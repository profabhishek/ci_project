<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Data access for the new Admin Panel (controllers/Adminpanel.php).
 *
 * Simple rules this model follows:
 *  - Table and column names are never taken from the browser directly.
 *    They are checked against an allow-list and against the real columns
 *    of the table (SHOW FULL COLUMNS).
 *  - Values always go through CodeIgniter's query builder (escaped).
 *  - Every insert / update / status change writes rows to
 *    iccr_admin_audit_log (one row per changed column) in the same
 *    database transaction, so a failed save leaves nothing half-done.
 */
class Adminpanel_model extends CI_Model
{
    /** Tables the panel may read and change, and how to show them. */
    public $tables = array(
        'iccr_users' => array(
            'label'    => 'Login account',
            'hidden'   => array('password', 'normal_password'),
            'readonly' => array('id', 'created', 'user_type'),
        ),
        'iccr_student_details' => array(
            'label'    => 'Registration details',
            'hidden'   => array(),
            'readonly' => array('id', 'uid', 'created'),
        ),
        'iccr_student_application_details' => array(
            'label'    => 'Application form',
            'hidden'   => array(),
            'readonly' => array('id', 'application_no', 'uid'),
        ),
        'iccr_student_other_details' => array(
            'label'    => 'Other details (Mission link)',
            'hidden'   => array(),
            'readonly' => array('id', 'application_no', 'uid'),
        ),
        'iccr_status_mapping' => array(
            'label'    => 'Workflow status',
            'hidden'   => array(),
            'readonly' => array('id', 'application_no', 'uid'),
            'workflow' => TRUE,
        ),
        'iccr_missions' => array(
            'label'    => 'Mission',
            'hidden'   => array('password'),
            'readonly' => array('id', 'created'),
        ),
        'iccr_univercities' => array(
            'label'    => 'University',
            'hidden'   => array('password'),
            'readonly' => array('id'),
        ),
    );

    /** Column names that are never shown or edited, in any table. */
    private $secret_pattern = '/(^|_)(pass|password|passwd|pwd|token|otp|salt|secret)($|_)/i';

    private $column_cache = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* ==============================================================
       Setup checks
       ============================================================== */

    public function setup_status()
    {
        return array(
            'nav'      => $this->db->table_exists('iccr_nav_links'),
            'audit'    => $this->db->table_exists('iccr_admin_audit_log'),
            'general_audit' => $this->general_audit_ready(),
            'security' => $this->login_setup_ok() && $this->db->table_exists('iccr_admin_trash') && $this->db->field_exists('published_at', 'iccr_notifications'),
        );
    }

    /* ==============================================================
       Column metadata
       ============================================================== */

    /**
     * Real columns of an allowed table, keyed by name.
     * Each: name, type (lower), base (int|decimal|date|datetime|time|text|enum|string),
     * length, nullable, default, primary, auto, options (enum), comment.
     */
    public function columns($table)
    {
        if (!$this->is_allowed_table($table) && !in_array($table, array('iccr_nav_links', 'iccr_notifications'), TRUE)) {
            return array();
        }
        if (isset($this->column_cache[$table])) {
            return $this->column_cache[$table];
        }
        if (!$this->db->table_exists($table)) {
            return $this->column_cache[$table] = array();
        }
        $rows = $this->db->query('SHOW FULL COLUMNS FROM ' . $this->db->protect_identifiers($table, TRUE))->result_array();
        $cols = array();
        foreach ($rows as $r) {
            $type = strtolower($r['Type']);
            $base = 'string';
            $length = NULL;
            $options = array();
            if (preg_match('/^(tinyint|smallint|mediumint|int|integer|bigint)/', $type)) {
                $base = 'int';
            } elseif (preg_match('/^(decimal|float|double|numeric)/', $type)) {
                $base = 'decimal';
            } elseif ($type === 'date') {
                $base = 'date';
            } elseif (preg_match('/^(datetime|timestamp)/', $type)) {
                $base = 'datetime';
            } elseif ($type === 'time') {
                $base = 'time';
            } elseif (preg_match('/text|blob/', $type)) {
                $base = 'text';
            } elseif (preg_match("/^enum\((.*)\)$/", $type, $m)) {
                $base = 'enum';
                preg_match_all("/'((?:[^'\\\\]|\\\\.|'')*)'/", $m[1], $mm);
                $options = $mm[1];
            }
            if (preg_match('/\((\d+)\)/', $type, $lm)) {
                $length = (int) $lm[1];
            }
            $cols[$r['Field']] = array(
                'name'     => $r['Field'],
                'type'     => $type,
                'base'     => $base,
                'length'   => $length,
                'nullable' => ($r['Null'] === 'YES'),
                'default'  => $r['Default'],
                'primary'  => ($r['Key'] === 'PRI'),
                'auto'     => (stripos($r['Extra'], 'auto_increment') !== FALSE),
                'options'  => $options,
                'comment'  => $r['Comment'],
            );
        }
        return $this->column_cache[$table] = $cols;
    }

    public function is_allowed_table($table)
    {
        return is_string($table) && isset($this->tables[$table]);
    }

    public function primary_key($table)
    {
        foreach ($this->columns($table) as $c) {
            if ($c['primary']) {
                return $c['name'];
            }
        }
        return isset($this->columns($table)['id']) ? 'id' : NULL;
    }

    public function is_secret_column($table, $col)
    {
        $hidden = isset($this->tables[$table]) ? $this->tables[$table]['hidden'] : array();
        return in_array($col, $hidden, TRUE) || preg_match($this->secret_pattern, $col);
    }

    /** Columns that may be shown (not secret). */
    public function visible_columns($table)
    {
        $out = array();
        foreach ($this->columns($table) as $name => $c) {
            if (!$this->is_secret_column($table, $name)) {
                $out[$name] = $c;
            }
        }
        return $out;
    }

    /** Columns that may be changed by the admin. */
    public function editable_columns($table, $extra_readonly = array())
    {
        $ro = isset($this->tables[$table]) ? $this->tables[$table]['readonly'] : array();
        $ro = array_merge($ro, $extra_readonly);
        $out = array();
        foreach ($this->visible_columns($table) as $name => $c) {
            if ($c['primary'] || $c['auto'] || in_array($name, $ro, TRUE)) {
                continue;
            }
            $out[$name] = $c;
        }
        return $out;
    }

    /* ==============================================================
       Generic read / save with audit
       ============================================================== */

    public function get_row($table, $id)
    {
        $pk = $this->primary_key($table);
        if (!$pk) {
            return NULL;
        }
        $row = $this->db->get_where($table, array($pk => $id), 1)->row_array();
        return $row ? $row : NULL;
    }

    /**
     * Turn raw POST values into DB values for the given columns.
     * Returns array(values, errors). Only columns present in $input are used.
     */
    public function clean_values($table, $input, $old_row = NULL, $extra_readonly = array())
    {
        $values = array();
        $errors = array();
        foreach ($this->editable_columns($table, $extra_readonly) as $name => $c) {
            if (!array_key_exists($name, $input)) {
                continue;
            }
            $raw = $input[$name];
            if (is_array($raw)) {
                $errors[$name] = 'Invalid value.';
                continue;
            }
            $raw = trim((string) $raw);
            $old = $old_row !== NULL && array_key_exists($name, $old_row) ? $old_row[$name] : NULL;

            if ($raw === '') {
                if ($c['nullable'] && ($old === NULL || $old_row === NULL || in_array($c['base'], array('int', 'decimal', 'date', 'datetime', 'time'), TRUE))) {
                    $values[$name] = NULL;
                } elseif (in_array($c['base'], array('int', 'decimal'), TRUE)) {
                    if ($old_row === NULL && $c['default'] !== NULL) {
                        continue; // let the DB default apply on insert
                    }
                    $errors[$name] = 'A number is required.';
                } elseif (in_array($c['base'], array('date', 'datetime', 'time'), TRUE) && !$c['nullable']) {
                    $values[$name] = ($old_row !== NULL && $old !== NULL) ? $old : NULL;
                    if ($values[$name] === NULL) { unset($values[$name]); }
                } else {
                    $values[$name] = '';
                }
                continue;
            }

            switch ($c['base']) {
                case 'int':
                    if (!preg_match('/^-?\d+$/', $raw)) { $errors[$name] = 'Whole number only.'; continue 2; }
                    break;
                case 'decimal':
                    if (!is_numeric($raw)) { $errors[$name] = 'Number only.'; continue 2; }
                    break;
                case 'date':
                    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) { $errors[$name] = 'Use YYYY-MM-DD.'; continue 2; }
                    break;
                case 'enum':
                    if (!in_array($raw, $c['options'], TRUE)) { $errors[$name] = 'Choose one of the listed values.'; continue 2; }
                    break;
                default:
                    if ($c['length'] && mb_strlen($raw) > $c['length']) { $errors[$name] = 'Too long (max ' . $c['length'] . ').'; continue 2; }
            }
            $values[$name] = $raw;
        }
        return array($values, $errors);
    }

    /** Only the values that differ from the current row. */
    public function diff($old_row, $values)
    {
        $changed = array();
        foreach ($values as $k => $v) {
            $o = array_key_exists($k, $old_row) ? $old_row[$k] : NULL;
            if ($o === NULL && $v === NULL) { continue; }
            if ($o !== NULL && $v !== NULL && (string) $o === (string) $v) { continue; }
            $changed[$k] = $v;
        }
        return $changed;
    }

    /**
     * Update one row by primary key and audit each changed column.
     * Returns number of changed columns, or FALSE on DB error.
     */
    public function update_row($table, $id, $values, $admin, $note = '')
    {
        $pk = $this->primary_key($table);
        $old = $this->get_row($table, $id);
        if (!$pk || !$old) {
            return FALSE;
        }
        $changed = $this->diff($old, $values);
        if (empty($changed)) {
            return 0;
        }
        $this->db->trans_start();
        $this->set_db_remarks($note);
        $this->db->where($pk, $id)->limit(1)->update($table, $changed);
        foreach ($changed as $col => $new) {
            $this->audit($admin, 'update', $table, $id, $col, $old[$col], $new, $note);
        }
        $this->db->trans_complete();
        return $this->db->trans_status() ? count($changed) : FALSE;
    }

    /** Insert a row (after filling required columns) and audit it. Returns new id or FALSE. */
    public function insert_row($table, $values, $admin, $note = '')
    {
        $values = $this->fill_required($table, $values);
        $this->db->trans_start();
        $this->set_db_remarks($note);
        $this->db->insert($table, $values);
        $id = $this->db->insert_id();
        $this->audit($admin, 'insert', $table, $id, '', NULL, json_encode($this->strip_secrets($table, $values)), $note);
        $this->db->trans_complete();
        return $this->db->trans_status() ? $id : FALSE;
    }

    /** NOT NULL columns with no default get an empty value so strict SQL mode does not reject the insert. */
    public function fill_required($table, $values)
    {
        foreach ($this->columns($table) as $name => $c) {
            if ($c['auto'] || array_key_exists($name, $values) || $c['nullable'] || $c['default'] !== NULL) {
                continue;
            }
            switch ($c['base']) {
                case 'int': case 'decimal': $values[$name] = 0; break;
                case 'date':     $values[$name] = date('Y-m-d'); break;
                case 'datetime': $values[$name] = date('Y-m-d H:i:s'); break;
                case 'time':     $values[$name] = '00:00:00'; break;
                case 'enum':     $values[$name] = isset($c['options'][0]) ? $c['options'][0] : ''; break;
                default:         $values[$name] = '';
            }
        }
        return $values;
    }

    private function strip_secrets($table, $values)
    {
        foreach ($values as $k => $v) {
            if ($this->is_secret_column($table, $k) || preg_match($this->secret_pattern, $k)) {
                $values[$k] = '[hidden]';
            }
        }
        return $values;
    }

    public function audit($admin, $action, $table, $record_id, $column, $old, $new, $note = '')
    {
        // 1) General audit log (audit_log) - the portal-wide "who changed what" table
        $this->general_audit($admin, $action, $table, $record_id, $column, $old, $new, $note);

        // 2) Admin Panel audit log (iccr_admin_audit_log)
        if (!$this->db->table_exists('iccr_admin_audit_log')) {
            return;
        }
        // Any change makes cached numbers / menus stale
        $this->cache_delete('dashboard_counts');
        if ($table === 'iccr_nav_links') { $this->cache_delete('nav_rows'); }
        if ($table === 'iccr_users') { $this->cache_delete('students_total_0'); }
        if (preg_match($this->secret_pattern, (string) $column)) {
            $old = $old === NULL ? NULL : '[hidden]';
            $new = $new === NULL ? NULL : '[hidden]';
        }
        $this->db->insert('iccr_admin_audit_log', array(
            'admin_id'    => (int) $admin['userid'],
            'admin_email' => (string) $admin['email'],
            'action'      => $action,
            'table_name'  => $table,
            'record_id'   => (string) $record_id,
            'column_name' => (string) $column,
            'old_value'   => $old === NULL ? NULL : (string) $old,
            'new_value'   => $new === NULL ? NULL : (string) $new,
            'note'        => mb_substr((string) $note, 0, 255),
            'ip_address'  => (string) $this->input->ip_address(),
            'created_at'  => date('Y-m-d H:i:s'),
        ));
    }

    /* ==============================================================
       General audit log (table: audit_log)
       --------------------------------------------------------------
       audit_log is the portal-wide change log (see
       sql/general_audit_log_setup.sql). It is also filled by database
       triggers on some tables. To avoid two rows for one change:
         - set_db_identity() puts the admin's name/role in MySQL session
           variables, so a trigger records the real admin, not UNKNOWN;
         - general_audit() writes a row itself ONLY when no audit
           trigger exists for that table + action.
       It never stores an IP address, and hides password-type values.
       ============================================================== */

    private $ga_ready = NULL;
    private $ga_fields = array();
    private $ga_triggers = NULL;
    private $ga_app_cache = array();
    private $ga_conn = NULL;

    /**
     * Separate DB connection for audit_log, with errors switched off.
     * The Admin Panel saves inside a transaction; if writing to audit_log
     * failed on the main connection (table missing, no INSERT right on the
     * live server, different layout) it would cancel the admin's real
     * change. On its own connection a problem here can never block a save;
     * it is only written to the CodeIgniter error log.
     */
    private function ga_db()
    {
        if ($this->ga_conn === NULL) {
            $this->ga_conn = $this->load->database('', TRUE);
            $this->ga_conn->db_debug = FALSE;
            // config/database.php sets dbprefix 'iccr_'; audit_log has no prefix
            $this->ga_conn->dbprefix = '';
        }
        return $this->ga_conn;
    }

    /** Role names for iccr_users.user_type, as shown in audit_log.user_role. */
    public $role_names = array(1 => 'Student', 2 => 'Mission', 3 => 'ICCR (HQ)', 4 => 'Regional Office', 5 => 'Super Admin', 7 => 'Agency', 8 => 'University');

    public function general_audit_ready()
    {
        if ($this->ga_ready === NULL) {
            $ga = $this->ga_db();
            try {
                $q = $ga->query("SHOW TABLES LIKE 'audit_log'");
                $this->ga_ready = ($q && $q->num_rows() > 0);
                if ($this->ga_ready) {
                    $this->ga_fields = array_flip($ga->list_fields('audit_log'));
                }
            } catch (Exception $e) {
                $this->ga_ready = FALSE;
            }
        }
        return $this->ga_ready;
    }

    private function admin_role($admin)
    {
        $t = isset($admin['user_type']) ? (int) $admin['user_type'] : 5;
        return (isset($this->role_names[$t]) ? $this->role_names[$t] : 'User type ' . $t) . ' (Admin Panel)';
    }

    /** Tell the database who is making changes (used by the audit triggers). Call once per request. */
    public function set_db_identity($admin)
    {
        $this->db->query('SET @audit_user_id = ?, @audit_user_name = ?, @audit_user_role = ?, @audit_remarks = ?', array(
            (string) $admin['userid'],
            mb_substr(trim((string) $admin['fname'] . ' <' . (string) $admin['email'] . '>'), 0, 100),
            mb_substr($this->admin_role($admin), 0, 50),
            'Admin Panel',
        ));
    }

    /** Reason text the triggers copy into audit_log.remarks for the next change. */
    public function set_db_remarks($note)
    {
        $note = trim((string) $note);
        $this->db->query('SET @audit_remarks = ?', array(mb_substr('Admin Panel' . ($note !== '' ? ': ' . $note : ''), 0, 500)));
    }

    /** INSERT / UPDATE / DELETE: what really happened in SQL for an Admin Panel action. */
    private function sql_event($action, $column)
    {
        if ($action === 'insert') { return 'INSERT'; }
        if ($action === 'delete' && (string) $column === '') { return 'DELETE'; } // hard delete (announcement / menu item)
        return 'UPDATE'; // update, status, publish, password, restore, soft delete (status = 0)
    }

    /** Audit triggers that already exist, as "table|EVENT" => TRUE. */
    private function audit_triggers()
    {
        if ($this->ga_triggers === NULL) {
            $this->ga_triggers = array();
            try {
                $q = $this->ga_db()->query("SELECT EVENT_OBJECT_TABLE AS t, EVENT_MANIPULATION AS e FROM information_schema.TRIGGERS
                                       WHERE TRIGGER_SCHEMA = DATABASE() AND ACTION_STATEMENT LIKE '%audit_log%'");
            } catch (Exception $e) {
                $q = FALSE; // PHP 8: database errors are exceptions
            }
            if ($q) {
                foreach ($q->result_array() as $r) { $this->ga_triggers[$r['t'] . '|' . strtoupper($r['e'])] = TRUE; }
            }
        }
        return $this->ga_triggers;
    }

    /** Application number linked to a record, so the daily report can group by application. */
    private function application_no_for($table, $record_id)
    {
        $key = $table . '|' . $record_id;
        if (array_key_exists($key, $this->ga_app_cache)) {
            return $this->ga_app_cache[$key];
        }
        $app = NULL;
        $uid = NULL;
        if (isset($this->tables[$table])) {
            $row = $this->get_row($table, $record_id);
            if ($row && !empty($row['application_no'])) {
                $app = $row['application_no'];
            } elseif ($table === 'iccr_users') {
                $uid = (int) $record_id;
            } elseif ($row && !empty($row['uid'])) {
                $uid = (int) $row['uid'];
            }
        }
        if ($app === NULL && $uid) {
            $r = $this->db->select('application_no')->where('uid', $uid)->order_by('id', 'DESC')->limit(1)->get('iccr_status_mapping')->row_array();
            $app = $r ? $r['application_no'] : NULL;
        }
        return $this->ga_app_cache[$key] = $app;
    }

    public function general_audit($admin, $action, $table, $record_id, $column, $old, $new, $note = '')
    {
        if (!$this->general_audit_ready()) {
            return;
        }
        if (in_array($action, array('login', 'logout'), TRUE)) {
            return; // sign-ins are in the Admin Panel log and "Sign-in attempts"; audit_log is for data changes
        }
        $event = $this->sql_event($action, $column);
        $triggers = $this->audit_triggers();
        if (isset($triggers[$table . '|' . $event])) {
            return; // the database trigger has already written this change (with the admin's name)
        }
        if (preg_match($this->secret_pattern, (string) $column)) {
            $old = $old === NULL ? NULL : '[hidden]';
            $new = $new === NULL ? NULL : '[hidden]';
        }
        $app = $this->application_no_for($table, $record_id);
        $remarks = 'Admin Panel: ' . $action . ($note !== '' ? ' - ' . $note : '');
        $row = array(
            'changed_at'     => date('Y-m-d H:i:s'),
            'table_name'     => $table,
            'record_id'      => (string) $record_id,
            'application_id' => $app,
            'application_no' => $app === NULL ? '' : $app, // older audit_log layout
            'action'         => $event,
            'field_name'     => (string) $column === '' ? NULL : (string) $column,
            'old_value'      => $old === NULL ? NULL : (string) $old,
            'new_value'      => $new === NULL ? NULL : (string) $new,
            'user_id'        => (string) $admin['userid'],
            'user_name'      => mb_substr(trim((isset($admin['fname']) ? $admin['fname'] : '') . ' <' . (string) $admin['email'] . '>'), 0, 100),
            'user_role'      => mb_substr($this->admin_role($admin), 0, 50),
            'remarks'        => mb_substr($remarks, 0, 500),
        );
        // Write only the columns this database's audit_log actually has
        $ga = $this->ga_db();
        try {
            $done = $ga->insert('audit_log', array_intersect_key($row, $this->ga_fields));
            $err = $ga->error();
            $msg = $err['message'];
        } catch (Exception $e) {
            $done = FALSE; // PHP 8: database errors are exceptions; never let them stop the admin's save
            $msg = $e->getMessage();
        }
        if (!$done) {
            log_message('error', 'General audit_log write failed (' . $table . ' #' . $record_id . '): ' . $msg);
        }
    }

    /** General audit log screen: every change in audit_log (Admin Panel, triggers, other screens). */
    public function general_audit_list($f, $limit, $offset)
    {
        if (!$this->general_audit_ready()) {
            return array(array(), 0);
        }
        $fields = $this->ga_fields;
        $app_col = isset($fields['application_id']) ? 'application_id' : (isset($fields['application_no']) ? 'application_no' : NULL);
        $db = $this->ga_db();
        $apply = function ($db) use ($f, $app_col) {
            if ($f['table'] !== '') { $db->where('table_name', $f['table']); }
            if ($f['app'] !== '' && $app_col) { $db->where($app_col, $f['app']); }
            if ($f['action'] !== '') { $db->where('action', $f['action']); }
            if ($f['from'] !== '') { $db->where('changed_at >=', $f['from'] . ' 00:00:00'); }
            if ($f['to'] !== '') { $db->where('changed_at <=', $f['to'] . ' 23:59:59'); }
            if ($f['q'] !== '') {
                $db->group_start()->like('user_name', $f['q'])->or_like('field_name', $f['q'])->or_like('old_value', $f['q'])
                   ->or_like('new_value', $f['q'])->or_like('remarks', $f['q'])->group_end();
            }
        };
        $apply($db);
        $total = $db->count_all_results('audit_log');
        $apply($db);
        $q = $db->order_by('id', 'DESC')->limit($limit, $offset)->get('audit_log');
        $rows = $q ? $q->result_array() : array();
        foreach ($rows as &$r) {
            $r['app'] = $app_col ? $r[$app_col] : '';
            if (!isset($r['record_id'])) { $r['record_id'] = ''; }
        }
        return array($rows, $total);
    }

    /** Distinct table names in audit_log, for the filter. */
    public function general_audit_tables()
    {
        if (!$this->general_audit_ready()) {
            return array();
        }
        $q = $this->ga_db()->distinct()->select('table_name')->order_by('table_name')->get('audit_log');
        return $q ? array_column($q->result_array(), 'table_name') : array();
    }

    public function audit_list($filters, $limit, $offset)
    {
        if (!$this->db->table_exists('iccr_admin_audit_log')) {
            return array(array(), 0);
        }
        $apply = function ($db) use ($filters) {
            if (!empty($filters['table'])) { $db->where('table_name', $filters['table']); }
            if (!empty($filters['record'])) { $db->where('record_id', $filters['record']); }
            if (!empty($filters['q'])) {
                $db->group_start()->like('admin_email', $filters['q'])->or_like('column_name', $filters['q'])
                   ->or_like('old_value', $filters['q'])->or_like('new_value', $filters['q'])->group_end();
            }
        };
        $apply($this->db);
        $total = $this->db->count_all_results('iccr_admin_audit_log');
        $apply($this->db);
        $rows = $this->db->order_by('id', 'DESC')->limit($limit, $offset)->get('iccr_admin_audit_log')->result_array();
        return array($rows, $total);
    }

    public function recent_audit($n = 8)
    {
        if (!$this->db->table_exists('iccr_admin_audit_log')) {
            return array();
        }
        return $this->db->order_by('id', 'DESC')->limit($n)->get('iccr_admin_audit_log')->result_array();
    }

    /* ==============================================================
       Dashboard
       ============================================================== */

    public function counts()
    {
        $cached = $this->cache_get('dashboard_counts');
        if ($cached !== FALSE) {
            return $cached;
        }
        $c = array();
        $c['students']      = $this->db->where('user_type', 1)->count_all_results('iccr_users');
        $c['applications']  = $this->db->where('created >=', 1772150400)->where('created <=', 1798761599)->count_all_results('iccr_status_mapping');
        $c['missions']      = $this->db->count_all_results('iccr_missions');
        $c['universities']  = $this->db->count_all_results('iccr_univercities');
        $c['announcements'] = $this->db->where('validated_upto >=', date('Y-m-d'))->where("(status IS NULL OR status <> '0')", NULL, FALSE)->count_all_results('iccr_notifications');
        $c['trash']         = $this->trash_ready() ? $this->db->where('restored_at IS NULL', NULL, FALSE)->count_all_results('iccr_admin_trash') : 0;
        $c['admins']        = $this->db->where('user_type', 5)->count_all_results('iccr_users');
        $c['nav']           = $this->db->table_exists('iccr_nav_links') ? $this->db->count_all_results('iccr_nav_links') : 0;
        $this->cache_set('dashboard_counts', $c, 300); // refreshed every 5 minutes
        return $c;
    }

    /* ==============================================================
       Announcements (existing table iccr_notifications)
       ============================================================== */

    public function announcements()
    {
        return $this->db->order_by('id', 'DESC')->get('iccr_notifications')->result_array();
    }

    public function announcement($id)
    {
        return $this->db->get_where('iccr_notifications', array('id' => (int) $id), 1)->row_array();
    }

    public function save_announcement($id, $values, $admin)
    {
        if ($id) {
            $old = $this->announcement($id);
            if (!$old) { return FALSE; }
            $changed = $this->diff($old, $values);
            if (!$changed) { return 0; }
            $this->db->trans_start();
            $this->db->where('id', (int) $id)->limit(1)->update('iccr_notifications', $changed);
            foreach ($changed as $k => $v) {
                $this->audit($admin, 'update', 'iccr_notifications', $id, $k, $old[$k], $v);
            }
            $this->db->trans_complete();
            return $this->db->trans_status() ? $id : FALSE;
        }
        $this->db->trans_start();
        $this->db->insert('iccr_notifications', $values);
        $new_id = $this->db->insert_id();
        $this->audit($admin, 'insert', 'iccr_notifications', $new_id, '', NULL, json_encode($values));
        $this->db->trans_complete();
        return $this->db->trans_status() ? $new_id : FALSE;
    }

    /** Draft / live / hidden / expired, for the list and preview. */
    public function announcement_state($r, $today = NULL)
    {
        $today = $today ? $today : date('Y-m-d');
        $published = array_key_exists('published_at', $r) ? !empty($r['published_at']) : TRUE; // old rows had no draft step
        if ((string) $r['status'] !== '0') {
            return (!empty($r['validated_upto']) && $r['validated_upto'] < $today) ? 'expired' : 'live';
        }
        return $published ? 'hidden' : 'draft';
    }

    /** Put an announcement on the home page (after the preview was confirmed). */
    public function publish_announcement($id, $admin)
    {
        $row = $this->announcement($id);
        if (!$row) { return FALSE; }
        $values = array('status' => '1');
        if ($this->db->field_exists('published_at', 'iccr_notifications')) {
            $values['published_at'] = date('Y-m-d H:i:s');
            $values['published_by'] = (int) $admin['userid'];
        }
        $this->db->trans_start();
        $this->db->where('id', (int) $id)->limit(1)->update('iccr_notifications', $values);
        $this->audit($admin, 'publish', 'iccr_notifications', $id, 'status', $row['status'], '1', 'Published to the home page after preview');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /** Permanently remove an announcement. The full old row stays in the audit log. */
    public function delete_announcement($id, $admin)
    {
        $row = $this->announcement($id);
        if (!$row) { return FALSE; }
        $this->db->trans_start();
        $this->db->where('id', (int) $id)->limit(1)->delete('iccr_notifications');
        $this->audit($admin, 'delete', 'iccr_notifications', $id, '', json_encode($row), NULL, 'Announcement deleted');
        $this->db->trans_complete();
        return $this->db->trans_status() ? $row : FALSE;
    }

    /* ==============================================================
       Admin sign-in (controllers/Adminlogin.php)
       ============================================================== */

    public function login_setup_ok()
    {
        return $this->db->table_exists('iccr_admin_login_attempts');
    }

    /** Active Super Admin by email (with the stored password hash), or NULL. */
    public function super_admin_by_email($email)
    {
        $row = $this->db->get_where('iccr_users', array('email_id' => $email, 'user_type' => 5, 'status' => 1), 1)->row_array();
        if (!$row || $this->is_trashed('iccr_users', $row['id'])) { return NULL; }
        return $row;
    }

    /** Still an active, not-deleted Super Admin? Checked on every Admin Panel request. */
    public function active_super_admin($uid)
    {
        $row = $this->db->select('id, username, email_id, user_type, status, state, university, user_country, created, apply_course_type, student_type, dir')
                        ->get_where('iccr_users', array('id' => (int) $uid), 1)->row_array();
        if (!$row || (int) $row['user_type'] !== 5 || (string) $row['status'] !== '1' || $this->is_trashed('iccr_users', $uid)) {
            return NULL;
        }
        return $row;
    }

    public function login_log($email, $ip, $success, $reason, $uid = NULL)
    {
        if (!$this->login_setup_ok()) { return; }
        $this->db->insert('iccr_admin_login_attempts', array(
            'email'      => mb_substr((string) $email, 0, 150),
            'ip_address' => mb_substr((string) $ip, 0, 45),
            'user_id'    => $uid,
            'success'    => $success ? 1 : 0,
            'reason'     => mb_substr((string) $reason, 0, 40),
            'user_agent' => mb_substr((string) $this->input->user_agent(), 0, 255),
            'created_at' => date('Y-m-d H:i:s'),
        ));
    }

    /** Failed tries for this email OR this IP in the last $window seconds (since the last success for that email). */
    public function login_fail_count($email, $ip, $window)
    {
        if (!$this->login_setup_ok()) { return 0; }
        $since = date('Y-m-d H:i:s', time() - $window);
        $by = function ($col, $val) use ($since) {
            $last_ok = $this->db->select_max('created_at')->where(array($col => $val, 'success' => 1))->get('iccr_admin_login_attempts')->row_array();
            $from = (!empty($last_ok['created_at']) && $last_ok['created_at'] > $since) ? $last_ok['created_at'] : $since;
            return $this->db->where(array($col => $val, 'success' => 0, 'created_at >' => $from))
                            ->where('reason !=', 'locked')->count_all_results('iccr_admin_login_attempts');
        };
        return max($email !== '' ? $by('email', $email) : 0, $by('ip_address', $ip));
    }

    /** Seconds until sign-in is allowed again (0 = allowed). */
    public function login_lock_seconds($email, $ip, $max, $window)
    {
        if ($this->login_fail_count($email, $ip, $window) < $max) { return 0; }
        $since = date('Y-m-d H:i:s', time() - $window);
        $last = $this->db->select_max('created_at')
                         ->group_start()->where('email', $email)->or_where('ip_address', $ip)->group_end()
                         ->where(array('success' => 0, 'created_at >' => $since))->where('reason !=', 'locked')
                         ->get('iccr_admin_login_attempts')->row_array();
        if (empty($last['created_at'])) { return 0; }
        return max(0, strtotime($last['created_at']) + $window - time());
    }

    public function login_history($limit = 50)
    {
        if (!$this->login_setup_ok()) { return array(); }
        return $this->db->order_by('id', 'DESC')->limit($limit)->get('iccr_admin_login_attempts')->result_array();
    }

    /* ==============================================================
       Trash (soft delete) - iccr_admin_trash
       A deleted record is switched off (status = 0, so it cannot log in
       or be picked in lists) and noted here with its old status, so
       Restore can put it back exactly. Nothing is removed from the
       scholarship tables.
       ============================================================== */

    public $trash_tables = array(
        'iccr_users'        => 'Login / student',
        'iccr_missions'     => 'Mission',
        'iccr_univercities' => 'University',
    );

    public function trash_ready()
    {
        return $this->db->table_exists('iccr_admin_trash');
    }

    public function is_trashed($table, $id)
    {
        if (!$this->trash_ready()) { return FALSE; }
        return $this->db->where(array('table_name' => $table, 'record_id' => (string) $id))->where('restored_at IS NULL', NULL, FALSE)
                        ->count_all_results('iccr_admin_trash') > 0;
    }

    /** SQL fragment: "<col> NOT IN (ids in trash for $table)". Empty string when trash is not set up. */
    public function not_trashed_sql($table, $col)
    {
        if (!$this->trash_ready()) { return ''; }
        return $col . ' NOT IN (SELECT CAST(t.record_id AS UNSIGNED) FROM iccr_admin_trash t WHERE t.table_name = '
             . $this->db->escape($table) . ' AND t.restored_at IS NULL)';
    }

    /** Soft delete. Returns TRUE, or an error message string. */
    public function trash($table, $id, $label, $reason, $admin)
    {
        if (!isset($this->trash_tables[$table])) { return 'This kind of record cannot be deleted here.'; }
        if (!$this->trash_ready()) { return 'Run application/sql/adminpanel_security_local.sql first (Trash table missing).'; }
        $row = $this->get_row($table, $id);
        if (!$row) { return 'Record not found.'; }
        if ($this->is_trashed($table, $id)) { return 'It is already in Trash.'; }
        $has_status = array_key_exists('status', $row);
        $this->db->trans_start();
        $this->db->insert('iccr_admin_trash', array(
            'table_name'   => $table,
            'record_id'    => (string) $id,
            'label'        => mb_substr((string) $label, 0, 255),
            'prev_status'  => $has_status ? $row['status'] : NULL,
            'reason'       => mb_substr((string) $reason, 0, 255),
            'deleted_by'   => (int) $admin['userid'],
            'deleted_email'=> (string) $admin['email'],
            'deleted_at'   => date('Y-m-d H:i:s'),
        ));
        if ($has_status && (string) $row['status'] !== '0') {
            $this->db->where($this->primary_key($table), $id)->limit(1)->update($table, array('status' => 0));
        }
        $this->audit($admin, 'delete', $table, $id, 'status', $has_status ? $row['status'] : NULL, $has_status ? '0' : NULL, 'Moved to Trash: ' . $reason);
        $this->db->trans_complete();
        if ($table === 'iccr_users') { $this->cache_delete('ap_students_total_0'); }
        return $this->db->trans_status() ? TRUE : 'Database error. Nothing changed.';
    }

    public function trash_list($table = '')
    {
        if (!$this->trash_ready()) { return array(); }
        if ($table !== '') { $this->db->where('table_name', $table); }
        return $this->db->where('restored_at IS NULL', NULL, FALSE)->order_by('id', 'DESC')->get('iccr_admin_trash')->result_array();
    }

    public function trash_entry($trash_id)
    {
        if (!$this->trash_ready()) { return NULL; }
        return $this->db->get_where('iccr_admin_trash', array('id' => (int) $trash_id), 1)->row_array();
    }

    /** Restore: put the old status back and close the trash entry. */
    public function restore($trash_id, $admin)
    {
        $t = $this->trash_entry($trash_id);
        if (!$t || $t['restored_at'] !== NULL) { return FALSE; }
        $row = $this->get_row($t['table_name'], $t['record_id']);
        $this->db->trans_start();
        if ($row && array_key_exists('status', $row) && $t['prev_status'] !== NULL && (string) $row['status'] !== (string) $t['prev_status']) {
            $this->db->where($this->primary_key($t['table_name']), $t['record_id'])->limit(1)->update($t['table_name'], array('status' => $t['prev_status']));
        }
        $this->db->where('id', (int) $trash_id)->update('iccr_admin_trash', array('restored_at' => date('Y-m-d H:i:s'), 'restored_by' => (int) $admin['userid']));
        $this->audit($admin, 'restore', $t['table_name'], $t['record_id'], 'status', $row ? $row['status'] : NULL, $t['prev_status'], 'Restored from Trash');
        $this->db->trans_complete();
        if ($t['table_name'] === 'iccr_users') { $this->cache_delete('ap_students_total_0'); }
        return $this->db->trans_status() ? $t : FALSE;
    }

    public function active_super_admin_count()
    {
        $this->db->where(array('user_type' => 5, 'status' => 1));
        if ($sql = $this->not_trashed_sql('iccr_users', 'id')) { $this->db->where($sql, NULL, FALSE); }
        return $this->db->count_all_results('iccr_users');
    }

    /* ==============================================================
       Navigation links
       ============================================================== */

    public function nav_all()
    {
        if (!$this->db->table_exists('iccr_nav_links')) {
            return array();
        }
        return $this->db->order_by('position', 'ASC')->order_by('sort_order', 'ASC')->order_by('id', 'ASC')
                        ->get('iccr_nav_links')->result_array();
    }

    /** Flat list in tree order with a "depth" key, for tables and parent pickers. */
    public function nav_tree_flat($exclude_id = NULL)
    {
        $all = $this->nav_all();
        $by_parent = array();
        foreach ($all as $r) {
            $by_parent[(int) $r['parent_id']][] = $r;
        }
        $out = array();
        $walk = function ($parent, $depth) use (&$walk, &$out, $by_parent, $exclude_id) {
            if (empty($by_parent[$parent])) { return; }
            foreach ($by_parent[$parent] as $r) {
                if ($exclude_id !== NULL && (int) $r['id'] === (int) $exclude_id) { continue; }
                $r['depth'] = $depth;
                $r['child_count'] = isset($by_parent[(int) $r['id']]) ? count($by_parent[(int) $r['id']]) : 0;
                $out[] = $r;
                $walk((int) $r['id'], $depth + 1);
            }
        };
        $walk(0, 0);
        return $out;
    }

    public function nav_get($id)
    {
        return $this->db->get_where('iccr_nav_links', array('id' => (int) $id), 1)->row_array();
    }

    /** IDs of a link and everything under it (to stop a link becoming its own child). */
    public function nav_descendants($id)
    {
        $ids = array((int) $id);
        $all = $this->nav_all();
        $added = TRUE;
        while ($added) {
            $added = FALSE;
            foreach ($all as $r) {
                if ($r['parent_id'] !== NULL && in_array((int) $r['parent_id'], $ids, TRUE) && !in_array((int) $r['id'], $ids, TRUE)) {
                    $ids[] = (int) $r['id'];
                    $added = TRUE;
                }
            }
        }
        return $ids;
    }

    public function nav_depth($id)
    {
        $depth = 0;
        $guard = 0;
        $row = $this->nav_get($id);
        while ($row && $row['parent_id'] !== NULL && $guard++ < 10) {
            $depth++;
            $row = $this->nav_get($row['parent_id']);
        }
        return $depth;
    }

    public function nav_save($id, $values, $admin)
    {
        $values['updated_at'] = date('Y-m-d H:i:s');
        if ($id) {
            $old = $this->nav_get($id);
            if (!$old) { return FALSE; }
            $changed = $this->diff($old, $values);
            unset($changed['updated_at']);
            if (!$changed) { return $id; }
            $changed['updated_at'] = $values['updated_at'];
            $this->db->trans_start();
            $this->db->where('id', (int) $id)->limit(1)->update('iccr_nav_links', $changed);
            foreach ($changed as $k => $v) {
                if ($k !== 'updated_at') { $this->audit($admin, 'update', 'iccr_nav_links', $id, $k, $old[$k], $v); }
            }
            $this->db->trans_complete();
            return $this->db->trans_status() ? $id : FALSE;
        }
        $this->db->trans_start();
        $this->db->insert('iccr_nav_links', $values);
        $new_id = $this->db->insert_id();
        $this->audit($admin, 'insert', 'iccr_nav_links', $new_id, '', NULL, json_encode($values));
        $this->db->trans_complete();
        return $this->db->trans_status() ? $new_id : FALSE;
    }

    /** Move a link one place up/down among its siblings (re-numbers siblings 10, 20, 30...). */
    public function nav_move($id, $dir, $admin)
    {
        $row = $this->nav_get($id);
        if (!$row) { return FALSE; }
        $q = $this->db->where('position', $row['position']);
        if ($row['parent_id'] === NULL) { $q->where('parent_id IS NULL', NULL, FALSE); } else { $q->where('parent_id', $row['parent_id']); }
        $sibs = $q->order_by('sort_order', 'ASC')->order_by('id', 'ASC')->get('iccr_nav_links')->result_array();
        $ids = array_map(function ($r) { return (int) $r['id']; }, $sibs);
        $i = array_search((int) $id, $ids, TRUE);
        $j = $dir === 'up' ? $i - 1 : $i + 1;
        if ($i === FALSE || $j < 0 || $j >= count($ids)) { return TRUE; }
        $tmp = $ids[$i]; $ids[$i] = $ids[$j]; $ids[$j] = $tmp;
        $this->db->trans_start();
        foreach ($ids as $n => $sid) {
            $this->db->where('id', $sid)->update('iccr_nav_links', array('sort_order' => ($n + 1) * 10));
        }
        $this->audit($admin, 'update', 'iccr_nav_links', $id, 'sort_order', $row['sort_order'], 'moved ' . $dir);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function nav_delete($id, $admin)
    {
        $row = $this->nav_get($id);
        if (!$row) { return FALSE; }
        if ($this->db->where('parent_id', (int) $id)->count_all_results('iccr_nav_links') > 0) {
            return 'has_children';
        }
        $this->db->trans_start();
        $this->db->where('id', (int) $id)->limit(1)->delete('iccr_nav_links');
        $this->audit($admin, 'delete', 'iccr_nav_links', $id, '', json_encode($row), NULL);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /* ==============================================================
       Students
       ============================================================== */

    /**
     * Student accounts (iccr_users.user_type = 1) with their latest application.
     *
     * Built for big tables (2 lakh+ rows):
     *  1. Find the 25 user IDs for this page using index-friendly filters only
     *     (exact or "starts with" matches - never LIKE '%...%' on the whole table).
     *  2. Load the extra columns (country, passport, latest application) for
     *     just those 25 IDs.
     * The unfiltered total is cached for 5 minutes.
     */
    public function students($q, $year, $limit, $offset)
    {
        $q = trim((string) $q);
        $apply = function () use ($q, $year) {
            $this->db->from('iccr_users u');
            $this->db->where('u.user_type', 1);
            if ($nt = $this->not_trashed_sql('iccr_users', 'u.id')) { $this->db->where($nt, NULL, FALSE); }
            if ($year) {
                $this->db->where('u.created >=', (int) $year . '-01-01 00:00:00');
                $this->db->where('u.created <', ((int) $year + 1) . '-01-01 00:00:00');
            }
            if ($q === '') { return; }
            $pre = $this->db->escape_like_str($q);
            if (preg_match('/^[A-Za-z]{2}\d{6,}$/', $q)) {
                // Application number: exact match via iccr_status_mapping
                $this->db->where('u.id IN (SELECT sm.uid FROM iccr_status_mapping sm WHERE sm.application_no = ' . $this->db->escape(strtoupper($q)) . ')', NULL, FALSE);
            } elseif (strpos($q, '@') !== FALSE) {
                $this->db->where("u.email_id LIKE '{$pre}%' ESCAPE '!'", NULL, FALSE);
            } elseif (ctype_digit($q)) {
                $this->db->group_start()->where('u.id', (int) $q)
                         ->or_where("u.mobile_no LIKE '{$pre}%' ESCAPE '!'", NULL, FALSE)
                         ->or_where("u.id IN (SELECT d.uid FROM iccr_student_details d WHERE d.passport_no LIKE '{$pre}%' ESCAPE '!')", NULL, FALSE)
                         ->group_end();
            } else {
                $words = preg_split('/\s+/', $q);
                $first = $this->db->escape_like_str($words[0]);
                $this->db->group_start();
                if (count($words) > 1) {
                    $last = $this->db->escape_like_str(end($words));
                    $this->db->where("(u.username LIKE '{$first}%' ESCAPE '!' AND (u.student_lname LIKE '{$last}%' ESCAPE '!' OR u.student_mname LIKE '{$last}%' ESCAPE '!'))", NULL, FALSE);
                } else {
                    $this->db->where("u.username LIKE '{$first}%' ESCAPE '!'", NULL, FALSE)
                             ->or_where("u.student_lname LIKE '{$first}%' ESCAPE '!'", NULL, FALSE)
                             ->or_where("u.email_id LIKE '{$first}%' ESCAPE '!'", NULL, FALSE)
                             ->or_where("u.id IN (SELECT d.uid FROM iccr_student_details d WHERE d.passport_no LIKE '{$first}%' ESCAPE '!')", NULL, FALSE);
                }
                $this->db->group_end();
            }
        };

        // Total
        $cache_key = 'ap_students_total_' . (int) $year;
        $total = ($q === '') ? $this->cache_get($cache_key) : FALSE;
        if ($total === FALSE) {
            $apply();
            $total = (int) $this->db->count_all_results();
            if ($q === '') { $this->cache_set($cache_key, $total, 300); }
        }

        // IDs for this page
        $apply();
        $ids = array_map('intval', array_column($this->db->select('u.id')->order_by('u.id', 'DESC')->limit($limit, $offset)->get()->result_array(), 'id'));
        if (!$ids) {
            return array(array(), $total);
        }

        // Details for just these IDs
        $in = implode(',', $ids);
        $rows = $this->db->query(
            "SELECT u.id, u.username, u.student_mname, u.student_lname, u.email_id, u.status AS account_status, u.created, u.user_country,
                    c.country_name,
                    (SELECT d.passport_no FROM iccr_student_details d WHERE d.uid = u.id ORDER BY d.id DESC LIMIT 1) AS passport_no,
                    (SELECT sm.application_no FROM iccr_status_mapping sm WHERE sm.uid = u.id ORDER BY sm.id DESC LIMIT 1) AS application_no,
                    (SELECT sm.status FROM iccr_status_mapping sm WHERE sm.uid = u.id ORDER BY sm.id DESC LIMIT 1) AS app_status
             FROM iccr_users u
             LEFT JOIN iccr_countries c ON c.id = u.user_country
             WHERE u.id IN ($in)
             ORDER BY u.id DESC"
        )->result_array();
        return array($rows, $total);
    }

    /* Small file cache (application/cache). Falls back to no cache if the folder is not writable. */
    private $cache_ready = NULL;

    private function cache_on()
    {
        if ($this->cache_ready === NULL) {
            $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));
            $this->cache_ready = TRUE;
        }
        return $this->cache_ready;
    }

    public function cache_get($key)
    {
        $this->cache_on();
        $v = $this->cache->get('a2a_' . $key);
        return $v === FALSE || $v === NULL ? FALSE : $v;
    }

    public function cache_set($key, $value, $ttl)
    {
        $this->cache_on();
        @$this->cache->save('a2a_' . $key, $value, $ttl);
    }

    public function cache_delete($key)
    {
        $this->cache_on();
        @$this->cache->delete('a2a_' . $key);
    }

    public function student($uid)
    {
        $user = $this->db->get_where('iccr_users', array('id' => (int) $uid, 'user_type' => 1), 1)->row_array();
        if (!$user) { return NULL; }
        $data = array('user' => $user);
        $data['details'] = $this->db->get_where('iccr_student_details', array('uid' => (int) $uid))->result_array();
        $apps = $this->db->order_by('id', 'DESC')->get_where('iccr_status_mapping', array('uid' => (int) $uid))->result_array();
        $data['applications'] = array();
        foreach ($apps as $sm) {
            $no = $sm['application_no'];
            $data['applications'][] = array(
                'status_mapping' => $sm,
                'application'    => $this->db->get_where('iccr_student_application_details', array('application_no' => $no), 1)->row_array(),
                'other'          => $this->db->get_where('iccr_student_other_details', array('application_no' => $no), 1)->row_array(),
                'responses'      => $this->db->order_by('id', 'ASC')->get_where('iccr_university_response', array('application_id' => $no))->result_array(),
            );
        }
        return $data;
    }

    public function email_exists($email, $except_id = NULL)
    {
        $this->db->where('email_id', $email);
        if ($except_id) { $this->db->where('id !=', (int) $except_id); }
        return $this->db->count_all_results('iccr_users') > 0;
    }

    public function countries()
    {
        if (!$this->db->table_exists('iccr_countries')) { return array(); }
        return $this->db->select('id, country_name')->order_by('country_name', 'ASC')->get('iccr_countries')->result_array();
    }

    /** Create a student login + registration row, like User::register does. */
    public function create_student($acc, $det, $admin)
    {
        $this->db->trans_start();
        $user = $this->fill_required('iccr_users', $acc);
        $this->db->insert('iccr_users', $user);
        $uid = $this->db->insert_id();
        $det['uid'] = $uid;
        $det = $this->fill_required('iccr_student_details', $det);
        $this->db->insert('iccr_student_details', $det);
        $det_id = $this->db->insert_id(); // read it now: the audit inserts below change insert_id()
        $this->audit($admin, 'insert', 'iccr_users', $uid, '', NULL, json_encode($this->strip_secrets('iccr_users', $user)), 'Student created from admin panel');
        $this->audit($admin, 'insert', 'iccr_student_details', $det_id, '', NULL, json_encode($det), 'Student created from admin panel');
        $this->db->trans_complete();
        return $this->db->trans_status() ? $uid : FALSE;
    }

    /* ==============================================================
       Missions / Universities (generic lists)
       ============================================================== */

    public function entity_list($table, $search_cols, $q, $limit, $offset)
    {
        $cols = $this->columns($table);
        $pk_col = $this->primary_key($table);
        $apply = function () use ($table, $search_cols, $q, $cols, $pk_col) {
            $this->db->from($table);
            if ($pk_col && isset($this->trash_tables[$table]) && ($nt = $this->not_trashed_sql($table, $pk_col))) { $this->db->where($nt, NULL, FALSE); }
            if ($q !== '') {
                $this->db->group_start();
                $first = TRUE;
                foreach ($search_cols as $c) {
                    if (!isset($cols[$c])) { continue; }
                    $first ? $this->db->like($c, $q) : $this->db->or_like($c, $q);
                    $first = FALSE;
                }
                if (isset($cols['id']) && ctype_digit($q)) { $this->db->or_where('id', (int) $q); }
                if ($first && !isset($cols['id'])) { $this->db->where('1 = 1', NULL, FALSE); }
                $this->db->group_end();
            }
        };
        $apply();
        $total = $this->db->count_all_results();
        $apply();
        $pk = $this->primary_key($table);
        if ($pk) { $this->db->order_by($pk, 'DESC'); }
        $rows = $this->db->limit($limit, $offset)->get()->result_array();
        return array($rows, $total);
    }

    /* ==============================================================
       Accounts (iccr_users for staff roles)
       ============================================================== */

    public function accounts($type, $q, $limit, $offset)
    {
        $apply = function () use ($type, $q) {
            $this->db->from('iccr_users');
            $this->db->where('user_type', (int) $type);
            if ($nt = $this->not_trashed_sql('iccr_users', 'id')) { $this->db->where($nt, NULL, FALSE); }
            if ($q !== '') {
                $this->db->group_start()->like('email_id', $q)->or_like('username', $q)->group_end();
            }
        };
        $apply();
        $total = $this->db->count_all_results();
        $apply();
        $rows = $this->db->select('id, username, email_id, user_type, status, created, user_country, university')
                         ->order_by('id', 'DESC')->limit($limit, $offset)->get()->result_array();
        return array($rows, $total);
    }

    public function account($id)
    {
        $row = $this->db->get_where('iccr_users', array('id' => (int) $id), 1)->row_array();
        if ($row && (int) $row['user_type'] === 1) { return NULL; } // students are managed under Students
        return $row;
    }

    public function set_password($id, $sha1_hash, $admin)
    {
        $this->db->trans_start();
        $this->db->where('id', (int) $id)->limit(1)->update('iccr_users', array('password' => $sha1_hash));
        $this->audit($admin, 'password', 'iccr_users', $id, 'password', NULL, NULL, 'Password reset from admin panel');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}

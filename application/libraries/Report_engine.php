<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Report_engine - the catalogue of recurring A2A reports for the Admin Panel.
 *
 * Every report is read-only (SELECT only), takes its inputs from a whitelist of
 * fields, binds every value in SQL, and never selects password / token / bank /
 * passport columns. A report returns:
 *   array('title' => ..., 'subtitle' => ..., 'sections' => array(
 *       array('title' => ..., 'note' => ..., 'columns' => array(...), 'rows' => array(array(...), ...)) ))
 * The same array is shown on screen, written to Excel / CSV by Report_writer,
 * or printed (Save as PDF) from the browser.
 *
 * Written for PHP 5.6+ and CodeIgniter 3.1.x. Query pieces were first run and
 * verified by hand in Adminer during 2026-27 (see README.txt).
 *
 * NEW ACADEMIC YEAR: add one line to $cycles below. Nothing else changes.
 */
class Report_engine
{
    const MAX_ROWS = 50000;
    const PREVIEW_ROWS = 100;

    /** cycle label => array(first epoch, last epoch, start year). */
    public $cycles = array(
        '2026-27' => array(1772150400, 1798761599, 2026),
        '2025-26' => array(1740614400, 1772150399, 2025),
    );

    /** iccr_status_mapping.status in plain words. */
    public $status_words = array(
        1  => 'Submitted',
        4  => 'Recommended by Mission',
        5  => 'Rejected',
        10 => 'Confirmed to Mission (award / acceptance pending)',
        11 => 'Awarded and offer accepted',
        12 => 'Declined the offer',
        13 => 'Visa / travel stage',
        14 => 'Arrived in India',
        15 => 'Withdrawn',
    );

    /** iccr_university_status_mapping.status in plain words. */
    public $univ_status_words = array(
        2  => 'Pending with university',
        6  => 'Admission confirmed',
        7  => 'Rejected by university',
        8  => 'Awarded',
        11 => 'Under Mission consideration',
    );

    /** "Awarded and accepted" = these statuses with scholar_acceptance = 1. */
    private $accepted_in = '11,13,14';

    protected $CI;
    private $cache = array();

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /* ==============================================================
       Catalogue and form fields
       ============================================================== */

    public function catalog()
    {
        return array(
            'status_summary' => array(
                'title'  => 'Status summary',
                'icon'   => 'fa-pie-chart',
                'desc'   => 'How many applications are at each stage, and at each level (UG / PG / PhD). Optional filter by scheme or country.',
                'fields' => array('cycle', 'scheme', 'country'),
            ),
            'country_report' => array(
                'title'  => 'Country report',
                'icon'   => 'fa-globe',
                'desc'   => 'Any country: status and level summary plus the student list (the Aid to Maldives report, for any country). Optionally also lists students of one scheme who are of another nationality.',
                'fields' => array('cycle', 'country_req', 'scheme'),
            ),
            'scheme_status' => array(
                'title'  => 'Scheme-wise status',
                'icon'   => 'fa-table',
                'desc'   => 'Every scheme against every status, with the number awarded and accepted. A scheme is recorded only when HQ awards, so earlier stages show under "Scheme not set".',
                'fields' => array('cycle'),
            ),
            'ro_scheme' => array(
                'title'  => 'RO-wise, scheme-wise (accepted students)',
                'icon'   => 'fa-map-marker',
                'desc'   => 'Awarded and accepted students: scheme against Regional Office, with the full name / scheme / RO list. Bhopal is merged into Delhi.',
                'fields' => array('cycle'),
            ),
            'overage' => array(
                'title'  => 'Over-age students',
                'icon'   => 'fa-hourglass-end',
                'desc'   => 'Awarded and accepted students over the age limit on 1 July (UG / PG / Diploma and PhD), checked on both the application DOB and the profile DOB. Lists mismatched and impossible DOBs. One list, or one sheet per RO or per scheme.',
                'fields' => array('cycle', 'limit_ug', 'limit_phd', 'excl_lata', 'excl_ayush', 'sheets'),
            ),
            'through' => array(
                'title'  => 'Application made through (Mission)',
                'icon'   => 'fa-flag',
                'desc'   => 'Paste application numbers to get the Mission each application was made through, or leave empty for every AYUSH application of the year.',
                'fields' => array('cycle', 'appnos'),
            ),
            'case_status' => array(
                'title'  => 'Student status check',
                'icon'   => 'fa-search',
                'desc'   => 'For a few application numbers: status in plain words, university-wise status, the confirmed university and any HQ letter.',
                'fields' => array('appnos_req'),
            ),
            'slots' => array(
                'title'  => 'Country slots against awards',
                'icon'   => 'fa-balance-scale',
                'desc'   => 'Slots allotted per scheme and country against awarded and accepted students. Needs the slots table (iccr_scheme_country_slots) to be loaded.',
                'fields' => array('cycle', 'scheme'),
            ),
        );
    }

    /** Definition of one form field. Options for scheme / country are read from the database. */
    public function field($name)
    {
        switch ($name) {
            case 'cycle':
                $o = array();
                foreach ($this->cycles as $k => $v) { $o[$k] = $k; }
                return array('name' => 'cycle', 'label' => 'Academic year', 'type' => 'select', 'options' => $o, 'default' => key($this->cycles),
                    'hint' => 'Applications created in that cycle.');
            case 'scheme':
                return array('name' => 'scheme', 'label' => 'Scheme', 'type' => 'select', 'options' => array('0' => 'All schemes') + $this->scheme_options(), 'default' => '0');
            case 'country':
                return array('name' => 'country', 'label' => 'Country (nationality)', 'type' => 'select', 'options' => array('0' => 'All countries') + $this->country_options(), 'default' => '0');
            case 'country_req':
                return array('name' => 'country', 'label' => 'Country (nationality)', 'type' => 'select', 'options' => array('0' => '- choose a country -') + $this->country_options(), 'default' => '0');
            case 'limit_ug':
                return array('name' => 'limit_ug', 'label' => 'Age limit: UG / PG / Diploma', 'type' => 'number', 'default' => 35, 'hint' => 'Over this age on 1 July of the year.');
            case 'limit_phd':
                return array('name' => 'limit_phd', 'label' => 'Age limit: PhD', 'type' => 'number', 'default' => 40);
            case 'excl_lata':
                return array('name' => 'excl_lata', 'label' => 'Leave out the Lata Mangeshkar scheme (UG / PG / Diploma)', 'type' => 'check', 'default' => 1,
                    'hint' => 'They are still shown on a separate sheet so nobody is dropped silently.');
            case 'excl_ayush':
                return array('name' => 'excl_ayush', 'label' => 'Leave out AYUSH schemes', 'type' => 'check', 'default' => 0);
            case 'sheets':
                return array('name' => 'sheets', 'label' => 'Lists', 'type' => 'select',
                    'options' => array('single' => 'One list', 'ro' => 'One sheet per RO', 'scheme' => 'One sheet per scheme'), 'default' => 'single');
            case 'appnos':
                return array('name' => 'appnos', 'label' => 'Application numbers (optional)', 'type' => 'textarea',
                    'hint' => 'One per line, or separated by commas or spaces. Empty = every AYUSH application of the year.');
            case 'appnos_req':
                return array('name' => 'appnos', 'label' => 'Application numbers', 'type' => 'textarea', 'hint' => 'One per line, or separated by commas or spaces (up to 200).');
        }
        return array('name' => $name, 'label' => $name, 'type' => 'text', 'default' => '');
    }

    public function fields_for($key)
    {
        $cat = $this->catalog();
        $out = array();
        if (!isset($cat[$key])) { return $out; }
        foreach ($cat[$key]['fields'] as $f) { $out[] = $this->field($f); }
        return $out;
    }

    /** Cleans GET values against the field whitelist. $submitted = the form was sent (so an unticked box means "off"). */
    public function read_params($key, $get, $submitted)
    {
        $p = array();
        foreach ($this->fields_for($key) as $f) {
            $n = $f['name'];
            $raw = isset($get[$n]) ? $get[$n] : NULL;
            switch ($f['type']) {
                case 'select':
                    if ($n === 'cycle') { $p[$n] = isset($this->cycles[$raw]) ? $raw : $f['default']; }
                    elseif ($n === 'sheets') { $p[$n] = in_array($raw, array('single', 'ro', 'scheme'), TRUE) ? $raw : 'single'; }
                    else { $p[$n] = (int) preg_replace('/\D/', '', (string) $raw); }
                    break;
                case 'number':
                    $v = (int) preg_replace('/\D/', '', (string) $raw);
                    $p[$n] = ($v >= 18 && $v <= 80) ? $v : $f['default'];
                    break;
                case 'check':
                    $p[$n] = $submitted ? (!empty($raw) ? 1 : 0) : (int) $f['default'];
                    break;
                case 'textarea':
                    $text = is_string($raw) ? $raw : '';
                    preg_match_all('/[A-Za-z]{2}\d{13}/', $text, $m);
                    $p[$n . '_text'] = $text;
                    $p[$n] = array_slice(array_values(array_unique(array_map('strtoupper', $m[0]))), 0, 200);
                    break;
                default:
                    $p[$n] = is_string($raw) ? trim($raw) : '';
            }
        }
        return $p;
    }

    /** Returns an error message, or '' when the inputs are enough to run the report. */
    public function check($key, $p)
    {
        if ($key === 'country_report' && empty($p['country'])) { return 'Please choose a country.'; }
        if ($key === 'case_status' && empty($p['appnos'])) { return 'Please enter at least one application number (two letters followed by 13 digits).'; }
        return '';
    }

    /** One line saying which inputs were used (printed on the report and written to the audit log). */
    public function params_text($key, $p)
    {
        $bits = array();
        foreach ($this->fields_for($key) as $f) {
            $n = $f['name'];
            if (!isset($p[$n])) { continue; }
            $v = $p[$n];
            if ($n === 'scheme') { if ($v) { $bits[] = 'Scheme: ' . $this->scheme_name($v); } }
            elseif ($n === 'country') { if ($v) { $bits[] = 'Country: ' . $this->country_name($v); } }
            elseif ($n === 'appnos') { if ($v) { $bits[] = 'Applications: ' . count($v); } }
            elseif ($f['type'] === 'check') { $bits[] = $f['label'] . ': ' . ($v ? 'yes' : 'no'); }
            elseif ($n === 'cycle') { $bits[] = 'Year: ' . $v; }
            elseif ($n === 'sheets') { $bits[] = 'Lists: ' . $f['options'][$v]; }
            else { $bits[] = $f['label'] . ': ' . $v; }
        }
        return implode(' | ', $bits);
    }

    public function run($key, $p)
    {
        $fn = 'r_' . $key;
        $cat = $this->catalog();
        if (!isset($cat[$key]) || !method_exists($this, $fn)) { throw new Exception('Unknown report.'); }
        @set_time_limit(300);
        @ini_set('memory_limit', '512M');
        $r = $this->$fn($p);
        $r['key'] = $key;
        $r['params_text'] = $this->params_text($key, $p);
        $r['rows_total'] = 0;
        foreach ($r['sections'] as $s) { $r['rows_total'] += count($s['rows']); }
        return $r;
    }

    /* ==============================================================
       Look-ups and helpers
       ============================================================== */

    public function scheme_options()
    {
        if (!isset($this->cache['schemes'])) {
            $o = array();
            foreach ($this->q('SELECT id, scheme_name FROM iccr_scheme ORDER BY scheme_name', array()) as $r) { $o[(string) $r['id']] = trim($r['scheme_name']); }
            $this->cache['schemes'] = $o;
        }
        return $this->cache['schemes'];
    }

    public function country_options()
    {
        if (!isset($this->cache['countries'])) {
            $o = array();
            foreach ($this->q('SELECT id, country_name FROM iccr_countries ORDER BY country_name', array()) as $r) { $o[(string) $r['id']] = trim($r['country_name']); }
            $this->cache['countries'] = $o;
        }
        return $this->cache['countries'];
    }

    private function scheme_name($id)
    {
        $o = $this->scheme_options();
        return isset($o[(string) $id]) ? $o[(string) $id] : ('Scheme ' . $id);
    }

    private function country_name($id)
    {
        $o = $this->country_options();
        return isset($o[(string) $id]) ? $o[(string) $id] : ('Country ' . $id);
    }

    /** Runs a SELECT with bound values. Throws a plain message instead of the framework error page. */
    private function q($sql, $binds)
    {
        $db = $this->CI->db;
        $old = $db->db_debug;
        $db->db_debug = FALSE;
        $res = $db->query($sql, $binds);
        $db->db_debug = $old;
        if ($res === FALSE) {
            $e = $db->error();
            throw new Exception('The database could not run this report' . (isset($e['message']) && $e['message'] !== '' ? ': ' . $e['message'] : '.'));
        }
        $rows = $res->result_array();
        if (count($rows) > self::MAX_ROWS) { $rows = array_slice($rows, 0, self::MAX_ROWS); }
        return $rows;
    }

    private function sec($title, $columns, $rows, $note = '')
    {
        return array('title' => $title, 'note' => $note, 'columns' => $columns, 'rows' => $rows);
    }

    private function sw($st)
    {
        $st = (int) $st;
        return isset($this->status_words[$st]) ? $this->status_words[$st] : ('Status ' . $st);
    }

    private function nm($r)
    {
        $parts = array();
        foreach (array('fullname', 'middlename', 'familyname') as $k) { if (isset($r[$k])) { $parts[] = $r[$k]; } }
        return trim(preg_replace('/\s+/', ' ', implode(' ', $parts)));
    }

    private function dmy($ts)
    {
        return ($ts !== NULL && $ts !== '' && (int) $ts > 0) ? date('d-m-Y', (int) $ts) : '';
    }

    private function cycle_range($p)
    {
        $c = $this->cycles[$p['cycle']];
        return array($c[0], $c[1], $c[2]);
    }

    private function in_list($arr)
    {
        return implode(',', array_fill(0, count($arr), '?'));
    }

    /** Counts per key in $order first, then any others. */
    private function tally($rows, $keyfn)
    {
        $out = array();
        foreach ($rows as $r) { $k = call_user_func($keyfn, $r); $out[$k] = isset($out[$k]) ? $out[$k] + 1 : 1; }
        return $out;
    }

    /** "Awarded and accepted" students with university and RO. Bhopal (3) is merged into Delhi (23). */
    private function accepted_rows($from, $to, $withDob, $programmes)
    {
        $sql = "SELECT sm.application_no, ad.fullname, ad.middlename, ad.familyname, c.country_name, ad.programme, p.name AS programme_name, "
             . "sm.scholarship_id, s.scheme_name, sm.status, un.name AS university, r.id AS ro_id, r.name AS ro_name"
             . ($withDob ? ", ad.dob AS application_dob, sd.date_of_birth AS profile_dob" : "")
             . " FROM iccr_status_mapping sm"
             . " JOIN iccr_student_application_details ad ON ad.application_no = sm.application_no"
             . ($withDob ? " JOIN iccr_student_details sd ON sd.uid = sm.uid" : "")
             . " LEFT JOIN iccr_countries c ON c.id = ad.nationality"
             . " LEFT JOIN iccr_programme p ON p.id = ad.programme"
             . " LEFT JOIN iccr_scheme s ON s.id = sm.scholarship_id"
             . " LEFT JOIN iccr_university_response ur ON ur.application_id = sm.application_no AND ur.confirmed_to_mission = 1"
             . " LEFT JOIN iccr_university_response_by_hqrs h ON h.application_id = sm.application_no AND h.university_is_accept = 1"
             . " LEFT JOIN iccr_univercities un ON un.id = COALESCE(ur.regional_university, h.regional_university)"
             . " LEFT JOIN iccr_regions r ON r.id = un.state"
             . " WHERE sm.created BETWEEN ? AND ? AND sm.status IN (" . $this->accepted_in . ") AND sm.scholar_acceptance = 1";
        $binds = array($from, $to);
        if ($programmes) {
            $sql .= " AND ad.programme IN (" . $this->in_list($programmes) . ")";
            $binds = array_merge($binds, $programmes);
        }
        $raw = $this->q($sql, $binds);

        $names = array();
        foreach ($raw as $r) { if ($r['ro_id'] !== NULL) { $names[(int) $r['ro_id']] = trim($r['ro_name']); } }
        $out = array();
        foreach ($raw as $r) {
            $k = $r['application_no'];
            if (isset($out[$k]) && ($out[$k]['ro'] !== 'RO not found' || $r['ro_id'] === NULL)) { continue; }
            $id = $r['ro_id'] === NULL ? 0 : (int) $r['ro_id'];
            if ($id === 3) { $id = 23; }
            $r['ro'] = $id === 0 ? 'RO not found' : (isset($names[$id]) ? $names[$id] : trim($r['ro_name']));
            $r['name'] = $this->nm($r);
            $r['scheme'] = ($r['scheme_name'] === NULL || trim($r['scheme_name']) === '') ? 'Scheme not set' : trim($r['scheme_name']);
            $out[$k] = $r;
        }
        return array_values($out);
    }

    /** Pivot: rows[rowLabel][colLabel] = n  ->  columns + rows with totals, biggest first, $last labels at the end. */
    private function matrix($cells, $rowHead, $lastRow, $lastCol)
    {
        $rt = array(); $ct = array();
        foreach ($cells as $r => $cols) {
            foreach ($cols as $c => $n) {
                $rt[$r] = (isset($rt[$r]) ? $rt[$r] : 0) + $n;
                $ct[$c] = (isset($ct[$c]) ? $ct[$c] : 0) + $n;
            }
        }
        $cmp = function ($a, $b, $tot, $last) {
            if ($a === $last) { return 1; }
            if ($b === $last) { return -1; }
            if ($tot[$a] === $tot[$b]) { return strcmp($a, $b); }
            return $tot[$b] - $tot[$a];
        };
        $rowKeys = array_keys($rt);
        usort($rowKeys, function ($a, $b) use ($cmp, $rt, $lastRow) { return $cmp($a, $b, $rt, $lastRow); });
        $colKeys = array_keys($ct);
        usort($colKeys, function ($a, $b) use ($cmp, $ct, $lastCol) { return $cmp($a, $b, $ct, $lastCol); });
        $columns = array_merge(array($rowHead), $colKeys, array('Total'));
        $rows = array();
        foreach ($rowKeys as $r) {
            $line = array($r);
            foreach ($colKeys as $c) { $line[] = isset($cells[$r][$c]) ? $cells[$r][$c] : ''; }
            $line[] = $rt[$r];
            $rows[] = $line;
        }
        $tot = array('Total');
        foreach ($colKeys as $c) { $tot[] = $ct[$c]; }
        $tot[] = array_sum($rt);
        $rows[] = $tot;
        return array($columns, $rows);
    }

    /** Reads a text DOB (d/m/Y, d-m-Y, d.m.Y or Y-m-d) into the integer Ymd, or NULL. */
    public function parse_dob($s)
    {
        $s = trim((string) $s);
        if ($s === '') { return NULL; }
        if (preg_match('/^(\d{1,2})[\/\-\.](\d{1,2})[\/\-\.](\d{4})/', $s, $m)) { $d = (int) $m[1]; $mo = (int) $m[2]; $y = (int) $m[3]; }
        elseif (preg_match('/^(\d{4})[\/\-\.](\d{1,2})[\/\-\.](\d{1,2})/', $s, $m)) { $y = (int) $m[1]; $mo = (int) $m[2]; $d = (int) $m[3]; }
        else { return NULL; }
        if (!checkdate($mo, $d, $y)) { return NULL; }
        return $y * 10000 + $mo * 100 + $d;
    }

    private function age_on($ymd, $refYmd)
    {
        return (int) floor(($refYmd - $ymd) / 10000);
    }

    private function dob_show($ymd, $raw)
    {
        return $ymd === NULL ? (trim((string) $raw) === '' ? '' : trim((string) $raw)) : sprintf('%02d-%02d-%04d', $ymd % 100, floor($ymd / 100) % 100, floor($ymd / 10000));
    }

    /* ==============================================================
       1. Status summary
       ============================================================== */

    private function r_status_summary($p)
    {
        list($from, $to) = $this->cycle_range($p);
        $where = 'sm.created BETWEEN ? AND ?';
        $b = array($from, $to);
        if (!empty($p['scheme']))  { $where .= ' AND sm.scholarship_id = ?'; $b[] = $p['scheme']; }
        if (!empty($p['country'])) { $where .= ' AND ad.nationality = ?'; $b[] = $p['country']; }
        $base = ' FROM iccr_status_mapping sm JOIN iccr_student_application_details ad ON ad.application_no = sm.application_no'
              . ' LEFT JOIN iccr_programme p ON p.id = ad.programme WHERE ' . $where;

        $byStatus = $this->q('SELECT sm.status AS k, COUNT(*) AS n' . $base . ' GROUP BY sm.status ORDER BY sm.status', $b);
        $byLevel  = $this->q("SELECT COALESCE(p.name, 'Not set') AS k, COUNT(*) AS n" . $base . ' GROUP BY p.name ORDER BY n DESC', $b);

        $rows = array(); $tot = 0;
        foreach ($byStatus as $r) { $rows[] = array($this->sw($r['k']), (int) $r['n']); $tot += (int) $r['n']; }
        $rows[] = array('Total', $tot);
        $rows2 = array(); $tot2 = 0;
        foreach ($byLevel as $r) { $rows2[] = array($r['k'], (int) $r['n']); $tot2 += (int) $r['n']; }
        $rows2[] = array('Total', $tot2);

        return array(
            'title' => 'Status summary - ' . $p['cycle'],
            'subtitle' => 'Applications created in the ' . $p['cycle'] . ' cycle.',
            'sections' => array(
                $this->sec('By status', array('Status', 'Applications'), $rows),
                $this->sec('By level', array('Level', 'Applications'), $rows2),
            ),
        );
    }

    /* ==============================================================
       2. Country report (generalised Aid to Maldives report)
       ============================================================== */

    private function r_country_report($p)
    {
        list($from, $to) = $this->cycle_range($p);
        $cond = 'ad.nationality = ?';
        $b = array($from, $to, $p['country']);
        if (!empty($p['scheme'])) { $cond = '(ad.nationality = ? OR sm.scholarship_id = ?)'; $b[] = $p['scheme']; }

        $sql = "SELECT sm.application_no, ad.fullname, ad.middlename, ad.familyname, IF(ad.gender=1,'Male',IF(ad.gender=2,'Female','')) AS gender, "
             . "ad.nationality, p.name AS level, n.title AS course, un.name AS university, sm.status, sm.scholarship_id, s.scheme_name, "
             . "COALESCE(ur.date_of_joining, h.date_of_joining) AS joining, COALESCE(ur.duration_of_course, h.duration_of_course) AS duration, "
             . "FROM_UNIXTIME(sm.created, '%d-%m-%Y') AS applied_on "
             . "FROM iccr_status_mapping sm JOIN iccr_student_application_details ad ON ad.application_no = sm.application_no "
             . "LEFT JOIN iccr_programme p ON p.id = ad.programme LEFT JOIN iccr_nomenclature n ON n.id = sm.nomenclature "
             . "LEFT JOIN iccr_scheme s ON s.id = sm.scholarship_id "
             . "LEFT JOIN iccr_university_response ur ON ur.application_id = sm.application_no AND ur.confirmed_to_mission = 1 "
             . "LEFT JOIN iccr_university_response_by_hqrs h ON h.application_id = sm.application_no AND h.university_is_accept = 1 "
             . "LEFT JOIN iccr_univercities un ON un.id = COALESCE(ur.regional_university, h.regional_university) "
             . "WHERE sm.created BETWEEN ? AND ? AND " . $cond . " ORDER BY sm.status, sm.application_no";
        $raw = $this->q($sql, $b);

        $seen = array(); $list = array();
        foreach ($raw as $r) { if (!isset($seen[$r['application_no']])) { $seen[$r['application_no']] = 1; $list[] = $r; } }

        $order = array(11 => 0, 13 => 1, 14 => 2, 10 => 3, 4 => 4, 1 => 5, 12 => 6, 15 => 7, 5 => 8);
        usort($list, function ($a, $c) use ($order) {
            $x = isset($order[(int) $a['status']]) ? $order[(int) $a['status']] : 99;
            $y = isset($order[(int) $c['status']]) ? $order[(int) $c['status']] : 99;
            return $x === $y ? strcmp($a['application_no'], $c['application_no']) : $x - $y;
        });

        $stat = array(); $lev = array();
        foreach ($list as $r) {
            $stat[(int) $r['status']] = isset($stat[(int) $r['status']]) ? $stat[(int) $r['status']] + 1 : 1;
            $l = $r['level'] === NULL || $r['level'] === '' ? 'Not set' : $r['level'];
            $lev[$l] = isset($lev[$l]) ? $lev[$l] + 1 : 1;
        }
        ksort($stat);
        $rows1 = array();
        foreach ($stat as $k => $n) { $rows1[] = array($this->sw($k), $n); }
        $rows1[] = array('Total', count($list));
        arsort($lev);
        $rows2 = array();
        foreach ($lev as $k => $n) { $rows2[] = array($k, $n); }
        $rows2[] = array('Total', count($list));

        $rows3 = array(); $i = 0; $withScheme = 0; $otherScheme = array(); $otherNat = array();
        foreach ($list as $r) {
            $i++;
            $hasScheme = ($r['scholarship_id'] !== NULL && (int) $r['scholarship_id'] > 0);
            if ($hasScheme) { $withScheme++; }
            $rows3[] = array($i, $r['application_no'], $this->nm($r), $r['gender'], $r['level'] === NULL ? '' : $r['level'],
                ($r['course'] === NULL || $r['course'] === '') ? 'Not yet allotted' : $r['course'],
                ($r['university'] === NULL || $r['university'] === '') ? 'Not yet allotted' : $r['university'],
                $this->sw($r['status']), $r['joining'] === NULL ? '-' : $r['joining'], $r['duration'] === NULL ? '-' : $r['duration'],
                $hasScheme ? trim($r['scheme_name']) : 'Not yet stamped', $r['applied_on']);
            if (!empty($p['scheme'])) {
                if ((int) $r['nationality'] === (int) $p['country'] && $hasScheme && (int) $r['scholarship_id'] !== (int) $p['scheme']) { $otherScheme[] = $r['application_no']; }
                if ((int) $r['nationality'] !== (int) $p['country']) { $otherNat[] = $r['application_no']; }
            }
        }
        $note = array();
        $note[] = 'Students counted: ' . count($list) . '; with a scheme recorded: ' . $withScheme . '. A scheme is recorded only when HQ awards, so earlier stages show "Not yet stamped".';
        if (!empty($p['scheme'])) {
            $note[] = 'Nationals of ' . $this->country_name($p['country']) . ' on a different scheme: ' . ($otherScheme ? implode(', ', $otherScheme) : 'none') . '.';
            $note[] = 'Students on ' . $this->scheme_name($p['scheme']) . ' who are of another nationality: ' . ($otherNat ? implode(', ', $otherNat) : 'none') . '.';
        }
        $note[] = 'Names, application numbers and course details only; no contact, passport or bank details.';

        return array(
            'title' => $this->country_name($p['country']) . ' - applications ' . $p['cycle'],
            'subtitle' => 'Applications created in the ' . $p['cycle'] . ' cycle.',
            'sections' => array(
                $this->sec('Summary by status', array('Status', 'Applications'), $rows1),
                $this->sec('Summary by level', array('Level', 'Applications'), $rows2),
                $this->sec('Student list', array('S.No', 'Application No.', 'Name', 'Gender', 'Level', 'Course', 'University', 'Status', 'Joining date', 'Duration (years)', 'Scheme', 'Applied on'), $rows3),
                $this->sec('Notes', array('Note'), array_map(function ($t) { return array($t); }, $note)),
            ),
        );
    }

    /* ==============================================================
       3. Scheme-wise status
       ============================================================== */

    private function r_scheme_status($p)
    {
        list($from, $to) = $this->cycle_range($p);
        $rows = $this->q("SELECT COALESCE(s.scheme_name, 'Scheme not set') AS scheme, sm.status AS st, COUNT(*) AS n, "
            . "SUM(IF(sm.scholar_acceptance = 1 AND sm.status IN (" . $this->accepted_in . "), 1, 0)) AS acc "
            . "FROM iccr_status_mapping sm LEFT JOIN iccr_scheme s ON s.id = sm.scholarship_id "
            . "WHERE sm.created BETWEEN ? AND ? GROUP BY s.scheme_name, sm.status", array($from, $to));

        $cells = array(); $acc = array();
        foreach ($rows as $r) {
            $s = trim($r['scheme']);
            $cells[$s][$this->sw($r['st'])] = (isset($cells[$s][$this->sw($r['st'])]) ? $cells[$s][$this->sw($r['st'])] : 0) + (int) $r['n'];
            $acc[$s] = (isset($acc[$s]) ? $acc[$s] : 0) + (int) $r['acc'];
        }
        list($cols, $out) = $this->matrix($cells, 'Scheme', 'Scheme not set', '');
        // add the accepted column before Total
        $cols = array_merge(array_slice($cols, 0, -1), array('Accepted (awarded, visa, arrived)', 'Total'));
        $tot = 0;
        foreach ($out as $i => $line) {
            $t = array_pop($line);
            if ($line[0] === 'Total') { $a = $tot; } else { $a = isset($acc[$line[0]]) ? $acc[$line[0]] : 0; $tot += $a; }
            $line[] = $a; $line[] = $t;
            $out[$i] = $line;
        }
        return array(
            'title' => 'Scheme-wise status - ' . $p['cycle'],
            'subtitle' => 'Applications created in the ' . $p['cycle'] . ' cycle. "Accepted" = awarded, visa / travel or arrived, with the offer accepted.',
            'sections' => array($this->sec('Scheme against status', $cols, $out,
                'A scheme is recorded only when HQ awards the student, so applications at earlier stages show under "Scheme not set".')),
        );
    }

    /* ==============================================================
       4. RO-wise, scheme-wise
       ============================================================== */

    private function r_ro_scheme($p)
    {
        list($from, $to) = $this->cycle_range($p);
        $acc = $this->accepted_rows($from, $to, FALSE, array());
        $cells = array();
        foreach ($acc as $r) { $cells[$r['ro']][$r['scheme']] = (isset($cells[$r['ro']][$r['scheme']]) ? $cells[$r['ro']][$r['scheme']] : 0) + 1; }
        list($cols, $matrix) = $this->matrix($cells, 'RO', 'RO not found', 'Scheme not set');

        usort($acc, function ($a, $b) {
            $x = strcmp($a['ro'], $b['ro']); if ($x) { return $x; }
            $x = strcmp($a['scheme'], $b['scheme']); return $x ? $x : strcmp($a['application_no'], $b['application_no']);
        });
        $list = array(); $i = 0;
        foreach ($acc as $r) {
            $i++;
            $list[] = array($i, $r['application_no'], $r['name'], $r['country_name'], $r['programme_name'], $r['scheme'], $r['ro'], $r['university'], $this->sw($r['status']));
        }
        return array(
            'title' => 'RO-wise, scheme-wise accepted students - ' . $p['cycle'],
            'subtitle' => 'Awarded and accepted students. RO = Regional Office of the placed university; Bhopal is merged into Delhi.',
            'sections' => array(
                $this->sec('RO against scheme', $cols, $matrix),
                $this->sec('Name, scheme and RO', array('S.No', 'Application No.', 'Name', 'Country', 'Level', 'Scheme', 'RO', 'University', 'Status'), $list,
                    'Students whose university is not mapped to an RO show as "RO not found".'),
            ),
        );
    }

    /* ==============================================================
       5. Over-age students
       ============================================================== */

    private function r_overage($p)
    {
        list($from, $to, $year) = $this->cycle_range($p);
        $ref = $year * 10000 + 701;                       // 1 July of the start year
        $cutUg  = ($year - $p['limit_ug']) * 10000 + 701;  // born before this = over the limit
        $cutPhd = ($year - $p['limit_phd']) * 10000 + 701;

        $rows = $this->accepted_rows($from, $to, TRUE, array(1, 2, 4, 8, 10, 11, 12));
        $isAyush = function ($r) { return stripos($r['scheme'], 'AYUSH') !== FALSE; };
        $isLata  = function ($r) { return stripos($r['scheme'], 'Lata Mangeshkar') !== FALSE; };

        $listG = array(); $lata = array(); $mismatch = array(); $bad = array();
        $checked = 0;
        foreach ($rows as $r) {
            if (!empty($p['excl_ayush']) && $isAyush($r)) { continue; }
            $checked++;
            $a = $this->parse_dob($r['application_dob']);
            $pr = $this->parse_dob($r['profile_dob']);
            $ageA = $a === NULL ? NULL : $this->age_on($a, $ref);
            $ageP = $pr === NULL ? NULL : $this->age_on($pr, $ref);
            $r['a'] = $a; $r['pr'] = $pr; $r['ageA'] = $ageA; $r['ageP'] = $ageP;
            $impossible = ($ageA !== NULL && ($ageA < 16 || $ageA > 75)) || ($ageP !== NULL && ($ageP < 16 || $ageP > 75));
            if ($a !== $pr) { $mismatch[] = $r; }
            if ($impossible) { $bad[] = $r; continue; }
            $phd = in_array((int) $r['programme'], array(4, 8), TRUE);
            $cut = $phd ? $cutPhd : $cutUg;
            $overA = ($a !== NULL && $a < $cut); $overP = ($pr !== NULL && $pr < $cut);
            if (!$overA && !$overP) { continue; }
            $r['basis'] = ($overA && $overP) ? 'Both DOBs' : ($overA ? 'Application DOB only' : 'Profile DOB only');
            $r['cat'] = $phd ? 'PhD over ' . $p['limit_phd'] : 'UG/PG/Diploma over ' . $p['limit_ug'];
            if (!$phd && !empty($p['excl_lata']) && $isLata($r)) { $lata[] = $r; continue; }
            $listG[] = $r;
        }

        $cols = array('S.No', 'Application No.', 'Name', 'Country', 'Level', 'Scheme', 'RO', 'Category', 'University', 'Status',
                      'DOB (application)', 'DOB (profile)', 'Age (application)', 'Age (profile)', 'Flagged by');
        $self = $this;
        $line = function ($i, $r) use ($self) {
            return array($i, $r['application_no'], $r['name'], $r['country_name'], $r['programme_name'], $r['scheme'], $r['ro'],
                isset($r['cat']) ? $r['cat'] : '', $r['university'], $self->status_label($r['status']),
                $self->dob_label($r['a'], $r['application_dob']), $self->dob_label($r['pr'], $r['profile_dob']),
                $r['ageA'] === NULL ? '' : $r['ageA'], $r['ageP'] === NULL ? '' : $r['ageP'], isset($r['basis']) ? $r['basis'] : '');
        };
        $make = function ($title, $set, $note) use ($cols, $line) {
            usort($set, function ($a, $b) { $x = ($b['ageA'] === NULL ? 0 : $b['ageA']) - ($a['ageA'] === NULL ? 0 : $a['ageA']); return $x ? $x : strcmp($a['application_no'], $b['application_no']); });
            $out = array(); $i = 0;
            foreach ($set as $r) { $i++; $out[] = $line($i, $r); }
            return array('title' => $title, 'note' => $note, 'columns' => $cols, 'rows' => $out);
        };

        $g1 = 0; $g2 = 0;
        foreach ($listG as $r) { if (strpos($r['cat'], 'PhD') === 0) { $g2++; } else { $g1++; } }
        $summary = array(
            array('Students checked (awarded and accepted; UG, PG, Diploma, PhD incl. AYUSH)', $checked),
            array('UG / PG / Diploma over ' . $p['limit_ug'], $g1),
            array('PhD over ' . $p['limit_phd'], $g2),
            array('Lata Mangeshkar students over ' . $p['limit_ug'] . ' (left out of the UG / PG / Diploma list)', count($lata)),
            array('Application DOB differs from profile DOB', count($mismatch)),
            array('Impossible DOBs (age under 16 or over 75) - need correction', count($bad)),
        );
        $nSum = 'Age is counted as on 1 July ' . $year . '. Over ' . $p['limit_ug'] . ' means born before 01-07-' . ($year - $p['limit_ug'])
              . '; over ' . $p['limit_phd'] . ' (PhD) means born before 01-07-' . ($year - $p['limit_phd'])
              . '. A student who is 35 years and even one day old counts as over 35, although the age column shows completed years. A student is listed if EITHER the application DOB or the profile DOB crosses the limit. The scheme comes from the portal scheme table; RO is the Regional Office of the placed university (Bhopal merged into Delhi).';

        // scheme x RO matrix of the listed students
        $cells = array();
        foreach ($listG as $r) { $cells[$r['scheme']][$r['ro']] = (isset($cells[$r['scheme']][$r['ro']]) ? $cells[$r['scheme']][$r['ro']] : 0) + 1; }
        $sections = array($this->sec('Summary', array('Check', 'Students'), $summary, $nSum));
        if ($cells) {
            list($mc, $mr) = $this->matrix($cells, 'Scheme', 'Scheme not set', 'RO not found');
            $sections[] = $this->sec('Scheme against RO (over-age students)', $mc, $mr);
        }

        if ($p['sheets'] === 'single') {
            $g = array(array(), array());
            foreach ($listG as $r) { $g[strpos($r['cat'], 'PhD') === 0 ? 1 : 0][] = $r; }
            $sections[] = $make('UG-PG-Diploma over ' . $p['limit_ug'], $g[0], '');
            $sections[] = $make('PhD over ' . $p['limit_phd'], $g[1], '');
        } else {
            $key = $p['sheets'] === 'ro' ? 'ro' : 'scheme';
            $groups = array();
            foreach ($listG as $r) { $groups[$r[$key]][] = $r; }
            uksort($groups, function ($a, $b) use ($groups) {
                $x = count($groups[$b]) - count($groups[$a]); return $x ? $x : strcmp($a, $b);
            });
            foreach ($groups as $label => $set) { $sections[] = $make($label, $set, ''); }
        }
        if ($lata) { $sections[] = $make('Lata Mangeshkar left out', $lata, 'UG / PG / Diploma students of the Lata Mangeshkar scheme over the limit, shown here so nobody is dropped silently.'); }
        $sections[] = $make('DOB mismatch', $mismatch, 'Application DOB and profile DOB differ (or one is missing). Check which is correct before acting on age.');
        $sections[] = $make('Impossible DOBs', $bad, 'Age under 16 or over 75 on the reference date: almost certainly a typing error in the DOB.');

        return array(
            'title' => 'Over-age students - ' . $p['cycle'],
            'subtitle' => 'Awarded and accepted students, age on 1 July ' . $year . '.',
            'sections' => $sections,
        );
    }

    // public only because the closures above call them
    public function status_label($st) { return $this->sw($st); }
    public function dob_label($ymd, $raw) { return $this->dob_show($ymd, $raw); }

    /* ==============================================================
       6. Application made through (Mission)
       ============================================================== */

    private function r_through($p)
    {
        list($from, $to) = $this->cycle_range($p);
        $sql = "SELECT sm.application_no, ad.fullname, ad.middlename, ad.familyname, c.country_name, s.scheme_name, pr.name AS level, sm.status, "
             . "m.mission_name AS made_through "
             . "FROM iccr_status_mapping sm JOIN iccr_student_application_details ad ON ad.application_no = sm.application_no "
             . "LEFT JOIN iccr_countries c ON c.id = ad.nationality LEFT JOIN iccr_scheme s ON s.id = sm.scholarship_id "
             . "LEFT JOIN iccr_programme pr ON pr.id = ad.programme "
             . "LEFT JOIN iccr_student_other_details od ON od.application_no = sm.application_no "
             . "LEFT JOIN iccr_missions m ON m.id = od.application_through ";
        if (!empty($p['appnos'])) {
            $raw = $this->q($sql . "WHERE sm.application_no IN (" . $this->in_list($p['appnos']) . ")", $p['appnos']);
            $scope = 'The application numbers entered.';
        } else {
            $raw = $this->q($sql . "WHERE sm.created BETWEEN ? AND ? AND ad.course_type = 1", array($from, $to));
            $scope = 'Every AYUSH application (course type AYUSH) created in the ' . $p['cycle'] . ' cycle.';
        }
        $seen = array(); $list = array();
        foreach ($raw as $r) { if (!isset($seen[$r['application_no']])) { $seen[$r['application_no']] = $r; $list[] = $r; } }
        usort($list, function ($a, $b) { $x = strcmp((string) $a['made_through'], (string) $b['made_through']); return $x ? $x : strcmp($a['application_no'], $b['application_no']); });

        $rows = array(); $i = 0; $by = array();
        foreach ($list as $r) {
            $i++;
            $mn = ($r['made_through'] === NULL || trim($r['made_through']) === '') ? 'Not recorded' : trim($r['made_through']);
            $by[$mn] = isset($by[$mn]) ? $by[$mn] + 1 : 1;
            $rows[] = array($i, $r['application_no'], $this->nm($r), $r['country_name'], $r['level'] === NULL ? '' : $r['level'],
                ($r['scheme_name'] === NULL || $r['scheme_name'] === '') ? 'Scheme not set' : trim($r['scheme_name']), $this->sw($r['status']), $mn);
        }
        arsort($by);
        $byRows = array();
        foreach ($by as $k => $n) { $byRows[] = array($k, $n); }
        $byRows[] = array('Total', count($list));

        $sections = array(
            $this->sec('Application made through', array('S.No', 'Application No.', 'Name', 'Country', 'Level', 'Scheme', 'Status', 'Application made through'), $rows, $scope),
            $this->sec('By Mission', array('Mission', 'Applications'), $byRows),
        );
        if (!empty($p['appnos'])) {
            $miss = array();
            foreach ($p['appnos'] as $a) { if (!isset($seen[$a])) { $miss[] = array($a); } }
            if ($miss) { $sections[] = $this->sec('Application numbers not found', array('Application No.'), $miss); }
        }
        return array('title' => 'Application made through (Mission)', 'subtitle' => $scope, 'sections' => $sections);
    }

    /* ==============================================================
       7. Student status check
       ============================================================== */

    private function r_case_status($p)
    {
        $in = $this->in_list($p['appnos']);
        $b = $p['appnos'];
        $main = $this->q("SELECT sm.application_no, ad.fullname, ad.middlename, ad.familyname, c.country_name, m.mission_name, pr.name AS level, s.scheme_name, "
            . "sm.status, sm.scholar_acceptance, ad.course_type, FROM_UNIXTIME(sm.created, '%d-%m-%Y') AS applied "
            . "FROM iccr_status_mapping sm JOIN iccr_student_application_details ad ON ad.application_no = sm.application_no "
            . "LEFT JOIN iccr_countries c ON c.id = ad.nationality LEFT JOIN iccr_student_other_details od ON od.application_no = sm.application_no "
            . "LEFT JOIN iccr_missions m ON m.id = od.application_through LEFT JOIN iccr_programme pr ON pr.id = ad.programme "
            . "LEFT JOIN iccr_scheme s ON s.id = sm.scholarship_id WHERE sm.application_no IN (" . $in . ")", $b);
        $univ = $this->q("SELECT us.application_id, un.name AS university, us.status, us.university_remarks "
            . "FROM iccr_university_status_mapping us LEFT JOIN iccr_univercities un ON un.id = us.regional_university "
            . "WHERE us.application_id IN (" . $in . ") ORDER BY us.application_id", $b);
        $resp = $this->q("SELECT ur.application_id, un.name AS university, ur.university_is_accept, ur.confirmed_to_mission, ur.duration_of_course, ur.date_of_joining "
            . "FROM iccr_university_response ur LEFT JOIN iccr_univercities un ON un.id = ur.regional_university "
            . "WHERE ur.application_id IN (" . $in . ") ORDER BY ur.application_id", $b);
        $hq = $this->q("SELECT h.application_id, un.name AS university, h.confirmed_to_mission, h.date_of_joining, h.duration_of_course, "
            . "IF(IFNULL(h.region_one_doc, '') <> '', 'Yes', 'No') AS letter "
            . "FROM iccr_university_response_by_hqrs h LEFT JOIN iccr_univercities un ON un.id = h.regional_university "
            . "WHERE h.application_id IN (" . $in . ") ORDER BY h.application_id", $b);

        $acc = array(1 => 'Accepted', -1 => 'Not accepted yet');
        $rows = array(); $found = array();
        foreach ($main as $r) {
            $found[$r['application_no']] = 1;
            $sa = (int) $r['scholar_acceptance'];
            $rows[] = array($r['application_no'], $this->nm($r), $r['country_name'], $r['mission_name'] === NULL ? '' : $r['mission_name'],
                $r['level'] === NULL ? '' : $r['level'], ($r['scheme_name'] === NULL || $r['scheme_name'] === '') ? 'Scheme not set' : trim($r['scheme_name']),
                ((int) $r['course_type'] === 1) ? 'AYUSH' : 'Normal', $this->sw($r['status']), isset($acc[$sa]) ? $acc[$sa] : 'Code ' . $sa, $r['applied']);
        }
        $u = array();
        foreach ($univ as $r) {
            $st = (int) $r['status'];
            $u[] = array($r['application_id'], ($r['university'] === NULL || $r['university'] === '') ? '[no university name saved]' : $r['university'],
                isset($this->univ_status_words[$st]) ? $this->univ_status_words[$st] : 'Status ' . $st, $r['university_remarks'] === NULL ? '' : $r['university_remarks']);
        }
        $c = array();
        foreach ($resp as $r) {
            $c[] = array($r['application_id'], $r['university'] === NULL ? '' : $r['university'], ((int) $r['confirmed_to_mission'] === 1) ? 'Placed here' : 'Accepted, not chosen',
                $r['date_of_joining'] === NULL ? '-' : $r['date_of_joining'], $r['duration_of_course'] === NULL ? '-' : $r['duration_of_course']);
        }
        $h = array();
        foreach ($hq as $r) {
            $h[] = array($r['application_id'], $r['university'] === NULL ? '' : $r['university'], $r['letter'],
                $r['date_of_joining'] === NULL ? '-' : $r['date_of_joining'], $r['duration_of_course'] === NULL ? '-' : $r['duration_of_course']);
        }
        $sections = array(
            $this->sec('Status', array('Application No.', 'Name', 'Country', 'Mission', 'Level', 'Scheme', 'Type', 'Status', 'Offer', 'Applied on'), $rows),
            $this->sec('University-wise status', array('Application No.', 'University', 'Status', 'University remarks'), $u),
            $this->sec('Confirmed university (placement)', array('Application No.', 'University', 'Placement', 'Joining date', 'Duration (years)'), $c),
            $this->sec('HQ letter (AYUSH)', array('Application No.', 'University', 'Letter uploaded', 'Joining date', 'Duration (years)'), $h),
        );
        $miss = array();
        foreach ($p['appnos'] as $a) { if (!isset($found[$a])) { $miss[] = array($a); } }
        if ($miss) { $sections[] = $this->sec('Application numbers not found', array('Application No.'), $miss); }
        return array('title' => 'Student status check', 'subtitle' => count($p['appnos']) . ' application number(s) entered.', 'sections' => $sections);
    }

    /* ==============================================================
       8. Country slots against awards
       ============================================================== */

    private function r_slots($p)
    {
        list($from, $to) = $this->cycle_range($p);
        if (!$this->CI->db->table_exists('iccr_scheme_country_slots')) {
            return array('title' => 'Country slots against awards - ' . $p['cycle'], 'subtitle' => '',
                'sections' => array($this->sec('Slots table not found', array('Note'), array(array(
                    'The table iccr_scheme_country_slots does not exist on this database yet. Load it first (load_country_slots_2026-27.sql, after approval), then run this report again.')))));
        }
        $b = array($p['cycle']);
        $w = '';
        if (!empty($p['scheme'])) { $w = ' AND cs.scheme_id = ?'; $b[] = $p['scheme']; }
        $slots = $this->q('SELECT cs.scheme_id, s.scheme_name, cs.country_id, c.country_name, cs.slots FROM iccr_scheme_country_slots cs '
            . 'LEFT JOIN iccr_scheme s ON s.id = cs.scheme_id LEFT JOIN iccr_countries c ON c.id = cs.country_id '
            . 'WHERE cs.academic_year = ?' . $w . ' ORDER BY s.scheme_name, c.country_name', $b);
        $b2 = array($from, $to);
        $w2 = '';
        if (!empty($p['scheme'])) { $w2 = ' AND sm.scholarship_id = ?'; $b2[] = $p['scheme']; }
        $aw = $this->q('SELECT sm.scholarship_id AS sid, ad.nationality AS cid, COUNT(*) AS n FROM iccr_status_mapping sm '
            . 'JOIN iccr_student_application_details ad ON ad.application_no = sm.application_no '
            . 'WHERE sm.created BETWEEN ? AND ? AND sm.status IN (' . $this->accepted_in . ') AND sm.scholar_acceptance = 1 AND sm.scholarship_id IS NOT NULL' . $w2
            . ' GROUP BY sm.scholarship_id, ad.nationality', $b2);
        $got = array();
        foreach ($aw as $r) { $got[$r['sid'] . '|' . $r['cid']] = (int) $r['n']; }

        $rows = array(); $per = array(); $used = array(); $totS = 0; $totA = 0; $i = 0;
        foreach ($slots as $r) {
            $k = $r['scheme_id'] . '|' . $r['country_id'];
            $n = isset($got[$k]) ? $got[$k] : 0;
            $used[$k] = 1;
            $i++;
            $rows[] = array($i, trim((string) $r['scheme_name']), trim((string) $r['country_name']), (int) $r['slots'], $n, (int) $r['slots'] - $n);
            $sn = trim((string) $r['scheme_name']);
            if (!isset($per[$sn])) { $per[$sn] = array(0, 0); }
            $per[$sn][0] += (int) $r['slots']; $per[$sn][1] += $n;
            $totS += (int) $r['slots']; $totA += $n;
        }
        $rows[] = array('', 'Total', '', $totS, $totA, $totS - $totA);
        $perRows = array();
        foreach ($per as $k => $v) { $perRows[] = array($k, $v[0], $v[1], $v[0] - $v[1]); }
        $perRows[] = array('Total', $totS, $totA, $totS - $totA);

        $extra = array();
        foreach ($got as $k => $n) {
            if (isset($used[$k])) { continue; }
            list($sid, $cid) = explode('|', $k);
            $extra[] = array($this->scheme_name($sid), $this->country_name($cid), $n);
        }
        $sections = array(
            $this->sec('Scheme and country', array('S.No', 'Scheme', 'Country', 'Slots', 'Awarded and accepted', 'Balance'), $rows,
                'Awarded and accepted = status awarded / visa / arrived with the offer accepted, for applications of the ' . $p['cycle'] . ' cycle. A negative balance means more students than slots.'),
            $this->sec('Scheme totals', array('Scheme', 'Slots', 'Awarded and accepted', 'Balance'), $perRows),
        );
        if ($extra) { $sections[] = $this->sec('Awards with no slot row', array('Scheme', 'Country', 'Awarded and accepted'), $extra, 'These scheme and country pairs have students but no row in the slots table.'); }
        return array('title' => 'Country slots against awards - ' . $p['cycle'], 'subtitle' => '', 'sections' => $sections);
    }
}

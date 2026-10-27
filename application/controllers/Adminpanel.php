<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * A2A Admin Panel  (URL: /adminpanel)
 *
 * Only Super Admin accounts (iccr_users.user_type = 5) can open it, and
 * only after signing in on its OWN sign-in page: /adminlogin
 * (controllers/Adminlogin.php). The normal portal login is not enough.
 * The admin session ends after 15 minutes without activity, or 8 hours
 * after sign-in, and is re-checked against the database on every request.
 *
 * Screens: Dashboard, Announcements, Header menu, Students, Missions,
 * Universities, Accounts, Audit log.
 *
 * Every change is written to iccr_admin_audit_log (old and new value)
 * and to the portal-wide general audit log, audit_log (see Adminpanel_model).
 * Run application/sql/adminpanel_setup_local.sql and
 * application/sql/adminpanel_security_local.sql once before first use.
 */
class Adminpanel extends CI_Controller
{
    const PER_PAGE = 25;
    const IDLE_LIMIT = 900;     // 15 minutes without activity
    const MAX_SESSION = 28800;  // 8 hours after sign-in, at most

    /** Staff account types the Accounts screen manages (students are under Students). */
    private $account_types = array(5 => 'Super Admin', 3 => 'ICCR (HQ)', 4 => 'Regional Office', 2 => 'Mission', 8 => 'University', 7 => 'Agency');

    /** Generic list screens. */
    private $entities = array(
        'missions' => array(
            'table'  => 'iccr_missions',
            'title'  => 'Missions',
            'single' => 'Mission',
            'list'   => array('id', 'mission_name', 'mission_email', 'country', 'mission_type', 'status'),
            'search' => array('mission_name', 'mission_email'),
            'icon'   => 'fa-flag',
        ),
        'universities' => array(
            'table'  => 'iccr_univercities',
            'title'  => 'Universities',
            'single' => 'University',
            'list'   => array('id', 'name', 'title', 'state', 'university_type', 'status'),
            'search' => array('name', 'title'),
            'icon'   => 'fa-university',
        ),
    );

    /** Known meanings of iccr_status_mapping codes, shown as hints next to the fields. */
    public $workflow_hints = array(
        'status' => array('1' => 'Submitted', '4' => 'Recommended by Mission', '5' => 'Rejected by Mission', '6' => 'Documents re-uploaded',
                          '9' => 'Response forwarded to HQ', '10' => 'Confirmed to Mission', '11' => 'Offer accepted', '12' => 'Offer declined',
                          '13' => 'Visa / travel', '14' => 'Arrived', '-14' => 'Not arrived', '15' => 'Withdrawn / excluded'),
        'mission_status' => array('-1' => 'Pending with Mission', '1' => 'Processed / awarded', '2' => 'Rejected by Mission'),
        'universities_status' => array('-1' => 'Not set', '1' => 'Normal (Undertaking tab opens)', '22' => 'AYUSH: Mission Process button on'),
        'iccr_status' => array('-1' => 'Not confirmed', '1' => 'Confirmed by HQ'),
    );

    protected $admin;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'security'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('adminpanel_model', 'ap');

        // Separate admin sign-in: only Adminlogin sets "ap_auth" (after password,
        // captcha and lockout checks). The portal login alone does not get in.
        $auth = $this->session->userdata('ap_auth');
        $now = time();
        $reason = '';
        if (empty($auth['uid'])) {
            $reason = 'login';
        } elseif ($now - (int) $auth['last'] > self::IDLE_LIMIT || $now - (int) $auth['at'] > self::MAX_SESSION) {
            $reason = 'expired';
        } elseif (!hash_equals((string) $auth['ua'], sha1((string) $this->input->user_agent()))) {
            $reason = 'login'; // session cookie used from a different browser
        }
        $user = $reason === '' ? $this->ap->active_super_admin($auth['uid']) : NULL;
        if (!$user) {
            $this->session->unset_userdata('ap_auth');
            if ($this->input->is_ajax_request()) {
                $this->output->set_status_header(401)->set_output('Admin sign-in required')->_display();
                exit;
            }
            redirect('adminlogin' . ($reason === 'expired' ? '?expired=1' : ''));
            exit;
        }
        $auth['last'] = $now;
        $this->session->set_userdata('ap_auth', $auth);
        $this->admin = array(
            'userid' => $user['id'], 'fname' => $user['username'], 'email' => $user['email_id'], 'user_type' => $user['user_type'],
        );
        // Database audit triggers (general audit_log) record this admin as the person making changes
        $this->ap->set_db_identity($this->admin);
        $this->output->set_header('X-Frame-Options: SAMEORIGIN');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('X-Content-Type-Options: nosniff');
        $this->output->set_header('Referrer-Policy: same-origin');
    }

    /* ==============================================================
       Helpers
       ============================================================== */

    private function render($view, $data = array(), $active = '')
    {
        $data['active']  = $active;
        $data['admin']   = $this->admin;
        $data['setup']   = $this->ap->setup_status();
        $data['entities'] = $this->entities;
        $this->load->view('adminpanel/_header', $data);
        $this->load->view('adminpanel/' . $view, $data);
        $this->load->view('adminpanel/_footer', $data);
    }

    private function flash($type, $msg)
    {
        $this->session->set_flashdata('ap_type', $type);
        $this->session->set_flashdata('ap_msg', $msg);
    }

    private function require_post()
    {
        if (strtoupper($this->input->method()) !== 'POST') {
            show_error('This action needs a form submit.', 405);
        }
    }

    /** Raw POST (no xss_clean: values are escaped on output and bound in SQL). */
    private function post()
    {
        $p = $this->input->post(NULL, FALSE);
        return is_array($p) ? $p : array();
    }

    private function page()
    {
        $p = (int) $this->input->get('page');
        return $p > 0 ? $p : 1;
    }

    private function pager($total, $page)
    {
        return array('total' => $total, 'page' => $page, 'pages' => max(1, (int) ceil($total / self::PER_PAGE)), 'per' => self::PER_PAGE);
    }

    /** Text with all HTML tags removed and spaces tidied (for titles shown on public pages). */
    private function plain_text($s)
    {
        $s = strip_tags(html_entity_decode((string) $s, ENT_QUOTES, 'UTF-8'));
        return trim(preg_replace('/\s+/u', ' ', str_replace(array('<', '>'), '', $s)));
    }

    /**
     * Menu links: allow page paths, #, {dashboard}, http(s)://, mailto: and tel: only.
     * Browsers ignore tabs, new lines and control characters inside a link, and
     * decode &#..; entities, so "java&#9;script:" is checked after removing them.
     */
    private function safe_link($url)
    {
        $u = preg_replace('/[\x00-\x20\x7f]+/', '', html_entity_decode((string) $url, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $u)) {
            return (bool) preg_match('/^(https?|mailto|tel):/i', $u);
        }
        return TRUE;
    }

    private function strong_password($p)
    {
        return strlen($p) >= 8 && preg_match('/[a-z]/', $p) && preg_match('/[A-Z]/', $p) && preg_match('/\d/', $p) && preg_match('/[^A-Za-z0-9]/', $p);
    }

    /* ==============================================================
       Dashboard
       ============================================================== */

    public function index()
    {
        $data['counts'] = $this->ap->counts();
        $data['recent'] = $this->ap->recent_audit(8);
        $this->render('dashboard', $data, 'dashboard');
    }

    /* ==============================================================
       Announcements (iccr_notifications)
       ============================================================== */

    public function announcements()
    {
        $data['rows'] = $this->ap->announcements();
        $data['today'] = date('Y-m-d');
        $data['ap'] = $this->ap;
        $this->render('announcements', $data, 'announcements');
    }

    public function announcement($id = NULL)
    {
        $data['row'] = $id ? $this->ap->announcement($id) : NULL;
        if ($id && !$data['row']) { show_404(); }
        $this->render('announcement_form', $data, 'announcements');
    }

    public function announcement_save()
    {
        $this->require_post();
        $p = $this->post();
        $id = isset($p['id']) ? (int) $p['id'] : 0;
        // Plain text only: some public and Mission pages print the title without escaping,
        // so HTML or script in a title would run on those pages.
        $title = $this->plain_text(isset($p['title']) ? $p['title'] : '');
        $upto = trim(isset($p['validated_upto']) ? $p['validated_upto'] : '');

        $back = 'adminpanel/announcement' . ($id ? '/' . $id : '');
        $old = $id ? $this->ap->announcement($id) : NULL;
        if ($id && !$old) { show_404(); }
        if ($title === '' || mb_strlen($title) > 500) {
            $this->flash('error', 'Please enter a title (up to 500 characters).');
            redirect($back);
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $upto)) {
            $this->flash('error', 'Please choose the "Show until" date.');
            redirect($back);
        }
        // Every save goes back to draft (off the home page) until it is
        // previewed and published again. Nothing reaches the public without the preview step.
        $values = array('title' => $title, 'validated_upto' => $upto, 'status' => '0');

        // Optional PDF (checked by content, not by the browser-supplied type)
        if (!empty($_FILES['notification_doc']['name']) && is_uploaded_file($_FILES['notification_doc']['tmp_name'])) {
            $f = $_FILES['notification_doc'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $f['tmp_name']);
            finfo_close($finfo);
            if ($mime !== 'application/pdf' || $f['size'] > 5 * 1024 * 1024) {
                $this->flash('error', 'Attachment must be a PDF under 5 MB.');
                redirect($back);
            }
            $safe = preg_replace('/[^A-Za-z0-9._-]/', '_', pathinfo($f['name'], PATHINFO_FILENAME));
            $name = time() . '_NOTIFICATION_' . substr($safe, 0, 80) . '.pdf';
            $dir = FCPATH . 'assets/site/main/notification/';
            if (!is_dir($dir)) { @mkdir($dir, 0755, TRUE); }
            if (!move_uploaded_file($f['tmp_name'], $dir . $name)) {
                $this->flash('error', 'Could not save the attachment.');
                redirect($back);
            }
            $values['notification_doc'] = $name;
        } elseif (!empty($p['remove_doc']) && $old && !empty($old['notification_doc'])) {
            $values['notification_doc'] = '';
        }
        if (!$id) {
            $values['created'] = date('Y-m-d');
        }
        $res = $this->ap->save_announcement($id, $values, $this->admin);
        if ($res === FALSE) {
            $this->flash('error', 'Could not save. Nothing was changed.');
            redirect($back);
        }
        $new_id = $id ? $id : (int) $res;
        $was_live = $old && $this->ap->announcement_state($old) === 'live';
        $this->flash('info', $was_live
            ? 'Changes saved as a draft, so the announcement is off the home page for now. Check the preview, then publish it again.'
            : 'Saved as a draft. Nothing is on the home page yet. Check the preview, then publish.');
        redirect('adminpanel/announcement_preview/' . $new_id);
    }

    /** What the announcement will look like, with the Publish confirmation. */
    public function announcement_preview($id)
    {
        $row = $this->ap->announcement($id);
        if (!$row) { show_404(); }
        $data = array('row' => $row, 'state' => $this->ap->announcement_state($row), 'today' => date('Y-m-d'));
        $data['live_now'] = array_values(array_filter($this->ap->announcements(), function ($r) use ($id) {
            return (int) $r['id'] !== (int) $id && $this->ap->announcement_state($r) === 'live';
        }));
        $this->render('announcement_preview', $data, 'announcements');
    }

    public function announcement_publish($id)
    {
        $this->require_post();
        $row = $this->ap->announcement($id);
        if (!$row) { show_404(); }
        $back = 'adminpanel/announcement_preview/' . (int) $id;
        if (empty($this->post()['confirm_publish'])) {
            $this->flash('error', 'Tick the box to confirm you checked the preview. Nothing was published.');
            redirect($back);
        }
        if (empty($row['validated_upto']) || $row['validated_upto'] < date('Y-m-d')) {
            $this->flash('error', 'The "Show until" date has passed. Edit the date first, then publish.');
            redirect($back);
        }
        if ($this->ap->announcement_state($row) === 'live') {
            $this->flash('info', 'It is already live on the home page.');
            redirect('adminpanel/announcements');
        }
        $ok = $this->ap->publish_announcement($id, $this->admin);
        $this->flash($ok ? 'success' : 'error', $ok ? 'Published. It is now on the home page.' : 'Database error. Nothing was published.');
        redirect($ok ? 'adminpanel/announcements' : $back);
    }

    /** Take a live announcement off the home page (it can be published again from its preview). */
    public function announcement_unpublish($id)
    {
        $this->require_post();
        $row = $this->ap->announcement($id);
        if (!$row) { show_404(); }
        $this->ap->save_announcement($id, array('status' => '0'), $this->admin);
        $this->flash('success', 'Taken off the home page. Open its preview to publish it again.');
        redirect('adminpanel/announcements');
    }

    public function announcement_delete($id)
    {
        $this->require_post();
        $row = $this->ap->delete_announcement($id, $this->admin);
        if ($row && !empty($row['notification_doc'])) {
            $file = FCPATH . 'assets/site/main/notification/' . basename($row['notification_doc']);
            // Keep the PDF if another announcement still uses it
            if (is_file($file) && !$this->db->where('notification_doc', $row['notification_doc'])->count_all_results('iccr_notifications')) {
                @unlink($file);
            }
        }
        $this->flash($row ? 'success' : 'error', $row ? 'Announcement deleted. Its old text is kept in the audit log.' : 'Could not delete.');
        redirect('adminpanel/announcements');
    }

    /* ==============================================================
       Header navigation (iccr_nav_links)
       ============================================================== */

    public function nav()
    {
        $data['rows'] = $this->ap->nav_tree_flat();
        $this->render('nav', $data, 'nav');
    }

    public function nav_edit($id = NULL)
    {
        $data['row'] = $id ? $this->ap->nav_get($id) : NULL;
        if ($id && !$data['row']) { show_404(); }
        $data['parents'] = $this->ap->nav_tree_flat($id);
        if ($id) {
            $blocked = $this->ap->nav_descendants($id);
            $data['parents'] = array_values(array_filter($data['parents'], function ($r) use ($blocked) {
                return !in_array((int) $r['id'], $blocked, TRUE);
            }));
        }
        $data['preset_parent'] = (int) $this->input->get('parent');
        $this->render('nav_form', $data, 'nav');
    }

    public function nav_save()
    {
        $this->require_post();
        $p = $this->post();
        $id = isset($p['id']) ? (int) $p['id'] : 0;
        $back = 'adminpanel/nav_edit' . ($id ? '/' . $id : '');

        $title = $this->plain_text(isset($p['title']) ? $p['title'] : '');
        $url = trim(isset($p['url']) ? $p['url'] : '');
        $parent = (isset($p['parent_id']) && $p['parent_id'] !== '') ? (int) $p['parent_id'] : NULL;

        $errors = array();
        if ($title === '' || mb_strlen($title) > 150) { $errors[] = 'Title is required (up to 150 characters).'; }
        if (!$this->safe_link($url)) { $errors[] = 'That link type is not allowed. Use a page path, http(s)://, mailto: or tel:.'; }
        if (mb_strlen($url) > 500) { $errors[] = 'Link is too long.'; }
        if ($parent !== NULL) {
            if (!$this->ap->nav_get($parent)) { $errors[] = 'Parent item not found.'; }
            if ($id && in_array($parent, $this->ap->nav_descendants($id), TRUE)) { $errors[] = 'An item cannot be placed inside itself.'; }
            if ($this->ap->nav_depth($parent) >= 2) { $errors[] = 'Menus can be 3 levels deep at most.'; }
        }
        $icon = trim(isset($p['icon']) ? $p['icon'] : '');
        if ($icon !== '' && !preg_match('/^fa-[a-z0-9-]+$/', $icon)) { $errors[] = 'Icon must look like fa-file-pdf-o.'; }
        $pg = (isset($p['page_group']) && $p['page_group'] !== '') ? (int) $p['page_group'] : NULL;

        if ($errors) {
            $this->flash('error', implode(' ', $errors));
            redirect($back);
        }
        $values = array(
            'parent_id'  => $parent,
            'title'      => $title,
            'subtitle'   => mb_substr(trim(isset($p['subtitle']) ? $p['subtitle'] : ''), 0, 150),
            'url'        => $url,
            'icon'       => $icon,
            'position'   => (isset($p['position']) && $p['position'] === 'action') ? 'action' : 'main',
            'visibility' => (isset($p['visibility']) && in_array($p['visibility'], array('all', 'guest', 'user'), TRUE)) ? $p['visibility'] : 'all',
            'page_group' => $pg,
            'new_tab'    => !empty($p['new_tab']) ? 1 : 0,
            'is_active'  => !empty($p['is_active']) ? 1 : 0,
            'sort_order' => isset($p['sort_order']) && preg_match('/^-?\d+$/', $p['sort_order']) ? (int) $p['sort_order'] : 100,
        );
        if ($parent !== NULL) {
            $par = $this->ap->nav_get($parent);
            $values['position'] = $par['position'];
        }
        $res = $this->ap->nav_save($id, $values, $this->admin);
        if ($res === FALSE) {
            $this->flash('error', 'Could not save. Nothing was changed.');
            redirect($back);
        }
        $this->flash('success', 'Menu item saved. The site header now shows the change.');
        redirect('adminpanel/nav');
    }

    public function nav_move($id, $dir)
    {
        $this->require_post();
        $this->ap->nav_move($id, $dir === 'up' ? 'up' : 'down', $this->admin);
        redirect('adminpanel/nav');
    }

    public function nav_toggle($id)
    {
        $this->require_post();
        $row = $this->ap->nav_get($id);
        if (!$row) { show_404(); }
        $this->ap->nav_save($id, array('is_active' => $row['is_active'] ? 0 : 1), $this->admin);
        $this->flash('success', $row['is_active'] ? 'Item hidden from the site.' : 'Item shown on the site.');
        redirect('adminpanel/nav');
    }

    public function nav_delete($id)
    {
        $this->require_post();
        $res = $this->ap->nav_delete($id, $this->admin);
        if ($res === 'has_children') {
            $this->flash('error', 'Move or delete the items inside it first.');
        } else {
            $this->flash($res ? 'success' : 'error', $res ? 'Menu item deleted.' : 'Could not delete.');
        }
        redirect('adminpanel/nav');
    }

    /* ==============================================================
       Students
       ============================================================== */

    public function students()
    {
        $q = trim((string) $this->input->get('q'));
        $year = (int) $this->input->get('year');
        $page = $this->page();
        list($rows, $total) = $this->ap->students($q, $year, self::PER_PAGE, ($page - 1) * self::PER_PAGE);
        $data = array('rows' => $rows, 'q' => $q, 'year' => $year, 'pager' => $this->pager($total, $page));
        $data['status_hints'] = $this->workflow_hints['status'];
        $this->render('students', $data, 'students');
    }

    public function student($uid)
    {
        $s = $this->ap->student($uid);
        if (!$s) { show_404(); }
        $data['s'] = $s;
        $data['ap'] = $this->ap;
        $data['trashed'] = $this->ap->is_trashed('iccr_users', $uid);
        $data['hints'] = $this->workflow_hints;
        $this->render('student', $data, 'students');
    }

    /**
     * Save one section of a student (or any allowed record).
     * POST: table, id, return, fields[...], confirm_workflow
     */
    public function record_save()
    {
        $this->require_post();
        $p = $this->post();
        $table = isset($p['table']) ? $p['table'] : '';
        $id = isset($p['id']) ? $p['id'] : '';
        $return = isset($p['return']) && preg_match('#^adminpanel/[A-Za-z0-9_/\-]+$#', $p['return']) ? $p['return'] : 'adminpanel';

        if (!$this->ap->is_allowed_table($table) || $id === '' || !($old = $this->ap->get_row($table, $id))) {
            $this->flash('error', 'Record not found.');
            redirect($return);
        }
        $is_workflow = !empty($this->ap->tables[$table]['workflow']);
        if ($is_workflow && empty($p['confirm_workflow'])) {
            $this->flash('error', 'Tick "I understand" before changing workflow fields. Nothing was saved.');
            redirect($return);
        }
        $fields = isset($p['fields']) && is_array($p['fields']) ? $p['fields'] : array();
        list($values, $errors) = $this->ap->clean_values($table, $fields, $old);
        if ($errors) {
            $msg = array();
            foreach ($errors as $k => $e) { $msg[] = $k . ': ' . $e; }
            $this->flash('error', 'Not saved. ' . implode(' ', $msg));
            redirect($return);
        }
        $note = trim(isset($p['note']) ? $p['note'] : '');
        $n = $this->ap->update_row($table, $id, $values, $this->admin, $note);
        if ($n === FALSE) {
            $this->flash('error', 'Database error. Nothing was changed.');
        } elseif ($n === 0) {
            $this->flash('info', 'No changes to save.');
        } else {
            $this->flash('success', $n . ' field' . ($n > 1 ? 's' : '') . ' updated in ' . $this->ap->tables[$table]['label'] . '. Logged in the audit trail.');
        }
        redirect($return);
    }

    public function student_new()
    {
        $data['countries'] = $this->ap->countries();
        $data['old'] = (array) $this->session->flashdata('ap_old');
        $this->render('student_add', $data, 'students');
    }

    public function student_create()
    {
        $this->require_post();
        $p = $this->post();
        $g = function ($k) use ($p) { return isset($p[$k]) ? trim((string) $p[$k]) : ''; };

        $errors = array();
        $email = strtolower($g('email_id'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Enter a valid email.'; }
        elseif ($this->ap->email_exists($email)) { $errors[] = 'That email is already registered.'; }
        if ($g('username') === '') { $errors[] = 'First name is required.'; }
        if (!ctype_digit($g('user_country'))) { $errors[] = 'Choose a country.'; }
        if (!preg_match('/^[A-Za-z0-9]{5,15}$/', $g('passport_no'))) { $errors[] = 'Passport number: 5-15 letters/numbers.'; }
        $dob = $g('dob');
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dob, $dm)) { $errors[] = 'Choose a date of birth.'; }
        $pw = isset($p['password']) ? (string) $p['password'] : '';
        if (!$this->strong_password($pw)) { $errors[] = 'Password: 8+ characters with upper and lower case, a number and a symbol.'; }

        if ($errors) {
            $keep = $p; unset($keep['password']);
            $this->session->set_flashdata('ap_old', $keep);
            $this->flash('error', implode(' ', $errors));
            redirect('adminpanel/student_new');
        }
        $acc = array(
            'username' => $g('username'), 'student_mname' => $g('student_mname'), 'student_lname' => $g('student_lname'),
            'student_title' => $g('student_title'), 'email_id' => $email, 'password' => sha1($pw),
            'mobile_no' => $g('mobile_no'), 'user_type' => 1, 'status' => 1, 'apply_course_type' => (int) $g('apply_course_type'),
            'created' => date('Y-m-d H:i:s'), 'state' => 0, 'student_type' => 1, 'user_country' => (int) $g('user_country'),
            'parent_type' => 0, 'unique_id' => '', 'passport_file' => '', 'dir' => '',
        );
        $det = array(
            'country_of_domicile' => (int) $g('user_country'), 'gender' => $g('gender'), 'passport_no' => strtoupper($g('passport_no')),
            'date_of_birth' => $dm[3] . '/' . $dm[2] . '/' . $dm[1], 'mobile_number' => $g('mobile_no'), 'currently_in_india' => 0,
            'created' => date('Y-m-d H:i:s'), 'student_type' => 1, 'apply_course_type' => (int) $g('apply_course_type'),
        );
        $uid = $this->ap->create_student($acc, $det, $this->admin);
        if (!$uid) {
            $this->flash('error', 'Database error. The student was not created.');
            redirect('adminpanel/student_new');
        }
        $this->flash('success', 'Student account created. They can log in with this email and the password you set (registration year ' . date('Y') . ').');
        redirect('adminpanel/student/' . $uid);
    }

    /* ==============================================================
       Missions / Universities
       ============================================================== */

    private function entity_conf($name)
    {
        if (!isset($this->entities[$name])) { show_404(); }
        return $this->entities[$name];
    }

    public function entity($name)
    {
        $e = $this->entity_conf($name);
        $q = trim((string) $this->input->get('q'));
        $page = $this->page();
        list($rows, $total) = $this->ap->entity_list($e['table'], $e['search'], $q, self::PER_PAGE, ($page - 1) * self::PER_PAGE);
        $cols = $this->ap->visible_columns($e['table']);
        $list = array_values(array_filter($e['list'], function ($c) use ($cols) { return isset($cols[$c]); }));
        if (!$list) { $list = array_slice(array_keys($cols), 0, 6); }
        $data = array('e' => $e, 'name' => $name, 'rows' => $rows, 'q' => $q, 'list' => $list, 'pk' => $this->ap->primary_key($e['table']),
                      'pager' => $this->pager($total, $page), 'has_status' => isset($cols['status']));
        $this->render('entity_list', $data, $name);
    }

    public function entity_edit($name, $id = NULL)
    {
        $e = $this->entity_conf($name);
        $row = $id !== NULL ? $this->ap->get_row($e['table'], $id) : NULL;
        if ($id !== NULL && !$row) { show_404(); }
        $data = array('e' => $e, 'name' => $name, 'row' => $row, 'cols' => $this->ap->editable_columns($e['table']),
                      'all' => $this->ap->visible_columns($e['table']), 'pk' => $this->ap->primary_key($e['table']),
                      'trashed' => $row ? $this->ap->is_trashed($e['table'], $id) : FALSE);
        $this->render('entity_form', $data, $name);
    }

    public function entity_save($name)
    {
        $this->require_post();
        $e = $this->entity_conf($name);
        $p = $this->post();
        $id = isset($p['id']) && $p['id'] !== '' ? $p['id'] : NULL;
        $old = $id !== NULL ? $this->ap->get_row($e['table'], $id) : NULL;
        if ($id !== NULL && !$old) { show_404(); }
        $fields = isset($p['fields']) && is_array($p['fields']) ? $p['fields'] : array();
        list($values, $errors) = $this->ap->clean_values($e['table'], $fields, $old);
        $back = 'adminpanel/entity_edit/' . $name . ($id !== NULL ? '/' . $id : '');
        if ($errors) {
            $msg = array();
            foreach ($errors as $k => $er) { $msg[] = $k . ': ' . $er; }
            $this->flash('error', 'Not saved. ' . implode(' ', $msg));
            redirect($back);
        }
        if ($id !== NULL) {
            $n = $this->ap->update_row($e['table'], $id, $values, $this->admin);
            $this->flash($n === FALSE ? 'error' : 'success', $n === FALSE ? 'Database error. Nothing changed.' : ($n ? $e['single'] . ' updated.' : 'No changes to save.'));
            redirect($back);
        }
        $cols = $this->ap->columns($e['table']);
        if (isset($cols['created']) && !isset($values['created'])) {
            $values['created'] = $cols['created']['base'] === 'int' ? time() : date('Y-m-d H:i:s');
        }
        $new = $this->ap->insert_row($e['table'], $values, $this->admin);
        $this->flash($new ? 'success' : 'error', $new ? $e['single'] . ' added.' : 'Database error. Nothing added.');
        redirect($new ? 'adminpanel/entity_edit/' . $name . '/' . $new : $back);
    }

    public function entity_status($name, $id)
    {
        $this->require_post();
        $e = $this->entity_conf($name);
        $row = $this->ap->get_row($e['table'], $id);
        if (!$row || !array_key_exists('status', $row)) { show_404(); }
        $new = ((string) $row['status'] === '1') ? '0' : '1';
        $this->ap->update_row($e['table'], $id, array('status' => $new), $this->admin, 'Status toggled');
        $this->flash('success', $e['single'] . ($new === '1' ? ' activated.' : ' deactivated.'));
        redirect('adminpanel/entity/' . $name);
    }

    /* ==============================================================
       Accounts (staff logins)
       ============================================================== */

    public function accounts()
    {
        $type = (int) $this->input->get('type');
        if (!isset($this->account_types[$type])) { $type = 5; }
        $q = trim((string) $this->input->get('q'));
        $page = $this->page();
        list($rows, $total) = $this->ap->accounts($type, $q, self::PER_PAGE, ($page - 1) * self::PER_PAGE);
        $data = array('rows' => $rows, 'type' => $type, 'types' => $this->account_types, 'q' => $q, 'pager' => $this->pager($total, $page));
        $this->render('accounts', $data, 'accounts');
    }

    public function account($id = NULL)
    {
        $row = $id ? $this->ap->account($id) : NULL;
        if ($id && !$row) { show_404(); }
        $data = array('row' => $row, 'types' => $this->account_types, 'preset_type' => (int) $this->input->get('type'),
                      'trashed' => $row ? $this->ap->is_trashed('iccr_users', $id) : FALSE);
        $this->render('account_form', $data, 'accounts');
    }

    public function account_save()
    {
        $this->require_post();
        $p = $this->post();
        $id = isset($p['id']) ? (int) $p['id'] : 0;
        $g = function ($k) use ($p) { return isset($p[$k]) ? trim((string) $p[$k]) : ''; };
        $back = 'adminpanel/account' . ($id ? '/' . $id : '');
        if ($id && !$this->ap->account($id)) { show_404(); }
        $email = strtolower($g('email_id'));
        $type = (int) $g('user_type');
        $errors = array();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Enter a valid email.'; }
        elseif ($this->ap->email_exists($email, $id ?: NULL)) { $errors[] = 'That email is already used by another login.'; }
        if (!isset($this->account_types[$type])) { $errors[] = 'Choose a role.'; }
        if ($g('username') === '') { $errors[] = 'Name is required.'; }
        $pw = isset($p['password']) ? (string) $p['password'] : '';
        if (!$id && !$this->strong_password($pw)) { $errors[] = 'Password: 8+ characters with upper and lower case, a number and a symbol.'; }
        if ($id === (int) $this->admin['userid'] && $type !== 5) { $errors[] = 'You cannot remove Super Admin from your own account.'; }
        if ($errors) {
            $this->flash('error', implode(' ', $errors));
            redirect($back);
        }
        $values = array('username' => $g('username'), 'email_id' => $email, 'user_type' => $type);
        foreach (array('user_country', 'university', 'state') as $k) {
            if ($g($k) !== '' && ctype_digit(ltrim($g($k), '-'))) { $values[$k] = (int) $g($k); }
        }
        if ($id) {
            $n = $this->ap->update_row('iccr_users', $id, $values, $this->admin, 'Account edited');
            $this->flash($n === FALSE ? 'error' : 'success', $n === FALSE ? 'Database error.' : ($n ? 'Account updated.' : 'No changes to save.'));
            redirect($back);
        }
        $values += array('password' => sha1($pw), 'status' => 1, 'created' => date('Y-m-d H:i:s'), 'parent_type' => 0,
                         'student_mname' => '', 'student_lname' => '', 'student_title' => '', 'unique_id' => '', 'mobile_no' => '',
                         'apply_course_type' => 0, 'student_type' => 0, 'passport_file' => '', 'dir' => '');
        $values += array('state' => 0, 'user_country' => 0);
        $new = $this->ap->insert_row('iccr_users', $values, $this->admin, 'Account created');
        $this->flash($new ? 'success' : 'error', $new ? 'Account created. They log in on the home page with "Are you an applicant?" = No.' : 'Database error.');
        redirect($new ? 'adminpanel/account/' . $new : $back);
    }

    public function account_password($id)
    {
        $this->require_post();
        $row = $this->ap->account($id);
        if (!$row) { show_404(); }
        $p = $this->post();
        $pw = isset($p['password']) ? (string) $p['password'] : '';
        $pw2 = isset($p['password2']) ? (string) $p['password2'] : '';
        if (!$this->strong_password($pw)) {
            $this->flash('error', 'Password: 8+ characters with upper and lower case, a number and a symbol.');
        } elseif ($pw !== $pw2) {
            $this->flash('error', 'The two passwords do not match.');
        } else {
            $ok = $this->ap->set_password($id, sha1($pw), $this->admin);
            $this->flash($ok ? 'success' : 'error', $ok ? 'Password changed.' : 'Database error.');
        }
        redirect('adminpanel/account/' . (int) $id);
    }

    public function account_status($id)
    {
        $this->require_post();
        $row = $this->ap->account($id);
        if (!$row) { show_404(); }
        if ((int) $id === (int) $this->admin['userid']) {
            $this->flash('error', 'You cannot deactivate your own account.');
            redirect('adminpanel/accounts?type=' . (int) $row['user_type']);
        }
        $new = ((string) $row['status'] === '1') ? 0 : 1;
        $this->ap->update_row('iccr_users', $id, array('status' => $new), $this->admin, 'Status toggled');
        $this->flash('success', $new ? 'Account activated.' : 'Account deactivated. It can no longer log in.');
        redirect('adminpanel/accounts?type=' . (int) $row['user_type']);
    }

    /** Activate / deactivate a student login. */
    public function student_status($uid)
    {
        $this->require_post();
        $row = $this->ap->get_row('iccr_users', $uid);
        if (!$row || (int) $row['user_type'] !== 1) { show_404(); }
        $new = ((string) $row['status'] === '1') ? 0 : 1;
        $this->ap->update_row('iccr_users', $uid, array('status' => $new), $this->admin, 'Student login status toggled');
        $this->flash('success', $new ? 'Student login activated.' : 'Student login deactivated.');
        redirect('adminpanel/student/' . (int) $uid);
    }

    public function student_password($uid)
    {
        $this->require_post();
        $row = $this->ap->get_row('iccr_users', $uid);
        if (!$row || (int) $row['user_type'] !== 1) { show_404(); }
        $p = $this->post();
        $pw = isset($p['password']) ? (string) $p['password'] : '';
        if (!$this->strong_password($pw)) {
            $this->flash('error', 'Password: 8+ characters with upper and lower case, a number and a symbol.');
        } else {
            $ok = $this->ap->set_password($uid, sha1($pw), $this->admin);
            $this->flash($ok ? 'success' : 'error', $ok ? 'Student password changed.' : 'Database error.');
        }
        redirect('adminpanel/student/' . (int) $uid);
    }

    /* ==============================================================
       Delete (soft) and Trash
       ============================================================== */

    private function reason()
    {
        $p = $this->post();
        return trim(isset($p['reason']) ? (string) $p['reason'] : '');
    }

    public function student_delete($uid)
    {
        $this->require_post();
        $row = $this->ap->get_row('iccr_users', $uid);
        if (!$row || (int) $row['user_type'] !== 1) { show_404(); }
        if ($this->reason() === '') {
            $this->flash('error', 'Give a reason for deleting. Nothing was changed.');
            redirect('adminpanel/student/' . (int) $uid);
        }
        $label = trim($row['username'] . ' ' . $row['student_lname']) . ' <' . $row['email_id'] . '>';
        $res = $this->ap->trash('iccr_users', $uid, 'Student: ' . $label, $this->reason(), $this->admin);
        $this->flash($res === TRUE ? 'success' : 'error', $res === TRUE ? 'Student moved to Trash. Their login is off; applications are untouched. Restore it from Trash if needed.' : $res);
        redirect($res === TRUE ? 'adminpanel/students' : 'adminpanel/student/' . (int) $uid);
    }

    public function account_delete($id)
    {
        $this->require_post();
        $row = $this->ap->account($id);
        if (!$row) { show_404(); }
        $back = 'adminpanel/account/' . (int) $id;
        if ((int) $id === (int) $this->admin['userid']) {
            $this->flash('error', 'You cannot delete your own account.');
            redirect($back);
        }
        if ((int) $row['user_type'] === 5 && (string) $row['status'] === '1' && $this->ap->active_super_admin_count() <= 1) {
            $this->flash('error', 'This is the last active Super Admin. Create another one first.');
            redirect($back);
        }
        if ($this->reason() === '') {
            $this->flash('error', 'Give a reason for deleting. Nothing was changed.');
            redirect($back);
        }
        $label = (isset($this->account_types[(int) $row['user_type']]) ? $this->account_types[(int) $row['user_type']] : 'Login') . ': ' . $row['username'] . ' <' . $row['email_id'] . '>';
        $res = $this->ap->trash('iccr_users', $id, $label, $this->reason(), $this->admin);
        $this->flash($res === TRUE ? 'success' : 'error', $res === TRUE ? 'Login moved to Trash. It can no longer sign in.' : $res);
        redirect($res === TRUE ? 'adminpanel/accounts?type=' . (int) $row['user_type'] : $back);
    }

    public function entity_delete($name, $id)
    {
        $this->require_post();
        $e = $this->entity_conf($name);
        $row = $this->ap->get_row($e['table'], $id);
        if (!$row) { show_404(); }
        $back = 'adminpanel/entity_edit/' . $name . '/' . rawurlencode($id);
        if ($this->reason() === '') {
            $this->flash('error', 'Give a reason for deleting. Nothing was changed.');
            redirect($back);
        }
        $title = '';
        foreach (array('mission_name', 'name', 'title') as $k) { if (!empty($row[$k])) { $title = $row[$k]; break; } }
        $res = $this->ap->trash($e['table'], $id, $e['single'] . ': ' . ($title !== '' ? $title : '#' . $id), $this->reason(), $this->admin);
        $this->flash($res === TRUE ? 'success' : 'error', $res === TRUE ? $e['single'] . ' moved to Trash and switched off. Restore it from Trash if needed.' : $res);
        redirect($res === TRUE ? 'adminpanel/entity/' . $name : $back);
    }

    public function trash()
    {
        $type = (string) $this->input->get('type');
        if (!isset($this->ap->trash_tables[$type])) { $type = ''; }
        $data = array('rows' => $this->ap->trash_list($type), 'type' => $type, 'types' => $this->ap->trash_tables, 'ready' => $this->ap->trash_ready());
        $this->render('trash', $data, 'trash');
    }

    public function trash_restore($trash_id)
    {
        $this->require_post();
        $t = $this->ap->restore($trash_id, $this->admin);
        $this->flash($t ? 'success' : 'error', $t ? 'Restored: ' . $t['label'] . '. Its old status is back.' : 'Could not restore (already restored?).');
        redirect('adminpanel/trash');
    }

    /** Recent Admin Panel sign-in attempts. */
    public function logins()
    {
        $data = array('rows' => $this->ap->login_history(100), 'ready' => $this->ap->login_setup_ok());
        $this->render('logins', $data, 'logins');
    }

    /* ==============================================================
       Audit log
       ============================================================== */

    public function audit()
    {
        $f = array('table' => trim((string) $this->input->get('table')), 'record' => trim((string) $this->input->get('record')), 'q' => trim((string) $this->input->get('q')));
        $page = $this->page();
        list($rows, $total) = $this->ap->audit_list($f, self::PER_PAGE, ($page - 1) * self::PER_PAGE);
        $data = array('rows' => $rows, 'f' => $f, 'pager' => $this->pager($total, $page));
        $this->render('audit', $data, 'audit');
    }

    /** General audit log (table audit_log): every recorded data change, from any screen. */
    public function general_audit()
    {
        $g = function ($k) { return trim((string) $this->input->get($k)); };
        $date = function ($v) { return preg_match('/^\d{4}-\d{2}-\d{2}$/', $v) ? $v : ''; };
        $f = array(
            'table'  => $g('table'),
            'app'    => $g('app'),
            'action' => in_array($g('action'), array('INSERT', 'UPDATE', 'DELETE'), TRUE) ? $g('action') : '',
            'from'   => $date($g('from')),
            'to'     => $date($g('to')),
            'q'      => $g('q'),
        );
        $page = $this->page();
        list($rows, $total) = $this->ap->general_audit_list($f, self::PER_PAGE, ($page - 1) * self::PER_PAGE);
        $data = array('rows' => $rows, 'f' => $f, 'pager' => $this->pager($total, $page),
                      'tables' => $this->ap->general_audit_tables(), 'ready' => $this->ap->general_audit_ready());
        $this->render('general_audit', $data, 'general_audit');
    }

    /* ==============================================================
       Gyan Setu export  (added 26 Oct 2026; data built by libraries/Gyansetu_export.php)
       ============================================================== */

    /** Reads the form and returns [year, appNos, idsText, hide, format].
     *  The form uses GET: it only reads data, and GET avoids stale CSRF tokens after a file download. */
    private function gyansetu_input()
    {
        $p = $this->input->get(NULL, FALSE);
        if (!is_array($p)) { $p = array(); }
        $year = preg_replace('/\D/', '', isset($p['year']) ? (string) $p['year'] : '');
        if (strlen($year) !== 4) { $year = date('Y'); }
        $idsText = isset($p['ids']) ? trim((string) $p['ids']) : '';
        preg_match_all('/[A-Za-z]{2}\d{13}/', $idsText, $m);
        $appNos = array_values(array_unique(array_map('strtoupper', $m[0])));
        $hide = !empty($p['hide']);
        $format = (isset($p['format']) && $p['format'] === 'csv') ? 'csv' : 'xlsx';
        return array($year, $appNos, $idsText, $hide, $format);
    }

    public function gyansetu()
    {
        $this->load->library('gyansetu_export', NULL, 'gs');
        $data = array('year' => date('Y'), 'ids_text' => '', 'hide' => FALSE, 'format' => 'xlsx',
                      'rows' => NULL, 'missing' => array(), 'columns' => $this->gs->columns);

        if (in_array($this->input->get('do'), array('preview', 'download'), TRUE)) {
            list($year, $appNos, $idsText, $hide, $format) = $this->gyansetu_input();
            @set_time_limit(300);
            @ini_set('memory_limit', '512M');
            $rows = $this->gs->build_rows($year, $appNos);

            $columns = $this->gs->columns;
            if ($hide) {
                $columns = array_values(array_diff($columns, $this->gs->sensitive));
            }
            $found = array();
            foreach ($rows as $r) { $found[$r['application_no']] = true; }
            $missing = array_values(array_filter($appNos, function ($a) use ($found) { return !isset($found[$a]); }));

            if ($this->input->get('do') === 'download') {
                $this->ap->audit($this->admin, 'export', 'gyansetu_export', $year, '', NULL, (string) count($rows),
                    ($appNos ? 'IDs: ' . implode(',', $appNos) : 'All students') . ($hide ? ' (personal details left out)' : ''));
                $this->gyansetu_send($rows, $columns, $year, $format);
                return;
            }
            $data = array_merge($data, array('year' => $year, 'ids_text' => $idsText, 'hide' => $hide, 'format' => $format,
                                             'rows' => $rows, 'missing' => $missing, 'columns' => $columns));
        }
        $this->render('gyansetu', $data, 'gyansetu');
    }

    /** Sends the rows as .xlsx (written by the library, no PHPExcel) or .csv. Every cell is text so phone numbers keep their digits. */
    private function gyansetu_send($rows, $columns, $year, $format)
    {
        $name = 'Gyan_Setu_' . $year . '_' . count($rows) . '_students_' . date('d-m-Y');

        if ($format === 'xlsx') {
            $path = $this->gs->write_xlsx($columns, $rows);
            if ($path !== FALSE) {
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $name . '.xlsx"');
                header('Content-Length: ' . filesize($path));
                header('Cache-Control: no-store');
                readfile($path);
                @unlink($path);
                exit;
            }
            // No ZipArchive on this server: fall through and send CSV instead
        }

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $name . '.csv"');
        header('Cache-Control: no-store');
        $fh = fopen('php://output', 'w');
        fwrite($fh, "\xEF\xBB\xBF"); // so Excel reads UTF-8 names correctly
        fputcsv($fh, $columns);
        foreach ($rows as $r) {
            $line = array();
            foreach ($columns as $c) { $line[] = (string) $r[$c]; }
            fputcsv($fh, $line);
        }
        fclose($fh);
        exit;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Separate sign-in for the Admin Panel.
 *
 * URLs (no routes needed):
 *   adminlogin                sign-in form (GET) and sign-in attempt (POST)
 *   adminlogin/captcha        the captcha picture for the form
 *   adminlogin/logout         ends the admin session
 *
 * Why a separate sign-in: signing in on the normal portal login no longer
 * opens the Admin Panel. Adminpanel.php only lets a request in when the
 * session carries "ap_auth", and only this controller sets it, after:
 *   - email + password of an ACTIVE Super Admin (iccr_users.user_type = 5)
 *   - a one-time captcha
 *   - fewer than 5 failed tries for that email or that IP in 15 minutes
 * The password never travels in plain text: the browser sends
 * sha1( sha1(password) + one-time salt ), the same way the portal login does.
 * Every attempt (good or bad) is written to iccr_admin_login_attempts.
 */
class Adminlogin extends CI_Controller
{
    const MAX_FAILS   = 5;    // failed tries allowed ...
    const FAIL_WINDOW = 900;  // ... within this many seconds (15 min)

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');
        $this->load->model('adminpanel_model', 'ap');
        $this->output->set_header('X-Frame-Options: DENY');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('X-Robots-Tag: noindex, nofollow');
        $this->output->set_header('X-Content-Type-Options: nosniff');
        $this->output->set_header('Referrer-Policy: same-origin');
    }

    /** GET: show the form. POST: check the sign-in. */
    public function index()
    {
        if (strtoupper($this->input->method()) === 'POST') {
            $this->attempt();
            return;
        }
        // Already signed in to the panel -> straight in
        $auth = $this->session->userdata('ap_auth');
        if (!empty($auth['uid']) && $this->ap->active_super_admin($auth['uid'])) {
            redirect('adminpanel');
        }
        $this->show_form((string) $this->session->flashdata('ap_login_email'));
    }

    private function show_form($email = '')
    {
        // New one-time salt and captcha every time the form is shown
        $salt = bin2hex(random_bytes(16));
        $this->session->set_userdata('ap_login_salt', $salt);
        $this->session->set_userdata('ap_login_captcha', $this->new_code());

        $data = array(
            'salt'   => $salt,
            'email'  => $email,
            'msg'    => $this->session->flashdata('ap_login_msg'),
            'msg_ok' => $this->input->get('out') ? 'You have signed out.' : ($this->input->get('expired') ? 'Your admin session ended after 15 minutes without activity. Please sign in again.' : ''),
            'setup'  => $this->ap->login_setup_ok(),
        );
        $this->load->view('adminpanel/login', $data);
    }

    private function fail($msg, $email)
    {
        $this->session->set_flashdata('ap_login_msg', $msg);
        $this->session->set_flashdata('ap_login_email', $email);
        redirect('adminlogin');
    }

    private function attempt()
    {
        $email   = strtolower(trim((string) $this->input->post('email', FALSE)));
        $hash    = strtolower(trim((string) $this->input->post('pass_hash', FALSE)));
        $captcha = trim((string) $this->input->post('captcha', FALSE));
        $ip      = (string) $this->input->ip_address();

        // One-time values: read, then remove straight away so they cannot be replayed
        $salt = (string) $this->session->userdata('ap_login_salt');
        $code = (string) $this->session->userdata('ap_login_captcha');
        $this->session->unset_userdata(array('ap_login_salt', 'ap_login_captcha'));

        if (!$this->ap->login_setup_ok()) {
            $this->fail('Admin sign-in is not set up yet. Run application/sql/adminpanel_security_local.sql first.', $email);
        }

        // Locked out?
        $wait = $this->ap->login_lock_seconds($email, $ip, self::MAX_FAILS, self::FAIL_WINDOW);
        if ($wait > 0) {
            $this->ap->login_log($email, $ip, 0, 'locked');
            $this->fail('Too many failed sign-ins. Try again in ' . max(1, (int) ceil($wait / 60)) . ' minute(s).', $email);
        }

        // Captcha (never accept an empty one)
        if ($code === '' || $captcha === '' || !hash_equals(strtolower($code), strtolower($captcha))) {
            $this->ap->login_log($email, $ip, 0, 'captcha');
            $this->fail('The security code did not match. Please try again.', $email);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[0-9a-f]{40}$/', $hash) || $salt === '') {
            $this->ap->login_log($email, $ip, 0, 'bad_input');
            $this->fail('Email or password is wrong.', $email);
        }

        $user = $this->ap->super_admin_by_email($email);
        $ok = FALSE;
        if ($user) {
            $expected = sha1(strtolower((string) $user['password']) . $salt);
            $ok = hash_equals($expected, $hash);
        } else {
            sha1($salt . $hash); // similar work either way, so timing does not reveal valid emails
        }
        if (!$ok) {
            $this->ap->login_log($email, $ip, 0, $user ? 'password' : 'unknown_or_not_admin');
            $left = self::MAX_FAILS - $this->ap->login_fail_count($email, $ip, self::FAIL_WINDOW);
            $this->fail('Email or password is wrong.' . ($left > 0 && $left <= 2 ? ' ' . $left . ' tr' . ($left === 1 ? 'y' : 'ies') . ' left before a 15-minute lock.' : ''), $email);
        }

        // Success: fresh session ID, then mark the session as admin-signed-in
        $this->session->sess_regenerate(FALSE);
        $now = time();
        $this->session->set_userdata('ap_auth', array(
            'uid'   => (int) $user['id'],
            'at'    => $now,
            'last'  => $now,
            'ua'    => sha1((string) $this->input->user_agent()),
        ));
        // Same user_data the portal login sets, so the "Classic admin" link keeps working
        $this->session->set_userdata('user_data', array(
            'userid' => $user['id'], 'fname' => $user['username'], 'email' => $user['email_id'], 'user_type' => $user['user_type'],
            'state' => $user['state'], 'university' => $user['university'], 'user_country' => $user['user_country'],
            'created' => $user['created'], 'apply_course_type' => $user['apply_course_type'],
            'student_type' => $user['student_type'], 'dir' => $user['dir'],
        ));
        $this->ap->login_log($email, $ip, 1, 'ok', (int) $user['id']);
        $this->ap->audit(array('userid' => $user['id'], 'email' => $user['email_id']), 'login', 'iccr_users', $user['id'], '', NULL, NULL, 'Signed in to the Admin Panel');
        redirect('adminpanel');
    }

    /** Captcha picture (PNG) for the code stored in the session. */
    public function captcha()
    {
        $code = (string) $this->session->userdata('ap_login_captcha');
        if ($code === '' || !function_exists('imagecreatetruecolor')) {
            show_404();
        }
        $w = 160; $h = 48;
        $im = imagecreatetruecolor($w, $h);
        $bg = imagecolorallocate($im, 242, 246, 252);
        imagefilledrectangle($im, 0, 0, $w, $h, $bg);
        for ($i = 0; $i < 6; $i++) {
            $c = imagecolorallocate($im, mt_rand(150, 200), mt_rand(160, 210), mt_rand(190, 230));
            imageline($im, mt_rand(0, $w), mt_rand(0, $h), mt_rand(0, $w), mt_rand(0, $h), $c);
        }
        for ($i = 0; $i < 220; $i++) {
            $c = imagecolorallocate($im, mt_rand(120, 220), mt_rand(120, 220), mt_rand(150, 230));
            imagesetpixel($im, mt_rand(0, $w - 1), mt_rand(0, $h - 1), $c);
        }
        $font = FCPATH . 'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf';
        $x = 14;
        for ($i = 0; $i < strlen($code); $i++) {
            $c = imagecolorallocate($im, mt_rand(10, 60), mt_rand(30, 70), mt_rand(90, 140));
            if (function_exists('imagettftext') && is_file($font)) {
                imagettftext($im, 22, mt_rand(-14, 14), $x, 35, $c, $font, $code[$i]);
                $x += 23;
            } else {
                imagestring($im, 5, $x, mt_rand(12, 20), $code[$i], $c);
                $x += 22;
            }
        }
        header('Content-Type: image/png');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        imagepng($im);
        imagedestroy($im);
        exit;
    }

    /** New code for the captcha picture (used by the refresh link). */
    public function captcha_refresh()
    {
        $this->session->set_userdata('ap_login_captcha', $this->new_code());
        $this->output->set_content_type('application/json')->set_output(json_encode(array('ok' => TRUE)));
    }

    public function logout()
    {
        $auth = $this->session->userdata('ap_auth');
        if (!empty($auth['uid'])) {
            $u = $this->session->userdata('user_data');
            $this->ap->audit(array('userid' => $auth['uid'], 'email' => isset($u['email']) ? $u['email'] : ''), 'logout', 'iccr_users', $auth['uid'], '', NULL, NULL, 'Signed out of the Admin Panel');
        }
        $this->session->unset_userdata(array('ap_auth', 'user_data'));
        $this->session->sess_destroy();
        redirect('adminlogin?out=1');
    }

    private function new_code()
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // no 0/O, 1/I
        $s = '';
        for ($i = 0; $i < 6; $i++) {
            $s .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $s;
    }
}

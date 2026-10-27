<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * GET /session_ping
 * Called by assets/site/main/js/a2a-session.js while the user is active, so
 * the server session (config.php sess_expiration = 30 min of inactivity) does
 * not run out while someone is still typing into a long form.
 * Loading the session on this request refreshes it. Returns JSON only.
 */
class Session_ping extends CI_Controller
{
    public function index()
    {
        $this->load->library('session');
        $u = $this->session->userdata('user_data');
        $this->output
            ->set_content_type('application/json')
            ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
            ->set_output(json_encode(array(
                'loggedIn'  => !empty($u),
                'idleLimit' => (int) $this->config->item('sess_expiration'),
            )));
    }
}

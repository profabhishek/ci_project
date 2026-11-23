<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * /lang/set/hi  or  /lang/set/en
 * Saves the visitor's language choice in a cookie for 1 year and returns to
 * the page they came from (same site only).
 */
class Lang extends CI_Controller
{
    public function set($code = 'en')
    {
        $this->config->load('a2a_site', TRUE);
        $langs = $this->config->item('a2a_languages', 'a2a_site');
        $code = isset($langs[$code]) ? $code : 'en';
        $this->input->set_cookie(array(
            'name' => 'a2a_lang', 'value' => $code, 'expire' => 31536000,
            'httponly' => TRUE, 'secure' => is_https(),
        ));
        $back = (string) $this->input->get('r');
        // Only allow a path on this site (blocks //evil.com and http:// links)
        if ($back === '' || $back[0] !== '/' || (isset($back[1]) && ($back[1] === '/' || $back[1] === '\\'))) {
            $back = '/';
        }
        $this->output->set_header('Cache-Control: no-store');
        redirect(rtrim(site_url(), '/') . $this->_relative($back));
    }

    // site_url() may include a sub-folder (e.g. /ci_project/). Strip it from the path once.
    private function _relative($path)
    {
        $base = parse_url(site_url(), PHP_URL_PATH);
        $base = rtrim((string) $base, '/');
        if ($base !== '' && strpos($path, $base . '/') === 0) { $path = substr($path, strlen($base)); }
        return $path === '' ? '/' : $path;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Friendly page when a form's security token has expired or is missing
 * (test case 1085, Nov 2026).
 *
 * CodeIgniter's default is a bare "The action you have requested is not
 * allowed." page. The request is still REJECTED exactly as before (HTTP 403,
 * nothing saved) - only the message is clearer, with a link back to the form.
 */
class MY_Security extends CI_Security
{
    public function csrf_show_error()
    {
        // Go back only to a page on this same site (never an outside URL)
        $back = '';
        $ref = isset($_SERVER['HTTP_REFERER']) ? (string) $_SERVER['HTTP_REFERER'] : '';
        $host = isset($_SERVER['HTTP_HOST']) ? (string) $_SERVER['HTTP_HOST'] : '';
        if ($ref !== '' && $host !== '') {
            $p = parse_url($ref);
            if (!empty($p['host']) && strcasecmp($p['host'] . (isset($p['port']) ? ':' . $p['port'] : ''), $host) === 0
                && in_array(isset($p['scheme']) ? strtolower($p['scheme']) : '', array('http', 'https'), TRUE)) {
                $back = $ref;
            }
        }
        $back = htmlspecialchars($back !== '' ? $back : '/', ENT_QUOTES, 'UTF-8');

        if (!headers_sent()) {
            http_response_code(403);
            header('Content-Type: text/html; charset=UTF-8');
            header('Cache-Control: no-store');
            header('X-Content-Type-Options: nosniff');
        }
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        if ($isAjax) {
            if (!headers_sent()) {
                header('Content-Type: application/json; charset=UTF-8');
            }
            echo json_encode(array('status' => FALSE, 'message' => 'Your form has expired. Please reload the page and try again.'));
            exit(1);
        }

        echo '<!doctype html><html lang="en"><head><meta charset="utf-8">'
            . '<meta name="viewport" content="width=device-width, initial-scale=1">'
            . '<title>Form expired - A2A Portal</title>'
            . '<style>body{font-family:Arial,sans-serif;background:#f5f7fa;margin:0;padding:16px;color:#1f2937}'
            . '.box{max-width:520px;margin:10vh auto;background:#fff;border:1px solid #d1d5db;border-radius:8px;padding:24px}'
            . 'h1{font-size:20px;margin:0 0 12px}p{line-height:1.5}a{display:inline-block;margin-top:8px;background:#1d4ed8;color:#fff;'
            . 'padding:10px 18px;border-radius:6px;text-decoration:none}a:focus{outline:3px solid #f59e0b}</style></head><body>'
            . '<main class="box" role="main"><h1>Your form has expired</h1>'
            . '<p role="alert">For your security, forms stop working after some time or when the page is opened in another tab. '
            . 'Nothing was saved.</p><p>Please go back, reload the page, and submit again.</p>'
            . '<a href="' . $back . '">Go back to the form</a></main></body></html>';
        exit(1);
    }
}

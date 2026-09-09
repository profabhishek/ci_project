<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Upload security helper.
 *
 * iccr_safe_move_upload() is a drop-in guarded replacement for
 * move_uploaded_file(). It returns FALSE when the file fails validation,
 * so existing "upload failed" error branches keep working unchanged.
 */
if (!function_exists('iccr_safe_move_upload')) {

    /**
     * Validate and move an uploaded file.
     *
     * @param array  $file        One entry of $_FILES (must contain name, tmp_name)
     * @param string $target_file Destination path
     * @param string $allowed     Optional pipe-separated extension whitelist
     * @return bool
     */
    function iccr_safe_move_upload($file, $target_file, $allowed = 'jpg|jpeg|png|gif|pdf|doc|docx')
    {
        if (!is_array($file) || !isset($file['tmp_name'], $file['name'])) {
            return FALSE;
        }
        if (!is_uploaded_file($file['tmp_name'])) {
            return FALSE;
        }

        // Block path traversal in the destination.
        $normalized = str_replace('\\', '/', $target_file);
        if (strpos($normalized, '..') !== FALSE) {
            return FALSE;
        }

        // 1. Extension whitelist (based on the LAST extension only).
        $allowed_ext = explode('|', strtolower($allowed));
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($ext === '' || !in_array($ext, $allowed_ext, TRUE)) {
            log_message('error', 'Upload rejected (extension): ' . $file['name']);
            return FALSE;
        }

        // Destination must also end in a whitelisted extension so a
        // user-controlled name can never yield an executable file.
        $target_ext = strtolower(pathinfo($normalized, PATHINFO_EXTENSION));
        if (!in_array($target_ext, $allowed_ext, TRUE)) {
            log_message('error', 'Upload rejected (target extension): ' . $target_file);
            return FALSE;
        }

        // 2. Real MIME type check via finfo (never trust the client).
        if (function_exists('finfo_open')) {
            $allowed_mime = array(
                'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                // .docx files are zip containers; some PHP builds report them so:
                'application/zip', 'application/octet-stream',
            );
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            // Explicitly reject anything PHP/script-like regardless of list.
            if (strpos((string) $mime, 'php') !== FALSE
                || strpos((string) $mime, 'x-httpd') !== FALSE
                || strpos((string) $mime, 'html') !== FALSE) {
                log_message('error', 'Upload rejected (mime ' . $mime . '): ' . $file['name']);
                return FALSE;
            }
            if (!in_array($mime, $allowed_mime, TRUE) && strpos((string) $mime, 'image/') !== 0) {
                log_message('error', 'Upload rejected (mime ' . $mime . '): ' . $file['name']);
                return FALSE;
            }
        }

        // Defense in depth: make sure the destination folder carries a
        // no-script-execution .htaccess (covers runtime-created folders).
        $dir = dirname($normalized);
        if (is_dir($dir) && !file_exists($dir . '/.htaccess') && is_writable($dir)) {
            @file_put_contents($dir . '/.htaccess',
                "# Uploaded files must never execute as scripts\n"
                . "<IfModule mod_php5.c>\nphp_flag engine off\n</IfModule>\n"
                . "<IfModule mod_php7.c>\nphp_flag engine off\n</IfModule>\n"
                . "RemoveHandler .php .phtml .php3 .php4 .php5 .php7 .phps .cgi .pl\n"
                . "RemoveType .php .phtml\n"
                . "<FilesMatch \"\\.(php|php\\d|phtml|phar|cgi|pl|py|sh)$\">\nRequire all denied\n</FilesMatch>\n");
        }

        return move_uploaded_file($file['tmp_name'], $target_file);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Returns a usable <img> src for an applicant photo/signature.
 *
 * Tries, in order:
 *   1. <dir>/<image>            (per-applicant year folder, e.g. ./2026/applications_doc/...)
 *   2. assets/site/main/profile_pics/<image>   (or a custom fallback folder)
 * A candidate is only used if the file exists, is readable and is NOT empty,
 * and its real content is an image. Result is a base64 data: URI so it always
 * renders (and prints/PDFs correctly). If nothing valid is found, returns the
 * public URL of the fallback folder copy (browser shows broken icon) so
 * behaviour is never worse than before.
 */
if (!function_exists('iccr_profile_img_src')) {
    function iccr_profile_img_src($dir, $image, $fallback_folder = 'assets/site/main/profile_pics/', $default_src = NULL)
    {
        $default = ($default_src !== NULL) ? $default_src : site_url() . 'assets/site/main/images/default_avatar.png';
        $image = trim((string) $image);
        if ($image === '') {
            return $default;
        }

        $candidates = array();
        $dir = trim((string) $dir);
        if ($dir !== '') {
            $candidates[] = rtrim($dir, '/\\') . '/' . $image;
            // Same folder but resolved from the front controller path,
            // in case the working directory differs (CLI, cron, subfolder).
            if (defined('FCPATH')) {
                $candidates[] = FCPATH . ltrim(str_replace('./', '', rtrim($dir, '/\\') . '/' . $image), '/\\');
            }
        }
        $candidates[] = $fallback_folder . $image;
        if (defined('FCPATH')) {
            $candidates[] = FCPATH . $fallback_folder . $image;
        }

        foreach ($candidates as $path) {
            if (@is_file($path) && @filesize($path) > 0 && @is_readable($path)) {
                $raw = @file_get_contents($path);
                if ($raw === false || $raw === '') {
                    continue;
                }
                $mime = '';
                if (function_exists('finfo_open')) {
                    $f = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_buffer($f, $raw);
                    finfo_close($f);
                }
                // Only embed real images; also allow PDFs for signature docs.
                if (strpos((string) $mime, 'image/') === 0) {
                    return 'data:' . $mime . ';base64,' . base64_encode($raw);
                }
            }
        }

        // Nothing valid found anywhere - show the default avatar instead of a broken image.
        return $default;
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Language switch for the public pages (English / Hindi).
 *   a2a_lang_code()  -> 'en' or 'hi' (from the a2a_lang cookie, set by /lang/set/hi)
 *   a2a_t('key')     -> text in the chosen language, falls back to English
 *   a2a_e('key')     -> same, HTML-escaped (use for plain text)
 * Texts live in application/language/{english,hindi}/a2a_lang.php
 */
if (!function_exists('a2a_lang_code')) {
    function a2a_lang_code()
    {
        static $code = NULL;
        if ($code !== NULL) { return $code; }
        $CI =& get_instance();
        $CI->config->load('a2a_site', TRUE);
        $langs = $CI->config->item('a2a_languages', 'a2a_site');
        $c = isset($_COOKIE['a2a_lang']) ? (string) $_COOKIE['a2a_lang'] : 'en';
        $code = isset($langs[$c]) ? $c : 'en';
        return $code;
    }
}
if (!function_exists('a2a_t')) {
    function a2a_t($key)
    {
        static $txt = NULL;
        if ($txt === NULL) {
            $CI =& get_instance();
            $CI->config->load('a2a_site', TRUE);
            $langs = $CI->config->item('a2a_languages', 'a2a_site');
            $folder = $langs[a2a_lang_code()][0];
            $lang = array();
            include APPPATH . 'language/english/a2a_lang.php';
            $txt = $lang;
            if ($folder !== 'english' && is_file(APPPATH . 'language/' . $folder . '/a2a_lang.php')) {
                $lang = array();
                include APPPATH . 'language/' . $folder . '/a2a_lang.php';
                $txt = array_merge($txt, $lang);
            }
        }
        return isset($txt[$key]) ? $txt[$key] : $key;
    }
}
if (!function_exists('a2a_e')) {
    function a2a_e($key) { return htmlspecialchars(a2a_t($key), ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('a2a_html_lang')) {
    function a2a_html_lang()
    {
        $CI =& get_instance();
        $CI->config->load('a2a_site', TRUE);
        $langs = $CI->config->item('a2a_languages', 'a2a_site');
        return $langs[a2a_lang_code()][2];
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Student name search for the Mission screens
 * ============================================
 * Students' names are stored in three columns of iccr_student_application_details:
 *   fullname (first name), middlename, familyname.
 * The old search looked for the WHOLE typed text inside fullname only, so
 * "Mohammed" was found but "Mohammed Alfairi" or "Alfairi" were not.
 *
 * New search: every word the Mission types must appear somewhere in
 * first + middle + family name, in any order. Dots, hyphens, apostrophes and
 * spaces are ignored on both sides, so "Y.S." matches "YS" and "Al-Hayek"
 * matches "Alhayek". Upper/lower case does not matter.
 *
 * Safety: the old search is used instead (exactly as before) when
 *   1. the typed text is not a plain name (fails the name check below), or
 *   2. the new SQL does not work on this database (checked once per page load,
 *      e.g. a missing column or a collation problem).
 * So a Mission can never get a worse result or an error page from this change.
 *
 * Use in a model (one line):
 *   $this->db->where(a2a_name_search_sql($this->db, $vars['ApplicantName']), NULL, FALSE);
 */

if (!function_exists('a2a_name_words')) {
    /**
     * Name check. Returns the list of words to search for, or FALSE when the text
     * is not a plain name (then the old search is used).
     * Allowed: letters of any language (Latin, Arabic, Cyrillic, ...), accents,
     * spaces, dot, hyphen, apostrophe. At most 100 characters and 8 words.
     */
    function a2a_name_words($term)
    {
        $term = trim(preg_replace('/\s+/u', ' ', (string) $term));
        if ($term === '' || mb_strlen($term, 'UTF-8') > 100) {
            return FALSE;
        }
        // The name check (regex). /u = Unicode. If PCRE cannot run it, preg_match returns FALSE -> old search.
        if (preg_match("/^[\\p{L}\\p{M} .'\\x{2019}-]+$/u", $term) !== 1) {
            return FALSE;
        }
        $words = array();
        foreach (explode(' ', $term) as $w) {
            $w = preg_replace("/[.'\\x{2019}-]+/u", '', $w);   // ignore . ' - inside a word
            if ($w !== '' && $w !== NULL) {
                $words[mb_strtolower($w, 'UTF-8')] = $w;        // drop repeated words (case-insensitive)
            }
        }
        if (!$words || count($words) > 8) {
            return FALSE;
        }
        return array_values($words);
    }
}

if (!function_exists('a2a_name_search_old_sql')) {
    /** The original search, unchanged: whole text inside the first-name column only. */
    function a2a_name_search_old_sql($db, $term)
    {
        return "CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE "
             . $db->escape('%' . $db->escape_like_str($term) . '%');
    }
}

if (!function_exists('a2a_name_search_new_sql')) {
    /** New search: each word somewhere in first + middle + family name (spaces and . ' - ignored). */
    function a2a_name_search_new_sql($db, $words)
    {
        $t = 'iccr_student_application_details';
        $name = "CONVERT(CONCAT_WS('', $t.fullname, $t.middlename, $t.familyname) USING utf8mb3) COLLATE utf8mb3_general_ci";
        foreach (array(' ', '.', '-', "''", "\xE2\x80\x99") as $ch) {
            $name = "REPLACE($name, '$ch', '')";
        }
        $parts = array();
        foreach ($words as $w) {
            $parts[] = "$name LIKE " . $db->escape('%' . $db->escape_like_str($w) . '%') . " ESCAPE '!'";
        }
        return '(' . implode(' AND ', $parts) . ')';
    }
}

if (!function_exists('a2a_name_search_works')) {
    /**
     * Does the new search SQL run on this database? Checked once per page load
     * with a harmless test query (errors are switched off for the check).
     */
    function a2a_name_search_works($db)
    {
        static $ok = NULL;
        if ($ok !== NULL) {
            return $ok;
        }
        $debug = $db->db_debug;
        $db->db_debug = FALSE;
        $msg = '';
        try {
            // PHP 8 turns database errors into exceptions, so catch them as well
            $q = $db->query('SELECT 1 FROM iccr_student_application_details WHERE ' . a2a_name_search_new_sql($db, array('Test')) . ' LIMIT 1');
        } catch (Exception $e) {
            $q = FALSE;
            $msg = $e->getMessage();
        }
        $db->db_debug = $debug;
        $ok = ($q !== FALSE);
        if (!$ok) {
            if ($msg === '') { $err = $db->error(); $msg = isset($err['message']) ? $err['message'] : ''; }
            log_message('error', 'Name search: new search not usable, using the old one. ' . $msg);
        }
        return $ok;
    }
}

if (!function_exists('a2a_name_search_sql')) {
    /** The WHERE condition for an applicant-name search: new search if possible, otherwise the old one. */
    function a2a_name_search_sql($db, $term)
    {
        $words = a2a_name_words($term);
        if ($words === FALSE || !a2a_name_search_works($db)) {
            return a2a_name_search_old_sql($db, $term);
        }
        return a2a_name_search_new_sql($db, $words);
    }
}

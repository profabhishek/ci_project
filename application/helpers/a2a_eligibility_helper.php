<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * A2A admission eligibility rules (one place for all age / DOB checks).
 * Added Nov 2026 for admission defects D-01, D-07, D-08.
 *
 * Age is counted on the reference date (1 July of the admission year).
 * Change A2A_AGE_REFERENCE_DATE each cycle - nothing else needs editing.
 */
if (!defined('A2A_AGE_REFERENCE_DATE')) {
    define('A2A_AGE_REFERENCE_DATE', '2026-07-01');
}

/**
 * Age band per "Apply For" value (iccr_student_details.apply_course_type).
 * array(min, max) in years on the reference date, both inclusive:
 * "max 35" allows a DOB of exactly 35 years (01-Jul-1991) but not one day
 * more (30-Jun-1991).  max NULL = no ICCR upper limit (ICCR guidelines:
 * Hindi / Sanskrit / Indian languages / performing arts courses - the
 * institution's own age rule applies instead).
 */
function a2a_age_limits($course_type = null)
{
    $limits = array(
        1  => array(18, 35),   // UG
        2  => array(18, 35),   // PG
        4  => array(18, 40),   // PhD
        8  => array(18, 40),   // PhD (Ayush)
        12 => array(18, null), // Diploma - Languages / Performing Arts
        13 => array(18, null), // Certificate - Languages / Performing Arts
    );
    $course_type = (int) $course_type;
    return isset($limits[$course_type]) ? $limits[$course_type] : array(18, 40);
}

/** Valid "Apply For" values offered on the registration form. */
function a2a_course_types()
{
    return array(1, 2, 4, 8, 12, 13);
}

/** Returns a DateTime for a real calendar date, or FALSE (D-08). */
function a2a_parse_dob($day, $month, $year)
{
    if (!ctype_digit((string) $day) || !ctype_digit((string) $month) || !ctype_digit((string) $year)) {
        return FALSE;
    }
    $d = (int) $day; $m = (int) $month; $y = (int) $year;
    if ($y < 1900 || !checkdate($m, $d, $y)) {
        return FALSE;
    }
    $dob = DateTime::createFromFormat('!Y-m-d', sprintf('%04d-%02d-%02d', $y, $m, $d));
    if (!$dob || $dob > new DateTime('today')) {
        return FALSE; // future dates are not a DOB
    }
    return $dob;
}

/** Completed years on the reference date (for messages only). */
function a2a_age_on_reference(DateTime $dob)
{
    $ref = DateTime::createFromFormat('!Y-m-d', A2A_AGE_REFERENCE_DATE);
    $diff = $dob->diff($ref);
    return $diff->invert ? -1 : $diff->y;
}

/**
 * Full check. Compares dates, not rounded years, so boundaries are exact.
 * Returns array(ok bool, message string, age int|null).
 */
function a2a_check_age($day, $month, $year, $course_type = null)
{
    $dob = a2a_parse_dob($day, $month, $year);
    if ($dob === FALSE) {
        return array(FALSE, 'Please enter a valid date of birth.', null);
    }
    $age = a2a_age_on_reference($dob);
    list($min, $max) = a2a_age_limits($course_type);
    $on = date('d M Y', strtotime(A2A_AGE_REFERENCE_DATE));
    $ref = DateTime::createFromFormat('!Y-m-d', A2A_AGE_REFERENCE_DATE);

    // Latest DOB allowed: reference date minus min years (01-Jul-2008 for 18)
    $latest = (clone $ref)->modify('-' . (int) $min . ' years');
    if ($dob > $latest) {
        return array(FALSE, "Applicant must be at least {$min} years old as on {$on}.", $age);
    }
    if ($max !== null) {
        // Earliest DOB allowed: reference date minus max years (01-Jul-1991 for 35)
        $earliest = (clone $ref)->modify('-' . (int) $max . ' years');
        if ($dob < $earliest) {
            return array(FALSE, "For the selected programme the maximum age is {$max} years as on {$on}.", $age);
        }
    }
    return array(TRUE, '', $age);
}

/**
 * D-07 cross-check: the visible date field (dob, YYYY-MM-DD) and the three
 * hidden fields must describe the same date, so a tampered request cannot
 * pass one value to the checks and store another.
 */
function a2a_dob_fields_match($dob, $day, $month, $year)
{
    if (!is_string($dob) || !preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dob, $m)) {
        return FALSE;
    }
    return ctype_digit((string) $day) && ctype_digit((string) $month) && ctype_digit((string) $year)
        && (int) $m[1] === (int) $year && (int) $m[2] === (int) $month && (int) $m[3] === (int) $day;
}

/**
 * ADM-017..020: passport must be valid for at least 2 years on the
 * reference date (expiry on or after 01-Jul-2028 for the 2026 cycle).
 * Returns array(ok bool, message string).
 */
function a2a_check_passport_expiry($day, $month, $year)
{
    $exp = a2a_parse_any_date($day, $month, $year);
    if ($exp === FALSE) {
        return array(FALSE, 'Please enter a valid passport expiry date.');
    }
    $ref = DateTime::createFromFormat('!Y-m-d', A2A_AGE_REFERENCE_DATE);
    $need = (clone $ref)->modify('+2 years');
    if ($exp < $ref) {
        return array(FALSE, 'Your passport has expired before ' . $ref->format('d M Y') . '. Please renew it before applying.');
    }
    if ($exp < $need) {
        return array(FALSE, 'Passport must be valid for at least 2 years as on ' . $ref->format('d M Y')
            . ' (expiry on or after ' . $need->format('d M Y') . ').');
    }
    return array(TRUE, '');
}

/** Real calendar date (past or future), or FALSE. */
function a2a_parse_any_date($day, $month, $year)
{
    if (!ctype_digit((string) $day) || !ctype_digit((string) $month) || !ctype_digit((string) $year)) {
        return FALSE;
    }
    $d = (int) $day; $m = (int) $month; $y = (int) $year;
    if ($y < 1900 || $y > 2100 || !checkdate($m, $d, $y)) {
        return FALSE;
    }
    return DateTime::createFromFormat('!Y-m-d', sprintf('%04d-%02d-%02d', $y, $m, $d));
}

/** Split a stored DD/MM/YYYY date into array(d, m, y) or FALSE. */
function a2a_split_dmy($s)
{
    if (!is_string($s) || !preg_match('#^\s*(\d{1,2})/(\d{1,2})/(\d{4})\s*$#', $s, $m)) {
        return FALSE;
    }
    return array($m[1], $m[2], $m[3]);
}

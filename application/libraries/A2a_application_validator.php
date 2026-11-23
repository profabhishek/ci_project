<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Server-side validation for the applicant's Application Form (step one).
 *
 * Why this exists (Nov 2026 security review):
 *  - The old save code wrote EVERY posted field straight into
 *    iccr_student_application_details (mass assignment). A crafted request
 *    could change status, uid, application_no or any other column.
 *  - Browser rules (required / pattern / readonly) were the only checks.
 *
 * What it does:
 *  1. Builds the record ONLY from an allowlist of fields the applicant may set.
 *  2. Takes identity fields (name, title, gender, nationality, email, mobile,
 *     passport no., citizenship no.) from the registration record - never from
 *     the browser, even though the form shows them read-only.
 *  3. Validates every field: type, length, format, allowed values, master-data
 *     existence (countries, programme, course type, university + course mapping).
 *  4. Returns a list of plain-English errors; nothing is saved if any exist.
 *
 * Used by Applicant::applicant_education_info() and
 * Applicant::applicant_education_info_save().
 */
class A2a_application_validator
{
    /** @var CI_Controller */
    protected $CI;

    /** Text limits (characters). */
    const MAX_NAME     = 50;
    const MAX_ADDRESS  = 300;
    const MAX_EMAIL    = 100;
    const MAX_ESSAY_WORDS = 500;   // "not more than 500 words" (form item 18)
    const MIN_ESSAY_WORDS = 50;    // blocks empty / token essays; change if ICCR sets a minimum

    /** English level options exactly as offered on the form. */
    protected $englishLevels = array(
        'Secondary|High School(8-10 Year)',
        'High School|College(10-12 Year)',
        'Under Graduate(12-15 Year)',
        'Post Graduate(15-18 Year)',
    );

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('a2a_eligibility');
    }

    /**
     * @param array $in     xss-cleaned POST (strings)
     * @param array $pairs  list of array(nomenclature_id, university_id) in preference order
     * @param int   $userId logged-in applicant
     * @param array $out    (by ref) the clean record to save - allowlisted fields only
     * @return string[]     errors (empty = valid)
     */
    public function validateStepOne(array $in, array $pairs, $userId, &$out)
    {
        $out = array();
        $e = array();
        $db = $this->CI->db;

        $s = function ($k) use ($in) {
            if (!isset($in[$k]) || is_array($in[$k])) { return ''; }
            // strip tags + control characters, collapse spaces
            $v = strip_tags((string) $in[$k]);
            $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v);
            return trim(preg_replace('/[ \t]+/u', ' ', $v));
        };

        // ---------- 1. Identity fields come from registration ----------
        $reg = $this->CI->common_model->getUserData($userId);
        if (empty($reg)) {
            return array('Your registration record was not found. Please log in again.');
        }
        $r = $reg[0];
        $out['student_title'] = isset($r['student_title']) ? $r['student_title'] : '';
        $out['fullname']      = isset($r['username']) ? $r['username'] : '';
        $out['middlename']    = isset($r['student_mname']) ? $r['student_mname'] : '';
        $out['familyname']    = isset($r['student_lname']) ? $r['student_lname'] : '';
        $out['gender']        = isset($r['gender']) ? $r['gender'] : '';
        $out['nationality']   = isset($r['country_of_domicile']) ? $r['country_of_domicile'] : '';
        $out['email']         = isset($r['email_id']) ? $r['email_id'] : '';
        $out['unique_id']     = isset($r['unique_id']) ? $r['unique_id'] : '';
        $out['passport_no']   = isset($r['passport_no']) ? strtoupper($r['passport_no']) : '';
        $out['phone_number']  = isset($r['mobile_number']) ? $r['mobile_number'] : '';

        // ---------- 2. Personal ----------
        $this->text($e, $out, 'city', $s('city'), 'Place of birth (city)', true, '/^[\p{L} .\'-]{2,50}$/u');
        $this->country($e, $out, 'birth_country', $s('birth_country'), 'Country of birth', true);

        // ---------- 3. Passport ----------
        $this->text($e, $out, 'passport_issue_place', $s('passport_issue_place'), 'Place of issue', true, '/^[\p{L} .\'-]{2,50}$/u');
        $this->country($e, $out, 'passport_issue_country', $s('passport_issue_country'), 'Passport issue country', true);

        $iss = a2a_parse_any_date($s('passport_issue_date'), $s('passport_issue_month'), $s('passport_issue_year'));
        if ($iss === FALSE) {
            $e[] = 'Please enter a valid passport date of issue.';
        } elseif ($iss > new DateTime('today')) {
            $e[] = 'Passport date of issue cannot be in the future.';
        }
        list($pok, $pmsg) = a2a_check_passport_expiry($s('passport_expiry_date'), $s('passport_expiry_month'), $s('passport_expiry_year'));
        if (!$pok) {
            $e[] = $pmsg;
        }
        $exp = a2a_parse_any_date($s('passport_expiry_date'), $s('passport_expiry_month'), $s('passport_expiry_year'));
        if ($iss && $exp && $exp <= $iss) {
            $e[] = 'Passport expiry date must be after the date of issue.';
        }
        // Model joins these into DD-MM-YYYY; pass them zero-padded.
        foreach (array('issue' => $iss, 'expiry' => $exp) as $k => $d) {
            if ($d) {
                $out["passport_{$k}_date"]  = $d->format('d');
                $out["passport_{$k}_month"] = $d->format('m');
                $out["passport_{$k}_year"]  = $d->format('Y');
            }
        }

        // ---------- 4. Address ----------
        $this->text($e, $out, 'postal_address', $s('postal_address'), 'Postal address', true, '/^[\p{L}\p{N} ,.\'\/#()&:\r\n-]{5,300}$/u');
        $this->text($e, $out, 'postal_address_city', $s('postal_address_city'), 'Postal address city', true, '/^[\p{L} .\'-]{2,50}$/u');
        $this->text($e, $out, 'postal_address_state', $s('postal_address_state'), 'Postal address state', true, '/^[\p{L} .\'-]{2,50}$/u');
        $this->country($e, $out, 'postal_address_country', $s('postal_address_country'), 'Postal address country', true);
        $this->text($e, $out, 'postal_address_pincode', strtoupper($s('postal_address_pincode')), 'Postal code', true, '/^[A-Z0-9 -]{3,11}$/');

        // ---------- 5. Contacts ----------
        $this->phone($e, $out, 'whatsapp_number', $s('whatsapp_number'), 'WhatsApp number', false);
        $this->phone($e, $out, 'father_number', $s('father_number'), "Father's mobile number", false);
        $this->email($e, $out, 'father_email', $s('father_email'), "Father's email", false);
        $this->phone($e, $out, 'mother_number', $s('mother_number'), "Mother's mobile number", false);
        $this->email($e, $out, 'mother_email', $s('mother_email'), "Mother's email", false);
        $this->text($e, $out, 'guardian_name', $s('guardian_name'), "Guardian's name", false, '/^[\p{L} .\'-]{2,50}$/u');
        $this->phone($e, $out, 'guardian_number', $s('guardian_number'), "Guardian's mobile number", false);
        $this->email($e, $out, 'guardian_email', $s('guardian_email'), "Guardian's email", false);
        $this->text($e, $out, 'guardian_address', $s('guardian_address'), 'Address in home country', true, '/^[\p{L}\p{N} ,.\'\/#()&:\r\n-]{5,300}$/u');
        $this->text($e, $out, 'gardiuan_address_city', $s('gardiuan_address_city'), 'Home-country city', false, '/^[\p{L} .\'-]{2,50}$/u');
        $this->text($e, $out, 'gardiuan_address_state', $s('gardiuan_address_state'), 'Home-country state', false, '/^[\p{L} .\'-]{2,50}$/u');
        $this->country($e, $out, 'gardiuan_address_country', $s('gardiuan_address_country'), 'Home country', true);
        $this->text($e, $out, 'gardiuan_address_pincode', strtoupper($s('gardiuan_address_pincode')), 'Home-country postal code', true, '/^[A-Z0-9 -]{3,11}$/');

        // ---------- 6. English ----------
        $this->choice($e, $out, 'is_english_as_subject', $s('is_english_as_subject'), 'English as a subject', array('', '1', '2'));
        $lvl = $s('english_level');
        if ($lvl !== '' && !in_array($lvl, $this->englishLevels, true)) {
            $e[] = 'Please choose a valid English level.';
        } else {
            $out['english_level'] = $lvl;
        }
        $this->choice($e, $out, 'is_toefl', $s('is_toefl'), 'TOEFL', array('', '1', '2'));
        $this->choice($e, $out, 'is_ielts', $s('is_ielts'), 'IELTS', array('', '1', '2'));
        $this->score($e, $out, 'toefl_score', $s('toefl_score'), 'TOEFL score', 0, 120, false);
        $this->score($e, $out, 'ielts_score', $s('ielts_score'), 'IELTS score', 0, 9, true);
        $this->score($e, $out, 'duolingo_score', $s('duolingo_score'), 'Duolingo score', 10, 160, false);
        $this->score($e, $out, 'gmat_score', $s('gmat_score'), 'GMAT score', 200, 800, false);

        $essay = isset($in['english_test_essay']) && !is_array($in['english_test_essay']) ? (string) $in['english_test_essay'] : '';
        $essay = trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', strip_tags($essay)));
        $words = preg_match_all('/[\p{L}\p{N}]+(?:[\'’-][\p{L}\p{N}]+)*/u', $essay);
        if ($essay === '' || $words === 0) {
            $e[] = 'The English essay (item 18) is required.';
        } elseif ($words < self::MIN_ESSAY_WORDS) {
            $e[] = 'The English essay (item 18) must have at least ' . self::MIN_ESSAY_WORDS . ' words (it has ' . $words . ').';
        } elseif ($words > self::MAX_ESSAY_WORDS) {
            $e[] = 'The English essay (item 18) must not be more than ' . self::MAX_ESSAY_WORDS . ' words (it has ' . $words . ').';
        } else {
            $out['english_test_essay'] = $essay;
        }

        // ---------- 7. Course + preferences ----------
        if ($s('acedemic_year') !== '2026-27') {
            $e[] = 'Academic year must be 2026-27.';
        } else {
            $out['acedemic_year'] = '2026-27';
        }
        $prog = $s('programme');
        $ctype = $s('course_type');
        if (!ctype_digit($prog) || !$this->exists('iccr_programme', 'id', (int) $prog)) {
            $e[] = 'Please choose a valid Level of Course.';
        } else {
            $out['programme'] = (int) $prog;
        }
        if (!ctype_digit($ctype) || !$this->exists('iccr_course_type', 'id', (int) $ctype)) {
            $e[] = 'Please choose a valid Course Type.';
        } else {
            $out['course_type'] = (int) $ctype;
        }

        $saved = $this->CI->common_model->getApplicationStepOne($userId);
        $savedPairs = array();
        if (!empty($saved)) {
            foreach (array('' => '', '_two' => '_two', '_three' => '_three', '_fourth' => '_fourth', '_fifth' => '_fifth') as $sfx) {
                $savedPairs[] = $saved[0]['nomenclature' . $sfx] . '|' . $saved[0]['universty_choice' . $sfx];
            }
        }

        $cols = array(
            array('nomenclature', 'universty_choice', 'university_choice_one_state'),
            array('nomenclature_two', 'universty_choice_two', 'university_choice_two_state'),
            array('nomenclature_three', 'universty_choice_three', 'university_choice_three_state'),
            array('nomenclature_fourth', 'universty_choice_fourth', 'university_choice_fourth_state'),
            array('nomenclature_fifth', 'universty_choice_fifth', 'university_choice_fifth_state'),
        );
        $clean = array();
        foreach ($pairs as $p) {
            $n = isset($p[0]) && !is_array($p[0]) ? trim((string) $p[0]) : '';
            $u = isset($p[1]) && !is_array($p[1]) ? trim((string) $p[1]) : '';
            if ($n === '' && $u === '') { continue; }
            if (!ctype_digit($n) || !ctype_digit($u)) {
                $e[] = 'Each university preference needs a valid course and university.';
                continue;
            }
            $clean[] = array((int) $n, (int) $u);
        }
        if (count($clean) > 5) {
            $e[] = 'You can choose at most five university preferences.';
            $clean = array_slice($clean, 0, 5);
        }
        if (count($clean) === 0) {
            $e[] = 'Please choose at least one university preference.';
        }
        $seen = array();
        foreach ($clean as $i => $p) {
            $key = $p[0] . '|' . $p[1];
            if (isset($seen[$key])) {
                $e[] = 'Preference ' . ($i + 1) . ' repeats an earlier preference.';
                continue;
            }
            $seen[$key] = true;
            if (isset($out['programme'], $out['course_type'])
                && !in_array($key, $savedPairs, true)
                && !$this->mappingExists($p[1], $p[0], $out['programme'], $out['course_type'])) {
                $e[] = 'Preference ' . ($i + 1) . ': the selected course is not offered by that university for this level.';
                continue;
            }
            $st = $this->CI->common_model->getUniversityStateById($p[1]);
            $out[$cols[$i][0]] = $p[0];
            $out[$cols[$i][1]] = $p[1];
            $out[$cols[$i][2]] = !empty($st) ? $st[0]['state'] : '';
        }
        // Clear unused slots so an old choice does not linger
        for ($i = count($clean); $i < 5; $i++) {
            $out[$cols[$i][0]] = '';
            $out[$cols[$i][1]] = '';
        }

        // ---------- 8. Fit the real column types ----------
        // Some phone columns are numeric in the database: a leading "+" would be
        // stored as blank, so keep digits only there (country code included).
        foreach ($this->columnTypes() as $col => $type) {
            if (isset($out[$col]) && is_string($out[$col]) && $out[$col] !== ''
                && preg_match('/int|decimal|numeric|float|double/i', $type)
                && preg_match('/^\+?[0-9]+$/', $out[$col])) {
                $out[$col] = ltrim($out[$col], '+');
            }
        }
        // Never longer than the database column
        $this->checkColumnLengths($e, $out);

        return array_values(array_unique($e));
    }

    /** Columns the applicant (via this validator) may write. Used by the model as a last guard. */
    public static function allowedColumns()
    {
        return array(
            'student_title', 'fullname', 'middlename', 'familyname', 'gender', 'nationality', 'email',
            'unique_id', 'passport_no', 'phone_number', 'city', 'birth_country',
            'passport_issue_place', 'passport_issue_country',
            'passport_issue_date', 'passport_issue_month', 'passport_issue_year',
            'passport_expiry_date', 'passport_expiry_month', 'passport_expiry_year',
            'postal_address', 'postal_address_city', 'postal_address_state', 'postal_address_country', 'postal_address_pincode',
            'whatsapp_number', 'father_number', 'father_email', 'mother_number', 'mother_email',
            'guardian_name', 'guardian_number', 'guardian_email', 'guardian_address',
            'gardiuan_address_city', 'gardiuan_address_state', 'gardiuan_address_country', 'gardiuan_address_pincode',
            'is_english_as_subject', 'english_level', 'is_toefl', 'is_ielts',
            'toefl_score', 'ielts_score', 'duolingo_score', 'gmat_score', 'english_test_essay',
            'acedemic_year', 'programme', 'course_type',
            'nomenclature', 'nomenclature_two', 'nomenclature_three', 'nomenclature_fourth', 'nomenclature_fifth',
            'universty_choice', 'universty_choice_two', 'universty_choice_three', 'universty_choice_fourth', 'universty_choice_fifth',
            'university_choice_one_state', 'university_choice_two_state', 'university_choice_three_state',
            'university_choice_fourth_state', 'university_choice_fifth_state',
        );
    }

    // ------------------------------------------------------------------ helpers

    protected function text(&$e, &$out, $k, $v, $label, $required, $re)
    {
        if ($v === '') {
            if ($required) { $e[] = "$label is required."; } else { $out[$k] = ''; }
            return;
        }
        if (!preg_match($re, $v)) {
            $e[] = "$label contains characters that are not allowed or is too long.";
            return;
        }
        $out[$k] = $v;
    }

    protected function country(&$e, &$out, $k, $v, $label, $required)
    {
        if ($v === '') {
            if ($required) { $e[] = "$label is required."; } else { $out[$k] = ''; }
            return;
        }
        if (!ctype_digit($v) || !$this->exists('iccr_countries', 'id', (int) $v)) {
            $e[] = "Please choose a valid $label.";
            return;
        }
        $out[$k] = (int) $v;
    }

    protected function phone(&$e, &$out, $k, $v, $label, $required)
    {
        $n = preg_replace('/[\s-]+/', '', $v);
        if ($n === '') {
            if ($required) { $e[] = "$label is required."; } else { $out[$k] = ''; }
            return;
        }
        if (!preg_match('/^\+?[0-9]{6,15}$/', $n)) {
            $e[] = "$label may contain only digits (and a leading +), 6 to 15 digits.";
            return;
        }
        $out[$k] = $n;
    }

    protected function email(&$e, &$out, $k, $v, $label, $required)
    {
        $v = strtolower($v);
        if ($v === '') {
            if ($required) { $e[] = "$label is required."; } else { $out[$k] = ''; }
            return;
        }
        if (strlen($v) > self::MAX_EMAIL || !filter_var($v, FILTER_VALIDATE_EMAIL)) {
            $e[] = "$label is not a valid email address.";
            return;
        }
        $out[$k] = $v;
    }

    protected function choice(&$e, &$out, $k, $v, $label, array $allowed)
    {
        if (!in_array($v, $allowed, true)) {
            $e[] = "Please choose a valid option for $label.";
            return;
        }
        $out[$k] = $v;
    }

    protected function score(&$e, &$out, $k, $v, $label, $min, $max, $halfSteps)
    {
        if ($v === '') { $out[$k] = ''; return; }
        if (!preg_match('/^\d{1,3}(\.\d)?$/', $v)) {
            $e[] = "$label must be a number.";
            return;
        }
        $f = (float) $v;
        if ($f < $min || $f > $max || ($halfSteps && fmod($f * 2, 1) != 0) || (!$halfSteps && floor($f) != $f)) {
            $e[] = "$label must be between $min and $max" . ($halfSteps ? ' in steps of 0.5' : '') . '.';
            return;
        }
        $out[$k] = $v;
    }

    protected function exists($table, $col, $val)
    {
        return $this->CI->db->select($col)->from($table)->where($col, $val)->limit(1)->get()->num_rows() > 0;
    }

    /**
     * Same rules as the form's own dropdowns:
     *  - course list   = Common_model::getnomenclatureByType()  (programme + course type, visible)
     *  - university list = Common_model::getuniversityBynomen() (course + course type)
     */
    protected function mappingExists($universityId, $nomenclatureId, $programme, $courseType)
    {
        $courseOk = $this->CI->db->select('nomenclature_id')->from('iccr_university_mapping')
            ->where('nomenclature_id', $nomenclatureId)
            ->where('programme_id', $programme)
            ->where('course_type', $courseType)
            ->where('view', '1')
            ->limit(1)->get()->num_rows() > 0;
        if (!$courseOk) {
            return FALSE;
        }
        return $this->CI->db->select('university_id')->from('iccr_university_mapping')
            ->where('university_id', $universityId)
            ->where('nomenclature_id', $nomenclatureId)
            ->where('course_type', $courseType)
            ->limit(1)->get()->num_rows() > 0;
    }

    /**
     * Real column definitions for the application table, from
     * INFORMATION_SCHEMA (cached per request):
     * name => array(data_type, max_characters or null)
     */
    protected function columns()
    {
        static $cols = null;
        if ($cols === null) {
            $cols = array();
            $q = $this->CI->db->query(
                'SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?', array('iccr_student_application_details'));
            foreach ($q->result_array() as $r) {
                $cols[$r['COLUMN_NAME']] = array(strtolower($r['DATA_TYPE']),
                    $r['CHARACTER_MAXIMUM_LENGTH'] !== null ? (int) $r['CHARACTER_MAXIMUM_LENGTH'] : null);
            }
        }
        return $cols;
    }

    protected function columnTypes()
    {
        $t = array();
        foreach ($this->columns() as $n => $c) { $t[$n] = $c[0]; }
        return $t;
    }

    /** Reject values longer than the real column (no silent truncation). */
    protected function checkColumnLengths(&$e, array $out)
    {
        $cols = $this->columns();
        foreach ($out as $k => $v) {
            if (!isset($cols[$k])) {
                continue;
            }
            list($type, $max) = $cols[$k];
            if ($max !== null && is_string($v) && mb_strlen($v) > $max) {
                $e[] = "The value for $k is too long (max $max characters).";
            }
        }
    }
}

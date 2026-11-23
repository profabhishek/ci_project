<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Mission "Student Status Tracker" - read-only data for the Mission login.
 *
 * Everything here is SELECT only. Nothing is ever changed in the database.
 *
 * How the data is limited to one Mission:
 *   The Mission controller already works out $this->ids (the iccr_missions
 *   rows that belong to the logged-in Mission's e-mail). Every query below is
 *   filtered with iccr_student_other_details.application_through IN (those ids),
 *   exactly like the existing "Applications Received" screens, so a Mission can
 *   only ever see its own students.
 *
 * Three small queries are run instead of one query per student (the old
 * screens ran 10-15 queries for every row, which is what made them slow):
 *   1. the list of applications for the chosen academic year
 *   2. every university choice + its status for those applications
 *   3. the universities' answers (accepted / placed, joining date, duration)
 */
class Mission_tracker_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Academic-year windows, copied from Mission_model::getMissionApplications
     * so this page counts the same applications as "Applications Received".
     * Values are Unix timestamps on iccr_status_mapping.created.
     */
    public function yearWindows() {
        return array(
            2026 => array('label' => '2026-2027', 'from' => 1772150400, 'to' => 1798761599),
            2025 => array('label' => '2025-2026', 'from' => 1738378143, 'to' => 1767149343),
            2024 => array('label' => '2024-2025', 'from' => 1711983082, 'to' => 1735656682),
            2023 => array('label' => '2023-2024', 'from' => 1680369394, 'to' => 1704046594),
            2022 => array('label' => '2022-2023', 'from' => 1644471556, 'to' => 1680369394),
            2021 => array('label' => '2021-2022', 'from' => 1615749687, 'to' => 1644471556),
        );
    }

    /** 1. Applications for this Mission in the chosen year. */
    public function getApplications($missionIds, $year) {
        if (empty($missionIds)) {
            return array();          // no Mission rows -> show nothing (never everything)
        }
        $windows = $this->yearWindows();
        if (!isset($windows[$year])) {
            return array();
        }

        $this->db->select('sm.application_no, sm.status, sm.mission_status, sm.mission_status_date, sm.scholarship_id, sm.undertaking_doc, sm.visa_no, sm.created AS submitted_on,
            ad.fullname, ad.middlename, ad.familyname, ad.email, ad.phone_number, ad.passport_no, ad.course_type, ad.programme,
            p.name AS programme_name, c.country_name', FALSE);
        $this->db->from('iccr_status_mapping sm');
        $this->db->join('iccr_student_other_details od', 'od.application_no = sm.application_no');
        $this->db->join('iccr_student_application_details ad', 'ad.application_no = sm.application_no');
        $this->db->join('iccr_programme p', 'p.id = ad.programme', 'left');
        $this->db->join('iccr_countries c', 'c.id = ad.nationality', 'left');
        $this->db->where_in('od.application_through', $missionIds);
        $this->db->where('ad.course_year', NULL);
        $this->db->where('sm.status >=', 1);
        $this->db->where('sm.created >=', $windows[$year]['from']);
        $this->db->where('sm.created <=', $windows[$year]['to']);
        $this->db->order_by('sm.created', 'DESC');

        $q = $this->db->get();
        return $q ? $q->result_array() : array();
    }

    /** 2. University choices and their status, for a list of application numbers. */
    public function getUniversityChoices($appNos) {
        if (empty($appNos)) {
            return array();
        }
        $this->db->select('us.application_id, us.regional_university, us.status AS uni_status, us.university_remarks, un.name AS university_name, un.state');
        $this->db->from('iccr_university_status_mapping us');
        $this->db->join('iccr_univercities un', 'un.id = us.regional_university', 'left');
        $this->db->where_in('us.application_id', $appNos);
        $q = $this->db->get();
        return $q ? $q->result_array() : array();
    }

    /** 3. Universities' answers (offer / placement) for a list of application numbers. */
    public function getUniversityResponses($appNos) {
        if (empty($appNos)) {
            return array();
        }
        $this->db->select('ur.application_id, ur.regional_university, ur.university_is_accept, ur.confirmed_to_mission, ur.duration_of_course, ur.date_of_joining, ur.region_one_status_date, ur.reject_reason, un.name AS university_name');
        $this->db->from('iccr_university_response ur');
        $this->db->join('iccr_univercities un', 'un.id = ur.regional_university', 'left');
        $this->db->where_in('ur.application_id', $appNos);
        $q = $this->db->get();
        return $q ? $q->result_array() : array();
    }

    /** AYUSH only: has the AYUSH admin uploaded the university letter yet? */
    public function getAyushLetterAppNos($appNos) {
        if (empty($appNos)) {
            return array();
        }
        $this->db->select('application_id');
        $this->db->from('iccr_university_response_by_hqrs');
        $this->db->where_in('application_id', $appNos);
        $this->db->where("region_one_doc IS NOT NULL AND region_one_doc <> ''", NULL, FALSE);
        $q = $this->db->get();
        $out = array();
        if ($q) {
            foreach ($q->result_array() as $r) {
                $out[$r['application_id']] = TRUE;
            }
        }
        return $out;
    }
    /* ------------------------------------------------------------------
     * Plain-language layer. Turns status codes into words a Mission
     * officer understands: what stage, what it means, who must act next.
     * ------------------------------------------------------------------ */

    /** Words for iccr_university_status_mapping.status (one row per university choice). */
    public function universityStatusWords($code) {
        $map = array(
            1  => array('Waiting for the student', 'wait'),
            2  => array('University is reviewing', 'wait'),
            3  => array('On hold by the university', 'wait'),
            5  => array('Sent back to student for corrections', 'action'),
            6  => array('Admission offered', 'good'),
            7  => array('Not admitted', 'closed'),
            8  => array('Scholarship awarded', 'good'),
            9  => array('Student re-submitted, university reviewing', 'wait'),
            11 => array('Admission offered, with Mission for scholarship', 'good'),
        );
        $code = (int) $code;
        return isset($map[$code]) ? $map[$code] : array('Status code ' . $code . ' (ask ICCR HQ)', 'wait');
    }

    /** Converts a stored date (Unix number or text) to "16 Oct 2026"; '' if empty/unreadable. */
    public function niceDate($value) {
        if ($value === NULL || $value === '' || $value === '0' || $value === 0) {
            return '';
        }
        $ts = is_numeric($value) ? (int) $value : strtotime($value);
        return ($ts && $ts > 0) ? date('d M Y', $ts) : (string) $value;
    }

    private function toTimestamp($value) {
        if ($value === NULL || $value === '' || $value === '0') {
            return 0;
        }
        $ts = is_numeric($value) ? (int) $value : strtotime($value);
        return $ts ? $ts : 0;
    }

    /**
     * Works out the current stage of ONE application.
     * step: 1 Applied, 2 University review, 3 Admission offered,
     *       4 Scholarship awarded, 5 Student accepted, 6 Visa & travel, 7 Arrived.
     * who:  mission | university | hq | student | none
     */
    private function stageOf($a, $unis, $resps, $ayushLetter) {
        $S = (int) $a['status'];
        $M = (int) $a['mission_status'];
        $isAyush = ((int) $a['course_type'] === 1);

        if ($S == 15) return array(0, 'Withdrawn / excluded', 'This application has been withdrawn or excluded. No further action.', 'none', 'closed');
        if ($S == 12) return array(0, 'Student declined the scholarship', 'The student was offered the scholarship but declined it. No further action.', 'none', 'closed');
        if ($M == 2)  return array(0, 'Not recommended by your Mission', 'Your Mission did not recommend this application. No further action.', 'none', 'closed');
        if ($S == 14) return array(7, 'Arrived in India', 'The student has reached India and joined. Nothing pending.', 'none', 'done');
        if ($S == 13) return array(6, 'Visa endorsed, travel being arranged', 'The student should book the ticket and upload the travel plan in the portal.', 'student', 'wait');
        if ($S == 11) return array(5, 'Student accepted the offer', 'The student has accepted the scholarship. Your Mission can now endorse the student visa (menu: Student/Research VISA Endorsement).', 'mission', 'action');
        if ($S == 10 && $M == 1) return array(4, 'Scholarship awarded by your Mission', 'Waiting for the student to log in, accept the offer and upload the signed undertaking.', 'student', 'wait');
        if ($S == 10) {
            if ($isAyush && !$ayushLetter) {
                return array(3, 'Admission confirmed, waiting for AYUSH letter', 'ICCR HQ (AYUSH desk) must upload the university letter first. The Process button will open after that.', 'hq', 'wait');
            }
            return array(3, 'Admission confirmed, your Mission to award', 'The university has admitted the student and ICCR HQ has sent the case to you. Please process / award the scholarship.', 'mission', 'action');
        }
        if ($S == 5) return array(1, 'Sent back to student for corrections', 'Some documents are missing or wrong. The student must correct them and re-submit.', 'student', 'action');

        // Below status 10: still with the universities. Look at each choice.
        $codes = array();
        foreach ($unis as $u) { $codes[] = (int) $u['uni_status']; }
        $accepted = FALSE;
        foreach ($resps as $r) { if ((int) $r['university_is_accept'] === 1) { $accepted = TRUE; } }

        if (empty($codes)) {
            return array(1, 'Submitted, no university choice found', 'The application is submitted but no university choice is saved. Please inform ICCR HQ with the application number.', 'hq', 'warn');
        }
        if ($accepted || in_array(6, $codes) || in_array(11, $codes) || in_array(8, $codes)) {
            return array(3, 'Admission offered by a university', 'A university has offered admission. ICCR HQ will confirm it and send the case to your Mission for award.', 'hq', 'wait');
        }
        if (in_array(5, $codes)) return array(2, 'University sent it back to the student', 'The university asked the student to correct the application and re-submit.', 'student', 'action');
        $allRejected = TRUE;
        foreach ($codes as $c) { if ($c !== 7) { $allRejected = FALSE; } }
        if ($allRejected) return array(0, 'Not admitted by any chosen university', 'Every university the student chose has declined admission for this session.', 'none', 'closed');
        if (in_array(3, $codes)) return array(2, 'On hold with a university', 'A university has put the application on hold. Waiting for the university.', 'university', 'wait');
        return array(2, 'Universities are reviewing', 'The application is with the universities the student chose. Waiting for their decision.', 'university', 'wait');
    }

    /**
     * iccr_university_status_mapping is filled with a plain INSERT, so a
     * double submit / re-submission stores the same university twice, and the
     * copies can disagree (one "Admission offered", one "Reviewing").
     * Keep ONE row per university:
     *   - if the university has answered in iccr_university_response, the row
     *     matching that answer wins (accepted -> admission offered, rejected -> not admitted);
     *   - otherwise the row with the furthest-along decision wins.
     * Only the screen is de-duplicated; the database is not touched.
     */
    private function uniqueChoices($unis, $resps) {
        $rank = array(8 => 9, 11 => 8, 6 => 7, 7 => 6, 5 => 5, 3 => 4, 9 => 3, 2 => 2, 1 => 1);
        $answer = array();
        foreach ($resps as $r) { $answer[$r['regional_university']] = (int) $r['university_is_accept']; }
        $best = array(); $order = array();
        foreach ($unis as $u) {
            $key = $u['regional_university'];
            $c = (int) $u['uni_status'];
            $score = isset($rank[$c]) ? $rank[$c] : 0;
            if (isset($answer[$key])) {
                if ($answer[$key] === 1 && in_array($c, array(6, 8, 11))) { $score += 100; }
                if ($answer[$key] === 2 && $c === 7) { $score += 100; }
            }
            if (!isset($best[$key])) { $order[] = $key; $best[$key] = array($score, $u); }
            elseif ($score > $best[$key][0]) { $best[$key] = array($score, $u); }
        }
        $out = array();
        foreach ($order as $key) { $out[] = $best[$key][1]; }
        return $out;
    }

    /** Everything the tracker page needs, in one call. */
    public function buildTracker($missionIds, $year) {
        $rows = $this->getApplications($missionIds, $year);

        // de-duplicate (a student can have more than one "other details" row)
        $apps = array();
        foreach ($rows as $r) {
            if (!isset($apps[$r['application_no']])) { $apps[$r['application_no']] = $r; }
        }
        $appNos = array_keys($apps);

        $unisBy = array();
        foreach (array_chunk($appNos, 500) as $chunk) {
            foreach ($this->getUniversityChoices($chunk) as $u) { $unisBy[$u['application_id']][] = $u; }
        }
        $respBy = array();
        foreach (array_chunk($appNos, 500) as $chunk) {
            foreach ($this->getUniversityResponses($chunk) as $u) { $respBy[$u['application_id']][] = $u; }
        }
        $ayushLetters = array();
        foreach (array_chunk($appNos, 500) as $chunk) {
            $ayushLetters = $ayushLetters + $this->getAyushLetterAppNos($chunk);
        }

        $today = strtotime(date('Y-m-d'));
        $out = array();
        foreach ($apps as $no => $a) {
            $resps = isset($respBy[$no]) ? $respBy[$no] : array();
            $unis  = $this->uniqueChoices(isset($unisBy[$no]) ? $unisBy[$no] : array(), $resps);
            list($step, $title, $explain, $who, $tone) = $this->stageOf($a, $unis, $resps, isset($ayushLetters[$no]));

            // university placed with (confirmed_to_mission = 1), else the ones that offered admission
            $placed = NULL; $offered = array(); $respByUni = array();
            foreach ($resps as $r) {
                $respByUni[$r['regional_university']] = $r;
                if ((int) $r['confirmed_to_mission'] === 1) { $placed = $r; }
                if ((int) $r['university_is_accept'] === 1) { $offered[] = $r['university_name']; }
            }

            $uniList = array();
            foreach ($unis as $u) {
                list($words, $utone) = $this->universityStatusWords($u['uni_status']);
                $r = isset($respByUni[$u['regional_university']]) ? $respByUni[$u['regional_university']] : NULL;
                if ($r && (int) $r['university_is_accept'] === 2 && (int) $u['uni_status'] !== 7) { $words = 'Not admitted'; $utone = 'closed'; }
                if ($r && (int) $r['confirmed_to_mission'] === 1) { $words = 'Placed here (final university)'; $utone = 'good'; }
                $uniList[] = array(
                    'name'    => $u['university_name'] ? $u['university_name'] : '(university name missing - inform ICCR HQ)',
                    'state'   => (string) $u['state'],
                    'status'  => $words,
                    'tone'    => $utone,
                    'remarks' => trim((string) $u['university_remarks'] . ($r && $r['reject_reason'] ? ' ' . $r['reject_reason'] : '')),
                    'decided' => $r ? $this->niceDate($r['region_one_status_date']) : '',
                );
            }

            $alerts = array();
            $joinTs = $placed ? $this->toTimestamp($placed['date_of_joining']) : 0;
            if ($joinTs && $joinTs < $today && $step >= 3 && $step <= 6) {
                $alerts[] = 'Joining date (' . date('d M Y', $joinTs) . ') has passed. The student should confirm late joining with the university before travelling.';
            }
            foreach ($unis as $u) {
                if (!$u['university_name']) { $alerts[] = 'One university choice has no name saved. Please inform ICCR HQ.'; break; }
            }

            $name = trim(preg_replace('/\s+/', ' ', $a['fullname'] . ' ' . $a['middlename'] . ' ' . $a['familyname']));
            $out[] = array(
                'no'        => $no,
                'name'      => $name,
                'email'     => (string) $a['email'],
                'phone'     => (string) $a['phone_number'],
                'passport'  => (string) $a['passport_no'],
                'country'   => (string) $a['country_name'],
                'programme' => $a['programme_name'] ? $a['programme_name'] : '',
                'ayush'     => ((int) $a['course_type'] === 1),
                'applied'   => $this->niceDate($a['submitted_on']),
                'step'      => $step,
                'stage'     => $title,
                'explain'   => $explain,
                'who'       => $who,
                'tone'      => $tone,
                'placed'    => $placed ? (string) $placed['university_name'] : '',
                'offered'   => array_values(array_unique(array_filter($offered))),
                'joining'   => $placed ? $this->niceDate($placed['date_of_joining']) : '',
                'duration'  => $placed ? (string) $placed['duration_of_course'] : '',
                'awardedOn' => ((int) $a['mission_status'] === 1) ? $this->niceDate($a['mission_status_date']) : '',
                'unis'      => $uniList,
                'alerts'    => $alerts,
            );
        }
        return $out;
    }
}

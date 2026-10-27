<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Gyan Setu export – builds the same rows, in the same column order, as the
 * API Home::confirmedStudentAPINew(), so the Admin Panel can download them as
 * an Excel file without Postman.
 *
 * Read-only: it only runs SELECT queries.
 * The course classifier below is an exact copy of Home::_classifyCourseCode().
 * If that function is changed, copy the change here too.
 *
 * The Excel file is written by write_xlsx() below, not by PHPExcel: the
 * PHPExcel 1.8.0 copy in third_party does not load on PHP 8 (old "$s{0}"
 * syntax), so using it would crash the download.
 */
class Gyansetu_export
{
    /** Column order of the API / Gyan Setu sheet. */
    public $columns = array('application_no', 'first_name', 'middle_name', 'last_name', 'gender', 'email', 'country_name', 'mission_name',
        'Name and Code of Scholarship Scheme', 'Level (UG/PG/ PhD/MPhil/ Post Doctoral)', 'course', 'course_fullname', 'stream',
        'Name Of University/Institute', 'ZO/S-ZO/RPO', 'phone_number', 'whatsapp_number', 'passport_no', 'passport_issue_date',
        'passport_expiry_date', 'passport_issue_place', 'acedemic_year', 'place_of_birth', 'visa_no', 'visa_isuue_date',
        'visa_expiry_date', 'date_of_arrival', 'date_of_joining', 'duration_of_course', 'created_date');

    /** Personal-contact / passport columns that can be left out of a download. */
    public $sensitive = array('phone_number', 'whatsapp_number', 'passport_no', 'passport_issue_date', 'passport_expiry_date', 'passport_issue_place', 'place_of_birth');

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('hqrs_model');
        $this->CI->load->model('common_model');
    }

    private function dmy($v)
    {
        if (empty($v)) { return ''; }
        $d = date_create($v);
        return $d ? date_format($d, 'd-m-Y') : '';
    }

    /**
     * @param string $year   e.g. "2026" (same value the API takes in the URL)
     * @param array  $appNos optional list of application numbers; empty = everyone
     * @return array list of rows keyed by $this->columns
     */
    public function build_rows($year, $appNos = array())
    {
        $db = $this->CI->db;
        $result = $this->CI->hqrs_model->getAllStudentData($year, array('iccr_status' => 1, 'status' => 10));
        if (!is_array($result)) { $result = array(); }

        if (!empty($appNos)) {
            $want = array_flip($appNos);
            $result = array_values(array_filter($result, function ($r) use ($want) { return isset($want[$r['application_no']]); }));
        }

        $missions = $schemes = $programs = $unis = $regions = $ctypes = $noms = array();
        foreach ($result as $r) {
            $missions[$r['application_through']] = true;
            $schemes[$r['scholarship_id']] = true;
            $programs[$r['programme']] = true;
            $u = $r['course_type'] == 1 ? $r['regional_university_ayush'] : $r['regional_university'];
            if ($u) { $unis[$u] = true; }
            $g = $r['course_type'] == 1 ? $r['region_one_status_ayush'] : $r['region_one_status'];
            if ($g) { $regions[$g] = true; }
            $ctypes[$r['course_type']] = true;
            if (!empty($r['nomenclature'])) { $noms[$r['nomenclature']] = true; }
        }
        foreach (array_keys($missions) as $k) { $missions[$k] = $db->get_where('iccr_missions', array('id' => $k))->row(); }
        foreach (array_keys($schemes) as $k)  { $schemes[$k]  = $this->CI->common_model->getSchemeById($k); }
        foreach (array_keys($programs) as $k) { $programs[$k] = $this->CI->common_model->getProgrammeById($k); }
        foreach (array_keys($unis) as $k)     { $unis[$k]     = $this->CI->common_model->getFinalUniversityById($k); }
        foreach (array_keys($regions) as $k)  { $regions[$k]  = $this->CI->common_model->getRegionById($k); }
        foreach (array_keys($ctypes) as $k)   { $row = $db->get_where('iccr_course_type', array('id' => $k))->row(); $ctypes[$k] = $row ? $row->course_type : ''; }
        foreach (array_keys($noms) as $k)     { $noms[$k]     = $this->CI->common_model->getnomenclatureByid($k); }

        $out = array();
        foreach ($result as $r) {
            $m       = isset($missions[$r['application_through']]) ? $missions[$r['application_through']] : NULL;
            $scheme  = isset($schemes[$r['scholarship_id']]) ? $schemes[$r['scholarship_id']] : array();
            $program = isset($programs[$r['programme']]) ? $programs[$r['programme']] : array();
            $ayush   = ($r['course_type'] == 1);

            $created = $ayush
                ? (!empty($r['region_one_status_date']) ? date('d-m-Y', $r['region_one_status_date']) : '')
                : (!empty($r['undertaking_doc']) ? date('d-m-Y', $r['undertaking_doc']) : '');
            $joining  = $this->dmy($ayush ? $r['date_of_joining_ayush'] : $r['date_of_joining']);
            $duration = $ayush ? (isset($r['duration_of_course_ayush']) ? $r['duration_of_course_ayush'] : '') : (isset($r['duration_of_course']) ? $r['duration_of_course'] : '');
            $regionId = $ayush ? $r['region_one_status_ayush'] : $r['region_one_status'];
            $uniId    = $ayush ? $r['regional_university_ayush'] : $r['regional_university'];
            $uni      = isset($unis[$uniId]) ? $unis[$uniId] : array();
            $region   = isset($regions[$regionId]) ? $regions[$regionId] : array();
            $nom      = isset($noms[$r['nomenclature']]) ? $noms[$r['nomenclature']] : array();
            $nomName  = isset($nom[0]['title']) ? $nom[0]['title'] : '';
            $nomName  = trim(preg_replace('/\s+/', ' ', preg_replace('/[^A-Za-z0-9 ]/', '', $nomName)));
            $level    = isset($program[0]['name']) ? $program[0]['name'] : '';

            $arrival = '';
            if (!empty($r['new_travel_date'])) {
                try { $dt = new DateTime($r['new_travel_date']); $arrival = $dt->format('d-m-Y'); } catch (Exception $e) { $arrival = ''; }
            }

            $out[] = array(
                'application_no' => $r['application_no'],
                'first_name' => $r['fullname'],
                'middle_name' => $r['middlename'],
                'last_name' => $r['familyname'],
                'gender' => $r['gender'] == 1 ? 'Male' : ($r['gender'] == 2 ? 'Female' : ''),
                'email' => $r['email'],
                'country_name' => $r['country_name'],
                'mission_name' => $m && isset($m->mission_name) ? $m->mission_name : '',
                'Name and Code of Scholarship Scheme' => isset($scheme[0]['scheme_name']) ? $scheme[0]['scheme_name'] : '',
                'Level (UG/PG/ PhD/MPhil/ Post Doctoral)' => $level,
                'course' => $this->classify_course_code($nomName, $level),
                'course_fullname' => $nomName,
                'stream' => isset($ctypes[$r['course_type']]) ? $ctypes[$r['course_type']] : '',
                'Name Of University/Institute' => isset($uni[0]['name']) ? $uni[0]['name'] : '',
                'ZO/S-ZO/RPO' => isset($region[0]['name']) ? $region[0]['name'] : '',
                'phone_number' => ltrim((string) $r['phone_number'], '+'),
                'whatsapp_number' => $r['whatsapp_number'],
                'passport_no' => $r['passport_no'],
                'passport_issue_date' => $this->dmy($r['passport_issue_date']),
                'passport_expiry_date' => $this->dmy($r['passport_expiry_date']),
                'passport_issue_place' => $r['passport_issue_place'],
                'acedemic_year' => $r['acedemic_year'],
                'place_of_birth' => $r['city'],
                'visa_no' => $r['visa_no'],
                'visa_isuue_date' => $this->dmy($r['visa_isuue_date']),
                'visa_expiry_date' => $this->dmy($r['visa_to_date']),
                'date_of_arrival' => $arrival,
                'date_of_joining' => $joining,
                'duration_of_course' => $duration,
                'created_date' => $created,
            );
        }
        return $out;
    }

	   public function classify_course_code($fullname, $levelName)
	   {
			$fn = strtoupper((string) $fullname);
			$fn = preg_replace('/[^A-Z0-9 ]/', ' ', $fn);
			$fn = trim(preg_replace('/\s+/', ' ', $fn));
			$lvl = strtoupper(trim((string) $levelName));

			if ($fn === '') {
				return '';
			}

			$has = function ($phrase) use ($fn) {
				return strpos($fn, $phrase) !== false;
			};
			$anyOf = function (...$phrases) use ($fn) {
				foreach ($phrases as $p) {
					if (strpos($fn, $p) !== false) return true;
				}
				return false;
			};
			$allOf = function (...$phrases) use ($fn) {
				foreach ($phrases as $p) {
					if (strpos($fn, $p) === false) return false;
				}
				return true;
			};
			// Exact-token-or-space-bounded prefix match.
			$starts = function ($tok) use ($fn) {
				return $fn === $tok || strpos($fn, $tok . ' ') === 0;
			};

			// Non-Western / no-canonical-equivalent degree naming.
			if ($anyOf('ACHARAYA', 'ACHARYA')) {
				return 'Others';
			}

			if (($has('POST') && $has('DOCTORAL')) || $lvl === 'POST DOCTORAL') {
				return 'Post Doctoral';
			}

			if ($anyOf('PHD', 'PH D') || ($has('DOCTOR') && $has('PHILOSOPHY')) || $lvl === 'PHD') {
				if ($has('CIVIL')) return 'Ph.D(Civil Engg.)';
				if ($anyOf('CSE') || $allOf('COMPUTER', 'SCIENCE')) return 'Ph.D(CSE)';
				return 'PhD';
			}

			if ($anyOf('MPHIL', 'M PHIL')) {
				return 'M Phil';
			}

			if ($has('CERTIFICATE') || $lvl === 'CERTIFICATE') {
				return 'Certificate course';
			}

			// DIPLOMA, but not when the only occurrence is inside "DIPLOMACY"
			// (e.g. "MA POLITICS INTERNATIONAL RELATIONS AND DIPLOMACY" is an
			// MA, not a Diploma Course).
			$fnNoDiplomacy = str_replace('DIPLOMACY', '', $fn);
			if (strpos($fnNoDiplomacy, 'DIPLOMA') !== false || $lvl === 'DIPLOMA') {
				return 'Diploma Course';
			}

			if ($has('LLB')) return 'BA LLB';
			if ($has('LLM') || ($has('MASTER') && $has('LAW'))) return 'LLM';

			// An explicit BTECH/MTECH/BE/ME prefix is the strongest possible
			// signal of the actually-awarded degree, and is checked here -
			// before Journalism/Tourism/Architecture/etc - so it always wins
			// over a subject word appearing later in the name. E.g. "BTECH
			// NAVAL ARCHITECTURE AND MARINE ENGINEERING" is a Bachelor of
			// TECHNOLOGY, not a Bachelor of Architecture, even though
			// "architecture" appears in the text.
			$isEngPrefix = (strpos($fn, 'BTECH') === 0) || (strpos($fn, 'MTECH') === 0)
				|| (strpos($fn, 'BE ') === 0) || (strpos($fn, 'ME ') === 0)
				|| in_array($fn, array('BE', 'ME', 'BTECH', 'MTECH'), true);
			if ($isEngPrefix) {
				$isPg = (strpos($fn, 'MTECH') === 0) || (strpos($fn, 'ME') === 0) || ($lvl === 'PG');
				$isCse = $has('CSE') || $allOf('COMPUTER', 'SCIENCE') || $allOf('COMPUTER', 'ENGINEERING');
				if ($isPg) {
					if ($isCse) return 'M.Tech(CSE)';
					if (strpos($fn, 'ME') === 0 && strpos($fn, 'MTECH') !== 0) return 'ME';
					return 'MTech';
				} else {
					if (strpos($fn, 'BE') === 0 && strpos($fn, 'BTECH') !== 0) return 'BE';
					return 'BTech';
				}
			}

			// Journalism / Mass Comm - checked before generic engineering/
			// design/etc, and before the generic B/M subject fallback.
			if ($has('JOURNALISM') || $allOf('MASS', 'COMMUNICATION')) {
				// NOTE: deliberately does not use bare "MA" as a text trigger -
				// it's a substring of the glued-typo "JOURNALISMA" ("JOURNALISM
				// AND" missing the space), which would wrongly flag UG
				// (BA-level) journalism records as PG. The Level field is
				// reliable in this dataset, so it alone decides once the
				// longer/safer text hints don't apply.
				$pgLike = ($lvl === 'PG') || $anyOf('MASTER', 'MASTERS', 'MSC', 'MBA', 'MSW');
				$both = $has('JOURNALISM') && $allOf('MASS', 'COMMUNICATION');
				$massOnly = $allOf('MASS', 'COMMUNICATION') && !$has('JOURNALISM');
				if ($pgLike) {
					if ($both || $massOnly) return $both ? 'MMCJ' : 'MJMC';
					return 'Master of Journalism';
				} else {
					if ($both || $massOnly) return 'BJMC';
					return 'Bachelor of Journalism';
				}
			}

			// Tourism - bare MTTM/BTTM abbreviation prefixes first (no
			// "TOURISM" word present in those records at all), then
			// text-based detection.
			if ($starts('MTTM')) return 'MTTM';
			if ($starts('BTTM')) return 'BTTM';
			if ($allOf('TOURISM', 'TRAVEL')) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MBA') || $has('MSC')) ? 'MTTM' : 'BTTM';
			}
			if ($has('TOURISM')) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MBA') || $has('MSC')) ? 'MTTM' : 'BTM';
			}

			// Architecture - bare "MARCH"/"BARCH" abbreviation prefixes first
			// (e.g. "MARCH URBAN REGENERATION" has no literal "ARCHITECTURE"
			// word).
			if ($starts('MARCH')) return 'MArch';
			if ($starts('BARCH')) return 'BArch';
			if ($has('ARCHITECTURE')) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MARCH')) ? 'MArch' : 'BArch';
			}
			if ($allOf('URBAN', 'REGIONAL', 'PLANNING') || $has('MURP')) return 'MURP';
			if ($has('PLANNING')) return 'MPlan';

			// Engineering / Tech content-word detection, for records with NO
			// literal BTECH/MTECH/BE/ME prefix (that case was already handled
			// above). Checked BEFORE the generic "design" rule, so things like
			// "ME VLSI DESIGN" register as engineering, not MDesign, just
			// because "design" appears in the specialization name.
			//
			// Bare "TECHNOLOGY" is deliberately NOT treated as an engineering
			// signal when "SCIENCE" is also present, or when the record has an
			// explicit "MSC"/"BSC" prefix - "MSC FOOD SCIENCE AND TECHNOLOGY"
			// and "MSC E LEARNING TECHNOLOGY" are Science degrees, not
			// engineering ones, even though the word "technology" appears in
			// them.
			$isEngWord = $anyOf('ENGINEERING', 'CSE', 'VLSI', 'MECHATRONICS')
				|| ($has('TECHNOLOGY') && !$has('SCIENCE') && strpos($fn, 'MSC') !== 0 && strpos($fn, 'BSC') !== 0);
			if ($isEngWord) {
				$isPg = ($lvl === 'PG') || $has('MASTER');
				$isCse = $has('CSE') || $allOf('COMPUTER', 'SCIENCE') || $allOf('COMPUTER', 'ENGINEERING');
				if ($isPg) {
					return $isCse ? 'M.Tech(CSE)' : 'MTech';
				} else {
					return 'BTech';
				}
			}

			if ($starts('MDES')) return 'MDesign';
			// Skip the generic DESIGN-word rule when the record already
			// carries an explicit "MSC"/"BSC" prefix (e.g. "MSC TEXTILES AND
			// APPAREL DESIGN") - that prefix is a stronger signal of the
			// actually-awarded degree than the word "design" appearing in the
			// specialization name, so let it fall through to the MSc/Bsc
			// prefix-override in the final fallback instead.
			if ($has('DESIGN') && !$has('ENGINEERING') && strpos($fn, 'MSC') !== 0 && strpos($fn, 'BSC') !== 0) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MDES')) ? 'MDesign' : 'BDesign';
			}

			if ($has('AYURVED') || $has('BAMS')) return 'BAMS';
			if ($anyOf('HOMOEOPATH', 'HOMEOPATH', 'BHMS')) return 'BHMS';
			if ($allOf('PUBLIC', 'HEALTH')) return $lvl === 'UG' ? 'MPH' : 'Masters (Public Health)';
			if ($has('MD') && !$anyOf('MEDIA', 'MEDIUM') && preg_match('/\bMD\b/', $fn)) {
				return 'MD';
			}
			if ($anyOf('PHARM', 'PHARMA', 'PHARMACY', 'PHARMACEUTICAL')) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MSC') || $has('MTECH')) ? 'MPharm' : 'BPharm';
			}

			if ($starts('MVSC')) return 'MVSc';
			if ($starts('BVSC')) return 'BVSc';
			if ($has('VETERINARY') || $has('VETERIANRY')) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MVSC')) ? 'MVSc' : 'BVSc';
			}
			if ($has('BSMS')) return 'BSMS';
			if ($allOf('VETERINARY', 'TECHNOLOGY') || $has('BVT')) return 'BVT';

			// Hotel Management - bare "BHM" abbreviation prefix first (no
			// literal "HOTEL" word in those records at all). Guarded so it
			// doesn't swallow "BHMS" (Homoeopathy) or "BHMCT", which both
			// share the "BHM" letters but are distinct canonical values.
			if ($starts('BHM')) return 'BHM';
			if ($has('HOTEL') && $has('CATERING')) return 'BHMCT';
			if ($has('HOTEL')) return 'BHM';

			if ($allOf('INTERNATIONAL', 'BUSINESS') || $has('MIB')) {
				return $lvl !== 'UG' ? 'MBA' : 'BBA';
			}
			if ($has('BBA') || $allOf('BUSINESS', 'ADMINISTRATION')) {
				return ($lvl === 'PG' || $has('MASTER')) ? 'MBA' : 'BBA';
			}
			if ($allOf('MANAGEMENT', 'STUDIES') || $has('MMS') || $has('BMS')) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MBA')) ? 'MMS' : 'BMS';
			}
			if ($has('MHRD') || $allOf('HUMAN', 'RESOURCE', 'DEVELOPMENT')) return 'MHRD';
			if ($has('HRM') || $allOf('HUMAN', 'RESOURCE')) return 'MHRM';
			if ($has('COMMERCE') || strpos($fn, 'BCOM') === 0 || strpos($fn, 'MCOM') === 0) {
				return ($lvl === 'PG' || strpos($fn, 'MCOM') === 0 || $has('MASTER')) ? 'MCom' : 'BCom';
			}
			if ($allOf('OPERATIONAL', 'RESEARCH') || $allOf('OPERATIONS', 'RESEARCH')) return 'MS';
			if ($has('MBA')) return 'MBA';
			if ($has('MANAGEMENT')) return ($lvl === 'PG' || $has('MASTER')) ? 'MBA' : 'BBA';

			if ($allOf('COMPUTER', 'APPLICATION') || $has('MCA') || $has('BCA')) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MCA')) ? 'MCA' : 'BCA';
			}

			if (($has('PHYSICAL') && $has('EDUCATION')) || $has('MPED') || $has('SPORT') || $has('SPORTS')) {
				return $lvl !== 'UG' ? 'MPEd' : 'BEd';
			}

			// Education - bare "MED"/"BED" abbreviation (no literal
			// "EDUCATION" word at all in that record) before the text-based
			// check.
			if ($starts('MED')) return 'MEd';
			if ($starts('BED')) return 'BEd';
			if ($has('EDUCATION')) {
				return ($lvl === 'PG' || $has('MASTER') || $has('MED')) ? 'MEd' : 'BEd';
			}

			if ($has('SOCIAL') && $has('WORK')) {
				return ($lvl === 'PG' || $has('MASTER')) ? 'MSW' : 'BSW';
			}

			// Performing / Fine / Visual arts - bare abbreviation prefixes
			// first ("MPA DANCE KATHAK", "BFA PAINTING", "MVA GRAPHIC ARTS"
			// etc have no literal "PERFORMING"/"FINE"/"VISUAL" word at all),
			// then text-based.
			if ($starts('MPA')) return 'MPA';
			if ($starts('BPA')) return 'BPA';
			if ($starts('MFA')) return 'MFA';
			if ($starts('BFA')) return 'BFA';
			if ($starts('MVA')) return 'MVA';
			if ($starts('BVA')) return 'BVA';
			if ($has('SANGEET') || $has('MUSIC')) return 'BMusic';
			if (($has('PERFORMING') && $has('ART')) || ($has('PERFORMING') && $has('ARTS'))) {
				return $lvl !== 'UG' ? 'MPA' : 'BPA';
			}
			if ($has('VISUAL') && ($has('ART') || $has('ARTS'))) {
				return ($lvl === 'PG' || $has('MASTER')) ? 'MVA' : 'BVA';
			}
			if ($has('FINE') && ($has('ART') || $has('ARTS'))) {
				return ($lvl === 'PG' || $has('MASTER')) ? 'MFA' : 'BFA';
			}

			if ($has('VOCATIONAL') || strpos($fn, 'BVOC') === 0 || $has('MVOC')) return 'BVoc';

			// Bare "MS" abbreviation (e.g. "MS CYBER SECURITY", "MS
			// BIOTECHNOLOGY") - word-boundary guarded since "MS" is a
			// substring of "SYSTEMS"/"MSC"/"BMS"/"MSW" etc. Placed after all
			// more-specific category checks above so it never steals a
			// record that already matched something better.
			if (preg_match('/\bMS\b/', $fn)) return 'MS';

			// No Library Science canonical value exists in the verified
			// 76-list.
			if ($starts('MLIB')) return 'Others';

			$scienceKw = array('SCIENCE', 'PHYSICS', 'CHEMISTRY', 'BIOLOGY', 'BIOTECHNOLOGY',
				'MICROBIOLOGY', 'MATHEMATICS', 'ZOOLOGY', 'BOTANY', 'GEOINFORMATICS',
				'FORENSIC', 'ENVIRONMENTAL', 'STATISTICS', 'BIOCHEMISTRY', 'GEOGRAPHY',
				'NUTRITION');
			// "POLITICAL SCIENCE" / "POLICE SCIENCE" are Arts/Social-science
			// subjects that happen to contain the word "SCIENCE" - strip them
			// out before the generic science-keyword check so they don't get
			// bucketed as Bsc/MSc.
			$fnSciCheck = str_replace(array('POLITICAL SCIENCE', 'POLICE SCIENCE'), '', $fn);
			$hasScienceKw = false;
			foreach ($scienceKw as $kw) {
				if (strpos($fnSciCheck, $kw) !== false) { $hasScienceKw = true; break; }
			}

			// An explicit "BSC"/"MSC"/"BA"/"MA" prefix is the strongest
			// possible signal of the actually-awarded degree and is honored
			// first - this covers data-entry typos (e.g. "MSC COMPUTER
			// SCEINCE", where "SCIENCE" is misspelled so the keyword list
			// above would miss it), subjects the keyword list doesn't
			// enumerate (e.g. "MSC TEXTILES AND APPAREL DESIGN"), and the
			// reverse case where a subject name merely contains a
			// science-sounding word but was explicitly awarded as an MA/BA
			// (e.g. "MA GEOGRAPHY", "BA HONS POLITICAL SCIENCE" - "geography"
			// and "science" are in the keyword list, but the literal
			// "MA"/"BA" prefix wins). Only when there is no explicit prefix at
			// all does the keyword-based guess decide.
			if ($lvl === 'UG') {
				if ($starts('BSC')) return 'Bsc';
				if ($starts('BA')) return 'BA';
				return $hasScienceKw ? 'Bsc' : 'BA';
			}
			if ($lvl === 'PG') {
				if ($starts('MSC')) return 'MSc';
				if ($starts('MA')) return 'MA';
				return $hasScienceKw ? 'MSc' : 'MA';
			}

			return 'Others';
	   }

    /* ==============================================================
       Excel (.xlsx) writer - small and self-contained, needs only ZipArchive.
       Every cell is text, so phone numbers and passport numbers keep their
       digits and leading zeros. Row 1 is bold and stays visible on scroll.
       ============================================================== */

    /** Column letter for a 0-based index: 0 -> A, 26 -> AA. */
    private function col_letter($i)
    {
        $s = '';
        for ($i = $i + 1; $i > 0; $i = intdiv($i - 1, 26)) {
            $s = chr(65 + ($i - 1) % 26) . $s;
        }
        return $s;
    }

    /** Text safe for XML: drops control characters Excel refuses to open. */
    private function xml_text($v)
    {
        $v = (string) $v;
        if (function_exists('mb_convert_encoding')) { $v = mb_convert_encoding($v, 'UTF-8', 'UTF-8'); }
        $v = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}]/u', '', $v);
        return htmlspecialchars((string) $v, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    private function cell($ref, $v, $style = 0)
    {
        $t = $this->xml_text($v);
        $sp = ($t !== '' && ($t[0] === ' ' || substr($t, -1) === ' ')) ? ' xml:space="preserve"' : '';
        return '<c r="' . $ref . '" t="inlineStr"' . ($style ? ' s="' . $style . '"' : '') . '><is><t' . $sp . '>' . $t . '</t></is></c>';
    }

    /**
     * Writes the rows to a temporary .xlsx file and returns its path,
     * or FALSE when ZipArchive is not available (the caller then sends CSV).
     */
    public function write_xlsx($columns, $rows)
    {
        if (!class_exists('ZipArchive')) {
            return FALSE;
        }
        $path = tempnam(sys_get_temp_dir(), 'gsx');
        $zip = new ZipArchive();
        if ($path === FALSE || $zip->open($path, ZipArchive::OVERWRITE) !== TRUE) {
            return FALSE;
        }
        $last = $this->col_letter(count($columns) - 1);

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
             . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
             . '<dimension ref="A1:' . $last . (count($rows) + 1) . '"/>'
             . '<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>'
             . '<cols><col min="1" max="' . count($columns) . '" width="18" customWidth="1"/></cols><sheetData>';
        $cells = '';
        foreach ($columns as $i => $c) { $cells .= $this->cell($this->col_letter($i) . '1', $c, 1); }
        $xml .= '<row r="1">' . $cells . '</row>';
        $letters = array();
        foreach ($columns as $i => $c) { $letters[$i] = $this->col_letter($i); }
        $n = 2;
        foreach ($rows as $r) {
            $cells = '';
            foreach ($columns as $i => $c) {
                $v = isset($r[$c]) ? (string) $r[$c] : '';
                if ($v !== '') { $cells .= $this->cell($letters[$i] . $n, $v); }
            }
            $xml .= '<row r="' . $n . '">' . $cells . '</row>';
            $n++;
        }
        $xml .= '</sheetData><autoFilter ref="A1:' . $last . '1"/></worksheet>';

        $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>');
        $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>');
        $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Sheet1" sheetId="1" r:id="rId1"/></sheets>'
            . '<definedNames><definedName name="_xlnm._FilterDatabase" localSheetId="0" hidden="1">Sheet1!$A$1:$' . $last . '$1</definedName></definedNames>'
            . '</workbook>');
        $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>');
        $zip->addFromString('xl/styles.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<numFmts count="0"/>'
            . '<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><name val="Calibri"/></font></fonts>'
            . '<fills count="2"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill></fills>'
            . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="2"><xf numFmtId="49" fontId="0" fillId="0" borderId="0" xfId="0" applyNumberFormat="1"/>'
            . '<xf numFmtId="49" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1" applyNumberFormat="1"/></cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>');
        $zip->addFromString('xl/worksheets/sheet1.xml', $xml);
        if (!$zip->close()) {
            @unlink($path);
            return FALSE;
        }
        return $path;
    }
}

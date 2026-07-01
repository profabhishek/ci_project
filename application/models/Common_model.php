<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    public $status;
    public $roles;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }
		function countgetConfirmationofCandidatesDemo($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where('iccr_status_mapping.created >=',1612227054); 
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function getMissionDetails($appno) {
        $this->db->select('mission_person_signature,mission_person_name,mission_person_designation,mission_person_place,mission_status_date,iccr_status_updtae_date');
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 function countgetConfirmationofCandidatesAlert($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where(array('iccr_status_mapping.scholar_acceptance >=' => 1));
		$this->db->where_in('iccr_university_response.university_is_accept', array(1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687)); 
		$this->db->where('FROM_UNIXTIME(`iccr_status_mapping`.`iccr_status_date`) >= now() - INTERVAL 7 day');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function getRegionalRpDoc($appid) {
		//echo "<pre>";
						//print_r($appid);
		 $this->db->select('*');
        $this->db->from('iccr_rp_issue_documents');
        $this->db->where('application_no', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
		function getHQRSAYUSHApplicationsfs() {
		$this->db->select('*');
        //$this->db->select('iccr_status_mapping.status,iccr_status_mapping.iccr_sfs_status,iccr_student_details.created,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        //$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 1));
		$this->db->where(array('iccr_student_details.student_type' => 2));
		//$this->db->where(array('iccr_status_mapping.iccr_sfs_status' => 1));
		
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
		function getCountHQRSAYUSHProcessedApplicationsfs() {
   
		$this->db->select('*');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->where(array('iccr_student_details.student_type' => 2));
        $this->db->where(array('iccr_status_mapping.status >=' => 10));
	    $this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->order_by('iccr_student_details.created', 'ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
		 function getCountHQRSAYUSHApplicationsfs() {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status' => 1));
		$this->db->where(array('iccr_student_details.student_type' => 2));
        $code = $this->db->error();
        //     echo $this->db->_compile_select();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	 function countgetConfirmationofHqrsDemo($missionId) {
        // Used in Mission Controller
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 10));
        $this->db->where_in('iccr_university_response.university_is_accept', array(1, 2));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		$this->db->where('iccr_status_mapping.created >=',1612227054); 
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }

    function getAllVisitors() {
        $this->db->select("count(*) as total");
        $this->db->from("iccr_counter");
        return $this->db->get()->result_array();
    }
	 function getRegionalApplicationsDemoCount($regionId) {
		$this->db->distinct('iccr_status_mapping.application_no');
       /*  $this->db->select('iccr_status_mapping.status,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.email,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.uni_forwarded_letter,iccr_status_mapping.uni_forwarded_letter_two,iccr_status_mapping.uni_forwarded_letter_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject'); */
	    $this->db->select('DISTINCT(iccr_status_mapping.application_no)');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status >=' => 1));
		$this->db->where(array('iccr_status_mapping.status !=' => 5));
		$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
          $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' .$regionId .' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ')');
		  $this->db->where('iccr_status_mapping.created >=',1612227054); 
        //$this->db->order_by('iccr_status_mapping.id', 'ASC');
		$this->db->order_by('iccr_student_details.created', 'ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function applicantAyushAcceptance($schemeids) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_student_application_details.course,iccr_student_other_details.created,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >=' => 11, 'iccr_status_mapping.status >=' => 12,'iccr_status_mapping.status !=' => 15));
        $this->db->where(array('iccr_student_application_details.university_choice_one_state >=' => 0, 'iccr_student_application_details.university_choice_two_state >=' => 0, 'iccr_student_application_details.university_choice_three_state >=' => 0));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->or_where(array("iccr_student_application_details.programme" => 8));
        $this->db->where(array('iccr_student_application_details.course_type' => 0));
        $this->db->where("iccr_status_mapping.scholarship_id IS NOT NULL");
        $this->db->where("iccr_status_mapping.scholarship_id != ''");
		//$this->db->order_by('iccr_student_details.created', 'ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	 function getRegionalApplicationsCount($regionId) {
		$this->db->distinct('iccr_status_mapping.application_no');
       /*  $this->db->select('iccr_status_mapping.status,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.email,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.uni_forwarded_letter,iccr_status_mapping.uni_forwarded_letter_two,iccr_status_mapping.uni_forwarded_letter_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject'); */
	    $this->db->select('DISTINCT(iccr_status_mapping.application_no)');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status >=' => 1));
		//$this->db->where(array('iccr_status_mapping.status !=' => 5));
		//$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->where(array('iccr_student_application_details.universty_choice_fourth !=' => 489));
        $this->db->where('(iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ')');
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        //$this->db->order_by('iccr_status_mapping.id', 'ASC');
		$this->db->order_by('iccr_student_details.created', 'ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	function getRegionalTwentyTwoApplicationsCount($regionId) {
		$this->db->distinct('iccr_status_mapping.application_no');
       /*  $this->db->select('iccr_status_mapping.status,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.email,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.uni_forwarded_letter,iccr_status_mapping.uni_forwarded_letter_two,iccr_status_mapping.uni_forwarded_letter_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject'); */
	    $this->db->select('DISTINCT(iccr_status_mapping.application_no)');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status >=' => 1));
		//$this->db->where(array('iccr_status_mapping.status !=' => 5));
		//$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->where(array('iccr_student_application_details.universty_choice_fourth !=' => 489));
        $this->db->where('(iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ')');
		$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
        //$this->db->order_by('iccr_status_mapping.id', 'ASC');
		$this->db->order_by('iccr_student_details.created', 'ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function saveYoutubeLink($uid, $link) {
        $data = array(
            'youtubelink' => $link
        );

        $this->db->where('uid', $uid);
        $this->db->update('iccr_status_mapping', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }


    function insertCounter($data) {
        $q = $this->db->insert('iccr_counter', $data);
        return $this->db->insert_id();
    }

    function insertComplaint($data) {
        $q = $this->db->insert_string('iccr_complaints', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function getAllComplaints($schemeids) {
        $this->db->select('iccr_complaints.*');
        $this->db->from('iccr_complaints');
        $this->db->where_in('scheme', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getCountriesById() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where(array('id' => 103));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }
	 function getCountriesByIdNotIn() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where_not_in('id', 166);
		//$this->db->where_not_in('id', 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }
	function getCountriesByIdNotInCurrent() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where_not_in('id', 166);
		$this->db->where_not_in('id', 1);
        // $this->db->where_not_in('id', 10);
        $this->db->order_by('country_name', "ASC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }
	function getComplaintCatById($catid) {
        $this->db->select('iccr_complaint_category.category');
        $this->db->from('iccr_complaint_category');
        $this->db->where(array('id' => $catid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getUResponseById($appid) {
        $this->db->select('iccr_university_response.region_one_status,iccr_status_mapping.scholarship_id,iccr_student_other_details.signature_doc');
        $this->db->from('iccr_university_response');
        $this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_university_response.application_id');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_university_response.application_id' => $appid, 'iccr_university_response.university_is_accept' => 1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getUTwoResponseById($appid) {
        $this->db->select('iccr_university_response_by_hqrs.region_one_status,iccr_status_mapping.scholarship_id,iccr_student_other_details.signature_doc');
        $this->db->from('iccr_university_response_by_hqrs');
        $this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_university_response_by_hqrs.application_id');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_university_response_by_hqrs.application_id' => $appid, 'iccr_university_response_by_hqrs.university_is_accept' => 1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getComplaints($appid) {
        $this->db->select('iccr_complaints.*');
        $this->db->from('iccr_complaints');
        $this->db->where(array('appid' => $appid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getAllComplaintCategory() {
        $this->db->select('iccr_complaint_category.id,iccr_complaint_category.category');
        $this->db->from('iccr_complaint_category');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getICARCourseDetails($applicationno) {
        $this->db->select('course,course_two,course_three,programme,universty_choice,universty_choice_two,universty_choice_three,course_option_name,course_option_name_two,course_option_name_three,course_subject,course_type');
        $this->db->from('iccr_student_application_details');
        $this->db->where(array('application_no' => $applicationno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getCourseDetails($applicationno, $universityId) {
		//echo $applicationno;die;
        $response = array('course_id' => 0, 'course_name' => '', 'programme_id' => 0, 'subject' => '');
        $this->db->select('course,course_two,course_three,course_fourth,course_fifth,programme,universty_choice,universty_choice_two,universty_choice_three,universty_choice_fourth,universty_choice_fifth,course_option_name,course_option_name_two,course_option_name_two,course_option_name_three,course_option_name_fourth,course_option_name_fifth,course_subject,course_type');
        $this->db->from('iccr_student_application_details');
        $this->db->where(array('application_no' => $applicationno));
        $result = $this->db->get()->result_array();
		//echo "<pre>";print_r($result);die;
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if (sizeof($result) > 0) {
            if ($result[0]['programme'] == 1 || $result[0]['programme'] == 2 ||  $result[0]['programme'] == 4 || $result[0]['programme'] == 5 || $result[0]['programme'] == 8 || $result[0]['programme'] == 12 || $result[0]['programme'] == 13 || $result[0]['programme'] == 6 || $result[0]['programme'] == 9) {
                if ($result[0]['programme'] == 1 || $result[0]['programme'] == 2 || $result[0]['programme'] == 4 || $result[0]['programme'] == 8 || $result[0]['programme'] == 12 || $result[0]['programme'] == 13) {
                    if ($result[0]['course_type'] == 1 || $result[0]['course_type'] == 2) {
                        $c1 = "";
                        $c2 = "";
                        $c3 = "";
						$c4 = "";
                        $c5 = "";
                        $course = $this->common_model->getCoursesById($result[0]['course']);
                        $course1 = $this->common_model->getCoursesById($result[0]['course_two']);
                        $course2 = $this->common_model->getCoursesById($result[0]['course_three']);
						$course3 = $this->common_model->getCoursesById($result[0]['course_fourth']);
						$course4 = $this->common_model->getCoursesById($result[0]['course_fifth']);
                        $response['course_id'] = array($result[0]['course'], $result[0]['course_two'], $result[0]['course_three'],$result[0]['course_fourth'],$result[0]['course_fifth']);
                        if ($result[0]['course_option_name'] != "") {
							$strm1 = $this->common_model->getStreamById($result[0]['course_option_name']);
                            $c1 = $course[0]['title'];
                        } else {
                            $c1 = $course[0]['title'];
                        }
                        if ($result[0]['course_option_name_two'] != "") {
							$strm2 = $this->common_model->getStreamById($result[0]['course_option_name_two']);
                            $c2 = $course1[0]['title'];
                        } else {
                            $c2 = $course1[0]['title'];
                        }
                        if ($result[0]['course_option_name_three'] != "") {
							$strm3 = $this->common_model->getStreamById($result[0]['course_option_name_three']);
                            $c3 = $course2[0]['title'];
                        } else {
                            $c3 = $course2[0]['title'];
                        }
						if ($result[0]['course_option_name_fourth'] != "") {
						    $strm4 = $this->common_model->getStreamById($result[0]['course_option_name_fourth']);
                            $c4 = $course3[0]['title'] ;
                        } else {
                            $c4 = $course3[0]['title'];
                        }
						if ($result[0]['course_option_name_fifth'] != "") {
							$strm5 = $this->common_model->getStreamById($result[0]['course_option_name_fifth']);
                            $c5 = $course4[0]['title'] ;
                        } else {
                            $c5 = $course4[0]['title'];
                        }
                        $response['course_name'] = array($c1,$c2,$c3,$c4,$c5);
                        $response['programme_id'] = $result[0]['programme'];
						//print_r($response['programme_id']);die;
						$programme = $this->common_model->getProgrammeById($response['programme_id']);
                        $response['name'] = $result[0]['course_option_name'];
						$response['programme'] = $programme[0]['name'];
                        return $response;
                    } else {
                        if ($universityId == 0) {
                            $c1 = "";
                            $c2 = "";
                            $c3 = "";
							$c4 = "";
							$c5 = "";
                            $course = $this->common_model->getCoursesById($result[0]['course']);
                            $course1 = $this->common_model->getCoursesById($result[0]['course_two']);
                            $course2 = $this->common_model->getCoursesById($result[0]['course_three']);
							$course3 = $this->common_model->getCoursesById($result[0]['course_fourth']);
							$course4 = $this->common_model->getCoursesById($result[0]['course_fifth']);
                            $response['course_id'] = array($result[0]['course'], $result[0]['course_two'], $result[0]['course_three'],$result[0]['course_fourth'],$result[0]['course_fifth']);
                            if ($result[0]['course_option_name'] != "") {
								$strm1= $this->common_model->getStreamById($result[0]['course_option_name']);
                                $c1 = $course[0]['title'] . ' (' . $result[0]['course_option_name'] . ')';
                            } else {
                                $c1 = $course[0]['title'];
                            }
                            if ($result[0]['course_option_name_two'] != "") {
								$strm2 = $this->common_model->getStreamById($result[0]['course_option_name_two']);
                                $c2 = $course1[0]['title'] . ' (' . $result[0]['course_option_name_two'] . ')';
                            } else {
                                $c2 = $course1[0]['title'];
                            }
                            if ($result[0]['course_option_name_three'] != "") {
								$strm3 = $this->common_model->getStreamById($result[0]['course_option_name_three']);
                                $c3 = $course2[0]['title'] . ' (' . $result[0]['course_option_name_three'] . ')';
                            } else {
                                $c3 = $course2[0]['title'];
                            }
							 if ($result[0]['course_option_name_fourth'] != "") {
								 $strm4 = $this->common_model->getStreamById($result[0]['course_option_name_fourth']);
                                $c4 = $course3[0]['title'] . ' (' . $result[0]['course_option_name_fourth'] . ')';
                            } else {
                                $c4 = $course3[0]['title'];
                            }
							 if ($result[0]['course_option_name_fifth'] != "") {
								 $strm5 = $this->common_model->getStreamById($result[0]['course_option_name_fifth']);
								 
                                $c5 = $course4[0]['title'] . ' (' . $result[0]['course_option_name_fifth'] . 
								')';
                            } else {
                                $c5 = $course4[0]['title'];
                            }
                            $response['course_name'] = array($c1, $c2, $c3,$c4,$c5);
                            $response['programme_id'] = $result[0]['programme'];
                            $response['name'] = $result[0]['course_option_name'];
                            return $response;
                        } else {
							
							//echo "---------------";
                            if ($result[0]['universty_choice'] == $universityId) {
								//echo "---------------";die;
                                $course = $this->common_model->getCoursesById($result[0]['course']);
                                $response['course_id'] = $result[0]['course'];
                                $response['course_name'] = $course[0]['title'];
                                $response['programme_id'] = $result[0]['programme'];
								$strm1 = $this->common_model->getStreamById($result[0]['course_option_name']);
                                $response['name'] = $result[0]['course_option_name'];
                                return $response;
                            } elseif ($result[0]['universty_choice_two'] == $universityId) {
                                $course1 = $this->common_model->getCoursesById($result[0]['course_two']);
                                $response['course_id'] = $result[0]['course'];
                                $response['course_name'] = $course1[0]['title'];
                                $response['programme_id'] = $result[0]['programme'];
								$strm2 = $this->common_model->getStreamById($result[0]['course_option_name_two']);
                                $response['name'] = $result[0]['course_option_name_two'];
                                return $response;
                            } elseif ($result[0]['universty_choice_three'] == $universityId) {
                                $course2 = $this->common_model->getCoursesById($result[0]['course_three']);
                                $response['course_id'] = $result[0]['course'];
                                $response['course_name'] = $course2[0]['title'];
                                $response['programme_id'] = $result[0]['programme'];
								$strm3 = $this->common_model->getStreamById($result[0]['course_option_name_three']);
								//echo "<pre>";print_r($strm3);die;
                                $response['name'] = $result[0]['course_option_name_three'];
                                return $response;
                            }
							elseif ($result[0]['universty_choice_fourth'] == $universityId) {

                                $course3 = $this->common_model->getCoursesById($result[0]['course_fourth']);
                                $response['course_id'] = $result[0]['course'];
                                $response['course_name'] = $course3[0]['title'];
                                $response['programme_id'] = $result[0]['programme'];
								$strm4 = $this->common_model->getStreamById($result[0]['course_option_name_fourth']);
                                $response['name'] = $result[0]['course_option_name_fourth'];
                                return $response;
                            }
							elseif ($result[0]['universty_choice_fifth'] == $universityId) {
									//echo "<pre>";print_r($result[0]);die;
								//echo "-------------------4";die;
                                $course4 = $this->common_model->getCoursesById($result[0]['course_fifth']);
								//echo $course4;die;
                                $response['course_id'] = $result[0]['course'];
                                $response['course_name'] = $course4[0]['title'];
                                $response['programme_id'] = $result[0]['programme'];
								$strm5 = $this->common_model->getStreamById($result[0]['course_option_name_fifth']);
							
                                $response['name'] = $result[0]['course_option_name_fifth'];
                                return $response;
                            }
                        }
                    }
                } elseif ($result[0]['programme'] == 5 || $result[0]['programme'] == 6 || $result[0]['programme'] == 9) {
                    if ($result[0]['universty_choice'] == $universityId) {
                        $course = $this->common_model->getCoursesById($result[0]['course']);
                        $response['course_id'] = $result[0]['course'];
                        $response['course_name'] = $course[0]['title'];
                        $response['programme_id'] = $result[0]['programme'];
                        $response['subject'] = $result[0]['course_option_name'];
                        return $response;
                    } elseif ($result[0]['universty_choice_two'] == $universityId) {
                        $course1 = $this->common_model->getCoursesById($result[0]['course_two']);
                        $response['course_id'] = $result[0]['course'];
                        $response['course_name'] = $course1[0]['title'];
                        $response['programme_id'] = $result[0]['programme'];
                        $response['subject'] = $result[0]['course_option_name_two'];
                        return $response;
                    } elseif ($result[0]['universty_choice_three'] == $universityId) {
                        $course2 = $this->common_model->getCoursesById($result[0]['course_three']);
                        $response['course_id'] = $result[0]['course'];
                        $response['course_name'] = $course2[0]['title'];
                        $response['programme_id'] = $result[0]['programme'];
                        $response['subject'] = $result[0]['course_option_name_three'];
                        return $response;
                    }
                }
            } elseif ($result[0]['programme'] == 3 || $result[0]['programme'] == 7 || $result[0]['programme'] == 8) {
				
                if ($result[0]['programme'] != 7) {
                    $course = $this->common_model->getProgrammeById($result[0]['programme']);
                    $response['course_id'] = $result[0]['programme'];
                    $response['course_name'] = $course[0]['name'];
                    $response['programme_id'] = $result[0]['programme'];
                    $response['subject'] = $result[0]['course_subject'];
                    return $response;
                } else {
                    $course = $this->common_model->getProgrammeById($result[0]['programme']);
					//echo "-----------------";
					//echo "<pre>";print_r($result[0]['programme']);die;
                    $response['course_id'] = $result[0]['programme'];
                    $response['course_name'] = $course[0]['name'];
                    $response['programme_id'] = $result[0]['programme'];
                    $response['subject'] = '';
                    return $response;
                }
            }
        }
    }

    function getLableOfCourse($applicationno, $universityId) {
        $this->db->select('iccr_programme.name,iccr_programme.id');
        $this->db->join('iccr_student_application_details','iccr_student_application_details.programme=iccr_programme.id');
        $this->db->from('iccr_programme');
        $this->db->where('iccr_student_application_details.application_no', $applicationno);
        $response = $this->db->get()->result_array();
        return $response;
    }

    function getMainStream($applicationno, $universityId) {
        $this->db->select('iccr_course_type.course_type,iccr_course_type.id');
        $this->db->join('iccr_student_application_details','iccr_student_application_details.course_type=iccr_course_type.id');
        $this->db->from('iccr_course_type');
        $this->db->where('iccr_student_application_details.application_no', $applicationno);
        $response = $this->db->get()->result_array();
        return $response;
    }

    function getDurationOfCourse($applicationno, $universityId) {
        $this->db->select('iccr_programme_duration.duration');
        $this->db->join('iccr_student_application_details','iccr_student_application_details.programme=iccr_programme_duration.prog_id');
        $this->db->from('iccr_programme_duration');
        $this->db->where('iccr_student_application_details.application_no', $applicationno);
        $response = $this->db->get()->result_array();
        return $response;
    }


    function getCourseName($applicationno, $universityId) {
        $this->db->select('course,course_two,course_three,course_fourth,course_fifth,programme,universty_choice,universty_choice_two,universty_choice_three,universty_choice_fourth,universty_choice_fifth,course_option_name,course_option_name_two,course_option_name_three,course_option_name_fourth,course_option_name_fifth,course_subject,course_type');
        $this->db->from('iccr_student_application_details');
        $this->db->where(array('application_no' => $applicationno));
        $result = $this->db->get()->result_array();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if (sizeof($result) > 0) {
            if ($result[0]['programme'] == 1 || $result[0]['programme'] == 2 || $result[0]['programme'] == 5 || $result[0]['programme'] == 6 || $result[0]['programme'] == 9) {
                if ($result[0]['programme'] == 1 || $result[0]['programme'] == 2) {
                    if ($result[0]['course_type'] == 1 || $result[0]['course_type'] == 2) {
                        $course = $this->common_model->getCoursesById($result[0]['course']);
                        return $course[0]['title'] . ' ' . $result[0]['course_option_name'];
                    } else {
                        if ($result[0]['universty_choice'] == $universityId) {
                            $course = $this->common_model->getCoursesById($result[0]['course']);
							$strm1 = $this->common_model->getStreamById($result[0]['course_option_name']);
                            return $course[0]['title'] . ' ' . $result[0]['course_option_name'];
                        } elseif ($result[0]['universty_choice_two'] == $universityId) {
                            $course1 = $this->common_model->getCoursesById($result[0]['course_two']);
							$strm2 = $this->common_model->getStreamById($result[0]['course_option_name_two']);
                            return $course1[0]['title'] . ' ' . $result[0]['course_option_name_two'];
                        } elseif ($result[0]['universty_choice_three'] == $universityId) {
                            $course2 = $this->common_model->getCoursesById($result[0]['course_three']);
							$strm3 = $this->common_model->getStreamById($result[0]['course_option_name_three']);
                            return $course2[0]['title'] . ' ' . $result[0]['course_option_name_three'];
                        }
						elseif ($result[0]['universty_choice_fourth'] == $universityId) {
                            $course3 = $this->common_model->getCoursesById($result[0]['course_fourth']);
							$strm4 = $this->common_model->getStreamById($result[0]['course_option_name_fourth']);
                            return $course3[0]['title'] . ' ' . $result[0]['course_option_name_fourth'];
                        }
						elseif ($result[0]['universty_choice_fifth'] == $universityId) {
                            $course4 = $this->common_model->getCoursesById($result[0]['course_fifth']);
							$strm5 = $this->common_model->getStreamById($result[0]['course_option_name_fifth']);
                            return $course4[0]['title'] . ' ' . $result[0]['course_option_name_fifth'];
                        }
                    }
                } elseif ($result[0]['programme'] == 5 || $result[0]['programme'] == 6 || $result[0]['programme'] == 9) {

                    if ($result[0]['universty_choice'] == $universityId) {
                        $course = $this->common_model->getCoursesById($result[0]['course']);
                        return $course[0]['title'] . ' ' . $result[0]['course_option_name'];
                    } elseif ($result[0]['universty_choice_two'] == $universityId) {
                        $course1 = $this->common_model->getCoursesById($result[0]['course_two']);
                        return $course1[0]['title'] . ' ' . $result[0]['course_option_name_two'];
                    } elseif ($result[0]['universty_choice_three'] == $universityId) {
                        $course2 = $this->common_model->getCoursesById($result[0]['course_three']);
                        return $course2[0]['title'] . ' ' . $result[0]['course_option_name_three'];
                    }
					elseif ($result[0]['universty_choice_fourth'] == $universityId) {
                            $course3 = $this->common_model->getCoursesById($result[0]['course_fourth']);
                            return $course3[0]['title'] . ' ' . $result[0]['course_option_name_fourth'];
                        }
						elseif ($result[0]['universty_choice_fifth'] == $universityId) {
                            $course4 = $this->common_model->getCoursesById($result[0]['course_fifth']);
                            return $course4[0]['title'] . ' ' . $result[0]['course_option_name_fifth'];
                        }
                }
            } elseif ($result[0]['programme'] == 3 || $result[0]['programme'] == 4 || $result[0]['programme'] == 7 || $result[0]['programme'] == 8) {
                if ($result[0]['programme'] != 7) {
                    $course = $this->common_model->getProgrammeById($result[0]['programme']);
                    return $course[0]['name'] . ' (' . $result[0]['course_subject'] . ')';
                } else {
                    $course = $this->common_model->getProgrammeById($result[0]['programme']);
                    return $course[0]['name'];
                }
            }
        }
    }

    function updateProfilePassword($data) {
		//echo "<pre>";print_r($data);die;
        $this->db->where('id', $data['id']);
        $this->db->update('iccr_users', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function oldPasswordMatched($id, $pass) {
        $this->db->select('iccr_users.username,iccr_users.email_id');
        $this->db->from('iccr_users');
        $this->db->where(array('password' => $pass, 'id' => $id));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getHeadquarterInfo($uid) {
        $this->db->select('iccr_users.username,iccr_users.email_id,iccr_headquarters.*');
        $this->db->from('iccr_users');
        $this->db->join('iccr_headquarters', 'iccr_headquarters.uid = iccr_users.id');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function updateProfileHeadquarterName($data) {
        $this->db->where('id', $data['id']);
        $this->db->update('iccr_users', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateProfileHeadquarter($data) {
        $this->db->where('uid', $data['uid']);
        $this->db->update('iccr_headquarters', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateProfileRegion($data) {
        $this->db->where('id', $data['id']);
        $this->db->update('iccr_regions', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateProfileMission($data) {
        $this->db->where('id', $data['id']);
        $this->db->update('iccr_missions', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	
	function getAllCourseTypeSfs() {
        $this->db->select('*');
        $this->db->from('iccr_course_type');
		//$this->db->where_in('id', array('1'));
		$this->db->where_in('id', array('8','9','10','11','12','13','14','15','16','17','18','19','20'));
		//$this->db->where_in('id', array('2','3','4','5','6','7','8','9'));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
   function getAllCourseType() {
        $this->db->select('*');
        $this->db->from('iccr_course_type');
		//$this->db->where_in('id', array('1'));
		$this->db->where_in('id', array('10','11','12','13','14','15','16','17','18','19','20'));
		//$this->db->where_in('id', array('2','3','4','5','6','7','8','9'));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getAllCourseTypeAyush() {
        $this->db->select('*');
        $this->db->from('iccr_course_type');
		$this->db->where_in('id', array('1'));
		//$this->db->where_in('id', array('2','3','4','5','6','7','8','9','10'));
		//$this->db->where_in('id', array('2','3','4','5','6','7','8','9'));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getAllPhdCourseType($pid=null) {
		//echo $pid;die;
        $this->db->select('*');
        $this->db->from('iccr_course_type');
		
		if(!empty($pid) && ($pid == 1 || $pid == 2 || $pid == 8))
		{
			 $this->db->where('id', 1);
		}else
		{
			 $this->db->where_not_in('id', 1);
		}
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    /* Expenditure Report Start	 */

    function getStudentDayExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,sd_amount as amount');
        $this->db->from('iccr_exp_student_day');
        if ($fy != "") {
            $this->db->where('iccr_exp_student_day.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_student_day.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_student_day.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getEmergencyFundExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,ef_amount as amount');
        $this->db->from('iccr_exp_emergency_fund');
        if ($fy != "") {
            $this->db->where('iccr_exp_emergency_fund.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_emergency_fund.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_emergency_fund.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getSumptuaryExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,sump_amount as amount');
        $this->db->from('iccr_exp_sumptuary');
        if ($fy != "") {
            $this->db->where('iccr_exp_sumptuary.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_sumptuary.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_sumptuary.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getISAExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,isa_amount as amount');
        $this->db->from('iccr_exp_isa_meeting');
        if ($fy != "") {
            $this->db->where('iccr_exp_isa_meeting.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_isa_meeting.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_isa_meeting.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCampsExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,camps_amount as amount');
        $this->db->from('iccr_exp_camps');
        if ($fy != "") {
            $this->db->where('iccr_exp_camps.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_camps.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_camps.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOrientChargesExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,op_amount as amount');
        $this->db->from('iccr_exp_orientation_programme');
        if ($fy != "") {
            $this->db->where('iccr_exp_orientation_programme.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_orientation_programme.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_orientation_programme.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getHostelChargesExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,hos_amount as amount');
        $this->db->from('iccr_exp_hostel');
        if ($fy != "") {
            $this->db->where('iccr_exp_hostel.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_hostel.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_hostel.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getEnglishBridgeExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,ebc_amount as amount');
        $this->db->from('iccr_exp_english_bridge_course');
        if ($fy != "") {
            $this->db->where('iccr_exp_english_bridge_course.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_english_bridge_course.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_english_bridge_course.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getTFExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,tf_amount as amount');
        $this->db->from('iccr_exp_tution_fee');
        if ($fy != "") {
            $this->db->where('iccr_exp_tution_fee.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_tution_fee.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_tution_fee.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getTravelDetailsExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,travel_amount as amount');
        $this->db->from('iccr_exp_travel');
        if ($fy != "") {
            $this->db->where('iccr_exp_travel.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_travel.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_travel.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getThesisExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,tc_amount as amount');
        $this->db->from('iccr_exp_thesis_charges');
        if ($fy != "") {
            $this->db->where('iccr_exp_thesis_charges.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_thesis_charges.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_thesis_charges.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMedicalReimbrusmentExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,mr_amount as amount');
        $this->db->from('iccr_exp_medical_reimbursment');
        if ($fy != "") {
            $this->db->where('iccr_exp_medical_reimbursment.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_medical_reimbursment.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_medical_reimbursment.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getStudyTourExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,st_amount as amount');
        $this->db->from('iccr_exp_study_tour');
        if ($fy != "") {
            $this->db->where('iccr_exp_study_tour.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_study_tour.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_study_tour.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function gethraExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,hra_amount as amount');
        $this->db->from('iccr_exp_hra');
        if ($fy != "") {
            $this->db->where('iccr_exp_hra.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_hra.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_hra.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getStipendExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,amount');
        $this->db->from('iccr_exp_stipend');
        if ($fy != "") {
            $this->db->where('iccr_exp_stipend.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_stipend.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_stipend.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAdvStipendExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,adv_stipend_amount as amount');
        $this->db->from('iccr_exp_advance_stipend');
        if ($fy != "") {
            $this->db->where('iccr_exp_advance_stipend.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_advance_stipend.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_advance_stipend.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getACAExpenditure($fy, $schem, $region, $quarter, $month) {
        $this->db->select('fy,scheme,regionId,aca_amount as amount');
        $this->db->from('iccr_exp_aca');
        if ($fy != "") {
            $this->db->where('iccr_exp_aca.fy', $fy);
        }
        if ($schem != "" && $schem != "all" && $schem > 0) {
            $this->db->where('iccr_exp_aca.scheme', $schem);
        }
        if ($region != "" && $region != "all" && $region > 0) {
            $this->db->where('iccr_exp_aca.regionId', $region);
        }
        if ($quarter != "" && $quarter != "all" && $quarter > 0) {
            if ($quarter == 1) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('4', '5', '6'));
            }
            if ($quarter == 2) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('7', '8', '9'));
            }
            if ($quarter == 3) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('10', '11', '12'));
            }
            if ($quarter == 4) {
                $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))', array('1', '2', '3'));
            }
        }
        if ($month != "" && $month != "all" && $month > 0) {
            $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=', $month);
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    /* Expenditure Report End	 */

     function getConfirmationofFourthOptionByHqrs($missionId = null) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.university_is_accept,iccr_status_mapping.regional_university,iccr_status_mapping.scholarship_id,iccr_university_response_by_hqrs.regional_university,iccr_university_response_by_hqrs.region_one_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 10));
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->where(array('iccr_student_details.apply_course_type =' => 10));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

	function getConfirmationofFourthOptionByHqrsOld($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.university_is_accept,iccr_status_mapping.regional_university,iccr_status_mapping.scholarship_id,iccr_university_response_by_hqrs.regional_university,iccr_university_response_by_hqrs.region_one_doc');
        $this->db->from('iccr_status_mapping');

        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 10));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function getAllExpenditureAppId() {
        
    }

    function getDivisionById($id) {
        $this->db->select('iccr_divisions.name,iccr_divisions.scheme_ids');
        $this->db->from('iccr_divisions');
        $this->db->where(array('iccr_divisions.id' => $id));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            show_error('Message', 500);
        }
        return $this->db->get()->result_array();
    }

    function getCourseDurationFromAcademicDetails($appid) {
        $this->db->select('iccr_academic_details.*');
        $this->db->from('iccr_academic_details');
        $this->db->where(array('iccr_academic_details.application_id' => $appid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    /* Reports Section */

    private function _get_datatables_query($schemeid,$vars = null) {
		//echo "<pre>";print_r($vars);die;
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.programme,iccr_university_response.confirmed_course,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.gender,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_university_response.regional_university,iccr_university_response.region_one_status,iccr_university_response.confirmed_to_mission,iccr_status_mapping.scholarship_id,iccr_student_details.created as cu_created,iccr_student_other_details.created');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >='=> 10));
		$this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeid);
		$this->db->group_by('iccr_status_mapping.application_no');
		$this->db->order_by('iccr_student_details.created', 'DESC');
		
        //add custom filter here

        if ($this->input->post('Country')) {
            $this->db->where('iccr_student_application_details.country', $this->input->post('Country'));
        }
		 if ($this->input->post('Application')) {
            $this->db->like('iccr_status_mapping.application_no', $this->input->post('Application'));
        }
		if (!empty($vars['country'])) {
            $this->db->where('iccr_student_application_details.country', $vars['country']);
        }
        if ($this->input->post('ApplicantName')) {
            $this->db->like('iccr_student_application_details.fullname', $this->input->post('ApplicantName'));
        }
        if ($this->input->post('Gender')) {
            $this->db->like('iccr_student_application_details.gender', $this->input->post('Gender'));
        }
		if (!empty($vars['gender'])) {
            $this->db->like('iccr_student_application_details.gender', $vars['gender']);
        }
        if ($this->input->post('Mail')) {
            $this->db->like('iccr_student_application_details.email', $this->input->post('Mail'));
        }
        if ($this->input->post('Programme')) {
            $this->db->where('iccr_student_application_details.programme', $this->input->post('Programme'));
        }
		if (!empty($vars['programmes'])){
            $this->db->where('iccr_student_application_details.programme', $vars['programmes']);
        }
        if ($this->input->post('Counrse')) {
            $this->db->where('iccr_university_response.course', $this->input->post('Counrse'));
        }
		if($this->input->post('ExpenditureFilter') != "" && $this->input->post('ExpenditureFilter') > 1)
		{
			//$sql .= " join iccr_student_expenditure ex on ex.application_id = map.application_no ";
			$this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_status_mapping.application_no');
		}

		if (!empty($vars['courses'])) {
            $this->db->where('iccr_university_response.course', $vars['courses']);
        }
        if ($this->input->post('Scheme')) {
            $this->db->where('iccr_status_mapping.scholarship_id', $this->input->post('Scheme'));
        }
		if (!empty($vars['schemes'])) {
            $this->db->where('iccr_status_mapping.scholarship_id', $vars['schemes']);
        }
        if ($this->input->post('Region')) {
			$this->db->where('iccr_university_response.region_one_status', $this->input->post('Region'));
            //$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
        if ($this->input->post('Universtiy')) {
			$this->db->where('iccr_university_response.regional_university', $this->input->post('Universtiy'));
			//$this->db->where('iccr_university_response.regional_university', $this->input->post('Universtiy'));
        }
		if (!empty($vars['university'])) {
			$this->db->where('iccr_university_response.regional_university', $this->input->post('Universtiy'));
			//$this->db->where('iccr_university_response.regional_university', $this->input->post('Universtiy'));
        }
		if(!empty($vars['region'])){
			$this->db->where('iccr_university_response.region_one_status', $vars['region']);
            //$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
		if($this->input->post('MinDate') != "" && $this->input->post('MaxDate') != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($this->input->post('MinDate')));
            $this->db->where('iccr_student_other_details.created <=', strtotime($this->input->post('MaxDate')));
		}
		if(!empty($vars['min-date']) && !empty($vars['max-date']))
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['min-date']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['max-date']));
		}
		if ($this->input->post('Confirmed') == 1) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 1);
			$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');
			}
		if (!empty($vars['confirmed']) && $vars['confirmed'] == 1) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 1);
			$this->db->group_by('iccr_status_mapping.application_no');
			$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');
			}
		if ($this->input->post('Confirmed') == 2) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 2);
			$this->db->group_by('iccr_status_mapping.application_no');
			$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');
			}
		if (!empty($vars['confirmed']) && $vars['confirmed'] == 2) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 2);

			$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');
			}
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
       //echo $this->db->_compile_select();
        
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
    }

	public function getAllAdmittStudents($schemeids,$vars) {

       /*  $sql = "SELECT iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_status_mapping.scholarship_id,iccr_countries.country_name,iccr_university_response.application_id
		FROM iccr_university_response 
		JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id
		JOIN iccr_student_application_details ON iccr_student_application_details.application_no = iccr_university_response.application_id
		join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
		JOIN iccr_travelplan ON iccr_travelplan.application_id =  iccr_university_response.application_id Where iccr_status_mapping.scholarship_id IN(".$schemeids.") AND iccr_travelplan.status=14 AND iccr_university_response.university_is_accept =1"; */
		//echo $sql;die;
        //add custom filter here
		
		 $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_status_mapping.scholarship_id,iccr_countries.country_name,iccr_university_response.application_id,iccr_university_response.university_is_accept,iccr_student_details.created');
        $this->db->from('iccr_university_response');
		$this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_university_response.application_id');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
		$this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_university_response.application_id');
        $this->db->where(array('iccr_status_mapping.status'  => 14));
		$this->db->where(array('iccr_university_response.university_is_accept'  => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		

        if ($this->input->post('Country')) {
            $this->db->where('iccr_student_application_details.country', $this->input->post('Country'));
        }
        if ($this->input->post('ApplicantName')) {
            $this->db->like('iccr_student_application_details.fullname', $this->input->post('ApplicantName'));
        }
        if ($this->input->post('Gender')) {
            $this->db->like('iccr_student_application_details.gender', $this->input->post('Gender'));
        }
        if ($this->input->post('Mail')) {
            $this->db->like('iccr_student_application_details.email', $this->input->post('Mail'));
        }
        if ($this->input->post('Programme')) {
            $this->db->where('iccr_student_application_details.programme', $this->input->post('Programme'));
        }
        if ($this->input->post('Counrse')) {
            $this->db->where('iccr_student_application_details.course', $this->input->post('Counrse'));
        }
        if ($this->input->post('Scheme')) {
            $this->db->where('iccr_status_mapping.scholarship_id', $this->input->post('Scheme'));
        }
        if ($this->input->post('Region')) {
            $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
        if ($this->input->post('Universtiy')) {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_two=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_three=' . $this->input->post('Universtiy') . ')');
        }
        $this->db->limit($vars['length'],$vars['start']);
        //echo $this->db->_compile_select();die;
        
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		return $this->db->get()->result_array();
    }
	
	
	public function getAllAdmittedStudents($schemeids) {

       /*  $sql = "SELECT iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_status_mapping.scholarship_id,iccr_countries.country_name,iccr_university_response.application_id
		FROM iccr_university_response 
		JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id
		JOIN iccr_student_application_details ON iccr_student_application_details.application_no = iccr_university_response.application_id
		join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
		JOIN iccr_travelplan ON iccr_travelplan.application_id =  iccr_university_response.application_id Where iccr_status_mapping.scholarship_id IN(".$schemeids.") AND iccr_travelplan.status=14 AND iccr_university_response.university_is_accept =1"; */
		//echo $sql;die;
        //add custom filter here
		
		 $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_status_mapping.scholarship_id,iccr_countries.country_name,iccr_university_response.application_id,iccr_university_response.university_is_accept,iccr_student_details.created');
        $this->db->from('iccr_university_response');
		$this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_university_response.application_id');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
		$this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_university_response.application_id');
        $this->db->where(array('iccr_status_mapping.status'  => 14));
		$this->db->where(array('iccr_university_response.university_is_accept'  => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		

        if ($this->input->post('Country')) {
            $this->db->where('iccr_student_application_details.country', $this->input->post('Country'));
        }
        if ($this->input->post('ApplicantName')) {
            $this->db->like('iccr_student_application_details.fullname', $this->input->post('ApplicantName'));
        }
        if ($this->input->post('Gender')) {
            $this->db->like('iccr_student_application_details.gender', $this->input->post('Gender'));
        }
        if ($this->input->post('Mail')) {
            $this->db->like('iccr_student_application_details.email', $this->input->post('Mail'));
        }
        if ($this->input->post('Programme')) {
            $this->db->where('iccr_student_application_details.programme', $this->input->post('Programme'));
        }
        if ($this->input->post('Counrse')) {
            $this->db->where('iccr_student_application_details.course', $this->input->post('Counrse'));
        }
        if ($this->input->post('Scheme')) {
            $this->db->where('iccr_status_mapping.scholarship_id', $this->input->post('Scheme'));
        }
        if ($this->input->post('Region')) {
            $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
        if ($this->input->post('Universtiy')) {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_two=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_three=' . $this->input->post('Universtiy') . ')');
        }
        
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		return $this->db->get()->result_array();
    }
	
	
	
		public function getAllROAdmittedStudents($region) {

		
		 $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_status_mapping.scholarship_id,iccr_countries.country_name,iccr_university_response.application_id,iccr_university_response.university_is_accept,iccr_student_details.created');
        $this->db->from('iccr_university_response');
		$this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_university_response.application_id');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
		$this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_university_response.application_id');
        $this->db->where(array('iccr_status_mapping.status'  => 14));
		$this->db->where(array('iccr_university_response.university_is_accept'  => 1));
        $this->db->where('iccr_university_response.region_one_status', $region);
		

        if ($this->input->post('Country')) {
            $this->db->where('iccr_student_application_details.country', $this->input->post('Country'));
        }
        if ($this->input->post('ApplicantName')) {
            $this->db->like('iccr_student_application_details.fullname', $this->input->post('ApplicantName'));
        }
        if ($this->input->post('Gender')) {
            $this->db->like('iccr_student_application_details.gender', $this->input->post('Gender'));
        }
        if ($this->input->post('Mail')) {
            $this->db->like('iccr_student_application_details.email', $this->input->post('Mail'));
        }
        if ($this->input->post('Programme')) {
            $this->db->where('iccr_student_application_details.programme', $this->input->post('Programme'));
        }
        if ($this->input->post('Counrse')) {
            $this->db->where('iccr_student_application_details.course', $this->input->post('Counrse'));
        }
        if ($this->input->post('Scheme')) {
            $this->db->where('iccr_status_mapping.scholarship_id', $this->input->post('Scheme'));
        }
        if ($this->input->post('Region')) {
            $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
        if ($this->input->post('Universtiy')) {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_two=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_three=' . $this->input->post('Universtiy') . ')');
        }
        
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		return $this->db->get()->result_array();
    }
	
	
	function getTotalAllAdmittStudents($schemeids,$vars = null)
    {
		$this->db->select('count(iccr_university_response.application_id) as total' ,'iccr_status_mapping'.'application_no');
        $this->db->from('iccr_university_response');
		$this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_university_response.application_id');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
		}
         if ($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
        }       
        if ($vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if ($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
        if ($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
       
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
        $this->db->where(array('iccr_status_mapping.status'  => 14));
		$this->db->where(array('iccr_university_response.university_is_accept'  => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
	}
	
	
    public function get_datatables($schemss,$vars = null) {
        $this->_get_datatables_query($schemss,$vars);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $query->result();
    }

    public function count_filtered($schemss) {
        $this->_get_datatables_query($schemss, null);
        $query = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $query->num_rows();
    }

    public function count_all($schemss = null) {
		$this->_get_datatables_query($schemss);
        //$this->db->from("iccr_status_mapping");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->count_all_results();
    }

	 public function count_total_joined_all($schemss,$vars = null) {
        $this->getAllAdmittStudents($schemss,$vars = null);
        $query = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        //return $query->num_rows();
    }

    public function count_total_filter_all($schemss,$vars = null) {
        $this->getAllAdmittStudents($schemss,$vars = null);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->count_all_results();
    }
	
	
    public function get_list_countries() {
        $this->db->select('*');
        $this->db->from("iccr_countries");
        $this->db->order_by('name', 'asc');
        $query = $this->db->get();
        $result = $query->result();

        $countries = array();
        foreach ($result as $row) {
            $countries[] = $row->name;
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $countries;
    }

    /* Report Section */

    function isStatusExists($data, $type, $status) {
        $this->db->select('status,scholarship_status,attendance_percentage,promoted_percentage,detained_reason,backlog_no');
        $this->db->from('iccr_academic_staus');
        $this->db->where(array('aca_year' => $data['aca_year'], 'is_sem' => $data['is_sem']));
        if ($data['is_sem'] == 1) {
            $this->db->where(array('sem_no' => $data['sem_no']));
        } elseif ($data['is_sem'] == 2) {
            $this->db->where(array('annual_no' => $data['annual_no']));
        }
        switch ($type) {
            case "1":
                $this->db->where(array('status' => $data['status']));
                switch ($status) {
                    case "1":
                        $this->db->where(array('promoted_percentage !=' => ""));
                        break;
                    case "2":
                        $this->db->where(array('detained_reason !=' => -1));
                        break;
                    case "3":
                        $this->db->where(array('backlog_no !=' => -1));
                        break;
                    case "4":
                        $this->db->where(array('finally_passed_percent !=' => ""));
                        break;
                }
                break;
            case "2":
                $this->db->where(array('attendance_percentage !=' => -1));
                break;
            case "3":
                $this->db->where(array('scholarship_status !=' => -1));
                break;
        }
        $this->db->where(array('application_id' => $data['application_id']));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function isRecordExists($data, $type, $status) {
        $this->db->select('status,scholarship_status,attendance_percentage,promoted_percentage,detained_reason,backlog_no');
        $this->db->from('iccr_academic_staus');
        $this->db->where(array('aca_year' => $data['aca_year'], 'is_sem' => $data['is_sem']));
        if ($data['is_sem'] == 1) {
            $this->db->where(array('sem_no' => $data['sem_no']));
        } elseif ($data['is_sem'] == 2) {
            $this->db->where(array('annual_no' => $data['annual_no']));
        }
        $this->db->where(array('application_id' => $data['application_id']));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    /* Expenditure Selection Tables Start */

    function isAlreadyUpdatedbalance($fy, $regionId) {
        $this->db->select('iccr_opening_balance.*');
        $this->db->from('iccr_opening_balance');
        $this->db->where(array('iccr_opening_balance.regional_office' => $regionId, 'iccr_opening_balance.financial_year' => $fy));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOpeningBalance($regionId) {
        $this->db->select('iccr_opening_balance.*');
        $this->db->from('iccr_opening_balance');
        $this->db->where(array('iccr_opening_balance.regional_office' => $regionId));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getRegionalComplaints($rid) {
        $this->db->select('iccr_complaints.*');
        $this->db->from('iccr_complaints');
        $this->db->where_in('rid', $rid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getBankingDetails($appno, $type) {
        $this->db->select('iccr_exp_bank_details.*');
        $this->db->from('iccr_exp_bank_details');
        $this->db->where(array('iccr_exp_bank_details.application_id' => $appno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getPermitDetails($appno, $type) {
        $this->db->select('iccr_exp_residential_permit.*');
        $this->db->from('iccr_exp_residential_permit');
        $this->db->where('iccr_exp_residential_permit.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getExpenditureDetails($appno) {
        $this->db->select('*');
        $this->db->from('iccr_student_expenditure');
        $this->db->where('iccr_student_expenditure.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getStipendDetails($appno, $type) {
        $this->db->select('iccr_exp_stipend.*');
        $this->db->from('iccr_exp_stipend');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_stipend.application_id');
        $this->db->where('iccr_exp_stipend.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAdvanceStipendDetails($appno, $type) {
        $this->db->select('iccr_exp_advance_stipend.*');
        $this->db->from('iccr_exp_advance_stipend');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_advance_stipend.application_id');
        $this->db->where('iccr_exp_advance_stipend.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getHRADetails($appno, $type) {
        $this->db->select('iccr_exp_hra.*');
        $this->db->from('iccr_exp_hra');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_hra.application_id');
        $this->db->where('iccr_exp_hra.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getACADetails($appno, $type) {
        $this->db->select('iccr_exp_aca.*');
        $this->db->from('iccr_exp_aca');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_aca.application_id');
        $this->db->where('iccr_exp_aca.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getStudyTourDetails($appno, $type) {
        $this->db->select('iccr_exp_study_tour.*');
        $this->db->from('iccr_exp_study_tour');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_study_tour.application_id');
        $this->db->where('iccr_exp_study_tour.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMedicalReimbursDetails($appno, $type) {
        $this->db->select('iccr_exp_medical_reimbursment.*');
        $this->db->from('iccr_exp_medical_reimbursment');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_medical_reimbursment.application_id');
        $this->db->where('iccr_exp_medical_reimbursment.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getThesisChargesDetails($appno, $type) {
        $this->db->select('iccr_exp_thesis_charges.*');
        $this->db->from('iccr_exp_thesis_charges');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_thesis_charges.application_id');
        $this->db->where('iccr_exp_thesis_charges.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMiscDetails($appno, $type) {
        $this->db->select('iccr_exp_miscellaneous.*');
        $this->db->from('iccr_exp_miscellaneous');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_miscellaneous.application_id');
        $this->db->where('iccr_exp_miscellaneous.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getHostelDetails($appno, $type) {
        $this->db->select('iccr_exp_hostel.*');
        $this->db->from('iccr_exp_hostel');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_hostel.application_id');
        $this->db->where('iccr_exp_hostel.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getTutionFeeDetails($appno, $type) {
        $this->db->select('iccr_exp_tution_fee.*');
        $this->db->from('iccr_exp_tution_fee');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_tution_fee.application_id');
        $this->db->where('iccr_exp_tution_fee.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOCFDetails($appno, $type) {
        $this->db->select('iccr_exp_other_fee.*');
        $this->db->from('iccr_exp_other_fee');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_other_fee.application_id');
        $this->db->where('iccr_exp_other_fee.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMiscellaneousUniversityDetails($appno, $type) {
        $this->db->select('iccr_exp_miscellaneous_university.*');
        $this->db->from('iccr_exp_miscellaneous_university');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_miscellaneous_university.application_id');
        $this->db->where('iccr_exp_miscellaneous_university.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getTravalDetails($appno, $type) {
        $this->db->select('iccr_exp_travel.*');
        $this->db->from('iccr_exp_travel');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_travel.application_id');
        $this->db->where('iccr_exp_travel.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOrientationDetails($appno, $type) {
        $this->db->select('iccr_exp_orientation_programme.*');
        $this->db->from('iccr_exp_orientation_programme');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_orientation_programme.application_id');
        $this->db->where('iccr_exp_orientation_programme.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCampsDetails($appno, $type) {
        $this->db->select('iccr_exp_camps.*');
        $this->db->from('iccr_exp_camps');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_camps.application_id');
        $this->db->where('iccr_exp_camps.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getISADetails($appno, $type) {
        $this->db->select('iccr_exp_isa_meeting.*');
        $this->db->from('iccr_exp_isa_meeting');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_isa_meeting.application_id');
        $this->db->where('iccr_exp_isa_meeting.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getSumptuaryDetails($appno, $type) {
        $this->db->select('iccr_exp_sumptuary.*');
        $this->db->from('iccr_exp_sumptuary');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_sumptuary.application_id');
        $this->db->where('iccr_exp_sumptuary.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getEmergencyFundDetails($appno, $type) {
        $this->db->select('iccr_exp_emergency_fund.*');
        $this->db->from('iccr_exp_emergency_fund');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_emergency_fund.application_id');
        $this->db->where('iccr_exp_emergency_fund.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getStudentDayDetails($appno, $type) {
        $this->db->select('iccr_exp_student_day.*');
        $this->db->from('iccr_exp_student_day');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_student_day.application_id');
        $this->db->where('iccr_exp_student_day.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getNationalDayDetails($appno, $type) {
        $this->db->select('iccr_exp_national_day.*');
        $this->db->from('iccr_exp_national_day');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_national_day.application_id');
        $this->db->where('iccr_exp_national_day.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getEnglishBridgeCourseDetails($appno, $type) {
        $this->db->select('iccr_exp_english_bridge_course.*');
        $this->db->from('iccr_exp_english_bridge_course');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_english_bridge_course.application_id');
        $this->db->where('iccr_exp_english_bridge_course.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getDeductionDetails($appno, $type) {
        $this->db->select('iccr_exp_deductions.*');
        $this->db->from('iccr_exp_deductions');
        $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_deductions.application_id');
        $this->db->where('iccr_exp_deductions.application_id', $appno);
        if ($type == "old") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        } elseif ($type == "New") {
            $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
        }
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
 function getAdvanceStipendDetailsWithoutType($appno) {
        $this->db->select('iccr_exp_advance_stipend.*');
        $this->db->from('iccr_exp_advance_stipend');
        
        $this->db->where('iccr_exp_advance_stipend.application_id', $appno);
       
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getHRADetailsWithoutType($appno) {
        $this->db->select('iccr_exp_hra.*');
        $this->db->from('iccr_exp_hra');
        $this->db->where('iccr_exp_hra.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 function getTutionFeeDetailsWithOutType($appno) {
        $this->db->select('iccr_exp_tution_fee.*');
        $this->db->from('iccr_exp_tution_fee');
        
        $this->db->where('iccr_exp_tution_fee.application_id', $appno);
        
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getMiscDetailsWithOutType($appno) {
        $this->db->select('iccr_exp_miscellaneous.*');
        $this->db->from('iccr_exp_miscellaneous');
        $this->db->where('iccr_exp_miscellaneous.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 function getMedicalReimbursDetailsWithOutType($appno) {
        $this->db->select('iccr_exp_medical_reimbursment.*');
        $this->db->from('iccr_exp_medical_reimbursment');
        $this->db->where('iccr_exp_medical_reimbursment.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getStudyTourDetailsWithOutType($appno) {
        $this->db->select('iccr_exp_study_tour.*');
        $this->db->from('iccr_exp_study_tour');
        $this->db->where('iccr_exp_study_tour.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getACADetailsWithOutType($appno) {
        $this->db->select('iccr_exp_aca.*');
        $this->db->from('iccr_exp_aca');
        $this->db->where('iccr_exp_aca.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	  function getHostelDetailsWithoutType($appno) {
        $this->db->select('iccr_exp_hostel.*');
        $this->db->from('iccr_exp_hostel');
        $this->db->where('iccr_exp_hostel.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 function getStipendDetailsWithOutType($appno) {
        $this->db->select('*');
        $this->db->from('iccr_exp_stipend');
        
        $this->db->where('iccr_exp_stipend.application_id', $appno);
        
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    /* Expenditure Selection Tables  End */

    function getRegionById($regionid) {
        $this->db->select('iccr_regions.*');
        $this->db->from('iccr_regions');


        $this->db->where('id', $regionid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        //echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	 function getAllAlumaniApplicationsDetails() {
        $this->db->select('count(iccr_alumni_data.id) as total,count(iccr_countries.id) as countryTotal,iccr_countries.country_name');
        $this->db->from('iccr_alumni_data');
        $this->db->join('iccr_countries', 'iccr_countries.id = iccr_alumni_data.nationality');
		$this->db->group_by('iccr_countries.country_name');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    //vipin demo


    function getRegionById1($regionid) {
        $this->db->select('iccr_regions.*');
        $this->db->from('iccr_regions');


        $this->db->where('id', $regionid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function deleteMission($id) {
        $this->db->where('id', $id);
        $this->db->delete('iccr_missions');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->affected_rows();
    }

    function deleteScheme($id) {
        $this->db->where('id', $id);
        $this->db->delete('iccr_scheme');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->affected_rows();
    }

    function deleteRgion($id) {
        $this->db->Where('id', $id);
        $this->db->delete('iccr_regions');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->affected_rows();
    }

    function getStateById($regionid) {
        $this->db->select('iccr_states.name,iccr_states.id');
        $this->db->from('iccr_states');
        $this->db->where('id', $regionid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	


    function insertOpeningBalance($data) {
        $q = $this->db->insert_string('iccr_opening_balance', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertAlumniData($data) {
        $q = $this->db->insert_string('iccr_alumni_data', $data);
		//echo $q;die;
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertAdvanceStipend($data) {
        $q = $this->db->insert_string('iccr_exp_advance_stipend', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertStipend($data) {
        $q = $this->db->insert_string('iccr_exp_stipend', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertHRA($data) {
        $q = $this->db->insert_string('iccr_exp_hra', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertACA($data) {
        $q = $this->db->insert_string('iccr_exp_aca', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertStudyTour($data) {
        $q = $this->db->insert_string('iccr_exp_study_tour', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertMedicalReimbursment($data) {
        $q = $this->db->insert_string('iccr_exp_medical_reimbursment', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertThesisCharges($data) {
        $q = $this->db->insert_string('iccr_exp_thesis_charges', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertMiscellaneous($data) {
        $q = $this->db->insert_string('iccr_exp_miscellaneous', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertHostelCharges($data) {
        $q = $this->db->insert_string('iccr_exp_hostel', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertSumptuary($data) {
        $q = $this->db->insert_string('iccr_exp_sumptuary', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertStudentDay($data) {
        $q = $this->db->insert_string('iccr_exp_student_day', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertNationalDay($data) {
        $q = $this->db->insert_string('iccr_exp_national_day', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertEmergancyFund($data) {
        $q = $this->db->insert_string('iccr_exp_emergency_fund', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertISAMeeting($data) {
        $q = $this->db->insert_string('iccr_exp_isa_meeting', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertCamps($data) {
        $q = $this->db->insert_string('iccr_exp_camps', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertOrientationProgramme($data) {
        $q = $this->db->insert_string('iccr_exp_orientation_programme', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertEnglishBridgeCourse($data) {
        $q = $this->db->insert_string('iccr_exp_english_bridge_course', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertTutionFee($data) {
        $q = $this->db->insert_string('iccr_exp_tution_fee', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertOCFee($data) {
        $q = $this->db->insert_string('iccr_exp_other_fee', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertUniversityMiscellaneous($data) {
        $q = $this->db->insert_string('iccr_exp_miscellaneous_university', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function isNotAcceptedByAllUniversities($appid) {
        $sql = "select Count(CASE WHEN  university_is_accept=2 or university_is_accept=1 THEN university_is_accept END) as count,
sum(CASE WHEN  university_is_accept=2 or university_is_accept=1 THEN university_is_accept END) as total from iccr_university_response  where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getTotalFundtoAllRegion() {
        $sql = "Select financial_year as FY, regional_office as RO,
SUM(CASE WHEN quarter=1 THEN amount_released END) First_Quarter,
SUM(CASE WHEN quarter=2 THEN amount_released END) Second_Quareter,
SUM(CASE WHEN quarter=3 THEN amount_released END) Third_Quareter,
SUM(CASE WHEN quarter=4 THEN amount_released END) Fourth_Quareter 
FROM iccr_hqrs_fund_monitoring Group BY regional_office,financial_year order by financial_year asc";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getTotalFundtoRegionbyFY($regionId, $Fy) {

        $sql = "Select financial_year as FY, regional_office as RO,SUM(CASE WHEN quarter=1 THEN amount_released ELSE 0 END) First_Quarter,SUM(CASE WHEN quarter=2 THEN amount_released ELSE 0 END) Second_Quareter,SUM(CASE WHEN quarter=3 THEN amount_released ELSE 0 END) Third_Quareter,SUM(CASE WHEN quarter=4 THEN amount_released ELSE 0 END) Fourth_Quareter FROM iccr_hqrs_fund_monitoring where regional_office=" . $regionId . " and financial_year='" . $Fy . "' Group BY regional_office";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getCurrentQuarterFundDetails($regionId, $fy, $quarter) {
        $sql = "Select amount_released FROM iccr_hqrs_fund_monitoring where regional_office=" . $regionId . " and quarter=" . $quarter . " and financial_year='" . $fy . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getTotalFundtoRegion($regionId) {
        $sql = "Select created,financial_year as FY, regional_office as RO,SUM(CASE WHEN quarter=1 THEN amount_released END) First_Quarter,SUM(CASE WHEN quarter=2 THEN amount_released END) Second_Quareter,SUM(CASE WHEN quarter=3 THEN amount_released END) Third_Quareter,SUM(CASE WHEN quarter=4 THEN amount_released END) Fourth_Quareter FROM iccr_hqrs_fund_monitoring where regional_office=" . $regionId . " group by financial_year";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getAdvStipendByFY($fromyear, $toyear, $regionId) {
        $sql = "Select doc, 'Stipend' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN adv_stipend_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN adv_stipend_amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN adv_stipend_amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=" . $toyear . " THEN adv_stipend_amount END) Fourth_Quarter FROM iccr_exp_advance_stipend where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getAdvStipendByFYofAppid($fromyear, $toyear, $appid) {
		//echo $fromyear; 
		//echo $toyear;
		//echo $appid;die;
        $sql = "Select doc, 'Stipend' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN adv_stipend_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN adv_stipend_amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN adv_stipend_amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=" . $toyear . " THEN adv_stipend_amount END) Fourth_Quarter  FROM iccr_exp_advance_stipend where application_id='" . $appid . "'";
//echo $sql;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getStipendByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Stipend' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=" . $toyear . " THEN amount END) Fourth_Quarter FROM iccr_exp_stipend where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getStipendByFYByAppno($fromyear, $toyear, $appid) {
        $sql = "Select doc, 'Stipend' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=" . $fromyear . " THEN amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=" . $toyear . " THEN amount END) Fourth_Quarter FROM iccr_exp_stipend where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getMedicalReimbrusmentbyFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Medical Reimbursment' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN mr_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN mr_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN mr_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=" . $toyear . " THEN mr_amount END) Fourth_Quarter FROM iccr_exp_medical_reimbursment where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getMedicalReimbrusmentbyFYByAppId($fromyear, $toyear, $appid) {
        $sql = "Select 'Medical Reimbursment' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN mr_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN mr_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN mr_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=" . $toyear . " THEN mr_amount END) Fourth_Quarter FROM iccr_exp_medical_reimbursment where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getThesisbyFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Thesis Charges' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=" . $toyear . " THEN tc_amount END) Fourth_Quarter FROM iccr_exp_thesis_charges where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getThesisbyFYByAppId($fromyear, $toyear, $appid) {
        $sql = "Select 'Thesis Charges' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=" . $toyear . " THEN tc_amount END) Fourth_Quarter FROM iccr_exp_thesis_charges where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getMiscbyFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Misc Charges' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(msc_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(msc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN msc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(msc_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(msc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN msc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(msc_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(msc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN msc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(msc_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(msc_release_date, '%d/%m/%Y'))=" . $toyear . " THEN msc_amount END) Fourth_Quarter FROM iccr_exp_miscellaneous where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function gethraByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'HRA' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN hra_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN hra_amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN hra_amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=" . $toyear . " THEN hra_amount END) Fourth_Quarter FROM iccr_exp_hra where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function gethraByFYByAppno($fromyear, $toyear, $appid) {
        $sql = "Select doc, 'HRA' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN hra_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN hra_amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN hra_amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=" . $toyear . " THEN hra_amount END) Fourth_Quarter FROM iccr_exp_hra where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getStudyTourbyFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Study Tour' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN st_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN st_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN st_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=" . $toyear . " THEN st_amount END) Fourth_Quarter FROM iccr_exp_study_tour where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getStudyTourbyFYByAppId($fromyear, $toyear, $appid) {
        $sql = "Select 'Study Tour' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN st_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN st_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN st_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=" . $toyear . " THEN st_amount END) Fourth_Quarter 
FROM iccr_exp_study_tour where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getTravelDetailsbyFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Trvel' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN travel_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN travel_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN travel_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=" . $toyear . " THEN travel_amount END) Fourth_Quarter FROM iccr_exp_travel where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getTravelDetailsbyFYByAppId($fromyear, $toyear, $appid) {
        $sql = "Select 'Trvel' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN travel_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN travel_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN travel_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=" . $toyear . " THEN travel_amount END) Fourth_Quarter FROM iccr_exp_travel where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getHostelChargesByAppid($fromyear, $toyear, $appid) {
        $sql = "Select 'Hostel' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=" . $fromyear . " THEN hos_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=" . $fromyear . " THEN hos_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=" . $fromyear . " THEN hos_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=" . $toyear . " THEN hos_amount END) Fourth_Quarter FROM iccr_exp_hostel where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getHostelChargesByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Hostel' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=" . $fromyear . " THEN hos_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=" . $fromyear . " THEN hos_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=" . $fromyear . " THEN hos_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=" . $toyear . " THEN hos_amount END) Fourth_Quarter FROM iccr_exp_hostel where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getACAbyFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'ACA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN aca_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN aca_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN aca_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=" . $toyear . " THEN aca_amount END) Fourth_Quarter FROM iccr_exp_aca where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getACAbyFYByAppid($fromyear, $toyear, $appid) {
        $sql = "Select doc, 'ACA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN aca_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN aca_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN aca_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=" . $toyear . " THEN aca_amount END) Fourth_Quarter FROM iccr_exp_aca where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getOCFByAppid($fromyear, $toyear, $appid) {
        $sql = "Select 'OCF' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN ocf_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN ocf_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN ocf_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=" . $toyear . " THEN ocf_amount END) Fourth_Quarter FROM iccr_exp_other_fee where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getOCFByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'OCF' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN ocf_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN ocf_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN ocf_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=" . $toyear . " THEN ocf_amount END) Fourth_Quarter FROM iccr_exp_other_fee where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getTFByByAppid($fromyear, $toyear, $appid) {
        $sql = "Select doc, 'TF' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tf_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tf_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tf_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=" . $toyear . " THEN tf_amount END) Fourth_Quarter FROM iccr_exp_tution_fee  where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getTFByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'TF' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tf_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tf_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN tf_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=" . $toyear . " THEN tf_amount END) Fourth_Quarter FROM iccr_exp_tution_fee where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getMiscUniByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Misc' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN uni_msc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN uni_msc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y'))=" . $fromyear . " THEN uni_msc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y'))=" . $toyear . " THEN uni_msc_amount END) Fourth_Quarter FROM iccr_exp_miscellaneous_university where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getEnglishBridgeByappid($fromyear, $toyear, $appid) {
        $sql = "Select 'EBC' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ebc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ebc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ebc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=" . $toyear . " THEN ebc_amount END) Fourth_Quarter FROM iccr_exp_english_bridge_course where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getEnglishBridgeByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'EBC' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ebc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ebc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ebc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=" . $toyear . " THEN ebc_amount END) Fourth_Quarter FROM iccr_exp_english_bridge_course where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getOrientChargesByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'OP' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN op_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN op_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN op_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=" . $toyear . " THEN op_amount END) Fourth_Quarter FROM iccr_exp_orientation_programme where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getOrientChargesByAppid($fromyear, $toyear, $appid) {
        $sql = "Select 'OP' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN op_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN op_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN op_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=" . $toyear . " THEN op_amount END) Fourth_Quarter FROM iccr_exp_orientation_programme where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getCampsByAppid($fromyear, $toyear, $appid) {
        $sql = "Select 'Camps' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN camps_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN camps_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN camps_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=" . $toyear . " THEN camps_amount END) Fourth_Quarter FROM iccr_exp_camps where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getCampsByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'Camps' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN camps_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN camps_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN camps_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=" . $toyear . " THEN camps_amount END) Fourth_Quarter FROM iccr_exp_camps where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getISAByAppid($fromyear, $toyear, $appid) {
        $sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN isa_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN isa_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN isa_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=" . $toyear . " THEN isa_amount END) Fourth_Quarter FROM iccr_exp_isa_meeting where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getISAByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN isa_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN isa_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN isa_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=" . $toyear . " THEN isa_amount END) Fourth_Quarter FROM iccr_exp_isa_meeting where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getSumptuaryByAppid($fromyear, $toyear, $appid) {
        $sql = "Select 'sump' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sump_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sump_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sump_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=" . $toyear . " THEN sump_amount END) Fourth_Quarter FROM iccr_exp_sumptuary where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getSumptuaryByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'sump' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sump_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sump_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sump_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=" . $toyear . " THEN sump_amount END) Fourth_Quarter FROM iccr_exp_sumptuary where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getEmergencyFundByAppid($fromyear, $toyear, $appid) {
        $sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ef_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ef_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ef_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=" . $toyear . " THEN ef_amount END) Fourth_Quarter FROM iccr_exp_emergency_fund where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getEmergencyFundByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ef_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ef_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN ef_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=" . $toyear . " THEN ef_amount END) Fourth_Quarter FROM iccr_exp_emergency_fund where regionid=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getStudentDayByAppid($fromyear, $toyear, $appid) {
        $sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sd_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sd_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sd_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=" . $toyear . " THEN sd_amount END) Fourth_Quarter FROM iccr_exp_student_day where application_id='" . $appid . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getStudentDayByFY($fromyear, $toyear, $regionId) {
        $sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sd_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sd_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=" . $fromyear . " THEN sd_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=" . $toyear . " THEN sd_amount END) Fourth_Quarter FROM iccr_exp_student_day where regionId=" . $regionId;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getDemands($regionid) {
        $this->db->select('iccr_rodemands.*');
        $this->db->from('iccr_rodemands');
        $this->db->where(array('regional_office' => $regionid, 'status' => -1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getconfirmationDataforHqrs($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getagreeconfirmationDataByMission($appno) {
        $this->db->select('application_id,region_one_status_date,region_one_doc,regional_university,university_is_accept,course,confirmed_to_mission,confirmed_course,reject_reason,timeline');
        $this->db->from('iccr_university_response_by_hqrs');
        $this->db->where(array('application_id' => $appno,'confirmed_to_mission' => -1));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getagreeconfirmationDataByMissionSfs($appno) {
        $this->db->select('application_id,region_one_status_date,region_one_doc,regional_university,university_is_accept,course,confirmed_to_mission,confirmed_course,reject_reason,timeline');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno,'confirmed_to_mission' => 1));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getconfirmationDataByMission($appno) {
        $this->db->select('iccr_university_response.application_id,iccr_university_response.region_one_status_date,iccr_university_response.region_one_doc,iccr_university_response.fee_structure,iccr_university_response.regional_university,iccr_university_response.university_is_accept,iccr_university_response.course,iccr_university_response.confirmed_to_mission,iccr_university_response.confirmed_course,iccr_university_response.subject,iccr_university_response.reject_reason,iccr_university_response.timeline,iccr_university_response.date_of_joining,ism.nomenclature');
        $this->db->from('iccr_university_response');
        $this->db->join('iccr_status_mapping as ism', 'ism.application_no = iccr_university_response.application_id');
        $this->db->where(array('application_id' => $appno,'confirmed_to_mission' => 1));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getconfirmationDataByMissionSfs($appno) {
        $this->db->select('application_id,region_one_status_date,region_one_doc,regional_university,university_is_accept,course,confirmed_to_mission,confirmed_course,reject_reason,timeline');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno,'confirmed_to_mission' => 2));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getconfirmationDataByMissionForUniversity($appno,$universityId) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno,'confirmed_to_mission' => 1,'regional_university'=>$universityId));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getconfirmationDataByMissionStatus($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno,'confirmed_to_mission' => 1));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getconfirmationDataforHqrsbyUniversityId($appno,$universityId) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno));
		$this->db->where(array('regional_university' => $universityId));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function getconfirmationDataforfourthoptionHqrs($appno) {
        $this->db->select('iccr_university_response_by_hqrs .*');
        $this->db->from('iccr_university_response_by_hqrs');
        $this->db->where(array('application_id' => $appno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getconfirmationDataforIcarhoptionHqrs($appno) {
        $this->db->select('iccr_university_response_by_hqrs .*');
        $this->db->from('iccr_university_response_by_hqrs');
        $this->db->where(array('application_id' => $appno ,'confirmed_to_mission' => -1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getconfirmationData($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('university_is_accept' => 1, 'application_id' => $appno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getconfirmationDataAcceptance($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('university_is_accept' => 1, 'application_id' => $appno,'scholar_acceptance' =>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
function getUniversityResponseSentByHqrsToMission7($data) {
	  $nowtime = time();
      $sql = "SELECT DISTINCT `iccr_status_mapping`.`status`,`iccr_student_application_details`.`application_no`,
 `iccr_student_application_details`.`fullname`, `iccr_student_application_details`.`email`, `iccr_countries`.`country_name`
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
 JOIN `iccr_university_response` ON `iccr_university_response`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
WHERE `iccr_status_mapping`.`status` >= 10 AND `iccr_status_mapping`.`iccr_status` = 1 AND `iccr_university_response`.`university_is_accept` = 1 AND `iccr_student_other_details`.`created` >= 1544832000 AND `iccr_student_other_details`.`created` <= ".$nowtime;
;

        return $this->db->query($sql)->result_array();
    }
    function isExistsFund($fy, $ro, $quarter) {
        $this->db->select('iccr_hqrs_fund_monitoring.*');
        $this->db->from('iccr_hqrs_fund_monitoring');
        $this->db->where(array('financial_year' => $fy, 'regional_office' => $ro, 'quarter' => $quarter));
        return $this->db->get()->result_array();
    }

    function isAnyUniversityResponseConfirm($appno, $regionId) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('region_one_status' => $regionId, 'application_id' => $appno));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function isAnyUniversityResponseConfirms($appno, $UniversityId) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('regional_university' => $UniversityId, 'application_id' => $appno));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 function isAnyUniversityResponseConfirmOld($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function isAnyUniversityResponseConfirmed($appno, $univesrsityId) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('regional_university' => $univesrsityId, 'application_id' => $appno));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function isAnyUniversityResponseConfirmedByAppno($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function isAnyUniversityResponseConfirmedOrNot($appno,$is_accept) {
        $this->db->select('iccr_university_response.university_is_accept,iccr_univercities.name,iccr_university_response.regional_university,iccr_univercities.id,iccr_university_response.region_one_doc,iccr_university_response.regional_university as UnId');
        $this->db->from('iccr_university_response');
		$this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_university_response.regional_university');
        $this->db->where(array('application_id' => $appno,'university_is_accept' => $is_accept));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
function isAnyUniversityResponseConfirmedOrNotAccepted($appno,$is_accept) {
        $this->db->select('iccr_university_response.university_is_accept,iccr_univercities.name,iccr_university_response.regional_university,iccr_univercities.id,iccr_university_response.region_one_doc,iccr_university_response.regional_university as UnId');
        $this->db->from('iccr_university_response');
		$this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_university_response.regional_university');
        $this->db->where(array('application_id' => $appno,'university_is_accept' => $is_accept,'scholar_acceptance'=> 1
		));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function isAnyUniversityResponseConfirmToHqrs($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno, 'university_is_accept' => 1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function isAnyUniversityResponseConfirmedToHqrs($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllDemands() {
        $this->db->select('iccr_rodemands.*');
        $this->db->from('iccr_rodemands');
        $this->db->where(array('status' => -1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
    function getCountAllDemands() {
        $this->db->select('iccr_rodemands.id');
        $this->db->from('iccr_rodemands');
        $this->db->where(array('status' => -1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->count_all_results();
    }

    function getAllProcessedDemands() {
        $this->db->select('iccr_rodemands.*');
        $this->db->from('iccr_rodemands');
        $this->db->where(array('status >' => 0));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getProcessedDemands($regionid) {
        $this->db->select('iccr_rodemands.*');
        $this->db->from('iccr_rodemands');
        $this->db->where(array('regional_office' => $regionid, 'status >' => 0));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getTotalFundtoRegionDetails($regionId) {
        $sql = "Select financial_year as FY, regional_office as RO,SUM(CASE WHEN quarter=1 THEN amount_released END) First_Quarter,SUM(CASE WHEN quarter=2 THEN amount_released END) Second_Quareter,SUM(CASE WHEN quarter=3 THEN amount_released END) Third_Quareter,SUM(CASE WHEN quarter=4 THEN amount_released END) Fourth_Quareter FROM iccr_hqrs_fund_monitoring where regional_office=" . $regionId . " Group BY regional_office";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function updateDemand($data) {
        $this->db->where('demand_id', $data['demand_id']);
        $this->db->update('iccr_rodemands', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function saveDemand($data) {
        $q = $this->db->insert_string('iccr_rodemands', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertFund($data) {
        $q = $this->db->insert_string('iccr_hqrs_fund_monitoring', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertTravelCharges($data) {
        $q = $this->db->insert_string('iccr_exp_travel', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertDeductions($data) {
        $q = $this->db->insert_string('iccr_exp_deductions', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertBankDetails($data) {
        $q = $this->db->insert_string('iccr_exp_bank_details', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertPermitDetails($data) {
        $q = $this->db->insert_string('iccr_exp_residential_permit', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertUniversity($data) {
        $q = $this->db->insert_string('iccr_univercities', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertunivercitiesListMapping($data) {
        $q = $this->db->insert_string('iccr_university_mapping', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertunivercitiesList($data) {
        $q = $this->db->insert_string('iccr_univercitiesList', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return $id;
        else
            return 0;
    }

    function updateRegion($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('iccr_regions', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            return FALSE;
        }
        return ($this->db->affected_rows() >= 0) ? TRUE : FALSE;
    }

    function insertRegion($data) {
        $q = $this->db->insert_string('iccr_regions', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertregionalExpenditure($data) {
        $q = $this->db->insert_string('iccr_regional_expenditure', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function getAllSemesters() {
        $this->db->select('iccr_academic_semesters.*');
        $this->db->from('iccr_academic_semesters');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOldAcademicApplicant($regionid) {
        $this->db->select('iccr_academic_details.*');
        $this->db->from('iccr_academic_details');
        $this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_academic_details.university');
        $this->db->where('iccr_academic_details.academic_type', "OLD");
        $this->db->where('iccr_univercities.state', $regionid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAcademicDetailsDataforReport($appno) {
        $this->db->select('iccr_academic_details.*');
        $this->db->from('iccr_academic_details');
        $this->db->where('iccr_academic_details.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAcademicStatusDataforReport($appno) {
        $this->db->select('iccr_academic_staus.*');
        $this->db->join('iccr_academic_details', 'iccr_academic_details.application_id = iccr_academic_staus.application_id');
        $this->db->from('iccr_academic_staus');
        $this->db->where('iccr_academic_staus.application_id', $appno);
        $this->db->order_by('iccr_academic_staus.aca_year');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getScholarshipStatusDataforReport($appno) {
        $this->db->select('iccr_scholarship_staus.*');
        $this->db->from('iccr_scholarship_staus');
        $this->db->where('iccr_scholarship_staus.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAcademicDataforReport($appno) {
        $this->db->select('iccr_academic_details.*');
        $this->db->from('iccr_academic_details');
        $this->db->where('iccr_academic_details.application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
    function getHeadquarterAcademicDataforReport($appno,$schemeids) {
        $this->db->select('iccr_academic_details.*');
        $this->db->from('iccr_academic_details');
        $this->db->where('iccr_academic_details.application_id', $appno);
		$this->db->where_in('iccr_academic_details.scheme', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAcademicData($appno) {
        $this->db->select('iccr_academic_details.*');
        $this->db->from('iccr_academic_details');
        $this->db->where('application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function insertAcademicDetails($data) {
        $q = $this->db->insert_string('iccr_academic_details', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateAcademic($data) {
        $update_data = array();
        $this->db->where(array('application_id' => $data['application_id'], 'is_sem' => $data['is_sem'], 'aca_year' => $data['aca_year']));
        if ($data['is_sem'] == 1) {
            $this->db->where('sem_no', $data['sem_no']);
        } elseif ($data['is_sem'] == 2) {
            $this->db->where('annual_no', $data['annual_no']);
        }
        $update_data = $data;
        unset($update_data['date_from']);
        unset($update_data['date_to']);
        if ($data['is_sem'] == "1") {
            unset($update_data['sem_no']);
        } elseif ($data['is_sem'] == "2") {
            unset($update_data['annual_no']);
        }
        unset($update_data['is_sem']);
        $this->db->update('iccr_academic_staus', $update_data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertAcademic($data) {
        $q = $this->db->insert_string('iccr_academic_staus', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertAttendanceData($data) {
        $q = $this->db->insert_string('iccr_attendance_staus', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertScholarshipStatus($data) {
        $q = $this->db->insert_string('iccr_scholarship_staus', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function getScholarshipStatusofApplicant($appno) {

        $this->db->select('iccr_academic_staus.*');
        $this->db->from('iccr_academic_staus');
        $this->db->where(array('application_id' => $appno));
        $this->db->order_by('aca_year', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function insertSchemeSlot($data) {
        $q = $this->db->insert_string('iccr_scheme_slots', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertMission($data) {
        $q = $this->db->insert_string('iccr_missions', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function getAttendenceStatus($acayear, $frommonth, $frmyear, $tomonth, $toyear, $appid) {
        $this->db->select('iccr_attendance_staus.*');
        $this->db->from('iccr_attendance_staus');
        $this->db->where(array('aca_year' => $acayear, 'sem_from_month' => $frommonth, 'sem_from_year' => $frmyear, 'sem_to_month' => $tomonth, 'sem_to_year' => $toyear, 'application_id' => $appid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getScholarshipStatus($acayear, $frommonth, $frmyear, $tomonth, $toyear, $appid) {
        $this->db->select('iccr_scholarship_staus.*');
        $this->db->from('iccr_scholarship_staus');
        $this->db->where(array('aca_year' => $acayear, 'sem_from_month' => $frommonth, 'sem_from_year' => $frmyear, 'sem_to_month' => $tomonth, 'sem_to_year' => $toyear, 'application_id' => $appid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getChecklistItemById($id) {
        $this->db->select('iccr_mission_checklist.item');
        $this->db->from('iccr_mission_checklist');
        $this->db->where('id', $id);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getPendingCheckList($appid) {
        $this->db->select('iccr_status_mapping.checklist_ids');
        $this->db->from('iccr_status_mapping');
        $this->db->where(array('iccr_status_mapping.application_no' => $appid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function pending_applications($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_other_details.application_through,iccr_student_other_details.mission_made_through,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 2));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function resubmitapplication($missionId) {
		
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.university_status_4,iccr_status_mapping.university_status_5,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');
        //$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 6));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function hold_applications($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 3));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMissionChecklist() {
        $this->db->select('iccr_mission_checklist.*');
        $this->db->from('iccr_mission_checklist');
		$this->db->where_in('iccr_mission_checklist.id', array(8, 9));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMissionsByCountry($cid) {
        $this->db->select('iccr_missions.*');
        $this->db->from('iccr_missions');
        $this->db->where('country', $cid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllMissions() {
        $this->db->select('iccr_missions.*,iccr_countries.country_name');
        $this->db->from('iccr_missions');
        $this->db->join('iccr_countries', 'iccr_missions.country = iccr_countries.id');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }

    function getAllRegions() {
        $this->db->select('iccr_regions.*');
        $this->db->from('iccr_regions');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllStudents1() {
        $this->db->select('iccr_users.email_id,iccr_student_details.*,iccr_countries.country_name');
        $this->db->from('iccr_users');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_users.id');
        $this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_details.country_of_domicile');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();die;
        return $this->db->get()->result_array();
    } 


	function getAllStudents(){
		
		$sql = "SELECT COUNT(a.username) as Total, a.user_country, a.email_id,c.country_name,a.created FROM `iccr_users` a 
                LEFT JOIN `iccr_countries` c ON a.user_country = c.id
                LEFT JOIN `iccr_student_details` ON `iccr_student_details`.`uid` =  a.id
                where date(a.created) >= date '2022-02-09' group by user_country";
		$re = $this->db->query($sql)->result_array();
		return $re;
	}
    function isExpenditureReady($appid) {
        $this->db->select('iccr_student_expenditure.id');
        $this->db->from('iccr_student_expenditure');
        $this->db->where(array('application_id' => $appid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllStudentsApplications($schemeids) {
        $this->db->select('iccr_student_application_details.*,iccr_users.email_id,iccr_student_details.*,iccr_countries.country_name,iccr_missions.mission_name,iccr_status_mapping.status,iccr_status_mapping.scholarship_id');
        $this->db->from('iccr_student_application_details');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.uid = iccr_student_application_details.uid');
        $this->db->join('iccr_users', 'iccr_student_application_details.uid = iccr_users.id');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_users.id');
        $this->db->join('iccr_missions', 'iccr_missions.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_countries', 'iccr_countries.id = iccr_missions.country');
        $this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_student_application_details.application_no');

        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        //echo $this->db->_compile_select();
        // die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        //$this->db->where(array('iccr_student_other_details.mission_made_through'=>$missionid));   
        return $this->db->get()->result_array();
    }

    function getAllUniversities() {
        $this->db->select('iccr_univercities.*,iccr_regions.name as statename,iccr_states.name as stname');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_regions', 'iccr_univercities.state = iccr_regions.id');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id', 'left');
		$this->db->where('iccr_univercities.status','1');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	    function getAllStreams() {
        $this->db->select('*');
        $this->db->from('iccr_stream');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getAllCurrentUniversities() {
        $this->db->select('iccr_univercities.*,iccr_regions.name as statename,iccr_states.name as stname');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_regions', 'iccr_univercities.state = iccr_regions.id');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id', 'left');
		//$this->db->where('iccr_univercities.status',1);
		$this->db->where(array('iccr_univercities.status' => 1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getApplicationUnderStatus($id) {
        $this->db->select('iccr_status_master.status');
        $this->db->from('iccr_status_master');
        $this->db->where(array('iccr_status_master.value' => $id));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllOLDSchemes() {
        $this->db->select('id,scheme_name,code');
        $this->db->from('iccr_schemes');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllFaqs() {
        $this->db->select('id,item,desc');
        $this->db->from('iccr_faqs');
        $this->db->order_by('iccr_faqs.id', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllSchemes() {
		$not_array = array(2,13,19,24,25,27);
		//$not_array = array(2,24,13,19,25);
        $this->db->select('id,scheme_name,code,desc,status');
        $this->db->from('iccr_scheme');
		$this->db->where_not_in('id',$not_array);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getLeftSlots($missionid, $schemeid) {
        $this->db->select('iccr_status_mapping.status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->where(array('iccr_student_other_details.mission_made_through' => $missionid, 'iccr_status_mapping.scholarship_id >' => $schemeid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getSlotsbySchemes($schemeid, $countryid) {
        $this->db->select('iccr_scheme_slots.slots');
        $this->db->from('iccr_scheme_slots');
        $this->db->where(array('iccr_scheme_slots.country_id' => $countryid, 'iccr_scheme_slots.scheme_id' => $schemeid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllSchemesOfMission($missionId) {
        $this->db->select('iccr_scheme.id,iccr_scheme.scheme_name,iccr_scheme.scheme_type');
        $this->db->from('iccr_scheme_slots');
        $this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_scheme_slots.scheme_id');
        $this->db->join('iccr_countries', 'iccr_countries.id = iccr_scheme_slots.country_id');
        $this->db->join('iccr_missions', 'iccr_missions.country = iccr_scheme_slots.country_id');
        $this->db->where('iccr_scheme_slots.slots=-3 or iccr_scheme_slots.country_id=' . $missionId);
        $this->db->group_by('iccr_scheme.id');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllSchemesSlotsOfMission($missionId) {
		$not_array = array(2,24,13,19,25);
        $this->db->select('iccr_scheme_slots.scheme_id,iccr_scheme_slots.id,iccr_scheme_slots.slots,iccr_scheme_slots.country_id,iccr_scheme.scheme_name,iccr_scheme.code,iccr_scheme.scheme_type');
        $this->db->from('iccr_scheme_slots');
        $this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_scheme_slots.scheme_id');
		$this->db->where_not_in('scheme_id',$not_array);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }

    function getAllNIFT() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link,iccr_univercities.title');
        $this->db->from('iccr_univercities');
        $this->db->where(array('university_type' => 9,'status'=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getNITUniversitiesofRO($regionId) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,link');
        $this->db->from('iccr_univercities');
        $this->db->where('iccr_univercities.state', $regionId);
        $this->db->where(array('university_type' => 3));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getNITUniversities() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link,iccr_univercities.title');
        $this->db->from('iccr_univercities');
        //	$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');	  
        $this->db->where(array('university_type' => 3,'status'=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    //added by punit
    function getNITUniversitiesByCourseType($id, $ctype) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link,iccr_univercities.title');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
        $this->db->where(array('iccr_university_mapping.programme_id' => $id, 'iccr_university_mapping.course_type' => $ctype));
        $this->db->from('iccr_univercities');
        //	$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');	  
        $this->db->where(array('university_type' => 3,'status'=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getYogaGurus() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.subject,iccr_univercities.link,iccr_univercities.title');
        $this->db->from('iccr_univercities');
        $this->db->where(array('university_type' => 4,'status'=>1));
		//$this->db->where_in(array('iccr_univercities.id' => 151));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCentralUniversitiesofRO($regionId) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni');
        $this->db->from('iccr_univercities');
        $this->db->where('iccr_univercities.state', $regionId);
        $this->db->where(array('university_type' => 1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCentralUniversities() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link,iccr_univercities.title');
        $this->db->from('iccr_univercities');
        //	$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');	  
        $this->db->where(array('university_type' => 1));
		$this->db->where(array('iccr_univercities.status' => 1,'status'=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    //created By punit
    function getCentralUniversitiesByCourseType($id, $ctype) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link,iccr_univercities.title');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
        $this->db->where(array('iccr_university_mapping.programme_id' => $id, 'iccr_university_mapping.course_type' => $ctype));
        $this->db->from('iccr_univercities');
        //	$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');	  
        $this->db->where(array('university_type' => 1));
		$this->db->where(array('iccr_univercities.status' => 1,'status'=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
//echo $this->db->last_query();
		//print_r($this->db->get()->result_array());
        return $this->db->get()->result_array();
    }

    function getICARUniversity() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link');
        $this->db->from('iccr_univercities');
        $this->db->where(array('university_type' => 6));
		$this->db->where(array('status' => 1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAYUSHUniversity() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link');
        $this->db->from('iccr_univercities');
        $this->db->where(array('university_type' => 7,'status'=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAgriculturalUniversity() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link,iccr_univercities.title,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        $this->db->where(array('university_type' => 6,'status'=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

	function getAgriculturalSfsUniversity() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link,iccr_univercities.title,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        $this->db->where(array('university_type' => 6,'status >='=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function getStateUniversitiesWithMapping($id, $ctype) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_states.name,iccr_states.id as stateid,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
        $this->db->where(array('iccr_univercities.university_type' => 2, 'iccr_university_mapping.programme_id' => $id, 'iccr_university_mapping.course_type' => $ctype,'iccr_univercities.status' => 1));
        //$this->db->order_by('iccr_univercities.name','ASC');
		//$this->db->where_in('iccr_univercities.id', 151);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	  function getICARUniversitiesWithMapping($id, $ctype) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_states.name,iccr_states.id as stateid,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
        $this->db->where(array('iccr_univercities.university_type' => 6, 'iccr_university_mapping.programme_id' => $id, 'iccr_university_mapping.course_type' => $ctype,'iccr_univercities.status' => 1));
        //$this->db->order_by('iccr_univercities.name','ASC');
		//$this->db->where_in('iccr_univercities.id', 151);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function getCentralUniversitiesWithMapping($id, $ctype) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        //$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
        $this->db->where(array('iccr_univercities.university_type' => 1, 'iccr_university_mapping.programme_id' => $id, 'iccr_university_mapping.course_type' => $ctype,'iccr_univercities.status' => 1));
        $this->db->order_by('iccr_univercities.name','ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
       // echo $this->db->_compile_select();
        return $this->db->get()->result_array();
    }

    function getStateUniversities() {
        $this->db->select('iccr_univercities.id,iccr_univercities.link,iccr_univercities.name as uni,iccr_univercities.title,iccr_states.name,iccr_states.id as stateid,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->where(array('university_type' => 2));
		$this->db->where(array('iccr_univercities.status' => 1));
        //$this->db->order_by('iccr_univercities.name','ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getStateUniversitiesofRO($regionId) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_states.name,iccr_states.id as stateid,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->where(array('university_type' => 2));
        $this->db->where('iccr_univercities.state', $regionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getUniversitiesByTypeAndStateId($state, $type) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name,iccr_states.name');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->where(array('state_id' => $state, 'university_type' => $type));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMissionInfo($missionid) {
        $this->db->select('iccr_missions.*,iccr_countries.country_name,iccr_countries.country_code');
        $this->db->from('iccr_missions');
        $this->db->join('iccr_countries', 'iccr_countries.id = iccr_missions.country');
        $this->db->where(array('iccr_missions.id' => $missionid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMissionInfos($ids) {
        $this->db->select('iccr_missions.*');
        $this->db->from('iccr_missions');
        //$this->db->join('iccr_countries', 'iccr_countries.id = iccr_missions.country');	  
        $this->db->where_in('iccr_missions.id', $ids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOccupations() {
        $this->db->select('iccr_alumni_occupation.*');
        $this->db->from('iccr_alumni_occupation');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOccupationsById($id) {
        $this->db->select('iccr_alumni_occupation.*');
        $this->db->from('iccr_alumni_occupation');
        $this->db->where('iccr_alumni_occupation.id', $id);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllSchemesSlot() {
        $this->db->select('iccr_scheme_slots.scheme_id,iccr_scheme_slots.id,iccr_scheme_slots.slots,iccr_scheme_slots.country_id,iccr_countries.country_name,iccr_scheme.scheme_name,iccr_scheme.code');
        $this->db->from('iccr_scheme_slots');
        $this->db->join('iccr_countries', 'iccr_countries.id = iccr_scheme_slots.country_id');
        $this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_scheme_slots.scheme_id');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAlumaniApplications($missionid) {
        $this->db->select('*');
        $this->db->from('iccr_alumni_data');
        $this->db->where('mission_id', $missionid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

     function getAllAlumaniApplications() {
        $this->db->select('*');
        $this->db->from('iccr_alumni_data');
		$this->db->order_by('duration_of_course_from','ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
    function getCountAllAlumaniApplications() {
        $this->db->select('iccr_alumni_data.id');
        $this->db->from('iccr_alumni_data');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->count_all_results();
    }

    function getAlumaniApplicationsByRegion($region) {
        $this->db->select('*');
        $this->db->from('iccr_alumni_data');
        $this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_alumni_data.unverisity','left');
        $this->db->where('iccr_univercities.state', $region);
		//$this->db->or_where('iccr_alumni_data.regional_id', $region);
		//$this->db->where_in('iccr_alumni_data.regional_id', $region);
		$this->db->or_where(array('iccr_alumni_data.regional_id' => $region));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAlumaniApplicationbyId($appno) {
        $this->db->select('*');
        $this->db->from('iccr_alumni_data');
        $this->db->where('application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getMissionAlumaniApplicationbyId($appno) {		
		$user_data = $this->session->userdata('user_data');
		$userCountryId = $user_data['user_country'];
		$condition = array('application_id' => $appno, 'mission_id' => $userCountryId);
        $this->db->select('*');
        $this->db->from('iccr_alumni_data');
		$this->db->where($condition);		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }			
        return $this->db->get()->result_array();
    }	
	  
	
	function getRegionalAlumaniApplicationbyId($appno) {
		$user_data = $this->session->userdata('user_data');
        $regionid = $user_data['state'];
       $this->db->select('*');
        $this->db->from('iccr_alumni_data');
        $this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_alumni_data.unverisity','left');
        $this->db->where('iccr_univercities.state', $regionid);
		 $this->db->where('iccr_alumni_data.application_id', $appno);
        $code = $this->db->error();  
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getTravelPlan($appno) {
        $this->db->select('*');
        $this->db->from('iccr_travelplan');
        $this->db->where(array('application_id' => $appno));
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
        return $this->db->get()->result_array();
    }
    function getTravelPlanArrived($appno) {
        $this->db->select('*');
        $this->db->from('iccr_travelplan');
        $this->db->where(array('application_id' => $appno,'status'=>14));
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllTravelPlan($appno) {
        $this->db->select('*');
        $this->db->from('iccr_travelplan');
        $this->db->where(array('application_id' => $appno));
        $this->db->order_by('id', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAllStates() {
        $sql = "select * from iccr_states order by name asc";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }

    function getUndertaking($appid) {
        $this->db->select('undertaking_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function uploadUndertaking($appid, $data) {
		//echo $appid;echo "<pre>";print_r($data);die;
        $this->db->where('application_no', $appid);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

	 function uploadUndertakingByRo($data,$appid) {
        $this->db->where('application_no', $appid);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
    function updateSchemeSlot($data) {
        $this->db->where('id', $data['id']);
        $this->db->update('iccr_scheme_slots', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateUniversity($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('iccr_univercities', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function ConfirmationofCourseToMissionByHqrs($data, $appno) {
        $this->db->where(array('application_id' => $appno, 'university_is_accept' => 1));
        $this->db->update('iccr_university_response', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function NOTConfirmationofCourseToMissionByHqrs($data, $appno) {
        $this->db->where(array('application_id' => $appno, 'university_is_accept' => 2));
        $this->db->update('iccr_university_response', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function ConfirmationForwardToMissionByHqrs($data, $appno) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function ForwardToHqrsFourthOption($data, $appno) {
        $q = $this->db->insert_string('iccr_university_response_by_hqrs', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }

    function ForwardToHqrs($data, $appno) {
        $q = $this->db->insert_string('iccr_university_response', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	 
	 
	
	function ForwardToRo($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertTravelPlan($data) {
        $q = $this->db->insert_string('iccr_travelplan', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }

    function ForwardtoUniversity($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function confirmregionforTravel($data, $appno) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertRegionalVisaInfo($data) {
        $q = $this->db->insert_string('iccr_regional_VISAInfo', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }

    function updateVisaInfo($data, $appno) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateMissionPass($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('iccr_missions', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function getUniversityById($universityId) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name,iccr_univercities.state');
        $this->db->from('iccr_univercities');
        $this->db->where(array('iccr_univercities.id' => $universityId,'iccr_univercities.status' =>1));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	 function getAlumniUniversityById($universityId) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name,iccr_univercities.state');
        $this->db->from('iccr_univercities');
        $this->db->where(array('iccr_univercities.id' => $universityId));
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 function getUniversityByIdOld($universityId) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name,iccr_univercities.state');
        $this->db->from('iccr_univercities');
        $this->db->where(array('iccr_univercities.id' => $universityId));
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getUniversityData($universityId,$programme,$course_type,$course) {
        $this->db->select('*');
        $this->db->from('iccr_univercities');
		$this->db->join('iccr_ayush_university_mapping', 'iccr_ayush_university_mapping.university_id = iccr_univercities.id');
        $this->db->where(array('iccr_ayush_university_mapping.university_id' => $universityId,'iccr_ayush_university_mapping.programme_id' => $programme,'iccr_ayush_university_mapping.course_type' => $course_type,'iccr_ayush_university_mapping.course_id' => $course));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getUgUniversityData($universityId,$programme,$course_type,$course) {
        $this->db->select('*');
        $this->db->from('iccr_univercities');
		$this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
		//$this->db->join('iccr_stream_page', 'iccr_stream_page.u = iccr_univercities.id');
        $this->db->where(array('iccr_university_mapping.university_id' => $universityId,'iccr_university_mapping.programme_id' => $programme,'iccr_university_mapping.course_type' => $course_type,'iccr_university_mapping.course_id' => $course));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
		function getUgUniversityStreamData($universityId,$programme,$course_type,$course){
        $this->db->select('*');
        $this->db->from('iccr_stream_page');
		//$this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
		//$this->db->join('iccr_stream_page', 'iccr_stream_page.u = iccr_univercities.id');
        $this->db->where(array('iccr_stream_page.user_id' => $universityId,'iccr_stream_page.programme_id' => $programme,'iccr_stream_page.course_type_id' => $course_type,'iccr_stream_page.course_id' => $course));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getUniversityStreamDataByCourse($programme,$course_type,$course){
        $this->db->select('*');
        $this->db->from('iccr_stream');
		//$this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
		//$this->db->join('iccr_stream_page', 'iccr_stream_page.u = iccr_univercities.id');
        $this->db->where(array('iccr_stream.programme_id' => $programme,'iccr_stream.course_type_id' => $course_type,'iccr_stream.course_id' => $course));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getUniversityCourseData($universityId) {
		//echo $universityId;die;
        $this->db->select('*');
        $this->db->from('iccr_univercities');
		$this->db->where('id',$universityId);
		$this->db->where('status',1);
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

  
    function getUniversityStateById($universityId) {
        $this->db->select('iccr_univercities.state,iccr_univercities.name,iccr_univercities.link,iccr_univercities.course_link');
        $this->db->from('iccr_univercities');
        $this->db->where(array('iccr_univercities.id' => $universityId));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getEnglishProficiencyTestResults($missionId) {
        $this->db->select('iccr_status_mapping.english_proficiency_test_marks,iccr_status_mapping.ref_no,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.english_proficiency_test_marks !=' => ''));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

     function getConfirmationofHqrs($missionId) {
        // Used in Mission Controller
		//$this->db->distinct();
        $this->db->select('iccr_status_mapping.english_proficiency_test_marks,iccr_status_mapping.id,iccr_status_mapping.status,iccr_status_mapping.iccr_status_date,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_status_mapping.university_is_accept,iccr_status_mapping.regional_university,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_university_response.region_one_status_date,iccr_student_other_details.created');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 10));
        $this->db->where_in('iccr_university_response.university_is_accept', array(1, 2));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		$this->db->where(array('iccr_status_mapping.created <'=> 1615749687));
		//$this->db->order_by('iccr_student_other_details.created','DESC');
		$this->db->order_by('iccr_status_mapping.iccr_status_date','ASC');
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function applicantAcceptance($schemeids,$year = null) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >=' => 11));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		$this->db->where(array('iccr_status_mapping.created <'=> 1615749687));
		$this->db->where(array('iccr_status_mapping.scholar_acceptance' => 1));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
    
     function countApplicantAcceptance($schemeids) {
           $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 11, 'iccr_status_mapping.status >=' => 12));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
       $countRow = $this->db->count_all_results();
       return $countRow;
    }
    

    function getAcceptedCandidates($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.undertaking_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where_in('iccr_status_mapping.status', array(11, 13));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	 function getAcceptedoldCandidates($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.undertaking_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where_in('iccr_status_mapping.status', array(11, 13));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getVisaConveyedApplicatgion($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where_in('iccr_status_mapping.status', array(13, -14));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
function getVisaConveyedoldApplicatgion($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where_in('iccr_status_mapping.status', array(13, -14));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
    function getConfirmationofCandidatesByAppno($missionId, $appno) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where('iccr_status_mapping.application_no', $appno);
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where_in('iccr_status_mapping.status', array(11, 12));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getConfirmationofCandidates($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where(array('iccr_status_mapping.status >' => 10));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

	    function getConfirmationofoldCandidates($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where(array('iccr_status_mapping.status >' => 10));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function scholarconfirmation($data, $appno) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function scholarArrived($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function confirmtomissionofuseracceptance($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateMissionStatus($data, $userid, $appno) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	

    function getMissionsRejectedApplications($missionid) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.mission_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.mission_status' => 2, 'iccr_status_mapping.status' => 1));
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getRoApplication() {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.mission_status' => 2, 'iccr_status_mapping.status' => 2));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMissionsProcessedApplicationslive($missionid) {
		$this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.universities_status,iccr_status_mapping.id,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.mission_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_student_application_details.course_option_name_two,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
		//$this->db->where(array('iccr_status_mapping.status >=' =>1));
        $this->db->where(array('iccr_university_response.confirmed_to_mission' =>1));
		//$this->db->or_where(array("iccr_status_mapping.universities_status"=>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	 function getMissionsProcessedApplications($missionid) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.scholar_acceptance,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.mission_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_two,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_status_mapping.scholarship_id,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject,iccr_status_mapping.mission_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->where('iccr_status_mapping.status >=', 10);
		$this->db->where('iccr_status_mapping.mission_status', 1);
		$this->db->where(array('iccr_student_details.apply_course_type !=' => 10));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->order_by('iccr_status_mapping.mission_status_date','asc');
		$this->db->order_by('iccr_status_mapping.id', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getMissionsProcessedApplications25($missionid) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.scholar_acceptance,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.mission_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_two,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_status_mapping.scholarship_id,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject,iccr_status_mapping.mission_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->where('iccr_status_mapping.status >=', 10);
		$this->db->where('iccr_status_mapping.mission_status', 1);
		$this->db->where(array('iccr_student_details.apply_course_type !=' => 10));
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->where(array('iccr_status_mapping.created >=' => 1735689600));
		//$this->db->order_by('iccr_status_mapping.mission_status_date','asc');
		$this->db->order_by('iccr_status_mapping.id', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getMissionsAyushProcessedApplications($missionid) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.scholar_acceptance,iccr_university_response_by_hqrs.region_one_doc,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.course_type,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.mission_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_two,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_status_mapping.scholarship_id,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject,iccr_status_mapping.mission_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
         //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->where('iccr_status_mapping.status >=', 10);
		$this->db->where('iccr_status_mapping.mission_status', 1);
		$this->db->where(array('iccr_student_application_details.course_type =' => 1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->order_by('iccr_status_mapping.mission_status_date','asc');
		$this->db->order_by('iccr_status_mapping.id', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

	function getMissionsAyushProcessedApplications25($missionid) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.scholar_acceptance,iccr_university_response_by_hqrs.region_one_doc,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.course_type,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.mission_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_two,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_status_mapping.scholarship_id,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject,iccr_status_mapping.mission_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->where('iccr_status_mapping.status >=', 10);
		$this->db->where('iccr_status_mapping.mission_status', 1);
		$this->db->where(array('iccr_student_application_details.course_type =' => 1));
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->where(array('iccr_status_mapping.created >=' => 1735689600));
		//$this->db->order_by('iccr_status_mapping.mission_status_date','asc');
		$this->db->order_by('iccr_status_mapping.id', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function getMissionsApprovedApplications($missionid) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.mission_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status > ' => 0, 'iccr_status_mapping.mission_status' => 1, 'iccr_student_other_details.application_through' => $missionid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getUniversityResponses($appno) {
        $sql = "SELECT application_id, GROUP_CONCAT(region_one_status SEPARATOR ',') as regional_office,GROUP_CONCAT(regional_university SEPARATOR ',') as University,GROUP_CONCAT(university_is_accept SEPARATOR ',') as response, GROUP_CONCAT(region_one_doc SEPARATOR ';') as docs, GROUP_CONCAT(confirmed_to_mission SEPARATOR ',') as confirmed_to_mission
FROM iccr_university_response where application_id ='" . $appno . "' GROUP BY application_id";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }
    
	
	function getUniversityResponsesbyHqrs($appno) {
        $sql = "SELECT application_id, GROUP_CONCAT(region_one_status SEPARATOR ',') as regional_office,GROUP_CONCAT(regional_university SEPARATOR ',') as University,GROUP_CONCAT(university_is_accept SEPARATOR ',') as response, GROUP_CONCAT(region_one_doc SEPARATOR ';') as docs, GROUP_CONCAT(confirmed_to_mission SEPARATOR ',') as confirmed_to_mission
FROM iccr_university_response_by_hqrs where application_id ='" . $appno . "' GROUP BY application_id";
//echo $sql;die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }
	function getUniversityResponsesbyHqrsNew($appno) {
        $sql = "SELECT application_id, GROUP_CONCAT(region_one_status SEPARATOR ',') as regional_office,GROUP_CONCAT(regional_university SEPARATOR ',') as University,GROUP_CONCAT(university_is_accept SEPARATOR ',') as response, GROUP_CONCAT(region_one_doc SEPARATOR ';') as docs, GROUP_CONCAT(confirmed_to_mission SEPARATOR ',') as confirmed_to_mission
FROM iccr_university_response_by_hqrs where application_id ='" . $appno . "' GROUP BY application_id";
//echo $sql;die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
    }
  function getCountRegionalApplications($regionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        // $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >=' => 4));
        $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ')');
        $this->db->order_by('iccr_status_mapping.id', 'ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

function getRegionalApplicationsConfirmationtoHqrs($schemeids) {
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_countries.country_name,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.course as courseconfirm,iccr_university_response.confirmed_to_mission,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details','iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 4));
		//$this->db->where_in('iccr_status_mapping.status', array(4));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->order_by('iccr_university_response.id', 'DESC');
		
		//echo $this->db->_compile_select();die;
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getRegionalApplicationsAllConfirmationtoHqrs($schemeids) {
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.mission_status_date,iccr_university_response.region_one_status_date,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.course as courseconfirm,iccr_university_response.confirmed_to_mission,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details','iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 4));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		
        $this->db->order_by('iccr_university_response.id', 'DESC');
		
		//echo $this->db->_compile_select();die;
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	
    function getRegionalApplicationsConfirmationtoHqrs9($schemeids) {
		//echo "<pre>";
		//print_r($schemeids);die;
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.new,iccr_status_mapping.university_is_accept,iccr_university_response.university_is_accept as University_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.course as courseconfirm,iccr_university_response.confirmed_to_mission,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details','iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        //$this->db->where(array('iccr_status_mapping.status' => 8));
		$this->db->where(array('iccr_status_mapping.status >=' => 8));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->order_by('iccr_university_response.id', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }

    
    
   /*

    *  Added By Rahul dey 
    *  Query optimizing to get Application no
    *     
    */ 
     function getAppNoRegionalApplicationsConfirmationtoHqrs($schemeids) {
        $this->db->distinct();
        $this->db->select('iccr_student_application_details.application_no');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
         $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 4));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
       $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
        
    }
    
        function getAppNoRegionalApplicationsConfirmationtoRegion($regional) {
        $this->db->distinct();
        $this->db->select('iccr_student_application_details.application_no');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
         $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        //$this->db->where(array('iccr_status_mapping.status' => 4));
		$this->db->where(array('iccr_status_mapping.status >=' => 4));
		$this->db->where(array('iccr_university_response.region_one_status' => $regional));
		//$this->db->where(array('iccr_university_response.iccr_university_response >=' => regional));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
       $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
        
    }
    
    function getconfirmationForwardtoMissionbyHqrs() {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.mission_status' => 1, 'iccr_status_mapping.status' => 5, 'iccr_status_mapping.region_one_status>' => 0, 'iccr_status_mapping.iccr_status >' => 0));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function ExpenditureExists($appid) {
        $this->db->select('iccr_student_expenditure.*');
        $this->db->from('iccr_student_expenditure');
        $this->db->where('iccr_student_expenditure.application_id', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function oldExpenditureExists($appid) {
        $this->db->select('iccr_old_student_expenditure.*');
        $this->db->from('iccr_old_student_expenditure');
        $this->db->where('iccr_old_student_expenditure.application_no', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOldRegionalReceivedApplication($regionid) {
        $this->db->select('iccr_student_expenditure.*');
        $this->db->from('iccr_student_expenditure');
        $this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_student_expenditure.universty_choice');
        $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        $this->db->where('iccr_univercities.state', $regionid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getOldReceivedApplication($schemeids) {
        $this->db->select('iccr_student_expenditure.*');
        $this->db->from('iccr_student_expenditure');
        $this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_student_expenditure.universty_choice');
        $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
        $this->db->where_in('iccr_student_expenditure.scheme', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getAcademicDetailsForhqrs($schemeids) {
        $this->db->select('iccr_academic_details.*');
        $this->db->from('iccr_academic_details');
        $this->db->where_in('iccr_academic_details.scheme', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getRegionalReceivedApplication($regionId) {
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.bonafide_doc,iccr_status_mapping.joining_doc,iccr_status_mapping.police_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no');
		//$this->db->join('iccr_issue_documents', 'iccr_issue_documents.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');

        $this->db->where('(iccr_university_response.region_one_status=' . $regionId . ' and iccr_university_response.university_is_accept=1) or (iccr_university_response_by_hqrs.region_one_status=' . $regionId . ' and iccr_university_response_by_hqrs.university_is_accept=1)');
        $this->db->where(array('iccr_status_mapping.status' => 14, 'iccr_travelplan.status' => 14));
		$this->db->order_by('iccr_travelplan.created','DESC');
		//$this->db->where(array('iccr_status_mapping.status' => 15));
        // $this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.')'); 	
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();die;
        return $this->db->get()->result_array();
    }

    function getRegionalTravelApplication($regionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_student_application_details.programme,iccr_student_application_details.course');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no and iccr_travelplan.status = iccr_status_mapping.status');
        $this->db->where_in('iccr_status_mapping.status', array(13, 14, -14));

        if (sizeof($applicalitonIds) > 0) {
            //print_r($applicalitonIds);
            //$this->db->where_in('iccr_status_mapping.application_no',$applicalitonIds);
        }

        //  $this->db->where('(iccr_university_response.region_one_status='.$regionId.' && iccr_university_response_by_hqrs.region_one_status='.$regionId.')'); 
        //  $this->db->where('(iccr_university_response.university_is_accept!=2 or iccr_university_response_by_hqrs.university_is_accept!=2)'); 
        //  $this->db->where('(iccr_university_response.university_is_accept=1 or iccr_university_response_by_hqrs.university_is_accept=1)'); 
        //$this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.')'); 	   
        //  echo $this->db->_compile_select();
        //  die;  
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getConfirmationofApplicationIds($appid) {
		//echo $appid;die;
        $sql = "SELECT t1.* FROM iccr_university_response as t1 WHERE t1.application_id='" . $appid . "'";
        //$sql = "Select tt.* from ((SELECT t1.* FROM iccr_university_response as t1 WHERE t1.application_id='" . $appid . "') UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2 WHERE  t2.application_id='" . $appid . "')) as tt where tt.university_is_accept=1 and tt.confirmed_to_mission = 1";
		//echo $sql;die;
        $q = $this->db->query($sql);
        return $q->result();
    }

	function getConfirmationofApplicationAyushIds($appid) {
		//echo $appid;die;
        $sql = "Select tt.* from ((SELECT t1.* FROM iccr_university_response as t1 WHERE t1.application_id='" . $appid . "') UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2 WHERE  t2.application_id='" . $appid . "')) as tt where tt.university_is_accept=1";
		//echo $sql;die;
        $q = $this->db->query($sql);
        return $q->result();
    }
	
    function getApplicationIdsofTravel($regionId) {
        //echo $regionId;die;
		//$regionId_lcknow = 13;
        $sql = "Select iccr_student_application_details.created,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.undertaking_status_by_region,
		iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,tt.region_one_status, tt.application_id,tt.region_one_status_date,tt.region_one_doc,tt.regional_university,tt.university_is_accept,tt.course,iccr_status_mapping.status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_travelplan.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_travelplan.travel_plan_doc,iccr_status_mapping.scholarship_id from ((SELECT t1.* FROM iccr_university_response as t1) UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2)) as tt 
join iccr_status_mapping on iccr_status_mapping.application_no = tt.application_id 
join iccr_student_application_details on iccr_student_application_details.application_no = iccr_status_mapping.application_no 
join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
join iccr_travelplan on iccr_travelplan.application_id = iccr_status_mapping.application_no and iccr_travelplan.regional_office_contacted = ".$regionId." and iccr_travelplan.status = iccr_status_mapping.status
where iccr_status_mapping.status IN(13,14,-14,15) and `iccr_status_mapping`.`created` < 1615749687 and tt.university_is_accept=1 and tt.region_one_status =".$regionId." order by iccr_travelplan.created DESC";


        $result = $this->db->query($sql);
		//
        if ($result != "") {
            return $result->result_array();
        } else {
            
        }
    }

function getApplicationIdsofTravelPlan($regionId) {
        //echo $regionId;die;
		//$regionId_lcknow = 13;
        $sql = "Select iccr_student_application_details.created,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.undertaking_status_by_region,
		iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,tt.region_one_status, tt.application_id,tt.region_one_status_date,tt.region_one_doc,tt.regional_university,tt.university_is_accept,tt.course,iccr_status_mapping.status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_travelplan.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_travelplan.travel_plan_doc,iccr_status_mapping.scholarship_id from ((SELECT t1.* FROM iccr_university_response as t1) UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2)) as tt 
join iccr_status_mapping on iccr_status_mapping.application_no = tt.application_id 
join iccr_student_application_details on iccr_student_application_details.application_no = iccr_status_mapping.application_no 
join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
join iccr_travelplan on iccr_travelplan.application_id = iccr_status_mapping.application_no and iccr_travelplan.status = iccr_status_mapping.status 
where iccr_status_mapping.status IN(13,14,-14,15) and `iccr_status_mapping`.`created` >= 1615749687 and tt.university_is_accept=1 and tt.confirmed_to_mission = 1 and  tt.region_one_status =".$regionId." order by iccr_travelplan.created DESC";


        $result = $this->db->query($sql);
		//
        if ($result != "") {
            return $result->result_array();
        } else {
            
        }
    }
    function getRegionalApplicationsForwardtoHqrs($regionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.mission_status' => 1, 'iccr_status_mapping.status' => 4, 'iccr_status_mapping.region_one_status>' => 0, 'iccr_status_mapping.iccr_status' => -1));
        $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ')');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getRegionalPendingUniversityApplications($regionId) {
		        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.university_status_4,iccr_status_mapping.university_status_5,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');
        //$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_status_mapping.status', array(4));
        
        // $this->db->where('iccr_status_mapping.region_one_status <',1);
        //$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ') ');
		 $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ') ');
        $this->db->where(array('iccr_status_mapping.status >='=>4));
         //echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getRegionalApplications($regionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.email,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.uni_forwarded_letter,iccr_status_mapping.uni_forwarded_letter_two,iccr_status_mapping.uni_forwarded_letter_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status >=' =>1));
		//$this->db->where(array('iccr_status_mapping.status >=' =>4));
        //$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ')');
		$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' .$regionId .' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ')');
        $this->db->order_by('iccr_status_mapping.id', 'ASC');
//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }

    //vipin demo
    function getRegionalApplications12($regionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.email,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.uni_forwarded_letter,iccr_status_mapping.uni_forwarded_letter_two,iccr_status_mapping.uni_forwarded_letter_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_status_mapping.status', array(4));
        $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ')');


        $this->db->order_by('iccr_status_mapping.id', 'ASC');
		echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

	function getRegionalApplications1($regionId) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.email,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.uni_forwarded_letter,iccr_status_mapping.uni_forwarded_letter_two,iccr_status_mapping.uni_forwarded_letter_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status >=' => 4));
		$this->db->where(array('iccr_status_mapping.status !=' => 5));
        $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ')');
        //$this->db->order_by('iccr_status_mapping.id', 'ASC');
		//$this->db->order_by('iccr_status_mapping.mission_status_date', 'ASC');
		//$this->db->order_by("STR_TO_DATE(iccr_status_mapping.mission_status_date, '%d/%M/%Y %H:%i')");
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
        return $this->db->get()->result_array();
    }
	
  	function getUniversityResponseSentByRoToMission($data) {
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.iccr_status_date,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.gender,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.region_one_doc,iccr_university_response.course,iccr_university_response.course,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
		$this->db->where(array('iccr_status_mapping.status!=' => 15));
		//$this->db->where(array('iccr_status_mapping.region_forward_mission_status' => 18));
		$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
        $this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
		$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		//$this->db->order_by('str_to_date('iccr_status_mapping.iccr_status_date', '%d-%b-%Y')','ASC');
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCountPendingUnderRegionalApplications($schemeids) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        //$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
    
    
    function getPendingUnderRegionalApplications($schemeids) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >=' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        // echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
    
    
    function getHQRSAYUSHProcessedApplication($schemeids) {
        $this->db->select('iccr_status_mapping.status,iccr_student_details.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_university_response_by_hqrs.region_one_doc,iccr_university_response_by_hqrs.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		 $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 10));
		//$this->db->where(array('iccr_student_application_details.university_choice_one_state >=' => 0, 'iccr_student_application_details.university_choice_two_state >=' => 0, 'iccr_student_application_details.university_choice_three_state >=' => 0));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->or_where(array("iccr_student_application_details.programme" => 8));
        //$this->db->where(array('iccr_student_application_details.course_type' => 0));
        $this->db->where("iccr_status_mapping.scholarship_id IS NOT NULL");
        $this->db->where("iccr_status_mapping.scholarship_id != ''");
		$this->db->order_by('iccr_student_details.created', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
    /*=============Added by Rahul Dey=========
     *  This function is used only for count Ayush Processed Application
     *  to optimize the query
     */
   function getCountHQRSAYUSHProcessedApplication($schemeids) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where(array('iccr_student_application_details.university_choice_one_state >=' => 0, 'iccr_student_application_details.university_choice_two_state >=' => 0, 'iccr_student_application_details.university_choice_three_state >=' => 0));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->or_where(array("iccr_student_application_details.programme" => 8));
        $this->db->where(array('iccr_student_application_details.course_type' => 0));
        $this->db->where("iccr_status_mapping.scholarship_id IS NOT NULL");
        $this->db->where("iccr_status_mapping.scholarship_id != ''");
         $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    } 
    
    

    function getHQRSAYUSHApplicationdemo($schemeids) {
        $this->db->select('iccr_status_mapping.status,iccr_student_details.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 4));
        $this->db->where(array('iccr_student_application_details.university_choice_one_state' => 0, 'iccr_student_application_details.university_choice_two_state' => 0, 'iccr_student_application_details.university_choice_three_state' => 0));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
     
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->or_where(array("iccr_student_application_details.programme"=>8));
        $this->db->where(array('iccr_student_application_details.course_type' => 0));
        $this->db->where("iccr_status_mapping.scholarship_id IS NOT NULL"); 
        $this->db->where("iccr_status_mapping.scholarship_id != ''");
      
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	 function getHQRSAYUSHApplication($schemeids) {
        $this->db->select('iccr_status_mapping.status,iccr_student_details.created,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 4));
        $this->db->where(array('iccr_student_application_details.university_choice_one_state >=' => 0, 'iccr_student_application_details.university_choice_two_state >=' => 0, 'iccr_student_application_details.university_choice_three_state >=' => 0));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->or_where(array("iccr_student_application_details.programme" => 8));
        $this->db->where(array('iccr_student_application_details.course_type' => 0));
        $this->db->where("iccr_status_mapping.scholarship_id IS NOT NULL");
        $this->db->where("iccr_status_mapping.scholarship_id != ''");
		$this->db->order_by('iccr_student_details.created', 'ASC');
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	 function getHQRSAYUSHReceivedApplication() {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.created,iccr_student_details.apply_course_type,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >='=> 1));
        //$this->db->where(array('iccr_student_application_details.university_choice_one_state >=' => 0, 'iccr_student_application_details.university_choice_two_state >=' => 0, 'iccr_student_application_details.university_choice_three_state >=' => 0));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        //$this->db->or_where(array("iccr_student_application_details.programme" => 8));
        //$this->db->where(array('iccr_student_application_details.course_type' => 0));
		$this->db->where(array('iccr_student_details.apply_course_type' => 10));
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->order_by('iccr_status_mapping.created', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getHQRSAYUSHReceivedApplication2023() {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.created,iccr_student_details.apply_course_type,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_status_mapping.iccr_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >='=> 1));
        //$this->db->where(array('iccr_student_application_details.university_choice_one_state >=' => 0, 'iccr_student_application_details.university_choice_two_state >=' => 0, 'iccr_student_application_details.university_choice_three_state >=' => 0));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        //$this->db->or_where(array("iccr_student_application_details.programme" => 8));
        //$this->db->where(array('iccr_student_application_details.course_type' => 0));
		$this->db->where(array('iccr_student_details.apply_course_type' => 10));
		$this->db->where(array('iccr_status_mapping.created >='=> 1681169602));
        $this->db->where(array('iccr_status_mapping.created <='=> 1704034611));
        
		$this->db->order_by('iccr_status_mapping.created', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getHQRSAYUSHReceivedApplication2024() {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.created,iccr_student_details.apply_course_type,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_status_mapping.iccr_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >='=> 1));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1712847411));
        
		$this->db->order_by('iccr_status_mapping.created', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
    function getHQRSAYUSHReceivedApplication2025() {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.created,iccr_student_details.apply_course_type,iccr_status_mapping.mission_status_date,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_status_mapping.iccr_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >='=> 1));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1744184668));
        
		$this->db->order_by('iccr_status_mapping.created', 'DESC'); 
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
    
     /*=============Added by Rahul Dey=========
     *  This function is used only for count Ayush New Application
     *  to optimize the query
     */
   function getCountHQRSAYUSHApplication($schemeids) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no'); 
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
       $this->db->where(array('iccr_status_mapping.status' => 4));
        $this->db->where(array('iccr_student_application_details.university_choice_one_state >=' => 0, 'iccr_student_application_details.university_choice_two_state >=' => 0, 'iccr_student_application_details.university_choice_three_state >=' => 0));
        $this->db->where(array('iccr_student_application_details.course_type' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->or_where(array("iccr_student_application_details.programme" => 8));
        $this->db->where(array('iccr_student_application_details.course_type' => 0));
        $this->db->where("iccr_status_mapping.scholarship_id IS NOT NULL");
        $this->db->where("iccr_status_mapping.scholarship_id != ''");
        $code = $this->db->error();
     //     echo $this->db->_compile_select();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    } 
    

    function getHqrsICARProcessedApplication() {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_status_mapping.mission_status_date,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_university_response_by_hqrs.region_one_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status>=' => 4));
        $this->db->where(array('iccr_student_application_details.course_type' => 2));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', NULL);
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
    
     /*=============Added by Rahul Dey=========
     *  This function is used only for count ICCR Processed Application
     *  to optimize the query
     */
    function getCountHqrsICARProcessedApplication($schemeids) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
          $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 10));
        $this->db->where(array('iccr_student_application_details.course_type' => 2));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
    
    
    
    

    function getHqrsICARApplication($schemeids = null) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_status_mapping.created as SubmitedDate,iccr_student_other_details.created,iccr_status_mapping.mission_status_date,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 1));
        $this->db->where(array('iccr_student_application_details.course_type' => 2));
        $this->db->where(array('iccr_student_application_details.university_choice_one_state' => 0, 'iccr_student_application_details.university_choice_two_state' => 0, 'iccr_student_application_details.university_choice_three_state' => 0,));
       // $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
	   $this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
	    $this->db->order_by('iccr_status_mapping.created','ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
    
    /*=============Added by Rahul Dey=========
     *  This function is used only for count ICCR New Application
     *  to optimize the query
     */
     function getCountHqrsICARApplication($schemeids = null) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');  
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 1));
        $this->db->where(array('iccr_student_application_details.course_type' => 2));
        $this->db->where(array('iccr_student_application_details.university_choice_one_state' => 0, 'iccr_student_application_details.university_choice_two_state' => 0, 'iccr_student_application_details.university_choice_three_state' => 0));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        
        return $countRowQuery;
    }
    
    

    function getHqrsAllNewApplication() {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
    
      function getCountHqrsAllNewApplication() {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
       // $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
     //   $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->count_all_results();
    }

    function getHqrsNewApplication($schemeids) {
       
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status >=' => 4)); 
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->limit(1);
        //echo $this->db->_compile_select();exit;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
    
    function getCountHqrsNewApplication($schemeids) {
		
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.application_no');
        $this->db->from('iccr_status_mapping');
      //  $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        //$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
       // $this->db->where(array('iccr_status_mapping.status >=' => 4));
	   $this->db->where(array('iccr_status_mapping.status >=' => 1));
		//$this->db->where(array('iccr_status_mapping.status !=' => 15));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		
		//$this->db->where(array('iccr_status_mapping.created >='=> 1575158400));
		$this->db->where(array('iccr_status_mapping.created >='=> 1575158400));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));

        //echo $this->db->_compile_select();exit;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function getCountHqrsNineteenApplication($schemeids) {
		
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.application_no,iccr_student_other_details.created');
        $this->db->from('iccr_status_mapping');
      //  $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
       // $this->db->where(array('iccr_status_mapping.status >=' => 4));
	   $this->db->where(array('iccr_status_mapping.status >=' => 1));
		//$this->db->where(array('iccr_status_mapping.status !=' => 15));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		
		//$this->db->where(array('iccr_status_mapping.created >='=> 1575158400));
		$this->db->where(array('iccr_student_other_details.created >='=> 1544812200));
		$this->db->where(array('iccr_student_other_details.created <='=> 1576368000));

        //echo $this->db->_compile_select();exit;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function getCountHqrsEighteenApplication($schemeids) {
		
		$this->db->distinct('iccr_status_mapping.application_no');
       $this->db->select('iccr_status_mapping.application_no,iccr_student_other_details.created');
        $this->db->from('iccr_status_mapping');
      //  $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
       // $this->db->where(array('iccr_status_mapping.status >=' => 4));
	   $this->db->where(array('iccr_status_mapping.status >=' => 1));
		//$this->db->where(array('iccr_status_mapping.status !=' => 15));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		
		//$this->db->where(array('iccr_status_mapping.created >='=> 1575158400));
		$this->db->where(array('iccr_student_other_details.created <='=> 1544812200));
			//$this->db->group_by('iccr_status_mapping.application_no');

        //echo $this->db->_compile_select();exit;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function getCountAllHqrsNewApplication($schemeids) {

        $this->db->select('iccr_status_mapping.id,iccr_status_mapping.created');
        $this->db->from('iccr_status_mapping');
		$this->db->where(array('iccr_status_mapping.status >=' => 1));
		//$this->db->where(array('iccr_status_mapping.universities_status >=' => -1));
		//$this->db->where(array('iccr_status_mapping.status !=' => 5));
		$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));

        //echo $this->db->_compile_select();exit;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function getRegionalBonafideDoc($appid) {
		//echo "<pre>";
						//print_r($appid);
		 $this->db->select('*');
        $this->db->from('iccr_issue_documents');
        $this->db->where('application_no', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getLastReference() {
        $sql = $this->db->query("select  SUBSTRING_INDEX(ref_no,'-',-1) as appid  from iccr_status_mapping where ref_no IS NOT NULL order by id DESC limit 0,1");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $sql->result();
    }

    function getApplicationData($appno, $userid) {
        $this->db->select('*');
        $this->db->from('iccr_student_application_details');
        $this->db->where(array('application_no' => $appno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCountriesofMissions($emailid) {
        $this->db->select('id');
        $this->db->from('iccr_missions');
        $this->db->where(array('iccr_missions.mission_email' => $emailid));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getMissionApplications($missionId,$cuntryid) {

        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status >=' => 1, 'iccr_status_mapping.universities_status' => 1,"iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
        $this->db->where_in('iccr_student_other_details.mission_made_through', $cuntryid);
		$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	  function getActiveNotification($todate) {
        $this->db->select('*');
        $this->db->from('iccr_notifications');

        $this->db->where('validated_upto >=', $todate);
        $this->db->order_by('id', "ASC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getNationality() {
        $this->db->select('id,title');
        $this->db->from('iccr_nationality');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCountries() {
        $this->db->select('id,country_name');
        $this->db->from('iccr_countries');
        $this->db->order_by('country_name', 'ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCountryById($id) {
        //echo $id;die;
        $this->db->select('country_name');
        $this->db->from('iccr_countries');
        $this->db->where('id', $id);
        $code = $this->db->error();
        //echo $this->db->_compile_select();exit;
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getNationalityById($id) {
        $this->db->select('title');
        $this->db->from('iccr_nationality');
        $this->db->where('id', $id);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getApplicationStatus($userid) {
        $this->db->select('iccr_status_mapping.application_no,iccr_status_mapping.status,iccr_student_application_details.fullname,iccr_student_application_details.phone,iccr_student_application_details.email,iccr_student_application_details.nationality,iccr_student_other_details.signature_doc,iccr_status_mapping.universities_status,iccr_status_mapping.undertaking_doc,visa_no,universities_status,scholarship_id','visa_from_date,visa_grant_permission');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid=iccr_status_mapping.uid');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.uid=iccr_status_mapping.uid');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no=iccr_status_mapping.application_no');
        $this->db->where('iccr_status_mapping.uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getApplicationStepOneByAppno($appno) {
        $this->db->select('iccr_student_application_details.*,iccr_student_details.father_fname,iccr_student_details.father_mname,iccr_student_details.father_lname,iccr_student_details.mother_fname,iccr_student_details.mother_fname,iccr_student_details.mother_lname');
        $this->db->from('iccr_student_application_details');
        $this->db->join('iccr_student_details','iccr_student_details.uid=iccr_student_application_details.uid');
        $this->db->where('iccr_student_application_details.application_no', $appno);

         //echo $this->db->_compile_select();exit;

        // $rr[] = $this->db->get()->result_array();
		// echo '<pre>'; print_r($rr);die;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	 function getUniversityApplicationStepOneByAppno1($appno) {
		 $user_data = $this->session->userdata('user_data');
		$universityId_icr1 = $user_data['university'];
        $this->db->select('iccr_student_application_details.*,iccr_student_details.father_fname,iccr_student_details.father_mname,iccr_student_details.father_lname,iccr_student_details.mother_fname,iccr_student_details.mother_fname,iccr_student_details.mother_lname');
        $this->db->from('iccr_student_application_details');
        $this->db->join('iccr_student_details','iccr_student_details.uid=iccr_student_application_details.uid');
		$this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_student_application_details.application_no');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId_icr1);
        $this->db->where('iccr_student_application_details.application_no', $appno);

         //echo $this->db->_compile_select();exit;

        // $rr[] = $this->db->get()->result_array();
		// echo '<pre>'; print_r($rr);die;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getUniversityApplicationStepOneByAppno($appno) {
		$user_data = $this->session->userdata('user_data');
		//$universityId_icr = $user_data['university'];
        $this->db->select('iccr_student_application_details.*,iccr_student_details.father_fname,iccr_student_details.father_mname,iccr_student_details.father_lname,iccr_student_details.mother_fname,iccr_student_details.mother_fname,iccr_student_details.mother_lname');
        $this->db->from('iccr_student_application_details');
        $this->db->join('iccr_student_details','iccr_student_details.uid=iccr_student_application_details.uid');
        $this->db->where('iccr_student_application_details.application_no', $appno);
//$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId_icr . ' or iccr_student_application_details.universty_choice_two=' . $universityId_icr . ' or iccr_student_application_details.universty_choice_three=' . $universityId_icr . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId_icr . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId_icr . ')');
         //echo $this->db->_compile_select();exit;

        // $rr[] = $this->db->get()->result_array();
		// echo '<pre>'; print_r($rr);die;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	
	 function getHeadquarterApplicationStepOneByAppno($appno) {
		// print_r($schemeid_s);die;
        $this->db->select('iccr_student_application_details.*,iccr_student_details.father_fname,iccr_student_details.father_mname,iccr_student_details.father_lname,iccr_student_details.mother_fname,iccr_student_details.mother_fname,iccr_student_details.mother_lname');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->where('iccr_student_application_details.application_no', $appno);
		$this->db->where(array('iccr_status_mapping.status >=' => 1));
		$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));

         //echo $this->db->_compile_select();exit;

        // $rr[] = $this->db->get()->result_array();
		// echo '<pre>'; print_r($rr);die;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getMsnApplicationStepOneByAppno($appno) {
		 $user_data = $this->session->userdata('user_data');
		$missionuserCountryId2 = $user_data['user_country'];
        $this->db->select('iccr_student_application_details.*,iccr_student_details.father_fname,iccr_student_details.father_mname,iccr_student_details.father_lname,iccr_student_details.mother_fname,iccr_student_details.mother_fname,iccr_student_details.mother_lname');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_details','iccr_student_details.uid=iccr_student_application_details.uid');
        $this->db->where('iccr_student_application_details.application_no', $appno);
        $this->db->where_in('iccr_student_other_details.application_through', $missionuserCountryId2); 
         //echo $this->db->_compile_select();exit;

        // $rr[] = $this->db->get()->result_array();
		// echo '<pre>'; print_r($rr);die;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getMissionApplicationStepOneByAppno($appno) {
		$user_data = $this->session->userdata('user_data');
		$missionuserCountryId = $user_data['user_country'];
        $this->db->select('iccr_student_application_details.*,iccr_student_details.father_fname,iccr_student_details.father_mname,iccr_student_details.father_lname,iccr_student_details.mother_fname,iccr_student_details.mother_fname,iccr_student_details.mother_lname');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_details','iccr_student_details.uid=iccr_student_application_details.uid');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where('iccr_student_application_details.application_no', $appno);
		$this->db->where_in('iccr_student_other_details.application_through', $missionuserCountryId);  

         //echo $this->db->_compile_select();exit;

        // $rr[] = $this->db->get()->result_array();
		// echo '<pre>'; print_r($rr);die;

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getApplicationSchemeId($appno) {
        $this->db->select('*');
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appno);
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
        return $this->db->get()->result_array();
    }
	
	
	public function update_userpass($email,$year = null,$data){
		
		//echo $email;
		//echo $year;
		//print_r($data);die;
		$pass = $data['password'];
		$pass_count = $data['pass_updated_count'];
		$sql = "UPDATE iccr_users SET password = '".$pass."', `pass_updated_count` = '".$pass_count."' WHERE  email_id = '".$email."'";
		
		if(!empty($year))
		{
			$previousYear = '2019';
			//$sql .=" and YEAR(created) ='".$year."'";
			$sql .= " and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.") and status = '1'";
		}
		
		$rs = $this->db->query($sql);
		if($rs){
			return true;
			
		}else{
			
			return false;
		}
	}
	
    function getAcademicDetailsofApplicant($appno) {
        $this->db->select('iccr_academic_staus.scholarship_status');
        $this->db->from('iccr_academic_details');
        $this->db->join('iccr_academic_staus', 'iccr_academic_staus.application_id=iccr_academic_details.application_id');
        $this->db->where(array('iccr_academic_details.application_id' => $appno));
        $this->db->order_by('iccr_academic_details.id', 'DESC');
        $this->db->limit(1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }



	 function getAcademicDetailsofSfsApplicant($appno) {
        $this->db->select('iccr_sfs_academic_staus.scholarship_status');
        $this->db->from('iccr_sfs_academic_details');
        $this->db->join('iccr_sfs_academic_staus', 'iccr_sfs_academic_staus.application_id=iccr_sfs_academic_details.application_id');
        $this->db->where(array('iccr_sfs_academic_details.application_id' => $appno));
        $this->db->order_by('iccr_sfs_academic_details.id', 'DESC');
        $this->db->limit(1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	//sfs
	function getApplicationSfsStepOne($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_student_application_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	  function getApplicationStepOne($userid) {
       
        $this->db->select('*');
        $this->db->from('iccr_student_application_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 function getApplicationPassportStepOne($userid) {
        $this->db->select('*');
        $this->db->from('iccr_student_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getApplicationStepTwo($userid) {
        $this->db->select('*');
        $this->db->from('iccr_student_education_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	   function getApplicationSfsStepTwo($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_student_education_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
function getApplicationSubmitDatabyAppNo($appno) {
        $this->db->select('created,scholar_acceptance');
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
}
function getApplicationSubmitDatabyUserId($uersId) {
        $this->db->select('created,application_no');
        $this->db->from('iccr_status_mapping');
        $this->db->where('uid', $uersId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
}
    function getApplicationStepTwoByAppno($appno) {
        $this->db->select('*');
        $this->db->from('iccr_student_education_details');
        $this->db->where('application_no', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getApplicationStepThreebyAppNo($appno) {
		//$user_data = $this->session->userdata('user_data');
		//$missionuserCountryId1 = $user_data['user_country'];
        $this->db->select('*');
        $this->db->from('iccr_student_other_details');
        $this->db->where('application_no', $appno);
		$this->db->where_in('application_through', $missionuserCountryId1);  
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }

    function getApplicationStepThree($userid) {
        $this->db->select('*');
        $this->db->from('iccr_student_other_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
	
	function getApplicationSfsStepThree($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_student_other_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }

    function getUserImage($userid) {
        $this->db->select('*');
		$this->db->from('iccr_profile_image');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
		//echo $this->db->last_query();die;
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }


 function getSfsUserImage($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_profile_image');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
    function imageExists($userid) {
        $this->db->select('*');
        $this->db->from('iccr_profile_image');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
	function passportExists($userid){
        $this->db->select('*');
        $this->db->from('iccr_users');
        $this->db->where('id', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
	function imageSfsExists($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_profile_image');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }

    function getApplicationByNo($appno) {
        $this->db->select('iccr_student_application_details.*,iccr_countries.country_name');
        $this->db->from('iccr_student_application_details');
        $this->db->join('iccr_countries', 'iccr_countries.id=iccr_student_application_details.country');
        $this->db->where('application_no', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        $result = $this->db->get()->result_array();
        if (sizeof($result) > 0)
            return $result;
        else
            return array();
    }
	
		function getScheme() {
        $this->db->select('*');
        $this->db->from('iccr_scheme');
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $result = $this->db->get()->result_array();
    }
	 function getUniversityResponseSentByRegionToMission($data,$regionId) {
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
		$ro_to_mission_status = $data['region_forward_mission_status'];
        //$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.region_forward_mission_status,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.region_one_doc,iccr_university_response.course,iccr_university_response.course,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		//$this->db->where(array('iccr_status_mapping.region_forward_mission_status>=' => $ro_to_mission_status));
		$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		//$this->db->where(array('iccr_status_mapping.status >=' => 4));
        $this->db->where(array('iccr_university_response.region_one_status' => $regionId));
		//$this->db->order_by('str_to_date('iccr_status_mapping.iccr_status_date', '%d-%b-%Y')','ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }

        return $this->db->get()->result_array();
    }
    function getSchemes() {
        $this->db->select('*');
        $this->db->from('iccr_profile_image');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }

    function getOldSchemeById($id) {
        $this->db->select('scheme_name,code');
        $this->db->from('iccr_schemes');
        $this->db->where('id', $id);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }

    function getSchemeById($id) {
        $this->db->select('id,scheme_name,code');
        $this->db->from('iccr_scheme');
        $this->db->where('id', $id);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }

    function applicationExists($userid) {
        $this->db->select('*');
        $this->db->from('iccr_student_application_details');
        $this->db->where('uid', $userid);		
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        $result = $this->db->get()->result_array();
        if (sizeof($result) > 0)
            return TRUE;
        else
            return FALSE;
    }
	
	    function applicationSfsExists($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_student_application_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        $result = $this->db->get()->result_array();
        if (sizeof($result) > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertDocuments($data) {
        $q = $this->db->insert_string('iccr_documents', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->insert_id();
    }
	 function insertAluminiDocuments($data) {
        $q = $this->db->insert_string('iccr_alumini_documents', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	
function insertSfsDocuments($data) {
        $q = $this->db->insert_string('iccr_sfs_documents', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }


    public function scholarArivalStatusUpdate($appno, $data, $id) {
        $sql = "update iccr_travelplan set iccr_travelplan.status=" . $data['status'] . ", iccr_travelplan.arrival_date_ro='" . $data['arrival_date_ro'] . "' where iccr_travelplan.id=" . $id;
        

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql);
    }

    public function updateApplicationMapStatus($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	public function updateApplicantResubmitStatus($appno, $data) {
        $this->db->where('application_id', $appno);
		$this->db->where('status', 5);
        $this->db->update('iccr_university_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

	  public function updateUniversityResubmitMapStatus($universityId,$appno, $data) {
        $this->db->where('application_no', $appno);
		 $this->db->where('regional_university', $appno);
        $this->db->update('iccr_university_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
    function insertBonafideDocument($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	
   


function insertIssueBonafideDocument($data) {
	//echo "<pre>"; print_r($data);
        $q = $this->db->insert_string('iccr_issue_documents', $data);
		//echo $this->db->_compile_select();die;
        $this->db->query($q);
		//print_r($this->db->last_query());die;
        $id = $this->db->insert_id();
		//echo $id;die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertJoiningDocument($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertPoliceDocument($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	function insertIssueRpDocument($data) {
	//echo "<pre>"; print_r($data);
        $q = $this->db->insert_string('iccr_rp_issue_documents', $data);
		//echo $this->db->_compile_select();die;
        $this->db->query($q);
		//print_r($this->db->last_query());die;
        $id = $this->db->insert_id();
		//echo $id;die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }
    function getCountUniversityResponseSentByRoToMissions() {
        // - 28 December Time Stamp 1590624000
          $status = '10';
          $iccr_status = '1';
          $this->db->distinct();
          $this->db->select('iccr_student_application_details.application_no');
          $this->db->from('iccr_status_mapping');
          $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
          $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
          $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
          $this->db->where(array('iccr_status_mapping.status >=' => $status));
          $this->db->where(array('iccr_status_mapping.status !=' =>15));
          //$this->db->where(array('iccr_status_mapping.region_forward_mission_status' =>18));
          //$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
          //$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
          $this->db->where(array('iccr_status_mapping.created >='=> 1590624000));
          $this->db->where(array('iccr_status_mapping.created <='=> 1609397249));
          $this->db->where(array('iccr_university_response.confirmed_to_mission' =>1));
          $code = $this->db->error();
          if ($code['code'] > 0) {
              //show_error('Message');
          }
  
          return $this->db->count_all_results();
      }
	function getCountUniversityResponseSentByRoToMission() {
	  // - 28 December Time Stamp 1590624000
        $status = '10';
        $iccr_status = '1';
        $this->db->distinct();
        $this->db->select('iccr_student_application_details.application_no');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => $status));
		$this->db->where(array('iccr_status_mapping.status !=' =>15));
		//$this->db->where(array('iccr_status_mapping.region_forward_mission_status' =>18));
        //$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		//$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->where(array('iccr_university_response.confirmed_to_mission' =>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->count_all_results();
    }
	 function getCountUniversityResponseSentByHqrsToMission() {
        $status = '10';
        $iccr_status = '1';
        $this->db->distinct();
        $this->db->select('iccr_student_application_details.application_no');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => $status));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		//$this->db->where(array('iccr_status_mapping.region_forward_mission_status !=' => 18));
		$this->db->where(array('iccr_status_mapping.status !=' =>15));
        $this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->count_all_results();
    }
    function updateApplicationStatus($appno, $userid) {
        $data = array(
            'status' => 'Submit'
        );
        $this->db->where('uid', $userid);
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_student_application_details', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function getResons($appid) {
        $this->db->select('checklist_ids');
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function updateApplicationStatusPending($appno, $userid) {
        $data = array(
            'status' => 'Pending'
        );
        $this->db->where('uid', $userid);
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_student_application_details', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function educationExists($userid) {
        $this->db->select('*');
        $this->db->from('iccr_student_education_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $result = $this->db->get()->result_array();
        if (sizeof($result) > 0)
            return TRUE;
        else
            return FALSE;
    }
function educationSfsExists($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_student_education_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $result = $this->db->get()->result_array();
        if (sizeof($result) > 0)
            return TRUE;
        else
            return FALSE;
    }
    function otherDetailExists($userid) {
        $this->db->select('*');
        $this->db->from('iccr_student_other_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $result = $this->db->get()->result_array();
        if (sizeof($result) > 0)
            return TRUE;
        else
            return FALSE;
    }
	
	  function otherSfsDetailExists($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_student_other_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $result = $this->db->get()->result_array();
        if (sizeof($result) > 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateUniversityForwardedLetter($data, $appni) {
        $this->db->where('application_no', $appni);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function updateOtherDetails($data, $userid) {
		unset($data['csrftestname']);
		unset($data['appno']);
        $this->db->where('uid', $userid);
        $this->db->update('iccr_student_other_details', $data);
        $success = $this->db->affected_rows();
        // print_r('lele');die;
        // print_r($success);die;
        if ($success){
            return TRUE;
        }else{
            return FALSE;
        }
    }
	
	function updateSfsOtherDetails($data, $userid) {
        $this->db->where('uid', $userid);
        $this->db->update('iccr_sfs_student_other_details', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function insertOtherDetails($data) {
		unset($data['csrftestname']);
		unset($data['appno']);
        $old_application_number = $data['old_application_number'];
        // $check = 0;
        // if(!empty($old_application_number)){
            
        //     $this->db->select('*');
        //     $this->db->from('iccr_student_application_details');
        //     $this->db->where('application_no', $old_application_number);
        //     $result = $this->db->get()->result_array();
        //     if(count($result) > 0){
        //         $check = 1;
        //     }else{
        //         return FALSE;
        //     }
        // }
        // if($check){
		
            $q = $this->db->insert_string('iccr_student_other_details', $data);
            $this->db->query($q);
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
        // }
        return $this->db->insert_id();
    }
	 function insertSfsOtherDetails($data) {
        $q = $this->db->insert_string('iccr_sfs_student_other_details', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }

    // function updateEducation($data, $userid) {
	// 	unset($data['csrftestname']);
	// 	unset($data['appno']);
    //     $this->db->where('uid', $userid);
    //     $this->db->update('iccr_student_education_details', $data);
    //     $code = $this->db->error();
    //     if ($code['code'] > 0) {
    //         //show_error('Message');
    //     }
    //     $success = $this->db->affected_rows();
    //     if ($success >= 0)
    //         return TRUE;
    //     else
    //         return FALSE;
    // }


    function updateEducation($data, $userid) {
		unset($data['csrftestname']);
		unset($data['appno']);


		
		$newdata = [

        'school_leaving_country_x'       => $data['country_secondary/high_school']?? '',
        'school_leaving_board_name_x'    => $data['board_secondary/high_school']?? '',
        'school_leaving_university_x'    => $data['institute_secondary/high_school']?? '',
        'school_leaving_subjects_x'      => $data['subjects_secondary/high_school']?? '',
        'school_leaving_year_x'          => $data['year_secondary/high_school']?? '',
        'school_leaving_percentage_x'    => $data['percentage_secondary/high_school']?? '',

        // INTERMEDIATE
        'school_leaving_country'      => $data['country_high_school/college']?? '',
        'school_leaving_board_name'   => $data['board_high_school/college']?? '',
        'school_leaving_university'   => $data['institute_high_school/college']?? '',
        'school_leaving_subjects'     => $data['subjects_high_school/college']?? '',
        'school_leaving_year'         => $data['year_high_school/college']?? '',
        'school_leaving_percentage'   => $data['percentage_high_school/college']?? '',

        // UNDERGRADUATE
        'ug_leaving_country'     => $data['country_undergraduate']?? '',
        'ug_leaving_board_name'  => $data['board_undergraduate']?? '',
        'ug_leaving_university'   => $data['institute_undergraduate']?? '',
        'ug_leaving_subjects'    => $data['subjects_undergraduate']?? '',
        'ug_leaving_year'        => $data['year_undergraduate']?? '',
        'ug_leaving_percentage'  => $data['percentage_undergraduate']?? '',
		

        // POSTGRADUATE
        'pg_leaving_country'      => $data['country_postgraduate']?? '',
        'pg_leaving_board_name'   => $data['board_postgraduate']?? '',
        'pg_leaving_university'    => $data['institute_postgraduate']?? '',
        'pg_leaving_subjects'     => $data['subjects_postgraduate']?? '',
        'pg_leaving_year'         => $data['year_postgraduate']?? '',
        'pg_leaving_percentage'   => $data['percentage_postgraduate']?? '',
		
		//PhD
	
		'phd_leaving_country'      => $data['country_phd']?? '',
        'phd_leaving_board_name'   => $data['board_phd']?? '',
        'phd_leaving_university'    => $data['institute_phd']?? '',
        'phd_leaving_subjects'     => $data['subjects_phd']?? '',
        'phd_leaving_year'         => $data['year_phd']?? '',
        'phd_leaving_percentage'   => $data['percentage_phd']?? ''

    ];


        $this->db->where('uid', $userid);
        $this->db->update('iccr_student_education_details', $newdata);
		//echo $this->db->last_query();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        $this->db->select('*');
        $this->db->from('iccr_student_education_details');
        $this->db->where('uid', $userid);
        $row = $this->db->get()->result_array();

        if ($success >= 0){
            $this->db->delete('iccr_student_education_other_courses_details', array('education_details_id' => $row[0]['id']));

            foreach($this->input->post('other_course_country') as $key=>$occ){
                $clean['education_details_id'] = $row[0]['id'];
                $clean['other_course_country'] = $occ;
                $clean['other_course_university'] = $this->input->post('other_course_university')[$key];
                $clean['other_course'] = $this->input->post('other_course')[$key];
                $clean['other_course_year'] = $this->input->post('other_course_year')[$key];
                $clean['other_course_percentage'] = $this->input->post('other_course_percentage')[$key];

                $q = $this->db->insert_string('iccr_student_education_other_courses_details', $clean);
                $this->db->query($q);
            }
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function getOtherEducationDetail($userid) {
        $this->db->select('*');
        $this->db->from('iccr_student_education_other_courses_details');
        $this->db->where('education_details_id', $userid);
        return $this->db->get()->result_array();
    }



	    function updateSfsEducation($data, $userid) {
        $this->db->where('uid', $userid);
        $this->db->update('iccr_sfs_student_education_details', $data);
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
	
        $success = $this->db->affected_rows();
		
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    function getApplicationNoByUserId($userid) {
        $this->db->select('application_no');
        $this->db->from('iccr_student_application_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	 function getSfsApplicationNoByUserId($userid) {
        $this->db->select('application_no');
        $this->db->from('iccr_sfs_student_application_details');
        $this->db->where('uid', $userid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getApplicationDocuments($userid) {
        $this->db->select('*');
        $this->db->from('iccr_documents');
        $this->db->where('uid', $userid);
        $this->db->order_by('added_on', "DESC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getApplicationSfsDocuments($userid) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_documents');
        $this->db->where('uid', $userid);
        $this->db->order_by('added_on', "DESC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	

    function getUserIdbyApplicationNo($appno) {
        $this->db->select('uid');
        $this->db->from('iccr_student_education_details');
        $this->db->where('application_no', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getApplicationDocumentsbyAppNo($appno) {
        $this->db->select('*');
        $this->db->from('iccr_documents');
        $this->db->where('application_no', $appno);
        $this->db->order_by('added_on', "DESC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	  function getApplicationOtherDetailsbyAppNo($uid) {
        $this->db->select('*');
        $this->db->from('iccr_student_details');
        $this->db->where('uid', $uid);
        //$this->db->order_by('added_on', "DESC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    // function insertEducation($data) {
	// 	 unset($data['csrftestname']);
	// 	 unset($data['appno']);
    //     $q = $this->db->insert_string('iccr_student_education_details', $data);

    //     $this->db->query($q);
    //     $code = $this->db->error();
    //     if ($code['code'] > 0) {
    //         //show_error('Message');
    //     }
    //     return $this->db->insert_id();
    // }
	


    function insertEducation($data) {
        unset($data['csrftestname']);
        unset($data['appno']);
		$newdata = [

        // HIGH SCHOOL$data[
        'school_leaving_country_x'       => $data['country_secondary/high_school']?? '',
        'school_leaving_board_name_x'    => $data['board_secondary/high_school']?? '',
        'school_leaving_university_x'    => $data['institute_secondary/high_school']?? '',
        'school_leaving_subjects_x'      => $data['subjects_secondary/high_school']?? '',
        'school_leaving_year_x'          => $data['year_secondary/high_school']?? '',
        'school_leaving_percentage_x'    => $data['percentage_secondary/high_school']?? '',

        // INTERMEDIATE
        'school_leaving_country'      => $data['country_high_school/college']?? '',
        'school_leaving_board_name'   => $data['board_high_school/college']?? '',
        'school_leaving_university'   => $data['institute_high_school/college']?? '',
        'school_leaving_subjects'     => $data['subjects_high_school/college']?? '',
        'school_leaving_year'         => $data['year_high_school/college']?? '',
        'school_leaving_percentage'   => $data['percentage_high_school/college']?? '',

        // UNDERGRADUATE
        'ug_leaving_country'     => $data['country_undergraduate']?? '',
        'ug_leaving_board_name'  => $data['board_undergraduate']?? '',
        'ug_leaving_university'   => $data['institute_undergraduate']?? '',
        'ug_leaving_subjects'    => $data['subjects_undergraduate']?? '',
        'ug_leaving_year'        => $data['year_undergraduate']?? '',
        'ug_leaving_percentage'  => $data['percentage_undergraduate']?? '',
		

        // POSTGRADUATE
        'pg_leaving_country'      => $data['country_postgraduate']?? '',
        'pg_leaving_board_name'   => $data['board_postgraduate']?? '',
        'pg_leaving_university'    => $data['institute_postgraduate']?? '',
        'pg_leaving_subjects'     => $data['subjects_postgraduate']?? '',
        'pg_leaving_year'         => $data['year_postgraduate']?? '',
        'pg_leaving_percentage'   => $data['percentage_postgraduate']?? '',
		
		//PhD
	
		'phd_leaving_country'      => $data['country_phd']?? '',
        'phd_leaving_board_name'   => $data['board_phd']?? '',
        'phd_leaving_university'    => $data['institute_phd']?? '',
        'phd_leaving_subjects'     => $data['subjects_phd']?? '',
        'phd_leaving_year'         => $data['year_phd']?? '',
        'phd_leaving_percentage'   => $data['percentage_phd']?? '',
        'application_no'            => $data['application_no'] ?? '',
		'uid'            => $data['uid'] ?? ''
    ];

             
       $q = $this->db->insert_string('iccr_student_education_details', $newdata);
	   //echo $this->db->last_query();die;

       $this->db->query($q);
       $code = $this->db->error();
       if ($code['code'] > 0) {
           //show_error('Message');
       }
       $success = $this->db->insert_id();
       if ($success > 0){
           foreach($this->input->post('other_course_country') as $key=>$occ){
               $clean['education_details_id'] = $success;
               $clean['other_course_country'] = $occ;
               $clean['other_course_university'] = $this->input->post('other_course_university')[$key];
               $clean['other_course'] = $this->input->post('other_course')[$key];
               $clean['other_course_year'] = $this->input->post('other_course_year')[$key];
               $clean['other_course_percentage'] = $this->input->post('other_course_percentage')[$key];

               $q = $this->db->insert_string('iccr_student_education_other_courses_details', $clean);
               $this->db->query($q);
           }
           return TRUE;
       }
       else{
           return FALSE;
       }
       return $success;
   }



	function insertSfsEducation($data) {
		
        $q = $this->db->insert_string('iccr_sfs_student_education_details', $data);
        $this->db->query($q);
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
        return $this->db->insert_id();
    }

    function updateApplicationStepOne($data, $userid) {
		//echo "<pre>";print_r($data);die;
		
		unset($data['old_passport_file']); 
        $this->db->where('uid', $userid);

        $date_issue = $data['passport_issue_date'] . '-' . $data['passport_issue_month'] . '-' . $data['passport_issue_year'];
        $date_expiry = $data['passport_expiry_date'] . '-' . $data['passport_expiry_month'] . '-' . $data['passport_expiry_year'];
		unset($data['csrftestname']);
        unset($data['passport_issue_date']);
        unset($data['passport_issue_month']);
        unset($data['passport_issue_year']);
        unset($data['passport_expiry_date']);
        unset($data['passport_expiry_month']);
        unset($data['passport_expiry_year']);
		
        $data['passport_issue_date'] = $date_issue;
        $data['passport_expiry_date'] = $date_expiry;
		$data['created'] = date('Y-m-d h:i:s');
        $this->db->update('iccr_student_application_details', $data);
		//echo $this->db->last_query();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	
	function updateApplicationSfsStepOne($data, $userid) {
        $this->db->where('uid', $userid);

        $date_issue = $data['passport_issue_date'] . '-' . $data['passport_issue_month'] . '-' . $data['passport_issue_year'];
        $date_expiry = $data['passport_expiry_date'] . '-' . $data['passport_expiry_month'] . '-' . $data['passport_expiry_year'];

        unset($data['passport_issue_date']);
        unset($data['passport_issue_month']);
        unset($data['passport_issue_year']);
        unset($data['passport_expiry_date']);
        unset($data['passport_expiry_month']);
        unset($data['passport_expiry_year']);

        $data['passport_issue_date'] = $date_issue;
        $data['passport_expiry_date'] = $date_expiry;
		$data['created'] = date('Y-m-d h:i:s');
        $this->db->update('iccr_sfs_student_application_details', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

	function insertApplicationSfsStepOne($data) {
        $date_issue = $data['passport_issue_date'] . '-' . $data['passport_issue_month'] . '-' . $data['passport_issue_year'];
        $date_expiry = $data['passport_expiry_date'] . '-' . $data['passport_expiry_month'] . '-' . $data['passport_expiry_year'];

        unset($data['passport_issue_date']);
        unset($data['passport_issue_month']);
        unset($data['passport_issue_year']);
        unset($data['passport_expiry_date']);
        unset($data['passport_expiry_month']);
        unset($data['passport_expiry_year']);

        $data['passport_issue_date'] = $date_issue;
        $data['passport_expiry_date'] = $date_expiry;
		$data['created'] = date('Y-m-d h:i:s');
        $q = $this->db->insert_string('iccr_sfs_student_application_details', $data);
		//echo $q;die;
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }

    function insertApplicationStepOne($data) {
		//echo "---------";die;
        $date_issue = $data['passport_issue_date'] . '-' . $data['passport_issue_month'] . '-' . $data['passport_issue_year'];
        $date_expiry = $data['passport_expiry_date'] . '-' . $data['passport_expiry_month'] . '-' . $data['passport_expiry_year'];
		unset($data['csrftestname']);
		unset($data['appno']);
        unset($data['passport_issue_date']);
        unset($data['passport_issue_month']);
        unset($data['passport_issue_year']);
        unset($data['passport_expiry_date']);
        unset($data['passport_expiry_month']);
        unset($data['passport_expiry_year']);
		 unset($data['old_passport_file']);

        $data['passport_issue_date'] = $date_issue;
        $data['passport_expiry_date'] = $date_expiry;
		$data['created'] = date('Y-m-d h:i:s');
        $q = $this->db->insert_string('iccr_student_application_details', $data);
		//echo $q;die;
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }

    function insertUserImage($image, $userid) {
        $data = array(
            'name' => $image,
            'created' => date('y-m-d h:i:s a'),
            'status' => 1,
            'uid' => $userid
        );
        $q = $this->db->insert_string('iccr_profile_image', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	 function insertSfsUserImage($image, $userid) {
        $data = array(
            'name' => $image,
            'created' => date('y-m-d h:i:s a'),
            'status' => 1,
            'uid' => $userid
        );
        $q = $this->db->insert_string('iccr_sfs_profile_image', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	

    function uploadProfilePic($name, $userid) {
        $data = array(
            'name' => $name,
            'created' => date('y-m-d h:i:s a'),
            'status' => 1
        );
        $this->db->where('uid', $userid);
        $this->db->update('iccr_profile_image', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
//echo $this->db->last_query();die;
        if (!$success) {
            return false;
        }
        return TRUE;
    }
	
	    function uploadPassportPic($name, $userid) {
        $data = array(
            'passport_file' => $name          
        );
        $this->db->where('id', $userid);
        $this->db->update('iccr_users', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        if (!$success) {
            return false;
        }
        return TRUE;
    }
	
	 function uploadSfsProfilePic($name, $userid) {
        $data = array(
            'name' => $name,
            'created' => date('y-m-d h:i:s a'),
            'status' => 1
        );
        $this->db->where('uid', $userid);
        $this->db->update('iccr_sfs_profile_image', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        if (!$success) {
            return false;
        }
        return TRUE;
    }

    function updateProfile($post) {
        $data = array(
            'first_name' => $post['fullname'],
            'phone' => $post['mobile_number'],
            'email' => $post['useremail']
        );
        $this->db->where('id', $post['userid']);
        $this->db->update('users', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        if (!$success) {
            return false;
        }
        return TRUE;
    }

	 
	 function updateProfileUniversity($post,$universityId) {
        $data = array(
            'mobile_no' => $post['mobile_no'],
			'alternate_no' => $post['alternate_no'],
            'nodal_officer' => $post['nodal_officer'],
            'office_address' => $post['office_address'],
			'telephone_number' => $post['telephone_number'],
			'fax_number' => $post['fax_number'],
			
        );
		//echo $universityId;
		//echo "<pre>";print_r($data);die;
        $this->db->where('university', $universityId);
        $this->db->update('iccr_users', $data);
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
        $success = $this->db->affected_rows();

        if (!$success) {
            return false;
        }
        return TRUE;
    }
    function updateProfileAgent($post) {
        $data = array(
            'first_name' => $post['fullname'],
            'phone' => $post['mobile_number'],
            'company' => $post['company'],
            'ceano' => $post['cea_number']
        );
        $this->db->where('id', $post['userid']);
        $this->db->update('users', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        if (!$success) {
            return false;
        }
        return TRUE;
    }

    function insertFbUser($post) {
        try {
            $string = array(
                'username' => $post['email'],
                'first_name' => $post['name'],
                'email' => $post['email'],
                'phone' => $post['mobile'],
                'role' => $this->roles[0],
                'password' => "",
                'user_type' => $post['user_type'],
                'status' => $this->status[1],
                'facebookid' => $post['fbid']
            );
            $q = $this->db->insert_string('users', $string);
            $this->db->query($q);
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $this->db->insert_id();
        } catch (Exception $e) {
            return 0;
        }
    }

    function updateUserImage($post) {
        $data = array(
            'image' => $post['image']
        );
        $this->db->where('userid', $post['userid']);
        $this->db->update('user_profile_image', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        if (!$success) {
            return false;
        }
        return TRUE;
    }

    public function insertUserFromMobile($d) {
        $string = array(
            'username' => $d['username'],
            'first_name' => $d['firstname'],
            'email' => $d['email'],
            'phone' => $d['phone'],
            'role' => $this->roles[0],
            'password' => md5($d['password']),
            'user_type' => $d['user_type'],
            'status' => $this->status[1]
        );
        $q = $this->db->insert_string('users', $string);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $this->db->query($q);
        return $this->db->insert_id();
    }

    function insertStudentDetails($d) {
        $string = array(
            'country_of_domicile' => $d['country'],
            'gender' => $d['gender'],
            'date_of_birth' => $d['dob'],
            'mobile_number' => $d['mobile_no'],
            'currently_in_india' => $d['isindian'],
            
            'created' => date('Y-m-d h:i:s'),
            'uid' => $d['uid']
        );
        $q = $this->db->insert_string('iccr_student_details', $string);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $this->db->query($q);
        return $this->db->insert_id();
    }

    public function insertRegion_User($string) {
        try {
            $q = $this->db->insert_string('iccr_users', $string);
            $this->db->query($q);
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $this->db->insert_id();
        } catch (Exception $e) {
            return false;
        }
    }

    public function insertUser($d) {
        try {
            //echo "<pre>";print_r($d);die;
            $string = array(
                'username' => $d['username'],
                'email_id' => $d['emailId'],
                'password' => md5($d['password']),
                'user_type' => 1,
                'status' => 0,
                'created' => date('Y-m-d h:i:s'),
                'state' => 0
            );

            $q = $this->db->insert_string('iccr_users', $string);
            $this->db->query($q);
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $this->db->insert_id();
        } catch (Exception $e) {
            return false;
        }
    }

    public function isDuplicate($email) {
        $this->db->get_where('iccr_users', array('email_id' => $email), 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    public function isDuplicateFb($fbid) {
        $this->db->get_where('users', array('facebookid' => $fbid), 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    public function insertToken($user_id) {
        $token = substr(sha1(rand()), 0, 30);
        $date = date('Y-m-d');
        $string = array(
            'token' => $token,
            'user_id' => $user_id,
            'created' => $date
        );
        $query = $this->db->insert_string('iccr_tokens', $string);

        $this->db->query($query);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $token . $user_id;
    }

    public function isTokenValid($token) {
        $tkn = substr($token, 0, 30);
        $uid = substr($token, 30);

        $q = $this->db->get_where('iccr_tokens', array(
            'iccr_tokens.token' => $tkn,
            'iccr_tokens.user_id' => $uid), 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();

            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d');
            $todayTS = strtotime($today);

            if ($createdTS != $todayTS) {
                return false;
            }

            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
        } else {
            return false;
        }
    }

    public function updatePassword($post) {
        $data = array(
            'password' => $post['password']
        );
        $this->db->where('id', $post['user_id']);
        $this->db->update('users', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        if (!$success) {
            error_log('Unable to updateUserInfo(' . $post['user_id'] . ')');
            return false;
        }

        $user_info = $this->getUserInfo($post['user_id']);
        return $user_info;
    }

    public function holdApplication($appid) {
        $data = array(
            'status' => 3
        );
        $this->db->where('application_no', $appid);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if (!$success) {
            return false;
        }
        return TRUE;
    }
	
	function getmappingDataforHqrsbyUniversityId($appno,$universityId) {
        $this->db->select('iccr_university_status_mapping.*');
        $this->db->from('iccr_university_status_mapping');
        $this->db->where(array('application_id' => $appno));
		$this->db->where(array('regional_university' => $universityId));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	public function holdApplicationByUniversity($appid,$universityId) {
        $data = array(
            'status' => 3
        );
        $this->db->where('application_id', $appid);
		$this->db->where('regional_university', $universityId);
        $this->db->update('iccr_university_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if (!$success) {
            return false;
        }
        return TRUE;
    }
	public function holdApplicationByUniversitydummy($appid) {
        $data = array(
            'status' => 3
        );
        $this->db->where('application_no', $appid);
        $this->db->update('iccr_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if (!$success) {
            return false;
        }
        return TRUE;
    }
    public function getUserData($userId) {
        $this->db->select('iccr_users.*,iccr_student_details.*');
		$this->db->from('iccr_users');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid=iccr_users.id');
        $this->db->where('iccr_users.id', $userId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();die;
        return $this->db->get()->result_array();
    }
	
	public function getUniversityUserData($universityId) {
        $this->db->select('*');
		$this->db->from('iccr_users');
        $this->db->where('iccr_users.university', $universityId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();die;
        return $this->db->get()->result_array();
    }
	 public function getSfsUserData($userId) {
        $this->db->select('iccr_sfs_users.*,iccr_sfs_student_details.*');
        $this->db->from('iccr_sfs_users');
	    $this->db->join('iccr_sfs_student_details', 'iccr_sfs_student_details.uid=iccr_sfs_users.id');
        $this->db->where('iccr_sfs_users.id', $userId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();die;
        return $this->db->get()->result_array();
    }

    public function updateUserInfo($post) {
        $data = array(
            'password' => $post['password'],
            'last_login' => date('Y-m-d h:i:s A'),
            'status' => $this->status[1]
        );
        $this->db->where('id', $post['user_id']);
        $this->db->update('iccr_users', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();

        if ($success < 0) {
            error_log('Unable to updateUserInfo(' . $post['user_id'] . ')');
            return false;
        }

        $user_info = $this->getUserInfo($post['user_id']);
        return $user_info;
    }

    function updateUserProfile($post) {
        try {
            $string = array(
                'first_name' => $post['name'],
                'email' => $post['email'],
                'phone' => $post['mobile'],
                'user_profile_image' => $post['user_image']
            );
            $this->db->where('id', $post['user_id']);
            $q = $this->db->update('users', $string);
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            $success = $this->db->affected_rows($q);

            if (!$success) {
                //error_log('Unable to update User Profile');
                return FALSE;
            }
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    function updateUserRegistration($post) {
        try {
            $string = array(
                'username' => $post['phone'],
                'first_name' => $post['firstname'],
                'email' => $post['email'],
                'phone' => $post['phone'],
                'role' => $this->roles[0],
                'password' => "",
                'user_type' => $post['user_type'],
                'status' => $this->status[1]
            );
            $q = $this->db->insert_string('users', $string);
            $this->db->query($q);
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            $id = $this->db->insert_id();
            if ($id <= 0) {
                error_log('Unable to updateUserRegistration()');
                return FALSE;
            }
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    function checkFbLogin($post) {
        $fbid = $post['fbid'];
        $condition = array("facebookid" => $fbid, "status" => "1");
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($condition);
        $rs = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($rs->num_rows() > 0) {
            $row = $rs->row();
            $datas = array(
                'userid' => $row->id,
                'fname' => $row->first_name,
                'email' => $row->email,
                'user_type' => $row->user_type,
                'user_image' => $row->user_profile_image,
                'phone' => $row->phone,
                'facebookid' => $row->facebookid
            );
            $this->session->set_userdata('user_data', $datas);
            return true;
        } else {
            $this->session->set_flashdata('loginerror', '<div class="error" style="color:red;">Please enter valid login/password</div>');
            return false;
        }
    }

    function ApplicationForwardFromHeadquarter($appno) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', array('status' => 7));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return FALSE;
        }
        return;
    }

    function ApplicationForwardFromMission($appno) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_status_mapping', array('status' => 2));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return FALSE;
        }
        return;
    }

    public function checkUsersLogin($data) {
        $email = $data['username'];
        $encrypt_password = md5(trim($data['pass']));
        $condition = array("email_id" => $email, "status" => "1", "password" => $encrypt_password);
        $this->db->select('*');
        $this->db->from('iccr_allusers');
        $this->db->where($condition);
        $rs = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row;
        } else {
            return false;
        }
    }

    public function checkLogin($data) {
        $email = $data['username'];
        $encrypt_password = md5(trim($data['pass']));
        $condition = array("email_id" => $email, "status" => "1", "password" => $encrypt_password);
        $this->db->select('*');
        $this->db->from('iccr_users');
        $this->db->where($condition);
        $rs = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row;
        } else {
            return false;
        }
    }

    public function checkLoginmobile($data) {
        $phone = $data['mobile'];
        $condition = array("username" => $phone);
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($condition);
        $rs = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($rs->num_rows() > 0) {
            $row = $rs->row();
            $datas = array(
                'userid' => $row->id,
                'fname' => $row->first_name,
                'email' => $row->email,
                'user_type' => $row->user_type
            );
            $this->session->set_userdata('user_data', $datas);
            return TRUE;
        } else {
            /* $string = array(
              'username'=>$phone,
              'first_name'=>"",
              'email'=>"",
              'phone'=>$phone,
              'role'=>$this->roles[0],
              'password'=>"",
              'status'=>$this->status[0]
              );
              $q = $this->db->insert_string('users',$string);

              $this->db->query($q);
              $this->db->insert_id(); */
            return FALSE;
        }
    }

    public function updateLoginTime($id) {
        $this->db->where('id', $id);
        $this->db->update('users', array('last_login' => date('Y-m-d h:i:s A')));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return;
    }

    public function getUserInfoByEmail($email) {
        $q = $this->db->get_where('users', array('email' => $email), 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $email . ')');
            return false;
        }
    }

    function getUserInfoByFbId($id) {
        $q = $this->db->get_where('users', array('facebookid' => $id), 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return false;
        }
    }

    public function getUserInfo($id) {
        $q = $this->db->get_where('iccr_users', array('id' => $id), 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return false;
        }
    }
	public function getDirUserInfo($id) {
        $q = $this->db->get_where('iccr_users', array('id' => $id), 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return false;
        }
    }

    public function getUserInfoById($id) {
        try {
            $q = $this->db->get_where('iccr_users', array('id' => $id), 1);
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            if ($this->db->affected_rows() > 0) {
                $row = $q->row();
                return $row;
            } else {
                return array();
            }
        } catch (Exception $e) {
            
        }
    }

    function alreadyApprovedUniversity($appId) {
        try {
            $this->db->select('region_one_status');
            $this->db->from('iccr_university_response');
            $this->db->where(array('application_id' => $appId, 'university_is_accept' => 1));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }

    function getAYUSHUnivercities() {
        try {
            $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_states.name,iccr_states.id as stateid,iccr_univercities.state_id,iccr_univercities.link,iccr_univercities.title');

            $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
            $this->db->from('iccr_univercities');
            $this->db->where('iccr_univercities.university_type', 8);
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
function isAyurvedaApplication($appId) {
        $this->db->select('iccr_university_response_by_hqrs.*');
        $this->db->from('iccr_university_response_by_hqrs');
        $this->db->where(array('iccr_university_response_by_hqrs.application_id' => $appId));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function getAllUnivercities() {
        try {
            $this->db->select('iccr_univercities.id,iccr_univercities.name,iccr_univercities.state');

            $this->db->from('iccr_univercities');
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }

    function getUnivercities() {
        try {
            $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_states.name,iccr_states.id as stateid,iccr_univercities.state_id');
            $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
            $this->db->from('iccr_univercities');
            $this->db->where('university_type', 6);
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }

    function getCourseByPrgrammeAndType($id, $type) {
       
        try {
            $this->db->select('id,title,has_stream');
            $this->db->from('iccr_courses');
            $this->db->where('prg_id', $id);
            $this->db->where('status',1);
			
            if ($type > 0) {
                $this->db->where('course_id', $type);
				
            }
            $this->db->order_by('title', "ASC");
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
            }
           


            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }

function getuniversitiesall() {
       
			 try {
						$this->db->select('*');
						$this->db->from('iccr_univercities');
						$this->db->where('status', '1');
						$result = $this->db->get();
						$code = $this->db->error();
						//echo $this->db->last_query();die;
						return $result->result_array();
					} catch (Exception $e) {
						
					}
    }

    function getnomenclature() {
       
			 try {
						$this->db->select('*');
						$this->db->from('iccr_nomenclature');
						$this->db->where('status', '1');
						$result = $this->db->get();
						$code = $this->db->error();
						//echo $this->db->last_query();die;
						return $result->result_array();
					} catch (Exception $e) {
						
					}
    }
    function getnomenclatureByType($type,$id) {
       
			 try {
						$this->db->select('iccr_nomenclature.id,iccr_nomenclature.title');
						$this->db->join('iccr_university_mapping', 'iccr_nomenclature.id = iccr_university_mapping.nomenclature_id');
						$this->db->from('iccr_nomenclature');
						$this->db->where('iccr_university_mapping.course_type', $type);
						$this->db->where('iccr_university_mapping.programme_id', $id);
						$this->db->where('iccr_university_mapping.view', '1');
						$this->db->group_by(array('iccr_nomenclature.id','iccr_nomenclature.title'));
						$result = $this->db->get();
						$code = $this->db->error();
						//echo $this->db->last_query();die;
						return $result->result_array();
					} catch (Exception $e) {
						
					}
    }
	
	    function getnomenclatureByid($id) {
       
			 try {
						$this->db->select('iccr_nomenclature.title');						
						$this->db->from('iccr_nomenclature');
						$this->db->where('iccr_nomenclature.id', $id);						
						$result = $this->db->get();
						$code = $this->db->error();
						//echo $this->db->last_query();die;
						return $result->result_array();
					} catch (Exception $e) {
						
					}
    }
	
	    function getuniversityBynomen($nomen,$type){
       
			 try {
						$this->db->select('iccr_univercities.id,iccr_univercities.title');
						$this->db->join('iccr_university_mapping', 'iccr_univercities.id = iccr_university_mapping.university_id');
						$this->db->from('iccr_univercities');
						$this->db->where('iccr_university_mapping.nomenclature_id', $nomen);
						$this->db->where('iccr_university_mapping.course_type', $type);
						$this->db->order_by("iccr_univercities.priority",'DESC');
						$this->db->order_by("iccr_univercities.title",'ASC');
						$result = $this->db->get();
						$code = $this->db->error();
						///echo $this->db->last_query();die;
						return $result->result_array();
					} catch (Exception $e) {
						
					}
    }
    // function getSubjectByTypeAndCourse($id) {
       
    //     try {
    //         $this->db->select('id,subject');
    //         $this->db->from('iccr_subjects');
    //         $this->db->where('sub_stream', $id);
			
    //         $this->db->order_by('subject', "ASC");
    //         $result = $this->db->get();
    //         $code = $this->db->error();
    //         if ($code['code'] > 0) {
    //         }
           
    //         return $result->result_array();
    //     } catch (Exception $e) {
            
    //     }
    // }

    function getCourseByPrgramme($id) {
        try {
            $this->db->select('id,title');
            $this->db->from('iccr_courses');
            $this->db->where('prg_id', $id);
            $this->db->order_by('title', "ASC");
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	
	  
	    function getStreamIdByCourseId($university_id,$programme,$course_type,$course) {
        try {
			
            $this->db->select('*');
            $this->db->from('iccr_stream');
			//$this->db->join('iccr_stream_page', 'iccr_stream_page.course_id = iccr_stream.course_id');
			$this->db->where(array('iccr_stream.university_id' => $university_id, 'iccr_stream.programme_id' => $programme,'iccr_stream.course_type_id' => $course_type,'iccr_stream.course_id' => $course,));
			$this->db->where('iccr_stream.course_id', $course);
			$this->db->order_by('iccr_stream.name', 'ASC');
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	
	
	function getCourseById($id) {
        try {
            $this->db->select('id,title');
            $this->db->from('iccr_courses');
			$this->db->where('id',$id);
            $this->db->order_by('id', "ASC");
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	
	function getStreamById($id) {
        try {
            $this->db->select('id,name');
            $this->db->from('iccr_stream');
			$this->db->where('id',$id);
            $this->db->order_by('id', "ASC");
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }

    function getVisaData($appno) {
        $this->db->select('visa_from_date,visa_to_date');
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	function getVisaDataRo($appno) {
        $this->db->select('visa_from_date,visa_to_date');
        $this->db->from('iccr_regional_VISAInfo');
        $this->db->where('application_no', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
    function getMappingData($appno) {
        $this->db->select('joining_date,completion_date,scholarship_id,regional_university,university_is_accept,region_forward_mission_status,region_one_doc,region_one_status_date,region_one_status,travel_arrival_date,status,scholar_acceptance,mission_status,mission_status_date,mission_person_name,mission_person_designation,mission_person_place,mission_person_signature,english_proficiency_test_marks,visa_from_date,visa_to_date,visa_issueplace,visa_approved,visa_no,visa_isuue_date,undertaking_doc,visa_grant_permission,application_no,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.medical_fitness');
		
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        //echo $this->db->_compile_select();die;
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
    function getRegionalResponseData($appno) {
        $this->db->select('regional_university');
		
        $this->db->from('iccr_university_status_mapping');
        $this->db->where('application_no', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        //echo $this->db->_compile_select();die;
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
    

	 function getMappingDataResponse($appno) {
        $this->db->select('joining_date,completion_date,iccr_university_response.application_id,iccr_status_mapping.scholarship_id,iccr_university_response.regional_university,iccr_university_response.university_is_accept,iccr_university_response.region_one_doc,iccr_university_response.region_one_status_date,iccr_university_response.region_one_status,travel_arrival_date,iccr_status_mapping.status,iccr_status_mapping.mission_status,mission_status_date,mission_person_name,mission_person_designation,mission_person_place,mission_person_signature,english_proficiency_test_marks,visa_from_date,visa_to_date,visa_no,visa_isuue_date,undertaking_doc,visa_grant_permission,application_no,iccr_status_mapping.scholar_acceptance,iccr_university_response.scholar_acceptance as rspo_scholar_acceptance,iccr_status_mapping.medical_fitness');
		$this->db->from('iccr_status_mapping');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_status_mapping.application_no', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
    
	 function getApplicationAppnoByUserId($userId) {
        $this->db->select('application_no');
        $this->db->from('iccr_status_mapping');
        $this->db->where('uid', $userId);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
    function getJoiningDoc($appno) {
        $this->db->select('joining_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	   function getCourseTypesSfs($pid=null) {
        $this->db->select('id,course_type');
        $this->db->from('iccr_course_type');
		if(!empty($pid) && ($pid == 1 || $pid == 2))
		{
			 $this->db->where('id', 1);
		}else
		{
			 $this->db->where_not_in('id', 1);
			 //$this->db->where_not_in('id', 7);
		}
        $result = $this->db->get();
        return $result->result_array();
    }
      /* function getCourseTypes($pid=null) {
        $this->db->select('id,course_type');
        $this->db->from('iccr_course_type');
		if(!empty($pid) && ($pid == 1 || $pid == 2))
		{
			 $this->db->where('id', 1);
		}else
		{
			 $this->db->where_not_in('id', 1);
			 $this->db->where_not_in('id', 7);
             $this->db->where_not_in('id', 5);
			 $this->db->where_not_in('id', 8);
             $this->db->where_not_in('id', 9);
		}
		$this->db->where('status', 1);
        $this->db->order_by("course_type", "asc");
        $result = $this->db->get();
        return $result->result_array();
    }*/
	
	function getCourseTypes($pid=null) {
        $this->db->select('id,course_type');
        $this->db->from('iccr_course_type');
		$this->db->where('status', 1);
        $this->db->order_by("course_type", "asc");
        $result = $this->db->get();
        return $result->result_array();
    }    
    function getCourseTypesDiploma($pid=null) {
        $this->db->select('id,course_type');
        $this->db->from('iccr_course_type');
		$this->db->where_in('id', ['3','17']);
		$this->db->where('status', 1);
        $this->db->order_by("course_type", "asc");
        $result = $this->db->get();
        return $result->result_array();
    }

    function getCoursesById($id) {
        try {
            $this->db->select('id,title,has_stream');
            $this->db->from('iccr_courses');
            $this->db->where('id', $id);
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }

    function getAllCourses() {
        try {
            $this->db->select('id,title');
            $this->db->from('iccr_courses');
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }

    function getSelectedUnvercities($id = null, $id1 = null,$id2 = null,$id3 = null) {
        try {

            $this->db->select('id,name,state');
            $this->db->from('iccr_univercities');
            if ($id > 0)
                $this->db->where_not_in('id', $id);
            if ($id1 > 0)
                $this->db->where_not_in('id', $id1);
			if ($id1 > 0)
                $this->db->where_not_in('id', $id2);
			if ($id1 > 0)
                $this->db->where_not_in('id', $id3);
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
    
    function getProgrammeById($Id) {
        try {
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
            $this->db->where('id', $Id);
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }

    function getAllProgramme() {
        try {
            $this->db->select('id,name');
            $this->db->from('iccr_programme');

            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	  function getAllPhdProgramme() {
        try {
			
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
			$this->db->where_in('id', array('1','2','4','8'));
			//$this->db->where_in('id', array('4'));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	function getAllPhdProgramme8() {
        try {
			
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
			$this->db->where_in('id', array('8'));
			//$this->db->where_in('id', array('4'));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	function getAllSfsProgramme() {
        try {
			
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
			$this->db->where_in('id', array('1','2','4'));
			//$this->db->where_in('id', array('4'));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	function getAllProgrammeWithoutAyush($prgid) {
        try {
			
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
			$this->db->where_in('id', $prgid);
			//$this->db->where_in('id', array('4'));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
function getAllProgrammeGuruDance() {
        try {
			
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
			$this->db->where_in('id', array('5','6'));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
    
    function getAllCertificate() {
        try {
			
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
			$this->db->where_in('id', array('13'));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
    
    function getAllDiploma() {
        try {
			
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
			$this->db->where_in('id', array('12'));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
    function updateOldExpenditure($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_old_student_expenditure', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($this->db->affected_rows() >= 0) {
            return TRUE;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return FALSE;
        }
        return;
    }

    public function insertOldExpenditure($post) {
        $q = $this->db->insert_string('iccr_old_student_expenditure', $post);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }

    public function updateExpenditureOldDetails($data) {
        $this->db->where('application_id', $data['application_id']);
        $this->db->update('iccr_student_expenditure', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }

    public function insertExpenditure($post) {

        $q = $this->db->insert_string('iccr_student_expenditure', $post);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }

    public function getExpeditureData($applicationId = null) {
        $this->db->select('*');
        $this->db->from('iccr_student_expenditure');
        $this->db->where('application_id', $applicationId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    public function checkPasswordUpdatedCount($token) {
        $this->db->select('id,pass_updated_count');
        $this->db->from('iccr_users');
        $this->db->where('token', $token);
        return $this->db->get()->result_array();
    }

    public function does_code_match($code, $email) {
        $this->db->where('email_id', $email);
        $this->db->where('token', $code);
        $this->db->from('iccr_users');
        $num_res = $this->db->count_all_results();

        if ($num_res == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_user($data, $email) {
        $this->db->where('email_id', $email);
        $this->db->update('iccr_users', $data);
        $success = $this->db->affected_rows();
        if ($success) {

            return true;
        } else {

            return false;
        }
    }

    function getAllSchemess() {
        $this->db->select('id,scheme_name,code');
        $this->db->from('iccr_schemes');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getStudentOtherDetails($appid) {
        $this->db->select('application_through,mission_made_through');
        $this->db->from('iccr_student_other_details');
        $this->db->where('application_no', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    
   function getUniversityResponseSentByHqrsToMission1($data) {
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.iccr_status_date,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.gender,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.region_one_doc,iccr_university_response.course,iccr_university_response.course,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
        $this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		//$this->db->order_by('str_to_date('iccr_status_mapping.iccr_status_date', '%d-%b-%Y')','ASC');
		echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->get()->result_array();
    }
	
  
	 function getUniversityResponseSentByHqrsToMission10($data) {
      $sql = "SELECT DISTINCT `iccr_status_mapping`.`status`, `iccr_status_mapping`.`iccr_status_date`, `iccr_student_application_details`.`application_no`, `iccr_student_other_details`.`created`, `iccr_student_application_details`.`gender`, `iccr_student_application_details`.`fullname`, `iccr_student_application_details`.`email`, `iccr_countries`.`country_name`, `iccr_status_mapping`.`ref_no`, `iccr_student_application_details`.`universty_choice`, `iccr_student_application_details`.`universty_choice_two`, `iccr_student_application_details`.`universty_choice_three`, `iccr_student_application_details`.`university_choice_one_state`, `iccr_student_application_details`.`university_choice_two_state`, `iccr_student_application_details`.`university_choice_three_state`, `iccr_status_mapping`.`region_one_status`, `iccr_status_mapping`.`university_status`, `iccr_status_mapping`.`region_one_doc`, `iccr_status_mapping`.`university_is_accept`, `iccr_student_application_details`.`course`, `iccr_status_mapping`.`scholarship_id`, `iccr_university_response`.`region_one_doc`, `iccr_university_response`.`course`, `iccr_university_response`.`course`, `iccr_university_response`.`region_one_status_date` FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
	  JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`uid` = `iccr_status_mapping`.`uid` JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id` JOIN `iccr_university_response` ON `iccr_university_response`.`application_id` = `iccr_status_mapping`.`application_no` WHERE `iccr_status_mapping`.`status` >= 10 AND `iccr_status_mapping`.`iccr_status` = 1 AND `iccr_student_other_details`.`created` >= 1544832000 AND `iccr_student_other_details`.`created` <= 1574055292 ";

        return $this->db->query($sql)->result_array();
    }
	
	
		 function getUniversityResponseSentByHqrsToMission5($data) {
      $sql = "SELECT DISTINCT `iccr_status_mapping`.`status`, `iccr_status_mapping`.`iccr_status_date`, `iccr_student_application_details`.`application_no`, `iccr_student_other_details`.`created`, `iccr_student_application_details`.`gender`, `iccr_student_application_details`.`fullname`, `iccr_student_application_details`.`email`, `iccr_countries`.`country_name`, `iccr_status_mapping`.`ref_no`, `iccr_student_application_details`.`universty_choice`, `iccr_student_application_details`.`universty_choice_two`, `iccr_student_application_details`.`universty_choice_three`, `iccr_student_application_details`.`university_choice_one_state`, `iccr_student_application_details`.`university_choice_two_state`, `iccr_student_application_details`.`university_choice_three_state`, `iccr_status_mapping`.`region_one_status`, `iccr_status_mapping`.`university_status`, `iccr_status_mapping`.`region_one_doc`, `iccr_status_mapping`.`university_is_accept`, `iccr_student_application_details`.`course`, `iccr_status_mapping`.`scholarship_id`, `iccr_university_response`.`region_one_doc`, `iccr_university_response`.`course`, `iccr_university_response`.`course`, `iccr_university_response`.`region_one_status_date` FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
	  JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`uid` = `iccr_status_mapping`.`uid` JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id` JOIN `iccr_university_response` ON `iccr_university_response`.`application_id` = `iccr_status_mapping`.`application_no` WHERE `iccr_status_mapping`.`status` >= 10 AND `iccr_status_mapping`.`iccr_status` = 1 AND `iccr_student_other_details`.`created` <= 1544832000";

        return $this->db->query($sql)->result_array();
    }
    function getUniversityResponseSentByHqrsToMission($data) {
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.undertaking_doc,iccr_status_mapping.iccr_status_date,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.gender,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.region_one_doc,iccr_university_response.course,iccr_university_response.course,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		
		//$this->db->where(array('iccr_status_mapping.status=' => 11));
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
		$this->db->where(array('iccr_status_mapping.status!=' => 15));
		//cooment by vipin below line
		//$this->db->where(array('iccr_status_mapping.region_forward_mission_status!=' => 18));
		//$this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
        $this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		//$this->db->order_by('str_to_date('iccr_status_mapping.iccr_status_date', '%d-%b-%Y')','ASC');
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->get()->result_array();
    }
	
	
	
      function getCountUniversityResponseSentByHqrsToMission1() {
        $status = '10';
        $iccr_status = '1';
        $this->db->distinct();
        $this->db->select('iccr_student_application_details.application_no');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => $status));
        $this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
     
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
   
        return $this->db->count_all_results();
    }
    function getTotalCountReport($ids)
    {
		$sql = "Select (SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping` WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.")) as totalCount,
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` 
 Where iccr_status_mapping.scholarship_id IN(".$ids.") AND  iccr_university_response.university_is_accept=1) as totalAccepted,
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` 
 Where iccr_status_mapping.scholarship_id IN(".$ids.") AND  iccr_university_response.university_is_accept=2) as totalRejected,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.gender=1) as totalMale,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.gender=2) as totalFemale,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.programme=1) as totalUG,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.programme=2) as totalPG,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.programme=3) as totalMphil,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.programme=4) as totalPHD,
(SELECT count(iccr_university_response.id) FROM iccr_university_response JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id JOIN iccr_travelplan ON iccr_travelplan.application_id = iccr_university_response.application_id Where iccr_status_mapping.scholarship_id IN(".$ids.") AND iccr_travelplan.status=14 AND iccr_university_response.university_is_accept=1) as totalAdmitted";
//echo $sql;
      return $this->db->query($sql)->result_array();
     
	}
    function getTotalApplicantStatusReport($schema_id='') {
        $this->db->select('iccr_scheme.scheme_name,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_university_response.university_is_accept');
        $this->db->from('iccr_university_response');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_university_response.application_id');
        $this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_university_response.application_id');
        $this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_status_mapping.scholarship_id');
        $this->db->where(array('iccr_university_response.university_is_accept IN (1,2)'));
        $this->db->where_in(array('iccr_status_mapping.scholarship_id'=>$scheme_id));       
      // echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->get()->result_array();
    }
	
	//=============================Added by Rahul Dey 24-01-2019=============================
	function getAllFeedback() {
        $this->db->select('id,name,emailid,mobile_no,comment');
        $this->db->from('iccr_feedback');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	  function deleteFeedback($id) {
        $this->db->where('id', $id);
        $this->db->delete('iccr_feedback');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->affected_rows();
    }
	
	function getAllPages($page_slug=null,$page_title=null)
	{		
		$this->db->select('*');
		if(!empty($page_slug)){
		$this->db->where('page_slug', $page_slug);	
		}
		if(!empty($page_title)){
		$this->db->like('page_title', $page_title);	
		}
        $this->db->from('iccr_page');
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}
	
	function getUniversityPages($page_slug=null,$page_title=null,$universityId)
	{	
		$this->db->select('*');
		if(!empty($page_slug)){
		$this->db->where('page_slug', $page_slug);	
		}
		if(!empty($page_title)){
		$this->db->like('page_title', $page_title);	
		}
        $this->db->from('iccr_page');
		// $this->db->where('user_id',$universityId);
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}
	
	
	function getFrontPage($page_master_category=null)
	{
		
		$this->db->select('*');     
        $this->db->from('iccr_page');
		$this->db->where(array('iccr_page.status'=>1,'iccr_page.master_page_id'=>$page_master_category));  
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}
	
	function getProgrammePage($page_master_category=null,$universityId)
	{
		
		$this->db->select('*');     
        $this->db->from('iccr_programme_page');
		$this->db->where(array('iccr_programme_page.status'=>1,'iccr_programme_page.master_page_id'=>$page_master_category,'user_id'=>$universityId));  
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}
	
	function getCoursePage($page_master_category=null,$universityId)
	{
		
		$this->db->select('*');     
        $this->db->from('iccr_course_page');
		$this->db->where(array('iccr_course_page.status'=>1,'iccr_course_page.master_page_id'=>$page_master_category,'user_id'=>$universityId));  
		//echo $this->db->_compile_select();exit;
		$this->db->group_by('programme_id','ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}
		function getStreamPage($page_master_category=null,$universityId)
	{
		
		$this->db->select('*');     
        $this->db->from('iccr_stream_page');
		$this->db->where(array('iccr_stream_page.status'=>1,'iccr_stream_page.master_page_id'=>$page_master_category,'user_id'=>$universityId));  
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}
	
	 function changeStatus($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('iccr_page', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
	 }
	 
	 function getIndividualUniversities($id) {
		
        $this->db->select('iccr_univercities.*,iccr_regions.name as statename,iccr_states.name as stname');
        $this->db->from('iccr_univercities');
		$this->db->where(array('iccr_univercities.id'=>$id));  
        $this->db->join('iccr_regions', 'iccr_univercities.state = iccr_regions.id');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id', 'left');
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 
	//==============================END============================ 
	 //vipin(all count functions)
	 
	
 function getCountMissionApplications($missionId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		$this->db->where('iccr_student_application_details.course_year', NULL);	
		
        //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function getCountTwentyTwoMissionApplications($missionId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		$this->db->where('iccr_student_application_details.course_year', NULL);	
		
        //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }

    function getCountTwentyTwoMissionApplications2324($missionId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1));
        // $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
        $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
        $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where('iccr_student_application_details.course_year', NULL); 
        
        //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }

    function getCountTwentyTwoMissionApplications2425($missionId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1));
        // $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
        $this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
        $this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where('iccr_student_application_details.course_year', NULL); 
        
        //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }

    function getCountTwentyTwoMissionApplications2526($missionId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1));
        // $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
        $this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
        $this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where('iccr_student_application_details.course_year', NULL); 
        
        //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }

	function countpending_applications($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 2));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function countresubmitapplication($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 6));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	 function counthold_applications($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 3));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
       $countRowQuery = $this->db->count_all_results();
       return $countRowQuery;
    }
	
	
	    function countgetMissionsProcessedApplications($missionid) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
        $this->db->where('iccr_status_mapping.status', 10);
		$this->db->where('iccr_status_mapping.mission_status', 1);
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function countgetMissionsProcessedApplications25($missionid) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
        $this->db->where('iccr_status_mapping.status', 10);
		$this->db->where('iccr_status_mapping.mission_status', 1);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->where(array('iccr_status_mapping.created >=' => 1735689600));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	  function countgetConfirmationofHqrs($missionId) {
        // Used in Mission Controller
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 10));
        $this->db->where_in('iccr_university_response.university_is_accept', array(1, 2));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	  function countgetConfirmationofFourthOptionByHqrs($missionId) {
		//echo "<pre>";print_r($missionId);die;
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 10));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function countgetAcceptedCandidates($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where_in('iccr_status_mapping.status', array(11, 13));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function countgetConfirmationofCandidates($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where(array('iccr_status_mapping.status >' => 10));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		

        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function countgetConfirmationofCandidates2025($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where(array('iccr_status_mapping.status >' => 10));
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->where(array('iccr_status_mapping.created >='=> 1744184668));

        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function countgetVisaConveyedApplicatgion($missionId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where_in('iccr_status_mapping.status', array(13, -14));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	
function getMissionApplication($nowtime){
$sql = "SELECT count(DISTINCT(`iccr_university_status_mapping`.`application_id`)) as Total,`iccr_countries`.`country_name` as Country
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
JOIN `iccr_university_status_mapping` ON `iccr_university_status_mapping`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_univercities` ON `iccr_univercities`.`id` = `iccr_university_status_mapping`.`regional_university`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
WHERE `iccr_status_mapping`.`status` >= 1 and `iccr_status_mapping`.`status` != 5 AND `iccr_univercities`.`status`= 1 AND `iccr_status_mapping`.`status` != 6 AND `iccr_status_mapping`.`status` != 15 AND `iccr_status_mapping`.`created` >= 1615749687 group by iccr_countries.country_name";
return $this->db->query($sql)->result_array();
		
	}
	
	
	
	
	
	function getCountryWiseMissionApplication(){
$sql = "SELECT count(DISTINCT(`iccr_university_status_mapping`.`application_id`)) as Total,`iccr_countries`.`country_name` as Country
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
JOIN `iccr_university_status_mapping` ON `iccr_university_status_mapping`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_univercities` ON `iccr_univercities`.`id` = `iccr_university_status_mapping`.`regional_university`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_univercities`.`status`= 1 AND `iccr_status_mapping`.`status` != 15 AND `iccr_status_mapping`.`created` >= 1615749687 group by iccr_countries.country_name";
return $this->db->query($sql)->result_array();
		
	}
	
	function getMissionForwordApplication($nowtime){
$sql = "SELECT `iccr_countries`.`country_name` ,`iccr_missions`.`mission_name`,`iccr_missions`.`mission_email` ,`iccr_countries`.`country_name`,
count(iccr_status_mapping.status) as Total FROM `iccr_status_mapping`
 JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
 JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
 JOIN `iccr_student_details` ON `iccr_student_details`.`uid` = `iccr_status_mapping`.`uid`
 JOIN `iccr_missions` ON `iccr_missions`.`id` =`iccr_student_other_details`.`application_through` 
 JOIN `iccr_countries` ON `iccr_student_other_details`.`mission_made_through` = `iccr_countries`.`id` WHERE `iccr_status_mapping`.`status` IN(4, 5) 
 AND `iccr_student_other_details`.`created` >= 1544812200 AND `iccr_student_other_details`.`created` <= ".$nowtime." group by iccr_missions.mission_email";

return $this->db->query($sql)->result_array();
		
	}
	
	
	function getRoTotalApplication($nowtime){
		
		
		$sql = "Select r.name as RO, count(t1.id) as total from (SELECT iccr_status_mapping.id, `iccr_student_application_details`.`university_choice_one_state` as s1,`iccr_student_application_details`.`university_choice_two_state` as s2,`iccr_student_application_details`.`university_choice_three_state` as s3 FROM `iccr_status_mapping` JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` JOIN `iccr_student_details` ON `iccr_student_details`.`uid` = `iccr_status_mapping`.`uid` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id` WHERE `iccr_status_mapping`.`status` >= 4 AND `iccr_student_other_details`.`created` >= 1544812200 AND `iccr_student_other_details`.`created` <= ".$nowtime." ORDER BY `iccr_status_mapping`.`id` ASC) as t1 JOIN iccr_regions r on r.id = t1.s1 or r.id = t1.s2 or r.id=t1.s3 group by r.id";
		return $this->db->query($sql)->result_array();
		
	}
	
	
	function getStudentRegistratioYear($appId){
		
        $this->db->select('iccr_student_other_details.*');
        $this->db->from('iccr_student_other_details');
        $this->db->where('application_no', $appId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
	}
	
	  function getconfirmationDataforHqrsIcar($appno) {
        $this->db->select('iccr_university_response_by_hqrs.*');
        $this->db->from('iccr_university_response_by_hqrs');
        $this->db->where(array('application_id' => $appno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function updateNew($data,$appId) {
        $this->db->where('application_no', $appId);
        $this->db->update('iccr_status_mapping', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	function getCountryWiseConfirmation($nowtime){
		
		
		$sql = "SELECT DISTINCT COUNT(iccr_status_mapping.status) as Total, `iccr_student_application_details`.`application_no`,
`iccr_student_application_details`.`fullname`, `iccr_student_application_details`.`email`, `iccr_countries`.`country_name` 
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
JOIN `iccr_university_response` ON `iccr_university_response`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no`
WHERE `iccr_status_mapping`.`status` >= 10 AND `iccr_status_mapping`.`iccr_status` = 1 
AND `iccr_university_response`.`university_is_accept` = 1 
AND `iccr_student_other_details`.`created` >= 1544832000
AND `iccr_student_other_details`.`created` <= 1568178831 And `iccr_countries`.`id` IN('2','3','160','14','129','130','131','132','159','134','23','153','146','24','135','30','136','137','31','148','149','37','138','158','55','139','40','62','63','64','67','155','68','71','72','74','78','79','141','142','94','96','143','156','100','101','104','144','110','145','113','116','125','126') group by iccr_countries.country_name";
		return $this->db->query($sql)->result_array();
		
	}
	
	
	  function updateExpeDocuments($data) {
        $this->db->where('id', $data['id']);
        $this->db->update('iccr_exp_stipend', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	

	
	function getScholorshipById($id) {
		//echo $appno;die;
        $this->db->select('*');
        $this->db->from('iccr_schemes');
        $this->db->where('id', $id);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	
	
	function isAlreadyDetails($appId, $regionId) {
		//echo $appId;
		//echo $regionId;die;
        $this->db->select('iccr_student_data.*');
        $this->db->from('iccr_student_data');
        $this->db->where(array('iccr_student_data.regional_office' => $regionId, 'iccr_student_data.application_no' => $appId));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function isApplication($appId) {
		//echo $appId;
		//echo $regionId;die;
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('iccr_university_response.application_id' => $appId));
		//$this->db->where(array('iccr_university_response.university_is_accept' =>1));
        $resu = $this->db->get()->result_array();
		 if ($resu) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	  function insertStudentsDetails($data) {
        $q = $this->db->insert_string('iccr_student_data', $data);
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($id > 0)
            return TRUE;
        else
            return FALSE;
    }
	function getStudentAdmissionDetailsByRegion($regionid) {
        $this->db->select('iccr_student_data.*');
        $this->db->from('iccr_student_data');


        $this->db->where('regional_office', $regionid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	
	
	  function get_iccr_datatables_query($ids,$vars)
    {
		//echo "<pre>";
		//print_r($vars);die;
		$minDate = strtotime($vars['MinDate']);
		$maxDate = strtotime($vars['MaxDate']);
		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			
			$sql = "Select (SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping` JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no WHERE `iccr_status_mapping`.`status` >= 1 AND  `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.")) as totalCount,
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
 Where iccr_status_mapping.scholarship_id IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND    iccr_university_response.university_is_accept=1) as totalAccepted,
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
 Where iccr_status_mapping.scholarship_id IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND iccr_university_response.university_is_accept=2) as totalRejected,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.gender=1) as totalMale,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.gender=2) as totalFemale,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=1) as totalUG,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=2) as totalPG,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=3) as totalMphil,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=4) as totalPHD,
(SELECT count(iccr_university_response.id) FROM iccr_university_response JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id JOIN iccr_travelplan ON iccr_travelplan.application_id = iccr_university_response.application_id JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no Where iccr_status_mapping.scholarship_id IN(".$ids.") AND iccr_travelplan.status=14 AND iccr_university_response.university_is_accept=1 AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate.") as totalAdmitted";
//echo $sql;die;
		}
	/* 	if ($vars['Programme'] != "") {
            
				$sql = "Select (SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping` JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no WHERE `iccr_status_mapping`.`status` >= 1 AND `sd`.`created` >= ".$minDate."  AND `sd`.`created` <= ".$maxDate." AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.")) as totalCount,
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
 Where iccr_status_mapping.scholarship_id IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND    iccr_university_response.university_is_accept=1) as totalAccepted,
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
 Where iccr_status_mapping.scholarship_id IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND iccr_university_response.university_is_accept=2) as totalRejected,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.gender=1) as totalMale,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.gender=2) as totalFemale,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no  JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=".$vars['Programme'].") as totalUG,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=".$vars['Programme'].") as totalPG,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=".$vars['Programme'].") as totalMphil,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=".$vars['Programme'].") as totalPHD,
(SELECT count(iccr_university_response.id) FROM iccr_university_response JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id JOIN iccr_travelplan ON iccr_travelplan.application_id = iccr_university_response.application_id JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no Where iccr_status_mapping.scholarship_id IN(".$ids.") AND iccr_travelplan.status=14 AND iccr_university_response.university_is_accept=1 AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate.") as totalAdmitted";
	echo $sql;die;		
        } */
		else
		{
			
			$sql = "Select (SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping` WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.")) as totalCount,
			
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` 
 Where iccr_status_mapping.scholarship_id IN(".$ids.") AND  iccr_university_response.university_is_accept=1) as totalAccepted,
 
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` 
 Where iccr_status_mapping.scholarship_id IN(".$ids.") AND  iccr_university_response.university_is_accept=2) as totalRejected,
 
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.gender=1) as totalMale,

(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.gender=2) as totalFemale,

(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.programme=1) as totalUG,

(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.programme=2) as totalPG,

(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.programme=3) as totalMphil,

(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no 
WHERE `iccr_status_mapping`.`status` >= 1 AND `iccr_status_mapping`.`scholarship_id` IN(".$ids.") AND ad.programme=4) as totalPHD,

(SELECT count(iccr_university_response.id) FROM iccr_university_response JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id JOIN iccr_travelplan ON iccr_travelplan.application_id = iccr_university_response.application_id Where iccr_status_mapping.scholarship_id IN(".$ids.") AND iccr_travelplan.status=14 AND iccr_university_response.university_is_accept=1) as totalAdmitted";
//echo $sql;die;
			
		}
		
		

	    $this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
		if ($code['code'] > 0) {
            //show_error('Message');
        }
      return $this->db->query($sql)->result_array();
     
	}
	
	function getTotalAdmitApplications($ids){
		
		$sql = "SELECT iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_status_mapping.scholarship_id,iccr_countries.country_name,iccr_university_response.application_id
		FROM iccr_university_response 
		JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id
		JOIN iccr_student_application_details ON iccr_student_application_details.application_no = iccr_university_response.application_id
		join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
		JOIN iccr_travelplan ON iccr_travelplan.application_id =  iccr_university_response.application_id Where iccr_status_mapping.scholarship_id IN(".$ids.") AND iccr_travelplan.status=14 AND iccr_university_response.university_is_accept =1";
		//echo $sql;die;
		return $this->db->query($sql)->result_array();
	}
	  
	
	public function getDocumentDetails($vars,$regionId) {
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.bonafide_doc,iccr_status_mapping.joining_doc,iccr_status_mapping.police_doc,iccr_courses.title,iccr_scheme.scheme_name,iccr_univercities.name');
		
		$this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no');
		$this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_status_mapping.scholarship_id');
		$this->db->join('iccr_courses', 'iccr_courses.id = iccr_student_application_details.course');
		//$this->db->join('iccr_issue_documents', 'iccr_issue_documents.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_university_response.regional_university');
		
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');
        $this->db->where('(iccr_university_response.region_one_status=' . $regionId . ' and iccr_university_response.university_is_accept=1) or (iccr_university_response_by_hqrs.region_one_status=' . $regionId . ' and iccr_university_response_by_hqrs.university_is_accept=1)');
		$this->db->where(array('iccr_status_mapping.status' => 14, 'iccr_travelplan.status' => 14));
   
		
        //add custom filter here

        if ($this->input->post('Country')) {
            $this->db->where('iccr_student_application_details.country', $this->input->post('Country'));
        }
        if ($this->input->post('ApplicantName')) {
            $this->db->like('iccr_student_application_details.fullname', $this->input->post('ApplicantName'));
        }
        if ($this->input->post('Gender')) {
            $this->db->like('iccr_student_application_details.gender', $this->input->post('Gender'));
        }
        if ($this->input->post('Mail')) {
            $this->db->like('iccr_student_application_details.email', $this->input->post('Mail'));
        }
        if ($this->input->post('Programme')) {
            $this->db->where('iccr_student_application_details.programme', $this->input->post('Programme'));
        }
        if ($this->input->post('Counrse')) {
            $this->db->where('iccr_student_application_details.course', $this->input->post('Counrse'));
        }
        if ($this->input->post('Scheme')) {
            $this->db->where('iccr_status_mapping.scholarship_id', $this->input->post('Scheme'));
        }
        if ($this->input->post('Region')) {
            $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
        if ($this->input->post('Universtiy')) {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_two=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_three=' . $this->input->post('Universtiy') . ')');
        }
       
       // echo $this->db->_compile_select();
        
        $code = $this->db->error();
		$this->db->limit($vars['length'],$vars['start']);
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		return $this->db->get()->result_array();
    }
	
	
	public function getTotalDocumentDetails($vars,$regionId) {
        $this->db->distinct();
        $this->db->select('count(iccr_status_mapping.application_no) as total');
		$this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no');
		$this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_status_mapping.scholarship_id');
		$this->db->join('iccr_courses', 'iccr_courses.id = iccr_student_application_details.course');
		//$this->db->join('iccr_issue_documents', 'iccr_issue_documents.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_university_response.regional_university');
		
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');
        $this->db->where('(iccr_university_response.region_one_status=' . $regionId . ' and iccr_university_response.university_is_accept=1) or (iccr_university_response_by_hqrs.region_one_status=' . $regionId . ' and iccr_university_response_by_hqrs.university_is_accept=1)');
		$this->db->where(array('iccr_status_mapping.status' => 14, 'iccr_travelplan.status' => 14));
   
		
        //add custom filter here

        if ($this->input->post('Country')) {
            $this->db->where('iccr_student_application_details.country', $this->input->post('Country'));
        }
        if ($this->input->post('ApplicantName')) {
            $this->db->like('iccr_student_application_details.fullname', $this->input->post('ApplicantName'));
        }
        if ($this->input->post('Gender')) {
            $this->db->like('iccr_student_application_details.gender', $this->input->post('Gender'));
        }
        if ($this->input->post('Mail')) {
            $this->db->like('iccr_student_application_details.email', $this->input->post('Mail'));
        }
        if ($this->input->post('Programme')) {
            $this->db->where('iccr_student_application_details.programme', $this->input->post('Programme'));
        }
        if ($this->input->post('Counrse')) {
            $this->db->where('iccr_student_application_details.course', $this->input->post('Counrse'));
        }
        if ($this->input->post('Scheme')) {
            $this->db->where('iccr_status_mapping.scholarship_id', $this->input->post('Scheme'));
        }
        if ($this->input->post('Region')) {
            $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
        if ($this->input->post('Universtiy')) {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_two=' . $this->input->post('Universtiy') . ' or iccr_student_application_details.universty_choice_three=' . $this->input->post('Universtiy') . ')');
        }
      
       // echo $this->db->_compile_select();
        
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		return $this->db->get()->result_array();
    }
	
	function bonafideUpdateInfo($data,$appid) {
		//echo "<pre>";
		//print_r($appid);
		//print_r($data);die;
        $this->db->where('id', $appid);
        $this->db->update('iccr_issue_documents', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	public function count_bonafide_filtered($regional) {
        $this->_get_bonafide_datatables_query($regional);
        $query = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $query->num_rows();
    }
	
	public function count_bonafide_all($regionId) {
       $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.bonafide_doc,iccr_status_mapping.joining_doc,iccr_status_mapping.police_doc,iccr_courses.title,iccr_scheme.scheme_name,iccr_univercities.name');
		
		$this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no');
		$this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_status_mapping.scholarship_id');
		$this->db->join('iccr_courses', 'iccr_courses.id = iccr_student_application_details.course');
		//$this->db->join('iccr_issue_documents', 'iccr_issue_documents.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_university_response.regional_university');
		
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');
        $this->db->where('(iccr_university_response.region_one_status=' . $regionId . ' and iccr_university_response.university_is_accept=1) or (iccr_university_response_by_hqrs.region_one_status=' . $regionId . ' and iccr_university_response_by_hqrs.university_is_accept=1)');
		$this->db->where(array('iccr_status_mapping.status' => 14, 'iccr_travelplan.status' => 14));
		
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->count_all_results();
    }
	
	function insertCourseId($data) {
        $q = $this->db->insert('course_id', $data);
        return $this->db->insert_id();
    }
	
	function applicantAcceptanceForRo($regionId) {
        $this->db->select('iccr_status_mapping.status,iccr_university_response_by_hqrs.application_id,iccr_status_mapping.application_no,iccr_student_details.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.undertaking_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
		$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no','left');
        $this->db->where(array('iccr_status_mapping.status >=' => 11,'iccr_status_mapping.status !=' => 15,'iccr_university_response.region_one_status' => $regionId));
		//echo $this->db->_compile_select();die;
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function applicantAcceptanceAyushForRo($regionId) {
        $this->db->select('iccr_status_mapping.status,iccr_university_response_by_hqrs.application_id,iccr_university_response_by_hqrs.regional_university,iccr_status_mapping.application_no,iccr_student_details.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.undertaking_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		//$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
		$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no','left');
        $this->db->where(array('iccr_status_mapping.status >=' => 11,'iccr_status_mapping.status !=' => 15,'iccr_university_response_by_hqrs.region_one_status' => $regionId));
		//echo $this->db->_compile_select();die;
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	public function getCheckTravelPlan1($appId) {
        $this->db->get_where('iccr_travelplan', array('application_id' => $appId), 1);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }
	
	

    public function getCheckTravelPlan($appId) {
        $this->db->where('application_id', $appId);
        $this->db->from('iccr_travelplan');
        $num_res = $this->db->get()->result_array();

        if ($num_res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	
	function getTravelPlanDetails($appId) {
        $this->db->select('iccr_travelplan.*');
        $this->db->from('iccr_travelplan');


        $this->db->where('application_id', $appId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getUnderTakingofStudent($appId) {
        $this->db->select('iccr_status_mapping.*');
        $this->db->from('iccr_status_mapping');
        $this->db->where('application_no', $appId);
        $code = $this->db->error();
		//echo $this->db->_compile_select();exit;
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	    function getRegionalApplicationsConfirmationtoRegion($regionId,$schemeids) {
		//echo "<pre>";
		//print_r($regionId);
		//print_r($id);die;
		//die;
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.new,iccr_status_mapping.university_is_accept,iccr_university_response.university_is_accept as University_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.course as courseconfirm,iccr_university_response.confirmed_to_mission,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details','iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        //$this->db->where(array('iccr_status_mapping.status' => 8));
		//$this->db->where(array('iccr_status_mapping.status >=' => 8));
		$this->db->where(array('iccr_status_mapping.status' => 4));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->where(array('iccr_university_response.region_one_status' => $regionId));
        $this->db->order_by('iccr_status_mapping.id', 'ASC');
        $this->db->order_by('iccr_university_response.id', 'DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	public function updateSfsApplicationMapStatus($appno, $data) {
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_sfs_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	function insertApplicationMapStatus($data) {
		//echo "<pre>";print_r($data);die;
        $q = $this->db->insert_string('iccr_status_mapping', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	
	function updateApplicationSfsStatus($appno, $userid) {
        $data = array(
            'status' => 'Submit'
        );
        $this->db->where('uid', $userid);
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_sfs_student_application_details', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	    function updateSfsApplicationStatus($appno, $userid) {
        $data = array(
            'status' => 'Submit'
        );
        $this->db->where('uid', $userid);
        $this->db->where('application_no', $appno);
        $this->db->update('iccr_sfs_student_application_details', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	function insertSfsApplicationMapStatus($data) {
        $q = $this->db->insert_string('iccr_sfs_status_mapping', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	
	    function getSFSHQRSAYUSHApplication($schemeids) {
        $this->db->select('iccr_sfs_status_mapping.status,iccr_sfs_student_details.created,iccr_sfs_student_application_details.application_no,iccr_sfs_student_application_details.fullname,iccr_sfs_student_application_details.email,iccr_countries.country_name,iccr_sfs_student_application_details.course,iccr_sfs_status_mapping.scholarship_id,iccr_sfs_student_application_details.programme,iccr_sfs_student_application_details.course_two,iccr_sfs_student_application_details.course_three');
        $this->db->from('iccr_sfs_status_mapping');
        $this->db->join('iccr_sfs_student_application_details', 'iccr_sfs_student_application_details.application_no = iccr_sfs_status_mapping.application_no');
		$this->db->join('iccr_sfs_student_details', 'iccr_sfs_student_details.uid = iccr_sfs_status_mapping.uid');
        $this->db->join('iccr_sfs_student_other_details', 'iccr_sfs_student_other_details.application_no = iccr_sfs_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_sfs_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_sfs_status_mapping.status' => 4));
        $this->db->where(array('iccr_sfs_student_application_details.university_choice_one_state' => 0, 'iccr_sfs_student_application_details.university_choice_two_state' => 0, 'iccr_sfs_student_application_details.university_choice_three_state' => 0));
        $this->db->where(array('iccr_sfs_student_application_details.course_type' => 1));
     
        $this->db->where_in('iccr_sfs_status_mapping.scholarship_id', $schemeids);
        $this->db->or_where(array("iccr_sfs_student_application_details.programme"=>8));
        $this->db->where(array('iccr_sfs_student_application_details.course_type' => 0));
        $this->db->where("iccr_sfs_status_mapping.scholarship_id IS NOT NULL"); 
        $this->db->where("iccr_sfs_status_mapping.scholarship_id != ''");
      
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	
	function getUniversityInfo($universityId) {
        $this->db->select('*');
        $this->db->from('iccr_users');
        $this->db->where(array('iccr_users.university' => $universityId));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	function getUniversityApplications($vars,$universityId) {
		//echo $universityId;die;
        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.application_no,iccr_student_details.created');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
		}
        $this->db->where(array('iccr_status_mapping.status' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
		
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
        
        if ($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
        }       
        if ($vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if ($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
        if ($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
       
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_details.created <=', strtotime($vars['MaxDate']));
		}
		//echo $this->db->_compile_select();die;
		//$this->db->where('iccr_student_details.created >=',1544832000 );
        //$this->db->where('iccr_student_details.created <=',1563167040 );
        $this->db->limit($vars['length'],$vars['start']);
	    //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
    function getTotalUniversityApplications($vars,$universityId)
    {
		$this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
		}
        //$this->db->where(array('iccr_status_mapping.status' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_student_other_details.mission_made_through'=>$cuntryid));
		 $this->db->where(array('iccr_status_mapping.status' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
         if ($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
        }       
        if ($vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if ($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
        if ($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		//echo $this->db->_compile_select();die;
		//$this->db->where('iccr_student_other_details.created >=',1544832000);
        //$this->db->where('iccr_student_other_details.created <=',1563167040);
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
	} 
	
	 function isAnyUniversityResponseConfirmByUniversity($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	//vipin ayush
	function getAYUSHUniversities() {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link');
        $this->db->from('iccr_univercities');
        $this->db->where(array('university_type' => 8,'status' =>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	   function getAllAyushCourseType() {
        $this->db->select('*');
        $this->db->from('iccr_course_type');
		$this->db->where_in('id', array('1'));
		//$this->db->where_in('id', array('1','2','3','4','5','6','7','8','9','10'));
		//$this->db->where_in('id', array('2','3','4','5','6','7','8','9'));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getAyushUniversitiesWithMapping() {
        $this->db->select('*');
        $this->db->from('iccr_univercities');
        $this->db->where_in('university_type', array(8));
        $this->db->where_in('status', array(1));
        $this->db->group_by('name');

        //$this->db->group_by('iccr_states.name');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	
	function getUniversitiesWithMapping($program_id,$courseType_id,$course_id,$university_id) {
		//echo "Agriculture";die;
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_states.name,iccr_states.id as stateid,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
		if($courseType_id == 2){
        $this->db->where(array('iccr_univercities.university_type' => 6, 'iccr_university_mapping.programme_id' => $program_id, 'iccr_university_mapping.course_type' => $courseType_id,'iccr_university_mapping.course_id' => $course_id));
		}else{
			 $this->db->where(array('iccr_univercities.university_type' => 2, 'iccr_university_mapping.programme_id' => $program_id, 'iccr_university_mapping.course_type' => $courseType_id,'iccr_university_mapping.course_id' => $course_id));
		}
        //$this->db->group_by('iccr_states.name');
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
		function getNITUniversitiesWithMapping($program_id,$courseType_id,$course_id) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        //$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
        $this->db->where(array('iccr_univercities.university_type' => 3, 'iccr_university_mapping.programme_id' => $program_id, 'iccr_university_mapping.course_type' => $courseType_id,'iccr_university_mapping.course_id' => $course_id));
        //$this->db->group_by('iccr_states.name');
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getIITUniversitiesWithMapping($program_id,$courseType_id,$course_id) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_states.name,iccr_states.id as stateid,iccr_univercities.state_id');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
        $this->db->where(array('iccr_univercities.university_type' => 1, 'iccr_university_mapping.programme_id' => $program_id, 'iccr_university_mapping.course_type' => $courseType_id,'iccr_university_mapping.course_id' => $course_id));
        //$this->db->group_by('iccr_states.name');
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getAllCourseTypeWithoutAyush() {
        $this->db->select('*');
        $this->db->from('iccr_course_type');
		//$this->db->where_in('id', array('1'));
		 $this->db->where_in('id', array('2','3','4','6','13','14','15','16','17','18','20'));
		//$this->db->where_in('id', array('2','3','4','5','6','7','8','9'));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $this->db->order_by("course_type", "asc");
        return $this->db->get()->result_array();
    }

	function getCertificateCourseType() {
        $this->db->select('*');
        $this->db->from('iccr_course_type');
		$this->db->where_in('id', array('9'));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $this->db->order_by("course_type", "asc");
        return $this->db->get()->result_array();
    }

	
	 function getAllAyushProgramme() {
        try {
			
            $this->db->select('id,name');
            $this->db->from('iccr_programme');
			
			//$this->db->where_in('id', array('4'));
			$this->db->where_in('id', array('1','2','8'));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	
	
	function getUniversitiesCourseStreamMapping($university_id,$programme,$course_type,$course) {
		//echo $program_id.'----'; echo $course_id.'----';echo $universityId.'----' ;die;
        $this->db->select('*');
        $this->db->from('iccr_stream_page');
		$this->db->join('iccr_stream', 'iccr_stream.id = iccr_stream_page.stream_id');
        $this->db->where(array('iccr_stream_page.programme_id' => $programme, 'iccr_stream_page.course_id' => $course,'iccr_stream_page.course_type_id' => $course_type,'iccr_stream_page.user_id' => $university_id));
        //$this->db->order_by('iccr_stream.name','ASC');
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getCourses($program_id,$courseType_id,$course_id) {
        $this->db->select('*');
        $this->db->from('iccr_courses');
        $this->db->where(array('iccr_courses.prg_id' => $program_id, 'iccr_courses.course_id' => $courseType_id,'iccr_courses.status' => 1));
        //$this->db->group_by('iccr_states.name');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	 //Insert Bunch Data
    public function insert_bunchdemo($table, $data)
    {
		//echo "<pre>";print_r($data);die;
		//echo $this->db->_compile_select();
        $this->db->insert_batch($table, $data);
		
        return $this->db->insert_id();
		
    }
	
	 function insert_bunch($data) {
        $q = $this->db->insert_string('iccr_exp_advance_stipend', $data);
		//echo $q;die;
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	
	
	   function getApplicationStepOneOldByAppno($appno) {
        $this->db->select('*');
        $this->db->from('iccr_student_expenditure');
        $this->db->where('application_id', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	function getMissionById($id) {
        $this->db->select('*');
        $this->db->from('iccr_missions');
        $this->db->where('id', $id);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	//vipin for Agency data 
	
	function getJoiningDetails($appno) {
        $this->db->select('*');
        $this->db->from('iccr_joining_details');
        $this->db->where('application_no', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getMissionData($appno,$userId) {
        $this->db->select('*');
        $this->db->from('iccr_student_other_details');
		$this->db->join('iccr_missions', 'iccr_missions.id = iccr_student_other_details.application_through');
        $this->db->where('application_no', $appno);
		$this->db->where('uid', $userId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
		function getRegion() {
        $this->db->select('*');
        $this->db->from('iccr_regions');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }
		function getCountMissionApplicationsAlert($missionId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		$this->db->where('FROM_UNIXTIME(`iccr_status_mapping`.`created`) >= now() - INTERVAL 1 day');
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	    function getMissionForwordApplicationAlert($missionid) {
        $this->db->select('count(iccr_status_mapping.id) as newProcessApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where_in('iccr_student_other_details.application_through', $missionid);
		//$this->db->where('TIMESTAMP(`iccr_status_mapping`.`mission_status_date`) >= now() - INTERVAL 1 day');
		$this->db->where('FROM_UNIXTIME(SUBSTRING_INDEX(`iccr_status_mapping`.`mission_person_signature`,"_",1) ) >= now() - INTERVAL 7 day');
        $this->db->where_in('iccr_status_mapping.status', array(4, 5));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	
	function countgetConfirmationofHqrsAlert($missionId) {
        // Used in Mission Controller
        $this->db->select('count(iccr_status_mapping.id) as newConfirmationApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 10));
		$this->db->where(array('iccr_status_mapping.universities_status' => 22));
		//$this->db->or_where(array('iccr_status_mapping.status' => 10,'iccr_status_mapping.universities_status' => 22));
        //$this->db->where(array('iccr_status_mapping.universities_status' => 22));
        $this->db->where_in('iccr_university_response.university_is_accept', array(1, 2));
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		$this->db->where('FROM_UNIXTIME(SUBSTRING_INDEX(`iccr_university_response`.`region_one_doc`,"_",1) ) >= now() - INTERVAL 7 day');
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
       $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	   function getStreamsById($id) {
        $this->db->select('*');
        $this->db->from('iccr_stream');
        $this->db->where('id', $id);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }

	 function getAluminiFiles($missionId) {
        $this->db->select('*');
        $this->db->from('iccr_alumini_documents');
		$this->db->where('iccr_alumini_documents.status', 1);
        $this->db->where_in('iccr_alumini_documents.mission_id', $missionId);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();
       return $result->result_array();
    }
	
	   function getStreamssById($id) {
        $this->db->select('iccr_stream.name,iccr_stream_page.no_of_seat');
        $this->db->from('iccr_stream');
		$this->db->join('iccr_stream_page', 'iccr_stream_page.stream_id = iccr_stream.id');
        $this->db->where('iccr_stream.id', $id);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	function getCountryByMissionId($id) {
        $this->db->select('id,country');
        $this->db->from('iccr_missions');
        $this->db->where('id', $id);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	    function getApplicantConfirmationofHqrs($applicationId) {
        // Used in Mission Controller
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.universities_status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_status_mapping.university_is_accept,iccr_status_mapping.regional_university,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
       // $this->db->where(array('iccr_status_mapping.status' => 10));
	    $this->db->or_where(array('iccr_status_mapping.status' => 10,'iccr_status_mapping.universities_status' => 22));
		$this->db->where(array('iccr_status_mapping.university_status' => 1));
		//$this->db->where(array('iccr_status_mapping.universities_status' => 22));
        $this->db->where_in('iccr_university_response.university_is_accept', array(1, 2));
        $this->db->where('iccr_status_mapping.application_no', $applicationId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	  function insertNotification($post) {
        $q = $this->db->insert_string('iccr_notifications', $post);

        $this->db->query($q);

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	function insertTestimonials($post) {
        $q = $this->db->insert_string('iccr_testimonials', $post);

        $this->db->query($q);

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	
	  function getActiveTestimonials($todate) {
        $this->db->select('*');
        $this->db->from('iccr_testimonials');

        $this->db->where('validated_upto >=', $todate);
        $this->db->order_by('id', "DESC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }


	    function getAllNotifications($id = null) {
        $this->db->select('*');
        $this->db->from('iccr_notifications');
        if (!empty($id)) {
            $this->db->where(array('iccr_notifications.id' => $id));
        }
        $this->db->order_by('id', "ASC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	  function getAllTestimonials($id = null) {
        $this->db->select('*');
        $this->db->from('iccr_testimonials');
        if (!empty($id)) {
            $this->db->where(array('iccr_testimonials.id' => $id));
        }
        $this->db->order_by('id', "ASC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function updateNotification($id, $post) {
        $this->db->where('id', $id);
        $this->db->update('iccr_notifications', $post);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return 1;
        else
            return 0;
    }

    function deleteNotification($id) {
        $this->db->where('id', $id);
        $this->db->delete('iccr_notifications');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->affected_rows();
    }



    function getAllArchieveNotifications($todate) {
        $this->db->select('*');
        $this->db->from('iccr_notifications');
        $this->db->where('validated_upto <', $todate);
        $this->db->order_by('id', "DESC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getHQRSAYUSHProcessedApplicationsfs() {
   
		$this->db->select('*');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->where(array('iccr_student_details.student_type' => 2));
        $this->db->where(array('iccr_status_mapping.status >=' => 10));
	    $this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->order_by('iccr_student_details.created', 'ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getAYUSHSchemes() {
		$ayushSchemeIds = array('10','21','22','23');
        $this->db->select('*');
        $this->db->from('iccr_scheme');
        $this->db->where_in('id',$ayushSchemeIds);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	public function getApplicantDetails($appid){
		
		 $this->db->select('*');
        $this->db->from('iccr_status_mapping');
        $this->db->where('iccr_status_mapping.application_no', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}
	
	public function checkStatus($appid){
		
	   $sql = "select status from iccr_status_mapping where status >= 1 and application_no = '".$appid."'" ;
	   $rs = $this->db->query($sql)->row();
	   if($rs > 0){
            return true;
		}else{
			
			return false;
		}       
	}
	
	
	function updateRemarks($data,$appid) {
		//echo $appid;die;
        $this->db->where('application_no', $appid);
        $this->db->update('iccr_status_mapping', $data);
        $success = $this->db->affected_rows();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	
	 function getNirfRankings() {
        try {
            $this->db->select('*');
            //$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
            $this->db->from('iccr_nirf_ranking');
            $result = $this->db->get();
			$this->db->order_by('id', 'ASC');
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	
	function getStatesById($id) {
        $this->db->select('*');
        $this->db->from('iccr_states');
        $this->db->where('iccr_states.id', $id);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	
	  function isAnyUniversityResponseApplicantConfirm($appno) {
        $this->db->select('iccr_university_response.*');
        $this->db->from('iccr_university_response');
        $this->db->where(array('application_id' => $appno));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	 function getTravelData($appno) {
        $this->db->select('*');
        $this->db->from('iccr_travelplan');
        $this->db->where('application_id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	  function getAppStatus($appId) {
        $this->db->select('*');
        $this->db->from('iccr_status_mapping');
        $this->db->where('iccr_status_mapping.application_no', $appId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
		
	
	function getUniversityFrontPage($page_master_category=null,$universityId)
	{
		$page_master_category = 0;
		$this->db->select('*');     
        $this->db->from('iccr_page');
		$this->db->where(array('iccr_page.status'=>1,'iccr_page.master_page_id'=>$page_master_category,'user_id'=>$universityId));  
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}

	 function getCommonApplicationStatus($appId,$universityId = null,$flag = null) {
		 
        $this->db->select('iccr_status_mapping.application_no,iccr_status_mapping.status,iccr_student_application_details.fullname,iccr_student_application_details.phone,iccr_student_application_details.email,iccr_student_application_details.nationality,iccr_student_other_details.signature_doc,iccr_status_mapping.universities_status,iccr_status_mapping.undertaking_doc,iccr_status_mapping.visa_no,iccr_status_mapping.scholarship_id,iccr_university_status_mapping.application_id,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_university_status_mapping.status as ResumitStatus,iccr_university_status_mapping.regional_university,iccr_university_status_mapping.university_remarks');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_details', 'iccr_student_details.uid=iccr_status_mapping.uid');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no=iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no=iccr_status_mapping.application_no');
		$this->db->join('iccr_university_status_mapping', 'iccr_university_status_mapping.application_id=iccr_status_mapping.application_no');
		
		if($flag == true)
		{
		$this->db->where('iccr_status_mapping.application_no', $appId);
		$this->db->where('iccr_university_status_mapping.regional_university', $universityId);
		}
        $this->db->where('iccr_status_mapping.application_no', $appId);
		
	    //echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	function getUniversityResponsesForOfferLetter($appid) {
		//echo $appid;die;
        $this->db->select('*');
        $this->db->from('iccr_university_response');
        $this->db->where('application_id', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	 function getAlertStatus() {
        $this->db->select('*');
        $this->db->from('iccr_alert_status_master');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	
	   function getConfirmationofCandidatesOfferLetter($missionId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.undertaking_doc,iccr_status_mapping.visa_grant_permission,iccr_university_response.regional_university');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->where(array('iccr_status_mapping.status >=' => 10));
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function UpdateToFinalConfirmationToHqrsbyMission($data,$appno,$unid) {
		//echo "<pre>";print_r($data);echo $appno;echo $unid;die;
        //$this->db->where('application_id', $appno);
		$this->db->where('regional_university', $unid);
		$this->db->where('application_id', $appno);
        $this->db->update('iccr_university_response', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	function UpdateToFinalConfirmationToHqrsbyMissionStatusMaster($data,$appno,$unid) {
		
		
		//echo "<pre>";print_r($data);echo $appno;echo $unid;die;
        //$this->db->where('application_id', $appno);
		$this->db->where('regional_university', $unid);
		$this->db->where('application_id', $appno);
        $this->db->update('iccr_university_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	
	
	function UpdateToFinalConfirmationToHqrs($data,$appno,$unid) {
		//echo "<pre>";print_r($data);echo $appno;echo $unid;die;
        //$this->db->where('application_id', $appno);
		$this->db->where('regional_university', $unid);
		$this->db->where('application_id', $appno);
        $this->db->update('iccr_university_status_mapping', $data);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $success = $this->db->affected_rows();
        if ($success >= 0)
            return TRUE;
        else
            return FALSE;
    }
	function getUniversitiesVedio() {
        $this->db->select("*");
        $this->db->from("iccr_universities_gallery");
        return $this->db->get()->result_array();
    }
	
	function getUniversitiesfrontVedio() {
		$Ids = array('1','2');
        $this->db->select("*");
        $this->db->from("iccr_universities_gallery");
		$this->db->where_in('id',$Ids);
        return $this->db->get()->result_array();
    }
	function getUniversitiesVedioById($universityId) {
        $this->db->select('iccr_universities_gallery.*');
        $this->db->from('iccr_universities_gallery');
        $this->db->where(array('university_id' => $universityId));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function insertUniversityMapStatus($data) {
		//echo "<pre>";print_r($data);die;
        $q = $this->db->insert_string('iccr_university_status_mapping', $data);
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->insert_id();
    }
	
		
	function getUniversityWiseConfirmApplication(){
$sql = "SELECT count(DISTINCT(`iccr_status_mapping`.`application_no`)) as Total,`iccr_univercities`.`name` as University
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
JOIN `iccr_university_response` ON `iccr_university_response`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_univercities` ON `iccr_univercities`.`id` = `iccr_university_response`.`regional_university`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
WHERE `iccr_status_mapping`.`status` >= 10 and `iccr_status_mapping`.`status` != 5 AND `iccr_status_mapping`.`status` != 6 AND `iccr_status_mapping`.`status` != 15 AND `iccr_university_response`.`university_is_accept` = 1 AND `iccr_status_mapping`.`created` >= 1615749687 group by iccr_univercities.name";
//echo $sql;die;
return $this->db->query($sql)->result_array();
		
	}
	
	
	function getUniversityWiseRejectApplication(){
$sql = "SELECT count(DISTINCT(`iccr_status_mapping`.`application_no`)) as Total,`iccr_univercities`.`name` as University
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
JOIN `iccr_university_response` ON `iccr_university_response`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_univercities` ON `iccr_univercities`.`id` = `iccr_university_response`.`regional_university`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
WHERE `iccr_status_mapping`.`status` >= 10 and `iccr_status_mapping`.`status` != 5 AND `iccr_status_mapping`.`status` != 6 AND `iccr_status_mapping`.`status` != 15 AND `iccr_university_response`.`university_is_accept` = 2 AND `iccr_status_mapping`.`created` >= 1615749687 group by iccr_univercities.name";
return $this->db->query($sql)->result_array();
		
	}
	
	function getFinalUniversityById($universityId) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name,iccr_univercities.state');
        $this->db->from('iccr_univercities');
        $this->db->where(array('iccr_univercities.id' => $universityId,'iccr_univercities.status'=>1));
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getUniversityWiseTotalApplication(){
$sql = "SELECT count(DISTINCT(`iccr_university_status_mapping`.`application_id`)) as Total,`iccr_univercities`.`name` as University
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
JOIN `iccr_university_status_mapping` ON `iccr_university_status_mapping`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_univercities` ON `iccr_univercities`.`id` = `iccr_university_status_mapping`.`regional_university`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
WHERE `iccr_status_mapping`.`status` >= 1 and `iccr_status_mapping`.`status` != 5 AND `iccr_univercities`.`status`= 1 AND `iccr_status_mapping`.`status` != 6 AND `iccr_status_mapping`.`status` != 15 AND `iccr_status_mapping`.`created` >= 1615749687 group by iccr_univercities.name";
return $this->db->query($sql)->result_array();
		
	}
	function getagriCultureUniversitiesWithMapping($id, $ctype,$apply_course_type = null) {
        $this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.state_id,iccr_states.name');
        $this->db->from('iccr_univercities');
        $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');
        $this->db->join('iccr_university_mapping', 'iccr_university_mapping.university_id = iccr_univercities.id');
		if($apply_course_type == 11)
		{
			 $this->db->where(array('iccr_univercities.university_type' => 6, 'iccr_university_mapping.programme_id' => $id, 'iccr_university_mapping.course_type' => $ctype,'iccr_univercities.status >='=> 1));
		}
		else
		{
			 $this->db->where(array('iccr_univercities.university_type' => 6, 'iccr_university_mapping.programme_id' => $id, 'iccr_university_mapping.course_type' => $ctype,'iccr_univercities.status' => 1));
		}
       
        //$this->db->order_by('iccr_univercities.name','ASC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
       //echo $this->db->_compile_select();
        return $this->db->get()->result_array();
    }
	
		function getApplicationDocumentsByAppId($appId) {
        $this->db->select('*');
        $this->db->from('iccr_documents');
        $this->db->where('application_no', $appId);
        $this->db->order_by('added_on', "DESC");
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getAllStatus() {
        $this->db->select('*');
        $this->db->from('iccr_status_master');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }

    function getCountriesByIdNotInCurrentforchina() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where_in('id', 21);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getCountriesByIdNotInCurrentforBangladesh() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where_in('id', 10);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getCountriesByIdNotInCurrentforTanzania() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where_in('id', 110);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getCountriesByIdNotInCurrentforEcuador() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where_in('id', 188);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getCountriesByIdNotInCurrentforMongolia() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where_in('id', 70);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }

    function getCountriesByIdNotInCurrentforKazakhstan() {
        $this->db->select('*');
        $this->db->from('iccr_countries');
        $this->db->where_in('id', 54);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result = $this->db->get()->result_array();
    }
	
	public function __destruct() {
    $this->db->close();
    }
	
	public function getloginHistory()
		{
			$this->db->select('*');
			$this->db->from('iccr_login_history');
			//return $this->db->get()->result_array();
			return $result = $this->db->get()->result_array();
		}
	
}
	
	


?>
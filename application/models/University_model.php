<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class University_model extends CI_Model {

    public $status;
    public $roles;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
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
        $this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		$this->db->where(array('iccr_university_response.confirmed_to_mission' =>1));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->count_all_results();
    }

	function getUniversityApplications($vars,$universityId,$year) {
		$this->db->distinct('iccr_status_mapping.application_no');
		//echo "<pre>";print_r($vars);die;
        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.application_no,iccr_student_details.created,iccr_status_mapping.created as SubmitDate,iccr_status_mapping.universities_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
		//$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.status!=' => 6,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.universities_status !=' => 2,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		//$this->db->where('iccr_university_response.university_is_accept', 2);
		$this->db->where('iccr_student_details.apply_course_type!=', 11);	

		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		if($year == 2021){
    $this->db->where('iccr_status_mapping.created >=',1615749687);
    $this->db->where('iccr_status_mapping.created <=',1644471556);
}
elseif($year == 2022){
    $this->db->where('iccr_status_mapping.created >=',1644471556);
    $this->db->where('iccr_status_mapping.created <=',1680369394);
}
elseif($year == 2023){
    $this->db->where('iccr_status_mapping.created >=',1680369394);
    $this->db->where('iccr_status_mapping.created <=',1704046594);
}
elseif($year == 2024){
    $this->db->where('iccr_status_mapping.created >=',1711983082);
    $this->db->where('iccr_status_mapping.created <=',1735656682);
}
elseif($year == 2025){
    $this->db->where('iccr_status_mapping.created >=',1738378143);
    $this->db->where('iccr_status_mapping.created <=',1767149343);
}
elseif($year == 2026){
    $this->db->where('iccr_status_mapping.created >=',1772150400);
    $this->db->where('iccr_status_mapping.created <=',1798761599);
}
$this->db->order_by('iccr_status_mapping.created','DESC');

        if($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
			//$this->db->or_like('iccr_student_application_details.middlename', $vars['ApplicantName']);
			//$this->db->or_like('iccr_student_application_details.familyname', $vars['ApplicantName']);
			
        } 		  
        if($vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }
        if($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_status_mapping.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_status_mapping.created <=', strtotime($vars['MaxDate']));
		}

        $this->db->limit($vars['length'],$vars['start']);
	   //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        //return 
$query = $this->db->get();
//echo $this->db->last_query();
//die();

return $query->result_array();
    }
function getUniversityApplications1($universityId){

        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.application_no,iccr_student_details.created,iccr_status_mapping.created as SubmitDate,iccr_status_mapping.universities_status');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where('iccr_status_mapping.created >=', 1772150400);
		$this->db->where('iccr_status_mapping.created <=', 1798761599);

        $code = $this->db->error();
        if ($code['code'] > 0) { 
            //show_error('Message');
        }
        // echo $rowcount2324;
        // return $rowcount2324;
       $query = $this->db->get();echo $this->db->last_query();
die();

return $query->result_array();;
    }	
	//Approved Applications
	
	function getUniversityApprovedApplications($vars,$universityId,$year) {
		$this->db->distinct('iccr_status_mapping.application_no');
		//echo "<pre>";print_r($vars);;die;
        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.application_no,iccr_status_mapping.created,iccr_status_mapping.created as SubmitDate,iccr_status_mapping.universities_status,iccr_university_response.regional_university,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		$this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        if($year == 2023){
            $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
            $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
        }
        if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
        if($year == 2025){
			$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
			$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
		}
       if($year == 2026){
			$this->db->where(array('iccr_status_mapping.created >='=> 1772150400));
			$this->db->where(array('iccr_status_mapping.created <='=> 1798761599));
		}
        else{            
            
        }
		
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        if($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
			$this->db->or_like('iccr_student_application_details.middlename', $vars['ApplicantName']);
			$this->db->or_like('iccr_student_application_details.familyname', $vars['ApplicantName']);
			
        }   
        if($vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }
        if($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_status_mapping.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_status_mapping.created <=', strtotime($vars['MaxDate']));
		}

        $this->db->limit($vars['length'],$vars['start']);
	    //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
	
	
	 function getTotalUniversityApprovedApplications($vars,$universityId,$year)
    {
		$this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		$this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
		//$this->db->where('iccr_student_details.student_type!=', 11);
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        if($year == 2023){
            $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
            $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
        }
        if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
        if($year == 2025){
			$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
			$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
		}
       if($year == 2026){
			$this->db->where(array('iccr_status_mapping.created >='=> 1772150400));
			$this->db->where(array('iccr_status_mapping.created <='=> 1798761599));
		}
        else{            
            
        }
		
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
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
			$this->db->where('iccr_status_mapping.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_status_mapping.created <=', strtotime($vars['MaxDate']));
		}
		//echo $this->db->_compile_select();die;
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
	} 
	
	//Rejected Applications
	
	function getUniversityRejectedApplications($vars,$universityId,$year) {
		$this->db->distinct('iccr_status_mapping.application_no');
		//echo "<pre>";print_r($vars);;die;
        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.application_no,iccr_student_details.created,iccr_status_mapping.created as SubmitDate,iccr_status_mapping.universities_status');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
        $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.universities_status !=' => 18,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where('(iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where('iccr_university_response.university_is_accept', 2);
		
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        if($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
        }       
        if($vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }
        if($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        if($year == 2023){
            $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
           $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
		   
        }
		 if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
		if($year == 2025){
		$this->db->where(array('iccr_status_mapping.created >=' => 1740787200));
		//$this->db->where(array('iccr_status_mapping.created <=' => 1767311999));
		}
       if($year == 2026){
			$this->db->where(array('iccr_status_mapping.created >='=> 1772150400));
			$this->db->where(array('iccr_status_mapping.created <='=> 1798761599));
        }
        else{          
            
        }

        $this->db->limit($vars['length'],$vars['start']);
	    //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
	
	   function getTotalUniversityRejectedApplications($vars,$universityId,$year)
    {
		$this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		 $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.universities_status !=' => 18,'iccr_status_mapping.universities_status' => 1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where('iccr_university_response.university_is_accept', 2);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
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
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        if($year == 2023){
            $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
            $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
        }
		 if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
		if($year == 2025){
		$this->db->where(array('iccr_status_mapping.created >=' => 1740787200));
		$this->db->where(array('iccr_status_mapping.created <=' => 1767311999));
}
		if($year == 2026){
    		$this->db->where('iccr_status_mapping.created >=',1772150400);
    		$this->db->where('iccr_status_mapping.created <=',1798761599);

        }
        else{            
            
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_status_mapping.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_status_mapping.created <=', strtotime($vars['MaxDate']));
		}
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
	} 
	  function getVisaConveyedApplicatgion($universityId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		
		 $this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
        $this->db->where_in('iccr_status_mapping.status', array(13, -14));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	//Rejected Applications
	
	
	
	function countgetConfirmationofHqrs($missionId) {
        // Used in Mission Controller
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 10));
        $this->db->where_in('iccr_university_response.university_is_accept', array(1, 2));
        $this->db->where('iccr_university_response.regional_university');
		//, $universityId
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
       $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function countgetConfirmationofCandidates($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
       // $this->db->where(array('iccr_status_mapping.status >=' => 10));
	    $this->db->where(array('iccr_university_response.confirmed_to_mission =' =>1));
		//$this->db->where(array('iccr_status_mapping.universities_status =' =>22));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.scholar_acceptance'=>1));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
		function countgetVisaConveyedApplicatgion($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
        $this->db->where_in('iccr_status_mapping.status', array(13, -14));
		$this->db->where('iccr_status_mapping.created' >='1615749687');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function countgetAcceptedCandidates($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
        $this->db->where_in('iccr_status_mapping.status', array(11, 13));
		$this->db->where('iccr_status_mapping.created' >='1615749687');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function getVisaConveyedApplicatgionUniversity($universityId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
        $this->db->where_in('iccr_status_mapping.status', array(13, -14));
		$this->db->where('iccr_status_mapping.created' >='1615749687');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	  function getAcceptedCandidatesUniversity($universityId) {
		  //echo $universityId;die;
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.undertaking_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
		$this->db->where('iccr_university_response.confirmed_to_mission', 1);
        $this->db->where_in('iccr_status_mapping.status', array(11, 13));
		$this->db->where('iccr_status_mapping.created' >='1615749687');
		
		
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
    function getTotalUniversityApplications($vars,$universityId,$year)
    {
		$this->db->distinct('iccr_status_mapping.application_no');
		$this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        
        //$this->db->where(array('iccr_status_mapping.status' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_student_other_details.mission_made_through'=>$cuntryid));
		$this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.status!=' => 6,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.universities_status !=' => 2,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
			$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
			//$this->db->where('iccr_status_mapping.created' >='1615749687');
			if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        if($year == 2023){
            $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
            $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
        }
        if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
        if($year == 2025){
			$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
			$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
		}
		 if($year == 2026){
			$this->db->where(array('iccr_status_mapping.created >='=> 1772150400));
			$this->db->where(array('iccr_status_mapping.created <='=> 1798761599));
		}
        else{            
            
        }
			$this->db->order_by('iccr_status_mapping.created','DESC');
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
			$this->db->where('iccr_status_mapping.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_status_mapping.created <=', strtotime($vars['MaxDate']));
		}
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
	} 
	
	
	public function getApplicantDetails($appid){
		
		 $this->db->select('*');
        $this->db->from('iccr_status_mapping');
        $this->db->where('iccr_status_mapping.id', $appid);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
	}
	

	
	function getApplicationSfsStepOneByAppno($appno) {
        $this->db->select('*');
        $this->db->from('iccr_sfs_student_application_details');
        $this->db->where('application_no', $appno);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getSfsMissionApplications($vars,$missionId,$cuntryid) {
		
        $this->db->select('iccr_sfs_status_mapping.status ,iccr_sfs_status_mapping.application_no,iccr_sfs_student_details.created');
        $this->db->from('iccr_sfs_status_mapping');
        $this->db->join('iccr_sfs_student_other_details', 'iccr_sfs_student_other_details.application_no = iccr_sfs_status_mapping.application_no');
		$this->db->join('iccr_sfs_student_details', 'iccr_sfs_student_details.uid = iccr_sfs_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_sfs_student_other_details.mission_made_through = iccr_countries.id');
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_sfs_student_application_details', 'iccr_sfs_student_application_details.application_no = iccr_sfs_status_mapping.application_no');	
		}
        $this->db->where(array('iccr_sfs_status_mapping.status' => 1, "iccr_sfs_status_mapping.mission_status" => -1, 'iccr_sfs_status_mapping.iccr_status' => -1, 'iccr_sfs_status_mapping.region_one_status' => -1, 'iccr_sfs_status_mapping.region_two_status' => -1, 'iccr_sfs_status_mapping.region_three_status' => -1));
        $this->db->where_in('iccr_sfs_student_other_details.application_through', $missionId);       
        
        if ($vars['ApplicantName'] != "") {
            $this->db->like('iccr_sfs_student_application_details.fullname', $vars['ApplicantName']);
        }       
        if ($vars['Mail'] != "") {
            $this->db->like('iccr_sfs_student_application_details.email', $vars['Mail']);
        }
        if ($vars['Programme'] != "") {
            $this->db->where('iccr_sfs_student_application_details.programme', $vars['Programme']);
        }
        if ($vars['Counrse'] != "") {
            $this->db->where('iccr_sfs_student_application_details.course',$vars['Counrse']);
        }  
       
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_sfs_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_sfs_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_sfs_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_sfs_student_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_sfs_student_details.created <=', strtotime($vars['MaxDate']));
		}
		
        $this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
	
	
	 function getTotalSfsMissionApplications($vars,$missionId,$cuntryid)
    {
		$this->db->select('count(iccr_sfs_status_mapping.application_no) as total');
        $this->db->from('iccr_sfs_status_mapping');
        $this->db->join('iccr_sfs_student_other_details', 'iccr_sfs_student_other_details.application_no = iccr_sfs_status_mapping.application_no');
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_sfs_student_application_details', 'iccr_sfs_student_application_details.application_no = iccr_sfs_status_mapping.application_no');	
		}
        $this->db->where(array('iccr_sfs_status_mapping.status' => 1, "iccr_sfs_status_mapping.mission_status" => -1, 'iccr_sfs_status_mapping.iccr_status' => -1, 'iccr_sfs_status_mapping.region_one_status' => -1, 'iccr_sfs_status_mapping.region_two_status' => -1, 'iccr_sfs_status_mapping.region_three_status' => -1,'iccr_sfs_student_other_details.mission_made_through'=>$cuntryid));
         if ($vars['ApplicantName'] != "") {
            $this->db->like('iccr_sfs_student_application_details.fullname', $vars['ApplicantName']);
        }       
        if ($vars['Mail'] != "") {
            $this->db->like('iccr_sfs_student_application_details.email', $vars['Mail']);
        }
        if ($vars['Programme'] != "") {
            $this->db->where('iccr_sfs_student_application_details.programme', $vars['Programme']);
        }
        if ($vars['Counrse'] != "") {
            $this->db->where('iccr_sfs_student_application_details.course',$vars['Counrse']);
        }  
       
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_sfs_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_sfs_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_sfs_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_sfs_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_sfs_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
        $this->db->where_in('iccr_sfs_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
	} 
	function getCountMissingDocumentsUniversityApplications($universityId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status=' => 5,'iccr_status_mapping.universities_status' => 18, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		
		
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
function getCountUniversityApplications_26_27($universityId){

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where('iccr_status_mapping.created >=', 1772150400);
		$this->db->where('iccr_status_mapping.created <=', 1798761599);

        $code = $this->db->error();
        if ($code['code'] > 0) { 
            //show_error('Message');
        }
        // echo $rowcount2324;
        // return $rowcount2324;
        $countRowQuery = $this->db->count_all_results();//echo $this->db->last_query(); 
        return $countRowQuery;
    }
    function getCountUniversityApplications_25_26($universityId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
		$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        // echo $rowcount2324;
        // return $rowcount2324;
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }

    function getCountUniversityApplications_24_25($universityId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
		$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        // echo $rowcount2324;
        // return $rowcount2324;
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }

    function getCountUniversityApplications_23_24($universityId) {
        // $frmdate = '2023-04-01';
        // $tomdate = '2023-12-31';
        // $Submit = "Submit";
        // $this->db->from('iccr_student_application_details');
        // $this->db->where('created >= ',$frmdate);
        // $this->db->where('created <= ',$tomdate);
        // $this->db->where('Status',$Submit);
        // $this->db->where('(iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
        // $query = $this->db->get();
        // $rowcount2324 = $query->num_rows();

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
		$this->db->where(array('iccr_status_mapping.created <='=> 1704046594));

        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        // echo $rowcount2324;
        // return $rowcount2324;
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function getCountUniversityApplications($universityId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }


    function getCountUniversityApplicationsNew($universityId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where(array('iccr_status_mapping.created >='=> 1680360601));
		$this->db->where(array('iccr_status_mapping.created <='=> 1704034201));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }


    function countgetUniversityProcessedApplications_2024($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
		//$this->db->where_in('iccr_status_mapping.universities_status', array(22, 18));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
		$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
        //echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
		 return $countRowQuery;
	 }

     function countgetUniversityProcessedApplications_2025($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
		//$this->db->where_in('iccr_status_mapping.universities_status', array(22, 18));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
		$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
        //echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
		 return $countRowQuery;
	 }

	function countgetUniversityProcessedApplications_2026($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
		//$this->db->where_in('iccr_status_mapping.universities_status', array(22, 18));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1772150400));
		$this->db->where(array('iccr_status_mapping.created <='=> 1798761599));
        //echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
		 return $countRowQuery;
	 }
	
	 function countgetUniversityProcessedApplications($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 1);
		//$this->db->where_in('iccr_status_mapping.universities_status', array(22, 18));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
		 return $countRowQuery;
	 }

	 function countgetUniversityRejectedApplications($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
		$this->db->where('iccr_university_response.university_is_accept', 2);
		//$this->db->where_in('iccr_status_mapping.universities_status', array(22, 18));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
		 return $countRowQuery;
	 }
	function getUniversityProcessedApplications($universityId) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.id,iccr_status_mapping.universities_status,iccr_student_application_details.application_no,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.mission_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_student_application_details.course_option_name_two,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.course_subject,iccr_university_response.university_is_accept,iccr_student_other_details.created,iccr_status_mapping.created as SubmitDate,iccr_university_response.region_one_status,iccr_university_response.region_one_status_date,iccr_university_response.regional_university');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_student_other_details.application_through', $missionid);
		//$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
        //$this->db->where_in('iccr_status_mapping.universities_status', array(22, 18));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		//$this->db->where('iccr_status_mapping.status', array(5));
		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	function countresubmitapplication($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_status_mapping', 'iccr_university_status_mapping.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
		$this->db->where(array('iccr_university_status_mapping.status' => 9,'iccr_university_status_mapping.regional_university' => $universityId));
        //$this->db->where(array('iccr_university_status_mapping.status' => 9));
        $this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	function resubmitapplication($universityId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_other_details.created,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_status_mapping', 'iccr_university_status_mapping.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
		//$this->db->join('iccr_university_status_mapping', 'iccr_university_status_mapping.application_id = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_university_status_mapping.status' => 9,'iccr_university_status_mapping.regional_university' => $universityId));
		
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function countpending_applications($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where(array('iccr_status_mapping.status' => 2));
	   $this->db->where(array('iccr_status_mapping.universities_status' => 21));
       $this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	 function pending_applications($universityId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_other_details.application_through,iccr_student_other_details.mission_made_through,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 2));
		//$this->db->where(array('iccr_status_mapping.universities_status' => 21));
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
       // $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function counthold_applications($universityId) {
        $this->db->select('iccr_status_mapping.id');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_status_mapping', 'iccr_university_status_mapping.application_id = iccr_status_mapping.application_no');
        //$this->db->where(array('iccr_status_mapping.status' => 23));
		
	  $this->db->where(array('iccr_university_status_mapping.status' => 3,'iccr_university_status_mapping.regional_university' =>$universityId));
	  $this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
	   //echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
       $countRowQuery = $this->db->count_all_results();
       return $countRowQuery;
    }
	
		 function hold_applications($universityId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.course_subject,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_status_mapping', 'iccr_university_status_mapping.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
       $this->db->where(array('iccr_university_status_mapping.status' => 3,'iccr_university_status_mapping.regional_university' =>$universityId));
		//$this->db->where(array('iccr_status_mapping.status' => 23));
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//$this->db->where(' (iccr_student_application_details.regional_university=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	 function getConfirmationofCandidates($universityId) {
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.nationality');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
        //$this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where(array('iccr_university_response.confirmed_to_mission =' =>1));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.scholar_acceptance'=>1));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getConfirmationofHqrs($universityId) {
        // Used in Mission Controller
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_status_mapping.university_is_accept,iccr_status_mapping.regional_university,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status' => 10));
		$this->db->where(array('iccr_status_mapping.universities_status' => 22));
        $this->db->where_in('iccr_university_response.university_is_accept', array(1, 2));
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
		function getAllStream($id) {
        try {
            $this->db->select('id,name');
            $this->db->from('iccr_stream');
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	
	
	function getUniversitiesStream($program_id) {
        $this->db->select('*');
        $this->db->from('iccr_stream');
        $this->db->where(array('iccr_stream.programme_id' => $program_id));
        //$this->db->group_by('iccr_states.name');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
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
	
	function insertSchemeSlot($data) {
        $q = $this->db->insert_string('iccr_stream_page', $data);
		//echo $q;die;
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
	function insertStream($data) {
        $q = $this->db->insert_string('iccr_stream', $data);
		//echo $q;die;
        $this->db->query($q);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $id = $this->db->insert_id();
        if ($id > 0)
            return $id;
        else
            return FALSE;
    }
	function insertStreamMapping($data) {
        $q = $this->db->insert_string('iccr_stream_page', $data);
		//echo $q;die;
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
	
		 function getUniversitySlugData($page_category,$universityId) {
        try {
            $this->db->select('*');
            $this->db->from('iccr_page');
			$this->db->where(array('iccr_page.page_slug' => $page_category,'iccr_page.user_id' => $universityId));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	
	function updateSchemeSlot($universityId,$post,$data) {
		//echo "<pre>";print_r($post);die;
		$programme = $post['programme_university'];
		$course = $post['university_course'];
		$stream = $post['university_stream'];
		$cType = $post['university_course_type'];
		//echo $programme;
		//echo $course;
		//echo $stream;
		//echo $cType;die;
		$this->db->where(array('iccr_stream_page.user_id' => $universityId, 'iccr_stream_page.programme_id' => $programme,'iccr_stream_page.stream_id' => $stream,'iccr_stream_page.course_id' => $course,'iccr_stream_page.course_type_id' => $cType,));
        $this->db->update('iccr_stream_page', $data);
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
	function updateUniversityPage($universityId,$data,$post) {
		$slug = $post['page_slug'];
		$this->db->where('page_slug', $slug);
		$this->db->where('user_id', $universityId);
        $this->db->update('iccr_page', $data);
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
	
	
			 function getUniversityStreamData($universityId,$programme,$courseType,$course,$stream) {
        try {
            $this->db->select('*');
            $this->db->from('iccr_stream_page');
			$this->db->where(array('iccr_stream_page.course_id' => $course,'iccr_stream_page.user_id' => $universityId,'iccr_stream_page.stream_id' => $stream,'iccr_stream_page.programme_id' => $programme));
            $result = $this->db->get();
            $code = $this->db->error();
            if ($code['code'] > 0) {
                //show_error('Message');
            }
            return $result->result_array();
        } catch (Exception $e) {
            
        }
    }
	
	
	public function isStreamExists($universityId,$data)
    {
        try {
			
			$course = $data['university_course'];
			$programme = $data['programme_university'];
			$stream = $data['university_stream'];
			$courseType = $data['university_course_type'];
            $this->db->select('*');
            $this->db->from('iccr_stream_page');
			$this->db->where(array('iccr_stream_page.course_id' => $course,'iccr_stream_page.course_type_id' => $courseType,'iccr_stream_page.user_id' => $universityId,'iccr_stream_page.stream_id' => $stream,'iccr_stream_page.programme_id' => $programme));
            $re = $this->db->get();
			$result = $re->result_array();
			//echo "<pre>";print_r($result);die;
           if($result){
            return true;
		}else{
			
			return false;
		} 
        } catch (Exception $e) {
			
		}
		
	}
            
    	function getCountUniversityApplicationsAlert($universityId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		 $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.status!=' => 6,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.universities_status !=' => 2,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		 $this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where('FROM_UNIXTIME(`iccr_status_mapping`.`created`) >= now() - INTERVAL 7 day');
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//echo $this->db->_compile_select();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	
	function getUniversityForwordApplicationAlert($universityId) {
        $this->db->select('count(iccr_status_mapping.id) as newProcessApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      	$this->db->where(array('iccr_status_mapping.status >=' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1,'iccr_status_mapping.universities_status >=' => 1 ,'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
	$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where('FROM_UNIXTIME(SUBSTRING_INDEX(`iccr_status_mapping`.`university_person_signature`,"_",1) ) >= now() - INTERVAL 7 day');
        //$this->db->where_in('iccr_status_mapping.universities_status', array(1));
		$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
	function getUniversityApplicantAcceptanceAlert($universityId) {
        $this->db->select('count(iccr_status_mapping.id) as newProcessApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_university_response', 'iccr_status_mapping.application_no = iccr_university_response.application_id');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      	$this->db->where(array('iccr_status_mapping.status >=' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
	$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		$this->db->where('FROM_UNIXTIME(SUBSTRING_INDEX(`iccr_status_mapping`.`undertaking_doc`,"_",1) ) >= now() - INTERVAL 7 day');
        $this->db->where('iccr_university_response.university_is_accept', 1);
        $this->db->where_in('iccr_status_mapping.status', array(11, 13));
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	public function checkStatus($appid){
		
	   $sql = "select status,id from iccr_status_mapping where status = 1 and status = 6 and id = '".$appid."'" ;
	   //echo $sql;die;
	   $rs = $this->db->query($sql)->row();
	   if($rs > 0){
            return true;
		}else{
			
			return false;
		}       
	}
	function getUniversityChecklist() {
        $this->db->select('iccr_mission_checklist.*');
		$this->db->where_in('id', array('1','2','3','4','5','6','7','8','10','12'));
        $this->db->from('iccr_mission_checklist');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function updateRemarks($data,$appid,$universityId) {
		//echo "<pre>";print_r($data);echo $universityId;'</br>';echo $appid;die;
        $this->db->where('application_id', $appid);
		$this->db->where('regional_university', $universityId);
        $this->db->update('iccr_university_status_mapping', $data);
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
	
	
	function updateUnivesityRemarks1($appno) {
		echo $appno;
        $data = array(
            'status' => 'Pending'
        );
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
	
	function missingDocs($universityId) {
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth ,iccr_student_other_details.created,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.universities_status' => 18,'iccr_status_mapping.status!=' =>6));
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	function getUniversityAcceptance($vars,$universityId,$year) {
		$this->db->select('iccr_status_mapping.status,iccr_status_mapping.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.nationality');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
        //$this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where(array('iccr_university_response.confirmed_to_mission =' =>1));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.scholar_acceptance'=>1));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        if($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
        }       
        if($vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }
        if($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        if($year == 2023){
            $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
            $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
        }
        if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
		if($year == 2025){
		//$this->db->where(array('iccr_status_mapping.created >=' => 1740787200));
		//$this->db->where(array('iccr_status_mapping.created <=' => 1767311999));
		$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
		$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
		}
		if($year == 2026){
			$this->db->where(array('iccr_status_mapping.created >='=> 1772150400));
			$this->db->where(array('iccr_status_mapping.created <='=> 1798761599));
}
        else{            
            
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_status_mapping.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_status_mapping.created <=', strtotime($vars['MaxDate']));
		}

        $this->db->limit($vars['length'],$vars['start']);
	   //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
	
	//Student Acceptance
	
	/*function getUniversityAcceptance($vars,$universityId,$year) {
		$this->db->select('iccr_status_mapping.status,iccr_status_mapping.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.nationality');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
        //$this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where(array('iccr_university_response.confirmed_to_mission =' =>1));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.scholar_acceptance'=>1));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        if($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
        }       
        if($vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }
        if($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        if($year == 2023){
            $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
            $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
        }
        if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
		if($year == 2025){
		//$this->db->where(array('iccr_status_mapping.created >=' => 1740787200));
		//$this->db->where(array('iccr_status_mapping.created <=' => 1767311999));
		$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
		$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
		}
		if($year == 2026){
			$this->db->where(array('iccr_status_mapping.created >='=> 1772150400));
			$this->db->where(array('iccr_status_mapping.created <='=> 1798761599));
} 
        else{            
            
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_status_mapping.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_status_mapping.created <=', strtotime($vars['MaxDate']));
		}

        $this->db->limit($vars['length'],$vars['start']);
	   //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }*/
	
	   function getTotalUniversityAcceptance($vars,$universityId,$year)
    {
		$this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
       // $this->db->select('iccr_status_mapping.status,iccr_status_mapping.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.nationality');
        //$this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $this->db->where('iccr_university_response.regional_university', $universityId);
        //$this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where(array('iccr_university_response.confirmed_to_mission =' =>1));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.scholar_acceptance'=>1));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
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
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        if($year == 2023){
            $this->db->where(array('iccr_status_mapping.created >='=> 1680369394));
            $this->db->where(array('iccr_status_mapping.created <='=> 1704046594));
        }
        if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
		if($year == 2025){
    $this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
    $this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
}
	if($year == 2026){
    $this->db->where(array('iccr_status_mapping.created >='=> 1767225600));
    $this->db->where(array('iccr_status_mapping.created <='=> 1798761599));
} 
 
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_status_mapping.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_status_mapping.created <=', strtotime($vars['MaxDate']));
		}
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
	} 
	
	public function __destruct() {
    $this->db->close();
}
	
	
}

?>
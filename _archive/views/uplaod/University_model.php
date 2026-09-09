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
       
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_details.created <=', strtotime($vars['MaxDate']));
		}
		
		
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
       
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
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
	
	public function checkStatus($appid){
		
	   $sql = "select status from iccr_status_mapping where status = 4 and id = '".$appid."'" ;
	   $rs = $this->db->query($sql)->row();
	   if($rs > 0){
            return true;
		}else{
			
			return false;
		}       
	}
	
	function updateTextMarks($data,$appid) {
        $this->db->where('id', $appid);
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
	
	
	function getCountUniversityApplications($universityId) {

        $this->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
        $this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
		
		
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $this->db->count_all_results();
        return $countRowQuery;
    }
	
}

?>
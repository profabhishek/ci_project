<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mission_model extends CI_Model {

    public $status;
    public $roles;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }
	
	
		function getMissionApplicationsAlert($missionId) {
			//echo "<pre>";print_r($missionId);
        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.application_no,iccr_status_mapping.universities_status,iccr_student_details.created');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status'=> 1, 'iccr_status_mapping.mission_status' => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
		//$this->db->where(array('iccr_student_details.created >=',1575158400));
		//$this->db->where('iccr_student_details.created >=', strtotime($vars['MinDate']));
		//$this->db->where('iccr_status_mapping.created > DATE_SUB(lastLoginTimestamp, INTERVAL 7 DAY));
		//$this->db->where('iccr_status_mapping.created BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
	
 	function getMissionForwordApplication(){
$sql = "SELECT `iccr_countries`.`country_name` ,`iccr_missions`.`mission_name`,`iccr_missions`.`mission_email` ,`iccr_countries`.`country_name`,
count(iccr_status_mapping.status) as Total FROM `iccr_status_mapping`
 JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
 JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
 JOIN `iccr_student_details` ON `iccr_student_details`.`uid` = `iccr_status_mapping`.`uid`
 JOIN `iccr_missions` ON `iccr_missions`.`id` =`iccr_student_other_details`.`application_through` 
 JOIN `iccr_countries` ON `iccr_student_other_details`.`mission_made_through` = `iccr_countries`.`id` WHERE `iccr_status_mapping`.`status` IN(4, 5) 
 AND `iccr_student_other_details`.`created` >= 1575158400 group by iccr_missions.mission_email";
return $this->db->query($sql)->result_array();
		
	} 
	
		function getMissionForwordApplicationdemo($nowtime){
$sql = "SELECT `iccr_countries`.`country_name` ,`iccr_missions`.`mission_name`,`iccr_missions`.`mission_email` ,`iccr_countries`.`country_name`,
count(iccr_status_mapping.status) as Total FROM `iccr_status_mapping`
 JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
 JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
 JOIN `iccr_student_details` ON `iccr_student_details`.`uid` = `iccr_status_mapping`.`uid`
 JOIN `iccr_missions` ON `iccr_missions`.`id` =`iccr_student_other_details`.`application_through` 
 JOIN `iccr_countries` ON `iccr_student_other_details`.`mission_made_through` = `iccr_countries`.`id` WHERE `iccr_status_mapping`.`status` IN(4, 5) 
 AND `iccr_student_other_details`.`created` >= 1575158400 AND `iccr_student_other_details`.`created` <= ".$nowtime." group by iccr_missions.mission_email";
return $this->db->query($sql)->result_array();
		
	}
	
	function getMissionApplications($vars,$missionId,$cuntryid) {
		
        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.application_no,iccr_status_mapping.universities_status,iccr_student_details.created,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "" || $vars['Country'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
		}
        // $this->db->where(array('iccr_status_mapping.status >=', 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
        // $this->db->where_in('iccr_student_other_details.application_through', $missionId);     

		 $this->db->where(array('iccr_status_mapping.status >=' => 1,"iccr_status_mapping.mission_status>=" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1,'iccr_student_other_details.mission_made_through'=>$cuntryid));
        
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
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] .' )');
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_details.created <=', strtotime($vars['MaxDate']));
		}
		$this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $this->db->limit($vars['length'],$vars['start']);
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
    function getTotalMissionApplications($vars,$missionId,$cuntryid)
    {
		$this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "" || $vars['Country'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
		}
        $this->db->where(array('iccr_status_mapping.status >=' => 1,"iccr_status_mapping.mission_status>=" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1,'iccr_student_other_details.mission_made_through'=>$cuntryid));
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
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] . ')');
        }
		 if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
        $code = $this->db->error();
        if ($code['code'] > 0) {
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
		
	   $sql = "select status from iccr_status_mapping where status = 11 and application_no = '".$appid."'" ;
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



		function updateVisaPermission($data,$appid) {
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
	
}

?>
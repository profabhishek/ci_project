<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hqrs_model extends CI_Model {

    public $status;
    public $roles;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }
	 function getHqrsAllNewApplication($schemeids,$vars,$year) {
	
		//print_r($vars);
		$this->db->distinct('iccr_university_response.application_id');
        $this->db->select('iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.status,iccr_status_mapping.scholarship_id,iccr_status_mapping.application_no,iccr_student_other_details.created,iccr_status_mapping.created as SubmitDate,iccr_status_mapping.universities_status,iccr_student_details.student_type,iccr_student_details.apply_course_type');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "" || $vars['Country'] != "" || $vars['Scheme'] != "" || $vars['Confirmed'] != "")
        {
			//$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
			$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	
		}
        //$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        //$this->db->where(array('iccr_status_mapping.status >=' => 4));
		$this->db->where(array('iccr_status_mapping.status >=' => 1));
		//$this->db->where(array('iccr_student_application_details.course_type !=' => 1));
		//$this->db->where(array('iccr_status_mapping.universities_status >=' => -1));
		//$this->db->where(array('iccr_status_mapping.status !=' => 5));
		$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
			$this->db->where(array('iccr_status_mapping.created <='=> 1680305602));
		}
		if($year == 2023){
			$this->db->where(array('iccr_status_mapping.created >='=> 1680315898));
			$this->db->where(array('iccr_status_mapping.created <='=> 1703979202));
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
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		$this->db->order_by('iccr_status_mapping.created', 'DESC');
		if ($vars['Application'] != "") {
            $this->db->like('iccr_student_application_details.application_no', $vars['Application']);
			
        }
			if ($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
			
			
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
            //$this->db->where('iccr_student_application_details.course',$vars['Counrse']);
			$this->db->where(' (iccr_student_application_details.course=' . $vars['Counrse'] . ' or iccr_student_application_details.course_two=' . $vars['Counrse'] . ' or iccr_student_application_details.course_three=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fourth=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fifth=' . $vars['Counrse'] . ')');
			
        }  
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] . ')');
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
		/* if ($vars['Region'] != "") {
          
		   $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $vars['Region'] . ' or iccr_student_application_details.university_choice_two_state=' . $vars['Region'] . ' or iccr_student_application_details.university_choice_three_state=' . $vars['Region'] . ' or iccr_student_application_details.university_choice_fourth_state=' . $vars['Region'] . ' or iccr_student_application_details.university_choice_fifth_state=' . $vars['Region'] . ')');
        } */
		if ($vars['Confirmed'] == 4) {
				$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
				$this->db->where(array('iccr_university_response.fee_structure !=' => NULL));
				
			}
		if ($vars['Confirmed'] == 10) {
				$this->db->where(array('iccr_student_application_details.course_type =' => 1));
			}
		else{
			$this->db->where(array('iccr_student_application_details.course_type !=' => 1));
		}
		if ($vars['Confirmed'] == 11) {
				$this->db->where(array('iccr_student_details.apply_course_type =' => 11));
				
			}
		else{
			$this->db->where(array('iccr_student_details.apply_course_type !=' => 11));
		}
		if ($vars['Confirmed'] == 12) {
				$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
				$this->db->where(array('iccr_university_response.university_is_accept =' => 1));
			}
		if ($vars['Confirmed'] == 13) {
				$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
				$this->db->where(array('iccr_university_response.university_is_accept =' => 2));
				
			}
		if ($vars['Confirmed'] == 2) {
				$this->db->where(array('iccr_student_application_details.course_type =' => 2));
				$this->db->where(array('iccr_status_mapping.status >=' => 1));
			}	
		
 		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
        $this->db->limit($vars['length'],$vars['start']);
		//$this->db->limit(0,20);
		$this->db->order_by('iccr_status_mapping.created','DESC');
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
    function getHqrsAllTotalNewApplication($schemeids,$vars,$year) {
		$this->db->distinct('iccr_university_response.application_id');
        $this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');      
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');  
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		 if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "" || 
		 $vars['Country'] != "" || $vars['Scheme'] != "" || $vars['Confirmed'] != "")
        {
			//$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
			$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		}
		 if ($vars['Application'] != "") {
            $this->db->like('iccr_student_application_details.application_no', $vars['Application']);
			
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
            //$this->db->where('iccr_student_application_details.course',$vars['Counrse']);
			$this->db->where(' (iccr_student_application_details.course=' . $vars['Counrse'] . ' or iccr_student_application_details.course_two=' . $vars['Counrse'] . ' or iccr_student_application_details.course_three=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fourth=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fifth=' . $vars['Counrse'] . ')');
        }  
       if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        } 
		/* if ($vars['Region'] != "") {
          
		   $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $vars['Region'] . ' or iccr_student_application_details.university_choice_two_state=' . $vars['Region'] . ' or iccr_student_application_details.university_choice_three_state=' . $vars['Region'] . ' or iccr_student_application_details.university_choice_fourth_state=' . $vars['Region'] . ' or iccr_student_application_details.university_choice_fifth_state=' . $vars['Region'] . ')');
        } */
		if ($vars['Confirmed'] == 4) {
				$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
				$this->db->where(array('iccr_university_response.fee_structure !=' => NULL));
				
			}
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] . ')');
        }
		if ($vars['Confirmed'] == 10) {
				$this->db->where(array('iccr_student_application_details.course_type =' => 1));
			}
		else{
			$this->db->where(array('iccr_student_application_details.course_type !=' => 1));
		}
		if ($vars['Confirmed'] == 11) {
				$this->db->where(array('iccr_student_details.apply_course_type =' => 11));
			}
		else{
			$this->db->where(array('iccr_student_details.apply_course_type !=' => 11));
		}
		if ($vars['Confirmed'] == 12) {
				$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
				$this->db->where(array('iccr_university_response.university_is_accept =' => 1));
			}
		if ($vars['Confirmed'] == 13) {
				$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
				$this->db->where(array('iccr_university_response.university_is_accept =' => 2));
			}
			if ($vars['Confirmed'] == 2) {
				$this->db->where(array('iccr_student_application_details.course_type =' => 2));
				$this->db->where(array('iccr_status_mapping.status >=' => 1));
			}
		
		//$this->db->where(array('iccr_student_application_details.course_type !=' => 1));
        //$this->db->where(array('iccr_status_mapping.status >=' => 4));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
			$this->db->where(array('iccr_status_mapping.created <='=> 1680305602));
		}
		if($year == 2023){
			$this->db->where(array('iccr_status_mapping.created >='=> 1680315898));
			$this->db->where(array('iccr_status_mapping.created <='=> 1703979202));
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
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->order_by('iccr_status_mapping.created','DESC');
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
        return $this->db->get()->result_array();
    }
    function getHqrsNewApplication($schemeids,$vars,$year) {
	
		//print_r($vars);
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.scholarship_id,iccr_status_mapping.application_no,iccr_student_other_details.created,iccr_status_mapping.created as SubmitDate,iccr_status_mapping.universities_status');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "" || $vars['Country'] != "" || $vars['Scheme'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
			$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	
		}
        //$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		//$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        //$this->db->where(array('iccr_status_mapping.status >=' => 4));
		//$this->db->where(array('iccr_student_application_details.course_type !=' => 1));
		$this->db->where(array('iccr_status_mapping.status >=' => 1));
		//$this->db->where(array('iccr_status_mapping.status !=' => 5));
		//$this->db->where(array('iccr_status_mapping.status !=' => 6));
		//$this->db->where(array('iccr_status_mapping.status !=' => 15));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		if($year == 2020){
		$this->db->where(array('iccr_status_mapping.created >='=> 1575158400));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		}
		if($year == 2019){
			$this->db->where(array('iccr_student_other_details.created >='=> 1544812200));
		    $this->db->where(array('iccr_student_other_details.created <='=> 1576368000));
		}
		if($year == 2018){
			$this->db->where(array('iccr_student_other_details.created <='=> 1544812200));
			//$this->db->group_by('iccr_status_mapping.application_no');
		  
		}
		$this->db->group_by('iccr_status_mapping.application_no');
		//$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		if ($vars['Application'] != "") {
            $this->db->like('iccr_status_mapping.application_no', $vars['Application']);
			
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
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
 		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		
        $this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
    function getHqrsTotalNewApplication($schemeids,$vars,$year) {
		 //$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('count(DISTINCT(iccr_status_mapping.application_no)) as total');
        $this->db->from('iccr_status_mapping');      
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');  
		 if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "" || $vars['Country'] != "" || $vars['Scheme'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
			$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		}
		if ($vars['Application'] != "") {
            $this->db->like('iccr_status_mapping.application_no', $vars['Application']);
			
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
       if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        } 
		  
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
		$this->db->where(array('iccr_status_mapping.status >=' => 1));
		
		//$this->db->where(array('iccr_student_application_details. !=' => 1));
		//$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		if($year == 2020){
		$this->db->where(array('iccr_status_mapping.created >='=> 1575158400));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		}
		if($year == 2019){
			$this->db->where(array('iccr_student_other_details.created >='=> 1544812200));
		    $this->db->where(array('iccr_student_other_details.created <='=> 1576368000));
		}
		if($year == 2018){
			$this->db->where(array('iccr_student_other_details.created <='=> 1544812200));
			//$this->db->group_by('iccr_status_mapping.application_no');
		  
		}
		
        //$this->db->where(array('iccr_status_mapping.status >=' => 4));
        //$this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
        return $this->db->get()->result_array();
    }
	
	
	
	function getAllStudentData($year,$data) {
		
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct();
		$this->db->select('iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.gender,iccr_student_application_details.course_type,iccr_student_application_details.email,iccr_countries.country_name,iccr_university_response_by_hqrs.region_one_status_date,iccr_student_other_details.application_through,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_status_mapping.final_course,iccr_university_response_by_hqrs.regional_university AS regional_university_ayush,iccr_university_response_by_hqrs.region_one_status AS region_one_status_ayush,iccr_student_application_details.phone_number,iccr_student_application_details.whatsapp_number,iccr_student_application_details.passport_no,iccr_student_application_details.passport_issue_date,iccr_student_application_details.passport_expiry_date,iccr_student_application_details.passport_issue_place,iccr_student_application_details.acedemic_year,iccr_student_application_details.city,iccr_status_mapping.visa_no,iccr_status_mapping.visa_isuue_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.undertaking_doc,iccr_university_response_by_hqrs.date_of_joining AS date_of_joining_ayush,iccr_university_response_by_hqrs.duration_of_course AS duration_of_course_ayush,iccr_travelplan.travel_arrival_date,iccr_travelplan.new_travel_date,iccr_university_response.regional_university AS regional_university,iccr_university_response.region_one_status AS region_one_status,iccr_university_response.date_of_joining AS date_of_joining,iccr_university_response.duration_of_course');
		$this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->where(array('iccr_status_mapping.status >=' => $status));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->group_start(); // Grouping conditions
		$this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
		$this->db->or_where(array('iccr_university_response_by_hqrs.university_is_accept=' => 1));
		$this->db->group_end(); // End of grouping
		// $this->db->where('iccr_status_mapping.scholar_acceptance', 1);
		$this->db->group_start(); // Grouping conditions
		$this->db->where('iccr_university_response.confirmed_to_mission', 1);
		$this->db->or_where('iccr_university_response_by_hqrs.university_is_accept', 1);
		$this->db->group_end(); // End of grouping
		$this->db->order_by("iccr_university_response_by_hqrs.id", 'ASC');
		$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');

		// Manoj start

		// $this->db->group_start();  // Grouping this OR condition
		// $this->db->where('iccr_university_response.regional_university !=', 990); // Exclude 990
		// $this->db->or_where('iccr_university_response.regional_university =', 990); // Include 990
		// $this->db->group_end();  // End of grouping

		
		// $this->db->where(array('iccr_university_response.regional_university !=' => 990));


		// $this->db->group_start();  // Grouping this OR condition
		/*

		$this->db->or_where(array('iccr_university_response.application_id =' => 'GA2119864686576'));
		// $this->db->or_where(array('iccr_university_response.application_id =' => 'QH9346266669319'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'GM9955745492954'));

		$this->db->or_where(array('iccr_university_response.application_id =' => 'GU2053553886820'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'VM9560735315725'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'RH4219445604137'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'JC8710868461568'));
		// $this->db->or_where(array('iccr_university_response.application_id =' => 'PS6936999714884'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'OQ9974393140447'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'KZ3675404581066'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'EG6550526112833'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'SZ6129092893898'));

		$this->db->or_where(array('iccr_university_response.application_id =' => 'TP9536975400392'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'OP1946898069795'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'IK8531725548084'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'XH7661204186211'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'PE2527264380090'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'UJ1505675264455'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'ZC2627311175469'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'XL8564911769445'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'RF0009700616300'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'UN5270466173694'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'MY7740817589057'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'GD8133137681550'));

		$this->db->or_where(array('iccr_university_response.application_id =' => 'TF0297888674490'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'YZ7209291822616'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'UR2267584685498'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'DG7843300957247'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'GX5806100660516'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'OZ3106815749978'));*/
		// $this->db->or_where(array('iccr_university_response.application_id =' => 'GD1214331655303')); 
		/* 
		$this->db->or_where(array('iccr_university_response.application_id =' => 'EI2566019097273'));

		$this->db->or_where(array('iccr_university_response.application_id =' => 'YW4511059597240'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'FU5603665414609'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'BT4712462006985'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'UE0496422252969'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'LU8139606239601'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'OP5835877025299'));

		$this->db->or_where(array('iccr_university_response.application_id =' => 'PC9895738947475'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'DD8596880850454'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'IO5530981756874'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'JH7504904871370'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'NO3349677480950'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'RO4793915127393'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'YC5076821615587'));

		$this->db->or_where(array('iccr_university_response.application_id =' => 'ZM4611604587956'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'AW4404317711147'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'IK9428497895617'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'JI7650146953407'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'KO7546755348824'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'UY1191161239851'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'HE0396114750321'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'JY9230844203041'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'JI7932004898741'));

		$this->db->or_where(array('iccr_university_response.application_id =' => 'AT4959370054081'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'ET3012991011957'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'PH5734030906707'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'IY4661991666348'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'DJ9124532449422'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'GU1006321301166'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'SP0685399590735'));

		$this->db->or_where(array('iccr_university_response.application_id =' => 'AT6727175689363'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'GD0037448772782'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'IJ1457401788804'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'SH3111654690627'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'UZ9759350956141'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'VF7486865343110'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'VX8708128711886'));
		$this->db->or_where(array('iccr_university_response.application_id =' => 'WL4465401223548'));

		 */
		// $this->db->group_end();  // End of grouping
		
						
		// $this->db->where(array('iccr_status_mapping.undertaking_doc >='=> 1727721000));
		// $this->db->where(array('iccr_status_mapping.undertaking_doc <='=> 1731004199));

		// Manoj end //
	
		// echo $this->db->_compile_select();exit;

			if (isset($vars['Region'])&&$vars['Region'] != "") {
				$this->db->where('iccr_university_response.region_one_status', $vars['Region']);
			}

		if($year == 2023){
			$this->db->where(array('iccr_status_mapping.created >='=> 1680315898));
			$this->db->where(array('iccr_status_mapping.created <='=> 1703979202));
		}
		if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
		if($year == 2025){
			$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
			$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
		}
		
        $code = $this->db->error(); 
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->get()->result_array();
    }


	function getSingleStudentData($year,$data,$application) {
		
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct();
		$this->db->select('iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_other_details.application_through,iccr_status_mapping.scholarship_id,iccr_university_response.lable_of_course,iccr_status_mapping.final_course,iccr_university_response.regional_university,iccr_university_response.region_one_status,iccr_student_application_details.phone_number,iccr_student_application_details.whatsapp_number,iccr_student_application_details.passport_no,iccr_student_application_details.passport_issue_date,iccr_student_application_details.passport_expiry_date,iccr_student_application_details.passport_issue_place,iccr_student_application_details.acedemic_year,iccr_student_application_details.city,iccr_status_mapping.visa_no,iccr_status_mapping.visa_isuue_date,iccr_status_mapping.visa_to_date,iccr_travelplan.travel_arrival_date,iccr_university_response.date_of_joining,iccr_university_response.duration_of_course,iccr_status_mapping.undertaking_doc');
		//,iccr_travelplan.travel_arrival_date
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no','left');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_student_application_details.application_no' => $application));
		$this->db->where(array('iccr_status_mapping.status>=' => $status));
		$this->db->where(array('iccr_status_mapping.status!=' => 15));
        //$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		$this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
		$this->db->where(array('iccr_university_response.university_is_accept=' => 1));
		//$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->order_by("str_to_date('iccr_student_other_details.CREATED', '%Y-%m-%d'),'ASC'");
		//comment by adarsh//$this->db->group_by('iccr_university_response.application_id');
		$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');

		//echo $this->db->_compile_select();exit;

            $this->db->where('iccr_status_mapping.scholar_acceptance', 1);

			if (isset($vars['Region'])&&$vars['Region'] != "") {
				$this->db->where('iccr_university_response.region_one_status', $vars['Region']);
			}
		
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
			$this->db->where(array('iccr_status_mapping.created <='=> 1680305602));
		}
		if($year == 2023){
			$this->db->where(array('iccr_status_mapping.created >='=> 1680315898));
			$this->db->where(array('iccr_status_mapping.created <='=> 1703979202));
		}
		if($year == 2024){
			$this->db->where(array('iccr_status_mapping.created >='=> 1711983082));
			$this->db->where(array('iccr_status_mapping.created <='=> 1735656682));
		}
		if($year == 2025){
			$this->db->where(array('iccr_status_mapping.created >='=> 1738378143));
			$this->db->where(array('iccr_status_mapping.created <='=> 1767149343));
		}
		
        $code = $this->db->error(); 
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->get()->result_array();

    }


	function getAllAyushData($year,$data) {

	$status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct();
		$this->db->select('iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_university_response_by_hqrs.region_one_status_date,iccr_student_other_details.application_through,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_status_mapping.final_course,iccr_university_response_by_hqrs.regional_university,iccr_university_response_by_hqrs.region_one_status,iccr_student_application_details.phone_number,iccr_student_application_details.whatsapp_number,iccr_student_application_details.passport_no,iccr_student_application_details.passport_issue_date,iccr_student_application_details.passport_expiry_date,iccr_student_application_details.passport_issue_place,iccr_student_application_details.acedemic_year,iccr_student_application_details.city,iccr_status_mapping.visa_no,iccr_status_mapping.visa_isuue_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.undertaking_doc,iccr_university_response_by_hqrs.date_of_joining AS date_of_joining_ayush,iccr_university_response_by_hqrs.duration_of_course,iccr_travelplan.travel_arrival_date,iccr_university_response.regional_university,iccr_university_response.region_one_status,iccr_university_response.date_of_joining AS date_of_joining,iccr_university_response.duration_of_course');
		$this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');
		$this->db->where(array('iccr_status_mapping.status >=' => $status));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->group_start(); // Grouping conditions
		$this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
		$this->db->or_where(array('iccr_university_response_by_hqrs.university_is_accept=' => 1));
		$this->db->group_end(); // End of grouping
		$this->db->where('iccr_status_mapping.scholar_acceptance', 1);
		$this->db->group_start(); // Grouping conditions
		$this->db->where('iccr_university_response.confirmed_to_mission', 1);
		$this->db->or_where('iccr_university_response_by_hqrs.university_is_accept', 1);
		$this->db->group_end(); // End of grouping
		$this->db->order_by("iccr_university_response_by_hqrs.id", 'ASC');

		// echo $this->db->_compile_select();exit;

			if (isset($vars['Region'])&&$vars['Region'] != "") {
				$this->db->where('iccr_university_response.region_one_status', $vars['Region']);
			}
		
		if($year == 2023){
			$this->db->where(array('iccr_status_mapping.created >='=> 1680315898));
		}
		
        $code = $this->db->error(); 
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->get()->result_array();
	}




	function getAllAyushData1($year,$data) {
		
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct();
		$this->db->select('iccr_student_application_details.application_no,iccr_student_application_details.fullname');
		//,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_other_details.application_through,iccr_status_mapping.scholarship_id,iccr_university_response.lable_of_course,iccr_status_mapping.final_course,iccr_university_response.regional_university,iccr_university_response.region_one_status,iccr_student_application_details.phone_number,iccr_student_application_details.whatsapp_number,iccr_student_application_details.passport_no,iccr_student_application_details.passport_issue_date,iccr_student_application_details.passport_expiry_date,iccr_student_application_details.passport_issue_place,iccr_student_application_details.acedemic_year,iccr_student_application_details.city,iccr_status_mapping.visa_no,iccr_status_mapping.visa_isuue_date,iccr_status_mapping.visa_to_date,iccr_university_response.date_of_joining,iccr_university_response.duration_of_course,iccr_status_mapping.undertaking_doc,iccr_university_response_by_hqrs.region_one_status_date');
		//$this->db->select('iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_other_details.application_through,iccr_status_mapping.scholarship_id,iccr_university_response.lable_of_course,iccr_status_mapping.final_course,iccr_university_response.regional_university,iccr_university_response.region_one_status,iccr_student_application_details.phone_number,iccr_student_application_details.whatsapp_number,iccr_student_application_details.passport_no,iccr_student_application_details.passport_issue_date,iccr_student_application_details.passport_expiry_date,iccr_student_application_details.passport_issue_place,iccr_student_application_details.acedemic_year,iccr_student_application_details.city,iccr_status_mapping.visa_no,iccr_status_mapping.visa_isuue_date,iccr_status_mapping.visa_to_date,iccr_university_response.date_of_joining,iccr_university_response.duration_of_course,iccr_status_mapping.undertaking_doc,iccr_university_response_by_hqrs.region_one_status_date');
		//,iccr_travelplan.travel_arrival_date,iccr_travelplan.travel_arrival_date
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		//$this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no','left');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
		//$this->db->where(array('iccr_status_mapping.status!=' => 15));
        //$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		$this->db->where(array('iccr_university_response_by_hqrs.confirmed_to_mission=' => -1));
		$this->db->where(array('iccr_university_response_by_hqrs.university_is_accept=' => 1));
		//$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->order_by("str_to_date('iccr_student_other_details.CREATED', '%Y-%m-%d'),'ASC'");
		//comment by adarsh//$this->db->group_by('iccr_university_response.application_id');
		$this->db->order_by("iccr_university_response_by_hqrs.region_one_status_date",'DESC');

		echo $this->db->_compile_select();exit;

           // $this->db->where('iccr_status_mapping.scholar_acceptance', 1);

			// if (isset($vars['Region'])&&$vars['Region'] != "") {
			// 	$this->db->where('iccr_university_response.region_one_status', $vars['Region']);
			// }
		
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
			$this->db->where(array('iccr_status_mapping.created <='=> 1680305602));
		}
		if($year == 2023){
			$this->db->where(array('iccr_status_mapping.created >='=> 1680315898));
		}
		
        $code = $this->db->error(); 
        if ($code['code'] > 0) {
            //show_error('Message');
        }

        return $this->db->get()->result_array();

    }


	
	
	function getUniversityResponseSentByHqrsToMission($year,$vars,$data) {
		
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.status,iccr_status_mapping.uid,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_student_application_details.phone_number,iccr_student_application_details.whatsapp_number,iccr_student_application_details.passport_no,iccr_student_application_details.passport_issue_date,iccr_student_application_details.passport_expiry_date,iccr_student_application_details.passport_issue_place,iccr_student_application_details.acedemic_year,iccr_student_application_details.city,iccr_countries.country_name,iccr_status_mapping.created as SubmitDate,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.region_one_doc,iccr_university_response.course,iccr_student_other_details.created,iccr_status_mapping.iccr_status_date,iccr_university_response.regional_university,iccr_university_response.confirmed_course,iccr_university_response.date_of_joining,iccr_university_response.duration_of_course,iccr_university_response.university_is_accept,iccr_university_response.region_one_status,iccr_university_response.fee_structure,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.undertaking_doc,iccr_status_mapping.final_course,iccr_status_mapping.visa_no,iccr_status_mapping.visa_isuue_date,iccr_status_mapping.visa_to_date,iccr_travelplan.travel_arrival_date');
		//,iccr_travelplan.travel_arrival_date
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no','left');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
		$this->db->where(array('iccr_status_mapping.status!=' => 15));
        //$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		$this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
		$this->db->where(array('iccr_university_response.university_is_accept=' => 1));
		//$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->order_by("str_to_date('iccr_student_other_details.CREATED', '%Y-%m-%d'),'ASC'");
		//comment by adarsh//$this->db->group_by('iccr_university_response.application_id');
		$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');
		if (isset($vars['ApplicantName'])&&$vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
			
			
			}
		if (isset($vars['Application'])&&$vars['Application'] != "") {
            $this->db->like('iccr_status_mapping.application_no', $vars['Application']);
			
        }
		if (isset($vars['Mail'])&&$vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if (isset($vars['Programme'])&&$vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
        if (isset($vars['Counrse'])&&$vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
       if (isset($vars['Country'])&&$vars['Country'] != "") {
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
		if (isset($vars['Scheme'])&&$vars['Scheme'] != "") {
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        } 
		if (isset($vars['Region'])&&$vars['Region'] != "") {
			$this->db->where('iccr_university_response.region_one_status', $vars['Region']);
            //$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
        if (isset($vars['Universtiy'])&&$vars['Universtiy'] != "") {
			
			 $this->db->where('iccr_university_response.regional_university', $vars['Universtiy']);
            //$this->db->where(' (iccr_student_application_details.universty_choice='.$vars['Universtiy'].' or iccr_student_application_details.universty_choice_two='.$vars['Universtiy'].' or iccr_student_application_details.universty_choice_three='.$vars['Universtiy'].')');
        }
		if (isset($vars['Confirmed'])&&$vars['Confirmed'] == 1) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 1);
			} 
		if (isset($vars['Confirmed'])&&$vars['Confirmed'] == 2) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 2);
			} 
		if(isset($vars['MinDate'])&&$vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
			$this->db->where(array('iccr_status_mapping.created <='=> 1680305602));
		}
		if($year == 2023){
			$this->db->where(array('iccr_status_mapping.created >='=> 1680315898));
			$this->db->where(array('iccr_status_mapping.created <='=> 1703979202));
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
		
        $code = $this->db->error(); 
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//$this->db->limit(isset($vars['length'])&&$vars['length'],isset($vars['start'])&&$vars['start']);
		$this->db->limit($vars['length'],$vars['start']);
		//echo $this->db->_compile_select();
       //echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
		function getTotalUniversityResponseSentByHqrsToMission($year,$vars,$data) {
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('count(DISTINCT(iccr_status_mapping.application_no)) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
		$this->db->where(array('iccr_status_mapping.status!=' => 15));
		$this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
		//$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		$this->db->where(array('iccr_university_response.university_is_accept=' => 1));
        //$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		//$this->db->group_by('iccr_university_response.application_id');
		$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');
		if (isset($vars['Application'])&&$vars['Application'] != "") {
            $this->db->like('iccr_status_mapping.application_no', $vars['Application']);
			
        }
        if (isset($vars['ApplicantName'])&&$vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
			}
		if (isset($vars['Mail'])&&$vars['Mail'] != "") {
            $this->db->like('iccr_student_application_details.email', $vars['Mail']);
        }
        if (isset($vars['Programme'])&&$vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
        if (isset($vars['Counrse'])&&$vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
        if (isset($vars['Country'])&&$vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
		if (isset($vars['Scheme'])&&$vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        } 
		  
        if (isset($vars['Universtiy'])&&$vars['Universtiy'] != "") {
			  $this->db->where('iccr_university_response.regional_university', $vars['Universtiy']);
            //$this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
		if (isset($vars['Region'])&&$vars['Region'] != "") {
			$this->db->where('iccr_university_response.region_one_status', $vars['Region']);
            //$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_two_state=' . $this->input->post('Region') . ' or iccr_student_application_details.university_choice_three_state=' . $this->input->post('Region') . ')');
        }
		if (isset($vars['Confirmed'])&&$vars['Confirmed'] == 1) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 1);
			} 
		if (isset($vars['Confirmed'])&&$vars['Confirmed'] == 2) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 2);
			} 
		if(isset($vars['MinDate'])&&$vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
			$this->db->where(array('iccr_status_mapping.created <='=> 1675134592));
		}
		if($year == 2023){
			$this->db->where(array('iccr_status_mapping.created >='=> 1681096192));
			$this->db->where(array('iccr_status_mapping.created <='=> 1703979202));
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

		//echo $this->db->_compile_select();exit;
		//$this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	   function getRegionalApplicationsConfirmationtoHqrs($schemeids,$vars) {
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.course as courseconfirm,iccr_university_response.confirmed_to_mission,iccr_university_response.region_one_status_date');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_other_details','iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
        //$this->db->where(array('iccr_status_mapping.status' => 8));
		$this->db->where(array('iccr_status_mapping.status >=' => 8));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
        $this->db->order_by('iccr_university_response.id', 'DESC');
		
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
       if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        } 
		  
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		$this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	
	function getRegionalApplicationsTotalConfirmationtoHqrs($schemeids,$vars) {
        $this->db->distinct();
        $this->db->select('count(iccr_status_mapping.application_no) as total');
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
       if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        } 
		  
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        }
		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		//$this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	
	
	function getAllStudents(){
		
		$sql = "SELECT COUNT(a.username) as Total, a.user_country, a.email_id,c.country_name,a.created FROM `iccr_users` a 
                LEFT JOIN `iccr_countries` c ON a.user_country = c.id
                LEFT JOIN `iccr_student_details` ON `iccr_student_details`.`uid` =  a.id
                where date(a.created) >= date '2022-02-09' group by user_country";
		/* echo $sql;die;
		echo $this->db->_compile_select();exit; */
		$re = $this->db->query($sql)->result_array();
		return $re;
	}
	
		
	function getAllStudentsChart(){
		
		$sql = "SELECT COUNT(a.username) as Total, a.user_country, a.email_id,c.country_name,a.created FROM `iccr_users` a 
                LEFT JOIN `iccr_countries` c ON a.user_country = c.id
                LEFT JOIN `iccr_student_details` ON `iccr_student_details`.`uid` =  a.id
                where date(a.created) >= date '2018-12-15'";
		/* echo $sql;die;
		echo $this->db->_compile_select();exit; */
		$jsonResults =json_encode(array_column($this->db->query($sql)->result_array(), 'Total'),JSON_NUMERIC_CHECK);
		//echo $jsonResults;die;
		return $jsonResults;
	}
	
	function getMissionApplication(){
$sql = "SELECT count(iccr_status_mapping.application_no) as Total, `iccr_missions`.`mission_name`,`iccr_missions`.`mission_email`,`iccr_countries`.`country_name`
FROM `iccr_status_mapping` JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no`
JOIN `iccr_missions` ON `iccr_missions`.`id` =`iccr_student_other_details`.`application_through`
LEFT JOIN `iccr_student_details` ON `iccr_student_details`.`uid` =  `iccr_status_mapping`.`uid`
JOIN `iccr_countries` ON `iccr_student_other_details`.`mission_made_through` = `iccr_countries`.`id` 
WHERE `iccr_status_mapping`.`status`>= 1  AND `iccr_student_details`.`apply_course_type` !=11 AND `iccr_student_other_details`.`created` >= 1644471556";
//echo $sql;
return $this->db->query($sql)->result_array();
		
	}
	
	function getMissionApplicationChart($nowtime){
		$sql = "SELECT count(iccr_status_mapping.id) as Total, `iccr_missions`.`mission_name`,`iccr_missions`.`mission_email`,`iccr_countries`.`country_name`
		FROM `iccr_status_mapping` JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no`
		JOIN `iccr_missions` ON `iccr_missions`.`id` =`iccr_student_other_details`.`application_through`
		JOIN `iccr_countries` ON `iccr_student_other_details`.`mission_made_through` = `iccr_countries`.`id` 
		WHERE `iccr_status_mapping`.`status` = 1 AND `iccr_status_mapping`.`mission_status` = -1
		AND `iccr_status_mapping`.`iccr_status` = -1 AND `iccr_status_mapping`.`region_one_status` = -1 
		AND `iccr_status_mapping`.`region_two_status` = -1  AND `iccr_student_other_details`.`created` >= 1544812200 AND `iccr_student_other_details`.`created` <= ".$nowtime."";
		$jsonResults =json_encode(array_column($this->db->query($sql)->result_array(), 'Total'),JSON_NUMERIC_CHECK);
		//echo $jsonResults;die;
		return $jsonResults;
		
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
	
		
		function getMissionForwordApplicationChart($nowtime){
$sql = "SELECT `iccr_countries`.`country_name` ,`iccr_missions`.`mission_name`,`iccr_missions`.`mission_email` ,`iccr_countries`.`country_name`,
count(iccr_status_mapping.status) as Total FROM `iccr_status_mapping`
 JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
 JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
 JOIN `iccr_student_details` ON `iccr_student_details`.`uid` = `iccr_status_mapping`.`uid`
 JOIN `iccr_missions` ON `iccr_missions`.`id` =`iccr_student_other_details`.`application_through` 
 JOIN `iccr_countries` ON `iccr_student_other_details`.`mission_made_through` = `iccr_countries`.`id` WHERE `iccr_status_mapping`.`status` >= 4 and `iccr_status_mapping`.`status` !=5
 AND `iccr_student_other_details`.`created` >= 1544812200 AND `iccr_student_other_details`.`created` <= ".$nowtime."";
$jsonResults =json_encode(array_column($this->db->query($sql)->result_array(), 'Total'),JSON_NUMERIC_CHECK);
		//echo $jsonResults;die;
		return $jsonResults;
	}
	
	function getRoTotalApplication($nowtime){
		
		
		$sql = "Select r.name as RO, count(t1.id) as total from (SELECT iccr_status_mapping.id, `iccr_student_application_details`.`university_choice_one_state` as s1,`iccr_student_application_details`.`university_choice_two_state` as s2,`iccr_student_application_details`.`university_choice_three_state` as s3 FROM `iccr_status_mapping` JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` JOIN `iccr_student_details` ON `iccr_student_details`.`uid` = `iccr_status_mapping`.`uid` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id` WHERE `iccr_status_mapping`.`status` >= 4 AND `iccr_student_other_details`.`created` >= 1544812200 AND `iccr_student_other_details`.`created` <= ".$nowtime." ORDER BY `iccr_status_mapping`.`id` ASC) as t1 JOIN iccr_regions r on r.id = t1.s1 or r.id = t1.s2 or r.id=t1.s3 group by r.id";
		//echo $sql;die;
		return $this->db->query($sql)->result_array();
		
	}
	
	
	function getTotalApplicationForwordMission($nowtime){
		
		$sql = "SELECT DISTINCT COUNT(iccr_status_mapping.status) as Total, `iccr_student_application_details`.`application_no`,
 `iccr_student_application_details`.`fullname`, `iccr_student_application_details`.`email`, `iccr_countries`.`country_name`
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
 JOIN `iccr_university_response` ON `iccr_university_response`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
WHERE `iccr_status_mapping`.`status` >= 10 AND `iccr_status_mapping`.`iccr_status` = 1 AND `iccr_university_response`.`university_is_accept` = 1 AND `iccr_student_other_details`.`created` >= 1544832000 AND `iccr_student_other_details`.`created` <= ".$nowtime.""
;
	    //echo $sql;die;
		return $this->db->query($sql)->result_array();	
		
	}
	
	function getTotalApplicationForwordMissionChart($nowtime){
		
		$sql = "SELECT DISTINCT COUNT(iccr_status_mapping.status) as Total, `iccr_student_application_details`.`application_no`,
 `iccr_student_application_details`.`fullname`, `iccr_student_application_details`.`email`, `iccr_countries`.`country_name`
FROM `iccr_status_mapping` JOIN `iccr_student_application_details` ON `iccr_student_application_details`.`application_no` = `iccr_status_mapping`.`application_no` 
JOIN `iccr_countries` ON `iccr_student_application_details`.`nationality` = `iccr_countries`.`id`
 JOIN `iccr_university_response` ON `iccr_university_response`.`application_id` = `iccr_status_mapping`.`application_no`
JOIN `iccr_student_other_details` ON `iccr_student_other_details`.`application_no` = `iccr_status_mapping`.`application_no` 
WHERE `iccr_status_mapping`.`status` >= 10 AND `iccr_status_mapping`.`iccr_status` = 1 AND `iccr_university_response`.`university_is_accept` = 1 AND `iccr_student_other_details`.`created` >= 1544832000 AND `iccr_student_other_details`.`created` <= ".$nowtime.""
;
	 $jsonResults =json_encode(array_column($this->db->query($sql)->result_array(), 'Total'),JSON_NUMERIC_CHECK);
		//echo $jsonResults;die;
		return $jsonResults;
		
	}
	
	function getAcceptance($schemeids,$vars,$year) {
	
		
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.course,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.confirmed_course');
        $this->db->from('iccr_status_mapping');      
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');  
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		if($year == '2021'){
			$this->db->where(array('iccr_university_response.confirmed_to_mission' =>1));
			$this->db->where(array('iccr_university_response.university_is_accept' =>1));
		}
		$this->db->where(array('iccr_status_mapping.status >=' => 11));
		$this->db->where(array('iccr_status_mapping.scholar_acceptance' => 1));
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
		//$this->db->order_by('iccr_status_mapping.created', 'DESC');
		if ($vars['Application'] != "") {
            $this->db->like('iccr_student_application_details.application_no', $vars['Application']);
			
        }
			if ($vars['ApplicantName'] != "") {
            $this->db->like('iccr_student_application_details.fullname', $vars['ApplicantName']);
			
			
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
            //$this->db->where('iccr_student_application_details.course',$vars['Counrse']);
			$this->db->where(' (iccr_student_application_details.course=' . $vars['Counrse'] . ' or iccr_student_application_details.course_two=' . $vars['Counrse'] . ' or iccr_student_application_details.course_three=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fourth=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fifth=' . $vars['Counrse'] . ')');
			
        }  
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] . ')');
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
	
 		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		if($year == '2021'){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		}
        elseif($year == 2020){
		$this->db->where(array('iccr_student_other_details.created >='=> 1575158400));
		$this->db->where(array('iccr_student_other_details.created <='=> 1615749687));
		}
		elseif($year == 2019){
			$this->db->where(array('iccr_student_other_details.created >='=> 1544812200));
		    $this->db->where(array('iccr_student_other_details.created <='=> 1576368000));
		}
		elseif($year == 2018){
			$this->db->where(array('iccr_student_other_details.created <='=> 1544812200));
			//$this->db->group_by('iccr_status_mapping.application_no');
		  
		}
		$this->db->limit($vars['length'],$vars['start']);
		//$this->db->order_by('iccr_status_mapping.created','DESC');
	    //echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
	
        return $this->db->get()->result_array();
    }
	
    function getAcceptanceCount($schemeids,$vars,$year) {
		$this->db->distinct('iccr_university_response.application_id');
        $this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');      
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');  
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		//$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		$this->db->where(array('iccr_status_mapping.status >=' => 11));
		$this->db->where(array('iccr_status_mapping.scholar_acceptance' => 1));
		if($year == '2021'){
			$this->db->where(array('iccr_university_response.confirmed_to_mission' =>1));
			$this->db->where(array('iccr_university_response.university_is_accept' =>1));
			
		}
        $this->db->where_in('iccr_status_mapping.scholarship_id', $schemeids);
	
		
		 if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "" || 
		 $vars['Country'] != "" || $vars['Scheme'] != "" || $vars['Confirmed'] != "")
        {
			//$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
			$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		}
		 if ($vars['Application'] != "") {
            $this->db->like('iccr_student_application_details.application_no', $vars['Application']);
			
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
            //$this->db->where('iccr_student_application_details.course',$vars['Counrse']);
			$this->db->where(' (iccr_student_application_details.course=' . $vars['Counrse'] . ' or iccr_student_application_details.course_two=' . $vars['Counrse'] . ' or iccr_student_application_details.course_three=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fourth=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fifth=' . $vars['Counrse'] . ')');
        }  
       if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        } 
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        } 
		
		if($year == '2021'){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		}
		elseif($year == 2020){
		$this->db->where(array('iccr_status_mapping.created >='=> 1575158400));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		}
		elseif($year == 2019){
			$this->db->where(array('iccr_student_other_details.created >='=> 1544812200));
		    $this->db->where(array('iccr_student_other_details.created <='=> 1576368000));
		}
		elseif($year == 2018){
			$this->db->where(array('iccr_student_other_details.created <='=> 1544812200));
			//$this->db->group_by('iccr_status_mapping.application_no');
		  
		}
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		
        return $this->db->get()->result_array();
    }
	
	public function __destruct() {
    $this->db->close();
}
}

?>

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
	function getMissionApplications($vars,$missionId,$cuntryid,$year) {
		$this->db->distinct('iccr_status_mapping.application_no');
		$marray = array('1',NULL);
		if ($vars['Confirmed'] == -1) {
		$this->db->select('iccr_status_mapping.status ,iccr_status_mapping.application_no,iccr_student_details.created,iccr_university_response.region_one_status_date,iccr_student_application_details.course_type,iccr_status_mapping.created as SubmitDate');
		}
        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.application_no,iccr_student_details.created,iccr_student_application_details.course_type,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
       /*  if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
			
		} */
       
		
		
		//$this->db->where_in('iccr_student_details.course_year',NULL);
        $this->db->where('iccr_student_application_details.course_year', NULL);		
		
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);       
        //$this->db->where_in('iccr_student_details.student_type', $marray);  
        if ($vars['ApplicantName'] != "") {
            // iccr_student_application_details.fullname is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
        }
        if ($vars['Mail'] != "") {
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
        }
        if ($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
        if ($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
       
       if ($vars['Universtiy'] != "") {
		   // iccr_university_response is normally only joined a few lines below,
		   // and only when $vars['Confirmed'] == -1 - but this University filter
		   // can be used independently of that condition, so a search using this
		   // filter without Confirmed==-1 was referencing a table that was never
		   // joined into the query, causing MySQL's "Unknown column" error.
		   // Joining it here too (harmless if the later block also joins it,
		   // since CodeIgniter's query builder just adds another JOIN clause -
		   // duplicate identical joins are a MySQL no-op) guarantees the table
		   // is always present whenever this column is referenced.
		   $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
		   $this->db->where('iccr_university_response.regional_university', $vars['Universtiy']);
           // $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] . ')');
        }
		if ($vars['Confirmed'] == -1) {
			$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
            $this->db->where('iccr_university_response.confirmed_to_mission', $vars['Confirmed']);
			$this->db->where('iccr_university_response.university_is_accept	',1);
			$this->db->group_by('iccr_university_response.application_id');
			$this->db->order_by('iccr_university_response.region_one_status_date','ASC');
			}
		if ($vars['Confirmed'] == 10) {
				$this->db->where(array('iccr_student_application_details.course_type =' => 1));
				$this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.mission_status' => 1));
			}
			else{
				 $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.mission_status' => -1,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1));
			}
		/* if ($vars['Confirmed'] == 10) {
				$this->db->where(array('iccr_student_application_details.course_type =' => 1));
			}
		else{
			$this->db->where(array('iccr_student_application_details.course_type !=' => 1));
		} */
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		
		//if('iccr_student_application_details.programme' != 4)
		//{
					//$this->db->where('iccr_student_details.created >=', 1575158400);
			
		//}

		//$this->db->or_where('iccr_student_application_details.programme', 4);
		//
		if($year == 2021){
            $this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
            $this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
            }
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
		}
        // if($year == 2022){
        //     $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
        //     $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        // }
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
			 $this->db->where('iccr_status_mapping.created >=',1772150400);
			  $this->db->where('iccr_status_mapping.created <=',1798761599);
		}
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->order_by('iccr_status_mapping.created','DESC');
        $this->db->limit($vars['length'],$vars['start']);
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
    }
    function getTotalMissionApplications($vars,$missionId,$cuntryid,$year)
    {
		$marray = array('2',NULL);
		//$this->db->distinct('iccr_status_mapping.application_no');
		$this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->where('iccr_student_application_details.course_year', NULL);
		
       /*  if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
				
		} */
        //$this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.mission_status' => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1));
         if ($vars['ApplicantName'] != "") {
            // iccr_student_application_details.fullname is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
        }
        if ($vars['Mail'] != "") {
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
        }
        if ($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
        if ($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
       
       if ($vars['Universtiy'] != "") {
		   // Same missing-join fix as the sibling getMissionApplications() above -
		   // this filter can run independently of the Confirmed==-1 branch below
		   // that normally adds this join, so join it here too to guarantee the
		   // table is present whenever this column is referenced.
		   $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
		   $this->db->where('iccr_university_response.regional_university', $vars['Universtiy']);
            //$this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] . ')');
        }
        if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		if ($vars['Confirmed'] == -1) {
			$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
            $this->db->where('iccr_university_response.confirmed_to_mission', $vars['Confirmed']);
			$this->db->where('iccr_university_response.university_is_accept	',1);
			$this->db->group_by('iccr_university_response.application_id');
			$this->db->order_by('iccr_university_response.region_one_status_date','ASC');
			}
			if ($vars['Confirmed'] == 10) {
				$this->db->where(array('iccr_student_application_details.course_type =' => 1));
				$this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.mission_status' => 1));
			}
			else
			{
				 $this->db->where(array('iccr_status_mapping.status >=' => 1,'iccr_status_mapping.mission_status' => -1,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1,'iccr_status_mapping.region_five_status' => -1));
			}
		/* if ($vars['Confirmed'] == 10) {
				$this->db->where(array('iccr_student_application_details.course_type =' => 1));
			}
			else{
			$this->db->where(array('iccr_student_application_details.course_type !=' => 1));
		} */
        $this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//$this->db->order_by('iccr_status_mapping.created','DESC');
		//$this->db->where(array('iccr_student_application_details.course_type !=' => 1));
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		if($year == 2021){
            $this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
            $this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
        }
		if($year == 2022){
            $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
            $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        }
        // if($year == 2022){
        //     $this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
        //     $this->db->where(array('iccr_status_mapping.created <='=> 1680369394));
        // }
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
			$this->db->where('iccr_status_mapping.created >=',1772150400);
			  $this->db->where('iccr_status_mapping.created <=',1798761599);
		}

		//$this->db->where_in('iccr_student_details.student_type', $marray);  
		//$this->db->or_where('iccr_student_application_details.programme', 4);
		//$this->db->where('iccr_student_details.created >=', 1575158400);
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->result_array();
	} 
	
	function getMissionDemoApplications($vars,$missionId,$cuntryid) {
		
        $this->db->select('iccr_status_mapping.status ,iccr_status_mapping.application_no,iccr_status_mapping.universities_status,iccr_student_details.created,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		$this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
		}
        // $this->db->where(array('iccr_status_mapping.status >=', 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1));
        // $this->db->where_in('iccr_student_other_details.application_through', $missionId);     

		 $this->db->where(array('iccr_status_mapping.status >=' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_student_other_details.mission_made_through'=>$cuntryid));
		 
		 
		 
		 $this->db->where('iccr_status_mapping.created >=',1612227054); 
        
        if ($vars['ApplicantName'] != "") {
            // iccr_student_application_details.fullname is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
        }
        if ($vars['Mail'] != "") {
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
        }
        if ($vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
        if ($vars['Counrse'] != "") {
            $this->db->where('iccr_student_application_details.course',$vars['Counrse']);
        }  
       
        if ($vars['Universtiy'] != "") {
			 // This function never joins iccr_university_response anywhere else,
			 // so referencing this column unconditionally threw "Unknown column"
			 // for any search using this filter. Join it here, scoped to only
			 // when the filter is actually used, matching the pattern used for
			 // iccr_student_application_details a few lines above in this
			 // same function.
			 $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
			 $this->db->where('iccr_university_response.regional_university', $vars['Universtiy']);
            //$this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
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
    function getTotalMissionDemoApplications($vars,$missionId,$cuntryid)
    {
		$this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        if($vars['ApplicantName'] != "" || $vars['Mail'] != "" || $vars['Programme'] != "" || $vars['Counrse'] != "" || $vars['Universtiy'] != "")
        {
			$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');	
		}
        $this->db->where(array('iccr_status_mapping.status >=' => 1, "iccr_status_mapping.mission_status" => -1, 'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_student_other_details.mission_made_through'=>$cuntryid));
		$this->db->where('iccr_status_mapping.created >=',1612227054); 
         if ($vars['ApplicantName'] != "") {
            // iccr_student_application_details.fullname is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
        }
        if ($vars['Mail'] != "") {
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
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
		
	   $sql = "select status from iccr_status_mapping where status = 10 and id = '".$appid."'" ;
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
	
	function updateMissionOfferLetterDetails($data,$id,$appid) {
		//echo "<pre>";print_r($data);
		//echo "<pre>";print_r($id);
		//echo "<pre>";print_r($appid);
		//die;
        $this->db->where('id', $id);
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
	
	function getMissionAcceptance($vars,$missionId,$year) {
		$this->db->select('iccr_status_mapping.status,iccr_status_mapping.created,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_fourth,iccr_student_application_details.course_option_name_fifth,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.nationality');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_student_other_details.application_through', $missionId);
		//$this->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ')');
		$this->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        // $universityId is not supplied by the caller for this listing (it filters by
        // mission via $missionId instead), so guard against passing an undefined/null
        // value into the where clause which otherwise leaves a dangling comparison.
        if (isset($universityId) && $universityId != "") {
            $this->db->where('iccr_university_response.regional_university', $universityId);
        }
        //$this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where(array('iccr_university_response.confirmed_to_mission =' =>1));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.scholar_acceptance'=>1));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        if($vars['ApplicantName'] != "") {
            // iccr_student_application_details.fullname is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
        }       
        if($vars['Mail'] != "") {
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
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
	
	 function getTotalMissionAcceptance($vars,$missionId,$year)
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
        // $universityId is not supplied by the caller for this listing (it filters by
        // mission via $missionId instead), so guard against passing an undefined/null
        // value into the where clause which otherwise leaves a dangling comparison.
        if (isset($universityId) && $universityId != "") {
            $this->db->where('iccr_university_response.regional_university', $universityId);
        }
        //$this->db->where(array('iccr_status_mapping.status >=' => 10));
		$this->db->where(array('iccr_university_response.confirmed_to_mission =' =>1));
		$this->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.scholar_acceptance'=>1));
		//$this->db->where('iccr_status_mapping.created' >='1615749687');
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
         if ($vars['ApplicantName'] != "") {
            // iccr_student_application_details.fullname is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
        }
        if ($vars['Mail'] != "") {
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
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
	
	public function __destruct(){
		
		$this->db->close();
	}
	
}

?>
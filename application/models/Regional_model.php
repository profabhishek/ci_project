<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Regional_model extends CI_Model {

    public $status;
    public $roles;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }
	
	
	   function getArivalDetails($regionId,$vars) {
		  // echo "<pre>";
	//print_r($vars);
		$sql = "Select iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_other_details.created,
		iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,tt.region_one_status, tt.application_id,tt.region_one_status_date,tt.region_one_doc,tt.regional_university,tt.university_is_accept,tt.course,iccr_status_mapping.status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_travelplan.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_travelplan.travel_plan_doc,iccr_status_mapping.scholarship_id from ((SELECT t1.* FROM iccr_university_response as t1) UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2)) as tt 
join iccr_status_mapping on iccr_status_mapping.application_no = tt.application_id 
join iccr_student_other_details on iccr_student_other_details.application_no = iccr_status_mapping.application_no 
join iccr_student_application_details on iccr_student_application_details.application_no = iccr_status_mapping.application_no 
join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
join iccr_travelplan on iccr_travelplan.application_id = iccr_status_mapping.application_no and iccr_travelplan.status = iccr_status_mapping.status 
where iccr_status_mapping.status IN(13,14,-14) and tt.university_is_accept=1 and tt.region_one_status =".$regionId."";
		//echo $sql;die;
        if ($vars['ApplicantName'] != "") {
            // Same latin1_swedish_ci/utf8mb3_general_ci mismatch as everywhere else -
            // this function builds a raw SQL string instead of using the query
            // builder, so the fix has to be embedded directly in the string too.
            $sql .=" and (CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%') . ")";
			}
		//$this->db->order_by('iccr_student_other_details.created', 'ASC');
	
        /* if ($vars['Mail'] != "") {
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
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
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
 		 if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_details.created <=', strtotime($vars['MaxDate']));
		} 
		
        $this->db->limit($vars['length'],$vars['start']); */
		$sql .= " limit ".$vars['length'].",".$vars['start'];
		//echo $sql;die;
        $code = $this->db->error();
		if ($code['code'] > 0) {
            //show_error('Message');
        }
       return $this->db->query($sql)->result_array();
    }
 	
	
		 function getArivalDetails1($regionId,$vars) {
		  // echo "<pre>";
	//print_r($vars);
		
		$sql = "Select iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_other_details.created,
		iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,tt.region_one_status, tt.application_id,tt.region_one_status_date,tt.region_one_doc,tt.regional_university,tt.university_is_accept,tt.course,iccr_status_mapping.status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_travelplan.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_travelplan.travel_plan_doc,iccr_status_mapping.scholarship_id from ((SELECT t1.* FROM iccr_university_response as t1) UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2)) as tt 
join iccr_status_mapping on iccr_status_mapping.application_no = tt.application_id 
join iccr_student_other_details on iccr_student_other_details.application_no = iccr_status_mapping.application_no 
join iccr_student_application_details on iccr_student_application_details.application_no = iccr_status_mapping.application_no 
join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
join iccr_scheme on iccr_scheme.id = iccr_status_mapping.scholarship_id
join iccr_travelplan on iccr_travelplan.application_id = iccr_status_mapping.application_no and iccr_travelplan.status = iccr_status_mapping.status 
where iccr_status_mapping.status IN(13,14,-14) and tt.university_is_accept=1 and tt.region_one_status =".$regionId."";
		//echo $sql;die;
          if ($vars['ApplicantName'] != "") {
            // Same collation mismatch as the query builder fixes elsewhere - this
            // function uses a raw SQL string, so the CONVERT+COLLATE fix has to be
            // embedded directly in the concatenated string.
            $sql .=" and (CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%') . ")";
			}
        if ($vars['Mail'] != "") {
			 $sql .=" and (CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%') . ")";
        }
        if ($vars['Programme'] != "") {
			 $sql .=" and (iccr_student_application_details.programme like '%".$vars['Programme']."%')";
        }
        if ($vars['Counrse'] != "") {
			$sql .=" and (tt.course like '%".$vars['Counrse']."%')";
        }  
       /*  if ($vars['Universtiy'] != "") {
			$sql .=" and (iccr_student_application_details.course like '%".$vars['Counrse']."%')";
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        } */
		if ($vars['Country'] != "") {
			$sql .= " and iccr_student_application_details.country=".$vars['Country'];
        }  
		  if ($vars['Scheme'] != "") {
          
		   $sql .= " and iccr_scheme.id=".$vars['Scheme'];
        } 
 		 if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$sql .= " and iccr_student_details.created >=".strtotime($vars['MinDate']);
			$sql .= " and iccr_student_details.created <=".strtotime($vars['MaxDate']);
	
		}  
		
        $sql .= " limit ".$vars['start'].",".$vars['length'];
		//echo $sql;die;
		//echo $this->db->_compile_select();
        $code = $this->db->error();
		if ($code['code'] > 0) {
            //show_error('Message');
        }
       return $this->db->query($sql)->result_array();
    }
	
	  function getArrivalTotalDetails($regionId,$vars) {

        $sql = "Select count(iccr_status_mapping.application_no) as total, iccr_student_application_details.fullname,iccr_student_other_details.created,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,tt.region_one_status,tt.application_id,tt.region_one_status_date,tt.region_one_doc,tt.regional_university,tt.university_is_accept,tt.course,iccr_status_mapping.status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_travelplan.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_travelplan.travel_plan_doc,iccr_status_mapping.scholarship_id from ((SELECT t1.* FROM iccr_university_response as t1) UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2)) as tt 
join iccr_status_mapping on iccr_status_mapping.application_no = tt.application_id 
join iccr_student_other_details on iccr_student_other_details.application_no = iccr_status_mapping.application_no 
join iccr_student_application_details on iccr_student_application_details.application_no = iccr_status_mapping.application_no 
join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
join iccr_scheme on iccr_scheme.id = iccr_status_mapping.scholarship_id
join iccr_travelplan on iccr_travelplan.application_id = iccr_status_mapping.application_no and iccr_travelplan.status = iccr_status_mapping.status 
where iccr_status_mapping.status IN(13,14,-14) and tt.university_is_accept=1 and tt.region_one_status =".$regionId;
		
		 if ($vars['ApplicantName'] != "") {
            // Same collation mismatch as the query builder fixes elsewhere - this
            // function uses a raw SQL string, so the CONVERT+COLLATE fix has to be
            // embedded directly in the concatenated string.
            $sql .=" and (CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%') . ")";
			}
        if ($vars['Mail'] != "") {
			 $sql .=" and (CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%') . ")";
        }
       if ($vars['Counrse'] != "") {
			$sql .=" and (tt.course like '%".$vars['Counrse']."%')";
        } 
         
       /*  if ($vars['Universtiy'] != "") {
			$sql .=" and (iccr_student_application_details.course like '%".$vars['Counrse']."%')";
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ')');
        } */
		if ($vars['Country'] != "") {
			$sql .= " and iccr_student_application_details.country=".$vars['Country'];
        }  
		  if ($vars['Scheme'] != "") {
          
		   $sql .= " and iccr_scheme.id=".$vars['Scheme'];
        } 
 		 if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$sql .= " and iccr_student_details.created >=".strtotime($vars['MinDate']);
			$sql .= " and iccr_student_details.created <=".strtotime($vars['MaxDate']);
	
		}  
		
        //$sql .= " limit ".$vars['start'].",".$vars['length'];
		//echo $this->db->_compile_select();die;
        $code = $this->db->error();
		if ($code['code'] > 0) {
            //show_error('Message');
        }
       return $this->db->query($sql)->result_array();
    }
	
	
    function getRegionalApplications($regionId,$vars,$year) {
		//echo $year;die;
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.universty_choice_fourth,iccr_student_application_details.universty_choice_fifth,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_student_application_details.university_choice_fourth_state,iccr_student_application_details.university_choice_fifth_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_fourth,iccr_student_application_details.course_fifth,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject,iccr_student_details.apply_course_type,iccr_status_mapping.universities_status,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		 $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >=' =>1));
		//$this->db->where('iccr_student_details.student_type!=', 11);
		//$this->db->where(array('iccr_status_mapping.status !=' => 5));
		//$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='> 1644471556));
		}
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
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
		//$this->db->where('iccr_status_mapping.created' <='1615749687');
		//$this->db->where(array('iccr_student_application_details.universty_choice_fourth !=' => 489));
        //$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ')');
		$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' .$regionId .' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ')');
		
        $this->db->order_by('iccr_status_mapping.id', 'DESC');
		
		$this->db->order_by('iccr_student_application_details.fullname', 'ASC');
		//$this->db->group_by('iccr_status_mapping.application_no');
		// Guarded each of these with isset() - this function is called from more
		// than one place (see getNewApplicaitons() and others in Regional.php),
		// and not every caller's $vars array (built from $this->input->post())
		// is guaranteed to include every one of these optional filter keys.
		// Reading a missing key directly (e.g. $vars['Mail']) logged an
		// "Undefined array key" warning on every request that omitted it.
		if (isset($vars['ApplicantName']) && $vars['ApplicantName'] != "") {
            // iccr_student_application_details.fullname is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
			}
        if (isset($vars['Mail']) && $vars['Mail'] != "") {
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
        }
        if (isset($vars['Programme']) && $vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
         if (isset($vars['Counrse']) && $vars['Counrse'] != "") {
            //$this->db->where('iccr_student_application_details.course',$vars['Counrse']);
			$this->db->where(' (iccr_student_application_details.course=' . $vars['Counrse'] . ' or iccr_student_application_details.course_two=' . $vars['Counrse'] . ' or iccr_student_application_details.course_three=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fourth=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fifth=' . $vars['Counrse'] . ')');

        }
         if (isset($vars['Universtiy']) && $vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] . ')');
        }
		if (isset($vars['Country']) && $vars['Country'] != "") {

		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }
		if (isset($vars['Scheme']) && $vars['Scheme'] != "") {

		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
		if (isset($vars['Confirmed']) && $vars['Confirmed'] == 11) {
				$this->db->where(array('iccr_student_details.apply_course_type =' => 11));
			}
		else{
			$this->db->where(array('iccr_student_details.apply_course_type!=' => 11));
		}
 		 if (isset($vars['MinDate'], $vars['MaxDate']) && $vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		} 
        $this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
    $query = $this->db->get();
//echo $this->db->last_query();
//die();  

return $query->result_array();
    }
	
	  function getRegionalTotalNewApplication($regionId,$vars,$year) {
	    //$this->db->distinct('iccr_status_mapping.application_no');
		//$this->db->select('count(iccr_status_mapping.application_no) as total',false);
        $this->db->select('count(DISTINCT(iccr_status_mapping.application_no)) as total',false);
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		 //$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >=' =>1));
		//$this->db->where('iccr_student_details.student_type!=', 11);
		//$this->db->where(array('iccr_status_mapping.status !=' => 5));
		//$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->where(array('iccr_student_application_details.universty_choice_fourth !=' => 489));
        $this->db->where('(iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ')');
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		if($year == 2021){
			$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
			$this->db->where(array('iccr_status_mapping.created <='=> 1644471556));
		}
		if($year == 2022){
			$this->db->where(array('iccr_status_mapping.created >='=> 1644471556));
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
        //$this->db->order_by('iccr_status_mapping.id', 'ASC');
		//$this->db->order_by('iccr_student_other_details.created', 'ASC');
		//$this->db->group_by('iccr_student_application_details.application_no');
		// Same isset() guarding as getRegionalApplications() above, for the
		// same reason: not every caller's $vars includes every optional filter
		// key, and reading a missing one directly logged an "Undefined array
		// key" warning.
		if (isset($vars['ApplicantName']) && $vars['ApplicantName'] != "") {
            // iccr_student_application_details.fullname is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
			}
        if (isset($vars['Mail']) && $vars['Mail'] != "") {
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
        }
        if (isset($vars['Programme']) && $vars['Programme'] != "") {
            $this->db->where('iccr_student_application_details.programme', $vars['Programme']);
        }
          if (isset($vars['Counrse']) && $vars['Counrse'] != "") {
            //$this->db->where('iccr_student_application_details.course',$vars['Counrse']);
			$this->db->where(' (iccr_student_application_details.course=' . $vars['Counrse'] . ' or iccr_student_application_details.course_two=' . $vars['Counrse'] . ' or iccr_student_application_details.course_three=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fourth=' . $vars['Counrse'] . ' or iccr_student_application_details.course_fifth=' . $vars['Counrse'] . ')');

        }
        if (isset($vars['Universtiy']) && $vars['Universtiy'] != "") {
            $this->db->where(' (iccr_student_application_details.universty_choice=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_two=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_three=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fourth=' . $vars['Universtiy'] . ' or iccr_student_application_details.universty_choice_fifth=' . $vars['Universtiy'] . ')');
        }
		if (isset($vars['Country']) && $vars['Country'] != "") {

		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }
		if (isset($vars['Scheme']) && $vars['Scheme'] != "") {

		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
		if (isset($vars['Confirmed']) && $vars['Confirmed'] == 11) {
				$this->db->where(array('iccr_student_details.apply_course_type =' => 11));
			}
		else{
			$this->db->where(array('iccr_student_details.apply_course_type !=' => 11));
		}
 		if (isset($vars['MinDate'], $vars['MaxDate']) && $vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
       
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	
	
	function getRegionalPendingUniversityApplications($regionId,$vars) {
		//echo "<pre>";
		//print_r($vars);die;
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_other_details.created,iccr_student_application_details.fullname,iccr_student_application_details.middlename,iccr_student_application_details.familyname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		//$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_status_mapping.status', array(4));
        
        // $this->db->where('iccr_status_mapping.region_one_status <',1);
        $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ') ');
        $this->db->where(array('iccr_status_mapping.status >='=>4));
		$this->db->where(array('iccr_status_mapping.status !=' => 5));
		$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		$this->db->where(array('iccr_student_application_details.universty_choice_fourth !=' => 489));
		//$this->db->order_by('iccr_student_details.created', 'DESC');
		$this->db->order_by('iccr_status_mapping.id', 'DESC');
		
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
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
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
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Scheme'] != "") {
           $this->db->distinct('iccr_status_mapping.application_no');
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
 		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		$this->db->limit($vars['length'],$vars['start']);
		//echo $this->db->_compile_select();exit;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	function getRegionalPendingUniversityTotalApplications($regionId,$vars) {
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('count(DISTINCT(iccr_status_mapping.application_no)) as total');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        //$this->db->where_in('iccr_status_mapping.status', array(4));
        
        // $this->db->where('iccr_status_mapping.region_one_status <',1);
        $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' . $regionId . ') ');
        $this->db->where(array('iccr_status_mapping.status >='=>4));
		$this->db->where(array('iccr_status_mapping.status !=' => 5));
		$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		$this->db->where(array('iccr_status_mapping.created <='=> 1615749687));
		$this->db->where(array('iccr_student_application_details.universty_choice_fourth !=' => 489));
		//$this->db->order_by('iccr_student_details.created', 'ASC');
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
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
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
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Scheme'] != "") {
          $this->db->distinct('iccr_status_mapping.application_no');
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
 		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		}
		
        //echo $this->db->_compile_select();die;
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
		function getExpenditureDetails($appno) {
		//echo $appno;die;
        $this->db->select('*');
        $this->db->from('iccr_exp_advance_stipend');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	function getStipenedExpenditureDetails($appno) {
		//echo $appno;die;
        $this->db->select('*');
        $this->db->from('iccr_exp_stipend');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	
	function getAdvanceStipendDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_advance_stipend');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	function getHRADetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_hra');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
		function getACADetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_aca');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	function updateAdvanceStipenedExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_advance_stipend', $data);
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
	function updateStipenedExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
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
	
	
	function updateHostelExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_hostel', $data);
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
	
		function updateStudyTourExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_study_tour', $data);
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
	
	function getStipendDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_stipend');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	
	function getHostelDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_hostel');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	function getTourDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_study_tour');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	function getMedicalDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_study_tour');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	
	function getTutionDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_tution_fee');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	function getThesisDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_study_tour');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	function getMiscellDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_exp_miscellaneous');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	function updateHRAExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_hra', $data);
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
	function updateMedicalExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_medical_reimbursment', $data);
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
	
	function updateTutionExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_tution_fee', $data);
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
		function updateThesisExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_thesis_charges', $data);
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
	function updateMiscellaneousExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_miscellaneous', $data);
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
	
	
	
	function updateACAExpeDocuments($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_exp_aca', $data);
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
	
	function bonafideUpdateInfo($data,$appid) {
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
	
	
	function getBonafideDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_issue_documents');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	
	function getPromotedAcademicDetails($appno) {
		//echo "asdasdas";die;
        $this->db->select('*');
        $this->db->from('iccr_academic_staus');
        $this->db->where('id', $appno);
        $result = $this->db->get();
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $result->result_array();
    }
	
	function updatePromtedDetails($data,$appid) {
        $this->db->where('id', $appid);
        $this->db->update('iccr_academic_staus', $data);
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
	
			  function get_iccr_datatables_query($regionid,$vars = NULL)
    {
		//echo "<pre>";
		//print_r($vars);die;
		$minDate = strtotime($vars['MinDate']);
		$maxDate = strtotime($vars['MaxDate']);
		if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$sql = "Select (SELECT count(`iccr_status_mapping`.`application_no`) as totalStudents FROM `iccr_status_mapping` JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no
			JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
			WHERE `iccr_status_mapping`.`status` >= 4 AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND (`ad`.`university_choice_one_state` = ".$regionid." or `ad`.`university_choice_two_state` = ".$regionid." or `ad`.`university_choice_three_state` = ".$regionid.")) as totalCount, 
 
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no
 Where iccr_university_response.region_one_status = ".$regionid." AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND iccr_university_response.university_is_accept=2) as totalRejected,
 
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 4 AND `ur`.`region_one_status` = ".$regionid." AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.gender=1) as totalMale,

(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN  iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 4 AND `ur`.`region_one_status` = ".$regionid."  AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.gender=2) as totalFemale,


(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `ur`.`region_one_status` = ".$regionid."  AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=1) as totalUG,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `ur`.`region_one_status` = ".$regionid." AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=2) as totalPG,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND`ur`.`region_one_status` = ".$regionid." AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=3) as totalMphil,
(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 1 AND `ur`.`region_one_status` = ".$regionid." AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND ad.programme=4) as totalPHD,




(SELECT count(iccr_university_response.id) FROM iccr_university_response JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id JOIN iccr_student_other_details sd ON sd.application_no = iccr_status_mapping.application_no JOIN iccr_travelplan ON iccr_travelplan.application_id = iccr_university_response.application_id Where `iccr_university_response`.`region_one_status` = ".$regionid."  AND `sd`.`created` >= ".$minDate." AND `sd`.`created` <= ".$maxDate." AND iccr_travelplan.status=14 AND iccr_status_mapping.status=14 AND iccr_university_response.university_is_accept=1) as totalAdmitted";
//echo $sql;die;
		}
		else
		{
			
			$sql = "Select (SELECT count(`iccr_status_mapping`.`application_no`) as totalStudents FROM `iccr_status_mapping` JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no WHERE `iccr_status_mapping`.`status` >= 4 AND (`ad`.`university_choice_one_state` = ".$regionid." or `ad`.`university_choice_two_state` = ".$regionid." or `ad`.`university_choice_three_state` = ".$regionid.")) as totalCount,
			
			
			
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` 
 Where `iccr_university_response`.`region_one_status` = ".$regionid." AND  iccr_university_response.university_is_accept=1) as totalAccepted,
 
 
 
 
(SELECT count(iccr_university_response.id) FROM `iccr_university_response` JOIN `iccr_status_mapping` ON `iccr_status_mapping`.`application_no` = `iccr_university_response`.`application_id` 
 Where `iccr_university_response`.`region_one_status` = ".$regionid."  AND  iccr_university_response.university_is_accept=2) as totalRejected,
 
 
 
(SELECT count(`iccr_status_mapping`.`application_no`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 4 AND `ur`.`region_one_status` = ".$regionid." AND ad.gender=1) as totalMale,


(SELECT count(`iccr_status_mapping`.`application_no`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 4 AND `ur`.`region_one_status` = ".$regionid." AND ad.gender=2) as totalFemale,


(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 4 AND `ur`.`region_one_status` = ".$regionid." AND ad.programme=1) as totalUG,


(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 4 AND `ur`.`region_one_status` = ".$regionid." AND ad.programme=2) as totalPG,


(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 4 AND `ur`.`region_one_status` = ".$regionid." AND ad.programme=3) as totalMphil,


(SELECT count(`iccr_status_mapping`.`scholarship_id`) as totalStudents FROM `iccr_status_mapping`
JOIN iccr_student_application_details ad ON ad.application_no = iccr_status_mapping.application_no JOIN iccr_university_response ur ON ur.application_id = iccr_status_mapping.application_no
WHERE `iccr_status_mapping`.`status` >= 4 AND `ur`.`region_one_status` = ".$regionid." AND ad.programme=4) as totalPHD,


(SELECT count(iccr_university_response.id) FROM iccr_university_response JOIN iccr_status_mapping ON iccr_status_mapping.application_no = iccr_university_response.application_id JOIN iccr_travelplan ON iccr_travelplan.application_id = iccr_university_response.application_id Where `iccr_university_response`.`region_one_status` = ".$regionid."  AND iccr_travelplan.status=14 AND iccr_status_mapping.status=14 AND iccr_university_response.university_is_accept=1) as totalAdmitted";


//echo $sql;die;
		}
		$this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
		if ($code['code'] > 0) {
            //show_error('Message');
        }
      return $this->db->query($sql)->result_array();	
	}
	
	
	
	function getACATotalExp($regionid,$fy,$vars)
    {    
		//echo $fy;die;
		
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))  ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(aca_amount)as totalamount from iccr_exp_aca where regionId = ".$regionid."  group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}
		else
		{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))  ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(aca_amount)as totalamount from iccr_exp_aca where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";	
		//echo $sql;die;
			
		}
  		return $this->db->query($sql)->result_array();
	}
	function getAdvanceStipnedTotalExp($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))  ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(adv_stipend_amount)as totalamount from iccr_exp_advance_stipend where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))  ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(adv_stipend_amount)as totalamount from iccr_exp_advance_stipend where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  
  		return $this->db->query($sql)->result_array();
  		//echo $this->db->_compile_select();
	}
	function getCamps($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))) ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(camps_amount)as totalamount from iccr_exp_camps where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))) ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(camps_amount)as totalamount from iccr_exp_camps where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getDeduction($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ded_amount)as totalamount from iccr_exp_deductions where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ded_amount)as totalamount from iccr_exp_deductions where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getEmergencyFund($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ef_amount)as totalamount from iccr_exp_emergency_fund where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ef_amount)as totalamount from iccr_exp_emergency_fund where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
		
	}
  	return $this->db->query($sql)->result_array();
	}
	function getEngBridgeCourse($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ebc_amount)as totalamount from iccr_exp_english_bridge_course where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ebc_amount)as totalamount from iccr_exp_english_bridge_course where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getHostel($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))) ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(hos_amount)as totalamount from iccr_exp_hostel where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))) ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(hos_amount)as totalamount from iccr_exp_hostel where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
		
	}
  		return $this->db->query($sql)->result_array();
	}
	function getHRA($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(hra_amount)as totalamount from iccr_exp_hra where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}else
	{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(hra_amount)as totalamount from iccr_exp_hra where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getisaMeeting($regionid,$fy)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(isa_amount)as totalamount from iccr_exp_isa_meeting where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}else{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(isa_amount)as totalamount from iccr_exp_isa_meeting where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getmedicalReEmbust($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(mr_amount)as totalamount from iccr_exp_medical_reimbursment where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
  
	}
	else{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(mr_amount)as totalamount from iccr_exp_medical_reimbursment where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getMicsellanious($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(msc_amount)as totalamount from iccr_exp_miscellaneous where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}else{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(msc_amount)as totalamount from iccr_exp_miscellaneous where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getMisUniversity($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(uni_msc_amount)as totalamount from iccr_exp_miscellaneous_university where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
  else{
	  
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(uni_msc_amount)as totalamount from iccr_exp_miscellaneous_university where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
  }
  		return $this->db->query($sql)->result_array();
	}
	function getNationalDay($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(nd_amount)as totalamount from iccr_exp_national_day where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}else{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(nd_amount)as totalamount from iccr_exp_national_day where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getOrientProg($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(op_amount)as totalamount from iccr_exp_orientation_programme where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$$vars['Fyear']."'";
	}else{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(op_amount)as totalamount from iccr_exp_orientation_programme where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getOtherFee($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ocf_amount)as totalamount from iccr_exp_other_fee where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
  else{
	  
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ocf_amount)as totalamount from iccr_exp_other_fee where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
  }
  		return $this->db->query($sql)->result_array();
	}
	function getStipned($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(amount)as totalamount from iccr_exp_stipend where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
  else
  {
	  
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(amount)as totalamount from iccr_exp_stipend where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
  }
  		return $this->db->query($sql)->result_array();
		
	}
	function getStudentDay($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(sd_amount)as totalamount from iccr_exp_student_day where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}else{
			
			$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(sd_amount)as totalamount from iccr_exp_student_day where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
		}
  		return $this->db->query($sql)->result_array();
	}
	function getStudyTour($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(st_amount)as totalamount from iccr_exp_study_tour where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}
  else
  {
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(st_amount)as totalamount from iccr_exp_study_tour where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
  }
  		return $this->db->query($sql)->result_array();
	}
	function getSump($regionid,$fy)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(sump_amount)as totalamount from iccr_exp_sumptuary where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}
  else
  {
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(sump_amount)as totalamount from iccr_exp_sumptuary where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	  
  }
  		return $this->db->query($sql)->result_array();
	}
	function getthesis($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(tc_amount)as totalamount from iccr_exp_thesis_charges where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}
  else
  {
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(tc_amount)as totalamount from iccr_exp_thesis_charges where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	  
  }
  		return $this->db->query($sql)->result_array();
	}
	function getTravel($regionid,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(travel_amount)as totalamount from iccr_exp_travel where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}else
		{
			
			$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(travel_amount)as totalamount from iccr_exp_travel where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";
		}
  		return $this->db->query($sql)->result_array();
	}
	
	
	
	
	function getTutFee($regionid,$fy,$vars)
    {
		
		if($vars['Fyear'] != "")
        {
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(tf_amount)as totalamount from iccr_exp_tution_fee where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
  
	}
	else
	{
	$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(tf_amount)as totalamount from iccr_exp_tution_fee where regionId = ".$regionid." group by financial_year) as t1 where t1.financial_year = '".$fy."'";	
		
	}
  		return $this->db->query($sql)->result_array();
	}
	
	
		function getUniversityResponseSentByMission($vars,$data,$regionId) {
		//echo "sadasd";die;
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
         $this->db->distinct('iccr_status_mapping.application_no');
		 // Guarded every $vars[...] read below with isset() - this is also
		 // called directly with an empty array from the dashboard badge count
		 // (Regional::dashboard()), which previously had no way to get a real
		 // number here without first triggering "Undefined array key" warnings
		 // for every one of these optional filter keys.
		  if (isset($vars['Confirmed']) && $vars['Confirmed'] == 2) {
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.undertaking_doc,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response_by_hqrs.region_one_doc,iccr_university_response_by_hqrs.course,iccr_university_response_by_hqrs.confirmed_course,iccr_university_response_by_hqrs.university_is_accept,iccr_university_response_by_hqrs.regional_university,iccr_status_mapping.created as SubmitDate,iccr_status_mapping.iccr_status_date');
		  }
		  else{
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.scholar_acceptance,iccr_status_mapping.undertaking_doc,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_university_response.region_one_doc,iccr_university_response.course,iccr_university_response.confirmed_course,iccr_university_response.university_is_accept,iccr_university_response.regional_university,iccr_status_mapping.created as SubmitDate,iccr_status_mapping.iccr_status_date');
		  }
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
		 $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		 
		 if ($vars['Confirmed'] == 2) {
				$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
				$this->db->where(array('iccr_student_application_details.course_type =' => 2));
			}
			else{
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
			}
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
		  $this->db->where(array('iccr_status_mapping.status!=' => 15));
		   if ($vars['Confirmed'] == 2) {
			    $this->db->where(array('iccr_university_response_by_hqrs.region_one_status' => $regionId));
		  $this->db->where(array('iccr_university_response_by_hqrs.confirmed_to_mission=' => -1));
		  
		}
		else{
			$this->db->where(array('iccr_university_response.region_one_status' => $regionId));
			  $this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
			 $this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
		}
		  
		//$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
        //$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		// Narrowed to the 2026 admission cycle only, using the same year
		// boundary already established for the other 2026 dashboard badges
		// (getRegionalTotalNewApplication() above). This previously counted
		// everything since Jan 2025 with no upper bound at all, which is why
		// this list and the dashboard badge never actually matched a single
		// year's data.
		$this->db->where(array('iccr_status_mapping.created >=' => 1772150400));
		$this->db->where(array('iccr_status_mapping.created <=' => 1798761599));
		$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');
		
		
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
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
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
			
			 $this->db->where('iccr_university_response.regional_university', $vars['Universtiy']);
            //$this->db->where(' (iccr_student_application_details.universty_choice='.$vars['Universtiy'].' or iccr_student_application_details.universty_choice_two='.$vars['Universtiy'].' or iccr_student_application_details.universty_choice_three='.$vars['Universtiy'].')');
        }
		if ($vars['Confirmed'] == 1) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 1);
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
		//echo $this->db->_compile_select();
        //echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	
	
	function getTotalUniversityResponseSentByMission($vars,$data,$regionId) {
        $status = $data['status'];
        $iccr_status = $data['iccr_status'];
        $this->db->distinct();
        $this->db->select('count(iccr_status_mapping.application_no) as total');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
         if ($vars['Confirmed'] == 2) {
				$this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
				$this->db->where(array('iccr_student_application_details.course_type =' => 2));
			}
			else{
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
			}
        $this->db->where(array('iccr_status_mapping.status>=' => $status));
        //$this->db->where(array('iccr_status_mapping.iccr_status' => $iccr_status));
		
		 if ($vars['Confirmed'] == 2) {
			 $this->db->where(array('iccr_university_response_by_hqrs.region_one_status' => $regionId));
			 	  $this->db->where(array('iccr_university_response_by_hqrs.confirmed_to_mission=' => -1));
		  $this->db->where(array('iccr_university_response_by_hqrs.confirmed_to_mission=' => 1));
		}
		else{
			$this->db->where(array('iccr_university_response.region_one_status' => $regionId));
				  $this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
			 $this->db->where(array('iccr_university_response.confirmed_to_mission=' => 1));
		}
		//$this->db->where('iccr_status_mapping.iccr_status_date >=', 1590624000);
		//$this->db->where(array('iccr_status_mapping.created >='=> 1615749687));
		// Narrowed to the 2026 admission cycle only - same boundary and same
		// reasoning as getUniversityResponseSentByMission() above, so this
		// count always matches the list it's counting.
		$this->db->where(array('iccr_status_mapping.created >=' => 1772150400));
		$this->db->where(array('iccr_status_mapping.created <=' => 1798761599));
		$this->db->order_by("iccr_status_mapping.undertaking_doc",'DESC');
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
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
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
			
			 $this->db->where('iccr_university_response.regional_university', $vars['Universtiy']);
            //$this->db->where(' (iccr_student_application_details.universty_choice='.$vars['Universtiy'].' or iccr_student_application_details.universty_choice_two='.$vars['Universtiy'].' or iccr_student_application_details.universty_choice_three='.$vars['Universtiy'].')');
        }
		if ($vars['Confirmed'] == 1) {
            $this->db->where('iccr_status_mapping.scholar_acceptance', 1);
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
        return $this->db->get()->result_array();
    }
	
	
	 function getRegionalApplicationsDemo($regionId,$vars) {
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.uni_forwarded_letter_date,iccr_status_mapping.uni_forwarded_letter_date_two,iccr_status_mapping.uni_forwarded_letter_date_three,iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_status_mapping.mission_status_date,iccr_student_details.created,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.email,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.uni_forwarded_letter,iccr_status_mapping.uni_forwarded_letter_two,iccr_status_mapping.uni_forwarded_letter_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject,iccr_status_mapping.created as SubmitDate');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		 $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >=' =>1));
		$this->db->where(array('iccr_status_mapping.status !=' => 5));
		$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
		
		$this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' .$regionId .' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ')');
		
        $this->db->group_by('iccr_status_mapping.uni_forwarded_letter_date', 'ASC');
		$this->db->group_by('iccr_status_mapping.uni_forwarded_letter_date_two', 'ASC');
		$this->db->group_by('iccr_status_mapping.uni_forwarded_letter_date_three', 'ASC');
		$this->db->where('iccr_status_mapping.created >=', 1612227054);
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
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
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
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
		//print_r($vars['Upload']);die;
		if ($vars['Upload'] == 1) {
		   //$this->db->or_where('iccr_status_mapping.uni_forwarded_letter', NULL);
		   //$this->db->or_where('iccr_status_mapping.uni_forwarded_letter_two', NULL);
		   //$this->db->or_where('iccr_status_mapping.uni_forwarded_letter_three', NULL);
		  $val = -1;
		  
		  $this->db->where(' (iccr_status_mapping.university_status_1=' . $val . ' or iccr_status_mapping.university_status_2=' . $val . ' or iccr_status_mapping.university_status_3=' . $val . ')');
		 
        }
	
 		 if($vars['MinDate'] != "" && $vars['MaxDate'] != "")
        {
			$this->db->where('iccr_student_other_details.created >=', strtotime($vars['MinDate']));
            $this->db->where('iccr_student_other_details.created <=', strtotime($vars['MaxDate']));
		} 
		$this->db->order_by("iccr_status_mapping.undertaking_doc",'ASC');
        $this->db->limit($vars['length'],$vars['start']);
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	  function getRegionalTotalNewApplicationDemo($regionId,$vars) {
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('count(DISTINCT(iccr_status_mapping.application_no)) as total');
        $this->db->from('iccr_status_mapping');
		$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		//$this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
		 //$this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
        $this->db->where(array('iccr_status_mapping.status >=' =>1));
		$this->db->where(array('iccr_status_mapping.status !=' => 5));
		$this->db->where(array('iccr_status_mapping.status !=' => 6));
		$this->db->where(array('iccr_status_mapping.status !=' => 15));
        $this->db->where(' (iccr_student_application_details.university_choice_one_state=' . $regionId . ' or iccr_student_application_details.university_choice_two_state=' . $regionId . ' or iccr_student_application_details.university_choice_three_state=' .$regionId .' or iccr_student_application_details.university_choice_fourth_state=' . $regionId . ' or iccr_student_application_details.university_choice_fifth_state=' . $regionId . ')');
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
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
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
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Scheme'] != "") {
          
		   $this->db->where('iccr_status_mapping.scholarship_id', $vars['Scheme']);
        }
		if ($vars['Upload'] == 1) {
			 
		   //$this->db->where('iccr_status_mapping.uni_forwarded_letter', NULL);
		   //$this->db->where('iccr_status_mapping.uni_forwarded_letter_two', NULL);
		   //$this->db->where('iccr_status_mapping.uni_forwarded_letter_three', NULL);
		  $val = -1;
		  $this->db->where(' (iccr_status_mapping.university_status_1=' . $val . ' or iccr_status_mapping.university_status_2=' . $val . ' or iccr_status_mapping.university_status_3=' . $val . ')');
        }
		if ($vars['Upload'] == 2) {
		   //$this->db->or_where('iccr_status_mapping.uni_forwarded_letter!=',NULL);
		   //$this->db->or_where('iccr_status_mapping.uni_forwarded_letter_two!=',NULL);
		   //$this->db->or_where('iccr_status_mapping.uni_forwarded_letter_three!=',NULL);
		   $val = 1;
		 
		  $this->db->where(' (iccr_status_mapping.university_status_1=' . $val . ' or iccr_status_mapping.university_status_2=' . $val . ' or iccr_status_mapping.university_status_3=' . $val . ')');
		
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
		//echo $this->db->_compile_select();exit;
        return $this->db->get()->result_array();
    }
	
	
	function getRegionalReceivedApplication($regionId) {
        $this->db->distinct();
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.bonafide_doc,iccr_status_mapping.joining_doc,iccr_status_mapping.police_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');

        $this->db->where('(iccr_university_response.region_one_status=' . $regionId . ' and iccr_university_response.university_is_accept=1) or (iccr_university_response_by_hqrs.region_one_status=' . $regionId . ' and iccr_university_response_by_hqrs.university_is_accept=1)');
        $this->db->where(array('iccr_status_mapping.status' => 14, 'iccr_travelplan.status' => 14));
        // $this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.')'); 	
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->get()->result_array();
    }
	
	
	 function getCurrentQuarterFundDetails($regionId, $fy, $quarter) {
        $sql = "Select amount_released FROM iccr_hqrs_fund_monitoring where regional_office=" . $regionId . " and quarter=" . $quarter . " and financial_year='" . $fy . "'";
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
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
	
	//expinditure 
	
	
	function getRegionalExpenditure($vars,$regionId) {
        $this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.bonafide_doc,iccr_status_mapping.joining_doc,iccr_status_mapping.police_doc');
        $this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no');
		if($vars['ApplicantName'] == ""){
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');
        $this->db->where('(iccr_university_response.region_one_status='.$regionId.' and iccr_university_response.university_is_accept=1) or (iccr_university_response_by_hqrs.region_one_status='.$regionId.' and iccr_university_response_by_hqrs.university_is_accept=1)');
		}
        $this->db->where(array('iccr_status_mapping.status' => 14, 'iccr_travelplan.status' => 14));
		$this->db->order_by('iccr_student_application_details.fullname', 'ASC');
        // $this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.')'); 
		if ($vars['ApplicantName'] != "") {
		$this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
		  $this->db->where('(iccr_university_response.region_one_status='.$regionId.' and iccr_university_response.university_is_accept=1)');
		  // iccr_student_application_details.fullname is stored with an older
		  // latin1_swedish_ci collation while the search text PHP/MySQL compares
		  // it against comes through as utf8mb3_general_ci - mixing the two in a
		  // LIKE throws "Illegal mix of collations" and crashes the search
		  // instead of returning results. Converting the column to utf8mb3 and
		  // explicitly setting the collation for just this comparison fixes the
		  // mismatch without touching the actual column/table definition.
		  $this->db->where("CONVERT(iccr_student_application_details.fullname USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['ApplicantName']).'%'), NULL, FALSE);
		 // $this->db->where('iccr_student_application_details.nationality', $vars['Country']);
		  //$res = $this->db->get()->result_array();
		}
		/* if($vars['ApplicantName'] != ""){
			 $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');
		} */
		
        if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_university_response.regional_university=' . $vars['Universtiy'] . ' or iccr_university_response_by_hqrs.regional_university=' . $vars['Universtiy'] .')');
        }
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		
		$this->db->limit($vars['length'],$vars['start']);		
        $code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
	    //echo $this->db->_compile_select();die; 
        return $this->db->get()->result_array();
    }
	
	function getRegionalTotalExpenditure($vars,$regionId) {
		$this->db->distinct('iccr_status_mapping.application_no');
        $this->db->select('count(DISTINCT(iccr_status_mapping.application_no)) as total');
		$this->db->from('iccr_status_mapping');
        $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
        $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
        $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no');
        $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no', 'left');
        $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no', 'left');

        $this->db->where('(iccr_university_response.region_one_status='.$regionId.' and iccr_university_response.university_is_accept=1) or (iccr_university_response_by_hqrs.region_one_status='.$regionId.' and iccr_university_response_by_hqrs.university_is_accept=1)');
        $this->db->where(array('iccr_status_mapping.status' => 14, 'iccr_travelplan.status' => 14));
		
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
            // iccr_student_application_details.email is stored with an older
            // latin1_swedish_ci collation while the search text PHP/MySQL compares
            // it against comes through as utf8mb3_general_ci - mixing the two in a
            // LIKE throws "Illegal mix of collations" and crashes the search
            // instead of returning results. Converting the column to utf8mb3 and
            // explicitly setting the collation for just this comparison fixes the
            // mismatch without touching the actual column/table definition.
            $this->db->where("CONVERT(iccr_student_application_details.email USING utf8mb3) COLLATE utf8mb3_general_ci LIKE " . $this->db->escape('%'.$this->db->escape_like_str($vars['Mail']).'%'), NULL, FALSE);
        }
       
		if ($vars['Country'] != "") {
          
		   $this->db->where('iccr_student_application_details.nationality',$vars['Country']);
        }  
		if ($vars['Universtiy'] != "") {
            $this->db->where(' (iccr_university_response.regional_university=' . $vars['Universtiy'] . ' or iccr_university_response_by_hqrs.regional_university=' . $vars['Universtiy'] .')');
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
	public function __destruct(){
		
		$this->db->close();
	}
}

?>



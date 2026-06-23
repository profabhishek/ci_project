<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Model {

    public $status;
    public $roles;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }
    
	public function getStudentDetailsReport($vars,$ids)
	{
		$sql ="Select sd.gender,sd.created, ad.application_no, ad.fullname, ad.email, ad.country, ad.programme, ad.course_type, map.scholarship_id from iccr_status_mapping map join iccr_student_details sd on sd.uid = map.uid join iccr_student_application_details ad on ad.application_no = map.application_no where map.scholarship_id IN(".$ids.") ";
		
		
		if($vars['ApplicantName'] != "")
		{
			$sql .= " and ad.fullname='".$vars['ApplicantName']."'";
		} 
		if($vars['Gender'] != "" && $vars['Gender'] > 0)
		{
			$sql .= " and sd.gender=".$vars['Gender'];
		}
		if($vars['Mail'] != "")
		{
			$sql .= " and ad.email='".$vars['Mail']."'";
		} 
		if($vars['Country'] != "" && $vars['Country'] > 0)
		{
			$sql .= " and ad.country=".$vars['Country'];
		}
		if($vars['Programme'] != "" && $vars['Programme'] > 0)
		{
			$sql .= " and ad.programme=".$vars['Programme'];
		} 
		$sql .= " limit ".$vars['start'].",".$vars['length'];
		$code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
	}
	public function getTotalStudentDetailsReport($vars,$ids)
	{
		$sql ="Select count( ad.application_no) as total from iccr_status_mapping map join iccr_student_details sd on sd.uid = map.uid join iccr_student_application_details ad on ad.application_no = map.application_no where map.scholarship_id IN(".$ids.") ";
		
		if($vars['ApplicantName'] != "")
		{
			$sql .= " and ad.fullname='".$vars['ApplicantName']."'";
		} 
		if($vars['Gender'] != "" && $vars['Gender'] > 0)
		{
			$sql .= " and sd.gender=".$vars['Gender'];
		}
		if($vars['Mail'] != "")
		{
			$sql .= " and ad.email='".$vars['Mail']."'";
		} 
		if($vars['Country'] != "" && $vars['Country'] > 0)
		{
			$sql .= " and ad.country=".$vars['Country'];
		}
		if($vars['Programme'] != "" && $vars['Programme'] > 0)
		{
			$sql .= " and ad.programme=".$vars['Programme'];
		} 
		
		$code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
	}
	public function getReportOfAllStudentsApplications($vars,$ids)
    {
		//$sql ="Select sd.created,ad.university_choice_one_state,ad.university_choice_two_state,ad.university_choice_three_state,ad.universty_choice,ad.universty_choice_two,ad.universty_choice_three, sd.gender, ad.application_no, ad.fullname, ad.email, ad.country,map.status, ad.programme, ad.course_type, map.scholarship_id from iccr_status_mapping map join iccr_student_details sd on sd.uid = map.uid join iccr_student_application_details ad on ad.application_no = map.application_no";
		$sql ="Select rp.*,sd.created,sd.gender, ad.application_no, ad.fullname, ad.email, ad.country,map.status, ad.programme, ad.course_type, map.scholarship_id from iccr_university_response rp join iccr_status_mapping map on rp.application_id = map.application_no join iccr_travelplan tp on rp.application_id = tp.application_id join iccr_student_details sd on sd.uid = map.uid join iccr_student_application_details ad on ad.application_no = map.application_no ";
		
		if($vars['ExpenditureFilter'] != "" && $vars['ExpenditureFilter'] > 1)
		{
			$sql .= " join iccr_student_expenditure ex on ex.application_id = map.application_no ";
		}
		
		$sql .= " where rp.university_is_accept=1 and map.scholarship_id IN(".$ids.") and tp.status=14";
		if($vars['RO'] != "" && $vars['RO'] > 0)
		{
			$sql .= " and rp.region_one_status=".$vars['RO'];
		}
		//echo $sql;
		if($vars['FinancialYear'] != "")
		{
			$finyear = explode('-',$vars['FinancialYear']);			
			$sql .= " and MONTH(STR_TO_DATE(DATE_FORMAT(sd.created, '%Y-%m-%d'), '%Y-%m-%d')) IN(4,5,6,7,8,9,10,11,12) and YEAR(STR_TO_DATE(DATE_FORMAT(sd.created, '%Y-%m-%d'), '%Y-%m-%d'))=".$finyear[0]." OR MONTH(STR_TO_DATE(DATE_FORMAT(sd.created, '%Y-%m-%d'), '%Y-%m-%d')) IN(1,2,3) and YEAR(STR_TO_DATE(DATE_FORMAT(sd.created, '%Y-%m-%d'), '%Y-%m-%d'))=".$finyear[1];
		} 		
		$sql .= " limit ".$vars['start'].",".$vars['length'];
		
		$code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        return $this->db->query($sql)->result_array();
	}
	public function getAllStudentDetailsReport($vars,$ids)
	{
		//$sql ="Select count(map.id) as total from iccr_status_mapping map join iccr_student_application_details ad on ad.application_no = map.application_no join iccr_student_details sd on sd.uid = map.uid  ";		
		$sql ="Select count(rp.id)as total from iccr_university_response rp join iccr_status_mapping map on rp.application_id = map.application_no join iccr_travelplan tp on rp.application_id = tp.application_id join iccr_student_details sd on sd.uid = map.uid join iccr_student_application_details ad on ad.application_no = map.application_no ";

		if($vars['ExpenditureFilter'] != "" && $vars['ExpenditureFilter'] > 1)
		{
			$sql .= " join iccr_student_expenditure ex on ex.application_id = map.application_no ";
		}	
		
		//$sql .= " where map.scholarship_id IN(".$ids.") ";
		$sql .= " where rp.university_is_accept=1 and map.scholarship_id IN(".$ids.") and tp.status=14";
		
		if($vars['RO'] != "" && $vars['RO'] > 0)
		{
			$sql .= " and rp.region_one_status=".$vars['RO'];
		}	
		
		if($vars['FinancialYear'] != "")
		{
			$finyear = explode('-',$vars['FinancialYear']);			
			$sql .= " and MONTH(STR_TO_DATE(DATE_FORMAT(sd.created, '%Y-%m-%d'), '%Y-%m-%d')) IN(4,5,6,7,8,9,10,11,12) and YEAR(STR_TO_DATE(DATE_FORMAT(sd.created, '%Y-%m-%d'), '%Y-%m-%d'))=".$finyear[0]." OR MONTH(STR_TO_DATE(DATE_FORMAT(sd.created, '%Y-%m-%d'), '%Y-%m-%d')) IN(1,2,3) and YEAR(STR_TO_DATE(DATE_FORMAT(sd.created, '%Y-%m-%d'), '%Y-%m-%d'))=".$finyear[1];
		} 
		
		$code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->query($sql)->result_array();
	}
	function getACATotalExp($ids,$fy,$vars)
    {    
		//echo $fy;die;
		
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))  ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(aca_amount)as totalamount from iccr_exp_aca where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}
		else
		{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))  ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(aca_amount)as totalamount from iccr_exp_aca where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";	
		//echo $sql;die;
			
		}
  		return $this->db->query($sql)->result_array();
	}
	function getAdvanceStipnedTotalExp($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))  ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(adv_stipend_amount)as totalamount from iccr_exp_advance_stipend where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))  ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(adv_stipend_amount)as totalamount from iccr_exp_advance_stipend where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  
  		return $this->db->query($sql)->result_array();
  		//echo $this->db->_compile_select();
	}
	function getCamps($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))) ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(camps_amount)as totalamount from iccr_exp_camps where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))) ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(camps_amount)as totalamount from iccr_exp_camps where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getDeduction($ids,$fy)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ded_amount)as totalamount from iccr_exp_deductions where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ded_amount)as totalamount from iccr_exp_deductions where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getEmergencyFund($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ef_amount)as totalamount from iccr_exp_emergency_fund where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ef_amount)as totalamount from iccr_exp_emergency_fund where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
		
	}
  		return $this->db->query($sql)->result_array();
	}
	function getEngBridgeCourse($ids,$fy)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ebc_amount)as totalamount from iccr_exp_english_bridge_course where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ebc_amount)as totalamount from iccr_exp_english_bridge_course where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getHostel($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))) ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(hos_amount)as totalamount from iccr_exp_hostel where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
	else
	{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))) ELSE concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1) END AS financial_year,sum(hos_amount)as totalamount from iccr_exp_hostel where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
		
	}
  		return $this->db->query($sql)->result_array();
	}
	function getHRA($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(hra_amount)as totalamount from iccr_exp_hra where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}else
	{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(hra_amount)as totalamount from iccr_exp_hra where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getisaMeeting($ids,$fy)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(isa_amount)as totalamount from iccr_exp_isa_meeting where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}else{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(isa_amount)as totalamount from iccr_exp_isa_meeting where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getmedicalReEmbust($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(mr_amount)as totalamount from iccr_exp_medical_reimbursment where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
  
	}
	else{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(mr_amount)as totalamount from iccr_exp_medical_reimbursment where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getMicsellanious($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(msc_amount)as totalamount from iccr_exp_miscellaneous where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}else{
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(msc_amount)as totalamount from iccr_exp_miscellaneous where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getMisUniversity($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(uni_msc_amount)as totalamount from iccr_exp_miscellaneous_university where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
  else{
	  
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(uni_msc_amount)as totalamount from iccr_exp_miscellaneous_university where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
  }
  		return $this->db->query($sql)->result_array();
	}
	function getNationalDay($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(nd_amount)as totalamount from iccr_exp_national_day where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}else{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(nd_amount)as totalamount from iccr_exp_national_day where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getOrientProg($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(op_amount)as totalamount from iccr_exp_orientation_programme where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$$vars['Fyear']."'";
	}else{
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(op_amount)as totalamount from iccr_exp_orientation_programme where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	}
  		return $this->db->query($sql)->result_array();
	}
	function getOtherFee($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ocf_amount)as totalamount from iccr_exp_other_fee where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
  else{
	  
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(ocf_amount)as totalamount from iccr_exp_other_fee where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
  }
  		return $this->db->query($sql)->result_array();
	}
	function getStipned($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(amount)as totalamount from iccr_exp_stipend where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
	}
  else
  {
	  
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(amount)as totalamount from iccr_exp_stipend where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
  }
  		return $this->db->query($sql)->result_array();
		
	}
	function getStudentDay($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(sd_amount)as totalamount from iccr_exp_student_day where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}else{
			
			$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(sd_amount)as totalamount from iccr_exp_student_day where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
		}
  		return $this->db->query($sql)->result_array();
	}
	function getStudyTour($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(st_amount)as totalamount from iccr_exp_study_tour where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}
  else
  {
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(st_amount)as totalamount from iccr_exp_study_tour where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
  }
  		return $this->db->query($sql)->result_array();
	}
	function getSump($ids,$fy)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(sump_amount)as totalamount from iccr_exp_sumptuary where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}
  else
  {
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(sump_amount)as totalamount from iccr_exp_sumptuary where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	  
  }
  		return $this->db->query($sql)->result_array();
	}
	function getthesis($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(tc_amount)as totalamount from iccr_exp_thesis_charges where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}
  else
  {
	  $sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(tc_amount)as totalamount from iccr_exp_thesis_charges where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
	  
  }
  		return $this->db->query($sql)->result_array();
	}
	function getTravel($ids,$fy,$vars)
    {
		if($vars['Fyear'] != "")
        {
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(travel_amount)as totalamount from iccr_exp_travel where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
		}else
		{
			
			$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(travel_amount)as totalamount from iccr_exp_travel where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";
		}
  		return $this->db->query($sql)->result_array();
	}
	
	
	
	
	function getTutFee($ids,$fy,$vars)
    {
		
		if($vars['Fyear'] != "")
        {
		
		$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(tf_amount)as totalamount from iccr_exp_tution_fee where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$vars['Fyear']."'";
  
	}
	else
	{
	$sql ="Select t1.* from (Select CASE WHEN MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))<=3 THEN
       concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))-1,'-', YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')))
   ELSE
concat(YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d')), '-',YEAR(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), '%Y-%m-%d'))+1)
  END AS financial_year,sum(tf_amount)as totalamount from iccr_exp_tution_fee where scheme IN(".$ids.") group by financial_year) as t1 where t1.financial_year = '".$fy."'";	
		
	}
  		return $this->db->query($sql)->result_array();
	}
	
	
	
	//Vipin start agency data
	
		public function getReportOfAllStudentsApplicationsRegionWise($vars,$ids)
    {
		  //echo "<pre>";print_r($vars);
		//$sql ="Select * from iccr_student_expenditure where exp_student_type = 'AGENCYOLD'";
		$sql ="Select * from iccr_student_expenditure right join iccr_academic_details ic on ic.application_id = iccr_student_expenditure.application_id where exp_student_type = 'AGENCYOLD'";		
		if($vars['RO'] != "" && $vars['RO'] > 0)
		{
			$sql .= " and ic.city_id = ".$vars['RO'];
		}
		//echo $sql;
		  if($vars['FinancialYear'] != "")
		{
			$finyear = explode('-',$vars['FinancialYear']);			
			$sql .= " and MONTH(STR_TO_DATE(DATE_FORMAT(ic.created, '%Y-%m-%d'), '%Y-%m-%d')) IN(4,5,6,7,8,9,10,11,12) and YEAR(STR_TO_DATE(DATE_FORMAT(ic.created, '%Y-%m-%d'), '%Y-%m-%d'))=".$finyear[0]." OR MONTH(STR_TO_DATE(DATE_FORMAT(ic.created, '%Y-%m-%d'), '%Y-%m-%d')) IN(1,2,3) and YEAR(STR_TO_DATE(DATE_FORMAT(ic.created, '%Y-%m-%d'), '%Y-%m-%d'))=".$finyear[1];
		}  	

		if($vars['AcademicYear'] != "")
		{
			
			//$acyear = explode('-',$vars['AcademicYear']);			
			$sql .= " and ic.academic_year="."'".$vars['AcademicYear']."'";
		}
		$sql .= " limit ".$vars['start'].",".$vars['length'];
		
		$code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $sql;die;
		//echo $this->db->_compile_select();
        return $this->db->query($sql)->result_array();
	}
	public function getAllStudentDetailsReportRegionWise($vars,$ids)
	{	
		//$sql ="Select count(rp.id)as total from iccr_university_response rp join iccr_status_mapping map on rp.application_id = map.application_no join iccr_travelplan tp on rp.application_id = tp.application_id join iccr_student_details sd on sd.uid = map.uid join iccr_student_application_details ad on ad.application_no = map.application_no ";
		
		//$sql ="Select * from iccr_student_expenditure where exp_student_type = 'AGENCYOLD'";
		$sql ="Select * from iccr_student_expenditure right join iccr_academic_details ic on ic.application_id = iccr_student_expenditure.application_id where exp_student_type = 'AGENCYOLD'";	
		//echo $sql;die;
		if($vars['RO'] != "" && $vars['RO'] > 0)
		{
			$sql .= " and ic.city_id = ".$vars['RO'];
		}
		//if($vars['ExpenditureFilter'] != "" && $vars['ExpenditureFilter'] > 1)
		//{
			//$sql .= " join iccr_student_expenditure ex on ex.application_id = map.application_no ";
		//}	
		
		//$sql .= " where map.scholarship_id IN(".$ids.") ";
		//$sql .= " where rp.university_is_accept=1 and map.scholarship_id IN(".$ids.") and tp.status=14";
		
		//if($vars['RO'] != "" && $vars['RO'] > 0)
		//{
			//$sql .= " and rp.region_one_status=".$vars['RO'];
		//}	
		
		if($vars['FinancialYear'] != "")
		{
			$finyear = explode('-',$vars['FinancialYear']);			
			$sql .= " and MONTH(STR_TO_DATE(DATE_FORMAT(ic.created, '%Y-%m-%d'), '%Y-%m-%d')) IN(4,5,6,7,8,9,10,11,12) and YEAR(STR_TO_DATE(DATE_FORMAT(ic.created, '%Y-%m-%d'), '%Y-%m-%d'))=".$finyear[0]." OR MONTH(STR_TO_DATE(DATE_FORMAT(ic.created, '%Y-%m-%d'), '%Y-%m-%d')) IN(1,2,3) and YEAR(STR_TO_DATE(DATE_FORMAT(ic.created, '%Y-%m-%d'), '%Y-%m-%d'))=".$finyear[1];
		} 
		if($vars['AcademicYear'] != "")
		{
			
			//$acyear = explode('-',$vars['AcademicYear']);			
			$sql .= " and ic.academic_year="."'".$vars['AcademicYear']."'";
		}
		//$sql .= " limit ".$vars['start'].",".$vars['length'];
		$code = $this->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
		//echo $this->db->_compile_select();exit;
        return $this->db->query($sql)->result_array();
	}
	
	//Vipin end agency data

}

?>
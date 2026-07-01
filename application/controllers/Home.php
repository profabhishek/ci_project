<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	///session_start();
	class Home extends CI_Controller {
		
		
		/**
			* Index Page for this controller.
			*
			* Maps to the following URL
			* 		http://example.com/index.php/welcome
			*	- or -
			* 		http://example.com/index.php/welcome/index
			*	- or -
			* Since this controller is set as the default controller in
			* config/routes.php, it's displayed at http://example.com/
			*
			* So any other public methods not prefixed with an underscore will
			* map to /index.php/welcome/<method_name>
			* @see https://codeigniter.com/user_guide/general/urls.html
		*/
		
		public function __construct()
		{
			parent::__construct();
			
			$this->load->helper('url');
			//$this->load->helper('SetValueHelper');
			$this->load->helper('form');
			$this->load->helper('security');
			$this->load->helper('text');
			$this->load->library('form_validation');
			$this->load->library('session');	
			$this->load->library('encryption');
			$this->load->helper('date');   
			$this->load->helper('cache_helper'); 
			$this->load->model('user_model'); 
			$this->load->model('common_model');  
			$this->load->model('hqrs_model');
			//$this->load->library('mpdf60/Mpdf');   
			//$this->load->library('fpdi/PDF_HTML');   
			//$this->load->library('fpdi/Htmltable');     
			$this->load->helper('file');

			
			$userdata = $this->session->userdata('user_data');
			
			$query = $this->db->query("SELECT * FROM iccr_page ORDER BY modified_on DESC;");
			$row = $query->row();	
			$this->session->set_userdata('last_modified_on',$row->modified_on);
			if(!$this->session->userdata('user_data'))
			{
				/*$roles = $this->config->item('roles_id');
					$role = $roles[$userdata['user_type']];
					switch($role)
					{
					case "Student":
					redirect(site_url() . 'applicant/dashboard');
					break;
					case "Mission":
					redirect(site_url() . 'mission/dashboard');
					break;
					case "ICCR":
					redirect(site_url() . 'headquarter/dashboard');
					break;
					case "Regional Office":
					redirect(site_url() . 'regional/dashboard');
					break;
					case "Super Admin":
					redirect(site_url() . 'admin/dashboard');
					break;
				} */
			}

		} 
		
		
		public function not_found()
		{
			$this->load->view('site/header');
			$this->load->view('errors/html/error_500');
			$this->load->view('site/footer');
		}
		
    function confirmedStudentAPI(){

		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
		$secretkey=$this->input->request_headers();
		
     	$getTokken = $this->db->get_where('iccr_header_token',array('secret_token'=>$secretkey['Secrettoken'],'secret_key'=>$secretkey['Secretkey']))->num_rows();

		//echo $getTokken; die;
	   	if($getTokken>0){
		$year = $this->uri->segment(3);
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      

		$result = $this->hqrs_model->getAllStudentData($year,$res);

		//print_r($result); die;
		
		$response = array();
		if(!empty($result))
		{
			
			foreach($result as $key=>$r)
			{
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				$gender = "";
				$output= array();	
			
				$output[$key]['fullname'] = $applicationDetails[0]['fullname'];
				$output[$key]['email'] = $applicationDetails[0]['email'];
				$output[$key]['application_no'] = $r['application_no'];
						
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$course = $this->common_model->getCoursesById($applicationDetails[0]['course']);
					$course1 = $this->common_model->getCoursesById($applicationDetails[0]['course_two']);
					$course2 = $this->common_model->getCoursesById($applicationDetails[0]['course_three']);
					$fullCourse ="";
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'_';
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'_';
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'_';
					$output[] = $fullCourse;
				}
				
				$universityDetails = "";
				$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				$universityDetails .= '1) '.$uni1[0]['name'].'_';
				$universityDetails .= '2) '.$uni2[0]['name'].'_';
				$universityDetails .= '3) '.$uni3[0]['name'].'_';
				$output[] = $universityDetails;			
				$scheme = $this->common_model->getSchemeById($r['scholarship_id']);
				$output[] =	$scheme[0]['scheme_name'];		
				$output[] = $country[0]['country_name'];
				$output[] = date("d-m-Y", $r['created']);
				$response[] = $output;
			}
		}

		$returnJson['data'] = $response;
		$responseApi = array();
		
		foreach($result as $key1=>$r1)
		{
			$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r1['application_no']);

			//echo'<pre>'; print_r($applicationDetails); die;
			$iccr_missions = $this->db->get_where('iccr_missions',array('id'=>$r1['application_through']))->row();
			$scheme = $this->common_model->getSchemeById($r1['scholarship_id']);
			// $confirmData = $this->common_model->getFinalUniversityById($r1['regional_university']);	
			// $region = $this->common_model->getRegionById($r1['region_one_status']);
			$program = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);

			
			if($applicationDetails[0]['course_type'] == 1) {
				if($r1['region_one_status_date']!=""){
					$undertaking_date=date('d-m-Y',$r1['region_one_status_date']);
				}else{
					$undertaking_date="";
				}
			}
			else {
				if($r1['undertaking_doc']!=""){
					$undertaking_date=date('d-m-Y',$r1['undertaking_doc']);
				}else{
					$undertaking_date="";
				}
			}

			 $visa_isuue_date="";
			  if($r1['visa_isuue_date']!=null){
                $visa_isuue_date=date_format(date_create($r1['visa_isuue_date']),'d-m-Y');
             }

			 $visa_to_date="";
			 if($r1['visa_to_date']!=null){
			   $visa_to_date=date_format(date_create($r1['visa_to_date']),'d-m-Y');
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$date_of_joining="";
			 if($r1['date_of_joining_ayush']!=null){
			   $date_of_joining=date_format(date_create($r1['date_of_joining_ayush']),'d-m-Y');
			}
			}
			else {
				$date_of_joining="";
			 if($r1['date_of_joining']!=null){
			   $date_of_joining=date_format(date_create($r1['date_of_joining']),'d-m-Y');
			}
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$duration_of_course="";
			 if($r1['duration_of_course_ayush']!=null){
			   $duration_of_course = $r1['duration_of_course_ayush'];
			}
			}
			else {
				$duration_of_course="";
			 if($r1['duration_of_course']!=null){
			   $duration_of_course = $r1['duration_of_course'];
			}
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$region_one_status="";
			 if($r1['region_one_status_ayush']!=null){
			   $region_one_status = $r1['region_one_status_ayush'];
			}
			}
			else {
				$region_one_status="";
			 if($r1['region_one_status']!=null){
			   $region_one_status = $r1['region_one_status'];
			}
			}
			$region = $this->common_model->getRegionById($region_one_status);



			if($applicationDetails[0]['course_type'] == 1) {
				$regional_university="";
			 if($r1['regional_university_ayush']!=null){
			   $regional_university = $r1['regional_university_ayush'];
			}
			}
			else {
				$regional_university="";
			 if($r1['regional_university']!=null){
			   $regional_university = $r1['regional_university'];
			}
			}
			$confirmData = $this->common_model->getFinalUniversityById($regional_university);	

			// echo '<pre>'; print_r($region_one_status);die;
			
			$responseApi[$key1]['application_no']=$r1['application_no'];
			$responseApi[$key1]['first_name']=$r1['fullname'];
			$responseApi[$key1]['middle_name']=$r1['middlename'];
			$responseApi[$key1]['last_name']=$r1['familyname'];
			$responseApi[$key1]['email']=$r1['email'];
			$responseApi[$key1]['country_name']=$r1['country_name'];
			$responseApi[$key1]['mission_name']=$iccr_missions->mission_name;
			$responseApi[$key1]['scheme_name']=$scheme[0]['scheme_name'];
			$responseApi[$key1]['level_of_course']=$program[0]['name'];
			$responseApi[$key1]['course_name']=$r1['final_course'];
			$responseApi[$key1]['university_name']=$confirmData[0]['name'];
			$responseApi[$key1]['region_name']=$region[0]['name'];
			$responseApi[$key1]['phone_number']=$r1['phone_number'];
			$responseApi[$key1]['whatsapp_number']=$r1['whatsapp_number'];
			$responseApi[$key1]['passport_no']=$r1['passport_no'];
			$responseApi[$key1]['passport_issue_date']=$r1['passport_issue_date'];
			$responseApi[$key1]['passport_expiry_date']=$r1['passport_expiry_date'];
			$responseApi[$key1]['passport_issue_place']=$r1['passport_issue_place'];
			$responseApi[$key1]['acedemic_year']=$r1['acedemic_year'];
			$responseApi[$key1]['place_of_birth']=$r1['city'];
			$responseApi[$key1]['visa_no']=$r1['visa_no'];
			$responseApi[$key1]['visa_isuue_date']=$visa_isuue_date;
			$responseApi[$key1]['visa_expiry_date']=$visa_to_date;
			$responseApi[$key1]['date_of_arrival']=$r1['travel_arrival_date'];
			$responseApi[$key1]['date_of_joining']=$date_of_joining;
			// $responseApi[$key1]['duration_of_course']=$r1['duration_of_course'];
			$responseApi[$key1]['duration_of_course']=$duration_of_course;
			$responseApi[$key1]['created_date']=$undertaking_date;


		}
		echo json_encode($responseApi);
	}else{
		$error = array(
            'message' => "secret token and secret key wrong",
            'status' => false
        );  
		echo json_encode($error);
	}
	   }
function confirmedStudentAPINew(){

		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
		$secretkey=$this->input->request_headers();
		
     	$getTokken = $this->db->get_where('iccr_header_token',array('secret_token'=>$secretkey['Secrettoken'],'secret_key'=>$secretkey['Secretkey']))->num_rows();

		//echo $getTokken; die;
	   	if($getTokken>0){
		$year = $this->uri->segment(3);
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      

		$result = $this->hqrs_model->getAllStudentData($year,$res);

		//print_r($result); die;

		$response = array();
		if(!empty($result))
		{

			foreach($result as $key=>$r)
			{
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);

				$gender = "";
				$output= array();

				$output[$key]['fullname'] = $applicationDetails[0]['fullname'];
				$output[$key]['email'] = $applicationDetails[0]['email'];
				$output[$key]['application_no'] = $r['application_no'];

				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$course = $this->common_model->getCoursesById($applicationDetails[0]['course']);
					$course1 = $this->common_model->getCoursesById($applicationDetails[0]['course_two']);
					$course2 = $this->common_model->getCoursesById($applicationDetails[0]['course_three']);
					$fullCourse ="";
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'_';
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'_';
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'_';
					$output[] = $fullCourse;
				}

				$universityDetails = "";
				$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				$universityDetails .= '1) '.$uni1[0]['name'].'_';
				$universityDetails .= '2) '.$uni2[0]['name'].'_';
				$universityDetails .= '3) '.$uni3[0]['name'].'_';
				$output[] = $universityDetails;
				$scheme = $this->common_model->getSchemeById($r['scholarship_id']);
				$output[] =	$scheme[0]['scheme_name'];
				$output[] = $country[0]['country_name'];
				$output[] = date("d-m-Y", $r['created']);
				$response[] = $output;
			}
		}

		$returnJson['data'] = $response;
		$responseApi = array();

		// Pre-fetch all lookup data in bulk to avoid N+1 queries
		$missionsCache = []; $schemesCache = []; $programsCache = [];
		$universitiesCache = []; $regionsCache = []; $courseTypeCache = [];
		foreach($result as $r1) {
			$missionsCache[$r1['application_through']] = true;
			$schemesCache[$r1['scholarship_id']] = true;
			$programsCache[$r1['programme']] = true;
			$uni = $r1['course_type'] == 1 ? $r1['regional_university_ayush'] : $r1['regional_university'];
			if($uni) $universitiesCache[$uni] = true;
			$reg = $r1['course_type'] == 1 ? $r1['region_one_status_ayush'] : $r1['region_one_status'];
			if($reg) $regionsCache[$reg] = true;
			$courseTypeCache[$r1['course_type']] = true;
		}
		foreach(array_keys($missionsCache) as $mid) {
			$missionsCache[$mid] = $this->db->get_where('iccr_missions', array('id'=>$mid))->row();
		}
		foreach(array_keys($schemesCache) as $sid) {
			$schemesCache[$sid] = $this->common_model->getSchemeById($sid);
		}
		foreach(array_keys($programsCache) as $pid) {
			$programsCache[$pid] = $this->common_model->getProgrammeById($pid);
		}
		foreach(array_keys($universitiesCache) as $uid) {
			$universitiesCache[$uid] = $this->common_model->getFinalUniversityById($uid);
		}
		foreach(array_keys($regionsCache) as $rid) {
			$regionsCache[$rid] = $this->common_model->getRegionById($rid);
		}
		foreach(array_keys($courseTypeCache) as $ctid) {
			$row = $this->db->get_where('iccr_course_type', array('id'=>$ctid))->row();
			$courseTypeCache[$ctid] = $row->course_type ?? '';
		}

		foreach($result as $key1=>$r1)
		{
			$iccr_missions = $missionsCache[$r1['application_through']] ?? null;
			$scheme        = $schemesCache[$r1['scholarship_id']] ?? [];
			$program       = $programsCache[$r1['programme']] ?? [];
			$course_type   = $r1['course_type'];

			if($course_type == 1) {
				$undertaking_date = !empty($r1['region_one_status_date']) ? date('d-m-Y',$r1['region_one_status_date']) : "";
			} else {
				$undertaking_date = !empty($r1['undertaking_doc']) ? date('d-m-Y',$r1['undertaking_doc']) : "";
			}

			 $visa_isuue_date="";
			  if($r1['visa_isuue_date']!=null){
                $visa_isuue_date=date_format(date_create($r1['visa_isuue_date']),'d-m-Y');
             }

			 $visa_to_date="";
			 if($r1['visa_to_date']!=null){
			   $visa_to_date=date_format(date_create($r1['visa_to_date']),'d-m-Y');
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$date_of_joining="";
			 if($r1['date_of_joining_ayush']!=null){
			   $date_of_joining=date_format(date_create($r1['date_of_joining_ayush']),'d-m-Y');
			}
			}
			else {
				$date_of_joining="";
			 if($r1['date_of_joining']!=null){
			   $date_of_joining=date_format(date_create($r1['date_of_joining']),'d-m-Y');
			}
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$duration_of_course="";
			 if($r1['duration_of_course_ayush']!=null){
			   $duration_of_course = $r1['duration_of_course_ayush'];
			}
			}
			else {
				$duration_of_course="";
			 if($r1['duration_of_course']!=null){
			   $duration_of_course = $r1['duration_of_course'];
			}
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$region_one_status="";
			 if($r1['region_one_status_ayush']!=null){
			   $region_one_status = $r1['region_one_status_ayush'];
			}
			}
			else {
				$region_one_status="";
			 if($r1['region_one_status']!=null){
			   $region_one_status = $r1['region_one_status'];
			}
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$regional_university="";
			 if($r1['regional_university_ayush']!=null){
			   $regional_university = $r1['regional_university_ayush'];
			}
			}
			else {
				$regional_university="";
			 if($r1['regional_university']!=null){
			   $regional_university = $r1['regional_university'];
			}
			}

			$confirmData = $universitiesCache[$regional_university] ?? [];
			$region      = $regionsCache[$region_one_status] ?? [];
			$gender      = $r1['gender'] == 1 ? 'Male' : ($r1['gender'] == 2 ? 'Female' : '');
			$stream      = $courseTypeCache[$r1['course_type']] ?? '';

			if (!empty($r1['new_travel_date'])) {
				try {
					$dt = new DateTime($r1['new_travel_date']);
					$travel_arrival_date = $dt->format("d-m-Y");
				} catch (Exception $e) {
					$travel_arrival_date = null;
				}
			} else {
				$travel_arrival_date = null;
			}

			$responseApi[$key1]['application_no']=$r1['application_no'];
			$responseApi[$key1]['first_name']=$r1['fullname'];
			$responseApi[$key1]['middle_name']=$r1['middlename'];
			$responseApi[$key1]['last_name']=$r1['familyname'];
			$responseApi[$key1]['gender']=$gender;
			$responseApi[$key1]['email']=$r1['email'];
			$responseApi[$key1]['country_name']=$r1['country_name'];
			$responseApi[$key1]['mission_name']=$iccr_missions->mission_name ?? '';
			$responseApi[$key1]['Name and Code of Scholarship Scheme']=$scheme[0]['scheme_name'] ?? '';
			$responseApi[$key1]['Level (UG/PG/ PhD/MPhil/ Post Doctoral)']=$program[0]['name'] ?? '';
			$responseApi[$key1]['course_name']=$r1['final_course'];
			$responseApi[$key1]['stream']=$stream;
			$responseApi[$key1]['Name Of University/Institute']=$confirmData[0]['name'] ?? '';
			$responseApi[$key1]['ZO/S-ZO/RPO']=$region[0]['name'] ?? '';
			$responseApi[$key1]['phone_number']=$r1['phone_number'];
			$responseApi[$key1]['whatsapp_number']=$r1['whatsapp_number'];
			$responseApi[$key1]['passport_no']=$r1['passport_no'];
			$responseApi[$key1]['passport_issue_date']=$r1['passport_issue_date'];
			$responseApi[$key1]['passport_expiry_date']=$r1['passport_expiry_date'];
			$responseApi[$key1]['passport_issue_place']=$r1['passport_issue_place'];
			$responseApi[$key1]['acedemic_year']=$r1['acedemic_year'];
			$responseApi[$key1]['place_of_birth']=$r1['city'];
			$responseApi[$key1]['visa_no']=$r1['visa_no'];
			$responseApi[$key1]['visa_isuue_date']=$visa_isuue_date;
			$responseApi[$key1]['visa_expiry_date']=$visa_to_date;
			$responseApi[$key1]['date_of_arrival']=$travel_arrival_date;
			$responseApi[$key1]['date_of_joining']=$date_of_joining;
			$responseApi[$key1]['duration_of_course']=$duration_of_course;
			$responseApi[$key1]['created_date']=$undertaking_date;
		}
		echo json_encode($responseApi);
	}else{
		$error = array(
            'message' => "secret token and secret key wrong",
            'status' => false
        );
		echo json_encode($error);
	}
	   }


	   function confirmedApplicationAPI(){
		$secretkey=$this->input->request_headers();
		
     	$getTokken = $this->db->get_where('iccr_header_token',array('secret_token'=>$secretkey['Secrettoken'],'secret_key'=>$secretkey['Secretkey']))->num_rows();

		//echo $getTokken; die;
	   	if($getTokken>0){
		$year = $this->uri->segment(3);
		$application = $this->uri->segment(4);
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      

		$result = $this->hqrs_model->getSingleStudentData($year,$res,$application);

		//print_r($result); die;
		
		$response = array();
		if(!empty($result))
		{
			
			foreach($result as $key=>$r)
			{
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				$gender = "";
				$output= array();	
			
				$output[$key]['fullname'] = $applicationDetails[0]['fullname'];
				$output[$key]['email'] = $applicationDetails[0]['email'];
				$output[$key]['application_no'] = $r['application_no'];
						
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$course = $this->common_model->getCoursesById($applicationDetails[0]['course']);
					$course1 = $this->common_model->getCoursesById($applicationDetails[0]['course_two']);
					$course2 = $this->common_model->getCoursesById($applicationDetails[0]['course_three']);
					$fullCourse ="";
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'_';
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'_';
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'_';
					$output[] = $fullCourse;
				}
				
				$universityDetails = "";
				$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				$universityDetails .= '1) '.$uni1[0]['name'].'_';
				$universityDetails .= '2) '.$uni2[0]['name'].'_';
				$universityDetails .= '3) '.$uni3[0]['name'].'_';
				$output[] = $universityDetails;			
				$scheme = $this->common_model->getSchemeById($r['scholarship_id']);
				$output[] =	$scheme[0]['scheme_name'];		
				$output[] = $country[0]['country_name'];
				$output[] = date("d-m-Y", $r['created']);
				$response[] = $output;
			}
		}

		$returnJson['data'] = $response;
		$responseApi = array();
		
		foreach($result as $key1=>$r1)
		{
			$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r1['application_no']);
			$iccr_missions = $this->db->get_where('iccr_missions',array('id'=>$r1['application_through']))->row();
			$scheme = $this->common_model->getSchemeById($r1['scholarship_id']);
			$confirmData = $this->common_model->getFinalUniversityById($r1['regional_university']);	
			$region = $this->common_model->getRegionById($r1['region_one_status']);
			$program = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);

			if($r['undertaking_doc']!=""){
                $undertaking_date=date('d-m-Y',$r1['undertaking_doc']);
            }else{
                $undertaking_date="";
            }

			$visa_isuue_date="";
			if($r1['visa_isuue_date']!=null){
			  $visa_isuue_date=date_format(date_create($r1['visa_isuue_date']),'d-m-Y');
		   	}

			$visa_to_date="";
			if($r1['visa_to_date']!=null){
				$visa_to_date=date_format(date_create($r1['visa_to_date']),'d-m-Y');
			}

			$date_of_joining="";
			if($r1['date_of_joining']!=null){
				$date_of_joining=date_format(date_create($r1['date_of_joining']),'d-m-Y');
			}

			// echo '<pre>'; print_r($region);die;
			
			$responseApi[$key1]['application_no']=$r1['application_no'];
			$responseApi[$key1]['first_name']=$r1['fullname'];
			$responseApi[$key1]['middle_name']=$r1['middlename'];
			$responseApi[$key1]['last_name']=$r1['familyname'];
			$responseApi[$key1]['email']=$r1['email'];
			$responseApi[$key1]['country_name']=$r1['country_name'];
			$responseApi[$key1]['mission_name']=$iccr_missions->mission_name;
			$responseApi[$key1]['scheme_name']=$scheme[0]['scheme_name'];
			$responseApi[$key1]['level_of_course']=$program[0]['name'];
			$responseApi[$key1]['course_name']=$r1['final_course'];
			$responseApi[$key1]['university_name']=$confirmData[0]['name'];
			$responseApi[$key1]['region_name']=$region[0]['name'];
			$responseApi[$key1]['phone_number']=$r1['phone_number'];
			$responseApi[$key1]['whatsapp_number']=$r1['whatsapp_number'];
			$responseApi[$key1]['passport_no']=$r1['passport_no'];
			$responseApi[$key1]['passport_issue_date']=$r1['passport_issue_date'];
			$responseApi[$key1]['passport_expiry_date']=$r1['passport_expiry_date'];
			$responseApi[$key1]['passport_issue_place']=$r1['passport_issue_place'];
			$responseApi[$key1]['acedemic_year']=$r1['acedemic_year'];
			$responseApi[$key1]['place_of_birth']=$r1['city'];
			$responseApi[$key1]['visa_no']=$r1['visa_no'];
			$responseApi[$key1]['visa_isuue_date']=$visa_isuue_date;
			$responseApi[$key1]['visa_expiry_date']=$visa_to_date;
			$responseApi[$key1]['date_of_arrival']=$r1['travel_arrival_date'];
			$responseApi[$key1]['date_of_joining']=$date_of_joining;
			$responseApi[$key1]['duration_of_course']=$r1['duration_of_course'];
			$responseApi[$key1]['created_date']=$undertaking_date;


		}
		echo json_encode($responseApi);
	}else{
		$error = array(
            'message' => "secret token and secret key wrong",
            'status' => false
        );  
		echo json_encode($error);
	}
	   }



	   function ayushStudentAPI(){

		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
		$secretkey=$this->input->request_headers();
		
     	$getTokken = $this->db->get_where('iccr_header_token',array('secret_token'=>$secretkey['Secrettoken'],'secret_key'=>$secretkey['Secretkey']))->num_rows();

		//echo $getTokken; die;
	   	if($getTokken>0){
		$year = $this->uri->segment(3);
        $res = array(
            'iccr_status' => 1,
            'status' => 4
        );      

		$result = $this->hqrs_model->getAllAyushData($year,$res);

		//print_r($result); die;
		
		$response = array();
		if(!empty($result))
		{
			
			foreach($result as $key=>$r)
			{
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				$gender = "";
				$output= array();	
			
				$output[$key]['fullname'] = $applicationDetails[0]['fullname'];
				$output[$key]['email'] = $applicationDetails[0]['email'];
				$output[$key]['application_no'] = $r['application_no'];
						
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$course = $this->common_model->getCoursesById($applicationDetails[0]['course']);
					$course1 = $this->common_model->getCoursesById($applicationDetails[0]['course_two']);
					$course2 = $this->common_model->getCoursesById($applicationDetails[0]['course_three']);
					$fullCourse ="";
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'_';
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'_';
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'_';
					$output[] = $fullCourse;
				}
				
				$universityDetails = "";
				$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				$universityDetails .= '1) '.$uni1[0]['name'].'_';
				$universityDetails .= '2) '.$uni2[0]['name'].'_';
				$universityDetails .= '3) '.$uni3[0]['name'].'_';
				$output[] = $universityDetails;			
				$scheme = $this->common_model->getSchemeById($r['scholarship_id']);
				$output[] =	$scheme[0]['scheme_name'];		
				$output[] = $country[0]['country_name'];
				$output[] = date("d-m-Y", $r['created']);
				$response[] = $output;
			}
		}

		$returnJson['data'] = $response;
		$responseApi = array();
		
		foreach($result as $key1=>$r1)
		{
			$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r1['application_no']);
			$iccr_missions = $this->db->get_where('iccr_missions',array('id'=>$r1['application_through']))->row();
			$scheme = $this->common_model->getSchemeById($r1['scholarship_id']);
			$confirmData = $this->common_model->getFinalUniversityById($r1['regional_university']);	
			$region = $this->common_model->getRegionById($r1['region_one_status']);
			$program = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);


			if($applicationDetails[0]['course_type'] == 1) {
				if($r1['region_one_status_date']!=""){
					$undertaking_date=date('d-m-Y',$r1['region_one_status_date']);
				}else{
					$undertaking_date="";
				}
			}
			else {
				if($r1['undertaking_doc']!=""){
					$undertaking_date=date('d-m-Y',$r1['undertaking_doc']);
				}else{
					$undertaking_date="";
				}
			}
			 $visa_isuue_date="";
			  if($r1['visa_isuue_date']!=null){
                $visa_isuue_date=date_format(date_create($r1['visa_isuue_date']),'d-m-Y');
             }

			 $visa_to_date="";
			 if($r1['visa_to_date']!=null){
			   $visa_to_date=date_format(date_create($r1['visa_to_date']),'d-m-Y');
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$date_of_joining="";
			 if($r1['date_of_joining_ayush']!=null){
			   $date_of_joining=date_format(date_create($r1['date_of_joining_ayush']),'d-m-Y');
			}
			}
			else {
				$date_of_joining="";
			 if($r1['date_of_joining']!=null){
			   $date_of_joining=date_format(date_create($r1['date_of_joining']),'d-m-Y');
			}
			}

			if($applicationDetails[0]['course_type'] == 1) {
				$duration_of_course="";
			 if($r1['duration_of_course_ayush']!=null){
			   $duration_of_course = $r1['duration_of_course_ayush'];
			}
			}
			else {
				$duration_of_course="";
			 if($r1['duration_of_course']!=null){
			   $duration_of_course = $r1['duration_of_course'];
			}
			}

			// echo '<pre>'; print_r($region);die;
			
			$responseApi[$key1]['application_no']=$r1['application_no'];
			$responseApi[$key1]['first_name']=$r1['fullname'];
			$responseApi[$key1]['middle_name']=$r1['middlename'];
			$responseApi[$key1]['last_name']=$r1['familyname'];
			$responseApi[$key1]['email']=$r1['email'];
			$responseApi[$key1]['country_name']=$r1['country_name'];
			$responseApi[$key1]['mission_name']=$iccr_missions->mission_name;
			$responseApi[$key1]['scheme_name']=$scheme[0]['scheme_name'];
			$responseApi[$key1]['programme']=$program[0]['name'];
			$responseApi[$key1]['course_name']=$r1['final_course'];
			$responseApi[$key1]['university_name']=$confirmData[0]['name'];
			$responseApi[$key1]['region_name']=$region[0]['name'];
			$responseApi[$key1]['phone_number']=$r1['phone_number'];
			$responseApi[$key1]['whatsapp_number']=$r1['whatsapp_number'];
			$responseApi[$key1]['passport_no']=$r1['passport_no'];
			$responseApi[$key1]['passport_issue_date']=$r1['passport_issue_date'];
			$responseApi[$key1]['passport_expiry_date']=$r1['passport_expiry_date'];
			$responseApi[$key1]['passport_issue_place']=$r1['passport_issue_place'];
			$responseApi[$key1]['acedemic_year']=$r1['acedemic_year'];
			$responseApi[$key1]['place_of_birth']=$r1['city'];
			$responseApi[$key1]['visa_no']=$r1['visa_no'];
			$responseApi[$key1]['visa_isuue_date']=$visa_isuue_date;
			$responseApi[$key1]['visa_expiry_date']=$visa_to_date;
			$responseApi[$key1]['date_of_arrival']=$r1['travel_arrival_date'];
			$responseApi[$key1]['date_of_joining']=$date_of_joining;
			// $responseApi[$key1]['duration_of_course']=$r1['duration_of_course'];
			$responseApi[$key1]['duration_of_course']=$duration_of_course;
			$responseApi[$key1]['created_date']=$undertaking_date;

		}
		echo json_encode($responseApi);
	}else{
		$error = array(
            'message' => "secret token and secret key wrong",
            'status' => false
        );  
		echo json_encode($error);
	}
   }







		public function index()
		{
	
			//echo "<pre>";print_r($_SERVER);
		    $data['captcha']= $this->createCaptcha( array(
		    'min_length' => 7,
		    'max_length' => 7,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz123456789',
		    'min_font_size' => 24,
		    'max_font_size' => 24,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));	
			//echo FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png';
			//print_r($captcha);
			//die;
			$data['salt'] = $this->random_string();
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			//$this->load->view('site/sidebar');
			$this->load->view('site/home',$data);
			$this->load->view('site/footer');
		}


		public function newnotification()
		{
			$this->load->view('site/header');
			$this->load->view('site/newnotification');
			$this->load->view('site/footer');
		}


		 public function sendMail($message_body,$email,$subject,$view)
   {
   		try{
   	 		$message = '';                
            //$message .= '<strong>Dear Applicant ('.$email.'),</strong><br><br>';
            $message .= $message_body;
        	$data = array(
			    'content' => $message					   
			);
        	$config = Array(
		        'mailtype' => 'html'				        
		     );
			 $config['protocol']    = 'smtp';
							//$config['smtp_host']    = 'relay.nic.in';
							//$config['smtp_port']    = '25';
							//$config['smtp_timeout'] = '7';
												
							//$config['smtp_user']    = 'kip.support@mea.gov.in';
							//$config['smtp_pass']    = 'Kip@Mea@123';
							$config['charset']    = 'utf-8';
							$config['newline']    = "\r\n";							
							//$this->email->initialize($config);
		     $content = $this->load->view($view,$data, true); 
		     $from_email = "splspd.iccr@nic.in"; 
			 $to_email = $email; 			   
			 /* Load email library */
			 $this->load->library('email',$config);			   
			 $this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
			 $this->email->to($to_email);
			 $this->email->subject($subject); 
			 $this->email->message($content); 			   
			 if($this->email->send()) 
			  {
			 	 return TRUE;
			  }					
			  else 
			 	 return FALSE;
		   } catch (Exception $e){
		   	
		   }
   }
		public function random_string()
		{
			$character_set_array = array();
			$character_set_array[] = array('count' => 4, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
			$character_set_array[] = array('count' => 4, 'characters' => '0123456789');
			$temp_array = array();
			foreach ($character_set_array as $character_set) {
				for ($i = 0; $i < $character_set['count']; $i++) {
					$temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
				}
			}
			shuffle($temp_array);
			return implode('', $temp_array);
		}
		public function forgotPassword()
		{
			$data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 7,
		    'max_length' => 7,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz123456789',
		    'min_font_size' => 24,
		    'max_font_size' => 24,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));			
			$data['salt'] = $this->random_string();
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			$this->load->view('site/forgotpassword',$data);
			$this->load->view('site/footer');
		}
		public function forgot_password() 
		{
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[5]|max_length[125]');
			if ($this->form_validation->run() == FALSE) 
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'No such user');	
			} 
			else 
			{	
				$year = date("Y");
				
				$post = $this->input->post(NULL, TRUE);
				
				$cleanPost = $this->security->xss_clean($post);
				if($this->isValidCaptch($cleanPost['userCaptcha']))
				{
					$email = $this->input->post('email');
					
					$userType = $this->user_model->checkForgetType($email,$year);
					
					if($cleanPost['year']!= '' && !empty($cleanPost['year']) && $userType->user_type == 1)
					{
						$num_res = $this->user_model->checkForgetWithType($email,$cleanPost['year']);
						//print_r($num_res );die;
					}
					else
					{
						
						if($userType->user_type == 1){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select registration year');
							redirect('home/forgotPassword');
						}
						
						else{
							if($cleanPost['year']!= ''){
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error','Please select valid email id!');
								$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Kindly Check Your Email to Reset Password!');
								redirect('home/forgotPassword');
								return false;
							}
							$num_res = $this->user_model->checkForgetWithoutYear($email);
							
						}
					}
					
					
					if ($num_res == 1) 
					{
						// Make a small string (code) to assign to the user // to indicate they've requested a change of // password
						$code = mt_rand('5000', '200000');
						$code = md5($code);
						$data = array(
						'token' => $code,
						'pass_updated_count'=>0
						);
						
						//$this->db->where('email_id', $email);
						
						
						$year = isset($cleanPost['year'])?$cleanPost['year']:'';
						if(!empty($year)){
							
							$pass_res = $this->user_model->checkForgetPass($email,$year,$data);
							//print_r($pass_res);DIE;
						}
						
						if($pass_res == 1) 
						{
		
							
							// Update okay, send email
							$url     = site_url() . 'home/completePassword/' . $code;
							$link    = '<a href="' . $url . '">Please click the link to reset the password! »</a>';
							$message = 'Please click the link below to reset your password.<br>' . $link;
							$data    = array('content' => $message);

							$config = array(
								'mailtype'     => 'html',
								'protocol'     => 'smtp',
								'smtp_host'    => 'relay.nic.in',
								'smtp_port'    => '25',
								'smtp_timeout' => '7',
								'charset'      => 'utf-8',
								'newline'      => "\r\n",
							);

							$content    = $this->load->view('mail_signup', $data, true);
							$from_email = $this->config->item('fromEmail');
							$to_email   = $this->input->post('email');

							$this->load->library('email');
							$this->email->initialize($config);
							$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)');
							$this->email->to($to_email);
							$this->email->subject('Reset Your Password - ICCR Scholarship Portal');
							$this->email->message($content);

							if($this->email->send())
							{
								$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Kindly Check Your Email to Reset Password!');
								redirect(site_url().'home/forgotPassword');
							}
							else
							{
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error', 'Email could not be sent. Please try again later.');
								redirect(site_url().'home/forgotPassword');
							}
							
							
							
						} 
						else 
						{ 
							//$this->session->set_flashdata('message_type', 'error');
							//$this->session->set_flashdata('error', 'Invalid Detail');
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Kindly Check Your Email to Reset Password!');
							redirect(site_url().'home/forgotPassword');
						}
					} 
					else
					{ 
						//$this->session->set_flashdata('message_type', 'error');
						//$this->session->set_flashdata('error', 'Invalid Detail');
						$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Kindly Check Your Email to Reset Password!');
						redirect(site_url().'home/forgotPassword');
					}
				}
				else
				{
					//$this->session->set_flashdata('message_type', 'error');
					//$this->session->set_flashdata('error', 'Wrong Text Entered');
					$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Kindly Check Your Email to Reset Password!');
					redirect(site_url().'home/forgotPassword');
				}
			}
		}

		public function testSmtp()
		{
			$config = array(
				'mailtype'     => 'html',
				'protocol'     => 'smtp',
				'smtp_host'    => 'relay.nic.in',
				'smtp_port'    => '25',
				'smtp_timeout' => '7',
				'charset'      => 'utf-8',
				'newline'      => "\r\n",
			);

			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->from('splspd.iccr@nic.in', 'ICCR Test');
			$this->email->to('jhaabhishek910@gmail.com');
			$this->email->subject('SMTP Test');
			$this->email->message('If you see this, SMTP is working.');

			if($this->email->send()) {
				echo 'Email sent successfully!';
			} else {
				echo $this->email->print_debugger();
			}
		}
		public function completePassword() 
		{

			
			$year = date("Y");
			$data['salt'] = uniqid(rand(59999, 199999));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('code', 'Code', 'required|min_length[4]|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[5]|max_length[125]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[125]');
			$this->form_validation->set_rules('password2', 'Confirmation Password', 'required|min_length[8]|max_length[45]|matches[password]');
			
			// Get Code from URL or POST and clean up
			$var = $this->uri->segment(3);
			if(!empty($var))
			{
				$passUpdatedCount = $this->common_model->checkPasswordUpdatedCount($var);	
				//echo "<pre>";print_r($passUpdatedCount);die;
				if($passUpdatedCount[0]['pass_updated_count'] == 1)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Your token has been expire.Please Try Again.');
					redirect(site_url().'home');
					return false;
				}
			}
			
			if($this->input->post()) 
			{
				$data['code'] = xss_clean($this->input->post('code'));
			} 
			else 
			{
				$data['code'] = xss_clean($this->uri->segment(3));
			}
			
			if($this->form_validation->run() == FALSE) 
			{
				
				$data['captcha'] = $this->getCaptchaForPassword();
				$this->load->view('site/header');
				$this->load->view('site/new_password',$data);
				$this->load->view('site/footer');
			} 
			else 
			{
				// Does code from input match the code against the // email
				// $this->load->model('Signin_model');
				$post = $this->input->post(NULL, TRUE);
				$cleanPost = $this->security->xss_clean($post);	
				//echo "<pre>";
				//print_r($cleanPost);
				//print_r($data['code']);die;
				//die;
				if($this->isValidCaptch($cleanPost['userCaptcha']))
				{
					$email = xss_clean($this->input->post('email'));
					if (!$this->common_model->does_code_match($data['code'], $email)) 
					{
						// Code doesn't match
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Invalid Detail, Please Try Again.');
						redirect(site_url().'home/completePassword');
					} 
					else 
					{
						$password = $this->input->post('password');
						$hash = $password;
						//echo $hash; die;
						$data = array(
						'password' => $hash,
						'pass_updated_count'=>1
						);
					
					$userType = $this->user_model->checkForgetType($email,$year);
					//echo "<pre>";print_r($userType);die;
					if($cleanPost['year']!= '' && !empty($cleanPost['year']) && $userType->user_type == 1)
					{
//echo $email;
//print_r($data);
//die();
						$update_pas = $this->common_model->update_userpass($email,'',$data);					}
					else
					{
						
						if($userType->user_type == 1){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select registration year');
							redirect('home/completePassword');
						}
						
						else{
							if($cleanPost['year']!= ''){
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error','Please select valid option!');
								redirect('home/completePassword');
								return false;
							}
							$update_pas = $this->common_model->update_userpass($email,$cleanPost['year'],$data);
							
						}
					}
						if($update_pas) 
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Password Update Successfully!');
							redirect(site_url().'home');
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Password is not Update Successfully');
							redirect(site_url().'home');							 
						}
					}
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Wrong Text Entered');
					redirect(site_url().'home/completePassword');
				}
			}
		}
		public function getCaptchaForPassword()
		{
			$data['captcha'] = $this->createCaptcha( array(
			'min_length' => 5,
			'max_length' => 5,
			'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
			'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/times_new_yorker.ttf'),
			'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
			'min_font_size' => 28,
			'max_font_size' => 28,
			'color' => '#666',
			'angle_min' => 0,
			'angle_max' => 10,
			'shadow' => true,
			'shadow_color' => '#fff',
			'shadow_offset_x' => -1,
			'shadow_offset_y' => 1
			));	
			$this->session->set_userdata('captcha_code',$data['captcha']);
			
			return $data; 
		}
		public function getAllSchemeList()
		{
		 
		  $data['schemes'] = $this->common_model->getAllSchemes();
		  //print_r($data);exit;
		  $this->load->view('site/header');
		  $this->load->view('site/schemes',$data);
		  $this->load->view('site/footer');
		}
		function isValidCaptch($captchText)
		{
			//echo $captchText;die;
			$sessionData = $this->session->userdata('captcha_code');
			$sessionText = $sessionData['code'];
			//echo $captchText."=====".$sessionText;die;
			return ($captchText == $sessionText) ? TRUE : FALSE;
		}
		public function test()
		{
			$this->load->view('site/header');
			$this->load->view('site/test');
			$this->load->view('site/footer');
		}
		public function faqs()
		{
			$this->load->view('site/header');
			$this->load->view('site/faqs');
			$this->load->view('site/footer');
		}
		public function contactus()
		{
			$this->load->view('site/header');
			$this->load->view('site/contactus');
			$this->load->view('site/footer');
		}
		public function termsandconditions()
		{
			$this->load->view('site/header');
			$this->load->view('site/termsandconditions');
			$this->load->view('site/footer');
		}	
		public function disclaimer()
		{
			$this->load->view('site/header');
			$this->load->view('site/disclaimer');
			$this->load->view('site/footer');
		}
		public function privacy()
		{
			$this->load->view('site/header');
			$this->load->view('site/privacy');
			$this->load->view('site/footer');
		}
		public function copyright()
		{
			$this->load->view('site/header');
			$this->load->view('site/copyright');
			$this->load->view('site/footer');
		}
		public function hyperlink()
		{
			$this->load->view('site/header');
			$this->load->view('site/hyperlink');
			$this->load->view('site/footer');
		}
		public function help()
		{
			$this->load->view('site/header');
			$this->load->view('site/help');
			$this->load->view('site/footer');
		}
		public function universitieslist()
		{
			$this->load->view('site/header');
			$this->load->view('site/universitieslist');
			$this->load->view('site/footer');
		}
		
		public function stateuniversitiesList()
		{
			$this->load->view('site/header');
			$this->load->view('site/stateuniversitiesList');
			$this->load->view('site/footer');
		}
		
		
		public function centraluniversitiesList()
		{
			$this->load->view('site/header');
			$this->load->view('site/centraluniversitiesList');
			$this->load->view('site/footer');
		}
		
		public function nitList()
		{
			$this->load->view('site/header');
			$this->load->view('site/nitList');
			$this->load->view('site/footer');
		}
		
		
		public function niftList()
		{
			$this->load->view('site/header');
			$this->load->view('site/niftList');
			$this->load->view('site/footer');
		}
		
		public function ayushList()
		{
			$this->load->view('site/header');
			$this->load->view('site/ayushList');
			$this->load->view('site/footer');
		}
		
		public function icarList()
		{
			$this->load->view('site/header');
			$this->load->view('site/icarList');
			$this->load->view('site/footer');
		}
		
		
		public function guruList()
		{
			$this->load->view('site/header');
			$this->load->view('site/guruList');
			$this->load->view('site/footer');
		}
		
		public function cities()
		{
			$this->load->view('site/header');
			$this->load->view('site/cities');
			$this->load->view('site/footer');
		}
		public function getCity()
		{
			$filename = $this->uri->segment(3);
			$this->load->view('site/header');
			$this->load->view('site/cities/'.$filename.'.php');
			$this->load->view('site/footer');
		}
		public function register()
		{	
			$data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 7,
		    'max_length' => 7,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz123456789',
		    'min_font_size' => 28,
		    'max_font_size' => 28,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));			
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			 //$this->load->view('site/home',$data);
			$this->load->view('site/register',$data);
			$this->load->view('site/footer');
		}

		public function newregisterforchina2022()
		{	
			
		//echo " ";die;
			$data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 5,
		    'max_length' => 5,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
		    'min_font_size' => 28,
		    'max_font_size' => 28,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));			
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			//$this->load->view('site/home',$data);
			 $this->load->view('site/china_register',$data); 
			$this->load->view('site/footer');
		}	
		
		public function getDob()
		{
			
			$response = array('status'=>FALSE,'jsondata'=>array());
			$year=$this->input->post('year'); 
			$month = $this->input->post('month'); 
			$date = $this->input->post('date');
			$dob=$date.'/'.$month.'/'.$year;
			$condate='01/07/2025';
			$birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $dob))))));
			$today= new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $condate))))));$age = $birthdate->diff($today)->y;
			
			if(($age >= 18) && ($age < 40))
			{
				$response['status'] = TRUE;
				//$response['jsondata'] = $data;
			}
			else{
				$response['status'] = FALSE;
				
			}
			echo json_encode($response);
		}

		public function getAyushDob()
		{
			
			$response = array('status'=>FALSE,'jsondata'=>array());
			$year=$this->input->post('year'); 
			$month = $this->input->post('month'); 
			$date = $this->input->post('date');
			$dob=$date.'/'.$month.'/'.$year;
			$condate='01/07/2025';
			$birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $dob))))));
			$today= new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $condate))))));$age = $birthdate->diff($today)->y;
			
			if(($age >= 18) && ($age < 100))
			{
				$response['status'] = TRUE;
				//$response['jsondata'] = $data;
			}
			else{
				$response['status'] = FALSE;
				
			}
			echo json_encode($response);
		}

		
		public function getDiplomaDob()
		{
			
			$response = array('status'=>FALSE,'jsondata'=>array());
			$year=$this->input->post('year'); 
			$month = $this->input->post('month'); 
			$date = $this->input->post('date');
			$dob=$date.'/'.$month.'/'.$year;
			$condate='01/07/2025';
			$birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $dob))))));
			$today= new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $condate))))));$age = $birthdate->diff($today)->y;
			
			if(($age >= 18) && ($age < 100))
			{
				$response['status'] = TRUE;
				//$response['jsondata'] = $data;
			}
			else{
				$response['status'] = FALSE;
				
			}
			echo json_encode($response);
		}

		
		function random_num($size) 
		{
		$alpha_key = '';
		$keys = range('A', 'Z');

		for ($i = 0; $i < 2; $i++) {
			$alpha_key .= $keys[array_rand($keys)];
		}
		$length = $size - 2;
		$key = '';
		$keys = range(0, 9);

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}
		return $alpha_key . $key;
		}
	
	
		function alumniApplications()
		{
		try{
			
			 $data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 5,
		    'max_length' => 5,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
		    'min_font_size' => 28,
		    'max_font_size' => 28,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));			
			$data['salt'] = $this->random_string();
			$this->session->set_userdata('captcha_val',$data['captcha']);  
			$data['get_application_number'] = $this->random_num(15);
			$this->load->view('site/header');
			$this->load->view('site/alumni_applications',$data);
			$this->load->view('site/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'site/dashboard');
		}
		}

		public function alumini_register()
		{		
			$data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 5,
		    'max_length' => 5,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
		    'min_font_size' => 28,
		    'max_font_size' => 28,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));			
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			$this->load->view('site/alumini_register',$data);
			$this->load->view('site/footer');
		}
		public function sfs_register()
		{		
		 
			$data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 5,
		    'max_length' => 5,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
		    'min_font_size' => 28,
		    'max_font_size' => 28,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));			
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			$this->load->view('site/home',$data);
			// $this->load->view('site/sfs_register',$data);
			$this->load->view('site/footer');
		}

		public function kazakhstan_register()
		{		
		 
			$data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 5,
		    'max_length' => 5,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
		    'min_font_size' => 28,
		    'max_font_size' => 28,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			//$this->load->view('site/home',$data);
			$this->load->view('site/kazakhstan_register',$data);
			$this->load->view('site/footer');
		}

		public function iccr_register()
		{		
			$data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 5,
		    'max_length' => 5,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
		    'min_font_size' => 28,
		    'max_font_size' => 28,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));			
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			// $this->load->view('site/home',$data);
			$this->load->view('site/iccr_register',$data);
			$this->load->view('site/footer');
		}
		public function complete()
		{
			try{
				$token      = base64_decode($this->uri->segment(4));
				//echo $token;die;
				$cleanToken = $this->security->xss_clean($token);
				$user_info  = $this->user_model->isTokenValid($cleanToken);
				if (!is_object($user_info)) {
					echo '<script>window.location.href="'.site_url().'home?text=Token is invalid or expired!.&type=Error Message&at=danger&redirect='.site_url().'home";</script>';
					return;  
				}
				$data = array(
	            'firstName' => $user_info->username,
	            'email' => $user_info->email_id,
	            'user_id' => $user_info->id,
	            'token' => $this->base64url_encode($token)
				);
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
				$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
				if ($this->form_validation->run() == FALSE) {
					$this->load->view('site/header');
					$this->load->view('site/complete', $data);
					$this->load->view('site/footer');
					} else {
					$post                  = $this->input->post(NULL, TRUE);
					$cleanPost             = $this->security->xss_clean($post);
					$hashed                = sha1($cleanPost['password']);
					$cleanPost['password'] = $hashed;
					$cleanPost['user_id'] =  $user_info->id;
					unset($cleanPost['passconf']);
					$userInfo = $this->user_model->updateUserInfo($cleanPost);
					if(is_object($userInfo) && property_exists($userInfo,"username"))
					{
						unset($userInfo->password);
						/* $datas = array(
						'userid'=> $userInfo->id,
						'fname'=> $userInfo->username,
						'email'=> $userInfo->email_id,
						'user_type'=> $userInfo->user_type	
						
						); */
						
						$datas = array(
						 'userid'=> $userInfo->id,
						 'fname'=> $userInfo->username,
						 'email'=> $userInfo->email_id,
						 'user_type'=> $userInfo->user_type,
						 'state'=>$userInfo->state,
						 'university'=>$userInfo->university,
						 'user_country'=>$userInfo->user_country,
						 'created'=>$userInfo->created,
						 'apply_course_type'=>$userInfo->apply_course_type,
						 'student_type'=>$userInfo->student_type,
						 'dir'=>$userInfo->dir
						);
						$this->session->set_userdata('user_data',$datas);   
						echo '<script>window.location.href="'.site_url().'home?text=Login Successfully!.&type=Thank You!&at=success&redirect='.site_url().'Applicant/dashboard";</script>';       
						
					}
					else
					{
						if (!$userInfo) {            	
							$this->session->set_flashdata('flash_message', 'There was a problem updating your record');
							echo '<script>window.location.href="'.site_url().'home?text=There was a problem updating your record!.&type=Error Message!&at=danger&redirect='.site_url().'home";</script>';  
						}
					}
				}
			}
			catch(Exception $e)
			{
				echo '<script>window.location.href="'.site_url().'home?text=Internal Server Error. Try After Some Time!&type=Error Message!&at=danger&redirect='.site_url().'home";</script>';			
			}
		} 
		public function applicant_guidlines()
		{
			$this->load->view('site/header');
			$this->load->view('site/applicant_guidlines');
			$this->load->view('site/footer');
		}
		public function lists()
		{
			$this->load->view('site/header');
			$this->load->view('site/lists');
			$this->load->view('site/footer');
		}   
		public function about()
		{
			$this->load->view('site/header');
			$this->load->view('site/about');
			$this->load->view('site/footer');
		}
		public function scheme()
		{
			$this->load->view('site/header');
			$this->load->view('site/schemes');
			$this->load->view('site/footer');
		}
		public function instructions()
		{
			$this->load->view('site/header');
			$this->load->view('site/instructions');
			$this->load->view('site/footer');
		}	
		public function createCaptcha($config = array())
		{
			 if( !function_exists('gd_info') ) {
				throw new Exception('Required GD library is missing');
			}
			
			$bg_path = dirname(__FILE__) . 'assets/site/main/images/captcha_bg/backgrounds/';
			$font_path = dirname(__FILE__) . 'assets/site/main/fonts/captcha_fonts/';
			
			// Default values
			$captcha_config = array(
	        'code' => '',
	        'min_length' => 6,
	        'max_length' => 6,
	        'backgrounds' => array(
			$bg_path . '45-degree-fabric.png',
			$bg_path . 'cloth-alike.png',
			$bg_path . 'grey-sandbag.png',
			$bg_path . 'kinda-jean.png',
			$bg_path . 'polyester-lite.png',
			$bg_path . 'stitched-wool.png',
			$bg_path . 'white-carbon.png',
			$bg_path . 'white-wave.png'
	        ),
	        'fonts' => array(
			$font_path . 'opensans-semibold-webfont.ttf'
	        ),
	        'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
	        'min_font_size' => 20,
	        'max_font_size' => 28,
	        'color' => '#666',
	        'angle_min' => 0,
	        'angle_max' => 10,
	        'shadow' => true,
	        'shadow_color' => '#fff',
	        'shadow_offset_x' => -1,
	        'shadow_offset_y' => 1
			);
			
			// Overwrite defaults with custom config values
			if( is_array($config) ) {
				foreach( $config as $key => $value ) $captcha_config[$key] = $value;
			}
			
			// Restrict certain values
			if( $captcha_config['min_length'] < 1 ) $captcha_config['min_length'] = 1;
			if( $captcha_config['angle_min'] < 0 ) $captcha_config['angle_min'] = 0;
			if( $captcha_config['angle_max'] > 10 ) $captcha_config['angle_max'] = 10;
			if( $captcha_config['angle_max'] < $captcha_config['angle_min'] ) $captcha_config['angle_max'] = $captcha_config['angle_min'];
			if( $captcha_config['min_font_size'] < 10 ) $captcha_config['min_font_size'] = 10;
			if( $captcha_config['max_font_size'] < $captcha_config['min_font_size'] ) $captcha_config['max_font_size'] = $captcha_config['min_font_size'];
			
			// Generate CAPTCHA code if not set by user
			if( empty($captcha_config['code']) ) {
				$captcha_config['code'] = '';
				$length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
				while( strlen($captcha_config['code']) < $length ) {
					$captcha_config['code'] .= substr($captcha_config['characters'], mt_rand() % (strlen($captcha_config['characters'])), 1);
				}
			}
			$image_src = site_url().'home/getCaptcha?_CAPTCHA&amp;t=' . urlencode(microtime());
			
			$cnfg = array('config'=>serialize($captcha_config));
			$this->session->set_userdata('captcha',$cnfg);	
		     // $_SESSION['captcha']=$cnfg;

			return array(
	        'code' => $captcha_config['code'],
	        'image_src' => $image_src
			);
		}
		public function getCaptcha()
		{	
			
			$captcha_cnf = array();		
			$cnf = $this->session->userdata('captcha');		
           // $cnf = $_SESSION['captcha'];	
                 		 
			$captcha_config = unserialize($cnf['config']);			
			
			if( !$captcha_config ) exit();
			
			//$this->session->unset_userdata('captcha');	    
			
			// Pick random background, get info, and start captcha
			$background = $captcha_config['backgrounds'][mt_rand(0, count($captcha_config['backgrounds']) -1)];
			list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);
			
			$captcha = imagecreatefrompng($background);
			
			$color = $this->hex2rgb($captcha_config['color']);
			$color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);
			
			// Determine text angle
			$angle = mt_rand( $captcha_config['angle_min'], $captcha_config['angle_max'] ) * (mt_rand(0, 1) == 1 ? -1 : 1);
			
			// Select font randomly
			$font = $captcha_config['fonts'][mt_rand(0, count($captcha_config['fonts']) - 1)];
			
			// Verify font file exists
			if( !file_exists($font) ) throw new Exception('Font file not found: ' . $font);
			
			//Set the font size.
			$font_size = mt_rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
			$text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);
			
			// Determine text position
			$box_width = abs($text_box_size[6] - $text_box_size[2]);
			$box_height = abs($text_box_size[5] - $text_box_size[1]);
			$text_pos_x_min = 0;
			$text_pos_x_max = ($bg_width) - ($box_width);
			$text_pos_x = mt_rand($text_pos_x_min, $text_pos_x_max);
			$text_pos_y_min = $box_height;
			$text_pos_y_max = ($bg_height) - ($box_height / 2);
			if ($text_pos_y_min > $text_pos_y_max) {
				$temp_text_pos_y = $text_pos_y_min;
				$text_pos_y_min = $text_pos_y_max;
				$text_pos_y_max = $temp_text_pos_y;
			}
			$text_pos_y = mt_rand($text_pos_y_min, $text_pos_y_max);
			
			// Draw shadow
			if( $captcha_config['shadow'] ){
				$shadow_color = $this->hex2rgb($captcha_config['shadow_color']);
				$shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
				imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);
			}
			
			// Draw text
			imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);
			
			// Output image
			header("Content-type: image/png");
			imagepng($captcha);
		}
		function hex2rgb($hex_str, $return_string = false, $separator = ',') {
			$hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
			$rgb_array = array();
			if( strlen($hex_str) == 6 ) {
				$color_val = hexdec($hex_str);
				$rgb_array['r'] = 0xFF & ($color_val >> 0x10);
				$rgb_array['g'] = 0xFF & ($color_val >> 0x8);
				$rgb_array['b'] = 0xFF & $color_val;
				} elseif( strlen($hex_str) == 3 ) {
				$rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
				$rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
				$rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
				} else {
				return false;
			}
			return $return_string ? implode($separator, $rgb_array) : $rgb_array;
		}
		public function base64url_encode($data)
		{
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
		}
		public function base64url_decode($data)
		{
			return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
		}
		
		public function notificationList($id=null)
		{
		  $data['notifications'] = $this->common_model->getAllNotifications($id);
		  
			$this->load->view('site/header');
			$this->load->view('site/notificationList',$data);
			$this->load->view('site/footer');
		}
		//=========================Added by Rahul dey 24-01-2019 ===============================
		
		public function feedback()
		{
			$data['captcha'] = $this->createCaptcha( array(
		    'min_length' => 6,
		    'max_length' => 6,
		    'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
		    'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
		    'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
		    'min_font_size' => 28,
		    'max_font_size' => 28,
		    'color' => '#666',
		    'angle_min' => 0,
		    'angle_max' => 10,
		    'shadow' => true,
		    'shadow_color' => '#fff',
		    'shadow_offset_x' => -1,
		    'shadow_offset_y' => 1
			));			
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			$this->load->view('site/feedback',$data);
			$this->load->view('site/footer');
		}
		
		//==================Feedback Send==============================
		
		public function sendfeedback()
		{
			try{
				$this->form_validation->set_rules('name', 'Name', 'required');
				$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required');
				$this->form_validation->set_rules('emailid', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('comment', 'Comment', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$clean    = $this->security->xss_clean($post);
				
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Something Wrong in Information.Please Try Again..!');
					redirect($actual_link);		           
				} 
				else 
				{
					if($this->isValidCaptch($clean['userCaptcha']))
					{
		                $clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
		                $id_detail = $this->user_model->insertFeedbackDetails($clean);
						/*  $token   = $this->user_model->insertToken($id);
							$qstring = $this->base64url_encode($token);
							$url     = site_url() . 'home/complete/token/' . $qstring;
							$link    = '<b><a href="' . $url . '">Click here to activate A2A account! ?</a></b>';
							$message = '';                
							$message .= '<strong>Hi '.$clean['username'].',</strong><br><br>';
							$message .= 'Thanks for your registration in A2A Scholarships portal. You have to activate your account and then Login for apply online. <br/><br/><b>Your Login Id is:</b> '.$clean['emailId'].'. <br/> <b>Your Password:</b> What you choose during registration. <br/><br/>Please click the link below to activate your ICCR account. <br>';
							
							$message .= $link;
							$data = array(
						    'content' => $message					   
							);
							$data = array(
							'content' => $message					   
							);
							$this->load->library('email');
							$config = Array(
							'mailtype' => 'html'				        
							);
							$config['protocol']    = 'smtp';
							$config['smtp_host']    = 'relay.nic.in';
							$config['smtp_port']    = '25';
							$config['smtp_timeout'] = '7';
							
							
							$config['charset']    = 'utf-8';
							$config['newline']    = "\r\n";							
							$this->email->initialize($config);
							
							$content = $this->load->view('mail_signup',$data, true); 
							
							$from_email = $this->config->item('fromEmail'); ; 
							$to_email = $this->input->post('emailId'); 			   
							
							$this->load->library('email',$config);			   
							$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
							$this->email->to($to_email);
							$this->email->subject('Indian Council for Cultural Relations (ICCR) Activate Account'); 
							$this->email->message($content); 			   
							if($this->email->send()) 
							{
							echo '<script>window.location.href="'.site_url().'home?text=Please check your email inbox/spam/junk to activate the account.&type=Thank You!&at=success&redirect='.site_url().'home";</script>';
							}					
							else 
						echo '<script>window.location.href="'.site_url().'home?text=Email not sent.&type=Error Message&at=danger&redirect='.site_url().'home/register";</script>'; */
						//$config['smtp_user']    = 'kip.support@mea.gov.in';
						//$config['smtp_pass']    = 'Kip@Mea@123';
						if($id_detail){
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Feedback Submitted Sucessfully!');
							redirect($actual_link);	
							}else{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Something wrong. Please try again later!');
							redirect($actual_link);		
						}						
	            		
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Wrong Text Enterd!');
						redirect($actual_link);	
						
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time');
				redirect($actual_link);				 
			}
		}
		
		public function page($page_slug=null)
		{
			$data = array();
			$data['pages'] = $this->common_model->getAllPages($page_slug);
			
			$this->load->view('site/header');
			$this->load->view('site/pages',$data);
			$this->load->view('site/footer');
		}
		public function getPhdDob()
		{
			
			$response = array('status'=>FALSE,'jsondata'=>array());
			$year=$this->input->post('year'); 
			$month = $this->input->post('month'); 
			$date = $this->input->post('date');
			$dob=$date.'/'.$month.'/'.$year;
			$condate='01/07/2025';
			$birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $dob))))));
			$today= new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $condate))))));$age = $birthdate->diff($today)->y;
			
			if(($age >= 18) && ($age < 50))
			{
				$response['status'] = TRUE;
				//$response['jsondata'] = $data;
			}else{
				$response['status'] = FALSE;
				
			}
			echo json_encode($response);
		}

		public function search()
		{
			
			$data = array();
			$input = $this->input->get('q');
			
			$data['pages'] = $this->common_model->getAllPages('',$input);
			$this->load->view('site/header');
			$this->load->view('site/search_result',$data);
			$this->load->view('site/footer');
		}
		
		function alumani()
	{
		try{
			$data['alunamiapplication']= $this->common_model->getAlumaniApplicationsByRegion($regionid);
			$this->load->view('site/header');
			$this->load->view('site/alumani',$data);
			$this->load->view('site/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	function isValidCaptchTest($captchText)
		{  
			$sessionData = $this->session->userdata('captcha_val');
			$sessionText = $sessionData['code'];
			return ($captchText == $sessionText) ? TRUE : FALSE;
		}
		
		function strip_quotes($str)
		{
			return str_replace(array('"',"'",'>','<'), '', $str);
		}
		
			 public function savesAlumniData()
	{
		
		try
		{
			
				//$post     = $this->input->post();
	            //$clean    = $this->security->xss_clean($post);
				$this->form_validation->set_rules('nationality', 'Nationality', 'required');
	        $this->form_validation->set_rules('mission_id', 'Mission', 'required');
			$this->form_validation->set_rules('fullname', 'Name', 'required');
	        $this->form_validation->set_rules('mission_id', 'Mission', 'required');
			$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('passport_no', 'Passport', 'required');
	        $this->form_validation->set_rules('passport_issue_place', 'Passport issue Place', 'required');
			$this->form_validation->set_rules('passport_issue_date', ' Passport issue date', 'required');
	        $this->form_validation->set_rules('passport_issue_month', 'Passport issue month', 'required');
			$this->form_validation->set_rules('passport_issue_year', 'Passport issue year', 'required');
			$this->form_validation->set_rules('passport_expiry_date', 'Passport expiry date', 'required');
			$this->form_validation->set_rules('passport_expiry_date', 'Passport expiry month', 'required');
			$this->form_validation->set_rules('passport_expiry_year', 'Passport expiry year', 'required');
			$this->form_validation->set_rules('programme', 'Level of Programme', 'required');
			$this->form_validation->set_rules('course', 'Course', 'required');
			$this->form_validation->set_rules('unverisity', 'Unverisity', 'required');
	        $this->form_validation->set_rules('city', 'city', 'required');
			$this->form_validation->set_rules('duration_of_course_from', 'Duration of Course From', 'required');
			$this->form_validation->set_rules('duration_of_course_to', 'Duration of Course To', 'required');
			$this->form_validation->set_rules('date_of_arrival', 'Date of Arrival', 'required');
			$this->form_validation->set_rules('date_of_departure', 'Date of Departure', 'required');
			$this->form_validation->set_rules('year_of_passing', 'Year of Passing', 'required');
			$this->form_validation->set_rules('subject', 'Subject', 'required');
			$this->form_validation->set_rules('division', 'Division', 'required');
			$this->form_validation->set_rules('present_details', 'Present details', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');
	        //$this->form_validation->set_rules('award_recognition', 'Award recognition', 'required');
			  if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('error',validation_errors());
				$this->session->set_flashdata('message_type', 'error');
				//$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        }
			else
			{
				
						$postData = $this->strip_quotes($this->security->xss_clean($this->input->post(NULL,TRUE)));
				if(!empty($_POST))
				{
				if($this->isValidCaptchTest($postData['captchatext'])){
					
				
	            if(!$this->user_model->isValidAluminiEmail($postData['email']))
	            {
					$application_no = "";$imgname="";
					$application_no = $this->uri->segment(3);
					$postData = $this->input->post(NULL,TRUE);	
					$files = $_FILES['img_alumnai'];
					$fnmae = $_FILES['img_alumnai']['name'];
					$tempfile = $_FILES['img_alumnai']['tmp_name'];
					$sizekbb = filesize($tempfile); //10485760= 10mb
					$head = fgets(fopen($tempfile, "r"), 5);
					$section = strtoupper(base64_encode(file_get_contents($tempfile)));
					$nsection = substr($section, 0, 8);
					$frst = strpos($fnmae, ".");
					$sec = strrpos($fnmae, ".");
					$handle = fopen($tempfile, "rb");
					$fsize = filesize($tempfile);
					$contents = fread($handle, $fsize);
			
			$pdf = substr($contents, 0, 4);
			/* if ($frst != $sec) 
			{				
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File content is not Valid!');
				redirect(site_url().'home');				
				return;
			} */
			/* if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File content is not Valid!');
				redirect(site_url().'home');		
				return;			
			} */
			if ($sizekbb > 5242880) 
			{			
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File size is not Valid!');
				redirect(site_url().'home');	
				return;
			}
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG");
			$imgname = '';
		   if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = $postData['application_id'].'_'.time().'_alumni_pics_'.$name;
			  
			  $target_file = 'assets/site/main/alumni_pic/'.$imgname; 
			  if (move_uploaded_file($_FILES["img_alumnai"]["tmp_name"], $target_file)) 
			  { 
		$aluminiData = array(
				'application_id'=>$postData['application_id'],
				'photo'=>$imgname,
				'created'=>time(),
				'nationality'=>$postData['nationality'],
				'mission_id'=>$postData['mission_id'],
				'fullname'=>$postData['fullname'],
				'date_of_birth'=>$postData['date_of_birth'],
				'gender'=>$postData['gender'],
				'programme'=>$postData['programme'],
				'course'=>$postData['course'],
				'other_course'=>$postData['other_course'],
				'unverisity'=>$postData['unverisity'],
				'other_unverisity'=>$postData['other_unverisity'],
				'city'=>$postData['city'],
				'other_city'=>$postData['other_city'],
				'duration_of_course_from'=>$postData['duration_of_course_from'],
				'duration_of_course_to'=>$postData['duration_of_course_to'],
				'year_of_passing'=>$postData['year_of_passing'],
				'subject'=>$postData['subject'],
				'division'=>$postData['division'],
				'about_us'=>$postData['about_us'],
				'present_details'=>$postData['present_details'],
				'email'=>$postData['email'],
				'phone'=>$postData['phone'],
				'date_of_arrival'=>$postData['date_of_arrival'],
				'date_of_departure'=>$postData['date_of_departure'],
				'present_occupation'=>$postData['present_occupation'],
				'passport_no'=>$postData['passport_no'],
				'award_recognition'=>$postData['award_recognition'],
				'passport_issue_date'=>$postData['passport_issue_date'],
				'passport_issue_month'=>$postData['passport_issue_month'],
				'passport_issue_year'=>$postData['passport_issue_year'],
				'passport_expiry_date'=>$postData['passport_expiry_date'],
				'passport_expiry_month'=>$postData['passport_expiry_month'],
				'passport_expiry_year'=>$postData['passport_expiry_year'],
				'passport_issue_place'=>$postData['passport_issue_place']
				
				);
			  	$to_email = $postData['email']; 
				 $result = $this->common_model->insertAlumniData($aluminiData);
				 if($result){
				 $message = '';                
		         $message .= '<strong>Hi '.$postData['fullname'].',</strong><br><br>';
		         $message .= 'Thanks for your registration in A2A Scholarships portal as a Alumini.<br>';
				 $message .= "<strong><a href= '".site_url().'home/aluminiPdf/'.$postData['application_id']."' download>Downlaod</a></strong><br><br>";
				 $body .= $message;	
				 $mailsend = $this->sendMail($body,$to_email,"Indian Council for Cultural Relations.","mail_acknowledgement");
				 if($mailsend) 
						 {
							 //$this->email->clear($pdfFilePath);
						 	 echo '<script>window.location.href="'.site_url().'home?text=Please check your email inbox/spam.&type=Thank You!&at=success&redirect='.site_url().'home";</script>';
						  }					
						  else 
						  echo '<script>window.location.href="'.site_url().'home?text=Email not sent.&type=Error Message&at=danger&redirect='.site_url().'home";</script>';
				 }
				 
				 
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
					redirect(site_url().'home');					
				 }
			  }
			  else
			  {
		  		$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
				redirect(site_url().'home');
			  }
			} 
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
				redirect(site_url().'home');
			}
				}
				else
	            {
	            	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You have already apply!');
					redirect('home');
				}
					
					
					
				}
				
				else
				{
					
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You have entered wrong text!');
					redirect('home');
					
				}
				}
				
			}
		
			
			
			
			
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'home');
		} 
	}
		function aluminiPdf(){
			
				$application_no = $this->uri->segment(3);
				$data['alunamiapplication'] = $this->common_model->getAlumaniApplicationbyId($application_no);
				if(!empty($data['alunamiapplication'])){
			    $pdffc = $this->load->view('site/viewAlumaniApplication',$data,TRUE);
				$mpdf = new Mpdf('s','A4','','',5,7,05,10,10,10);			
				$mpdf->SetFont('Arial','B',12);
				$fileName  = $application_no.'.pdf';
				$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
				$mpdf->watermark_font = 'DejaVuSansCondensed';
				$mpdf->showWatermarkText = true;
				//$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>".date("jS F Y h:i:s")."</div>";
				$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>Ref. No.".$application_no.'<br/>'.date("jS F Y h:i:s")."</div>";
				$html = $content;
				//$html = $content;
				//$imgArray = $this->common_model->getUserImage($data[0]['uid']);		  
				
				$mpdf->SetDisplayMode('fullpage');			 
				// LOAD a stylesheet
				$stylesheet = file_get_contents('assets/site/main/css/bootstrap.min.css'); 
				
				$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
				$mpdf->WriteHTML($html1,2);
				
				$mpdf->WriteHTML($pdffc);	
				//$file_name = md5(rand()) . '.pdf';
				$mpdf->Output($fileName,'D');
				//file_put_contents($file_name, $file);

				}
				else{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
					redirect(site_url().'home');
				}
			
			
		}  
	public function uploadAluminiProfilePic()
		{
			try
			{
				$files = $_FILES['file']; 
                //echo "<pre>";
				//print_r($files);die;				
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];		
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['img_alumnai'];
				$typpe = $_FILES['file']['type'];
				$tempfile = $_FILES['file']['tmp_name'];
				$sizekbb = filesize($tempfile); //10485760= 10mb
				$head = fgets(fopen($tempfile, "r"), 5);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				$nsection = substr($section, 0, 8);
				
				$frst = strpos($fnmae, ".");
				$sec = strrpos($fnmae, ".");
				$handle = fopen($tempfile, "rb");
				$fsize = filesize($tempfile);
				$contents = fread($handle, $fsize);
				
				$pdf = substr($contents, 0, 4);	
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,"message"=>"File content is not Valid"));
					return ;
				}
				if ($sizekbb > 200000) 
				{						
					$this->session->set_flashdata('error', 'File size is not Valid!');
					echo json_encode(array('status'=>FALSE,"message"=>"File size is not Valid"));
					return;
				}
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG files are allowed"));
					return;
				}
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_'.$name;
					$target_file = 'assets/site/main/alumni_pic/';
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						
						$this->session->set_flashdata('success', 'Profile image upload successfully.');
					    //echo json_encode(array('status'=>TRUE,"message"=>"Profile image upload successfully"));
						echo json_encode(array('status'=>TRUE, 'file_path'=> base_url().$target_file));
					    return ;
					}
					else{
						echo json_encode(array('status'=>FALSE,"message"=>"Error While Uploading Profile Pic!. Try Again Later."));
					}
				}
			}
			catch(Exception $e)
			{
				echo json_encode(array('status'=>FALSE,"message"=>"Error While Uploading Profile Pic!. Try Again Later."));
			}
		}
	public function getMissionsByCountry()
		{
		
			$response = array('status'=>FALSE,'jsondata'=>array());
			$country = $this->input->post("countryId");
			$data = $this->common_model->getMissionsByCountry($country);
			if(count($data)>0)
			{
				$response['status'] = TRUE;
				$response['jsondata'] = $data;
			}
			echo json_encode($response);
		}
		
		
			public function completeSfs()
		{
			try{
				$token      = base64_decode($this->uri->segment(4));
				echo $token;die;
				$cleanToken = $this->security->xss_clean($token);
				$user_info  = $this->user_model->isSfsTokenValid($cleanToken);
				if (!is_object($user_info)) {
					echo '<script>window.location.href="'.site_url().'home?text=Token is invalid or expired!.&type=Error Message&at=danger&redirect='.site_url().'home";</script>';
					return;  
				}
				$data = array(
	            'firstName' => $user_info->username,
	            'email' => $user_info->email_id,
	            'user_id' => $user_info->id,
	            'token' => $this->base64url_encode($token)
				);
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
				$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
				if ($this->form_validation->run() == FALSE) {
					$this->load->view('site/header');
					$this->load->view('site/sfs/completeSfs', $data);
					$this->load->view('site/footer');
					} else {
					$post                  = $this->input->post(NULL, TRUE);
					$cleanPost             = $this->security->xss_clean($post);
					$hashed                = md5($cleanPost['password']);
					$cleanPost['password'] = $hashed;
					$cleanPost['user_id'] =  $user_info->id;
					unset($cleanPost['passconf']);
					$userInfo = $this->user_model->updateSfsUserInfo($cleanPost);
					if(is_object($userInfo) && property_exists($userInfo,"username"))
					{
						unset($userInfo->password);
						$datas = array(
						'userid'=> $userInfo->id,
						'fname'=> $userInfo->username,
						'email'=> $userInfo->email_id,
						'user_type'=> $userInfo->user_type								
						);
						$this->session->set_userdata('user_data',$datas);   
						echo '<script>window.location.href="'.site_url().'home?text=Login Successfully!.&type=Thank You!&at=success&redirect='.site_url().'Applicant/dashboard";</script>';       
						
					}
					else
					{
						if (!$userInfo) {            	
							$this->session->set_flashdata('flash_message', 'There was a problem updating your record');
							echo '<script>window.location.href="'.site_url().'home?text=There was a problem updating your record!.&type=Error Message!&at=danger&redirect='.site_url().'home";</script>';  
						}
					}
				}
			}
			catch(Exception $e)
			{
				echo '<script>window.location.href="'.site_url().'home?text=Internal Server Error. Try After Some Time!&type=Error Message!&at=danger&redirect='.site_url().'home";</script>';			
			}
		} 
		public function getAllActiveNotification()
		{
		  $todate = date('Y-m-d');
		  $data['notifications'] = $this->common_model->getActiveNotification($todate);
		  
			$this->load->view('site/header');
			$this->load->view('site/notificationList',$data);
			$this->load->view('site/footer');
		}
		
		public function nirfRanking()
		{
			$data['nirfRank'] = $this->common_model->getNirfRankings();
			$this->load->view('site/header');
			$this->load->view('site/nirfRanking.php',$data);
			$this->load->view('site/footer');
		}
		
		
		public function video()
		{
			$this->load->view('site/header');
			$this->load->view('site/video');
			$this->load->view('site/footer');
		}
		
		public function testimonials()
		{
			$this->load->view('site/header');
			$this->load->view('site/testimonials');
			$this->load->view('site/footer');
		}
		
		public function applicaitonAluminiProcess()
	{
		try{
			//echo "<pre>";print_r($_POST);die;
			//echo '------------';die;
			$postData = $this->strip_quotes($this->input->post(NULL,TRUE));
			
				if($this->isValidCaptchTest($postData['captchatext'])){
					
			
					if(!$this->user_model->isValidAluminiEmail($postData['email']))
	            {
					
					
					//echo "<pre>";print_r($postData);die;
			        $imgname="";
					$application_no = $this->uri->segment(3);
					$postData = $this->input->post(NULL,TRUE);	
					$files = $_FILES['img_alumnai'];
					$typpe = $_FILES['img_alumnai']['type'];
					$fnmae = $_FILES['img_alumnai']['name'];
					$typpe = $_FILES['img_alumnai']['type'];
					$tempfile = $_FILES['img_alumnai']['tmp_name'];
					$sizekbb = filesize($tempfile); //10485760= 10mb
					$head = fgets(fopen($tempfile, "r"), 5);
					$section = strtoupper(base64_encode(file_get_contents($tempfile)));
					$nsection = substr($section, 0, 8);
					$frst = strpos($fnmae, ".");
					$sec = strrpos($fnmae, ".");
					$handle = fopen($tempfile, "rb");
					$fsize = filesize($tempfile);
					$contents = fread($handle, $fsize);
			//echo $sizekbb;die;
			  if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png")
				{
					//$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG files are allowed'));
					return;
				}
				
				if($frst != $sec)
				{
						
					//$this->session->set_flashdata('error', 'File content is not Validssssssssss!');
					echo json_encode(array('status'=>FALSE,'message'=>'File content is not Valid!'));
					return;
					
				}
				
				if ($sizekbb > 5242880) 
				{			
						//$this->session->set_flashdata('error', 'File size is not Valid!');
						echo json_encode(array('status'=>FALSE,'message'=>'File size should be less than equal to 200 KB!'));
						return;
				}
				
			
			if(!empty($_FILES))
			{	
				$files = $_FILES['img_alumnai']; 
				
								
				if($files["name"] != "")
				{				
				  $name = str_replace(" ","_",$files['name']);
				  $imgname = $postData['application_id'].'_'.time().'_alumni_pics_'.$name;
				  $target_file = 'assets/site/main/alumni_pic/'.$imgname; 
				  move_uploaded_file($_FILES["img_alumnai"]["tmp_name"], $target_file);
			    }
					
			}	
			
			$aluminiData = array(
				'application_id'=>$postData['application_id'],
				'photo'=>$imgname,
				'created'=>time(),
				'nationality'=>$postData['nationality'],
				'mission_id'=>$postData['mission_id'],
				'fullname'=>$postData['fullname'],
				'date_of_birth'=>$postData['date_of_birth'],
				'gender'=>$postData['gender'],
				'programme'=>$postData['programme'],
				'course'=>$postData['course'],
				'other_course'=>$postData['other_course'],
				'unverisity'=>$postData['unverisity'],
				'other_unverisity'=>$postData['other_unverisity'],
				'city'=>$postData['city'],
				'other_city'=>$postData['other_city'],
				'duration_of_course_from'=>$postData['duration_of_course_from'],
				'duration_of_course_to'=>$postData['duration_of_course_to'],
				'year_of_passing'=>$postData['year_of_passing'],
				'subject'=>$postData['subject'],
				'division'=>$postData['division'],
				'about_us'=>$postData['about_us'],
				'present_details'=>$postData['present_details'],
				'email'=>$postData['email'],
				'phone'=>$postData['phone'],
				'date_of_arrival'=>$postData['date_of_arrival'],
				'date_of_departure'=>$postData['date_of_departure'],
				'present_occupation'=>$postData['present_occupation'],
				'passport_no'=>$postData['passport_no'],
				'award_recognition'=>$postData['award_recognition'],
				'passport_issue_date'=>$postData['passport_issue_date'],
				'passport_issue_month'=>$postData['passport_issue_month'],
				'passport_issue_year'=>$postData['passport_issue_year'],
				'passport_expiry_date'=>$postData['passport_expiry_date'],
				'passport_expiry_month'=>$postData['passport_expiry_month'],
				'passport_expiry_year'=>$postData['passport_expiry_year'],
				'passport_issue_place'=>$postData['passport_issue_place'],
				);
			//echo "<pre>";print_r($aluminiData);die;
				$to_email = $postData['email']; 
				 $result = $this->common_model->insertAlumniData($aluminiData);
				 if($result){
				 $message = '';                
		         $message .= '<strong>Hi '.$postData['fullname'].',</strong><br><br>';
		         $message .= 'Thanks for your registration in A2A Scholarships portal as a Alumini.<br>';
				 $message .= "<strong><a href= '".site_url().'home/aluminiPdf/'.$postData['application_id']."' download>Downlaod</a></strong><br><br>";
				 $body .= $message;	
				 $mailsend = $this->sendMail($body,$to_email,"Indian Council for Cultural Relations.","mail_acknowledgement");
				 
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
					redirect(site_url().'home');					
				 }
						
				 if($result){
							
							echo json_encode(array('status'=>TRUE,"message"=>"Approved"));
							}
						else
							echo json_encode(array('status'=>FALSE,"message"=>"Error"));
					
				}
				else
	            {
						
						//$this->session->set_flashdata('error', 'You have already apply!');
						echo json_encode(array('status'=>FALSE,'message'=>'You have already apply!'));
						return;
	            	
				}
				
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You have entered wrong text!');
					redirect('home');
					
				}
			
		}
		
		catch(Exception $e)
		{
			echo json_encode(array('status'=>FALSE,"message"=>"Error"));
		}
	}

	public function __destruct() {
    $this->db->close();
    }

	function refreshCaptcha()
    {
        $data['captcha']= $this->createCaptcha( array(
            'min_length' => 5,
            'max_length' => 5,
            'backgrounds' => array(FCPATH.'assets/site/main/images/captcha_bg/white-carbon.png'),
            'fonts' => array(FCPATH.'assets/site/main/fonts/captcha_fonts/opensans-semibold-webfont.ttf'),
            'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
            'min_font_size' => 28,
            'max_font_size' => 28,
            'color' => '#666',
            'angle_min' => 0,
            'angle_max' => 10,
            'shadow' => true,
            'shadow_color' => '#fff',
            'shadow_offset_x' => -1,
            'shadow_offset_y' => 1
            )); 
            
            $this->session->set_userdata('captcha_code', $data['captcha']);
            echo $data['captcha']['image_src'];
            exit;
    }



	// function phoneupdate()
	// {
	// 	ini_set('display_errors', 1);
	// 	ini_set('display_startup_errors', 1);
	// 	error_reporting(E_ALL);
	// 	$wphone = $this->db->select(['id','phone_number'])->where('id','144077 ')->order_by('id','desc')->get('iccr_student_application_details')->result_array();
	// 	//print_r($wphone);
	// 	//die();
    //     foreach($wphone as $result){
	// 		//echo $result['phone_number']."<br>".$result['id'] ; die;
	// 		//$data = array('whatsapp_number'=>$result['phone_number']);
	// 	    $phoneno = $result['phone_number'];
	// 		$id = $result['id'];
	// 		$sql = "UPDATE iccr_student_application_details SET whatsapp_number = '".$phoneno."' WHERE  id = '".$id."'";
	// 	$rs = $this->db->query($sql);

    //        // $this->db->where('id', $result['id'])->update('iccr_student_application_details',$data);
	// 	}

	// }



		
	}

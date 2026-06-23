<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(1);

class University extends CI_Controller {

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
	 public $ids = array();
	  public $ip;
    	public $refs;
    	public $uris;
    	public $agents;
	 public function __construct()
     {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');	
        $this->load->library('encryption');
        $this->load->library('mpdf60/Mpdf');   
       // $this->load->library('fpdi/PDF_HTML');  
        $this->load->helper('date');   
		$this->load->library('zip');
		$this->load->helper('status_helper');
        $this->load->model('user_model');        
        $this->load->model('common_model');      
        $this->load->model('mission_model');   
        $this->load->model('university_model');		
        $this->load->helper('file');
         
        $userdata = $this->session->userdata('user_data'); 
		//echo "<pre>";print_r($userdata);die;
		
        if(!$this->session->userdata('user_data'))
	    {
	    	redirect('home');
	    }
	    else
	    {
			$roles = $this->config->item('roles_id');
			//echo "<pre>";print_r($roles);die;
   			$role = $roles[$userdata['user_type']];
        	switch($role)
        	{

        		case "ICCR":
				redirect(site_url() . 'headquarter/dashboard');
				break;
				case "Regional Office":
				redirect(site_url() . 'regional/dashboard');
				break;
				case "Super Admin":
				redirect(site_url() . 'admin/dashboard');
				break;
				case "Mission":
				redirect(site_url() . 'mission/dashboard');
				break;

				
				
				
			}
		}
         
         
         $emailId = $userdata['email'];
         
			$arrayIds = array();
			$ids  = $this->common_model->getCountriesofMissions($emailId);
			if(count($ids)>0)
			{
				foreach($ids as $id)
				{					
					array_push($arrayIds,$id['id']);
				}
			}
			$this->ids = $arrayIds;
			
    } 




    public function getCourseByPrgrammeold() {
        $response = array('status' => FALSE, 'data' => array(), 'csrfName' => '', 'csrfHash' => '');
        try {
            $id = $this->input->post('programme');
            $courses = $this->common_model->getCourseByPrgramme($id);

            if (count($courses) > 0) {
                $response['status'] = TRUE;
                foreach ($courses as $row) {
                    $response['data'][] = $row;
                }
            }
        } catch (Exception $e) {
            echo json_encode($response);
        }
        echo json_encode($response);
    }

	public function getNewUniversityApplicaitonsCsv()
    {

		$file_name = 'student_details_on_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$file_name"); 
		header("Content-Type: application/csv;");

		$year = $this->uri->segment(3);
		//echo $year;die;
    	$user_data = $this->session->userdata('user_data');
		//echo "<pre>";print_r($user_data);die;
		//$missionId = $user_data['user_country'];
		//$misionData = $this->common_model->getMissionInfo($missionId);
    	//$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		//echo "<pre>";print_r($vars);die;pending_application
		//$counter = $_POST['start'];
		$universityId = $user_data['university'];
		$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
		//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
		$result = $this->university_model->getUniversityApplications($vars,$universityId,$year);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->university_model->getTotalUniversityApplications($vars,$universityId,$year);
		
		$response = array();
		//$counter++;
		$file = fopen('php://output', 'w');
	
		$header = array("Sr.No.","Applicant No","Applicant Name","Email Id","Country","Programme","Course","Date of Submission"); 
		fputcsv($file, $header);
		$cnt=1;
		if(!empty($result))
		{
			foreach($result as $r)
			   {
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				   $output= array();
				   $applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				   $applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($r['application_no']);
				  		 

				   $sch = $this->common_model->getSchemeById($r['scholarship_id']);
								   $scheme = $sch[0]['scheme_name'];
				   $confirmData = $this->common_model->getFinalUniversityById($r['regional_university']);	
   $region = $this->common_model->getRegionById($r['region_one_status']);
			   $date2 = $r['SubmitDate'];	
	 
			   $course34 = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
			 

			   $course = $this->common_model->getCoursesById($applicationDetails[0]['course']);
					$course1 = $this->common_model->getCoursesById($applicationDetails[0]['course_two']);
					$course2 = $this->common_model->getCoursesById($applicationDetails[0]['course_three']);
					$course3 = $this->common_model->getCoursesById($applicationDetails[0]['course_fourth']);
					$course4 = $this->common_model->getCoursesById($applicationDetails[0]['course_fifth']);
			   $fullCourse ="";
			   $strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
			   $strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
			   $strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
			   $strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
			   $strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
			   //echo "<pre>";print_r($applicationDetails[0]);
			   if($universityId == $applicationDetails[0]['universty_choice']){
			   $fullCourse .= $course[0]['title'].'/'.$applicationDetails[0]['course_option_name'];
			   }
			   elseif($universityId == $applicationDetails[0]['universty_choice_two']){
			   $fullCourse .= $course1[0]['title'].'/'.$applicationDetails[0]['course_option_name_two'];
			   }
			   elseif($universityId == $applicationDetails[0]['universty_choice_three']){
			   $fullCourse .= $course2[0]['title'].'/'.$applicationDetails[0]['course_option_name_three'];
			   }
			   elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
			   $fullCourse .= $course3[0]['title'].'/'.$applicationDetails[0]['course_option_name_fourth'];
			   }
			   elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
			   $fullCourse .= $course4[0]['title'].'/'.$applicationDetails[0]['course_option_name_fifth'];
			   }
			   $date2 = $r['SubmitDate'];	
		
				$narray=array($cnt,$r['application_no'], $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'],
				$applicationDetails[0]['email'], $country[0]['country_name'],$course34[0]['name'],$fullCourse,
				date('d-m-Y',$date2)
				);	 
				$cnt++;
			   fputcsv($file, $narray); 		
			   }
		}
		fclose($file); 
		exit; 
	}

    public function getNewUniversityApplicaitons()
    {
		$year = $this->uri->segment(3);
		//echo $year;die;
    	$user_data = $this->session->userdata('user_data');
		//echo "<pre>";print_r($user_data);die;
		//$missionId = $user_data['user_country'];
		//$misionData = $this->common_model->getMissionInfo($missionId);
    	//$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		//echo "<pre>";print_r($vars);die;pending_application
		//$counter = $_POST['start'];
		$universityId = $user_data['university'];
		$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
		//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
		$result = $this->university_model->getUniversityApplications($vars,$universityId,$year);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->university_model->getTotalUniversityApplications($vars,$universityId,$year);
		
		$response = array();
		//$counter++;
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				
				//echo "<pre>";print_r($r);die;
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				$gender = "";
				$output= array();	
				$output[] = $counter;
					$date1 = '2021-03-14';
					
						//$date1 = '2019-12-01';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($r['created']);
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
				$output[] = $applicationDetails[0]['application_no'];
				$output[]= $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'].$new;
				$output[] = $applicationDetails[0]['email'];
				$output[] = $applicationDetails[0]['passport_no'];
				$output[] = $applicationDetails[0]['dob'];
				$output[] = $applicationDetails[0]['phone_number'];
				$output[] = ($applicationDetails[0]['gender']== 1) ? 'Male' : 'Female';
				$output[] = $country[0]['country_name'];	
				$progrm = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
				$output[] = $progrm[0]['name'];
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$nomenclature = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature']);
					$nomenclature1 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_two']);
					$nomenclature2 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_three']);
					$nomenclature3 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fourth']);
					$nomenclature4 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					if($universityId == $applicationDetails[0]['universty_choice']){
					$fullCourse .= $nomenclature[0]['title'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_two']){
					$fullCourse .= $nomenclature1[0]['title'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_three']){
					$fullCourse .= $nomenclature2[0]['title'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$fullCourse .= $nomenclature3[0]['title'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$fullCourse .= $nomenclature4[0]['title'].'<br/>';
					}
					$output[] = $fullCourse;
				}
				$universityDetails = "";
				if($universityId == $applicationDetails[0]['universty_choice']){
					$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_two']){
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_three']){
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
				$uni4 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fourth']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
				$uni5 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fifth']);
				}
				if($universityId == $applicationDetails[0]['universty_choice']){
				$universityDetails .= ' '.$uni1[0]['name'].'<br/>';		
				}
				if($universityId == $applicationDetails[0]['universty_choice_two']){
					$universityDetails .= ' '.$uni2[0]['name'].'<br/>';
				}
				if($universityId == $applicationDetails[0]['universty_choice_three']){
					$universityDetails .= ' '.$uni3[0]['name'].'<br/>';
				}
				if($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$universityDetails .= ' '.$uni4[0]['name'].'<br/>';	
				}
				if($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$universityDetails .= ' '.$uni5[0]['name'].'<br/>';
				}
				$output[] = $universityDetails;
				//$date1 = strtotime($r['created']);	
				//$orgDate = date('d-m-Y', $date1); 
				//$output[] = $orgDate;
					
				
				$date2 = $r['SubmitDate'];	
				$output[] = date('d-m-Y',$date2);

				$universityConfirmData = $this->common_model->getconfirmationDataforHqrsbyUniversityId($r['application_no'],$universityId);
				$universityMissionConfirmData = $this->common_model->getconfirmationDataByMissionStatus($r['application_no']);
				//var_dump($universityMissionConfirmData);die;
				//echo "<pre>";print_r($universityConfirmData);die;
				$universityMappingData = $this->common_model->getmappingDataforHqrsbyUniversityId($r['application_no'],$universityId);
				//echo "<pre>";print_r($universityMissionConfirmData);
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'university/viewfullApplication/'.$applicationDetails[0]['application_no'].'" target = "_blank" class="form-control sbmt1">View</a>';
				
				if(!empty($r['universities_status']) && $r['universities_status'] == 1 && !empty($universityConfirmData)){
				
				$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;"  class="form-control sbmt1" disabled>Click Here</a>';
				
				}
				else
				{
					
					$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =editRemarks("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Click Here</a>';
					// $output[] ='<a href="'.site_url().'#" style="float:left;width:104px;" onclick =editRemarks("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Click Here</a>';
				}
				
				if(!empty($r['universities_status']) && $r['universities_status'] == 1 && !empty($universityConfirmData) || $universityMappingData[0]['status'] == 3  || $universityMissionConfirmData[0]['confirmed_to_mission'] == 1) {
					
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" disabled = disbaled href="javascript:void(0);" class="form-control sbm">Click Here</a>';
				}
				else{

					// $date1 = '2023-12-31';
					$date1 = '2022-02-10';
					
					// $date1 = '2022-02-10';
					
						//$date1 = '2019-12-01';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($r['created']);
					if ($date2 >= $date1) {
						
					
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'university/viewApplication/'.$applicationDetails[0]['application_no'].'" target = "_blank" class="form-control sbmt">Process</a>';
					// $output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'#" target = "_blank" class="form-control sbmt">Closed</a>';
					}
					else
					{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="#" target = "_blank" class="form-control sbmt">Click Here</a>';
					}
				}
				
						
				$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =openStatus("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Status</a>';
				$output[] = '<a target="_blank" href="'.site_url().'university/downloadStudent_zip/'.$r['application_no'].'" target="_blank"><span class = "label label-success">Download</span></a>';
				
				$response[] = $output;
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}

	public function getNewUniversityApplicaitons2324()
    {
		$year = $this->uri->segment(3);
		//echo $year;die;
    	$user_data = $this->session->userdata('user_data');
		//echo "<pre>";print_r($user_data);die;
		//$missionId = $user_data['user_country'];
		//$misionData = $this->common_model->getMissionInfo($missionId);
    	//$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		//echo "<pre>";print_r($vars);die;pending_application
		//$counter = $_POST['start'];
		$universityId = $user_data['university'];
		$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
		//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
		$result = $this->university_model->getUniversityApplications($vars,$universityId,$year);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->university_model->getTotalUniversityApplications($vars,$universityId,$year);
		
		$response = array();
		//$counter++;
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				
				//echo "<pre>";print_r($r);die;
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				$gender = "";
				$output= array();	
				$output[] = $counter;
					$date1 = '2023-04-01';
					
						//$date1 = '2019-12-01';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($r['created']);
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
				$output[] = $applicationDetails[0]['application_no'];
				$output[]= $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'].$new;
				$output[] = $applicationDetails[0]['email'];
				$output[] = $applicationDetails[0]['passport_no'];
				$output[] = $applicationDetails[0]['dob'];
				$output[] = $applicationDetails[0]['phone_number'];
				$output[] = ($applicationDetails[0]['gender']== 1) ? 'Male' : 'Female';
				$output[] = $country[0]['country_name'];	
				$progrm = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
				$output[] = $progrm[0]['name'];
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$course = $this->common_model->getCoursesById($applicationDetails[0]['course']);
					$course1 = $this->common_model->getCoursesById($applicationDetails[0]['course_two']);
					$course2 = $this->common_model->getCoursesById($applicationDetails[0]['course_three']);
					$course3 = $this->common_model->getCoursesById($applicationDetails[0]['course_fourth']);
					$course4 = $this->common_model->getCoursesById($applicationDetails[0]['course_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					if($universityId == $applicationDetails[0]['universty_choice']){
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_two']){
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_three']){
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$fullCourse .= $course3[0]['title'].' '.$applicationDetails[0]['course_option_name_fourth'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$fullCourse .= $course4[0]['title'].' '.$applicationDetails[0]['course_option_name_fifth'].'<br/>';
					}
					$output[] = $fullCourse;
				}
				$universityDetails = "";
				if($universityId == $applicationDetails[0]['universty_choice']){
					$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_two']){
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_three']){
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
				$uni4 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fourth']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
				$uni5 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fifth']);
				}
				if($universityId == $applicationDetails[0]['universty_choice']){
				$universityDetails .= ' '.$uni1[0]['name'].'<br/>';		
				}
				if($universityId == $applicationDetails[0]['universty_choice_two']){
					$universityDetails .= ' '.$uni2[0]['name'].'<br/>';
				}
				if($universityId == $applicationDetails[0]['universty_choice_three']){
					$universityDetails .= ' '.$uni3[0]['name'].'<br/>';
				}
				if($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$universityDetails .= ' '.$uni4[0]['name'].'<br/>';	
				}
				if($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$universityDetails .= ' '.$uni5[0]['name'].'<br/>';
				}
				$output[] = $universityDetails;
				//$date1 = strtotime($r['created']);	
				//$orgDate = date('d-m-Y', $date1); 
				//$output[] = $orgDate;
					
				
				$date2 = $r['SubmitDate'];	
				$output[] = date('d-m-Y',$date2);

				$universityConfirmData = $this->common_model->getconfirmationDataforHqrsbyUniversityId($r['application_no'],$universityId);
				$universityMissionConfirmData = $this->common_model->getconfirmationDataByMissionStatus($r['application_no']);
				//var_dump($universityMissionConfirmData);die;
				//echo "<pre>";print_r($universityConfirmData);die;
				$universityMappingData = $this->common_model->getmappingDataforHqrsbyUniversityId($r['application_no'],$universityId);
				//echo "<pre>";print_r($universityMissionConfirmData);
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'university/viewfullApplication/'.$applicationDetails[0]['application_no'].'" target = "_blank" class="form-control sbmt1">View</a>';
				
				if(!empty($r['universities_status']) && $r['universities_status'] == 1 && !empty($universityConfirmData)){
				
				$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;"  class="form-control sbmt1" disabled>Click Here</a>';
				
				}
				else
				{
					
					$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =editRemarks("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Click Here</a>';
				}
				
				if(!empty($r['universities_status']) && $r['universities_status'] == 1 && !empty($universityConfirmData) || $universityMappingData[0]['status'] == 3  || $universityMissionConfirmData[0]['confirmed_to_mission'] == 1) {
					
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" disabled = disbaled href="javascript:void(0);" class="form-control sbm">Click Here</a>';
				}
				else{
					
					$date1 = '2023-12-31';
					
						//$date1 = '2019-12-01';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($r['created']);
					if ($date2 >= $date1) {
						
					
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'university/viewApplication/'.$applicationDetails[0]['application_no'].'" target = "_blank" class="form-control sbmt">Click Here</a>';
					}
					else
					{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="#" target = "_blank" class="form-control sbmt">Click Here</a>';
					}
				}
				
				
				$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =openStatus("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Status</a>';
				$output[] = '<a target="_blank" href="'.site_url().'university/downloadStudent_zip/'.$r['application_no'].'" target="_blank"><span class = "label label-success">Download</span></a>';
				
				$response[] = $output; 
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	
	public function getNewUniversityApproveApplicaitons()
    {
		//echo "sddfsdfsd";die;
		$year= $this->uri->segment(3);
    	$user_data = $this->session->userdata('user_data');
		//echo "<pre>";print_r($user_data);die;
		//$missionId = $user_data['user_country'];
		//$misionData = $this->common_model->getMissionInfo($missionId);
    	//$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		//echo "<pre>";print_r($vars);die;pending_application
		//$counter = $_POST['start'];
		$universityId = $user_data['university'];
		$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
		//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
		$result = $this->university_model->getUniversityApprovedApplications($vars,$universityId,$year);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->university_model->getTotalUniversityApprovedApplications($vars,$universityId,$year);
		
		$response = array();
		//$counter++;
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				
				//echo "<pre>";print_r($r);die;
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				$gender = "";
				$output= array();	
				$output[] = $counter;
					$date1 = '2019-12-01';
						//$date1 = '2019-12-01';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($r['created']);
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
				$output[] = $applicationDetails[0]['application_no'];
				$output[]= $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'].$new;
				$output[] = $applicationDetails[0]['email'];
				$output[] = $applicationDetails[0]['passport_no'];
				$output[] = $applicationDetails[0]['dob'];
				$output[] = $applicationDetails[0]['phone_number'];
				$output[] = ($applicationDetails[0]['gender']== 1) ? 'Male' : 'Female';
				$output[] = $country[0]['country_name'];	
				$progrm = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
				$output[] = $progrm[0]['name'];
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$nomenclature = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature']);
					$nomenclature1 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_two']);
					$nomenclature2 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_three']);
					$nomenclature3 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fourth']);
					$nomenclature4 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					if($universityId == $applicationDetails[0]['universty_choice']){
					$fullCourse .= $nomenclature[0]['title'].' '.$applicationDetails[0]['course_option_name'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_two']){
					$fullCourse .= $nomenclature1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_three']){
					$fullCourse .= $nomenclature2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$fullCourse .= $nomenclature3[0]['title'].' '.$applicationDetails[0]['course_option_name_fourth'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$fullCourse .= $nomenclature4[0]['title'].' '.$applicationDetails[0]['course_option_name_fifth'].'<br/>';
					}
					$output[] = $fullCourse;
				}
				$universityDetails = "";
				if($universityId == $applicationDetails[0]['universty_choice']){
					$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_two']){
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_three']){
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
				$uni4 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fourth']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
				$uni5 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fifth']);
				}
				if($universityId == $applicationDetails[0]['universty_choice']){
				$universityDetails .= ' '.$uni1[0]['name'].'<br/>';		
				}
				if($universityId == $applicationDetails[0]['universty_choice_two']){
					$universityDetails .= ' '.$uni2[0]['name'].'<br/>';
				}
				if($universityId == $applicationDetails[0]['universty_choice_three']){
					$universityDetails .= ' '.$uni3[0]['name'].'<br/>';
				}
				if($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$universityDetails .= ' '.$uni4[0]['name'].'<br/>';	
				}
				if($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$universityDetails .= ' '.$uni5[0]['name'].'<br/>';
				}
				$output[] = $universityDetails;
				//$date1 = strtotime($r['created']);	
				//$orgDate = date('d-m-Y', $date1); 
				//$output[] = $orgDate;
					
						
						$date2 = $r['SubmitDate'];	
						$output[] = date('d-m-Y',$date2);
							if($universityId == $r['regional_university']){
							$date1 = $r['region_one_status_date'];
							$confirmationDate =  date('d-m-Y',$date1);
							}
							elseif($universityId == $r['regional_university']){
							$date1 = $r['region_one_status_date'];
							$confirmationDate = date('d-m-Y',$date1);
							}
							elseif($universityId == $r['regional_university']){
							$date1 = $r['region_one_status_date'];
							$confirmationDate = date('d-m-Y',$date1);
							}
							elseif($universityId == $r['regional_university']){
							$date1 = $r['region_one_status_date'];
							$confirmationDate = date('d-m-Y',$date1);
							}
							elseif($universityId == $r['regional_university']){
							$date1 = $r['region_one_status_date'];
							$confirmationDate = date('d-m-Y',$date1);
							}
							$output[] = $confirmationDate;
							//echo "<pre>";print_r($confirmationDate);die;
				
				$universityConfirmData = $this->common_model->getconfirmationDataforHqrsbyUniversityId($r['application_no'],$universityId);
				//echo "<pre>";print_r($universityConfirmData);die;
				
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'university/viewProcessedApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt1" target = "_blank">View</a>';
				
				if(!empty($r['universities_status']) && $r['universities_status'] == 1 && !empty($universityConfirmData)){
				
				$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;"  class="form-control sbmt1" disabled>Click Here</a>';
				
				}
				else
				{
					
					$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =editRemarks("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Click Here</a>';
				}
				
				
				
				$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =openStatus("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Status</a>';
				$response[] = $output; 
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	
	  public function getUniversityRejectedApplicaitons()
    {
		//echo "sddfsdfsd";die;
		$year= $this->uri->segment(3);
		//echo $year;die;
    	$user_data = $this->session->userdata('user_data');
		//echo "<pre>";print_r($user_data);die;
		//$missionId = $user_data['user_country'];
		//$misionData = $this->common_model->getMissionInfo($missionId);
    	//$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		//echo "<pre>";print_r($vars);die;pending_application
		//$counter = $_POST['start'];
		$universityId = $user_data['university'];
		$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
		//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
		$result = $this->university_model->getUniversityRejectedApplications($vars,$universityId,$year);
		//echo "<pre>";print_r($result);die; 
		$totalResult = $this->university_model->getTotalUniversityRejectedApplications($vars,$universityId,$year);
		
		$response = array();
		//$counter++;
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				
				//echo "<pre>";print_r($r);die;
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				$gender = "";
				$output= array();	
				$output[] = $counter;
					$date1 = '2019-12-01';
						//$date1 = '2019-12-01';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($r['created']);
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
				$output[] = $applicationDetails[0]['application_no'];
				$output[]= $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'].$new;
				$output[] = $applicationDetails[0]['email'];
				$output[] = $applicationDetails[0]['passport_no'];
				$output[] = $applicationDetails[0]['dob'];
				$output[] = $applicationDetails[0]['phone_number'];
				$output[] = ($applicationDetails[0]['gender']== 1) ? 'Male' : 'Female';
				$output[] = $country[0]['country_name'];	
				$progrm = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
				$output[] = $progrm[0]['name'];
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
					$course3 = $this->common_model->getCoursesById($applicationDetails[0]['course_fourth']);
					$course4 = $this->common_model->getCoursesById($applicationDetails[0]['course_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					if($universityId == $applicationDetails[0]['universty_choice']){
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_two']){
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_three']){
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$fullCourse .= $course3[0]['title'].' '.$applicationDetails[0]['course_option_name_fourth'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$fullCourse .= $course4[0]['title'].' '.$applicationDetails[0]['course_option_name_fifth'].'<br/>';
					}
					$output[] = $fullCourse;
				}
				$universityDetails = "";
				if($universityId == $applicationDetails[0]['universty_choice']){
					$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_two']){
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_three']){
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
				$uni4 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fourth']);
				}
				elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
				$uni5 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fifth']);
				}
				if($universityId == $applicationDetails[0]['universty_choice']){
				$universityDetails .= ' '.$uni1[0]['name'].'<br/>';		
				}
				if($universityId == $applicationDetails[0]['universty_choice_two']){
					$universityDetails .= ' '.$uni2[0]['name'].'<br/>';
				}
				if($universityId == $applicationDetails[0]['universty_choice_three']){
					$universityDetails .= ' '.$uni3[0]['name'].'<br/>';
				}
				if($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$universityDetails .= ' '.$uni4[0]['name'].'<br/>';	
				}
				if($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$universityDetails .= ' '.$uni5[0]['name'].'<br/>';
				}
				$output[] = $universityDetails;
				//$date1 = strtotime($r['created']);	
				//$orgDate = date('d-m-Y', $date1); 
				//$output[] = $orgDate;
					
				
				$date2 = $r['SubmitDate'];	
				$output[] = date('d-m-Y',$date2);

				
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'university/viewProcessedApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt1" target = "_blank">View</a>';
				//$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =editRemarks("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Click Here</a>';
				
				$universityConfirmData = $this->common_model->getconfirmationDataforHqrs($r['application_no']);
				
				if(!empty($r['universities_status']) && $r['universities_status'] == 1){
					
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" disabled = disbaled href="javascript:void(0);" class="form-control sbm">Click Here</a>';
				}
				else{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'university/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt">Click Here</a>';
				}
				
				$output[] ='<a href="javascript:void(0);" style="float:left;width:104px;" onclick =openStatus("'.$applicationDetails[0]['application_no'].'") class="form-control sbmt1">Status</a>';
				$response[] = $output; 
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		//print_r($response);die;
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	public function index()
	{
		try{
			
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			
			$data['universityData'] = $this->common_model->getUniversityInfo($missionId);
			//$data['newApplication'] = count($this->common_model->getMissionApplications($this->ids));
			//$data['approvedApplication'] = count($this->common_model->getMissionsProcessedApplications($this->ids));
			//$data['rejectedApplication'] = count($this->common_model->getMissionsRejectedApplications($this->ids));
			//$data['results'] = count($this->common_model->getEnglishProficiencyTestResults($this->ids));
			//$data['confirmationForwardtoMissionbyHqrs'] = count($this->common_model->getConfirmationofHqrs($this->ids));
			//$data['listofacceptance'] = count($this->common_model->getConfirmationofCandidates($this->ids));
			//$data['visaendrosment'] = count($this->common_model->getAcceptedCandidates($this->ids));
			//$data['travel'] = count($this->common_model->getVisaConveyedApplicatgion($this->ids));
			//$data['holdapplications']= count($this->common_model->hold_applications($this->ids));
			//$data['pending_application']= count($this->common_model->pending_applications($this->ids));
			//$data['resubmitapplication']= count($this->common_model->resubmitapplication($this->ids));
			$this->load->view('university/header_mission');
			$this->load->view('university/dashboard',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'university/dashboard');
		}
	}	
		public function profile()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			//$missionId = $user_data['user_country'];
			
			$universityId = $user_data['university'];
			
			$postData = $this->input->post(NULL,TRUE);
			if(count($postData)>0)
			{
				$cleanData = $this->security->xss_clean($postData);	
				//echo "<pre>";print_r($cleanData);die;
				$status = $this->common_model->updateProfileUniversity($cleanData,$universityId);
				if($status)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Profile Successfully Updated!');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Updating Profile! Try Again Later.');
				}
			}
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			//echo "<pre>";print_r($data['universityData']);die;
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$this->load->view('university/header_mission');
			$this->load->view('university/profile',$data);
			$this->load->view('university/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'university/dashboard');
		}
	}
	public function changepassword()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');	
			$postData = $this->input->post(NULL,TRUE);
			//print_r($postData);die;
			if(count($postData)>0)
			{
				$cleanData = $this->security->xss_clean($postData);	
				if(count($this->common_model->oldPasswordMatched($cleanData['id'],$cleanData['oldpassword'])))
				{
					$profileData = array(
						'id'=>$cleanData['id'],
						'password'=>$cleanData['newpassword']				
					);			
					$message = '';                
					$message .= '<strong>Your Password has been updated Sucessfully.</strong><br><br>';
					$data = array(
					'content' => $message					   
					);
					$config = Array(
					'mailtype' => 'html'				        
					);
					$content = $this->load->view('change_password',$data, true); 
					//$from_email = "diritc.iccr@gov.in"; 
					$from_email = "vipin.bisht@velocis.co.in"; 
					$to_email = $user_data['email']; 			   
					/* Load email library */
					$this->load->library('email',$config);			   
					$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
					$this->email->to($to_email);
					$this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
					$this->email->message($content);
					if($this->email->send())
					{
						$status = $this->common_model->updateProfilePassword($profileData);
						if($status)
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Password Successfully Updated!');
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error Occur While Updating Password! Try Again Later.');
						}
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error Occur While Email not send! Try Again Later.');
					}	
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Old Password Not Matched.');
				}
			}
			$universityId = $user_data['university'];
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			$data['head'] = $this->session->userdata('user_data');
			$this->load->view('university/header_mission');
			$this->load->view('university/changepassword',$data);
			$this->load->view('university/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'university/dashboard');
		}
	}
	
	public function confirmaitonofuniversityformhqrs()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['confirmaitonofuniversityformhqrs'] = $this->common_model->getConfirmationofFourthOptionByHqrs($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/universityconfirmaitonformhqrs',$data);
			$this->load->view('mission/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	//pages
	
	public function page($page_slug=null)
		{
			//echo $page_slug;die;
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);die;
			$data['university'] = $user_data['university'];
			$universityId = $user_data['university'];
			$data = array();
			$data['pages'] = $this->common_model->getUniversityPages($page_slug,$page_title,$universityId);
			//echo "<pre>";print_r($data['pages']);die;
			
			$this->load->view('university/header_mission');
			$this->load->view('university/pages',$data);
			$this->load->view('university/footer');
		}
	public function addPages(){
		
		$user_data = $this->session->userdata('user_data');
		//echo "<pre>";print_r($user_data);die;
			$universityId = $user_data['university'];
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			$data = array();
			$data['pages'] = $this->common_model->getUniversityPages($page_slug,$page_title,$universityId);
			//echo "<pre>";print_r($data['universityData']);die;
			
			$this->load->view('university/header_mission');
			$this->load->view('university/add_page',$data);
			$this->load->view('university/footer');
	}
	
	 public function create()
    {
        $user_data = $this->session->userdata('user_data');
		$data['university'] = $user_data['university'];
		$universityId = $user_data['university'];
		//$this->form_validation->set_rules('master_page_id', 'Page Category', 'required');
        $this->form_validation->set_rules('page_title', 'Title', 'required');
        $this->form_validation->set_rules('page_slug', 'Slug', 'required');
        $this->form_validation->set_rules('page_description', 'Description', 'required');

        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE)
        {
            $validation_errors = $this->form_validation->error_array();
			
            $message = array('type'=>'error', 'errors'=>$validation_errors);
            $this->session->set_flashdata('message', $message);

            redirect(base_url('university/addPages'));
        }
        else
        {
            //$post = $this->security->xss_clean($this->input->post(NULL, TRUE)) ;
            $post = $this->input->post() ;
			$master_page_id = isset($post['master_page_id']) && !empty($post['master_page_id'])?$post['master_page_id']:0;
            $data = array(
				'master_page_id' => 0,
                'page_title' => $post['page_title'],
                'page_slug' => $post['page_slug'],
                'page_description' => $post['page_description'],
                //'meta_title' => $post['meta_title'],
                //'meta_keyword' =>trim($post['meta_keyword']),
                //'meta_description' => trim($post['meta_description']),
                'status' => 1,
                'created_on' => date('Y-m-d H:i:s')
            );
	        //echo "<pre>";print_r($data);die;
            $lastId = $this->university_model->updateUniversityPage($universityId,$data,$post);
            if($lastId)
            {
				/* if($_FILES["page_main_image"]['name'] != "")
				{				
					$ext = pathinfo($_FILES["page_main_image"]['name'],PATHINFO_EXTENSION);
					$imgname = time().'.'.$ext;		  
					$target_file = 'assets/site/main/page_main_image/'.$imgname; 
					if(move_uploaded_file($_FILES["page_main_image"]["tmp_name"], $target_file)) 
					{
						$data = array(
							'page_main_image' => $imgname
						);
						$update_page_image = $this->general->update('iccr_page', $data,$post['page_slug']);
						if($update_page_image)
						{
							
						}else{
						$message = array('type'=>'error', 'message'=>'Unable to upload image..!');
						$this->session->set_flashdata('message', $message);

						redirect(base_url('admin/page/add'));	
						}
					}else{
						$message = array('type'=>'error', 'message'=>'Unable to upload image..!');
						$this->session->set_flashdata('message', $message);

						redirect(base_url('admin/page/add'));	
					}
				} */
                $message = array('type'=>'success', 'message'=>'New page added successfully !');
                $this->session->set_flashdata('message', $message);

                redirect(base_url('university/addPages'));
            }
            else{
                $message = array('type'=>'error', 'message'=>'Unable to add page, please try again !');
                $this->session->set_flashdata('message', $message);

                redirect(base_url('admin/page/add'));
            }
        }

    }
	public function programme($page_slug=null)
		{
			$user_data = $this->session->userdata('user_data');
			$data['university'] = $user_data['university'];
			$universityId = $user_data['university'];
			$data = array();
			//$data['mappingData'] = $this->common_model->getCoursesMappingData($universityId);
			//echo "<pre>";print_r($data['mappingData']);die;
			$data['pages'] = $this->common_model->getUniversityPages($page_slug,$page_title,$universityId);
			//echo "<pre>";print_r($data['pages']);die;
			$this->load->view('university/header');
			$this->load->view('university/courses',$data);
			$this->load->view('university/footer');
		}
	public function saveAlumniData()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
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
			if ($frst != $sec) 
			{				
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File content is not Valid!');
				redirect(site_url().'mission/alumniApplication');				
				return;
			}
			if ($nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File content is not Valid!');
				redirect(site_url().'mission/alumniApplication');		
				return;			
			}
			if ($sizekbb > 5242880) 
			{			
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File size is not Valid!');
				redirect(site_url().'mission/alumniApplication');	
				return;
			}
			 
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = $application_no.'_'.time().'_alumni_pics_'.$name;
			  
			  $target_file = 'assets/site/main/alumni_pic/'.$imgname; 
			  if (move_uploaded_file($_FILES["img_alumnai"]["tmp_name"], $target_file)) 
			  { 
			  	 $postData['mission_id'] = $missionId;
			  	 //$postData['application_id'] = $application_no;
			  	 $postData['photo'] = $imgname;
			 	 $result = $this->common_model->insertAlumniData($postData);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Alumni Details Saved!');
					redirect(site_url().'mission/alumni');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
					redirect(site_url().'mission/alumni');					
				 }
			  }
			  else
			  {
		  		$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
				redirect(site_url().'mission/alumni');
			  }
			} 
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
				redirect(site_url().'mission/alumni');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'mission/alumni');
		}
	}
	public function historyview()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];		
			$data['university'] = $user_data['university'];
			$universityId = $user_data['university'];
			$data['applicaitonStepOne'] = $this->common_model->getUniversityApplicationStepOneByAppno1($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}	
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
			if(count($imgArray)> 0)
			{
				$image = $imgArray[0]['name'];
			}		
			else
			{
				$image = '';
			}
			$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			$data['userImage'] = $image;
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['mappingData'] = $this->common_model->getMappingData($applicationId);
			$this->load->view('university/header_mission');
			$this->load->view('university/acceptanceHistory',$data);
			$this->load->view('university/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function viewfullApplication()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$data['applicaitonStepOne'] = $this->common_model->getUniversityApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}		
			
			
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
			if(count($imgArray)> 0)
			{
				$image = $imgArray[0]['name'];
			}		
			else
			{
				$image = '';
			}
			$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			$data['userImage'] = $image;
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyAppNo($applicationId);
			$this->load->view('university/header_mission');
			$this->load->view('university/viewFullApplication',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}		
	}
	public function viewApplication()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$data['applicaitonStepOne'] = $this->common_model->getUniversityApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}		
			
			
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
			if(count($imgArray)> 0)
			{
				$image = $imgArray[0]['name'];
			}		
			else
			{
				$image = '';
			}
			$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			$data['userImage'] = $image;
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyAppNo($applicationId);
			$this->load->view('university/header_mission');
			$this->load->view('university/viewApplication',$data);
			$this->load->view('university/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'university/dashboard');
		}
	}
	public function pending_application()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$universityId = $user_data['university'];
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['pending_applications']= $this->university_model->pending_applications($universityId);
			$this->load->view('university/header_mission');
			$this->load->view('university/pending_applications',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'university/dashboard');
		}
	}
	public function viewAlumaniDetails()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$appno = $this->uri->segment(3);
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['alunamiapplication']= $this->common_model->getAlumaniApplicationbyId($appno);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/viewAlumaniApplication',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function alumni()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['alunamiapplication']= $this->common_model->getAlumaniApplications($missionId);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/alumani',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function hold_applications()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$universityId = $user_data['university'];
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['holdapplications']= $this->university_model->hold_applications($universityId);
			$this->load->view('university/header_mission');
			$this->load->view('university/hold_applications',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function holdApplication()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$appno = $this->input->post('appno');
			$status = $this->common_model->holdApplicationByUniversity($appno,$universityId);
			if($status)
			{
				echo json_encode(array('status'=>TRUE));
			}
			else
			{
				echo json_encode(array('status'=>FALSE));
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'university/dashboard');
		}
	}
	public function forward()
	{
		$appno = $this->uri->segment(3);
		try{
			$status = $this->common_model->ApplicationForwardFromMission($appno);
			if($status)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Application Forward Successfully!');
				redirect(site_url().'mission/approved_applications');
				
			}			
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function generate_zip($files = array(), $path)
	{
	    if (empty($files)) {
	        throw new Exception('Archive should\'t be empty');
	    }
	    $this->load->library('zip');
	    foreach ($files as $file) {
	        $this->zip->read_file($file);
	    }
	    $this->zip->archive($path);
	}
public function downloadStudent_zip($path)
{   
    $this->load->library('zip');

    $applicationId = $this->uri->segment(3);

    $studentsDetails = $this->common_model->getApplicationDocumentsByAppId($applicationId);

    if(!empty($studentsDetails))
    {
        foreach($studentsDetails as $row)
        {
            if(!empty($row['doc_path']))
            {
                $file = FCPATH . $row['doc_path'];

                if(file_exists($file))
                {
                    $this->zip->read_file($file);
                }
            }
        }
    }

    $this->zip->download($applicationId.'_documents.zip');
}
	public function new_applications()
	{
		try{
			
			$data['year']= $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);die;
			//$missionId = $user_data['user_country'];
			$universityId = $user_data['university'];
			//echo $universityId;die;
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			//$data['newApplication']= $this->common_model->getMissionApplications($this->ids);
			$this->load->view('university/header_mission');
			$this->load->view('university/new_applications',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'university/dashboard');	
		}
	}
	public function rejected_applications()
	{
		try{
			$data['year']= $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);die;
			//$missionId = $user_data['user_country'];
			$universityId = $user_data['university'];
			//echo $universityId;die;
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			//$data['newApplication']= $this->common_model->getMissionApplications($this->ids);
			$this->load->view('university/header_mission');
			$this->load->view('university/rejected_applications',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'university/dashboard');	
		}
	}
	public function applicant_guidlines()
	{
		try{
			$this->load->view('mission/header_mission');
			$this->load->view('mission/applicant_guidlines');
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function mission_guidlines()
	{
		try{
			$this->load->view('mission/header_mission');
			$this->load->view('mission/mission_guidlines');
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function instructions()
	{
		try{
			$this->load->view('mission/header_mission');
			$this->load->view('university/instructions');
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function checklist()
	{
		try{
			$data['applicaitonStepOne']= $this->common_model->getMissionApplications();
			$this->load->view('mission/header_mission');
			$this->load->view('mission/checklist');
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function getProcessedApplications()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionid = $user_data['user_country'];
			$data['approvedApplication'] = $this->common_model->getMissionsProcessedApplications($missionid);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/approved_applications',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');	
		}
	}
	function approved_applications()
	{
		try{
			$data['year']= $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$missionid = $user_data['user_country'];
			$universityId = $user_data['university'];
			$regionid = $user_data['state'];
			$data['regionId'] = $regionid;
			//$data['misionData'] = $this->common_model->getMissionInfo($missionid);
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			//$data['approvedApplication'] = $this->university_model->getUniversityProcessedApplications($universityId);
			//echo "<pre>";print_r($data['approvedApplication']);die;
			$this->load->view('university/header_mission');
			$this->load->view('university/approved_applications',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'university/dashboard');	
		}
	}

	function createTravelPlan()
	{
		try{
			$applicationId = $this->uri->segment(3);	
			$user_data = $this->session->userdata('user_data');
			
			$missionid = $user_data['user_country'];		
			$data['misionData'] = $this->common_model->getMissionInfo($missionid);
			$data['mappingData'] = $this->common_model->getMappingData($applicationId);
			$data['appno'] = $applicationId;
			$data['travel'] = $this->common_model->getMappingData($applicationId);	
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);				
			$this->load->view('mission/header_mission');
			$this->load->view('mission/createtravelplan',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');	
		}
	}
	function travelpaln()
	{
		try
		{
			$imgname ="";
			$files = $_FILES['travel_plan_doc'];      		
			$applicationId = $this->uri->segment(3);
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = time().'_TravelPlan_'.$name;
			  
			  $target_file = 'assets/site/main/travelplan/'.$imgname; 	
			  if (move_uploaded_file($_FILES["travel_plan_doc"]["tmp_name"], $target_file)) { 	
			  		$data = array(			  			
			  			'travel_plan_doc' =>$imgname,
			  			'departure_date' =>$this->input->post('departure_date'),
			  			'travel_arrival_date' =>$this->input->post('travel_arrival_date'),
			  			'flight_no' =>$this->input->post('flight_no'),
			  			'final_city_arrival' =>$this->input->post('final_city_arrival'),
			  			'city_other' =>$this->input->post('city_other'),
			  			'regional_office_contacted' =>$this->input->post('regional_office_contacted'),
			  			'cost_of_ticket' =>$this->input->post('cost_of_ticket'),
			  			'created' =>time(),
			  			'application_id'=>$applicationId,
			  			'status'=>13
			  		 );
			  		$sts = $this->common_model->insertTravelPlan($data);
			  	  if($sts > 0)
			  	  {
			  	  	$data = array(			
					'status'=>13
					);
					$sts = $this->common_model->scholarArrived($applicationId,$data);	
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Travel Plan Uploaded!');
					redirect(site_url().'mission/travel_applications');				  	  					  	
				  }			  
			  }
			  else
			  {
		  		$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
				redirect(site_url().'mission/travel_applications');					
			  }
			}
		}
		catch(Exception $e)
		{
		  	echo json_encode(array('status'=>FALSE));
		}
	}
	function confirmregionforTravel()
	{
		try
		{
			$applicationId = $this->uri->segment(3);		
			$data['non_xss']= array(
				'travel_informed_to_region' =>1
			);		
			$data['xss_data'] = $this->security->xss_clean($data['non_xss']);
			
			$status = $this->common_model->confirmregionforTravel($data['xss_data'],$applicationId);
			if($status)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Travel Plan Informed Successfully!');
				redirect(site_url().'mission/travel_applications');					
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Some Internal Error Occured While Informing to Region!');
				redirect(site_url().'mission/dashboard');	
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'mission/dashboard');	
		}
	}
	function travel_applications()
	{
		try{
			
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			//echo $universityId;die;
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
		//echo "<pre>";print_r($this->ids);
			$data['travel'] = $this->university_model->getVisaConveyedApplicatgionUniversity($universityId);			
			$this->load->view('university/header_mission');
			$this->load->view('university/travel_applications',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function alumniApplication()
	{
		try{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$missionid = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionid);
			if($applicationId == NULL || $applicationId == "")
			{
				$applicationId = $this->random_num(15);
			}	
			else
			{
				$applicationId = $this->uri->segment(3);
			}
			$data['appno'] = $applicationId;
			//$data['travel'] = $this->common_model->getVisaConveyedApplicatgion($missionid);			
			$this->load->view('mission/header_mission');
			$this->load->view('mission/alumni_application',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'mission/dashboard');
		}
	}	
	public function downloadUndertaking()
	{
		try
		{
			$this->load->file('fpdi/PdfHTMLTable.php');
			$appno = $this->uri->segment(3);
			$pdf = new PdfHTMLTable();		
			$pdf->AddPage('P');	
			$pdf->applicationId = $appno;		
			$pdf->SetXY(10.0,45.0);
			$pdf->SetDisplayMode('default');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetTitle('Indian Council For Cultural Relations',false);
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',10);	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'mission/dashboard');
		}	
	}		
	public function logout()
    {
       	$userInfo =$this->session->userdata('user_data');
		$lastLoginHistry = $this->user_model->updateLogoutHistry($userInfo);
        $this->session->unset_userdata('salt');
        $this->session->sess_destroy();
        redirect('home');
    }	
    public function results()
    {
		try{
			$user_data = $this->session->userdata('user_data');
			$missionid = $user_data['user_country'];
			$data['results'] = $this->common_model->getEnglishProficiencyTestResults($missionid);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/english_results',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function dashboard()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);die;
			$missionId = $user_data['user_country'];
			$universityId = $user_data['university'];
			$data['university'] = $user_data['university'];
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			//echo "<pre>";print_r($data['universityData']);die;
			$data['newCountApplication'] = $this->university_model->getCountUniversityApplications($universityId);
			$data['newCountMissingDocuments'] = $this->university_model->getCountMissingDocumentsUniversityApplications($universityId);
			//$data['approvedApplication'] = count($this->common_model->getMissionsProcessedApplications($this->ids));
			
			$data['countapprovedApplication'] = $this->university_model->countgetUniversityProcessedApplications($universityId);
			$data['countapprovedApplication_2026'] = $this->university_model->countgetUniversityProcessedApplications_2026($universityId);
			$data['countapprovedApplication_2025'] = $this->university_model->countgetUniversityProcessedApplications_2025($universityId);
			//$data['countapprovedApplication_2024'] = $this->university_model->countgetUniversityProcessedApplications_2024($universityId);
			$data['countrejectedApplication'] = $this->university_model->countgetUniversityRejectedApplications($universityId);
			//print_r($data['countapprovedApplication']);die;
			//print_r($data['countapprovedApplication']);die;
			//$data['rejectedApplication'] = count($this->common_model->getMissionsRejectedApplications($this->ids));
			
			//$data['results'] = count($this->common_model->getEnglishProficiencyTestResults($this->ids));
			//$data['confirmationForwardtoMissionbyHqrs'] = count($this->common_model->getConfirmationofHqrs($this->ids));
			
			$data['countconfirmationForwardtoMissionbyHqrs'] = $this->university_model->countgetConfirmationofHqrs($this->ids);
			
			//$data['confirmaitonofuniversityformhqrs'] = count($this->common_model->getConfirmationofFourthOptionByHqrs($this->ids));
			
			//$data['countconfirmaitonofuniversityformhqrs'] = $this->university_model->countgetConfirmationofFourthOptionByHqrs($this->ids);
			
			 //$data['listofacceptance'] = count($this->common_model->getConfirmationofCandidates($this->ids));
			
			
			$data['countlistofacceptance'] = $this->university_model->countgetConfirmationofCandidates($universityId);
			
			//$data['visaendrosment'] = count($this->common_model->getAcceptedCandidates($this->ids));
			
			$data['countvisaendrosment'] = $this->university_model->countgetAcceptedCandidates($universityId);
			
			//$data['countvisaendrosment'] = count($this->university_model->getVisaConveyedApplicatgion($universityId));
			
			$data['counttravel'] = $this->university_model->countgetVisaConveyedApplicatgion($universityId);
			
			
			//$data['holdapplications']= count($this->common_model->hold_applications($this->ids));
			
			$data['countholdapplications']= $this->university_model->counthold_applications($universityId);
			
			//$data['pending_application']= count($this->common_model->pending_applications($this->ids));
			
			$data['countpending_application']= $this->university_model->countpending_applications($universityId);
			
			//$data['resubmitapplication']= count($this->common_model->resubmitapplication($this->ids));
			
			$data['countresubmitapplication']= $this->university_model->countresubmitapplication($universityId);
			
			//$data['alumanidata'] = count($this->common_model->getAlumaniApplications($missionId));
			$this->load->view('university/header_mission');
			$this->load->view('university/dashboard',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'university/dashboard');
		}
	}
	function acceptance()
	{
		try
		{
			$appno = $this->uri->segment(3);
			$data = array(
				'scholar_acceptance'=>1,					
				'status'=>11
			);
			$sts = $this->common_model->scholarconfirmation($data,$appno);	
			if($sts)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Application Accepted Successfully!');
				redirect(site_url().'mission/confirmaitonreceivesformhqrs');				
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
				redirect(site_url().'mission/confirmaitonreceivesformhqrs');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/confirmaitonreceivesformhqrs');
		}	
	}
	
	function rejection()
	{
		try
		{
			$appno = $this->uri->segment(3);
			$data = array(
				'scholar_acceptance'=>2,					
				'status'=>12
			);
			$sts = $this->common_model->scholarconfirmation($data,$appno);	
			if($sts)
			{
				 $this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Application Rejected Successfully!');
				redirect(site_url().'mission/confirmaitonreceivesformhqrs');
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
				redirect(site_url().'mission/confirmaitonreceivesformhqrs');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/confirmaitonreceivesformhqrs');
		}
			
	}
	function confirmtomissionofuseracceptance()
	{
		try
		{
			$appno = $this->uri->segment(3);
			$data = array(									
				'status'=>7
			);
			$sts = $this->common_model->confirmtomissionofuseracceptance($appno,$data);	
			if($sts)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Confirm to Head Quarter Successfully!');
				redirect(site_url().'mission/listofacceptance');				
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur while confirmation!');
				redirect(site_url().'mission/listofacceptance');				
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/confirmaitonreceivesformhqrs');
		}	
	}
	function travelSchedule()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$stepthree = $this->common_model->getApplicationStepThreebyAppNo($applicationId);		
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$mission = $this->common_model->getMissionInfo($stepthree[0]['application_through']);
			$course = $this->common_model->getCoursesById($stepOne[0]['course']);
			$uni = $this->common_model->getUniversityById($schemeId[0]['regional_university']);
			$this->load->file('fpdi/PdfHTMLTable.php');
			$pdf = new PdfHTMLTable();	
			$pdf->AddPage('P');
			$pdf->SetXY(10.0,5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial','',7);
			$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
			$pdf->MultiCell(180,5,'Date: '.date('d M Y h:i:s'),'','R');
			
			$pdf->SetXY(10.0,45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations',false);		
			$pdf->SetFont('Arial','',10);	
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'1. Name of scholar                                             : '.$stepOne[0]['fullname'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'2. Country                                                           : '.$country[0]['country_name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'3. Mission dealing                                               : '.$mission[0]['mission_name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'4. Scheme                                                           : '.$schemename[0]['scheme_name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'5. Course admitted to                                          : '.$course[0]['title'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'6. University admitted to                                      : '.$uni[0]['name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'7. Date of Departure                                            : '.$schemename[0][''],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'8. Date of arrival in India                                      : '.$schemename[0][''],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'9. Flight Number                                                  : '.$schemename[0][''],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'10. Final city of arrival                                          : '.$schemename[0][''],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'11. Regional Office to be contacted                    : '.$schemename[0][''],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'12.	 Cost of Ticket (INR)                                      : '.$schemename[0][''],'','L');
			$pdf->Ln(15);
			$pdf->SetFont('Arial','B');
			$pdf->MultiCell(180,5,'Signature:'.$schemename[0][''],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'Name of Official:'.$schemename[0][''],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'Mission/Post:'.$schemename[0][''],'','L');
			$pdf->Ln(5);
			$filename = $applicationId."_Travel_Plan_".date('jS-F-Y-h-i-s').'.pdf';
			$pdf->Output($filename,"D");
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function visaendrosment()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			//$missionId = $user_data['user_country'];
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$universityId = $user_data['university'];
			//echo $universityId;die;
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			$data['visaendrosment'] = $this->university_model->getAcceptedCandidatesUniversity($universityId);
			$this->load->view('university/header_mission');
			$this->load->view('university/visaendrosment',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function visaapply()
	{
		try
		{
			$applicationId = $this->uri->segment(3);	
			$arrival_date = $this->input->post('arrival_date') . "-".$this->input->post('arrival_month').'-'.$this->input->post('arrival_year');
			$duration_from = $this->input->post('visa_from_date');
			$duration_to = $this->input->post('duration_to_date');		
			$duration_issue_date = $this->input->post('visa_issue_date');
			$data['non_xss']= array(
				'arrival_date' => "",
				'visa_from_date' =>$duration_from,
				'visa_to_date'=>$duration_to,
				'visa_isuue_date'=>$duration_issue_date,
				'visa_no'=>$this->input->post('visa_no'),
				'status'=>13								
			);		
			$data['xss_data'] = $this->security->xss_clean($data['non_xss']);
			$status = $this->common_model->updateVisaInfo($data['xss_data'],$applicationId);
			if($status)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'VISA Endorsed Successfully!');
				redirect(site_url().'mission/visaendrosment');				
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
				redirect(site_url().'mission/visaendrosment');
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function getSlotsbySchemes()
	{
		$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];
		$mis = $this->common_model->getMissionInfo($missionId);		
		$data['non_xss']= array(
			'schemeid' => $this->input->post('schemeid')									
		);		
		$data['xss_data'] = $this->security->xss_clean($data['non_xss']);		
		$status = $this->common_model->getSlotsbySchemes($data['xss_data']['schemeid'],$mis[0]['country']);
		$sts = $this->common_model->getLeftSlots($mis[0]['country'],$data['xss_data']['schemeid']);
		if(count($status)>0)
		{
			$return['status'] = TRUE;
		 	$return['slots'] = $status[0]['slots'];
		 	if(count($sts)>0)
		 	{
				$return['slots_left'] = count($sts);	
			}
			else
			{
				$return['slots_left'] = 0;
			}
		}
		else
		{
			$return['status'] = FALSE;			
		}
		echo json_encode($return);
	}
	function scholarsvisaendrosment()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$applicationId = $this->uri->segment(3);
			$data['appno'] = $applicationId;
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/scholarsvisaendrosment',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}		
	}
	function listofacceptance()
	{
		try
		{
			$data['year']= $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
            $universityId = $user_data['university'];
		
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);            
			
			$data['listofacceptance'] = $this->university_model->getConfirmationofCandidates($universityId);
			//echo "<pre>";print_r($data['listofacceptance'] );die;
			$this->load->view('university/header_mission');
			$this->load->view('university/listofacceptance',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'university/dashboard');
		}
	}
	function listofacceptances()
	{
		try
		{
			$data['year']= $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
            $universityId = $user_data['university'];
		
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);            
			
			//$data['listofacceptance'] = $this->university_model->getConfirmationofCandidates($universityId);
			//echo "<pre>";print_r($data['listofacceptance'] );die;
			$this->load->view('university/header_mission');
			$this->load->view('university/listofacceptances',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'university/dashboard');
		}
	}
	
	 public function getUniversityAcceptance()
    {
		//echo "sddfsdfsd";die;
		$year= $this->uri->segment(3);
		//echo $year;die;
    	$user_data = $this->session->userdata('user_data');
		//echo "<pre>";print_r($user_data);die;
		//$missionId = $user_data['user_country'];
		//$misionData = $this->common_model->getMissionInfo($missionId);
    	//$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		//echo "<pre>";print_r($vars);die;pending_application
		//$counter = $_POST['start'];
		$universityId = $user_data['university'];
		$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
		//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
		$result = $this->university_model->getUniversityAcceptance($vars,$universityId,$year);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->university_model->getTotalUniversityAcceptance($vars,$universityId,$year);
		
		$response = array();
		//$counter++;
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				$output= array();	
				$output[] = $counter;
				$output[] = $r['application_no'];
				$output[]= $r['fullname'];
				$output[] = $r['email'];
				$country = $this->common_model->getCountryById($r['nationality']);
				$output[] = $country[0]['country_name'];	
				$progrm = $this->common_model->getProgrammeById($r['programme']);
				$output[] = $progrm[0]['name'];
				$uni = $this->common_model->getSchemeById($r['scholarship_id']);
				if(!empty($uni)){
						$scname = $uni[0]['scheme_name'];
						}else{
							$scname = "NA";
						}
				$output[]=$scname;
				if($r['scholar_acceptance'] == 1)
							{
								$st="Accepted";
							}
							elseif($app['scholar_acceptance'] == 2)
							{
								$st="Declined";
							}
							elseif($app['scholar_acceptance'] == -1)
							{
								$st= "Pending";
							}
					
					$output[]=$st;
			       $output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'university/historyview/'.$r['application_no'].'" class="form-control sbmt">View</a>';
				   $response[] = $output;
				   $counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	function processConfirmedappforFourthbyhqrs()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}	
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
			if(count($imgArray)> 0)
			{
				$image = $imgArray[0]['name'];
			}		
			else
			{
				$image = '';
			}
			$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			$data['userImage'] = $image;
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['mappingData'] = $this->common_model->getMappingData($applicationId);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/processConfirmedappforFourthbyhqrs',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function processConfirmedappfromhqrs()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];		
			$universityId = $user_data['university'];
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}	
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
			if(count($imgArray)> 0)
			{
				$image = $imgArray[0]['name'];
			}		
			else
			{
				$image = '';
			}
			$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			$data['userImage'] = $image;
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['mappingData'] = $this->common_model->getMappingData($applicationId);
						
			$this->load->view('university/header_mission');
			$this->load->view('university/processConfirmedappfromhqrs',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function confirmaitonreceivesformhqrs()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$universityId = $user_data['university'];
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);  
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['confirmationForwardtoMissionbyHqrs'] = $this->university_model->getConfirmationofHqrs($universityId);
			//$data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getConfirmationofApplicationIds($this->ids);
			
			$this->load->view('university/header_mission');
			$this->load->view('university/confirmaitonreceivesformhqrs',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function getFinancialYears($from,$nexttoyears)
   {
		$currentDate = $from;
		$lastFY = date('Y-m-d', strtotime('+'.$nexttoyears.' years'));
		return $this->calcFY($currentDate,$lastFY);
   }
   function calcFY($startDate,$endDate) 
   {

	    $prefix = '';

	    $ts1 = strtotime($startDate);
	    $ts2 = strtotime($endDate);

	    $year1 = date('Y', $ts1);
	    $year2 = date('Y', $ts2);

	    $month1 = date('m', $ts1);
	    $month2 = date('m', $ts2);

	    //get months
	    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

	    /**
	     * if end month is greater than april, consider the next FY
	     * else dont consider the next FY
	     */
	    $total_years = ($month2 > 4)?ceil($diff/12):floor($diff/12);

	    $fy = array();

	    while($total_years >= 0) {

	        $prevyear = $year1 - 1;

	        //We dont need 20 of 20** (like 2014)
	      //  $fy[] = $prefix.substr($prevyear,-2).'-'.substr($year1,-2);
	        $fy[] = $prevyear.'-'.$year1;

	        $year1 += 1;

	        $total_years--;
	    }
	    /**
	     * If start month is greater than or equal to april, 
	     * remove the first element
	     */
	    if($month1 >= 4) {
	        unset($fy[0]);
	    }
	    /* Concatenate the array with ',' */
	    return $fy;
	}
	function confirmationReceivedWithFormat()
	{
		try
		{
			$doc = array();
			$applicationId = $this->uri->segment(3);
			$uniid = $this->uri->segment(4);
			$response = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$region = 0;$coursename = "";$respFile="";
			if(count($response)>0)
			{
				foreach($response as $resp)
				{
					if($resp['university_is_accept'] == 1 && $resp['regional_university'] == $uniid)
					{
						$respFile = $resp['region_one_doc'];
						$region = $resp['region_one_status'];
						$coursename = $resp['course'];
						array_push($doc,$resp['region_one_doc']);
					}
				}
			}
			
			
			$current = date('d-m-Y');
			$fy = $this->getFinancialYears($current,1);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$studentOther = $this->common_model->getStudentOtherDetails($applicationId);
			$mission = $this->common_model->getMissionInfo($studentOther[0]['application_through']);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$regionInfo = $this->common_model->getRegionById($region);
			$uninmae = $this->common_model->getUniversityStateById($uniid);
			$this->load->file('fpdi/PdfHTMLTable.php');
			
			
			$pdf = new PdfHTMLTable();
			$pdf->AddPage('P');
			$pdf->SetXY(10.0,5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial','',7);
			$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
			$pdf->MultiCell(180,5,'Date: '.date('d M Y h:i:s'),'','R');
			
			$pdf->SetXY(10.0,45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations',false);		
			$pdf->SetFont('Arial','',10);	
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',35);
			$pdf->SetTextColor(221,221,255);
			$pdf->RotatedText(35,190,'Indian Council For Cultural Relations',45);
			$pdf->SetFont('Arial','',10);	
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(180,5,$mission[0]['mission_type'].': '.$mission[0]['mission_name'],'','L');
			
			$pdf->MultiCell(180,5,$mission[0]['country_name'],'','L');
			
			$pdf->MultiCell(180,5,'To     :	HoC / Education Wing / Culture Wing','','L');
			
			$pdf->MultiCell(180,5,'From :	Scholarship Division, ICCR, '.$regionInfo[0]['name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year 2022-2023. Mr./Ms. '.$stepOne[0]['fullname'].' is provisionally confirmed for '.$coursename.' course at '.$uninmae[0]['name'].', '.$regionInfo[0]['name'].' subject to production of all original documents at the time of joining','','J');
		$pdf->Ln(5);		
			$pdf->MultiCell(180,5,'Mission is requested to immediately take the following action:-','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'a)	Inform the candidate & convey his/her acceptance or rejection of the offer to ICCR at the earliest.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'b)	Obtain a written Undertaking from the student in the attached Proforma & email/fax it to ICCR. isd1section.iccr@nic.in / isd2section.iccr@nic.in / poafghan.iccr@nic.in','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'c)	Issue appropriate fulltime Student Visa (Research Visa in case of Ph.D.) to the student in accordance with the latest guidelines. The mission must issue the appropriate visa.','','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'d) 	Inform the scholars to report to Scholarship Division, Indian Council for Cultural Relations  (ICCR),'.$regionInfo[0]['name'].' or The Head, Department of '.$coursename.', '.$uninmae[0]['name'].', '.$regionInfo[0]['name'].' alongwith all original certificates and testimonials and academic transcript in English on prescribed date in the attached acceptance letter of the university, failing which admission will be cancelled.','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'e)	Please ensure that the student brings all his/her documents/Credentials/Mark Sheets in English language only.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'f)	Also inform him/her of the requirement to register with the local FRO/FRRO within 7/14 days of arrival in India or as per Indian Mission’s instruction on his/her passport.','','J');		
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'g)	Advice the scholar to carry with him/her some money to meet incidental expenses on arrival (a minimum of INR 35,000/- is recommended) also brief the scholar on living conditions in India and the Terms & Conditions of ICCR’s scholarship.  Including the fact that living in hostel accommodation is compulsory.','','J');	
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'h)	You may inform to the candidate he/she is entitled for scholarship dues upto declaration of result only.','','J');
			
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'i)	To carry all original documents with them.','','J');		
			$pdf->Ln(5);	
			$pdf->SetFont('Arial','B');	
			$pdf->MultiCell(170,5,'Note:	Please do not send us acceptances which exceed the number of slots allotted to your country under specific scheme.','','L');	
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Regards,','','L');	
			
			$pdf->MultiCell(170,5,'Scholarship Division','','R');
			
			$pdf->MultiCell(170,5,'ICCR,'.$regionInfo[0]['name'],'','R');
			
			$pdf->MultiCell(170,5,'File No. ('.$applicationId.')/'.$fy[1] ,'','L');
			
			$filename = $applicationId."_University_Response_".date('jS-F-Y-h-i-s').'.pdf';
			
			$filenamePath = FCPATH."assets/site/main/accept/".$filename;
			$pdf->Output($filename,"D");
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			
			redirect(site_url().'university/dashboard');
		}
		
	}
	
	function confirmationNotReceivedWithFormat()
	{
		try
		{
			$doc = array();
			$applicationId = $this->uri->segment(3);
			$uniid = $this->uri->segment(4);
			$response = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$region = 0;$coursename = "";$respFile="";$reason = "";
			if(count($response)>0)
			{
				foreach($response as $resp)
				{
					if($resp['university_is_accept'] == 2 && $resp['regional_university'] == $uniid)
					{
						$reason = $resp['reason'];
						$respFile = $resp['region_one_doc'];
						$region = $resp['region_one_status'];
						$coursename = $resp['course'];
						array_push($doc,$resp['region_one_doc']);
					}
				}
			}
			
			
			$current = date('d-m-Y');
			$fy = $this->getFinancialYears($current,1);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$studentOther = $this->common_model->getStudentOtherDetails($applicationId);
			$mission = $this->common_model->getMissionInfo($studentOther[0]['application_through']);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$regionInfo = $this->common_model->getRegionById($region);
			$uninmae = $this->common_model->getUniversityStateById($uniid);
			$this->load->file('fpdi/PdfHTMLTable.php');
			
			
			$pdf = new PdfHTMLTable();
			$pdf->AddPage('P');
			$pdf->SetXY(10.0,5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial','',7);
			$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
			$pdf->MultiCell(180,5,'Date: '.date('d M Y h:i:s'),'','R');
			
			$pdf->SetXY(10.0,45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations',false);		
			$pdf->SetFont('Arial','',10);	
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',35);
			$pdf->SetTextColor(221,221,255);
			$pdf->RotatedText(35,190,'Indian Council For Cultural Relations',45);
			$pdf->SetFont('Arial','',10);	
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(180,5,$mission[0]['mission_type'].': '.$mission[0]['mission_name'],'','L');
			
			$pdf->MultiCell(180,5,$mission[0]['country_name'],'','L');
			
			$pdf->MultiCell(180,5,'To     :	HoC / Education Wing / Culture Wing','','L');
			
			$pdf->MultiCell(180,5,'From :	Scholarship Division, ICCR, '.$regionInfo[0]['name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year '.$fy[1],'','J');
		$pdf->Ln(5);		
			$pdf->MultiCell(180,5,'The application of above applicant was forwarded to University. The University has declined the application for admission. It may please be noted that the decision of the University is final and no further correspondence on this will be entertained by ICCR / Mission.  In case the applicant has applied for admission in some other university/ institute, the response if not yet conveyed, will be uploaded as and when it is received by ICCR','','J');
			$pdf->Ln(5);
			
			
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'The applicant may please be informed suitably.','J');		
			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B');	
			$pdf->MultiCell(180,5,'University Remarks:','J');		
			$pdf->SetFont('Arial','',10);
			$pdf->MultiCell(180,5,$reason,'J');		
			
			
			$pdf->Ln(5);	
			$pdf->SetFont('Arial','B');	
			$pdf->MultiCell(170,5,'Thanking you,','','L');	
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Scholarship Division','','R');
			
			$pdf->MultiCell(170,5,'ICCR,'.$regionInfo[0]['name'],'','R');
			
			$pdf->MultiCell(170,5,'File No. ('.$applicationId.')/'.$fy[1] ,'','L');
			
			$filename = $applicationId."_University_Response_".date('jS-F-Y-h-i-s').'.pdf';
			
			$filenamePath = FCPATH."assets/site/main/accept/".$filename;
			$pdf->Output($filename,"D");
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			
			redirect(site_url().'mission/dashboard');
		}
		
	}
		function undertakingFromStudent()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			//echo $applicationId;die;
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			//echo $userId;die;
			//$applicationId = $this->common_model->getApplicationAppnoByUserId($userId);	
			//echo "<pre>";print_r($applicationId);die;
			//$applicationId =  $applicationId[0]['application_no'];
			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$country = $this->common_model->getCountryById($stepOne[0]['nationality']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			
			$response = $this->common_model->getconfirmationDataByMission($applicationId);
			//echo "<pre>";print_r($response);die;
			if(count($response) >1){
				$uni1 = $this->common_model->getUniversityById($response[1]['regional_university']);
				$course = $response[1]['final_course'];
			}
			else
			{
				$uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
				$course = $response[0]['final_course'];
				
			}
			//echo "<pre>";print_r($schemeId);die;
			$applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$userd = $this->common_model->getUserInfo($applicaitonStepThree[0]['uid']); 
			$applicantAcceptanceDate = $schemeId[0]['undertaking_doc'];
			$date1 = $applicaitonSubmitData[0]['created'];						
			$acDate =  date('d-m-Y',$applicantAcceptanceDate);
			$getDir = $this->common_model->getDirUserInfo($userd->id);
			/* if($getDir->dir == ''){
				$imgPath = site_url().'assets/site/main/profile_signature/'.$applicaitonStepThree[0]['signature_doc'];
			}else{
				$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			} */
			$imgs = file_get_contents($userd->dir .'/'.$applicaitonStepThree[0]['signature_doc']);
			$data = base64_encode($imgs);
			$f = finfo_open();
			$imgdata = base64_decode($data);
            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
			$img_base64_encoded = 'data:'.$mime_type.';base64,'.$data.'';
			$imageContent = file_get_contents($img_base64_encoded);
			$imgPath = tempnam(sys_get_temp_dir(), 'prefix');
			file_put_contents ($imgPath, $imageContent);
			$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			$new='<img src="'.$imgPath.'" style="width:100px;">';

			$image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$logo = '<img src="' . $image . '" style="width:auto;">';
			$course = $response[0]['final_course'];
			//echo $course;die;
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			ob_start();
        ?>
        <html>
    <style>
        .sign_align {
            text-align: right;
        }
		body {
			font-family: Arial;
		}
		@media print {
			@page {
				margin-top: 0;
				margin-bottom: 0;
			}
			body {
				padding-top: 72px;
				padding-bottom: 72px ;
			}
		}
    </style>

    <body>
		<div class="pdf_div" style="font-size: 14px;">
        <p style="text-align: right;"><small>Ref. No. <?php echo $applicationId; ?> <br/>Date: <?php echo $acDate; ?> </small></p>
		<div style="text-align: center;"><?php echo $logo;?></div>
        <h3 style="text-align: center;">Indian Council For Cultural Relations (ICCR)</h3>
		<h2 style="color: #d8d5d5;opacity: 0.3;font-family: arial;font-size: 40px;margin: 0;transform(rotate(45deg));transform-origin(0 0);transform: rotate(328deg);position: relative;top: 300px;text-align: center;">Indian Council For Cultural Relations</h2>

        <p><b>ACCEPTANCE TO OFFER OF ADMISSION WITH ICCR SCHOLARSHIP</b></p>
		<br>
		<p>Acceptance of <?php echo $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname'] . ' to offer of admission at  ' . $uni1[0]['name'] . ' to pursue course  ' . $course;?> 
    	<p style="text-align: justify;">1)  I Mr./Ms./Mrs. <?php echo $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname'] . ' do hereby affirm that I have read the Terms and Conditions including Financial Terms of ICCR’s scholarship with due diligence and agree to abide by them.'; ?></p>
        <p style="text-align: justify;">2)  I also confirm that the course <?php echo $course . ' offered to me in ' . $uni1[0]['name'] . ' is accepted to me and that I will not ask for a change in course or university.'; ?></p>
        <p style="text-align: justify;">3)  I will complete the entire course of study in which I have been admitted.</p>
        <p style="text-align: justify;">4)  I will purchase medical insurance of minimum sum assured of INR (Rs.) 5 lakhs / equivalent to approximate US$ 6700 per year. I understand that it is compulsory for continuation of ICCR Scholarship.</p>
        <p style="text-align: justify;">5)  I certify that I do not suffer from terminal illness or ailments affecting vital organs. I also certify that I am not in family way. In case of illness require long absence of my course of study, I undertake to return to my country.</p>
        <p style="text-align: justify;">6)  I agree to deliberately study in India.  In case I fail to get promoted to next level of course / fail, I understand that ICCR will stop scholarship. If such situation arises, I undertake that I will clear the level of study in which I have failed with my own financial resources and once I clear the level, I will request for revival of scholarship.</p>
        <p style="text-align: justify;">7)  I agree to abide by and respect the law of India.  In case if I get involved in illegal activities and /or events concerning law and order issues, I understand that I will be prosecuted as per the law of India and I also agree on being deported to my country.</p>
		<p style="text-align: justify;">8)  I understand that ICCR has right to change its Scholarship Policy (ies) including financial terms of scholarship from time to time.  I agree to abide by them.  If I disagree to follow the revised terms and conditions, ICCR will have right to discontinue my scholarship.</p>	
	</br>

		<p style="text-align: left;"><?php echo $new;?></p>

		<p style="text-align: left;">Name: <?php echo $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname']; ?></p>
		<p style="text-align: left;">Country: <?php echo $country[0]['country_name'];?> </p>
		<p style="text-align: left;">Date: <?php echo $acDate;?> </p>
		<p style="text-align: left;">Passport No: <?php echo $stepOne[0]['passport_no']; ?></p>
		
	</div>
    </body>
</html>     
<?php	



      $html = ob_get_clean();		
			$this->load->library('GenPdf');
			
			$dompdf = new GenPdf();
			//$canvas = $dompdf->get_canvas();
			$dompdf->set_option('isHtml5ParserEnabled', true);
			$dompdf->set_option('isRemoteEnabled', true);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream("welcome.pdf", array("Attachment"=>0));

			//$pdf->debug = true;
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');

			redirect(site_url() . 'mission/dashboard');
		}
		
	}
	function pending_process()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);die;
			$missionId = $user_data['user_country'];
			$universityId = $user_data['university'];
			//$regionId = $user_data['state'];
			//echo $universityId;die;
			$data['univercities'] = $this->common_model->getUnivercities();	
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			$applicationId = $this->uri->segment(3);
			$data['regionId'] = $user_data['state'];
			$data['applicaitonStepOne']= $this->common_model->getApplicationStepOneByAppno($applicationId);
			$data['applicaitonStepTwo']= $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree']= $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments']= $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['getCheckList'] = $this->common_model->getPendingCheckList($applicationId);
			$this->load->view('university/header_mission');
			$this->load->view('university/checklist',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function process()
	{
		try{
			//echo "";die;
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);die;
			$missionId = $user_data['user_country'];
			$regionid = $user_data['state'];
			$univesrsityid = $user_data['university'];
			$data['regionId'] = $regionid;
			$data['univesrsityId'] = $univesrsityid;
			$applicationId = $this->uri->segment(3); 
			$isApproved = $this->common_model->alreadyApprovedUniversity($applicationId);			
		if(count($isApproved)>= 0)
		{
			$user_data = $this->session->userdata('user_data');	
			$userId = $this->common_model->getUserIdbyApplicationNo($applicationId);		
			$imgArray = $this->common_model->getUserImage($userId[0]['uid']);
			if(count($imgArray)> 0)
			{
				$data['userImage'] = $imgArray[0]['name'];
			}		
			else
			{
				$data['userImage'] = '';
			}
			//$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getAllUnivercities();		
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}
			$regionid = $user_data['state'];
			$data['regionId'] = $regionid;
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);			
			$this->load->view('university/header_mission');
			$this->load->view('university/checklist',$data);
			$this->load->view('university/footer');
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Application Already Approved!');
			redirect(site_url().'university/checklist');		
		}
		
			//$data['univercities'] = $this->common_model->getAllUnivercities();
			//$data['applicaitonStepOne']= $this->common_model->getApplicationStepOneByAppno($applicationId);
			//$data['applicaitonStepTwo']= $this->common_model->getApplicationStepTwoByAppno($applicationId);
			//$data['applicaitonStepThree']= $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			//$data['applicaitonDocuments']= $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			//$this->load->view('university/header_mission');
			//$this->load->view('university/checklist',$data);
			//$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'university/dashboard');
		}
	}	
	
	public function getCourseDetail()
	{
		$postData = $this->input->post(NULL,TRUE);
		$cleanData = $this->security->xss_clean($postData);	
		//echo "<pre>";print_r($cleanData);die;
		echo json_encode($this->common_model->getCourseDetails($cleanData['appid'],$cleanData['uniid']));
	}
	public function undertakingacceptancce()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$data['appno'] = $applicationId;
			$data['undertaking'] = $this->common_model->getUndertaking($applicationId);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/undertakingacceptancce',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function UploadUnderTaking()
	{
		try
		{
			$imgname ="";
			$files = $_FILES['undertaking'];      		
			$applicationId = $this->uri->segment(3);
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = time().'_undertakings_'.$name;			  
			  $target_file = 'assets/site/main/undertakings/'.$imgname; 	
			  if (move_uploaded_file($_FILES["undertaking"]["tmp_name"], $target_file)) { 	
			  		$data = array(
			  			'scholar_acceptance'=>$this->input->post('scholar_is_accept'),
			  			'undertaking_doc' =>$imgname,
			  			'status'=>11,
						'universities_status'=>23
			  		 );
			  		$sts = $this->common_model->uploadUndertaking($applicationId,$data);
			  	  if($sts)
			  	  {
			  	  	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Undertaking Uploaded Successfully!');
					redirect(site_url().'university/confirmaitonreceivesformhqrs');				  	  	
				  }			  
			  }
			  else{
			  		$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
					redirect(site_url().'university/undertakingacceptancce/'.$applicationId);	
			  }
			}
		}
		catch(Exception $e)
		{
		  	echo json_encode(array('status'=>FALSE));
		}
	}
	public function downloadList()
	{
		try
	    {
	    	$appno = $this->uri->segment(3);
	    	$content = $this->input->post("myHTML");
			$mpdf = new Mpdf('s','A4','','',7,7,05,10,10,10);			
			$mpdf->SetFont('Arial','B',12);
			$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
			$mpdf->watermark_font = 'DejaVuSansCondensed';
			$mpdf->showWatermarkText = true;
			$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Application Form For Scholarship through ICCR</h3><br/>";       	 				
	    	$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>".date("jS F Y h:i:s")."</div>";
$html = $content;
 			$imgArray = $this->common_model->getUserImage($data[0]['uid']);		  
			 
			$mpdf->SetDisplayMode('fullpage');			 
			// LOAD a stylesheet
			$stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css'); 
			
			$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
			$mpdf->WriteHTML($stylesheet1,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css'); 
			$mpdf->WriteHTML($stylesheet2,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
			$mpdf->WriteHTML($stylesheet3,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
			$mpdf->WriteHTML($stylesheet4,1); // The parameter 1 tells that this is css/style only and no body/html/text
			
			$stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
			$mpdf->WriteHTML($stylesheet5,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($html1,2);
			$mpdf->WriteHTML($content);	
			$mpdf->Output();
	    }
	    catch(HTML2PDF_exception $e) {
   			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Downloading!');
			redirect(site_url().'mission/dashboard/');	
	        exit;
	    }
	}
	public function downloadAlumniApplication()
	{
		try
	    {
	    	$appno = $this->uri->segment(3);
	    	$content = $this->input->post("myHTML");
			$mpdf = new Mpdf('s','A4','','',7,7,05,10,10,10);			
			$mpdf->SetFont('Arial','B',8);
			$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
			$mpdf->watermark_font = 'DejaVuSansCondensed';
			$mpdf->showWatermarkText = true;
			$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Alumni Details For Scholarship through ICCR</h3><br/>";       	 				
	    	$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>Ref. No.".$appno.'<br/>'.date("jS F Y h:i:s")."</div>";
$html = $content;
 			$imgArray = $this->common_model->getUserImage($data[0]['uid']);		  
			 
			$mpdf->SetDisplayMode('fullpage');			 
			// LOAD a stylesheet
			$stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css'); 
			
			$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
			$mpdf->WriteHTML($stylesheet1,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css'); 
			$mpdf->WriteHTML($stylesheet2,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
			$mpdf->WriteHTML($stylesheet3,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
			$mpdf->WriteHTML($stylesheet4,1); // The parameter 1 tells that this is css/style only and no body/html/text
			
			$stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
			$mpdf->WriteHTML($stylesheet5,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($html1,2);
			$mpdf->WriteHTML($content);	
			$mpdf->Output();
	    }
	    catch(HTML2PDF_exception $e) {
	       	$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Downloading!');
			redirect(site_url().'mission/dashboard');	
	        exit;
	    }
	}
	public function downloadApplication()
	{
		try {
            $appno = $this->uri->segment(3);

            $content = $this->input->post("myHTML");
            $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
            $mpdf->SetFont('Arial', 'B', 9);
            $mpdf->SetWatermarkText('Indian Council For Cultural Relations');
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Application Form For Scholarship through ICCR</h3><br/>";
            $html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>Ref. No." . $appno . '<br/>' . date("jS F Y h:i:s") . "</div>";
            $html = $content;
            $imgArray = $this->common_model->getUserImage($data[0]['uid']);

            $mpdf->SetDisplayMode('fullpage');
            // LOAD a stylesheet
            $stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css');

            $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
            $mpdf->WriteHTML($stylesheet1, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css');
            $mpdf->WriteHTML($stylesheet2, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
            $mpdf->WriteHTML($stylesheet3, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
            $mpdf->WriteHTML($stylesheet4, 1); // The parameter 1 tells that this is css/style only and no body/html/text

            $stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
            $mpdf->WriteHTML($stylesheet5, 1); // The parameter 1 tells that this is css/style only and no body/html/text
            $mpdf->WriteHTML($html1, 2);
            $mpdf->WriteHTML($content);
            $mpdf->Output();
        }
	    catch(HTML2PDF_exception $e) {
	        $this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Downloading!');
			redirect(site_url().'university/dashboard');	
	        exit;
	    }
	}
    public function application()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);	
			
			$this->load->view('mission/header_mission');
			$this->load->view('mission/applications',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured! Try After Some Time');
			redirect(site_url().'mission/dashboard');	
		}
	}
	public function download()
	{
		try{
			header("Content-type: application/pdf");
	    	$mpdf = new Mpdf('c','A4','','',10,10,05,10,10,10);
	    	
	    	$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div>";       	 				
	    	$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>".date("jS F Y h:i:s")."</div>";
			$html2 = $this->input->post("myHTML");
			//echo $html2;
			//die;
			$appid = $this->input->post("approvedappId");
			$mpdf->SetFontSize(10,TRUE);
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
			$mpdf->watermark_font = 'DejaVuSansCondensed';
			$mpdf->showWatermarkText = true;
			$mpdf->debug = true;
			$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
			// LOAD a stylesheet
			$stylesheetpath = base_url()."assets/site/main/css/tablepdf.css";
			$stylesheet = file_get_contents($stylesheetpath);
			$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->SetFontSize(7,TRUE);
			$mpdf->WriteHTML($html1,2);
			$mpdf->SetFontSize(8,TRUE);
			$mpdf->WriteHTML($html2,2);
			$filename = FCPATH.'assets/site/downloads/'.$appid.'_'.date('d_m_Y_h_i_s').'.pdf';			
			$pdfString = $mpdf->Output($filename,'F');
			if (file_exists($filename)) {
			   header('Content-type: application/force-download');
			   header('Content-Disposition: attachment; filename='.$filename);
			   readfile($filename);
			}
			exit();				
		} 
		catch (Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured! Try After Some Time');
			redirect(site_url().'mission/dashboard');	
		}			
	}


	function downloadcsv(){
		
		$file_name = 'student_details_on_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$file_name"); 
		header("Content-Type: application/csv;");
	  
		// get data 
				$year = $this->uri->segment(3);
		   $res = array(
			   'iccr_status' => 1,
			   'status' => 10
		   );      
		   $vars = $this->input->post();
		   $counter = $_POST['start'];
		   $result = $this->hqrs_model->getUniversityResponseSentByHqrsToMission($year,$vars,$res);
		   $totalResult = $this->hqrs_model->getTotalUniversityResponseSentByHqrsToMission($year,$vars,$res);
   
		// file creation 
		$file = fopen('php://output', 'w');
	
		$header = array("Sr.No.","Applicant No","Applicant Name","Email Id","Country","Programme","Course","University","Date of Submission"); 
		fputcsv($file, $header);
		  $cnt=1;
		   if(!empty($result))
		   {
			   foreach($result as $r)
			   {
				   $output= array();
				   $applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				   $applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($r['application_no']);
				   $country = $this->common_model->getCountryById($r['nationality']);
				   $missions = $this->common_model->getAllMissions();
				   $missionname="";
				   foreach($missions as $mission)
									  {
										  
										   if($applicaitonStepThree[0]['application_through'] == $mission['id'])
										   {
											   $missionname = $mission['mission_name'];
										   }										
										   
									  }
				   $sch = $this->common_model->getSchemeById($r['scholarship_id']);
								   $scheme = $sch[0]['scheme_name'];
				   $confirmData = $this->common_model->getFinalUniversityById($r['regional_university']);	
   $region = $this->common_model->getRegionById($r['region_one_status']);
			   $date2 = $r['SubmitDate'];	
	 
				$narray=array($cnt,$r['application_no'],$r['fullname'].' '.$r['middlename'].' '.$r['familyname'],
				$r['email'],$r['country_name'],$missionname,$scheme,$confirmData,$r['confirmed_course'],$region[0]['name'],
				date('d-m-Y',$date2)
				);	 
				$cnt++;
			   fputcsv($file, $narray); 		
			   }
				   
		   }
		
		
		fclose($file); 
		exit; 
   
	   }


	public function viewProcessedApplication()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$regionid = $user_data['state'];
			$data['regionId'] = $regionid;
			$data['applicaitonStepOne'] = $this->common_model->getUniversityApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}	
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
			if(count($imgArray)> 0)
			{
				$image = $imgArray[0]['name'];
			}		
			else
			{
				$image = '';
			}
			$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			$data['userImage'] = $image;
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['schemeId'] = $this->common_model->getApplicationSchemeId($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			//print_r($data['applicaitonStepOne']);die;
			$this->load->view('university/header_mission');
			$this->load->view('university/universityResponse',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured! Try After Some Time');
			redirect(site_url().'university/dashboard');	
		}		
	}
	
	

	public function applicaitonProcess()
	{ //print_r($this->input->post());die;
		try{
			
			$currentyear = date('Y');
			$user_data = $this->session->userdata('user_data');
			$universityId= $user_data['university'];
			$referenceNumber = "";
			$appno = $_POST['applicaiton_number'];
			$user_data = $this->session->userdata('user_data');				
			$regionid = $user_data['state'];
			$roDetails = $this->common_model->getRegionById($user_data['state']);
			$data['regionId'] = $regionid;
			$confirmvalue = $this->input->post("university_is_accept");
			$imgname = "";		
			$imgnameUn = "";		

			
			if(!empty($_FILES))
			{	
				$files = $_FILES['signature']; 			
				if($files["name"] != "")
				{				
				  $name = str_replace(" ","_",$files['name']);
				  $imgname = time().'_university_signature_'.$name;
				  
				  $target_file = './'.$currentyear.'/university_signature/'.$imgname; 
				  move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file);
			    }
					
			}
			
				if(!empty($_FILES))
			{	
				    $filesUn = $_FILES['inputfile_regional']; 
				
					$typpe = $_FILES['inputfile_regional']['type'];
					$fnmae = $_FILES['inputfile_regional']['name'];//print_r($_FILES['inputfile_regional']['error']);die;
					$tempfile = $_FILES['inputfile_regional']['tmp_name'];
					$sizekbb = filesize($tempfile); //10485760= 10mb
					$head = fgets(fopen($tempfile, "r"), 5);
					$section = strtoupper(base64_encode(file_get_contents($tempfile)));
					$nsection = substr($section, 0, 8);
					$frst = strpos($fnmae, ".");
					$sec = strrpos($fnmae, ".");
					$handle = fopen($tempfile, "rb");
					$fsize = filesize($tempfile);
					$contents = fread($handle, $fsize);
					//echo $sizekbb;
					
					if($typpe != "application/pdf" && $typpe != "image/jpeg" && $typpe != "image/png")
				{
					//$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					//$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 1MB!'));
					return;
				}
				//echo $filesUn;die;
				if($filesUn["name"] != "")
				{				
				  $nameUn = str_replace(" ","_",$filesUn['name']);
				  $imgnameUn = time().'_university_approval_'.$appno.'_'.$nameUn;
				  $target_file = './'.$currentyear.'/university_approval/'.$imgnameUn; 
				  move_uploaded_file($_FILES["inputfile_regional"]["tmp_name"], $target_file);
			    }	
			}
			// if($confirmvalue == 1){
			// if(!empty($_FILES))
			// {	
			// 	    $filesUn = $_FILES['fee_structure']; 
			// 		$typpe = $_FILES['fee_structure']['type'];
			// 		$fnmae = $_FILES['fee_structure']['name'];
			// 		$tempfile = $_FILES['fee_structure']['tmp_name'];
			// 		$sizekbb = filesize($tempfile); //10485760= 10mb
			// 		$head = fgets(fopen($tempfile, "r"), 5);
			// 		$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			// 		$nsection = substr($section, 0, 8);
			// 		$frst = strpos($fnmae, ".");
			// 		$sec = strrpos($fnmae, ".");
			// 		$handle = fopen($tempfile, "rb");
			// 		$fsize = filesize($tempfile);
			// 		$contents = fread($handle, $fsize);
			// 		//echo $typpe;die;
			// 		if($typpe != "application/pdf" && $typpe != "image/jpeg" && $typpe != "image/png")
			// 	{
			// 		//$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
			// 		echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed'));
			// 		return;
			// 	}
				
			// 	if ($sizekbb > 2097152) 
			// 	{
			// 		//$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
			// 		echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 1MB!'));
			// 		return;
			// 	}
				
			// 	//echo $filesUn;die;
			// 	if($filesUn["name"] != "")
			// 	{				
			// 	  $nameFeeUn = str_replace(" ","_",$filesUn['name']);
			// 	  $imgnameFeeUn = time().'_university_fee_structure_'.$appno.'_'.$nameFeeUn;
			// 	  $target_file = '../../'.$currentyear.'/university_fee_structure/'.$imgnameFeeUn; 
			// 	  move_uploaded_file($_FILES["fee_structure"]["tmp_name"], $target_file);
			//     }	
			// }
			// }
			$checklist = ""; $notSelected = array();$messages_for_mail = "";
			if($checklist !="")
			{
				$checklist = substr($checklist,0,(strlen($checklist)-1));	
			}
			
			$data['non_xss']= array(
				'application_number' => $this->input->post('appid'),
				'type' => $this->input->post('type'),
				'schloarship_name'=>$this->input->post('schloarship_name'),
				'marks'=>$this->input->post('marks'),
				'university_name'=>$this->input->post('university_name'),
				'university_desg'=>$this->input->post('university_desg'),
				'university_place'=>$this->input->post('university_place'),
				'testmarks'=>$this->input->post('testmarks'),
				'university_date'=>$this->input->post('university_date'),
				'university_cheklist_avail'=>$this->input->post('university_cheklist_avail'),				
			);
			$data['xss_data'] = $this->security->xss_clean($data['non_xss']);
			if(count($notSelected) > 0)
			{
				$data['xss_data']['checklist_ids'] =  $checklist;
			}  			
			$data['xss_data']['signature'] =  $imgname;
			
			$applicationData = $this->common_model->getApplicationData($data['xss_data']['application_number'],0);
			$userdata = $this->common_model->getUserData($applicationData[0]['uid']);
			$last = $this->common_model->getLastReference();			
			switch($data['xss_data']['type'])
			{				
				case "Submit Application":	
					if(count($notSelected) > 0)
					{		
						/* if(in_array("9",$notSelected))	
						{
							/* $this->common_model->updateApplicationStatusPending($this->input->post('appid'),$applicationData[0]['uid']);
							$update['status'] = 5;
							$update['universities_status'] = 18;
							$update['university_status_date'] = $data['xss_data']['university_date'];
							$update['university_person_name'] = $data['xss_data']['university_name'];		
							$update['university_person_designation'] = $data['xss_data']['university_desg'];		
							$update['university_person_place'] = $data['xss_data']['university_place'];		
							$update['university_person_signature'] = $imgname;							
							$update['university_english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
							$update['university_cheklist_avail'] = $data['xss_data']['university_cheklist_avail'];	
							$status = $this->common_model->updateMissionStatus($update,$userId,$data['xss_data']['application_number']);
							//$body = "We regret to inform you that you have not met the criteria of selection for award of scholarship.<br/><br/>";
							//$mailsend = $this->sendMail($body,$userdata[0]['email_id'],"Your Application could not processed by ICCR.","mail_not_process");
							
							if($status)
							{
								
								if($status)
								echo json_encode(array('status'=>TRUE,'ref'=>"","message"=>"Rejected","Mail"=>"Sent"));
								else
								echo json_encode(array('status'=>TRUE,'ref'=>"","message"=>"Rejected","Mail"=>"NotSent"));
							}	
							else
								echo json_encode(array('status'=>FALSE,"message"=>"Rejected"));	
							
						} 	
						else
						{
							*/
							$this->common_model->updateApplicationStatusPending($this->input->post('appid'),$applicationData[0]['uid']);
							$update['status'] = 2;
							$update['universities_status'] = 21;
							$update['university_person_name'] = $data['xss_data']['university_name'];		
							$update['university_status_date'] = $data['xss_data']['university_date'];
							$update['university_person_designation'] = $data['xss_data']['university_desg'];		
							$update['university_person_place'] = $data['xss_data']['university_place'];		
							$update['university_person_signature'] = $imgname;			
							$update['university_english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
							$update['university_cheklist_avail'] = $data['xss_data']['university_cheklist_avail'];
							$update['university_checklist_ids'] = $data['xss_data']['checklist_ids'];									
							$status = $this->common_model->updateMissionStatus($update,$userId,$data['xss_data']['application_number']);
							$body = "Your application for scholarship could not be processed for the following reasons.<br/><br/>";
							$body .= $messages_for_mail;	
							$body .= "<br/><br/>You are being given opportunity to resubmit your applicatin with the mission documents before ".$this->config->item('Mission_Applicant_Pending_Date');					
							$mailsend = $this->sendMail($body,$userdata[0]['email_id'],"Your Application could not processed by ICCR.","mail_not_process");
							if($status)
							{
									if($mailsend)
									echo json_encode(array('status'=>TRUE,'ref'=>"","message"=>"PENDING","Mail"=>"Sent"));
									else
									echo json_encode(array('status'=>TRUE,'ref'=>"","message"=>"PENDING","Mail"=>"NotSent"));
							}
							else
								echo json_encode(array('status'=>FALSE,"message"=>"PENDING"));	
						//}	
					}
					else
					{
						$no = 0;
						$no = (int)$last[0]->appid + 1;
						$rand = $this->random_num(3);
						//$referenceNumber = $applicationData[0]['country']."-" .date('Y')."-".$data['xss_data']['schloarship_name']."-".$rand."-".$no; 
						//$update['ref_no'] = $referenceNumber;						
						$update['status'] = 10;
						$update['universities_status'] = 1;
						
						/* $update['university_status_date'] = $data['xss_data']['university_date'];
						$update['university_person_name'] = $data['xss_data']['university_name'];		
						$update['university_person_designation'] = $data['xss_data']['university_desg'];		
						$update['university_person_place'] = $data['xss_data']['university_place'];		
						$update['university_person_signature'] = $imgname;	
						//$update['scholarship_id'] = $data['xss_data']['schloarship_name']; */
						
						$update['university_english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
						$update['university_checklist_ids'] = $data['xss_data']['checklist_ids'];	
						$status = $this->common_model->updateMissionStatus($update,$userId,$data['xss_data']['application_number']);
						
						$confirmvalue = $this->input->post("university_is_accept");
						//var_dump($status);die;
						$data1 = array(
						'region_one_status'=>$regionid,
						'region_one_status_date'=>time(),
						'status'=>9,
						'region_one_doc'=>$imgnameUn,
						// 'fee_structure'=>$imgnameFeeUn,
						'regional_university'=> $this->input->post("regional_university"),
						'university_is_accept'=> $this->input->post("university_is_accept"),
						'application_id'=> $this->input->post("applicaiton_number"),
						'course'=>$this->input->post("course"),
						'lable_of_course'=>$this->input->post("lable_of_course"),
						//'sub_stream'=>$this->input->post("sub_stream"),
						//'subject'=>$this->input->post("subject"),
						'nomenclature'=>$this->input->post("nomenclature"),
						'duration_of_course'=>$this->input->post("duration_of_course"),
						'date_of_joining'=>$this->input->post("date_of_joining"),
						// 'confirmed_course'=>$this->input->post("confirmedCourse"),
						'reject_reason'=>$this->input->post("reject_reason"),
						);
						$value = 6;
						if($this->input->post("university_is_accept") == 2)
						{
							$value = 7;
						}
						//$UniversityMapdata = array(
							//'status'=>$value,
							//);
						
							$updateUnData['university_status_date'] = $data['xss_data']['university_date'];
							$updateUnData['university_person_name'] = $data['xss_data']['university_name'];		
							$updateUnData['university_person_designation'] = $data['xss_data']['university_desg'];		
							$updateUnData['university_person_place'] = $data['xss_data']['university_place'];		
							$updateUnData['university_person_signature'] = $imgname;	
							$updateUnData['status'] = $value;
							
							
						$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($appno);
						$applicaitonStepThree= $this->common_model->getApplicationStepThreeByAppno($appno);
						$uninmae = $this->common_model->getUniversityStateById($data1['regional_university']);
						$missionName = $this->common_model->getMissionById($applicaitonStepThree[0]['application_through']);
				       
						$universityEmail = $user_data['email'];
						$roEmail = $roDetails[0]['email'];
						$missionEmail = $missionName[0]['mission_email'];
						$hqrs = $this->config->item('hqrs_email');
						$recipients = array($universityEmail,$roEmail,$missionEmail,$hqrs);		
						$messages = '';                
						$messages .= '<strong>Hi '.$applicaitonStepOne[0]['fullname'].',</strong><br><br>';
						$messages .= "Mr./Ms./Mrs. ".$applicaitonStepOne[0]['fullname'] .", Your application in Course ".$data1['regional_university']." has been provisionally confirmed at ".$uninmae[0]['name']."";			
						$body .= $messages;	
						//$mailsend = $this->sendMail($body,implode(',',$recipients),"Indian Council for Cultural Relations.","mail_not_process");
						$sts = $this->common_model->ForwardToHqrs($data1,$appno);
						
						if($sts && $confirmvalue == 1){
							$this->common_model->UpdateToFinalConfirmationToHqrs($updateUnData,$appno,$universityId);
							echo json_encode(array('status'=>TRUE,"message"=>"Approved"));
							}
						if($sts && $confirmvalue == 2){
							$this->common_model->UpdateToFinalConfirmationToHqrs($updateUnData,$appno,$universityId);
							echo json_encode(array('status'=>TRUE,"message"=>"Rejected"));
						}
					}
				break;
			}
		}
		catch(Exception $e)
		{  
			echo json_encode(array('status'=>FALSE,"message"=>"Error"));
		}
	}
	public function getApplicantCheckList($appid)
	{
		$fulllist = array();
		$applicant_checklist = array("1","2","5","6","9");
		$mission_checklist = array("3","4","8","10");
		$applicant_check = array();$mission_check = array();
		$applicant = $this->common_model->getApplicationStepOneByAppno($applicationId);
		for($i=1; $i<=11;$i++)
		{
			if($i!= 7)
			{
				if($i == 4)
				{
					if($applicant[0]['course'] == 12)
					{
						array_push($mission_check,$i);
						array_push($fulllist,$i);
					}
				}
				elseif($i == 5)
				{
					if($applicant[0]['programee'] == 5 || $applicant[0]['programee'] == 6)
					{
						array_push($applicant_check,$i);
						array_push($fulllist,$i);
					}
				}
				elseif($i == 6)
				{
					if($applicaitonStepOne[0]['programee'] == 3 || $applicaitonStepOne[0]['programee'] == 4)
					{
						array_push($applicant_check,$i);
						array_push($fulllist,$i);
					}	
				}
				else
				{
					if(in_array($i,$applicant_checklist))
					{
						array_push($applicant_check,$i);
						array_push($fulllist,$i);
					}
					if(in_array($i,$mission_checklist))
					{
						array_push($mission_check,$i);
						array_push($fulllist,$i);
					}
				}
			}
		}
		return array('mission'=>$mission_check,'applicant'=>$applicant_check,'fulllist'=>$fulllist);
	}
	public function resubmitapplication()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$universityId = $user_data['university'];
			//echo $universityId;die;
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			$data['resubmitapplication']= $this->university_model->resubmitapplication($universityId);
			$this->load->view('university/header_mission');
			$this->load->view('university/resubmitapplication',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured! Try After Some Time');
			redirect(site_url().'university/dashboard');
		}
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
	        'min_length' => 5,
	        'max_length' => 5,
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
	            $font_path . 'times_new_yorker.ttf'
	        ),
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
	    return array(
	        'code' => $captcha_config['code'],
	        'image_src' => $image_src
	    );
	}
	public function getCaptcha()
	{	
		
		$captcha_cnf = array();		
		$cnf = $this->session->userdata('captcha');			
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
   public function base64url_encode($data)
   {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
   }
   public function base64url_decode($data)
   {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
   }
   public function sendMail($message_body,$email,$subject,$view)
   {
	   //echo "----";die;
	   //echo "<pre>";print_r($message_body);print_r($email);print_r($subject);print_r($view);die;
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

		     $content = $this->load->view($view,$data, true);
//print_r($content);die;
		     $from_email = "diritc.iccr@gov.in"; 
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
   
   
   	//edit Engish Marks
	
	function editApplication()
    {
		
		//echo '<pre>';
		//print_r($_POST);die;
		//echo $appid;die;
		$appId = $_POST['id'];
		$applicanteDetails = $this->mission_model->getApplicantDetails($appId);
		$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicanteDetails[0]['application_no']);			  
			?>
			
			<table class="table table-bordered">
    <thead>
		
        <th>Name</th>
		<th>Application No</th>
		<th>Email</th>
		<th>Level of Programme</th>
		<th>University</th>
    </thead>
    <tbody>
	<?php
	if(count($applicaitonStepOne)>0)
				{
					foreach($applicaitonStepOne as $app)
					{
						?>
      <tr>
	  <td><?php echo $app['fullname'];?></td>
	  <td><?php echo $app['application_no'];?></td>
	    <td><?php echo $app['email'];?></td>
		 <td><?php
            $programme = $this->common_model->getAllProgramme();
                                        foreach ($programme as $program) {
                                            if (!empty($applicaitonStepOne)) {
                                                if ($applicaitonStepOne[0]['programme'] == $program['id']) {
                                                    echo $program['name'];
                                                }
                                            }
                                        }
                                        ?></td>
			
					<td>
							<?php
							$uni1 = $this->common_model->getUniversityById($app['universty_choice']);
							$uni2 = $this->common_model->getUniversityById($app['universty_choice_two']);
							$uni3 = $this->common_model->getUniversityById($app['universty_choice_three']);
							echo '1) '.$uni1[0]['name'].'<br/>';
							echo '2) '.$uni2[0]['name'].'<br/>';
							echo '3) '.$uni3[0]['name'].'<br/>';
							?>
						</td>			
						
	  </tr>
	  <?php
					}
				}
				?>
    </tbody>
  </table>
  <?php
			
			  $htm  ="<form action='".site_url().'mission/saveApplicantData/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			  $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$applicanteDetails[0]['id']."'>";
			  $htm .="<div class='form-row'>";
			  $htm .="<div class='form-group'>";
			  $htm .="<label>Enter English Proficiency Test Marks:</label>";
			  $htm .="<select class='form-control' id ='testmarks' name='testmarks'>";
	          $htm .="<option value=''>English Marks</option>";
			  if($applicanteDetails[0]['english_proficiency_test_marks'] == '1'){
				  $htm .="<option value='1' selected>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10'>10</option>";
			  }
			    elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '2'){
				  $htm .="<option value='1'>1</option>";
				  $htm .="<option value='2' selected>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10'>10</option>";
				  
			  }
			 
			    elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '3'){
				 				  $htm .="<option value='1' selected>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3' selected>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10'>10</option>";
				  
			  }
			
			    elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '4'){
				
				  				  $htm .="<option value='1' selected>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4' selected>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10'>10</option>";
				  
			  }
			    elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '5'){
					
				 $htm .="<option value='1' selected>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5' selected>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10'>10</option>";
				} 
				 elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '6'){
					
				 $htm .="<option value='1' selected>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6' selected>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10'>10</option>";
				}
				 elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '7'){
					
				 $htm .="<option value='1'>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7' selected>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10'>10</option>";
				}
				 elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '8'){
					
				 $htm .="<option value='1'>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8' selected>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10' >10</option>";
				}
				 elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '9'){
					
				 $htm .="<option value='1'>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9' selected>9</option>";
				  $htm .="<option value='10'>10</option>";
				}
				 elseif($applicanteDetails[0]['english_proficiency_test_marks'] == '10'){
					
				 $htm .="<option value='1'>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10' selected>10</option>";
				}
				else{
					
					
					
				 $htm .="<option value='1'>1</option>";
				  $htm .="<option value='2'>2</option>";
				  $htm .="<option value='3'>3</option>";
				  $htm .="<option value='4'>4</option>";
				  $htm .="<option value='5'>5</option>";
				  $htm .="<option value='6'>6</option>";
				  $htm .="<option value='7'>7</option>";
				  $htm .="<option value='8'>8</option>";
				  $htm .="<option value='9'>9</option>";
				  $htm .="<option value='10'>10</option>";
				
				}
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
          
		   
			  $htm .="<div class='form-group'>";					    
			  $htm .="<div>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
              $htm .="</form>";
              echo $htm;
              exit;
				
				
				
			//}
			
			
		}
		
			public function saveApplicantDataDemo()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			$checkStatus = $this->mission_model->checkStatus($appid);
			if(!$checkStatus){
							$this->session->set_flashdata('message_type', 'error');
					        $this->session->set_flashdata('error', 'You are Not Authorise this.');
							redirect('regional/approved_applications');
							return false;
			}
			
			if(!empty($_POST)){
				 $data = array(
				 'english_proficiency_test_marks'=>$cleanData['testmarks'],
				 'update_testmarks'=>time()
				 );
				 
			 	 $result = $this->mission_model->updateTextMarks($data,$appid);
				 //var_dump($result);die;
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details Saved!');
					redirect(site_url().'mission/approved_applications');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'mission/approved_applications');					
				 }
			  
			  
			}	
		}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'mission/approved_applications');
		}
	}
	
	public function new_sfs_applications()
	{
		try{
			
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			//$data['newApplication']= $this->common_model->getMissionApplications($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/new_sfs_applications',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');	
		}
	}
	
	
	public function getSfsNewApplicaitons()
    {
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];
		$misionData = $this->common_model->getMissionInfo($missionId);
    	$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		$result = $this->mission_model->getSfsMissionApplications($vars,$this->ids,$countryid);
		$totalResult = $this->mission_model->getTotalSfsMissionApplications($vars,$this->ids,$countryid);
		
		$response = array();
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				
				//echo "<pre>";print_r($r);
				$applicationDetails = $this->mission_model->getApplicationSfsStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				$gender = "";
				$output= array();	
				$output[] = $counter;
				$output[] = $applicationDetails[0]['fullname'];
				$output[] = $applicationDetails[0]['email'];
				$output[] = $country[0]['country_name'];				
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
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'<br/>';
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'<br/>';
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'<br/>';
					$output[] = $fullCourse;
				}
				$universityDetails = "";
				$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				$universityDetails .= '1) '.$uni1[0]['name'].'<br/>';
				$universityDetails .= '2) '.$uni2[0]['name'].'<br/>';
				$universityDetails .= '3) '.$uni3[0]['name'].'<br/>';
				$output[] = $universityDetails;				
				
				
				$date1 = strtotime($r['created']);	
				$output[] = date('Y-m-d',$date1);

				$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt">Process</a>';
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'mission/viewfullApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt1">View</a>';
				$response[] = $output;
				$counter++;
			}
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	
	//vipin 16-8-2020
	
	function addStreamMapping()
	{
		$this->load->view('university/header_mission');
		//$this->load->view('university/leftsidebar');
		$this->load->view('university/addStreamMapping');
		$this->load->view('university/footer');
	}
	function addStream()
	{
		$this->load->view('university/header_mission');
		//$this->load->view('university/leftsidebar');
		$this->load->view('university/addStream');
		$this->load->view('university/footer');
	}
	
	
	public function getUniversityCourseProgramme()
		{
			
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$program_id = $_POST['university_pg'];
			$course_type_id = $_POST['university_course_type'];
			$universityCourses = $this->common_model->getCourseByPrgrammeAndType($program_id,$course_type_id);
		//echo "<pre>";print_r($universityCourses);die;
			//echo '<optgroup label="State Universities">';		 
											echo '<option>------Select---------</option>';
												if(count($universityCourses)>0)
												{
													foreach($universityCourses as $uni_course)
													{												
																echo '<option value="'.$uni_course['id'].'">'.$uni_course['title'].'</option>';
													}		
												}	
											
	
		} 
		public function getUniversityStreamByCourseProgrammeCoureseType()
		{
			//echo "<pre>";print_r($_POST);die;
			$var = $_POST['programme'];
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$var1 = $_POST['courseType'];
			if($var == 2 && $var1 == 4 || $var == 1 && $var1 == 5 || $var == 2 && $var1 == 5  || $var == 4 && $var1 == 5){
			$course_type = $_POST['courseType'];
			$course = $_POST['course'];
			//$universityData = $this->common_model->getUgUniversityData($universityId,$var,$course_type,$course);
			//echo "<pre>";print_r($universityData);die;
				if($var == 1 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['ug_course_stream_id']);
					//echo "<pre>";print_r($main_array);
				}
				elseif($var == 2 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['pg_courser_id']);	
				}
				elseif($var == 2 && $var1 == 4)
				{
					$main_array = explode('|',$universityData[0]['pg_courser_id']);	
				}
				elseif($var == 4 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['phd_courser_id']);	
				}
				$Coursedata = $this->common_model->getUniversityStreamDataByCourse($var,$course_type,$course);
				//$Coursedata =  $this->common_model->getUniversitiesCourseStreamMapping($universityId,$var,$course_type,$course);
				//echo "<pre>";print_r($Coursedata);die;
			 //$courseDataA = $x = array();
/* 			 if(!empty($Coursedata))
			 {
				 foreach($Coursedata as $d)
				 {
					 array_push($courseDataA, $d['id']);
				 }
				 
				$x =  array_intersect($main_array, $courseDataA);
			 } */
			
			$course =  $this->common_model->getAllCourses();
			$courseWiseUniversites = array();
			//echo "<pre>";print_r($statewiseUniversites);die;
			foreach($course as $st)
			{
				if(!array_key_exists($st['id'],$courseWiseUniversites))
				{
					$courseWiseUniversites[$st['id']] = array();
					
				}
			}
			echo '<optgroup label="Courses">';	
							 				foreach($Coursedata as $univercity)
											{											
												if(array_key_exists($univercity['course_id'],$courseWiseUniversites))
												{													
													array_push($courseWiseUniversites[$univercity['course_id']],$univercity);
												}
											}	 
											echo '<option>------Select---------</option>';
											foreach($courseWiseUniversites as $key=>$univercity1)
											{
												//echo "<pre>";print_r($univercity1);
												if(count($univercity1)>0)
												{
													$statenames = $this->common_model->getCourseById($key);
													
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['title'].'" class="stt">';
													foreach($univercity1 as $uni_choice)
													{
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['course_option_name'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['name'].'">'.$uni_choice['name'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'" disabled>'.$uni_choice['name'].'</option>';
															}
														}
														else
														{
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['name'].'</option>';
														}	
													}
													echo '</optgroup>';			
												}	
											}
										    echo '</optgroup>';
				
				//exit;
			
			}
		}
		public function getUniversityStreamByCourseProgrammeCoureseTypedemo()
		{
			//echo "<pre>";print_r($_POST);die;
			$var = $_POST['programme'];
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$var1 = $_POST['courseType'];
			if($var == 2 && $var1 == 4 || $var == 1 && $var1 == 5 || $var == 2 && $var1 == 5  || $var == 4 && $var1 == 5){
			$course_type = $_POST['courseType'];
			$course = $_POST['course'];
			//$universityData = $this->common_model->getUgUniversityData($universityId,$var,$course_type,$course);
			//echo "<pre>";print_r($universityData);die;
				if($var == 1 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['ug_course_stream_id']);
					//echo "<pre>";print_r($main_array);
				}
				elseif($var == 2 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['pg_courser_id']);	
				}
				elseif($var == 2 && $var1 == 4)
				{
					$main_array = explode('|',$universityData[0]['pg_courser_id']);	
				}
				elseif($var == 4 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['phd_courser_id']);	
				}
				$Coursedata = $this->common_model->getUniversityStreamDataByCourse($var,$course_type,$course);
			
					 $response = "<table class='table table-bordered'>";
					 $response .= "<tr>";
					 $response .= "<td><p align ='center'>".$universityData[0]['name'].'<p align ="center">following Courses only:-'."</td>";
					 $response .= "</tr>";
					 $response .= "<tr>";
					 $counter = 1;
				if(count($Coursedata) > 0)
				{ 
				foreach($Coursedata as $key){
					 $Coursedata =  $this->common_model->getStreamById($key['id']);
					
					 $response .= "<tr></td><td>".$counter.' - '.$Coursedata[0]['name']."</tr></td>";
					  $counter++;
				 }
				 $response .= "</tr>";
				
				 echo $response;
				}
				else
				{
					'No Data Found!';
				}
				
				//exit;
			
			}
		}
		public function getUniversityStream()
		{
			//echo "<pre>";print_r($_POST);
			$var = $_POST['programme'];
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$var1 = $_POST['courseType'];
			if($var == 2 && $var1 == 4 || $var == 1 && $var1 == 5 || $var == 2 && $var1 == 5  || $var == 4 && $var1 == 5){
			$course_type = $_POST['courseType'];
			$course = $_POST['course'];
			$universityData = $this->common_model->getUgUniversityData($universityId,$var,$course_type,$course);
			//echo "<pre>";print_r($universityData);die;
				if($var == 1 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['ug_course_stream_id']);
					//echo "<pre>";print_r($main_array);
				}
				elseif($var == 2 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['pg_courser_id']);	
				}
				elseif($var == 2 && $var1 == 4)
				{
					$main_array = explode('|',$universityData[0]['pg_courser_id']);	
				}
				elseif($var == 4 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['phd_courser_id']);	
				}
				$Coursedata =  $this->common_model->getUniversitiesCourseStreamMapping($universityId,$var,$course_type,$course);
				//echo "<pre>";print_r($Coursedata);die;
			 $courseDataA = $x = array();
			 if(!empty($Coursedata))
			 {
				 foreach($Coursedata as $d)
				 {
					 array_push($courseDataA, $d['id']);
				 }
				 
				$x =  array_intersect($main_array, $courseDataA);
			 }
			
			$course =  $this->common_model->getAllCourses();
			$courseWiseUniversites = array();
			//echo "<pre>";print_r($statewiseUniversites);die;
			foreach($course as $st)
			{
				if(!array_key_exists($st['id'],$courseWiseUniversites))
				{
					$courseWiseUniversites[$st['id']] = array();
					
				}
			}
			echo '<optgroup label="Courses">';	
							 				foreach($Coursedata as $univercity)
											{											
												if(array_key_exists($univercity['course_id'],$courseWiseUniversites))
												{													
													array_push($courseWiseUniversites[$univercity['course_id']],$univercity);
												}
											}	 
											echo '<option>------Select---------</option>';
											foreach($courseWiseUniversites as $key=>$univercity1)
											{
												//echo "<pre>";print_r($univercity1);
												if(count($univercity1)>0)
												{
													$statenames = $this->common_model->getCourseById($key);
													
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['title'].'" class="stt">';
													foreach($univercity1 as $uni_choice)
													{
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['course_option_name'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['name'].'">'.$uni_choice['name'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'" disabled>'.$uni_choice['name'].'</option>';
															}
														}
														else
														{
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['name'].'</option>';
														}	
													}
													echo '</optgroup>';			
												}	
											}
										    echo '</optgroup>';
				
				//exit;
			
			}
		}
		
		public function getUniversityCourseProgrammede()
		{
			
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$program_id = $_POST['university_pg'];
			$course_type_id = $_POST['university_course_type'];
			$universityCourses = $this->common_model->getCourseByPrgrammeAndType($program_id,$course_type_id);
			//echo "<pre>";print_r($universityCourses);die;
			//$universityData = $this->common_model->getUgUniversityData($universityId);
			//$stateuniversities = $this->university_model->getUniversitiesStream($universityId,$program_id);
			//echo "<pre>";print_r($universitiesStream);die;
			$programmes =  $this->university_model->getAllProgramme();
			//echo "<pre>";print_r($programmes);die;
			$statewiseUniversites = array();
			//echo "<pre>";print_r($statewiseUniversites);die;
			foreach($programmes as $st)
			{
				if(!array_key_exists($st['id'],$statewiseUniversites))
				{
					$statewiseUniversites[$st['id']] = array();
					
				}
			}
			//echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
											{											
												if(array_key_exists($univercity['programme_id'],$statewiseUniversites))
												{													
													array_push($statewiseUniversites[$univercity['programme_id']],$univercity);
												}
											}	 
											echo '<option>------Select---------</option>';
											foreach($statewiseUniversites as $key=>$univercity1)
											{
												if(count($univercity1)>0)
												{
													$statenames = $this->common_model->getProgrammeById($key);
													
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'" class="stt">';
													foreach($univercity1 as $uni_choice)
													{
																									  		
																													
																echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['name'].'</option>';
															
														
													}
													echo '</optgroup>';			
												}	
											}
										    echo '</optgroup>';	
	
		}
	public function getUniversityPageBySlugdemo()
		{
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$page_category = $_POST['page_category'];
			//print_r($page_category);die;
			$universitySlugData = $this->university_model->getUniversitySlugData($page_category,$universityId);
			//echo "<pre>";print_r($universitySlugData);die;
			$ctypeHtml = '';
			//$ctypeHtml .="<option value='0'>Course Type</option>";
			
			$ctypeHtml .="<input value='".$universitySlugData[0]['page_title']."'>";	
			
			echo $ctypeHtml;
			exit;
			
							 				
	
		} 
		
		public function getUniversityPageBySlug()
		{
			$response = array('status'=>FALSE,'data'=>array());
			try
			{			
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$page_category = $_POST['page_category'];
			//print_r($page_category);die;
			$universitySlugData = $this->university_model->getUniversitySlugData($page_category,$universityId);
				
				
				
				if(count($universitySlugData) > 0)
				{
					$response['status'] = TRUE;
					foreach($universitySlugData as $row)
					{
						//echo "<pre>";print_r($row);die;
						$response['data'][] = $row;
					}
				}
				
				
			}
			catch(Exception $e)
			{
				echo json_encode($response);
			}
			echo json_encode($response);
		}
		
		function createSeatsAllotmentMapping()
	{
		$user_data = $this->session->userdata('user_data');
		$universityId = $user_data['university'];
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		//echo "<pre>";print_r($clean);die;
		$data = array();
		if(count($clean)>0)
		{			
			
			$data['master_page_id'] = 1;
			$data['programme_id'] = $clean['programme_university'];
			$data['no_of_seat'] = $clean['seats'];	
			$data['course_id'] = $clean['university_course'];
			$data['stream_id'] = $clean['university_stream'];
			$data['course_type_id'] = $clean['university_course_type'];
			$data['created'] = time();
			$data['status'] = 1;			
		}
		
		//echo "<pre>";print_r($data);die;
		//$sts = $this->university_model->insertSchemeSlot($data);
		$sts = $this->university_model->updateSchemeSlot($universityId,$clean,$data);
		//var_dump($sts);die;
		if($sts)
		{
			 echo '<script>window.location.href="'.site_url().'university/addStreamMapping?text=Added Successfully!.&type=Success&at=success&redirect='.site_url().'university/addStreamMapping";</script>';
		}
		else
		{
			 echo '<script>window.location.href="'.site_url().'university/addStreamMapping?text=Error Occur While Adding Scheme!.&type=Error Message&at=danger&redirect='.site_url().'university/addStreamMapping";</script>';
		}
	}
		public function getUniversityStreamById()
		{
			$response = array('status'=>FALSE,'data'=>array());
			try
			{			
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$programme = $_POST['programme'];
			$courseType = $_POST['courseType'];
			$course = $_POST['course'];
			$stream = $_POST['stream'];
			//print_r($_POST);die;
			$universityStreamData = $this->university_model->getUniversityStreamData($universityId,$programme,$courseType,$course,$stream);
			//echo "<pre>";print_r($universityStreamData);die;
				if(count($universityStreamData) > 0)
				{
					$response['status'] = TRUE;
					foreach($universityStreamData as $row)
					{
						//echo "<pre>";print_r($row);die;
						$response['data'][] = $row;
					}
				}
				
				
			}
			catch(Exception $e)
			{
				echo json_encode($response);
			}
			echo json_encode($response);
		}
		
		
		function createStream()
	{
		$user_data = $this->session->userdata('user_data');
		$universityId = $user_data['university'];
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		//echo "<pre>";print_r($clean);die;
		$checkStream = $this->university_model->isStreamExists($universityId,$clean);
		//var_dump($checkStream);die;
		if($checkStream){
			
		echo '<script>window.location.href="'.site_url().'university/addStream?text=Error Occur While Adding Stream!.&type=Error Message&at=danger&redirect='.site_url().'university/addStream";</script>';
		return false;
		}
		else
		{
		$datas = array();
		/* if(count($clean)>0)
		{			
			$data['programme_id'] = $clean['programme_university'];
			$data['course_id'] = $clean['university_course'];
			$data['university_id'] = $universityId;
			$data['course_type_id'] = $clean['university_course_type'];
			$data['name'] = $clean['stream'];
			$data['created'] = time();
			$data['status'] = 1;			
		} */
		
		//echo "<pre>";print_r($data);die;
		//$sts = $this->university_model->insertSchemeSlot($data);
		//$sts = $this->university_model->insertStream($data);
		if(count($clean)>0)
		{			
			$datas['programme_id'] = $clean['programme_university'];
			$datas['course_id'] = $clean['university_course'];
			$datas['user_id'] = $universityId;
			$datas['master_page_id'] = 1;
			$datas['stream_id'] = $clean['university_stream'];
			$datas['course_type_id'] = $clean['university_course_type'];
			$datas['created'] = time();
			$datas['status'] = 1;			
		}
		$sts1 = $this->university_model->insertStreamMapping($datas);
		//var_dump($sts);die;
		if($sts1)
		{
			 echo '<script>window.location.href="'.site_url().'university/addStreamMapping?text=Added Successfully!.&type=Success&at=success&redirect='.site_url().'university/addStream";</script>';
		}
		else
		{
			 echo '<script>window.location.href="'.site_url().'university/addStream?text=Error Occur While Adding Scheme!.&type=Error Message&at=danger&redirect='.site_url().'university/addStream";</script>';
		}
		}
	
		
	}
	
	function openUniversityStatus(){
		
		
		echo openUniversityStatus();
		
	}
	//University Popup
	
		function ajaxfile()
    {
		
    	$user_data = $this->session->userdata('user_data');
		$universityId = $user_data['university'];
		//print_r($universityId);die;
		$result = $this->university_model->getCountUniversityApplicationsAlert($universityId);
		//echo "<pre>";print_r($result);die;
		$missionFrdAppRes = $this->university_model->getUniversityForwordApplicationAlert($universityId);
		
		
		$acceptance= $this->university_model->getUniversityApplicantAcceptanceAlert($universityId);

		
		$response = array();
		//if(!empty($result))
		//{
			$counter = 1;
			$sum = 0;
			$htm = "<table class='customTable1 table table-striped table-bordered'>";
			
				$htm .= "<thead>";

				$htm .= "<tr>";
				$htm .= "<td>Application Received : </td><td>".$result."</td>";
				$htm .= "</tr>";

				$htm .= "<tr>";
				$htm .= "<td>Processed Application : </td><td>0</td>";
				$htm .= "</tr>";
				
				$htm .= "<tr>";
				$htm .= "<td>Acceptance/Decline by Applicant : </td><td>".$acceptance."</td>";
				$htm .= "</tr>";
				
				
				

				
				$htm .="</thead>";
      $htm .= "</table>";
      echo $htm;
      exit;
				
				
				
			//}
			
			
		}
		
		
		
		//University Remarks 
   
   function editUniversityRemarks()
    {
		
		
		$appId = $_POST['id'];
		//echo '<pre>';
		//print_r($_POST);die;
		$applicanteDetails = $this->mission_model->getApplicantDetails($appId);
		$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicanteDetails[0]['application_no']);
		//echo '<pre>';
		//print_r($applicanteDetails);die;
			?>
			<table class="table table-bordered">
    <thead>
        <th>Name</th>
		<th>Application No</th>
		<th>Email</th>
		<!---<th>Level of Programme</th>
		<th>University</th>--->
    </thead>
    <tbody>
	<?php
	if(count($applicaitonStepOne)>0)
				{
					foreach($applicaitonStepOne as $app)
					{
						?>
      <tr>
	  <td><?php echo $app['fullname'];?></td>
	  <td><?php echo $app['application_no'];?></td>
	    <td><?php echo $app['email'];?></td>
		 <!------<td><?php
            $programme = $this->common_model->getAllProgramme();
                                        foreach ($programme as $program) {
                                            if (!empty($applicaitonStepOne)) {
                                                if ($applicaitonStepOne[0]['programme'] == $program['id']) {
                                                    echo $program['name'];
                                                }
                                            }
                                        }
                                        ?></td>
			
					<td>
							<?php
							$uni1 = $this->common_model->getUniversityById($app['universty_choice']);
							$uni2 = $this->common_model->getUniversityById($app['universty_choice_two']);
							$uni3 = $this->common_model->getUniversityById($app['universty_choice_three']);
							echo '1) '.$uni1[0]['name'].'<br/>';
							echo '2) '.$uni2[0]['name'].'<br/>';
							echo '3) '.$uni3[0]['name'].'<br/>';
							?>
					</td>------>

	<!------<table class="table table-bordered">
    <thead>
        <th>Remarks By University</th>
		<th>University Remarks Date</th>
		<th>Remarks By Applicant</th>
		<th>Applicant Remarks Date</th>
    </thead>
    <tbody>
	<?php
		if(count($applicanteDetails)>0)
				{
					?>	
<tr>
<td>

<?php 
if(!empty($applicanteDetails[0]['university_remarks'])){
echo $applicanteDetails[0]['university_remarks'];
}
else
{
	echo 'NA';
}

?>

</td>
<td>
<?php 
if(!empty($applicanteDetails[0]['update_university_remarks'])){
$unDate = $applicanteDetails[0]['update_university_remarks'];
echo date('Y-m-d',$unDate);	
}
else
{
	echo 'NA';
}

?></td>
<td><?php 
if(!empty($applicanteDetails[0]['student_remarks'])){
echo $applicanteDetails[0]['student_remarks'];
}
else
{
	echo 'NA';
}
?>
</td>
<td><?php 
$applicantDate = $applicanteDetails[0]['update_student_remarks'];	
if(!empty($applicantDate)){
	echo date('Y-m-d',$applicantDate);
}
else
{
	echo 'NA';
	
}


?></td>
</tr>

<?php
					
				}
						
?>

   </tbody>		
	  </tr>
	  <?php
					}
				}
		?>
    </tbody>----->
  </table>
  <?php
			
			  $htm  ="<form action='".site_url().'university/saveUniversityApplicantData/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			  $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$applicanteDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'app_no' value = '".$applicanteDetails[0]['application_no']."'>";
			  $htm .="<div class='form-row'>";
			  $htm .="<div class='form-group'>";
			  $htm .="<label>Enter Remarks:</label>";
			  $htm .="<textarea class='form-control rounded-0' id='exampleFormControlTextarea2' id ='university_remarks' name='university_remarks' required rows='3'>";
			  $htm .="</textarea>";
			  $htm .="</div>";
			  
			  $htm .="<label>Action:</label>";
			  $htm .="<select class='form-control' id ='status' name='status' required = 'true'>";
			 
			  $htm .="<option value=''>---Select---</option>";
			  $htm .="<option value='5'>Re-submit</option>";
				  
			 
			   $htm .="</select>";
			  
			  $htm .="<div class='form-group'>";					    
			  $htm .="<div>";
			  $htm .="</br>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
			 
              $htm .="</form>";
              echo $htm;
              exit;
				
				
				
			//}
			
			
		}
		
			public function saveUniversityApplicantData()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$postData = $this->input->post(NULL,TRUE);
			//echo "<pre>";print_r($postData);die;
		    $cleanData = $this->security->xss_clean($postData);	
			$roDetails = $this->common_model->getRegionById($user_data['state']);
			//echo "<pre>";print_r($roDetails);die;
			$appid = $cleanData['appId'];
			$app_no = $cleanData['app_no'];
			$universityId = $user_data['university'];
			$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($app_no);
			//$checkStatus = $this->university_model->checkStatus($appid);
			//var_dump($applicaitonStepOne);die;
			//if(!$checkStatus){
					//$this->session->set_flashdata('message_type', 'error');
					//$this->session->set_flashdata('error', 'You are Not Authorise this.');
					//redirect('university/dashboard');
					//return false;
			//}
			
			
			
			if(!empty($_POST)){
				 $data = array(
				 'university_remarks'=>$cleanData['university_remarks'],
				 'university_remarks_date'=>time(),
				 'status'=>$cleanData['status'],
				 'main_status'=>'Pending'
				 );
				 
				 //$applicanteDetails = $this->university_model->getApplicantDetails($appId);
				 //echo "<pre>";print_r($data);die;
				 $applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($app_no);
				 //echo "<pre>";print_r($applicaitonStepOne);die;
				 	 $email_to = array(
						$applicaitonStepOne[0]['email'], 
						$user_data['email'],
						$roDetails[0]['email']
						
						);
				//echo "<pre>";print_r($email_to);die;
			 	 $result = $this->university_model->updateRemarks($data,$app_no,$universityId);
				 //var_dump($result);die;
 				 /* if($result)
				 {
					 $resulReject = $this->university_model->updateUnivesityRemarks($app_no);
					 var_dump($resulReject);die;
				 }  */
			
				  $messages = '';                
		          $messages .= '<strong>Hi '.$applicaitonStepOne[0]['fullname'].',</strong><br><br>';
		          $messages .= $data['university_remarks'];
						//$body = "Your application for scholarship could not be processed for the following reasons.<br/><br/>";
				  $body .= $messages;	
						//$body .= "<br/><br/>You are being given opportunity to resubmit your applicatin with the mission documents before ".$this->config->item('Mission_Applicant_Pending_Date');					
				  $mailsend = $this->sendMail($body,$email_to,"Indian Council for Cultural Relations.","mail_not_process");
				 //var_dump($result);die;
			 	 if($mailsend)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details Saved!');
					redirect(site_url().'university/dashboard');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'university/dashboard');					
				 }
			  
			  
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'mission/dashboard');
		}
	}
	
		public function addUniversityPages(){
		
		    $user_data = $this->session->userdata('user_data');
			$data['university'] = $user_data['university'];
			$universityId = $user_data['university'];
			$data = array();
			$data['pages'] = $this->common_model->getUniversityPages($page_slug,$page_title,$universityId);
			//echo "<pre>";print_r($data['pages']);die;
			
			$this->load->view('university/header_mission');
			$this->load->view('university/add_university_page',$data);
			$this->load->view('university/footer');
	}

		public function missingDocs()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$universityId = $user_data['university'];
			//echo $universityId;die;
			//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			$data['missingDocs']= $this->university_model->missingDocs($universityId);
			$this->load->view('university/header_mission');
			$this->load->view('university/missingDocs',$data);
			$this->load->view('university/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured! Try After Some Time');
			redirect(site_url().'university/dashboard');
		}
	}
	
	public function video()
		{
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$data['universityData'] = $this->common_model->getUniversityInfo($universityId);
			//echo "<pre>";print_r($data['universityData']);die;
			$this->load->view('university/header_mission');
			$this->load->view('university/video',$data);
			$this->load->view('university/footer');
		}
	
	public function downloadDocs(){
			//echo base64_decode($this->uri->segment(3));die;
			$file_name = base64url_decode($this->uri->segment(3));
			fileForceDownload($file_name);
		}
	public function __destruct() {
    $this->db->close();
    }
	
}

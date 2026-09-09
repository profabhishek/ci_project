<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
	 
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');	
        // $this->load->library('encryption');
        $this->load->helper('date');   
		// $this->load->library('zip');
		$this->load->helper('fy_helper');   
        $this->load->model('user_model'); 
        $this->load->model('common_model');     
        $this->load->model('user_model');    
		$this->load->model('admin_model'); 
        $this->load->model('hqrs_model');		
        // Moved out of the constructor for performance: 'excel' is now loaded only inside the methods that use it.
        // Moved out of the constructor for performance: 'mpdf60/Mpdf' is now loaded only inside the methods that use it.
		
       $userdata =$this->session->userdata('user_data');
        if(!$this->session->userdata('user_data'))
	    {
	    	redirect('home');
	    }
	    else
	    {
			$roles = $this->config->item('roles_id');
   			$role = $roles[$userdata['user_type']];
        	switch($role)
        	{				
				case "Mission":
				redirect(site_url() . 'mission/dashboard');
				break;				
				case "Regional Office":
				redirect(site_url() . 'regional/dashboard');
				break;
				case "ICCR":
				redirect(site_url() . 'headquarter/dashboard');
				break;
				case "Student":
				redirect(site_url() . 'applicant/dashboard');
				break;
				
			}
		}  

			 $division = $userdata['state'];
        if ($division == 0 || $division == -10 || $division == -20) {
            $division = 1;
        }
       
        $divisionInfo = $this->common_model->getDivisionById($division);
     
        
        $schemids = explode(',',  $divisionInfo[0]['scheme_ids']);
    
        if(count($schemids) > 1){
			$this->ids = $schemids;
		}else{
			$schemstring = $divisionInfo[0]['scheme_ids'];
			$this->ids = $schemstring;
		}
    }	
	
    public function index()
    {
    	$data['missions'] = count($this->common_model->getAllMissions());
		$data['regions'] = count($this->common_model->getAllRegions());
		$data['universities'] = count($this->common_model->getAllUniversities());
		$data['students'] =  count($this->common_model->getAllStudents());
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/dashboard',$data);
		$this->load->view('admin/footer_main');
	}
	
	/*public function generateMissiionPassword()
	{
		$missions = $this->common_model->getAllMissions();
		foreach($missions as $mis)
		{
			$token = substr(sha1(rand()), 0, 8);
			$data = array('password'=>$token);
			$sts = $this->common_model->updateMissionPass($data,$mis['id']);
			echo $sts;
		}
	}*/
	public function dashboard()
	{
		$data['missions'] = count($this->common_model->getAllMissions());
		$data['regions'] = count($this->common_model->getAllRegions());
		$data['universities'] = count($this->common_model->getAllCurrentUniversities());
		$data['students'] =  $this->common_model->getAllStudents();

		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		 $this->load->view('admin/dashboard',$data);
		$this->load->view('admin/footer_main');
	}
	
	public function logout()
    {
        $this->session->unset_userdata('user_data');
        redirect('home');
    }
    function deleteMission()
    {
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $clean['missionId'];
		$sts = $this->common_model->deleteMission($id);
		if($sts)
		{
			$response['status'] = TRUE;
		}
		else
		{
			 $response['status'] = FALSE;
		}
		echo json_encode($response);		
	}
    function allmissions()
    {
    	$data['missions'] = $this->common_model->getAllMissions();
    	
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/missionlist',$data);
		$this->load->view('admin/footer_main');
	}
	function addMission()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addMission');
		$this->load->view('admin/footer_main');
	}
	
	function allschemes()	
    {
    	$data['schemes'] = $this->common_model->getAllSchemes();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/schemesList',$data);
		$this->load->view('admin/footer_main');
	}
	
	
	
	function addStreamMapping()
	{
		$this->load->view('university/header_mission');
		//$this->load->view('university/leftsidebar');
		$this->load->view('university/addStreamMapping');
		$this->load->view('university/footer');
	}
	
	
	
	public function getUniversityCourseProgramme()
		{
			
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$program_id = $_POST['university_pg'];
			$course_type_id = $_POST['university_course_type'];
			$universityCourses = $this->common_model->getCourseByPrgrammeAndType($program_id,$course_type_id);
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
			$var = $_POST['programme'];
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$var1 = $_POST['courseType'];
			if($var == 2 && $var1 == 4 || $var == 1 && $var1 == 5 || $var == 2 && $var1 == 5  || $var == 4 && $var1 == 5){
			$course_type = $_POST['courseType'];
			$course = $_POST['course'];
				if($var == 1 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['ug_course_stream_id']);
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
			}
		}
		public function getUniversityStreamByCourseProgrammeCoureseTypedemo()
		{
			$var = $_POST['programme'];
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$var1 = $_POST['courseType'];
			if($var == 2 && $var1 == 4 || $var == 1 && $var1 == 5 || $var == 2 && $var1 == 5  || $var == 4 && $var1 == 5){
			$course_type = $_POST['courseType'];
			$course = $_POST['course'];
			//$universityData = $this->common_model->getUgUniversityData($universityId,$var,$course_type,$course);
				if($var == 1 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['ug_course_stream_id']);
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
			}
		}
		public function getUniversityStream()
		{
			$var = $_POST['programme'];
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$var1 = $_POST['courseType'];
			if($var == 2 && $var1 == 4 || $var == 1 && $var1 == 5 || $var == 2 && $var1 == 5  || $var == 4 && $var1 == 5){
			$course_type = $_POST['courseType'];
			$course = $_POST['course'];
			$universityData = $this->common_model->getUgUniversityData($universityId,$var,$course_type,$course);
				if($var == 1 && $var1 == 5)
				{
					$main_array = explode('|',$universityData[0]['ug_course_stream_id']);
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
							
			}
		}
		
		public function getUniversityCourseProgrammede()
		{
			
			$user_data = $this->session->userdata('user_data');
			$universityId = $user_data['university'];
			$program_id = $_POST['university_pg'];
			$course_type_id = $_POST['university_course_type'];
			$universityCourses = $this->common_model->getCourseByPrgrammeAndType($program_id,$course_type_id);
			//$universityData = $this->common_model->getUgUniversityData($universityId);
			//$stateuniversities = $this->university_model->getUniversitiesStream($universityId,$program_id);
			$programmes =  $this->university_model->getAllProgramme();
			$statewiseUniversites = array();
			foreach($programmes as $st)
			{
				if(!array_key_exists($st['id'],$statewiseUniversites))
				{
					$statewiseUniversites[$st['id']] = array();
					
				}
			}
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
			$universitySlugData = $this->university_model->getUniversitySlugData($page_category,$universityId);
			$ctypeHtml = '';			
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
			$universitySlugData = $this->university_model->getUniversitySlugData($page_category,$universityId);
				if(count($universitySlugData) > 0)
				{
					$response['status'] = TRUE;
					foreach($universitySlugData as $row)
					{
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
			$universityStreamData = $this->university_model->getUniversityStreamData($universityId,$programme,$courseType,$course,$stream);
				if(count($universityStreamData) > 0)
				{
					$response['status'] = TRUE;
					foreach($universityStreamData as $row)
					{
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
		$datas = array();
		if(count($clean)>0)
		{			
			$datas['programme_id'] = $clean['programme_university'];
			$datas['course_id'] = $clean['university_course'];
			$datas['name'] = $clean['stream'];
			$datas['course_type_id'] = $clean['university_course_type'];
			$datas['created'] = time();
			$datas['status'] = 1;			
		}
		$sts1 = $this->admin_model->insertStream($datas);
		if($sts1)
		{
			 echo '<script>window.location.href="'.site_url().'admin/addStream?text=Added Successfully!.&type=Success&at=success&redirect='.site_url().'admin/addStream";</script>';
		}
		else
		{
			 echo '<script>window.location.href="'.site_url().'admin/addStream?text=Error Occur While Adding Scheme!.&type=Error Message&at=danger&redirect='.site_url().'admin/addStream";</script>';
		}
	}
	
	function adduniverstiyMapping()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/adduniverstiyMapping');
		$this->load->view('admin/footer_main');
	}
	function addStream()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addStream');
		$this->load->view('admin/footer');
	}
	function addSchemeSlot()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addSchemeSlot');
		$this->load->view('admin/footer_main');
	}
	function createUniverstiyMapping()
	{
		$response = array('status'=>FALSE);
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			$data['state'] = $clean['regions'];		
			if(count($clean['ug_courser_typ_id'])>0)
			{
				$data['ug_courser_typ_id'] = implode("|",$clean['ug_courser_typ_id']);
			}
			else
			{
				$data['ug_courser_typ_id'] = "";
			}
			if(count($clean['pg_courser_typ_id'])>0)
			{
				$data['pg_courser_typ_id'] = implode("|",$clean['pg_courser_typ_id']);
			}
			else
			{
				$data['pg_courser_typ_id'] = "";
			}
			if(count($clean['mhphil_courser_typ_id'])>0)
			{
				$data['mhphil_courser_typ_id'] = implode("|",$clean['mhphil_courser_typ_id']);		
			}
			else
			{
				$data['mhphil_courser_typ_id'] = "";
			}
			if(count($clean['phd_courser_typ_id'])>0)
			{
				$data['phd_courser_typ_id'] = implode("|",$clean['phd_courser_typ_id']);	
			}
			else
			{
				$data['phd_courser_typ_id'] = "";
			}
			if($clean['universtiy'] == "")
			{
				$data['name'] = $clean['universy'];	
			}
			else
			{
				$data['name'] = $clean['universtiy'];	
			}
			
			$data['state_id'] = $clean['state_id'];
			$data['link'] = $clean['link'];	
			$data['status'] = 1;	
			$data['university_type'] = $clean['university_type'];				
		} 		
		$sts = $this->common_model->insertunivercitiesList($data);
		if(count($clean['ug_courser_typ_id'])>0)
		{
			$ugArray = array();
			foreach($clean['ug_courser_typ_id'] as $ugid)
			{
				$ugArray = array(
					'university_id'=>$sts,
					'programme_id'=>1,
					'course_type'=>$ugid
				);	
				$sts1 = $this->common_model->insertunivercitiesListMapping($ugArray);
			}			
		}
		if(count($clean['pg_courser_typ_id'])>0)
		{
			$pgArray = array();
			foreach($clean['pg_courser_typ_id'] as $pgid)
			{
				$pgArray = array(
					'university_id'=>$sts,
					'programme_id'=>2,
					'course_type'=>$pgid
				);
				$sts2 = $this->common_model->insertunivercitiesListMapping($pgArray);		
			}
		}
		if(count($clean['mhphil_courser_typ_id'])>0)
		{
			$mphilArray = array();
			foreach($clean['mhphil_courser_typ_id'] as $mpid)
			{
				$mphilArray = array(
					'university_id'=>$sts,
					'programme_id'=>3,
					'course_type'=>$mpid
				);	
				$sts3 = $this->common_model->insertunivercitiesListMapping($mphilArray);	
			}
		}
		if(count($clean['phd_courser_typ_id'])>0)
		{
			$phdArray = array();
			foreach($clean['phd_courser_typ_id'] as $phdid)
			{
				$phdArray = array(
					'university_id'=>$sts,
					'programme_id'=>4,
					'course_type'=>$phdid
				);		
				$sts4 = $this->common_model->insertunivercitiesListMapping($phdArray);
			}
		}
		if($sts)
		{
			$response['status'] = TRUE;
		}
		else
		{
			 $response['status'] = FALSE;
		}
		echo json_encode($response);
	}
	function updateSeatsAllotment()
	{
		$response = array('status'=>FALSE);
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			$data['id'] = $clean['schemesId'];
			$data['scheme_id'] = $clean['schemes_one'];
			$data['country_id'] = $clean['schemecountry_one'];
			$data['slots'] = $clean['seats_one'];	
		} 
		$sts = $this->common_model->updateSchemeSlot($data);
		if($sts)
		{
			$response['status'] = TRUE;
		}
		else
		{
			 $response['status'] = FALSE;
		}
		echo json_encode($response);
	}
	function createSeatsAllotmentMapping()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		$countryString ="";
		if(count($clean)>0)
		{			
			if(count($clean['schemecountry']) > 0)
			{
				$counteies = $clean['schemecountry'];
				foreach($counteies as $country)
				{
					$countryString .= $country.'|';
				}
				$countryString = substr($countryString,0,strlen($countryString)-1);
			}
			$data['scheme_id'] = $clean['schemes'];
			$data['country_id'] = $countryString;
			$data['slots'] = $clean['seats'];			
			$data['created'] = time();
			$data['status'] = 1;			
		}
		$sts = $this->common_model->insertSchemeSlot($data);
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Scheme Added Successfully!!');
			redirect(site_url().'admin/addSchemeMapping');
			 //echo '<script>window.location.href="'.site_url().'admin/addSchemeMapping?text=Scheme Added Successfully!.&type=Success&at=success&redirect='.site_url().'admin/addSchemeMapping";</script>';
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Scheme!');
			redirect(site_url().'admin/addSchemeMapping');
			 //echo '<script>window.location.href="'.site_url().'admin/addSchemeMapping?text=Error Occur While Adding Scheme!.&type=Error Message&at=danger&redirect='.site_url().'admin/addSchemeMapping";</script>';
		}
	}
	function createSeatsAllotment()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			$data['scheme_id'] = $clean['schemes'];
			$data['country_id'] = $clean['schemecountry'];
			$data['slots'] = $clean['seats'];			
			$data['created'] = date("Y-m-d H:i:s",time());
			$data['status'] = 1;			
		} 
		//$sts = $this->common_model->insertSchemeSlot($data);
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Scheme Added Successfully!!');
			redirect(site_url().'admin/addSchemeSlot');
			 //echo '<script>window.location.href="'.site_url().'admin/addSchemeSlot?text=Mission Added Successfully!.&type=Success&at=success&redirect='.site_url().'admin/addSchemeSlot";</script>';
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Scheme!');
			redirect(site_url().'admin/addSchemeSlot');
			 //echo '<script>window.location.href="'.site_url().'admin/addSchemeSlot?text=Error Occur While Adding Mission!.&type=Error Message&at=danger&redirect='.site_url().'admin/addSchemeSlot";</script>';
		}
	}
	function addMissionLogin()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addMIssionLogin');
		$this->load->view('admin/footer_main');
	}
	function createMission()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$this->form_validation->set_rules('mission_email', 'Email', 'required|valid_email');
	   // $this->form_validation->set_rules('pass', 'Password', 'required');	
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        }
		$data = array();
		if(count($clean)>0)
		{			
			$data['country'] = $clean['missioncountry'];
			$data['mission_type'] = $clean['mission_type'];
			$data['mission_name'] = $clean['mission_name'];
			$data['mission_email'] = $clean['mission_email'];			
			$data['created'] = date("Y-m-d H:i:s",time());
			$data['status'] = 1;			
		} 
		$sts = $this->common_model->insertMission($data);
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Mission Added Successfully!!');
			redirect(site_url().'admin/addMission');
			 //echo '<script>window.location.href="'.site_url().'admin/addMission?text=Mission Added Successfully!.&type=Success&at=success&redirect='.site_url().'admin/addMission";</script>';
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Mission!');
			redirect(site_url().'admin/addMission');
			 //echo '<script>window.location.href="'.site_url().'admin/addMission?text=Error Occur While Adding Mission!.&type=Error Message&at=danger&redirect='.site_url().'admin/addMission";</script>';
		}
	}
	function deleteRegion()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $clean['regionId'];
		$sts = $this->common_model->deleteRgion($id);
		if($sts)
		{
			$response['status'] = TRUE;
		}
		else
		{
			 $response['status'] = FALSE;
		}
		echo json_encode($response);
	}
	
	function deleteScheme()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $clean['schemeId'];
		$sts = $this->common_model->deleteScheme($id);
		if($sts)
		{
			$response['status'] = TRUE;
		}
		else
		{
			 $response['status'] = FALSE;
		}
		echo json_encode($response);
	}
	function allregions()	
    {
    	$data['regions'] = $this->common_model->getAllRegions();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/regionlist',$data);
		$this->load->view('admin/footer_main');
	}
	function Schemes()
	{
		$data['schemes'] = $this->common_model->getAllSchemes();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/schemesList',$data);
		$this->load->view('admin/footer_main');
	}
	function addSchemeMapping()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addSchemeSlotMapping');
		$this->load->view('admin/footer_main');
	}
	function allSchemeslots()
	{
		$data['schemesslot'] = $this->common_model->getAllSchemesSlot();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/schemesslotList',$data);
		$this->load->view('admin/footer_main');
	}
	function addUniversity()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addUniversity');
		$this->load->view('admin/footer_main');
	}
	function addRegion()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addRegion');
		$this->load->view('admin/footer_main');
	}
	function addRegionalOffice()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addRegional');
		$this->load->view('admin/footer_main');
	}
	function createMissionLogin()
	{		
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			$data['username'] =  $clean['mission_username'];
			$data['user_country'] =  $clean['mission_id'];			
			$data['status'] = 1;			
			$data['email_id'] =  $clean['email_id']; 
			$data['password'] =  md5("123456"); 
			$data['created'] = time(); 
			$data['user_type'] = 2;
			$data['normal_password'] =  "123456";
		} 
		$sts = $this->common_model->insertRegion_User($data);
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Mission Login Added Successfully!!');
			redirect(site_url().'admin/addMissionLogin');
			 //echo '<script>window.location.href="'.site_url().'admin/addMissionLogin?text=Regional Login Added Successfully!.&type=Success&at=success&redirect='.site_url().'admin/addMissionLogin";</script>';
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Mission Login!');
			redirect(site_url().'admin/addMissionLogin');
			 //echo '<script>window.location.href="'.site_url().'admin/addMissionLogin?text=Error Occur While Adding Regional Login!.&type=Error Message&at=danger&redirect='.site_url().'admin/addMissionLogin";</script>';
		}
	}
	public function downloadList()
	{
		try
	    {
	    	$appno = $this->uri->segment(3);
	    	$content = $this->input->post("myHTML");
			$this->load->library('mpdf60/Mpdf');
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
	        echo $e;
	        exit;
	    }
	}
	function createRegionalOffice()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			$data['username'] = $clean['username'];
			$data['state'] =  $clean['state'];			
			$data['status'] = 1;			
			$data['email_id'] =  $clean['email_id']; 
			$data['password'] =  md5("123456"); 
			$data['created'] = time(); 
			$data['user_type'] = 4;
			$data['normal_password'] =  "123456";
		} 
		$sts = $this->common_model->insertRegion_User($data);
		if($sts)
		{
			 echo '<script>window.location.href="'.site_url().'admin/addUniversity?text=Regional Login Added Successfully!.&type=Success&at=success&redirect='.site_url().'admin/addUniversity";</script>';
		}
		else
		{
			 echo '<script>window.location.href="'.site_url().'admin/addUniversity?text=Error Occur While Adding Regional Login!.&type=Error Message&at=danger&redirect='.site_url().'admin/addUniversity";</script>';
		}
	}
	/* function directUpdateUniversity(){
	$data = $this->common_model->getAllUniversities();
	$value = array();
	$arr = array();
	foreach($data as $val){
	
	$value = $this->security->xss_clean($val['name']);
	
	$final_value = preg_replace('/[^A-Za-z0-9\s]/','',$value);
	
		if(count($final_value)>0)
		{
			$arr['title'] = $final_value;
			$sts = $this->common_model->updateUniversity($val['id'],$arr);					
			
		}
	}
	//echo '<pre>';print_r($arr);exit;
		exit;
      
	} */
	function updateUniversity()
	{
				
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			
			$data['title'] =  $clean['title'];
			$data['status'] =  $clean['status'];
			$data['link'] =  $clean['university_link'];
			
		} 
		
		$sts = $this->common_model->updateUniversity($clean['id'],$data);
		if($sts)
		{
			 $message = array('type'=>'success', 'message'=>'University data updated successfully !');
                $this->session->set_flashdata('message', $message);

                redirect(base_url('admin/editUniversity/').$clean['id']);
		}
		else
		{
			 $message = array('type'=>'error', 'message'=>'University data not updated!');
                $this->session->set_flashdata('message', $message);

                redirect(base_url('admin/editUniversity/').$clean['id']);
		}
		
	}
		 public function downloadAluminiPdf()
		{
			
				$nowtime = time();
				$user_data = $this->session->userdata('user_data');	
				$clean = $this->input->post(NULL,TRUE);
				$cleanData = $this->security->xss_clean($clean);	
				$alunamiapplication = $this->common_model->getAllAlumaniApplicationsDetails();
				//echo "<pre>";
				//print_r($data['confirmation']);die;
				//$this->load->view('admin/header_main');
		       //$this->load->view('admin/leftsidebar');
		        //$this->load->view('admin/reportTotalPdf',$data);
		        //$this->load->view('admin/footer_main');
				
				//$pdff = $this->load->view('admin/reportTotalPdf',$data,TRUE);
                //echo $pdff;die;
				
			    $this->load->library('mpdf60/Mpdf');
			    $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
				$mpdf->SetFont('Arial', 'B', 12);
				$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
				$mpdf->watermark_font = 'DejaVuSansCondensed';
				$mpdf->showWatermarkText = true;
				$html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Total Alumini</h3><br/>";
				$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";		 
				// LOAD a stylesheet
				$stylesheet = file_get_contents('assets/site/main/css/bootstrap.min.css'); 
				//echo $stylesheet;
				$stylesheet1 = file_get_contents('assets/site/main/css/tablepdf.css'); 
				
				$stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
                $mpdf->WriteHTML($stylesheet5, 1); // The parameter 1 tells that this is css/style only and no body/html/text
				
				$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
				$mpdf->WriteHTML($stylesheet1,1); 
				$mpdf->WriteHTML($html1,2);
				
				
				//$rpsdata = $this->main_model->downloadReportData($appno);
				
				
				$datahtml = '';
				$datahtml.= "<table class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;' class='table table-bordered'><tbody>";
				
				
				$datahtml.='<thead>';
				$datahtml.= '<tr>';
				$datahtml.= "<th class='caps' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>S.No</th>";
				$datahtml.="<th class='caps' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Country</th>";
				$datahtml.="<th class='caps' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Total</th>";
				$datahtml.= '<tr>';		
				$datahtml.='<tbody>';
				$counter = 1;
				$sum = 0;
				if(count($alunamiapplication)>0)
				{
					
					foreach($alunamiapplication as $confirm)
					
					{
						$datahtml.='<tr>';
						$datahtml.='<td>'.$counter.'</td>';
						$datahtml.='<td>'.$confirm['country_name'].'</td>';
						$datahtml.='<td>'.$confirm['countryTotal'].'</td>';
					    $datahtml.='<br/>';
						$sum+= $confirm['countryTotal'];
						$datahtml.='</tr>';	
						$counter++;
						
					}
					
					$datahtml.='<td>Total -'.$sum.'</td>';
					$datahtml.= '</tbody>';
					$datahtml.= '</table>';
					$mpdf->WriteHTML($datahtml);	
					$mpdf->Output();
			}
			
				
		
		}
	 public function downloadTotalConfirmationpdfs()
		{
			
			try
			{
				$nowtime = time();
				$user_data = $this->session->userdata('user_data');	
				$clean = $this->input->post(NULL,TRUE);
				$cleanData = $this->security->xss_clean($clean);	
				$vars = $this->input->post();
			
                $lists = $this->common_model->get_datatables($this->ids,$vars);	
				//echo "<pre>";print_r($lists);die;
				
			    $this->load->library('mpdf60/Mpdf');
			    $mpdf = new Mpdf('s', 'A4', '', '', 10, 10, 15, 15, 15, 15);
				$mpdf->SetFont('Arial', 'B', 12);
				$mpdf->shrink_tables_to_fit = 1;
				$keep_table_proportions = true;
				$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
				$mpdf->watermark_font = 'DejaVuSansCondensed';
				$mpdf->showWatermarkText = true;
				$html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Report</h3><br/>";
				$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";		 
				// LOAD a stylesheet
				$stylesheet = file_get_contents('assets/site/main/css/bootstrap.min.css'); 
				//echo $stylesheet;
				$stylesheet1 = file_get_contents('assets/site/main/css/tablepdf.css'); 
				
				$stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
				
                $mpdf->WriteHTML($stylesheet5, 1); // The parameter 1 tells that this is css/style only and no body/html/text
				
				$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
				$mpdf->WriteHTML($stylesheet1,1); 
				$mpdf->WriteHTML($html1,2);
				
				
				//$rpsdata = $this->main_model->downloadReportData($appno);
				
				
				$datahtml = '';
				$datahtml.= "<table border='1' width='100%' style='overflow: wrap' class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;' class='table table-bordered r-report'><tbody>";
				
				
				$datahtml.='<thead>';
				$datahtml.= '<tr>';
				$datahtml.= "<th class='caps tbl_rpdf' style='width:150px;top:20px;min-width: 500pt;text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;' style='padding:110px;'>S.No</th>";
				$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Application No</th>";
				$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Name</th>";
							$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Email</th>";
				$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Gender</th>";
							$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Country</th>";
				$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Programme</th>";
							$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Region Name</th>";
				$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Course</th>";
							$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>University</th>";
				$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Scheme Name</th>";
				$datahtml.="<th class='caps tbl_rpdf' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:0;font-weight:normal;' style='padding:110px;'>Year</th>";
				$datahtml.= '<tr>';
				$datahtml.='<tbody>';
				$counter = 1;
				if(count($lists)>0)
				{
					
					foreach($lists as $r)
					
					{
						//echo "<pre>";print_r($r);die;
						$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r->application_no);
				$country = $this->common_model->getCountryById($r->nationality);
				
		
		
		
		if ($r->gender == 1) {
								$gender  = "Male";
								} elseif ($r->gender == 2) {
									$gender  = "Female";
								}
		$programme = $this->common_model->getProgrammeById($r->programme);
		 $reg1 = $this->common_model->getRegionById($r->region_one_status);
		 $regionName = $reg1[0]['name'];
				$programmeName = $programme[0]['name'];
				 $uni = $this->common_model->getUniversityById($r->regional_university);
				$uniName = $uni[0]['name'];
				$sch = $this->common_model->getSchemeById($r->scholarship_id);
                $schemeName= $sch[0]['scheme_name'];
				
				$date1 = '2021-03-15';
						//$date1 = '2019-12-01';
						$date = date_create($r->cu_created);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
							if ($date2 >= $date1) {
							$fy = '2021-2022';
							$acdYear = $fy;
							}
				$date2020 = '2019-12-01';
						//$date1 = '2019-12-01';
						$date = date_create($r->cu_created);
						$array =  (array) $date;
						$date2020st = date("Y-m-d", strtotime($array['date']));
							if($date2020st >=$date2020 && $date2020st <=$date1) {
							$fy = '2020-2021';
							$acdYear = $fy;
							}
				$date2019 = '2018-12-15';
						//$date1 = '2019-12-01';
						$date = date_create($r->cu_created);
						$array =  (array) $date;
						$date2019st = date("Y-m-d", strtotime($array['date']));
							if($date2019st >= $date2019 && $date2019st <= $date1 && $date2019st <= $date2020) {
							$fy = '2019-2020';
							$acdYear = $fy;
							}
						$datahtml.='<tr>';
						$datahtml.='<td class="caps tbl_rpdf">'.$counter.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$r->application_no.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$r->fullname.$r->middlename.$r->familyname.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$r->email.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$gender.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$r->country_name.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$programmeName.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$regionName.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$r->confirmed_course.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$uniName.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$schemeName.'</td>';
						$datahtml.='<td class="caps tbl_rpdf">'.$acdYear.'</td>';
					    $datahtml.='<br/>';
						$datahtml.='</tr>';	
						$counter++;
						
					}
					
	    $filename='TotalConfirmation.pdf'; //save our workbook as this file name
        header('Content-Type: application/pdf'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

                    $datahtml.= '</tbody>';
					$datahtml.= '</table>';
					$mpdf->WriteHTML($datahtml);	
					$mpdf->Output();

die(json_encode($response));
        //$objWriter->save('php://output');
					
			}
			
			}
catch(\Mpdf\MpdfException $e) {
echo $e->getMessage();
}			
		
		}
	
		function alumini()
	{
		
		$nowtime = time();
		$data['alunamiapplication'] = $this->common_model->getAllAlumaniApplications();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/alumini',$data);
		$this->load->view('admin/footer_main');
	}
	  public function viewAlumaniDetails() {
        try {
            $user_data = $this->session->userdata('user_data');
            $missionId = $user_data['user_country'];
            $appno = $this->uri->segment(3);
            $data['misionData'] = $this->common_model->getMissionInfo($missionId);
            $data['alunamiapplication'] = $this->common_model->getAlumaniApplicationbyId($appno);
            $this->load->view('admin/header_main');
			$this->load->view('admin/leftsidebar');
            $this->load->view('admin/viewAlumaniApplication', $data);
            $this->load->view('admin/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'admin/dashboard');
        }
    }
	function updateMission()
	{
		$resturn = array('status'=>FALSE);
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			$data['id'] = $clean['missionid'];
			$data['state_id'] =  $clean['stat_one'];
		} 
		$sts = $this->common_model->updateMission($data);
		if($sts)
		{
			$resturn['status'] = TRUE;
		}
		else
		{
			$resturn['status'] = FALSE;
		}
		echo json_encode($resturn);
	}
	function createUniversity()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			$data['name'] = $clean['university_name'];
			$data['state'] =  $clean['region'];			
			$data['title'] =  $clean['title'];			
			$data['status'] = $clean['status'];			
			$data['university_type'] =  $clean['university_type']; 
			$data['subject'] =  $clean['subject']; 
		} 
		$sts = $this->common_model->insertUniversity($data);
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Universities Added Successfully!!');
			redirect(site_url().'admin/addUniversity');
			 //echo '<script>window.location.href="'.site_url().'admin/addUniversity?text=Mission Added Successfully!.&type=Success&at=success&redirect='.site_url().'admin/addUniversity";</script>';
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Universities!');
			redirect(site_url().'admin/addUniversity');
			 //echo '<script>window.location.href="'.site_url().'admin/addUniversity?text=Error Occur While Adding Mission!.&type=Error Message&at=danger&redirect='.site_url().'admin/addUniversity";</script>';
		}
	}
	function updateRegion()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $clean['regionId'];
		$data = array('name' => $clean['regionname']);
		$sts = $this->common_model->updateRegion($id, $data);
		if($sts)
		{
			$response['status'] = TRUE;
		}
		else
		{
			$response['status'] = FALSE;
		}
		echo json_encode($response);
	}

	function createRegion()
	{
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{			
			$data['name'] = $clean['regionname'];
			$data['password'] =  substr(sha1(rand()), 0, 8); 
			$data['status'] = 1;			
		} 
		$sts = $this->common_model->insertRegion($data);
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Region Added Successfully!!');
			redirect(site_url().'admin/addRegion');
			 //echo '<script>window.location.href="'.site_url().'admin/addRegion?text=Mission Added Successfully!.&type=Success&at=success&redirect='.site_url().'admin/addRegion";</script>';
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Region!');
			redirect(site_url().'admin/addRegion');
			 //echo '<script>window.location.href="'.site_url().'admin/addRegion?text=Error Occur While Adding Mission!.&type=Error Message&at=danger&redirect='.site_url().'admin/addRegion";</script>';
		}
	}
	function allStudents()
	{
		$data['students'] = $this->common_model->getAllStudents();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/studentList',$data);
		$this->load->view('admin/footer_main');
	}
	function allUniversities()
	{
		$data['universities'] = $this->common_model->getAllUniversities();
		#echo '<pre>';print_r($data);exit;
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/universitiesList',$data);
		$this->load->view('admin/footer_main');
	}
	function allStreams()
	{
		$data['universities'] = $this->common_model->getAllStreams();
		#echo '<pre>';print_r($data);exit;
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/streamList',$data);
		$this->load->view('admin/footer_main');
	}
	function downloadUniversityList()
	{
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Universities');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'Region');
		$this->excel->getActiveSheet()->setCellValue('B2', 'University Name');
        
        $this->excel->getActiveSheet()->getCell('A1')->setValue('Universities');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:B2")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getAllUniversities();
		        $exceldata="";
		foreach ($rs as $row){			
			$myarray = array('Region'=>$row['statename'],'University Name'=>$row['name']);
			$exceldata[] = $myarray;
		}		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                 
        $filename='UniversitiesList.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	function downloadMisionList()
	{
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Missions');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'Country');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Misssion Type');
		$this->excel->getActiveSheet()->setCellValue('C2', 'Mission');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Email Address');
        
        $this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getAllMissions();
		        $exceldata="";
		foreach ($rs as $row){			
			$myarray = array('Country'=>$row['country_name'],'Misssion Type'=>$row['mission_type'],'Mission'=>$row['mission_name'],'Email Address'=>$row['mission_email']);
			$exceldata[] = $myarray;
		}		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='MissionList.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	 public function downloadpdf() {
        try {
			
           
            $content = $this->input->post("myHTML");
            $this->load->library('mpdf60/Mpdf');
            $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
            $mpdf->SetFont('Arial', 'B', 12);
            $mpdf->SetWatermarkText('Indian Council For Cultural Relation');
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Reports</h3><br/>";
            $html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";
            $html = $content;
           

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
        } catch (HTML2PDF_exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'admin/dashboard');
            exit;
        }
    }
	
    function createCaptcha($config = array())
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
	    $image_src = site_url().'admin/getCaptcha?_CAPTCHA&amp;t=' . urlencode(microtime());
	    
	    $cnfg = array('config'=>serialize($captcha_config));
		$this->session->set_userdata('captcha',$cnfg);	
	    return array(
	        'code' => $captcha_config['code'],
	        'image_src' => $image_src
	    );
	}
	function getCaptcha()
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
	public function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    public function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }	
	
	//===============================Added by Rahul Dey 24-01-2019====================================
	public function getFeedbackList()
	{
		$data['feedback'] = $this->common_model->getAllFeedback();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/feedBackList',$data);
		$this->load->view('admin/footer_main');	
	}
	
	function deleteFeedback()
	{
		//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $_REQUEST['feedBackId'];
		
		$sts = $this->common_model->deleteFeedback($id);
		if($sts)
		{
			$response = TRUE;
		}
		else
		{
			 $response = FALSE;
		}
		echo $response;
	}
	
	function editUniversity($university_id=null)
	{
		
		$data['university'] = $this->common_model->getIndividualUniversities($university_id);
		#echo '<pre>';print_r($data);exit;
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/edit_university',$data);
		$this->load->view('admin/footer_main');
	}
	
	
	//vipin
	
		function totalApplicationMission()
	{
		
		$nowtime = time();
		$data['totalApplication'] = $this->common_model->getMissionApplication($nowtime);
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/total_mission_applications',$data);
		$this->load->view('admin/footer_main');
	}
	
	function totalCountryWiseApplication()
	{
		
		//$nowtime = time();
		$data['totalApplication'] = $this->common_model->getCountryWiseMissionApplication();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/total_countrywise_mission_applications',$data);
		$this->load->view('admin/footer_main');
	}
	
	function totalForwordApplicationMission()
	{
		
		$nowtime = time();
		$data['totalApplication'] = $this->common_model->getMissionForwordApplication($nowtime);
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/total_mission_forwordapplications',$data);
		$this->load->view('admin/footer_main');
	}
	
	
	function totalApplicationRo()
	{
		
		$nowtime = time();
		$data['totalApplication'] = $this->common_model->getRoTotalApplication($nowtime);
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/total_ro_applications',$data);
		$this->load->view('admin/footer_main');
	}
	
	
    function downloadTotalMisionApplication()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Missions');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'Country');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Mission');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Total');
        $this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getCountryWiseMissionApplication();
		        $exceldata="";
		
		$allTotal = 0;	
		foreach ($rs as $row){			
			$myarray = array('Country'=>$row['Country'],'Mission'=>$row['mission_name'],'Total'=>$row['Total']);
			$allTotal+=$row['Total'];
			$exceldata[] = $myarray;
		}

		$exceldata[] = array('Country'=>'Total','Mission'=>'','Total'=>$allTotal);
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalCountryWiseApplicationList.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	
	
	
	 function downloadTotalMisionForwordApplication()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Missions');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'Country');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Mission');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Total');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getMissionForwordApplication($nowtime);
		        $exceldata="";
		
		$allTotal = 0;	
		foreach ($rs as $row){			
			$myarray = array('Country'=>$row['country_name'],'Mission'=>$row['mission_name'],'Total'=>$row['Total']);
			$allTotal+=$row['Total'];
			$exceldata[] = $myarray;
		}

		$exceldata[] = array('Country'=>'Total','Mission'=>'','Total'=>$allTotal);
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalMissionForwordApplicationList.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	
	
	
	function downloadTotalRoApplication()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('RO');
        //set cell A1 content with some text
      
       
		$this->excel->getActiveSheet()->setCellValue('A2', 'RO');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Total');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Ro');        
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getRoTotalApplication($nowtime);
		        $exceldata="";
		
		$allTotal = 0;	
		foreach ($rs as $row){			
			$myarray = array('RO'=>$row['RO'],'total'=>$row['total']);
			$allTotal+=$row['total'];
			$exceldata[] = $myarray;
		}

		$exceldata[] = array('Ro'=>'Total','total'=>$allTotal);
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalROApplicationList.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	
	
	function downloadCountryWiseTotalMisionApplication()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Missions');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'Country');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Total');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getCountryWiseMissionApplication();
		        $exceldata="";
		
		$allTotal = 0;	
		foreach ($rs as $row){			
			$myarray = array('Country'=>$row['Country'],'Total'=>$row['Total']);
			$allTotal+=$row['Total'];
			$exceldata[] = $myarray;
		}

		$exceldata[] = array('Country'=>'Total','Total'=>$allTotal);
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalCountryMissionApplicationList.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	function downloadTotalStudentRegister()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Students');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'Country');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Total');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getAllStudents();
		        $exceldata="";
		
		$allTotal = 0;	
		foreach ($rs as $row){			
			$myarray = array('Country'=>$row['country_name'],'Total'=>$row['Total']);
			$allTotal+=$row['Total'];
			$exceldata[] = $myarray;
		}

		$exceldata[] = array('Country'=>'Total','Total'=>$allTotal);
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalStudentRegistered.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	public function reports() {
         $user_data = $this->session->userdata('user_data');
			//echo "<pre>";
			//print_r($user_data);die;
		 $nowtime = time();
		  //$data['totalApplication'] = $this->common_model->getPendingUnderRegionalApplications($nowtime);
		 $this->load->view('admin/header_main');
		 $this->load->view('admin/leftsidebar');
		 $this->load->view('admin/reports');
		 $this->load->view('admin/footer_main');

    }
	 function calcFY($startDate, $endDate) {

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
        $total_years = ($month2 > 4) ? ceil($diff / 12) : floor($diff / 12);

        $fy = array();

        while ($total_years >= 0) {

            $prevyear = $year1 - 1;

            //We dont need 20 of 20** (like 2014)
            //  $fy[] = $prefix.substr($prevyear,-2).'-'.substr($year1,-2);
            $fy[] = $prevyear . '-' . $year1;

            $year1 += 1;

            $total_years--;
        }
        /**
         * If start month is greater than or equal to april, 
         * remove the first element
         */
        if ($month1 >= 4) {
            unset($fy[0]);
        }
        /* Concatenate the array with ',' */
        return $fy;
    }
	 function getFinancialYears($from, $nexttoyears) {
        $currentDate = $from;
        $lastFY = date('Y-m-d', strtotime('+' . $nexttoyears . ' years'));
        return $this->calcFY($currentDate, $lastFY);
    }
	public function getReports() {
        try {
			$vars = $this->input->post();
            $list = $this->common_model->get_datatables($this->ids);
			//echo "<pre>";
            //print_r($list);die;
			
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no;
				$row[] = $customers->application_no;
                $row[] = $customers->fullname;
                if ($customers->gender == 1) {
                    $row[] = "Male";
                } elseif ($customers->gender == 2) {
                    $row[] = "Female";
                } else {
                    $row[] = "Other";
                }
                $row[] = $customers->country_name;
                $uni = $this->common_model->getUniversityById($customers->regional_university);
				//echo "<pre>";print_r($uni);die;
                $r = "";
                $reg1 = $this->common_model->getRegionById($customers->region_one_status);

				$programme = $this->common_model->getProgrammeById($customers->programme);
				$row[] = (!empty($programme) ? $programme[0]['name'] : 'NA');
                $reg1Name = (!empty($reg1) ? $reg1[0]['name'] : 'NA');
                if ($customers->region_one_status == $this->input->post("Region")) {
                    $r .= '<b>' . $reg1Name . '</b><br/>';
                }
				else
				{
					$r .= '<b>' . $reg1Name . '</b><br/>';
				}
                $row[] = $r;
                //$course = $this->common_model->getCoursesById($customers->course);
                //$row[] = $course[0]['title'];
				$row[] = $customers->confirmed_course;

                $u = "";
                $uniName = (!empty($uni) ? $uni[0]['name'] : 'NA');
                if ($customers->regional_university == $this->input->post("Universtiy")) {
                    $u .= '<b>' . $uniName . '</b><br/>';
                }
				else {
                    $u .= $uniName . '<br/>';
                }
                if ($u != "") {
                    $row[] = $u;
                } else {
                    $row[] = "NA";
                }
                $scheme = $this->common_model->getSchemeById($customers->scholarship_id);
                if (!empty($scheme) && $scheme[0]['scheme_name'] != "") {
                    $row[] = $scheme[0]['scheme_name'];
                } else {
                    $row[] = "NA";
                }
				$fn = date('Y-m-d',strtotime($customers->cu_created));
				//echo "<pre>";print_r($customers->cu_created);
				$date1   = '2021-03-15';
				$date2020 = '2019-12-01';
				$date2019 = '2018-12-15';
				$dateObj  = date_create($customers->cu_created);
				$dateArr  = (array) $dateObj;
				$appDate  = date("Y-m-d", strtotime($dateArr['date']));
				if ($appDate >= $date1) {
					$fy = '2021-2022';
				} elseif ($appDate >= $date2020 && $appDate < $date1) {
					$fy = '2020-2021';
				} elseif ($appDate >= $date2019 && $appDate < $date2020) {
					$fy = '2019-2020';
				} else {
					$fy = 'N/A';
				}
				$row[] = $fy;
                //$sts = $this->common_model->getApplicationUnderStatus($customers->status);
                //$row[] = $sts[0]['status'];
				//$row[] = date("Y-m-d",$customers->created);
				$expenditureDatail = $this->common_model->isExpenditureReady($customers->application_no);
				$sts = "";
				if(count($expenditureDatail)>0)
				{								
				
				$sts ="<a class='form-control sbmt1' style='height:35px;width:140px;' href='javascript:void(0);' onclick=showExpenditureList('".$customers->application_no."'); target='_ blank'>View Details</a>";
	
				}
				else
				{
					$sts = "Not Released";
				}
				$row[] = $sts;
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->common_model->count_all($this->ids),
                "recordsFiltered" => $this->common_model->count_filtered($this->ids),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);
        } catch (Exception $e) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    "draw" => isset($_POST['draw']) ? (int)$_POST['draw'] : 0,
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => [],
                    "error" => $e->getMessage()
                ]));
        }
    }

	function expenditureReportofStudent() {
        try {
            $applicationId = $this->uri->segment(3);
			//echo $applicationId;die;
            $user_data = $this->session->userdata('user_data');
           
            $fy = $this->uri->segment(4);
            $yearArray = explode('-', $fy);
            $user_data = $this->session->userdata('user_data');
            $regionid = $user_data['state'];
            $user_data = $this->session->userdata('user_data');
            $regionid = $user_data['state'];
            $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
            $imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];
            } else {
                $image = '';
            }

            $data['userImage'] = $image;
            $data['academicDetails'] = $this->common_model->getAcademicDetailsDataforReport($applicationId);
            $ro = $this->common_model->getTravelPlanArrived($applicationId);
            $regionid = $ro[0]['regional_office_contacted'];
            if(count($regionid)>0)
            {
				$data['regionName'] = $this->common_model->getRegionById($regionid);	
			}
			else
			{
				$data['regionName'] = "";
			}
            
            $data['bankDetails'] = $this->common_model->getBankingDetails($applicationId, "");
            $data['permitDetails'] = $this->common_model->getPermitDetails($applicationId, "");
            $data['advstipendDetails'] = $this->common_model->getAdvStipendByFYofAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['stipendDetails'] = $this->common_model->getStipendByFYByAppno($yearArray[0], $yearArray[1], $applicationId);
            $data['hraDetails'] = $this->common_model->gethraByFYByAppno($yearArray[0], $yearArray[1], $applicationId);
            $data['acaDetails'] = $this->common_model->getACAbyFYByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['studyTourDetails'] = $this->common_model->getStudyTourbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
            $data['MRDetails'] = $this->common_model->getMedicalReimbrusmentbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
            $data['ThesisDetails'] = $this->common_model->getThesisbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
            $data['TravelDetails'] = $this->common_model->getTravelDetailsbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
            $data['ocfDetails'] = $this->common_model->getOCFByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['tfDetails'] = $this->common_model->getTFByByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['hostelDetails'] = $this->common_model->getHostelChargesByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getEnglishBridgeByFY'] = $this->common_model->getEnglishBridgeByappid($yearArray[0], $yearArray[1], $applicationId);
            $data['oreientDetails'] = $this->common_model->getOrientChargesByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getCampsByFY'] = $this->common_model->getCampsByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getISAByFY'] = $this->common_model->getISAByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getSumptuaryByFY'] = $this->common_model->getSumptuaryByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getEmergencyFundByFY'] = $this->common_model->getEmergencyFundByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getStudentDayByFY'] = $this->common_model->getStudentDayByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['getStudentDayByFY'] = $this->common_model->getStudentDayByAppid($yearArray[0], $yearArray[1], $applicationId);
            $data['totalFund'] = $this->common_model->getTotalFundtoRegionbyFY($regionid, $fy);
          
			$this->load->view('admin/header_main');
			//$this->load->view('admin/leftsidebar');
			$this->load->view('admin/viewExpenditureDetailsofStudent',$data);
			$this->load->view('admin/footer_main');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'admin/dashboard');
        }
    }
	 public function downloadAllExpenditureReport() {
        try {
            $appno = $this->uri->segment(3);
            $content = $this->input->post("myHTML");
            $this->load->library('mpdf60/Mpdf');
            $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
            $mpdf->SetFont('Arial', 'B', 12);
            $mpdf->SetWatermarkText('Indian Council For Cultural Relations');
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:15px;font-weight:normal;'>Expenditure Statement of Student </h3><br/>";
            $html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";
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
        } catch (HTML2PDF_exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'admin/dashboard');
            exit;
        }
    }
	public function download_zip($path) {
        $applicationId = $this->uri->segment(3);
        $fy = $this->uri->segment(4);
        $yearArray = explode('-', $fy);
        $bankDetails = $this->common_model->getBankingDetails($applicationId, "");
        if (count($bankDetails) > 0) {
            $path = FCPATH . "assets/site/main/bank_docs/";
            foreach ($bankDetails as $bankDetail) {
                if ($bankDetail['bank_doc'] != "") {
                    $filename = $bankDetail['bank_doc'];
                    $this->load->library('zip');
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $permitDetails = $this->common_model->getPermitDetails($applicationId, "");
        if (count($permitDetails) > 0) {
            $path = FCPATH . "assets/site/main/permit_docs/";
            foreach ($permitDetails as $permit) {
                if ($permit['permit_doc'] != "") {
                    $filename = $permit['permit_doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $advstipendDetails = $this->common_model->getAdvStipendByFYofAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($advstipendDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($advstipendDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $stipendDetails = $this->common_model->getStipendByFYByAppno($yearArray[0], $yearArray[1], $applicationId);
        if (count($stipendDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($stipendDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $hraDetails = $this->common_model->gethraByFYByAppno($yearArray[0], $yearArray[1], $applicationId);
        if (count($hraDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($hraDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $acaDetails = $this->common_model->getACAbyFYByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($acaDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($acaDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $studyTourDetails = $this->common_model->getStudyTourbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
        if (count($studyTourDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($studyTourDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $MRDetails = $this->common_model->getMedicalReimbrusmentbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
        if (count($MRDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($MRDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $ThesisDetails = $this->common_model->getThesisbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
        if (count($ThesisDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($ThesisDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $TravelDetails = $this->common_model->getTravelDetailsbyFYByAppId($yearArray[0], $yearArray[1], $applicationId);
        if (count($TravelDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($TravelDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $ocfDetails = $this->common_model->getOCFByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($ocfDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($ocfDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $tfDetails = $this->common_model->getTFByByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($tfDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($tfDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $hostelDetails = $this->common_model->getHostelChargesByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($hostelDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($hostelDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getEnglishBridgeByFY = $this->common_model->getEnglishBridgeByappid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getEnglishBridgeByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getEnglishBridgeByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $oreientDetails = $this->common_model->getOrientChargesByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($oreientDetails) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($oreientDetails as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getCampsByFY = $this->common_model->getCampsByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getCampsByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getCampsByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getISAByFY = $this->common_model->getISAByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getISAByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getISAByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getSumptuaryByFY = $this->common_model->getSumptuaryByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getSumptuaryByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getSumptuaryByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getEmergencyFundByFY = $this->common_model->getEmergencyFundByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getEmergencyFundByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getEmergencyFundByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getStudentDayByFY = $this->common_model->getStudentDayByAppid($yearArray[0], $yearArray[1], $applicationId);
        if (count($getStudentDayByFY) > 0) {
            $path = FCPATH . "assets/site/main/expenditure_doc/";
            foreach ($getStudentDayByFY as $adstipend) {
                if ($adstipend['doc'] != "") {
                    $filename = $adstipend['doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $getJoiningDoc = $this->common_model->getJoiningDoc($applicationId);
        if (count($getJoiningDoc) > 0) {
            $path = FCPATH . "assets/site/main/joining_doc/";
            foreach ($getJoiningDoc as $joind) {
                if ($joind['joining_doc'] != "") {
                    $filename = $joind['joining_doc'];
                    $this->zip->read_file($path . $filename);
                }
            }
        }
        $this->zip->download($applicationId . '_documents' . '.zip');
    }
	function ajaxfile()
    {
		//echo "sadsad";die;
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];		 	
		$vars = $this->input->post();
		$nowtime = time();
		//print_r($vars['search']['value']);die;
		$studends = $this->hqrs_model->getAllStudents();
		$missionRes = $this->hqrs_model->getMissionApplication();
		$missionFrdAppRes = $this->hqrs_model->getMissionForwordApplication($nowtime);
		$RoTotalApplicationRes = $this->hqrs_model->getRoTotalApplication($nowtime);
		//echo "<pre>";
		//print_r($RoTotalApplicationRes);die;
		$TotalApplicationApplicationForwordMissionRes = $this->hqrs_model->getTotalApplicationForwordMission($nowtime);
		//echo "<pre>";
		//print_r($TotalApplicationApplicationForwordMissionRes);die;
		if(!empty($missionRes)){
			$missiomSum = 0;
			foreach($missionRes as $mr){
				
				$missiomSum+= $mr['Total'];
			}
		}
		if(!empty($RoTotalApplicationRes)){
			$RoTotalApplicationSum = 0;
			foreach($RoTotalApplicationRes as $ro){
				
				$RoTotalApplicationSum+= $ro['total'];
			}
		}
		if(!empty($missionFrdAppRes)){
			$missiomFrdResSum = 0;
			foreach($missionFrdAppRes as $mrps){
				
				$missiomFrdResSum+= $mrps['Total'];
			}
			
		}
		
			if(!empty($TotalApplicationApplicationForwordMissionRes)){
			$TotalApplicationApplicationForwordMissionSum = 0;
			foreach($TotalApplicationApplicationForwordMissionRes as $frdmission){
				
				$TotalApplicationApplicationForwordMissionSum+= $frdmission['Total'];
			}
		}
		//$result = array_merge($result1,$result2);
		//echo "<pre>";
		//print_r($result);die;
		$response = array();
		if(!empty($studends))
		{
			$counter = 1;
			$sum = 0;
			$htm = "<table class='customTable1 table table-striped table-bordered'>";
			foreach($studends as $st)
			{
				$sum+= $st['Total'];
				

				}
				$htm .= "<thead>";
		        $htm .= "<tr>";
				$htm .= "<td>Toal Registered Students : </td><td>".$sum."</td>";
				$htm .= "</tr>";

				$htm .= "<tr>";
				$htm .= "<td>Application Received : </td><td>".$missiomSum."</td>";
				$htm .= "</tr>";

			
				$htm .="</thead>";
      $htm .= "</table>";
      echo $htm;
      exit;
				
				
				
			}
			
			
		}
		
		public function test() {
            $user_data = $this->session->userdata('user_data');
			//echo "<pre>";
			//print_r($user_data);die;
		  $nowtime = time();
		  //$data['totalApplication'] = $this->common_model->getPendingUnderRegionalApplications($nowtime);
		 $this->load->view('admin/header_main');
		 $this->load->view('admin/leftsidebar');
		 $this->load->view('admin/test');
		 $this->load->view('admin/footer_main');

    }
	
		function CountryWiseConfirmation()
	{
		
		$nowtime = time();
		$data['totalApplication'] = $this->common_model->getCountryWiseConfirmation($nowtime);
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/countryWiseConfirmation',$data);
		$this->load->view('admin/footer_main');
	}
	
	  public function downloadTotalConfirmationPdf() {
        ini_set("pcre.backtrack_limit", "1000000");
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 900);
        try {
			$nowtime = time();
            $this->load->library('mpdf60/Mpdf');
            $mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
            $mpdf->SetFont('Arial', 'B', 12);
            $mpdf->SetWatermarkText('Indian Council For Cultural Relations');
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>$title</h3><br/>";
            $html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";
            $html = $content;
            $imgArray = $this->common_model->getUserImage($data[0]['uid']);
			$data['totalApplication'] = $this->common_model->getCountryWiseConfirmation($nowtime);
			$pdf = $this->load->view('admin/countryWiseConfirmationPdf',$data,true);
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
            //$mpdf->WriteHTML($html1, 2);
            $mpdf->WriteHTML($pdf);
            $mpdf->Output();
        } catch (HTML2PDF_exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
            exit;
        }
    }
	
	
	
	public function africanCountry()
		{
			
			try
			{	
			
			    $nowtime = time();
				$user_data = $this->session->userdata('user_data');	
				$clean = $this->input->post(NULL,TRUE);
				$cleanData = $this->security->xss_clean($clean);	
				$data['confirmation'] = $this->admin_model->getTotalAfricaApplicationForwordMission($nowtime);
				//echo "<pre>";
				//print_r($data['confirmation']);die;
				$this->load->view('admin/header_main');
		        $this->load->view('admin/leftsidebar');
		        $this->load->view('admin/africanCountry',$data);
		        $this->load->view('admin/footer_main');
			}
			catch(HTML2PDF_exception $e) {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
				redirect(site_url().'admin/dashboard');
				exit;
			}
			
			
			
			
			
		}
		
		
		 public function downloadTotalafricanConfirmationPdf()
		{
			
				$nowtime = time();
				$confirmation = $this->admin_model->getTotalAfricaApplicationForwordMission($nowtime);
				$this->load->library('mpdf60/Mpdf');
				$mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
				$mpdf->SetFont('Arial', 'B', 12);
				$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
				$mpdf->watermark_font = 'DejaVuSansCondensed';
				$mpdf->showWatermarkText = true;
				$html1 = "<div style='text-align:center;'><img width='300px' src='" . site_url() . "assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Total Confirmation</h3><br/>";
				$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>" . date("jS F Y h:i:s") . "</div>";
				$mpdf->SetDisplayMode('fullpage');			 
				// LOAD a stylesheet
				$stylesheet = file_get_contents('assets/site/main/css/bootstrap.min.css'); 
				//echo $stylesheet;
				$stylesheet1 = file_get_contents('assets/site/main/css/tablepdf.css'); 
				
				$stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
				//$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
				$mpdf->WriteHTML($stylesheet1,1); 
				
				$mpdf->WriteHTML($html1,2);
				
				
				//$rpsdata = $this->main_model->downloadReportData($appno);
				
				
				$datahtml = '';
				$datahtml.= "<table class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;' ><tbody>";
				$datahtml.='<thead>';
				$datahtml.= '<tr>';
				$datahtml.= "<th class='caps' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:10;font-weight:normal;' style='padding:110px;'>S.No</th>";
				$datahtml.="<th class='caps' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:10;font-weight:normal;' style='padding:110px;'>Country</th>";
				$datahtml.="<th class='caps' style='text-align:center;font-family:verdana;margin-bottom:20;margin-top:10;font-weight:normal;' style='padding:110px;'>Total</th>";
				$datahtml.= '<tr>';		
				$datahtml.='<tbody>';
				$counter = 1;
				$sum = 0;
				if(count($confirmation)>0)
				{
					
					foreach($confirmation as $confirm)
					
					{
						
						
						
						$datahtml.='<tr>';
						$datahtml.="<td class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:10;font-weight:normal;' >".$counter."</td>";
						$datahtml.='<td>'.$confirm['country_name'].'</td>';
						$datahtml.='<td>'.$confirm['Total'].'</td>';
					    $datahtml.='<br/>';
						$sum+= $confirm['Total'];
						$datahtml.='</tr>';	
						$counter++;
						
					}
					
					$datahtml.='<td>Total -'.$sum.'</td>';
					$datahtml.= '</tbody>';
					$datahtml.= '</table>';
					$mpdf->WriteHTML($datahtml);	
					$mpdf->Output();
			}
			
				
		
		}
	
	
		function getAfricaReports()
    {
		
    	$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];		
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$data['region'] = $regionid;	 	
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->Regional_model->getRegionalApplications($regionid,$vars);
		
		$totalResult = $this->Regional_model->getRegionalTotalNewApplication($regionid,$vars);
		$response = array();
		$counter++;
		
		if(!empty($result))
		{
			
			foreach($result as $r)
			{
			//echo "<pre>";
		    //print_r($r);
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				//echo "<pre>";
				//print_r($r);die;
					$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				        $gender = "";
				        $output= array();	
				        $output[] = $counter;	
						
				        
						$output[] = $country[0]['country_name'];
									
						
						
			
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
	
	
	function addNotification()	
    {
    	$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addNotification');
		$this->load->view('admin/footer_main');
	}
	function strip_quotes($str)
		{
			return str_replace(array('"',"'",'>','<'), '', $str);
		}
	function allNotification()	
    {
    	$data['notifications'] = $this->common_model->getAllNotifications();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/notificationList',$data);
		$this->load->view('admin/footer_main');
	}
	function editNotification($id)	
    {
		$data['notifications'] = $this->common_model->getAllNotifications($id);
    	$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/editNotification',$data);
		$this->load->view('admin/footer_main');
	}
	function deleteNotification()
	{
		//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $_REQUEST['notificationid'];
		
		$sts = $this->common_model->deleteNotification($id);
		if($sts)
		{
			$response = TRUE;
		}
		else
		{
			 $response = FALSE;
		}
		echo $response;
	}
	function updateNotification()
	{	
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{
			if($_FILES['notification_doc']['name'] != "" &&  $_FILES['notification_doc']['type'] == "application/pdf")
			{
					$fnmae = $_FILES['notification_doc']['name'];
					$tempfile = $_FILES['notification_doc']['tmp_name'];					
					$imgname = time().'_NOTIFICATION_'.$fnmae;					
					$target_file = 'assets/site/main/notification/'.$imgname; 
					move_uploaded_file($tempfile, $target_file);
					$data['notification_doc'] =  $imgname;	
			}else{
				    $data['notification_doc'] =  $clean['old_file'];	
			}	
			$data['title'] = $clean['title'];							
			
			$data['validated_upto'] =  date('Y-m-d',strtotime($clean['validated_upto'])); 
		} 
		$sts = $this->common_model->updateNotification($clean['id'],$data);
		$id = $clean['id'];
		if($sts == 1)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Notification Updated Successfully!!');
			redirect(site_url().'admin/editNotification/'.$id);
			
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Notification!');
			redirect(site_url().'admin/editNotification/'.$id);
			 
		}
	}
	function createNotification()
	{
		
		//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$clean = $this->strip_quotes($this->security->xss_clean($this->input->post(NULL,TRUE)));
		
		$data = array();
		if(count($clean)>0)
		{	
			$data['title'] = $clean['title'];	
			if($_FILES['notification_doc']['name'] != "" &&  $_FILES['notification_doc']['type'] == "application/pdf")
			{
					$fnmae = $_FILES['notification_doc']['name'];
					$tempfile = $_FILES['notification_doc']['tmp_name'];					
					$imgname = time().'_NOTIFICATION_'.$fnmae;					
					$target_file = 'assets/site/main/notification/'.$imgname; 
					move_uploaded_file($tempfile, $target_file);
					$data['notification_doc'] =  $imgname;	
			}			
							
			$data['status'] ='1';			
			$data['created'] = date('Y-m-d'); 
			$data['validated_upto'] = date('Y-m-d',strtotime($clean['validated_upto'])); 
			
		
		} 
		
		$sts = $this->common_model->insertNotification($data);
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Notification Added Successfully!!');
			redirect(site_url().'admin/addNotification');
			
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Notification!');
			redirect(site_url().'admin/addNotification');
			
		}
	}
	
	//Testimonials
	
	function addTestimonials()	
    {
    	$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/addTestimonials');
		$this->load->view('admin/footer_main');
	}
	function createTestimonials()
	{
		
		//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$clean = $this->strip_quotes($this->security->xss_clean($this->input->post(NULL,TRUE)));
		
		$data = array();
		if(count($clean)>0)
		{	
			$data['title'] = $clean['title'];
			$data['testimonials_url'] = $clean['testimonials_url'];
			//echo "<pre>";print_r($_FILES);die;
			if($_FILES['testimonials_doc']['name'] != "" &&  $_FILES['testimonials_doc']['type'] == "application/pdf")
			{
					$fnmae = $_FILES['testimonials_doc']['name'];
					$tempfile = $_FILES['testimonials_doc']['tmp_name'];					
					$imgname = time().'_TESTIMONIALS_'.$fnmae;					
					$target_file = 'assets/site/main/testimonials/'.$imgname; 
					move_uploaded_file($tempfile, $target_file);
					$data['testimonials_file_path'] =  $imgname;	
			}			
			if($_FILES['testimonials_image']['name'] != "" &&  $_FILES['testimonials_image']['type'] == "image/jpeg" ||  $_FILES['testimonials_image']['type'] == "image/jpg" || $_FILES['testimonials_image']['type'] == "image/png")
			{
					$fnmae = $_FILES['testimonials_image']['name'];
					$tempfile = $_FILES['testimonials_image']['tmp_name'];					
					$imgnameProfile = time().'_TESTIMONIALS_'.$fnmae;					
					$target_file = 'assets/site/main/testimonials/'.$imgnameProfile; 
					move_uploaded_file($tempfile, $target_file);
					$data['testimonials_profile_image'] =  $imgnameProfile;	
			}else{
				$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error wrong file format.Please upload only JPEG,JPG,PNG');
			redirect(site_url().'admin/addTestimonials');
			}					
			$data['status'] ='1';			
			$data['created'] = date('Y-m-d'); 
			$data['validated_upto'] = date('Y-m-d',strtotime($clean['validated_upto'])); 
			//echo "<pre>";print_r($data);die;
			
		
		} 
		
		$sts = $this->common_model->insertTestimonials($data);
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Testimonials Added Successfully!!');
			redirect(site_url().'admin/addTestimonials');
			
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Testimonials!');
			redirect(site_url().'admin/addTestimonials');
			
		}
	}
	function allTestimonials()	
    {
    	$data['testimonials'] = $this->common_model->getAllTestimonials();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/testimonialsList',$data);
		$this->load->view('admin/footer_main');
	}
	function editTestimonials($id)	
    {
		$data['notifications'] = $this->common_model->getAllNotifications($id);
    	$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/editNotification',$data);
		$this->load->view('admin/footer_main');
	}
	function deleteTestimonials()
	{
		//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $_REQUEST['notificationid'];
		
		$sts = $this->common_model->deleteNotification($id);
		if($sts)
		{
			$response = TRUE;
		}
		else
		{
			 $response = FALSE;
		}
		echo $response;
	}
	function updateTestimonials()
	{	
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array();
		if(count($clean)>0)
		{
			if($_FILES['notification_doc']['name'] != "" &&  $_FILES['notification_doc']['type'] == "application/pdf")
			{
					$fnmae = $_FILES['notification_doc']['name'];
					$tempfile = $_FILES['notification_doc']['tmp_name'];					
					$imgname = time().'_NOTIFICATION_'.$fnmae;					
					$target_file = 'assets/site/main/notification/'.$imgname; 
					move_uploaded_file($tempfile, $target_file);
					$data['notification_doc'] =  $imgname;	
			}else{
				    $data['notification_doc'] =  $clean['old_file'];	
			}	
			$data['title'] = $clean['title'];							
			
			$data['validated_upto'] =  date('Y-m-d',strtotime($clean['validated_upto'])); 
		} 
		$sts = $this->common_model->updateNotification($clean['id'],$data);
		$id = $clean['id'];
		if($sts == 1)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Notification Updated Successfully!!');
			redirect(site_url().'admin/editNotification/'.$id);
			
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Notification!');
			redirect(site_url().'admin/editNotification/'.$id);
			 
		}
	}
	
	function UniversityWiseConfirmation()
	{
		
		
		$data['totalApplication'] = $this->common_model->getUniversityWiseConfirmApplication();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/total_universities_wise_confirmation',$data);
		$this->load->view('admin/footer_main');
	}
	
	
	function downloadUniversitywiseTotalApplication()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('University');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'University');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Total');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getUniversityWiseConfirmApplication();
		        $exceldata="";
		
		$allTotal = 0;	
		foreach ($rs as $row){			
			$myarray = array('University'=>$row['University'],'Total'=>$row['Total']);
			$allTotal+=$row['Total'];
			$exceldata[] = $myarray;
		}

		$exceldata[] = array('University'=>'Total','Total'=>$allTotal);
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalUniversityWiseConfirmation.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	
	function UniversityWiseRejection()
	{
		
		
		$data['totalApplication'] = $this->common_model->getUniversityWiseRejectApplication();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/total_universities_wise_rejection',$data);
		$this->load->view('admin/footer_main');
	}
	
	
	function downloadUniversitywiseTotalRejection()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('University');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'University');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Total');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getUniversityWiseRejectApplication();
		        $exceldata="";
		
		$allTotal = 0;	
		foreach ($rs as $row){			
			$myarray = array('University'=>$row['University'],'Total'=>$row['Total']);
			$allTotal+=$row['Total'];
			$exceldata[] = $myarray;
		}

		$exceldata[] = array('University'=>'Total','Total'=>$allTotal);
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalUniversityWiseRejection.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	function UniversityWiseReceviedApplication()
	{
		
		
		$data['totalApplication'] = $this->common_model->getUniversityWiseTotalApplication();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/total_universities_wise_application',$data);
		$this->load->view('admin/footer_main');
	}
	
	
	function downloadUniversitywiseTotalReceviedApplication()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('University');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A2', 'University');
        $this->excel->getActiveSheet()->setCellValue('B2', 'Total');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getUniversityWiseTotalApplication();
		        $exceldata="";
		
		$allTotal = 0;	
		foreach ($rs as $row){			
			$myarray = array('University'=>$row['University'],'Total'=>$row['Total']);
			$allTotal+=$row['Total'];
			$exceldata[] = $myarray;
		}

		$exceldata[] = array('University'=>'Total','Total'=>$allTotal);
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalUniversityWiseApplication.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	function getUniversityResponseSentByHqarsToMissiondemo() {      
        $res = array(
            'iccr_status' => 1,
            'status' => 10
        );      
      
        //$data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByHqrsToMission($res);
        $this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/getUniversityResponseSentByHqToMission1',$data);
		$this->load->view('admin/footer_main');
      
    }
	
	
			function downloadTotalConfirmation()
	{
		//echo "<pre>";print_r($data);die;
		//echo "---------------------";die;
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
		$this->excel->getActiveSheet()->setTitle('S.No');
        $this->excel->getActiveSheet()->setTitle('Application No');
		$this->excel->getActiveSheet()->setTitle('Applicant Name');
		$this->excel->getActiveSheet()->setTitle('Gender');
		$this->excel->getActiveSheet()->setTitle('Email');
		$this->excel->getActiveSheet()->setTitle('Country');
		$this->excel->getActiveSheet()->setTitle('Programme');
		$this->excel->getActiveSheet()->setTitle('Regional Office');
		$this->excel->getActiveSheet()->setTitle('Scheme');
		$this->excel->getActiveSheet()->setTitle('Course');
		$this->excel->getActiveSheet()->setTitle('University');
		$this->excel->getActiveSheet()->setTitle('Scheme');
		$this->excel->getActiveSheet()->setTitle('Year');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A1', 'S.No');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Application No');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Applicant Name');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Email');
		$this->excel->getActiveSheet()->setCellValue('E1', 'Gender');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Country');
		$this->excel->getActiveSheet()->setCellValue('G1', 'Programme');
		$this->excel->getActiveSheet()->setCellValue('H1', 'Regional Office');
	    $this->excel->getActiveSheet()->setCellValue('I1', 'Course');
		$this->excel->getActiveSheet()->setCellValue('J1', 'University');
		$this->excel->getActiveSheet()->setCellValue('K1', 'Scheme');
		$this->excel->getActiveSheet()->setCellValue('L1', 'Year');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
			
            $vars = $this->input->post();
			//echo "<pre>";print_r($vars);die;
            $list = $this->common_model->get_datatables($this->ids,$vars);			
		  
		    $exceldata = array();
					//echo "<pre>";
				//print_r($data);die;
		$counter++;
		$counter = 0;
		foreach($list as $r){	
//echo "<pre>";
		//print_r($r);	
			$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r->application_no);
				$country = $this->common_model->getCountryById($r->nationality);
				
			$counter++;
		
		
		if ($r->gender == 1) {
								$gender  = "Male";
								} elseif ($r->gender == 2) {
									$gender  = "Female";
								}
		$programme = $this->common_model->getProgrammeById($r->programme);
		 $reg1 = $this->common_model->getRegionById($r->region_one_status);
		 $regionName = $reg1[0]['name'];
				$programmeName = $programme[0]['name'];
				 $uni = $this->common_model->getUniversityById($r->regional_university);
				$uniName = $uni[0]['name'];
				$sch = $this->common_model->getSchemeById($r->scholarship_id);
                $schemeName= $sch[0]['scheme_name'];
				
				$date1 = '2021-03-15';
						//$date1 = '2019-12-01';
						$date = date_create($r->cu_created);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
							if ($date2 >= $date1) {
							$fy = '2021-2022';
							$acdYear = $fy;
							}
				$date2020 = '2019-12-01';
						//$date1 = '2019-12-01';
						$date = date_create($r->cu_created);
						$array =  (array) $date;
						$date2020st = date("Y-m-d", strtotime($array['date']));
							if($date2020st >=$date2020 && $date2020st <=$date1) {
							$fy = '2020-2021';
							$acdYear = $fy;
							}
				$date2019 = '2018-12-15';
						//$date1 = '2019-12-01';
						$date = date_create($r->cu_created);
						$array =  (array) $date;
						$date2019st = date("Y-m-d", strtotime($array['date']));
							if($date2019st >= $date2019 && $date2019st <= $date1 && $date2019st <= $date2020) {
							$fy = '2019-2020';
							$acdYear = $fy;
							}
			$fullName=$r->fullname." ".$r->middlename." ".$r->familyname;
			$myarray = array('S.No'=>$counter,'Application No'=>$r->application_no,'Applicant Name'=>$fullName,
			'Email' =>$r->email,'Gender'=>$gender, 'Country'=>$r->country_name,'Programme'=>$programmeName,'Regional Office'=>$regionName,'Course'=>$r->confirmed_course,'University'=>$uniName,'Scheme'=>$schemeName,'Year'=>$acdYear);
			$exceldata[] = $myarray;
			
				
		
		}

		
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalConfirmation.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
		//$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
ob_start();
$objWriter->save("php://output");
$xlsData = ob_get_contents();
ob_end_clean();

$response =  array(
        'op' => 'ok',
        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
    );

die(json_encode($response));
        //$objWriter->save('php://output');
	}
	
	public function __destruct() {
    $this->db->close();
    }
	
	//Alumni Excel
	
	
	function downloadAlumniExcel()
	{
		
		$nowtime = time();
		 $this->load->library('excel');
		 $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Missions');
        //set cell A1 content with some text
      
        $this->excel->getActiveSheet()->setCellValue('A1', 'Sr.No');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Application No');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Applicant Name');
		   $this->excel->getActiveSheet()->setCellValue('D1', 'Applicant Mobile');
		 $this->excel->getActiveSheet()->setCellValue('E1', 'Email');
		 $this->excel->getActiveSheet()->setCellValue('F1', 'Country');
		 $this->excel->getActiveSheet()->setCellValue('G1', 'Level of Study');
		 $this->excel->getActiveSheet()->setCellValue('H1', 'Date of Arrival in India');
		 $this->excel->getActiveSheet()->setCellValue('I1', 'Date of Departure in India');
		 $this->excel->getActiveSheet()->setCellValue('J1', 'University');
		  $this->excel->getActiveSheet()->setCellValue('K1', 'Course');
		  $this->excel->getActiveSheet()->setCellValue('L1', 'From');
		  $this->excel->getActiveSheet()->setCellValue('M1', 'To');
		  $this->excel->getActiveSheet()->setCellValue('N1', 'Passing Year');
        //$this->excel->getActiveSheet()->getCell('A1')->setValue('Missions');        
      
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A1:G5")->applyFromArray($border_style1);        
        
      
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
		for($col = ord('A'); $col <= ord('G'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		         //change the font size
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
		         
		        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
		        //retrive contries table data
		        $rs = $this->common_model->getAllAlumaniApplications();
				
				//echo "<pre>";print_r($rs);die;
		        $exceldata="";
		
		$allTotal = 0;	
		$counter = 1;
		foreach ($rs as $row){	

			if($row['unverisity'] == -1)
							{
								$un =  $row['other_unverisity'];
							}
							elseif($row['unverisity'] > 0)
							{
								$uni = $this->common_model->getAlumniUniversityById($row['unverisity']);
								$un = $uni[0]['name'];
							}
			$countries = $this->common_model->getCountryById($row['nationality']);
			
			$courses = $this->common_model->getProgrammeById($row['programme']);
			$arrivalDate = $row['date_of_arrival'];
			$departureDate = $row['date_of_departure'];
			$programeName = $courses[0]['name']; 
			$countryName = $countries[0]['country_name'];
			if($row['course'] == -1)
							{
								$courseName =  $row['other_course'];
							}
							elseif($row['course'] > 0)
							{
								$coursee = $this->common_model->getCoursesById($row['course']);
								if($row['subject'] == '')
								{
									$courseName =  $coursee[0]['title'].'('.$row['subject'].')';
								}
								else
								{
									$courseName =  $coursee[0]['title'];
								}
								
							}
			$myarray = array('Sr.No'=>$counter,'Application No'=>$row['application_id'],'Applicant Name'=>$row['fullname'],'Applicant Mobile'=>$row['phone'],'Email'=>$row['email'],
			'Country'=>$countryName,'Level of Study'=>$programeName,'Date of arrival in India'=>$arrivalDate,'Date of departure in India'=>$departureDate,'University'=>$un,
			'Course'=>$courseName,'From'=>$row['duration_of_course_from'],'To'=>$row['duration_of_course_to'],'Passing Year'=>$row['year_of_passing']);
			$allTotal+=$row['Total'];
			$exceldata[] = $myarray;
			$counter++;
		}

	
		
		 //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
         
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
                 
        $filename='TotalAlumni.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
	
	
	function smsSend()
	{
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/sms');
		$this->load->view('admin/footer_main');
	}
	function sendSMSdemo($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
   
   
   $data_array="{'Account':{'APIKey':null,'User':'demo','Password':'demo','SenderId':'SMPSMS','Channel':'Promo','DCS':'0','FlashSms':0,'SchedTime':null,'GroupId':null,'Route':2},'Messages':[{'Number':'91XXXXXXXX','Text':'Hello google thanks'}]} ";

$make_call = sendSMSdemo('POST','http://a2ascholarships.iccr.gov.in/RestAPI/MT.svc/mt?data=',$data_array);
$response = json_decode($make_call, true);

}

 



			public function sendSMSdemo1()
    {
		
		//echo "<pre>";print_r($_POST);die;
		$mobile_no = $_POST['mobile'];
		$user_name = 'iccr.sms';
        $pin = "V4%26aG4%40wR1";
        $entityId = "110100001364";
        $template_id ="1107161727043527532"; 
		$message = "Dear Sir/Madam,Your letter has been received.For Future communications please refer to the correspondence no 1212121.Regards-Ankita.";
		//$templateId = '1107161727088012984';
        # Log a request
        //$dateTime = Carbon::now()->format('d-M-Y H:i:s a');
        //$log = "Message ( ".$message." ) Sent to ".$mobile_no."";
       // file_put_contents(storage_path().'/logs/smslog.log', $log);
       //$otp_url = "https://sms.innuvissolutions.com/api/mt/SendSMS?Apikey=" . $user_name . "&senderid=" . $sender_id . "&channel=" . $channel . "&DCS=" . $dcs . "&flashsms=" . $flashsms . "&number=" . $number . "&text=" . $text. "&route=" . $route . "&peid=" . $peid ;
        $otp_url = "https://smsgw.sms.gov.in/failsafe/HttpLink?username=" . $user_name . "&pin=" . $pin . "&message=" . urlencode($message) . "&mnumber=" . $mobile_no . "&signature=ICCRAA&dlt_entity_id=".$entityId. "&dlt_template_id=" .$template_id;
  
    $ch = curl_init(); // initialize CURL
    curl_setopt($ch, CURLOPT_POST, false); // Set CURL Post Data
    curl_setopt($ch, CURLOPT_URL, $otp_url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
   if(!$result){die("Connection Failure");}else{
	   echo "Successfully sent.";
   }
   curl_close($ch);
    #dd($output);
    
    return $result;
    }
	
}
        
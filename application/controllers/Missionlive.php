<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mission extends CI_Controller {

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
        //$this->load->library('fpdi/PDF_HTML');  
		$this->load->helper('status_helper');
		$this->load->helper('download');
        $this->load->helper('date');   
        $this->load->model('user_model');     
		$this->load->library('excel'); 
        $this->load->model('common_model');      
        $this->load->model('mission_model');      
        $this->load->helper('file');
         
        $userdata = $this->session->userdata('user_data');     	
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
        		case "ICCR":
				redirect(site_url() . 'headquarter/dashboard');
				break;
				case "Regional Office":
				redirect(site_url() . 'regional/dashboard');
				break;
				case "Super Admin":
				redirect(site_url() . 'admin/dashboard');
				break;
				case "Student":
				redirect(site_url() . 'applicant/dashboard');
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
    public function getNewApplicaitons()
    {
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];
		$misionData = $this->common_model->getMissionInfo($missionId);
    	$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		$result = $this->mission_model->getMissionApplications($vars,$this->ids,$countryid);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->mission_model->getTotalMissionApplications($vars,$this->ids,$countryid);
		
		$response = array();
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				
				
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
				//echo "<pre>";print_r($r);
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				//echo "<pre>";print_r($applicationDetails);die;
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				$gender = "";
				$output= array();	
				$output[] = $counter;
				$output[] = $applicationDetails[0]['application_no'];
				$output[] = $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'].$new;
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
					$course3 = $this->common_model->getCoursesById($applicationDetails[0]['course_fourth']);
					$course4 = $this->common_model->getCoursesById($applicationDetails[0]['course_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					$fullCourse .= $course[0]['title'].' '.$applicationDetails[0]['course_option_name'].'<br/>';
					
					$fullCourse .= $course1[0]['title'].' '.$applicationDetails[0]['course_option_name_two'].'<br/>';
					
					$fullCourse .= $course2[0]['title'].' '.$applicationDetails[0]['course_option_name_three'].'<br/>';
					
					$fullCourse .= $course3[0]['title'].' '.$applicationDetails[0]['course_option_name_fourth'].'<br/>';
					
					$fullCourse .= $course4[0]['title'].' '.$applicationDetails[0]['course_option_name_fifth'].'<br/>';
					$output[] = $fullCourse;
				}
				$universityDetails = "";
				$uni1 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);
				$uni2 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
				$uni3 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
				$uni4 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fourth']);
				$uni5 = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_fifth']);
				$universityDetails .= '1) '.$uni1[0]['name'].'<br/>';
				$universityDetails .= '2) '.$uni2[0]['name'].'<br/>';
				$universityDetails .= '3) '.$uni3[0]['name'].'<br/>';
				$universityDetails .= '4) '.$uni4[0]['name'].'<br/>';
				$universityDetails .= '5) '.$uni5[0]['name'].'<br/>';
				$output[] = $universityDetails;				
				
				
				$date1 = strtotime($applicationDetails[0]['created']);	
				$orgDate = date('d-m-Y', $date1); 
				$output[] = $orgDate;
					
				
				$date2 = $r['SubmitDate'];	
				$output[] = date('d-m-Y',$date2);
				
/* 
				if($applicationDetails[0]['universities_status'] == 23)
				{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt">Process</a>';
				}
				else
				{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" disabled=disabled href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt" >Process</a>';
				} */
				
				
					if($r['universities_status'] == 1)
				{
					
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" title = "hello" href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt">Process</a>';
				}
				else
				{
					//$output[] = 'Not Allowed';
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" title = "This button will be enabled once admission is confirmed by University." href="javascript:void(0);" class="btn btn-block btn-default sbmt disabled">Process</a>';
				} 
				
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'mission/viewfullApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt1" target = "__blank" >View</a>';
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
  
	public function index()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$misionData = $this->common_model->getMissionInfo($missionId);
    	    $countryid = $misionData[0]['country']; 
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['newApplication'] = count($this->common_model->getMissionApplications($this->ids,$countryid));
			$data['approvedApplication'] = count($this->common_model->getMissionsProcessedApplications($this->ids));
			$data['rejectedApplication'] = count($this->common_model->getMissionsRejectedApplications($this->ids));
			$data['results'] = count($this->common_model->getEnglishProficiencyTestResults($this->ids));
			$data['confirmationForwardtoMissionbyHqrs'] = count($this->common_model->getConfirmationofHqrs($this->ids));
			$data['listofacceptance'] = count($this->common_model->getConfirmationofCandidates($this->ids));
			$data['visaendrosment'] = count($this->common_model->getAcceptedCandidates($this->ids));
			$data['travel'] = count($this->common_model->getVisaConveyedApplicatgion($this->ids));
			$data['holdapplications']= count($this->common_model->hold_applications($this->ids));
			$data['pending_application']= count($this->common_model->pending_applications($this->ids));
			$data['resubmitapplication']= count($this->common_model->resubmitapplication($this->ids));
			$this->load->view('mission/header_mission');
			$this->load->view('mission/dashboard',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}	
	public function profile()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			
			
			$postData = $this->input->post(NULL,TRUE);
			if(count($postData)>0)
			{
				$cleanData = $this->security->xss_clean($postData);		
				$status = $this->common_model->updateProfileMission($cleanData);
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
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/profile',$data);
			$this->load->view('mission/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');
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
					$from_email = "yashpal.sharma@velocis.co.in"; 
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
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['head'] = $this->session->userdata('user_data');
			$this->load->view('mission/header_mission');
			$this->load->view('mission/changepassword',$data);
			$this->load->view('mission/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');
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
			$data['controllerBase'] = 'missionlive';
			$this->load->view('mission/header_mission');
			$this->load->view('mission/acceptanceHistory',$data);
			$this->load->view('mission/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	
		public function viewfullApproveApplication()
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
			$this->load->view('mission/header_mission');
			$this->load->view('mission/viewFullApproveApplication',$data);
			$this->load->view('mission/footer');
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
			$this->load->view('mission/header_mission');
			$this->load->view('mission/viewFullApplication',$data);
			$this->load->view('mission/footer');
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
			$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyAppNo($applicationId);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/viewApplication',$data);
			$this->load->view('mission/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	public function pending_application()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['pending_applications']= $this->common_model->pending_applications($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/pending_applications',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
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
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['holdapplications']= $this->common_model->hold_applications($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/hold_applications',$data);
			$this->load->view('mission/footer');
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
			$appno = $this->input->post('appno');
			$status = $this->common_model->holdApplication($appno);
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
			redirect(site_url().'mission/dashboard');
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
	public function new_applications()
	{
		try{
			
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			//$data['newApplication']= $this->common_model->getMissionApplications($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/new_applications',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');	
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
			$this->load->view('mission/instructions');
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
			$user_data = $this->session->userdata('user_data');
			$missionid = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionid);
			$data['approvedApplication'] = $this->common_model->getMissionsProcessedApplications($this->ids);
			//echo "<pre>";print_r($data['approvedApplication']);die;
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
	function rejected_applications()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionid = $user_data['user_country'];
			$data['rejectedApplication'] = $this->common_model->getMissionsRejectedApplications($missionid);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/rejected_applications',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');	
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
			$missionid = $user_data['user_country'];
			//echo "<pre>";
			//print_r($missionid);
			$data['misionData'] = $this->common_model->getMissionInfo($missionid);
		//echo "<pre>";print_r($this->ids);
			$data['travel'] = $this->common_model->getVisaConveyedApplicatgion($this->ids);	
			
			$this->load->view('mission/header_mission');
			$this->load->view('mission/travel_applications',$data);
			$this->load->view('mission/footer');
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
        $this->session->unset_userdata('user_data');
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
			$missionId = $user_data['user_country'];
			
			$misionData = $this->common_model->getMissionInfo($missionId);
    	    $countryid = $misionData[0]['country']; 
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			
			$data['newApplication'] = count($this->common_model->getMissionApplications($this->ids,$countryid));
			

			$data['newCountApplication'] = $this->common_model->getCountMissionApplications($this->ids,$countryid);
			
			//$data['approvedApplication'] = count($this->common_model->getMissionsProcessedApplications($this->ids));
			
			$data['countapprovedApplication'] = $this->common_model->countgetMissionsProcessedApplications($this->ids);
			
			//$data['rejectedApplication'] = count($this->common_model->getMissionsRejectedApplications($this->ids));
			
			//$data['results'] = count($this->common_model->getEnglishProficiencyTestResults($this->ids));
			//$data['confirmationForwardtoMissionbyHqrs'] = count($this->common_model->getConfirmationofHqrs($this->ids));
			
			$data['countconfirmationForwardtoMissionbyHqrs'] = $this->common_model->countgetConfirmationofHqrs($this->ids);
			
			//$data['countconfirmationForwardtoMissionbyHqrsDemo'] = $this->common_model->countgetConfirmationofHqrsDemo($this->ids);
			
			//$data['confirmaitonofuniversityformhqrs'] = count($this->common_model->getConfirmationofFourthOptionByHqrs($this->ids));
			
			//$data['countconfirmaitonofuniversityformhqrs'] = $this->common_model->countgetConfirmationofFourthOptionByHqrs($this->ids);
			
			//$data['listofacceptance'] = count($this->common_model->getConfirmationofCandidates($this->ids));
			
			
			$data['countlistofacceptance'] = $this->common_model->countgetConfirmationofCandidates($this->ids);
			
			//$data['visaendrosment'] = count($this->common_model->getAcceptedCandidates($this->ids));
			
			$data['countvisaendrosment'] = $this->common_model->countgetAcceptedCandidates($this->ids);
			
			//$data['travel'] = count($this->common_model->getVisaConveyedApplicatgion($this->ids));
			
			$data['counttravel'] = $this->common_model->countgetVisaConveyedApplicatgion($this->ids);
			
			
			//$data['holdapplications']= count($this->common_model->hold_applications($this->ids));
			
			//$data['countholdapplications']= $this->common_model->counthold_applications($this->ids);
			
			//$data['pending_application']= count($this->common_model->pending_applications($this->ids));
			
			//$data['countpending_application']= $this->common_model->countpending_applications($this->ids);
			
			//$data['resubmitapplication']= count($this->common_model->resubmitapplication($this->ids));
			
			$data['countresubmitapplication']= $this->common_model->countresubmitapplication($this->ids);
			
			//$data['alumanidata'] = count($this->common_model->getAlumaniApplications($missionId));
			$this->load->view('mission/header_mission');
			$this->load->view('mission/dashboard',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'mission/dashboard');
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
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['visaendrosment'] = $this->common_model->getAcceptedCandidates($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/visaendrosment',$data);
			$this->load->view('mission/footer');
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
	function scholarsvisaGrantendrosment()
	{
		echo "VisaGrant";die;
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
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['listofacceptance'] = $this->common_model->getConfirmationofCandidates($this->ids);
			$data['listofacceptancewithconfirmation'] = $this->common_model->getConfirmationofCandidatesOfferLetter($this->ids);
			//echo "<pre>";print_r($data['listofacceptance']);die;
			$this->load->view('mission/header_mission');
			$this->load->view('mission/listofacceptance',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	
	function visaendrosmentDemo()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['visaendrosment'] = $this->common_model->getAcceptedCandidates($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/visaendrosmentDemo',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
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
			$this->load->view('mission/processConfirmedappfromhqrs',$data);
			$this->load->view('mission/footer');
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
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getConfirmationofHqrs($this->ids);
			//$data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getConfirmationofApplicationIds($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/confirmaitonreceivesformhqrs',$data);
			$this->load->view('mission/footer');
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
	public function downloadDocs(){
		//echo base64_decode($this->uri->segment(3));die;
		$file_name = base64url_decode($this->uri->segment(3));
		fileForceDownload($file_name);
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
			$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year '.$fy[1].'. Mr./Ms. '.$stepOne[0]['fullname'].' is provisionally confirmed for '.$coursename.' course at '.$uninmae[0]['name'].', '.$regionInfo[0]['name'].' subject to production of all original documents at the time of joining','','J');
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
			
			redirect(site_url().'mission/dashboard');
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
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
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
			$pdf->MultiCell(180,5,'Name of Scholarship Scheme : '.$schemename[0]['scheme_name'],'','L');
			$pdf->Ln(5);
		
			$pdf->MultiCell(180,5,'1. I Mr./Ms. '.$stepOne[0]['fullname'].' do hereby affirm that I have understood all the terms & conditions of ICCR\'s scholarship scheme & agree to abide by them for the duration of my study in India under this scholarship.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'2. I confirm that the course .............................................................. being offered to me in .................................................................................................... University/Institute is acceptable to me & that I will not ask for a change of either course or institution. In case I seek for a change of course/Institution after joining the course, I will reimburse the expenditure incurred on me for the previous course.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'3. If admitted to University/Institute which has a residential facility, I undertake to continue to stay in the hostel and not ask for a change from hostel to private accommodation.','','J');		
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'4. If I decide to leave India before the completion of my course, I agree to refund all expenses incurred by ICCR on my behalf.','','J');	
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'5. I certify that I do not suffer from terminal illness or aliments affecting vital organs /certify that I am not in the family way. In case of such illness which requires long absence from course, I agree if I am sent back to my country.','','J');						
			
			
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'6. I agree to abide by and respect role of conduct of the country. In case I get involved in illegal activities and /or events concerning law and order issues, I agree on being deported to my country. ','','J');		
			$pdf->Ln(5);	
			$pdf->SetFont('Arial','B');	
			$pdf->MultiCell(170,5,'Scholar                                                                                                                            Guardian ','','L');	
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Signature   : ............................................','','L');	
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Name        : '.$stepOne[0]['fullname'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Country     : '.$country[0]['country_name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Date          : '.date('d M Y h:i:s'),'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Passport No : ............................................','','L');				
			
			$filename = $applicationId."_UnderTaking_".date('jS-F-Y-h-i-s').'.pdf';
			$pdf->Output($filename,"D");
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
		
	}
	function pending_process()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$applicationId = $this->uri->segment(3);
			$data['applicaitonStepOne']= $this->common_model->getApplicationStepOneByAppno($applicationId);
			$data['applicaitonStepTwo']= $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree']= $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments']= $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['getCheckList'] = $this->common_model->getPendingCheckList($applicationId);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/checklist',$data);
			$this->load->view('mission/footer');
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
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);die;
			$missionId = $user_data['user_country'];
			$applicationId = $this->uri->segment(3);
			$data['applicaitonStepOne']= $this->common_model->getApplicationStepOneByAppno($applicationId);
			$data['applicaitonStepTwo']= $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree']= $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments']= $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['univercities'] = $this->common_model->getAllUnivercities();
			$this->load->view('mission/header_mission');
			$this->load->view('mission/checklist',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
		public function getCourseDetail()
	{
		$postData = $this->input->post(NULL,TRUE);
		$cleanData = $this->security->xss_clean($postData);	
		//echo "<pre>";print_r($cleanData);die;
		echo json_encode($this->common_model->getCourseDetails($cleanData['appid'],$cleanData['uniid']));
	}
   public function getUniversityConfirmDetail()
	{
		$postData = $this->input->post(NULL,TRUE);
		$cleanData = $this->security->xss_clean($postData);	
		//echo "<pre>";print_r($cleanData);die;
		echo json_encode($this->common_model->isAnyUniversityResponseConfirmedOrNot($cleanData['appid'],$cleanData['is_accept']));
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
						'undertaking_doc'=>1,
			  			'status'=>11						
			  		 );
			  		$sts = $this->common_model->uploadUndertaking($applicationId,$data);
			  	  if($sts)
			  	  {
			  	  	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Undertaking Uploaded Successfully!');
					redirect(site_url().'mission/confirmaitonreceivesformhqrs');				  	  	
				  }			  
			  }
			  else{
			  		$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
					redirect(site_url().'mission/undertakingacceptancce/'.$applicationId);	
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
			$mpdf->SetWatermarkText('Indian Council For Cultural Relation');
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
			$mpdf->SetWatermarkText('Indian Council For Cultural Relation');
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
		try
	    {
	    	$appno = $this->uri->segment(3);
	    	$content = $this->input->post("myHTML");
			$mpdf = new Mpdf('s','A4','','',7,7,05,10,10,10);			
			$mpdf->SetFont('Arial','B',9);
			$mpdf->SetWatermarkText('Indian Council For Cultural Relation');
			$mpdf->watermark_font = 'DejaVuSansCondensed';
			$mpdf->showWatermarkText = true;
			$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Application Form For Scholarship through ICCR</h3><br/>";       	 				
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
			$mpdf->SetWatermarkText('Indian Council For Cultural Relation');
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
	public function viewProcessedApplication()
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
			$this->load->view('mission/header_mission');
			$this->load->view('mission/viewProcessedApplication',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured! Try After Some Time');
			redirect(site_url().'mission/dashboard');	
		}		
	}
	public function applicaitonProcess()
	{
		try{
			$referenceNumber = "";$appno = '';
			$user_data = $this->session->userdata('user_data');				
			$missionEmail = $user_data['email'];	
			$imgname = "";			
			if(!empty($_FILES))
			{	
				$files = $_FILES['signature']; 
				
								
				if($files["name"] != "")
				{				
				  $name = str_replace(" ","_",$files['name']);
				  $imgname = time().'_mission_signature_'.$name;
				  
				  $target_file = 'assets/site/main/mission_signature/'.$imgname; 
				  move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file);
			    }
					
			}	
			$checklist = ""; $notSelected = array();$messages_for_mail = "";
			$ocunter = 1;
			$current_checklist = $this->getApplicantCheckList($this->input->post('appid'));			
			for($i=0; $i<count($current_checklist['fulllist']);$i++)
			{				
					if(!array_key_exists('checklist_'.($current_checklist['fulllist'][$i]),$_POST))
					{
						$checklist .= ($current_checklist['fulllist'][$i]) .",";
						array_push($notSelected,($current_checklist['fulllist'][$i]));
						$applicant_checklist = $current_checklist['applicant'];
						if(in_array(($current_checklist['fulllist'][$i]),$applicant_checklist))
						{
							$id = ($current_checklist['fulllist'][$i]);
							$item = $this->common_model->getChecklistItemById($id);
							if($id==2)
							{
								$messages_for_mail .= $ocunter.' Copies of mark sheets not attached.<br/>';	
							}
							if($id==3)
							{
								$messages_for_mail .= $ocunter.' Translated documents missing.<br/>';	
							}
							if($id==5)
							{
								$messages_for_mail .= $ocunter.' Audio/Video clip not uploaded.<br/>';	
							}
							else
							{
								$messages_for_mail .= $ocunter.' '.$item[0]['item'].'<br/>';
							}
							
							$ocunter++;
						}
					}
									
			}
			if($checklist !="")
			{
				$checklist = substr($checklist,0,(strlen($checklist)-1));	
			}
			
			$data['non_xss']= array(
				'application_number' => $this->input->post('appid'),
				'type' => $this->input->post('type'),
				'schloarship_name'=>$this->input->post('schloarship_name'),
				'marks'=>$this->input->post('marks'),
				'mission_name'=>$this->input->post('mission_name'),
				'mission_desg'=>$this->input->post('mission_desg'),
				'mission_place'=>$this->input->post('mission_place'),
				'testmarks'=>$this->input->post('testmarks'),
				'mission_date'=>$this->input->post('mission_date'),
				'mission_cheklist_avail'=>$this->input->post('mission_cheklist_avail'),				
			);
			$data['xss_data'] = $this->security->xss_clean($data['non_xss']);
			if(count($notSelected) > 0)
			{
				$data['xss_data']['checklist_ids'] =  $checklist;
			}  			
			$data['xss_data']['signature'] =  $imgname;
			
			$applicationData = $this->common_model->getApplicationData($data['xss_data']['application_number'],0);
			$userdata = $this->common_model->getUserData($applicationData[0]['uid']);
			//echo "<pre>";print_r($userdata);die;
			$last = $this->common_model->getLastReference();
			//echo "<pre>";print_r($notSelected);
			switch($data['xss_data']['type'])
			{				
				case "Submit Application":	
					if(count($notSelected) > 0)
					{		
						if(in_array("9",$notSelected))	
						{
							$this->common_model->updateApplicationStatusPending($this->input->post('appid'),$applicationData[0]['uid']);
							$update['status'] = 5;
							$update['mission_status'] = 2;
							$update['mission_status_date'] = $data['xss_data']['mission_date'];
							$update['mission_person_name'] = $data['xss_data']['mission_name'];		
							$update['mission_person_designation'] = $data['xss_data']['mission_desg'];		
							$update['mission_person_place'] = $data['xss_data']['mission_place'];		
							$update['mission_person_signature'] = $imgname;							
							$update['english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
							$update['mission_cheklist_avail'] = $data['xss_data']['mission_cheklist_avail'];	
							$update['checklist_ids'] = $data['xss_data']['checklist_ids'];	
							$status = $this->common_model->updateMissionStatus($update,$userId,$data['xss_data']['application_number']);
							$body = "We regret to inform you that you have not met the criteria of selection for award of scholarship.<br/><br/>";
							$mailsend = $this->sendMail($body,$userdata[0]['email_id'],"Your Application could not processed by ICCR.","mail_not_process");
							
							if($status)
							{
								if($mailsend)
								echo json_encode(array('status'=>TRUE,'ref'=>"","message"=>"Rejected","Mail"=>"Sent"));
								else
								echo json_encode(array('status'=>TRUE,'ref'=>"","message"=>"Rejected","Mail"=>"NotSent"));
							}	
							else
								echo json_encode(array('status'=>FALSE,"message"=>"Rejected"));	
							
						}	
						else
							$no = 0;
						$no = (int)$last[0]->appid + 1;
						$rand = $this->random_num(3);
						$referenceNumber = $applicationData[0]['country']."-" .date('Y')."-".$data['xss_data']['schloarship_name']."-".$rand."-".$no; 
						$update['ref_no'] = $referenceNumber;						
						$update['mission_status'] = 1;
						//$update['status'] = 4;
						$update['mission_status_date'] = $data['xss_data']['mission_date'];
						$update['mission_person_name'] = $data['xss_data']['mission_name'];		
						$update['mission_person_designation'] = $data['xss_data']['mission_desg'];		
						$update['mission_person_place'] = $data['xss_data']['mission_place'];		
						$update['mission_person_signature'] = $imgname;	
						$update['scholarship_id'] = $data['xss_data']['schloarship_name'];
						$update['english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
						$update['checklist_ids'] = $data['xss_data']['checklist_ids'];	
						
						$response = $this->common_model->getconfirmationDataforHqrs($this->input->post('appid'));
						$uninmae = $this->common_model->getUniversityStateById($response[0]['regional_university']);
						$schemeId = $this->common_model->getMappingData($this->input->post('appid'));
						$schemename = $this->common_model->getSchemeById($this->input->post('schloarship_name'));
						$status = $this->common_model->updateMissionStatus($update,$userId,$data['xss_data']['application_number']);
						$appid = $this->input->post('appid');
						$confirmData = array(
						'confirmed_to_mission'=>1,
						'reject_reason'=>$this->input->post("reject_reason"),
						'timeline'=>$this->input->post("timeline"),
						);
						$id = $this->input->post("regional_university");
						//echo $id;
						//echo "<pre>";print_r($confirmData);die;
						
						$email_to = $userdata[0]['email_id'];
							
						 $messages = '';                
						  $messages .= '<strong>Hi '.$userdata[0]['username'].',</strong><br><br>';
						 
						  $messages .= "<br/><br/>Mr./Ms. ".$userdata[0]['username'] .", your admission in Course has been provisionally confirmed at University under ".$schemename[0]['scheme_name']."  (".$schemename[0]['code'].").You may login on a2a portal page and accept or reject the offer of admissions with in stipulate time ".$this->input->post("timeline")."(see Timeline).";	
						  $body .= $messages;						
						  $mailsend = $this->sendMail($body,$email_to,"Indian Council for Cultural Relations.","mail_not_process");
					
						$sts = $this->common_model->UpdateToFinalConfirmationToHqrsbyMission($confirmData,$appid,$id);
						$confirmMasterData = array(
						'status'=>11
						);
						$stsMater = $this->common_model->UpdateToFinalConfirmationToHqrsbyMissionStatusMaster($confirmMasterData,$appid,$id);
						//var_dump($sts);die;
						if($sts)
							if($sts){
							
							echo json_encode(array('status'=>TRUE,"message"=>"Approved",'ref'=>$referenceNumber));
							}
						else
							echo json_encode(array('status'=>FALSE,"message"=>"Error"));	
					}	
					
					else
					{
						$no = 0;
						$no = (int)$last[0]->appid + 1;
						$rand = $this->random_num(3);
						$referenceNumber = $applicationData[0]['country']."-" .date('Y')."-".$data['xss_data']['schloarship_name']."-".$rand."-".$no; 
						$update['ref_no'] = $referenceNumber;						
						$update['mission_status'] = 1;
						//$update['status'] = 4;
						$update['mission_status_date'] = $data['xss_data']['mission_date'];
						$update['mission_person_name'] = $data['xss_data']['mission_name'];		
						$update['mission_person_designation'] = $data['xss_data']['mission_desg'];		
						$update['mission_person_place'] = $data['xss_data']['mission_place'];		
						$update['mission_person_signature'] = $imgname;	
						$update['scholarship_id'] = $data['xss_data']['schloarship_name'];
						$update['english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
						$update['checklist_ids'] = $data['xss_data']['checklist_ids'];	
						
						$response = $this->common_model->getconfirmationDataforHqrs($this->input->post('appid'));
						//echo "<pre>";print_r($this->input->post('appid'));die;
						$uninmae = $this->common_model->getUniversityStateById($response[0]['regional_university']);
						//$hqrs = 'pdisd2'
						//$email_to = array(
						//$userdata[0]['email_id']
						//$missionEmail
						//);
						$schemeId = $this->common_model->getMappingData($this->input->post('appid'));
						$schemename = $this->common_model->getSchemeById($this->input->post('schloarship_name'));
						//echo "<pre>";print_r($response);die;
						$status = $this->common_model->updateMissionStatus($update,$userId,$data['xss_data']['application_number']);
						$email_to = $userdata[0]['email_id'];
							//var_dump($status);die;
						   //echo "<pre>";print_r($schemename[0]['scheme_name']);die;
						 $messages = '';                
		          $messages .= '<strong>Hi '.$userdata[0]['username'].',</strong><br><br>';
				  //$messages = "Your application for scholarship could not be processed for the following reasons.<br/><br/>";
				
				  $messages .= "<br/><br/>Mr./Ms. ".$userdata[0]['username'] .", your admission under ".$schemename[0]['scheme_name']."  (".$schemename[0]['code'].") is provisionally confirmed.)";	
						//$body = "Your application for scholarship could not be processed for the following reasons.<br/><br/>";
				  $body .= $messages;	
						//$body .= "<br/><br/>You are being given opportunity to resubmit your applicatin with the mission documents before ".$this->config->item('Mission_Applicant_Pending_Date');					
				  $mailsend = $this->sendMail($body,$email_to,"Indian Council for Cultural Relations.");
				  //var_dump($mailsend);die;
						if($status)
							if($mailsend){
							echo json_encode(array('status'=>TRUE,"message"=>"Approved",'ref'=>$referenceNumber));
							}
						else
							echo json_encode(array('status'=>FALSE,"message"=>"Error"));	
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
		//echo "<pre>";print_r($fulllist);die;
		$applicant_checklist = array("1","2","5","6","9");
		$mission_checklist = array("3","4","8","10","11");
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
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['resubmitapplication']= $this->common_model->resubmitapplication($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/resubmitapplication',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured! Try After Some Time');
			redirect(site_url().'mission/dashboard');
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
		
			public function saveApplicantData()
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
			redirect(site_url().'nission/approved_applications');
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
	
	//Mission Popup
	
		function ajaxfile()
    {
		//echo "sadsad";die;
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];
		$countryid = $misionData[0]['country']; 
		$vars = $this->input->post();
		$nowtime = time();
		//print_r($user_data);die;
		$result = $this->common_model->getCountMissionApplicationsAlert($this->ids);
		//echo "<pre>";
		//print_r($result);die;
		
		$missionFrdAppRes = $this->common_model->getMissionForwordApplicationAlert($this->ids);
		
		
		
		$confirmationReceive = $this->common_model->countgetConfirmationofHqrsAlert($this->ids);
		//$RoTotalApplicationRes = $this->hqrs_model->getRoTotalApplication($nowtime);
		//echo "<pre>";
		//print_r($missionFrdAppRes);die;
		//$TotalApplicationApplicationForwordMissionRes = $this->hqrs_model->getTotalApplicationForwordMission($nowtime);
		//echo "<pre>";
		//print_r($TotalApplicationApplicationForwordMissionRes);die;
		/* if(!empty($result)){
			$missiomSum = 0;
			foreach($result as $mr){
				
				$missiomSum+= $mr['Total'];
			}
		} */
		/* if(!empty($RoTotalApplicationRes)){
			$RoTotalApplicationSum = 0;
			foreach($RoTotalApplicationRes as $ro){
				
				$RoTotalApplicationSum+= $ro['total'];
			}
		} */
	/* 	if(!empty($missionFrdAppRes)){
			$missiomFrdResSum = 0;
			foreach($missionFrdAppRes as $mrps){
				
				$missiomFrdResSum+= $mrps['Total'];
			}
			
		} */
		
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
				$htm .= "<td>Processed Application : </td><td>".$missionFrdAppRes."</td>";
				$htm .= "</tr>";
				
				
				$htm .= "<tr>";
				$htm .= "<td>Confirmation Receieved : </td><td>".$confirmationReceive."</td>";
				$htm .= "</tr>";

				
				$htm .="</thead>";
      $htm .= "</table>";
      echo $htm;
      exit;
				
				
				
			//}
			
			
		}
		
			function alumni_details()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);
			//echo "<pre>";print_r($this->ids);die;
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['alumindetails'] = $this->common_model->getAluminiFiles($this->ids);
			//echo "<pre>";print_r($data['alumindetails']);die;
			$this->load->view('mission/header_mission');
			$this->load->view('mission/alumni_details',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	
				function downloadFile()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);
			//echo "<pre>";print_r($this->ids);die;
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$alumindetails = $this->common_model->getAluminiFiles($this->ids);
			//echo "<pre>";print_r($alumindetails);die;
			if($alumindetails)
				{
				$filename    =   file_get_contents(base_url().$alumindetails[0]['file_path'].'/'.$alumindetails[0]['file_name']."");
				//echo $filename;die;
				$name    =   $alumindetails[0]['file_name'];
				//echo $name;die;
				force_download($name, $filename);     
				}
			/* if(file_exists($filename)) {
			   header('Content-type: application/force-download');
			   header('Content-Disposition: attachment; filename='.$filename);
			   readfile($filename);
			} */
			//echo "<pre>";print_r($data['alumindetails']);die;
			$this->load->view('mission/header_mission');
			$this->load->view('mission/alumni_details',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	
	
	public function createdir($cid)
	{
		$countries = $this->common_model->getCountryById($cid);
		$country = $countries[0]['country_name'];
		$country = str_replace(" ","_",$country);
		$country = str_replace("(","_",$country);
		$country = str_replace(")","_",$country);
		$country = str_replace("&","_and_",$country);
		$country = str_replace("&","_and_",$country);
		$status = FALSE;
		if (!file_exists('assets/site/main/alumini_doc/'.$country)) {
	    	$status = mkdir('assets/site/main/alumini_doc/'.$country, 0777, true);
		}
		return array('status'=>$status,'dir'=>'assets/site/main/alumini_doc/'.$country);
	}
	
	//Alumin Upload
	
		public function uploadAluminiDocs()
		{
			try
			{
				//echo "<pre>";print_r($_FILES);die;
				$user_data = $this->session->userdata('user_data');
			    $missionId = $user_data['user_country'];
				$files = $_FILES['file'];  
				//echo "<pre>";print_r($user_data);die;
				$countryId = $this->common_model->getCountryByMissionId($missionId);
				$countryName = $this->common_model->getCountryById($countryId[0]['country']);
				//echo "<pre>";print_r($countryName);die;
				$typpe = $_FILES['file']['type'];   		
				//echo "<pre>";print_r($user_data);die;
				//$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
				$tempfile = $_FILES['file']['tmp_name'];
				$sizekbb = filesize($tempfile); //10485760= 10mb
				$head = fgets(fopen($tempfile, "r"), 5);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				$nsection = substr($section, 0, 8);
				//echo $nsection;die;
				$frst = strpos($fnmae, ".");
				$sec = strrpos($fnmae, ".");
				$handle = fopen($tempfile, "rb");
				$fsize = filesize($tempfile);
				$contents = fread($handle, $fsize);
				
				$pdf = substr($contents, 0, 4);
				//echo $pdf;die;
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ" && $nsection != "UESDBBQA")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ" && $nsection != "UESDBBQA") 
				{					
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,'message'=>'Invalid File.'));
					return;
				}
				if ($sizekbb > 5242880) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 5MB.'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf" && $typpe != "application/vnd.ms-excel")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				$responseDir = $this->createdir($countryId[0]['country']);
		                if($responseDir['status'] == TRUE)
		                {
							$clean['dir'] = $responseDir['dir'];
						}
						else
						{
							$clean['dir'] = "";
						}
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_alumini_doc_'.$name;
					
					//$countryName[0]['country_name']
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/alumini_doc/'.$countryName[0]['country_name'].'/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						$data = array(
			  			'file_name'=>$imgname,
			  			'file_path'=>$target_file,
			  			'created'=>time(),
			  			'mission_id'=>$missionId,
						'country'=>$countryId[0]['country'],
						'status'=>1
						); 				  	  
						if($this->common_model->insertAluminiDocuments($data))
						{			      	
							echo json_encode(array('status'=>TRUE, 'file_path'=> base_url().$target_file));
						}				  
					}
					else{
						echo json_encode(array('status'=>FALSE,"message"=>"Error While Uploading File!. Try Again Later."));
					}
				}
			}
			catch(Exception $e)
			{
				echo json_encode(array('status'=>FALSE,"message"=>"Error While Uploading File!. Try Again Later."));
			}
		}
	
	
	function openUniversityStatus(){
		
		
		echo openUniversityStatus();
		
	}
	
	
	   	//grant Visa
	
	function processApplication()
    {
		
		//echo '<pre>';
		//print_r($_POST);die;
		//echo $appid;die;
		$appId = $_POST['id'];
		
		$applicanteDetails = $this->mission_model->getApplicantDetails($appId);
		//echo "<pre>";print_r($applicanteDetails);die;
		$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicanteDetails[0]['application_no']);			  
			?>
			
			<table class="table table-bordered">
    <thead>
		
        <th>Name</th>
		<th>Application No</th>
		<th>Email</th>
		
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
		
			
							
						
	  </tr>
	  <?php
					}
				}
				?>
    </tbody>
  </table>
  <?php
			
			  $htm  ="<form action='".site_url().'mission/saveVisaPermission/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			  $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$applicanteDetails[0]['application_no']."'>";
			  $htm .="<div class='form-row'>";
			  $htm .="<div class='form-group'>";
			  $htm .="<label>Visa Grant:</label>";
			  $htm .="<select class='form-control' id ='visa_grant_permission' name='visa_grant_permission'>";
	          $htm .="<option value=''>---Select---</option>";
			 
			  $htm .="<option value='1'>Yes</option>";
				  
			  
			    
				  
			  
			 
			  
			  						 		
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
	
	
	
					public function saveVisaPermission()
	{
		
		try
		{
			//echo "--------------";die;
			$user_data = $this->session->userdata('user_data');
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			//echo $appid;die;
			/* $checkStatus = $this->mission_model->checkStatus($appid);
			if(!$checkStatus){
							$this->session->set_flashdata('message_type', 'error');
					        $this->session->set_flashdata('error', 'You are Not Authorise this.');
							redirect('mission/listofacceptance');
							return false;
			}
			 */
			if(!empty($_POST)){
				 $data = array(
				 'visa_grant_permission'=>$cleanData['visa_grant_permission']
				 );
				 
			 	 $result = $this->mission_model->updateVisaPermission($data,$appid);
				 $response = $this->common_model->getconfirmationDataforHqrs($appid);	
				 $uninmae = $this->common_model->getUniversityStateById($response[0]['regional_university']);
				 $email_to = $userdata[0]['email_id'];
				 $messages = '';                
		         //$messages .= '<strong>Hi '.$userdata[0]['username'].',</strong><br><br>';
				 $messages .= "<br/><br/>Mr./Ms. ".$userdata[0]['username'] .", We are pleased to inform you that have been provisionally selected for ".$coursename." course at ".$uninmae[0]['name'].")";	
				 $messages .= "You are required to report to Scholarshp Division Indian Council For Cultural Relations(ICCR) Delhi or ".$uninmae[0]['name']." along with all original certficates including G.C.E(O\L & A/L) result issued by the Department of Examination,".$country[0]['country_name']."";
				 $body .= $messages;					
				 $mailsend = $this->sendMail($body,$email_to,"Indian Council for Cultural Relations.","mail_not_process");
				 //var_dump($result);die;
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details Saved!');
					redirect(site_url().'mission/listofacceptance');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'mission/listofacceptance');					
				 }
			  
			  
			}	
		}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'nission/approved_applications');
		}
	}
	
	
		//Visa Grant Offer Letter
	
	function offerReceivedWithFormat()
	{
		try
		{
			$doc = array();
			$applicationId = $this->uri->segment(3);
			$uniid = $this->uri->segment(4);
			$response = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$student_registerDate = $this->common_model->getStudentRegistratioYear($applicationId);
			$registerDate = $student_registerDate[0]['created'];
			$studentRegisterYear= date('d-m-Y', $registerDate);
			$compareDate = '15-12-2018';
			$date = date_create($studentRegisterYear);
			$array =  (array) $date;
			$miss = date("Y-m-d", strtotime($array['date']));
			$date1=date_create($miss);
            $date2=date_create($compareDate);
            $diff=date_diff($date1,$date2);
//now convert the $diff object to type integer
            $intDiff = $diff->format("%R%a");
			
            $intDiff = intval($intDiff);
	
			 if ($intDiff > 0){
				 
				 $current  = '15-12-2018';
					$fy = $this->getFinancialYears($current,1);
					 }
                 else 
				 {
					$current = date('d-m-Y');
					$fy = $this->getFinancialYears($current,1);
				 }
			
		
			
			
			
			
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
			
			//$fy = $this->getFinancialYears($current,1);
			
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
			//$pdf->MultiCell(180,5,$mission[0]['mission_type'].': '.$mission[0]['mission_name'],'','L');
			
			//$pdf->MultiCell(180,5,$mission[0]['country_name'],'','L');
			
			$pdf->MultiCell(180,5,'Dear Student','','L');
			
			//$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year '.$fy[1].'. Mr./Ms. '.$stepOne[0]['fullname'].' is provisionally confirmed for '.$coursename.' course at '.$uninmae[0]['name'].', Regional Office '  .$regionInfo[0]['name'].' subject to production of all original documents at the time of joining','','J');
			
			
		    $pdf->Ln(5);		
			$pdf->MultiCell(180,5,'Kindly refer to your application for admission to an Indian University under the above mentioned Scholarshp Scheme.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'1)	We are pleased to inform you that have been provisionally selected for '.$coursename.' course at '.$uninmae[0]['name'].'','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'2)	You are required to report to Scholarshp Division Indian Council For Cultural Relations(ICCR) Delhi or '.$uninmae[0]['name'].' along with all original certficates including G.C.E(O\L & A/L) result issued by the Department of Examination,'.$country[0]['country_name'].'','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'3)	You are also inform that no request for change of course or university will be entertained. Students joining a science course, will have to be bear the expenduture on chemaicals and other incidental charges.You have to give an undertaking that you would undergo AIDS test in India and in case you are found HIV positive you will have to return to '.$country[0]['country_name'].' at your own cost.Hostel facality may be provided, subject to availability. Kindly confirm your acceptance as early as possible (Enclosed Performa) by fax/email(). In case we do not hear anything from you then we will treat that you are no more interested to avail this scholarship. You will also have to give an undertaking that in case you leave the course in between you have to pay all the expences incurred by ICCR. You are advice to carry with you some money (a minimum of Indian Ruppees 35,000\-) to meet incidental expences on arrival in India.','','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'4) 	On arrival in India, You have to register yourself at the Foreigners Regional Registration Office(FRRO). Kindly furnish us the expected date of your depature and details of Journey so that the ICCR is informed well in advance to arrange reception on your arrival in India.','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'6)	Please contact '.$mission[0]['mission_type'].': '.$mission[0]['mission_name'].'this High Commission for any further assistance, including visa etc.','','J');
			$pdf->Ln(5);
			
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Regards,','','L');	
			
			$pdf->MultiCell(170,5,'Your Sincerely','','R');
			
			//$pdf->MultiCell(170,5,'ICCR,'.$regionInfo[0]['name'],'','R');
			
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
		
}

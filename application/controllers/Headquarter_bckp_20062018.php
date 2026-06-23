<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Headquarter extends CI_Controller {

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
        $this->load->library('encrypt');       
        $this->load->helper('date');   
         $this->load->library('zip');
        $this->load->model('user_model');        
        $this->load->model('common_model'); 
        $this->load->library('mpdf60/Mpdf'); 
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
				case "Super Admin":
				redirect(site_url() . 'admin/dashboard');
				break;
				case "Student":
				redirect(site_url() . 'applicant/dashboard');
				break;
			}
		}  
		$division = $userdata['state']; 	
		if($division == 0 || $division == -10 || $division == -20)
		{
			$division = 1;
		}
		$divisionInfo = $this->common_model->getDivisionById($division);
		$arrayIds = array();
		$schemstring  = $divisionInfo[0]['scheme_ids'];
		$schemids = explode(',',$schemstring);		
		$this->ids = $schemids;		
		        
    }
 
    public function complaints()
    {
    	try
    	{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == 0 || $division == 1)
			{
				$data['complaints'] = $this->common_model->getAllComplaints($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/complaints',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
    public function ayushprocess()
    {
		try{	
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
					
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
			$data['univercities'] = $this->common_model->getAYUSHUnivercities();	
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['mappingData'] = $this->common_model->getMappingData($applicationId);		
			$data['listofacceptance'] = $this->common_model->applicantAcceptance($this->ids);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/ayushprocess',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
    public function icarprocess()
    {
		try{	
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
					
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
			$data['listofacceptance'] = $this->common_model->applicantAcceptance($this->ids);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/icarprocess',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	public function ayush_processed()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == -20)
			{
				$data['icar_applications']= $this->common_model->getHQRSAYUSHProcessedApplication($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/ayush_processed',$data);
				$this->load->view('iccr/footer');	
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	public function ayush_applications()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			echo $division;
			if($division == -20)
			{
				$data['ayush_applications']= $this->common_model->getHQRSAYUSHApplication($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/ayush_applications',$data);
				$this->load->view('iccr/footer');	
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function icar_processed()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];		
			if($division == -10)
			{
				$data['icar_applications']= $this->common_model->getHqrsICARProcessedApplication($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/icar_processed',$data);
				$this->load->view('iccr/footer');	
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
		
	}
    public function icar_applications()
    {
    	try
    	{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == -10)
			{
				$data['icar_applications']= $this->common_model->getHqrsICARApplication($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/icar_applications',$data);
				$this->load->view('iccr/footer');	
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
    public function getExpenditureDetails()
    {
    	try
    	{
			$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$schemmesArray = array();
			$regionalArray = array();
			$allAppId = $this->common_model->getAllExpenditureAppId();
			$allSchemes = $this->common_model->getAllSchemes();
			$allregions = $this->common_model->getAllRegions();
			$fy = $clean["fy"];
			$schemes = $clean["schemes"];
			$region = $clean["region"];
			$quarter = $clean["quarter"];
			$qrtMonth = $clean['qrtMonth'];
			foreach($allregions as $regions)
			{
				if(!array_key_exists($regions['id'],$regionalArray))
				{
					$ar = array('id'=>$regions['id'],"r"=>$regions['name'],'schemes'=>array(),'expenditure'=>0);
					$regionalArray[$regions['id']] = $ar;
					
					foreach($allSchemes as $scheme)
					{
						if(!array_key_exists($scheme['id'],$regionalArray[$regions['id']]['schemes']))
						{
							$ar = array('id'=>$scheme['id'],"name"=>$scheme['scheme_name'],'code'=>$scheme['code'],'expenditure'=>0);
							$regionalArray[$regions['id']]['schemes'][$scheme['id']]=$ar;						
						}
					}
				}
			}
			foreach($allSchemes as $scheme)
			{
				if(!array_key_exists($scheme['id'],$schemmesArray))
				{
					$ar = array('id'=>$scheme['id'],'name'=>$scheme['scheme_name'],'code'=>$scheme['code'],'expenditure'=>0);
					$schemmesArray[$scheme['id']] = $ar;
				}
			}
			$aca = $this->common_model->getACAExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$advstipendDetails = $this->common_model->getAdvStipendExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$stipendDetails = $this->common_model->getStipendExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$hraDetails = $this->common_model->gethraExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$studyTourDetails = $this->common_model->getStudyTourExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$MRDetails = $this->common_model->getMedicalReimbrusmentExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$ThesisDetails = $this->common_model->getThesisExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$TravelDetails = $this->common_model->getTravelDetailsExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$tfDetails = $this->common_model->getTFExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$getEnglishBridgeByFY = $this->common_model->getEnglishBridgeExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$hostelDetails = $this->common_model->getHostelChargesExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$oreientDetails = $this->common_model->getOrientChargesExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$getCampsByFY = $this->common_model->getCampsExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$getISAByFY = $this->common_model->getISAExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$getSumptuaryByFY = $this->common_model->getSumptuaryExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$getEmergencyFundByFY = $this->common_model->getEmergencyFundExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			$getStudentDayByFY = $this->common_model->getStudentDayExpenditure($fy,$schemes,$region,$quarter,$qrtMonth);
			
			if(count($aca) > 0)
			{
				foreach($aca as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
				
			if(count($advstipendDetails) > 0)
			{
				foreach($advstipendDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($stipendDetails) > 0)
			{
				foreach($stipendDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($hraDetails) > 0)
			{
				foreach($hraDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($studyTourDetails) > 0)
			{
				foreach($studyTourDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($MRDetails) > 0)
			{
				foreach($MRDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];
					}
				}
			}
			
			if(count($ThesisDetails) > 0)
			{
				foreach($ThesisDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($TravelDetails) > 0)
			{
				foreach($TravelDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($tfDetails) > 0)
			{
				foreach($tfDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($getEnglishBridgeByFY) > 0)
			{
				foreach($getEnglishBridgeByFY as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($hostelDetails) > 0)
			{
				foreach($hostelDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($oreientDetails) > 0)
			{
				foreach($oreientDetails as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($getCampsByFY) > 0)
			{
				foreach($getCampsByFY as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($getISAByFY) > 0)
			{
				foreach($getISAByFY as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($getSumptuaryByFY) > 0)
			{
				foreach($getSumptuaryByFY as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if(count($getEmergencyFundByFY) > 0)
			{
				foreach($getEmergencyFundByFY as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
				
			if(count($getStudentDayByFY) > 0)
			{
				foreach($getStudentDayByFY as $exp)
				{
					if($exp['scheme'] != "")
					{
						$schemmesArray[$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
						$regionalArray[$exp['regionId']]['schemes'][$exp['scheme']]["expenditure"] = $schemmesArray[$exp['scheme']]["expenditure"] + $exp['amount'];	
					}
				}
			}
			
			if($schemes > 0) 
			{
				$schemmesAr = array();$regionalAr = array();
				$schemmesAr[$schemes] = $schemmesArray[$schemes];
				if($region > 0)
				{				
					$regionalAr[$region] = $regionalArray[$region];
					$sr = $regionalArray[$region]['schemes'][$schemes];
					$regionalAr[$region]['schemes'] = array();
					$regionalAr[$region]['schemes'][$schemes] = $sr;
				}	
				else
				{				
					foreach($regionalArray as $key=>$regionAr)
					{					
						$srr = array();
						$srr = $regionAr['schemes'][$schemes];
						$regionAr['schemes'] = array();
						$regionalArray[$key]['schemes'] = $srr; 
					}
				}	
				if($region > 0)
				{				
					echo json_encode(array('region'=>$regionalAr,'schemes'=>$schemmesAr));
				}	
				else
				{
					echo json_encode(array('region'=>$regionalArray,'schemes'=>$schemmesAr));
				}
			}
			else
			{	
				$regionalAr = array();
				if($region > 0)
				{				
					$regionalAr[$region] = $regionalArray[$region];
					echo json_encode(array('region'=>$regionalAr,'schemes'=>$schemmesArray));	
				}	
				else
				{
					echo json_encode(array('region'=>$regionalArray,'schemes'=>$schemmesArray));	
				}	
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
    public function forwardtohqrs()
	{
		try{
			$user_data = $this->session->userdata('user_data');			
			$name = "";
			$appno = $this->uri->segment(3);
			
			if(!empty($_FILES))
			{	
				$files = $_FILES['inputfile_regional']; 
				$imgname = "";
				if($files["name"] != "")
				{				
				  $name = str_replace(" ","_",$files['name']);
				  $imgname = time().'_university_approval_'.$appno.'_'.$name;
				  
				  $target_file = 'assets/site/main/university_approval/'.$imgname; 
				  move_uploaded_file($_FILES["inputfile_regional"]["tmp_name"], $target_file);
			    }	
			}
			$regionsdata = $this->common_model->getUniversityStateById($this->input->post("universty_choice"));
			$data = array(
				'region_one_status'=>$regionsdata[0]['state'],
				'region_one_status_date'=>time(),
				'region_one_doc'=>$imgname,
				'regional_university'=> $this->input->post("universty_choice"),
				'university_is_accept'=> $this->input->post("university_is_accept"),
				'application_id'=>$appno,
				'status'=>9,
				'course'=>$this->input->post("course"),	
			);	
			$sts = $this->common_model->ForwardToHqrsFourthOption($data,$appno);
			if($sts > 0)
			{
				$data1 = array(
					'iccr_status'=>1,					
					'status'=>10
				);
				$sts1 = $this->common_model->ConfirmationForwardToMissionByHqrs($data1,$appno);
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Application Forwarded Successfully !');
				redirect(site_url().'headquarter/dashboard');
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
				redirect(site_url().'headquarter/dashboard');				
			}		
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
    public function status()
    {
		try{	
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
					
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
			$data['listofacceptance'] = $this->common_model->applicantAcceptance($this->ids);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/status',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
    public function universityResponse()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
					
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
			$data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/universityResponse',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
    public function getReports()
    {
    	try
    	{
			$list = $this->common_model->get_datatables($this->ids);
			//print_r($list);
			
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $customers) {
	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = $customers->fullname;  
	            $row[] = $customers->email;
	            if($customers->gender == 1)
	            {
						$row[] = "Male";	
				}
	            elseif($customers->gender == 2)
	            {
						$row[] = "Female";	                      	
				}
				$row[] = $customers->country_name;
	            $uni = $this->common_model->getUniversityById($customers->universty_choice);
	            $uni1 = $this->common_model->getUniversityById($customers->universty_choice_two);
	            $uni2 = $this->common_model->getUniversityById($customers->universty_choice_three);
	            $r = "";
	            $reg1 = $this->common_model->getRegionById($uni[0]['state']);
	            $reg2 = $this->common_model->getRegionById($uni1[0]['state']);
	            $reg3 = $this->common_model->getRegionById($uni2[0]['state']);
	            
	            if($uni[0]['state'] ==  $this->input->post("Region"))
	            {
					 $r .= '<b>'.$reg1[0]['name'].'</b><br/>';
				}
				else
				{
					 $r .= $reg1[0]['name'].'<br/>';
				}
				if($uni1[0]['state'] ==  $this->input->post("Region"))
	            {
					 $r .= '<b>'.$reg2[0]['name'].'</b><br/>';
				}
				else
				{
					 $r .= $reg2[0]['name'].'<br/>';
				}
				if($uni2[0]['state'] ==  $this->input->post("Region"))
	            {
					 $r .= '<b>'.$reg3[0]['name'].'</b><br/>';
				}
				else
				{
					 $r .= $reg3[0]['name'].'<br/>';
				}
				$row[] = $r;
	            $course = $this->common_model->getCoursesById($customers->course);
	            $row[] = $course[0]['title'];
	            
	            $u = "";
	            if($customers->universty_choice == $this->input->post("Universtiy"))
	            {
					$u .= '<b>'.$uni[0]['name'].'</b><br/>';
				}
				else
				{
					$u .= $uni[0]['name'].'<br/>';
				}
				if($customers->universty_choice_two == $this->input->post("Universtiy"))
	            {
					$u .= '<b>'.$uni1[0]['name'].'</b><br/>';
				}
				else
				{
					$u .= $uni1[0]['name'].'<br/>';
				}
				if($customers->universty_choice_three == $this->input->post("Universtiy"))
	            {
					$u .= '<b>'.$uni2[0]['name'].'</b><br/>';
				}
				else
				{
					$u .= $uni2[0]['name'].'<br/>';
				}
	            if($u != "")
	            {
	            	
				   $row[] = $u;
				}
				else
				{
				   $row[] = "NA"; 
				}
	            $scheme = $this->common_model->getSchemeById($customers->scholarship_id);
	            if($scheme[0]['scheme_name'] != "")
	            {
					$row[] = $scheme[0]['scheme_name'];
				}
				else
				{
					$row[] = "NA";
				}
	            $sts = $this->common_model->getApplicationUnderStatus($customers->status);
	            $row[] = $sts[0]['status'];
	            $data[] = $row;
	        }
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->common_model->count_all(),
	                        "recordsFiltered" => $this->common_model->count_filtered($this->ids),
	                        "data" => $data,
	                );
	        //output to json format
	        echo json_encode($output);
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function getCourseByPrgrammeold()
    {
   		$response = array('status'=>FALSE,'data'=>array(),'csrfName'=>'','csrfHash'=>'');	
   		try
   		{	
   			$id=$this->input->post('programme');
	   		$courses = $this->common_model->getCourseByPrgramme($id);
	   		
	   		if(count($courses) > 0)
	   		{
	   			$response['status'] = TRUE;
	   			foreach($courses as $row)
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
    public function studentDetails()
    {		
		try{
			$divs = array(2,3,4,5,6,7,8,9,10);
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
    		if(in_array($division,$divs))
    		{
				$data['newApplication'] = $this->common_model->getHqrsAllNewApplication();
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/studentDetails',$data);
				$this->load->view('iccr/footer');	
			}	
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
    public function reports()
    {
    	try
    	{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division > 0)
			{
				$data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
				$data['schemes'] = $this->ids;
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/reports',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function expenditurereports()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division > 0)
			{
				$current = date('Y-m-d',strtotime('-1 years'));
				$data['fy'] = $this->getFinancialYears($current,4);
				$data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/expenditureReports',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
    public function demands()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == 0 || $division == 1)
			{
				$data['demands'] = $this->common_model->getAllDemands();
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/demands',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	} 
	public function processDemand()
	{
		try
		{
			$data['demandId'] = $this->uri->segment(3);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/createdemand',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function processeddemands()
	{	
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == 0 || $division == 1)
			{
				$data['demands'] = $this->common_model->getAllProcessedDemands();
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/processeddemands',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}		
	}
	
	public function updateDemand()
	{
		try
		{
			$demadArray = array();
			$user_data = $this->session->userdata('user_data');		
			$demandId = $this->uri->segment(3);
			$files = $_FILES['demand_doc'];   
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = $demandId.'_'.time().'_demands_'.$name;		  
			  $target_file = 'assets/site/main/demands/'.$imgname; 
			  if(move_uploaded_file($_FILES["demand_doc"]["tmp_name"], $target_file)) 
			  {		  		
			  	
			  	$demadArray['demand_id'] = $demandId;
			  	$demadArray['status_remarks'] = $this->input->post('remarks');
			  	$demadArray['status'] = $this->input->post('status');
			  	$demadArray['status_doc'] = $imgname;
			  	$demadArray['status_date'] = time();
			  	$sts = $this->common_model->updateDemand($demadArray);
			  	if($sts)
			  	{
					$data['message']['type'] = 1;
					$data['message']['text'] = "Demand Updated Successfully";
					$data['message']['redirect'] = site_url().'regional/demands/';
					$this->load->view("regional/msg",$data);
				}
				else
				{
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error Occur While Updating Demand";
					$data['message']['redirect'] = site_url().'regional/demands/';
					$this->load->view("regional/msg",$data);
				}
		  	  }
		  	  else
			  {
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error Occur While Updating Demand";
					$data['message']['redirect'] = site_url().'regional/demands/';
					$this->load->view("regional/msg",$data);
			  }
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
		
	}
	public function index()
	{
		try
		{
			$data['newapplication'] = $this->common_model->getHqrsNewApplication($this->ids);
			$data['underprocess'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
			$confapps = $this->common_model->getRegionalApplicationsConfirmationtoHqrs($this->ids);
			$confirms = 0;$notconfirms =0;
			if(count($confapps)>0)
			{
				foreach($confapps as $app)
				{
					$response = $this->common_model->getUniversityResponses($app['application_no']);
					$resp = explode(',',$response[0]['response']);
					if($response[0]['response'] != "2,2,2")
					{
						$confirms++;
					}
					elseif($response[0]['response'] == "2,2,2")
					{
						$notconfirms++;
					}
				}
			}			
			$data['confirmationfromROs'] = $confirms;
			$data['confirmationfromallROs']=$notconfirms;			
			$data['acceptance'] = $this->common_model->applicantAcceptance($this->ids);
			$data['studentexpenditure'] = count($this->common_model->getAllStudentsApplications($this->ids));
			$data['demands'] = count($this->common_model->getAllDemands());
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/dashboard',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');		
			redirect(site_url().'headquarter/dashboard');
		}	
	}
	
	public function addfund()
	{
		try
		{
			$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 
			$this->form_validation->set_rules('fin_year', 'Financial Year', 'required');
	        $this->form_validation->set_rules('regiion', 'Region', 'required');	
	        $this->form_validation->set_rules('quarter', 'Quarter', 'required');
	        $this->form_validation->set_rules('amount', 'Amount', 'required');	
	         $actual_link =  $_SERVER['HTTP_REFERER'];
	        if ($this->form_validation->run() == FALSE) { 
	        	$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Invalid Data!');
				redirect(site_url().'headquarter/fundmonitoring');
	        }
			
			$updateData['financial_year'] = $clean['fin_year'];
			$updateData['regional_office'] = $clean['regiion'];
			$updateData['quarter'] = $clean['quarter'];
			$updateData['amount_released'] = $clean['amount'];
			$updateData['created'] = time();
			$fund = $this->common_model->isExistsFund($clean['fin_year'],$clean['regiion'],$clean['quarter']);
			if(count($fund)<=0)
			{
				$status = $this->common_model->insertFund($updateData);
				if($status)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Fund Updated to RO!');
					redirect(site_url().'headquarter/fundmonitoring');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Some Error Occur While Updating Fund!');
					redirect(site_url().'headquarter/fundmonitoring');					
				}
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Fund Already Sent for This Quarter to RO!');
				redirect(site_url().'headquarter/fundmonitoring');				
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function downloadFundMonitoringList()
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
			$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Fund Monitoring List RO and Financial Year Wise</h3><br/>";       	 				
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
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
	        exit;
	    }
	}
	function viewExpenditureDetails()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$fy = $this->uri->segment(3);		
			$yearArray = explode('-',$fy);
			$user_data = $this->session->userdata('user_data');
			$regionid = $this->uri->segment(4);
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['openingBalance'] = $this->common_model->isAlreadyUpdatedbalance($fy,$regionid);
			$data['advstipendDetails'] = $this->common_model->getAdvStipendByFY($yearArray[0],$yearArray[1],$regionid);
			$data['stipendDetails'] = $this->common_model->getStipendByFY($yearArray[0],$yearArray[1],$regionid);
			$data['hraDetails'] = $this->common_model->gethraByFY($yearArray[0],$yearArray[1],$regionid);
			$data['acaDetails'] = $this->common_model->getACAbyFY($yearArray[0],$yearArray[1],$regionid);
			$data['studyTourDetails'] = $this->common_model->getStudyTourbyFY($yearArray[0],$yearArray[1],$regionid);
			$data['MRDetails'] = $this->common_model->getMedicalReimbrusmentbyFY($yearArray[0],$yearArray[1],$regionid);
			$data['ThesisDetails'] = $this->common_model->getThesisbyFY($yearArray[0],$yearArray[1],$regionid);
			$data['MiscDetails'] = $this->common_model->getMiscbyFY($yearArray[0],$yearArray[1],$regionid);
			$data['TravelDetails'] = $this->common_model->getTravelDetailsbyFY($yearArray[0],$yearArray[1],$regionid);
			$data['ocfDetails'] = $this->common_model->getOCFByFY($yearArray[0],$yearArray[1],$regionid);
			$data['tfDetails'] = $this->common_model->getTFByFY($yearArray[0],$yearArray[1],$regionid);
			$data['miscUniDetails'] = $this->common_model->getMiscUniByFY($yearArray[0],$yearArray[1],$regionid);
			$data['getEnglishBridgeByFY'] = $this->common_model->getEnglishBridgeByFY($yearArray[0],$yearArray[1],$regionid);
			$data['hostelDetails'] = $this->common_model->getHostelChargesByFY($yearArray[0],$yearArray[1],$regionid);
			
			$data['oreientDetails'] = $this->common_model->getOrientChargesByFY($yearArray[0],$yearArray[1],$regionid);
			$data['getCampsByFY'] = $this->common_model->getCampsByFY($yearArray[0],$yearArray[1],$regionid);
			$data['getISAByFY'] = $this->common_model->getISAByFY($yearArray[0],$yearArray[1],$regionid);
			$data['getSumptuaryByFY'] = $this->common_model->getSumptuaryByFY($yearArray[0],$yearArray[1],$regionid);
			$data['getEmergencyFundByFY'] = $this->common_model->getEmergencyFundByFY($yearArray[0],$yearArray[1],$regionid);
			$data['getStudentDayByFY'] = $this->common_model->getStudentDayByFY($yearArray[0],$yearArray[1],$regionid);
			
			$data['totalFund'] = $this->common_model->getTotalFundtoRegionbyFY($regionid,$fy);
			$this->load->view('iccr/header_mission');		
			$this->load->view('iccr/viewExpenditureDetails',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function fundmonitoring()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == 0 || $division == 1)
			{
				$current = date('Y-m-d',strtotime('-1 years'));
				$data['fy'] = $this->getFinancialYears($current,9);
				$data['totalFund'] = $this->common_model->getTotalFundtoAllRegion();
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/fundmonitoring',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	function getFinancialYears($from,$nexttoyears)
   {
		$currentDate = $from;
		$lastFY = date('Y-m-d', strtotime('+'.$nexttoyears.' years'));
		return $this->calcFY($currentDate,$lastFY);
   }
	public function viewApplication()
	{
		try{
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
			echo $data['applicaitonStepOne'][0]['uid'];
			
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
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/viewFullApplication',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
		
	}
	function academicDetails()
	{
		try{	
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division > 0)
			{
				$data['allarrived'] = $this->common_model->getAcademicDetailsForhqrs($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/academicDetails',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}		
			
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function viewAlumaniDetails()
	{
		try{
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
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	function alumani()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division > 0)
			{
				$data['alunamiapplication']= $this->common_model->getAllAlumaniApplications();
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/alumani',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
			
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	function createregionalExpenditure()
	{
		try
		{
			$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 	
			$status = $this->common_model->createregionalExpenditure($clean);		
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	function expenditureReportofStudent()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$fy = $this->uri->segment(4);		
			$yearArray = explode('-',$fy);
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
			if(count($imgArray)> 0)
			{
				$image = $imgArray[0]['name'];
			}		
			else
			{
				$image = '';
			}
			
			$data['userImage'] = $image;
			$data['academicDetails'] = $this->common_model->getAcademicDetailsDataforReport($applicationId);
			$data['bankDetails'] = $this->common_model->getBankingDetails($applicationId,"");
			$data['permitDetails'] = $this->common_model->getPermitDetails($applicationId,"");
			$data['advstipendDetails'] = $this->common_model->getAdvStipendByFYofAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['stipendDetails'] = $this->common_model->getStipendByFYByAppno($yearArray[0],$yearArray[1],$applicationId);
			$data['hraDetails'] = $this->common_model->gethraByFYByAppno($yearArray[0],$yearArray[1],$applicationId);
			$data['acaDetails'] = $this->common_model->getACAbyFYByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['studyTourDetails'] = $this->common_model->getStudyTourbyFYByAppId($yearArray[0],$yearArray[1],$applicationId);
			$data['MRDetails'] = $this->common_model->getMedicalReimbrusmentbyFYByAppId($yearArray[0],$yearArray[1],$applicationId);
			$data['ThesisDetails'] = $this->common_model->getThesisbyFYByAppId($yearArray[0],$yearArray[1],$applicationId);
			$data['TravelDetails'] = $this->common_model->getTravelDetailsbyFYByAppId($yearArray[0],$yearArray[1],$applicationId);
			$data['ocfDetails'] = $this->common_model->getOCFByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['tfDetails'] = $this->common_model->getTFByByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['hostelDetails'] = $this->common_model->getHostelChargesByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['getEnglishBridgeByFY'] = $this->common_model->getEnglishBridgeByappid($yearArray[0],$yearArray[1],$applicationId);
			$data['oreientDetails'] = $this->common_model->getOrientChargesByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['getCampsByFY'] = $this->common_model->getCampsByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['getISAByFY'] = $this->common_model->getISAByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['getSumptuaryByFY'] = $this->common_model->getSumptuaryByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['getEmergencyFundByFY'] = $this->common_model->getEmergencyFundByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['getStudentDayByFY'] = $this->common_model->getStudentDayByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['getStudentDayByFY'] = $this->common_model->getStudentDayByAppid($yearArray[0],$yearArray[1],$applicationId);
			$data['totalFund'] = $this->common_model->getTotalFundtoRegionbyFY($regionid,$fy);
			$this->load->view('iccr/header_mission');		
			$this->load->view('iccr/viewExpenditureDetailsofStudent',$data);
			$this->load->view('iccr/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function downloadAllExpenditureReport()
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
			$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:15px;font-weight:normal;'>Expenditure Statement of Student </h3><br/>";       	 				
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
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
	        exit;
	    }
	}
	public function regionalExpenditure()
	{
		try{
			$data['newApplication'] = $this->common_model->getHqrsNewApplication();
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/new_applications',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
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
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
	        exit;
	    }
	}
	public function applicantExpenditure()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
    		if($division >= 0)
    		{
				$current = date('Y-m-d');
				$current1 = date('Y-m-d',strtotime('-8 years'));
				$data['fy'] = $this->getFinancialYears($current,1);
				$data['ofy'] = $this->getFinancialYears($current,5);
				$data['studentexpenditure'] = $this->common_model->getAllStudentsApplications($this->ids);
				$data['studentexpenditureold'] = $this->common_model->getOldReceivedApplication($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/studentExpenditurelist',$data);
				$this->load->view('iccr/footer');	
			}	
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function new_applications()
	{		
		try{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
    		if($division == 1)
    		{
				$data['newApplication'] = $this->common_model->getHqrsNewApplication($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/new_applications',$data);
				$this->load->view('iccr/footer');	
			}	
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function forward()
	{
		$appno = $this->uri->segment(3);
		try{
			$status = $this->common_model->ApplicationForwardFromHeadquarter($appno);
			if($status)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Application Forwarded to RO Successfully!');
				redirect(site_url().'headquarter/new_applications');				
			}			
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function underprocess()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == 1)
			{
				$data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/underprocess',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function confirmationfromallROs()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == 1)
			{
				$data['confirmationfromROs'] = $this->common_model->getRegionalApplicationsConfirmationtoHqrs($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/confirmationfromallROs',$data);
				$this->load->view('iccr/footer');
			}	
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	function savenotconfirmedcourse()
	{
		$sts1 = 0;
		$appno = $this->uri->segment(3);
		$unid = $this->uri->segment(4);
		$postData = $this->input->post(NULL,TRUE);
		$data = array(
			'iccr_status'=>1,					
			'status'=>10
		);
		$data1 = array(
			'reason'=>$postData['reason'],
			'application_id'=>$appno,
			'regional_university'=>$unid
		);
		$sts1 = $this->common_model->NOTConfirmationofCourseToMissionByHqrs($data1,$appno);	
		$sts = $this->common_model->ConfirmationForwardToMissionByHqrs($data,$appno);	
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
			redirect(site_url().'headquarter/confirmationfromROs');				
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
			redirect(site_url().'headquarter/confirmationfromROs');					
		}
	}
	function saveconfirmedcourse()
	{
		$sts1 = 0;
		$appno = $this->uri->segment(3);
		$unid = $this->uri->segment(4);
		$postData = $this->input->post(NULL,TRUE);
		$data = array(
			'iccr_status'=>1,					
			'status'=>10
		);
		$data1 = array(
			'course'=>$postData['confirmedCourse'],
			'application_id'=>$appno,
			'regional_university'=>$unid
		);
		$sts1 = $this->common_model->ConfirmationofCourseToMissionByHqrs($data1,$appno);	
		$sts = $this->common_model->ConfirmationForwardToMissionByHqrs($data,$appno);	
		if($sts)
		{
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
			redirect(site_url().'headquarter/confirmationfromROs');				
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
			redirect(site_url().'headquarter/confirmationfromROs');					
		}
	}
	public function beforerejectiontoMission()
	{
		$applicationId = $this->uri->segment(3);	
		$user_data = $this->session->userdata('user_data');
					
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
			$data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
		
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/beforerejectiontoMission',$data);
			$this->load->view('iccr/footer');
	}
	public function beforeconfirmtoMission()
	{
		$applicationId = $this->uri->segment(3);	
		$user_data = $this->session->userdata('user_data');
					
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
			$data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
		
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/beforeconfirmtoMission',$data);
			$this->load->view('iccr/footer');
	}
	public function confirmationfromROs()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == 1)
			{
				$data['confirmationfromROs'] = $this->common_model->getRegionalApplicationsConfirmationtoHqrs($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/confirmationfromROs',$data);
				$this->load->view('iccr/footer');
			}	
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}		
	}
	public function instructions()
	{
		try{
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/instructions');
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function ro_guidlines()
	{
		try{
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/regional_guidlines');
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function applicant_guidlines()
	{
		try{
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/applicant_guidlines');
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	public function mission_guidlines()
	{
		try{
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/mission_guidlines');
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}	
	public function hqrs_guidlines()
	{
		try{
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/hqrs_guidlines');
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
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
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	
	function travel_applications()
	{
		try{
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/travel_applications');
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}	
	public function applicationForm()
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
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/applicationForm',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
		
	}	
	public function contactForm()
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
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/contactForm',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
		
	}
	public function profile()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');		
			$postData = $this->input->post(NULL,TRUE);
			if(count($postData)>0)
			{
				$cleanData = $this->security->xss_clean($postData);		
				$profileData = array(
					'uid'=>$cleanData['id'],
					'mobile_no'=>$cleanData['mobile_no'],
					'office_address'=>$cleanData['office_address'],
					'telephone_number'=>$cleanData['telephone_number'],
					'fax_number'=>$cleanData['fax_number']
				);
				$userData = array(
					'username'=>$cleanData['username'],
					'id'=>$cleanData['id']				
				);
				$status = $this->common_model->updateProfileHeadquarter($profileData);
				$status1 = $this->common_model->updateProfileHeadquarterName($userData);
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
			$data['head'] = $this->common_model->getHeadquarterInfo($user_data['uid']);			
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/profile',$data);
			$this->load->view('iccr/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}	
	public function changepassword()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');	
			$postData = $this->input->post(NULL,TRUE);
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
			$data['head'] = $this->session->userdata('user_data');
			$data['salt'] = $this->random_string();
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/changepassword',$data);
			$this->load->view('iccr/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
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
	public function logout()
    {
        $this->session->unset_userdata('user_data');
        $this->session->unset_userdata('salt');
        $this->session->sess_destroy();
        redirect('home');
    }	
	public function dashboard()
	{
		try{
			//$missionid =1;
			$data['newapplication'] = $this->common_model->getHqrsNewApplication($this->ids);
			$data['underprocess'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
			$data['students'] = count($this->common_model->getHqrsAllNewApplication($this->ids));
			$confapps = $this->common_model->getRegionalApplicationsConfirmationtoHqrs($this->ids);
			$confirms = 0;$notconfirms =0;
			if(count($confapps)>0)
			{
				foreach($confapps as $app)
				{
					$response = $this->common_model->getUniversityResponses($app['application_no']);
					$resp = explode(',',$response[0]['response']);
					if($response[0]['response'] != "2,2,2")
					{
						$confirms++;
					}
					elseif($response[0]['response'] == "2,2,2")
					{
						$notconfirms++;
					}
				}
			}			
			$data['confirmationfromROs'] = $confirms;
			$data['confirmationfromallROs']=$notconfirms;
			
			$data['acceptance'] = $this->common_model->applicantAcceptance($this->ids);
			
			$data['studentexpenditure'] = array();//count($this->common_model->getAllStudentsApplications($this->ids));
			$data['alunamiapplication']= count($this->common_model->getAllAlumaniApplications());			
			$data['icar_applications']= count($this->common_model->getHqrsICARApplication($this->ids));
			$data['icar_processed']= count($this->common_model->getHqrsICARProcessedApplication($this->ids));
			
			$data['ayush_applications']= count($this->common_model->getHQRSAYUSHApplication($this->ids));
			$data['ayush_processed']= count($this->common_model->getHQRSAYUSHProcessedApplication($this->ids));
			
			$data['demands'] = count($this->common_model->getAllDemands());
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/dashboard',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
		}
	}
	function savefourthchoice()
	{
		$applicationId = $this->uri->segment(3);
	}
	function processfourthchoice()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
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
			$data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/processfourthchoice',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
		
	}
	function forwardtoMission()
	{
		try
		{
			$appno = $this->uri->segment(3);
			$data = array(
				'iccr_status'=>1,					
				'status'=>10
			);
			$sts = $this->common_model->ConfirmationForwardToMissionByHqrs($data,$appno);	
			if($sts)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
				redirect(site_url().'headquarter/confirmationfromROs');				
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
				redirect(site_url().'headquarter/confirmationfromROs');					
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}	
	}
	function payexpendituretoregion()
	{
		try{
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/payexpendituretoregion');
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	
	function applicantAcceptanceStatus()
	{
		try{			
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
					
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
			$data['listofacceptance'] = $this->common_model->applicantAcceptance($applicationId);
			$data['universityData'] = $this->common_model->getConfirmationofApplicationIds($applicationId);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/applicantAcceptanceView',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			show_404();
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	function viewAcademicdetialsold()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$data['academic'] = $this->common_model->getAcademicDataforReport($applicationId);
			$data['academicStatus'] = $this->common_model->getAcademicStatusDataforReport($applicationId);
			$data['academic_data'] = $this->common_model->getAcademicDataforReport($applicationId);
			//$data['scholarship'] = $this->common_model->getScholarshipStatusDataforReport($applicationId);
			//$data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/accademicReportofOldStudent',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	function viewAcademicdetials()
	{
		try
		{
			$applicationId = $this->uri->segment(3);
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			$data['mapdata'] = $this->common_model->getMappingData($applicationId);
			$data['academic'] = $this->common_model->getAcademicStatusDataforReport($applicationId);
			$data['academic_data'] = $this->common_model->getAcademicDataforReport($applicationId);
			//$data['scholarship'] = $this->common_model->getScholarshipStatusDataforReport($applicationId);
			$userId = $data['applicaitonStepOne'][0]['uid'];
			$data['universityData'] = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$imgArray = $this->common_model->getUserImage($userId);
			if(count($imgArray)> 0)
			{
				$data['userImage'] = $imgArray[0]['name'];
			}		
			else
			{
				$data['userImage'] = '';
			}
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/accademicReportofStudent',$data);
			$this->load->view('iccr/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	function applicantAcceptance()
	{
		try{			
			$user_data = $this->session->userdata('user_data');
			$division = $user_data['state'];
			if($division == 1)
			{
				$data['listofacceptance'] = $this->common_model->applicantAcceptance($this->ids);
				$this->load->view('iccr/header_mission');
				$this->load->view('iccr/listofacceptance',$data);
				$this->load->view('iccr/footer');
			}
			else
			{
				$this->load->view('iccr/header_mission');
				$this->load->view('errors/html/error_403');
				$this->load->view('iccr/footer');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	function confirmationForwardtoMissionbyHqrs()
	{
		try{			
			$data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getconfirmationForwardtoMissionbyHqrs();
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/confirmationForwardtoMissionbyHqrs',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	public function application()
	{
		try
		{
			$applicationId = $this->uri->segment(3);				
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
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();		
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if(count($data['applicaitonStepOne'])>0)
			{
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			}
			else
			{
				$data['get_application_number'] = $this->random_num(15);
			}
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);			
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/applicant_personal_info',$data);
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');	
		}
	}
	function Expenditure()
	{
		try{
			$this->load->view('iccr/header_mission');
			$this->load->view('iccr/expenditure');
			$this->load->view('iccr/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
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
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url().'headquarter/dashboard');
	        exit;
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
   public function base64url_encode($data)
   {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
   }
   public function base64url_decode($data)
   {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
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
	public function download_zip($path)
	{	
		$applicationId = $this->uri->segment(3);		
		$fy = $this->uri->segment(4);		
		$yearArray = explode('-',$fy);
		$bankDetails = $this->common_model->getBankingDetails($applicationId,"");
		if(count($bankDetails)>0)
		{
			$path = FCPATH."assets/site/main/bank_docs/";
			foreach($bankDetails as $bankDetail)
			{
				if($bankDetail['bank_doc'] != "")
				{
					$filename =  $bankDetail['bank_doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$permitDetails = $this->common_model->getPermitDetails($applicationId,"");
		if(count($permitDetails)>0)
		{
			$path = FCPATH."assets/site/main/permit_docs/";
			foreach($permitDetails as $permit)
			{
				if($permit['permit_doc'] != "")
				{
					$filename =  $permit['permit_doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}		
		$advstipendDetails = $this->common_model->getAdvStipendByFYofAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($advstipendDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($advstipendDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$stipendDetails = $this->common_model->getStipendByFYByAppno($yearArray[0],$yearArray[1],$applicationId);
		if(count($stipendDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($stipendDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$hraDetails = $this->common_model->gethraByFYByAppno($yearArray[0],$yearArray[1],$applicationId);
		if(count($hraDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($hraDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$acaDetails = $this->common_model->getACAbyFYByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($acaDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($acaDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$studyTourDetails = $this->common_model->getStudyTourbyFYByAppId($yearArray[0],$yearArray[1],$applicationId);
		if(count($studyTourDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($studyTourDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$MRDetails = $this->common_model->getMedicalReimbrusmentbyFYByAppId($yearArray[0],$yearArray[1],$applicationId);
		if(count($MRDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($MRDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$ThesisDetails = $this->common_model->getThesisbyFYByAppId($yearArray[0],$yearArray[1],$applicationId);
		if(count($ThesisDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($ThesisDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$TravelDetails = $this->common_model->getTravelDetailsbyFYByAppId($yearArray[0],$yearArray[1],$applicationId);
		if(count($TravelDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($TravelDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$ocfDetails = $this->common_model->getOCFByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($ocfDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($ocfDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$tfDetails = $this->common_model->getTFByByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($tfDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($tfDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$hostelDetails = $this->common_model->getHostelChargesByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($hostelDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($hostelDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$getEnglishBridgeByFY = $this->common_model->getEnglishBridgeByappid($yearArray[0],$yearArray[1],$applicationId);
		if(count($getEnglishBridgeByFY)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($getEnglishBridgeByFY as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$oreientDetails = $this->common_model->getOrientChargesByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($oreientDetails)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($oreientDetails as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$getCampsByFY = $this->common_model->getCampsByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($getCampsByFY)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($getCampsByFY as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$getISAByFY = $this->common_model->getISAByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($getISAByFY)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($getISAByFY as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$getSumptuaryByFY = $this->common_model->getSumptuaryByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($getSumptuaryByFY)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($getSumptuaryByFY as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$getEmergencyFundByFY = $this->common_model->getEmergencyFundByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($getEmergencyFundByFY)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($getEmergencyFundByFY as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
		$getStudentDayByFY = $this->common_model->getStudentDayByAppid($yearArray[0],$yearArray[1],$applicationId);
		if(count($getStudentDayByFY)>0)
		{
			$path = FCPATH."assets/site/main/expenditure_doc/";
			foreach($getStudentDayByFY as $adstipend)
			{
				if($adstipend['doc'] != "")
				{
					$filename =  $adstipend['doc'];
					$this->zip->read_file($path.$filename);
				}
			}
		}
	    $this->zip->download($applicationId.'_documents'.'.zip');
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');	
        $this->load->library('encrypt');
        $this->load->helper('date');      
        $this->load->model('user_model');
        $this->load->model('common_model');
    } 
    public function createdir($email,$cid,$year)
	{
		$countries = $this->common_model->getCountryById($cid);
		$country = $countries[0]['country_name'];
		$country = str_replace(" ","_",$country);
		$country = str_replace("(","_",$country);
		$country = str_replace(")","_",$country);
		$country = str_replace("&","_and_",$country);
		$country = str_replace("&","_and_",$country);
		
		$email = str_replace(".","_",$email);
		$email = str_replace("@","_at_",$email);
		$email .= "_".$year;
		$status = FALSE;
		if (!file_exists('assets/site/main/applications_doc/'.$country)) {
	    	mkdir('assets/site/main/applications_doc/'.$country, 0777, true);
		}
		if (!file_exists('assets/site/main/applications_doc/'.$country."/".$email)) {
	    	$status = mkdir('assets/site/main/applications_doc/'.$country."/".$email, 0777, true);
		}
		return array('status'=>$status,'dir'=>'assets/site/main/applications_doc/'.$country."/".$email);
	}
		public function login()
	{
		try
		{
			$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('pass', 'Password', 'required');	
			$year = date("Y");
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        } else {
	            $post     = $this->input->post();
	            $clean    = $this->security->xss_clean($post);
	            if($this->isValidCaptch($clean['captchatext']))
	            {
					$userType = $this->user_model->checkType($clean);
					if($clean['year']!= '' && !empty($clean['year']) && $userType->user_type == 1)
					{
						$userInfo = $this->user_model->checkLoginYear($clean,$clean['year']);
						//echo "<pre>";print_r($userInfo);die;
						$userAyushLastDateSubmit = $this->user_model->checkAyushSubmitDetails($userInfo->id);
						var_dump($userAyushLastDateSubmit);die;
						if($clean['year']!= '' && !empty($clean['year']) && $clean['course_type'] == 1)
						{
							if($userInfo->apply_course_type == '' || $userAyushLastDateSubmit->status == 'Draft' || $userAyushLastDateSubmit == false){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Sorry You are Not allowed');
							redirect($actual_link);
							return false;
						}
						}
						elseif($userInfo)
						{
							//echo "<pre>";print_r($userInfo);die;
							$userAyushLastDateSubmit = $this->user_model->checkAyushSubmitDetails($userInfo->id);
							$userLastDateSubmit = $this->user_model->checkSubmitDetails($userInfo->id);
							//var_dump($userAyushLastDateSubmit);die;
							if($userInfo->student_type == 2)
							{
								 if($userLastDateSubmit->status == 'Draft' || $userInfo->apply_course_type == 1 || $userInfo->apply_course_type == '')
							{
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error','!');
								redirect($actual_link);
								return false;
								
							}
							}else{
								 if($userLastDateSubmit->status == 'Draft' || $userInfo->apply_course_type == 1 || $userInfo->apply_course_type == '' || $userLastDateSubmit->status == false)
							{
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error','!');
								redirect($actual_link);
								return false;
								
							}
							}
							
								
							
							
						}
						
					}
					else
					{
						if($userType->user_type == 1){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select registration year');
							redirect($actual_link);
							
							}
							
					    else
						{
							if($clean['year']!= ''){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please activate your account!');
							redirect($actual_link);
							return false;
							}
							$userInfo = $this->user_model->checkLogin($clean);
						}
						
					} 	            
		            if (is_object($userInfo) && property_exists($userInfo,"username")) {	
		            	
		            	$password = $this->input->post('pass');		            	
						$Pass = sha1($userInfo->password.$_SESSION['salt']);
						if(trim($password) !=$Pass){					
							$this->session->set_flashdata('message_type', 'error');		
							$this->session->set_flashdata('error', 'Wrong Username/Password!');
							redirect($actual_link);
						}
		            	$datas = array(
						 'userid'=> $userInfo->id,
						 'fname'=> $userInfo->username,
						 'email'=> $userInfo->email_id,
						 'user_type'=> $userInfo->user_type,
						 'state'=>$userInfo->state,
						 'user_country'=>$userInfo->user_country,
						 'apply_course_type'=>$userInfo->apply_course_type,
						 'student_type'=>$userInfo->student_type,
						 'dir'=>$userInfo->dir
						);
						session_regenerate_id();
						//$this->session->regenerate_id();
						$this->user_model->updateLogin($userInfo->id);
			   			$this->session->set_userdata('user_data',$datas);
			   			$roles = $this->config->item('roles_id');
			   			$role = $roles[$userInfo->user_type];
			   			unset($_SESSION['salt']);

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
							case "Agency":
							redirect(site_url() . 'agency/dashboard');
							break;
							case "Super Admin":
							redirect(site_url() . 'admin/dashboard');
							break;
						}         
		            }
		            else
		            {
		            	$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Wrong Username/Password!');
						redirect($actual_link);	
					}
				}
	            else
	            {
	            	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Wrong Text Entered!');
					redirect($actual_link);
				}
	        }
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Wrong Username/Password');
			redirect($actual_link);				
		}
	}
		public function loginty()
	{
		try
		{
					$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('pass', 'Password', 'required');	
			$year = date("Y");
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        } else {
	            $post     = $this->input->post();
	            $clean    = $this->security->xss_clean($post);
				//echo "<pre>";
				//print_r($clean);die;
	            if($this->isValidCaptch($clean['captchatext']))
	            {
					$userType = $this->user_model->checkType($clean);
					if($clean['year']!= '' && !empty($clean['year']) && $userType->user_type == 1)
					{
						$userInfo = $this->user_model->checkLoginYear($clean,$clean['year']);
						if($clean['year']!= '' && !empty($clean['year']) && $clean['course_type'] == 2)
						{
							if($userInfo->apply_course_type == ''){
								
							//echo "1"; die;
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Sorry You are Not allowed');
							redirect($actual_link);
							return false;
						}
						}
						elseif($userInfo)
						{
							$userLastDateSubmit = $this->user_model->checkSubmitDetails($userInfo->id);
							 if($userLastDateSubmit->status == 'Draft')
							{
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error','!');
								redirect($actual_link);
								return false;
								
							}  
							
						}
						elseif($userInfo)
						{
							$userLastDateSubmit = $this->user_model->checkAyushSubmitDetails($userInfo->id);
							 if($userLastDateSubmit->status == 'Draft')
							{
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error','!');
								redirect($actual_link);
								return false;
								
							}  
							
						}
					}
					
					else
					{
						if($userType->user_type == 1){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select registration year');
							redirect($actual_link);
							
							}
							
					    else
						{
							if($clean['year']!= ''){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select valid option!');
							redirect($actual_link);
							return false;
							}
							$userInfo = $this->user_model->checkLogin($clean);
							
						}
						
					} 
						
		            if (is_object($userInfo) && property_exists($userInfo,"username")) {	
		            	
		            	$password = $this->input->post('pass');		            	
						$Pass = sha1($userInfo->password.$_SESSION['salt']);
						if(trim($password) !=$Pass){					
							$this->session->set_flashdata('message_type', 'error');		
							$this->session->set_flashdata('error', 'Wrong Username/Password!');
							redirect($actual_link);
						}
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
						session_regenerate_id();
						//$this->session->regenerate_id();
						$this->user_model->updateLogin($userInfo->id);
			   			$this->session->set_userdata('user_data',$datas);
			   			$roles = $this->config->item('roles_id');
			   			$role = $roles[$userInfo->user_type];
			   			unset($_SESSION['salt']);

		            	switch($role)
		            	{
							case "Student":
							
							redirect(site_url() . 'applicant/dashboard');
							break;
							case "University":
							redirect(site_url() . 'university/dashboard');
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
						}         
		            }
		            else
		            {
		            	$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Wrong Username/Password!');
						redirect($actual_link);	
					}
				}
	            else
	            {
	            	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Wrong Text Entered!');
					redirect($actual_link);
				}
	        }
			}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Wrong Username/Password');
			redirect($actual_link);				
		}
	}
	public function logindemo()
	{
		try
		{
			//echo "<pre>";print_r($_POST);die;
			if($_POST['sfs'] == '1'){
				
					$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('pass', 'Password', 'required');	
			$year = date("Y");
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        } else {
	            $post     = $this->input->post();
	            $clean    = $this->security->xss_clean($post);
				//echo "<pre>";
				//print_r($clean);die;
	            if($this->isValidCaptch($clean['captchatext']))
	            {
					$userType = $this->user_model->checkSfsType($clean);

					if($clean['year']!= '' && !empty($clean['year']) && $userType->user_type == 6)
					{
						$userInfo = $this->user_model->checkSfsLoginYear($clean,$clean['year']);
						
						/* $userLastDateSubmit = $this->user_model->checkSubmitDetails($userInfo->id);
						if($userLastDateSubmit->status == 'Draft')
						{
							
							
						} */
						
					}
					
					else
					{
						if($userType->user_type == 6){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select registration year');
							redirect($actual_link);
							
							}
							
					    else
						{
							if($clean['year']!= ''){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select valid option!');
							redirect($actual_link);
							return false;
							}
							
							
						}
						
					} 
					$userInfo = $this->user_model->checkSfsLoginYear($clean,$clean['year']);
		            if (is_object($userInfo) && property_exists($userInfo,"username")) {	
		            	
		            	$password = $this->input->post('pass');		            	
						$Pass = sha1($userInfo->password.$_SESSION['salt']);
						if(trim($password) !=$Pass){					
							$this->session->set_flashdata('message_type', 'error');		
							$this->session->set_flashdata('error', 'Wrong Username/Password!');
							redirect($actual_link);
						}
		            	$datas = array(
						 'userid'=> $userInfo->id,
						 'fname'=> $userInfo->username,
						 'email'=> $userInfo->email_id,
						 'user_type'=> $userInfo->user_type,
						 'state'=>$userInfo->state,
						 'user_country'=>$userInfo->user_country,
						 'created'=>$userInfo->created,
						 'dir'=>$userInfo->dir
						);
						session_regenerate_id();
						//$this->session->regenerate_id();
						$this->user_model->updateSfsLogin($userInfo->id);
			   			$this->session->set_userdata('user_data',$datas);
			   			$roles = $this->config->item('roles_id');
						//echo "<pre>";print_r($roles);die;
			   			$role = $roles[$userInfo->user_type];
			   			unset($_SESSION['salt']);

		            	switch($role)
		            	{
							case "Sfs":
							redirect(site_url() . 'Sfs/dashboard');
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
						}         
		            }
		            else
		            {
		            	$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Wrong Username/Password!');
						redirect($actual_link);	
					}
				}
	            else
	            {
	            	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Wrong Text Entered!');
					redirect($actual_link);
				}
	        }
				
				
			}
			else if($_POST['sfs'] == '2'){
				
					$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('pass', 'Password', 'required');	
			$year = date("Y");
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        } else {
	            $post     = $this->input->post();
	            $clean    = $this->security->xss_clean($post);
				//echo "<pre>";
				//print_r($clean);die;
	            if($this->isValidCaptch($clean['captchatext']))
	            {
					$userType = $this->user_model->checkType($clean);
					if($clean['year']!= '' && !empty($clean['year']) )
					{
						$userInfo = $this->user_model->checkLoginYear($clean,$clean['year']);
						
						
						/* $userLastDateSubmit = $this->user_model->checkSubmitDetails($userInfo->id);
						if($userLastDateSubmit->status == 'Draft')
						{
							
							
						} */
						
					}
					
					else
					{
						if($userType->user_type == 1){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select registration year');
							redirect($actual_link);
							
							}
							
					    else
						{
							if($clean['year']!= ''){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select valid option!');
							redirect($actual_link);
							return false;
							}
							$userInfo = $this->user_model->checkLogin($clean);
							
						}
						
					} 
						
		            if (is_object($userInfo) && property_exists($userInfo,"username")) {	
		            	
		            	$password = $this->input->post('pass');		            	
						$Pass = sha1($userInfo->password.$_SESSION['salt']);
						if(trim($password) !=$Pass){					
							$this->session->set_flashdata('message_type', 'error');		
							$this->session->set_flashdata('error', 'Wrong Username/Password!');
							redirect($actual_link);
						}
		            	$datas = array(
						 'userid'=> $userInfo->id,
						 'fname'=> $userInfo->username,
						 'email'=> $userInfo->email_id,
						 'user_type'=> $userInfo->user_type,
						 'state'=>$userInfo->state,
						 'university'=>$userInfo->university,
						 'user_country'=>$userInfo->user_country,
						 'created'=>$userInfo->created,
						 'dir'=>$userInfo->dir
						);
						session_regenerate_id();
						//$this->session->regenerate_id();
						$this->user_model->updateLogin($userInfo->id);
			   			$this->session->set_userdata('user_data',$datas);
			   			$roles = $this->config->item('roles_id');
			   			$role = $roles[$userInfo->user_type];
			   			unset($_SESSION['salt']);

		            	switch($role)
		            	{
							case "Student":
							
							redirect(site_url() . 'applicant/dashboard');
							break;
							case "University":
							redirect(site_url() . 'university/dashboard');
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
						}         
		            }
		            else
		            {
		            	$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Wrong Username/Password!');
						redirect($actual_link);	
					}
				}
	            else
	            {
	            	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Wrong Text Entered!');
					redirect($actual_link);
				}
	        }
			}
			
		
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Wrong Username/Password');
			redirect($actual_link);				
		}
	}	
	public function logout()
    {        
        $userInfo = $this->session->userdata('user_data');
		$roles = $this->config->item('roles_id');
		$role = $roles[$userInfo['user_type']];
		$this->session->unset_userdata('user_data');
		$this->session->sess_destroy();
		redirect('home');    	       
    }
	function isValidCaptch($captchText)
	{
		$sessionData = $this->session->userdata('captcha_code');
		$sessionText = $sessionData['code'];
		
		return ($captchText == $sessionText) ? TRUE : FALSE;
	}
	
	
	
	public function register()
	{
		try{
			$this->form_validation->set_rules('country', 'Country', 'required');
	        $this->form_validation->set_rules('student_name', 'Name', 'required');
	        $this->form_validation->set_rules('gender', 'Gender', 'required');
	        $this->form_validation->set_rules('applicant_date', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('applicant_month', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('applicant_year', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required');
	        $this->form_validation->set_rules('emailId', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('password', 'Password', 'required');	       
	        $this->form_validation->set_rules('isindian', 'Is Indian', 'required');
	        $post     = $this->input->post();
			$year = date("Y");
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        $clean    = $this->security->xss_clean($post);
	        if ($this->form_validation->run() == FALSE) {
        	    $this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Invalid Data!');
				redirect($actual_link);		           
	        } 
	        else 
	        {
	        	if($this->isValidCaptch($clean['userCaptcha']))
	            {
    		   if($this->user_model->isDuplicateEmail($this->input->post('emailId'),$year)) {
    		     	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Email Id Already Exist!');
					redirect($actual_link);	    	
	            } else {
		                $clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));	               
		                $clean['username'] = $this->input->post('student_name');
		                $responseDir = $this->createdir($clean['emailId'],$clean['country'],$year);
		                if($responseDir['status'] == TRUE)
		                {
							$clean['dir'] = $responseDir['dir'];
						}
						else
						{
							$clean['dir'] = "";
						}
						
		                $id      = $this->user_model->insertUser($clean);
		                $clean['uid'] = $id;
		                $id_detail = $this->user_model->insertStudentDetails($clean);
		                
		                $token   = $this->user_model->insertToken($id);
		                $qstring = $this->base64url_encode($token);
		                $url     = site_url() . 'home/complete/token/' . $qstring;
		                $link    = '<b><a href="' . $url . '">Click here to activate A2A account! »</a></b>';
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
							$config['smtp_host']    = 'smtp.gmail.com';
							$config['smtp_port']    = '465';
							$config['smtp_user']    = 'vipinbisht7@gmail.com';
							$config['smtp_password']    = 'Vipinmygmail@2020';
							$config['smtp_timeout'] = '7';
							$config['charset']    = 'utf-8';
							$config['newline']    = "\r\n";							
							$this->email->initialize($config);
							$content = $this->load->view('mail_signup',$data, true); 
					    
					     $from_email = $this->config->item('fromEmail'); ; 
						 $to_email = $this->input->post('emailId'); 			   
						 /* Load email library */
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
						  echo '<script>window.location.href="'.site_url().'home?text=Email not sent.&type=Error Message&at=danger&redirect='.site_url().'home/register";</script>';
						 $this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Registration Sucessfully!');
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
	public function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    public function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }	
	
	
	public function sfs_register()
	{
		try{
			$this->form_validation->set_rules('country', 'Country', 'required');
	        $this->form_validation->set_rules('student_name', 'Name', 'required');
	        $this->form_validation->set_rules('gender', 'Gender', 'required');
	        $this->form_validation->set_rules('applicant_date', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('applicant_month', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('applicant_year', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required');
	        $this->form_validation->set_rules('emailId', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('password', 'Password', 'required');	       
	        $this->form_validation->set_rules('isindian', 'Is Indian', 'required');
	        $post     = $this->input->post();
			$year = date("Y");
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        $clean    = $this->security->xss_clean($post);
	        if ($this->form_validation->run() == FALSE) {
        	    $this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Invalid Data!');
				redirect($actual_link);		           
	        } 
	        else 
	        {
	        	if($this->isValidCaptch($clean['userCaptcha']))
	            {
    		   if($this->user_model->isDuplicateSfsEmail($this->input->post('emailId'),$year)) {
    		     	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Email Id Already Exist!');
					redirect($actual_link);	    	
	            } else {
		                $clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));	               
		                $clean['username'] = $this->input->post('student_name');
		                $responseDir = $this->createdir($clean['emailId'],$clean['country'],$year);
		                if($responseDir['status'] == TRUE)
		                {
							$clean['dir'] = $responseDir['dir'];
						}
						else
						{
							$clean['dir'] = "";
						}
						
		                $id      = $this->user_model->insertSfsUser($clean);
		                $clean['uid'] = $id;
		                $id_detail = $this->user_model->insertSfsStudentDetails($clean);
		                
		                $token   = $this->user_model->insertSfsToken($id);
		                $qstring = $this->base64url_encode($token);
		                $url     = site_url() . 'home/completeSfs/token/' . $qstring;
		                $link    = '<b><a href="' . $url . '">Click here to activate A2A account! »</a></b>';
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
												
							//$config['smtp_user']    = 'kip.support@mea.gov.in';
							//$config['smtp_pass']    = 'Kip@Mea@123';
							$config['charset']    = 'utf-8';
							$config['newline']    = "\r\n";							
							$this->email->initialize($config);
							
							$content = $this->load->view('mail_signup',$data, true); 
					    
					     $from_email = $this->config->item('fromEmail'); ; 
						 $to_email = $this->input->post('emailId'); 			   
						 /* Load email library */
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
						  echo '<script>window.location.href="'.site_url().'home?text=Email not sent.&type=Error Message&at=danger&redirect='.site_url().'home/register";</script>';
						 $this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Registration Sucessfully!');
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
	
	
	
}

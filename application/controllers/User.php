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
        $this->load->library('encryption');
        $this->load->helper('date');      
		$this->load->helper('status_helper');
        $this->load->model('user_model');
        $this->load->model('common_model');
    } 

    public function createdir($email="",$cid="",$year="")
	{
		//manoj 21-02-2023
		$currentyear = date("Y");
		if (!file_exists('./'.$currentyear.'/applications_doc')) {
	    	mkdir('./'.$currentyear.'/applications_doc', 0777, true);
		}
		
		
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
		if (!file_exists('./'.$currentyear.'/applications_doc/'.$country)) {
	    	mkdir('./'.$currentyear.'/applications_doc/'.$country, 0777, true);
		}
		if (!file_exists('./'.$currentyear.'/applications_doc/'.$country."/".$email)) {
	    	$status = mkdir('./'.$currentyear.'/applications_doc/'.$country."/".$email, 0777, true);
		}
		return array('status'=>$status,'dir'=>'./'.$currentyear.'/applications_doc/'.$country."/".$email);
	}
	public function createsfsdir($email,$cid,$year)
	{
		$currentyearsfs = '2021SFS';
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
		if (!file_exists('../../'.$currentyearsfs.'/applications_doc/'.$country)) {
	    	mkdir('../../'.$currentyearsfs.'/applications_doc/'.$country, 0777, true);
		}
		if (!file_exists('../../'.$currentyearsfs.'/applications_doc/'.$country."/".$email)) {
	    	$status = mkdir('../../'.$currentyearsfs.'/applications_doc/'.$country."/".$email, 0777, true);
		}
		return array('status'=>$status,'dir'=>'../../'.$currentyearsfs.'/applications_doc/'.$country."/".$email);
	}
	
		public function logindemo()
	{
		try
		{
			$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('pass', 'Password', 'required');	
			$year = date("Y");
	        $actual_link =  isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url();
	        if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        } else {
	            $post     = $this->input->post();
	            //$clean    = $this->security->xss_clean($post);
				$cleanData = $this->security->xss_clean($post);
				$clean =  $this->strip_quotes($cleanData);
	            if($this->isValidCaptch($clean['captchatext']))
	            {
					
					$userType = $this->user_model->checkType($clean);
					if($userType->user_type == 1 && $clean['year'] == 2021)
					{
					 $userLastDateSubmit = $this->user_model->checkSubmitDetails($userType->id);
					}
					if($clean['year']!= '' && !empty($clean['year']) && $userType->user_type == 1)
					{
						if($userType->apply_course_type == 11 && $clean['year'] == 2022)
						{
							
							$userInfo = $this->user_model->checkLoginYearSfs($clean,$clean['year']);
						}
						elseif($userLastDateSubmit->status == 'Submit')
						{
							
							$userInfo = $this->user_model->checkLoginSubmitYear($clean,$clean['year']);
						}
						else
						{
							$userInfo = $this->user_model->checkLoginYear($clean,$clean['year']);
						}
						
						if($clean['year']!= '' && !empty($clean['year']) && $clean['course_type'] == 1)
						{
							if($userInfo->apply_course_type == ''){
								
							//echo "1"; die;
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Sorry You are Not allowed');
							redirect($actual_link);
							return false;
						}
						}
					}
					
					else
					{
						if(!empty($userType) && $userType->user_type == 1){
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
						// The login salt is only set when the login page itself renders
					// (site/home.php etc). If the session lost it before submit (expired
					// session, resubmitted form, etc.) this used to throw an "Undefined
					// array key 'salt'" warning; falling back to an empty string instead
					// just makes the password check below fail normally, no warning.
					$loginSalt = isset($_SESSION['salt']) ? $_SESSION['salt'] : '';
					$Pass = sha1($userInfo->password.$loginSalt);
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
	
	
	public function logindemo1()
	{
		try
		{
			$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('pass', 'Password', 'required');	
			$year = date("Y");
	        $actual_link =  isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url();
	        if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        } else {
	            $post     = $this->input->post();
	            //$clean    = $this->security->xss_clean($post);
				$cleanData = $this->security->xss_clean($post);
				$clean =  $this->strip_quotes($cleanData);
	            if($this->isValidCaptch($clean['captchatext']))
	            {
					$userType = $this->user_model->checkType($clean);
					if(!empty($userType) && $clean['year']!= '' && !empty($clean['year']) && $userType->user_type == 1)
					{
						$userInfo = $this->user_model->checkLoginYear($clean,$clean['year']);
						//echo "<pre>";print_r($userInfo);die;
						//$userLastDateSubmit = $this->user_model->checkSubmitDetails($userInfo->id);
						$userLastDateSubmit = $this->user_model->checkSubmitDetails($userInfo->id);
						//echo "<pre>";var_dump($userLastDateSubmit);die;
						  if($userLastDateSubmit->status == 'Draft' || $userLastDateSubmit == false)
						{ 
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error','!');
								redirect($actual_link);
								return false;
								
						}
						
					    
					}
					else
					{
						if(!empty($userType) && $userType->user_type == 1){
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
						// The login salt is only set when the login page itself renders
					// (site/home.php etc). If the session lost it before submit (expired
					// session, resubmitted form, etc.) this used to throw an "Undefined
					// array key 'salt'" warning; falling back to an empty string instead
					// just makes the password check below fail normally, no warning.
					$loginSalt = isset($_SESSION['salt']) ? $_SESSION['salt'] : '';
					$Pass = sha1($userInfo->password.$loginSalt);
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
	public function logout()
    {        
       
		$userInfo =$this->session->userdata('user_data');
		if (!empty($userInfo)) {
			$lastLoginHistry = $this->user_model->updateLogoutHistry($userInfo);
		}
		// $role removed: computed here but never used anywhere in this
		// function (also threw a warning when $userInfo was already empty).
		$this->session->unset_userdata('user_data');
		$this->session->sess_destroy();
		redirect('home');    	       
    }
	function isValidCaptch($captchText)
	{
		$sessionData = $this->session->userdata('captcha_code');
		$sessionText = !empty($sessionData) ? $sessionData['code'] : null;

		return ($captchText == $sessionText) ? TRUE : FALSE;
	}
	
	
	function strip_quotes($str)
		{
			// return str_replace(array('"', "'", '>', '<'), '', $str);
		$arr=array();
		foreach($str as $k=>$p){
	        $arr[$k] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $p);
	        $arr[$k] = preg_replace('/-+/', '-', $p);
	        // $arr[$k] = filter_var($p, 'FILTER_SANITIZE_STRING');
	         $arr[$k] = htmlspecialchars($p);

	        $arr[$k] = str_replace(array('<', '>', '"', ';', 'script', 'alert', 'prompt', 'onmouseover', 'javascript', '&lt;', '&gt;'), array('', '', '', '', '', '', '', '', '', '', ''), $p);
	        // $arr[$k] = strip_tags($p);
    	}
    	return $arr;
		}
	 public function sendMail($message_body,$email,$subject,$view)
   {
   		try{
   	 		$message = '';                
            $message .= '<strong>Dear Applicant ('.$email.'),</strong><br><br>';
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
   public function login()
	{
		try
		{
			$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('pass', 'Password', 'required');
			$year = date("Y");
	        $actual_link =  isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url();
	        if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);
	        } else {
	            $post     = $this->input->post();
	            //$clean    = $this->security->xss_clean($post);
				$cleanData = $this->security->xss_clean($post);
				$clean =  $this->strip_quotes($cleanData);
	            if($this->isValidCaptch($clean['captchatext']))
	            {
					$userType = $this->user_model->checkType($clean);
					if(!empty($userType) && $clean['year']!= '' && !empty($clean['year']) && $userType->user_type == 1)
					{
						$userInfo = $this->user_model->checkLoginYear($clean,$clean['year']);
						//echo "<pre>";print_r($userInfo);die;
						//$userLastDateSubmit = $this->user_model->checkSubmitDetails($userInfo->id);

						// Note: checkSubmitDetails() query removed — its result (formerly
						// $userLastDateSubmit) was only used by the "Login Restriction" block
						// below, which is fully commented out. The query ran on every single
						// login for no effect, adding an extra DB round-trip.
						if(is_object($userInfo) && $userInfo->apply_course_type != 100 && $userInfo->user_country != 188){
							
						/* Login Restriction*/
							
						// if($userLastDateSubmit->status == 'Draft'||$userLastDateSubmit->status == 'draft')
						// 	{ 
						// 			$this->session->set_flashdata('message_type', 'error');
						// 			$this->session->set_flashdata('error','Session closed');
						// 			redirect($actual_link);
						// 			return false;
									
						// 	}
						
						/* Login Restriction*/
						
						}
						//die($userInfo->apply_course_type);
						    
					}
					else
					{
						if(!empty($userType) && $userType->user_type == 1){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select registration year');
							redirect($actual_link);
							
							}
							
					    else
						{
							if($clean['year']!= ''){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Email id not registered');
							redirect($actual_link);
							return false;
							}
							$userInfo = $this->user_model->checkLogin($clean);
						}

					}
		            if (is_object($userInfo) && property_exists($userInfo,"username")) {

		            	$password = $this->input->post('pass');
						// The login salt is only set when the login page itself renders
					// (site/home.php etc). If the session lost it before submit (expired
					// session, resubmitted form, etc.) this used to throw an "Undefined
					// array key 'salt'" warning; falling back to an empty string instead
					// just makes the password check below fail normally, no warning.
					$loginSalt = isset($_SESSION['salt']) ? $_SESSION['salt'] : '';
					$Pass = sha1($userInfo->password.$loginSalt);
						if(trim($password) !=$Pass){
                             
												
							$this->session->set_flashdata('message_type', 'error');		
							$this->session->set_flashdata('error', 'Wrong Username/Password!');
							
							
							redirect($actual_link);
							$updateLoginFailHistry = $this->user_model->updateLoginFailHistry($userInfo);	
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

						//$lastLoginHistry = $this->user_model->updateLoginHistry($datas);
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
						$this->session->set_flashdata('error', 'No Such Username or Password!');
						redirect($actual_link);	
						$updateLoginFailHistry = $this->user_model->updateLoginFailHistry($userInfo);
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
			$this->session->set_flashdata('error', 'No Such Username or Password');
			redirect($actual_link);				
		}
	}
 public function register()
{
    $post = $this->input->post(NULL, TRUE);
    $parent_type = $post['parent_type'] ?? '';

    $actual_link = $_SERVER['HTTP_REFERER'] ?? site_url();
    $year = date("Y");

    // ======== Conditional Parents Validation ==========
    if ($parent_type == '1') { // Father only
        $this->form_validation->set_rules('father_fname', 'Father Name', 'required');
    } 
    else if ($parent_type == '2') { // Mother only
        $this->form_validation->set_rules('mother_fname', 'Mother Name', 'required');
    } 
    else if ($parent_type == '3') { // Father & Mother optional
        // no required
    } 
    else if ($parent_type == '4') { // Guardian
        $this->form_validation->set_rules('guardian_name', 'Guardian Name', 'required');
    }

    // ===== Other Mandatory Fields =====
    $this->form_validation->set_rules('country', 'Country', 'required');
    $this->form_validation->set_rules('student_fname', 'Student Name', 'required');
    $this->form_validation->set_rules('student_title', 'Title', 'required');
    $this->form_validation->set_rules('gender', 'Gender', 'required');
    $this->form_validation->set_rules('applicant_date', 'Date of Birth', 'required');
    $this->form_validation->set_rules('applicant_month', 'Date of Birth', 'required');
    $this->form_validation->set_rules('applicant_year', 'Date of Birth', 'required');
    $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required');
    $this->form_validation->set_rules('passport_no', 'Passport No', 'required');
    $this->form_validation->set_rules('unique_id', 'Unique No', 'required');
    $this->form_validation->set_rules('emailId', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('isindian', 'Is Indian', 'required');

    // ===== RUN VALIDATION ONLY ONCE =====
    if ($this->form_validation->run() == FALSE) {
        echo "<pre>";
        echo validation_errors();
        die;
    }

    try {

        // ===== CLEAN DATA =====
        $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
        $clean = $this->strip_quotes($cleanData);

        // ===== CAPTCHA CHECK =====
        if (!$this->isValidCaptch($clean['userCaptcha'])) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Wrong Text Entered!');
            redirect($actual_link);
        }

        // ===== DOB =====
        $dob = $this->input->post('applicant_date') . "/" .
               $this->input->post('applicant_month') . "/" .
               $this->input->post('applicant_year');

        // ===== DUPLICATE CHECK =====
        if (
            $this->user_model->isDuplicateEmail($clean['emailId'], $year) ||
            $this->user_model->isDuplicatePassport($clean['passport_no'], $year)
        ) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Email id and Passport No Already Exist!');
            redirect($actual_link);
        }

        // ===== DIRECTORY CREATE =====
        $clean['username'] = $clean['student_fname'];
        $responseDir = $this->createdir($clean['emailId'], $clean['country'], $year);

        $clean['dir'] = $responseDir['status'] ? $responseDir['dir'] : "";

        // ===== PASSPORT FILE UPLOAD =====
        $passportFile = '';

        if (!empty($_FILES['passport']['name'])) {

            $uploadPath = FCPATH . 'assets/img/register/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('passport')) {
                echo $this->upload->display_errors('<pre>', '</pre>');
                die;
            } else {
                $uploadData   = $this->upload->data();
                $passportFile = 'assets/img/register/' . $uploadData['file_name'];
            }
        }

        $clean['passport_file'] = $passportFile;

        // ===== INSERT DATA =====
        $id = $this->user_model->insertUser($clean);
        $clean['uid'] = $id;
        $this->user_model->insertStudentDetails($clean);

        // ===== EMAIL =====
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'relay.nic.in';
        $config['smtp_port'] = '25';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $this->email->initialize($config);

        $message = "<strong>Hi {$clean['username']},</strong><br><br>";
        $message .= "Registration successful.<br>";
        $message .= "<b>Email:</b> {$clean['emailId']}<br>";

        $content = $this->load->view('mail_signup', ['content' => $message], true);

        $this->email->from($this->config->item('fromEmail'), 'ICCR');
        $this->email->to($clean['emailId']);
        $this->email->subject('ICCR Registration');
        $this->email->message($content);

        $this->email->send();

        $this->session->set_flashdata('message_type', 'success');
        $this->session->set_flashdata('success', 'Registration Successfully!');
        redirect($actual_link);

    } catch (Exception $e) {
        $this->session->set_flashdata('message_type', 'error');
        $this->session->set_flashdata('error', 'Internal Server Error');
        redirect($actual_link);
    }
}	public function sfs_register()
	{
		try{
			$this->form_validation->set_rules('country', 'Country', 'required');
	        $this->form_validation->set_rules('student_name', 'Name', 'required');
	        $this->form_validation->set_rules('gender', 'Gender', 'required');
	        $this->form_validation->set_rules('applicant_date', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('applicant_month', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('applicant_year', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required');
			$this->form_validation->set_rules('passport_no', 'Passport No', 'required');
	        $this->form_validation->set_rules('emailId', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('password', 'Password', 'required');	       
	        $this->form_validation->set_rules('isindian', 'Is Indian', 'required');
	        $post     = $this->input->post();
			$year = date("Y");
	        $actual_link =  isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url();
	        //$clean    = $this->security->xss_clean($post);
			$cleanData = $this->security->xss_clean($post);
			$clean =  $this->strip_quotes($cleanData);
	        if ($this->form_validation->run() == FALSE) {
        	    $this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Invalid Data!');
				redirect($actual_link);		           
	        } 
	        else 
	        {
	        	if($this->isValidCaptch($clean['userCaptcha']))
	            {
    		  if($this->user_model->isDuplicateEmail($this->input->post('emailId'),$year) || $this->user_model->isDuplicatePassport($this->input->post('passport_no'),$year)){
    		     	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Email Id and Passport Already Exist!');
					redirect($actual_link);	    	
	            } else {
		                
						$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
						$clean =  $this->strip_quotes($cleanData);						
		                $clean['username'] = $this->input->post('student_name');
		                //$responseDir = $this->createsfsdir($clean['emailId'],$clean['country'],$year);
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
		                $link    = '<b><a href="' . $url . '">Click here to login on A2A account! »</a></b>';
						//$link    = '<b><a href="' . $url . '">Click here to activate A2A account! »</a></b>';
		                $message = '';                
		                $message .= '<strong>Hi '.$clean['username'].',</strong><br><br>';
		                $message .= 'Thanks for your registration in A2A Scholarships portal. You may Login for apply online. <br/><br/><b>Your Login Id is:</b> '.$clean['emailId'].'. <br/> <b>Your Password:</b> What you choose during registration. <br/><br>';
		                //$message .= 'Thanks for your registration in A2A Scholarships portal. You have to activate your account and then Login for apply online. <br/><br/><b>Your Login Id is:</b> '.$clean['emailId'].'. <br/> <b>Your Password:</b> What you choose during registration. <br/><br/>Please click the link below to activate your ICCR account. <br>';
						
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
						 $this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
						 //$this->email->subject('Indian Council for Cultural Relations (ICCR) Activate Account'); 
						 $this->email->message($content); 			   
						  if($this->email->send()) 
						 {
						 	 echo '<script>window.location.href="'.site_url().'a2a_register?text=Please check your email inbox/spam/junk to activate the account.&type=Thank You!&at=success&redirect='.site_url().'home";</script>';
						  }					
						  else 
						  echo '<script>window.location.href="'.site_url().'home?text=Email not sent.&type=Error Message&at=danger&redirect='.site_url().'a2a_register/register";</script>';
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
	// .....03-04-2024......//
	public function sendOTP_old(){
		$otp = rand(1111, 9999);
		$message = '';                
		$message .= '<strong>Hi </strong><br><br>';
		$message .= 'Thanks for showing intrest on A2A Scholarships portal. '.$otp.' is your otp. <br>';
						
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
		 $to_email = $this->input->post('email'); 		
		// print_r($to_email);die();	   
		 /* Load email library */
		 $this->load->library('email',$config);			   
		 $this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
		 $this->email->to($to_email);
		 $this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
		 //$this->email->subject('Indian Council for Cultural Relations (ICCR) Activate Account'); 
		 $this->email->message($content); 	
		//  echo $otp;		 
		 if($this->email->send()){
			 //echo $otp;
		 }
	}
	
	public function sendOTP(){
		$to_email = $this->input->post('email'); 
		
		$user_otp_detail = $this->user_model->getUserOTPData($to_email);
		// print_r($user_otp_detail->email);
		// die;
		
		if(!empty($user_otp_detail))
		{
			if($user_otp_detail->otp_count >= 5)
			{
				$last_updated = $user_otp_detail->updated_at;
				$newDate = date('Y-m-d H:i:s', strtotime($last_updated. ' + 1 hours'));
				$current_time = date("Y-m-d H:i:s");

				if($current_time > $newDate)
				{
					$otpCount = 1;
					$otp = rand(1111, 9999);
					

					$datas = array(
						'email'=> $to_email,
						'otp'=> $otp,
						'otp_count'=> 1,
						// 'verify_status'=> Null,
						// 'valid_otp_count'=> Null,
						'created_at'=> date('Y-m-d H:i:s'),
						'updated_at'=> date('Y-m-d H:i:s'),
					);
					$otp_updated = $this->user_model->updateOTP($datas);
					if($otp_updated)
					{
						$message = '';                
						$message .= '<strong>Hi </strong><br><br>';
						$message .= 'Thanks for showing intrest on A2A Scholarships portal. '.$otp.' is your otp. <br>';
										
						$data = array(
							'content' => $message					   
						);
						$this->load->library('email');
						$config = Array(
						 'mailtype' => 'html'				        
						);
						/*  $config['protocol']    = 'smtp';
						$config['smtp_host']    = 'relay.nic.in';
						$config['smtp_port']    = '25';
						$config['smtp_timeout'] = '7'; */
											
						$config['charset']    = 'utf-8';
						$config['newline']    = "\r\n";							
						$this->email->initialize($config); 
							
						$content = $this->load->view('mail_signup',$data, true); 
						
						$from_email = $this->config->item('fromEmail');
						$to_email = $this->input->post('email');
						
						// print_r($to_email);die();

                           
						
						/* Load email library */
						
						$this->load->library('email',$config);			   
						$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
						$this->email->to($to_email);
						$this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
						//$this->email->subject('Indian Council for Cultural Relations (ICCR) Activate Account'); 
						$this->email->message($content); 	
						//  echo $otp;		 
						 if($this->email->send())
						 {
							 //echo $otp;
							  echo json_encode(array('status'=>'success','message'=>'OTP sent successfully'));
						 }
				 
						//echo json_encode(array('status'=>'success','message'=>'OTP sent successfully'));
					}
				}
				else
				{
					echo json_encode(array('status'=>'error','message'=>'You have exceed the limit. Please try after 1 hour.'));
				}
			}
			else
			{
				$otpCount = $user_otp_detail->otp_count + 1;
				$otp = rand(1111, 9999);
				
				$datas = array(
					'email'=> $to_email,
					'otp'=> $otp,
					'otp_count'=> $otpCount,
					// 'verify_status'=> Null,
					// 'valid_otp_count'=> Null,
					'updated_at'=> date('Y-m-d H:i:s'),
				);
				$otp_updated = $this->user_model->updateOTP($datas);
				
				$message = '';                
				$message .= '<strong>Hi </strong><br><br>';
				$message .= 'Thanks for showing intrest on A2A Scholarships portal. '.$otp.' is your otp. <br>';
								
				$data = array(
					'content' => $message					   
				);
				$this->load->library('email');
				$config = Array(
				 'mailtype' => 'html'				        
				);
				/* $config['protocol']    = 'smtp';
				$config['smtp_host']    = 'relay.nic.in';
				$config['smtp_port']    = '25';
				$config['smtp_timeout'] = '7';*/
									
				$config['charset']    = 'utf-8';
				$config['newline']    = "\r\n";							
				$this->email->initialize($config); 
					
				$content = $this->load->view('mail_signup',$data, true); 
				
				$from_email = $this->config->item('fromEmail');
				$to_email = $this->input->post('email');
				
				// print_r($to_email);die();	   
				/* Load email library */
				
				$this->load->library('email',$config);			   
				$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
				$this->email->to($to_email);
				$this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
				//$this->email->subject('Indian Council for Cultural Relations (ICCR) Activate Account'); 
				$this->email->message($content); 	
				//  echo $otp;		 
				 if($this->email->send())
				 {
					 //echo $otp;
					  echo json_encode(array('status'=>'success','message'=>'OTP sent successfully'));
				 }
				// echo json_encode(array('status'=>'success','message'=>'OTP sent successfully'));
			}
		}
		else
		{
			$otpCount = 1;
			$otp = rand(1111, 9999);
			
			$datas = array(
				'email'=> $to_email,
				'otp'=> $otp,
				'otp_count'=> 1,
				// 'verify_status'=> Null,
				// 'valid_otp_count'=> Null,
				'created_at'=> date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s'),
			 );
			$otp_created = $this->user_model->insertOTP($datas);
			if($otp_created)
			{
				$message = '';                
				$message .= '<strong>Hi </strong><br><br>';
				$message .= 'Thanks for showing intrest on A2A Scholarships portal. '.$otp.' is your otp. <br>';
								
				$data = array(
					'content' => $message					   
				);
				$this->load->library('email');
				$config = Array(
				 'mailtype' => 'html'				        
				);
				/* $config['protocol']    = 'smtp';
				$config['smtp_host']    = 'relay.nic.in';
				$config['smtp_port']    = '25';
				$config['smtp_timeout'] = '7';*/
									
				$config['charset']    = 'utf-8';
				$config['newline']    = "\r\n";							
				$this->email->initialize($config); 
					
				$content = $this->load->view('mail_signup',$data, true); 
				
				$from_email = $this->config->item('fromEmail');
				$to_email = $this->input->post('email');
				
				// print_r($to_email);die();	   
				/* Load email library */
				
				$this->load->library('email',$config);			   
				$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
				$this->email->to($to_email);
				$this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
				//$this->email->subject('Indian Council for Cultural Relations (ICCR) Activate Account'); 
				$this->email->message($content); 	
				//  echo $otp;		 
				 if($this->email->send())
				 {
					 //echo $otp;
					  echo json_encode(array('status'=>'success','message'=>'OTP sent successfully'));
				 }
				//echo json_encode(array('status'=>'success','message'=>'OTP sent successfully'));
			 }
			 else
			 {
				 echo json_encode(array('status'=>'error','message'=>'Something went wrong. Please try again'));
			 }
		}
		
		
		
		/* $otp = rand(1111, 9999);
		$message = '';                
		$message .= '<strong>Hi </strong><br><br>';
		$message .= 'Thanks for showing intrest on A2A Scholarships portal. '.$otp.' is your otp. <br>';
						
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
		
		$from_email = $this->config->item('fromEmail');
		$to_email = $this->input->post('email'); 
		$datas = array(
			'email'=> $to_email,
			'otp'=> $otp,
			'otp_count'=> 1,
			'created_at'=> date('Y-m-d H:i:s'),
			'updated_at'=> date('Y-m-d H:i:s'),
		 );
         $otp_created = $this->user_model->insertOTP($datas); */
		 
		 /* if($otp_created)
		 { */
			 // print_r($to_email);die();	   
			 /* Load email library */
			 /* $this->load->library('email',$config);			   
			 $this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
			 $this->email->to($to_email);
			 $this->email->subject('Indian Council for Cultural Relations (ICCR)'); */ 
			 //$this->email->subject('Indian Council for Cultural Relations (ICCR) Activate Account'); 
			 // $this->email->message($content); 	
			//  echo $otp;		 
			 //if($this->email->send()){
				 //echo $otp;
			 //}
		 //}
	}
	//............03-04-2024.......//
	public function validateOTP_Old(){
		$inputOtp = $this->input->post('inputOtp');
		$sentOtp = $this->input->post('sentOtp');
		if($inputOtp == $sentOtp){
			echo 1;
		}else{
			echo 0;
		}
	}

	public function validateOTP()
	{
		$post = $this->input->post();
    // print_r($post);die;
		$to_email = $this->input->post('email');
		$inputOtp = $this->input->post('inputOtp');
		if(!empty($to_email && $inputOtp))
		{
			$data = $this->user_model->getUserOTPData($to_email);
			if($data->valid_otp_count >= 5)
			{
				$last_updated = $data->updated_at;
				$newDate = date('Y-m-d H:i:s', strtotime($last_updated. ' + 1 hours'));
				$current_time = date("Y-m-d H:i:s");

				if($current_time > $newDate)
				{
					if($data->otp == $this->input->post('inputOtp'))
					{
						$datas = array(
							'email'=> $to_email,
							'verify_status'=> 1,
						);
						$otp_updated = $this->user_model->updateValidOTP($datas);
						if($otp_updated)
						{
							echo json_encode(['status'=>'success','message'=>"OTP verified successfully"]);
						}
					}
					else
					{
						$valid_otp_count = 1;
						$datas = array(
							'email'=> $to_email,
							'valid_otp_count'=> $valid_otp_count,
						);
						$otp_updated = $this->user_model->updateValidOTP($datas);
						if($otp_updated)
						{
							echo json_encode(['status'=>'error','message'=>"Please enter valid otp."]);
						}
					}
				}
				else
				{
					echo json_encode(array('status'=>'error','message'=>'You have exceed invalid OTP limit. Please try after 1 hour.'));
				}
			}
			else
			{
				if($data->otp == $this->input->post('inputOtp'))
				{
					$datas = array(
						'email'=> $to_email,
						'verify_status'=> 1,
					);
					$otp_updated = $this->user_model->updateValidOTP($datas);
					if($otp_updated)
					{
						echo json_encode(['status'=>'success','message'=>"OTP verified successfully"]);
					}
				}
				else
				{
					$valid_otp_count = $data->valid_otp_count + 1;
					$datas = array(
						'email'=> $to_email,
						'valid_otp_count'=> $valid_otp_count,
					);
					$otp_updated = $this->user_model->updateValidOTP($datas);
					if($otp_updated)
					{
						echo json_encode(['status'=>'error','message'=>"Please enter valid otp."]);
					}
				}
			}
		}
		

		




		
		// $sentOtp = $this->input->post('sentOtp');
		/* if($inputOtp == $sentOtp){
			echo 1;
		}else{
			echo 0;
		} */
	}
	
public function uploadPassportAjax()
{

header('Content-Type: application/json');

$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];

$uploadPath = FCPATH.'assets/img/register/';

if(!is_dir($uploadPath)){
mkdir($uploadPath,0777,true);
}

$config['upload_path'] = $uploadPath;
$config['allowed_types'] = 'jpg|jpeg|png';
$config['max_size'] = 2048;
$config['encrypt_name'] = TRUE;

$this->load->library('upload',$config);

if(!$this->upload->do_upload('passport_file')){

exit(json_encode([
'status'=>0,
'message'=>strip_tags($this->upload->display_errors()),
'new_token'=>$this->security->get_csrf_hash()
]));

}else{

$data = $this->upload->data();

$imagePath = 'assets/img/register/'.$data['file_name'];

$this->db->where('id',$userId);
$this->db->update('iccr_users',['passport_file'=>$imagePath]);

exit(json_encode([
'status'=>1,
'image_url'=>base_url($imagePath),
'new_token'=>$this->security->get_csrf_hash()
]));

}

}

	public function __destruct() {
    $this->db->close();
    }
	
	
}

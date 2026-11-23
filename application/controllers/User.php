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
							redirect(site_url() . 'adminpanel'); // new Admin Panel (classic admin still at admin/dashboard)
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
							redirect(site_url() . 'adminpanel'); // new Admin Panel (classic admin still at admin/dashboard)
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
		$sessionText = !empty($sessionData['code']) ? (string) $sessionData['code'] : '';
		// Security fix: an empty or missing code used to pass ('' == null is TRUE in PHP),
		// so a script could skip the captcha entirely. The code is also single-use now.
		$this->session->unset_userdata('captcha_code');
		if ($sessionText === '' || !is_string($captchText) || $captchText === '') {
			return FALSE;
		}
		return hash_equals($sessionText, $captchText);
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
							redirect(site_url() . 'adminpanel'); // new Admin Panel (classic admin still at admin/dashboard)
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
    // Registration - every rule the browser checks is checked again here,
    // because anything in the browser can be bypassed (Nov 2026 test cases).
    $actual_link = site_url() . 'home/register';
    $year = date("Y");
    $this->load->helper('a2a_eligibility');

    $raw = $this->input->post(NULL, TRUE);
    if (!is_array($raw) || empty($raw)) {
        redirect($actual_link);
    }
    // Trim every text value (test 1034/1040: leading/trailing spaces)
    $in = array();
    foreach ($raw as $k => $v) {
        $in[$k] = is_string($v) ? trim(preg_replace('/\s+/', ' ', $v)) : '';
    }
    $g = function ($k) use ($in) { return isset($in[$k]) ? $in[$k] : ''; };

    $errors = array();
    $nameRe = '/^[A-Za-z]+( [A-Za-z]+)*$/';
    $name = function ($k, $label, $required) use ($g, $nameRe, &$errors) {
        $v = $g($k);
        if ($v === '') {
            if ($required) { $errors[] = "$label is required."; }
            return;
        }
        if (strlen($v) > 15) {
            $errors[] = "$label can be at most 15 characters.";
        } elseif (!preg_match($nameRe, $v)) {
            $errors[] = "$label may contain only English letters and spaces.";
        }
    };

    // ----- Choice fields: must be one of the values the form offers -----
    if (!in_array($g('student_title'), array('1', '2'), true))  { $errors[] = 'Title is required.'; }
    if (!in_array($g('gender'), array('1', '2'), true))         { $errors[] = 'Gender is required.'; }
    elseif ($g('student_title') !== '' && $g('student_title') !== $g('gender')) {
        $errors[] = 'Title and Gender do not match (Mr = M, Ms = F).';
    }
    $countryIds = array_map(function ($c) { return (string) $c['id']; }, $this->common_model->getCountriesByIdNotInCurrent());
    if (!in_array($g('country'), $countryIds, true))            { $errors[] = 'Nationality is required.'; }
    if (!in_array((int) $g('apply_course_type'), a2a_course_types(), true) || !ctype_digit($g('apply_course_type'))) {
        $errors[] = 'Apply For is required.';
    }
    if (!in_array($g('isindian'), array('1', '2'), true))       { $errors[] = 'Currently Staying In India is required.'; }
    $parent_type = $g('parent_type');
    if (!in_array($parent_type, array('1', '2', '3', '4'), true)) { $errors[] = 'Parent Details is required.'; }

    // ----- Names -----
    $name('student_fname', 'First Name', true);
    $name('student_mname', 'Middle Name', false);
    $name('student_lname', 'Last Name', true);
    $needFather   = in_array($parent_type, array('1', '3'), true);
    $needMother   = in_array($parent_type, array('2', '3'), true);
    $needGuardian = ($parent_type === '4');
    $name('father_fname', "Father's First Name", $needFather);
    $name('father_mname', "Father's Middle Name", false);
    $name('father_lname', "Father's Last Name", $needFather);
    $name('mother_fname', "Mother's First Name", $needMother);
    $name('mother_mname', "Mother's Middle Name", false);
    $name('mother_lname', "Mother's Last Name", $needMother);
    $name('gurdian_fname', "Guardian's First Name", $needGuardian);
    $name('gurdian_mname', "Guardian's Middle Name", false);
    $name('gurdian_lname', "Guardian's Last Name", $needGuardian);

    // ----- Contact / identity -----
    $mobile = $g('mobile_no');
    if ($mobile === '') { $errors[] = 'Mobile Number is required.'; }
    elseif (!preg_match('/^\+?[0-9]{6,15}$/', $mobile)) { $errors[] = 'Mobile Number may contain only digits (and a leading +), 6 to 15 digits.'; }

    $email = strtolower($g('emailId'));
    if ($email === '') { $errors[] = 'Email address is required.'; }
    elseif (strlen($email) > 40 || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Please enter a valid email address (max 40 characters).'; }

    $uniqueId = strtoupper($g('unique_id'));
    if ($uniqueId === '') { $errors[] = 'Citizenship/Local/Domestic Number is required.'; }
    elseif (!preg_match('/^[A-Z0-9\/-]{3,20}$/', $uniqueId)) { $errors[] = 'Citizenship/Local/Domestic Number may contain only letters, digits, - and /, 3 to 20 characters.'; }

    $passportNo = strtoupper($g('passport_no'));
    if ($passportNo === '') { $errors[] = 'Passport No. is required.'; }
    elseif (!preg_match('/^[A-Z0-9]{6,10}$/', $passportNo)) { $errors[] = 'Passport No. may contain only letters and digits, 6 to 10 characters.'; }

    // ----- Password: the browser sends SHA-1 hex of the password -----
    $pw = strtolower($g('password'));
    $cpw = strtolower($g('cpassword'));
    if ($pw === '') { $errors[] = 'Password is required.'; }
    elseif (!preg_match('/^[0-9a-f]{40}$/', $pw)) { $errors[] = 'Password was not submitted correctly. Please reload the page and try again.'; }
    if ($cpw === '') { $errors[] = 'Confirm Password is required.'; }
    elseif ($pw !== $cpw) { $errors[] = 'Password and Confirm Password do not match.'; }

    // ----- DOB: check 1 - visible field and hidden fields must agree -----
    if ($g('dob') === '' && $g('applicant_year') === '') {
        $errors[] = 'Date of Birth is required.';
    } elseif (!a2a_dob_fields_match($g('dob'), $g('applicant_date'), $g('applicant_month'), $g('applicant_year'))) {
        $errors[] = 'Date of Birth is not valid. Please select it again.';
    } else {
        // DOB: check 2 - real date, not in future, inside the programme age band
        list($ageOk, $ageMsg) = a2a_check_age($g('applicant_date'), $g('applicant_month'), $g('applicant_year'), $g('apply_course_type'));
        if (!$ageOk) { $errors[] = $ageMsg; }
    }

    // ----- Passport image: required, real JPG/PNG, max 1 MB -----
    $pf = isset($_FILES['passport']) ? $_FILES['passport'] : null;
    if (!$pf || $pf['error'] === UPLOAD_ERR_NO_FILE || $pf['name'] === '') {
        $errors[] = 'Passport image is required.';
    } elseif ($pf['error'] === UPLOAD_ERR_INI_SIZE || $pf['error'] === UPLOAD_ERR_FORM_SIZE || $pf['size'] > 1048576) {
        $errors[] = 'Passport image must be 1 MB or smaller.';
    } elseif ($pf['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($pf['tmp_name'])) {
        $errors[] = 'Passport image could not be uploaded. Please try again.';
    } else {
        $ext = strtolower(pathinfo($pf['name'], PATHINFO_EXTENSION));
        $info = @getimagesize($pf['tmp_name']);
        if (!in_array($ext, array('jpg', 'jpeg', 'png'), true)) {
            $errors[] = 'Passport image must be a JPG, JPEG or PNG file.';
        } elseif ($info === false || !in_array($info[2], array(IMAGETYPE_JPEG, IMAGETYPE_PNG), true)) {
            $errors[] = 'Passport image is not a valid or readable JPG/PNG image.';
        } elseif (function_exists('imagecreatefromjpeg')
               && (($info[2] === IMAGETYPE_JPEG && @imagecreatefromjpeg($pf['tmp_name']) === false)
               || ($info[2] === IMAGETYPE_PNG && @imagecreatefrompng($pf['tmp_name']) === false))) {
            $errors[] = 'Passport image file is damaged. Please upload another copy.';
        }
    }

    // ----- Captcha (single-use, case-sensitive) -----
    if ($g('userCaptcha') === '') {
        $errors[] = 'Please enter the captcha text.';
    } elseif (!$this->isValidCaptch($g('userCaptcha'))) {
        $errors[] = 'Wrong captcha text entered.';
    }

    // ----- Duplicates (only once the format checks pass) -----
    if (empty($errors)) {
        if ($this->user_model->isDuplicateEmail($email, $year)) {
            $errors[] = 'This email address is already registered for this year.';
        }
        if ($this->user_model->isDuplicatePassport($passportNo, $year)) {
            $errors[] = 'This passport number is already registered for this year.';
        }
        if ($this->user_model->isDuplicateUniqueId($uniqueId, $year)) {
            $errors[] = 'This Citizenship/Local/Domestic Number is already registered for this year.';
        }
    }

    if (!empty($errors)) {
        // Keep safe values so the applicant need not retype (no password,
        // captcha or file); the page escapes them before showing.
        $keep = array('student_title','gender','country','apply_course_type','isindian','parent_type','dob',
            'student_fname','student_mname','student_lname','father_fname','father_mname','father_lname',
            'mother_fname','mother_mname','mother_lname','gurdian_fname','gurdian_mname','gurdian_lname',
            'mobile_no','emailId','unique_id','passport_no');
        $old = array();
        foreach ($keep as $k) { $old[$k] = mb_substr($g($k), 0, 60); }
        $this->session->set_flashdata('reg_old', $old);
        $this->session->set_flashdata('message_type', 'error');
        $this->session->set_flashdata('error', implode('<br>', array_map('html_escape', $errors)));
        redirect($actual_link);
    }

    try {
        $clean = array(
            'parent_type' => $parent_type, 'country' => $g('country'),
            'student_fname' => $g('student_fname'), 'student_mname' => $g('student_mname'), 'student_lname' => $g('student_lname'),
            'student_title' => $g('student_title'), 'gender' => $g('gender'),
            'applicant_date' => $g('applicant_date'), 'applicant_month' => $g('applicant_month'), 'applicant_year' => $g('applicant_year'),
            'mobile_no' => $mobile, 'passport_no' => $passportNo, 'unique_id' => $uniqueId,
            'emailId' => $email, 'password' => $pw, 'isindian' => $g('isindian'),
            'apply_course_type' => (int) $g('apply_course_type'),
            'father_fname' => $g('father_fname'), 'father_mname' => $g('father_mname'), 'father_lname' => $g('father_lname'),
            'mother_fname' => $g('mother_fname'), 'mother_mname' => $g('mother_mname'), 'mother_lname' => $g('mother_lname'),
            'gurdian_fname' => $g('gurdian_fname'), 'gurdian_mname' => $g('gurdian_mname'), 'gurdian_lname' => $g('gurdian_lname'),
        );
        $clean['username'] = $clean['student_fname'];
        $responseDir = $this->createdir($clean['emailId'], $clean['country'], $year);
        $clean['dir'] = $responseDir['status'] ? $responseDir['dir'] : "";

        // ===== PASSPORT FILE UPLOAD (already validated above) =====
        $uploadPath = FCPATH . 'assets/img/register/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $config = array(
            'upload_path' => $uploadPath, 'allowed_types' => 'jpg|jpeg|png',
            'max_size' => 1024, 'encrypt_name' => TRUE, // random safe file name
        );
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('passport')) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Passport image: ' . strip_tags($this->upload->display_errors('', '')));
            redirect($actual_link);
        }
        $uploadData = $this->upload->data();
        $clean['passport_file'] = 'assets/img/register/' . $uploadData['file_name'];

        // ===== INSERT DATA =====
        $id = $this->user_model->insertUser($clean);
        $clean['uid'] = $id;
        $this->user_model->insertStudentDetails($clean);

        // ===== EMAIL =====
        $this->load->library('email');
        $mcfg = array('protocol' => 'smtp', 'smtp_host' => 'relay.nic.in', 'smtp_port' => '25',
                      'mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n");
        $this->email->initialize($mcfg);
        $message = "<strong>Hi " . html_escape($clean['username']) . ",</strong><br><br>";
        $message .= "Registration successful.<br>";
        $message .= "<b>Email:</b> " . html_escape($clean['emailId']) . "<br>";
        $content = $this->load->view('mail_signup', ['content' => $message], true);
        $this->email->from($this->config->item('fromEmail'), 'ICCR');
        $this->email->to($clean['emailId']);
        $this->email->subject('ICCR Registration');
        $this->email->message($content);
        @$this->email->send();

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

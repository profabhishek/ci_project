<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
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
			$this->load->helper('form');
			$this->load->helper('security');
			$this->load->helper('text');
			$this->load->library('form_validation');
			$this->load->library('session');	
			$this->load->library('encrypt');
			$this->load->helper('date');   
			$this->load->model('user_model'); 
			$this->load->model('common_model');  

			
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
		public function index()
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
			$data['salt'] = $this->random_string();
			$this->session->set_userdata('captcha_code',$data['captcha']); 
			$this->load->view('site/header');
			$this->load->view('site/home',$data);
			$this->load->view('site/footer');
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
				$this->session->set_flashdata('error', 'Wrong Email Id');	
			} 
			else 
			{	
				$post = $this->input->post(NULL, TRUE);
				$cleanPost = $this->security->xss_clean($post);
				//$year = date("Y");
				//print_r($cleanPost);die;
				if($this->isValidCaptch($cleanPost['userCaptcha']))
				{
					$email = $this->input->post('email');
					$userType = $this->user_model->checkForgetType($email);
					//echo "<pre>";
					//print_r($userType);die;
					if($cleanPost['year']!= '' && !empty($cleanPost['year']) && is_object($userType) && $userType->user_type == 1)
					{
						$num_res = $this->user_model->checkForgetWithType($email,$cleanPost['year']);
						//echo $num_res;die;
					}
					else
					{

						if(is_object($userType) && $userType->user_type == 1){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Please select registration year');
							redirect('home/forgotPassword');
						}
						
						else{
							if($cleanPost['year']!= ''){
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error','Please select valid option!');
								redirect('home/forgotPassword');
								return false;
							}
							$num_res = $this->user_model->checkForgetWithoutYear($email);
							
						}
					}
					
					
					// See Home.php forgot_password() for why this checks !empty()
					// instead of == 1 (checkForgetWithType() returns a row object,
					// not literally 1).
					if (!empty($num_res))
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
						//var_dump($pass_res);die;
						}
						else{
						$pass_res = $this->user_model->checkForgetPass($email,$year,$data);
						//var_dump($pass_res);die;
						}
						if($pass_res) 
						{
							
							
							// Update okay, send email
							$url     = site_url() . 'home/completePassword/' .$code;
							
							$link    = '<a href="' . $url . '">Please click the link to reset the password! »</a>';
							$message = '';                
							$message .= 'Please click the link below to reset your password. <br>';
							
							$message .= $link;
							$data = array(
							'content' => $message					   
							);
							$this->load->library('email');
							$config = Array(
							'mailtype' => 'html'				        
							);
							
							$from_email = "vipinbisht7@gmail.com"; 
							$to_email = $email; 			   
							/* Load email library */
							$this->load->library('email',$config);	
							
							
							/* $config['protocol']    = 'smtp';
							$config['smtp_host']    = 'relay.nic.in';
							$config['smtp_host']    = 'relay.nic.in';
							$config['smtp_port']    = '25';
							$config['smtp_timeout'] = '7'; */
							
							//$config['smtp_user']    = 'kip.support@mea.gov.in';
							//$config['smtp_pass']    = 'Kip@Mea@123';
							$config['charset']    = 'utf-8';
							$config['newline']    = "\r\n";							
							$this->email->initialize($config);
							
							$content = $this->load->view('change_password',$data, true); 							
							$from_email = $this->config->item('fromEmail'); 
							$to_email = $email; 			   
							/* Load email library */
							
							$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
							$this->email->to($to_email);
							$this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
							$this->email->message($content);			   
							if($this->email->send()) 
							{
								//echo $this->email->print_debugger();
								$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Kindly Check Your Email to Reset Password!');
								redirect(site_url().'home/forgotPassword');
								
							}
							else 
							{
								//echo $this->email->print_debugger();
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error', 'Email Not Send');
								redirect(site_url().'home/forgotPassword');
							}
							
							
							
						} 
						else 
						{ 
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Wrong Email Id');
							redirect(site_url().'home/forgotPassword');
						}
					} 
					else
					{ 
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Wrong Email Id');
						redirect(site_url().'home/forgotPassword');
					}
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Wrong Text Entered');
					redirect(site_url().'home/forgotPassword');
				}
			}
		}
		public function completePassword() 
		{
			
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
				//print_r($data['code']);
				//die;
				if($this->isValidCaptch($cleanPost['userCaptcha']))
				{
					$email = xss_clean($this->input->post('email'));
					if (!$this->common_model->does_code_match($data['code'], $email)) 
					{
						// Code doesn't match
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Your Email is not Valid Please Try Again.');
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
					
					$userType = $this->user_model->checkForgetType($email);
					if($cleanPost['year']!= '' && !empty($cleanPost['year']) && $userType->user_type == 1)
					{
						$update_pas = $this->common_model->update_userpass($email,$cleanPost['year'],$data);
					}
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
		
		if (!$_SERVER['HTTP_REFERER']) 
			redirect($actual_link);
		?>
		
		
		
		
		<?php
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
			$this->load->view('site/register',$data);
			$this->load->view('site/footer');
		}	
		
			public function getDob()
		{
			
			$response = array('status'=>FALSE,'jsondata'=>array());
			$year=$this->input->post('year'); 
			$month = $this->input->post('month'); 
			$date = $this->input->post('date');
			$dob=$date.'/'.$month.'/'.$year;
			$condate='01/07/2020';
			$birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $dob))))));
			$today= new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $condate))))));$age = $birthdate->diff($today)->y;
			
			if($age < 18)
			{
				$response['status'] = FALSE;
				//$response['jsondata'] = $data;
			}else{
				$response['status'] = TRUE;
				
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
			$applicationId = $this->uri->segment(3);
			if($applicationId == NULL || $applicationId == "")
			{
				$applicationId = $this->random_num(15);
			}	
			else
			{
				$applicationId = $this->uri->segment(3);
			}
			$data['appno'] = $applicationId;
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
			$this->load->view('site/sfs/sfs_register',$data);
			$this->load->view('site/footer');
		}
		public function complete()
		{
			try{
				$token      = base64_decode($this->uri->segment(4));
				echo $token;die;
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
					$hashed                = md5($cleanPost['password']);
					$cleanPost['password'] = $hashed;
					$cleanPost['user_id'] =  $user_info->id;
					unset($cleanPost['passconf']);
					$userInfo = $this->user_model->updateUserInfo($cleanPost);
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
		public function base64url_encode($data)
		{
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
		}
		public function base64url_decode($data)
		{
			return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
		}
		
		//=========================Added by Rahul dey 24-01-2019 ===============================
		
		public function feedback()
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
		public function savesAlumniData()
	{
		
		try
		{
			
				$post     = $this->input->post();
	            $clean    = $this->security->xss_clean($post);
				//echo "<pre>";
				//print_r($clean);DIE;
				if(!empty($_POST))
				{
				if($this->isValidCaptchTest($clean['captchatext'])){
					
				
	            if(!$this->user_model->isValidAluminiEmail($clean['email']))
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
			if ($frst != $sec) 
			{				
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File content is not Valid!');
				redirect(site_url().'home');				
				return;
			}
			if ($nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File content is not Valid!');
				redirect(site_url().'home');		
				return;			
			}
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
			  $imgname = $application_no.'_'.time().'_alumni_pics_'.$name;
			  
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
				'present_details'=>$postData['present_details'],
				'email'=>$postData['email'],
				'phone'=>$postData['phone'],
				'award_recognition'=>$postData['award_recognition'],
				'passport_no'=>$postData['passport_no'],
				'passport_issue_date'=>$postData['passport_issue_date'],
				'passport_issue_month'=>$postData['passport_issue_month'],
				'passport_issue_year'=>$postData['passport_issue_year'],
				'passport_expiry_date'=>$postData['passport_expiry_date'],
				'passport_expiry_month'=>$postData['passport_expiry_month'],
				'passport_expiry_year'=>$postData['passport_expiry_year'],
				'passport_issue_place'=>$postData['passport_issue_place']
				
				
				);
			  	
				 //echo "<pre>";
				// print_r($aluminiData);die;
				 
				 
				 
				 $result = $this->common_model->insertAlumniData($aluminiData);
				 //var_dump($result);die;
				 if($result){
				 $message = '';                
		         $message .= '<strong>Hi '.$clean['fullname'].',</strong><br><br>';
		         $message .= 'Thanks for your registration in A2A Scholarships portal.<br>';
				 
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
							$config['smtp_user']    = 'vipin.bisht@velocis.co.in';
							$config['smtp_password']    = 'Vipinmygmail8#';
							$config['smtp_timeout'] = '7';
							$config['charset']    = 'utf-8';
							$config['newline']    = "\r\n";							
							$this->email->initialize($config);
							
					        $content = $this->load->view('mail_acknowledgement',$data, true); 
					    
							 $from_email = $this->config->item('fromEmail'); ; 
							 $to_email = $postData['email']; 			   
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
						  echo '<script>window.location.href="'.site_url().'home?text=Email not sent.&type=Error Message&at=danger&redirect='.site_url().'home";</script>';
						 $this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Registration Sucessfully!');
						redirect($actual_link);
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
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'home');
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
	}

<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Sfs extends CI_Controller {
		
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
			$this->load->helper('file');
			$this->load->library('form_validation');
			$this->load->library('session');	
			$this->load->library('encryption');
			$this->load->helper('date');   
			$this->load->model('user_model'); 
			$this->load->model('common_model');
			$this->load->library('mpdf60/Mpdf');   
			$this->load->library('fpdi/PDF_HTML');   
			//$this->load->library('fpdi/Htmltable');     
			$this->load->helper('file');
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
		} 
		
		public function addVideo()
		{								
			$this->load->view('site/header');
			$this->load->view('site/addvideo');
			$this->load->view('site/footer');
		}
		public function saveYoutubeLink()
		{
			$user_data = $this->session->userdata('user_data');	
			$userId = $user_data['userid'];	
			$postData = $this->input->post(NULL,TRUE);
			if(count($postData)>0)
			{
				$cleanData = $this->security->xss_clean($postData);	
				$link = $cleanData['youtubelink'];
				$sts = $this->common_model->saveYoutubeLink($userId,$link);
				if($sts)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Youtube Link Added!');
					redirect(site_url().'applicant/dashboard');	
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur while adding Youtube Link. Please try again.');
					redirect(site_url().'applicant/dashboard');
				}
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
				$this->load->view('site/sfs/header');
				$this->load->view('site/sfs/changepassword',$data);
				$this->load->view('site/sfs/footer');	
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
				redirect(site_url().'Sfs/dashboard');
			}
		}
		public function submitbankDetails()
		{
			$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$rid = 0;$schid = 0;	$signature = "";
			
			$appid = $clean['appid'];
			$bankName = $clean['bankname'];
			$accno = $clean['accno'];
			$uresponse = $this->common_model->getUResponseById($appid);
			$uresponse1 = $this->common_model->getUTwoResponseById($appid);
			$imgname ="";
			$files = $_FILES['bank_doc'];	
			if($files["name"] != "")
			{				
				$name = str_replace(" ","_",$files['name']);
				$imgname = time().'_bank_doc_'.$name;		  
				$target_file = 'assets/site/main/bank_docs/'.$imgname; 
				if(move_uploaded_file($_FILES["bank_doc"]["tmp_name"], $target_file)) 
				{ 
					if(count($uresponse)>0)
					{
						$rid = $uresponse[0]['region_one_status'];						
						$signature = $uresponse[0]['signature_doc'];
					}
					elseif(count($uresponse1)>0)
					{
						$rid = $uresponse1[0]['region_one_status'];						
						$signature = $uresponse1[0]['signature_doc'];
					}
					
					$data = array(
						'regionId' =>$rid,
						'application_id'=>$appid,
						'bankname'=>$bankName,
						'account_no'=>$accno,
						'bank_off_sign'=>$signature,
						'bank_doc' =>$imgname,
						'bank_off_name'=>'Applicant',
						'created'=>time()
					);
					$status = $this->common_model->insertBankDetails($data);
					if($status)
					{
						$data['message']['type'] = 1;
						$data['message']['text'] = "Bank Details Added Successfully";
						$data['message']['redirect'] = site_url().'applicant/bankdetails/'.$appid;
						$this->load->view("site/msg",$data);
					}
					else
					{
						$data['message']['type'] = 2;
						$data['message']['text'] = "Error While Adding Bank Details! Try After Some Time";
						$data['message']['redirect'] = site_url().'applicant/bankdetails/'.$appid;
						$this->load->view("site/msg",$data);
					}
				}
				else
				{
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error While Adding Bank Details! Try After Some Time";
					$data['message']['redirect'] = site_url().'applicant/bankdetails/'.$appid;
					$this->load->view("site/msg",$data);
				}
			}
			else
			{
				$data['message']['type'] = 2;
				$data['message']['text'] = "Error While Adding Bank Details! Try After Some Time";
				$data['message']['redirect'] = site_url().'applicant/bankdetails/'.$appid;
				$this->load->view("site/msg",$data);
			}
		}
		public function submitcomplaint()
		{
			$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$rid = 0;$schid = 0;		
			$category = $clean['complaint_id'];
			$appid = $clean['appid'];
			$desc = $clean['description'];
			$othercat = $clean['other_cat'];
			$uresponse = $this->common_model->getUResponseById($appid);
			$uresponse1 = $this->common_model->getUTwoResponseById($appid);
			$imgname ="";
			$files = $_FILES['applicant_signature'];	
			if($files["name"] != "")
			{				
				$name = str_replace(" ","_",$files['name']);
				$imgname = time().'_complaint_signature_'.$name;		  
				$target_file = 'assets/site/main/complaint_signature/'.$imgname; 
				if(move_uploaded_file($_FILES["applicant_signature"]["tmp_name"], $target_file)) 
				{ 
					if(count($uresponse)>0)
					{
						$rid = $uresponse[0]['region_one_status'];
						$schid = $uresponse[0]['scholarship_id'];
					}
					elseif(count($uresponse1)>0)
					{
						$rid = $uresponse1[0]['region_one_status'];
						$schid = $uresponse1[0]['scholarship_id'];
					}
					
					$data = array(
					'cid' =>$this->uri->segment(3),
					'appid'=>$appid,
					'category'=>$category,
					'descripton'=>$desc,
					'signature'=>$imgname,
					'created' =>time(),
					'rid'=>$rid,
					'scheme'=>$schid
					);
					$status = $this->common_model->insertComplaint($data);
					if($status)
					{
						$data['message']['type'] = 1;
						$data['message']['text'] = "Complaint Created Successfully";
						$data['message']['redirect'] = site_url().'applicant/complaints/'.$appid;
						$this->load->view("site/msg",$data);
					}
					else
					{
						$data['message']['type'] = 2;
						$data['message']['text'] = "Error While Creating Complaint! Try After Some Time";
						$data['message']['redirect'] = site_url().'applicant/complaints/'.$appid;
						$this->load->view("site/msg",$data);
					}
				}
				else
				{
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error While Creating Complaint! Try After Some Time";
					$data['message']['redirect'] = site_url().'applicant/complaints/'.$appid;
					$this->load->view("site/msg",$data);
				}
			}
			else
			{
				$data['message']['type'] = 2;
				$data['message']['text'] = "Error While Creating Complaint! Try After Some Time";
				$data['message']['redirect'] = site_url().'applicant/complaints/'.$appid;
				$this->load->view("site/msg",$data);
			}
		}
		public function addBankDetails()
		{
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);					
			$this->load->view('site/header');
			$this->load->view('site/addBankDetails',$data);
			$this->load->view('site/footer');
		}
		public function addFRRODetails()
		{
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);					
			$this->load->view('site/header');
			$this->load->view('site/addFRRODetails',$data);
			$this->load->view('site/footer');
		}
		public function createcomplaint()
		{
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);	
			$data['complaint_no'] = 'COMPLAINT'.$this->random_num(4);		
			$this->load->view('site/header');
			$this->load->view('site/createcomplaints',$data);
			$this->load->view('site/footer');
		}
		public function complaints()
		{
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			$appid = $this->uri->segment(3);
			$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);	
			$data['complaints'] = $this->common_model->getComplaints($appid);	
			$this->load->view('site/header');
			$this->load->view('site/complaints',$data);
			$this->load->view('site/footer');
		}
		public function bankdetails()
		{
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			$appid = $this->uri->segment(3);
			$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);	
			$data['bankDetails'] = $this->common_model->getBankingDetails($appid,"");	
			$this->load->view('site/header');
			$this->load->view('site/bankdetails',$data);
			$this->load->view('site/footer');
		}
		public function frroDetails()
		{
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			$appid = $this->uri->segment(3);
			$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);	
			$data['frroDetails'] = $this->common_model->getPermitDetails($appid,"");	
			$this->load->view('site/header');
			$this->load->view('site/frroDetails',$data);
			$this->load->view('site/footer');
		}
		public function viewProfile()
		{
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$imgArray = $this->common_model->getUserImage($userId);
			if(count($imgArray)> 0)
			{
				$data['userImage'] = $imgArray[0]['name'];
			}		
			else
			{
				$data['userImage'] = '';
			}
			$data['applicaitonSfsStepOne'] = $this->common_model->getApplicationSfsStepOne($userId);
			$data['registerSfsData'] = $this->common_model->getSfsUserData($userId);
			$this->load->view('site/sfs/header');
			$this->load->view('site/sfs/profile',$data);
			$this->load->view('site/sfs/footer');
		}
		public function viewApplication()
		{
			
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$data['registerSfsData'] = $this->common_model->getSfsUserData($userId);
			$imgArray = $this->common_model->getSfsUserImage($userId);
			if(count($imgArray)> 0)
			{
				$data['userImage'] = $imgArray[0]['name'];
			}		
			else
			{
				$data['userImage'] = '';
			}
			$data['registerSfsData'] = $this->common_model->getSfsUserData($userId);
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();		
			$data['applicaitonSfsStepOne'] = $this->common_model->getApplicationSfsStepOne($userId);
			$data['applicaitonSfsStepThree'] = $this->common_model->getApplicationSfsStepThree($userId);
			$data['applicaitonSfsStepTwo'] = $this->common_model->getApplicationSfsStepTwo($userId);	
			$data['applicaitonSfsDocuments'] = $this->common_model->getApplicationSfsDocuments($userId);
			$this->load->view('site/sfs/header');
			$this->load->view('site/sfs/full_sfs_application',$data);
			$this->load->view('site/sfs/footer');
		}
		public function downloadApplication()
		{
			header("Content-type: application/pdf");
			try
			{	    	
				$appno = $this->uri->segment(3);
				$content = $this->input->post("myHTML");

				$mpdf = new Mpdf('s','A4','','',7,7,05,10,10,10);			
				$mpdf->SetFont('Arial','B',9);
				$mpdf->SetWatermarkText('Indian Council For Cultural Relation');
				$mpdf->watermark_font = 'DejaVuSansCondensed';
				$mpdf->showWatermarkText = true;
				$mpdf->showImageErrors = true;
				
				$html1 = "<div style='text-align:center;'><img width='300px' src='/var/www/html/assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Application Form For Scholarship through ICCR</h3><br/>";       	 				
				$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>Ref. No.".$appno.'<br/>'.date("jS F Y h:i:s")."</div>";
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
				$pdfString = $mpdf->Output($appno.'.pdf','I');
				header("Content-Disposition: attachment; filename='".$appno.".pdf\""); 
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: " . mb_strlen($pdfString));	
			}
			catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
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
		public function index()
		{
			try
			{
				$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				//echo "<pre>";
				//print_r($_POST);die;
				if(!empty($_POST))
				{		
				
					
					$appno = '';
					if(isset($_GET['appno']))
					{
						$appno = $_GET['appno'];
					}
					$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));	
						//echo "<pre>";
						//print_r($clean);die;
					if($clean['sfs_undertaking'] == '' || $clean['sfs_undertaking'] != '')
					{				
						$applicat = $this->common_model->getApplicationSfsStepOne($userId);
						if($applicat[0]['status']== "Pending")
						{
							$submitApp = array(	
							'status'=>6
							);	
							$this->common_model->updateSfsApplicationMapStatus($appno,$submitApp);
						}
						else
						{
							$submitApp = array(
							'uid'=>$userId,
							'application_no'=>$appno,
							'mission_status_date'=>'',
							'mission_doc'=>'',
							'iccr_status_date'=>'',
							'iccr_doc'=>'',
							'status'=>1,
							'status_update_date'=>time(),
							'mission_status'=>-1,
							'iccr_status'=>-1,
							'region_one_status'=>-1,
							'region_two_status'=>-1,
							'region_three_status'=>-1,
							'created'=>time()
							);
							$this->common_model->insertSfsApplicationMapStatus($submitApp);	
						}	
						$sts = $this->common_model->updateSfsApplicationStatus($appno,$userId);
						if($sts)
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Your Application Submitted Successfully. Your Reference Number is: '.$appno);
							redirect(site_url().'Sfs/dashboard');	
							
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
							redirect(site_url().'Sfs/dashboard');						
						}
					}
				}		
				$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
				$this->load->view('site/sfs/header');
				$this->load->view('site/sfs/dashboard',$data);
				$this->load->view('site/sfs/footer');	
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
				redirect(site_url().'Sfs/dashboard');	
			}
		}
		public function applicant_personal_info()
		{
			try
			{
				$user_data = $this->session->userdata('user_data');	
				$userId = $user_data['userid'];		
				$data['registerData'] = $this->common_model->getUserData($userId);
				$imgArray = $this->common_model->getUserImage($userId);
				
				if(count($imgArray)> 0)
				{
					$data['userImage'] = $imgArray[0]['name'];
				}		
				else
				{
					$data['userImage'] = '';
				}
				$applicationData = $this->common_model->getApplicationStepOne($userId);
				
				$data['applicaitonStepOne'] = $applicationData;
				$data['missions'] = $this->common_model->getAllMissions();
				if(count($data['applicaitonStepOne'])>0)
				{
					$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
				}
				else
				{
					$data['missions'] = $this->common_model->getAllMissions();
					$data['get_application_number'] = $this->random_num(15);
				}
				
				if(count($applicationData)>0 && $applicationData[0]['status'] == "Draft")
				{
					$data['applicaitonStepOne'] = $applicationData;
					$data['univercities'] = $this->common_model->getUnivercities();			
					$this->load->view('site/header');
					$this->load->view('site/applicant_personal_info',$data);
					$this->load->view('site/footer');
				}
				elseif(count($applicationData)>0 && $applicationData[0]['status'] == "Submit" )
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You have already applied!');
					redirect(site_url().'applicant/dashboard');	
				}
				else
				{
					$data['applicaitonStepOne'] = $applicationData;
					$data['univercities'] = $this->common_model->getUnivercities();			
					$this->load->view('site/header');
					$this->load->view('site/applicant_personal_info',$data);
					$this->load->view('site/footer');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
				redirect(site_url().'applicant/dashboard');	
			}		
		}
		public function applicant_education_info()
		{
			//echo "<pre>";
			//print_r($_POST);die;
			$actual_link =  $_SERVER['HTTP_REFERER'];
			try
			{
				$year = date('Y');
				$user_data = $this->session->userdata('user_data');
				//echo "<pre>";
				//print_r($user_data);die;
				$userId = $user_data['userid'];		
				$appno = '';
				if(isset($_GET['appno']))
				{
					$appno = $_GET['appno'];
				}
				if(!empty($_POST))
				{
					
					$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 
				    
					//var_dump($userInfo);die;
					unset($clean['step-one-application']);
					if($this->common_model->applicationExists($userId))
					{	
						//echo "sadasdsad";die;
						$choice_one = $clean['universty_choice'];
						$choice_two = $clean['universty_choice_two'];
						$choice_three = $clean['universty_choice_three'];
						$stateId = 0;$stateIdOne =0;$stateIdtwo=0;
						if($choice_one > 0)
						{
							$stateId = $this->common_model->getUniversityStateById($choice_one);
							$clean['university_choice_one_state'] = $stateId[0]['state'];    		
						}
						if($choice_two > 0)
						{
							$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
							$clean['university_choice_two_state'] = $stateIdOne[0]['state'];    			
						}
						if($choice_three > 0)
						{
							$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);
							$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
						}						
						$this->common_model->updateApplicationStepOne($clean,$userId);
					}
					else
					{
						$checkyear = $this->user_model->checkYear($clean['passport_no'],$year);
						//echo "<pre>";
						//var_dump($checkyear);die;
						$userInfo = $this->user_model->checkPassportYear($clean['passport_no'],$year);
						//var_dump($userInfo);die;
						$clean['status'] = 'Draft';
						$choice_one = $clean['universty_choice'];
						$choice_two = $clean['universty_choice_two'];
						$choice_three = $clean['universty_choice_three'];
						$stateId = 0;$stateIdOne =0;$stateIdtwo=0;
						//var_dump($userInfo);die;
						if($userInfo){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Application already exists this passport number');
							redirect($actual_link);
							return false;
			            }
						if($choice_one > 0)
						{
							$stateId = $this->common_model->getUniversityStateById($choice_one);
							$clean['university_choice_one_state'] = $stateId[0]['state'];    		
						}
						if($choice_two > 0)
						{
							$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
							$clean['university_choice_two_state'] = $stateIdOne[0]['state'];    			
						}
						if($choice_three > 0)
						{
							$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);
							$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
						}
						$clean['uid'] = $userId;
						$clean['application_no'] = $appno;				
						$id = $this->common_model->insertApplicationStepOne($clean);				
					}
				}
				$applicationData = $this->common_model->getApplicationStepOne($userId);		
				$data['applicaitonStepOne'] = $applicationData;
				$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);				
				$this->load->view('site/header');
				$this->load->view('site/applicant_educaion_info',$data);
				$this->load->view('site/footer');	
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
				redirect($actual_link);	
			}
		}
		public function applicant_other_info()
		{
			$actual_link =  $_SERVER['HTTP_REFERER'];
			try
			{
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$data['registerData'] = $this->common_model->getUserData($userId);
				$appno = '';
				if(isset($_GET['appno']))
				{
					$appno = $_GET['appno'];
				}	
				if(!empty($_POST))
				{
					$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 
					if($this->common_model->educationExists($userId))
					{    			
						$this->common_model->updateEducation($clean,$userId);				
					}
					else
					{
						$clean['uid'] = $userId;
						$clean['application_no'] = $appno;
						$id = $this->common_model->insertEducation($clean);				
					}
				}				
				$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);		
				$this->load->view('site/header');
				$this->load->view('site/applicant_other_info',$data);
				$this->load->view('site/footer');	
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
				redirect($actual_link);	
			}
		}
		
		public function phydical_fitness_format()
		{
			$this->load->view('site/header');
			$this->load->view('site/phydical_fitness_format');
			$this->load->view('site/footer');
		}
		public function applicant_documents()
		{
			$actual_link =  $_SERVER['HTTP_REFERER'];
			//echo "<pre>";
			//print_r($actual_link);die;
			try
			{
				$user_data = $this->session->userdata('user_data');
				$imgname = "";
				$userId = $user_data['userid'];	
				$appno = '';
				if(isset($_GET['appno']))
				{
					$appno = $_GET['appno'];
				}
				if(!empty($_POST))
				{
					$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 
					
					$clean['created'] = time();
					
					if($this->common_model->otherDetailExists($userId))
					{
						$this->common_model->updateOtherDetails($clean,$userId);
					}
					else
					{
						$clean['uid'] = $userId;
						$clean['application_no'] = $appno;
						$this->common_model->insertOtherDetails($clean);
					}
				}
				
				$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
				//echo "<pre>";
	            //print_r($data['applicaitonStepOne']);die;
				$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
				$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);	
				$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);		
				$this->load->view('site/header');
				$this->load->view('site/applicant_documents',$data);
				$this->load->view('site/footer');	
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
				redirect($actual_link);	
			}
		}
		public function uploadSignature()
		{
			try
			{
				$imgname ="";
				$files = $_FILES['file'];      		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);			
				$types = $this->config->item('doc_types');
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
				$typpe = $_FILES['file']['type'];
				$tempfile = $_FILES['file']['tmp_name'];
				$sizekbb = filesize($tempfile); //10485760= 10mb
				$head = fgets(fopen($tempfile, "r"), 5);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				//echo $section;
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
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
					return ;
				}
				if ($sizekbb > 2097152) 
				{						
					$this->session->set_flashdata('error', 'File size is not Valid!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size should be less than equal to 1 MB!'));
					return;
				}
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_profile_signature_'.$name;
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/profile_signature/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 					
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'signature_doc' =>$imgname,
						'created' =>time()
						);
						if($this->common_model->otherDetailExists($userId))
						{
							$sts = $this->common_model->updateOtherDetails($data,$userId);
						}
						else
						{
							$data['uid'] = $userId;
							$data['application_no'] = $applicatinNo[0]['application_no'];
							$sts = $this->common_model->insertOtherDetails($data);
						}
						if($sts)
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
		
		public function uploadTranslation()
		{
			try
			{
				$files = $_FILES['file'];      		
				$typpe = $_FILES['file']['type'];   
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);			
				$types = $this->config->item('doc_types');
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG files are allowed."));
						return false;
					}
				}				
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
					return;
				}
				if ($sizekbb > 5242880) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must less than equal to 5MB!'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Translation_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/translation/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 	
					
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['tl']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);
						
						if($this->common_model->insertDocuments($data))
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
		
		public function uploadTranslationSfs()
		{
			try
			{
				$files = $_FILES['file'];      		
				$typpe = $_FILES['file']['type'];   
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);			
				$types = $this->config->item('doc_types');
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG files are allowed."));
						return false;
					}
				}				
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
					return;
				}
				if ($sizekbb > 5242880) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must less than equal to 5MB!'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Translation_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/SFS_translation/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 	
					
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['tl']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);
						
						if($this->common_model->insertSfsDocuments($data))
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
		public function uploadLicence()
		{
			try
			{
				$files = $_FILES['file'];   
				$typpe = $_FILES['file']['type'];    		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);			
				$types = $this->config->item('doc_types');
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must less than equal to 1MB!'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_International_licence_'.$name;	
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/licence/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['dl']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);
						
						if($this->common_model->insertDocuments($data))
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
		public function uploadMphil()
		{
			try
			{
				$files = $_FILES['file'];    
				$typpe = $_FILES['file']['type'];   		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];		
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);	
				$types = $this->config->item('doc_types');
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must less than equal to 1MB'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Mphil_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/Mphil/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 
					 
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['mhil']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);
						
						if($this->common_model->insertDocuments($data))
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
		public function uploadPassport()
		{
			try
			{
				$files = $_FILES['file'];      
				$typpe = $_FILES['file']['type']; 			
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);		
				$types = $this->config->item('doc_types');
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 1MB.'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Passport_'.$name;		
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/Passport/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['passport']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);
						
						if($this->common_model->insertDocuments($data))
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
		
		public function uploadPassportSfs()
		{
			try
			{
				$files = $_FILES['file'];      
				$typpe = $_FILES['file']['type']; 			
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);		
				$types = $this->config->item('doc_types');
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 1MB.'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Passport_'.$name;		
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/SFS_Passport/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['passport']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);
						
						if($this->common_model->insertSfsDocuments($data))
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
		
		public function uploadSchoolLeavingSfs()
		{
			try
			{
				$files = $_FILES['file'];  
				$typpe = $_FILES['file']['type']; 	    		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
					echo json_encode(array('status'=>FALSE,"message"=>"File size must less than equal to 1MB"));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_school_Leaving_'.$name;
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/SFS_school_Leaving/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					 
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['school_leaving']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);
						
						if($this->common_model->insertSfsDocuments($data))
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
		public function uploadSchoolLeaving()
		{
			try
			{
				$files = $_FILES['file'];  
				$typpe = $_FILES['file']['type']; 	    		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
					echo json_encode(array('status'=>FALSE,"message"=>"File size must less than equal to 1MB"));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_school_Leaving_'.$name;
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/school_Leaving/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					 
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['school_leaving']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);
						
						if($this->common_model->insertDocuments($data))
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
		
			public function uploadUnderGraduateSfs()
		{
			try
			{
				$files = $_FILES['file'];  
				$typpe = $_FILES['file']['type']; 	    		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 1MB!'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Under_Graduate_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/SFS_Under_Graduate/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['ug']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);				  	  
						if($this->common_model->insertSfsDocuments($data))
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
		public function uploadUnderGraduate()
		{
			try
			{
				$files = $_FILES['file'];  
				$typpe = $_FILES['file']['type']; 	    		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 1MB!'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Under_Graduate_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/Under_Graduate/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['ug']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);				  	  
						if($this->common_model->insertDocuments($data))
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
		public function uploadPostGraduate()
		{
			try
			{
				$files = $_FILES['file'];      
				$typpe = $_FILES['file']['type']; 		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');		
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,'message'=>'File content is not Valid!'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE));
					return;
				}
			
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Post_Graduate_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/Post_Graduate/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['pg']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);			  	  
						if($this->common_model->insertDocuments($data))
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
		
		
		public function uploadPhd()
		{
			try
			{
				$files = $_FILES['file'];   
				$typpe = $_FILES['file']['type'];   		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
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
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_PHD_'.$name;
					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/PHD/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['phd']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						); 				  	  
						if($this->common_model->insertDocuments($data))
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
		public function uploadPhdSfs()
		{
			try
			{
				$files = $_FILES['file'];   
				$typpe = $_FILES['file']['type'];   		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
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
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_PHD_'.$name;
					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/SFS_PHD/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['phd']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						); 				  	  
						if($this->common_model->insertSfsDocuments($data))
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
		public function uploadPanCard()
		{
			try
			{
				$files = $_FILES['file'];      		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];		
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Pand_Card_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/Pand_Card/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['pan']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);				  	  
						if($this->common_model->insertDocuments($data))
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
		public function uploadIdProof()
		{
			try
			{
				$files = $_FILES['file'];     
				$typpe = $_FILES['file']['type']; 		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');		
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,'message'=>'Invalid File.'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 5MB.'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_ID_Proof_'.$name;
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/ID_Proof/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['id']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);				  	  
						if($this->common_model->insertDocuments($data))
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
		
		public function uploadIdProofSfs()
		{
			try
			{
				$files = $_FILES['file'];     
				$typpe = $_FILES['file']['type']; 		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');		
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,'message'=>'Invalid File.'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must be less than equal to 5MB.'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_ID_Proof_'.$name;
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/SFS_ID_Proof/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['id']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);				  	  
						if($this->common_model->insertSfsDocuments($data))
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
		
		
		public function uploadAddressProof()
		{
			try
			{
				$files = $_FILES['file'];    
				$typpe = $_FILES['file']['type'];    
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);		
				$types = $this->config->item('doc_types');
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,'message'=>'File content is not Valid!'));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size must less than equal to 5MB!'));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Address_Proof_'.$name;
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/Address_Proof/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 		
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['indian_address']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);			  	  
						if($this->common_model->insertDocuments($data))
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
		public function uploadPhysicalFitness()
		{
			try
			{
				
				$files = $_FILES['file']; 
				$typpe = $_FILES['file']['type'];     		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,"message"=>"File Size Should be less than 5MB."));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Physical_Fitness_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/Physical_Fitness/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['physical']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);			  	  
						if($this->common_model->insertDocuments($data))
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
		
			public function uploadPhysicalFitnessSfs()
		{
			try
			{
				
				$files = $_FILES['file']; 
				$typpe = $_FILES['file']['type'];     		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
				{					
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
					return;
				}
				if ($sizekbb > 2097152) 
				{
					$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
					echo json_encode(array('status'=>FALSE,"message"=>"File Size Should be less than 5MB."));
					return;
				}
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Physical_Fitness_'.$name;					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/SFS_Physical_Fitness/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['physical']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);			  	  
						if($this->common_model->insertSfsDocuments($data))
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
		
		
		
		public function uploadProfilePic()
		{
			try
			{
				$files = $_FILES['file']; 
                //echo "<pre>";
				//print_r($files);die;				
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];		
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/profile_pics/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						if($this->common_model->imageExists($userId))
						{
							if($this->common_model->uploadProfilePic($imgname,$userId))
							{			      	
								echo json_encode(array('status'=>TRUE, 'file_path'=> base_url().$target_file));
							}
						}	
						else
						{
							if($this->common_model->insertUserImage($imgname,$userId))
							{			      	
								echo json_encode(array('status'=>TRUE, 'file_path'=> base_url().$target_file));
							}
						}
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
		
		//sfs/applicant_sfs_educaion_info
		
		public function uploadProfileSfsPic()
		{
			try
			{
				$files = $_FILES['file']; 
                //echo "<pre>";
				//print_r($files);die;				
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];		
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/profile_sfs_pics/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						if($this->common_model->imageSfsExists($userId))
						{
							if($this->common_model->uploadSfsProfilePic($imgname,$userId))
							{			      	
								echo json_encode(array('status'=>TRUE, 'file_path'=> base_url().$target_file));
							}
						}	
						else
						{
							if($this->common_model->insertSfsUserImage($imgname,$userId))
							{			      	
								echo json_encode(array('status'=>TRUE, 'file_path'=> base_url().$target_file));
							}
						}
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
		public function register()
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
			$this->load->view('site/header');
			$this->load->view('site/register',$data);
			$this->load->view('site/footer');
		}
		
		public function status()
		{
			try{		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);	
				$this->load->view('site/sfs/header');
				$this->load->view('site/sfs/status',$data);
				$this->load->view('site/sfs/footer');
			}
			catch(Exception $e)
			{
				
			}
		}
			public function dashboard()
		{
			try{	
				
				$user_data = $this->session->userdata('user_data');	
				//echo "<pre>";
			    //print_r($user_data);die;
				$userId = $user_data['userid'];	
				$userType = $user_data['user_type'];	
				$data['applicaitonSfsStepOne'] = $this->common_model->getApplicationSfsStepOne($userId);
				$data['academicSfsDeatils'] = $this->common_model->getAcademicDetailsofSfsApplicant($data['applicaitonSfsStepOne'][0]['application_no']);
				$data['username'] = $user_data['email'];
				$this->load->view('site/sfs/header');
				$this->load->view('site/sfs/dashboard',$data);
				$this->load->view('site/sfs/footer');
			}
			catch(Exception $e)
			{
				
			}
		}
		public function complete()
		{
			try{
				$token      = base64_decode($this->uri->segment(4));
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
						echo '<script>window.location.href="'.site_url().'home?text=Login Successfully!.&type=Thank You!&at=success&redirect='.site_url().'home/dashboard/student";</script>';       
						
					}
					else
					{
						if (!$userInfo) {            	
							
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
		public function applicant_guidlines()
		{
			$this->load->view('site/header');
			$this->load->view('site/applicant_guidlines');
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
		public function base64url_encode($data)
		{
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
		}
		public function base64url_decode($data)
		{
			return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
		}
		public function selectedUnvercity()
		{
			$response = array('status'=>FALSE,'data'=>array(),'csrfName'=>'','csrfHash'=>'');	
			try
			{			
				$id=$this->input->post('university');  
				$id1=$this->input->post('university1');   		
				$unvercitiesids=$this->common_model->getSelectedUnvercities($id,$id1);
				if(count($unvercitiesids) > 0)
				{
					$response['status'] = TRUE;
					foreach($unvercitiesids as $row)
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
		public function getCourseByPrgramme()
		{
			$response = array('status'=>FALSE,'data'=>array(),'csrfName'=>'','csrfHash'=>'','stateuniversities'=>array(),'centraluniversities'=>array(),'nit'=>array());	$courses = array();
			try
			{			
				$id=$this->input->post('programme'); 
				$ctype = $this->input->post('course_type'); 
				
				if($id == 3 || $id == 4 || $id == 5 || $id == 6 || $id == 7)
				{
					if($id == 3 || $id == 4)
					{
						$states = $this->common_model->getAllStates();
						foreach($states as $state)
						{
							//$univesities = $this->common_model->getUniversitiesByTypeAndStateId($state['id'],2);
							
							if(array_key_exists($state['id'],$response['stateuniversities']))
							{
								$response['stateuniversities'][$state['name']] = array();	
							}
							$response['stateuniversities'][$state['id']] = array('stateid');
						}	
					}
					if($id == 5 || $id == 6 || $id == 7)
					{
						
					}
				}  	
				
				$courses = $this->common_model->getCourseByPrgrammeAndType($id,$ctype);
				
				if(count($courses) > 0)
				{
					$response['status'] = TRUE;
					foreach($courses as $row)
					{
						$response['data'][] = $row;
					}
				}
				$stateUniversities = $this->common_model->getStateUniversitiesWithMapping($id,$ctype);
				//print_r($stateUniversities);
				if(count($stateUniversities) > 0)
				{
					$response['stateUniversities'] = $stateUniversities;
				}
				$centralUniversities = $this->common_model->getCentralUniversitiesWithMapping($id,$ctype);
				if(count($centralUniversities) > 0)
				{
					$response['centralUniversities'] = $centralUniversities;
				}
				else
				{
					$response['centralUniversities'] = array();
				}
				
			}
			catch(Exception $e)
			{
				echo json_encode($response);
			}
			echo json_encode($response);
		}
		public function logout()
		{
			$this->session->unset_userdata('user_data');
			$this->session->unset_userdata('salt');
			$this->session->sess_destroy();
			redirect('home');
		}	
		
		//=================Added by Rahul Dey==================
		
		public function getCourseType()
		{
			
			$program_type = $_POST['programme'];
			$result = $this->common_model->getAllPhdCourseType($program_type);
			$ctypeHtml = '';
			$ctypeHtml .="<option value='0'>Course Type</option>";
			foreach($result as $val)		
			{
			$ctypeHtml .="<option value='".$val['id']."'>".$val['course_type']."</option>";	
			}
			echo $ctypeHtml;
			exit;
		}



		public function uploadPhdResearchPaper()
		{
			try
			{
				$files = $_FILES['file'];   
				$typpe = $_FILES['file']['type'];   		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
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
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_Phd_Research'.$name;
					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/Phd_Research/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['phdReseachPaper']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						); 				  	  
						if($this->common_model->insertDocuments($data))
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
		
		public function uploadOtherDocsSfs()
		{
			try
			{
				$files = $_FILES['file'];   
				$typpe = $_FILES['file']['type'];   		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
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
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_other_Doc_'.$name;
					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/SFS_other_Doc/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['otherDoc']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						); 				  	  
						if($this->common_model->insertSfsDocuments($data))
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
		public function uploadOtherDocs()
		{
			try
			{
				$files = $_FILES['file'];   
				$typpe = $_FILES['file']['type'];   		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
				$types = $this->config->item('doc_types');	
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
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
				
				if($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ")
				{
					if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) 
					{
						$this->session->set_flashdata('error', 'File content is not Valid!');
						echo json_encode(array('status'=>FALSE,"message"=>"File Content is Not Valid."));
						return false;
					}
				}
				if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
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
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE,"message"=>"File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_other_Doc_'.$name;
					
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/other_Doc/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						$data = array(
			  			'document_name'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['otherDoc']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						); 				  	  
						if($this->common_model->insertDocuments($data))
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
		
		
		
		
		//Sfs Form
		
		
		
		
		
		
				public function applicant_sfs_personal_info()
		{
			//echo "sadasd";die;
			try
			{
				$user_data = $this->session->userdata('user_data');	
				$userId = $user_data['userid'];	
				$userType = $user_data['user_type'];
				$data['registerSfsData'] = $this->common_model->getSfsUserData($userId);
				$imgArray = $this->common_model->getSfsUserImage($userId);
				if(count($imgArray)> 0)
				{
					$data['userImage'] = $imgArray[0]['name'];
				}		
				else
				{
					$data['userImage'] = '';
				}
				$applicationData = $this->common_model->getApplicationSfsStepOne($userId);
				
				$data['applicaitonSfsStepOne'] = $applicationData;
				$data['missions'] = $this->common_model->getAllMissions();
				if(count($data['applicaitonSfsStepOne'])>0)
				{
					$data['get_application_number'] = $data['applicaitonSfsStepOne'][0]['application_no'];
				}
				else
				{
					$data['missions'] = $this->common_model->getAllMissions();
					$data['get_application_number'] = $this->random_num(15);
				}
				
				if(count($applicationData)>0 && $applicationData[0]['status'] == "Draft")
				{
					$data['applicaitonSfsStepOne'] = $applicationData;
					$data['univercities'] = $this->common_model->getUnivercities();			
					$this->load->view('site/sfs/header');
					$this->load->view('site/sfs/applicant_sfs_personal_info',$data);
					$this->load->view('site/sfs/footer');
				}
				elseif(count($applicationData)>0 && $applicationData[0]['status'] == "Submit" )
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You have already applied!');
					redirect(site_url().'sfs/dashboard');	
				}
				else
				{
					$data['applicaitonSfsStepOne'] = $applicationData;
					$data['univercities'] = $this->common_model->getUnivercities();			
					$this->load->view('site/sfs/header');
					$this->load->view('site/sfs/applicant_sfs_personal_info',$data);
					$this->load->view('site/sfs/footer');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
				redirect(site_url().'sfs/dashboard');	
			}		
		}
		
		
		
		
				public function applicant_sfs_education_info()
		{
			//echo "<pre>";
			//print_r($_POST);die;
			$actual_link =  $_SERVER['HTTP_REFERER'];
			try
			{
				$year = date('Y');
				$user_data = $this->session->userdata('user_data');
				//echo "<pre>";
				//print_r($user_data);die;
				$userId = $user_data['userid'];		
				$appno = '';
				if(isset($_GET['appno']))
				{
					$appno = $_GET['appno'];
				}
				if(!empty($_POST))
				{
					
					$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 
				    
					//var_dump($userInfo);die;
					unset($clean['step-one-application']);
					if($this->common_model->applicationSfsExists($userId))
					{	
						//echo "sadasdsad";die;
						$choice_one = $clean['universty_choice'];
						$choice_two = $clean['universty_choice_two'];
						$choice_three = $clean['universty_choice_three'];
						$stateId = 0;$stateIdOne =0;$stateIdtwo=0;
						if($choice_one > 0)
						{
							$stateId = $this->common_model->getUniversityStateById($choice_one);
							$clean['university_choice_one_state'] = $stateId[0]['state'];    		
						}
						if($choice_two > 0)
						{
							$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
							$clean['university_choice_two_state'] = $stateIdOne[0]['state'];    			
						}
						if($choice_three > 0)
						{
							$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);
							$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
						}						
						$this->common_model->updateApplicationSfsStepOne($clean,$userId);
					}
					else
					{
						//$checkyear = $this->user_model->checkYear($clean['passport_no'],$year);
						//echo "<pre>";
						//var_dump($checkyear);die;
						//$userInfo = $this->user_model->checkPassportYear($clean['passport_no'],$year);
						//var_dump($userInfo);die;
						$clean['status'] = 'Draft';
						$choice_one = $clean['universty_choice'];
						$choice_two = $clean['universty_choice_two'];
						$choice_three = $clean['universty_choice_three'];
						$stateId = 0;$stateIdOne =0;$stateIdtwo=0;
						//var_dump($userInfo);die;
						/* if($userInfo){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Application already exists this passport number');
							redirect($actual_link);
							return false;
			            } */
						if($choice_one > 0)
						{
							$stateId = $this->common_model->getUniversityStateById($choice_one);
							$clean['university_choice_one_state'] = $stateId[0]['state'];    		
						}
						if($choice_two > 0)
						{
							$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
							$clean['university_choice_two_state'] = $stateIdOne[0]['state'];    			
						}
						if($choice_three > 0)
						{
							$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);
							$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
						}
						$clean['uid'] = $userId;
						$clean['application_no'] = $appno;				
						$id = $this->common_model->insertApplicationSfsStepOne($clean);				
					}
				}
				$applicationData = $this->common_model->getApplicationSfsStepOne($userId);		
				$data['applicaitonSfsStepOne'] = $applicationData;
				$data['applicaitonSfsStepTwo'] = $this->common_model->getApplicationSfsStepTwo($userId);				
				$this->load->view('site/sfs/header');
				$this->load->view('site/sfs/applicant_sfs_educaion_info',$data);
				$this->load->view('site/sfs/footer');	
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
				redirect($actual_link);	
			}
		}
		
		
		public function applicant_sfs_other_info()
		{
			//echo "sfs";die;
			$actual_link =  $_SERVER['HTTP_REFERER'];
			try
			{
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$data['registerSfsData'] = $this->common_model->getSfsUserData($userId);
				$appno = '';
				if(isset($_GET['appno']))
				{
					$appno = $_GET['appno'];
				}	
				if(!empty($_POST))
				{
					$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 
					$clean['created'] = date("Y-m-d h:i:s");
					if($this->common_model->educationSfsExists($userId))
					{    			
						$this->common_model->updateSfsEducation($clean,$userId);				
					}
					else
					{
						$clean['uid'] = $userId;
						$clean['application_no'] = $appno;
						$clean['created'] = date("Y-m-d h:i:s");
						//echo "<pre>";print_r($clean);die;
						$id = $this->common_model->insertSfsEducation($clean);				
					}
				}				
				$data['applicaitonSfsStepThree'] = $this->common_model->getApplicationSfsStepThree($userId);		
				$this->load->view('site/header');
				$this->load->view('site/sfs/applicant_sfs_other_info',$data);
				$this->load->view('site/footer');	
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
				redirect($actual_link);	
			}
		}
		
		
			public function applicant_sfs_documents()
		{
			$actual_link =  $_SERVER['HTTP_REFERER'];
			//echo "<pre>";
			//print_r($actual_link);die;
			try
			{
				$user_data = $this->session->userdata('user_data');
				$imgname = "";
				$userId = $user_data['userid'];	
				$appno = '';
				if(isset($_GET['appno']))
				{
					$appno = $_GET['appno'];
				}
				if(!empty($_POST))
				{
					$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 
					
					$clean['created'] = date("Y-m-d h:i:s");
					
					if($this->common_model->otherSfsDetailExists($userId))
					{
						$this->common_model->updateSfsOtherDetails($clean,$userId);
					}
					else
					{
						$clean['uid'] = $userId;
						$clean['application_no'] = $appno;
						$this->common_model->insertSfsOtherDetails($clean);
					}
				}
				
				$data['applicaitonSfsStepOne'] = $this->common_model->getApplicationSfsStepOne($userId);
				//echo "<pre>";
	            //print_r($data['applicaitonStepOne']);die;
				$data['applicaitonSfsStepThree'] = $this->common_model->getApplicationSfsStepThree($userId);
				$data['applicaitonSfsStepTwo'] = $this->common_model->getApplicationSfsStepTwo($userId);	
				$data['applicaitonSfsDocuments'] = $this->common_model->getApplicationSfsDocuments($userId);		
				$this->load->view('site/header');
				$this->load->view('site/sfs/applicant_sfs_documents',$data);
				$this->load->view('site/footer');	
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
				redirect($actual_link);	
			}
		}
		
		
		public function uploadSfsSignature()
		{
			try
			{
				$imgname ="";
				$files = $_FILES['file'];      		
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];
				$applicatinNo =  $this->common_model->getSfsApplicationNoByUserId($userId);			
				$types = $this->config->item('doc_types');
				
				
				/*******File Content Check**********/
				$fnmae = $_FILES['file']['name'];
				$typpe = $_FILES['file']['type'];
				$tempfile = $_FILES['file']['tmp_name'];
				$sizekbb = filesize($tempfile); //10485760= 10mb
				$head = fgets(fopen($tempfile, "r"), 5);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				//echo $section;
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
					echo json_encode(array('status'=>FALSE,'message'=>'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
					return ;
				}
				if ($sizekbb > 2097152) 
				{						
					$this->session->set_flashdata('error', 'File size is not Valid!');
					echo json_encode(array('status'=>FALSE,'message'=>'File size should be less than equal to 1 MB!'));
					return;
				}
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png")
				{
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
					echo json_encode(array('status'=>FALSE));
					return;
				}
				
				if($files["name"] != "")
				{				
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_profile_signature_'.$name;
					
					if($user_data['dir'] == "")
					{
						$target_file = 'assets/site/main/profile_sfs_signature/';
					}
					else
					{
						$target_file = $user_data['dir'].'/';
					}
					$target_file = $target_file.$imgname; 					
					$date = date("Y-m-d h:i:s");
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
						$data = array(
			  			'signature_doc' =>$imgname,
						'created' =>time()
						);
						if($this->common_model->otherSfsDetailExists($userId))
						{
							$sts = $this->common_model->updateSfsOtherDetails($data,$userId);
						}
						else
						{
							$data['uid'] = $userId;
							$data['application_no'] = $applicatinNo[0]['application_no'];
							$sts = $this->common_model->insertSfsOtherDetails($data);
						}
						if($sts)
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
	}

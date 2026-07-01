<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Common_model $common_model
 * @property User_model $user_model
 * @property CI_Upload $upload
 * @property stdClass $ids
 */
class Applicant extends CI_Controller
{

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
		$this->load->helper('status_helper');
		$this->load->model('user_model');
		$this->load->model('common_model');
		$this->load->library('mpdf60/Mpdf');
		$this->load->helper('pdf_helper');
		$this->load->library('fpdi/PDF_HTML');
		//$this->load->library('fpdi/Htmltable');     
		$this->load->helper('file');
		$userdata = $this->session->userdata('user_data');
		//echo "<pre>";print_r($userdata);die;




		if (!$this->session->userdata('user_data')) {
			redirect('home');
		} else {
			$roles = $this->config->item('roles_id');
			$role = $roles[$userdata['user_type']];
			//echo "<pre>";print_r($role);die;
			switch ($role) {
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


		// add timeout configration here

	ini_set("max_execution_time", "-1");
	ini_set("memory_limit", "-1");
	ignore_user_abort(true);
	set_time_limit(0);
	}

	
 function strip_quotes($str)
	{
		// return str_replace(array('"', "'", '>', '<'), '', $str);
		$arr=array();
		foreach($str as $k=>$p){
	        $arr[$k] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $p);
	        $arr[$k] = preg_replace('/-+/', '-', $p);
	        // $arr[$k] = filter_var($p, 'FILTER_SANITIZE_STRING');
	         //$arr[$k] = htmlspecialchars($p);

	        $arr[$k] = str_replace(array('<', '>', '"', ';', 'script', 'alert', 'prompt', 'onmouseover', 'javascript', '&lt;', '&gt;'), array('', '', '', '', '', '', '', '', '', '', ''), $p);
	        // $arr[$k] = strip_tags($p);
    	}
    	return $arr;
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
		$postData = $this->input->post(NULL, TRUE);
		if (count($postData) > 0) {
			  $cleanDatas = $this->security->xss_clean($postData);
			  $cleanData =  $this->strip_quotes($cleanDatas);
			
			//$cleanData = $this->security->xss_clean($postData);
			$link = $cleanData['youtubelink'];
			$sts = $this->common_model->saveYoutubeLink($userId, $link);
			if ($sts) {
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Youtube Link Added!');
				redirect(site_url() . 'applicant/dashboard');
			} else {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur while adding Youtube Link. Please try again.');
				redirect(site_url() . 'applicant/dashboard');
			}
		}
	}
	public function changepassword()
	{
		try {
			$user_data = $this->session->userdata('user_data');
			$postData = $this->input->post(NULL, TRUE);
			if (count($postData) > 0) {
				$cleanDatas = $this->security->xss_clean($postData);
			   $cleanData =  $this->strip_quotes($cleanDatas);
				if (count($this->common_model->oldPasswordMatched($cleanData['id'], $cleanData['oldpassword']))) {
					$profileData = array(
						'id' => $cleanData['id'],
						'password' => $cleanData['newpassword']
					);
					$message = '';
					$message .= '<strong>Your Password has been updated Sucessfully.</strong><br><br>';
					$data = array(
						'content' => $message
					);
					$config = array(
						'mailtype' => 'html'
					);
					$content = $this->load->view('change_password', $data, true);
					$from_email = "diritc.iccr@gov.in";

					$to_email = $user_data['email'];
					/* Load email library */
					$this->load->library('email', $config);
					$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)');
					$this->email->to($to_email);
					$this->email->subject('Indian Council for Cultural Relations (ICCR)');
					$this->email->message($content);
					if ($this->email->send()) {
						$status = $this->common_model->updateProfilePassword($profileData);
						if ($status) {
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Password Successfully Updated!');
						} else {
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error Occur While Updating Password! Try Again Later.');
						}
					} else {
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error Occur While Email not send! Try Again Later.');
					}
				} else {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Old Password Not Matched.');
				}
			}
			$data['head'] = $this->session->userdata('user_data');
			$this->load->view('site/header');
			$this->load->view('site/changepassword', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
			redirect(site_url() . 'headquarter/dashboard');
		}
	}
	public function submitbankDetails()
	{
		//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		 $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
	     $clean =  $this->strip_quotes($cleanData);
		$rid = 0;
		$schid = 0;
		$signature = "";

		$appid = $clean['appid'];
		$bankName = $clean['bankname'];
		$accno = $clean['accno'];
		$uresponse = $this->common_model->getUResponseById($appid);
		$uresponse1 = $this->common_model->getUTwoResponseById($appid);
		$imgname = "";
		$files = $_FILES['bank_doc'];
		if ($files["name"] != "") {
			$name = str_replace(" ", "_", $files['name']);
			$imgname = time() . '_bank_doc_' . $name;
			$target_file = 'assets/site/main/bank_docs/' . $imgname;
			if (move_uploaded_file($_FILES["bank_doc"]["tmp_name"], $target_file)) {
				if (count($uresponse) > 0) {
					$rid = $uresponse[0]['region_one_status'];
					$signature = $uresponse[0]['signature_doc'];
				} elseif (count($uresponse1) > 0) {
					$rid = $uresponse1[0]['region_one_status'];
					$signature = $uresponse1[0]['signature_doc'];
				}

				$data = array(
					'regionId' => $rid,
					'application_id' => $appid,
					'bankname' => $bankName,
					'account_no' => $accno,
					'bank_off_sign' => $signature,
					'bank_doc' => $imgname,
					'bank_off_name' => 'Applicant',
					'created' => time()
				);
				$status = $this->common_model->insertBankDetails($data);
				if ($status) {
					$data['message']['type'] = 1;
					$data['message']['text'] = "Bank Details Added Successfully";
					$data['message']['redirect'] = site_url() . 'applicant/bankdetails/' . $appid;
					$this->load->view("site/msg", $data);
				} else {
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error While Adding Bank Details! Try After Some Time";
					$data['message']['redirect'] = site_url() . 'applicant/bankdetails/' . $appid;
					$this->load->view("site/msg", $data);
				}
			} else {
				$data['message']['type'] = 2;
				$data['message']['text'] = "Error While Adding Bank Details! Try After Some Time";
				$data['message']['redirect'] = site_url() . 'applicant/bankdetails/' . $appid;
				$this->load->view("site/msg", $data);
			}
		} else {
			$data['message']['type'] = 2;
			$data['message']['text'] = "Error While Adding Bank Details! Try After Some Time";
			$data['message']['redirect'] = site_url() . 'applicant/bankdetails/' . $appid;
			$this->load->view("site/msg", $data);
		}
	}
	public function submitcomplaint()
	{
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
		//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$rid = 0;
		$schid = 0;
		$category = $clean['complaint_id'];
		$appid = $clean['appid'];
		$desc = $clean['description'];
		$othercat = $clean['other_cat'];
		$uresponse = $this->common_model->getUResponseById($appid);
		$uresponse1 = $this->common_model->getUTwoResponseById($appid);
		$imgname = "";
		$files = $_FILES['applicant_signature'];
		if ($files["name"] != "") {
			$name = str_replace(" ", "_", $files['name']);
			$imgname = time() . '_complaint_signature_' . $name;
			$target_file = 'assets/site/main/complaint_signature/' . $imgname;
			if (move_uploaded_file($_FILES["applicant_signature"]["tmp_name"], $target_file)) {
				if (count($uresponse) > 0) {
					$rid = $uresponse[0]['region_one_status'];
					$schid = $uresponse[0]['scholarship_id'];
				} elseif (count($uresponse1) > 0) {
					$rid = $uresponse1[0]['region_one_status'];
					$schid = $uresponse1[0]['scholarship_id'];
				}

				$data = array(
					'cid' => $this->uri->segment(3),
					'appid' => $appid,
					'category' => $category,
					'descripton' => $desc,
					'signature' => $imgname,
					'created' => time(),
					'rid' => $rid,
					'scheme' => $schid
				);
				$status = $this->common_model->insertComplaint($data);
				if ($status) {
					$data['message']['type'] = 1;
					$data['message']['text'] = "Complaint Created Successfully";
					$data['message']['redirect'] = site_url() . 'applicant/complaints/' . $appid;
					$this->load->view("site/msg", $data);
				} else {
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error While Creating Complaint! Try After Some Time";
					$data['message']['redirect'] = site_url() . 'applicant/complaints/' . $appid;
					$this->load->view("site/msg", $data);
				}
			} else {
				$data['message']['type'] = 2;
				$data['message']['text'] = "Error While Creating Complaint! Try After Some Time";
				$data['message']['redirect'] = site_url() . 'applicant/complaints/' . $appid;
				$this->load->view("site/msg", $data);
			}
		} else {
			$data['message']['type'] = 2;
			$data['message']['text'] = "Error While Creating Complaint! Try After Some Time";
			$data['message']['redirect'] = site_url() . 'applicant/complaints/' . $appid;
			$this->load->view("site/msg", $data);
		}
	}
	public function addBankDetails()
	{
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);
		$this->load->view('site/header');
		$this->load->view('site/addBankDetails', $data);
		$this->load->view('site/footer');
	}
	public function addFRRODetails()
	{
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);
		$this->load->view('site/header');
		$this->load->view('site/addFRRODetails', $data);
		$this->load->view('site/footer');
	}
	public function createcomplaint()
	{
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);
		$data['complaint_no'] = 'COMPLAINT' . $this->random_num(4);
		$this->load->view('site/header');
		$this->load->view('site/createcomplaints', $data);
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
		$this->load->view('site/complaints', $data);
		$this->load->view('site/footer');
	}
	public function bankdetails()
	{
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$appid = $this->uri->segment(3);
		$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);
		$data['bankDetails'] = $this->common_model->getBankingDetails($appid, "");
		$this->load->view('site/header');
		$this->load->view('site/bankdetails', $data);
		$this->load->view('site/footer');
	}
	public function frroDetails()
	{
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$appid = $this->uri->segment(3);
		$data['applicaitonStatus'] = $this->common_model->getApplicationStatus($userId);
		$data['frroDetails'] = $this->common_model->getPermitDetails($appid, "");
		$this->load->view('site/header');
		$this->load->view('site/frroDetails', $data);
		$this->load->view('site/footer');
	}
	public function viewProfile()
	{
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['registerData'] = $this->common_model->getUserData($userId);
		$this->load->view('site/header');
		$this->load->view('site/profile', $data);
		$this->load->view('site/footer');
	}
	public function viewApplication()
	{

		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);

		$this->load->view('site/header');
		$this->load->view('site/full_application', $data);
		$this->load->view('site/footer');
	}
	public function downloadApplication()
	{

		try {


			/*
					---- ---- ---- ----
					your code here
					---- ---- ---- ----
				*/
			$data = $this->uri->segment(3);
			$this->load->view('pdfreport', $data);
			//die;
			//header("Content-type: application/pdf");
			$appno = $this->uri->segment(3);

			$content = $this->input->post("myHTML");

			// 		$pdfString = $mpdf->Output($pdfnm,'D');
			// die;
			$mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
			// $mpdf->SetFont('Arial','B',9);
			$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
			$mpdf->watermark_font = 'DejaVuSansCondensed';
			$mpdf->showWatermarkText = true;
			$mpdf->showImageErrors = true;

			$html1 = "<div style='text-align:center;'><img width='300px' src='assets/site/main/images/mea-logo.png'></div><br/><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:0;font-weight:normal;'>Application Form For Scholarship through ICCR</h3><br/>";
			$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>Ref. No." . $appno . '<br/>' . date("jS F Y h:i:s") . "</div>";
			//$imgArray = $this->common_model->getUserImage($data[0]['uid']);		  

			$mpdf->SetDisplayMode('fullpage');
			// LOAD a stylesheet
			$stylesheet = file_get_contents('assets/site/main/css/bootstrap_custom.css');

			// $mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet1 = file_get_contents('assets/site/main/css/font-awesome.min.css');
			// $mpdf->WriteHTML($stylesheet1,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet2 = file_get_contents('assets/site/main/css/AdminLTE.min.css');
			// $mpdf->WriteHTML($stylesheet2,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet3 = file_get_contents('assets/site/main/css/mea-portal.css');
			// $mpdf->WriteHTML($stylesheet3,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$stylesheet4 = file_get_contents('assets/site/main/css/jquery-ui.css');
			// $mpdf->WriteHTML($stylesheet4,1); // The parameter 1 tells that this is css/style only and no body/html/text

			$stylesheet5 = file_get_contents('assets/site/main/css/mea-portal-custom-pdf-view.css');
			// $mpdf->WriteHTML($stylesheet5, 1); // The parameter 1 tells that this is css/style only and no body/html/text
			// $mpdf->WriteHTML($html1,1);
			// $mpdf->WriteHTML($content);	
			$pdfnm = 'abc.pdf';
			$pdfString = $mpdf->Output($pdfnm, 'D');
			// header("Content-Disposition: attachment; filename='".$appno.".pdf\""); 
			// header("Content-Transfer-Encoding: binary");
			// header("Content-Length: " . mb_strlen($pdfString));	
		} catch (HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
	}
	public function getMissionsByCountry()
	{
		$response = array('status' => FALSE, 'jsondata' => array());
		$country = $this->input->post("countryId");
		$data = $this->common_model->getMissionsByCountry($country);
		if (count($data) > 0) {
			$response['status'] = TRUE;
			$response['jsondata'] = $data;
		}
		echo json_encode($response);
	}
	public function sendMail($message_body, $email, $subject, $view)
	{
		try {
			$message = '';
			//$message .= '<strong>Dear Applicant ('.$email.'),</strong><br><br>';
			$message .= $message_body;
			$data = array(
				'content' => $message
			);
			$config = array(
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
			//$this->email->initialize($config);
			$content = $this->load->view($view, $data, true);
			$from_email = "splspd.iccr@nic.in";
			$to_email = $email;
			/* Load email library */
			// $this->load->library('email',$config);			   
			//$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
			//$this->email->to($to_email);
			//$this->email->subject($subject); 
			//$this->email->message($content); 			   
			// if($this->email->send()) 
			// {
			// return TRUE;
			// }					
			// else 
			return FALSE;
		} catch (Exception $e) {
		}
	}
	public function index() 
	{
		try {
			//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$emailId = $user_data['email'];

			$usename = $user_data['fname'];
			$student_type = $user_data['student_type'];
			$student_course_type = $user_data['apply_course_type'];
			//echo "<pre>";print_r($student_type);die;
			$prgid = $user_data['apply_course_type'];
			//echo "<pre>";
			//print_r($user_data);
			//print_r($clean);die;
			if (!empty($_POST)) {


				$appno = '';
				if (isset($_GET['appno'])) {
					$appno = $_GET['appno'];
				}
				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
				$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				//echo "<pre>";
				//print_r($clean);die;
				$applicaitonsResubmitStatus = $this->common_model->getCommonApplicationStatus($appno, '', '');
				//$universityId,$flag
				//echo "<pre>";print_r($applicaitonsResubmitStatus);die;
				if ($clean['undertaking'] == '' || $clean['undertaking'] != '') {
					if ($student_type == 1 && $student_course_type == 10) {
						$applicat = $this->common_model->getApplicationStepOne($userId);
						if ($applicat[0]['status'] == "Pending") {
							$submitApp = array(
								'status' => 6
							);
							$this->common_model->updateApplicationMapStatus($appno, $submitApp);
						} else {
							$submitApp = array(
								'uid' => $userId,
								'application_no' => $appno,
								'mission_status_date' => '',
								'mission_doc' => '',
								'iccr_status_date' => '',
								'iccr_doc' => '',
								'status' => 1,
								'status_update_date' => time(),
								'mission_status' => -1,
								'iccr_status' => -1,
								'region_one_status' => -1,
								'region_two_status' => -1,
								'region_three_status' => -1,
								'region_four_status' => -1,
								'region_five_status' => -1,
								'universities_status' => -1,
								'created' => time()
							);
							$this->common_model->insertApplicationMapStatus($submitApp);
						}
						$sts = $this->common_model->updateApplicationStatus($appno, $userId);
						if ($sts) {
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Your Application Submitted Successfully. Your Reference Number is: ' . $appno);
							redirect(site_url() . 'applicant/dashboard');
						} else {
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
							redirect(site_url() . 'applicant/dashboard');
						}
					} else {

						$applicat = $this->common_model->getApplicationStepOne($userId);

						$flag = false;
						//print_r($applicaitonsResubmitStatus);die;				
						if (!empty($applicaitonsResubmitStatus)) {
							for ($i = 0; $i <= 4; $i++) {


								if ($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 5) {
									$flag = true;
									break;
								}
							}
						}
						// echo $flag;die;
						//echo $applicat[0]['status']; echo $flag;die;
						if ($applicat[0]['status'] == "Pending" || $flag == true) {
							//echo "hello1";die;

							$submitApp = array(
								'status' => 9,
								'main_status' => 'Submit'
							);
							//$this->common_model->updateApplicationMapStatus($appno,$submitApp);
							$this->common_model->updateApplicantResubmitStatus($appno, $submitApp);
						} else {
							//echo "hello2";die;
							//echo "----------------";die;
							$submitApp = array(
								'uid' => $userId,
								'application_no' => $appno,
								'mission_status_date' => '',
								'mission_doc' => '',
								'iccr_status_date' => '',
								'iccr_doc' => '',
								'status' => 1,
								'status_update_date' => time(),
								'mission_status' => -1,
								'iccr_status' => -1,
								'region_one_status' => -1,
								'region_two_status' => -1,
								'region_three_status' => -1,
								'region_four_status' => -1,
								'region_five_status' => -1,
								'universities_status' => -1,
								'created' => time()
							);


							$id = $this->common_model->insertApplicationMapStatus($submitApp);

							$unArray = array(
								$applicat[0]['universty_choice'], $applicat[0]['universty_choice_two'], $applicat[0]['universty_choice_three'], $applicat[0]['universty_choice_fourth'], $applicat[0]['universty_choice_fifth']
							);

							foreach ($unArray as $mainArray) {
								$UniversityMappingdata = array(
									'status' => 2,
									'master_id' => $id,
									'regional_university' => $mainArray,
									'application_id' => $appno,
									'created' => time()
								);

								$this->common_model->insertUniversityMapStatus($UniversityMappingdata);
								$sts = $this->common_model->updateApplicationStatus($appno, $userId);
							}
						}


						$getMissionData = $this->common_model->getMissionData($appno, $userId);
						//echo "<pre>";print_r($getMissionData);die;



						//$missionEmail = $getMissionData[0]['mission_email'];

						$messages = '';
						$body = '';
						$messages .= '<strong>Hi ' . $usename . ',</strong><br><br>';
						$messages .= 'Your have successfully submitted your application. Your Reference Number is: ' . $appno;
						//$body = "Your application for scholarship could not be processed for the following reasons.<br/><br/>";
						$body .= $messages;
						//$body .= "<br/><br/>You are being given opportunity to resubmit your applicatin with the mission documents before ".$this->config->item('Mission_Applicant_Pending_Date');					
						$mailsend = $this->sendMail($body, $emailId, "Indian Council for Cultural Relations.", "mail_not_process");
						if ($sts) {
							if ($mailsend) {
								$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Your Application Submitted Successfully. Your Reference Number is: ' . $appno);
								redirect(site_url() . 'applicant/dashboard');
							}
						} else {
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
							redirect(site_url() . 'applicant/dashboard');
						}
					}
				}
			}

		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		if (isset($data['applicaitonStepOne'][0]['application_no'])) {
			$data['applicaitonsResubmitStatus'] = $this->common_model->getCommonApplicationStatus($data['applicaitonStepOne'][0]['application_no'], '', '');
		} else {
			$data['applicaitonsResubmitStatus'] = array();
		}
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		if (isset($data['applicaitonStepOne'][0]['application_no'])) {
			$data['academicDeatils'] = $this->common_model->getAcademicDetailsofApplicant($data['applicaitonStepOne'][0]['application_no']);
		} else {
			$data['academicDeatils']  = array();
		}
		$data['username'] = $user_data['email'];
		$this->load->view('site/header');
		$this->load->view('site/dashboard', $data);
		$this->load->view('site/footer'); 
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url() . 'applicant/dashboard');
		}
	}


	public function applicant_personal_infoayush()
	{
		try {
			//echo "----------";die;
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			//echo "<pre>";print_r($user_data);die;
			$data['registerData'] = $this->common_model->getUserData($userId);
			$imgArray = $this->common_model->getUserImage($userId);
			if (count($imgArray) > 0) {
				$data['userImage'] = $imgArray[0]['name'];
			} else {
				$data['userImage'] = '';
			}
			$applicationData = $this->common_model->getApplicationStepOne($userId);
			//echo "<pre>";print_r($applicationData);die;
			$data['applicaitonStepOne'] = $applicationData;
			$data['missions'] = $this->common_model->getAllMissions();
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['missions'] = $this->common_model->getAllMissions();
				$data['get_application_number'] = $this->random_num(15);
			}

			if (count($applicationData) > 0 && $applicationData[0]['status'] == "Draft") {
				$data['applicaitonStepOne'] = $applicationData;
				$data['univercities'] = $this->common_model->getUnivercities();
				$this->load->view('site/header');
				if ($userId == 205691 || $userId == 203797 || $userId == 203799) {

					$this->load->view('site/applicant_personal_infoayush', $data);
				} else {
					$this->load->view('site/applicant_personal_info', $data);
				}
				$this->load->view('site/footer');
			} elseif (count($applicationData) > 0 && $applicationData[0]['status'] == "Submit") {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You have already applied!');
				redirect(site_url() . 'applicant/dashboard');
			} else {
				$data['applicaitonStepOne'] = $applicationData;
				$data['univercities'] = $this->common_model->getUnivercities();
				$this->load->view('site/header');
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];


				if ($userId == 203795 || $userId == 203797 || $userId == 203799) {
					$this->load->view('site/applicant_personal_infoayush', $data);
				} else {
					$this->load->view('site/applicant_personal_info', $data);
				}

				//$this->load->view('site/applicant_personal_info',$data);
				$this->load->view('site/footer');
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect(site_url() . 'applicant/dashboard');
		}
	}
	//Load applicant_personal_info
	public function applicant_personal_info()
	{
		try {

			$user_data = $this->session->userdata('user_data');
			//print_r($user_data);die;
			$userId = $user_data['userid'];
			$data['registerData'] = $this->common_model->getUserData($userId);
			$imgArray = $this->common_model->getUserImage($userId);

			if (count($imgArray) > 0) {
				$data['userImage'] = $imgArray[0]['name'];
			} else {
				$data['userImage'] = '';
			}

			$data['dir'] = $user_data['dir'];

			$applicationData = $this->common_model->getApplicationStepOne($userId);
			$data['applicaitonStepOne'] = $applicationData;
			$data['missions'] = $this->common_model->getAllMissions();
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['missions'] = $this->common_model->getAllMissions();
				$data['get_application_number'] = $this->random_num(15);
			}

			if (count($applicationData) > 0) {
				$data['applicaitonStepOne'] = $applicationData;
				$data['univercities'] = $this->common_model->getUnivercities();
				$this->load->view('site/header', array('include' => true));
				$student_type = $user_data['student_type'];
				$student_course_type = $user_data['apply_course_type'];

				if ($student_type == 1 && $student_course_type == 10) {
					$data = $this->load->view('site/applicant_personal_infoayush', $data, TRUE);
				} elseif ($student_type == 1 && $student_course_type == 11) {
					$data = $this->load->view('site/applicant_personal_infoself', $data, TRUE);
				} else {
					$data = $this->load->view('site/applicant_personal_info', $data, TRUE);
				}
				echo $data;
			} /*elseif ($applicationData > 0 && $applicationData[0]['status'] == "Submit") {
				$this->load->view('site/header', array('include' => true));
				$data = $this->load->view('site/applicant_personal_info_prev', $data, TRUE);
				echo $data;
				//$this->session->set_flashdata('message_type', 'error');
				//$this->session->set_flashdata('error', 'You have already applied!');
				//redirect(site_url().'applicant/dashboard');	
			}*/ else {
				$data['applicaitonStepOne'] = $applicationData;
				$data['univercities'] = $this->common_model->getUnivercities();
				$this->load->view('site/header', array('include' => true));
				//$data = $this->load->view('site/applicant_personal_info',$data,TRUE);
				$student_type = $user_data['student_type'];
				$student_course_type = $user_data['apply_course_type'];
				if ($student_type == 1 && $student_course_type == 10) {

					$data = $this->load->view('site/applicant_personal_infoayush', $data, TRUE);
				} elseif ($student_type == 1 && $student_course_type == 11) {

					$data = $this->load->view('site/applicant_personal_infoself', $data, TRUE);
				} else {
					$data = $this->load->view('site/applicant_personal_info', $data, TRUE);
				}
				echo $data;
				//$this->load->view('site/footer');
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect(site_url() . 'applicant/dashboard');
		}
	}
	public function applicant_personal_infomenu()
	{
		try {
			
			//$id = $_POST[''];
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$data['registerData'] = $this->common_model->getUserData($userId);
			$imgArray = $this->common_model->getUserImage($userId);

			if (count($imgArray) > 0) {
				$data['userImage'] = $imgArray[0]['name'];
			} else {
				$data['userImage'] = '';
			}
			$applicationData = $this->common_model->getApplicationStepOne($userId);
			//$applicationPassportData = $this->common_model->getApplicationPassportStepOne($userId);
			$data['applicaitonStepOne'] = $applicationData;
			$data['missions'] = $this->common_model->getAllMissions();
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['missions'] = $this->common_model->getAllMissions();
				$data['get_application_number'] = $this->random_num(15);
			}

			if (count($applicationData) > 0 && $applicationData[0]['status'] == "Draft") {
				$data['applicaitonStepOne'] = $applicationData;
				//$data['applicaitonPassportStepOne'] = $applicationPassportData;
				$data['univercities'] = $this->common_model->getUnivercities();
				$this->load->view('site/header');
				$this->load->view('site/applicant_personal_info', $data);
				$this->load->view('site/footer');
			} elseif (count($applicationData) > 0 && $applicationData[0]['status'] == "Submit") {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You have already applied!');
				redirect(site_url() . 'applicant/dashboard');
			} else {
				$data['applicaitonStepOne'] = $applicationData;
				$data['univercities'] = $this->common_model->getUnivercities();
				//$this->load->view('site/header');
				$data = $this->load->view('site/applicant_personal_info', $data, TRUE);
				echo $data;
				//$this->load->view('site/footer');
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect(site_url() . 'applicant/dashboard');
		}
	}
	public function applicant_personal_info_prev()
	{
		try {
			//echo "-----------------------------";die;
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$data['registerData'] = $this->common_model->getUserData($userId);
			$imgArray = $this->common_model->getUserImage($userId);

			if (count($imgArray) > 0) {
				$data['userImage'] = $imgArray[0]['name'];
			} else {
				$data['userImage'] = '';
			}
			$applicationData = $this->common_model->getApplicationStepOne($userId);
			//$applicationPassportData = $this->common_model->getApplicationPassportStepOne($userId);
			$data['applicaitonStepOne'] = $applicationData;
			$data['missions'] = $this->common_model->getAllMissions();
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['missions'] = $this->common_model->getAllMissions();
				$data['get_application_number'] = $this->random_num(15);
			}

			if (count($applicationData) > 0 && $applicationData[0]['status'] == "Draft") {
				$data['applicaitonStepOne'] = $applicationData;
				//$data['applicaitonPassportStepOne'] = $applicationPassportData;
				$data['univercities'] = $this->common_model->getUnivercities();
				$this->load->view('site/header');
				$this->load->view('site/applicant_personal_info_prev', $data, TRUE);
				$this->load->view('site/footer');
			} elseif (count($applicationData) > 0 && $applicationData[0]['status'] == "Submit") {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You have already applied!');
				redirect(site_url() . 'applicant/dashboard');
			} else {
				$data['applicaitonStepOne'] = $applicationData;
				$data['univercities'] = $this->common_model->getUnivercities();
				//$this->load->view('site/header');
				$this->load->view('site/applicant_personal_info_prev', true);
				//$this->load->view('site/footer');
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect(site_url() . 'applicant/dashboard');
		}
	}
	public function applicant_education_info()
	{
		//echo "<pre>";
		//print_r($_POST);die;
		$actual_link =  $_SERVER['HTTP_REFERER'];
		try {
			$year = date('Y');
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";
			//print_r($user_data);die;
			$userId = $user_data['userid'];
			$appno = '';
			if (isset($_POST['application_no'])) {
				$appno = $_POST['application_no'];
			}
			if (!empty($_POST)) {

				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				//var_dump($userInfo);die;
				unset($clean['step-one-application']);
				if ($this->common_model->applicationExists($userId)) {
					//echo "sadasdsad";die;
					$choice_one = $clean['universty_choice'];
					$choice_two = $clean['universty_choice_two'];
					$choice_three = $clean['universty_choice_three'];
					$choice_fourth = $clean['universty_choice_fourth'];
					$choice_fifth = $clean['universty_choice_fifth'];
					$stateId = 0;
					$stateIdOne = 0;
					$stateIdtwo = 0;
					$stateIdthree = 0;
					$stateIdfour = 0;
					if ($choice_one > 0) {
						$stateId = $this->common_model->getUniversityStateById($choice_one);
						$clean['university_choice_one_state'] = $stateId[0]['state'];
					}
					if ($choice_two > 0) {
						$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
						$clean['university_choice_two_state'] = $stateIdOne[0]['state'];
					}
					if ($choice_three > 0) {
						$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);
						$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
					}
					if ($choice_fourth > 0) {
						$stateIdthree = $this->common_model->getUniversityStateById($choice_fourth);
						$clean['university_choice_fourth_state'] = $stateIdthree[0]['state'];
					}
					if ($choice_fifth > 0) {
						$stateIdfour = $this->common_model->getUniversityStateById($choice_fifth);
						$clean['university_choice_fifth_state'] = $stateIdfour[0]['state'];
					}
					$this->common_model->updateApplicationStepOne($clean, $userId);
				} else {
					$checkyear = $this->user_model->checkYear($clean['passport_no'], $year);
					//echo "<pre>";
					//var_dump($checkyear);die;
					$userInfo = $this->user_model->checkPassportYear($clean['passport_no'], $year);
					//var_dump($userInfo);die;
					$clean['status'] = 'Draft';
					$choice_one = $clean['universty_choice'];
					$choice_two = $clean['universty_choice_two'];
					$choice_three = $clean['universty_choice_three'];
					$choice_fourth = $clean['universty_choice_fourth'];
					$choice_fifth = $clean['universty_choice_fifth'];
					$stateId = 0;
					$stateIdOne = 0;
					$stateIdtwo = 0;
					$stateIdthree = 0;
					$stateIdfour = 0;
					//var_dump($userInfo);die;
					if ($userInfo) {
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Application already exists this passport number');
						redirect($actual_link);
						return false;
					}
					if ($choice_one > 0) {
						$stateId = $this->common_model->getUniversityStateById($choice_one);
						$clean['university_choice_one_state'] = $stateId[0]['state'];
					}
					if ($choice_two > 0) {
						$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
						$clean['university_choice_two_state'] = $stateIdOne[0]['state'];
					}
					if ($choice_three > 0) {
						$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);
						$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
					}
					if ($choice_fourth > 0) {
						$stateIdthree = $this->common_model->getUniversityStateById($choice_fourth);
						$clean['university_choice_fourth_state'] = $stateIdthree[0]['state'];
					}
					if ($choice_fifth > 0) {
						$stateIdfour = $this->common_model->getUniversityStateById($choice_fifth);
						$clean['university_choice_fifth_state'] = $stateIdfour[0]['state'];
					}
					$clean['uid'] = $userId;
					$clean['application_no'] = $appno;
					$id = $this->common_model->insertApplicationStepOne($clean);
				}
			}
			$applicationData = $this->common_model->getApplicationStepOne($userId);
			$data['apply_course_type'] = $user_data['apply_course_type'];
            $data['applicaitonStepOne'] = $applicationData;
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
			//$this->load->view('site/header');
			$this->load->view('site/header', array('include' => true));
			$data = $this->load->view('site/applicant_educaion_info', $data, TRUE);
			echo $data;
			//$this->load->view('site/footer');	
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect($actual_link);
		}
	}

	public function applicant_education_info_save()
	{

		try {
			$year = date('Y');
			$user_data = $this->session->userdata('user_data');
			$user_country = $user_data['user_country'];
			$userId = $user_data['userid'];
			$appno = $_POST['application_no'];
			
			$nomenclature = $this->input->post('nomenclature');
			$university   = $this->input->post('universty_choice');
			
			
			if (!empty($nomenclature) && !empty($university)) {
                 $i=1;
				foreach ($nomenclature as $key => $value) {
						
					if (!empty($value) && !empty($university[$key])) {
							if($i=='1'){$nomenclature1= $value ; $university1=$university[$key];}
							if($i=='2'){$nomenclature2= $value ; $university2=$university[$key];}
							if($i=='3'){$nomenclature3= $value ; $university3=$university[$key];}
							if($i=='4'){$nomenclature4= $value ; $university4=$university[$key];}
							if($i=='5'){$nomenclature5= $value ; $university5=$university[$key];}
					}

					
						$i++;			
						
					}
				}

//print_r($_POST);die; 
			
			//if (isset($_POST['application_no'])) {
				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
               $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				unset($clean['step-one-application']);
				if ($this->common_model->applicationExists($userId)) {

					$choice_one = $university1;

					$choice_two = $university2;

					$choice_three = $university3;

					$choice_fourth = $university4;

					$choice_fifth = $university5;

					$stateId = 0;
					$stateIdOne = 0;
					$stateIdtwo = 0;
					$stateIdthree = 0;
					$stateIdfour = 0;

					if ($choice_one > 0) {
						$stateId = $this->common_model->getUniversityStateById($choice_one);

						$clean['university_choice_one_state'] = $stateId[0]['state'];
					}
					if ($choice_two > 0) {
						$stateIdOne = $this->common_model->getUniversityStateById($choice_two);

						$clean['university_choice_two_state'] = $stateIdOne[0]['state'];
					}
					if ($choice_three > 0) {
						$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);

						$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
					}
					if ($choice_fourth > 0) {
						$stateIdthree = $this->common_model->getUniversityStateById($choice_fourth);
						$clean['university_choice_fourth_state'] = $stateIdthree[0]['state'];
					}
					if ($choice_fifth > 0) {
						$stateIdfour = $this->common_model->getUniversityStateById($choice_fifth);
						$clean['university_choice_fifth_state'] = $stateIdfour[0]['state'];
					}
					$clean['nomenclature'] = $nomenclature1;
					$clean['nomenclature_two'] = $nomenclature2;
					$clean['nomenclature_three'] = $nomenclature3;
					$clean['nomenclature_fourth'] = $nomenclature4;
					$clean['nomenclature_fifth'] = $nomenclature5;
					$clean['universty_choice'] = $university1;
					$clean['universty_choice_two'] = $university2;
					$clean['universty_choice_three'] = $university3;
					$clean['universty_choice_fourth'] = $university4;
					$clean['universty_choice_fifth'] = $university5;
					$passport_file_path = $this->input->post('old_passport_file')??'';
					//print_r($clean);die;
					
					$st = $this->common_model->updateApplicationStepOne($clean, $userId);
					
				//var_dump($st);die;
					//print_r('A1');
					if ($st) {
						echo json_encode(array('status' => TRUE, "message" => "Success"));
						
						$passportFile = '';

						$passport_file_path = $this->input->post('old_passport_file')??'';

						if (isset($_FILES['passport_file']) && !empty($_FILES['passport_file']['name'])) {
							//print_r('A2');
							$uploadPath = FCPATH . 'assets/img/register/';
							if (!is_dir($uploadPath)) {
								mkdir($uploadPath, 0777, true);
							}
							$config['upload_path']   = $uploadPath;
							$config['allowed_types'] = 'jpg|jpeg|png';
							$config['max_size']      = 2048; // 2 MB
							$config['encrypt_name']  = true;


							$this->load->library('upload');
							$this->upload->initialize($config);
							
							
							if (!$this->upload->do_upload('passport_file')) {
							$this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
							redirect($_SERVER['HTTP_REFERER']);
							return;
						} else {
							$uploadData = $this->upload->data();
							$passport_file_path = 'assets/img/register/' . $uploadData['file_name'];

							$old_passport_file = $this->input->post('old_passport_file')??'';
							if (!empty($old_passport_file) && file_exists(FCPATH . $old_passport_file)) {
								@unlink(FCPATH . $old_passport_file);
							}
						}
					}	


								$data1['passport_file'] = $passport_file_path;
							}
						
						

						$data1['userid'] = $userId;

						$this->user_model->updateUserPassport($data1);
	
						
					/*} else {
						echo json_encode(array('status' => FALSE, "message" => "Error1"));
						//$this->load->view('site/footer');	
					}*/
				} else {
					$checkyear = $this->user_model->checkYear($clean['passport_no'], $year);

					$uniqueId = $clean['unique_id'];
					if ($user_country == 75 || $user_country == 10) {
						$userInfo = $this->user_model->checkUniqueIdYear($uniqueId, $year);
					} else {
						$userInfo = $this->user_model->checkPassportYear($clean['passport_no'], $year);
					}

					//var_dump($userInfo);die;
					$clean['status'] = 'Draft';
					$choice_one = $university1;

					$choice_two = $university2;

					$choice_three = $university3;

					$choice_fourth = $university4;

					$choice_fifth = $university5;
					$stateId = 0;
					$stateIdOne = 0;
					$stateIdtwo = 0;
					$stateIdthree = 0;
					$stateIdfour = 0;
					//var_dump($userInfo);die;
					/* if($userInfo){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Application already exists this passport number');
							redirect($actual_link);
							return false;
			            } */
					/*if ($userInfo) {
						echo json_encode(array('status' => FALSE, "message" => "Application already exists this passport/Unique number"));
						return false;
					}*/

					if ($choice_one > 0) {
						$stateId = $this->common_model->getUniversityStateById($choice_one);
						$clean['university_choice_one_state'] = $stateId[0]['state'];
					}
					if ($choice_two > 0) {
						$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
						$clean['university_choice_two_state'] = $stateIdOne[0]['state'];
					}
					if ($choice_three > 0) {
						$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);
						$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
					}
					if ($choice_fourth > 0) {
						$stateIdthree = $this->common_model->getUniversityStateById($choice_fourth);
						$clean['university_choice_fourth_state'] = $stateIdthree[0]['state'];
					}
					if ($choice_fifth > 0) {
						$stateIdfour = $this->common_model->getUniversityStateById($choice_fifth);
						$clean['university_choice_fifth_state'] = $stateIdfour[0]['state'];
					}
					$clean['uid'] = $userId;
					$clean['application_no'] = $appno;
						$clean['nomenclature'] = $nomenclature1;
						$clean['nomenclature_two'] = $nomenclature2;
						$clean['nomenclature_three'] = $nomenclature3;
						$clean['nomenclature_fourth'] = $nomenclature4;
						$clean['nomenclature_fifth'] = $nomenclature5;
						$clean['universty_choice'] = $university1;
						$clean['universty_choice_two'] = $university2;
						$clean['universty_choice_three'] = $university3;
						$clean['universty_choice_fourth'] = $university4;
						$clean['universty_choice_fifth'] = $university5;
					$id = $this->common_model->insertApplicationStepOne($clean);
					if ($id) {
						echo json_encode(array('status' => TRUE, "message" => "Success"));
					} else {
						echo json_encode(array('status' => FALSE, "message" => "Error2"));
						//$this->load->view('site/footer');	
					}
				}
			
			$applicationData = $this->common_model->getApplicationStepOne($userId);
			$data['applicaitonStepOne'] = $applicationData;
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
			//$this->load->view('site/header');
			//$this->load->view('site/header', array('include'=>true));
			//$data = $this->load->view('site/applicant_educaion_info',$data,TRUE);
			//echo $data;
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error" . $e));
		}
		
		}
	public function applicant_other_info_save()
		{
			//echo "<pre>";print_r($_POST);die;
			$actual_link =  $_SERVER['HTTP_REFERER'];
			try
			{
				$user_data = $this->session->userdata('user_data');
				$userId = $user_data['userid'];	
				$data['registerData'] = $this->common_model->getUserData($userId);
				$appno = '';
				if(isset($_POST['appno']))
				{
					$appno = $_POST['appno'];
				}	
				if(!empty($_POST))
				{
					//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE)); 
				   $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
			 
			 
			  
					if($this->common_model->educationExists($userId))
					{    			
						$result = $this->common_model->updateEducation($clean,$userId);	
					
						if($result)
						{
						echo json_encode(array('status'=>TRUE,"message"=>"Success"));
						}
						else
						{
						echo json_encode(array('status'=>FALSE,"message"=>"Error"));	
						//$this->load->view('site/footer');	
						}
					}
					else
					{
						$clean['uid'] = $userId;
						$clean['application_no'] = $appno;

						$id = $this->common_model->insertEducation($clean);	
						if($id)
						{
						echo json_encode(array('status'=>TRUE,"message"=>"Success"));
						}
						else
						{
						echo json_encode(array('status'=>FALSE,"message"=>"Error"));	
						//$this->load->view('site/footer');	
					}
				}
			}
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error"));
		}
	}
	public function applicant_other_info()
	{
		
		$actual_link =  $_SERVER['HTTP_REFERER'];
		try {
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$data['registerData'] = $this->common_model->getUserData($userId);
			$appno = '';
			if (isset($_POST['appno'])) {
				$appno = $_POST['appno'];
			}
			if (!empty($_POST)) {
				
				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
				 $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				if ($this->common_model->educationExists($userId)) {
					$this->common_model->updateEducation($clean, $userId);
				} else {
					$clean['uid'] = $userId;
					$clean['application_no'] = $appno;
					$id = $this->common_model->insertEducation($clean);
				}
			}
			
			$applicationData = $this->common_model->getApplicationStepOne($userId);
			$data['applicaitonStepOne'] = $applicationData;
			//echo "<pre>";print_r($data['applicaitonStepOne']);die;
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
			//$this->load->view('site/header');
			$this->load->view('site/header', array('include' => true));
			$data = $this->load->view('site/applicant_other_info', $data, TRUE);
			echo $data;
			//$this->load->view('site/footer');	
		} catch (Exception $e) {
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

		//$actual_link =  $_SERVER['HTTP_REFERER'];
		//echo "<pre>";
		//print_r($actual_link);die;
		if (isset($_SERVER['HTTP_REFERER'])) {
			$actual_link =  $_SERVER['HTTP_REFERER'];
		} else {
			$actual_link =  '';
		}
		try {
			$user_data = $this->session->userdata('user_data');
			$imgname = "";
			$userId = $user_data['userid'];
			$appno = '';
			if (isset($_POST['appno'])) {
				$appno = $_POST['appno'];
			}
			if (!empty($_POST)) {
				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
             $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				$clean['created'] = time();

				if ($this->common_model->otherDetailExists($userId)) {
					$this->common_model->updateOtherDetails($clean, $userId);
				} else {
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
			$data['applicaitonsResubmitStatus'] = $this->common_model->getCommonApplicationStatus($data['applicaitonStepOne'][0]['application_no'], '', '');
			//,$universityId,$flag
			//$this->load->view('site/header');
			$this->load->view('site/header', array('include' => true));
			$data = $this->load->view('site/applicant_documents', $data, TRUE);
			echo $data;
			//$this->load->view('site/footer');	
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect($actual_link);
		}
	}
	public function applicant_document_info_save()
	{
		//echo "<pre>";print_r($_POST);die;
		$actual_link =  $_SERVER['HTTP_REFERER'];
		//echo "<pre>";
		//print_r($actual_link);die;
		try {
			$user_data = $this->session->userdata('user_data');
			$imgname = "";
			$userId = $user_data['userid'];
			$appno = '';
			if (isset($_POST['application_no'])) {
				$appno = $_POST['application_no'];
			}
			if (!empty($_POST)) {
				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				$clean['created'] = time();
				//echo '<pre>'; print_r($userId); die;
				if ($this->common_model->otherDetailExists($userId)) {
					//echo '<pre>'; print_r($clean); die;
					$results = $this->common_model->updateOtherDetails($clean, $userId);
					// print_r($results); die;
					if ($results) {
						echo json_encode(array('status' => TRUE, "message" => "Success"));
					} else {
						// print_r('hello');die;
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Application already Exist!');
						//redirect($actual_link);
						echo json_encode(array('status'=>FALSE, "message"=>"Error1" ));	
						//$this->load->view('site/footer');	
					}
				} else {
					$clean['uid'] = $userId;
					$clean['application_no'] = $appno;
					$ids  = $this->common_model->insertOtherDetails($clean);
					if ($ids) {
						echo json_encode(array('status' => TRUE, "message" => "Success"));
					} else {
						echo json_encode(array('status' => FALSE, "message" => "Error2"));
						//$this->load->view('site/footer');	
					}
				}
			}

			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
			//echo "<pre>";
			//print_r($data['applicaitonStepOne']);die;
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		} catch (Exception $e) {
			//print_r($e);die;
			echo json_encode(array('status' => FALSE, "message" => "Error3"));
		}
	}


	public function uploadSignature()
	{
		try {
			$imgname = "";
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (signature.jpg..etc.) not in other language like:-> غفران_الحلبي_كشف.jpg."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
				return;
			}
			if ($sizekbb > 200000) {
				$this->session->set_flashdata('error', 'File size is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size should be less than equal to 200 KB!'));
				return;
			}
			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_profile_signature_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/profile_signature/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'signature_doc' => $imgname,
						'created' => time()
					);
					if ($this->common_model->otherDetailExists($userId)) {
						$sts = $this->common_model->updateOtherDetails($data, $userId);
					} else {
						$data['uid'] = $userId;
						$data['application_no'] = $applicatinNo[0]['application_no'];
						$sts = $this->common_model->insertOtherDetails($data);
					}
					if ($sts) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadTranslation()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (translation.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG files are allowed."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
				return;
			}
			if ($sizekbb > 4000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must less than equal to 5MB!'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}



			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Translation_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/translation/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;


				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['tl']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadTranslationSfs()
	{
		try {
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

			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG files are allowed."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
				return;
			}
			if ($sizekbb > 4000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must less than equal to 5MB!'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}



			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Translation_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/SFS_translation/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;


				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['tl']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertSfsDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadLicence()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (licience.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must less than equal to 1MB!'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}



			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_International_licence_' . $name;
				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/licence/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['dl']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadMphil()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (mphil.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must less than equal to 1MB'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}



			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Mphil_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Mphil/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['mhil']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadPassport()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (passport.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 1MB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}


			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Passport_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Passport/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['passport']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadPassportSfs()
	{
		try {
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

			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 1MB.'));
				return;
			}

			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}


			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Passport_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/SFS_Passport/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['passport']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertSfsDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadSchoolLeavingSfs()
	{
		try {
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

			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
				echo json_encode(array('status' => FALSE, "message" => "File size must less than equal to 1MB"));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_school_Leaving_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/SFS_school_Leaving/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['school_leaving']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertSfsDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadSchoolLeaving()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (school.pdf..etc.) not in other language like:-> غفران_الحلبي_كف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
				echo json_encode(array('status' => FALSE, "message" => "File size must less than equal to 1MB"));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_school_Leaving_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/school_Leaving/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['school_leaving']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadSchoolLeavingx()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (school.pdf..etc.) not in other language like:-> غفران_احلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
				echo json_encode(array('status' => FALSE, "message" => "File size must less than equal to 1MB"));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_school_Leaving_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/school_Leaving/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['school_leaving_x']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);

					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadUnderGraduateSfs()
	{
		try {
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
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 1MB!'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Under_Graduate_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/SFS_Under_Graduate/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['ug']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertSfsDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadUnderGraduate()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (ug.pdf..etc.) not in other language like:-> فران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
					echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed!'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 1MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 1MB!'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Under_Graduate_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Under_Graduate/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['ug']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadPostGraduate()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (pg.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File content is not Valid!'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Post_Graduate_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Post_Graduate/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['pg']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}


	public function uploadPhd()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (phd.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 4000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 5MB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_PHD_' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/PHD/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['phd']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadPhdSfs()
	{
		try {
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

			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 4000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 5MB.'));
				return;
			}

			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_PHD_' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/SFS_PHD/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['phd']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertSfsDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadPanCard()
	{
		try {
			$files = $_FILES['file'];
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$applicatinNo =  $this->common_model->getApplicationNoByUserId($userId);
			$types = $this->config->item('doc_types');
			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Pand_Card_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Pand_Card/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['pan']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadIdProof()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (id.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 5MB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_ID_Proof_' . $name;
				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/ID_Proof/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['id']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadIdProofSfs()
	{
		try {
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

			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 5MB.'));
				return;
			}

			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_ID_Proof_' . $name;
				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/SFS_ID_Proof/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['id']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertSfsDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}


	public function uploadAddressProof()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (address.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File content is not Valid!'));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must less than equal to 5MB!'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Address_Proof_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Address_Proof/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['indian_address']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadPhysicalFitness()
	{
		try {

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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (fitness.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, "message" => "File Size Should be less than 5MB."));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Physical_Fitness_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Physical_Fitness/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['physical']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadPhysicalFitnessSfs()
	{
		try {

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
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
				return;
			}
			if ($sizekbb > 2097152) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, "message" => "File Size Should be less than 5MB."));
				return;
			}

			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Physical_Fitness_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/SFS_Physical_Fitness/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['physical']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertSfsDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadPassportPic()
{
    if (!empty($_FILES['file']['name'])) {

        $config['upload_path']   = './uploads/passport/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = true;

        if (!is_dir('./uploads/passport/')) {
            mkdir('./uploads/passport/', 0777, true);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            echo json_encode([
                'status'  => 'error',
                'message' => strip_tags($this->upload->display_errors())
            ]);
            exit;
        } else {
            $uploadData = $this->upload->data();
            $filePath   = 'uploads/passport/' . $uploadData['file_name'];

            // Example: save in database
            // Adjust according to your table structure
            $user_data = $this->session->userdata('user_data');
            $user_id   = !empty($user_data['id']) ? $user_data['id'] : 0;

            if ($user_id > 0) {
                $this->db->where('id', $user_id);
                $this->db->update('icce_users', [
                    'passport_file' => $filePath
                ]);
            }

            echo json_encode([
                'status'   => 'success',
                'message'  => 'Passport uploaded successfully.',
                'file_path'=> $filePath,
                'file_url' => base_url($filePath)
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'No file selected.'
        ]);
        exit;
    }
}

	public function uploadProfilePic()
	{
		try {
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

			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (profile image.jpg..etc.) not in other language like:-> غفران_الحلبي_كشف.png."));
				return;
			}
			$pdf = substr($contents, 0, 4);
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, "message" => "File content is not Valid"));
				return;
			}
			if ($sizekbb > 200000) {
				$this->session->set_flashdata('error', 'File size is not Valid!');
				echo json_encode(array('status' => FALSE, "message" => "File size is not Valid"));
				return;
			}
			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG files are allowed"));
				return;
			}
			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_' . $name;
				
				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/profile_pics/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					if ($this->common_model->imageExists($userId)) {
						if ($this->common_model->uploadProfilePic($imgname, $userId)) {
							echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
						}
					} else {
						if ($this->common_model->insertUserImage($imgname, $userId)) {
							echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
						}
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading Profile Pic!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading Profile Pic!. Try Again Later."));
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
		$data['captcha'] = $this->createCaptcha(array(
			'min_length' => 5,
			'max_length' => 5,
			'backgrounds' => array(FCPATH . 'assets/site/main/images/captcha_bg/white-carbon.png'),
			'fonts' => array(FCPATH . 'assets/site/main/fonts/captcha_fonts/times_new_yorker.ttf'),
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
		$this->load->view('site/header');
		$this->load->view('site/register', $data);
		$this->load->view('site/footer');
	}

	public function statusdemo()
	{
		try {
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$data['applicaitonsStatus'] = $this->common_model->getApplicationStatus($userId);
			$this->load->view('site/header');
			$this->load->view('site/status', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
		}
	}



	public function dashboard()
	{
		try {
			 
			$user_data = $this->session->userdata('user_data');
			
			$userId = $user_data['userid'];
			
			$userType = $user_data['user_type'];
			
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
			
			if (isset($data['applicaitonStepOne'][0]['application_no'])) {
				
				$data['applicaitonsResubmitStatus'] = $this->common_model->getCommonApplicationStatus($data['applicaitonStepOne'][0]['application_no'], '', '');
			} else {
				
				$data['applicaitonsResubmitStatus'] = array();
				
			}
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
			if (isset($data['applicaitonStepOne'][0]['application_no'])) {
				$data['academicDeatils'] = $this->common_model->getAcademicDetailsofApplicant($data['applicaitonStepOne'][0]['application_no']);
			} else {
				$data['academicDeatils']  = array();
			}
			$data['username'] = $user_data['email'];
			$this->load->view('site/header');
			$this->load->view('site/dashboard', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
		}
	}
	public function complete()
	{
		try {
			$token      = base64_decode($this->uri->segment(4));
			$cleanToken = $this->security->xss_clean($token);
			$user_info  = $this->user_model->isTokenValid($cleanToken);
			if (!is_object($user_info)) {
				echo '<script>window.location.href="' . site_url() . 'home?text=Token is invalid or expired!.&type=Error Message&at=danger&redirect=' . site_url() . 'home";</script>';
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
				
				
				//$post                  = $this->input->post(NULL, TRUE);
				//$cleanPost             = $this->security->xss_clean($post);
				$post                  = $this->input->post(NULL, TRUE);
				$cleanPosts             = $this->security->xss_clean($post);
				$cleanPost =  $this->strip_quotes($cleanPosts);
				$hashed                = md5($cleanPost['password']);
				$cleanPost['password'] = $hashed;
				$cleanPost['user_id'] =  $user_info->id;
				unset($cleanPost['passconf']);
				$userInfo = $this->user_model->updateUserInfo($cleanPost);
				if (is_object($userInfo) && property_exists($userInfo, "username")) {
					unset($userInfo->password);
					$datas = array(
						'userid' => $userInfo->id,
						'fname' => $userInfo->username,
						'email' => $userInfo->email_id,
						'user_type' => $userInfo->user_type
					);
					$this->session->set_userdata('user_data', $datas);
					echo '<script>window.location.href="' . site_url() . 'home?text=Login Successfully!.&type=Thank You!&at=success&redirect=' . site_url() . 'home/dashboard/student";</script>';
				} else {
					if (!$userInfo) {

						echo '<script>window.location.href="' . site_url() . 'home?text=There was a problem updating your record!.&type=Error Message!&at=danger&redirect=' . site_url() . 'home";</script>';
					}
				}
			}
		} catch (Exception $e) {
			echo '<script>window.location.href="' . site_url() . 'home?text=Internal Server Error. Try After Some Time!&type=Error Message!&at=danger&redirect=' . site_url() . 'home";</script>';
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
		if (!function_exists('gd_info')) {
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
		if (is_array($config)) {
			foreach ($config as $key => $value) $captcha_config[$key] = $value;
		}

		// Restrict certain values
		if ($captcha_config['min_length'] < 1) $captcha_config['min_length'] = 1;
		if ($captcha_config['angle_min'] < 0) $captcha_config['angle_min'] = 0;
		if ($captcha_config['angle_max'] > 10) $captcha_config['angle_max'] = 10;
		if ($captcha_config['angle_max'] < $captcha_config['angle_min']) $captcha_config['angle_max'] = $captcha_config['angle_min'];
		if ($captcha_config['min_font_size'] < 10) $captcha_config['min_font_size'] = 10;
		if ($captcha_config['max_font_size'] < $captcha_config['min_font_size']) $captcha_config['max_font_size'] = $captcha_config['min_font_size'];

		// Generate CAPTCHA code if not set by user
		if (empty($captcha_config['code'])) {
			$captcha_config['code'] = '';
			$length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
			while (strlen($captcha_config['code']) < $length) {
				$captcha_config['code'] .= substr($captcha_config['characters'], mt_rand() % (strlen($captcha_config['characters'])), 1);
			}
		}
		$image_src = site_url() . 'home/getCaptcha?_CAPTCHA&amp;t=' . urlencode(microtime());

		$cnfg = array('config' => serialize($captcha_config));
		$this->session->set_userdata('captcha', $cnfg);
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

		if (!$captcha_config) exit();

		//$this->session->unset_userdata('captcha');	    

		// Pick random background, get info, and start captcha
		$background = $captcha_config['backgrounds'][mt_rand(0, count($captcha_config['backgrounds']) - 1)];
		list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);

		$captcha = imagecreatefrompng($background);

		$color = $this->hex2rgb($captcha_config['color']);
		$color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);

		// Determine text angle
		$angle = mt_rand($captcha_config['angle_min'], $captcha_config['angle_max']) * (mt_rand(0, 1) == 1 ? -1 : 1);

		// Select font randomly
		$font = $captcha_config['fonts'][mt_rand(0, count($captcha_config['fonts']) - 1)];

		// Verify font file exists
		if (!file_exists($font)) throw new Exception('Font file not found: ' . $font);

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
		if ($captcha_config['shadow']) {
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
	function hex2rgb($hex_str, $return_string = false, $separator = ',')
	{
		$hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
		$rgb_array = array();
		if (strlen($hex_str) == 6) {
			$color_val = hexdec($hex_str);
			$rgb_array['r'] = 0xFF & ($color_val >> 0x10);
			$rgb_array['g'] = 0xFF & ($color_val >> 0x8);
			$rgb_array['b'] = 0xFF & $color_val;
		} elseif (strlen($hex_str) == 3) {
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
		$response = array('status' => FALSE, 'data' => array(), 'csrfName' => '', 'csrfHash' => '');
		try {
			$id = $this->input->post('university');
			$id1 = $this->input->post('university1');
			$unvercitiesids = $this->common_model->getSelectedUnvercities($id, $id1);
			if (count($unvercitiesids) > 0) {
				$response['status'] = TRUE;
				foreach ($unvercitiesids as $row) {
					$response['data'][] = $row;
				}
			}
		} catch (Exception $e) {
			echo json_encode($response);
		}
		echo json_encode($response);
	}
	
	public function getNomenclatureByType()
	{
		// $response = array('status'=>FALSE,'data'=>array(),'csrfName'=>'','csrfHash'=>'','stateuniversities'=>array(),'centraluniversities'=>array(),'agriculturealuniversities' =>array(),'nit'=>array());	$courses = array();

		try {
			$user_data = $this->session->userdata('user_data');
			$apply_course_type = $user_data['apply_course_type'];


			$id = $this->input->post('programme');

			$ctype = $this->input->post('course_type');


			//echo $id;echo $ctype;die;


			if ($id == 3 || $id == 4 || $id == 5 || $id == 6 || $id == 7 || $id == 1 ) {
				
				if ($id == 3 || $id == 4) {
					$stateUniversities = $this->common_model->getStateUniversitiesWithMapping($id, $ctype);

					//echo "<pre>";
					//print_r($stateUniversities);
					if (count($stateUniversities) > 0) {
						$response['stateUniversities'] = $stateUniversities;
					}
					// $states = $this->common_model->getAllStates();
					
					// foreach ($states as $state) {
					// 	//$univesities = $this->common_model->getUniversitiesByTypeAndStateId($state['id'],2);
					// 	//echo '<pre>'; print_r($state);die;
					// 	if (array_key_exists($state['id'], $response['stateuniversities'])) {
					// 		$response['stateuniversities'][$state['name']] = array();
					// 	}
					// 	$response['stateuniversities'][$state['id']] = array('stateid');
					// }
					// echo '<pre>'; print_r($response);die;
				}
				if ($id == 5 || $id == 6 || $id == 7) {
				}
			}

			$courses = $this->common_model->getnomenclatureByType($ctype,$id);

			if (count($courses) > 0) {
				$response['status'] = TRUE;
				foreach ($courses as $row) {
					$response['data'][] = $row;
				}
			}
			$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash(); 
    
			/*$stateUniversities = $this->common_model->getStateUniversitiesWithMapping($id, $ctype);

			//echo "<pre>";
			//print_r($stateUniversities);
			if (count($stateUniversities) > 0) {
				$response['stateUniversities'] = $stateUniversities;
			}
			$centralUniversities = $this->common_model->getCentralUniversitiesWithMapping($id, $ctype);
			//echo "<pre>";print_r($centralUniversities);die; 
			if (count($centralUniversities) > 0) {
				$response['centraluniversities'] = $centralUniversities;
			}
			$agriCultureUniversities = $this->common_model->getagriCultureUniversitiesWithMapping($id, $ctype, $apply_course_type);
			//echo "<pre>";print_r($agriCultureUniversities);die;
			if (count($agriCultureUniversities) > 0) {
				$response['agriculturealuniversities'] = $agriCultureUniversities;
			} else {
				$response['centralUniversities'] = array();
			}*/
		} catch (Exception $e) {
			echo json_encode($response);
		}
		// echo '<pre>'; print_r($response);die;
		echo json_encode($response);
	}
	
	public function getUniversitybynomenclature()
	{  
		// $response = array('status'=>FALSE,'data'=>array(),'csrfName'=>'','csrfHash'=>'','stateuniversities'=>array(),'centraluniversities'=>array(),'agriculturealuniversities' =>array(),'nit'=>array());	$courses = array();

		try {
			$user_data = $this->session->userdata('user_data');
			$apply_course_type = $user_data['apply_course_type'];


			$coursetype = $this->input->post('coursetype');

			$nomen = $this->input->post('nomen');


			//echo $id;echo $ctype;die;


		
				
			$courses = $this->common_model->getuniversityBynomen($nomen,$coursetype);

			if (count($courses) > 0) {
				$response['status'] = TRUE;
				foreach ($courses as $row) {
					$response['data'][] = $row;
				}
			}
				$response['csrfName'] = $this->security->get_csrf_token_name();
			$response['csrfHash'] = $this->security->get_csrf_hash(); 
			/*$stateUniversities = $this->common_model->getStateUniversitiesWithMapping($id, $ctype);

			//echo "<pre>";
			//print_r($stateUniversities);
			if (count($stateUniversities) > 0) {
				$response['stateUniversities'] = $stateUniversities;
			}
			$centralUniversities = $this->common_model->getCentralUniversitiesWithMapping($id, $ctype);
			//echo "<pre>";print_r($centralUniversities);die; 
			if (count($centralUniversities) > 0) {
				$response['centraluniversities'] = $centralUniversities;
			}
			$agriCultureUniversities = $this->common_model->getagriCultureUniversitiesWithMapping($id, $ctype, $apply_course_type);
			//echo "<pre>";print_r($agriCultureUniversities);die;
			if (count($agriCultureUniversities) > 0) {
				$response['agriculturealuniversities'] = $agriCultureUniversities;
			} else {
				$response['centralUniversities'] = array();
			}*/
		} catch (Exception $e) {
			echo json_encode($response);
		}
		// echo '<pre>'; print_r($response);die;
		echo json_encode($response);
	}
	
	
	public function getCourseByPrgramme()
	{
		// $response = array('status'=>FALSE,'data'=>array(),'csrfName'=>'','csrfHash'=>'','stateuniversities'=>array(),'centraluniversities'=>array(),'agriculturealuniversities' =>array(),'nit'=>array());	$courses = array();

		try {
			$user_data = $this->session->userdata('user_data');
			$apply_course_type = $user_data['apply_course_type'];


			$id = $this->input->post('programme');

			$ctype = $this->input->post('course_type');


			//echo $id;echo $ctype;die;


			if ($id == 3 || $id == 4 || $id == 5 || $id == 6 || $id == 7 || $id == 1 ) {
				
				if ($id == 3 || $id == 4) {
					$stateUniversities = $this->common_model->getStateUniversitiesWithMapping($id, $ctype);

					//echo "<pre>";
					//print_r($stateUniversities);
					if (count($stateUniversities) > 0) {
						$response['stateUniversities'] = $stateUniversities;
					}
					// $states = $this->common_model->getAllStates();
					
					// foreach ($states as $state) {
					// 	//$univesities = $this->common_model->getUniversitiesByTypeAndStateId($state['id'],2);
					// 	//echo '<pre>'; print_r($state);die;
					// 	if (array_key_exists($state['id'], $response['stateuniversities'])) {
					// 		$response['stateuniversities'][$state['name']] = array();
					// 	}
					// 	$response['stateuniversities'][$state['id']] = array('stateid');
					// }
					// echo '<pre>'; print_r($response);die;
				}
				if ($id == 5 || $id == 6 || $id == 7) {
				}
			}

			$courses = $this->common_model->getCourseByPrgrammeAndType($id, $ctype);

			if (count($courses) > 0) {
				$response['status'] = TRUE;
				foreach ($courses as $row) {
					$response['data'][] = $row;
				}
			}
			$stateUniversities = $this->common_model->getStateUniversitiesWithMapping($id, $ctype);

			//echo "<pre>";
			//print_r($stateUniversities);
			if (count($stateUniversities) > 0) {
				$response['stateUniversities'] = $stateUniversities;
			}
			$centralUniversities = $this->common_model->getCentralUniversitiesWithMapping($id, $ctype);
			//echo "<pre>";print_r($centralUniversities);die; 
			if (count($centralUniversities) > 0) {
				$response['centraluniversities'] = $centralUniversities;
			}
			$agriCultureUniversities = $this->common_model->getagriCultureUniversitiesWithMapping($id, $ctype, $apply_course_type);
			//echo "<pre>";print_r($agriCultureUniversities);die;
			if (count($agriCultureUniversities) > 0) {
				$response['agriculturealuniversities'] = $agriCultureUniversities;
			} else {
				$response['centralUniversities'] = array();
			}
		} catch (Exception $e) {
			echo json_encode($response);
		}
		// echo '<pre>'; print_r($response);die;
		echo json_encode($response);
	}
	public function logout()
	{
		$userInfo =$this->session->userdata('user_data');
		$lastLoginHistry = $this->user_model->updateLogoutHistry($userInfo);
		$this->session->unset_userdata('salt');
		$this->session->sess_destroy();
		redirect('home');
	}

	//=================Added by Rahul Dey==================

	public function getCourseType()
	{
		$program_type = $_POST['programme'];
		$user_data = $this->session->userdata('user_data');
		$student_type = $user_data['student_type'];
		// print_r($student_type);die();
		$student_course_type = $user_data['apply_course_type'];

		if ($student_type == 1 && $student_course_type == 4 || $student_type == 1 && $student_course_type == 2 || $student_type == 1 && $student_course_type == 1 || $student_type == 1 && $student_course_type == 11) {
			$result = $this->common_model->getAllCourseType();
		} elseif ($student_type == 1 && $student_course_type == 11) {
			$result = $this->common_model->getAllCourseTypeSfs();
		} else {
			$result = $this->common_model->getAllCourseTypeAyush();
		}
		//$program_type = $_POST['programme'];
		//$result = $this->common_model->getAllCourseType();

		//$result = $this->common_model->getAllPhdCourseType($program_type);
		//echo "<pre>";print_r($result);die;
		$ctypeHtml = '';
		$ctypeHtml .= "<option selected value=''>Select Course Type</option>";
		foreach ($result as $val) {
			$ctypeHtml .= "<option value='" . $val['id'] . "'>" . $val['course_type'] . "</option>";
		}
		echo $ctypeHtml;
		exit;
	}

	public function getCertificateCourseType()
	{
		$program_type = $_POST['programme'];
		$user_data = $this->session->userdata('user_data');
		$student_type = $user_data['student_type'];
		$student_course_type = $user_data['apply_course_type'];

		if ($student_type == 1 && $student_course_type == 9) {
			$result = $this->common_model->getCertificateCourseType();
		}
		$ctypeHtml = '';
		$ctypeHtml .= "<option value='0'>Course Type</option>";
		foreach ($result as $val) {
			$ctypeHtml .= "<option value='" . $val['id'] . "'>" . $val['course_type'] . "</option>";
		}
		echo $ctypeHtml;
		exit;
	}


	public function uploadPhdResearchPaper()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (phd.pdf..etc.) not in other language like:-> غفران_الحلبي_كش.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 4000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 5MB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Phd_Research' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Phd_Research/';
				} else {
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['phdReseachPaper']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function uploadOtherDocsSfs()
	{
		try {
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

			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 3000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 5MB.'));
				return;
			}

			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_other_Doc_' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/SFS_other_Doc/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['otherDoc']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertSfsDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function uploadOtherDocs()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (other.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 3000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 5MB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_other_Doc_' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/other_Doc/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['otherDoc']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	
	public function uploadTOEFLDocs()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (other.pdf..etc.) not in other language like:-> غفرا_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 700000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 700KB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 700KB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_toefl_Doc_' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/other_Doc/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['toeflDoc']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	
	public function uploadIELTSDocs()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (other.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 700000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 700KB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 700KB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_ielts_Doc_' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/other_Doc/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['ieltsDoc']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	
	public function uploadDUOLINGODocs()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (other.pdf..etc.) not in other language like:-> غفران_الحلب_كشف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 700000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 700KB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 700KB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_ielts_Doc_' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/other_Doc/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['duolingoDoc']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	
	public function uploadSubjectDocs()
	{
		try {
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (other.pdf..etc.) not in other language like:-> غفران_الحلبي_شف.pdf."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'Invalid File.'));
				return;
			}
			if ($sizekbb > 700000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 700KB!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size must be less than equal to 700KB.'));
				return;
			}

			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_ielts_Doc_' . $name;


				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/other_Doc/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['subjectDoc']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}




	//Sfs Form






	public function applicant_sfs_personal_info()
	{
		//echo "sadasd";die;
		try {
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$userType = $user_data['user_type'];
			$data['registerSfsData'] = $this->common_model->getSfsUserData($userId);
			$imgArray = $this->common_model->getSfsUserImage($userId);
			if (count($imgArray) > 0) {
				$data['userImage'] = $imgArray[0]['name'];
			} else {
				$data['userImage'] = '';
			}
			$applicationData = $this->common_model->getApplicationSfsStepOne($userId);

			$data['applicaitonSfsStepOne'] = $applicationData;
			$data['missions'] = $this->common_model->getAllMissions();
			if (count($data['applicaitonSfsStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonSfsStepOne'][0]['application_no'];
			} else {
				$data['missions'] = $this->common_model->getAllMissions();
				$data['get_application_number'] = $this->random_num(15);
			}

			if (count($applicationData) > 0 && $applicationData[0]['status'] == "Draft") {
				$data['applicaitonSfsStepOne'] = $applicationData;
				$data['univercities'] = $this->common_model->getUnivercities();
				$this->load->view('site/header');
				$this->load->view('site/sfs/applicant_sfs_personal_info', $data);
				$this->load->view('site/footer');
			} elseif (count($applicationData) > 0 && $applicationData[0]['status'] == "Submit") {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You have already applied!');
				redirect(site_url() . 'applicant/dashboard');
			} else {
				$data['applicaitonSfsStepOne'] = $applicationData;
				$data['univercities'] = $this->common_model->getUnivercities();
				$this->load->view('site/header');
				$this->load->view('site/sfs/applicant_sfs_personal_info', $data);
				$this->load->view('site/footer');
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect(site_url() . 'applicant/dashboard');
		}
	}




	public function applicant_sfs_education_info()
	{
		//echo "<pre>";
		//print_r($_POST);die;
		$actual_link =  $_SERVER['HTTP_REFERER'];
		try {
			$year = date('Y');
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";
			//print_r($user_data);die;
			$userId = $user_data['userid'];
			$appno = '';
			if (isset($_GET['appno'])) {
				$appno = $_GET['appno'];
			}
			if (!empty($_POST)) {
                 $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));

				//var_dump($userInfo);die;
				unset($clean['step-one-application']);
				if ($this->common_model->applicationSfsExists($userId)) {
					//echo "sadasdsad";die;
					$choice_one = $clean['universty_choice'];
					$choice_two = $clean['universty_choice_two'];
					$choice_three = $clean['universty_choice_three'];
					$stateId = 0;
					$stateIdOne = 0;
					$stateIdtwo = 0;
					if ($choice_one > 0) {
						$stateId = $this->common_model->getUniversityStateById($choice_one);
						$clean['university_choice_one_state'] = $stateId[0]['state'];
					}
					if ($choice_two > 0) {
						$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
						$clean['university_choice_two_state'] = $stateIdOne[0]['state'];
					}
					if ($choice_three > 0) {
						$stateIdtwo = $this->common_model->getUniversityStateById($choice_three);
						$clean['university_choice_three_state'] = $stateIdtwo[0]['state'];
					}
					$this->common_model->updateApplicationSfsStepOne($clean, $userId);
				} else {
					//$checkyear = $this->user_model->checkYear($clean['passport_no'],$year);
					//echo "<pre>";
					//var_dump($checkyear);die;
					//$userInfo = $this->user_model->checkPassportYear($clean['passport_no'],$year);
					//var_dump($userInfo);die;
					$clean['status'] = 'Draft';
					$choice_one = $clean['universty_choice'];
					$choice_two = $clean['universty_choice_two'];
					$choice_three = $clean['universty_choice_three'];
					$stateId = 0;
					$stateIdOne = 0;
					$stateIdtwo = 0;
					//var_dump($userInfo);die;
					/* if($userInfo){
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','Application already exists this passport number');
							redirect($actual_link);
							return false;
			            } */
					if ($choice_one > 0) {
						$stateId = $this->common_model->getUniversityStateById($choice_one);
						$clean['university_choice_one_state'] = $stateId[0]['state'];
					}
					if ($choice_two > 0) {
						$stateIdOne = $this->common_model->getUniversityStateById($choice_two);
						$clean['university_choice_two_state'] = $stateIdOne[0]['state'];
					}
					if ($choice_three > 0) {
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
			$this->load->view('site/header');
			$this->load->view('site/sfs/applicant_sfs_educaion_info', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect($actual_link);
		}
	}


	public function applicant_sfs_other_info()
	{
		//echo "sfs";die;
		$actual_link =  $_SERVER['HTTP_REFERER'];
		try {
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$data['registerSfsData'] = $this->common_model->getSfsUserData($userId);
			$appno = '';
			if (isset($_GET['appno'])) {
				$appno = $_GET['appno'];
			}
			if (!empty($_POST)) {
				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
				 $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				$clean['created'] = date("Y-m-d h:i:s");
				if ($this->common_model->educationSfsExists($userId)) {
					$this->common_model->updateSfsEducation($clean, $userId);
				} else {
					$clean['uid'] = $userId;
					$clean['application_no'] = $appno;
					$clean['created'] = date("Y-m-d h:i:s");
					//echo "<pre>";print_r($clean);die;
					$id = $this->common_model->insertSfsEducation($clean);
				}
			}
			$data['applicaitonSfsStepThree'] = $this->common_model->getApplicationSfsStepThree($userId);
			$this->load->view('site/header');
			$this->load->view('site/sfs/applicant_sfs_other_info', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
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
		try {
			$user_data = $this->session->userdata('user_data');
			$imgname = "";
			$userId = $user_data['userid'];
			$appno = '';
			if (isset($_GET['appno'])) {
				$appno = $_GET['appno'];
			}
			if (!empty($_POST)) {
				 $cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			  $clean =  $this->strip_quotes($cleanData);
				//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));

				$clean['created'] = date("Y-m-d h:i:s");

				if ($this->common_model->otherSfsDetailExists($userId)) {
					$this->common_model->updateSfsOtherDetails($clean, $userId);
				} else {
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
			$this->load->view('site/sfs/applicant_sfs_documents', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time.');
			redirect($actual_link);
		}
	}

	public function getStreamByCourse()
	{
		//echo "<pre>";print_r($_POST);die;
		$user_data = $this->session->userdata('user_data');
		$student_type = $user_data['student_type'];
		$universityId = $_POST['university'];
		$student_course_type = $user_data['apply_course_type'];
		$program_id = $_POST['programme'];
		$courseType_id = $_POST['courseType'];
		$course_id = $_POST['course'];
		//if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2)
		//{
		//$stateuniversities = $this->common_model->getAyushUniversitiesWithMapping($program_id,$courseType_id,$course_id);
		//}
		if ($student_type == 1 && $student_course_type == 4 || $student_type == NULL && $student_course_type == 4) {
			//$courseStream = $this->common_model->getUgUniversityStreamData($universityId,$program_id,$courseType_id,$course_id);
			$courseStream = $this->common_model->getUniversitiesCourseStreamMapping($universityId, $program_id, $courseType_id, $course_id);
			//echo "<pre>";print_r($courseStream);
		} elseif ($student_type == 1 && $student_course_type == 1 || $student_type == 1 && $student_course_type == 2) {
			//$courseStream = $this->common_model->getUgUniversityStreamData($universityId,$program_id,$courseType_id,$course_id);
			$courseStream = $this->common_model->getUniversitiesCourseStreamMapping($universityId, $program_id, $courseType_id, $course_id);
			//echo "<pre>";print_r($courseStream);
		} else {
			$stateuniversities = $this->common_model->getUniversitiesWithMapping($program_id, $courseType_id, $course_id);
		}
		$course =  $this->common_model->getAllCourses();
		$courseWiseUniversites = array();
		//echo "<pre>";print_r($statewiseUniversites);die;
		foreach ($course as $st) {
			if (!array_key_exists($st['id'], $courseWiseUniversites)) {
				$courseWiseUniversites[$st['id']] = array();
			}
		}
		echo '<optgroup label="Courses">';
		foreach ($courseStream as $univercity) {
			if (array_key_exists($univercity['course_id'], $courseWiseUniversites)) {
				array_push($courseWiseUniversites[$univercity['course_id']], $univercity);
			}
		}
		echo '<option>------Select---------</option>';
		foreach ($courseWiseUniversites as $key => $univercity1) {
			echo "<pre>";
			print_r($univercity1);
			if (count($univercity1) > 0) {
				$statenames = $this->common_model->getCourseById($key);

				echo '<optgroup label="&nbsp;&nbsp;&nbsp;' . $statenames[0]['title'] . '" class="stt">';
				foreach ($univercity1 as $uni_choice) {
					if (!empty($applicaitonStepOne)) {
						if ($applicaitonStepOne[0]['course_option_name'] == $uni_choice['id']) {
							echo '<option selected="selected" value="' . $uni_choice['name'] . '">' . $uni_choice['name'] . '</option>';
						} else {
							echo '<option value="' . $uni_choice['id'] . '" disabled>' . $uni_choice['name'] . '</option>';
						}
					} else {
						echo '<option value="' . $uni_choice['id'] . '">' . $uni_choice['name'] . '</option>';
					}
				}
				echo '</optgroup>';
			}
		}
		echo '</optgroup>';
	}
	public function getAyushUniversityByCourse()
	{
		//echo "<pre>";print_r($_POST);die;
		$user_data = $this->session->userdata('user_data');
		$student_type = $user_data['student_type'];
		$student_course_type = $user_data['apply_course_type'];
		$program_id = $_POST['programme'];
		$courseType_id = $_POST['courseType'];
		$course_id = $_POST['course'];
		$university_id = $_POST['university'];
		if ($student_type == 1 && $student_course_type == 10 || $student_type == NULL && $student_course_type == 10) {
			//echo "---------------------";die;
			$stateuniversities = $this->common_model->getAyushUniversitiesWithMapping($program_id, $courseType_id, $course_id);
		}

		if ($student_type == 1 && $student_course_type == 4 || $student_type == NULL && $student_course_type == 4) {
			$stateuniversities = $this->common_model->getUniversitiesWithMapping($program_id, $courseType_id, $course_id, $university_id);
			//echo "<pre>";print_r($stateuniversities);die;
			$nits = $this->common_model->getNITUniversitiesWithMapping($program_id, $courseType_id, $course_id, $university_id);
			//echo "<pre>";print_r($nits);die;
			$iits = $this->common_model->getIITUniversitiesWithMapping($program_id, $courseType_id, $course_id);
		} elseif ($student_type == 1 && $student_course_type == 1 || $student_type == 1 && $student_course_type == 2) {
			//echo "die-----";die;
			$stateuniversities = $this->common_model->getUniversitiesWithMapping($program_id, $courseType_id, $course_id, $university_id);
			//echo "<pre>";print_r($stateuniversities);die;
			$nits = $this->common_model->getNITUniversitiesWithMapping($program_id, $courseType_id, $course_id, $university_id);
			//echo "<pre>";print_r($nits);die;
			$iits = $this->common_model->getIITUniversitiesWithMapping($program_id, $courseType_id, $course_id);
		}

		$states =  $this->common_model->getAllStates();
		//$nits = $this->common_model->getNITUniversities();
		$statewiseUniversites = array();
		//echo "<pre>";print_r($statewiseUniversites);die;
		foreach ($states as $st) {
			if (!array_key_exists($st['id'], $statewiseUniversites)) {
				$statewiseUniversites[$st['id']] = array();
			}
		}
		echo '<optgroup label="State Universities">';
		foreach ($stateuniversities as $univercity) {
			
			if (array_key_exists($univercity['state_id'], $statewiseUniversites)) {
				array_push($statewiseUniversites[$univercity['state_id']], $univercity);
			}
		}
		echo '<option>------Select---------</option>';
		foreach ($statewiseUniversites as $key => $univercity1) {
			if (count($univercity1) > 0) {
				$statenames = $this->common_model->getStateById($key);

				echo '<optgroup label="&nbsp;&nbsp;&nbsp;' . $statenames[0]['name'] . '" class="stt">';
				foreach ($univercity1 as $uni_choice) {
					
					if (!empty($applicaitonStepOne)) {
						if ($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id']) {
							echo '<option selected="selected" value="' . $uni_choice['id'] . '">' . $uni_choice['name'] . '</option>';
						} else {
							echo '<option value="' . $uni_choice['id'] . '" disabled>' . $uni_choice['name'] . '</option>';
						}
					} else {
						echo '<option value="' . $uni_choice['id'] . '">' . $uni_choice['name'] . '</option>';
					}
				}
				echo '</optgroup>';
			}
		}
		echo '</optgroup>';
		die;
		echo '<optgroup label="National Institute of Technology (NIT)">';
		foreach ($nits as $univercity_nit) {
			if (!empty($applicaitonStepOne)) {
				if ($applicaitonStepOne[0]['universty_choice'] == $univercity_nit['id']) {
					echo '<option selected="selected" value="' . $univercity_nit['id'] . '">' . $univercity_nit['uni'] . '</option>';
				} else {
					echo '<option value="' . $univercity_nit['id'] . '">' . $univercity_nit['uni'] . '</option>';
				}
			} else {
				echo '<option value="' . $univercity_nit['id'] . '">' . $univercity_nit['uni'] . '</option>';
			}
		}
		echo '</optgroup>';


		echo '<optgroup label="Indian Institute of Technology (IIT)">';
		foreach ($iits as $univercity_iit) {
			if (!empty($applicaitonStepOne)) {
				if ($applicaitonStepOne[0]['universty_choice'] == $univercity_iit['id']) {
					echo '<option selected="selected" value="' . $univercity_iit['id'] . '">' . $univercity_iit['uni'] . '</option>';
				} else {
					echo '<option value="' . $univercity_iit['id'] . '">' . $univercity_iit['uni'] . '</option>';
				}
			} else {
				echo '<option value="' . $univercity_iit['id'] . '">' . $univercity_iit['uni'] . '</option>';
			}
		}
		echo '</optgroup>';
	}



	// vipin ug

	public function selectedSchemeUniversityData()
	{
		//echo "<pre>";print_r($_POST);
		$var = $_POST['programme'];
		$var1 = $_POST['course_types'];
		if ($var == 2 && $var1 == 6 || $var == 2 && $var1 == 4 || $var == 1 && $var1 == 5 || $var == 2 && $var1 == 5  || $var == 4 && $var1 == 5 || $var == 1 && $var1 == 2) {
			$university_id = $_POST['uni_id'];
			$programme = $_POST['programme'];
			$course_type = $_POST['course_types'];
			$course = $_POST['course'];
			//$universityData = $this->common_model->getUgUniversityData($university_id,$programme,$course_type,$course);
			//$universityData = $this->common_model->getUgUniversityStreamData($university_id,$programme,$course_type,$course);
			//echo "<pre>";print_r($universityData);die;
			$universityData = [];
			if ($var == 1 && $var1 == 5) {
				//$main_array = explode('|',$universityData[0]['ug_courser_id']);
				$main_array = explode('|', $universityData[0]['ug_course_stream_id']);
				//echo "<pre>";print_r($main_array);
			} elseif ($var == 2 && $var1 == 5 || $var == 2 && $var1 == 6) {
				//echo "----------";die;
				$main_array = explode('|', $universityData[0]['pg_courser_stream_id']);
			} elseif ($var == 2 && $var1 == 4) {
				$main_array = explode('|', $universityData[0]['pg_courser_id']);
			} elseif ($var == 4 && $var1 == 5) {
				$main_array = explode('|', $universityData[0]['phd_courser_id']);
			}
			$Coursedata = $this->common_model->getUgUniversityStreamData($university_id, $programme, $course_type, $course);
			//$Coursedata =  $this->common_model->getUniversitiesCourseStreamMapping($university_id,$programme,$course_type,$course);
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

			$response = "<table class='table table-bordered'>";
			$response .= "<tr>";
			$response .= "<td><p align ='center'>" . $universityData[0]['name'] . '<p align ="center">following Streams only:-' . "</td>";
			$response .= "</tr>";
			$response .= "<tr>";
			$counter = 1;
			if (count($Coursedata) > 0) {
				foreach ($Coursedata as $key) {
					$Coursedata =  $this->common_model->getStreamssById($key['stream_id']);
					//echo "<pre>";print_r($Coursedata);
					$response .= "<tr></td><td>" . $counter . ' - ' . $Coursedata[0]['name'] . '(' . $Coursedata[0]['no_of_seat'] . ')' . "</tr></td>";
					$counter++;
				}
				$response .= "</tr>";

				echo $response;
			} else {
				'No Data Found!';
			}
			//exit;

		}
	}
	// vipin ayush

	public function selectedAyushSchemeUniversityData()
	{
		//print_r($_POST);die;
		$university_id = $_POST['uni_id'];
		$programme = $_POST['programme'];
		$course_type = $_POST['course_types'];
		$course = $_POST['course'];
		$universityData = $this->common_model->getUniversityData($university_id, $programme, $course_type, $course);
		//echo "<pre>";print_r($universityData);die;
		$main_array = explode('|', $universityData[0]['scheme_id']);
		$scheme_one = $main_array[0];
		$scheme_two = $main_array[1];
		$scheme_three = $main_array[2];
		//echo "<pre>";print_r($main_array);die;
		$schemedata_one =  $this->common_model->getSchemeById($scheme_one);
		$schemedata_two =  $this->common_model->getSchemeById($scheme_two);
		$schemedata_three =  $this->common_model->getSchemeById($scheme_three);

		//echo "<pre>";print_r($schemedata_one);
		//echo "<pre>";print_r($schemedata_two);die;
		if ($universityData) {
			foreach ($universityData as $resutlt) {
				$response = "<table class='table table-bordered'>";
				$response .= "<tr>";
				$response .= "<td><p align ='center'>" . $resutlt['name'] . '<p align ="center">is under following schemes only:-' . "</td>";
				$response .= "</tr>";

				$response .= "<tr>";

				if (!empty($schemedata_one) && empty($schemedata_two) && empty($schemedata_three)) {
					$response .= "<td><b></td><td>" . $schemedata_one[0]['scheme_name'] . "</td>";
				}
				if (!empty($schemedata_one) && !empty($schemedata_two) && !empty($schemedata_three)) {
					//$response .= "<td><b></td><td>".$schemedata_one[0]['scheme_name'].' '.'&'.$schemedata_two[0]['scheme_name'].' '.'AND'.' '.$schemedata_three[0]['scheme_name']."</td>";
					$response .= "<tr><td>1. " . $schemedata_one[0]['scheme_name'] . "</tr></td>";
					$response .= "<tr><td>2. " . $schemedata_two[0]['scheme_name'] . "</tr></td>";
					$response .= "<tr><td>3. " . $schemedata_three[0]['scheme_name'] . "</tr></td>";
				} elseif (!empty($schemedata_one) && !empty($schemedata_two)) {
					$response .= "<tr><td>1. " . $schemedata_one[0]['scheme_name'] . "</tr></td>";
					$response .= "<tr><td>2. " . $schemedata_two[0]['scheme_name'] . "</tr></td>";
				} elseif (!empty($schemedata_one) && !empty($schemedata_two) && !empty($schemedata_three)) {
					//$response .= "<td><b></td><td>".$schemedata_one[0]['scheme_name'].' '.'&'.$schemedata_two[0]['scheme_name'].' '.'AND'.' '.$schemedata_three[0]['scheme_name']."</td>";
					$response .= "<tr><td>1. " . $schemedata_one[0]['scheme_name'] . "</tr></td>";
					$response .= "<tr><td>2. " . $schemedata_two[0]['scheme_name'] . "</tr></td>";
					$response .= "<tr><td>3. " . $schemedata_three[0]['scheme_name'] . "</tr></td>";
				}




				$response .= "</tr>";
			}

			$response .= "</table>";

			echo $response;
		} else {
			'No Data Found!';
		}
		exit;
	}
	public function uploadSfsSignature()
	{
		try {
			$imgname = "";
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
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
				return;
			}
			if ($sizekbb > 2097152) {
				$this->session->set_flashdata('error', 'File size is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size should be less than equal to 1 MB!'));
				return;
			}
			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_profile_signature_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/profile_sfs_signature/';
				} else {
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				$date = date("Y-m-d h:i:s");
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'signature_doc' => $imgname,
						'created' => time()
					);
					if ($this->common_model->otherSfsDetailExists($userId)) {
						$sts = $this->common_model->updateSfsOtherDetails($data, $userId);
					} else {
						$data['uid'] = $userId;
						$data['application_no'] = $applicatinNo[0]['application_no'];
						$sts = $this->common_model->insertSfsOtherDetails($data);
					}
					if ($sts) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}

	public function view_personal_info()
	{

		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if ($imgArray > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		$this->load->view('site/header');
		$this->load->view('site/view_personal_info', $data);
		$this->load->view('site/footer');
	}
	public function uploadGmatScore()
	{
		try {

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
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				if ($pdf != '%PDF' || strpos($contents, 'obj') === false || strpos($contents, 'endobj') === false) {
					$this->session->set_flashdata('error', 'File content is not Valid!');
					echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
					return false;
				}
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, "message" => "File Content is Not Valid."));
				return;
			}
			if ($sizekbb > 1000000) {
				$this->session->set_flashdata('error', 'File size must less than equal to 5MB!');
				echo json_encode(array('status' => FALSE, "message" => "File Size Should be less than 5MB."));
				return;
			}

			if ($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only JPEG/PNG/JPG/PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_Gamt_Score_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = 'assets/site/main/Gmat_Score/';
				} else {
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;
				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
					$data = array(
						'document_name' => $imgname,
						'doc_path' => $target_file,
						'doc_type' => $types['gmat']['type'],
						'added_on' => time(),
						'uid' => $userId,
						'application_no' => $applicatinNo[0]['application_no']
					);
					if ($this->common_model->insertDocuments($data)) {
						echo json_encode(array('status' => TRUE, 'file_path' => base_url() . $target_file));
					}
				} else {
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
	}
	public function applicant_education_info_prev()
	{

		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		$this->load->view('site/header');
		$this->load->view('site/applicant_education_info_prev', $data);
		$this->load->view('site/footer');
	}
	public function applicant_other_info_prev()
	{

		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);

		$this->load->view('site/header');
		$this->load->view('site/applicant_other_info_prev', $data);
		$this->load->view('site/footer');
	}

	public function applicant_document_info_view()
	{

		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyUserId($userId);
		$this->load->view('site/header');
		$this->load->view('site/applicant_document_info_view', $data);
		$this->load->view('site/footer');
	}


	function confirmaitonreceivesformhqrs()
	{
		try {
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$applicationId = $this->uri->segment(3);
			//echo $applicationId;die;
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getApplicantConfirmationofHqrs($applicationId);
			//$data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getConfirmationofApplicationIds($this->ids);
			$this->load->view('site/header');
			$this->load->view('site/confirmaitonreceivesformhqrs', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'site/dashboard');
		}
	}

	function processConfirmedappfromhqrsdemo()
	{
		try {
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['get_application_number'] = $this->random_num(15);
			}
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
			if (count($imgArray) > 0) {
				$image = $imgArray[0]['name'];
			} else {
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

			$this->load->view('site/header');
			$this->load->view('site/processConfirmedappfromhqrs', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'site/dashboard');
		}
	}

	function undertakingFromStudentdemo()
	{
		try {
			//$applicationId = $this->uri->segment(3);

			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			//echo $userId;die;
			$applicationId = $this->common_model->getApplicationAppnoByUserId($userId);
			//echo "<pre>";print_r($applicationId);die;
			$applicationId =  $applicationId[0]['application_no'];

			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$response = $this->common_model->getconfirmationDataByMission($applicationId);
			//echo "<pre>";print_r($response);die;
			$uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
			//echo $uni1[0]['name'];
			$course = $response[0]['course'];
			//echo $course;die;
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$this->load->file('fpdi/PdfHTMLTable.php');
			$pdf = new PdfHTMLTable();
			$pdf->AddPage('P');
			$pdf->SetXY(10.0, 5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial', '', 7);
			$pdf->MultiCell(180, 5, 'Ref. No.' . $applicationId, '', 'R');
			$pdf->MultiCell(180, 5, 'Date: ' . date('d M Y h:i:s'), '', 'R');

			$pdf->SetXY(10.0, 45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations', false);
			$pdf->SetFont('Arial', '', 10);
			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, 'Name of Scholarship Scheme : ' . $schemename[0]['scheme_name'], '', 'L');
			$pdf->Ln(5);

			$pdf->MultiCell(180, 5, '1. I Mr./Ms. ' . $stepOne[0]['fullname'] . ' do hereby affirm that I have understood all the terms & conditions of ICCR\'s scholarship scheme & agree to abide by them for the duration of my study in India under this scholarship.', '', 'J');
			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, '2. I confirm that the course ' . $course . ' being offered to me in ' . $uni1[0]['name'] . 'University/Institute is acceptable to me & that I will not ask for a change of either course or institution. In case I seek for a change of course/Institution after joining the course, I will reimburse the expenditure incurred on me for the previous course.', '', 'J');
			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, '3. If admitted to University/Institute which has a residential facility, I undertake to continue to stay in the hostel and not ask for a change from hostel to private accommodation.', '', 'J');
			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, '4. If I decide to leave India before the completion of my course, I agree to refund all expenses incurred by ICCR on my behalf.', '', 'J');
			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, '5. I certify that I do not suffer from terminal illness or aliments affecting vital organs /certify that I am not in the family way. In case of such illness which requires long absence from course, I agree if I am sent back to my country.', '', 'J');


			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, '6. I agree to abide by and respect role of conduct of the country. In case I get involved in illegal activities and /or events concerning law and order issues, I agree on being deported to my country. ', '', 'J');
			$pdf->Ln(5);
			$pdf->SetFont('Arial', 'B');
			$pdf->MultiCell(170, 5, 'Scholar                                                                                                                            Guardian ', '', 'L');
			$pdf->SetFont('Arial', '', 10);
			$pdf->Ln(5);
			$pdf->MultiCell(170, 5, 'Signature   : ............................................', '', 'L');
			$pdf->Ln(5);
			$pdf->MultiCell(170, 5, 'Name        : ' . $stepOne[0]['fullname'], '', 'L');
			$pdf->Ln(5);
			$pdf->MultiCell(170, 5, 'Country     : ' . $country[0]['country_name'], '', 'L');
			$pdf->Ln(5);
			$pdf->MultiCell(170, 5, 'Date          : ' . date('d M Y h:i:s'), '', 'L');
			$pdf->Ln(5);
			$pdf->MultiCell(170, 5, 'Passport No : ............................................', '', 'L');

			$filename = $applicationId . "_UnderTaking_" . date('jS-F-Y-h-i-s') . '.pdf';
			$pdf->Output($filename, "D");
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'mission/dashboard');
		}
	}
	function undertakingFromStudent()
	{
		try {
			$applicationId = $this->uri->segment(3);
			//echo $applicationId;die;
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$response = $this->common_model->getconfirmationDataByMission($applicationId);
			//echo "<pre>";print_r($response);die;
			$nomenid = (!empty($response) ? $response[0]['nomenclature'] : '');
			$nomclature = $this->common_model->getnomenclatureByid($nomenid);
			$nomenclature=$nomclature[0]['title'];
			//echo $userId;die;
			//$applicationId = $this->common_model->getApplicationAppnoByUserId($userId);
			//echo "<pre>";print_r($applicationId);die;
			//$applicationId =  $applicationId[0]['application_no'];

			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);
			$country = $this->common_model->getCountryById($stepOne[0]['nationality']);
			//echo "<pre>";print_r($country);die;
			$schemeId = $this->common_model->getMappingData($applicationId);
			$applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$userd = $this->common_model->getUserInfo($applicaitonStepThree[0]['uid']);
			$applicantAcceptanceDate = $schemeId[0]['undertaking_doc'];
			$applicaitonSubmitData = [];
			$date1 = (!empty($applicaitonSubmitData) ? $applicaitonSubmitData[0]['created'] : '');
			$acDate =  date('d-m-Y', $applicantAcceptanceDate);
			$imgs = file_get_contents($userd->dir . '/' . $applicaitonStepThree[0]['signature_doc']);
			$data = base64_encode($imgs);
			$f = finfo_open();
			$imgdata = base64_decode($data);
			$mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
			$img_base64_encoded = 'data:' . $mime_type . ';base64,' . $data . '';
			$imageContent = file_get_contents($img_base64_encoded);
			$imgPath = tempnam(sys_get_temp_dir(), 'prefix');

			file_put_contents($imgPath, $imageContent);
			/* if($userd == ''){
				$imgPath = site_url().'assets/site/main/profile_signature/'.$applicaitonStepThree[0]['signature_doc'];
			}else{
				$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			} */
			$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			$new = '<img src="' . $imgPath . '" style="width:100px;">';

			$image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$logo = '<img src="' . $image . '" style="width:auto;">';

			//echo "<pre>";print_r($imgPath);die;
			$uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
			//echo $uni1[0]['name'];
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
        <p>Acceptance of <?php echo $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname'] . ' to offer of admission at ' . $uni1[0]['name'] . ' to pursue ' . $nomenclature; ?>    	
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


die;

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



	public function UploadUnderTaking()
	{
		try {
			$user_data = $this->session->userdata('user_data');
			$applicationId = $_POST['id'];
			//echo $applicationId;die;
			if (!empty($_POST)) {
				
				try {
			$imgname = "";
			$files = $_FILES['file'];
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
			if (strlen($fnmae) != mb_strlen($fnmae, 'utf-8')) {
				echo json_encode(array('status' => FALSE, "message" => "All file names should be in english language like (signature.jpg..etc.) not in other language like:-> غفران_الحلبي_كشف.jpg."));
				return;
			}
			if ($nsection != "JVBERI0X" && $nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") {
				$this->session->set_flashdata('error', 'File content is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed!'));
				return;
			}
			if ($sizekbb > 200000) {
				$this->session->set_flashdata('error', 'File size is not Valid!');
				echo json_encode(array('status' => FALSE, 'message' => 'File size should be less than equal to 200 KB!'));
				return;
			}
			if ($typpe != "application/pdf") {
				$this->session->set_flashdata('error', 'File Type is not Valid! Only JPEG/PNG/JPG files are allowed');
				echo json_encode(array('status' => FALSE, "message" => "File Type is not Valid! Only PDF files are allowed"));
				return;
			}

			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_medical_fitness_' . $name;

				if ($user_data['dir'] == "") {
					$target_file = '2026/medical_fitness/';
				} else {
					if (!is_dir($user_data['dir'])) {
						mkdir($user_data['dir'], 0777, TRUE);
					}
					$target_file = $user_data['dir'] . '/';
				}
				$target_file = $target_file . $imgname;

				if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {					
						$imgname1 = $imgname;					
					
				} else {
					$imgname1 = '';
					echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE, "message" => "Error While Uploading File!. Try Again Later."));
		}
				

				$data = array(
					'scholar_acceptance' => $this->input->post('scholar_is_accept'),
					'undertaking_doc' => time(),
					'medical_fitness' => $imgname1,
					'status' => 11
				);
				//echo "<pre>";print_r($data);die;
				$sts = $this->common_model->uploadUndertaking($applicationId, $data);
				//$confirmMasterData = array(
				//'status'=>12
				//);
				//$stsMater = $this->common_model->UpdateToFinalConfirmationToHqrsbyMissionStatusMaster($confirmMasterData,$appid,$id);
				if ($sts) {
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Accepted the offer successfully!');
					redirect(site_url() . 'applicant/applicantStatus/' . $applicationId);
				}
			}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE));
		}
	}


	function getFinancialYears($from, $nexttoyears)
	{
		$currentDate = $from;
		$lastFY = date('Y-m-d', strtotime('+' . $nexttoyears . ' years'));
		return $this->calcFY($currentDate, $lastFY);
	}
	function calcFY($startDate, $endDate)
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
	//Visa Grant Offer Letter

	function offerReceivedWithFormat()
	{
		try {
			$doc = array();
			$applicationId = $this->uri->segment(3);
			$uniid = $this->uri->segment(4);
			$response = $this->common_model->getconfirmationDataforHqrs($applicationId);
			$student_registerDate = $this->common_model->getStudentRegistratioYear($applicationId);
			$registerDate = $student_registerDate[0]['created'];
			$studentRegisterYear = date('d-m-Y', $registerDate);
			$compareDate = '15-12-2018';
			$date = date_create($studentRegisterYear);
			$array =  (array) $date;
			$miss = date("Y-m-d", strtotime($array['date']));
			$date1 = date_create($miss);
			$date2 = date_create($compareDate);
			$diff = date_diff($date1, $date2);
			//now convert the $diff object to type integer
			$intDiff = $diff->format("%R%a");

			$intDiff = intval($intDiff);

			if ($intDiff > 0) {

				$current  = '15-12-2018';
				$fy = $this->getFinancialYears($current, 1);
			} else {
				$current = date('d-m-Y');
				$fy = $this->getFinancialYears($current, 1);
			}






			$region = 0;
			$coursename = "";
			$respFile = "";
			if (count($response) > 0) {
				foreach ($response as $resp) {
					if ($resp['university_is_accept'] == 1 && $resp['regional_university'] == $uniid) {
						$respFile = $resp['region_one_doc'];
						$region = $resp['region_one_status'];
						$coursename = $resp['course'];
						array_push($doc, $resp['region_one_doc']);
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
			$pdf->SetXY(10.0, 5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial', '', 7);
			$pdf->MultiCell(180, 5, 'Ref. No.' . $applicationId, '', 'R');
			$pdf->MultiCell(180, 5, 'Date: ' . date('d M Y h:i:s'), '', 'R');

			$pdf->SetXY(10.0, 45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations', false);
			$pdf->SetFont('Arial', '', 10);
			$pdf->Ln(5);
			$pdf->SetFont('Arial', '', 35);
			$pdf->SetTextColor(221, 221, 255);
			$pdf->RotatedText(35, 190, 'Indian Council For Cultural Relations', 45);
			$pdf->SetFont('Arial', '', 10);
			$pdf->SetTextColor(0, 0, 0);
			//$pdf->MultiCell(180,5,$mission[0]['mission_type'].': '.$mission[0]['mission_name'],'','L');

			//$pdf->MultiCell(180,5,$mission[0]['country_name'],'','L');

			$pdf->MultiCell(180, 5, 'Dear Student', '', 'L');

			//$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year '.$fy[1].'. Mr./Ms. '.$stepOne[0]['fullname'].' is provisionally confirmed for '.$coursename.' course at '.$uninmae[0]['name'].', Regional Office '  .$regionInfo[0]['name'].' subject to production of all original documents at the time of joining','','J');


			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, 'Kindly refer to your application for admission to an Indian University under the above mentioned Scholarshp Scheme.', '', 'J');
			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, '1)	We are pleased to inform you that have been provisionally selected for ' . $coursename . ' course at ' . $uninmae[0]['name'] . '', '', 'J');
			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, '2)	You are required to report to Scholarshp Division Indian Council For Cultural Relations(ICCR) Delhi or ' . $uninmae[0]['name'] . ' along with all original certficates including G.C.E(O\L & A/L) result issued by the Department of Examination,' . $country[0]['country_name'] . '', '', 'J');
			$pdf->Ln(5);
			$pdf->MultiCell(180, 5, '3)	You are also inform that no request for change of course or university will be entertained. Students joining a science course, will have to be bear the expenduture on chemaicals and other incidental charges.You have to give an undertaking that you would undergo AIDS test in India and in case you are found HIV positive you will have to return to ' . $country[0]['country_name'] . ' at your own cost.Hostel facality may be provided, subject to availability. Kindly confirm your acceptance as early as possible (Enclosed Performa) by fax/email(). In case we do not hear anything from you then we will treat that you are no more interested to avail this scholarship. You will also have to give an undertaking that in case you leave the course in between you have to pay all the expences incurred by ICCR. You are advice to carry with you some money (a minimum of Indian Ruppees 35,000\-) to meet incidental expences on arrival in India.', '', 'J');
			$pdf->Ln(5);

			$pdf->MultiCell(180, 5, '4) 	On arrival in India, You have to register yourself at the Foreigners Regional Registration Office(FRRO). Kindly furnish us the expected date of your depature and details of Journey so that the ICCR is informed well in advance to arrange reception on your arrival in India.', 'J');
			$pdf->Ln(5);

			$pdf->MultiCell(180, 5, '6)	Please contact ' . $mission[0]['mission_type'] . ': ' . $mission[0]['mission_name'] . 'this High Commission for any further assistance, including visa etc.', '', 'J');
			$pdf->Ln(5);



			$pdf->SetFont('Arial', '', 10);
			$pdf->Ln(5);
			$pdf->MultiCell(170, 5, 'Regards,', '', 'L');

			$pdf->MultiCell(170, 5, 'Your Sincerely', '', 'R');

			//$pdf->MultiCell(170,5,'ICCR,'.$regionInfo[0]['name'],'','R');

			$pdf->MultiCell(170, 5, 'File No. (' . $applicationId . ')/' . $fy[1], '', 'L');

			$filename = $applicationId . "_University_Response_" . date('jS-F-Y-h-i-s') . '.pdf';

			$filenamePath = FCPATH . "assets/site/main/accept/" . $filename;
			$pdf->Output($filename, "D");
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');

			redirect(site_url() . 'mission/dashboard');
		}
	}
	function scholarsvisaendrosment()
	{
		try {
			
			//echo "<pre>";print_r($_POST);die;
			//die;
			$user_data = $this->session->userdata('user_data');
			$applicationId = $_POST['id'];
			//echo $applicationId;die;
			$userId = $user_data['userid'];
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['get_application_number'] = $this->random_num(15);
			}
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
			if (count($imgArray) > 0) {
				$image = $imgArray[0]['name'];
			} else {
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
			//echo $applicationId;die;
			$data['appno'] = $applicationId;
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);

			//$this->load->view('applicant/header');
			$data = $this->load->view('site/scholarsvisaendrosment', $data, TRUE);
			echo $data;
			//$this->load->view('applicant/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'applicant/dashboard');
		}
	}



	public function applicantStatus()
	{
		try {
			//echo "----------------";
			$applicationId = $this->uri->segment(3);
			//echo $applicationId;die;
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($user_data);die;
			$userId = $user_data['userid'];
			$data['applicaitonsStatus'] = $this->common_model->getApplicationStatus($userId);
			//echo "<pre>";print_r($data['applicaitonsStatus']);die;
			$data['mappingData'] = $this->common_model->getMappingData($applicationId);
			$data['travel'] = $this->common_model->getTravelData($applicationId);
			//echo "<pre>";print_r($travel);die;
			$this->load->view('site/header');
			$this->load->view('site/applicantStatus', $data);
			$this->load->view('site/footer');
		} catch (Exception $e) {
		}
	}

	// vipin first University Popup



	public function selectedUniversityData()
	{

		$university_id = $_POST['uni_id'];
		$universityData = $this->common_model->getUniversityStateById($university_id);

		$courseArray = explode('|', $universityData[0]['course_link']);
		$countArray = count($courseArray);
		//echo "<pre>";print_r($countArray);
		//echo "<pre>";print_r($countArray);die;
		if (!empty($universityData) && $countArray > 0 && $countArray != 2 && $countArray != 3) {
			foreach ($universityData as $resutlt) {
				$response = "<table class='table table-bordered'>";
				$response .= "<tr>";
				$response .= "<td><p align ='center'>" . $resutlt['name'] . '<p align ="center"><a href = "' . $resutlt['link'] . '" target = "_blank">View Website</a>' . "</td>";
				$response .= "<td><p align ='center'>" . $resutlt['name'] . '<p align ="center"><a href = "' . $resutlt['course_link'] . '" target = "_blank">View Courses</a>' . "</td>";
				$response .= "</tr>";
			}

			$response .= "</table>";
			if ($university_id == 333) {
				$response .= "<tr>";
				$response .= "<td><p align ='center'>" . $resutlt['name'] . '<p align ="center">TOFEL Score(minimum 60) os IELTS Score(minimum 6) is essential' . "</td>";
				$response .= "</tr>";
			}
			echo $response;
		} else if (!empty($universityData) && $countArray > 1) {

			foreach ($universityData as $resutlt) {
				//echo "-------------------------";die;
				$response = "<table class='table table-bordered'>";
				$response .= "<tr>";
				$response .= "<td><p align ='center'>" . $resutlt['name'] . '<p align ="center"><a href = "' . $resutlt['link'] . '" target = "_blank">View Website</a>' . "</td>";
				$response .= "<td><p align ='center'>" . $resutlt['namae'] . '<p align ="center"><a href = "' . $courseArray[0] . '" target = "_blank">1. View Courses</a>';
				$response .= '<p align ="center"><a href = "' . $courseArray[1] . '" target = "_blank">2. View Courses</a>';
				$response .= "<p align ='center'>" . $resutlt['nsame'] . '<p align ="center"><a href = "' . $courseArray[2] . '" target = "_blank">3. View Courses</a>' . "</td>";
				$response .= "</tr>";
			}

			$response .= "</table>";
			if ($university_id == 333) {
				$response .= "<tr>";
				$response .= "<td><p align ='center'>" . $resutlt['name'] . '<p align ="center">TOFEL Score(minimum 60) os IELTS Score(minimum 6) is essential' . "</td>";
				$response .= "</tr>";
			}
			echo $response;
		} else {
			'No Data Found!';
		}
		exit;
	}

	//Applicant Remarks 

	function editApplicantRemarks()
	{

		//echo '<pre>';
		//print_r($_POST);die;
		$appId = $_POST['id'];
		//echo $appId;die;
		$applicanteDetails = $this->common_model->getApplicantDetails($appId);
		//echo '<pre>';
		//print_r($applicanteDetails);die;
		$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicanteDetails[0]['application_no']);
		//echo '<pre>';
		//print_r($applicaitonStepOne);die;
?>
		<table class="table table-bordered">
			<thead>
				<th>Name</th>
				<th>Application No</th>
				<th>Email</th>
				<!-----<th>Level of Programme</th>
		<th>University</th>---->
			</thead>
			<tbody>
				<?php
				if (count($applicaitonStepOne) > 0) {
					foreach ($applicaitonStepOne as $app) {
				?>
						<tr>
							<td><?php echo $app['fullname']; ?></td>
							<td><?php echo $app['application_no']; ?></td>
							<td><?php echo $app['email']; ?></td>
							<!-----<td><?php
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
							echo '1) ' . $uni1[0]['name'] . '<br/>';
							echo '2) ' . $uni2[0]['name'] . '<br/>';
							echo '3) ' . $uni3[0]['name'] . '<br/>';
							?>
					</td>----->

							<table class="table table-bordered">
								<thead>
									<th>Remarks By University</th>
									<th>University Remarks Date</th>
									<th>Remarks By Applicant</th>
									<th>Applicant Remarks Date</th>
								</thead>
								<tbody>
									<?php
									if (count($applicanteDetails) > 0) {
									?>
										<tr>
											<td>

												<?php
												if (!empty($applicanteDetails[0]['university_remarks'])) {
													echo $applicanteDetails[0]['university_remarks'];
												} else {
													echo 'NA';
												}

												?>

											</td>
											<td>
												<?php
												if (!empty($applicanteDetails[0]['update_university_remarks'])) {
													$unDate = $applicanteDetails[0]['update_university_remarks'];
													echo date('Y-m-d', $unDate);
												} else {
													echo 'NA';
												}

												?></td>
											<td><?php
												if (!empty($applicanteDetails[0]['student_remarks'])) {
													echo $applicanteDetails[0]['student_remarks'];
												} else {
													echo 'NA';
												}
												?>
											</td>
											<td><?php
												$applicantDate = $applicanteDetails[0]['update_student_remarks'];
												if (!empty($applicantDate)) {
													echo date('Y-m-d', $applicantDate);
												} else {
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
			</tbody>
		</table>
<?php

		$htm  = "<form action='" . site_url() . 'applicant/saveApplicantRemarksData/' . $appId . "' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
		$htm .= "<input type='hidden' name='" . $this->security->get_csrf_token_name() . "' value='" . $this->security->get_csrf_hash() . "'>";
		$htm .= "<input type = 'hidden' name = 'appId' value = '" . $applicanteDetails[0]['application_no'] . "'>";
		$htm .= "<div class='form-row'>";
		$htm .= "<div class='form-group'>";
		$htm .= "<label>Enter Remarks:</label>";
		$htm .= "<textarea class='form-control rounded-0' id='exampleFormControlTextarea2' id ='student_remarks' name='student_remarks' required rows='3'>";
		$htm .= "</textarea>";
		$htm .= "</div>";
		$htm .= "<div class='form-group'>";
		$htm .= "<div>";
		$htm .= "<input type='submit' class='btn btn-primary' value='Submit'/>";
		$htm .= "</div>";
		$htm .= "</div>";
		$htm .= "</form>";
		echo $htm;
		exit;



		//}


	}

	public function saveApplicantRemarksData()
	{

		try {
			$user_data = $this->session->userdata('user_data');
			$postData = $this->input->post(NULL, TRUE);
			 $cleanDatas = $this->security->xss_clean($postData);
			  $cleanData =  $this->strip_quotes($cleanDatas);
			
			
			//$cleanData = $this->security->xss_clean($postData);
			$appid = $cleanData['appId'];
			$userId = $user_data['userid'];
			//echo $appid;die;
			$checkStatus = $this->common_model->checkStatus($appid);
			if (!$checkStatus) {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You are Not Authorise this.');
				redirect('applicant/applicantStatus/' . $appid);
				return false;
			}
			$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($appid);
			//echo "<pre>";print_r($applicaitonStepOne);die;
			$getMissionData = $this->common_model->getMissionData($appid, $userId);
			if (!empty($_POST)) {
				$data = array(
					'student_remarks' => $cleanData['student_remarks'],
					'update_student_remarks' => time()
				);
				//echo "<pre>";print_r($data);die;
				$result = $this->common_model->updateRemarks($data, $appid);

				$email_to = array(
					$applicaitonStepOne[0]['email'],
					$missionEmail = $getMissionData[0]['mission_email'],
					//$roDetails[0]['email']

				);
				$messages = '';
				$body	= '';
				$messages .= '<strong>Hi ' . $applicaitonStepOne[0]['fullname'] . ',</strong><br><br>';
				$messages .= $data['student_remarks'];
				//$body = "Your application for scholarship could not be processed for the following reasons.<br/><br/>";
				$body .= $messages;
				//$body .= "<br/><br/>You are being given opportunity to resubmit your applicatin with the mission documents before ".$this->config->item('Mission_Applicant_Pending_Date');					
				$mailsend = true; //$this->sendMail($body,$email_to,"Indian Council for Cultural Relations.","mail_not_process");
				//var_dump($result);die;
				if ($result) {
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details Saved!');
					redirect(site_url() . 'applicant/dashboard');
				} else {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url() . 'applicant/applicantStatus/' . $appid);
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url() . 'applicant/dashboard');
		}
	}

	function createTravelPlan()
	{
		try { 
			$applicationId = $_POST['id'];
			//$applicationId = $this->uri->segment(3);
			//echo $applicationId;die;			
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['get_application_number'] = $this->random_num(15);
			}
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
			if (count($imgArray) > 0) {
				$image = $imgArray[0]['name'];
			} else {
				$image = '';
			}
			$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
			$data['userImage'] = $image;
			$data['missions'] = $this->common_model->getAllMissions();
			$data['univercities'] = $this->common_model->getUnivercities();
			$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			$data['registerData'] = $this->common_model->getUserData($userId);
			//echo "<pre>";print_r($data['registerData']);die;
			$data['mappingData'] = $this->common_model->getMappingData($applicationId);
			$data['appno'] = $applicationId;
			$data['travel'] = $this->common_model->getTravelData($applicationId);
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			//$this->load->view('site/header');
			$data = $this->load->view('site/createtravelplan', $data, TRUE);
			echo $data;
			//$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url() . 'applicant/dashboard');
		}
	}
	function travelpaln()
	{
		try {
			$imgname = "";
			$files = $_FILES['travel_plan_doc'];
			$applicationId = $this->uri->segment(3);
			if ($files["name"] != "") {
				$name = str_replace(" ", "_", $files['name']);
				$imgname = time() . '_TravelPlan_' . $name;

				$target_file = 'assets/site/main/travelplan/' . $imgname;
				if (move_uploaded_file($_FILES["travel_plan_doc"]["tmp_name"], $target_file)) {
					$data = array(
						'travel_plan_doc' => $imgname,
						'departure_date' => $this->input->post('departure_date'),
						'flight_no' => $this->input->post('flight_no'),
						'time_of_departure' => $this->input->post('time_of_departure'),
						'departure_city' => $this->input->post('departure_city'),
						'time_of_arrival' => $this->input->post('time_of_arrival'),
						'airport_reseption' => $this->input->post('airport_reseption'),
						'travel_arrival_date' => $this->input->post('travel_arrival_date'),
						'flight_no_old' => $this->input->post('flight_no_old'),
						'final_city_arrival' => $this->input->post('final_city_arrival'),
						'city_other' => $this->input->post('city_other'),
						'regional_office_contacted' => $this->input->post('regional_office_contacted'),
						'cost_of_ticket' => $this->input->post('cost_of_ticket'),
						'created' => time(),
						'application_id' => $applicationId,
						'status' => 13
					);
					//echo "<pre>";print_r($data);die;
					$sts = $this->common_model->insertTravelPlan($data);
					if ($sts > 0) {
						$data = array(
							'status' => 13
						);
						$sts = $this->common_model->scholarArrived($applicationId, $data);
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Travel Plan Uploaded!');
						redirect(site_url() . 'applicant/applicantStatus/' . $applicationId);
					}
				} else {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
					redirect(site_url() . 'applicant/applicantStatus/' . $applicationId);
				}
			}else {
					$data = array(
						
						'departure_date' => $this->input->post('departure_date'),
						'flight_no' => $this->input->post('flight_no'),
						'time_of_departure' => $this->input->post('time_of_departure'),
						'departure_city' => $this->input->post('departure_city'),
						'time_of_arrival' => $this->input->post('time_of_arrival'),
						'airport_reseption' => $this->input->post('airport_reseption'),
						'travel_arrival_date' => $this->input->post('travel_arrival_date'),
						'flight_no_old' => $this->input->post('flight_no_old'),
						'final_city_arrival' => $this->input->post('final_city_arrival'),
						'city_other' => $this->input->post('city_other'),
						'regional_office_contacted' => $this->input->post('regional_office_contacted'),
						'cost_of_ticket' => $this->input->post('cost_of_ticket'),
						'created' => time(),
						'application_id' => $applicationId,
						'status' => 13
					);
					//echo "<pre>";print_r($data);die;
					$sts = $this->common_model->insertTravelPlan($data);
					if ($sts > 0) {
						$data = array(
							'status' => 13
						);
						$sts = $this->common_model->scholarArrived($applicationId, $data);
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Travel Plan Uploaded!');
						redirect(site_url() . 'applicant/applicantStatus/' . $applicationId);
					}
				}
		} catch (Exception $e) {
			echo json_encode(array('status' => FALSE));
		}
	}
	function processConfirmedappfromhqrsSfs()
	{
		try {
			//echo "";die;
			$applicationId = $_POST['id'];
			//echo $applicationId;die;
			//$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');

			$userId = $user_data['userid'];
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['get_application_number'] = $this->random_num(15);
			}
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
			if (count($imgArray) > 0) {
				$image = $imgArray[0]['name'];
			} else {
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
			$data['id'] =  $applicationId;

			//$this->load->view('site/header');
			$data = $this->load->view('site/processConfirmedappfromhqrsSfs', $data, TRUE);
			echo $data;
			//$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'site/dashboard');
		}
	}
	function processConfirmedappfromhqrsAyush()
	{
		try {
			//echo "";die;
			$applicationId = $_POST['id'];
			//echo $applicationId;die;
			//$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');

			$userId = $user_data['userid'];
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['get_application_number'] = $this->random_num(15);
			}
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
			if (count($imgArray) > 0) {
				$image = $imgArray[0]['name'];
			} else {
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
			$data['id'] =  $applicationId;

			//$this->load->view('site/header');
			$data = $this->load->view('site/processConfirmedappfromhqrsAyush', $data, TRUE);
			echo $data;
			//$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'site/dashboard');
		}
	}
	function processConfirmedappfromhqrs()
	{
		try {
			//echo "";die;
			$applicationId = $_POST['id'];
			//echo $applicationId;die;
			//$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');

			$userId = $user_data['userid'];
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			if (count($data['applicaitonStepOne']) > 0) {
				$data['get_application_number'] = $data['applicaitonStepOne'][0]['application_no'];
			} else {
				$data['get_application_number'] = $this->random_num(15);
			}
			$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);
			if (count($imgArray) > 0) {
				$image = $imgArray[0]['name'];
			} else {
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
			$data['id'] =  $applicationId;

			//$this->load->view('site/header');
			$data = $this->load->view('site/processConfirmedappfromhqrs', $data, TRUE);
			echo $data;
			//$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'site/dashboard');
		}
	}


	function visaendrosment()
	{
		try {

			$user_data = $this->session->userdata('user_data');
			$data['visaendrosment'] = $this->common_model->getAcceptedCandidates($this->ids);
			//$this->load->view('site/header');
			$data = $this->load->view('site/visaendrosment', $data, TRUE);
			echo $data;
			//$this->load->view('site/footer');
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'site/dashboard');
		}
	}

	function testpdf()
	{
		error_reporting(E_ALL);
		ini_set('display_errors','1');
        $html = 'testing pdf testing pdf';

	}


	function confirmationReceivedWithFormat()
	{

		try {
			$doc = array();
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];

			$applicationId = $this->common_model->getApplicationAppnoByUserId($userId);
			//echo "<pre>";print_r($applicationId);die;
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId[0]['application_no']);
			//echo "<pre>";print_r($stepOne);die;
			$applicationId =  $applicationId[0]['application_no'];

			$uniid = $this->uri->segment(4);
			if ($stepOne[0]['course_type'] == 2) {
				$response = $this->common_model->isAyurvedaApplication($applicationId);
			} else {
				$response = $this->common_model->getconfirmationDataByMission($applicationId);
			}
			//$response = $this->common_model->getconfirmationDataByMission($applicationId);
			//echo "<pre>";print_r($response);die;
			if (count($response) > 1) {
				$uni1 = $this->common_model->getUniversityById($response[1]['regional_university']);
				$course = $response[1]['final_course'];
			} else {
				$uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
				$course = $response[0]['final_course'];
			}
			if ($stepOne[0]['course_type'] == 2) {
				$course = $response[0]['final_course'];
			} else {
				$course = $response[0]['final_course'];
			}

			$current = date('d-m-Y');
			$fy = $this->getFinancialYears($current, 1);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$nomenid = $response[0]['nomenclature'];
			$nomclature = $this->common_model->getnomenclatureByid($nomenid);
			$nomenclature=$nomclature[0]['title'];
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);

			$studentOther = $this->common_model->getStudentOtherDetails($applicationId);
			$missionDetails = $this->common_model->getMissionDetails($applicationId);
			//echo "<pre>";print_r($missionDetails);die;
			$missionPersonName = $missionDetails[0]['mission_person_name'];

			$missionDate = $missionDetails[0]['mission_status_date'];

			$missionAyushDate = $missionDetails[0]['iccr_status_updtae_date'];

			$imgPath = site_url() . 'assets/site/main/mission_signature/' . $missionDetails[0]['mission_person_signature'];

			$new = '<img src="' . $imgPath . '" style="width:200px;">';

			$image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$logo = '<img src="' . $image . '" style="width:auto;">';


			$mission = $this->common_model->getMissionInfo($studentOther[0]['application_through']);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			///$regionInfo = $this->common_model->getRegionById($region);
			$regionInfo = [];
			$uninmae = $this->common_model->getUniversityStateById($uniid);
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
		/* body{margin:0px;}
		.pdf_div{width:80%; margin:auto; border:3px solid #f3f3f3; padding:10px 25px 0 25px; font-size:15px;}
		@media print{
			.pdf_div{width:100%; margin:auto;  padding:0px; font-size:15px; padding:10px 15; border:0px;}

		} */
    </style>

       <body>
		<div class="pdf_div" style="font-size: 13px;">
        <p style="text-align: right;"><small>Ref. No. <?php echo $applicationId; ?> <br/>Date: <?php echo $missionDate; ?> </small></p>
		<div style="text-align: center;"><?php echo $logo;?></div>
        <h3 style="text-align: center;">Indian Council For Cultural Relations (ICCR)</h3>
		<h2 style="color: #d8d5d5;opacity: 0.3;font-family: arial;font-size: 36px;margin: -20px;transform(rotate(45deg));transform-origin(0 0);transform: rotate(328deg);position: relative;top: 300px;text-align: center;">Indian Council For Cultural Relations</h2>
        <p style="text-align: right;"><?php echo  $mission[0]['mission_type'] . ': ' . $mission[0]['mission_name'].',<br>'.$mission[0]['country_name']; ?></p>
        <p><b>Subject:-</b> Offer of Provisional admission with award of ICCR Scholarship for A.Y 2026-27</p>
        <p>Dear: Mr./Ms./Mrs. <?php echo  $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname']; ?></p>
		<p style="text-align: justify;">1)  We are pleased to inform you that you have been provisionally selected to pursue Nomenclature "<?php echo $nomenclature . '" at under ' . $uninmae[0]['name'] . ' ' . $schemename[0]['scheme_name'] . ' for the Academic Year 2026-2027. You are requested to report ' . $regionInfo[0]['name'] . ' University physically along with all original certificate and testimonials latest by '   . $response[0]['date_of_joining'] . ' and also to Regional Office through Email.'; ?></p>
        <p style="text-align: justify;">2)  Hostel accommodation will be provided to you subject to its availability by University authorities. You are required to report at the nearest “Foreign Regional Registration Office” within fourteen days of arrival in India.</p>
        <p style="text-align: justify;">3)  You are advised to contact the Education Wing of this Mission immediately along with your passport for grant of visa and finalization of your date of departure. You are also hereby directed to obtain your final departure letter from the Mission before joining the concerned Institution in India failing which this offer letter stands cancelled. Furthermore no request of change of course and University will be entertained.</p>
        <p style="text-align: justify;">4)  Scholarship expenses will be managed into two parts, which are as follows:-</p>
        <p style="text-align: justify;">(A)	Hostel dues:- On arrival, all these expenses are to be managed by the scholar.</p>

	    <p>i) Hostel fee, Mess fee, Electricity charges, Caution money and Application fee </br>ii) Health insurance </br>iii) FRRO registration fee/late fee</p>

        <p style="text-align: justify;">(B)	Stipend/OCF/other dues – After completion of procedural formalities (dues can be released by ICCR but it takes minimum two months time to complete the process).</p>

        <p>i) Stipend, HRA, ACA and thesis charges (to be paid directly to scholar) </br>ii) Tuition Fee/OCF (to be paid to university/institute on receipt of demand) </br>iii) Air-Tickets (as per admissibility)</p>

        <p style="text-align: justify;">5)  You are also advised to carry with you joining report form and a Minimum of INR 50,000/- equivalent to $700 to meet incidental expenses on arrival in India. There could also be some miscellaneous expanses, so please carry some extra amount to meet the same.</p>
        <p style="text-align: justify;">6)  Please complete all pre-departure formalities such as preparation of passport  and getting the student/research visa.</p>
        <p style="text-align: justify;">7)  Please carry original documents for confirming the provisional admission at the time of reporting at University. Please note that admission is granted provisionally and needs to be confirmed on the basis of submission of original documents at the time of first reporting at the University. In case of discrepancies in documentation, University reserves the right to cancel provisional admission offered to student. ICCR/Mission will not be responsible for cancellation of provisional admission on the above grounds and will not be liable to pay scholarship or expenses  incurred on return air-tickets by the student.</p>
        <!--<p><b>NOTE:-</b> Due to ongoing Covid-19 Pandemic, students will take up online classes and once the situation is better students will be invited to India as and when University allows to report and join physical classes. For any update, please be in touch with University and Mission.</p>-->
		<!-- </br> -->
		<p style="text-align: right;"><?php echo $new;?></p>
		<p style="text-align: right;">Yours Sincerely <br><?php echo $missionPersonName; ?></p>
		
	</div>
    </body>
</html>     
<?php	


die;

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


// $this->load->library('GenPdf');
// $dompdf = new GenPdf();
// $dompdf->loadHtml($html);
// $dompdf->setPaper('A4', 'landscape');
// $dompdf->render();
// $dompdf->stream("welcome.pdf", array("Attachment"=>0));

	}


	public function viewOfferLetter()
	{
		$doc = array();
			$user_data = $this->session->userdata('user_data');
			
			$userId = $user_data['userid'];

			$applicationId = $this->common_model->getApplicationAppnoByUserId($userId);
			//echo "<pre>";print_r($applicationId);die;
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId[0]['application_no']);
			//echo "<pre>";print_r($stepOne);die;
			$applicationId=  $applicationId[0]['application_no'];
//echo "<pre>";print_r($data['data']);die;
			$uniid = $this->uri->segment(4);
			if ($stepOne[0]['course_type'] == 2) {
				$response = $this->common_model->isAyurvedaApplication($applicationId);
			} else {
				$response = $this->common_model->getconfirmationDataByMission($applicationId);
			}
			//$response = $this->common_model->getconfirmationDataByMission($applicationId);
			//echo "<pre>";print_r($response);die;
			if (count($response) > 1) {
				$uni1 = $this->common_model->getUniversityById($response[1]['regional_university']);
				$course = $response[1]['subject'];
			} else {
				$uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
				$course = $response[0]['subject'];
			}
			if ($stepOne[0]['course_type'] == 2) {
				$course = $response[0]['subject'];
			} else {
				$course = $response[0]['subject'];
			}

			//echo "<pre>";print_r($response);die;


			$current = date('d-m-Y');
			$fy = $this->getFinancialYears($current, 1);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);

			$studentOther = $this->common_model->getStudentOtherDetails($applicationId);
			$missionDetails = $this->common_model->getMissionDetails($applicationId);
			//echo "<pre>";print_r($missionDetails);die;
			$missionPersonName = $missionDetails[0]['mission_person_name'];

			$missionDate = $missionDetails[0]['mission_status_date'];

			$missionAyushDate = $missionDetails[0]['iccr_status_updtae_date'];

			$imgPath = site_url() . 'assets/site/main/mission_signature/' . $missionDetails[0]['mission_person_signature'];

			$new = '<img src="' . $imgPath . '" style="width:100px;">';

			$image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$new = '<img src="' . $image . '" style="width:100px;">';


			$mission = $this->common_model->getMissionInfo($studentOther[0]['application_through']);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId['schemeId'] = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			///$regionInfo = $this->common_model->getRegionById($region);
			$regionInfo = [];
			$uninmae = $this->common_model->getUniversityStateById($uniid);
		//$userId = 3427;
		
			//echo "<pre>";print_r($schemeId);die;
			$this->load->view('site/header');
			$this->load->view('site/applicantofferletter',$schemeId );
			$this->load->view('site/footer');
	}


	public function downloadAdmitCard()
{

	//$appno = $this->uri->segment(3);
	 $mpdf = new Mpdf('s','A4','','',7,7,05,10,10,10);
	$mpdf->SetFont('Arial','B',9);
	 $mpdf->SetWatermarkText('NATIONAL SPORTS UNIVERSITY');
	 $mpdf->showWatermarkText = true;
	 $html1 = "<div style='text-align:center;'></div><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:15px;font-weight:normal;'>STUDENT ADMIT CARD</h3><br/>"; 
	//$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>".date("jS F Y h:i:s")."</div>";
	$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>".date('jS F Y').'-'.date('y', strtotime('+1 year')).date('h:i:s')."</div>";
	$html2 = $this->input->post("myHTML");
	echo $html2; die;
	$mpdf->WriteHTML($html2);
	$mpdf->SetFontSize(10, TRUE);
	 $mpdf->SetDisplayMode('fullpage');
	$mpdf->list_indent_first_level = 0;
	$stylesheetpath = base_url()."assets/site/main/css/tablepdf.css";
	$stylesheet = file_get_contents($stylesheetpath);
	 $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
	$stylesheet1 = file_get_contents(base_url().'assets/site/main/css/font-awesome.min.css');
	 $mpdf->WriteHTML($stylesheet1,1); // The parameter 1 tells that this is css/style only and no body/html/text
	$stylesheet2 = file_get_contents(base_url().'assets/site/main/css/AdminLTE.min.css'); 
	$mpdf->WriteHTML($stylesheet2,1); // The parameter 1 tells that this is css/style only and no body/html/text
	$stylesheet3 = file_get_contents(base_url().'assets/site/main/css/mea-portal.css');
	$mpdf->WriteHTML($stylesheet3,1); // The parameter 1 tells that this is css/style only and no body/html/text
	$stylesheet4 = file_get_contents(base_url().'assets/site/main/css/jquery-ui.css');
 	$mpdf->WriteHTML($stylesheet4,1); // The parameter 1 tells that this is css/style only and no body/html/text

	$stylesheet5 = file_get_contents(base_url().'assets/site/main/css/mea-portal-custom-pdf-view.css');
	$mpdf->WriteHTML($stylesheet5,1); // The parameter 1 tells that this is css/style only and no body/html/text
		$stylesheet6 = file_get_contents(base_url().'assets/site/main/css/bootstrap_custom.css'); 	

	$mpdf->WriteHTML($stylesheet6,1); // The parameter 1 tells that this is css/style only and no body/html/text
	$mpdf->SetFontSize(7, TRUE);
	$mpdf->WriteHTML($html1, 2);
	$mpdf->SetFontSize(8, TRUE);
	$mpdf->WriteHTML($html2, 2);
	?>

	<html>
<h1>Hello</h1> 

	</html>
	<?php
 //$stylesheet6 = file_get_contents('assets/site/main/css/iccsrprint.css');
//$mpdf->WriteHTML($stylesheet6,1); // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->SetProtection(array(), '123');
//$mpdf->Output('yourFileName.pdf', 'D');
header("Content-type: application/pdf");
$mpdf->Output('nsuAdmitCard'.time().'.pdf', 'I');
	}




	function visaapply()
	{
		try {
			$applicationId = $_POST['app_id'];
			//echo $applicationId;die;
			$arrival_date = $this->input->post('arrival_date') . "-" . $this->input->post('arrival_month') . '-' . $this->input->post('arrival_year');
			$duration_from = $this->input->post('visa_from_date');
			$duration_to = $this->input->post('duration_to_date');
			$duration_issue_date = $this->input->post('visa_issue_date');
			$visa_issueplace= $this->input->post('visa_issueplace');
			$visa_approved= $this->input->post('visa_approved');
			$data['non_xss'] = array(
				'arrival_date' => "",
				'visa_from_date' => $duration_from,
				'visa_to_date' => $duration_to,
				'visa_isuue_date' => $duration_issue_date,
				'visa_issueplace' => $visa_issueplace,
				'visa_approved' => $visa_approved,
				'visa_no' => $this->input->post('visa_no'),
				'status' => 13
			);
			//echo "<pre>";print_r($data['non_xss']);die;
			$data['xss_data'] = $this->security->xss_clean($data['non_xss']);
			$status = $this->common_model->updateVisaInfo($data['xss_data'], $applicationId);
			if ($status) {
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'VISA Endorsed Successfully!');
				redirect(site_url() . 'applicant/applicantStatus/' . $applicationId);
			} else {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
				redirect(site_url() . 'applicant/applicantStatus/' . $applicationId);
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url() . 'applicant/dashboard');
		}
	}

	public function applicant_personal_info_preview()
	{

		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		//$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyUserId($userId);/
		//$this->load->view('site/header');
		$this->load->view('site/header', array('include' => 'applicant_personal_info_preview'));
		$data = $this->load->view('site/full_application', $data, TRUE);
		echo $data;
		//$this->load->view('site/footer');
	}



	public function applicant_education_info_preview()
	{
		//echo "<pre>";print_r($_POST);die;
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		//$this->load->view('site/header');
		$this->load->view('site/header', array('include' => 'applicant_education_info_preview'));
		$data = $this->load->view('site/full_application', $data, TRUE);
		echo $data;
		//$this->load->view('site/footer');
	}

	public function applicant_other_info_preview()
	{
		//echo "<pre>";print_r($_POST);die;
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		//$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyUserId($userId);
		//$this->load->view('site/header');
		$this->load->view('site/header', array('include' => 'applicant_other_info_preview'));
		$data = $this->load->view('site/full_application', $data, TRUE);
		echo $data;
		//$this->load->view('site/footer');
	}


	public function applicant_documents_info_preview()
	{
		//echo "<pre>";print_r($_POST);die;
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];
		$data['registerData'] = $this->common_model->getUserData($userId);
		$imgArray = $this->common_model->getUserImage($userId);
		if (count($imgArray) > 0) {
			$data['userImage'] = $imgArray[0]['name'];
		} else {
			$data['userImage'] = '';
		}
		$data['registerData'] = $this->common_model->getUserData($userId);
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
		//echo "<pre>";print_r($data['applicaitonStepOne']);die;
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThree($userId);
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwo($userId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocuments($userId);
		$data['applicaitonSubmitData'] = $this->common_model->getApplicationSubmitDatabyUserId($userId);
		//$this->load->view('site/header');
		$this->load->view('site/header', array('include' => 'applicant_documents_info_preview'));
		$data = $this->load->view('site/full_application', $data, TRUE);
		echo $data;
		//$this->load->view('site/footer');
	}

	public function downloadDocs()
	{
		//echo base64_decode($this->uri->segment(3));die;
		$file_name = base64url_decode($this->uri->segment(3));
		fileForceDownload($file_name);
	}

	function getDuration()
	{
		$courseId = $this->input->post('course_id');
		$duration = $this->db->get_where('iccr_programme_duration', array('prog_id' => $courseId))->result_array();
		$option = "<option value=''>Select Duration</option>";
		foreach ($duration as $dur) {
			$option .= "<option value='" . $dur['duration'] . "'>" . $dur['duration'] . "</option>";
		}
		echo $option;
	}
	function getDurationCourse()
	{
		$courseId = $_GET['courseId'];
		$duration = $this->db->order_by('subject', 'asc');
		$duration = $this->db->get_where('iccr_subjects', array('sub_stream' => $courseId))->result_array();
		$option = "<option value=''>Select Subject</option>";
		foreach ($duration as $dur) {
			$option .= "<option value='" . $dur['subject'] . "'>" . $dur['subject'] . "</option>";
		}
		echo $option;
	}

	public function __destruct()
	{
		$this->db->close();
	}
}

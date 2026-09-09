<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Regional extends CI_Controller {

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
	  public $ip;
    	public $refs;
    	public $uris;
    	public $agents;
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');	
        $this->load->library('encryption');      
        $this->load->helper('date');   
        $this->load->model('user_model');        
        $this->load->model('common_model');   
		$this->load->model('Regional_model'); 
        $this->load->library('excel');      
        $this->load->library('mpdf60/Mpdf');
        $this->load->library('zip');
        $this->load->library('mpdf60/Mpdf');  
        $userdata =$this->session->userdata('user_data');
       // $this->saveVisitor();
			
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
				case "Student":
				redirect(site_url() . 'applicant/dashboard');
				break;
				case "Super Admin":
				redirect(site_url() . 'admin/dashboard');
				break;
			}
		}    
    } 
    function saveVisitor()
    {
    	 $this->ip = $_SERVER['REMOTE_ADDR'];
    	if (isset($_SERVER['HTTP_REFERER'])) 
		{
			$this->refs = $_SERVER['HTTP_REFERER'];
		}
	    $this->uris = $_SERVER['REQUEST_URI'];
	    $this->agents = $_SERVER['HTTP_USER_AGENT'];
		$data = array(
			'VisIP'=>$this->ip,
			'VisRef'=>$this->refs,
			'VisUrl'=>$this->uris,
			'VisDate'=>time(),
			'VisAgent'=>$this->agents
		);
		$this->common_model->insertCounter($data);		
	}
	public function index()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);	
			$data['newApplication'] = $this->common_model->getRegionalApplications($regionid);	
			$data['forwardedtohqrs'] = $this->common_model->getRegionalApplicationsForwardtoHqrs($regionid);	
			$data['travel'] = count($this->common_model->getRegionalTravelApplication($regionid));
			$data['arrived'] = count($this->common_model->getRegionalReceivedApplication($regionid));		
			
			$data['travel_stipend'] = count($this->common_model->getRegionalTravelApplication($regionid));		
			$data['demands'] = count($this->common_model->getDemands($regionid));
			$data['processeddemands'] = count($this->common_model->getProcessedDemands($regionid));
			$this->load->view('regional/header_regional');
			$this->load->view('regional/dashboard',$data);
			$this->load->view('regional/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');	
		}
	}	
	public function getCourseDetail()
	{
		$postData = $this->input->post(NULL,TRUE);
		$cleanData = $this->security->xss_clean($postData);	
		echo json_encode($this->common_model->getCourseDetails($cleanData['appid'],$cleanData['uniid']));
	}
	public function profile()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];			
			$postData = $this->input->post(NULL,TRUE);
			if(count($postData)>0)
			{
				$cleanData = $this->security->xss_clean($postData);		
				$status = $this->common_model->updateProfileRegion($cleanData);
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
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['userData'] = $user_data;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/profile',$data);
			$this->load->view('regional/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');	
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
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['head'] = $this->session->userdata('user_data');
			$data['userData'] = $user_data;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/changepassword',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');	
		}
	}	
	public function addbalance()
	{
		try
		{	
			$data = array();
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			
			if(!$this->common_model->isAlreadyUpdatedbalance($this->input->post("fy"),$regionid))
			{
				$data['financial_year'] = $this->input->post("fy");
				$data['regional_office'] = $regionid;
				$data['amount'] = $this->input->post("amount");
				$data['created'] = time();
				$sts = $this->common_model->insertOpeningBalance($data);
			  	if($sts)
			  	{
			  		$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Opening Balance Updated!');
					redirect(site_url().'regional/fundmonitoring');						
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Adding Opening Balance!');
					redirect(site_url().'regional/fundmonitoring');				
				}
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Opening Balance Already Updated for this Financial Year!');
				redirect(site_url().'regional/fundmonitoring');					
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Adding Updating Application!');
			redirect(site_url().'regional/fundmonitoring');				
		}
	}
	public function openingbalance()
	{
		try
		{
			$data['fundmonitoring'] = "";
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$current = date('d-m-Y');
			$data['fy'] = $this->getFinancialYears($current,1);
			$data['totalFund'] = $this->common_model->getOpeningBalance($regionid);
			$this->load->view('regional/header_regional');		
			$this->load->view('regional/addopeningbalance',$data);
			$this->load->view('regional/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/openingbalance');				
		}
	}
	public function expenditurereports()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');		
			$regionid = $user_data['state'];
			$current = date('Y-m-d',strtotime('-1 years'));
			$data['fy'] = $this->getFinancialYears($current,4);
			$data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/expenditureReports_Latest',$data);
			$this->load->view('regional/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');				
		}				
	}
	/*public function expenditurereports()
	{
		$data['newApplication'] = $this->common_model->getPendingUnderRegionalApplications($this->ids);
		$this->load->view('regional/header_regional');
		$this->load->view('regional/expenditureReports.php',$data);
		$this->load->view('regional/footer');
	}*/
	function visaendorsment() 
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			
			$data['regionName'] = $this->common_model->getRegionById($regionid);	
			$data['visaendrosment'] = $this->common_model->getRegionalReceivedApplication($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/visaendrosment',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');				
		}
	}
	function visaapply()
	{
		try
		{
			//echo "sadsadas";die;
			//echo "<pre>";
			//print_r($_FILES);die;
			$applicationId = $this->uri->segment(3);
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG");
			$duration_from = $this->input->post('visa_from_date');
			$duration_to = $this->input->post('duration_to_date');		
			$duration_issue_date = $this->input->post('visa_issue_date');
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			
			if(!empty($_FILES))
					{
					$imgname2 = "";
					
						if(!empty($_FILES['signature']['name']))
					{
						$file_name=$_FILES["signature"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['signature']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/scholarsvisaendrosment/'.$applicationId);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'signature'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/scholarsvisaendrosment/'.$applicationId);	
							return false;
							
						}
						elseif($_FILES['signature']["size"] <= 0 || $_FILES['signature']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/scholarsvisaendrosment/'.$applicationId);	
							return false;
						}
						$file_tmp = $_FILES["signature"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['signature']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/visa_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['signature'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/scholarsvisaendrosment/'.$applicationId);	
							return false;
							
						}
						
					}
					
					}
			
			
			$data['non_xss']= array(			
				'visa_from_date' =>$duration_from,
				'visa_to_date'=>$duration_to,
				'visa_isuue_date'=>$duration_issue_date,
				'visa_no'=>$this->input->post('visa_no'),
				'application_no'=>$applicationId,
				'status'=>14,
				'signature'=>$imgname2,
				'created'=>time()								
			);		
			//echo "<pre>";
			//print_r($data['non_xss']);die;
			$data['xss_data'] = $this->security->xss_clean($data['non_xss']);
			$status = $this->common_model->insertRegionalVisaInfo($data['xss_data']);
			//var_dump($status);die;
			if($status)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'VISA Endorsed Successfully!');
				redirect(site_url().'regional/visaendorsment');	
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur while updating VISA Information!');
				redirect(site_url().'regional/visaendorsment');				
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/visaendrosment');				
		}
	}
	function scholarsvisaendrosment()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);	
			$applicationId = $this->uri->segment(3);
			$data['appno'] = $applicationId;
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/scholarsvisaendrosment',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');				
		}
	}
	public function processeddemands()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['demands'] = $this->common_model->getProcessedDemands($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/processeddemands',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');				
		}
	}
	public function demands()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['demands'] = $this->common_model->getDemands($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/demands',$data);
			$this->load->view('regional/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');				
		}
	}
	public function saveDemand()
	{
		try
		{
			$demadArray = array();
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$demandId = $this->uri->segment(3);
			$files = $_FILES['demand_doc'];   
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = $demandId.'_'.time().'_demands_'.$name;		  
			  $target_file = 'assets/site/main/demands/'.$imgname; 
			  if(move_uploaded_file($_FILES["demand_doc"]["tmp_name"], $target_file)) 
			  {			  		
			  	$demadArray['regional_office'] = $regionid;
			  	$demadArray['demand_id'] = $demandId;
			  	$demadArray['remarks'] = $this->input->post('remarks');
			  	$demadArray['financial_year'] = $this->input->post('fy_year');
			  	$demadArray['document'] = $imgname;
			  	$demadArray['created'] = time();
			  	$sts = $this->common_model->saveDemand($demadArray);
			  	if($sts)
			  	{
					$data['message']['type'] = 1;
					$data['message']['text'] = "Demand Created Successfully";
					$data['message']['redirect'] = site_url().'regional/demands/';
					$this->load->view("regional/msg",$data);
				}
				else
				{
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error Occur While Creating Demand";
					$data['message']['redirect'] = site_url().'regional/demands/';
					$this->load->view("regional/msg",$data);
				}
		  	  }
		  	  else
			  {
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error Occur While Creating Demand";
					$data['message']['redirect'] = site_url().'regional/demands/';
					$this->load->view("regional/msg",$data);
			  }
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');				
		}  	  
	}
	public function createDemand()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$current = date('d-m-Y',strtotime('-8 years'));
			$financial = $this->getFinancialYears($current,1);
			$data['fy'] = $financial;
			if($demandId == NULL || $demandId == "")
			{
				$demandId = 'DEMAND'.$this->random_num(6);
			}	
			else
			{
				$demandId = $this->uri->segment(3);
			}
			$data['demandId'] = $demandId;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/createdemand',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');				
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
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');		
	        exit;
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
			$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div><h3 class='caps' style='text-align:center;font-family:verdana;margin-bottom:0;margin-top:15px;font-weight:normal;'>Expenditure Statement of Applicant </h3><br/>";       	 				
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
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');
	        exit;
	    }
	}
	function getCurrentQuarterFundDetails()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$curMonth = date("m", time());
			$curQuarter = ceil($curMonth%3) + 1;		
			$fy = $this->getCurrentFinancialYear();		
			return $this->common_model->getCurrentQuarterFundDetails($regionid,$fy,$curQuarter);
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');
		}
	}
	function fundmonitoring()
	{
		try
		{
			$data['fundmonitoring'] = "";
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$current = date('d-m-Y');
			$data['fy'] = $this->getFinancialYears($current,1);
			$data['totalFundbalance'] = $this->common_model->getOpeningBalance($regionid);
			$data['totalFund'] = $this->common_model->getTotalFundtoRegion($regionid);
			$this->load->view('regional/header_regional');		
			$this->load->view('regional/fundmonitoring',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/dashboard');
		}
		
	}
	function viewExpenditureDetails()
	{
		$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$fy = $this->uri->segment(3);		
		$yearArray = explode('-',$fy);
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
		
		$this->load->view('regional/header_regional');		
		$this->load->view('regional/viewExpenditureDetails',$data);
		$this->load->view('regional/footer');
		
	}
	function studentAcademicCurrent()
	{
		try{
			$data = array();
			$applicationId = $this->uri->segment(3);
			$post = $this->input->post();
			$acaArray = array();
			$otherData = array();
			$files = $_FILES['off_sign'];   
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = time().'_academic_signature_'.$name;
			  
			  $target_file = 'assets/site/main/expenditure_signature/'.$imgname; 
			  if (move_uploaded_file($_FILES["off_sign"]["tmp_name"], $target_file)) 
			  { 	
			  	  $mapdata = $this->common_model->getMappingData($applicationId);
			  	  $applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);
			  	  $uni = $this->common_model->getconfirmationData($applicationId);
 				  $acaArray['fullname'] = $applicaitonStepOne[0]['fullname'];
 				  $acaArray['country'] = $applicaitonStepOne[0]['country'];
 				  $acaArray['programme'] = $applicaitonStepOne[0]['programme'];
 				  $acaArray['course'] = $applicaitonStepOne[0]['course'];
 				  $acaArray['course_duration_from'] = $this->input->post('course_duration_from');
 				  $acaArray['course_duration_to'] = $this->input->post('course_duration_to');
 				  $acaArray['university'] = $uni[0]['regional_university'];
 				  $acaArray['scheme'] = $mapdata[0]['scholarship_id'];
 				  $acaArray['city_id'] = $this->input->post('city_id');
 				  $acaArray['city_other'] = $this->input->post('city_other');
 				  $acaArray['academic_type'] = "New";
 				  $acaArray['application_id'] = $applicationId;
 				  $acaArray['created'] = time();
 				  
				  $main_filter = 1;
				  $student_filter = $this->input->post('student_filter');
				  $uni_filter = $this->input->post('uni_filter');
				 
				  $otherData['application_id'] = $applicationId;					 		  
				  /* Main Table Fields End */
				  $otherData['aca_year'] = $this->input->post('aca_year');	
			  	  $otherData['is_sem'] = $this->input->post('is_sem');	
			  	  if($this->input->post('is_sem') == "1")
			  	  {
						$otherData['sem_no'] = $this->input->post('sem_no');
				  }
				  elseif($this->input->post('is_sem') == "2")
			  	  {
						$otherData['annual_no'] = $this->input->post('annual_no');
				  }
			  	  $otherData['date_from'] = $this->input->post('date_from');	
			  	  $otherData['date_to'] = $this->input->post('date_to');
			  	  $otherData['officer_name'] = $this->input->post('officer_name');
				  $otherData['off_sign'] = $imgname;
				  $otherData['created'] = time();	
				  				
				  switch($main_filter)
				  {
				  	case "1":
				  	case "2":
				  	case "3":				  		
				  		switch($student_filter)
				  		{
							case "1": 
								  $otherData['status'] = 1;		
								  /* Promoted */									  							  
								  if($this->input->post('percentage') != "")
								  {
								    $otherData['promoted_percentage'] = $this->input->post('percentage');
								  }
							break;							
							case "2":
							  /* Detained */			
							 	  $otherData['status'] = 2;									  							  
								  if($this->input->post('reasons') != "")
								  {
								    $otherData['detained_reason'] = $this->input->post('reasons');
								  }	
							break;
							case "3":
									$otherData['status'] = 3;		
								 /* Backlogs */		
								  if($this->input->post('noofbacklogs') != "")
								  {
								    $otherData['backlog_no'] = $this->input->post('noofbacklogs');
								  }								  
							break;	
							case "4":
								$otherData['status'] = 4;		
								/* finally_passed */	
								  if($this->input->post('finally_pass_percentage') != "")
								  {
								    $otherData['finally_passed_percent'] = $this->input->post('finally_pass_percentage');
								  }							  
							break;					
						}
						if($this->input->post('att_per') != "")
					   {
					    $otherData['attendance_percentage'] = $this->input->post('att_per');
					   }
					   if($this->input->post('schlr_sts') != "")
					  {
					  	if($this->input->post('schlr_sts') == 5)
					  	{
							$otherData['remarks_terminated'] = $this->input->post('remarks_terminated');
							$otherData['scholarship_status'] = $this->input->post('schlr_sts');
							$termfiles = $_FILES['term_file'];
							if($termfiles["name"] != "")
							{				
							  $name_term = str_replace(" ","_",$termfiles['name']);
							  $imgnameterm = time().'_academic_terminated_'.$name_term;
							  
							  $target_file_term = 'assets/site/main/terminatedDoc/'.$imgnameterm; 
							  if (move_uploaded_file($_FILES['term_file']["tmp_name"], $target_file_term)) 
							  {
							  	$otherData['term_file'] = $this->input->post('schlr_sts');
							  }
							}  	 
						}
						else
						{
							$otherData['scholarship_status'] = $this->input->post('schlr_sts');
						}
					    
					  }
				  	break;		  	
				}
				if(count($this->common_model->getAcademicData($applicationId))<=0)
				{
					$result_main = $this->common_model->insertAcademicDetails($acaArray);
					if($result_main)
						{
							$data['message']['type'] = 1;
							$data['message']['text'] = "Academic Detail Saved Successfully";
							$data['message']['redirect'] = site_url().'regional/addcurrentAcademicDetails/'.$applicationId;;
							$this->load->view("regional/msg",$data);	
						}
						else
						{
					  		$data['message']['type'] = 2;
							$data['message']['text'] = "Error Occur While Saving Signature.";
							$data['message']['redirect'] = site_url().'regional/addcurrentAcademicDetails/'.$applicationId;
							$this->load->view("regional/msg",$data);
				  		}
				}
				else
				{
					$array = $this->common_model->isStatusExists($otherData,$main_filter,$student_filter);
					if(count($array)<=0 && count($otherData)>0)
					{					
						$isexist = $this->common_model->isRecordExists($otherData,$main_filter,$student_filter);
						if(count($isexist)>0)
						{
							 $result = $this->common_model->updateAcademic($otherData,$main_filter);
						}
						else
						{
							$result = $this->common_model->insertAcademic($otherData);
						}
						if($result)
						{
							$data['message']['type'] = 1;
							$data['message']['text'] = "Academic Detail Saved Successfully";
							$data['message']['redirect'] = site_url().'regional/addcurrentAcademicDetails/'.$applicationId;;
							$this->load->view("regional/msg",$data);	
						}
						else
						{
					  		$data['message']['type'] = 2;
							$data['message']['text'] = "Error Occur While Saving Signature.";
							$data['message']['redirect'] = site_url().'regional/addcurrentAcademicDetails/'.$applicationId;
							$this->load->view("regional/msg",$data);
				  		}
						
					}
					else
					{
						$data['message']['type'] = 2;
						$data['message']['text'] = "Status Already Updated for This Session.";
						$data['message']['redirect'] = site_url().'regional/addcurrentAcademicDetails/'.$applicationId;
						$this->load->view("regional/msg",$data);	
					}	
				}
			  }
			  else{
			  		$data['message']['type'] = 2;
					$data['message']['text'] = "Error Occur While Saving Signaturetg.";
					$data['message']['redirect'] = site_url().'regional/addcurrentAcademicDetails/'.$applicationId;
					$this->load->view("regional/msg",$data);
			  }
			}
			else
			{
				$data['message']['type'] = 2;
				$data['message']['text'] = "Error Occur While Saving Signature12.";
				$data['message']['redirect'] = site_url().'regional/addcurrentAcademicDetails/'.$applicationId;
				$this->load->view("regional/msg",$data);
			}
		}
		catch(Exception $e)
		{
			$data['message']['type'] = 2;
			$data['message']['text'] = "Error Occur While Saving Signaturehhh.";
			$data['message']['redirect'] = site_url().'regional/addcurrentAcademicDetails/'.$applicationId;
			$this->load->view("regional/msg",$data);
		}
	}
	function studentAcademic()
	{
		try{
			$applicationId = $this->uri->segment(3);
			$post = $this->input->post();
			$acaArray = array();$expArray = array();
			$otherData = array();
			$files = $_FILES['off_sign'];   
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = time().'_academic_signature_'.$name;
			  
			  $target_file = 'assets/site/main/expenditure_signature/'.$imgname; 
			  if (move_uploaded_file($_FILES["off_sign"]["tmp_name"], $target_file)) 
			  { 	
			  	  $acaArray['file_no'] = $this->input->post('file_no');	
 				  $acaArray['fullname'] = $this->input->post('fullname');
 				  $acaArray['country'] = $this->input->post('country');
 				  $acaArray['programme'] = $this->input->post('programme1');
 				  $acaArray['course'] = $this->input->post('course1');
				  $acaArray['other_course'] = $this->input->post('other_course');
 				  $acaArray['course_duration_from'] = $this->input->post('course_duration_from');
 				  $acaArray['course_duration_to'] = $this->input->post('course_duration_to');
 				  $acaArray['university'] = $this->input->post('university');
 				  $acaArray['city_id'] = $this->input->post('city_id');
 				  $acaArray['city_other'] = $this->input->post('city_other');
 				  $acaArray['scheme'] = $this->input->post('scheme');
				  $acaArray['institute_name'] = $this->input->post('institute_name');
				  $acaArray['pvt_govt'] = $this->input->post('pvt_govt');
 				  $acaArray['academic_type'] = "OLD";
 				  $acaArray['application_id'] = $applicationId;
 				  $acaArray['created'] = time();
 				  
 				  
 				  /* Add Expenditure Details Array */
 				  $schem = $this->common_model->getSchemeById($this->input->post('scheme'));
 				  	  $expArray['name'] = $this->input->post('fullname');
	 				  $expArray['country'] = $this->input->post('country');
	 				  $expArray['programme'] = $this->input->post('programme1');
	 				  $expArray['course'] = $this->input->post('course1');
	 				  $expArray['duration_from'] = $this->input->post('course_duration_from');
	 				  $expArray['duration_to'] = $this->input->post('course_duration_to');
	 				  $expArray['universty_choice'] = $this->input->post('university');
	 				  $expArray['city_id'] = $this->input->post('city_id');
	 				  $expArray['city_other'] = $this->input->post('city_other');
	 				  $expArray['scheme'] = $this->input->post('scheme');
	 				  $expArray['code'] = $schem[0]['code'];
	 				  $expArray['exp_student_type'] = "OLD";
	 				  $expArray['application_id'] = $applicationId;
	 				  
	 				  /*$expArray['visa_type'] = $applicationId;
	 				  $expArray['visa_from_date'] = $applicationId;
	 				  $expArray['visa_to_date'] = $applicationId;*/
	 				  
	 				  $expArray['created'] = time();
 				  /* End */
 				  
 				  
 				  
				  $main_filter = 1;//$this->input->post('stipend_programme');
				  $student_filter = $this->input->post('student_filter');
				  $uni_filter = $this->input->post('uni_filter');
				 
				  $otherData['application_id'] = $applicationId;					 		  
				  /* Main Table Fields End */
				  $otherData['aca_year'] = $this->input->post('aca_year');	
			  	  $otherData['is_sem'] = $this->input->post('is_sem');	
			  	  if($this->input->post('is_sem') == "1")
			  	  {
						$otherData['sem_no'] = $this->input->post('sem_no');
				  }
				  elseif($this->input->post('is_sem') == "2")
			  	  {
						$otherData['annual_no'] = $this->input->post('annual_no');
				  }
			  	  $otherData['date_from'] = $this->input->post('date_from');	
			  	  $otherData['date_to'] = $this->input->post('date_to');			  	  
			  	  $otherData['officer_name'] = $this->input->post('officer_name');
				  $otherData['off_sign'] = $imgname;
				  $otherData['created'] = time();	
				  switch($main_filter)
				  {
				  	case "1":
				  	case "2":
				  	case "3": 		
				  		switch($student_filter)
				  		{
							case "1": 
								  $otherData['status'] = 1;		
								  /* Promoted */									  							  
								  if($this->input->post('percentage') != "")
								  {
								    $otherData['promoted_percentage'] = $this->input->post('percentage');
								  }
							break;							
							case "2":
							  /* Detained */			
							 	  $otherData['status'] = 2;									  							  
								  if($this->input->post('reasons') != "")
								  {
								    $otherData['detained_reason'] = $this->input->post('reasons');
								  }	
							break;
							case "3":
									$otherData['status'] = 3;		
								 /* Backlogs */		
								  if($this->input->post('noofbacklogs') != "")
								  {
								    $otherData['backlog_no'] = $this->input->post('noofbacklogs');
								  }								  
							break;	
							case "4":
								$otherData['status'] = 4;		
								/* finally_passed */	
								  if($this->input->post('finally_pass_percentage') != "")
								  {
								    $otherData['finally_passed_percent'] = $this->input->post('finally_pass_percentage');
								  }							  
							break;					
						}
					  if($this->input->post('att_per') != "")
					  {
					    $otherData['attendance_percentage'] = $this->input->post('att_per');
					  }
					  if($this->input->post('schlr_sts') != "")
					  {
					  	if($this->input->post('schlr_sts') == 5)
					  	{
							$otherData['remarks_terminated'] = $this->input->post('remarks_terminated');
							$otherData['scholarship_status'] = $this->input->post('schlr_sts');
							$termfiles = $_FILES['term_file'];
							if($termfiles["name"] != "")
							{				
							  $name_term = str_replace(" ","_",$termfiles['name']);
							  $imgnameterm = time().'_academic_terminated_'.$name_term;
							  
							  $target_file_term = 'assets/site/main/terminatedDoc/'.$imgnameterm; 
							  if (move_uploaded_file($_FILES['term_file']["tmp_name"], $target_file_term)) 
							  {
							  	$otherData['term_file'] = $this->input->post('schlr_sts');
							  }
							}  	 
						}
						else
						{
							$otherData['scholarship_status'] = $this->input->post('schlr_sts');
						}
					  }
				  	break;	  	
				}
				if(count($this->common_model->getAcademicData($applicationId))<=0)
				{
					$result_main = $this->common_model->insertAcademicDetails($acaArray);
					$result_main1 = $this->common_model->insertExpenditure($expArray);
					if($result_main)
						{
							$data['message']['type'] = 1;
							$data['message']['text'] = "Academic Detail Saved Successfully";
							$data['message']['redirect'] = site_url().'regional/addAcademicDetails/'.$applicationId;;
							$this->load->view("regional/msg",$data);	
						}
						else
						{
					  		$data['message']['type'] = 2;
							$data['message']['text'] = "Error Occur While Saving Signature.";
							$data['message']['redirect'] = site_url().'regional/addAcademicDetails/'.$applicationId;
							$this->load->view("regional/msg",$data);
				  		}
				}
				else
				{
					$array = $this->common_model->isStatusExists($otherData,$main_filter,$student_filter);
					if(count($array)<=0 && count($otherData)>0)
					{
						$isexist = $this->common_model->isRecordExists($otherData,$main_filter,$student_filter);
						if(count($isexist)>0)
						{	
							 $result = $this->common_model->updateAcademic($otherData);	
						}
						else
						{
							$result = $this->common_model->insertAcademic($otherData);
						}
						
						$data['message']['type'] = 1;
						$data['message']['text'] = "Academic Detail Saved Successfully";
						$data['message']['redirect'] = site_url().'regional/addAcademicDetails/'.$applicationId;;
						$this->load->view("regional/msg",$data);	
					}
					else
					{
						$data['message']['type'] = 2;
						$data['message']['text'] = "Status Already Updated for This Session.";
						$data['message']['redirect'] = site_url().'regional/addAcademicDetails/'.$applicationId;
						$this->load->view("regional/msg",$data);	
					}
				}
				
			  }
			  else{
					$data['message']['type'] = 2;
					$data['message']['text'] = "Error Occur While Saving Signature.";
					$data['message']['redirect'] = site_url().'regional/addAcademicDetails/'.$applicationId;
					$this->load->view("regional/msg",$data);
			  }
			}
			else
			{
				$data['message']['type'] = 2;
				$data['message']['text'] = "Error Occur While Saving Signature.";
				$data['message']['redirect'] = site_url().'regional/addAcademicDetails/'.$applicationId;
				$this->load->view("regional/msg",$data);
			}
		}
		catch(Exception $e)
		{
			$data['message']['type'] = 2;
			$data['message']['text'] = "Error Occur While Saving Signature.";
			$data['message']['redirect'] = site_url().'regional/addAcademicDetails/'.$applicationId;
			$this->load->view("regional/msg",$data);
		}
	}
	function oldstudentExpenditure()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$applicationId = $this->uri->segment(3);
			$post = $this->input->post();
			$expenditureArray = array();
			$otherData = array();
			$files = $_FILES['expenditure_sign']; 
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = time().'_expenditure_signature_'.$name;
			  $target_file = 'assets/site/main/expenditure_signature/'.$imgname; 			
			  if(move_uploaded_file($_FILES["expenditure_sign"]["tmp_name"], $target_file)) 
			  { 	
			  	  
			  	  	  $expenditureArray['application_id'] = $applicationId;				 
					  $main_filter = $this->input->post('stipend_programme');
					  $student_filter = $this->input->post('student_filter');
					  $welfare_filter = $this->input->post('welfare_filter');
					  $uni_filter = $this->input->post('uni_filter');
					  
					  /* Main Table Fields Start */		
					  if(count($this->common_model->ExpenditureExists($applicationId))<=0)
					  {
					  	  $expenditureArray['name'] = $this->input->post('fullname');
						  $expenditureArray['country'] = $this->input->post('country');
						  $expenditureArray['universty_choice'] = $this->input->post('universty_choice');
						  
						  $expenditureArray['programme'] = $this->input->post('programme2');
						  $expenditureArray['course'] = $this->input->post('course2');
						  $expenditureArray['duration_from'] = $this->input->post('course_duration_from');
						  $expenditureArray['duration_to'] = $this->input->post('course_duration_to');
						  $expenditureArray['scheme'] = $this->input->post('scheme');
						  $expenditureArray['code'] = $this->input->post('code');
						  $expenditureArray['visa_type'] = $this->input->post('visa_type');								  
						  $expenditureArray['visa_from_date'] = $this->input->post('visa_from_date');
						  $expenditureArray['visa_to_date'] = $this->input->post('visa_to_date');
						  $expenditureArray['city_id'] = $this->input->post('city_id');
						  $expenditureArray['city_other'] = $this->input->post('city_other');
					  }		  
					  else
					  {
					  	  $d = $this->common_model->ExpenditureExists($applicationId);
					  	  $expenditureArray['name'] = $this->input->post('fullname');
						  $expenditureArray['country'] = $d[0]['country'];
						  $expenditureArray['universty_choice'] = $d[0]['universty_choice'];
						  $expenditureArray['programme'] = $d[0]['programme'];
						  $expenditureArray['course'] = $d[0]['course'];
						  $expenditureArray['duration_from'] = $d[0]['duration_from'];
						  $expenditureArray['duration_to'] = $d[0]['duration_to'];
						  $expenditureArray['scheme'] = $d[0]['scheme'];
						  $expenditureArray['code'] = $d[0]['code'];
						  $expenditureArray['visa_type'] = $d[0]['visa_type'];				  
						  $expenditureArray['visa_from_date'] = $d[0]['visa_from_date'];
						  $expenditureArray['visa_to_date'] = $d[0]['visa_to_date'];
						  $expenditureArray['city_id'] = $d[0]['city_id'];
						  $expenditureArray['city_other'] = $d[0]['city_other'];
					  }
					 
					  
					  $expenditureArray['application_id'] = $applicationId;	
					  $expenditureArray['exp_student_type'] = 'OLD';	
					  $expenditureArray['created'] = time();			  
					  /* Main Table Fields End */
					  $otherData['regionId'] = $regionid;
					  $otherData['application_id'] = $applicationId;
					  $otherData['created'] = time();	
					  	 	
					if($main_filter != 4 && $main_filter != 6)
					{
						$expenditureDoc = $_FILES['doc'];
						if($expenditureDoc["name"] != "")
						{
							$name1 = str_replace(" ","_",$expenditureDoc['name']);
							$docname = time().'_expenditure_doc_'.$name1;
							$target_doc_file = 'assets/site/main/expenditure_doc/'.$docname;
							if(move_uploaded_file($_FILES["doc"]["tmp_name"], $target_doc_file)) 
		  	  				{
		  	  					$otherData['doc'] = $docname;
		  	  				}
						}
						$otherData['scheme'] = $this->input->post('scheme');
					}	 	
					  	 	  
					  switch($main_filter)
					  {
					  	case "1":
					  		switch($student_filter)
					  		{
								case "1": 
								/* Stipend Table Date */			
										
										
									  if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('adv_stipend_from_date') != "")
									  {
									    $otherData['adv_stipend_from'] = $this->input->post('adv_stipend_from_date');
									  }
									  if($this->input->post('adv_stipend_to_date') != "")
									  {
									    $otherData['adv_stipend_to'] = $this->input->post('adv_stipend_to_date');
									  }
									  if($this->input->post('adv_stipend_rate') != "")
									  {
									    $otherData['adv_stipend_amount'] = $this->input->post('adv_stipend_rate');
									  }
									  if($this->input->post('adv_stipend_pmode') != "")
									  {
									    $otherData['adv_stipend_mode'] = $this->input->post('adv_stipend_pmode');
									  }
									  if($this->input->post('adv_stipend_cno') != "")
									  {
									    $otherData['adv_stipend_cheq_no'] = $this->input->post('adv_stipend_cno');
									  }
									  
									  $otherData['adv_stipend_off_name'] = $this->input->post('officer_name');
									  $otherData['fy'] = $this->input->post('fy_year');
									  $otherData['adv_stipend_off_sign'] = $imgname;
									 
									 $formattedFrom = date('d/m/Y', strtotime($otherData['adv_stipend_from']));
									 $formattedTo = date('d/m/Y', strtotime($otherData['adv_stipend_to']));
									 $otherData['adv_stipend_from'] =  $formattedFrom;
									 $otherData['adv_stipend_to'] =  $formattedTo;

										
									  $result = $this->common_model->insertAdvanceStipend($otherData);
								break;
								case "2":
								
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  /* Stipend Table Date */									  							  
									  if($this->input->post('stipend_from_date') != "")
									  {
									    $otherData['stipend_from'] = $this->input->post('stipend_from_date');
									  }
									  if($this->input->post('stipend_to_date') != "")
									  {
									    $otherData['stipend_to'] = $this->input->post('stipend_to_date');
									  }
									  if($this->input->post('stipend_rate') != "")
									  {
									    $otherData['amount'] = $this->input->post('stipend_rate');
									  }
									  if($this->input->post('stipend_pmode') != "")
									  {
									    $otherData['stipend_mode'] = $this->input->post('stipend_pmode');
									  }
									  if($this->input->post('stipend_cno') != "")
									  {
									    $otherData['stipend_cheq_no'] = $this->input->post('stipend_cno');
									  }
									  $otherData['stipend_off_name'] = $this->input->post('officer_name');
									  $otherData['stipend_off_sign'] = $imgname;
									  $otherData['fy'] = $this->input->post('fy_year');
									  
									 $formattedFrom = date('d/m/Y', strtotime($otherData['stipend_from']));
									 $formattedTo = date('d/m/Y', strtotime($otherData['stipend_to']));
									 $otherData['stipend_from'] =  $formattedFrom;
									 $otherData['stipend_to'] =  $formattedTo;
									  $result = $this->common_model->insertStipend($otherData);
								break;							
								case "3":
								 /* HRA Table Date */			
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
										  if($this->input->post('aca_year') != "")
										  {
										    $otherData['aca_year'] = $this->input->post('aca_year');
										  }
									  if($this->input->post('hra_from_date') != "")
									  {
									    $otherData['hra_from_date'] = $this->input->post('hra_from_date');
									  }
									  if($this->input->post('hra_to_date') != "")
									  {
									    $otherData['hra_to_date'] = $this->input->post('hra_to_date');
									  }
									  if($this->input->post('hra_rate') != "")
									  {
									    $otherData['hra_amount'] = $this->input->post('hra_rate');
									  }
									  if($this->input->post('hra_mode') != "")
									  {
									    $otherData['hra_mode'] = $this->input->post('hra_mode');
									  }
									  if($this->input->post('hra_cno') != "")
									  {
									    $otherData['hra_cno'] = $this->input->post('hra_cno');
									  }
									  if($this->input->post('hra_city') != "")
									  {
									    $otherData['hra_city'] = $this->input->post('hra_city');
									  }
									  $otherData['hra_official_name'] = $this->input->post('officer_name');
									  $otherData['hra_signature'] = $imgname;
									  $otherData['fy'] = $this->input->post('fy_year');
									  
									   $formattedFrom = date('d/m/Y', strtotime($otherData['hra_from_date']));
									 $formattedTo = date('d/m/Y', strtotime($otherData['hra_to_date']));
									 $otherData['hra_from_date'] =  $formattedFrom;
									 $otherData['hra_to_date'] =  $formattedTo;
									  
									  
									  $result = $this->common_model->insertHRA($otherData);
								break;
								case "4":
									/* ACA Table Date */		
									 if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
										
									  if($this->input->post('aca_release_date') != "")
									  {
									    $otherData['aca_release_date'] = $this->input->post('aca_release_date');
									  }
									  if($this->input->post('aca_year') != "")
									  {
									    $otherData['aca_year'] = $this->input->post('aca_year');
									  }								  
									  if($this->input->post('aca') != "")
									  {
									    $otherData['aca_amount'] = $this->input->post('aca');
									  }
									  if($this->input->post('aca_mode') != "")
									  {
									    $otherData['aca_mode'] = $this->input->post('aca_mode');
									  }
									  if($this->input->post('aca_cno') != "")
									  {
									    $otherData['aca_cno'] = $this->input->post('aca_cno');
									  }								  
									  $otherData['aca_official_name'] = $this->input->post('officer_name');
									  $otherData['aca_signature'] = $imgname;
									  $otherData['fy'] = $this->input->post('fy_year');
									  $otherData['aca_year'] = $this->input->post('aca_year');
									  $formattedFrom = date('d/m/Y', strtotime($otherData['aca_release_date']));
									  $otherData['aca_release_date'] =  $formattedFrom;
									
									  
									  $result = $this->common_model->insertACA($otherData);
								break;
								case "5":
									/* Study Tour Table Date */	

									 if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('st_from_date') != "")
									  {
									    $otherData['st_from_date'] = $this->input->post('st_from_date');
									  }	
									  if($this->input->post('st_to_date') != "")
									  {
									    $otherData['st_to_date'] = $this->input->post('st_to_date');
									  }								  
									  if($this->input->post('st_amount') != "")
									  {
									    $otherData['st_amount'] = $this->input->post('st_amount');
									  }
									  if($this->input->post('st_mode') != "")
									  {
									    $otherData['st_mode'] = $this->input->post('st_mode');
									  }
									  if($this->input->post('st_cno') != "")
									  {
									    $otherData['st_cno'] = $this->input->post('st_cno');
									  }								  
									  if($this->input->post('st_from_city') != "")
									  {
									    $otherData['st_from_city'] = $this->input->post('st_from_city');
									  }
									  if($this->input->post('st_to_city') != "")
									  {
									    $otherData['st_to_city'] = $this->input->post('st_to_city');
									  }
									  if($this->input->post('st_from_city_days') != "")
									  {
									    $otherData['st_from_city_days'] = $this->input->post('st_from_city_days');
									  }
									  if($this->input->post('st_to_city_days') != "")
									  {
									    $otherData['st_to_city_days'] = $this->input->post('st_to_city_days');
									  }								  
									  $otherData['st_official_name'] = $this->input->post('officer_name');
									  $otherData['st_signature'] = $imgname;	
									   $otherData['fy'] = $this->input->post('fy_year');
                             
									$formattedFrom = date('d/m/Y', strtotime($otherData['st_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['st_to_date']));
										  $otherData['st_from_date'] =  $formattedFrom;
										  $otherData['st_to_date'] =  $formattedTo;
									  $result = $this->common_model->insertStudyTour($otherData);
								break;
								case "6":
									/* Medical Reimbursment Table Date */	
									
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('mr_release_date') != "")
									  {
									    $otherData['mr_release_date'] = $this->input->post('mr_release_date');
									  }
									  if($this->input->post('mr_amount') != "")
									  {
									    $otherData['mr_amount'] = $this->input->post('mr_amount');
									  }
									  if($this->input->post('mr_mode') != "")
									  {
									    $otherData['mr_mode'] = $this->input->post('mr_mode');
									  }
									  if($this->input->post('mr_cno') != "")
									  {
									    $otherData['mr_cno'] = $this->input->post('mr_cno');
									  }							  
									  $otherData['mr_official_name'] = $this->input->post('officer_name');
									  $otherData['mr_signature'] = $imgname;
									  $otherData['fy'] = $this->input->post('fy_year');	
									$formattedFrom = date('d/m/Y', strtotime($otherData['mr_release_date']));
										 
									$otherData['mr_release_date'] =  $formattedFrom;
									  $result = $this->common_model->insertMedicalReimbursment($otherData);
								break;
								case "7":
								  /* Thesis Charges Table Date */	
								  
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
								  	  if($this->input->post('tc_release_date') != "")
									  {
									    $otherData['tc_release_date'] = $this->input->post('tc_release_date');
									  }
									  if($this->input->post('tc_amount') != "")
									  {
									    $otherData['tc_amount'] = $this->input->post('tc_amount');
									  }
									  if($this->input->post('tc_mode') != "")
									  {
									    $otherData['tc_mode'] = $this->input->post('tc_mode');
									  }
									  if($this->input->post('tc_cno') != "")
									  {
									    $otherData['tc_cno'] = $this->input->post('tc_cno');
									  }							  
									  $otherData['tc_official_name'] = $this->input->post('officer_name');
									  $otherData['tc_signature'] = $imgname;
									  	 $otherData['fy'] = $this->input->post('fy_year');		
										 
										 $formattedFrom = date('d/m/Y', strtotime($otherData['tc_release_date']));
										  
										  $otherData['tc_release_date'] =  $formattedFrom;
										  

											
									 $result = $this->common_model->insertThesisCharges($otherData);
								break;
								case "8":
									 /* Misce Table Date */	
									 
									 if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('msc_release_date') != "")
									  {
									    $otherData['msc_release_date'] = $this->input->post('msc_release_date');
									  }
									  if($this->input->post('msc_item') != "")
									  {
									    $otherData['msc_item'] = $this->input->post('msc_item');
									  }
									  if($this->input->post('msc_amount') != "")
									  {
									    $otherData['msc_amount'] = $this->input->post('msc_amount');
									  }
									  if($this->input->post('msc_mode') != "")
									  {
									    $otherData['msc_mode'] = $this->input->post('msc_mode');
									  }
									  if($this->input->post('msc_cno') != "")
									  {
									    $otherData['msc_cno'] = $this->input->post('msc_cno');
									  }								  						  
									  $otherData['msc_official_name'] = $this->input->post('officer_name');
									  $otherData['msc_signature'] = $imgname;
									   $otherData['fy'] = $this->input->post('fy_year');

									$formattedFrom = date('d/m/Y', strtotime($otherData['msc_release_date']));
										  
									   $otherData['msc_release_date'] =  $formattedFrom;
									  $result=$this->common_model->insertMiscellaneous($otherData);
								break;
								
							}
					  	break;
					  	case "2":
					  		switch($uni_filter)
					  		{
								case "1":
								/* Tution Fee Table Date */		
								if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
								  if($this->input->post('tf_year') != "")
								  {
								    $otherData['tf_year'] = $this->input->post('tf_year');
								  }	
								  if($this->input->post('tf_release_date') != "")
								  {
								    $otherData['tf_release_date'] = $this->input->post('tf_release_date');
								  }						  
								  if($this->input->post('tf_amount') != "")
								  {
								    $otherData['tf_amount'] = $this->input->post('tf_amount');
								  }
								  if($this->input->post('tf_mode') != "")
								  {
								    $otherData['tf_mode'] = $this->input->post('tf_mode');
								  }
								  if($this->input->post('tf_cheq_no') != "")
								  {
								    $otherData['tf_cheq_no'] = $this->input->post('tf_cheq_no');
								  }							  
								  $otherData['tf_off_name'] = $this->input->post('officer_name');
								  $otherData['tf_off_sign'] = $imgname;
								  $otherData['fy'] = $this->input->post('fy_year');
								  $otherData['tf_year'] = $this->input->post('tf_year');
								  
								  $formattedFrom = date('d/m/Y', strtotime($otherData['tf_release_date']));
								  $otherData['tf_release_date'] =  $formattedFrom;
										  
								  $result=$this->common_model->insertTutionFee($otherData);
								break;
								case "2":
								/* Tution Fee Table Date */		
									
								 if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
								  if($this->input->post('ocf_year') != "")
								  {
								    $otherData['ocf_year'] = $this->input->post('ocf_year');
								  }		
								  if($this->input->post('ocf_release_date') != "")
								  {
								    $otherData['ocf_release_date'] = $this->input->post('ocf_release_date');
								  }					  
								  if($this->input->post('ocf_amount') != "")
								  {
								    $otherData['ocf_amount'] = $this->input->post('ocf_amount');
								  }
								  if($this->input->post('ocf_mode') != "")
								  {
								    $otherData['ocf_mode'] = $this->input->post('ocf_mode');
								  }
								  if($this->input->post('ocf_cheq_no') != "")
								  {
								    $otherData['ocf_cheq_no'] = $this->input->post('ocf_cheq_no');
								  }							  
								  $otherData['ocf_off_name'] = $this->input->post('officer_name');
								  $otherData['ocf_off_sign'] = $imgname;
								  	
								$formattedFrom = date('d/m/Y', strtotime($otherData['ocf_release_date']));	 
								$otherData['ocf_release_date'] =  $formattedFrom;
								 $result=$this->common_model->insertOCFee($otherData);
								break;
								case "3":
								/* Misce Table Date */	
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('uni_msc_item') != "")
									  {
									    $otherData['uni_msc_item'] = $this->input->post('uni_msc_item');
									  }
									  if($this->input->post('uni_msc_release_date') != "")
									  {
									    $otherData['uni_msc_release_date'] = $this->input->post('uni_msc_release_date');
									  }
									  if($this->input->post('uni_msc_amount') != "")
									  {
									    $otherData['uni_msc_amount'] = $this->input->post('uni_msc_amount');
									  }
									  if($this->input->post('uni_msc_mode') != "")
									  {
									    $otherData['uni_msc_mode'] = $this->input->post('uni_msc_mode');
									  }
									  if($this->input->post('uni_msc_cno') != "")
									  {
									    $otherData['uni_msc_cno'] = $this->input->post('uni_msc_cno');
									  }								  						  
									  $otherData['uni_msc_official_name'] = $this->input->post('officer_name');
									  $otherData['uni_msc_signature'] = $imgname;
									
									  $formattedFrom = date('d/m/Y', strtotime($otherData['uni_msc_release_date']));
									  $otherData['uni_msc_release_date'] =  $formattedFrom;
										  
									  $result=$this->common_model->insertUniversityMiscellaneous($otherData);
								break;	
								case "4":
								/* Hostel Charges Table Date */	
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('hos_from') != "")
									  {
									    $otherData['hos_from'] = $this->input->post('hos_from');
									  }	
									  if($this->input->post('hos_to') != "")
									  {
									    $otherData['hos_to'] = $this->input->post('hos_to');
									  }								  
									  if($this->input->post('hos_amount') != "")
									  {
									    $otherData['hos_amount'] = $this->input->post('hos_amount');
									  }
									  if($this->input->post('hos_mode') != "")
									  {
									    $otherData['hos_mode'] = $this->input->post('hos_mode');
									  }
									  if($this->input->post('hos_cheq_no') != "")
									  {
									    $otherData['hos_cheq_no'] = $this->input->post('hos_cheq_no');
									  }							  
									  $otherData['hos_off_name'] = $this->input->post('officer_name');
									  $otherData['hos_off_sign'] = $imgname;
									 

									$formattedFrom = date('d/m/Y', strtotime($otherData['hos_from']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['hos_to']));
										  $otherData['hos_from'] =  $formattedFrom;
										  $otherData['hos_to'] =  $formattedTo;
									  $result=$this->common_model->insertHostelCharges($otherData);
								break;
								case "5":
								/* English Bridge Course Table Date */	
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('ebc_from_date') != "")
									  {
									    $otherData['ebc_from_date'] = $this->input->post('ebc_from_date');
									  }	
									  if($this->input->post('ebc_to_date') != "")
									  {
									    $otherData['ebc_to_date'] = $this->input->post('ebc_to_date');
									  }								  
									  if($this->input->post('ebc_amount') != "")
									  {
									    $otherData['ebc_amount'] = $this->input->post('ebc_amount');
									  }
									  if($this->input->post('ebc_mode') != "")
									  {
									    $otherData['ebc_mode'] = $this->input->post('ebc_mode');
									  }
									  if($this->input->post('ebc_cno') != "")
									  {
									    $otherData['ebc_cno'] = $this->input->post('ebc_cno');
									  }							  
									  $otherData['ebc_off_name'] = $this->input->post('officer_name');
									  $otherData['ebc_off_sign'] = $imgname;
									   $formattedFrom = date('d/m/Y', strtotime($otherData['ebc_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['ebc_to_date']));
										  $otherData['ebc_to_date'] =  $formattedFrom;
										  $otherData['st_to_date'] =  $formattedTo;
									  $result=$this->common_model->insertEnglishBridgeCourse($otherData);
								break;						
							}
					  	break;
					  	case "3":
					  		/* Travel Table Date */	
							
							if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
							  if($this->input->post('travel_type') != "")
							  {
							    $otherData['travel_type'] = $this->input->post('travel_type');
							  }
							  if($this->input->post('travel_amount') != "")
							  {
							    $otherData['travel_amount'] = $this->input->post('travel_amount');
							  }
							  if($this->input->post('travel_release_date') != "")
							  {
							    $otherData['travel_release_date'] = $this->input->post('travel_release_date');
							  }
							  if($this->input->post('travel_mode') != "")
							  {
							    $otherData['travel_mode'] = $this->input->post('travel_mode');
							  }
							  if($this->input->post('travel_cno') != "")
							  {
							    $otherData['travel_cno'] = $this->input->post('travel_cno');
							  }								  						  
							  $otherData['travel_official_name'] = $this->input->post('officer_name');
							  $otherData['travel_signature'] = $imgname;
							   $otherData['fy'] = $this->input->post('fy_year');	
								$formattedFrom = date('d/m/Y', strtotime($otherData['travel_release_date']));
										  
										  $otherData['travel_release_date'] =  $formattedFrom;
										
							  $result=$this->common_model->insertTravelCharges($otherData);
					  	break;
					  	case "4":
					  		/* Residential Permit Table Date */	
							if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
							  if($this->input->post('permit_no') != "")
							  {
							    $otherData['permit_no'] = $this->input->post('permit_no');
							  }
							  if($this->input->post('permit_from') != "")
							  {
							    $otherData['permit_from'] = $this->input->post('permit_from');
							  }
							  if($this->input->post('permit_to') != "")
							  {
							    $otherData['permit_to'] = $this->input->post('permit_to');
							  }
							  $permitfiles = $_FILES['permit_doc'];   
							  if($permitfiles["name"] != "")
							  {				
								  $name = str_replace(" ","_",$permitfiles['name']);
								  $permitname = $applicationId.'_'.time().'_permit_doc_'.$name;
								  
								  $target_file_permit = 'assets/site/main/permit_docs/'.$permitname; 
								  if (move_uploaded_file($_FILES["permit_doc"]["tmp_name"], $target_file_permit)) 
								  { 
								  	$otherData['permit_doc'] = $permitname;
								  }
								  else
								  {
								  	$otherData['permit_doc'] = "NO_DOC_UPLOADED";
								  }
							  }						  						  
							  $otherData['permit_off_name'] = $this->input->post('officer_name');
							  $otherData['permit_off_sign'] = $imgname;
							   $otherData['fy'] = $this->input->post('fy_year');		
								$formattedFrom = date('d/m/Y', strtotime($otherData['st_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['permit_to']));
										  $otherData['st_from_date'] =  $formattedFrom;
										  $otherData['permit_to'] =  $formattedTo;
							  $result=$this->common_model->insertPermitDetails($otherData);
					  		
					  	break;
					  	case "5":
					  	/* welfare_filter */
					  		switch($welfare_filter)
					  		{
								case "1":
									  /* Orientation Programme */		
										if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('op_from_date') != "")
									  {
									    $otherData['op_from_date'] = $this->input->post('op_from_date');
									  }
									  if($this->input->post('op_to_date') != "")
									  {
									    $otherData['op_to_date'] = $this->input->post('op_to_date');
									  }
									  if($this->input->post('op_amount') != "")
									  {
									    $otherData['op_amount'] = $this->input->post('op_amount');
									  }
									  if($this->input->post('op_mode') != "")
									  {
									    $otherData['op_mode'] = $this->input->post('op_mode');
									  }
									  if($this->input->post('op_cno') != "")
									  {
									    $otherData['op_cno'] = $this->input->post('op_cno');
									  }
									  $otherData['op_official_name'] = $this->input->post('officer_name');
									  $otherData['op_signature'] = $imgname;
									 
										 $formattedFrom = date('d/m/Y', strtotime($otherData['op_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['op_to_date']));
										  $otherData['op_from_date'] =  $formattedFrom;
										  $otherData['op_to_date'] =  $formattedTo;
									  $result = $this->common_model->insertOrientationProgramme($otherData);
								break;							
								case "2":
								 /* Camps */				

									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									   if($this->input->post('camps_from_date') != "")
									  {
									    $otherData['camps_from_date'] = $this->input->post('camps_from_date');
									  }
									  if($this->input->post('camps_to_date') != "")
									  {
									    $otherData['camps_to_date'] = $this->input->post('camps_to_date');
									  }
									  if($this->input->post('camps_amount') != "")
									  {
									    $otherData['camps_amount'] = $this->input->post('camps_amount');
									  }
									  if($this->input->post('camps_mode') != "")
									  {
									    $otherData['camps_mode'] = $this->input->post('camps_mode');
									  }
									  if($this->input->post('camps_cno') != "")
									  {
									    $otherData['camps_cno'] = $this->input->post('camps_cno');
									  }
									  $otherData['camps_official_name'] = $this->input->post('officer_name');
									  $otherData['camps_signature'] = $imgname;
									  $otherData['fy'] = $this->input->post('ac_year');		
										 $formattedFrom = date('d/m/Y', strtotime($otherData['camps_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['camps_to_date']));
										  $otherData['camps_from_date'] =  $formattedFrom;
										  $otherData['camps_to_date'] =  $formattedTo;
									  $result = $this->common_model->insertCamps($otherData);
								break;
								case "3":
									/* ISA Meeting */	
										if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }									
									  if($this->input->post('isa_from_date') != "")
									  {
									    $otherData['isa_from_date'] = $this->input->post('isa_from_date');
									  }
									  if($this->input->post('isa_to_date') != "")
									  {
									    $otherData['isa_to_date'] = $this->input->post('isa_to_date');
									  }
									  if($this->input->post('isa_amount') != "")
									  {
									    $otherData['isa_amount'] = $this->input->post('isa_amount');
									  }
									  if($this->input->post('isa_mode') != "")
									  {
									    $otherData['isa_mode'] = $this->input->post('isa_mode');
									  }
									  if($this->input->post('isa_cno') != "")
									  {
									    $otherData['isa_cno'] = $this->input->post('isa_cno');
									  }
									  $otherData['isa_official_name'] = $this->input->post('officer_name');
									  $otherData['isa_signature'] = $imgname;
									  	$formattedFrom = date('d/m/Y', strtotime($otherData['isa_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['isa_to_date']));
										  $otherData['isa_from_date'] =  $formattedFrom;
										  $otherData['isa_to_date'] =  $formattedTo;						  
									  $result = $this->common_model->insertISAMeeting($otherData);
								break;
								case "4":
									/* Stumptuary Allowance */	
											if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('sump_from_date') != "")
									  {
									    $otherData['sump_from_date'] = $this->input->post('sump_from_date');
									  }
									  if($this->input->post('sump_to_date') != "")
									  {
									    $otherData['sump_to_date'] = $this->input->post('sump_to_date');
									  }
									  if($this->input->post('sump_amount') != "")
									  {
									    $otherData['sump_amount'] = $this->input->post('sump_amount');
									  }
									  if($this->input->post('sump_mode') != "")
									  {
									    $otherData['sump_mode'] = $this->input->post('sump_mode');
									  }
									  if($this->input->post('sump_cno') != "")
									  {
									    $otherData['sump_cno'] = $this->input->post('sump_cno');
									  }
									  $otherData['sump_official_name'] = $this->input->post('officer_name');
									  $otherData['sump_signature'] = $imgname;	
									  	 $formattedFrom = date('d/m/Y', strtotime($otherData['sump_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['sump_to_date']));
										  $otherData['sump_from_date'] =  $formattedFrom;
										  $otherData['sump_to_date'] =  $formattedTo;					  
									  $result = $this->common_model->insertSumptuary($otherData);
								break;
								case "5":
									/* Emergancy Fund */	
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('ef_from_date') != "")
									  {
									    $otherData['ef_from_date'] = $this->input->post('ef_from_date');
									  }
									  if($this->input->post('ef_to_date') != "")
									  {
									    $otherData['ef_to_date'] = $this->input->post('ef_to_date');
									  }
									  if($this->input->post('ef_amount') != "")
									  {
									    $otherData['ef_amount'] = $this->input->post('ef_amount');
									  }
									  if($this->input->post('ef_mode') != "")
									  {
									    $otherData['ef_mode'] = $this->input->post('ef_mode');
									  }
									  if($this->input->post('ef_cno') != "")
									  {
									    $otherData['ef_cno'] = $this->input->post('ef_cno');
									  }
									  $otherData['ef_official_name'] = $this->input->post('officer_name');
									  $otherData['ef_signature'] = $imgname;
									  	$formattedFrom = date('d/m/Y', strtotime($otherData['ef_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['ef_to_date']));
										  $otherData['ef_from_date'] =  $formattedFrom;
										  $otherData['ef_to_date'] =  $formattedTo;							  
									  $result = $this->common_model->insertEmergancyFund($otherData);
								break;
								case "6":
									/* Student Day */	
									
									  if($this->input->post('sd_from_date') != "")
									  {
									    $otherData['sd_from_date'] = $this->input->post('sd_from_date');
									  }
									  if($this->input->post('sd_to_date') != "")
									  {
									    $otherData['sd_to_date'] = $this->input->post('sd_to_date');
									  }
									  if($this->input->post('sd_amount') != "")
									  {
									    $otherData['sd_amount'] = $this->input->post('sd_amount');
									  }
									  if($this->input->post('sd_mode') != "")
									  {
									    $otherData['sd_mode'] = $this->input->post('sd_mode');
									  }
									  if($this->input->post('sd_cno') != "")
									  {
									    $otherData['sd_cno'] = $this->input->post('sd_cno');
									  }
									  $otherData['sd_official_name'] = $this->input->post('officer_name');
									  $otherData['sd_signature'] = $imgname;
									  	$formattedFrom = date('d/m/Y', strtotime($otherData['sd_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['sd_to_date']));
										  $otherData['sd_from_date'] =  $formattedFrom;
										  $otherData['sd_to_date'] =  $formattedTo;					  
									  $result = $this->common_model->insertStudentDay($otherData);
								break;
								case "7":
									/* Day of National Importance */	
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('nd_from_date') != "")
									  {
									    $otherData['nd_from_date'] = $this->input->post('nd_from_date');
									  }
									  if($this->input->post('nd_to_date') != "")
									  {
									    $otherData['nd_to_date'] = $this->input->post('nd_to_date');
									  }
									  if($this->input->post('nd_amount') != "")
									  {
									    $otherData['nd_amount'] = $this->input->post('nd_amount');
									  }
									  if($this->input->post('nd_mode') != "")
									  {
									    $otherData['nd_mode'] = $this->input->post('nd_mode');
									  }
									  if($this->input->post('nd_cno') != "")
									  {
									    $otherData['nd_cno'] = $this->input->post('nd_cno');
									  }
									 
									  $otherData['nd_official_name'] = $this->input->post('officer_name');
									  $otherData['nd_signature'] = $imgname;
									  $formattedFrom = date('d/m/Y', strtotime($otherData['nd_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['nd_to_date']));
										  $otherData['nd_from_date'] =  $formattedFrom;
										  $otherData['nd_to_date'] =  $formattedTo;
									  $result = $this->common_model->insertNationalDay($otherData);
								break;
							}
					  	break;
					  	case "6":
					  		/* Bank Details Table Date */	
							
							if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
							  if($this->input->post('bankname') != "")
							  {
							    $otherData['bankname'] = $this->input->post('bankname');
							  }
							  if($this->input->post('account_no') != "")
							  {
							    $otherData['account_no'] = $this->input->post('account_no');
							  }
							  
							  $bankFiles = $_FILES['bank_doc'];   
							  if($bankFiles["name"] != "")
							  {				
								  $name = str_replace(" ","_",$bankFiles['name']);
								  $bankimgname = $applicationId.'_'.time().'_bank_doc_'.$name;
								  
								  $target_file_bank = 'assets/site/main/bank_docs/'.$bankimgname; 
								  if (move_uploaded_file($_FILES["bank_doc"]["tmp_name"], $target_file_bank)) 
								  { 
								  	$otherData['bank_doc'] = $bankimgname;
								  }
								  else
								  {
								  	$otherData['bank_doc'] = "NO_DOC_UPLOADED";
								  }
							  }						  						  
							  $otherData['bank_off_name'] = $this->input->post('officer_name');
							  $otherData['bank_off_sign'] = $imgname;
														  
							  $result=$this->common_model->insertBankDetails($otherData);
					  	break;
					  	case "7":
					  		/* Ex-India Deductions Table Date */	
							if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
							  if($this->input->post('ded_from') != "")
							  {
							    $otherData['ded_from'] = $this->input->post('ded_from');
							  }
							  if($this->input->post('ded_to') != "")
							  {
							    $otherData['ded_to'] = $this->input->post('ded_to');
							  }
							  if($this->input->post('ded_mode') != "")
							  {
							    $otherData['ded_mode'] = $this->input->post('ded_mode');
							  }
							  if($this->input->post('ded_cheq_no') != "")
							  {
							    $otherData['ded_cheq_no'] = $this->input->post('ded_cheq_no');
							  }	
							  if($this->input->post('ded_amount') != "")
							  {
							    $otherData['ded_amount'] = $this->input->post('ded_amount');
							  }								  						  
							  $otherData['ded_off_name'] = $this->input->post('officer_name');
							  $otherData['ded_off_sign'] = $imgname;
							    $formattedFrom = date('d/m/Y', strtotime($otherData['ded_from']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['ded_to']));
										  $otherData['ded_from'] =  $formattedFrom;
										  $otherData['ded_to'] =  $formattedTo;							  
							  $result=$this->common_model->insertDeductions($otherData);
					  	break;
					  }
					  
					  if(count($this->common_model->ExpenditureExists($applicationId))<=0)
					  {
					     		
					  	 $result1 = $this->common_model->insertExpenditure($expenditureArray);
					  }
					  else
					  {					  	
					  	 $result1 = $this->common_model->updateExpenditureOldDetails($expenditureArray);
					  }
					  
					if($result)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Expenditure Saved!');
						redirect(site_url().'regional/regionalExpenditureForOldUser/'.$applicationId);						
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error Occur While Saving Expenditure!');
						redirect(site_url().'regional/dashboard');							
					}
			  	  	
			  }
			  else{
			  			$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error Occur While Saving Signature.!');
						redirect(site_url().'regional/dashboard');							
			  }
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Signature.!');
				redirect(site_url().'regional/dashboard');	
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Signature.!');
			redirect(site_url().'regional/dashboard');
		}
	}
	function studentExpenditure()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$applicationId = $this->uri->segment(3);
			$post = $this->input->post();
			//echo "<pre>";
			//print_r($post);die;
			$expenditureArray = array();
			$otherData = array();
			
			$files = $_FILES['expenditure_sign'];
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = time().'_expenditure_signature_'.$name;
			  $target_file = 'assets/site/main/expenditure_signature/'.$imgname; 
			  if(move_uploaded_file($_FILES["expenditure_sign"]["tmp_name"], $target_file)) 
			  { 
			  	 
				  	  $post['application_id'] = $applicationId;
					  $main_filter = $this->input->post('stipend_programme');
					  $student_filter = $this->input->post('student_filter');
					  $welfare_filter = $this->input->post('welfare_filter');
					  $uni_filter = $this->input->post('uni_filter');
					  
					  /* Main Table Fields Start */	
					  $mapdata = $this->common_model->getMappingData($applicationId);
				  	  $applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);			  
					  $expenditureArray['name'] = $applicaitonStepOne[0]['fullname'];
					  $expenditureArray['country'] = $applicaitonStepOne[0]['country'];
					  $expenditureArray['universty_choice'] = $mapdata[0]['regional_university'];
					   $expenditureArray['programme'] = $applicaitonStepOne[0]['programme'];
					  $expenditureArray['course'] =  $applicaitonStepOne[0]['course'];
					  $expenditureArray['duration_from'] = $this->input->post('course_duration_from');
					  $expenditureArray['duration_to'] = $this->input->post('course_duration_to');
					  $expenditureArray['scheme'] = $mapdata[0]['scholarship_id'];
					  $expenditureArray['code'] = $this->input->post('code');	
					  $expenditureArray['visa_type'] = $this->input->post('visa_type');								  
					  $expenditureArray['visa_from_date'] = $this->input->post('visa_from_date');
					  $expenditureArray['visa_to_date'] = $this->input->post('visa_to_date');
					  $expenditureArray['city_id'] = $this->input->post('city_id');
					  $expenditureArray['city_other'] = $this->input->post('city_other');
					  $expenditureArray['application_id'] = $applicationId;	
					  $expenditureArray['exp_student_type'] = 'NEW';
						$expenditureArray['created'] = time();					  
					  /* Main Table Fields End */
					  
					  $otherData['application_id'] = $applicationId;
					  $otherData['regionId'] = $regionid;
					  $otherData['created'] = time();		
					
						if($main_filter != 4 && $main_filter != 6)
						{
							$expenditureDoc = $_FILES['doc'];
							if($expenditureDoc["name"] != "")
							{
								$name1 = str_replace(" ","_",$expenditureDoc['name']);
								$docname = time().'_expenditure_doc_'.$name1;
								$target_doc_file = 'assets/site/main/expenditure_doc/'.$docname;
								if(move_uploaded_file($_FILES["doc"]["tmp_name"], $target_doc_file)) 
			  	  				{
			  	  					$otherData['doc'] = $docname;
			  	  				}
							}
							$otherData['scheme'] = $mapdata[0]['scholarship_id'];
						}	  
					 	  switch($main_filter)
						  {
							  
						  	case "1":
						  		switch($student_filter)
						  		{
									case "1": 
									/* Stipend Table Date */	
											if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
										  if($this->input->post('adv_stipend_from_date') != "")
										  {
										    $otherData['adv_stipend_from'] = $this->input->post('adv_stipend_from_date');
										  }
										  if($this->input->post('adv_stipend_to_date') != "")
										  {
										    $otherData['adv_stipend_to'] = $this->input->post('adv_stipend_to_date');
										  }
										  if($this->input->post('adv_stipend_rate') != "")
										  {
										    $otherData['adv_stipend_amount'] = $this->input->post('adv_stipend_rate');
										  }
										  if($this->input->post('adv_stipend_pmode') != "")
										  {
										    $otherData['adv_stipend_mode'] = $this->input->post('adv_stipend_pmode');
										  }
										  if($this->input->post('adv_stipend_cno') != "")
										  {
										    $otherData['adv_stipend_cheq_no'] = $this->input->post('adv_stipend_cno');
										  }
										  $otherData['adv_stipend_off_name'] = $this->input->post('officer_name');
										  $otherData['adv_stipend_off_sign'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['adv_stipend_from']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['adv_stipend_to']));
										  $otherData['adv_stipend_from'] =  $formattedFrom;
										  $otherData['adv_stipend_to'] =  $formattedTo;
										  $result = $this->common_model->insertAdvanceStipend($otherData);
									break;
									case "2":
										  /* Stipend Table Date */
										  if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }									  							  
										  if($this->input->post('stipend_from_date') != "")
										  {
										    $otherData['stipend_from'] = $this->input->post('stipend_from_date');
										  }
										  if($this->input->post('stipend_to_date') != "")
										  {
										    $otherData['stipend_to'] = $this->input->post('stipend_to_date');
										  }
										  if($this->input->post('stipend_rate') != "")
										  {
										    $otherData['amount'] = $this->input->post('stipend_rate');
										  }
										  if($this->input->post('stipend_pmode') != "")
										  {
										    $otherData['stipend_mode'] = $this->input->post('stipend_pmode');
										  }
										  if($this->input->post('stipend_cno') != "")
										  {
										    $otherData['stipend_cheq_no'] = $this->input->post('stipend_cno');
										  }
										  $otherData['stipend_off_name'] = $this->input->post('officer_name');
										  $otherData['stipend_off_sign'] = $imgname;				
											//echo "<pre>";print_r($otherData);die;
										  $formattedFrom = date('d/m/Y', strtotime($otherData['stipend_from']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['stipend_to']));
										  $otherData['stipend_from'] =  $formattedFrom;
										  $otherData['stipend_to'] =  $formattedTo;
										  //echo "<pre>";
										  //print_r($otherdata);die;
										  $result = $this->common_model->insertStipend($otherData);
									break;							
									case "3":
									 /* HRA Table Date */		
											
										  if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }	
										  if($this->input->post('hra_from_date') != "")
										  {
										    $otherData['hra_from_date'] = $this->input->post('hra_from_date');
										  }
										  if($this->input->post('hra_to_date') != "")
										  {
										    $otherData['hra_to_date'] = $this->input->post('hra_to_date');
										  }
										  if($this->input->post('hra_rate') != "")
										  {
										    $otherData['hra_amount'] = $this->input->post('hra_rate');
										  }
										  if($this->input->post('hra_mode') != "")
										  {
										    $otherData['hra_mode'] = $this->input->post('hra_mode');
										  }
										  if($this->input->post('hra_cno') != "")
										  {
										    $otherData['hra_cno'] = $this->input->post('hra_cno');
										  }
										  if($this->input->post('hra_city') != "")
										  {
										    $otherData['hra_city'] = $this->input->post('hra_city');
										  }
										  $otherData['hra_official_name'] = $this->input->post('officer_name');
										  $otherData['hra_signature'] = $imgname;	

										  $formattedFrom = date('d/m/Y', strtotime($otherData['hra_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['hra_to_date']));
										  $otherData['hra_from_date'] =  $formattedFrom;
										  $otherData['hra_to_date'] =  $formattedTo;
										  $result = $this->common_model->insertHRA($otherData);
									break;
									case "4":
										/* ACA Table Date */	
										if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }									  							  
										  if($this->input->post('aca_release_date') != "")
										  {
										    $otherData['aca_release_date'] = $this->input->post('aca_release_date');
										  }
										  if($this->input->post('aca_year') != "")
										  {
										    $otherData['aca_year'] = $this->input->post('aca_year');
										  }								  
										  if($this->input->post('aca') != "")
										  {
										    $otherData['aca_amount'] = $this->input->post('aca');
										  }
										  if($this->input->post('aca_mode') != "")
										  {
										    $otherData['aca_mode'] = $this->input->post('aca_mode');
										  }
										  if($this->input->post('aca_cno') != "")
										  {
										    $otherData['aca_cno'] = $this->input->post('aca_cno');
										  }								  
										  $otherData['aca_official_name'] = $this->input->post('officer_name');
										  $otherData['aca_signature'] = $imgname;	
										
										  $formattedFrom = date('d/m/Y', strtotime($otherData['aca_release_date']));
										  $otherData['aca_release_date'] =  $formattedFrom;
										  $result = $this->common_model->insertACA($otherData);
									break;
									case "5":
										/* Study Tour Table Date */		

											if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }	
										  if($this->input->post('st_from_date') != "")
										  {
										    $otherData['st_from_date'] = $this->input->post('st_from_date');
										  }	
										  if($this->input->post('st_to_date') != "")
										  {
										    $otherData['st_to_date'] = $this->input->post('st_to_date');
										  }								  
										  if($this->input->post('st_amount') != "")
										  {
										    $otherData['st_amount'] = $this->input->post('st_amount');
										  }
										  if($this->input->post('st_mode') != "")
										  {
										    $otherData['st_mode'] = $this->input->post('st_mode');
										  }
										  if($this->input->post('st_cno') != "")
										  {
										    $otherData['st_cno'] = $this->input->post('st_cno');
										  }								  
										  if($this->input->post('st_from_city') != "")
										  {
										    $otherData['st_from_city'] = $this->input->post('st_from_city');
										  }
										  if($this->input->post('st_to_city') != "")
										  {
										    $otherData['st_to_city'] = $this->input->post('st_to_city');
										  }
										  if($this->input->post('st_from_city_days') != "")
										  {
										    $otherData['st_from_city_days'] = $this->input->post('st_from_city_days');
										  }
										  if($this->input->post('st_to_city_days') != "")
										  {
										    $otherData['st_to_city_days'] = $this->input->post('st_to_city_days');
										  }								  
										  $otherData['st_official_name'] = $this->input->post('officer_name');
										  $otherData['st_signature'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['st_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['st_to_date']));
										  $otherData['st_from_date'] =  $formattedFrom;
										  $otherData['st_to_date'] =  $formattedTo;
										  
										  $result = $this->common_model->insertStudyTour($otherData);
									break;
									case "6":
										/* Medical Reimbursment Table Date */

										
											if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
										  if($this->input->post('mr_release_date') != "")
										  {
										    $otherData['mr_release_date'] = $this->input->post('mr_release_date');
										  }
										  if($this->input->post('mr_amount') != "")
										  {
										    $otherData['mr_amount'] = $this->input->post('mr_amount');
										  }
										  if($this->input->post('mr_mode') != "")
										  {
										    $otherData['mr_mode'] = $this->input->post('mr_mode');
										  }
										  if($this->input->post('mr_cno') != "")
										  {
										    $otherData['mr_cno'] = $this->input->post('mr_cno');
										  }							  
										  $otherData['mr_official_name'] = $this->input->post('officer_name');
										  $otherData['mr_signature'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['mr_release_date']));
										  $otherData['mr_release_date'] =  $formattedFrom;
										 
										  
										  $result = $this->common_model->insertMedicalReimbursment($otherData);
									break;
									case "7":
									  /* Thesis Charges Table Date */	
									  
											if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  	  if($this->input->post('tc_release_date') != "")
										  {
										    $otherData['tc_release_date'] = $this->input->post('tc_release_date');
										  }
										  if($this->input->post('tc_amount') != "")
										  {
										    $otherData['tc_amount'] = $this->input->post('tc_amount');
										  }
										  if($this->input->post('tc_mode') != "")
										  {
										    $otherData['tc_mode'] = $this->input->post('tc_mode');
										  }
										  if($this->input->post('tc_cno') != "")
										  {
										    $otherData['tc_cno'] = $this->input->post('tc_cno');
										  }							  
										  $otherData['tc_official_name'] = $this->input->post('officer_name');
										  $otherData['tc_signature'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['tc_release_date']));
										  $otherData['tc_release_date'] =  $formattedFrom;
										  
										 $result = $this->common_model->insertThesisCharges($otherData);
									break;
									case "8":
										 /* Misce Table Date */	
										 
											if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
										  if($this->input->post('msc_release_date') != "")
										  {
										    $otherData['msc_release_date'] = $this->input->post('msc_release_date');
										  }
										  if($this->input->post('msc_item') != "")
										  {
										    $otherData['msc_item'] = $this->input->post('msc_item');
										  }
										  if($this->input->post('msc_amount') != "")
										  {
										    $otherData['msc_amount'] = $this->input->post('msc_amount');
										  }
										  if($this->input->post('msc_mode') != "")
										  {
										    $otherData['msc_mode'] = $this->input->post('msc_mode');
										  }
										  if($this->input->post('msc_cno') != "")
										  {
										    $otherData['msc_cno'] = $this->input->post('msc_cno');
										  }								  						  
										  $otherData['msc_official_name'] = $this->input->post('officer_name');
										  $otherData['msc_signature'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['msc_release_date']));
										
										  $otherData['msc_release_date'] =  $formattedFrom;
										 
										  $result=$this->common_model->insertMiscellaneous($otherData);
									break;
									
								}
						  	break;
						  	case "2":
						  		switch($uni_filter)
						  		{
									case "1":
									/* Tution Fee Table Date */	
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }								  							  
									  if($this->input->post('tf_year') != "")
									  {
									    $otherData['tf_year'] = $this->input->post('tf_year');
									  }	
									  if($this->input->post('tf_release_date') != "")
									  {
									    $otherData['tf_release_date'] = $this->input->post('tf_release_date');
									  }						  
									  if($this->input->post('tf_amount') != "")
									  {
									    $otherData['tf_amount'] = $this->input->post('tf_amount');
									  }
									  if($this->input->post('tf_mode') != "")
									  {
									    $otherData['tf_mode'] = $this->input->post('tf_mode');
									  }
									  if($this->input->post('tf_cheq_no') != "")
									  {
									    $otherData['tf_cheq_no'] = $this->input->post('tf_cheq_no');
									  }							  
									  $otherData['tf_off_name'] = $this->input->post('officer_name');
									  $otherData['tf_off_sign'] = $imgname;
									   $formattedFrom = date('d/m/Y', strtotime($otherData['tf_release_date']));
										
									  $otherData['tf_release_date'] =  $formattedFrom;
									  $result=$this->common_model->insertTutionFee($otherData);
									break;
									case "2":
									/* Tution Fee Table Date */	
									
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
									  if($this->input->post('ocf_year') != "")
									  {
									    $otherData['ocf_year'] = $this->input->post('ocf_year');
									  }		
									  if($this->input->post('ocf_release_date') != "")
									  {
									    $otherData['ocf_release_date'] = $this->input->post('ocf_release_date');
									  }					  
									  if($this->input->post('ocf_amount') != "")
									  {
									    $otherData['ocf_amount'] = $this->input->post('ocf_amount');
									  }
									  if($this->input->post('ocf_mode') != "")
									  {
									    $otherData['ocf_mode'] = $this->input->post('ocf_mode');
									  }
									  if($this->input->post('ocf_cheq_no') != "")
									  {
									    $otherData['ocf_cheq_no'] = $this->input->post('ocf_cheq_no');
									  }							  
									  $otherData['ocf_off_name'] = $this->input->post('officer_name');
									  $otherData['ocf_off_sign'] = $imgname;
									  
									   $formattedFrom = date('d/m/Y', strtotime($otherData['ocf_release_date']));
										
									  $otherData['ocf_release_date'] =  $formattedFrom;
									  $result=$this->common_model->insertOCFee($otherData);
									break;
									case "3":
									/* Misce Table Date */	
									
										if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
										  if($this->input->post('uni_msc_item') != "")
										  {
										    $otherData['uni_msc_item'] = $this->input->post('uni_msc_item');
										  }
										  if($this->input->post('uni_msc_release_date') != "")
										  {
										    $otherData['uni_msc_release_date'] = $this->input->post('uni_msc_release_date');
										  }
										  if($this->input->post('uni_msc_amount') != "")
										  {
										    $otherData['uni_msc_amount'] = $this->input->post('uni_msc_amount');
										  }
										  if($this->input->post('uni_msc_mode') != "")
										  {
										    $otherData['uni_msc_mode'] = $this->input->post('uni_msc_mode');
										  }
										  if($this->input->post('uni_msc_cno') != "")
										  {
										    $otherData['uni_msc_cno'] = $this->input->post('uni_msc_cno');
										  }								  						  
										  $otherData['uni_msc_official_name'] = $this->input->post('officer_name');
										  $otherData['uni_msc_signature'] = $imgname;
										  
										   $formattedFrom = date('d/m/Y', strtotime($otherData['uni_msc_release_date']));
										
									      $otherData['uni_msc_release_date'] =  $formattedFrom;
										  
										  $result=$this->common_model->insertUniversityMiscellaneous($otherData);
									break;	
									case "4":
									/* Hostel Charges Table Date */		
										if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
										  if($this->input->post('hos_from') != "")
										  {
										    $otherData['hos_from'] = $this->input->post('hos_from');
										  }	
										  if($this->input->post('hos_to') != "")
										  {
										    $otherData['hos_to'] = $this->input->post('hos_to');
										  }								  
										  if($this->input->post('hos_amount') != "")
										  {
										    $otherData['hos_amount'] = $this->input->post('hos_amount');
										  }
										  if($this->input->post('hos_mode') != "")
										  {
										    $otherData['hos_mode'] = $this->input->post('hos_mode');
										  }
										  if($this->input->post('hos_cheq_no') != "")
										  {
										    $otherData['hos_cheq_no'] = $this->input->post('hos_cheq_no');
										  }							  
										  $otherData['hos_off_name'] = $this->input->post('officer_name');
										  $otherData['hos_off_sign'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['hos_from']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['hos_to']));
										  $otherData['hos_from'] =  $formattedFrom;
										  $otherData['hos_to'] =  $formattedTo;
										  $result=$this->common_model->insertHostelCharges($otherData);
									break;
									case "5":
									/* English Bridge Course Table Date */		

										if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
										  if($this->input->post('ebc_from_date') != "")
										  {
										    $otherData['ebc_from_date'] = $this->input->post('ebc_from_date');
										  }	
										  if($this->input->post('ebc_to_date') != "")
										  {
										    $otherData['ebc_to_date'] = $this->input->post('ebc_to_date');
										  }								  
										  if($this->input->post('ebc_amount') != "")
										  {
										    $otherData['ebc_amount'] = $this->input->post('ebc_amount');
										  }
										  if($this->input->post('ebc_mode') != "")
										  {
										    $otherData['ebc_mode'] = $this->input->post('ebc_mode');
										  }
										  if($this->input->post('ebc_cno') != "")
										  {
										    $otherData['ebc_cno'] = $this->input->post('ebc_cno');
										  }							  
										  $otherData['ebc_off_name'] = $this->input->post('officer_name');
										  $otherData['ebc_off_sign'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['ebc_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['ebc_to_date']));
										  $otherData['ebc_from_date'] =  $formattedFrom;
										  $otherData['ebc_to_date'] =  $formattedTo;
										  $result=$this->common_model->insertEnglishBridgeCourse($otherData);
									break;						
								}
						  	break;
						  	case "3":
						  		/* Travel Table Date */	
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
								  if($this->input->post('travel_type') != "")
								  {
								    $otherData['travel_type'] = $this->input->post('travel_type');
								  }
								  if($this->input->post('travel_amount') != "")
								  {
								    $otherData['travel_amount'] = $this->input->post('travel_amount');
								  }
								  if($this->input->post('travel_release_date') != "")
								  {
								    $otherData['travel_release_date'] = $this->input->post('travel_release_date');
								  }
								  if($this->input->post('travel_mode') != "")
								  {
								    $otherData['travel_mode'] = $this->input->post('travel_mode');
								  }
								  if($this->input->post('travel_cno') != "")
								  {
								    $otherData['travel_cno'] = $this->input->post('travel_cno');
								  }								  						  
								  $otherData['travel_official_name'] = $this->input->post('officer_name');
								  $otherData['travel_signature'] = $imgname;
								  
								  
								 $formattedFrom = date('d/m/Y', strtotime($otherData['travel_release_date']));
								 $otherData['travel_release_date'] =  $formattedFrom;
							
								  $result=$this->common_model->insertTravelCharges($otherData);
						  	break;
						  	case "4":
						  		/* Residential Permit Table Date */	
								
									if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
								  if($this->input->post('permit_no') != "")
								  {
								    $otherData['permit_no'] = $this->input->post('permit_no');
								  }
								  if($this->input->post('permit_from') != "")
								  {
								    $otherData['permit_from'] = $this->input->post('permit_from');
								  }
								  if($this->input->post('permit_to') != "")
								  {
								    $otherData['permit_to'] = $this->input->post('permit_to');
								  }
								  $permitfiles = $_FILES['permit_doc'];   
								  if($permitfiles["name"] != "")
								  {				
									  $name = str_replace(" ","_",$permitfiles['name']);
									  $permitname = $applicationId.'_'.time().'_permit_doc_'.$name;
									  
									  $target_file_permit = 'assets/site/main/permit_docs/'.$permitname; 
									  if (move_uploaded_file($_FILES["permit_doc"]["tmp_name"], $target_file_permit)) 
									  { 
									  	$otherData['permit_doc'] = $permitname;
									  }
									  else
									  {
									  	$otherData['permit_doc'] = "NO_DOC_UPLOADED";
									  }
								  }						  						  
								  $otherData['permit_off_name'] = $this->input->post('officer_name');
								  $otherData['permit_off_sign'] = $imgname;
								  
								  
								   $formattedFrom = date('d/m/Y', strtotime($otherData['permit_from']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['permit_to']));
										  $otherData['permit_from'] =  $formattedFrom;
										  $otherData['permit_to'] =  $formattedTo;
								  $result=$this->common_model->insertPermitDetails($otherData);
						  		
						  	break;
						  	case "5":
						  	/* welfare_filter */
						  		switch($welfare_filter)
						  		{
									case "1":
										  /* Orientation Programme */									  							  
										  if($this->input->post('op_from_date') != "")
										  {
										    $otherData['op_from_date'] = $this->input->post('op_from_date');
										  }
										  if($this->input->post('op_to_date') != "")
										  {
										    $otherData['op_to_date'] = $this->input->post('op_to_date');
										  }
										  if($this->input->post('op_amount') != "")
										  {
										    $otherData['op_amount'] = $this->input->post('op_amount');
										  }
										  if($this->input->post('op_mode') != "")
										  {
										    $otherData['op_mode'] = $this->input->post('op_mode');
										  }
										  if($this->input->post('op_cno') != "")
										  {
										    $otherData['op_cno'] = $this->input->post('op_cno');
										  }
										  $otherData['op_official_name'] = $this->input->post('officer_name');
										  $otherData['op_signature'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['op_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['op_to_date']));
										  $otherData['op_from_date'] =  $formattedFrom;
										  $otherData['op_to_date'] =  $formattedTo;
										  $result = $this->common_model->insertOrientationProgramme($otherData);
									break;							
									case "2":
									 /* Camps */									  							  
										   if($this->input->post('camps_from_date') != "")
										  {
										    $otherData['camps_from_date'] = $this->input->post('camps_from_date');
										  }
										  if($this->input->post('camps_to_date') != "")
										  {
										    $otherData['camps_to_date'] = $this->input->post('camps_to_date');
										  }
										  if($this->input->post('camps_amount') != "")
										  {
										    $otherData['camps_amount'] = $this->input->post('camps_amount');
										  }
										  if($this->input->post('camps_mode') != "")
										  {
										    $otherData['camps_mode'] = $this->input->post('camps_mode');
										  }
										  if($this->input->post('camps_cno') != "")
										  {
										    $otherData['camps_cno'] = $this->input->post('camps_cno');
										  }
										  $otherData['camps_official_name'] = $this->input->post('officer_name');
										  $otherData['camps_signature'] = $imgname;
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['camps_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['camps_to_date']));
										  $otherData['camps_from_date'] =  $formattedFrom;
										  $otherData['camps_to_date'] =  $formattedTo;
										  $result = $this->common_model->insertCamps($otherData);
									break;
									case "3":
										/* ISA Meeting */									  							  
										  if($this->input->post('isa_from_date') != "")
										  {
										    $otherData['isa_from_date'] = $this->input->post('isa_from_date');
										  }
										  if($this->input->post('isa_to_date') != "")
										  {
										    $otherData['isa_to_date'] = $this->input->post('isa_to_date');
										  }
										  if($this->input->post('isa_amount') != "")
										  {
										    $otherData['isa_amount'] = $this->input->post('isa_amount');
										  }
										  if($this->input->post('isa_mode') != "")
										  {
										    $otherData['isa_mode'] = $this->input->post('isa_mode');
										  }
										  if($this->input->post('isa_cno') != "")
										  {
										    $otherData['isa_cno'] = $this->input->post('isa_cno');
										  }
										  $otherData['isa_official_name'] = $this->input->post('officer_name');
										  $otherData['isa_signature'] = $imgname;
										  
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['isa_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['isa_to_date']));
										  $otherData['isa_from_date'] =  $formattedFrom;
										  $otherData['isa_to_date'] =  $formattedTo;
										  $result = $this->common_model->insertISAMeeting($otherData);
									break;
									case "4":
										/* Stumptuary Allowance */									  							  
										  if($this->input->post('sump_from_date') != "")
										  {
										    $otherData['sump_from_date'] = $this->input->post('sump_from_date');
										  }
										  if($this->input->post('sump_to_date') != "")
										  {
										    $otherData['sump_to_date'] = $this->input->post('sump_to_date');
										  }
										  if($this->input->post('sump_amount') != "")
										  {
										    $otherData['sump_amount'] = $this->input->post('sump_amount');
										  }
										  if($this->input->post('sump_mode') != "")
										  {
										    $otherData['sump_mode'] = $this->input->post('sump_mode');
										  }
										  if($this->input->post('sump_cno') != "")
										  {
										    $otherData['sump_cno'] = $this->input->post('sump_cno');
										  }
										  $otherData['sump_official_name'] = $this->input->post('officer_name');
										  $otherData['sump_signature'] = $imgname;	
										  $formattedFrom = date('d/m/Y', strtotime($otherData['sump_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['sump_to_date']));
										  $otherData['sump_from_date'] =  $formattedFrom;
										  $otherData['sump_to_date'] =  $formattedTo;
										  $result = $this->common_model->insertSumptuary($otherData);
									break;
									case "5":
										/* Emergancy Fund */	
										  if($this->input->post('ef_from_date') != "")
										  {
										    $otherData['ef_from_date'] = $this->input->post('ef_from_date');
										  }
										  if($this->input->post('ef_to_date') != "")
										  {
										    $otherData['ef_to_date'] = $this->input->post('ef_to_date');
										  }
										  if($this->input->post('ef_amount') != "")
										  {
										    $otherData['ef_amount'] = $this->input->post('ef_amount');
										  }
										  if($this->input->post('ef_mode') != "")
										  {
										    $otherData['ef_mode'] = $this->input->post('ef_mode');
										  }
										  if($this->input->post('ef_cno') != "")
										  {
										    $otherData['ef_cno'] = $this->input->post('ef_cno');
										  }
										  $otherData['ef_official_name'] = $this->input->post('officer_name');
										  $otherData['ef_signature'] = $imgname;
										  
										  
										  $formattedFrom = date('d/m/Y', strtotime($otherData['ef_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['ef_to_date']));
										  $otherData['ef_from_date'] =  $formattedFrom;
										  $otherData['ef_to_date'] =  $formattedTo;
										  $result = $this->common_model->insertEmergancyFund($otherData);
									break;
									case "6":
										/* Student Day */	
										  if($this->input->post('sd_from_date') != "")
										  {
										    $otherData['sd_from_date'] = $this->input->post('sd_from_date');
										  }
										  if($this->input->post('sd_to_date') != "")
										  {
										    $otherData['sd_to_date'] = $this->input->post('sd_to_date');
										  }
										  if($this->input->post('sd_amount') != "")
										  {
										    $otherData['sd_amount'] = $this->input->post('sd_amount');
										  }
										  if($this->input->post('sd_mode') != "")
										  {
										    $otherData['sd_mode'] = $this->input->post('sd_mode');
										  }
										  if($this->input->post('sd_cno') != "")
										  {
										    $otherData['sd_cno'] = $this->input->post('sd_cno');
										  }
										  $otherData['sd_official_name'] = $this->input->post('officer_name');
										  $otherData['sd_signature'] = $imgname;
										  
										  
										   $formattedFrom = date('d/m/Y', strtotime($otherData['sd_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['sd_to_date']));
										  $otherData['sd_from_date'] =  $formattedFrom;
										  $otherData['sd_to_date'] =  $formattedTo;
										  $result = $this->common_model->insertStudentDay($otherData);
									break;
									case "7":
									/* Day of National Importance */	
									  if($this->input->post('nd_from_date') != "")
									  {
									    $otherData['nd_from_date'] = $this->input->post('nd_from_date');
									  }
									  if($this->input->post('nd_to_date') != "")
									  {
									    $otherData['nd_to_date'] = $this->input->post('nd_to_date');
									  }
									  if($this->input->post('nd_amount') != "")
									  {
									    $otherData['nd_amount'] = $this->input->post('nd_amount');
									  }
									  if($this->input->post('nd_mode') != "")
									  {
									    $otherData['nd_mode'] = $this->input->post('nd_mode');
									  }
									  if($this->input->post('nd_cno') != "")
									  {
									    $otherData['nd_cno'] = $this->input->post('nd_cno');
									  }
									  $otherData['nd_official_name'] = $this->input->post('officer_name');
									  $otherData['nd_signature'] = $imgname;
									  
									   $formattedFrom = date('d/m/Y', strtotime($otherData['nd_from_date']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['nd_to_date']));
										  $otherData['nd_from_date'] =  $formattedFrom;
										  $otherData['nd_to_date'] =  $formattedTo;
									  $result = $this->common_model->insertNationalDay($otherData);
									break;
								}
						  	break;
						  	case "6":
						  		/* Bank Details Table Date */	
								if($this->input->post('fy_year') != "")
										  {
										    $otherData['fy'] = $this->input->post('fy_year');
										  }
								  if($this->input->post('bankname') != "")
								  {
								    $otherData['bankname'] = $this->input->post('bankname');
								  }
								  if($this->input->post('account_no') != "")
								  {
								    $otherData['account_no'] = $this->input->post('account_no');
								  }
								   if($this->input->post('ifsc_code') != "")
								  {
								    $otherData['ifsc_code'] = $this->input->post('ifsc_code');
								  }
								  $bankFiles = $_FILES['bank_doc'];   
								  if($bankFiles["name"] != "")
								  {				
									  $name = str_replace(" ","_",$bankFiles['name']);
									  $bankimgname = $applicationId.'_'.time().'_bank_doc_'.$name;
									  
									  $target_file_bank = 'assets/site/main/bank_docs/'.$bankimgname; 
									  if (move_uploaded_file($_FILES["bank_doc"]["tmp_name"], $target_file_bank)) 
									  { 
									  	$otherData['bank_doc'] = $bankimgname;
									  }
									  else
									  {
									  	$otherData['bank_doc'] = "NO_DOC_UPLOADED";
									  }
								  }						  						  
								  $otherData['bank_off_name'] = $this->input->post('officer_name');
								  $otherData['bank_off_sign'] = $imgname;					  
								  $result=$this->common_model->insertBankDetails($otherData);
						  	break;
						  	case "7":
						  		/* Ex-India Deductions Table Date */	
								  if($this->input->post('ded_from') != "")
								  {
								    $otherData['ded_from'] = $this->input->post('ded_from');
								  }
								  if($this->input->post('ded_to') != "")
								  {
								    $otherData['ded_to'] = $this->input->post('ded_to');
								  }
								  if($this->input->post('ded_mode') != "")
								  {
								    $otherData['ded_mode'] = $this->input->post('ded_mode');
								  }
								  if($this->input->post('ded_cheq_no') != "")
								  {
								    $otherData['ded_cheq_no'] = $this->input->post('ded_cheq_no');
								  }	
								  if($this->input->post('ded_amount') != "")
								  {
								    $otherData['ded_amount'] = $this->input->post('ded_amount');
								  }								  						  
								  $otherData['ded_off_name'] = $this->input->post('officer_name');
								  $otherData['ded_off_sign'] = $imgname;
								  
								  
								  $formattedFrom = date('d/m/Y', strtotime($otherData['ded_from']));
										  $formattedTo = date('d/m/Y', strtotime($otherData['ded_to']));
										  $otherData['ded_from'] =  $formattedFrom;
										  $otherData['ded_to'] =  $formattedTo;
								  $result=$this->common_model->insertDeductions($otherData);
						  	break;
					  }
					  if(count($this->common_model->ExpenditureExists($applicationId))<=0)
					  {
					     		
					  	 $result1 = $this->common_model->insertExpenditure($expenditureArray);
					  }
					  else
					  {
					  	//$result = $this->common_model->updateOldExpenditure($expenditureArray);
					  } 
					  
					if($result)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Expenditure Saved!');
						redirect(site_url().'regional/expenditureStatement');							
					}
					else
					{
						 $this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error Occur While Saving Expenditure!');
						redirect(site_url().'regional/dashboard');
					}	
			  	  
			  }
			  else
			  {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Signature!');
					redirect(site_url().'regional/dashboard');
			  }
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Signature!');
				redirect(site_url().'regional/dashboard');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Signature!');
			redirect(site_url().'regional/dashboard');
		}
	}
	public function universtiyLetter()
	{
		try
		{
			$imgname ="";
			$files = $_FILES['file'];      		
			$user_data = $this->session->userdata('user_data');		
			$regionid = $user_data['state'];	
			$applicatinNo =  $this->input->post("application_no");	
			$uniId =  $this->input->post("uniId");		
			$opt =  $this->input->post("opt");			
			
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = time().'_forwarded_Letter_'.$name;
			  
			  $target_file = 'assets/site/main/university_Forwarded_letter/'.$imgname; 
			  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 	
			  
			  		$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicatinNo);	
			  		if($regionid == $applicaitonStepOne[0]['university_choice_one_state'] && $applicaitonStepOne[0]['universty_choice'] == $uniId && $opt == 1)
			  		{
						$data = array(
				  			'uni_forwarded_letter' =>$imgname,
							'uni_forwarded_letter_date' =>time()
			  		 	);
					}
					elseif($regionid == $applicaitonStepOne[0]['university_choice_two_state'] && $applicaitonStepOne[0]['universty_choice_two'] == $uniId  && $opt == 2)
			  		{
						$data = array(
				  			'uni_forwarded_letter_two' =>$imgname,
							'uni_forwarded_letter_date_two' =>time()
			  		 	);
					}
					elseif($regionid == $applicaitonStepOne[0]['university_choice_three_state'] && $applicaitonStepOne[0]['universty_choice_three'] == $uniId  && $opt == 3)
			  		{
						$data = array(
				  			'uni_forwarded_letter_three' =>$imgname,
							'uni_forwarded_letter_date_three' =>time()
			  		 	);
					}
			  		
			  		$sts = $this->common_model->updateUniversityForwardedLetter($data,$applicatinNo);
			  	  if($sts)
			  	  {
				  	echo json_encode(array('status'=>TRUE, 'file_path'=> base_url().$target_file));
				  }	
				  else{
					echo json_encode(array('status'=>FALSE));
			 	 }		  
			  }
			  else{
					echo json_encode(array('status'=>FALSE));
			  }
			}
		}
		catch(Exception $e)
		{
		  	echo json_encode(array('status'=>FALSE));
		}
	}
	public function complaints()
    {
    	$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];		
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$data['complaints'] = $this->common_model->getRegionalComplaints($regionid);
		$data['region'] = $regionid;			
		$this->load->view('regional/header_regional');
		$this->load->view('regional/complaints',$data);
		$this->load->view('regional/footer');
	}
	public function new_applications()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];		
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['newApplication'] = $this->common_model->getRegionalApplications($regionid);
			$data['region'] = $regionid;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/new_applications',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	
	public function new_applicationsDemo()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];		
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			//$data['newApplication'] = $this->common_model->getRegionalApplications($regionid);
			$data['region'] = $regionid;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/new_applicationsDemo',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	//DEMO VIPIN
	
		public function new_applicationsDemoOne()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];		
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			//$data['newApplication'] = $this->common_model->getRegionalApplications($regionid);
			$data['region'] = $regionid;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/new_applicationsDemoOne',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function new_applications1()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];		
			$data['regionName'] = $this->common_model->getRegionById1($regionid);
			$data['newApplication'] = $this->common_model->getRegionalApplications1($regionid);
			$data['region'] = $regionid;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/new_applications1',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function regionalExpenditure()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['newApplication'] = $this->common_model->getRegionalApplications($regionid);
			$data['region'] = $regionid;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/new_applications',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function forwardtohqrs()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
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
			
			//$data= array(
            //'iccr_status' => 1,
           // 'status' => 10,
			//'iccr_status_date' =>time()
        //); 
			
			$data1 = array(
				'region_one_status'=>$regionid,
				'region_one_status_date'=>time(),
				'region_one_doc'=>$imgname,
				'regional_university'=> $this->input->post("regional_university"),
				'university_is_accept'=> $this->input->post("university_is_accept"),
				'application_id'=>$appno,
				'status'=>9,
				'is_gov_private'=>$this->input->post("is_gov_private"),
				'confirmed_course'=>$this->input->post("confirmedCourse"),
				'course'=>$this->input->post("course"),
				'institute_name'=>$this->input->post("institute_name")
				
			);		
			$stsUni = $this->common_model->alreadyApprovedUniversity($appno);	
			if(count($stsUni)>=0)
			{
				$sts = $this->common_model->ForwardToHqrs($data1,$appno);
                //$sts1 = $this->common_model->ConfirmationForwardToMissionByHqrs($data, $appno);				
				$applicationData = $this->common_model->getApplicationData($appno,0);
				$userdata = $this->common_model->getUserData($applicationData[0]['uid']);	
				if($sts)
				{
					$body = "We are pleased to inform you that you have been provisionally selected for award of scholarship to persue 2017 year\'s studies at Delhi University.<br/><br/>";
					//$mailsend = $this->sendMail($body,$userdata[0]['email_id'],"Your Application ".$appno." is approved for ICCR scholarship.","mail_not_process");
					$mailsend = TRUE;
					if($mailsend)
					{
						$mailsend1 = $this->sendMail($body,"diritc.iccr@gov.in","Application ".$appno." is confirmed at regional office.","mail_not_process");
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
						redirect(site_url().'regional/universityapplications');						
					}
					else
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
						redirect(site_url().'regional/universityapplications');							
					}
					 
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
					redirect(site_url().'regional/universityapplications');						
				}
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Already Approved By Other University!');
				redirect(site_url().'regional/universityapplications');				
			}		
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'nternal Server Error. Try After Some Time.');
			redirect(site_url().'regional/universityapplications');	
		}
	}
	public function universityapplications()
	{
		$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			
			$data['newApplication'] = $this->common_model->getRegionalPendingUniversityApplications($regionid);
			$data['region'] = $regionid;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/universityapplications',$data);
			$this->load->view('regional/footer');
	}
		public function universityapplications2()
	{
		$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			
			$data['newApplication'] = $this->common_model->getRegionalPendingUniversityApplications2($regionid);
			$data['region'] = $regionid;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/universityapplications',$data);
			$this->load->view('regional/footer');
	}
	public function forwardtouniversity()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$appno = $this->uri->segment(3);
			$statusno = $this->uri->segment(4);
			$col = 'university_status_'.$statusno;
			$data = array(
			$col=>1
			
			);
			$sts = $this->common_model->ForwardtoUniversity($appno,$data);	
			if($sts)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
				redirect(site_url().'regional/new_applicationsDemo');
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Forwarding Application!');
				redirect(site_url().'regional/new_applications');				
			}		
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Forwarding Application!');
			redirect(site_url().'regional/new_applications');	
		}
	}
	
		public function forwardtouniversity1()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$appno = $this->uri->segment(3);
			$statusno = $this->uri->segment(4);
			$col = 'university_status_'.$statusno;
			$data = array(
			$col=>1
			
			);
			$sts = $this->common_model->ForwardtoUniversity($appno,$data);	
			if($sts)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
				redirect(site_url().'regional/new_applicationsDemo');
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Forwarding Application!');
				redirect(site_url().'regional/new_applicationsDemo');				
			}		
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Forwarding Application!');
			redirect(site_url().'regional/new_applicationsDemo');	
		}
	}
	
	public function guidlines()
	{
		try{
			$this->load->view('regional/header_regional');
			$this->load->view('regional/regional_guidlines');
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function applicant_guidlines()
	{
		try{
			$this->load->view('regional/header_regional');
			$this->load->view('regional/applicant_guidlines');
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function mission_guidlines()
	{
		try{
			$this->load->view('regional/header_regional');
			$this->load->view('regional/mission_guidlines');
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function hqrs_guidlines()
	{
		try{
			$this->load->view('regional/header_regional');
			$this->load->view('regional/hqrs_guidlines');
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function instructions()
	{
		try{
			$this->load->view('regional/header_regional');
			$this->load->view('regional/instructions');
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	function expenditureReportofStudent()
	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$fy = $this->uri->segment(4);		
		$yearArray = explode('-',$fy);
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
		$data['bankDetails'] = $this->common_model->getBankingDetails($applicationId,"");
		$data['permitDetails'] = $this->common_model->getPermitDetails($applicationId,"");
		$data['academicDetails'] = $this->common_model->getAcademicDetailsDataforReport($applicationId);
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
		$data['mappingData'] = $this->common_model->getMappingData($applicationId);		
		
		$data['totalFund'] = $this->common_model->getTotalFundtoRegionbyFY($regionid,$fy);
		$this->load->view('regional/header_regional');		
		$this->load->view('regional/viewExpenditureDetailsofStudent',$data);
		$this->load->view('regional/footer');
	}
	function regionalExpenditureForOldUser()
	{
		try{	
		
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];		
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			if($applicationId == NULL || $applicationId == "")
			{
				$applicationId = $this->random_num(15);
			}	
			else
			{
				$applicationId = $this->uri->segment(3);
			}	
			$data['expeditureDetails'] = $this->common_model->getExpenditureDetails($applicationId);
			$data['getBankingDetails'] = $this->common_model->getBankingDetails($applicationId,"old");
			$data['getPermitDetails'] = $this->common_model->getPermitDetails($applicationId,"old");
			$data['getAdvanceStipendDetails'] = $this->common_model->getAdvanceStipendDetails($applicationId,"old");
			$data['getStipendDetails'] = $this->common_model->getStipendDetails($applicationId,"old");
			$data['getHRADetails'] = $this->common_model->getHRADetails($applicationId,"old");
			$data['getACADetails'] = $this->common_model->getACADetails($applicationId,"old");
			$data['getStudyTourDetails'] = $this->common_model->getStudyTourDetails($applicationId,"old");
			$data['getMedicalReimbursDetails'] = $this->common_model->getMedicalReimbursDetails($applicationId,"old");
			$data['getThesisChargesDetails'] = $this->common_model->getThesisChargesDetails($applicationId,"old");
			$data['getMiscDetails'] = $this->common_model->getMiscDetails($applicationId,"old");
			$data['getHostelDetails'] = $this->common_model->getHostelDetails($applicationId,"old");
			$data['getTutionFeeDetails'] = $this->common_model->getTutionFeeDetails($applicationId,"old");
			$data['getOCFDetails'] = $this->common_model->getOCFDetails($applicationId,"old");
			$data['getMiscellaneousUniversityDetails'] = $this->common_model->getMiscellaneousUniversityDetails($applicationId,"old");
			$data['getTravalDetails'] = $this->common_model->getTravalDetails($applicationId,"old");
			$data['getDeductionDetails'] = $this->common_model->getDeductionDetails($applicationId,"old");
			
			/* New Adding */
			$data['getOrientationDetails'] = $this->common_model->getOrientationDetails($applicationId,"old");
			$data['getCampsDetails'] = $this->common_model->getCampsDetails($applicationId,"old");
			$data['getISADetails'] = $this->common_model->getISADetails($applicationId,"old");
			$data['getSumptuaryDetails'] = $this->common_model->getSumptuaryDetails($applicationId,"old");
			$data['getEmergencyFundDetails'] = $this->common_model->getEmergencyFundDetails($applicationId,"old");
			$data['getStudentDayDetails'] = $this->common_model->getStudentDayDetails($applicationId,"old");
			$data['getEnglishBridgeCourseDetails'] = $this->common_model->getEnglishBridgeCourseDetails($applicationId,"old");
			$id = $data['expeditureDetails'][0]['programme'];
			
			
			
			$current = $data['expeditureDetails'][0]['duration_from'];//date($data['expeditureDetails'][0]['duration_from'].'-m-d');
			$to = $data['expeditureDetails'][0]['duration_to'];
			$v = abs($data['expeditureDetails'][0]['duration_from']-$to); 		
			$v = $v + $v;
			
			
			
			//$current = date('Y-m-d');
	   		$current1 = date('Y-m-d',strtotime('-2 years'));
			if($id == 1 || $id == 5 || $id == 6 || $id == 7)
	   		{	   			
				$financial = $this->getFinancialYearsFromBased($current,$v);
				$acaYears =  $this->getFinancialYearsOnly($current1,6);
			}  
			if($id == 2)
	   		{	   			
				$financial = $this->getFinancialYearsFromBased($current,$v);
				$acaYears =  $this->getFinancialYearsOnly($current1,2);
			}
			if($id == 3)
	   		{	   			
				$financial = $this->getFinancialYearsFromBased($current,$v);
				$acaYears =  $this->getFinancialYearsOnly($current1,1);
			} 
			if($id == 4)
	   		{	   			
				$financial = $this->getFinancialYearsFromBased($current,$v);	
				$acaYears =  $this->getFinancialYearsOnly($current1,3);			
			}
			if($id == 8)
	   		{	   			
				$financial = $this->getFinancialYearsFromBased($current,$v);
				$acaYears =  $this->getFinancialYearsOnly($current1,1);
			}	
			$data['financial'] = $financial;
			$data['acayears'] = $acaYears;	
			$data['uni'] = $schemeId[0]['regional_university'];
			$data['expenditure_year'] = $this->getAllFinancialYear();
			$frm = date('2008-1-1');
			
			$data['fy'] = $this->getFinancialYears($frm,1);
			$data['oldappno'] = $applicationId;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/expenditureolduser',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function getExpenditureDetails()
    {
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$schemmesArray = array();
		$regionalArray = array();
		$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];	
		$allAppId = $this->common_model->getAllExpenditureAppId();
		$allSchemes = $this->common_model->getAllSchemes();
		$allregions = $this->common_model->getAllRegions();
		$fy = $clean["fy"];
		$schemes = $clean["schemes"];
		$region = $regionid;
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
	function regionalExpenditureUser()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];		
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['regionId']=$regionid;
			$applicationId = $this->uri->segment(3);
			$data['appno'] = $applicationId;
			$data['expeditureDetails'] = $this->common_model->getExpenditureDetails($applicationId);
			$data['getBankingDetails'] = $this->common_model->getBankingDetails($applicationId,"New");
			$data['getPermitDetails'] = $this->common_model->getPermitDetails($applicationId,"New");
			$data['getStipendDetails'] = $this->common_model->getStipendDetails($applicationId,"New");
			$data['getHRADetails'] = $this->common_model->getHRADetails($applicationId,"New");
			$data['getACADetails'] = $this->common_model->getACADetails($applicationId,"New");
			$data['getStudyTourDetails'] = $this->common_model->getStudyTourDetails($applicationId,"New");
			$data['getMedicalReimbursDetails'] = $this->common_model->getMedicalReimbursDetails($applicationId,"New");
			$data['getThesisChargesDetails'] = $this->common_model->getThesisChargesDetails($applicationId,"New");
			$data['getMiscDetails'] = $this->common_model->getMiscDetails($applicationId,"New");
			$data['getHostelDetails'] = $this->common_model->getHostelDetails($applicationId,"New");
			$data['getTutionFeeDetails'] = $this->common_model->getTutionFeeDetails($applicationId,"New");
			$data['getOCFDetails'] = $this->common_model->getOCFDetails($applicationId,"New");
			$data['getMiscellaneousUniversityDetails'] = $this->common_model->getMiscellaneousUniversityDetails($applicationId,"New");
			$data['getTravalDetails'] = $this->common_model->getTravalDetails($applicationId,"New");
			$data['getDeductionDetails'] = $this->common_model->getDeductionDetails($applicationId,"New");
			
			/* New Adding */
			$data['getOrientationDetails'] = $this->common_model->getOrientationDetails($applicationId,"New");
			$data['getCampsDetails'] = $this->common_model->getCampsDetails($applicationId,"New");
			$data['getISADetails'] = $this->common_model->getISADetails($applicationId,"New");
			$data['getSumptuaryDetails'] = $this->common_model->getSumptuaryDetails($applicationId,"New");
			$data['getEmergencyFundDetails'] = $this->common_model->getEmergencyFundDetails($applicationId,"New");
			$data['getStudentDayDetails'] = $this->common_model->getStudentDayDetails($applicationId,"New");
			$data['getNationalDayDetails'] = $this->common_model->getNationalDayDetails($applicationId,"New");
			$data['getEnglishBridgeCourseDetails'] = $this->common_model->getEnglishBridgeCourseDetails($applicationId,"New");
			
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			
			$id = $data['applicaitonStepOne'][0]['programme'];
			
			$duration = $this->common_model->getCourseDurationFromAcademicDetails($applicationId);
			$current = date($duration[0]['course_duration_from'].'-m-d');
			$to = $duration[0]['course_duration_to'];
			$v = abs($duration[0]['course_duration_from']-$to); 		
			$v = $v + $v;
			
			
			$current = date('Y-m-d',strtotime('-2 years'));
	   		$current1 = date('Y-m-d',strtotime('-1 years'));
			if($id == 1 || $id == 5 || $id == 6 || $id == 7)
	   		{	   			
				$financial = $this->getFinancialYears($current,$v);
				$acaYears =  $this->getFinancialYearsOnly($current1,6);
			}  
			if($id == 2)
	   		{	   			
				$financial = $this->getFinancialYears($current,$v);
				$acaYears =  $this->getFinancialYearsOnly($current1,2);
			}
			if($id == 3)
	   		{	   			
				$financial = $this->getFinancialYears($current,$v);
				$acaYears =  $this->getFinancialYearsOnly($current1,1);
			} 
			if($id == 4)
	   		{	   			
				$financial = $this->getFinancialYears($current,$v);	
				$acaYears =  $this->getFinancialYearsOnly($current1,3);			
			}
			if($id == 8)
	   		{	   			
				$financial = $this->getFinancialYears($current,$v);
				$acaYears =  $this->getFinancialYearsOnly($current1,1);
			}
			
			$data['financial'] = $financial;
			$data['acayears'] = $acaYears;	
			$data['visadata'] = $this->common_model->getVisaData($applicationId);
			$data['visadataRO'] = $this->common_model->getVisaDataRo($applicationId);
			$country = $this->common_model->getCountryById($data['applicaitonStepOne'][0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$data['schemeId'] = $schemeId[0]['scholarship_id'];
			$data['code'] = $schemename[0]['code'];
			$data['uni'] = $schemeId[0]['regional_university'];
			$data['arrival'] = $schemeId[0]['travel_arrival_date'];
			$data['joining_date'] = $schemeId[0]['joining_date'];
			$data['completion_date'] = $schemeId[0]['completion_date'];
			$data['expenditure_year'] = $this->getAllFinancialYear();
			$this->load->view('regional/header_regional');
			$this->load->view('regional/expenditure',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	function downloadExpenditure()
	{
		$applicationId = $this->uri->segment(3);		
		$rs = $this->common_model->getExpeditureData($applicationId);
	    $mpdata = $this->common_model->getMappingData($applicationId);
	    $onedata = $this->common_model->getApplicationStepOneByAppno($applicationId);
	    $threedata = $this->common_model->getApplicationStepThreeByAppno($applicationId);
	   // print_r($threedata);
		$univ = $this->common_model->getUniversityById($mpdata[0]['regional_university']);
		$country = $this->common_model->getCountryById($threedata[0]['application_through']);
		$scheme = $this->common_model->getSchemeById($mpdata[0]['scholarship_id']);
		
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Expenditure '.$applicationId);
        //set cell A1 content with some text
        
        $this->excel->getActiveSheet()->setCellValue('A7', 'Date');      
            
        $this->excel->getActiveSheet()->setCellValue('B7', 'Cash/Cheque');
		$this->excel->getActiveSheet()->setCellValue('C7', 'Period');
		$this->excel->getActiveSheet()->setCellValue('D7', 'Stipend');
		$this->excel->getActiveSheet()->setCellValue('E7', 'HRA/Hostel');
		$this->excel->getActiveSheet()->setCellValue('F7', 'ACA');
		$this->excel->getActiveSheet()->setCellValue('G7', 'TF');
		$this->excel->getActiveSheet()->setCellValue('H7', 'OCF');
		$this->excel->getActiveSheet()->setCellValue('I7', 'Study Tour');
		$this->excel->getActiveSheet()->setCellValue('J7', 'Misc.');
		$this->excel->getActiveSheet()->setCellValue('K7', 'Deductions');
		$this->excel->getActiveSheet()->setCellValue('L7', 'Total');
		
        //merge cell A1 until C1
         $crs = $this->common_model->getCoursesById($onedata[0]['course']);
        
        $this->excel->getActiveSheet()->getCell('A1')->setValue('Name of the Student : ' .$onedata[0]['fullname']);
        $this->excel->getActiveSheet()->getCell('A2')->setValue('Bank Account Number : ' .$rs[0]['account_no']);
        $this->excel->getActiveSheet()->getCell('A3')->setValue('University : ' .$univ[0]['name']);
        $this->excel->getActiveSheet()->getCell('L3')->setValue('File No: 260');
        $this->excel->getActiveSheet()->getCell('A4')->setValue('Country : ' .$country[0]['country_name']);
        $this->excel->getActiveSheet()->getCell('L4')->setValue('Scheme: '.$scheme[0]['scheme_name']);
         $this->excel->getActiveSheet()->getCell('A5')->setValue('Course : ' .$crs[0]['title'] );
        $this->excel->getActiveSheet()->getCell('L5')->setValue('Dr. of Course: '.$rs[0]['duration_from'].' to '.$rs[0]['duration_to']);
         $this->excel->getActiveSheet()->getCell('A6')->setValue('Dt. of arr. :' .$mpdata[0]['travel_arrivaldate']);
         $this->excel->getActiveSheet()->mergeCells('A1:L1');
         $this->excel->getActiveSheet()->mergeCells('A2:L2');
        $this->excel->getActiveSheet()->mergeCells('A3:K3');
        $this->excel->getActiveSheet()->mergeCells('A4:K4');
        $this->excel->getActiveSheet()->mergeCells('A5:K5');
        $this->excel->getActiveSheet()->mergeCells('A6:L6');
        
         $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         
        $border_style= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style1= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style2= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $border_style3= array('borders' => array('right' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '00FFFFFF'),)));
        $this->excel->getActiveSheet()->getStyle("A3:K3")->applyFromArray($border_style);
        //$this->excel->getActiveSheet()->getStyle("K1:L1")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A3:K3")->applyFromArray($border_style1);
        $this->excel->getActiveSheet()->getStyle("K3:L3")->applyFromArray($border_style1);
        
        $this->excel->getActiveSheet()->getStyle("A4:K4")->applyFromArray($border_style);
       // $this->excel->getActiveSheet()->getStyle("K2:L2")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A4:K4")->applyFromArray($border_style1);
        $this->excel->getActiveSheet()->getStyle("K4:L4")->applyFromArray($border_style1);
        
         $this->excel->getActiveSheet()->getStyle("A5:K5")->applyFromArray($border_style);
       // $this->excel->getActiveSheet()->getStyle("K3:L3")->applyFromArray($border_style);
        $this->excel->getActiveSheet()->getStyle("A5:K5")->applyFromArray($border_style1);
        $this->excel->getActiveSheet()->getStyle("K5:L5")->applyFromArray($border_style1);
        
        $this->excel->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
for($col = ord('A'); $col <= ord('L'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
         //change the font size
        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
         
        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}
        
        $exceldata="";
		foreach ($rs as $row)
		{
			$total = 0;
			$total = $row['stipend_rate'] + $row['hra_rate'] + $row['aca'] + $row['tf'] + $row['ocf'] + $row['misc_amount'];
			$myarray = array('Date'=>$row['expenditure_date'],'payment_mode'=>$row['payment_mode'],'Period'=>$row['duration_from']." To ".$row['duration_from'],'Stipend'=>$row['stipend_rate'],'HRA/Hostel'=>$row['hra_rate'],'ACA'=>$row['aca'],'TF'=>$row['tf'],'OCF'=>$row['ocf'],'study_tour_date'=>$row['study_tour_date'].'-'.$row['study_tour_to_date'],'Misc'=>$row['misc_amount'],"Deductions"=>0,"total"=>$total);		
			$exceldata[] = $myarray;
	
		}	
		//$myarray = array('Date'=>'18/7/16','Cheque/Cash'=>'Cash','Period'=>'June to Aug 16','Stipend'=>'2000','HRA/Hostel'=>'3500','ACA'=>'2000','TF'=>'2000','OCF'=>'3000','Misc'=>'0','HRA Deduction'=>'2000','Ex-India'=>'0','Total'=>'14500');
//$myarray1 = array('Date'=>'18/7/16','Cheque/Cash'=>'Cash','Period'=>'June to Aug 16','Stipend'=>'2000','HRA/Hostel'=>'3500','ACA'=>'2000','TF'=>'2000','OCF'=>'3000','Misc'=>'0','HRA Deduction'=>'2000','Ex-India'=>'0','Total'=>'14500');

//$exceldata[] = $myarray;
//$exceldata[] = $myarray1;	
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A8');
         
        $this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                
        $this->excel->getActiveSheet()->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
         
        $filename= $applicationId.'_Expenditure_'.date('d-M-Y-h-i-s').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
    function forwardjoiningtoHqrs()
    {
		
	}
	function forwardjoiningreport()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['region'] = $regionid;
			$data['forwardjoiningreport'] = $this->common_model->getRegionalApplicationsForwardtoHqrs($regionid);	
			$this->load->view('regional/header_regional');
			$this->load->view('regional/forwardjoiningreport',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	function expenditure()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['region'] = $regionid;
			$data['appno'] = $regionid;
			$data['forwardjoiningreport'] = $this->common_model->getRegionalApplicationsForwardtoHqrs($regionid);	
			$this->load->view('regional/header_regional');
			$this->load->view('regional/expenditure',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	function forwardtohqrslist()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['region'] = $regionid;
			$data['forwardedtohqrs'] = $this->common_model->getRegionalApplicationsForwardtoHqrs($regionid);	
			$this->load->view('regional/header_regional');
			$this->load->view('regional/forwardtohqrs',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function scholarNotArrived()
	{
		try
		{
			$appno = $this->uri->segment(3);
			$data = array(			
			'status'=>-14
			);
			$sts = $this->common_model->scholarArrived($appno,$data);	
			if($sts)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Scholar Arrivel Status Updated!');
				redirect(site_url().'regional/scholararrival');	
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Updataion of Scholar Arrival Status!');
				redirect(site_url().'regional/scholararrival');					
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updataion of Scholar Arrival Status!');
			redirect(site_url().'regional/scholararrival');	
		}
	}
	public function scholarArrived()
	{
		try
		{
			$appno = $this->uri->segment(3);
			$data = array(			
			'status'=>14
			);
			$sts = $this->common_model->scholarArrived($appno,$data);	
			if($sts)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Scholar Arrived!');
				redirect(site_url().'regional/scholararrival');					
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Updataion of Scholar Arrival Details!');
				redirect(site_url().'regional/scholararrival');					
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updataion of Scholar Arrival Details!');
			redirect(site_url().'regional/scholararrival');	
		}
	}
	function updateArrivalStatus()
	{
		try
		{
			$appno = $this->uri->segment(3);
			
			$status = $this->input->post('arrival_status');
			$dateRo = $this->input->post('travel_arrival_date');
			$travelId = $this->input->post('travelId');
			$stss = 0;
			if($status == '1')
			{
				$stss = 14;
				$dateRo = $this->input->post('travel_arrival_date');
			}
			elseif($status == '2')
			{
				$stss = -14;
				$dateRo = '';
			}
			$data1 = array(			
				'status'=>$stss,
				'arrival_date_ro'=>$dateRo
			);
			$sts1 = $this->common_model->scholarArivalStatusUpdate($appno,$data1,$travelId);	
			$data = array(			
			'status'=>$stss
			);
			$sts = $this->common_model->scholarArrived($appno,$data);	
			
			if($sts)
			{			
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Scholar Arrival Detail Updated!');
				redirect(site_url().'regional/scholararrival');							
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Updataion of Scholar Arrival Details!');
				redirect(site_url().'regional/scholararrival');					
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updataion of Scholar Arrival Details!');
			redirect(site_url().'regional/scholararrival');	
		}
	}
	function scholarArrivedstatusView()
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
		$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
		if(count($imgArray)> 0)
		{
			$image = $imgArray[0]['name'];
		}		
		else
		{
			$image = '';
		}
		$data['regionId'] =  $user_data['state'];	
		$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
		$data['userImage'] = $image;
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();	
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
		$data['mappingData'] = $this->common_model->getMappingData($applicationId);
		$data['universityData'] = $this->common_model->getconfirmationData($applicationId);
		$data['travelplan'] = $this->common_model->getAllTravelPlan($applicationId);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/scholarArrivedstatusView',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	function scholarArrivedstatus()
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
		$imgArray = $this->common_model->getUserImage($data['applicaitonStepOne'][0]['uid']);		
		if(count($imgArray)> 0)
		{
			$image = $imgArray[0]['name'];
		}		
		else
		{
			$image = '';
		}
		$data['regionId'] =  $user_data['state'];	
		$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
		$data['userImage'] = $image;
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();	
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
		$data['mappingData'] = $this->common_model->getMappingData($applicationId);
		$data['universityData'] = $this->common_model->getconfirmationData($applicationId);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/scholarArrivedstatus',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	function scholararrival()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			//$data['travel'] = $this->common_model->getRegionalTravelApplication($regionid);
			$data['travel'] = $this->common_model->getApplicationIdsofTravel($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/scholararrival',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	function scholararrivalDemo()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			//$data['travel'] = $this->common_model->getRegionalTravelApplication($regionid);
			//$data['travel'] = $this->common_model->getApplicationIdsofTravel($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/scholararrivalDemo',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	function uploadbonafide()
	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$data['appno'] = $applicationId;	
		$regionid = $user_data['state'];
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$this->load->view('regional/header_regional');
		$this->load->view('regional/uploadbonafide',$data);
		$this->load->view('regional/footer');
		
	}
	function uploadresidentialpermit()
	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$data['appno'] = $applicationId;
		$regionid = $user_data['state'];
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$this->load->view('regional/header_regional');
		$this->load->view('regional/uploadpolicedoc',$data);
		$this->load->view('regional/footer');
	}
	function uploadjoiningreport()
	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$data['appno'] = $applicationId;
		$regionid = $user_data['state'];
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$this->load->view('regional/header_regional');
		$this->load->view('regional/uploadjoiningreport',$data);
		$this->load->view('regional/footer');
	}
	function createJoining()
	{
		try
		{
			$applicationId = $this->uri->segment(3);	
			$files = $_FILES['joining_doc'];   
			$imgname ="";$data = array();
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = $applicationId.'_'.time().'_joining_doc_'.$name;
			  $target_file = 'assets/site/main/joining_doc/'.$imgname; 
			 
			  if(move_uploaded_file($_FILES["joining_doc"]["tmp_name"], $target_file)) 
			  {
			  	$data['joining_doc'] = $imgname;
			  	$data['joining_date'] = $_POST['joining_date'];
			  	$data['completion_date'] = $_POST['completion_date'];
			  	$sts = $this->common_model->insertJoiningDocument($applicationId,$data);
			  	if($sts)
			  	{
			  		$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Joining Report Uploaded!');
					redirect(site_url().'regional/issueDocuments');						
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Uploading Joining Report!');
					redirect(site_url().'regional/issueDocuments');	
					
				}
			  }
			  else
			  {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Uploading Joining Report!');
					redirect(site_url().'regional/issueDocuments');	
			  }
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Uploading Joining Report!');
			redirect(site_url().'regional/issueDocuments');	
		}
	}
	function createPolicedoc()
	{
		try
		{
			$applicationId = $this->uri->segment(3);	
			$files = $_FILES['police_doc'];   
			$imgname ="";$data = array();
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = $applicationId.'_'.time().'_police_doc_'.$name;
			  
			  $target_file = 'assets/site/main/police_doc/'.$imgname; 
			  if(move_uploaded_file($_FILES["police_doc"]["tmp_name"], $target_file)) 
			  {
			  	$data['police_doc'] = $imgname;
			  	$sts = $this->common_model->insertPoliceDocument($applicationId,$data);
			  	if($sts)
			  	{
			  		$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', ' Police Certificate Updated!');
					redirect(site_url().'regional/issueDocuments');						
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Uploading Police Certificate!');
					redirect(site_url().'regional/issueDocuments');						
				}
			  }
			  else
			  {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Uploading Police Certificate!');
					redirect(site_url().'regional/issueDocuments');			
			  }
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Uploading Police Certificate!');
			redirect(site_url().'regional/issueDocuments');		
		}
	}
	function createBonafide()
	{
		try
		{
			$applicationId = $this->uri->segment(3);	
			$files = $_FILES['bonafide_doc'];   
			$imgname ="";$data = array();
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = $applicationId.'_'.time().'_bonafile_doc_'.$name;
			  
			  $target_file = 'assets/site/main/bonafide_doc/'.$imgname;
 			  
			  if(move_uploaded_file($_FILES["bonafide_doc"]["tmp_name"], $target_file)) 
			  {
			  	$data['bonafide_doc'] = $imgname;
			  	$sts = $this->common_model->insertBonafideDocument($applicationId,$data);
			  	if($sts)
			  	{
			  		$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Bonafide Certificate Uploaded!');
					redirect(site_url().'regional/issueDocuments');						
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Status Error Occur While Uploading Bonafide Certificate!');
					redirect(site_url().'regional/issueDocuments');						
				}
			  }
			  else
			  {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Permission Error Occur While Uploading Bonafide Certificate!');
				redirect(site_url().'regional/issueDocuments');		
			  }
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Server Error Occur While Uploading Bonafide Certificate!');
			redirect(site_url().'regional/issueDocuments');	
		} 
	}
	function issueDocuments()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['travel'] = $this->common_model->getRegionalReceivedApplication($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/issueDocuments',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}	
	
	function issueDocumentsDemo()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			//$data['travel'] = $this->common_model->getRegionalReceivedApplication($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/issueDocuments1',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	public function getBonafide() {
    
			
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			
			$vars = $this->input->post();
			$no = $_POST['start'];
		    $result = $this->common_model->getDocumentDetails($vars,$regionid);
			//echo "<pre>";
			//print_r($result);die;
		    $totalResult = $this->common_model->getTotalDocumentDetails($vars,$regionid);
			//echo "<pre>";
			//print_r($totalResult);die;
            $response = array();
			if(!empty($result))
			{
			
			
			foreach($result as $r)
			{
				$no++;
				$output= array();	
				$output[] = $no;
				$output[] = $r['fullname'];
				$output[] = $r['email'];
				$course = $this->common_model->getCoursesById($r['course']);
				$output[] = $course[0]['title'];
				$uni = $this->common_model->getSchemeById($r['scholarship_id']);
				$output[] = $uni[0]['scheme_name'];
				$data = $this->common_model->getConfirmationofApplicationIds($r['application_no']);
				$uni = $this->common_model->getUniversityById($data[0]->regional_university);
				$output[] =  $uni[0]['name'];				
				$output[] = $r['country_name'];
				$bonafide = $this->common_model->getRegionalBonafideDoc($r['application_no']);
				//echo "<pre>";
				//print_r($bonafide);die;
						$dwnldDetails = '';
						
						$dwnldpermitDetails = '';
						$dwnldjoiningDetails = '';
						$upload = '';
						$uploadpermit = '';
						$downldpermit = '';
						$uploadjoinning = '';
						$downldjoining = '';
						foreach($bonafide as $bn) {
							
						if($bn['bonafide_doc'] != "")
						{
							$downld = '<a download href="'.site_url().'assets/site/main/bonafide_doc/'.$bn['bonafide_doc'].'" target ="__blank">Download</a></br>';
							/* $downld2 = "<a href='#'  onclick=updateId('".$r['application_no']."','".$r['universty_choice_two']."','".$optionNo."'); data-toggle='modal' class='form-control sbmt' data-target='#universtiyLetterdiv'>Upload</a>"; */
						}
						}
						
						
						
						$upload = '<a href="'.site_url().'regional/uploadbonafide/'.$r['application_no'].'" class="form-control sbmt">Upload</a>';
						if($r['bonafide_doc']){
							$downld = '<a download href="'.site_url().'assets/site/main/bonafide_doc/'.$r['application_no'].'" target = "__blank">Download</a></br>';
						}
						$dwnldDetails .= $downld.'<br/>';
						$output[] = $dwnldDetails.$upload;
						
						if($r['police_doc'] != "")
						{
							$downldpermit = '<a download href="'.site_url().'assets/site/main/police_doc/'.$r['police_doc'].'" target = "__blank">Download</a></br>';
						}
						else
						{
							$uploadpermit = '<a href="'.site_url().'regional/uploadresidentialpermit/'.$r['application_no'].'" class="form-control sbmt">Upload</a>';
							
						}
                       
						
						
						$dwnldpermitDetails .= $downldpermit.'<br/>';
						$output[] = $dwnldpermitDetails.$uploadpermit;
						
							if($r['joining_doc'] != "")
						{
							$downldjoining = '<a href="'.site_url().'assets/site/main/joining_doc/'.$r['joining_doc'].'" taget = "__blank">Download</a></br>';
						}
						else
						{
							$uploadjoining = '<a href="'.site_url().'regional/uploadjoiningreport/'.$r['application_no'].'" class="form-control sbmt">Upload</a>';
							
						}
						$dwnldjoiningDetails .= $downldjoining.'<br/>';
						$output[] = $dwnldjoiningDetails.$uploadjoining; 
                        $response[] = $output;
				        
			
			}
			}
			$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
			$returnJson['recordsTotal'] = $totalResult[0]['total'];
			$returnJson['recordsFiltered'] = $totalResult[0]['total'];
			$returnJson['data'] = $response;
			echo json_encode($returnJson);
			
			
    }
	
	public function getAcademicDetails() {
    
			
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$vars = $this->input->post();
			$no = $_POST['start'];
		    $result = $this->Regional_model->getRegionalExpenditure($vars,$regionid);
		    $totalResult = $this->Regional_model->getRegionalTotalExpenditure($vars,$regionid);
            $response = array();
			if(count($result)>0)
			{
			foreach($result as $r)
			{
				
				$no++;
				$output= array();	
				$output[] = $no;
				$output[] = $r['fullname'];
				$output[] = $r['country_name'];
			    $corse = $this->common_model->getCoursesById($r['course']);
			    $output[] = $corse[0]['title'];	
				$uname ="";		
				$data = $this->common_model->getConfirmationofApplicationIds($r['application_no']);
				$uni = $this->common_model->getUniversityById($data[0]->regional_university);
				$output[] = $uni[0]['name'];
				
				$travelpl = $this->common_model->getTravelPlan($r['application_no']);
							if($travelpl[0]['arrival_date_ro'] != "")
							{
								$output[] = $travelpl[0]['arrival_date_ro'];
							}else{
								$output[] = '';
							}
				
				$uploadaAcdemic = '<a class="form-control sbmt" style="height:35px;width:140px;" href="'.site_url().'regional/addcurrentAcademicDetails/'.$r['application_no'].'" class="form-control sbmt" target = "__blank">Update Details</a>';		
						$output[] = $uploadaAcdemic;
                        $response[] = $output;        
			
			}
			}
			$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
			$returnJson['recordsTotal'] = $totalResult[0]['total'];
			$returnJson['recordsFiltered'] = $totalResult[0]['total'];
			$returnJson['data'] = $response;
			echo json_encode($returnJson);
			
			
    }
	public function getExpenditure() {
    
			
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$vars = $this->input->post();
			$no = $_POST['start'];
		    $result = $this->Regional_model->getRegionalExpenditure($vars,$regionid);
			//echo "<pre>";
			//print_r($result);die;
		    $totalResult = $this->Regional_model->getRegionalTotalExpenditure($vars,$regionid);
			$quarterbalance = $this->getCurrentQuarterFundDetails();
			//echo "<pre>";
			//print_r($result);die;
            $response = array();
			if(count($result)>0)
			{
			foreach($result as $r)
			{
				$no++;
				$output= array();	
				$output[] = $no;
				$output[] = $r['application_no'];
				$output[] = $r['email'];
				$output[] = $r['ref_no'];
				$output[] = $r['fullname'];
				$data = $this->common_model->getConfirmationofApplicationIds($r['application_no']);
				$uni = $this->common_model->getUniversityById($data[0]->regional_university);
				$output[] = $uni[0]['name'];
				$output[] = $r['country_name'];
				$travelpl = $this->common_model->getTravelPlan($r['application_no']);
				if($travelpl[0]['arrival_date_ro'] != "")
				{
					$output[] = $travelpl[0]['arrival_date_ro'];
				}else{
					
					$output[] = '';
				}	
				
				
				$uni = $this->common_model->getSchemeById($r['scholarship_id']);			
				
						$uploadpermit = '';
									
						$status = $this->common_model->getScholarshipStatusofApplicant($r['application_no']);
						
						if(count($status) <= 0)
						{
							if(count($quarterbalance)>0)
							{
						
							
							$uploadpermit = '<a class="form-control sbmt" style="height:35px;width:140px;" href="'.site_url().'regional/regionalExpenditureUser/'.$r['application_no'].'" class="form-control sbmt" target = "__blank">Payment Details</a>';
							
							
							
							
							
						
							}
							else
							{
								
								
								$uploadpermit = '<a class="form-control sbmt" style="height:35px;width:140px;" href="'.site_url().'regional/regionalExpenditureUser/'.$r['application_no'].'" class="form-control sbmt" target = "__blank">Payment Details</a>';
								
								


						
							}
						}
					
						elseif(count($status)>0)
						{
							if($status[0]['scholarship_status'] == 2)
							{
								
							$output[] ='<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Detained"/>';
						
								
							}
							elseif($status[0]['scholarship_status'] == 4)
							{
								
							$output[] = '<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Finally Passed"/>';
					
								
							}
							else
							{
								if(count($quarterbalance)>0)
								{
						
								
								$uploadpermit = '<a class="form-control sbmt" style="height:35px;width:140px;" href="'.site_url().'regional/regionalExpenditureUser/'.$r['application_no'].'" class="form-control sbmt" target = "__blank">Payment Details</a>';
								
							
					
								}
								else
								{
								
			
$uploadpermit = '<a class="form-control sbmt" style="height:35px;width:140px;" href="'.site_url().'regional/regionalExpenditureUser/'.$r['application_no'].'" class="form-control sbmt" target = "__blank">Payment Details</a>';

							
							
								}	
								
							}	
							
						}
						$output[] = $uploadpermit;
                        $response[] = $output;
				        
			
			}
			}
			$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
			$returnJson['recordsTotal'] = $totalResult[0]['total'];
			$returnJson['recordsFiltered'] = $totalResult[0]['total'];
			$returnJson['data'] = $response;
			echo json_encode($returnJson);
			
			
    }
	
	
	function expenditureStatement()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionId'] = $regionid;
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['arrived'] = $this->common_model->getRegionalReceivedApplication($regionid);
			$data['oldarrived'] = $this->common_model->getOldRegionalReceivedApplication($regionid);
			$data['quarterbalance'] = $this->getCurrentQuarterFundDetails();			
			$this->load->view('regional/header_regional');
			$this->load->view('regional/paystipend',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	function expenditureStatementDemo()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionId'] = $regionid;
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			//$data['arrived'] = $this->common_model->getRegionalReceivedApplication($regionid);
			//$data['oldarrived'] = $this->common_model->getOldRegionalReceivedApplication($regionid);
			//$data['quarterbalance'] = $this->getCurrentQuarterFundDetails();			
			$this->load->view('regional/header_regional');
			$this->load->view('regional/paystipendDemo',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	function academicDetails()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['arrived'] = $this->common_model->getRegionalReceivedApplication($regionid);
			$data['oldarrived'] = $this->common_model->getOldAcademicApplicant($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/academicDetails',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}

	function academicDetailsDemo()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['arrived'] = $this->common_model->getRegionalReceivedApplication($regionid);
			$data['oldarrived'] = $this->common_model->getOldAcademicApplicant($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/academicDetailsDemo',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
/* 	public function viewAlumaniDetails()
	{
		$user_data = $this->session->userdata('user_data');
		//$missionId = $user_data['user_country'];
		$regionid = $user_data['state'];
		$appno = $this->uri->segment(3);
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
		$data['alunamiapplication']= $this->common_model->getAlumaniApplicationbyId($appno);
		$this->load->view('regional/header_regional');
		$this->load->view('regional/viewAlumaniApplication',$data);
		$this->load->view('regional/footer');
	} */
	function alumani()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['alunamiapplication']= $this->common_model->getAlumaniApplicationsByRegion($regionid);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/alumani',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	 public function viewAlumaniDetails() {
        try {
            $user_data = $this->session->userdata('user_data');
            $missionId = $user_data['user_country'];
            $appno = $this->uri->segment(3);
            $data['misionData'] = $this->common_model->getMissionInfo($missionId);
            $data['alunamiapplication'] = $this->common_model->getAlumaniApplicationbyId($appno);
            $this->load->view('regional/header_regional');
            $this->load->view('regional/viewAlumaniApplication', $data);
            $this->load->view('regional/footer');
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'regional/dashboard');
        }
    }
	public function getCourseByPrgrammeold()
    {
   		$response = array('status'=>FALSE,'data'=>array(),'csrfName'=>'','csrfHash'=>'','stateuniversities'=>array(),'centraluniversities'=>array(),'nit'=>array());	
   		try
   		{	
   			$current = date('Y-m-d',strtotime('-12 years'));
   			$current1 = date('Y-m-d',strtotime('-12 years'));
	   		$id=$this->input->post('programme'); 
	   		if($id == 1 || $id == 5 || $id == 6 || $id == 7)
	   		{	   			
				$financial = $this->getFinancialYears($current,7);
				$acaYears =  $this->getFinancialYearsOnly($current1,6);
			}  
			if($id == 2)
	   		{	   			
				$financial = $this->getFinancialYears($current,3);
				$acaYears =  $this->getFinancialYearsOnly($current1,2);
			}
			if($id == 3)
	   		{	   			
				$financial = $this->getFinancialYears($current,2);
				$acaYears =  $this->getFinancialYearsOnly($current1,1);
			} 
			if($id == 4)
	   		{	   			
				$financial = $this->getFinancialYears($current,4);	
				$acaYears =  $this->getFinancialYearsOnly($current1,3);			
			}
			if($id == 8)
	   		{	   			
				$financial = $this->getFinancialYears($current,2);
				$acaYears =  $this->getFinancialYearsOnly($current1,1);
			}
			foreach($financial as $fy)
   			{	   				
				$response['fy'][] = $fy;
			}
			foreach($acaYears as $fy1)
   			{	   				
				$response['fyrs'][] = $fy1;
			}	
			
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
	public function getCourseByPrgramme()
    {
   		$response = array('status'=>FALSE,'data'=>array(),'csrfName'=>'','csrfHash'=>'','stateuniversities'=>array(),'centraluniversities'=>array(),'nit'=>array());	
   		try
   		{	
   			$current = date('Y-m-d',strtotime('-1 years'));
   			$current1 = date('Y-m-d',strtotime('-2 years'));
	   		$id=$this->input->post('programme'); 
	   		if($id == 1 || $id == 5 || $id == 6 || $id == 7)
	   		{	   			
				$financial = $this->getFinancialYears($current,7);
				$acaYears =  $this->getFinancialYearsOnly($current1,6);
			}  
			if($id == 2)
	   		{	   			
				$financial = $this->getFinancialYears($current,3);
				$acaYears =  $this->getFinancialYearsOnly($current1,2);
			}
			if($id == 3)
	   		{	   			
				$financial = $this->getFinancialYears($current,2);
				$acaYears =  $this->getFinancialYearsOnly($current1,1);
			} 
			if($id == 4)
	   		{	   			
				$financial = $this->getFinancialYears($current,4);	
				$acaYears =  $this->getFinancialYearsOnly($current1,3);			
			}
			if($id == 8)
	   		{	   			
				$financial = $this->getFinancialYears($current,2);
				$acaYears =  $this->getFinancialYearsOnly($current1,1);
			}
			foreach($financial as $fy)
   			{	   				
				$response['fy'][] = $fy;
			}
			foreach($acaYears as $fy1)
   			{	   				
				$response['fyrs'][] = $fy1;
			}	
			
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
   function accademicReportofOldStudent()
    {
		$applicationId = $this->uri->segment(3);
		$data['academic'] = $this->common_model->getAcademicDataforReport($applicationId);
		$data['academicStatus'] = $this->common_model->getAcademicStatusDataforReport($applicationId);
		//$data['scholarship'] = $this->common_model->getScholarshipStatusDataforReport($applicationId);
		$data['academicDetails'] = $this->common_model->getAcademicDetailsDataforReport($applicationId);
		$this->load->view('regional/header_regional');
		$this->load->view('regional/accademicReportofOldStudent',$data);
		$this->load->view('regional/footer');
	}
    function accademicReportofStudent()
    {
		$applicationId = $this->uri->segment(3);
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
		$data['mapdata'] = $this->common_model->getMappingData($applicationId);
		$data['academic'] = $this->common_model->getAcademicStatusDataforReport($applicationId);
		$data['academicDetails'] = $this->common_model->getAcademicDetailsDataforReport($applicationId);
		//$data['scholarship'] = $this->common_model->getScholarshipStatusDataforReport($applicationId);
		$userId = $data['applicaitonStepOne'][0]['uid'];
		$imgArray = $this->common_model->getUserImage($userId);
		if(count($imgArray)> 0)
		{
			$data['userImage'] = $imgArray[0]['name'];
		}		
		else
		{
			$data['userImage'] = '';
		}
		$this->load->view('regional/header_regional');
		$this->load->view('regional/accademicReportofStudent',$data);
		$this->load->view('regional/footer');
	}
   	function addcurrentAcademicDetails()
   	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];	
		$data['regionId']=	$regionid;
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		if($applicationId == NULL || $applicationId == "")
		{
			$applicationId = $this->random_num(15);
		}	
		else
		{
			$applicationId = $this->uri->segment(3);
		}
		$data['appno'] = $applicationId;
		
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
		$data['mapdata'] = $this->common_model->getMappingData($applicationId);
		$data['academic'] = $this->common_model->getAcademicDataforReport($applicationId);
		$id = $data['applicaitonStepOne'][0]['programme'];
		$current = date($data['academic'][0]['course_duration_from'].'-m-d');
		$to = $data['academic'][0]['course_duration_to'];
		$v = abs($data['academic'][0]['course_duration_from']-$to); 
		$v = $v + $v;
		
   		$current1 = date('Y-m-d',strtotime('-1 years'));
		if($id == 1 || $id == 5 || $id == 6 || $id == 7)
   		{	   			
			$financial = $this->getFinancialYears($current,$v);
			$acaYears =  $this->getFinancialYearsOnly($current1,6);
		}  
		if($id == 2)
   		{	   			
			$financial = $this->getFinancialYears($current,$v);
			$acaYears =  $this->getFinancialYearsOnly($current1,2);
		}
		if($id == 3)
   		{	   			
			$financial = $this->getFinancialYears($current,$v);
			$acaYears =  $this->getFinancialYearsOnly($current1,1);
		} 
		if($id == 4)
   		{	   			
			$financial = $this->getFinancialYears($current,$v);	
			$acaYears =  $this->getFinancialYearsOnly($current1,3);			
		}
		if($id == 8)
   		{	   			
			$financial = $this->getFinancialYears($current,$v);
			$acaYears =  $this->getFinancialYearsOnly($current1,1);
		}
		$country = $this->common_model->getCountryById($data['applicaitonStepOne'][0]['country']);
		$schemeId = $this->common_model->getMappingData($applicationId);
		$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
		$data['schemeId'] = $schemeId[0]['scholarship_id'];
		$data['uni'] = $schemeId[0]['regional_university'];
		$data['financial'] = $financial;
		$data['acayears'] = $acaYears;
		
		$data['expenditure_year'] = $this->getAllFinancialYear();
		$this->load->view('regional/header_regional');
		$this->load->view('regional/addcurrentAcademicDetails',$data);
		$this->load->view('regional/footer');
	}
	function addAcademicDetails()
	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];	
		$data['regionId']=	$regionid;	
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		if($applicationId == NULL || $applicationId == "")
		{
			$applicationId = $this->random_num(15);
		}	
		else
		{
			$applicationId = $this->uri->segment(3);
		}
		$data['academic'] = $this->common_model->getAcademicDataforReport($applicationId);
		$id = $data['academic'][0]['programme'];
		//$current = date('Y-m-d',strtotime('-12 years'));
		
		$current = date($data['academic'][0]['course_duration_from'].'-m-d');
		
		$crnt = $data['academic'][0]['course_duration_from'].'-m-d';
		$to = $data['academic'][0]['course_duration_to'];
		$v = abs($data['academic'][0]['course_duration_from']-$to); 		
		$v = $v + $v;		
		$toy = $v;
   		$current1 = date('Y-m-d',strtotime('-12 years'));
		if($id == 1 || $id == 5 || $id == 6 || $id == 7)
   		{	   			
			$financial = $this->getFinancialYearsFromBased($data['academic'][0]['course_duration_from'],$toy);
			$acaYears =  $this->getFinancialYearsOnly($current1,6);
		}  
		if($id == 2)
   		{	   			
			$financial = $this->getFinancialYearsFromBased($data['academic'][0]['course_duration_from'],$toy);
			$acaYears =  $this->getFinancialYearsOnly($current1,2);
		}
		if($id == 3)
   		{	   			
			$financial = $this->getFinancialYearsFromBased($data['academic'][0]['course_duration_from'],$toy);
			$acaYears =  $this->getFinancialYearsOnly($current1,1);
		} 
		if($id == 4)
   		{	   			
			$financial = $this->getFinancialYearsFromBased($data['academic'][0]['course_duration_from'],$toy);	
			$acaYears =  $this->getFinancialYearsOnly($current1,3);			
		}
		if($id == 8)
   		{	   			
			$financial = $this->getFinancialYearsFromBased($data['academic'][0]['course_duration_from'],$toy);
			$acaYears =  $this->getFinancialYearsOnly($current1,1);
		}
		$data['appno'] = $applicationId;
		$data['financial'] = $financial;
		$data['acayears'] = $acaYears;	
		
		$data['expenditure_year'] = $this->getAllFinancialYear();
		$this->load->view('regional/header_regional');
		$this->load->view('regional/addAcademicDetails',$data);
		$this->load->view('regional/footer');
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
			$user_data = $this->session->userdata('user_data');
			$data['user_data'] = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionid'] = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);	
			$data['newApplication'] = $this->common_model->getRegionalApplicationsCount($regionid);	
			$data['forwardedtohqrs'] = $this->common_model->getRegionalApplicationsForwardtoHqrs($regionid);	
				
			$responsee = $this->common_model->getRegionalTravelApplication($regionid);			
			//$data['travel'] = count($this->common_model->getRegionalTravelApplication($regionid));
			$data['travel'] = count($this->common_model->getApplicationIdsofTravel($regionid));			
			$data['arrived'] = count($this->common_model->getRegionalReceivedApplication($regionid));	
			$data['admission']= count($this->common_model->getRegionalPendingUniversityApplications($regionid));
			
			//$data['travel_stipend'] = count($this->common_model->getRegionalTravelApplication($regionid));	
			$data['travel_stipend'] = count($this->common_model->getApplicationIdsofTravel($regionid));	
			$data['alunamiapplication']= count($this->common_model->getAlumaniApplicationsByRegion($regionid));	
			$data['demands'] = count($this->common_model->getDemands($regionid));
			$data['processeddemands'] = count($this->common_model->getProcessedDemands($regionid));
			$this->load->view('regional/header_regional');
			$this->load->view('regional/dashboard',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	public function applicationForm()
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
		$this->load->view('regional/header_regional');
		$this->load->view('regional/applicationForm',$data);
		$this->load->view('regional/footer');
	}	
	public function contactForm()
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
		$this->load->view('regional/header_regional');
		$this->load->view('regional/contactForm',$data);
		$this->load->view('regional/footer');
	}	
	public function universityResponse()
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
		$data['regionId'] =  $user_data['state'];	
		$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
		$data['userImage'] = $image;
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();	
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
		$data['mappingData'] = $this->common_model->getMappingData($applicationId);
		$data['universityData'] = $this->common_model->getconfirmationData($applicationId);
		$this->load->view('regional/header_regional');
		$this->load->view('regional/universityResponse',$data);
		$this->load->view('regional/footer');
	}
	public function universityLetter()
	{
		$applicationId = $this->uri->segment(3);
		$user_data = $this->session->userdata('user_data');
		$userId = $user_data['userid'];			
		$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);
		
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
		$pdf->Ln(2);
		$pdf->MultiCell(180,5,'Ref No                 /2020-21','','L');
		$pdf->Ln(3);
		$pdf->MultiCell(180,5,'To,','','L');
		$pdf->Ln(20);
		$pdf->SetFont('Arial','',13);	
		$pdf->MultiCell(180,5,'Subject : Request for the admission of International Students for the Academic Year 2020 to 2021','','L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(180,5,'Dear Sir/Madam,','','L');		
		
		$pdf->MultiCell(170,5,'The Indian Council for Cultural Relations (Ministry of External Affairs) proposes to award scholarship to:','','J');						
		$pdf->Ln(5);
		$uniid = array();
		if($stepOne[0]['university_choice_one_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice']);
			//$uniid = $stepOne[0]['universty_choice'];
		}
		if($stepOne[0]['university_choice_two_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice_two']);
			//$uniid = $stepOne[0]['universty_choice_two'];
		}
		if($stepOne[0]['university_choice_three_state'] == $user_data['state'])
		{
			array_push($uniid,$stepOne[0]['universty_choice_three']);
			//$uniid = $stepOne[0]['universty_choice_three'];
		}
		//print_r($uniid);
		$country = $this->common_model->getCountryById($stepOne[0]['country']);
		$schemeId = $this->common_model->getMappingData($applicationId);
		$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
		if($country[0]["country_name"] == "Afghanistan")
		{
			$pdf->MultiCell(175,5,'Name                     : '.$stepOne[0]['fullname'],'','L');
			$pdf->Ln(2);	
			$pdf->MultiCell(175,5,'Fathers Name        : '.$stepOne[0]['guardian_name'],'','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,'Country                  : '.$country[0]['country_name'],'','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,'Scheme                 : '.$schemename[0]['scheme_name'],'','L');
			$pdf->Ln(2);
			$courseDetails = 'Course    : ';
			if(count($uniid)>1)
			{
				foreach($uniid as $unid)
				{
					$course1=$this->common_model->getCourseDetails($applicationId,$unid);
					$courseDetails = $courseDetails. $course1['course_name'].' ('.$course1['subject'].'), ';
				}
			}
			else
			{
				$course1=$this->common_model->getCourseDetails($applicationId,$uniid[0]);
				$courseDetails = $courseDetails. $course1['course_name'].' ('.$course1['subject'].')';
			}
				
			//$course=$this->common_model->getCoursesById($stepOne[0]['course']);
			$pdf->MultiCell(175,5,'Embassy Ref No.  : ','','L');
			$pdf->Ln(2);
			$pdf->MultiCell(175,5,$courseDetails ,'','L');
		}
		else
		{
			$pdf->MultiCell(175,5,'Name     : '.$stepOne[0]['fullname'],'','L');				
			$pdf->MultiCell(175,5,'Country  : '.$country[0]['country_name'],'','L');
			$pdf->MultiCell(175,5,'Scheme  : '.$schemename[0]['scheme_name'],'','L');
			$course=$this->common_model->getCoursesById($stepOne[0]['course']);			
			//$course1=$this->common_model->getCourseDetails($applicationId,$uniid);			
			$courseDetails = 'Course    : ';		
			if(count($uniid)>1)
			{
				foreach($uniid as $unid)
				{
					$course1=$this->common_model->getCourseDetails($applicationId,$unid);
					$courseDetails = $courseDetails. $course1['course_name'].' ('.$course1['subject'].'), ';
				}
			}
			else
			{
				$course1=$this->common_model->getCourseDetails($applicationId,$uniid[0]);
				$courseDetails = $courseDetails. $course1['course_name'].' ('.$course1['subject'].')';
			}
			
			$pdf->MultiCell(175,5,$courseDetails ,'','L');
		}
		
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Copy of his/her application along with copies of certificates and marks sheet are enclosed herewith for your perusal.  The applicant would be awarded scholarship by ICCR provided he/she is accepted for admission to the said course at your University/Institute.','','J');		
		$pdf->Ln(5);		
		$pdf->MultiCell(170,5,'Kindly confirm his/her admission at the earliest along and also confirm whether Hostel accommodation would be provided to the student.','','J');	
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Name of the College may also be mentioned if possible in the confirmation letter. ICCR will pay the tuition fee, admission fee & other compulsory fees (excluding refundable caution/security money etc.) and hostel charges to the University/Institute after receiving the joining report of the applicant countersigned by the appropriate authority in the University/Institute. ','','J');	
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'If admission is confirmed kindly indicate last date by which candidate is required to join the course, allowing him/her at least one/two months preparation time to obtain visas & make necessary travel arrangements for India.','','J');
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'Please note that in case of scholar pursuing science courses the expenditure on chemicals and other related incidental charges will be borne by the scholar himself/herself.  ','','J');
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'We would appreciate receiving confirmation as early as possible.','','L');
		$pdf->Ln(2);
		$pdf->MultiCell(170,5,'Thanking you,','','C');	
		$pdf->MultiCell(170,5,'Yours faithfully,','','R');		
		$pdf->Ln(8);		
		$pdf->MultiCell(170,5,'Regional Director','','R');
		$pdf->Ln(2);	
		$pdf->MultiCell(170,5,'Date: '.date('d M Y'),'','L');
		
		$filename = $applicationId."_University_Letter_".date('jS-F-Y-h-i-s').'.pdf';
		$pdf->Output($filename,"D");
	}	
    public function application()
	{
		
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
			$data['missions'] = $this->common_model->getAllMissions();
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
			$this->load->view('regional/header_regional');
			$this->load->view('regional/applicant_personal_info',$data);
			$this->load->view('regional/footer');
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Application Already Approved!');
			redirect(site_url().'regional/universityapplications');		
		}
	}
	public function viewApplication()
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
		$this->load->view('regional/header_regional');
		$this->load->view('regional/viewApplication',$data);
		$this->load->view('regional/footer');
	}
	public function downloadContactForm()
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
	        echo $e;
	        exit;
	    }
	}
	public function downloadguidlines()
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
			$html1 = "<div style='text-align:center;'><img width='300px' src='".site_url()."assets/site/main/images/mea-logo.png'></div><br/>";       	 				
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
	        echo $e;
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
	        echo $e;
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
    function getCurrentFinancialYear()
   {
   		$currentMonth = date('m');
   		$yearString = "";
		if($currentMonth>4)
		{
			$currentYear=date('Y');
			$yearString = $currentYear.'-';
			$pt = date('Y', strtotime('+1 year'));
			$yearString .= $pt;
		}
		else 
		{
			$lastYear=date('Y', strtotime('-1 year'));
			$yearString = $lastYear.'-';
			$pt = date('Y');
			$yearString .= $pt;
		}
   		return $yearString;
   }
   function getFinancialYearsFromBased($from,$nexttoyears)
   {
   		$array = array();
   		$end = $from + $nexttoyears;
   		for($i=$from; $i<$end; $i++)
   		{
   			$dd = $i.'-'.($i+1);
			array_push($array,$dd);
		}
		return $array;
   }
   function getFinancialYears($from,$nexttoyears)
   {
		$currentDate = $from;
		$lastFY = date('Y-m-d', strtotime('+'.$nexttoyears.' years'));
		return $this->calcFY($currentDate,$lastFY);
   }
   function getFinancialYearsOnly($from,$nexttoyears)
   {
		$currentDate = $from;
		$lastFY = date('Y-m-d', strtotime('+'.$nexttoyears.' years'));
		return $this->calcFYears($currentDate,$lastFY);
   }
   function getAllFinancialYear()
   {
		//$currentDate = date("Y-m-d");
		$currentDate = date("Y-m-d",strtotime('-4 years'));
		$lastFY = date('Y-m-d', strtotime('+'.$this->config->item("financial_year_last").' years'));
		return $this->calcFY($currentDate,$lastFY);
   }
   function calcFYears($startDate,$endDate) 
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
	        $fy[] = $year1;

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
   function calcFYSingle($startDate,$endDate)
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
	        //$fy[] = $prefix.substr($prevyear,-2).'-'.substr($year1,-2);
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
	    return implode(',',$fy);
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

	public function saveAlumniData()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			//print_r($user_data);
			$regionid = $user_data['state'];
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
				redirect(site_url().'regional/alumniApplication');				
				return;
			}
			if ($nsection != "IVBORW0K" && $nsection != "/9J/4AAQ") 
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File content is not Valid!');
				redirect(site_url().'regional/alumniApplication');		
				return;			
			}
			if ($sizekbb > 5242880) 
			{			
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'File size is not Valid!');
				redirect(site_url().'regional/alumniApplication');	
				return;
			}
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$imgname1 = '';
			$imgname2 = '';
			if(!empty($_FILES['upload_university_letter']['name']))
					{
						$file_name=$_FILES["upload_university_letter"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['upload_university_letter']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect('regional/alumani');
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'upload_university_letter'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							
							$this->session->set_flashdata('error','File name is not valid.');
							redirect('regional/alumani');
							return false;
							
						}
						elseif($_FILES['upload_university_letter']["size"] <= 0 || $_FILES['upload_university_letter']["size"] >5000000)
						{
							
							
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect('regional/alumani');
							return false;
						}
						$file_tmp = $_FILES["upload_university_letter"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['upload_university_letter']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/alumani_university_letter/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$postData['upload_university_letter'] = $imgname1;
						}
						else
						{
							
							
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect('regional/alumani');
							return false;
							
					}
						
			}
			if(!empty($_FILES['upload_travel_doc']['name']))
					{
						$file_name=$_FILES["upload_travel_doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['upload_travel_doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect('regional/alumani');
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'upload_travel_doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							
							$this->session->set_flashdata('error','File name is not valid.');
							redirect('regional/alumani');
							return false;
							
						}
						elseif($_FILES['upload_travel_doc']["size"] <= 0 || $_FILES['upload_travel_doc']["size"] >5000000)
						{
							
							
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect('regional/alumani');
							return false;
						}
						$file_tmp = $_FILES["upload_travel_doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['upload_travel_doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/alumani_travel_plan/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$postData['upload_travel_doc'] = $imgname2;
						}
						else
						{
							
							
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect('regional/alumani');
							return false;
							
					    }
						
			}
			 
			if($files["name"] != "")
			{				
			  $name = str_replace(" ","_",$files['name']);
			  $imgname = $application_no.'_'.time().'_alumni_pics_'.$name;
			  
			  $target_file = 'assets/site/main/alumni_pic/'.$imgname; 
			  if (move_uploaded_file($_FILES["img_alumnai"]["tmp_name"], $target_file)) 
			  { 
			  	 $postData['regional_id'] = $regionid;
			  	 //$postData['application_id'] = $application_no;
			  	 $postData['photo'] = $imgname;
				 $postData['created'] = time();
			 	 $result = $this->common_model->insertAlumniData($postData);
				 //var_dump($result);die;
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Alumni Details Saved!');
					redirect(site_url().'regional/alumani');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
					redirect(site_url().'regional/alumani');					
				 }
			  }
			  else
			  {
		  		$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
				redirect(site_url().'regional/alumani');
			  }
			} 
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
				redirect(site_url().'regional/alumani');
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/alumani');
		}
	}
	
	function alumniApplication()
	{
		try{
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
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
			$this->load->view('regional/header_regional');
			$this->load->view('regional/alumni_application',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'regional/dashboard');
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
		
		public function getScolarArrival()
    {
		//echo "adas";die;
    	$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];		
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$data['region'] = $regionid;	 	
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->Regional_model->getArivalDetails1($regionid,$vars);
		//echo "<pre>";
		//print_r($result);die;
		$totalResult = $this->Regional_model->getArrivalTotalDetails($regionid,$vars);
		$filted = count($totalResult);
		//echo $filted;
		$response = array();
		//$counter = 1;
		$arrat = array();
		if(!empty($result))
		{
			
			foreach($result as $r)
			{
			if(!in_array($r['application_id'],$arrat))
						{
							array_push($arrat,$r['application_id']);	
				
			//echo "<pre>";
		    //print_r($r);die;
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_id']);
				$counter++;
				
				        $gender = "";
				        $output= array();	
				        $output[] = $counter;	
						$date1 = '2019-12-01';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						$studentyreg = strtotime($r['created']);
						$arrat = array();
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
						//}
						
					    $output[]= $applicationDetails[0]['fullname'];
						$output[] = $applicationDetails[0]['email'];
						$data = $this->common_model->getConfirmationofApplicationIds($r['application_id']);
						$output[] = $data[0]->course;
						$sch = $this->common_model->getSchemeById($r['scholarship_id']);
						$output[] = $sch[0]['scheme_name'];		
						
						$data1 = $this->common_model->getConfirmationofApplicationIds($r['application_id']);
						$uni = $this->common_model->getUniversityById($data1[0]->regional_university);
						$output[] = $uni[0]['name'];	
						$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
						$output[] = $country[0]['country_name'];
						$travelDetails = '';
						$travelpl = $this->common_model->getTravelPlan($r['application_id']);
						if($r['undertaking_status_by_region'] != ''){
							$travelDetails = $travelpl[0]['travel_arrival_date'].'(RO)';
						}
						else
						{
							$travelDetails = $travelpl[0]['travel_arrival_date'];
						}
						$output[] = $travelDetails;	
						
					
						$travelpl = $this->common_model->getTravelPlan($r['application_id']);
						
						
						$output[] = '<a download  href="'.site_url().'assets/site/main/travelplan/'.$travelpl[0]['travel_plan_doc'].'">Download</a>';
						
						
						    $arivedStatus = '';
							
							if($r['status'] == 13)
							{
				
							
							$arivedStatus = '<a class=form-control sbmt1" style="height:30px;width:90px;margin-bottom: 8px;" href="'.site_url().'regional/scholarArrivedstatus/'.$r['application_id'].'/'.$travelpl[0]['id'].'" target = "__blank">Process</a>';
							}
							elseif($r['status'] >= 14)
							{
								$arivedStatus = "Arrived";
							}
							elseif($r['status'] == -14)
							{
								$arivedStatus = "Not Arrived";
							}
							
							$output[] = $arivedStatus;
							
							$viewDetails = '';
							if($r['status'] == 13)
							{
								$viewDetails =  "NA";
							}
							elseif($r['status'] >= 14)
							{
								
					
							
							$viewDetails = '<a class=form-control sbmt1" style="height:30px;width:90px;margin-bottom: 8px;" href="'.site_url().'regional/scholarArrivedstatusView/'.$r['application_id'].'" target = "__blank">View</a>';
							
							}
							elseif($r['status'] == -14)
							{
							$viewDetails = '<a class=form-control sbmt1" style="height:30px;width:90px;margin-bottom: 8px;" href="'.site_url().'regional/scholarArrivedstatusView/'.$r['application_id'].'" target = "__blank">View</a>';
							}
							$date = date_create($r['created']);
							$array =  (array) $date;
							$date2 = date("Y-m-d", strtotime($array['date']));
							$studentyreg = strtotime($r['created']);
							$output[] = $studentyreg;
							$output[] = $viewDetails;
							
							
						}
						$response[] = $output;	
						//$counter++;	
					}
					
				}
				
			
		
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}	
		function getNewApplicaitons()
    {
		
    	$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];		
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$data['region'] = $regionid;	 	
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->Regional_model->getRegionalApplications($regionid,$vars);
		
		$totalResult = $this->Regional_model->getRegionalTotalNewApplication($regionid,$vars);
		//echo "<pre>";print_r(count($totalResult));die;
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
				//print_r($applicationDetails);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				        $gender = "";
				        $output= array();	
				        $output[] = $counter;	
						
						//$finish = date("Y-m", $r['created']);
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
						//}
						$output[] = $applicationDetails[0]['application_no'];
					    $output[]= $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'].$new;
							
						//$output[] = $applicationDetails[0]['fullname'];
                       
						$output[] = $country[0]['country_name'];
						$sch = $this->common_model->getSchemeById($r['scholarship_id']);
						$output[] = $sch[0]['scheme_name'];				
						if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
							$output[] =  $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
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
						$universityDetails = '';
						$uname1 ="";$array_uni_id = array();
						
						if($regionid == $applicationDetails[0]['university_choice_one_state']){
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);		
							$uname1 = $university[0]['name'];
							array_push($array_uni_id,1);
						}
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);		
							$uname1 = $university[0]['name'];
						}
						
						$uname2 ="";					
						if($regionid == $applicationDetails[0]['university_choice_two_state']){						
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
							$uname2 = $university[0]['name'];
							array_push($array_uni_id,2);
						}						
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);	
							$uname2 = $university[0]['name'];
						}
						
						
						$uname3 ="";
						
						if($regionid == $applicationDetails[0]['university_choice_three_state']){							
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
							$uname3 = $university[0]['name'];
							array_push($array_uni_id,3);
						}
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
							$uname3 = $university[0]['name'];
						}
						$universityDetails .= '1) '.$uname1.'<br/>';
				        $universityDetails .= '2) '.$uname2.'<br/>';
				        $universityDetails .= '3) '.$uname3.'<br/>';
				        $output[] = $universityDetails;	
						$output[] = '<a target="_blank"  href="'.site_url().'regional/applicationForm/'.$applicationDetails[0]['application_no'].'">Download</a>';
					    $output[] = '<a target="_blank" href="'.site_url().'regional/contactForm/'.$applicationDetails[0]['application_no'].'">Download</a>';
					    $output[] = '<a  href="'.site_url().'regional/universityLetter/'.$applicationDetails[0]['application_no'].'">Download</a>';
							$downld1 = '';$dwnldDetails  = '';
							if(count($array_uni_id)>0)
							{
								
								foreach($array_uni_id as $optionNo)
								{
									
									if($optionNo == 1)
									{
										if($r['uni_forwarded_letter'] == "")
										{
											$downld1 = "<a href='#'  onclick=updateId('".$r['application_no']."','".$r['universty_choice']."','".$optionNo."'); data-toggle='modal' class='form-control sbmt' data-target='#universtiyLetterdiv'>Upload</a>";
										}
										else
										{
											
											$downld1 = '<a download href="'.site_url().'assets/site/main/university_Forwarded_letter/'.$r['uni_forwarded_letter'].'">Download</a>';
											
										}
										
									$dwnldDetails .= $downld1.'<br/>';
									}
									$downld2 = '';
									if($optionNo == 2)
									{
										if($r['uni_forwarded_letter_two'] == "")
										{
											$downld2 = "<a href='#'  onclick=updateId('".$r['application_no']."','".$r['universty_choice_two']."','".$optionNo."'); data-toggle='modal' class='form-control sbmt' data-target='#universtiyLetterdiv'>Upload</a>";
											
											
										}
										else
										{
										
											$downld2 = '<a download href="'.site_url().'assets/site/main/university_Forwarded_letter/'.$r['uni_forwarded_letter_two'].'">Download</a>';
											
										}
										 $dwnldDetails .= $downld2.'<br/>';
				       
										
									}
								    $downld3 = '';
									if($optionNo == 3)
									{
										if($r['uni_forwarded_letter_three'] == "")
										{
										
											
											$downld3 = "<a href='#'  onclick=updateId('".$r['application_no']."','".$r['universty_choice_three']."','".$optionNo."'); data-toggle='modal' class='form-control sbmt' data-target='#universtiyLetterdiv'>Upload</a>";
										  
											
										}
										else
										{
											$downld3 = '<a download href="'.site_url().'assets/site/main/university_Forwarded_letter/'.$r['uni_forwarded_letter_three'].'">Download</a>';
											
										}
									}
									 $dwnldDetails .= $downld3.'<br/>';
									
								}
								
				       
				        $output[] = $dwnldDetails;
							}
							
					        //$date = date_create($r['created']);
							//$array =  (array) $date;
					        //$output[] = date("Y-m-d", strtotime($array['date']));
							$output[] = date("Y-m-d",$studentyreg);
						    //$output[] = date("Y-m-d", $r['created']);
					        $mdate = date_create($r['mission_status_date']);
							$array =  (array) $mdate;
					        $output[] = date("Y-m-d H:i:sa", strtotime($array['date']));
							
//$output[] = '';							
						if($r['status'] >= 4)
						{
							$forwartToUniversity = array();
						
							if(count($array_uni_id)>0 && count($array_uni_id) >= 1)
							{
								$stscounter = 0; $pend ="";$array_pend = array();
								foreach($array_uni_id as $ststid)
								{
									$colname = "university_status_".$ststid;
									if($r[$colname] == "-1")
									{
										$stscounter++;
										$pend .= $ststid;		
										array_push($forwartToUniversity,$ststid);
									}
								}
								$upfirst = ''; $letterDetails = '';
								if(count($forwartToUniversity) > 0)
								{
									
									
									foreach($forwartToUniversity as $optNo)
									{
										
										if($optNo == 1)
										{
											if($regionid == $r['university_choice_one_state']){
												if($r['uni_forwarded_letter'] == "")
												{
												
											$upfirst ='<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>'; 
											
												}
												else
												{
												
											$upfirst = '<a class="form-control sbmt" style="height:32px;width:140px;" href="'.site_url().'regional/forwardtouniversity/'.$r['application_no'].'/'.$optNo.'">Forward To University</a>';
										
												}
												
											}
											$letterDetails .= $upfirst;
				       
										}
										$upsecond = '';
										if($optNo == 2)
										{
											if($regionid == $r['university_choice_two_state']){
												if($r['uni_forwarded_letter_two'] == "")
												{
												
											$upsecond = '<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>';
										
												}
												else
												{
												
											$upsecond = '<a class="form-control sbmt" style="height:32px;width:140px;" href="'.site_url().'regional/forwardtouniversity/'.$r['application_no'].'/'.$optNo.'">Forward To University</a>';
										
												}
											}
											 $letterDetails .=$upsecond;
				     
										}
										$upthird = '';
										if($optNo == 3)
										{
											if($regionid == $r['university_choice_three_state']){
												if($r['uni_forwarded_letter_three'] == "")
												{
												
											$upthird = '<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>';
										
												}
												else
												{
												
											$upthird = '<a class="form-control sbmt" style="height:32px;width:140px;" href="'.site_url().'regional/forwardtouniversity/'.$r['application_no'].'/'.$optNo.'">Forward To University</a>';
										
												}
											}
											   $letterDetails .= $upthird;
										}
									}
									
				              $output[] = $letterDetails;
								}
								else
								{
									$output[] =  "Forwarded to University";
								}								
							}
							
						}
						
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
	
	
	
	
		public function universityapplications1()
	{
		
		    $user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			
			//$data['newApplication'] = $this->common_model->getRegionalPendingUniversityApplications($regionid);
			$data['region'] = $regionid;
			$this->load->view('regional/header_regional');
			$this->load->view('regional/universityapplications5',$data);
			$this->load->view('regional/footer');
	}
	
	
	function getUniversityapplications()
    {
		//echo "aAsaS";die;
    	$user_data = $this->session->userdata('user_data');
		$region = $user_data['state'];		
		$data['regionName'] = $this->common_model->getRegionById($region);
		$data['region'] = $regionid;	 	
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->Regional_model->getRegionalPendingUniversityApplications($region,$vars);
		//echo "<pre>";print_r($result);
		$totalResult = $this->Regional_model->getRegionalPendingUniversityTotalApplications($region,$vars);
		$response = array();
		$counter++;
		if(!empty($result))
		{
			
			foreach($result as $app)
			{
				//echo "<pre>";
				//print_r($app);die;
				if($app['status'] >= 4)
						{
						$sts = $this->common_model->isAnyUniversityResponseConfirm($app['application_no'],$region);		
							//echo "<pre>";print_r($sts);
							//echo count($sts);
						if(count($sts) <= 0)
						{									
					    $gender = "";
				        $output= array();	
						$output[] = $counter;
						$output[]=  $app['application_no']; 
						$date1 = '2019-12-1';
						$date = date_create($app['mission_status_date']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//print_r($date2);die;
						
						//if($app['status'] = 4) {
							if ($date2 > $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
						//}
						
					    $output[]= $app['fullname'].' '.$app['middlename'].' '.$app['familyname'].$new;
						
						
						
						$output[] = $app['email'];
						$output[] = $app['country_name'];
						$sch = $this->common_model->getSchemeById($app['scholarship_id']);
						$output[] = $sch[0]['scheme_name'];	
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							$output[] = $course[0]['name'].' '.$app['course_subject'];
						}
						else
						{
							$course = $this->common_model->getCoursesById($app['course']);
							$course1 = $this->common_model->getCoursesById($app['course_two']);
							$course2 = $this->common_model->getCoursesById($app['course_three']);
							$fullCourse ="";
							$fullCourse .= $course[0]['title'].' '.$app['course_option_name'].'<br/>';
							$fullCourse .= $course1[0]['title'].' '.$app['course_option_name_two'].'<br/>';
							$fullCourse .= $course2[0]['title'].' '.$app['course_option_name_three'].'<br/>';
							$output[] = $fullCourse;
						}
						$universityDetails = '';
						$uname1 ="";$array_uni_id = array();
						//$output[] =  "1)";
						if($region == $app['university_choice_one_state']){
							$university = $this->common_model->getUniversityById($app['universty_choice']);		
							$uname1 = $university[0]['name'];
							array_push($array_uni_id,1);
							//$output[] =  $uname;
						}
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice']);		
							$uname1 = $university[0]['name'];
							//$output[] =  $uname;
						}
						
							
						//$output[] =  "2)";
						$uname2 ="";					
						if($region == $app['university_choice_two_state']){						
							$university = $this->common_model->getUniversityById($app['universty_choice_two']);
							$uname2 = $university[0]['name'];
							
							//$output[]= $uname;
							array_push($array_uni_id,2);
						}						
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice_two']);	
							$uname2 = $university[0]['name'];
							//$output[] = $uname;
						}
						//$output[] = "3)";
						$uname3 ="";
						
						if($region == $app['university_choice_three_state']){							
							$university = $this->common_model->getUniversityById($app['universty_choice_three']);
							$uname3 = $university[0]['name'];
							array_push($array_uni_id,3);
							//$output[] =  $uname;
						}
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice_three']);
							$uname3 = $university[0]['name'];
							//$output[] = $uname;
						}	
						
						$universityDetails .= '1) '.$uname1.'<br/>';
				        $universityDetails .= '2) '.$uname2.'<br/>';
				        $universityDetails .= '3) '.$uname3.'<br/>';
						$output[] = $universityDetails;	
							$sts1 = $this->common_model->isAnyUniversityResponseConfirmToHqrs($app['application_no']);
							if(count($sts1)<=0)
						{
						$hqrsConfirm = '';
						
						if(count($array_uni_id)>0)
						{
								foreach($array_uni_id as $optionNo)
								{
									$hqrsConfirm1 = '';
									if($optionNo == 1)
									{
																	
						
						              $hqrsConfirm1= '<a style="height:34px;width:140px;" class="form-control sbmt" target="_blank"  href="'.site_url().'regional/application/'.$app['application_no'].'">Confirm to Hqrs</a>';
									
									$hqrsConfirm .= $hqrsConfirm1;
						
									}
									
									$hqrsConfirm2 = '';
									if($optionNo == 2)
									{
															
						$hqrsConfirm2 = '<a style="height:34px;width:140px;" class="form-control sbmt" target="_blank"  href="'.site_url().'regional/application/'.$app['application_no'].'">Confirm to Hqrs</a>';
										
										
										   $hqrsConfirm .= $hqrsConfirm2;
									}
									$hqrsConfirm3 = '';
									if($optionNo == 3)
									{
																
						$hqrsConfirm3= '<a style="height:34px;width:140px;" class="form-control sbmt" target="_blank"  href="'.site_url().'regional/application/'.$app['application_no'].'">Confirm to Hqrs</a>';
										  $hqrsConfirm .= $hqrsConfirm3;
									}
								}
						
				     
				      
						$output[] = $hqrsConfirm;	
							}	
						}
						else
						{
							
						$output[]  ='<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Confirm to Hqrs"/>';
							
							
							
						}
						$output[] = date("Y-m-d", $app['created']);
						
						$output[] = $date2;
						/* $date = date_create($app['created']);
						$array =  (array) $date;
					    $output[] = date("Y-m-d", strtotime($array['date'])); */
						$output[] ="NA";
						
							}
							elseif(count($sts) > 0)
							{
								
					    $output[] = $counter;
						$output[] = $app['application_no']; 
					    $output[] = $app['fullname'];
						$output[] = $app['email'];
						$output[] = $app['country_name'];
						$sch = $this->common_model->getSchemeById($app['scholarship_id']);
					    $output[] = $sch[0]['scheme_name'];
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							$output[] =  $course[0]['name'].' '.$app['course_subject'];
						}
						else
						{
							$course = $this->common_model->getCoursesById($app['course']);
							$course1 = $this->common_model->getCoursesById($app['course_two']);
							$course2 = $this->common_model->getCoursesById($app['course_three']);
							$fullCourse ="";
							
							$fullCourse .=$course[0]['title'].' '.$app['course_option_name'].'<br/>';
							$fullCourse .= $course1[0]['title'].' '.$app['course_option_name_two'].'<br/>';
							$fullCourse .= $course2[0]['title'].' '.$app['course_option_name_three'].'<br/>';
							$output[] = $fullCourse;
						}
						$universityDetails = '';
						$uname1 ="";$array_uni_id = array();
						//$output[] =  "1) ";
						if($region == $app['university_choice_one_state']){
							$university = $this->common_model->getUniversityById($app['universty_choice']);		
							$uname1 = $university[0]['name'];
							array_push($array_uni_id,1);
							//$output[] = $uname;
						}
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice']);		
							$uname1 = $university[0]['name'];
							//$output[] = $uname;
						}
					
							
						//$output[] = 	echo "2) ";
						$uname2 ="";					
						if($region == $app['university_choice_two_state']){						
							$university = $this->common_model->getUniversityById($app['universty_choice_two']);
							$uname2 = $university[0]['name'];
							
							//$output[] =  $uname;
							array_push($array_uni_id,2);
						}						
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice_two']);	
							$uname2 = $university[0]['name'];
							//$output[] = $uname;
						}
						
						
							//$output[] = "3) ";
						$uname3 ="";
						
						if($region == $app['university_choice_three_state']){							
							$university = $this->common_model->getUniversityById($app['universty_choice_three']);
							$uname3 = $university[0]['name'];
							array_push($array_uni_id,3);
							//$output[] = $uname;
						}
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice_three']);
							$uname3 = $university[0]['name'];
							//$output[] = $uname;
						}
					
						$universityDetails .= '1) '.$uname1.'<br/>';
				        $universityDetails .= '2) '.$uname2.'<br/>';
				        $universityDetails .= '3) '.$uname3.'<br/>';
						$output[] = $universityDetails;	
							$isAccept = FALSE;$uiver = array();
							foreach($sts as $st)
							{
								if($st['university_is_accept']==1)
								{
									$isAccept = TRUE;
								}
								$uiver[$st['regional_university']] = $st;
							}	
							
							$sts1 = $this->common_model->isAnyUniversityResponseConfirmToHqrs($app['application_no']);
				
						
							if(count($array_uni_id)>0)
							{
								if(count($sts1)<=0)
						           {
								foreach($array_uni_id as $optionNo)
								{
									
									if($optionNo == 1)
									{
										if(count($sts) > 0)
										{	
											if(array_key_exists($app['universty_choice'],$uiver))	
											{
												if($uiver[$app['universty_choice']]['university_is_accept']==1 || $uiver[$app['universty_choice']]['university_is_accept']==2)
												{
													if($uiver[$app['universty_choice']]['university_is_accept'] == 1)
													{
														$output[] =  "(A) for (".$optionNo.") Sent to Hqrs </br>";
													}
													elseif($uiver[$app['universty_choice']]['university_is_accept'] == 2)
													{
														$output[] = "(R) for (".$optionNo.") Sent to Hqrs </br>";	
													}
													
												}
											}		
											else
											{											
											
												
												$output[] = '<a style="height:34px;width:140px;" class="form-control sbmt" target="_blank"  href="'.site_url().'regional/application/'.$app['application_no'].'">Confirm to Hqrs</a>';
													
											}											
										}
									}
						}
								}else{
							
							
							$output[] ='<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Confirm to Hqrs"/>';
							
						}
						$output[] = date("Y-m-d", $app['created']);
						
						$output[] = $date2;
						if(count($array_uni_id)>0)
							{
						if(count($sts1)<=0)
						           {
									   foreach($array_uni_id as $optionNo)
								{
									if($optionNo == 2)
									{
										if($sts1 > 0)
										{
											if(array_key_exists($app['universty_choice_two'],$uiver))	
											{
												if($uiver[$app['universty_choice_two']]['university_is_accept']==1 || $uiver[$app['universty_choice_two']]['university_is_accept']==2)
												{
													if($uiver[$app['universty_choice_two']]['university_is_accept'] == 1)
													{
														$output[] = "(A) for (".$optionNo.") Sent to Hqrs </br>";
													}
													elseif($uiver[$app['universty_choice_two']]['university_is_accept'] == 2)
													{
														$output[] = "(R) for (".$optionNo.") Sent to Hqrs </br>";	
													}
												}
											}		
											else
											{	
												$output[] = '<a style="height:34px;width:140px;" class="form-control sbmt" target="_blank"  href="'.site_url().'regional/application/'.$app['application_no'].'">Confirm to Hqrs</a>';
												
											}											
										}
										
									}
								}
								   }
							}
								   else
								   {
									
								
							$output[] ='<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Confirm to Hqrs"/>';
							
									
								   }
								   if(count($array_uni_id)>0)
							{
								   if(count($sts1)<=0)
						           {
									   foreach($array_uni_id as $optionNo)
								{
									if($optionNo == 3)
									{
										if(count($sts)>0)
										{
											if(array_key_exists($app['universty_choice_three'],$uiver))	
											{
												if($uiver[$app['universty_choice_three']]['university_is_accept']==1 || $uiver[$app['universty_choice_three']]['university_is_accept']==2)
												{
													if($uiver[$app['universty_choice_three']]['university_is_accept'] == 1)
													{
														$output[]= "(A) for (".$optionNo.") Sent to Mission </br>";
													}
													elseif($uiver[$app['universty_choice_three']]['university_is_accept'] == 2)
													{
														$output[]= "(R) for (".$optionNo.") Sent to Mission </br>";	
													}
												}
											}		
											else
											{
												
												$output[] = '<a style="height:34px;width:140px;" class="form-control sbmt" target="_blank"  href="'.site_url().'regional/application/'.$app['application_no'].'">Confirm to Hqrs</a>';
												
											}											
										}
										
									}
								}
								}
							}
								else
								{
							
							$output[]='<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Confirm to Hqrs"/>';
				
									
								}
						
							}	
		
						
							if($sts[0]['region_one_status'] == $region)
							{
						
						$output[] = '<a style="height:34px;width:140px;" class="form-control sbmt1" target="_blank"  href="'.site_url().'regional/universityResponse/'.$app['application_no'].'">View</a>';
						
							
							
							}
							elseif($sts[0]['region_one_status'] != $region)
							{
								$output[] = "NA";	
							}
						
							}
						}
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
	
	
	public function forwardtohqrsdemohqrsregion()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
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
			
			/* $data= array(
            'iccr_status' => 1,
            'status' => 10,
			'region_forward_mission_status'=>18,
			'iccr_status_date' =>time() */
        //);
			$data1 = array(
				'region_one_status'=>$regionid,
				'region_one_status_date'=>time(),
				'region_one_doc'=>$imgname,
				'regional_university'=> $this->input->post("regional_university"),
				'university_is_accept'=> $this->input->post("university_is_accept"),
				'application_id'=>$appno,
				'status'=>9,
				'is_gov_private'=>$this->input->post("is_gov_private"),
				'confirmed_course'=>$this->input->post("confirmedCourse"),
				'course'=>$this->input->post("course")	
			);				
			$stsUni = $this->common_model->alreadyApprovedUniversity($appno);	
			if(count($stsUni)>=0)
			{
				$sts = $this->common_model->ForwardToHqrs($data1,$appno);
                //$sts1 = $this->common_model->ConfirmationForwardToMissionByHqrs($data, $appno);				
				$applicationData = $this->common_model->getApplicationData($appno,0);
				$userdata = $this->common_model->getUserData($applicationData[0]['uid']);	
				if($sts)
				{
					$body = "We are pleased to inform you that you have been provisionally selected for award of scholarship to persue 2017 year\'s studies at Delhi University.<br/><br/>";
					//$mailsend = $this->sendMail($body,$userdata[0]['email_id'],"Your Application ".$appno." is approved for ICCR scholarship.","mail_not_process");
					$mailsend = TRUE;
					if($mailsend)
					{
						$mailsend1 = $this->sendMail($body,"diritc.iccr@gov.in","Application ".$appno." is confirmed at regional office.","mail_not_process");
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
						redirect(site_url().'regional/universityapplications1');						
					}
					else
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Application Forwarded Successfully!');
						redirect(site_url().'regional/universityapplications1');							
					}
					 
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Forwarding Applicaiton!');
					redirect(site_url().'regional/universityapplications1');						
				}
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Already Approved By Other University!');
				redirect(site_url().'regional/universityapplications1');				
			}		
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'nternal Server Error. Try After Some Time.');
			redirect(site_url().'regional/universityapplications1');	
		}
	}
	
	
	function getUniversityResponseSentByRegionToMission() { 
		
		$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];
		$data['regionName'] = $this->common_model->getRegionById($regionid);
        $res = array(
            'iccr_status' => 1,
            'status' => 10,
			'region_forward_mission_status'=>18
			
        );      
      
        $data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByRegionToMission($res,$regionid);
		//echo "<pre>";
		//print_r($data['responseSetByHqToMission']);die;
        $this->load->view('regional/header_regional');
        $this->load->view('regional/getUniversityResponseSentByRegionToMission',$data);
        $this->load->view('regional/footer');
      
    }
		function get_universityResponseSentByRegionToMission() { 
		
		$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];		
        $res = array(
            'iccr_status' =>1,
            'status' =>10,
			'region_forward_mission_status'=>18
        );      
      
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->Regional_model->getUniversityResponseSentByRegionToMission($vars,$res,$regionid);
		$totalResult = $this->Regional_model->getTotalUniversityResponseSentByRegionToMission($vars,$res,$regionid);
		//$response1 = array();
		$counter++;
		if(!empty($result))
		{
			foreach($result as $r)
			{
				$output= array();
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				$response1 = $this->common_model->getUniversityResponses($r['application_no']);
				//echo "<pre>";
				//print_r($response1);
				$resp = explode(',', $response1[0]['response']);
				if($response1[0]['response'] != "2,2,2") 
				{
					
					            $output[] = $counter;				
                                $output[] = $r['fullname']; 
                                $output[] = $r['email']; 
                                $output[] = $r['country_name'];	
								$sch = $this->common_model->getSchemeById($r['scholarship_id']);
                                $output[] = $sch[0]['scheme_name'];
								$unii = 0;
                                $resp = explode(',', $response1[0]['response']);
                                $cnt = 0;
                                $uniar = array();
                                $universties = explode(',', $response1[0]['University']);
								//echo "<pre>";
								//print_r($universties);die;
                                    foreach ($resp as $res) {
                                        if ($res == 1) {
                                            $unii = $universties[$cnt];
                                            $uniar[$universties[$cnt]] = $res;
                                        } else {
                                            $uniar[$universties[$cnt]] = $res;
                                        }
                                        $cnt++;
                                    }
                                    $course = "";
                                    foreach ($uniar as $key => $u) {
                                        $c = $this->common_model->getCourseDetails($r['application_no'], $key);
                                        $course .= $c['course_name'];
                                        if ($c['subject'] != "")
                                            $course .= $c['subject'];
                                        $course .= "<br/>";
                                    }
                                    $output[] =  $course;
									$universityDetails = "";
									$universties = explode(',', $response1[0]['University']);
                                    foreach ($universties as $uni) {
                                        $u = $this->common_model->getUniversityById($uni);
										$universityDetails .= $u[0]['name'];
										$universityDetails .="</br>";
                                       
                                    }
									$output[] = $universityDetails;
									
									$regionDetails = "";
                                    $regions = explode(',', $response1[0]['regional_office']);
                                    foreach ($regions as $reg) {
                                        $rg = $this->common_model->getRegionById($reg);
                                        $regionDetails .= $rg[0]['name']."<br/>";
                                        $regionDetails .="</br>";
                                    }
									$output[] = $regionDetails;
									//$output[] = date("Y-m-d", $r['created']);
									if($r['course'] !=""){
                                    $output[] =  $r['course'];
                                    }else{
                                        $output[] =  'NA';
                                    }
									
									$resp = explode(',', $response1[0]['response']);
									$accepted = "";
									$decline = "";
                                    foreach ($resp as $res) {
                                        if ($res == 1){
										   $accepted .= "Accepted";
										   $accepted .= "</br>";
									}  
                                        elseif ($res == 2){
										   $decline .= "Declined";
										   $decline .= "</br>";
										}
                                    }
									$output[] = $accepted."</br>".$decline;
									if(!empty($r['created'])){
								$output[] = date("Y-m-d",$r['created']);
								}else{
									$output[] =  "NA";
								}
									
									//$output[] = $decline;
									if ($r['status'] == 4) {
                                        $userdata = $this->session->userdata('user_data');
                                        $division = $userdata['state'];
                                        if ($division == 1 || $division == 11 || $division == 12) {
                                            foreach ($uniar as $keyid => $respppp) {
                                                if ($respppp == 1) {
                                                 
                                                   $output[] = '<a class="form-control sbmt" style="height:42px;width:140px;" href="'.site_url().'headquarter/beforeconfirmtoMission/'.$r['application_no'].'/'.$keyid.'">(A) Forward To Mission</a>';
                                                } elseif ($respppp == 2) {
                                                   $output[] = '<a class="form-control sbmt" style="height:42px;width:140px;" href="'.site_url().'headquarter/beforerejectiontoMission/'.$r['application_no'].'/'.$keyid.'">(R) Forward To Mission</a>';   
                                                }
                                            }
                                        } else {
                                            $output[] = "Not Authorised";
                                        }
                                    } elseif ($r['status'] >= 10) {
                                        $output[] = "Forwarded to Mission";
                                    }
                             

                                   
                                   /*  $sts = 0;
                                    foreach ($response1 as $resp) {
                                       if ($resp['University'] == $r['universty_choice_three'] || $resp['University'] == $r['universty_choice_two'] || $resp['University'] == $r['universty_choice']) {
                                            $sts++;
                                            if ($resp['response'] == 1) {
                                             
                                               $output[] =  '<a target="_blank" href="'.site_url().'headquarter/confirmationReceivedWithFormat/'.$r['application_no'].'/'.$resp['University'].'" target="_blank">Download</a>';

                        
                    } elseif ($resp['response'] == 2) {
                    
                                               $output[] =  '<a target="_blank" href="'.site_url().'headquarter/confirmationNotReceivedWithFormat/'.$r['application_no'].'/'.$resp['University'].'" target="_blank">Download</a>';
                                                
                                            }
                                        }
                                    }
                                    if ($sts == 0) {
                                        $output[] = "NA";
                                    } */
                                   

                             
                            
                               if(!empty($r['region_one_doc'])){
                                 $output[] = '<a target="_blank" href="'.site_url().'assets/site/main/university_approval/'. $r['region_one_doc'].'" target="_blank">Download</a>';
                               
                                
                               } else {
                                $output[] =  "NA";
                                }
								if(!empty($r['iccr_status_date'])){
								$output[] = date("Y-m-d",$r['iccr_status_date']);
								}else{
									$output[] =  "NA";
								}
                        $response[] = $output;
				        $counter++; 
					
				}
				
				
			}
			
		}
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = $totalResult[0]['total'];
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	  
        //$data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByHqrsToMission($res);
      
    
}
	function getUniversityResponseSentByRegionToMissionDemo() { 
		
		$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];
		$data['regionName'] = $this->common_model->getRegionById($regionid);
        $res = array(
            'iccr_status' => 1,
            'status' => 10,
			'region_forward_mission_status'=>18
			
        );      
      
        //$data['responseSetByHqToMission']  = $this->common_model->getUniversityResponseSentByRegionToMission($res,$regionid);
		//echo "<pre>";
		//print_r($data['responseSetByHqToMission']);die;
        $this->load->view('regional/header_regional');
        $this->load->view('regional/getUniversityResponseSentByRegionToMissionDemo',$data);
        $this->load->view('regional/footer');
      
    }
	public function applicationDemoA2a()
	{
		
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
			$data['missions'] = $this->common_model->getAllMissions();
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
			$this->load->view('regional/header_regional');
			$this->load->view('regional/applicant_personal_info1',$data);
			$this->load->view('regional/footer');
		}
		else
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Application Already Approved!');
			redirect(site_url().'regional/universityapplications');		
		}
	}
	

	
		
 //edit Expenditure
	
	function editExpenditure()
    {
		//echo '<pre>';
		//print_r($_POST);die;
		//echo $appid;die;
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getExpenditureDetails($appId);
		 //echo "<pre>";
		 //print_r($expenditureDetails);die;
		//$response = array();
		//if(!empty($studends))
		//{
			//$counter = 1;
			//$sum = 0S;
			  $htm  ="<form action='".site_url().'regional/studentExpenditureSave/'.$appId."' method='post' enctype='multipart/form-data'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>From</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' name = 'stipend_from' value = '".$expenditureDetails[0]['adv_stipend_from']."' placeholder='From'>";
			  
			  $htm .="</div>";
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>To</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_from' id='inputPassword4'  value = '".$expenditureDetails[0]['adv_stipend_to']."' placeholder='Password'>";
			  $htm .="</div>";
			  $htm .="</div>";				
            
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' name='adv_stipend_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['adv_stipend_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['adv_stipend_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['adv_stipend_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['adv_stipend_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['adv_stipend_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
           
			
		      $htm .="<divs class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'adv_stipend_amount' id='inputPassword4'  value = '".$expenditureDetails[0]['adv_stipend_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  $htm .="<divs class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  //$htm .="<input type='file' name = 'doc' class='form-control' id='inputPassword4'>";
			  
			  $htm .="<a href='#' data-toggle='modal' class='upload_link' data-target = '#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<divs class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_off_name' id='inputPassword4' value = '".$expenditureDetails[0]['adv_stipend_off_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
			  $htm .="<divs class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			   if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['adv_stipend_off_sign']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input type='file' class='form-control' name = 'adv_stipend_off_sign' id='inputPassword4'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='form-control sbmit' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
              $htm .="</form>";
              echo $htm;
              exit;
				
				
				
			//}
			
			
		}
		
		
		public function uploadExpenditure()
		{
			try
			{
				$files = $_FILES['file']; 
               //echo "<pre>";
				//print_r($files);die;  
				$typpe = $_FILES['file']['type'];    
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
					$imgname = time().'_expenditure_doc_'.$name;
					
					$target_file = $target_file.$imgname;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) { 		
						$data = array(
			  			'doc'=>$imgname,
			  			'doc_path'=>$target_file,
			  			'doc_type'=>$types['indian_address']['type'],
			  			'added_on'=>time(),
			  			'uid'=>$userId,
			  			'application_no'=>$applicatinNo[0]['application_no']
						);			  	  
						if($this->common_model->updateExpeDocuments($data))
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
		
		
		function studentAdvanceStipend(){
		
		$applicationId = $this->uri->segment(3);
		
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		//$getAdvanceStipendDetails = $this->common_model->getAdvanceStipendDetails($applicationId,"New");
		//echo "<pre>";
		$getAdvanceStipendDetails = $this->common_model->getAdvanceStipendDetailsWithoutType($applicationId);
		//print_r($getAdvanceStipendDetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of Advance Stipend Released in Financial Year <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
							 		echo '<th> From</th>';
							 		echo '<th> To</th>';
							 		//echo '<th> Mode</th>';
							 		echo '<th> Amount</th>';
							 		echo '<th> Date</th>';
									echo '<th> View</th>';
									echo '<th> Edit</th>';
						 		    echo '</thead>';
						 		    echo '<tbody>';
						 								 			
						 				if(isset($getAdvanceStipendDetails) && !empty($getAdvanceStipendDetails))
						 				{
											foreach($getAdvanceStipendDetails as $stp)
											{
												echo '<tr>';
												echo '<td>'.$stp['adv_stipend_from'].'</td>';
												echo '<td>'.$stp['adv_stipend_to'].'</td>';
												//echo '<td>'.getMode($stp['adv_stipend_mode']).'</td>';
												echo '<td>'.$stp['adv_stipend_amount'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
												if($stp['doc']){
				  echo "<td><a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$stp['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br><?td>"; 
			  }
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editAdvanceStipendExp('.$stp['id'].')">Edit</button></td>';
												echo '</tr>';
												
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	
		function studentHostel(){
		
		$applicationId = $this->uri->segment(3);
		
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		//$getHRADetails= $this->common_model->getHostelDetails($applicationId,"New");
		$getHRADetails= $this->common_model->getHostelDetailsWithoutType($applicationId);
		
		//echo "<pre>";
		//print_r($getHRADetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of HRA Released in Financial Year <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
									
									echo '<th> From</th>';
							 		echo '<th> To</th>';
									//echo '<th> City</th>';
							 		//echo '<th> Mode</th>';
							 		echo '<th> Amount</th>';
							 		echo '<th> Date</th>';
									echo '<th> View</th>';
									echo '<th>Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 				$cities = $this->config->item('grade_cities');			
						 				if(isset($getHRADetails) && !empty($getHRADetails))
						 				{
											foreach($getHRADetails as $hra)
											{
												echo '<tr>';
												
												echo '<td>'.$hra['hos_from'].'</td>';
												echo '<td>'.$hra['hos_to'].'</td>';
												echo '<td>'.$hra['hos_amount'].'</td>';
												//echo '<td>'.getMode($hra['hra_mode']).'</td>';
												
												//echo '<td>'.$hra['hra_cno'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$hra['created']).'</td>';		
												if($stp['doc']){
				  echo "<td><a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$hra['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br><?td>"; 
			  }
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editHostelExp('.$hra['id'].')">Edit</button></td>';					
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	
		function tutionFee(){
		
		$applicationId = $this->uri->segment(3);
		
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		//$getHRADetails= $this->common_model->getHRADetails($applicationId,"New");
		$getTutionDetails= $this->common_model->getTutionFeeDetailsWithOutType($applicationId);
		//echo "<pre>";
		//print_r($getHRADetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of HRA Released in Financial Year <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
									echo '<th> Release Date</th>';
							 		echo '<th> Amount</th>';
										
							 		echo '<th> Date</th>';
									echo '<th> Date</th>';
									echo '<th>Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 				$cities = $this->config->item('grade_cities');			
						 				if(isset($getTutionDetails) && !empty($getTutionDetails))
						 				{
											foreach($getTutionDetails as $tution)
											{
												echo '<tr>';
												echo '<td>'.$tution['tf_release_date'].'</td>';
												
												echo '<td>'.$tution['tf_amount'].'</td>';
												//echo '<td>'.getMode($hra['hra_mode']).'</td>';
												
												if($tution['doc']){
				  echo "<td><a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$tution['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br><?td>"; 
			  }
												echo '<td>'.date('d M Y h:i:s A',$tution['created']).'</td>';		
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editTutionFeeExp('.$tution['id'].')">Edit</button></td>';					
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
		function studentHRA(){
		
		$applicationId = $this->uri->segment(3);
		
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		//$getHRADetails= $this->common_model->getHRADetails($applicationId,"New");
		$getHRADetails= $this->common_model->getHRADetailsWithOutType($applicationId);
		//echo "<pre>";
		//print_r($getHRADetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of HRA Released in Financial Year <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
									echo '<th> City</th>';
									echo '<th> From</th>';
							 		echo '<th> To</th>';
									//echo '<th> City</th>';
							 		//echo '<th> Mode</th>';
							 		echo '<th> Amount</th>';
							 		echo '<th> Date</th>';
									echo '<th> View</th>';
									echo '<th>Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 				$cities = $this->config->item('grade_cities');			
						 				if(isset($getHRADetails) && !empty($getHRADetails))
						 				{
											foreach($getHRADetails as $hra)
											{
												echo '<tr>';
												echo '<td>'.$cities[$hra['hra_city']].'</td>';
												echo '<td>'.$hra['hra_from_date'].'</td>';
												echo '<td>'.$hra['hra_to_date'].'</td>';
												echo '<td>'.$hra['hra_amount'].'</td>';
												//echo '<td>'.getMode($hra['hra_mode']).'</td>';
												
												//echo '<td>'.$hra['hra_cno'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$hra['created']).'</td>';	
											if($hra['doc']){
												  echo "<td><a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$hra['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br><?td>"; 
											  }												
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editHRAExp('.$hra['id'].')">Edit</button></td>';					
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	
	function studentACA(){
		
		$applicationId = $this->uri->segment(3);
		//echo $applicationId;die;
		
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		//$getACADetails = $this->common_model->getACADetails($applicationId,"New");
		$getACADetails = $this->common_model->getACADetailsWithOutType($applicationId);
		//echo "<pre>";
		//print_r($getACADetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of Annual Contingent Allowance Released in Financial Year  <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
									
									//echo '<th> City</th>';
							 		echo '<th> Academic Year</th>';
							 		echo '<th> Amount</th>';
									echo '<th> Release Date</th>';
							 		echo '<th> Date</th>';
									echo '<th> View</th>';
									echo '<th>Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 					
						 				if(isset($getACADetails) && !empty($getACADetails))
						 				{
											foreach($getACADetails as $aca)
											{
												echo '<tr>';
												
												echo '<td>'.$aca['aca_year'].'</td>';
												echo '<td>'.$aca['aca_amount'].'</td>';
												//echo '<td>'.$aca['hra_amount'].'</td>';
												//echo '<td>'.getMode($aca['hra_mode']).'</td>';
												echo '<td>'.$aca['aca_release_date'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$aca['created']).'</td>';
												if($aca['doc']){
				  echo "<td><a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$aca['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br><?td>"; 
			  }
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editACAExp('.$aca['id'].')">Edit</button></td>';				
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	function studyTour(){

		$applicationId = $this->uri->segment(3);
		$getTourDetails = $this->common_model->getStudyTourDetailsWithOutType($applicationId);
		//echo "<pre>";
		//print_r($getHRADetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of Annual Contingent Allowance Released in Financial Year  <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
									
									echo '<th> From</th>';
									echo '<th> To</th>';
							 		echo '<th> Amount</th>';
									//echo '<th> Mode</th>';
							 		echo '<th> Date</th>';
									echo '<th>Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 					
						 				if(isset($getTourDetails) && !empty($getTourDetails))
						 				{
											foreach($getTourDetails as $tour)
											{
												echo '<tr>';
												
												echo '<td>'.$tour['st_from_date'].'</td>';
												echo '<td>'.$tour['st_to_date'].'</td>';
												echo '<td>'.$aca['st_amount'].'</td>';
												//echo '<td>'.getMode($aca['hra_mode']).'</td>';
												//echo '<td>'.$hra['hra_cno'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$tour['created']).'</td>';
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editTourExp('.$tour['id'].')">Edit</button></td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	
	function studentStipend(){
		
		$applicationId = $this->uri->segment(3);
		
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		$getStipendDetails = $this->common_model->getStipendDetailsWithOutType($applicationId);
		//$getStipendDetails = $this->common_model->getAdvanceStipendDetails($applicationId,"old");
		 //echo "<pre>";
		//print_r($getStipendDetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of Stipend Released in Financial Year <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
							 		echo '<th> From</th>';
							 		echo '<th> To</th>';
							 		//echo '<th> Mode</th>';
							 		echo '<th> Amount</th>';
							 		echo '<th> Date</th>';
									echo '<th> view</th>';
									echo '<th> Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 								 			
						 				if(isset($getStipendDetails) && !empty($getStipendDetails))
						 				{
											foreach($getStipendDetails as $stp)
											{
												echo '<tr>';
												echo '<td>'.$stp['stipend_from'].'</td>';
												echo '<td>'.$stp['stipend_to'].'</td>';
												//echo '<td>'.getMode($stp['stipend_mode']).'</td>';
												echo '<td>'.$stp['amount'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
												if($stp['doc']){
				  echo "<td><a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$stp['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br><?td>"; 
			  }
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editStipendExp('.$stp['id'].')">Edit</button></td>';
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	function medicalRebursment(){
		//echo "asaasa";die;
		$applicationId = $this->uri->segment(3);
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		//$getMedicalDetails = $this->common_model->getMedicalReimbursDetails($applicationId,"New");
		$getMedicalDetails = $this->common_model->getMedicalReimbursDetailsWithOutType($applicationId);
		//echo "<pre>";
		//print_r($getMedicalDetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of Annual Contingent Allowance Released in Financial Year  <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
									
									echo '<th>Release Date</th>';
							 		echo '<th> Amount</th>';
							 		echo '<th> Date</th>';
									echo '<th>Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 					
						 				if(isset($getMedicalDetails) && !empty($getMedicalDetails))
						 				{
											foreach($getMedicalDetails as $medical)
											{
												echo '<tr>';
												
												echo '<td>'.$medical['mr_release_date'].'</td>';
												echo '<td>'.$medical['mr_amount'].'</td>';
												//echo '<td>'.getMode($aca['hra_mode']).'</td>';
												//echo '<td>'.$hra['hra_cno'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$medical['created']).'</td>';
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editMedicalExp('.$medical['id'].')">Edit</button></td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	
	function thesis(){
		
		$applicationId = $this->uri->segment(3);
		//echo $applicationId;die;
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		$getThesisDetails = $this->common_model->getThesisChargesDetails($applicationId,"New");
		//echo "<pre>";
		//print_r($getMedicalDetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of Annual Contingent Allowance Released in Financial Year  <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
									
									echo '<th>Release Date</th>';
							 		echo '<th> Amount</th>';
							 		echo '<th> Date</th>';
									echo '<th>Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 					
						 				if(isset($getThesisDetails) && !empty($getThesisDetails))
						 				{
											foreach($getThesisDetails as $thesis)
											{
												echo '<tr>';
												
												echo '<td>'.$thesis['tc_release_date'].'</td>';
												echo '<td>'.$thesis['tc_amount'].'</td>';
												//echo '<td>'.getMode($aca['hra_mode']).'</td>';
												//echo '<td>'.$hra['hra_cno'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$thesis['created']).'</td>';
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editThesisExp('.$thesis['id'].')">Edit</button></td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	function miscellaneous(){
		
		$applicationId = $this->uri->segment(3);
		//echo $applicationId;die;
		//$getStipendDetails = $this->common_model->getStipendDetails($applicationId,"New");
		$getMiscellaneous = $this->common_model->getMiscDetailsWithOutType($applicationId);
		//echo "<pre>";
		//print_r($getMiscellaneous);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of Annual Contingent Allowance Released in Financial Year  <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
									
									echo '<th>Release Date</th>';
							 		echo '<th> Amount</th>';
							 		echo '<th> Release Date</th>';
									echo '<th>Edit</th>';
						 		echo '</thead>';
						 		echo '<tbody>';
						 					
						 				if(isset($getMiscellaneous) && !empty($getMiscellaneous))
						 				{
											foreach($getMiscellaneous as $miss)
											{
												echo '<tr>';
												
												echo '<td>'.$miss['msc_release_date'].'</td>';
												echo '<td>'.$miss['msc_amount'].'</td>';
												echo '<td>'.($miss['msc_release_date']).'</td>';
												//echo '<td>'.$hra['hra_cno'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$miss['created']).'</td>';
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editMiscellaneousExp('.$miss['id'].')">Edit</button></td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}
	public function editStudentStipendDetails()
	{
		
		try
		{
			$appid = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['expenditureDetails'] = $this->Regional_model->getStipendDetails($appid);
			$this->load->view('regional/header_regional');		
			$this->load->view('regional/studentEditStipendForm',$data);
			$this->load->view('regional/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/expenditureStatement');				
		}
	}
	
	
	
	function editStipendExpenditure()
    {
		//echo '<pre>';
		//print_r($_POST);die;
		//echo $appid;die;
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getStipenedExpenditureDetails($appId);
		 //echo "<pre>";
		 //print_r($expenditureDetails);die;
		//$response = array();
		//if(!empty($studends))
		//{
			//$counter = 1;
			//$sum = 0S;
			  $htm  ="<form action='".site_url().'regional/studentExpenditureSave/'.$appId."' method='post' enctype='multipart/form-data'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>From</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' name = 'stipend_from' value = '".$expenditureDetails[0]['adv_stipend_from']."' placeholder='From'>";
			  
			  $htm .="</div>";
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>To</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_from' id='inputPassword4'  value = '".$expenditureDetails[0]['adv_stipend_to']."' placeholder='Password'>";
			  $htm .="</div>";
			  $htm .="</div>";				
            
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' name='adv_stipend_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['adv_stipend_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['adv_stipend_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['adv_stipend_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['adv_stipend_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['adv_stipend_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
           
			
		      $htm .="<divs class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'adv_stipend_amount' id='inputPassword4'  value = '".$expenditureDetails[0]['adv_stipend_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  $htm .="<divs class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  //$htm .="<input type='file' name = 'doc' class='form-control' id='inputPassword4'>";
			  
			  $htm .="<a href='#' data-toggle='modal' class='upload_link' data-target = '#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<divs class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_off_name' id='inputPassword4' value = '".$expenditureDetails[0]['adv_stipend_off_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
			  $htm .="<divs class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			   if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['adv_stipend_off_sign']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input type='file' class='form-control' name = 'adv_stipend_off_sign' id='inputPassword4'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='form-control sbmit' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
              $htm .="</form>";
              echo $htm;
              exit;
				
				
				
			//}
			
			
		}
		
			function editAdvancStipenedExpenditure()
    {
		
		$appId = $_POST['appno'];
		//echo $appId;die;
		$expenditureDetails = $this->Regional_model->getAdvanceStipendDetails($appId);
		//echo "<pre>";print_r($expenditureDetails);die;
			$htm  ="<form action='".site_url().'regional/studentStipenedExpenditureSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name='appId' value = '".$expenditureDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>From - (Format - dd/mm/yyyy)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'stipend_from_id' name = 'adv_stipend_from' value = '".$expenditureDetails[0]['adv_stipend_from']."' placeholder='From'>";
			  
			  $htm .="</div>";
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>To-  (Format - dd/mm/yyyy)</label>";
			  $htm .="<input type='text' class='form-control' name = 'adv_stipend_to' id='adv_stipend_to'  value = '".$expenditureDetails[0]['adv_stipend_to']."' placeholder='Password'>";
			  $htm .="</div>";
			  $htm .="</div>";				
				
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='adv_stipend_mode' name='adv_stipend_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['adv_stipend_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['adv_stipend_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['adv_stipend_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['adv_stipend_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['adv_stipend_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>"; */
           
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'adv_stipend_amount' id='adv_stipend_amount'  value = '".$expenditureDetails[0]['adv_stipend_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			 /*  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile' required>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'adv_stipend_off_name' id='inputPassword4' value = '".$expenditureDetails[0]['adv_stipend_off_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='adv_stipend_off_sign' id='inputPassword4' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
			 /*  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['adv_stipend_off_sign']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='adv_stipend_off_sign' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['adv_stipend_off_sign']."'/></a></br>";
			    */
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}
		
		
		
		
		
		
		
							function editHostelExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getHostelDetails($appId);
		
			$htm  ="<form action='".site_url().'regional/studentHostelExpenditureAdvanceSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			   $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-4'>";
			  
			  $htm .="<label for='inputEmail4'>From- (Format- dd/mm/yyyy)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'hos_from' name = 'hos_from' value = '".$expenditureDetails[0]['hos_from']."' placeholder='dd/mm/yyyy'>";
			  
			  $htm .="</div>";
			  $htm .="<div class='form-group col-md-4'>";
			  $htm .="<label>To - (Format- dd/mm/yyyy)</label>";
			  $htm .="<input type='text' class='form-control' name ='hos_to' id='hos_to'  value = '".$expenditureDetails[0]['hos_to']."' placeholder='dd/mm/yyyy'>";
			  $htm .="</div>";
			  $htm .="</div>";				
				
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='stipend_mode' name='stipend_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['stipend_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['stipend_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['stipend_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['stipend_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['stipend_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
            */
			
		      $htm .="<div class='form-group col-md-4'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'hos_amount' id='hos_amount'  value = '".$expenditureDetails[0]['hos_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile' required>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_off_name' id='inputPassword4' value = '".$expenditureDetails[0]['stipend_off_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='stipend_off_sign' id='inputPassword4' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
/* 			  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['stipend_off_sign']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='stipend_off_sign' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['stipend_off_sign']."'/></a></br>"; */
			   
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}
		
		
		
		
		public function studentHostelExpenditureAdvanceSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			$app_id =$cleanData['application_id'];
			//echo "<pre>";
			//print_r($cleanData);die;
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['hos_off_sign']['name']))
					{
						$file_name=$_FILES["hos_off_sign"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['hos_off_sign']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'hos_off_sign'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['hos_off_sign']["size"] <= 0 || $_FILES['hos_off_sign']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["hos_off_sign"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['hos_off_sign']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['hos_off_sign'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
				 			
				 //$appid = $cleanData['app_id'];
				 $data = array(
				 'hos_from'=>$cleanData['hos_from'],
				 'hos_to'=>$cleanData['hos_to'],
				 'hos_amount'=>$cleanData['hos_amount'],
				 'created'=>time()
				 );
				//echo $appid;
				//echo "<pre>";print_r($data);die;
				 
			 	 $result = $this->Regional_model->updateHostelExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
		
					function editStipenedExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getStipendDetails($appId);
		
			$htm  ="<form action='".site_url().'regional/studentStipenedExpenditureAdvanceSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			   $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-4'>";
			  
			  $htm .="<label for='inputEmail4'>From- (Format- dd/mm/yyyy)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'stipend_from_id' name = 'stipend_from' value = '".$expenditureDetails[0]['stipend_from']."' placeholder='dd/mm/yyyy'>";
			  
			  $htm .="</div>";
			  $htm .="<div class='form-group col-md-4'>";
			  $htm .="<label>To - (Format- dd/mm/yyyy)</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_to' id='stipend_to'  value = '".$expenditureDetails[0]['stipend_to']."' placeholder='dd/mm/yyyy'>";
			  $htm .="</div>";
			  $htm .="</div>";				
				
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='stipend_mode' name='stipend_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['stipend_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['stipend_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['stipend_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['stipend_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['stipend_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
            */
			
		      $htm .="<div class='form-group col-md-4'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'amount' id='amount'  value = '".$expenditureDetails[0]['amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile' required>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_off_name' id='inputPassword4' value = '".$expenditureDetails[0]['stipend_off_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='stipend_off_sign' id='inputPassword4' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
/* 			  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['stipend_off_sign']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='stipend_off_sign' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['stipend_off_sign']."'/></a></br>"; */
			   
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}
		
	function editHRAExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getHRADetails($appId);
			$htm  ="<form action='".site_url().'regional/studentHRAExpenditureAdvanceSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>From- Format(dd/mm/yyyy)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'hra_from_date' name = 'hra_from_date' value = '".$expenditureDetails[0]['hra_from_date']."' placeholder='From'>";
			  
			  $htm .="<label for='inputEmail4'>To - Format(dd/mm/yyyy)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'hra_to_date' name = 'hra_to_date' value = '".$expenditureDetails[0]['hra_to_date']."' placeholder='From'>";
			 			
				/* 
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='hra_mode' name='hra_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['hra_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['hra_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['hra_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['hra_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['hra_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
            */
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'hra_amount' id='hra_amount'  value = '".$expenditureDetails[0]['hra_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			   /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>";  
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile' required>"; */
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'hra_official_name' id='hra_official_name' value = '".$expenditureDetails[0]['hra_official_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'hra_to_date' id='hra_official_name' value = '".$expenditureDetails[0]['hra_to_date']."' placeholder='Name'>";
			  $htm .="</div>";
		   
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='aca_official_name' id='inputPassword4' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
			 /*  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['hra_signature']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='hra_signature' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['hra_signature']."'/></a></br>"; */
			   
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}



function editACAExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getACADetails($appId);
			$htm  ="<form action='".site_url().'regional/studentACAExpenditureAdvanceSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>Release Date-(Format - dd//mm/yyyy)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'aca_release_date' name = 'aca_release_date' value = '".$expenditureDetails[0]['aca_release_date']."' placeholder='From'>";
			  
			
			 			
				
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='aca_mode' name='aca_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['aca_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['aca_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['aca_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['aca_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['aca_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>"; */
           
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'aca_amount' id='aca_amount'  value = '".$expenditureDetails[0]['aca_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile'>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>"; */
		   
			
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'aca_official_name' id='aca_official_name' value = '".$expenditureDetails[0]['aca_official_name']."' placeholder='Name'>";
			  $htm .="</div>"; */
		   
		   
			/*   $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='aca_signature' id='inputPassword4' required>";
			  $htm .="</div>";  */
			 
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
			 /*  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['aca_signature']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='aca_signature' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['aca_signature']."'/></a></br>";
			   */
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}
	function editTourExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getTourDetails($appId);
			$htm  ="<form action='".site_url().'regional/studentTourExpenditureAdvanceSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>Release Date</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'aca_release_date' name = 'aca_release_date' value = '".$expenditureDetails[0]['aca_release_date']."' placeholder='From'>";
			  
			
			 			
				
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='aca_mode' name='aca_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['aca_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['aca_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['aca_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['aca_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['aca_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
           
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'aca_amount' id='aca_amount'  value = '".$expenditureDetails[0]['aca_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile'>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'aca_official_name' id='aca_official_name' value = '".$expenditureDetails[0]['aca_official_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='aca_signature' id='inputPassword4' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
			  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['aca_signature']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='aca_signature' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['aca_signature']."'/></a></br>";
			  
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}


function editMedicalExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getMedicalDetails($appId);
			$htm  ="<form action='".site_url().'regional/studentMedicalExpenditureAdvanceSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>Release Date</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'mr_release_date' name = 'mr_release_date' value = '".$expenditureDetails[0]['mr_release_date']."' placeholder='From'>";
			  
			
			 			
				
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='mr_mode' name='mr_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['mr_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['mr_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['mr_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['mr_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['mr_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
           
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'mr_amount' id='mr_amount'  value = '".$expenditureDetails[0]['mr_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile'>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'mr_official_name' id='mr_official_name' value = '".$expenditureDetails[0]['mr_official_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='mr_signature' id='mr_signature' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
			  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['mr_signature']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='mr_signature' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['mr_signature']."'/></a></br>";
			  
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}	
		
		
function editTutionFeeExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getTutionDetails($appId);
		//echo "<pre>";print_r($expenditureDetails);die;
			$htm  ="<form action='".site_url().'regional/studentTutionExpenditureSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>Release Date - Format(dd/mm/yyyy)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'tf_release_date' name = 'tf_release_date' value = '".$expenditureDetails[0]['tf_release_date']."' placeholder='From'>";
			  
			
			 			
				
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='mr_mode' name='mr_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['mr_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['mr_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['mr_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['mr_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['mr_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>"; */
           
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'tf_amount' id='tf_amount'  value = '".$expenditureDetails[0]['tf_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  /* $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile'>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>"; */
		   
			
			 /*  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'mr_official_name' id='mr_official_name' value = '".$expenditureDetails[0]['mr_official_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='mr_signature' id='mr_signature' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; 
			  
			  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['mr_signature']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='mr_signature' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['mr_signature']."'/></a></br>"; */
			  
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}	

function editThesisExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getThesisDetails($appId);
			$htm  ="<form action='".site_url().'regional/studentThesisExpenditureAdvanceSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>Release Date</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'tc_release_date' name = 'tc_release_date' value = '".$expenditureDetails[0]['tc_release_date']."' placeholder='From'>";
			  
			
			 			
				
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='tc_mode' name='tc_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['tc_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['tc_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['tc_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['tc_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['tc_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
           
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'tc_amount' id='tc_amount'  value = '".$expenditureDetails[0]['tc_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile'>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'mr_official_name' id='mr_official_name' value = '".$expenditureDetails[0]['mr_official_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='tc_signature' id='tc_signature' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
			  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['tc_signature']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='tc_signature' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['tc_signature']."'/></a></br>";
			  
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}
		function editMiscellaneousExpenditure()
    {
		
		$appId = $_POST['appno'];
		$expenditureDetails = $this->Regional_model->getMiscellDetails($appId);
		//echo "<pre>";print_r($expenditureDetails);die;
			$htm  ="<form action='".site_url().'regional/studentMiscellaneousExpenditureAdvanceSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'application_id' value = '".$expenditureDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>Release Date - Formate (dd/mm/yyyy)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'msc_release_date' name = 'msc_release_date' value = '".$expenditureDetails[0]['msc_release_date']."' placeholder='From'>";
			  
			
			 			
				
			 /*  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='msc_mode' name='msc_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['msc_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['msc_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['msc_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['msc_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['msc_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>"; */
           
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'msc_amount' id='msc_amount'  value = '".$expenditureDetails[0]['msc_amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			 /*  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='userfile'>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>"; */
		   
			
			 /*  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'msc_official_name' id='msc_official_name' value = '".$expenditureDetails[0]['msc_official_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='msc_signature' id='msc_signature' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
			/*   $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['msc_signature']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='msc_signature' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$expenditureDetails[0]['msc_signature']."'/></a></br>";  */
			  
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
             $htm .="</form>";
              echo $htm;
              exit;
		}
		
		public function studentStipenedExpenditureSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			$app_id =$cleanData['application_id'];
			//echo "<pre>";
			//print_r($cleanData);die;
			if(!empty($_FILES))
					{	
						$imgname4 = "";
						$imgname5 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname4 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname4);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname4; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname4;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid!.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
							
						}
						
					}
					
					if(!empty($_FILES['adv_stipend_off_sign']['name']))
					{
						$file_name=$_FILES["adv_stipend_off_sign"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['adv_stipend_off_sign']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid!.!');
							redirect('regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname5 = time().'adv_stipend_off_sign'.$name;
						$isValid_Extention_Size = explode('.',$imgname5);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid');
							redirect('regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['adv_stipend_off_sign']["size"] <= 0 || $_FILES['adv_stipend_off_sign']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect('regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["adv_stipend_off_sign"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['adv_stipend_off_sign']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname5; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['adv_stipend_off_sign'] = $imgname5;
						}
						else
						{
							
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid!.!');
							redirect('regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						
					}
						
					}
				 $data = array(
				 'adv_stipend_from'=>$cleanData['adv_stipend_from'],
				 'adv_stipend_to'=>$cleanData['adv_stipend_to'],
				 'adv_stipend_amount'=>$cleanData['adv_stipend_amount'],
				 'created'=>time()
				 );
			 	 $result = $this->Regional_model->updateAdvanceStipenedExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/expenditureStatement');					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/expenditureStatement');
		}
	}
	
	
	function editPromotedDetails()
    {
		
		$appId = $_POST['appno'];
		$academicDetails = $this->Regional_model->getPromotedAcademicDetails($appId);
		
			$htm  ="<form action='".site_url().'regional/studentAcademicDetailsUpdate/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			
			 $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$academicDetails[0]['id']."'>";
			   $htm .="<input type = 'hidden' name = 'application_id' value = '".$academicDetails[0]['application_id']."'>";
			  $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-6'>";
			  
			  $htm .="<label for='inputEmail4'>Promoted %Age(Percentage)</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'stipend_from_id' name = 'promoted_percentage' value = '".$academicDetails[0]['promoted_percentage']."' placeholder='&age'>";
			  
			  $htm .="</div>";
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Attendance %age(Attendance Percentage)</label>";
			  $htm .="<input type='text' class='form-control' name = 'attendance_percentage' id='adv_stipend_to'  value = '".$academicDetails[0]['attendance_percentage']."' placeholder='Percentage'>";
			  $htm .="</div>";
			  $htm .="</div>";				
				
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Scholarship Status(Status)</label>";
			 
			  
			  $htm .="<select class='form-control' id ='scholarship_status' name='scholarship_status'>";
			  $htm .="<option value=''></option>";
			 
			  $schlorshipStatus = array('1'=>'Continued','2'=>'Detained','3'=>'Renewed','4'=>'Self Financed');
			  //echo "<pre>";
			  //print_r($schlorshipStatus);die;
              foreach ($schlorshipStatus as $scStatus=>$status) {
				  
				  
              $htm .='<option value="'.$scStatus.'"'.($scStatus == $academicDetails[0]['status'] ? ' selected="selected"' : '').'>'.$status.'</option>';
              }
         
		      $htm .="</select>";
		     
			  $htm .="</div>";
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of the Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'officer_name' id='officer_name'  value = '".$academicDetails[0]['officer_name']."' placeholder='Name'>";
			  $htm .="</div>";
		  
		   
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name ='off_sign' id='inputPassword4' required>";
			  $htm .="</div>"; 
			  $htm .="<input type = 'hidden' name = 'app_id' value = '".$expenditureDetails[0]['id']."' name = 'app_id'>";
			  /* $htm .="<a href='#' class='signatureadvstipneddiv_img'  
			  
			  data-toggle='modal' data-target='#advstipned_signature'>Re-Upload Signature</a>"; */
			  
			  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_signature/'.$academicDetails[0]['off_sign']."' target='_blank' title='Click to View Signature'><img id='signatureImageImg' name='off_sign' style='border:1px solid #cecece;padding:2px;width:50px;max-height:40px;' class='pull-right' src='".site_url().'assets/site/main/expenditure_signature/'.$academicDetails[0]['off_sign']."'/></a></br>";
			  
			  
			  
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
              //$htm .="</form>";
              echo $htm;
              exit;
				
				
				
			//}
			
			
		}
	
		  	function romanic_number($integer, $upcase = true) 
{ 
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
    $return = ''; 
    while($integer > 0) 
    { 
        foreach($table as $rom=>$arb) 
        { 
            if($integer >= $arb) 
            { 
                $integer -= $arb; 
                $return .= $rom; 
                break; 
            } 
        } 
    } 

    return $return; 
} 
	
//Edit Student Academic Details

		function studentPromoted(){
		
		$applicationId = $this->uri->segment(3);
		
		$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
	    $getPromotedDetails = $this->common_model->getAcademicStatusDataforReport($applicationId);
		
		//echo "<pre>";
		//print_r($getPromotedDetails);die;
		                 echo '<div>';
						 echo '<div class="panel-heading">Summary of Promoted <label class="fy"></label> <span class="spn_note"></span></div>';
						 echo '<div class="panel-body">';						 	
						 	echo '<table class="table table-striped table-bordered">';
						 		echo '<thead>';
							 		echo '<th> Academic Year</th>';
							 		echo '<th> Annual/Semester</th>';
							 		//echo '<th> Mode</th>';
							 		echo '<th> Duration of Annual/Semester</th>';
							 		echo '<th> Academic Status</th>';
									echo '<th> Attendance %age</th>';
									echo '<th> Scholarship Status %age</th>';
									echo '<th> Action</th>';
						 		    echo '</thead>';
						 		    echo '<tbody>';
						 								 			
						 				if(isset($getPromotedDetails) && !empty($getPromotedDetails))
						 				{
											foreach($getPromotedDetails as $prom)
											{
												echo '<tr>';
												echo '<td>'.$prom['aca_year'].'</td>';
												
												if($prom['is_sem'] == 1)
												{
                                                   $sem_year = $this->romanic_number($prom['sem_no'],TRUE).' Semester';	
												}
												elseif($prom['is_sem'] == 2)
												{
													$sem_year = $this->romanic_number($prom['annual_no'],TRUE).' Year';	
												}
												
												echo '<td>'.$sem_year.'</td>';
												  echo'<td>'.$prom['date_from'].' to '.$prom['date_to'].'</td>';
													switch($prom['status'])
											{
												case "1":
													$re =  "Promoted (".$prom['promoted_percentage']."%)";
												break;
												case "2":
													$detainedReson = $this->config->item('detainedReason');
													
													$re = "Detained (due to ".$detainedReson[$prom['detained_reason']].")";
												break;
												case "3":
													$re = "Backlogs (No of Backlogs: ".$prom['backlog_no']."%)";
												break;
												case "4":
													$re = "Finally Passed (with ".$prom['finally_passed_percent']."%)";
												break;
											}
												echo '<td>'.$re.'</td>';
												
												if($prom['attendance_percentage'] != -1 && $prom['attendance_percentage'] != "")
												{
													$atper = $prom['attendance_percentage'].'%';
												}
												else 
												{
													$atper = "NA";
												}
							
											    echo '<td>'.$atper.'</td>';	
												
														if($prom['scholarship_status'] != -1 && $prom['scholarship_status'] != "")
							{
								switch($prom['scholarship_status'])
								{
									case "1":
										$status = "Continued";
									break;
									case "2":
										$status = "Detained";
									break;
									case "3":
										$status = "Renewed";
									break;
									case "4":
										$status =  "Self Financed";
									break;
									case "5":
										$status = "Terminated<br/>(".$prom['remarks_terminated'].")<br/><a href='".site_url()."assets/site/main/terminatedDoc/".$prom['term_file']."'>Download Termination Letter</a>";
										
									break;									
								}
							}
							else 
							{
								echo "NA";
							}
												
								 echo '<td>'.$status.'</td>';					
												//echo '<td>'.getMode($stp['adv_stipend_mode']).'</td>';
											  
												//echo '<td>'.date('d M Y h:i:s A',$prom['created']).'</td>';
												echo '<td><button type="button" class="btn" id = "expe" onclick ="editPromoted('.$prom['id'].')">Edit</button></td>';
												echo '</tr>';
												
											}
										}
										else
										{
											echo '<tr><td colspan="6">Academic Status Not Updated Yet!</td></tr>';
										}
						
						 		echo '</tbody>';
						 	    echo '</table>';
		  echo '</div>';
 
		
		
	}	
		
	public function studentAcademicDetailsUpdate()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";
			//print_r($_POST);die;
			//print_r($_FILES);die;
			
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['app_id'];
			$app_id =$cleanData['application_id'];
			//echo "<pre>";
			//print_r($cleanData);
			if(!empty($_FILES))
					{	
						
						$imgname5 = "";
					
					if(!empty($_FILES['off_sign']['name']))
					{
						$file_name=$_FILES["off_sign"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['off_sign']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect('regional/addcurrentAcademicDetails/'.$app_id);
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname5 = time().'off_sign'.$name;
						$isValid_Extention_Size = explode('.',$imgname5);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect('regional/addcurrentAcademicDetails/'.$app_id);
							return false;
							
						}
						elseif($_FILES['off_sign']["size"] <= 0 || $_FILES['off_sign']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect('regional/addcurrentAcademicDetails/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["off_sign"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['off_sign']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname5; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['off_sign'] = $imgname5;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect('regional/addcurrentAcademicDetails/'.$app_id);
							return false;	
			
							
							
			
							
						}
						
					}
						
					}
				 			
				 $appid = $cleanData['appId'];
				 $data = array(
				 'promoted_percentage'=>$cleanData['promoted_percentage'],
				 'attendance_percentage'=>$cleanData['attendance_percentage'],
				 'scholarship_status'=>$cleanData['scholarship_status'],
				 'officer_name'=>$cleanData['officer_name'],
				 'off_sign'=>$cleanData['off_sign'],
				 'created'=>time()
				 );
			  	 //echo "<pre>";
				// print_r($appid);
				// print_r($data);die;
				 
			 	 $result = $this->Regional_model->updatePromtedDetails($data,$appid);
				 //var_dump($result);die;
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details Saved!');
					redirect(site_url().'regional/addcurrentAcademicDetails/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/addcurrentAcademicDetails/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/expenditureStatement');
		}
	}	
		
	public function studentStipenedExpenditureAdvanceSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			$app_id =$cleanData['application_id'];
			//echo "<pre>";
			//print_r($cleanData);die;
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['stipend_off_sign']['name']))
					{
						$file_name=$_FILES["stipend_off_sign"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['stipend_off_sign']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'stipend_off_sign'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['stipend_off_sign']["size"] <= 0 || $_FILES['stipend_off_sign']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["stipend_off_sign"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['stipend_off_sign']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['stipend_off_sign'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
				 			
				 //$appid = $cleanData['app_id'];
				 
				
				 $data = array(
				 'stipend_from'=>$cleanData['stipend_from'],
				 'stipend_to'=>$cleanData['stipend_to'],
				 'amount'=>$cleanData['amount'],
				 'created'=>time()
				 );
				//echo $appid;
				 //echo "<pre>";print_r($data);die;
				 
			 	 $result = $this->Regional_model->updateStipenedExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
	
	
	public function studentHRAExpenditureAdvanceSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			$app_id =$cleanData['application_id'];
			//echo "<pre>";
			//print_r('welcome');die;
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['hra_signature']['name']))
					{
						$file_name=$_FILES["hra_signature"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['hra_signature']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'hra_signature'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['hra_signature']["size"] <= 0 || $_FILES['hra_signature']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["hra_signature"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['hra_signature']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['hra_signature'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
				 			
				 $data = array(
				 'hra_from_date'=>$cleanData['hra_from_date'],
				 'hra_to_date'=>$cleanData['hra_to_date'],
				 'hra_amount'=>$cleanData['hra_amount'],
				 'created'=>time()
				 );
				 //echo $app_id;
				 //echo $appid;
				 //print_r($data);die;
			 	 $result = $this->Regional_model->updateHRAExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
	
	public function studentACAExpenditureAdvanceSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			$app_id =$cleanData['application_id'];
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['aca_signature']['name']))
					{
						$file_name=$_FILES["aca_signature"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['aca_signature']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'aca_signature'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['aca_signature']["size"] <= 0 || $_FILES['aca_signature']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["aca_signature"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['aca_signature']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['aca_signature'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
				
				 $data = array(
				 'aca_release_date'=>$cleanData['aca_release_date'],
				  'aca_amount'=>$cleanData['aca_amount'],
				 'created'=>time()
				 );
				 //echo $appid;
				 //echo "<pre>";print_r($data);die;
			 	 $result = $this->Regional_model->updateACAExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
	
	public function studentStudyTourExpenditureAdvanceSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['app_id'];
			$app_id =$cleanData['application_id'];
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['st_signature']['name']))
					{
						$file_name=$_FILES["st_signature"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['st_signature']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'st_signature'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['st_signature']["size"] <= 0 || $_FILES['st_signature']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["st_signature"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['st_signature']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['st_signature'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
				 			
				 $appid = $cleanData['app_id'];
				 $data = array(
				 'st_from_date'=>$cleanData['st_from_date'],
				 'st_to_date'=>$cleanData['st_to_date'],
				 'st_amount'=>$cleanData['st_amount'],
				 'doc'=>$imgname1,
				 'st_signature'=>$imgname2,
				 'st_official_name'=>$cleanData['st_official_name'],
				 'created'=>time()
				 );
				 
				 
			 	 $result = $this->Regional_model->updateStudyTourExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
	
		public function studentMedicalExpenditureAdvanceSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['app_id'];
			$app_id =$cleanData['application_id'];
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['mr_signature']['name']))
					{
						$file_name=$_FILES["mr_signature"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['mr_signature']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'mr_signature'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['mr_signature']["size"] <= 0 || $_FILES['mr_signature']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["mr_signature"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['mr_signature']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['mr_signature'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
				 			
				 $appid = $cleanData['app_id'];
				 $data = array(
				 'mr_release_date'=>$cleanData['mr_release_date'],
				 'mr_amount'=>$cleanData['mr_amount'],
				 'doc'=>$imgname1,
				 'mr_signature'=>$imgname2,
				 'mr_official_name'=>$cleanData['mr_official_name'],
				 'created'=>time()
				 );
				 
				 
			 	 $result = $this->Regional_model->updateMedicalExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
	
	
	
	
	public function studentTutionExpenditureSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			$app_id =$cleanData['application_id'];
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['mr_signature']['name']))
					{
						$file_name=$_FILES["mr_signature"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['mr_signature']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'mr_signature'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['mr_signature']["size"] <= 0 || $_FILES['mr_signature']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["mr_signature"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['mr_signature']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['mr_signature'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
					
				 			
				 
				 $data = array(
				 'tf_release_date'=>$cleanData['tf_release_date'],
				 'tf_amount'=>$cleanData['tf_amount'],
				 'created'=>time()
				 );
				 
				 
			 	 $result = $this->Regional_model->updateTutionExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
	
	
	public function studentThesisExpenditureAdvanceSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['app_id'];
			$app_id =$cleanData['application_id'];
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['tc_signature']['name']))
					{
						$file_name=$_FILES["tc_signature"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['tc_signature']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'tc_signature'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['tc_signature']["size"] <= 0 || $_FILES['tc_signature']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["tc_signature"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['tc_signature']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['tc_signature'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
				 			
				 $appid = $cleanData['app_id'];
				 $data = array(
				 'tc_release_date'=>$cleanData['tc_release_date'],
				 'tc_amount'=>$cleanData['tc_amount'],
				 'doc'=>$imgname1,
				 'tc_signature'=>$imgname2,
				 'tc_official_name'=>$cleanData['tc_official_name'],
				 'created'=>time()
				 );
				 
				 
			 	 $result = $this->Regional_model->updateThesisExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
	
	public function countsregional() {
        try {
			
				
                $user_data = $this->session->userdata('user_data');
				//echo "<pre>";
				//print_r($user_data);die;
				$regionid = $user_data['state'];
                $this->load->view('regional/header_regional');
                $this->load->view('regional/countregional', $data);
                $this->load->view('regional/footer');
            
        } catch (Exception $e) {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
				redirect(site_url() . 'regional/dashboard');
        }
    }
	
	
	 public function getCountRegional() {
        try {
			
			$fy = "2018-2019";
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$vars = $this->input->post();
			//echo "<pre>";
			//print_r($vars);die;
            $list = $this->Regional_model->get_iccr_datatables_query($regionid,$vars);
            //print_r($list);die;
			
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $customers) {
                $no++;
                $row = array();
                $row[] = $no;
               $row[] = $customers['totalCount'];
				$row[] = $customers['totalMale'];
				$row[] = $customers['totalFemale'];
				$row[] = $customers['totalUG'];
				$row[] = $customers['totalPG'];
				$row[] = $customers['totalMphil'];
				$row[] = $customers['totalPHD'];
				$row[] = $customers['totalAccepted'];
				$row[] = $customers['totalRejected'];
				//$row[] = $customers['totalAdmitted'];
				$row[]  = '<a href="'.site_url().'regional/admittStudents">'.$customers['totalAdmitted'].'</a>';
               
               $totalExp = 0;
                
                $aca = $this->Regional_model->getACATotalExp($regionid,$fy,$vars);
                $getAdvanceStipnedTotalExp = $this->Regional_model->getAdvanceStipnedTotalExp($regionid,$fy,$vars);
                $getCamps = $this->Regional_model->getCamps($regionid,$fy,$vars);
                $getDeduction = $this->Regional_model->getDeduction($regionid,$fy,$vars);
                $getEmergencyFund = $this->Regional_model->getEmergencyFund($regionid,$fy,$vars);
                $getEngBridgeCourse = $this->Regional_model->getEngBridgeCourse($regionid,$fy,$vars);
                $getHostel = $this->Regional_model->getHostel($regionid,$fy,$vars);
                $getHRA = $this->Regional_model->getHRA($regionid,$fy,$vars);
                $getisaMeeting = $this->Regional_model->getisaMeeting($regionid,$fy,$vars);
                $getmedicalReEmbust = $this->Regional_model->getmedicalReEmbust($regionid,$fy,$vars);
                $getMicsellanious = $this->Regional_model->getMicsellanious($regionid,$fy,$vars);
                $getMisUniversity = $this->Regional_model->getMisUniversity($regionid,$fy,$vars);
                $getNationalDay = $this->Regional_model->getNationalDay($regionid,$fy,$vars);
                $getOrientProg = $this->Regional_model->getOrientProg($regionid,$fy,$vars);
                $getOtherFee = $this->Regional_model->getOtherFee($regionid,$fy,$vars);
                $getStipned = $this->Regional_model->getStipned($regionid,$fy,$vars);
                $getStudentDay = $this->Regional_model->getStudentDay($regionid,$fy,$vars);
                $getStudyTour = $this->Regional_model->getStudyTour($regionid,$fy,$vars);
                $getSump = $this->Regional_model->getSump($regionid,$fy,$vars);
                $getthesis = $this->Regional_model->getthesis($regionid,$fy,$vars);
                $getTravel = $this->Regional_model->getTravel($regionid,$fy,$vars);
                $getTutFee = $this->Regional_model->getTutFee($regionid,$fy,$vars);
                
               
           
                
                if(count($aca)>0){$totalExp = $totalExp + $aca[0]['totalamount'];}
                
				if(count($getAdvanceStipnedTotalExp)>0){$totalExp = $totalExp + $getAdvanceStipnedTotalExp[0]['totalamount'];}
				if(count($getCamps)>0){$totalExp = $totalExp + $getCamps[0]['totalamount'];}
				if(count($getDeduction)>0){$totalExp = $totalExp + $getDeduction[0]['totalamount'];}
				if(count($getEmergencyFund)>0){$totalExp = $totalExp + $getEmergencyFund[0]['totalamount'];}
				if(count($getEngBridgeCourse)>0){$totalExp = $totalExp + $getEngBridgeCourse[0]['totalamount'];}
				if(count($getHostel)>0){$totalExp = $totalExp + $getHostel[0]['totalamount'];}
				if(count($getHRA)>0){$totalExp = $totalExp + $getHRA[0]['totalamount'];}
				if(count($getisaMeeting)>0){$totalExp = $totalExp + $getisaMeeting[0]['totalamount'];}
				if(count($getmedicalReEmbust)>0){$totalExp = $totalExp + $getmedicalReEmbust[0]['totalamount'];}
				if(count($getMicsellanious)>0){$totalExp = $totalExp + $getMicsellanious[0]['totalamount'];}
				if(count($getMisUniversity)>0){$totalExp = $totalExp + $getMisUniversity[0]['totalamount'];}
				if(count($getNationalDay)>0){$totalExp = $totalExp + $getNationalDay[0]['totalamount'];}
				if(count($getOrientProg)>0){$totalExp = $totalExp + $getOrientProg[0]['totalamount'];}
				if(count($getOtherFee)>0){$totalExp = $totalExp + $getOtherFee[0]['totalamount'];}
				if(count($getStipned)>0){$totalExp = $totalExp + $getStipned[0]['totalamount'];}
				if(count($getStudentDay)>0){$totalExp = $totalExp + $getStudentDay[0]['totalamount'];}
				if(count($getStudyTour)>0){$totalExp = $totalExp + $getStudyTour[0]['totalamount'];}
				if(count($getSump)>0){$totalExp = $totalExp + $getSump[0]['totalamount'];}
				if(count($getthesis)>0){$totalExp = $totalExp + $getthesis[0]['totalamount'];}
				if(count($getTravel)>0){$totalExp = $totalExp + $getTravel[0]['totalamount'];}
				if(count($getTutFee)>0){$totalExp = $totalExp + $getTutFee[0]['totalamount'];}
				
                $row[] = $totalExp;
                $row[] = $sts[0]['status'];
                $data[] = $row;
            }
			
            $output = array(
                //"draw" => $_POST['draw'],
                //"recordsTotal" => $this->common_model->count_all(),
                //"recordsFiltered" => $this->common_model->count_filtered($this->ids),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	
	
	public function admittStudents() {
		 //echo "sdsadas";die;
        try {
            $user_data = $this->session->userdata('user_data');
            $regionid = $user_data['state'];
		
				$current = date('Y-m-d');
                $current1 = date('Y-m-d', strtotime('-1 years'));
                $data['fy'] = $this->getFinancialYears($current, 1);
                $data['ofy'] = $this->getFinancialYears($current1, 5);
                $data['totalAdmitt'] = $this->common_model->getAllROAdmittedStudents($regionid);
				//echo "<pre>";
				//print_r($data['totalAdmitt']);die;
                $data['schemes'] = $this->ids;
                $this->load->view('regional/header_regional');
                $this->load->view('regional/admittStudents', $data);
                $this->load->view('regional/footer');
           
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'headquarter/dashboard');
        }
    }
	function scholarStatusView()
	{
		//echo "sadasdsasad";die;
		try{
			$applicationId = $this->uri->segment(3);
			//echo $applicationId;die;
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
		$data['regionId'] =  $user_data['state'];	
		$data['registerData'] = $this->common_model->getUserData($data['applicaitonStepOne'][0]["uid"]);
		$data['userImage'] = $image;
		$data['missions'] = $this->common_model->getAllMissions();
		$data['univercities'] = $this->common_model->getUnivercities();	
		$data['applicaitonStepTwo'] = $this->common_model->getApplicationStepTwoByAppno($applicationId);
		$data['applicaitonStepThree'] = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
		$data['applicaitonDocuments'] = $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
		$data['mappingData'] = $this->common_model->getMappingData($applicationId);
		$data['universityData'] = $this->common_model->getconfirmationData($applicationId);
		$data['travelplan'] = $this->common_model->getAllTravelPlan($applicationId);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/scholarArrivedstatusView',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			
		}
	}
	
	public function studentMiscellaneousExpenditureAdvanceSave()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			$appid = $cleanData['appId'];
			$app_id =$cleanData['application_id'];
			if(!empty($_FILES))
					{	
						$imgname1 = "";
						$imgname2 = "";
					
						
						if(!empty($_FILES['doc']['name']))
					{
						$file_name=$_FILES["doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						$name = str_replace(" ","_",$file_name);
						$imgname1 = time().'doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname1);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File name is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
							
						}
						elseif($_FILES['doc']["size"] <= 0 || $_FILES['doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
							return false;
						}
						$file_tmp = $_FILES["doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgname1; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['doc'] = $imgname1;
						}
						else
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'File Extension is not valid.!');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['msc_signature']['name']))
					{
						$file_name=$_FILES["msc_signature"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['mr_signature']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'msc_signature'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						elseif($_FILES['msc_signature']["size"] <= 0 || $_FILES['msc_signature']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
						}
						$file_tmp = $_FILES["msc_signature"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['msc_signature']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/expenditure_signature/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['msc_signature'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);	
							return false;
							
						}
						
					}
						
					}
				 			
				
				 $data = array(
				 'msc_release_date'=>$cleanData['msc_release_date'],
				 'msc_amount'=>$cleanData['msc_amount'],
				 'created'=>time()
				 );
				 //echo $appid;
				// echo "<pre>";print_r($data);die;
			 	 $result = $this->Regional_model->updateMiscellaneousExpeDocuments($data,$appid);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details update successfully!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);					
				 }
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/regionalExpenditureUser/'.$app_id);
		}
	}
	
	
	//RP Upload
	
	
		public function rpUpload()
		{
			$response = array('status'=>TRUE,'data'=>array());	
			try
			{			
				$user_data = $this->session->userdata('user_data');	
		$regionid = $user_data['state'];
		$applicationId = $_POST['appid'];
		$acdemicyear   = $_POST['acdemic_year'];
		//echo "<pre>";
		//print_r($_POST);die;
  if($_FILES["files"]["name"] != '')
  {
   $output = '';
   $config["upload_path"] = './assets/site/main/police_doc/';
   $config["allowed_types"] = 'gif|jpg|png|pdf';
   $config['file_name']     = $applicationId.'_'.time().'_police_doc_'.$_FILES["files"]["name"][0];
   
   $this->load->library('upload', $config);
   $this->upload->initialize($config);
   for($count = 0;$count<count($_FILES["files"]["name"]);$count++)
   {
	//$imgname = $applicationId.'_'.time().'_bonafide_doc_'.$data["file_name"];
    $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
    $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
    $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
    $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
    $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
    if($this->upload->do_upload('file'))
    {
     $data = $this->upload->data();
	 $filedata = array(
	 'police_doc'=>$data['file_name'],
	 'application_no'=>$applicationId,
	 'created'=>date('Y-m-d H:i:s'),
	 'acdemic_year'=>$acdemicyear,
	 'region_id'=>$regionid
	 );
				//echo "<pre>";
				//print_r($filedata);die;
				
				//$status = array("STATUS"=>"false");
				 $sts = $this->common_model->insertIssueRpDocument($filedata);
				//var_dump($sts);die;
				
				
			
    }
   }
  }
				
				if($sta)
				{
					$response['status'] = TRUE;
					
				}
			}
			catch(Exception $e)
			{
				echo json_encode($response);
			}
			echo json_encode($response);	
		}
	
		public function upload()
		{
			$response = array('status'=>TRUE,'data'=>array());	
			try
			{			
				$user_data = $this->session->userdata('user_data');	
		$regionid = $user_data['state'];
		$applicationId = $_POST['appid'];
		$acdemicyear   = $_POST['acdemic_year'];
		//echo "<pre>";
		//print_r($_POST);die;
  if($_FILES["files"]["name"] != '')
  {
   $output = '';
   $config["upload_path"] = './assets/site/main/bonafide_doc/';
   $config["allowed_types"] = 'gif|jpg|png|pdf';
   $config['file_name']     = $applicationId.'_'.time().'_bonafide_doc_'.$_FILES["files"]["name"][0];
   
   $this->load->library('upload', $config);
   $this->upload->initialize($config);
   for($count = 0;$count<count($_FILES["files"]["name"]);$count++)
   {
	//$imgname = $applicationId.'_'.time().'_bonafide_doc_'.$data["file_name"];
    $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
    $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
    $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
    $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
    $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
    if($this->upload->do_upload('file'))
    {
     $data = $this->upload->data();
	 $filedata = array(
	 'bonafide_doc'=>$data['file_name'],
	 'application_no'=>$applicationId,
	 'created'=>time(),
	 'acdemic_year'=>$acdemicyear,
	 'region_id'=>$regionid
	 );
				//echo "<pre>";
				//print_r($filedata);die;
				
				//$status = array("STATUS"=>"false");
				 $sts = $this->common_model->insertIssueBonafideDocument($filedata);
				//var_dump($sts);die;
				
				
			
    }
   }
  }
				
				if($sta)
				{
					$response['status'] = TRUE;
					
				}
			}
			catch(Exception $e)
			{
				echo json_encode($response);
			}
			echo json_encode($response);	
		}
		
		
			
	public function editBonafideDetails()
		{
			try
			{
				$current = date('d-m-Y',strtotime('-2 years'));
				$fy= $this->getFinancialYears($current,1);
		$appid = $_POST['appno'];
		
		$studentBonafideDetails = $this->Regional_model->getBonafideDetails($appid);
		
		if(!empty($studentBonafideDetails))
		{
               
			  $htm  ="<form action='".site_url().'regional/studentBonafideSave/'."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>"; 
			  $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' id = 'appId' name = 'appId' value = '".$studentBonafideDetails[0]['application_no']."'>";
			   $htm .="<input type = 'hidden' id = 'app_id' name = 'appId' value = '".$studentBonafideDetails[0]['id']."'>";
			 
            
			
			
			  
			  $htm .="<div class='form-group row'>";
			  $htm .="<label for='staticEmail' class='col-sm-5 col-form-label'>Acadmic Year</label>";
			  $htm .="<div class='col-sm-6'>";
			  $htm .="<select class='form-control' id ='acdemic_year' name='acdemic_year'>";
			  $htm .="<option value=''></option>";
			 
              foreach ($fy as $year) {
              $htm .='<option value="'.$year.'"'.($year === $studentBonafideDetails[0]['acdemic_year'] ? ' selected="selected"' : '').'>'.$year.'</option>';
              }
         
		      $htm .="</select>";
		      $htm .="</div>";
			  $htm .="</div>";
		   
		     $htm .="<div class='form-group row'>";
			 
			  $htm .="<label for='staticEmail' class='col-sm-5 col-form-label'>Expenditure Document </label></br>";
			  
			  $htm .="<div class='col-sm-6'>";
			  $htm .="<input type='file' name ='bonafide_doc'  class='form-control' id='userfile' required>";
			  
			   if($studentBonafideDetails[0]['bonafide_doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/bonafide_doc/'.$studentBonafideDetails[0]['bonafide_doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  
			  
			  $htm .="</div>";	
			 
			  
			  
			  
			  $htm .="<div class='form-group col-md-5'>";					    
			  $htm .="<div class='col-sm-5'>";
			  $htm .="<input type='submit' class='form-control sbmit' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
              $htm .="</form>";
              echo $htm;
              exit;
			
			}
			}
			catch(Exception $e)
			{
				echo json_encode(array('status'=>FALSE,"message"=>"Error Try Again Later."));
			}
			

	
		
	}
	
	
	
	
	function getTravelStudents()
    {
	
			  $htm  ="<form action='".site_url().'regional/travelDetails/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			  
			  $htm .="<div class='form-group row'>";
              $htm .="<label for='staticEmail' class='col-sm-6 col-form-label'>Application No</label>";
              $htm .="<div class='col-sm-6'>";
              $htm .="<input type='text' class='form-control' name = 'application_no' id='app_no' value='' required>";
              $htm .="</div>";
              $htm .="</div>";
			
		   
		   
			  $htm .="<div class='form-group col-md-3'>";					    
			  $htm .="<div class='col-sm-3'>";
			  //$htm .="<input type='submit' class='form-control sbmit' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
              $htm .="</form>";
              echo $htm;
              exit;
				
				
				
			//}
			
			
		}
	
	public function isCheckDetails()
		{
			$response = array('status'=>FALSE,'data'=>array());	
			try
			{		
				$applicationId = $_POST['app_no'];
				$data = $this->common_model->getConfirmationofApplicationIds($applicationId);
				
				
				if($data) {
				$response['status'] = TRUE;
				}
					else 
					{	
					$response['status'] = FALSE;
					}
				}
				
			
			catch(Exception $e)
			{
				echo json_encode($response);
			}
			echo json_encode($response);	
		}
	
	
	public function isUnderTaking()
		{
			$response = array('status'=>FALSE,'data'=>array());	
			try
			{		
				$applicationId = $_POST['app_no'];
				$result= $this->common_model->getUnderTakingofStudent($applicationId);
				if($result[0]['undertaking_doc'] != NULL) {
				   $response['status'] = TRUE;
				}
					else 
					{	
					$response['status'] = FALSE;
					}
				}
				
			catch(Exception $e)
			{
				echo json_encode($response);
			}
			echo json_encode($response);	
		}
		
		
		public function isAlreadytTravelPlan()
		{
			$response = array('status'=>FALSE,'data'=>array());	
			try
			{			
				$applicationId = $_POST['app_no'];
			
				$isAlreadytTravelPlan = $this->common_model->getCheckTravelPlan($applicationId);
				//var_dump($isAlreadytTravelPlan);die;
				if($isAlreadytTravelPlan){
					
					if($isAlreadytTravelPlan == TRUE) {
					$response['status'] = true;
					} else {
					$response['status'] = false;
					
				}
					
				}
				
				
			}
			catch(Exception $e)
			{
				echo json_encode($response);
			}
			echo json_encode($response);	
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
			redirect(site_url().'regional/dashboard');
		}
		
	}
		public function createTravelplan()
	{
		
		try
		{
			
			
			$appid = $this->uri->segment(3);
			//echo $appid;die;
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$data['regionName'] = $this->common_model->getRegionById($regionid);
			$data['appno'] = $this->uri->segment(3);
			$data['travel'] = $this->common_model->getMappingData($appid);	
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($appid);
			//echo "<pre>";print_r($data['applicaitonStepOne'][0]['course_type']);die;
			if($data['applicaitonStepOne'][0]['course_type'] == '1'){
				$result = $this->common_model->isAyurvedaApplication($appid);
			}else{
				$result = $this->common_model->isApplication($appid);
			}
			
			//var_dump($result);die;
			if($result == false)
			{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/scholararrival');	
			return false;
			}else{
			$this->load->view('regional/header_regional');		
			$this->load->view('regional/createtravelplan',$data);
			$this->load->view('regional/footer');	
			}
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/scholararrival');				
		}
	}
		
		public function travelpaln()
	{
		
		try
		{
			$appid = $this->uri->segment(3);
			//echo $appid;die;
			$user_data = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);
			if(!empty($_FILES))
					{	
						$imgnametr = "";
						$imgnameut = "";
						
						if(!empty($_FILES['travel_plan_doc']['name']))
					{
						$file_name=$_FILES["travel_plan_doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['travel_plan_doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
					        $this->session->set_flashdata('error', 'A File Extension is not valid.');
							redirect('regional/createTravelplan/'.$appid);
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgnametr = time().'_travel_plan_doc_'.$name;
						$isValid_Extention_Size = explode('.',$imgnametr);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							
							$this->session->set_flashdata('error','File name is not valid.');
							redirect('regional/createTravelplan/'.$appid);
							return false;
							
						}
						elseif($_FILES['travel_plan_doc']["size"] <= 0 || $_FILES['travel_plan_doc']["size"] >5000000)
						{
							
							
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect('regional/createTravelplan');
							return false;
						}
						$file_tmp = $_FILES["travel_plan_doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['travel_plan_doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
					
							$target_file = 'assets/site/main/expenditure_doc/'.$imgnametr; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['travel_plan_doc'] = $imgnametr;
						}
						else
						{
							
							
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect('regional/createTravelplan/'.$appid);
							return false;
							
						}
						
					}
					
					if(!empty($_FILES['undertaking']['name']))
					{
						$file_name=$_FILES["undertaking"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['undertaking']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect('regional/createTravelplan/'.$appid);
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgnameut = time().'_undertaking_'.$name;
						$isValid_Extention_Size = explode('.',$imgnameut);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							
							$this->session->set_flashdata('error','File name is not valid.');
							redirect('regional/createTravelplan/'.$appid);
							return false;
							
						}
						elseif($_FILES['undertaking']["size"] <= 0 || $_FILES['undertaking']["size"] >5000000)
						{
							
							
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect('regional/createTravelplan/'.$appid);
							return false;
						}
						$file_tmp = $_FILES["undertaking"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['undertaking']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/undertakings/'.$imgnameut; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['undertaking'] = $imgnameut;
						}
						else
						{
							
							
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect('regional/createTravelplan/'.$appid);
							return false;
							
						}
						
					}
						
					}
					
				$alreadyUnderTaking = $this->common_model->getUnderTaking($appid);	 
				 $datatr = array(			  			
			  			'travel_plan_doc' =>$imgnametr,
			  			'departure_date' =>$this->input->post('departure_date'),
			  			'travel_arrival_date' =>$this->input->post('travel_arrival_date'),
			  			'flight_no' =>$this->input->post('flight_no'),
			  			'final_city_arrival' =>$this->input->post('final_city_arrival'),
			  			'city_other' =>$this->input->post('city_other'),
			  			'regional_office_contacted' =>$this->input->post('regional_office_contacted'),
			  			'cost_of_ticket' =>$this->input->post('cost_of_ticket'),
			  			'created' =>time(),
			  			'application_id'=>$appid,
			  			'status'=>13,
						'region_status'=>17
			  		 );
					 
				
				if($alreadyUnderTaking[0]['undertaking_doc'] == null)
			{
						$data = array(
			  			'scholar_acceptance'=>$this->input->post('scholar_is_accept'),
			  			'undertaking_doc' =>$imgnameut,
			  			'status'=>11,
						'undertaking_status_by_region'=>$regionid
			  		 );
			 	 $result = $this->common_model->uploadUndertakingByRo($data,$appid);
				 //var_dump($result);die;
			 	 if($result)
				 {		

					$sts = $this->common_model->insertTravelPlan($datatr);
					if($sts > 0)
			  	  {
			  	  	$dataar = array(			
					'status'=>13
					);
					$sts = $this->common_model->scholarArrived($appid,$dataar);	
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Travel Plan Uploaded!');
					redirect(site_url().'regional/scholararrival');				  	  					  	
				  }
					
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details Saved!');
					redirect(site_url().'regional/scholararrival');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'regional/scholararrival');					
				 }
				 
				 
			}
			
			else
			{
				
					$sts = $this->common_model->insertTravelPlan($datatr);
					if($sts > 0)
			  	  {
			  	  	$dataar = array(			
					'status'=>13
					);
					$sts = $this->common_model->scholarArrived($appid,$dataar);	
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Travel Plan Uploaded!');
					redirect(site_url().'regional/scholararrival');				  	  					  	
				  }
					
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Details Saved!');
					redirect(site_url().'regional/scholararrival');		 						
				
			}
			  
			  
			}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'regional/expenditureStatement');
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
			$pdf->MultiCell(180,5,'Mission/Region/Post:'.$schemename[0][''],'','L');
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
	function studentBonafideSave()
	{
		try
		{
			
			$extension=array("jpeg","jpg","png","JPEG","JPG","PNG","pdf","PDF");
			$postData = $this->input->post(NULL,TRUE);
		    $cleanData = $this->security->xss_clean($postData);	
			//echo "<pre>";
			//print_r($cleanData);die;
			if(!empty($_FILES))
					{
					$imgname2 = "";
					
						if(!empty($_FILES['bonafide_doc']['name']))
					{
						$file_name=$_FILES["bonafide_doc"]["name"];
						$finfo = finfo_open(FILEINFO_MIME_TYPE);
						$mime = finfo_file($finfo, $_FILES['bonafide_doc']['tmp_name']);
						
						$mimearray = array('image/jpeg','image/png','application/pdf');
						if(!in_array($mime,$mimearray))
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid.');
							redirect(site_url().'regional/issueDocuments');	
							return false;
						}
						$name = str_replace(" ","_",$file_name);
						$imgname2 = time().'bonafide_doc'.$name;
						$isValid_Extention_Size = explode('.',$imgname2);
						if(count($isValid_Extention_Size) > 2)
						{	
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File name is not valid.');
							redirect(site_url().'regional/issueDocuments');	
							return false;
							
						}
						elseif($_FILES['bonafide_doc']["size"] <= 0 || $_FILES['bonafide_doc']["size"] >5000000)
						{
							
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File size should be greater than 0 Bytes and less than 5 MB!.');
							redirect(site_url().'regional/issueDocuments');	
							return false;
						}
						$file_tmp = $_FILES["bonafide_doc"]["tmp_name"];
						$ext = pathinfo($file_name,PATHINFO_EXTENSION);
						if($mime=='application/pdf')
						{
							$imageinfo = array('pdf');
							}else{
							$imageinfo = getimagesize($_FILES['bonafide_doc']['tmp_name']);
						}
						
						
						if(in_array($ext,$extension))
						{	
							$target_file = 'assets/site/main/bonafide_doc/'.$imgname2; 
							move_uploaded_file($file_tmp, $target_file);
							$cleanData['bonafide_doc'] = $imgname2;
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error','File Extension is not valid!.');
							redirect(site_url().'regional/issueDocuments');	
							return false;
							
						}
						
					}
					
					}
			  
			   $data= array(			
				'acdemic_year' =>$cleanData['acdemic_year'],
				'bonafide_doc'=>$imgname2,
				'created'=>time()								
			);		
			
			//$data['xss_data'] = $this->security->xss_clean($data['non_xss']);
			$status = $this->common_model->bonafideUpdateInfo($data,$cleanData['appId']);
			if($status)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Bonafide Details updated Successfully!');
				redirect(site_url().'regional/issueDocuments');	
			}
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur while updating Bonafide Details!');
				redirect(site_url().'regional/issueDocuments');				
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Updating Application!');
			redirect(site_url().'regional/visaendrosment');				
		}
	}
	
	
			function getNewApplicaitonsDemo()
    {
		
    	$user_data = $this->session->userdata('user_data');
		$regionid = $user_data['state'];		
		$data['regionName'] = $this->common_model->getRegionById($regionid);
		$data['region'] = $regionid;	 	
		$vars = $this->input->post();
		$counter = $_POST['start'];
		$result = $this->Regional_model->getRegionalApplicationsDemo($regionid,$vars);
		
		$totalResult = $this->Regional_model->getRegionalTotalNewApplicationDemo($regionid,$vars);
		//echo "<pre>";
		//print_r($totalResult);die;
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
				//print_r($applicationDetails);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				
				        $gender = "";
				        $output= array();	
				        $output[] = $counter;	
						
						//$finish = date("Y-m", $r['created']);
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
						//}
						
					    $output[]= $applicationDetails[0]['fullname'].$new;
							
						//$output[] = $applicationDetails[0]['fullname'];
                       
						$output[] = $country[0]['country_name'];
						$sch = $this->common_model->getSchemeById($r['scholarship_id']);
						$output[] = $sch[0]['scheme_name'];				
						if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
							$output[] =  $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
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
						$universityDetails = '';
						$uname1 ="";$array_uni_id = array();
						
						if($regionid == $applicationDetails[0]['university_choice_one_state']){
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);		
							$uname1 = $university[0]['name'];
							array_push($array_uni_id,1);
						}
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice']);		
							$uname1 = $university[0]['name'];
						}
						
						$uname2 ="";					
						if($regionid == $applicationDetails[0]['university_choice_two_state']){						
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);
							$uname2 = $university[0]['name'];
							array_push($array_uni_id,2);
						}						
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_two']);	
							$uname2 = $university[0]['name'];
						}
						
						
						$uname3 ="";
						
						if($regionid == $applicationDetails[0]['university_choice_three_state']){							
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
							$uname3 = $university[0]['name'];
							array_push($array_uni_id,3);
						}
						else
						{
							$university = $this->common_model->getUniversityById($applicationDetails[0]['universty_choice_three']);
							$uname3 = $university[0]['name'];
						}
						$universityDetails .= '1) '.$uname1.'<br/>';
				        $universityDetails .= '2) '.$uname2.'<br/>';
				        $universityDetails .= '3) '.$uname3.'<br/>';
				        $output[] = $universityDetails;	
						$output[] = '<a target="_blank"  href="'.site_url().'regional/applicationForm/'.$applicationDetails[0]['application_no'].'">Download</a>';
					    $output[] = '<a target="_blank" href="'.site_url().'regional/contactForm/'.$applicationDetails[0]['application_no'].'">Download</a>';
					    $output[] = '<a  href="'.site_url().'regional/universityLetter/'.$applicationDetails[0]['application_no'].'">Download</a>';
							$downld1 = '';$dwnldDetails  = '';
							if(count($array_uni_id)>0)
							{
								
								foreach($array_uni_id as $optionNo)
								{
									
									if($optionNo == 1)
									{
										if($r['uni_forwarded_letter'] == "")
										{
											$downld1 = "<a href='#'  onclick=updateId('".$r['application_no']."','".$r['universty_choice']."','".$optionNo."'); data-toggle='modal' class='form-control sbmt' data-target='#universtiyLetterdiv'>Upload</a>";
										}
										else
										{
											
											$downld1 = '<a download href="'.site_url().'assets/site/main/university_Forwarded_letter/'.$r['uni_forwarded_letter'].'">Download</a>';
											
										}
										
									$dwnldDetails .= $downld1.'<br/>';
									}
									$downld2 = '';
									if($optionNo == 2)
									{
										if($r['uni_forwarded_letter_two'] == "")
										{
											$downld2 = "<a href='#'  onclick=updateId('".$r['application_no']."','".$r['universty_choice_two']."','".$optionNo."'); data-toggle='modal' class='form-control sbmt' data-target='#universtiyLetterdiv'>Upload</a>";
											
											
										}
										else
										{
										
											$downld2 = '<a download href="'.site_url().'assets/site/main/university_Forwarded_letter/'.$r['uni_forwarded_letter_two'].'">Download</a>';
											
										}
										 $dwnldDetails .= $downld2.'<br/>';
				       
										
									}
								    $downld3 = '';
									if($optionNo == 3)
									{
										if($r['uni_forwarded_letter_three'] == "")
										{
										
											
											$downld3 = "<a href='#'  onclick=updateId('".$r['application_no']."','".$r['universty_choice_three']."','".$optionNo."'); data-toggle='modal' class='form-control sbmt' data-target='#universtiyLetterdiv'>Upload</a>";
										  
											
										}
										else
										{
											$downld3 = '<a download href="'.site_url().'assets/site/main/university_Forwarded_letter/'.$r['uni_forwarded_letter_three'].'">Download</a>';
											
										}
									}
									 $dwnldDetails .= $downld3.'<br/>';
									
								}
								
				       
				        $output[] = $dwnldDetails;
							}
							
					        //$date = date_create($r['created']);
							//$array =  (array) $date;
					        //$output[] = date("Y-m-d", strtotime($array['date']));
							$output[] = date("Y-m-d",$studentyreg);
						    //$output[] = date("Y-m-d", $r['created']);
					        $mdate = date_create($r['mission_status_date']);
							$array =  (array) $mdate;
					        $output[] = date("Y-m-d H:i:sa", strtotime($array['date']));
							
//$output[] = '';							
						if($r['status'] >= 4)
						{
							$forwartToUniversity = array();
						
							if(count($array_uni_id)>0 && count($array_uni_id) >= 1)
							{
								$stscounter = 0; $pend ="";$array_pend = array();
								foreach($array_uni_id as $ststid)
								{
									$colname = "university_status_".$ststid;
									if($r[$colname] == "-1")
									{
										$stscounter++;
										$pend .= $ststid;		
										array_push($forwartToUniversity,$ststid);
									}
								}
								$upfirst = ''; $letterDetails = '';
								if(count($forwartToUniversity) > 0)
								{
									
									
									foreach($forwartToUniversity as $optNo)
									{
										
										if($optNo == 1)
										{
											if($regionid == $r['university_choice_one_state']){
												if($r['uni_forwarded_letter'] == "")
												{
												
											$upfirst ='<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>'; 
											
												}
												else
												{
												
											$upfirst = '<a class="form-control sbmt" style="height:32px;width:140px;" href="'.site_url().'regional/forwardtouniversity/'.$r['application_no'].'/'.$optNo.'">Forward To University</a>';
										
												}
												
											}
											$letterDetails .= $upfirst;
				       
										}
										$upsecond = '';
										if($optNo == 2)
										{
											if($regionid == $r['university_choice_two_state']){
												if($r['uni_forwarded_letter_two'] == "")
												{
												
											$upsecond = '<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>';
										
												}
												else
												{
												
											$upsecond = '<a class="form-control sbmt" style="height:32px;width:140px;" href="'.site_url().'regional/forwardtouniversity/'.$r['application_no'].'/'.$optNo.'">Forward To University</a>';
										
												}
											}
											 $letterDetails .=$upsecond;
				     
										}
										$upthird = '';
										if($optNo == 3)
										{
											if($regionid == $r['university_choice_three_state']){
												if($r['uni_forwarded_letter_three'] == "")
												{
												
											$upthird = '<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>';
										
												}
												else
												{
												
											$upthird = '<a class="form-control sbmt" style="height:32px;width:140px;" href="'.site_url().'regional/forwardtouniversity/'.$r['application_no'].'/'.$optNo.'">Forward To University</a>';
										
												}
											}
											   $letterDetails .= $upthird;
										}
									}
									
				              $output[] = $letterDetails;
								}
								else
								{
									$output[] =  "Forwarded to University";
								}								
							}
							
						}
						
						$response[] = $output;	
						$counter++;	
					}
					
				}
				
			
		
		$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
		$returnJson['recordsTotal'] = count($totalResult);
		$returnJson['recordsFiltered'] = $totalResult[0]['total'];
		$returnJson['data'] = $response;
		echo json_encode($returnJson);
	}
	
	 function applicantAcceptance() {
        try {
				$user_data = $this->session->userdata('user_data');
				$regionid = $user_data['state'];	
                $data['listofacceptance'] = $this->common_model->applicantAcceptanceForRo($regionid);
                $this->load->view('regional/header_regional');
                $this->load->view('regional/listofacceptance', $data);
                $this->load->view('regional/footer');
            
        } catch (Exception $e) {
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'regional/dashboard');
        }
    }
	
	  function applicantAcceptanceStatus() {
        try {
            $applicationId = $this->uri->segment(3);
            $user_data = $this->session->userdata('user_data');

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
            $data['listofacceptance'] = $this->common_model->applicantAcceptance($applicationId);
            $data['universityData'] = $this->common_model->getConfirmationofApplicationIds($applicationId);
            $this->load->view('regional/header_regional');		
            $this->load->view('regional/applicantAcceptanceView', $data);
            $this->load->view('regional/footer');
        } catch (Exception $e) {
            show_404();
            $this->session->set_flashdata('message_type', 'error');
            $this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
            redirect(site_url() . 'regional/dashboard');
        }
    }
	
	
		//Mission Popup
	
		function ajaxfile()
    {
		//echo "sadsad";die;
    	$user_data = $this->session->userdata('user_data');
		//$missionId = $user_data['user_country'];
		//$countryid = $misionData[0]['country']; 
		//$vars = $this->input->post();
		//$nowtime = time();
		//print_r($user_data);die;
		
			$data['user_data'] = $this->session->userdata('user_data');
			$regionid = $user_data['state'];
		$result = $this->common_model->getRegionalApplicationsCountAlert($regionid);
		//echo "<pre>";
		//print_r($result);die;
		
		$roFrdAppRes = $this->common_model->getRegionalApplicationsCountConfirmationAlert($regionid);
		
		//$confirmationReceive = $this->common_model->countgetConfirmationofHqrsAlert($this->ids);
		
		
		//$totalAcceptance = $this->common_model->countgetConfirmationofCandidatesAlert($this->ids);
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
		/* if(!empty($missionFrdAppRes)){
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
				$htm .= "<td>Confirmation sent to HQRS  : </td><td>".$roFrdAppRes."</td>";
				$htm .= "</tr>"; 
				

				
				$htm .="</thead>";
      $htm .= "</table>";
      echo $htm;
      exit;
				
				
				
			//}
			
			
		}
		function isValidCaptchTest($captchText)
		{  
			$sessionData = $this->session->userdata('captcha_val');
			$sessionText = $sessionData['code'];
			return ($captchText == $sessionText) ? TRUE : FALSE;
		}
		function strip_quotes($str)
		{
			return str_replace(array('"',"'",'>','<'), '', $str);
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
			$data['get_application_number'] = $this->random_num(15);
			$this->load->view('regional/header_regional');
			$this->load->view('regional/alumni_applications',$data);
			$this->load->view('regional/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading!');
			redirect(site_url().'site/dashboard');
		}
	}
	
	
	 public function savesAlumniData()
	{
		
		try
		{
			
				//$post     = $this->input->post();
	            //$clean    = $this->security->xss_clean($post);
				$this->form_validation->set_rules('nationality', 'Nationality', 'required');
	        $this->form_validation->set_rules('mission_id', 'Mission', 'required');
			$this->form_validation->set_rules('fullname', 'Name', 'required');
	        $this->form_validation->set_rules('mission_id', 'Mission', 'required');
			$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('passport_no', 'Passport', 'required');
	        $this->form_validation->set_rules('passport_issue_place', 'Passport issue Place', 'required');
			$this->form_validation->set_rules('passport_issue_date', ' Passport issue date', 'required');
	        $this->form_validation->set_rules('passport_issue_month', 'Passport issue month', 'required');
			$this->form_validation->set_rules('passport_issue_year', 'Passport issue year', 'required');
			$this->form_validation->set_rules('passport_expiry_date', 'Passport expiry date', 'required');
			$this->form_validation->set_rules('passport_expiry_date', 'Passport expiry month', 'required');
			$this->form_validation->set_rules('passport_expiry_year', 'Passport expiry year', 'required');
			$this->form_validation->set_rules('programme', 'Level of Programme', 'required');
			$this->form_validation->set_rules('course', 'Course', 'required');
			$this->form_validation->set_rules('unverisity', 'Unverisity', 'required');
	        $this->form_validation->set_rules('city', 'city', 'required');
			$this->form_validation->set_rules('duration_of_course_from', 'Duration of Course From', 'required');
			$this->form_validation->set_rules('duration_of_course_to', 'Duration of Course To', 'required');
			$this->form_validation->set_rules('date_of_arrival', 'Date of Arrival', 'required');
			$this->form_validation->set_rules('date_of_departure', 'Date of Departure', 'required');
			$this->form_validation->set_rules('year_of_passing', 'Year of Passing', 'required');
			$this->form_validation->set_rules('subject', 'Subject', 'required');
			$this->form_validation->set_rules('division', 'Division', 'required');
			$this->form_validation->set_rules('present_details', 'Present details', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');
	        $this->form_validation->set_rules('award_recognition', 'Award recognition', 'required');
			  if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('error',validation_errors());
				$this->session->set_flashdata('message_type', 'error');
				//$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        }
			else
			{
				
				$user_data = $this->session->userdata('user_data');
		        $regionid = $user_data['state'];
				$postData = $this->strip_quotes($this->security->xss_clean($this->input->post(NULL,TRUE)));
				if(!empty($_POST))
				{
				if($this->isValidCaptchTest($postData['captchatext'])){
					
				
	            if(!$this->user_model->isValidAluminiEmail($postData['email']))
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
			  $imgname = $postData['application_id'].'_'.time().'_alumni_pics_'.$name;
			  
			  $target_file = 'assets/site/main/alumni_pic/'.$imgname; 
			  if (move_uploaded_file($_FILES["img_alumnai"]["tmp_name"], $target_file)) 
			  { 
		$aluminiData = array(
				'application_id'=>$postData['application_id'],
				'photo'=>$imgname,
				'created'=>time(),
				'nationality'=>$postData['nationality'],
				'regional_id'=>$regionid,
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
				'date_of_arrival'=>$postData['date_of_arrival'],
				'date_of_departure'=>$postData['date_of_departure'],
				'present_occupation'=>$postData['present_occupation'],
				'passport_no'=>$postData['passport_no'],
				'award_recognition'=>$postData['award_recognition'],
				'passport_issue_date'=>$postData['passport_issue_date'],
				'passport_issue_month'=>$postData['passport_issue_month'],
				'passport_issue_year'=>$postData['passport_issue_year'],
				'passport_expiry_date'=>$postData['passport_expiry_date'],
				'passport_expiry_month'=>$postData['passport_expiry_month'],
				'passport_expiry_year'=>$postData['passport_expiry_year'],
				'passport_issue_place'=>$postData['passport_issue_place']
				
				);
			  	
				 $result = $this->common_model->insertAlumniData($aluminiData);
				 if($result){
				 $message = '';                
		         $message .= '<strong>Hi '.$postData['fullname'].',</strong><br><br>';
		         $message .= 'Thanks for your registration in A2A Scholarships portal as a Alumini.<br>';
				 $message .= "<strong><a href= '".site_url().'home/aluminiPdf/'.$postData['application_id']."' download>Downlaod</a></strong><br><br>";
				 
				 
				 /* $data['alunamiapplication'] = $this->common_model->getAlumaniApplicationbyId($postData['application_id']);
				
						
			    $pdffc = $this->load->view('site/viewAlumaniApplication',$data,TRUE);
				$mpdf = new Mpdf('s','A4','','',5,7,05,10,10,10);			
				$mpdf->SetFont('Arial','B',12);
				$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
				$mpdf->watermark_font = 'DejaVuSansCondensed';
				$mpdf->showWatermarkText = true;
				$html1 .= "<div style='font-size:7pt;position:absolute;right:0;width:150px;top:20px;'>".date("jS F Y h:i:s")."</div>";
				//$html = $content;
				//$imgArray = $this->common_model->getUserImage($data[0]['uid']);		  
				
				$mpdf->SetDisplayMode('fullpage');			 
				// LOAD a stylesheet
				$stylesheet = file_get_contents('assets/site/main/css/bootstrap.min.css'); 
				
				$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
				$mpdf->WriteHTML($html1,2);
				
				$mpdf->WriteHTML($pdffc);
				$content = chunk_split(base64_encode($mpdf->Output('', 'S'))); */
				//$file_name = md5(rand()) . '.pdf';
				//$mpdf->Output();
				//file_put_contents($file_name, $file);
				//$this->load->library('mpdf');
				//$mpdf = new Mpdf('L', 'A4', 0, 'Trebuchet MS', 6, 6, 9, 9, 3, 3, 'L');
				//ob_start();
				//$html = ob_get_contents();
				//ob_end_clean();
				//$mpdf->WriteHTML(utf8_encode($html));
				//$content = chunk_split(base64_encode($mpdf->Output('', 'S')));
				  //$filename = "alumini.pdf";
				
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
							
					        $content = $this->load->view('site/mail_acknowledgement',$data, true); 
					    
							 $from_email = $this->config->item('fromEmail'); ; 
							 $to_email = $postData['email']; 			   
						 /* Load email library */
						 $this->load->library('email',$config);			   
						 $this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
						 $this->email->to($to_email);
						 $this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
						 //$this->email->attach($content, 'attachment', $filename, 'application/pdf');
						 $this->email->message($content); 	
						 //$data['alunamiapplication'] = $this->common_model->getAlumaniApplicationbyId($application_no);
						 
						 
						 //$mpdf = new Mpdf('s', 'A4', '', '', 7, 7, 05, 10, 10, 10);
						 
						 //$attach_str = $this->load->view('site/viewAlumaniApplication',$data,true); // true returns 
						 //$pdfFilePath = FCPATH . "assets/site/docs/pdf_name.pdf";
						//$mpdf->WriteHTML($html);
						//$mpdf->Output($pdfFilePath, "F");
						 //$this->email->attach($attach_str, 'attachement', 'somename.pdf', 'application/pdf');
						  if($this->email->send()) 
						 {
							 $this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Please check your email inbox/spam!');
							redirect(site_url().'regional/dashboard');	
							 //$this->email->clear($pdfFilePath);
						 	 						  }					
						  else 
						    $this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Email not sent');
							redirect(site_url().'regional/dashboard');	
						 
						  
				 }
				 
				 
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
					redirect(site_url().'regional/dashboard');					
				 }
			  }
			  else
			  {
		  		$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
				redirect(site_url().'regional/dashboard');
			  }
			} 
			else
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
				redirect(site_url().'regional/dashboard');
			}
				}
				else
	            {
	            	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You have already apply!');
					redirect('regional/dashboard');
				}
					
					
					
				}
				
				else
				{
					
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You have entered wrong text!');
					redirect('regional/dashboard');
					
				}
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
	
}

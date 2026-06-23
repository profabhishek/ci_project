<?php

ini_set('memory_limit','512M');
error_reporting(0);
ini_set('display_errors', 0);

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
       // $this->load->library('fpdi/PDF_HTML');
		$this->load->helper('status_helper');
        $this->load->helper('download');
        $this->load->helper('date');   
        $this->load->model('user_model');        
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
				//University Status 
   public function getNewApplicaitonsDemo()
    {
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];
		$misionData = $this->common_model->getMissionInfo($missionId);
    	$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		$result = $this->mission_model->getMissionDemoApplications($vars,$this->ids,$countryid);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->mission_model->getTotalMissionDemoApplications($vars,$this->ids,$countryid);
		
		$response = array();
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				
				
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
				$output[] = $applicationDetails[0]['passport_no'];
				$output[] = $applicationDetails[0]['dob'];
				$output[] = $applicationDetails[0]['phone_number'];
				$output[] = ($applicationDetails[0]['gender']== 1) ? 'Male' : 'Female';
				$output[] = $country[0]['country_name'];				
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 4 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$nomenclature = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature']);
					$nomenclature1 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_two']);
					$nomenclature2 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_three']);
					$nomenclature3 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fourth']);
					$nomenclature4 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					if($universityId == $applicationDetails[0]['universty_choice']){
					$fullCourse .= $nomenclature[0]['title'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_two']){
					$fullCourse .= $nomenclature1[0]['title'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_three']){
					$fullCourse .= $nomenclature2[0]['title'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fourth']){
					$fullCourse .= $nomenclature3[0]['title'].'<br/>';
					}
					elseif($universityId == $applicationDetails[0]['universty_choice_fifth']){
					$fullCourse .= $nomenclature4[0]['title'].'<br/>';
					}
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
				
				
				$date1 = strtotime($r['created']);	
				//$output[] = date('Y-m-d',$date1);
				$output[] = date("Y-m-d", $date1);	
				//$output[] = date("Y-m-d", $r['SubmitDate']);	
				$date2 = strtotime($r['created']);	
				$output[] = date('Y-m-d',$date2);
				
/* 
				if($applicationDetails[0]['universities_status'] == 23)
				{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt">Process</a>';
				}
				else
				{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" disabled=disabled href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt" >Process</a>';
				} */
				
				
					if($r['universities_status'] == 22)
				{
					
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" title = "Process" href="'.site_url().'mission/viewApplication/'.base64_encode($applicationDetails[0]['application_no']).'" class="form-control sbmt">Process</a>';
				}
				else
				{
					//$output[] = 'Not Allowed';
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" title = "This button will be enabled once admission is confirmed by University." href="javascript:void(0);" class="btn btn-block btn-default sbmt disabled">Process</a>';
				} 
				
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'mission/viewfullApplications/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt1">View</a>';
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
		function openUniversityStatus(){
		
		
		echo openUniversityStatus();
		
	}
   function openUniversityStatus1()
    {
		//echo "-------------------";die;
		//echo '<pre>';
		//print_r($_POST);die;
		$appId = $_POST['id'];
		//echo '<pre>';
		//print_r($_POST);die;
		$applicanteDetails = $this->mission_model->getApplicantDetails($appId);
		$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicanteDetails[0]['application_no']);
		$applicaitonsStatus = $this->common_model->getCommonApplicationStatus($appId);
		//echo '<pre>';
		//print_r($applicaitonsStatus);die;
			?>
<div class = "table-responsive">
						<table class="table">
						<thead>
							<th>S.No.</th>
							
							<th>Status</th>	
							<th>Alerts</th>	
							<!-----<th>Reasons</th>--->	
							<th>Undertaking</th>
                            <th>Visa</th>							
							<th>Travel Details</th>		
						</thead>
						<tbody>	
							<?php 
							if(count($applicaitonsStatus)>0)
							{
								//echo "<pre>";print_r($applicaitonsStatus);die;
							?>
							<tr>
								<td>1</td>
								
								<td>
								<?php
								if($applicaitonsStatus[0]['status'] == 1 || $applicaitonsStatus[0]['status'] == 6)
								{
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning">Appliation Underproess</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == 10 && $applicaitonsStatus[0]['universities_status'] == 22)
								{
									?>
									<span class="label label-primary">Scholarship under process</span>
									
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == -3)
								{
									echo 'Your Application is not processed due to these <a href="javascript:void(0);" data-toggle="modal" data-target="#reasons">Reasons</a>';
								}
								elseif($applicaitonsStatus[0]['status'] == 5 || $applicaitonsStatus[0]['universities_status'] == 18)
								{
									?>
								
									<span class="label label-warning">Please Re-submit Again</span>
									<?php
								}
								
								elseif($applicaitonsStatus[0]['universities_status'] = 22 && $applicaitonsStatus[0]['undertaking_doc'] != NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Undertaking Successfully uploaded by student</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] = 22 && $applicaitonsStatus[0]['undertaking_doc'] == NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Confirmed by University</span>
									<?php
								}
								
								
								?>
								</td>
								<!------<td><span class="label label-danger">Resubmit your application before date:<?php echo $this->config->item('Mission_Applicant_Pending_Date'); ?></span></td>----->
								<td>
								<span class="label label-danger">
								
								<?php if($applicaitonsStatus[0]['universities_status'] == -1 && $applicaitonsStatus[0]['status'] == 1)
								{
									echo 'TBC (To be confirm)';
								}
								elseif($applicaitonsStatus[0]['status'] == 10 && $applicaitonsStatus[0]['universities_status'] == 22 && $applicaitonsStatus[0]['scholarship_id'] == NULL)
								{
									echo 'Please approach Indian mission';
								}
								elseif($applicaitonsStatus[0]['status'] == 10 && $applicaitonsStatus[0]['universities_status'] == 22 && $applicaitonsStatus[0]['scholarship_id']>= 0)
								{
									echo 'Please sign and upload the undertaking form to be uploaded by applicant';
								}
								elseif($applicaitonsStatus[0]['universities_status'] == 18 && $applicaitonsStatus[0]['status'] == 5)
								{
									echo 'Missing Documents : Please Re-Upload Your documents and Re-Submit your application.';
								}
								elseif($applicaitonsStatus[0]['status'] == 6)
								{
									echo 'Re-Uploaded Documents Successfully!';
								}
								elseif($applicaitonsStatus[0]['universities_status'] = 22 && $applicaitonsStatus[0]['undertaking_doc'] != NULL)
								{
									echo 'Please approach mission for issuing visa and download Undertaking and keep copy while applying for visa';
								}
								
								?>
									
								
								</span></td>
								
								<!-----<td>									              	<?php
									              		$reasons = $this->common_model->getResons($applicaitonsStatus[0]['application_no']);
														//echo "<pre>";print_r($reasons);die;
									              		$resonsArray = explode(',',$reasons[0]['checklist_ids']);
									              	
									              		$counter = 1;
									              		if(count($resonsArray) > 0)
									              		{
															foreach($resonsArray as $res)
															{
																$item = $this->common_model->getChecklistItemById($res);
																echo '<li class="list-group-item">'.$item[0]['item'] .'</li>';
															}
														}
									              	?>  </td>---->
								<td>
								<?php 
								//echo "<pre>";print_r($applicaitonsStatus);
									if($applicaitonsStatus[0]['universities_status'] == 22 && $applicaitonsStatus[0]['status']>=  11)
								{
									
									
									?>
									<a href="<?php echo site_url();?>assets/site/main/undertakings/<?php echo $applicaitonsStatus[0]['undertaking_doc'];?>" target = "_blank"><span class = "label label-success">Download</span></a>
									
									<?php
								}
									else
								{
									?>
									
									<!----<span class="label label-warning">Pending at applicant</span>----->
									<span class="label label-warning">Once scholarship is granted to be uploaded by applicant.</span>
									<?php
								}
								?>
								</td>
								
								
									<td>
								<?php 
								//echo "<pre>";print_r($applicaitonsStatus);
								if($applicaitonsStatus[0]['visa_no'] == '')
								{
									?>
									<!----<span class="label label-warning">Pending at applicant</span>--->
									<span class="label label-warning">Once Visa is issued to be uploaded by applicant.</span>
									<?php
								}
									else
								{
									?>
									<span class="label label-info">Uploaded</span>
									<?php
								}
								?>
								</td>
								
								<td>
								<?php 
								$travel = $this->common_model->getTravelData($applicaitonsStatus[0]['application_no']);
								//echo "<pre>";print_r($travel);
									if($travel[0]['travel_plan_doc'] == '')
								{
									?>
									<!------<span class="label label-warning">Pending at applicant</span>----->
									<span class="label label-warning">Once students book tickets to be uploaded by applicant.</span>
									<?php
								}
									else
								{
									?>
									<a href="<?php echo site_url();?>assets/site/main/travelplan/<?php echo $travel[0]['travel_plan_doc'];?>" target = "_blank"><span class = "label label-success">Download</span></a>
									
									<?php
								}
								?>
								</td>
							
								<div id="reasons" class="modal fade" role="dialog">
  									<div class="modal-dialog popup">
  									<section class="content">
									      <!-- Small boxes (Stat box) -->
									      <div class="row">
									      	<div class="col-xs-12">
									    	<div class="box">
												<div class="box-header"><b>Resubmit your application before date:  <?php echo $this->config->item('Mission_Applicant_Pending_Date'); ?></b></div>
									              <div class="box-body">    
									              		<ul class="list-group">
									              	<?php
									              		$reasons = $this->common_model->getResons($applicaitonsStatus[0]['application_no']);
									              		$resonsArray = explode(',',$reasons[0]['checklist_ids']);
									              	
									              		$counter = 1;
									              		if(count($resonsArray) > 0)
									              		{
															foreach($resonsArray as $res)
															{
																$item = $this->common_model->getChecklistItemById($res);
																echo '<li class="list-group-item">'.$item[0]['item'] .'</li>';
															}
														}
									              	?>  
									              	</ul>
									              </div>          
									       </div>
									       </div>
									      </div>
									      <!-- /.row -->
									      <!-- Main row -->
      
      <!-- /.row (main row) ----->

									</section>
  									</div>
  								</div>	
								</td>
								
								
							</tr>
							<?php	
							}
							
							?>					
														
						</tbody>
					</table>
							</div>
  <?php	
	}
	
	public function new_applicationsDemo()
	{
		try{
			
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			//$data['newApplication']= $this->common_model->getMissionApplications($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/new_applicationsDemo',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error! Try After Some Time!');
			redirect(site_url().'mission/dashboard');	
		}
	}
	  public function getNewApplicaitons()
    {
		$year = $this->uri->segment(3);
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];
		$misionData = $this->common_model->getMissionInfo($missionId);
    	$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		$result = $this->mission_model->getMissionApplications($vars,$this->ids,$countryid,$year);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->mission_model->getTotalMissionApplications($vars,$this->ids,$countryid,$year);
		
		$response = array();
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				
				
				$date1 = '2021-03-15';
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
				$output[] = $applicationDetails[0]['passport_no'];
				$output[] = $applicationDetails[0]['dob'];
				$output[] = $applicationDetails[0]['phone_number'];
				$output[] = ($applicationDetails[0]['gender']== 1) ? 'Male' : 'Female';
				$output[] = $country[0]['country_name'];				
				if($applicationDetails[0]['programme'] == 3 || $applicationDetails[0]['programme'] == 8)
				{
					$course = $this->common_model->getProgrammeById($applicationDetails[0]['programme']);
					$output[] = $course[0]['name'].' ('.$applicationDetails[0]['course_subject'].')';
				}
				else
				{
					$nomenclature = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature']);
					$nomenclature1 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_two']);
					$nomenclature2 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_three']);
					$nomenclature3 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fourth']);
					$nomenclature4 = $this->common_model->getnomenclatureByid($applicationDetails[0]['nomenclature_fifth']);
					$fullCourse ="";
					$strm1 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name']);
					$strm2 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($applicationDetails[0]['course_option_name_fifth']);
					//echo "<pre>";print_r($applicationDetails[0]);
					$fullCourse .= '1) '.$nomenclature[0]['title'].'<br/>';
					$fullCourse .= '2) '.$nomenclature1[0]['title'].'<br/>';
					$fullCourse .= '3) '.$nomenclature2[0]['title'].'<br/>';
					$fullCourse .= '4) '.$nomenclature3[0]['title'].'<br/>';
					$fullCourse .= '5) '.$nomenclature4[0]['title'].'<br/>';
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
				
				if(!empty($r['region_one_status_date'])){
				$date4 = strtotime($r['region_one_status_date']);	
				$orgDate1 = date('d-m-Y', $r['region_one_status_date']); 
				$output[] = $orgDate1;
				}
				else
				{
					$output[] = 'NA';
					
				}
				
				//$response = $this->common_model->getconfirmationDataforHqrs($applicationDetails[0]['application_no']);
				//echo "<pre>";print_r($response);die;
				
/* 
				if($applicationDetails[0]['universities_status'] == 23)
				{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt">Process</a>';
				}
				else
				{
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" disabled=disabled href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt" >Process</a>';
				} */
				
				
					 if($r['status'] == 10)
				{ 
					$output[] = '<a style="float:left;margin-right:7px;width:104px;" title = "Process'.$applicationDetails[0]['country'].'" href="'.site_url().'mission/viewApplication/'.$applicationDetails[0]['application_no'].'" class="form-control sbmt">Process</a>';
				}
				 elseif($r['course_type'] == 1)
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
	 public function getUniversityConfirmDetail()
	{
		$postData = $this->input->post(NULL,TRUE);
		//$cleanData = $this->security->xss_clean($postData);
		$cleanDatas = $this->security->xss_clean($postData);
	    $cleanData =  $this->strip_quotes($cleanDatas);		

		//echo "<pre>";print_r($cleanData);die;
		
		echo json_encode($this->common_model->isAnyUniversityResponseConfirmedOrNot($cleanData['appid'],$cleanData['is_accept']));
	}
	public function getCourseDetail()
	{
		$postData = $this->input->post(NULL,TRUE);
		//$cleanData = $this->security->xss_clean($postData);	
		$cleanDatas = $this->security->xss_clean($postData);
	     $cleanData =  $this->strip_quotes($cleanDatas);
		//echo "<pre>";print_r($cleanData);die;
		echo json_encode($this->common_model->getCourseDetails($cleanData['appid'],$cleanData['uniid']));
	}
    public function getNewApplicaitonslive()
    {
    	$user_data = $this->session->userdata('user_data');
		$missionId = $user_data['user_country'];
		$misionData = $this->common_model->getMissionInfo($missionId);
    	$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		$result = $this->mission_model->getMissionApplications($vars,$this->ids,$countryid);
		$totalResult = $this->mission_model->getTotalMissionApplications($vars,$this->ids,$countryid);
		
		$response = array();
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				$applicationDetails = $this->common_model->getApplicationStepOneByAppno($r['application_no']);
				$country = $this->common_model->getCountryById($applicationDetails[0]['nationality']);
				$gender = "";
				$output= array();	
				
				
						$date1 = '2021-03-15';
						$date = date_create($r['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
				
				
				
				
				$studentyreg = strtotime($r['created']);
				
				//$finish = date("Y-m", $r['created']);
				//$checkDate = '1575142427';
						//$date = date_create($r['created']);
						//$array =  (array) $date;
						//$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//print_r($date2);die;
						
						
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
						
				$output[] = $counter;
				$output[] = $applicationDetails[0]['fullname'].' '.$applicationDetails[0]['middlename'].' '.$applicationDetails[0]['familyname'].$new;
				$output[] = $applicationDetails[0]['email'];
				$output[] = $applicationDetails[0]['passport_no'];
				$output[] = $applicationDetails[0]['dob'];
				$output[] = $applicationDetails[0]['phone_number'];
				$output[] = ($applicationDetails[0]['gender']== 1) ? 'Male' : 'Female';
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
				
				
				//$output[] = $r['created'];	
				$output[] = date("Y-m-d",$studentyreg);
				$output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'mission/viewApplication/'.base64_encode($applicationDetails[0]['application_no']).'" class="form-control sbmt">Process</a>';
				$output[] = '<a style="float:left;width:104px;" href="'.site_url().'mission/viewfullApplication/'.base64_encode($applicationDetails[0]['application_no']).'" class="form-control sbmt1">View</a>';
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
			
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['newApplication'] = count($this->common_model->getMissionApplications($this->ids));
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
				//$cleanData = $this->security->xss_clean($postData);	
				$cleanDatas = $this->security->xss_clean($this->input->post(NULL, TRUE));
				$cleanData =  $this->strip_quotes($cleanDatas);				
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
				//$cleanData = $this->security->xss_clean($postData);
				$cleanDatas = $this->security->xss_clean($this->input->post(NULL, TRUE));
				$cleanData =  $this->strip_quotes($cleanDatas);				
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
			$data['confirmaitonofuniversityformhqrsOld'] = $this->common_model->getConfirmationofFourthOptionByHqrsOld($this->ids);
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
        $data['applicaitonStepOne'] = $this->common_model->getMsnApplicationStepOneByAppno($applicationId);
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
        $data['university'] = $this->common_model->getconfirmationDataByMission($applicationId);  // ADDED
        $data['currentyear'] = date('Y');  // ADDED
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
	public function historyoldview()
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
			$this->load->view('mission/acceptanceoldHistory',$data);
			$this->load->view('mission/footer');	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Try After Some Time!');
			redirect(site_url().'mission/dashboard');
		}
	}
	
	function confirmationoldReceivedWithFormat()
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
		public function viewfullApplications()
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
			$this->load->view('mission/viewFullApplications',$data);
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
			//$data['applicaitonStepOne'] = $this->common_model->getMsnApplicationStepOneByAppno($applicationId);
			$data['applicaitonStepOne'] = $this->common_model->getHeadquarterApplicationStepOneByAppno($applicationId);
			
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
			//print_r($this->common_model->getApplicationStepOneByAppno($applicationId));die;
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
			$appno = base64_decode($this->uri->segment(3));
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['alunamiapplication']= $this->common_model->getMissionAlumaniApplicationbyId($appno);
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
			
			$data['year'] = $this->uri->segment(3);
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
			$data['approvedAyushApplication'] = $this->common_model->getMissionsAyushProcessedApplications($this->ids);
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
	function approved_applications_2023()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionid = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionid);
			$data['approvedApplication'] = $this->common_model->getMissionsProcessedApplications($this->ids);
			$data['approvedAyushApplication'] = $this->common_model->getMissionsAyushProcessedApplications($this->ids);
			//$data['icar_applications'] = $this->common_model->getHQRSAYUSHProcessedApplication($this->ids);
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
		function approved_applications_2026()
	{
		try{
			$user_data = $this->session->userdata('user_data');
			$missionid = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionid);
			$data['approvedApplication'] = $this->common_model->getMissionsProcessedApplications25($this->ids);
			$data['approvedAyushApplication'] = $this->common_model->getMissionsAyushProcessedApplications25($this->ids); 
			//$data['icar_applications'] = $this->common_model->getHQRSAYUSHProcessedApplication($this->ids);
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
			$data['misionData'] = $this->common_model->getMissionInfo($missionid);
			$data['travelold'] = $this->common_model->getVisaConveyedoldApplicatgion($this->ids);	
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
        $userInfo =$this->session->userdata('user_data');
		$lastLoginHistry = $this->user_model->updateLogoutHistry($userInfo);
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
			$data['mission'] = $user_data['user_country'];
			
			
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
//print_r($missionId);die;
			$data['newTwentryTwoCountApplication2526'] = $this->common_model->getCountTwentyTwoMissionApplications2526($this->ids);

			$data['newTwentryTwoCountApplication2425'] = $this->common_model->getCountTwentyTwoMissionApplications2425($this->ids);

			$data['newTwentryTwoCountApplication2324'] = $this->common_model->getCountTwentyTwoMissionApplications2324($this->ids);
			
			$data['newTwentryTwoCountApplication'] = $this->common_model->getCountTwentyTwoMissionApplications($this->ids);
			
			$data['newCountApplication'] = $this->common_model->getCountMissionApplications($this->ids);
			
			
			//$data['approvedApplication'] = count($this->common_model->getMissionsProcessedApplications($this->ids));
			
			$data['countapprovedApplication'] = $this->common_model->countgetMissionsProcessedApplications($this->ids);
			$data['countapprovedApplication25'] = $this->common_model->countgetMissionsProcessedApplications25($this->ids);
			
			$data['rejectedApplication'] = count($this->common_model->getMissionsRejectedApplications($this->ids));
			
			//$data['results'] = count($this->common_model->getEnglishProficiencyTestResults($this->ids));
			//$data['confirmationForwardtoMissionbyHqrs'] = count($this->common_model->getConfirmationofHqrs($this->ids));
			
			$data['countconfirmationForwardtoMissionbyHqrs'] = $this->common_model->countgetConfirmationofHqrs($this->ids);
			
			
			$data['countconfirmationForwardtoMissionbyHqrsDemo'] = $this->common_model->countgetConfirmationofHqrsDemo($this->ids);
			//$data['confirmaitonofuniversityformhqrs'] = count($this->common_model->getConfirmationofFourthOptionByHqrs($this->ids));
			
			$data['countconfirmaitonofuniversityformhqrs'] = $this->common_model->countgetConfirmationofFourthOptionByHqrs($this->ids);
			
			//$data['listofacceptance'] = count($this->common_model->getConfirmationofCandidates($this->ids));
			
			
			$data['countlistofacceptance'] = $this->common_model->countgetConfirmationofCandidates($this->ids);
			
			$data['countlistofacceptance2025'] = $this->common_model->countgetConfirmationofCandidates2025($this->ids);
			
			$data['countlistofacceptanceDemo'] = $this->common_model->countgetConfirmationofCandidatesDemo($this->ids);
			//$data['visaendrosment'] = count($this->common_model->getAcceptedCandidates($this->ids));
			
			$data['countvisaendrosment'] = $this->common_model->countgetAcceptedCandidates($this->ids);
			
			//$data['travel'] = count($this->common_model->getVisaConveyedApplicatgion($this->ids));
			
			$data['counttravel'] = $this->common_model->countgetVisaConveyedApplicatgion($this->ids);
			
			
			//$data['holdapplications']= count($this->common_model->hold_applications($this->ids));
			
			$data['countholdapplications']= $this->common_model->counthold_applications($this->ids);
			
			//$data['pending_application']= count($this->common_model->pending_applications($this->ids));
			
			$data['countpending_application']= $this->common_model->countpending_applications($this->ids);
			
			//$data['resubmitapplication']= count($this->common_model->resubmitapplication($this->ids));
			
			$data['countresubmitapplication']= $this->common_model->countresubmitapplication($this->ids);
			
			$data['alumanidata'] = count($this->common_model->getAlumaniApplications($missionId));
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
			$applicationId = base64_decode($this->uri->segment(3));
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$stepthree = $this->common_model->getApplicationStepThreebyAppNo($applicationId);		
			$country = $this->common_model->getCountryById($stepOne[0]['nationality']);
			//echo $country;die;
			//echo '<pre>'; print_r($country);die;
			//$schemeId = $this->common_model->getMappingDataResponse($applicationId);
			//getconfirmationDataByMission
			$university = $this->common_model->getconfirmationDataByMission($applicationId);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$travel = $this->common_model->getTravelPlan($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$mission = $this->common_model->getMissionInfo($stepthree[0]['application_through']);
			$course = $this->common_model->getCoursesById($stepOne[0]['course']);
			$uni = $this->common_model->getUniversityById($university[0]['regional_university']);

			$cities = $this->config->item('grade_cities');

			//echo '<pre>'; print_r($cities);die;

			$missionDetails = $this->common_model->getMissionDetails($applicationId);
			$missionPersonName = $missionDetails[0]['mission_person_name'];
			$missionPersonPlace = $missionDetails[0]['mission_person_place'];
			$missionPersonDesignation = $missionDetails[0]['mission_person_designation'];

			$imgPath = site_url().'assets/site/main/mission_signature/'.$missionDetails[0]['mission_person_signature'];
			$new='<img src="'.$imgPath.'" style="width:100px;">';

			$image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$logo = '<img src="' . $image . '" style="width:auto;">';

			ob_start();
			?>
					<html>
				<style>
					body {
						font-family: Arial;
						font-size: 13px;
					}
					tbody {
						font-size: 13px;
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
					<p style="text-align: right;"><small>Ref. No. <?php echo $applicationId; ?> <br/>Date: <?php echo date('d M Y h:i:s'); ?> </small></p>
					<div style="text-align: center;"><?php echo $logo;?></div>
					<h3 style="text-align: center;">Indian Council For Cultural Relations (ICCR)</h3>
					<h2 style="color: #d8d5d5;opacity: 0.3;font-family: arial;font-size: 38px;margin: 0;transform(rotate(45deg));transform-origin(0 0);transform: rotate(328deg);position: relative;top: 300px;text-align: center;">Indian Council For Cultural Relations</h2>

					<table>
						<tbody>
							<tr>
								<td>01. Name of scholar</td>
								<td>:&nbsp;&nbsp;<?php echo $stepOne[0]['fullname']. ' ' .$stepOne[0]['middlename']. ' ' .$stepOne[0]['familyname']; ?></td>
							</tr>
							<tr>
								<td>02. Country</td>
								<td>:&nbsp;&nbsp;<?php echo $country[0]['country_name']; ?></td>
							</tr>
							<tr>
								<td>03. Mission dealing</td>
								<td>:&nbsp;&nbsp;<?php echo $mission[0]['mission_name']; ?></td>
							</tr>
							<tr>
								<td>04. Scheme</td>
								<td>:&nbsp;&nbsp;<?php echo $schemename[0]['scheme_name']; ?></td>
							</tr>
							<tr>
								<td>05. Course admitted to</td>
								<td>:&nbsp;&nbsp;<?php echo $course[0]['title']; ?></td>
							</tr>
							<tr>
								<td>06. University admitted to</td>
								<td>:&nbsp;&nbsp;<?php echo $uni[0]['name']; ?></td>
							</tr>
							<tr>
								<td>07. Date of Departure</td>
								<td>:&nbsp;&nbsp;<?php echo $travel[0]['departure_date']; ?></td>
							</tr>
							<tr>
								<td>08. Date of arrival in India</td>
								<td>:&nbsp;&nbsp;<?php echo $travel[0]['travel_arrival_date']; ?></td>
							</tr>
							<tr>
								<td>09. Flight Number</td>
								<td>:&nbsp;&nbsp;<?php echo $travel[0]['flight_no']; ?></td>
							</tr>

							<?php if($travel[0]['final_city_arrival'] == 7) { ?>
							<tr>
								<td>10. Final city of arrival</td>
								<td>:&nbsp;&nbsp;<?php echo $travel[0]['city_other']; ?></td>
							</tr>
							<?php } else { ?>
								<tr>
								<td>10. Final city of arrival</td>
								<!--<td>:&nbsp;&nbsp;<?php echo $cities; ?></td>-->
								<td>:&nbsp;&nbsp;<?php echo $travel[0]['final_city_arrival']; ?></td>
							</tr>
							<?php }	?>

							<tr>
								<td>11. Regional Office to be contacted</td>
								<td>:&nbsp;&nbsp;<?php echo $travel[0]['regional_office_contacted']; ?></td>
							</tr>
							<tr>
								<td>12. Cost of Ticket (INR)</td>
								<td>:&nbsp;&nbsp;<?php echo $travel[0]['cost_of_ticket']; ?></td>
							</tr>
						</tbody>
					</table>

					<!--<p style="text-align: left;">1. Name of scholar <?php echo 'Mr/Ms/Mrs' .$stepOne[0]['fullname']; ?></p>
					<p style="text-align: left;">2. Country <?php echo $country[0]['country_name']; ?></p>
					<p style="text-align: left;">3. Mission dealing <?php echo $mission[0]['mission_name']; ?></p>
					<p style="text-align: left;">4. Scheme <?php echo $schemename[0]['scheme_name']; ?></p>
					<p style="text-align: left;">5. Course admitted to <?php echo $course[0]['title']; ?></p>
					<p style="text-align: left;">6. University admitted to <?php echo $uni[0]['name']; ?></p>
					<p style="text-align: left;">7. Date of Departure <?php echo $schemename[0]['']; ?></p>
					<p style="text-align: left;">8. Date of arrival in India <?php echo $schemename[0]['']; ?></p>
					<p style="text-align: left;">9. Flight Number <?php echo $schemename[0]['']; ?></p>
					<p style="text-align: left;">10. Final city of arrival <?php echo $schemename[0]['']; ?></p>
					<p style="text-align: left;">11. Regional Office to be contacted <?php echo $schemename[0]['']; ?></p>
					<p style="text-align: left;">12. Cost of Ticket (INR) <?php echo $schemename[0]['']; ?></p>
					<p style="text-align: left;">Signature: <?php echo $new; //$schemename[0]['mission_person_signature'];?></p>-->
					</br></br>
					
					<p style="text-align: left;"><?php echo $new;?> <br><br>Signature</p>	
					<p style="text-align: left;">Name of Official: <?php echo $missionPersonName;?></p>
					<p style="text-align: left;">Designation: <?php echo $missionPersonDesignation; ?></p>
					<p style="text-align: left;">Mission/Place: <?php echo $missionPersonPlace; ?></p>
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
		//try
		//{
			$user_data = $this->session->userdata('user_data');
			//echo "<pre>";print_r($data['misionData']);die;
			$missionId = $user_data['user_country'];
			
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			//echo "<pre>";print_r($data['misionData']);die;
			$data['visaendrosment'] = $this->common_model->getAcceptedCandidates($this->ids);
			$data['visaendoldrosment'] = $this->common_model->getAcceptedoldCandidates($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/visaendrosment',$data);
			$this->load->view('mission/footer');
		//}
		// catch(Exception $e)
		// {
		// 	$this->session->set_flashdata('message_type', 'error');
		// 	$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
		// 	redirect(site_url().'mission/dashboard');
		// }
	}
	function visaendrosmentDemo()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['visaendrosment'] = $this->common_model->getAcceptedCandidatesDemo($this->ids);
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
	
		
	   	//grant Visa
	
	function processApplication()
    {
		
		//echo '<pre>';
		//print_r($_POST);die;
		//echo $appid;die;
		$appId = $_POST['id'];
		//echo $appId;die;
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
			  $htm .="<select class='form-control' id ='visa_grant_permission' name='visa_grant_permission' required>";
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
		    //$cleanData = $this->security->xss_clean($postData);
			$cleanDatas = $this->security->xss_clean($postData);
			$cleanData =  $this->strip_quotes($cleanDatas);
			$appid = $cleanData['appId'];
			//echo $appid;die;
			/* $checkStatus = $this->mission_model->checkStatus($appid);
			if(!$checkStatus){
							$this->session->set_flashdata('message_type', 'error');
					        $this->session->set_flashdata('error', 'You are Not Authorise this.');
							redirect('mission/listofacceptance');
							return false;
			} */
			
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
					redirect(site_url().'mission/listofacceptanceDemo');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'mission/listofacceptanceDemo');					
				 }
			  
			  
			}	
		}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'mission/approved_applications');
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
			$compareDate = '15-03-2021';
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
				 
				 $current  = '15-03-2021';
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
			$applicationId = base64_decode($this->uri->segment(3));
			$data['appno'] = $applicationId;
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['applicaitonStepOne'] = $this->common_model->getMsnApplicationStepOneByAppno($applicationId);
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
			$data['year']= $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
                        
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['listofacceptance'] = $this->common_model->getConfirmationofCandidates($this->ids);
			$data['listofoldacceptance'] = $this->common_model->getConfirmationofoldCandidates($this->ids);
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
	
	function listofacceptances()
	{
		try
		{
			$data['year']= $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
                        
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['listofacceptance'] = $this->common_model->getConfirmationofCandidates($this->ids);
			$data['listofoldacceptance'] = $this->common_model->getConfirmationofoldCandidates($this->ids);
			//echo "<pre>";print_r($data['listofacceptance']);die;
			$this->load->view('mission/header_mission');
			$this->load->view('mission/listofacceptances',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	
	 public function getMissionAcceptance()
    {
		//echo "sddfsdfsd";die;
		$year= $this->uri->segment(3);
		//echo $year;die;
    	$user_data = $this->session->userdata('user_data');
		//echo "<pre>";print_r($user_data);die;
		//$missionId = $user_data['user_country'];
		//$misionData = $this->common_model->getMissionInfo($missionId);
    	//$countryid = $misionData[0]['country'];    	
		$vars = $this->input->post();
		//echo "<pre>";print_r($vars);die;pending_application
		//$counter = $_POST['start'];
		$missionId = $user_data['user_country'];
		$data['misionData'] = $this->common_model->getMissionInfo($universityId);
		//$data['misionData'] = $this->common_model->getMissionInfo($missionId);
		$result = $this->mission_model->getMissionAcceptance($vars,$universityId,$year);
		//echo "<pre>";print_r($result);die;
		$totalResult = $this->mission_model->getTotalMissionAcceptance($vars,$universityId,$year);
		
		$response = array();
		//$counter++;
		if(!empty($result))
		{
			$counter = 1;
			foreach($result as $r)
			{
				$output= array();	
				$output[] = $counter;
				$output[] = $r['application_no'];
				$output[]= $r['fullname'];
				$output[] = $r['email'];
				$country = $this->common_model->getCountryById($r['nationality']);
				$output[] = $country[0]['country_name'];	
				$progrm = $this->common_model->getProgrammeById($r['programme']);
				$output[] = $progrm[0]['name'];
				$uni = $this->common_model->getSchemeById($r['scholarship_id']);
				if(!empty($uni)){
						$scname = $uni[0]['scheme_name'];
						}else{
							$scname = "NA";
						}
				$output[]=$scname;
				if($r['scholar_acceptance'] == 1)
							{
								$st="Accepted";
							}
							elseif($app['scholar_acceptance'] == 2)
							{
								$st="Declined";
							}
							elseif($app['scholar_acceptance'] == -1)
							{
								$st= "Pending";
							}
					
					$output[]=$st;
			       $output[] = '<a style="float:left;margin-right:7px;width:104px;" href="'.site_url().'mission/historyview/'.base64_encode($r['application_no']).'" class="form-control sbmt">View</a>';
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
	function processConfirmedappfromhqrsDemo()
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
			$this->load->view('mission/processConfirmedappfromhqrsDemo',$data);
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
			//echo "";die;
			
			$applicationId = $this->uri->segment(3);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOneByAppno($applicationId);
			//echo "<pre>";print_r($data['applicaitonStepOne']);die;
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
		function listofacceptanceDemo()
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
			$this->load->view('mission/listofacceptanceDemo',$data);
			$this->load->view('mission/footer');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
	}
	function confirmaitonreceivesformhqrsDemo()
	{
		try
		{
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			$data['misionData'] = $this->common_model->getMissionInfo($missionId);
			$data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getConfirmationofHqrsDemo($this->ids);
			//$data['confirmationForwardtoMissionbyHqrs'] = $this->common_model->getConfirmationofApplicationIds($this->ids);
			$this->load->view('mission/header_mission');
			$this->load->view('mission/confirmaitonreceivesformhqrsDemo',$data);
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
	
		function confirmationReceivedWithFormat()
	{
		try
		{
			$doc = array();
			$applicationId = $this->uri->segment(3);
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);
			//echo "<pre>";print_r($stepOne);die;
			$uniid = $this->uri->segment(4);
			if($stepOne[0]['course_type']== 2)
			{
				$response = $this->common_model->isAyurvedaApplication($applicationId);
			}
			else
			{
				$response = $this->common_model->getconfirmationDataByMission($applicationId);
			}
			
			$region = 0;$coursename = "";$respFile="";
			if($stepOne[0]['course_type']== 2)
			{
			$course = $response[0]['course'];
			}
			else
			{
				$course = $response[0]['final_course'];
			}

			//echo $course;die;
			
			$current = date('d-m-Y');
			$fy = $this->getFinancialYears($current,1);
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$nomenid = $response[0]['nomenclature'];
			$nomclature = $this->common_model->getnomenclatureByid($nomenid);
			$nomenclature=$nomclature[0]['title'];
			
			$studentOther = $this->common_model->getStudentOtherDetails($applicationId);
			$missionDetails = $this->common_model->getMissionDetails($applicationId);
			$missionPersonName = $missionDetails[0]['mission_person_name'];
			
			$missionDate = $missionDetails[0]['mission_status_date'];
			
			$missionAyushDate = $missionDetails[0]['iccr_status_updtae_date'];
			
			$imgPath = site_url().'assets/site/main/mission_signature/'.$missionDetails[0]['mission_person_signature'];
			
			$new='<img src="'.$imgPath.'" style="max-width:100px; max-height:60px;">';
			
			$image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$logo = '<img src="' . $image . '" style="width:auto;">';

			$mission = $this->common_model->getMissionInfo($studentOther[0]['application_through']);
			$country = $this->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			$schemename = $this->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$regionInfo = $this->common_model->getRegionById($region);
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
			$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year '.$fy[0],'','J');
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
			//echo $applicationId;die;
			$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];	
			//echo "<pre>";print_r($user_data);die;
			//$applicationId = $this->common_model->getApplicationAppnoByUserId($userId);	
			//echo "<pre>";print_r($applicationId);die;
			//$applicationId =  $applicationId[0]['application_no'];
			
			$stepOne = $this->common_model->getApplicationStepOneByAppno($applicationId);		
			$country = $this->common_model->getCountryById($stepOne[0]['nationality']);
			$schemeId = $this->common_model->getMappingData($applicationId);
			
			$response = $this->common_model->getconfirmationDataByMission($applicationId);
			if(count($response) >1){
				$uni1 = $this->common_model->getUniversityById($response[1]['regional_university']);
				$course = $response[1]['final_course'];
			}
			else
			{
				$uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
				$course = $response[0]['final_course'];
				
			}
			//echo "<pre>";print_r($schemeId);die;
			$applicaitonStepThree = $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$userd = $this->common_model->getUserInfo($applicaitonStepThree[0]['uid']); 
			//echo $userd->id;die;
			$getDir = $this->common_model->getDirUserInfo($userd->id); 
			//echo "<pre>";print_r($getDir);die;
			$applicantAcceptanceDate = $schemeId[0]['undertaking_doc'];
			$date1 = $applicaitonSubmitData[0]['created'];						
			$acDate =  date('d-m-Y',$applicantAcceptanceDate);
			
			$imgs = file_get_contents($userd->dir .'/'.$applicaitonStepThree[0]['signature_doc']);
			$data = base64_encode($imgs);
			$f = finfo_open();
			$imgdata = base64_decode($data);
            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
			$img_base64_encoded = 'data:'.$mime_type.';base64,'.$data.'';
			$imageContent = file_get_contents($img_base64_encoded);
			$imgPath = tempnam(sys_get_temp_dir(), 'prefix');
			file_put_contents ($imgPath, $imageContent);
			/*if($getDir->dir == ''){
				$imgPath = site_url().'assets/site/main/profile_signature/'.$applicaitonStepThree[0]['signature_doc'];
			}else{
				$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			}*/
			$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			$new='<img src="'.$imgPath.'" style="width:100px;">';

			$image = site_url() . 'assets/site/main/images/mea-logo.jpg';
			$logo = '<img src="' . $image . '" style="width:auto;">';
			//echo "<pre>";print_r($imgPath);die;
			$uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
			//echo $uni1[0]['name'];
			
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
		<p>Acceptance of <?php echo $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname'] . ' to offer of admission at  ' . $uni1[0]['name'] . ' to pursue course  ' . $course;?> 
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


	function undertakingFromStudentdemo()
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
	function processagree()
	{
		try{
			
			
			//echo "";die;
			$applicationId = $this->uri->segment(3);
			//echo $applicationId;die;
			$response = $this->common_model->getconfirmationDataforHqrs($applicationId);
			//echo "<pre>";print_r($response);die;
			if($response[0]['confirmed_to_mission'] == 1){
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You have already uploaded!');
				redirect(site_url().'mission/dashboard');
				return false;
			}

			//echo "<pre>";print_r($response);die;
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			
			$data['applicaitonStepOne']= $this->common_model->getApplicationStepOneByAppno($applicationId);
			//echo "<pre>";print_r($data['applicaitonStepOne']);die;
			$data['applicaitonStepTwo']= $this->common_model->getApplicationStepTwoByAppno($applicationId);
			$data['applicaitonStepThree']= $this->common_model->getApplicationStepThreebyAppNo($applicationId);
			$data['applicaitonDocuments']= $this->common_model->getApplicationDocumentsbyAppNo($applicationId);
			//echo "<pre>";print_r($data['applicaitonDocuments']);die;
			$data['univercities'] = $this->common_model->getAllUnivercities();	
			$this->load->view('mission/header_mission');
			$this->load->view('mission/checklist_old',$data);
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
			
			
			//echo "";die;
			$applicationId = $this->uri->segment(3);
			//echo $applicationId;die;
			$response = $this->common_model->getconfirmationDataforHqrs($applicationId);
			
			$responseMapping = $this->common_model->getApplicationSubmitDatabyAppNo($applicationId);
			//echo "<pre>";print_r($responseMapping);die;
			if($response[0]['confirmed_to_mission'] == 1 && $responseMapping[0]['scholar_acceptance'] == 1){
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You have already uploaded!');
				redirect(site_url().'mission/dashboard');
				return false;
			}

			//echo "<pre>";print_r($response);die;
			$user_data = $this->session->userdata('user_data');
			$missionId = $user_data['user_country'];
			
			$data['applicaitonStepOne']= $this->common_model->getApplicationStepOneByAppno($applicationId);
			//echo "<pre>";print_r($data['applicaitonStepOne']);die;
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
			$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
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
			redirect(site_url().'headquarter/dashboard');	
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
			$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
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
			$mpdf->SetWatermarkText('Indian Council For Cultural Relations');
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
	
	public function applicaitonAgreeProcess()
	{
	//echo "-------------------";die;
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
						$update['status'] = 4;
						$update['mission_status_date'] = $data['xss_data']['mission_date'];
						$update['mission_person_name'] = $data['xss_data']['mission_name'];		
						$update['mission_person_designation'] = $data['xss_data']['mission_desg'];		
						$update['mission_person_place'] = $data['xss_data']['mission_place'];		
						$update['mission_person_signature'] = $imgname;	
						$update['scholarship_id'] = $data['xss_data']['schloarship_name'];
						$update['english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
						$update['checklist_ids'] = $data['xss_data']['checklist_ids'];	
						//echo "<pre>";print_r($data['xss_data']);die;
					//echo "1";die;
						$schemeId = $this->common_model->getMappingData($this->input->post('appid'));
						$schemename = $this->common_model->getSchemeById($this->input->post('schloarship_name'));
						$status = $this->common_model->updateMissionStatus($update,$userId,$data['xss_data']['application_number']);
						$appid = $this->input->post('appid');
						
						
						
						//var_dump($sts);die;
						if($status)
							if($status){
							
							echo json_encode(array('status'=>TRUE,"message"=>"Approved",'ref'=>$referenceNumber));
							}
						else
							echo json_encode(array('status'=>FALSE,"message"=>"Error"));	
					}	
					
					else
					{
						echo "2";die;
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
						
						
						$schemeId = $this->common_model->getMappingData($this->input->post('appid'));
						$schemename = $this->common_model->getSchemeById($this->input->post('schloarship_name'));
						//echo "<pre>";print_r($response);die;
						$status = $this->common_model->updateMissionStatus($update,$userId,$data['xss_data']['application_number']);
					
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
	
	public function applicaitonProcess()
	{

		// $post = $this->input->post('final_course');
		// echo '<pre>'; print_r($post);die;
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
				'final_course'=>$this->input->post('final_course'),
				'nomenclature'=>$this->input->post('nomenclature'),
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
						//$update['final_course'] = $data['xss_data']['final_course'];
						$update['nomenclature'] = $data['xss_data']['nomenclature'];
						$update['mission_status_date'] = $data['xss_data']['mission_date'];
						$update['mission_person_name'] = $data['xss_data']['mission_name'];		
						$update['mission_person_designation'] = $data['xss_data']['mission_desg'];	
						$update['mission_person_place'] = $data['xss_data']['mission_place'];		
						$update['mission_person_signature'] = $imgname;	
						$update['scholarship_id'] = $data['xss_data']['schloarship_name'];
						$update['english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
						$update['checklist_ids'] = $data['xss_data']['checklist_ids'];	
						
						$response = $this->common_model->getconfirmationDataforHqrs($this->input->post('appid'));
						$uninmae = $this->common_model->getUniversityStateById($this->input->post("regional_university"));
						//echo "<pre>";print_r($uninmae);die;
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
						 
						  $messages .= "<br/><br/>Mr./Ms./Mrs. ".$userdata[0]['username'] .", your admission in Course has been provisionally confirmed at ".$uninmae[0]['name']." under ".$schemename[0]['scheme_name']."  (".$schemename[0]['code'].").You may login on a2a portal page and accept or reject the offer of admissions with in stipulate time ".$this->input->post("timeline")."(see Timeline).";	
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
						//$update['final_course'] = $data['xss_data']['final_course'];
						$update['nomenclature'] = $data['xss_data']['nomenclature'];
						$update['mission_status_date'] = $data['xss_data']['mission_date'];
						$update['mission_person_name'] = $data['xss_data']['mission_name'];		
						$update['mission_person_designation'] = $data['xss_data']['mission_desg'];		
						$update['mission_person_place'] = $data['xss_data']['mission_place'];		
						$update['mission_person_signature'] = $imgname;	
						$update['scholarship_id'] = $data['xss_data']['schloarship_name'];
						$update['english_proficiency_test_marks'] = $data['xss_data']['testmarks'];	
						$update['checklist_ids'] = $data['xss_data']['checklist_ids'];	
						
						$response = $this->common_model->getconfirmationDataforHqrs($this->input->post('appid'));
						$uninmae = $this->common_model->getUniversityStateById($this->input->post("regional_university"));
						//echo "<pre>";print_r($uninmae);die;
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
						 
						  $messages .= "<br/><br/>Mr./Ms. ".$userdata[0]['username'] .", your admission in Course has been provisionally confirmed at ".$uninmae[0]['name']." under ".$schemename[0]['scheme_name']."  (".$schemename[0]['code'].").You may login on a2a portal page and accept or reject the offer of admissions with in stipulate time ".$this->input->post("timeline")."(see Timeline).";	
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
		$applicant_checklist = array("1","2","5","6","9");
		$mission_checklist = array("3","4","8","11");
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
   
   function confirmationReceivedWithFormatIcar()
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
			$pdf->MultiCell(180,5,'Please refer to the application uploaded on A2A Scholarship Portal by Mr./Ms. '.$stepOne[0]['fullname'].', a national of '.$country[0]['country_name'].' for admission under '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year 2021-2022. Mr./Ms. '.$stepOne[0]['fullname'].' is provisionally confirmed for '.$coursename.' course at '.$uninmae[0]['name'].', reference ICAR Delhi,'  .$regionInfo[0]['name'].' subject to production of all original documents at the time of joining','','J');
		$pdf->Ln(5);		
			$pdf->MultiCell(180,5,'Mission is requested to immediately take the following action:-','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'a)	Inform the candidate & convey his/her acceptance or rejection of the offer to ICCR at the earliest.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'b)	Obtain a written Undertaking from the student in the attached Proforma & email/fax it to ICCR. isd1section.iccr@nic.in / isd2section.iccr@nic.in / poafghan.iccr@nic.in','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'c)	Issue appropriate fulltime Student Visa (Research Visa in case of Ph.D.) to the student in accordance with the latest guidelines. The mission must issue the appropriate visa.','','J');
			$pdf->Ln(5);
			
			$pdf->MultiCell(180,5,'d) 	Inform the scholars to report to Scholarship Division, Indian Council for Cultural Relations  (ICCR),'.$regionInfo[0]['name'].' or The Head, Department of '.$coursename.', '.$uninmae[0]['name'].', reference ICAR Delhi,'  .$regionInfo[0]['name'].' alongwith all original certificates and testimonials and academic transcript in English on prescribed date in the attached acceptance letter of the university, failing which admission will be cancelled.','J');
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
	
	//Mission English Test Marks Update
   
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
			  $htm .="<select class='form-control' id ='testmarks' name='testmarks' required>";
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
		    //$cleanData = $this->security->xss_clean($postData);	
			$cleanDatas = $this->security->xss_clean($postData);	
			$cleanData =  $this->strip_quotes($cleanDatas);
			$appid = $cleanData['appId'];
			$checkStatus = $this->mission_model->checkStatus($appid);
			if(!$checkStatus){
							$this->session->set_flashdata('message_type', 'error');
					        $this->session->set_flashdata('error', 'You are Not Authorise this.');
							redirect('mission/confirmaitonreceivesformhqrs');
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
					redirect(site_url().'mission/confirmaitonreceivesformhqrs');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'mission/confirmaitonreceivesformhqrs');					
				 }
			  
			  
			}	
		}
		
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'mission/confirmaitonreceivesformhqrs');
		}
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
		
		
		$totalAcceptance = $this->common_model->countgetConfirmationofCandidatesAlert($this->ids);
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
				$htm .= "<td>Processed Application : </td><td>".$missionFrdAppRes."</td>";
				$htm .= "</tr>";
				
				$htm .= "<tr>";
				$htm .= "<td>Confirmation from HQRS: </td><td>".$confirmationReceive."</td>";
				$htm .= "</tr>";
				
				$htm .= "<tr>";
				$htm .= "<td>Total Acceptance: </td><td>".$totalAcceptance."</td>";
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
			//echo "<pre>";print_r($data['alumindetails']);die;
			if($alumindetails)
				{
				$filename    =   file_get_contents(base_url().$alumindetails[0]['file_path']);
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
	
	
	//Alumin Upload
	
		public function uploadAluminiDocs()
		{
			try
			{
				$user_data = $this->session->userdata('user_data');
			    $missionId = $user_data['user_country'];
				$files = $_FILES['file'];   
				$typpe = $_FILES['file']['type'];   		
				//echo "<pre>";print_r($typpe);die;
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
				
				if($typpe != "image/jpg" && $typpe != "image/jpeg" && $typpe != "image/png" && $typpe != "application/pdf" && $typpe != "application/xls")
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
						$target_file = 'assets/site/main/alumini_doc/';
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
			  			'doc_type'=>$types['otherDoc']['type'],
			  			'created'=>time(),
			  			'uid'=>$missionId
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
		public function downloadDocs(){
			//echo base64_decode($this->uri->segment(3));die;
			$file_name = base64url_decode($this->uri->segment(3));
			fileForceDownload($file_name);
		}
		
		
			//Mission Offer letter
   
   function openMissionOfferLetter()
    {
		
		
		$appId = $_POST['id'];
		//echo '<pre>';
		//print_r($_POST);die;
		$applicanteDetails = $this->mission_model->getApplicantDetails($appId);
		$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($applicanteDetails[0]['application_no']);
		//echo '<pre>';
		//print_r($applicanteDetails);die;
			?>
			<table class="table table-bordered">
    <thead>
        <th>Name</th>
		<th>Application No</th>
		<th>Email</th>
		<!---<th>Level of Programme</th>
		<th>University</th>--->
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
		 <!------<td><?php
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
					</td>------>

	<!------<table class="table table-bordered">
    <thead>
        <th>Remarks By University</th>
		<th>University Remarks Date</th>
		<th>Remarks By Applicant</th>
		<th>Applicant Remarks Date</th>
    </thead>
    <tbody>
	<?php
		if(count($applicanteDetails)>0)
				{
					?>	
<tr>
<td>

<?php 
if(!empty($applicanteDetails[0]['university_remarks'])){
echo $applicanteDetails[0]['university_remarks'];
}
else
{
	echo 'NA';
}

?>

</td>
<td>
<?php 
if(!empty($applicanteDetails[0]['update_university_remarks'])){
$unDate = $applicanteDetails[0]['update_university_remarks'];
echo date('Y-m-d',$unDate);	
}
else
{
	echo 'NA';
}

?></td>
<td><?php 
if(!empty($applicanteDetails[0]['student_remarks'])){
echo $applicanteDetails[0]['student_remarks'];
}
else
{
	echo 'NA';
}
?>
</td>
<td><?php 
$applicantDate = $applicanteDetails[0]['update_student_remarks'];	
if(!empty($applicantDate)){
	echo date('Y-m-d',$applicantDate);
}
else
{
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
    </tbody>----->
  </table>
  <?php
			
			  $htm  ="<form action='".site_url().'mission/saveOfferLetterData/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			  $htm .="<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>";
			  $htm .="<input type = 'hidden' name = 'appId' value = '".$applicanteDetails[0]['id']."'>";
			  $htm .="<input type = 'hidden' name = 'app_no' value = '".$applicanteDetails[0]['application_no']."'>";
			
			  
			  $htm .="<label>Action:</label>";
			  $htm .="<select class='form-control' id ='status' name='mission_status' required = 'true'>";
			 
			  $htm .="<option value=''>---Select---</option>";
			  $htm .="<option value='1'>Genrate Offer Letter</option>";
				  
			 
			   $htm .="</select>";
			  
			  $htm .="<div class='form-group'>";					    
			  $htm .="<div>";
			  $htm .="</br>";
			  $htm .="<input type='submit' class='btn btn-primary' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
			 
              $htm .="</form>";
              echo $htm;
              exit;
				
				
				
			//}
			
			
		}
		
		
		public function saveOfferLetterData()
	{
		
		try
		{
			$user_data = $this->session->userdata('user_data');
			$postData = $this->input->post(NULL,TRUE);
			//echo "<pre>";print_r($postData);die;
		    //$cleanData = $this->security->xss_clean($postData);	
			$cleanDatas = $this->security->xss_clean($postData);
			$cleanData =  $this->strip_quotes($cleanDatas);
			$id = $cleanData['appId'];
			$app_no = $cleanData['app_no'];
			$applicaitonStepOne = $this->common_model->getApplicationStepOneByAppno($app_no);
			//$checkStatus = $this->university_model->checkStatus($appid);
			//var_dump($applicaitonStepOne);die;
			//if(!$checkStatus){
					//$this->session->set_flashdata('message_type', 'error');
					//$this->session->set_flashdata('error', 'You are Not Authorise this.');
					//redirect('university/dashboard');
					//return false;
			//}
			
			
			
			if(!empty($_POST)){
				 $data = array(
				 'iccr_status_updtae_date'=>date('d-m-Y H:i:s'),
				 'region_forward_mission_status'=>$cleanData['mission_status'],
				 );
				// echo "<pre>";print_r($data);die;
			 	 $result = $this->mission_model->updateMissionOfferLetterDetails($data,$id,$app_no);
			 	 if($result)
				 {				 
				 	$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success',  'Offer Letter Genrate Successfully!');
					redirect(site_url().'mission/dashboard');		 						
				 }
				 else
				 {
				 	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error Occur While Saving Detail.!');
					redirect(site_url().'mission/dashboard');					
				 }
			  
			  
			}	
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error Occur While Saving Alumni Detail.!');
			redirect(site_url().'mission/dashboard');
		}
	}
		public function __destruct() {
    $this->db->close();
    }
}

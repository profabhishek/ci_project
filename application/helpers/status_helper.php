
   <?php
   function openUniversityStatus()
    {
		$appId = $_POST['id'];
		//echo $appId;die;
		$CI =& get_instance();
		$user_data = $CI->session->userdata('user_data');
		$universityId = $user_data['university'];
		$userType = $user_data['user_type'];
		//print_r($userType);die;
		$applicanteDetails = $CI->mission_model->getApplicantDetails($appId);
	
		$applicaitonStepOne = $CI->common_model->getApplicationStepOneByAppno($applicanteDetails[0]['application_no']);
			//echo "<pre>";print_r($applicaitonStepOne);die;
		$flag = false;
		if(isset($universityId) && !empty($universityId)){
			$flag = true;
		}
		//echo $flag; 
		//echo $universityId;die;
		$applicaitonsStatus = $CI->common_model->getCommonApplicationStatus($appId,$universityId,$flag);
		
		//echo '<pre>';
		//print_r($applicaitonsStatus);die;
			?>
<div class = "table-responsive">
						<table class="table">
						<thead>
							<th>S.No.</th>
							<th>Status</th>	
							<!----<th>Alerts</th>	--->
							<!-----<th>Reasons</th>--->	
							
                            <!------<th>Visa</th>							
							<th>Travel Details</th>------>	
						</thead>
						
						<?php 
							if($userType == 8)
							{
								?>
								
												<tbody>	
							<?php 
							if(sizeof($applicaitonsStatus)>0)
							{
								//echo "<pre>";print_r($applicaitonsStatus);die;
							?>
							<tr>
								<td>1</td>
								<td>
								
								<?php
								

								$unStatus = $CI->config->item('universities_status_master');
									//echo "<pre>";echo $applicaitonsStatus[0]['ResumitStatus'];die;
								if($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 5 && $applicaitonsStatus[0]['universities_status'] == -1)
								{
									
									
									
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 5 && $applicaitonsStatus[0]['universities_status'] == -1)
								{
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 2 && $applicaitonsStatus[0]['universities_status'] == -1)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 5 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 2 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 5 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 2 && $applicaitonsStatus[0]['universities_status'] == -1)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 3)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 5 && $applicaitonsStatus[0]['universities_status'] == -1)
								{
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 2 && $applicaitonsStatus[0]['universities_status'] == -1)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 7 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
								elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 11 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
									elseif($universityId == $applicaitonsStatus[0]['regional_university'] && $applicaitonsStatus[0]['ResumitStatus'] == 9 && $applicaitonsStatus[0]['universities_status'] == -1)
								{
									
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning"><?php echo $unStatus[$applicaitonsStatus[0]['ResumitStatus']];?>
									
									</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == -3)
								{
									echo 'Your Application is not processed due to these <a href="javascript:void(0);" data-toggle="modal" data-target="#reasons">Reasons</a>';
								}
								elseif($applicaitonsStatus[0]['status'] == 10 && $applicaitonsStatus[0]['universities_status'] == 1 && (isset($applicaitonsStatus[0]['university_is_accept']) ? $applicaitonsStatus[0]['university_is_accept'] : 0) == 2)
								{
									?>
									<span class="label label-primary">Rejected</span>
									
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == 5 || $applicaitonsStatus[0]['universities_status'] == 5)
								{
									?>
								
									<span class="label label-warning">Please Re-submit Again</span>
									<?php
								}
								
								//University missing documents status
								
								
								elseif($applicaitonsStatus[0]['status'] == 3 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									?>
								
									<span class="label label-warning">Application on hold by university</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == 6 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									?>
								
									<span class="label label-warning">Application returned by university for re-submission by applicant</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == 10 && $applicaitonsStatus[0]['universities_status'] == 2)
								{
									?>
								
									<span class="label label-warning">Admission rejected by university</span>
									<?php
								}
								
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['scholarship_id'] != NULL && $applicaitonsStatus[0]['undertaking_doc'] == NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Scholarship awarded.Student to provide acceptance to offer and approach Indian Mission.</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['scholarship_id'] == NULL && $applicaitonsStatus[0]['status'] == 10)
								{
									
									?>
								
									
									<span class="label label-primary">Admission confirmed by university. Scholarship under consideration by Mission</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['undertaking_doc'] == 1 && $applicaitonsStatus[0]['visa_no'] == NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Student accepted the offer</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] = 1 && $applicaitonsStatus[0]['visa_no'] != NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Under process for grant of Visa</span>
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
												<div class="box-header"><b>Resubmit your application before date:  <?php echo $CI->config->item('Mission_Applicant_Pending_Date'); ?></b></div>
									              <div class="box-body">    
									              		<ul class="list-group">
									              	<?php
									              		$reasons = $CI->common_model->getResons($applicaitonsStatus[0]['application_no']);
									              		$resonsArray = !empty($reasons) ? explode(',',$reasons[0]['checklist_ids']) : array();
									              	
									              		$counter = 1;
									              		if(sizeof($resonsArray) > 0)
									              		{
															foreach($resonsArray as $res)
															{
																$item = $CI->common_model->getChecklistItemById($res);
																echo '<li class="list-group-item">'.(!empty($item) ? $item[0]['item'] : '') .'</li>';
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
								
								<?php
							}
							
							
							else
							{
								?>
								
											<tbody>	
							<?php 
							if(sizeof($applicaitonsStatus)>0)
							{
								//echo "<pre>";print_r($applicaitonsStatus);die;
							?>
							<tr>
								<td>1</td>
								<td>
								<?php
								//echo "------------------";die;
								//echo $applicaitonsStatus[0]['application_no'];die;
									$applicaitonsResubmitStatus = $CI->common_model->getCommonApplicationStatus($applicaitonsStatus[0]['application_no'],$universityId,$flag);
								  //echo "<pre>";print_r($applicaitonsResubmitStatus);die;
								
								if(!empty($applicaitonsResubmitStatus) || $applicaitonsResubmitStatus[0]['ResumitStatus'] == 5 || $applicaitonsResubmitStatus[1]['ResumitStatus'] == 5 || $applicaitonsResubmitStatus[2]['ResumitStatus'] == 5 || $applicaitonsResubmitStatus[3]['ResumitStatus'] == 5 || $applicaitonsResubmitStatus[4]['ResumitStatus'] == 5){
									//echo $applicaitonsResubmitStatus[0]['universty_choice'];die;
								//$universityName = $this->common_model->getUniversityCourseData($applicaitonsResubmitStatus[0]['universty_choice']);
								//echo "<pre>";print_r($applicaitonsResubmitStatus);die;
									?>
									<div class = "table-responsive">
									<table class="table">
									<thead>
										<th>S.No</th>
										<th>University name</th>
										<th>Status</th>
									</thead>
									<tbody>	
									<?php 
									$counter=1;
									//echo "<pre>";print_r($applicaitonsResubmitStatus);die;
									for($i = 0;$i<=4;$i++){
										$universityName = $CI->common_model->getUniversityCourseData($applicaitonsResubmitStatus[$i]['regional_university']);
									 ?>
									<tr>
									<td><?php echo $counter; ?></td>
									<td><?php echo !empty($universityName) ? $universityName[0]['name'] : 'NA'; ?></td>
									<td>
									
										<?php  
										//echo "------------";die;
										//echo $applicaitonsResubmitStatus[$i]['ResumitStatus'];
											if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 5)
								{
									?>
									
									
									<span class="label label-warning">Application returned by university for re-submission by applicant</span>
									<?php
								}
								
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 2)
								{
									?>
									
									
									<span class="label label-warning">Submited</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 6)
								{
									?>
									
									
									<span class="label label-warning">Admission confirmed by university.Scholarship under consideration by Mission</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 7)
								{
									?>
									
									
									<span class="label label-warning">Rejected by university</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 11)
								{
									?>
									
									
									<span class="label label-warning">Application under consideration Mission for award of scholarship</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 9)
								{
									?>
									
									
									<span class="label label-warning">Re-submited by applicant</span>
									<?php
								}
										
										?>
									</td>
									</tr>
									<?php
									$counter++;
									} 
									
									?>
										
									</tbody>
									</table>
									</div>
									<?php
									
									
								}
								
								
								
								elseif($applicaitonsStatus[0]['status'] == -3)
								{
									echo 'Your Application is not processed due to these <a href="javascript:void(0);" data-toggle="modal" data-target="#reasons">Reasons</a>';
								}
								elseif($applicaitonsStatus[0]['status'] == 10 && $applicaitonsStatus[0]['universities_status'] == 1 && (isset($applicaitonsStatus[0]['university_is_accept']) ? $applicaitonsStatus[0]['university_is_accept'] : 0) == 2)
								{
									?>
									<span class="label label-primary">Rejected by University</span>
									
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == 5 || $applicaitonsStatus[0]['universities_status'] == 5)
								{
									?>
								
									<span class="label label-warning">Please Re-submit Again</span>
									<?php
								}
								
								//University missing documents status
								
								
								elseif($applicaitonsStatus[0]['status'] == 3 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									?>
								
									<span class="label label-warning">Application on hold by university</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == 6 && $applicaitonsStatus[0]['universities_status'] == 1)
								{
									?>
								
									<span class="label label-warning">Application returned by university for re-submission by applicant</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == 10 && $applicaitonsStatus[0]['universities_status'] == 2)
								{
									?>
								
									<span class="label label-warning">Admission rejected by university</span>
									<?php
								}
								
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['scholarship_id'] != NULL && $applicaitonsStatus[0]['undertaking_doc'] == NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Scholarship awarded.Student to provide acceptance to offer and approach Indian Mission.</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['scholarship_id'] == NULL && $applicaitonsStatus[0]['status'] == 10)
								{
									
									?>
								
									
									<span class="label label-primary">Admission confirmed by university. Scholarship under consideration by Mission</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['undertaking_doc'] == 1 && $applicaitonsStatus[0]['visa_no'] == NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Student accepted the offer</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] = 1 && $applicaitonsStatus[0]['visa_no'] != NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Under process for grant of Visa</span>
									<?php
								}
								 
								?>
								</td>
							
								
								
									<!-----<td>
								<?php 
								//echo "<pre>";print_r($applicaitonsStatus);
								if($applicaitonsStatus[0]['visa_no'] == '')
								{
									?>
									<!----<span class="label label-warning">Pending at applicant</span>
									<span class="label label-warning">Not Uploaded</span>
									<?php
								}
									else
								{
									?>
									<span class="label label-info">Uploaded</span>
									<?php
								}
								?>
								</td>----->
								
								<td>
								<?php 
								$travel = $CI->common_model->getTravelData($applicaitonsStatus[0]['application_no']);
								//echo "<pre>";print_r($travel);
									if((!empty($travel) ? $travel[0]['travel_plan_doc'] : '') == '')
								{
									?>
									<!------<span class="label label-warning">Pending at applicant</span>
									<span class="label label-warning">Not Uploaded</span>
									<?php
								}
									else
								{
									?>
									<a href="<?php echo site_url();?>assets/site/main/travelplan/<?php echo !empty($travel) ? $travel[0]['travel_plan_doc'] : '';?>" target = "_blank"><span class = "label label-success">Download</span></a>
									
									<?php
								}
								?>
								</td>---->
							
								<div id="reasons" class="modal fade" role="dialog">
  									<div class="modal-dialog popup">
  									<section class="content">
									      <!-- Small boxes (Stat box) -->
									      <div class="row">
									      	<div class="col-xs-12">
									    	<div class="box">
												<div class="box-header"><b>Resubmit your application before date:  <?php echo $CI->config->item('Mission_Applicant_Pending_Date'); ?></b></div>
									              <div class="box-body">    
									              		<ul class="list-group">
									              	<?php
									              		$reasons = $CI->common_model->getResons($applicaitonsStatus[0]['application_no']);
									              		$resonsArray = !empty($reasons) ? explode(',',$reasons[0]['checklist_ids']) : array();
									              	
									              		$counter = 1;
									              		if(sizeof($resonsArray) > 0)
									              		{
															foreach($resonsArray as $res)
															{
																$item = $CI->common_model->getChecklistItemById($res);
																echo '<li class="list-group-item">'.(!empty($item) ? $item[0]['item'] : '') .'</li>';
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
								
								<?php
							}
						?>
						
						
						
			
					</table>
							</div>
  <?php	
	}
	
	
	
	function confirmationReceivedWithNewFormat()
	{
		try
		{
			$doc = array();
			$CI =& get_instance();
			$applicationId = $CI->uri->segment(3);
			$uniid = $CI->uri->segment(4);
			$response = $CI->common_model->getconfirmationDataByMission($applicationId);
			$course = $response[0]['confirmed_course'];
			
			
			$current = date('d-m-Y');
			//$fy[1] = '2021-2022';
			$fy = $CI->getFinancialYears($current,1);
			$user_data = $CI->session->userdata('user_data');
			$userId = $user_data['userid'];			
			$stepOne = $CI->common_model->getApplicationStepOneByAppno($applicationId);
			
			$studentOther = $CI->common_model->getStudentOtherDetails($applicationId);
			$missionDetails = $CI->common_model->getMissionDetails($applicationId);
			$missionPersonName = $missionDetails[0]['mission_person_name'];
			
			$missionDate = $missionDetails[0]['mission_status_date'];
			
			$imgPath = site_url().'assets/site/main/mission_signature/'.$missionDetails[0]['mission_person_signature'];
			
			$new='<img src="'.$imgPath.'" style="width:100px;">';
			

			$mission = $CI->common_model->getMissionInfo($studentOther[0]['application_through']);

			$country = $CI->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $CI->common_model->getMappingData($applicationId);
			$schemename = $CI->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$regionInfo = $CI->common_model->getRegionById($region);
						
			$uninmae = $CI->common_model->getUniversityStateById($uniid);
			$CI->load->file('fpdi/PdfHTMLTable.php');
			
			
			$pdf = new PdfHTMLTable();
			$pdf->AddPage('P');
			$pdf->SetXY(10.0,5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial','',7);
			$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
			$pdf->MultiCell(180,5,'Date: '.$missionDate,'','R');
			
			$pdf->SetXY(10.0,45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations',false);		
			$pdf->SetFont('Arial','',10);	
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',35);
			$pdf->SetTextColor(221,221,255);
			$pdf->RotatedText(35,190,'Indian Council For Cultural Relations',45);
			$pdf->SetFont('Arial','',10);	
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(180,5,$mission[0]['mission_type'].': '.$mission[0]['mission_name'],'','R');
			
			$pdf->MultiCell(180,5,$mission[0]['country_name'],'','R');
			$getYear = date_format(date_create($schemeId[0]['mission_status_date']),'Y');
			$dataYear = "";
			   if($getYear=='2022'){
				 $dataYear = "2022-23";  
			   }
			   else{
			   $dataYear = "2021-22"; 
			   }
			$pdf->MultiCell(180,5,'Subject:- Offer of Provisional admission with award of ICCR Scholarship for A.Y '.$dataYear.'','','J');
		    $pdf->Ln(5);
					
			$pdf->MultiCell(180,5, 'Dear     :	Mr./Ms. '.$stepOne[0]['fullname'].' '.$stepOne[0]['middlename'].' '.$stepOne[0]['familyname'].'','L');
			
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'1)  We are pleased to inform you that you have been provisionally selected to pursue Course '.$course.' at under '.$uninmae[0]['name'].' '.$schemename[0]['scheme_name'].'  ('.$schemename[0]['code'].') for the Academic Year '.$dataYear.'. You are requested to report '.$regionInfo[0]['name']. ' Regional Office along with all original certificate and testimonials latest by '   .$response[0]['timeline'] ,'','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'2)  Hostel accommodation will be provided to you subject to its availability by University authorities. You are required to report at the nearest “Foreign Regional Registration Office” within fourteen days of arrival in India.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'3)  You are advised to contact the Education Wing of this Mission immediately along with your passport for grant of visa and finalization of your date of departure. You are also hereby directed to obtain your final departure letter from the Mission before joining the concerned Institution in India failing which this offer letter stands cancelled. Furthermore no request of change of course and University will be entertained.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'4)  You are advised to carry with you joining report form and a Minimum of INR 50,000/- equivalent to 700 $) to meet incidental expenses on arrival in India.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'5)  Please complete all pre-departure formalities such as preparation of passport  and getting the student/research visa.','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'6)	Please carry original documents for confirming the provisional admission at the time of reporting at University. Please note that admission is granted provisionally and needs to be confirmed on the basis of submission of original documents at the time of first reporting at the University. In case of discrepancies in documentation, University reserves the right to cancel provisional admission offered to student. ICCR/Mission will not be responsible for cancellation of provisional admission on the above grounds and will not be liable to pay scholarship or expenses  incurred on return air-tickets by the student.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'NOTE :- ) Due to ongoing Covid-19 Pandemic, students will take up online classes and once the situation is better students will be invited to India as and when University allows to report and join physical classes. For any update, please be in touch with University and Mission.','','J');		
			$pdf->Ln(5);
			
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(5);
			
			
			$pdf->MultiCell(170,5,'Yours Sincerely','','R');
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,$missionPersonName,'','R');
			$pdf->Ln(5);
			//$pdf->Image($imgPath,145,250,60,30,'png','');
			//$pdf->Ln(5);
			$filename = $applicationId."_University_Response_".date('jS-F-Y-h-i-s').'.pdf';
			
			$filenamePath = FCPATH."assets/site/main/accept/".$filename;
			//$pdf->debug = true;
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
			$CI =& get_instance();
			$applicationId = $CI->uri->segment(3);
			//echo $applicationId;die;
			$user_data = $CI->session->userdata('user_data');
			$userId = $user_data['userid'];	
			//echo $userId;die;
			//$applicationId = $this->common_model->getApplicationAppnoByUserId($userId);	
			//echo "<pre>";print_r($applicationId);die;
			//$applicationId =  $applicationId[0]['application_no'];
			
			$stepOne = $CI->common_model->getApplicationStepOneByAppno($applicationId);		
			$country = $CI->common_model->getCountryById($stepOne[0]['country']);
			$schemeId = $CI->common_model->getMappingData($applicationId);
			$response = $CI->common_model->getconfirmationDataByMission($applicationId);
			//echo "<pre>";print_r($response);die;
			$applicaitonStepThree = $CI->common_model->getApplicationStepThreebyAppNo($applicationId);
			$userd = $CI->common_model->getUserInfo($applicaitonStepThree[0]['uid']); 
			$applicantAcceptanceDate = $schemeId[0]['undertaking_doc'];
			$date1 = $applicaitonSubmitData[0]['created'];						
			$acDate =  date('d-m-Y',$applicantAcceptanceDate);
			if($userd->dir == ''){
				$imgPath = site_url().'assets/site/main/profile_signature/'.$applicaitonStepThree[0]['signature_doc'];
			}else{
				$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			}
			//$imgPath = site_url().$userd->dir.'/'.$applicaitonStepThree[0]['signature_doc'];
			$new='<img src="'.$imgPath.'" style="width:100px;">';
			//echo "<pre>";print_r($imgPath);die;
			$uni1 = $CI->common_model->getUniversityById($response[0]['regional_university']);
			//echo $uni1[0]['name'];
			$course = $response[0]['confirmed_course'];
			//echo $course;die;
			$schemename = $CI->common_model->getSchemeById($schemeId[0]['scholarship_id']);
			$CI->load->file('fpdi/PdfHTMLTable.php');
			$pdf = new PdfHTMLTable();	
			$pdf->AddPage('P');
			$pdf->SetXY(10.0,5.0);
			$pdf->SetDisplayMode('fullwidth');
			$pdf->SetLeftMargin(15.0);
			$pdf->SetFont('Arial','',7);
			$pdf->MultiCell(180,5,'Ref. No.'.$applicationId,'','R');
			$pdf->MultiCell(180,5,'Date: '.$acDate,'','R');
			
			
			
			$pdf->SetXY(10.0,45.0);
			$pdf->SetTitle('Indian Council For Cultural Relations',false);		
			$pdf->SetFont('Arial','',10);	
			$pdf->Ln(5);
			
			
			$pdf->MultiCell(250,10,'ACCEPTANCE TO OFFER OF ADMISSION WITH ICCR SCHOLARSHIP','','L');
			$pdf->Ln(5);
			
			//$pdf->MultiCell(180,5,'Name of Scholarship Scheme : '.$schemename[0]['scheme_name'],'','L');
			$pdf->MultiCell(180,5,'Acceptance of  '.$stepOne[0]['fullname'].' '.$stepOne[0]['middlename'].' '.$stepOne[0]['familyname']. ' to offer of admission at  ' . $uni1[0]['name'] . ' to pursue course  ' .$course ,'','L');
			$pdf->Ln(5);
		
			$pdf->MultiCell(180,5,'1. I Mr./Ms. '.$stepOne[0]['fullname'].' '.$stepOne[0]['middlename'].' '.$stepOne[0]['familyname'].' do hereby affirm that I have read the Terms and Conditions including Financial Terms of ICCR’s scholarship with due diligence and agree to abide by them.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'2. I also confirm that the course '.$course.' offered to me in '.$uni1[0]['name'].' is accepted to me and that I will not ask for a change in course or university.','','J');
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'3. I will complete the entire course of study in which I have been admitted.','','J');		
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'4. I will purchase medical insurance of minimum sum assured of INR (Rs.) 5 lakhs / equivalent to approximate US$ 6700) per year. I understand that it is compulsory for continuation of ICCR Scholarship.','','J');	
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'5. I certify that I do not suffer from terminal illness or ailments affecting vital organs. I also certify that I am not in family way. In case of illness require long absence of my course of study, I undertake to return to my country.','','J');						
			
			
			$pdf->Ln(5);
			$pdf->MultiCell(180,5,'6. I agree to deliberately study in India.  In case I fail to get promoted to next level of course / fail, I understand that ICCR will stop scholarship. If such situation arises, I undertake that I will clear the level of study in which I have failed with my own financial resources and once I clear the level, I will request for revival of scholarship. ','','J');		
			$pdf->Ln(5);

            $pdf->Ln(5);
			$pdf->MultiCell(180,5,'7. I agree to abide by and respect the law of India.  In case if I get involved in illegal activities and /or events concerning law and order issues, I understand that I will be prosecuted as per the law of India and I also agree on being deported to my country ','','J');		
			$pdf->Ln(5);

            
			$pdf->MultiCell(180,5,'8. I understand that ICCR has right to change its Scholarship Policy (ies) including financial terms of scholarship from time to time.  I agree to abide by them.  If I disagree to follow the revised terms and conditions, ICCR will have right to discontinue my scholarship. ','','J');		
			$pdf->Ln(10);
			
			$explode = explode('.',$applicaitonStepThree[0]['signature_doc']);
			//echo "<pre>";print_r($explode);die;
			if($explode[1] == 'png')
			{
				$pdf->Image($imgPath,20,210,35,24,'png','');
			}
			elseif($explode[1] == 'PNG')
			{
				$pdf->Image($imgPath,20,210,35,24,'PNG','');
			}
			elseif($explode[1] == 'jpeg')
			{
				$pdf->Image($imgPath,20,210,35,24,'jpeg','');
			}
			elseif($explode[1] == 'JPEG')
			{
				$pdf->Image($imgPath,20,210,35,24,'JPEG','');
			}
			elseif($explode[1] == 'jpg')
			{
				$pdf->Image($imgPath,20,210,35,24,'jpg','');
			}
			elseif($explode[1] == 'JPG')
			{
				$pdf->Image($imgPath,20,210,35,24,'JPG','');
			}
			
			//$pdf->Image($imgPath,20,210,35,24,'jpeg','');
			$pdf->Ln(20);
			//$pdf->MultiCell(170,5,'Signature   : '.$new,'','L');	
			//$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Name        : '.$stepOne[0]['fullname'].' '.$stepOne[0]['middlename'].' '.$stepOne[0]['familyname'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Country     : '.$country[0]['country_name'],'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Date          : '.$acDate,'','L');
			$pdf->Ln(5);
			$pdf->MultiCell(170,5,'Passport No : '.$stepOne[0]['passport_no'],'','L');	


			
			$filename = $applicationId."_UnderTaking_".date('jS-F-Y-h-i-s').'.pdf';
			$filenamePath = "assets/site/main/undertakings/".$filename;
			$pdf->Output($filename,"D");
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Some Internal Error Occured While Uploading Application!');
			redirect(site_url().'mission/dashboard');
		}
		
	}
	
	function openHqrsStatus(){
		
		?>
			<table  class="customTable1 table table-striped table-bordered detailpagepdf newApplication ">
			<thead>
				<!----<th>Application No</th>
				<th>Applicant Name</th>				
				<th>Country</th>--->
				<th>University</th>	
				<th>Course</th>	
				<th>University Letter</th>
				<th>ICCR Letter</th>
				<th>Acceptance</th>
			   <th>Acceptance/decline Date</th>
			</thead>
				<tbody>
					
					<?php 
					$appId = $_POST['id'];
					$CI =& get_instance();
					$university = $CI->common_model->getconfirmationDataByMission($appId);
						  //echo "<pre>";print_r($university);
						  //echo "<pre>";print_r($mappingData);
					//$applicaitonStepOne = $CI->common_model->getApplicationStepOneByAppno($appId);
						  $count = sizeof($university);
						 if($count>0)
						{
							for($i = 0;$i<$count;$i++){
								//echo $i.'<br/>';
								//echo $university[$i]['application_id'].'<br/>'; ?>
								<tr>
								<!----<td><?php $r['application_no'];?>	</td>
                               <td> <?php $r['fullname'].$r['middlename'].$r['familyname']; ?></td>
                               <td> <?php $r['email'];?> </td>
                               <td> <?php $r['country_name'];	?></td>--->
						<td><?php  $universityData = $CI->common_model->getUniversityById($university[$i]['regional_university']);
							 echo $universityData[0]['name'];?></td>
						<td><?php  echo $CI->common_model->getCourseName($university[$i]['application_id'],$university[$i]['regional_university']);?></td>
						
						
						<td>
                                <?php
                             
							   $mappingData = $CI->common_model->getMappingData($appId);
							   // echo "<pre>";print_r($mappingData);
							  $response = $CI->common_model->getconfirmationDataByMission($mappingData[0]['application_no']);
                                   if($mappingData[0]['mission_status'] == 1) {
									   ?>
                                        <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $university[$i]['region_one_doc']; ?>" target="_blank"><span class = "label label-success">Download</span></a>
										<?php
                                    }
									
                                
                               
                                ?>

                            </td>
						
						<td>
                                <?php
                              //echo "<pre>";print_r($mappingData);
                                   if($mappingData[0]['mission_status'] == 1) {
                                        if ($university[$i]['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>applicant/confirmationReceivedWithFormat/<?php echo $university[$i]['application_id']; ?>/<?php echo $university[$i]['regional_university']; ?>" target="_blank"><span class = "label label-success">Download</span></a>

                                            <?php
                                        }
                                    }
									else
									{
										echo "NA";
									}
                                
                               
                                ?>

                            </td>
							<td>
                                <?php
                              //echo "<pre>";print_r($university[$i]);die;
                                   if($mappingData[0]['mission_status'] == 1) {
                                        if ($university[$i]['university_is_accept'] == 1 && ($mappingData[0]['scholar_acceptance'] == 1)) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>headquarter/undertakingFromStudent/<?php echo $university[$i]['application_id']; ?>/<?php echo $university[$i]['regional_university']; ?>" target="_blank"><span class = "label label-success">Download</span></a>

                                            <?php
                                        }
										 
										else
										{
											echo "Decline";
										}
                                    }
									else
									{
										echo "NA";
									}
                                
                               
                                ?>

                            </td>
							
							<td><?php 
							if(!empty($mappingData[0]['undertaking_doc'])){
							$date2 = $mappingData[0]['undertaking_doc'];	
							echo  date('d-m-Y',$date2);
							}
							else
							{
								echo "NA";
							}
							?> 
							
							</td>
						</tr>
							<?php }
						}
					
						
						?>
					</tbody>
		</table>
		
		<?php
	}
	
	
	function fileForceDownload($file_name){

		/*
		 * SECURITY: every controller's downloadDocs() passes a caller-supplied,
		 * base64url-encoded path straight into this function. Without a check the
		 * path can point anywhere on the server (application/config/database.php,
		 * for example), which is an arbitrary file read. Confine the download to
		 * files that actually live inside the web root and are not executable
		 * source files. Legitimate document paths (year folders, assets/, and the
		 * applicant upload directories) are all inside FCPATH, so nothing that
		 * used to work stops working.
		 */
		$resolved = @realpath($file_name);
		if ($resolved === false) {
			return;
		}
		$root = @realpath(defined('FCPATH') ? FCPATH : '.');
		if ($root === false) {
			return;
		}
		$root = rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
		if (strncasecmp($resolved, $root, strlen($root)) !== 0) {
			return; // outside the web root - refuse
		}
		$blockedExtensions = array('php', 'php3', 'php4', 'php5', 'php7', 'phtml', 'phps', 'inc', 'htaccess', 'ini', 'env', 'sql');
		$extension = strtolower(pathinfo($resolved, PATHINFO_EXTENSION));
		if (in_array($extension, $blockedExtensions, true)) {
			return; // never hand out source/config files
		}
		$file_name = $resolved;

		if(is_file($file_name)) {
			/*
				Do any processing you'd like here:
				1.  Increment a counter
				2.  Do something with the DB
				3.  Check user permissions
				4.  Anything you want!
			*/

			// required for IE
			if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

			// get the file mime type using the file extension
			switch(strtolower(substr(strrchr($file_name, '.'), 1))) {
				case 'pdf': $mime = 'application/pdf'; break;
				case 'zip': $mime = 'application/zip'; break;
				case 'jpeg':
				case 'jpg': $mime = 'image/jpg'; break;
				default: $mime = 'application/force-download';
			}

			header('Pragma: public'); 	// required
			header('Expires: 0');		// no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$mime);
			header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
			//header('Content-Disposition: inline; filename="'.basename($file_name).'"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($file_name));	// provide file size
			header('Connection: close');
			readfile($file_name);		// push it out
			exit();
		}
	}
	
	function base64url_encode($data){
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data){
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}



function getCountUniversityApplications($universityId= null) {
		$CI =& get_instance();
        $CI->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $CI->db->from('iccr_status_mapping');
		$CI->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$CI->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
		$CI->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $CI->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$CI->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.status!=' => 3,'iccr_status_mapping.iccr_status' => -1, 'iccr_status_mapping.region_one_status' => -1, 'iccr_status_mapping.region_two_status' => -1, 'iccr_status_mapping.region_three_status' => -1,'iccr_status_mapping.region_four_status' => -1, 'iccr_status_mapping.region_five_status' => -1));
		if($universityId){
		$CI->db->where(' (iccr_student_application_details.universty_choice=' . $universityId . ' or iccr_student_application_details.universty_choice_two=' . $universityId . ' or iccr_student_application_details.universty_choice_three=' . $universityId . ' or iccr_student_application_details.universty_choice_fourth=' . $universityId . ' or iccr_student_application_details.universty_choice_fifth=' . $universityId . ')');
		}
		$CI->db->where(array('iccr_status_mapping.created >='=> 1644471556));
		 //$this->db->where('iccr_status_mapping.created' >='1615749687');
		$CI->db->where(array('iccr_student_details.apply_course_type !=' => 11));
		//echo $this->db->_compile_select();die;
        $code = $CI->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $CI->db->count_all_results();
        return $countRowQuery;
    }
	
	
	function countgetUniversityProcessedApplications($universityId) {
		$CI =& get_instance();
        $CI->db->select('iccr_status_mapping.id');
        $CI->db->from('iccr_status_mapping');
        $CI->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$CI->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $CI->db->where('iccr_university_response.regional_university', $universityId);
	    $CI->db->where('iccr_university_response.university_is_accept', 1);
		//$this->db->where_in('iccr_status_mapping.universities_status', array(22, 18));
		$CI->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		$CI->db->where(array('iccr_status_mapping.created >='=> 1644471556));
		//echo $this->db->_compile_select();exit;
        $code = $CI->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $CI->db->count_all_results();
		 return $countRowQuery;
	 }
	 
	 
	  function countgetUniversityRejectedApplications($universityId) {
		$CI =& get_instance();
        $CI->db->select('iccr_status_mapping.id');
        $CI->db->from('iccr_status_mapping');
        $CI->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
        //$this->db->where_in('iccr_status_mapping.status', array(4, 5));
		$CI->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
        $CI->db->where('iccr_university_response.regional_university', $universityId);
		$CI->db->where('iccr_university_response.university_is_accept', 2);
		//$this->db->where_in('iccr_status_mapping.universities_status', array(22, 18));
		$CI->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18, 'iccr_status_mapping.universities_status' => 1));
		//echo $this->db->_compile_select();exit;
		$CI->db->where(array('iccr_status_mapping.created >='=> 1644471556));
        $code = $CI->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $CI->db->count_all_results();
		 return $countRowQuery;
	 }
	 
	 
	 function getCountUniversityAcceptance($universityId= null) {
		$CI =& get_instance();
        $CI->db->select('count(iccr_status_mapping.id) as newCountApplication');
        $CI->db->from('iccr_status_mapping');
		$CI->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
		$CI->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through');
		$CI->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_status_mapping.uid');
        $CI->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
		$CI->db->join('iccr_university_response', ' iccr_university_response.application_id = iccr_status_mapping.application_no');
		$CI->db->where('iccr_university_response.regional_university', $universityId);
		$CI->db->where(array('iccr_university_response.confirmed_to_mission =' =>1));
		$CI->db->where(array('iccr_status_mapping.status>=' => 1,'iccr_status_mapping.universities_status!=' => 18,'iccr_status_mapping.scholar_acceptance'=>1));
		$CI->db->where(array('iccr_status_mapping.created >='=> 1644471556));
		 //$this->db->where('iccr_status_mapping.created' >='1615749687');
		$CI->db->where(array('iccr_student_details.apply_course_type !=' => 11));
		//echo $this->db->_compile_select();die;
        $code = $CI->db->error();
        if ($code['code'] > 0) {
            //show_error('Message');
        }
        $countRowQuery = $CI->db->count_all_results();
        return $countRowQuery;
    }
	
	
	if (!function_exists('history_monitoring'))
{
    function history_monitoring($user_data,$module)
    {
			$ci =& get_instance();
			$ci->load->database();
			$uri= $_SERVER['HTTP_USER_AGENT']; 
			$ip_address=$ci->input->ip_address();
			$created = date('Y/m/d h:i:s');
			$data = array('user_id' => $user_data['userid'],'first_name' => $user_data['fname'],'when'=>$created,'ip_address'=>$ip_address,'action'=>$module,'uri'=>$uri,'user_type'=>$user_data['user_type']);
			$q = $ci->db->insert_string('iccr_login_history',$data);
			$ci->db->query($q);
			return true;
    }
}
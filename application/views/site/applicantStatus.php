<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 10px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
</style>
<style type="text/css">
.tweaked-margin{margin-right:5px !important;}
.list-group {
	list-style: decimal inside;
}

.list-group-item {
	display: list-item;
}
</style>

<?php
	    	if($this->session->flashdata('message_type') == "success")
	    	{
			?>
			<div class="alert alert-success" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
			</div>
			<?php	
			}
			if($this->session->flashdata('message_type') == "error")
	    	{
			?>
			<div class="alert alert-error" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>
			</div>
			<?php	
			}
	    	
	    	?>	
	<!-----<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Indian Concuil For Cultural Relations</h3>
		<h4 class="text-center caps">Application Status</h4>
	</div>------->
	
	<div  class="container pdleft pdright">
		<div class="tab-contents-sec">
	  <div id="step3" class="tab-pane fade in active">	 
	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <div class="box-body">
              	<div class="panel with-nav-tabs panel-default application-tabs mttop">
					<div class="panel-heading">
						<!-- START OF YOUR CODE -->
						<ul class="nav nav-tabs" id="lb-tabs">
						<?php 
						// I just made an array with some data, since I don't have your data source
							$sqlCat =   array(
											array('tab_title'=>'Dashboard','tab_id'=>'dashboard','tab_value'=>'1'),
											array('tab_title'=>'Status','tab_id'=>'chks_status'),
											
											array('tab_title'=>'Undertaking','tab_id'=>'undertaking','tab_value'=>'2'),
											
											array('tab_title'=>'Visa','tab_id'=>'visa','tab_value'=>'3'),
											array('tab_title'=>'Travel', 'tab_id'=>'travel','tab_value'=>'4'),
											
										   
										);
						

							//set the current tab to be the first one in the list.... or whatever one you specify
							$current_tab = $sqlCat[0]['tab_title'];
						?>
						<?php 
						foreach ($sqlCat as $row):
							//set the class to "active" for the active tab.
							
							$user_data = $this->session->userdata('user_data');
			                $userId = $user_data['userid'];	
							if($user_data['apply_course_type'] == 11)
							{
								
								$tab_class = ($row['tab_title']==$current_tab) ? 'active' : '' ;
							echo '<li class="'.$tab_class.'"><a href="#' . urlencode($row['tab_title']) .  '" data-toggle="tab" onclick = openUndertakingSfs("'.$row['tab_value'].'","'.$applicaitonsStatus[0]['application_no'].'"); id = "'.$row['tab_id'].'" value = "'.$row['tab_value'].'">' .           
							$row['tab_title'] .  ' </a></li>';
							}
						else
						{
							
							$tab_class = ($row['tab_title']==$current_tab) ? 'active' : '' ;
							echo '<li class="'.$tab_class.'"><a href="#' . urlencode($row['tab_title']) .  '" data-toggle="tab" onclick = openUndertaking("'.$row['tab_value'].'","'.$applicaitonsStatus[0]['application_no'].'"); id = "'.$row['tab_id'].'" value = "'.$row['tab_value'].'">' .           
							$row['tab_title'] .  ' </a></li>';
						}
							
							
							
						endforeach;
						?>
						</ul><!-- /nav-tabs -->
					</div>
								<div class="tab-content">
	
        <?php foreach ($sqlCat as $row2): 
        $tab = $row2['tab_title'];
        //set the class to "active" for the active content.
        $content_class = ($tab==$current_tab) ? 'active' : '' ;
        ?>
        <div class="tab-pane <?php echo $content_class;?>" id="<?php echo $tab; //--  this right here is from yoru code, but there was no "echo" ?>">
            <div class="links">
                <ul class="col">
                    <?php  
                    // Again, I just made an array with some data, since I don't have your data source
                    $items = array(
                                array('title'=>'Status','tab_link'=>'<a href="'.site_url().'applicant/applicantStatus/'. $this->uri->segment(3).'"></a>'),
                                array('title'=>'Undertaking','tab_link'=>'<a href="'.site_url().'applicant/processConfirmedappfromhqrs/'. $this->uri->segment(3).'"></a>'),
								array('title'=>'Visa','tab_link'=>'http://messages.com'),
                                array('title'=>'Travel','tab_link'=>'http://messages.com'),
                                array('title'=>'Remarks','tab_link'=>'http://settings.com')
                            );
					//echo "<pre>";print_r($items);die;
                    // you have a while loop here, my array doesn't have a "fetch" method, so I use a foreach loop here        
                    
              //output the links with the title that matches this content's tab.
              if($items[0]['title'] == $tab){
                            //echo '<li>' . $item['title'] . ' - '. $item['tab_link'] .'</li>';
							
							?>
							<div class = "table-responsive">
						<table class="table">
						<thead>
							
							<th>Application Number</th>
							<!----<th>Country</th>
							<th>Name</th>
							<th>Email Id</th>
							<th>Mobile</th>	----->
							<th>Status</th>	
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
							
								<td><?php echo $applicaitonsStatus[0]['application_no'];?></td>
								<!----<td><?php $ch = $this->common_model->getCountryById($applicaitonsStatus[0]['nationality']); echo $ch[0]['country_name'];?></td>
								<td><?php echo $applicaitonsStatus[0]['fullname'];?></td>
								<td><?php echo $applicaitonsStatus[0]['email'];?></td>
								<td><?php echo $applicaitonsStatus[0]['phone'];?></td>--->
								<td>
								<?php
								//$alertStatus = $this->common_model->getAlertStatus();
								//echo "<pre>";print_r($applicaitonsStatus);die;
								//$flag = false;
								$applicaitonsResubmitStatus = $this->common_model->getCommonApplicationStatus($applicaitonsStatus[0]['application_no'],$universityId,$flag);
								//echo "<pre>";print_r($applicaitonsResubmitStatus);die;
								
								if(!empty($applicaitonsResubmitStatus) || $applicaitonsResubmitStatus[0]['ResumitStatus'] == 5 || $applicaitonsResubmitStatus[1]['ResumitStatus'] == 5 || $applicaitonsResubmitStatus[2]['ResumitStatus'] == 5 || $applicaitonsResubmitStatus[3]['ResumitStatus'] == 5 || $applicaitonsResubmitStatus[4]['ResumitStatus'] == 5)
								{
								
								//echo "<pre>";print_r($applicaitonsResubmitStatus);die;
								//$universityName = $this->common_model->getUniversityCourseData($applicaitonsResubmitStatus[0]['universty_choice']);
								//echo "<pre>";print_r($applicaitonsResubmitStatus);die;
									?>
									<div class = "table-responsive">
									<table class="table">
									<thead>
										<th>Preference</th>
										<th>Nomenclature</th>
										<th>University name</th>
										<th>Status</th>
									</thead>
									<tbody>	
									<?php 
									$unStatus = $this->config->item('universities_status_master');
									$counter=1;
								
									//if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 11)
											
											//{
												
											//}
								$flag = false;			
								   for($i = 0;$i<=4;$i++){
									   if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 11){
										   $flag = true;
										   break;
									   }
									   
								   }
								   if($flag == true){
									   	for($i = 0;$i<=4;$i++){
										
										 if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 11){
											 
											 
											 
										
									
										
										$universityName = $this->common_model->getUniversityCourseData($applicaitonsResubmitStatus[$i]['regional_university']);
										
										
										
										
											
											
										
									 ?>
									<tr>
									<td><?php echo $counter; ?></td>
									<td></td>
									<td><?php echo $universityName[0]['name']?></td>
									<td>
									
										<?php  
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
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 3)
								{
									?>
									
									
									<span class="label label-warning">Application on hold</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 6)
								{
									?>
									
									
									<span class="label label-warning">Submited</span>
									
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 7)
								{
									?>
									
									
									<span class="label label-warning">Admission rejected by university</span>
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
								   }
								   }
									else{
									//for($i = 0;$i<=4;$i++){
										
									
										
										$universityName = $this->common_model->getUniversityApplicationStepOneByAppno($applicaitonsStatus[0]['application_no']);
										//echo "<pre>";print_r($universityName);
										
										
											
											
										
									 ?>
									<tr>
									<td>1 <?php $i=0; ?></td>
									<td><?php
									$nomen = $this->common_model->getnomenclatureByid($universityName[0]['nomenclature'])??'';
									echo $nomen[0]['title']; ?>
									</td>
									<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice'])??'';
										echo $university_second[0]['name']; ?>
									</td>
									
									<td>
									
										<?php  
											if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 5)
								{
									//echo "<pre>";print_r($applicaitonsResubmitStatus);
									?>
									
									
									<span class="label label-warning">Application returned by university for re-submission by applicant.</br></br><?php echo $applicaitonsResubmitStatus[$i]['university_remarks']?></span>
									<?php
								}
								
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 2)
								{
									?>
									
									
									<span class="label label-warning">Submited</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 3)
								{
									?>
									
									
									<span class="label label-warning">Application on hold</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 6)
								{
									?>
									
								
									<span class="label label-warning">Submited</span>
									
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 7)
								{
									?>
									
									
									<span class="label label-warning">Rejected</span>
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
									<?php if($universityName[0]['nomenclature_two'] !=''){?>
									
									<tr>
									<td>2 <?php $i=1; ?></td>
									<td><?php
									$nomen = $this->common_model->getnomenclatureByid($universityName[0]['nomenclature_two'])??'';
									echo $nomen[0]['title']; ?>
									</td>
									<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two'])??'';
										echo $university_second[0]['name']; ?>
									</td>
									
									<td>
									
										<?php  
											if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 5)
								{
									//echo "<pre>";print_r($applicaitonsResubmitStatus);
									?>
									
									
									<span class="label label-warning">Application returned by university for re-submission by applicant.</br></br><?php echo $applicaitonsResubmitStatus[$i]['university_remarks']?></span>
									<?php
								}
								
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 2)
								{
									?>
									
									
									<span class="label label-warning">Submited</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 3)
								{
									?>
									
									
									<span class="label label-warning">Application on hold</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 6)
								{
									?>
									
								
									<span class="label label-warning">Submited</span>
									
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 7)
								{
									?>
									
									
									<span class="label label-warning">Rejected</span>
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
									<?php } if($universityName[0]['nomenclature_three'] !=''){?>
									<tr>
									<td>3 <?php $i=2; ?></td>
									<td><?php
									$nomen = $this->common_model->getnomenclatureByid($universityName[0]['nomenclature_three'])??'';
									echo $nomen[0]['title']; ?>
									</td>
									<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three'])??'';
										echo $university_second[0]['name']; ?>
									</td>
									
									<td>
									
										<?php  
											if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 5)
								{
									//echo "<pre>";print_r($applicaitonsResubmitStatus);
									?>
									
									
									<span class="label label-warning">Application returned by university for re-submission by applicant.</br></br><?php echo $applicaitonsResubmitStatus[$i]['university_remarks']?></span>
									<?php
								}
								
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 2)
								{
									?>
									
									
									<span class="label label-warning">Submited</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 3)
								{
									?>
									
									
									<span class="label label-warning">Application on hold</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 6)
								{
									?>
									
								
									<span class="label label-warning">Submited</span>
									
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 7)
								{
									?>
									
									
									<span class="label label-warning">Rejected</span>
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
									<?php }if($universityName[0]['nomenclature_fourth'] !=''){?>
									<tr>
									<td>4 <?php $i=3; ?></td>
									<td><?php
									$nomen = $this->common_model->getnomenclatureByid($universityName[0]['nomenclature_fourth'])??'';
									echo $nomen[0]['title']; ?>
									</td>
									<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fourth'])??'';
										echo $university_second[0]['name']; ?>
									</td>
									
									<td>
									
										<?php  
											if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 5)
								{
									//echo "<pre>";print_r($applicaitonsResubmitStatus);
									?>
									
									
									<span class="label label-warning">Application returned by university for re-submission by applicant.</br></br><?php echo $applicaitonsResubmitStatus[$i]['university_remarks']?></span>
									<?php
								}
								
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 2)
								{
									?>
									
									
									<span class="label label-warning">Submited</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 3)
								{
									?>
									
									
									<span class="label label-warning">Application on hold</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 6)
								{
									?>
									
								
									<span class="label label-warning">Submited</span>
									
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 7)
								{
									?>
									
									
									<span class="label label-warning">Rejected</span>
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
									<?php }if($universityName[0]['nomenclature_fifth'] !=''){?>
									<tr>
									
									<td>5 <?php $i=4; ?></td>
									<td><?php
									$nomen = $this->common_model->getnomenclatureByid($universityName[0]['nomenclature_fifth'])??'';
									echo $nomen[0]['title']; ?>
									</td>
									<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fifth'])??'';
										echo $university_second[0]['name']; ?>
									</td>
									
									<td>
									
										<?php  
											if($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 5)
								{
									//echo "<pre>";print_r($applicaitonsResubmitStatus);
									?>
									
									
									<span class="label label-warning">Application returned by university for re-submission by applicant.</br></br><?php echo $applicaitonsResubmitStatus[$i]['university_remarks']?></span>
									<?php
								}
								
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 2)
								{
									?>
									
									
									<span class="label label-warning">Submited</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 3)
								{
									?>
									
									
									<span class="label label-warning">Application on hold</span>
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 6)
								{
									?>
									
								
									<span class="label label-warning">Submited</span>
									
									<?php
								}
								elseif($applicaitonsResubmitStatus[$i]['ResumitStatus'] == 7)
								{
									?>
									
									
									<span class="label label-warning">Rejected</span>
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
									<?php }?>
									<?php
									$counter++;
									 
								//}
									}
									?>
										
									</tbody>
									</table>
									</div>
									<?php
									
									
								}
								
								elseif($applicaitonsStatus[0]['status'] == 1 && $applicaitonsStatus[0]['universities_status'] == -1)
								{
									?>
									
									<!----<span class="label label-warning">Pending At Mission</span>---->
									<span class="label label-warning">Submitted</span>
									<?php
								}
								
								
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['scholarship_id'] == NULL && $applicaitonsStatus[0]['status'] == 10)
								{
									?>
									<span class="label label-primary">Admission confirmed by university. Scholarship under consideration by Mission</span>
									
									<?php
								}
								elseif($applicaitonsStatus[0]['status'] == 6 && $applicaitonsStatus[0]['universities_status'] == -1)
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
								
								elseif($applicaitonsStatus[0]['status'] == 5 || $applicaitonsStatus[0]['universities_status'] == 18)
								{
									?>
								
									<span class="label label-warning">Please Re-submit Again</span>
									<?php
								}
								
								
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['scholarship_id'] != NULL && $applicaitonsStatus[0]['undertaking_doc'] == NULL)
								{
									//echo "<pre>";print_r($applicaitonsStatus);
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Scholarship awarded.Download letter of award of scholarship.provide acceptance to offer and approach Indian Mission </span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] == -1 && $applicaitonsStatus[0]['status'] == 4 && $applicaitonsStatus[0]['scholarship_id'] != NULL && $applicaitonsStatus[0]['undertaking_doc'] == NULL)
								{
									//echo "<pre>";print_r($applicaitonsStatus);
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Submitted </span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['undertaking_doc'] == 1 && $applicaitonsStatus[0]['visa_no'] == NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Student accepted the offer</span>
									<?php
								}
								
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['visa_no'] != NULL)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Under process for grant of Visa</span>
									<?php
								}
								elseif($applicaitonsStatus[0]['universities_status'] == 1 && $applicaitonsStatus[0]['visa_grant_permission'] == 1)
								{
									?>
								
									<!------<span class="label label-primary">Confirmed by University</span>--->
									<span class="label label-primary">Upload Travel Documents</span>
									<?php
								}
								  elseif($applicaitonsStatus[0]['status'] == 3 || $applicaitonsStatus[0]['universities_status'] == 1)
								{
									?>
								
									<span class="label label-warning">Application on hold by university</span>
									<?php
								}
								?>
								</td>
								<!------<td><span class="label label-danger">Resubmit your application before date:<?php echo $this->config->item('Mission_Applicant_Pending_Date'); ?></span></td>----->
								<!-----<td>
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
									
								
								</span></td>---->
								
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
								if($applicaitonsStatus[0]['visa_no'] == '')
								{
									?>
									<!----<span class="label label-warning">Pending at applicant</span>--->
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
								</td>
								
								<td>
								<?php 
								$travel = $this->common_model->getTravelData($applicaitonsStatus[0]['application_no']);
								//echo "<pre>";print_r($travel);
									if($travel[0]['travel_plan_doc'] == '')
								{
									?>
									<!------<span class="label label-warning">Pending at applicant</span>----->
									<span class="label label-warning">Not Uploaded</span>
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
							else
							{
							?>
								<tr>
									<td colspan="3">Application Not Submitted Yet!(Pending with Applicant)</td>
								</tr>
							<?php
							}
							?>					
														
						</tbody>
					</table>
							</div>
							
							<?php
					
							
                        }
						
						$appStatus = $this->common_model->getAppStatus($applicaitonsStatus[0]['application_no']);
						$user_data = $this->session->userdata('user_data');
			                $userId = $user_data['userid'];	
							$type = $user_data['apply_course_type'];
						  if($items[1]['title'] == $tab)
						  {
							  ?>
							
							 <?php 
							// echo "--------------------------";
							 //echo "<pre>";print_r($appStatus);
							 if($appStatus[0]['universities_status'] == 1 && $appStatus[0]['scholarship_id'] != NULL || $type == 11)
							 {
								 ?>
								  <div class = 'undert'></div>
								 <?php
							 }
							 
							 elseif($appStatus[0]['universities_status'] == -1 && $appStatus[0]['scholarship_id'] != NULL)
							 {
								 ?>
								  <div class = 'undert'></div>
								 <?php
							 }
							 else
							 {
								 ?>
								  <!-----<div>Application Not Submitted Yet!</div>---->
								  <div>Once scholarship is granted to be uploaded by applicant.!</div>
								 
								 <?php
							 }
							 ?>
							
							<?php
							 //echo '<script>window.location.href="'.site_url().'applicant/applicantStatus";</script>';
						  }
						  
						  else if($items[2]['title'] == $tab){
							  ?>
							   <!-----<p >Visa</p>
							   
							    <a href="<?php echo site_url();?>applicant/createTravelPlan/<?php echo $this->uri->segment(3);?>" target = "__blank">Click Here</a>--->
								<?php 
							 //echo "<pre>";print_r($applicaitonStatus);die;
							 if($appStatus[0]['status'] == 11 || $appStatus[0]['status'] == 13 )
							 {
								 ?>
								  <div class = 'visa'></div>
								 <?php
							 }
							 else
							 {
								 ?>
								  <!-----<div>Application Not Submitted Yet!</div>--->
								  <div>Once Visa is issued to be uploaded by applicant.!</div>
								 
								 <?php
							 }
							   
						  }
						  
						  else if($items[3]['title'] == $tab){
							  ?>
							   <!-----<p >Travel</p>
							   
							  <a href="<?php echo site_url();?>applicant/createTravelPlan/<?php echo $this->uri->segment(3);?>" target = "__blank">Click Here</a>--->
							  <?php
							 if($appStatus[0]['status'] >= 11)
							 {
								 ?>
								  <div class = 'travel'></div>
								 <?php
							 }
							 else
							 {
								 ?>
								  <!------<div>Application Not Submitted Yet!</div>------->
								  <div>Once students book tickets to be uploaded by applicant.!</div>
								 <?php
							 }
							   
						  }
						  else if($items[4]['title'] == $tab){
							  //echo "<pre>";print_r($applicaitonsStatus);
							   if($applicaitonsStatus[0]['universities_status'] == 18 || $applicaitonsStatus['status'] == 1)
							  {
								  ?>
								  <!-----<p>Remarks</p>--->
							   
							   <a href="javascript:void(0)" onclick = "openApplicantRemarks('<?php echo $applicaitonsStatus[0]['application_no'];?>')";>Click Here</a>
							   <?php
								  
							  }
							  else
							  {
								  ?>
								  <div>Application Not Submitted Yet!(Pending with Applicant)</div>
								  <?php
							  }   
						  }
                    ?>
					</ul>
            </div>
        </div><!-- /tab-pane  -->
    <?php endforeach; ?>
    </div><!-- /tab-content  -->

<!-- END OF YOUR CODE -->
				</div>
				</div>				
              </div>
              <!-- /.box-body -->
		
	  </div>
	</div>
	<!----<div class="col-xs-12 col-sm-3 col-md-3">
		Righ Sife
	</div>--->
	
		<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">REMARKS</h4>
                        </div>
                        <div class="modal-body">
     
						</div>
	<div class="modal-footer">
	<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
	<!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
           
	
	</div>
                    </div>
                  
                </div>
            </div>
	


<script type='text/javascript'>
	function openApplicantRemarks(appid){
	// AJAX request
				//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('applicant/editApplicantRemarks')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}
 function openUndertakingSfs(id,appid){
	//alert(appid);
			if(id == 2){
				
				//window.location.href = '<?php echo site_url('applicant/processConfirmedappfromhqrs') ?>';
				      $.ajax({
                        url: '<?php echo site_url('applicant/processConfirmedappfromhqrsSfs');?> ',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            //$('.modal-body').html(response); 
							$('.undert').html(response);
							$("#loader").hide();
							
                        }
    
	});
			}
			
			else if(id == 3){
			
				//window.location.href = '<?php echo site_url('applicant/processConfirmedappfromhqrs') ?>';
				      $.ajax({
                        url: '<?php echo site_url('applicant/scholarsvisaendrosment');?> ',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            //$('.modal-body').html(response); 
							$('.visa').html(response);
							$("#loader").hide();
							
                        }
    
	});
			}
			
			else if(id == 4){
				//alert(id);
				//alert(appid);
				//window.location.href = '<?php echo site_url('applicant/processConfirmedappfromhqrs') ?>';
				      $.ajax({
                        url: '<?php echo site_url('applicant/createTravelPlan');?> ',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            //$('.modal-body').html(response); 
							$('.travel').html(response);
							$("#loader").hide();
							
                        }
    
	});
			}
 }
 
  function openUndertaking(id,appid){
	//alert(id);
			if(id == 2){
				
				//window.location.href = '<?php echo site_url('applicant/processConfirmedappfromhqrs') ?>';
				      $.ajax({
                        url: '<?php echo site_url('applicant/processConfirmedappfromhqrs');?> ',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						beforeSend: function() {
						  $("#loader").show();
							},
                        success: function(response){ 
							//alert(JSON.stringify(response));
                            // Add response in Modal body
                            //$('.modal-body').html(response); 
							$('.undert').html(response);
							$("#loader").hide();
							
							}
    
						});
			}
			
			else if(id == 3){
			
				//window.location.href = '<?php echo site_url('applicant/processConfirmedappfromhqrs') ?>';
				      $.ajax({
                        url: '<?php echo site_url('applicant/scholarsvisaendrosment');?> ',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            //$('.modal-body').html(response); 
							$('.visa').html(response);
							$("#loader").hide();
							
                        }
    
	});
			}
			
			else if(id == 4){
				//alert(id);
				//alert(appid);
				//window.location.href = '<?php echo site_url('applicant/processConfirmedappfromhqrs') ?>';
				      $.ajax({
                        url: '<?php echo site_url('applicant/createTravelPlan');?> ',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            //$('.modal-body').html(response); 
							$('.travel').html(response);
							$("#loader").hide();
							
                        }
    
	});
			}
 }
</script>
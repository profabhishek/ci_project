<section class="meacontent">
<?php
error_reporting(0);
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
<div  class="container pdleft pdright">
	
	<marquee>
		Welcome <?php echo $username; ?> to ICCR Scholarship Portal.<?php if($usercountry == '130')
		{
			?>
			<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" >
			Last date for submitting online application for Burundi is 19 Feburary 2020.
			<?php
		}
		if($usercountry == '116')
		{
			?>
			<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" >
			Last date for submitting online application for Uganda is 13 Feburary 2020.
			<?php
		}
	
		if($usercountry == '108')
		{
			?>
			<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" >
			Last date for submitting online application for Syria is 5 Feburary 2020 and 12 Feburary 2020 for the written test for English Language .
			<?php
		}
	?>
	</marquee>	
	<hr/>
	
		<div class="col-xs-12">
		 <h4 style="color:red;font-weight:bold;text-align: center;border: 1px solid;padding: 14px;">Application editing option will be available in case of <b>University</b> find any problem in your application.</h4>
		 </div>

		 <div class="col-xs-12">
		 <?php //echo $include;?>
			 <div class="panel with-nav-tabs panel-default application-tabs mttop">
                <div class="panel-heading main_tab">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" id = "dashb" data-toggle="tab">Dashboard</a></li>
							<?php //echo "<pre>";print_r($applicaitonStepOne);
							 //echo "<pre>";print_r($applicaitonsResubmitStatus);die;
								if(isset($applicaitonStepOne[0]['status'])&&$applicaitonStepOne[0]['status'] == 'Submit')
								{
									
									?>
									<li><a href="#tab2default" data-toggle="tab" id ="psdetails" onclick = "openApplicantPersonalDetailsPreForm();">Personal Details</a></li>
									<?php
								}
								else
								{
									?>
									<li><a href="#tab2default" data-toggle="tab" id ="psdetails" onclick = "openApplicantPersonalDetailsForm();">Personal Details</a></li>
									<?php
									
								}
							
							?>
                            <?php 
							//echo "<pre>";print_r($applicaitonStepOne);
							if(!empty($applicaitonStepOne))
							{
									if($applicaitonStepOne[0]['status'] == 'Submit')
									{
										
										?>
										 <li><a href="#tab3default" class = "edus_toggle_1" data-toggle="tab" id = "edus" onclick ="openApplicantEducationDetailsPreForm();">Education Details</a></li>
										<?php
									}
									
								else
								{
									
										?>
										<li><a href="#tab3default" class = "edus_toggle_2" data-toggle="tab" id = "edus" onclick="openApplicantEducationDetailsForm();">Education Details</a></li>
										<?php
									
								}
							}
							else
							{
								?>
									<li><a href="#tab3default" class = "edus_toggle_3" data-toggle="tab" id = "edus">Education Details</a></li>
									<?php
							}
							
							
								

							
									
							?>
                           <?php
						   //echo "<pre>";print_r($applicaitonStepTwo);
						   if(!empty($applicaitonStepOne) && !empty($applicaitonStepTwo))
							{
									if($applicaitonStepOne[0]['status'] == 'Submit')
										{
											?>
											
												<li><a href="#tab4default" class = "other_toggle_1" data-toggle="tab" id = "otherinfo" onclick = "openApplicantOtherDetailsPreForm();">Other Details</a></li>
									
											<?php
											
										}
										else
										{
											?>
												<li><a href="#tab4default" class = "other_toggle_2" data-toggle="tab" id = "otherinfo" onclick = "openApplicantOtherDetailsForm();">Other Details</a></li>
									
											<?php
										}
								
							}
							else
							{
								
									?>
										<li><a href="#tab4default" data-toggle="tab" class = "other_toggle_3" id = "otherinfo">Other Details</a></li>
										<script>
									//$('#otherinfo').trigger('click');
									</script>	
									<?php
									
									
							}
							
							?>
									
						
						<?php
						//echo "<pre>";print_r($applicaitonStepOne);
						//echo "<pre>";print_r($applicaitonStepTwo);
						//echo "<pre>";print_r($applicaitonStepThree);
						if(!empty($applicaitonStepOne) && !empty($applicaitonStepThree))
							{
								
									$flag = false;
								if(!empty($applicaitonsResubmitStatus)){
									
									foreach($applicaitonsResubmitStatus as $unData){
										if($unData['ResumitStatus'] == 5){
											
											$flag = true;
											break;
										}
									}
								}
								
						if($applicaitonStepOne[0]['status'] == 'Submit' && $flag == false)
								{
									
									?>
							<li><a href="#tab5default" data-toggle="tab" class = "docs_toggle_1" id = "docsinfo" onclick = "openApplicantDocumentsDetailsPreForm();">Documents</a></li>

									<?php
								}
								else
								{
								
								
								
										?>
										<li><a href="#tab5default" class = "docs_toggle_2" data-toggle="tab" id = "docsinfo" onclick = "openApplicantDocumentDetailsForm();">Documents </a></li>
										<?php
									
									
									
								}
							}
							else
							{
								?>
									<li><a href="#tab5default" class = "docs_toggle_3" data-toggle="tab" id = "docsinfo" >Documents </a></li>
									
									
									<?php
								
							}
								?>
								
							
							
							
							<!----<li><a href="#tab8default" data-toggle="tab" id ="check_download" onclick = "openDownloadForm();">Download</a></li>--->
							<li><a href="#tab9default" data-toggle="tab" onclick = "openApplicantProfileForm();">Profile</a></li>
							<li><a href="#tab7default" data-toggle="tab" id ="check_status">Status</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1default">
							<h3>Welcome to the Indian Council for Cultural Relations</h3>
							<div class="formrow">
								<div class="col-xs-12 col-sm-5 col-md-5">
									<img style="height:178px;width:100%;margin-top:8px;" class="first-slide" src="<?php echo base_url();?>assets/site/main/images/banner/PAR_11031.JPG" alt="ICCR" />
								</div>
								<div class="col-xs-12 col-sm-7 col-md-7">	  
									<p style="text-align:justify;">The Indian Council for Cultural Relations (ICCR) was founded in 1950 by Maulana Abul Kalam Azad, independent India’s first Education Minister. Its objectives are to actively participate in the formulation and implementation of policies and programmes pertaining to India’s external cultural relations; to foster and strengthen cultural relations and mutual understanding between India and other countries; to promote cultural exchanges with other countries and people; and to develop relations with nations.</p> 
									
									 <div class="inner">
            
			<?php  

			
            if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['status'] == 'Submit' )
            {
				
				?>
			<a href="<?php echo site_url(); ?>applicant/viewApplication/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer" style = "margin-left:400px" target = "_blank">View Application</a>
			<?php
			}
			else
			{
			?>
              <a href="#tab2default" data-toggle="tab" style = "margin-left:350px" onclick = "openApplicantPersonalDetailsForm();">Apply for Scholarship</a>
			  <?php
			}
			  ?>
              
            </div>
									<!----<a href="#tab2default" data-toggle="tab" style = "margin-left:400px" onclick = "openApplicantPersonalDetailsForm();">Click here to apply</a>--->
								</div>
							</div>
						</div>
                        <div class="tab-pane fade" id="tab2default">
							<div class ="personalDetails">
							</div>
						</div>
                        <div class="tab-pane fade" id="tab3default">
							<div class ="educationDetails"></div>
						</div>
						
						 <div class="tab-pane fade" id="tab4default">
							<div class ="otherDetails"></div>
						</div>
						
						<div class="tab-pane fade" id="tab5default">
							<div class ="documentDetails"></div>
						</div>
						
						<div class="tab-pane fade" id="tab6default">
							<div class ="documentDetails"></div>
						</div>
						<div class="tab-pane fade" id="tab7default">
						<?php  
							//echo "<pre>";print_r($data);
						 $data['include'] = 'application_status';
						 
						 $user_data = $this->session->userdata('user_data');
						 //echo "<pre>"; print_r($user_data);
				         $userId = $user_data['userid'];	
						 $data['applicaitonsStatus'] = $this->common_model->getApplicationStatus($userId);
						 $data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
						 if($user_data['apply_course_type'] == 10){
							 $this->load->view('site/applicantAyushStatus',$data);
						 }
						 else
						 {
				         $this->load->view('site/applicantStatus',$data);
						 }
						?>
							<!----<div class ="applicatStatusDetails"></div>--->
						</div>
						
						<!----<div class="tab-pane fade" id="tab8default">
							<?php
							
							?>
							<div class ="documentDetails">
							<div class="table-responsive">
							<table class="table">
						<thead>
							<tr><th>S.No.</th>
							<th>Documents</th>
								
						</tr></thead>
						<tbody>	
							<tr>
								<td>1.</td>
								<td><a href="<?php echo site_url(); ?>applicant/viewApplication/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer pull-right export-btn"><i class="fa fa-arrow-circle-right"></i></a></td>
							</tr>
												
														
						</tbody>
						</table>
							</div>


							
							</div>
							
						</div>--->
						
						<div class="tab-pane fade" id="tab9default">
							<div class="col-md-12">
				<?php  
				
				
				$user_data = $this->session->userdata('user_data');
			$userId = $user_data['userid'];
			$imgArray = $this->common_model->getUserImage($userId);
			if(count($imgArray)> 0)
			{
				$userImage = $imgArray[0]['name'];
			}		
			else
			{
				$userImage = '';
			}
			$data['applicaitonStepOne'] = $this->common_model->getApplicationStepOne($userId);
			$registerData = $this->common_model->getUserData($userId);
				
				
				?>
          <!-- Profile Image -->
          <div class="box box-primary profile-sec">
            <div class="box-body box-profile">			
			<?php  
			
			$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid'] );
			$user_data = $this->session->userdata('user_data');
							$dir = $user_data['dir'];
							if($userd->dir == "")
						{
							?>
							<img class="profile-user-img img-responsive img-circle" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
							<?php		
						}						
						else
						{
							if(file_exists($userd->dir.'/'. $userImage))
							{
								?>
							<img class="profile-user-img img-responsive img-circle" src="data:<?php if(!empty($mime_type)){echo $mime_type;}?>;base64,<?php if(!empty($data)){echo $data;}?>"/>
							<?php		
							}
							else{
								?>
							<img class="profile-user-img img-responsive img-circle" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
							<?php
							}
							
						}
						
							/*$imgs = file_get_contents($dir.'/'.$userImage);
							//echo $imgs;
							$data = base64_encode($imgs);
							$f = finfo_open();
							$imgdata = base64_decode($data);
                            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);*/
					
					?>
             

              <h3 class="profile-username text-center"><?php $title = '';									
						  if(count($registerData) > 0)
						  {
						  	$title = $registerData[0]['username'];
						  }												  
					  ?>
					  <?php if(!empty($registerData)) echo $registerData[0]['username'];?></h3>

              <p class="text-muted text-center"><?php   $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $nationality)
						  {
						  	if(!empty($registerData))
						  	{
								if($registerData[0]['country_of_domicile'] == $nationality['id'])
								{
									echo $nationality['country_name'];
								}								
							}
						  	
						  }
						  ?>			</p>

   

              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary profile-sec">
            <!----<div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>--->
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Personal Information</strong>

              <p class="text-muted">
                <div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					Gender: <?php $title = '';
						  if(count($registerData) > 0)
						  {
						  	$title = $registerData[0]['gender'];
						  }
						  if($title == 1)
						  {
						  ?>
							M					  							 
						  <?php	
						  }
						  elseif($title == 2)
						  {
						  ?>
							 
					  		F
						  <?php		
						  }	?>	
				
					</div>	
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
						 Date of Birth: </label><?php if(!empty($registerData)) echo $registerData[0]['date_of_birth'];?>							
					
				
					</div>
					
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					 Nationality: </label>	<?php   $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $nationality)
						  {
						  	if(!empty($registerData))
						  	{
								if($registerData[0]['country_of_domicile'] == $nationality['id'])
								{
									echo $nationality['country_name'];
								}								
							}
						  	
						  }
						  ?>					
					</div>
					
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					Country of Residence:  </label><?php //echo "<pre>";print_r($applicaitonStepOne);die;
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $nationality)
						  {
						  	if(!empty($registerData))
						  	{
								if($registerData[0]['country_of_domicile'] == $nationality['id'])
								{
									echo $nationality['country_name'];
								}								
							}
						  	
						  }
						  ?>
						
					
					</div>
					
					
					 <div class="tab-pane fade in" id="tab2" style="overflow:hidden;">
          <div class="col-xs-12 col-sm-7 col-md-12 contact-detail">
			Mobile Number:
			
			 <?php if(!empty($registerData)) echo $registerData[0]['mobile_number'];?>
				
		  </div>
		  <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdright">
			Email Id:
			 <?php if(!empty($registerData)) echo $registerData[0]['email_id'];?>
			</div>
        </div>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Postal Address</strong>

              <p class="text-muted"><div class="form-group col-md-12 pdleft">							
						  <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address'];?><br/>
						  City :<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_city'];?><br/>
						  State: <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_state'];?><br/>
						  Country:  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['postal_address_country'] == $country['id'])
								{
									echo $country['country_name'];
								}
							}
						  }
						  ?>
						  <br/>
						  Pincode: <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_pincode'];?>
					</div></p>

              <hr>

              <!----<strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>---->

              <!----<p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>--->

              <hr>

              <!-----<strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>---->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
						</div>
                    </div>
                </div>
            </div>	        
        </div>
        
			 <div class="col-xs-12 col-sm-3 col-md-3">
				<!--<div class="needhelp">
					<div class="needhttext">Need Help</div>
					<ul class="needhelpul">
						<li><a href="javascript:void(0);">A recent passport size photograph not more than 3.5x4.5cm (200kb) should be uploaded on the application form in the space provided.The photograph should be with white background and without spectacles.</a></li>
						<li><a href="javascript:void(0);">Copies of all academic qualifications, certificates and marksheet, including those relating to school leaving examination must be uploaded.</a></li>
						<li><a href="javascript:void(0);">Recommendations / character certificates from existing school/University etc.</a></li>
						<li><a href="javascript:void(0);">Notarized copies of relevant pages of candidate’s valid passport showing photograph, name, contact details, date of issue, date of expiry and place of issue. Please ensure that your passport is valid for the duration of the course for which you have applied</a></li>
						<li><a href="javascript:void(0);">At the time of uploading the required documents kindly ensure that all documents uploaded correctly in the given module e.g. module for educational certificates should only be uploaded with the educational certificates only not other documents such as passport copies or photographs etc.</a></li>
						<li><a href="javascript:void(0);">Original Certificates/ documents must be carried by the Applicant if admitted for verification by the concerned University/ Institute at the time of joining. This mandatory requirement otherwise admission can be cancelled by the University/ Institute and the ICCR will not be responsible for this..</a></li>
						<li><a href="javascript:void(0);">In case of Engineering courses, you must have Physics, Chemistry & Mathematics (PCM) in your school leaving examinations as this is mandatory for Engineering courses.</a></li>
						<li><a href="javascript:void(0);">Candidates are requested that they may apply on portal along with following compulsory details of their Personal/Academic details.
						<p>a)Passport Number.</br>b).Age Proof (Birth Certificate /Any Unique Identity issued by the Government indicating clear date of Birth).</br>c).Synopsis detail in case of Ph.D candidates</a></li>
						
						<li><a href="javascript:void(0);">Note: Ensure that notarized copies of documents showing specific qualifications required for the course of your choice (such as GMAT scores for admission in MBA, TOEFL/IELTS scores for English courses etc.) are also attached. The requirements can be checked from the UGC/Institute/University website.
						(ORIGINAL CERTIFICATES/DOCUMENTS MUST BE CARRIED BY THE APPLICANT IF ADMITTED, FOR VERIFICATION BY THE UNIVERSITY/INSTITUTE.)
						 PLEASE CHECK THAT ALL COLUMNS / MODULES ARE PROPERLY FILLED UP BEFORE SUBMISSION OF THE APPLICANT FOR ONWARD PROCESSING AS ANY INCOMPLETE APPLICATION WILL NOT BE PROCESSED FOR ADMISSION.</a></li>
						
					</ul>
				</div>-->
          <!-- small box -->
          <div class="small-box bg-aqua">

			
          <?php 
          if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['status'] == 'Submit')
          {
		  	?>
		  	  <!----<div class="small-box bg-green">
            <div class="inner">
           
               <h4 class="text-center">Add Youtube Video/Audio Link</h4>
              
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>/applicant/addVideo/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">Click Here<i class="fa fa-arrow-circle-right"></i></a>
          </div> ---->
		  	<?php
		  }
          ?>
              
        </div>
			     
        <?php
        
        	if(count($academicDeatils)>0 && $academicDeatils[0]["scholarship_status"] > 0)
        	{
				?>
				 <div class="col-xs-2">
        	<br/><br/>
           <div class="small-box bg-red">
            <div class="inner">
               <h4 class="text-center">Complaints</h4>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           <a href="<?php echo site_url(); ?>applicant/complaints/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
          <div class="small-box bg-yellow">
            <div class="inner">
               <h4 class="text-center">Bank Details</h4>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           <a href="<?php echo site_url(); ?>applicant/bankdetails/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
           <div class="small-box bg-orange">
            <div class="inner">
               <h4 class="text-center">FRRO Details</h4>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           <a href="<?php echo site_url(); ?>applicant/frroDetails/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
				<?php
			}
        ?>
		
        <!-- ./col -->
        <div class="col-xs-12">
          <!-- small box -->
          
        </div>      
      
	</div>
</section>
<script src="<?php echo base_url();?>assets/site/main/js/custom.js" ></script>
<script type='text/javascript'>
	function openApplicantPersonalDetailsForm(appid){
	// AJAX request
				//alert('ok');
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_personal_info')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						 beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
                            // Display Modals
                            $('.personalDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}
function openApplicantEducationDetailsForm(appid){
	// AJAX request
	//alert('ok');
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_education_info')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						 beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
                            // Display Modals
                            $('.educationDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}
function openApplicantOtherDetailsForm(appid){
	// AJAX request
				//alert('ok');
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_other_info')?>',
                        type: 'post',
						data:{'id':appid},
						 beforeSend: function() {
						  $("#loader").show();
					   },
	                    //dataType:'json',
                        success: function(response){ 
                            // Display Modals
                            $('.otherDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}
 
function openApplicantDocumentDetailsForm(appid){
	// AJAX request
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_documents')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						 beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
                            // Display Modals
                            $('.documentDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}

function openApplicantStatusForm(appid){
	// AJAX request
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicantStatus')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
                            // Display Modals
                            $('.applicatStatusDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}

function openApplicantPersonalDetailsPreForm(appid){
	// AJAX request
	
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_personal_info_preview')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						 beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
                            // Display Modals
                            $('.personalDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}

function openApplicantEducationDetailsPreForm(appid){
	// AJAX request
	
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_education_info_preview')?>',
                        type: 'post',
						data:{'id':appid},
						beforeSend: function() {
						  $("#loader").show();
					   },
	                    //dataType:'json',
                        success: function(response){ 
                            // Display Modals
                            $('.educationDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}
function openApplicantOtherDetailsPreForm(appid){
	// AJAX request
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_other_info_preview')?>',
                        type: 'post',
						data:{'id':appid},
						beforeSend: function() {
						  $("#loader").show();
					   },
	                    //dataType:'json',
                        success: function(response){ 
                            // Display Modals
                            $('.otherDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}

function openApplicantDocumentsDetailsPreForm(appid){
	// AJAX request
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_documents_info_preview')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
						beforeSend: function() {
						  $("#loader").show();
					   },
                        success: function(response){ 
                            // Display Modals
                            $('.documentDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}
function openDownloadForm(appid){
	// AJAX request
	
                    $.ajax({
                        url: '<?php echo site_url('applicant/applicant_download_form')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
                            // Display Modals
                            $('.downloadDetails').html(response);
							$("#loader").hide();
                        }
    
	});
}

</script>
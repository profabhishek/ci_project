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
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
</style>


						
<?php	
$universityarray = array();	
$univarray = array();
$isResponseSent = $this->common_model->isAnyUniversityResponseConfirm($this->uri->segment(3),$regionId);	
if(count($isResponseSent)>0)
{
	foreach($isResponseSent as $isResponseS)
	{
		array_push($univarray,$isResponseS['regional_university']);
	}
}	
foreach($univercities as $univercity)
{							
	if(!empty($applicaitonStepOne))
  	{
		if($applicaitonStepOne[0]['universty_choice'] == $univercity['id'])
		{
			if($univercity['state'] == $regionId)
			{
				if(!in_array($univercity['id'],$univarray))
				{
					$universityarray[$univercity['id']] = $univercity['name'];	
				}
			}
		}									
	}								
} 
$univercitie_two = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],0);

foreach($univercitie_two as $univercity1)
 {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_two'] == $univercity1['id'])
  		{  	
  					
  			if($univercity1['state'] == $regionId)
			{
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}
			}			
		}									
	}								
 }							 	
$univercitie_two = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],$applicaitonStepOne[0]['universty_choice_two']);
foreach($univercitie_two as $univercity1)
 {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_three'] == $univercity1['id'])
  		{  			
  			if($univercity1['state'] == $regionId)
			{
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}				
			}  
		}									
	}								
 }	
?>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;">	
	<form method="post" action="<?php echo base_url();?>regional/downloadApplication" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<div class="tab-content detailpagepdf">		
	  <div id="home" class="tab-pane fade in active">	
	    	 
              <div class="box-body">
              	  	<div class="col-xs-3 prfl pull-right" >
              		              		<?php 
					
						$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']); 
              			if($userd->dir == "")
              			{
						?>
					
							<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
							<?php		
						}
						else
						{
							if(file_exists($userd->dir.'/'. $userImage))
							{
								?>
							<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?><?php echo $userd->dir.'/'. $userImage; ?>"/>
							<?php		
							}
							else{
								?>
							<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
							<?php
							}
							
						}
              		?>
              	</div>
              	<div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">              		
	              	<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<label style="font-size:18px; padding-bottom: 20px;">Application Made Through: <?php
							 	foreach($missions as $mission)
	       						{
	       							if(!empty($applicaitonStepThree))
							  		{
										if($applicaitonStepThree[0]['application_through'] == $mission['id'])
										{
											echo $mission['country_name'].'</b> '.$mission['mission_type'].' '.$mission['mission_name'];
										}										
									}	
	       						}	
							 	?>	</label>				
						
					</div>	
					<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<label>1. Full Name (IN BLOCK LETTERS)</label>
					<div class="col-xs-2 col-md-6 col-sm-2 pdright">
					<div class="form-group">
					<label>
					  <?php $title = '';
						  if(count($applicaitonStepOne) > 0)
						  {
						  	$title = $applicaitonStepOne[0]['student_title'];
						  }
						  if($title == 1)
						  {
						  	echo 'Mr.';						  
						  }
						  elseif($title == 2)
						  { 
						  	echo 'Mrs';
						  }
					  ?>		
					   <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['fullname'];?>				  
						</label>
					</div>
					</div>						
					<div class="name-sec col-xs-12 col-sm-5 col-md-12 pdleft">	
					<label>2. Gender</label>			
						<div class="form-group">	
						  <?php $title = '';
						  if(count($applicaitonStepOne) > 0)
						  {
						  	$title = $applicaitonStepOne[0]['gender'];
						  }
						  if($title == 1)
						  {
						  	echo 'Male';					  	
						  }
						  elseif($title == 2)
						  {
						  	echo 'Female';							  						  
						  }
					  ?>
						 
						</div>
					</div>	
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright"  >	
					<div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft leftside" style="float: left;">
						 <label for="comment">3. Date of Birth</label>
							<div class="form-group col-md-9 pdleft">
						<?php if(!empty($applicaitonStepOne)) echo date("d/m/Y", strtotime($applicaitonStepOne[0]['dob']));?>
							</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-4 leftside" style="float: left;">
					 <label for="comment">Nationality</label>
						<div class="form-group">
						 <div class="form-group">						
						  <?php
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $nationality)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['country'] == $nationality['id'])
								{
									echo $nationality['country_name'];
								}
							}
						  }
						  ?>						
						</div>
						</div>
					</div>
					</div>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-3 col-md-5 pdleft">
					 <label for="comment">4. Country of Residence</label>
						<div class="form-group col-md-9 pdleft">
						 
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['country'] == $country['id'])
								{
									echo $country['country_name'];
								}
							}
						  }
						  ?>
						
						</div>
					</div>
					</div>
				<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-5 pdleft">
					 <label for="comment">5. Passport No (Excluding Passport No.)</label>
						<div class="form-group col-md-9 pdleft">
						  <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_no'];?>
						</div>
					</div>
					
				</div>
				<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
					 <label for="comment">a) Date of Issue</label>
						<div class="form-group">
						  <?php if(!empty($applicaitonStepOne)) echo date("d/m/Y", strtotime($applicaitonStepOne[0]['passport_issue_date']));?>
						</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
					 <label for="comment">b) Date of Expiry</label>
						<div class="form-group">
						 <?php if(!empty($applicaitonStepOne)) echo date("d/m/Y", strtotime($applicaitonStepOne[0]['passport_expiry_date']));?>
						</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
					 <label for="comment">c) Place of Issue</label>
						<div class="form-group">
						  <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place'];?>
						</div>
					</div>
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12 pdleft">
						<label for="comment">6. Postal Address </label>	
							<div class="form-group col-md-12 pdleft">							
						 <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address'];?>
					</div>			
				 </div>
				</div>	
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12 pdleft">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">
					   <?php if(!empty($applicaitonStepOne)) echo 'City: '. $applicaitonStepOne[0]['postal_address_city'];?>
					</div>
					<div class="form-group col-md-12 pdleft">
					   <?php if(!empty($applicaitonStepOne)) echo 'State: '.$applicaitonStepOne[0]['postal_address_state'];?>
					</div>
</div>
				</div>	
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">	
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['postal_address_country'] == $country['id'])
								{
									echo 'Country: '.$country['country_name'];
								}								
							}							
						  }
						  ?>						
					</div>
					<div class="form-group col-md-12 pdleft">
					  <?php if(!empty($applicaitonStepOne)) echo 'Pincode: '. $applicaitonStepOne[0]['postal_address_pincode'];?>
					</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-7 col-md-12 contact-detail pdleft">
					<label>7. Contact Details <span class="note"></span></label>
					<div class="col-xs-12 col-md-5 col-sm-4 pdleft" style="padding: 0px;">
					<div class="form-group">+ <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['tel_country_code'];?> <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['phone'];?></div>
					</div>				
					
					</div>
					<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
					<label>Email Id</label>	
						
						<div class="form-group col-md-4 pdleft"> <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['email'];?></div>
						
					</div>
					
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">	
					 <label for="comment">Permanent Unique ID</label>
						<div class="form-group col-md-4 pdleft">
						  <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['unique_id'];?>
						</div>
				
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-7 pdleft">
					<h4><strong>Details of Father/Guardian</strong></h4>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
                   <label for="comment">Name</label>
                   <div class="form-group date">
                       <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_name'];?>
                   </div>
                </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
                   <label for="comment">Relation</label>
                   <div class="form-group">
                     <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_relation'];?>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
                   <label for="comment">Occupation</label>
                   <div class="form-group date">
                      <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_occupation'];?>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
                   <label for="comment">Nationality</label>
                   <div class="form-group">                      
						  <?php
						  $nationalities = $this->common_model->getNationality();
						  foreach($nationalities as $nationality)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['nationality'] == $nationality['id'])
								{
									echo $nationality['title'];
								}								
							}							
						  }
						  ?>
                   </div>
                </div>               	
               </div> 
              <div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12 pdleft">
						<label for="comment"> Address </label>	
							<div class="form-group col-md-12 pdleft">							
						  <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_address'];?>
					</div>			
				 </div>
				</div>	
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
					<label for="comment"></label>	
					<div class="form-group col-md-12 pdleft">
						   <?php if(!empty($applicaitonStepOne)) echo 'City: '. $applicaitonStepOne[0]['gardiuan_address_city'];?>
						</div>
						<div class="form-group col-md-12 pdleft">
						  <?php if(!empty($applicaitonStepOne)) echo 'State: '. $applicaitonStepOne[0]['gardiuan_address_state'];?>
						</div>
					</div>
				</div>	
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">					  
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['gardiuan_address_country'] == $country['id'])
								{
									echo 'Country: '.$country['country_name'];
								}								
							}
						  }
						  ?>						
					</div>
					<div class="form-group col-md-12 pdleft">
					   <?php if(!empty($applicaitonStepOne)) echo 'Pincode: '. $applicaitonStepOne[0]['gardiuan_address_pincode'];?>
					</div>
					</div>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                <div class="name-sec col-xs-12 col-sm-6 col-md-4 pdleft">
					 <label for="comment">8. Knowledge of English</label>
					<div class="form-group">					  
					  	 <?php $knowledge = '';
						  if(count($applicaitonStepOne) > 0)
						  {
						  	$knowledge = $applicaitonStepOne[0]['knowledge_english'];
						  }
						  if($knowledge == 1)
						  {
						  	echo 'Yes';
						  }
						  elseif($knowledge == 2)
						  {
						  	echo 'No';						 		
						  }
					  ?>					 
					</div>
				 </div>
				 <?php
				 	if($knowledge == 1)
					{
					?>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-4 knwledge_eng">
					<label for="comment">Written:</label>
					<div class="form-group">
						<?php
						if($applicaitonStepOne[0]['knowledge_english'] == 1)
						{
							echo 'Average';									
						}
						elseif($applicaitonStepOne[0]['knowledge_english'] == 2)
						{
							echo 'Proficient';									
						}
						elseif($applicaitonStepOne[0]['knowledge_english'] == 3)
						{
							echo 'Good';									
						}
						?>					   
					   
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-4 knwledge_eng">
					<label for="comment">Spoken:</label>
					<div class="form-group">
					<?php
						if($applicaitonStepOne[0]['knowledge_english'] == 1)
						{
							echo 'Average';									
						}
						elseif($applicaitonStepOne[0]['knowledge_english'] == 2)
						{
							echo 'Proficient';									
						}
						elseif($applicaitonStepOne[0]['knowledge_english'] == 3)
						{
							echo 'Good';									
						}
						?>						    
					</div>
				 </div>	
					<?php	
					}					
				 ?>
				</div> 
				  	<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">						
					<div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft">
					 <label for="comment">9. Level of Programme</label>
						<div class="form-group col-md-10 pdleft">						 
						  		<?php 
						  		$programme = $this->common_model->getAllProgramme();
						  		
						  		$res = array(8 => $programme[7]);
						  		$ress = array_merge(array_slice($programme, 0, 4), $res, array_slice($programme, 4));
						  		unset($ress[8]);	
						  		foreach($ress as $program)
						  		{
									if(!empty($applicaitonStepOne))
								  	{
								  		if($applicaitonStepOne[0]['programme'] == $program['id'])
								  		{
											echo $program['name'];
										}										
									}									
								}
						  	?>		
						</div>
					</div>	
					<?php
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 9)
					{
					?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_type" required="true">
						 <label for="comment">Course Type </label>
							<div class="form-group col-md-10 pdleft">
							  	<?php 
							  		$courseType = $this->common_model->getAllCourseType();
							  		
							  		foreach($courseType as $ctype)
							  		{
										if(!empty($applicaitonStepOne))
									  	{
									  		if($applicaitonStepOne[0]['course_type'] == $ctype['id'])
									  		{
												echo $ctype['course_type'];
											}											
										}
										
									}
							  	?>			
							</div>
						</div>
					<?php	
					}
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_type fade" style="display:none;">
						 <label for="comment">Course Type <span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  
							  	<?php 
							  		$courseType = $this->common_model->getAllCourseType();
							  		
							  		foreach($courseType as $ctype)
							  		{
										if(!empty($applicaitonStepOne))
									  	{
									  		if($applicaitonStepOne[0]['course_type'] == $program['id'])
									  		{
												echo $program['course_type'];
											}
										}
										
									}
							  	?>						 	
							 
							</div>
						</div>
						<?php	
					}
					?>	
				<?php
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
					{
					?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 cours_subject" required="true">
						 <label for="comment">Subject </label>
							<div class="form-group col-md-10 pdleft">							  
							  	<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]["course_subject"];  ?>				 	
							</div>
						</div>
					<?php	
					}
					?>			
				</div>
				<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-12 pdleft">
					 <label for="comment">10. Univesities/Institutes in India where you wish to seek admission:</label>
				<?php
									if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
						?>
						<table id="tbl_uni" style="width: 100%;">
										<thead>
											<th>Course you wish to study</th>
											<th>University</th>
											<th>Course Stream</th>
										</thead>
										<tbody>
											<tr>
												<td>
												<?php
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							
					  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
					  		
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}	
						}
						elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						{
							$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}
						}
						elseif($applicaitonStepOne[0]['programme'] == 9)
						{
							 
					  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
					  		
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}
								  	
						}
						?>	
													
													
													
												</td>
												<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);echo $university_second[0]['name'];?></td>
												<td><?php
												if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
								if(!empty($applicaitonStepOne)) 
								echo $applicaitonStepOne[0]['course_option_name'];
							}	
							else
							{
								echo "NA";
							}
						}
						else
						{
							echo "NA";
						}	
												?></td>
											</tr>
											<tr>
												<td><?php
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							
					  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
					  		
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course_two'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}	
						}
						elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						{
							$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course_two'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}
						}
						elseif($applicaitonStepOne[0]['programme'] == 9)
						{
							 
					  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
					  		
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course_two'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}
								  	
						}
						?></td>
												<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);echo $university_second[0]['name'];?></td>
												<td><?php
												if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course_two'] > 0 && $crs[0]['has_stream'] > 0)
							{
								if(!empty($applicaitonStepOne)) 
								echo $applicaitonStepOne[0]['course_option_name_two'];
							}
							else
							{
								echo "NA";
							}	
						}
						else
						{
							echo "NA";
						}	
												?></td>
											</tr>
											<tr>
												<td><?php
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							
					  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
					  		
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course_three'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}	
						}
						elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						{
							$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course_three'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}
						}
						elseif($applicaitonStepOne[0]['programme'] == 9)
						{
							 
					  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
					  		
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course_three'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}
								  	
						}
						?></td>
												<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']);echo $university_second[0]['name'];?></td>
												<td><?php
												if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course_three'] > 0 && $crs[0]['has_stream'] > 0)
							{
								if(!empty($applicaitonStepOne)) 
								echo $applicaitonStepOne[0]['course_option_name_three'];
							}
							else
							{
								echo "NA";
							}	
						}
						else
						{
							echo "NA";
						}	
												?></td>
											</tr>
										</tbody>
									</table>
						<?php
					}
					else
					{
						?>
						<table id="tbl_uni" style="width: 100%;">
										<thead>
											<th>University 1</th>
											<th>University 2</th>
											<th>University 3</th>
										</thead>
										<tbody>
											<tr>
												<td><?php $university_first = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']); echo $university_first[0]['name'];?></td>
												<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);echo $university_second[0]['name'];?></td>
												<td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']); echo $university_three[0]['name'];?></td>
											</tr>
										</tbody>
									</table>
						<?php
					}
									?>
					</div>
					
				</div>
				
										
					
				</div>				
              </div>
              <!-- /.box-body -->
           
	  </div>
<div class="box-body">  
				 <div class="name-sec col-xs-12 col-sm-5 col-md-7 pdleft">
					<h4>11. Previous Educational Qualifications  </h4>
				</div> 
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table class="table">
						<thead>
							<th>Certificate/Degree</th>
							<th colspan="1">Country</th>
							<th colspan="3">Name of School/University/Board</th>
							<th colspan="1">Year</th>
							<th colspan="1">Percentage(%)/Grade</th>
						</thead>
						<tbody>
							<?php 
							$programs = $this->config->item('programme');
							$program = $programs[$applicaitonStepOne[0]['programme']];
							switch($program)
							{
								case "UG":
								?>
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India)</td>
								<td colspan="1">
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
										  }
									  ?>
			                       
								</td>
								<td colspan="3">
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>
								</td>
							</tr>
								<?php
								break;
								case "PG":
								case "Dance":
								case "Music":
								case "Yoga":
								?>
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India)</td>
								<td colspan="1">
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}
												
											}											
										  	
										  }
									  ?>
			                       
								</td>
								<td colspan="3">
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>
								</td>
							</tr>
							<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)</td>
								<td colspan="1">
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}
											}
										  }
									  ?>
			                       
								</td>
								<td colspan="3">
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>
								</td>
							</tr>
								<?php
								break;
								case "M.Phil":
								?>
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India)</td>
								<td colspan="1">
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}
											}
										  }
									  ?>
			                       
								</td>
								<td colspan="3">
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>
								</td>
							</tr>
								<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)</td>
								<td colspan="1">
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
										  }
									  ?>
			                       
								</td>
								<td colspan="3">
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>
								</td>
							</tr>
								<tr>
							<td>Post graduate<br/>(Two years University education after graduation or five years after class XII.)</td>
								<td colspan="1">								   
			                        
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['pg_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
										  }
									  ?>
			                       
								</td>
								<td colspan="3">
								 <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_percentage'];?>
								</td>
							</tr>
								<?php
								break;
								case "Ph.D":
								?>
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India)</td>
								<td colspan="1">
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
											
										  	
										  }
									  ?>
			                       
								</td>
								<td colspan="3">
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>
								</td>
							</tr>
								<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)</td>
								<td colspan="1">
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
										  }
									  ?>
			                       
								</td>
								<td colspan="3">
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>
								</td>
							</tr>
								<tr>
							<td>Post graduate<br/>(Two years University education after graduation or five years after class XII.)</td>
								<td colspan="1">
								   
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['pg_leaving_country'] == $country['id'])
												{
													echo $country['country_name'];
												}
												
											}
										  }
									  ?>			                     
								</td>
								<td colspan="3">
								 <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_university'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_year'];?>
								</td>
								<td colspan="1">
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_percentage'];?>
								</td>
							</tr>								
								<?php
								break;								
							}
							?>	
						</tbody>
					</table>
				</div>		
			 	
				
              </div>	   


	</div>
	</div>
	<?php 
	
	$docsArray = array();
	/* if(count($applicaitonDocuments) > 0)
	{
		foreach($applicaitonDocuments as $docs)
		{
			if(!array_key_exists($docs['doc_type'],$docsArray))
			{
				$docsArray[$docs['doc_type']] = array();
			}
			$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
			$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
		}
	} */	

	if(count($applicaitonDocuments) > 0)
	{
		foreach($applicaitonDocuments as $docs)
		{
			if(!array_key_exists($docs['doc_type'],$docsArray))
			{
				$docsArray[$docs['doc_type']] = array();
				$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
				$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
			}
			
		}
	}	
	?>
	<br/>
	<br/>
	<div class="tab-content">		
	  <div id="step3" class="tab-pane fade in active">	 
	  <h5 class="text-center">All Documents</h5>	    
	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <div class="box-body">
              	<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table class="table">
						<thead>
							<th>S.No.</th>
							<th>Document Name</th>
							<th>Upload Document</th>							
							<th>Uploaded Time</th>							
						</thead>
						<tbody>
							<?php
								$counter = 1;	
								$upload = 0;						
								$doctypes = $this->config->item('doc_types');								
							?>	
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td>Permanent Unique ID <span class="text-red">*</span></td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['id']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['id']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								  <a href="#" data-toggle="modal" data-target="#idProofDiv">Upload</a>
								  <?php	
								  }
								  ?>	
								  
								</td>
								<td>
								 <?php
								  if(array_key_exists($doctypes['id']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['id']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>								
							</tr>
							<?php
							if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['passport_no']!= "")
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['passport']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['passport']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['passport']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#passportDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['id']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['id']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
							{								
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['school_leaving']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['school_leaving']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#schoolLivingDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['school_leaving']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['school_leaving']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0)
							{
								
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['ug']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['ug']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['ug']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#underGraduateDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['ug']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['ug']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['pg_leaving_country'] != "" && $applicaitonStepTwo[0]['pg_leaving_country'] > 0)
							{
								
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['pg']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['pg']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['pg']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#postGraduateDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['pg']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['pg']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['mphil_leaving_country'] != "" && $applicaitonStepTwo[0]['mphil_leaving_country'] > 0)
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['mhil']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['mhil']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['mhil']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#mphilDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['mhil']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['mhil']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
								<?php
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['phd_leaving_country'] != "" && $applicaitonStepTwo[0]['phd_leaving_country'] > 0)
							if(array_key_exists($doctypes['phd']['type'],$docsArray))
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['phd']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['phd']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['phd']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#phdDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['phd']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['phd']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							
							<?php
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['phd_leaving_country'] != "" && $applicaitonStepTwo[0]['phd_leaving_country'] > 0)
							if(array_key_exists($doctypes['phdReseachPaper']['type'],$docsArray))
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['phdReseachPaper']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['phdReseachPaper']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['phdReseachPaper']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#phdDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['phdReseachPaper']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['phdReseachPaper']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							?>
							<?php							
							if(count($applicaitonStepThree) > 0 && $applicaitonStepThree[0]['currently_non_nri'] != "" && $applicaitonStepThree[0]['currently_non_nri'] > 0 && $applicaitonStepThree[0]['currently_non_nri'] == 1)
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['indian_address']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['indian_address']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['indian_address']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#addressProofDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['indian_address']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['indian_address']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>		
							<?php							
							if(count($applicaitonStepThree) > 0 && $applicaitonStepThree[0]['is_international_lic'] != "" && $applicaitonStepThree[0]['is_international_lic'] > 0 && $applicaitonStepThree[0]['is_international_lic'] == 1)
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['dl']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['dl']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['dl']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#licenceDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['dl']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['dl']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>						
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['physical']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['physical']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['physical']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#physicalFitnessDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['physical']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['physical']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>							
						</tbody>
					</table>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Schholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.</span>
					</div>
										
				 </div>
				 </div>
				 <div class="name-sec col-xs-4 col-sm-2 col-md-6">
	         <div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
			  <a href="javascript:void(0);" onclick="showForwardRegional();" class="form-control sbmt">Process</a>			  
			  </div> 
			 
			                             
      	</div>
      	<div class="name-sec col-xs-4 col-sm-2 col-md-2">
      	 <div class="name-sec col-xs-4 col-sm-2 col-md-12 pull-right">
			  <a href="<?php echo site_url();?>regional/universityapplications1" class="form-control sbmt">Cancel</a>
			  </div>
				</div>
              </div>
              <div class="box-body fade forwarddiv_regional">                       
              <?php echo form_open('regional/forwardtohqrs1/'.$this->uri->segment(3),array('enctype'=>'multipart/form-data')); ?>
              <div class="form-group col-xs-3">
					    <label for="inputEmail3" class="col-sm-7 control-label">University Status  <span class="text-red">*</span></label>
					    <div class="col-sm-5">
					      <select id="university_is_accept" name="university_is_accept" class="form-control" required="true">
					      	<option value="">Select</option>
					      	<option value="1">Yes</option>
					      	<option value="2">No</option>
					      </select>
					    </div>
					</div>
              		<div class="form-group col-xs-5">
					    <label for="inputEmail3" class="col-sm-5">Confirmed/Not-Confirmed by  <span class="text-red">*</span></label>
					    <div class="col-sm-7">
					      <select id="regional_university" name="regional_university" class="form-control" required="true" onchange="getCoursename(this.id);">
					      	<option value="">Select</option>
					      	 <?php					      	 
					      	  foreach($universityarray as $key=>$uni)
					      	  {
							  	echo '<option value="'.$key.'">'.$uni.'</option>';
							  }
					      	 ?>
					      </select>
					    </div>
					</div>
					<div class="form-group col-xs-4">
					    <label for="inputEmail3" class="col-sm-5">Course  <span class="text-red">*</span></label>
					    <div class="col-sm-7">
					      <select id="course" name="course" class="form-control" required="true">
					      	<option value="">Select</option>					      	
					      </select>
					    </div>
					</div>
              		
              		
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Upload Letter  <span class="text-red">*</span></label>
					    <div class="col-sm-8">
					      <input type="file" accept="application/pdf"  required="true" id="inputfile_regional" name="inputfile_regional"/>
					    </div>
					</div>
					<div class="form-group col-xs-6">
					 <label for="inputEmail3" class="col-sm-5">Enter University Confirmed Couse<span class="text-red">*</span></label>
					<input type="text" class="form-control" name="confirmedCourse" id="confirmedCourse" required="true"/>
					</div>
					 <div class="form-group col-xs-3">
					    <label for="inputEmail3" class="col-sm-7 control-label">College(Govt/Private)<span class="text-red">*</span></label>
					    <div class="col-sm-5">
					      <select id="is_gov_private" name="is_gov_private" class="form-control" required="true">
					      	<option value="">Select</option>
					      	<option value="1">Govt</option>
					      	<option value="2">Private</option>
					      </select>
					    </div>
					</div>
					<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">				
				 		<input type="submit" class="form-control sbmt" value="Confirm to Mission"/>
              		</div> 
              		<?php echo form_close(); ?>
              </div>
              <!-- /.box-body -->
		
	  </div>	
	     
	</div>
	</div>
</section>
<script type="text/javascript">
	function getCoursename(id)
	{
		var uniid = $('#' + id).val();
		if(uniid != "")
		{
			var appid = $('#approvedappId').val();
			$.ajax({
			    type: "POST",
			    url: baseURL +'regional/getCourseDetail',	   
			    data: {'uniid':uniid,'appid':appid},
			    dataType:'json',		    
			    success: function (data) {			    	
			    	
						var htmll = "";
						htmll += "<option selected='selected' value='" + data.course_name + " " +data.subject +"'>" + data.course_name + " " +data.subject + "</option>";
						$('#course').html(htmll);
					
			    }
			});
		}
		    	
	}
</script>
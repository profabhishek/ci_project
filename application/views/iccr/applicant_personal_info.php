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
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding-top:0px;">	
	<form method="post" action="<?php echo base_url();?>headquarter/downloadApplication" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
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
              			if($userImage == "")
              			{
						?>
						<img id="profil_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png"/>
						<?php	
						}
						else
						{
						?>
						<img id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
						<?php		
						}
              		?>
              	</div>
              	<div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">              		
	              	<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<label style="font-size:18px; padding-bottom: 20px;">Application Made Through: <?php
							 	foreach($missions as $mission)
	       						{
	       							if(!empty($applicaitonStepOne))
							  		{
										if($applicaitonStepOne[0]['application_through'] == $mission['id'])
										{
											echo $mission['country_name'].'</b> '.$mission['mission_type'].' '.$mission['mission_name'];
										}										
									}	
	       						}	
							 	?>	</label>				
						
					</div>	
					<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<label>1. Full name (IN BLOCK LETTERS)</label>
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
					 <label for="comment">9. Level</label>
						<div class="form-group col-md-10 pdleft">						 
						  	<?php 
						  		$programme = $this->common_model->getAllProgramme();
						  		foreach($programme as $program)
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
					<div class="name-sec col-xs-12 col-sm-3 col-md-5 pdleft">
					 <label for="comment">Name of course you wish to study</label>
						<div class="form-group col-md-10 pdleft">						  	
						  	<?php 
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
						  	?>					 	
						 
						</div>
					</div>			
				</div>
				<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-12 pdleft">
					 <label for="comment">10. Univesities/Institutes in India where you wish to seek admission:</label>
					 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12 pdleft">					
					<div class="form-group">
						<span class="note1"><strong>Note: </strong>ICCR provides scholarships only for courses in central or state goverment universities. Candidates should be very specific and clear about the course of study which he/she wishes to pursue in India. Scholarships are not available to pursue more than one course. Candidates should ensure that the courses listed here are offered by all three Universities listed under S.No.10. The candidates must refer to the University/Institute website to know the eligibility criteria for the courses of their choice. Those seeking admission to agricultural courses must opt for ICAR in the University choice.</span>
					</div>										
				 </div>
				 </div>
						<div class="form-group col-md-4 pdleft">
						 	<?php							
							foreach($univercities as $univercity)
							{								
								if(!empty($applicaitonStepOne))
							  	{
									if($applicaitonStepOne[0]['universty_choice'] == $univercity['id'])
									{
										echo '<b>University Selection One:</b><br/> '.$univercity['name'];
									}									
								}								
						    } 
						    ?>
						</div>						
						<div class="form-group col-md-4 pdleft">
						 	 <?php
						 	 $univercitie_two = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],0);
						 	 foreach($univercitie_two as $univercity1)
							 {
							 	if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['universty_choice_two'] == $univercity1['id'])
							  		{
										echo '<b>University Selection Two: </b><br/>'.$univercity1['name'];
									}									
								}								
							 }	
						 	 ?>
						</div>
						<div class="form-group col-md-4 pdleft">							
						 	  <?php
						 	 $univercitie_two = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],$applicaitonStepOne[0]['universty_choice_two']);
						 	 foreach($univercitie_two as $univercity1)
							 {
							 	if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['universty_choice_three'] == $univercity1['id'])
							  		{
										echo '<b>University Selection Three:</b> <br/>'.$univercity1['name'];
									}									
								}								
							 }	
						 	 ?>					 	
						 
						</div>
					</div>
					
				</div>
				
										
					
				</div>	
				 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">				
						<div class="form-group">
						<span class="note1"><strong>Note: </strong>Once admission is confirmed, no change in either course or University/Institute will be permitted by the Council.
						<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allotment of colleges is done by the respective Universities.</span><br/>						
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
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
						<div class="form-group">
							<span class="note1"><strong>Note: </strong>(Details of any course in Indian Universities/Institutes which the scholar is currently attending or has attended in past may be given below.)</span>
						</div>											
				 	</div>
				 </div>  	
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table class="table">
						<thead>
							<th>Year</th>							
							<th>Name of School/University/Board</th>
							<th>Course</th>
						</thead>
						<tbody>
							<tr>
								<td><?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course_year'];?></td>
								<td><?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course_university'];?></td>
								<td><?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course'];?></td>							
							</tr>							
						</tbody>
					</table>
				</div>
              </div>	   
<div class="box-body">
              	 <div class="name-sec col-xs-12 col-sm-5 col-md-12 pdleft">
					<h4>12. Give below the names of two persons who have agreed to testify from their personal knowledge to your character (they must not be related to you and should have direct knowledge of your academic pursuits).</h4>
				</div> 
				<div class="passport-sec col-xs-12 col-sm-12 col-md-6 pdleft pdright" style="background: rgb(244, 244, 244) none repeat scroll 0% 0%; border: 1px solid rgb(206, 206, 206); margin-right: 0px;padding-top: 20px;">
				<div class="name-sec col-xs-12 col-sm-3 col-md-6">
				<label for="comment"><u>Reference 1</u></label>
				</div>
					<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Name</label>
                   <div class="form-group date">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_name'];?>
                   </div>
                </div> 
                 <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Occupation</label>
                   <div class="form-group">
                     <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation'];?>
                   </div>
                </div>        	
               </div> 
               <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
               	<div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Email</label>
                   <div class="form-group">
                     <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_email'];?> 
                   </div>
                </div>              
                <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Telephone</label>
                   <div class="form-group">
                     <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_phone'];?>
                   </div>
                </div> 
               </div>
               <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
               	<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment"> Postal Address</label>	
							<div class="form-group col-md-12 pdleft">							
						  <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address'];?>
					</div>				
				 </div>
				</div>				
               </div>
				</div> 
				<div class="passport-sec col-xs-12 col-sm-12 col-md-6 pdleft pdright" style="background: rgb(244, 244, 244) none repeat scroll 0% 0%; border: 1px solid rgb(206, 206, 206); margin-right: 0px;padding-top: 20px;">
				<div class="name-sec col-xs-12 col-sm-3 col-md-6">
				<label for="comment"><u>Reference 2</u></label>
				</div>
					<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-6 col-md-6">
                   <label for="comment">Name</label>
                   <div class="form-group date">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_name'];?>
                   </div>
                </div>
                	 <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Occupation</label>
                   <div class="form-group">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation'];?>
                   </div>
                </div> 
                <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Email</label>
                   <div class="form-group">
                     <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_email'];?>
                   </div>
                </div> 
                <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Telephone</label>
                   <div class="form-group">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_phone'];?>
                   </div>
                </div> 
                <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
               	<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment"> Postal Address </label>	
							<div class="form-group col-md-12 pdleft">							
						  <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_address'];?>
					</div>				
				 </div>
				</div>
               </div>        	
               </div> 
				</div> 
				
 				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>13. Details of close relative(s) or friends, if any, in India.</h4>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Name</label>
                   <div class="form-group date">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_name'];?>
                   </div>
                </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Relationship</label>
                   <div class="form-group">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_relation'];?>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Occupation</label>
                   <div class="form-group">
                     <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_designation'];?>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Postal Address</label>
                   <div class="form-group date">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_address'];?>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Tel No.</label>
                   <div class="form-group">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_contact'];?>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Email</label>
                   <div class="form-group">
                      <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_email'];?>
                   </div>
                </div>               	
               </div> 
				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">14. Have you travelled or lived in India in the past?</label>
						<div class="form-group">
						<?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['is_travel_or_live_in_india_before'] == 1){
								echo 'Yes';
						  	}
							elseif($applicaitonStepThree[0]['is_travel_or_live_in_india_before'] == 2){
						echo 'No';
							}
						}
						?>
						  
						</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-6">
					 <label for="comment">15. Have you ever availed of ICCR Scholarship earlier?</label>
						<div class="form-group">
						<?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 1){
								echo 'Yes';
							}
							elseif($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 2){
								echo 'No';
							}
						}
						?>
						 
						</div>
				</div>					
				</div>
				<?php
				if(!empty($applicaitonStepThree))
				{
					if($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 1){
					?>
					<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright iccr_scholar">				 			 
					<div class="name-sec col-xs-12 col-sm-6 col-md-2">
					 <label for="comment">Year of Scholarship</label>
						<div class="form-group">
						  <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_year'];?>
						</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">Name of Course</label>
						<div class="form-group">
						<?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['iccr_scholar_course'] == 1){
								echo 'UG';
							}
							elseif($applicaitonStepThree[0]['iccr_scholar_course'] == 2){
								echo 'PG';
							}
							elseif($applicaitonStepThree[0]['iccr_scholar_course'] == 3){
								echo 'Ph.D.';
							}
							elseif($applicaitonStepThree[0]['iccr_scholar_course'] == 4){
								echo 'Other';
							}
						}						
						?>						  
						</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-3">
					 <label for="comment">Name of Institue/University</label>
						<div class="form-group">
						  <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_institute'];?>
						</div>
				</div>	
				 <div class="name-sec col-xs-12 col-sm-3 col-md-4">
					 <label for="comment">Duration of stay in India on Scholarship</label>
						<div class="pdleft col-md-6">
						<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_from'];?>
						</div>
						<div class="pdleft col-md-6">
						<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_to'];?>
						</div>
				</div>				
				</div>
					<?php			
					}
				}
				?>				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-5">
					 <label for="comment">16. Are you currently a resident in India?</label>
						<div class="form-group">
						<?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['currently_non_nri'] == 1){
								echo 'Yes';
							}
							elseif($applicaitonStepThree[0]['currently_non_nri'] == 2){
								echo 'No';
							}
						}						
						?>						 
						</div>
				 </div>
				 	<?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['currently_non_nri'] == 1){
								?>
								 <div class="name-sec col-xs-12 col-sm-3 col-md-7 fade in is_indian_address">
									 <label for="comment">Postal Address</label>
										<div class="pdleft col-md-12">
										<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['currently_non_nri_address'];?>
										</div>
										
								</div>
								<?php
							}
						}										
					?>							
				</div>				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-3 col-md-5">
					 <label for="comment">17. Do you have an International driving licence?</label>
						<div class="form-group">
						<?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['is_international_lic'] == 1){
								echo 'Yes';
						  
							}
							elseif($applicaitonStepThree[0]['is_international_lic'] == 2){
								echo 'No';
							}
						}						
						?>						  
						</div>
				</div>
				<?php
				if(!empty($applicaitonStepThree))
				{
					if($applicaitonStepThree[0]['is_international_lic'] == 1){
						?>
				<div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade in">
					<label for="comment">Licence Number</label>
					<div class="form-group">
					   <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_no'];?>					   
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade in">
					<label for="comment">Issuing Authority</label>
					<div class="form-group">
					   <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_auth'];?>					   
					</div>
				 </div>	
						<?php
					}
				}				
				?>		
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">18. Any Other Information.</label>
						<div class="form-group">
						  <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['any_other_info'];?>
						</div>
				 </div>			
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">Date: <?php echo date('d-m-Y');?></label>
						
				 </div>			
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-4">
					 
						<div class="form-group">
						 <label for="comment" style="float: left;width:20%;">Place: </label> <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['place'];?>
						</div>
				 </div>
				    <div class="name-sec col-xs-12 col-sm-6 col-md-3 pull-right">
					 	
						<div class="form-group">
						  <?php 
						  if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['signature_doc'] != "")
						  {
						  ?>
						 
						  <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonStepThree[0]['signature_doc']; ?>" target="_blank" title="Click to View Signature"><img  style="border:1px solid #cecece;padding:2px;width:150px;max-height:80px;"  src="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonStepThree[0]['signature_doc']; ?>"/></a><br/>Signature
						
						  <?php	
						  }						 
						  ?>						 
						  
						</div>
				 </div>
				  			
				</div>
				  <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and that I have understood the financial terms and conditions of the Schholarship Scheme. I hereby undertake to abide by them, and I also undertake to return to my country after completion of my studies in India.</span>
					</div>
										
				 </div>
				 </div>				
              </div>

	</div>
	</div>
	<?php 
	
	$docsArray = array();
	if(count($applicaitonDocuments) > 0)
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
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['phd_leaving_country'] != "" && $applicaitonStepTwo[0]['phd_leaving_country'] > 0)
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
      	
              </div>
            
              <!-- /.box-body -->
		
	  </div>	
	     
	</div>
	</div>
</section>
	
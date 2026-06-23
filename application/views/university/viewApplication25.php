<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:178px;width:159px;text-align: center;padding:0;}
.prfl img{;margin-bottom:8px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
#fbl_main tbody tr td:first-child{
	width: 279px !important;
}
optgroup[label]{ color: #4e7a9f;
    font-size: 20px;
    padding-left: 10px;
    padding-top: 10px;
    text-decoration: underline;}
optgroup option{color:#747474; font-size: 14px;}
</style>
<?php 
$stateuniversities = $this->common_model->getStateUniversities();
$centraluniversities = $this->common_model->getCentralUniversities();
$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states =  $this->common_model->getAllStates();
$statewiseUniversites = array();
foreach($states as $st)
{
	if(!array_key_exists($st['id'],$statewiseUniversites))
	{
		$statewiseUniversites[$st['id']] = array();
	}
}
//print_r($states);
$stateuniversities_one = str_replace("'","\'",json_encode($stateuniversities));
$centraluniversities_one = str_replace("'","\'",json_encode($centraluniversities));
$nits_one = str_replace("'","\'",json_encode($nits));
$yogas_one = str_replace("'","\'",json_encode($yogas));
$states_array = json_encode($statewiseUniversites);
?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
var centralUniversities = JSON.parse('<?php echo $centraluniversities_one;?>');
var nits = JSON.parse('<?php echo $nits_one;?>');
var yogas = JSON.parse('<?php echo $yogas_one;?>');
var statesarray = JSON.parse('<?php echo $states_array;?>');
</script>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding-top:0px;">	
	<form method="post" action="<?php echo base_url();?>mission/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
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
						<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png"/>
						<?php	
						}
						else
						{
						?>
						<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
						<?php		
						}
              		?>
              	</div>
              	<div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">
					<table id="fbl_main" style="width: 100%;">
						
						<tbody>
						<tr>
							<td style="font-weight:bold;"><label id="lbl" style="">Application Made Through</label>				</td>
							<td colspan="2"><label>:&nbsp;&nbsp;<?php
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
							 	?>	</label></td>
							 	</tr>
							<tr >
								<td style="height:35px;font-weight:bold;"><label>1. Full name (IN BLOCK LETTERS)</label></td>
								<td align="left" style="height:35px;">:&nbsp;&nbsp;<?php $title = '';
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
					   <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['fullname'];?>	</td>
							</tr>
							<tr >
								<td style="font-weight:bold;height: 35px;"><label>2. Gender</label></td>
								<td>:&nbsp;&nbsp;<?php $title = '';
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
					  ?></td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>3. Date of Birth</label></td>
											<td>:&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo date("d/m/Y", strtotime($applicaitonStepOne[0]['dob']));?>
										
								</td>
								</tr>
								<tr>
								<td style="height:35px;font-weight: bold;">
								<label>4. Country</label></td>
											<td>:&nbsp;&nbsp;<?php
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $na)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['country'] == $na['id'])
								{
									echo $na['country_name'];
								}
							}
						  }
						  ?>
								 	</td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>5. Country of Residence</label></td>
											<td>:&nbsp;&nbsp;<?php
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
						  ?></td>
															
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><label for="comment">6. Passport No</label></td>
								<td style="height:35px;">:&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_no'];?></td>
							</tr>
							<tr>
								<td style="height:35px;" colspan="2">
								<table id="tblpassport" class="table" style="width: 100%;">
									<thead>
										<th style="width:150px; ">a) Date of Issue</th>
										<th style="width:150px; ">b) Date of Expiry</th>
										<th style="width:150px; ">c) Place of Issue</th>
									</thead>
									<tbody>
										<tr>
											<td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_date']; ?></td>
											<td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_expiry_date']; ?></td>
											<td ><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place'];?></td>
										</tr>
									</tbody>
								</table>
							
								</td>
								
															
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>7. Postal Address</label>
								</td>
								<td>:&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address'];?></td>	
								
							</tr>
							<tr>
							<td colspan="2">
								<table id="tblpassport" class="table" style="width: 100%;">
									<thead>
										<th style="width:150px; ">a)City</th>
										<th style="width:150px; ">b) State</th>
										<th style="width:150px; ">c) Country</th>
										<th style="width:150px; ">d) Zipcode</th>
									</thead>
									<tbody>
										<tr>
											<td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_city'];?></td>
											<td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_state'];?></td>
											<td ><?php
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
											  ?></td>
											  <td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_pincode'];?></td>
										</tr>
									</tbody>
								</table>
								</td>
								</tr>					
						
							
							<tr>
								<td style="min-height:35px;font-weight: bold;">
									<label><b>8. Contact Details </b></label>
								</td>
																
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><b>Contact No</b></td>
								<td style="height:35px;">:&nbsp;&nbsp;+<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['tel_country_code'];?>&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['phone'];?></td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><b>Email Id</b>
								</td>
								<td style="height:35px;">:&nbsp;&nbsp;<?php 
								//print_r($registerData);
								if(!empty($registerData)) echo $registerData[0]['email_id'];?></td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
									<label>Permanent Unique ID </label>
								</td>
								<td style="height:35px;">
									:&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['unique_id'];?>
								</td>
							</tr>
							<tr>
							<td style="font-weight: bold;"><label>Details of Father/Guardian</label></td></tr>							
							<tr>
								
								<td colspan="2" style="height:35px;" >
								
								<table id="tbl_father" class="table" style="width:100%;">
									<thead>
										<th>Name</th>
										<th>Relation</th>
										<th>Occupation</th>
										<th>Country</th>
									</thead>
									<tbody>
										<tr>
											<td ><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_name'];?>	 </td>
											<td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_relation'];?></td>
											<td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_occupation'];?></td>
											<td><?php
									  $nationalities = $this->common_model->getCountries();
									  foreach($nationalities as $na)
									  {
									  	if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['guardian_nationality'] == $na['id'])
											{
												echo $na['country_name'];
											}
										}
									  }
									  ?></td>
										</tr>
									</tbody>
								</table>
								</td>
							</tr>						
							<tr>
								<td style="height:35px;font-weight: bold;"><label for="comment">Address</label>
								
								
								</td>
								<td>:&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_address'];?></td>
							</tr>
							<tr>
								<td colspan="2">
									<table id="tbl_gaurdian" style="width: 100%;">
										<thead>
											<th>City</th>
											<th>State</th>
											<th>Country</th>
											<th>Zincode</th>
										</thead>
										<tbody>
											<td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_city'];?></td>
											<td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_state'];?></td>
											<td><?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
								  	if(!empty($applicaitonStepOne))
								  	{
										if($applicaitonStepOne[0]['gardiuan_address_country'] == $country['id'])
										{
											echo $country['country_name'];
										}
									}
								  }
								  ?></td>
								  <td><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_pincode'];?></td>
										</tbody>
									</table>
								</td>
							</tr>
							
							<tr>
								<td style="font-weight: bold;"><b>8. Knowledge of English</b></td>
								<td style="height:35px;max-width:120px">:
							 <?php $knowledge = '';
								  if(count($applicaitonStepOne) > 0)
								  {
								  	$knowledge = $applicaitonStepOne[0]['knowledge_english'];
								  }						  
								  if($knowledge == 1)
								  {
								  	echo "Yes";
								  }
								  elseif($knowledge == 2)
								  {
									 echo "No";	
								  }
							  ?>							
								</td>
							</tr>
							<tr>
								<td style="height:35px;max-width:120px;font-weight: bold;"><b>Written:</b>
								<?php
							 	if($knowledge == 1)
								{					
									if($applicaitonStepOne[0]['knowledge_english_written'] == 1)
									{
									  echo "Average";						 	
									}
									elseif($applicaitonStepOne[0]['knowledge_english_written'] == 2)
									{
										echo "Proficient";						   
									}
									elseif($applicaitonStepOne[0]['knowledge_english_written'] == 3)
									{
										echo "Good";
									}
								}
									?>		
								</td>
								<td style="height:35px;max-width:120px;font-weight: bold;">
								<b>Spoken:</b>
							 <?php
							 	if($knowledge == 1)
								{					
									if($applicaitonStepOne[0]['knowledge_english_spoken'] == 1)
									{
									  echo "Average";						 	
									}
									elseif($applicaitonStepOne[0]['knowledge_english_spoken'] == 2)
									{
										echo "Proficient";						   
									}
									elseif($applicaitonStepOne[0]['knowledge_english_spoken'] == 3)
									{
										echo "Good";
									}
								}	
									?>							
								</td>
							</tr>
								<tr>
								<td colspan="2" style="height:35px;max-width:120px">
								<table style="width:100%;" id="tbl_course">
									<thead>
										<th>9. Level of Programme</th>
										<th>Name of course you wish to study </th>
									</thead>
									<tbody>
										<tr>
											<td><?php 
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
						  	?></td>
						  	<td>
						  		<?php 
					if($applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7)
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
					else
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
					if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							if($applicaitonStepOne[0]['programme'] == 1)
							{
								if($applicaitonStepOne[0]['course'] > 0 && ($applicaitonStepOne[0]['course'] == 13 || $applicaitonStepOne[0]['course'] == 12))
								{
									if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name'];
										
								}								 	
							}
							if($applicaitonStepOne[0]['programme'] == 2)
							{
								if($applicaitonStepOne[0]['course'] > 0 && ($applicaitonStepOne[0]['course'] == 21 || $applicaitonStepOne[0]['course'] == 26 || $applicaitonStepOne[0]['course'] == 25))
								{									
									if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name'];
								}								 	
							}
							if($applicaitonStepOne[0]['programme'] == 4)
							{									
								if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name'];
							}
						}
					?>
						  	</td>
										</tr>
									</tbody>
								</table>
								</td>
							</tr>
							<tr>
								<td style="height:35px;max-width:120px;font-weight: bold;" colspan="2"><label>10. Univesities/Institutes in India where you wish to seek admission:</label></td>
							</tr>
							<tr>
								<td colspan="2" ><span class="note1"><strong>Note: </strong>ICCR provides scholarships only for courses in central or state goverment universities. Candidates should be very specific and clear about the course of study which he/she wishes to pursue in India. Scholarships are not available to pursue more than one course. Candidates should ensure that the courses listed here are offered by all three Universities listed under S.No.10. The candidates must refer to the University/Institute website to know the eligibility criteria for the courses of their choice. Those seeking admission to agricultural courses must opt for ICAR in the University choice.</span></td>
							</tr>
							<tr>
								<td colspan="3">
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
								</td>
								
							</tr>
							<tr>
								<td colspan="2">
									<span class="note1"><strong>Note: </strong>&nbsp;&nbsp;&nbsp;Once admission is confirmed, no change in either course or University/Institute will be permitted by the Council.
						<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allotment of colleges is done by the respective Universities.
						</span>
						<br/>						
						<?php 
								if(!empty($applicaitonStepOne)) 
								{
									 if($applicaitonStepOne[0]['agreedisagree'] != "")
									 {
									 	if($applicaitonStepOne[0]['agreedisagree']==1)
									 	{
											echo "I agree : Yes";
										}
										elseif($applicaitonStepOne[0]['agreedisagree']==2)
									 	{
											echo "I disagree : Yes";								
										}
									 }
								}
								?>
								</td>
							</tr>
						</tbody>
					</table>
						
              </div>
              <div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">   
					
				</div>
				
              <!-- /.box-body -->
           
	  </div>
<div class="box-body">  
				 <div class="name-sec col-xs-12 col-sm-5 col-md-7 pdleft">
					<label class="scfont">11. Previous Educational Qualifications  </label>
				</div> 
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table id="tbl_edu" class="table" style="width:100%;">
						<thead>
							<th>Certificate/Degree</th>
							<th>Country</th>
							<th>Name of School/University/Board</th>
							<th>Year</th>
							<th >Percentage(%)/Grade</th>
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
								<td >
								   
			                         
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
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>
								</td>
								<td >
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
								<td >
								   
			                         
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
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>
								</td>
							</tr>
							<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)</td>
								<td >
								   
			                         
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
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>
								</td>
								<td>
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>
								</td>
								<td >
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
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>
								</td>
							</tr>
								<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)</td>
								<td >
								   
			                         
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
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>
								</td>
							</tr>
								<tr>
							<td>Post graduate<br/>(Two years University education after graduation or five years after class XII.)</td>
								<td >								   
			                        
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
								<td >
								 <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_university'];?>
								</td>
								<td>
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_year'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_percentage'];?>
								</td>
							</tr>
								<?php
								break;
								case "Ph.D":
								?>
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India)</td>
								<td >
								   
			                         
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
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>
								</td>
							</tr>
								<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)</td>
								<td >
								   
			                         
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
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>
								</td>
							</tr>
								<tr>
							<td>Post graduate<br/>(Two years University education after graduation or five years after class XII.)</td>
								<td >
								   
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
								<td >
								 <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_university'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_year'];?>
								</td>
								<td >
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
				
				<?php 
				if(!empty($applicaitonStepTwo) && $applicaitonStepTwo[0]['other_course_year'] != "" && $applicaitonStepTwo[0]['other_course_university'] != "" && $applicaitonStepTwo[0]['other_course'] != "") 
				{
				?>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
						<div class="form-group">
							<span class="note1"><strong>Note: </strong>(Details of any course in Indian Universities/Institutes which the scholar is currently attending or has attended in past may be given below (Optional).)</span>
						</div>											
				 	</div>
				 </div>  	
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table id="tbl_optional" class="table" style="width:100%;">
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
				<?php					
				}
				?>
					
				
              </div>	   
				<div class="box-body">
              	 <div class="name-sec col-xs-12 col-sm-5 col-md-12 pdleft">
					<label >12. Give below the names of two persons who have agreed to testify from their personal knowledge to your character (they must not be related to you and should have direct knowledge of your academic pursuits).</label>
					</div>
				
				
				 <div class="name-sec col-xs-12 col-sm-5 col-md-12 pdleft">
					<label style="font-weight: bold;">Reference 1</label>
					</div>
				<table id="tbl_ref1" class="table" style="width:100%;">
				<thead>
					<th>Name</th>
					<th>Occupation</th>
					<th>Email</th>
					<th>Telephone</th>
					<th colspan="2">Postal Address</th>
				</thead>
					<tbody>
					<tr>
										<td> <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_name'];?></td>
										<td>
											<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_designation'];?>
										</td>
										<td> <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_email'];?> </td>
										<td> <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_phone'];?></td>
										<td colspan="2"><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address'];?></td>
									</tr>
						<tr>
							
							
						</tr>
					</tbody>	
				</table>
				<br/>
				 <div class="name-sec col-xs-12 col-sm-5 col-md-12 pdleft">
					<label style="font-weight: bold;">Reference 2</label>
					</div>
				<table style="width:100%;" id="tbl_ref2" class="table">
					<thead>
					<th>Name</th>
					<th>Occupation</th>
					<th>Email</th>
					<th>Telephone</th>
					<th colspan="2">Postal Address</th>
				</thead>
					<tbody>
						<tr>
							<td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_name'];?></td>
							<td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation'];?></td>
							<td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_email'];?> </td>
							<td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_phone'];?></td>
							<td colspan="2"> <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_address'];?></td>							
						</tr>
					</tbody>
				</table>
				<br/>
				<table style="width:100%;">
					<tbody>
						<tr>
							<td>
								<label> 13. Details of close relative(s) or friends, if any, in India.</label>
							</td>
						</tr>
						<tr>
							<td>
								<table id="tbl_relation" class="table" style="width:100%;">
								<thead>
									<th>Name</th>
									<th>Relationship</th>
									<th>Occupation</th>
									<th>Telephone</th>
									<th>Email</th>
									<th>Postal Address</th>
								</thead>
					<tbody>
						<tr>
							<td style="height: 27px;">
								 <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_name'];?>
							</td>
							<td style="height: 27px;">
								<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_relation'];?>
							</td >
								<td  style="height: 27px;">
								 <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_designation'];?> 
							</td>
							<td style="height: 27px;">
								 <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_contact'];?>
							</td>
							<td style="height: 27px;">
								 <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_email'];?>
							</td>
							<td style="height: 27px;">
								
								<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address'];?>
							</td>
						</tr>
						<tr>
						</tr>
					</tbody>
				</table>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="height: 35px;">
								<label>14. Have you travelled or lived in India in the past?</label>&nbsp;&nbsp;
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
							</td>							
						</tr>
						<tr>
							<td colspan="2" style="height: 35px;">
								<label>15. Have you ever availed of ICCR Scholarship earlier?</label>&nbsp;&nbsp;
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
						 
							</td>							
						</tr>
						<?php
							if(!empty($applicaitonStepThree))
							{
								if($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 1){
								?>
								<tr>
							<td>
								<table id="tbl_schrls" style="width:100%;" class="table">
								<thead>
										<th>Year of Scholarship</th>
										<th>Name of Course</th>
										<th>Name of Institue/University</th>
										<th>Duration of stay in India on Scholarship</th>
									</thead>
					<tbody>
						<tr>
							<td style="height: 35px;">
								 <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_year'];?>
							</td>
							<td style="height: 35px;">
								
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
							</td>
								<td  style="padding-left:10px;height: 35px;">
								 
								<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_institute'];?>
							</td>
							<td style="height: 35px;">
								
								 <?php
								  if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_from']; 
								 echo '-';
								 if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_to'];
								 ?>
							</td>
						</tr>
						<tr>
						</tr>
					</tbody>
				</table>
							</td>
						</tr>
								<?php	
								}	
							}
						 ?>
						<tr>
							<td style="height: 35px;">
								<label>16. Are you currently a resident in India?</label>&nbsp;&nbsp;
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
							</td>
						</tr>
						<?php
							if(!empty($applicaitonStepThree))
							{
								if($applicaitonStepThree[0]['currently_non_nri'] == 1){
									?>
									 <tr>
									 <td>
										 <label for="comment">Postal Address</label>
											
											<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['currently_non_nri_address'];?>
										
										</td>	
									</tr>
									<?php
								}
							}										
						?>	
						<tr>
							<td style="height: 35px;">
								<label>17. Do you have an International driving licence?</label>&nbsp;&nbsp;
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
							</td>
						</tr>
						<?php
							if(!empty($applicaitonStepThree))
							{
								if($applicaitonStepThree[0]['is_international_lic'] == 1){
									?>
									<tr>
										<td colspan="1" style="height: 35px;">
										<table style="width:100%;">
											<tbody>
												<tr>
													<td style="font-weight:bold;">Licence Number:</td>
													<td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_no'];?>					   </td>
													<td style="font-weight:bold;">Issuing Authority:</td>
													<td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_auth'];?></td>
												</tr>
											</tbody>
										</table>	
										</td>
																
									 </tr>
									<?php
								}
							}				
							?>
							<tr>
								<td style="height: 35px;font-weight: bold;"><label>18. Any Other Information.</label></td>
							</tr>	
							<tr>
								<td> <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['any_other_info'];?></td>
							</tr>	
							<tr>
								<td  style="height: 25px;font-weight: bold;"><label>Date: <?php echo date('d-m-Y');?></label></td>
								
							</tr>
							<tr><td  style="height: 25px;font-weight: bold; text-align: left;"> 
								<label for="comment" >Place: </label> <?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['place'];?>
									
								</td></tr>							
							<tr>
								<td>
									<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and that I have understood the financial terms and conditions of the Schholarship Scheme. I hereby undertake to abide by them, and I also undertake to return to my country after completion of my studies in India.</span>
								</td>
							</tr>
							
							<tr>
								<td style="text-align:right;"><?php 
						  if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['signature_doc'] != "")
						  {
						  ?>
						 
						  <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonStepThree[0]['signature_doc']; ?>" target="_blank" title="Click to View Signature"><img  style="padding:2px;width:150px;max-height:50px;" src="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonStepThree[0]['signature_doc']; ?>"/></a><br/>
						
						  <?php	
						  }						 
						  ?>	</td>
							</tr>
							<tr>
								<td style="text-align:right;">
									<label>Signature</label>									 
								</td>
								
							</tr>
					</tbody>
				</table> 				
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
	<div class="tab-content docsdiv">		
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
							<?php							
							if(count($docsArray) > 0 && array_key_exists($doctypes['tl']['type'],$docsArray))
							{	
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['tl']['title'];?></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['tl']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['tl']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#translationDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['tl']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['tl']['type']]['time']);	
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
						</tbody>
					</table>
				</div>
				 
              <div class="box-body">
              	<table class="table" id="tbl_relation" style="width:100%;">
              		<thead>
              			<th>19. Status</th>
              			
              		</thead>              		
              	</table>
              	<table class="table" id="tbl_relation" style="width:100%;">
              		<thead>
              			<th>University Name</th>
              			<th>Course</th>
              			<th>Scheme</th>
              			<th>ICCR Regional Office</th>
              			<th>Date of Forwarding</th>
              			<th>University Letter</th>
              			<th>University Response</th>
              		</thead>
              		<tbody>
              			<?php
              			$data = $this->common_model->isAnyUniversityResponseConfirm($this->uri->segment(3),$regionId);
              			if(count($data)>0)
              			{
							?>
								<tr>
              				<td>
              					<?php
              					$univ = $this->common_model->getUniversityById($data[0]['regional_university']);
              					echo $univ[0]['name'];
              					?>
              				</td>
              				<td>
              					<?php
              					echo $this->common_model->getCourseName($applicaitonStepOne[0]['application_no'],$data[0]['regional_university']);
              					
              					?>
              				</td>
              				<td>
              					<?php
              					$sch = $this->common_model->getSchemeById($mappingData[0]['scholarship_id']);
              					echo $sch[0]['scheme_name'];
              					?>
              				</td>
              				<td>
              					<?php
              					$reg = $this->common_model->getRegionById($data[0]['region_one_status']);
              					echo $reg[0]['name'];
              					?>
              				</td>
              				<td>
              					<?php              				
              					echo date('d M Y h:i:s A',$data[0]['region_one_status_date']);
              					?>
              				</td>
              				<td>
              					<a target="_blank" href="<?php echo site_url();?>assets/site/main/university_approval/<?php echo  $data[0]['region_one_doc'];?>" target="_blank">Download</a>
              				</td>
              				<td>
              				<?php if($data[0]['university_is_accept'] == 1)
              					  {
									echo "Confirmed";
								  }
								  elseif($data[0]['university_is_accept'] == 2)
              					  {
									echo "Not-Confirmed";
								  }
              				?>
              				</td>
              			</tr>
							<?php
						}
						else
						{
							if(count($universityData)>0)
	              			{
							?>
								<tr>
              				<td>
              					<?php
              					$univ = $this->common_model->getUniversityById($universityData[0]['regional_university']);
              					echo $univ[0]['name'];
              					?>
              				</td>
              				<td>
              					<?php
              					echo $this->common_model->getCourseName($applicaitonStepOne[0]['application_no'],$universityData[0]['regional_university']);
              					
              					?>
              				</td>
              				<td>
              					<?php
              					$sch = $this->common_model->getSchemeById($mappingData[0]['scholarship_id']);
              					echo $sch[0]['scheme_name'];
              					?>
              				</td>
              				<td>
              					<?php
              					$reg = $this->common_model->getRegionById($universityData[0]['region_one_status']);
              					echo $reg[0]['name'];
              					?>
              				</td>
              				<td>
              					<?php              				
              					echo date('d M Y h:i:s A',$universityData[0]['region_one_status_date']);
              					?>
              				</td>
              				<td>
              					<a target="_blank" href="<?php echo site_url();?>assets/site/main/university_approval/<?php echo  $universityData[0]['region_one_doc'];?>" target="_blank">Download</a>
              				</td>
              				<td>
              				<?php if($universityData[0]['university_is_accept'] == 1)
              					  {
									echo "Confirmed";
								  }
								  elseif($mappingData[0]['university_is_accept'] == 2)
              					  {
									echo "Not-Confirmed";
								  }
              				?>
              				</td>
              			</tr>
							<?php	
							}
						}
              			?>
              		</tbody>
              	</table>
              
				<br/>					
      
              </div>
          
              <!-- /.box-body -->
		
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Schholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.</span>
					</div>
										
				 </div>
				 </div>
		<div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
		
	      <!--  <div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">                
				<a href="javascript:void(0);" onclick="applicaiton_process('Rejected','<?php echo $this->uri->segment(3); ?>');" class="form-control sbmt">Rejected</a>				              
	        </div> -->   
	        <!-- <div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
			  <a href="javascript:void(0);" onclick="applicaiton_process('Process','<?php echo $this->uri->segment(3); ?>');" class="form-control sbmt">Process</a>
			  </div> -->                          
      	</div>
		
		
      
              </div>
          
              <!-- /.box-body -->
		
	  </div>	
	     
	</div>
	</div>
</section>
	
	


	
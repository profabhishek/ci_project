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
$user_data = $this->session->userdata('user_data');
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
	
	<div  class="container" style="min-height:410px;padding:0px;">	
	<form method="post" action="<?php echo base_url();?>applicant/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
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
					
						    $user_data = $this->session->userdata('user_data');
							$dir = $user_data['dir'];
							$imgs = file_get_contents($dir.'/'.$userImage);
							//echo $imgs;
							$data = base64_encode($imgs);
							$f = finfo_open();
							$imgdata = base64_decode($data);
                            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
						
                        //$q     = (count(glob("$dir/*")) === 0) ? 'Empty' : 'Not empty';
              			if($userImage == "")
              			{
						?>
						<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png"/>
						<?php	
						}
						
						else
						{
							if($user_data['dir'] == "")
							{
								?>
								<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
								<?php		
							}
							/* if($q=="Empty"){
							?>
								<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
								<?php	
							} */
							else
							{
								?>
								<img style="width:151px;height:171px;" id="profil_image_div" src="data:<?php if(!empty($mime_type)){echo $mime_type;}?>;base64,<?php if(!empty($data)){echo $data;}?>"/>
								<?php	
							}		
						}
						
              		?>
              	</div>
              	<div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">
					<table id="fbl_main" style="width: 100%;">
						
						<tbody>
						<!----<tr>
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
						</tr>--->
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
					   <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['fullname'].' '.$applicaitonStepOne[0]['middlename'].' '.$applicaitonStepOne[0]['familyname'];?>	</td>
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
											<td>:&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['dob'];?>
										
								</td>
								</tr>
								<tr>
								<td style="height:35px;font-weight: bold;">
								<label>4. Country of Residence</label></td>
											<td>:&nbsp;&nbsp;<?php
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $na)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['nationality'] == $na['id'])
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
								<td style="height:35px;">:&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) if($applicaitonStepOne[0]['passport_no'] != "") echo $applicaitonStepOne[0]['passport_no']; else echo "NA";?></td>
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
											<td><?php if(!empty($applicaitonStepOne)) if($applicaitonStepOne[0]['passport_issue_date'] != "") echo $applicaitonStepOne[0]['passport_issue_date']; else echo "NA"; ?></td>
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
										<th style="width:150px; ">a) City</th>
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
									<label><b>8.Telephone/Mobile Number</b></label>
								</td>
																
							
								<tr>
									<td style="min-height:35px;font-weight: bold;">
										<label><b>11. Mobile Number</b></label>
									</td>
									<td style="height:35px;">:&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['tel_country_code']; ?>&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['phone_number']; ?></td>
								</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><b>Email Id</b>
								</td>
								<td style="height:35px;">:&nbsp;&nbsp;<?php if(!empty($registerData)) echo $registerData[0]['email_id'];?></td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
									<label>Permanent Unique ID of your country (Excluding Passport No.)</label>
								</td>
								<td style="height:35px;">
									:&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['unique_id'];?>
								</td>
							</tr>
							<tr>
							<td style="font-weight: bold;"><label>9. Details of Father/Mother/Guardian</label></td></tr>							
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
								<td style="font-weight: bold;"><b>10. Knowledge of English</b></td>
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
							<?php
							if($knowledge == 1)
							{
							?>
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
									<td style="height:35px;max-width:120px;font-weight: bold;">
								<b>Reading:</b>
							 <?php
							 	if($knowledge == 1)
								{					
									if($applicaitonStepOne[0]['knowledge_english_reading'] == 1)
									{
									  echo "Average";						 	
									}
									elseif($applicaitonStepOne[0]['knowledge_english_reading'] == 2)
									{
										echo "Proficient";						   
									}
									elseif($applicaitonStepOne[0]['knowledge_english_reading'] == 3)
									{
										echo "Good";
									}
								}	
									?>							
								</td>
							</tr>
							<?php	
							}	
							?>
							
									<?php if(count($applicaitonStepOne[0]['is_english_proficiency'] == 1))
						{
	 ?> 
	 
	 
	 <tr>
								<td style="font-weight: bold;"><b>11. English Proficiency Test</b></td>
								<td style="height:35px;max-width:120px">:
							 <?php $knowledge = '';
								  if(count($applicaitonStepOne) > 0)
								  {
								  	$knowledge = $applicaitonStepOne[0]['is_english_proficiency'];
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
							<!----Tofel------->
							<?php
									if(count($applicaitonStepOne) > 0)
										  {
											  $knowledge = $applicaitonStepOne[0]['is_english_proficiency'];
											  
											  if($knowledge == 1){ 
												 
												 ?>
												 
											<tr>
												<td style="font-weight: bold;"><b>TOEFL:</b></td>
														<td style="height:35px;max-width:120px">
														
															<?php  
															if(!empty($applicaitonStepOne[0]['toefl_score'])){
																echo $applicaitonStepOne[0]['toefl_score'];
															}
															?>
														
														</td>
												
											</tr>
												 <?php
												 
											  }
										  }
								 ?>
							
							<!-------Tofel End------->
							
							
							<!----------Ielts Start------------->
							
							
							<?php
									if(count($applicaitonStepOne) > 0)
										  {
											  $knowledge = $applicaitonStepOne[0]['is_english_proficiency'];
											  
											  if($knowledge == 1){ 
												 
												 ?>
												 
											<tr>
												<td style="font-weight: bold;"><b>IELTS:</b></td>
														<td style="height:35px;max-width:120px">
														
															<?php  
															if(!empty($applicaitonStepOne[0]['ielts_score'])){
																echo $applicaitonStepOne[0]['ielts_score'];
															}
															?>
														
														</td>
												
											</tr>
												 <?php
												 
											  }
										  }
								 ?>
							
							<!------------Ielts End------------>
							
							
									<!----------Duolingo Score Start------------->
							<?php
									if(count($applicaitonStepOne) > 0)
										  {
											  $knowledge = $applicaitonStepOne[0]['is_english_proficiency'];
											  
											  if($knowledge == 1){ 
												 
												 ?>
												 
											<tr>
												<td style="font-weight: bold;"><b>DUOLINGO:</b></td>
														<td style="height:35px;max-width:120px">
														
															<?php  
															if(!empty($applicaitonStepOne[0]['duolingo_score'])){
																echo $applicaitonStepOne[0]['duolingo_score'];
															}
															?>
														
														</td>
												
											</tr>
												 <?php
												 
											  }
										  }
								 ?>
							
							<!------------Duolingo Score End------------>
							
								
							<?php if(!empty($applicaitonStepOne)) 
							{
								if(!empty($applicaitonStepOne[0]['gmat_score'])){
								
								?>
									<tr>
							<td style="height:35px;max-width:50px;font-weight: bold;" colspan="2"><label id="lbl" style="">   GMAT Score: </label></td>
							<td colspan="2">:&nbsp;&nbsp;
						
							 		
								<?php
									if(!empty($applicaitonStepOne[0]['gmat_score'])){
										echo $applicaitonStepOne[0]['gmat_score'];
										
									}else{
										echo "NA";
									}
									
									
								
								
								?>
							</td>
							</tr>
								<?php
							}
							} 
							
							?>
						
						
					
	 
	 <?php
						}
						?>
							
							
							<tr>
								<td style="height:35px;max-width:120px;font-weight: bold;" colspan="2"><label>12.  Write an essey:</label></td>
							</tr>
							<tr>
								<td colspan="2" ><span class="note1"><strong></strong><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['english_test_essay'];?></span></td>
							</tr>
								<tr>
								<td colspan="2" style="height:35px;max-width:120px">
								<table style="width:100%;" id="tbl_course">
									<thead>
										<th>13. Course applied for</th>
											  		<?php 
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 8)
					{
					
						?>
						<th>Course Type </th>
						<?php
						}
						elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<th>Course Type/Subject </th>
						<?php
					}	
						?>
										
									</thead>
									<tbody>
										<tr>
											<td>
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
						  	?></td>
						  	<td>
						  	<?php 
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
					{
						
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
									
							if($applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4)
							{
								echo $applicaitonStepOne[0]['course_subject'];
							}		
						}
						elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 8)
					{
						echo $applicaitonStepOne[0]['course_subject'];
					}	
						?>
						  		
						  	</td>
										</tr>
									</tbody>
								</table>
								</td>
							</tr>
							<tr>
							
							<?php 
							$user_data = $this->session->userdata( 'user_data' );
						 
						  $student_type = $user_data[ 'student_type' ];
						  $student_course_type = $user_data[ 'apply_course_type' ];
						  $prgid = $user_data[ 'apply_course_type' ];
							if($student_course_type == 11)
							{
								?>
									<td style="height:35px;max-width:120px;font-weight: bold;" colspan="2"><label>14. Univesities/Institutes</label></td>
								<?php
							}
							else
							{
								?>
									<td style="height:35px;max-width:120px;font-weight: bold;" colspan="2"><label>14. Univesities/Institutes in India where you wish to seek admission:</label></td>
								<?php
							}
							?>
							
								
								
							</tr>
							<?php
							$user_data = $this->session->userdata( 'user_data' );
						 
						  $student_type = $user_data[ 'student_type' ];
						  $student_course_type = $user_data[ 'apply_course_type' ];
						  $prgid = $user_data[ 'apply_course_type' ];?>
						  <?php 	if($student_course_type == 11)
						  {
							  ?>
							  <tr>
								<td>
								</td>
							</tr>
							<tr>
								<td></td>
							</tr>
							  <?php
							  
						  }
						  else
						  {
							  ?>
							  <tr>
								<td colspan="2" ><span class="note1"><strong>Note: </strong>ICCR provides scholarships only for courses in central or state goverment universities. Candidates should be very specific and clear about the course of study which he/she wishes to pursue in India. Scholarships are not available to pursue more than one course. Candidates should ensure that the courses listed here are offered by all five Universities listed under S.No.14. The candidates must refer to the University/Institute website to know the eligibility criteria for the courses of their choice. Those seeking admission to agricultural courses must opt for ICAR in the University choice.</span>
								<span>Please select Univesrity in order of preference.</span>
								</td>
							</tr>
							<tr>
								<td colspan="2" ><span class="note1"><strong>Note: </strong>ICCR provides scholarships only for courses in central or state goverment universities. Candidates should be very specific and clear about the course of study which he/she wishes to pursue in India. Scholarships are not available to pursue more than one course. Candidates should ensure that the courses listed here are offered by all five Universities listed under S.No.14. The candidates must refer to the University/Institute website to know the eligibility criteria for the courses of their choice. Those seeking admission to agricultural courses must opt for ICAR in the University choice.</span>
								<span>Please select Univesrity in order of preference.</span>
								</td>
							</tr>
							  <?php
						  }
						  ?>
							
							
							
							<?php $user_data = $this->session->userdata( 'user_data' );
						 
						  $student_type = $user_data[ 'student_type' ];
						  $student_course_type = $user_data[ 'apply_course_type' ];
						  $prgid = $user_data[ 'apply_course_type' ]; ?>
							
								<?php 
						if($student_course_type == 11)
						{
							?>
							
							<tr>
								<td colspan="3">
								<table id="tbl_uni" style="width: 100%;">
										<thead>
										<th>University</th>
											<th>Subject</th>
											<th>Year</th>
											<th>City</th>
										</thead>
										<tbody>
											<tr>
											<td>
											
												<?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);echo $university_second[0]['name'];?>
											</td>
											<td><?php echo $applicaitonStepOne[0]['course_subject']; ?></td>
											<td><?php if($applicaitonStepOne[0]['course_year'] == 1){
												echo "I Year";
											}
											elseif($applicaitonStepOne[0]['course_year'] == 2){
												echo "II Year";
											}
											elseif($applicaitonStepOne[0]['course_year'] == 3){
												echo "III Year";
											}
											?></td>
											<td><?php $regionName = $this->common_model->getRegionById($applicaitonStepOne[0]['region']);
											
											echo $regionName[0]['name'];?></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<?php
							
						}
						else
						{
							
							?>
							
							<tr>
								<td colspan="3">
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
						elseif($applicaitonStepOne[0]['programme'] == 8)
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
									$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course']);
								//echo $strm[0]['name'];
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
						elseif($applicaitonStepOne[0]['programme'] == 8)
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
												if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4 ||  $applicaitonStepOne[0]['programme'] == 8)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_two']);
							if($applicaitonStepOne[0]['course_two'] > 0 && $crs[0]['has_stream'] > 0)
							{
								if(!empty($applicaitonStepOne)) 
									$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course_option_name_two']);
								//echo $strm[0]['name'];
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
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_three']);
							if($applicaitonStepOne[0]['course_three'] > 0 && $crs[0]['has_stream'] > 0)
							{
								if(!empty($applicaitonStepOne)) 
									$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course_option_name_three']);
								//echo $strm[0]['name'];
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
											
											<!----------University 4 Start Here----------->
											<tr>
												<td><?php
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							
					  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
					  		
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course_fourth'] == $course['id'])
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
							  		if($applicaitonStepOne[0]['course_fourth'] == $course['id'])
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
							  		if($applicaitonStepOne[0]['course_fourth'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}
								  	
						}
						?></td>
												<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fourth']);echo $university_second[0]['name'];?></td>
												<td><?php
												if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_fourth']);
							if($applicaitonStepOne[0]['course_fourth'] > 0 && $crs[0]['has_stream'] > 0)
							{
								if(!empty($applicaitonStepOne)) 
									$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course_option_name_fourth']);
								//echo $strm[0]['name'];
								echo $applicaitonStepOne[0]['course_option_name_fourth'];
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
											<!------- University 4 End Here -------->
											
											
											
											<!------- University 5 Start Here -------->
											<tr>
												<td><?php
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							
					  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
					  		
					  		foreach($courses as $course)
					  		{
								if(!empty($applicaitonStepOne))
							  	{
							  		if($applicaitonStepOne[0]['course_fifth'] == $course['id'])
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
							  		if($applicaitonStepOne[0]['course_fifth'] == $course['id'])
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
							  		if($applicaitonStepOne[0]['course_fifth'] == $course['id'])
							  		{
										echo $course['title'];
									}
								}
							}
								  	
						}
						?></td>
												<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fifth']);echo $university_second[0]['name'];?></td>
												<td><?php
												if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_fifth']);
							if($applicaitonStepOne[0]['course_fifth'] > 0 && $crs[0]['has_stream'] > 0)
							{
								if(!empty($applicaitonStepOne)) 
								$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course_option_name_fifth']);
							echo $applicaitonStepOne[0]['course_option_name_fifth'];
								//echo $strm[0]['name'];
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
											
											<!----------University 5 End Here------>
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
											<th>University 4</th>
											<th>University 5</th>
										</thead>
										<tbody>
											<tr>
												<td><?php $university_first = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']); echo $university_first[0]['name'];?></td>
												<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);echo $university_second[0]['name'];?></td>
												<td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']); echo $university_three[0]['name'];?></td>
												<td><?php $university_fourth =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fourth']);echo $university_fourth[0]['name'];?></td>
												<td><?php $university_fifth = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fifth']); echo $university_fifth[0]['name'];?></td>
											</tr>
										</tbody>
									</table>
						<?php
					}
									?>
								
									
								</td>
								
							</tr>
							<?php
						}
						?>
							<tr>
								<td colspan="2">
								<?php
								$user_data = $this->session->userdata( 'user_data' );
						 
						  $student_type = $user_data[ 'student_type' ];
						  $student_course_type = $user_data[ 'apply_course_type' ];
						  $prgid = $user_data[ 'apply_course_type' ];
						   if($student_course_type == 11){
							   ?>
							  <span class="note1"><strong> </strong>.
						</span>
						<?php
						  }
						  else
						  {
							  ?>
							  <span class="note1"><strong>Note: </strong>&nbsp;&nbsp;&nbsp;Once admission is confirmed, no change in either course or University/Institute will be permitted by the Council.
						<br/>Allotment of colleges is done by the respective Universities.
						</span>
							  <?php
						  }
								?>
									
						
						
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
					<label class="scfont">15. Previous Educational Qualifications  </label>
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
								<td>Grade X<br/>(equivalent to Grade X in India)</td>
								<td >
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
										  }
									  ?>
			                       
								</td>
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>
								</td>
							</tr>
								<tr>
								<td>Grade XII<br/>(equivalent to Grade XII in India)</td>
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
								<td>Grade X<br/>(equivalent to Grade X in India)</td>
								<td >
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
										  }
									  ?>
			                       
								</td>
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>
								</td>
							</tr>
								<tr>
								<td>Grade XII<br/>(equivalent to Grade XII in India)</td>
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
								<td>Grade X<br/>(equivalent to Grade X in India)</td>
								<td >
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
										  }
									  ?>
			                       
								</td>
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>
								</td>
							</tr>
								<tr>
								<td>Grade XII<br/>(equivalent to Grade XII in India)</td>
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
								<td>Grade X<br/>(equivalent to Grade X in India)</td>
								<td >
								   
			                         
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo $country['country_name'];
												}												
											}
										  }
									  ?>
			                       
								</td>
								<td >
								  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>
								</td>
								<td >
									<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>
								</td>
							</tr>
								<tr>
								<td>Grade XII<br/>(equivalent to Grade XII in India)</td>
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
				
              </div>
          
              <!-- /.box-body -->
		
	  </div>	
	     
	</div>
	</div>
</section>
	
	


	
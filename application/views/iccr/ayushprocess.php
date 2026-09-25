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
    text-decoration: none;}
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
		<h3 class="text-center caps">Application Details For Scholarship through ICCR</h3>
		<h5 class="text-center">FILLED BY APPLICANT</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;">	
	<form method="post" action="<?php echo base_url();?>headquarter/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<div class="tab-content detailpagepdf">		
	  <div id="home" class="tab-pane fade in active">	
	    	 
             <div class="col-xs-3 prfl pull-right" >
              		<?php 
              			$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']);
$dirdata = $userd->dir;
						//$oldYear = explode('/',$dirdata);
						//echo "<pre>";print_r($oldYear);die;
						$imgs = file_get_contents($userd->dir .'/'.$userImage);
							//echo $imgs;
							$data = base64_encode($imgs);
							$f = finfo_open();
							$imgdata = base64_decode($data);
                            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
						//echo "<pre>";print_r($userd->dir);die;						
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
							<!-- <img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?><?php echo $userd->dir.'/'. $userImage; ?>"/> -->
							
							<img style="width:151px;height:171px;" id="profil_image_div" src="data:<?php if(!empty($mime_type)){echo $mime_type;}?>;base64,<?php if(!empty($data)){echo $data;}?>"/>
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
											echo '</b> '.$mission['mission_type'].' '.$mission['mission_name'].', '.$mission['country_name'];
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
						  	echo 'Mr';						  
						  }
						  elseif($title == 2)
						  { 
						  	echo 'Ms';
						  }
						  elseif($title == 3)
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
									<label>4. Country</label>
								</td>
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
								<td style="height:35px;font-weight: bold;"><label for="comment">5. Passport No</label></td>
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
								<label>6. Postal Address</label>
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
									<label><b>7. Contact Details </b></label>
								</td>
																
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><b>Contact No</b></td>
								<td style="height:35px;">:&nbsp;&nbsp;+<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['tel_country_code'];?>&nbsp;&nbsp;<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['phone'];?></td>
							</tr>					
								<tr>
								<td colspan="3" style="height:35px;">
								<table style="width:100%;" id="tbl_course" class="table">
									<thead>
										<th>8. Level of Programme</th>
										<th>Course Type</th>
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
									</td>
						  	<!----<td>
							
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
						  	</td>--->
										</tr>
									</tbody>
								</table>
								</td>
							</tr>
							<tr>
							<td style="min-height:35px;font-weight: bold;">
									<label><b>9. University/Institute/Courses </b></label>
								</td>						
							</tr>
								<tr>
								<td colspan="3">
									<table id="tbl_uni" style="width: 100%;">
										<thead>
											<th>Course 1</th>
											<th>Course 2</th>
											<th>Course 3</th>
											<th>Course 4</th>
											<th>Course 5</th>
										</thead>
										<tbody>
											<tr>

												<td><?php $course_first = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']); echo $course_first[0]['title'] ?? 'NA';?></td>
												<td><?php $course_second =  $this->common_model->getCoursesById($applicaitonStepOne[0]['course_two']);echo $course_second[0]['title'] ?? 'NA';?></td>
												<td><?php $course_three = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_three']); echo $course_three[0]['title'] ?? 'NA';?></td>
												<td><?php $course_fourth = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_fourth']); echo $course_fourth[0]['title'] ?? 'NA';?></td>
												<td><?php $course_fifth = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_fifth']); echo $course_fifth[0]['title'] ?? 'NA';?></td>
											</tr>
										</tbody>
									</table>
								</td>
								
							</tr>
							<tr> 
								<td colspan="4" style="min-height:30px;">
									<table id="tbl_uni" style="width: 100%;" class="table">
										<thead>
											<th>University 1</th>
											<th>University 2</th>
											<th>University 3</th>
											<th>University 4 </th>
											<th>University 5 </th>
										</thead>
										<tbody>

											<tr>
												<td><?php $university_first = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']); echo $university_first[0]['name'];?></td>
												<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);echo $university_second[0]['name'];?></td>
												<td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']); echo $university_three[0]['name'];?></td>
												<td><?php $university_fourth = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fourth']); echo $university_fourth[0]['name'];?></td>
												<td><?php $university_fifth = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fifth']); echo $university_fifth[0]['name'];?></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							
							<tr>
							<td style="min-height:35px;font-weight: bold;">
									<label><b>10. Previous Educational Qualifications  </b></label>
								</td>						
							</tr>
							<tr>
								<td colspan="3">
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
								</td>
							</tr>
						</tbody>
					</table>
						
              </div>
                     	
				
              <!-- /.box-body -->
           
	  </div>
	</div>		
	  <div id="step3" class="tab-pane fade in active">	 
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
	
				
									
	  <!--<h3 class="text-center" id="h5_cnetr">Applicant's Acceptance Forwarded to Hqrs/RO</h3>-->	 
	 
             <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>headquarter/forwardAyuushtohqrs/<?php echo $this->uri->segment(3); ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">				
					
              		<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Select University</label>
					    <div class="col-sm-8">
						    <select id="universty_choice" name="universty_choice"  class="form-control" onchange="selectUniversityChoice(this.value)"  required="true">	
						 <option value="">Select</option>							 
						 	<?php						 
						 	if($applicaitonStepOne[0]['programme']>0)
						 	{
						 		echo '<optgroup label="Ayurveda, Yoga, Unani, Siddha and Homoeopathy (AYUSH)">';	
						 		
							 				
			 					foreach($univercities as $univercity)
								{											
									if(array_key_exists($univercity['state_id'],$statewiseUniversites))
									{													
										array_push($statewiseUniversites[$univercity['state_id']],$univercity);
									}
								}
								
								foreach($statewiseUniversites as $key=>$univercity1)
								{
									if(count($univercity1)>0)
									{
										$statenames = $this->common_model->getStateById($key);
										echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'" class="stt">';
										foreach($univercity1 as $uni_choice)
										{
											
											echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												
										}
										echo '</optgroup>';			
									}	
								}										    
							    echo '</optgroup>';	
							}	
						    ?>							 	
						 </select>
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">University Response</label>
					    <div class="col-sm-8">
					      <select id="university_is_accept" name="university_is_accept" class="form-control" required="true">
					      	<option value="">Select</option>
					      	<option value="1">Confirmed</option>
					      	<option value="2">Not-Confirmed</option>
					      </select>
					    </div>
					</div>
					
					<?php if($appid = $this->uri->segment(3) == 'KU5155758869454'){
						?>
						
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Nomenclature</label>
					    <div class="col-sm-8">
					      <select id="course" name="course" class="form-control" required="true" data-searchable="true">
					      	<option value="">Select</option>
					      <option value="93">Ph.D Yoga</option>
						  <option value="93">Ph.D Yoga</option>
						  <option value="93">Ph.D Yoga</option>
						  <option value="93">Ph.D Yoga</option>
					      </select>
					    </div>
					</div>
						
						<?php
					}
					else
					{
						?>
						
						<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Nomenclature</label>
					    <div class="col-sm-8">
					      <select id="course" name="course" class="form-control" required="true" data-searchable="true">
					      	<option value="">Select</option>
					      	<?php
					      	// Lists the complete nomenclature list, not only the entries
					      	// mapped to this applicant's programme, because Headquarters
					      	// may confirm any course. Same source and ordering as the
					      	// nomenclature dropdown in mission/checklist.php.
					      	$nomenclatureList = $this->common_model->getnomenclature();
					      	if(!is_array($nomenclatureList)) { $nomenclatureList = array(); }
					      	usort($nomenclatureList, function($a, $b) {
					      		return strcmp($a['title'], $b['title']);
					      	});
					      	foreach($nomenclatureList as $nomen)
					      	{
					      		$nomTitle = isset($nomen['title']) ? trim($nomen['title']) : '';
					      		if($nomTitle === '') { continue; }
					      		// Value stays the title text, which is what this field
					      		// saved before - forwardAyuushtohqrs writes it straight
					      		// into the course column.
					      		echo '<option value="'.htmlspecialchars($nomTitle, ENT_QUOTES).'">'.htmlspecialchars($nomTitle, ENT_QUOTES).'</option>';
					      	}
					      	?>
					      </select>
					    </div>
					</div>
						<?php
						
					}
					?>
					
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Mission Scheme</label>
					    <div class="col-sm-8">
					      	<?php
					      
					        $schemes = $this->common_model->getSchemeById($mappingData[0]['scholarship_id']);
					        $scheme = $schemes[0]['scheme_name'] ?? '';
					      	if(!empty($scheme))
					      	{					      		
					      											
									echo $scheme;
								
							}
					      	?>
					     
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Scheme</label>
					    <div class="col-sm-8">
					      <select id="scheme" name="scheme_id" class="form-control" required="true">
					      	<option value="">Select</option>
					      	<?php
					      	$ayusShchemes = $this->common_model->getAYUSHSchemes();
							//echo "<pre>";print_r($ayusShchemes);die;
					      	if(!empty($ayusShchemes))
					      	{					      		
					      		foreach($ayusShchemes as $scheme)
					      		{									
									echo '<option value="'.$scheme['id'].'">'.$scheme['scheme_name'].'</option>';
								}
							}
					      	?>
					      </select>
					    </div>
					</div>
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-3">Upload Letter</label>
					    <div class="col-sm-8">
					      <input type="file" accept="application/pdf"  required="true" id="inputfile_regional" name="inputfile_regional"/>
					    </div>
					</div>
					<div class="form-group col-xs-9 pull-right pdlef signt">					    
					    <div class="col-sm-6 pull-left pdleft">
					      <input type="submit" class="form-control sbmt pull-right" id="submit" value="Submit"/>
					    </div>					    
					</div> 			
			</div>
              <!-- /.box-body -->
            </form>
	  </div>
          
              <!-- /.box-body -->
		
	  </div>	
<hr>
	</div>
	
	</div>
</section>

<?php
// Searchable Nomenclature dropdown - see assets/site/main/js/iccr-searchable-select.js.
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/main/css/iccr-searchable-select.css?v=20260925">
<script src="<?php echo base_url(); ?>assets/site/main/js/iccr-searchable-select.js?v=20260925"></script>

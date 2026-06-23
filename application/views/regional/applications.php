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

.export-btn:hover{font-weight: bold;}
</style>

<section class="meacontent">
<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Details For Scholarship through ICCR</h3>
		<h5 class="text-center">FILLED BY APPLICANT</h5>
	</div>	
	<div  class="container detailpagepdf" style="min-height:410px;padding:0px;">
	<form method="post" action="<?php echo base_url();?>mission/download" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		<div class="blue-heading col-md-12">
			 <h3>Personal Information</h3>
		</div><br><br>
		<table class=" table table-striped table-bordered">
			<thead>
				<th class="col-xs-1">S.No.</th>
				<th class="col-xs-5">Personal Info</th>
				<th class="col-xs-8">Values</th>				
			</thead>
			<tbody>
			<?php //print_r($applicaitonStepOne); ?>
				<tr>
					<td>1</td>
					<td>Applicant Name</td>
					<?php $title = ''; $tlt = "";
						  if(count($applicaitonStepOne) > 0)
						  {
						  	$title = $applicaitonStepOne[0]['student_title'];
						  }
						  if($title == 1)
						  {
						  	$tlt = "Mr.";						  
						  }
						  elseif($title == 2)
						  {
						  	$tlt = "Mrs.";
						  }						  
					  ?>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['fullname'] != "") echo  $tlt.' '.$applicaitonStepOne[0]['fullname']; ?></td>
				</tr>
				<tr>
					<td>2</td>
					<td>Gender</td>
					<?php $title = '';$gnd = "";
						  if(count($applicaitonStepOne) > 0)
						  {
						  	$title = $applicaitonStepOne[0]['gender'];
						  }
						  if($title == 1)
						  {
						  	$gnd = 'Male';						  
						  }
						  elseif($title == 2)
						  {
						 	$gnd = 'Female';	
						  }
					  ?>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['gender'] != "") echo  $applicaitonStepOne[0]['gender']; ?></td>
				</tr>
				<tr>
					<td>3</td>
					<td>Contact Number</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['tel_country_code'] != "") echo  '+'.$applicaitonStepOne[0]['tel_country_code']; echo  ' '.$applicaitonStepOne[0]['phone']; ?></td>
				</tr>
				<tr>
					<td>4</td>
					<td>Email Id</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['email'] != "") echo  $applicaitonStepOne[0]['email']; ?></td>
				</tr>
				<tr>
					<td>5</td>
					<td>Postal Address</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['postal_address'] != "") echo  $applicaitonStepOne[0]['postal_address']; ?></td>
				</tr>
				<tr>
					<td>6</td>
					<td>Permanent Unique No (Excluding Passport No)</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['unique_id'] != "") echo  $applicaitonStepOne[0]['unique_id']; ?></td>
				</tr>
				<tr>
					<td>7</td>
					<td>Date of Birth</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['dob'] != "") echo  $applicaitonStepOne[0]['dob']; ?></td>
				</tr>
				<tr>
					<td>8</td>
					<td>Nationality</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['nationality'] != "") echo  $applicaitonStepOne[0]['nationality']; ?></td>
				</tr>
				<tr>
					<td>9</td>
					<td>Country</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['country'] != "") echo  $applicaitonStepOne[0]['country']; ?></td>
				</tr>
				<tr>
					<td>10</td>
					<td>Passport Number </td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['passport_no'] != "") echo  $applicaitonStepOne[0]['passport_no']; ?></td>
				</tr>
				<tr>
					<td>11</td>
					<td>Passport Issuing Date</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['passport_issue_date'] != "") echo  $applicaitonStepOne[0]['passport_issue_date']; ?></td>
				</tr>
				<tr>
					<td>12</td>
					<td>Passport Expiry Date</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['passport_expiry_date'] != "") echo  $applicaitonStepOne[0]['passport_expiry_date']; ?></td>
				</tr>
				<tr>
					<td>13</td>
					<td>Passport Issuing Date</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['passport_issue_place'] != "") echo  $applicaitonStepOne[0]['passport_issue_place']; ?></td>
				</tr>
			</tbody>
		</table>
		<hr/>
		<table class=" table table-striped table-bordered">
			<thead>
				<th class="col-xs-1">S.No.</th>
				<th class="col-xs-5">Guardian/Father Details</th>
				<th class="col-xs-8">Values</th>				
			</thead>
			<tbody>
			
				<tr>
					<td>1</td>
					<td>Name</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['guardian_name'] != "") echo  $applicaitonStepOne[0]['guardian_name']; ?></td>
				</tr>
				<tr>
					<td>2</td>
					<td>Relation</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['guardian_relation'] != "") echo  $applicaitonStepOne[0]['guardian_relation']; ?></td>
				</tr>
				<tr>
					<td>3</td>
					<td>Occupation</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['guardian_occupation'] != "") echo  $applicaitonStepOne[0]['guardian_occupation']; ?></td>
				</tr>
				<tr>
					<td>4</td>
					<td>Nationality</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['guardian_nationality'] != "") echo  $applicaitonStepOne[0]['guardian_nationality']; ?></td>
				</tr>
				<tr>
					<td>5</td>
					<td>Address</td>
					<td><?php if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['guardian_address'] != "") echo  $applicaitonStepOne[0]['guardian_address']; ?></td>
				</tr>
				
			</tbody>
		</table>
<table class=" table table-striped table-bordered">
			<thead>
				<th class="col-xs-1">S.No.</th>
				<th class="col-xs-5">Language Details</th>
				<th class="col-xs-8">Values</th>				
			</thead>
			<tbody>	
				<tr>
					<td>1</td>
					<td>Knowledge of English</td>
					<td>Yes</td>
				</tr>		
				<tr>
					<td>(a)</td>
					<td>English (Written)</td>
					<td>Average : No | Proficient :Yes | Good : No</td>					
				</tr>
				<tr>
					<td>(b)</td>
					<td>English (Spoken)</td>
					<td>Average : No | Proficient :Yes | Good : No</td>	
				</tr>
			</tbody>
		</table>
		<hr/>		
		<table class=" table table-striped table-bordered">
			<thead>
				<th class="col-xs-1">S.No.</th>
				<th class="col-xs-5">Course Details</th>
				<th class="col-xs-8">Values</th>				
			</thead>
			<tbody>	
				<tr>
					<td>1</td>
					<td>Order of preference for the Univesities/Institutes in India where in you wish to seek admission:</td>
					<td>Andhra University, Visakhapatnam, Andhra Pradesh | Osmania University, Hyderabad, Andhra Pradesh |Dibrugarh University, Dibrugarh Assam</td>
				</tr>		
				<tr>
					<td>2</td>
					<td>Programme</td>
					<td>UG</td>					
				</tr>
				<tr>
					<td>3</td>
					<td>Course</td>
					<td>BCA</td>	
				</tr>
			</tbody>
		</table>
		<div class="blue-heading col-md-12">
			 <h3>Education Details</h3>
		</div><br><br>
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
		<table class=" table table-striped table-bordered">
			<thead>
				<th>Certificate/Degree</th>
				<th colspan="1">Country</th>
				<th colspan="3">Name of School/University/Board</th>
				<th colspan="1">Year</th>
				<th colspan="1">Percentage(%)/Grade</th>				
			</thead>
			<tbody>
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
										echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
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
				<tr>
				<td>MPhil<br/> (Must have a Post-Graduate Degree.)</td>
					<td colspan="1">								   
                         <?php
							  $countries = $this->common_model->getCountries();
							  foreach($countries as $country)
							  {
							  	if(!empty($applicaitonStepTwo))
							  	{
									if($applicaitonStepTwo[0]['mphil_leaving_country'] == $country['id'])
									{
										echo $country['country_name'];
									}
								}
							  }
						  ?>			                       
					</td>
					<td colspan="3">
					 <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['mphil_leaving_university'];?>
					</td>
					<td colspan="1">
						<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['mphil_leaving_year'];?>
					</td>
					<td colspan="1">
						<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['mphil_leaving_percentage'];?>
					</td>
				</tr>
				<tr>
					<td>								
					DOCTORAL (Ph.D)<br/></td>
					<td colspan="1">
					   
                         <?php
							  $countries = $this->common_model->getCountries();
							  foreach($countries as $country)
							  {
							  	if(!empty($applicaitonStepTwo))
							  	{
									if($applicaitonStepTwo[0]['phd_leaving_country'] == $country['id'])
									{
										echo $country['country_name'];
									}
								}
							  }
						  ?>			                       
					</td>
					<td colspan="3">
					  <?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['phd_leaving_university'];?>
					</td>
					<td colspan="1">
						<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['phd_leaving_year'];?>
					</td>
					<td colspan="1">
						<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['phd_leaving_percentage'];?>
					</td>
				</tr>
				
			</tbody>
		</table>
		<span class="note1"><strong>Note: </strong>(Details of any course in Indian Universities/Institutes which the scholar is currently attending or has attended in past may be given below.)</span>
		<br/><br/>
		<table class=" table table-striped table-bordered">
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
		<div class="blue-heading col-md-12">
			 <h3>Other Details</h3>
		</div><br><br>
		<table class="table table-striped table-bordered">
			<thead>
				<th class="col-xs-1">S.No.</th>
				<th class="col-xs-13">Reference Details</th>								
			</thead>
			<tbody>
			<?php //print_r($applicaitonStepOne); ?>
				<tr>
					<td>1</td>
					<td>
						<table class=" table table-striped table-bordered">
							<tr><td>Name</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_name'];?></td></tr>
							<tr><td>Occupation</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation'];?></td></tr>								
							<tr><td>Email</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_email'];?></td></tr>
							<tr><td>Telephone</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_designation'];?></td></tr>
							<tr><td>Postal Address</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address'];?></td></tr>
						</table>						
					</td>					
				</tr>
				<tr>
					<td>2</td>
					<td>						
						<table class=" table table-striped table-bordered">
							<tr><td>Name</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_name'];?></td></tr>
							<tr><td>Occupation</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation'];?></td></tr>								
							<tr><td>Email</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_email'];?></td></tr>
							<tr><td>Telephone</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_designation'];?></td></tr>
							<tr><td>Postal Address</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address'];?></td></tr>
						</table>
					</td>					
				</tr>
			</tbody>
		</table>
		
		<hr/>
		<table class="table table-striped table-bordered">
			<thead>
				<th class="col-xs-1">S.No.</th>
				<th class="col-xs-13">Details of close relative(s) or friends, if any, in India</th>								
			</thead>
			<tbody>			
				<tr>
					<td>1</td>
					<td>
						<table class=" table table-striped table-bordered">
							<tr><td>Name</td><td>Kamal</td></tr>
							<tr><td>Occupation</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation'];?></td></tr>								
							<tr><td>Email</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_email'];?></td></tr>
							<tr><td>Telephone</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_designation'];?></td></tr>
							<tr><td>Postal Address</td><td><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address'];?></td></tr>
						</table>						
					</td>					
				</tr>				
			</tbody>
		</table>
		<hr/>
		<table class=" table table-striped table-bordered">
			<thead>
				<th>S.No</th>							
				<th>Other Details</th>
				<th>Values</th>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>Have You travelled or lived in India in the past?</td>
					<td><?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['is_travel_or_live_in_india_before'] == 1){
								echo "Yes";
							}
							elseif($applicaitonStepThree[0]['is_travel_or_live_in_india_before'] == 2){
								echo "No";
							}
						}?></td>							
				</tr>
				<tr>
					<td>2</td>
					<td>Have you ever availed of ICCR Scholarship earlier?</td>
					<td><?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 1){
								echo "Yes<br/>";
								echo "Year of Scholarship : ";
								if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_year'];
								echo '<br/>';
								echo "Name of Course : ";								
								if(!empty($applicaitonStepThree))
								{
									if($applicaitonStepThree[0]['iccr_scholar_course'] == 1){
										echo "UG";
									}
									if($applicaitonStepThree[0]['iccr_scholar_course'] == 2){
										echo "PG";
									}
									if($applicaitonStepThree[0]['iccr_scholar_course'] == 3){
										echo "Ph.D";
									}
									if($applicaitonStepThree[0]['iccr_scholar_course'] == 4){
										echo "Other";
									}
								}	
								echo '<br/>';
								echo "Name of Institue/University : ";
								if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_institute'];
								echo '<br/>';
								echo "Duration of stay in India on Scholarship : ";
								if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_from'] .' to ';
								if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_to'];
								echo '<br/>';
							}
							elseif($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 2){
									echo "No";
							}
						}?></td>							
				</tr>	
				<tr>
					<td>3</td>
					<td>Are you currently a resident of India?</td>
					<td><?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['currently_non_nri'] == 1){
								echo "Yes<br/>";
								echo "Postal Address : Noida";
							}
							elseif($applicaitonStepThree[0]['currently_non_nri'] == 2){
								echo "No";
							}
						}
						?></td>							
				</tr>
				<tr>
					<td>4</td>
					<td>Do you have an International driving licence?</td>
					<td><?php
						if(!empty($applicaitonStepThree))
						{
							if($applicaitonStepThree[0]['is_international_lic'] == 1){
								echo "Yes<br/>";							
								echo "Licence Number : 25417892";
								if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_institute'];
								echo '<br/>';
								echo "Issuing Authority : SKU";
							}
							elseif($applicaitonStepThree[0]['is_international_lic'] == 2){
								echo "No";
							}
						}
						?></td>							
				</tr>
				<tr>
					<td>5</td>
					<td>Any Other Information.</td>
					<td><?php
						if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['any_other_info'];
						?></td>							
				</tr>
				
				 						
			</tbody>
		</table>
		
	</div>
	<div class="container" style="min-height:410px;padding-top:50px;">
		<div class="blue-heading col-md-12">
			 <h3>Documents</h3>
		</div><br><br>
		<table class=" table table-striped table-bordered">
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
								<td>Govt. ID Proof <span class="text-red">*</span></td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['id']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['id']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['passport']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['ug']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['pg']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['mhil']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['phd']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['indian_address']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['physical']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['physical']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['physical']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view PDF</a>
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
		<div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
	         <div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
			  <a href="javascript:void(0);" onclick="applicaiton_process('Process','<?php echo $this->uri->segment(3); ?>');" class="form-control sbmt">Process</a>
			  </div>                           
      	</div>
	</div>
		
</section>
	
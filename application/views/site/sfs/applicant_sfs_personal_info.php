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
optgroup[label]{ color: #4e7a9f;
    font-size: 20px;
    padding-left: 10px;
    padding-top: 10px;
    text-decoration: none;}
optgroup option{color:#747474; font-size: 14px;}
.alert
{	
	margin: 12px auto 8px;    
    width: 85.5%;
}

.box-shadow {box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, .05);}
</style>
<?php 
function sortByName($a, $b)
{
	$a = $a['uni'];
	$b = $b['uni'];

	if ($a == $b)
	{
		return 0;
	}

	return ($a < $b) ? -1 : 1;
}
$stateuniversities = $this->common_model->getStateUniversities();
$icaruni = $this->common_model->getICARUniversity();
$ayush = $this->common_model->getAYUSHUniversity();
$agricultureal =  $this->common_model->getAgriculturalUniversity();
$centraluniversities = $this->common_model->getCentralUniversities();
$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states =  $this->common_model->getAllStates();
$nifts = $this->common_model->getAllNIFT();

$crstype =  $this->common_model->getCourseTypes();

//print_r($states);
$statewiseUniversites = array();
foreach($states as $st)
{
	if(!array_key_exists($st['id'],$statewiseUniversites))
	{
		$statewiseUniversites[$st['id']] = array();
	}
}
//print_r($statewiseUniversites);
$stateuniversities_one = str_replace("'","\'",json_encode($stateuniversities));
$centraluniversities_one = str_replace("'","\'",json_encode($centraluniversities));
$nits_one = str_replace("'","\'",json_encode($nits));
$yogas_one = str_replace("'","\'",json_encode($yogas));
$states_array = json_encode($statewiseUniversites);
$icar = json_encode($icaruni);
$agricultural = json_encode($agricultureal);
$ayushUni = json_encode($ayush);
$ctypes = json_encode($crstype);
$nift = json_encode($nifts);
?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
var centralUniversities = JSON.parse('<?php echo $centraluniversities_one;?>');
var nits = JSON.parse('<?php echo $nits_one;?>');
var yogas = JSON.parse('<?php echo $yogas_one;?>');
var statesarray = JSON.parse('<?php echo $states_array;?>');
var icar = JSON.parse('<?php echo $icar;?>');
var agricultural = JSON.parse('<?php echo $agricultural;?>');
var ayushU = JSON.parse('<?php echo $ayushUni;?>');
var courseTypeList = JSON.parse('<?php echo $ctypes;?>');
var niftList = JSON.parse('<?php echo $nift;?>');
</script>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Form(2020-2021) For Scholarship through ICCR SFS</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
		<span style="color:red;font-weight: bold;box-shadow:4px 1px 13px yellow inset;">Note: (Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format) </span>
	</div>
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
	<div  class="container" style="min-height:410px;padding-top:0px;padding:0;">
	
	<script type="text/javascript">
		window.history.pushState({}, "Indian Council for Cultural Relations",  baseURL + 'Sfs/applicant_sfs_personal_info?appno=' + '<?php echo $get_application_number; ?>');
	</script>
	<div class="main-cnsfs ">		
	  <div id="home" class="tab-pane fade in active">	 
	    <?php
		//$data = array('onsubmit' => "return smtProfilePic();"); 
	    $hidden = array($this->security->get_csrf_token_name() => $this->security->get_csrf_hash());
		echo form_open('Sfs/applicant_sfs_education_info?appno='.$get_application_number,array('onsubmit'=>'return validateFieldsPersonalInfo()')); 
		
		?>	    	 
	    	 
              <div class ="box-body ">
              	<div class="col-xs-3 prfl pull-right" >
              		<?php 
              			if($userImage == "")
              			{
						?>
						<img id="profilsfs_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png" />
						<a href="javascript:void(0);" data-toggle="modal" data-target="#profileSfsUploadsPic">Upload Profile Pic</a>
						<?php	
						}
						else
						{
						?>
						<img id="profilsfs_image_div" src="<?php echo site_url();?>assets/site/main/profile_sfs_pics/<?php echo $userImage; ?>"  />
						<a href="javascript:void(0);" data-toggle="modal" data-target="#profileSfsUploadsPic">Re-Upload Profile Pic</a>
						<?php		
						}
              		?>	
              	</div>
			
              	<div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">
              		<div class="name-sec col-xs-12 col-sm-5 col-md-7">
	              	
	              	</div>
	              	
					<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<label>1. Full Name (IN BLOCK LETTERS)</label>
					<div class="col-xs-2 col-md-2 col-sm-2 pdleft pdright">
					<div class="form-group">
					<select id="student_title" name="student_title" class="selectpicker form-control" required="true">
					  <?php $title = '';
						  if(count($applicaitonSfsStepOne) > 0)
						  {
						  	$title = $applicaitonSfsStepOne[0]['student_title'];
						  }
						  if($title == 1)
						  {
						  ?>
						  <option value="">Title</option>
						  <option  selected="selected" value="1">Mr.</option>
						  <option  value="3">Miss</option>
						  <option  value="2">Mrs</option>
						  <?php	
						  }
						  elseif($title == 2)
						  {
						  ?>
						  <option value="">Title</option>
						  <option value="1">Mr.</option>
						  <option  value="3">Miss</option>
						  <option selected="selected" value="2">Mrs</option>
						  <?php		
						  }
						  elseif($title == 3)
						  {
						  ?>
						  <option value="">Title</option>
						  <option value="1">Mr.</option>
						  <option selected="selected" value="3">Miss</option>
						  <option  value="2">Mrs</option>
						  <?php		
						  }
						  else
						  {
						  ?>
						  <option value="">Title</option>						  
						  <option value="1">Mr.</option>
						  <option  value="3">Miss</option>
						  <option value="2">Mrs</option>
						  <?php	
						  }
					  ?>					  
					</select>
					</div>
					</div>
					<div class="col-xs-10 col-md-7 col-sm-10 pdright">
					<div class="form-group">
					<?php 
					$myname = "";
					if(!empty($applicaitonSfsStepOne) && $applicaitonSfsStepOne[0]['fullname'] != "") $myname = $applicaitonSfsStepOne[0]['fullname'];
					else $myname = $registerSfsData[0]['username'];
					?> <input type="text" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" name="fullname" class="form-control" placeholder="Full Name" id="fullname" value="<?php if(!empty($myname)) echo $myname;?>"  required="true"></div>					
					</div>	
					</div>	
					<div class="name-sec col-xs-12 col-sm-5 col-md-12">	
					<label>2. Gender</label>			
						<div class="form-group">	
						  <?php $title = '';
						  if(count($registerSfsData) > 0)
						  {
						  	$title = $registerSfsData[0]['gender'];
						  }
						  if($title == 1)
						  {
						  ?>
							<input checked="true" class="is_knwldge" type="radio" value="1" name="gender" id="gender"/> Male
					  		<input type="radio" class="is_knwldge" value="2" name="gender" id="gender"/> Female					 
						  <?php	
						  }
						  elseif($title == 2)
						  {
						  ?>
							  <input class="is_knwldge" type="radio" value="1" name="gender" id="gender"/> Male
					  		<input type="radio" checked="true" class="is_knwldge" value="2" name="gender" id="gender"/> Female							  
						  <?php		
						  }						 
						  else
						  {
						  ?>
							  <input checked="true" class="is_knwldge" type="radio" value="1" name="gender" id="gender"/> Male
					  		<input type="radio" class="is_knwldge" value="2" name="gender" id="gender"/> Female	
							  
						  <?php	
						  }
					  ?>
						 
						</div>
					</div>	
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-3 col-md-5">
						 <label for="comment">3. Date of Birth</label>
							<div class="form-group col-md-9 pdleft">
							  <input type="text" readonly="true" class="form-control" placeholder="yy-mm-dd" id="dob" name="dob" value="<?php if(!empty($registerSfsData)) echo $registerSfsData[0]['date_of_birth'];?>"/>
							</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-4">
					 <label for="comment">Country <span class="text-red">*</span></label>
						<div class="form-group">
						 <div class="form-group">
						<select id="nationality" name="nationality" class="selectpicker form-control" required="true">
						  
						  <?php
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $na)
						  {
						  	if(!empty($registerSfsData))
						  	{
								if($registerSfsData[0]['country_of_domicile'] == $na['id'])
								{
									echo '<option selected="selected" value="'.$na['id'].'">'.$na['country_name'].'</option>';
								}
							}
							else
							{
								echo '<option value="'.$na['id'].'">'.$na['country_name'].'</option>';
							}
						  	
						  }
						  ?>
						</select>
						</div>
						</div>
					</div>
					</div>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-3 col-md-5">
					 <label for="comment">4. Country of Residence <span class="text-red">*</span></label>
						<div class="form-group col-md-9 pdleft">
						  <select id="country" name="country" class="selectpicker form-control" required="true">
						  <option value="">---- Select ---</option>
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonSfsStepOne))
						  	{
								if($applicaitonSfsStepOne[0]['country'] == $country['id'])
								{
									echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
								}
								else
								{
									echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
								}
							}
							else
							{
								echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
							}
						  	
						  }
						  ?>
						</select>
						</div>
					</div>
					</div>
					
					<?php if(!empty($registerSfsData))
						  	{
								if($registerSfsData[0]['country_of_domicile'] == '75')
								{
									?>
<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-5">
					 <label for="comment">5. Passport No</label>
						<div class="form-group col-md-9 pdleft">
						  <input type="text" name="passport_no" class="form-control" placeholder="Passport No" id="passport_no" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '"  value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['passport_no'];?>"/>
						</div>
					</div>
					
				</div>
<?php
							    }
								else
								{
									?>
									
									<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-5">
					 <label for="comment">5. Passport No<span class="text-red">*</span></label>
						<div class="form-group col-md-9 pdleft">
						  <input type="text" name="passport_no" class="form-control" placeholder="Passport No" id="passport_no" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '"  value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['passport_no'];?>"/>
						</div>
					</div>
					
				</div>
									<?php
									
								}
							
							}

							?>
				
				
				
				<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<div class="name-sec col-xs-12 col-sm-3 col-md-6">
					 <label for="comment">a) Date of Issue</label>
						<div class="form-group col-md-4 pdleft">						
						 <select class="form-control" id="passport_issue_date" name="passport_issue_date">
						 <option value="">Date</option>
					 		<?php						 		
					 		for($i=1; $i<=31;$i++)
					 		{
					 			if(!empty($applicaitonSfsStepOne))
					 			{
					 				$date_of_issue = $applicaitonSfsStepOne[0]['passport_issue_date'];
					 				$date_of_issue_array = explode('-',$date_of_issue);
									if($i==$date_of_issue_array[0])
									{
										echo '<option selected="selected" value="'.$i.'">'.$i.'</option>';		
									}
									else
									{
										echo '<option value="'.$i.'">'.$i.'</option>';		
									}
								}
								else
								{
									echo '<option value="'.$i.'">'.$i.'</option>';		
								}									
							}
					 		?>
							</select>
						</div>
						<div class="form-group col-md-4">						
						 	<select class="form-control" id="passport_issue_month" name="passport_issue_month" >
							<option value="">Month</option>
							<?php						 		
					 		for($i=1; $i<=12;$i++)
					 		{
					 			$monthName = date("M", mktime(0, 0, 0, $i, 10));
					 			if(!empty($applicaitonSfsStepOne))
					 			{
					 				$date_of_issue = $applicaitonSfsStepOne[0]['passport_issue_date'];
					 				$date_of_issue_array = explode('-',$date_of_issue);
									if($i==$date_of_issue_array[1])
									{
										echo '<option selected="selected" value="'.$i.'">'.$monthName.'</option>';		
									}
									else
									{
										echo '<option value="'.$i.'">'.$monthName.'</option>';		
									}
								}
								else
								{
									echo '<option value="'.$i.'">'.$monthName.'</option>';		
								}									
							}
					 		?>															
						</select>						   
						</div>
						<div class="form-group col-md-4">						
						  <select id="passport_issue_year" name="passport_issue_year" class="form-control">
						  <option value="">Year</option>
						  <?php 
						 
						  	for($i=1917;$i<=date('Y');$i++)
						  	{
						  		if(!empty($applicaitonSfsStepOne))
					 			{
					 				$date_of_issue = $applicaitonSfsStepOne[0]['passport_issue_date'];
					 				$date_of_issue_array = explode('-',$date_of_issue);
									if($i==$date_of_issue_array[2])
									{
										echo '<option selected="selected" value="'.$i.'">'.$i.'</option>';
									}
									else
									{
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								}
								else
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							}
						  ?>
						  </select>
						</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-6">
					 <label for="comment">b) Date of Expiry</label>
						<div class="form-group col-md-4">						
						 <select class="form-control" id="passport_expiry_date" name="passport_expiry_date" >
								<option value="">Date</option>
								<?php						 		
						 		for($i=1; $i<=31;$i++)
						 		{
						 			if(!empty($applicaitonSfsStepOne))
						 			{
						 				$date_of_issue = $applicaitonSfsStepOne[0]['passport_expiry_date'];
						 				$date_of_issue_array = explode('-',$date_of_issue);
										if($i==$date_of_issue_array[0])
										{
											echo '<option selected="selected" value="'.$i.'">'.$i.'</option>';		
										}
										else
										{
											echo '<option value="'.$i.'">'.$i.'</option>';		
										}
									}
									else
									{
										echo '<option value="'.$i.'">'.$i.'</option>';		
									}									
								}
					 		?>
							</select>
						</div>
						<div class="form-group col-md-4">						
						 	<select class="form-control" id="passport_expiry_month" name="passport_expiry_month" >
							<option value="">Month</option>
							<?php						 		
					 		for($i=1; $i<=12;$i++)
					 		{
					 			$monthName = date("M", mktime(0, 0, 0, $i, 10));
					 			if(!empty($applicaitonSfsStepOne))
					 			{
					 				$date_of_issue = $applicaitonSfsStepOne[0]['passport_expiry_date'];
					 				$date_of_issue_array = explode('-',$date_of_issue);
									if($i==$date_of_issue_array[1])
									{
										echo '<option selected="selected" value="'.$i.'">'.$monthName.'</option>';		
									}
									else
									{
										echo '<option value="'.$i.'">'.$monthName.'</option>';		
									}
								}
								else
								{
									echo '<option value="'.$i.'">'.$monthName.'</option>';		
								}									
							}
					 		?>								
						</select>						   
						</div>
						<div class="form-group col-md-4">						
						  <select id="passport_expiry_year" name="passport_expiry_year" class="form-control">
						  <option value="">Year</option>
						  <?php 
						 
						  	for($i=date('Y');$i<=date('Y',strtotime('+30 years'));$i++)
						  	{
						  		if(!empty($applicaitonSfsStepOne))
					 			{
					 				$date_of_issue = $applicaitonSfsStepOne[0]['passport_expiry_date'];
					 				$date_of_issue_array = explode('-',$date_of_issue);
									if($i==$date_of_issue_array[2])
									{
										echo '<option selected="selected" value="'.$i.'">'.$i.'</option>';
									}
									else
									{
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								}
								else
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							}
						  ?>
						  </select>
						</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-3">
					 <label for="comment">c) Place of Issue</label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Place of Issue" id="passport_issue_place" name="passport_issue_place"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['passport_issue_place'];?>"/>
						
					
	
						</div>
					</div>
				</div>
				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment">6. Permanent Postal Address <span class="text-red">*</span></label>	
							<div class="form-group col-md-12 pdleft">							
						  <textarea class="form-control" rows="3" id="postal_address" name="postal_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['postal_address'];?></textarea>
					</div>
					
										
				 </div>
				</div>	
				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">
					   <input name="postal_address_city" pattern="^[a-zA-Z ]+$" title="[a-zA-Z ]" type="text" class="form-control" placeholder="City" id="postal_address_city" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['postal_address_city'];?>">
					</div>
					<div class="form-group col-md-12 pdleft">
					   <input name="postal_address_state" pattern="^[a-zA-Z ]+$" title="[a-zA-Z ]" type="text" class="form-control" placeholder="State" id="postal_address_state" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['postal_address_state'];?>">
					</div>
</div>
				</div>	

				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">					  
					   <select id="postal_address_country" name="postal_address_country" class="selectpicker form-control" required="true">
						  <option value="">---- Country ---</option>
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonSfsStepOne))
								
						  	{
								if($applicaitonSfsStepOne[0]['postal_address_country'] == $country['id'])
								{
									echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
								}
								else
								{
									echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
								}
							}
							else
							{
								echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
							}
						  	
						  }
						  ?>
						</select>
					</div>
					<div class="form-group col-md-12 pdleft">
					   <input name="postal_address_pincode" title="[a-zA-Z0-9 ]" pattern="^[a-zA-Z0-9 ]+$" maxlength="11" type="text" class="form-control" placeholder="Zipcode" id="postal_address_pincode" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['postal_address_pincode'];?>">
					</div>
					</div>
				</div>
				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment">7.Resident Permit(Service No) <span class="text-red">*</span></label>	
							<div class="form-group col-md-12 pdleft">							
						  <textarea class="form-control" rows="3" id="rp_service_no" name="rp_service_no" placeholder="Resident Details" required="true" ><?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['rp_service_no'];?></textarea>
					</div>
					
										
				 </div>
				</div>	
				<div class="col-xs-12 col-sm-7 col-md-12 contact-detail">
					<label>8. Contact Details <span class="text-red">*</span><!--<span class="note"><strong>Note:</strong> (Telephone Number With Country Code eg. : 91 for India)</span>--></label>
					<div class="col-xs-12 col-md-4 col-sm-5 pdleft">
					<div class="form-group">
					 <input name="phone" pattern= "[0-9]" readonly="true" title="[0-9]" type="text" class="form-control" placeholder="Telephone No." id="phone" required="true" value="<?php if(!empty($registerSfsData)) echo $registerSfsData[0]['mobile_number'];?>"></div>
					</div>					
					
					</div>
					<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment">9.Indian Address <span class="text-red">*</span></label>	
							<div class="form-group col-md-12 pdleft">							
						  <textarea class="form-control" rows="3" id="india_address" name="india_address" placeholder="Resident Details" required="true" ><?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['rp_service_no'];?></textarea>
					</div>
					
										
										
				 </div>
				</div>
					<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdright">
					<label>10.Email Id</label>	
						
						<div class="form-group col-md-4 pdleft"> <input type="email" readonly="true" name="email" class="form-control" placeholder="Email" id="email" required="true" value="<?php if(!empty($registerSfsData)) echo $registerSfsData[0]['email_id'];?>"></div>
						
					</div>
					
					
				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdright">	
					 <label for="comment">11.Permanent Unique ID  (Excluding Passport No.)<span class="text-red">*</span></label>
						<div class="form-group col-md-4 pdleft">
						  <input type="text" class="form-control" id="unique_id" name="unique_id" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '" placeholder="Unique ID" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['unique_id'];?>"/>
						</div>
				
				</div>
				
				
				<div class="name-sec col-xs-12 col-sm-5 col-md-7">
					<h4><strong>12 .Details of Father/Guardian <span class="text-red">*</span></strong></h4>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Name <span class="text-red">*</span></label>
                   <div class="form-group date">
                       <input type="text" class="form-control" placeholder="Name" id="guardian_name" name="guardian_name" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['guardian_name'];?>"/>
                   </div>
                </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Relation <span class="text-red">*</span></label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Relation" id="guardian_relation" name="guardian_relation" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['guardian_relation'];?>"/>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Occupation <span class="text-red">*</span></label>
                   <div class="form-group date">
                      <input type="text" class="form-control" placeholder="Occupation" id="guardian_occupation" name="guardian_occupation" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['guardian_occupation'];?>"/>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Country <span class="text-red">*</span></label>
                   <div class="form-group">
                      <select class="selectpicker form-control" id="guardian_nationality" name="guardian_nationality" required="true">
                        <option value="">---- Select ---</option>
						  <?php
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $na)
						  {
						  	if(!empty($applicaitonSfsStepOne))
						  	{
								if($applicaitonSfsStepOne[0]['guardian_nationality'] == $na['id'])
								{
									echo '<option selected="selected" value="'.$na['id'].'">'.$na['country_name'].'</option>';
								}
								else
								{
									echo '<option value="'.$na['id'].'">'.$country['country_name'].'</option>';
								}
							}
							else
							{
								echo '<option value="'.$na['id'].'">'.$na['country_name'].'</option>';
							}
						  	
						  }
						  ?>
                      </select>
                   </div>
                </div>               	
               </div> 
              <div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment"> Address <span class="text-red">*</span></label>	
							<div class="form-group col-md-12 pdleft">							
						  <textarea class="form-control" rows="3" id="guardian_address" name="guardian_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['guardian_address'];?></textarea>
					</div>			
				 </div>
				</div>	
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">
					   <input name="gardiuan_address_city" pattern="^[a-zA-Z ]+$" title="[A-Z,a-z]" type="text" class="form-control" placeholder="City" id="gardiuan_address_city" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['gardiuan_address_city'];?>">
					</div>
					<div class="form-group col-md-12 pdleft">
					   <input name="gardiuan_address_state" pattern="^[a-zA-Z ]+$" title="[A-Z,a-z]" type="text" class="form-control" placeholder="State" id="gardiuan_address_state" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['gardiuan_address_state'];?>">
					</div>
</div>
				</div>	
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">
					   <select id="gardiuan_address_country" name="gardiuan_address_country" class="selectpicker form-control" required="true">
						  <option value="">---- Country ---</option>
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonSfsStepOne))
						  	{
								if($applicaitonSfsStepOne[0]['gardiuan_address_country'] == $country['id'])
								{
									echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
								}
								else
								{
									echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
								}
							}
							else
							{
								echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
							}
						  	
						  }
						  ?>
						</select>
					</div>
					<div class="form-group col-md-12 pdleft">
					   <input name="gardiuan_address_pincode" pattern="^[a-zA-Z0-9 ]+$" title="[a-zA-Z0-9 ]" type="text" class="form-control" placeholder="Zipcode" id="gardiuan_address_pincode" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['gardiuan_address_pincode'];?>">
					</div>
					</div>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                <div class="name-sec col-xs-12 col-sm-6 col-md-4">
					 <label for="comment">13. Knowledge of English <span class="text-red">*</span></label>
					<div class="form-group">
					  
					  	 <?php $knowledge = '';
						  if(count($applicaitonSfsStepOne) > 0)
						  {
						  	$knowledge = $applicaitonSfsStepOne[0]['knowledge_english'];
						  }
						  
						  if($knowledge == 1)
						  {
						  ?>
						    <input checked="true" class="is_knwldge" type="radio" value="1" name="knowledge_english" id="knowledge_english"/> Yes
					  		<input type="radio" class="is_knwldge" value="2" name="knowledge_english" id="knowledge_english"/> No
						  <?php	
						  }
						  elseif($knowledge == 2)
						  {
						  ?>
						   <input type="radio" class="is_knwldge" value="1" name="knowledge_english" id="knowledge_english"/> Yes
					 	   <input checked="true" class="is_knwldge" type="radio" value="2" name="knowledge_english" id="knowledge_english"/> No
						  <?php		
						  }
						  else
						  {
						  ?>
						  	<input type="radio" class="is_knwldge" value="1" name="knowledge_english" id="knowledge_english"/> Yes
					  		<input type="radio" class="is_knwldge" value="2" name="knowledge_english" id="knowledge_english" checked="true"/> No
						  <?php	
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
						if($applicaitonSfsStepOne[0]['knowledge_english_written'] == 1)
						{
							?>
						   <input type="radio" checked="true" value="1" name="knowledge_english_written" id="knowledge_english_written "/> Average
						   <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/> Good
						   <?php
							
						}
						elseif($applicaitonSfsStepOne[0]['knowledge_english_written'] == 2)
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/> Average
						   <input type="radio" checked="true" value="2" name="knowledge_english_written" id="knowledge_english_written"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/> Good
						   <?php
						}
						elseif($applicaitonSfsStepOne[0]['knowledge_english_written'] == 3)
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/> Average
						   <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/> Proficient
						   <input type="radio" checked="true" value="3" name="knowledge_english_written" id="knowledge_english_written"/> Good
						   <?php
						}
						else
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/> Average
						   <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/> Good
						   <?php
						}
						?>					   
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-4 knwledge_eng">
					<label for="comment">Spoken:</label>
					<div class="form-group">
					<?php 
						if($applicaitonSfsStepOne[0]['knowledge_english_spoken'] == 1)
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken" checked="true"/> Average
						   <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Good
						   <?php
							
						}
						elseif($applicaitonSfsStepOne[0]['knowledge_english_spoken'] == 2)
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Average
						   <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken" checked="true"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Good
						   <?php
						}
						elseif($applicaitonSfsStepOne[0]['knowledge_english_spoken'] == 3)
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Average
						   <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken" checked="true"/> Good
						   <?php
						}
						else
						{
							?>
						  <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Average
					   <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Proficient
					   <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Good
						   <?php
						}
						?>
					    
					</div>
				 </div>	
					<?php	
					}
					else
					{
					?>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-4 knwledge_eng fade">
					<label for="comment">Written:</label>
					<div class="form-group">
					   <input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/> Average
					   <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/> Proficient
					   <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/> Good
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-4 knwledge_eng fade">
					<label for="comment">Spoken:</label>
					<div class="form-group">
					    <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Average
					   <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Proficient
					   <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Good
					</div>
				 </div>	
					<?php		
					}	
				 ?>
				</div> 
				</div>	
				<div>						
					<div class="name-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<div class="name-sec col-xs-12 col-sm-3 col-md-3">
					 <label for="comment">14. Level of Programme <span class="text-red">*</span></label>
						<div class="form-group">
						  <select id="programme" name="programme" class="form-control" required="true">						 	
						  	<option value="">Select Programme</option>
						  	<?php 
						  		$programme = $this->common_model->getAllProgramme();
								//$programme = $this->common_model->getAllPhdProgramme();
						  		//echo "<pre>";
								//print_r($programme);die;
						  		$res = array(8 => $programme[7]);
						  		$ress = array_merge(array_slice($programme, 0, 4), $res, array_slice($programme, 4));
						  		unset($ress[8]);	
						  		foreach($ress as $program)
						  		{
									if(!empty($applicaitonSfsStepOne))
								  	{
								  		if($applicaitonSfsStepOne[0]['programme'] == $program['id'])
								  		{
											echo '<option selected="selected" value="'.$program['id'].'">'.$program['name'].'</option>';
										}
										else
										{
											echo '<option value="'.$program['id'].'">'.$program['name'].'</option>';
										}
									}
									else
									{
										echo '<option value="'.$program['id'].'">'.$program['name'].'</option>';
									}
								}
						  	?>						 	
						 </select>
						</div>
					</div>
					
					
					
					
					
					<div class="name-sec col-xs-6 col-sm-2 col-md-2 course_type" required="true">
						 <label for="comment">Year</label>
							<div class="form-group">
							  <select id="course_year" name="course_year" class="form-control">						 	
							 <option value="">Select Year</option>
							 <?php  if($applicaitonSfsStepOne[0]['course_year'] == 1)
						{
							?>
							<option value = "1" selected = "true">I Year</option>
							<option value = "2">II Year</option>
							<option value = "3">III Year</option>	
							<?php
						} elseif($applicaitonSfsStepOne[0]['course_year'] == 2)
						{
							?>
							<option value = "1">I Year</option>
							<option value = "2" selected = "true">II Year</option>
							<option value = "3">III Year</option>	
							<?php
						} elseif($applicaitonSfsStepOne[0]['course_year'] == 3)
						{
							?>
							<option value = "1">I Year</option>
							<option value = "2">II Year</option>
							<option value = "3" selected = "true">III Year</option>	
							<?php
						}
						else{
							?>
							
							
							<option value = "1">I Year</option>
							<option value = "2">II Year</option>
							<option value = "3">III Year</option>	
							
							
							<?php
							
						}
							?>
							
							 </select>
							</div>
						</div>
					
					<?php
					if(count($applicaitonSfsStepOne)>0 && $applicaitonSfsStepOne[0]['programme'] == 1 || $applicaitonSfsStepOne[0]['programme'] == 2 || $applicaitonSfsStepOne[0]['programme'] == 3 || $applicaitonSfsStepOne[0]['programme'] == 4 || $applicaitonSfsStepOne[0]['programme'] == 9)
					{
					?>
						<div class="name-sec col-xs-6 col-sm-2 col-md-2 course_type" required="true">
						 <label for="comment">Course Types </label>
							<div class="form-group">
							  <select id="course_type" name="course_type" class="form-control">						 	
							  	<option value="">Select Course</option>
							  	<?php 
							  		//$courseType = $this->common_model->getAllPhdCourseType($applicaitonSfsStepOne[0]['programme']);
						         $courseType = $this->common_model->getAllCourseType();
							  		foreach($courseType as $ctype)
							  		{
										if(!empty($applicaitonSfsStepOne))
									  	{
									  		if($applicaitonSfsStepOne[0]['course_type'] == $ctype['id'])
									  		{
												echo '<option selected="selected" value="'.$ctype['id'].'">'.$ctype['course_type'].'</option>';
											}
											else
											{
												echo '<option value="'.$ctype['id'].'">'.$ctype['course_type'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$ctype['id'].'">'.$ctype['course_type'].'</option>';
										}
									}
							  	?>						 	
							 </select>
							</div>
						</div>
						
					<?php	
					}
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_type fade" style="display:none;">
						 <label for="comment">Course Types <span class="text-red">*</span></label>
							<div class="form-group">
							  <select id="course_type" name="course_type" class="form-control">						 	
							  	<option value="">Select Course</option>
							  	<?php 
							  		$courseType = $this->common_model->getAllCourseType();
							  		
							  		foreach($courseType as $ctype)
							  		{
										if(!empty($applicaitonSfsStepOne))
									  	{
									  		if($applicaitonSfsStepOne[0]['course_type'] == $program['id'])
									  		{
												echo '<option selected="selected" value="'.$program['id'].'">'.$program['course_type'].'</option>';
											}
											else
											{
												echo '<option value="'.$ctype['id'].'">'.$ctype['course_type'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$ctype['id'].'">'.$ctype['course_type'].'</option>';
										}
									}
							  	?>						 	
							 </select>
							</div>
						</div>
						<?php	
					}
					?>	
					<?php
					if(count($applicaitonSfsStepOne)>0 && $applicaitonSfsStepOne[0]['programme'] == 3 || $applicaitonSfsStepOne[0]['programme'] == 4 || $applicaitonSfsStepOne[0]['programme'] == 8)
					{
					?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 cours_subject" required="true">
						 <label for="comment">Subject </label>
							<div class="form-group col-md-5 pdleft">							  
							  	<input type="text" name="course_subject" id="course_subject" class="form-control" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]["course_subject"];  ?>"/>					 	
							</div>
						</div>
						
						
					<?php	
					}
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 cours_subject" style="display:none;">
						 <label for="comment">Subject </label>
							<div class="form-group col-md-5 pdleft">							  
							  	<input type="text" name="course_subject" id="course_subject" class="form-control"/>					 	
							</div>
						</div>
						<?php	
					}
					?>	
												
				</div>
				
				</div>
				<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-3 col-md-5">
						 <label for="comment">15.Universities/Institutes Name:<span class="text-red">*</span></label>
							<div class="form-group col-md-9 pdleft">
							  <input type="text" name="university" class="form-control" placeholder="University" id="region" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['university'];?>">
							</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-4">
					 <label for="comment">Region<span class="text-red">*</span></label>
						<div class="form-group">
						 <div class="form-group">
						<select id="region" name="region" class="selectpicker form-control" required="true">
						  <!-----<option value="">---- Region ---</option>---->
						  <?php
						  $regions = $this->common_model->getAllRegions();
						  foreach($regions as $region)
						  {
						  	if(!empty($applicaitonSfsStepOne))
						  	{
								if($applicaitonSfsStepOne[0]['region'] == $region['id'])
								{
									echo '<option selected="selected" value="'.$region['id'].'">'.$region['name'].'</option>';
								}
								else
								{
									echo '<option value="'.$region['id'].'">'.$region['name'].'</option>';
								}
							}
							else
							{
								echo '<option value="'.$region['id'].'">'.$region['name'].'</option>';
							}
						  	
						  }
						  ?>
						</select>
						</div>
						</div>
					</div>
					<!-----<div class="name-sec col-xs-12 col-sm-3 col-md-4">
					 <label for="comment">Region(ICCR RO) <span class="text-red">*</span></label>
						<div class="form-group">
					<input type="text" name="region" class="form-control" placeholder="Region(ICCR RO)" id="region" required="true" value="<?php if(!empty($applicaitonSfsStepOne)) echo $applicaitonSfsStepOne[0]['region'];?>">
						</div>
						
					</div>--->
					</div>
				 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">
					
					
					<div class="form-group">
						<span class="note1"><strong>Note: </strong>Once admission is confirmed, no change in either course or University/Institute will be permitted by the Council.
						<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allotment of colleges is done by the respective Universities.</span>
						<br/>
						
						<?php 
						if(!empty($applicaitonSfsStepOne)) 
						{
							 if($applicaitonSfsStepOne[0]['agreedisagree'] != "")
							 {
							 	if($applicaitonSfsStepOne[0]['agreedisagree']==1)
							 	{
								?>
								I agree <input checked="true" type="radio" required="true"  value="1" name="agreedisagree" id="agreedisagree">
						  I disagree <input type="radio" required="true" id="agreedisagree" value="2" name="agreedisagree"/>
								<?php	
								}
								elseif($applicaitonSfsStepOne[0]['agreedisagree']==2)
							 	{
								?>
								I agree <input  type="radio" required="true"  value="1" name="agreedisagree" id="agreedisagree">
						  I disagree <input checked="true" type="radio" required="true" id="agreedisagree" value="2" name="agreedisagree"/>
								<?php	
								}
								
							 }
							 else
							 	{
									?>
								I agree <input checked="true"  type="radio" required="true"  value="1" name="agreedisagree" id="agreedisagree">
						  I disagree <input  type="radio" required="true" id="agreedisagree" value="2" name="agreedisagree"/>
								<?php
								}
						}
						else
					 	{
							?>
						I agree <input checked="true" type="radio" required="true"  value="1" name="agreedisagree" id="agreedisagree">
				  I disagree <input  type="radio" required="true" id="agreedisagree" value="2" name="agreedisagree"/>
						<?php
						}
						
						?>
						 
						  </span><br/>
						
					</div>										
				 </div>
				 </div>
				<!--<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">				
				 <input type="submit" id="step-one-application" name="step-one-application" class="form-control sbmt" value="Save & Continue to Page 2"/>
                
              	</div>-->
              	<div class="name-sec col-xs-4 col-sm-2 col-md-2 pull-right">				
				 <input type="submit" id="step-one-application" name="step-one-application" class="form-control btn btn-info" value="Next >>"/>
				 <!--<a href="<?php echo site_url();?>applicant/applicant_education_info?appno=VD0130633969883" class="form-control sbmt">Save & Continue to Page 2</a>-->
                
              	</div>
              </div>
              <!-- /.box-body -->
            <?php echo form_close(); ?>
	  </div>	   
	</div>
	</div>
</section>

 <div id="profileSfsUploadsPic" class="modal fade" role="dialog">
  	<div id="profileSfsPic" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Hereother</span></div>
  		</div>
  </div>
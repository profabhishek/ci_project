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
</style>
<?php 
//echo "<pre>";
//print_r($registerData);die;

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
//console.log(stateuniversities);
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
		<h3 class="text-center caps">Application Form(2025-2026) For Scholarship through ICCR</h3>
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
	
	<!-----<script type="text/javascript">
		window.history.pushState({}, "Indian Council for Cultural Relations",  baseURL + 'applicant/applicant_personal_info_prev?appno=' + '<?php echo $get_application_number; ?>');
	</script>---->
	<div class="tab-content">		
	  <div id="home" class="tab-pane fade in active">	 
	    <?php
		//$data = array('onsubmit' => "return smtProfilePic();"); 
	    $hidden = array($this->security->get_csrf_token_name() => $this->security->get_csrf_hash());
		echo form_open('applicant/applicant_education_info?appno='.$get_application_number,array('onsubmit'=>'return validateFieldsPersonalInfo()')); 
		
		?>	    	 
	    	 
              <div class="box-body">
              	<div class="col-xs-3 prfl pull-right" >
              		<?php 
              			if($userImage == "")
              			{
						?>
						<img id="profil_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png" />
						<a href="javascript:void(0);" data-toggle="modal" data-target="#profileUploadsPic">Upload Profile Pic</a>
						<?php	
						}
						else
						{
						?>
						<img id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"  />
						<a href="javascript:void(0);" data-toggle="modal" data-target="#profileUploadsPic">Re-Upload Profile Pic</a>
						<?php		
						}
              		?>	
              	</div>
			
              	<div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">
              		<div class="name-sec col-xs-12 col-sm-5 col-md-7">
	              	
	              	</div>
	              	
					<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<label>1. Full Name (IN BLOCK LETTERS)<span class="text-red">*</span></label>
					<div class="col-xs-2 col-md-2 col-sm-2 pdleft pdright">
					<div class="form-group">
					<select id="student_title" name="student_title" class="selectpicker form-control" required="true">
					  <?php $title = '';
						  if(count($applicaitonStepOne) > 0)
						  {
						  	$title = $applicaitonStepOne[0]['student_title'];
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
					<div class="col-xs-10 col-md-3 col-sm-3 pdright">
					<div class="form-group">
					<?php 
					$myname = "";
					if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['fullname'] != "") $myname = $applicaitonStepOne[0]['fullname'];
					else $myname = $registerData[0]['username'];
					?> <input type="text" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" name="fullname" class="form-control" placeholder="Full Name" id="fullname" value="<?php if(!empty($myname)) echo $myname;?>"  required="true"></div>					
					</div>	
					<div class="col-xs-3 col-md-3 col-sm-3 pdright">
					
						<?php
						$middlename = "";
					if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['middlename'] != "") $middlename = $applicaitonStepOne[0]['middlename'];
					else $myname = $registerData[0]['username'];
					?> <input type="text" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" name="middlename" class="form-control" placeholder="Middle Name" id="middlename" value="<?php if(!empty($middlename)) echo $middlename;?>">
						
					</div>
					<div class="col-xs-3 col-md-3 col-sm-3 pdright" class="text-red">
					
						<?php
						$familyname = "";
					if(!empty($applicaitonStepOne) && $applicaitonStepOne[0]['familyname'] != "") $familyname = $applicaitonStepOne[0]['familyname'];
					else $myname = $registerData[0]['username'];
					?> <input type="text" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" name="familyname" class="form-control" placeholder="Family Name" id="familyname" value="<?php if(!empty($familyname)) echo $familyname;?>"  required="true">
						
					</div>
					</div>	
					<div class="name-sec col-xs-12 col-sm-5 col-md-12">	
					<label>2. Gender<span class="text-red">*</span></label>			
						<div class="form-group">	
						  <?php $title = '';
						  if(count($registerData) > 0)
						  {
						  	$title = $registerData[0]['gender'];
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
						 <label for="comment">3. Date of Birth<span class="text-red">*</span></label>
							<div class="form-group col-md-9 pdleft">
							  <input type="text" readonly="true" class="form-control" placeholder="yy-mm-dd" id="dob" name="dob" value="<?php if(!empty($registerData)) echo $registerData[0]['date_of_birth'];?>"/>
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
						  	if(!empty($registerData))
						  	{
								if($registerData[0]['country_of_domicile'] == $na['id'])
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
					 <label for="comment">4. Nationality<span class="text-red">*</span></label>
						<div class="form-group col-md-9 pdleft">
						  <select id="country" name="country" class="selectpicker form-control" required="true">
						  <option value="">---- Select ---</option>
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['country'] == $country['id'])
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
					
					<?php if(!empty($registerData))
						  	{
								if($registerData[0]['country_of_domicile'] == '75')
								{
									?>
<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-5">
					 <label for="comment">5. Passport No<span class="text-red">*</span></label>
						<div class="form-group col-md-9 pdleft">
						  <input type="text" name="passport_no" class="form-control" placeholder="Passport No" readonly="true" id="passport_no" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '"  value="<?php if(!empty($registerData)) echo $registerData[0]['passport_no'];?>"/>
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
						  <input type="text" name="passport_no" class="form-control" readonly="true" placeholder="Passport No" id="passport_no" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '"  value="<?php if(!empty($registerData)) echo $registerData[0]['passport_no'];?>"/>
						</div>
					</div>
					
				</div>
									<?php
									
								}
							
							}

							?>
				
				
				
				<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<div class="name-sec col-xs-12 col-sm-3 col-md-6">
					 <label for="comment">a) Date of Issue<span class="text-red">*</span></label>
						<div class="form-group col-md-4 pdleft">						
						 <select class="form-control" id="passport_issue_date" name="passport_issue_date">
						 <option value="">Date</option>
					 		<?php						 		
					 		for($i=1; $i<=31;$i++)
					 		{
					 			if(!empty($applicaitonStepOne))
					 			{
					 				$date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
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
					 			if(!empty($applicaitonStepOne))
					 			{
					 				$date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
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
						  		if(!empty($applicaitonStepOne))
					 			{
					 				$date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
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
					 <label for="comment">b) Date of Expiry<span class="text-red">*</span></label>
						<div class="form-group col-md-4">						
						 <select class="form-control" id="passport_expiry_date" name="passport_expiry_date" >
								<option value="">Date</option>
								<?php						 		
						 		for($i=1; $i<=31;$i++)
						 		{
						 			if(!empty($applicaitonStepOne))
						 			{
						 				$date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
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
					 			if(!empty($applicaitonStepOne))
					 			{
					 				$date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
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
						  		if(!empty($applicaitonStepOne))
					 			{
					 				$date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
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
					 <label for="comment">c) Place of Issue<span class="text-red">*</span></label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Place of Issue" id="passport_issue_place" name="passport_issue_place"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place'];?>"/>
						
					
	
						</div>
					</div>
				</div>
				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment">6. Postal Address <span class="text-red">*</span></label>	
							<div class="form-group col-md-12 pdleft">							
						  <textarea class="form-control" rows="3" id="postal_address" name="postal_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address'];?></textarea>
					</div>
					
										
				 </div>
				</div>	
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">
					   <input name="postal_address_city" pattern="^[a-zA-Z ]+$" title="[a-zA-Z ]" type="text" class="form-control" placeholder="City" id="postal_address_city" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_city'];?>">
					</div>
					<div class="form-group col-md-12 pdleft">
					   <input name="postal_address_state" pattern="^[a-zA-Z ]+$" title="[a-zA-Z ]" type="text" class="form-control" placeholder="State" id="postal_address_state" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_state'];?>">
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
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['postal_address_country'] == $country['id'])
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
					   <input name="postal_address_pincode" title="[a-zA-Z0-9 ]" pattern="^[a-zA-Z0-9 ]+$" maxlength="11" type="text" class="form-control" placeholder="Zipcode" id="postal_address_pincode" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_pincode'];?>">
					</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-7 col-md-12 contact-detail">
					<label>7. Telephone/Mobile Number <span class="text-red">*</span><!--<span class="note"><strong>Note:</strong> (Telephone Number With Country Code eg. : 91 for India)</span>--></label>
					<!--<div class="col-xs-12 col-md-1 col-sm-4 pdleft" style="padding: 0px;">
					<div class="form-group"> <input type="text" id="tel_country_code" class="form-control" placeholder="" name="tel_country_code" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['tel_country_code'];?>"></div>
					</div>-->
					<!--<div class="col-xs-1 col-md-0 col-sm-1" style="font-weight:bold;margin-left:13px;margin-right:20px;padding-bottom:0;padding-top:0;text-align: center;width:20px;"><span>+</span>
					</div>-->
					
					<div class="col-xs-12 col-md-4 col-sm-5 pdleft">
					<div class="form-group">
					 <input name="phone" pattern= "[0-9]" readonly="true" title="[0-9]" type="text" class="form-control" placeholder="Telephone No." id="phone" required="true" value="<?php if(!empty($registerData)) echo $registerData[0]['mobile_number'];?>"></div>
					</div>					
					
					</div>
					<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdright">
					<label>Email Id<span class="text-red">*</span></label>	
						
						<div class="form-group col-md-4 pdleft"> <input type="email" readonly="true" name="email" class="form-control" placeholder="Email" id="email" required="true" value="<?php if(!empty($registerData)) echo $registerData[0]['email_id'];?>"></div>
						
					</div>
					
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdright">	
					 <label for="comment">Permanent Unique ID of your country (Excluding Passport No.)<span class="text-red">*</span></label>
						<div class="form-group col-md-4 pdleft">
						  <input type="text" class="form-control" id="unique_id" name="unique_id" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '" placeholder="Unique ID" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['unique_id'];?>"/>
						</div>
				
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-7">
					<h4><strong>Details of Father/Mother/Guardian <span class="text-red">*</span></strong></h4>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Name <span class="text-red">*</span></label>
                   <div class="form-group date">
                       <input type="text" class="form-control" placeholder="Name" id="guardian_name" name="guardian_name" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_name'];?>"/>
                   </div>
                </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Relation <span class="text-red">*</span></label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Relation" id="guardian_relation" name="guardian_relation" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_relation'];?>"/>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Occupation <span class="text-red">*</span></label>
                   <div class="form-group date">
                      <input type="text" class="form-control" placeholder="Occupation" id="guardian_occupation" name="guardian_occupation" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_occupation'];?>"/>
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
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['guardian_nationality'] == $na['id'])
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
						  <textarea class="form-control" rows="3" id="guardian_address" name="guardian_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_address'];?></textarea>
					</div>			
				 </div>
				</div>	
				<div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
				<label for="comment"></label>	
				<div class="form-group col-md-12 pdleft">
					   <input name="gardiuan_address_city" pattern="^[a-zA-Z ]+$" title="[A-Z,a-z]" type="text" class="form-control" placeholder="City" id="gardiuan_address_city" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_city'];?>">
					</div>
					<div class="form-group col-md-12 pdleft">
					   <input name="gardiuan_address_state" pattern="^[a-zA-Z ]+$" title="[A-Z,a-z]" type="text" class="form-control" placeholder="State" id="gardiuan_address_state" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_state'];?>">
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
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['gardiuan_address_country'] == $country['id'])
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
					   <input name="gardiuan_address_pincode" pattern="^[a-zA-Z0-9 ]+$" title="[a-zA-Z0-9 ]" type="text" class="form-control" placeholder="Zipcode" id="gardiuan_address_pincode" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_pincode'];?>">
					</div>
					</div>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                <div class="name-sec col-xs-12 col-sm-6 col-md-4">
					 <label for="comment">8. Knowledge of English <span class="text-red">*</span></label>
					<div class="form-group">
					  
					  	 <?php $knowledge = '';
						  if(count($applicaitonStepOne) > 0)
						  {
						  	$knowledge = $applicaitonStepOne[0]['knowledge_english'];
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
						if($applicaitonStepOne[0]['knowledge_english_written'] == 1)
						{
							?>
						   <input type="radio" checked="true" value="1" name="knowledge_english_written" id="knowledge_english_written "/> Average
						   <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/> Good
						   <?php
							
						}
						elseif($applicaitonStepOne[0]['knowledge_english_written'] == 2)
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/> Average
						   <input type="radio" checked="true" value="2" name="knowledge_english_written" id="knowledge_english_written"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/> Good
						   <?php
						}
						elseif($applicaitonStepOne[0]['knowledge_english_written'] == 3)
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
						if($applicaitonStepOne[0]['knowledge_english_spoken'] == 1)
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken" checked="true"/> Average
						   <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Good
						   <?php
							
						}
						elseif($applicaitonStepOne[0]['knowledge_english_spoken'] == 2)
						{
							?>
						   <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Average
						   <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken" checked="true"/> Proficient
						   <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/> Good
						   <?php
						}
						elseif($applicaitonStepOne[0]['knowledge_english_spoken'] == 3)
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
				 	<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">						
					<div class="name-sec col-xs-12 col-sm-3 col-md-4">
					 <label for="comment">9. Course applied for<span class="text-red">*</span></label>
						<div class="form-group col-md-10 pdleft">
						<?php $user_data = $this->session->userdata('user_data');
						//echo "<pre>";print_r($user_data);die;
							$student_type = $user_data['student_type'];	
							$student_course_type = $user_data['apply_course_type'];	?>
						  <!-----<select id="programme" name="programme" class="form-control" required="true">---->		
							<select id="<?php 
						  if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2){
							  echo 'programmeayush';
							}
							  elseif($student_type == 1 && $student_course_type == 4 || $student_type == NULL && $student_course_type == 4){
							  echo 'programmeayush';
							}
							else
							{
								echo 'programme';
							};?>" name="programme" class="form-control" required="true" >	
						  	<option value="">Select Programme</option>
						  	<?php 
							if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2)
								{
									$programme = $this->common_model->getAllAyushProgramme();
								}
								elseif($student_type == 1 && $student_course_type == 4 || $student_type == NULL && $student_course_type == 4)
								{
									$programme = $this->common_model->getAllProgrammeWithoutAyush();
								}
								else
								{
									$programme = $this->common_model->getAllPhdProgramme();
								}
						  		//$programme = $this->common_model->getAllProgramme();
								//$programme = $this->common_model->getAllPhdProgramme();
						  		$res = array(8 => $programme[7]);
						  		$ress = array_merge(array_slice($programme, 0, 4), $res, array_slice($programme, 4));
						  		unset($ress[8]);	
						  		foreach($ress as $program)
						  		{
									if(!empty($applicaitonStepOne))
								  	{
								  		if($applicaitonStepOne[0]['programme'] == $program['id'])
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
					<?php
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 9)
					{
					?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_type" required="true">
						 <label for="comment">Course Types draft s</label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_type" name="course_type" class="form-control">						 	
							  	<option value="">Select Course</option>
							  	<?php 
								if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2){
										$courseType =  $this->common_model->getAllAyushCourseType();
									}
									elseif($student_type == 1 && $student_course_type == 4 || $student_type == NULL && $student_course_type == 4){
										$courseType =  $this->common_model->getAllCourseTypeWithoutAyush();
										//echo "<pre>";print_r($courseType);
									}
									else
									{
										$courseType =  $this->common_model->getCourseTypes();
									}
							  		//$courseType = $this->common_model->getAllPhdCourseType($applicaitonStepOne[0]['programme']);
						
							  		foreach($courseType as $ctype)
							  		{
										if(!empty($applicaitonStepOne))
									  	{
									  		if($applicaitonStepOne[0]['course_type'] == $ctype['id'])
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
							<div class="form-group col-md-10 pdleft">
							  <!----<select id="course_type" name="course_type" class="form-control">--->
								<?php  $user_data = $this->session->userdata('user_data');
								$student_type = $user_data['student_type'];	
								$student_course_type = $user_data['apply_course_type'];	 ?>
							  <select id="<?php 
									  if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2)
								   {
									echo 'course_types';
								   }
								   elseif($student_type == 1 && $student_course_type == 4 || $student_type == NULL && $student_course_type == 4)
								   {
									echo 'course_types';
								   }
									else
									{
									  echo 'course_type';
						  };
						  ?>" name="course_type" class="form-control">								  
							  	<option value="">Select Course</option>
							  	<?php 
								
									if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2){
										$courseType =  $this->common_model->getAllAyushCourseType();
									}
									elseif($student_type == 1 && $student_course_type == 4 || $student_type == NULL && $student_course_type == 4){
										$courseType =  $this->common_model->getAllCourseTypeWithoutAyush();
										//echo "<pre>";print_r($courseType);
									}
									else
									{
										$courseType =  $this->common_model->getCourseTypes();
									}
							  		//$courseType = $this->common_model->getAllPhdCourseType($applicaitonStepOne[0]['programme']);
							  		
							  		foreach($courseType as $ctype)
							  		{
										if(!empty($applicaitonStepOne))
									  	{
									  		if($applicaitonStepOne[0]['course_type'] == $program['id'])
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
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
					{
					?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 cours_subject" required="true">
						 <label for="comment">Subject </label>
							<div class="form-group col-md-10 pdleft">							  
							  	<input type="text" name="course_subject" id="course_subject" class="form-control" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]["course_subject"];  ?>"/>					 	
							</div>
						</div>
					<?php	
					}
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 cours_subject" style="display:none;">
						 <label for="comment">Subject </label>
							<div class="form-group col-md-10 pdleft">							  
							  	<input type="text" name="course_subject" id="course_subject" class="form-control"/>					 	
							</div>
						</div>
						<?php	
					}
					?>	
													
				</div>
<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">						
					<div class="name-sec col-xs-12 col-sm-3 col-md-12">
					 <label for="comment">10. Universities/Institutes in India where you wish to seek admission:<span class="text-red">*</span></label>
					 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12 pdleft">					
					<div class="form-group">
						<span class="note1"><strong>Note: </strong>ICCR provides scholarships only for courses in Central or State Goverment Universities. Candidates should be very specific and clear about the course of study which he/she wishes to pursue in India. Scholarships are not available to pursue more than one course. Candidates should ensure that the courses opted are offered by the Universities selected under the dropdown menu given below. The candidates must refer to the University/Institute website to know the availability of course in that University and eligibility criteria for the courses of their choice. Those seeking admission to agricultural courses must opt for <b>ICAR</b> in the University choice. Those seeking admission to Ayurveda, Yoga, Unani, Siddha and Homoeopathy course must opt for <b>AYUSH</b> in the University choice.</span>
						<span>Please select Univesrity in order of preference.</span>
					</div>										
				 </div>
				 </div>
					</div>					
				</div>
				<?php
				if(count($applicaitonStepOne)<=0 || count($applicaitonStepOne)>0)
				{
					
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv1">	
					<?php
					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-4 pdleft pdright unidiv1">	
					<?php	
					}
					elseif(count($applicaitonStepOne)<=0)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv1">	
					<?php	
					}
					
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course" name="course" class="form-control">						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
							<?php	
						}
						elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course" name="course" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}
						elseif($applicaitonStepOne[0]['programme'] == 9)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course" name="course" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}

					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_wish_study" style="display:none;">
						 	<label for="comment">course you wish to study <span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course" name="course" class="form-control">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php	
					}	
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
						 	<label for="comment">course you wish to study 1 <span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course" name="course" class="form-control course">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php
					}				
					?>	
					
					<?php
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-12 unidiv">
						 <label for="comment">University 1 </label>
					<div class="form-group col-md-10 pdleft">
						
						 <select id="universty_choice" name="universty_choice"  class="form-control" onchange="selectUniversityChoice(this.value)"  required="true">	
						 <option value="">Select</option>							 
						 		<?php						 
						 	if(count($applicaitonStepOne)>0)
						 	{						 		
						 		if($applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}	
								elseif($applicaitonStepOne[0]['programme'] == 7)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}							
							}	
						    ?>							 	
						 </select>
						
						</div>
					</div>	
						<?php
					}	
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6 || $applicaitonStepOne[0]['programme'] == 9)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 1 draft 1	</label>
					<div class="form-group col-md-10 pdleft">						
						 <select id="universty_choice" name="universty_choice"  class="form-control" onchange="selectUniversityChoice(this.value)"  required="true">
						 	<option value="">Select</option>	
						 	<?php						 
						 	if($applicaitonStepOne[0]['programme']>0)
						 	{
						 		if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						 		{
						 			if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				foreach($ayush as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 2)
						 			{						 				
						 				foreach($icaruni as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 3 || $applicaitonStepOne[0]['course_type'] == 4 || $applicaitonStepOne[0]['course_type'] == 6 || $applicaitonStepOne[0]['course_type'] == 7 || $applicaitonStepOne[0]['course_type'] == 8 || $applicaitonStepOne[0]['course_type'] == 9)
									{
										echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
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
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
														}
														else
														{
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}	
													}
													echo '</optgroup>';			
												}	
											}
										    echo '</optgroup>';	
										    echo '<optgroup label="Central Universities">';
										    foreach($centraluniversities as $univercity_cnet)
											{								
												if(!empty($applicaitonStepOne))
											  	{
													if($applicaitonStepOne[0]['universty_choice'] == $univercity_cnet['id'])
													{
														echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
													else
													{
														echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
												}
										    }
										     echo '</optgroup>';
									}
									elseif($applicaitonStepOne[0]['course_type'] == 5)
									{
										
										
										echo '<optgroup label="State Universities-------------">';
										foreach($stateuniversities as $univercity)
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
													if(!empty($applicaitonStepOne))
												  	{											  		
														if($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id'])
														{
															echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
														else
														{														
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
													}
													else
													{
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}	
												}
												echo '</optgroup>';			
											}	
										}
										echo '</optgroup>';
										echo '<optgroup label="National Institute of Technology (NIT)">';
									    foreach($nits as $univercity_nit)
										{								
											if(!empty($applicaitonStepOne))
										  	{
												if($applicaitonStepOne[0]['universty_choice'] == $univercity_nit['id'])
												{
													echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
												else
												{
													echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
									    }
										echo '</optgroup>';
									}
									
								}
						 		if($applicaitonStepOne[0]['programme'] == 9)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}
								elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
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
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 1 </label>
					<div class="form-group col-md-10 pdleft">	
					<?php
							$user_data = $this->session->userdata('user_data');
							$student_type = $user_data['student_type'];	
							$student_course_type = $user_data['apply_course_type'];	
					
						 if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2)
				{
					?>
					 <select id="universty_choice" name="universty_choice"  class="form-control universty_choice_cl" onchange="selectAyushUniversityChoice(this.value)" required="true">
					<?php
				}
				else
				{
					?>
					 <select id="universty_choice" name="universty_choice"  class="form-control universty_choice_cl"  required="true" onchange="selectUgUniversityChoice(this.value)">
					<?php
					
				}
						?>
						<option value="">Select</option>							 								 	
						 </select>
						
						</div>
					</div>	
					
						<?php
					}
									
					
						if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name">
							 <label for="comment">Course Stream </label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name" id="course_option_name" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name'];?>"/>
								</div>
							</div>
							<?php	
							}
							else
							{
								?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name" style="display:none;">
							 <label for="comment">Course Stream 1 latest</label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name" id="course_option_name" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name'];?>"/>
								</div>
							</div>
							<?php
							}
						}
						else
						{
						?>
						<!------<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_option_name" style="display:none;">
						 <label for="comment">Course Stream 1 latest</label>
							<div class="form-group col-md-10 pdleft">
							  <input type="text" name="course_option_name" id="course_option_name" placeholder="Subject" class="form-control"/>
							</div>
						</div>----->
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_option_name" style="display:none;">
						 <label for="comment">Course Stream 1 latest</label>
							<div class="form-group col-md-10 pdleft">
							<select id="course_option_name" name="course_option_name" class="form-control">
							
							<option value="">Select Stream</option>
							
							
							
							</select>
							</div>
						</div>
						<?php	
						}
					?>
				</div>
				
				<?php
				if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv2">
					<?php
					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-4 pdleft pdright unidiv2">
					<?php	
					}
					elseif(count($applicaitonStepOne)<=0)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv2">
					<?php	
					}
					
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_two" name="course_two" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_two'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
							<?php	
						}
						elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_two" name="course_two" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_two'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}
						elseif($applicaitonStepOne[0]['programme'] == 9)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_two" name="course_two" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_two'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}

					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_wish_study" style="display:none;">
						 	<label for="comment">course you wish to study <span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_two" name="course_two" class="form-control">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php	
					}	
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
						 	<label for="comment">course you wish to study 2 <span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_two" name="course_two" class="form-control course_two">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php
					}				
					?>
					
					
					<?php
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-12 unidiv">
						 <label for="comment">University 2</label>
					<div class="form-group col-md-10 pdleft">
						
						<select id="universty_choice_two" name="universty_choice_two"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">	
						 <option value="">Select</option>							 
						 		<?php						 
						 	if(count($applicaitonStepOne)>0)
						 	{						 		
						 		if($applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice_two'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_two'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_two'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}		
								elseif($applicaitonStepOne[0]['programme'] == 7)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_two'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}						
							}	
						    ?>							 	
						 </select>
						
						</div>
					</div>	
						<?php
					}	
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6 || $applicaitonStepOne[0]['programme'] == 9)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 2</label>
					<div class="form-group col-md-10 pdleft">						
						 <select id="universty_choice_two" name="universty_choice_two"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">
						 	<option value="">Select</option>	
						 	<?php						 
						 	if($applicaitonStepOne[0]['programme']>0)
						 	{
						 		if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						 		{
						 			if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				foreach($ayush as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 2)
						 			{						 				
						 				foreach($icaruni as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 3 || $applicaitonStepOne[0]['course_type'] == 4 || $applicaitonStepOne[0]['course_type'] == 6 || $applicaitonStepOne[0]['course_type'] == 7 || $applicaitonStepOne[0]['course_type'] == 8 || $applicaitonStepOne[0]['course_type'] == 9)
									{
										echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
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
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice_two'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
														}
														else
														{
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}	
													}
													echo '</optgroup>';			
												}	
											}
										    echo '</optgroup>';	
										    echo '<optgroup label="Central Universities">';
										    foreach($centraluniversities as $univercity_cnet)
											{								
												if(!empty($applicaitonStepOne))
											  	{
													if($applicaitonStepOne[0]['universty_choice_two'] == $univercity_cnet['id'])
													{
														echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
													else
													{
														echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
												}
										    }
										     echo '</optgroup>';
									}
									elseif($applicaitonStepOne[0]['course_type'] == 5)
									{
										echo '<optgroup label="State Universities">';
										foreach($stateuniversities as $univercity)
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
													if(!empty($applicaitonStepOne))
												  	{											  		
														if($applicaitonStepOne[0]['universty_choice_two'] == $uni_choice['id'])
														{
															echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
														else
														{														
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
													}
													else
													{
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}	
												}
												echo '</optgroup>';			
											}	
										}
										echo '</optgroup>';
										echo '<optgroup label="National Institute of Technology (NIT)">';
									    foreach($nits as $univercity_nit)
										{								
											if(!empty($applicaitonStepOne))
										  	{
												if($applicaitonStepOne[0]['universty_choice_two'] == $univercity_nit['id'])
												{
													echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
												else
												{
													echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
									    }
										echo '</optgroup>';
									}
									
								}
						 		if($applicaitonStepOne[0]['programme'] == 9)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice_two'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_two'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_two'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}
								elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_two'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
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
					<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 2</label>
					<div class="form-group col-md-10 pdleft">		
							<?php
							$user_data = $this->session->userdata('user_data');
							$student_type = $user_data['student_type'];	
							$student_course_type = $user_data['apply_course_type'];	
					if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2)
				{
					?>
					 <select id="universty_choice_two" name="universty_choice_two"  class="form-control universty_choice_cl" onchange="selectUniversityChoice_third(this.value)" required="true">
					<?php
				}
				else
				{
					?>
					 <select id="universty_choice_two" name="universty_choice_two"  class="form-control universty_choice_cl"  required="true" onchange="selectUgUniversityChoiceTwo(this.value)">
					<?php
					
				}
						?>
						 <!----<select id="universty_choice_two" name="universty_choice_two"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">--->
						 	<option value="">Select</option>							 								 	
						 </select>
						
					</div>
					</div>	
						<?php
					}
					?>
					<?php
						if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name_two">
							 <label for="comment">Course Stream </label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name_two" id="course_option_name_two" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_two'];?>"/>
								</div>
							</div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name_two" style="display:none;">
							 <label for="comment">Course Stream </label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name_two" id="course_option_name_two" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_two'];?>"/>
								</div>
							</div>
							<?php	
							}
						}
						else
						{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_option_name_two" style="display:none;">
						 <label for="comment">Course Stream latest 2</label>
							<div class="form-group col-md-10 pdleft">
							<select id="course_option_name_two" name="course_option_name_two" class="form-control">
							
							<option value="">Select Stream</option>
							
							
							
							</select>
							  <!----<input type="text" name="course_option_name_two" id="course_option_name_two" placeholder="Subject" class="form-control"/>--->
							</div>
						</div>
						<?php	
						}
					?>
					
					
				</div>
				
				
				<?php				
				if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv3">	
					<?php
					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-4 pdleft pdright unidiv3">	
					<?php	
					}
					elseif(count($applicaitonStepOne)<=0)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv3">	
					<?php	
					}
					else
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv3">	
					<?php	
					}
					
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_three" name="course_three" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_three'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
							<?php	
						}
						elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_three" name="course_three" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_three'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}
						elseif($applicaitonStepOne[0]['programme'] == 9)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_three" name="course_three" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}

					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_wish_study" style="display:none;">
						 	<label for="comment">course you wish to study <span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_three" name="course_three" class="form-control">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php	
					}	
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
						 	<label for="comment">course you wish to study 3<span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_three" name="course_three" class="form-control course_three">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php
					}				
					?>		
					
						<?php
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-12 unidiv">
						 <label for="comment">University 3 </label>
					<div class="form-group col-md-10 pdleft">
						
						 <select id="universty_choice_three" name="universty_choice_three"  class="form-control"  required="true">						 	
						 <option value="">Select</option>							 
						 		<?php						 
						 	if(count($applicaitonStepOne)>0)
						 	{						 		
						 		if($applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice_three'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_three'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_three'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}								
								elseif($applicaitonStepOne[0]['programme'] == 7)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_three'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}
							}	
						    ?>							 	
						 </select>
						
						</div>
					</div>	
						<?php
					}	
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6 || $applicaitonStepOne[0]['programme'] == 9)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 3</label>
					<div class="form-group col-md-10 pdleft">						
						<select id="universty_choice_three" name="universty_choice_three"  class="form-control"  required="true">						 
						 	<option value="">Select</option>	
						 	<?php						 
						 	if($applicaitonStepOne[0]['programme']>0)
						 	{
						 		if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						 		{
						 			if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				foreach($ayush as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 2)
						 			{						 				
						 				foreach($icaruni as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 3 || $applicaitonStepOne[0]['course_type'] == 4 || $applicaitonStepOne[0]['course_type'] == 6 || $applicaitonStepOne[0]['course_type'] == 7 || $applicaitonStepOne[0]['course_type'] == 8 || $applicaitonStepOne[0]['course_type'] == 9)
									{
										echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
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
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice_three'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
														}
														else
														{
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}	
													}
													echo '</optgroup>';			
												}	
											}
										    echo '</optgroup>';	
										    echo '<optgroup label="Central Universities">';
										    foreach($centraluniversities as $univercity_cnet)
											{								
												if(!empty($applicaitonStepOne))
											  	{
													if($applicaitonStepOne[0]['universty_choice_three'] == $univercity_cnet['id'])
													{
														echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
													else
													{
														echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
												}
										    }
										     echo '</optgroup>';
									}
									elseif($applicaitonStepOne[0]['course_type'] == 5)
									{
										echo '<optgroup label="State Universities">';
										foreach($stateuniversities as $univercity)
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
													if(!empty($applicaitonStepOne))
												  	{											  		
														if($applicaitonStepOne[0]['universty_choice_three'] == $uni_choice['id'])
														{
															echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
														else
														{														
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
													}
													else
													{
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}	
												}
												echo '</optgroup>';			
											}	
										}
										echo '</optgroup>';
										echo '<optgroup label="National Institute of Technology (NIT)">';
									    foreach($nits as $univercity_nit)
										{								
											if(!empty($applicaitonStepOne))
										  	{
												if($applicaitonStepOne[0]['universty_choice_three'] == $univercity_nit['id'])
												{
													echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
												else
												{
													echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
									    }
										echo '</optgroup>';
									}
									
								}
						 		if($applicaitonStepOne[0]['programme'] == 9)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice_three'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_three'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_three'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}
								elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_three'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
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
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 3 </label>
					<div class="form-group col-md-10 pdleft">
						<?php
							$user_data = $this->session->userdata('user_data');
							$student_type = $user_data['student_type'];	
							$student_course_type = $user_data['apply_course_type'];	
					
						 if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2)
				{
					?>
					 <select id="universty_choice_three" name="universty_choice_three"  class="form-control universty_choice_cl" onchange="selectAyushUniversityChoice(this.value)" required="true">
					<?php
				}
				else
				{
					?>
					 <select id="universty_choice_three" name="universty_choice_three"  class="form-control universty_choice_three"  required="true" onchange="selectUgUniversityChoiceThree(this.value)">
					<?php
					
				}
						?>

					
						<!----<select id="universty_choice_three" name="universty_choice_three"  class="form-control"  required="true">---->						 
						 	<option value="">Select</option>							 								 	
						 </select>
						
						</div>
					</div>	
						<?php
					}
					?>
					
					
					<?php
						if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name_three">
							 <label for="comment">Course Stream </label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name_three" id="course_option_name_three" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_three'];?>"/>
								</div>
							</div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name_three" style="display:none;">
							 <label for="comment">Course Stream </label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name_three" id="course_option_name_three" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_three'];?>"/>
								</div>
							</div>
							<?php	
							}
						}
						else
						{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_three" style="display:none;">
						 <label for="comment">Course Stream 3 latest</label>
							<div class="form-group col-md-10 pdleft">
							<select id="course_option_name_three" name="course_option_name_three" class="form-control">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							  <!----<input type="text" name="course_option_name_three" id="course_option_name_three" placeholder="Subject" class="form-control"/>----->
							</div>
						</div>
						<?php	
						}
					?>
					
						
					
				</div>
				
				
				
			<!---------University 4 START HERE----------->	
							<?php
				if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv4">
					<?php
					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-4 pdleft pdright unidiv4">
					<?php	
					}
					elseif(count($applicaitonStepOne)<=0)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv4">
					<?php	
					}
					
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study 4<span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_fourth" name="course_fourth" class="form-control course_fourth">						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_fourth'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
							<?php	
						}
						elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study 4<span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_fourth" name="course_fourth" class="form-control course_fourth">						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_fourth'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}
						elseif($applicaitonStepOne[0]['programme'] == 9)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study 4<span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_fourth" name="course_fourth" class="form-control course_fourth" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_fourth'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}

					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_wish_study" style="display:none;">
						 	<label for="comment">course you wish to study 4<span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_fourth" name="course_fourth" class="form-control course_fourth">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php	
					}	
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
						 	<label for="comment">course you wish to study 4 <span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_fourth" name="course_fourth" class="form-control course_fourth">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php
					}				
					?>
					
					
					<?php
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-12 unidiv">
						 <label for="comment">University 4</label>
					<div class="form-group col-md-10 pdleft">
						
						<select id="universty_choice_fourth" name="universty_choice_fourth"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">	
						 <option value="">Select</option>							 
						 		<?php						 
						 	if(count($applicaitonStepOne)>0)
						 	{						 		
						 		if($applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice_fourth'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}		
								elseif($applicaitonStepOne[0]['programme'] == 7)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}						
							}	
						    ?>							 	
						 </select>
						
						</div>
					</div>	
						<?php
					}	
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6 || $applicaitonStepOne[0]['programme'] == 9)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 4</label>
					<div class="form-group col-md-10 pdleft">						
						 <select id="universty_choice_fourth" name="universty_choice_fourth"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">
						 	<option value="">Select</option>	
						 	<?php						 
						 	if($applicaitonStepOne[0]['programme']>0)
						 	{
						 		if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						 		{
						 			if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				foreach($ayush as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 2)
						 			{						 				
						 				foreach($icaruni as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 3 || $applicaitonStepOne[0]['course_type'] == 4 || $applicaitonStepOne[0]['course_type'] == 6 || $applicaitonStepOne[0]['course_type'] == 7 || $applicaitonStepOne[0]['course_type'] == 8 || $applicaitonStepOne[0]['course_type'] == 9)
									{
										echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
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
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice_fourth'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
														}
														else
														{
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}	
													}
													echo '</optgroup>';			
												}	
											}
										    echo '</optgroup>';	
										    echo '<optgroup label="Central Universities">';
										    foreach($centraluniversities as $univercity_cnet)
											{								
												if(!empty($applicaitonStepOne))
											  	{
													if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity_cnet['id'])
													{
														echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
													else
													{
														echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
												}
										    }
										     echo '</optgroup>';
									}
									elseif($applicaitonStepOne[0]['course_type'] == 5)
									{
										echo '<optgroup label="State Universities">';
										foreach($stateuniversities as $univercity)
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
													if(!empty($applicaitonStepOne))
												  	{											  		
														if($applicaitonStepOne[0]['universty_choice_fourth'] == $uni_choice['id'])
														{
															echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
														else
														{														
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
													}
													else
													{
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}	
												}
												echo '</optgroup>';			
											}	
										}
										echo '</optgroup>';
										echo '<optgroup label="National Institute of Technology (NIT)">';
									    foreach($nits as $univercity_nit)
										{								
											if(!empty($applicaitonStepOne))
										  	{
												if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity_nit['id'])
												{
													echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
												else
												{
													echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
									    }
										echo '</optgroup>';
									}
									
								}
						 		if($applicaitonStepOne[0]['programme'] == 9)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice_fourth'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}
								elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
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
					<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 4</label>
					<div class="form-group col-md-10 pdleft">		
							<?php
							$user_data = $this->session->userdata('user_data');
							$student_type = $user_data['student_type'];	
							$student_course_type = $user_data['apply_course_type'];	
					if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2)
				{
					?>
					 <select id="universty_choice_fourth" name="universty_choice_fourth"  class="form-control universty_choice_cl" onchange="selectUniversityChoice_third(this.value)" required="true">
					<?php
				}
				else
				{
					?>
					 <select id="universty_choice_fourth" name="universty_choice_fourth"  class="form-control universty_choice_cl"  required="true" onchange="selectUgUniversityChoiceFourth(this.value)">
					<?php
					
				}
						?>
						 <!----<select id="universty_choice_two" name="universty_choice_two"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">--->
						 	<option value="">Select</option>							 								 	
						 </select>
						
					</div>
					</div>	
						<?php
					}
					?>
					<?php
						if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_fourth']);
							if($applicaitonStepOne[0]['course_fourth'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name_fourth">
							 <label for="comment">Course Stream 4</label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name_fourth" id="course_option_name_fourth" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fourth'];?>"/>
								</div>
							</div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name_fourth" style="display:none;">
							 <label for="comment">Course Stream 4</label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name_fourth" id="course_option_name_fourth" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fourth'];?>"/>
								</div>
							</div>
							<?php	
							}
						}
						else
						{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_option_name_fourth" style="display:none;">
						 <label for="comment">Course Stream latest 4</label>
							<div class="form-group col-md-10 pdleft">
							<select id="course_option_name_fourth" name="course_option_name_fourth" class="form-control">
							
							<option value="">Select Stream</option>
							
							
							
							</select>
							  <!----<input type="text" name="course_option_name_two" id="course_option_name_two" placeholder="Subject" class="form-control"/>--->
							</div>
						</div>
						<?php	
						}
					?>
					
					
				</div>
			
			
			
			<!---------University 4 END HERE----------->








			<!---------University 5 START HERE----------->	
								
												<?php
				if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv5">
					<?php
					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-4 pdleft pdright unidiv5">
					<?php	
					}
					elseif(count($applicaitonStepOne)<=0)
					{
					?>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright unidiv5">
					<?php	
					}
					
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8)
					{
						if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study 5<span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_fifth" name="course_fifth" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_fifth'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
							<?php	
						}
						elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study 5<span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_fifth" name="course_fifth" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_fifth'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}
						elseif($applicaitonStepOne[0]['programme'] == 9)
						{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
							 <label for="comment">course you wish to study 5<span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
								  <select id="course_fifth" name="course_fifth" class="form-control" >						 	
								  	<option value="">Select Course</option>		
								  	<?php 
								  		$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type']);
								  		
								  		foreach($courses as $course)
								  		{
											if(!empty($applicaitonStepOne))
										  	{
										  		if($applicaitonStepOne[0]['course_fifth'] == $course['id'])
										  		{
													echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
												}
												else
												{
													echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
											}
										}
								  	?>					 	
								 </select>
								</div>
							</div>
					<?php
						}

					}
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_wish_study" style="display:none;">
						 	<label for="comment">course you wish to study 5<span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_fifth" name="course_fifth" class="form-control">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php	
					}	
					else
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_wish_study">
						 	<label for="comment">course you wish to study 5<span class="text-red">*</span></label>
							<div class="form-group col-md-10 pdleft">
							  <select id="course_fifth" name="course_fifth" class="form-control course_fifth">						 	
							  	<option value="">Select Course</option>								  					 	
							 </select>
							</div>
						</div>
						<?php
					}				
					?>
					
					
					<?php
					if(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 7 || $applicaitonStepOne[0]['programme'] == 8)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-12 unidiv">
						 <label for="comment">University 5</label>
					<div class="form-group col-md-10 pdleft">
						
						<select id="universty_choice_fifth" name="universty_choice_fifth"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">	
						 <option value="">Select</option>							 
						 		<?php						 
						 	if(count($applicaitonStepOne)>0)
						 	{						 		
						 		if($applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice_fifth'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}		
								elseif($applicaitonStepOne[0]['programme'] == 7)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}						
							}	
						    ?>							 	
						 </select>
						
						</div>
					</div>	
						<?php
					}	
					elseif(count($applicaitonStepOne)>0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6 || $applicaitonStepOne[0]['programme'] == 9)
					{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 5</label>
					<div class="form-group col-md-10 pdleft">						
						 <select id="universty_choice_fifth" name="universty_choice_fifth"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">
						 	<option value="">Select</option>	
						 	<?php						 
						 	if($applicaitonStepOne[0]['programme']>0)
						 	{
						 		if($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2)
						 		{
						 			if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				foreach($ayush as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 2)
						 			{						 				
						 				foreach($icaruni as $un)
										{											
											echo '<option selected="selected" value="'.$un['id'].'">'.$un['uni'].'</option>';
										}
									}
									elseif($applicaitonStepOne[0]['course_type'] == 3 || $applicaitonStepOne[0]['course_type'] == 4 || $applicaitonStepOne[0]['course_type'] == 6 || $applicaitonStepOne[0]['course_type'] == 7 || $applicaitonStepOne[0]['course_type'] == 8 || $applicaitonStepOne[0]['course_type'] == 9)
									{
										echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
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
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice_fifth'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
														}
														else
														{
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}	
													}
													echo '</optgroup>';			
												}	
											}
										    echo '</optgroup>';	
										    echo '<optgroup label="Central Universities">';
										    foreach($centraluniversities as $univercity_cnet)
											{								
												if(!empty($applicaitonStepOne))
											  	{
													if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity_cnet['id'])
													{
														echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
													else
													{
														echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
												}
										    }
										     echo '</optgroup>';
									}
									elseif($applicaitonStepOne[0]['course_type'] == 5)
									{
										echo '<optgroup label="State Universities">';
										foreach($stateuniversities as $univercity)
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
													if(!empty($applicaitonStepOne))
												  	{											  		
														if($applicaitonStepOne[0]['universty_choice_fifth'] == $uni_choice['id'])
														{
															echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
														else
														{														
															echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
														}
													}
													else
													{
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}	
												}
												echo '</optgroup>';			
											}	
										}
										echo '</optgroup>';
										echo '<optgroup label="National Institute of Technology (NIT)">';
									    foreach($nits as $univercity_nit)
										{								
											if(!empty($applicaitonStepOne))
										  	{
												if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity_nit['id'])
												{
													echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
												else
												{
													echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
									    }
										echo '</optgroup>';
									}
									
								}
						 		if($applicaitonStepOne[0]['programme'] == 9)
						 		{
						 			echo '<optgroup label="State Universities">';
									foreach($stateuniversities as $univercity)
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
												if(!empty($applicaitonStepOne))
											  	{											  		
													if($applicaitonStepOne[0]['universty_choice_fifth'] == $uni_choice['id'])
													{
														echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
													else
													{														
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
													}
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}	
											}
											echo '</optgroup>';			
										}	
									}
									echo '</optgroup>';
									echo '<optgroup label="Central Universities">';
								    foreach($centraluniversities as $univercity_cnet)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity_cnet['id'])
											{
												echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
									echo '<optgroup label="National Institute of Technology (NIT)">';
								    foreach($nits as $univercity_nit)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity_nit['id'])
											{
												echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
								}
								elseif($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6)
						 		{
						 			echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										if(!empty($applicaitonStepOne))
									  	{
											if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity_yogs['id'])
											{
												echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
											else
											{
												echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
											}
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
								    }
									echo '</optgroup>';
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
					<div class="name-sec col-xs-12 col-sm-3 col-md-4 unidiv">
						 <label for="comment">University 5</label>
					<div class="form-group col-md-10 pdleft">		
							<?php
							$user_data = $this->session->userdata('user_data');
							$student_type = $user_data['student_type'];	
							$student_course_type = $user_data['apply_course_type'];	
					if($student_type == 1 && $student_course_type == 2 || $student_type == NULL && $student_course_type == 2)
				{
					?>
					 <select id="universty_choice_fifth" name="universty_choice_fifth"  class="form-control universty_choice_cl" onchange="selectUniversityChoice_third(this.value)" required="true">
					<?php
				}
				else
				{
					?>
					 <select id="universty_choice_fifth" name="universty_choice_fifth"  class="form-control universty_choice_cl"  required="true" onchange="selectUgUniversityChoiceFifth(this.value)">
					<?php
					
				}
						?>
						 <!----<select id="universty_choice_two" name="universty_choice_two"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">--->
						 	<option value="">Select</option>							 								 	
						 </select>
						
					</div>
					</div>	
						<?php
					}
					?>
					<?php
						if($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4)
						{
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_fifth']);
							if($applicaitonStepOne[0]['course_fifth'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name_fifth">
							 <label for="comment">Course Stream 5th </label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name_fifth" id="course_option_name_fifth" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fifth'];?>"/>
								</div>
							</div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name_two" style="display:none;">
							 <label for="comment">Course Stream 5th</label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name_fifth" id="course_option_name_fifth" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fifth'];?>"/>
								</div>
							</div>
							<?php	
							}
						}
						else
						{
						?>
						<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade course_option_name_fifth" style="display:none;">
						 <label for="comment">Course Stream latest 5</label>
							<div class="form-group col-md-10 pdleft">
							<select id="course_option_name_fifth" name="course_option_name_fifth" class="form-control">
							
							<option value="">Select Stream</option>
							
							
							
							</select>
							  <!----<input type="text" name="course_option_name_two" id="course_option_name_two" placeholder="Subject" class="form-control"/>--->
							</div>
						</div>
						<?php	
						}
					?>
					
					
				</div>
				
			<!---------University 5 END HERE----------->
			
				<?php
				}
				
					
				?>
				 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">
					
					
					<div class="form-group">
						<span class="note1"><strong>Note: </strong>Once admission is confirmed, no change in either course or University/Institute will be permitted by the Council.
						<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allotment of colleges is done by the respective Universities.
						</span>
						
						<?php 
						if(!empty($applicaitonStepOne)) 
						{
							 if($applicaitonStepOne[0]['agreedisagree'] != "")
							 {
							 	if($applicaitonStepOne[0]['agreedisagree']==1)
							 	{
								?>
								I agree <input checked="true" type="radio" required="true"  value="1" name="agreedisagree" id="agreedisagree">
						  I disagree <input type="radio" required="true" id="agreedisagree" value="2" name="agreedisagree"/>
								<?php	
								}
								elseif($applicaitonStepOne[0]['agreedisagree']==2)
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
              	<div class="name-sec col-xs-2 col-sm-2 col-md-4 pull-right">				
				 <input type="submit" id="step-one-application" name="step-one-application" class="form-control sbmt" value="Next >>"/>
				
                
              	</div>
				<div class="name-sec col-xs-2 col-sm-2 col-md-4 pull-right">				
				  <a href="<?php echo site_url();?>applicant/applicant_personal_info?appno=VD0130633969883" class="form-control sbmt">Preview</a>
				
                
              	</div>
              </div>
              <!-- /.box-body -->
            <?php echo form_close(); ?>
	  </div>	   
	</div>
	</div>
	  <!-- Modal -->
   <div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">
 
     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Information</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
 
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
     </div>
    </div>
   </div>
</section>
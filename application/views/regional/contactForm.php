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
	<form method="post" action="<?php echo base_url();?>regional/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<div class="tab-content detailpagepdf" style="border-bottom: 2px solid #cecece;">		
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
						</tbody>
					</table>
						
              </div>
              <div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">   
					
				</div>
				
              <!-- /.box-body -->
           
	  </div>
	</div>
	</div>

	</div>
</section>
	
	


	
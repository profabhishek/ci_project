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
		<h3 class="text-center caps">Application Details For Scholarship through ICCR</h3>
		<h5 class="text-center">FILLED BY APPLICANT</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;">	
	<form method="post" action="<?php echo base_url();?>regional/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
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
								<td colspan="2" style="height:35px;max-width:120px">
								<table style="width:100%;" id="tbl_course" class="table">
									<thead>
										<th>8. Level of Programme</th>
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
													
							
							
						</tbody>
					</table>
						
              </div>
              <div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">   
					
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
	 
              <div class="box-body">
              	<table class="table" id="tbl_relation" style="width:100%;">
              		<thead>
              			<th>9. Status</th>
              			
              		</thead>              		
              	</table>
              	<table class="table" id="tbl_relation" style="width:100%;">
              		<thead>
              			<th>University Name</th>
              			<th>Scheme</th>
              			<th>ICCR Regional Office</th>
              			<th>Date of Forwarding</th>
              			<th>University Letter</th>
              			<th>University Response</th>
              		</thead>
              		<tbody>
              			<?php
              			$ano = $this->uri->segment(3);
              			$data = $this->common_model->getConfirmationofApplicationIds($ano);						
						 $uni = $this->common_model->getUniversityById($data[0]->regional_university);    
              			if(count($data)>0)
              			{
							?>
								<tr>
              				<td>
              					<?php
              					$univ = $this->common_model->getUniversityById($data[0]->regional_university);
              					echo $univ[0]['name'];
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
              					$reg = $this->common_model->getRegionById($data[0]->region_one_status);
              					echo $reg[0]['name'];
              					?>
              				</td>
              				<td>
              					<?php              				
              					echo date('d M Y h:i:s A',$data[0]->region_one_status_date);
              					?>
              				</td>
              				<td>
              					<a target="_blank" href="<?php echo site_url();?>assets/site/main/university_approval/<?php echo  $data[0]->region_one_doc;?>" target="_blank">Download</a>
              				</td>
              				<td>
              				<?php if($data[0]->university_is_accept == 1)
              					  {
									echo "Confirmed";
								  }
								  elseif($data[0]->university_is_accept == 2)
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
<br/><br/>
                <table class="table" id="tbl_relation" style="width:100%;">
              		<thead>
              			<th>Departure Date</th>
              			<th>Arrival Date by Mission</th>
              			<th>Travel Plan Document</th>  
              			<th>Flight No.</th>            			
              			<th>Status</th>
              			<th>Arrival Date</th>
              		</thead>
              		<tbody>
              			<?php
              				if(count($travelplan)>0)
              				{
								foreach($travelplan as $plan)
								{
								?>
									<tr>
										<td><?php echo $plan['departure_date'];?></td>
										<td><?php echo $plan['travel_arrival_date'];?></td>
										<td><?php if($plan['status'] == 14) 
										{
										?>
										<a class='link_div' download href="<?php echo site_url();?>assets/site/main/travelplan/<?php echo $plan['travel_plan_doc'];?>">Download</a>
										<?php	
										}
										elseif($plan['status'] == -14) 
										{
											?>
										<a class='link_div' download href="<?php echo site_url();?>assets/site/main/travelplan/<?php echo $plan['travel_plan_doc'];?>">Download</a>
										<?php
										}	?></td>									
										<td><?php echo $plan['flight_no'];?></td>
										<td><?php if($plan['status'] == 14) echo "Arrived"; elseif($plan['status'] == -14) echo "Not Arrived" ;?></td>
										<td><?php if($plan['status'] == 14) 
										{
											echo $plan['arrival_date_ro'];
										}
										elseif($plan['status'] == -14) 
										{
											echo "NA";
										}	?></td>
										<td></td>
									</tr>
								<?php
								}
							}
              			?>
              		</tbody>
              	</table>
				<br/>	
				<br/>
				<hr>	
						
      			
              </div>
          
              <!-- /.box-body -->
		
	  </div>	
<hr>
	</div>
	
	</div>
</section>
	
	


	
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
// print_r($applicaitonStepOne);die;
?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
var centralUniversities = JSON.parse('<?php echo $centraluniversities_one;?>');
var nits = JSON.parse('<?php echo $nits_one;?>');
var yogas = JSON.parse('<?php echo $yogas_one;?>');
var statesarray = JSON.parse('<?php echo $states_array;?>');
</script>
<section class="meacontent" id="printableArea">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;">	
	<form method="post" action="<?php echo base_url();?>mission/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;">
		<input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" onclick="printDiv('printableArea')" value=""/>	
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<div class="tab-content detailpagepdf">		
	  <div id="home" class="tab-pane fade in active">	
	    	 
              <div class="box-body">
              	<div class="col-xs-3 prfl pull-right" >
              		<?php              			 
              			
              			$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']);
						// file_exists() matches directories as well as files, so when $userImage
						// is genuinely blank (no photo uploaded) the path collapses to just
						// $userd->dir - a real directory - and file_exists() passed, then
						// file_get_contents() failed with "Is a directory". is_file() plus a
						// non-empty filename check correctly treats a missing photo as "no image".
						if (!empty($userd->dir) && !empty($userImage) && is_file($userd->dir .'/'.$userImage)) {
							$imgs = file_get_contents($userd->dir .'/'.$userImage);
							//echo $imgs;
							$data = base64_encode($imgs);
							$f = finfo_open();
							$imgdata = base64_decode($data);
                            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
						}
          				if($userd->dir == "")
						{
							?>
							<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
							<?php		
						}						
						else
						{
							if(!empty($userImage) && is_file($userd->dir.'/'. $userImage))
							{
								?>
							<img style="width:151px;height:171px;" id="profil_image_div"  src="data:<?php if(!empty($mime_type)){echo $mime_type;}?>;base64,<?php if(!empty($data)){echo $data;}?>"/>
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
								<td style="height:35px;">:&nbsp;&nbsp;<?php $title = '';
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
					   <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['fullname'].' '.$applicaitonStepOne[0]['middlename'].' '.$applicaitonStepOne[0]['familyname'];?></td>
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
										<label> Age</label>
									</td>
									<td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['age']; ?> 

									</td>
								</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"> <label>4. Place of Birth</label> </td>
									<?php $countryName= $this->db->get_where('iccr_countries',array('id'=>$applicaitonStepOne[0]['birth_country']))->row(); ?>
									<td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['city'] .', '. $countryName->country_name;
														?>
								</td>
							</tr>
							<tr>
									<td style="height:35px;font-weight: bold;"> <label>5. Current Location</label> </td>
									<td>:&nbsp;&nbsp;<?php
														$nationalities = $this->common_model->getCountries();
														foreach ($nationalities as $na) {
															if (!empty($applicaitonStepOne)) {
																if ($applicaitonStepOne[0]['nationality'] == $na['id']) {
																	echo $na['country_name'];
																}
															}
														}
														?>
									</td>
							</tr>
							<!-- <tr>
								<td style="height:35px;font-weight: bold;">
										<label>6. Country of Residence</label></td>
								<td>:&nbsp;&nbsp;<?php
									// $countries = $this->common_model->getCountries();
									// foreach($countries as $country)
									// {
									// 	if(!empty($applicaitonStepOne))
									// 	{
									// 		if($applicaitonStepOne[0]['country'] == $country['id'])
									// 		{
									// 			echo $country['country_name'];
									// 		}
									// 	}
									// }
									?>
								</td>
																	
								
							</tr> -->
							<tr>
									<td style="height:35px;font-weight: bold;"><label for="comment">6. Passport No</label></td>
									<td style="height:35px;">:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) if ($applicaitonStepOne[0]['passport_no'] != "") echo $applicaitonStepOne[0]['passport_no'];
								else echo "NA"; ?>	
								<?php if (!empty($userd) && !empty($userd->passport_file)): ?>
                      <img 
						src="<?= base_url($userd->passport_file); ?>" 
						alt="Passport Photo"
						style="max-width:200px; max-height:100px; border:1px solid #ddd; padding:4px; cursor:pointer;"
						onclick="openImage(this.src)"
					>
                  <?php else: ?>
                      <p>No passport image uploaded.</p>
                  <?php endif; ?></td>
								</tr>
													<div id="imageModal" class="image-modal">
						<span class="close" onclick="closeImage()">&times;</span>
						<img class="modal-content" id="popupImage">
					</div>
				  <style>
				.image-modal {
					display: none;
					position: fixed;
					z-index: 9999;
					padding-top: 60px;
					left: 0;
					top: 0;
					width: 100%;
					height: 100%;
					background-color: rgba(0,0,0,0.9);
				}

				.image-modal img {
					margin: auto;
					display: block;
					max-width: 90%;
					max-height: 80%;
				}

				.close {
					position: absolute;
					top: 20px;
					right: 40px;
					color: #fff;
					font-size: 40px;
					font-weight: bold;
					cursor: pointer;
				}
				</style>
<script>
function openImage(src) {
    document.getElementById("imageModal").style.display = "block";
    document.getElementById("popupImage").src = src;
}

function closeImage() {
    document.getElementById("imageModal").style.display = "none";
}
</script>


							<tr>
								<td style="height:35px;font-weight: bold;">
									<label>7. Issue of Passport (City, Country)</label>
								</td>
									<?php $Passport_Issue_Country= $this->db->get_where('iccr_countries',array('id'=>$applicaitonStepOne[0]['passport_issue_country']))->row(); ?>
								<td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place'] .', '. $Passport_Issue_Country->country_name; ?>
								</td>
							</tr>

							<!-- <tr>
								<td style="height:35px;" colspan="2">
								<table id="tblpassport" class="table" style="width: 100%;">
									<thead>
										<th style="width:150px; ">a) Date of Issue</th>
										<th style="width:150px; ">b) Date of Expiry</th>
										<th style="width:150px; ">c) Place of Issue</th>
									</thead>
									<tbody>
										<tr>
											<td><?php //if(!empty($applicaitonStepOne)) echo date('d/m/Y',strtotime($applicaitonStepOne[0]['passport_issue_date'])); ?></td>
											<td><?php //if(!empty($applicaitonStepOne)) echo date('d/m/Y',strtotime($applicaitonStepOne[0]['passport_expiry_date'])); ?></td>
											<td><?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place'];?></td>
										</tr>
									</tbody>
								</table>
							
								</td>							
							</tr> -->

								<tr>
									<td style="height:35px;font-weight: bold;">
										<label>8. Passport Issue Date</label>
									</td>
									<td>:&nbsp;
										<?php if (!empty($applicaitonStepOne)) {
											
										$dateFormat = explode('-',$applicaitonStepOne[0]['passport_issue_date']);
										
										echo $dateFormat[0].'/'.$dateFormat[1].'/'.$dateFormat[2];
										
										} ?>
									</td>
								</tr>

								<tr>
									<td style="height:35px;font-weight: bold;">
										<label>9. Passport Expiry Date</label>
									</td>
									<td>:&nbsp;
										<?php if (!empty($applicaitonStepOne)) { 
										
										$dateFormat = explode('-',$applicaitonStepOne[0]['passport_expiry_date']);
										
										echo $dateFormat[0].'/'.$dateFormat[1].'/'.$dateFormat[2];

										} ?>
									</td>
								</tr>


							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>10. Postal Address</label>
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
								<td style="min-height:35px;font-weight: bold;"> <label><b>11. Mobile Number</b></label> </td>
								<td style="height:35px;">:&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['tel_country_code']; ?>&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['phone_number']; ?></td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><b>12. WhatsApp Number</b></td>
								<td style="height:35px;">:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['tel_country_code']; ?>&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['whatsapp_number']; ?></td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><b>13. Email Id</b> </td>
								<td style="height:35px;">:&nbsp;&nbsp;<?php if(!empty($registerData)) echo $registerData[0]['email_id'];?></td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"> <label>14. Unique Identifcation No.</label> </td>
								<td style="height:35px;">
									:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['unique_id']; ?>
								</td>
							</tr>
							<tr>
									<td style="font-weight: bold;"><label>15. Details of Father/Mother/Guardian</label></td>
								</tr>
								<tr>

									<td colspan="2" style="height:35px;">
										<table id="tbl_father" class="table" style="width:100%;">
											<thead>
												<th>Name</th>
												<th>Relation</th>
												<th>Phone Number</th>
												<th>Email ID</th>
											</thead>
											<tbody>
											<?php if (!empty( $registerData[0]['father_fname'])) { ?>
												<tr>
													<td><?php if (!empty($registerData)) { echo $registerData[0]['father_fname'].' '.$registerData[0]['father_mname'].' '.$registerData[0]['father_lname']; } ?> </td>
													<td>Father</td>
													<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['father_number']; ?></td>
													<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['father_email']; ?></td>
												</tr>
											<?php } if (!empty( $registerData[0]['mother_fname'])) { ?>
												<tr>
													<td><?php if (!empty($registerData)) { echo $registerData[0]['mother_fname'].' '.$registerData[0]['mother_mname'].' '.$registerData[0]['mother_lname']; } ?> </td>
													<td>Mother</td>
													<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['mother_number']; ?></td>
													<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['mother_email']; ?></td>
												</tr>
												<?php } if (!empty( $registerData[0]['gurdian_fname'])) { ?>
												<tr>
													<td><?php if (!empty($registerData)) { echo $registerData[0]['gurdian_fname'].' '.$registerData[0]['gurdian_mname'].' '.$registerData[0]['gurdian_lname']; } ?> </td>
													<td>Guardian</td>
													<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gurdian_number'] ?? ''; ?></td>
													<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gurdian_email'] ?? ''; ?></td>
												</tr>
												<?php }  ?>
											</tbody>
										</table>
									</td>
								</tr>				
							<tr>
								<td style="height:35px;font-weight: bold;"><label for="comment">Address</label></td>
								<td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_address']; ?></td>
							</tr>
							<tr>
									<td colspan="2">
										<table id="tbl_gaurdian" class="table" style="width: 100%;">
											<thead>
												<th>City</th>
												<th>State</th>
												<th>Country</th>
												<th>Zincode</th>
											</thead>
											<tbody>
												<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_city']; ?></td>
												<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_state']; ?></td>
												<td><?php
													$countries = $this->common_model->getCountries();
													foreach ($countries as $country) {
														if (!empty($applicaitonStepOne)) {
															if ($applicaitonStepOne[0]['gardiuan_address_country'] == $country['id']) {
																echo $country['country_name'];
															}
														}
													}
													?></td>
												<td><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_pincode']; ?></td>
											</tbody>
										</table>
									</td>
							</tr>
							
							<!-- <tr>
								<td style="font-weight: bold;"><b>10. Knowledge of English</b></td>
								<td style="height:35px;max-width:120px">:
							 <?php $knowledge = '';
								//   if(count($applicaitonStepOne) > 0)
								//   {
								//   	$knowledge = $applicaitonStepOne[0]['knowledge_english'];
								//   }						  
								//   if($knowledge == 1)
								//   {
								//   	echo "Yes";
								//   }
								//   elseif($knowledge == 2)
								//   {
								// 	 echo "No";	
								//   }
							  ?>							
								</td>
							</tr> -->
							<!-- <tr>
								<td style="height:35px;max-width:120px;font-weight: bold;"><b>Written:</b>
								<?php
							 	// if($knowledge == 1)
								// {					
								// 	if($applicaitonStepOne[0]['knowledge_english_written'] == 1)
								// 	{
								// 	  echo "Average";						 	
								// 	}
								// 	elseif($applicaitonStepOne[0]['knowledge_english_written'] == 2)
								// 	{
								// 		echo "Proficient";						   
								// 	}
								// 	elseif($applicaitonStepOne[0]['knowledge_english_written'] == 3)
								// 	{
								// 		echo "Good";
								// 	}
								// }
									?>		
								</td>
								<td style="height:35px;max-width:120px;font-weight: bold;">
								<b>Spoken:</b>
							 <?php
							 	// if($knowledge == 1)
								// {					
								// 	if($applicaitonStepOne[0]['knowledge_english_spoken'] == 1)
								// 	{
								// 	  echo "Average";						 	
								// 	}
								// 	elseif($applicaitonStepOne[0]['knowledge_english_spoken'] == 2)
								// 	{
								// 		echo "Proficient";						   
								// 	}
								// 	elseif($applicaitonStepOne[0]['knowledge_english_spoken'] == 3)
								// 	{
								// 		echo "Good";
								// 	}
								// }	
									?>							
								</td>
							</tr>
								<?php 
						// 		if($applicaitonStepOne[0]['is_gmat'] == 1)
						// {
	 ?> 
	  -->
	 
	  							<tr>
									<td style="font-weight: bold;"><b>16. English Proficiency - I</b></td>
									<td style="height:35px;max-width:120px">:
										<?php $proficiency = '';
										if (count($applicaitonStepOne) > 0) {
											$proficiency = $applicaitonStepOne[0]['is_english_as_subject'];
										}
										if ($proficiency == 1) {
											echo "Yes";
										} elseif ($proficiency == 2) {
											echo "No";
										}
										?>
									</td>
								</tr>
								<?php
								if ($proficiency == 1) {
								?>
									<tr>
										<td style="height:35px;max-width:120px;font-weight: bold;"><b>Till What Level:</b>
											<?php
												if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['english_level'];
											?>
										</td>
										<!--<td style="height:35px;max-width:120px;font-weight: bold;"><b>Score/Percentage (%):</b>
											<?php
												if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['english_score'];
											?>
										</td>-->
									</tr>
								<?php
								}
								else {
								?>
									<tr>
										<td style="height:35px;max-width:120px;font-weight: bold;"><b>Till What Level:</b>
											<?php
												echo "NA";
											?>
										</td>
										<!--<td style="height:35px;max-width:120px;font-weight: bold;"><b>Score/Percentage (%):</b>
											<?php
												echo "NA";
											?>
										</td>-->
									</tr>
								<?php
								}
								?>


								<tr>
									<td style="font-weight: bold;"><b>17. English Proficiency - II</b></td>
									<td style="height:35px;max-width:120px">:
										<?php $tofel = '';
										if (count($applicaitonStepOne) > 0) {
											$tofel = $applicaitonStepOne[0]['is_toefl'];
										}
										if ($tofel == 1) {
											echo "Yes";
										} elseif ($tofel == 2) {
											echo "No";
										}
										?>
										<?php $ielts = '';
										if (count($applicaitonStepOne) > 0) {
											$ielts = $applicaitonStepOne[0]['is_ielts'];
										}
										if ($ielts == 1) {
											echo "Yes";
										} elseif ($ielts == 2) {
											echo "No";
										}
										?>
										<?php $duolingo = '';
										if (count($applicaitonStepOne) > 0) {
											$duolingo = $applicaitonStepOne[0]['is_duolingo'];
										}
										if ($duolingo == 1) {
											echo "Yes";
										} elseif ($duolingo == 2) {
											echo "No";
										}
										?>
									</td>
								</tr>
								<?php
								if ($tofel == 1) {
								?>
									<tr>
										<td style="height:35px;max-width:120px;font-weight: bold;"><b>TOEFL Score:</b>
											<?php
												if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['toefl_score'];
											?>
										</td>
									</tr>
								<?php
								}
								else {
								?>
									<tr>
										<td style="height:35px;max-width:120px;font-weight: bold;"><b>TOEFL Score:</b>
											<?php
												echo "NA";
											?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if ($ielts == 1) {
								?>
									<tr>
										<td style="height:35px;max-width:120px;font-weight: bold;"><b>IELTS Score:</b>
											<?php
												if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['ielts_score'];
											?>
										</td>
									</tr>
								<?php
								}
								else {
								?>
									<tr>
										<td style="height:35px;max-width:120px;font-weight: bold;"><b>IELTS Score:</b>
											<?php
												echo "NA";
											?>
										</td>
									</tr>
								<?php
								}
								?>
								<?php
								if ($duolingo == 1) {
								?>
									<!--<tr>
										<td style="height:35px;max-width:120px;font-weight: bold;"><b>Duolingo Score:</b>
											<?php
												if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['duolingo_score'];
											?>
										</td>
									</tr>-->
								<?php
								}
								else {
								?>
									<!--<tr>
										<td style="height:35px;max-width:120px;font-weight: bold;"><b>Duolingo Score:</b>
											<?php
												echo "NA";
											?>
										</td>
									</tr>-->
								<?php
								}
								?>






										<?php if (!empty($applicaitonStepOne)) {
											if (!empty($applicaitonStepOne[0]['gmat_score'])) {

										?>
												<tr>
													<td style="font-weight:bold;"><label id="lbl" style="">GMAT Score</label></td>
													<td colspan="2">:&nbsp;&nbsp;


														<?php
														if (!empty($applicaitonStepOne[0]['gmat_score'])) {
															echo $applicaitonStepOne[0]['gmat_score'];
														} else {
															echo "NA";
														}



														?>
													</td>
												</tr>
										<?php
											}
										}

										?>
						
						<tr>
									<td style="height:35px;max-width:120px;font-weight: bold;" colspan="2"><label>18. Essay:</label></td>
								</tr>
								<tr>
									<td colspan="2"><span class="note1"><strong></strong><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['english_test_essay']; ?></span></td>
								</tr>
								<tr>
									<td style="height:35px;max-width:120px;font-weight: bold;"><b>19. Academic Year</b></td>
									<td style="height:35px;">:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['acedemic_year']; ?> </td>									 
								</tr>

								<tr>
									<td style="height:35px;max-width:120px;font-weight: bold;"><b>20. Level of Course:</b></td>
									<td>:&nbsp;&nbsp;
														<?php
														$programme = $this->common_model->getAllProgramme();
														foreach ($programme as $program) {
															if (!empty($applicaitonStepOne)) {
																if ($applicaitonStepOne[0]['programme'] == $program['id']) {
																	echo $program['name'];
																}
															}
														}
														?></td>
								</tr>

								<!-- <tr>
									<td colspan="2" style="height:35px;max-width:120px">
										<table style="width:100%;" id="tbl_course">
											<thead>
												<th>20. Level of Course:</th>
												 <?php
												//if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 9) {

												?>
													<th>Level of Course:</th>
												<?php
												//} elseif (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8) {
												?>
													<th>Level of Course:</th>
												<?php
												//}
												?> 

											</thead>
											<tbody>
												<tr>
													<td>
														<?php
														$programme = $this->common_model->getAllProgramme();
														foreach ($programme as $program) {
															if (!empty($applicaitonStepOne)) {
																if ($applicaitonStepOne[0]['programme'] == $program['id']) {
																	echo $program['name'];
																}
															}
														}
														?></td>
													 <td>
														<?php
														if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 9 || $applicaitonStepOne[0]['programme'] == 8) {

															$user_data = $this->session->userdata('user_data');

															$student_type = $user_data['student_type'];
															$student_course_type = $user_data['apply_course_type'];
															$prgid = $user_data['apply_course_type'];
															if ($student_course_type == 10) {
																$courseType = $this->common_model->getAllCourseTypeAyush();
															} else {
																$courseType = $this->common_model->getAllCourseType();
															}
															foreach ($courseType as $ctype) {
																if (!empty($applicaitonStepOne)) {
																	if ($applicaitonStepOne[0]['course_type'] == $ctype['id']) {
																		echo $ctype['course_type'];
																	}
																}
															}

															if ($applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4) {
																echo $applicaitonStepOne[0]['course_subject'];
															}
														} elseif (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 8) {
															echo $applicaitonStepOne[0]['course_subject'];
														}
														?>

													</td> 
												</tr>
											</tbody>
										</table>
									</td>
								</tr> -->

								<tr>
									<td style="height:35px;font-weight: bold;">
										<label>21. Course Main Stream</label>
									</td>
									<?php $Course_main_stream= $this->db->get_where('iccr_course_type',array('id'=>$applicaitonStepOne[0]['course_type']))->row(); ?>
									<td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $Course_main_stream->course_type;
														?>
									</td>
								</tr>

															<tr>

									<?php
									$user_data = $this->session->userdata('user_data');

									$student_type = $user_data['student_type'];
									$student_course_type = $user_data['apply_course_type'];
									$prgid = $user_data['apply_course_type'];
									if ($student_course_type == 11) {
									?>
										<td style="height:35px;max-width:120px;font-weight: bold;" colspan="2"><label>22. Univesities/Institutes</label></td>
									<?php
									} else {
									?>
										<td style="height:35px;max-width:120px;font-weight: bold;" colspan="2"><label>22. Univesities/Institutes in India where you wish to seek admission:</label></td>
									<?php
									}
									?>


									<?php $user_data = $this->session->userdata('user_data');

									$student_type = $user_data['student_type'];
									$student_course_type = $user_data['apply_course_type'];
									$prgid = $user_data['apply_course_type']; ?>

									<?php
									if ($student_course_type == 11) {
									?>

								<tr>
									<td colspan="3">
										<table id="tbl_uni" style="width: 100%;">
											<thead>
												<th>University</th>
												<th>Course</th>
												<th>Subject/Stream</th>
												<th>Year</th>
												<th>City</th>
											</thead>
											<tbody>
												<tr>
													<td>

														<?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);
														echo $university_second[0]['name']; ?>
													</td>
													<td>
														<?php
														if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2) {

															$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

															foreach ($courses as $course) {
																if (!empty($applicaitonStepOne)) {
																	if ($applicaitonStepOne[0]['course'] == $course['id']) {
																		echo $course['title'];
																	}
																}
															}
														} elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
															$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
															foreach ($courses as $course) {
																if (!empty($applicaitonStepOne)) {
																	if ($applicaitonStepOne[0]['course'] == $course['id']) {
																		echo $course['title'];
																	}
																}
															}
														} elseif ($applicaitonStepOne[0]['programme'] == 9) {

															$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

															foreach ($courses as $course) {
																if (!empty($applicaitonStepOne)) {
																	if ($applicaitonStepOne[0]['course'] == $course['id']) {
																		echo $course['title'];
																	}
																}
															}
														}
														?>



													</td>
													<td><?php

														if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4) {
															$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
															if ($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0) {
																if (!empty($applicaitonStepOne))
																	$strm = $this->common_model->getStreamsById($applicaitonStepOne[0]['course_option_name']);
																//echo $strm[0]['name'];
																echo $applicaitonStepOne[0]['course_option_name'];
															} else {
																echo "NA";
															}
														} else {
															echo "NA";
														}
														?></td>

													<td><?php if ($applicaitonStepOne[0]['course_year'] == 1) {
															echo "I Year";
														} elseif ($applicaitonStepOne[0]['course_year'] == 2) {
															echo "II Year";
														} elseif ($applicaitonStepOne[0]['course_year'] == 3) {
															echo "III Year";
														}
														?></td>
													<td><?php $regionName = $this->common_model->getRegionById($applicaitonStepOne[0]['region']);

														echo $regionName[0]['name']; ?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							<?php
									} else {
							?>
								</tr>
								<tr>
									<td colspan="3">
										<?php
										if (count($applicaitonStepOne) > 0) {
										?>
											<table id="tbl_uni" style="width: 100%;">
												<thead>
													<th>Nomenclture</th>
													<th>University</th>
													<?php
													$user_data = $this->session->userdata('user_data');
													$student_type = $user_data['student_type'];

													$student_course_type = $user_data['apply_course_type'];
													?>
													
														
												</thead>
												<tbody>
													<tr>
														<td>
															<?php /*
															if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 4 
															|| $applicaitonStepOne[0]['programme'] == 8 || $applicaitonStepOne[0]['programme'] == 10 || $applicaitonStepOne[0]['programme'] == 11
															|| $applicaitonStepOne[0]['programme'] == 12 || $applicaitonStepOne[0]['programme'] == 13) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
																$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 9) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															}
															*/ 
															
															$nomen = $this->common_model->getnomenclatureByid($applicaitonStepOne[0]['nomenclature']);

															echo $nomen[0]['title'];
															
															
															?>



														</td>
														<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);
															echo $university_second[0]['name']; ?>
														</td>
														<td>
															<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name']; ?>
														</td>

														<!-- <td><?php
															if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 12 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4) {
																$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
																if ($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0) {
																	if (!empty($applicaitonStepOne))
																		$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course']);
																	//echo $strm[0]['name'];
																	echo $applicaitonStepOne[0]['course_option_name'];
																} else {
																	echo "";
																}
															} else {
																echo "";
															}
															?>
														</td> -->
													</tr>
													<tr>
														<td><?php /*
															if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 4 
															|| $applicaitonStepOne[0]['programme'] == 8 || $applicaitonStepOne[0]['programme'] == 10 || $applicaitonStepOne[0]['programme'] == 11
															|| $applicaitonStepOne[0]['programme'] == 12 || $applicaitonStepOne[0]['programme'] == 13) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_two'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
																$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_two'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 9) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_two'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} */
															$nomen = $this->common_model->getnomenclatureByid($applicaitonStepOne[0]['nomenclature_two']);

															echo isset($nomen[0]['title']) ? $nomen[0]['title'] : '';
															
															
															?></td>
														<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);
															echo isset($university_second[0]['name']) ? $university_second[0]['name'] : ''; ?></td>

														<td>
															<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_two']; ?>
														</td>
														<!-- <td><?php
															if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4) {
																$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_two']);
																if ($applicaitonStepOne[0]['course_two'] > 0 && $crs[0]['has_stream'] > 0) {
																	if (!empty($applicaitonStepOne))
																		//$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course_option_name_two']);
																		//echo $strm[0]['name'];
																		echo $applicaitonStepOne[0]['course_option_name_two'];
																} else {
																	echo "";
																}
															} else {
																echo "";
															}
															?></td> -->
													</tr>
													<tr>
														<td><?php /*
															if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 4 
															|| $applicaitonStepOne[0]['programme'] == 8 || $applicaitonStepOne[0]['programme'] == 10 || $applicaitonStepOne[0]['programme'] == 11
															|| $applicaitonStepOne[0]['programme'] == 12 || $applicaitonStepOne[0]['programme'] == 13) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_three'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
																$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_three'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 9) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_three'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} */
															$nomen = $this->common_model->getnomenclatureByid($applicaitonStepOne[0]['nomenclature_three']);

															echo isset($nomen[0]['title']) ? $nomen[0]['title'] : '';
															?></td>
														<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']);
															echo isset($university_second[0]['name']) ? $university_second[0]['name'] : ''; ?></td>

														<td>
															<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_three']; ?>
														</td>
														<!-- <td><?php
															if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4) {
																$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_three']);
																if ($applicaitonStepOne[0]['course_three'] > 0 && $crs[0]['has_stream'] > 0) {
																	if (!empty($applicaitonStepOne))
																		//$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course_option_name_three']);
																		//echo $strm[0]['name'];
																		echo $applicaitonStepOne[0]['course_option_name_three'];
																} else {
																	echo "";
																}
															} else {
																echo "";
															}
															?></td> -->

													</tr>

													<!----------University 4 Start Here----------->
													<tr>
														<td><?php /*
															if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 4 
															|| $applicaitonStepOne[0]['programme'] == 8 || $applicaitonStepOne[0]['programme'] == 10 || $applicaitonStepOne[0]['programme'] == 11
															|| $applicaitonStepOne[0]['programme'] == 12 || $applicaitonStepOne[0]['programme'] == 13) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_fourth'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
																$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_fourth'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 9) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_fourth'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} */
															$nomen = $this->common_model->getnomenclatureByid($applicaitonStepOne[0]['nomenclature_fourth']);

															echo !empty($nomen) ? $nomen[0]['title'] : 'NA';
															?></td>
														<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fourth']);
															echo !empty($university_second) ? $university_second[0]['name'] : 'NA'; ?></td>
														<td>
															<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fourth']; ?>
														</td>
														<!-- <td><?php
															if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4) {
																$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_fourth']);
																if ($applicaitonStepOne[0]['course_fourth'] > 0 && $crs[0]['has_stream'] > 0) {
																	if (!empty($applicaitonStepOne))
																		//$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course_option_name_fourth']);
																		//echo $strm[0]['name'];
																		echo $applicaitonStepOne[0]['course_option_name_fourth'];
																} else {
																	echo "";
																}
															} else {
																echo "";
															}
															?></td> -->

													</tr>
													<!------- University 4 End Here -------->



													<!------- University 5 Start Here -------->
													<tr>
														<td><?php /*
															if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 4 
															|| $applicaitonStepOne[0]['programme'] == 8 || $applicaitonStepOne[0]['programme'] == 10 || $applicaitonStepOne[0]['programme'] == 11
															|| $applicaitonStepOne[0]['programme'] == 12 || $applicaitonStepOne[0]['programme'] == 13) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_fifth'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
																$courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_fifth'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} elseif ($applicaitonStepOne[0]['programme'] == 9) {

																$courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

																foreach ($courses as $course) {
																	if (!empty($applicaitonStepOne)) {
																		if ($applicaitonStepOne[0]['course_fifth'] == $course['id']) {
																			echo $course['title'];
																		}
																	}
																}
															} */
															$nomen = $this->common_model->getnomenclatureByid($applicaitonStepOne[0]['nomenclature_fifth']);

															echo !empty($nomen) ? $nomen[0]['title'] : 'NA';
															?></td>
														<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fifth']);
															echo !empty($university_second) ? $university_second[0]['name'] : 'NA'; ?></td>

														<td>
															<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fifth']; ?>
														</td>	
														<!-- <td><?php
															if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 ||  $applicaitonStepOne[0]['programme'] == 2 ||  $applicaitonStepOne[0]['programme'] == 4) {
																$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course_fifth']);
																if ($applicaitonStepOne[0]['course_fifth'] > 0 && $crs[0]['has_stream'] > 0) {
																	if (!empty($applicaitonStepOne))
																		//$strm = $this->common_model->getStreamById($applicaitonStepOne[0]['course_option_name_fifth']);
																		//echo $strm[0]['name'];
																		echo $applicaitonStepOne[0]['course_option_name_fifth'];
																} else {
																	echo "";
																}
															} else {
																echo "";
															}
															?></td> -->

													</tr>

													<!----------University 5 End Here------>
												</tbody>
											</table>
										<?php
										} else {
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
														<td><?php $university_first = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);
															echo $university_first[0]['name']; ?></td>
														<td><?php $university_second =  $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);
															echo $university_second[0]['name']; ?></td>
														<td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']);
															echo $university_three[0]['name']; ?></td>
														<td><?php $university_fourth = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fourth']);
															echo $university_fourth[0]['name']; ?></td>
														<td><?php $university_fifth = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fifth']);
															echo $university_fifth[0]['name']; ?></td>
													</tr>
												</tbody>
											</table>
										<?php
										}
										?>
											<?php
											// ---------------------------------------------------
											// Confirmed university, its approval letter, scheme and
											// nomenclature.
											//
											// The five choices above are what the applicant ASKED
											// for. This block shows which university actually
											// confirmed the admission, and lets the Mission open the
											// letter that university uploaded without having to go
											// to another screen to find it.
											//
											// The letter sits in one of two places depending on
											// which module uploaded it:
											// ./<year>/university_approval/ (outside the web root,
											// so it must be served through mission/downloadDocs) or
											// assets/site/main/university_approval/ (public). Check
											// both, and only offer a link when the file is really on
											// disk - linking to a missing file makes Apache fall
											// through to the 404 handler, which renders an
											// "Error 500" page for what is only a missing upload.
											// ---------------------------------------------------
											// Rows come from iccr_university_response_by_hqrs, which
											// holds the allotment made for this application. Every
											// row here is a real allotment, so they are all shown
											// rather than filtered on university_is_accept - that
											// filter previously hid rows whose acceptance flag had
											// not been set yet, and the screen wrongly reported that
											// no university had confirmed.
											$confirmedRows = array();
											if (!empty($universityResponses) && is_array($universityResponses)) {
												foreach ($universityResponses as $uniResp) {
													if (!empty($uniResp['regional_university']) || !empty($uniResp['region_one_doc']) || !empty($uniResp['course'])) {
														$confirmedRows[] = $uniResp;
													}
												}
											}

											$schemeText = '';
											$nomenclatureText = '';

											// NOMENCLATURE.
											// This is held on the application itself, in
											// iccr_student_application_details.nomenclature - the
											// same value the "Nomenclture" column of the table above
											// prints (see the getnomenclatureByid() call further up
											// this file). It is NOT iccr_status_mapping.nomenclature,
											// which is only written later, when the Mission
											// processes the application; reading that column showed
											// "NA" here even though the nomenclature was printed a
											// few lines above on the same page.
											// Fall back to the status-mapping copy so applications
											// that only have the later value still display it.
											$nomRaw = '';
											if (!empty($applicaitonStepOne) && !empty($applicaitonStepOne[0]['nomenclature'])) {
												$nomRaw = trim((string) $applicaitonStepOne[0]['nomenclature']);
											} elseif (!empty($schemeNomenclature) && is_array($schemeNomenclature) && count($schemeNomenclature) > 0 && !empty($schemeNomenclature[0]['nomenclature'])) {
												$nomRaw = trim((string) $schemeNomenclature[0]['nomenclature']);
											}
											if ($nomRaw !== '') {
												// Depending on which screen saved it, this value is
												// either the nomenclature id or the title itself.
												// Resolve an id, otherwise show the stored text.
												if (ctype_digit($nomRaw)) {
													$nomRow = $this->common_model->getnomenclatureByid($nomRaw);
													$nomenclatureText = (is_array($nomRow) && count($nomRow) > 0 && isset($nomRow[0]['title'])) ? $nomRow[0]['title'] : '';
												} else {
													$nomenclatureText = $nomRaw;
												}
											}

											// SCHEME.
											// iccr_status_mapping.scholarship_id is only populated
											// when the Mission processes the application - it is
											// genuinely empty before that, and the status helpers
											// test for exactly that state. So an unprocessed
											// application has no scheme to show, and saying
											// "Not yet assigned" is more accurate than "NA".
											$schemeAssigned = FALSE;
											if (!empty($schemeNomenclature) && is_array($schemeNomenclature) && count($schemeNomenclature) > 0) {
												if (!empty($schemeNomenclature[0]['scholarship_id'])) {
													$schemeAssigned = TRUE;
													$schemeRow = $this->common_model->getSchemeById($schemeNomenclature[0]['scholarship_id']);
													if (is_array($schemeRow) && count($schemeRow) > 0 && isset($schemeRow[0]['scheme_name'])) {
														$schemeText = $schemeRow[0]['scheme_name'];
													}
												}
											}
											if (!$schemeAssigned) {
												$schemeText = 'Not yet assigned';
											}
											?>
											<div style="margin-top:18px; padding:12px; border:1px solid #cecece; background:#f4f4f4;">
												<label style="display:block; margin-bottom:8px;">Confirmed University &amp; University Letter</label>
												<table class="table table-bordered" style="width:100%; background:#fff; margin-bottom:0;">
													<thead>
														<th style="width:40%;">Confirmed University</th>
														<th style="width:20%;">University Letter</th>
														<th style="width:20%;">Scheme</th>
														<th style="width:20%;">Nomenclature</th>
													</thead>
													<tbody>
													<?php
													if (count($confirmedRows) > 0) {
														foreach ($confirmedRows as $confRow) {
															$confUniName = '';
															if (!empty($confRow['regional_university'])) {
																$confUniRow = $this->common_model->getUniversityById($confRow['regional_university']);
																if (is_array($confUniRow) && count($confUniRow) > 0 && isset($confUniRow[0]['name'])) {
																	$confUniName = $confUniRow[0]['name'];
																}
															}
															$letterFile = isset($confRow['region_one_doc']) ? trim((string) $confRow['region_one_doc']) : '';

															// Nomenclature for THIS allotment. On
															// iccr_university_response_by_hqrs the
															// nomenclature is held in the course column;
															// confirmed_course is a second source, and
															// the application's own nomenclature is the
															// last resort. The value may be an id or the
															// title itself, so resolve an id and
															// otherwise print the stored text.
															$rowNomRaw = '';
															foreach (array('course', 'confirmed_course', 'nomenclature') as $nomCol) {
																if (!empty($confRow[$nomCol])) {
																	$rowNomRaw = trim((string) $confRow[$nomCol]);
																	break;
																}
															}
															$rowNomText = '';
															if ($rowNomRaw !== '') {
																if (ctype_digit($rowNomRaw)) {
																	$rowNomRow = $this->common_model->getnomenclatureByid($rowNomRaw);
																	$rowNomText = (is_array($rowNomRow) && count($rowNomRow) > 0 && isset($rowNomRow[0]['title'])) ? $rowNomRow[0]['title'] : '';
																} else {
																	$rowNomText = $rowNomRaw;
																}
															}
															if ($rowNomText === '') {
																$rowNomText = $nomenclatureText;
															}
															?>
															<tr>
																<td><?php echo $confUniName !== '' ? htmlspecialchars($confUniName, ENT_QUOTES) : 'NA'; ?></td>
																<td>
																	<?php
																	if ($letterFile !== '') {
																		$letterFound = '';
																		$thisYear = (int) date('Y');
																		for ($y = $thisYear; $y >= $thisYear - 3; $y--) {
																			$tryPath = './' . $y . '/university_approval/' . $letterFile;
																			if (file_exists($tryPath)) { $letterFound = $tryPath; break; }
																		}
																		if ($letterFound !== '') {
																			?>
																			<a target="_blank" href="<?php echo site_url() . 'mission/downloadDocs/' . base64url_encode($letterFound); ?>"><span class="label label-success">Download</span></a>
																			<?php
																		} elseif (file_exists(FCPATH . 'assets/site/main/university_approval/' . $letterFile)) {
																			?>
																			<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $letterFile; ?>"><span class="label label-success">Download</span></a>
																			<?php
																		} else {
																			?>
																			<span class="label label-warning" title="Expected file: <?php echo htmlspecialchars($letterFile, ENT_QUOTES); ?>">File not found</span>
																			<?php
																		}
																	} else {
																		echo 'NA';
																	}
																	?>
																</td>
																<td><?php echo $schemeText !== '' ? htmlspecialchars($schemeText, ENT_QUOTES) : 'NA'; ?></td>
																<td><?php echo $rowNomText !== '' ? htmlspecialchars($rowNomText, ENT_QUOTES) : 'NA'; ?></td>
															</tr>
															<?php
														}
													} else {
														?>
														<tr>
															<td colspan="4">No university allotment has been recorded for this application yet.</td>
														</tr>
														<?php
													}
													?>
													</tbody>
												</table>
											</div>


									</td>

								</tr>
							<?php
									}
							?>
							
							<tr>
								<td colspan="2">
									<?php
									$user_data = $this->session->userdata('user_data');

									$student_type = $user_data['student_type'];
									$student_course_type = $user_data['apply_course_type'];
									$prgid = $user_data['apply_course_type'];
									if ($student_course_type == 11) {
									?>
										<span class="note1"><strong> </strong>.
										</span>
									<?php
									} else {
									?>
										<br/><br/><span class="note1"><strong>Note: </strong>&nbsp;&nbsp;&nbsp;Once admission is confirmed, no change in either course or University/Institute will be permitted by the Council.
											<br />Allotment of colleges is done by the respective Universities.
										</span>
									<?php
									}
									?>
									<br />
									<?php
									if (!empty($applicaitonStepOne)) {
										if ($applicaitonStepOne[0]['agreedisagree'] != "") {
											if ($applicaitonStepOne[0]['agreedisagree'] == 1) {
												echo "I agree : Yes";
											} elseif ($applicaitonStepOne[0]['agreedisagree'] == 2) {
												echo "I disagree : Yes";
											}
										}
									}
									?>
								</td>
							</tr>
							</tbody>
						</table>

					</div> <!--  Col-9 Div end here   -->

					
					<div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">

					</div>

					<!-- /.box-body -->

				</div>

				<?php
				if (isset($include) && $include == 'applicant_personal_info_preview') {
				?>
					<div class="box-body" <?php if (isset($include) && $include == 'applicant_personal_info_preview') {
												echo 'style="display:none;';
											} ?>>
					<?php
				}
					?>
<div class="box-body">  


					<div class="name-sec col-xs-12 col-sm-5 col-md-7 pdleft">
						<label class="scfont">23. Previous Educational Qualifications</label>
					</div>
					<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
						<table id="tbl_edu" class="table" style="width:100%;">
							<thead>
								<th>Certificate/Degree</th>
								<th>Country</th>
								<th>Board Name</th>
								<th>Name of School/University/Board</th>
								<th>Subjects Covered</th>
								<th>Year</th>
								<th>Percentage(%)/Grade</th>
							</thead>
							<tbody>
								<?php
								$programs = $this->config->item('programme');
								$program = $programs[$applicaitonStepOne[0]['programme']];
								switch ($program) {
									case "UG":
									case "Diploma":
									case "Certificate":
								?>

										<tr>
											<td>Grade X<br />(equivalent to Grade X in India)</td>
											<td>
												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>
											</td>

											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name_x']; ?>
											</td>

											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x']; ?>
											</td>

											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x']; ?>
											</td>

											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x']; ?>
											</td>
										</tr>
										<tr>
											<td>Grade XII<br />(equivalent to Grade XII in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['school_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>

											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university']; ?>
											</td>

											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage']; ?>
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
											<td>Grade X<br />(equivalent to Grade X in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x']; ?>
											</td>
										</tr>
										<tr>
											<td>Grade XII<br />(equivalent to Grade XII in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['school_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage']; ?>
											</td>
										</tr>
										<tr>
											<td>Undergraduate<br />(equivalent to three years course after grade XII in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage']; ?>
											</td>
										</tr>
									<?php
										break;
									case "M.Phil":
									?>
										<tr>
											<td>Grade X<br />(equivalent to Grade X in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x']; ?>
											</td>
										</tr>
										<tr>
											<td>Grade XII<br />(equivalent to Grade XII in India)</td>
											<td colspan="1">


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['school_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage']; ?>
											</td>
										</tr>
										<tr>
											<td>Undergraduate<br />(equivalent to three years course after grade XII in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage']; ?>
											</td>
										</tr>
										<tr>
											<td>Post graduate<br />(Two years University education after graduation or five years after class XII.)</td>
											<td>

												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['pg_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_university']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_percentage']; ?>
											</td>
										</tr>
									<?php
										break;
									case "Ph.D":
									?>
										<tr>
											<td>Grade X<br />(equivalent to Grade X in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x']; ?>
											</td>
										</tr>
										<tr>
											<td>Grade XII<br />(equivalent to Grade XII in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['school_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage']; ?>
											</td>
										</tr>
										<tr>
											<td>Undergraduate<br />(equivalent to three years course after grade XII in India)</td>
											<td>


												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>

											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage']; ?>
											</td>
										</tr>
										<tr>
											<td>Post graduate<br />(Two years University education after graduation or five years after class XII.)</td>
											<td>

												<?php
												$countries = $this->common_model->getCountries();
												foreach ($countries as $country) {
													if (!empty($applicaitonStepTwo)) {
														if ($applicaitonStepTwo[0]['pg_leaving_country'] == $country['id']) {
															echo $country['country_name'];
														}
													}
												}
												?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_board_name']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_university']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_subjects']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_year']; ?>
											</td>
											<td>
												<?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_percentage']; ?>
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
					if (!empty($applicaitonStepTwo) && $applicaitonStepTwo[0]['other_course_year'] != "" && $applicaitonStepTwo[0]['other_course_university'] != "" && $applicaitonStepTwo[0]['other_course'] != "") {
					?>
						<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
							<div class="name-sec col-xs-12 col-sm-6 col-md-12">
								<div class="form-group">
									<span class="note1"><strong> Note: </strong>(Details of any course in Indian Universities/Institutes which the scholar is currently attending or has attended in past.(Optional)</span>
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
										<td><?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course_year']; ?></td>
										<td><?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course_university']; ?></td>
										<td><?php if (!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					<?php
					}
					?>
				</div>

					<div class="name-sec col-xs-12 col-sm-5 col-md-12 pdleft">
						<label>24. Give below the names of two persons who have agreed to testify from their personal knowledge to your character (they must not be related to you and should have direct knowledge of your academic pursuits).</label>
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
										<td> <?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_name']; ?></td>
										<td>
											<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_designation']; ?>
										</td>
										<td> <?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_email']; ?> </td>
										<td> <?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_phone']; ?></td>
										<td colspan="2"><?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address']; ?></td>
									</tr>
									<tr>


									</tr>
								</tbody>
							</table>
							<br />
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
										<td><?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_name']; ?></td>
										<td><?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation']; ?></td>
										<td><?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_email']; ?> </td>
										<td><?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_phone']; ?></td>
										<td colspan="2"> <?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_address']; ?></td>
									</tr>
								</tbody>
							</table>
							<br />
							<?php
							if (isset($include) && $include == 'applicant_education_info_preview') {
							?>
								<table style="width:100%;" <?php if (isset($include) && $include == 'applicant_education_info_preview') {
																echo 'style="display:none;"';
															} ?>">
								<?php
							} elseif (isset($include) && $include == 'applicant_personal_info_preview') {
								?>
									<table style="width:100%;" <?php if (isset($include) && $include == 'applicant_personal_info_preview') {
																	echo 'style="display:none;"';
																} ?>">
									<?php
								}
									?>
									<tbody>
										<tr>
											<td>
												<label> 25. Details of close relative(s) or friends, if any, in India.</label>
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
																<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_name']; ?>
															</td>
															<td style="height: 27px;">
																<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_relation']; ?>
															</td>
															<td style="height: 27px;">
																<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_designation']; ?>
															</td>
															<td style="height: 27px;">
																<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_contact']; ?>
															</td>
															<td style="height: 27px;">
																<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_email']; ?>
															</td>
															<td style="height: 27px;">

																<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_address']; ?>
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
												<label>26. Have you travelled or lived in India in the past?</label>&nbsp;&nbsp;
												<?php
												if (!empty($applicaitonStepThree)) {
													if ($applicaitonStepThree[0]['is_travel_or_live_in_india_before'] == 1) {
														echo 'Yes';
													} elseif ($applicaitonStepThree[0]['is_travel_or_live_in_india_before'] == 2) {
														echo 'No';
													}
												}
												?>
											</td>
										</tr>
										<tr>
											</br>
											<td colspan="2" style="height: 35px;">
												<label>27. Have you ever availed of ICCR Scholarship earlier?</label>&nbsp;&nbsp;
												<?php
												if (!empty($applicaitonStepThree)) {
													if ($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 1) {
														echo 'Yes';
													} elseif ($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 2) {
														echo 'No';
													}
												}
												?>

											</td>
										</tr>
										</br>
										<?php
										if (!empty($applicaitonStepThree)) {
											if ($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 1) {
										?>
												<tr>
													<td>
														<table id="tbl_schrls" style="width:100%;" class="table">
															<thead>
																<th>Year of Scholarship</th>
																<th>Name of Course</th>
																<th>Previous Application Number</th>
																<th>Name of Institue/University</th>
																<th>Duration of stay in India on Scholarship</th>
															</thead>
															<tbody>
																<tr>
																	<td style="height: 35px;">
																		<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_year']; ?>
																	</td>
																	<td style="height: 35px;">

																		<?php
																		if (!empty($applicaitonStepThree)) {
																			if ($applicaitonStepThree[0]['iccr_scholar_course'] == 1) {
																				echo 'UG';
																			} elseif ($applicaitonStepThree[0]['iccr_scholar_course'] == 2) {
																				echo 'PG';
																			} elseif ($applicaitonStepThree[0]['iccr_scholar_course'] == 3) {
																				echo 'Ph.D.';
																			} elseif ($applicaitonStepThree[0]['iccr_scholar_course'] == 4) {
																				echo 'Other';
																			}
																		}
																		?>
																	</td>
																	<td style="padding-left:10px;height: 35px;">

																		<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['old_application_number']; ?>
																	</td>
																	<td style="padding-left:10px;height: 35px;">

																		<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_institute']; ?>
																	</td>
																	<td style="height: 35px;">

																		<?php
																		if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_from'];
																		echo '-';
																		if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_to'];
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
												<label>28. Are you currently a resident in India?</label>&nbsp;&nbsp;
												<?php
												if (!empty($applicaitonStepThree)) {
													if ($applicaitonStepThree[0]['currently_non_nri'] == 1) {
														echo 'Yes';
													} elseif ($applicaitonStepThree[0]['currently_non_nri'] == 2) {
														echo 'No';
													}
												}
												?>
											</td>
										</tr>
											</br>
										<?php
										if (!empty($applicaitonStepThree)) {
											if ($applicaitonStepThree[0]['currently_non_nri'] == 1) {
										?>
												<tr>
													<td>
														<label for="comment">Postal Address</label>

														:&nbsp;&nbsp;<?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['currently_non_nri_address']; ?>

													</td>
												</tr>
										<?php
											}
										}
										?>
										</br>
										<tr>
											<td style="height: 35px;">
												<label>29. Are you married to an indian national ?</label>&nbsp;&nbsp;
												<?php
												if (!empty($applicaitonStepThree)) {
													if ($applicaitonStepThree[0]['is_married'] == 1) {
														echo 'Yes';
													} elseif ($applicaitonStepThree[0]['is_married'] == 2) {
														echo 'No';
													}
												}
												?>
											</td>
										</tr>
										</br>
									
										<tr>
											<td style="height: 35px;">
												<label>30. Do you have an International driving licence?</label>&nbsp;&nbsp;
												<?php
												if (!empty($applicaitonStepThree)) {
													if ($applicaitonStepThree[0]['is_international_lic'] == 1) {
														echo 'Yes';
													} elseif ($applicaitonStepThree[0]['is_international_lic'] == 2) {
														echo 'No';
													}
												}
												?>
											</td>
										</tr>
										</br>
										<?php
										if (!empty($applicaitonStepThree)) {
											if ($applicaitonStepThree[0]['is_international_lic'] == 1) {
										?>
												<tr>
													<td colspan="1" style="height: 35px;">
														<table style="width:100%;">
															<tbody>
																<tr>
																	<td style="font-weight:bold;">Licence Number:</td>
																	<td><?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_no']; ?> </td>
																	<td style="font-weight:bold;">Issuing Authority:</td>
																	<td><?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_auth']; ?></td>
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
											<td style="height: 25px;font-weight: bold; text-align: left;">
												<label for="comment">31. Any Other Information: </label> <?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['any_other_info']; ?>

											</td>
										<tr></br>
											</br>

										<tr>
											<td style="height: 25px;font-weight: bold;"><label>Date: <?php
																										if (!empty($applicaitonSubmitData)) {
																											$date2 = $applicaitonSubmitData[0]['created'];

																											echo date('d-m-Y', $date2);
																										} else {
																											echo date('d-m-Y');
																										}
																										?></label></td>

										</tr>
										</br>
										<tr>
											<td style="height: 25px;font-weight: bold; text-align: left;">
												<label for="comment">Place: </label> <?php if (!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['place']; ?>

											</td>
										</tr>
							
							<tr>
								<td>
									<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and that I have understood the financial terms and conditions of the Schholarship Scheme. I hereby undertake to abide by them, and I also undertake to return to my country after completion of my studies in India.</span>
								</td>
							</tr>
							
										<tr>
											<td style="text-align:right;"><?php
								if (!empty($userd->dir) && !empty($applicaitonStepThree) && file_exists($userd->dir .'/'.$applicaitonStepThree[0]['signature_doc'])) {
									$imgs = file_get_contents($userd->dir .'/'.$applicaitonStepThree[0]['signature_doc']);
									$data = base64_encode($imgs);
									$f = finfo_open();
									$imgdata = base64_decode($data);
									$mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
								}
						  if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['signature_doc'] != "")
						  {
						  
	          				if($userd->dir == "")
							{
								?>
								  <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonStepThree[0]['signature_doc']; ?>" target="_blank" title="Click to View Signature"><img  style="padding:2px;width:150px;max-height:50px;" src="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonStepThree[0]['signature_doc']; ?>"/></a><br/>
								<?php		
							}
							else
							{
						
									if(file_exists($userd->dir.'/'.$applicaitonStepThree[0]['signature_doc']))
								{
									
									?>
									
									<a target="_blank" href="<?php echo site_url(); ?><?php echo $userd->dir.'/'.$applicaitonStepThree[0]['signature_doc']; ?>" target="_blank" title="Click to View Signature"><img  style="padding:2px;width:150px;max-height:50px;" src="data:<?php echo $mime_type;?>;base64,<?php echo $data;?>"/></a>
									
									<?php
								}
								else{
								
								?>									
								 <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonStepThree[0]['signature_doc']; ?>" target="_blank" title="Click to View Signature"><img  style="padding:2px;width:150px;max-height:50px;" src="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonStepThree[0]['signature_doc']; ?>"/></a></br>
								  
								<?php
								}
							}
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
				$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
				$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
			}
			
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
							<th>Uploaded Document</th>							
							<th>Uploaded Time</th>							
						</thead>
						<tbody>
							<?php
								$counter = 1;	
								$upload = 0;						
								$doctypes = $this->config->item('doc_types');	
								$file_path = $docsArray[$doctypes['id']['type']]['path'] ?? '';
								$file_path_passport = $docsArray[$doctypes['passport']['type']]['path'] ?? '';
								$file_path_school_leaving_x = $docsArray[$doctypes['school_leaving_x']['type']]['path'] ?? '';
								$file_path_school_leaving = $docsArray[$doctypes['school_leaving']['type']]['path'] ?? '';
								$file_path_ug = $docsArray[$doctypes['ug']['type']]['path'] ?? '';
								$file_path_pg = $docsArray[$doctypes['pg']['type']]['path'] ?? '';
								$file_path_phd = $docsArray[$doctypes['phd']['type']]['path'] ?? '';
								$file_path_phdReseachPaper = $docsArray[$doctypes['phdReseachPaper']['type']]['path'] ?? '';
								$file_path_indian_address = $docsArray[$doctypes['indian_address']['type']]['path'] ?? '';
								$file_path_d1 = isset($doctypes['d1']['type']) ? ($docsArray[$doctypes['d1']['type']]['path'] ?? '') : '';
								/*$file_path_physical = $docsArray[$doctypes['physical']['type']]['path'];*/
								$file_path_tl = $docsArray[$doctypes['tl']['type']]['path'] ?? '';
								$file_path_otherDoc = $docsArray[$doctypes['otherDoc']['type']]['path'] ?? '';
								$file_path_gmat = $docsArray[$doctypes['gmat']['type']]['path'] ?? '';
								$file_path_mphil = $docsArray[$doctypes['mhil']['type']]['path'] ?? '';
								
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
								  <a href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_passport); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
							?>
							<?php
						//	if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
							if(array_key_exists($doctypes['school_leaving_x']['type'],$docsArray))
							{								
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['school_leaving_x']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['school_leaving_x']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								   <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_school_leaving_x);?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#schoolLivingDivX">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['school_leaving_x']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['school_leaving_x']['type']]['time']);	
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
							
								?>
							<?php
						//	if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
							if(array_key_exists($doctypes['school_leaving']['type'],$docsArray))
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
								  <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_school_leaving); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0)
							if(array_key_exists($doctypes['ug']['type'],$docsArray))
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
								  <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_ug); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['pg_leaving_country'] != "" && $applicaitonStepTwo[0]['pg_leaving_country'] > 0)
							if(array_key_exists($doctypes['pg']['type'],$docsArray))
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
								   <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_pg); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['mphil_leaving_country'] != "" && $applicaitonStepTwo[0]['mphil_leaving_country'] > 0)
							if(array_key_exists($doctypes['mhil']['type'],$docsArray))
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
								  <a target="_blank" href="<?php echo $docsArray[$doctypes['mhil']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_phd); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								   <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_indian_address); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								   <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_d1); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
							<!--<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['physical']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['physical']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_physical); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								
							</tr>-->
							
							
								<?php if($applicaitonStepOne[0]['course'] == 35 || $applicaitonStepOne[0]['course_two'] == 35 || $applicaitonStepOne[0]['course_three'] == 35 || $applicaitonStepOne[0]['course_fourth'] == 35 || $applicaitonStepOne[0]['course_fifth'] == 35)
							{
								?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['gmat']['title'];?><span class="text-red">*</span> &nbsp;</td>
								<td>
								<?php
								  if(array_key_exists($doctypes['gmat']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  
							
								   <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_gmat); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  
								  <?php	
								  }
								  else
								  {
								  ?>
								
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['gmat']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['gmat']['type']]['time']);	
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
								  <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_tl); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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

							
								<?php							
							if(count($docsArray) > 0 && array_key_exists($doctypes['otherDoc']['type'],$docsArray))
							{	
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['otherDoc']['title'];?></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['otherDoc']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								 <a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_otherDoc); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  if(array_key_exists($doctypes['otherDoc']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['otherDoc']['type']]['time']);	
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
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Schholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.</span>
					</div>
										
				 </div>
				 </div>
		<div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
		<?php //echo "<pre>";print_r($applicaitonStepOne);die;?>
		<?php  
		if($applicaitonStepOne[0]['course_type'] == 1)
		{
			?>
			<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
	         	<?php if($this->uri->segment(4) != "")
	         		  {
	         		  	?>
					  	<a href="javascript:void(0);" onclick="applicaiton_process_pending('Pending','<?php echo $this->uri->segment(3); ?>','');" class="form-control sbmt">Process</a>
					  	<?php
	         		  }
	         		  else
	         		  {
					  	?>
					  	<a href="javascript:void(0);" onclick="applicaiton_process_agri('Process','<?php echo $this->uri->segment(3); ?>','');" class="form-control sbmt">Process</a>
					  	<?php
					  }
	         	 ?>
			  
		  </div>     
			
			<?php
		}
		else
		{
			?>
			<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
	         	<?php if($this->uri->segment(4) != "")
	         		  {
	         		  	?>
					  	<a href="javascript:void(0);" onclick="applicaiton_process_pending('Pending','<?php echo $this->uri->segment(3); ?>','');" class="form-control sbmt">Process</a>
					  	<?php
	         		  }
	         		  else
	         		  {
					  	?>
					  	<a href="javascript:void(0);" onclick="applicaiton_process('Process','<?php echo $this->uri->segment(3); ?>','');" class="form-control sbmt">Process</a>
					  	<?php
					  }
	         	 ?>
			  
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
	
	
<script>
function printDiv(divName) {
	
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;

     window.print();
     document.body.innerHTML = originalContents;
}

</script>

	
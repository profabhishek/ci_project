<?php
//error_reporting(1);
//echo "<pre>";
//print_r($registerData);die;
function sortByName( $a, $b ) {
  $a = $a[ 'uni' ];
  $b = $b[ 'uni' ];
  if ( $a == $b ) {
    return 0;
  }
  return ( $a < $b ) ? -1 : 1;
}
$stateuniversities = $this->common_model->getStateUniversities();
$icaruniversities = $this->common_model->getICARUniversity();
$ayush = $this->common_model->getAYUSHUniversity();
$agriculturealuniversitiesold = $this->common_model->getAgriculturalSfsUniversity();
$newagarray = array(
    '73' => array(
            'id' => '10020',
            'uni' => 'ICAR Indian Agricultural Research Institute',
            'link' => '',
            'title' => 'ICAR Indian Agricultural Research Institute',
            'state_id' => '10'
			),
			array(
            'id' => '426',
            'uni' => 'Assam Agricultural University, Jorhat',
            'link' => '',
            'title' => 'Assam Agricultural University, Jorhat',
            'state_id' => '4'
			)
			
        );
$agriculturealuniversities =	array_merge($agriculturealuniversitiesold,$newagarray);
//echo "<pre>";print_r($agriculturealuniversities);die;
//$agricultureal = $this->common_model->getAgriculturalUniversity();
$centraluniversities = $this->common_model->getCentralUniversities();
$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states = $this->common_model->getAllStates();
$nifts = $this->common_model->getAllNIFT();
$crstype = $this->common_model->getCourseTypesSfs();
//echo "<pre>";print_r($icaruniversities);
$statewiseUniversites = array();
foreach ( $states as $st ) {
  if ( !array_key_exists( $st[ 'id' ], $statewiseUniversites ) ) {
    $statewiseUniversites[ $st[ 'id' ] ] = array();
  }
}
$agriCultureUniversities = array();
foreach ( $states as $st ) {
  if ( !array_key_exists( $st[ 'id' ], $agriCultureUniversities ) ) {
    $agriCultureUniversities[ $st[ 'id' ] ] = array();
  }
}
//echo "<pre>";print_r($statewiseUniversites);
$icaruniUniversity = array();
foreach ( $states as $st ) {
  if ( !array_key_exists( $st[ 'id' ], $icaruniUniversity ) ) {
    $icaruniUniversity[ $st[ 'id' ] ] = array();
  }
}

$stateuniversities_one = str_replace( "'", "\'", json_encode( $stateuniversities ) );
$centraluniversities_one = str_replace( "'", "\'", json_encode( $centraluniversities ) );
$agricultureuniversities_one = str_replace( "'", "\'", json_encode( $agriculturealuniversities ) );
$icar_one = str_replace( "'", "\'", json_encode( $icaruniversities ) );
$nits_one = str_replace( "'", "\'", json_encode( $nits ) );
$yogas_one = str_replace( "'", "\'", json_encode( $yogas ) );
$states_array = json_encode( $statewiseUniversites );
$icar_array = json_encode( $agriCultureUniversities );



$agricultural_array = json_encode( $icaruniUniversity );
//echo "<pre>"; print_r($agricultural_array);
//$icar = json_encode( $icaruni );
$ayushUni = json_encode( $ayush );
$ctypes = json_encode( $crstype );
$nift = json_encode( $nifts );
?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
//console.log(stateuniversities);
var centralUniversities = JSON.parse('<?php echo $centraluniversities_one;?>');
var agriculturealuniversities = JSON.parse('<?php echo $agricultureuniversities_one;?>');
var icaruniversities = JSON.parse('<?php echo $icar_one;?>');
var nits = JSON.parse('<?php echo $nits_one;?>');
var yogas = JSON.parse('<?php echo $yogas_one;?>');
var statesarray = JSON.parse('<?php echo $states_array;?>');
var icararray = JSON.parse('<?php echo $icar_array;?>');
//alert(JSON.stringify(statesarray));
var agriculturalarray = JSON.parse('<?php echo $agricultural_array;?>');
var ayushU = JSON.parse('<?php echo $ayushUni;?>');
var courseTypeList = JSON.parse('<?php echo $ctypes;?>');
//alert(JSON.stringify(courseTypeList));
var niftList = JSON.parse('<?php echo $nift;?>');
</script>
<!-- Image loader -->
							
<section class="meacontent">
	<div class="col-xs-10 form_head">
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam" />
		<h3 class="text-center caps">Application Form(2022-2023) For SFS(Self Finance Student)</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
		<span class="notext">Note: (Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format)</span>
	</div>
	<?php
		if ( $this->session->flashdata( 'message_type' ) == "success" ) {
	?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
	</div>
	<?php
	}
		if ( $this->session->flashdata( 'message_type' ) == "error" ) {
	?>
	<div class="alert alert-error" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Error!</strong> <?php echo $this->session->flashdata('error');?> </div>
	<?php
	}
	?>
	<div  class="container pdleft pdright">
		<!-----<script type="text/javascript">
		window.history.pushState({}, "Indian Council for Cultural Relations",  baseURL + 'applicant/applicant_personal_info?appno=' + '<?php echo $get_application_number; ?>');
		</script>--->
		<?php  //echo $get_application_number;die;?>
		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
			
		<form id="form-process-personal-info" enctype="multipart/form-data" method="post">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
		
		<input type="hidden" name="application_no" value="<?php echo $get_application_number;?>"/>
		<?php
				//$data = array('onsubmit' => "return smtProfilePic();"); 
				//$hidden = array( $this->security->get_csrf_token_name() => $this->security->get_csrf_hash() );
				//echo form_open( 'applicant/applicant_education_info', array( 'onsubmit' => 'return validateFieldsPersonalInfo()' ) );
				?>
				<div class="box-body">
					<div class="formmainrow">
						<div class="col-xs-12 col-sm-10 col-md-10 pdleft pdright">
							<div class="formrow">
								<label title="Please Enetr Full Name">1. Full Name (IN BLOCK LETTERS)<span class="text-red" >*</span></label>
								<div class="col-xs-2 col-md-2 col-sm-2">
									<select id="student_title" name="student_title" class="selectpicker form-control" required="true">
										<?php
										$title = '';
										if ( count( $applicaitonStepOne ) > 0 ) {
										  $title = $applicaitonStepOne[ 0 ][ 'student_title' ];
										}
										if ( $title == 1 ) {
										  ?>
										<option value="">Title</option>
										<option  selected="selected" value="1">Mr.</option>
										<option  value="3">Mrs</option>
										<option  value="2">Ms</option>
										<?php
										} elseif ( $title == 2 ) {
											?>
										<option value="">Title</option>
										<option value="1">Mr.</option>
										<option  value="3">Mrs</option>
										<option selected="selected" value="2">Ms</option>
										<?php
										} elseif ( $title == 3 ) {
											?>
										<option value="">Title</option>
										<option value="1">Mr.</option>
										<option selected="selected" value="3">Mrs</option>
										<option  value="2">Ms</option>
										<?php
										} else {
										  ?>
										<option value="">Title</option>
										<option value="1">Mr.</option>
										<option  value="3">Mrs</option>
										<option value="2">Ms</option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-xs-10 col-md-4 col-sm-4">
									<?php
									  $myname = "";
									  if ( !empty( $applicaitonStepOne ) && $applicaitonStepOne[ 0 ][ 'fullname' ] != "" )$myname = $applicaitonStepOne[ 0 ][ 'fullname' ];
									  else $myname = $registerData[ 0 ][ 'username' ];
									?>
									<input type="text"  title="A-Z a-z ' '" name="fullname" class="form-control" placeholder="First Name" id="fullname" value="<?php if(!empty($myname)) echo $myname;?>"  required="true">
								</div>
								<div class="col-xs-3 col-md-3 col-sm-3">
									<?php
										$middlename = "";
										if ( !empty( $applicaitonStepOne ) && $applicaitonStepOne[ 0 ][ 'middlename' ] != "" )$middlename = $applicaitonStepOne[ 0 ][ 'middlename' ];
										else $myname = $registerData[ 0 ][ 'username' ];
									?>
									<input type="text" title="A-Z a-z ' '" name="middlename" class="form-control" placeholder="Middle Name" id="middlename" value="<?php if(!empty($middlename)) echo $middlename;?>">
								</div>
								<div class="col-xs-3 col-md-3 col-sm-3 text-red">
									<?php
										$familyname = "";
										if ( !empty( $applicaitonStepOne ) && $applicaitonStepOne[ 0 ][ 'familyname' ] != "" )$familyname = $applicaitonStepOne[ 0 ][ 'familyname' ];
										else $myname = $registerData[ 0 ][ 'username' ];
									?>
									<input type="text" title="A-Z a-z ' '" name="familyname" class="form-control" placeholder="Last Name" id="familyname" value="<?php if(!empty($familyname)) echo $familyname;?>"  required="true">
								</div>
							</div>
							
							<div class="formrow">
								<label title="Please Select Gender">2. Gender<span class="text-red">*</span></label>
								<?php
									  $title = '';
									  if ( count( $registerData ) > 0 ) {
										$title = $registerData[ 0 ][ 'gender' ];
									  }
									  if ( $title == 1 ) {
										?>
									  <input checked="true" class="is_knwldge" type="radio" value="1" name="gender" id="gender"/>
									  Male
									  <input type="radio" class="is_knwldge" value="2" name="gender" id="gender"/>
									  Female
									  <?php
									  } elseif ( $title == 2 ) {
										  ?>
									  <input class="is_knwldge" type="radio" value="1" name="gender" id="gender"/>
									  Male
									  <input type="radio" checked="true" class="is_knwldge" value="2" name="gender" id="gender"/>
									  Female
									  <?php
									  } else {
										?>
									  <input checked="true" class="is_knwldge" type="radio" value="1" name="gender" id="gender"/>
									  Male
									  <input type="radio" class="is_knwldge" value="2" name="gender" id="gender"/>
									  Female
									  <?php
									  }
								?>
								
							</div>
							
							
							
							<div class="formrow">
								<div class="col-xs-12 col-sm-4 col-md-4 pdleft">
									<label title="Please Enter Date of Birth" for="comment">3. Date of Birth<span class="text-red">*</span></label>
									<input type="text" readonly="true" class="form-control" placeholder="yy-mm-dd" id="dob" name="dob" value="<?php if(!empty($registerData)) echo $registerData[0]['date_of_birth'];?>"/>
								</div>
								<div class="col-xs-12 col-sm-4 col-md-4">
									<label title="Country" for="comment">Country <span class="text-red">*</span></label>
									<select id="nationality" name="nationality" class="selectpicker form-control" required="true">
										<?php
										$nationalities = $this->common_model->getCountries();
										foreach ( $nationalities as $na ) {
										  if ( !empty( $registerData ) ) {
											if ( $registerData[ 0 ][ 'country_of_domicile' ] == $na[ 'id' ] ) {
											  echo '<option selected="selected" value="' . $na[ 'id' ] . '">' . $na[ 'country_name' ] . '</option>';
											}
										  } else {
											echo '<option value="' . $na[ 'id' ] . '">' . $na[ 'country_name' ] . '</option>';
										  }

										}
										?>
									</select>
								</div>
								<div class="col-xs-12 col-sm-4 col-md-4">
									<label title="Nationality" for="comment">4. Nationality<span class="text-red">*</span></label>
									<select id="country" name="country" class="selectpicker form-control" required="true">
										<option value="">---- Select ---</option>
										<?php
											$countries = $this->common_model->getCountries();
											  foreach ( $countries as $country ) {
												if ( !empty( $applicaitonStepOne ) ) {
												  if ( $applicaitonStepOne[ 0 ][ 'country' ] == $country[ 'id' ] ) {
													echo '<option selected="selected" value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
												  } else {
													echo '<option value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
												  }
												} else {
												  echo '<option value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
												}

											  }
										?>
									</select>
								</div>
								
							</div>
							<?php
							  if ( !empty( $registerData ) ) {
								if ( $registerData[ 0 ][ 'country_of_domicile' ] == '75' || $registerData[ 0 ][ 'country_of_domicile' ] == '10') {
							?>
							<div class="formrow">
								<label for="comment" title="Passport No">5. Passport No<span class="text-red"></span></label>
								<input type="text" name="passport_no" class="form-control" placeholder="Passport No"  id="passport_no" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_no'];?>"/>
							</div>
							<?php
									} else {
								?>
							<div class="formrow">
								
								<label for="comment" title = "Passport No">5. Passport No<span class="text-red">*</span></label>
								<input type="text" name="passport_no" class="form-control" required placeholder="Passport No"  id="passport_no" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_no'];?>"/>
							</div>
							<?php
								}
								}
							?>
							
							
							
							<?php  
									
									if ( !empty( $registerData ) ) {
								if ( $registerData[ 0 ][ 'country_of_domicile' ] == '75' || $registerData[ 0 ][ 'country_of_domicile' ] == '10') {
									?>
									
										<div class="formrow">	
								<div class="col-xs-12 col-sm-6 col-md-6 pdleft">
									<label for="comment">a) Date of Issue<span class="text-red"></span></label>
									<div class="col-xs-12 col-sm-4 col-md-4 pdleft">
										<select class="form-control" id="passport_issue_date" name="passport_issue_date">
											<option value="">Date</option>
											<?php
												for ( $i = 1; $i <= 31; $i++ ) {
													if ( !empty( $applicaitonStepOne ) ) {
													  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_issue_date' ];
													  $date_of_issue_array = explode( '-', $date_of_issue );
													  if ( $i == $date_of_issue_array[ 0 ] ) {
														echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
													  } else {
														echo '<option value="' . $i . '">' . $i . '</option>';
													  }
													} else {
													  echo '<option value="' . $i . '">' . $i . '</option>';
													}
												}
											?>
										</select>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4">
										<select class="form-control" id="passport_issue_month" name="passport_issue_month">
											<option value="">Month</option>
											<?php
												for ( $i = 1; $i <= 12; $i++ ) {
												$monthName = date( "M", mktime( 0, 0, 0, $i, 10 ) );
													if ( !empty( $applicaitonStepOne ) ) {
													  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_issue_date' ];
													  $date_of_issue_array = explode( '-', $date_of_issue );
													  if ( $i == $date_of_issue_array[ 1 ] ) {
														echo '<option selected="selected" value="' . $i . '">' . $monthName . '</option>';
													  } else {
														echo '<option value="' . $i . '">' . $monthName . '</option>';
													  }
													} else {
													  echo '<option value="' . $i . '">' . $monthName . '</option>';
													}
												}
											?>
										</select>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4">
										<select id="passport_issue_year" name="passport_issue_year" class="form-control">
											<option value="">Year</option>
											<?php
												for ( $i = 1917; $i <= date( 'Y' ); $i++ ) {
													if ( !empty( $applicaitonStepOne ) ) {
													  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_issue_date' ];
													  $date_of_issue_array = explode( '-', $date_of_issue );
													  if ( $i == $date_of_issue_array[ 2 ] ) {
														echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
													  } else {
														echo '<option value="' . $i . '">' . $i . '</option>';
													  }
													} else {
													  echo '<option value="' . $i . '">' . $i . '</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<label for="comment">b) Date of Expiry<span class="text-red"></span></label>
									<div class="col-xs-12 col-sm-4 col-md-4 pdleft">
										<select class="form-control" id="passport_expiry_date" name="passport_expiry_date">
										  <option value="">Date</option>
										  <?php
										  for ( $i = 1; $i <= 31; $i++ ) {
											if ( !empty( $applicaitonStepOne ) ) {
											  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_expiry_date' ];
											  $date_of_issue_array = explode( '-', $date_of_issue );
											  if ( $i == $date_of_issue_array[ 0 ] ) {
												echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
											  } else {
												echo '<option value="' . $i . '">' . $i . '</option>';
											  }
											} else {
											  echo '<option value="' . $i . '">' . $i . '</option>';
											}
										  }
										  ?>
										</select>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4">
										<select class="form-control" id="passport_expiry_month" name="passport_expiry_month">
										  <option value="">Month</option>
										  <?php
										  for ( $i = 1; $i <= 12; $i++ ) {
											$monthName = date( "M", mktime( 0, 0, 0, $i, 10 ) );
											if ( !empty( $applicaitonStepOne ) ) {
											  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_expiry_date' ];
											  $date_of_issue_array = explode( '-', $date_of_issue );
											  if ( $i == $date_of_issue_array[ 1 ] ) {
												echo '<option selected="selected" value="' . $i . '">' . $monthName . '</option>';
											  } else {
												echo '<option value="' . $i . '">' . $monthName . '</option>';
											  }
											} else {
											  echo '<option value="' . $i . '">' . $monthName . '</option>';
											}
										  }
										  ?>
										</select>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4 pdright">
										<select id="passport_expiry_year" name="passport_expiry_year" class="form-control">
										  <option value="">Year</option>
										  <?php

										  for ( $i = date( 'Y' ); $i <= date( 'Y', strtotime( '+30 years' ) ); $i++ ) {
											if ( !empty( $applicaitonStepOne ) ) {
											  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_expiry_date' ];
											  $date_of_issue_array = explode( '-', $date_of_issue );
											  if ( $i == $date_of_issue_array[ 2 ] ) {
												echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
											  } else {
												echo '<option value="' . $i . '">' . $i . '</option>';
											  }
											} else {
											  echo '<option value="' . $i . '">' . $i . '</option>';
											}
										  }
										  ?>
										</select>
									</div>
								</div>
							</div>
									
									<?php
								}else
								{
									?>
										<div class="formrow">	
								<div class="col-xs-12 col-sm-6 col-md-6 pdleft">
									<label for="comment">a) Date of Issue<span class="text-red">*</span></label>
									<div class="col-xs-12 col-sm-4 col-md-4 pdleft">
										<select class="form-control" id="passport_issue_date" name="passport_issue_date" required>
											<option value="">Date</option>
											<?php
												for ( $i = 1; $i <= 31; $i++ ) {
													if ( !empty( $applicaitonStepOne ) ) {
													  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_issue_date' ];
													  $date_of_issue_array = explode( '-', $date_of_issue );
													  if ( $i == $date_of_issue_array[ 0 ] ) {
														echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
													  } else {
														echo '<option value="' . $i . '">' . $i . '</option>';
													  }
													} else {
													  echo '<option value="' . $i . '">' . $i . '</option>';
													}
												}
											?>
										</select>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4">
										<select class="form-control" id="passport_issue_month" name="passport_issue_month" required>
											<option value="">Month</option>
											<?php
												for ( $i = 1; $i <= 12; $i++ ) {
												$monthName = date( "M", mktime( 0, 0, 0, $i, 10 ) );
													if ( !empty( $applicaitonStepOne ) ) {
													  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_issue_date' ];
													  $date_of_issue_array = explode( '-', $date_of_issue );
													  if ( $i == $date_of_issue_array[ 1 ] ) {
														echo '<option selected="selected" value="' . $i . '">' . $monthName . '</option>';
													  } else {
														echo '<option value="' . $i . '">' . $monthName . '</option>';
													  }
													} else {
													  echo '<option value="' . $i . '">' . $monthName . '</option>';
													}
												}
											?>
										</select>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4">
										<select id="passport_issue_year" name="passport_issue_year" class="form-control" required>
											<option value="">Year</option>
											<?php
												for ( $i = 1917; $i <= date( 'Y' ); $i++ ) {
													if ( !empty( $applicaitonStepOne ) ) {
													  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_issue_date' ];
													  $date_of_issue_array = explode( '-', $date_of_issue );
													  if ( $i == $date_of_issue_array[ 2 ] ) {
														echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
													  } else {
														echo '<option value="' . $i . '">' . $i . '</option>';
													  }
													} else {
													  echo '<option value="' . $i . '">' . $i . '</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6">
									<label for="comment">b) Date of Expiry<span class="text-red">*</span></label>
									<div class="col-xs-12 col-sm-4 col-md-4 pdleft">
										<select class="form-control" id="passport_expiry_date" name="passport_expiry_date" required>
										  <option value="">Date</option>
										  <?php
										  for ( $i = 1; $i <= 31; $i++ ) {
											if ( !empty( $applicaitonStepOne ) ) {
											  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_expiry_date' ];
											  $date_of_issue_array = explode( '-', $date_of_issue );
											  if ( $i == $date_of_issue_array[ 0 ] ) {
												echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
											  } else {
												echo '<option value="' . $i . '">' . $i . '</option>';
											  }
											} else {
											  echo '<option value="' . $i . '">' . $i . '</option>';
											}
										  }
										  ?>
										</select>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4">
										<select class="form-control" id="passport_expiry_month" name="passport_expiry_month" required>
										  <option value="">Month</option>
										  <?php
										  for ( $i = 1; $i <= 12; $i++ ) {
											$monthName = date( "M", mktime( 0, 0, 0, $i, 10 ) );
											if ( !empty( $applicaitonStepOne ) ) {
											  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_expiry_date' ];
											  $date_of_issue_array = explode( '-', $date_of_issue );
											  if ( $i == $date_of_issue_array[ 1 ] ) {
												echo '<option selected="selected" value="' . $i . '">' . $monthName . '</option>';
											  } else {
												echo '<option value="' . $i . '">' . $monthName . '</option>';
											  }
											} else {
											  echo '<option value="' . $i . '">' . $monthName . '</option>';
											}
										  }
										  ?>
										</select>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4 pdright">
										<select id="passport_expiry_year" name="passport_expiry_year" class="form-control" required>
										  <option value="">Year</option>
										  <?php

										  for ( $i = date( 'Y' ); $i <= date( 'Y', strtotime( '+30 years' ) ); $i++ ) {
											if ( !empty( $applicaitonStepOne ) ) {
											  $date_of_issue = $applicaitonStepOne[ 0 ][ 'passport_expiry_date' ];
											  $date_of_issue_array = explode( '-', $date_of_issue );
											  if ( $i == $date_of_issue_array[ 2 ] ) {
												echo '<option selected="selected" value="' . $i . '">' . $i . '</option>';
											  } else {
												echo '<option value="' . $i . '">' . $i . '</option>';
											  }
											} else {
											  echo '<option value="' . $i . '">' . $i . '</option>';
											}
										  }
										  ?>
										</select>
									</div>
								</div>
							</div>
									
									<?php
									
								}
								
								
									}

							?>
							
							
						
							
							
							
							
							
							
						</div>
						<div class="col-xs-12 col-sm-2 col-md-2 prfl pull-right" >
							<?php
							$userd = $this->common_model->getUserInfo( $applicaitonStepOne[ 0 ][ 'uid' ] );
							$user_data = $this->session->userdata('user_data');
							$dir = $user_data['dir'];
							$imgs = file_get_contents($dir.'/'.$userImage);
							
							$data = base64_encode($imgs);
							$f = finfo_open();
							$imgdata = base64_decode($data);
                            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
							
							
							if ($userImage == "" ) {
							?>
							<img id="profil_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png" />
							<a href="javascript:void(0);" title = "Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format" data-toggle="modal" data-target="#profileUploadsPic">Upload Profile Pic</a>
							<hr>
							<span class="notext">Note: (Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format)</span>
							<?php
							} else {
							  ?>
							<img style="width:151px;height:171px;" id="profil_image_div" src="data:<?php if(!empty($mime_type)){echo $mime_type;}?>;base64,<?php if(!empty($data)){echo $data;}?>"/> <a href="javascript:void(0);" title = "Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format" data-toggle="modal" data-target="#profileUploadsPic">Re-Upload Profile Pic</a>
							<hr>
							<span style="color:black;font-weight: bold;box-shadow:4px 1px 13px yellow inset;">Note: (Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format) </span>
							<?php
							}
							?>
						</div>
					</div>
					
					<?php  
						
									if ( !empty( $registerData ) ) {
								if ( $registerData[ 0 ][ 'country_of_domicile' ] == '75' || $registerData[ 0 ][ 'country_of_domicile' ] == '10') {
									?>
									<div class="formrow">
						<label for="comment">c) Place of Issue<span class="text-red"></span></label>
						<input type="text" class="form-control" placeholder="Place of Issue" id="passport_issue_place" name="passport_issue_place"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place'];?>" />
					</div>
									
									<?php
									
								}
									else{
										?>
										<div class="formrow">
						<label for="comment">c) Place of Issue<span class="text-red">*</span></label>
						<input type="text" class="form-control" placeholder="Place of Issue" id="passport_issue_place" name="passport_issue_place"  required pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place'];?>" />
					</div>
										
										<?php
										
									}
									}
						?>
					
					<div class="formrow">
						<label for="comment">6. Postal Address <span class="text-red">*</span></label>
						<textarea class="form-control" rows="3" id="postal_address" name="postal_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address'];?></textarea>
					</div>
					<div class="formrow">
						<div class="col-xs-12 col-sm-3 col-md-3 pdleft">
							<input name="postal_address_city" pattern="^[a-zA-Z ]+$" title="[a-zA-Z ]" type="text" class="form-control" placeholder="City" id="postal_address_city" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_city'];?>">
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<input name="postal_address_state" pattern="^[a-zA-Z ]+$" title="[a-zA-Z ]" type="text" class="form-control" placeholder="State" id="postal_address_state" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_state'];?>">
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<select id="postal_address_country" name="postal_address_country" class="selectpicker form-control" required="true">
								<option value="">---- Country ---</option>
								<?php
									$countries = $this->common_model->getCountries();
									foreach ( $countries as $country ) {
									if ( !empty( $applicaitonStepOne ) ) {
									if ( $applicaitonStepOne[ 0 ][ 'postal_address_country' ] == $country[ 'id' ] ) {
									echo '<option selected="selected" value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
									} else {
									echo '<option value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
									}
									} else {
									echo '<option value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
									}
									}
								?>
							</select>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3 pdright">
							<input name="postal_address_pincode" title="[0-9]" pattern="^[0-9]+$" maxlength="11" type="text" class="form-control" placeholder="Zipcode" id="postal_address_pincode" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_pincode'];?>">
						</div>
					</div>
					<div class="formrow">
						<div class="col-xs-12 col-sm-6 col-md-6 pdleft">
							<label>7. Telephone/Mobile Number <span class="text-red">*</span></label>
							<input name="phone" pattern= "[0-9]" readonly="true" title="[0-9]" type="text" class="form-control" placeholder="Telephone No." id="phone" required="true" value="<?php if(!empty($registerData)) echo $registerData[0]['mobile_number'];?>">
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 pdright">
							<label>Email Id<span class="text-red">*</span></label>
							<input type="email" readonly="true" name="email" class="form-control" placeholder="Email" id="email" required="true" value="<?php if(!empty($registerData)) echo $registerData[0]['email_id'];?>">
						</div>
					</div>
					<div class="formrow">
						<label for="comment">Permanent Unique ID of your country (Excluding Passport No.)<span class="text-red">*</span></label>
						<input type="text" class="form-control" id="unique_id" name="unique_id" pattern="^[a-zA-Z0-9 ]+$" title="A-Z a-z 0-9 ' '" placeholder="Unique ID" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['unique_id'];?>"/>
					</div>
					<div class="formrow">
						<label for="comment">Details of Father/Mother/Guardian<span class="text-red">*</span></label>
						<div class="col-xs-12 col-sm-3 col-md-3 pdleft">
							<label for="comment">Name <span class="text-red">*</span></label>
							<input type="text" class="form-control" placeholder="Name" id="guardian_name" name="guardian_name" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_name'];?>"/>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<label for="comment">Relation <span class="text-red">*</span></label>
							<input type="text" class="form-control" placeholder="Relation" id="guardian_relation" name="guardian_relation" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_relation'];?>"/>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<label for="comment">Occupation <span class="text-red">*</span></label>
							<input type="text" class="form-control" placeholder="Occupation" id="guardian_occupation" name="guardian_occupation" required="true" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_occupation'];?>"/>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3 pdright">
							<label for="comment">Country <span class="text-red">*</span></label>
							<select class="selectpicker form-control" id="guardian_nationality" name="guardian_nationality" required="true">
								<option value="">---- Select ---</option>
								<?php
								$nationalities = $this->common_model->getCountries();
								foreach ( $nationalities as $na ) {
								  if ( !empty( $applicaitonStepOne ) ) {
									if ( $applicaitonStepOne[0]['guardian_nationality'] == $na['id'] ) {
									  echo '<option selected="selected" value="' . $na[ 'id' ] . '">' . $na['country_name'] . '</option>';
									} else {
									  echo '<option value="' . $na['id'] . '">' . $country[ 'country_name' ] . '</option>';
									}
								  } else {
									echo '<option value="' . $na['id'] . '">' . $na['country_name'] . '</option>';
								  }

								}
								?>
							</select>
						</div>
					</div>
					<div class="formrow">
						<div class="col-xs-12 col-sm-12 col-md-12 pdleft pdright">
							<label for="comment">Address <span class="text-red">*</span></label>
							<textarea class="form-control" rows="3" id="guardian_address" name="guardian_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_address'];?></textarea>
						</div>
					</div>
					<div class="formrow">
						<div class="col-xs-12 col-sm-3 col-md-3 pdleft">
							<input name="gardiuan_address_city" pattern="^[a-zA-Z ]+$" title="[A-Z,a-z]" type="text" class="form-control" placeholder="City" id="gardiuan_address_city" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_city'];?>">
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<input name="gardiuan_address_state" pattern="^[a-zA-Z ]+$" title="[A-Z,a-z]" type="text" class="form-control" placeholder="State" id="gardiuan_address_state" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_state'];?>">
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<select id="gardiuan_address_country" name="gardiuan_address_country" class="selectpicker form-control" required="true">
								<option value="">---- Country ---</option>
								<?php
								$countries = $this->common_model->getCountries();
								foreach ( $countries as $country ) {
								  if ( !empty( $applicaitonStepOne ) ) {
									if ( $applicaitonStepOne[ 0 ][ 'gardiuan_address_country' ] == $country[ 'id' ] ) {
									  echo '<option selected="selected" value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
									} else {
									  echo '<option value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
									}
								  } else {
									echo '<option value="' . $country[ 'id' ] . '">' . $country[ 'country_name' ] . '</option>';
								  }

								}
								?>
							</select>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3 pdright">
							<input name="gardiuan_address_pincode" title="[0-9]" title="[0-9]" type="text" class="form-control" placeholder="Zipcode" id="gardiuan_address_pincode" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_pincode'];?>">
						</div>
					</div>
					
					<div class="formrow">
						<div class="col-xs-12 col-sm-12 col-md-12 pdleft">
							<div class="forminner">
								<label for="comment" title = "Knowledge of English">8. Knowledge of English<span class="text-red">*</span></label>
								<?php
								  $knowledge = '';
								  if ( count( $applicaitonStepOne ) > 0 ) {
									$knowledge = $applicaitonStepOne[ 0 ][ 'knowledge_english' ];
								  }

								  if ( $knowledge == 1 ) {
									?>
								  <input checked="true" class="is_knwldge" type="radio" value="1" name="knowledge_english" id="knowledge_english"/>
								  Yes
								  <input type="radio" class="is_knwldge" value="2" name="knowledge_english" id="knowledge_english"/>
								  No
								  <?php
								  } elseif ( $knowledge == 2 ) {
									  ?>
								  <input type="radio" class="is_knwldge" value="1" name="knowledge_english" id="knowledge_english"/>
								  Yes
								  <input checked="true" class="is_knwldge" type="radio" value="2" name="knowledge_english" id="knowledge_english"/>
								  No
								  <?php
								  } else {
									?>
								  <input type="radio" class="is_knwldge" value="1" name="knowledge_english" id="knowledge_english"/>
								  Yes
								  <input type="radio" class="is_knwldge" value="2" name="knowledge_english" id="knowledge_english" checked="true"/>
								  No
								  <?php
								  }
								?>
							</div>
							<?php
								if ( $knowledge == 1 ) {
							?>
							<div class="col-xs-12 col-sm-4 col-md-4 knwledge_eng pdleft">
								<label for="comment">Written:</label>
								<?php
								//echo $applicaitonStepOne[ 0 ][ 'knowledge_english_spoken' ];
								  if ( $applicaitonStepOne[ 0 ][ 'knowledge_english_written' ] == 1 ) {
									?>
								  <input type="radio" checked="true" value="1" name="knowledge_english_written" id="knowledge_english_written "/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/>
								  Good
								  <?php

								  } elseif ( $applicaitonStepOne[ 0 ][ 'knowledge_english_written' ] == 2 ) {
									  ?>
								  <input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/>
								  Average
								  <input type="radio" checked="true" value="2" name="knowledge_english_written" id="knowledge_english_written"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/>
								  Good
								  <?php
								  } elseif ( $applicaitonStepOne[ 0 ][ 'knowledge_english_written' ] == 3 ) {
									  ?>
								  <input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/>
								  Proficient
								  <input type="radio" checked="true" value="3" name="knowledge_english_written" id="knowledge_english_written"/>
								  Good
								  <?php
								  } else {
									?>
								  <input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/>
								  Good
								  <?php
								  }
								  ?>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 knwledge_eng">
								<label for="comment">Spoken:</label>
								<?php
								  if ( $applicaitonStepOne[ 0 ][ 'knowledge_english_spoken' ] == 1 ) {
									?>
								  <input type="radio" checked="true" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken" checked="true"/>
								  Averages
								  <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Good
								  <?php

								  } elseif ( $applicaitonStepOne[ 0 ][ 'knowledge_english_spoken' ] == 2 ) {
									  //echo $applicaitonStepOne[ 0 ][ 'knowledge_english_spoken' ];
									  ?>
								  <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken" checked="true"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Good
								  <?php
								  } elseif ( $applicaitonStepOne[ 0 ][ 'knowledge_english_spoken' ] == 3 ) {
									  ?>
								  <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken" checked="true"/>
								  Good
								  <?php
								  } else {
									?>
								  <input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Good
								  <?php
								  }
								  ?>
							</div>
								<div class="col-xs-12 col-sm-4 col-md-4 knwledge_eng">
								<label for="comment">Reading:</label>
								<?php
								  if ( $applicaitonStepOne[ 0 ][ 'knowledge_english_reading' ] == 1 ) {
									?>
								  <input type="radio" value="1" name="knowledge_english_reading" id="knowledge_english_spoken" checked="true"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_reading" id="knowledge_english_spoken"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_reading" id="knowledge_english_spoken"/>
								  Good
								  <?php

								  } elseif ( $applicaitonStepOne[ 0 ][ 'knowledge_english_reading' ] == 2 ) {
									  ?>
								  <input type="radio" value="1" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_reading" id="knowledge_english_reading" checked="true"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Good
								  <?php
								  } elseif ( $applicaitonStepOne[ 0 ][ 'knowledge_english_reading' ] == 3 ) {
									  ?>
								  <input type="radio" value="1" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_reading" id="knowledge_english_reading" checked="true"/>
								  Good
								  <?php
								  } else {
									?>
								  <input type="radio" value="1" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Good
								  <?php
								  }
								  ?>
							</div>
							<?php
								} else {
							?>
							<div class="col-xs-12 col-sm-4 col-md-4 pdleft knwledge_eng fade">
								<label for="comment">Written:</label>
								<input type="radio" value="1" name="knowledge_english_written" id="knowledge_english_written "/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_written" id="knowledge_english_written"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_written" id="knowledge_english_written"/>
								  Good 
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 pdright knwledge_eng fade">
								<label for="comment">Spoken:</label>
								<input type="radio" value="1" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_spoken" id="knowledge_english_spoken"/>
								  Good
							</div>
							
							<div class="col-xs-12 col-sm-4 col-md-4 pdright knwledge_eng fade">
								<label for="comment">Reading:</label>
								<input type="radio" value="1" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Average
								  <input type="radio" value="2" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Proficient
								  <input type="radio" value="3" name="knowledge_english_reading" id="knowledge_english_reading"/>
								  Good
							</div>
							<?php
							}
							?>
						</div>
					
					</div>
				
					<div class="formrow">
						<div class="col-xs-12 col-sm-12 col-md-12 pdleft">
							<div class="forminner">
								<label for="comment" title = "">9.Do you have English Proficiency Test Score?<span class="text-red">*</span></label>
								<?php
								  $english_proficiency = '';
								  if ( count( $applicaitonStepOne ) > 0 ) {
									$english_proficiency = $applicaitonStepOne[ 0 ][ 'is_english_proficiency' ];
								  }

								  if ( $english_proficiency == 1 ) {
									?>
								  <input checked="true" class="is_english_proficiency" type="radio" value="1" name="is_english_proficiency" id="is_married"/>
								  Yes
								  <input type="radio" class="is_english_proficiency" value="2" name="is_english_proficiency" id="is_english_proficiency"/>
								  No
								  <?php
								  } elseif ( $english_proficiency == 2 ) {
									  ?>
								  <input type="radio" class="is_english_proficiency" value="1" name="is_english_proficiency" id="is_english_proficiency"/>
								  Yes
								  <input checked="true" class="is_english_proficiency" type="radio" value="2" name="is_english_proficiency" id="is_english_proficiency"/>
								  No
								  <?php
								  } else {
									?>
								  <input type="radio" class="is_english_proficiency" value="1" name="is_english_proficiency" id="is_english_proficiency"/>
								  Yes
								  <input type="radio" class="is_english_proficiency" value="2" name="is_english_proficiency" id="is_english_proficiency" checked="true"/>
								  No
								  <?php
								  }
								?>
							</div>
							
						</div>
					
				</div>
				
				<?php  
				
				if ( count( $applicaitonStepOne ) > 0 ) {
									$english_proficiency = $applicaitonStepOne[ 0 ][ 'is_english_proficiency' ];
								  }

								  if ( $english_proficiency == 1 ) 
								  {
				?>
				
					<div class="formrow">
								<div class="col-xs-12 col-sm-4 col-md-4 pdleft toefl_score_marks">
								
								
									<label title="Enter TOEFL Score" for="comment">TOEFL<span class="text-red"></span></label>
								
							<input type="text" class="form-control" placeholder="TOEFL" id="toefl_score" name="toefl_score"  value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['toefl_score'];?>"/>
								</div>
								<div class="col-xs-12 col-sm-4 col-md-4 ielts_score_marks">
									<label title="Enter IELTS Score" for="comment">IELTS <span class="text-red"></span></label>
									<input type="text" class="form-control" placeholder="IELTS" id="ielts_score" name="ielts_score"  value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['ielts_score'];?>"/>
								</div>
								<div class="col-xs-12 col-sm-4 col-md-4 duolingo_score_marks">
									<label title="Enter DUOLINGO Score" for="comment">DUOLINGO<span class="text-red"></span></label>
									<input type="text" class="form-control" placeholder="DUOLINGO" id="duolingo_score" name="duolingo_score"  value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['duolingo_score'];?>"/>
								</div>
								
					</div>
					
	<?php
								  }
								  else
								  {
									  ?>
									  <div class="formrow">
								<div class="col-xs-12 col-sm-4 col-md-4 pdleft toefl_score_marks fade">
								
								
									<label title="Enter TOEFL Score" for="comment">TOEFL<span class="text-red"></span></label>
								
							<input type="text" class="form-control" placeholder="TOEFL" id="toefl_score" name="toefl_score"  value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['toefl_score'];?>"/>
								</div>
								<div class="col-xs-12 col-sm-4 col-md-4 ielts_score_marks fade">
									<label title="Enter IELTS Score" for="comment">IELTS <span class="text-red"></span></label>
									<input type="text" class="form-control" placeholder="IELTS" id="ielts_score" name="ielts_score"  value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['ielts_score'];?>"/>
								</div>
								<div class="col-xs-12 col-sm-4 col-md-4 duolingo_score_marks fade">
									<label title="Enter DUOLINGO Score" for="comment">DUOLINGO<span class="text-red"></span></label>
									<input type="text" class="form-control" placeholder="DUOLINGO" id="duolingo_score" name="duolingo_score"  value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['duolingo_score'];?>"/>
								</div>
								
					</div>
									  <?php
								  }
								  ?>
										<div class="formrow">
						<div class="col-xs-12 col-sm-4 col-md-4 pdleft">

								<label for="comment" title = "Course applied">10. Course applied for<span class="text-red">*</span></label>
						 
						  <select id="programme" name="programme" class="form-control" required="true" >
							<option value="">Select Programme</option>
						<?php
							//$programme = $this->common_model->getAllProgramme();
							$programme = $this->common_model->getAllSfsProgramme();
							$res = array( 8 => $programme[ 7 ] );
							$ress = array_merge( array_slice( $programme, 0, 4 ), $res, array_slice( $programme, 4 ) );
							unset( $ress[ 8 ] );
							foreach ( $ress as $program ) {
							  if ( !empty( $applicaitonStepOne ) ) {
								if ( $applicaitonStepOne[ 0 ][ 'programme' ] == $program[ 'id' ] ) {
								  echo '<option selected="selected" value="' . $program[ 'id' ] . '">' . $program[ 'name' ] . '</option>';
								} else {
								  echo '<option value="' . $program[ 'id' ] . '">' . $program[ 'name' ] . '</option>';
								}
							  } else {
								echo '<option value="' . $program[ 'id' ] . '">' . $program[ 'name' ] . '</option>';
							  }
							}
							?>
					  </select>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 course_type">
						<?php
							if(count( $applicaitonStepOne ) > 0 ) {
							$user_data = $this->session->userdata( 'user_data' );
							$student_type = $user_data[ 'student_type' ];
							$student_course_type = $user_data[ 'apply_course_type' ];
							$prgid = $user_data[ 'apply_course_type' ];
						?>
						<div class="course_type pdleft" required="true" >
							<label for="comment" title ="Course Types choice">Course Type</label>
							<select id="course_type" name="course_type" class="form-control">
								<option value="">Select Course Type</option>
							<?php
								 $courseType = $this->common_model->getCourseTypesSfs();
								foreach ($courseType as $ctype){
								  if(!empty( $applicaitonStepOne)) {
									if ( $applicaitonStepOne[0]['course_type'] == $ctype['id']) {
									  echo '<option selected="selected" value="'.$ctype['id'].'">' . $ctype[ 'course_type' ] . '</option>';
									} else {
									  echo '<option value="'.$ctype['id'].'">'.$ctype['course_type'].'</option>';
									}
								  } else {
									echo '<option value="'.$ctype['id'].'">'.$ctype['course_type'].'</option>';
								  }
								}
								?>
							</select>
						</div>
							
						<div class="course_type fade" style="display:none;">
												  
							  <?php
						  } 
						  else 
						  {
						?>
							<label for="comment">Course Type<span class="text-red">*</span></label>
							<?php
							  $user_data = $this->session->userdata('user_data');
							  $student_type = $user_data['student_type'];
							  
							  $student_course_type = $user_data['apply_course_type'];
							  
?>								
							<select id= "course_type" name="course_type" class="form-control">
						
								<option value="">Select Course Type</option>
								<?php
								 
							
								  $courseType = $this->common_model->getCourseTypesSfs();
								foreach($courseType as $ctype){
								  if(!empty( $applicaitonStepOne)){
									if ($applicaitonStepOne[0]['course_type'] == $program['id'] ) {
									  echo '<option selected="selected" value="' . $program['id'] . '">' . $program[ 'course_type' ] . '</option>';
									} else {
									  echo '<option value="' . $ctype['id'] . '">' . $ctype['course_type'] . '</option>';
									}
								  } else {
									echo '<option value="' . $ctype['id'] . '">' . $ctype['course_type'] . '</option>';
								  }
								}
						  }
								?>
							</select>
						</div>
						</div>
					
					<?php 
					if(count( $applicaitonStepOne ) > 0 && !empty($applicaitonStepOne[ 0 ][ 'gmat_score' ])){
						
						?>
						
						<div class="col-xs-12 col-sm-4 col-md-4 gmat_sc">
									<label title="Enter GMAT Score" for="comment">GMAT<span class="text-red">*</span></label>
							<input type="text" class="form-control" placeholder="GMAT" id="gmat_score" name="gmat_score" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gmat_score'];?>"/>
					</div>
						<?php
					}
					else
					{
						
						?>
						
						<div class="col-xs-12 col-sm-4 col-md-4 gmat_sc" style="display:none;">
									<label title="Enter GMAT Score" for="comment">GMAT<span class="text-red">*</span></label>
							<input type="text" class="form-control" placeholder="GMAT" id="gmat_score" name="gmat_score" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gmat_score'];?>"/>
					</div>
						
						<?php
					}
					?>
					
					
					</div>
					
					<div class="formrow">
						  <?php
						  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
							?>
						  <div class="col-xs-12 col-sm-3 col-md-3 cours_subject" required="true">
							<label for="comment">Subject </label>
							<input type="text" name="course_subject" id="course_subject" class="form-control" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]["course_subject"];  ?>"/>
						  </div>
							<?php
							} else {
							?>
						  <div class="col-xs-12 col-sm-3 col-md-3 cours_subject" style="display:none;">
							<label for="comment">Subject </label>
							<input type="text" name="course_subject" id="course_subject" class="form-control"/>
						  </div>
						  <?php
						  }
						  ?>
					</div>

<?php
  if ( count( $applicaitonStepOne ) <= 0 || count( $applicaitonStepOne ) > 0 ) {
  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7 && $applicaitonStepOne[ 0 ][ 'programme' ] != 8 ) {
?>
<div class="formrow unidiv1">
	<?php
	} elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
    ?>
<div class="formrow unidiv1">
	<?php
		} elseif ( count( $applicaitonStepOne ) <= 0 ) {
    ?>
<div class="formrow unidiv1">
 <?php
}
  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7 && $applicaitonStepOne[ 0 ][ 'programme' ] != 8 ) {
    if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 ) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment" title = "Course choice 1">Course you wish to study <span class="text-red">*</span></label>
    <select id="course" name="course" class="form-control course">
        <option value="">Select Course</option>
        <?php
        $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

        foreach ( $courses as $course ) {
          if ( !empty( $applicaitonStepOne ) ) {
            if ( $applicaitonStepOne[ 0 ][ 'course' ] == $course[ 'id' ] ) {
              echo '<option selected="selected" value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
            } else {
              echo '<option value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
            }
          } else {
            echo '<option value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
          }
        }
        ?>
    </select>
  </div>
  <?php
  } elseif ( $applicaitonStepOne[ 0 ][ 'programme' ] == 5 || $applicaitonStepOne[ 0 ][ 'programme' ] == 6 ) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment">Course you wish to study <span class="text-red">*</span></label>
    <select id="course" name="course" class="form-control course" >
        <option value="">Select Course</option>
        <?php
        $courses = $this->common_model->getCourseByPrgramme( $applicaitonStepOne[ 0 ][ 'programme' ] );

        foreach ( $courses as $course ) {
          if ( !empty( $applicaitonStepOne ) ) {
            if ( $applicaitonStepOne[ 0 ][ 'course' ] == $course[ 'id' ] ) {
              echo '<option selected="selected" value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
            } else {
              echo '<option value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
            }
          } else {
            echo '<option value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
          }
        }
        ?>
    </select>
  </div>
  <?php
  } elseif ( $applicaitonStepOne[ 0 ][ 'programme' ] == 9 ) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment">Course you wish to study <span class="text-red">*</span></label>
    <select id="course" name="course" class="form-control course" >
        <option value="">Select Course</option>
        <?php
        $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

        foreach ( $courses as $course ) {
          if ( !empty( $applicaitonStepOne ) ) {
            if ( $applicaitonStepOne[ 0 ][ 'course' ] == $course[ 'id' ] ) {
              echo '<option selected="selected" value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
            } else {
              echo '<option value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
            }
          } else {
            echo '<option value="' . $course[ 'id' ] . '">' . $course[ 'title' ] . '</option>';
          }
        }
        ?>
      </select>
  </div>
  <?php
  }

  } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdright fade course_wish_study" style="display:none;">
    <label for="comment">Course you wish to study <span class="text-red">*</span></label>
    <select id="course" name="course" class="form-control ">
		<option value="">Select Course</option>
	</select>
  </div>
  <?php
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment">Course you wish to study  <span class="text-red">*</span></label>
    <select id="course" name="course" class="form-control course">
		<option value="">Select Course</option>
	</select>
  </div>
  <?php
  }
  ?>
  <?php
  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdright unidiv">
    <label for="comment">University <span class="text-red">*</span></label>
    <select id="universty_choice" name="universty_choice"  class="form-control" onchange="selectUniversityChoice(this.value)"  required="true">
        <option value="">Select</option>
        <?php
        if ( count( $applicaitonStepOne ) > 0 ) {
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
            echo '<optgroup label="State Universities">';
            foreach ( $stateuniversities as $univercity ) {
              if ( array_key_exists( $univercity[ 'state_id' ], $statewiseUniversites ) ) {
                array_push( $statewiseUniversites[ $univercity[ 'state_id' ] ], $univercity );
              }
            }
            foreach ( $statewiseUniversites as $key => $univercity1 ) {
              if ( count( $univercity1 ) > 0 ) {
                $statenames = $this->common_model->getStateById( $key );
                echo '<optgroup label="&nbsp;&nbsp;&nbsp;' . $statenames[ 0 ][ 'name' ] . '" class="stt">';
                foreach ( $univercity1 as $uni_choice ) {
                  if ( !empty( $applicaitonStepOne ) ) {
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $uni_choice[ 'id' ] ) {
                      echo '<option selected="selected" value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                    } else {
                      echo '<option value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                    }
                  } else {
                    echo '<option value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                  }
                }
                echo '</optgroup>';
              }
            }
            echo '</optgroup>';
            echo '<optgroup label="Central Universities">';
            foreach ( $centraluniversities as $univercity_cnet ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_cnet[ 'id' ] ) {
                  echo '<option selected="selected" value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                } else {
                  echo '<option value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                }
              } else {
                echo '<option value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
              }
            }
            echo '</optgroup>';
            echo '<optgroup label="National Institute of Technology (NIT)">';
            foreach ( $nits as $univercity_nit ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_nit[ 'id' ] ) {
                  echo '<option selected="selected" value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
                } else {
                  echo '<option value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
                }
              } else {
                echo '<option value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
              }
            }
            echo '</optgroup>';
          } elseif ( $applicaitonStepOne[ 0 ][ 'programme' ] == 7 ) {
            echo '<optgroup label="Gurus">';
            foreach ( $yogas as $univercity_yogs ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_yogs[ 'id' ] ) {
                  echo '<option selected="selected" value="' . $univercity_yogs[ 'id' ] . '">' . $univercity_yogs[ 'uni' ] . '</option>';
                } else {
                  echo '<option value="' . $univercity_yogs[ 'id' ] . '">' . $univercity_yogs[ 'uni' ] . '</option>';
                }
              } else {
                echo '<option value="' . $univercity_yogs[ 'id' ] . '">' . $univercity_yogs[ 'uni' ] . '</option>';
              }
            }
            echo '</optgroup>';
          }
        }
        ?>
      </select>
  </div>
  <?php
  } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 5 || $applicaitonStepOne[ 0 ][ 'programme' ] == 6 || $applicaitonStepOne[ 0 ][ 'programme' ] == 9 ) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
    <label for="comment" title = "University Choice 1">University <span class="text-red">*</span></label>
    <select id="universty_choice" name="universty_choice"  class="form-control universty_choice_cl" onchange="selectUniversityChoice(this.value)"  required="true">        
        <option value="">Select</option>
        <?php

        if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 ) {
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4) {
            if ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 1 ) {
              foreach ( $ayush as $un ) {
                echo '<option selected="selected" value="' . $un[ 'id' ] . '">' . $un[ 'uni' ] . '</option>';
              }
            } elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 2 ) {
              foreach ( $agriculturealuniversities as $un ) {
                echo '<option selected="selected" value="' . $un[ 'id' ] . '">' . $un[ 'uni' ] . '</option>';
              }
            }
            elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 3 || $applicaitonStepOne[ 0 ][ 'course_type' ] == 4 || $applicaitonStepOne[ 0 ][ 'course_type' ] == 6 || $applicaitonStepOne[ 0 ][ 'course_type' ] == 7 || $applicaitonStepOne[ 0 ][ 'course_type' ] == 8 || $applicaitonStepOne[ 0 ][ 'course_type' ] == 9 ) {
              echo '<optgroup label="State Universities">';
              foreach ( $stateuniversities as $univercity ) {
                if ( array_key_exists( $univercity[ 'state_id' ], $statewiseUniversites ) ) {
                  array_push( $statewiseUniversites[ $univercity[ 'state_id' ] ], $univercity );
                }
              }
              foreach ( $statewiseUniversites as $key => $univercity1 ) {
                if ( count( $univercity1 ) > 0 ) {
                  $statenames = $this->common_model->getStateById( $key );
                  echo '<optgroup label="&nbsp;&nbsp;&nbsp;' . $statenames[ 0 ][ 'name' ] . '" class="stt">';
                  foreach ( $univercity1 as $uni_choice ) {
                    if ( !empty( $applicaitonStepOne ) ) {
                      if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $uni_choice[ 'id' ] ) {
                        echo '<option selected="selected" value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                      } else {
                        echo '<option value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                      }
                    } else {
                      echo '<option value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                    }
                  }
                  echo '</optgroup>';
                }
              }
              echo '</optgroup>';
              echo '<optgroup label="Central Universities">';
              foreach ( $centraluniversities as $univercity_cnet ) {
                if ( !empty( $applicaitonStepOne ) ) {
                  if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_cnet[ 'id' ] ) {
                    echo '<option selected="selected" value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                  } else {
                    echo '<option value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                  }
                } else {
                  echo '<option value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                }
              }
              echo '</optgroup>';
            }
            elseif ( $applicaitonStepOne[0]['course_type'] == 5 ) {


              //$program_id = $applicaitonStepOne[ 0 ][ 'programme' ];
              //$courseType_id = $applicaitonStepOne[ 0 ][ 'course_type' ];
              //$course_id = $applicaitonStepOne[ 0 ][ 'course' ];
              //$university_id = $applicaitonStepOne[ 0 ][ 'universty_choice' ];
              //$stateuniversities = $this->common_model->getUniversitiesWithMapping( $program_id, $courseType_id, $course_id, $university_id );
              //$nits = $this->common_model->getNITUniversitiesWithMapping( $program_id, $courseType_id, $course_id, $university_id );
              echo '<optgroup label="State Universities">';
              foreach ( $stateuniversities as $univercity ) {
                if ( array_key_exists( $univercity[ 'state_id' ], $statewiseUniversites ) ) {
                  array_push( $statewiseUniversites[ $univercity[ 'state_id' ] ], $univercity );
                }
              }
              foreach ( $statewiseUniversites as $key => $univercity1 ) {
                if ( count( $univercity1 ) > 0 ) {
                  $statenames = $this->common_model->getStateById( $key );
                  echo '<optgroup label="&nbsp;&nbsp;&nbsp;' . $statenames[ 0 ][ 'name' ] . '" class="stt">';
                  foreach ( $univercity1 as $uni_choice ) {
                    if ( !empty( $applicaitonStepOne ) ) {
                      if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $uni_choice[ 'id' ] ) {
                        echo '<option selected="selected" value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                      } else {
                        echo '<option value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                      }
                    } else {
                      echo '<option value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                    }
                  }
                  echo '</optgroup>';
                }
              }
			   echo '<optgroup label="Central Universities">';
              foreach ( $centraluniversities as $univercity_cnet ) {
                if ( !empty( $applicaitonStepOne ) ) {
                  if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_cnet[ 'id' ] ) {
                    echo '<option selected="selected" value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                  } else {
                    echo '<option value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                  }
                } else {
                  echo '<option value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                }
              }
              echo '</optgroup>';
              echo '</optgroup>';
              echo '<optgroup label="National Institute of Technology (NIT)">';
              foreach ( $nits as $univercity_nit ) {
                if ( !empty( $applicaitonStepOne ) ) {
                  if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_nit[ 'id' ] ) {
                    echo '<option selected="selected" value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
                  } else {
                    echo '<option value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
                  }
                } else {
                  echo '<option value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
                }
              }
              echo '</optgroup>';
            }

          }
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 9 ) {
            echo '<optgroup label="State Universities">';
            foreach ( $stateuniversities as $univercity ) {
              if ( array_key_exists( $univercity[ 'state_id' ], $statewiseUniversites ) ) {
                array_push( $statewiseUniversites[ $univercity[ 'state_id' ] ], $univercity );
              }
            }
            foreach ( $statewiseUniversites as $key => $univercity1 ) {
              if ( count( $univercity1 ) > 0 ) {
                $statenames = $this->common_model->getStateById( $key );
                echo '<optgroup label="&nbsp;&nbsp;&nbsp;' . $statenames[ 0 ][ 'name' ] . '" class="stt">';
                foreach ( $univercity1 as $uni_choice ) {
                  if ( !empty( $applicaitonStepOne ) ) {
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $uni_choice[ 'id' ] ) {
                      echo '<option selected="selected" value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                    } else {
                      echo '<option value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                    }
                  } else {
                    echo '<option value="' . $uni_choice[ 'id' ] . '">' . $uni_choice[ 'uni' ] . '</option>';
                  }
                }
                echo '</optgroup>';
              }
            }
            echo '</optgroup>';
            echo '<optgroup label="Central Universities">';
            foreach ( $centraluniversities as $univercity_cnet ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_cnet[ 'id' ] ) {
                  echo '<option selected="selected" value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                } else {
                  echo '<option value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
                }
              } else {
                echo '<option value="' . $univercity_cnet[ 'id' ] . '">' . $univercity_cnet[ 'uni' ] . '</option>';
              }
            }
            echo '</optgroup>';
            echo '<optgroup label="National Institute of Technology (NIT)">';
            foreach ( $nits as $univercity_nit ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_nit[ 'id' ] ) {
                  echo '<option selected="selected" value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
                } else {
                  echo '<option value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
                }
              } else {
                echo '<option value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit[ 'uni' ] . '</option>';
              }
            }
            echo '</optgroup>';
          } elseif ( $applicaitonStepOne[ 0 ][ 'programme' ] == 5 || $applicaitonStepOne[ 0 ][ 'programme' ] == 6 ) {
            echo '<optgroup label="Gurus">';
            foreach ( $yogas as $univercity_yogs ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice' ] == $univercity_yogs[ 'id' ] ) {
                  echo '<option selected="selected" value="' . $univercity_yogs[ 'id' ] . '">' . $univercity_yogs[ 'uni' ] . '</option>';
                } else {
                  echo '<option value="' . $univercity_yogs[ 'id' ] . '">' . $univercity_yogs[ 'uni' ] . '</option>';
                }
              } else {
                echo '<option value="' . $univercity_yogs[ 'id' ] . '">' . $univercity_yogs[ 'uni' ] . '</option>';
              }
            }
            echo '</optgroup>';
          }
        }
        ?>
      </select>
  </div>
  <?php
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
    <label for="comment">University <span class="text-red">*</span></label>
    <?php
      $user_data = $this->session->userdata( 'user_data' );
      $student_type = $user_data[ 'student_type' ];
      $student_course_type = $user_data[ 'apply_course_type' ];

      if($student_type == 1 && $student_course_type == 11) {
        ?>
      <select id="universty_choice" name="universty_choice"  class="form-control universty_choice_cl" onchange="selectAyushUniversityChoice(this.value)" required="true">
        <?php
        } else {
          ?>
        <select id="universty_choice" name="universty_choice"  class="form-control universty_choice_cl"  required="true" onchange="selectUniversityChoice(this.value)">
        <?php

        }
        ?>
        <option value="">Select</option>
      </select>
  </div>
  <?php
  }
  if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 ) {
    $crs = $this->common_model->getCoursesById( $applicaitonStepOne[ 0 ][ 'course' ] );
    if ( $applicaitonStepOne[ 0 ][ 'course' ] > 0 && $crs[ 0 ][ 'has_stream' ] > 0 ) {
   $crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 fade in course_option_name">
							 <label for="comment">Course Stream/Subject 1</label>
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
							 <label for="comment">Course Stream/Subject 1</label>
								<div class="form-group col-md-10 pdleft">
								  <input type="text" name="course_option_name" id="course_option_name" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name'];?>"/>
								</div>
							</div>
							<?php	
							}
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft fade in course_option_name" style="display:none;">
    <label for="comment" title = "Course Stream choice 1">Course Stream/Subject 1 </label>
    <input type="text" name="course_option_name" id="course_option_name" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name'];?>"/>
  </div>
  <?php
  }
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdright fade course_option_name" style="display:none;">
    <label for="comment">Course Stream/Subject 1 </label>
     <input type="text" name="course_option_name" id="course_option_name" class="form-control" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name'];?>"/>
  </div>
  <?php
  }
  }
  ?>
</div>
		<div class="formrow">
					<div class="col-xs-12 col-sm-4 col-md-4 pdleft course_type">
				
						 <label for="comment">Year <span class="text-red">*</span></label>
							<div class="form-group">
							  <select id="course_year" name="course_year" class="form-control">						 	
							 <option value="">Select Year</option>
							 <?php  if($applicaitonStepOne[0]['course_year'] == 1)
						{
							?>
							<option value = "1" selected = "true">I Year</option>
							<option value = "2">II Year</option>
							<option value = "3">III Year</option>	
							<?php
						} elseif($applicaitonStepOne[0]['course_year'] == 2)
						{
							?>
							<option value = "1">I Year</option>
							<option value = "2" selected = "true">II Year</option>
							<option value = "3">III Year</option>	
							<?php
						} elseif($applicaitonStepOne[0]['course_year'] == 3)
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
						
				<!-----<div class="col-xs-12 col-sm-6 col-md-6">
						  <?php
						  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 ||  $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
							?>
						  <div class="col-xs-12 col-sm-6 col-md-6 cours_subject" required="true">
							<label for="comment">Subject </label>
							<input type="text" name="course_subject" id="course_subject" class="form-control" required="true" value="<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]["course_subject"];  ?>"/>
						  </div>
							<?php
							} else {
							?>
						  <div class="col-xs-12 col-sm-6 col-md-6 cours_subject">
							<label for="comment">Subject </label>
							<input type="text" name="course_subject" id="course_subject" class="form-control"/>
						  </div>
						  <?php
						  }
						  ?>
				</div>----->
				
					<div class="col-xs-12 col-sm-4 col-md-4 pdleft">
					 <label for="comment">City<span class="text-red">*</span></label>
						<div class="form-group">
						 <div class="form-group">
						<select id="region" name="region" class="selectpicker form-control" required="true">
						  <option value="">---- Select ---</option>
						  <?php
						  $regions = $this->common_model->getAllRegions();
						  foreach($regions as $region)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['region'] == $region['id'])
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
</div>
				
			
						
						
						
		
        <div class="name-sec col-xs-2 col-sm-2 col-md-2 pull-right mt-2">
          <input type="submit" id="step-one-application" name="step-one-application" class="form-control sbmt" value="Next >>"/>
        </div>
        <?php
        if ( !empty( $applicaitonStepOne ) ) {
          ?>
        <div class="name-sec col-xs-2 col-sm-2 col-md-2 pull-right mt-2"><a href="<?php echo site_url();?>applicant/view_personal_info?appno=<?php echo $applicaitonStepOne[0]['application_no'];?>" target = "_blank" class="form-control sbmt">Preview</a></div>
        <?php
        }
		else
		{
			?>
			
			<div class="name-sec col-xs-2 col-sm-2 col-md-2 pull-right mt-2"><a href="javascript:void(0);" class="form-control sbmt" disabled>Preview</a></div>
        <?php
		
		}
        ?>
      </div>
      <?php //echo form_close(); ?> 
	  </form>
	  </div>
  </div>
</div>

</section>



<script>
$('#profilePic').dropzone({ url: baseURL + "applicant/uploadProfilePic",uploadMultiple:false,dictDefaultMessage:"Click / Drop here to upload files"});
</script>
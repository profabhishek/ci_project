<?php
function sortByName( $a, $b ) {
  $a = $a[ 'uni' ];
  $b = $b[ 'uni' ];
  if ( $a == $b ) {
    return 0;
  }
  return ( $a < $b ) ? -1 : 1;
}
$stateuniversities = $this->common_model->getStateUniversities();
$icaruni = $this->common_model->getICARUniversity();
$ayush = $this->common_model->getAYUSHUniversities();
$ayushUniversities = $this->common_model->getAYUSHUniversities();
$agricultureal = $this->common_model->getAgriculturalUniversity();
$centraluniversities = $this->common_model->getCentralUniversities();
$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states = $this->common_model->getAllStates();
$nifts = $this->common_model->getAllNIFT();
$crstype = $this->common_model->getCourseTypes();
$statewiseUniversites = array();
foreach ( $states as $st ) {
  if ( !array_key_exists( $st[ 'id' ], $statewiseUniversites ) ) {
    $statewiseUniversites[ $st[ 'id' ] ] = array();
  }
}


$user_data = $this->session->userdata('user_data');
				$student_type = $user_data['student_type'];	
				$student_course_type = $user_data['apply_course_type'];	
				
				$userid = $user_data['userid'];	
				if($student_type == 1 && $student_course_type == 10 || $student_type == NULL && $student_course_type == 10){
					$crstype =  $this->common_model->getAllAyushCourseType();
				}
				else
				{
					$crstype =  $this->common_model->getCourseTypes();
				}
$icaruniUniversity = array();
foreach ( $states as $st ) {
  if ( !array_key_exists( $st[ 'id' ], $icaruniUniversity ) ) {
    $icaruniUniversity[ $st[ 'id' ] ] = array();
  }
}
$stateuniversities_one = str_replace( "'", "\'", json_encode( $stateuniversities ) );
$centraluniversities_one = str_replace( "'", "\'", json_encode( $centraluniversities ) );
$ayushuniversities_one = str_replace("'","\'",json_encode($ayushUniversities));
$nits_one = str_replace( "'", "\'", json_encode( $nits ) );
$yogas_one = str_replace( "'", "\'", json_encode( $yogas ) );
$states_array = json_encode( $statewiseUniversites );
$icar = json_encode( $icaruni );
$agricultural = json_encode( $agricultureal );
$ayushUni = json_encode($ayushUniversities);
$ctypes = json_encode( $crstype );
$nift = json_encode( $nifts );


?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
var ayushuniversities = JSON.parse('<?php echo $ayushuniversities_one;?>');
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
<!-- Image loader -->

<style>
   #admission {
   display: flex;
   }
   #course_wish {
   order: 2;
   }
   #univdiv {
   order: 1;
   }
   #option_name {
   order: 3;
   }
   .capitalLetter:valid {
   text-transform: uppercase;
   }
   /* .capitalLetter::placeholder {
   text-transform: capitalize;
   } */
</style>
<section class="meacontent">
   <div class="col-xs-10 form_head">
      <img src="<?php echo site_url(); ?>assets/site/main/images/indian-embelam.png"
         alt="Indian Embelam" />
      <h3 class="text-center caps">Application Form(2025-2026) For Scholarship through ICCR</h3>
      <h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
      <span class="text-center"
         style="color:red;font-size:13px;font-weight:bold;padding:13px 0;display: block;">THE INFORMATION ENTERED BY
      THE STUDENT SHOULD BE SINCERELY FILLED.</br>
      IF THE DETAILS ENTERED BY THE STUDENT AT ANY STAGE OF THE ADMISSION PROCESS ARE FOUND INCORRECT AND DOES NOT MATCH WITH THE ORIGINAL DOCUMENTS OR ENTRIES IN DUPLICATE ARE FOUND, THE ADMISSION OF THE SAID STUDENT WILL STAND <b style="font-size: 21px;">CANCELLED</b>.</span>
      <span class="notext">Note: (Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format)</span>
   </div>
   <?php
      if ($this->session->flashdata('message_type') == "success") {
      ?>
   <div class="alert alert-success"
      role="alert">
      <button type="button"
         class="close"
         data-dismiss="alert"
         aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
   </div>
   <?php
      }
      if ($this->session->flashdata('message_type') == "error") {
      ?>
   <div class="alert alert-error"
      role="alert">
      <button type="button"
         class="close"
         data-dismiss="alert"
         aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
   </div>
   <?php
      }
      ?>
   <div class="container pdleft pdright"
      style="padding-top:140px;">
   <div class="tab-content col-12 col-lg-12 col-md-12 col-sm-12">
   <div id="home"
      class="tab-pane fade in active">
   <form id="form-process-personal-info"
      enctype="multipart/form-data"
      method="post">
      <input type="hidden"
         name="<?php echo $this->security->get_csrf_token_name(); ?>"
         value="<?php echo $this->security->get_csrf_hash(); ?>" />
      <input type="hidden"
         name="application_no"
         value="<?php echo $get_application_number; ?>" />
      <div class="box-body">
      <div class="col-xs-12 col-sm-12 col-md-12 pdleft pdright">
         <div class="col-xs-12 col-sm-2 col-md-2 prfl pull-right">
            <?php
               if (isset($applicaitonStepOne[0]['uid'])) {
                 $userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']);
               } else {
                 $userd = "";
               }
               $user_data = $this->session->userdata('user_data');
               $imgArray = $this->common_model->getUserImage($applicaitonStepOne[0]['uid']);
            if (count($imgArray) > 0) {
                $image = $imgArray[0]['name'];?>
                <?php if(!empty($dir)){ ?>
                <img id="profil_image_div" src="<?php echo site_url(); ?><?php echo str_replace('./','',$dir).'/'.$image; ?>"/>
                <?php } else { ?>
                <img id="profil_image_div" src="<?php echo site_url(); ?>assets/site/main/profile_pics/<?php echo $image; ?>"/>
                <?php } ?>
            <a href="javascript:void(0);"
               title="Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format"
               data-toggle="modal"
               data-target="#profileUploadsPic">Re-Upload Profile Pic</a>
            <hr>
            <?php
               }else {
               ?>
               
            <a href="javascript:void(0);"
               title="Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format"
               data-toggle="modal"
               data-target="#profileUploadsPic">Upload Profile Pic</a>
            <hr>
            <span style="color:black;font-weight: bold;box-shadow:4px 1px 13px yellow inset;">Note:
            (Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format)
            </span>
            <?php
               }

            $data['userImage'] = $image;
               $dir = $user_data['dir'];
               $imgs = file_get_contents($dir . '/' . $userImage);
             
               //echo $imgs;
               $data = base64_encode($imgs);
               $f = finfo_open();
               $imgdata = base64_decode($data);
               $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
               
               
               if ($userImage == "") {
               ?>
            
            <?php
               }
               ?>
         </div>
         <div class="formmainrow">
            <div class="formrow">
               <label title="Please Enetr Full Name">1. Full Name<span
                  class="text-red">*</span></label>
               <div class="col-xs-2 col-md-3 col-sm-3">
                  <select readonly="true"
                     id="student_title"
                     name="student_title"
                     class="selectpicker form-control "
                     required="true">
                     <option value="">Title</option>
                     <option value="1"
                        <?php if($registerData[0]['student_title'] == 1) echo 'selected'; ?>>Mr
                     </option>
                     <option value="2"
                        <?php if($registerData[0]['student_title'] == 2) echo 'selected'; ?>>Ms
                     </option>
                     <option value="3"
                        <?php if($registerData[0]['student_title'] ==3) echo 'selected'; ?>>Mrs
                     </option>
                  </select>
               </div>
               <div class="col-xs-10 col-md-3 col-sm-3">
                  <?php
                     $myname = "";
                     if (!empty($applicaitonStepOne) && $applicaitonStepOne[0]['fullname'] != "") $myname = $applicaitonStepOne[0]['fullname'];
                     else $myname = $registerData[0]['username'];
                     ?>
                  <input type="text"
                     title="A-Z"
                     name="fullname"
                     readonly="true"
                     class="form-control capitalLetter"
                     placeholder="First Name"
                     id="fullname"
                     value="<?php if (!empty($myname)) echo strtoupper($myname); ?>"
                     required="true">
               </div>
               <div class="col-xs-3 col-md-3 col-sm-3">
                  <?php
                     $myname1 = $registerData[0]['student_mname'];
                     ?>
                  <input type="text"
                     title="A-Z"
                     name="middlename"
                     readonly="true"
                     class="form-control capitalLetter"
                     placeholder="Middle Name"
                     id="middlename"
                     value="<?php if (!empty($myname1)) echo strtoupper($myname1); ?>">
               </div>
               <div class="col-xs-3 col-md-3 col-sm-3 text-red">
                  <?php
                     $myname2 = $registerData[0]['student_lname'];
                     ?>
                  <input type="text"
                     title="A-Z"
                     name="familyname"
                     readonly="true"
                     class="form-control capitalLetter"
                     placeholder="Last Name"
                     id="familyname"
                     value="<?php if (!empty($myname2)) echo strtoupper($myname2); ?>"
                     required="true">
               </div>
            </div>
            <div class="formrow">
               <div class="col-xs-2 col-md-3 col-sm-3">
                  <label title="Please Select Gender">2. Gender<span
                     class="text-red">*</span></label>
                  <?php
                     $title = '';
                     if (count($registerData) > 0) {
                         $title = $registerData[0]['gender'];
                     }
                     if ($title == 1) {
                     ?>
                  <select readonly="true"
                     class="is_knwldge form-control col-xs-3 col-md-3 col-sm-3"
                     id="gender"
                     name="gender">
                     <option value="">Select</option>
                     <option selected
                        value="1">M</option>
                     <option value="2">F</option>
                  </select>
                  <?php
                     } elseif ($title == 2) {
                     ?>
                  <select readonly="true"
                     class="is_knwldge form-control col-xs-3 col-md-3 col-sm-3"
                     id="gender"
                     name="gender">
                     <option value="">Select</option>
                     <option value="1">M</option>
                     <option selected
                        value="2">F</option>
                  </select>
                  <?php
                     } else {
                     ?>
                  <select readonly="true"
                     class="is_knwldge form-control col-xs-3 col-md-3 col-sm-3"
                     id="gender"
                     name="gender">
                     <option value="">Select</option>
                     <option selected
                        value="1">M</option>
                     <option value="2">F</option>
                  </select>
                  <?php
                     }
                     ?>
               </div>
               <div class="col-xs-12 col-sm-3 col-md-3 pdleft">
                  <label title="Please Enter Date of Birth"
                     for="comment">3. Date of Birth<span class="text-red">*</span></label>
                  <input type="text"
                     readonly="true"
                     class="form-control"
                     placeholder="yy-mm-dd"
                     id="dob"
                     name="dob"
                     value="<?php if (!empty($registerData)) echo $registerData[0]['date_of_birth']; ?>" />
               </div>
               <div class="col-xs-12 col-sm-3 col-md-3 pdleft">
                  <label title="Birth City"
                     for="comment">4. Place of Birth<span class="text-red">*</span></label>
                  <input type="text"
                     class="form-control capitalLetter"
                     title="A-Z"
                     name="city"
                     onkeypress="return (event.charCode > 64 && 
                     event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                     placeholder="City"
                     value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['city']; ?>" />
               </div>
               <div class="col-xs-12 col-sm-3 col-md-3 pdleft">
                  <label title="Birth Country"
                     for="comment">Place of Birth Country<span class="text-red">*</span></label>
                  <select id="birth_country"
                     name="birth_country"
                     class="selectpicker form-control"
                     required="true">
                     <option value="">---- Country ---</option>
                  <?php
                     $countries = $this->common_model->getCountries();
                     foreach ($countries as $country) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['birth_country'] == $country['id']) {
                                 echo '<option selected="selected" value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                             } else {
                                 echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                         }
                     }
                     ?>
                  </select>
               </div>
            </div>
            <div class="formrow">
               <div class="col-xs-12 col-sm-3 col-md-3">
                  <label title="Country"
                     for="comment">5. Current Location <span class="text-red">*</span></label>
                  <select id="nationality"
                     name="nationality"
                     class="selectpicker form-control capitalLetter"
                     readonly="true"
                     required="true">
                  <?php
                     $nationalities = $this->common_model->getCountries();
                     foreach ($nationalities as $na) {
                         if (!empty($registerData)) {
                             if ($registerData[0]['country_of_domicile'] == $na['id']) {
                                 echo '<option selected="selected" value="' . $na['id'] . '">' . $na['country_name'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $na['id'] . '">' . $na['country_name'] . '</option>';
                         }
                     }
                     ?>
                  </select>
               </div>
               <?php
                  if (!empty($registerData)) {
                      if ($registerData[0]['country_of_domicile'] == '75' || $registerData[0]['country_of_domicile'] == '10') {
                  ?>
               <div class="col-xs-12 col-sm-3 col-md-3">
                  <label for="comment"
                     title="Passport No">6. Passport No<span class="text-red"></span></label>
                  <input type="text"
                     readonly="true"
                     name="passport_no"
                     class="form-control capitalLetter"
                     required="true"
                     placeholder="Passport No"
                     id="passport_no"
                     pattern="^[a-zA-Z0-9 ]+$"
                     title="A-Z a-z 0-9 ' '"
                     value="<?php if (!empty($registerData)) echo $registerData[0]['passport_no']; ?>" />
               </div>
               <?php
                  } else {
                  ?>
               <div class="col-xs-12 col-sm-3 col-md-3">
                  <label for="comment"
                     title="Passport No">6. Passport No<span class="text-red">*</span></label>
                  <input type="text"
                     readonly="true"
                     name="passport_no"
                     class="form-control capitalLetter"
                     required="true"
                     placeholder="Passport No"
                     id="passport_no"
                     pattern="^[a-zA-Z0-9 ]+$"
                     title="A-Z a-z 0-9 ' '"
                     value="<?php if (!empty($registerData)) echo $registerData[0]['passport_no']; ?>" />
               </div>
               <?php
                  }
                  }
                  ?>
               <?php
                  if (!empty($registerData)) {
                      if ($registerData[0]['country_of_domicile'] == '75' || $registerData[0]['country_of_domicile'] == '10') {
                  ?>
               <div class="col-xs-12 col-sm-3 col-md-3">
                  <label for="comment">7. Place of Issue of Passport<span
                     class="text-red">*</span></label>
                  <input type="text"
                     class="form-control capitalLetter"
                     placeholder="City"
                     id="passport_issue_place"
                     name="passport_issue_place"
                     pattern="^[a-zA-Z ]+$"
                     onkeypress="return (event.charCode > 64 && 
                     event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                     title="A-Z"
                     value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place']; ?>" />
               </div>
               <div class="col-xs-12 col-sm-3 col-md-3">
                  <label for="comment">Passport Issue Country<span
                     class="text-red">*</span></label>
                  <select id="passport_issue_country"
                     name="passport_issue_country"
                     class="selectpicker form-control"
                     required="true">
                     <option value="">---- Country ---</option>
                     <?php
                        $countries = $this->common_model->getCountries();
                        foreach ($countries as $country) {
                            if (!empty($applicaitonStepOne)) {
                                if ($applicaitonStepOne[0]['passport_issue_country'] == $country['id']) {
                                    echo '<option selected="selected" value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                                } else {
                                    echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                                }
                            } else {
                                echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                            }
                        }
                        ?>
                  </select>
               </div>
               <?php
                  } else {
                  ?>
               <div class="col-xs-12 col-sm-3 col-md-3">
                  <label for="comment">7. Place of Issue of Passport <span
                     class="text-red">*</span></label>
                  <input type="text"
                     class="form-control capitalLetter"
                     placeholder="City"
                     id="passport_issue_place"
                     name="passport_issue_place"
                     required
                     onkeypress="return (event.charCode > 64 && 
                     event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                     pattern="^[a-zA-Z ]+$"
                     title="A-Z"
                     value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['passport_issue_place']; ?>" />
               </div>
               <div class="col-xs-12 col-sm-3 col-md-3">
                  <label for="comment">Passport Issue Country<span
                     class="text-red">*</span></label>
                  <select id="passport_issue_country"
                     name="passport_issue_country"
                     class="selectpicker form-control"
                     required="true">
                     <option value="">---- Country ---</option>
                     <?php
                        $countries = $this->common_model->getCountries();
                        foreach ($countries as $country) {
                            if (!empty($applicaitonStepOne)) {
                                if ($applicaitonStepOne[0]['passport_issue_country'] == $country['id']) {
                                    echo '<option selected="selected" value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                                } else {
                                    echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                                }
                            } else {
                                echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                            }
                        }
                        ?>
                  </select>
               </div>
               <?php
                  }
                  }
                  ?>
            </div>
            <?php
               if (!empty($registerData)) {
                   if ($registerData[0]['country_of_domicile'] == '75' || $registerData[0]['country_of_domicile'] == '10') {
               ?>
            <div class="formrow">
               <div class="col-xs-12 col-sm-6 col-md-6 pdleft">
                  <label for="comment">8. Date of Issue of Passport<span
                     class="text-red"></span></label>
                  <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
                     <select class="form-control"
                        id="passport_issue_date"
                        name="passport_issue_date">
                        <option value="">Date</option>
                        <?php
                           for ($i = 1; $i <= 31; $i++) {
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[0]) {
                                       echo '<option selected="selected" value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                                   } else {
                                       echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                                   }
                               } else {
                                   echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                               }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4">
                     <select class="form-control"
                        id="passport_issue_month"
                        name="passport_issue_month">
                        <option value="">Month</option>
                        <?php
                           for ($i = 1; $i <= 12; $i++) {
                               $monthName = date("M", mktime(0, 0, 0, $i, 10));
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[1]) {
                                       echo '<option selected="selected" value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                                   } else {
                                       echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                                   }
                               } else {
                                   echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                               }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4">
                     <select id="passport_issue_year"
                        name="passport_issue_year"
                        class="form-control">
                        <option value="">Year</option>
                        <?php
                           for ($i = 1917; $i <= date('Y'); $i++) {
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[2]) {
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
                  <label for="comment">9. Date of Expiry of Passport<span
                     class="text-red"></span></label>
                  <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
                     <select class="form-control"
                        id="passport_expiry_date"
                        name="passport_expiry_date">
                        <option value="">Date</option>
                        <?php
                           for ($i = 1; $i <= 31; $i++) {
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[0]) {
                                       echo '<option selected="selected" value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                                   } else {
                                       echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                                   }
                               } else {
                                   echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                               }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4">
                     <select class="form-control"
                        id="passport_expiry_month"
                        name="passport_expiry_month">
                        <option value="">Month</option>
                        <?php
                           for ($i = 1; $i <= 12; $i++) {
                               $monthName = $i < 10 ? '0' . $i : $i;
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[1]) {
                                       echo '<option selected="selected" value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                                   } else {
                                       echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                                   }
                               } else {
                                   echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                               }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4 pdright">
                     <select id="passport_expiry_year"
                        name="passport_expiry_year"
                        class="form-control">
                        <option value="">Year</option>
                        <?php
                           for ($i = date('Y'); $i <= date('Y', strtotime('+30 years')); $i++) {
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[2]) {
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
               } else {
               ?>
            <div class="formrow">
               <div class="col-xs-12 col-sm-6 col-md-6 pdleft">
                  <label for="comment">8. Date of Issue of Passport<span
                     class="text-red">*</span></label>
                  <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
                     <select class="form-control"
                        id="passport_issue_date"
                        name="passport_issue_date"
                        required>
                        <option value="">Date</option>
                        <?php
                           for ($i = 1; $i <= 31; $i++) {
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[0]) {
                                       echo '<option selected="selected" value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                                   } else {
                                       echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                                   }
                               } else {
                                   echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                               }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4">
                     <select class="form-control"
                        id="passport_issue_month"
                        name="passport_issue_month"
                        required>
                        <option value="">Month</option>
                        <?php
                           for ($i = 1; $i <= 12; $i++) {
                               $monthName = $i < 10 ? '0' . $i : $i;
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[1]) {
                                       echo '<option selected="selected" value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                                   } else {
                                       echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                                   }
                               } else {
                                   echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                               }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4">
                     <select id="passport_issue_year"
                        name="passport_issue_year"
                        class="form-control"
                        required>
                        <option value="">Year</option>
                        <?php
                           for ($i = 1917; $i <= date('Y'); $i++) {
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_issue_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[2]) {
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
                  <label for="comment">9. Date of Expiry of Passport<span
                     class="text-red">*</span></label>
                  <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
                     <select class="form-control"
                        id="passport_expiry_date"
                        name="passport_expiry_date"
                        required>
                        <option value="">Date</option>
                        <?php
                           for ($i = 1; $i <= 31; $i++) {
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[0]) {
                                       echo '<option selected="selected" value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                                   } else {
                                       echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                                   }
                               } else {
                                   echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . ($i < 10 ? '0' . $i : $i) . '</option>';
                               }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4">
                     <select class="form-control"
                        id="passport_expiry_month"
                        name="passport_expiry_month"
                        required>
                        <option value="">Month</option>
                        <?php
                           for ($i = 1; $i <= 12; $i++) {
                               $monthName = $i < 10 ? '0' . $i : $i;
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[1]) {
                                       echo '<option selected="selected" value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                                   } else {
                                       echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                                   }
                               } else {
                                   echo '<option value="' . ($i < 10 ? '0' . $i : $i) . '">' . $monthName . '</option>';
                               }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-4 pdright">
                     <select id="passport_expiry_year"
                        name="passport_expiry_year"
                        class="form-control"
                        required>
                        <option value="">Year</option>
                        <?php
                           for ($i = date('Y'); $i <= date('Y', strtotime('+30 years')); $i++) {
                               if (!empty($applicaitonStepOne)) {
                                   $date_of_issue = $applicaitonStepOne[0]['passport_expiry_date'];
                                   $date_of_issue_array = explode('-', $date_of_issue);
                                   if ($i == $date_of_issue_array[2]) {
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
      </div>
      <div class="formrow">
         <div class="col-xs-12 col-sm-12 col-md-12 pdleft">
            <label for="comment">10. Postal Address <span class="text-red">*</span></label>
            <textarea class="form-control capitalLetter"
               rows="3"
               id="postal_address"
               name="postal_address"
               placeholder="Postal Address"
               required="true"><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address']; ?></textarea>
         </div>
      </div>
      <div class="formrow">
         <div class="col-xs-12 col-sm-3 col-md-3">
            <input name="postal_address_city"
               pattern="^[a-zA-Z ]+$"
               title="[a-zA-Z ]"
               type="text"
               onkeypress="return (event.charCode > 64 && 
               event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
               class="form-control capitalLetter"
               placeholder="City"
               id="postal_address_city"
               required="true"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_city']; ?>">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <input name="postal_address_state"
               pattern="^[a-zA-Z ]+$"
               title="[a-zA-Z ]"
               type="text"
               onkeypress="return (event.charCode > 64 && 
               event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
               class="form-control capitalLetter"
               placeholder="State"
               id="postal_address_state"
               required="true"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_state']; ?>">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <select id="postal_address_country"
               name="postal_address_country"
               class="selectpicker form-control"
               required="true">
               <option value="">---- Country ---</option>
               <?php
                  $countries = $this->common_model->getCountries();
                  foreach ($countries as $country) {
                      if (!empty($applicaitonStepOne)) {
                          if ($applicaitonStepOne[0]['postal_address_country'] == $country['id']) {
                              echo '<option selected="selected" value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                          } else {
                              echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                          }
                      } else {
                          echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                      }
                  }
                  ?>
            </select>
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <input name="postal_address_pincode"
               title="[0-9]"
               pattern="^[0-9]+$"
               maxlength="11"
               type="text"
               class="form-control"
               placeholder="Zipcode"
               id="postal_address_pincode"
               required="true"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_pincode']; ?>">
         </div>
      </div>
      <div class="formrow">
         <div class="col-xs-12 col-sm-3 col-md-3">
            <label>11. Mobile Number <span class="text-red">*</span></label>
            <input type="text"
               class="form-control"
               value="<?php if (!empty($registerData)) echo $registerData[0]['mobile_number']; ?>"
               id="phone_number"
               pattern="^[0-9\+]+$"
               title="+0-9"
               required="true"
               readonly="true"
               name="phone_number"
               placeholder="Mobile Number"
               maxlength="20">
            <!-- <small><b>You&nbsp;want&nbsp;to&nbsp;use&nbsp;same&nbsp;No&nbsp;on&nbsp;WhatsApp</b>&nbsp;<input 
               type="checkbox"
               value="<?php if (!empty($registerData)) echo $registerData[0]['mobile_number']; ?>"></small>-->
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <label>12. WhatsApp Number <span class="text-red">*</span></label>
            <input name="whatsapp_number"
               pattern="^[0-9\+]+$"
               title="+0-9"
               type="number"
               required="true"
               class="form-control"
               placeholder="WhatsApp No. with Country Code"
               maxlength="20"
               id="phone">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <label>13. Email Id<span class="text-red">*</span></label>
            <input type="email"
               readonly="true"
               name="email"
               class="form-control"
               placeholder="Email"
               id="email"
               value="<?php if (!empty($registerData)) echo $registerData[0]['email_id']; ?>">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <label for="comment">14. Unique Identification No<span class="text-red">*</span></label>
            <input type="text"
               class="form-control capitalLetter"
               id="unique_id"
               name="unique_id"
               readonly="true"
               pattern="^[a-zA-Z0-9 ]+$"
               title="A-Z a-z 0-9 ' '"
               placeholder="Unique ID"
               required="true"
               value="<?php if (!empty($registerData)) echo $registerData[0]['unique_id']; ?>" />
         </div>
      </div>
      <div class="formrow">
      <label for="comment">15. Details of Father/Mother<span class="text-red">*</span></label>
      <div class="col-xs-12 col-sm-3 col-md-4">
         <label for="comment">Father Name <span class="text-red">*</span></label>
         <div class="form-group">
            <input class="form-control capitalLetter"
               readonly="ture"
               id="father_name"
               pattern="^[a-zA-Z ]+$"
               title="A-Z a-z ' '"
               placeholder="Enter Name"
               value="<?php if (!empty($registerData)) echo strtoupper($registerData[0]['father_fname'] . ' ' . $registerData[0]['father_mname'] . ' ' . $registerData[0]['father_lname']); ?>">
         </div>
      </div>
      <div class="col-xs-12 col-sm-3 col-md-4">
         <label> Phone Number <span class="text-red">*</span></label>
         <input type="text"
            class="form-control capitalLetter"
            id="father_number"
            pattern="^[0-9\+]+$"
            title="+0-9"
            name="father_number"
            placeholder="Eg. +91**********"
            value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['father_number']; ?>"
            maxlength="20">
      </div>
      <div class="col-xs-12 col-sm-3 col-md-4">
         <label>Email Id<span class="text-red">*</span></label>
         <input type="email"
            name="father_email"
            class="form-control"
            placeholder="Email"
            id="father_email"
            value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['father_email']; ?>">
      </div>
      <div class="formrow">
         <div class="col-xs-12 col-sm-3 col-md-4">
            <label for="comment">Mother Name <span class="text-red">*</span></label>
            <div class="form-group">
               <input class="form-control capitalLetter"
                  readonly="true"
                  id="mother_name"
                  pattern="^[a-zA-Z ]+$"
                  title="A-Z a-z ' '"
                  placeholder="Enter Name"
                  value="<?php if (!empty($registerData)) echo strtoupper($registerData[0]['mother_fname'] . ' ' . $registerData[0]['mother_mname'] . ' ' . $registerData[0]['mother_lname']); ?>">
            </div>
         </div>
         <div class="col-xs-12 col-sm-3 col-md-4">
            <label> Phone Number <span class="text-red">*</span></label>
            <input type="text"
               class="form-control capitalLetter"
               id="mother_number"
               pattern="^[0-9\+]+$"
               title="+0-9"
               name="mother_number"
               placeholder="Eg. +91**********"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['mother_number']; ?>"
               maxlength="20">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-4">
            <label>Email Id<span class="text-red">*</span></label>
            <input type="email"
               name="mother_email"
               class="form-control"
               placeholder="Email"
               id="mother_email"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['mother_email']; ?>">
         </div>
      </div>
      <div class="formrow">
         <div class="col-xs-12 col-sm-12 col-md-12">
            <label for="comment">Address <span class="text-red">*</span></label>
            <textarea class="form-control capitalLetter"
               rows="3"
               id="guardian_address"
               name="guardian_address"
               placeholder="Postal Address"
               required="true"><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_address']; ?></textarea>
         </div>
      </div>
      <div class="formrow">
         <div class="col-xs-12 col-sm-3 col-md-3 pdleft">
            <input name="gardiuan_address_city"
               pattern="^[a-zA-Z ]+$"
               title="[A-Z,a-z]"
               onkeypress="return (event.charCode > 64 && 
               event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
               type="text"
               class="form-control capitalLetter"
               placeholder="City"
               id="gardiuan_address_city"
               required="true"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_city']; ?>">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <input name="gardiuan_address_state"
               pattern="^[a-zA-Z ]+$"
               title="[A-Z,a-z]"
               onkeypress="return (event.charCode > 64 && 
               event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
               type="text"
               class="form-control capitalLetter"
               placeholder="State"
               id="gardiuan_address_state"
               required="true"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_state']; ?>">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <select id="gardiuan_address_country"
               name="gardiuan_address_country"
               class="selectpicker form-control"
               required="true">
               <option value="">---- Country ---</option>
               <?php
                  $countries = $this->common_model->getCountries();
                  foreach ($countries as $country) {
                      if (!empty($applicaitonStepOne)) {
                          if ($applicaitonStepOne[0]['gardiuan_address_country'] == $country['id']) {
                              echo '<option selected="selected" value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                          } else {
                              echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                          }
                      } else {
                          echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                      }
                  }
                  ?>
            </select>
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <input name="gardiuan_address_pincode"
               title="[0-9]"
               title="[0-9]"
               type="text"
               class="form-control"
               placeholder="Zipcode"
               id="gardiuan_address_pincode"
               required="true"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_pincode']; ?>">
         </div>
      </div>
      <!-- <div class="formrow">
         <div class="col-xs-12 col-sm-12 col-md-12 pdleft">
             <div class="forminner">
                 <label for="comment" title="Knowledge of English">16. English Proficiency<span class="text-red">*</span></label>
                 <?php
            $knowledge = '';
            if (count($applicaitonStepOne) > 0) {
                $knowledge = $applicaitonStepOne[0]['knowledge_english'];
            }
            if ($knowledge == 1) {
            ?>
                 <input checked="true"
                     class="is_knwldge"
                     type="radio"
                     value="1"
                     name="knowledge_english"
                     id="knowledge_english" />
                 Yes
                 <input type="radio"
                     class="is_knwldge"
                     value="2"
                     name="knowledge_english"
                     id="knowledge_english" />
                 No
                 <?php
            } elseif ($knowledge == 2) {
            ?>
                 <input type="radio"
                     class="is_knwldge"
                     value="1"
                     name="knowledge_english"
                     id="knowledge_english" />
                 Yes
                 <input checked="true"
                     class="is_knwldge"
                     type="radio"
                     value="2"
                     name="knowledge_english"
                     id="knowledge_english" />
                 No
                 <?php
            } else {
            ?>
                 <input type="radio"
                     class="is_knwldge"
                     value="1"
                     name="knowledge_english"
                     id="knowledge_english" />
                 Yes
                 <input type="radio"
                     class="is_knwldge"
                     value="2"
                     name="knowledge_english"
                     id="knowledge_english"
                     checked="true" />
                 No
                 <?php
            }
            ?>
             </div>
             <?php
            if ($knowledge == 1) {
            ?>
             <div class="col-xs-12 col-sm-4 col-md-4 knwledge_eng pdleft">
                 <label for="comment">Writing:</label>
                 <?php
            if ($applicaitonStepOne[0]['knowledge_english_written'] == 1) {
            ?>
                 <input type="radio"
                     checked="true"
                     value="1"
                     name="knowledge_english_written"
                     id="knowledge_english_written " />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Good
                 <?php
            } elseif ($applicaitonStepOne[0]['knowledge_english_written'] == 2) {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_written"
                     id="knowledge_english_written " />
                 Average
                 <input type="radio"
                     checked="true"
                     value="2"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Good
                 <?php
            } elseif ($applicaitonStepOne[0]['knowledge_english_written'] == 3) {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_written"
                     id="knowledge_english_written " />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Proficient
                 <input type="radio"
                     checked="true"
                     value="3"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Good
                 <?php
            } else {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_written"
                     id="knowledge_english_written " />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Good
                 <?php
            }
            ?>
             </div>
             <div class="col-xs-12 col-sm-4 col-md-4 knwledge_eng">
                 <label for="comment">Speaking:</label>
                 <?php
            if ($applicaitonStepOne[0]['knowledge_english_spoken'] == 1) {
            ?>
                 <input type="radio"
                     checked="true"
                     value="1"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken"
                     checked="true" />
                 Averages
                 <input type="radio"
                     value="2"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Good
                 <?php
            } elseif ($applicaitonStepOne[0]['knowledge_english_spoken'] == 2) {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken"
                     checked="true" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Good
                 <?php
            } elseif ($applicaitonStepOne[0]['knowledge_english_spoken'] == 3) {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken"
                     checked="true" />
                 Good
                 <?php
            } else {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Good
                 <?php
            }
            ?>
             </div>
             <div class="col-xs-12 col-sm-4 col-md-4 knwledge_eng">
                 <label for="comment">Reading:</label>
                 <?php
            if ($applicaitonStepOne[0]['knowledge_english_reading'] == 1) {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_reading"
                     id="knowledge_english_spoken"
                     checked="true" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_reading"
                     id="knowledge_english_spoken" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_reading"
                     id="knowledge_english_spoken" />
                 Good
                 <?php
            } elseif ($applicaitonStepOne[0]['knowledge_english_reading'] == 2) {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading"
                     checked="true" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Good
                 <?php
            } elseif ($applicaitonStepOne[0]['knowledge_english_reading'] == 3) {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading"
                     checked="true" />
                 Good
                 <?php
            } else {
            ?>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Good
                 <?php
            }
            ?>
             </div>
             <?php
            } else {
            ?>
             <div class="col-xs-12 col-sm-4 col-md-4 pdleft knwledge_eng fade">
                 <label for="comment">Writing:</label>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_written"
                     id="knowledge_english_written " />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_written"
                     id="knowledge_english_written" />
                 Good
             </div>
             <div class="col-xs-12 col-sm-4 col-md-4 pdright knwledge_eng fade">
                 <label for="comment">Speaking:</label>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_spoken"
                     id="knowledge_english_spoken" />
                 Good
             </div>
             <div class="col-xs-12 col-sm-4 col-md-4 pdright knwledge_eng fade">
                 <label for="comment">Reading:</label>
                 <input type="radio"
                     value="1"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Average
                 <input type="radio"
                     value="2"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Proficient
                 <input type="radio"
                     value="3"
                     name="knowledge_english_reading"
                     id="knowledge_english_reading" />
                 Good
             </div>
             <?php
            }
            ?>
         </div>
         </div> -->
      <div class="formrow">
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
            <div class="forminner">
               <?php
                  $is_english_as_subject = '';
                  $english_level = '';
                  $english_score = '';
                  if (count($applicaitonStepOne) > 0) {
                      $is_english_as_subject = $applicaitonStepOne[0]['is_english_as_subject'];
                      $english_level = $applicaitonStepOne[0]['english_level'];
                      $english_score = $applicaitonStepOne[0]['english_score'];
                  } ?>
               <label for="comment"
                  title="">16. English Proficiency - I <span class="text-red">*</span></label>
               <label for="comment"
                  title=""><small>English as a Subject in School/College</small></label>
               <select name="is_english_as_subject"
                  class="form-control capitalLetter"
                  onChange="showEnglishlevel(this.value)">
                  <option value="">Select</option>
                  <option value="1"
                     <?php if ($is_english_as_subject == 1) {
                        echo 'selected';
                        } ?>>Yes</option>
                  <option value="2"
                     <?php if ($is_english_as_subject == 2) {
                        echo 'selected';
                        } ?>>No</option>
               </select>
            </div>
         </div>
      </div>
      <div class="formrow"
         id="englishLevel"
         <?php if ($is_english_as_subject == 1) { ?>
         style="display:block"
         <?php } else { ?>
         style="display:none"
         <?php } ?>
         ?>
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
            <label title="Till What Level"
               for="comment">Till what Level<span class="text-red"></span></label>
            <select name="english_level"
               id="english_level"
               class="form-control">
               <option value=" ">Select</option>
               <?php for($i=1; $i<=19; $i++){ ?>
               <option value="<?=$i; ?>" <?php if ($english_level == $i) {
                        echo 'selected';
                        } ?>><?=$i; ?></option>
               <?php } ?>
            </select>
         </div>
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
            <label title="Grade/Score/Percentage"
               for="comment">Score/Percentage (%)<span class="text-red"></span></label>
            <input type="number"
               class="form-control"
               placeholder="Score"
               value="<?php echo $english_score; ?>"
               id="english_score"
               name="english_score" />
         </div>
      </div>
      <div class="formrow">
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
            <label for="comment"
               title="">17. English Proficiency - II <span class="text-red">*</span></label>
         </div>
      </div>
      <div class="formrow">
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
            <div class="forminner">
               <label for="comment"
                  title="">Appeared in TOEFL</label>
               <?php
                  $english_proficiency = '';
                  if (count($applicaitonStepOne) > 0) {
                      $english_proficiency = $applicaitonStepOne[0]['is_toefl'];
                  } ?>
               <select name="is_toefl"
                  id="is_toefl"
                  class="form-control capitalLetter"
                  onChange="showEnglishlevel2(this.value)">
                  <option value="">Select</option>
                  <option <?php if ($english_proficiency == 1) {
                     echo "selected";
                     } ?>
                     value="1">Yes</option>
                  <option <?php if ($english_proficiency == 2) {
                     echo "selected";
                     } ?>
                     value="2">No</option>
               </select>
            </div>
         </div>
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
            <div class="forminner">
               <label for="comment"
                  title="">Appeared in IELTS</label>
               <?php
                  $english_proficiency = '';
                  if (count($applicaitonStepOne) > 0) {
                      $english_proficiency = $applicaitonStepOne[0]['is_ielts'];
                  } ?>
               <select name="is_ielts"
                  id="is_ielts"
                  class="form-control capitalLetter"
                  onChange="showEnglishlevel3(this.value)">
                  <option value="">Select</option>
                  <option <?php if ($english_proficiency == 1) {
                     echo "selected";
                     } ?>
                     value="1">Yes</option>
                  <option <?php if ($english_proficiency == 2) {
                     echo "selected";
                     } ?>
                     value="2">No</option>
               </select>
            </div>
         </div>
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft">
            <div class="forminner">
               <label for="comment"
                  title="">Appeared in DUOLINGO</label>
               <?php
                  $english_proficiency = '';
                  if (count($applicaitonStepOne) > 0) {
                      $english_proficiency = $applicaitonStepOne[0]['is_duolingo'];
                  } ?>
               <select name="is_duolingo"
                  id="is_duolingo"
                  class="form-control capitalLetter"
                  onChange="showEnglishlevel4(this.value)">
                  <option value="">Select</option>
                  <option <?php if ($english_proficiency == 1) {
                     echo "selected";
                     } ?>
                     value="1">Yes</option>
                  <option <?php if ($english_proficiency == 2) {
                     echo "selected";
                     } ?>
                     value="2">No</option>
               </select>
            </div>
         </div>
      </div>
      <?php
         if (count($applicaitonStepOne) > 0) {
             $english_proficiency = $applicaitonStepOne[0]['is_english_proficiency'];
         }
         if ($english_proficiency == 1) {
         ?>
      <div class="formrow">
         <div class="eng_score col-xs-12 col-sm-4 col-md-4 pdleft toefl_score_marks">
            <label title="Enter TOEFL Score"
               for="comment">TOEFL Score <span class="text-red"></span></label>
            <input type="text"
               class="form-control capitalLetter"
               placeholder="TOEFL"
               id="toefl_score"
               name="toefl_score"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['toefl_score']; ?>" />
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 pdleft toefl_score_marks mt-1">
               <label title="Enter TOFEL Score" for="comment">Supporting Documents<span class="text-red"></span></label>
               <input type="file" class="form-control capitalLetter" placeholder="TOEFL" id="toefl_score_file" name="toefl_score_file"/>
               </div> -->
         </div>
      </div>
      <div class="formrow">
         <div class="eng_score3 col-xs-12 col-sm-4 col-md-4 ielts_score_marks">
            <label title="Enter IELTS Score"
               for="comment">IELTS Score<span class="text-red"></span></label>
            <input type="text"
               class="form-control capitalLetter"
               placeholder="IELTS"
               id="ielts_score"
               name="ielts_score"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['ielts_score']; ?>" />
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 pdleft toefl_score_marks mt-1">
               <label title="Enter TOFEL Score" for="comment">Supporting Documents<span class="text-red"></span></label>
               <input type="file" class="form-control capitalLetter" placeholder="TOEFL" id="ielts_score_file" name="ielts_score_file"/>
               </div> -->
         </div>
      </div>
      <div class="formrow">
         <div class="eng_score4 col-xs-12 col-sm-4 col-md-4 duolingo_score_marks">
            <label title="Enter DUOLINGO Score"
               for="comment">DUOLINGO Score<span class="text-red"></span></label>
            <input type="text"
               class="form-control capitalLetter"
               placeholder="DUOLINGO"
               id="duolingo_score"
               name="duolingo_score"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['duolingo_score']; ?>" />
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 pdleft toefl_score_marks mt-1">
               <label title="Enter TOFEL Score" for="comment">Supporting Documents<span class="text-red"></span></label>
               <input type="file" class="form-control capitalLetter" placeholder="TOEFL" id="duolingo_score_file" name="duolingo_score_file"/>
               </div> -->
         </div>
      </div>
      <?php
         } else {
         ?>
      <div class="formrow">
         <?php $english_proficiency = '';
            if (count($applicaitonStepOne) > 0) {
                $english_proficiency = $applicaitonStepOne[0]['is_toefl'];
            } ?>
         <div style="<?php if ($english_proficiency == 1) { ?> display:block <?php }else { ?> display:none <?php } ?>"
            class="eng_score col-xs-12 col-sm-4 col-md-4 pdleft toefl_score_marks">
            <label title="Enter TOEFL Score"
               for="comment">TOEFL Score <span class="text-red"></span></label>
            <input type="text"
               class="form-control capitalLetter"
               placeholder="TOEFL"
               id="toefl_score"
               name="toefl_score"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['toefl_score']; ?>" />
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 pdleft toefl_score_marks mt-1">
               <label title="Enter TOFEL Score" for="comment">Supporting Documents<span class="text-red"></span></label>
               <input type="file" class="form-control capitalLetter" placeholder="TOEFL" id="toefl_score_file" name="toefl_score_file"/>
               </div> -->
         </div>
         <?php
            $english_proficiency = '';
            if (count($applicaitonStepOne) > 0) {
                $english_proficiency = $applicaitonStepOne[0]['is_ielts'];
            } ?>
         <div style="<?php if ($english_proficiency == 1) { ?> display:block <?php }else { ?> display:none <?php } ?>"
            class="eng_score3 col-xs-12 col-sm-4 col-md-4 ielts_score_marks">
            <label title="Enter IELTS Score"
               for="comment">IELTS Score<span class="text-red"></span></label>
            <input type="text"
               class="form-control capitalLetter"
               placeholder="IELTS"
               id="ielts_score"
               name="ielts_score"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['ielts_score']; ?>" />
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 pdleft toefl_score_marks mt-1">
               <label title="Enter TOFEL Score" for="comment">Supporting Documents<span class="text-red"></span></label>
               <input type="file" class="form-control capitalLetter" placeholder="TOEFL" id="ielts_score_file" name="ielts_score_file"/>
               </div> -->
         </div>
         <?php
            $english_proficiency = '';
            if (count($applicaitonStepOne) > 0) {
                $english_proficiency = $applicaitonStepOne[0]['is_duolingo'];
            } ?>
         <div style="<?php if ($english_proficiency == 1) { ?> display:block <?php }else { ?> display:none <?php } ?>"
            class="eng_score4 col-xs-12 col-sm-4 col-md-4 duolingo_score_marks">
            <label title="Enter DUOLINGO Score"
               for="comment">DUOLINGO Score<span class="text-red"></span></label>
            <input type="text"
               class="form-control capitalLetter"
               placeholder="DUOLINGO"
               id="duolingo_score"
               name="duolingo_score"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['duolingo_score']; ?>" />
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 pdleft toefl_score_marks mt-1">
               <label title="Enter TOFEL Score" for="comment">Supporting Documents<span class="text-red"></span></label>
               <input type="file" class="form-control capitalLetter" placeholder="TOEFL" id="duolingo_score_file" name="duolingo_score_file"/>
               </div> -->
         </div>
      </div>
      <?php
         }
         ?>
      <div class="addres-sec col-xs-12 col-sm-12 col-md-12">
         <div class="name-sec">
            <label for="comment">18. Write an essay in English on any one of the following
            prompts. It should be original and written by students themselves without any
            help or assistance from anybody else. If plagiarism is noted, the application
            will be rejected. The word limit of not more than 500 words should be strictly
            observed. It must be noted that the essay has to be only on one topic else the
            application will not be considered.The essay can be written offline and pasted
            in the space below.<span class="text-red">*</span></label>
            </br>
            <p>1. Some students have a background, identity, interest, or talent so meaningful
               they believe their application would be incomplete without it. If this sounds
               like you, please share your story.</br></br>
               2. The lessons we take from obstacles we encounter can be fundamental to later
               success. Recount a time when you faced a challenge, setback, or failure. How did
               it affect you, and what did you learn from the experience?</br></br>
               3. Reflect on a time when you questioned or challenged a belief or idea. What
               prompted your thinking? What was the outcome?</br></br>
               4. Describe a problem you’ve solved or a problem you’d like to solve. It can be
               an intellectual challenge, a research query, an ethical dilemma — anything of
               personal importance, no matter the scale. Explain its significance to you and
               what steps you took or could be taken to identify a solution.</br></br>
               5. Discuss an accomplishment, event, or realization that sparked a period of
               personal growth and a new understanding of yourself or others.</br></br>
               6. Describe a topic, idea, or concept you find so engaging it makes you lose all
               track of time. Why does it captivate you? What or who do you turn to when you
               want to learn something?</br></br>
            <div class="form-group">
               <textarea rows="10"
                  cols="100"
                  class="form-control"
                  placeholder="Write an essay in English"
                  id="english_test_essay"
                  name="english_test_essay"
                  required><?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['english_test_essay']; ?></textarea>
            </div>
            <div class="col-sm-6"><span id="charlimit"><strong class="words-left">500 words
               left</strong></span>
            </div>
            </br /></br>
            <small id="passwordHelpBlock"
               class="form-text text-muted">
            </small>
         </div>
      </div>
				
					
				<div class="formrow">
            <?php
                $acedemic_year = '';
                if (count($applicaitonStepOne) > 0) {
                    $acedemic_year = $applicaitonStepOne[0]['acedemic_year'];
                } ?>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <label for="comment"
                  title="Academic Year">19. Admitted Academic Year<span
                  class="text-red">*</span></label>
                <select name="acedemic_year"
                  class="form-control">
                  <!-- <option>Select Year</option> -->
                  <option <?php if ($acedemic_year == '2025-26') {
                      echo "selected";
                      } ?>>2025-26</option>
                </select>
            </div>
				
            <div class="col-xs-12 col-sm-3 col-md-3">
              <label for="comment" title="Course applied">20. Level of Course <span class="text-red">*</span></label>
                  <?php
                    $user_data = $this->session->userdata('user_data');
                    $student_type = $user_data['student_type'];
                    $student_course_type = $user_data['apply_course_type'];
                    $prgid = $user_data['apply_course_type'];
                  ?>
                  <select name="programme" class="form-control capitalLetter" onChange="courseDuration(this.value)" id="<?php 
                      if($student_type == 1 && $student_course_type == 10) { echo 'programmeayush'; };?>" required="true" >

                    <option selected="selected" value="">Select Programme</option>
                      <?php
                      if ( $student_type == 1 && $student_course_type == 1 || $student_type == 1 && $student_course_type == 4 || $student_type == 1 && $student_course_type == 2) {
                          $programme = $this->common_model->getAllProgrammeWithoutAyush( $prgid );
                      } elseif($student_type == 1 && $student_course_type == 10) {
                         
                          $programme = $this->common_model->getAllAyushProgramme();
                      } else {
                          $programme = $this->common_model->getAllPhdProgramme();
                      }
                      
                      $res = array( 8 => $programme[ 7 ] );
                      $ress = array_merge( array_slice( $programme, 0, 4 ), $res, array_slice( $programme, 4 ) );
                      unset( $ress[ 8 ] );
                      foreach ( $ress as $program ) {
                        if ( !empty( $applicaitonStepOne ) ) {
                        if ( $applicaitonStepOne[ 0 ][ 'programme' ] == $program[ 'id' ] ) {
                          echo '<option  value="' . $program[ 'id' ] . '">' . $program[ 'name' ] . '</option>';
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


						<div class="col-xs-12 col-sm-4 col-md-4 course_type pdright">
						<?php
							if(count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[ 0 ]['programme'] == 4 || $applicaitonStepOne[0][ 'programme' ] == 9 || $applicaitonStepOne[0][ 'programme' ] == 8) {
							$user_data = $this->session->userdata( 'user_data' );
							$student_type = $user_data[ 'student_type' ];
							$student_course_type = $user_data[ 'apply_course_type' ];
							//echo "<pre>";print_r($student_type);die;
							$prgid = $user_data[ 'apply_course_type' ];
							
						?>
						<div class="course_type pdleft" required="true" >
							<label for="comment" title ="Course Types choice">21. Course Type</label>
							<select id="course_type" name="course_type" class="form-control" required="true">
								<option selected="selected" value="">Select Course Type</option>
								<?php
								  //$courseType = $this->common_model->getAllAyushCourseType();
								if($student_type == 1 && $student_course_type == 5) {
								  $courseType = $this->common_model->getAllCourseTypeWithoutAyush( $prgid );
								  //echo "<pre>";print_r($courseType);
								}
								elseif($student_type == 1 && $student_course_type == 6) {
								  $courseType = $this->common_model->getAllCourseTypeWithoutAyush( $prgid );
								  //echo "<pre>";print_r($courseType);
								}
								elseif($student_type == 1 && $student_course_type == 4) {
								  $courseType = $this->common_model->getAllCourseTypeWithoutAyush( $prgid );
								  //echo "<pre>";print_r($courseType);
								}
								elseif($student_type == 1 && $student_course_type == 9) {
								  $courseType = $this->common_model->getAllCourseTypeWithoutAyush( $prgid );
								  //echo "<pre>";print_r($courseType);
								}
								elseif($student_type == 1 && $student_course_type == 1) {
								  //$programme = $this->common_model->getAllProgrammeWithoutAyush($prgid);
								  $courseType = $this->common_model->getCourseTypes();
								}
								elseif($student_type == 1 && $student_course_type == 2) {
								  //$programme = $this->common_model->getAllProgrammeWithoutAyush($prgid);
								  $courseType = $this->common_model->getCourseTypes();
								}
								
								elseif($student_type == 1 && $student_course_type == 10)
								{
									$courseType = $this->common_model->getAllAyushCourseType();
								}
								else {
								  $courseType = $this->common_model->getCourseTypes();
								}
							
								//$courseType = $this->common_model->getAllPhdCourseType($applicaitonStepOne[0]['programme']);

								foreach ($courseType as $ctype){
								  if(!empty( $applicaitonStepOne)) {
									if ( $applicaitonStepOne[0]['course_type'] == $ctype['id']) {
									  echo '<option  value="'.$ctype['id'].'">' . $ctype[ 'course_type' ] . '</option>';
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
							<label for="comment">21. Course Type<span class="text-red">*</span></label>
							<?php
							  $user_data = $this->session->userdata('user_data');
							  $student_type = $user_data['student_type'];
							  
							  $student_course_type = $user_data['apply_course_type'];
							?>								
							<select id="<?php 
							if($student_type == 1 && $student_course_type == 1 || $student_type == 1 && $student_course_type == 4 ||$student_type == 1 && $student_course_type == 9 || $student_type == 1 && $student_course_type == 2 || $student_type == 1 && $student_course_type == 3 || $student_type == 1 && $student_course_type == 6 || $student_type == 1 && $student_course_type == 5 || $student_type == 1 && $student_course_type == 9)
							{ echo 'course_type';}else{echo 'course_types';};?>" name="course_type" class="form-control" required="true">
						
								<option value="">Select Course Type</option>
								<?php
								  //$courseType = $this->common_model->getAllAyushCourseType();
								if($student_type == 1 && $student_course_type == 4 || $student_type == 1 && $student_course_type == 1 || $student_type == 1 && $student_course_type == 2 || $student_type == 1 && $student_course_type == 3 || $student_type == 1 && $student_course_type == 9) {
								  $courseType = $this->common_model->getAllCourseTypeWithoutAyush();
								  //echo "<pre>";print_r($courseType);
								}
								elseif($student_type == 1 && $student_course_type == 10)
								{
									$courseType = $this->common_model->getAllAyushCourseType();
								}
								else{
								  $courseType = $this->common_model->getCourseTypes();
								}
								//$courseType = $this->common_model->getAllPhdCourseType($applicaitonStepOne[0]['programme']);
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
					<!-----<div class="col-xs-12 col-sm-4 col-md-4 pdright gmat_sc" style="display:none;">
							<div class="forminner">
							<label for="comment" title="GMAT Sore">GMAT SCORE<span class="text-red">*</span></label>
							<input type="radio" class="is_gmat" value="1" name="is_gmat" id="gmats" checked="true" > Yes
							<input type="radio" class="is_gmat" value="2" name="is_gmat" id="gmats" > No
							</div>
							
							
					</div>--->
					
					
					</div>
					
					<div class="formrow">
						  <?php
						  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4) {
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
					<div class="formrow">
						<label for="comment" title = "University">22. Universities/Institutes in India where you wish to seek admission:<span class="text-red">*</span></label>
						<span class="note1"><strong>Note : </strong>ICCR provides scholarships only for courses in Central or State Goverment Universities. Candidates should be very specific and clear about the course of study which he/she wishes to pursue in India. Scholarships are not available to pursue more than one course. Candidates should ensure that the courses opted are offered by the Universities selected under the dropdown menu given below. The candidates must refer to the University/Institute website to know the availability of course in that University and eligibility criteria for the courses of their choice. Those seeking admission to agricultural courses must opt for <b>ICAR</b> in the University choice.</span>
						<!-----<span>Please give your preference with highest preference on the top and lowest on the bottom.</span>--->
						<span>Please select Univesrity in order of preference.</span>
					</div>

          <div class="formrow text">
            <span><strong><small>Note: In case of University/Course listing not showing, Press Ctrl + Shift +R.</small></strong></span> 
          </div>

          <div class="formrow text-red">
            <span><strong>Note: </strong>List of Subjects offered by AYUSH Universities/ Institutes under AYUSH Scholarship Scheme</span> 
            <a href="<?php echo site_url(); ?>assets/site/docs/Ayush_Universities_Courses.pdf" target="_blank"><img src="<?php echo site_url(); ?>assets/site/main/images/pdficon.png" alt="Course File"></a>
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
  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7) {
    if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment" title = "Course choice 1">Course you wish to study 1<span class="text-red">*</span></label>
    <select id="course" name="course" onchange="getCourseData(this.value);" class="form-control course" required="true">
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
    <label for="comment">Course you wish to study 1<span class="text-red">*</span></label>
    <select id="course" name="course" onchange="getCourseData(this.value);" class="form-control course" required="true">
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
    <label for="comment">Course you wish to study 1<span class="text-red">*</span></label>
    <select id="course" name="course" onchange="getCourseData(this.value);" class="form-control course" required="true">
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
    <label for="comment">Course you wish to study 1<span class="text-red">*</span></label>
    <select id="course" name="course" onchange="getCourseData(this.value);" class="form-control" required="true">
		<option value="">Select Course</option>
	</select>
  </div>
  <?php
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment">Course you wish to study 1 <span class="text-red">*</span></label>
    <select id="course" name="course" onchange="getCourseData(this.value);" class="form-control course" required="true">
		<option value="">Select Course</option>
	</select>
  </div>
  <?php
  }
  ?>
  <?php
  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7) {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdright unidiv">
    <label for="comment">University 1 <span class="text-red">*</span></label>
    <select id="universty_choice" name="universty_choice" required="true" class="form-control" onchange="selectUniversityChoice(this.value)">
        <option value="">Select</option>
        <?php
        if ( count( $applicaitonStepOne ) > 0 ) {
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
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
  } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 5 || $applicaitonStepOne[ 0 ][ 'programme' ] == 6 || $applicaitonStepOne[ 0 ][ 'programme' ] == 9 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
    <label for="comment" title = "University Choice 1">University 1<span class="text-red">*</span></label>
    <select id="universty_choice" name="universty_choice"  class="form-control universty_choice_cl" onchange="selectAyushUniversityChoice(this.value)" required="true">        
        <option value="">Select</option>
        <?php

        if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 ) {
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
			   $stateuniversities = $this->common_model->getAyushUniversitiesWithMapping($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['course']);
			  		$states =  $this->common_model->getAllStates();
									$statewiseUniversites = array();
									//echo "<pre>";print_r($statewiseUniversites);die;
									foreach($states as $st)
									{
										if(!array_key_exists($st['id'],$statewiseUniversites))
										{
											$statewiseUniversites[$st['id']] = array();
											
										}
									}
			  if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
											{											
												if(array_key_exists($univercity['state_id'],$statewiseUniversites))
												{													
													array_push($statewiseUniversites[$univercity['state_id']],$univercity);
												}
											}	 
											
											foreach($statewiseUniversites as $key=>$univercity)
											{
												if(count($univercity)>0)
												{
													$statenames = $this->common_model->getStateById($key);
													
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'" class="stt">';
													foreach($univercity as $uni_choice)
													{
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'" disabled>'.$uni_choice['uni'].'</option>';
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
											echo '<option>------Select---------</option>';
										    echo '</optgroup>';	
									}
			  		 elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 2 ) {
				

              foreach ( $icaruni as $un ) {
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
    <label for="comment">University 1 <span class="text-red">*</span></label>
    <?php
      $user_data = $this->session->userdata('user_data');
      $student_type = $user_data['student_type'];
      $student_course_type = $user_data['apply_course_type'];

      if($student_type == 1 && $student_course_type == 10) {
        ?>
      <select id="universty_choice" name="universty_choice"  class="form-control universty_choice_cl" required="true" onchange="selectAyushUniversityChoice(this.value)">
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
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name" id="option_name">
								<label for="comment">Subject 1 <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
									<select name="course_option_name" id="course_option_name" class="form-control" required="true">
										<option value="<?php echo $applicaitonStepOne[0]['course_option_name']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name']; ?></option>
									</select>
								</div>
							</div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name" id="option_name">
								<label for="comment">Subject 1 <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
									<select name="course_option_name" id="course_option_name" class="form-control" required="true">
										<option value="<?php echo $applicaitonStepOne[0]['course_option_name']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name']; ?></option>
									</select>
								</div>
							</div>
							<?php	
							}
  } else {
    ?>
  <div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name" id="option_name">
		<label for="comment">Subject 1 <span class="text-red">*</span></label>
		<div class="form-group col-md-10 pdleft">
			<select name="course_option_name" id="course_option_name" class="form-control" required="true">
				<option value="<?php echo $applicaitonStepOne[0]['course_option_name']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name']; ?></option>
			</select>
		</div>
	</div>
  <?php
  }
  } else {
    ?>
  <div class="name-sec col-xs-12 col-sm-3 col-md-4  course_option_name" id="option_name">
		<label for="comment">Subject 1 <span class="text-red">*</span></label>
		<div class="form-group col-md-10 pdleft">
			<select name="course_option_name" id="course_option_name" class="form-control" required="true">
				<option value="<?php echo $applicaitonStepOne[0]['course_option_name']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name']; ?></option>
			</select>
		</div>
	</div>
  <?php
  }
  ?>
</div>
<?php
if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7 && $applicaitonStepOne[ 0 ][ 'programme' ] != 8 ) {
  ?>
<div class="formrow dateof-birth unidiv2">
<?php
} elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
    ?>
<div class="formrow dateof-birth unidiv2">
<?php
} elseif ( count( $applicaitonStepOne ) <= 0 ) {
    ?>
<div class="formrow dateof-birth unidiv2">
  <?php
  }

  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7) {
    if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 ||  $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment" title = "Course choice 2">Course you wish to study 2<span class="text-red">*</span></label>
    <select id="course_two" name="course_two" onchange="getCourseData2(this.value);" class="form-control course_two" required="true">
        <option value="">Select Course</option>
        <?php
        $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

        foreach ( $courses as $course ) {
          if ( !empty( $applicaitonStepOne ) ) {
            if ( $applicaitonStepOne[ 0 ][ 'course_two' ] == $course[ 'id' ] ) {
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
  <div class="col-xs-12 col-sm-4 col-md-4 course_wish_study">
    <label for="comment">Course you wish to study <span class="text-red"></span></label>
	<select id="course_two" name="course_two" onchange="getCourseData2(this.value);" class="form-control" >
        <option value="">Select Course</option>
        <?php
        $courses = $this->common_model->getCourseByPrgramme( $applicaitonStepOne[ 0 ][ 'programme' ] );

        foreach ( $courses as $course ) {
          if ( !empty( $applicaitonStepOne ) ) {
            if ( $applicaitonStepOne[ 0 ][ 'course_two' ] == $course[ 'id' ] ) {
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
  <div class="col-xs-12 col-sm-4 col-md-4 course_wish_study">
    <label for="comment">Course you wish to study <span class="text-red"></span></label>
    <select id="course_two" name="course_two" onchange="getCourseData2(this.value);" class="form-control" >
        <option value="">Select Course</option>
        <?php
        $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

        foreach ( $courses as $course ) {
          if ( !empty( $applicaitonStepOne ) ) {
            if ( $applicaitonStepOne[ 0 ][ 'course_two' ] == $course[ 'id' ] ) {
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
    <label for="comment">Course you wish to study <span class="text-red"></span></label>
    <select id="course_two" name="course_two" onchange="getCourseData2(this.value);" class="form-control">
        <option value="">Select Course</option>
      </select>
  </div>
  <?php
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment" title = "Course choice 3">Course you wish to study 2 <span class="text-red">*</span></label>
    <select id="course_two" name="course_two" onchange="getCourseData2(this.value);" class="form-control course_two" required="true">
        <option value="">Select Course</option>
      </select>
  </div>
  <?php
  }
  ?>
  <?php
  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7) {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
    <label for="comment">University 2 <span class="text-red">*</span></label>
    <select id="universty_choice_two" name="universty_choice_two"  class="form-control" onchange="selectAyushUniversityChoice_third(this.value)" required="true">
        <option value="">Select</option>
        <?php
        if ( count( $applicaitonStepOne ) > 0 ) {
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $uni_choice[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $univercity_cnet[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $univercity_nit[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $univercity_yogs[ 'id' ] ) {
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
  } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 5 || $applicaitonStepOne[ 0 ][ 'programme' ] == 6 || $applicaitonStepOne[ 0 ][ 'programme' ] == 9 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
    <label for="comment" title = "University choice 2">University 2 <span class="text-red">*</span></label>
    <select id="universty_choice_two" name="universty_choice_two"  class="form-control" onchange="selectAyushUniversityChoice_third(this.value)" required="true">
        <option value="">Select</option>
        <?php
        if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 ) {
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
			  $stateuniversities = $this->common_model->getAyushUniversitiesWithMapping($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['course_two']);
									$states =  $this->common_model->getAllStates();
									$statewiseUniversites = array();
									//echo "<pre>";print_r($statewiseUniversites);die;
									foreach($states as $st)
									{
										if(!array_key_exists($st['id'],$statewiseUniversites))
										{
											$statewiseUniversites[$st['id']] = array();
											
										}
									}
			  if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
											{											
												if(array_key_exists($univercity['state_id'],$statewiseUniversites))
												{													
													array_push($statewiseUniversites[$univercity['state_id']],$univercity);
												}
											}	 
											
											foreach($statewiseUniversites as $key=>$univercity)
											{
												if(count($univercity)>0)
												{
													$statenames = $this->common_model->getStateById($key);
													
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'" class="stt">';
													foreach($univercity as $uni_choice)
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
											echo '<option>------Select---------</option>';
										    echo '</optgroup>';	
									}
            elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 2 ) {
              foreach ( $icaruni as $un ) {
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
                      if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $uni_choice[ 'id' ] ) {
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
                  if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $univercity_cnet[ 'id' ] ) {
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
            elseif ($applicaitonStepOne[0]['course_type'] == 5) {
              echo '<optgroup label="State Universities">';
              foreach ( $stateuniversities as $univercity ) {
                if ( array_key_exists( $univercity[ 'state_id' ], $statewiseUniversites ) ) {
                  array_push( $statewiseUniversites[ $univercity[ 'state_id' ] ], $univercity );
                }
              }
              foreach ( $statewiseUniversites as $key => $univercity1 ) {
                if ( count( $univercity1 ) > 0 ) {
                  $statenames = $this->common_model->getStateById( $key );
                  //echo "<pre>";print_r($statenames);die;
                  echo '<optgroup label="&nbsp;&nbsp;&nbsp;' . $statenames[0][ 'name' ] . '" class="stt">';
                  foreach ( $univercity1 as $uni_choice ) {
                    if ( !empty( $applicaitonStepOne ) ) {
                      if ( $applicaitonStepOne[ 0 ]['universty_choice_two'] == $uni_choice[ 'id' ] ) {
                        echo '<option selected="selected" value="' .$uni_choice[ 'id' ]. '">' . $uni_choice['uni'] . '</option>';
                      } else {
                        echo '<option value="' . $uni_choice['id'] . '">' . $uni_choice['uni'] . '</option>';
                      }
                    } else {
                      echo '<option value="' . $uni_choice['id'] . '">' . $uni_choice['uni'] . '</option>';
                    }
                  }
                  echo '</optgroup>';
                }
              }
			  
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
			  
              echo '</optgroup>';
              echo '<optgroup label="National Institute of Technology (NIT)">';
              foreach ( $nits as $univercity_nit ) {
                if ( !empty( $applicaitonStepOne ) ) {
                  if ( $applicaitonStepOne[0]['universty_choice_two'] == $univercity_nit['id'] ) {
                    echo '<option selected="selected" value="' . $univercity_nit[ 'id' ] . '">' . $univercity_nit['uni'] . '</option>';
                  } else {
                    echo '<option value="' . $univercity_nit['id'] . '">' . $univercity_nit['uni'] . '</option>';
                  }
                } else {
                  echo '<option value="' . $univercity_nit['id'] . '">' . $univercity_nit['uni'] . '</option>';
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $uni_choice[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $univercity_cnet[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $univercity_nit[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_two' ] == $univercity_yogs[ 'id' ] ) {
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
    <label for="comment">University 2 <span class="text-red">*</span></label>
    <?php
      $user_data = $this->session->userdata( 'user_data' );
      $student_type = $user_data[ 'student_type' ];
      $student_course_type = $user_data[ 'apply_course_type' ];
      if ( $student_type == 1 && $student_course_type == 10) {
        ?>
      <select id="universty_choice_two" name="universty_choice_two"  class="form-control universty_choice_cl" required="true" onchange="selectAyushUniversityChoice_third(this.value)">
        <?php
        } else {
          ?>
        <select id="universty_choice_two" name="universty_choice_two"  class="form-control universty_choice_cl"  required="true" onchange="selectUniversityChoice_third(this.value)">
        <?php
        }
        ?>
        <option value="">Select</option>
      </select>
  </div>
  <?php
  }
  ?>
  <?php
  if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 ) {
    $crs = $this->common_model->getCoursesById( $applicaitonStepOne[ 0 ][ 'course' ] );
    if ( $applicaitonStepOne[ 0 ][ 'course' ] > 0 && $crs[ 0 ][ 'has_stream' ] > 0 ) {
     
							$crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_two" id="option_name">
								<label for="comment">Subject 2 <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
									<select name="course_option_name_two" id="course_option_name_two" class="form-control" required="true">
										<option value="<?php echo $applicaitonStepOne[0]['course_option_name_two']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_two']; ?></option>
									</select>
								</div>
							</div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_two" id="option_name">
								<label for="comment">Subject 2 <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
									<select name="course_option_name_two" id="course_option_name_two" class="form-control" required="true">
										<option value="<?php echo $applicaitonStepOne[0]['course_option_name_two']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_two']; ?></option>
									</select>
								</div>
							</div>
							<?php	
							}
  
						} else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_option_name_two" id="option_name">
		<label for="comment">Subject 2 <span class="text-red">*</span></label>
		<select name="course_option_name_two" id="course_option_name_two" class="form-control" required="true">
			<option value="<?php echo $applicaitonStepOne[0]['course_option_name_two']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_two']; ?></option>
		</select>
	</div>
  <?php
  }
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdright course_option_name_two" id="option_name">
		<label for="comment">Subject 2 <span class="text-red">*</span></label>
		<select name="course_option_name_two" id="course_option_name_two" class="form-control" required="true">
			<option value="<?php echo $applicaitonStepOne[0]['course_option_name_two']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_two']; ?></option>
		</select>
	</div>
  <?php
  }
  ?>
</div>
<?php
if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7 && $applicaitonStepOne[ 0 ][ 'programme' ] != 8 ) {
  ?>
<div class="formrow dateof-birth unidiv3">
<?php
} elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
    ?>
<div class="formrow dateof-birth unidiv3">
<?php
} elseif ( count( $applicaitonStepOne ) <= 0 ) {
    ?>
<div class="formrow dateof-birth unidiv3">
<?php
} else {
  ?>
<div class="formrow dateof-birth unidiv3">
  <?php
  }

  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7) {
    if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment" title = "Course choice 3">Course you wish to study 3<span class="text-red">*</span></label>
    <select id="course_three" name="course_three" onchange="getCourseData3(this.value);" class="form-control course_three" required="true">
        <option value="">Select Course</option>
        <?php
        $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

        foreach ( $courses as $course ) {
          if ( !empty( $applicaitonStepOne ) ) {
            if ( $applicaitonStepOne[ 0 ][ 'course_three' ] == $course[ 'id' ] ) {
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
  <div class="col-xs-12 col-sm-4 col-md-4 course_wish_study">
    <label for="comment">course you wish to study <span class="text-red"></span></label>
    <select id="course_three" name="course_three" onchange="getCourseData3(this.value);" class="form-control" >
        <option value="">Select Course</option>
        <?php
        $courses = $this->common_model->getCourseByPrgramme( $applicaitonStepOne[ 0 ][ 'programme' ] );

        foreach ( $courses as $course ) {
          if ( !empty( $applicaitonStepOne ) ) {
            if ( $applicaitonStepOne[ 0 ][ 'course_three' ] == $course[ 'id' ] ) {
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
  <div class="col-xs-12 col-sm-4 col-md-4 course_wish_study">
    <label for="comment">course you wish to study <span class="text-red"></span></label>
    <select id="course_three" name="course_three" onchange="getCourseData3(this.value);" class="form-control" >
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
    <label for="comment">Course you wish to Study<span class="text-red"></span></label>
    <select id="course_three" name="course_three" onchange="getCourseData3(this.value);" class="form-control">
        <option value="">Select Course</option>
      </select>
  </div>
  <?php
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
    <label for="comment">Course you wish to study 3<span class="text-red">*</span></label>
    <select id="course_three" name="course_three" onchange="getCourseData3(this.value);" class="form-control course_three" required="true">
        <option value="">Select Course</option>
     </select>
  </div>
  <?php
  }
  ?>
  <?php
  if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7) {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
    <label for="comment">University 3 <span class="text-red"></span></label>
    <select id="universty_choice_three" name="universty_choice_three"  class="form-control"  onchange="selectAyushUniversity_thirdpop(this.value)">
        <option value="">Select</option>
        <?php
        if ( count( $applicaitonStepOne ) > 0 ) {
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $uni_choice[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_cnet[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_nit[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_yogs[ 'id' ] ) {
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
  } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 5 || $applicaitonStepOne[ 0 ][ 'programme' ] == 6 || $applicaitonStepOne[ 0 ][ 'programme' ] == 9 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
      ?>
  <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
    <label for="comment" title = "University choice 3">University 3 <span class="text-red">*</span></label>
    <select id="universty_choice_three" name="universty_choice_three"  onchange="selectAyushUniversity_thirdpop(this.value)" class="form-control" required="true" >
        <option value="">Select</option>
        <?php
        if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 ) {
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
			  $stateuniversities = $this->common_model->getAyushUniversitiesWithMapping($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['course_three']);
									$states =  $this->common_model->getAllStates();
									$statewiseUniversites = array();
									//echo "<pre>";print_r($statewiseUniversites);die;
									foreach($states as $st)
									{
										if(!array_key_exists($st['id'],$statewiseUniversites))
										{
											$statewiseUniversites[$st['id']] = array();
											
										}
									}
            if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
											{											
												if(array_key_exists($univercity['state_id'],$statewiseUniversites))
												{													
													array_push($statewiseUniversites[$univercity['state_id']],$univercity);
												}
											}	 
											
											foreach($statewiseUniversites as $key=>$univercity)
											{
												if(count($univercity)>0)
												{
													$statenames = $this->common_model->getStateById($key);
													
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'" class="stt">';
													foreach($univercity as $uni_choice)
													{
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice_three'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
															}
															else
															{														
																echo '<option value="'.$uni_choice['id'].'" disabled>'.$uni_choice['uni'].'</option>';
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
											echo '<option>------Select---------</option>';
										    echo '</optgroup>';	
									} elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 2 ) {
              foreach ( $icaruni as $un ) {
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
                      if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $uni_choice[ 'id' ] ) {
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
                  if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_cnet[ 'id' ] ) {
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
            elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 5 ) {
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
                      if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $uni_choice[ 'id' ] ) {
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
                  if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_cnet[ 'id' ] ) {
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
                  if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_nit[ 'id' ] ) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $uni_choice[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_cnet[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_nit[ 'id' ] ) {
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
                if ( $applicaitonStepOne[ 0 ][ 'universty_choice_three' ] == $univercity_yogs[ 'id' ] ) {
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
    <label for="comment">University 3 <span class="text-red">*</span></label>
    <?php
      $user_data = $this->session->userdata( 'user_data' );
      $student_type = $user_data[ 'student_type' ];
      $student_course_type = $user_data[ 'apply_course_type' ];
      if ( $student_type == 1 && $student_course_type == 10) {
        ?>
      <select id="universty_choice_three" name="universty_choice_three"  class="form-control universty_choice_cl" required="true" onchange="selectAyushUniversity_thirdpop(this.value)">
        <?php
        } else {
          ?>
        <select id="universty_choice_three" name="universty_choice_three"  class="form-control universty_choice_three"  required="true" onchange="selectUniversityChoice_fourth(this.value)">
        <?php

        }
        ?>
        <option value="">Select</option>
      </select>
  </div>
  <?php
  }
  ?>
  <?php
  if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 ) {
    $crs = $this->common_model->getCoursesById( $applicaitonStepOne[ 0 ][ 'course' ] );
    if ( $applicaitonStepOne[ 0 ][ 'course' ] > 0 && $crs[ 0 ][ 'has_stream' ] > 0 ) {
 $crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_three" id="option_name">
								<label for="comment">Subject 3 <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
									<select name="course_option_name_three" id="course_option_name_three" class="form-control" required="true">
										<option value="<?php echo $applicaitonStepOne[0]['course_option_name_three']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_three']; ?></option>
									</select>
								</div>
							</div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_three" id="option_name">
								<label for="comment">Subject 3 <span class="text-red">*</span></label>
								<div class="form-group col-md-10 pdleft">
									<select name="course_option_name_three" id="course_option_name_three" class="form-control" required="true">
										<option value="<?php echo $applicaitonStepOne[0]['course_option_name_three']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_three']; ?></option>
									</select>
								</div>
							</div>
							<?php	
							}
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 course_option_name_three" id="option_name">
		<label for="comment">Subject 3 <span class="text-red">*</span></label>
		<select name="course_option_name_three" id="course_option_name_three" class="form-control" required="true">
			<option value="<?php echo $applicaitonStepOne[0]['course_option_name_three']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_three']; ?></option>
		</select>
		<!--<input type="text" name="course_option_name_three" id="course_option_name_three" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_three'];
																															?>" />-->
	</div>
  <?php
  }
  } else {
    ?>
  <div class="col-xs-12 col-sm-4 col-md-4 pdright course_option_name_three" id="option_name">
		<label for="comment">Subject 3 <span class="text-red">*</span></label>
		<select name="course_option_name_three" id="course_option_name_three" class="form-control" required="true">
			<option value="<?php echo $applicaitonStepOne[0]['course_option_name_three']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_three']; ?></option>
		</select>
		<!--<input type="text" name="course_option_name_three" id="course_option_name_three" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_three'];
																															?>" />-->
	</div>
  <?php
  }
  ?>
</div>
<!---------University 4 START HERE----------->
<?php
if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7 && $applicaitonStepOne[ 0 ][ 'programme' ] != 8 ) {
  ?>
<div class="formrow dateof-birth unidiv4">
  <?php
  } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
      ?>
  <div class="formrow dateof-birth unidiv4">
    <?php
    } elseif ( count( $applicaitonStepOne ) <= 0 ) {
        ?>
    <div class="formrow dateof-birth unidiv4">
      <?php
      }

      if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7) {
        if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
          ?>
      <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
        <label for="comment" title = "Course choice 4">Course you wish to study 4</label>
        <select id="course_fourth" name="course_fourth" onchange="getCourseData4(this.value);" class="form-control course_fourth">
            <option value="">Select Course</option>
            <?php
            $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

            foreach ( $courses as $course ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'course_fourth' ] == $course[ 'id' ] ) {
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
        <label for="comment">Course you wish to study 4</label>
        <select id="course_fourth" name="course_fourth" onchange="getCourseData4(this.value);" class="form-control course_fourth">
            <option value="">Select Course</option>
            <?php
            $courses = $this->common_model->getCourseByPrgramme( $applicaitonStepOne[ 0 ][ 'programme' ] );
            foreach ( $courses as $course ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'course_fourth' ] == $course[ 'id' ] ) {
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
      <div class="col-xs-12 col-sm-4 col-md-4 course_wish_study">
        <label for="comment">Course you wish to study 4</label>
        <select id="course_fourth" name="course_fourth" onchange="getCourseData4(this.value);" class="form-control course_fourth">
            <option value="">Select Course</option>
            <?php
            $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

            foreach ( $courses as $course ) {
              if ( !empty( $applicaitonStepOne ) ) {
                if ( $applicaitonStepOne[ 0 ][ 'course_fourth' ] == $course[ 'id' ] ) {
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
      <div class="col-xs-12 col-sm-4 col-md-4 fade course_wish_study" style="display:none;">
        <label for="comment">Course you wish to study 4</label>
        <select id="course_fourth" name="course_fourth" onchange="getCourseData4(this.value);" class="form-control course_fourth">
			<option value="">Select Course</option>
		</select>
      </div>
      <?php
      } else {
        ?>
      <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
        <label for="comment">Course you wish to study 4</label>
        <select id="course_fourth" name="course_fourth" onchange="getCourseData4(this.value);" class="form-control course_fourth">
            <option value="">Select Course</option>
          </select>
      </div>
      <?php
      }
      ?>
      <?php
      if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7) {
        ?>
      <div class="col-xs-12 col-sm-4 col-md-4 pdright unidiv">
        <label for="comment">University 4</label>
        <select id="universty_choice_fourth" name="universty_choice_fourth"  class="form-control" onchange="selectAyushUniversity_fourthpop(this.value)">
            <option value="">Select</option>
            <?php
            if ( count( $applicaitonStepOne ) > 0 ) {
              if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
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
                        if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $uni_choice[ 'id' ] ) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $univercity_cnet[ 'id' ] ) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $univercity_nit[ 'id' ] ) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $univercity_yogs[ 'id' ] ) {
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
      } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 5 || $applicaitonStepOne[ 0 ][ 'programme' ] == 6 || $applicaitonStepOne[ 0 ][ 'programme' ] == 9 ) {
          ?>
      <div class="col-xs-12 col-sm-4 col-md-4 pdright unidiv">
        <label for="comment" title = "University choice 4">University 4 <span class="text-red"></span></label>
        <select id="universty_choice_fourth" name="universty_choice_fourth"  class="form-control" onchange="selectAyushUniversity_fourthpop(this.value)">
            <option value="">Select</option>
            <?php
            if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 ) {
              if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 ) {
				  $stateuniversities = $this->common_model->getAyushUniversitiesWithMapping($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['course_fourth']);
									$states =  $this->common_model->getAllStates();
									$statewiseUniversites = array();
									//echo "<pre>";print_r($statewiseUniversites);die;
									foreach($states as $st)
									{
										if(!array_key_exists($st['id'],$statewiseUniversites))
										{
											$statewiseUniversites[$st['id']] = array();
											
										}
									}
               if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
											{											
												if(array_key_exists($univercity['state_id'],$statewiseUniversites))
												{													
													array_push($statewiseUniversites[$univercity['state_id']],$univercity);
												}
											}	 
											
											foreach($statewiseUniversites as $key=>$univercity)
											{
												if(count($univercity)>0)
												{
													$statenames = $this->common_model->getStateById($key);
													
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'" class="stt">';
													foreach($univercity as $uni_choice)
													{
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice_fourth'] == $uni_choice['id'])
															{
																echo '<option selected="selected" value="'.$uni_choice['id'].'" disabled>'.$uni_choice['uni'].'</option>';
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
											echo '<option>------Select---------</option>';
										    echo '</optgroup>';	
									} elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 2 ) {
                  foreach ( $icaruni as $un ) {
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
                          if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $uni_choice[ 'id' ] ) {
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
                      if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $univercity_cnet[ 'id' ] ) {
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
                elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 5 ) {
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
                          if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $uni_choice[ 'id' ] ) {
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
                  foreach ( $nits as $univercity_nit ) {
                    if ( !empty( $applicaitonStepOne ) ) {
                      if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $univercity_nit[ 'id' ] ) {
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
                        if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $uni_choice[ 'id' ] ) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $univercity_cnet[ 'id' ] ) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $univercity_nit[ 'id' ] ) {
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
                    if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fourth' ] == $univercity_yogs[ 'id' ] ) {
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
        <label for="comment">University 4<span class="text-red"></span></label>
        <?php
          $user_data = $this->session->userdata( 'user_data' );
          $student_type = $user_data[ 'student_type' ];
          $student_course_type = $user_data[ 'apply_course_type' ];
          if ( $student_type == 1 && $student_course_type == 10) {
            ?>
          <select id="universty_choice_fourth" name="universty_choice_fourth"  class="form-control universty_choice_cl" onchange="selectAyushUniversity_fourthpop(this.value)">
            <?php
            } else {
              ?>
            <select id="universty_choice_fourth" name="universty_choice_fourth"  class="form-control universty_choice_cl" onchange="selectUniversityChoice_fifth(this.value)">
            <?php

            }
            ?>
            <!----<select id="universty_choice_two" name="universty_choice_two"  class="form-control" onchange="selectUniversityChoice_third(this.value)"  required="true">--->
            <option value="">Select</option>
          </select>
      </div>
      <?php
      }
      ?>
      <?php
      if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 ) {
        $crs = $this->common_model->getCoursesById( $applicaitonStepOne[ 0 ][ 'course_fourth' ] );
        if ( $applicaitonStepOne[ 0 ][ 'course_fourth' ] > 0 && $crs[ 0 ][ 'has_stream' ] > 0 ) {
          ?>
		  <?php
      $crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_fourth" id="option_name">
								<label for="comment">Subject 4</label>
								<div class="form-group col-md-10 pdleft">
									<select name="course_option_name_fourth" id="course_option_name_fourth" class="form-control">
										<option value="<?php echo $applicaitonStepOne[0]['course_option_name_fourth']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_fourth']; ?></option>
									</select>
									<!--<input type="text" name="course_option_name_fourth" id="course_option_name_fourth" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fourth'];
																																						?>"/>-->
								</div>
							</div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_fourth" id="option_name">
								<label for="comment">Subject 4</label>
								<div class="form-group col-md-10 pdleft">
									<select name="course_option_name_fourth" id="course_option_name_fourth" class="form-control">
										<option value="<?php echo $applicaitonStepOne[0]['course_option_name_fourth']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_fourth']; ?></option>
									</select>
									<!--<input type="text" name="course_option_name_fourth" id="course_option_name_fourth" class="form-control" value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fourth']; ?>"/>-->
								</div>
							</div>
							<?php	
							}
      } else {
        ?>
      <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_option_name_fourth" id="option_name">
			<label for="comment">Subject 4</label>
			<select name="course_option_name_fourth" id="course_option_name_fourth" class="form-control">
				<option value="<?php echo $applicaitonStepOne[0]['course_option_name_fourth']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_fourth']; ?></option>
			</select>
			<!--<input type="text" name="course_option_name_fourth" id="course_option_name_fourth" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fourth'];
																																?>"/>-->
		</div>
      <?php
      }
      } else {
        ?>
      <div class="col-xs-12 col-sm-4 col-md-4 pdright course_option_name_fourth" id="option_name">
			<label for="comment">Subject 4</label>
			<select name="course_option_name_fourth" id="course_option_name_fourth" class="form-control">
				<option value="<?php echo $applicaitonStepOne[0]['course_option_name_fourth']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_fourth']; ?></option>
			</select>
			<!--<input type="text" name="course_option_name_fourth" id="course_option_name_fourth" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fourth'];
																																?>"/>-->
		</div>
      <?php
      }
      ?>
    </div>
    
    <!---------University 4 END HERE-----------> 
    
    <!---------University 5 START HERE----------->
    
    <?php
    if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7 && $applicaitonStepOne[ 0 ][ 'programme' ] != 8 ) {
      ?>
    <div class="col-xs-12 col-sm-12 col-md-12 dateof-birth unidiv5">
      <?php
      } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8 ) {
          ?>
      <div class="col-xs-12 col-sm-12 col-md-12 dateof-birth unidiv5">
        <?php
        } elseif ( count( $applicaitonStepOne ) <= 0 ) {
            ?>
        <div class="formrow dateof-birth unidiv5">
          <?php
          }

          if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] != 3 && $applicaitonStepOne[ 0 ][ 'programme' ] != 4 && $applicaitonStepOne[ 0 ][ 'programme' ] != 7) {
            if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
              ?>
          <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
            <label for="comment" title = "Course choice 5">Course you wish to study 5<span class="text-red"></span></label>
            <select id="course_fifth" name="course_fifth" onchange="getCourseData5(this.value);" class="form-control course_fifth" required="true">
                <option value="">Select Course</option>
                <?php
                $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

                foreach ( $courses as $course ) {
                  if ( !empty( $applicaitonStepOne ) ) {
                    if ( $applicaitonStepOne[ 0 ][ 'course_fifth' ] == $course[ 'id' ] ) {
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
          <div class="col-xs-12 col-sm-4 col-md-4 course_wish_study">
            <label for="comment">Course you wish to study 5<span class="text-red"></span></label>
            <select id="course_fifth" name="course_fifth" onchange="getCourseData5(this.value);" class="form-control course_fifth">
                <option value="">Select Course</option>
                <?php
                $courses = $this->common_model->getCourseByPrgramme( $applicaitonStepOne[ 0 ][ 'programme' ] );

                foreach ( $courses as $course ) {
                  if ( !empty( $applicaitonStepOne ) ) {
                    if ( $applicaitonStepOne[ 0 ][ 'course_fifth' ] == $course[ 'id' ] ) {
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
          <div class="col-xs-12 col-sm-4 col-md-4 course_wish_study">
            <label for="comment">Course you wish to study 5<span class="text-red"></span></label>
            <select id="course_fifth" name="course_fifth" onchange="getCourseData5(this.value);" class="form-control">
                <option value="">Select Course</option>
                <?php
                $courses = $this->common_model->getCourseByPrgrammeAndType( $applicaitonStepOne[ 0 ][ 'programme' ], $applicaitonStepOne[ 0 ][ 'course_type' ] );

                foreach ( $courses as $course ) {
                  if ( !empty( $applicaitonStepOne ) ) {
                    if ( $applicaitonStepOne[ 0 ][ 'course_fifth' ] == $course[ 'id' ] ) {
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
            <label for="comment">Course you wish to study 5<span class="text-red"></span></label>
            <select id="course_fifth" name="course_fifth" onchange="getCourseData5(this.value);" class="form-control">
				<option value="">Select Course</option>
			  </select>
          </div>
          <?php
          } else {
            ?>
          <div class="col-xs-12 col-sm-4 col-md-4 pdleft course_wish_study">
            <label for="comment">Course you wish to study 5<span class="text-red"></span></label>
            <select id="course_fifth" name="course_fifth" onchange="getCourseData5(this.value);" class="form-control course_fifth">
                <option value="">Select Course</option>
              </select>
          </div>
          <?php
          }
          ?>
          <?php
          if ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 || $applicaitonStepOne[ 0 ][ 'programme' ] == 7) {
            ?>
          <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
            <label for="comment">University 5</label>
            <select id="universty_choice_fifth" name="universty_choice_fifth"  class="form-control" onchange="selectAyushUniversity_fifthpop(this.value)">
                <option value="">Select</option>
                <?php
                if ( count( $applicaitonStepOne ) > 0 ) {
                  if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 3 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4) {
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
                            if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $uni_choice[ 'id' ] ) {
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
                        if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $univercity_cnet[ 'id' ] ) {
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
                        if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $univercity_nit[ 'id' ] ) {
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
                        if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $univercity_yogs[ 'id' ] ) {
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
          } elseif ( count( $applicaitonStepOne ) > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 5 || $applicaitonStepOne[ 0 ][ 'programme' ] == 6 || $applicaitonStepOne[ 0 ][ 'programme' ] == 9 ) {
              ?>
          <div class="col-xs-12 col-sm-4 col-md-4 unidiv">
            <label for="comment" title = "University choice 5">University 5<span class="text-red"></span> </label>
            <select id="universty_choice_fifth" name="universty_choice_fifth"  class="form-control" onchange="selectAyushUniversity_fifthpop(this.value)">
                <option value="">Select</option>
                <?php
                if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 ) {
                  if ( $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 8) {
                    
                      $stateuniversities = $this->common_model->getAyushUniversitiesWithMapping($applicaitonStepOne[0]['programme'],$applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['course_fifth']);
									$states =  $this->common_model->getAllStates();
									$statewiseUniversites = array();
									//echo "<pre>";print_r($statewiseUniversites);die;
									foreach($states as $st)
									{
										if(!array_key_exists($st['id'],$statewiseUniversites))
										{
											$statewiseUniversites[$st['id']] = array();
											
										}
									}
               if($applicaitonStepOne[0]['course_type'] == 1)
						 			{						 				
						 				echo '<optgroup label="State Universities">';	
							 				foreach($stateuniversities as $univercity)
											{											
												if(array_key_exists($univercity['state_id'],$statewiseUniversites))
												{													
													array_push($statewiseUniversites[$univercity['state_id']],$univercity);
												}
											}	 
											
											foreach($statewiseUniversites as $key=>$univercity)
											{
												if(count($univercity)>0)
												{
													$statenames = $this->common_model->getStateById($key);
													
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'" class="stt">';
													foreach($univercity as $uni_choice)
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
											echo '<option>------Select---------</option>';
										    echo '</optgroup>';	
                    } elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 2 ) {
                      foreach ( $icaruni as $un ) {
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
                              if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $uni_choice[ 'id' ] ) {
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
                          if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $univercity_cnet[ 'id' ] ) {
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
                    elseif ( $applicaitonStepOne[ 0 ][ 'course_type' ] == 5 ) {
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
                              if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $uni_choice[ 'id' ] ) {
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
                      echo '<optgroup label="National Institute of Technology (NIT)">';
                      foreach ( $nits as $univercity_nit ) {
                        if ( !empty( $applicaitonStepOne ) ) {
                          if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $univercity_nit[ 'id' ] ) {
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
                            if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $uni_choice[ 'id' ] ) {
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
                        if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $univercity_cnet[ 'id' ] ) {
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
                        if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $univercity_nit[ 'id' ] ) {
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
                        if ( $applicaitonStepOne[ 0 ][ 'universty_choice_fifth' ] == $univercity_yogs[ 'id' ] ) {
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
            <label for="comment">University 5<span class="text-red"></span></label>
            <?php
              $user_data = $this->session->userdata( 'user_data' );
              $student_type = $user_data[ 'student_type' ];
              $student_course_type = $user_data[ 'apply_course_type' ];
              if ( $student_type == 1 && $student_course_type == 10) {
                ?>
              <select id="universty_choice_fifth" name="universty_choice_fifth"  class="form-control universty_choice_cl" onchange="selectAyushUniversity_fifthpop(this.value)">
                <?php
                } else {
                  ?>
                <select id="universty_choice_fifth" name="universty_choice_fifth"  class="form-control universty_choice_cl" onchange="selectUgUniversityChoiceFifth(this.value)">
                <?php

                }
                ?>
                <option value="">Select</option>
              </select>
          </div>
          <?php
          }
          ?>
          <?php
          if ( $applicaitonStepOne[ 0 ][ 'programme' ] > 0 && $applicaitonStepOne[ 0 ][ 'programme' ] == 1 || $applicaitonStepOne[ 0 ][ 'programme' ] == 2 || $applicaitonStepOne[ 0 ][ 'programme' ] == 4 ) {
            $crs = $this->common_model->getCoursesById( $applicaitonStepOne[ 0 ][ 'course_fifth' ] );
            if ( $applicaitonStepOne[ 0 ][ 'course_fifth' ] > 0 && $crs[ 0 ][ 'has_stream' ] > 0 ) {
             $crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
							if($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0)
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_fifth" id="option_name">
                                                                                                                <label for="comment">Subject 5</label>
                                                                                                                <div class="form-group col-md-10 pdleft">
                                                                                                                    <select name="course_option_name_fifth" id="course_option_name_fifth" class="form-control">
                                                                                                                        <option value="<?php echo $applicaitonStepOne[0]['course_option_name_fifth']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_fifth']; ?></option>
                                                                                                                    </select>
                                                                                                                    <!--<input type="text" name="course_option_name_fifth" id="course_option_name_fifth" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fifth'];
                                                                                                                                                                                                                                        ?>"/>-->
                                                                                                                </div>
                                                                                                            </div>
							<?php	
							}
							else
							{
							?>
							<div class="name-sec col-xs-12 col-sm-3 col-md-4 course_option_name_fifth" id="option_name">
                                                                                                                <label for="comment">Subject 5</label>
                                                                                                                <div class="form-group col-md-10 pdleft">
                                                                                                                    <select name="course_option_name_fifth" id="course_option_name_fifth" class="form-control">
                                                                                                                        <option value="<?php echo $applicaitonStepOne[0]['course_option_name_fifth']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_fifth']; ?></option>
                                                                                                                    </select>
                                                                                                                    <!--<input type="text" name="course_option_name_two" id="course_option_name_fifth" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fifth'];
                                                                                                                                                                                                                                    ?>"/>-->
                                                                                                                </div>
                                                                                                            </div>
							<?php	
							}
          } else {
            ?>
          <div class="col-xs-12 col-sm-4 col-md-4 course_option_name_fifth" id="option_name">
                                                                                                            <label for="comment">Subject 5</label>
                                                                                                            <select name="course_option_name_fifth" id="course_option_name_fifth" class="form-control">
                                                                                                                <option value="<?php echo $applicaitonStepOne[0]['course_option_name_fifth']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_fifth']; ?></option>
                                                                                                            </select>
                                                                                                            <!--<input type="text" name="course_option_name_fifth" id="course_option_name_fifth" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fifth'];
                                                                                                                                                                                                                                ?>"/>-->
                                                                                                        </div>
		  
		  
		  
          <?php
          }
          } else {
            ?>
          <div class="col-xs-12 col-sm-4 col-md-4 pdright course_option_name_fifth" id="option_name">
                                                                                                        <label for="comment">Subject 5</label>
                                                                                                        <select name="course_option_name_fifth" id="course_option_name_fifth" class="form-control">
                                                                                                            <option value="<?php echo $applicaitonStepOne[0]['course_option_name_fifth']; ?>"><?php echo $applicaitonStepOne[0]['course_option_name_fifth']; ?></option>
                                                                                                        </select>
                                                                                                        <!--<input type="text" name="course_option_name_fifth" id="course_option_name_fifth" class="form-control" value="<?php //if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['course_option_name_fifth'];
                                                                                                                                                                                                                            ?>"/>-->
                                                                                                    </div>
          <?php
          }
          ?>
        </div>
        <!---------University 5 END HERE----------->
        <?php
        }
        ?>
		
		
		
		
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
<!-- Modal -->
            <!-- <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    // Modal content
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">INFORMATION</h4>
                        </div>
                    <div class="modal-body">
     
						    </div>
                <div class="modal-footer">
                // <button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>
                // <button type="button" class="btn btn-primary submitBtn">SUBMIT</button>
                        
                
                </div>
            </div> -->
                  
                </div>
            </div>
</section>



<script>
// vipin change
function selectAyushUniversityChoice(id)
{
//alert(id);
	var programme = $('#programmeayush').val();
	var course_types = $('#course_types').val();
	var course = $('#course').val();
	//alert(programme);
	//alert(course_types);
	//alert(course);
	var datas = id.split('/');
	var uni_id = datas[0];
	var schemid_one = datas[1];
	var schemid_two = datas[2];
	//alert(uni_id);
	//alert(schemid_one);
	//alert(schemid_two);
	
	  // AJAX request
   $.ajax({
    url: baseURL +'applicant/selectedAyushSchemeUniversityData',
    type: 'post',
    data: {uni_id:uni_id,programme: programme,course_types:course_types,course:course},
    success: function(response){ 
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      //$('#modalForm').modal('show'); 
	  
	  var htmlFirst = $('#universty_choice').html();
	$('#universty_choice_two').html(htmlFirst);
	$('#universty_choice_two option[value="'+id+'"]').remove();
	$("#course_two").val("");
	//$('#universty_choice_two').val("");
    }
  });
	
	
	
}

function selectAyushUniversityChoice_third(uni_id)
{
	var programme = $('#programmeayush').val();
	var course_types = $('#course_types').val();
	var course = $('#course_two').val();
	var uni_id_two = $('#universty_choice_two').val();
	//alert(uni_id);
	//alert(uni_id_two);
	$.ajax({
    url: baseURL +'applicant/selectedAyushSchemeUniversityData',
    type: 'post',
    data: {uni_id:uni_id,programme: programme,course_types:course_types,course:course},
    success: function(response){ 
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      //$('#modalForm').modal('show'); 
	  
	var htmlFirst = $('#universty_choice_two').html();
	$('#universty_choice_three').html(htmlFirst);
	$('#universty_choice_three option[value="'+uni_id+'"]').remove();
	$('#universty_choice_three option[value="'+uni_id_two+'"]').remove();
	$("#course_three").val("");
    }
  });
	
}

function selectAyushUniversity_thirdpop(uni_id)
{
	
	var programme = $('#programmeayush').val();
	var course_types = $('#course_types').val();
	var course = $('#course_three').val();
	var uni_id_two = $('#universty_choice_three').val();
	$.ajax({
    url: baseURL +'applicant/selectedAyushSchemeUniversityData',
    type: 'post',
     data: {uni_id:uni_id,programme: programme,course_types:course_types,course:course},
    success: function(response){ 
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      //$('#modalForm').modal('show'); 
	  
	var htmlFirst = $('#universty_choice_three').html();
	//$('#universty_choice_three').html(htmlFirst);
	//$('#universty_choice_three option[value="'+uni_id+'"]').remove();
	//$('#universty_choice_three option[value="'+uni_id_two+'"]').remove();
    }
  });
	
}
function selectAyushUniversity_fourthpop(uni_id)
{
	
	var programme = $('#programmeayush').val();
	var course_types = $('#course_types').val();
	var course = $('#course_fourth').val();
	var uni_id_two = $('#universty_choice_fourth').val();
	$.ajax({
    url: baseURL +'applicant/selectedAyushSchemeUniversityData',
    type: 'post',
     data: {uni_id:uni_id,programme: programme,course_types:course_types,course:course},
    success: function(response){ 
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      //$('#modalForm').modal('show'); 
	  
	var htmlFirst = $('#universty_choice_fourth').html();
	//$('#universty_choice_three').html(htmlFirst);
	//$('#universty_choice_three option[value="'+uni_id+'"]').remove();
	//$('#universty_choice_three option[value="'+uni_id_two+'"]').remove();
    }
  });
	
}
function selectAyushUniversity_fifthpop(uni_id)
{
	//alert('ok');
	var programme = $('#programmeayush').val();
	var course_types = $('#course_types').val();
	var course = $('#course_fifth').val();
	var uni_id_two = $('#universty_choice_fifth').val();
	$.ajax({
    url: baseURL +'applicant/selectedAyushSchemeUniversityData',
    type: 'post',
     data: {uni_id:uni_id,programme: programme,course_types:course_types,course:course},
    success: function(response){ 
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      //$('#modalForm').modal('show'); 
	  
	var htmlFirst = $('#universty_choice_fifth').html();
	//$('#universty_choice_three').html(htmlFirst);
	//$('#universty_choice_three option[value="'+uni_id+'"]').remove();
	//$('#universty_choice_three option[value="'+uni_id_two+'"]').remove();
    }
  });
	
}

$('#profilePic').dropzone({
	url: baseURL + "applicant/uploadProfilePic",
	uploadMultiple:false,
	dictDefaultMessage:"Click / Drop here to upload files"
});


    function showEnglishlevel(str) {
        if (str == 1) {
            $('#english_level').attr("required", true);
            $('#english_score').attr("required", true);
            $('#englishLevel').show();
        } else {
            $('#english_level').attr("required", false);
            $('#english_score').attr("required", false);
            $('#englishLevel').hide();
        }
    }

    function showEnglishlevel2(str) {
        if (str == 1) {
            $('.eng_score').show();
        } else {
            $('.eng_score').hide();
        }
    }

    function courseDuration(str) {

        if (str != "") {
            $.ajax({
                type: "POST",
                url: baseURL + 'applicant/getDuration',
                data: {
                    "<?php echo $this->security->get_csrf_token_name(); ?>": "<?php echo $this->security->get_csrf_hash(); ?>",
                    "course_id": str
                },
                success: function(data) {
                    $('#selectDuration').html(data);
                }
            })
        }else{
        	 $('.duration_type').hide();
        }
    }

    function getCourseData(str) {
        if (str != "") {
            $.ajax({
                type: "GET",
                url: baseURL + 'applicant/getDurationCourse?courseId=' + str,
                success: function(data) {
                    $('#course_option_name').html(data);
                }
            })
        }

    }

    function getCourseData2(str) {

        if (str != "") {
            $.ajax({
                type: "GET",
                url: baseURL + 'applicant/getDurationCourse?courseId=' + str,
                success: function(data) {
                    $('#course_option_name_two').html(data);
                }
            })
        }

    }

    function getCourseData3(str) {

        if (str != "") {
            $.ajax({
                type: "GET",
                url: baseURL + 'applicant/getDurationCourse?courseId=' + str,
                success: function(data) {
                    $('#course_option_name_three').html(data);
                }
            })
        }

    }

    function getCourseData4(str) {

        if (str != "") {
            $.ajax({
                type: "GET",
                url: baseURL + 'applicant/getDurationCourse?courseId=' + str,
                success: function(data) {
                    $('#course_option_name_fourth').html(data);
                }
            })
        }

    }

    function getCourseData5(str) {

        if (str != "") {
            $.ajax({
                type: "GET",
                url: baseURL + 'applicant/getDurationCourse?courseId=' + str,
                success: function(data) {
                    $('#course_option_name_fifth').html(data);
                }
            })
        }

    }

function showEnglishlevel3(str) {
	if (str == 1) {
	$('.eng_score3').show();
	} else {
	$('.eng_score3').hide();
	
	}
	}
	
	function showEnglishlevel4(str) {
	if (str == 1) {
	$('.eng_score4').show();
	} else {
	$('.eng_score4').hide();
	
	}
	}



</script>
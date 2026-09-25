<style>
   input::-webkit-outer-spin-button,
   input::-webkit-inner-spin-button {
   -webkit-appearance: none;
   margin: 0;
   }
   input[type=number] {
   -moz-appearance: textfield;
   }
</style>
<?php
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);
   //echo "<pre>";
   //print_r($registerData);die;
   function sortByName($a, $b)
   {
       $a = $a['uni'];
       $b = $b['uni'];
       if ($a == $b) {
           return 0;
       }
       return ($a < $b) ? -1 : 1;
   }
   $stateuniversities = $this->common_model->getStateUniversities();
   $icaruniversities = $this->common_model->getICARUniversity();
   $ayush = $this->common_model->getAYUSHUniversity();
   if (isset($applicaitonStepOne[0]['programme']) && $applicaitonStepOne[0]['programme'] < 0) {
       $agriculturealuniversities = $this->common_model->getAgriculturalUniversity();
   } else {
       if (isset($applicaitonStepOne[0]['programme']) && isset($applicaitonStepOne[0]['course_type'])) {
           $agriculturealuniversities = $this->common_model->getICARUniversitiesWithMapping($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       } else {
           $agriculturealuniversities = array();
       }
   }
   //$agricultureal = $this->common_model->getAgriculturalUniversity();
   if (isset($applicaitonStepOne[0]['programme']) && isset($applicaitonStepOne[0]['course_type'])) {
       $centraluniversities = $this->common_model->getCentralUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       //print_r($centralUniversities);die;
	   
	   $centraluniversitiestwo = $this->common_model->getCentralUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $centraluniversitiesthree = $this->common_model->getCentralUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $centraluniversitiesfour = $this->common_model->getCentralUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $centraluniversitiesfive = $this->common_model->getCentralUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $nits = $this->common_model->getNITUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $nitstwo = $this->common_model->getNITUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $nitsthree = $this->common_model->getNITUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $nitsfour = $this->common_model->getNITUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $nitsfive = $this->common_model->getNITUniversitiesByCourseType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
       $stateuniversities = $this->common_model->getStateUniversitiesWithMapping($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);
   }else{
       $centraluniversities = $this->common_model->getCentralUniversities();
       $centraluniversitiestwo = $this->common_model->getCentralUniversities();
       $centraluniversitiesthree = $this->common_model->getCentralUniversities();
       $centraluniversitiesfour = $this->common_model->getCentralUniversities();
       $centraluniversitiesfive = $this->common_model->getCentralUniversities();
       $nits = $this->common_model->getNITUniversities();
       $nitstwo = $this->common_model->getNITUniversities();
       $nitsthree = $this->common_model->getNITUniversities();
       $nitsfour = $this->common_model->getNITUniversities();
       $nitsfive = $this->common_model->getNITUniversities();
       $stateuniversities = $this->common_model->getStateUniversities();
   }
    
   $yogas = $this->common_model->getYogaGurus();
   $states = $this->common_model->getAllStates();
   $nifts = $this->common_model->getAllNIFT();
   $crstype = $this->common_model->getCourseTypes();
   //echo "<pre>";print_r($icaruniversities);
   $statewiseUniversites = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $statewiseUniversites)) {
           $statewiseUniversites[$st['id']] = array();
       }
   }
   
   $statewiseUniversitestwo = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $statewiseUniversitestwo)) {
           $statewiseUniversitestwo[$st['id']] = array();
       }
   }
   
   $statewiseUniversitesthree = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $statewiseUniversitesthree)) {
           $statewiseUniversitesthree[$st['id']] = array();
       }
   }
   
   $statewiseUniversitesfour = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $statewiseUniversitesfour)) {
           $statewiseUniversitesfour[$st['id']] = array();
       }
   }
   
   $statewiseUniversitesfive = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $statewiseUniversitesfive)) {
           $statewiseUniversitesfive[$st['id']] = array();
       }
   }
   $agriCultureUniversities = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $agriCultureUniversities)) {
           $agriCultureUniversities[$st['id']] = array();
       }
   }
   //echo "<pre>";print_r($statewiseUniversites);
   $icaruniUniversity = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $icaruniUniversity)) {
           $icaruniUniversity[$st['id']] = array();
       }
   }
   
   $agriCultureUniversitiesTwo = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $agriCultureUniversitiesTwo)) {
           $agriCultureUniversitiesTwo[$st['id']] = array();
       }
   }
   $agriCultureUniversitiesThree = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $agriCultureUniversitiesThree)) {
           $agriCultureUniversitiesThree[$st['id']] = array();
       }
   }
   $agriCultureUniversitiesFourth = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $agriCultureUniversitiesFourth)) {
           $agriCultureUniversitiesFourth[$st['id']] = array();
       }
   }
   $agriCultureUniversitiesFifth = array();
   foreach ($states as $st) {
       if (!array_key_exists($st['id'], $agriCultureUniversitiesFifth)) {
           $agriCultureUniversitiesFifth[$st['id']] = array();
       }
   }
   
   $stateuniversities_one = str_replace("'", "\'", json_encode($stateuniversities));
   $centraluniversities_one = str_replace("'", "\'", json_encode($centraluniversities));
   $agricultureuniversities_one = str_replace("'", "\'", json_encode($agriculturealuniversities));
   $icar_one = str_replace("'", "\'", json_encode($icaruniversities));
   $nits_one = str_replace("'", "\'", json_encode($nits));
   $yogas_one = str_replace("'", "\'", json_encode($yogas));
   $states_array = json_encode($statewiseUniversites);
   $icar_array = json_encode($agriCultureUniversities);
   
   
   
   $agricultural_array = json_encode($icaruniUniversity);
   //echo "<pre>"; print_r($agricultural_array);
   //$icar = json_encode( $icaruni );
   $ayushUni = json_encode($ayush);
   $ctypes = json_encode($crstype);
   $nift = json_encode($nifts);
   ?>
<script type="text/javascript">
   var stateuniversities = JSON.parse('<?php echo $stateuniversities_one; ?>');
   //console.log(stateuniversities);
   var centralUniversities = JSON.parse('<?php echo $centraluniversities_one; ?>');
   var agriculturealuniversities = JSON.parse('<?php echo $agricultureuniversities_one; ?>');
   var icaruniversities = JSON.parse('<?php echo $icar_one; ?>');
   var nits = JSON.parse('<?php echo $nits_one; ?>');
   var yogas = JSON.parse('<?php echo $yogas_one; ?>');
   var statesarray = JSON.parse('<?php echo $states_array; ?>');
   var icararray = JSON.parse('<?php echo $icar_array; ?>');
   //alert(JSON.stringify(statesarray));
   var agriculturalarray = JSON.parse('<?php echo $agricultural_array; ?>');
   var ayushU = JSON.parse('<?php echo $ayushUni; ?>');
   var courseTypeList = JSON.parse('<?php echo $ctypes; ?>');
   //alert(JSON.stringify(courseTypeList));
   var niftList = JSON.parse('<?php echo $nift; ?>');
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
      <h3 class="text-center caps">Application Form(2026-2027) For Scholarship through ICCR</h3>
      <h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
      <span class="text-center"
         style="color:red;font-size:13px;font-weight:bold;padding:13px 0;display: block;"> Applicant must note that the information to be provided by him/her on the A2A Portal should be correct and match with the supporting documents to be uploaded in the courses of application and verified by the Indian Mission and the Universities/Institutions at the time of award of scholarship/admission at the time of joining.</br>
	If any information found to be incorrect in any manner whatsoever, at any stage of the scholarship, application will be REJECTED immediately without any intimation.</br>
	Falsification of data or multiple applications will lead to automatic REJECTION of application at any stage of the scholarship process.
     <span class="notext">Note: (Profile Image should be less than equal to 200 KB and in JPG/JPEG/PNG format)</span> 
      <!--<br><span class="notext">Note: (Signature should be less than equal to 200 KB and in JPG/JPEG/PNG format)</span>-->
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
   <div id="home"     class="tab-pane fade in active">
   <form id="form-process-personal-info"
      enctype="multipart/form-data"
      method="post">
      <input type="hidden"
         name="<?php echo $this->security->get_csrf_token_name(); ?>"
         value="<?php echo $this->security->get_csrf_hash(); ?>" />
      <input type="hidden"
         name="application_no"
         value="<?php echo $get_application_number; ?>"/>
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
			   $userId = $user_data['userid'];
              // $imgArray = $this->common_model->getUserImage($applicaitonStepOne[0]['uid']);
			  $imgArray = $this->common_model->getUserImage($userId);
			   //print_r($imgArray);die;
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
               
               }
               ?>
         </div>
         <div class="formmainrow">
            <div class="formrow">
               <label title="Please Enetr Full Name">1. Full Name<span class="text-red">*</span></label>
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
                     title="Enter your full name as it appears on your passport. Do not use nicknames or short forms."
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
                     title="Enter your full name as it appears on your passport. Do not use nicknames or short forms."
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
                     title="Enter your full name as it appears on your passport. Do not use nicknames or short forms."
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
                     title="Note: If the date of birth is found to be different from the DOB in the passport column at any stage, your application/scholarship will be cancelled. "
                     readonly="true"
                     class="form-control"
                     placeholder="yy-mm-dd"
                     id="dob"
                     name="dob"
                     value="<?php if (!empty($registerData)) echo $registerData[0]['date_of_birth']; ?>" />
               </div>
              <div class="col-xs-12 col-sm-3 col-md-3 pdleft">
                  <label title="Please Enter Date of Birth"
                     for="comment">Age<span class="text-red">*</span></label>
                <?php
                $age = ""; 
                $newDate = "";

                if (!empty($registerData) && !empty($registerData[0]['date_of_birth'])) {

                    $dobRaw = trim($registerData[0]['date_of_birth']); // e.g. 25/03/2002

                    // Parse dd/mm/yyyy safely
                    $birthDateObj = DateTime::createFromFormat('d/m/Y', $dobRaw);

                    if ($birthDateObj !== false) {
                        // Convert to Y-m-d if you need
                        $newDate = $birthDateObj->format('Y-m-d'); // 2002-03-25

                        // Calculate Age
                        $today = new DateTime('today');
                        $age = $birthDateObj->diff($today)->y;
                    }
                }
                ?>
                <input type="text"
                   title="Valid Age"
                   readonly
                   class="form-control"
                   id="age"
                   name="age"
                   value="<?php echo $age; ?>" />

               </div>
               <div class="col-xs-12 col-sm-3 col-md-3 pdleft">
                  <label title="Birth City"
                     for="comment">4. Place of Birth<span class="text-red">*</span></label>
                  <input type="text"
                     class="form-control capitalLetter"
                     title="Mention the city and country where you were born."
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
                          title="Mention your present city and country of residence."
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
                     for="comment">5. Country <span class="text-red">*</span></label>
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
			   /*
			  
                   if (!empty($registerData)) {
                      if ($registerData[0]['country_of_domicile'] == '75' || $registerData[0]['country_of_domicile'] == '10') {
                 **/ ?>


<div class="col-xs-12 col-sm-3 col-md-3">

<label title="Passport No">6. Passport No<span class="text-red"></span></label>

<input type="text"
    name="passport_no"
    class="form-control capitalLetter"
    required
    placeholder="Passport No"
    id="passport_no"
    pattern="^[a-zA-Z0-9 ]+$"
    value="<?php if (!empty($registerData)) echo $registerData[0]['passport_no']; ?>"
    <?php if (!empty($registerData) && !empty($registerData[0]['passport_file'])) echo "readonly"; ?>
/>
<?php
$passport_file = !empty($registerData[0]['passport_file']) ? $registerData[0]['passport_file'] : '';
?>

<input type="hidden" name="old_passport_file" value="<?php echo $passport_file; ?>">

<div class="passport-section">
    <?php if (!empty($passport_file)) { ?>
        <img id="passport_image_div"
             src="<?php echo base_url($passport_file); ?>"
             style="width:100px;height:auto;border:1px solid #ccc;padding:3px;" />

        <br><br>

        <a href="#"
           data-toggle="modal"
           data-target="#passportUploadsPic"
           onclick="return false;">
           Re-Upload Passport
        </a>
        <hr>
    <?php } else { ?>
        <img id="passport_image_div"
             src=""
             style="width:100px;height:auto;border:1px solid #ccc;padding:3px;display:none;" />

        <a href="#"
           data-toggle="modal"
           data-target="#passportUploadsPic"
           onclick="return false;">
           Upload Passport
        </a>
        <hr>

        <span style="color:black;font-weight:bold;box-shadow:4px 1px 13px yellow inset;padding:4px;">
            Note: Passport should be less than or equal to 2 MB and in JPG/JPEG/PNG format
        </span>
    <?php } ?>
</div>

			

</div>


		  
				  
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
                     title="Mention the city and country where your passport was issued."
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
                     title="Mention the city and country where your passport was issued."
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
                        title="Provide the exact date on which your passport was issued."
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
                        title="Should have the minimum validity of 2 yrs on the date of application. "
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
                        title="Should have the minimum validity of 2 yrs on the date of application. "
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
                        title="Should have the minimum validity of 2 yrs on the date of application. "
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
                        title="Provide the exact date on which your passport was issued."
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
                        title="Provide the exact date on which your passport was issued."
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
                        title="Provide the exact date on which your passport was issued."
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
 						title="Should have the minimum validity of 2 yrs on the date of application. "
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
                        title="Should have the minimum validity of 2 yrs on the date of application. "
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
                        title="Should have the minimum validity of 2 yrs on the date of application. "
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
               title="Write your complete permanent postal address with city, state, country, and postal/ZIP code."
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
               title="Write your complete permanent postal address with city, state, country, and postal/ZIP code."
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
               title="Write your complete permanent postal address with city, state, country, and postal/ZIP code."
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
               title="Write your complete permanent postal address with city, state, country, and postal/ZIP code."
               pattern="^[a-zA-Z0-9 ]+$"
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
               title="Provide your personal mobile number (with country code). "
               required="true"
               readonly="true"
               name="phone_number"
               placeholder="Mobile Number"
               maxlength="20">
            <!-- <small><b>You&nbsp;want&nbsp;to&nbsp;use&nbsp;same&nbsp;No&nbsp;on&nbsp;WhatsApp</b>&nbsp;<input
               type="checkbox"
               value="<?php //if (!empty($registerData)) echo $registerData[0]['mobile_number']; ?>"></small> -->
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <label>12. WhatsApp Number <span class="text-red">*</span></label>
            <input name="whatsapp_number"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['whatsapp_number']; ?>"
               pattern="^[0-9\+]+$"
               title="Enter your active WhatsApp number (with country code)."
               type="number"
               class="form-control"
               placeholder="Enter your active WhatsApp number (with country code)."
               maxlength="20"
               required="true"
               id="phone">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <label>13. Email Address<span class="text-red">*</span></label>
            <input type="email"
               title="Please note that all updates will be sent on the mail address provided in this column. ICCR will not be responsible if it is incorrect or invalid. No changes would be allowed in this column at any stage."
               readonly="true"
               name="email"
               class="form-control"
               placeholder="Email"
               id="email"
               value="<?php if (!empty($registerData)) echo $registerData[0]['email_id']; ?>">
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <label for="comment">14. Citizenship/Local/Domestic Number<span class="text-red">*</span></label>
            <input type="text"
               class="form-control capitalLetter"
               id="unique_id"
               name="unique_id"
               readonly="true"
               pattern="^[a-zA-Z0-9 ]+$"
               title="Mention your Local/Domestic Number that is given to the citizen of your country."
               placeholder="Unique ID"
               required="true"
               value="<?php if (!empty($registerData)) echo $registerData[0]['unique_id']; ?>" />
         </div>
      </div>
      
      <?php
      $parent_type = !empty($registerData) ? $registerData[0]['parent_type'] : 3; // default both
      ?>

      <!-- ================== FATHER ================== -->
      <?php if ($parent_type == 1 || $parent_type == 3) { ?>
      <div class="formrow">
        <label>15. Details of Father/Mother/Guardian<span class="text-red">*</span></label>

        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Father Name <span class="text-red">*</span></label>
           <input class="form-control capitalLetter"
              readonly
              id="father_name"
              placeholder="Enter Name"
              value="<?php if (!empty($registerData)) echo strtoupper(trim($registerData[0]['father_fname'].' '.$registerData[0]['father_mname'].' '.$registerData[0]['father_lname'])); ?>">
        </div>

        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Phone Number <span class="text-red">*</span></label>
           <input type="text"
              class="form-control"
              id="father_number"
              name="father_number"
              placeholder="Eg. +91**********"
              value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['father_number']; ?>">
        </div>

        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Email Id<span class="text-red">*</span></label>
           <input type="email"
              name="father_email"
              class="form-control"
              id="father_email"
              value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['father_email']; ?>">
        </div>
      </div>
      <?php } ?>

      <!-- ================== MOTHER ================== -->
      <?php if ($parent_type == 2 || $parent_type == 3) { ?>
      <div class="formrow">
        <label>15. Details of Father/Mother/Guardian<span class="text-red">*</span></label>
        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Mother Name <span class="text-red">*</span></label>
           <input class="form-control capitalLetter"
              readonly
              id="mother_name"
              placeholder="Enter Name"
              value="<?php if (!empty($registerData)) echo strtoupper(trim($registerData[0]['mother_fname'].' '.$registerData[0]['mother_mname'].' '.$registerData[0]['mother_lname'])); ?>">
        </div>

        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Phone Number <span class="text-red">*</span></label>
           <input type="text"
              class="form-control"
              id="mother_number"
              name="mother_number"
              placeholder="Eg. +91**********"
              value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['mother_number']; ?>">
        </div>

        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Email Id<span class="text-red">*</span></label>
           <input type="email"
              name="mother_email"
              class="form-control"
              id="mother_email"
              value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['mother_email']; ?>">
        </div>
      </div>
      <?php } ?>

      <!-- ================== GUARDIAN ================== -->
      <?php if ($parent_type == 4) { ?>
      <div class="formrow">
        <label>15. Details of Father/Mother/Guardian<span class="text-red">*</span></label>
        
        <label>15. Details of Guardian<span class="text-red">*</span></label>

        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Guardian Name <span class="text-red">*</span></label>
           <input class="form-control capitalLetter"
              id="guardian_name"
              name="guardian_name"
              placeholder="Enter Guardian Name"
              value="<?php if (!empty($registerData)) echo strtoupper(trim($registerData[0]['gurdian_fname'].' '.$registerData[0]['gurdian_mname'].' '.$registerData[0]['gurdian_lname'])); ?>">
        </div>

        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Phone Number <span class="text-red">*</span></label>
           <input type="text"
              class="form-control"
              id="guardian_number"
              name="guardian_number"
              placeholder="Eg. +91**********"
              value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_number']; ?>">
        </div>

        <div class="col-xs-12 col-sm-3 col-md-4">
           <label>Email Id<span class="text-red">*</span></label>
           <input type="email"
              name="guardian_email"
              class="form-control"
              id="guardian_email"
              value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['guardian_email']; ?>">
        </div>
      </div>
      <?php } ?>

      
        
        
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
               title="A-Z a-z 0-9 ' '"
               pattern="^[a-zA-Z0-9 ]+$"
               type="text"
               class="form-control"
               placeholder="Zipcode"
               id="gardiuan_address_pincode"
               required="true"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gardiuan_address_pincode']; ?>">
         </div>
      </div>
     
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
      <div class="formrow"  id="englishLevel"     <?php if ($is_english_as_subject == 1) { ?>  style="display:block"  <?php } else { ?>
         style="display:none"    <?php } ?>  >
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft">

         <?php
                  if (count($applicaitonStepOne) > 0) {
                      $english_level = $applicaitonStepOne[0]['english_level'];
                  } ?>

            <label title="Till What Level"
               for="comment">Till What Level<span class="text-red"></span></label>
            <select name="english_level"
               id="english_level"
               class="form-control">
               <option value=" ">Select</option>
               <option value="Secondary|High School(8-10 Year)">Secondary|High School(8-10 Year)</option>
               <option value="High School|College(10-12 Year)">High School|College(10-12 Year)</option>
               <option value="Under Graduate(12-15 Year)">Under Graduate(12-15 Year)</option>
               <option value="Post Graduate(15-18 Year)">Post Graduate(15-18 Year)</option>
              
              
            </select>
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
         <div class="col-xs-12 col-sm-4 col-md-4 pdleft eng" style="display:none;">
            <div class="forminner">
               <label for="comment"
                  title="">Please attach the certificate<br><span style="color:red;font-size:8px">(jpg|jpeg|png|pdf)(Max 2 MB)</span></label>
              	<input type="file" class="form-control" name="attach_certificate" >
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
            application will not be considered. The essay can be written offline and pasted
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
               4. Describe a problem you’ve solved or a problem youd like to solve. It can be
               an intellectual challenge, a research query, an ethical dilemma— anything of
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
               
               <option <?php if ($acedemic_year == '2026-27') {
                  echo "selected";
                  } ?>>2026-27</option> 
            </select>
         </div>
         <div class="col-xs-12 col-sm-3 col-md-3">
            <label for="comment"
               title="Course applied">20. Level of Course <span
               class="text-red">*</span></label>
            <?php
               $user_data = $this->session->userdata('user_data');
             $student_type = $user_data['student_type'];
             $student_course_type = $user_data['apply_course_type'];
             $prgid = $user_data['apply_course_type']; 
               ?>
            

               <?php
			   
			   
                  if ($student_type == 1 && $student_course_type == 1 || $student_type == 1 && $student_course_type == 3 || $student_type == 1 && $student_course_type == 4 || $student_type == 1 && $student_course_type == 9 || $student_type == 1 && $student_course_type == 2) {
                      $programme = $this->common_model->getAllProgrammeWithoutAyush($prgid);
                  } elseif ($student_type == 1 && $student_course_type == 5 || $student_type == 1 && $student_course_type == 6) {
                      $programme = $this->common_model->getAllProgrammeGuruDance();
                  }elseif ($student_course_type == 12) {
                      $programme = $this->common_model->getAllDiploma();
                  }elseif ($student_course_type == 13) {
                      $programme = $this->common_model->getAllCertificate();
                  }elseif ($student_course_type == 8) {
					  
                      $programme = $this->common_model->getAllPhdProgramme8();
                  } else {
                      $programme = $this->common_model->getAllPhdProgramme();
                  }
				  
				  
				  
                  $res = array(8 => $programme[7]);
                  $ress = array_merge(array_slice($programme, 0, 4), $res, array_slice($programme, 4));
                  unset($ress[8]);?>
				  <select id="programme"
               name="programme"
               onChange="courseDuration(this.value)"
               class="form-control capitalLetter"
               required="true">
				  <?php
                  foreach ($ress as $program) {
                      if (!empty($applicaitonStepOne)) {
                          if ($applicaitonStepOne[0]['programme'] == $program['id']) {
                              echo '<option value="' . $program['id'] . '">' . $program['name'] . '</option>';
                          } else {
                              echo '<option  value="' . $program['id'] . '">' . $program['name'] . '</option>';
                          }
                      } else {
                          echo '<option  value="' . $program['id'] . '">' . $program['name'] . '</option>';
                      }
                  }
			   
                  ?>
            </select>
         </div>
         
         <div class="col-xs-12 col-sm-3 col-md-3 course_type">
            <?php
			
               if (isset($applicaitonStepOne[0]['programme'])) {
                   if (count($applicaitonStepOne) > 0 &&  $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 9 || $applicaitonStepOne[0]['programme'] == 8) {
                       $user_data = $this->session->userdata('user_data');
                       $student_type = $user_data['student_type'];
                       $student_course_type = $user_data['apply_course_type'];
                       $prgid = $user_data['apply_course_type'];
					   
               ?>
            <div class="course_type pdleft"
               required="true">
               <label for="comment"
                  title="Course Types choice">21. Course Main Stream <span
                  class="text-red">*</span> </label>
               <select id="course_type"
                  name="course_type"
                  class="form-control capitalLetter">
                  <option value="">Select Main Stream</option>
                  <?php
                     /*if ($student_type == 1 && $student_course_type == 5) {
                         $courseType = $this->common_model->getAllCourseTypeWithoutAyush($prgid);
                     } elseif ($student_type == 1 && $student_course_type == 6) {
                         $courseType = $this->common_model->getAllCourseTypeWithoutAyush($prgid);
                     } elseif ($student_type == 1 && $student_course_type == 4) {
                         $courseType = $this->common_model->getAllCourseTypeWithoutAyush($prgid);
                     } elseif ($student_type == 1 && $student_course_type == 9) {
                         $courseType = $this->common_model->getAllCourseTypeWithoutAyush($prgid);
                     } elseif ($student_type == 1 && $student_course_type == 1) {
                         $courseType = $this->common_model->getCourseTypes();
                     } elseif ($student_type == 1 && $student_course_type == 2) {
                         $courseType = $this->common_model->getCourseTypes();
                     }elseif ($student_course_type == 12) {
                         $courseType = $this->common_model->getCourseTypesDiploma();
                     }elseif ($student_course_type == 13) {
                         $courseType = $this->common_model->getCourseTypesDiploma();
                     } else {*/
                         $courseType = $this->common_model->getCourseTypes();
                    // }
					if($registerData[0]['country_of_domicile']=='46' || $registerData[0]['country_of_domicile']=='49'){
                     foreach ($courseType as $ctype) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['course_type'] == $ctype['id']) {
                                 echo '<option selected="selected" value="' . $ctype['id'] . '">' . $ctype['course_type'] . '</option>';
                             } else {
                                 echo '<option value="' . $ctype['id'] . '">' . $ctype['course_type'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $ctype['id'] . '">' . $ctype['course_type'] . '</option>';
                         }
                     }
					 }else{
				 echo '<option value="1">Ayurveda, Yoga, Unani, Siddha and Homeopathy</option>';  
			   }
                     ?>
               </select>
            </div>
            <div class="course_type fade"
               style="display:none;">
               <?php
                  }
                  } else {
                      ?>
               <label for="comment">21. Course Main Stream <span
                  class="text-red">*</span></label>
               <?php
                  $user_data = $this->session->userdata('user_data');
                 $student_type = $user_data['student_type'];
                $student_course_type = $user_data['apply_course_type'];
				  
                  ?>
               <select id="<?php
                  if (($student_type == 1 && $student_course_type == 1) || ($student_type == 1 && $student_course_type == 4) || ($student_type == 1 && $student_course_type == 9) || ($student_type == 1 && $student_course_type == 2) || ($student_type == 1 && $student_course_type == 3) || ($student_type == 1 && $student_course_type == 6) || ($student_type == 1 && $student_course_type == 5) || ($student_type == 1 && $student_course_type == 9) ||($student_type == 1 && $student_course_type == 8) || ($student_type == 1 && $student_course_type == 12) ||( $student_type == 1 && $student_course_type == 13)) {
                      echo 'course_type';
                  }
                  ; ?>"
                  name="course_type"
                  class="form-control capitalLetter">
                  <option value="">Select Main Stream</option>
                  <?php
				if($registerData[0]['country_of_domicile']=='46' || $registerData[0]['country_of_domicile']=='49'){
					 $courseType = $this->common_model->getCourseTypes();
			
                     foreach ($courseType as $ctype) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['course_type'] == $program['id']) {
                                 echo '<option selected="selected" value="' . $program['id'] . '">' . $program['course_type'] . '</option>';
                             } else {
                                 echo '<option value="' . $ctype['id'] . '">' . $ctype['course_type'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $ctype['id'] . '">' . $ctype['course_type'] . '</option>';
                         }
                     }
					  }else{
				 echo '<option value="1">Ayurveda, Yoga, Unani, Siddha and Homeopathy</option>';  
			   }
                     ?>
               </select>
               <?php } ?>
            </div>

            

         </div>

         <?php
            if (count($applicaitonStepOne) > 0 && !empty($applicaitonStepOne[0]['gmat_score'])) {
            
            ?>
         <div class="col-xs-12 col-sm-4 col-md-4 gmat_sc">
            <label title="Enter GMAT Score"
               for="comment">GMAT<span class="text-red">*</span></label>
            <input type="text"
               class="form-control capitalLetter"
               placeholder="GMAT"
               id="gmat_score"
               name="gmat_score"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gmat_score']; ?>" />
         </div>
         <?php
            } else {
            ?>
         <div class="col-xs-12 col-sm-4 col-md-4 gmat_sc"
            style="display:none;">
            <label title="Enter GMAT Score"
               for="comment">GMAT<span class="text-red">*</span></label>
            <input type="text"
               class="form-control capitalLetter"
               placeholder="GMAT"
               id="gmat_score"
               name="gmat_score"
               value="<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['gmat_score']; ?>" />
         </div>
         <?php
            }
            ?>
      </div>

      <div class="formrow">
         <div class="col-xs-12 col-sm-12 col-md-12">
            <label for="comment"
               title="University">22. Universities/Institutes in India where you wish to seek
            admission:<span class="text-red">*</span></label>
            <span class="note1"><strong>Note : </strong>Candidates should be very
            specific and clear about the course of study which he/she wishes to pursue in
            India. Scholarships are not available to pursue more than one course. Candidates
            should ensure that the courses opted are offered by the Universities selected
            under the dropdown menu given below. The candidates must refer to the
            University/Institute website to know the course content/curriculum & eligibility criteria for the courses of
            their choice. Those seeking admission to Ayurveda, Yoga, Unani, Siddha and Homoeopathy course must opt for 
            <b>AYUSH</b> in the University choice.</span>
            <span>Please select University in order of preference.</span>
         </div>
      </div>
 <?php// print_r($applicaitonStepOne[0]);die;?>     
			
			
<div id="courseContainer" class="formrow"
     style="<?php echo !empty($applicaitonStepOne[0]['nomenclature']) ? '' : 'display:none;'; ?>">
 
<?php

	$nomenclatures = $this->common_model->getnomenclatureByType($applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['programme']);
                     			   
if (count($applicaitonStepOne) > 0 && !empty($applicaitonStepOne[0]['nomenclature'])) {
    ?>
	<div class="courseRow row" style="margin-bottom:15px;">
        <!-- Nomenclature -->
        <div class="col-sm-4">
            <label>Nomenclature of Course <span style="color:red;">*</span></label>

            <select name="nomenclature[]"
                    class="form-control nomenclature" data-searchable="true">

                <option value="">Select Nomenclature</option>
                <?php

					 $nomenclatures = $this->common_model->getnomenclatureByType($applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['programme']);
                     
					 foreach ($nomenclatures as $nomen) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['nomenclature'] == $nomen['id']) {
                                 echo '<option selected="selected" value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                         }
                     }
                     ?>
            </select>
        </div>


        <!-- University -->
        <div class="col-sm-6 pdright unidiv">
            <label>
                University Choice
                <span style="color:red;">*</span>
            </label>

         <select name="universty_choice[]" class="form-control universty_choice">
                <option value="">Select</option>
				
				<?php

					 $univs = $this->common_model->getuniversityBynomen($applicaitonStepOne[0]['nomenclature'],$applicaitonStepOne[0]['course_type']);
                     foreach ($univs as $univ) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['universty_choice'] == $univ['id']) {
                                 echo '<option selected="selected" value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
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
if (count($applicaitonStepOne) > 0 && !empty($applicaitonStepOne[0]['nomenclature_two'])) {
    ?>
	<div class="courseRow row" style="margin-bottom:15px;">
        <!-- Nomenclature -->
        <div class="col-sm-4">
            <label>Nomenclature of Course <span style="color:red;">*</span></label>

            <select name="nomenclature[]"
                    class="form-control nomenclature" data-searchable="true">

                <option value="">Select Nomenclature</option>
                <?php

					 $nomenclatures = $this->common_model->getnomenclatureByType($applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['programme']);
                     foreach ($nomenclatures as $nomen) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['nomenclature_two'] == $nomen['id']) {
                                 echo '<option selected="selected" value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                         }
                     }
                     ?>
            </select>
        </div>


        <!-- University -->
        <div class="col-sm-6 pdright unidiv">
            <label>
                University Choice
                <span style="color:red;">*</span>
            </label>

         <select name="universty_choice[]" class="form-control universty_choice">
                <option value="">Select</option>
				
				<?php

					 $univs = $this->common_model->getuniversityBynomen($applicaitonStepOne[0]['nomenclature_two'],$applicaitonStepOne[0]['course_type']);
                     foreach ($univs as $univ) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['universty_choice_two'] == $univ['id']) {
                                 echo '<option selected="selected" value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
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
if (count($applicaitonStepOne) > 0 && !empty($applicaitonStepOne[0]['nomenclature_three'])) {
    ?>
	<div class="courseRow row" style="margin-bottom:15px;">
        <!-- Nomenclature -->
        <div class="col-sm-4">
            <label>Nomenclature of Course <span style="color:red;">*</span></label>

            <select name="nomenclature[]"
                    class="form-control nomenclature" data-searchable="true">

                <option value="">Select Nomenclature</option>
                <?php

					 $nomenclatures = $this->common_model->getnomenclatureByType($applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['programme']);
                     foreach ($nomenclatures as $nomen) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['nomenclature_three'] == $nomen['id']) {
                                 echo '<option selected="selected" value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                         }
                     }
                     ?>
            </select>
        </div>


        <!-- University -->
        <div class="col-sm-6 pdright unidiv">
            <label>
                University Choice
                <span style="color:red;">*</span>
            </label>

         <select name="universty_choice[]" class="form-control universty_choice">
                <option value="">Select</option>
				
				<?php

					 $univs = $this->common_model->getuniversityBynomen($applicaitonStepOne[0]['nomenclature_three'],$applicaitonStepOne[0]['course_type']);
                     foreach ($univs as $univ) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['universty_choice_three'] == $univ['id']) {
                                 echo '<option selected="selected" value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
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
if (count($applicaitonStepOne) > 0 && !empty($applicaitonStepOne[0]['nomenclature_fourth'])) {
    ?>
	<div class="courseRow row" style="margin-bottom:15px;">
        <!-- Nomenclature -->
        <div class="col-sm-4">
            <label>Nomenclature of Course <span style="color:red;">*</span></label>

            <select name="nomenclature[]"
                    class="form-control nomenclature" data-searchable="true">

                <option value="">Select Nomenclature</option>
                <?php

					 $nomenclatures = $this->common_model->getnomenclatureByType($applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['programme']);
                     foreach ($nomenclatures as $nomen) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['nomenclature_fourth'] == $nomen['id']) {
                                 echo '<option selected="selected" value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                         }
                     }
                     ?>
            </select>
        </div>


        <!-- University -->
        <div class="col-sm-6 pdright unidiv">
            <label>
                University Choice
                <span style="color:red;">*</span>
            </label>

         <select name="universty_choice[]" class="form-control universty_choice">
                <option value="">Select</option>
				
				<?php

					 $univs = $this->common_model->getuniversityBynomen($applicaitonStepOne[0]['nomenclature_fourth'],$applicaitonStepOne[0]['course_type']);
                     foreach ($univs as $univ) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['universty_choice_fourth'] == $univ['id']) {
                                 echo '<option selected="selected" value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
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
if (count($applicaitonStepOne) > 0 && !empty($applicaitonStepOne[0]['nomenclature_fifth'])) {
    ?>
	<div class="courseRow row" style="margin-bottom:15px;">
        <!-- Nomenclature -->
        <div class="col-sm-4">
            <label>Nomenclature of Course <span style="color:red;">*</span></label>

            <select name="nomenclature[]"
                    class="form-control nomenclature" data-searchable="true">

                <option value="">Select Nomenclature</option>
                <?php

					 $nomenclatures = $this->common_model->getnomenclatureByType($applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['programme']);
                     foreach ($nomenclatures as $nomen) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['nomenclature_fifth'] == $nomen['id']) {
                                 echo '<option selected="selected" value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';
                         }
                     }
                     ?>
            </select>
        </div>


        <!-- University -->
        <div class="col-sm-6 pdright unidiv">
            <label>
                University Choice
                <span style="color:red;">*</span>
            </label>

         <select name="universty_choice[]" class="form-control universty_choice">
                <option value="">Select</option>
				
				<?php

					 $univs = $this->common_model->getuniversityBynomen($applicaitonStepOne[0]['nomenclature_fifth'],$applicaitonStepOne[0]['course_type']);
                     foreach ($univs as $univ) {
                         if (!empty($applicaitonStepOne)) {
                             if ($applicaitonStepOne[0]['universty_choice_fifth'] == $univ['id']) {
                                 echo '<option selected="selected" value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             } else {
                                 echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                             }
                         } else {
                             echo '<option value="' . $univ['id'] . '">' . $univ['title'] . '</option>';
                         }
                     }
                     ?>
            </select>

           
        </div>
</div>

<?php
  
} else{
?>
   <!-- If no saved data show empty row -->
   <div class="courseRow row" style="margin-bottom:15px;">
        <div class="col-sm-4">
            <label>Nomenclature of Course<span style="color:red;">*</span></label>

            <select name="nomenclature[]"
                    class="form-control nomenclature" data-searchable="true">

                <option value="">Select Nomenclature</option>
                <?php

					 $nomenclatures = $this->common_model->getnomenclatureByType($applicaitonStepOne[0]['course_type'],$applicaitonStepOne[0]['programme']);
                     foreach ($nomenclatures as $nomen) {
                      echo '<option value="' . $nomen['id'] . '">' . $nomen['title'] . '</option>';                         
                     }
                     ?>
            </select>
        </div>

        <div class="col-sm-6">
            <label>University Choice <span style="color:red;">*</span></label>
            <select name="universty_choice[]" class="form-control universty_choice">
                <option value="">Select</option>
            </select>
        </div>
		 <!-- Buttons -->
        <div class="col-sm-2" style="margin-top:25px;">
            <button type="button" class="btn btn-success addRow">+</button>
            <button type="button" class="btn btn-danger removeRow" style="display:none;">x</button>
        </div>

    </div>
<?php
  
} 
?>



</div>
<div id="passportUploadsPic" class="modal fade" role="dialog">
    <div class="modal-dialog popup" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Passport</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Select Passport File</label>
                    <input type="file"
                           name="passport_file"
                           id="passport_file"
                           class="form-control"
                           accept=".jpg,.jpeg,.png">
                    <small style="color:#666;">
                        Only JPG, JPEG, PNG allowed. Max size: 2 MB
                    </small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="passportUploadBtn" class="btn btn-primary">Use This File</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

         
                  <div class="name-sec col-xs-2 col-sm-2 col-md-2 pull-right mt-2">
                     <input type="submit"
                        id="step-one-application"
                        name="step-one-application"
                        class="form-control sbmt"
                        value="Next >>" />
                  </div>
                  <?php
                     if (!empty($applicaitonStepOne)) {
                     ?>
                  <div
                     class="name-sec col-xs-2 col-sm-2 col-md-2 pull-right mt-2">
                     <a href="<?php echo site_url(); ?>applicant/view_personal_info?appno=<?php echo $applicaitonStepOne[0]['application_no']; ?>"
                        target="_blank"
                        class="form-control sbmt">Preview</a>
                  </div>
                  <?php
                     } else {
                     ?>
                  <div
                     class="name-sec col-xs-2 col-sm-2 col-md-2 pull-right mt-2">
                     <a href="javascript:void(0);"
                        class="form-control sbmt"
                        disabled>Preview</a>
                  </div>
                  <?php
                     }
                     ?>
               
             
   </form>
   </div>
   </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade"
   id="modalForm"
   role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button"
               class="close"
               data-dismiss="modal">&times;</button>
            <h4 class="modal-title">INFORMATION</h4>
            <span style="color:red;"><b>Please select the Subject only (For Instance- English, Economics, Botany etc) from the Universities/Institutes website as from now onwards, only the Subjects will be Appear on the Portal and the Courses correspond to the selected subject will be alotted by the respective Universities</b></span>
         </div>
         <div class="modal-body">
         </div>
         <div class="modal-footer">
            <!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
            <!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
         </div>
      </div>
   </div>
</div>

<div id="profileUploadsPic"
   class="modal fade"
   role="dialog">
   <div id="profilePic"
      class="modal-dialog popup dropzone">
      <div class="dz-message"
         data-dz-message><span>Click/Drop PNG/JPG/JPEG file to upload</span></div>
   </div>
</div>

<script>
   $('#profilePic').dropzone({
       url: baseURL + "applicant/uploadProfilePic",
       uploadMultiple: false,
       dictDefaultMessage: "Click / Drop here to upload files"
   });
   
$(document).ready(function () {

    $("#passportUploadBtn").on("click", function () {
        var input = $("#passport_file")[0];

        if (input.files.length === 0) {
            alert("Please select a passport file.");
            return false;
        }

        var file = input.files[0];
        var fileName = file.name.toLowerCase();
        var fileSize = file.size / 1024 / 1024;

        if (!fileName.match(/\.(jpg|jpeg|png)$/)) {
            alert("Only JPG, JPEG, and PNG files are allowed.");
            $("#passport_file").val("");
            return false;
        }

        if (fileSize > 2) {
            alert("File size must be less than or equal to 2 MB.");
            $("#passport_file").val("");
            return false;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            $("#passport_image_div").attr("src", e.target.result).show();
        };
        reader.readAsDataURL(file);

        $("#passportUploadsPic").modal("hide");
    });

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
           $('.eng').show();
       } else {
		    $('.eng_score').hide();
           $('.eng').hide();
       }
   }
   
   function courseDuration(str) {
       //alert('h1');
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
       }
   }
   
   
   
   
   function getCourseData(str) {
       //alert('h1');
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
		   $('.eng').show();
       } else {
           $('.eng_score3').hide();
		   $('.eng').hide();
   
       }
   }
   
   function showEnglishlevel4(str) {
       if (str == 1) {
           $('.eng_score4').show();
		   $('.eng').show();
       } else {
           $('.eng_score4').hide();
		   $('.eng').hide();
   
       }
   }
   
   
   
   
   
   $(document).ready(function() {
   
       if ($("#is_toefl").val() == 1) {
           showEnglishlevel2($("#is_toefl").val());
       }
       if ($("#is_ielts").val() == 1) {
           showEnglishlevel3($("#is_ielts").val());
       }
   
       if ($("#is_duolingo").val() == 1) {
           showEnglishlevel4($("#is_duolingo").val());
       }
   
   
       $checks = $(":checkbox");
       $checks.on('change', function() {
           var string = $checks.filter(":checked").map(function(i, v) {
               return parseInt(this.value);
           }).get().join(" ");
           $('#phone').val(string);
       });
   });
</script>
<script>
$(document).ready(function () {

    var maxRows = 5;

    // Add Row
    $(document).on("click", ".addRow", function () {

        var rowCount = $(".courseRow").length;

        if (rowCount >= maxRows) {
            alert("Maximum 5 choices allowed.");
            return;
        }

        var $lastRow = $(".courseRow").last();
        var $newRow = $lastRow.clone();

        // Clear dropdowns
        $newRow.find("select").val("");

        $("#courseContainer").append($newRow);

        updateNumbering();
        updateButtons();
    });

    // Remove Row
    $(document).on("click", ".removeRow", function () {
        $(this).closest(".courseRow").remove();
        updateNumbering();
        updateButtons();
    });

    function updateNumbering() {
        $(".courseRow").each(function (index) {
            $(this).find(".choiceTitle").text("Choice " + (index + 1));
        });
    }

    function updateButtons() {

        var total = $(".courseRow").length;

        // Show remove button only if more than 1 row
        if (total == 1) {
            $(".removeRow").hide();
        } else {
            $(".removeRow").show();
        }

        // Hide Add button on last row if max reached
        if (total >= maxRows) {
            $(".addRow").hide();
        } else {
            $(".addRow").show();
        }
    }

});
</script>
<script>
var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
</script>

<?php
// Searchable Nomenclature dropdown - see assets/site/main/js/iccr-searchable-select.js.
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/main/css/iccr-searchable-select.css?v=20260925b">
<script src="<?php echo base_url(); ?>assets/site/main/js/iccr-searchable-select.js?v=20260925b"></script>

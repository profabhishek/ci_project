<?php
 //phpinfo(); 
?>
<style>
  .progress {
    border: 1px solid #cecece;
    height: 22px;
    margin-top: 5px;
  }

  .alert {
    margin: 12px auto 8px;
    width: 85.5%;
  }

  .note {
    color: red;
    float: left;
    font-size: 10px;
    font-weight: normal;
    margin-left: 0;
    padding: 0;
    text-align: justify !important;
  }

  #pswd_info {
    background: #fefefe none repeat scroll 0 0;
    border: 0 none;
    border-radius: 5px;
    bottom: 0;
    box-shadow: 0 1px 3px #ccc;
    font-size: 0.875em;
    height: 174px;
    padding: 11px;
    position: absolute;
    right: 0;
    top: 68px;
    width: 318px;
    max-width: 90vw;
  }

  #pswd_info h4 {
    border-bottom: 1px solid #cecece;
    font-size: 15px;
    font-weight: bold;
    margin: 0 auto 3px;
    padding: 0 0 6px;
    text-align: center;
    width: 98%;
  }

  #pswd_info ul {
    height: 112px;
  }

  #pswd_info::before {
    content: "\25B2";
    position: absolute;
    top: -12px;
    left: 45%;
    font-size: 14px;
    line-height: 14px;
    color: #ddd;
    text-shadow: none;
  }

  .invalid {
    background: url("../assets/site/main/img/invalid.png") no-repeat 0 50%;
    padding-left: 22px;
    line-height: 24px;
    color: #ec3f41;
    float: left;
    width: 100%;
  }

  .valid {
    content: "\2713";
    background: rgba(0, 0, 0, 0) url("../assets/site/main/img/valid.png") no-repeat scroll 0 50%;
    color: #3a7d34;
    float: left;
    line-height: 24px;
    padding-left: 22px;
    width: 100%;
  }

  #pswd_info {
    display: none;
  }

  .note {
    color: red;
    float: left;
    font-size: 13px;
    font-weight: bold;
    margin-left: 0;
    padding: 0;
    text-align: justify !important;
  }

  .col-xs-10.form_head {
    margin-bottom: 140px;
  }

  .container .box.col-xs-6 {
    padding-top: 25px;
  }

  .capitalLetter:valid {
    text-transform: uppercase;
  }

  /* .capitalLetter::placeholder { text-transform: capitalize; } */
</style>

<link rel="stylesheet" href="<?php echo site_url(); ?>assets/site/main/css/intlTelInput.css" />


<section class="meacontent">
<div class="col-xs-10 form_head">
    <img src="<?php echo site_url(); ?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
	<h3 class="text-center caps" style="color:blue">WELCOME TO A2A PORTAL</h3>
    <h3 class="text-center caps">ICCR SCHOLARSHIP PROGRAMME 2026-27</h3>
    <h5 class="text-center">STUDENT REGISTRATION FORM</h5>
    <h5 class="text-center" style="color:#ffff12;font-size:23px;font-weight:bold;text-shadow:2px 2px 4px #000;">Please Read Guidelines Before Registration</h5>
    <span class="text-center" style="color:red;font-size:18px;font-weight:bold;padding:13px 0;display: block;text-decoration: underline;">Applicant must note that the information to be provided by him/her on the A2A Portal should be correct and match with the supporting documents to be uploaded in the courses of application and verified by the Indian Mission and the Universities/Institutions at the time of award of scholarship/admission at the time of joining.
	If any information found to be incorrect in any manner whatsoever, at any stage of the scholarship, application will be REJECTED immediately without any intimation.
	Falsification of data or multiple applications will lead to automatic REJECTION of application at any stage of the scholarship process.
       </span>
    <!-- <span class="text-center" style="color:#00a716;font-size:16px;font-weight:bold;"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png"
                    alt="new gif Image"> Before apply, kindly first register on <a href="https://studyinindia.gov.in" target="_blank">Study In India (SII)</a> portal.</span>  
    <span class="text-center" style="color:Blue;font-size:15px;font-weight:bold;padding:8px 0;display:block;text-decoration:underline;">Applicants from Bangladesh are requested to kindly first register at Suborno Jayanti Portal (https://sjsdhaka.gov.in) and thereafter on A2A Portal for the ICCR Scholarship.</span>--> 
    </div>
  <?php
  if ($this->session->flashdata('message_type') == "success") {
  ?>
    <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
    </div>
  <?php
  }
  if ($this->session->flashdata('message_type') == "error") {
  ?>
    <div class="alert alert-error" role="alert" tabindex="-1" id="formErrorBox">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
    </div>
    <script>
    // Move keyboard / screen-reader focus to the error message
    document.addEventListener('DOMContentLoaded', function () {
      var b = document.getElementById('formErrorBox');
      if (b) { b.scrollIntoView({block: 'center'}); b.focus(); }
    });
    </script>
  <?php
  }

  ?>

  <div class="container" style="padding:0;min-height: 396px;">
    <div class="box col-xs-6" style="margin-top: 60px;">
      <!-- form start -->
      <form id="identicalForm" action="<?php echo site_url(); ?>index.php/user/register" onsubmit="return validate_registration();" enctype="multipart/form-data" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
        <div class="box-body">

          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

               
          <div class="col-xs-2 col-md-3 col-sm-3">
            <label for="student_title">Title <span class="text-red">*</span></label>
            <select id="student_title" name="student_title" class="selectpicker form-control" required="true">
              <?php
              $title = '';
              if ($applicaitonStepOne > 0) {
                $title = $applicaitonStepOne[0]['student_title'];
              }
              if ($title == 1) {
              ?>
                <option value="">Title</option>
                <option selected="selected" value="1">Mr</option>
                <option value="2">Ms</option>
                
              <?php
              }  else if ($title == 2) {
              ?>
                <option value="">Title</option>
                <option value="1">Mr</option>
                <option selected="selected" value="2">Ms</option>
                
              <?php
              } else {
              ?>
                <option value="">Title</option>
                <option value="1">Mr</option>
                <option value="2">Ms</option>
                
              <?php
              }
              ?>
            </select>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="gender">Gender <span class="text-red">*</span></label>
            <div class="form-group">

              <select class="form-control select2" title="Select your gender (Male/Female) as per your official records." name="gender" id="gender" style="width: 100%;" read only required="true">
                <option value="">Select</option>
                <option value="1">M</option>
                <option value="2">F</option>
              </select>
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="country">Nationality<span class="text-red">*</span></label>
            <div class="form-group">

              <select class="form-control select2" title="Mention your nationality/citizenship (e.g., Nepalese, Bangladeshi, Sri Lankan)." name="country" id="country" style="width: 100%;" required="true">
                <option value="">Select</option>
                <?php
                $countries = $this->common_model->getCountriesByIdNotInCurrent();
                foreach ($countries as $country) {

                  echo '<option value="' . $country['id'] . '">' . $country['country_name'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
<div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft1">
              <label for="dob">Date of Birth (MM/DD/YYYY) <span class="text-red">*</span></label>

              <!-- Single date input -->
              <input type="date" class="form-control" id="dob" name="dob" min="1900-01-01" max="2008-07-01" title="Note: If the date of birth is found to be different from the DOB in the passport column at any stage, your application/scholarship will be cancelled." required>

              <!-- Hidden fields for existing backend -->
              <input type="hidden" id="applicant_date" name="applicant_date">
              <input type="hidden" id="applicant_month" name="applicant_month">
              <input type="hidden" id="applicant_year" name="applicant_year">
          </div>

<script>
document.getElementById('dob').addEventListener('change', function () {
    if (!this.value) return;

    const [year, month, day] = this.value.split("-");

    // Set hidden fields
    document.getElementById('applicant_date').value = day;
    document.getElementById('applicant_month').value = month;
    document.getElementById('applicant_year').value = year;

    // =====================
    // AGE VALIDATION (18+ as on 01/07/2026)
    // =====================

    const dob = new Date(year, month - 1, day);

    // Fixed reference date ? 1 July 2026
    const referenceDate = new Date(2026, 6, 1); // Month is 0-based (6 = July)

    let age = referenceDate.getFullYear() - dob.getFullYear();
    const monthDiff = referenceDate.getMonth() - dob.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && referenceDate.getDate() < dob.getDate())) {
        age--;
    }

    // D-01: upper age limit per programme (same table as helpers/a2a_eligibility_helper.php)
    // Diploma/Certificate (12,13 - languages & performing arts): no ICCR upper limit
    var A2A_MAX_AGE = {1:35, 2:35, 4:40, 8:40, 12:null, 13:null};
    var ctSel = document.getElementById('apply_course_type');
    var maxAge = (ctSel && ctSel.value in A2A_MAX_AGE) ? A2A_MAX_AGE[ctSel.value] : 40;

    if (age < 18) {
        alert('Applicant must be at least 18 years old as on 01 July 2026.');
        document.getElementById('dob').value = ''; // clear DOB instead of reload
    } else if (maxAge !== null && (age > maxAge || (age === maxAge && (monthDiff !== 0 || referenceDate.getDate() !== dob.getDate())))) {
        alert('For the selected programme the maximum age is ' + maxAge + ' years as on 01 July 2026.');
        document.getElementById('dob').value = '';
    }
});
// Re-check the DOB when the programme changes (select2 fires jQuery change)
document.addEventListener('DOMContentLoaded', function () {
    var ct = document.getElementById('apply_course_type');
    if (!ct) return;
    var recheck = function () {
        var d = document.getElementById('dob');
        if (d && d.value) { d.dispatchEvent(new Event('change')); }
    };
    if (window.jQuery) { jQuery(ct).on('change', recheck); }
    else { ct.addEventListener('change', recheck); }
});
</script>



          </div>
        
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="mobile_no">Mobile Number <span class="text-red">*</span></label>
            <!-- <span class="note">Please enter country code before your mobile no. Like +91 for India</span> -->
            <div class="form-group">
              <input type="text" class="form-control" id="mobile_no" pattern="^[0-9\+]+$" title="Provide your active mobile number with country code. This will be used for communication." name="mobile_no" placeholder="Like +918750859869" required="true" maxlength="20">
              <!-- <span class="note">Please enter country code before your mobile no. Like +91 for India</span> -->
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-2 col-md-3">
            <label for="emailId">Email address <span class="text-red">*</span></label>
            <div class="form-group">
              <input type="email" class="form-control" id="emailId" title="Note: Please note that all updates will be sent on the mail address provided in this column. ICCR will not be responsible if it is incorrect or invalid. No changes would be allowed in this column at any stage." name="emailId" placeholder="Enter email" required="true" maxlength="40" re>
            </div>
          </div>
        
        
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="student_fname">First Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="student_fname" pattern="^[a-zA-Z ]+$" title="Enter your first name exactly as it appears on your passport." name="student_fname" placeholder="Enter First Name" required="true" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="student_mname">Middle Name </label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="student_mname" pattern="^[a-zA-Z ]+$" title="If you have a middle name, enter it here. Leave blank if not applicable." name="student_mname" placeholder="Enter Middle Name" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="student_lname">Last Name<span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="student_lname" pattern="^[a-zA-Z ]+$" title="Enter your family/surname as per your passport." name="student_lname" placeholder="Enter Last Name" required="true" maxlength="15">
            </div>
          </div>
		            <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="unique_id">Citizenship/Local/Domestic Number<span class="text-red">*</span></label>
            <div class="form-group">
              <input type="text" class="form-control capitalLetter" title="Provide your National identity number/Local ID issued by your country as identity proof." id="unique_id" name="unique_id" placeholder="Citizenship/Unique ID" required="true" maxlength="20" pattern="^[A-Za-z0-9\/\-]{3,20}$"/>
            </div>
          </div>
        <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="parentdetail">Parent Details <span class="text-red">*</span></label>
            <div class="form-group">

              <select class="form-control select2" title="Select your Parent Details" name="parent_type" id="parentdetail" style="width: 100%;"  required="true">
                <option value="">Select</option>
                <option value="1">Father</option>
                <option value="2">Mother</option>
                <option value="3">Father &amp; Mother</option>
                <option value="4">Gaurdian</option>
              </select>
            </div>
          </div>

          <div id="father_section">
          <div class="name-sec col-xs-12 col-sm-3 col-md-3" >
            <label for="father_fname">Father's First Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="father_fname" pattern="^[a-zA-Z ]+$" title="Enter your father’s first name." name="father_fname" placeholder="Enter First Name" required="true" maxlength="15">
            </div>
          </div>
          
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="father_mname">Father's Middle Name </label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="father_mname" pattern="^[a-zA-Z ]+$" title="Provide your father’s middle name (if any). Leave blank if not applicable." name="father_mname" placeholder="Enter Middle Name" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="father_lname">Father's Last Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="father_lname" pattern="^[a-zA-Z ]+$" title="Enter your father’s surname/family name." name="father_lname" placeholder="Enter Last Name" required="true" maxlength="15">
            </div>
          </div>
        </div>
        <div id="mother_section">
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="mother_fname">Mother's First Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="mother_fname" pattern="^[a-zA-Z ]+$" title="Enter your mother’s first name." name="mother_fname" placeholder="Enter First Name" required="true" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="mother_mname">Mother's Middle Name </label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="mother_mname" pattern="^[a-zA-Z ]+$" title="Provide your mothers middle name (if any). Leave blank if not applicable." name="mother_mname" placeholder="Enter Middle Name" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="mother_lname">Mother's Last Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="mother_lname" pattern="^[a-zA-Z ]+$" title="Enter your mother’s surname/family name." name="mother_lname" placeholder="Enter Last Name" required="true" maxlength="15">
            </div>
          </div>
        </div>
<div id="guardian_section" style="display:none;">
   <div class="name-sec col-xs-12 col-sm-3 col-md-3">
      <label>Guardian's First Name <span class="text-red">*</span></label>
      <input class="form-control capitalLetter" name="gurdian_fname" id="guardian_fname" maxlength="15" pattern="^[a-zA-Z ]+$" title="Provide your guardian’s first name"  placeholder="Enter First Name" required="true">
   </div>
  <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="gurdian_mname">Guardian's Middle Name </label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="gurdian_mname" pattern="^[a-zA-Z ]+$" title="Provide your guardian’s middle name (if any). Leave blank if not applicable." name="gurdian_mname" placeholder="Enter Middle Name" maxlength="15" required="false">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="gurdian_lname">Guardian's Last Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="gurdian_lname" pattern="^[a-zA-Z ]+$" title="Enter your guardians surname/family name." name="gurdian_lname" placeholder="Enter Last Name"  maxlength="15">
            </div>
          </div>
</div>




          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="apply_course_type">Apply For<span class="text-red">*</span></label>
            <div class="form-group">

              <select class="form-control select2" name="apply_course_type" id="apply_course_type" title="Select the program/level you are applying for-> UG(18-35), PG(18-35), PhD(18-40), Diploma/Certificate in Languages/Performing Arts (18+, no ICCR upper limit). Age as on 01 July 2026." style="width: 100%;" required="true">
                <option value="">Select</option>
                <option value="1">UG(Ayush Scholarship)</option>
                <option value="2">PG(Ayush Scholarship)</option>
                <option value="4">PhD(upto 40 yrs)</option>
				<option value="8">PhD(Ayush Scholarship)</option>
                <option value="12">Diploma (only for Languages and Performing Arts)(18+ yrs) </option>
                <option value="13">Certificate (only for Languages and Performing Arts)(18+ yrs) </option>                
              </select>
            </div>
          </div>


          <!-- <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="apply_indian_course_type">Select Course<span class="text-red">*</span></label>
            <div class="form-group">

              <select class="form-control select2" name="apply_indian_course_type" id="apply_indian_course_type" style="width: 100%;" required="true">
                <option value="">Select</option>
                <option value="1">General Courses</option>
                <option value="2">Hindi Course</option>
                <option value="3">Sanskrit Course</option>
                <option value="4">Indian Art</option>
                <option value="5">Indian Painting</option>
                <option value="6">Indian Culture</option>
                <option value="7">Indian Religion</option>
              </select>
            </div>
          </div> -->


          <!--<div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft1">
            <label for="applicant_date">Date of Birth (DD/MM/YYYY) <span class="text-red">*</span></label>
            <div class="form-group col-md-4 pdleft">
              <select class="form-control" id="applicant_date" name="applicant_date" title="Note: If the date of birth is found to be different from the DOB in the passport column at any stage, your application/scholarship will be cancelled." required="true">
                <option value="">Date</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              </select>-->
              <!-- <input  class="form-control datepicker_register" readonly="true" data-provide="datepicker_register" id="dob" name="dob" placeholder="Enter Date of Birth" required="true">-->
           <!-- </div>
            <div class="form-group col-md-4 pdleft">
              <select class="form-control" id="applicant_month" name="applicant_month" required="true">
                <option value="">Month</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>
            <div class="form-group col-md-4 pdleft" style="padding-right:0;">
              <select class="form-control" id="applicant_year" name="applicant_year" onchange="validateDob();" required="true">
                <option value="">Year</option>
                <option value="1957">1957</option>
                <option value="1958">1958</option>
                <option value="1959">1959</option>
                <option value="1960">1960</option>
                <option value="1961">1961</option>
                <option value="1962">1962</option>
                <option value="1963">1963</option>
                <option value="1964">1964</option>
                <option value="1965">1965</option>
                <option value="1966">1966</option>
                <option value="1967">1967</option>
                <option value="1968">1968</option>
                <option value="1969">1969</option>
                <option value="1970">1970</option>
                <option value="1971">1971</option>
                <option value="1972">1972</option>
                <option value="1973">1973</option>
                <option value="1974">1974</option>
                <option value="1975">1975</option>
                <option value="1976">1976</option>
                <option value="1977">1977</option>
                <option value="1978">1978</option>
                <option value="1979">1979</option>
                <option value="1980">1980</option>
                <option value="1981">1981</option>
                <option value="1982">1982</option>
                <option value="1983">1983</option>
                <option value="1984">1984</option>
                <option value="1985">1985</option>
                <option value="1986">1986</option>
                <option value="1987">1987</option>
                <option value="1988">1988</option>
                <option value="1989">1989</option>
                <option value="1990">1990</option>
                <option value="1991">1991</option>
                <option value="1992">1992</option>
                <option value="1993">1993</option>
                <option value="1994">1994</option>
                <option value="1995">1995</option>
                <option value="1996">1996</option>
                <option value="1997">1997</option>
                <option value="1998">1998</option>
                <option value="1999">1999</option>
                <option value="2000">2000</option>
                <option value="2001">2001</option>
                <option value="2002">2002</option>
                <option value="2003">2003</option>
                <option value="2004">2004</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
              </select>
            </div>-->
          
          	
        

          <div class="name-sec col-xs-12 col-sm-2 col-md-3">
            <label for="password">Password <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control" type="password" id="password" title="Create a strong password for your application portal login. Using  letters, numbers, and special characters." name="password" placeholder="Enter Password" required="true" maxlength="40" aria-describedby="pswd_info" autocomplete="new-password">
              <div id="pswd_info" aria-live="polite">
                <h4>Password must meet below requirements:</h4>
                <ul>
                  <li id="letter" class="invalid">At least <strong>one small letter</strong></li>
                  <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
                  <li id="number" class="invalid">At least <strong>one numeric value</strong></li>
                  <li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
                  <li id="specChar" class="invalid">At least <strong>one special character</strong></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-2 col-md-3">
            <label for="cpassword">Confirm Password <span class="text-red">*</span></label>
            <div class="form-group">

              <input type="password" data-fv-identical="true" data-fv-identical-field="password" data-fv-identical-message="The password and its confirm are not the same" title="Re-enter the same password to confirm it. Both must match." class="form-control" id="cpassword" name="cpassword" placeholder="Re-Enter Password" required="true" autocomplete="new-password">
              <span class="note cpassmatch" role="status" aria-live="polite"></span>
            </div>
          </div>
		  
		  <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="passport_no">Passport No. <span class="text-red">*</span></label>
            <div class="form-group">
              <input type="text" class="form-control capitalLetter" title="Note: If there is any discrepancy in the passport at any stage, your application/scholarship will be cancelled.
Note: Please note that no Local Ids to be mentioned in this column." id="passport_no" name="passport_no" placeholder="Enter Passport" maxlength="10" pattern="^[A-Za-z0-9]{6,10}$" required="true">
            </div>
          </div>
          
          <div class="name-sec col-xs-12 col-sm-2 col-md-3">
            <label for="fileInput">Upload Passport Image(jpg|jpeg|png)(max 1 MB)<span class="text-red">*</span></label>
            <div class="form-group">
			<input type="file" name="passport" id="fileInput" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="form-control" title="Note: Upload your passport image. No other file shpuld be uploaded." required>
              
            </div>
          </div>

          
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label id="isindian_label">Currently Staying In India <span class="text-red">*</span></label>
            <div class="form-group" role="radiogroup" aria-labelledby="isindian_label">
              <input value="1" type="radio" name="isindian" title="Select Yes if you are presently residing in India, otherwise select No." required="true"> Yes
              <input class="minimal" checked="true" value="2" type="radio" name="isindian" required="true"> No
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="userCaptcha">Enter Text as Displayed Below <span class="text-red">*</span></label><br>
            <div class="form-group col-md-6 pdleft">
              <input type="text" autocomplete="off" title="Type the characters shown in the image/text box (captcha) to verify that you are a genuine applicant." name="userCaptcha" id="userCaptcha" class="form-control" required placeholder="Enter text" required="true" maxlength="5" />
            </div>
            <a href="javascript:void(0);" id="refreshImg" class="reload-captcha" role="button" aria-label="Show a new captcha image">&nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></a>
            <div class="form-group col-md-6">
              <img id="captchid" src="<?php echo $captcha['image_src']; ?>" alt="Captcha: type the letters shown in this image" style="max-width:100%;height:auto;"/>
            </div>
          </div>
        </div>

        <div class="col-xs-12" style="margin:8px 0 4px;">
          <div class="checkbox">
            <label for="guidelines_ack" style="font-weight:normal;">
              <input type="checkbox" id="guidelines_ack" name="guidelines_ack" value="1" required="true">
              I have read the <a href="<?php echo base_url(); ?>assets/site/docs/Policy_Guidelines.pdf" target="_blank" rel="noopener noreferrer">Scholarship Guidelines (PDF, opens in a new tab)</a>
              and confirm that the information I give is correct. <span class="text-red">*</span>
            </label>
          </div>
        </div>

        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </div>
      </form>

      <!--<a href="http://a2ascholarships.iccr.gov.in/home/sfs_register"> For Afghanistan Strudents - Click Here</a> -->
    </div>
    <!-- /.box -->

  </div>

</section>

<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 1030px; max-width: 95vw;
    margin-left: -190px;">
      <div class="modal-header">
        <h5 class="modal-title">
          <h5 class="text-center" style="color:#dd0e0e;font-size:23px;font-weight:bold;">Please Read Guidelines Before Registration</h5>
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <span class="text-center" style="color:red;font-size:18px;font-weight:bold;padding:13px 0;display: block;text-decoration: underline;">Applicant must note that the information to be provided by him/her on the A2A Portal should be correct and match with the supporting documents to be uploaded in the course of application and verified by the Indian Mission and the University/Institution at the time of award of scholarship/admission at the time of joining.</br>  
If any information found to be incorrect in any manner whatsoever, at any stage of the scholarship, application will be REJECTED immediately without any intimation.</br>  
Falsification of data or multiple applications will lead to automatic REJECTION of application at any stage of the scholarship process.</span>

      </div>
    </div>
  </div>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" id="modalButton" data-target="#otpModal" style="display: none;">
  Launch demo modal
</button>
<div id="otpModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <h5 class="text-center" style="color:#dd0e0e;font-size:23px;font-weight:bold;">Verify the OTP sent on Email Id</h5>
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="row">
            <div class="col-lg-12">
              <div class="col-lg-10">
                <input type="text" class="form-control" name="sentOtp" id="sentOtp" value="" style="display: none;">
                <input type="number" class="form-control" name="otp" id="inputOtp" required>    
                <p style="color: red;" id="errorid"></p>		
                <p style="color: green;" id="succesid"></p>
 		
           </div>
			      <!--<div class="col-lg-2">
              <button type="button" class="btn btn-primary" id="otpSubmitButton">Submit</button>
              </div>-->
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Bangladesh Info Modal -->
<div class="modal fade" id="bangladeshModal" tabindex="-1" role="dialog" aria-labelledby="bangladeshModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="bangladeshModalLabel">Important Notice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        Applicants from Bangladesh are requested to kindly first register at 
        <strong>Suborno Jayanti Portal</strong> 
        (<a href="https://sjsdhaka.gov.in" target="_blank">https://sjsdhaka.gov.in</a>) 
        and thereafter on A2A Portal for the ICCR Scholarship.
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="https://sjsdhaka.gov.in" target="_blank" class="btn btn-primary">
          Go to Portal
        </a>
      </div>
      
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/site/main/js/intlTelInput.min.js"></script>
<!--  <script type="text/javascript" src="<?php echo site_url(); ?>assets/site/main/js/bootstrapPasswordStrengthMeter.js"></script>
<script src="<?php echo site_url(); ?>assets/site/main/js/zxcvbn.js"></script>-->
<script type="text/javascript">
  $("#mobile_no").intlTelInput({
    allowDropdown: false,
    // autoHideDialCode: false,
    // autoPlaceholder: "off",
    // dropdownContainer: "body",
    // excludeCountries: ["us"],
    // formatOnDisplay: false,
    // geoIpLookup: function(callback) {
    //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
    //     var countryCode = (resp && resp.country) ? resp.country : "";
    //     callback(countryCode);
    //   });
    // },
    // initialCountry: "auto",
    // nationalMode: false,
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    // placeholderNumberType: "MOBILE",
    // preferredCountries: ['cn', 'jp'],
    separateDialCode: true,
    utilsScript: baseURL + "assets/site/main/js/utils.js"
  });
  /* $(document).ready(function(){
      $('#password').bootstrapPasswordStrengthMeter({
       minPasswordLength: 4,
	  level0ClassName: 'progress-bar-danger',
	  level0Description: 'Weak',
	  level1ClassName: 'progress-bar-danger',
	  level1Description: 'Not great',
	  level2ClassName: 'progress-bar-warning',
	  level2Description: 'Better',
	  level3ClassName: 'progress-bar-success',
	  level3Description: 'Strong',
	  level4ClassName: 'progress-bar-success',
	  level4Description: 'Very strong',
	  parentContainerClass: '.form-group'
      });
    });*/
</script>
<script>
$(document).ready(function () {
    $('#country').on('change', function () {
        if ($(this).val() == '10') {   // Bangladesh
            $('#bangladeshModal').modal('show');
        }
    });
});
</script>
  <script>
$(document).ready(function () {

    $('#student_title').on('change', function () {
        var title = $(this).val();

        if (title == '1') {          // Mr
            $('#gender').val('1').trigger('change');  // M
        } 
        else if (title == '2') {     // Ms
            $('#gender').val('2').trigger('change');  // F
        } 
        else {
            $('#gender').val('').trigger('change');   // Reset
        }
    });

});
</script>
<script>
$(document).ready(function () {

    function toggleParentSections(value) {

        // Hide all sections first
        $('#father_section').hide();
        $('#mother_section').hide();
        $('#guardian_section').hide();

        // Remove required from all inputs first
        $('#father_section input').prop('required', false);
        $('#mother_section input').prop('required', false);
        $('#guardian_section input').prop('required', false);

        // First + last name of every shown section are required; middle names optional
        var need = function (sec) {
            $(sec + ' input').each(function () {
                $(this).prop('required', !/_mname$/.test(this.id || ''));
            });
        };
        if (value == '1') { $('#father_section').show(); need('#father_section'); }
        else if (value == '2') { $('#mother_section').show(); need('#mother_section'); }
        else if (value == '3') { $('#father_section').show(); $('#mother_section').show(); need('#father_section'); need('#mother_section'); }
        else if (value == '4') { $('#guardian_section').show(); need('#guardian_section'); }
    }
    // On Change
    $('#parentdetail').on('change', function () {
        toggleParentSections($(this).val());
    });

    // On Page Load (Edit Mode)
    toggleParentSections($('#parentdetail').val());

});
</script>
<?php $regOld = $this->session->flashdata('reg_old'); if (is_array($regOld)) { ?>
<script>
// Refill the form after a server-side validation error (no password/captcha/file)
$(document).ready(function () {
  var old = <?php echo json_encode($regOld, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
  $.each(old, function (k, v) {
    if (v === '' || v === null) return;
    var $f = $('[name="' + k + '"]');
    if (!$f.length) return;
    if ($f.is(':radio')) { $f.filter('[value="' + v + '"]').prop('checked', true); }
    else { $f.val(v).trigger('change'); }
  });
});
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/site/main/js/sha.js"></script>
<script type="text/javascript">


  function validate_registration() {
    // Double-submit guard (test 1083)
    if (window.__a2aSubmitting) { return false; }
    // DOB must be chosen and copied into the hidden fields
    var dobVal = $('#dob').val();
    if (!dobVal) { alert('Please select your Date of Birth.'); return false; }
    var parts = dobVal.split('-');
    $('#applicant_year').val(parts[0]); $('#applicant_month').val(parts[1]); $('#applicant_date').val(parts[2]);
    // Passport image: type and size (server checks again)
    var pf = document.getElementById('fileInput');
    if (pf && pf.files && pf.files[0]) {
      var f = pf.files[0];
      if (!/\.(jpe?g|png)$/i.test(f.name)) { alert('Passport image must be a JPG, JPEG or PNG file.'); return false; }
      if (f.size > 1048576) { alert('Passport image must be 1 MB or smaller.'); return false; }
    }
    var pswd = $("#password").val();
    if (pswd.length < 8) {
      $('#pswd_info').show();
      $('#length').removeClass('valid').addClass('invalid');
      return false;
    }
    if (pswd.match(/[a-z]/)) {} else {
      $('#pswd_info').show();
      $('#letter').removeClass('valid').addClass('invalid');
      return false;
    }
    //validate capital letter
    if (pswd.match(/[A-Z]/)) {} else {
      $('#pswd_info').show();
      $('#capital').removeClass('valid').addClass('invalid');
      return false;
    }
    //validate number
    if (pswd.match(/\d/)) {} else {
      $('#number').removeClass('valid').addClass('invalid');
      $('#pswd_info').show();
      return false;
    }
    if (pswd.match(/[!@#$%^&*()_]/)) {} else {
      $('#specChar').removeClass('valid').addClass('invalid');
      $('#pswd_info').show();
      return false;
    }

    $("#cpassword").attr("style", "border:1px solid #cecece");
    if ($('#password').val() != $("#cpassword").val()) {
      $("#cpassword").attr("style", "border:1px solid red");
      $('.cpassmatch').text("Password Does Not Match!");
      return false;
    }
    var secret = $('#password').val();
    var shaObj = new jsSHA("SHA-1", "TEXT");
    shaObj.update(secret);
    var hash = shaObj.getHash("HEX");

    $('#password').val(hash);

    var secret1 = $('#cpassword').val();
    var shaObj1 = new jsSHA("SHA-1", "TEXT");
    shaObj1.update(secret1);
    var hash1 = shaObj1.getHash("HEX");

    $('#cpassword').val(hash1);
    window.__a2aSubmitting = true;
    $('#submit').prop('disabled', true).text('Submitting...');
    return true;
  }

  $('#submitButton-OLD').on('click', function() {

    //var email = $('#emailId').val();
    var email = 'umakant.dwivedi@velocis.co.in';
    var student_f = $('#student_fname').val();
	if(student_f = '' && student_f == null)
	{ 
         alert('Please enter student Name');
		return false;
	}
	else if(email == '' || email == null)
	{ 
         alert('Please enter emailId');
		return false;
	}
	
var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
if (filter.test(email)) {
  // Yay! valid
  $.ajax({
      type: "POST",
      cache: false,
      url: '<?php echo site_url(); ?>user/sendOTP',
      data: {
        'email': email
      },
      beforeSend: function() {
        $("#loader").show();
      },
      success: function(result) {
		  
		//console.log(result);
		var resp = JSON.parse(result);
		if (resp.status == 'success')
		{
			$("#loader").hide();
			$('#modalButton').click();
			alert(resp.message);
		}
		else if(resp.status == 'error')
		{
			$("#loader").hide();
			alert(resp.message);
		}
        // $('#sentOtp').val(result);
        // $('#modalButton').click();
        // $("#loader").hide();
      },
      error: function(result, success) {
        //$(".zip-error").slideDown(300);
      }
    });
 // return true;
}
else
  {
	alert('Please input a valid email address!');  
	  return false;}

   
  });

  $('#otpSubmitButton-OLD').on('click', function() {

    // var sentOtp = $('#sentOtp').val();
	var email = $('#emailId').val();
    var inputOtp = $('#inputOtp').val();

    $.ajax({
      type: "POST",
      cache: false,
      url: '<?php echo site_url(); ?>user/validateOTP',
      data: {
        // 'sentOtp': sentOtp,
        'inputOtp': inputOtp,
		'email': email,

      },
	  
      beforeSend: function() {
        $("#loader").show();
      },
      success: function(result) {
		
		var resp = JSON.parse(result);
		//console.log(resp);
		if(resp.status == 'error')
		{
			//alert('1');
			
			$("#loader").hide();
			$('#inputOtp').val('');
			document.getElementById("errorid").innerHTML = resp.message;
		$("#errorid").fadeOut(2000);
		//	alert(resp.message);
			return false;
		}
		else if(resp.status == 'success')
		{
			
			$("#loader").hide();
			$('#submit').click();
			$('#modalButton').hide();
			$("#errorid").hide();
			document.getElementById("succesid").innerHTML = resp.message;
			$("#succesid").fadeOut(2000);
			
			//alert(resp.message);
			return true;
		}
      },
      error: function(result, success) {
        //$(".zip-error").slideDown(300);
      }
    });
  });

  $(document).ready(function() {
    $("#myModal").modal('show');
  });


  $('#refreshImg').click(function() {
        refreshCapt();
    })


    function refreshCapt() {
        $.ajax({
            url: baseURL + 'home/refreshCaptcha',
            dataType: "html",
            success: function(data) {
                $('#captchid').attr('src', data);
            }
        });
    }

</script>
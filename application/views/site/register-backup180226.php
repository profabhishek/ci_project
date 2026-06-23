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
    <h3 class="text-center caps">Student Registration(2025-2026) for ICCR Scholarship Programme</h3>
    <h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
    <h5 class="text-center" style="color:#ffff12;font-size:23px;font-weight:bold;text-shadow:2px 2px 4px #000;">Please Read Guidelines Before Registration</h5>
    <span class="text-center" style="color:red;font-size:18px;font-weight:bold;padding:13px 0;display: block;text-decoration: underline;">THE INFORMATION ENTERED BY THE STUDENT SHOULD BE SINCERELY FILLED.</br>
      IF THE DETAILS ENTERED BY THE STUDENT AT ANY STAGE OF THE ADMISSION PROCESS ARE FOUND INCORRECT AND DOES NOT MATCH WITH THE ORIGINAL DOCUMENTS OR ENTRIES IN DUPLICATE ARE FOUND, THE ADMISSION OF THE SAID STUDENT WILL STAND <b style="font-size: 21px;">CANCELLED</b>.</span>
    <!-- <span class="text-center" style="color:#00a716;font-size:16px;font-weight:bold;"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png"
                    alt="new gif Image"> Before apply, kindly first register on <a href="https://studyinindia.gov.in" target="_blank">Study In India (SII)</a> portal.</span> -->  
    <span class="text-center" style="color:Blue;font-size:15px;font-weight:bold;padding:8px 0;display:block;text-decoration:underline;">Applicants from Bangladesh are requested to kindly first register at Suborno Jayanti Portal (https://sjsdhaka.gov.in) and thereafter on A2A Portal for the ICCR Scholarship.</span>
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
    <div class="alert alert-error" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
    </div>
  <?php
  }

  ?>

  <div class="container" style="padding:0;min-height: 396px;">
    <div class="box col-xs-6" style="margin-top: 60px;">
      <!-- form start -->
      <form id="identicalForm" action="<?php echo site_url(); ?>user/register" onsubmit="return validate_registration();" enctype="multipart/form-data" method="post" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
        <div class="box-body">

          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

               
          <div class="col-xs-2 col-md-3 col-sm-3">
            <label for="exampleInputEmail1">Title <span class="text-red">*</span></label>
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
                <option value="3">Mrs</option>
              <?php
              } else if ($title == 2) {
              ?>
                <option value="">Title</option>
                <option value="1">Mr</option>
                <option value="2">Ms</option>
                <option selected="selected" value="3">Mrs</option>
              <?php
              } else if ($title == 3) {
              ?>
                <option value="">Title</option>
                <option value="1">Mr</option>
                <option selected="selected" value="2">Ms</option>
                <option value="3">Mrs</option>
              <?php
              } else {
              ?>
                <option value="">Title</option>
                <option value="1">Mr</option>
                <option value="2">Ms</option>
                <option value="3">Mrs</option>
              <?php
              }
              ?>
            </select>
          </div>

          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Student First Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="student_fname" pattern="^[a-zA-Z ]+$" title="Applicant First Name" name="student_fname" placeholder="Enter First Name" required="true" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1 ">Student Middle Name </label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="student_mname" pattern="^[a-zA-Z ]+$" title="A-Z" name="student_mname" placeholder="Enter Middle Name" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Student Last Name<span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="student_lname" pattern="^[a-zA-Z ]+$" title="Applicant Last Name" name="student_lname" placeholder="Enter Last Name" required="true" maxlength="15">
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Nationality<span class="text-red">*</span></label>
            <div class="form-group">

              <select class="form-control select2" name="country" id="country" style="width: 100%;" required="true">
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

          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Father First Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="father_fname" pattern="^[a-zA-Z ]+$" title="Father First Name" name="father_fname" placeholder="Enter First Name" required="true" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Father Middle Name </label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="father_mname" pattern="^[a-zA-Z ]+$" title="A-Z" name="father_mname" placeholder="Enter Middle Name" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Father Last Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="father_lname" pattern="^[a-zA-Z ]+$" title="Father Last Name" name="father_lname" placeholder="Enter Last Name" required="true" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Mother First Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="mother_fname" pattern="^[a-zA-Z ]+$" title="Mother First Name" name="mother_fname" placeholder="Enter First Name" required="true" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Mother Middle Name </label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="mother_mname" pattern="^[a-zA-Z ]+$" title="A-Z" name="mother_mname" placeholder="Enter Middle Name" maxlength="15">
            </div>
          </div>
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Mother Last Name <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control capitalLetter" id="mother_lname" pattern="^[a-zA-Z ]+$" title="Mother Last Name" name="mother_lname" placeholder="Enter Last Name" required="true" maxlength="15">
            </div>
          </div>


          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Gender <span class="text-red">*</span></label>
            <div class="form-group">

              <select class="form-control select2" name="gender" id="gender" style="width: 100%;" required="true">
                <option value="">Select</option>
                <option value="1">M</option>
                <option value="2">F</option>
              </select>
            </div>
          </div>


          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Mobile Number <span class="text-red">*</span></label>
            <!-- <span class="note">Please enter country code before your mobile no. Like +91 for India</span> -->
            <div class="form-group">
              <input type="text" class="form-control" id="mobile_no" pattern="^[0-9\+]+$" title="Please enter country code before your mobile no. Like +91 for India" name="mobile_no" placeholder="Like +918750859869" required="true" maxlength="20">
              <!-- <span class="note">Please enter country code before your mobile no. Like +91 for India</span> -->
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-2 col-md-3">
            <label for="exampleInputEmail1">Email Id <span class="text-red">*</span></label>
            <div class="form-group">
              <input type="email" class="form-control" id="emailId" name="emailId" placeholder="Enter email" required="true" maxlength="40" re>
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Passport No. of your country <span class="text-red">*</span></label>
            <div class="form-group">
              <input type="text" class="form-control capitalLetter" id="passport_no" name="passport_no" placeholder="Enter Passport" maxlength="10" required="true">
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="comment">Citizenship No./Unique ID No.<span class="text-red">*</span></label>
            <div class="form-group">
              <input type="text" class="form-control capitalLetter" id="unique_id" name="unique_id" placeholder="Citizenship/Unique ID" required="true" maxlength="20"/>
            </div>
          </div>


          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Apply For<span class="text-red">*</span></label>
            <div class="form-group">

              <select class="form-control select2" name="apply_course_type" id="apply_course_type" style="width: 100%;" required="true">
              

                
              </select>
            </div>
          </div>


          <!-- <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Select Course<span class="text-red">*</span></label>
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


          <div class="name-sec col-xs-12 col-sm-3 col-md-3 pdleft1">
            <label for="exampleInputEmail1">Date of Birth (DD/MM/YYYY) <span class="text-red">*</span></label>
            <div class="form-group col-md-4 pdleft">
              <select class="form-control" id="applicant_date" name="applicant_date" required="true">
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
              </select>
              <!-- <input  class="form-control datepicker_register" readonly="true" data-provide="datepicker_register" id="dob" name="dob" placeholder="Enter Date of Birth" required="true">-->
            </div>
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
            </div>

          </div>
        

          <div class="name-sec col-xs-12 col-sm-2 col-md-3">
            <label for="exampleInputEmail1">Password <span class="text-red">*</span></label>
            <div class="form-group">
              <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password" required="true" maxlength="40">
              <div id="pswd_info">
                <h4>Password must meet below requirements:</h4>
                <ul>
                  <li id="letter" class="invalid">At least <strong>one letter</strong></li>
                  <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
                  <li id="number" class="invalid">At least <strong>one numeric value</strong></li>
                  <li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
                  <li id="specChar" class="invalid">At least <strong>one special character</strong></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-2 col-md-3">
            <label for="exampleInputEmail1">Confirm Password <span class="text-red">*</span></label>
            <div class="form-group">

              <input type="password" data-fv-identical="true" data-fv-identical-field="password" data-fv-identical-message="The password and its confirm are not the same" class="form-control" id="cpassword" name="cpassword" placeholder="Re-Enter Password" required="true">
              <span class="note cpassmatch"></span>
            </div>
          </div>

          
          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputFile">Currently Staying In India <span class="text-red">*</span></label>
            <div class="form-group">
              <input value="1" type="radio" name="isindian" required="true"> Yes
              <input class="minimal" checked="true" value="2" type="radio" name="isindian" required="true"> No
            </div>
          </div>

          <div class="name-sec col-xs-12 col-sm-3 col-md-3">
            <label for="exampleInputEmail1">Enter Text Here <span class="text-red">*</span></label><br>
            <div class="form-group col-md-6 pdleft">
              <input type="text" autocomplete="off" name="userCaptcha" id="userCaptcha" class="form-control" required placeholder="Enter text" required="true" maxlength="7" />
            </div>
            <a href="javascript:void(0);" id="refreshImg" class="reload-captcha">&nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></a>
            <div class="form-group col-md-6">
              <img id="captchid" src="<?php echo $captcha['image_src']; ?>"  style="max-width: -webkit-fill-available;"/>
            </div>
          </div>
        </div>

        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary" id="submit">Submit</button>
         <!-- <button type="button" class="btn btn-primary" id="submitButton">Submit</button>-->
        </div>
      </form>

      <!--<a href="http://a2ascholarships.iccr.gov.in/home/sfs_register"> For Afghanistan Strudents - Click Here</a> -->
    </div>
    <!-- /.box -->

  </div>

</section>

<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 1030px;
    margin-left: -190px;">
      <div class="modal-header">
        <h5 class="modal-title">
          <h5 class="text-center" style="color:#dd0e0e;font-size:23px;font-weight:bold;">Please Read Guidelines Before Registration</h5>
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <span class="text-center" style="color:red;font-size:18px;font-weight:bold;padding:13px 0;display: block;text-decoration: underline;">THE INFORMATION ENTERED BY THE STUDENT SHOULD BE SINCERELY FILLED.</br>
        IF THE DETAILS ENTERED BY THE STUDENT AT ANY STAGE OF THE ADMISSION PROCESS ARE FOUND INCORRECT AND DOES NOT MATCH WITH THE ORIGINAL DOCUMENTS OR ENTRIES IN DUPLICATE ARE FOUND, THE ADMISSION OF THE SAID STUDENT WILL STAND <b style="font-size: 21px;">CANCELLED</b>.</span>

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
			      <div class="col-lg-2">
              <button type="button" class="btn btn-primary" id="otpSubmitButton">Submit</button>
              </div>
            </div>
          </div>
        </div>

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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/site/main/js/sha.js"></script>
<script type="text/javascript">
  function validate_registration() {
    var pswd = $("#password").val();
    if (pswd.length < 8) {
      $('#pswd_info').show();
      $('#length').removeClass('valid').addClass('invalid');
      return false;
    }
    if (pswd.match(/[A-z]/)) {} else {
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
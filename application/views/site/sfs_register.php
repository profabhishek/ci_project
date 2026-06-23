<style>
.progress {   
    border: 1px solid #cecece;  
    height: 22px;   
    margin-top: 5px;   
}
.alert
{	
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
    position:absolute;
    top:-12px;
    left:45%;
    font-size:14px;
    line-height:14px;
    color:#ddd;
    text-shadow:none;   
}
.invalid {
    background:url("../assets/site/main/img/invalid.png") no-repeat 0 50%;
    padding-left:22px;
    line-height:24px;
    color:#ec3f41;
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
    display:none;
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
.form_head {
	height: 165px;
}
.box {
    padding-top: 30px;
}
</style>
<link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/intlTelInput.css"/>


<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Student Registration(2022-2023) for SFS (Self Finance Students)</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
		<h5 class="text-center" style="color:yellow;font-size:23px;font-weight:bold;text-shadow:2px 4px 4px #000;">Please Read Guidelines Before Registration</h5>
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

<div class="container" style="padding:0;min-height: 396px;">

	  <!-- general form elements -->
          <div class="box  col-xs-6">  


            <!-- /.box-header -->
            <!-- form start -->
           <form id="identicalForm" action="<?php echo site_url();?>user/sfs_register" onsubmit="return validate_registration();" enctype="multipart/form-data" method="post"  data-fv-framework="bootstrap"
    data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
              <div class="box-body">
             
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						
						<div class="name-sec col-xs-12 col-sm-3 col-md-2">
						<label for="exampleInputEmail1">Apply For<span class="text-red">*</span></label>
              	<div class="form-group">
                  
                <select class="form-control select2" name="apply_course_type" id="apply_course_type" style="width: 100%;" required="true">                  
                   <option value="">Select</option>
				   
                   <option value="11">SFS(Under all Scholarship Schemes for ICCR)</option>
				   
                </select>
                </div>             
              </div>
						<div class="name-sec col-xs-12 col-sm-3 col-md-2">
						<label for="exampleInputEmail1">Nationality<span class="text-red">*</span></label>
              	<div class="form-group">
                  
                  <select class="form-control select2" name="country" id="country" style="width: 100%;" required="true">                  
                  <option value="">Select</option>
								 <option value="1">Afghanistan</option>
							
						
						  
						                                  
                </select>
                </div>             
              </div>
              <div class="name-sec col-xs-12 col-sm-3 col-md-2">
               <label for="exampleInputEmail1">Full Name of the student <span class="text-red">*</span></label>
                <div class="form-group">
                 
                  <input class="form-control" id="student_name" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" name="student_name" placeholder="Enter Name" required="true">
                </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                 <label for="exampleInputEmail1">Gender <span class="text-red">*</span></label>
                 <div class="form-group">
                 
                  <select class="form-control select2" name="gender" id="gender" style="width: 100%;" required="true">                  
                  <option value="">Select</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>                                  
                </select>
                </div> 
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4 pdleft">
                 <label for="exampleInputEmail1">Date of Birth (DD/MM/YYYY) <span class="text-red">*</span></label>
                <div class="form-group col-md-4 pdleft">
                 <select class="form-control" id="applicant_date" name="applicant_date" required="true">
								<option value="">Date</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
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
							<option value="1">Jan</option>
							<option value="2">Feb</option>
							<option value="3">Mar</option>
							<option value="4">Apr</option>
							<option value="5">May</option>
							<option value="6">Jun</option>
							<option value="7">Jul</option>
							<option value="8">Aug</option>
							<option value="9">Sep</option>
							<option value="10">Oct</option>
							<option value="11">Nov</option>
							<option value="12">Dec</option>								
						</select>
					</div>
                <div class="form-group col-md-4 pdleft">
                	<select class="form-control"  id="applicant_year" name="applicant_year" onchange = "validateDob();"required="true">
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
								
							</select>
                </div>
                
                </div>               
                <div class="name-sec col-xs-12 col-sm-2 col-md-2">
                 <label for="exampleInputEmail1">Mobile Number <span class="text-red" >*</span></label>
                 <div class="form-group">
                 
                  <input type="text" class="form-control" id="mobile_no" pattern="^[0-9\+]+$" title="+0-9" name="mobile_no" placeholder="+918750859869 (+91 for India)" required="true" maxlength="20">
                  <span class="note">Please enter country code before your mobile no. Like +91 for India</span>
                </div>
                </div>
				<div class="name-sec col-xs-12 col-sm-2 col-md-2">
                 <label for="exampleInputEmail1">Passport No.or Permanent Unique ID of your country <span class="text-red">*</span></label>
                <div class="form-group">
                 
                  <input type="text" class="form-control" id="passport_no" name="passport_no" placeholder="Enter Passport" required="true">
                </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-2 col-md-2">
                 <label for="exampleInputEmail1">Email Id <span class="text-red">*</span></label>
                <div class="form-group">
                 
                  <input type="email" class="form-control" id="emailId" name="emailId" placeholder="Enter email" required="true">
                </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-2 col-md-2">
                <label for="exampleInputEmail1">Password <span class="text-red">*</span></label>
                <div class="form-group">
                  
                  <input  class="form-control" type="password" id="password" name="password" placeholder="Enter Password" required="true">
             
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
                <div class="name-sec col-xs-12 col-sm-2 col-md-2">
                 <label for="exampleInputEmail1">Confirm Password <span class="text-red">*</span></label>
                 <div class="form-group">
                 
                  <input type="password" data-fv-identical="true" data-fv-identical-field="password" data-fv-identical-message="The password and its confirm are not the same"  class="form-control" id="cpassword" name="cpassword" placeholder="Re-Enter Password" required="true">
                  <span class="note cpassmatch"></span>
                </div>
                </div>
                
                 <div class="name-sec col-xs-12 col-sm-3 col-md-12">
                  <label for="exampleInputFile">Currently Staying In India <span class="text-red">*</span></label>   
                   <div class="form-group">
                   <input  value="1" type="radio" name="isindian" required="true"> Yes
                  
                   <input class="minimal"  checked="true" value="2"   type="radio"  name="isindian" required="true">
                   No
                  </div>
                </div>
                </div>
               
                 <div class="name-sec col-xs-12 col-sm-3 col-md-12">
                 <label for="exampleInputEmail1">Enter Text Here <span class="text-red">*</span></label><br>
                  <div class="form-group col-md-3 pdleft">
                  
				  <input type="text" autocomplete="off" name="userCaptcha" id="userCaptcha" class="form-control" required placeholder="Enter text" required="true" />
				  </div>
				  <div class="form-group col-md-6">
				   
				     <img src="<?php echo $captcha['image_src']; ?>"/>
                </div>
               </div>
              
              
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->			
				
</div>

</section>

  <script type="text/javascript" src="<?php echo site_url();?>assets/site/main/js/intlTelInput.min.js"></script>
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
function validate_registration()
{
	var pswd = $("#password").val();
    if (pswd.length < 8) {
    	$('#pswd_info').show();
    	$('#length').removeClass('valid').addClass('invalid');   
    	return false; 
	}
	if ( pswd.match(/[A-z]/) ) {		
	} else {
		$('#pswd_info').show();
	    $('#letter').removeClass('valid').addClass('invalid');
	    return false;
	}
	//validate capital letter
	if ( pswd.match(/[A-Z]/) ) {	   
	} else {
		$('#pswd_info').show();
	    $('#capital').removeClass('valid').addClass('invalid');
	     return false;
	}
	//validate number
	if ( pswd.match(/\d/) ) {	   
	} else {
	    $('#number').removeClass('valid').addClass('invalid');
	    $('#pswd_info').show();
	    return false;
	}
	if ( pswd.match(/[!@#$%^&*()_]/) ) {	  
	} else {
	    $('#specChar').removeClass('valid').addClass('invalid');
	     $('#pswd_info').show();
	    return false;
	}
	
	$("#cpassword").attr("style","border:1px solid #cecece");
	if($('#password').val() != $("#cpassword").val())
	{
		$("#cpassword").attr("style","border:1px solid red");
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

$(document).ready(function(){
	fetch('https://api.ipregistry.co/?key=tryout')
    .then(function (response) {
        return response.json();
    })
    .then(function (payload) {
        console.log( + ', ' + payload.location.city);
		if(payload.location.country.name!="India"){
			window.open('http://a2ascholarships.iccr.gov.in/','_self');
		}
    });
});



 
</script>
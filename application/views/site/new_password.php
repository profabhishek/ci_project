<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:88px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;font-weight: bold;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
.form-horizontal .control-label {
    
    margin-bottom: 0;
    text-align: left;
    font-size: 12px;
    padding: 0;
    padding-top: 7px;
    width: 135px;
}
.form-group{
    margin-right: 0 !important;
    padding-left: 0;
    padding-right: 0;
    width: 100%;
}
.filter
{
	 border-bottom: 1px solid #cecece;
    border-top: 1px solid #cecece;
    margin-bottom: 36px;
    margin-top: 30px;
    padding-bottom: 15px;
    padding-top: 10px;
}
.filter1,.filter2
{
	border-bottom: 1px solid #cecece;
    border-top: 1px solid #cecece;
    margin-bottom: 36px;   
    padding-bottom: 15px;
    padding-top: 10px;
}
.filter label{padding-right:0;padding-top:10px;width:150px;}
.filter1 label{padding-right:0;padding-top:10px;width:150px;}
.filter2 label{padding-right:0;padding-top:10px;width:150px;}
.customdate{width:116px;}
input,select,label{font-size:14px !important;}
.tab-content input[type="text"], select {
    background: #FFEE75 none repeat scroll 0 0 !important;
    color: #747474 !important;
    font-size: 14px !important;
    font-weight: bold;
}
.tab-content  input[readonly]
{
   background-color: #ccde8f !important;
    color: #000 !important;
}
.rpt{
	 border: 1px solid #cecece;
    border-radius: 24px;
    color: #747474;
    float: right;
    font-weight: bold;
    padding: 6px;
    text-align: center;
    width: 129px;
}


</style>
<section class="meacontent">
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Reset Your Password</h3>	
	</div>
		<div class="headsec container">Welcome to ICCR Scholarship Portal </div>
	<div class="container">
		  <div class="box-body">
		<?php 
			$fattr = array('class' => 'form-signin','onsubmit' => "return ValidatePass2()");
			echo form_open('home/completePassword',$fattr) ;
			
		?>
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
			}?>
		<div class="form-group col-xs-9">
			<label for="exampleInputEmail1" class="col-sm-2">Email Id <span class="text-red">*</span></label>
			<div class="col-sm-8">
				
				<?php echo form_input(array('name' => 'email', 'id' => 'email', 'value' => set_value('email', ''), 'maxlength' => '100', 'size' => '50', 'class' => 'form-control','required'=>'true')); ?>
			</div>
		</div>
		<div class="form-group col-xs-9">
			<label for="exampleInputEmail1" class="col-sm-2">Password <span class="text-red">*</span></label>
			<div class="col-sm-8">
				
				<?php echo form_password(array('name' => 'password', 'id' => 'password1', 'value' => set_value('password', ''), 'maxlength' => '100', 'size' => '50', 'class' => 'form-control pass' ,'required'=>'true')); ?>
			</div>
		</div>
		<div class="form-group col-xs-9">
			<label for="exampleInputEmail1" class="col-sm-2">Confirm Password <span class="text-red">*</span></label>
			<div class="col-sm-8">				
				<?php echo form_password(array('name' => 'password2', 'id' => 'password2', 'value' => set_value('password2', ''), 'maxlength' => '100', 'size' => '50', 'class' => 'form-control pass' ,'required'=>'true')); ?>
				<?php echo form_hidden('code', $code) ; ?>
			</div>
		</div>
		<div class="form-group col-xs-9 options">
							<label class="col-sm-2">Are you applicant<span class="text-red">*</span></label>
							<div class="col-sm-8">
							<label class="radio-inline"><input type="radio" id = "app_r" name="optradio" value = "1" >Yes</label>
							<label class="radio-inline"><input type="radio" value = "2" name="optradio" checked>No</label>
							</div>
						</div>
						<div class="form-group col-xs-9" id = "app_div" style="display:none">
							<label class="col-sm-2">Registation Year</label>
							<div class="col-xs-8">
							<select id="year" name="year" class="form-control">
							<option value="">Select</option>
							<!----<option value="2017">2017-2018</option>
							<option value="2018">2018-2019</option>---->
							<option value="2021">2021-2022</option>
							<option value="2022">2022-2023</option>
							<option value="2023">2023-2024</option>
							<option value="2024">2024-2025</option>
							<option value="2025">2025-2026</option>
							<option value="2025">2026-2027</option>
							</select>
							</div>
						</div>
		<div class="form-group col-xs-9">
			<div class="col-sm-2">
				<label for="">Enter Text Here <span class="text-red">*</span></label>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-2 catchaimg">
				<img id="captid" src="<?php echo $captcha['captcha']['image_src']; ?>"/>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-6 cap-text">
				<input type="text" autocomplete="off" name="userCaptcha" class="form-control" required placeholder="Enter text" required="true" />
			</div>			
		</div>
		<div class="col-xs-12 col-sm-6 col-md-9 nopadding">	
			<div class="col-xs-12 col-sm-3 col-md-3 cap-text pull-right">
				<?php echo anchor('home', 'Cancel', array('class'=>'form-control sbmt')); ?>
			</div>			
			<div class="col-xs-12 col-sm-3 col-md-3 cap-text pull-right">
				<?php echo form_submit(array('type'=>'submit', 'value'=>'Submit','id'=>'register-submit1','class'=>'form-control sbmt'));?>
			</div>				
		</div>
		<?php echo form_close(); ?>
		</div>
	</div>	
</section>
<script src="<?php echo base_url();?>assets/site/main/js/sha.js"></script>
<script>	
	
	function ValidatePass2() {
        var password = document.getElementById("password1").value;
		var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,50}$/;
		
		if (!regex.test(password)) {
			alert("Password field must be at least one lowercase letter,one Upperase, one number,one special character and minium length 8 character.");
			return false;
		} 
        var confirmPassword = document.getElementById("password2").value;
        if (password != confirmPassword) {
			alert("Passwords do not match.");
            return false;
		}
		
		// var value = $.trim(password);
		// if(value != '')
		// {
		// value = btoa(value);
        // $('#password1').val(salt+'@#1'+value);
		// }
		// var value1 = $.trim(confirmPassword);
		// if(value1 != '')
		// {
		// value1 = btoa(value1);
        // $('#password2').val(salt+'@#1'+value1);
		// }	
		
		var secret = $('#password1').val();
		
		var shaObj = new jsSHA("SHA-1", "TEXT");
		shaObj.update(secret);   
		var hash = shaObj.getHash("HEX");
		
		$('#password1').val(hash);	
		
		var secret1 = $('#password2').val();
		var shaObj1 = new jsSHA("SHA-1", "TEXT");
		shaObj1.update(secret1);   
		var hash1 = shaObj1.getHash("HEX");
		
		$('#password2').val(hash1);	
		
		
		
        return true;
	}
</script>	
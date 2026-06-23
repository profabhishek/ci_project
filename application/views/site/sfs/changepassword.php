<?php //echo "<pre>";print_r($applicaitonStepOne);die;?>
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
    top: 44px;
    
    z-index: 999;
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
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Reset Your Password</h3>	
	</div>
	<div class="headsec container">Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal </div>	
	<div  class="container" style="min-height:241px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-changepassword" role="form" data-toggle="validator" action="<?php echo site_url();?>applicant/changepassword" method="post" class="form-horizontal" enctype="multipart/form-data" onsubmit="return getPass();">
	    <div class="box-body">
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
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
	    	  <input type="hidden" name="id" id="id" value="<?php echo $head['userid'];?>">					
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Old Password.</label>
					    <div class="col-sm-8">
					     
						  <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old Password" required="true">
					    </div>
					</div>
              		<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">New Password</label>
					    <div class="col-sm-8">					    
							 <input type="password" data-minlength="6" class="form-control" id="newpassword" name="newpassword" placeholder="Password" required>
							 <div id="pswd_info">
								<h4>Password must meet below requirements:</h4>
								<ul>
									<li id="letter" class="invalid">At least <strong>one letter</strong></li>
									<li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
									<li id="number" class="invalid">At least <strong>one number</strong></li>
									<li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
									<li id="specChar" class="invalid">At least <strong>one special char from (@#!)</strong></li>
								</ul>
								
							</div>
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Re-Type Password</label>
					    <div class="col-sm-8">
					    	<input type="password" class="form-control" id="confirmpassword" name="confirmpassword" data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="Confirm" required>
							<span class="note cpassmatch" ></span>
					    </div>
					</div>
					
				<br/><br/>		
			</div>
			<div class="form-group col-xs-9 pull-right pdlef ">					    
					    <div class="col-sm-7 pull-right pdleft">
					      <input type="submit" class="form-control sbmt" value="Submit"/>
					    </div>					    
					</div>
              <!-- /.box-body -->
            </form>
	  </div>
	  <br/><br/>	<br/>   
	</div>
	</div>
	<br/><br/>	<br/>  
	
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/site/main/js/sha.js"></script>
<script type="text/javascript">
	function getPass()
	{
		
		var pswd = $("#newpassword").val();
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
		
		$("#confirmpassword").attr("style","border:1px solid #cecece");
		if($('#newpassword').val() != $("#confirmpassword").val())
		{
			$("#confirmpassword").attr("style","border:1px solid red");
			$('.cpassmatch').text("Password Does Not Match!");
			return false;
		}
		 
		
		var secretold = $('#oldpassword').val();
		var shaObj = new jsSHA("SHA-1", "TEXT");
		shaObj.update(secretold);      
		var hashold = shaObj.getHash("HEX");
		$('#oldpassword').val(hashold);	
		
		var secret1 = $('#newpassword').val();
		var shaObj1 = new jsSHA("SHA-1", "TEXT");
		shaObj1.update(secret1);   
		var hash1 = shaObj1.getHash("HEX");	
		$('#newpassword').val(hash1);
		
		var secret2 = $('#confirmpassword').val();
		var shaObj2 = new jsSHA("SHA-1", "TEXT");
		shaObj2.update(secret2);   
		var hash2 = shaObj1.getHash("HEX");	
		$('#confirmpassword').val(hash2);
		
		return true;
	}
	</script>	

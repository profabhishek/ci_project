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
		<div class="headsec container">Welcome to ICCR Scholarship Portal </div>
	<div  class="container" style="min-height:241px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>home/forgot_password" method="post" class="form-horizontal" enctype="multipart/form-data">
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
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Email Id <span class="text-red">*</span></label>
							<div class="col-sm-8">
							<input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required="true" maxlength="50">
							</div>
					</div>
					<div class="form-group col-xs-9 options">
							<label class="col-sm-2">Are you applicant?<span class="text-red">*</span></label>
							<div class="col-sm-8">
							<label class="radio-inline"><input type="radio" id = "app_r" name="optradio" value = "1" >Yes</label>
							<label class="radio-inline"><input type="radio" value = "2" name="optradio" checked>No</label>
							</div>
						</div>
						<div class="form-group col-xs-9" id = "app_div" style="display:none">
							<label class="col-sm-2">Registration Year<span class="text-red">*</span></label>
							<div class="col-sm-8">
							<select id="year" name="year" class="form-control">
							<option value="">Select</option>
							<!-- <option value="2021">2021-2022</option>
							<option value="2022">2022-2023</option>
							<option value="2023">2023-2024</option> 
							<option value="2024">2024-2025</option>
							<option value="2025">2025-2026</option>-->
							<option value="2026">2026-2027</option>
							</select>
							</div>
						</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Enter Text Here</label>
						<div class="col-sm-4">
					     <input type="text" autocomplete="off" name="userCaptcha" class="form-control" required placeholder="Enter text" required="true" maxlength="7"/>
						  
					    </div>
					    <div class="col-sm-4">
					     <img id="captid" src="<?php echo $captcha['image_src']; ?>"/>
						  
					    </div>
					</div>
				<br/><br/>		
			</div>
			<div class="form-group col-xs-9 pull-right pdlef ">					    
					    <div class="col-sm-6 pull-left pdleft">
					      <input type="submit" class="form-control sbmt pull-right" id="submit" value="Submit"/>
					    </div>	
						<div class="col-sm-6 pull-left pdleft">
					      <?php echo anchor('home', 'Cancel',array('class'=>'form-control sbmt')); ?>
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

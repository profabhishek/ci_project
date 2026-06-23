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
</style>
<link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/intlTelInput.css"/>


<section class="meacontent" id="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Feedback Form</h3>
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
           <form id="feedbackForm" action="<?php echo site_url();?>home/sendfeedback" enctype="multipart/form-data" method="post"  data-fv-framework="bootstrap"
    data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
                <div class="box-body">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						
				<div class="name-sec col-xs-12 col-sm-12 col-md-6">
				<label for="exampleInputEmail1">Name<span class="text-red">*</span></label>
                <div class="form-group">                
                  <input class="form-control cls" id="name" name="name" placeholder="Enter Name" maxlength="50">
                </div>
                </div>
                
                <div class="name-sec col-xs-12 col-sm-12 col-md-6">
                <label for="exampleInputEmail1">Email Id <span class="text-red">*</span></label>
                <div class="form-group">
                <input type="email" class="form-control cls" id="emailId" name="emailid" placeholder="Enter email" maxlength="50">
                </div>
                </div>
				
				<div class="name-sec col-xs-12 col-sm-12 col-md-6">
                <label for="exampleInputEmail1">Phone Number <span class="text-red">*</span></label>
                <div class="form-group">
                <input type="text" class="form-control cls" id="mobile_number" pattern="^[0-9\+]+$" title="+0-9" name="mobile_no" placeholder="Mobile No" maxlength="18">
                 
                </div>
                </div>
               
                <div class="name-sec col-xs-12 col-sm-12 col-md-6">
                 <label for="exampleInputEmail1">Comment<span class="text-red">*</span></label>
                <div class="form-group">
                <textarea name="comment" class="form-control clsarea" rows="5" id="comment"></textarea> 
                 
                </div>
                </div>
                 <div class="name-sec col-xs-12 col-sm-3 col-md-12">
                 <label for="exampleInputEmail1">Enter Text Here <span class="text-red">*</span></label><br>
                  <div class="form-group col-md-3 pdleft">
                  
				  <input type="text" autocomplete="off" name="userCaptcha" id="userCaptcha" class="form-control cls" required placeholder="Enter text" maxlength="6"/>
				  </div>
				  <div class="form-group col-md-6">
				   
				     <img src="<?php echo $captcha['image_src']; ?>"/>
                </div>
               </div>
            </div>
			<!-- /.box-body -->
              <div class="box-footer">
                <button type="button" id="submitfeedback" class="btn btn-primary">Submit</button>
              </div>
            </form>
         
          <!-- /.box -->			
				
</div>

</section>

  <script type="text/javascript" src="<?php echo site_url();?>assets/site/main/js/intlTelInput.min.js"></script>
  <script type="text/javascript">
    $("#mobile_no").intlTelInput({
       allowDropdown: false,
      separateDialCode: true,
      utilsScript: baseURL + "assets/site/main/js/utils.js"
    });
  
  
  </script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/site/main/js/sha.js"></script>
<script type="text/javascript">
$('#submitfeedback').click(function(){

	var empty = 0; 
    
    $('input.cls').each(function(){  
	  
       if (this.value == "") {
		
       $(this).addClass("error_validate");
       $(this).find(".error_validate").focus();
          empty++;
       }
       else
       {
       	$(this).removeClass("error_validate");
       } 
    })

    $('textarea.clsarea').each(function(){    
       if (this.value == "") {
       $(this).addClass("error_validate");
          empty++;
       }else{
       	$(this).removeClass("error_validate");
       } 
    })
	
	
	if(empty > 0){
	
	return false;
	}else{
	$('#feedbackForm').submit();
	}
	
});
</script>
<style>
.error_validate {   
    border: 2px solid red;
}
</style>
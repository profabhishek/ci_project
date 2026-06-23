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
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps"> <?php
		$user_data = $this->session->userdata('user_data');
		 echo $user_data['fname'];?> Profile</h3>	
	</div>
	<div class="headsec container">Welcome <?php
			
			 echo $user_data['fname'];?> to ICCR Scholarship Portal  </div>	
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>headquarter/profile" method="post" class="form-horizontal" enctype="multipart/form-data">
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
	    	  <input type="hidden" name="id" id="id" value="<?php echo $head[0]['uid'];?>">			
					<div class="form-group col-xs-9">					
					    <label for="inputEmail3" class="col-sm-2">Name of Head of Dept.</label>
					    <div class="col-sm-8">					      
						  <input type="text" class="form-control" name="username" id="username" placeholder="Name" value="<?php echo $head[0]['username'];?>" >
					    </div>
					</div>
              		<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Mobile Number</label>
					    <div class="col-sm-8">					   
						<input type="text" class="form-control" placeholder="Mobile Number" value="<?php echo $head[0]['mobile_no'];?>" id="mobile_no" name="mobile_no"/>						
						     
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Email Id</label>
					    <div class="col-sm-8">
					    	<input type="text" class="form-control" readonly="true" value="<?php echo $head[0]['email_id'];?>" placeholder="Email Id"/>
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Office Address</label>
					    <div class="col-sm-8">
					    	<input type="text" id="office_address" name="office_address" class="form-control" value="<?php echo $head[0]['office_address'];?>" placeholder="Office Address"/>
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Telephone</label>
					    <div class="col-sm-8">
					    	<input type="text" class="form-control" id="telephone_number" name="telephone_number" value="<?php echo $head[0]['telephone_number'];?>" placeholder="Telephone"/>
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Fax Number</label>
					    <div class="col-sm-8">
					    	<input type="text" class="form-control" id="fax_number" name="fax_number"  value="<?php echo $head[0]['fax_number'];?>" placeholder="Fax Number"/>
					    </div>
					</div>
				<br/><br/>		
			</div>
			<div class="form-group col-xs-9 pull-right pdlef ">					    
					    <div class="col-sm-7 pull-right pdleft">
					      <input type="submit" class="form-control sbmt" id="submit" value="Submit"/>
					    </div>					    
					</div>
              <!-- /.box-body -->
            </form>
	  </div>
	  <br/><br/>	<br/>   
	</div>
	</div>
</section>

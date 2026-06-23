<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:178px;width:159px;text-align: center;padding:0;}
.prfl img{;margin-bottom:8px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
#fbl_main tbody tr td:first-child{
	width: 279px !important;
}
optgroup[label]{ color: #4e7a9f;
    font-size: 20px;
    padding-left: 10px;
    padding-top: 10px;
    text-decoration: underline;}
optgroup option{color:#747474; font-size: 14px;}
</style>
<?php if($this->session->flashdata('success')){ ?>
		<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
		</div>
		<?php }else if($this->session->flashdata('error')){  ?>
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
		</div>
		<?php }else if($this->session->flashdata('warning')){  ?>
		<div class="alert alert-warning">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
		</div>
		<?php }else if($this->session->flashdata('info')){  ?>
		<div class="alert alert-info">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
		</div>
	<?php } ?>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Stipend Edit Form </h3>
		<h5 class="text-center">TO BE FILLED BY REGIONAL OFFICE</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding-top:0px;">	
	<form method="post" action="<?php echo base_url();?>regional/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<div class="tab-content detailpagepdf" style="border-bottom: 2px solid #cecece;">		
	  <div id="home" class="tab-pane fade in active">	
	    	 
       <div class="box-body">
	   <?php
              //$htm  ="<form action='".site_url().'regional/saveStudentDetails'"' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			  
			  
			 $htm  ="<form action='".site_url().'regional/studentExpenditureSave/'.$appId."' method='post' enctype='multipart/form-data' id='frm_imageuupload'>";
			 
			 $htm .="<input type = 'hidden' name = 'appId' value = '".$expenditureDetails[0]['id']."'>";
			 $htm .="<div class='form-row'>";
			  
			  $htm .="<div class='form-group col-md-3'>";
			  
			  $htm .="<label for='inputEmail4'>From</label>";
			  
			  $htm .="<input type='text' class='form-control fyDatepicker' id = 'stipend_from_id' name = 'stipend_from' value = '".$expenditureDetails[0]['stipend_from']."' placeholder='From'>";
			  
			  $htm .="</div>";
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>To</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_to' id='stipend_to_id'  value = '".$expenditureDetails[0]['stipend_to']."' placeholder='To'>";
			  $htm .="</div>";
			  $htm .="</div>";				
				
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Mode</label>";
			  $htm .="<select class='form-control' id ='stipend_mode_id' name='stipend_mode' onchange='showStipendMode(this.id);'>";
	          $htm .="<option value=''>Mode</option>";
			  if($expenditureDetails[0]['stipend_mode'] == '1'){
				  $htm .="<option value='1' selected>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
			  }
			    if($expenditureDetails[0]['stipend_mode'] == '2'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2' selected>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				 
				  
			  }
			 
			    if($expenditureDetails[0]['stipend_mode'] == '3'){
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3' selected>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			
			    if($expenditureDetails[0]['stipend_mode'] == '4'){
				
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4' selected>RTGS</option>";
				  $htm .="<option value='5'>Other</option>";
				  
			  }
			    if($expenditureDetails[0]['stipend_mode'] == '5'){
					
				  $htm .="<option value='1'>Cash</option>";
				  $htm .="<option value='2'>Cheque</option>";
				  $htm .="<option value='3'>NEFT</option>";
				  $htm .="<option value='4'>RTGS</option>";
				  $htm .="<option value='5' selected>Other</option>";
				} 
			  						 		
			   $htm .="</select>";
			   $htm .="</div>";
           
			
		      $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Amount</label>";
			  $htm .="<input type='text' class='form-control' name = 'amount' id='amount_id'  value = '".$expenditureDetails[0]['amount']."' placeholder='Amount'>";
			  $htm .="</div>";
		   
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Expenditure Document</label></br>";
			  if($expenditureDetails[0]['doc']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['doc']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  $htm .="<input name ='doc' type='file' class='form-control' id='doc'>";
			  
			  //$htm .="<a href='#' data-toggle='modal' class='upload_link' data-target ='#expDiv'>Re-Upload</a>";
			  $htm .="</div>";
		   
			
			  $htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Name of Officer</label>";
			  $htm .="<input type='text' class='form-control' name = 'stipend_off_name' id='inputPassword4' value = '".$expenditureDetails[0]['stipend_off_name']."' placeholder='Name'>";
			  $htm .="</div>";
		   
		   
				$htm .="<div class='form-group col-md-3'>";
			  $htm .="<label>Signature</label></br>";
			  if($expenditureDetails[0]['stipend_off_sign']){
				  $htm .="<a target='_blank' href='".site_url().'assets/site/main/expenditure_doc/'.$expenditureDetails[0]['stipend_off_sign']."'><i class='fa fa-file-pdf-o fa-1x text-red' title='Click to View Document'></i>Click to View Document</a></br></br>"; 
			  }
			  
			  $htm .="<div class='form-group col-md-6'>";
			  $htm .="<label>Signature</label>";
			  $htm .="<input type='file' class='form-control' name = 'stipend_off_sign' id='inputPassword4'>";
			  $htm .="</div>";
		   
			  
			  
			  $htm .="<div class='form-group col-md-8 pull-left'>";					    
			  $htm .="<div class='col-sm-8'>";
			  $htm .="<input type='submit' class='form-control sbmit' value='Submit'/>";
			  $htm .="</div>";				    
			  $htm .="</div>";
		   
              $htm .="</form>";
			  echo $htm;
           ?>
	  </div>
	</div>
	</div>

	</div>
</section>
<script>
$('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});
</script>
	
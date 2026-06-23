<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:133px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
.form-horizontal .control-label {
    padding-top: 7px;
    margin-bottom: 0;
    text-align: left;
    font-size: 12px;
}
input,select,label{font-size:14px !important;}
.tab-content input[type="text"], select {
    background: #fffdca none repeat scroll 0 0 !important;
    color: #747474 !important;
    font-size: 14px !important;
    font-weight: bold;
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
		<h3 class="text-center caps">VISA Endorsement</h3>
		<h4 class="text-center caps">APPLICATION NUMBER <?php echo $appno; ?></h4>		
	</div>
	<div class="headsec container">Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal</div>		
	<div  class="container" style="min-height:347px;padding:0px;">	

	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-visa" action="<?php echo site_url();?>mission/visaapply/<?php echo $appno; ?>" method="post" class="form-horizontal">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	   	 
            
            		
              		<div class="form-group col-xs-10">
					    <label for="inputEmail3" class="col-sm-2 control-label">VISA Type</label>
					    <div class="form-group col-md-4">
					      <select class="form-control">
					      	
					      	<?php 
					      	$course =$applicaitonStepOne[0]['programme'];
					      	if($counter == 3 || $counter == 4)
					      	{
							?>
								<option value="2">Research</option>
							<?php	
							}
							else
							{
							?>
								<option value="1">Student</option>
							<?php	
							}
					      	?>				      	
					      </select>
					    </div>
					</div>
					<div class="form-group col-xs-10">
					    <label for="inputEmail3" class="col-sm-2 control-label">VISA Number</label>
					    <div class="form-group col-md-4">
					     <input type="text" class="form-control" id="visa_no" name="visa_no" required="true" placeholder="VISA Number"/>
					    </div>
					</div>
					<div class="form-group col-xs-10">
					    <label for="inputEmail3" class="col-sm-2 control-label">VISA Issue Date</label>
					     <div class="form-group col-md-4">		
					      <input type="text" class="form-control datepicker_visa_issuedate" id="visa_issue_date" name="visa_issue_date" required="true" placeholder="VISA Issue Date"/>										
						</div>
					</div>				 
					<div class="form-group col-xs-10">					
					    <label for="inputEmail3" class="col-sm-2 control-label">VISA Duration</label>					   
					     <div class=" col-md-2 pdleft">	
					     		
					      <input type="text" class="form-control datepicker_visa_issuedate" id="visa_from_date" name="visa_from_date" required="true" placeholder="From"/>		
						</div>
						
						 <div class=" col-md-2 pdleft">	
						    <input type="text" class="form-control datepicker_visa_issuedate" id="duration_to_date" name="duration_to_date" required="true" placeholder="To"/>	 
						</div>
					</div>
				 	
					<div class="form-group col-xs-7">					    
					    <div class="col-sm-3">
					      <input type="submit" class="form-control sbmt" value="Submit"/>
					    </div>					    
					</div> 			
			</div>
              <!-- /.box-body -->
            </form>
	  </div>	
 
	</div>

	</div>
	
</section>
	
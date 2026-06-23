<?php //echo "<pre>";print_r($applicaitonStepOne);die;?>
<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:125px;margin:0 auto;text-align:center;}
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
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Expenditure Statement of Regional Offices</h3>			
	</div>
	
	<div  class="container" style="min-height:410px;padding-top:0px;">		
	<div class="tab-content">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>headquarter/createregionalExpenditure/<?php echo $appno;?>" method="post" class="form-horizontal">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				
              		<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Reagion</label>
					    <div class="col-sm-5">
						     <select id="region" name="region" class="selectpicker form-control">
						     		<option value="">Select</option>
								  <?php
								  $regions = $this->common_model->getAllRegions();
								  foreach($regions as $region)
								  {									  
									 echo '<option value="'.$region['id'].'">'.$region['name'].'</option>';
									 
								  }
								  ?>
							</select>
					    </div>
					</div> 
						<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Scheme</label>
					    <div class="col-sm-5">
						     <select id="scheme_name" name="scheme_name" class="selectpicker form-control">
						     		<option value="">Select</option>
								  <?php
								  $schems = $this->common_model->getAllSchemes();
								  foreach($schems as $region)
								  {									  
									 echo '<option value="'.$region['id'].'">'.$region['scheme_name'].'</option>';
									 
								  }
								  ?>
							</select>
					    </div>
					</div> 
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Code</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"   id="code" name="code" placeholder="Code">
					    </div>
					</div>
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">No of Scholars</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"   id="no_of_scholars" name="no_of_scholars" placeholder="No of Students">
					    </div>
					</div>
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Amount Released by Hqrs.</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"   id="amount_released" name="amount_released" placeholder="Amount Released">
					    </div>
					</div> 
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Stipend</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"   id="stipend" name="stipend" placeholder="Stipend">
					    </div>
					</div> 
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">HRA</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"   id="hra" name="hra" placeholder="HRA">
					    </div>
					</div>
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">ACA</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"  id="aca" name="aca" placeholder="ACA">
					    </div>
					</div>
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Hostel</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"  id="hostel" name="hostel" placeholder="Hostel">
					    </div>
					</div> 
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">TCF</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"  id="tcf" name="tcf" placeholder="TCF">
					    </div>
					</div> 
						<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">OCF</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"  id="ocf" name="ocf" placeholder="OCF">
					    </div>
					</div> 
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Misc.</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"  id="misc" name="misc" placeholder="Misc">
					    </div>
					</div> 
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Ticket Reimbursment</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"  id="ticket_reimbursment" name="ticket_reimbursment" placeholder="Misc">
					    </div>
					</div>
					<div class="form-group col-xs-12">
					    <label for="inputEmail3" class="col-sm-2 control-label">Date of Release</label>
					    <div class="col-sm-5">
					      <input type="text" class="form-control"  id="date_of_release" name="date_of_release" placeholder="Misc">
					    </div>
					</div> 
					<div class="form-group col-xs-6">					    
					    <div class="col-sm-4 pull-left">
					      <input type="submit" class="form-control sbmt"  value="Submit"/>
					    </div>					    
					</div> 			
			</div>
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	
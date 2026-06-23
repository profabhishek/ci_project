<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:90px;margin:0 auto;text-align:center;}
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
		<h3 class="text-center caps">Expenditure Statement of Student</h3>		
	</div>
	
	<div  class="container" style="min-height:410px;padding-top:0px;">		
	<div class="tab-content">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>headquarter/expendituredetails" method="post" class="form-horizontal">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	   	 
            
              		<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Country</label>
					    <div class="col-sm-8">
						     <select id="country" name="country" class="selectpicker form-control" required="true">
								  <option value="">---- Select ---</option>
								  <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
								  	echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
								  }
								  ?>
							</select>
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Date of Arrival</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="DD/MM/YYYY">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Scheme</label>
					    <div class="col-sm-8">
					      <select id="country" name="country" class="selectpicker form-control" required="true">
								  <option value="">---- Select ---</option>
								  <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
								  	echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
								  }
								  ?>
							</select>
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Duration</label>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="DD/MM/YYYY">
					    </div>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="DD/MM/YYYY">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Name</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Name">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Stipend</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Stipend Rate">
					    </div>					   
					</div>
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Course</label>
					    <div class="col-sm-8">
					      <select id="country" name="country" class="selectpicker form-control" required="true">
								  <option value="">---- Select ---</option>
								  <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
								  	echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
								  }
								  ?>
							</select>
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Stipend Period</label>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="From">
					    </div>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="To">
					    </div>
					</div>
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">University</label>
					    <div class="col-sm-8">
					     <select id="country" name="country" class="selectpicker form-control" required="true">
								  <option value="">---- Select ---</option>
								  <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
								  	echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
								  }
								  ?>
							</select>
					    </div>
					</div> 
					 
					 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">HRA</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="HRA Rate">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">ACA</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="ACA Rate">
					    </div>
					</div>
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">HRA Period</label>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="From">
					    </div>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="To">
					    </div>
					</div> 
					 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">TF</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="TF">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Study Tour</label>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="From">
					    </div>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="To">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">OCF</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="OCF">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Ex India</label>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="From">
					    </div>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="To">
					    </div>
					</div>
						<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Hostel</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Hostel">
					    </div>
					</div>
					
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Amount Deducted</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Amount Deducted">
					    </div>
					</div>
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Medical Reimbursment</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Medical Reimbursment">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Thesis charges</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Thesis charges">
					    </div>
					</div>
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Ticket Reimbursment</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Ticket Reimbursment">
					    </div>
					</div> 
					 
				
				
					
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Discontinued Due to Failure</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="Discontinued">
					    </div>
					</div> 
					<div class="form-group col-xs-6">
					    <label for="inputEmail3" class="col-sm-4 control-label">Scholarship Extended</label>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="From">
					    </div>
					    <div class="col-sm-4">
					      <input type="email" class="form-control" id="inputEmail3" placeholder="To">
					    </div>
					</div> 	
					<div class="form-group col-xs-6">					    
					    <div class="col-sm-4 pull-right">
					      <input type="submit" class="form-control sbmt" id="inputEmail3" value="Submit"/>
					    </div>					    
					</div> 			
			</div>
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	
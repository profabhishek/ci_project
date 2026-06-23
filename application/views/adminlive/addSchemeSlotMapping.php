   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Seats Allotment for Different Schemes 
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Seats Allotment for Different Schemes</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Create Seats Allotment for Different Schemes</div>
			<?php echo form_open('admin/createSeatsAllotmentMapping',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Schemes</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="schemes" name="schemes" required="true">
                    	 <option value="">---- Schemes ---</option>
						  <?php
						  $schemses = $this->common_model->getAllSchemes();
						  foreach($schemses as $scheme)
						  {
						  	echo '<option value="'.$scheme['id'].'">'.$scheme['scheme_name'].'</option>';
						  }
						  ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                    <select name="schemecountry[]" multiple="true" id="schemecountry" title="Please select Country" class="form-control" required="true" style="height:400px;">
						<option value="">---- Country ---</option>
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
             
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Scheme Type</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="seats" name="seats" placeholder="Scheme Type" required="true" type="text">
                  </div>
                </div>              
              </div>
              <!-- /.box-body -->
              <div class="box-footer">                
                <button type="submit" class="btn btn-success pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            <?php echo form_close(); ?>
       </div>
       </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
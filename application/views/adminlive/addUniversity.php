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
        University 
        <small>Create University</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> University</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Create University</div>
			<?php echo form_open('admin/createUniversity',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Region</label>
                  <div class="col-sm-10">
                    <select name="region" id="region" title="Please select Region" class="form-control" required="true">
						<option value="">---- Region ---</option>
						  <?php
						  $regions = $this->common_model->getAllRegions();						 
						  $this->common_model->array_sort_by_column($regions,'name');
						  foreach($regions as $region)
						  {
						  	echo '<option value="'.$region['id'].'">'.$region['name'].'</option>';
						  }
						  ?>
					</select>
                  </div>
                </div>      
                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">University Type</label>
                  <div class="col-sm-10">
                    <select name="university_type" id="university_type" title="Please select Region" class="form-control" required="true">
						<option value="">---- Type ---</option>
						<option value="1">Central University</option>  
						<option value="2">State University</option>  
						<option value="3">National Institute of Technology (NIT)</option>  
						<option value="4">Guru's</option>  
					</select>
                  </div>
                </div>           
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">University Name</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="university_name" name="university_name" placeholder="University Name" type="text" required="true">
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Subject</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="subject" name="subject" placeholder="Subject" type="text" required="true">
                  </div>
                </div>
				 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="title" name="subject" placeholder="Title" type="text" required="true">
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10">
                    <select name="status" id="status" title="Please select Status" class="form-control" required="true">
						<option value="">---- Selet Type ---</option>
						<option value="1">Enabled</option>  
						<option value="0">Disabled</option> 
					</select>
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
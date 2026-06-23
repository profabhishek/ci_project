   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Regional Office 
        <small>Create Regional Office</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Regional Office</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Create Regional Office</div>
			<?php echo form_open('admin/createRegionalOffice',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Regional Name</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="username" name="username" placeholder="Region Name" type="text" required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Region</label>
                  <div class="col-sm-10">
                    <select name="state" id="state" title="Please select Region" class="form-control" required="true">
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Regional Email</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="email_id" name="email_id" placeholder="Email Id" type="text" required="true">
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
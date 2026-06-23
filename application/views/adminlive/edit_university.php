   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php if($this->session->flashdata('message')) {

$flash_data = $this->session->flashdata('message');

		if($flash_data['type'] == 'error' && isset($flash_data['type'])) {
				foreach ($flash_data['errors'] as $e) { ?>
					<div class="alert alert-danger alert-dismissible">
						<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Error ! </strong> <?php echo $e; ?>
					</div>
				<?php } ?>
		<?php } 
		if($flash_data['type'] == 'success' && isset($flash_data['type'])) { ?>
			<div class="alert alert-success alert-dismissible">
			<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success ! </strong> <?php  echo $flash_data['message']; ?>
			
			</div>
		<?php } 
		?>
<?php } ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        University 
        <small>Update University</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/universitiesList"><i class="fa fa-dashboard"></i> University</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Update University</div>
			<?php echo form_open('admin/updateUniversity',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Region</label>
                  <div class="col-sm-10">
                 
				 <input class="form-control" disabled="disabled" id="university_name" name="university_name" placeholder="University Name" type="text" value="<?php echo $university[0]['statename']?>" required="true">		
					
                  </div>
                </div>      
                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">University Type</label>
                  <div class="col-sm-10">
				  <?php if($university[0]['university_type'] == 1){$type = "Central University";}?>
				  <?php if($university[0]['university_type'] == 2){$type = "State University";}?>
				  <?php if($university[0]['university_type'] == 3){$type = "National Institute of Technology (NIT)";}?>
				  <?php if($university[0]['university_type'] == 4){$type = "Guru's";}?>
				   <input class="form-control" id="university_name" name="university_name" placeholder="University Name" type="text" value="<?php echo $type;?>" required="true">	
				 
                  </div>
                </div>           
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">University Name</label>
                  <div class="col-sm-10">
				   <input class="form-control" disabled="disabled" id="university_name" name="state" placeholder="University Name" type="text" value="<?php echo $university[0]['name'];?>" required="true">	
                     
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">University Link</label>
                  <div class="col-sm-10">
				   <input class="form-control" id="university_name" name="university_link" placeholder="University Link" type="text" value="<?php echo $university[0]['link'];?>" required="true">	
                   
                  </div>
                </div>
				 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="title" value="<?php echo $university[0]['title'];?>" name="title" placeholder="Title" type="text" required="true">
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10">
                    <select name="status" id="status" title="Please select Status" class="form-control" required="true">
						<option value="">---- Selet Type ---</option>
						<option value="1" <?php if($university[0]['status'] == 1)echo 'selected="selected"';?>>Enabled</option>  
						<option value="0"<?php if($university[0]['status'] == 0)echo 'selected="selected"';?>>Disabled</option> 
					</select>
                  </div>
                </div>
				<input type="hidden" value="<?php echo $university[0]['id'];?>" name="id">
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
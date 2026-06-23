<?php 
if($this->session->flashdata('message')) {
		$flash_data = $this->session->flashdata('message');
		if($flash_data['type'] == 'success' && isset($flash_data['success'])) { 
			  echo $flash_data;
		 } 
		if($flash_data['type'] == 'danger' && isset($flash_data['danger'])) { 
			 echo $flash_data; 
		 } 
 } 
 ?>

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
        Add Testimonials      
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Add Testimonials</a></li>       
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header"></div>
			<?php echo form_open('admin/createTestimonials',array('class'=>'form-horizontal','method'=>'POST','enctype'=>"multipart/form-data")); ?>
              <div class="box-body">
				
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Title</label>               
				    <div class="col-sm-6">				   
					 <input class="form-control" id="title" name="title" placeholder="Title" type="text" required>
                    </div>
				</div>
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Student Name</label>               
				    <div class="col-sm-6">				   
					 <input class="form-control" id="title" name="student_name" placeholder="Name" type="text">
                    </div>
				</div>
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Country</label>               
				    <div class="col-sm-6">				   
					 <input class="form-control" id="title" name="country" placeholder="Country" type="text">
                    </div>
				</div>
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Course</label>               
				    <div class="col-sm-6">				   
					 <input class="form-control" id="title" name="course" placeholder="Course" type="text">
                    </div>
				</div>
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Testimonial Url</label>               
				    <div class="col-sm-6">				   
					 <input class="form-control" id="testimonials_url" name="testimonials_url" placeholder="Testimonials Url" type="text" required>
                    </div>
				</div>
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">File</label>               
				    <div class="col-sm-6">				   
					 <input class="form-control" id="file" name="testimonials_doc" type="file">
                    </div>
				</div> 
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">End Date</label>
					<div class="col-sm-6">
					<input class="form-control" id="validated_upto" readonly name="validated_upto" placeholder="End Date" type="text" required>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
$(document).ready(function(){
	
	 $("#validated_upto").datepicker({
		dateFormat: 'dd-mm-yy' 
	});
})
	
			
</script>      
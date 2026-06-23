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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Notification      
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Add Notification</a></li>       
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header"></div>
			<?php echo form_open('admin/createNotification',array('class'=>'form-horizontal','method'=>'POST','enctype'=>"multipart/form-data")); ?>
              <div class="box-body">
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Title</label>               
				    <div class="col-sm-6">				   
					 <input class="form-control" id="title" name="title" placeholder="Title" type="text" required>
                    </div>
				</div>
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">File</label>               
				    <div class="col-sm-6">				   
					 <input class="form-control" id="file" name="notification_doc" type="file">
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
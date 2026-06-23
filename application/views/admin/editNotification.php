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
        Edit Notification      
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>       
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
    <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header"></div>
			
				<form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo base_url('admin/updateNotification')?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					<input type ="hidden" value="<?php echo $notifications[0]['id']?>" name="id">
					<div class="box-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Title</label>               
						<div class="col-sm-6">
						<input type="text" name="title" class="form-control"value="<?php echo $notifications[0]['title']; ?>" required/>
						</div>
					</div>
					<?php if(isset($notifications[0]['notification_doc']) && !empty($notifications[0]['notification_doc']) &&  file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/site/main/notification/'.$notifications[0]['notification_doc'])){?>
					<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Old Document</label>               
						<div class="col-sm-6">
					 <a target="_blank" href="<?php echo site_url().'assets/site/main/notification/'.$notifications[0]['notification_doc']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
					 </div>
					<input type="hidden" name="old_file"  value="<?php echo isset($notifications[0]['notification_doc'])?$notifications[0]['notification_doc']:"";?>"/> 
					</div>
					
					<?php } ?>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">File</label>               
						<div class="col-sm-6">				   
						<input class="form-control" id="file" name="notification_doc" type="file">
						</div>
					</div>
					     
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">End Date</label>
					<div class="col-sm-6">
					<input class="form-control" id="validated_upto" readonly name="validated_upto" value="<?php echo date('d-m-Y',strtotime($notifications[0]['validated_upto']))?>" placeholder="End Date" type="text" required>
					</div>
				</div>					
				</div>
				 <div class="box-footer">   
					<button type="submit" class="btn btn-success pull-right">Submit</button>
				</div>
				</form>
			</div>
       </div>
    </div>
</section>
    <!-- /.content -->
</div>
<script type="text/javascript">
$(document).ready(function(){
	 $("#validated_upto").datepicker({
		dateFormat: 'dd-mm-yy' 
	});
})
	
			
</script>  

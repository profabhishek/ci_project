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
        Edit Scheme      
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
			
			<form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo base_url('admin/updateScheme')?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					<input type ="hidden" value="<?php echo $schemes[0]['id']?>" name="id">
					<div class="box-body">
				<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Scheme Name</label>               
						<div class="col-sm-6">
						<input type="text" name="scheme_name" class="form-control"value="<?php echo $schemes[0]['scheme_name']; ?>" required/>
						</div>
				</div>
				<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Scheme Description</label>               
						<div class="col-sm-6">
						<textarea class="form-control" cols="6" rows="6" id="desc"  name="desc"><?php echo isset($schemes[0]['desc'])?$schemes[0]['desc']:"";?></textarea>
					
						</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Status</label>
					<div class="col-sm-6">					
					<?php if($schemes[0]['status']==1){?>					
						<input type="radio" name="status"  checked="checked" value="1" />Active
						<input type="radio" name="status"  value="0" />Archive
					<?php } ?>
					<?php if($schemes[0]['status']==0){?>					
						<input type="radio" name="status"  value="1" />Active
						<input type="radio" name="status"checked="checked"  value="0" />Archive
					<?php } ?>
					</div>
				</div>					
				</div>
				 <div class="box-footer">   
					<button type="submit" class="btn btn-success pull-right">Submit</button>
					<a class="btn btn-success" style="float:right;margin-right:10px" href="<?php echo base_url('admin/allSchemes/'); ?>"> Back</i></a>
				</div>
				</form>
			</div>
       </div>
    </div>
</section>
    <!-- /.content -->
</div>

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
		if($flash_data['type'] == 'errorupdate' && isset($flash_data['type'])) { ?>
			<div class="alert alert-danger alert-dismissible">
			<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Error ! </strong> <?php  echo $flash_data['message']; ?>
			</div>
		<?php } ?>
<?php } ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Page      
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
			
				<form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo base_url('admin/page/update/'.$page[0]['page_slug'])?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					<div class="box-body">
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Page Title</label>               
						<div class="col-sm-6">
						<input type="text" name="page_title" class="form-control"value="<?php echo $page[0]['page_title']; ?>" required/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
						<textarea name="page_description" class="form-control" id="summernote" required><?php echo $page[0]['page_description']; ?></textarea>
						</div>
					</div>
					<script type="text/javascript">
					CKEDITOR.replace('summernote',{
					width: "100%",
					height: "200px"
					}
					);
					</script>
					<?php if(!empty($page[0]['page_main_image']) && $page[0]['master_page_id'] == 1){?>
					<div class="form-group" id="page_image" style="display:none">
					<label for="inputEmail3" class="col-sm-2 control-label">Page Image</label>
					<div class="col-sm-10">
					<input type="file" name="page_main_image"/>
					</div>
					</div>
					<?php if(!empty($page[0]['page_main_image']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/site/main/page_main_image/'.$page[0]['page_main_image'])){?>
					<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Old Page Image</label>
					<div class="col-sm-6">
					<img  style="width:150px;max-height:100px;" src="<?php echo site_url(); ?>assets/site/main/page_main_image/<?php echo $page[0]['page_main_image']; ?>"/>
					</div>
					</div>	
					<?php } ?>
					<?php } ?>
					<div class="form-group">
					
						<label for="inputEmail3" class="col-sm-2 control-label" style="text-decoration: underline;">SEO Information</label>
					
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Meta Title</label>
						<div class="col-sm-6">
						<input type="text" name="meta_title" class="form-control" value="<?php echo $page[0]['meta_title']; ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Meta Description</label>
						<div class="col-sm-10">
						<textarea name="meta_description" id="meta_description" class="form-control" rows="5"><?php echo $page[0]['meta_description']; ?></textarea>
						</div>
					</div>
					<script type="text/javascript">
					CKEDITOR.replace('meta_description',{
					width: "100%",
					height: "200px"
					}
					);
					</script>
						
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Meta Keywords</label>
						<div class="col-sm-10">
						<textarea name="meta_keyword" id="meta_keyword" class="form-control"><?php echo $page[0]['meta_keyword']; ?></textarea>
						</div>
					</div>
					<script type="text/javascript">
					CKEDITOR.replace('meta_keyword',{
					width: "100%",
					height: "200px"
					}
					);
					</script>
					
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
<script>
 $(document).ready(function(){
$('#page_category').change(function(){
		var pagecategory = $('#page_category').val();
		if(pagecategory == 1){
		$('#page_image').show();
		}else{
		$('#page_image').hide();	
		}
	});
 });
</script>

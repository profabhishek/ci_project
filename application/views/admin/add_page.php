<?php if($this->session->flashdata('message')) {

$flash_data = $this->session->flashdata('message');

		if($flash_data['type'] == 'error' && isset($flash_data['errors'])) {
				foreach ($flash_data['errors'] as $e) { ?>
					<div class="alert alert-danger alert-dismissible">
						<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Error ! </strong> <?php echo $e; ?>
					</div>
				<?php } ?>
		<?php } 
		if($flash_data['type'] == 'success' && isset($flash_data['success'])) { ?>
			<?php  echo $flash_data; ?>
		<?php } ?>
<?php } ?>

   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Page      
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Add Page</a></li>       
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header"></div>
			<?php echo form_open('page/create',array('class'=>'form-horizontal','enctype'=>"multipart/form-data")); ?>
              <div class="box-body">
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Master Page Category</label>               
				   <div class="col-sm-6">
				   <select class="form-control" name="master_page_id" id="page_category">
				   <option value="">--Select Page Category--</option>
				   <option value="0">No Master Category</option>
				   <option value="1">About Us</option>
				   <option value="2">Schemes</option>
				   <option value="3">Instructions</option>
				   <option value="4">FAQ'S</option>
				   </select>
                 
                </div>
				</div>
                <div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Page Title</label>               
				   <div class="col-sm-6">
                  <input class="form-control" id="page_title" name="page_title" placeholder="Page Title" type="text" required>
                </div>
				</div>
               <div class="form-group">
					 <label for="inputEmail3" class="col-sm-2 control-label">Slug</label>
					 <div class="col-sm-6">
					<input class="form-control" id="page_slug" name="page_slug" placeholder="Page Slug" type="text" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10">
					<textarea name="page_description" class="form-control"  id="summernote"></textarea>
					</div>
				</div>     
				<script type="text/javascript">
                CKEDITOR.replace('summernote',{
                width: "100%",
                height: "200px"
                }
                );
				</script>
				<div class="form-group" id="page_image" style="display:none">
					<label for="inputEmail3" class="col-sm-2 control-label">Page Image</label>
					<div class="col-sm-10">
					<input type="file" name="page_main_image"/>
					</div>
				</div>				
                 <div style="text-align:center;padding-bottom: 20px;">
                  <label style="text-decoration: underline;">SEO Information</label>
                </div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Meta Title</label>
					<div class="col-sm-6">
					 <input type="text" name="meta_title" class="form-control"/>
					 </div>
				</div>   
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Meta Description</label>
					<div class="col-sm-10">
					<textarea name="meta_description" id="meta_description" class="form-control" rows="5"></textarea>
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
					<label for="inputEmail3" class="col-sm-2 control-label">Meta Keyword</label>
					<div class="col-sm-10">
					<textarea name="meta_keyword" id="meta_keyword" class="form-control" rows="5"></textarea>
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
  
<script>
    $(document).ready(function(){
        $('input[type="text"][name="page_title"]').on('keyup', function(){
			
            $this = $(this);
            text = $this.val();

            $('input[type="text"][name="page_slug"]').val('');
            if(text !="")
            {
                var slug = convertToSlug(text);
                $('input[type="text"][name="page_slug"]').val(slug);
            }
        })

    });
	$('#page_category').change(function(){
		var pagecategory = $('#page_category').val();
		if(pagecategory == 1){
		$('#page_image').show();
		}else{
		$('#page_image').hide();	
		}
	})

    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-')
            ;
    }

</script>
<style type="text/css">
	#frm_details_ngo {
    float: right;
    position: absolute !important;
    right: 0;
    top: 11px !important;
}
.blue-heading h3
{
	margin-top: 13px !important;
	font-weight: bold;
    
}
marquee{
	
    border: 1px solid #cecece;
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto 5px;
    padding: 7px 5px 0;
    text-align: left;
}
</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">
		<marquee>Welcome <?php echo $universityData[0]['name']; ?> to ICCR Scholarship Portal</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3>Add Page</h3>
			 <form method="post" action="<?php echo base_url();?>university/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>university/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
	<div class="row">
		<div class="col-12 col-sm-12 col-md-3 left-menu-sec">
			<div id="sidebar-wrapper">       
	        <ul class="sidebar-nav" id="sidebar">
	          <li><a href="<?php echo site_url(); ?>university/new_applications">Applications Received<span class="pull-right fltright"><?php echo $newCountApplication;?></span></a></li>	           
	          <li><a href="<?php echo site_url(); ?>university/pending_application">Pending Application<span class="pull-right fltright"><?php echo $countpending_application; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/resubmitapplication">Cases of Re-Subuniversity by Applicant<span class="pull-right fltright"><?php echo $countresubmitapplication; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/hold_applications">Applications on Hold<span class="pull-right fltright"><?php echo $countholdapplications; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/approved_applications">Processed Applications<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/confirmaitonreceivesformhqrs">Confirmation from University/Institute<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
	           <li><a href="<?php echo site_url(); ?>university/listofacceptance">Acceptance/Decline by Applicant<span class="pull-right fltright"><?php echo $countlistofacceptance; ?></span></a></li>
			    <li><a href="<?php echo site_url(); ?>university/visaendrosment">Student/Research VISA Endorsement<span class="pull-right fltright"><?php echo $countvisaendrosment; ?></span></a></li>
	             <li><a href="<?php echo site_url(); ?>university/travel_applications">Travel Plan of Applicant<span class="pull-right fltright"><?php echo $counttravel; ?></span></a></li>
				 <li><a href="<?php echo site_url();?>university/addStream"><i class="fa fa-book"></i>Create Stream</a></li>
				  <li><a href="<?php echo site_url();?>university/addStreamMapping"><i class="fa fa-book"></i>Create Stream mapping</a></li>
				 <li><a href="<?php echo site_url();?>university/addPages"><i class="fa fa-book"></i> Create Page</a></li>
	        </ul>
    </div>
		</div>
		<div class="col-12 col-sm-12 col-md-9">
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
        <li><a href="<?php echo site_url();?>university/dashboard"><i class="fa fa-dashboard"></i>Home</a></li>       
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header"></div>
			<?php echo form_open('university/create',array('class'=>'form-horizontal','enctype'=>"multipart/form-data")); ?>
              <div class="box-body">
				<div class="form-group">
				 <label for="inputEmail3" class="col-sm-2 control-label">Master Page Category</label>               
				   <div class="col-sm-6">
				   <select class="form-control" name="master_page_id" id="page_category">
				   <option value="">--Select Page Category--</option>
				   <option value="0">No Master Category</option>
				   <option value="about-us">About Us</option>
				   <option value="mission-vision">Mission & Vision</option>
				   <option value="whos-who">Who's Who</option>
				   <option value="contact-us">Contact Us</option>
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
		//alert(pagecategory);
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
		</div>
		</div>
		<hr/>
	</div>

</div>
<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">UPDATE ENGLISH TEST MARKS OF STUDENT</h4>
                        </div>
                        <div class="modal-body">
     
						</div>
	<div class="modal-footer">
	<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
	<!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
           
	
	</div>
                    </div>
                  
                </div>
            </div>
			
</section>


	<script src="<?php echo base_url();?>assets/site/main/js/bootbox/bootbox.min.js"></script>
<script type='text/javascript'>
	function editApp(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('mission/editApplication')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}
</script>
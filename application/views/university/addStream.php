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
			 <h3>Add Streams</h3>
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
		<!-------<div class="col-12 col-sm-3 col-md-3 left-menu-sec">
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
		</div>---->
		<div class="col-12 col-sm-9 col-md-12 customdiv">
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Streams
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>university/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
	
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Create Stream </div>
			<?php echo form_open('university/createStream',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Programme</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="programme_university" name="programme_university" required="true">
                    	 <option value="">---- Programme ---</option>
						  <?php
						  $programmes = $this->common_model->getAllProgramme();
						  foreach($programmes as $progm)
						  {
						  	echo '<option value="'.$progm['id'].'">'.$progm['name'].'</option>';
						  }
						  ?>
                    </select>
                  </div>
                </div>
				 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Course Type</label>
                  <div class="col-sm-10">
                    <select name="university_course_type" id="university_course_type" class="form-control" required="true">
						<option value="">---- Course Type---</option>
						  <?php
						  $courseType = $this->common_model->getAllCourseTypeWithoutAyush();
						  foreach($courseType as $type)
						  {
						  	echo '<option value="'.$type['id'].'">'.$type['course_type'].'</option>';
						  }
						  ?>
					</select>
                  </div>
                </div>
				 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Courses</label>
                  <div class="col-sm-10">
                    <select name="university_course" id="university_courses" title="Please select Course" class="form-control" required="true">
						<option value="">---- Courses ---</option>
						  <?php
						  //$streams = $this->university_model->getAllStream();
						  //foreach($streams as $strm)
						  //{
						  	//echo '<option value="'.$strm['id'].'">'.$strm['name'].'</option>';
						  //}
						  ?>
					</select>
                  </div>
                </div>
				
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Streams/Branch</label>
                  <div class="col-sm-10">
                    <!----<input class="form-control" id="stream" name="stream" placeholder="Streams/Branch" required="true" type="text">--->
					 <select name="university_stream" id="university_stream" title="Please select Stream/branch" class="form-control" required="true">
						<option value="">---- Streans/Branch ---</option>
						  <?php
						  //$streams = $this->university_model->getAllStream();
						  //foreach($streams as $strm)
						  //{
						  	//echo '<option value="'.$strm['id'].'">'.$strm['name'].'</option>';
						  //}
						  ?>
					</select>
                  </div>
                </div>
             
               <!----<div class="form-group" style="display:none;">
                  <label for="inputPassword3" class="col-sm-2 control-label">Add Streams/Branch</label>
                  <div class="col-sm-10">
                     <input class="form-control" id="stream" name="stream" placeholder="Streams/Branch" required="true" type="text">
                  </div>
                </div>---->            
              </div>
              <!-- /.box-body -->
              <div class="box-footer">                
                <button type="submit" class="btn btn-success pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            <?php echo form_close(); ?>
    
       </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
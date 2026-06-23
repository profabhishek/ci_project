   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Streams
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
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
			<?php echo form_open('admin/createStream',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
			   <!-----<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Universtiy Name</label>
                  <div class="col-sm-10">
                    <select name="universtiy" id="universtiy" class="form-control">
						<option value="" label="" >---- University Name ---</option>
						  <?php
						  $countries = $this->common_model->getAllUniversities();
						  foreach($countries as $country)
						  {
						  	echo '<option value="'.$country['name'].'" class="'.$country['state_id'].'"  id="'.$country['link'].'">'.$country['name'].' ========== ( Region: '.$country['statename'].'),(State : '.$country['stname'].')</option>';
						  }
						  ?>
					</select>
                  </div>
                </div>---->
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Programme</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="programme_admin" name="programme_university" required="true">
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
                    <select name="university_course_type" id="admin_course_type" class="form-control" onchange="getCourseByAdmin(this.id)" required="true">
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
                    <select name="university_course" id="admin_courses" title="Please select Course" class="form-control" required="true">
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
				
                <!---<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Streams/Branch</label>
                  <div class="col-sm-10">
                    <!----<input class="form-control" id="stream" name="stream" placeholder="Streams/Branch" required="true" type="text">
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
                </div>--->
             
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Add Streams/Branch</label>
                  <div class="col-sm-10">
                     <input class="form-control" id="stream" name="stream" placeholder="Streams/Branch" required="true" type="text">
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
  <script type="text/javascript">
  //admin
$('#admin_course_type').change(function(){

	var university_pg =$('#programme_admin').val()
	alert(university_pg);
	var university_course_type =$('#admin_course_type').val()
	//alert(university_pg);
			if(university_pg == 1 || university_pg == 2  || university_pg == 8)
			{
				
					$.ajax({
					type: "POST",
					url: baseURL +'admin/getUniversityCourseProgramme',	   
					data: {"university_pg":university_pg,"university_course_type":university_course_type},
						success: function (data) {
						$("#admin_courses").html(data);
						}
					})
			}
});
</script>
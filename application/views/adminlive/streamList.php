   <!-- Content Wrapper. Contains page content -->
   <script type="text/javascript">
   	/* var universities = [];
   	
   	function updateUniversity(id)
   	{
		var obj = universities[id];
		$('#region_one').val(obj.state);
		$('#university_one').val(id);
		$('#universityid').val(id);
		
		stat_one
		
		
	}
	$(document).ready(function(){
		$("#frm_university").submit(function() {   
		var  formID = $(this).attr('id');
		var formDetails = $('#'+formID);	
			alert();
		$.ajax({
		    type: "GET",
		    url: baseURL +'admin/updateUniversity',
		    data: formDetails.serialize(),
		    dataType:'json',
		    success: function (data) {	
			alert(data);
		    	if(data.status == true)
		    	{
		    		BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Update Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "admin/allUniversities";}}]});
				}
		      },
		        error: function(jqXHR, text, error){
		                
		      }
		   });
		        return false;
		  });
	}); */
   </script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Streams 
        <small>All Streams</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allStreams"><i class="fa fa-dashboard"></i> Stream List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Stream List<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadUniversityList">
			<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/></a></div><div class="pull-right"><a href="<?php echo site_url();?>admin/addStream">Add Stream</a></div></div>
			
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>	       			       		
	       		<th>Stream Name</th>
				<th>Programme</th>
	       		<th>Course Type</th>	
	       		<th>Course </th>	       		
	       			       		      		
	       	</thead>
	       	<tbody>
	       		<?php		
	       		$counter = 1;
	       		foreach($universities as $university)
	       		{
	       			
				?>
							
				<tr>
					
					<td><?php echo $counter;?></td>
					<td><?php echo $university['name'];?></td>
					<td><?php 
					$programme = $this->admin_model->getProgrammeById($university['programme_id']);
					echo $programme[0]['name'];
					
					
					?></td>	
					<td>
					
					
					<?php 
					//echo "<pre>";print_r($university);die;
					$courseType = $this->admin_model->getCourseTypesbyId($university['course_type_id']);
					echo $courseType[0]['course_type'];
					
					?>
					
					</td>													
					<td>
					<?php 
					
					//echo "<pre>";print_r($university);die;
					$course = $this->admin_model->getCoursesById($university['course_id']);
					echo $course[0]['title'];
		
					
					?>
					</td>													
																	
															
					 <!-----<td>
                  <a href="<?php echo site_url('admin/editUniversity/'.$university['id']);?>" class="icon_link edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<span class="space">&nbsp;&nbsp;&nbsp;</span>
				<a href="javascript:void(0);" class="icon_link delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
								</td>---->
				</tr>
				<?php	
				$counter++;
				}
	       		?>
	       	</tbody>
	       </table>
      		</div>
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
 <div id="updateUniversity" class="modal fade" role="dialog">
  	<div class="modal-dialog popup">
  		    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Update University</div>
			
			<form id="frm_university" name="frm_university" method="post">
              <div class="box-body">
              	<input type="hidden" id="universityid" name="universityid" value="0"/>
                <div class="form-group" style="height: 38px;">
                  <label for="inputEmail3" class="col-sm-2 control-label">Region</label>
                  <div class="col-sm-10">
                    <select name="region_one" id="region_one" title="Please select Region" class="form-control" required="true">
						<option value="">---- Region ---</option>
						  <?php
						  $regions = $this->common_model->getAllRegions();						 
						  $this->common_model->array_sort_by_column($regions,'name');
						  foreach($regions as $region)
						  {
						  	echo '<option value="'.$region['id'].'">'.$region['name'].'</option>';
						  }
						  ?>
					</select>
                  </div>
                </div>    
               <div class="form-group"  style="height: 38px;">
                  <label for="inputPassword3" class="col-sm-2 control-label">University Name</label>
                  <div class="col-sm-10">
                     <select name="university_one" id="university_one" title="Please select University" class="form-control" required="true">
						<option value="">---- University ---</option>
						  <?php
						  foreach($universities as $university)
	       				  {
	       				  ?>
	       				  <option value="<?php echo $university['id'];?>"><?php echo $university['name'];?></option>
	       				  <?php	
	       				  }	
						  ?>
					</select>
                  </div>
                </div>
                 <div class="form-group"  style="height: 38px;">
                  <label for="inputPassword3" class="col-sm-2 control-label">University Name</label>
                  <div class="col-sm-10">
                     <select name="stat_one" id="stat_one" title="Please select University" class="form-control" required="true">
						<option value="">---- States ---</option>
						  <?php
						  $states = $this->common_model->getAllStates();
						  foreach($states as $state)
	       				  {
	       				  ?>
	       				  <option value="<?php echo $state['id'];?>"><?php echo $state['name'];?></option>
	       				  <?php	
	       				  }	
						  ?>
					</select>
                  </div>
                </div> 
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-10">
                    <input class="form-control" value="" id="title" name="title" placeholder="Title" type="text" required="true">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">                
                <button type="submit" class="btn btn-success pull-right">Submit</button>
              </div>
              </form>
              
              <!-- /.box-footer -->           
       </div>
       </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
      <!-- /.row (main row) -->

    </section>		
  	</div>
  </div>
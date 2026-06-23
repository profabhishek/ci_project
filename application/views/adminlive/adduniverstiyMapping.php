   <!-- Content Wrapper. Contains page content -->
   <script type="text/javascript">
   	function updateStateid(id)
   	{
		var idd = $('#' + id + ' option:selected').attr('class');
		var lnk = $('#' + id + ' option:selected').attr('id');		
		$('#state_id').val(idd);
		$('#link').val(lnk);
	}
   </script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
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
      <h1>
        Universtiy Mapping
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Universtiy Mapping</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Create University Mapping</div>
			<?php echo form_open('admin/createUniverstiyMapping',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Regional Office</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="regions" name="regions" required="true">
                    	 <option value="">---- Region ---</option>
						  <?php
						  $regions = $this->common_model->getAllRegions();
						  foreach($regions as $reg)
						  {
						  	echo '<option value="'.$reg['id'].'">'.$reg['name'].'</option>';
						  }
						  ?>
                    </select>
                  </div>
                </div>
             
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">UG Course Type</label>
                  <div class="col-sm-10">
                    <select multiple="true" class="form-control" id="ug_courser_typ_id" name="ug_courser_typ_id[]"  style="min-height:195px;">
                    	 <option value="">---- UG Course Type ---</option>
						  <?php
						  $ctype = $this->common_model->getAllCourseType();
						  foreach($ctype as $ctyp)
						  {
						  	echo '<option value="'.$ctyp['id'].'">'.$ctyp['course_type'].'</option>';
						  }
						  ?>
                    </select>
                  </div>
                </div>
                  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">PG Course Type</label>
                  <div class="col-sm-10">
                    <select multiple="true" class="form-control" id="pg_courser_typ_id" name="pg_courser_typ_id[]"  style="min-height:195px;">
                    	 <option value="">---- PG Course Type ---</option>
						  <?php
						  $ctype = $this->common_model->getAllCourseType();
						  foreach($ctype as $ctyp)
						  {
						  	echo '<option value="'.$ctyp['id'].'">'.$ctyp['course_type'].'</option>';
						  }
						  ?>
                    </select>
                  </div>
                </div>
                  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Mphil Course Type</label>
                  <div class="col-sm-10">
                    <select multiple="true" class="form-control" id="mhphil_courser_typ_id" name="mhphil_courser_typ_id[]"  style="min-height:195px;">
                    	 <option value="">---- Mphil Course Type ---</option>
						  <?php
						  $ctype = $this->common_model->getAllCourseType();
						  foreach($ctype as $ctyp)
						  {
						  	echo '<option value="'.$ctyp['id'].'">'.$ctyp['course_type'].'</option>';
						  }
						  ?>
                    </select>
                  </div>
                </div>
                  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Phd Course Type</label>
                  <div class="col-sm-10">
                    <select multiple="true" class="form-control" id="phd_courser_typ_id" name="phd_courser_typ_id[]"  style="min-height:195px;">
                    	 <option value="">---- Phd Course Type ---</option>
						  <?php
						  $ctype = $this->common_model->getAllCourseType();
						  foreach($ctype as $ctyp)
						  {
						  	echo '<option value="'.$ctyp['id'].'">'.$ctyp['course_type'].'</option>';
						  }
						  ?>
                    </select>
                  </div>
                </div>
                    <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">University Type</label>
                  <div class="col-sm-10">
                    <select name="university_type" id="university_type" class="form-control" required="true">
						<option value="">---- Type ---</option>
						<option value="1">Central University</option>  
						<option value="2">State University</option>  
						<option value="3">National Institute of Technology (NIT)</option>  
						<option value="4">Guru's</option>  
					</select>
                  </div>
                </div> 
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Universtiy Name</label>
                  <div class="col-sm-10">
                    <select name="universtiy" id="universtiy" onchange="updateStateid(this.id)" class="form-control">
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
                </div>
             	<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">University Name</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="universy" name="universy" placeholder="University Name" type="text">
                  </div>
                </div>
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">State Id</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="state_id" name="state_id" placeholder="State Id" required="true" type="text">
                  </div>
                </div> 
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="link" name="link" placeholder="Link" required="true" type="text">
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
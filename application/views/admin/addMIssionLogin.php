   <!-- Content Wrapper. Contains page content -->
   <script type="text/javascript">
   	var missionsList = [];
   	function getMissionName(missionId)
   	{
		var id = $('#' + missionId).val();
		var misisonName = missionsList[id];
		$('#mission_username').val(misisonName.mission_name);
		$('#email_id').val(misisonName.mission_email);
	}
   	</script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mission
        <small>Create Mission Login</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Mission Login</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Create Mission Login</div>
			<?php echo form_open('admin/createMissionLogin',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Missions</label>
                  <div class="col-sm-10">
                    <select name="mission_id" id="mission_id" title="Please select Region" onchange="getMissionName(this.id);" class="form-control" required="true" onchange="">
						<option value="">---- Missions ---</option>
						  <?php
						  $missions = $this->common_model->getAllMissions();						 
						  $this->common_model->array_sort_by_column($missions,'country_name');
						  foreach($missions as $mission)
						  {
						  	echo '<script type="text/javascript">';
			       			echo 'var missions = [];';
			       			echo 'missions["id"]='.$mission["id"].';';
			       			echo 'missions["mission_name"]="'.$mission["mission_name"].'";';
			       			echo 'missions["mission_email"]="'.$mission["mission_email"].'";';	
			       			echo 'missionsList['.$mission["id"].'] =missions;';
			       			echo '</script>';	
						  	echo '<option value="'.$mission['id'].'">'.$mission['country_name'].'  '.$mission['mission_name'].'</option>';
						  }
						  ?>
					</select>
                  </div>
                </div>
                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Mission Name</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="mission_username" name="mission_username" placeholder="Mission Name" type="text" required="true">
                  </div>
                </div>
                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Mission Email</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="email_id" name="email_id" placeholder="Email Id" type="text" required="true">
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
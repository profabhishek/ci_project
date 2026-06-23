   <!-- Content Wrapper. Contains page content -->
    <script type="text/javascript">
   	var mission = [];
   	
   	function updateMission(id)
   	{
		var obj = mission[id];
		$('#region_one').val(obj.state);
		$('#mission_one').val(id);
		$('#missionid').val(id);
	}
	$(document).ready(function(){
		$("#frm_mission").submit(function() {   
		var  formID = $(this).attr('id');
		var formDetails = $('#'+formID);	
			
		$.ajax({
		    type: "POST",
		    url: baseURL +'admin/updateMission',
		    data: formDetails.serialize(),
		    dataType:'json',
		    success: function (data) {	
		    	if(data.status == true)
		    	{
		    		BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Update Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "admin/allMission";}}]});
				}
		      },
		        error: function(jqXHR, text, error){
		                
		      }
		   });
		        return false;
		  });
	});
	function deleteMission(id)
	{
		$.ajax({
		    type: "POST",
		    url: baseURL +'admin/deleteMission',
		    data:{'missionId':id},
		    dataType:'json',
		    success: function (data) {	
		    	if(data.status == true)
		    	{
		    		BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Delete Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "admin/allmissions";}}]});
				}
		      },
		        error: function(jqXHR, text, error){
		                
		      }
	   });
	}
   </script>
   
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mission 
        <small>All Missions</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Mission List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Mission List
			<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadMisionList">
			<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/></a></div>
			<div class="pull-right"><a href="<?php echo site_url();?>admin/addMission">Add Mission</a></div></div>
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>
	       		<th>Country</th>	       		
	       		<th>Mission Type</th>
	       		<th>Mission</th>
	       		<th>Email Address</th>	       		
	       		
	       		<th>Action</th>       		
	       	</thead>
	       	<tbody>
	       		<?php	       		
	       		$counter = 1;
	       		foreach($missions as $mission)
	       		{
				?>
				<tr>
				<?php
				
					echo '<script type="text/javascript">';
	       			echo 'var mission = [];';
	       			echo 'mission["id"]='.$mission["id"].';';
					echo 'mission["mission_type"]="'.$mission["mission_type"].'";';
	       			echo 'mission["mission_name"]="'.$mission["mission_name"].'";';
					echo 'mission["mission_email"]="'.$mission["mission_email"].'";';
					echo 'mission['.$mission["id"].'] =mission;';
	       			echo '</script>';
	       			
					?>
					
					<td><?php echo $counter;?></td>
					<td><?php echo $mission['country_name'];?></td>
					<td><?php echo $mission['mission_type'];?></td>
					<td><?php echo $mission['mission_name'];?></td>
					<td><?php echo $mission['mission_email'];?></td>
					 <td>
                   <a href="javascript:void(0);" data-toggle="modal" data-target="#updateMission" onclick="updateMission('<?php echo $mission["id"];?>');"  class="icon_link edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<span class="space">&nbsp;&nbsp;&nbsp;</span>
				<a href="javascript:void(0);" class="icon_link delete" onclick="deleteMission('<?php echo $mission["id"];?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
								</td>
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
 
 <div id="updateMission" class="modal fade" role="dialog">
  	<div class="modal-dialog popup">
  		    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Create Mission</div>
			<?php echo form_open('admin/createMission',array('class'=>'form-horizontal')); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                    <select name="missioncountry" id="missioncountry" title="Please select Country" class="form-control">
						<option value="">---- Country ---</option>
						  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
						  }
						  ?>
					</select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Type</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="mission_type" name="mission_type">
                    		<option value="0">--Select Mission Type --</option>
							<option value="Assistant High Commission of India">Assistant High Commission of India</option>
							<option value="Consulate General of India">Consulate General of India</option>
							<option value="Embassy of India">Embassy of India</option>
							<option value="High Commission of India">High Commission of India</option>
							<option value="Honorary Consul General">Honorary Consul General</option>
							<option value="Honorary Consul of India">Honorary Consul of India</option>
							<option value="Other">Other</option>
							<option value="Permanent Mission of india">Permanent Mission of india</option>
                    </select>
                  </div>
                </div>
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Mission Name</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="mission_name" name="mission_name" placeholder="Mission Name" type="text">
                  </div>
                </div>               
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                   <input class="form-control" id="mission_email" name="mission_email" placeholder="Email Id" type="email">
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
  	</div>
  </div>

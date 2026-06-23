   <!-- Content Wrapper. Contains page content -->
   <script type="text/javascript">
   	var state = [];
   	
   	function update(id)
   	{
		var obj = state[id];
		$('#region_one').val(obj.state);
		$('#state_one').val(id);
		$('#universityid').val(id);
	}
	$(document).ready(function(){
		$("#frm_state").submit(function() {   
		var  formID = $(this).attr('id');
		var formDetails = $('#'+formID);	
			
		$.ajax({
		    type: "POST",
		    url: baseURL +'admin/update',
		    data: formDetails.serialize(),
		    dataType:'json',
		    success: function (data) {	
		    	if(data.status == true)
		    	{
		    		BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Update Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "admin/allState";}}]});
				}
		      },
		        error: function(jqXHR, text, error){
		                
		      }
		   });
		        return false;
		  });
	});
   </script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        State 
        <small>All State</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> State List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">State List<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadList">
			<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/></a></div><div class="pull-right"><a href="<?php echo site_url();?>admin/add">Add </a></div></div>
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>	       			       		
	       		<th>Universitiey Name</th>
	       		<th>State</th>	
	       		<th>Region</th>	       		
	       		<th>Action</th>       		
	       	</thead>
	       	<tbody>
	       		<?php	       		
	       		$counter = 1;
	       		foreach($state as $state)
	       		{
	       			//print_r($university);
				?>
							
				<tr>
					<?php
					echo '<script type="text/javascript">';
	       			echo 'var state = [];';
	       			echo 'state["id"]='.state["id"].';';
	       			echo 'state["state"]='.state["state"].';';
	       			echo 'state["state_type"]='.state["state_type"].';';	       			
	       			echo 'state['.state["id"].'] =state;';
	       			echo '</script>';
	       			
					?>
					
					<td><?php echo $counter;?></td>
					<td><?php echo $state['name'];?></td>
					<td><?php echo $state['stname'];?></td>													
					<td><?php echo $state['statename'];?></td>													
					 <td>
                  <a href="javascript:void(0);" data-toggle="modal" data-target="#update" onclick="update('<?php echo $university["id"];?>');"  class="icon_link edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<span class="space">&nbsp;&nbsp;&nbsp;</span>
				<a href="javascript:void(0);" class="icon_link delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
 <div id="update" class="modal fade" role="dialog">
  	<div class="modal-dialog popup">
  		    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Update </div>
			
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
                  <label for="inputPassword3" class="col-sm-2 control-label"> Name</label>
                  <div class="col-sm-10">
                     <select name="university_one" id="university_one" title="Please select " class="form-control" required="true">
						<option value="">----  ---</option>
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
                  <label for="inputPassword3" class="col-sm-2 control-label"> Name</label>
                  <div class="col-sm-10">
                     <select name="stat_one" id="stat_one" title="Please select " class="form-control" required="true">
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
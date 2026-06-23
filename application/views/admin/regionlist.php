 <script type="text/javascript">
 	function deleteRegion(id)
 	{
		$.ajax({
			url:baseURL + "admin/deleteRegion",
			data:{'regionId':id},
			dataType:"json",
			type:"post",
			success:function(jsonData){
				if(jsonData.status == true)
				{
					BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Delete Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "admin/allregions";}}]});
				}
			},
			error:function()
			{

			}
		});
	}

	function editRegion(id, name)
	{
		$('#editRegionId').val(id);
		$('#editRegionName').val(name);
		$('#editRegionModal').modal('show');
	}

	function saveRegion()
	{
		var id   = $('#editRegionId').val();
		var name = $('#editRegionName').val().trim();
		if(name === '') { alert('Region name cannot be empty.'); return; }
		$.ajax({
			url: baseURL + "admin/updateRegion",
			data: {regionId: id, regionname: name},
			dataType: "json",
			type: "post",
			success: function(jsonData){
				if(jsonData.status == true){
					BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS, title: "Success", message: "Region updated successfully!", buttons: [{label:'OK', action: function(d){ d.close(); location.href = baseURL + "admin/allregions"; }}]});
				} else {
					BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER, title: "Error", message: "Failed to update region.", buttons: [{label:'OK', action: function(d){ d.close(); }}]});
				}
			},
			error: function(){ alert('Server error. Please try again.'); }
		});
	}
 </script>

<!-- Edit Region Modal -->
<div class="modal fade" id="editRegionModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Region</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editRegionId">
        <div class="form-group">
          <label>Region Name</label>
          <input type="text" id="editRegionName" class="form-control" placeholder="Region Name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="saveRegion()">Save</button>
      </div>
    </div>
  </div>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Regions
        <small>All Regions</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allregions"><i class="fa fa-dashboard"></i> Region List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Region List<div class="pull-right"><a href="<?php echo site_url();?>admin/addRegion">Add Region</a></div></div>
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>
	       		<th>Region</th>
	       		<th>Password</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<?php
	       		$counter = 1;
	       		foreach($regions as $region)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $region['name'];?></td>
					<td><?php echo $region['password'];?></td>
					 <td>
                  <a href="javascript:void(0);" onclick="editRegion('<?php echo $region['id'];?>','<?php echo addslashes($region['name']);?>')" class="icon_link edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<span class="space">&nbsp;&nbsp;&nbsp;</span>
				<a href="javascript:void(0);" onclick="deleteRegion('<?php echo $region["id"];?>');" class="icon_link delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

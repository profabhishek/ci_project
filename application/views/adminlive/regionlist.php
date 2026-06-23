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
 </script>
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
                  <a href="javascript:void(0);"  class="icon_link edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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

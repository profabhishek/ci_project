  <script type="text/javascript">
 	function deleteScheme(id)
 	{
		$.ajax({
			url:baseURL + "admin/deleteScheme",
			data:{'schemeId':id},
			dataType:"json",
			type:"post",
			success:function(jsonData){
				if(jsonData.status == true)	
				{
					BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Delete Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "admin/allschemes";}}]});
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
        Schemes 
        <small>All Schemes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Schemes List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Schemes List</div>
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>
	       		<th>Scheme Name</th>
	       		<th>Status</th>
	       		<th>Action</th>       		
	       	</thead>
	       	<tbody>
	       		<?php	       		 
	       		$counter = 1;
	       		foreach($schemes as $scheme)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $scheme['scheme_name'];?></td>
					<td><?php if($scheme['status'] == 1){echo "<span style='color:green'>ACTIVE</span>";}else{echo "<span style='color:red'>ARCHIVED</span>";}?></td>				
					 <td>
					  <a href="<?php echo site_url('admin/editScheme/'.$scheme['id']);?>"  class="icon_link edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                
				<!--<span class="space">&nbsp;&nbsp;&nbsp;</span>
				

				<a href="javascript:void(0);"onclick="deleteScheme('<?php echo $scheme["id"];?>');" class="icon_link delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
								</td>-->
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

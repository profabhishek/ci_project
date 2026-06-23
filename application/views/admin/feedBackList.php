  <script type="text/javascript">
 	function deleteFeedback(id)
 	{
		if (confirm('Are you sure you want to delete this?')) {
		$.ajax({
			url:baseURL + "admin/deleteFeedback",
			data:{'feedBackId':id},
			
			type:"GET",
			success:function(jsonData){
				if(jsonData == true)	
				{
					location.reload();
				}
			},
			error:function()
			{
				
			}
		});
		}
	}
 </script>
 
 
 
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Feedback List
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Feedback List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Feedback List</div>
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>
	       		<th>Name</th>
	       		<th>Email Id</th>
	       		<th>Phone No</th>
	       		<th>Comment</th>
	       		<th>Action</th>       		
	       	</thead>
	       	<tbody>
	       		<?php	       		 
	       		$counter = 1;
	       		foreach($feedback as $feedbacks)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $feedbacks['name'];?></td>
					<td><?php echo $feedbacks['emailid'];?></td>
					<td><?php echo $feedbacks['mobile_no'];?></td>
					<td><?php echo $feedbacks['comment'];?></td>
									
					 <td>
                  
				<a href="javascript:void(0);"onclick="deleteFeedback('<?php echo $feedbacks["id"];?>');" class="icon_link delete" style="padding-left:15px"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
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

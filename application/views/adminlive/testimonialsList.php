  <script type="text/javascript">
 	function deleteNotification(id)
 	{
		if (confirm('Are you sure you want to delete this?')) {
		$.ajax({
			url:baseURL + "admin/deleteNotification",
			data:{'notificationid':id},			
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
        Testimonials
        <small>All Testimonials</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Testimonials List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Testimonials List</div>
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>
	       		<th>Title</th>	
	       		<th>View Document</th>	
									
	       		<th>Valid Upto</th>	       		       		       		
	       		<th>Status</th>	       		
	       		<th>Action</th>       		
	       	</thead>
	       	<tbody>
	       		<?php	       		 
	       		$counter = 1;
	       		foreach($notifications as $notification)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $notification['title'];?></td>	
					<td>
					<?php $file = isset($notifications[0]['notification_doc'])?$notifications[0]['notification_doc']:"" ?>
					<?php if(!empty($file)){?>
					<a target="_blank" href="<?php echo site_url().'assets/site/main/notification/'.$notification['notification_doc']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
				   <?php }else{ ?>
				   N/A
				   <?php } ?>
					</td>					
											
					<td><?php echo date('d/m/Y',strtotime($notification['validated_upto']));?></td>						
					<td><?php
					
					$status = strtotime(date('Y-m-d'))  > strtotime($notification['validated_upto']) ? "<span style='color:red'>ARCHIEVED</span>":"<span style='color:green'>ACTIVE</span>";
					echo $status;
					?></td>						
					 <td>
                  <a href="<?php echo site_url('admin/editNotification/'.$notification['id']);?>"  class="icon_link edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<span class="space">&nbsp;&nbsp;&nbsp;</span>
				

				<a href="javascript:void(0);"onclick="deleteNotification('<?php echo $notification["id"];?>');" class="icon_link delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
 
  <script type="text/javascript">
 	function deletePage(id)
 	{
		if (confirm('Are you sure you want to delete this?')) {
		$.ajax({
			url:baseURL + "page/destroy",
			data:{'pageid':id},
			
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
  <?php if($this->session->flashdata('message')) {

		$flash_data = $this->session->flashdata('message');
		
		if($flash_data == 'success') {?>
		
		<div class="alert alert-success alert-dismissible">
						<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success ! </strong> Status Change Sucessfully!
					</div>
		<?php } 
		if($flash_data == 'error') { ?>
		<div class="alert alert-danger alert-dismissible">
						<a class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Error ! </strong> Something wrong. Please try again later!
					</div>
		<?php
		} 
	} ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Page List
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>page/viewPage"><i class="fa fa-dashboard"></i> Page List</a></li> 
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Page List</div>
			<div class="box-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td>#</td>
								<td>Title</td>
								<td>Description</td>
								
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
	       		<?php	       		 
	       		$counter = 1;
	       		foreach($pages as $page)
	       		{
				$id = $page["id"];
				$page_slug = $page["page_slug"];
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $page['page_title'];?></td>
					<td><?php echo $page['page_description'];?></td>
					<td>
					<?php if($page['status'] == 1){ ?>
					<a href="<?php echo site_url('page/changeStatus/'.$id.'/0');?>" onclick="return confirm('Are you sure?')"><i class="fa fa-toggle-on" style="font-size:20px;color:green"></i></a>
					<?php }else{ ?>
					<a href="<?php echo site_url('page/changeStatus/'.$id.'/1');?>" onclick="return confirm('Are you sure?')"><i class="fa fa-toggle-on" style="font-size:20px;color:red"></i></a>
					<?php } ?>
					</td>
					
					<td><a href="<?php echo site_url('admin/page/edit/'.$page_slug);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="javascript:void(0);"onclick="deletePage('<?php echo $page["id"];?>');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
				</tr>
				<?php	
				$counter++;
				}
	       		?>
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
  
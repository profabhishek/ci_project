   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Registered Students 
        <small>All Registered Students</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Registered Students List</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Registered Students List
			<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadTotalStudentRegister">
			<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/></a></div>
			<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadPdfTotalStudentRegister">
			<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/></a></div>
			</div>
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>
	       		<th>Country</th>
				<th>Total</th>
	       		<!--<th>Email Id</th>	       		
	       		<th>Mobile Number</th>--->	       		
	       		<th>Action</th>       		
	       	</thead>
	       	<tbody>
	       		<?php	       		
	       		$counter = 1;
	       		foreach($students as $student)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $student['country_name'];?></td>
					<td><?php echo $student['Total'];?></td>
					<!----<td><?php echo $student['email_id'];?></td>
					<td><?php echo $student['mobile_number'];?></td>--->					
					 <td>
                  <a href="javascript:void(0);"  class="icon_link edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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

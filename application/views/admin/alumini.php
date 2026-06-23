   <link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/datatables.min.css" />
   <script src="<?php echo base_url();?>assets/site/main/js/datatables.min.js"></script>
     <script src="<?php echo base_url();?>assets/site/main/js/dataTables.buttons.min.js"></script>
   <script src="<?php echo base_url();?>assets/site/main/js/jszip.min.js"></script>
    <script src="<?php echo base_url();?>assets/site/main/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/jquery-ui.js"></script>
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Alumni 
        <small>Total Alumni</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i> Alumni </a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Alumni 
			<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadAlumniExcel">
			<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/ target ="__blank"></a></div>
			</div>
			
			<div class="box-body">
	      	<table id="myMissionsfilter" class="table table-bordered table-striped">
	       	<thead>
	       		<th>S.No.</th>		
				<th>Applicant Name</th>
				<th>Email Id</th>
				<th>Country</th>
				<th>University</th>		
				<th>Course</th>		
				<th>View</th>	
				<th>Year</th>
	       	</thead>
	       <tbody>
				<?php 
				$counter=1;
				if(count($alunamiapplication)>0)
				{
					foreach($alunamiapplication as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>						
						<td><?php echo $app['fullname'];?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php $country = $this->common_model->getCountryById($app['nationality']); 
						echo $country[0]['country_name']
						?></td>
						
						<td><?php
							if($app['unverisity'] == -1)
							{
								echo $app['other_unverisity'];
							}
							elseif($app['unverisity'] > 0)
							{
								$uni = $this->common_model->getAlumniUniversityById($app['unverisity']);
								echo $uni[0]['name'];
							}
							?>
						</td>
						<td><?php
							if($app['course'] == -1)
							{
								echo $app['other_course'];
							}
							elseif($app['course'] > 0)
							{
								$coursee = $this->common_model->getCoursesById($app['course']);
								echo $coursee[0]['title'];
							}
							?>
						</td>
						<td>
							<a class="form-control sbmt" style="width:100px;" href="<?php echo site_url();?>admin/viewAlumaniDetails/<?php echo $app['application_id'];?>" target = "_blank">View</a>
						</td>
						<td><?php echo $app['duration_of_course_from'];?></td>	
						</tr>
						<?php	
						$counter++;	
					}
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
  
<script>


$(document).ready( function() {
    $('#myMissionsfilter').DataTable( {
        dom: 'Bfrtip',
        buttons: [ {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data'
        } ]
    } );
} );
</script>
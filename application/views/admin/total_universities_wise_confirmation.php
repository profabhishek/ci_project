   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Application 
        <small>Total Confirmations</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>admin/allmissions"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-xs-12">
    	<div class="box">
			<div class="box-header">Total Confirmation 
			<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadUniversitywiseTotalApplication">
			<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/></a></div>
				<!----<div class="pull-right"><a href="<?php echo site_url();?>admin/downloadCountryWiseTotalMisionApplicationPdf" target = "__blank">-->
			<!----<img style="width: 32px; height: 30px; margin-left: 16px;" src="<?php echo site_url();?>assets/site/main/images/xls_icon.png"/></a></div>---->
			</div>
			
			<div class="box-body">
	      	<table class="table table-bordered table-striped myMissions">
	       	<thead>
	       		<th>S.No.</th>
				<th>University</th>
	       		<th>Total</th>       		
	       	</thead>
	       	<tbody>
	       		<?php	       		 
	       		$counter = 1;
	       		foreach($totalApplication as $totalApp)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $totalApp['University'];?></td>
					<td><?php echo $totalApp['Total'];?></td>
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
  
<script>

$(document).ready(function() {
    $('.myMissions').DataTable( {
		alert('ok');
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],
        columnDefs: [ {
            targets: -1,
            visible: false
        } ]
    } );
} );
</script>
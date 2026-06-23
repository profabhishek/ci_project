<script src="<?php echo base_url();?>assets/site/main/js/bootbox/bootbox.min.js" ></script>

   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php

	    	if($this->session->flashdata('message_type') == "success")
	    	{
			?>
			<div class="alert alert-success" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
			</div>
			<?php	
			}
			if($this->session->flashdata('message_type') == "error")
	    	{
			?>
			<div class="alert alert-error" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>
			</div>
			<?php	
			}
	    	
	    	?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Indian Council For Cultural Relations</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $missions;?></h3>

              <p>Missions</p>
            </div>
            <div class="icon">
              <i class="fa fa-globe"></i>
            </div>
            <a href="<?php echo site_url();?>admin/allmissions" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $regions;?></h3>

              <p>Regions</p>
            </div>
            <div class="icon">
              <i class="fa fa-map-marker"></i>
            </div>
            <a href="<?php echo site_url();?>admin/allregions" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $universities;?></h3>

              <p>Universities</p>
            </div>
            <div class="icon">
              <i class="fa fa-institution"></i>
            </div>
            <a href="<?php echo site_url();?>admin/allUniversities" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
			<?php 
				if(!empty($students)){
				$sum = 0;
				foreach($students as $value)
				{
				   $sum+= $value['Total'];
				}
			}
			?>
              <h3><?php echo $sum; ?></h3>
              <p>Students</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo site_url();?>admin/allStudents" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!----<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <!----<div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $students; ?></h3>
              <p>Regional Logins</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo site_url();?>admin/allRegionalList" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>-->
		
		
		<div class="col-lg-12 col-xs-12">
          <!-- small box -->
         
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
         
        </div>
		
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->
  	
	<!-- Modal -->
            <div class="modal fade" id="empModal" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">HQRS Report</h4>
                        </div>
                        <div class="modal-body">
     
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                  
                </div>
            </div>
			
			
			
			
			
            </div>
	
	
</section>

<?php

 $totalRegisteredStudent = $this->hqrs_model->getAllStudentsChart();
$nowtime = time();
 $applicationReceivedMission = $this->hqrs_model->getMissionApplicationChart($nowtime);
 //echo $totalMissionApplication;die;


$applicationForwardedByMission = $this->hqrs_model->getMissionForwordApplicationChart($nowtime);
//echo "<pre>";
//print_r($applicationForwardedByMission);die;

$universityResponsesentbyHqrstoMission = $this->hqrs_model->getTotalApplicationForwordMissionChart($nowtime);

$totalApplicationPendingatRo = $applicationForwardedByMission - $universityResponsesentbyHqrstoMission;



?>
<script type="text/javascript">
//alert('ok');
   var total_registeredStudent = <?php echo $totalRegisteredStudent; ?>;
   var application_receivedMission = <?php echo $applicationReceivedMission; ?>;
   var application_forwardedByMission = <?php echo $applicationForwardedByMission; ?>;
   var total_applicationPendingatRo = <?php echo $totalApplicationPendingatRo;?>;
   var university_responsesentbyHqrstoMission = <?php echo $universityResponsesentbyHqrstoMission; ?>;
   
  $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Yearly Wise Ratio'
        },
		
        xAxis: {
            categories: ['Application Forwarded By Mission','Application Received at Mission','Application Forwarded By Mission','Total Application Pending at Ro','University Response sent by Hqrs to Mission'],					        
			
        },
        yAxis: {
            title: {
				min: 0,
			    allowDecimals: false,
                text: 'Total'
            }
        },
		
       /*  series: [
		{
			type: 'column',
            name: 'Total Registered Student',
            data: total_registeredStudent
        }, 
		{
			type: 'column',
            name: 'Application Received at Mission',
            data: application_receivedMission
			
			
        },
		{
		 type: 'column',
		 name: 'Application Forwarded By Mission',
         data: application_forwardedByMission
		},
		{
			
		type: 'column',
		name: 'Total Application Pending at Ro',
        data: total_applicationPendingatRo
		},
		{
		name: 'University Response sent by Hqrs to Mission',
        data: university_responsesentbyHqrstoMission
			
		}
		] */
		  series: [{
        type: 'column',
		name: 'Application',
        colorByPoint: true,
        data: [total_registeredStudent,application_receivedMission,application_forwardedByMission,total_applicationPendingatRo,university_responsesentbyHqrstoMission],
        //showInLegend: false
    }]
    });



</script>
<script type='text/javascript'>
       $(window).on('load',function(){
         	  // AJAX request
                    $.ajax({
                        url: '<?php echo site_url('admin/ajaxfile')?>',
                        type: 'post',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modal
                            $('#empMssssodal').modal('show'); 
                        }
                    });
    } ); 
	
	
	/* function open_notification(){
		
		$('.modal-body-notification').html(response); 

                            // Display Modal
        $('#notificationModal').modal('show'); 
		
		
	} */


</script>

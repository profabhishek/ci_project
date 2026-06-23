  <div class="content-wrapper">
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

    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
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
        <div class="col-lg-3 col-xs-6">
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
        <div class="col-lg-3 col-xs-6">
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
        <div class="col-lg-3 col-xs-6">
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
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
			
		
              <h3><?php echo $regions; ?></h3>
              <p>Regional Logins</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo site_url();?>admin/allregions" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
		
		<div class="col-lg-12 col-xs-12">
         
            <div id="container" style="min-width: 310px; height: 500px; margin: 0 auto"></div>
         
        </div>
      </div>
    </section>
  </div>
  
  
            <div class="modal fade" id="empModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Status</h4>
                        </div>
                        <div class="modal-body">
     
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                  
                </div>
            </div>
	

<script type="text/javascript">

   var total_registeredStudent = <?php echo $totalRegisteredStudent; ?>;
   var application_receivedMission = <?php echo $applicationReceivedMission; ?>;
   var application_forwardedByMission = <?php echo $applicationForwardedByMission; ?>;
   var total_applicationPendingatRo = <?php echo $totalApplicationPendingatRo;?>;
   var university_responsesentbyHqrstoMission = <?php echo $universityResponsesentbyHqrstoMission; ?>;
   
   
   var total_registeredStudent_eighteen = <?php echo $totalRegisteredStudent_eighteen; ?>;
   var application_receivedMission_eighteen = <?php echo $applicationReceivedMission_eighteen; ?>;
   var application_forwardedByMission_eighteen = <?php echo $applicationForwardedByMission_eighteen; ?>;
   var total_applicationPendingatRo_eighteen = <?php echo $totalApplicationPendingatRo_eighteen;?>;
   var university_responsesentbyHqrstoMission_eighteen = <?php echo $universityResponsesentbyHqrstoMission_eighteen; ?>;
   
   //2020
   
    var total_registeredStudent_twenty = <?php echo $totalRegisteredStudent_twenty; ?>
    var application_receivedMission_twenty = <?php echo $applicationReceivedMission_twenty; ?>;  
    var application_forwardedByMission_twenty = <?php echo $applicationForwardedByMission_twenty; ?>;
	  var total_applicationPendingatRo_twenty = <?php echo $totalApplicationPendingatRo_twenty;?>;
	  var university_responsesentbyHqrstoMission_twenty = <?php echo $universityResponsesentbyHqrstoMission_twenty; ?>;
	  
	  //2021
	  
	  var total_registeredStudentOne = <?php echo $totalRegisteredStudent_twentyOne; ?>;
		var application_receivedMission_twentyOne = <?php echo $applicationReceivedMission_twentyOne; ?>;  
		var university_responsesentbyHqrstoMission_twentyOne = <?php echo $universityResponsesentbyHqrstoMission_twentyOne; ?>;
  
  $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
		
        xAxis: {
            categories: ['Total Registered Student','Application Received at Mission','Application Forwarded By Mission','Total Application Pending at Ro','University Response sent by Hqrs to Mission'],					        
			
        },
        yAxis: {
            title: {
				min: 0,
			    allowDecimals: false,
                text: 'Total'
            }
        },
		
         series: [
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
		] 
		 series: [
		 	 {
		 type: 'column',
		 name: '2018',
         colorByPoint: true,
          data: [total_registeredStudent_eighteen,application_receivedMission_eighteen,application_forwardedByMission_eighteen,total_applicationPendingatRo,university_responsesentbyHqrstoMission_eighteen],
		 },
		{
        type: 'column',
		name: '2019',
        colorByPoint: true,
        data: [total_registeredStudent,application_receivedMission,application_forwardedByMission,total_applicationPendingatRo,university_responsesentbyHqrstoMission],
         },
		 {
		 type: 'column',
		name: '2020',
        colorByPoint: true,
        data: [total_registeredStudent_twenty,application_receivedMission_twenty,application_forwardedByMission_twenty,total_applicationPendingatRo_twenty,university_responsesentbyHqrstoMission_twenty]
         },
		  {
		 type: 'column',
		name: '2021',
        colorByPoint: true,
        data: [total_registeredStudentOne,application_receivedMission_twentyOne,university_responsesentbyHqrstoMission_twentyOne]
         }
		 ]
    });

</script>
<script type='text/javascript'>
      $(window).on('load',function(){
        $.ajax({
            url: '<?php echo site_url('admin/ajaxfile')?>',
            type: 'post',
            success: function(response){ 
                $('.modal-body').html(response); 
                $('#empModal').modal('show'); 
            }
        });
    }); 
	
</script>
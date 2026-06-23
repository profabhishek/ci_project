<style type="text/css">
.bg-custom{background:#DBDBDD;border:1px solid #aaa;}
.bg-custom-link{background:#337ab7 !important;}
.small-box:hover{color:#337ab7;}
.small-box>.inner{min-height:130px;}
.bg-custom > .inner > p{bottom: 25px;position:absolute;font-size:14px;}
.spntext{ float: left;
    font-size: 20px;
    width:100%;}
.loginname{color: #337ab7;margin-left:20px;border-left:2px solid #cecece;padding-left:13px;}
.card img:first-child{
	/* height: 86px !important; */
    margin: 0 auto;
    /* width: 87% !important; */
    position: absolute !important;
}
.card img:last-child{
	/* height: 86px !important; */
    margin: 0 auto;
    /* width: 87% !important; */
    position: absolute !important;
}
marquee{
	
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto;
    padding: 10px 0 0;
    text-align: left;
}
.fltright{
	color: #02335c;
    font-weight: bold;
    padding-right: 10px;
}
.lft{ /*float: right;
    width: 62%;*/
     text-align: center;
	 margin-bottom:20px;
}
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
}
@media (min-width: 1400px) and (max-width: 2560px) {
.big-screen {
	display: flex;
	position: relative;
}
.first-bar {
	width: min-content;
}
}
</style>
<section class="meacontent" style="margin-top: 0;">	
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
<div class="container" style="float:none;height:38px;margin:0 auto;text-align: left;padding:0 16px;">

<marquee>Welcome <?php echo $universityData[0]['username']; ?> to ICCR Scholarship Portal</marquee>
	</div>	
	
	<div  class="container">
	
	<div class="row big-screen">
	<div class="col-12 col-sm-12 col-md-4 pd left-menu-sec pd-right pd-left first-bar">
	<div id="sidebar-wrapper">       
	      <ul class="sidebar-nav" id="sidebar">
		<li><a href="<?php echo site_url(); ?>university/new_applications/2026">Applications Received(2026-2027)<img src="<?php echo site_url(); ?>assets/site/main/images/newnotification.gif.png" alt="new gif Image"><span class="pull-right fltright"><?php echo $this->university_model->getCountUniversityApplications_26_27($university); ?></span></a></li>
		<li><a href="<?php echo site_url(); ?>university/new_applications/2025">Applications Received(2025-2026)<span class="pull-right fltright"><?php echo $this->university_model->getCountUniversityApplications_25_26($university); ?></span></a></li>
		 <li><a href="<?php echo site_url(); ?>university/new_applications/2024">Applications Received(2024-2025)<span class="pull-right fltright"><?php echo $this->university_model->getCountUniversityApplications_24_25($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/new_applications/2023">Applications Received(2023-2024)<span class="pull-right fltright"><?php echo $this->university_model->getCountUniversityApplications_23_24($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/new_applications/2022">Applications Received(2022-2023)<span class="pull-right fltright"><?php echo getCountUniversityApplications($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/new_applications/2021">Applications Received(2021-2022)<span class="pull-right fltright"><?php echo $newCountApplication;?></span></a></li>	 
				<!-----<li><a href="<?php echo site_url(); ?>university/missingDocs">Cases of Missing Documents<span class="pull-right fltright"><?php echo $newCountMissingDocuments; ?></span></a></li>---->
				
				<li><a href="<?php echo site_url(); ?>university/approved_applications/2026">Provisionally Confirmed by University(2026-2027)<img src="<?php echo site_url(); ?>assets/site/main/images/newnotification.gif.png" alt="new gif Image"><span class="pull-right fltright"><?php //echo countgetUniversityProcessedApplications_2026($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/approved_applications/2025">Provisionally Confirmed by University(2025-2026)<span class="pull-right fltright"><?php //echo countgetUniversityProcessedApplications_2025($university); ?></span></a></li>
        <li><a href="<?php echo site_url(); ?>university/approved_applications/2024">Provisionally Confirmed by University(2024-2025)<span class="pull-right fltright"><?php // echo countgetUniversityProcessedApplications_2024($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/approved_applications/2023">Provisionally Confirmed by University(2023-2024)<span class="pull-right fltright"><?php //echo countgetUniversityProcessedApplications($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/approved_applications/2022">Provisionally Confirmed by University(2022-2023)<span class="pull-right fltright"><?php echo countgetUniversityProcessedApplications($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/approved_applications/2021">Provisionally Confirmed by University(2021-2022)<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
				
				<li><a href="<?php echo site_url(); ?>university/rejected_applications/2025">Rejected by Univesrsity(2026-2027)<img src="<?php echo site_url(); ?>assets/site/main/images/newnotification.gif.png" alt="new gif Image"><span class="pull-right fltright"><?php //echo countgetUniversityRejectedApplications($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/rejected_applications/2025">Rejected by Univesrsity(2025-2026)<span class="pull-right fltright"><?php //echo countgetUniversityRejectedApplications($university); ?></span></a></li>
				
				<li><a href="<?php echo site_url(); ?>university/rejected_applications/2023">Rejected by Univesrsity(2023-2024)<span class="pull-right fltright"><?php //echo countgetUniversityRejectedApplications($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/rejected_applications/2022">Rejected by Univesrsity(2022-2023)<span class="pull-right fltright"><?php echo countgetUniversityRejectedApplications($university); ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/rejected_applications/2021">Rejected by Univesrsity(2021-2022)<span class="pull-right fltright"><?php echo $countrejectedApplication; ?></span></a></li>
				<!------<li><a href="<?php echo site_url(); ?>university/pending_application">Pending Application<span class="pull-right fltright"><?php echo $countpending_application; ?></span></a></li>--->
				  
				<!--<li><a href="<?php echo site_url(); ?>university/resubmitapplication">Cases of Re-Submit by Applicant<span class="pull-right fltright"><?php echo $countresubmitapplication; ?></span></a></li>-->
				  
				<!--<li><a href="<?php echo site_url(); ?>university/hold_applications">Applications on Hold<span class="pull-right fltright"><?php echo $countholdapplications; ?></span></a></li>-->
				  
				<!-----<li><a href="<?php echo site_url(); ?>university/confirmaitonreceivesformhqrs">Confirmation from University/Institute<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>---->
			<li><a href="<?php echo site_url(); ?>university/listofacceptances/2026">Acceptance/Decline by Applicant(2026-2027)<img src="<?php echo site_url(); ?>assets/site/main/images/newnotification.gif.png" alt="new gif Image"><span class="pull-right fltright"><?php //echo getCountUniversityAcceptance($university)?></span></a></li>
			<li><a href="<?php echo site_url(); ?>university/listofacceptances/2025">Acceptance/Decline by Applicant(2025-2026)<span class="pull-right fltright"><?php //echo getCountUniversityAcceptance($university)?></span></a></li>
					
        <li><a href="<?php echo site_url(); ?>university/listofacceptances/2024">Acceptance/Decline by Applicant(2024-2025)<span class="pull-right fltright"><?php //echo getCountUniversityAcceptance($university)?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/listofacceptances/2023">Acceptance/Decline by Applicant(2023-2024)<span class="pull-right fltright"><?php //echo getCountUniversityAcceptance($university)?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/listofacceptances/2022">Acceptance/Decline by Applicant(2022-2023)<span class="pull-right fltright"><?php echo getCountUniversityAcceptance($university)?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/listofacceptances/2021">Acceptance/Decline by Applicant(2021-2022)<span class="pull-right fltright"><?php echo $countlistofacceptance; ?></span></a></li>
				   
				<!-- <li><a href="<?php echo site_url(); ?>university/visaendrosment">Student/Research VISA Endorsement<span class="pull-right fltright"><?php echo $countvisaendrosment; ?></span></a></li>
				<li><a href="<?php echo site_url(); ?>university/travel_applications">Travel Plan of Applicant<span class="pull-right fltright"><?php echo $counttravel; ?></span></a></li> -->
					 
				<!-----<li><a href="<?php echo site_url();?>university/addStream"><i class="fa fa-book"></i>Create Stream</a></li>
				<li><a href="<?php echo site_url();?>university/addStreamMapping"><i class="fa fa-book"></i>Create Stream mapping</a></li>
				<li><a href="<?php echo site_url();?>university/addPages"><i class="fa fa-book"></i> Create Page</a></li>---->
	        </ul>
      </div>
      </div>
	  <div class="col-12 col-sm-12 col-md-8">
      <div class="lft">
      	<img style="margin-left: 14px;width:161px;" src="<?php echo site_url(); ?>assets/site/main/images/logos/India_240-animated-flag-gifs.gif"/>
      	
      	<span class="spntext">
		<img style="width:43px;margin-right:13px;" src="<?php echo site_url();?>assets/site/main/images/logos/national-emblem-india.png" alt="Indian Embelam"> 
		<b style="color: #337ab7;"><?php echo $universityData[0]['username']; ?></b>		
		<br/>
		
		</span>	
		
		
			<?php
			if(isset($misionData[0])&&$misionData[0]['university_type'] == "Consulate General of India")
			{
				$add = "INDIAN CONSULATE, ".', '.$misionData[0]['university_name'];	
			}
			else
			{
				$add = isset($misionData[0])&&$misionData[0]['university_type'].', '.$misionData[0]['university_name'];
			}
			
      	$address = strtoupper($add);
		//$latLong = getLatLong($address);
		//$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
		//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
      	?>
      		<span class="spntext">		
		<label class="loginname"><?php
		$user = $this->session->userdata('user_data');
		 ?> </label><br/>
		
		</span>	
	
<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><!--<div style='overflow:hidden;height:200px;width:100%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:200px;width:100%;'></div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div>-->

<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'<?php echo $misionData[0]['university_type'];?> : <?php echo $misionData[0]["university_name"];?><br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}//google.maps.event.addDomListener(window, 'load', init_map);
</script>
		
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d56035.78163841422!2d77.2310811!3d28.6226776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcf6a7c9b6a4be178!2sI.+C.+C.+R.+Azad+Bhavan!5e0!3m2!1sen!2sin!4v1494568307997" style="height:212px;width:100%;border:1px solid orange;padding:5px;" frameborder="0" allowfullscreen></iframe>
      </div>
	
	<div  >
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle front"/></a>
						<a target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle back"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle front"/></a>
						<a target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle back"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Incredible India" class="img-circle front" /></a>
						<a target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Incredible India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle front" /></a>
						<a target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" class="img-circle front" /></a>							
						<a target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png"  class="img-circle back" /></a>
					</div>
					
					
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle front" /></a>
						<a target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle back" /></a>
					</div>
					
									
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle front"/></a>
						<a target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle back"/></a>
					</div>
				</div>
				</div>
				</div>

	
	
	
	
	
	<!--
		<div class="row">
        <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">            
              <h3><?php echo $newApplication;?></h3>
              <p>Applications Received</p>              
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/new_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
            <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">            
              <h3><?php echo $pending_application;?></h3>
              <p>Pending Applications</p>              
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/pending_application" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
           <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">            
              <h3><?php echo $resubmitapplication;?></h3>
              <p>Cases of Re-Subuniversity</p>              
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/resubmitapplication" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">            
              <h3><?php echo $holdapplications;?></h3>
              <p>Applications on Hold</p>              
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/hold_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $approvedApplication;?></h3>
              <p>Recommended Candidates</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/approved_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> 
         <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $rejectedApplication;?></h3>
              <p>Rejected Candidates</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/rejected_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> 
             <!-- <div class="col-xs-3 col-xs-6">
         
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $results;?></h3>
              <p>Results of English Proficiency Test</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/results" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>--
        
         <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $confirmationForwardtouniversitybyHqrs;?></h3>
              <p>Receives Confirmation from Hqrs</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/confirmaitonreceivesformhqrs" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $listofacceptance;?></h3>
              <p>Acceptance/Decline</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/listofacceptance" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
           <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $visaendrosment;?></h3>
              <p>Student/Research VISA Endorsement</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/visaendrosment" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <div class="col-xs-3 col-xs-6">
          
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $travel;?></h3>
              <p>Travel Plan</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>university/travel_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>      
      </div>-->
	  	<!-- Modal -->
            <div class="modal fade" id="missionAlertModal" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">University Notification(last 7 Days)</h4>
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
function getLatLong($address){
    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        $data['latitude']  = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
            return $data;
        }else{
            return false;
        }
    }else{
        return false;   
    }
}
?>
<script type='text/javascript'>
       $(window).on('load',function(){
         	  // AJAX request
                    $.ajax({
                        url: '<?php echo site_url('university/ajaxfile')?>',
                        type: 'post',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modal
                            $('#missionAlertModal').modal('show'); 
                        }
                    });
    } ); 
</script>
<style type="text/css">
.bg-custom{background:#DBDBDD;border:1px solid #aaa;}
.bg-custom-link{background:#337ab7 !important;}
.small-box:hover{color:#337ab7;}
.small-box>.inner{min-height:130px;}
.bg-custom > .inner > p{bottom: 25px;position:absolute;font-size:14px;}
.loginname{color: #337ab7;margin-left:20px;border-left:2px solid #cecece;padding-left:13px;}
#sidebar_menu li a, .sidebar-nav li a
{
	width:440px;
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
.lft{
	float: right;
    width: 60%;
    text-align: center;
    
}
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
}
<?php
$user_data = $this->session->userdata('user_data');
//echo "<pre>";
//print_r($regionid);die;
?>
</style>
<section class="meacontent" style="margin-top: 0;">
<!--<div class="container" style="float:none;height:72px;margin:0 auto;text-align: left;padding: 5px;padding-left: 20px;">	
		<span class="spntext">
		<img style="width:37px;margin-right:13px;float: left;" src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam"> 
		<b style="color: #337ab7;">INDIAN COUNCIL FOR CULTURAL RELATIONS</b><label class="loginname"><?php
		$user = $this->session->userdata('user_data');
		
		 echo 'You are login as: '.$user['fname']; ?> </label><br/>
		<label style="font-size:25px;">REGIONAL OFFICE : <?php echo strtoupper($regionName[0]["name"]); ?></label>
		</span>	
	</div>	-->	
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




<?php if($regionName[0]["id"] == 6)
{
	?>
	
	<marquee>Welcome Regional Office <?php echo strtoupper($regionName[0]["name"]); ?> to ICCR Scholarship Portal.<a href ="<?php echo base_url();?>/assets/site/main/notification/1611898628_NOTIFICATION_Letter_reg_revised_norms_on_Medical_Insurance_for_foreign_students_studying_in_India_under_ICCR_Scholarship_Schemes (1).pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-Revised norms on Medical Insurance for foreign students  studying in India under ICCR Scholarship Schemes.<a href ="<?php echo base_url();?>/assets/site/main/notification/1611898703_NOTIFICATION_Coverage_and_Benefity_Type_of_Raheja_QBE_General_Insurance_Company_Limited_and_Royal_Sundaram_General_Insurance_Co_Limited.pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Coverage and Benefit of Medical Insurance policy.<a href ="<?php echo base_url();?>/assets/site/docs/Guidelines-for-Visa-Travel-restrictions-in-responce-to-COVID-19.pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-Visa & Travel restrictions in response to COVID-19 -  Permitting certain categories of foreign nationals including Overseas Citizen of India (OCI) & PIO Cardholders to enter India.<a href ="<?php echo base_url();?>/assets/site/docs/notification_date.jpg" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-The last date for submission of application for the session 2020-2021 has been extended up to 31th March 2020.
However for Ph.d last date is 30th September 2020.</a><a href ="<?php echo base_url();?>/assets/site/docs/Procedure_ admission_ International Students_MTech_NITR.pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-Admission of International Students at NIT Rourkela during the AY 2020-2021 for M. Tech Programme.
</a></marquee>
	<?php
}
else{
	?>
	<?php $todate = date('Y-m-d');
$notifications = $this->common_model->getActiveNotification($todate); ?>

<marquee>
<a href ="#"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note: - (1)Before rolling out any Scholarship offer letter, authentication of academic transcripts, mark list or any other local relevant documents, shall be done by the Mission. (2) Furthermore, the Missions have the prerogative to pick and choose students from among the total students recommended by colleges/universities, as per their strategic interests, if the number of students exceeds the scholarship quota.</a> &nbsp;&nbsp;
<?php
if(!empty($notifications))
{
	foreach($notifications as $notval)
	{
		?>
		<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" ><a href="<?php echo site_url('home/notificationList/'.$notval['id']);?>"><?php echo $notval['title']?></a>
		
		<?php
		
	}
}
?>
</marquee>
	<!----<marquee>Welcome Regional Office <?php echo strtoupper($regionName[0]["name"]); ?> to ICCR Scholarship Portal.Note: - ICCR wishes best of luck for future to applicants who could not receive admissions in AY 2020-2021. Admission process through A2A portal for AY 2020-2021 is closed except for applicants of Ph.D courses; Schemes under Ayush Scholarship and IARI.
	<a href ="<?php echo base_url();?>/assets/site/main/notification/1611898628_NOTIFICATION_Letter_reg_revised_norms_on_Medical_Insurance_for_foreign_students_studying_in_India_under_ICCR_Scholarship_Schemes (1).pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-Revised norms on Medical Insurance for foreign students  studying in India under ICCR Scholarship Schemes.<a href ="<?php echo base_url();?>/assets/site/main/notification/1611898703_NOTIFICATION_Coverage_and_Benefity_Type_of_Raheja_QBE_General_Insurance_Company_Limited_and_Royal_Sundaram_General_Insurance_Co_Limited.pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Coverage and Benefit of Medical Insurance policy.<a href ="<?php echo base_url();?>/assets/site/docs/Guidelines-for-Visa-Travel-restrictions-in-responce-to-COVID-19.pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-Visa & Travel restrictions in response to COVID-19 -  Permitting certain categories of foreign nationals including Overseas Citizen of India (OCI) & PIO Cardholders to enter India.<a href ="<?php echo base_url();?>/assets/site/docs/notification_date.jpg" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-The last date for submission of application for the session 2020-2021 has been extended up to 31th March 2020.
However for Ph.d last date is 30th September 2020.</a><a href ="<?php echo base_url();?>/assets/site/docs/notification_date.jpg" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">
</a></marquee>---->
<?php
}
?>


<!----<marquee><a href ="<?php echo base_url();?>/assets/site/docs/notification_date.jpg" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/Procedure_ admission_ International Students_MTech_NITR.pdf" alt="new gif Image">Note:-Admission of International Students at NIT Rourkela during the AY 2020-2021 for M. Tech. Programme.</a></marquee>----->


<!-----<marquee>Welcome Regional Office <?php echo strtoupper($regionName[0]["name"]); ?> to ICCR Scholarship Portal.<img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Offer of ICCR Scholorship for the Academic session 2020-2021 have been announced.Students registration opens on 1st December 2019.Please note last date for receving applications from studends is 29th feburary 2020 for all courses.
However for Ph.d last date is 31st August 2020.</marquee>--->
	</div>
	<div  class="container" style="min-height:249px;padding-top:24px;padding-bottom: 15px;">
	

	<div id="sidebar-wrapper"> 
	 
	        <ul class="sidebar-nav" id="sidebar">
			<?php $user_data = $this->session->userdata('user_data');	
				//echo print_r($user_data);
				?>
				<li><a href="<?php echo site_url(); ?>regional/new_applicationsDemo/2026">Application Received from Mission(2026-2027)</a></li>
					  <li><a href="<?php echo site_url(); ?>regional/new_applicationsDemo/2025">Application Received from Mission(2025-2026)</a></li>
            <li><a href="<?php echo site_url(); ?>regional/new_applicationsDemo/2024">Application Received from Mission(2024-2025)</a></li>
            <li><a href="<?php echo site_url(); ?>regional/new_applicationsDemo/2022">Application Received from Mission(2022-2023)<span class="pull-right fltright"><?php echo count($newTwentyTwoApplication); ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>regional/new_applicationsDemo/2021">Application Received from Mission(2021-2022)<span class="pull-right fltright"><?php echo count($newApplication); ?></span></a></li>	

	          <?php 
	          $admissioncount=1;
	          if(count($newApplication)>0)
				{
					
					?>
					 <li><a href="<?php echo site_url(); ?>regional/universityapplications1">University Response Sent to Hqrs<span class="pull-right fltright"><!---<?php echo count($newApplication); ?>----></span></a></li>
					<?php
				}
				else
				{
				?>
				 <li><a href="<?php echo site_url(); ?>regional/universityapplications1">University Response Sent to Hqrs<span class="pull-right fltright"><?php echo "0"; ?></span></a></li>
				<?php	
				}
				?>			        
	         
	          <li><a href="<?php echo site_url(); ?>regional/scholararrival">Arrival Schedule of Student<span class="pull-right fltright"><?php echo $travel; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>regional/issueDocuments">Documents/Certificates<span class="pull-right fltright"><?php echo $arrived; ?></span></a></li>
	          
	          <li><a href="<?php echo site_url(); ?>regional/academicDetails">Student Wise Academic Details<span class="pull-right fltright"><?php echo $arrived; ?></span></a></li>
	          
	          <li><a href="<?php echo site_url(); ?>regional/visaendorsment">Student VISA Endorsement</a></li>
	          <!--<li><a href="<?php echo site_url(); ?>regional/openingbalance">Opening Balance</a></li>-->
	          <li><a href="<?php echo site_url(); ?>regional/fundmonitoring">Fund Management</a></li>
	          <li><a href="<?php echo site_url(); ?>regional/expenditureStatement">Student Wise Expenditure<span class="pull-right fltright"><?php echo $arrived; ?></span></a></li>
			   <li><a href="<?php echo site_url(); ?>regional/applicantAcceptance">Acceptance/Decline by Applicant<span class="pull-right fltright"></span></a></li>
	          <li><a href="<?php echo site_url(); ?>regional/demands">Demand to Hqrs<span class="pull-right fltright"><?php echo $demands; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>regional/processeddemands">Processed Demands by Hqrs.<span class="pull-right fltright"><?php echo $processeddemands; ?></span></a></li>
	           <li><a href="<?php echo site_url(); ?>regional/alumani">Alumni Details<span class="pull-right fltright"><?php echo $alunamiapplication; ?></span></a></li>
	           <li><a href="<?php echo site_url(); ?>regional/expenditurereports">Expenditure Report</a></li> <li><a href="<?php echo site_url(); ?>regional/countsregional">Summary Report</a></li>
	           <li><a href="<?php echo site_url(); ?>regional/complaints">Complaints</a></li>	
			   <!---<div>
			   <?php
			    if($regionName[0]["id"] == 23){
				?>
			    <li><a href="<?php echo site_url(); ?>regional/new_applicationsDemo">Application Received from Mission<span class="pull-right fltright"><?php echo count($newApplication); ?></span></a></li>	
				
				<li><a href="<?php echo site_url(); ?>regional/universityapplications1">University Response Sent to Hqrs<span class="pull-right fltright"><!---<?php echo count($newApplication); ?></span></a></li>
				<?php
				}
			
				
				
			   ?>
			   </div>--->
			  <li><a href="<?php echo site_url(); ?>regional/getUniversityResponseSentByMissiontoRegion"><img src="<?php echo site_url();?>assets/site/main/images/newnotification.gif.png" alt="new gif Image">Confirmation sent by Mission & Student Acceptance<span class="pull-right fltright"><?php echo $countresponseSetByHqToMission; ?></span></a></li>
	         <!--<li><a href="<?php echo site_url(); ?>regional/expenditureStatement">Reports<span class="pull-right fltright"><?php echo $arrived; ?></span></a></li>-->
			  <!----<li><a href="<?php echo site_url(); ?>regional/new_applicationsDemoOne">Application Received<span class="pull-right fltright"><?php echo count($newApplicationDemo); ?></span></a></li>---->
	          
	        </ul>
      </div>
	
	     <div class="lft">
      	
      	<?php
      	$address = strtoupper($regionName[0]["name"]) .", India";
		//$latLong = getLatLong($address);
	//	$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
	//	$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
      	?>
      		<span class="spntext">
		
		<b style="color: #337ab7;">INDIAN COUNCIL FOR CULTURAL RELATIONS</b><label class="loginname"><?php
		$user = $this->session->userdata('user_data');
		// echo 'You are login as: '.$user['fname']; ?> </label><br/>
		<label style="font-size:25px;">REGIONAL OFFICE : <?php echo strtoupper($regionName[0]["name"]); ?></label>
		</span>	
	
<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script><div style='overflow:hidden;height:212px;width:100%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:200px;width:100%;'></div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div>--><script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'REGIONAL OFFICE: <?php echo $regionName[0]["name"];?><br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}//google.maps.event.addDomListener(window, 'load', init_map);
</script>
<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d56035.78163841422!2d77.2310811!3d28.6226776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcf6a7c9b6a4be178!2sI.+C.+C.+R.+Azad+Bhavan!5e0!3m2!1sen!2sin!4v1494568307997" style="height:212px;width:100%;border:1px solid orange;padding:5px;" frameborder="0" allowfullscreen></iframe>
      	<br/>	<br/>
      
      </div>
      <div  style="float:right;margin:3% auto 0;width:65%;">
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
		<!--<div class="row">
        <div class="col-xs-3 col-xs-6">
         
          <div class="small-box bg-custom">
            <div class="inner">            
              <h3 ><?php echo count($newApplication);?></h3>
              <p>Application Receives from Mission </p>              
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url(); ?>regional/new_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
         <div class="col-xs-3 col-xs-6">
         
          <div class="small-box bg-custom">
            <div class="inner">            
              <h3 ><?php echo count($newApplication);?></h3>
              <p>Admission Confirmed to Hqrs</p>              
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo site_url(); ?>regional/universityapplications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
    <!--    <div class="col-xs-3 col-xs-6">
        
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo count($forwardedtohqrs);?></h3>
              <p>Forwards confirmation to Hqrs.</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>regional/forwardtohqrslist" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> ;;
         <div class="col-xs-3 col-xs-6">
         
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $travel;?></h3>
              <p>Receives scholar on arrival</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>regional/scholararrival" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> 
          <div class="col-xs-3 col-xs-6">
         
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $travel_stipend;?></h3>
              <p>Documents/Certificates.</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>regional/issueDocuments" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
<!--<div class="col-xs-3 col-xs-6">
         
          <div class="small-box bg-custom">
            <div class="inner">
            <h3>0</h3>
              <p>Forwards Joining Report to Hqrs.</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>regional/forwardjoiningreport" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --
        <div class="col-xs-3 col-xs-6">
         
          <div class="small-box bg-custom">
            <div class="inner">
            <h3><?php echo $travel_stipend;?></h3>
              <p>Release TF/OCF and Dues<br/> (Individual expenditure statement gets generated).</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>regional/travel_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>   
        <!--<div class="col-xs-3 col-xs-6">
          <!-- small box 
          <div class="small-box bg-blue">
            <div class="inner">
            <h3>1</h3>
              <p>Attendance & Progress Report.</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>regional/travel_applications" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>--
      </div>-->
	     	<!-- Modal -->
            <div class="modal fade" id="missionAlertModal" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Region Notification(Last 7 Days)</h4>
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
        $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
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
                        url: '<?php echo site_url('regional/ajaxfile')?>',
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
	
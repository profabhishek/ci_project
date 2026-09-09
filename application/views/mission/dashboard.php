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
/* Previously a fixed 86px height + 87% width, floated at top-left of the
   circle with no object-fit - since the source logos aren't all square,
   this stretched/cropped them off-center and let them spill past the
   round frame, so the "circle" read as a squashed oval/moon shape.
   Filling the whole circle (100%/100%) with object-fit:cover keeps each
   logo's own aspect ratio intact while cropping it to a perfect circle,
   and .goals below now clips anything that overflows the round edge. */
.card img:first-child,
.card img:last-child{
	height: 100% !important;
    width: 100% !important;
    object-fit: cover;
    border-radius: 50%;
    position: absolute !important;
    top: 0;
    left: 0;
    margin: 0;
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
    width: 62%;
     text-align: center;
}
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
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

<!-----<marquee>Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal.  <img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Offer of ICCR Scholorship for the Academic session 2020-2021 have been announced.Students registration opens on 1st December 2019.Please note last date for receving applications from studends is 29th feburary 2020 for all courses.
However for Ph.d last date is 31st August 2020.</marquee>-->

<!-----<marquee>Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal.  <a href ="<?php echo base_url();?>/assets/site/main/notification/1611898628_NOTIFICATION_Letter_reg_revised_norms_on_Medical_Insurance_for_foreign_students_studying_in_India_under_ICCR_Scholarship_Schemes (1).pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-Revised norms on Medical Insurance for foreign students  studying in India under ICCR Scholarship Schemes.<a href ="<?php echo base_url();?>/assets/site/main/notification/1611898703_NOTIFICATION_Coverage_and_Benefity_Type_of_Raheja_QBE_General_Insurance_Company_Limited_and_Royal_Sundaram_General_Insurance_Co_Limited.pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Coverage and Benefit of Medical Insurance policy.<a href ="<?php echo base_url();?>/assets/site/docs/Guidelines-for-Visa-Travel-restrictions-in-responce-to-COVID-19.pdf" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-Visa & Travel restrictions in response to COVID-19 -  Permitting certain categories of foreign nationals including Overseas Citizen of India (OCI) & PIO Cardholders to enter India.Offer of scholarships under the Ayush Scholarship Scheme for the Academic Year 2020-2021.Please note that last date for submitting application from students has been extended till 30th September 2020.</a>&nbsp;&nbsp;<a href ="<?php echo base_url();?>/assets/site/docs/notification_date.jpg" target ="__blank"><img src="<?php echo base_url();?>/assets/site/main/images/newnotification.gif.png" alt="new gif Image">Note:-The last date for submission of application for the session 2020-2021 has been extended up  31th March 2020.
However for Ph.d last date is 30th September 2020.</a> &nbsp;&nbsp;</marquee>--->

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

	</div>	
	
	<div  class="container" style="min-height:410px;padding-top:20px;padding-bottom: 20px;">
	
	
	<div id="sidebar-wrapper">       
	        <ul class="sidebar-nav" id="sidebar">
	         
	          <!--Reports link removed: was dead HTML-comment code still executed by PHP, referencing an undefined $visaendrosment-->
	          <!---<li><a href="<?php echo site_url(); ?>mission/alumni">Alumni Application<span class="pull-right fltright"><?php echo $alumanidata; ?></span></a></li>----->
            <li><a href="<?php echo site_url(); ?>mission/new_applications/2026">Applications Received(2026-2027)<img src="<?php echo site_url(); ?>assets/site/main/images/newnotification.gif.png" alt="new gif Image"><span class="pull-right fltright"><?php echo $newTwentryTwoCountApplication2627?></span></a></li>
		   <li><a href="<?php echo site_url(); ?>mission/new_applications/2025">Applications Received(2025-2026)<span class="pull-right fltright"><?php echo $newTwentryTwoCountApplication2526?></span></a></li>
            <li><a href="<?php echo site_url(); ?>mission/new_applications/2024">Applications Received(2024-2025)<span class="pull-right fltright"><?php echo $newTwentryTwoCountApplication2425?></span></a></li>
            <li><a href="<?php echo site_url(); ?>mission/new_applications/2023">Applications Received(2023-2024)<span class="pull-right fltright"><?php echo $newTwentryTwoCountApplication2324?></span></a></li>
				    <li><a href="<?php echo site_url(); ?>mission/new_applications/2022">Applications Received(2022-2023)<span class="pull-right fltright"><?php echo $newTwentryTwoCountApplication?></span></a></li>
				    <li><a href="<?php echo site_url(); ?>mission/new_applications/2021">Applications Received<span class="pull-right fltright"><?php echo $newCountApplication?></span></a></li>	           
	          <!----<li><a href="<?php echo site_url(); ?>mission/pending_application">Pending Application With Mission/Post<span class="pull-right fltright"><?php echo $countpending_application; ?></span></a></li>--->
	          <!----<li><a href="<?php echo site_url(); ?>mission/resubmitapplication">Cases of Re-Submission by Applicant<span class="pull-right fltright"><?php echo $countresubmitapplication; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>mission/hold_applications">Applications on Hold<span class="pull-right fltright"><?php echo $countholdapplications; ?></span></a></li>--->
	          <li><a href="<?php echo site_url(); ?>mission/approved_applications_2026">Processed Applications (2026-2027)<img src="<?php echo site_url(); ?>assets/site/main/images/newnotification.gif.png" alt="new gif Image"><span class="pull-right fltright"><?php echo $countapprovedApplication25; ?></span></a></li>
	          
			  <li><a href="<?php echo site_url(); ?>mission/approved_applications_2025">Processed Applications (2025-2026)<span class="pull-right fltright"><?php echo $countapprovedApplication26; ?></span></a></li>
	          
			  <li><a href="<?php echo site_url(); ?>mission/approved_applications">Processed Applications<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
            <li><a href="<?php echo site_url(); ?>mission/approved_applications_2023">Processed Applications (2023-2024)<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
	          <!-----<li><a href="<?php echo site_url(); ?>mission/confirmaitonreceivesformhqrs">Confirmation from University/Institute by HQRS<span class="pull-right fltright"><?php echo $countconfirmationForwardtoMissionbyHqrs; ?></span></a></li>--->
			  
	          <li><a href="<?php echo site_url(); ?>mission/confirmaitonofuniversityformhqrs">Confirmation of University/Institute by HQRS(By Ayush/ICAR)<span class="pull-right fltright"><?php echo $countconfirmaitonofuniversityformhqrs; ?></span></a></li>
			      <!--<li><a href="<?php echo site_url(); ?>mission/listofacceptance/2022">Acceptance/Decline by Applicant(2022-2023)<span class="pull-right fltright"><?php echo $countlistofacceptance; ?></span></a></li>-->
	           <li><a href="<?php echo site_url(); ?>mission/listofacceptance/2026">Acceptance/Decline by Applicant(2026-2027)<span class="pull-right fltright"><?php echo $countlistofacceptance26; ?></span></a></li>
	          
			  <!--2025-2026 acceptance link removed: dead HTML-comment code still executed by PHP, referencing an undefined $countlistofacceptance25-->
	          <li><a href="<?php echo site_url(); ?>mission/listofacceptance">Acceptance/Decline by Applicant<span class="pull-right fltright"><?php echo $countlistofacceptance; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>mission/visaendrosment">Student/Research VISA Endorsement<span class="pull-right fltright"><?php echo $countvisaendrosment; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>mission/travel_applications">Travel Plan of Applicant<span class="pull-right fltright"><?php echo $counttravel; ?></span></a></li>
				    <li><a href="<?php echo site_url(); ?>mission/alumni">Alumini<span class="pull-right fltright"><?php echo $alumanidata; ?></span></a></li>

	        </ul>
      </div>
      <div class="lft">
      	<img style="margin-left: 14px;width:161px;" src="<?php echo site_url(); ?>assets/site/main/images/logos/India_240-animated-flag-gifs.gif"/>
      	
      	<span class="spntext">
		<img style="width:43px;margin-right:13px;" src="<?php echo site_url();?>assets/site/main/images/logos/national-emblem-india.png" alt="Indian Embelam"> 
		<b style="color: #337ab7;"><?php echo strtoupper($misionData[0]['country_name']); ?> | <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?></b>		
		<br/>
		
		</span>	
		
		
			<?php
			if($misionData[0]['mission_type'] == "Consulate General of India")
			{
				$add = "INDIAN CONSULATE, ".', '.$misionData[0]['mission_name'];	
			}
			else
			{
				$add = $misionData[0]['mission_type'].', '.$misionData[0]['mission_name'];
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
	
<!-- init_map script removed: the DOM listener that would ever call it was
already commented out, so it was 100% dead JS. It also referenced undefined
$latitude/$longitude PHP variables (never computed — the getLatLong() call
above is commented out too), throwing warnings on every load for nothing. -->

		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d56035.78163841422!2d77.2310811!3d28.6226776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcf6a7c9b6a4be178!2sI.+C.+C.+R.+Azad+Bhavan!5e0!3m2!1sen!2sin!4v1494568307997" style="height:212px;width:100%;padding:5px;" frameborder="0" allowfullscreen></iframe>
      </div>
	
	<div  style="float:right;margin:3% auto 0;width:65%;display:flex;flex-wrap:wrap;align-items:center;gap:16px;">
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

	
	
	
	
	
	   	<!-- Modal -->
            <div class="modal fade" id="missionAlertModal" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Mission Notification(Last 7 Days)</h4>
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





 <!----<script>
  
  $(document).ready(function(){
	  
	  notificationd();
  });
  
  
   function notificationda(){

	
	BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: "Warning" ,message: "<p></br></br>To Enable Edit option for student .</p>" ,buttons: [{label: 'Ok',action: function(dialogItself)
	{
		
		dialogItself.close();
		
		
	
	}},
	{label: 'Cancel',action: function(dialogItself) {dialogItself.close();}}]}); 

  
    }
	</script>----->
<script type='text/javascript'>
       $(window).on('load',function(){
         	  // AJAX request
                    $.ajax({
                        url: '<?php echo site_url('mission/ajaxfile')?>',
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

	
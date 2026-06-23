<style type="text/css">
    .bg-custom{background:#DBDBDD;border:1px solid #aaa;}
    .bg-custom-link{background:#337ab7 !important;}
    .small-box:hover{color:#337ab7;}
    .small-box>.inner{min-height:130px;}
    .bg-custom > .inner > p{bottom: 25px;position:absolute;font-size:14px;}
    .loginname{color: #337ab7;margin-left:20px;border-left:2px solid #cecece;padding-left:13px;}
    .strips{

    }
    #sidebar_menu li a, .sidebar-nav li a
    {
        width:440px;
    }
    .strips li{
        border: 1px solid #cecece;
        margin-bottom: 9px;
        padding: 5px 5px 5px 9px;
    }
    .strips li div:first-child{

    }
    .strips li div:last-child{
        background: #47a0c7 none repeat scroll 0 0;
        border: 1px solid #cecece;
        border-radius: 15px;
        color: #fff;
        float: right;
        font-weight: bold;
        max-width: 63px;
        text-align: center;
    }
    .strips li div a{
        color: #337ab7;
        margin-left: 7px;
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
        margin-right: 28px;
        width: 62%;
        text-align: center;
    }
    .alert
    {
        margin: 0 auto 1%;    
        width: 85.5%;
    }
</style>
<section class="meacontent" style="margin-top:0;">	
    <?php
    if ($this->session->flashdata('message_type') == "success") {
        ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php
    }
    if ($this->session->flashdata('message_type') == "error") {
        ?>
        <div class="alert alert-error" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php
}
?>
    <div class="container" style="float:none;height:38px;margin:0 auto;text-align: left;padding:0 16px;">


        <marquee style="margin-bottom:5px;">
            Welcome <?php
    $user_data = $this->session->userdata('user_data');
    echo $user_data['fname'];
?> to ICCR Scholarship Portal 
        </marquee>

    </div>		
    <div  class="container" style="min-height:620px;padding-top:10px;">
        <div class="row" style="background:#fff;">
            <div id="sidebar-wrapper">       
                <ul class="sidebar-nav" id="sidebar">
<?php
#print_r($user_data);exit;
$division = $user_data['state'];
switch ($division) {
    case "0":
        ?>
                            <li><a href="<?php echo site_url(); ?>headquarter/fundmonitoring">Fund Released/Expenditure Details of RO</a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/applicantExpenditure">Expenditure Details of Students</a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/demands">RO's Demand<span class="pull-right fltright"><?php echo $demands; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/processeddemands">Processed Demands by Hqrs.<span class="pull-right fltright"><?php echo $processeddemands; ?></span></a></li>
        <?php
        break;
    case "-10":
        ?>
                            <br/><br/><br/><br/>
                            <li><a href="<?php echo site_url(); ?>headquarter/icar_applications">New Applications<span class="pull-right fltright"><?php echo $icar_applications; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/icar_processed">Processed Application<span class="pull-right fltright"><?php echo $icar_processed; ?></span></a></li>
        <?php
        break;
    case "-20":
        ?>
                            <br/><br/><br/><br/>
                            <li><a href="<?php echo site_url(); ?>headquarter/ayush_applications">New Applications<span class="pull-right fltright"><?php echo $ayush_applications; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/ayush_processed">Processed Application<span class="pull-right fltright"><?php echo $ayush_processed; ?></span></a></li>
        <?php
        break;
    case "1":
        ?>
                            <li><a href="<?php echo site_url(); ?>headquarter/new_applications">Application Received From Mission<span class="pull-right fltright"><?php echo count($newapplication); ?></span></a></li>	           
                            <li><a href="<?php echo site_url(); ?>headquarter/underprocess">Applications Under Process<span class="pull-right fltright"><?php echo count($underprocess); ?></span></a></li>

                            <li><a href="<?php echo site_url(); ?>headquarter/confirmationfromROs">University Response Received from RO<span class="pull-right fltright"><?php echo $confirmationfromROs; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/confirmationfromallROs">Not-Confirmed by All Three University/Institute<span class="pull-right fltright"><?php echo $confirmationfromallROs; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/applicantAcceptance">Acceptence & Undertaking of Applicant from Missions<span class="pull-right fltright"><?php echo count($acceptance); ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/academicDetails">Academic Details of Students<span class="pull-right fltright"><?php echo $arrived; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/fundmonitoring">Fund Released/Expenditure Details of RO</a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/applicantExpenditure">Expenditure Details of Students</a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/demands">RO's Demand<span class="pull-right fltright"><?php echo $demands; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/processeddemands">Processed Demands by Hqrs.<span class="pull-right fltright"><?php echo $processeddemands; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/alumani">Alumni Details<span class="pull-right fltright"><?php echo $alunamiapplication; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/reports">Reports</a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/expenditurereports">Expenditure Reports</a></li>	
                            <li><a href="<?php echo site_url(); ?>headquarter/complaints">Complaints</a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/getUniversityResponseSentByHqToMission">University Response sent by Hqrs to Mission/Post<span class="pull-right fltright"><?php echo $countresponseSetByHqToMission; ?></span></a></li>
        <?php
        break;
    case "2": case "3": case "4": case "5": case "6": case "7": case "8": case "9": case "10":
        ?>	
                            <li><a href="<?php echo site_url(); ?>headquarter/studentDetails">Student Details<span class="pull-right fltright"><?php echo $students; ?></span></a></li>					
                            <li><a href="<?php echo site_url(); ?>headquarter/academicDetails">Academic Details of Students<span class="pull-right fltright"><?php echo $arrived; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/applicantExpenditure">Expenditure Details of Students</a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/alumani">Alumni Details<span class="pull-right fltright"><?php echo $alunamiapplication; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/reports">Reports</a></li>	
        <?php
        break;
    default:
        ?>	
                            <li><a href="<?php echo site_url(); ?>headquarter/new_applications">Application Received From Mission<span class="pull-right fltright"><?php echo count($newapplication); ?></span></a></li>	           
                            <li><a href="<?php echo site_url(); ?>headquarter/underprocess">Applications Under Process<span class="pull-right fltright"><?php echo count($underprocess); ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/confirmationfromROs">University Response Received from RO<span class="pull-right fltright"><?php echo $confirmationfromROs; ?></span></a></li>					    <li><a href="<?php echo site_url(); ?>headquarter/applicantAcceptance">Acceptence & Undertaking of Applicant from Missions<span class="pull-right fltright"><?php echo count($acceptance); ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/academicDetails">Academic Details of Students<span class="pull-right fltright"><?php echo $arrived; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/applicantExpenditure">Expenditure Details of Students</a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/alumani">Alumni Details<span class="pull-right fltright"><?php echo $alunamiapplication; ?></span></a></li>
                            <li><a href="<?php echo site_url(); ?>headquarter/reports">Reports</a></li>	
        <?php
        break;
}
?>        
                </ul>
            </div>
            <div class="lft">
                <span class="spntext">

                    <b style="color: #337ab7;"><?php
                    if ($division == 0) {
                        echo "Program Director ISD-Accounts";
                    }
                    if ($division == -10) {
                        $divs = $this->common_model->getDivisionById(15);
                        echo strtoupper($divs[0]['name']);
                    }
                    if ($division == -20) {
                        $divs = $this->common_model->getDivisionById(16);
                        echo strtoupper($divs[0]['name']);
                    } elseif ($division > 0) {
                        $divs = $this->common_model->getDivisionById($division);
                        echo strtoupper($divs[0]['name']);
                    }
?> </b>
                    <br/>
                    <label style="font-size:25px;">HEADQUARTER,DELHI </label>
                </span>
                <br/><br/>
                        <?php
                        switch ($division) {
                            case "-10":
                                ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.126985680941!2d77.15879611439696!3d28.625955991130944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d02ce2389f245%3A0xddb5eea25c028bef!2sIndian+Council+of+Agricultural+Research!5e0!3m2!1sen!2sin!4v1499892796571" style="height:212px;width:100%;border:1px solid orange;padding:5px;" frameborder="0" allowfullscreen></iframe>
        <?php
        break;
    case "-20":
        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3503.85079192439!2d77.2116405143957!3d28.57424289346903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce261a70c4d75%3A0x9b665605f37a7ef8!2sAyush+Bhavan!5e0!3m2!1sen!2sin!4v1499892653216" style="height:212px;width:100%;border:1px solid orange;padding:5px;" frameborder="0" allowfullscreen></iframe>
                        <?php
                        break;
                    case "0": case "1": case "11": case "12": case "13":
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d56035.78163841422!2d77.2310811!3d28.6226776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcf6a7c9b6a4be178!2sI.+C.+C.+R.+Azad+Bhavan!5e0!3m2!1sen!2sin!4v1494568307997" style="height:212px;width:100%;border:1px solid orange;padding:5px;" frameborder="0" allowfullscreen></iframe>
                        <?php
                        break;
                    case "5": case "6": case "7": case "8":
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7005.502560770406!2d77.21922217541369!3d28.607237429710946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce2c6cc8ee1bf%3A0x3a3802df681b5c04!2sSouth+Block%2C+Man+Singh+Road+Area%2C+New+Delhi%2C+Delhi!5e0!3m2!1sen!2sin!4v1497015627549" style="height:212px;width:100%;border:1px solid orange;padding:5px;" frameborder="0" style="border:0" allowfullscreen></iframe>
                        <?php
                        break;
                    case "2": case "3": case "4": case "9":
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.6296111654215!2d77.21505091507561!3d28.61088638242643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce2b8096232c3%3A0xd74927f5b5f1d548!2sMinistry+Of+External+Affairs+Jawaharlal+Nehru+Bhawan!5e0!3m2!1sen!2sin!4v1497015803950" style="height:212px;width:100%;border:1px solid orange;padding:5px;" frameborder="0" style="border:0" allowfullscreen></iframe>
                        <?php
                        break;
                    default:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d56035.78163841422!2d77.2310811!3d28.6226776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcf6a7c9b6a4be178!2sI.+C.+C.+R.+Azad+Bhavan!5e0!3m2!1sen!2sin!4v1494568307997" style="height:212px;width:100%;border:1px solid orange;padding:5px;" frameborder="0" allowfullscreen></iframe>
                        <?php
                        break;
                }
                ?>


                <br/>	<br/>

            </div>

            <div  style="float:right;margin:3% auto 0;width:65%;">
                <div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
                    <a target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url(); ?>assets/site/main/images/logos/iccr-logo.png" class="img-circle front"/></a>
                    <a target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url(); ?>assets/site/main/images/logos/iccr-logo.png" class="img-circle back"/></a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
                    <a target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle front"/></a>
                    <a target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle back"/></a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
                    <a target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/india_galance.png" alt="Incredible India" class="img-circle front" /></a>
                    <a target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/india_galance.png" alt="Incredible India" class="img-circle back" /></a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
                    <a target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle front" /></a>
                    <a target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle back" /></a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
                    <a target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/logo.png" class="img-circle front" /></a>							
                    <a target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/logo.png"  class="img-circle back" /></a>
                </div>


                <div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
                    <a target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle front" /></a>
                    <a target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle back" /></a>
                </div>


                <div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
                    <a target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/_logo.jpg" class="img-circle front"/></a>
                    <a target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url(); ?>assets/site/main/images/logos/_logo.jpg" class="img-circle back"/></a>
                </div>
            </div>



            <!--<ul class="strips">
                    <li class="col-xs-12">
                            <div class="col-xs-11 pdleft"><span class="glyphicon glyphicon-hand-right"></span><a href="<?php echo site_url(); ?>headquarter/new_applications">Application Received From Mission</a></div>
                            <div class="col-xs-1"><?php echo count($newapplication); ?></div>
                            
                    </li>
                    <li class="col-xs-12">
                            <div class="col-xs-11 pdleft"><span class="glyphicon glyphicon-hand-right"></span><a href="<?php echo site_url(); ?>headquarter/underprocess">Applications Under Process</a></div>
                            <div class="col-xs-1"><?php echo count($underprocess); ?></div>
                            
                    </li>
                    <li class="col-xs-12">
                            <div class="col-xs-11 pdleft"><span class="glyphicon glyphicon-hand-right"></span><a href="<?php echo site_url(); ?>headquarter/confirmationfromROs">Provisional Confirmation of Admission Received from ROs & Delhi Jurisdiction</a></div>
                            <div class="col-xs-1"><?php echo count($confirmationfromROs); ?></div>
                            
                    </li>
                    <li class="col-xs-12">
                            <div class="col-xs-11 pdleft"><span class="glyphicon glyphicon-hand-right"></span><a href="<?php echo site_url(); ?>headquarter/confirmationForwardtoMissionbyHqrs">Confirmation Forwarded to Mission</a></div>
                            <div class="col-xs-1"><?php echo count($confirmationForwardtoMissionbyHqrs); ?></div>
                            
                    </li>
                    <li class="col-xs-12">
                            <div class="col-xs-11 pdleft"><span class="glyphicon glyphicon-hand-right"></span><a href="<?php echo site_url(); ?>headquarter/travel_applications">Acceptence and Undertaking of candidates from Missions</a></div>
                            <div class="col-xs-1"><?php echo count($newapplication); ?></div>
                            
                    </li>
                    <li class="col-xs-12">
                            <div class="col-xs-11 pdleft"><span class="glyphicon glyphicon-hand-right"></span><a href="<?php echo site_url(); ?>headquarter/travel_applications">Travel Schedule</a></div>
                            <div class="col-xs-1"><?php echo count($newapplication); ?></div>
                            
                    </li>
                    <li class="col-xs-12">
                            <div class="col-xs-11 pdleft"><span class="glyphicon glyphicon-hand-right"></span><a href="<?php echo site_url(); ?>headquarter/regionalExpenditure">View Regional Expenditure Statement</a></div>
                            <div class="col-xs-1"><?php echo count($newapplication); ?></div>
                            
                    </li>
                    <li class="col-xs-12">
                            <div class="col-xs-11 pdleft"><span class="glyphicon glyphicon-hand-right"></span><a href="<?php echo site_url(); ?>headquarter/applicantExpenditure">View Applicant Expenditure Statement</a></div>
                            <div class="col-xs-1"><?php echo count($studentexpenditure); ?></div>
                            
                    </li>
                    
            </ul> -->

            <!--
            
    <div class="col-xs-3 col-xs-6">
     
      <div class="small-box bg-custom">
        <div class="inner">            
          <h3><?php echo count($newapplication); ?></h3>
          <p>Application Received From Mission</p>              
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="<?php echo site_url(); ?>headquarter/new_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
     <div class="col-xs-3 col-xs-6">
     
      <div class="small-box bg-custom">
        <div class="inner">            
          <h3><?php echo count($underprocess); ?></h3>
          <p>Applications Under Process</p>              
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="<?php echo site_url(); ?>headquarter/underprocess" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
   
    <div class="col-xs-3 col-xs-6">
     
      <div class="small-box bg-custom">
        <div class="inner">
        <h3><?php echo count($confirmationfromROs); ?></h3>
          <p>Provisional Confirmation of Admission Received from ROs & Delhi Jurisdiction</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?php echo site_url(); ?>headquarter/confirmationfromROs" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div> 
     <div class="col-xs-3 col-xs-6">
     
      <div class="small-box bg-custom">
        <div class="inner">
        <h3><?php echo count($confirmationForwardtoMissionbyHqrs); ?></h3>
          <p>Confirmation Forwarded to Mission<br/><br/></p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?php echo site_url(); ?>headquarter/confirmationForwardtoMissionbyHqrs" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div> 
      <div class="col-xs-3 col-xs-6">
     
      <div class="small-box bg-custom">
        <div class="inner">
        <h3>1</h3>
          <p>Acceptence and Undertaking of candidates from Missions</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?php echo site_url(); ?>headquarter/travel_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>  
    <div class="col-xs-3 col-xs-6">
     
      <div class="small-box bg-custom">
        <div class="inner">
        <h3>1</h3>
          <p>Travel Schedule </p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?php echo site_url(); ?>headquarter/travel_applications" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
        <div class="col-xs-3 col-xs-6">
     
      <div class="small-box bg-custom">
        <div class="inner">
        <h3>1</h3>
          <p>View Regional Expenditure Statement Year Wise </p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?php echo site_url(); ?>headquarter/regionalExpenditure" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
       <div class="col-xs-3 col-xs-6">
     
      <div class="small-box bg-custom">
        <div class="inner">
        <h3><?php echo $studentexpenditure; ?></h3>
          <p>View Applicant Expenditure Statement Year Wise </p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?php echo site_url(); ?>headquarter/applicantExpenditure" class="small-box-footer bg-custom-link">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>-->
        </div>
    </div>
</section>

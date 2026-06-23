<style>
marquee{
	
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto;
    padding: 10px 0 0;
    text-align: left;
}
hr{
	margin: 0;
}
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
}
</style>
<section class="meacontent">
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
	<div  class="container" style="min-height:410px;padding-top:0;">
	
	<marquee>
		Welcome <?php echo $username; ?> to ICCR Scholarship Portal.<?php if($usercountry == '130')
		{
			?>
			<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" >
			Last date for submitting online application for Burundi is 19 Feburary 2020.
			<?php
		}
		if($usercountry == '116')
		{
			?>
			<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" >
			Last date for submitting online application for Uganda is 13 Feburary 2020.
			<?php
		}
	
		if($usercountry == '108')
		{
			?>
			<img src="<?php echo base_url();?>assets/site/main/images/new2019.gif" alt="new gif Image" >
			Last date for submitting online application for Syria is 5 Feburary 2020 and 12 Feburary 2020 for the written test for English Language .
			<?php
		}
	?>
	</marquee>	
	<hr/>
		<div class="row" style="background:#fff;">
		
		
		
		 <h4 style="color:red;font-weight:bold;text-align: center;border: 1px solid;width: 80%;margin: 0 auto;padding: 14px;">Application editing option will be available in case of <b>Mission/Post</b> find any problem in your application.</h4>
		 

		 <div class="col-xs-8">
		
		 <h3>Welcome to the Indian Council for Cultural Relations</h3>
		 	<div class="col-md-5 pdleft">
					  <img style="height: 178px;width: 100%;margin-top: 8px;" class="first-slide" src="<?php echo base_url();?>assets/site/main/images/banner/banner1.jpg" alt="ICCR" />
					</div>
					<div class="col-md-7">
					  
          <p style="text-align:justify;">
The Indian Council for Cultural Relations (ICCR) was founded in 1950 by Maulana Abul Kalam Azad, independent India’s first Education Minister. Its objectives are to actively participate in the formulation and implementation of policies and programmes pertaining to India’s external cultural relations; to foster and strengthen cultural relations and mutual understanding between India and other countries; to promote cultural exchanges with other countries and people; and to develop relations with nations.</p> 
					</div>
		 	        
        </div>
        <?php
        if(count($academicDeatils)>0 && $academicDeatils[0]["scholarship_status"] > 0)
        {
			?>
			 <div class="col-xs-2">
        	<br/><br/>
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
            
			<?php             
            if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['status'] == 'Submit')
            {
				?>
              <h4 class="text-center">View Application</h4>
			  <?php
			}
			else
			{
			?>
              <h4 class="text-center">Apply Application</h4>
			  <?php	
			}
			  ?>
              
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <?php    
                    
            if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['status'] == 'Submit' )
            {
			?>
			<a href="<?php echo site_url(); ?>applicant/viewApplication/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
			<?php	
			}
			else 
			{
			?>
			<a href="<?php echo site_url();?>applicant/applicant_personal_info" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			<?php	
			}
            ?>
          </div>
          <?php
          
          ?>
           
              <div class="small-box bg-blue">
            <div class="inner">
           
               <h4 class="text-center">Check Status</h4>
              
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           <a href="<?php echo site_url(); ?>applicant/applicantStatus/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>  
          <div class="small-box bg-green">
            <div class="inner">
           
               <h4 class="text-center">View Profile</h4>
              
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>/applicant/viewProfile" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>       
        </div>
			<?php
		}
		else
		{
			?>
			 <div class="col-xs-3">
        	<br/><br/>
          <!-- small box -->
          <div class="small-box bg-aqua">
		  
		  
		  
		  
           		  <?php $user_data = $this->session->userdata('user_data');	
				$userId = $user_data['userid'];	


if($userId == 203795 || $userId == 203797 || $userId == 203799){
	?>
	
	 <div class="inner">
            
			<?php  

			
            if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['status'] == 'Submit' )
            {
				?>
              <h4 class="text-center">View Application</h4>
			  <?php
			}
			else
			{
			?>
              <h4 class="text-center">Apply Application r</h4>
			  <?php	
			}
			  ?>
              
            </div>
	<?php
}else{
	?>
	
	 <div class="inner">
            
			<?php  

			
            if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['status'] == 'Submit' )
            {
				?>
              <h4 class="text-center">View Application</h4>
			  <?php
			}
			else
			{
			?>
              <h4 class="text-center">Apply Application</h4>
			  <?php	
			}
			  ?>
              
            </div>
	<?php
}
				?>
				
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <?php             
            if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['status'] == 'Submit' )
            {
			?>
			<a href="<?php echo site_url(); ?>applicant/viewApplication/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
			<?php	
			}
			else 
			{
			?>
			
			<?php if($userId == 203795 || $userId == 203797 || $userId == 203799)
			{
				?>
					<a href="<?php echo site_url();?>applicant/applicant_personal_infoayush" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
				
			}
			else
			{
			?>
	<a href="<?php echo site_url();?>applicant/applicant_personal_info" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
<?php			
				
			}
			
			?>
			
		
			
			
			
			<?php	
			}
            ?>
          </div>
          <?php
          
          ?>
           
              <div class="small-box bg-blue">
            <div class="inner">
           
               <h4 class="text-center">Check Status</h4>
              
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           <a href="<?php echo site_url(); ?>applicant/applicantStatus/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>  
          <div class="small-box bg-green">
            <div class="inner">
           
               <h4 class="text-center">View Profile</h4>
              
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>/applicant/viewProfile" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>   
          <?php 
          if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['status'] == 'Submit')
          {
		  	?>
		  	  <div class="small-box bg-green">
            <div class="inner">
           
               <h4 class="text-center">Add Youtube Video/Audio Link</h4>
              
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo site_url(); ?>/applicant/addVideo/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">Click Here<i class="fa fa-arrow-circle-right"></i></a>
          </div> 
		  	<?php
		  }
          ?>
              
        </div>
			<?php
		}	
        ?>       
        <?php
        
        	if(count($academicDeatils)>0 && $academicDeatils[0]["scholarship_status"] > 0)
        	{
				?>
				 <div class="col-xs-2">
        	<br/><br/>
           <div class="small-box bg-red">
            <div class="inner">
               <h4 class="text-center">Complaints</h4>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           <a href="<?php echo site_url(); ?>applicant/complaints/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
          <div class="small-box bg-yellow">
            <div class="inner">
               <h4 class="text-center">Bank Details</h4>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           <a href="<?php echo site_url(); ?>applicant/bankdetails/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
           <div class="small-box bg-orange">
            <div class="inner">
               <h4 class="text-center">FRRO Details</h4>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
           <a href="<?php echo site_url(); ?>applicant/frroDetails/<?php echo $applicaitonStepOne[0]['application_no']; ?>" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
				<?php
			}
        ?>
		
        <!-- ./col -->
        <div class="col-xs-6">
          <!-- small box -->
          
        </div>      
      </div>
	</div>
</section>
	
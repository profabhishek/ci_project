<style type="text/css">
.tab-content{ padding: 10px 20px 20px;border:none;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}

.card-bkimg {
    -webkit-filter: blur(25px);
    -moz-filter: blur(25px);
    -o-filter: blur(25px);
    -ms-filter: blur(25px);
    filter: blur(25px);    
    margin-left: -100px !important;
    margin-top: -200px !important;
    min-width: 130%;
}
 .card1 {
      background-color: rgba(214, 224, 226, 0.2) !important;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    box-sizing: border-box;
    display: block;
    height: 167px;
    margin: 0;
    padding: 30px !important;
    width: 100%;
    -webkit-border-top-left-radius:5px;
    -moz-border-top-left-radius:5px;
    border-top-left-radius:5px;
    -webkit-border-top-right-radius:5px;
    -moz-border-top-right-radius:5px;
    border-top-right-radius:5px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.card1.hovercard {
    position: relative;
    padding-top: 0;
    overflow: hidden;
    text-align: center;
    background-color: #fff;
    background-color: rgba(255, 255, 255, 1);
}
.card1.hovercard .card-background {
    height: 130px;
}

.card1.hovercard .useravatar {
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
}
.card1.hovercard .useravatar img {
    width: 100px;
    height: 100px;
    max-width: 100px;
    max-height: 100px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    border: 5px solid rgba(255, 255, 255, 0.5);
}
.card1.hovercard .card-info {
    position: absolute;
    bottom: 14px;
    left: 0;
    right: 0;
}
.card1.hovercard .card-info .card-title {
    padding:0 5px;
    font-size: 20px;
    line-height: 1;
    color: #FFF;
    font-weight:bold;
    background-color: rgba(255, 255, 255, 0.1);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
.card1.hovercard .card-info {
    overflow: hidden;
    font-size: 12px;
    line-height: 20px;
    color: #737373;
    text-overflow: ellipsis;
}
.card1.hovercard .bottom {
    padding: 0 20px;
    margin-bottom: 17px;
}
.btn-pref .btn {
    -webkit-border-radius:0 !important;
}
.well {
   
    min-height: 187px !important;
   margin-bottom: 0;
   background-color: #fff;
}
</style>
<section class="meacontent">
	
	
	<div  class="container" style="min-height:410px;padding:0px;">
	<marquee>Welcome INDIAN COUNCIL FOR CULTURAL RELATIONS (DELHI) to ICCR Scholarship Portal</marquee>
	<div class="tab-content" style="min-height:200px;overflow:hidden;padding:9px 34px 34px;">		
	  <div id="home" class="tab-pane fade in active">	
	  
	      <div class="col-lg-12 col-sm-12" style="padding:0;">
    <div class="card1 hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" src="<?php echo site_url();?>assets/site/main/images/bg/colourback_5019.jpg">
            <!-- http://lorempixel.com/850/280/people/9/ -->
        </div>
        <div class="useravatar">
        <?php 
						$userd = $this->common_model->getUserInfo( $applicaitonStepOne[ 0 ][ 'uid' ] );
					if($userd->dir == "" ){
							?>
						<img id="profil_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png"/>
						<?php	
						}
						else
						{
						?>
						<img id="profil_image_div" src="<?php echo site_url();?><?php echo $userd->dir.'/'. $userImage; ?>"/> <a href="javascript:void(0);"/>
						<?php		
						}
              		?>
            
        </div>
        <div class="card-info"> <span class="card-title">
        				<?php $title = '';									
						  if(count($registerData) > 0)
						  {
						  	$title = $registerData[0]['username'];
						  }												  
					  ?>
					  <?php if(!empty($registerData)) echo $registerData[0]['username'];?></span>

        </div>
    </div>
    <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" id="stars" class="btn bg-green" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">Personal Information</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                <div class="hidden-xs">Contact Details</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="following" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                <div class="hidden-xs">Postal Address</div>
            </button>
        </div>
    </div>

        <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1" style="overflow:hidden;">        
          <div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					<label>Gender: </label>	<?php $title = '';
						  if(count($registerData) > 0)
						  {
						  	$title = $registerData[0]['gender'];
						  }
						  if($title == 1)
						  {
						  ?>
							Male					  							 
						  <?php	
						  }
						  elseif($title == 2)
						  {
						  ?>
							 
					  		Female							  
						  <?php		
						  }	?>	
				
					</div>	
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
						 <label for="comment"> Date of Birth: </label><?php if(!empty($registerData)) echo $registerData[0]['date_of_birth'];?>							
					
				
					</div>
						<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					 <label for="comment">Nationality:   </label>	<?php   $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $nationality)
						  {
						  	if(!empty($registerData))
						  	{
								if($registerData[0]['country_of_domicile'] == $nationality['id'])
								{
									echo $nationality['country_name'];
								}								
							}
						  	
						  }
						  ?>					
					</div>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
					 <label> Country of Residence:  </label><?php //echo "<pre>";print_r($applicaitonStepOne);die;
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $nationality)
						  {
						  	if(!empty($registerData))
						  	{
								if($registerData[0]['country_of_domicile'] == $nationality['id'])
								{
									echo $nationality['country_name'];
								}								
							}
						  	
						  }
						  ?>
						
					
					</div>
        </div>
        <div class="tab-pane fade in" id="tab2" style="overflow:hidden;">
          <div class="col-xs-12 col-sm-7 col-md-12 contact-detail">
			<label>Mobile Number:</label>
			
			 <?php if(!empty($registerData)) echo $registerData[0]['mobile_number'];?>
				
		  </div>
		  <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdright">
			<label>Email Id: </label>	
			 <?php if(!empty($registerData)) echo $registerData[0]['email_id'];?>
			</div>
        </div>
        <div class="tab-pane fade in" id="tab3" style="overflow:hidden;">
          <div class="addres-sec col-xs-9 col-sm-9 col-md-4 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment"> Postal Address </label>	
							<div class="form-group col-md-12 pdleft">							
						  <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address'];?><br/>
						  City :<?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_city'];?><br/>
						  State: <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_state'];?><br/>
						  Country:  <?php
						  $countries = $this->common_model->getCountries();
						  foreach($countries as $country)
						  {
						  	if(!empty($applicaitonStepOne))
						  	{
								if($applicaitonStepOne[0]['postal_address_country'] == $country['id'])
								{
									echo $country['country_name'];
								}
							}
						  }
						  ?>
						  <br/>
						  Pincode: <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['postal_address_pincode'];?>
					</div>
					
										
				 </div>
				</div>
        </div>
      </div>
    </div>
    
    </div>
	  
	  
	  
	  
	  
                
              
              
          
              
              
              
              
              
                   
	  </div>	   
	</div>
	</div>
</section>



            
    	
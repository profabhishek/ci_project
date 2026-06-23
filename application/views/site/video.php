<style type="text/css">
.bg-custom{background:#DBDBDD;border:1px solid #aaa;}
.bg-custom-link{background:#337ab7 !important;}
.small-box:hover{color:#337ab7;}
.small-box>.inner{min-height:130px;}
.bg-custom > .inner > p{bottom: 25px;position:absolute;font-size:14px;}
.loginname{color: #337ab7;margin-left:20px;border-left:2px solid #cecece;padding-left:13px;}
.strips{
	
}
.carousel-inner .item img
{
	 border: 4px solid orange;
    height: 299px;
    width: 100%;
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
    width: 90%;
    margin: 0 auto;
    min-height:250px;
    text-align: left;
}
.hd{
	   color: #747474;
    display: block;
    font-size: 24px;
    text-align: center;
    text-shadow: 0 0 2px black;
    width: 100%;
}
</style>
<section class="meacontent" style="margin-top:0;">	
<div class="container" style="float:none;height:38px;margin:0 auto;text-align: left;padding:0 16px;">
	<marquee>Welcome INDIAN COUNCIL FOR CULTURAL RELATIONS (DELHI) to ICCR Scholarship Portal</marquee>		
</div>		
	<div  class="container">
		<div class="row" style="background:#fff;">		
			
			
			
			
      <div class="lft">
		
		<br/>
		
		<?php   
		
		$vedio = $this->common_model->getUniversitiesVedio();
		if(!empty($vedio)){
		foreach($vedio as $unVedio){
			//echo "<pre>";print_r($unVedio);
			?>
			
		<div id="myCarousel" class="carousel slide" data-ride="carousel" style="float:left;margin-right:90px;max-height:500px;width:25%;">
			<div class="carousel-inner" role="listbox">
			
			<div class="item active">
			<?php
			if($unVedio['path'] == null){
				?>
			  <div class="embed-responsive embed-responsive-16by9">
			  <iframe class="embed-responsive-item" src="<?php echo $unVedio['link']?>" allowfullscreen></iframe>
			</div>
			
			<?php
			
			}
			?>
			</div>
			
			
			<?php 
			if($unVedio['link'] == null){
			?>
			<div class="item active">
			 <video controls width="320" height="240">
			  <source src="<?php echo base_url();?>assets/site/main/universities_vedio/<?php echo $unVedio['path'];?>" type="video/mp4">
			  </video>
			</div>
			<?php  if(!empty($unVedio['name'])){
						?>
						<?php echo $unVedio['name']?>
						<?php
					}
					?>
			<?php
			}	
			?>
			
			
			</div>
		</div>
		
		
			
			<?php
			
		}
		
		}
		?>
		
		


      	<br/>	<br/>
      	
      </div>
		
		
		<!-----<div  style="margin:1% auto 0;width:75%;">
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
				</div>---->
		
		
	
      </div>
	</div>
</section>
	
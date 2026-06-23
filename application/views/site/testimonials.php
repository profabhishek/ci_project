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

#quote-carousel {
    padding: 0 10px 30px 10px;
    margin-top: 60px;
}
#quote-carousel .carousel-control {
    background: none;
    color: #CACACA;
    font-size: 2.3em;
    text-shadow: none;
    margin-top: 30px;
}
#quote-carousel .carousel-indicators {
    position: relative;
    right: 50%;
    top: auto;
    bottom: 0px;
    margin-top: 20px;
    margin-right: -19px;
}
#quote-carousel .carousel-indicators li {
    width: 50px;
    height: 50px;
    cursor: pointer;
    border: 1px solid #ccc;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    opacity: 0.4;
    overflow: hidden;
    transition: all .4s ease-in;
    vertical-align: middle;
}
#quote-carousel .carousel-indicators .active {
    width: 128px;
    height: 128px;
    opacity: 1;
    transition: all .2s;
}
.item blockquote {
    border-left: none;
    margin: 0;
}
.item blockquote p:before {

    font-family: 'Fontawesome';
    float: left;
    margin-right: 10px;
}

</style>
<section class="meacontent" style="margin-top:0;">	
<div class="container" style="float:none;height:38px;margin:0 auto;text-align: left;padding:0 16px;">
	<marquee>Welcome to Indian Council for Cultural Relations Scholarship Portal</marquee>		
</div>		
	<div  class="container" style="min-height:502px;padding-top:100px;">
		<div class="row" style="background:#fff;">		
			
			<div class = "container">
        <div class = "row">
            <div class = "col-md-12">
                <div class = "carousel slide" data-ride = "carousel" id = "quote-carousel">
 
                    <!-- Carousel Slides / Quotes -->
                    <div class = "carousel-inner text-center">
					<?php $i=1; $todate = date('Y-m-d');
					$testimonials = $this->common_model->getActiveTestimonials($todate);
						 //echo "<pre>";print_r($testimonials);die;
						if(!empty($testimonials)){
						
					foreach($testimonials as $testmonl){ 
					if($i==1){
					$Active = 'active';
					} else {
						$Active = '';
					}
					?>
                        <!-- Quote 1 -->
                        <div class = "item <?php echo $Active; ?>">
                            <blockquote>
                                <div class = "row">
                                    <div class = "col-sm-8 col-sm-offset-2">
									
									<?php 
									if($testmonl['testimonials_file_path'] == '')
									{
										?>
										<a href = "<?php echo base_url();?>assets/site/docs/<?php echo $testmonl['testimonials_url'];?>" target = "_blank"><p> "<?php echo $testmonl['title'];?>" </p></a>
										
										<?php
									}
									else
									{
										?>
										<a href = "<?php echo $testmonl['testimonials_url'];?>" target = "_blank"><p> "<?php echo $testmonl['title'];?>" </p></a>
										<?php
									}
									?>
                                        
                                        <small> <?php if(!empty($testmonl['student_name']))
					 { echo $testmonl['student_name']; } 
				  if(!empty($testmonl['country']))
					 {
						?>
						 <label>Country : <?php echo $testmonl['country'];?> </label> 
						<?php
						 
					 }
					  if(!empty($testmonl['course']))
					 {
						?>
						 <label>Course : <?php echo $testmonl['course'];?> </label> 
						<?php
						 
					 }
				 ?>

				 </small>
                                    </div>
                                </div>
                            </blockquote>
                        </div>
						
						<?php $i++; } }?>
                        <!-- Quote 2 -->
                        <!--<div class = "item">
                            <blockquote>
                                <div class = "row">
                                    <div class = "col-sm-8 col-sm-offset-2">
                                        <p> Edureka has the best online courses!  </p>
                                        <small> Reviewer's Name </small>
                                    </div>
                                </div>
                            </blockquote>
                        </div>-->
                        
                    </div>
                    <!-- Bottom Carousel Indicators -->
                    <ol class = "carousel-indicators">
                        
                        
						 <?php $j=0; $todate = date('Y-m-d');
					$testimonials = $this->common_model->getActiveTestimonials($todate);
					foreach($testimonials as $testmonl){ 
					if($j==0){
					$Active = 'active';
					} else {
						$Active = '';
					}
						 if(empty($testmonl['testimonials_profile_image']))
					 {
						 ?>
											 <li data-target = "#quote-carousel" data-slide-to = "<?php echo $j; ?>" class = "<?php echo $Active; ?>"> <img class = "img-responsive " src = "<?php echo base_url();?>assets/site/main/images/default_avatar.png"><?php echo $j; ?></a>">
                        </li>
						 <?php
					 }
					 else
					 {
						 ?>
						<li data-target = "#quote-carousel" data-slide-to = "<?php echo $j; ?>" class = "<?php echo $Active; ?>"> <img class = "img-responsive " src = "<?php echo base_url();?>assets/site/main/testimonials/<?php echo $testmonl['testimonials_profile_image'];?>"><?php echo $j; ?></a>">
                        </li>
						 <?php
					 }
$j++; }
					 ?>
                    </ol>
 
                    <!-- Carousel Buttons Next/Prev -->
                    <a data-slide = "prev" href = "#quote-carousel" class = "left carousel-control"><i class = "fa fa-chevron-left"> </i> </a>
                    <a data-slide = "next" href = "#quote-carousel" class = "right carousel-control"><i class = "fa fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
      
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
	
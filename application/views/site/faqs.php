	<style type="text/css">
.hd{
	text-align: center; border-bottom: 1px solid rgb(206, 206, 206); padding-bottom: 14px; margin-bottom: 20px;
}
.fqs
{
	 padding: 10px 35px 10px 10px;
    text-align: justify;
}
.fqs span
{
	  color: green;
    font-size: 15px;
    font-weight: bold;
    margin-left: 6px;
    margin-right: 9px;
}
.srilanka-scheme ul li a {
    color: #f18f2e;
    font-size: 16px;
    font-weight: bold;
}
.panel-heading{
	border-bottom:1px solid #cecece !important; 
}
.panel-heading h4 a{
	color: #02335C;
    font-weight: normal;
    margin-left: 7px;
}
</style>
	<section class="meacontent" id="meacontent">
			<div  class="container">
				 <h2 class="hd">Indian Council for Cultural Relations  Scholarship FAQ's</h2>
				
				
				 <div class="panel-group">
				  <div class="panel panel-default">
				  	<?php
				  	$i =0;
						$faqs = $this->common_model->getAllFaqs();
						foreach($faqs as $fqs)
						{
							echo '<div class="panel-heading">
						      <h4 class="panel-title">
						        <b><span class="glyphicon glyphicon-screenshot"></span><a data-toggle="collapse" href="#collapse'.$i.'">'.$fqs['item'].'</a></b>
						      </h4>
						    </div>';
							echo '<div id="collapse'.$i.'" class="panel-collapse collapse fqs"><span class="glyphicon glyphicon-hand-right"></span>'.$fqs['desc'].'</div>';
							$i++;
						}
						?>	
				  </div>
				</div> 
				
				
				
				
				
				
				
			<div  style="width: 76%;margin: 0 auto;">
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
		</section>
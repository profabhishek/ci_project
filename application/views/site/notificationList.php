	<style type="text/css">
.hd{
	text-align: center; border-bottom: 1px solid rgb(206, 206, 206); padding-bottom: 14px; margin-bottom: 20px;
}
.srilanka-scheme ul li a {
    color: #f18f2e;
    font-size: 16px;
    font-weight: bold;
}
</style>
	<section class="meacontent" id="meacontent">
			<div  class="container">
				 <h2 class="hd">Indian Council for Cultural Relations Notifications</h2>
				<div class="col-xs-12 col-sm-6 col-md-12 pdleft pdright">
					<div class="srilanka-scheme">
						<ul>
						<?php
						if(!empty($notifications)){
						
						foreach($notifications as $notification)
						{
						if(isset($notification['notification_doc']) && !empty($notification['notification_doc']) &&  file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/site/main/notification/'.$notification['notification_doc']))
						{	
							?>
							<li><a target="_blank" href="<?php echo site_url().'assets/site/main/notification/'.$notification['notification_doc']; ?>"><i class="fa  fa-1x text-red"></i> <?php echo $notification['title'] ?></a>
							</li>
							
						<?php }else{?>
							<li><?php echo $notification['title'] ?>
							</li>
						<?php }
						}
						?>	
						<?php }else{?>
						<li>No Active Notification is found</li>
						<?php } ?>
						</ul>
						<div>
						<div class="form-group btn-sec">
								<div class="submit-sec input-rig">
								<button id="archievebtn"  onclick="location.href='<?php echo site_url();?>home/archieveList/'">Archive</button>
							
								
								</div>
							</div>
					
					</div>
					</div>
					
				</div>
			<div  style="width: 76%;margin: 0 auto;">
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle front" alt="Iccr"/></a>
						<a title="External site that open in new window" target="_blank" href="http://www.iccr.gov.in/"><img style="height:70px;" src="<?php echo base_url();?>assets/site/main/images/logos/iccr-logo.png" class="img-circle back" alt="Iccr"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle front" alt="Ministry-of-External-Affairs"/></a>
						<a title="External site that open in new window" target="_blank" href="http://mea.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/Internship-Ministry-of-External-Affairs.jpg" class="img-circle back" alt="Ministry-of-External-Affairs"/></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="http://knowindia.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india_galance.png" alt="Know India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="National Portal of India" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="National Portal of India" class="img-circle back" /></a>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" class="img-circle front" alt="Idayofyoga"/></a>							
						<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png"  class="img-circle back" alt="Idayofyoga"/></a>
					</div>
					
					
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Make In India" class="img-circle front" /></a>
						<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Make In India" class="img-circle back" /></a>
					</div>
					
									
					<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
						<a title="External site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle front" alt="Incredible India"/></a>
						<a title="External site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle back" alt="Incredible India"/></a>
					</div>
				</div>
			</div>
		</section>

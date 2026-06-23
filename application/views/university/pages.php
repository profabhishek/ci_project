
<?php if($pages[0]['master_page_id'] == 1 || $pages[0]['master_page_id'] == 3){?>

<style type="text/css">
.hd{
	text-align: center; border-bottom: 1px solid rgb(206, 206, 206); padding-bottom: 14px; margin-bottom: 20px;
}
</style>
<?php } ?>
<?php if($pages[0]['master_page_id'] == 2){?>
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
<?php } ?>
<?php if($pages[0]['master_page_id'] == 4){?>
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
<?php } ?>

<?php 
//=========================================This is for About Us Section============================
if($pages[0]['master_page_id'] == 1){?>
<section class="meacontent" id="meacontent">
	<div  class="container" style="min-height:410px;">
	<div class="field-item even">
	
		<h1 class="hd"><?php echo $pages[0]['page_title']?></h1>
		<?php if (!empty($pages[0]['page_main_image'])){?>
		<div class="col-md-7 pdleft">
		<img style="height: 287px;width: 100%;margin-top: 0px;" class="first-slide" src="<?php echo base_url();?>assets/site/main/page_main_image/<?php echo $pages[0]['page_main_image']?>" alt="ICCR" />
		</div>
		
		<div class="col-md-5"><p style="text-align:justify;"><?php echo $pages[0]['page_description']?></p></div>
		<?php }else{ ?>
		
		<div class="col-md-12"><p style="text-align:justify;"><?php echo $pages[0]['page_description']?></p></div>
		<?php } ?>
	</div>
	</div>
</section>
<?php } ?>
<?php
//=========================================This is for Programme & course Section============================
if($pagecr[0]['master_page_id'] == 1){?>
<section class="meacontent" id="meacontent">
	<div  class="container" style="min-height:410px;">
	<div class="field-item even">
	
		<h1 class="hd"><?php echo $pages[0]['page_title']?></h1>
		<?php if (!empty($pages[0]['page_main_image'])){?>
		<div class="col-md-7 pdleft">
		<img style="height: 287px;width: 100%;margin-top: 0px;" class="first-slide" src="<?php echo base_url();?>assets/site/main/page_main_image/<?php echo $pages[0]['page_main_image']?>" alt="ICCR" />
		</div>
		
		<div class="col-md-5"><p style="text-align:justify;"><?php echo $pages[0]['page_description']?></p></div>
		<?php }else{ ?>
		
		<div class="col-md-12"><p style="text-align:justify;"><?php echo $pages[0]['page_description']?></p></div>
		<?php } ?>
	</div>
	</div>
</section>
<?php } ?>


<?php
//=========================================This is for Stream Section============================
if($page[0]['master_page_id'] == 1){?>
<section class="meacontent" id="meacontent">
	<div  class="container" style="min-height:410px;">
	<div class="field-item even">
	
		<h1 class="hd"><?php echo $pages[0]['page_title']?></h1>
		<?php if (!empty($pages[0]['page_main_image'])){?>
		<div class="col-md-7 pdleft">
		<img style="height: 287px;width: 100%;margin-top: 0px;" class="first-slide" src="<?php echo base_url();?>assets/site/main/page_main_image/<?php echo $pages[0]['page_main_image']?>" alt="ICCR" />
		</div>
		
		<div class="col-md-5"><p style="text-align:justify;"><?php echo $pages[0]['page_description']?></p></div>
		<?php }else{ ?>
		
		<div class="col-md-12"><p style="text-align:justify;"><?php echo $pages[0]['page_description']?></p></div>
		<?php } ?>
	</div>
	</div>
</section>
<?php } ?>


<?php 
//=========================================This is for Schemes Section============================
if($pages[0]['master_page_id'] == 2){?>
<section class="meacontent" id="meacontent">
	<div  class="container">
		<h2 class="hd">Indian Council for Cultural Relations  Scholarship Schemes</h2>
		<h4>Note:-These Scholorship Schemes are administred by ICCR</h4>
		<div class="col-xs-12 col-sm-6 col-md-12 pdleft pdright">
			<div class="srilanka-scheme">
			<?php echo $pages[0]['page_description'];?>
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
				<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle front" /></a>
				<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle back" /></a>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
				<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" class="img-circle front" alt="I day of yoga"/></a>							
				<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png"  class="img-circle back" alt="I day of yoga"/></a>
			</div>			
			<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
				<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle front" alt="Make in India"/></a>
				<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle back" alt="Make in India"/></a>
			</div>
			
							
			<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
				<a title="External site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle front" alt="Incredible India"/></a>
				<a title="External site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle back" alt="Incredible India"/></a>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<?php 
//=========================================This is for Instruction Section============================
if($pages[0]['master_page_id'] == 3){?>
<section class="meacontent" id="meacontent">
	<div  class="container">
	<h2 class="hd">INSTRUCTIONS TO CANDIDATES FOR FILLING THE APPLICATION FORM</h2>
	<div class="field-item even" property="content:encoded">
	<?php echo $pages[0]['page_description'];?>
	</div>
	</div>
</section>
<?php } ?>
<?php 
//=========================================This is for Faq Section============================
if($pages[0]['master_page_id'] == 4){?>
<section class="meacontent" id="meacontent">
	<div  class="container">
		<h2 class="hd">Indian Council for Cultural Relations Scholarship FAQ's</h2>				
		<div class="panel-group">
			<div class="panel panel-default">
			<?php echo $pages[0]['page_description'];?>
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
				<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle front" /></a>
				<a title="External site that open in new window" target="_blank" href="https://india.gov.in/"><img src="<?php echo base_url();?>assets/site/main/images/logos/india-gov.png" alt="eFilling India" class="img-circle back" /></a>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
				<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png" class="img-circle front" alt="I day of yoga"/></a>							
				<a title="External site that open in new window" target="_blank" href="http://idayofyoga.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/logo.png"  class="img-circle back" alt="I day of yoga"/></a>
			</div>			
			<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
				<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle front" alt="Make in India"/></a>
				<a title="External site that open in new window" target="_blank" href="http://www.makeinindia.com/home"><img src="<?php echo base_url();?>assets/site/main/images/logos/i-bWNH6DK.png" alt="Ministry of Tourism" class="img-circle back" alt="Make in India"/></a>
			</div>
			
							
			<div class="col-xs-12 col-sm-6 col-md-6 pdleft goals card">
				<a title="External site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle front" alt="Incredible India"/></a>
				<a title="External site that open in new window" target="_blank" href="https://incredibleindia.org/"><img src="<?php echo base_url();?>assets/site/main/images/logos/_logo.jpg" class="img-circle back" alt="Incredible India"/></a>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<?php 
//=========================================This is for Footer Page============================
if($pages[0]['master_page_id'] == 0){?>
<section class="meacontent" id="meacontent">
<div class="containear" style="float:none;height:38px;margin:0 auto;text-align: left;padding:0 16px;">
	<marquee>Welcome INDIAN COUNCIL FOR CULTURAL RELATIONS (DELHI) to ICCR Scholarship Portal</marquee>		
</div>
	<div  class="container" style="min-height:410px;">
	<div class="field-item even" property="content:encoded">
		<div class="col-md-12 text-justify">
		 	<div class="field-item even" property="content:encoded"><h2><?php echo $pages[0]['page_title']?></h2>
			<p><span><?php echo $pages[0]['page_description']?></span></p>
			</div>
		</div>
	</div>
	</div>
</section>
<?php } ?>
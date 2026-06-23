<!doctype html>

<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="<?php echo base_url();?>assets/site/main/images/favicon.ico" type="image/vnd.microsoft.icon" />
<!--<meta http-equiv="Cache-Control" content=" private, no-cache, no-store, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="title" content="Indian Council for Cultural Relations">
<meta name="description" content="The Indian Council for Cultural Relations (ICCR) was founded in 1950 by Maulana Abul Kalam Azad, independent India’s first Education Minister. Its objectives are to actively participate in the formulation and implementation of policies and programs pertaining to India’s external cultural relations">
<meta name="keywords" content="Indian Council for Cultural Relations,ICCR">
<title>Indian Council for Cultural Relations</title>

<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap-dialog.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/datatables.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/AdminLTE.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/mea-portal.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/dropzone.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/jquery-ui.css" />
<?php
echo '<script type="text/javascript">var baseURL="'.base_url().'";</script>';
echo '<script type="text/javascript">var Controller="'.$this->router->fetch_class().'";</script>';
echo '<script type="text/javascript">var Action="'.$this->router->fetch_method().'";</script>';
?>
<?php echo '<script type="text/javascript">var baseURL = "'.base_url().'";</script>'; ?>
<?php echo '<script type="text/javascript">var csrf_test_name = "'.$this->security->get_csrf_hash().'";</script>'; ?>
<?php echo '<script type="text/javascript">var csrfName = "'.$this->security->get_csrf_token_name().'";</script>';?>
<?php echo '<script type="text/javascript">var csrfHash = "'.$this->security->get_csrf_hash().'";</script>';?>
<?php echo '<script type="text/javascript">var isProduction = "'.$this->config->item("isProduction").'";</script>';?>
<?php 
$userdata =$this->session->userdata('user_data');
if(!$this->session->userdata('user_data'))
{
echo '<script type="text/javascript">var redirectLink = "'.site_url().'";</script>';
echo '<script type="text/javascript">var isLogin = "false";</script>';
}
else
{
echo '<script type="text/javascript">var isLogin = "true";</script>';
$roles = $this->config->item('roles_id');
$role = $roles[$userdata['user_type']];
switch($role)
{				
case "ICCR":
echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'headquarter/logout";</script>';
break;				
case "Mission":	
echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'mission/logout";</script>';
break;
case "Super Admin":	
echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'admin/logout";</script>';
break;
case "Sfs":	
echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'Sfs/logout";</script>';
break;

}
}
?>

<script src="<?php echo base_url();?>assets/site/main/js/jquery-3.7.1.min.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap.min.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap-dialog.min.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/datatables.min.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/dropzone.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/jquery-ui.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/flip.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/custom.js" ></script>



<!----------------------LightBox------------------------------>
<script src="<?php echo base_url();?>assets/site/main/js/bootbox/bootbox.min.js" ></script>

<script type="text/javascript">
$(document).ready(function($) {
var isMessage = getParameterByName("text");		
var msgType = getParameterByName("type");	
var alertType = getParameterByName("at");
var redirect = getParameterByName("redirect");
if(getParameterByName("text") != undefined && getParameterByName("text") != "" && getParameterByName("text") != null)
{
switch(alertType)
{
case "danger":
BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: msgType ,message: isMessage ,buttons: [{label: 'OK',action: function(dialog) {location.href=redirect;}}]}); 	
break;
case "success":
BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: msgType ,message: isMessage ,buttons: [{label: 'OK',action: function(dialog) {location.href=redirect;}}]}); 	
break;
case "warning":
BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: msgType ,message: isMessage ,buttons: [{label: 'OK',action: function(dialog) {location.href=redirect;}}]}); 	
break;
}

}		

});
$(function(){
$(".card").flip({
trigger: "hover"
});
});
</script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css"> 
.card {
width: 100px;
height: 100px;
margin: 20px;
display: inline-block;
}

.front, .back {       
}
.front {

}
.back {       
}
</style>
</head>

<body>
<noscript>
<div class="js_enable">This page is trying to run JavaScript and your browser either does not support JavaScript or you may have turned-off JavaScript. If you have disabled JavaScript on your computer, please turn on JavaScript, to have proper access to this page.</div>   
</noscript>
<div class="container-fluid"> 
<div class="row">
<header>
<div class="topheader">
<div class="container" >
<nav class="navbar navbar-default">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1">
		<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
	</button>
	<div class="collapse navbar-collapse" id="defaultNavbar1">
	  <ul class="nav navbar-nav">
		<li class="updationdate tcenter"><?php echo date('d M, Y | h:i A').' IST';?></li>
	  </ul>
	  <ul class="skipcontent tcenter nav navbar-nav navbar-right">
		<li><a href="<?php echo site_url();?>">Home</a></li>
		<li><a href="#meacontent">Skip to main content</a></li>							
		<li class="nobg"><a id="decfont" href="">A<sup>-</sup></a></li>
		<li class="nobg"><a id="norfont" href="">A</a></li>
		<li class="nobg"><a id="incfont" href="#">A<sup>+</sup></a></li>							
		<li><a href="<?php echo site_url();?>seo/sitemap" class="hindi">Sitemap</a></li>
	  </ul>
	</div>
</nav>
</div>
</div>
<div class="midheader">
<div class="container" >
<div class="logo">
	<div class="col-xs-12 col-sm-4 col-md-4 tcenter nopadding logo-sec">
		<a href="<?php echo site_url();?>"><img src="<?php echo base_url();?>assets/site/main/images/mea-logo.png" title="A2A Indian council for culture relations / Government of India" alt="MEA Logo" /></a>
	</div>
	<div class="col-xs-12 col-sm-7 col-md-7 tcenter text-right searcharea">
		<?php echo form_open('home/search',array('method'=>'get','class'=>'navbar-form','enctype'=>"multipart/form-data")); ?>
			<div class="input-group">
				<input type="text" class="form-control srch" placeholder="Search" name="q">
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		 <?php echo form_close(); ?>
	</div>
	<div class="col-xs-12 col-sm-1 col-md-1 tcenter">
		<img src="<?php echo base_url();?>assets/site/main/images/logos/national-emblem-india.png" style="width:62px;" title="Government of India" alt="Indian Embelam"/>
	</div>
</div>
</div>
</div>
<div class="naviarea">
<div class="container">
<div class="row">
	<nav class="navbar navbar-default">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar2">
			<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
		</button>
		<div class="collapse navbar-collapse" id="defaultNavbar2" style="padding-left:0;">
			<ul class="nav navbar-nav">
				<?php 
			//	$segment = $this->uri->segment(3);
				
				$user = $this->session->userdata('user_data');

				if($user == '')
				{
				?>
				<li class="navbar-item"><a href="<?php echo site_url();?>" class="active">Home</a></li>
				<li class="navbar-item aboutus">
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">About us<b class="caret"></b></a>
				<?php 
				$data['aboutus'] = $this->common_model->getFrontPage(1);
				if(!empty($data['aboutus'])){
				?>
				<ul class="dropdown-menu aboutusul">
				<?php 
				
					foreach($data['aboutus'] as $page){?>
					<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><?php echo $page['page_title'] ?></a></li>
					<?php } ?>
				
				</ul>
				<?php } ?>
				</li>
				<li class="navbar-item scheme">
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Schemes<b class="caret"></b></a>
				<?php 
				$data['schemes'] = $this->common_model->getFrontPage(2);
				if(!empty($data['schemes'])){
				?>
				<ul class="dropdown-menu schemeul">
				<?php 
				
					foreach($data['schemes'] as $page){?>
					<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><?php echo $page['page_title'] ?></a></li>
					<?php } ?>
				
				</ul>	
				<?php } ?>
				</li>
				<li class="navbar-item instruction">
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Instructions<b class="caret"></b></a>
				<?php 
				$data['instructions'] = $this->common_model->getFrontPage(3);
				if(!empty($data['instructions'])){
				?>
				<ul class="dropdown-menu instructionul">
				<?php 
				
					foreach($data['instructions'] as $page){?>
					<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><?php echo $page['page_title'] ?></a></li>
					<?php } ?>
				
				</ul>
				<?php } ?>				
				</li>
				<li><a href="<?php echo site_url();?>home/cities">Cities Brief</a></li>
				<li class="navbar-item university">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Universities List &nbsp; <b class="caret"></b></a>
					<ul class="dropdown-menu universityul">
					  <li ><a href="<?php echo site_url();?>home/stateuniversitiesList">State Universities</a></li>														         
					  <li><a href="<?php echo site_url();?>home/centraluniversitiesList">Central Universities</a></li>
					  <li><a href="<?php echo site_url();?>home/nitList">NIT's</a></li>
					  <li><a href="<?php echo site_url();?>home/ayushList">AYUSH</a></li>
					  <li><a href="<?php echo site_url();?>home/icarList">ICAR</a></li>
						<li><a href="<?php echo site_url();?>home/niftList">NIFT</a></li>
						 <li><a href="<?php echo site_url();?>home/guruList">Guru's</a></li>
					  </ul>
				</li>									
				<?php		
				}
				else
				{
				?>	
		
					<li><a href="<?php echo site_url();?>Sfs/dashboard" class="active">Home</a></li>										
				<?php	
				}
				?>
				<li class="navbar-item guidelines">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Guidelines&nbsp; <b class="caret"></b></a>
				<ul class="dropdown-menu guidelinesul">
										<?php 
					if($user != '')
					{
						?>

					<li><a href="<?php echo site_url();?>assets/site/docs/guidelines-for-students-after-admission.pdf">Guidelines After Admission</a></li>
						<?php
					}
					?>
					
				<li><a href="<?php echo site_url();?>assets/site/docs/applicant_guidelines_beforefilling.pdf">Guidelines Before Filling Form</a></li>      							           
				<li><a href="<?php echo site_url();?>assets/site/docs/Financial_Terms.pdf" download>Financial Terms of ICCR</a></li>
					  <li><a href="<?php echo site_url();?>assets/site/docs/Fitness.pdf" download>Physical Fitness Format</a></li>	
				</ul>
				</li>
				<li class="navbar-item faqs">
				<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">FAQ'S<b class="caret"></b></a>
				<?php
				$data['faqs'] = $this->common_model->getFrontPage(4);
				if(!empty($data['faqs'])){
				?>
				<ul class="dropdown-menu faqsul">
				<?php 
				
					foreach($data['faqs'] as $page){?>
					<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><?php echo $page['page_title'] ?></a></li>
					<?php } ?>
				
				</ul>
				<?php } ?>				
				</li>	
				 
				<li><a style="background:#F6751D;box-shadow:4px 1px 16px #fff inset;font-weight:500;" href="<?php echo site_url();?>assets/site/downloads/ICCR_UserManual.pdf">User Manual</a></li>
				<li class="last"><a href="<?php echo site_url();?>home/contactus">Contact Us</a></li>
			
				<?php 
				if($user == '')
				{
				?>
					
				<?php		
				}
				else
				{
				?>										
					
					
									
				<?php	
				}
				?>
			</ul>
			<ul class="nav navbar-nav pull-right">
				
				<?php
					$user = $this->session->userdata('user_data');
					if($user == '')
					{
					?>
				<li class="navbar-item registration">
				<a style = "background:#F6751D;box-shadow:4px 1px 16px #fff inset;font-weight:500; "href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" id = "reg"> Registration<b class="caret"></b></a>
				<ul class="dropdown-menu registrationul">
					<li><a href="<?php echo base_url();?>home/register" style="background: #F6751D;box-shadow: 4px 1px 16px #fff inset;font-weight: 500;">Applicant Registration</a></li>
					<li><a href="<?php echo base_url();?>home/alumniApplications" style="background: #F6751D;box-shadow: 4px 1px 16px #fff inset;font-weight: 500;">Alumini Registration</a></li>
				</ul>				
				</li>
					<li class="last"><a href="<?php echo base_url();?>#myLogin">Login</a></li>
					<?php		
					}
					else
					{
					?>
						<li><label class="username-info"><?php echo 'You are login as: '.$user['fname']; ?> </label></li>
						<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">User Profile &nbsp; <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url();?>Sfs/viewProfile">Profile</a></li>
							<li><a href="<?php echo base_url();?>Sfs/changepassword">Change Password</a></li>
							<li class="last"><a href="<?php echo base_url();?>user/logout">Logout</a></li></ul>							  			     
						</li>
					
						
						
					<?php	
					}
				?>
				
			</ul>
		</div>
	</nav>
</div>
</div>
</div>
</header>
<script>
		$(document).ready(function(){
			//==================for about us tab=======================
			$('.navbar-nav .aboutus > a').on('focus', function() {
			$('.aboutusul').show();
			});
			$('.aboutusul li:last-child').on('focusout', function() {
			$('.aboutusul').hide();
			});
			//==================for scheme tab=======================
			$('.navbar-nav .scheme > a').on('focus', function() {
			$('.schemeul').show();
			});
			$('.schemeul li:last-child').on('focusout', function() {
			$('.schemeul').hide();
			});
			//==================for instruction tab=======================
			$('.navbar-nav .instruction > a').on('focus', function() {
			$('.instructionul').show();
			});
			$('.instructionul li:last-child').on('focusout', function() {
			$('.instructionul').hide();
			});
			//==================for registration tab=======================
			$('.navbar-nav .registration > a').on('focus', function() {
			$('.registration').show();
			});
			$('.registrationul li:last-child').on('focusout', function() {
			$('.registration').hide();
			});
			//==================for university tab=======================
			$('.navbar-nav .university > a').on('focus', function() {
			$('.universityul').show();
			});
			$('.universityul li:last-child').on('focusout', function() {
			$('.universityul').hide();
			});
			//==================for faq tab=======================
			$('.navbar-nav .faqs > a').on('focus', function() {
			$('.faqsul').show();
			});
			$('.faqsul li:last-child').on('focusout', function() {
			$('.faqsul').hide();
			});			
			//==================for faq tab=======================
			$('.navbar-nav .guidelines > a').on('focus', function() {
			$('.guidelinesul').show();
			});
			$('.guidelinesul li:last-child').on('focusout', function() {
			$('.guidelinesul').hide();
			});
			
		});
		</script>
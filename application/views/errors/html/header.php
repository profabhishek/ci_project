<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="<?php echo base_url();?>assets/site/main/images/favicon.ico" type="image/vnd.microsoft.icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

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
		case "Student":		
		echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'applicant/logout";</script>';
		break;
		
	}
}
?>
<script src="<?php echo base_url();?>assets/site/main/js/jquery-3.7.1.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap-dialog.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/dropzone.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/flip.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/custom.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
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
							<a href=""><img src="<?php echo base_url();?>assets/site/main/images/mea-logo.png" alt="MEA Logo" /></a>
						</div>
						<div class="col-xs-12 col-sm-7 col-md-7 tcenter text-right searcharea">
							<form class="navbar-form" role="search">
								<div class="input-group">
									<input type="text" class="form-control srch" placeholder="Search" name="q">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-xs-12 col-sm-1 col-md-1 tcenter">
							<img src="<?php echo base_url();?>assets/site/main/images/logos/national-emblem-india.png" style="width:62px;" alt="Indian Embelam"/>
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
							  		$segment = $this->uri->segment(3);
							  		
							  		$user = $this->session->userdata('user_data');

						   			if($user == '')
						   			{
									?>
										<li><a href="<?php echo site_url();?>" class="active">Home</a></li>
									<?php		
									}
									else
									{
									?>										
										<li><a href="<?php echo site_url();?>applicant/dashboard" class="active">Home</a></li>										
									<?php	
									}
							  		?>
									
									<li><a href="<?php echo site_url();?>home/about">About us</a></li>
									<li><a href="<?php echo site_url();?>home/scheme">Schemes</a></li>
									<li><a href="<?php echo site_url();?>home/instructions">Instructions</a></li>
									<li><a href="<?php echo site_url();?>home/cities">Cities Brief</a></li>
									<li><a href="<?php echo site_url();?>home/universitieslist">Universities List</a></li>
									<li><a href="<?php echo site_url();?>home/applicant_guidlines">Guidelines</a></li>	
										
									<li ><a href="<?php echo site_url();?>home/contactus">Contact Us</a></li>
									<li class="last"><a href="<?php echo site_url();?>home/faqs">FAQ's</a></li>	
									<?php 
						   			if($user == '')
						   			{
									?>
										
									<?php		
									}
									else
									{
									?>										
										<li>
							  		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Forms &nbsp; <b class="caret"></b></a>
							  		<ul class="dropdown-menu">
								          <li ><a href="<?php echo site_url();?>assets/site/docs/Undertaking_from_students.pdf">Undertaking Form</a></li>														         
								          <li><a href="<?php echo site_url();?>assets/site/docs/Financial_Terms.pdf" download>Financial Terms of ICCR</a></li>
								          <li><a href="<?php echo site_url();?>assets/site/docs/Fitness.pdf" download>Physical Fitness Format</a></li>
								            <li><a href="<?php echo site_url();?>assets/site/docs/CityBrief.pdf" download>Cities Brief</a></li>
								           
								          <!--<li><a href="<?php echo site_url();?>mission/format">English Language Test Format</a></li>-->
								          </ul>
							  		</li>
										
														
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
											<li><a href="<?php echo base_url();?>home/register">Register</a></li>
											<li class="last"><a href="<?php echo base_url();?>">Login</a></li>
										<?php		
										}
										else
										{
										?>
											<li><label class="username-info"><?php echo 'You are login as: '.$user['fname']; ?> </label></li>
											<li class="last"><a href="<?php echo base_url();?>user/logout">Logout</a></li>
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
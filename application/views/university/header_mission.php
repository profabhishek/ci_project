<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="<?php echo base_url();?>assets/site/main/images/favicon.ico" type="image/vnd.microsoft.icon" />
<meta http-equiv="Cache-Control" content=" private, no-cache, no-store, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Indian Council for Cultural Relations</title>
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap-dialog.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/AdminLTE.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/mea-portal.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/datatables.min.css" />

<?php
echo '<script type="text/javascript">var baseURL="'.base_url().'";</script>';
echo '<script type="text/javascript">var Controller="'.$this->router->fetch_class().'";</script>';
echo '<script type="text/javascript">var Action="'.$this->router->fetch_method().'";</script>';
?>
<?php echo '<script type="text/javascript">var baseURL = "'.base_url().'";</script>'; ?>
<?php echo '<script type="text/javascript">var csrf_test_name = "'.$this->security->get_csrf_hash().'";</script>'; ?>
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
		case "University":
		echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'university/logout";</script>';
		break;	
		case "ICCR":
		echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'headquarter/logout";</script>';
		break;				
		case "Regional Office":	
		echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'regional/logout";</script>';
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
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/custom.js"></script>
<script  src="<?php echo base_url();?>assets/site/main/js/ckeditor/ckeditor.js"></script>
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
</head>

<body>
<div class="container-fluid"> 
	<div class="row">
		<header>
	
			<div class="topheader">
				<div class="container">
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
							<li><a href="" class="hindi">Sitemap</a></li>
						  </ul>
						</div>
					</nav>
				</div>
			</div>
			<div class="midheader">
				<div class="container">
					<div class="logo">
						<div class="col-xs-12 col-sm-4 col-md-4 tcenter nopadding logo-sec">
							<a href=""><img src="<?php echo base_url();?>assets/site/main/images/mea-logo.png" alt="MEA Logo" /></a>
						</div>
						<div class="col-xs-12 col-sm-7 col-md-7 tcenter text-right searcharea">
							<form class="navbar-form" role="search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search" name="q">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-xs-12 col-sm-1 col-md-1 tcenter">
							<img src="<?php echo base_url();?>assets/site/main/images/logos/national-emblem-india.png" style="width:62px;" alt="Indian Embelam" />
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
							<div class="collapse navbar-collapse" id="defaultNavbar2">
							  	<ul class="nav navbar-nav">
							  		<?php 
							  		$user = $this->session->userdata('user_data');
						   			if($user == '')
						   			{
									?>
										<li><a href="<?php echo site_url();?>university" class="active">Home</a></li>
									<?php		
									}
									else
									{
									?>
										<li><a href="<?php echo site_url();?>university/dashboard" class="active">Home</a></li>										
									<?php	
									}
							  		?>


								<li class="navbar-item aboutus">
								<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">About us<b class="caret"></b></a>
								<?php 
								
								$user_data = $this->session->userdata('user_data');
								$data['university'] = $user_data['university'];
								$universityId = $user_data['university'];
								$data['aboutus'] = $this->common_model->getUniversityFrontPage(1,$universityId);
								//print_r($data['aboutus']);die;
								if(!empty($data['aboutus'])){
								?>
								<ul class="dropdown-menu aboutusul">
								<?php 
								
									foreach($data['aboutus'] as $page){?>
									<li><a href="<?php echo site_url();?>university/page/<?php echo $page['page_slug']?>"><?php echo $page['page_title'] ?></a></li>
									<?php } ?>
								
								</ul>
								<?php } ?>
								</li>
								
							
								          <li><a href="<?php echo site_url();?>assets/site/docs/Timeline-AY-2026-27.pdf"target = "_blank">Timeline (2026-2027)</a></li>
										  <li><a href="<?php echo site_url();?>assets/site/docs/Guidelines_for_university.pdf"target = "_blank">University Guidelines</a></li>
										  <li class="last"><a href="<?php echo site_url();?>university/video">Gallery</a></li>
								          
										  
								
								
								<!----<li class="navbar-item aboutus">
								<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Programme<b class="caret"></b></a>
								<?php 
								$coursearray = array();
								//$programm = array();
								$data['programme'] = $this->common_model->getProgrammePage(1,$universityId);
							    
								
								if(!empty($data['programme'])){
								?>
								<ul class="dropdown-menu aboutusul">
								<?php 
								
									foreach($data['programme'] as $pagecr){
										//echo "<pre>";print_r($page);die;
										?>
									
									<li><a href="<?php echo site_url();?>university/page/<?php echo $pagecr['id']?>"><?php $programmes_name = $this->common_model->getProgrammeById($pagecr['programme_id']);echo $programmes_name[0]['name'] ?></a></li>
									<?php } ?>
								
								</ul>
								<?php } ?>
								</li>----->
								
								
								<!-----<li class="navbar-item aboutus">
								<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Course<b class="caret"></b></a>
								<?php 
							
								//$programm = array();
								$data['course'] = $this->common_model->getCoursePage(1,$universityId);
							    //echo "<pre>";print_r($data['course']);die;
								
								if(!empty($data['course'])){
								?>
								<ul class="dropdown-menu aboutusul">
								<?php 
								
									foreach($data['course'] as $pagecourse){
										//echo "<pre>";print_r($pagecourse);
										?>
									
									<li><a href="<?php echo site_url();?>university/page/<?php echo $pagecourse['id']?>"><?php $course_name = $this->common_model->getCourseById($pagecourse['course_id']);
									if($pagecourse['programme_id'] == 1){
										
										echo $course_name[0]['title'].'(UG)';
									}
									if($pagecourse['programme_id'] == 2){
										
										echo $course_name[0]['title'].'(PG)';
									}
									?>
									</a></li>
									<?php } ?>
								
								</ul>
								<?php } ?>
								</li>------>
								
								<!-----<li class="navbar-item aboutus">
								<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Branch/Stream<b class="caret"></b></a>
								<?php 
								$coursearray = array();
								//$programm = array();
								$data['stream'] = $this->common_model->getStreamPage(1,$universityId);
							    
								
								if(!empty($data['stream'])){
								?>
								<ul class="dropdown-menu aboutusul">
								<?php 
								
									foreach($data['stream'] as $pagestream){
										//echo "<pre>";print_r($pagestream);
										?>
									
									<li><a href="<?php echo site_url();?>university/page/<?php echo $pagestream['id']?>"><?php $stream_name = $this->common_model->getStreamById($pagestream['stream_id']);
									if($pagestream['programme_id'] == 1){
										echo $stream_name[0]['name'].'('.$pagestream['no_of_seat'].') - UG';
									
									}
									if($pagestream['programme_id'] == 2){
										echo $stream_name[0]['name'].'('.$pagestream['no_of_seat'].') - PG';
									
									}
									?>
									
									</a></li>
									<?php } ?>
								
								</ul>
								<?php } ?>
								</li>----->
							  		<!-----<li><a href="<?php echo site_url();?>university/instructions">University Portal</a></li>--->
							  		<!-----<li><a href="<?php echo site_url();?>assets/site/downloads/ICCR_UserManual_university.docx">User Manual</a></li>----->
							  		
							  	
							  		
							  		
							  		<!----<li>
							  		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Downloads &nbsp; <b class="caret"></b></a>
								  		<ul class="dropdown-menu">
								  			<li><a download href="<?php echo site_url();?>assets/site/docs/university_CheckList.pdf">university Check List</a></li>
									           <li class="last"><a  download href="<?php echo site_url();?>assets/site/docs/Undertaking_from_students.pdf">Undertaking Form of Scholar</a></li>
									           <li><a   href="<?php echo site_url();?>assets/site/docs/Financial_Terms.pdf" download>Financial Terms of ICCR</a></li>
								          <li><a  download href="<?php echo site_url();?>assets/site/docs/Englisth_Test_format.pdf">English Language Test Format</a></li>
									    </ul>							  			     
							  		</li>----->
							  		
							  	</ul>
							   	<ul class="nav navbar-nav pull-right">
							   		
							   		<?php
							   			$user = $this->session->userdata('user_data');
							   			if($user != '')
							   			{
										?>
										
											<li>
							  				<a href="#" class="dropdown-toggle" data-toggle="dropdown">university Profile <b class="caret"></b></a>
									  		<ul class="dropdown-menu">
										        <li><a href="<?php echo base_url();?>university/profile">Profile</a></li>
												<li><a href="<?php echo base_url();?>university/changepassword">Change Password</a></li>
												<li><a href="<?php echo base_url();?>university/logout">Logout</a></li>							
										    </ul>							  			     
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
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Indian Council For Cultural Relation</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url();?>assets/site/main/dist/css/AdminLTE.min.css"/>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/dist/css/skins/_all-skins.min.css">
  
  <!-- iCheck --> 
  <link rel="stylesheet" type="text/css" href="<?php echo site_url();?>assets/site/main/plugins/iCheck/flat/blue.css"/>
  <!-- Morris chart -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url();?>assets/site/main/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/plugins/datepicker/datepicker3.css">
   <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/datetimepicker.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap-dialog.min.css" />

<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/dropzone.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/datatables.min.css" />
<?php
echo '<script type="text/javascript">var baseURL="'.base_url().'";</script>';
echo '<script type="text/javascript">var Controller="'.$this->router->fetch_class().'";</script>';
echo '<script type="text/javascript">var Action="'.$this->router->fetch_method().'";</script>';
?>
<?php echo '<script type="text/javascript">var baseURL = "'.base_url().'";</script>'; ?>
<?php echo '<script type="text/javascript">var csrf_test_name = "'.$this->security->get_csrf_hash().'";</script>'; ?>
<script src="<?php echo base_url();?>assets/site/main/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap-dialog.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/jquery-ui.js"></script>
  <script  src="<?php echo base_url();?>assets/site/main/js/ckeditor/ckeditor.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
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
					BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: msgType ,message: isMessage ,buttons: [{label: 'Submit',action: function(dialog) {location.href=redirect;}}]}); 	
				break;
				case "success":
				BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: msgType ,message: isMessage ,buttons: [{label: 'Submit',action: function(dialog) {location.href=redirect;}}]}); 	
				break;
				case "warning":
				BootstrapDialog.show({type: BootstrapDialog.TYPE_WARNING ,title: msgType ,message: isMessage ,buttons: [{label: 'Submit',action: function(dialog) {location.href=redirect;}}]}); 	
				break;
			}
			
		}		
		
	});

</script>
<style type="text/css">
	.mrq{
		 color: white;
    font-weight: bold;
    margin: 1% auto;
    width: 74%;
	}
</style>
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url();?>admin" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>ICCR</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>ICCR</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
		<marquee class="mrq">Welcome Super Admin to Indian Council For Cultural Relation Scholarship Portal</marquee>	
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo site_url();?>assets/site/main/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Super Admin</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo site_url();?>assets/site/main/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  Super Admin - ICCR                  
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">                
                <div class="pull-right">
                  <a href="<?php echo site_url();?>admin/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        <!--  <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>
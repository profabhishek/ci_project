<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="<?php echo base_url();?>assets/site/main/images/favicon.ico" type="image/vnd.microsoft.icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>National Council for Cultural Relations</title>
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap-dialog.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/AdminLTE.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/mea-portal.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/jquery-ui.css" />

<?php
echo '<script type="text/javascript">var baseURL="'.base_url().'";</script>';
echo '<script type="text/javascript">var Controller="'.$this->router->fetch_class().'";</script>';
echo '<script type="text/javascript">var Action="'.$this->router->fetch_method().'";</script>';
?>
<?php echo '<script type="text/javascript">var baseURL = "'.base_url().'";</script>'; ?>
<?php echo '<script type="text/javascript">var csrf_test_name = "'.$this->security->get_csrf_hash().'";</script>'; ?>

<script src="<?php echo base_url();?>assets/site/main/js/jquery-3.7.1.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap-dialog.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/dropzone.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/jquery-ui.js"></script>
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
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
	header{		
	    background-repeat: no-repeat;
	    background-size: 100% 100%;
	    height: 128px;
	    padding: 16px;
	    height: 145px;
	}
	.midheader {
	    padding: 0;
	    margin: 0;
	}
	hr.line{
		margin: 0;
	}
</style>
</head>

<body>
<div class="container-fluid"> 
	<div class="row">
		<header>			
			<div class="midheader">
				<div class="container">
					<div class="logo">
						<div class="col-xs-12 col-sm-4 col-md-4 tcenter nopadding logo-sec">
							<a href=""><img src="<?php echo base_url();?>assets/site/main/images/mea-logo.png" alt="MEA Logo" /></a>
						</div>
						<div class="col-xs-12 col-sm-7 col-md-7 tcenter text-right searcharea">
							
						</div>
						<div class="col-xs-12 col-sm-1 col-md-1 tcenter">
							<img src="<?php echo base_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam" />
						</div>
					</div>
				</div>
			</div>			
		</header>
		<hr class="line">
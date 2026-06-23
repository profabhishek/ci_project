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
<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/datatables.min.css" />-->
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

</script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
	

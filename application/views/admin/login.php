<!--Author: W3layoutsAuthor URL: http://w3layouts.comLicense: Creative Commons Attribution 3.0 UnportedLicense URL: http://creativecommons.org/licenses/by/3.0/-->
<!DOCTYPE HTML>
<html>
<head>
<title>Realha.com</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?php echo  base_url().'assets/admin/' ?>css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo  base_url().'assets/admin/' ?>css/style.css" rel='stylesheet' type='text/css' />
<link href="<?php echo  base_url().'assets/admin/' ?>css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<script src="<?php echo  base_url().'assets/admin/' ?>js/jquery.min.js"></script>
<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<!---//webfonts--->
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo  base_url().'assets/admin/' ?>js/bootstrap.min.js"></script>
</head>
<body id="login">

<div class="login-logo"> <a href="javascript:void(0)"><img src="<?php echo  base_url().'assets/admin/' ?>images/logo.png" alt=""/></a> </div>
<div class="login-b">
<h2 class="form-heading">login</h2>
<div class="app-cam">
  <form action="<?php echo  base_url()?>admin" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <input type="text" class="text" name="email" value="E-mail address" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'E-mail address';}">
    <input type="password" name="password" value="Password" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Password';}">
    <div class="submit">
      <input type="submit" onClick="myFunction()" value="Login">
    </div>
  
  </form>
</div>
</div>
<div class="copy_layout login">

  <p style="color:#333333;">&copy; 2016 realha.com All rights reserved. | Powered By <a href="http://experienceit.sg//" target="_blank"><font color="#333333">EXperienceIT Realty</font></a> </p>
</div>
</body>
</html>

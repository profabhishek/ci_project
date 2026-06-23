<?php define('site_url','https://a2ascholarships.iccr.gov.in/'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="<?php echo site_url;?>assets/site/main/images/favicon.ico" type="image/vnd.microsoft.icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Indian Council for Cultural Relations</title>
<link rel="stylesheet" href="<?php echo site_url;?>assets/site/main/css/bootstrap-dialog.min.css" />
<link rel="stylesheet" href="<?php echo site_url;?>assets/site/main/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo site_url;?>assets/site/main/css/datatables.min.css" />
<link rel="stylesheet" href="<?php echo site_url;?>assets/site/main/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo site_url;?>assets/site/main/css/AdminLTE.min.css" />
<link rel="stylesheet" href="<?php echo site_url;?>assets/site/main/css/mea-portal.css" />
<link rel="stylesheet" href="<?php echo site_url;?>assets/site/main/css/dropzone.css" />
<link rel="stylesheet" href="<?php echo site_url;?>assets/site/main/css/jquery-ui.css" />
<script src="<?php echo site_url;?>assets/site/main/js/jquery-3.7.1.min.js"></script>
<script src="<?php echo site_url;?>assets/site/main/js/bootstrap.min.js"></script>
<script src="<?php echo site_url;?>assets/site/main/js/bootstrap-dialog.min.js"></script>
<script src="<?php echo site_url;?>assets/site/main/js/datatables.min.js"></script>
<script src="<?php echo site_url;?>assets/site/main/js/dropzone.js"></script>
<script src="<?php echo site_url;?>assets/site/main/js/jquery-ui.js"></script>
<script src="<?php echo site_url;?>assets/site/main/js/flip.js"></script>
<script src="<?php echo site_url;?>assets/site/main/js/custom.js"></script>

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
    .front,.back {
    }
    .front {
    }
    .back {       
    }
    .sn {
		color: red;
    	font-size: 93px;
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
							<!--<li class="updationdate tcenter"><?php echo date('d M, Y | h:i A').' IST';?></li>-->
						  </ul>
						  <ul class="skipcontent tcenter nav navbar-nav navbar-right">
							<li><a href="<?php echo site_url;?>">Home</a></li>
							<li><a href="#meacontent">Skip to main content</a></li>							
							<li class="nobg"><a id="decfont" href="">A<sup>-</sup></a></li>
							<li class="nobg"><a id="norfont" href="">A</a></li>
							<li class="nobg"><a id="incfont" href="#">A<sup>+</sup></a></li>							
							<li><a href="<?php echo site_url;?>seo/sitemap" class="hindi">Sitemap</a></li>
						  </ul>
						</div>
					</nav>
				</div>
			</div>
			<div class="midheader">
				<div class="container" >
					<div class="logo">
						<div class="col-xs-12 col-sm-4 col-md-4 tcenter nopadding logo-sec">
							<a href=""><img src="<?php echo site_url;?>assets/site/main/images/mea-logo.png" alt="MEA Logo" /></a>
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
							<img src="<?php echo site_url;?>assets/site/main/images/logos/national-emblem-india.png" style="width:62px;" alt="Indian Embelam"/>
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
									<li><a href="<?php echo site_url;?>" class="active">Home</a></li>
									<li><a href="<?php echo site_url;?>home/about">About us</a></li>
									<li><a href="<?php echo site_url;?>home/scheme">Schemes</a></li>
									<li><a href="<?php echo site_url;?>home/instructions">Instructions</a></li>
									<li><a href="<?php echo site_url;?>home/cities">Cities Brief</a></li>
									<li><a href="<?php echo site_url;?>home/universitieslist">Universities List</a></li>
									<li><a href="<?php echo site_url;?>home/applicant_guidlines">Guidelines</a></li>	
									<li><a href="<?php echo site_url;?>home/contactus">Contact Us</a></li>
									<li class="last"><a href="<?php echo site_url;?>home/faqs">FAQ's</a></li>	
							  	</ul>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</header>
<section class="meacontent">
	<div  class="container" style="min-height: 410px; text-align: center; padding-top: 27px; background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
	<br/>
		<span class="glyphicon glyphicon-warning-sign sn"></span>
		<br/>
		<h1>Whoop's Something Went Wrong!</h1>
		<h2>Sorry We Can't get information right now. Please try again later.</h2>

	</div>
</section>	
<div class="clearfix"> </div>
		<footer>
			<section class="footerarea">
				<div class="container">
				
					<ul class="flink text-center">
						<li><a href="<?php echo site_url;?>home/termsandconditions">Terms &amp; Conditions</a></li>
						<li><a href="<?php echo site_url;?>home/privacy">Privacy Policy</a></li>
						<li><a href="<?php echo site_url;?>home/copyright">Copyright Policy</a></li>
						<li><a href="<?php echo site_url;?>home/hyperlink">Hyperlinking Policy</a></li>
						<li><a href="<?php echo site_url;?>home/disclaimer">Disclaimer</a></li>
						<li><a href="<?php echo site_url;?>home/help">Help</a></li>
						<li class="visitor-count"><a href="">Visitors : 250546</a></li>
					</ul>
					<div class="copyright text-center">&copy; Content Owned by Indian Council for Cultural Relations, Government of India. All Rights Reserved.</div>
				</div>
			</section>
		</footer>
	</div>
</div>
<!-- Upload Divs -->
 
  <script type="text/javascript">
     $(document).ready(function() {
      $('#incfont').click(function(){
   		curSize = parseInt($('body').css('font-size')) + 1;
          if(curSize<=20)
   			$('body').css('font-size', curSize);
    	}); 
		$('#decfont').click(function(){
       	 curSize= parseInt($('body').css('font-size')) - 1;
            if(curSize>=10)
       	 $('body').css('font-size', curSize);
        });
       $('#norfont').click(function(){
        curSize1= parseInt($('body').css('font-size', ''))  ;
        $('body').css('font-size', curSize1);
        });
    });
</script>
</body>
</html>

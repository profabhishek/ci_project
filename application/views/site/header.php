<!doctype html>
<?php error_reporting(0);
$this->load->helper('a2a_i18n');
$this->config->load('a2a_site', TRUE);
$a2aLangs = $this->config->item('a2a_languages', 'a2a_site');
$a2aLang  = a2a_lang_code();
?>
<html lang="<?php echo a2a_html_lang(); ?>">
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="<?php echo base_url();?>assets/site/main/images/favicon.ico" type="image/vnd.microsoft.icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#0a1f44">
<meta name="title" content="Indian Council for Cultural Relations">
<meta name="description" content="The Indian Council for Cultural Relations (ICCR) was founded in 1950 by Maulana Abul Kalam Azad, independent India’s first Education Minister. Its objectives are to actively participate in the formulation and implementation of policies and programs pertaining to India’s external cultural relations">
<meta name="keywords" content="Indian Council for Cultural Relations,ICCR">
<title><?php echo a2a_e('a2a_page_title'); ?></title>
<link rel="preload" as="image" href="<?php echo base_url();?>assets/site/main/images/mea-logo.webp" type="image/webp">

<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap-dialog.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/datatables.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/AdminLTE.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/mea-portal.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/dropzone.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/jquery-ui.css" />
<!-- New navy theme for header, footer and login. Must stay AFTER mea-portal.css. -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/a2a-modern.css?v=20261009" />
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
case "University":
echo '<script type="text/javascript">var redirectLink = "'.site_url() . 'university/logout";</script>';
break;
}
}
?>

<script src="<?php echo base_url();?>assets/site/main/js/jquery-3.7.1.min.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap.min.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootstrap-dialog.min.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/datatables.min.js" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/dropzone.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/flip.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/bootbox/bootbox.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/custom.js?v=20261009" ></script>
<script src="<?php echo base_url();?>assets/site/main/js/owl.carousel.js"></script>
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
<style type="text/css">
.card { width: 100px; height: 100px; margin: 20px; display: inline-block; }
.visitor { display: flex; justify-content: center; align-items: center; color: #000065; font-weight: 600; }
</style>
</head>

<body>
<noscript>
<div class="js_enable">This page is trying to run JavaScript and your browser either does not support JavaScript or you may have turned-off JavaScript. If you have disabled JavaScript on your computer, please turn on JavaScript, to have proper access to this page.</div>
</noscript>
<div class="container-fluid" <?php if(isset($include) && $include == true){ echo 'style="display:none;"'; } ?>>

<div class="row posi-relas" style="position:relative;">
<?php
	$user = $this->session->userdata('user_data');
	$docs = site_url().'assets/site/docs/';
	// Menu managed in /adminpanel/nav (table iccr_nav_links). NULL = use the built-in menu below.
	$this->load->helper('a2a_nav');
	$a2aNav = a2a_nav_load($user);
?>
<header class="a2a-header" role="banner">

	<!-- 1. Utility bar: date, accessibility tools -->
	<div class="a2a-utility">
		<div class="a2a-wrap">
			<div class="a2a-utility__date">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
				<span><?php
				date_default_timezone_set('Asia/Calcutta');
				echo date('d M, Y | h:i A').' IST';
				?></span>
			</div>
			<ul class="a2a-utility__links">
				<li><a class="a2a-skip" href="#a2a-main"><?php echo a2a_e('a2a_skip'); ?></a></li>
				<li><a href="<?php echo site_url();?>"><?php echo a2a_e('a2a_home'); ?></a></li>
				<li><a href="<?php echo site_url();?>home/contactus"><?php echo a2a_e('a2a_contact'); ?></a></li>
				<li>
					<span class="a2a-fontsize" role="group" aria-label="<?php echo a2a_e('a2a_text_size'); ?>">
						<button type="button" id="decfont" title="<?php echo a2a_e('a2a_text_smaller'); ?>">A<sup>-</sup><span class="sr-only"> <?php echo a2a_e('a2a_text_smaller'); ?></span></button>
						<button type="button" id="norfont" title="<?php echo a2a_e('a2a_text_normal'); ?>">A<span class="sr-only"> <?php echo a2a_e('a2a_text_normal'); ?></span></button>
						<button type="button" id="incfont" title="<?php echo a2a_e('a2a_text_larger'); ?>">A<sup>+</sup><span class="sr-only"> <?php echo a2a_e('a2a_text_larger'); ?></span></button>
					</span>
				</li>
				<li><span class="a2a-langswitch" role="group" aria-label="<?php echo a2a_e('a2a_language'); ?>">
					<i class="fa fa-language" aria-hidden="true"></i>
					<?php $a2aHere = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
					foreach ($a2aLangs as $lc => $ld) {
						if ($lc === $a2aLang) { ?>
						<span class="is-on" lang="<?php echo $ld[2]; ?>" aria-current="true"><?php echo $ld[1]; ?></span>
					<?php } else { ?>
						<a lang="<?php echo $ld[2]; ?>" hreflang="<?php echo $ld[2]; ?>" href="<?php echo site_url('lang/set/'.$lc).'?r='.rawurlencode($a2aHere); ?>"><?php echo $ld[1]; ?></a>
					<?php } } ?>
				</span></li>
				<li><a href="<?php echo site_url();?>seo/sitemap"><?php echo a2a_e('a2a_sitemap'); ?></a></li>
			</ul>
		</div>
	</div>

	<!-- 2. Brand bar: logo, search, emblem -->
	<div class="a2a-brand">
		<div class="a2a-wrap">
			<a class="a2a-brand__logo" href="<?php echo site_url();?>" title="Admission 2 Alumni (A2A) - Indian Council for Cultural Relations, Government of India">
				<picture>
					<source srcset="<?php echo base_url();?>assets/site/main/images/mea-logo.webp" type="image/webp">
					<img src="<?php echo base_url();?>assets/site/main/images/mea-logo.png" width="369" height="71" fetchpriority="high" alt="Admission 2 Alumni (A2A) - Indian Council for Cultural Relations" />
				</picture>
			</a>
			<div class="a2a-brand__right">
				<?php echo form_open('home/search',array('method'=>'get','class'=>'a2a-search','role'=>'search')); ?>
					<label for="a2aSearch" class="sr-only"><?php echo a2a_e('a2a_search_label'); ?></label>
					<i class="fa fa-search" aria-hidden="true"></i>
					<input type="search" id="a2aSearch" class="srch" placeholder="<?php echo a2a_e('a2a_search_ph'); ?>" title="<?php echo a2a_e('a2a_search_label'); ?>" name="q" autocomplete="off" maxlength="100">
					<button type="submit" aria-label="<?php echo a2a_e('a2a_search_go'); ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
				<?php echo form_close(); ?>
				<picture>
					<source srcset="<?php echo base_url();?>assets/site/main/images/logos/national-emblem-india-sm.webp" type="image/webp">
					<img class="a2a-brand__emblem" src="<?php echo base_url();?>assets/site/main/images/logos/national-emblem-india-sm.png" width="100" height="160" title="Government of India" alt="National Emblem of India"/>
				</picture>
			</div>
		</div>
	</div>

	<!-- 3. Primary navigation -->
	<nav class="a2a-nav" aria-label="Main navigation">
		<div class="a2a-wrap">
			<button type="button" class="a2a-nav__toggle collapsed" data-toggle="collapse" data-target="#a2aNavCollapse" aria-controls="a2aNavCollapse" aria-expanded="false">
				<i class="fa fa-bars" aria-hidden="true"></i> <?php echo a2a_e('a2a_menu'); ?>
			</button>

			<div class="collapse a2a-nav__collapse" id="a2aNavCollapse">
				<ul class="a2a-menu">
					<?php if ($a2aNav !== NULL) { a2a_nav_render_main($a2aNav['main'], $user); } else { ?>
					<?php if($user == '') { ?>
					<li><a href="<?php echo site_url();?>" class="active"><?php echo a2a_e('a2a_home'); ?></a></li>

					<?php $data['aboutus'] = $this->common_model->getFrontPage(1); ?>
					<li class="dropdown navbar-item aboutus">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo a2a_e('a2a_about'); ?> <i class="fa fa-angle-down a2a-caret" aria-hidden="true"></i></a>
						<?php if(!empty($data['aboutus'])){ ?>
						<ul class="dropdown-menu aboutusul">
							<?php foreach($data['aboutus'] as $page){ ?>
							<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><span class="a2a-ico"><i class="fa fa-info" aria-hidden="true"></i></span><span><?php echo $page['page_title'] ?></span></a></li>
							<?php } ?>
						</ul>
						<?php } ?>
					</li>

					<li class="dropdown navbar-item scheme">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo a2a_e('a2a_schemes'); ?> <i class="fa fa-angle-down a2a-caret" aria-hidden="true"></i></a>
						<ul class="dropdown-menu schemeul">
							<li><a href="<?php echo site_url();?>home/getAllSchemeList"><span class="a2a-ico"><i class="fa fa-list-ul" aria-hidden="true"></i></span><span><?php echo a2a_e('a2a_scheme_list'); ?></span></a></li>
						</ul>
					</li>

					<?php $data['instructions'] = $this->common_model->getFrontPage(3); ?>
					<li class="dropdown navbar-item instruction">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo a2a_e('a2a_instructions'); ?> <i class="fa fa-angle-down a2a-caret" aria-hidden="true"></i></a>
						<?php if(!empty($data['instructions'])){ ?>
						<ul class="dropdown-menu instructionul">
							<?php foreach($data['instructions'] as $page){ ?>
							<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><span class="a2a-ico"><i class="fa fa-book" aria-hidden="true"></i></span><span><?php echo $page['page_title'] ?></span></a></li>
							<?php } ?>
						</ul>
						<?php } ?>
					</li>

					<li><a href="<?php echo site_url();?>home/cities"><?php echo a2a_e('a2a_cities'); ?></a></li>

					<li class="dropdown navbar-item university">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo a2a_e('a2a_universities'); ?> <i class="fa fa-angle-down a2a-caret" aria-hidden="true"></i></a>
						<ul class="dropdown-menu universityul">
							<li><a href="<?php echo $docs;?>universities.pdf" target="_blank" rel="noopener"><span class="a2a-ico"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span><span>Universities<span class="a2a-meta">PDF, opens in a new tab</span></span></a></li>
							<li><a href="<?php echo $docs;?>Universities_Details.xlsx" target="_blank" rel="noopener"><span class="a2a-ico"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span><span>Universities Details<span class="a2a-meta">Excel file</span></span></a></li>
						</ul>
					</li>
					<?php } else { ?>
						<?php if($user['user_type'] == 8){ ?>
						<li><a href="<?php echo site_url();?>university/dashboard" class="active">Home</a></li>
						<?php } else { ?>
						<li><a href="<?php echo site_url();?>applicant/dashboard" class="active">Home</a></li>
						<?php } ?>
					<?php } ?>

					<li class="dropdown navbar-item guidelines">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo a2a_e('a2a_guidelines'); ?> <i class="fa fa-angle-down a2a-caret" aria-hidden="true"></i></a>
						<ul class="dropdown-menu guidelinesul">
							<li><a title="Guidelines Before Filling Form" href="<?php echo $docs;?>Policy_Guidelines.pdf" target="_blank" rel="noopener"><span class="a2a-ico"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span><span>Scholarship Guidelines (Before Filling Form)<span class="a2a-meta">PDF &middot; 35.1 KB</span></span></a></li>
							<li><a title="Physical Fitness Format" href="<?php echo $docs;?>Fitness.pdf" target="_blank" rel="noopener"><span class="a2a-ico"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span><span>Physical Fitness Format<span class="a2a-meta">PDF &middot; 234 KB</span></span></a></li>
							<li><a title="Timelines" href="<?php echo $docs;?>Timeline-AY-2026-27.pdf" target="_blank" rel="noopener"><span class="a2a-ico"><i class="fa fa-calendar" aria-hidden="true"></i></span><span>Timeline (2026-2027)<span class="a2a-meta">PDF &middot; 234 KB</span></span></a></li>
						</ul>
					</li>

					<?php $data['faqs'] = $this->common_model->getFrontPage(4); ?>
					<li class="dropdown navbar-item faqs">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo a2a_e('a2a_faqs'); ?> <i class="fa fa-angle-down a2a-caret" aria-hidden="true"></i></a>
						<?php if(!empty($data['faqs'])){ ?>
						<ul class="dropdown-menu faqsul">
							<?php foreach($data['faqs'] as $page){ ?>
							<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><span class="a2a-ico"><i class="fa fa-question" aria-hidden="true"></i></span><span><?php echo $page['page_title'] ?></span></a></li>
							<?php } ?>
						</ul>
						<?php } ?>
					</li>

					<li><a href="<?php echo site_url();?>home/contactus"><?php echo a2a_e('a2a_contact'); ?></a></li>
					<?php } /* end built-in menu */ ?>
				</ul>

				<ul class="a2a-actions">
					<?php if ($a2aNav !== NULL) { a2a_nav_render_actions($a2aNav['action'], $user); } else { ?>
					<li><a class="a2a-btn a2a-btn--ghost" href="http://a2ascholarships.iccr.gov.in/alumni_app"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php echo a2a_e('a2a_alumni'); ?></a></li>
					<?php } ?>
					<?php if($user == '') { ?>
						<?php /* Registration dropdown was empty (all items commented out), so it is hidden.
						         To reopen registration, add:
						         <li><a class="a2a-btn a2a-btn--ghost" href="<?php echo base_url();?>home/register">Register</a></li> */ ?>
						<li><a class="a2a-btn a2a-btn--gold" href="<?php echo base_url();?>#myLogin"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo a2a_e('a2a_login'); ?></a></li>
					<?php } else {
						$fname = isset($user['fname']) ? $user['fname'] : '';
						$initial = $fname !== '' ? strtoupper(substr($fname, 0, 1)) : '?';
					?>
						<li class="dropdown a2a-user">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<span class="a2a-avatar" aria-hidden="true"><?php echo htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?></span>
								<span class="a2a-user__name"><?php echo htmlspecialchars($fname, ENT_QUOTES, 'UTF-8'); ?></span>
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</a>
							<ul class="dropdown-menu">
								<li class="dropdown-header">Signed in as <strong><?php echo htmlspecialchars($fname, ENT_QUOTES, 'UTF-8'); ?></strong></li>
								<li><a href="<?php echo base_url();?>applicant/viewProfile"><span class="a2a-ico"><i class="fa fa-user" aria-hidden="true"></i></span><span>Profile</span></a></li>
								<li><a href="<?php echo base_url();?>applicant/changepassword"><span class="a2a-ico"><i class="fa fa-key" aria-hidden="true"></i></span><span>Change Password</span></a></li>
								<li><a href="<?php echo base_url();?>user/logout"><span class="a2a-ico"><i class="fa fa-sign-out" aria-hidden="true"></i></span><span>Logout</span></a></li>
							</ul>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>
</header>
<main id="a2a-main" class="a2a-main" tabindex="-1">
<script>
	// Keep the dropdown caret state and aria-expanded in sync (Bootstrap 3 handles open/close).
	$(function(){
		$('.a2a-menu, .a2a-actions').on('shown.bs.dropdown hidden.bs.dropdown', '.dropdown', function(e){
			$(this).children('.dropdown-toggle').attr('aria-expanded', e.type === 'shown');
		});
		$('#a2aNavCollapse').on('shown.bs.collapse hidden.bs.collapse', function(e){
			$('.a2a-nav__toggle').attr('aria-expanded', e.type === 'shown');
		});
	});
</script>

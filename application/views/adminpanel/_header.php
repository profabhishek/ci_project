<?php defined('BASEPATH') OR exit('No direct script access allowed');
$titles = array('dashboard' => 'Dashboard', 'announcements' => 'Announcements', 'nav' => 'Header menu', 'students' => 'Students',
                'missions' => 'Missions', 'universities' => 'Universities', 'accounts' => 'Accounts', 'audit' => 'Admin audit log', 'general_audit' => 'General audit log',
                'trash' => 'Trash', 'logins' => 'Sign-in attempts');
$page_title = isset($titles[$active]) ? $titles[$active] : 'Admin';
$name = isset($admin['fname']) ? $admin['fname'] : 'Admin';
$menu = array(
    array('sec' => 'Overview'),
    array('key' => 'dashboard', 'url' => 'adminpanel', 'icon' => 'fa-th-large', 'label' => 'Dashboard'),
    array('sec' => 'Website'),
    array('key' => 'announcements', 'url' => 'adminpanel/announcements', 'icon' => 'fa-bullhorn', 'label' => 'Announcements'),
    array('key' => 'nav', 'url' => 'adminpanel/nav', 'icon' => 'fa-sitemap', 'label' => 'Header menu'),
    array('sec' => 'Scholarship data'),
    array('key' => 'students', 'url' => 'adminpanel/students', 'icon' => 'fa-users', 'label' => 'Students'),
    array('key' => 'missions', 'url' => 'adminpanel/entity/missions', 'icon' => 'fa-flag', 'label' => 'Missions'),
    array('key' => 'universities', 'url' => 'adminpanel/entity/universities', 'icon' => 'fa-university', 'label' => 'Universities'),
    array('sec' => 'Security'),
    array('key' => 'accounts', 'url' => 'adminpanel/accounts', 'icon' => 'fa-key', 'label' => 'Accounts'),
    array('key' => 'audit', 'url' => 'adminpanel/audit', 'icon' => 'fa-history', 'label' => 'Admin audit log'),
    array('key' => 'general_audit', 'url' => 'adminpanel/general_audit', 'icon' => 'fa-list-alt', 'label' => 'General audit log'),
    array('key' => 'logins', 'url' => 'adminpanel/logins', 'icon' => 'fa-shield', 'label' => 'Sign-in attempts'),
    array('key' => 'trash', 'url' => 'adminpanel/trash', 'icon' => 'fa-trash-o', 'label' => 'Trash'),
    array('sec' => 'Other'),
    array('key' => 'classic', 'url' => 'admin/dashboard', 'icon' => 'fa-columns', 'label' => 'Classic admin (reports)'),
    array('key' => 'site', 'url' => '', 'icon' => 'fa-globe', 'label' => 'View website'),
);
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title><?php echo html_escape($page_title); ?> · A2A Admin</title>
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/site/main/images/favicon.ico">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/main/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/main/css/adminpanel.css">
<script>var baseURL = <?php echo json_encode(base_url()); ?>, isLogin = 'true', redirectLink = <?php echo json_encode(site_url('adminlogin/logout')); ?>;</script>
<script src="<?php echo base_url(); ?>assets/site/main/js/a2a-session.js?v=1" defer></script>
</head>
<body class="ap">
<a class="sr-only" href="#ap-main">Skip to content</a>
<div class="ap-shell">
	<aside class="ap-side" id="apSide" aria-label="Admin menu">
		<div class="ap-brand">
			<span class="ap-brand__mark">A2A</span>
			<span><b>Admin Panel</b><small>ICCR Scholarships</small></span>
		</div>
		<ul class="ap-menu">
			<?php foreach ($menu as $m) { if (isset($m['sec'])) { ?>
				<li class="ap-sec"><?php echo html_escape($m['sec']); ?></li>
			<?php } else { ?>
				<li><a href="<?php echo site_url($m['url']); ?>" class="<?php echo $active === $m['key'] ? 'on' : ''; ?>"<?php echo $active === $m['key'] ? ' aria-current="page"' : ''; ?>><i class="fa <?php echo $m['icon']; ?>" aria-hidden="true"></i><?php echo html_escape($m['label']); ?></a></li>
			<?php } } ?>
		</ul>
		<div class="ap-side__foot">Every change is recorded in the admin and general audit logs.</div>
	</aside>

	<div class="ap-main">
		<header class="ap-top">
			<div style="display:flex;align-items:center;gap:12px">
				<button type="button" class="btn btn-sm ap-menu-btn" onclick="document.getElementById('apSide').classList.toggle('open')" aria-label="Open menu"><i class="fa fa-bars"></i></button>
				<div>
					<div class="ap-crumb">A2A Admin</div>
					<h1><?php echo html_escape($page_title); ?></h1>
				</div>
			</div>
			<div class="ap-user">
				<span class="muted" style="text-align:right;line-height:1.25"><b style="color:var(--ink)"><?php echo html_escape($name); ?></b><br><small><?php echo html_escape(isset($admin['email']) ? $admin['email'] : ''); ?></small></span>
				<span class="ap-avatar" aria-hidden="true"><?php echo html_escape(strtoupper(substr($name, 0, 1))); ?></span>
				<a class="btn btn-sm" href="<?php echo site_url('adminlogin/logout'); ?>"><i class="fa fa-sign-out"></i> Sign out</a>
			</div>
		</header>

		<main class="ap-content" id="ap-main">
			<?php if (empty($setup['nav']) || empty($setup['audit'])) { ?>
			<div class="ap-alert ap-alert--warn"><i class="fa fa-exclamation-triangle"></i>
				<div><b>Setup needed.</b> Run <span class="mono">application/sql/adminpanel_setup_local.sql</span> once on this database to create the
				<?php echo empty($setup['nav']) ? '<span class="mono">iccr_nav_links</span>' : ''; ?>
				<?php echo empty($setup['audit']) ? '<span class="mono">iccr_admin_audit_log</span>' : ''; ?> table(s).
				Until then the header menu and the audit log do not work.</div></div>
			<?php } ?>
			<?php if (isset($setup['general_audit']) && !$setup['general_audit']) { ?>
			<div class="ap-alert ap-alert--warn"><i class="fa fa-exclamation-triangle"></i>
				<div><b>General audit log not set up.</b> Run <span class="mono">application/sql/general_audit_log_setup.sql</span> once on this database.
				Until then changes are recorded only in the Admin audit log.</div></div>
			<?php } ?>
			<?php if (isset($setup['security']) && !$setup['security']) { ?>
			<div class="ap-alert ap-alert--warn"><i class="fa fa-exclamation-triangle"></i>
				<div><b>Security update not finished.</b> Run <span class="mono">application/sql/adminpanel_security_local.sql</span> once on this database.
				Until then sign-in lockout, Trash and the announcement draft step cannot be saved.</div></div>
			<?php } ?>
			<?php if (!empty($trashed)) { ?>
			<div class="ap-alert ap-alert--warn"><i class="fa fa-trash-o"></i>
				<div><b>This record is in Trash.</b> It is switched off. <a href="<?php echo site_url('adminpanel/trash'); ?>">Open Trash</a> to restore it.</div></div>
			<?php } ?>
			<?php $ft = $this->session->flashdata('ap_type'); $fm = $this->session->flashdata('ap_msg');
			if ($fm) {
				$icons = array('success' => 'fa-check-circle', 'error' => 'fa-exclamation-circle', 'info' => 'fa-info-circle'); ?>
			<div class="ap-alert ap-alert--<?php echo html_escape($ft); ?>" role="<?php echo $ft === 'error' ? 'alert' : 'status'; ?>">
				<i class="fa <?php echo isset($icons[$ft]) ? $icons[$ft] : 'fa-info-circle'; ?>"></i><div><?php echo html_escape($fm); ?></div>
			</div>
			<?php } ?>

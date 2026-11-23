<?php
// Contact Us. Details come from application/config/a2a_site.php (one place to update).
if (!function_exists('a2a_t')) { $this->load->helper('a2a_i18n'); }
$this->config->load('a2a_site', TRUE);
$cc = $this->config->item('a2a_contact', 'a2a_site');
?>
<section class="a2a-page" aria-labelledby="a2aContactH">
	<div class="a2a-wrap">
		<nav class="a2a-crumbs" aria-label="Breadcrumb"><a href="<?php echo site_url(); ?>"><?php echo a2a_e('a2a_home'); ?></a> <span aria-hidden="true">/</span> <span aria-current="page"><?php echo a2a_e('a2a_contact'); ?></span></nav>
		<h1 id="a2aContactH"><?php echo a2a_e('a2a_contact'); ?></h1>
		<p class="a2a-lead">Indian Council for Cultural Relations (ICCR) runs the A2A scholarship portal. For questions about your application, first contact the Indian Mission in your country. For portal or technical problems, use the details below.</p>

		<div class="a2a-contact-grid">
			<div class="a2a-card">
				<h2><i class="fa fa-building-o" aria-hidden="true"></i> Office address</h2>
				<address><?php echo html_escape($cc['office']); ?><br><?php echo html_escape($cc['address']); ?></address>
				<a class="a2a-more" href="<?php echo html_escape($cc['map_url']); ?>" target="_blank" rel="noopener">Open in maps <span class="sr-only">(opens in a new tab)</span> <i class="fa fa-external-link" aria-hidden="true"></i></a>
			</div>
			<div class="a2a-card">
				<h2><i class="fa fa-phone" aria-hidden="true"></i> <?php echo a2a_e('a2a_phone'); ?></h2>
				<ul class="a2a-plain">
					<?php foreach ($cc['phones'] as $ph) { ?>
					<li><a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $ph); ?>"><?php echo html_escape($ph); ?></a></li>
					<?php } ?>
				</ul>
				<p class="a2a-muted"><?php echo a2a_e('a2a_hours'); ?>: <?php echo html_escape($cc['hours']); ?></p>
			</div>
			<div class="a2a-card">
				<h2><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo a2a_e('a2a_email'); ?></h2>
				<p><?php echo html_escape($cc['email_label']); ?>:<br><a href="mailto:<?php echo html_escape($cc['email']); ?>"><?php echo html_escape($cc['email']); ?></a></p>
				<p class="a2a-muted">Please include your application number and registered email ID.</p>
			</div>
			<div class="a2a-card">
				<h2><i class="fa fa-flag-o" aria-hidden="true"></i> Indian Missions abroad</h2>
				<p>Your application is reviewed by the Indian Embassy or High Commission in your country.</p>
				<a class="a2a-more" href="<?php echo html_escape($cc['missions_url']); ?>" target="_blank" rel="noopener"><?php echo a2a_e('a2a_mission_dir'); ?> <span class="sr-only">(opens in a new tab)</span> <i class="fa fa-external-link" aria-hidden="true"></i></a>
			</div>
		</div>

		<div class="a2a-card a2a-card--soft">
			<h2><i class="fa fa-comments-o" aria-hidden="true"></i> Feedback and help</h2>
			<p>Tell us what is not working or what we can improve.</p>
			<p class="a2a-btnrow">
				<a class="a2a-btnlink a2a-btnlink--primary" href="<?php echo site_url('home/feedback'); ?>"><?php echo a2a_e('a2a_feedback'); ?></a>
				<a class="a2a-btnlink" href="<?php echo site_url('home/faqs'); ?>"><?php echo a2a_e('a2a_faqs'); ?></a>
				<a class="a2a-btnlink" href="<?php echo site_url('home/help'); ?>"><?php echo a2a_e('a2a_help'); ?></a>
			</p>
		</div>
	</div>
</section>

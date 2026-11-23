<div class="clearfix"> </div>
</main>
		<?php
		$fdocs = site_url().'assets/site/docs/';
		if (!function_exists('a2a_t')) { $this->load->helper('a2a_i18n'); }
		$this->config->load('a2a_site', TRUE);
		$fc = $this->config->item('a2a_contact', 'a2a_site');
		$data['footerpage'] = $this->common_model->getFrontPage(0);
		$aboutPages = $this->common_model->getFrontPage(1);
		$aboutUrl = !empty($aboutPages) ? site_url('home/page/'.$aboutPages[0]['page_slug']) : site_url('home/page/about-us');
		?>
		<footer class="a2a-footer" role="contentinfo">
			<!-- Fixed footer items (GIGW): Home, About Us, Contact, Feedback, Sitemap -->
			<nav class="a2a-footer__fixed" aria-label="Footer">
				<div class="a2a-wrap">
					<ul>
						<li><a href="<?php echo site_url();?>"><?php echo a2a_e('a2a_home'); ?></a></li>
						<li><a href="<?php echo $aboutUrl; ?>"><?php echo a2a_e('a2a_about'); ?></a></li>
						<li><a href="<?php echo site_url();?>home/contactus"><?php echo a2a_e('a2a_contact'); ?></a></li>
						<li><a href="<?php echo site_url();?>home/feedback"><?php echo a2a_e('a2a_feedback'); ?></a></li>
						<li><a href="<?php echo site_url();?>seo/sitemap"><?php echo a2a_e('a2a_sitemap'); ?></a></li>
						<li><a href="<?php echo site_url();?>home/help"><?php echo a2a_e('a2a_help'); ?></a></li>
					</ul>
					<button type="button" class="a2a-share" id="a2aShare" data-copied="<?php echo a2a_e('a2a_link_copied'); ?>">
						<i class="fa fa-share-alt" aria-hidden="true"></i> <span><?php echo a2a_e('a2a_share'); ?></span>
					</button>
				</div>
			</nav>

			<div class="a2a-wrap">
				<div class="a2a-footer__grid">
					<div class="a2a-footer__brand">
						<img src="<?php echo base_url();?>assets/site/main/images/logos/national-emblem-india-sm.png" width="100" height="160" alt="National Emblem of India" />
						<h2>Indian Council for Cultural Relations</h2>
						<p><?php echo a2a_e('a2a_footer_about'); ?></p>
					</div>

					<div>
						<h3><?php echo a2a_e('a2a_footer_contact'); ?></h3>
						<address class="a2a-contact">
							<span><i class="fa fa-map-marker" aria-hidden="true"></i><span><?php echo html_escape($fc['office']); ?>, <?php echo html_escape($fc['address']); ?></span></span>
							<?php foreach ($fc['phones'] as $ph) { ?>
							<a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $ph); ?>"><i class="fa fa-phone" aria-hidden="true"></i><span><span class="sr-only"><?php echo a2a_e('a2a_phone'); ?>: </span><?php echo html_escape($ph); ?></span></a>
							<?php } ?>
							<a href="mailto:<?php echo html_escape($fc['email']); ?>"><i class="fa fa-envelope" aria-hidden="true"></i><span><span class="sr-only"><?php echo a2a_e('a2a_email'); ?>: </span><?php echo html_escape($fc['email']); ?> <small>(<?php echo html_escape($fc['email_label']); ?>)</small></span></a>
							<span><i class="fa fa-clock-o" aria-hidden="true"></i><span><span class="sr-only"><?php echo a2a_e('a2a_hours'); ?>: </span><?php echo html_escape($fc['hours']); ?></span></span>
						</address>
					</div>

					<div>
						<h3><?php echo a2a_e('a2a_policies'); ?></h3>
						<ul>
							<?php $hasPriv = $hasTerms = FALSE;
							if(!empty($data['footerpage'])){
							foreach($data['footerpage'] as $page){
								if (stripos($page['page_title'], 'privacy') !== FALSE) { $hasPriv = TRUE; }
								if (stripos($page['page_title'], 'terms') !== FALSE) { $hasTerms = TRUE; } ?>
							<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><?php echo $page['page_title'] ?></a></li>
							<?php } } ?>
							<?php if (!$hasPriv) { ?><li><a href="<?php echo site_url();?>home/privacy">Privacy Policy</a></li><?php } ?>
							<?php if (!$hasTerms) { ?><li><a href="<?php echo site_url();?>home/termsandconditions">Terms &amp; Conditions</a></li><?php } ?>
						</ul>
					</div>

					<div>
						<h3><?php echo a2a_e('a2a_resources'); ?></h3>
						<ul>
							<li><a href="<?php echo $fdocs;?>Policy_Guidelines.pdf" target="_blank" rel="noopener"><?php echo a2a_e('a2a_q_guidelines'); ?> <span class="sr-only">(PDF, opens in a new tab)</span></a></li>
							<li><a href="<?php echo $fdocs;?>Timeline-AY-2026-27.pdf" target="_blank" rel="noopener"><?php echo a2a_e('a2a_q_timeline'); ?> <span class="sr-only">(PDF, opens in a new tab)</span></a></li>
							<li><a href="<?php echo $fdocs;?>universities.pdf" target="_blank" rel="noopener"><?php echo a2a_e('a2a_universities'); ?> <span class="sr-only">(PDF, opens in a new tab)</span></a></li>
							<li><a href="<?php echo site_url();?>home/testimonials">Testimonials</a></li>
							<li><a href="http://a2ascholarships.iccr.gov.in/alumni_app">Alumni Portal</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="a2a-footer__bottom">
				<div class="a2a-wrap">
					<div>&copy; <?php echo a2a_e('a2a_copyright'); ?></div>
					<div class="a2a-footer__updated">
						<i class="fa fa-refresh" aria-hidden="true"></i> <?php echo a2a_e('a2a_last_updated'); ?>: 09-10-2026
						<a href="#a2a-main" class="a2a-totop" id="a2aToTop"><i class="fa fa-arrow-up" aria-hidden="true"></i> <?php echo a2a_e('a2a_top'); ?></a>
					</div>
				</div>
			</div>
		</footer>
	</div>
</div>
<!-- Upload Divs -->
<div id="profileUploadsPic" class="modal fade" role="dialog">
	<div id="profilePic" class="modal-dialog popup dropzone">
		<div class="dz-message" data-dz-message><span>Click/Drop Image file Here</span></div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	// Text size controls (A- / A / A+ in the header)
	var baseSize = parseInt($('body').css('font-size'), 10) || 14;
	$('#incfont').click(function(){
		var curSize = parseInt($('body').css('font-size'), 10) + 1;
		if(curSize <= 20){ $('body').css('font-size', curSize); }
	});
	$('#decfont').click(function(){
		var curSize = parseInt($('body').css('font-size'), 10) - 1;
		if(curSize >= 10){ $('body').css('font-size', curSize); }
	});
	$('#norfont').click(function(){
		$('body').css('font-size', baseSize);
	});
	// Back to top
	$('#a2aToTop').on('click', function(e){
		e.preventDefault();
		$('html, body').animate({scrollTop: 0}, 300);
		$('#a2a-main').trigger('focus');
	});
	// Share this page: phone share sheet where available, otherwise copy the link
	$('#a2aShare').on('click', function(){
		var $b = $(this), url = window.location.href.split('#')[0], title = document.title;
		function done(){ var t = $b.find('span').text(); $b.find('span').text($b.data('copied')); setTimeout(function(){ $b.find('span').text(t); }, 2000); }
		if (navigator.share) { navigator.share({title: title, url: url}).catch(function(){}); return; }
		if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(url).then(done); return; }
		var i = $('<input>').val(url).appendTo('body').select(); try { document.execCommand('copy'); done(); } catch (e) {} i.remove();
	});
});
</script>

</body>
</html>

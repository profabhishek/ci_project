<?php
// HTML sitemap. The list itself is in application/helpers/a2a_sitemap_helper.php
$this->load->helper('a2a_sitemap');
if (!function_exists('a2a_t')) { $this->load->helper('a2a_i18n'); }
$groups = a2a_sitemap_groups();
?>
<section class="a2a-page" aria-labelledby="a2aSitemapH">
	<div class="a2a-wrap">
		<nav class="a2a-crumbs" aria-label="Breadcrumb"><a href="<?php echo site_url(); ?>"><?php echo a2a_e('a2a_home'); ?></a> <span aria-hidden="true">/</span> <span aria-current="page"><?php echo a2a_e('a2a_sitemap'); ?></span></nav>
		<h1 id="a2aSitemapH"><?php echo a2a_e('a2a_sitemap'); ?></h1>
		<p class="a2a-lead">All public pages of the A2A scholarship portal in one place.</p>
		<div class="a2a-sitemap">
			<?php foreach ($groups as $title => $links) { if (empty($links)) { continue; }
				$seen = array(); ?>
			<section class="a2a-card">
				<h2><?php echo html_escape($title); ?></h2>
				<ul>
					<?php foreach ($links as $l) {
						if (isset($seen[strtolower($l[0])])) { continue; } $seen[strtolower($l[0])] = 1;
						$href = (strpos($l[1], '#') === 0) ? site_url() . $l[1] : site_url($l[1]); ?>
					<li><a href="<?php echo $href; ?>"><?php echo html_escape($l[0]); ?></a></li>
					<?php } ?>
				</ul>
			</section>
			<?php } ?>
		</div>
	</div>
</section>

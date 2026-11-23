<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Public home-page content shown below the sign-in card (no login needed).
 * Added for the UX4G audit: citizen journey (Apply -> Status -> Outcome),
 * scheme explorer with filter + sort, "find your Mission" by country, and
 * quick links. Data: A2a_public_model (cached 1 hour).
 */
if (!function_exists('a2a_t')) { $this->load->helper('a2a_i18n'); }
$A2A =& get_instance();
$A2A->load->model('A2a_public_model', 'a2apub');
$this->config->load('a2a_site', TRUE);
$pc = $this->config->item('a2a_contact', 'a2a_site');
$schemes  = $A2A->a2apub->schemes();
$missions = $A2A->a2apub->mission_countries();
$byCountry = array();
foreach ($missions as $m) {
    $byCountry[$m['country_id']]['name'] = $m['country'];
    $byCountry[$m['country_id']]['missions'][] = $m['mission'];
}
$pdocs = site_url().'assets/site/docs/';
?>
<div class="a2a-public">

	<!-- 1. Citizen journey: Application -> Status -> Outcome -->
	<section class="a2a-sec" aria-labelledby="a2aJourneyH">
		<div class="a2a-sec__head">
			<h2 id="a2aJourneyH"><?php echo a2a_e('a2a_journey_title'); ?></h2>
			<p><?php echo a2a_e('a2a_journey_sub'); ?></p>
		</div>
		<ol class="a2a-journey">
			<?php $ico = array(1 => 'fa-pencil-square-o', 2 => 'fa-flag', 3 => 'fa-university', 4 => 'fa-trophy', 5 => 'fa-plane');
			for ($i = 1; $i <= 5; $i++) { ?>
			<li>
				<span class="a2a-journey__n" aria-hidden="true"><?php echo $i; ?></span>
				<span class="a2a-journey__ico" aria-hidden="true"><i class="fa <?php echo $ico[$i]; ?>"></i></span>
				<h3><?php echo a2a_e('a2a_j'.$i.'_t'); ?></h3>
				<p><?php echo a2a_e('a2a_j'.$i.'_d'); ?></p>
			</li>
			<?php } ?>
		</ol>
		<div class="a2a-journey__cta">
			<a class="a2a-btnlink a2a-btnlink--primary" href="#myLogin"><i class="fa fa-search" aria-hidden="true"></i> <?php echo a2a_e('a2a_track'); ?></a>
			<span><?php echo a2a_e('a2a_track_d'); ?></span>
		</div>
	</section>

	<div class="a2a-twocol">
		<!-- 2. Scheme explorer (filter + sort) -->
		<section class="a2a-sec a2a-card" aria-labelledby="a2aSchemesH">
			<div class="a2a-sec__head">
				<h2 id="a2aSchemesH"><?php echo a2a_e('a2a_explore_title'); ?></h2>
				<p><?php echo a2a_e('a2a_explore_sub'); ?></p>
			</div>
			<div class="a2a-tools">
				<div class="a2a-field">
					<label for="a2aSchemeFilter"><?php echo a2a_e('a2a_filter_label'); ?></label>
					<input type="search" id="a2aSchemeFilter" class="a2a-input" placeholder="<?php echo a2a_e('a2a_filter_ph'); ?>" autocomplete="off" aria-controls="a2aSchemeList">
				</div>
				<div class="a2a-field">
					<label for="a2aSchemeSort"><?php echo a2a_e('a2a_sort'); ?></label>
					<select id="a2aSchemeSort" class="a2a-input" aria-controls="a2aSchemeList">
						<option value="az"><?php echo a2a_e('a2a_sort_az'); ?></option>
						<option value="za"><?php echo a2a_e('a2a_sort_za'); ?></option>
					</select>
				</div>
			</div>
			<p class="a2a-count" id="a2aSchemeCount" aria-live="polite" data-showing="<?php echo a2a_e('a2a_showing'); ?>" data-of="<?php echo a2a_e('a2a_of'); ?>"></p>
			<ul class="a2a-schemes" id="a2aSchemeList">
				<?php foreach ($schemes as $sc) { ?>
				<li data-name="<?php echo html_escape(strtolower($sc['scheme_name'].' '.$sc['desc'])); ?>" data-sort="<?php echo html_escape(strtolower($sc['scheme_name'])); ?>">
					<h3><?php echo html_escape($sc['scheme_name']); ?></h3>
					<?php if (trim(strip_tags($sc['desc'])) !== '') { ?><p><?php echo html_escape(strip_tags($sc['desc'])); ?></p><?php } ?>
				</li>
				<?php } ?>
			</ul>
			<p class="a2a-empty" id="a2aSchemeEmpty" hidden><?php echo a2a_e('a2a_no_match'); ?></p>
			<a class="a2a-more" href="<?php echo site_url('home/getAllSchemeList'); ?>"><?php echo a2a_e('a2a_all_schemes'); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
		</section>

		<div class="a2a-stack">
			<!-- 3. Location based: find the Mission for your country -->
			<section class="a2a-sec a2a-card" aria-labelledby="a2aMissionH">
				<div class="a2a-sec__head">
					<h2 id="a2aMissionH"><?php echo a2a_e('a2a_mission_title'); ?></h2>
					<p><?php echo a2a_e('a2a_mission_sub'); ?></p>
				</div>
				<div class="a2a-field">
					<label for="a2aCountry"><?php echo a2a_e('a2a_your_country'); ?></label>
					<select id="a2aCountry" class="a2a-input" aria-controls="a2aMissionOut">
						<option value=""><?php echo a2a_e('a2a_choose_country'); ?></option>
						<?php foreach ($byCountry as $cid => $cinfo) { ?>
						<option value="<?php echo (int) $cid; ?>"><?php echo html_escape($cinfo['name']); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="a2a-mission" id="a2aMissionOut" aria-live="polite"></div>
				<a class="a2a-more" href="<?php echo html_escape($pc['missions_url']); ?>" target="_blank" rel="noopener"><?php echo a2a_e('a2a_mission_dir'); ?> <span class="sr-only">(opens in a new tab)</span> <i class="fa fa-external-link" aria-hidden="true"></i></a>
				<script type="application/json" id="a2aMissionData"><?php
					$out = array();
					foreach ($byCountry as $cid => $cinfo) { $out[(int)$cid] = array('c' => $cinfo['name'], 'm' => array_values(array_unique($cinfo['missions']))); }
					echo json_encode($out, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
				?></script>
				<span hidden id="a2aMissionTxt" data-for="<?php echo a2a_e('a2a_mission_for'); ?>" data-none="<?php echo a2a_e('a2a_mission_none'); ?>"></span>
			</section>

			<!-- 4. Before you apply -->
			<section class="a2a-sec a2a-card" aria-labelledby="a2aQuickH">
				<div class="a2a-sec__head"><h2 id="a2aQuickH"><?php echo a2a_e('a2a_quick_title'); ?></h2></div>
				<ul class="a2a-quick">
					<li><a href="<?php echo $pdocs; ?>Policy_Guidelines.pdf" target="_blank" rel="noopener"><i class="fa fa-file-pdf-o" aria-hidden="true"></i><span><strong><?php echo a2a_e('a2a_q_guidelines'); ?></strong><small><?php echo a2a_e('a2a_q_guidelines_d'); ?></small></span></a></li>
					<li><a href="<?php echo $pdocs; ?>Timeline-AY-2026-27.pdf" target="_blank" rel="noopener"><i class="fa fa-calendar" aria-hidden="true"></i><span><strong><?php echo a2a_e('a2a_q_timeline'); ?></strong><small><?php echo a2a_e('a2a_q_timeline_d'); ?></small></span></a></li>
					<li><a href="<?php echo $pdocs; ?>universities.pdf" target="_blank" rel="noopener"><i class="fa fa-university" aria-hidden="true"></i><span><strong><?php echo a2a_e('a2a_q_universities'); ?></strong><small><?php echo a2a_e('a2a_q_universities_d'); ?></small></span></a></li>
					<li><a href="<?php echo site_url('home/faqs'); ?>"><i class="fa fa-question-circle" aria-hidden="true"></i><span><strong><?php echo a2a_e('a2a_faqs'); ?></strong><small><?php echo a2a_e('a2a_q_faqs_d'); ?></small></span></a></li>
				</ul>
			</section>
		</div>
	</div>
</div>
<script>
(function () {
	// Scheme filter + sort (works without a page reload; without JS the full list is shown)
	var list = document.getElementById('a2aSchemeList');
	if (list) {
		var input = document.getElementById('a2aSchemeFilter'), sort = document.getElementById('a2aSchemeSort'),
			count = document.getElementById('a2aSchemeCount'), empty = document.getElementById('a2aSchemeEmpty'),
			items = Array.prototype.slice.call(list.children);
		function apply() {
			var q = (input.value || '').toLowerCase().trim(), shown = 0;
			items.sort(function (a, b) {
				var r = a.getAttribute('data-sort').localeCompare(b.getAttribute('data-sort'));
				return sort.value === 'za' ? -r : r;
			});
			items.forEach(function (li) {
				var ok = !q || li.getAttribute('data-name').indexOf(q) !== -1;
				li.hidden = !ok; if (ok) { shown++; } list.appendChild(li);
			});
			count.textContent = count.getAttribute('data-showing') + ' ' + shown + ' ' + count.getAttribute('data-of') + ' ' + items.length;
			empty.hidden = shown !== 0;
		}
		input.addEventListener('input', apply); sort.addEventListener('change', apply); apply();
	}
	// Find your Mission
	var sel = document.getElementById('a2aCountry');
	if (sel) {
		var data = {}; try { data = JSON.parse(document.getElementById('a2aMissionData').textContent); } catch (e) {}
		var txt = document.getElementById('a2aMissionTxt'), out = document.getElementById('a2aMissionOut');
		sel.addEventListener('change', function () {
			out.textContent = '';
			if (!sel.value) { return; }
			var d = data[sel.value];
			if (!d || !d.m.length) { var p = document.createElement('p'); p.textContent = txt.getAttribute('data-none'); out.appendChild(p); return; }
			var h = document.createElement('p'); h.className = 'a2a-mission__for';
			h.textContent = txt.getAttribute('data-for') + ' ' + d.c + ':'; out.appendChild(h);
			d.m.forEach(function (name) {
				var b = document.createElement('p'); b.className = 'a2a-mission__name';
				var i = document.createElement('i'); i.className = 'fa fa-flag'; i.setAttribute('aria-hidden', 'true');
				b.appendChild(i); b.appendChild(document.createTextNode(' ' + name)); out.appendChild(b);
			});
		});
	}
})();
</script>

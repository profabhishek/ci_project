<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-card">
	<div class="ap-card__head"><div><h2>Reports</h2><p>Pick a report, choose the year and filters, then preview it or download it as Excel, CSV or PDF. Every download is recorded in the audit log.</p></div></div>
</div>

<style type="text/css">
.rep-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;margin-top:16px;}
.rep-card{display:flex;flex-direction:column;gap:10px;background:#fff;border:1px solid var(--line,#e3e8ef);border-radius:var(--r,12px);box-shadow:var(--shadow,0 1px 2px rgba(16,24,40,.06));padding:18px 18px 20px;color:inherit;transition:border-color .12s ease,box-shadow .12s ease,transform .12s ease;}
.rep-card:hover{text-decoration:none;border-color:#b9c6db;box-shadow:0 6px 18px rgba(16,24,40,.08);transform:translateY(-1px);}
.rep-card__ico{width:44px;height:44px;border-radius:11px;background:var(--n50,#eef2f7);color:var(--n600,#475569);display:grid;place-items:center;font-size:19px;flex:0 0 auto;}
.rep-card__title{font-size:15.5px;font-weight:700;color:var(--n900,#0f172a);line-height:1.25;}
.rep-card__desc{font-size:12.8px;color:var(--muted,#667085);line-height:1.5;}
</style>

<div class="rep-grid">
	<?php foreach ($catalog as $key => $c) { ?>
	<a class="rep-card" href="<?php echo site_url('adminpanel/report/' . $key); ?>">
		<span class="rep-card__ico"><i class="fa <?php echo html_escape($c['icon']); ?>"></i></span>
		<div class="rep-card__title"><?php echo html_escape($c['title']); ?></div>
		<div class="rep-card__desc"><?php echo html_escape($c['desc']); ?></div>
	</a>
	<?php } ?>
	<a class="rep-card" href="<?php echo site_url('adminpanel/gyansetu'); ?>">
		<span class="rep-card__ico"><i class="fa fa-file-excel-o"></i></span>
		<div class="rep-card__title">Gyan Setu export</div>
		<div class="rep-card__desc">Same data and column order as the Gyan Setu API, for all students or chosen application numbers.</div>
	</a>
</div>

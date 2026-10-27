<?php defined('BASEPATH') OR exit('No direct script access allowed');
$id = (int) $row['id'];
$expired = empty($row['validated_upto']) || $row['validated_upto'] < $today;
$days = $expired ? 0 : (int) floor((strtotime($row['validated_upto']) - strtotime($today)) / 86400) + 1;
$labels = array('draft' => 'Draft - not on the home page', 'hidden' => 'Off the home page', 'live' => 'Live on the home page', 'expired' => 'Expired');
?>
<style>
	.pv-strip { display: flex; align-items: stretch; border-radius: 10px; overflow: hidden; border: 1px solid var(--line); background: #fff; }
	.pv-strip__tag { background: var(--n800); color: #fff; font-weight: 700; padding: 12px 16px; white-space: nowrap; display: flex; align-items: center; gap: 8px; }
	.pv-strip__items { flex: 1; overflow: hidden; display: flex; align-items: center; gap: 28px; padding: 0 16px; white-space: nowrap; }
	.pv-strip__items a { color: var(--n700); }
	.pv-new { background: #fff7e0; outline: 2px dashed var(--gold); outline-offset: 2px; padding: 3px 8px; border-radius: 6px; font-weight: 600; }
	.pv-dl { display: grid; grid-template-columns: 170px 1fr; gap: 8px 16px; margin: 0; }
	.pv-dl dt { color: var(--muted); }
	.pv-dl dd { margin: 0; }
</style>

<div class="ap-card">
	<div class="ap-card__head">
		<div><h2>Preview announcement #<?php echo $id; ?></h2><p>This is how the home page strip will look. The new item has a dashed outline.</p></div>
		<div class="btn-group">
			<a class="btn btn-sm" href="<?php echo site_url('adminpanel/announcement/' . $id); ?>"><i class="fa fa-pencil"></i> Edit</a>
			<a class="btn btn-sm" href="<?php echo site_url('adminpanel/announcements'); ?>"><i class="fa fa-angle-left"></i> All announcements</a>
		</div>
	</div>
	<div class="ap-card__body">
		<div class="pv-strip" aria-label="Home page announcement strip preview">
			<div class="pv-strip__tag"><i class="fa fa-bullhorn"></i> Announcements</div>
			<div class="pv-strip__items">
				<span class="pv-new"><a href="#" onclick="return false"><?php echo html_escape($row['title']); ?></a></span>
				<?php foreach (array_slice($live_now, 0, 3) as $l) { ?><span><a href="#" onclick="return false"><?php echo html_escape($l['title']); ?></a></span><?php } ?>
			</div>
		</div>

		<dl class="pv-dl" style="margin-top:20px">
			<dt>State now</dt><dd><b><?php echo html_escape($labels[$state]); ?></b></dd>
			<dt>Full title</dt><dd><?php echo nl2br(html_escape($row['title'])); ?> <span class="muted">(<?php echo mb_strlen($row['title']); ?> characters)</span></dd>
			<dt>Show until</dt><dd><?php echo html_escape($row['validated_upto']); ?>
				<?php echo $expired ? '<span class="badge badge--err">Date has passed</span>' : '<span class="muted">(' . $days . ' day' . ($days === 1 ? '' : 's') . ' on the home page)</span>'; ?></dd>
			<dt>Attachment</dt><dd><?php if (!empty($row['notification_doc'])) { ?><a href="<?php echo base_url('assets/site/main/notification/' . rawurlencode($row['notification_doc'])); ?>" target="_blank" rel="noopener"><i class="fa fa-file-pdf-o"></i> Open the PDF</a> - check it is the right file<?php } else { ?><span class="muted">None</span><?php } ?></dd>
			<dt>Already live</dt><dd><?php echo count($live_now); ?> other announcement<?php echo count($live_now) === 1 ? '' : 's'; ?> on the home page</dd>
		</dl>
	</div>

	<?php if ($state === 'live') { ?>
	<div class="form-actions">
		<span class="muted">This announcement is already on the home page.</span>
		<?php echo form_open('adminpanel/announcement_unpublish/' . $id, array('class' => 'inline')); ?>
			<button class="btn" data-confirm="Take this announcement off the home page?"><i class="fa fa-eye-slash"></i> Unpublish</button>
		<?php echo form_close(); ?>
	</div>
	<?php } elseif ($expired) { ?>
	<div class="form-actions">
		<span class="muted">Change the "Show until" date before publishing.</span>
		<a class="btn btn-primary" href="<?php echo site_url('adminpanel/announcement/' . $id); ?>"><i class="fa fa-pencil"></i> Edit date</a>
	</div>
	<?php } else { ?>
	<?php echo form_open('adminpanel/announcement_publish/' . $id); ?>
	<div class="form-actions" style="justify-content:space-between;flex-wrap:wrap">
		<label class="chk"><input type="checkbox" name="confirm_publish" value="1" required> I have checked the text, the date and the attachment</label>
		<button class="btn btn-primary" type="submit" data-confirm="Publish this announcement to the public home page now?"><i class="fa fa-bullhorn"></i> Publish to home page</button>
	</div>
	<?php echo form_close(); ?>
	<?php } ?>
</div>

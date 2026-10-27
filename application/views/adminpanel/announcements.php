<?php defined('BASEPATH') OR exit('No direct script access allowed');
$badges = array(
	'draft'   => '<span class="badge badge--gold">Draft</span>',
	'live'    => '<span class="badge badge--ok">Live</span>',
	'hidden'  => '<span class="badge badge--off">Off the home page</span>',
	'expired' => '<span class="badge badge--warn">Expired</span>',
);
?>
<div class="ap-card">
	<div class="ap-card__head">
		<div><h2>Announcements</h2><p>New and edited announcements are saved as <b>drafts</b>. Nothing reaches the home page until you open the preview and confirm <b>Publish</b>.</p></div>
		<a class="btn btn-primary" href="<?php echo site_url('adminpanel/announcement'); ?>"><i class="fa fa-plus"></i> New announcement</a>
	</div>
	<?php if (!$rows) { ?>
		<div class="empty">No announcements yet.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>#</th><th>Title</th><th>Show until</th><th>State</th><th>Attachment</th><th class="actions">Actions</th></tr></thead>
		<tbody>
		<?php foreach ($rows as $r) { $st = $ap->announcement_state($r, $today); $id = (int) $r['id']; ?>
			<tr>
				<td class="num muted"><?php echo $id; ?></td>
				<td style="max-width:480px"><?php echo html_escape($r['title']); ?>
					<?php if (!empty($r['published_at'])) { ?><br><span class="muted" style="font-size:12px">Published <?php echo html_escape($r['published_at']); ?></span><?php } ?></td>
				<td class="num"><?php echo html_escape($r['validated_upto']); ?></td>
				<td><?php echo $badges[$st]; ?></td>
				<td><?php if (!empty($r['notification_doc'])) { ?><a href="<?php echo base_url('assets/site/main/notification/' . rawurlencode($r['notification_doc'])); ?>" target="_blank" rel="noopener"><i class="fa fa-file-pdf-o"></i> PDF</a><?php } else { ?><span class="muted">None</span><?php } ?></td>
				<td class="actions">
					<a class="btn btn-sm<?php echo $st === 'draft' || $st === 'hidden' ? ' btn-primary' : ''; ?>" href="<?php echo site_url('adminpanel/announcement_preview/' . $id); ?>"><i class="fa fa-eye"></i> <?php echo $st === 'draft' || $st === 'hidden' ? 'Preview &amp; publish' : 'Preview'; ?></a>
					<a class="btn btn-sm" href="<?php echo site_url('adminpanel/announcement/' . $id); ?>"><i class="fa fa-pencil"></i> Edit</a>
					<?php if ($st === 'live' || $st === 'expired') { echo form_open('adminpanel/announcement_unpublish/' . $id, array('class' => 'inline')); ?>
						<button class="btn btn-sm" type="submit" data-confirm="Take this announcement off the home page?"><i class="fa fa-eye-slash"></i> Unpublish</button>
					<?php echo form_close(); } ?>
					<?php echo form_open('adminpanel/announcement_delete/' . $id, array('class' => 'inline')); ?>
						<button class="btn btn-sm btn-danger" type="submit" data-confirm="Delete announcement #<?php echo $id; ?> permanently? Its text stays in the audit log."><i class="fa fa-trash-o"></i> Delete</button>
					<?php echo form_close(); ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php } ?>
</div>

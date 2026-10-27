<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-tabs" style="margin-top:0">
	<a class="ap-tab<?php echo $type === '' ? ' on' : ''; ?>" href="<?php echo site_url('adminpanel/trash'); ?>">All</a>
	<?php foreach ($types as $k => $l) { ?>
		<a class="ap-tab<?php echo $type === $k ? ' on' : ''; ?>" href="<?php echo site_url('adminpanel/trash') . '?type=' . rawurlencode($k); ?>"><?php echo html_escape($l); ?></a>
	<?php } ?>
</div>
<div class="ap-card">
	<div class="ap-card__head">
		<div><h2>Trash</h2><p>Deleted students, logins, Missions and universities. They are switched off, not erased: <b>Restore</b> puts the old status back.
		Applications and other scholarship data are never removed.</p></div>
	</div>
	<?php if (!$ready) { ?>
		<div class="empty">Run <span class="mono">application/sql/adminpanel_security_local.sql</span> to turn on Trash.</div>
	<?php } elseif (!$rows) { ?>
		<div class="empty">Trash is empty.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>What</th><th>Table / ID</th><th>Reason</th><th>Deleted by</th><th>When</th><th class="actions">Actions</th></tr></thead>
		<tbody>
		<?php foreach ($rows as $t) { ?>
			<tr>
				<td><b><?php echo html_escape($t['label']); ?></b></td>
				<td class="mono"><?php echo html_escape($t['table_name'] . ' #' . $t['record_id']); ?></td>
				<td><?php echo html_escape($t['reason']); ?></td>
				<td><?php echo html_escape($t['deleted_email']); ?></td>
				<td class="muted"><?php echo html_escape($t['deleted_at']); ?></td>
				<td class="actions">
					<a class="btn btn-sm" href="<?php echo site_url('adminpanel/audit') . '?table=' . rawurlencode($t['table_name']) . '&record=' . rawurlencode($t['record_id']); ?>"><i class="fa fa-history"></i> History</a>
					<?php echo form_open('adminpanel/trash_restore/' . (int) $t['id'], array('class' => 'inline')); ?>
						<button class="btn btn-sm btn-primary" data-confirm="Restore <?php echo html_escape($t['label']); ?>?"><i class="fa fa-undo"></i> Restore</button>
					<?php echo form_close(); ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php } ?>
</div>

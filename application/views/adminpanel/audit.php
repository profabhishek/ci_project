<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-card">
	<div class="ap-card__head">
		<form class="ap-toolbar" method="get" action="<?php echo site_url('adminpanel/audit'); ?>">
			<select class="inp" name="table" style="width:240px" aria-label="Table">
				<option value="">All tables</option>
				<?php foreach (array('iccr_users', 'iccr_student_details', 'iccr_student_application_details', 'iccr_student_other_details', 'iccr_status_mapping', 'iccr_missions', 'iccr_univercities', 'iccr_notifications', 'iccr_nav_links') as $t) { ?>
					<option<?php echo $f['table'] === $t ? ' selected' : ''; ?>><?php echo $t; ?></option>
				<?php } ?>
			</select>
			<input class="inp mono" name="record" value="<?php echo html_escape($f['record']); ?>" placeholder="Record ID" style="width:130px" aria-label="Record ID">
			<label class="ap-search"><span class="sr-only">Search</span><i class="fa fa-search"></i><input class="inp" name="q" value="<?php echo html_escape($f['q']); ?>" placeholder="Admin, field or value"></label>
			<button class="btn" type="submit">Filter</button>
			<?php if ($f['table'] || $f['record'] || $f['q']) { ?><a class="btn" href="<?php echo site_url('adminpanel/audit'); ?>">Clear</a><?php } ?>
		</form>
	</div>
	<?php if (!$rows) { ?>
		<div class="empty">No changes recorded<?php echo ($f['table'] || $f['record'] || $f['q']) ? ' for this filter' : ' yet'; ?>.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>When</th><th>Admin</th><th>Action</th><th>Record</th><th>Field</th><th>Old value</th><th>New value</th><th>Note</th></tr></thead>
		<tbody>
		<?php foreach ($rows as $r) { ?>
			<tr>
				<td class="muted" style="white-space:nowrap"><?php echo html_escape($r['created_at']); ?></td>
				<td><?php echo html_escape($r['admin_email']); ?><br><span class="muted mono" style="font-size:11px"><?php echo html_escape($r['ip_address']); ?></span></td>
				<td><span class="badge<?php echo $r['action'] === 'delete' ? ' badge--err' : ($r['action'] === 'insert' ? ' badge--ok' : ''); ?>"><?php echo html_escape($r['action']); ?></span></td>
				<td class="mono"><?php echo html_escape($r['table_name']); ?><br>#<?php echo html_escape($r['record_id']); ?></td>
				<td class="mono"><?php echo html_escape($r['column_name']); ?></td>
				<td class="mono muted" style="min-width:160px;max-width:300px;word-break:break-word"<?php echo $r['old_value'] !== NULL ? ' title="' . html_escape($r['old_value']) . '"' : ''; ?>><?php echo $r['old_value'] === NULL ? '<i>NULL</i>' : html_escape(mb_strimwidth($r['old_value'], 0, 120, '…')); ?></td>
				<td class="mono" style="min-width:160px;max-width:300px;word-break:break-word"<?php echo $r['new_value'] !== NULL ? ' title="' . html_escape($r['new_value']) . '"' : ''; ?>><?php echo $r['new_value'] === NULL ? '<i class="muted">NULL</i>' : html_escape(mb_strimwidth($r['new_value'], 0, 120, '…')); ?></td>
				<td class="muted"><?php echo html_escape($r['note']); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php $this->load->view('adminpanel/_pager', array('pager' => $pager, 'base' => 'adminpanel/audit', 'params' => $f)); ?>
	<?php } ?>
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-card">
	<div class="ap-card__head">
		<p class="muted" style="margin:0 0 10px">Every recorded data change on the portal (table <span class="mono">audit_log</span>): changes made here in the Admin Panel,
			and changes caught by the database audit triggers from other screens. Use it for the daily report: filter by date, application or table.</p>
		<form class="ap-toolbar" method="get" action="<?php echo site_url('adminpanel/general_audit'); ?>">
			<select class="inp" name="table" style="width:220px" aria-label="Table">
				<option value="">All tables</option>
				<?php foreach ($tables as $t) { ?>
					<option<?php echo $f['table'] === $t ? ' selected' : ''; ?>><?php echo html_escape($t); ?></option>
				<?php } ?>
			</select>
			<select class="inp" name="action" style="width:120px" aria-label="Action">
				<option value="">All actions</option>
				<?php foreach (array('INSERT', 'UPDATE', 'DELETE') as $a) { ?>
					<option<?php echo $f['action'] === $a ? ' selected' : ''; ?>><?php echo $a; ?></option>
				<?php } ?>
			</select>
			<input class="inp mono" name="app" value="<?php echo html_escape($f['app']); ?>" placeholder="Application no." style="width:170px" aria-label="Application number">
			<label class="muted" style="display:flex;align-items:center;gap:4px">From <input class="inp" type="date" name="from" value="<?php echo html_escape($f['from']); ?>"></label>
			<label class="muted" style="display:flex;align-items:center;gap:4px">To <input class="inp" type="date" name="to" value="<?php echo html_escape($f['to']); ?>"></label>
			<label class="ap-search"><span class="sr-only">Search</span><i class="fa fa-search"></i><input class="inp" name="q" value="<?php echo html_escape($f['q']); ?>" placeholder="User, field, value or remark"></label>
			<button class="btn" type="submit">Filter</button>
			<a class="btn" href="<?php echo site_url('adminpanel/general_audit') . '?from=' . date('Y-m-d') . '&amp;to=' . date('Y-m-d'); ?>">Today</a>
			<?php if (implode('', $f) !== '') { ?><a class="btn" href="<?php echo site_url('adminpanel/general_audit'); ?>">Clear</a><?php } ?>
		</form>
	</div>
	<?php if (!$ready) { ?>
		<div class="empty">The general audit log table (<span class="mono">audit_log</span>) does not exist on this database yet.
			Run <span class="mono">application/sql/general_audit_log_setup.sql</span> once.</div>
	<?php } elseif (!$rows) { ?>
		<div class="empty">No changes recorded<?php echo implode('', $f) !== '' ? ' for this filter' : ' yet'; ?>.</div>
	<?php } else { ?>
	<p class="muted" style="margin:10px 20px"><?php echo number_format($pager['total']); ?> change<?php echo $pager['total'] == 1 ? '' : 's'; ?> found.</p>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>When</th><th>Who</th><th>Action</th><th>Application</th><th>Record</th><th>Field</th><th>Old value</th><th>New value</th><th>Remarks</th></tr></thead>
		<tbody>
		<?php foreach ($rows as $r) { $act = strtoupper((string) $r['action']); ?>
			<tr>
				<td class="muted" style="white-space:nowrap"><?php echo html_escape(substr((string) $r['changed_at'], 0, 19)); ?></td>
				<td><?php echo html_escape($r['user_name']); ?><br><span class="muted" style="font-size:11px"><?php echo html_escape($r['user_role']); ?></span></td>
				<td><span class="badge<?php echo $act === 'DELETE' ? ' badge--err' : ($act === 'INSERT' ? ' badge--ok' : ''); ?>"><?php echo html_escape($act); ?></span></td>
				<td class="mono"><?php echo $r['app'] !== NULL && $r['app'] !== '' ? '<a href="' . site_url('adminpanel/general_audit') . '?app=' . rawurlencode($r['app']) . '">' . html_escape($r['app']) . '</a>' : '<span class="muted">-</span>'; ?></td>
				<td class="mono"><?php echo html_escape($r['table_name']); ?><?php echo $r['record_id'] !== '' ? '<br>#' . html_escape($r['record_id']) : ''; ?></td>
				<td class="mono"><?php echo html_escape((string) $r['field_name']); ?></td>
				<td class="mono muted" style="min-width:150px;max-width:280px;word-break:break-word"<?php echo $r['old_value'] !== NULL ? ' title="' . html_escape($r['old_value']) . '"' : ''; ?>><?php echo $r['old_value'] === NULL ? '<i>NULL</i>' : html_escape(mb_strimwidth($r['old_value'], 0, 120, '…')); ?></td>
				<td class="mono" style="min-width:150px;max-width:280px;word-break:break-word"<?php echo $r['new_value'] !== NULL ? ' title="' . html_escape($r['new_value']) . '"' : ''; ?>><?php echo $r['new_value'] === NULL ? '<i class="muted">NULL</i>' : html_escape(mb_strimwidth($r['new_value'], 0, 120, '…')); ?></td>
				<td class="muted"><?php echo html_escape((string) $r['remarks']); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php $this->load->view('adminpanel/_pager', array('pager' => $pager, 'base' => 'adminpanel/general_audit', 'params' => $f)); ?>
	<?php } ?>
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-tabs" style="margin-top:0">
	<?php foreach ($types as $k => $l) { ?>
		<a class="ap-tab<?php echo $type === $k ? ' on' : ''; ?>" href="<?php echo site_url('adminpanel/accounts') . '?type=' . $k; ?>"<?php echo $type === $k ? ' aria-current="page"' : ''; ?>><?php echo html_escape($l); ?></a>
	<?php } ?>
</div>
<div class="ap-card">
	<div class="ap-card__head">
		<form class="ap-toolbar" method="get" action="<?php echo site_url('adminpanel/accounts'); ?>">
			<input type="hidden" name="type" value="<?php echo (int) $type; ?>">
			<label class="ap-search"><span class="sr-only">Search</span><i class="fa fa-search"></i><input class="inp" name="q" value="<?php echo html_escape($q); ?>" placeholder="Email or name"></label>
			<button class="btn" type="submit">Search</button>
		</form>
		<a class="btn btn-primary" href="<?php echo site_url('adminpanel/account') . '?type=' . (int) $type; ?>"><i class="fa fa-plus"></i> New <?php echo html_escape($types[$type]); ?> login</a>
	</div>
	<?php if (!$rows) { ?>
		<div class="empty">No <?php echo html_escape($types[$type]); ?> logins found.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>ID</th><th>Name</th><th>Email (login)</th><th>Created</th><th>Status</th><th class="actions">Actions</th></tr></thead>
		<tbody>
		<?php foreach ($rows as $r) { $me = (int) $r['id'] === (int) $admin['userid']; ?>
			<tr>
				<td class="num muted"><?php echo (int) $r['id']; ?></td>
				<td><b><?php echo html_escape($r['username']); ?></b><?php echo $me ? ' <span class="badge badge--gold">You</span>' : ''; ?></td>
				<td><?php echo html_escape($r['email_id']); ?></td>
				<td class="muted"><?php echo html_escape(is_numeric($r['created']) ? date('Y-m-d', (int) $r['created']) : substr((string) $r['created'], 0, 10)); ?></td>
				<td><?php echo (string) $r['status'] === '1' ? '<span class="badge badge--ok">Active</span>' : '<span class="badge badge--off">Off</span>'; ?></td>
				<td class="actions">
					<a class="btn btn-sm" href="<?php echo site_url('adminpanel/account/' . (int) $r['id']); ?>"><i class="fa fa-pencil"></i> Edit</a>
					<?php if (!$me) { echo form_open('adminpanel/account_status/' . (int) $r['id'], array('class' => 'inline')); ?>
						<button class="btn btn-sm<?php echo (string) $r['status'] === '1' ? ' btn-danger' : ''; ?>" data-confirm="<?php echo (string) $r['status'] === '1' ? 'Turn off this login?' : 'Turn this login back on?'; ?>"><?php echo (string) $r['status'] === '1' ? 'Turn off' : 'Turn on'; ?></button>
					<?php echo form_close(); } ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php $this->load->view('adminpanel/_pager', array('pager' => $pager, 'base' => 'adminpanel/accounts', 'params' => array('type' => $type, 'q' => $q))); ?>
	<?php } ?>
</div>

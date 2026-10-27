<?php defined('BASEPATH') OR exit('No direct script access allowed');
$tiles = array(
	array('students', 'Student accounts', 'fa-users', 'adminpanel/students'),
	array('applications', 'Applications 2026', 'fa-file-text-o', 'adminpanel/students?year=2026'),
	array('missions', 'Missions', 'fa-flag', 'adminpanel/entity/missions'),
	array('universities', 'Universities', 'fa-university', 'adminpanel/entity/universities'),
	array('announcements', 'Live announcements', 'fa-bullhorn', 'adminpanel/announcements'),
	array('nav', 'Header menu items', 'fa-sitemap', 'adminpanel/nav'),
	array('admins', 'Super Admins', 'fa-key', 'adminpanel/accounts?type=5'),
);
?>
<div class="ap-stats">
	<?php foreach ($tiles as $t) { ?>
	<a class="ap-stat" href="<?php echo site_url($t[3]); ?>">
		<span class="ap-stat__ico"><i class="fa <?php echo $t[2]; ?>"></i></span>
		<span><b><?php echo number_format((int) $counts[$t[0]]); ?></b><span><?php echo $t[1]; ?></span></span>
	</a>
	<?php } ?>
</div>

<div class="ap-card">
	<div class="ap-card__head">
		<div><h2>Quick actions</h2><p>Common jobs, one click away.</p></div>
	</div>
	<div class="ap-card__body btn-group">
		<a class="btn btn-primary" href="<?php echo site_url('adminpanel/announcement'); ?>"><i class="fa fa-plus"></i> New announcement</a>
		<a class="btn" href="<?php echo site_url('adminpanel/nav_edit'); ?>"><i class="fa fa-plus"></i> New menu item</a>
		<a class="btn" href="<?php echo site_url('adminpanel/students'); ?>"><i class="fa fa-search"></i> Find a student</a>
		<a class="btn" href="<?php echo site_url('adminpanel/student_new'); ?>"><i class="fa fa-user-plus"></i> Add student</a>
		<a class="btn" href="<?php echo site_url('adminpanel/account?type=5'); ?>"><i class="fa fa-key"></i> New admin login</a>
	</div>
</div>

<div class="ap-card">
	<div class="ap-card__head">
		<div><h2>Recent changes</h2><p>The last changes made through this panel.</p></div>
		<a class="btn btn-sm" href="<?php echo site_url('adminpanel/audit'); ?>">Full audit log <i class="fa fa-angle-right"></i></a>
	</div>
	<?php if (!$recent) { ?>
		<div class="empty">No changes recorded yet.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>When</th><th>Who</th><th>What</th><th>Field</th><th>Old</th><th>New</th></tr></thead>
		<tbody>
		<?php foreach ($recent as $r) { ?>
			<tr>
				<td class="muted" style="white-space:nowrap"><?php echo html_escape($r['created_at']); ?></td>
				<td><?php echo html_escape($r['admin_email']); ?></td>
				<td><span class="badge"><?php echo html_escape($r['action']); ?></span> <span class="mono"><?php echo html_escape($r['table_name'] . ' #' . $r['record_id']); ?></span></td>
				<td class="mono"><?php echo html_escape($r['column_name']); ?></td>
				<td class="mono muted"><?php echo html_escape(mb_strimwidth((string) $r['old_value'], 0, 40, '…')); ?></td>
				<td class="mono"><?php echo html_escape(mb_strimwidth((string) $r['new_value'], 0, 40, '…')); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php } ?>
</div>

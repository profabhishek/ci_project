<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-card">
	<div class="ap-card__head">
		<form class="ap-toolbar" method="get" action="<?php echo site_url('adminpanel/students'); ?>">
			<label class="ap-search"><span class="sr-only">Search students</span><i class="fa fa-search"></i>
				<input class="inp" name="q" value="<?php echo html_escape($q); ?>" placeholder="Email, name, passport or application no."></label>
			<select class="inp" name="year" style="width:150px" aria-label="Registration year">
				<option value="">All years</option>
				<?php for ($y = (int) date('Y'); $y >= 2021; $y--) { ?><option value="<?php echo $y; ?>"<?php echo $year === $y ? ' selected' : ''; ?>>Registered <?php echo $y; ?></option><?php } ?>
			</select>
			<button class="btn" type="submit">Search</button>
			<?php if ($q !== '' || $year) { ?><a class="btn" href="<?php echo site_url('adminpanel/students'); ?>">Clear</a><?php } ?>
		</form>
		<a class="btn btn-primary" href="<?php echo site_url('adminpanel/student_new'); ?>"><i class="fa fa-user-plus"></i> Add student</a>
	</div>
	<?php if (!$rows) { ?>
		<div class="empty">No students match.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Country</th><th>Passport</th><th>Latest application</th><th>Login</th><th class="actions"></th></tr></thead>
		<tbody>
		<?php foreach ($rows as $r) {
			$nm = trim($r['username'] . ' ' . $r['student_mname'] . ' ' . $r['student_lname']); ?>
			<tr>
				<td class="num muted"><?php echo (int) $r['id']; ?></td>
				<td><b><?php echo html_escape($nm !== '' ? $nm : '(no name)'); ?></b><br><span class="muted" style="font-size:12px">Registered <?php echo html_escape(substr((string) $r['created'], 0, 10)); ?></span></td>
				<td><?php echo html_escape($r['email_id']); ?></td>
				<td><?php echo html_escape($r['country_name'] ? $r['country_name'] : '—'); ?></td>
				<td class="mono"><?php echo html_escape($r['passport_no'] ? $r['passport_no'] : '—'); ?></td>
				<td>
					<?php if ($r['application_no']) { ?>
						<span class="mono"><?php echo html_escape($r['application_no']); ?></span><br>
						<span class="badge" title="iccr_status_mapping.status"><?php echo html_escape($r['app_status']); ?><?php echo isset($status_hints[(string) $r['app_status']]) ? ' · ' . html_escape($status_hints[(string) $r['app_status']]) : ''; ?></span>
					<?php } else { ?><span class="muted">Not submitted</span><?php } ?>
				</td>
				<td><?php echo (string) $r['account_status'] === '1' ? '<span class="badge badge--ok">Active</span>' : '<span class="badge badge--off">Off</span>'; ?></td>
				<td class="actions"><a class="btn btn-sm" href="<?php echo site_url('adminpanel/student/' . (int) $r['id']); ?>">Open <i class="fa fa-angle-right"></i></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php $this->load->view('adminpanel/_pager', array('pager' => $pager, 'base' => 'adminpanel/students', 'params' => array('q' => $q, 'year' => $year ? $year : ''))); ?>
	<?php } ?>
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed');
$u = $s['user'];
$uid = (int) $u['id'];
$full = trim($u['username'] . ' ' . (isset($u['student_mname']) ? $u['student_mname'] : '') . ' ' . (isset($u['student_lname']) ? $u['student_lname'] : ''));
$return = 'adminpanel/student/' . $uid;
$CI =& get_instance();

/** Print one editable section for a record of an allowed table. */
$section = function ($table, $row, $title, $subtitle, $open, $prefix, $hints = array()) use ($ap, $return, $CI) {
	if (!$row) {
		echo '<details class="sec"><summary><span>' . html_escape($title) . ' <span class="badge badge--off">no record</span></span><i class="fa fa-angle-down"></i></summary><div class="sec-body muted">No row in <span class="mono">' . html_escape($table) . '</span> for this student.</div></details>';
		return;
	}
	$pk = $ap->primary_key($table);
	$visible = $ap->visible_columns($table);
	$editable = $ap->editable_columns($table);
	$workflow = !empty($ap->tables[$table]['workflow']);
	$box = 'box_' . $prefix;
	echo '<details class="sec"' . ($open ? ' open' : '') . '><summary><span>' . html_escape($title) . ' <span class="muted" style="font-weight:500;font-size:12.5px">' . html_escape($subtitle) . '</span></span><i class="fa fa-angle-down"></i></summary>';
	echo form_open('adminpanel/record_save', array('data-track' => '1'));
	echo '<input type="hidden" name="table" value="' . html_escape($table) . '"><input type="hidden" name="id" value="' . html_escape($row[$pk]) . '"><input type="hidden" name="return" value="' . html_escape($return) . '">';
	echo '<div class="sec-body">';
	if ($workflow) {
		echo '<div class="ap-alert ap-alert--warn workflow-warn"><i class="fa fa-exclamation-triangle"></i><div><b>Workflow fields.</b> These decide which Mission, University and HQ lists show the application and which buttons work. Change them only when you know the effect. Every change is logged with the old value so it can be put back.</div></div>';
	}
	if (count($visible) > 12) {
		echo '<input class="inp field-filter" style="margin-bottom:14px" placeholder="Find a field…" data-field-filter="' . $box . '" aria-label="Find a field">';
	}
	echo '<div class="fgrid" id="' . $box . '">';
	foreach ($visible as $name => $c) {
		$CI->load->view('adminpanel/_field', array(
			'c' => $c, 'val' => array_key_exists($name, $row) ? $row[$name] : NULL,
			'ro' => !isset($editable[$name]), 'prefix' => $prefix . '_',
			'hint_map' => isset($hints[$name]) ? $hints[$name] : array(),
		));
	}
	echo '</div></div>';
	echo '<div class="form-actions">';
	echo '<input class="inp" name="note" maxlength="255" placeholder="Reason for the change (saved in the audit log)" style="max-width:360px">';
	if ($workflow) {
		echo '<label class="chk"><input type="checkbox" name="confirm_workflow" value="1"> I understand these are workflow fields</label>';
	}
	echo '<a class="btn btn-sm" href="' . site_url('adminpanel/audit') . '?table=' . rawurlencode($table) . '&record=' . rawurlencode($row[$pk]) . '"><i class="fa fa-history"></i> History</a>';
	echo '<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Save ' . html_escape(strtolower($title)) . '</button>';
	echo '</div>';
	echo form_close();
	echo '</details>';
};
?>
<div class="ap-card">
	<div class="ap-card__body">
		<div style="display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:center">
			<div class="ap-profile">
				<span class="ap-profile__avatar"><?php echo html_escape(strtoupper(substr($full !== '' ? $full : '?', 0, 1))); ?></span>
				<div>
					<h2><?php echo html_escape($full !== '' ? $full : '(no name)'); ?></h2>
					<div class="ap-meta">
						<span><i class="fa fa-envelope-o"></i> <?php echo html_escape($u['email_id']); ?></span>
						<span><i class="fa fa-hashtag"></i> User <?php echo $uid; ?></span>
						<span><i class="fa fa-calendar"></i> Registered <?php echo html_escape(substr((string) $u['created'], 0, 10)); ?></span>
						<span><?php echo (string) $u['status'] === '1' ? '<span class="badge badge--ok">Login active</span>' : '<span class="badge badge--off">Login off</span>'; ?></span>
					</div>
				</div>
			</div>
			<div class="btn-group">
				<a class="btn" href="<?php echo site_url('adminpanel/students'); ?>"><i class="fa fa-angle-left"></i> All students</a>
				<?php echo form_open('adminpanel/student_status/' . $uid, array('class' => 'inline')); ?>
					<button class="btn<?php echo (string) $u['status'] === '1' ? ' btn-danger' : ''; ?>" data-confirm="<?php echo (string) $u['status'] === '1' ? 'Turn off this student\'s login?' : 'Turn this student\'s login back on?'; ?>"><?php echo (string) $u['status'] === '1' ? '<i class="fa fa-ban"></i> Turn off login' : '<i class="fa fa-check"></i> Turn on login'; ?></button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<div class="ap-tabs" role="tablist" data-tabs>
	<button type="button" class="on" role="tab" aria-selected="true" data-pane="p-account"><i class="fa fa-user"></i> Account &amp; registration</button>
	<?php foreach ($s['applications'] as $i => $a) { ?>
		<button type="button" role="tab" aria-selected="false" data-pane="p-app<?php echo $i; ?>"><i class="fa fa-file-text-o"></i> <?php echo html_escape($a['status_mapping']['application_no']); ?></button>
	<?php } ?>
	<?php if (!$s['applications']) { ?><button type="button" disabled style="opacity:.6">No application submitted yet</button><?php } ?>
</div>

<div class="ap-pane on" id="p-account" role="tabpanel">
	<?php $section('iccr_users', $u, 'Login account', 'iccr_users', TRUE, 'u'); ?>
	<?php foreach ($s['details'] as $k => $d) { $section('iccr_student_details', $d, 'Registration details', 'iccr_student_details', FALSE, 'd' . $k); } ?>
	<?php if (!$s['details']) { $section('iccr_student_details', NULL, 'Registration details', '', FALSE, 'd'); } ?>

	<details class="sec">
		<summary><span>Set a new password <span class="muted" style="font-weight:500;font-size:12.5px">The student logs in with it straight away</span></span><i class="fa fa-angle-down"></i></summary>
		<?php echo form_open('adminpanel/student_password/' . $uid); ?>
		<div class="sec-body fgrid fgrid--2">
			<div class="f"><label for="spw">New password</label><input class="inp" type="password" id="spw" name="password" autocomplete="new-password" required minlength="8"><span class="hint">8+ characters with upper and lower case, a number and a symbol.</span></div>
		</div>
		<div class="form-actions"><button class="btn btn-primary" data-confirm="Change this student's password?"><i class="fa fa-key"></i> Set password</button></div>
		<?php echo form_close(); ?>
	</details>

	<?php if (empty($trashed)) { $this->load->view('adminpanel/_delete', array('action' => 'adminpanel/student_delete/' . $uid, 'what' => 'this student',
		'effect' => 'The student\'s login is switched off and they disappear from the Students list. Their applications and documents are not touched.')); } ?>
</div>

<?php foreach ($s['applications'] as $i => $a) {
	$no = $a['status_mapping']['application_no']; ?>
<div class="ap-pane" id="p-app<?php echo $i; ?>" role="tabpanel">
	<?php $section('iccr_status_mapping', $a['status_mapping'], 'Workflow status', 'iccr_status_mapping', TRUE, 'sm' . $i, $hints); ?>
	<?php $section('iccr_student_application_details', $a['application'], 'Application form', 'iccr_student_application_details', FALSE, 'ad' . $i); ?>
	<?php $section('iccr_student_other_details', $a['other'], 'Other details (Mission link)', 'iccr_student_other_details', FALSE, 'od' . $i); ?>

	<details class="sec">
		<summary><span>University responses <span class="badge"><?php echo count($a['responses']); ?></span> <span class="muted" style="font-weight:500;font-size:12.5px">read-only, iccr_university_response</span></span><i class="fa fa-angle-down"></i></summary>
		<?php if (!$a['responses']) { ?>
			<div class="sec-body muted">No university has responded to <?php echo html_escape($no); ?>.</div>
		<?php } else { ?>
		<div class="tbl-wrap"><table class="tbl">
			<thead><tr><th>ID</th><th>University</th><th>Status</th><th>Accepted</th><th>Confirmed to Mission</th><th>Student acceptance</th></tr></thead>
			<tbody><?php foreach ($a['responses'] as $r) { ?>
				<tr>
					<td class="num muted"><?php echo (int) $r['id']; ?></td>
					<td class="num"><?php echo html_escape(isset($r['regional_university']) ? $r['regional_university'] : ''); ?></td>
					<td class="num"><?php echo html_escape(isset($r['status']) ? $r['status'] : ''); ?></td>
					<td class="num"><?php echo html_escape(isset($r['university_is_accept']) ? $r['university_is_accept'] : ''); ?></td>
					<td class="num"><?php echo html_escape(isset($r['confirmed_to_mission']) ? $r['confirmed_to_mission'] : ''); ?></td>
					<td class="num"><?php echo html_escape(isset($r['scholar_acceptance']) ? $r['scholar_acceptance'] : ''); ?></td>
				</tr>
			<?php } ?></tbody>
		</table></div>
		<?php } ?>
	</details>
</div>
<?php } ?>

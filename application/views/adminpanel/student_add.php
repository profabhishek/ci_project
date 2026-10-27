<?php defined('BASEPATH') OR exit('No direct script access allowed');
$o = function ($k, $d = '') use ($old) { return isset($old[$k]) ? html_escape($old[$k]) : $d; };
?>
<div class="ap-card" style="max-width:900px">
	<div class="ap-card__head"><div><h2>Add a student</h2><p>Creates the login and registration record, the same as the public registration form. The student fills in the application form after logging in.</p></div></div>
	<?php echo form_open('adminpanel/student_create', array('data-track' => '1', 'autocomplete' => 'off')); ?>
	<div class="ap-card__body">
		<div class="fgrid fgrid--2">
			<div class="f"><label for="student_title">Title</label>
				<select class="inp" id="student_title" name="student_title"><?php foreach (array('Mr', 'Ms', 'Mrs', 'Dr') as $t) { ?><option<?php echo $o('student_title') === $t ? ' selected' : ''; ?>><?php echo $t; ?></option><?php } ?></select></div>
			<div class="f"><label for="username">First name</label><input class="inp" id="username" name="username" maxlength="50" required value="<?php echo $o('username'); ?>"></div>
			<div class="f"><label for="student_mname">Middle name</label><input class="inp" id="student_mname" name="student_mname" maxlength="50" value="<?php echo $o('student_mname'); ?>"></div>
			<div class="f"><label for="student_lname">Family name</label><input class="inp" id="student_lname" name="student_lname" maxlength="50" value="<?php echo $o('student_lname'); ?>"></div>
			<div class="f"><label for="email_id">Email (login ID)</label><input class="inp" type="email" id="email_id" name="email_id" maxlength="100" required value="<?php echo $o('email_id'); ?>"></div>
			<div class="f"><label for="mobile_no">Mobile</label><input class="inp" id="mobile_no" name="mobile_no" maxlength="20" inputmode="tel" value="<?php echo $o('mobile_no'); ?>"></div>
			<div class="f"><label for="user_country">Country</label>
				<select class="inp" id="user_country" name="user_country" required>
					<option value="">Select</option>
					<?php foreach ($countries as $c) { ?><option value="<?php echo (int) $c['id']; ?>"<?php echo $o('user_country') === (string) $c['id'] ? ' selected' : ''; ?>><?php echo html_escape($c['country_name']); ?></option><?php } ?>
				</select></div>
			<div class="f"><label for="gender">Gender</label>
				<select class="inp" id="gender" name="gender"><?php foreach (array('Male', 'Female', 'Other') as $gd) { ?><option<?php echo $o('gender') === $gd ? ' selected' : ''; ?>><?php echo $gd; ?></option><?php } ?></select></div>
			<div class="f"><label for="dob">Date of birth</label><input class="inp" type="date" id="dob" name="dob" required value="<?php echo $o('dob'); ?>"></div>
			<div class="f"><label for="passport_no">Passport number</label><input class="inp mono" id="passport_no" name="passport_no" maxlength="15" required value="<?php echo $o('passport_no'); ?>"></div>
			<div class="f"><label for="apply_course_type">Apply for</label>
				<select class="inp" id="apply_course_type" name="apply_course_type">
					<?php foreach (array(1 => 'UG (Ayush Scholarship)', 2 => 'PG (Ayush Scholarship)', 4 => 'PhD', 8 => 'PhD (Ayush Scholarship)', 12 => 'Diploma (Languages / Performing Arts)', 13 => 'Certificate (Languages / Performing Arts)') as $k => $l) { ?>
						<option value="<?php echo $k; ?>"<?php echo $o('apply_course_type') === (string) $k ? ' selected' : ''; ?>><?php echo $l; ?></option>
					<?php } ?>
				</select></div>
			<div class="f"><label for="password">Temporary password</label><input class="inp" type="password" id="password" name="password" autocomplete="new-password" required minlength="8"><span class="hint">8+ characters with upper and lower case, a number and a symbol. Share it with the student securely.</span></div>
		</div>
	</div>
	<div class="form-actions">
		<a class="btn" href="<?php echo site_url('adminpanel/students'); ?>">Cancel</a>
		<button class="btn btn-primary" type="submit"><i class="fa fa-user-plus"></i> Create student</button>
	</div>
	<?php echo form_close(); ?>
</div>

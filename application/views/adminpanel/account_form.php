<?php defined('BASEPATH') OR exit('No direct script access allowed');
$r = $row ? $row : array('id' => '', 'username' => '', 'email_id' => '', 'user_type' => isset($types[$preset_type]) ? $preset_type : 5, 'user_country' => '', 'university' => '', 'state' => '');
$g = function ($k) use ($r) { return isset($r[$k]) ? html_escape($r[$k]) : ''; };
?>
<div class="fgrid fgrid--2" style="align-items:start">
<div class="ap-card" style="margin:0">
	<div class="ap-card__head"><div><h2><?php echo $row ? 'Edit login #' . (int) $r['id'] : 'New staff login'; ?></h2><p>Staff log in on the home page with "Are you an applicant?" set to No.</p></div></div>
	<?php echo form_open('adminpanel/account_save', array('data-track' => '1', 'autocomplete' => 'off')); ?>
	<input type="hidden" name="id" value="<?php echo $g('id'); ?>">
	<div class="ap-card__body">
		<div class="fgrid fgrid--2">
			<div class="f"><label for="username">Name</label><input class="inp" id="username" name="username" maxlength="100" required value="<?php echo $g('username'); ?>"></div>
			<div class="f"><label for="email_id">Email (login ID)</label><input class="inp" type="email" id="email_id" name="email_id" maxlength="100" required value="<?php echo $g('email_id'); ?>"></div>
			<div class="f"><label for="user_type">Role</label>
				<select class="inp" id="user_type" name="user_type">
					<?php foreach ($types as $k => $l) { ?><option value="<?php echo $k; ?>"<?php echo (int) $r['user_type'] === $k ? ' selected' : ''; ?>><?php echo html_escape($l); ?></option><?php } ?>
				</select></div>
			<div class="f"><label for="user_country">Country ID (Missions)</label><input class="inp mono" id="user_country" name="user_country" inputmode="numeric" value="<?php echo $g('user_country'); ?>"><span class="hint">For Mission logins: the iccr_countries ID they handle.</span></div>
			<div class="f"><label for="university">University ID (Universities)</label><input class="inp mono" id="university" name="university" inputmode="numeric" value="<?php echo $g('university'); ?>"></div>
			<div class="f"><label for="state">Region / division ID</label><input class="inp mono" id="state" name="state" inputmode="numeric" value="<?php echo $g('state'); ?>"></div>
			<?php if (!$row) { ?>
			<div class="f full"><label for="password">Password</label><input class="inp" type="password" id="password" name="password" autocomplete="new-password" required minlength="8"><span class="hint">8+ characters with upper and lower case, a number and a symbol.</span></div>
			<?php } ?>
		</div>
	</div>
	<div class="form-actions">
		<a class="btn" href="<?php echo site_url('adminpanel/accounts') . '?type=' . (int) $r['user_type']; ?>">Cancel</a>
		<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> <?php echo $row ? 'Save changes' : 'Create login'; ?></button>
	</div>
	<?php echo form_close(); ?>
</div>

<?php if ($row) { ?>
<div class="ap-card" style="margin:0">
	<div class="ap-card__head"><div><h2>Change password</h2><p>The old password stops working immediately.</p></div></div>
	<?php echo form_open('adminpanel/account_password/' . (int) $r['id'], array('autocomplete' => 'off')); ?>
	<div class="ap-card__body fgrid">
		<div class="f"><label for="pw1">New password</label><input class="inp" type="password" id="pw1" name="password" autocomplete="new-password" required minlength="8"></div>
		<div class="f"><label for="pw2">Repeat new password</label><input class="inp" type="password" id="pw2" name="password2" autocomplete="new-password" required minlength="8"><span class="hint">8+ characters with upper and lower case, a number and a symbol.</span></div>
	</div>
	<div class="form-actions"><button class="btn btn-primary" data-confirm="Change the password for this login?"><i class="fa fa-key"></i> Change password</button></div>
	<?php echo form_close(); ?>
	<div class="ap-card__body" style="padding-top:0">
	<?php if (empty($trashed)) { $this->load->view('adminpanel/_delete', array('action' => 'adminpanel/account_delete/' . (int) $r['id'], 'what' => 'this login',
		'effect' => 'The login is switched off and can no longer sign in. Nothing it created is removed.',
		'blocked' => (int) $r['id'] === (int) $admin['userid'] ? 'You cannot delete the account you are signed in with.' : '')); } ?>
	</div>
</div>
<?php } ?>
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Admin sign-in · A2A Admin</title>
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/site/main/images/favicon.ico">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/main/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/main/css/adminpanel.css">
<style>
  body.ap-login { min-height: 100vh; display: grid; place-items: center; padding: 24px 16px;
    background: radial-gradient(1200px 600px at 10% -10%, var(--n700), transparent), linear-gradient(160deg, var(--n900), var(--n950)); }
  .login-box { width: 100%; max-width: 420px; }
  .login-brand { display: flex; align-items: center; gap: 12px; color: #fff; margin-bottom: 18px; }
  .login-brand small { display: block; color: rgba(255,255,255,.6); }
  .login-box .ap-card__body { padding: 24px; }
  .login-box h1 { font-size: 20px; margin: 0 0 4px; }
  .login-box .f { margin-bottom: 14px; }
  .cap-row { display: flex; gap: 10px; align-items: center; }
  .cap-row img { border: 1px solid var(--line); border-radius: 8px; height: 48px; width: 160px; background: var(--n50); }
  .login-foot { color: rgba(255,255,255,.55); font-size: 12.5px; text-align: center; margin-top: 16px; }
  .login-foot a { color: rgba(255,255,255,.8); }
  .btn-block { width: 100%; justify-content: center; }
</style>
</head>
<body class="ap ap-login">
<main class="login-box">
	<div class="login-brand">
		<span class="ap-brand__mark">A2A</span>
		<span><b>Admin Panel</b><small>ICCR Scholarships · restricted area</small></span>
	</div>
	<div class="ap-card">
		<div class="ap-card__body">
			<h1>Admin sign-in</h1>
			<p class="muted" style="margin:0 0 18px">For Super Admin accounts only. This is separate from the portal login.</p>

			<?php if (empty($setup)) { ?>
			<div class="ap-alert ap-alert--warn" role="alert"><i class="fa fa-exclamation-triangle"></i>
				<div><b>Setup needed.</b> Run <span class="mono">application/sql/adminpanel_security_local.sql</span> once on this database.</div></div>
			<?php } ?>
			<?php if (!empty($msg)) { ?>
			<div class="ap-alert ap-alert--error" role="alert"><i class="fa fa-exclamation-circle"></i><div><?php echo html_escape($msg); ?></div></div>
			<?php } elseif (!empty($msg_ok)) { ?>
			<div class="ap-alert ap-alert--info" role="status"><i class="fa fa-info-circle"></i><div><?php echo html_escape($msg_ok); ?></div></div>
			<?php } ?>

			<?php echo form_open('adminlogin', array('id' => 'apLogin', 'autocomplete' => 'off', 'novalidate' => 'novalidate')); ?>
				<input type="hidden" name="pass_hash" id="pass_hash" value="">
				<div class="f">
					<label for="email">Email</label>
					<input class="inp" type="email" id="email" name="email" required maxlength="150" autocomplete="username" value="<?php echo html_escape($email); ?>">
				</div>
				<div class="f">
					<label for="pw">Password</label>
					<!-- no name attribute: the plain password is never sent -->
					<input class="inp" type="password" id="pw" required autocomplete="current-password">
				</div>
				<div class="f">
					<label for="captcha">Security code</label>
					<div class="cap-row">
						<img id="capImg" src="<?php echo site_url('adminlogin/captcha') . '?t=' . time(); ?>" alt="Security code picture" width="160" height="48">
						<button type="button" class="btn btn-sm" id="capNew" aria-label="Show a new code"><i class="fa fa-refresh"></i></button>
					</div>
					<input class="inp" id="captcha" name="captcha" required maxlength="6" autocomplete="off" style="margin-top:8px;text-transform:uppercase" placeholder="Type the 6 characters">
				</div>
				<div class="ap-alert ap-alert--error" id="jsErr" role="alert" style="display:none"><i class="fa fa-exclamation-circle"></i><div></div></div>
				<button class="btn btn-primary btn-block" type="submit"><i class="fa fa-lock"></i> Sign in</button>
			<?php echo form_close(); ?>
		</div>
	</div>
	<p class="login-foot">5 wrong tries lock sign-in for 15 minutes. The session ends after 15 minutes without activity.<br><a href="<?php echo site_url(); ?>">Back to the website</a></p>
</main>
<script>
/* SHA-1 (hex) - small public-domain implementation, so the plain password never leaves the browser. */
function sha1(msg) {
	function rotl(n, s) { return (n << s) | (n >>> (32 - s)); }
	function hex(v) { var s = '', i; for (i = 7; i >= 0; i--) { s += ((v >>> (i * 4)) & 0x0f).toString(16); } return s; }
	msg = unescape(encodeURIComponent(msg));
	var words = [], i, len = msg.length;
	for (i = 0; i < len - 3; i += 4) { words.push(msg.charCodeAt(i) << 24 | msg.charCodeAt(i + 1) << 16 | msg.charCodeAt(i + 2) << 8 | msg.charCodeAt(i + 3)); }
	var r = len % 4, t;
	if (r === 0) { t = 0x080000000; }
	else if (r === 1) { t = msg.charCodeAt(len - 1) << 24 | 0x0800000; }
	else if (r === 2) { t = msg.charCodeAt(len - 2) << 24 | msg.charCodeAt(len - 1) << 16 | 0x08000; }
	else { t = msg.charCodeAt(len - 3) << 24 | msg.charCodeAt(len - 2) << 16 | msg.charCodeAt(len - 1) << 8 | 0x80; }
	words.push(t);
	while ((words.length % 16) !== 14) { words.push(0); }
	words.push(len >>> 29); words.push((len << 3) & 0x0ffffffff);
	var H0 = 0x67452301, H1 = 0xEFCDAB89, H2 = 0x98BADCFE, H3 = 0x10325476, H4 = 0xC3D2E1F0, W = new Array(80), A, B, C, D, E, temp, blk, j;
	for (blk = 0; blk < words.length; blk += 16) {
		for (j = 0; j < 16; j++) { W[j] = words[blk + j]; }
		for (j = 16; j <= 79; j++) { W[j] = rotl(W[j - 3] ^ W[j - 8] ^ W[j - 14] ^ W[j - 16], 1); }
		A = H0; B = H1; C = H2; D = H3; E = H4;
		for (j = 0; j <= 79; j++) {
			var f, k;
			if (j < 20) { f = (B & C) | (~B & D); k = 0x5A827999; }
			else if (j < 40) { f = B ^ C ^ D; k = 0x6ED9EBA1; }
			else if (j < 60) { f = (B & C) | (B & D) | (C & D); k = 0x8F1BBCDC; }
			else { f = B ^ C ^ D; k = 0xCA62C1D6; }
			temp = (rotl(A, 5) + f + E + k + W[j]) & 0x0ffffffff;
			E = D; D = C; C = rotl(B, 30); B = A; A = temp;
		}
		H0 = (H0 + A) & 0x0ffffffff; H1 = (H1 + B) & 0x0ffffffff; H2 = (H2 + C) & 0x0ffffffff; H3 = (H3 + D) & 0x0ffffffff; H4 = (H4 + E) & 0x0ffffffff;
	}
	return (hex(H0) + hex(H1) + hex(H2) + hex(H3) + hex(H4)).toLowerCase();
}
(function () {
	var salt = <?php echo json_encode($salt); ?>;
	var form = document.getElementById('apLogin'), pw = document.getElementById('pw'), err = document.getElementById('jsErr');
	function show(m) { err.querySelector('div').textContent = m; err.style.display = ''; }
	form.addEventListener('submit', function (e) {
		var email = document.getElementById('email').value.trim(), cap = document.getElementById('captcha').value.trim();
		if (!email || !pw.value || !cap) { e.preventDefault(); show('Please fill in email, password and the security code.'); return; }
		document.getElementById('pass_hash').value = sha1(sha1(pw.value) + salt);
		pw.value = '';
	});
	document.getElementById('capNew').addEventListener('click', function () {
		fetch(<?php echo json_encode(site_url('adminlogin/captcha_refresh')); ?>, { credentials: 'same-origin' })
			.then(function () { document.getElementById('capImg').src = <?php echo json_encode(site_url('adminlogin/captcha')); ?> + '?t=' + Date.now(); });
	});
	document.getElementById(document.getElementById('email').value ? 'pw' : 'email').focus();
})();
</script>
</body>
</html>

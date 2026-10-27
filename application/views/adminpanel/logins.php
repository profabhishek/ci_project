<?php defined('BASEPATH') OR exit('No direct script access allowed');
$why = array('ok' => 'Signed in', 'password' => 'Wrong password', 'unknown_or_not_admin' => 'Unknown email or not a Super Admin',
             'captcha' => 'Wrong security code', 'locked' => 'Blocked: too many tries', 'bad_input' => 'Incomplete form');
?>
<div class="ap-card">
	<div class="ap-card__head">
		<div><h2>Sign-in attempts</h2><p>The last 100 attempts on the Admin Panel sign-in page. 5 failures for one email or one IP within 15 minutes lock sign-in for 15 minutes.</p></div>
	</div>
	<?php if (!$ready) { ?>
		<div class="empty">Run <span class="mono">application/sql/adminpanel_security_local.sql</span> to start recording sign-ins.</div>
	<?php } elseif (!$rows) { ?>
		<div class="empty">No sign-in attempts yet.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>When</th><th>Email</th><th>Result</th><th>IP address</th><th>Browser</th></tr></thead>
		<tbody>
		<?php foreach ($rows as $r) { ?>
			<tr>
				<td class="muted"><?php echo html_escape($r['created_at']); ?></td>
				<td><?php echo html_escape($r['email']); ?></td>
				<td><?php echo (int) $r['success'] ? '<span class="badge badge--ok">Signed in</span>' : '<span class="badge badge--err">' . html_escape(isset($why[$r['reason']]) ? $why[$r['reason']] : $r['reason']) . '</span>'; ?></td>
				<td class="mono"><?php echo html_escape($r['ip_address']); ?></td>
				<td class="muted" style="max-width:320px;font-size:12px"><?php echo html_escape(mb_strimwidth((string) $r['user_agent'], 0, 90, '…')); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php } ?>
</div>

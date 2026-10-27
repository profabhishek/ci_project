<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * "Move to Trash" box. Params: $action (URL), $what (e.g. "this student"), $effect (one sentence), $blocked (optional reason it cannot be deleted)
 */
?>
<details class="sec" style="margin-top:16px">
	<summary><span style="color:var(--err)"><i class="fa fa-trash-o"></i> Delete <span class="muted" style="font-weight:500;font-size:12.5px">moves it to Trash; it can be restored</span></span><i class="fa fa-angle-down"></i></summary>
	<?php if (!empty($blocked)) { ?>
		<div class="sec-body muted"><?php echo html_escape($blocked); ?></div>
	<?php } else { echo form_open($action); ?>
		<div class="sec-body">
			<p style="margin-top:0"><?php echo html_escape($effect); ?></p>
			<div class="f"><label for="del_reason">Reason (saved in the audit log)</label>
				<input class="inp" id="del_reason" name="reason" maxlength="255" required placeholder="e.g. duplicate registration"></div>
		</div>
		<div class="form-actions">
			<button class="btn btn-danger" type="submit" data-confirm="Move <?php echo html_escape($what); ?> to Trash?"><i class="fa fa-trash-o"></i> Move to Trash</button>
		</div>
	<?php echo form_close(); } ?>
</details>

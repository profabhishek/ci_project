<?php defined('BASEPATH') OR exit('No direct script access allowed');
$r = $row ? $row : array('id' => '', 'title' => '', 'validated_upto' => date('Y-m-d', strtotime('+30 days')), 'status' => '0', 'notification_doc' => '');
$is_live = $row && (string) $r['status'] !== '0';
?>
<div class="ap-card" style="max-width:820px">
	<div class="ap-card__head"><div><h2><?php echo $row ? 'Edit announcement #' . (int) $r['id'] : 'New announcement'; ?></h2><p>Keep it short. It scrolls across the home page.</p></div></div>
	<?php echo form_open_multipart('adminpanel/announcement_save', array('data-track' => '1')); ?>
	<input type="hidden" name="id" value="<?php echo html_escape($r['id']); ?>">
	<div class="ap-card__body">
		<?php if ($is_live) { ?>
		<div class="ap-alert ap-alert--warn"><i class="fa fa-exclamation-triangle"></i>
			<div><b>This announcement is live.</b> Saving takes it off the home page as a draft until you check the preview and publish it again.</div></div>
		<?php } else { ?>
		<div class="ap-alert ap-alert--info"><i class="fa fa-info-circle"></i>
			<div>Saving keeps it as a <b>draft</b>. You will see a preview next, and it goes on the home page only when you confirm <b>Publish</b>.</div></div>
		<?php } ?>
		<div class="fgrid fgrid--2">
			<div class="f full">
				<label for="title">Title</label>
				<textarea class="inp" id="title" name="title" rows="2" maxlength="500" required><?php echo html_escape($r['title']); ?></textarea>
			</div>
			<div class="f">
				<label for="validated_upto">Show until</label>
				<input class="inp" type="date" id="validated_upto" name="validated_upto" value="<?php echo html_escape($r['validated_upto']); ?>" required>
				<span class="hint">It disappears from the home page after this date.</span>
			</div>
			<div class="f full">
				<label for="notification_doc">Attachment (optional PDF, max 5 MB)</label>
				<input class="inp" type="file" id="notification_doc" name="notification_doc" accept="application/pdf" style="padding-top:6px">
				<?php if (!empty($r['notification_doc'])) { ?>
					<span class="hint">Current file: <a href="<?php echo base_url('assets/site/main/notification/' . rawurlencode($r['notification_doc'])); ?>" target="_blank" rel="noopener"><?php echo html_escape($r['notification_doc']); ?></a>. Choose a new file only to replace it.</span>
					<label class="chk" style="margin-top:6px"><input type="checkbox" name="remove_doc" value="1"> Remove the attachment</label>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<a class="btn" href="<?php echo site_url('adminpanel/announcements'); ?>">Cancel</a>
		<button class="btn btn-primary" type="submit"><i class="fa fa-eye"></i> Save draft &amp; preview</button>
	</div>
	<?php echo form_close(); ?>
</div>

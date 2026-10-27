<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-card">
	<div class="ap-card__head"><div><h2>Gyan Setu export</h2><p>Same data and column order as the Gyan Setu API. Leave the box empty to export every confirmed student of the year.</p></div></div>
	<form method="get" action="<?php echo site_url('adminpanel/gyansetu'); ?>" autocomplete="off">
	<div class="ap-card__body">
		<div class="fgrid fgrid--2">
			<div class="f"><label for="gs_year">Year</label>
				<input class="inp mono" id="gs_year" name="year" inputmode="numeric" maxlength="4" required value="<?php echo html_escape($year); ?>">
				<span class="hint">The same year used in the API link, e.g. 2026.</span></div>
			<div class="f"><label for="gs_format">File type</label>
				<select class="inp" id="gs_format" name="format">
					<option value="xlsx"<?php echo $format === 'xlsx' ? ' selected' : ''; ?>>Excel (.xlsx)</option>
					<option value="csv"<?php echo $format === 'csv' ? ' selected' : ''; ?>>CSV (faster for the full list)</option>
				</select></div>
			<div class="f full"><label for="gs_ids">Application numbers (optional)</label>
				<textarea class="inp mono" id="gs_ids" name="ids" rows="4" placeholder="CJ1405794280170&#10;ZO8557799736020"><?php echo html_escape($ids_text); ?></textarea>
				<span class="hint">One per line, or separated by commas or spaces. Empty = all students.</span></div>
			<div class="f full"><label class="chk"><input type="checkbox" name="hide" value="1"<?php echo $hide ? ' checked' : ''; ?>> Leave out passport, phone and place of birth</label>
				<span class="hint">Tick this when the file does not need personal details. Every download is recorded in the audit log.</span></div>
		</div>
	</div>
	<div class="form-actions">
		<button class="btn" type="submit" name="do" value="preview"><i class="fa fa-eye"></i> Preview</button>
		<button class="btn btn-primary" type="submit" name="do" value="download"><i class="fa fa-download"></i> Download</button>
	</div>
	</form>
</div>

<?php if ($rows !== NULL) { ?>
<div class="ap-card">
	<div class="ap-card__head"><div><h2><?php echo count($rows); ?> student<?php echo count($rows) === 1 ? '' : 's'; ?> found</h2>
		<p><?php echo count($rows) > 50 ? 'Showing the first 50. The download has all of them.' : 'This is what the download will contain.'; ?></p></div></div>
	<?php if ($missing) { ?>
	<div class="ap-alert ap-alert--warn"><i class="fa fa-exclamation-triangle"></i><div><b>Not in the export:</b> <span class="mono"><?php echo html_escape(implode(', ', $missing)); ?></span>.
		The API only includes confirmed students (not withdrawn) of the chosen year.</div></div>
	<?php } ?>
	<?php if ($rows) { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><?php foreach ($columns as $c) { ?><th style="white-space:nowrap"><?php echo html_escape($c); ?></th><?php } ?></tr></thead>
		<tbody>
		<?php foreach (array_slice($rows, 0, 50) as $r) { ?>
			<tr><?php foreach ($columns as $c) { ?><td style="white-space:nowrap"><?php echo html_escape((string) $r[$c]); ?></td><?php } ?></tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php } else { ?>
		<div class="empty">No students match.</div>
	<?php } ?>
</div>
<?php } ?>

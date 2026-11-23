<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-card">
	<div class="ap-card__head"><div><h2><?php echo html_escape($def['title']); ?></h2><p><?php echo html_escape($def['desc']); ?></p></div>
		<a class="btn btn-sm" href="<?php echo site_url('adminpanel/reports'); ?>"><i class="fa fa-angle-left"></i> All reports</a></div>
	<form method="get" action="<?php echo site_url('adminpanel/report/' . $key); ?>" autocomplete="off">
	<div class="ap-card__body">
		<div class="fgrid fgrid--2">
		<?php foreach ($fields as $f) { $n = $f['name']; $v = isset($p[$n]) ? $p[$n] : (isset($f['default']) ? $f['default'] : ''); ?>
			<?php if ($f['type'] === 'select') { ?>
			<div class="f"><label for="f_<?php echo $n; ?>"><?php echo html_escape($f['label']); ?></label>
				<select class="inp" id="f_<?php echo $n; ?>" name="<?php echo $n; ?>">
				<?php foreach ($f['options'] as $ov => $ol) { ?>
					<option value="<?php echo html_escape($ov); ?>"<?php echo ((string) $v === (string) $ov) ? ' selected' : ''; ?>><?php echo html_escape($ol); ?></option>
				<?php } ?>
				</select>
				<?php if (!empty($f['hint'])) { ?><span class="hint"><?php echo html_escape($f['hint']); ?></span><?php } ?></div>
			<?php } elseif ($f['type'] === 'number') { ?>
			<div class="f"><label for="f_<?php echo $n; ?>"><?php echo html_escape($f['label']); ?></label>
				<input class="inp mono" id="f_<?php echo $n; ?>" name="<?php echo $n; ?>" inputmode="numeric" maxlength="2" value="<?php echo html_escape($v); ?>">
				<?php if (!empty($f['hint'])) { ?><span class="hint"><?php echo html_escape($f['hint']); ?></span><?php } ?></div>
			<?php } elseif ($f['type'] === 'check') { ?>
			<div class="f full"><label class="chk"><input type="checkbox" name="<?php echo $n; ?>" value="1"<?php echo $v ? ' checked' : ''; ?>> <?php echo html_escape($f['label']); ?></label>
				<?php if (!empty($f['hint'])) { ?><span class="hint"><?php echo html_escape($f['hint']); ?></span><?php } ?></div>
			<?php } elseif ($f['type'] === 'textarea') { ?>
			<div class="f full"><label for="f_<?php echo $n; ?>"><?php echo html_escape($f['label']); ?></label>
				<textarea class="inp mono" id="f_<?php echo $n; ?>" name="<?php echo $n; ?>" rows="4" placeholder="CJ1405794280170&#10;ZO8557799736020"><?php echo html_escape(isset($p[$n . '_text']) ? $p[$n . '_text'] : ''); ?></textarea>
				<?php if (!empty($f['hint'])) { ?><span class="hint"><?php echo html_escape($f['hint']); ?></span><?php } ?></div>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
	<div class="form-actions">
		<button class="btn" type="submit" name="do" value="preview"><i class="fa fa-eye"></i> Preview</button>
		<button class="btn btn-primary" type="submit" name="do" value="xlsx"><i class="fa fa-file-excel-o"></i> Excel</button>
		<button class="btn" type="submit" name="do" value="csv"><i class="fa fa-file-text-o"></i> CSV</button>
		<button class="btn" type="submit" name="do" value="print" formtarget="_blank"><i class="fa fa-file-pdf-o"></i> PDF (print view)</button>
	</div>
	</form>
</div>

<?php if (!empty($error)) { ?>
<div class="ap-alert ap-alert--error" role="alert"><i class="fa fa-exclamation-circle"></i><div><?php echo html_escape($error); ?></div></div>
<?php } ?>

<?php if (!empty($report)) { ?>
<div class="ap-card">
	<div class="ap-card__head"><div><h2><?php echo html_escape($report['title']); ?></h2>
		<p><?php echo html_escape($report['subtitle']); ?> <?php echo html_escape($report['params_text']); ?></p></div></div>
</div>
<?php foreach ($report['sections'] as $s) { ?>
<div class="ap-card">
	<div class="ap-card__head"><div><h2><?php echo html_escape($s['title']); ?> <small class="muted">(<?php echo count($s['rows']); ?>)</small></h2>
		<?php if (!empty($s['note'])) { ?><p><?php echo html_escape($s['note']); ?></p><?php } ?></div></div>
	<?php if (!$s['rows']) { ?><div class="empty">Nothing to show.</div><?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><?php foreach ($s['columns'] as $c) { ?><th style="white-space:nowrap"><?php echo html_escape($c); ?></th><?php } ?></tr></thead>
		<tbody>
		<?php foreach (array_slice($s['rows'], 0, $preview_rows) as $row) { ?>
			<tr><?php foreach ($s['columns'] as $i => $c) { ?><td><?php echo html_escape(isset($row[$i]) ? (string) $row[$i] : ''); ?></td><?php } ?></tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php if (count($s['rows']) > $preview_rows) { ?><div class="hint" style="padding:8px 16px">Showing the first <?php echo (int) $preview_rows; ?> rows. The downloads have all <?php echo count($s['rows']); ?>.</div><?php } ?>
	<?php } ?>
</div>
<?php } } ?>

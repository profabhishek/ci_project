<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * One form field built from column metadata.
 * Expects: $c (column info), $val (current value), $ro (bool readonly), optional $hint_map (code => meaning)
 */
$fid = 'f_' . preg_replace('/[^a-z0-9_]/i', '_', (isset($prefix) ? $prefix : '') . $c['name']);
$nm = 'fields[' . $c['name'] . ']';
$v = $val === NULL ? '' : (string) $val;
$is_null = ($val === NULL);
$hint_map = isset($hint_map) && is_array($hint_map) ? $hint_map : array();
?>
<div class="f<?php echo ($c['base'] === 'text' && !$ro) ? ' full' : ''; ?>">
	<label for="<?php echo $fid; ?>"><?php echo html_escape($c['name']); ?>
		<?php if ($ro) { ?><span class="badge badge--off" style="height:18px;font-size:10.5px">read-only</span><?php } ?>
	</label>
	<?php if ($ro) { ?>
		<input class="inp mono" id="<?php echo $fid; ?>" value="<?php echo $is_null ? 'NULL' : html_escape($v); ?>" readonly>
	<?php } elseif ($c['base'] === 'enum') { ?>
		<select class="inp" id="<?php echo $fid; ?>" name="<?php echo $nm; ?>">
			<?php if ($c['nullable']) { ?><option value=""<?php echo $is_null ? ' selected' : ''; ?>>(empty)</option><?php } ?>
			<?php foreach ($c['options'] as $o) { ?><option value="<?php echo html_escape($o); ?>"<?php echo $v === $o ? ' selected' : ''; ?>><?php echo html_escape($o); ?></option><?php } ?>
		</select>
	<?php } elseif ($c['base'] === 'text') { ?>
		<textarea class="inp" id="<?php echo $fid; ?>" name="<?php echo $nm; ?>" rows="3"><?php echo html_escape($v); ?></textarea>
	<?php } else {
		$type = 'text'; $extra = '';
		if ($c['base'] === 'int') { $type = 'text'; $extra = ' inputmode="numeric" pattern="-?[0-9]*"'; }
		elseif ($c['base'] === 'decimal') { $extra = ' inputmode="decimal"'; }
		elseif ($c['base'] === 'date') { $type = 'date'; }
		if ($c['length'] && in_array($c['base'], array('string'), TRUE)) { $extra .= ' maxlength="' . (int) $c['length'] . '"'; }
		$list = $hint_map ? ' list="' . $fid . '_list"' : '';
	?>
		<input class="inp<?php echo in_array($c['base'], array('int', 'decimal'), TRUE) ? ' mono' : ''; ?>" type="<?php echo $type; ?>" id="<?php echo $fid; ?>" name="<?php echo $nm; ?>" value="<?php echo html_escape($v); ?>"<?php echo $extra . $list; ?><?php echo $is_null ? ' placeholder="NULL"' : ''; ?>>
		<?php if ($hint_map) { ?>
		<datalist id="<?php echo $fid; ?>_list"><?php foreach ($hint_map as $code => $meaning) { ?><option value="<?php echo html_escape($code); ?>"><?php echo html_escape($meaning); ?></option><?php } ?></datalist>
		<?php } ?>
	<?php } ?>
	<?php if ($hint_map && isset($hint_map[$v])) { ?>
		<span class="hint"><i class="fa fa-info-circle"></i> <?php echo html_escape($v . ' = ' . $hint_map[$v]); ?></span>
	<?php } elseif (!empty($c['comment'])) { ?>
		<span class="hint"><?php echo html_escape($c['comment']); ?></span>
	<?php } ?>
</div>

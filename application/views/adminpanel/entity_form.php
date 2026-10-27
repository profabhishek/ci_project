<?php defined('BASEPATH') OR exit('No direct script access allowed');
$id = $row ? $row[$pk] : '';
?>
<div class="ap-card">
	<div class="ap-card__head">
		<div><h2><?php echo $row ? 'Edit ' . strtolower($e['single']) . ' #' . html_escape($id) : 'Add ' . strtolower($e['single']); ?></h2>
		<p>Fields come straight from the <span class="mono"><?php echo html_escape($e['table']); ?></span> table. Changes are logged.</p></div>
		<div class="btn-group">
			<?php if ($row) { ?><a class="btn btn-sm" href="<?php echo site_url('adminpanel/audit') . '?table=' . rawurlencode($e['table']) . '&record=' . rawurlencode($id); ?>"><i class="fa fa-history"></i> History</a><?php } ?>
			<a class="btn btn-sm" href="<?php echo site_url('adminpanel/entity/' . $name); ?>"><i class="fa fa-angle-left"></i> Back to list</a>
		</div>
	</div>
	<?php echo form_open('adminpanel/entity_save/' . $name, array('data-track' => '1')); ?>
	<input type="hidden" name="id" value="<?php echo html_escape($id); ?>">
	<div class="ap-card__body">
		<?php if (count($all) > 12) { ?><input class="inp field-filter" style="margin-bottom:14px" placeholder="Find a field…" data-field-filter="entbox" aria-label="Find a field"><?php } ?>
		<div class="fgrid" id="entbox">
		<?php foreach ($all as $n => $c) {
			if (!$row && !isset($cols[$n])) { continue; } // hide id/created on add
			$this->load->view('adminpanel/_field', array('c' => $c, 'val' => $row ? $row[$n] : $c['default'], 'ro' => !isset($cols[$n]), 'prefix' => 'e_', 'hint_map' => array()));
		} ?>
		</div>
	</div>
	<div class="form-actions">
		<a class="btn" href="<?php echo site_url('adminpanel/entity/' . $name); ?>">Cancel</a>
		<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Save <?php echo strtolower($e['single']); ?></button>
	</div>
	<?php echo form_close(); ?>
</div>
<?php if ($row && empty($trashed)) { ?>
<div class="ap-card"><div class="ap-card__body">
<?php $this->load->view('adminpanel/_delete', array('action' => 'adminpanel/entity_delete/' . $name . '/' . rawurlencode($id), 'what' => 'this ' . strtolower($e['single']),
	'effect' => 'It is switched off (status 0) and hidden from this list. Students and applications linked to it are not changed.')); ?>
</div></div>
<?php } ?>

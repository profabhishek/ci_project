<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ap-card">
	<div class="ap-card__head">
		<form class="ap-toolbar" method="get" action="<?php echo site_url('adminpanel/entity/' . $name); ?>">
			<label class="ap-search"><span class="sr-only">Search</span><i class="fa fa-search"></i>
				<input class="inp" name="q" value="<?php echo html_escape($q); ?>" placeholder="Search <?php echo strtolower($e['title']); ?> by name or ID"></label>
			<button class="btn" type="submit">Search</button>
			<?php if ($q !== '') { ?><a class="btn" href="<?php echo site_url('adminpanel/entity/' . $name); ?>">Clear</a><?php } ?>
		</form>
		<a class="btn btn-primary" href="<?php echo site_url('adminpanel/entity_edit/' . $name); ?>"><i class="fa fa-plus"></i> Add <?php echo strtolower($e['single']); ?></a>
	</div>
	<?php if (!$rows) { ?>
		<div class="empty">Nothing found.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><?php foreach ($list as $c) { ?><th><?php echo html_escape(str_replace('_', ' ', $c)); ?></th><?php } ?><th class="actions">Actions</th></tr></thead>
		<tbody>
		<?php foreach ($rows as $r) { ?>
			<tr>
				<?php foreach ($list as $c) { $v = $r[$c]; ?>
					<td<?php echo is_numeric($v) ? ' class="num"' : ''; ?>>
						<?php if ($c === 'status') { echo (string) $v === '1' ? '<span class="badge badge--ok">Active</span>' : '<span class="badge badge--off">' . html_escape($v === NULL ? 'NULL' : $v) . '</span>'; }
						else { echo html_escape(mb_strimwidth((string) $v, 0, 70, '…')); } ?>
					</td>
				<?php } ?>
				<td class="actions">
					<a class="btn btn-sm" href="<?php echo site_url('adminpanel/entity_edit/' . $name . '/' . rawurlencode($r[$pk])); ?>"><i class="fa fa-pencil"></i> Edit</a>
					<?php if ($has_status) { echo form_open('adminpanel/entity_status/' . $name . '/' . rawurlencode($r[$pk]), array('class' => 'inline')); ?>
						<button class="btn btn-sm" data-confirm="<?php echo (string) $r['status'] === '1' ? 'Deactivate this ' . strtolower($e['single']) . '? It may disappear from lists and dropdowns.' : 'Activate this ' . strtolower($e['single']) . '?'; ?>"><?php echo (string) $r['status'] === '1' ? 'Deactivate' : 'Activate'; ?></button>
					<?php echo form_close(); } ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php $this->load->view('adminpanel/_pager', array('pager' => $pager, 'base' => 'adminpanel/entity/' . $name, 'params' => array('q' => $q))); ?>
	<?php } ?>
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed');
$vis = array('all' => 'Everyone', 'guest' => 'Logged out', 'user' => 'Logged in');
$groups = array(1 => 'About Us pages', 3 => 'Instructions pages', 4 => 'FAQ pages', 0 => 'Footer pages');
$sections = array('main' => 'Main menu', 'action' => 'Buttons on the right');
?>
<div class="ap-alert ap-alert--info"><i class="fa fa-info-circle"></i>
	<div>This list controls the menu in the website header. Items can sit inside other items (up to 3 levels). Use the arrows to change the order.
	If the list is empty, the header shows its built-in default menu.</div></div>

<?php foreach ($sections as $pos => $label) {
	$list = array_values(array_filter($rows, function ($r) use ($pos) { return $r['position'] === $pos; })); ?>
<div class="ap-card">
	<div class="ap-card__head">
		<div><h2><?php echo $label; ?></h2><p><?php echo $pos === 'main' ? 'The navy menu bar.' : 'Shown as buttons next to Login (for example Alumni).'; ?></p></div>
		<a class="btn btn-primary" href="<?php echo site_url('adminpanel/nav_edit') . ($pos === 'action' ? '?position=action' : ''); ?>"><i class="fa fa-plus"></i> Add item</a>
	</div>
	<?php if (!$list) { ?>
		<div class="empty">No items.</div>
	<?php } else { ?>
	<div class="tbl-wrap"><table class="tbl">
		<thead><tr><th>Title</th><th>Link</th><th>Who sees it</th><th>Status</th><th class="actions">Actions</th></tr></thead>
		<tbody>
		<?php foreach ($list as $r) { ?>
			<tr>
				<td>
					<?php for ($i = 0; $i < $r['depth']; $i++) { ?><span class="tree-indent"><?php echo $i === $r['depth'] - 1 ? '└' : ''; ?></span><?php } ?>
					<?php if ($r['icon']) { ?><i class="fa <?php echo html_escape($r['icon']); ?> muted"></i><?php } ?>
					<b><?php echo html_escape($r['title']); ?></b>
					<?php if ($r['child_count']) { ?><span class="badge" title="Items inside"><?php echo (int) $r['child_count']; ?> inside</span><?php } ?>
					<?php if ($r['page_group'] !== NULL && $r['page_group'] !== '') { ?><span class="badge badge--gold" title="Also lists CMS pages">+ <?php echo html_escape(isset($groups[(int) $r['page_group']]) ? $groups[(int) $r['page_group']] : 'page group ' . $r['page_group']); ?></span><?php } ?>
				</td>
				<td class="mono muted" style="max-width:320px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?php echo $r['url'] === '#' ? '<span class="muted">(dropdown only)</span>' : html_escape($r['url'] === '' ? '(home page)' : $r['url']); ?><?php echo $r['new_tab'] ? ' <i class="fa fa-external-link" title="Opens in new tab"></i>' : ''; ?></td>
				<td><?php echo html_escape($vis[$r['visibility']]); ?></td>
				<td><?php echo $r['is_active'] ? '<span class="badge badge--ok">Shown</span>' : '<span class="badge badge--off">Hidden</span>'; ?></td>
				<td class="actions">
					<?php echo form_open('adminpanel/nav_move/' . (int) $r['id'] . '/up', array('class' => 'inline')); ?><button class="btn btn-sm btn-icon" title="Move up" aria-label="Move up"><i class="fa fa-arrow-up"></i></button><?php echo form_close(); ?>
					<?php echo form_open('adminpanel/nav_move/' . (int) $r['id'] . '/down', array('class' => 'inline')); ?><button class="btn btn-sm btn-icon" title="Move down" aria-label="Move down"><i class="fa fa-arrow-down"></i></button><?php echo form_close(); ?>
					<?php if ($r['depth'] < 2) { ?><a class="btn btn-sm" href="<?php echo site_url('adminpanel/nav_edit') . '?parent=' . (int) $r['id']; ?>" title="Add an item inside this one"><i class="fa fa-plus"></i> Child</a><?php } ?>
					<a class="btn btn-sm" href="<?php echo site_url('adminpanel/nav_edit/' . (int) $r['id']); ?>"><i class="fa fa-pencil"></i> Edit</a>
					<?php echo form_open('adminpanel/nav_toggle/' . (int) $r['id'], array('class' => 'inline')); ?><button class="btn btn-sm"><?php echo $r['is_active'] ? 'Hide' : 'Show'; ?></button><?php echo form_close(); ?>
					<?php echo form_open('adminpanel/nav_delete/' . (int) $r['id'], array('class' => 'inline')); ?><button class="btn btn-sm btn-danger btn-icon" data-confirm="Delete &quot;<?php echo html_escape($r['title']); ?>&quot; from the menu?" title="Delete" aria-label="Delete"><i class="fa fa-trash"></i></button><?php echo form_close(); ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>
	<?php } ?>
</div>
<?php } ?>

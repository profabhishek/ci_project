<?php defined('BASEPATH') OR exit('No direct script access allowed');
$pos_q = $this->input->get('position') === 'action' ? 'action' : 'main';
$r = $row ? $row : array('id' => '', 'parent_id' => $preset_parent ? $preset_parent : NULL, 'title' => '', 'subtitle' => '', 'url' => '', 'icon' => '',
	'position' => $pos_q, 'visibility' => 'all', 'page_group' => NULL, 'new_tab' => 0, 'sort_order' => 100, 'is_active' => 1);
?>
<div class="ap-card" style="max-width:900px">
	<div class="ap-card__head"><div><h2><?php echo $row ? 'Edit menu item' : 'New menu item'; ?></h2><p>Changes show in the website header straight away.</p></div></div>
	<?php echo form_open('adminpanel/nav_save', array('data-track' => '1')); ?>
	<input type="hidden" name="id" value="<?php echo html_escape($r['id']); ?>">
	<div class="ap-card__body">
		<div class="fgrid fgrid--2">
			<div class="f">
				<label for="title">Title</label>
				<input class="inp" id="title" name="title" maxlength="150" required value="<?php echo html_escape($r['title']); ?>">
			</div>
			<div class="f">
				<label for="parent_id">Place inside</label>
				<select class="inp" id="parent_id" name="parent_id">
					<option value="">(Top level)</option>
					<?php foreach ($parents as $p) { if ($p['depth'] >= 2) { continue; } ?>
						<option value="<?php echo (int) $p['id']; ?>"<?php echo (string) $r['parent_id'] === (string) $p['id'] ? ' selected' : ''; ?>><?php echo str_repeat('— ', $p['depth']) . html_escape($p['title']) . ($p['position'] === 'action' ? ' (button)' : ''); ?></option>
					<?php } ?>
				</select>
				<span class="hint">Choose a parent to make this a dropdown item.</span>
			</div>
			<div class="f full">
				<label for="url">Link</label>
				<input class="inp mono" id="url" name="url" maxlength="500" value="<?php echo html_escape($r['url']); ?>" placeholder="home/contactus">
				<span class="hint">Portal page: <span class="mono">home/contactus</span> · File: <span class="mono">assets/site/docs/x.pdf</span> · Other site: <span class="mono">https://…</span> · Dropdown only: <span class="mono">#</span> · Logged-in dashboard: <span class="mono">{dashboard}</span> · Empty = home page</span>
			</div>
			<div class="f">
				<label for="subtitle">Small text under the title (dropdown items)</label>
				<input class="inp" id="subtitle" name="subtitle" maxlength="150" value="<?php echo html_escape($r['subtitle']); ?>" placeholder="PDF · 35 KB">
			</div>
			<div class="f">
				<label for="icon">Icon (optional)</label>
				<input class="inp mono" id="icon" name="icon" maxlength="60" value="<?php echo html_escape($r['icon']); ?>" placeholder="fa-file-pdf-o">
				<span class="hint">A Font Awesome 4 name, e.g. fa-file-pdf-o, fa-calendar, fa-book.</span>
			</div>
			<div class="f">
				<label for="visibility">Who sees it</label>
				<select class="inp" id="visibility" name="visibility">
					<?php foreach (array('all' => 'Everyone', 'guest' => 'Only when logged out', 'user' => 'Only when logged in') as $k => $l) { ?>
						<option value="<?php echo $k; ?>"<?php echo $r['visibility'] === $k ? ' selected' : ''; ?>><?php echo $l; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="f">
				<label for="position">Where (top level only)</label>
				<select class="inp" id="position" name="position">
					<option value="main"<?php echo $r['position'] === 'main' ? ' selected' : ''; ?>>Main menu bar</option>
					<option value="action"<?php echo $r['position'] === 'action' ? ' selected' : ''; ?>>Button on the right</option>
				</select>
				<span class="hint">Items inside another item follow their parent.</span>
			</div>
			<div class="f">
				<label for="page_group">Also list CMS pages from</label>
				<select class="inp" id="page_group" name="page_group">
					<option value="">(None)</option>
					<?php foreach (array(1 => 'About Us pages (group 1)', 3 => 'Instructions pages (group 3)', 4 => 'FAQ pages (group 4)', 0 => 'Footer pages (group 0)') as $k => $l) { ?>
						<option value="<?php echo $k; ?>"<?php echo ($r['page_group'] !== NULL && $r['page_group'] !== '' && (int) $r['page_group'] === $k) ? ' selected' : ''; ?>><?php echo $l; ?></option>
					<?php } ?>
				</select>
				<span class="hint">Adds the pages managed in the classic admin under this item.</span>
			</div>
			<div class="f">
				<label for="sort_order">Order number</label>
				<input class="inp mono" id="sort_order" name="sort_order" inputmode="numeric" value="<?php echo (int) $r['sort_order']; ?>">
				<span class="hint">Lower numbers come first. The arrows on the list also change this.</span>
			</div>
			<div class="f">
				<span class="lbl">Options</span>
				<label class="chk" style="margin:6px 18px 0 0"><input type="checkbox" name="new_tab" value="1"<?php echo $r['new_tab'] ? ' checked' : ''; ?>> Open in a new tab</label>
				<label class="chk" style="margin-top:6px"><input type="checkbox" name="is_active" value="1"<?php echo $r['is_active'] ? ' checked' : ''; ?>> Show on the site</label>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<a class="btn" href="<?php echo site_url('adminpanel/nav'); ?>">Cancel</a>
		<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Save item</button>
	</div>
	<?php echo form_close(); ?>
</div>

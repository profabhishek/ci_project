<?php defined('BASEPATH') OR exit('No direct script access allowed');
$params = isset($params) ? $params : array();
$link = function ($p) use ($params, $base) {
	$params['page'] = $p;
	return site_url($base) . '?' . http_build_query($params);
};
$from = $pager['total'] ? (($pager['page'] - 1) * $pager['per'] + 1) : 0;
$to = min($pager['total'], $pager['page'] * $pager['per']);
?>
<div class="pager">
	<span>Showing <?php echo number_format($from); ?>–<?php echo number_format($to); ?> of <?php echo number_format($pager['total']); ?></span>
	<span class="btn-group">
		<?php if ($pager['page'] > 1) { ?><a class="btn btn-sm" href="<?php echo html_escape($link($pager['page'] - 1)); ?>"><i class="fa fa-angle-left"></i> Previous</a><?php } ?>
		<span class="btn btn-sm" style="pointer-events:none">Page <?php echo (int) $pager['page']; ?> of <?php echo (int) $pager['pages']; ?></span>
		<?php if ($pager['page'] < $pager['pages']) { ?><a class="btn btn-sm" href="<?php echo html_escape($link($pager['page'] + 1)); ?>">Next <i class="fa fa-angle-right"></i></a><?php } ?>
	</span>
</div>

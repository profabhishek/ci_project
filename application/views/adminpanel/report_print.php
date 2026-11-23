<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="robots" content="noindex,nofollow">
<title><?php echo html_escape($report['title']); ?></title>
<style>
@page { size: A4 landscape; margin: 10mm; }
* { box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #111; margin: 0; padding: 12px; }
h1 { font-size: 16px; margin: 0 0 2px; text-align: center; }
.sub { text-align: center; color: #555; margin-bottom: 8px; font-size: 10px; }
h2 { font-size: 12px; margin: 14px 0 4px; }
.note { color: #555; margin: 0 0 4px; font-style: italic; }
table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
th { background: #1F3864; color: #fff; text-align: left; padding: 3px 4px; border: 1px solid #bfbfbf; font-size: 9px; }
td { padding: 3px 4px; border: 1px solid #bfbfbf; vertical-align: top; word-wrap: break-word; }
tr { page-break-inside: avoid; }
thead { display: table-header-group; }
tr:nth-child(even) td { background: #f2f5fa; }
tr.tot td { font-weight: bold; }
.bar { background: #f4f4f4; border: 1px solid #ddd; padding: 8px; margin-bottom: 10px; }
.bar button { padding: 5px 12px; font-size: 12px; cursor: pointer; }
.foot { color: #777; margin-top: 10px; font-size: 9px; }
@media print { .bar { display: none; } body { padding: 0; } }
</style></head><body>
<div class="bar">Choose <b>Save as PDF</b> as the printer in the print window. <button onclick="window.print()">Print / Save as PDF</button></div>
<h1><?php echo html_escape($report['title']); ?></h1>
<div class="sub"><?php echo html_escape($report['subtitle']); ?> <?php echo html_escape($report['params_text']); ?></div>
<?php foreach ($report['sections'] as $s) { ?>
<h2><?php echo html_escape($s['title']); ?></h2>
<?php if (!empty($s['note'])) { ?><p class="note"><?php echo html_escape($s['note']); ?></p><?php } ?>
<?php if (!$s['rows']) { ?><p>Nothing to show.</p><?php } else { ?>
<table><thead><tr><?php foreach ($s['columns'] as $c) { ?><th><?php echo html_escape($c); ?></th><?php } ?></tr></thead><tbody>
<?php foreach ($s['rows'] as $row) { $tot = (isset($row[0]) && $row[0] === 'Total'); ?>
<tr<?php echo $tot ? ' class="tot"' : ''; ?>><?php foreach ($s['columns'] as $i => $c) { ?><td><?php echo html_escape(isset($row[$i]) ? (string) $row[$i] : ''); ?></td><?php } ?></tr>
<?php } ?></tbody></table>
<?php } } ?>
<div class="foot">Generated <?php echo date('d-m-Y H:i'); ?> from the A2A portal, ICCR Scholarships Section. Prepared for official use.</div>
</body></html>

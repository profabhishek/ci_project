<?php defined('BASEPATH') OR exit('No direct script access allowed');
$uname = (isset($universityData[0]['name']) && $universityData[0]['name'] !== '') ? $universityData[0]['name'] : '';
?>
<style type="text/css">
.mc-wrap{max-width:1100px;margin:30px auto 60px;padding:0 15px;}
.mc-wrap h2{font-size:24px;color:#0b2e59;margin:0 0 6px;font-weight:bold;}
.mc-wrap h3{font-size:18px;color:#0b2e59;margin:28px 0 10px;}
.mc-wrap .mc-note{color:#555;font-size:13px;margin:4px 0 0;}
.mc-wrap .mc-uni{font-size:15px;margin:4px 0 0;}
.mc-table{width:100%;border-collapse:collapse;margin-top:8px;background:#fff;}
.mc-table th,.mc-table td{border:1px solid #d6dae0;padding:8px 10px;font-size:13.5px;text-align:left;vertical-align:top;}
.mc-table thead th{background:#0b2e59;color:#fff;font-weight:600;}
.mc-table tbody tr:nth-child(even){background:#f4f6f9;}
.mc-table td.mc-num,.mc-table td.mc-seat{text-align:center;}
.mc-empty{text-align:center;color:#777;padding:16px;}
</style>

<div class="mc-wrap">
	<h2>My Mapped Courses &amp; Seats</h2>
	<?php if ($uname) { ?><p class="mc-uni">University: <strong><?php echo html_escape($uname); ?></strong></p><?php } ?>
	<p class="mc-note">This is a read-only view of the Programmes and Courses your university is mapped to by ICCR, and the seats you have allotted. If anything here is wrong or missing, please contact ICCR &mdash; it cannot be edited here.</p>

	<h3>1. Courses mapped to you (set by ICCR)</h3>
	<table class="mc-table">
		<thead>
			<tr><th style="width:50px;">#</th><th>Programme</th><th>Course Type</th><th>Course</th><th>Nomenclature / Specialisation</th></tr>
		</thead>
		<tbody>
		<?php if (!empty($mapped)) { $i = 1; foreach ($mapped as $r) { ?>
			<tr>
				<td class="mc-num"><?php echo $i++; ?></td>
				<td><?php echo html_escape($r['programme_name']); ?></td>
				<td><?php echo html_escape($r['course_type_name']); ?></td>
				<td><?php echo html_escape($r['course_title']); ?></td>
				<td><?php echo html_escape($r['nomenclature_title']); ?></td>
			</tr>
		<?php } } else { ?>
			<tr><td class="mc-empty" colspan="5">No courses are mapped to your university yet. Please contact ICCR if this is unexpected.</td></tr>
		<?php } ?>
		</tbody>
	</table>

	<h3>2. Seats you have allotted (per course / stream)</h3>
	<table class="mc-table">
		<thead>
			<tr><th style="width:50px;">#</th><th>Programme</th><th>Course Type</th><th>Course</th><th>Stream / Branch</th><th style="width:80px;">Seats</th></tr>
		</thead>
		<tbody>
		<?php if (!empty($seats)) { $i = 1; foreach ($seats as $r) { ?>
			<tr>
				<td class="mc-num"><?php echo $i++; ?></td>
				<td><?php echo html_escape($r['programme_name']); ?></td>
				<td><?php echo html_escape($r['course_type_name']); ?></td>
				<td><?php echo html_escape($r['course_title']); ?></td>
				<td><?php echo html_escape($r['stream_name']); ?></td>
				<td class="mc-seat"><?php echo (int) $r['no_of_seat']; ?></td>
			</tr>
		<?php } } else { ?>
			<tr><td class="mc-empty" colspan="6">You have not allotted seats to any course yet. Use &ldquo;Create Stream mapping&rdquo; to add them.</td></tr>
		<?php } ?>
		</tbody>
	</table>
</div>

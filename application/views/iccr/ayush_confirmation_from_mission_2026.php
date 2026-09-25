<style type="text/css">
	#frm_details_ngo {
    float: right;
    position: absolute !important;
    right: 0;
    top: 11px !important;
}
.blue-heading h3
{
	margin-top: 13px !important;
	font-weight: bold;

}
</style>
<?php
// ---------------------------------------------------------------------------
// AYUSH admin: "Confirmation from Mission (2026-2027)".
//
// Lists AYUSH 2026-27 applications the Mission has finished processing - it
// has submitted the process screen and uploaded both the Medical Fitness
// Certificate and the Undertaking Form. Built from
// Common_model::getHQRSAYUSHConfirmedByMission2026(); layout follows
// iccr/ayush_received_applications_2026.php.
//
// Document links only point at files that really exist on disk; otherwise the
// cell says so, rather than sending the admin to an error page.
// ---------------------------------------------------------------------------

// University letter uploaded by the AYUSH admin. Headquarter::forwardAyuushtohqrs
// stores it under assets/site/main/university_approval/; older letters may sit in
// a ./<year>/university_approval/ folder, which is served through downloadDocs.
if (!function_exists('ayush_cfm_letter_link')) {
	function ayush_cfm_letter_link($file) {
		$file = trim((string) $file);
		if ($file === '') {
			return 'NA';
		}
		if (file_exists(FCPATH . 'assets/site/main/university_approval/' . $file)) {
			return '<a target="_blank" href="' . site_url() . 'assets/site/main/university_approval/' . rawurlencode($file) . '"><span class="label label-success">Download</span></a>';
		}
		foreach (array(date('Y'), date('Y') - 1, date('Y') - 2) as $y) {
			$path = './' . $y . '/university_approval/' . $file;
			if (file_exists($path)) {
				return '<a target="_blank" href="' . site_url() . 'headquarter/downloadDocs/' . base64url_encode($path) . '"><span class="label label-success">Download</span></a>';
			}
		}
		return '<span class="label label-warning" title="Expected file: ' . htmlspecialchars($file, ENT_QUOTES) . '">File not found</span>';
	}
}

// Medical Fitness Certificate / Undertaking Form uploaded by the Mission
// (Mission::applicaitonAgreeProcess -> assets/site/main/mission_documents/).
if (!function_exists('ayush_cfm_mission_doc_link')) {
	function ayush_cfm_mission_doc_link($file) {
		$file = trim((string) $file);
		if ($file === '') {
			return 'Not uploaded';
		}
		if (file_exists(FCPATH . 'assets/site/main/mission_documents/' . $file)) {
			return '<a target="_blank" href="' . site_url() . 'assets/site/main/mission_documents/' . rawurlencode($file) . '"><span class="label label-success">Download</span></a>';
		}
		return '<span class="label label-warning" title="Expected file: ' . htmlspecialchars($file, ENT_QUOTES) . '">File not found</span>';
	}
}
?>
<section class="meacontent">
	<div class="container" style="min-height:410px;padding-top:10px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal
	</marquee>
		<div class="blue-heading col-md-12">
			<h3>Confirmation from Mission (2026-2027)</h3>
	<a href="<?php echo site_url();?>headquarter/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>

				<div class="container">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>

		<div class="table-responsive">
		<table id="tbl_schrls" class="customTable1 table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				<th>Application No.</th>
				<th>Applicant Name</th>
				<th>Email Id</th>
				<th>Nomenclature</th>
				<th>Scheme</th>
				<th>Country</th>
				<th>Year</th>
				<th>Processed by Mission on</th>
				<th>Verifying Official</th>
				<th>University Letter</th>
				<th>Medical Fitness Certificate</th>
				<th>Undertaking Form</th>
				<th>View</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php
				$counter=1;
				if(!empty($ayush_applications))
				{
					foreach($ayush_applications as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo htmlspecialchars((string) $app['application_no'], ENT_QUOTES);?></td>
						<td><?php echo htmlspecialchars(trim((string) $app['fullname'].' '.$app['middlename'].' '.$app['familyname']), ENT_QUOTES);?></td>
						<td><?php echo htmlspecialchars((string) $app['email'], ENT_QUOTES);?></td>
						<td><?php
						// The confirmed course recorded when the application was
						// processed takes priority; otherwise fall back to the
						// applicant's own preferences, as on the Received page.
						$confirmedNom = !empty($app['confirmed_nomenclature']) ? $this->common_model->getnomenclatureByid($app['confirmed_nomenclature']) : array();
						if(!empty($confirmedNom[0]['title']))
						{
							echo $confirmedNom[0]['title'];
						}
						else if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							echo (isset($course[0]['name']) ? $course[0]['name'] : '').' '.(isset($app['course_subject']) ? $app['course_subject'] : '');
						}
						else
						{
							$nomKeys = array('nomenclature','nomenclature_two','nomenclature_three','nomenclature_fourth','nomenclature_fifth');
							$shown = 0;
							foreach($nomKeys as $nk)
							{
								if(empty($app[$nk])) { continue; }
								$nom = $this->common_model->getnomenclatureByid($app[$nk]);
								if(empty($nom[0]['title'])) { continue; }
								$shown++;
								echo $shown.') '.$nom[0]['title'].'<br/>';
							}
							if($shown === 0) { echo 'NA'; }
						}?></td>
						<td><?php
						$schem = $this->common_model->getSchemeById($app['scholarship_id']);
						echo !empty($schem) ? $schem[0]['scheme_name'] : 'NA';
						?></td>
						<td><?php echo htmlspecialchars((string) $app['country_name'], ENT_QUOTES);?></td>
						<td><?php echo date('Y-m-d', strtotime($app['created']));?></td>
						<td><?php echo htmlspecialchars((string) $app['mission_status_date'], ENT_QUOTES);?></td>
						<td><?php
						echo htmlspecialchars(trim((string) $app['mission_person_name']), ENT_QUOTES);
						if(trim((string) $app['mission_person_designation']) !== '')
						{
							echo '<br/><small>'.htmlspecialchars(trim((string) $app['mission_person_designation']), ENT_QUOTES).'</small>';
						}
						?></td>
						<td><?php echo ayush_cfm_letter_link($app['region_one_doc']);?></td>
						<td><?php echo ayush_cfm_mission_doc_link($app['mission_medical_fitness']);?></td>
						<td><?php echo ayush_cfm_mission_doc_link($app['mission_undertaking_form']);?></td>
						<td><a target="_blank" href="<?php echo site_url();?>headquarter/viewAyushFullApplication/<?php echo $app['application_no'];?>" class="form-control sbmt1"> View</a></td>
						<td><a target="_blank" href="<?php echo site_url().'headquarter/downloadStudent_zip/'.$app['application_no'];?>"><span class = "label label-success">Download</span></a></td>
						</tr>
						<?php
						$counter++;
					}
				}
				?>
			</tbody>
		</table>
		</div>
		<hr/>
	</div>
</section>
		<script>
$(document).ready(function(){

$('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});

// Set up your table
table = $('.customTable1').DataTable({
  paging: true,
  info: true
});

// Date range filter on the "Year" (registration date) column - index 7.
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[7] || 0;

    if (
      (min == "" || max == "") ||
      (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
    ) {
      return true;
    }
    return false;
  }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change(function() {
  table.draw();
});

$('#my-table_filter').hide();
});
</script>

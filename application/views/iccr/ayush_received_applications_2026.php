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
<section class="meacontent">
	<div class="container" style="min-height:410px;padding-top:10px;">		
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal 
	</marquee>	
		<div class="blue-heading col-md-12">
			<h3>Application Received</h3>
			<form method="post" action="<?php echo base_url();?>headquarter/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
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
		
		<table id="tbl_schrls" class="customTable1 table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>	
				<th>Application No.</th>			
				<th>Applicant Name</th>				
				<th>Email Id</th>
				<th>Nomenclature</th>
				<th>Scheme</th>
				<th>Country</th>								
				<!----<th>Application Form </th>	
				<th>Contact Form </th>-->
				<th>Year</th>
				<th>View</th>
				<!----<th>Mission Date</th>--->
			
				<th>Action</th>
				<th>Process </th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($ayush_applications)>0)
				{
					foreach($ayush_applications as $app)
					{
						//echo "<pre>";print_r($app);die;
						?>
						<tr>
						<td><?php echo $counter;?></td>
							<?php 
							$date1 = '2023-04-11';
						//$date1 = '2020-07-10';
						$date = date_create($app['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($app['created']);
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
							?>
						<td><?php $applicationDetails = $this->common_model->getApplicationStepOneByAppno($app['application_no']);
						
						echo $applicationDetails[0]['application_no'];?></td>
						<td><?php echo $app['fullname'].' '.$app['middlename'].' '.$app['familyname'];?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php
						// Shows the full nomenclature the applicant selected, rather
						// than the short course name. The nomenclature ids are held on
						// iccr_student_application_details and resolved through
						// iccr_nomenclature; empty preferences are skipped so the cell
						// does not fill with blank lines.
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
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
						if(!empty($schem)){
						echo $schem[0]['scheme_name'];
						}
						else
						{
							echo "NA";
						}
						?></td>
						<td><?php echo $app['country_name'];?></td>
						<!----<td><a target="_blank"  href="<?php echo site_url();?>headquarter/applicationForm/<?php echo $app['application_no'];?>">Download</a></td>
						<td><a target="_blank" href="<?php echo site_url();?>headquarter/contactForm/<?php echo $app['application_no'];?>">Download</a></td>---->
						<?php
						$date = date_create($app['created']);
							$array =  (array) $date;
							//print_r($array);
						?>
						<td><?php echo date("Y-m-d", strtotime($array['date']));?></td>	
						<td><a target="_blank" href="<?php echo site_url();?>headquarter/viewAyushFullApplication/<?php echo $app['application_no'];?>" class="form-control sbmt1"> View</a></td>
                        <!---<td><?php echo $app['mission_status_date']; ?></td>--->				
						
						<td>
							<?php 
							if($app['iccr_status'] == 1){
							?>
								<a href="#" title="Already Processed" class="form-control sbmt btn btn-block btn-default disabled">Processed</a>	
							<?php
							}
							else
							{
							?>
								<a href="<?php echo site_url();?>headquarter/ayushprocess/<?php echo $app['application_no'];?>" class="form-control sbmt">Process</a>
							<?php
							}
							?>
						</td>

						<td><a target="_blank" href="<?php echo site_url().'headquarter/downloadStudent_zip/'.$app['application_no'];?>" target="_blank"><span class = "label label-success">Download</span></a></td>
						</tr>
						<?php	
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
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

// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[8] || 0; // Our date column in the table

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
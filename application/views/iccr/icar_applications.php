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
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
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
				<th>Application No</th>	
				<th>Applicant Name</th>				
				<th>Email Id</th>
				<th>Course</th>
				<th>Scheme</th>
				<th>Country</th>	
				<th>Date of Submission</th>
				<th>View</th>
				<th>Process </th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($icar_applications)>0)
				{
					foreach($icar_applications as $app)
					{
							$date1 = '2021-03-15';
						//$date1 = '2019-12-01';
						$date = date_create($app['SubmitedDate']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($app['SubmitedDate']);
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
						?>
						<tr>
						<td><?php echo $counter;?></td>		
						<td><?php echo $app['application_no'];?></td>	
						<td><?php echo $app['fullname'].' '.$app['middlename'].' '.$app['familyname'];?></td>						
						<td><?php echo $app['email'];?></td>
						<td align="left"><?php
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							echo $course[0]['name'].' '.$app['course_subject'];
						}
						else
						{
							$course = $this->common_model->getCoursesById($app['course']);
							$course1 = $this->common_model->getCoursesById($app['course_two']);
							$course2 = $this->common_model->getCoursesById($app['course_three']);
							$course2 = $this->common_model->getCoursesById($app['course_fourth']);
							$course2 = $this->common_model->getCoursesById($app['course_fifth']);
							echo $course[0]['title'].' '.$app['course_option_name'].'<br/>';
							echo $course1[0]['title'].' '.$app['course_option_name_two'].'<br/>';
							echo $course2[0]['title'].' '.$app['course_option_name_three'].'<br/>';
							echo $course2[0]['title'].' '.$app['course_option_name_fourth'].'<br/>';
							echo $course2[0]['title'].' '.$app['course_option_name_fifth'].'<br/>';
							
						}?></td>
						<td><?php $schem = $this->common_model->getSchemeById($app['scholarship_id']); if(!empty($schem)){echo $schem[0]['scheme_name'];}else{echo "NA";}?></td>
						<td><?php echo $app['country_name'];?></td>
						<td><?php echo date("Y-m-d", $app['created']); ?></td>
						
						<td><a target="_blank" href="<?php echo site_url();?>headquarter/viewFullApplication/<?php echo $app['application_no'];?>" class ="form-control sbmt1" target = "_blank">View</a></td>
						<td><a href="<?php echo site_url();?>headquarter/icarprocess/<?php echo $app['application_no'];?>" class="form-control sbmt">Process</a></td>			
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
    var createdAt = data[7] || 0; // Our date column in the table

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
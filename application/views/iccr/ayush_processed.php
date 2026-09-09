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
			 <h3>Application Received From Mission</h3>
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
				<th>Application Form </th>	
				<th>Contact Form </th>
				<th>University Letter Format</th>
				<th>Year</th>
				<!----<th>Forward Date</th>--->
				
				<th>University Letter</th>
				<th>Iccr Letter</th>
				<th>Status </th>								
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($icar_applications)>0)
				{
					foreach($icar_applications as $app)
					{
						
						?>
						<tr>
						<td><?php echo $counter;?></td>		
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['fullname'].' '.$app['middlename'].' '.$app['familyname'];?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php $course = $this->common_model->getCoursesById($app['course']);echo $course[0]['title'];?></td>
						<td><?php $schem = $this->common_model->getSchemeById($app['scholarship_id']); echo $schem[0]['scheme_name'];?></td>
						<td><?php echo $app['country_name'];?></td>
						<td><a target="_blank"  href="<?php echo site_url();?>headquarter/applicationForm/<?php echo $app['application_no'];?>">Download</a></td>
						<td><a target="_blank" href="<?php echo site_url();?>headquarter/contactForm/<?php echo $app['application_no'];?>">Download</a></td>
						<?php
						$date = date_create($app['created']);
							$array =  (array) $date;
							//print_r($array);
							
							//$date1 = date_create($app['region_one_status_date']);
							//$array =  (array) $date1;
						?>
						
						
						<?php
						// target="_blank" added to match the Application Form and
						// Contact Form links above. The letter now opens inline in
						// the browser's PDF viewer rather than downloading, so
						// without this it would replace the listing and staff would
						// have to go back and re-apply their filters each time.
						?>
						<td><a target="_blank" href="<?php echo site_url();?>headquarter/universityLetter/<?php echo $app['application_no'];?>">Download</a></td>

						<td><?php echo date("Y-m-d", strtotime($array['date']));?></td>
						
						<td>
                             <?php
                              // University approval letters are written to two different
                              // places depending on which module uploaded them. The
                              // University module saves to ./<year>/university_approval/
                              // (outside the web root, so it cannot be linked directly),
                              // while Headquarters and Regional save to
                              // assets/site/main/university_approval/.
                              //
                              // This page previously built the assets/ link regardless,
                              // so a letter saved by the University module - or one that
                              // was never written to disk at all - produced a link to a
                              // file that does not exist. Apache then rewrote the request
                              // to index.php, no route matched, and the 404_override in
                              // routes.php sent it to home/not_found, which renders the
                              // "Error 500" page. Staff saw an internal server error for
                              // what was only a missing file.
                              //
                              // Confirm the file is actually present before offering a
                              // link: year folders first (served through downloadDocs,
                              // which reads from disk), then the public assets folder.
                              // If it is in neither, say so rather than linking to it.
                              if(!empty($app['region_one_doc'])){
                                  $ayushDoc   = $app['region_one_doc'];
                                  $ayushYear  = (int) date('Y');
                                  $ayushFound = '';

                                  // Look in the year folders first. The letter may have
                                  // been uploaded in an earlier cycle, so check a few
                                  // years back rather than only the current one.
                                  for($y = $ayushYear; $y >= $ayushYear - 3; $y--){
                                      $tryPath = './'.$y.'/university_approval/'.$ayushDoc;
                                      if(file_exists($tryPath)){ $ayushFound = $tryPath; break; }
                                  }

                                  if($ayushFound !== ''){
                                      // Held outside the web root, so serve it through
                                      // the existing route that reads it from disk.
                                      ?>
                                      <a target="_blank" href="<?php echo site_url().'headquarter/downloadDocs/'.base64url_encode($ayushFound); ?>"><span class="label label-success">Download</span></a>
                                      <?php
                                  }
                                  elseif(file_exists(FCPATH.'assets/site/main/university_approval/'.$ayushDoc)){
                                      // Present in the public assets folder, link directly.
                                      ?>
                                      <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $ayushDoc; ?>"><span class="label label-success">Download</span></a>
                                      <?php
                                  }
                                  else{
                                      // The database records a filename but the file is
                                      // not on the server in either location. Previously
                                      // this still produced a Download link; clicking it
                                      // found no file, so the request fell through to the
                                      // framework's 404 handler, which renders the
                                      // "Error 500" page. Staff were shown a server error
                                      // for what is simply a missing upload. Say so
                                      // plainly instead, and show the expected filename
                                      // so the record can be traced and re-uploaded.
                                      ?>
                                      <span class="label label-warning" title="Expected file: <?php echo htmlspecialchars($ayushDoc, ENT_QUOTES); ?>">File not found</span>
                                      <?php
                                  }
                              } else {
                                echo "NA";
                                }
                               ?>
                        </td>
						<td>

                                    <?php
									$response1 = $this->common_model->getUniversityResponsesbyHqrs($app['application_no']);
									$mappingData = $this->common_model->getMappingData($app['application_no']);
                                    //$sts = 0;
                                    //echo '<pre>';print_r($response1);
                                    foreach ($response1 as $resp) {
                                      /*  if ($resp['University'] == $app['universty_choice_three'] || $resp['University'] == $app['universty_choice_two'] || $resp['University'] == $app['universty_choice']) { */
                                        
                                            if ($resp['confirmed_to_mission'] == -1 && $mappingData[0]['region_forward_mission_status'] == 1) {
                                                ?>
                                                <a target="_blank" href="<?php echo site_url(); ?>headquarter/confirmationReceivedWithNewFormat/<?php echo $app['application_no']; ?>/<?php echo $resp['University']; ?>" target="_blank"><span class = "label label-success">Download</span></a>

                        <?php
                    } elseif ($resp['confirmed_to_mission'] == 2) {
                        ?>
                                                <a target="_blank" href="<?php echo site_url(); ?>headquarter/confirmationReceivedWithNewFormat/<?php echo $app['application_no']; ?>/<?php echo $resp['University']; ?>" target="_blank"><span class = "label label-success">Download</span></a>
                                                <?php
                                            }
											else{
												echo "NA";
											}
                                        }

                                    //}
                                  
                                    ?>

                                </td>
						<!----<td><?php echo date("Y-m-d", strtotime($array['date1']));?></td>-->	
						<td>Processed</td>				
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
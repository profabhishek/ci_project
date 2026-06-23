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
marquee{
	
    border: 1px solid #cecece;
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto 5px;
    padding: 7px 5px 0;
    text-align: left;
}
</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">
		<marquee>Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3>Confirmation from University/Institute</h3>
			 <form method="post" action="<?php echo base_url();?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>mission/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				
				<th>Applicant Name</th>
				<th>Email Id</th>
				<th>Course</th>
				<th>University</th>
			
				<th>Scheme</th>		
				<th>Status </th>
				<th>University Letter</th>
				<th>Iccr Letter</th>
				<th>Process </th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($confirmaitonofuniversityformhqrs)>0)
				{
					foreach($confirmaitonofuniversityformhqrs as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						
						<td><?php echo $app['fullname'];?></td>
						<td><?php echo $app['email'];?></td>
						<td><?php
						
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
							$course3 = $this->common_model->getCoursesById($app['course_fourth']);
							$course4 = $this->common_model->getCoursesById($app['course_fifth']);
							echo $course[0]['title'].' '.$app['course_option_name'].'<br/>';
							echo $course1[0]['title'].' '.$app['course_option_name_two'].'<br/>';
							echo $course2[0]['title'].' '.$app['course_option_name_three'].'<br/>';
							echo $course3[0]['title'].' '.$app['course_option_name_fourth'].'<br/>';
							echo $course4[0]['title'].' '.$app['course_option_name_fifth'].'<br/>';
							
						}?></td>
						<td>
						<?php $uni = $this->common_model->getUniversityById($app['regional_university']); echo $uni[0]['name'];?></td>			
						
						<td><?php $scheme = $this->common_model->getSchemeById($app['scholarship_id']);echo $scheme[0]['scheme_name'];?></td>
						<td>Received</td>
						<td>
                             <?php 
                              if(!empty($app['region_one_doc'])){
                              ?>
                               <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $app['region_one_doc']; ?>" target="_blank">Download</a>
                                <?php
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
                                                <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationReceivedWithFormat/<?php echo $app['application_no']; ?>/<?php echo $resp['University']; ?>" target="_blank"><span class = "label label-success">Download</span></a>

                        <?php
                    } elseif ($resp['confirmed_to_mission'] == 2) {
                        ?>
                                                <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationReceivedWithFormat/<?php echo $app['application_no']; ?>/<?php echo $resp['University']; ?>" target="_blank"><span class = "label label-success">Download</span></a>
                                                <?php
                                            }
											else{
												echo "NA";
											}
                                        }

                                    //}
                                  
                                    ?>

                                </td>
								
								<?php
								if($mappingData[0]['mission_status'] == 1 && $mappingData[0]['region_forward_mission_status'] == -1)
								{
									?>
									<td><a class="form-control sbmt" style="width:100px;" href="javascript:void(0);" onclick ="openOfferGenrateModel('<?php echo $app['application_no'];?>')">Process</a></td>
									<?php
								}
								else
								{
									?>
									<td><a style="width:100px;">Processed</a></td>
									<?php
									
								}
								
								?>
						
						
						
						</tr>
						<?php	
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
		
		
		<div class="blue-heading col-md-12 ">
			 <h3>Confirmation from University/Institute Old</h3>
			 <form method="post" action="<?php echo base_url();?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>mission/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				
				<th>Applicant Name</th>
				<th>Email Id</th>
				<th>Course</th>
				<th>University</th>
			
				<th>Scheme</th>		
				<th>Status </th>
				<th>University Letter</th>
				<th>Iccr Letter</th>
				<th>Process </th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($confirmaitonofuniversityformhqrsOld)>0)
				{
					foreach($confirmaitonofuniversityformhqrsOld as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						
						<td><?php echo $app['fullname'];?></td>
						<td><?php echo $app['email'];?></td>
						<td><?php
						
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
							$course3 = $this->common_model->getCoursesById($app['course_fourth']);
							$course4 = $this->common_model->getCoursesById($app['course_fifth']);
							echo $course[0]['title'].' '.$app['course_option_name'].'<br/>';
							echo $course1[0]['title'].' '.$app['course_option_name_two'].'<br/>';
							echo $course2[0]['title'].' '.$app['course_option_name_three'].'<br/>';
							echo $course3[0]['title'].' '.$app['course_option_name_fourth'].'<br/>';
							echo $course4[0]['title'].' '.$app['course_option_name_fifth'].'<br/>';
							
						}?></td>
						<td>
						<?php $uni = $this->common_model->getUniversityById($app['regional_university']); echo $uni[0]['name'];?></td>			
						
						<td><?php $scheme = $this->common_model->getSchemeById($app['scholarship_id']);echo $scheme[0]['scheme_name'];?></td>
						<td>Received</td>
						<td>
                             <?php 
                              if(!empty($app['region_one_doc'])){
                              ?>
                               <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $app['region_one_doc']; ?>" target="_blank">Download</a>
                                <?php
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
                                        
                                            if ($resp['confirmed_to_mission'] == -1 && $mappingData[0]['mission_status'] == 1) {
                                                ?>
                                                <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationReceivedWithFormat/<?php echo $app['application_no']; ?>/<?php echo $resp['University']; ?>" target="_blank"><span class = "label label-success">Download</span></a>

                        <?php
                    } elseif ($resp['confirmed_to_mission'] == 2) {
                        ?>
                                                <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationReceivedWithFormat/<?php echo $app['application_no']; ?>/<?php echo $resp['University']; ?>" target="_blank"><span class = "label label-success">Download</span></a>
                                                <?php
                                            }
											else{
												echo "NA";
											}
                                        }

                                    //}
                                  
                                    ?>

                                </td>
								
								<?php
								if($mappingData[0]['mission_status'] == 1)
								{
									?>
									<td><a class="form-control sbmt" style="width:100px;" href="javascript:void(0);">Process</a></td>
									<?php
								}
								else
								{
									?>
									<td><a class="form-control sbmt" style="width:100px;" href="<?php echo site_url();?>mission/processConfirmedappforFourthbyhqrs/<?php echo $app['application_no'];?>">Process</a></td>
									<?php
									
								}
								
								?>
						
						
						
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
	<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">OFFER LETTER GENRATE FOR AYUSH</h4>
                        </div>
                        <div class="modal-body">
     
						</div>
	<div class="modal-footer">
	<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
	<!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
           
	
	</div>
                    </div>
                  
                </div>
            </div>
</section>
<script>
function openOfferGenrateModel(appid){
	// AJAX request
				//var appid = $('#expe').val();
					
                    $.ajax({
                        url: '<?php echo site_url('mission/openMissionOfferLetter')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}
</script>
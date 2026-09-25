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
			<h3>Processed Applications</h3>
		 	<form method="post" action="<?php echo base_url();?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;">
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
				<th>Applicant No</th>
				<th>Applicant Name</th>
				<th>Email Id</th>	
				<th>Course</th>	
				<th>University</th>			
				<th>Date of Registration</th>
				<th>Date of Confirmation</th>
				<th>University Letter</th>
				<th>View</th>
				<th>Status</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($approvedApplication)>0)
				{
					foreach($approvedApplication as $app)
					{
						//echo "<pre>";print_r($app);die;
						$date1 = '2021-03-15';
						//$date1 = '2019-12-01';
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
					//echo "<pre>";print_r($app);die;
						?>
						<tr>
						<td><?php echo $counter;?></td>	
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['fullname'].' '.$app['middlename'].' '.$app['familyname'].$new;?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php
							// Prefer Nomenclature (reliable, set once a university confirms
							// the admission) over the raw applied-course lookup below, which
							// is frequently null/mismatched and was showing as "NA".
							$nomenclature = !empty($app['nomenclature']) ? $this->common_model->getnomenclatureByid($app['nomenclature']) : [];
							if(!empty($nomenclature))
							{
								echo $nomenclature[0]['title'];
							}
							else if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
							{
								$course = $this->common_model->getProgrammeById($app['programme']);
								echo $course[0]['name'].' ('.$app['course_subject'].')';
							}
							else
							{
								$course = $this->common_model->getCoursesById($app['course']);
								$strm1 = $this->common_model->getStreamById($app['course_option_name']);

								echo (!empty($course) ? $course[0]['title'] : 'NA').' '.(!empty($strm1) ? $strm1[0]['name'] : '').'<br/>';
						}?></td>
						<td>
							<?php
							$response = $this->common_model->getconfirmationDataByMission($app['application_no']);
							//echo "<pre>";print_r($response);die;
						    $uni1 = !empty($response) ? $this->common_model->getUniversityById($response[0]['regional_university']) : array();
							//echo "<pre>";print_r($uni1);die;;
							echo !empty($uni1) ? $uni1[0]['name'] : 'NA';
							?>
						</td>				
					
						<td>
						<?php
						$date1 = strtotime($app['created']);	
						echo date('Y-m-d',$date1);
						?>
						</td>
						
						<td>
						<?php
						$date1 = strtotime($app['mission_status_date']);	
						echo date('Y-m-d',$date1);
						//$date1 = $app['mission_status_date'];	
						//echo $date1;
						?>
						</td>
						<!----<td>
						<?php						
							if($app['status'] == "10" )
							{
								?>
								<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/viewFullApproveApplication/<?php echo $app['application_no'];?>/approved" class="form-control sbmt1" target = "_blank">View</a>
								<?php								
							}	
						?>	
						</td>----->
						<?php 
					$response = $this->common_model->getconfirmationDataByMission($app['application_no']);
					//echo "<pre>";print_r($response);die;
					?>
						<td>
					<?php if (!empty($response) && $response[0]['university_is_accept'] == 1) {

						$file_path_un = null;
						foreach (array(date('Y'), date('Y')-1, date('Y')-2) as $ua_year) {
							$ua_candidate = './'.$ua_year.'/university_approval/'.$response[0]['region_one_doc'];
							if (file_exists($ua_candidate)) {
								$file_path_un = $ua_candidate;
								break;
							}
						}
                        if(strpos($response[0]['region_one_doc'],'.pdf')){
							if($file_path_un) {
							 $output = '<a href="'.site_url().'mission/downloadDocs/'.base64url_encode($file_path_un).'" target = "_blank">Download</a>';
							}
							else{
							$output = '<a target="_blank" href="'.site_url().'assets/site/main/university_approval/'.$response[0]["region_one_doc"].'" target="_blank">Download</a>';
							}
						   }
						   else {
							if($file_path_un) {
						     $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
				   $output = '<a download="'.rand().time().'" href="data:'.$mime_type.';base64,'.$data.'" target = "_blank">Download</a>';
							}
							else{
						$output = '<a target="_blank" href="'.site_url().'assets/site/main/university_approval/'.$response[0]["region_one_doc"].'" target="_blank">Download</a>';
							}
							}
							echo $output;

						   ?>
                                            <!--<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $response[0]['region_one_doc']; ?>" target="_blank">Download</a>-->
                                            <?php
                                        }  ?>
						</td>
						<td>
						
						<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/historyview/<?php echo !empty($response) ? $response[0]['application_id'] : '';?>" class="form-control sbmt1" target = "_blank">View</a>
						
						</td>
						<td>
						
						<a href="javascript:void(0);" style="float:left;width:104px;" onclick ="openStatus(<?php echo $app['application_no']?>)" class="form-control sbmt1">Status</a>
						
						
						</td>
						<?php 
				if($app['status'] >= 10 && $app['scholar_acceptance'] == 2)
				{
					?>
					<td>
						<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/viewApplication/<?php echo $app['application_no'];?>" class="form-control sbmt1" target = "_blank">Process</a>
						</td>
					<?php
				}
				else
				{
					?>
					<td>
					<a style="float:left;width:104px;" href = "#" class="form-control sbmt1" disabled target = "_blank">Process</a>
					</td>
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

</div>

			
			
			<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Status</h4>
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


	<div  class="container" style="min-height:410px;padding-top:16px;">
		
		<div class="blue-heading col-md-12 ">
			 <h3>Ayush Processed Applications</h3>
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
				<th>Applicant No</th>
				<th>Applicant Name</th>
				<th>Email Id</th>
				<th>Course</th>
				<th>University</th>
				<th>Scheme</th>
				<th>University Letter</th>
				<th>Medical Fitness Certificate</th>
				<th>Undertaking Form</th>
				<th>View</th>
				<th>Date of Registration</th>
				<th>Status</th>
			</thead>

			<tbody>
				<?php 
				$counter=1;
				if(count($approvedAyushApplication)>0)
				{
					foreach($approvedAyushApplication as $app)
					{
						//echo "<pre>";print_r($app);die;
						$date1 = '2021-03-15';
						//$date1 = '2019-12-01';
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
					//echo "<pre>";print_r($app);die;
						?>
						<tr>
						<td><?php echo $counter;?></td>	
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['fullname'].' '.$app['middlename'].' '.$app['familyname'].$new;?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php
						// For AYUSH applications, $app['course']/course_two/.../course_fifth
						// all point to a generic AYUSH category record whose title is just
						// "Ayush" - so echoing all 5 just repeats "Ayush" five times, which
						// looks broken even though nothing is technically failing. The
						// actual confirmed course/discipline lives in Nomenclature once a
						// university has confirmed the admission, so show that instead when
						// it's available.
						$nomenclature = !empty($app['nomenclature']) ? $this->common_model->getnomenclatureByid($app['nomenclature']) : [];
						if(!empty($nomenclature))
						{
							echo $nomenclature[0]['title'];
						}
						else if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							echo $course[0]['name'].' ('.$app['course_subject'].')';
						}
						else
						{
							$course1 = $this->common_model->getCoursesById($app['course'] ?? null);
							$course2 = $this->common_model->getCoursesById($app['course_two'] ?? null);
							$course3 = $this->common_model->getCoursesById($app['course_three'] ?? null);
							$course4 = $this->common_model->getCoursesById($app['course_fourth'] ?? null);
							$course5 = $this->common_model->getCoursesById($app['course_fifth'] ?? null);

							$strm1 = $this->common_model->getStreamById($app['course_option_name'] ?? null);

							echo (!empty($course1) ? $course1[0]['title'] : 'NA').'<br/>';
							echo (!empty($course2) ? $course2[0]['title'] : 'NA').'<br/>';
							echo (!empty($course3) ? $course3[0]['title'] : 'NA').'<br/>';
							echo (!empty($course4) ? $course4[0]['title'] : 'NA').'<br/>';
							echo (!empty($course5) ? $course5[0]['title'] : 'NA').'<br/>';

						}?>
						</td>
						
						<td>
							<?php
							$uni1 = $this->common_model->getUniversityById($app['universty_choice'] ?? null);
							$uni2 = $this->common_model->getUniversityById($app['universty_choice_two'] ?? null);
							$uni3 = $this->common_model->getUniversityById($app['universty_choice_three'] ?? null);
							$uni4 = $this->common_model->getUniversityById($app['universty_choice_fourth'] ?? null);
							$uni5 = $this->common_model->getUniversityById($app['universty_choice_fifth'] ?? null);
							echo (!empty($uni1) ? $uni1[0]['name'] : 'NA').'<br/>';
							echo (!empty($uni2) ? $uni2[0]['name'] : 'NA').'<br/>';
							echo (!empty($uni3) ? $uni3[0]['name'] : 'NA').'<br/>';
							echo (!empty($uni4) ? $uni4[0]['name'] : 'NA').'<br/>';
							echo (!empty($uni5) ? $uni5[0]['name'] : 'NA').'<br/>';
							?>
						</td>				

						<td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
							echo !empty($sch) ? $sch[0]['scheme_name'] : 'NA';?>
						</td>

						
						<td>
                             <?php
                              if(!empty($app['region_one_doc'])){
                                  $ua_file_path = null;
                                  foreach (array(date('Y'), date('Y')-1, date('Y')-2) as $ua_year) {
                                      $ua_candidate = './'.$ua_year.'/university_approval/'.$app['region_one_doc'];
                                      if (file_exists($ua_candidate)) {
                                          $ua_file_path = $ua_candidate;
                                          break;
                                      }
                                  }
                                  if ($ua_file_path) {
                              ?>
                               <a href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($ua_file_path); ?>" target="_blank"><span class = "label label-success">Download</span></a>
                                <?php
                                  } else {
                              ?>
                               <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $app['region_one_doc']; ?>" target="_blank"><span class = "label label-success">Download</span></a>
                                <?php
                                  }
                               } else {
                                echo "NA";
                                }
                               ?>
                        </td>
                        <?php
                        // Medical Fitness Certificate and Undertaking Form, uploaded by
                        // the Mission on the process screen and stored under
                        // assets/site/main/mission_documents/ (see
                        // Mission::applicaitonAgreeProcess). Only link when the file
                        // is really on disk.
                        $missionDocCells = array('mission_medical_fitness', 'mission_undertaking_form');
                        foreach ($missionDocCells as $docKey) {
                            $docName = isset($app[$docKey]) ? trim((string) $app[$docKey]) : '';
                            ?>
                            <td>
                            <?php
                            if ($docName === '') {
                                echo 'Not uploaded';
                            } elseif (file_exists(FCPATH.'assets/site/main/mission_documents/'.$docName)) {
                                ?>
                                <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/mission_documents/<?php echo rawurlencode($docName); ?>"><span class="label label-success">Download</span></a>
                                <?php
                            } else {
                                ?>
                                <span class="label label-warning" title="Expected file: <?php echo htmlspecialchars($docName, ENT_QUOTES); ?>">File not found</span>
                                <?php
                            }
                            ?>
                            </td>
                            <?php
                        }
                        ?>

						<!--<td><a target="_blank" href="<?php echo site_url();?>mission/viewfullApplication/<?php echo base64_encode($app['application_no']);?>" class="form-control sbmt1"> View</a></td>
						-->
						<td><a target="_blank" href="<?php echo site_url();?>mission/viewfullApplication/<?php echo $app['application_no'];?>" class="form-control sbmt1"> View</a></td>
						
						<td>
							<?php
							$date1 = strtotime($app['created']);	
							echo date('Y-m-d',$date1);
							?>
						</td>
						
						<!----<td>
						<?php						
							if($app['status'] == "10" )
							{
								?>
								<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/viewFullApproveApplication/<?php echo $app['application_no'];?>/approved" class="form-control sbmt1" target = "_blank">View</a>
								<?php								
							}	
						?>	
						</td>----->

						<?php 
						$response = $this->common_model->getconfirmationDataByMission($app['application_no']);
						//echo "<pre>";print_r($response);die;
						?>

						<td>
							<a href="javascript:void(0);" style="float:left;width:104px;" onclick ="openStatus(<?php echo $app['application_no']?>)" class="form-control sbmt1">Status</a>
						</td>
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

</div>

			
			
			<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Status</h4>
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
	<script src="<?php echo base_url();?>assets/site/main/js/bootbox/bootbox.min.js"></script>
<script type='text/javascript'>
	function editApp(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('mission/editApplication')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalFormMission').modal('show'); 
                        }
    
	});
}

function openStatus(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('mission/openUniversityStatus')?>',
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
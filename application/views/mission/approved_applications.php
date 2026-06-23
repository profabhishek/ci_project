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
							if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
							{
								$course = $this->common_model->getProgrammeById($app['programme']);
								echo $course[0]['name'].' ('.$app['course_subject'].')';
							}
							else
							{
								$course = $this->common_model->getCoursesById($app['course']);							
								$strm1 = $this->common_model->getStreamById($app['course_option_name']);
								
								echo $course[0]['title'].' '.$strm1[0]['name'].'<br/>';
						}?></td>	
						<td>
							<?php
							$response = $this->common_model->getconfirmationDataByMission($app['application_no']);
							//echo "<pre>";print_r($response);die;
						    $uni1 = $this->common_model->getUniversityById($response[0]['regional_university']);
							//echo "<pre>";print_r($uni1);die;;
							echo $uni1[0]['name'];
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
					<?php if ($response[0]['university_is_accept'] == 1) {
                                            
						$file_path_un = './2025/university_approval/'.$response[0]['region_one_doc']; 
                        if(strpos($response[0]['region_one_doc'],'.pdf')){
							if(file_exists($file_path_un)) {	
							 $output = '<a href="'.site_url().'mission/downloadDocs/'.base64url_encode($file_path_un).'" target = "_blank">Download</a>';   
							}
							else{
							$output = '<a target="_blank" href="'.site_url().'assets/site/main/university_approval/'.$response[0]["region_one_doc"].'" target="_blank">Download</a>';		
							}
						   }
						   else {
						$file_path_un = './2024/university_approval/'.$response[0]['region_one_doc'];
							if(file_exists($file_path_un)) {						
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
						
						<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/historyview/<?php echo $response[0]['application_id'];?>" class="form-control sbmt1" target = "_blank">View</a>
						
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
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							echo $course[0]['name'].' ('.$app['course_subject'].')';
						}
						else
						{
							$course1 = $this->common_model->getCoursesById($app['course']);
							$course2 = $this->common_model->getCoursesById($app['course_two']);
							$course3 = $this->common_model->getCoursesById($app['course_three']);
							$course4 = $this->common_model->getCoursesById($app['course_fourth']);
							$course5 = $this->common_model->getCoursesById($app['course_fifth']);
										
							$strm1 = $this->common_model->getStreamById($app['course_option_name']);
							
							echo $course1[0]['title'].'<br/>';
							echo $course2[0]['title'].'<br/>';
							echo $course3[0]['title'].'<br/>';
							echo $course4[0]['title'].'<br/>';
							echo $course5[0]['title'].'<br/>';
							
						}?>
						</td>	
						
						<td>
							<?php
							$uni1 = $this->common_model->getUniversityById($app['universty_choice']);
							$uni2 = $this->common_model->getUniversityById($app['universty_choice_two']);
							$uni3 = $this->common_model->getUniversityById($app['universty_choice_three']);
							$uni4 = $this->common_model->getUniversityById($app['universty_choice_fourth']);
							$uni5 = $this->common_model->getUniversityById($app['universty_choice_fifth']);
							echo $uni1[0]['name'].'<br/>';
							echo $uni2[0]['name'].'<br/>';
							echo $uni3[0]['name'].'<br/>';
							echo $uni4[0]['name'].'<br/>';
							echo $uni5[0]['name'].'<br/>';
							?>
						</td>				

						<td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
							echo $sch[0]['scheme_name'];?>
						</td>

						
						<td>
                             <?php 
                              if(!empty($app['region_one_doc'])){
                              ?>
                               <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $app['region_one_doc']; ?>" target="_blank"><span class = "label label-success">Download</span></a>
                                <?php
                               } else {
                                echo "NA";
                                }
                               ?>   
                        </td>

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
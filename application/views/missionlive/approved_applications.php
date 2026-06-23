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
				<!------<th>Status</th>--->
				<th>Date of Registration</th>
				<th>View</th>
				<!--------<th>Edit</th>---->	
				<th>Status</th>	
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($approvedApplication)>0)
				{
					foreach($approvedApplication as $app)
					{
						//echo "<pre>";print_r($app);die;
						?>
						<tr>
						<td><?php echo $counter;?></td>	
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['fullname'].' '.$app['middlename'].' '.$app['familyname'];?></td>						
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
						<!--------<td>
						<?php						
							if($app['status'] == "4"  || $app['universities_status'] == "22")
							{
								echo "Approved";
							}	
							elseif($app['status'] == "5" || $app['universities_status'] == "18")
							{
								echo "Rejected";
							}
						?>	
						</td>------->	
						
						<td>
						<?php
						$date1 = strtotime($app['created']);	
						echo date('Y-m-d',$date1);
						?>
						</td>
						
						<td>
						<?php						
							if($app['universities_status'] == "1" )
							{
								?>
								<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/viewFullApproveApplication/<?php echo $app['application_no'];?>/approved" class="form-control sbmt1">View</a>
								<?php								
							}	
							elseif($app['status'] == "5" || $app['universities_status'] == "18")
							{
								?>
								<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/viewFullApplication/<?php echo $app['application_no'];?>/rejected" class="form-control sbmt1">View</a>
								<?php								
							}
						?>	
						</td>
						<!-------------<td><?php						
							if($app['status'] == "4" || $app['universities_status'] == "22")
							{
								?>
								<a href="javascript:void(0);" style="float:left;width:104px;" onclick ="editApp(<?php echo $app['id']?>)" class="form-control sbmt1">Edit</a>
								<?php								
							}	
							elseif($app['status'] == "5" || $app['universities_status'] == "18")
							{
								
								echo "NA";
																
							}
						?>	</td>------->
					
						<td>
						<a href='javascript:void(0);' style="float:left;width:104px;" onclick ="openStatus('<?php echo $app['application_no'];?>')" class="form-control sbmt1">Status</a>
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
</section>


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
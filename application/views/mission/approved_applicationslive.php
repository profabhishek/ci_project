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
<?php
	    	if($this->session->flashdata('message_type') == "success")
	    	{
			?>
			<div class="alert alert-success" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
			</div>
			<?php	
			}
			if($this->session->flashdata('message_type') == "error")
	    	{
			?>
			<div class="alert alert-error" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>
			</div>
			<?php	
			}
	    	
	    	?>
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
						
				<th>Applicant Name</th>
				
				<th>Email Id</th>
<th>Scheme</th>				
				<th>Course</th>	
				<th>Universities Opts.</th>			
				<th>Status</th>		
				<th>Year</th>
				<th>View</th>
				<!-----------<th>Action</th>--->			
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($approvedApplication)>0)
				{
					foreach($approvedApplication as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>						
						<td><?php echo $app['fullname'].' '.$app['middlename'].' '.$app['familyname'];?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
						
						echo $sch[0]['scheme_name'];?>
						
						</td>	
						<td><?php
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							echo $course[0]['name'].' ('.$app['course_subject'].')';
						}
						else
						{
							$course = $this->common_model->getCoursesById($app['course']);
							$course1 = $this->common_model->getCoursesById($app['course_two']);
							$course2 = $this->common_model->getCoursesById($app['course_three']);
							echo $course[0]['title'].' '.$app['course_option_name'].'<br/>';
							echo $course1[0]['title'].' '.$app['course_option_name_two'].'<br/>';
							echo $course2[0]['title'].' '.$app['course_option_name_three'].'<br/>';
							
						}?></td>	
						<td>
							<?php
							$uni1 = $this->common_model->getUniversityById($app['universty_choice']);
							$uni2 = $this->common_model->getUniversityById($app['universty_choice_two']);
							$uni3 = $this->common_model->getUniversityById($app['universty_choice_three']);
							echo '1) '.$uni1[0]['name'].'<br/>';
							echo '2) '.$uni2[0]['name'].'<br/>';
							echo '3) '.$uni3[0]['name'].'<br/>';
							?>
						</td>				
						<td>
						<?php						
							if($app['status'] == "4" )
							{
								echo "Approved";
							}	
							elseif($app['status'] == "5" )
							{
								echo "Rejected";
							}
						?>	
						</td>	
						<td>
						<?php $arr= explode('-',$app['created']);
						echo $arr[0];
						?>
						</td>
						<td>
							
						<?php						
							if($app['status'] == "4" )
							{
								?>
								<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/viewProcessedApplication/<?php echo $app['application_no'];?>/approved" class="form-control sbmt1">View</a>
								<?php								
							}	
							elseif($app['status'] == "5" )
							{
								?>
								<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/viewProcessedApplication/<?php echo $app['application_no'];?>/rejected" class="form-control sbmt1">View</a>
								<?php								
							}
						?>	
						</td>
						<!----<td><?php						
							if($app['status'] == "4" )
							{
								?>
								<a href="javascript:void(0);" style="float:left;width:104px;" onclick ="editApp(<?php echo $app['id']?>)" class="form-control sbmt1">Edit</a>
								<?php								
							}	
							elseif($app['status'] == "5" )
							{
								
								echo "NA";
																
							}
						?>	</td>--->
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
                          <h4 class="modal-title">UPDATE ENGLISH TEST MARKS OF STUDENT</h4>
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
                            $('#modalForm').modal('show'); 
                        }
    
	});
}
</script>
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
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
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
				<th>Scheme</th>		
				<th>Status </th>
				<th>Process </th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				
				if(count($confirmationForwardtoMissionbyHqrs)>0)
				{
					foreach($confirmationForwardtoMissionbyHqrs as $app)
					{
						$response1 = $this->common_model->getconfirmationDataforfourthoptionHqrs($app['application_no']);
						if(count($response1)<=0)
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
							
							
							$strm1 = $this->common_model->getStreamById($app['course_option_name']);
							$strm2 = $this->common_model->getStreamById($app['course_option_name_two']);
							$strm3 = $this->common_model->getStreamById($app['course_option_name_three']);
							$strm4 = $this->common_model->getStreamById($app['course_option_name_fourth']);
							$strm5 = $this->common_model->getStreamById($app['course_option_name_fifth']);
							
							
							echo $course[0]['title'].' '.$strm1[0]['name'].'<br/>';
							echo $course1[0]['title'].' '.$strm2[0]['name'].'<br/>';
							echo $course2[0]['title'].' '.$strm3[0]['name'].'<br/>';
							echo $course3[0]['title'].' '.$strm4[0]['name'].'<br/>';
							echo $course4[0]['title'].' '.$strm5[0]['name'].'<br/>';
							
						}?></td>
						<td><?php 
						$scheme = $this->common_model->getSchemeById($app['scholarship_id']);
						//echo "<pre>";print_r($scheme);
						if(!empty($scheme)){
						echo $scheme[0]['scheme_name'];
						}else{
							echo "NA";
						}
						//echo $scheme[0]['scheme_name'];?></td>
						<td>Received</td>
						<!--<td><?php 	
						$university = $this->common_model->getUniversityById($app['regional_university']);						
						echo $university[0]["name"];
						?></td>-->
						<!--<td><?php 	
						$university_sts = $app['university_is_accept'];						
						if($university_sts == 1)
							echo "Approved";
						elseif($university_sts == 2)
							echo "Rejected";	
						?></td>	-->					
						<!--<td><a target="_blank" href="<?php echo site_url();?>assets/site/main/university_approval/<?php echo  $app['region_one_doc'];?>" target="_blank">Download</a></td>-->
						<!--<td><a href="<?php echo site_url();?>mission/undertakingFromStudent/<?php echo $app['application_no'];?>" >Download</a></td>
						
						<td><a class="form-control sbmt" style="width:100px;" href="<?php echo site_url();?>mission/undertakingacceptancce/<?php echo $app['application_no'];?>">Accept</a></td>
						<td><a class="form-control sbmt" style="width:100px;" href="javascript:void(0);" onclick="candidateacceptance('Reject','<?php echo $app['application_no'];?>');">Decline</a></td>-->
						<td>
						
						<a class="form-control sbmt" style="width:100px;" href="<?php echo site_url();?>mission/processConfirmedappfromhqrs/<?php echo $app['application_no'];?>">Process</a>
						
						
						</td>
						</tr>
						<?php	
						$counter++;	
						}
						
					}
				}
				?>
			</tbody>
		</table>
		<hr/>
	</div>
</section>
	
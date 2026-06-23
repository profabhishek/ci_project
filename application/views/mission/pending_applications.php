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
			 <h3>Pending Application With Mission/Post</h3>
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
				<th>Country</th>	
				
				<th>Course</th>	
				<th>Universities Opts.</th>	
										
				<th style="width:226px;">Action </th>				
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($pending_applications)>0)
				{
					foreach($pending_applications as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>						
						<td><?php echo $app['fullname'];?></td>
						
						<td><?php echo  $app['email'];?></td>
						<td><?php echo $app['country_name'];?></td>							
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
								
						<td colspan="2"><a style="float:left;width:104px;margin-right:10px;" href="<?php echo site_url();?>mission/viewApplication/<?php echo $app['application_no'];?>/pending" class="form-control sbmt">Process</a>
						<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/viewfullApplication/<?php echo $app['application_no'];?>" class="form-control sbmt1">View</a></td>						
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
	
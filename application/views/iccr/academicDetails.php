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
	<div  class="container" style="min-height:410px;padding-top:16px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal 
	</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3> Applicant Academic Details</h3>
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
		
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>		
				<th>Applicantion Id</th>			
				<th>Applicant Name</th>							
				<th>Country</th>
				<th>Course</th>
				<th>University/Institute</th>	
				<th>Scheme</th>	
				<th>Applicant Status</th>	
				<th>Academic Status</th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($allarrived)>0)
				{
					foreach($allarrived as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>		
						<td><?php echo $app['application_id'];?></td>				
						<td><?php echo $app['fullname'];?></td>
						<td><?php $country = $this->common_model->getCountryById($app['country']); 
						echo $country[0]['country_name'];?></td>
						<td><?php $coures = $this->common_model->getCoursesById($app['course']); echo $coures[0]['title'];?></td>
						<td><?php $uni = $this->common_model->getUniversityById($app['university']); echo $uni[0]['name'];?></td>
						<td><?php $scheme = $this->common_model->getSchemeById($app['scheme']); echo $scheme[0]['scheme_name'];?></td>
						<td><?php echo strtoupper($app['academic_type']);?></td>
						<td>
						<?php
						if(strtoupper($app['academic_type']) =='NEW')
						{
						?>
						<a class="form-control sbmt1" style="height:35px;width:140px;" href="<?php echo site_url();?>headquarter/viewAcademicdetials/<?php echo base64_encode($app['application_id']);?>">View Details</a>
						<?php	
						}
						elseif(strtoupper($app['academic_type']) =='OLD')
						{
						?>
						<a class="form-control sbmt1" style="height:35px;width:140px;" href="<?php echo site_url();?>headquarter/viewAcademicdetialsold/<?php echo base64_encode($app['application_id']);?>">View Details</a>
						<?php	
						}
						?>						
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
</section>
	
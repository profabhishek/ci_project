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
			 <h3> Alumni Details</h3>
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
						
				<th>Applicant Name</th>
				<th>Country</th>
				<th>Email Id</th>
				<th>University</th>		
				<th>Course</th>		
				<th>View</th>	
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($alunamiapplication)>0)
				{
					foreach($alunamiapplication as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>						
						<td><?php echo $app['fullname'];?></td>	
						<td><?php $country = $this->common_model->getCountryById($app['nationality']); 
						echo $country[0]['country_name']
						?></td>
						<td><?php echo $app['email'];?></td>
						
						<td><?php
							if($app['unverisity'] == -1)
							{
								echo $app['other_unverisity'];
							}
							elseif($app['unverisity'] > 0)
							{
								$uni = $this->common_model->getUniversityById($app['unverisity']);
								echo $uni[0]['name'];
							}
							?>
						</td>
						<td><?php
							if($app['course'] == -1)
							{
								echo $app['other_course'];
							}
							elseif($app['course'] > 0)
							{
								$coursee = $this->common_model->getCoursesById($app['course']);
								echo $coursee[0]['title'];
							}
							?>
						</td>
						<td>
							<a class="form-control sbmt" style="width:100px;" href="<?php echo site_url();?>headquarter/viewAlumaniDetails/<?php echo base64_encode($app['application_id']);?>" target = "__blank">View</a>
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
	
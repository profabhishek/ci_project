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
.backbtn
{
	top:-32px;
}
marquee{
	
    border: 1px solid #cecece;
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto 5px;
    padding: 7px 5px 0 !important;
    text-align: left;
}
</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3> Alumni Details</h3>
			 <form method="post" action="<?php echo base_url();?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a class="form-control lnk" style="width:129px;"   href="<?php echo site_url();?>regional/alumniApplications">Add Alumni Details</a>
	<a href="<?php echo site_url();?>regional/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
						
				<th>Applicant Name</th>
				
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
							if($app['course'] == -1 || $app['course'] >=0)
							{
								echo $app['other_course'];
							}
							elseif($app['course'] >= 0)
							{
								$coursee = $this->common_model->getCoursesById($app['course']);
								echo $coursee[0]['title'];
							}
							?>
						</td>
						
						<td>
							<a class="form-control sbmt" style="width:100px;" href="<?php echo site_url();?>regional/viewAlumaniDetails/<?php echo base64_encode($app['application_id']);?>">View</a>
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
	
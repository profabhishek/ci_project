<style type="text/css">
	#frm_details_ngo {
    float: right;
    position: absolute !important;
    right: 0;
    top: 11px !important;
}
	#frm_details_ngo_one {
    float: right;
    position: absolute !important;
    right: 0;
    top: 11px !important;
}
.form_head h3 {
    font-weight: bold;    
}
.blue-heading h3
{
	margin-top: 13px !important;
	font-weight: bold;
    
}
.popup
{
	background: #fff none repeat scroll 0 0;
    min-height: 350px;
    padding: 10px;
    width: 63%;
}
.lnk
{
	 background: #747474 none repeat scroll 0 0;
    border: 1px solid;
    border-radius: 38px;
    box-shadow: 0 0 5px #fff inset;
    color: #fff;
    cursor: pointer;
    float: right;
    font-size: 11px;
    font-weight: bold;
    height: 30px;
    position: relative;
    right: 132px;
    top: -34px;
    width: 144px;
}
.lnk:hover
{
	background: #747474 none repeat scroll 0 0;
    color: #fff;
   
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
			Welcome <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3> Academic Details For New Students</h3>
			 <form method="post" action="<?php echo base_url();?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>regional/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>				
				<th>Applicant Name</th>							
				<th>Country</th>
				<th>Course</th>
				<th>University/Institute</th>
				<th>Arrival Date</th>				
				<th>Update Details</th>	
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($arrived)>0)
				{
					foreach($arrived as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>						
						<td><?php echo $app['fullname'];?></td>
						<td><?php echo $app['country_name'];?></td>
						<td><?php $corse = $this->common_model->getCoursesById($app['course']);
						echo $corse[0]['title'];?></td>						
						<td><?php 
						$uname ="";
						
						$data = $this->common_model->getConfirmationofApplicationIds($app['application_no']);
						 $uni = $this->common_model->getUniversityById($data[0]->regional_university);echo $uni[0]['name'];?>
						</td>	
							
						<td>
						<?php 
							$travelpl = $this->common_model->getTravelPlan($app['application_no']);
							if($travelpl[0]['arrival_date_ro'] != "")
							{
								echo $travelpl[0]['arrival_date_ro'];
							}							
						?>
						</td>					
						
						<td><a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/addcurrentAcademicDetails/<?php echo base64_encode($app['application_no']);?>">Update Details</a>
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
		
		<div class="blue-heading col-md-12 ">
			 <h3>Academic Details For Existing Students</h3>
			  <a class="form-control lnk"  href="<?php echo site_url();?>regional/addAcademicDetails">Add Academic Details</a>
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo_one" name="frm_details_ngo_one" style="width: 100%;position: relative;top: -43px;width:120px;">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		</div>
		
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdfone">
			<thead>
				<th>S.No.</th>				
				<th>Applicant Name</th>							
				<th>Country</th>
				<th>Course</th>
				<th>University/Institute</th>
				<th>Academic Status</th>					
				<th>Update Details</th>	
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($oldarrived)>0)
				{
					foreach($oldarrived as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>						
						<td><?php echo $app['fullname'];?></td>
						<td><?php $countr = $this->common_model->getCountryById($app['country']);
						echo $countr[0]['country_name'];?></td>
						<td><?php $corse = $this->common_model->getCoursesById($app['course']);
						echo $corse[0]['title'];?></td>
						<td><?php
						$uni = $this->common_model->getUniversityById($app['university']);
						echo $uni[0]['name'];
						 ?></td>
						<!--<td><?php echo $app['email'];?></td>-->
						
							
						<td><a href="<?php echo site_url();?>regional/accademicReportofOldStudent/<?php echo $app['application_id'];?>">View Details</a>
						 
						</td>					
						
						<td><a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/addAcademicDetails/<?php echo $app['application_id'];?>">Update Details</a>
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
	
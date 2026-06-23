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
			 <h3>Student/Research VISA Endorsement</h3>
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
				<th>University</th>
				
				<th>Country</th>
				<th>Undertaking Letter </th>			
				<!----<th>Process VISA</th>--->				
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($visaendrosment)>0)
				{
					foreach($visaendrosment as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['fullname'];?></td>
						<td><?php echo $app['email'];?></td>
						<td><?php $course = $this->common_model->getCoursesById($app['course']);echo $course[0]['title'];?></td>
						<td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);echo $uni[0]['scheme_name'];?></td>
						<td><?php
						//if(($app['programme'] == 1 && $app['course'] == 58) || ($app['programme'] == 2 && $app['course'] == 59))
						//{
						//	$data = $this->common_model->getconfirmationDataforfourthoptionHqrs($app['application_no']);
						//}
					//	else
						//{
							$data = $this->common_model->getConfirmationofApplicationIds($app['application_no']);
						//}
						//print_r($data);
						 $uni = $this->common_model->getUniversityById($data[0]->regional_university);echo $uni[0]['name'];?></td>
						<td><?php echo $app['country_name'];?></td>
						<td><a download href="<?php echo site_url();?>assets/site/main/undertakings/<?php echo $app['undertaking_doc'];?>">Download</td>
						<!-----<td>
						<?php 
						if($app['status'] == 13)
						{
							echo "Processed";
						}
						elseif($app['status'] == 11)
						{
							?>
						<a class="form-control sbmt" style="height:32px;width:95px;" href="<?php echo site_url();?>mission/scholarsvisaendrosment/<?php echo $app['application_no'];?>">Process</a>
						<?php
						}
						?>
						
						 
						</td>--->
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
	
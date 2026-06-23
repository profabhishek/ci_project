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
			 <h3>Acceptance/Declined by Applicant</h3>
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
				<th>View History </th>				
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($listofacceptance)>0)
				{
					foreach($listofacceptance as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<?php $date1 = '2021-03-15';
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
							} ?>
						<td><?php echo $app['fullname'].$app['middlename'].$app['familyname'].$new;?></td>
						<td><?php echo $app['email'];?></td>
						<?php $response = $this->common_model->getconfirmationDataByMission($app['application_no']); ?>
						<td><?php echo $response[0]['confirmed_course'];?></td>
						<td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);echo $uni[0]['scheme_name'];?></td>
										
						<td>
						<?php							
							if($app['scholar_acceptance'] == 1)
							{
								echo "Accepted";
							}
							elseif($app['scholar_acceptance'] == 2)
							{
								echo "Declined";
							}
							?>
							
						</td>						
					<td><a class="form-control sbmt1" style="width:100px;" href="<?php echo site_url();?>mission/historyview/<?php echo $app['application_no'];?>">View</a></td>	
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
	
	
	
	
	
	
	
	
	<div  class="container" style="min-height:410px;padding-top:16px;">
			
		<div class="blue-heading col-md-12 ">
			 <h3>Acceptance/Declined by Applicant Old</h3>
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
				<th>View History </th>		
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($listofoldacceptance)>0)
				{
					foreach($listofoldacceptance as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<?php $date1 = '2021-03-15';
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
							} ?>
						<td><?php echo $app['fullname'].$app['middlename'].$app['familyname'];?></td>
						<td><?php echo $app['email'];?></td>
						<?php $response = $this->common_model->getconfirmationDataByMission($app['application_no']); ?>
						<td><?php echo $response[0]['confirmed_course'];?></td>
						<td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);echo $uni[0]['scheme_name'];?></td>
										
						<td>
						<?php							
							if($app['scholar_acceptance'] == 1)
							{
								echo "Accepted";
							}
							elseif($app['scholar_acceptance'] == 2)
							{
								echo "Declined";
							}
							?>
							
						</td>						
					<td><a class="form-control sbmt1" style="width:100px;" href="<?php echo site_url();?>mission/historyoldview/<?php echo $app['application_no'];?>">View</a></td>
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
	
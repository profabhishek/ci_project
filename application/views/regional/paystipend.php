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
    width: 205px;
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
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>
			<h4 style="text-align:center;color:red;font-weight:bold;font-size:15px;font-family:arial;">For Enabling Payment Detail Link of Applicant, Please Update Course Duration & City in Academic Detail of Applicant. </h4>
			
			<h3 style="text-align:center;color:red;font-weight:bold;font-size:15px;font-family:arial;">Fund Balance for Current Quarter (<?php echo getStartOfQuarter() .' to '.getEndOfQuarter(); ?>): <?php if(count($quarterbalance)>0) echo $quarterbalance[0]['amount_released']; else echo "0 Balance"; ?></h3>
		<div class="blue-heading col-md-12 ">
			 <h3>New Applicant Expenditure Statement</h3>			 
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;width:120px;">
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
				<th>Application No</th>
				<th>Reference No</th>
				<th>Applicant Name</th>
				<th>University</th>
				<!--<th>Email Id</th>-->
				<th>Country</th>
						
				<th>Arrival Date</th>								
				<th>Payment Details</th>				
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
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['ref_no'];?></td>
						<td><?php echo $app['fullname'].' '.$app['middlename'].' '.$app['familyname'];?></td>
						<td><?php 
						$data = $this->common_model->getConfirmationofApplicationIds($app['application_no']);
						 $uni = $this->common_model->getUniversityById($data[0]->regional_university);echo $uni[0]['name'];?>
						</td>
						<!--<td><?php echo $app['email'];?></td>-->
						<td><?php echo $app['country_name'];?></td>
						
						<td>
						<?php 
						$travelpl = $this->common_model->getTravelPlan($app['application_no']);
						
							if($travelpl[0]['arrival_date_ro'] != "")
							{
								echo $travelpl[0]['arrival_date_ro'];
							}							
						?>
						</td>
						<td>
						<?php						
						$status = $this->common_model->getScholarshipStatusofApplicant($app['application_no']);
						
						if(count($status) <= 0)
						{
							if(count($quarterbalance)>0)
							{
							?>
							<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureUser/<?php echo base64_encode($app['application_no']);?>">Payment Details</a>
							<?php
							}
							else
							{
								?>
								<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureUser/<?php echo base64_encode($app['application_no']);?>">Payment Details</a>

							<!--<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Fund Shortage"/>-->

							<?php
							}
						}
						elseif(count($status)>0)
						{
							if($status[0]['scholarship_status'] == 2)
							{
								?>
							<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Detained"/>
							<?php
								
							}
							elseif($status[0]['scholarship_status'] == 4)
							{
								?>
							<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Finally Passed"/>
							<?php
								
							}
							else
							{
								if(count($quarterbalance)>0)
								{
								?>
							<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureUser/<?php echo base64_encode($app['application_no']);?>">Payment Details</a>
							<?php	
								}
								else
								{
									?>
			
<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureUser/<?php echo base64_encode($app['application_no']);?>">Payment Details</a>

							<!--<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Fund Shortage"/>-->
							<?php
								}	
								
							}	
							
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
		
		<div class="blue-heading col-md-12 ">
			 <h3>Expenditure Statement For Live Applicant </h3>
			 <!--<a class="form-control lnk"  href="<?php echo site_url();?>regional/regionalExpenditureForOldUser">Payment Details For Old Student</a>-->
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;width:120px;">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		</div>
		
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>
				
				<th>Applicant Name</th>
				
				<th>University</th>
				
				<th>Country</th>
												
				<th>Payment Details</th>
				
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
						<td><?php echo $app['application_id'];?></td>						
						<td><?php echo $app['name'];?></td>						
						<td><?php $counry = $this->common_model->getUniversityById($app['universty_choice']); echo $counry[0]['name'];?></td>	
						<td><?php $counry = $this->common_model->getCountryById($app['country']); echo $counry[0]['country_name'];?>
						</td>
						<!--<td><?php echo $app['email'];?></td>-->
						
						<td>
						<?php
						$status = $this->common_model->getScholarshipStatusofApplicant($app['application_id']);
						
						if(count($status) <= 0)
						{
							?>
							<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureForOldUser/<?php echo $app['application_id'];?>">Payment Details</a>
							<?php
						}
						elseif(count($status)>0)
						{
							if($status[0]['scholarship_status'] != -1)
							{
								if($status[0]['scholarship_status'] == 2)
								{
									?>
								<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Detained"/>
								<?php
								}
								elseif($status[0]['scholarship_status'] == 4)
								{
									?>
								<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Finally Passed"/>
								<?php
								}
								else
								{
								?>
								<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureForOldUser/<?php echo $app['application_id'];?>">Payment Details</a>
								<?php	
								}	
							}
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
	<?php
function getStartOfQuarter()
{
     return date(sprintf('01-%s-Y', floor((date('n') - 1) / 3) * 3 + 1));
}

function getEndOfQuarter()
{
    return date(sprintf('t-%s-Y', floor((date('n') + 2) / 3) * 3));
}
	?>
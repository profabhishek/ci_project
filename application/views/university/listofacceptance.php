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
			<marquee>Welcome <?php echo $universityData[0]['mission_name']; ?> to ICCR Scholarship Portal</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3>Acceptance/Declined by Applicant</h3>
			 <form method="post" action="<?php echo base_url();?>university/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>university/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		<div class="row">
		<!----<div class="col-12 col-sm-12 col-md-3 left-menu-sec">
			<div id="sidebar-wrapper">       
	        <ul class="sidebar-nav" id="sidebar">
	          <li><a href="<?php echo site_url(); ?>university/new_applications">Applications Received<span class="pull-right fltright"><?php echo $newCountApplication;?></span></a></li>	           
	          <li><a href="<?php echo site_url(); ?>university/pending_application">Pending Application<span class="pull-right fltright"><?php echo $countpending_application; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/resubmitapplication">Cases of Re-Subuniversity by Applicant<span class="pull-right fltright"><?php echo $countresubmitapplication; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/hold_applications">Applications on Hold<span class="pull-right fltright"><?php echo $countholdapplications; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/approved_applications">Processed Applications<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
	          <!-----<li><a href="<?php echo site_url(); ?>university/confirmaitonreceivesformhqrs">Confirmation from University/Institute<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
	           <li><a href="<?php echo site_url(); ?>university/listofacceptance">Acceptance/Decline by Applicant<span class="pull-right fltright"><?php echo $countlistofacceptance; ?></span></a></li>
			    <li><a href="<?php echo site_url(); ?>university/visaendrosment">Student/Research VISA Endorsement<span class="pull-right fltright"><?php echo $countvisaendrosment; ?></span></a></li>
	             <li><a href="<?php echo site_url(); ?>university/travel_applications">Travel Plan of Applicant<span class="pull-right fltright"><?php echo $counttravel; ?></span></a></li>
				 <li><a href="<?php echo site_url();?>university/addStream"><i class="fa fa-book"></i>Create Stream</a></li>
				  <li><a href="<?php echo site_url();?>university/addStreamMapping"><i class="fa fa-book"></i>Create Stream mapping</a></li>
				 <li><a href="<?php echo site_url();?>university/addPages"><i class="fa fa-book"></i> Create Page</a></li>
	        </ul>
      </div>
		</div>---->
		<div class="col-12 col-sm-12 col-md-12">
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>		
				<th>Applicantion No</th>
				<th>Applicant Name</th>	
				<th>Email Id</th>	
				<th>Country</th>
				<th>Programme</th>
			
				<th>Scheme</th>							
				<th>Status</th>
				<th>View</th>			
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($listofacceptance)>0)
				{
					foreach($listofacceptance as $app)
					{
						//echo "<pre>";print_r($app);die
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $new.$app['fullname'].' '.$app['middlename'].' '.$app['familyname'];?></td>
						<td><?php echo $app['email'];?></td>
						<td><?php $country = $this->common_model->getCountryById($app['nationality']);
						echo $country[0]['country_name'];
						?></td>
						<td><?php $progrm = $this->common_model->getProgrammeById($app['programme']);
			            echo $progrm[0]['name'];?></td>
				
						<td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);
						if(!empty($uni)){
						echo $uni[0]['scheme_name'];
						}else{
							echo "NA";
						}
					?></td>		
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
							elseif($app['scholar_acceptance'] == -1)
							{
								echo "Pending";
							}
							?>
							
						</td>						
					<td><a class="form-control sbmt1" style="width:100px;" href="<?php echo site_url();?>university/historyview/<?php echo base64_encode($app['application_no']);?>">View</a></td>	
						</tr>
						<?php	
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
		</div>
		</div>
		<hr/>
	</div>
</section>
	
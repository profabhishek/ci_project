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
	<marquee>Welcome to ICCR Scholarship Portal</marquee>		
		<div class="blue-heading col-md-12 ">
			 <h3>NIRF Ranking</h3>
			 <!------<form method="post" action="<?php echo base_url();?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>---->
	<!----<a href="<?php echo site_url();?>mission/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>---->
		</div>
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				<th>Name</th>
				<th>State</th>
				<th>Rank</th>
							
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($nirfRank)>0)
				{
					foreach($nirfRank as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php $universities = $this->common_model->getUniversityById($app['university_id']);echo $universities[0]['name'];?></td>
						<td><?php $states = $this->common_model->getStatesById($app['state_id']);echo $states[0]['name'];?></td>
						<td><?php echo $app['rank'];?></td> 
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
	
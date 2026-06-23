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
	top:9px;
}
.divider{
	margin:0;
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
.pops
{
	background: white none repeat scroll 0 0;
    border: 2px solid rgba(0, 0, 0, 0.3);
    min-height: 150px;
    padding: 20px;
    text-align: center;
}
</style>
<style type="text/css">
.tweaked-margin{margin-right:5px !important;}
.list-group {
	list-style: decimal inside;
}

.list-group-item {
	display: list-item;
}
</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:15px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>	
		<div class="blue-heading col-md-12 ">
			 <h3 style="float:left;">Complaints Received</h3>
			
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
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
							<th>Application No.</th>
							<th>Complaint Number</th>
							<th>Category</th>
							<th>Description</th>
							<th>Complaint Status</th>	
							<th>Process</th>			
						</thead>
						<tbody>	
							<?php 
							if(count($complaints)>0)
							{
								$counter = 1;
								foreach($complaints as $complaint)
								{
									?>
									<tr>
										<td><?php echo $counter;?></td>
										<td><?php echo $complaint['appid'];?></td>
										<td><?php echo $complaint['cid'];?></td>
										<td><?php $c = $this->common_model->getComplaintCatById($complaint['category']); echo $c[0]['category'];?></td>
										<td><?php echo $complaint['descripton'];?></td>
										<td>Under Process</td>
										<td><a class="form-control sbmt" style="height:32px;width:140px;" href="<?php echo site_url();?>regional/forwardtouniversity/<?php echo $app['application_no'].'/'.$optNo;?>">Process</a></td>
									</tr>
									<?php	
									$counter++;
								}
							}
							
							?>					
														
						</tbody>
					</table>
	</div>
</section>

	
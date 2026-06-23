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
</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal 
	</marquee>
	<div class="blue-heading col-md-12 ">
			 <h3>Demands by Regional Offices</h3>			
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;width:120px;">
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
				<th>Demand No</th>				
						
				<th>Financial Year</th>				
				<th>Regional Office</th>		
				<th>RO Remarks</th>	
				<th>Demand Date</th>			
				<th>Demand Document</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($demands)>0)
				{
					foreach($demands as $app)
					{						
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['demand_id'];?></td>						
						<td><?php echo $app['financial_year'];?></td>
						<td><?php $reg = $this->common_model->getRegionById($app['regional_office']); echo $reg[0]['name'];?></td>						
						<td><?php echo $app['remarks'];?></td>
						<td><?php echo date('d M Y h:i:s A',$app['created']);?></td>	
						<td><a href="<?php echo site_url();?>/assets/site/main/demands/<?php echo $app['document'];?>">Download</a></td>	
						<td><a class="form-control sbmt" href="<?php echo site_url();?>headquarter/processDemand/<?php echo $app['demand_id'];?>">Process</a></td>	
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
	
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
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>
	<div class="blue-heading col-md-12 ">
			 <h3>Demands to Hqrs</h3>			 
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;width:120px;">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		</div>
		
	<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				<th>Demand No</th>				
				<th>Financial Year</th>				
				<th>Remarks by Hqrs</th>	
				<th>Demand Date</th>
				<th>Process Date</th>	
				<th>Status</th>			
				<th>Document</th>
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
						<td><?php echo $app['status_remarks'];?></td>
						<td><?php echo date('d M Y h:i:s A',$app['created']);?></td>	
						<td><?php echo date('d M Y h:i:s A',$app['status_date']);?></td>	
						<td><?php
							if($app['status'] == 1)
							{
								echo "Sanctioned";
							}
							elseif($app['status'] == 2)
							{
								echo "Not Sanctioned";
							}
							?></td>
						<td><a href="<?php echo site_url();?>/assets/site/main/demands/<?php echo $app['status_doc'];?>">Download</a></td>	
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
	
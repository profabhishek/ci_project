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

</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">
		<marquee>Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3>Alumini Details</h3>
			 <form method="post" action="<?php echo base_url();?>mission/downloadFile/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
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
				<th>Country</th>
				<th>Download</th>	
				<!----<th>Uplod</th>---->
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($alumindetails)>0)
				{
					foreach($alumindetails as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php 
						$country = $this->common_model->getCountryById($app['country']);
						echo $country[0]['country_name'];
						
						?>
						
						</td>
						<td><a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/downloadFile" class="form-control sbmt1">Download</a></td>						
						
						
						<!-----<td><a href="#"  data-toggle="modal" data-target="#aluminiDiv">Upload</a></td>----->
						</tr>
						<?php	
						$counter++;	
					}
				}
				?>
				
<div id="aluminiDiv" class="modal fade" role="dialog">
  	<div id="alumini" class="modal-dialog popup dropzone">
  		<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  	</div>
</div>
			</tbody>
		</table>
		<hr/>
		
	</div>

</div>

</section>

	<script src="<?php echo base_url();?>assets/site/main/js/bootbox/bootbox.min.js"></script>

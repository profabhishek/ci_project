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
</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">
		
		<div class="blue-heading col-md-12 ">
			 <h3> Applicant Expenditure Statement</h3>
			 <form method="post" action="<?php echo base_url();?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
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
				<th>Status </th>			
				<th>Travel Plan</th>								
				<th>Payment Details</th>
				<th>Download Expenditure</th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($travel)>0)
				{
					foreach($travel as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['ref_no'];?></td>
						<td><?php echo $app['fullname'];?></td>
						<td><?php 
						$uname ="";
						$region = $app['region_one_status'];
						if($region == $app['university_choice_one_state']){
							$university = $this->common_model->getUniversityById($app['universty_choice']);		
							$uname = $university[0]['name'];			
						}
						if($region == $app['university_choice_two_state']){
							if($uname == "")
							{
								$university = $this->common_model->getUniversityById($app['universty_choice_two']);
								$uname = $university[0]['name'];
							}
							else
							{
								$university =  $this->common_model->getUniversityById($app['universty_choice_two']);
								$uname .= "<br/>".$university[0]['name'];
							}							
						}
						if($region == $app['university_choice_three_state']){
							if($uname == "")
							{
								$university = $this->common_model->getUniversityById($app['universty_choice_three']);
								$uname = $university[0]['name'];
							}
							else
							{
								$university = $this->common_model->getUniversityById($app['universty_choice_three']);
								$uname .= "<br/>".$university[0]['name'];
							}							
						}
						echo $uname;
						?></td>
						<!--<td><?php echo $app['email'];?></td>-->
						<td><?php echo $app['country_name'];?></td>
						<td>Accepted by Scholar	</td>
						<td>
						<?php 
							if($app['travel_arrival_date'] != "")
							{
								echo $app['travel_arrival_date'];
							}							
						?>
						</td>
						<td>
							<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureUser/<?php echo $app['application_no'];?>">Payment Details</a>
						</td>
						<td>
							<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/downloadExpenditure/<?php echo $app['application_no'];?>">Download</a>
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
	
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
	<div  class="container" style="min-height:410px;padding-top:50px;">
		<div class="blue-heading col-md-12">
			 <h3>Confirmation from Hqrs to Mission</h3>
		</div><br><br>
		<table class="customTable table table-striped table-bordered">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>
				<th>Reference No</th>
				<th>Applicant Name</th>
				<th>University</th>
				<th>Email Id</th>
				<th>Country</th>
				<th>Status </th>			
								
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($confirmationForwardtoMissionbyHqrs)>0)
				{
					foreach($confirmationForwardtoMissionbyHqrs as $app)
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
						<td><?php echo $app['email'];?></td>
						<td><?php echo $app['country_name'];?></td>
						<td>Confirmed
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

	
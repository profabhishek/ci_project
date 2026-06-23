<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:50px;">
		<div class="blue-heading col-md-12">
			 <h3>Rejected Application</h3>
		</div><br/><br/>		
		<table class="customTable table table-striped table-bordered">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>					
				<th>Applicant Name</th>
				<th>Session</th>
				<th>Email Id</th>				
				<th>Status</th>								
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($rejectedApplication)>0)
				{
					foreach($rejectedApplication as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['application_no'];?></td>						
						<td><?php echo $app['fullname'];?></td>
						<td>2017-18</td>
						<td><?php echo $app['email'];?></td>						
						<td>Rejected &nbsp;&nbsp; <a target="_blank" href="<?php echo site_url(); ?>mission/viewfullApplication/<?php echo $app['application_no'];?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>							
						<!--<td><a href="<?php echo site_url();?>misson/exportContactform">Contact Form</a>| <a href="#">Application Form</a>-->
						<!--<td><a href="<?php echo site_url();?>mission/exportContactDetails/<?php echo $app['application_no'];?>">Contact Form</a>| <a href="<?php echo site_url();?>misson/exportApplication/<?php echo $app['application_no'];?>">Application Form</a>
						</td>-->
						<!--<td><a href="<?php echo site_url();?>mission/checklist/<?php echo $app['application_no'];?>">Recommend</a>| <a href="<?php echo site_url();?>mission/rejected/<?php echo $app['application_no'];?>">Reject</a></td>-->
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
	
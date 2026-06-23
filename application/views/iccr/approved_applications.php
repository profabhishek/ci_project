<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:50px;">
		<div class="blue-heading col-md-12">
			 <h3>Approved Application</h3>
		</div><br><br>
		<table class="customTable table table-striped table-bordered">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>
				<th>Applicant Name</th>
				<th>Session</th>
				<th>Email Id</th>
				<th>Country</th>
				<th>Process </th>				
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($rosapplication)>0)
				{
					foreach($rosapplication as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['fullname'];?></td>
						<td>2017-18</td>
						<td><?php echo $app['email'];?></td>
						<td><?php echo $app['country_name'];?></td>
						<td><a href="<?php echo site_url();?>headquarter/application/<?php echo $app['application_no'];?>">Process</a></td>						
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
	
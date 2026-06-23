<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:50px;">
		<div class="blue-heading col-md-12">
			 <h3>English Proficiency Test Result</h3>
		</div><br><br>
		<table class="customTable table table-striped table-bordered">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>
				<th>Reference No </th>		
				<th>Applicant Name</th>				
				<th>Email Id</th>	
				<th>Marks</th>			
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($results)>0)
				{
					foreach($results as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['ref_no'];?></td>
						<td><?php echo $app['fullname'];?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php echo $app['english_proficiency_test_marks'];?></td>
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
	
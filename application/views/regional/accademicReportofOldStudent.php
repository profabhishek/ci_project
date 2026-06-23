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
<?php 
$stateuniversities = $this->common_model->getStateUniversities();
$centraluniversities = $this->common_model->getCentralUniversities();
$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states =  $this->common_model->getAllStates();
$statewiseUniversites = array();
foreach($states as $st)
{
	if(!array_key_exists($st['id'],$statewiseUniversites))
	{
		$statewiseUniversites[$st['id']] = array();
	}
}
//print_r($states);
$stateuniversities_one = str_replace("'","\'",json_encode($stateuniversities));
$centraluniversities_one = str_replace("'","\'",json_encode($centraluniversities));
$nits_one = str_replace("'","\'",json_encode($nits));
$yogas_one = str_replace("'","\'",json_encode($yogas));
$states_array = json_encode($statewiseUniversites);
?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
var centralUniversities = JSON.parse('<?php echo $centraluniversities_one;?>');
var nits = JSON.parse('<?php echo $nits_one;?>');
var yogas = JSON.parse('<?php echo $yogas_one;?>');
var statesarray = JSON.parse('<?php echo $states_array;?>');
</script>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">
		
		<div class="blue-heading col-md-12 ">
			 <h3> Academic Report of Application No : <?php echo $this->uri->segment(3); ?> </h3>
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		</div>
		
		<div class="tab-content">		
	  		<div id="home" class="tab-pane fade in active">
	  			 <div class="box-body detailpagepdf">
	  			 	<table id="tbl_vertical" class="table table-striped table-bordered">
	  			 		<tbody>
	  			 			<tr class="trr">
	  			 				<td>Application No.</td>
	  			 				<td><?php echo $this->uri->segment(3); ?></td>
	  			 			</tr>
	  			 			<tr class="trr">
	  			 				<td>Name</td>
	  			 				<td><?php echo $academic[0]['fullname']; ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td>Country</td>
	  			 				<td> <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
									  if($country['id'] == $academic[0]['country'])
									  {
										  echo $country['country_name'];
									  }									  
								  }
								  ?></td>
	  			 			</tr>
	  			 			<tr class="trr">
	  			 				<td>Level of Programme</td>
	  			 				<td><?php
								  $programme = $this->common_model->getAllProgramme();
								  foreach($programme as $prog)
								  {
								  		if($prog['id'] != 5 && $prog['id'] != 6 && $prog['id'] != 7)
								  		{
											if($prog['id'] == $academic[0]['programme'])
											  {
												echo $prog['name'];
											  }											  
										} 
								  }
								  ?>								 
							</td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td>Course</td>
	  			 				<td>  <?php
								  $courses = $this->common_model->getAllCourses();
								  foreach($courses as $course)
								  {
									  if($course['id'] == $academic[0]['course'])
									  {
										echo $course['title'];
									  }
								  }
								  if($academic[0]['course'] == -1){
									  echo $academic[0]['other_course'];
								  }
								  ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td>Course Duration</td>
	  			 				<td>  <?php
									echo $academicDetails[0]['course_duration_from'].' - '.$academicDetails[0]['course_duration_to'];
								  ?></td>
	  			 			</tr>
	  			 			<tr class="trr">
	  			 				<td>University/Institute</td>
	  			 				<td> <?php
								
				 				foreach($stateuniversities as $univercity)
								{											
									if(array_key_exists($univercity['state_id'],$statewiseUniversites))
									{													
										array_push($statewiseUniversites[$univercity['state_id']],$univercity);
									}
								}	 
								foreach($statewiseUniversites as $key=>$univercity1)
								{
									if(count($univercity1)>0)
									{
										$statenames = $this->common_model->getStateById($key);	
										foreach($univercity1 as $uni_choice)
										{
											if(!empty($academic))
											{
												if($academic[0]['university'] == $uni_choice['id'])
												{
													echo $uni_choice['uni'];											
												}
											}
										}
													
									}	
								}
								foreach($centraluniversities as $univercity_cnet)
								{				
									if(!empty($academic))
									{
										if($academic[0]['university'] == $univercity_cnet['id'])
										{
											echo $univercity_cnet['uni'];
										}
									}
							    }
							    foreach($nits as $univercity_nit)
								{		
									if(!empty($academic))
									{
										if($academic[0]['university'] == $univercity_nit['id'])
										{
											$univercity_nit['uni'];
										}
									}
							    }
					 			foreach($yogas as $univercity_yogs)
								{		
									if(!empty($academic))
									{
										if($academic[0]['university'] == $univercity_nit['id'])
										{
											echo $univercity_yogs['uni'];
										}
									}
							    }
								
						    ?>	</td>
	  			 			</tr>
							<tr>
	  			 				<td>Institute Name</td>
	  			 				<td> <?php
								  if(!empty($academic)){
									  echo $academic[0]['institute_name'];
								  }
								  ?></td>
	  			 			</tr>
							<tr>
	  			 				<td>Govt/Private</td>
	  			 				<td> <?php
								  if(!empty($academic)){
									  if($academic['govt_pvt'] == 1){
										  echo "Govt";
									  }else{
										  echo "Private";
									  }
								  }
								  ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td>Scheme</td>
	  			 				<td> <?php
								  $code = "";
								  $schemes = $this->common_model->getAllSchemess();
								 
								  foreach($schemes as $scheme)
								  {								  		
								  		if(!empty($academic))
					      		  		{
											if($academic[0]['scheme'] == $scheme['id'])
											{
												echo $scheme['scheme_name'];
											}
											
										}
								  }
								  ?></td>
	  			 			</tr>
							
	  			 		</tbody>
	  			 	</table> 			 
              		
				
					<hr/>
					<table id="tbl_schrls" class=" table table-striped table-bordered ">
			<thead>
				<th>Academic Year</th>				
				<th>Annual/Semester</th>							
				<th>Duration of Annual/Semester</th>
				<th>Academic Status</th>
				<th>Attendance %age</th>
				<th>Scholarship Status</th>				
			</thead>
			<tbody>
				<?php 				
				$counter=1;				
				if(count($academicStatus)>0)
				{
					foreach($academicStatus as $app)
					{
						?>
						<tr>											
						<td><?php echo $app['aca_year'];?></td>	
						<td><?php 
						if($app['is_sem'] == 1)
						{
							echo romanic_number($app['sem_no'],TRUE).' Semester';	
						}
						elseif($app['is_sem'] == 2)
						{
							echo romanic_number($app['annual_no'],TRUE).' Year';	
						}
						?></td>						
						<td><?php 
						echo $app['date_from'].' to '.$app['date_to'];?></td>
						<td><?php 
							switch($app['status'])
							{
								case "1":
									echo "Promoted (".$app['promoted_percentage']."%)";
								break;
								case "2":
									$detainedReson = $this->config->item('detainedReason');
									echo "Detained (due to ".$detainedReson[$app['detained_reason']].")";
								break;
								case "3":
									echo "Backlogs (No of Backlogs: ".$app['backlog_no']."%)";
								break;
								case "4":
									echo "Finally Passed (with ".$app['finally_passed_percent']."%)";
								break;
							}
						?></td>
						<td><?php
							if($app['attendance_percentage'] != -1 && $app['attendance_percentage'] != "")
							{
								echo $app['attendance_percentage'].'%';
							}
							else 
							{
								echo "NA";
							}?></td>
							<td>
							
							<?php
							if($app['scholarship_status'] != -1 && $app['scholarship_status'] != "")
							{
								switch($app['scholarship_status'])
								{
									case "1":
										echo "Continued";
									break;
									case "2":
										echo "Detained";
									break;
									case "3":
										echo "Renewed";
									break;	
									case "4":
										echo "Self Financed";
									break;
									case "5":
										echo "Terminated<br/>(".$app['remarks_terminated'].")<br/><a href='".site_url()."assets/site/main/terminatedDoc/".$app['term_file']."'>Download Termination Letter</a>";
										
									break;											
								}
							}
							else 
							{
								echo "NA";
							}
							 
							?></td>
						</tr>
						<?php	
						$counter++;	
					}
				}
				else
				{
					echo '<tr><td colspan="6">Academic Status Not Updated Yet!</td></tr>';
				}
				?>
			</tbody>
		</table>
	  			 </div>
	  		</div>
	  	</div>	
		
		
		<hr/>
	</div>
</section>
		<?php
	function romanic_number($integer, $upcase = true) 
{ 
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
    $return = ''; 
    while($integer > 0) 
    { 
        foreach($table as $rom=>$arb) 
        { 
            if($integer >= $arb) 
            { 
                $integer -= $arb; 
                $return .= $rom; 
                break; 
            } 
        } 
    } 

    return $return; 
} 
	?>
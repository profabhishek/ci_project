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
.blue-heading{
	 margin-bottom: 0;
}
.prfl
{
	border: 4px double #cecece;
    height: 142px;
    padding: 0;
    position: absolute;
    right: 36px;
    text-align: center;
    top: 78px;
    width: 142px;
     z-index: 11111111;
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
			 <h3> Academic Report of Application No : <?php echo base64_decode($this->uri->segment(3)); ?> </h3>
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadList/<?php echo base64_decode($this->uri->segment(3)); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		</div>
		
		<div class="tab-content">		
	  		<div id="home" class="tab-pane fade in active">
	  			 <div class="box-body detailpagepdf" style="position:relative;top:25px;">
	  			 	 	<div class="col-xs-3 prfl pull-right" style="  height: 152px;
    margin-top: 0;
    position: absolute;
    top: 25px;
    width: 151px;
    z-index: 11111;">
              		<?php 
              			if($userImage == "")
              			{
						?>
						<img style="width:142px;height:142px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png"/>
						<?php	
						}
						else
						{
						?>
						<img style="width:142px;height:142px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
						<?php		
						}
              		?>
              	</div>
	  			 	<table id="tbl_vertical" class="table table-striped table-bordered">
	  			 		<tbody>
	  			 			<tr class="trr">
	  			 				<td>Application No.</td>
	  			 				<td><?php echo base64_decode($this->uri->segment(3)); ?></td>
	  			 			</tr>
	  			 			<tr class="trr">
	  			 				<td>Name</td>
	  			 				<td><?php echo $applicaitonStepOne[0]['fullname']; ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td>Country</td>
	  			 				<td> <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
									  if($country['id'] == $applicaitonStepOne[0]['country'])
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
											if($prog['id'] == $applicaitonStepOne[0]['programme'])
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
									  if($course['id'] == $applicaitonStepOne[0]['course'])
									  {
										echo $course['title'];
									  }
								  }
								  ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td>Course Duration</td>
	  			 				<td>  <?php	  			 				
	  			 				if(!empty($academic_data))
	  			 				{
									 echo $academic_data[0]['course_duration_from'];
									 echo ' to ';
									  echo $academic_data[0]['course_duration_to'];
								}
								 
								  ?></td>
	  			 			</tr>
	  			 				<tr>
	  			 				<td>Joining Date</td>
	  			 				<td>  <?php	  			 				
	  			 				if(!empty($mapdata) && $mapdata[0]['joining_date'] != "")
	  			 				{
									 echo $mapdata[0]['joining_date'];									
								}
								else
								{
									echo "Not Updated";
								}
								 
								  ?></td>
	  			 			</tr>
	  			 				<tr>
	  			 				<td>Compeletion Date</td>
	  			 				<td>  <?php	  			 				
	  			 				if(!empty($mapdata) && $mapdata[0]['completion_date'] != "")
	  			 				{
									 echo $mapdata[0]['completion_date'];									
								}
								else
								{
									echo "Not Updated";
								}
								 
								  ?></td>
	  			 			</tr>
	  			 			<tr class="trr">
	  			 				<td>University/Institute</td>
	  			 				<td> <?php
								$univ = $this->common_model->getUniversityById($universityData[0]['regional_university']);
              					echo $univ[0]['name'];
								
						    ?>	</td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td>Scheme</td>
	  			 				<td> <?php
								  $code = "";
								  $schemes = $this->common_model->getAllSchemes();
								 
								  foreach($schemes as $scheme)
								  {								  		
								  		if(!empty($mapdata))
					      		  		{
											if($mapdata[0]['scholarship_id'] == $scheme['id'])
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
				if(count($academic)>0)
				{
					foreach($academic as $app)
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
						if($app['date_from'] != "" && $app['date_to'] != "") 
						echo $app['date_from'].' to '.$app['date_to'];
						else echo "NA";?></td>
						<td><?php 
							switch($app['status'])
							{
								case "1":
									echo "Promoted (".$app['promoted_percentage']."%)";
								break;
								case "2":
									echo "Detained (due to ".$app['detained_reason'].")";
								break;
								case "3":
									echo "Backlogs (No of Backlogs: ".$app['backlog_no']."%)";
								break;
								case "4":
									echo "Finally Passed (with ".$app['finally_passed_percent']."%)";
								break;
								default:
									echo "NA";
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
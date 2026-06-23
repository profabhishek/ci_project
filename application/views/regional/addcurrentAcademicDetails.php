<?php //echo "<pre>";print_r($applicaitonStepOne);die;?>
<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:125px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;font-weight: bold;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
.form-horizontal .control-label {
    
    margin-bottom: 0;
    text-align: left;
    font-size: 12px;
    padding: 0;
    padding-top: 7px;
    width: 135px;
}
.form-group{
    margin-right: 0 !important;
    padding-left: 0;
    padding-right: 0;
    width: 100%;
}
.filter
{
	 border-bottom: 1px solid #cecece;
    border-top: 1px solid #cecece;
    margin-bottom: 36px;
    margin-top: 30px;
    padding-bottom: 15px;
    padding-top: 10px;
}

.filter1,.filter2
{
	border-bottom: 1px solid #cecece;
    border-top: 1px solid #cecece;
    margin-bottom: 36px;   
    padding-bottom: 15px;
    padding-top: 10px;
}
.filter label{padding-right:0;padding-top:10px;width:150px;}
.filter1 label{padding-right:0;padding-top:10px;width:150px;}
.filter2 label{padding-right:0;padding-top:10px;width:150px;}
.customdate{width:116px;}
input,select,label{font-size:14px !important;}
.tab-content input[type="text"], select {
    background: #FFEE75 none repeat scroll 0 0 !important;
    color: #747474 !important;
    font-size: 14px !important;
    font-weight: bold;
}
.tab-content  input[readonly]
{
     background-color: #ccde8f !important;
    color: #000 !important;
}
.rpt{
	 border: 1px solid #cecece;
    border-radius: 24px;
    color: #747474;
    float: right;
    font-weight: bold;
    padding: 6px;
    text-align: center;
    width: 129px;
}

</style>

<script type="text/javascript">
function shwsem(id)
{
	var vall = $('#' + id).val();
	if(vall == 1)
	{
		$('.sem').show();
		$('.annual').hide();
		$('.seman').show();
	}
	else if(vall == 2)
	{
		$('.annual').show();
		$('.sem').hide();
		$('.seman').show();
	}
}
	$(function(){
		$('.seman').hide();
		$('.sem').hide();
		$('.annual').hide();
		$('.finally_pass_percentage').hide();
		$('.prom_details').hide();
		$('.det_details').hide();
		$('.back_details').hide();
		$('.terminated_details').hide();
		//$('.atte_details').hide();
		//$('.schlr_details').hide();
					
	//	$('.signt').hide();
		//$('.filter1').hide();
		//$('.filter2').hide();
	});	
	function showteminated(id)
	{
		var v = $('#' + id).val();
		if(v==5)
		{
			$('.terminated_details').show();
		}
		else
		{
			$('.terminated_details').hide();
		}
	}
	function showFilters(id)
	{
		
		var FilterType = $('#' +  id).val();
		$('.panel-default').hide();
		$('.signt').hide();
		$('.filter1').hide();
		$('.filter2').hide();
		switch(FilterType)
		{
			case "1":
			$('.filter1').show();
			break;
			case "2":
			$('.atte_details').show();	
			$('.signt').show();	
			break;
			case "3":
			$('.schlr_details').show();
			$('.signt').show();					
			break;	
							
			break;					
		}
	}
	function studentFilters(id)
	{
		var FilterType = $('#' +  id).val();
		//$('.panel-default').hide();
		$('.signt').hide();
		$('.filter1').show();
		switch(FilterType)
		{
			case "1":
			$('.prom_details').show();
			$('.det_details').hide();
			$('.back_details').hide();
			$('.finally_pass_percentage').hide();
			$('.signt').show();
			break;
			case "2":
			$('.det_details').show();			
			$('.prom_details').hide();			
			$('.back_details').hide();
			$('.finally_pass_percentage').hide();
			$('.signt').show();
			break;
			case "3":
			$('.back_details').show();
			$('.det_details').hide();			
			$('.prom_details').hide();
			$('.finally_pass_percentage').hide();
			$('.signt').show();
			break;
			case "4":
			$('.finally_pass_percentage').show();
			$('.back_details').hide();
			$('.det_details').hide();			
			$('.prom_details').hide();
			
			$('.signt').show();	
			break;			
		}
	}	
	function fillYears(id)
	{
		var v = $('#' + id).val();
		var yrs = v.split('-');
		var ht = "<option value=''>Year</option>";
			ht += "<option value='"+ yrs[0] +"'>" + yrs[0] + "</option>";
			ht += "<option value='"+ yrs[1] +"'>" + yrs[1] + "</option>";
		$('#from_year').html(ht);
		$('#to_year').html(ht);	
	}
</script>
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


<?php
	    	if($this->session->flashdata('message_type') == "success")
	    	{
			?>
			<div class="alert alert-success" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
			</div>
			<?php	
			}
			if($this->session->flashdata('message_type') == "error")
	    	{
			?>
			<div class="alert alert-error" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>
			</div>
			<?php	
			}
	    	
	    	?>

<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Academic & Attendance Details of Applicant</h3>	
		<h4 class="text-center caps">APPLICATION NUMBER : <?php if(!empty($appno)){ echo $appno; } ?></h4>	
	</div>	
	<div class="headsec container">Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal </div>
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>regional/studentAcademicCurrent/<?php echo $appno;?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">				
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Name</label>
					    <div class="col-sm-8">
					      <?php
					      if(!empty($applicaitonStepOne))
					      {
					      ?>
						  <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Name" value="<?php echo $applicaitonStepOne[0]['fullname']; ?>" readonly="true" >
						  <?php	
					      }
					      else
					      {
						  ?>
						  <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Name" >
						  <?php
						  }
					      ?>	
					     
					    </div>
					</div>
              		<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Country</label>
					    <div class="col-sm-8">
					     <?php 
					    if(!empty($applicaitonStepOne))
						{
						  $countries = $this->common_model->getCountries();								  
						  foreach($countries as $country)
						  {
							  if(!empty($applicaitonStepOne))
							  {
								  if($country['id'] == $applicaitonStepOne[0]['country'])
								  {
									  echo '<input readonly="true" type="text" class="form-control" value="'.$country['country_name'].'"/>';
								  }								 
							  }
						  }	
						}
						else
						{
						?>
						 <select id="country" name="country" class="selectpicker form-control" readonly="true" >
								  <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
									  if($country['id'] == $applicaitonStepOne[0]['country'])
									  {
										  echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
									  }									  
								  }
								  ?>
							</select>
						<?php	
						}
					    ?>
						    
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Level of Programme</label>
					    <div class="col-sm-8">
					    
					    <?php
					    		if(!empty($applicaitonStepOne))
					    		{
									  $programme = $this->common_model->getAllProgramme();
									  foreach($programme as $prog)
									  {
									  		if($prog['id'] != 5 && $prog['id'] != 6 && $prog['id'] != 7)
									  		{
												if($prog['id'] == $applicaitonStepOne[0]['programme'])
												  {
													echo '<input readonly="true" type="text" class="form-control" value="'.$prog['name'].'"/>';
												  }
											} 
									  }
								}
								else
								{
								?>
								 <select id="programme1" name="programme1" class="selectpicker form-control" readonly="true">	
								  <?php
								  $programme = $this->common_model->getAllProgramme();
								  foreach($programme as $prog)
								  {
								  		if($prog['id'] != 5 && $prog['id'] != 6 && $prog['id'] != 7)
								  		{
											if($prog['id'] == $applicaitonStepOne[0]['course'])
											  {
												echo '<option selected="selected" value="'.$prog['id'].'">'.$prog['name'].'</option>';
											  }											  
										} 
								  }
								  ?>								 
							</select>
								<?php	
								}
					    		 
					    	?>
					     
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Course</label>
					    <div class="col-sm-8">
					    
					    <?php
					    	if(!empty($applicaitonStepOne))
					    	{							
							  $courses = $this->common_model->getAllCourses();
							  foreach($courses as $course)
							  {
								  if($course['id'] == $applicaitonStepOne[0]['course'])
								  {
									echo '<input readonly="true" type="text" class="form-control" value="'.$course['title'].'"/>';
								  }
							  } 	
							}
							else
							{
							?>
								   <select id="course1" name="course1" class="selectpicker form-control" readonly="true">	
								  <?php
								  $courses = $this->common_model->getAllCourses();
								  foreach($courses as $course)
								  {
									  if($course['id'] == $applicaitonStepOne[0]['course'])
									  {
										echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
									  }
								  }
								  ?>
							</select>
							<?php	
							}	
					    	?>
					    
					   
					    </div>
					</div>
					
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">University/Institute</label>
					    <div class="col-sm-8">
					    <?php
					    $apno = $this->uri->segment(3);
					    $data = $this->common_model->getConfirmationofApplicationIds($apno);
						$uni = $this->common_model->getUniversityById($data[0]->regional_university);
					    echo '<input readonly="true" type="text" class="form-control" value="'.$uni[0]['name'].'"/>';
					    ?>
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Scheme</label>
					    <div class="col-sm-8">
					    <?php
					    
					    	$scheme = $this->common_model->getSchemeById($mapdata[0]['scholarship_id']);
					    	echo '<input readonly="true" type="text" class="form-control" value="'.$scheme[0]['scheme_name'].'"/>';
					    ?>
					    </div>
					</div>
					<div class="form-group col-xs-9 ">
					    <label for="inputEmail3" class="col-sm-2">Course Duration</label>
					    <div class="col-sm-3">
					    <?php
					    	if(!empty($academic))
					    	{
								echo '<input readonly="true" type="text" class="form-control" value="'.$academic[0]['course_duration_from'].'"/>';
							}
							else
							{
							?>
							 <select id="course_duration_from" name="course_duration_from" class="form-control" required="true">
							  <option value="">Year</option>
							  <?php
							  
							  $strt = date('Y');
							  $previousyear = $strt -2;
							  	for($i=$previousyear; $i<=$previousyear+10; $i++)
							  	{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}							  	
							  ?>							 							  
							</select>
							<?php	
							}
					    	?>
					     
					    </div>
					   <label class="col-sm-1 pdleft pdright" style="width: 20px;padding-top: 5px">To</label>
					    <div class="col-sm-3">
					     <?php
					    	if(!empty($academic))
					    	{
								echo '<input readonly="true" type="text" class="form-control" value="'.$academic[0]['course_duration_to'].'"/>';
							}
							else
							{
							?>
							 <select id="course_duration_to" name="course_duration_to" class="form-control" required="true">
							  <option value="">Year</option>
							   <?php
							  $strt = date('Y');
							  $previousyear = $strt -1;
							  	for($i=$previousyear; $i<=$previousyear+10; $i++)
							  	{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}							  	
							  ?>							 							  
							</select>
							<?php	
							}
					    	?>
					     
					    </div>
					     <label id="lblyr">
					    	<?php
					    	if(!empty($academic))
					    	{
					    		$ctnr=0;
					    		for($i=$academic[0]['course_duration_from']; $i<$academic[0]['course_duration_to'];$i++)
					    		{
									$ctnr++;
								}
								echo $ctnr.' years';
					    	}
					    	
					    	?>
					    </label>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Cities</label>
					    <div class="col-sm-5">
					      <?php					   
					      if(!empty($academic))
					      {		
					      	$citiess = $this->config->item('grade_cities');			      	
						  	?>
					      <input type="text" readonly="true" class="form-control" value="<?php echo $citiess[$academic[0]['city_id']];?>" />
					      <?php
						  }
						  else
						  {
						  	 ?>
					      	<select id="city_id" name="city_id" class="selectpicker form-control" onchange="showOtherCity(this.id);">
					      		<option value="">Select</option>								 
								 <?php 
								 $citiess = $this->config->item('grade_cities');
								 foreach($citiess as $cityid=>$cityval)
								 {
								 	echo '<option value="'.$cityid.'">'.$cityval.'</option>';
								 }
								 ?>	
							</select>
					      <?php
						  }
					     ?>	
					    </div>
					       <?php					   
					      if(!empty($academic))
					      {		
					      	if($academic[0]['city_id'] == 7)
					      	{
					      		?>
							  	<div class="col-sm-3 fade in ctyother">
	 						  		<input type="text" class="form-control" placeholder="Other City" value="<?php echo $academic[0]['city_other'];?>" readonly="true"/>
						    	</div>
							  	<?php
					      	}
					      }	
					      else
					      {
						  	?>
						  	<div class="col-sm-3 fade ctyother">
 						  		<input type="text" class="form-control" id="city_other" name="city_other" placeholder="Other City">
					    	</div>
						  	<?php
						  }	
						?>
					</div>
					<?php 
					if(!empty($academic))
					{
					?>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Academic Year</label>
					    <div class="col-sm-8">
					      <select id="aca_year" name="aca_year" class="selectpicker form-control" onchange="fillYears(this.id);">
					      		<option value=''>Academic Year</option>
							   <?php 
								  
								   foreach($financial as $years)
								   {
								   	echo '<option value="'.$years.'">'.$years.'</option>';
								   }
								  ?>
							</select>
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Semester/Annual</label>
					    <div class="col-sm-8">
					     <select id="is_sem" name="is_sem" class="form-control" onchange="shwsem(this.id);">
							  <option value="">Select</option>
							  <option value="1">Semester</option>	
							  <option value="2">Annual</option>
							</select>
					    </div>
					</div>	
					<div class="form-group col-xs-9 annual">
					    <label for="inputEmail3" class="col-sm-2">Annual Duration</label>
					    <div class="col-sm-8">
					     <select id="annual_no" name="annual_no" class="form-control">
							  <option value="">Select</option>
							  <option value="1">Ist Year</option>	
							  <option value="2">IInd Year</option>
							  <option value="3">IIIrd Year</option>
							  <option value="4">IVth Year</option>
							  <option value="5">Vth Year</option>
							</select>
					    </div>
					</div>
					<div class="form-group col-xs-9 sem">
					    <label for="inputEmail3" class="col-sm-2">Semester</label>
					    <div class="col-sm-8">
					     <select id="sem_no" name="sem_no" class="form-control">
							  <option value="">Select</option>
							  <?php
							  $existingSems = array();
							  $semesters = $this->common_model->getAllSemesters();
							  $academic = $this->common_model->getAcademicStatusDataforReport($appno);
							  if(count($academic)>0)
							  {
									foreach($academic as $acd)
								  	{
										if($acd['is_sem'] == 1)
										{
											array_push($existingSems,$acd['sem_no']);
										}
									}	
							  }
							  foreach($semesters as $sem)
							  {							  	
								if(!in_array($sem['id'],$existingSems))
								{
									?>
							  	<option value="<?php echo $sem['id']; ?>"><?php echo $sem['semester']; ?></option>
							  	<?php
								}
							  }
							  ?>
							</select>
					    </div>
					</div>	
					<div class="form-group col-xs-9 seman">
					    <label for="inputEmail3" class="col-sm-2">Duration of Semester/Year</label>
					      <div class="col-sm-4 pdright">
					     <input type="text" class="form-control" name="date_from" id="date_from" placeholder="From" >
					    
					    </div>
					    
					    <div class="col-sm-4">
					     <input type="text" class="form-control" name="date_to" id="date_to" placeholder="To" >
					    </div>
					</div>
												
				<!--	<div class="form-group col-xs-12 filter">
						 <div class="col-sm-5">
					    <label for="inputEmail3" class="col-sm-4 pull-right" >Status Update</label>
					    </div>
					    
					     <div class="col-sm-2">
					 		<select class="form-control" id="stipend_programme" name="stipend_programme" onchange="showFilters(this.id);">
						 		<option value="">Filter</option>
						 		<option value="1">Academic Status</option>
						 		<option value="2">Attendance Status</option>
						 		<option value="3">Scholarship Status</option>					 			
							</select>
					    </div> 
					</div>-->
					<div class="form-group col-xs-12 filter1">
						 <div class="col-sm-5">
					    <label for="inputEmail3" class="col-sm-4 pull-right" >Academic Status</label>
					    </div>
					    <div>
					    	<a class="rpt"  href="<?php echo site_url();?>regional/accademicReportofStudent/<?php echo $appno;?>">Generate Report</a>
					    </div>
						
						
						
						
						
					     <div class="col-sm-2">
					 		<select class="form-control" id="student_filter" name="student_filter" onchange="studentFilters(this.id);">
						 		<option value="">Select</option>
						 		<option value="1">Promoted</option>
						 		<option value="2">Detained</option>
						 		<option value="3">Backlogs</option>
						 		<option value="4">Finally Passed</option>
							</select>
					    </div> 
					</div>										
					 
					
								
					<ul class="nav nav-tabs tabs-up" id="friends">
					  <li><a href="<?php echo site_url();?>regional/studentPromoted/<?php echo $appno;?>" data-target="#promoted" class="media_node active span" id="promoted_tab" data-toggle="tabajax" rel="tooltip"> Promoted </a></li>
					  <!---<li><a href="<?php echo site_url();?>regional/studentStipend/<?php echo $appno;?>" data-target="#detained" class="media_node span" id="detained_tab" data-toggle="tabajax" rel="tooltip"> Detained</a></li>
					  <li><a href="<?php echo site_url();?>regional/studentHRA/<?php echo $appno;?>" data-target="#backlogs" class="media_node span" id="backlogs_tab" data-toggle="tabajax" rel="tooltip">Backlogs</a></li>
					  <li><a href="<?php echo site_url();?>regional/studentACA/<?php echo $appno;?>" data-target="#finally_passed" class="media_node span" id="finally_passed_tab" data-toggle="tabajax" rel="tooltip">Finally Passed</a></li>--->
				    </ul>
					
					<div class="tab-content">
					<div class="tab-pane active" id="promoted">
						
					</div>
					<!----<div class="tab-pane" id="detained">

					 </div>
					 <div class="tab-pane  urlbox span8" id="backlogs">

					 </div>
					 <div class="tab-pane  urlbox span8" id="finally_passed">

					 </div>--->
				</div>
					
					
					<div class="prom_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Promoted %Age</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Percentage</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="percentage" name="percentage" placeholder="%age">
							    </div>
							</div>																			
						 </div>
					</div>
					<div class="finally_pass_percentage panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Finally Passed %Age</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Percentage</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="finally_pass_percentage" name="finally_pass_percentage" placeholder="%age">
							    </div>
							</div>																			
						 </div>
					</div>
					
					<div class="det_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Detained Reason</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Reason</label>
							     <div class="col-sm-4">
							   		<select class="form-control" id="reasons" name="reasons">
								 		<option value="">Select</option>
								 		<option value="1">Medical Grounds</option>
								 		<option value="2">Backlog</option>
								 		<option value="3">Malpractice</option>
								 		<option value="4">Shortage of attendance</option>
									</select>
							    </div>
							</div>																		
						 </div>
					</div>	
					<div class="back_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Backlogs</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Number of Backlogs</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="noofbacklogs" name="noofbacklogs" placeholder="Number">
							    </div>
							</div>																			
						 </div>
					</div>
					<div class="atte_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Attendance %age</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Attendance Percentage</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="att_per" name="att_per" placeholder="Percentage">
							    </div>
							</div>																			
						 </div>
					</div>
					
					<div class="schlr_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Scholarship Status</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Status</label>
							     <div class="col-sm-4">
							   		<select class="form-control" id="schlr_sts" name="schlr_sts" onchange="showteminated(this.id);">
								 		<option value="">Select</option>
								 		<option value="1">Continued</option>
								 		<option value="2">Discontinued</option>
								 		<option value="3">Revived</option>
								 		<option value="4">Self Financed</option>
								 		<option value="5">Terminated</option>
									</select>
							    </div>
							</div>																			
						 </div>
					</div>
					<div class="terminated_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Terminated Details</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12" style="margin-bottom:15px;">
							<label for="inputEmail3" class="col-sm-3 control-label">Remarks for Termination</label>
							<div class="col-sm-4">
							   <textarea class="form-control" id="remarks_terminated" name="remarks_terminated" placeholder="Remarks"></textarea>
							</div>
						</div>
						
						<div class="col-xs-12">
							<label for="inputEmail3" class="col-sm-3 control-label">Upload File</label>
							<div class="col-sm-4">
							   <input type="file" name="term_file" id="term_file"/>
							</div>
						</div>																		
						 </div>
					</div>
					
					<?php	
					}
					?>
					<hr style="width:100%;border:1px solid #cecece !important;float:left;"/>
					<?php
					if(!empty($academic))
					{
					?>
						<div class="form-group col-xs-9 signt">
					    <label for="inputEmail3" class="col-sm-2">Name of the Officer</label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" id="officer_name" name="officer_name" placeholder="Name">
					    </div>
					
				<div class="form-group col-xs-5 pull-right" style="width: 416px;">
					    <label for="" class="col-sm-3">Signature</label>
					    <div class="col-sm-8">
					      <input class="" id="off_sign" name="off_sign" placeholder="From" type="file">
					    </div>					    
					</div>
					
					    					    
					</div>
					<div class="form-group col-xs-9 signt">
					    <label for="inputEmail3" class="col-sm-2">Date</label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" readonly="true" placeholder="Date" value="<?php echo date('d M Y h:i:s A');?>">
					    </div>				    
					</div>
						<div class="form-group col-xs-9 pull-right pdlef signt">					    
					    <div class="col-sm-3 pull-left pdleft">
					      <input type="submit" class="form-control sbmt" id="submit" value="Submit"/>
					    </div>					    
					</div> 
					<?php	
					}
					else
					{
					?>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Name of the Officer</label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" id="officer_name" name="officer_name" placeholder="Name">
					    </div>
					
				<div class="form-group col-xs-5 pull-right" style="width: 416px;">
					    <label for="" class="col-sm-3">Signature</label>
					    <div class="col-sm-8">
					      <input class="" id="off_sign" name="off_sign" placeholder="From" type="file" required="true">
					    </div>					    
					</div>
					
					    					    
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Date</label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" readonly="true" placeholder="Date" value="<?php echo date('d M Y h:i:s A');?>">
					    </div>				    
					</div>
						<div class="form-group col-xs-9 pull-right pdlef">					    
					    <div class="col-sm-7 pull-right pdleft">
					      <input type="submit" class="form-control sbmt" id="submit" value="Submit"/>
					    </div>					    
					</div> 
					<?php	
					}
					?>
					
							
			</div>
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
	
		<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">ACADEMIC & ATTENDANCE DETAILS OF APPLICANT</h4>
                        </div>
                        <div class="modal-body">
     
						</div>
	<div class="modal-footer">
	<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
	<!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
           
	<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
	</div>
                    </div>
                  
                </div>
            </div>
</section>
<script type='text/javascript'>
	function editPromoted(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editPromotedDetails')?>',
                        type: 'post',
						data:{'appno':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
							//alert(JSON.stringify(response));
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}
	</script>
<script>

$('[data-toggle="tabajax"]').click(function(e) {
	//alert('ok');
    var $this = $(this),
        loadurl = $this.attr('href'),
		
        targ = $this.attr('data-target');
		//alert(targ);
    $.get(loadurl, function(data) {
		
        $(targ).html(data);
    });

    $this.tab('show');
    return false;
});
</script>
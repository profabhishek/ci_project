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
function calculateyears(id)
{
	var frm = $('#course_duration_from').val();
	var yrvalue = $('#' + id).val();
	var cntr = 0;
	for(var i=frm; i<yrvalue;i++)
	{
		cntr++;
	}
	$('#lblyr').text(cntr + " years");
}
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
$stateuniversities = $this->common_model->getStateUniversitiesofRO($regionId);

$centraluniversities = $this->common_model->getCentralUniversitiesofRO($regionId);
$nits = $this->common_model->getNITUniversitiesofRO($regionId);
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
<script type="text/javascript">
	function showothercourse(id)
	{
		var v = $('#'+ id).val();
		if(v==-1)
		{
			$('.other_course').addClass("in");
		}
		else
		{
			$('.other_course').removeClass("in");
		}
	}
</script>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Academic & Attendance Details of Applicant</h3>	
		<h4 class="text-center caps">APPLICATION NUMBER : <?php if(!empty($appno)){ echo $appno; } ?></h4>	
	</div>
	<div class="headsec container">Welcome <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal </div>
	<script type="text/javascript">
		window.history.pushState({}, "Indian Council for Cultural Relations",  baseURL + 'regional/addAcademicDetails/' + '<?php echo $appno; ?>');
	</script>
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>regional/studentAcademic/<?php echo $appno;?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	    	  		<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">File Number</label>
					    <div class="col-sm-8">
					      <?php
					      if(!empty($academic))
					      {
					      ?>
						  <input type="text" class="form-control" placeholder="File Number" value="<?php echo $academic[0]['file_no']; ?>" readonly="true" >
						  <?php	
					      }
					      else
					      {
						  ?>
						  <input type="text" class="form-control" name="file_no" id="file_no" placeholder="File Number" >
						  <?php
						  }
					      ?>	
					      
					    </div>
					</div>	
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Name</label>
					    <div class="col-sm-8">
					      <?php
					      if(!empty($academic))
					      {
					      ?>
						  <input type="text" class="form-control" placeholder="Name" value="<?php echo $academic[0]['fullname']; ?>" readonly="true" >
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
					    if(!empty($academic))
						{
						  $countries = $this->common_model->getCountries();								  
						  foreach($countries as $country)
						  {
							  if(!empty($academic))
							  {
								  if($country['id'] == $academic[0]['country'])
								  {
									  echo '<input readonly="true" type="text" class="form-control" value="'.$country['country_name'].'"/>';
								  }								 
							  }
						  }	
						}
						else
						{
						?>
						<select id="country" name="country" class="selectpicker form-control" >	
						 <option value="">Select</option>					     
							  <?php
							  $countries = $this->common_model->getCountries();							  
							  foreach($countries as $country)
							  {
								 
								  echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
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
					    		if(!empty($academic))
					    		{
									  $programme = $this->common_model->getAllProgramme();
									  foreach($programme as $prog)
									  {
									  		if($prog['id'] != 5 && $prog['id'] != 6 && $prog['id'] != 7)
									  		{
												if($prog['id'] == $academic[0]['programme'])
												  {
													echo '<input readonly="true" type="text" class="form-control" value="'.$prog['name'].'"/>';
												  }
											} 
									  }
								}
								else
								{
								?>
								 <select id="programme1" name="programme1" class="selectpicker form-control">
								      <option value="">Select</option>
											  <?php
											  $programme = $this->common_model->getAllProgramme();
											  foreach($programme as $prog)
											  {
											  		if($prog['id'] != 5 && $prog['id'] != 6 && $prog['id'] != 7)
											  		{
														if($prog['id'] == $academic[0]['course'])
														  {
															echo '<option selected="selected" value="'.$prog['id'].'">'.$prog['name'].'</option>';
														  }
														  else
														  {
														  	echo '<option  value="'.$prog['id'].'">'.$prog['name'].'</option>';
														  }
													} 
											  }
											  ?>
										  <option value="8">Post-doctoral</option>
									</select>
								<?php	
								}
					    		 
					    	?>
					    	
					     
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Course</label>
					    <div class="col-sm-4">
					    	<?php
					    	if(!empty($academic))
					    	{							
							  $courses = $this->common_model->getAllCourses();
							  foreach($courses as $course)
							  {
								  if($course['id'] == $academic[0]['course'])
								  {
									echo '<input readonly="true" type="text" class="form-control" value="'.$course['title'].'"/>';
								  }
								  
							  } 	
							}
							else
							{
							?>
								<select id="course1" name="course1" class="selectpicker form-control" onchange="showothercourse(this.id);">
					      		<option value="">Select</option>
								  <?php
								  $courses = $this->common_model->getAllCourses();
								  
								  foreach($courses as $course)
								  {
									  if($course['id'] == $academic[0]['course'])
									  {
										echo '<option selected="selected" value="'.$course['id'].'">'.$course['title'].'</option>';
									  }
									  else
									  {
									  	echo '<option  value="'.$course['id'].'">'.$course['title'].'</option>';
										
									  }
									  
								  }
								  echo '<option  value="-1">Other</option>';
								  
								  ?>
							</select>
							<?php	
							}	
					    	?>
					      
					    </div>
						<div class="col-sm-4 fade other_course">
					       <input type="text" class="form-control" id="other_course" name="other_course" placeholder="Other">
					    </div>
						 
					</div>
					
					
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">University/Institute</label>
					    <div class="col-sm-8">
					     <?php 
					    	if(!empty($academic))
					    	{
					    		$univ = $this->common_model->getUniversityById($academic[0]['university']);
								echo '<input readonly="true" type="text" class="form-control" value="'.$univ[0]['name'].'"/>';
							}
							else
							{
							?>
							 <select id="university" name="university"  class="form-control" onchange="selectUniversityChoice(this.value)"  required="true">					      
					       <option value="">Select</option>	
						 	<?php
								echo '<optgroup label="State Universities">';	
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
										echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'">';
										foreach($univercity1 as $uni_choice)
										{
											if(!empty($academic))
											{
												if($academic[0]['university'] == $uni_choice['id'])
												{
													echo '<option selected="selected" value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';											
												}
												else
												{
													echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';
											}
											
										}
										echo '</optgroup>';			
									}	
								}
							    echo '</optgroup>';
							    echo '<optgroup label="Central Universities">';
								foreach($centraluniversities as $univercity_cnet)
								{				
									if(!empty($academic))
									{
										if($academic[0]['university'] == $univercity_cnet['id'])
										{
											echo '<option selected="selected" value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
										else
										{
											echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
										}
									}
									else
									{
										echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';
									}
							    }
								echo '</optgroup>';
								   echo '<optgroup label="National Institute of Technology (NIT)">';
							    foreach($nits as $univercity_nit)
								{		
									if(!empty($academic))
									{
										if($academic[0]['university'] == $univercity_nit['id'])
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
										else
										{
											echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
										}
									}
									else
									{
										echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
									}								
									
							    }
								echo '</optgroup>';
								echo '<optgroup label="Gurus">';
					 			foreach($yogas as $univercity_yogs)
								{		
									if(!empty($academic))
									{
										if($academic[0]['university'] == $univercity_nit['id'])
										{
											echo '<option selected="selected" value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
										else
										{
											echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
										}
									}
									else
									{
										echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';
									}
							    }
								echo '</optgroup>';
						    ?>
						    </select>
							<?php	
							}
					    	?>
					    
					    
					    
					    
					    </div>
					</div>

					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Scheme</label>
					    <div class="col-sm-3">
					    	<?php 
					    	if(!empty($academic))
					    	{
					    		$schems = $this->common_model->getOldSchemeById($academic[0]['scheme']);
								echo '<input readonly="true" type="text" class="form-control" value="'.$schems[0]['scheme_name'].'"/>';
							}
							else
							{
							?>
							<select id="scheme" name="scheme" class="selectpicker form-control">	
					      		 <option value="">Select</option>							  
								  <?php
								  $code = "";
								  $schemes = $this->common_model->getAllOLDSchemes();
								 
								  foreach($schemes as $scheme)
								  {
								  	?>								
								  	<?php	
								  		if(!empty($academic))
					      		  		{
											if($academic[0]['scheme'] == $scheme['id'])
											{
												echo '<option selected="selected" value="'.$scheme['id'].'">'.$scheme['scheme_name'].'</option>';
											}
											else
											{
												echo '<option value="'.$scheme['id'].'">'.$scheme['scheme_name'].'</option>';		
											}
										}
										else
										{
											echo '<option value="'.$scheme['id'].'">'.$scheme['scheme_name'].'</option>';		
										}
								  }
								  ?>
							</select>
							<?php	
							}
					    	?>
					    </div>
						
						 <div class="col-sm-3">
						 
						 <label  class="col-sm-3">Institute Name</label>
					    <div class="col-sm-8">
						
						<?php 
					    	if(!empty($academic))
					    	{
								?>
					      <input type="text" class="form-control" id="institute_name" name="institute_name" placeholder="Name" value ="<?php echo $academic[0]['institute_name'];?>" required>
						  <?php
							}
							else
							{
								?>
								<input type="text" class="form-control" id="institute_name" name="institute_name" placeholder="Name"  required>
								<?php
							}
							?>
					    </div>

						 </div>
						 
						 
						  <div class="col-sm-3">
						 
						 <label  class="col-sm-3">Private/Govt</label>
					    <div class="col-sm-8">
						<?php
						if(!empty($academic))
					    	{
								?>
					    <select id="pvt_govt" name="pvt_govt" class="form-control">	
					      		 <option value="">Select</option>
								 <?php
							if($academic[0]['pvt_govt'] == 1)
						{
							?>
							<option value="1" selected>Govt</option>
						   <?php
						}
						else
						{
							?>
							<option value="2" selected>Private</option>
						   <?php
						}
						?>
								 
						</select>
						<?php
							}
							else
							{
								?>
								 <select id="pvt_govt" name="pvt_govt" class="form-control">	
					      		 <option value="">Select</option>
								 <option value="1">Govt</option>
								 <option value="2">Private</option>
						</select>
						<?php
							}
							?>
					    </div>

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
							  $strt = date('Y')-7;
							  	for($i=$strt; $i<=date('Y'); $i++)
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
							  $strt = date('Y')-7;
							  	for($i=$strt; $i<=$strt+15; $i++)
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
					      <select id="aca_year" name="aca_year" class="selectpicker form-control">
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
					     <select id="annual_no" name="annual_no" class="form-control" onchange="showduration(this.id,'year');">
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
					     <select id="sem_no" name="sem_no" class="form-control" onchange="showduration(this.id,'semester');">
							  <option value="">Select</option>
							  <?php
							  $semesters = $this->common_model->getAllSemesters();
							  foreach($semesters as $sem)
							  {
							  	?>
							  	<option value="<?php echo $sem['id']; ?>"><?php echo $sem['semester']; ?></option>
							  	<?php
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
					<!--<div class="form-group col-xs-12 filter">
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
					    	<a class="rpt"  href="<?php echo site_url();?>regional/accademicReportofOldStudent/<?php echo $appno;?>">Generate Report</a>
					    </div>
					     <div class="col-sm-2">
					 		<select class="form-control" id="student_filter" name="student_filter" onchange="studentFilters(this.id);">
						 		<option value="">Select</option>
						 		<option value="1">Promoted</option>
						 		<option value="5">Promoted with Backlogs</option>						 		
						 		<option value="2">Detained</option>
						 		<option value="3">Backlogs</option>
						 		<option value="4">Finally Passed</option>
							</select>
					    </div> 
					</div>	
					<div class="prom_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Promoted %Age</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Percentage</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="percentage" name="percentage" placeholder="%age">
							    </div>
							</div><br/><br/>																			
						 </div>
					</div>
					<div class="finally_pass_percentage panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Promoted %Age</div>
						 <div class="panel-body">						 
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Passed Percentage</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="finally_pass_percentage" name="finally_pass_percentage" placeholder="%age">
							    </div>
							</div><br/><br/>																			
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
							</div><br/><br/>																			
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
					<hr/><br><br>
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
				<hr style="width:100%;border:1px solid #cecece !important;float:left;"/><br/><br/>
					<div class="form-group col-xs-9">
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
					<div class="form-group col-xs-9 ">
					    <label for="inputEmail3" class="col-sm-2">Date</label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" readonly="true" placeholder="Date" value="<?php echo date('d M Y h:i:s A');?>">
					    </div>				    
					</div>
					<div class="form-group col-xs-9 pull-right pdlef ">					    
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
</section>

<!--<div class="modal bootstrap-dialog type-danger fade size-normal in" role="dialog" aria-hidden="true" tabindex="-1" style="z-index: 1050; display: block; padding-right: 17px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="bootstrap-dialog-header">
				<div class="bootstrap-dialog-close-button" style="display: block;">
					<button class="close">×</button>
				</div>
				<div class="bootstrap-dialog-title">Error Message</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="bootstrap-dialog-body">
				<div class="bootstrap-dialog-message">Wrong Username/Password!.</div>
				</div>
			</div>
			<div class="modal-footer" style="display: block;">
				<div class="bootstrap-dialog-footer">
					<div class="bootstrap-dialog-footer-buttons">
						<button class="btn btn-default" id="f6782a82-d72e-49ba-a554-1414b9390128">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	-->


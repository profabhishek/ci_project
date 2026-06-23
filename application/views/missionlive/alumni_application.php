<?php //echo "<pre>";print_r($applicaitonStepOne);die;?>
<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:125px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
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
.tab-content input[type="text"], select,textarea {
    background: #fffdca none repeat scroll 0 0 !important;
    color: #747474 !important;
    font-size: 14px !important;
    font-weight: bold;
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
.img-alumni{
	 border: 1px solid #cecece;
    height: 150px;
    position: absolute;
    right: 39px;
    top: 31px;
    width: 150px;
}
.uimg{
	  height: 150px;
    width: 150px;
}
.uimg img{
	  height: 148px;
    width: 148px;
}
.hd{
	 background: #CCDE8F;
    border: 1px solid #cecece;
    margin-bottom: 21px;
    padding: 6px;
    text-align: center;
    width: 81%;
    float: left;
}
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
}
</style>
<?php 
$stateuniversities = $this->common_model->getStateUniversities();
//print_r($stateuniversities);
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
<script type="text/javascript">
	function showcityother(id)
	{
		var v = $('#'+ id).val();
		if(v==7)
		{
			$('.city_other').addClass("in");
		}
		else
		{
			$('.city_other').removeClass("in");
		}
	}
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
	function showotheruni(id)
	{
		var v = $('#'+ id).val();
		if(v==-1)
		{
			$('.other_unverisity').addClass("in");
		}
		else
		{
			$('.other_unverisity').removeClass("in");
		}
	}
</script>
<script type="text/javascript">
	function showotherOpt(id)
	{
		var v = $('#'+ id).val();
		if(v==7)
		{
			$('.occupation_other').addClass("in");
		}
		else
		{
			$('.occupation_other').removeClass("in");
		}
	}
</script>
<script type="text/javascript">
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#uimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

	$(function(){
		
		
		$("#img_alumnai").change(function(){
		    readURL(this);
		});
		
		$('#openpic').click(function(){
			$('#img_alumnai').click();
		});
		
		$('.prom_details').hide();
		$('.det_details').hide();
		$('.back_details').hide();
		$('.atte_details').hide();
		$('.schlr_details').hide();
					
		$('.signt').hide();
		$('.filter1').hide();
		$('.filter2').hide();
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
			break;
			case "3":
			$('.atte_details').show();
			$('.signt').show();
			break;
			case "4":
			$('.schlr_details').show();
			$('.signt').show();
			break;						
		}
	}
	function studentFilters(id)
	{
		var FilterType = $('#' +  id).val();
		$('.panel-default').hide();
		$('.signt').hide();
		$('.filter1').show();
		switch(FilterType)
		{
			case "1":
			$('.prom_details').show();
			$('.signt').show();
			break;
			case "2":
			$('.det_details').show();
			$('.signt').show();
			break;
			case "3":
			$('.back_details').show();
			$('.signt').show();
			break;
			case "4":
			$('.back_details').show();
			$('.signt').show();
			break;			
		}
	}	
</script>
<section class="meacontent">	
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
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Alumni Data (ICCR)</h3>	
		<h5 class="text-center">TO BE FILLED BY Mission</h5>
		
	</div>
	<script type="text/javascript">
		window.history.pushState({}, "Indian Council for Cultural Relations",  baseURL + 'mission/alumniApplication/' + '<?php echo $appno; ?>');
	</script>
	<div class="headsec container">Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal</div>
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>mission/saveAlumniData/<?php echo $appno;?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	    <div class="box-body" style="position: relative;">
	    	 <h3 class="hd">Personal Details</h3>
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
	    	  <input type="hidden" id="application_id" name="application_id" value="<?php echo $appno;?>">				
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Fullname</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Name" >
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Age</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="age" name="age" placeholder="Age" >
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Date of Birth</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control datepicker" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth" required="true">
					    </div>
					</div>
              	
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Gender</label>
					    <div class="col-sm-8">
						     <select id="gender" name="gender" class="selectpicker form-control" required="true">
						    	  <option value="">Select</option>
								  <option value="1">Male</option>
								  <option value="2">Female</option>
							</select>
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Country</label>
					    <div class="col-sm-8">
						     <select id="nationality" name="nationality" class="selectpicker form-control">
						     	<option value="">Select</option>
								  <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
								  	if($country['id'] == $misionData[0]['country'])
								  	{
										 echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';	
									}
								  }
								  ?>
							</select>
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Schemes</label>
					    <div class="col-sm-8">
					       <select class="form-control" id="scholarship_scheme" name="scholarship_scheme" required="true">		
								<option value="">Select</option>			
								<?php						
								
								$schemes = $this->common_model->getAllOLDSchemes();
								foreach($schemes as $scheme)
								{
									echo '<option value="'.$scheme['id'].'">'.$scheme['scheme_name'].'</option>';
								}
								?>
							</select>
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Course</label>
					    <div class="col-sm-4">
					      <select id="course" name="course" class="selectpicker form-control" onchange="showothercourse(this.id);">
					     	 <option value="">Select</option>	
								  <?php
								  $counter =1;
								  $courses = $this->common_model->getAllCourses();
								  foreach($courses as $course)
								  {
									 echo '<option value="'.$course['id'].'">'.$course['title'].'</option>';
									 $counter++;
								  }
								  ?>
								<option value="-1">Other</option>
							</select>
					    </div>
					     <div class="col-sm-4 fade other_course">
					       <input type="text" class="form-control" id="other_course" name="other_course" placeholder="Other">
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">University/Institute</label>
					    <div class="col-sm-4">
					    	
					      <select id="unverisity" name="unverisity"  class="form-control"  required="true" onchange="showotheruni(this.id);">	
						 <option value="">Select</option>	
						 	<?php
										if($applicaitonStepOne[0]['course'] == 13 || $applicaitonStepOne[0]['course'] == 12)
							 			{						
							 				 				
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
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id'])
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
										    echo '<optgroup label="National Institute of Technology (NIT)">';
										    foreach($nits as $univercity_nit)
											{								
												if(!empty($applicaitonStepOne))
											  	{
													if($applicaitonStepOne[0]['universty_choice'] == $univercity_nit['id'])
													{
														echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
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
							 			}
							 			else
							 			{
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
														if(!empty($applicaitonStepOne))
													  	{											  		
															if($applicaitonStepOne[0]['universty_choice'] == $uni_choice['id'])
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
												if(!empty($applicaitonStepOne))
											  	{
													if($applicaitonStepOne[0]['universty_choice'] == $univercity_cnet['id'])
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
												if(!empty($applicaitonStepOne))
											  	{
													if($applicaitonStepOne[0]['universty_choice'] == $univercity_nit['id'])
													{
														echo '<option selected="selected" value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';
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
										}										
								
								
								
						    ?>	
						    <option value="-1">Others</option>						 	
						 </select>
					    </div>
					    <div class="col-sm-4 fade other_unverisity">
					       <input type="text" class="form-control" id="other_unverisity" name="other_unverisity" placeholder="Other">
					    </div>
					</div>
					
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">City</label>
					    <div class="col-sm-4">
					      
					      <select id="city" name="city" class="form-control" required="true" onchange="showcityother(this.id);">
					    		<option value="">Select</option>
					    		<?php
					    			$cities = $this->config->item('grade_cities');
					    			
					    			foreach($cities as $cityid=>$ctyName)
					    			{
										echo '<option value="'.$cityid.'">'.$ctyName.'</option>';
									}
					    		?>
					      </select>
					    </div>
					   <div class="col-sm-4 fade city_other">
		    	<input type="text" name="other_city" id="other_city" placeholder="Other City" class="form-control"/>
		    </div>
					</div>	
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Duration of Course</label>
					    <div class="col-sm-4">
					    	<select id="duration_of_course_from" name="duration_of_course_from" class="form-control" required="true">
					      	<option value="">Year</option>
							  <?php
							  	for($i=date('Y')-10;$i<=date('Y');$i++)
							  	{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							  ?>
					      </select>
					     <!-- <input type="text" class="form-control" id="duration_of_course_from" name="duration_of_course_from" placeholder="Duration of Course">-->
					    </div>
					     <div class="col-sm-4">
					     <select id="duration_of_course_to" name="duration_of_course_to" class="form-control" required="true">
					      	<option value="">Year</option>
							  <?php
							  	for($i=date('Y')-10;$i<=date('Y');$i++)
							  	{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							  ?>
					      </select>
					     <!-- <input type="text" class="form-control" id="duration_of_course_to" name="duration_of_course_to" placeholder="Duration of Course">-->
					    </div>
					</div>										
					 <div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Year of Passing</label>
					    <div class="col-sm-8">
					    
					      <select id="year_of_passing" name="year_of_passing" class="form-control" required="true">
					      	<option value="">Year</option>
							  <?php
							  	for($i=date('Y')-10;$i<=date('Y');$i++)
							  	{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							  ?>
					      </select>
					    </div>
					</div>	
					<h3 class="hd">Present Details</h3>
					
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Occupation</label>
					    <div class="col-sm-4">
					      <select id="occupation" name="occupation" class="form-control" onchange="showotherOpt(this.id);">
					      	<option value="">Select</option>
					      	<?php 
					      	$occ = $this->common_model->getOccupations();
					      	foreach($occ  as $value)
					      	{
								echo '<option value="'.$value['id'].'">'.$value['occupation'].'</option>';
							}
					      	?>
					      </select>
					    </div>
					    <div class="col-sm-4 fade occupation_other">
					      <input type="text" class="form-control" id="occupation_other" name="occupation_other" placeholder="Others">
					    </div>
					</div>
						<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Professional Address</label>
					    <div class="col-sm-8">
					      <textarea class="form-control" id="present_details" name="present_details" placeholder="Details"></textarea>
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Email</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="email" name="email" placeholder="Email" required="true">
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Phone</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Award Recognition</label>
					    <div class="col-sm-8">
					     <input type="text" class="form-control" id="award_recognition" name="award_recognition" placeholder="Award Recognition">
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Mission/Post  Remarks</label>
					    <div class="col-sm-8">
					      <textarea class="form-control" id="mission_special_remarks" name="mission_special_remarks" placeholder="Mission/Post Remarks"></textarea>
					    </div>
					</div>
					<hr/><br><br>
				
					
					<div class="form-group col-xs-9 pull-right pdlef">					    
					    <div class="col-sm-3 pull-left pdleft">
					      <input type="submit" class="form-control sbmt" id="submit" value="Submit"/>
					    </div>					    
					</div> 
					<div class="img-alumni">
						<div class="uimg">
							<img id="uimg" name="uimg"  src="<?php echo site_url();?>assets/site/main/images/default_avatar.png"/>
						</div>
						<input type="file" name="img_alumnai" id="img_alumnai" required="true" style="width:0;"/>
						<a id="openpic" href="javascript:void(0);">Upload Alumni Image</a>
					</div>			
			</div>
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	
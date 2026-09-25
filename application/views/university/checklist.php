<style type="text/css">
.tweaked-margin{margin-right:5px !important;}
.list-group {
	list-style: none;
}

.list-group-item {
	display: list-item;
	float: left;
	width: 100%;
}
.lbl{
	font-weight: normal;
    line-height: 29px;
    margin-left: 11px;
    display: block;
}
.p-div{
	display: block;
    float: left;
    margin-top: 0;
    width: 100%;
}

input[type=checkbox]:not(old){
  width     : 2em;
  margin    : 0;
  padding   : 0;
  font-size : 1em;
  opacity   : 0;
  float: left;
  height: 2em;
}

input[type=checkbox]:not(old) + label{
  display      : inline-block;
  margin-left  : -2em;
  line-height  : 28px;
   float: left;
}

input[type=checkbox]:not(old) + label > span{
  display          : inline-block;
  width            : 1.5em;
  height           : 1.5em;
  margin           : 0.25em 0.5em 0.25em 0.25em;
  border           : 0.0625em solid rgb(192,192,192);
  border-radius    : 0.25em;
  background       : rgb(224,224,224);
  background-image :    -moz-linear-gradient(rgb(240,240,240),rgb(224,224,224));
  background-image :     -ms-linear-gradient(rgb(240,240,240),rgb(224,224,224));
  background-image :      -o-linear-gradient(rgb(240,240,240),rgb(224,224,224));
  background-image : -webkit-linear-gradient(rgb(240,240,240),rgb(224,224,224));
  background-image :         linear-gradient(rgb(240,240,240),rgb(224,224,224));
  vertical-align   : bottom;
}

input[type=checkbox]:not(old):checked + label > span{
  background-image :    -moz-linear-gradient(rgb(224,224,224),rgb(240,240,240));
  background-image :     -ms-linear-gradient(rgb(224,224,224),rgb(240,240,240));
  background-image :      -o-linear-gradient(rgb(224,224,224),rgb(240,240,240));
  background-image : -webkit-linear-gradient(rgb(224,224,224),rgb(240,240,240));
  background-image :         linear-gradient(rgb(224,224,224),rgb(240,240,240));
}

input[type=checkbox]:not(old):checked + label > span:before{
  content     : '✓';
  display     : block;
  width       : 1em;
  color       : rgb(153,204,102);
  font-size   : 1.3em;
  line-height : 1em;
  text-align  : center;
  text-shadow : 0 0 0.0714em rgb(115,153,77);
  font-weight : bold;
}

input[type=radio]:not(old):checked +  label > span > span{
  display          : block;
  width            : 0.5em;
  height           : 0.5em;
  margin           : 0.125em;
  border           : 0.0625em solid rgb(115,153,77);
  border-radius    : 0.125em;
  background       : rgb(153,204,102);
  background-image :    -moz-linear-gradient(rgb(179,217,140),rgb(153,204,102));
  background-image :     -ms-linear-gradient(rgb(179,217,140),rgb(153,204,102));
  background-image :      -o-linear-gradient(rgb(179,217,140),rgb(153,204,102));
  background-image : -webkit-linear-gradient(rgb(179,217,140),rgb(153,204,102));
  background-image :         linear-gradient(rgb(179,217,140),rgb(153,204,102));
}
.notee{
	color: red;
    font-size: 14px;
    font-weight: bold;
    margin-left: 10px;
}
</style>
<script type="text/javascript">
var schemetype = [];
	function getSchemeType(id)
	{
		var v = $('#' + id).val();
		var stype = "";
		if(v <= 0 || v == "")
		{
			stype = "";
			$('#lbl_scheme_type').text(stype);
		}
		else
		{
			if(schemetype[v]['scheme_type'] == 1)
			{
				stype = "Non-Agency Scheme";
			}
			else if(schemetype[v]['scheme_type'] == 2)
			{
				stype = "Agency Scheme";
			}
			$('#lbl_scheme_type').text(stype);
		}
	}
	function getSlots(id)
	{
		var scheme = $('#' + id).val();
		$.ajax({
		    type: "POST",
		    url: baseURL +'mission/getSlotsbySchemes',
		    data: {'schemeid' : scheme},
		    dataType:'json',
		    success: function (data) {	
		    var htm = "<option value=''>-- Select --</option>";
		    	if(data.status == true)
		    	{
					$('.total_slots').text(data.slots);
					if(data.slots_left == 0)
					{
						$('.left_slots').text(data.slots);	
					}
					else
					{
						$('.left_slots').text(data.slots_left);
					}
				}
				else if(data.status == false)
		    	{
		    		$('.total_slots').text("0");
		    		$('.left_slots').text("0");
				}	
		      },
		      error: function(jqXHR, text, error){		             
		      }
		   });
	}
</script>
<?php	
$universityarray = array();	
$univarray = array();
$isResponseSent = $this->common_model->isAnyUniversityResponseConfirmed($this->uri->segment(3),$univesrsityId);	
if(count($isResponseSent)>0)
{
	foreach($isResponseSent as $isResponseS)
	{
		array_push($univarray,$isResponseS['regional_university']);
	}
}	
foreach($univercities as $univercity)
{							
	if(!empty($applicaitonStepOne))
  	{
		if($applicaitonStepOne[0]['universty_choice'] == $univercity['id'])
		{
			if($univercity['id'] == $univesrsityId)
			{
				if(!in_array($univercity['id'],$univarray))
				{
					$universityarray[$univercity['id']] = $univercity['name'];	
				}
			}
		}									
	}								
} 
$univercitie_two = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],0);
//echo "<pre>";print_r($univercitie_two);die;
foreach($univercitie_two as $univercity1)
 {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_two'] == $univercity1['id'])
  		{  	
  					
  			if($univercity1['id'] == $univesrsityId)
			{
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}
			}			
		}									
	}								
 }							 	
$univercitie_two = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],$applicaitonStepOne[0]['universty_choice_two']);
foreach($univercitie_two as $univercity1)
  {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_three'] == $univercity1['id'])
  		{  			
  			if($univercity1['id'] == $univesrsityId)
			{
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}				
			}  
		}									
	}								
 }

$univercitie_three = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],$applicaitonStepOne[0]['universty_choice_two'],$applicaitonStepOne[0]['universty_choice_three'],$applicaitonStepOne[0]['universty_choice_fourth']);
foreach($univercitie_three as $univercity1)
  {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity1['id'])
  		{  			
  			if($univercity1['id'] == $univesrsityId)
			{
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}				
			}  
		}									
	}								
 }
 
 
 
 $univercitie_fourth = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],$applicaitonStepOne[0]['universty_choice_two'],$applicaitonStepOne[0]['universty_choice_three']);
foreach($univercitie_fourth as $univercity1)
  {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity1['id'])
  		{  			
  			if($univercity1['id'] == $univesrsityId)
			{
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}				
			}  
		}									
	}								
 }
?>
<section class="meacontent">
	<div class="row posi-relas" style = "position:relative;">
<!-----------<div id='loader' style='display: none;'>
							  <img src="<?php echo site_url();?>assets/site/main/images/loader/loaderimg.gif">
							</div>-->
<div class="col-xs-10 form_head">				
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">University Checklist For Applicant Scholarship through ICCR</h3>
		<h5 class="text-center">APPLICATION NUMBER : <?php echo $this->uri->segment(3); ?></h5>
	</div>
	<div  class="container" style="padding-bottom:15px;">
	<div class="field-item even" property="content:encoded">
	<form id="form-process-university-application" class = "form-submit" action="<?php echo site_url();?>university/applicaitonProcess" enctype="multipart/form-data" method="post">
		<input type="hidden" id="applicaiton_number" name="applicaiton_number" value="<?php echo $this->uri->segment(3); ?>"/>
		<input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
		<h5 style="text-align:center">Applicant Name : <?php echo $applicaitonStepOne[0]['fullname'].' '.$applicaitonStepOne[0]['middlename'].' '.$applicaitonStepOne[0]['familyname'];?></h5>
		<h5 style="text-align:center">Email Id : <?php echo $applicaitonStepOne[0]['email'];?></h5>
		<!------<div><a target="_blank" style="float: right;width:104px;" href="<?php echo site_url(); ?>university/viewfullApplication/<?php echo $this->uri->segment(3); ?>" class="form-control sbmt1">View</a></div>------>
		<hr style="margin-top:50px;" />
		
		<?php 
	
	$docsArray = array();
	
	if(count($applicaitonDocuments) > 0)
	{
		foreach($applicaitonDocuments as $docs)
		{
			if(!array_key_exists($docs['doc_type'],$docsArray))
			{
				$docsArray[$docs['doc_type']] = array();
				$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
				$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
			}
			
		}
	}	
	
	?>
	<br/>
	<br/>
	 <p style = "color:red"> Note :Please Select all checkpoints and Click on "Submit/Proceed" button.
	</br>
	</br>
	<div class="tab-content docsdiv">		
	  <div id="step3" class="tab-pane fade in active">	 
	  <h5 class="text-center">All Documents</h5>	    
	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <div class="box-body">
              	<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table class="table">
						<thead>
							<th>S.No.</th>
							<th>Document Name</th>
							<th>Uploaded Document</th>							
							<th>Uploaded Time</th>							
						</thead>
						<tbody>
							<?php
								$counter = 1;	
								$upload = 0;						
								$doctypes = $this->config->item('doc_types');	
								$file_path = $docsArray[$doctypes['id']['type']]['path'];
								$file_path_passport = $docsArray[$doctypes['passport']['type']]['path'];
								$file_path_school_leaving_x = $docsArray[$doctypes['school_leaving_x']['type']]['path'];
								$file_path_school_leaving = $docsArray[$doctypes['school_leaving']['type']]['path'];
								$file_path_ug = $docsArray[$doctypes['ug']['type']]['path'];
								$file_path_pg = (isset($docsArray[$doctypes['pg']['type']]['path']) ? $docsArray[$doctypes['pg']['type']]['path'] : '');
								$file_path_phd = (isset($docsArray[$doctypes['phd']['type']]['path']) ? $docsArray[$doctypes['phd']['type']]['path'] : '');
								$file_path_phdReseachPaper = (isset($docsArray[$doctypes['phdReseachPaper']['type']]['path']) ? $docsArray[$doctypes['phdReseachPaper']['type']]['path'] : '');
								$file_path_indian_address = (isset($docsArray[$doctypes['indian_address']['type']]['path']) ? $docsArray[$doctypes['indian_address']['type']]['path'] : '');
								$file_path_d1 = (isset($docsArray[$doctypes['d1']['type']]['path']) ? $docsArray[$doctypes['d1']['type']]['path'] : '');
								/*$file_path_physical = $docsArray[$doctypes['physical']['type']]['path'];*/
								$file_path_tl = $docsArray[$doctypes['tl']['type']]['path'];
								$file_path_otherDoc = (isset($docsArray[$doctypes['otherDoc']['type']]['path']) ? $docsArray[$doctypes['otherDoc']['type']]['path'] : '');
							?>	
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td>Permanent Unique ID <span class="text-red">*</span></td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['id']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a href="<?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								  <a href="#" data-toggle="modal" data-target="#idProofDiv">Upload</a>
								  <?php	
								  }
								  ?>	
								  
								</td>
								<td>
								 <?php
								  if(array_key_exists($doctypes['id']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['id']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>								
							</tr>
							<?php
							if(count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['passport_no']!= "")
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['passport']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['passport']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								 <a target="_blank" href="<?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_passport); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#passportDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['id']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['id']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
						//	if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
							if(array_key_exists($doctypes['school_leaving_x']['type'],$docsArray))
							{								
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['school_leaving_x']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['school_leaving_x']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_school_leaving_x);?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#schoolLivingDivX">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['school_leaving_x']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['school_leaving_x']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							?>
							<?php
						//	if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
							if(array_key_exists($doctypes['school_leaving']['type'],$docsArray))
							{								
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['school_leaving']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['school_leaving']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_school_leaving); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#schoolLivingDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['school_leaving']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['school_leaving']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0)
							if(array_key_exists($doctypes['ug']['type'],$docsArray))
							{
								
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['ug']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['ug']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								 <a target="_blank" href="<?php echo site_url(); ?><?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_ug); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#underGraduateDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['ug']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['ug']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['pg_leaving_country'] != "" && $applicaitonStepTwo[0]['pg_leaving_country'] > 0)
							if(array_key_exists($doctypes['pg']['type'],$docsArray))
							{
								
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['pg']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['pg']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								   <a target="_blank" href="<?php echo site_url(); ?><?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_pg); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#postGraduateDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['pg']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['pg']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['mphil_leaving_country'] != "" && $applicaitonStepTwo[0]['mphil_leaving_country'] > 0)
							if(array_key_exists($doctypes['mhil']['type'],$docsArray))
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['mhil']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['mhil']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['mhil']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#mphilDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['mhil']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['mhil']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php
							//if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['phd_leaving_country'] != "" && $applicaitonStepTwo[0]['phd_leaving_country'] > 0)
							if(array_key_exists($doctypes['phd']['type'],$docsArray))
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['phd']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['phd']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								 <a target="_blank" href="<?php echo site_url(); ?><?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_phd); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#phdDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['phd']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['phd']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>
							<?php							
							if(count($applicaitonStepThree) > 0 && $applicaitonStepThree[0]['currently_non_nri'] != "" && $applicaitonStepThree[0]['currently_non_nri'] > 0 && $applicaitonStepThree[0]['currently_non_nri'] == 1)
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['indian_address']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['indian_address']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_indian_address); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#addressProofDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['indian_address']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['indian_address']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>		
							<?php							
							if(count($applicaitonStepThree) > 0 && $applicaitonStepThree[0]['is_international_lic'] != "" && $applicaitonStepThree[0]['is_international_lic'] > 0 && $applicaitonStepThree[0]['is_international_lic'] == 1)
							{
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['dl']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['dl']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_d1); ?><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#licenceDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['dl']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['dl']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>						
							<!--<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['physical']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['physical']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_physical); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#physicalFitnessDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['physical']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['physical']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>-->	
							<?php							
							if(count($docsArray) > 0 && array_key_exists($doctypes['tl']['type'],$docsArray))
							{	
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['tl']['title'];?></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['tl']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a target="_blank" href="<?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_tl); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#translationDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['tl']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['tl']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>	
									<?php							
							if(count($docsArray) > 0 && array_key_exists($doctypes['otherDoc']['type'],$docsArray))
							{	
							?>
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['otherDoc']['title'];?></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['otherDoc']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								   <a target="_blank" href="<?php echo site_url().'university/downloadDocs/'.base64url_encode($file_path_otherDoc); ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" data-target="#translationDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['otherDoc']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['otherDoc']['type']]['time']);	
								  }
								  else
								  {
								  ?>
								  N/A
								  <?php	
								  }
								  ?>
								</td>
								
							</tr>
							<?php	
							}	
							?>	
						</tbody>
					</table>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<!----<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Schholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.Any false information given in the application will be liable to cancellation of admission.</span>
					</div>
										
				 </div>--->
				 </div>
		<div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
		
	      <!--  <div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">                
				<a href="javascript:void(0);" onclick="applicaiton_process('Rejected','<?php echo $this->uri->segment(3); ?>');" class="form-control sbmt">Rejected</a>				              
	        </div> -->   
	      <!--   <div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
			  <a href="javascript:void(0);" onclick="applicaiton_process('Process','<?php echo $this->uri->segment(3); ?>');" class="form-control sbmt">Process</a>
			  </div> -->                          
      	</div>
      
              </div>
          
              <!-- /.box-body -->
		
	  </div>	
	     
	</div>
	<hr />
		
		<ul class="list-group checklistdiv">
			<?php
			$checklist = $this->university_model->getUniversityChecklist();
			$counter = 1;$arrrayCounter = array();
			foreach($checklist as $check)
			{
				if(isset($getCheckList) && count($getCheckList)>0 && $getCheckList[0]['checklist_ids'] !="")
				{					
					$idarray = explode(',',$getCheckList[0]['checklist_ids']);	
					
					$vals = $idarray[$counter-1];
					if($counter == 8)
					{	
						if(in_array($check['id'],$idarray))	
						{
							array_push($arrrayCounter,1);
							?>
						<li class="list-group-item" >
							<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span style="font-size:10px;color:red;">Note: (Application may be rejected if this point is not checked.)</span></label>
						</li>						
					<?php
						}
						else
						{
							array_push($arrrayCounter,1);
							?>
							<script type="text/javascript">
								checklist.push('<?php echo $check["id"];?>');
							</script>
						<li class="list-group-item">
							<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><!--span class="notee">Note: (Application may be rejected if this point is not checked.)</span--></label>
						</li>						
					<?php	
						}	
					}	
					else
					{
						if($counter == 4)
						{
							if($applicaitonStepOne[0]['course'] == 12)
							{
								if(in_array($check['id'],$idarray))	
								{
									array_push($arrrayCounter,1);
									?>
								<li class="list-group-item">
									<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span style="font-size:10px;color:red;">Note: (Application may be rejected if this point is not checked.)</span></label>
								</li>						
							<?php
								}
								else
								{
									array_push($arrrayCounter,1);
									?>
									<script type="text/javascript">
										checklist.push('<?php echo $check["id"];?>');
									</script>
								<li class="list-group-item">
									<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><!--span class="notee">Note: (Application may be rejected if this point is not checked.)</span--></label>
								</li>						
							<?php	
								}
							}
						}
						elseif($counter == 5)
						{
							if($applicaitonStepOne[0]['programee'] == 5 || $applicaitonStepOne[0]['programee'] == 6)
							{
								if(in_array($check['id'],$idarray))	
								{
									array_push($arrrayCounter,1);
									?>
								<li class="list-group-item">
									<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span style="font-size:10px;color:red;">Note: (Application may be rejected if this point is not checked.)</span></label>
								</li>						
							<?php
								}
								else
								{
									array_push($arrrayCounter,1);
									?>
									<script type="text/javascript">
										checklist.push('<?php echo $check["id"];?>');
									</script>
								<li class="list-group-item">
									<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><!--span class="notee">Note: (Application may be rejected if this point is not checked.)</span--></label>
								</li>						
							<?php	
								}
							}
						}
						elseif($counter == 6)
						{
							if($applicaitonStepOne[0]['programee'] == 3 || $applicaitonStepOne[0]['programee'] == 4)
							{
								if(in_array($check['id'],$idarray))	
								{
									array_push($arrrayCounter,1);
									?>
								<li class="list-group-item">
									<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span style="font-size:10px;color:red;">Note: (Application may be rejected if this point is not checked.)</span></label>
								</li>						
							<?php
								}
								else
								{
									array_push($arrrayCounter,1);
									?>
									<script type="text/javascript">
										checklist.push('<?php echo $check["id"];?>');
									</script>
								<li class="list-group-item">
									<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><!--span class="notee">Note: (Application may be rejected if this point is not checked.)</span></label-->
								</li>						
							<?php	
								}
							}
						}
						
						
							if(in_array($check['id'],$idarray))
							{
								array_push($arrrayCounter,1);
								?>
								<li class="list-group-item">
							<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?></label>
						</li>
								<?php
							}
							else
							{
								array_push($arrrayCounter,1);
								?>
								<script type="text/javascript">
								checklist.push('<?php echo $check["id"];?>');
							</script>
								<li class="list-group-item">
							<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?></label>
						</li>
								<?php
							}
							?>
						
						<?php
						}
				}
				else
				{
					
					if($counter == 8)
					{
						array_push($arrrayCounter,1);
						?>
							<li class="list-group-item">
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><!--span class="notee">Note: (Application may be rejected if this point is not checked.)</span--></label>
							</li>						
						<?php
					}
					else
					{
						if($counter == 4)
						{
							if($applicaitonStepOne[0]['course'] == 12)
							{
								array_push($arrrayCounter,1);
								?>
							<li class="list-group-item">
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?></label>
							</li>
						<?php
							}
						}
						elseif($counter == 5)
						{
							if((isset($applicaitonStepOne[0]['programee']) ? $applicaitonStepOne[0]['programee'] : null) == 5 || (isset($applicaitonStepOne[0]['programee']) ? $applicaitonStepOne[0]['programee'] : null) == 6)
							{
								array_push($arrrayCounter,1);
								?>
							<li class="list-group-item">
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?></label>
							</li>
						<?php
							}
						}
						elseif($counter == 6)
						{
							if((isset($applicaitonStepOne[0]['programee']) ? $applicaitonStepOne[0]['programee'] : null) == 3 || (isset($applicaitonStepOne[0]['programee']) ? $applicaitonStepOne[0]['programee'] : null) == 4)
							{
								array_push($arrrayCounter,1);
								?>
							<li class="list-group-item">
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?></label>
							</li>
						<?php
							}
						}						
						else
						{
							array_push($arrrayCounter,1);
							if($check['id'] == 8){}else{
						?>
							<li class="list-group-item">
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?></label>
							</li>
						<?php	
							}		
						}
					}
				}
				$counter++;		 
			}
			?>
			
		</ul>	
		<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206);">
		 	<!-----<div class="name-sec col-xs-12 col-sm-6 col-md-9 pdleft">					
				<div class="form-group">
					<label for="comment" style="float: left;width:31%;">Enter English Proficiency Test Marks:<span class="text-red"></span> </label> 
					<select style="float: left;width:12%;" class="form-control" id="testmarks" name="testmarks">		
						<option value="0">Select</option>			
						<option value="1">1</option>			
						<option value="2">2</option>			
						<option value="3">3</option>			
						<option value="4">4</option>			
						<option value="5">5</option>			
						<option value="6">6</option>			
						<option value="7">7</option>			
						<option value="8">8</option>			
						<option value="9">9</option>			
						<option value="10">10</option>			
					</select>
					
				</div>				
			 </div>--->
			 <br/> <br/>
			 <!------<div class="name-sec col-xs-12 col-sm-6 col-md-9 pdleft">
			 
			 	<div class="form-group">
					<label for="comment" style="float: left;">Wheater Applicant has availed ICCR scholarship earlier. <input checked="true" type="radio" id="university_cheklist_avail" value="1" name="university_cheklist_avail"/>&nbsp;&nbsp;Yes&nbsp;&nbsp;
					<input checked="true" type="radio" id="university_cheklist_avail" value="2" name="university_cheklist_avail"/> &nbsp;&nbsp;No</label> 
				</div>	
			 </div>---->
			 <div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Schholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.Any false information given in the application will be liable to cancellation of admission.</span>
					</div>
										
				 </div>
		 </div>
		<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206);">
		 <div class="name-sec col-xs-4 col-sm-2 col-md-6 ">	
		 	<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right pdright">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" title = "" onclick="showUniversityProcess('process');" href="javascript:void(0);">Submit/Proceed</a>
		 	</div>
      	</div>
      	 <div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
      		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pdleft">				
		 	<!-----<a id="step-one-application" name="step-one-application" class="form-control sbmt" title = "Please do not select any checkpoint to hold the application." onclick="hold_application_by_university('<?php echo $this->uri->segment(3); ?>');" href="javascript:void(0);">Hold</a>---->
		 	</div>
      	</div>
      <!--	<div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
      		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pdleft">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="showprocess('reject');" href="javascript:void(0);">Reject</a>
		 	</div>
      	</div>-->
				 <div id="schemes_selection" class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright scholardiv" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: #5b84a6 none repeat scroll 0 0; padding-left: 12px; border: 1px solid rgb(206, 206, 206); color:#fff;">
		 	    <div class="row">
					<div class="form-group col-xs-3">
					    <!----<label for="inputEmail3" class="col-sm-7 control-label">Application Status  <span class="text-red">*</span></label>--->
						<label for="inputEmail3" class="col-sm-7 control-label">Admission confirmed<span class="text-red">*</span></label>
						
					    <div class="col-sm-5">
					      <select id="university_is_accept" name="university_is_accept" class="form-control is_accept" required="true">
					      	<option value="">Select</option>
					      	<option value="1">Yes</option>
					      	<option value="2">No</option>
					      </select>
					    </div>
					</div>
					
					<div class = "is_university_accepct is_university_accepct_yes">
              		<div class="form-group col-xs-3">
					    <label for="inputEmail3" class="col-sm-5">Confirmed by University<span class="text-red">*</span></label>
					    <div class="col-sm-7">
					      <select id="regional_university" name="regional_university" class="form-control" required="true">
					      	<option value="">Select</option>
					      	 <?php					      	 
					      	  foreach($universityarray as $key=>$uni)
					      	  {
								  
							  	echo '<option value="'.$key.'" selected>'.$uni.'</option>';
							  }
					      	 ?>
					      </select>
					    </div>
					</div>
					</div>
					<div class="form-group col-xs-3 is_university_accepct is_university_accepct_yes">
					    <label for="inputEmail3" class="col-sm-3">Lable of Course <span class="text-red">*</span></label>
					    <div class="col-sm-7">					    	
					      <select id="lable_of_course" name="lable_of_course" class="form-control" required="true">
					      	<option value="">Select</option>							  

							  <?php
							  $applicationId = $this->uri->segment(3);
							  $user_data = isset($user_data) ? $user_data : $this->session->userdata('user_data');
							  $universityId = $user_data['university'];
								$getLableOfCourse = $this->common_model->getLableOfCourse($applicationId,$universityId);  
								// print_r($getLableOfCourse);
								foreach($getLableOfCourse as $val) {
									if(!empty($val)){
										echo '<option value="'.$val['id'].'" selected>'.$val['name'].'</option>';
								  
									}
								}
					    	?>
					      </select>
					    </div>
					</div>
					<div class="form-group col-xs-3 is_university_accepct is_university_accepct_yes">
					    <label for="inputEmail3" class="col-sm-3">Main Stream <span class="text-red">*</span></label>
					    <div class="col-sm-7">
					      <select id="course" name="course" class="form-control" required="true">
					      	<option value="">Select</option>	
							  <?php
							  $applicationId = $this->uri->segment(3);
							  $user_data = isset($user_data) ? $user_data : $this->session->userdata('user_data');
							  $universityId = $user_data['university'];
								$getLableOfCourse = $this->common_model->getMainStream($applicationId,$universityId);  
								// print_r($getLableOfCourse);
								foreach($getLableOfCourse as $val) {
									if(!empty($val)){
										echo '<option value="'.$val['id'].'" selected>'.$val['course_type'].'</option>';
								  
									}
								}
					    	?>
					      </select>
					    </div>
					</div>
              	</div>

              	<div class="row is_university_accepct is_university_accepct_yes">
				<div class = "is_university_accepct is_university_accepct_yes">
              		<div class="form-group col-xs-3">
					    <label for="inputEmail3" class="col-sm-5">Nomenclature<span class="text-red">*</span></label>
					    <div class="col-sm-7">
					      <select id="nomenclature" name="nomenclature" class="form-control" required="true" data-searchable="true">
					      	<option value="">Select</option>
							  <?php					      	 
								$applicationId = $this->uri->segment(3);
								$user_data = $this->session->userdata('user_data');
								$universityId = $user_data['university'];
								$uname=$user_data['fname'];
												if($applicaitonStepOne[0]['universty_choice']==$universityId)
												{ $nomen1= $applicaitonStepOne[0]['nomenclature'];
												$nomenc = $this->common_model->getnomenclatureByid($nomen1);
												foreach($nomenc as $nm)
												{
													 echo '<option value="'.$nm['id'].'">'.$nm['title'].'</option>';						
													
												}
												}
												if($applicaitonStepOne[0]['universty_choice_two']==$universityId)
												{ $nomen1= $applicaitonStepOne[0]['nomenclature_two'];
												$nomenc = $this->common_model->getnomenclatureByid($nomen1);
												foreach($nomenc as $nm)
												{
													echo '<option value="'.(isset($nm['id']) ? $nm['id'] : '').'">'.(isset($nm['title']) ? $nm['title'] : '').'</option>';
												}
												}
												if($applicaitonStepOne[0]['universty_choice_three']==$universityId)
												{ $nomen1= $applicaitonStepOne[0]['nomenclature_three'];
												$nomenc = $this->common_model->getnomenclatureByid($nomen1);
												foreach($nomenc as $nm)
												{
													echo '<option value="'.$nm['id'].'">'.$nm['title'].'</option>';
												}
												}
												if($applicaitonStepOne[0]['universty_choice_fourth']==$universityId)
												{ $nomen1= $applicaitonStepOne[0]['nomenclature_fourth'];
												$nomenc = $this->common_model->getnomenclatureByid($nomen1);
												foreach($nomenc as $nm)
												{
													echo '<option value="'.$nm['id'].'">'.$nm['title'].'</option>';
												}
												}
												if($applicaitonStepOne[0]['universty_choice_fifth']==$universityId)
												{ $nomen1= $applicaitonStepOne[0]['nomenclature_fifth'];
												$nomenc = $this->common_model->getnomenclatureByid($nomen1);
												foreach($nomenc as $nm)
												{
													echo '<option value="'.(isset($nm['id']) ? $nm['id'] : '').'">'.(isset($nm['title']) ? $nm['title'] : '').'</option>';
												}
												}
							
					      	 ?>			      	 
					      </select>
					    </div>
					</div>
					</div>
					<!--<div class="form-group col-xs-3">
					    <label for="inputEmail3" class="col-sm-7 control-label">Sub Stream<span class="text-red">*</span></label>
						
					    <div class="col-sm-5">
					      <select id="sub_stream" name="sub_stream" class="form-control" required="true">
					      	<option value="">Select</option>
							  <?php	/*				      	 
							$applicationId = $this->uri->segment(3);
							$user_data = $this->session->userdata('user_data');
							$universityId = $user_data['university'];
							$getCourse = $this->common_model->getCourseDetails($applicationId,$universityId);
							//echo "<pre>";print_r($getCourse['course_name']);
					      	  if(!empty($getCourse)){
								if(is_array($getCourse['course_name'])){
								  echo '<option value="'.$getCourse['course_name'][0].'" selected>'.$getCourse['course_name'][0].'</option>';
								}
								else{
									echo '<option value="'.$getCourse['course_name'].'" selected>'.$getCourse['course_name'].'</option>';	
								}
							  } */
					      	 ?>
					      </select>
					    </div>
					</div>
					
					<div class = "is_university_accepct is_university_accepct_yes">
              		<div class="form-group col-xs-3">
					    <label for="inputEmail3" class="col-sm-5">Subject<span class="text-red">*</span></label>
					    <div class="col-sm-7">
					      <select id="subject" name="subject" class="form-control" required="true">
					      	<option value="">Select</option>
							  <?php	/*				      	 
								$applicationId = $this->uri->segment(3);
								$user_data = $this->session->userdata('user_data');
								$universityId = $user_data['university'];
								$getCourse = $this->common_model->getCourseDetails($applicationId,$universityId);
								//echo "<pre>".$universityId;print_r($getCourse);
								if(!empty($getCourse)){
									if($getCourse['programme_id'] == 4){
										echo '<option value="'.$getCourse['subject'].'" selected>'.$getCourse['name'].'</option>';
								  
										}
										else{
											echo '<option value="'.$getCourse['name'].'" selected>'.$getCourse['name'].'</option>';
										}
									// echo '<option value="'.$getCourse['name'].'" selected>'.$getCourse['name'].'</option>';
								
								} */
					      	 ?>			      	 
					      </select>
					    </div>
					</div>
					</div>-->
					<div class="form-group col-xs-3 is_university_accepct is_university_accepct_yes">
					    <label for="inputEmail3" class="col-sm-3">Duration of Course <span class="text-red">*</span></label>
					    <div class="col-sm-7">
					      <select id="duration_of_course" name="duration_of_course" class="form-control" required="true">
					      	<option value="">Select</option>
							  <?php					      	 
								$applicationId = $this->uri->segment(3);
								$user_data = $this->session->userdata('user_data');
								$universityId = $user_data['university'];
								$getCourse = $this->common_model->getDurationOfCourse($applicationId,$universityId);
								//echo "<pre>";print_r($getCourse);
								if(!empty($getCourse)){
									foreach($getCourse as $val){
									echo '<option value="'.$val['duration'].'" selected>'.$val['duration'].'</option>';
									}
								}
					      	 ?>		
					      </select>
					    </div>
					</div>
					<div class="form-group col-xs-3 is_university_accepct is_university_accepct_yes">
					    <label for="inputEmail3" class="col-sm-3">Date of Joining <span class="text-red">*</span></label>
					    <div class="col-sm-7">
					    	<input type="date" class="form-control" name="date_of_joining" id="date_of_joining">
					    </div>
					</div>
              	<!--</div> 

              		<div class="row">-->
					
					<!-- <div class="form-group col-xs-3 is_fee_structure">
					    <label for="inputEmail3" class="col-sm-5 control-label">Upload Fee Structure  <span class="text-red">*</span></label>
					    <div class="col-sm-3">
					      <input type="file"  name="fee_structure"  required="true" id="fee_structure"/>
					    </div>
					</div> -->
					<div class="form-group col-xs-4 is_university_accepct">
					    <label for="inputEmail3" class="col-sm-5 control-label">Upload University Letter  <span class="text-red">*</span></label>
					    <div class="col-sm-3">
					      <input type="file"  name="inputfile_regional"  required="true" id="inputfile_regional"/>
					    </div>
					</div>
					
					<!-- <div class="form-group col-xs-5 is_university_accepct is_university_accepct_yes">
					 <label for="inputEmail3" class="col-sm-5">Course Confirmed by University<span class="text-red">*</span></label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="confirmedCourse" id="confirmedCourse" required="true"/>
					  </div>
					</div> -->
					
					
					<div class="form-group col-xs-5 decline" style = "display:none">
					 <label for="inputEmail3" class="col-sm-5">Enter reason for decline <span class="text-red">*</span></label>
					<div class="col-sm-7">
					<input type="text" class="form-control" name="reject_reason" id="declineReaso">
					  </div>
					</div>
					
					
					</div>
					
              		
		 </div>
      	</div>
		 <div id="process_selection" class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright processdiv" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206);">
		<p class="p-div aex">It is certified that the application form is completed and the supporting documents have been verified. </p>
		<div class="dateof-birth col-xs-12 col-sm-12 col-md-5 pdleft pdright aex">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft" style="height: 67px;">
					<div class="form-group">
						 <label for="comment" style="float: left;width:100%;">Name of verifying Official: <span class="text-red">*</span></label> <input style="float: left;width:74%;" type="text" class="form-control" placeholder="Name" id="university_name" name="university_name" required="true" />
					</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft" style="height: 67px;">
						<div class="form-group">
						 	<label for="comment" style="float: left;width:100%;">Designation of verifying Official: <span class="text-red">*</span></label> 
						 	<input style="float: left;width:74%;" type="text" class="form-control" placeholder="Designation" required="true" id="university_desg" name="university_desg" />
						</div>	
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft " style="height: 67px;">
					 <label for="comment" style="float: left;width:100%;">Date: </label>
					 <input style="float: left;width:74%;" type="text" class="form-control" required="true" placeholder="DD/MM/YYYY" id="university_date" name="university_date" value="<?php echo date('d-M-Y h:i:s A');?>" />
					</div>
					<br/><br/>
				</div>

				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright aex" style="height: 68px;">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-4 pdleft" style="height: 45px;">
					 
						<div class="form-group">
						 <label for="comment">Place: <span class="text-red">*</span></label> <input style="float: left;width:70%;" type="text" class="form-control" placeholder="Place" id="university_place" name="university_place" />
						</div>
				 </div>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-3 pull-right" style="height: 45px;">
					 <label for="comment"><span class="text-red">*</span>Upload Signature of official</label>
						<div class="form-group">						 
						  <input type="file" id="signature" name="signature" width="" height="0" required="true"/>						 						 
						  
						</div>
				 </div>			
				</div>	
		<!--<div class="name-sec col-xs-4 col-sm-2 col-md-7 pull-right">				
		 	<input type="submit" id = "upload" class="form-control sbmt process-submit" value="Submit"/>
      	</div>-->
      	
</div>
    </form>          	
	</div>
</div>
<div id='loader' style='display: none;'>
							  <img src="<?php echo site_url();?>assets/site/main/images/loader/loaderimg.gif">
							</div>
</section>		
<script type="text/javascript">
	function getCoursename(id)
	{
		var uniid = $('#' + id).val();
		if(uniid != "")
		{
			var appid = $('#approvedappId').val();
			$.ajax({
			    type: "POST",
			    url: baseURL +'university/getCourseDetail',	   
			    data: {'uniid':uniid,'appid':appid},
			    dataType:'json',		    
			    success: function (data) {			    	
			    	
						var htmll = "";
						if(data.programme_id == 1 || data.programme_id == 2){
						htmll += "<option selected='selected' value='" + data.course_name + " " +data.name +"'>" + data.course_name + " " +data.name + "</option>";
						}
						else if(data.programme_id == 4){
							htmll += "<option selected='selected' value='" + data.course_name + " " +data.subject +"'>" + data.course_name + " " +data.subject + "</option>";
						}
						$('#course').html(htmll);
					
			    }
			});
		}
		    	
	}
</script>
<script type='text/javascript'>
	function editRemarks(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('university/editUniversityRemarks')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}

$('#university_is_accept').change(function(){
var is_accepct = $('#university_is_accept').val();
//alert(is_accepct);
if(is_accepct == 1)
		{
			$('#declineReaso').removeAttr("required");
			$('#date_of_joining').attr("required","true");
			
		}
		else{
			//$('#declineReaso').attr("required","true");
			$('#date_of_joining').removeAttr("required");
			$('#regional_university').removeAttr("required");     
			$('#lable_of_course').removeAttr("required");
			$('#course').removeAttr("required");
			$('#nomenclature').removeAttr("required");
			$('#duration_of_course').removeAttr("required");
			$('#date_of_joining').removeAttr("required");
			$('#inputfile_regional').removeAttr("required");
		}
});

  $('#upload111').bind("click",function() 
    { 
	
		
        $('#university_is_accept').addClass("focused");
		var is_accepct = $('#university_is_accept').val();
        if(is_accepct=='') 
        { 
			$("#university_is_accept").focus();
            return false; 
        }
		
		var is_accepct = $('#university_is_accept').val();
		//alert(is_accepct);
		if(is_accepct == 1){
        var imgVal = $('#inputfile_regional').val(); 
        if(imgVal=='') 
        { 
			$("#inputfile_regional").focus();
            return false; 
        } 
		// var feeVal = $('#fee_structure').val(); 
  //       if(feeVal=='') 
  //       { 
		// 	$("#fee_structure").focus();
  //           return false; 
  //       } 

		// var imgVal = $('#confirmedCourse').val(); 
  //       if(imgVal=='') 
  //       { 
		// 	$("#confirmedCourse").focus();
		// 	$("#bio-input").focus();
  //           return false; 
  //       } 
		
		}
		else{
			 var imgVal = $('#inputfile_regional').val(); 
        if(imgVal=='') 
        { 
			$("#inputfile_regional").focus();
            return false; 
        } 
		}


    });
</script>

<?php
// Searchable Nomenclature dropdown - see assets/site/main/js/iccr-searchable-select.js.
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/site/main/css/iccr-searchable-select.css?v=20260925b">
<script src="<?php echo base_url(); ?>assets/site/main/js/iccr-searchable-select.js?v=20260925b"></script>

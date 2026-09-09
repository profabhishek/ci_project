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
$userd = $this->common_model->getUserInfo( $applicaitonStepOne[ 0 ][ 'uid' ] );
//echo "<pre>";print_r($userd);die;
$currentyear = date('Y');
if (!empty($userd->dir)) {
	$ar = explode('/',$userd->dir);
	$oldYear = isset($ar[2]) ? $ar[2] : 'main';
} else {
	$oldYear = 'main';
}
//echo $oldYear;
$universityarray = array();	
$univarray = array();
$isResponseSent = $this->common_model->isAnyUniversityResponseConfirmedByAppno($this->uri->segment(3));	
//echo "<pre>";print_r($isResponseSent);die;
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
				if(!in_array($univercity['id'],$univarray))
				{
					$universityarray[$univercity['id']] = $univercity['name'];	
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
  					
  			
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}
						
		}									
	}								
 }							 	
$univercitie_three = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],$applicaitonStepOne[0]['universty_choice_two']);
foreach($univercitie_three as $univercity1)
  {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_three'] == $univercity1['id'])
  		{  			
  			
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}				
			 
		}									
	}								
 }

$univercitie_fifth = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],$applicaitonStepOne[0]['universty_choice_two'],$applicaitonStepOne[0]['universty_choice_three'],$applicaitonStepOne[0]['universty_choice_fourth']);
foreach($univercitie_fifth as $univercity1)
  {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_fifth'] == $univercity1['id'])
  		{  			
  			
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}				
			 
		}									
	}								
 }
 
 
 
 $univercitie_fourth = $this->common_model->getSelectedUnvercities($applicaitonStepOne[0]['universty_choice'],$applicaitonStepOne[0]['universty_choice_two'],$applicaitonStepOne[0]['universty_choice_three'],$applicaitonStepOne[0]['universty_choice_fifth']);
foreach($univercitie_fourth as $univercity1)
  {
 	if(!empty($applicaitonStepOne))
  	{
  		if($applicaitonStepOne[0]['universty_choice_fourth'] == $univercity1['id'])
  		{  			
  			
				if(!in_array($univercity1['id'],$univarray))
				{
					$universityarray[$univercity1['id']] = $univercity1['name'];	
				}				
			 
		}									
	}								
 }
?>
<section class="meacontent">
<div class="row posi-relas" style = "position:relative;">
<div id='loader' style='display: none;'>
							  <img src="<?php echo site_url();?>assets/site/main/images/loader/loaderimg.gif">
							</div>
<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Mission Checklist For Applicant Scholarship through ICCR</h3>
		<h5 class="text-center">APPLICATION NUMBER : <?php echo $this->uri->segment(3); ?></h5>
	</div>
	<div  class="container" style="padding-bottom:15px;">
	<div class="field-item even" property="content:encoded">
	<form id="form-process-application" action="<?php echo site_url();?>mission/applicaitonProcess" enctype="multipart/form-data" method="post">
		<input type="hidden" id="applicaiton_number" name="applicaiton_number" value="<?php echo $this->uri->segment(3); ?>"/>
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
		<h5 style="text-align:center">Applicant Name : <?php echo $applicaitonStepOne[0]['fullname'];?></h5>
		<h5 style="text-align:center">Email Id : <?php echo $applicaitonStepOne[0]['email'];?></h5>
		<!--------<div><a target="_blank" style="float: right;width:104px;" href="<?php echo site_url(); ?>mission/viewfullApplication/<?php echo $this->uri->segment(3); ?>" class="form-control sbmt1">View</a></div>----->
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
							<th>Upload Document</th>							
							<th>Uploaded Time</th>							
						</thead>
						<tbody>
							<?php
								$counter = 1;	
								$upload = 0;						
								$doctypes = $this->config->item('doc_types');								
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['id']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['passport']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving_x']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['ug']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['pg']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['phd']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['indian_address']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['dl']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['physical']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['tl']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
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
						</tbody>
					</table>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Schholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.</span>
					</div>
										
				 </div>
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
	
	<div class="tab-content docsdiv">		
	  <div id="step3" class="tab-pane fade in active">	 
	  <h5 class="text-center"></h5>	    
	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <div class="box-body">
              	<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
		
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					
					<?php
$response = $this->common_model->getconfirmationDataforHqrs($this->uri->segment(3));
?>
                <table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>Preferences</th>
                    <th >Universities Name</th>
					<th >Confirmed Course</th>
                    <th >Universities Status</th>	
                    <th >University Letter</th>			
					<!-- <th >Fee Structure</th>	 -->
                    <!-----<th >ICCR Letter</th>----->	
					 <th>Date of Confirmation/Rejection</th>
                    </thead>
                              <tbody>
                             <tr>											
                            <td>1.</td>
                            <td>													
                <?php $university_first = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);
                echo $university_first[0]['name']; ?></td>
							<td>  
							<?php
                $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
                       $sts++;
                        if (!empty($resp['confirmed_course'])) {
							 echo $resp['confirmed_course'];	
				        
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
				 if ($sts == 0) {
                    echo "NA";
                }
                
                ?>
				</td>
                            <td>
                <?php
                $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
                        $sts++;
                        if ($resp['university_is_accept'] == 1) {
                            echo "Confirmed";
                        } elseif ($resp['university_is_accept'] == 2) {
                            echo "Not Confirmed";
                        }
                    }
                }
                if ($sts == 0) {
                    echo "NA";
                }
                ?>
                            </td>

                            <td>

<?php
$sts = 0;
foreach ($response as $resp) {
	 $file_path_un = './'.$currentyear.'/university_approval/'.$resp['region_one_doc'];
	
    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
        $sts++;
        if ($resp['university_is_accept'] == 1) {
            
                                           if($oldYear == 'main')
{

 ?>
 
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
//elseif($oldYear == 2022)
//{
	
	if(strpos($resp['region_one_doc'],'.pdf')){ ?>
			<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Download</a>
						<?php   } else {
			   $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);				
?>
																
<a  href="data:<?php echo $mime_type; ?>;base64,<?php echo $data ?>" download="<?php echo rand().time(); ?>" >Download</a>
<?php
						}	
												
//}
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
							
							
							<!---------UNIVERSITY FEE STRUCTURE PDF START---------->
							
							<!-- <td>

<?php
$sts = 0;
foreach ($response as $resp) {
	 $file_path_un = '../../'.$currentyear.'/university_fee_structure/'.$resp['fee_structure'];
	
    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
        $sts++;
        if ($resp['university_is_accept'] == 1) {
            
                                           if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022 && $resp['fee_structure'] != NULL)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
else{echo "NA";}
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
							 -->
							<!---------UNIVERSITY FEE STRUCTURE PDF END---------->
							
							<td>  
							<?php
               $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
                       $sts++;
                        if (!empty($resp['region_one_status_date'])) {
							 $date2 = $resp['region_one_status_date'];	
				        echo date('d-m-Y',$date2);
                            //echo $resp['region_one_status_date'];
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
                if ($sts == 0) {
                                    echo "NA";
                                }
                ?>
				</td>
                            <!-----<td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationNotReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>

                            </td>--->
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td ><?php $university_second = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);
                                echo isset($university_second[0]['name']) ? $university_second[0]['name'] : ''; ?></td>
								<td>  
							<?php
               $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
                       $sts++;
                        if (!empty($resp['confirmed_course'])) {
							 echo $resp['confirmed_course'];	
				        
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
                if ($sts == 0) {
                                    echo "NA";
                                }
                ?>
				</td>
                            <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            echo "Confirmed";
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            echo "Not Confirmed";
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
                        <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
									 $file_path_un = './'.$currentyear.'/university_approval/'.$resp['region_one_doc'];
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
//elseif($oldYear == 2022)
//{
	if(strpos($resp['region_one_doc'],'.pdf')){ ?>
			<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Download</a>
						<?php   } else {
			   $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);				
?>
																
<a  href="data:<?php echo $mime_type; ?>;base64,<?php echo $data ?>" download="<?php echo rand().time(); ?>" >Download</a>
<?php
						}												
//} 
                                        } elseif ($resp['university_is_accept'] == 2) {
                                           if($oldYear == 'main')
{ 
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
							
							<!------------FEE STRUCTURE START--------------------->
							   <!-- <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
									 $file_path_un = '../../'.$currentyear.'/university_fee_structure/'.$resp['fee_structure'];
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        } elseif ($resp['university_is_accept'] == 2) {
                                           if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022 && $resp['fee_structure'] != NULL)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
else{
	echo "NA";
}
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td> -->
							<!------------FEE STRUCTURE END---------------------------------->
							
								<td>  
							<?php
                  $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
                       $sts++;
                        if (!empty($resp['region_one_status_date'])) {
							 $date2 = $resp['region_one_status_date'];	
				        echo date('d-m-Y',$date2);
                            //echo $resp['region_one_status_date'];
							echo "";
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
				if($sts == 0) {
                  echo "NA";
                 }
                
                ?>
				</td>
                            <!-------<td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationNotReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>

                            </td>------>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']);
                                echo isset($university_three[0]['name']) ? $university_three[0]['name'] : ''; ?></td>
								<td>  
							<?php
                $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                       $sts++;
                        if (!empty($resp['confirmed_course'])) {
							 echo $resp['confirmed_course'];	
				        
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
				 if ($sts == 0) {
                    echo "NA";
                }
                
                ?>
				</td>
                            <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            echo "Confirmed";
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            echo "Not Confirmed";
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
                           <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
									 $file_path_un = './'.$currentyear.'/university_approval/'.$resp['region_one_doc'];
									  //echo $resp['university_is_accept'];
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            if($oldYear == 'main')
											
{
	//echo $oldYear;
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}//
//elseif($oldYear == 2022)
//{
	if(strpos($resp['region_one_doc'],'.pdf')){ ?>
			<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Download</a>
						<?php   } else {
			   $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);				
?>
																
<a  href="data:<?php echo $mime_type; ?>;base64,<?php echo $data ?>" download="<?php echo rand().time(); ?>" >Download</a>
<?php
						}	
												
//}
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
							
							
							<!-- <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
									 $file_path_un = '../../'.$currentyear.'/university_fee_structure/'.$resp['fee_structure'];
									  //echo $resp['university_is_accept'];
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            if($oldYear == 'main')
											
{
	//echo $oldYear;
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022 && $resp['fee_structure'] != NULL)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
else{echo "NA";}
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td> -->
							
							
							
							<td>  
							<?php
               $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                       $sts++;
                        if (!empty($resp['region_one_status_date'])) {
							 $date2 = $resp['region_one_status_date'];	
				        echo date('d-m-Y',$date2);
                            //echo $resp['region_one_status_date'];
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
                if ($sts == 0) {
                                    echo "NA";
                                }
                ?>
				</td>
                            <!-------<td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationNotReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
									<td>  
							<?php
               $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                       $sts++;
                        if (!empty($resp['region_one_status_date'])) {
							 $date2 = $resp['region_one_status_date'];	
				        echo date('d-m-Y',$date2);
                            //echo $resp['region_one_status_date'];
                        } 
                    }
                }
                if($sts == 0) {
                  echo "NA";
                 }
                ?>
				</td>
                            </td>-------->
                        </tr>
						
									<!-----Option Fourth Start Here-------->
						
						    <tr>
                            <td>4.</td>
                            <td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fourth']);
                                echo !empty($university_three) ? $university_three[0]['name'] : 'NA'; ?></td>
								<td>  
							<?php
               $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fourth']) {
                       $sts++;
                        if (!empty($resp['confirmed_course'])) {
							 echo $resp['confirmed_course'];	
				        
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
				
                if ($sts == 0) {
                                    echo "NA";
                                }
                ?>
				</td>
                            <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fourth']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            echo "Confirmed";
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            echo "Not Confirmed";
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
                           <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
									 $file_path_un = './'.$currentyear.'/university_approval/'.$resp['region_one_doc'];
									  //echo $resp['university_is_accept'];
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fourth']) {
										
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
											
                                            if($oldYear == 'main')
											
{
	

 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
// elseif($oldYear == 2022)
// {
	//die($file_path_un);
	if(strpos($resp['region_one_doc'],'.pdf')){ ?>
			<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Download</a>
						<?php   } else {
			   $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);				
?>
																
<a  href="data:<?php echo $mime_type; ?>;base64,<?php echo $data ?>" download="<?php echo rand().time(); ?>" >Download</a>
<?php
						}
												
//}
   } elseif ($resp['university_is_accept'] == 2) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
							 <!-- <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
									 $file_path_un = '../../'.$currentyear.'/university_fee_structure/'.$resp['fee_structure'];
									  //echo $resp['university_is_accept'];
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fourth']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            if($oldYear == 'main')
											
{
	//echo $oldYear;
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022 && $resp['fee_structure'] != NULL)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
else{echo "NA";}
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td> -->
								<td>  
							<?php
               $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fourth']) {
                       $sts++;
                        if (!empty($resp['region_one_status_date'])) {
							 $date2 = $resp['region_one_status_date'];	
				        echo date('d-m-Y',$date2);
                            //echo $resp['region_one_status_date'];
							echo "";
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
				if ($sts == 0){
                echo "NA";
                }
                
                ?>
				</td>
                            <!-----<td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fourth']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>university/confirmationReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>university/confirmationNotReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>

                            </td>---->
                        </tr>
						<!-----Option Fourth End Here-------->
						
						
						
						
						
						
						<!-----Option Fifth Start Here-------->
						    <tr>
                            <td>5.</td>
                            <td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_fifth']);
                                echo !empty($university_three) ? $university_three[0]['name'] : 'NA'; ?></td>
								<td>  
							<?php
               $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fifth']) {
                       $sts++;
                        if (!empty($resp['confirmed_course'])) {
							 echo $resp['confirmed_course'];	
				        
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
				if ($sts == 0) {
                                    echo "NA";
                                }
                
                ?>
				</td>
                            <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fifth']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            echo "Confirmed";
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            echo "Not Confirmed";
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $sts = 0;
								
					
							   
                                foreach ($response as $resp) {
									 $file_path_un = './'.$currentyear.'/university_approval/'.$resp['region_one_doc'];
										//echo "<pre>";print_r($oldYear);
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fifth']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
											
											if($oldYear == 'main')
											{
												?>
												<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
												<?php
											}
											//elseif($oldYear == 2022)
											//{
												if(strpos($resp['region_one_doc'],'.pdf')){ ?>
			<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Download</a>
						<?php   } else {
			   $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);				
						?>
																						
						<a  href="data:<?php echo $mime_type; ?>;base64,<?php echo $data ?>" download="<?php echo rand().time(); ?>" >Download</a>
						<?php
						}												
											//}
                                            ?>
											
                                            
                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
											
                                            if($oldYear == 'main')
											
											{
												?>
												<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
												<?php
											}
											elseif($oldYear == 2022)
											{
												?>
												
												<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
												<?php
												
											}
                                            
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td>
							 <!-- <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
									 $file_path_un = '../../'.$currentyear.'/university_fee_structure/'.$resp['fee_structure'];
									  //echo $resp['university_is_accept'];
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fifth']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            if($oldYear == 'main')
											
{
	//echo $oldYear;
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022)
{
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            if($oldYear == 'main')
{
 ?>
<a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
												
<?php
}
elseif($oldYear == 2022 && $resp['fee_structure'] != NULL)
{
	
?>
												
<a target="_blank" href="<?php echo site_url().'mission/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank">Downlaod</a>
<?php
												
}
else{echo "NA";}
                                        }

                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>
                            </td> -->
								<td>  
							<?php
               $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fifth']) {
                       $sts++;
                        if (!empty($resp['region_one_status_date'])) {
							 $date2 = $resp['region_one_status_date'];	
				        echo date('d-m-Y',$date2);
                            //echo $resp['region_one_status_date'];
							echo "";
                        } 
						else{
							echo "NA";
						}
                    }
					
                }
				if ($sts == 0) {
                                    echo "NA";
                                }
                
                ?>
				</td>
                            <!-----<td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_fifth']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>university/confirmationReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>university/confirmationNotReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>

                            </td>---->
                        </tr>
						
						<!-----Option Fifth End Here-------->
						
						
                    </tbody>
                </table>
					
										
				 </div>
				</div>
		<div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
		
	                          
      	</div>
      
              </div>
          
              <!-- /.box-body -->
		
	  </div>	
	     
	</div>
	<hr />
	
	
	
	<hr />
		
		<ul class="list-group checklistdiv">
			<?php
			$checklist = $this->common_model->getMissionChecklist();
			//print_r($checklist);die;
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
							<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span class="notee">Note: (Application may be rejected if this point is not checked.)</span></label>
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
									<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span class="notee">Note: (Application may be rejected if this point is not checked.)</span></label>
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
									<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span class="notee">Note: (Application may be rejected if this point is not checked.)</span></label>
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
									<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span class="notee">Note: (Application may be rejected if this point is not checked.)</span></label>
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
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span class="notee">Note: (Application may be rejected if this point is not checked.)</span></label>
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
							if($applicaitonStepOne[0]['programee'] == 5 || $applicaitonStepOne[0]['programee'] == 6)
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
							if($applicaitonStepOne[0]['programee'] == 3 || $applicaitonStepOne[0]['programee'] == 4)
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
						?>
							<li class="list-group-item">
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?></label>
							</li>
						<?php		
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
			 <div class="name-sec col-xs-12 col-sm-6 col-md-9 pdleft">
			 
			 	<div class="form-group">
					<label for="comment" style="float: left;">Wheater Applicant has availed ICCR scholarship earlier. <input checked="true" type="radio" id="mission_cheklist_avail" value="1" name="mission_cheklist_avail"/>&nbsp;&nbsp;Yes&nbsp;&nbsp;
					<input checked="true" type="radio" id="mission_cheklist_avail" value="2" name="mission_cheklist_avail"/> &nbsp;&nbsp;No</label> 
					
				</div>	
			 </div>
		 </div>
		<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206);">
		 <div class="name-sec col-xs-4 col-sm-2 col-md-6 ">	
		 	<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right pdright">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="showprocess('process');" href="javascript:void(0);">Process</a>
		 	</div>
      	</div>
      	 	<!------<div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
      		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pdleft">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="hold_application('<?php echo $this->uri->segment(3); ?>');" href="javascript:void(0);">Hold</a>
		 	</div>
      	</div>------>
      <!--	<div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
      		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pdleft">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="showprocess('reject');" href="javascript:void(0);">Reject</a>
		 	</div>
      	</div>-->
      	</div>
		 <div id="schemes_selection" class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright scholardiv" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: #5b84a6 none repeat scroll 0 0; padding-left: 12px; padding-right: 12px; border: 12px; border: 1px solid rgb(206, 206, 206); color:#fff;">
		 <div class="row">
					<div class="form-group col-xs-3">
					    <!----<label for="inputEmail3" class="col-sm-7 control-label">Application Status  <span class="text-red">*</span></label>--->
						<label for="inputEmail3" class="control-label">Scholarship&nbsp;confirmed<span class="text-red">*</span></label>
						
					    <div class="">
					      <select id="university_is_accept" name="university_is_accept" onchange="getUniversityConfirmData(this.id);"  class="form-control is_accept" required="true">
					      	<option value="">Select</option>
					      	<option value="1">Yes</option>
					      	<!------<option value="2">No</option>---->
					      </select>
					    </div>
					</div>
					
					
              		<div class="form-group col-xs-5 is_university_accepct">
					    <label for="inputEmail3" class="control-label">Select&nbsp;Universities<span class="text-red">*</span></label>
					    <div class="">
					      <select id="regional_university" name="regional_university" class="form-control" required="true" onchange="getCoursename(this.id);">
					      	<option value="">Select</option>
					      	 
					      </select>
					    </div>
					</div>
				
					<!--<div class="form-group col-xs-4 is_university_accepct">
					    <label for="inputEmail3" class="control-label">Sub Stream / Subject  <span class="text-red">*</span></label>
					    <div class="">
					      <select id="course" name="course" class="form-control" required="true">
					      	<option value="">Select</option>					      	
					      </select>
					    </div>
					</div>-->
              	</div>
				
						
					<div class="row">

					<!--<div class="form-group col-xs-3">
					    <label for="inputEmail3" class="control-label">Course Confirmed In <span class="text-red">*</span></label>
					    <div class="">
							
							<select id="final_course" name="final_course" class="form-control">
								<option value=" ">Select</option>
								<optgroup label="UG Course" style="font-size:14px">
								<option value="BA">BA</option>
								<option value="BA (Yoga Shastra)">BA (Yoga Shastra)</option>
								<option value="BAMS">BAMS</option>
								<option value="BArch">BArch</option>
								<option value="BBA">BBA</option>
								<option value="BCA">BCA</option>
								<option value="BCom">BCom</option>
								<option value="BE">BE</option>
								<option value="BEd">BEd</option>
								<option value="BFA">BFA</option>
								<option value="BHM">BHM</option>
								<option value="BHMS">BHMS</option>
								<option value="BJMC">BJMC</option>
								<option value="BMS">BMS</option>
								<option value="BPA">BPA</option>
								<option value="BPharma">BPharma</option>
								<option value="BSc">BSc</option>
								<option value="BSc (Yoga)">BSc (Yoga)</option>
								<option value="BSMS">BSMS</option>
								<option value="BSW">BSW</option>
								<option value="BTech">BTech</option>
								<option value="BTTM">BTTM</option>
								<option value="BVoc">BVoc</option>
								<option value="BVSc">BVSc</option>
								</optgroup>
								<optgroup label="Certificate/Diploma Course" style="font-size:14px">
								<option value="Certificate">Certificate</option>
								<option value="Diploma">Diploma</option>
								</optgroup>
								<optgroup label="PG Course" style="font-size:14px">
								<option value="MA">MA</option>
								<option value="MArch">MArch</option>
								<option value="MBA">MBA</option>
								<option value="MCA">MCA</option>
								<option value="MCom">MCom</option>
								<option value="MD (Ayurveda)">MD (Ayurveda)</option>
								<option value="MD (Homeopathy)">MD (Homeopathy)</option>
								<option value="MD (Siddha)">MD (Siddha)</option>
								<option value="MD (Unani)">MD (Unani)</option>
								<option value="MDesign">MDesign</option>
								<option value="ME">ME</option>
								<option value="MEd">MEd</option>
								<option value="MFA">MFA</option>
								<option value="MHRM">MHRM</option>
								<option value="MJMC">MJMC</option>
								<option value="MMS">MMS</option>
								<option value="MPA">MPA</option>
								<option value="MPEd">MPEd</option>
								<option value="MPH">MPH</option>
								<option value="MPharma">MPharma</option>
								<option value="MSc">MSc</option>
								<option value="MSc (Yoga)">MSc (Yoga)</option>
								<option value="MTech">MTech</option>
								<option value="MTTM">MTTM</option>
								<option value="MURP">MURP</option>
								<option value="MVA">MVA</option>
								<option value="MVSc">MVSc</option>
                                                                <option value="MPlan">MPlan</option>

								</optgroup>
								<optgroup label="PhD Course" style="font-size:14px">
								<option value="PhD (Ayurveda)">PhD (Ayurveda)</option>
								<option value="PhD (Yoga)">PhD (Yoga)</option>
								<option value="PhD">PhD</option>
								</optgroup>
							</select>
					    </div>
					</div>-->
		
					<div class="form-group col-xs-5">
					    <label class="control-label">Nomenclature:<span class="text-red">*</span></label>
					    <div class="">
					     			 <select class="form-control" id="nomenclature" name="nomenclature" required="true" >		
						<option value="">Select</option>			
						<?php
						
						$schemesList = $this->common_model->getnomenclature();
						// print_r($schemesList);die();
						            usort($schemesList, function($a, $b) {
                return strcmp($a['title'], $b['title']);
            });

						
						foreach($schemesList as $nomen)
						{						
							
							echo '<option value="'.$nomen['id'].'">'.$nomen['title'].'</option>';
							
						
						}
						?>
					</select>
					    </div>
					</div>
              		<div class="form-group col-xs-5">
					    <label class="control-label">Scholarship Programme:<span class="text-red">*</span></label>
					    <div class="">
					     			 <select class="form-control" id="schloarship_name" name="schloarship_name" required="true" onchange="getSchemeType(this.id);">		
						<option value="">Select</option>			
						<?php
						
						$user_data = $this->session->userdata('user_data');

						$missionId = $user_data['user_country'];
						//echo "<pre>";
						//print_r($missionId);die;
						$mis = $this->common_model->getMissionInfo($missionId);
						$miss = $this->common_model->getMissionInfos($this->ids);
						//$this->
						$schemesList = $this->common_model->getAllSchemesSlotsOfMission($this->ids);
						// print_r($schemesList);die();

						$schemsArray = array();
						foreach($schemesList as $list)
						{
							$countrList = $list['country_id'];
							$countryArray = explode('|',$countrList);
							
							foreach($miss as $misss)
							{				
								if(in_array($misss['country'],$countryArray))
								{
									if(!array_key_exists($list['scheme_id'],$schemsArray))
									{
										$code = $list['scheme_type'];
										$scheme_code = $list['code'];
										
										$schemsArray[$list['scheme_id']] = array('name'=>$list['scheme_name'],'scheme_code'=>$scheme_code,'code'=>$code);
									}
									
								}
							}
							
						}
						foreach($schemsArray as $key=>$vals)
						{						
							
							echo '<option value="'.$key.'">'.$vals['name'].' - '.$vals['scheme_code'].'</option>';
							?>
								<script type="text/javascript">
									var schemet = [];									
									schemet['scheme_type'] = '<?php echo $vals["code"];?>';
									schemetype['<?php echo $key;?>'] = schemet;
								</script>
							<?php
						}
						/*$schemes = $this->common_model->getAllSchemesOfMission($mis[0]['country']);
						foreach($schemes as $scheme)
						{
							?>
								<script type="text/javascript">
									var schemet = [];									
									schemet['scheme_type'] = '<?php echo $scheme["scheme_type"];?>';
									schemetype['<?php echo $scheme["id"];?>'] = schemet;
								</script>
							<?php
							echo '<option value="'.$scheme['id'].'">'.$scheme['scheme_name'].'</option>';
						}*/
						?>
					</select>
					    </div>
					</div>
					
					<div class="form-group col-xs-4">
					    <label class="control-label">Undertaking&nbsp;(Last&nbsp;Date)<span class="text-red">*</span></label>
					    <div class="">
							<input type="text" class="form-control datepicker_arrival" name="timeline" id="timeline" required="true"/>
					    </div>
					</div>
					</div>
					
					<div class="row">
		
              		
					</div>
              		

		 </div>
		 <div id="process_selection" class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright processdiv" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206);">
		<p class="p-div">It is certified that the application form is completed and the supporting documents have been verified. </p>
		<div class="dateof-birth col-xs-12 col-sm-12 col-md-5 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft" style="height: 67px;">
					<div class="form-group">
						 <label for="comment" style="float: left;width:100%;">Name of verifying Official: <span class="text-red">*</span></label> <input style="float: left;width:74%;" type="text" class="form-control" placeholder="Name" id="mission_name" name="mission_name" required="true" />
					</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft" style="height: 67px;">
						<div class="form-group">
						 	<label for="comment" style="float: left;width:100%;">Designation of verifying Official: <span class="text-red">*</span></label> 
						 	<input style="float: left;width:74%;" type="text" class="form-control" placeholder="Designation" required="true" id="mission_desg" name="mission_desg" />
						</div>	
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft " style="height: 67px;">
					 <label for="comment" style="float: left;width:100%;">Date: </label>
					 <input style="float: left;width:74%;" type="text" class="form-control" required="true" placeholder="DD/MM/YYYY" id="mission_date" name="mission_date" value="<?php echo date('d-M-Y h:i:s A');?>" />
					</div>
					<br/><br/>
				</div>

				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright" style="height: 68px;">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-4 pdleft" style="height: 45px;">
					 
						<div class="form-group">
						 <label for="comment">Place: <span class="text-red">*</span></label> <input style="float: left;width:70%;" type="text" class="form-control" placeholder="Place" id="mission_place" name="mission_place" />
						</div>
				 </div>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-3 pull-right" style="height: 45px;">
					 <label for="comment">Upload Signature of official</label>
						<div class="form-group">						 
						  <input type="file" id="signature" name="signature" width="" height="0" required="true"/>						 						 
						  
						</div>
				 </div>			
				</div>	
		<div class="name-sec col-xs-4 col-sm-2 col-md-7 pull-right">				
		 	<input type="submit" class="form-control sbmt process-submit" value="Submit"/>
      	</div>
      	
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
			var appid = $('#applicaiton_number').val();
			$.ajax({
			    type: "POST",
			    url: baseURL +'mission/getCourseDetail',	   
			    data: {'uniid':uniid,'appid':appid},
			    dataType:'json',		    
			    success: function (data) {			    	
			    	
						var htmll = "";
						htmll += "<option selected='selected' value='" + data.course_name + " " +data.subject +"'>" + data.course_name + " / " +data.name + "</option>";
						$('#course').html(htmll);
						
					
			    }
			});
		}
		    	
	}
	function getUniversityConfirmData(id)
	{
		var is_accept = $('#' + id).val();
		
		if(is_accept != "")
		{
			var appid = $('#applicaiton_number').val();
			$.ajax({
			    type: "POST",
			    url: baseURL +'mission/getUniversityConfirmDetail',	   
			    data: {'is_accept':is_accept,'appid':appid},
			    dataType:'json',	
				beforeSend: function() {
				$("#loader").show();
				},
			    success: function (data) {			    	
			    	var htmll = "";
					htmll += "<option value=''>-- Select --</option>";
					for(var j=0; j<data.length;j++)
						{
							
							htmll += "<option value='"+ data[j].UnId +"'>" + data[j].name + "</option>";
						}
						

						$('#regional_university').html(htmll);
						$("#loader").hide();
					
			    }
			});
		}
		    	
	}
	function getUniversityConfirmationFile(id)
	{
		var is_accept = $('#' + id).val();
		
		if(is_accept != "")
		{
			var appid = $('#applicaiton_number').val();
			$.ajax({
			    type: "POST",
			    url: baseURL +'mission/getUniversityConfirmDetail',	   
			    data: {'is_accept':is_accept,'appid':appid},
			    dataType:'json',		    
			    success: function (data) {			    	
			    	var htmll = "";
					htmll += "<option value=''>-- Select --</option>";
					for(var j=0; j<data.length;j++)
						{
							
							htmll += "<option value='"+ data[j].id +"'>" + data[j].region_one_doc + "</option>";
						}
						

						$('#university_letter').html(htmll);
					
			    }
			});
		}
		    	
	}
	
</script>	
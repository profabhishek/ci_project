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
<section class="meacontent">
<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Mission Checklist For Applicant Scholarship through ICCR</h3>
		<h5 class="text-center">APPLICATION NUMBER : <?php echo $this->uri->segment(3); ?></h5>
	</div>
	<div  class="container" style="padding-bottom:15px;">
	<div class="field-item even" property="content:encoded">
	<form id="form-process-application-agree" action="<?php echo site_url();?>mission/applicaitonAgreeProcess" enctype="multipart/form-data" method="post">
		<input type="hidden" id="applicaiton_number" name="applicaiton_number" value="<?php echo $this->uri->segment(3); ?>"/>
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
		<h5 style="text-align:center">Applicant Name : <?php echo $applicaitonStepOne[0]['fullname'];?></h5>
		<h5 style="text-align:center">Email Id : <?php echo $applicaitonStepOne[0]['email'];?></h5>
		<hr />
		<?php 
	
	$docsArray = array();
	if(count($applicaitonDocuments) > 0)
	{
		foreach($applicaitonDocuments as $docs)
		{
			if(!array_key_exists($docs['doc_type'],$docsArray))
			{
				$docsArray[$docs['doc_type']] = array();
			}
			$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
			$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
		}
	}		
	?>
	

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
							<tr>
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
								
							</tr>	
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
	<hr />
		<ul class="list-group checklistdiv">
			<?php
			$checklist = $this->common_model->getMissionChecklist();
			$counter = 1;
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
							?>
							
						<li class="list-group-item">
							<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo $counter.'. '.$check['item']; ?><span style="font-size:10px;color:red;">Note: (Application will be rejected if this point is not checked.)</span></label>
						</li>						
					<?php
						}
						else
						{
							?>
							<script type="text/javascript">
								checklist.push('<?php echo $check["id"];?>');
							</script>
						<li class="list-group-item">
							<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo $counter.'. '.$check['item']; ?><span class="notee">Note: (Application will be rejected if this point is not checked.)</span></label>
						</li>						
					<?php	
						}	
					}	
					else
					{
						
							if(in_array($check['id'],$idarray))
							{
								?>
								<li class="list-group-item">
							<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo $counter.'. '.$check['item']; ?></label>
						</li>
								<?php
							}
							else
							{
								?>
								<script type="text/javascript">
								checklist.push('<?php echo $check["id"];?>');
							</script>
								<li class="list-group-item">
							<input type="checkbox" checked="true" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo $counter.'. '.$check['item']; ?></label>
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
						
						?>
							<li class="list-group-item">
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo $counter.'. '.$check['item']; ?><span class="notee">Note: (Application will be rejected if this point is not checked.)</span></label>
							</li>						
						<?php
					}
					else
					{
						?>
					<li class="list-group-item">
						<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo $counter.'. '.$check['item']; ?></label>
					</li>
					<?php
					}
				}
				$counter++;		 
			}
			?>
			
		</ul>		
		<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206);">
		 	<!-----<div class="name-sec col-xs-12 col-sm-6 col-md-9 pdleft">					
				<div class="form-group">
					<label for="comment" style="float: left;width:31%;">Enter English Proficiency Test Marks: </label> 
					<select style="float: left;width:12%;" class="form-control" id="testmarks" name="testmarks">		
						<option value="">Select</option>			
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
		<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206); display:none;">
		 <div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
		 	<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right pdright">
		 	<?php
		 	// The Process button used to reveal the certification block below by
		 	// calling showprocess('process'). That block is now shown at all
		 	// times, so this button no longer does anything useful and its
		 	// container is hidden (display:none above). The markup is left in
		 	// place rather than deleted because showprocess() also sets the
		 	// submit button's caption, which the controller reads as the "type"
		 	// field; that caption is now set directly on the button instead.
		 	?>
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="showprocess('process');" href="javascript:void(0);">Process</a>
		 	</div>
      	</div>
      	 	<!-----<div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
      		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pdleft">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="hold_application('<?php echo $this->uri->segment(3); ?>');" href="javascript:void(0);">Hold</a>
		 	</div>
      	</div>--->
      <!--	<div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
      		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pdleft">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="showprocess('reject');" href="javascript:void(0);">Reject</a>
		 	</div>
      	</div>-->
      	</div>
		 <?php
		 // ---------------------------------------------------------------------
		 // "Select Scholarship Programme" has been removed from this screen.
		 //
		 // The scheme is NOT simply dropped, because two saved values depend on
		 // it in Mission::applicaitonAgreeProcess():
		 //     $update['scholarship_id'] = ...schloarship_name
		 //     $referenceNumber = country-YEAR-schloarship_name-rand-no
		 // Posting an empty value would blank scholarship_id and produce a
		 // malformed reference number on every application processed from here.
		 //
		 // So the scheme already recorded against this application is carried in
		 // the hidden field below under the SAME field name the controller
		 // already reads. Nothing on the server side changes, and the value
		 // saved is the one the application already had.
		 //
		 // The original dropdown markup is preserved in the comment block that
		 // follows, so it can be restored if this decision is ever reversed.
		 // ---------------------------------------------------------------------
		 // The scheme already on the record, if the application has one.
		 $missionSchemeId = '';
		 if (!empty($mappingData) && is_array($mappingData) && count($mappingData) > 0 && !empty($mappingData[0]['scholarship_id'])) {
		 	$missionSchemeId = $mappingData[0]['scholarship_id'];
		 }

		 // For a new application it usually does NOT have one: scholarship_id is
		 // only written when the Mission processes the application, and this
		 // screen is where that happened. So build the same list of schemes the
		 // old dropdown offered, from the schemes allocated to this Mission.
		 $missionSchemeChoices = array();
		 $schemesList = $this->common_model->getAllSchemesSlotsOfMission($this->ids);
		 $missionInfos = $this->common_model->getMissionInfos($this->ids);
		 if (is_array($schemesList) && is_array($missionInfos)) {
		 	foreach ($schemesList as $oneScheme) {
		 		$countryArray = explode('|', $oneScheme['country_id']);
		 		foreach ($missionInfos as $oneMission) {
		 			if (in_array($oneMission['country'], $countryArray)) {
		 				if (!array_key_exists($oneScheme['scheme_id'], $missionSchemeChoices)) {
		 					$missionSchemeChoices[$oneScheme['scheme_id']] = $oneScheme['scheme_name'];
		 				}
		 			}
		 		}
		 	}
		 }

		 // If the record has no scheme yet and exactly one is available to this
		 // Mission, there is nothing to choose - assign it. If several are
		 // available only a person can decide, so a dropdown is still shown.
		 // Posting an empty value is never acceptable: scholarship_id would be
		 // saved blank and the reference number would come out as
		 // COUNTRY-YEAR--rand-no with a gap where the scheme belongs.
		 if ($missionSchemeId === '' && count($missionSchemeChoices) === 1) {
		 	$missionSchemeId = key($missionSchemeChoices);
		 }

		 $missionSchemeName = '';
		 if ($missionSchemeId !== '') {
		 	$missionSchemeRow = $this->common_model->getSchemeById($missionSchemeId);
		 	if (is_array($missionSchemeRow) && count($missionSchemeRow) > 0 && isset($missionSchemeRow[0]['scheme_name'])) {
		 		$missionSchemeName = $missionSchemeRow[0]['scheme_name'];
		 	}
		 }

		 $missionSchemeNeedsChoice = ($missionSchemeId === '' && count($missionSchemeChoices) > 1);
		 ?>
		 <?php if ($missionSchemeNeedsChoice) { ?>
		 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 12px; padding-bottom: 12px; background: #5b84a6 none repeat scroll 0 0; padding-left: 12px; border: 1px solid rgb(206, 206, 206); color:#fff;">
		 	<div class="name-sec col-xs-12 col-sm-12 col-md-10 pdleft">
		 		<div class="form-group">
		 			<label for="schloarship_name" style="float: left; width:24%;">Scholarship Programme: <span style="color:#ffdddd;">*</span></label>
		 			<select class="form-control" id="schloarship_name" name="schloarship_name" style="float:left; width:60%;">
		 				<option value="">Select</option>
		 				<?php foreach ($missionSchemeChoices as $schemeKey => $schemeLabel) { ?>
		 				<option value="<?php echo htmlspecialchars($schemeKey, ENT_QUOTES); ?>"><?php echo htmlspecialchars($schemeLabel, ENT_QUOTES); ?></option>
		 				<?php } ?>
		 			</select>
		 		</div>
		 	</div>
		 </div>
		 <?php } else { ?>
		 <input type="hidden" id="schloarship_name" name="schloarship_name" value="<?php echo htmlspecialchars($missionSchemeId, ENT_QUOTES); ?>"/>
		 <?php if ($missionSchemeName !== '') { ?>
		 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 12px; padding-bottom: 12px; background: #5b84a6 none repeat scroll 0 0; padding-left: 12px; border: 1px solid rgb(206, 206, 206); color:#fff;">
		 	<div class="name-sec col-xs-12 col-sm-12 col-md-12 pdleft">
		 		<label style="float:left;">Scholarship Programme:&nbsp;</label>
		 		<span style="float:left;"><?php echo htmlspecialchars($missionSchemeName, ENT_QUOTES); ?></span>
		 	</div>
		 </div>
		 <?php } ?>
		 <?php } ?>
		 <!-- ORIGINAL SCHOLARSHIP DROPDOWN - REMOVED ON REQUEST, KEPT FOR REFERENCE
		 <div id="schemes_selection" class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright scholardiv" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: #5b84a6 none repeat scroll 0 0; padding-left: 12px; border: 1px solid rgb(206, 206, 206); color:#fff;">
		 	<div class="name-sec col-xs-12 col-sm-6 col-md-10 pdleft">
				<div class="form-group">
					<label for="comment" style="float: left;width:24%;">Select Scholarship Programme: </label>
					<select class="form-control" id="schloarship_name" name="schloarship_name" required="true" onchange="getSchemeType(this.id);">
						<option value="">Select</option>
						[ scheme options were rendered here from
						  Common_model::getAllSchemesSlotsOfMission() ]
					</select>
					<label id="lbl_scheme_type" style="float:left;width:228px;margin-left:15px;margin-top: 7px;"></label>
				</div>
			 </div>
		 </div>
		 -->
		 <?php
		 // ---------------------------------------------------------------------
		 // Mission document uploads.
		 //
		 // Both files are stored under assets/site/main/mission_documents/,
		 // alongside the existing mission_signature folder, and their filenames
		 // are saved to iccr_status_mapping.mission_medical_fitness and
		 // .mission_undertaking_form.
		 //
		 // These are deliberately NOT the existing medical_fitness /
		 // undertaking_doc columns: those belong to a later stage and are
		 // written by the applicant, and undertaking_doc holds a UNIX timestamp
		 // that Home.php renders with date(). Writing a filename there would
		 // break the applicant's status and date display.
		 // ---------------------------------------------------------------------
		 ?>
		 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206);">
			<div class="name-sec col-xs-12 col-sm-6 col-md-6 pdleft">
				<div class="form-group">
					<label for="medical_fitness_doc" style="float: left; width:100%;">1. Medical Fitness Certificate <span style="color:red;">*</span></label>
					<input type="file" id="medical_fitness_doc" name="medical_fitness_doc" accept="application/pdf" class="mission-required-file"/>
					<span style="display:block; font-size:11px; color:#666;">PDF only, maximum 2 MB.</span>
				</div>
			</div>
			<div class="name-sec col-xs-12 col-sm-6 col-md-6 pdleft">
				<div class="form-group">
					<label for="undertaking_form_doc" style="float: left; width:100%;">2. Undertaking Form <span style="color:red;">*</span></label>
					<input type="file" id="undertaking_form_doc" name="undertaking_form_doc" accept="application/pdf" class="mission-required-file"/>
					<span style="display:block; font-size:11px; color:#666;">PDF only, maximum 2 MB.</span>
				</div>
			</div>
		 </div>
		 <?php
		 // The certification block below was hidden until the Process button was
		 // clicked. With that button gone it is shown at all times, so the
		 // "processdiv" class and the inline hiding have been dropped.
		 ?>
		 <?php
		 // The id is deliberately NOT "process_selection". The shared script
		 // assets/site/main/js/custom.js runs
		 //     $('#process_selection').hide();
		 // on document ready for every page that includes it, which would hide
		 // this block again as soon as the page loaded. Renaming it here leaves
		 // that shared behaviour untouched for the other checklist screen while
		 // keeping this section permanently visible.
		 ?>
		 <div id="mission_process_selection" class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: rgb(244, 244, 244) none repeat scroll 0% 0%; padding-left: 12px; border: 1px solid rgb(206, 206, 206);">
		<p class="p-div">It is certified that the application form is completed and the supporting documents have been verified. </p>
		<div class="dateof-birth col-xs-12 col-sm-12 col-md-5 pdleft pdright">	
					
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft" style="height: 67px;">
					<div class="form-group">
						 <label for="comment" style="float: left;width:100%;">Name of verifying Official: </label> <input style="float: left;width:74%;" type="text" class="form-control" placeholder="Name" id="mission_name" name="mission_name" required="true" />
					</div>
					</div>
					<div class="name-sec col-xs-12 col-sm-3 col-md-9 pdleft" style="height: 67px;">
						<div class="form-group">
						 	<label for="comment" style="float: left;width:100%;">Designation of verifying Official: </label> 
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
						 <label for="comment">Place: <span style="color:red;">*</span></label> <input style="float: left;width:70%;" type="text" class="form-control" placeholder="Place" id="mission_place" name="mission_place" required="true" />
						</div>
				 </div>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-3 pull-right" style="height: 45px;">
					 <label for="comment">Upload Signature of official <span style="color:red;">*</span></label>
						<div class="form-group">
						  <input type="file" id="signature" name="signature" class="mission-required-file" width="" height="0"/>
						</div>
				 </div>
				</div>
		<div class="name-sec col-xs-4 col-sm-2 col-md-7 pull-right">
			<?php
			// The submit button's caption is posted as the "type" field and the
			// controller switches on it: only "Submit Application" runs the
			// approval path. That caption used to be set by showprocess() when
			// the Process button was clicked; with that button gone it is set
			// here directly, otherwise the value would stay "Submit" and the
			// controller's switch would match nothing and silently do nothing.
			//
			// It starts disabled and is enabled by the page script below only
			// once every required field and document is present.
			?>
		 	<input type="submit" class="form-control sbmt process-submit" value="Submit Application" disabled="disabled"/>
			<span id="mission_submit_hint" style="display:block; font-size:11px; color:#a94442; margin-top:4px;">Complete all fields and upload all documents to enable submission.</span>
      	</div>

</div>
    </form>
	</div>
</div>
</section>
<script type="text/javascript">
// ---------------------------------------------------------------------------
// Mission process screen - submission gate.
//
// The Process button that used to reveal the certification block has been
// removed, so that block is now always on screen. In exchange, the Submit
// Application button stays disabled until every required field is filled in
// and all three documents are attached:
//
//     - Medical Fitness Certificate (PDF, max 2 MB)
//     - Undertaking Form            (PDF, max 2 MB)
//     - Signature of the official
//
// This is a convenience check only. The same rules are enforced again in
// Mission::applicaitonAgreeProcess(), because anything validated solely in the
// browser can be bypassed.
// ---------------------------------------------------------------------------
$(document).ready(function () {

	var MAX_PDF_BYTES = 2 * 1024 * 1024; // 2 MB

	// The shared script custom.js hides #process_selection on ready for
	// every page it is included on. This block was renamed to
	// #mission_process_selection so it is not caught by that, but make sure it
	// is visible in case any other rule hides it.
	$('#mission_process_selection').show();

	function pdfProblem(inputId, label) {
		var el = document.getElementById(inputId);
		if (!el || !el.files || el.files.length === 0) {
			return label + ' is required.';
		}
		var f = el.files[0];
		var nameLower = (f.name || '').toLowerCase();
		if (nameLower.slice(-4) !== '.pdf') {
			return label + ' must be a PDF file.';
		}
		if (f.size > MAX_PDF_BYTES) {
			return label + ' must be 2 MB or smaller.';
		}
		return '';
	}

	function signatureProblem() {
		var el = document.getElementById('signature');
		if (!el || !el.files || el.files.length === 0) {
			return 'Signature of the official is required.';
		}
		if (el.files[0].size > MAX_PDF_BYTES) {
			return 'Signature must be 2 MB or smaller.';
		}
		return '';
	}

	function textProblem() {
		var required = [
			{ id: 'mission_name',  label: 'Name of verifying Official' },
			{ id: 'mission_desg',  label: 'Designation of verifying Official' },
			{ id: 'mission_date',  label: 'Date' },
			{ id: 'mission_place', label: 'Place' }
		];
		for (var i = 0; i < required.length; i++) {
			var v = $('#' + required[i].id).val();
			if (!v || $.trim(v) === '') {
				return required[i].label + ' is required.';
			}
		}
		return '';
	}

	// The scheme must never post empty: the controller writes it to
	// scholarship_id and builds the reference number from it. When the
	// application already has a scheme, or the Mission has only one, this is a
	// hidden field that is always filled. When several are available it is a
	// dropdown, and the official has to pick one.
	function schemeProblem() {
		var v = $('#schloarship_name').val();
		if (!v || $.trim(v) === '') {
			return 'Scholarship Programme is required.';
		}
		return '';
	}

	function firstProblem() {
		return schemeProblem()
			|| textProblem()
			|| pdfProblem('medical_fitness_doc', 'Medical Fitness Certificate')
			|| pdfProblem('undertaking_form_doc', 'Undertaking Form')
			|| signatureProblem();
	}

	function refreshSubmitState() {
		var problem = firstProblem();
		if (problem === '') {
			$('.process-submit').prop('disabled', false);
			$('#mission_submit_hint').text('').hide();
		} else {
			$('.process-submit').prop('disabled', true);
			$('#mission_submit_hint').text(problem).show();
		}
	}

	$('#mission_name, #mission_desg, #mission_date, #mission_place').on('input change keyup blur', refreshSubmitState);
	$('#medical_fitness_doc, #undertaking_form_doc, #signature').on('change', refreshSubmitState);
	$('#schloarship_name').on('change', refreshSubmitState);

	refreshSubmitState();

	// Final guard: if the button is somehow enabled, still refuse to submit an
	// incomplete form.
	$('#form-process-application-agree').on('submit', function (e) {
		var problem = firstProblem();
		if (problem !== '') {
			e.preventDefault();
			e.stopImmediatePropagation();
			if (typeof BootstrapDialog !== 'undefined') {
				BootstrapDialog.show({
					type: BootstrapDialog.TYPE_DANGER,
					title: 'Incomplete',
					message: problem,
					buttons: [{ label: 'Ok', action: function (d) { d.close(); } }]
				});
			} else {
				alert(problem);
			}
			return false;
		}
	});
});
</script>

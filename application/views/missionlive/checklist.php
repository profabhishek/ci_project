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
	<form id="form-process-application" action="<?php echo site_url();?>mission/applicaitonProcess" enctype="multipart/form-data" method="post">
		<input type="hidden" id="applicaiton_number" name="applicaiton_number" value="<?php echo $this->uri->segment(3); ?>"/>
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
		<h5 style="text-align:center">Applicant Name : <?php echo $applicaitonStepOne[0]['fullname'];?></h5>
		<h5 style="text-align:center">Email Id : <?php echo $applicaitonStepOne[0]['email'];?></h5>
		<div><a target="_blank" style="float: right;width:104px;" href="<?php echo site_url(); ?>mission/viewfullApplication/<?php echo $this->uri->segment(3); ?>" class="form-control sbmt1">View</a></div>
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
								<input type="checkbox" name="checklist_<?php echo $check['id'];?>" id="checklist_<?php echo $check['id'];?>" class="tweaked-margin checklist_checkbox"  value="<?php echo $check['id'];?>" /><label><span></span></label> <label class="lbl"><?php echo count($arrrayCounter).'. '.$check['item']; ?><span class="notee">Note: (Application may be rejected or requested for re-submmision by the student) if this point is not checked</span></label>
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
		 	<div class="name-sec col-xs-12 col-sm-6 col-md-9 pdleft">					
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
			 </div>
			 <br/> <br/>
			 <div class="name-sec col-xs-12 col-sm-6 col-md-9 pdleft">
			 
			 	<div class="form-group">
					<label for="comment" style="float: left;">whether Applicant has availed ICCR scholarship earlier. <input checked="true" type="radio" id="mission_cheklist_avail" value="1" name="mission_cheklist_avail"/>&nbsp;&nbsp;Yes&nbsp;&nbsp;
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
      	 	<!---------<div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
      		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pdleft">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="hold_application('<?php echo $this->uri->segment(3); ?>');" href="javascript:void(0);">Hold</a>
		 	</div>------>
      	</div>
      <!--	<div class="name-sec col-xs-4 col-sm-2 col-md-6 ">
      		<div class="name-sec col-xs-4 col-sm-2 col-md-3 pdleft">				
		 	<a id="step-one-application" name="step-one-application" class="form-control sbmt" onclick="showprocess('reject');" href="javascript:void(0);">Reject</a>
		 	</div>
      	</div>-->
      	</div>
			 <div id="schemes_selection" class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright scholardiv" style="margin-top: 20px; padding-top: 18px; padding-bottom: 18px; background: #5b84a6 none repeat scroll 0 0; padding-left: 12px; border: 1px solid rgb(206, 206, 206); color:#fff;">
		 	<div class="name-sec col-xs-12 col-sm-6 col-md-10 pdleft">					
				<div class="form-group">
					<label for="comment" style="float: left;width:24%;">Select Scholarship Programme: <span class="text-red">*</span></label>
					 <select style="float: left;width:48%;" class="form-control" id="schloarship_name" name="schloarship_name" required="true" onchange="getSchemeType(this.id);">		
						<option value="">Select</option>			
						<?php
						
						$user_data = $this->session->userdata('user_data');
						$missionId = $user_data['user_country'];
						$mis = $this->common_model->getMissionInfo($missionId);
						
						$miss = $this->common_model->getMissionInfos($this->ids);
						//$this->
						$schemesList = $this->common_model->getAllSchemesSlotsOfMission($this->ids);
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
										
										$schemsArray[$list['scheme_id']] = array('name'=>$list['scheme_name'],'code'=>$code);
									}
									
								}
							}
							
						}
						foreach($schemsArray as $key=>$vals)
						{						
							
							echo '<option value="'.$key.'">'.$vals['name'].'</option>';
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
					<label id="lbl_scheme_type" style="float:left;width:228px;margin-left:15px;margin-top: 7px;"></label>
				</div>				
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
						 <label for="comment" ">Place: <span class="text-red">*</span></label> <input style="float: left;width:70%;" type="text" class="form-control" placeholder="Place" id="mission_place" name="mission_place" />
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
</section>		
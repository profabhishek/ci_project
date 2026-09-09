<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:4px !important;float: left;}
.upload_link{border-right: 1px solid #cecece;margin-right: 8px;padding-right: 12px;}
.alert
{	
	margin: 12px auto 8px;    
    width: 85.5%;
}
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
	</div>
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
	<div  class="container" style="min-height:380px;padding:0px;">	
	<?php 
	
	$docsArray = array();
	if(count($applicaitonDocuments) > 0)
	{
		foreach($applicaitonDocuments as $docs)
		{
			/*if(!array_key_exists($docs['doc_type'],$docsArray))
			{
				$docsArray[$docs['doc_type']] = array();
			}
			$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
			$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];*/
			if(!array_key_exists($docs['doc_type'],$docsArray))
			{
				$docsArray[$docs['doc_type']] = array();
				$docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
				$docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
			}
		}
	}		
	?>
	<div class="tab-content">
		
	  <div id="step3" class="tab-pane fade in active">	 
	  <h5 class="text-center">Please Upload All Documents Listed Below <br/><span style="color:red;">Note: (All document should be in PDF/Image format) <br/> All file names should be in english language like (physicalfiltness.pdf..etc.) not in other language like:-> غفران_الحلبي_كشف.pdf.
	  <br/>
	  </span></h5>
	  <form id="form-two-application" action="<?php echo site_url();?>applicant?appno=<?php echo $_GET['appno']; ?>" method="post" enctype="multipart/form-data">   
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
								<td>Permanent Unique ID <span style="color:red;font-size:11px;">(Document size  must be less than 2 MB)</span><span class="text-red">*</span></td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['id']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a href="#" data-toggle="modal" class="upload_link" data-target="#idProofDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['id']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								  <a href="#" data-toggle="modal" class="upload_link" data-target="#idProofDiv">Upload</a>
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
								   <a href="#"  data-toggle="modal" class="upload_link" data-target="#passportDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['passport']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#passportDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['passport']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['passport']['type']]['time']);	
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
								$programs = $this->config->item('programme');
								
								$program = $programs[$applicaitonStepOne[0]['programme']];
								switch($program)
								{
									case "UG":									
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
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
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Upload</a>
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
							
									break;
									case "PG":	
									case "Dance":
									case "Music":
									case "Yoga":
									case "CetificateCourse":
									if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
									{								
									?>																																								<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['school_leaving']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['school_leaving']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Upload</a>
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
									if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0)
									{								
									?>																																								<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['ug']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['ug']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['ug']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Upload</a>
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
									break;
									case "M.Phil":
									if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
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
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Upload</a>
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
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0)
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
								   <a href="#"  data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['ug']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Upload</a>
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
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['pg_leaving_country'] != "" && $applicaitonStepTwo[0]['pg_leaving_country'] > 0)
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
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#postGraduateDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['pg']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#postGraduateDiv">Upload</a>
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
									break;
									case "Ph.D":
									case "Ph.D Ayurveda":
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
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
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#schoolLivingDiv">Upload</a>
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
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0)
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
								   <a href="#"  data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['ug']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#underGraduateDiv">Upload</a>
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
							if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['pg_leaving_country'] != "" && $applicaitonStepTwo[0]['pg_leaving_country'] > 0)
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
								   <a href="#"  data-toggle="modal" class="upload_link" data-target="#postGraduateDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['pg']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#postGraduateDiv">Upload</a>
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
							
							<tr>
								<td><?php echo $counter; $counter++;?></td>
								<td><?php echo $doctypes['phd']['title'];?><span class="text-red">*</span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['phd']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#phdDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['phd']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#phdDiv">Upload</a>
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
							
							
							<tr>
							<td><?php echo $counter;$counter++;?></td>
							<td><?php echo $doctypes['phdReseachPaper']['title'];?><span class="text-red"></span></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['phdReseachPaper']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#phdResearchDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['phdReseachPaper']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#phdResearchDiv">Upload</a>
								  <?php	
								  }
								  ?>
								   
								</td>
								<td>
								  <?php
								  if(array_key_exists($doctypes['phdReseachPaper']['type'],$docsArray))
								  {
								   echo date('d-m-y h:i:s a',$docsArray[$doctypes['phdReseachPaper']['type']]['time']);	
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
									break;
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
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#addressProofDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['indian_address']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#addressProofDiv">Upload</a>
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
								  <a href="#"  data-toggle="modal" class="upload_link" data-target="#licenceDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['dl']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i> </a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#licenceDiv">Upload</a>
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
								<td><?php echo $doctypes['physical']['title'];?><span class="text-red">*</span> &nbsp;<a href="<?php echo site_url();?>assets/site/docs/Fitness.pdf" target="_blank">Download Format</a></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['physical']['type'],$docsArray))
								  {
								  	$upload++;
								  ?>
								   <a href="#"  data-toggle="modal" class="upload_link" data-target="#physicalFitnessDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['physical']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#physicalFitnessDiv">Upload</a>
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
							<tr>
							<!----<td><?php echo '9';?></td>--->
								<td><?php echo $counter;?></td>
								<td><?php echo $doctypes['tl']['title'];?> &nbsp;<b>(Optional) If you have any translation document please upload. </b></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['tl']['type'],$docsArray))
								  {
								  	//$upload++;
								  ?>
								   <a href="#"  data-toggle="modal" class="upload_link" data-target="#translationDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['tl']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#translationDiv">Upload</a>
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
								 <tr>
								 <td><?php echo '10';?></td>
								<!-----<td><?php echo $counter;?></td>------->
								<td><?php echo $doctypes['otherDoc']['title'];?> &nbsp;<b>(Optional)If you have any other document please upload. </b></td>
								<td>
								<?php
								  if(array_key_exists($doctypes['otherDoc']['type'],$docsArray))
								  {
								  	//$upload++;
								  ?>
								   <a href="#"  data-toggle="modal" class="upload_link" data-target="#otherDocDiv">Re-Upload</a>
								  <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['otherDoc']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red" title="Click to View Document"></i></a>
								  <?php	
								  }
								  else
								  {
								  ?>
								 <a href="#"  data-toggle="modal" class="upload_link" data-target="#otherDocDiv">Upload</a>
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
						</tbody>
					</table>
					<br/>					
				 
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1"><input type="checkbox" id="undertaking" name="undertaking" class="undertake" checked="true"/>I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Scholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.</span>
						
						<br/><br/><span style="color:red;"><b>Note: </b></span><span><b>Kindly review your application before final submission. Details can't be changed after final submit.</b></span>
					</div>
										
				 </div>
				 </div>
				<div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
                <div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
                <?php
                if($upload == ($counter-1))
                {
                	//print_r($applicaitonStepOne);
                	if($applicaitonStepOne[0]['status']=="Pending")
					{
						?>
							<input type="submit" class="form-control sbmt" value="Re-Submit"/>
						<?php	
					}
					else
					{
						?>
							<input type="submit" class="form-control sbmt" value="Final Submit"/>
						<?php	
					}
				}
				else
				{
					if($applicaitonStepOne[0]['status']=="Pending")
					{						
						?>
						<a class="btn btn-block btn-default disabled">Re-Submit</a>						
						<?php
					}
					else
					{
						?>
						<a class="btn btn-block btn-default disabled">Final Submit</a>						
						<?php
					}
				}
                ?>                
                </div> 
                  <div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
				  <a href="<?php echo site_url();?>applicant/applicant_other_info?appno=<?php echo $_GET['appno']; ?>" class="form-control sbmt"><< Previous</a>
				  </div>               
              	</div>
              </div>
              <!-- /.box-body -->
		</form>
	  </div>	   
	</div>
	</div>
</section>
<div id="schoolLivingDiv" class="modal fade" role="dialog">
  	<div id="schoolLiving" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
  		</div>
  </div>
  <div id="underGraduateDiv" class="modal fade" role="dialog">
  	<div id="underGraduate" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  		</div>
  </div>
  <div id="postGraduateDiv" class="modal fade" role="dialog">
  	<div id="postGraduate" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  		</div>
  </div>
  <div id="mphilDiv" class="modal fade" role="dialog">
  	<div id="mphil" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  		</div>
  </div>
  <div id="phdDiv" class="modal fade" role="dialog">
  	<div id="phd" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  		</div>
  </div>
  <div id="panCardDiv" class="modal fade" role="dialog">
  	<div id="panCard" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  		</div>
  </div>
  <div id="idProofDiv" class="modal fade" role="dialog">
  	<div id="idProof" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  		</div>
  </div>
   <div id="addressProofDiv" class="modal fade" role="dialog">
  	<div id="addressProof" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  		</div>
  </div>
  <div id="physicalFitnessDiv" class="modal fade" role="dialog">
  	<div id="physicalFitness" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  		</div>
  </div>
  <div id="passportDiv" class="modal fade" role="dialog">
  	<div id="passport" class="modal-dialog popup dropzone">
  		<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  	</div>
  </div>
  <div id="licenceDiv" class="modal fade" role="dialog">
  	<div id="licenceUpload" class="modal-dialog popup dropzone">
  		<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  	</div>
  </div>
   <div id="translationDiv" class="modal fade" role="dialog">
  	<div id="translationUpload" class="modal-dialog popup dropzone">
  		<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  	</div>
  </div>
    <div id="phdResearchDiv" class="modal fade" role="dialog">
  	<div id="phdResearch" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file HereRearch</span></div>
  		</div>
  </div>
  
   <div id="otherDocDiv" class="modal fade" role="dialog">
  	<div id="otherDoc" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Hereother</span></div>
  		</div>
  </div>
	
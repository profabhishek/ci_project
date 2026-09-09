<?php 
function getMode($id)
{
	$mode = array('1'=>'Cash','2'=>'Cheque','3'=>'NEFT','4'=>'RTGS','5'=>'Other');
	return $mode[$id];
}
//echo "<pre>";print_r($applicaitonOldStepOne);
if(!empty($_POST)){
	
	$fy = $_POST['fin_year'];
	$rg = $_POST['region'];
	$appId = $applicaitonOldStepOne[0]['application_id'];
	$regionName = $this->common_model->getRegionById($rg);
	$rgname = $regionName[0]["name"];
	$sc = $_POST['schemes'];
	$schemeName = $this->common_model->getSchemebyId($sc);
	$scname = $schemeName[0]["scheme_name"];
	
}
?>
<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:148px;margin:0 auto;text-align:center;}
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
.filter1,.filter2,.filter3
{
	border-bottom: 1px solid #cecece;
    border-top: 1px solid #cecece;
    margin-bottom: 36px;   
    padding-bottom: 15px;
    padding-top: 10px;
}
.filter label{padding-right:0;padding-top:10px;width:180px;}
.filter1 label{padding-right:0;padding-top:10px;width:180px;}
.filter2 label{padding-right:0;padding-top:10px;width:180px;}
.filter3 label{padding-right:0;padding-top:10px;width:180px;}
.customdate{width:116px;}
input,select,label{font-size:14px !important;}
.tab-content input[type="text"], select {
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
	#frm_details_ngo {
    float: right;
    position: absolute !important;
    right: 0;
    top: 11px !important;
}
#imgDivprf{
	 height: 150px;
    margin-top: 15px;
    position: absolute;
    right: 40px;
    top: 30px;
    width: 150px;
    z-index: 11111;
}
.blue-heading h3
{
	margin-top: 13px !important;
	font-weight: bold;
    
}
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Expenditure Statement of Applicant </h3>
		
		<h4 class="text-center caps">Financial Year : <?php echo $this->uri->segment(4); if(!empty($_POST)){echo $fy;}?></h4>	
		
		<h4 class="text-center caps"><?php echo strtoupper($regionName[0]["name"]); ?> </h4>	
	</div>
	<!-----Vipin Bisht------>
				<form method = "post" id="form-filter" class="form-horizontal" action="<?php echo base_url();?>headquarter/expenditureReportofStudentRegionWise" enctype="multipart/form-data">
				 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
 <input id="application_id" name="application_id" value="<?php echo $this->uri->segment(3); if(empty($this->uri->segment(3))){echo $appId;} ?>" type="hidden"/>				 
			<div class="filters col-md-12 form-group">
				
			</div>
			<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Financial Year</label>
					<div class="col-md-6 pdright pdleft">
					<select id="fin_year" name="fin_year" class="selectpicker form-control" required="true" >
						     
						<option value="">Select</option>
								  <?php
								  $counter =0;
								  foreach($ofy as $fyear)
								  {
									echo '<option value="'.$fyear.'">'.$fyear.'</option>';
									 $counter++;
								  }
								  ?>
							</select>
					</div>
				</div>
				<!----<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">RO</label>
					<div class="col-md-6 pdright pdleft">
						<select id="region" name="region" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						  <?php
						  $nationalities = $this->common_model->getRegion();
						  foreach($nationalities as $na)
						  {
						  	echo '<option value="'.$na['id'].'">'.$na['name'].'</option>';
						  }
						  ?>
						</select>
					</div>
				</div>---->
				
				<div class="col-sm-4">
                    <input type="submit" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:50px;">

                 </div>
			
				<!-----<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Schemes</label>
					<div class="col-md-6 pdright pdleft">
						<select id="schemes" name="schemes" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						  <?php
						  $schems = $this->common_model->getAllSchemes();
						  foreach($schems as $na)
						  {
						  	if(count($na) > 0)
						  	{					
								echo '<option value="'.$na['id'].'">'.$na['scheme_name'].'</option>';
							}
						  }
						  ?>
						</select>
					</div>---->
					
				</div>
			
			
			
			<hr style="float: left;width:98%;"/>
	
		<div class="container">
	<div class="col-md-4 pull-right">
   
  </div>
</div>

</form>
<!-----Vipin Bisht----->
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="blue-heading col-md-12 " style="margin-bottom:0;">
			 <h3>Expenditure Statement of Applicant: <?php echo $this->uri->segment(3); ?> for FY - <?php echo $this->uri->segment(4); if(!empty($_POST)){echo $fy;}?></h3>
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadAllExpenditureReport/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); if(empty($_POST['application_id'])){echo $applicaitonOldStepOne[0]['application_no'];}?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	</div>
	<div class="tab-content">		
	  <div id="home" class="tab-pane fade in active">	
	    <div class="box-body detailpagepdf" style="position:relative;top:25px;">
	    
	    	<div class="col-xs-3 prfl pull-right" id="imgDivprf" name="imgDivprf">
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
	  			 	<table id="tbl_report1" class="table table-striped table-bordered" style="width:100%">
	  			 		<tbody>
	  			 			<tr>
	  			 				<td width="200px">Application No.</td>
	  			 				<td ><?php echo $this->uri->segment(3); if(empty($this->uri->segment(3))){echo $applicaitonOldStepOne[0]['application_id'];}?></?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px">Name</td>
	  			 				<td><?php echo $applicaitonOldStepOne[0]['name']; ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px">Country</td>
	  			 				<td> <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
									  if($country['id'] == $applicaitonOldStepOne[0]['country'])
									  {
										  echo $country['country_name'];
									  }									  
								  }
								  ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px">Level of Programme</td>
	  			 				<td><?php
								  $programme = $this->common_model->getAllProgramme();
								  foreach($programme as $prog)
								  {
								  		if($prog['id'] != 5 && $prog['id'] != 6 && $prog['id'] != 7)
								  		{
											if($prog['id'] == $applicaitonOldStepOne[0]['programme'])
											  {
												echo $prog['name'];
											  }											  
										} 
								  }
								  ?>								 
							</td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px">Course</td>
	  			 				<td>  <?php
								  $courses = $this->common_model->getAllCourses();
								  foreach($courses as $course)
								  {
									  if($course['id'] == $applicaitonOldStepOne[0]['course'])
									  {
										echo $course['title'];
									  }
								  }
								  ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px">Course Duration</td>
	  			 				<td>  <?php
									echo $applicaitonOldStepOne[0]['duration_to'].' - '.$applicaitonOldStepOne[0]['duration_from'];
								  ?></td>
	  			 			</tr>
	  			 			<tr class="trr">
	  			 				<td>University/Institute</td>
	  			 				<td> <?php
								
				 				$data = $this->common_model->getconfirmationData($this->uri->segment(3));
						 $uni = $this->common_model->getUniversityById($applicaitonOldStepOne[0]['universty_choice']);echo $uni[0]['name'];
								
						    ?>	</td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px" style="background:#fff;">Scheme</td>
	  			 				<td> <?php
								  $code = "";
								  $schemes = $this->common_model->getAllSchemes();
								  foreach($schemes as $scheme)
								  {								  		
								  		if(!empty($applicaitonOldStepOne))
					      		  		{
											if($applicaitonOldStepOne[0]['scheme'] == $scheme['id'])
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
	  			 	<table id="tbl_report" class="table table-striped table-bordered" style="width:100%;">
	  			 	<thead>
	  			 		<th>Bank Details</th>
	  			 	</thead>
	  			 	<tbody>
	  			 		<tr>
	  			 			<td>
	  			 				<?php
	  			 				if(count($bankDetails)>0)
	  			 				{
									echo "Bank Name : ".$bankDetails[0]['bankname'];
									echo '<br/>';
									echo "Account Number : ".$bankDetails[0]['account_no'];
								}
								else
								{
									echo "Bank Detial Not Updated Yet!";
								}
	  			 				?>	  			 				
	  			 			</td>
	  			 		</tr>
	  			 	</tbody>
	  			 	</table>
	  			 	<hr>
	  			 	<table id="tbl_report" class="table table-striped table-bordered" style="width:100%;">
	  			 	<thead>
	  			 		<th>Residential Permit Details</th>
	  			 	</thead>
	  			 	<tbody>
	  			 		<tr>
	  			 			<td>
	  			 				<?php	  			 				
	  			 				if(count($permitDetails)>0)
	  			 				{
									echo "Permit Number : ".$permitDetails[0]['permit_no'];
									echo '<br/>';
									echo "Duration : ".$permitDetails[0]['permit_from'].' - '.$permitDetails[0]['permit_to'];
								}
								else
								{
									echo "Residential Permit Detial Not Updated Yet!";
								}
	  			 				?>	  			 				
	  			 			</td>
	  			 		</tr>
	  			 	</tbody>
	  			 	</table>
	  			 	<hr/>
	     			<table id="tbl_report" class="table table-striped table-bordered" style="width:100%;">
						 		
						 		<tbody>
						 			<tr>
						 			<td >Payment to Student</td>
						 				
						 			</tr>
						 			<tr>
						 				<td style="width:100%;">
						 			<table  class="table table-striped table-bordered studentTable" style="width:100%;">
						 				<thead>
						 					<th> Categories</th>
							 		<th> Quarter 1st</th>
							 		<th> Quarter 2nd</th>
							 		<th> Quarter 3rd</th>	
							 		<th> Quarter 4th</th>
							 		<th> Total</th>
						 				</thead>
						 				<tbody>
						 					<tr>
						 				<?php $fulltotal = 0; $advstipendTotal=0;$stipendTotal=0;$hraTotal = 0;$acaTotal=0;$stTotal=0;$mrTotal = 0;$thsTotal = 0;$q1total=0;$q2total=0;$q3total=0;$q4total=0;?>
						 				<td>Advance Stipend</td>
						 				<?php
						 				//print_r($advstipendDetails);
						 					if(count($advstipendDetails)>0)
						 					{						 						
												foreach($advstipendDetails as $stpnd)
							 					{
							 						
							 						echo (($stpnd['First_Quarter'] !=NULL) && ($stpnd['First_Quarter'] !="")) ? "<td>".$stpnd['First_Quarter']."</td>" : "<td>0</td>";
													echo (($stpnd['Second_Quarter'] !=NULL) && ($stpnd['Second_Quarter'] !="")) ? "<td>".$stpnd['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($stpnd['Third_Quarter'] !=NULL && $stpnd['Third_Quarter'] !="")) ? "<td>".$stpnd['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($stpnd['Fourth_Quarter'] !=NULL && $stpnd['Fourth_Quarter'] !="")) ? "<td>".$stpnd['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$advstipendTotal = $stpnd['First_Quarter'] + $stpnd['Second_Quarter'] + $stpnd['Third_Quarter'] + $stpnd['Fourth_Quarter'];
													$fulltotal = $advstipendTotal;
													echo "<td>".$advstipendTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 					<tr>
						 				<?php $fulltotal = 0; ?>
						 				<td>Stipend</td>
						 				<?php
						 				
						 					if(count($stipendDetails)>0)
						 					{
						 						$stipendTotal = 0;
												foreach($stipendDetails as $stpnd)
							 					{
							 						
							 						echo (($stpnd['First_Quarter'] !=NULL) && ($stpnd['First_Quarter'] !="")) ? "<td>".$stpnd['First_Quarter']."</td>" : "<td>0</td>";
													echo (($stpnd['Second_Quarter'] !=NULL) && ($stpnd['Second_Quarter'] !="")) ? "<td>".$stpnd['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($stpnd['Third_Quarter'] !=NULL && $stpnd['Third_Quarter'] !="")) ? "<td>".$stpnd['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($stpnd['Fourth_Quarter'] !=NULL && $stpnd['Fourth_Quarter'] !="")) ? "<td>".$stpnd['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$stipendTotal = $stpnd['First_Quarter'] + $stpnd['Second_Quarter'] + $stpnd['Third_Quarter'] + $stpnd['Fourth_Quarter'];
													$fulltotal = $stipendTotal;
													echo "<td>".$stipendTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
							 																															<tr>
						 				<td>HRA</td>
						 				<?php
						 					if(count($hraDetails)>0)
						 					{
						 						
												foreach($hraDetails as $hrad)
							 					{
							 						
							 						echo (($hrad['First_Quarter'] !=NULL) && ($hrad['First_Quarter'] !="")) ? "<td>".$hrad['First_Quarter']."</td>" : "<td>0</td>";
													echo (($hrad['Second_Quarter'] !=NULL) && ($hrad['Second_Quarter'] !="")) ? "<td>".$hrad['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($hrad['Third_Quarter'] !=NULL && $hrad['Third_Quarter'] !="")) ? "<td>".$hrad['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($hrad['Fourth_Quarter'] !=NULL && $hrad['Fourth_Quarter'] !="")) ? "<td>".$hrad['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$hraTotal = $hrad['First_Quarter'] + $hrad['Second_Quarter'] + $hrad['Third_Quarter'] + $hrad['Fourth_Quarter'];
													$fulltotal = $fulltotal + $hraTotal;
													echo "<td>".$hraTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
							 				<tr>
						 				<td>Annual Contingent Allowance</td>
						 				<?php
						 				
						 					if(count($acaDetails)>0)
						 					{
						 						$acaTotal = 0;
												foreach($acaDetails as $acad)
							 					{
							 						
							 						echo (($acad['First_Quarter'] !=NULL) && ($acad['First_Quarter'] !="")) ? "<td>".$acad['First_Quarter']."</td>" : "<td>0</td>";
													echo (($acad['Second_Quarter'] !=NULL) && ($acad['Second_Quarter'] !="")) ? "<td>".$acad['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($acad['Third_Quarter'] !=NULL && $acad['Third_Quarter'] !="")) ? "<td>".$acad['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($acad['Fourth_Quarter'] !=NULL && $acad['Fourth_Quarter'] !="")) ? "<td>".$acad['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$acaTotal = $acad['First_Quarter'] + $acad['Second_Quarter'] + $acad['Third_Quarter'] + $acad['Fourth_Quarter'];
													$fulltotal = $fulltotal + $acaTotal;
													echo "<td>".$acaTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>																											<tr>
						 				<td>Study Tour</td>
						 				<?php
						 					if(count($studyTourDetails)>0)
						 					{
						 						
												foreach($studyTourDetails as $st)
							 					{
							 						
							 						echo (($st['First_Quarter'] !=NULL) && ($st['First_Quarter'] !="")) ? "<td>".$st['First_Quarter']."</td>" : "<td>0</td>";
													echo (($st['Second_Quarter'] !=NULL) && ($st['Second_Quarter'] !="")) ? "<td>".$st['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($st['Third_Quarter'] !=NULL && $st['Third_Quarter'] !="")) ? "<td>".$st['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($st['Fourth_Quarter'] !=NULL && $st['Fourth_Quarter'] !="")) ? "<td>".$st['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$stTotal = $st['First_Quarter'] + $st['Second_Quarter'] + $st['Third_Quarter'] + $st['Fourth_Quarter'];
													$fulltotal = $fulltotal + $stTotal;
													echo "<td>".$stTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
	<tr>
						 				<td>Medical Reimbursment</td>
						 				<?php
						 					if(count($MRDetails)>0)
						 					{
						 						
												foreach($MRDetails as $mr)
							 					{
							 						
							 						echo (($mr['First_Quarter'] !=NULL) && ($mr['First_Quarter'] !="")) ? "<td>".$mr['First_Quarter']."</td>" : "<td>0</td>";
													echo (($mr['Second_Quarter'] !=NULL) && ($mr['Second_Quarter'] !="")) ? "<td>".$mr['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($mr['Third_Quarter'] !=NULL && $mr['Third_Quarter'] !="")) ? "<td>".$mr['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($mr['Fourth_Quarter'] !=NULL && $mr['Fourth_Quarter'] !="")) ? "<td>".$mr['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$mrTotal = $mr['First_Quarter'] + $mr['Second_Quarter'] + $mr['Third_Quarter'] + $mr['Fourth_Quarter'];
													$fulltotal = $fulltotal + $mrTotal;
													echo "<td>".$mrTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 			<tr>
						 				<td>Thesis Charges</td>
						 				<?php
						 					if(count($ThesisDetails)>0)
						 					{
						 						
												foreach($ThesisDetails as $ths)
							 					{
							 						
							 						echo (($ths['First_Quarter'] !=NULL) && ($ths['First_Quarter'] !="")) ? "<td>".$ths['First_Quarter']."</td>" : "<td>0</td>";
													echo (($ths['Second_Quarter'] !=NULL) && ($ths['Second_Quarter'] !="")) ? "<td>".$ths['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($ths['Third_Quarter'] !=NULL && $ths['Third_Quarter'] !="")) ? "<td>".$ths['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($ths['Fourth_Quarter'] !=NULL && $ths['Fourth_Quarter'] !="")) ? "<td>".$ths['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$thsTotal = $ths['First_Quarter'] + $ths['Second_Quarter'] + $ths['Third_Quarter'] + $ths['Fourth_Quarter'];
													$fulltotal = $fulltotal + $thsTotal;
													echo "<td>".$thsTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 			
						 			<tr>						 				
						 				<!--<td style="background:#F0F8E3;"><b>Total</b></td>-->
						 				<!--<td style="background:#F0F8E3;"><?php echo $advstipendTotal;?></td>
						 				<td style="background:#F0F8E3;"><?php echo $stipendTotal;?></td>
						 				<td style="background:#F0F8E3;"><?php echo $acaTotal;?></td>
						 				<td style="background:#F0F8E3;"><?php echo $stTotal;?></td>-->
						 				<!--<td style="background:#F0F8E3;"><?php echo $fulltotal;?></td>-->
						 				
						 			</tr>
						 				</tbody>
						 			</table>
						 			</td>
						 			</tr>
						 			<tr>
						 				<td><b>Payment to University/Institute</b></td>
						 				
						 			</tr>
						 			<tr>
						 				<td>
						 				<table class="table table-striped table-bordered uniTable" style="width:100%;">
						 				<thead>
						 					<th> Categories</th>
							 		<th> Quarter 1st</th>
							 		<th> Quarter 2nd</th>
							 		<th> Quarter 3rd</th>	
							 		<th> Quarter 4th</th>
							 		<th> Total</th>
						 				</thead>
						 				<tbody>
						 				
						 			<tr>
						 				<td>Tution Fee/Other Compulsary Fees </td>
						 				<?php
						 				$fulltotal_uni =0;
						 					if(count($tfDetails)>0)
						 					{
						 						$tftotal = 0;
												foreach($tfDetails as $tf)
							 					{
							 						
							 						echo (($tf['First_Quarter'] !=NULL) && ($tf['First_Quarter'] !="")) ? "<td>".$tf['First_Quarter']."</td>" : "<td>0</td>";
													echo (($tf['Second_Quarter'] !=NULL) && ($tf['Second_Quarter'] !="")) ? "<td>".$tf['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($tf['Third_Quarter'] !=NULL && $tf['Third_Quarter'] !="")) ? "<td>".$tf['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($tf['Fourth_Quarter'] !=NULL && $tf['Fourth_Quarter'] !="")) ? "<td>".$tf['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$tftotal = $tf['First_Quarter'] + $tf['Second_Quarter'] + $tf['Third_Quarter'] + $tf['Fourth_Quarter'];
													$fulltotal_uni = $fulltotal_uni + $tftotal;
													echo "<td>".$tftotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 				<!--<tr>
						 				<td>Other Compulsary Fees</td>
						 				<?php
						 					if(count($ocfDetails)>0)
						 					{
						 						$ocftotal = 0;
												foreach($ocfDetails as $ocf)
							 					{
							 						
							 						echo (($ocf['First_Quarter'] !=NULL) && ($ocf['First_Quarter'] !="")) ? "<td>".$ocf['First_Quarter']."</td>" : "<td>0</td>";
													echo (($ocf['Second_Quarter'] !=NULL) && ($ocf['Second_Quarter'] !="")) ? "<td>".$ocf['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($ocf['Third_Quarter'] !=NULL && $ocf['Third_Quarter'] !="")) ? "<td>".$ocf['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($ocf['Fourth_Quarter'] !=NULL && $ocf['Fourth_Quarter'] !="")) ? "<td>".$ocf['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$ocftotal = $ocf['First_Quarter'] + $ocf['Second_Quarter'] + $ocf['Third_Quarter'] + $ocf['Fourth_Quarter'];
													$fulltotal_uni = $fulltotal_uni + $ocftotal;
													echo "<td>".$ocftotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>-->
						 			<!--<tr>
						 				<td>Miscellaneous Released</td>
						 				<?php
						 					if(count($miscUniDetails)>0)
						 					{
						 						$misuniTotal = 0;
												foreach($miscUniDetails as $mscuni)
							 					{
							 						
							 						echo (($mscuni['First_Quarter'] !=NULL) && ($mscuni['First_Quarter'] !="")) ? "<td>".$mscuni['First_Quarter']."</td>" : "<td>0</td>";
													echo (($mscuni['Second_Quarter'] !=NULL) && ($mscuni['Second_Quarter'] !="")) ? "<td>".$mscuni['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($mscuni['Third_Quarter'] !=NULL && $mscuni['Third_Quarter'] !="")) ? "<td>".$mscuni['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($mscuni['Fourth_Quarter'] !=NULL && $mscuni['Fourth_Quarter'] !="")) ? "<td>".$mscuni['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$misuniTotal = $mscuni['First_Quarter'] + $mscuni['Second_Quarter'] + $mscuni['Third_Quarter'] + $mscuni['Fourth_Quarter'];
													$fulltotal_uni = $fulltotal_uni + $misuniTotal;
													echo "<td>".$misuniTotal."</td>";
												}	
											}
											else
											{
												echo "<td colspan='4'>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>	-->
									<tr>
						 				<td>Hostel Charges</td>
						 				<?php
						 					if(count($hostelDetails)>0)
						 					{
						 						$hostTotal = 0;
												foreach($hostelDetails as $host)
							 					{
							 						
							 						echo (($host['First_Quarter'] !=NULL) && ($host['First_Quarter'] !="")) ? "<td>".$host['First_Quarter']."</td>" : "<td>0</td>";
													echo (($host['Second_Quarter'] !=NULL) && ($host['Second_Quarter'] !="")) ? "<td>".$host['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($host['Third_Quarter'] !=NULL && $host['Third_Quarter'] !="")) ? "<td>".$host['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($host['Fourth_Quarter'] !=NULL && $host['Fourth_Quarter'] !="")) ? "<td>".$host['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$hostTotal = $host['First_Quarter'] + $host['Second_Quarter'] + $host['Third_Quarter'] + $host['Fourth_Quarter'];
													$fulltotal_uni = $fulltotal_uni + $hostTotal;
													echo "<td>".$hostTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 			<tr>
						 				<td>English Bridge Course</td>
						 				<?php
						 					if(count($getEnglishBridgeByFY)>0)
						 					{
						 						$ebctotal = 0;
												foreach($getEnglishBridgeByFY as $ebc)
							 					{
							 						
							 						echo (($ebc['First_Quarter'] !=NULL) && ($ebc['First_Quarter'] !="")) ? "<td>".$ebc['First_Quarter']."</td>" : "<td>0</td>";
													echo (($ebc['Second_Quarter'] !=NULL) && ($ebc['Second_Quarter'] !="")) ? "<td>".$ebc['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($ebc['Third_Quarter'] !=NULL && $ebc['Third_Quarter'] !="")) ? "<td>".$ebc['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($ebc['Fourth_Quarter'] !=NULL && $ebc['Fourth_Quarter'] !="")) ? "<td>".$ebc['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$ebctotal = $ebc['First_Quarter'] + $ebc['Second_Quarter'] + $ebc['Third_Quarter'] + $ebc['Fourth_Quarter'];
													$fulltotal_uni = $fulltotal_uni + $ebctotal;
													echo "<td>".$ebctotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 			
						 			
						 				</tbody>
						 			</table>
						 				</td>
						 			</tr>
						 			
<tr>
						 				<td><b>Travel Payment</b></td>
						 				
						 			</tr>
						 			<tr>
						 				<td>
						 					<table class=" table table-striped table-bordered travelTable" style="width:100%;">
						 				<thead>
						 					<th> Categories</th>
							 		<th> Quarter 1st</th>
							 		<th> Quarter 2nd</th>
							 		<th> Quarter 3rd</th>	
							 		<th> Quarter 4th</th>
							 		<th> Total</th>
						 				</thead>
						 				<tbody>
						 					<tr>
						 				<?php $full_welfare = 0; ?>
						 				<td>Travel</td>
						 				<?php
						 				
						 					if(count($TravelDetails)>0)
						 					{
						 						$travelTotal = 0;
												foreach($TravelDetails as $trvl)
							 					{
							 						
							 						echo (($trvl['First_Quarter'] !=NULL) && ($trvl['First_Quarter'] !="")) ? "<td>".$trvl['First_Quarter']."</td>" : "<td>0</td>";
													echo (($trvl['Second_Quarter'] !=NULL) && ($trvl['Second_Quarter'] !="")) ? "<td>".$trvl['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($trvl['Third_Quarter'] !=NULL && $trvl['Third_Quarter'] !="")) ? "<td>".$trvl['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($trvl['Fourth_Quarter'] !=NULL && $trvl['Fourth_Quarter'] !="")) ? "<td>".$trvl['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$travelTotal = $trvl['First_Quarter'] + $trvl['Second_Quarter'] + $trvl['Third_Quarter'] + $trvl['Fourth_Quarter'];
													$fulltotal_travel = $travelTotal;
													echo "<td>".$travelTotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
							 																															
						 			
						 				</tbody>
						 			</table>
						 				</td>
						 			</tr>
<tr>
						 				<td><b>Expenditure on Student Welfare Activities</b></td>
						 				
						 			</tr>
						 			<tr>
						 				<td>
						 					<table class="table table-striped table-bordered welfare" style="width:100%;">
						 				<thead>
						 					<th> Categories</th>
							 		<th> Quarter 1st</th>
							 		<th> Quarter 2nd</th>
							 		<th> Quarter 3rd</th>	
							 		<th> Quarter 4th</th>
							 		<th> Total</th>
						 				</thead>
						 				<tbody>
						 					<tr>
						 				<?php $fulltotal_wel = 0; ?>
						 				<td>Orientation Programme</td>
						 				<?php
						 				
						 					if(count($oreientDetails)>0)
						 					{
						 						$ortotal = 0;
												foreach($oreientDetails as $or)
							 					{
							 						
							 						echo (($or['First_Quarter'] !=NULL) && ($or['First_Quarter'] !="")) ? "<td>".$or['First_Quarter']."</td>" : "<td>0</td>";
													echo (($or['Second_Quarter'] !=NULL) && ($or['Second_Quarter'] !="")) ? "<td>".$or['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($or['Third_Quarter'] !=NULL && $or['Third_Quarter'] !="")) ? "<td>".$or['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($or['Fourth_Quarter'] !=NULL && $or['Fourth_Quarter'] !="")) ? "<td>".$or['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$ortotal = $or['First_Quarter'] + $or['Second_Quarter'] + $or['Third_Quarter'] + $or['Fourth_Quarter'];
													$fulltotal_wel = $fulltotal_wel + $ortotal;
													echo "<td>".$ortotal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
							 				<tr>
						 				<?php $fulltotal = 0; ?>
						 				<td>Camps</td>
						 				<?php
						 				
						 					if(count($getCampsByFY)>0)
						 					{
						 						$cmptotla = 0;
												foreach($getCampsByFY as $cmps)
							 					{
							 						
							 						echo (($cmps['First_Quarter'] !=NULL) && ($cmps['First_Quarter'] !="")) ? "<td>".$cmps['First_Quarter']."</td>" : "<td>0</td>";
													echo (($cmps['Second_Quarter'] !=NULL) && ($cmps['Second_Quarter'] !="")) ? "<td>".$cmps['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($cmps['Third_Quarter'] !=NULL && $cmps['Third_Quarter'] !="")) ? "<td>".$cmps['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($cmps['Fourth_Quarter'] !=NULL && $cmps['Fourth_Quarter'] !="")) ? "<td>".$cmps['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$cmptotla = $cmps['First_Quarter'] + $cmps['Second_Quarter'] + $cmps['Third_Quarter'] + $cmps['Fourth_Quarter'];
													$fulltotal_wel = $fulltotal_wel + $cmptotla;
													echo "<td>".$cmptotla."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>																											<tr>
						 				
						 				<td>ISA Meeting</td>
						 				<?php
						 				
						 					if(count($getISAByFY)>0)
						 					{
						 						$istotoal = 0;
												foreach($getISAByFY as $isa)
							 					{
							 						
							 						echo (($isa['First_Quarter'] !=NULL) && ($isa['First_Quarter'] !="")) ? "<td>".$isa['First_Quarter']."</td>" : "<td>0</td>";
													echo (($isa['Second_Quarter'] !=NULL) && ($isa['Second_Quarter'] !="")) ? "<td>".$isa['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($isa['Third_Quarter'] !=NULL && $isa['Third_Quarter'] !="")) ? "<td>".$isa['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($isa['Fourth_Quarter'] !=NULL && $isa['Fourth_Quarter'] !="")) ? "<td>".$isa['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$istotoal = $isa['First_Quarter'] + $isa['Second_Quarter'] + $isa['Third_Quarter'] + $isa['Fourth_Quarter'];
													$fulltotal_wel = $fulltotal_wel + $istotoal;
													echo "<td>".$istotoal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 			<tr>
						 				<?php $fulltotal = 0; ?>
						 				<td>Sumptuary Allowance</td>
						 				<?php
						 				
						 					if(count($getSumptuaryByFY)>0)
						 					{
						 						$sumptotoal = 0;
												foreach($getSumptuaryByFY as $sump)
							 					{
							 						
							 						echo (($sump['First_Quarter'] !=NULL) && ($sump['First_Quarter'] !="")) ? "<td>".$sump['First_Quarter']."</td>" : "<td>0</td>";
													echo (($sump['Second_Quarter'] !=NULL) && ($sump['Second_Quarter'] !="")) ? "<td>".$sump['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($sump['Third_Quarter'] !=NULL && $sump['Third_Quarter'] !="")) ? "<td>".$sump['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($sump['Fourth_Quarter'] !=NULL && $sump['Fourth_Quarter'] !="")) ? "<td>".$sump['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$sumptotoal = $sump['First_Quarter'] + $sump['Second_Quarter'] + $sump['Third_Quarter'] + $sump['Fourth_Quarter'];
													$fulltotal_wel = $fulltotal_wel + $sumptotoal;
													echo "<td>".$sumptotoal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 			<tr>
						 				<?php $fulltotal = 0; ?>
						 				<td>Emergency Fund</td>
						 				<?php
						 				
						 					if(count($getEmergencyFundByFY)>0)
						 					{
						 						$eftotoal = 0;
												foreach($getEmergencyFundByFY as $ef)
							 					{
							 						
							 						echo (($ef['First_Quarter'] !=NULL) && ($ef['First_Quarter'] !="")) ? "<td>".$ef['First_Quarter']."</td>" : "<td>0</td>";
													echo (($ef['Second_Quarter'] !=NULL) && ($ef['Second_Quarter'] !="")) ? "<td>".$ef['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($ef['Third_Quarter'] !=NULL && $ef['Third_Quarter'] !="")) ? "<td>".$ef['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($ef['Fourth_Quarter'] !=NULL && $ef['Fourth_Quarter'] !="")) ? "<td>".$ef['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$eftotoal = $ef['First_Quarter'] + $ef['Second_Quarter'] + $ef['Third_Quarter'] + $ef['Fourth_Quarter'];
													$fulltotal_wel = $fulltotal_wel + $eftotoal;
													echo "<td>".$eftotoal."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 			
						 			<tr>
						 				
						 				<td>International Student Day</td>
						 				<?php
						 				
						 					if(count($getStudentDayByFY)>0)
						 					{
						 						$stud = 0;
												foreach($getStudentDayByFY as $std)
							 					{
							 						
							 						echo (($std['First_Quarter'] !=NULL) && ($std['First_Quarter'] !="")) ? "<td>".$std['First_Quarter']."</td>" : "<td>0</td>";
													echo (($std['Second_Quarter'] !=NULL) && ($std['Second_Quarter'] !="")) ? "<td>".$std['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($std['Third_Quarter'] !=NULL && $std['Third_Quarter'] !="")) ? "<td>".$std['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($std['Fourth_Quarter'] !=NULL && $std['Fourth_Quarter'] !="")) ? "<td>".$std['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$stud = $std['First_Quarter'] + $std['Second_Quarter'] + $std['Third_Quarter'] + $std['Fourth_Quarter'];
													$fulltotal_wel = $fulltotal_wel + $stud;
													echo "<td>".$stud."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>
						 			<tr>
						 				
						 				<td>Day of National Importance of India</td>
						 				<?php
						 				
						 					if(count($getStudentDayByFY)>0)
						 					{
						 						$stud = 0;
												foreach($getStudentDayByFY as $std)
							 					{
							 						
							 						echo (($std['First_Quarter'] !=NULL) && ($std['First_Quarter'] !="")) ? "<td>".$std['First_Quarter']."</td>" : "<td>0</td>";
													echo (($std['Second_Quarter'] !=NULL) && ($std['Second_Quarter'] !="")) ? "<td>".$std['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($std['Third_Quarter'] !=NULL && $std['Third_Quarter'] !="")) ? "<td>".$std['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($std['Fourth_Quarter'] !=NULL && $std['Fourth_Quarter'] !="")) ? "<td>".$std['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$stud = $std['First_Quarter'] + $std['Second_Quarter'] + $std['Third_Quarter'] + $std['Fourth_Quarter'];
													$fulltotal_wel = $fulltotal_wel + $stud;
													echo "<td>".$stud."</td>";
												}	
											}
											else
											{
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
												echo "<td>0</td>";
											}
						 				?>
						 			</tr>						 			
						 				</tbody>
						 			</table>
						 				</td>
						 			</tr>
						 		</tbody>
						 	</table>

				<br/>
				
			</div>
              <!-- /.box-body -->
         <div class="box-body">
        	<table id="tbl_report" class="table table-striped table-bordered" style="width:100%;">
		 	<thead>
		 		<th>All Document</th>
		 	</thead>
		 	<tbody>
		 		<tr>
		 			<td>
		 				<a href="<?php echo site_url();?>headquarter/download_zip/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4); ?>">Download Zip</a>
<!-----<a href="<?php echo site_url();?>headquarter/download_zip/<?php echo $this->uri->segment(3);if(empty($_POST['application_id'])){echo $applicaitonOldStepOne[0]['application_no'];}?>/<?php echo $this->uri->segment(4); if(!empty($_POST)){echo $fy;} ?>">Download Zip</a>----->	  			 										
		 			</td>
		 		</tr>
		 	</tbody>
		 	</table> 	
        </div> 
	  </div>	   
	</div>
	</div>
</section>
<script type="text/javascript">
$(document).ready(function(){
	var tdsize = 6;	
	var q1=0;var q2=0; var q3=0; var q4=0; var total =0;
	var uq1=0;var uq2=0; var uq3=0; var uq4=0; var utotal =0;
	var tq1=0;var tq2=0; var tq3=0; var tq4=0; var ttotal =0;
	var wq1=0;var wq2=0; var wq3=0; var wq4=0; var wtotal =0;
	
	$('.studentTable tbody tr').each(function(){
		for(var i=1; i<=tdsize; i++)
		{
			
			switch(i)
			{
				case 1:				
				q1 = Number(q1) + Number($(this).find('td:eq('+i+')').text());	
				break;
				case 2:
				q2 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 3:
				q3 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 4:
				q4 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 5:
				total += Number($(this).find('td:eq('+i+')').text());	
				break;
			}
			
		}
	});
	$('.uniTable tbody tr').each(function(){
		for(var i=1; i<=tdsize; i++)
		{
			switch(i)
			{
				case 1:
				uq1 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 2:
				uq2 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 3:
				uq3 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 4:
				uq4 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 5:
				utotal += Number($(this).find('td:eq('+i+')').text());	
				break;
			}
			
		}
	});
	$('.travelTable tbody tr').each(function(){
		for(var i=1; i<=tdsize; i++)
		{
			switch(i)
			{
				case 1:
				tq1 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 2:
				tq2 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 3:
				tq3 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 4:
				tq4 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 5:
				ttotal += Number($(this).find('td:eq('+i+')').text());	
				break;
			}
			
		}
	});
	$('.welfare tbody tr').each(function(){
		for(var i=1; i<=tdsize; i++)
		{
			switch(i)
			{
				case 1:
				wq1 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 2:
				wq2 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 3:
				wq3 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 4:
				wq4 += Number($(this).find('td:eq('+i+')').text());	
				break;
				case 5:
				wtotal += Number($(this).find('td:eq('+i+')').text());	
				break;
			}
			
		}
	});
	
	var trr = "<tr>";
	trr += "<td><b>Grand Total</b></td>";
	trr += "<td>"+q1+"</td>";
	trr += "<td>"+q2+"</td>";
	trr += "<td>"+q3+"</td>";
	trr += "<td>"+q4+"</td>";
	trr += "<td>"+total+"</td>";
	trr +="</tr>";	
	var trru = "<tr>";
	trru += "<td><b>Grand Total</b></td>";
	trru += "<td>"+uq1+"</td>";
	trru += "<td>"+uq2+"</td>";
	trru += "<td>"+uq3+"</td>";
	trru += "<td>"+uq4+"</td>";
	trru += "<td>"+utotal+"</td>";
	trru +="</tr>";
	var trrt = "<tr>";
	trrt += "<td><b>Grand Total</b></td>";
	trrt += "<td>"+tq1+"</td>";
	trrt += "<td>"+tq2+"</td>";
	trrt += "<td>"+tq3+"</td>";
	trrt += "<td>"+tq4+"</td>";
	trrt += "<td>"+ttotal+"</td>";
	trrt +="</tr>";
	var trrw = "<tr>";
	trrw += "<td><b>Grand Total</b></td>";
	trrw += "<td>"+wq1+"</td>";
	trrw += "<td>"+wq2+"</td>";
	trrw += "<td>"+wq3+"</td>";
	trrw += "<td>"+wq4+"</td>";
	trrw += "<td>"+wtotal+"</td>";
	trrw +="</tr>";
	$('.studentTable tbody').append(trr);
	$('.uniTable tbody').append(trru);
	$('.travelTable tbody').append(trrt);	
	$('.welfare tbody').append(trrw);	
	
	$('.table').each(function(){
  		$(this).find('tr:last').css({"background":"#CCDE8F","font-weight":"bold"});
	});
	$('.table tbody tr').each(function(){
	  $(this).find('td:last').css({"background":"#CCDE8F","font-weight":"bold"});
	});
	
});
</script>
	
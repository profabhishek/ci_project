<?php 
function getMode($id)
{
	$mode = array('1'=>'Cash','2'=>'Cheque','3'=>'NEFT','4'=>'RTGS','5'=>'Other');
	return $mode[$id];
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
.blue-heading h3
{
	margin-top: 13px !important;
	font-weight: bold;
    
}
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Expenditure Statement of Regional Office </h3>	
		<h4 class="text-center caps">Financial Year : <?php echo $this->uri->segment(3); ?></h4>	
		<h4 class="text-center caps"><?php echo strtoupper($regionName[0]["name"]); ?> </h4>	
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="blue-heading col-md-12 ">
			 <h3>Expenditure Statement of RO <?php echo $regionName[0]["name"]; ?> for FY - <?php echo $this->uri->segment(3); ?></h3>
			 <form method="post" action="<?php echo base_url();?>regional/downloadAllExpenditureReport/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		</div>
	<div class="tab-content">		
	  <div id="home" class="tab-pane fade in active">	   
	   
	    <div class="box-body detailpagepdf">
	    
	    <table id="tbl_report" class="table table-striped table-bordered rotable" style="width:100%;">
						 		
						 			<thead>
						 				<th colspan="6" align="center" style="text-align:center;background:#F0F8E3;"> Expenditure Statement of RO <?php echo $regionName[0]["name"]; ?> for FY - <?php echo $this->uri->segment(3); ?></th>
							 		
						 			</thead>
						 			<thead>
						 			<th> Category</th>
							 		<th> Quarter First</th>
							 		<th> Quarter Second</th>
							 		<th> Quarter Third</th>
							 		<th> Quarter Fourth</th>
							 		<th> Total</th>	
						 			</thead>
						 		<tbody>	
						 				<?php		
						 				$fulltotal = 0;	
						 				echo '<script type="text/javascript">var totalFund ='.json_encode($totalFund).'</script>';				 						
						 				echo '<script type="text/javascript">var openingBalance ='.json_encode($openingBalance).'</script>';			 				
						 				?>
						 									 									 			
						 			
						 		</tbody>
						 	</table>
						 	<br/>
						 	
	     			<table id="tbl_report" class="table table-striped table-bordered" style="width:100%;">
						 		<thead>
						 			<!--<tr>
						 				<th colspan="6" style="background:#F0F8E3;"> Expenditure Statement of RO <?php echo $regionName[0]["name"]; ?> for FY - <?php echo $this->uri->segment(3); ?></th>
							 		
						 			</tr>-->
						 								 		
						 		</thead>
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
						 						$hraTotal = 0;
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
						 						$stipendTotal = 0;
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
						 						$mrTotal = 0;
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
						 						$thsTotal = 0;
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
						 		<!--	<tr>
						 				<td>Miscellaneous</td>
						 				<?php
						 					if(count($MiscDetails)>0)
						 					{
						 						$misctotal = 0;
												foreach($MiscDetails as $misc)
							 					{
							 						
							 						echo (($misc['First_Quarter'] !=NULL) && ($misc['First_Quarter'] !="")) ? "<td>".$misc['First_Quarter']."</td>" : "<td>0</td>";
													echo (($misc['Second_Quarter'] !=NULL) && ($misc['Second_Quarter'] !="")) ? "<td>".$misc['Second_Quarter']."</td>" : "<td>0</td>";
													echo (($misc['Third_Quarter'] !=NULL && $misc['Third_Quarter'] !="")) ? "<td>".$misc['Third_Quarter']."</td>" : "<td>0</td>";
													echo (($misc['Fourth_Quarter'] !=NULL && $misc['Fourth_Quarter'] !="")) ? "<td>".$misc['Fourth_Quarter']."</td>" : "<td>0</td>";
													
													$misctotal = $misc['First_Quarter'] + $misc['Second_Quarter'] + $misc['Third_Quarter'] + $misc['Fourth_Quarter'];
													$fulltotal = $fulltotal + $misctotal;
													echo "<td>".$misctotal."</td>";
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
						 				<td>Tution Fee </td>
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
						 				<tr>
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
						 			</tr>
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
	
	var roQ1=0;var roQ2=0; var roQ3=0; var roQ4=0; var rototal =0;
	
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
	roQ1 = roQ1 + q1;
	roQ2 = roQ2 + q2;
	roQ3 = roQ3 + q3;
	roQ4 = roQ4 + q4;	
	rototal = rototal + total;
	
	roQ1 = roQ1 + uq1;
	roQ2 = roQ2 + uq2;
	roQ3 = roQ3 + uq3;
	roQ4 = roQ4 + uq4;
	rototal = rototal + utotal;
	
	roQ1 = roQ1 + tq1;
	roQ2 = roQ2 + tq2;
	roQ3 = roQ3 + tq3;
	roQ4 = roQ4 + tq4;
	rototal = rototal + ttotal;
	
	roQ1 = roQ1 + wq1;
	roQ2 = roQ2 + wq2;
	roQ3 = roQ3 + wq3;
	roQ4 = roQ4 + wq4;
	rototal = rototal + wtotal;
	
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
	
	if(openingBalance.length > 0)
	{
		balanceSheet[0].firstQuarter.openingBalance = openingBalance[0].amount;	
		fundbalance(roQ1,roQ2,roQ3,roQ4);
		var quarter = getCurrentQuarter();
		if(quarter == 2)
		{
			balanceSheet[0].secondQuarter.openingBalance = balanceSheet[0].firstQuarter.fundBalance;
			fundbalance(roQ1,roQ2,roQ3,roQ4);
		}
		if(quarter == 3)
		{
			balanceSheet[0].thirdQuarter.openingBalance = balanceSheet[0].secondQuarter.fundBalance;
			fundbalance(roQ1,roQ2,roQ3,roQ4);
		}
		if(quarter == 4)
		{
			balanceSheet[0].fourthQuarter.openingBalance = balanceSheet[0].thirdQuarter.fundBalance;
			fundbalance(roQ1,roQ2,roQ3,roQ4);
		}
		generateTable();
	}
	else
	{
		generateBlankTable();
	}
	
	$('.studentTable tbody').append(trr);
	$('.uniTable tbody').append(trru);
	$('.travelTable tbody').append(trrt);	
	$('.welfare tbody').append(trrw);
	//$('.rotable').append(trrro);	
	//$('.rotable').append(trrrb);
		
	$('.table').each(function(){
  		$(this).find('tr:last').css({"background":"#CCDE8F","font-weight":"bold","border-color":"#fff"});
	});
	$('.table tbody tr').each(function(){
	  $(this).find('td:last').css({"background":"#CCDE8F","font-weight":"bold","border-color":"#fff"});
	});
	
});
function generateBlankTable()
{
	var trr4 = "<tr>";	
	trr4 += "<td colspan='6' align='center' style='background-color:#fff !important;color:#000;text-shadow:4px #000;'>Opening Balance of This Financial Year Not Updated Yet by RO.</td>";
	trr4 +="</tr>";	
	$('.rotable > tbody').append(trr4);	
}
function generateTable()
{
	var total = Number(balanceSheet[0].firstQuarter.openingBalance) + Number(balanceSheet[0].secondQuarter.openingBalance) + Number(balanceSheet[0].thirdQuarter.openingBalance) + Number(balanceSheet[0].fourthQuarter.openingBalance);
	var trr = "<tr>";
	trr += "<td><b>Opening Balance</b></td>";
	trr += "<td>"+ balanceSheet[0].firstQuarter.openingBalance +"</td>";
	trr += "<td>"+ balanceSheet[0].secondQuarter.openingBalance +"</td>";
	trr += "<td>"+ balanceSheet[0].thirdQuarter.openingBalance +"</td>";
	trr += "<td>"+ balanceSheet[0].fourthQuarter.openingBalance +"</td>";
	trr += "<td>"+ total +"</td>";	
	trr +="</tr>";	
	$('.rotable > tbody').append(trr);	
	var trr1 = "<tr>";
	var total = Number(balanceSheet[0].firstQuarter.fundReceived) + Number(balanceSheet[0].secondQuarter.fundReceived) + Number(balanceSheet[0].thirdQuarter.fundReceived) + Number(balanceSheet[0].fourthQuarter.fundReceived);
	trr1 += "<td><b>Fund Received</b></td>";
	trr1 += "<td>"+ balanceSheet[0].firstQuarter.fundReceived +"</td>";
	trr1 += "<td>"+ balanceSheet[0].secondQuarter.fundReceived +"</td>";
	trr1 += "<td>"+ balanceSheet[0].thirdQuarter.fundReceived +"</td>";
	trr1 += "<td>"+ balanceSheet[0].fourthQuarter.fundReceived +"</td>";
	trr1 += "<td>"+ total +"</td>";	
	trr1 +="</tr>";
	$('.rotable > tbody').append(trr1);		
	var trr2 = "<tr>";
	var total2= Number(balanceSheet[0].firstQuarter.totalFund) + Number(balanceSheet[0].secondQuarter.totalFund) + Number(balanceSheet[0].thirdQuarter.totalFund) + Number(balanceSheet[0].fourthQuarter.totalFund);
	trr2 += "<td><b> Total Fund</b></td>";
	trr2 += "<td>"+ balanceSheet[0].firstQuarter.totalFund +"</td>";
	trr2 += "<td>"+ balanceSheet[0].secondQuarter.totalFund +"</td>";
	trr2 += "<td>"+ balanceSheet[0].thirdQuarter.totalFund +"</td>";
	trr2 += "<td>"+ balanceSheet[0].fourthQuarter.totalFund +"</td>";
	trr2 += "<td>"+ total2 +"</td>";	
	
	trr2 +="</tr>";
	$('.rotable > tbody').append(trr2);	
	var trr3 = "<tr>";
	var total3 = Number(balanceSheet[0].firstQuarter.fundUtilize) + Number(balanceSheet[0].secondQuarter.fundUtilize) + Number(balanceSheet[0].thirdQuarter.fundUtilize) + Number(balanceSheet[0].fourthQuarter.fundUtilize);
	trr3 += "<td><b> Fund Utilize</b></td>";
	trr3 += "<td>"+ balanceSheet[0].firstQuarter.fundUtilize +"</td>";
	trr3 += "<td>"+ balanceSheet[0].secondQuarter.fundUtilize +"</td>";
	trr3 += "<td>"+ balanceSheet[0].thirdQuarter.fundUtilize +"</td>";
	trr3 += "<td>"+ balanceSheet[0].fourthQuarter.fundUtilize +"</td>";
	trr3 += "<td>"+ total3 +"</td>";
	
	trr3 +="</tr>";
	$('.rotable > tbody').append(trr3);	
	var trr4 = "<tr>";
	var total4 =Number(balanceSheet[0].firstQuarter.fundBalance) + Number(balanceSheet[0].secondQuarter.fundBalance) + Number(balanceSheet[0].thirdQuarter.fundBalance) + Number(balanceSheet[0].fourthQuarter.fundBalance);
	trr4 += "<td><b> Fund Balance</b></td>";
	trr4 += "<td>"+ balanceSheet[0].firstQuarter.fundBalance +"</td>";
	trr4 += "<td>"+ balanceSheet[0].secondQuarter.fundBalance +"</td>";
	trr4 += "<td>"+ balanceSheet[0].thirdQuarter.fundBalance +"</td>";
	trr4 += "<td>"+ balanceSheet[0].fourthQuarter.fundBalance +"</td>";
	trr4 += "<td>"+ total4 +"</td>";	
	
	trr4 +="</tr>";	
	$('.rotable > tbody').append(trr4);	
}
function fundbalance(roQ1,roQ2,roQ3,roQ4)
{
	
	balanceSheet[0].firstQuarter.fundReceived = totalFund[0].First_Quarter;
	balanceSheet[0].secondQuarter.fundReceived = totalFund[0].Second_Quareter;
	balanceSheet[0].thirdQuarter.fundReceived = totalFund[0].Third_Quareter;
	balanceSheet[0].fourthQuarter.fundReceived = totalFund[0].Fourth_Quareter;	
	
	balanceSheet[0].firstQuarter.totalFund = Number(balanceSheet[0].firstQuarter.openingBalance) + Number(balanceSheet[0].firstQuarter.fundReceived);
	balanceSheet[0].secondQuarter.totalFund = Number(balanceSheet[0].secondQuarter.openingBalance) + Number(balanceSheet[0].secondQuarter.fundReceived);
	balanceSheet[0].thirdQuarter.totalFund = Number(balanceSheet[0].thirdQuarter.openingBalance) + Number(balanceSheet[0].thirdQuarter.fundReceived);
	balanceSheet[0].fourthQuarter.totalFund = Number(balanceSheet[0].fourthQuarter.openingBalance) + Number(balanceSheet[0].fourthQuarter.fundReceived);
	
	balanceSheet[0].firstQuarter.fundUtilize = roQ1;
	balanceSheet[0].secondQuarter.fundUtilize = roQ2;
	balanceSheet[0].thirdQuarter.fundUtilize = roQ3;
	balanceSheet[0].fourthQuarter.fundUtilize = roQ4;	
	
	balanceSheet[0].firstQuarter.fundBalance = Number(balanceSheet[0].firstQuarter.totalFund) - Number(balanceSheet[0].firstQuarter.fundUtilize);
	balanceSheet[0].secondQuarter.fundBalance = Number(balanceSheet[0].secondQuarter.totalFund) - Number(balanceSheet[0].secondQuarter.fundUtilize);
	balanceSheet[0].thirdQuarter.fundBalance = Number(balanceSheet[0].thirdQuarter.totalFund) - Number(balanceSheet[0].thirdQuarter.fundUtilize);
	balanceSheet[0].fourthQuarter.fundBalance = Number(balanceSheet[0].fourthQuarter.totalFund) - Number(balanceSheet[0].fourthQuarter.fundUtilize);
}
</script>
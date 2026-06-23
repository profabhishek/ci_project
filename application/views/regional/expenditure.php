<?php 
function getMode($id)
{
	$mode = array('1'=>'Cash','2'=>'Cheque','3'=>'NEFT','4'=>'RTGS','5'=>'Other');
	return $mode[$id];
}
?>
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
    float: right !important;
    font-weight: bold;
    padding: 6px !important;
    text-align: center !important;
    width: 129px;
}
.spn_note {
    color: red;
    float: right;
}
</style>

<script type="text/javascript">
var codes = [];
var stipendRate = [];
stipendRate['1'] = 5500;
stipendRate['2'] = 6000;
stipendRate['3'] = 7000;
stipendRate['4'] = 7000;
stipendRate['5'] = 7500;

function getCode(id)
{
	var cid = $('#' + id).val();
	$('#code').val(codes[cid]['code']);
}
function getStipend(course)
{	
	var cid = $('#' + course).val();
	$('#stipend_rate').val(stipendRate[cid]);
}
	$(function(){
		$('.adv_stipend_details').hide();
		$('.nday_details').hide();
		$('.uni_misc_details').hide();
		$('.hos_details').hide();
		$('.visa_details').hide();
		$('.bank_details').hide();
		$('.rp_details').hide();
		$('.stipend_details').hide();
		$('.aca_details').hide();
		$('.hra_details').hide();
		$('.tf_details').hide();
		$('.ocf_details').hide();
		$('.st_details').hide();
		$('.mr_details').hide();
		$('.travel_details').hide();	
		$('.this_details').hide();	
		$('.misc_details').hide();	
		$('.exindia_details').hide();
		$('.sextnd_details').hide();	
		$('.sdiscnt_details').hide();	
		$('.srevivd_details').hide();	
		$('.signt').hide();
		$('.exp_doc').hide();		
		$('.filter1').hide();
		$('.filter2').hide();
		$('.filter3').hide();
		$('.orient_details').hide();
		$('.camps_details').hide();
		$('.isa_details').hide();
		$('.sumal_details').hide();
		$('.emg_fund_details').hide();
		$('.sday_details').hide();
		$('.eng_brg_details').hide();
	});	
	function showFilters(id)
	{
		
		var FilterType = $('#' +  id).val();
		$('.panel-default').hide();
		$('.signt').hide();
		$('.exp_doc').hide();
		$('.filter1').hide();
		$('.filter2').hide();
		$('.filter3').hide();
		switch(FilterType)
		{
			case "1":
			$('.filter1').show();			
			break;
			case "2":
			$('.filter2').show();	
			break;
			case "3":
			$('.travel_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "4":
			$('.rp_details').show();			
			$('.signt').show();
			break;
			case "5":
			$('.filter3').show();
			
			break;
			case "6":
			$('.bank_details').show();
			$('.signt').show();
			break;
			case "7":
			$('.exindia_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;		
		}
	}
	function studentFilters(id)
	{
		var FilterType = $('#' +  id).val();
		$('.panel-default').hide();
		$('.signt').hide();
		$('.exp_doc').hide();
		$('.filter1').show();
		switch(FilterType)
		{
			case "1":
			$('.adv_stipend_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "2":
			$('.stipend_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "3":
			$('.hra_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;	
			case "4":
			$('.aca_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "5":
			$('.st_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "6":
			$('.mr_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;	
			case "7":
			$('.this_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "8":
			$('.misc_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "9":
			$('.hos_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;			
		}
	}
	function welfareFilters(id)
	{
		var FilterType = $('#' +  id).val();
		$('.panel-default').hide();
		$('.signt').hide();
		$('.exp_doc').hide();
		$('.filter3').show();
		switch(FilterType)
		{
			case "1":
			$('.orient_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "2":
			$('.camps_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "3":
			$('.isa_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;	
			case "4":
			$('.sumal_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "5":
			$('.emg_fund_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "6":
			$('.sday_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;	
			case "7":
			$('.nday_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
		}
	}
	function universityFilters(id)
	{
		var FilterType = $('#' +  id).val();
		$('.panel-default').hide();
		$('.signt').hide();
		$('.filter1').hide();
		switch(FilterType)
		{
			case "1":
			$('.tf_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "2":
			$('.ocf_details').show();
			$('.signt').show();
			$('.exp_doc').show();
			break;
			case "3":	
			$('.uni_misc_details').show();	
			$('.signt').show();	
			$('.exp_doc').show();
			break;	
			case "4":	
			$('.hos_details').show();
			$('.signt').show();	
			$('.exp_doc').show();
			break;
			case "5":	
			$('.eng_brg_details').show();
			$('.signt').show();	
			$('.exp_doc').show();
			break;					
		}
	}
</script>
<?php
$ano = $this->uri->segment(3);
$data = $this->common_model->getConfirmationofApplicationIds($ano);
						
$travelpl = $this->common_model->getTravelPlan($appno);
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
		<h3 class="text-center caps">Expenditure Statement of Student</h3>	
		<h4 class="text-center caps">APPLICATION NUMBER : <?php if(!empty($appno)){ echo $appno; } ?></h4>	
	</div>
	<div class="headsec container">Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal </div>
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active">	   
	    <form id="form-expenditure" action="<?php echo site_url();?>regional/studentExpenditure/<?php echo $appno;?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	    <div class="box-body">
	    	  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<input type="hidden" name="uid" id="uid" value="<?php echo $applicaitonStepOne[0]['uid'] ?>">
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Name</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" placeholder="Name" value="<?php echo $applicaitonStepOne[0]['fullname']; ?>" readonly = "true">
					    </div>
					</div>
              		<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Country</label>
					    <div class="col-sm-8">
					    	<?php
					    	 if(!empty($applicaitonStepOne))								 
							  {
							  	  $countr = $this->common_model->getCountryById($applicaitonStepOne[0]['country']);
								  ?>
								  <input type="text" readonly="true" class="form-control" value="<?php echo $countr[0]['country_name'];?>" />
								  <?php
							  }
							?>	
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">University/Institute</label>
					    <div class="col-sm-8">
					    
					      <input type="text" class="form-control" readonly="true" placeholder="University/Institute" value="<?php $univ = $this->common_model->getUniversityById($data[0]->regional_university); echo $univ[0]["name"]; ?>">
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Level of Programme</label>
					    <div class="col-sm-8">
					    	<?php
					    	$programme = $this->common_model->getAllProgramme();
							  foreach($programme as $prog)
							  {
							  	if($applicaitonStepOne[0]['programme'] == $prog['id'])	
							  	{
									?>
							      <input type="text" readonly="true" class="form-control" value="<?php echo $prog['name'];?>" />
							      <?php
								} 
							  }
					    	?>		      
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Course</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" readonly="true" placeholder="Course" value="<?php $crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']); echo $crs[0]["title"]; ?>">
					    </div>
					</div> 
					<div class="form-group col-xs-9 ">
					    <label for="inputEmail3" class="col-sm-2">Course Duration</label>
					    <div class="col-sm-3">
					    <?php
					    $duration = $this->common_model->getCourseDurationFromAcademicDetails($appno);
					      if(!empty($duration))
					      {					      	
						  	?>
					      <input type="text" readonly="true" class="form-control" value="<?php echo $duration[0]['course_duration_from'];?>" />
					      <?php
						  }
					     ?>
					    
					    </div>
					   <label class="col-sm-1 pdleft pdright" style="width: 20px;padding-top: 5px">To</label>
					    <div class="col-sm-3">
					    <?php
					      if(!empty($duration))
					      {					      	
						  	?>
					      <input type="text" readonly="true" class="form-control" value="<?php echo $duration[0]['course_duration_to'];?>" />
					      <?php
						  }
					     ?>
					     
					    </div>
					       <label id="lblyr">
					    	<?php
					    	if(!empty($duration))
					    	{
					    		$ctnr=0;
					    		for($i=$duration[0]['course_duration_from']; $i<$duration[0]['course_duration_to'];$i++)
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
					      if(!empty($duration))
					      {		
					      	$citiess = $this->config->item('grade_cities');			      	
						  	?>
					      <input type="text" readonly="true" class="form-control" value="<?php echo $citiess[$duration[0]['city_id']];?>" />
					      <?php
						  }						 
					     ?>	
					    </div>
					       <?php					   
					      if(!empty($duration))
					      {		
					      	if($duration[0]['city_id'] == 7)
					      	{
					      		?>
							  	<div class="col-sm-3 fade in ctyother">
	 						  		<input type="text" class="form-control" placeholder="Other City" value="<?php echo $duration[0]['city_other'];?>" readonly="true"/>
						    	</div>
							  	<?php
					      	}
					      }
						?>
					</div>	
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Scheme</label>
					    <div class="col-sm-8">
					    <?php
					    $code = "";
					    
					    ?>
					    	<input type="text" class="form-control" placeholder="Scheme" value="<?php $sch = $this->common_model->getSchemeById($schemeId); echo $sch[0]['scheme_name'];?>" readonly="true">
					      <?php
					      $code = $sch[0]['code'];
					      ?>
					    </div>
					</div> 
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Code</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" readonly="true" id="code" name="code" placeholder="Code" value="<?php if(!empty($code)) echo $code; else echo "A-0000"; ?>">
					    </div>
					</div> 
					<div class="form-group col-xs-9">					
					    <label for="inputEmail3" class="col-sm-2">Date of Arrival</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" readonly="true" placeholder="Arrival Date" value="<?php if(!empty($travelpl)) echo $travelpl[0]['travel_arrival_date']; ?>">
					    </div>
					</div> 
					<div class="form-group col-xs-9">					
					    <label for="inputEmail3" class="col-sm-2">Date of Joining</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" readonly="true" placeholder="Arrival Date" value="<?php if(!empty($joining_date)) echo $joining_date; else echo "Not Updated Yet"; ?>">
					    </div>
					</div> 
					<div class="form-group col-xs-9">					
					    <label for="inputEmail3" class="col-sm-2">Date of Completion</label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" readonly="true" placeholder="Arrival Date" value="<?php if(!empty($completion_date)) echo $completion_date; else echo "Not Updated Yet";  ?>">
					    </div>
					</div> 
					<div class="form-group col-xs-12 permit">						 
						 	<label for="inputEmail3" class="col-sm-2">VISA (Type)</label>
							     <div class="col-sm-2">
							     	<?php 
							     	$vtype = "";
							     	$prg = $applicaitonStepOne[0]['programme'];
							     	if($prg == 1 || $prg == 2 || $prg == 5 || $prg == 6 || $prg == 7)
							     	{
										$vtype ="Student";
									}
									elseif($prg == 3 || $prg == 4)
							     	{
										$vtype ="Research";
									}
							     	?>
							    	<input type="text" class="form-control" id="visa_type" name="visa_type" placeholder="Visa Type" value="<?php echo $vtype;?>" readonly="true">
							   </div>
							   
							 
							   <div class="col-sm-3">	

								<?php if(empty($visadata[0]['visa_from_date']))
								{
									?>
									<input type="text" class="form-control" readonly="true" id="visa_from_date" name="visa_from_date" placeholder="From" value="<?php echo $visadataRO[0]['visa_from_date'];?>"/>
									
									<?php
								}
									else
									{
										?>
										<input type="text" class="form-control" readonly="true" id="visa_from_date" name="visa_from_date" placeholder="From" value="<?php echo $visadata[0]['visa_from_date'];?>"/>
										<?php
										
									}
								?>
							    
								
								
							    </div>
								<div class="col-sm-3">
								<?php 
								if(empty($visadata[0]['visa_to_date']))
								{
									?>
								
								<input type="text" class="form-control" readonly="true" id="visa_to_date" name="visa_to_date" placeholder="To" value="<?php  echo $visadataRO[0]['visa_to_date'];?>"/>
								<?php
								}
								else
									{
										?>
										<input type="text" class="form-control" readonly="true" id="visa_to_date" name="visa_to_date" placeholder="To" value="<?php echo $visadata[0]['visa_to_date'];?>"/>
										<?php
									}
								?>
							    </div>
													 
					</div>
					<!----<div class="form-group col-xs-12 permit">						 
						 	<label for="inputEmail3" class="col-sm-2">VISA (Type)</label>
							     <div class="col-sm-2">
							     	<?php 
							     	$vtype = "";
							     	$prg = $applicaitonStepOne[0]['programme'];
							     	if($prg == 1 || $prg == 2 || $prg == 5 || $prg == 6 || $prg == 7)
							     	{
										$vtype ="Student";
									}
									elseif($prg == 3 || $prg == 4)
							     	{
										$vtype ="Research";
									}
							     	?>
							    	<input type="text" class="form-control" id="visa_type" name="visa_type" placeholder="Visa Type" value="<?php echo $vtype;?>" readonly="true">
							   </div>
							   <div class="col-sm-3">							
							    <input type="text" class="form-control" readonly="true" id="visa_from_date" name="visa_from_date" placeholder="From" value="<?php if(!empty($visadata)) echo $visadata[0]['visa_from_date'];?>"/>
							    </div>
								<div class="col-sm-3">
								<input type="text" class="form-control" readonly="true" id="visa_to_date" name="visa_to_date" placeholder="To" value="<?php if(!empty($visadata)) echo $visadata[0]['visa_to_date'];?>"/>
							    </div>
													 
					</div>--->
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Financial Year</label>
					    <div class="col-sm-8">
					      <select id="fy_year" name="fy_year" class="selectpicker form-control FY_DATEPICKER" required>
					      		<option value=''>Financial Year</option>
							   <?php 
								  
								   foreach($financial as $years)
								   {
								   	echo '<option value="'.$years.'">'.$years.'</option>';
								   }
								  ?>
							</select>
					    </div>
					</div>
				<div class="form-group col-xs-12 filter">
						 <div class="col-sm-5">
					    <label for="inputEmail3" class="col-sm-4 pull-right" >Select Expenditure Type</label>
					    </div>
					     <div class="col-sm-3">
					 		<select class="form-control" id="stipend_programme" name="stipend_programme" onchange="showFilters(this.id);">
						 		<option value="">Filter</option>
						 		<option value="1">Payment to Student</option>
						 		<option value="2">Payment to University/Institute</option>
						 		<option value="3">Travel Payment</option>
					 			<!--<option value="4">Residential Permit Details</option>-->
					 			<option value="5">Student Welfare Activities</option>
					 			<option value="6">Banking Detail of Student</option>
					 			<option value="7">Payment Deductions</option>
							</select>
					    </div> 
					     <div class="col-sm-2 pull-right">
					  <a class="rpt" onclick="showReport('<?php echo $appno; ?>');"  href="#">Generate Report</a>
					    </div>
					</div>
						<ul class="nav nav-tabs tabs-up" id="friends">
					  <li><a href="<?php echo site_url();?>regional/studentAdvanceStipend/<?php echo $appno;?>" data-target="#advance_stipend" class="media_node active span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Three Month Advane Stipend </a></li>
					  <li><a href="<?php echo site_url();?>regional/studentStipend/<?php echo $appno;?>" data-target="#stipend_list" class="media_node span" id="Stipend_tab" data-toggle="tabajax" rel="tooltip"> Stipend</a></li>
					  <li><a href="<?php echo site_url();?>regional/studentHRA/<?php echo $appno;?>" data-target="#hra_list" class="media_node span" id="hra_tab" data-toggle="tabajax" rel="tooltip">HRA</a></li>
					  <li><a href="<?php echo site_url();?>regional/studentHostel/<?php echo $appno;?>" data-target="#hostel_list" class="media_node span" id="hostel_tab" data-toggle="tabajax" rel="tooltip">Hostel</a></li>
					  <li><a href="<?php echo site_url();?>regional/studentACA/<?php echo $appno;?>" data-target="#aca_list" class="media_node span" id="aca_tab" data-toggle="tabajax" rel="tooltip">ACA</a></li>
					  <li><a href="<?php echo site_url();?>regional/studyTour/<?php echo $appno;?>" data-target="#study_list" class="media_node span" id="study_tour_tab" data-toggle="tabajax" rel="tooltip">Study Tour</a></li>
					  
					  <li><a href="<?php echo site_url();?>regional/medicalRebursment/<?php echo $appno;?>" data-target="#medical_reimbursment_list" class="media_node span" id="medical_reimbursment_tab" data-toggle="tabajax" rel="tooltip">Medical Reimbursment</a></li>
					  
					  <li><a href="<?php echo site_url();?>regional/thesis/<?php echo $appno;?>" data-target="#awaiting_request" class="media_node span" id="thesis_tab" data-toggle="tabajax" rel="tooltip">Thesis Charges</a></li>
					  <li><a href="<?php echo site_url();?>regional/miscellaneous/<?php echo $appno;?>" data-target="#medical_misce_list" class="media_node span" id="miscellaneous_tab" data-toggle="tabajax" rel="tooltip">Miscellaneous</a></li>
					  <li><a href="<?php echo site_url();?>regional/tutionFee/<?php echo $appno;?>" data-target="#tution_fee_list" class="media_node span" id="miscellaneous_tab" data-toggle="tabajax" rel="tooltip">Tution Fee</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="advance_stipend">
						
					</div>
					<div class="tab-pane" id="stipend_list">

					 </div>
					 <div class="tab-pane  urlbox span8" id="hra_list">

					 </div>
					  <div class="tab-pane  urlbox span8" id="hostel_list">

					 </div>
					 <div class="tab-pane  urlbox span8" id="aca_list">

					 </div>
					 
					  <div class="tab-pane  urlbox span8" id="study_list">

					 </div>
					 
					 <div class="tab-pane  urlbox span8" id="medical_misce_list">

					 </div>
					 <div class="tab-pane  urlbox span8" id="thesis_tab">

					 </div>
					 <div class="tab-pane  urlbox span8" id="miscellaneous_tab">

					 </div>
					 <div class="tab-pane  urlbox span8" id="tution_fee_list">

					 </div>
					 
				</div>
					<div class="form-group col-xs-12 filter1">
						 <div class="col-sm-5">
					    <label for="inputEmail3" class="col-sm-4 pull-right" >Select Payment Type</label>
					    </div>
					     <div class="col-sm-3">
					 		<select class="form-control" id="student_filter" name="student_filter" onchange="studentFilters(this.id);">
						 		<option value="">Filter</option>
						 		<option value="1">Three Month Advance Stipend</option>
						 		<option value="2">Stipend</option>
						 		<option value="3">HRA</option>
						 		<option value="4">ACA</option>
						 		<option value="5">Study Tour</option>	
						 		<option value="6">Medical Reimbursment</option>						 		
						 		<option value="7">Thesis charges</option>	
						 		<option value="8">Miscellaneous</option>
						 		
							</select>
					    </div> 
					</div>
					<div class="form-group col-xs-12 filter2">
						 <div class="col-sm-5">
					    <label for="inputEmail3" class="col-sm-4 pull-right" >Select Payment Type</label>
					    </div>
					     <div class="col-sm-3">
					 		<select class="form-control" id="uni_filter" name="uni_filter" onchange="universityFilters(this.id);">
						 		<option value="">Filter</option>
						 		<option value="1">TF/OCF</option>						 			
						 		<option value="3">Miscellaneous</option>
						 		<option value="4">Hostel Charges</option>
						 		<option value="5">English Bridge Course</option>	 		
							</select>
					    </div> 
					</div>
							<div class="form-group col-xs-12 filter3">
						<div class="col-sm-5">
					    	<label for="inputEmail3" class="col-sm-4 pull-right" >Select Payment Type</label>
					    </div>
					     <div class="col-sm-3">
					 		<select class="form-control" id="welfare_filter" name="welfare_filter" onchange="welfareFilters(this.id);">
						 		<option value="">Select</option>
						 		<option value="1">Orientation Programme</option>
						 		<option value="2">Camps</option>
						 		<option value="3">ISA Meeting</option>
						 		<option value="4">Sumptuary Allowance</option>
						 		<option value="5">Emergency Fund</option>	
						 		<option value="6">Student Day</option>	
						 		<option value="7">Day of National Importance of India</option>
							</select>
					    </div> 
					</div>
					<div class="rp_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Residential Permit Details</div>
						 <div class="panel-body">
						 		<table class="table table-striped table-bordered">
						 		<thead>
							 		<th> Permit Number</th>
							 		<th> From</th>
							 		<th> To</th>
							 		<th> FRRO Document</th>	
							 		<th> Date</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(isset($getPermitDetails) && count($getPermitDetails)>0)
						 				{
											foreach($getPermitDetails as $permit)
											{
												echo '<tr>';
												echo '<td>'.$permit['permit_no'].'</td>';
												echo '<td>'.$permit['permit_from'].'</td>';
												echo '<td>'.$permit['permit_to'].'</td>';
												echo '<td><a href="'.site_url().'/assets/site/main/expenditure_signature/'.$permit['permit_doc'].'" target="_blank">Download</a></td>';
												echo '<td>'.date('d M Y h:i:s A',$permit['created']).'</td>';
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="4">Permit Not Added Yet</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 							 	
					 		<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Permit Number</label>
							     <div class="col-sm-4">
							    	<input type="text" class="form-control" id="permit_no" name="permit_no" placeholder="Number">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
								 <label for="inputEmail3" class="col-sm-3 control-label">Permit From</label>
							    <div class="col-sm-4">
							   <input type="text" class="form-control datepicker" id="permit_from" name="permit_from" placeholder="From"/>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
								<label for="inputEmail3" class="col-sm-3 control-label">Permit To</label>
								<div class="col-sm-4">
								<input type="text" class="form-control datepicker" id="permit_to" name="permit_to" placeholder="To"/>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
								<label for="inputEmail3" class="col-sm-3 control-label">Upload Permit</label>
								<div class="col-sm-4">
								<input type="file"  readonly="true" id="permit_doc" name="permit_doc" placeholder="To" required = "true"/>
							    </div>
							</div><br/><br/>
						 </div>
					</div>					
					<div class="bank_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Banking Details</div>
						 <div class="panel-body">
						 	<table class="table table-striped table-bordered">
						 		<thead>
							 		<th> Bank Name</th>
							 		<th> Account Number</th>
									<th> IFSC CODE</th>
							 		<th> Bank Document</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(isset($getBankingDetails) && count($getBankingDetails) >0)
						 				{
											foreach($getBankingDetails as $bank)
											{
												echo '<tr>';
												echo '<td>'.$bank['bankname'].'</td>';
												echo '<td>'.$bank['account_no'].'</td>';
												echo '<td>'.$bank['ifsc_code'].'</td>';
												echo '<td><a href="'.site_url().'/assets/site/main/bank_docs/'.$bank['bank_doc'].'" target="_blank">Download</a></td>';
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="3">Bank Details Not Updated Yet!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 	<?php						 	
						 	if(isset($getBankingDetails) && count($getBankingDetails) <= 0)
						 	{
						 	?>
						 	<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Bank Name</label>
							     <div class="col-sm-4">
							      <input type="text" class="form-control"  id="bankname" name="bankname" placeholder="Bank Name">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Account Number</label>
							     <div class="col-sm-4">
							      <input type="text" class="form-control" id="account_no" name="account_no" placeholder="Account No">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">IFSC CODE</label>
							     <div class="col-sm-4">
							      <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
								<label for="inputEmail3" class="col-sm-3 control-label">Upload Bank Document</label>
								<div class="col-sm-4">
								<input type="file"  readonly="true" id="bank_doc" name="bank_doc" placeholder="To" required = "true"/>
							    </div>
							</div><br/><br/>
						 	<?php	
						 	}
						 	?>
						 	
						 </div>
					</div>	
						<!-- new -->
					<div class="orient_details panel panel-default" style="float:left;width:100%;min-height:150px;">
					 <div class="panel-heading">Summary of Orientation Programme in Financial Year <label class="fy"></label> <span class='spn_note'><!---Date Can be Selected Quarter Wise Only-->.</span> </div>
					 <div class="panel-body">						 	
					 	<table class="table table-striped table-bordered">
					 		<thead>
						 		<th> From</th>
						 		<th> To</th>
						 		<th> Mode</th>
						 		<th> Amount</th>
						 		<th> Date</th>
					 		</thead>
					 		<tbody>
					 			<?php 						 			
					 				if(isset($getOrientationDetails) && !empty($getOrientationDetails))
					 				{
										foreach($getOrientationDetails as $stp)
										{
											echo '<tr>';
											echo '<td>'.$stp['op_from_date'].'</td>';
											echo '<td>'.$stp['op_to_date'].'</td>';
											echo '<td>'.getMode($stp['op_mode']).'</td>';
											echo '<td>'.$stp['op_amount'].'</td>';
											echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr><td colspan="5">Orientation Programme Released Yet!</td></tr>';
									}
					 			?>
					 		</tbody>
					 	</table>
					 
					 	<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control  fyDatepicker" id="op_from_date" name="op_from_date" placeholder="From">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control fyDatepicker" id="op_to_date" name="op_to_date" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control" id="op_amount" name="op_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
						     <div class="col-sm-4">
						    <select class="form-control" id="op_pmode" name="op_pmode" onchange="showStipendMode(this.id);">
						 		<option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>
							</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12 fade  op_pmode">
						    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
						     <div class="col-sm-4">
						    <input type="text" class="form-control" id="op_cno" name="op_cno" placeholder="Transaction No/Other">
						    </div>
						</div><br/><br/>
					</div>	 
					</div>
					<div class="camps_details panel panel-default" style="float:left;width:100%;min-height:150px;">
					 <div class="panel-heading">Summary of Camps Released in Financial Year <label class="fy"></label> <span class='spn_note'><!--Date Can be Selected Quarter Wise Only--->.</span></div>
					 <div class="panel-body">						 	
					 	<table class="table table-striped table-bordered">
					 		<thead>
						 		<th> From</th>
						 		<th> To</th>
						 		<th> Mode</th>
						 		<th> Amount</th>
						 		<th> Date</th>
					 		</thead>
					 		<tbody>
					 			<?php 						 			
					 				if(isset($getCampsDetails) && !empty($getCampsDetails))
					 				{
										foreach($getCampsDetails as $stp)
										{
											echo '<tr>';
											echo '<td>'.$stp['camps_from_date'].'</td>';
											echo '<td>'.$stp['camps_to_date'].'</td>';
											echo '<td>'.getMode($stp['camps_mode']).'</td>';
											echo '<td>'.$stp['camps_amount'].'</td>';
											echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr><td colspan="5">Camps Fund Not Released Yet!</td></tr>';
									}
					 			?>
					 		</tbody>
					 	</table>
					 
					 	<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control  fyDatepicker" id="camps_from_date" name="camps_from_date" placeholder="From">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control fyDatepicker" id="camps_to_date" name="camps_to_date" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control" id="camps_amount" name="camps_amount" placeholder="Amount" >
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
						     <div class="col-sm-4">
						    <select class="form-control" id="camps_mode" name="camps_mode" onchange="showStipendMode(this.id);">
						 		<option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>
							</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12 fade  camps_mode">
						    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
						     <div class="col-sm-4">
						    <input type="text" class="form-control" id="camps_cno" name="camps_cno" placeholder="Transaction No/Other">
						    </div>
						</div><br/><br/>
					</div>	 
					</div>
					<div class="isa_details panel panel-default" style="float:left;width:100%;min-height:150px;">
					 <div class="panel-heading">Summary of ISA Meetings Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only----->.</span></div>
					 <div class="panel-body">						 	
					 	<table class="table table-striped table-bordered">
					 		<thead>
						 		<th> From</th>
						 		<th> To</th>
						 		<th> Mode</th>
						 		<th> Amount</th>
						 		<th> Date</th>
					 		</thead>
					 		<tbody>
					 			<?php 						 			
					 				if(isset($getISADetails) && !empty($getISADetails))
					 				{
										foreach($getISADetails as $stp)
										{
											echo '<tr>';
											echo '<td>'.$stp['isa_from_date'].'</td>';
											echo '<td>'.$stp['isa_to_date'].'</td>';
											echo '<td>'.getMode($stp['isa_mode']).'</td>';
											echo '<td>'.$stp['isa_amount'].'</td>';
											echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr><td colspan="5">ISA Meetings Fund Not Released Yet!</td></tr>';
									}
					 			?>
					 		</tbody>
					 	</table>
					 
					 	<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control  fyDatepicker" id="isa_from_date" name="isa_from_date" placeholder="From">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control fyDatepicker" id="isa_to_date" name="isa_to_date" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control" id="isa_amount" name="isa_amount" placeholder="Amount" >
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
						     <div class="col-sm-4">
						    <select class="form-control" id="isa_mode" name="isa_mode" onchange="showStipendMode(this.id);">
						 		<option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>
							</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12 fade  isa_mode">
						    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
						     <div class="col-sm-4">
						    <input type="text" class="form-control" id="isa_cno" name="isa_cno" placeholder="Transaction No/Other">
						    </div>
						</div><br/><br/>
					</div>	 
					</div>
					<div class="sumal_details panel panel-default" style="float:left;width:100%;min-height:150px;">
					 <div class="panel-heading">Summary of Stumptuary Allowance Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only.----></span></div>
					 <div class="panel-body">						 	
					 	<table class="table table-striped table-bordered">
					 		<thead>
						 		<th> From</th>
						 		<th> To</th>
						 		<th> Mode</th>
						 		<th> Amount</th>
						 		<th> Date</th>
					 		</thead>
					 		<tbody>
					 			<?php 						 			
					 				if(isset($getSumptuaryDetails) && !empty($getSumptuaryDetails))
					 				{
										foreach($getSumptuaryDetails as $stp)
										{
											echo '<tr>';
											echo '<td>'.$stp['sump_from_date'].'</td>';
											echo '<td>'.$stp['sump_to_date'].'</td>';
											echo '<td>'.getMode($stp['sump_mode']).'</td>';
											echo '<td>'.$stp['sump_amount'].'</td>';
											echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr><td colspan="5">Sumptuary Not Released Yet!</td></tr>';
									}
					 			?>
					 		</tbody>
					 	</table>
					 
					 	<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control  fyDatepicker" id="sump_from_date" name="sump_from_date" placeholder="From">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control fyDatepicker" id="sump_to_date" name="sump_to_date" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control" id="sump_amount" name="sump_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
						     <div class="col-sm-4">
						    <select class="form-control" id="sump_mode" name="sump_mode" onchange="showStipendMode(this.id);">
						 		<option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>
							</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12 fade  sump_mode">
						    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
						     <div class="col-sm-4">
						    <input type="text" class="form-control" id="sump_cno" name="sump_cno" placeholder="Transaction No/Other">
						    </div>
						</div><br/><br/>
					</div>	 
					</div>
					<div class="emg_fund_details panel panel-default" style="float:left;width:100%;min-height:150px;">
					 <div class="panel-heading">Summary of Emergency Fund Released in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.-----></span></div>
					 <div class="panel-body">						 	
					 	<table class="table table-striped table-bordered">
					 		<thead>
						 		<th> From</th>
						 		<th> To</th>
						 		<th> Mode</th>
						 		<th> Amount</th>
						 		<th> Date</th>
					 		</thead>
					 		<tbody>
					 			<?php 						 			
					 				if(isset($getEmergencyFundDetails) && !empty($getEmergencyFundDetails))
					 				{
										foreach($getEmergencyFundDetails as $stp)
										{
											echo '<tr>';
											echo '<td>'.$stp['ef_from_data'].'</td>';
											echo '<td>'.$stp['ef_to_data'].'</td>';
											echo '<td>'.getMode($stp['stipend_mode']).'</td>';
											echo '<td>'.$stp['ef_amount'].'</td>';
											echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr><td colspan="5">Emergency Fund Not Released Yet!</td></tr>';
									}
					 			?>
					 		</tbody>
					 	</table>
					 
					 	<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control  fyDatepicker" id="ef_from_date" name="ef_from_date" placeholder="From">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control fyDatepicker" id="ef_to_date" name="ef_to_date" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control" id="ef_amount" name="ef_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
						     <div class="col-sm-4">
						    <select class="form-control" id="ef_mode" name="ef_mode" onchange="showStipendMode(this.id);">
						 		<option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>
							</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12 fade  ef_mode">
						    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
						     <div class="col-sm-4">
						    <input type="text" class="form-control" id="ef_cno" name="ef_cno" placeholder="Transaction No/Other">
						    </div>
						</div><br/><br/>
					</div>	 
					</div>
					<div class="sday_details panel panel-default" style="float:left;width:100%;min-height:150px;">
					 <div class="panel-heading">Summary of Student Day Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only.----></span></div>
					 <div class="panel-body">						 	
					 	<table class="table table-striped table-bordered">
					 		<thead>
						 		<th> From</th>
						 		<th> To</th>
						 		<th> Mode</th>
						 		<th> Amount</th>
						 		<th> Date</th>
					 		</thead>
					 		<tbody>
					 			<?php 						 			
					 				if(isset($getStudentDayDetails) && !empty($getStudentDayDetails))
					 				{
										foreach($getStudentDayDetails as $stp)
										{
											echo '<tr>';
											echo '<td>'.$stp['sd_from'].'</td>';
											echo '<td>'.$stp['sd_to'].'</td>';
											echo '<td>'.getMode($stp['sd_mode']).'</td>';
											echo '<td>'.$stp['sd_amount'].'</td>';
											echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr><td colspan="5">Student Day Amount Not Released Yet!</td></tr>';
									}
					 			?>
					 		</tbody>
					 	</table>
					 
					 	<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control  fyDatepicker" id="sd_from_date" name="sd_from_date" placeholder="From">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control fyDatepicker" id="sd_to_date" name="sd_to_date" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control" id="sd_amount" name="sd_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
						     <div class="col-sm-4">
						    <select class="form-control" id="sd_mode" name="sd_mode" onchange="showStipendMode(this.id);">
						 		<option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>
							</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12 fade  sd_mode">
						    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
						     <div class="col-sm-4">
						    <input type="text" class="form-control" id="sd_cno" name="sd_cno" placeholder="Transaction No/Other">
						    </div>
						</div><br/><br/>
					</div>	 
					</div>
					<div class="nday_details panel panel-default" style="float:left;width:100%;min-height:150px;">
					 <div class="panel-heading">Summary of Day of National Importance Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only.------></span></div>
					 <div class="panel-body">						 	
					 	<table class="table table-striped table-bordered">
					 		<thead>
						 		<th> From</th>
						 		<th> To</th>
						 		<th> Mode</th>
						 		<th> Amount</th>
						 		<th> Date</th>
					 		</thead>
					 		<tbody>
					 			<?php 						 			
					 				if(isset($getStudentDayDetails) && !empty($getStudentDayDetails))
					 				{
										foreach($getStudentDayDetails as $stp)
										{
											echo '<tr>';
											echo '<td>'.$stp['nd_from_date'].'</td>';
											echo '<td>'.$stp['nd_to_date'].'</td>';
											echo '<td>'.getMode($stp['nd_mode']).'</td>';
											echo '<td>'.$stp['nd_amount'].'</td>';
											echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr><td colspan="5">Student Day Amount Not Released Yet!</td></tr>';
									}
					 			?>
					 		</tbody>
					 	</table>
					 
					 	<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control  fyDatepicker" id="nd_from_date" name="nd_from_date" placeholder="From">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control fyDatepicker" id="nd_to_date" name="nd_to_date" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control" id="nd_amount" name="nd_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
						     <div class="col-sm-4">
						    <select class="form-control" id="nd_mode" name="nd_mode" onchange="showStipendMode(this.id);">
						 		<option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>
							</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12 fade  sd_mode">
						    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
						     <div class="col-sm-4">
						    <input type="text" class="form-control" id="nd_cno" name="nd_cno" placeholder="Transaction No/Other">
						    </div>
						</div><br/><br/>
					</div>	 
					</div>
					<div class="eng_brg_details panel panel-default" style="float:left;width:100%;min-height:150px;">
					 <div class="panel-heading">Summary of English Bridge Course Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only.---></span></div>
					 <div class="panel-body">						 	
					 	<table class="table table-striped table-bordered">
					 		<thead>
						 		<th> From</th>
						 		<th> To</th>
						 		<th> Mode</th>
						 		<th> Amount</th>
						 		<th> Date</th>
					 		</thead>
					 		<tbody>
					 			<?php 						 			
					 				if(isset($getEnglishBridgeCourseDetails) && !empty($getEnglishBridgeCourseDetails))
					 				{
										foreach($getEnglishBridgeCourseDetails as $stp)
										{
											echo '<tr>';
											echo '<td>'.$stp['ebc_from_data'].'</td>';
											echo '<td>'.$stp['ebc_to_date'].'</td>';
											echo '<td>'.getMode($stp['ebc_mode']).'</td>';
											echo '<td>'.$stp['ebc_amount'].'</td>';
											echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
											echo '</tr>';
										}
									}
									else
									{
										echo '<tr><td colspan="5">English Bridge Course Amount Not Released Yet!</td></tr>';
									}
					 			?>
					 		</tbody>
					 	</table>
					 
					 	<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control  fyDatepicker" id="ebc_from_date" name="ebc_from_date" placeholder="From">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control fyDatepicker" id="ebc_to_date" name="ebc_to_date" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						     <input type="text" class="form-control" id="ebc_amount" name="ebc_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
						     <div class="col-sm-4">
						    <select class="form-control" id="ebc_mode" name="ebc_mode" onchange="showStipendMode(this.id);">
						 		<option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>
							</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12 fade  ebc_mode">
						    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
						     <div class="col-sm-4">
						    <input type="text" class="form-control" id="ebc_cno" name="ebc_cno" placeholder="Transaction No/Other">
						    </div>
						</div><br/><br/>
					</div>	 
					</div>
					<!-- new end -->
					<div class="adv_stipend_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Advance Stipend Released in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.----></span></div>
						 <div class="panel-body">						 	
						 	<table class="table table-striped table-bordered">
						 		<thead>
							 		<th> From</th>
							 		<th> To</th>
							 		<th> Mode</th>
							 		<th> Amount</th>
							 		<th> Date</th>
						 		</thead>
						 		<tbody>
						 			<?php 						 			
						 				if(isset($getStipendDetails) && !empty($getStipendDetails))
						 				{
											foreach($getStipendDetails as $stp)
											{
												echo '<tr>';
												echo '<td>'.$stp['adv_stipend_from'].'</td>';
												echo '<td>'.$stp['adv_stipend_to'].'</td>';
												echo '<td>'.getMode($stp['adv_stipend_mode']).'</td>';
												echo '<td>'.$stp['adv_stipend_amount'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 
						 	<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
							     <div class="col-sm-4">
							     <input type="text" class="form-control  fyDatepicker" id="adv_stipend_from_date" name="adv_stipend_from_date" placeholder="From">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
							     <div class="col-sm-4">
							     <input type="text" class="form-control fyDatepicker" id="adv_stipend_to_date" name="adv_stipend_to_date" placeholder="To">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							     <?php
							     $programme_exp = $this->config->item('programme_exp_stp');
								  $stipend_amt = $programme_exp[$applicaitonStepOne[0]['programme']];
							     ?>
							     
							     <input type="text" class="form-control" id="adv_stipend_rate" name="adv_stipend_rate" placeholder="Amount" value="<?php echo $stipend_amt;?>">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							    <select class="form-control" id="adv_stipend_pmode" name="adv_stipend_pmode" onchange="showStipendMode(this.id);">
							 		<option value="">Mode</option>
								   <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade  adv_stipend_pmode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							    <input type="text" class="form-control" id="adv_stipend_cno" name="adv_stipend_cno" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>
					</div>	 
					</div>
					<div class="stipend_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Stipend Details Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only.----></span></div>
						 <div class="panel-body">						 	
						 	<table class="table table-striped table-bordered">
						 		<thead>
							 		<th> From</th>
							 		<th> To</th>
							 		<th> Mode</th>
							 		<th> Amount</th>
							 		<th> Date</th>
									<!---<th> Action</th>--->
						 		</thead>
						 		<tbody>
						 			<?php 						 			
						 				if(isset($getStipendDetails) && !empty($getStipendDetails))
						 				{
											foreach($getStipendDetails as $stp)
											{
												echo '<tr>';
												echo '<td>'.$stp['stipend_from'].'</td>';
												echo '<td>'.$stp['stipend_to'].'</td>';
												echo '<td>'.getMode($stp['stipend_mode']).'</td>';
												echo '<td>'.$stp['amount'].'</td>';
												echo '<td>'.date('d M Y h:i:s A',$stp['created']).'</td>';
												//echo '<td><button type="button" class="btn" id = "expe" onclick ="editExp('.$stp['id'].')">Edit</button></td>';
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Stipend Not Released Yet!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 
						 	<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
							     <div class="col-sm-4">
							     <input type="text" class="form-control  fyDatepicker" id="stipend_from_date" name="stipend_from_date" placeholder="From">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
							     <div class="col-sm-4">
							     <input type="text" class="form-control fyDatepicker" id="stipend_to_date" name="stipend_to_date" placeholder="To">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							     <?php
							     $programme_exp = $this->config->item('programme_exp_stp');
								  $stipend_amt = $programme_exp[$applicaitonStepOne[0]['programme']];
							     ?>
							     
							     <input type="text" class="form-control" id="stipend_rate" name="stipend_rate" placeholder="Amount" value="<?php echo $stipend_amt;?>">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							    <select class="form-control" id="stipend_pmode" name="stipend_pmode" onchange="showStipendMode(this.id);">
							 		<option value="">Mode</option>
								   <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade  stipend_pmode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							    <input type="text" class="form-control" id="stipend_cno" name="stipend_cno" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>
					</div>	 
					</div>					
					<div class="aca_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Annual Contingent Allowance Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only.----></span></div>
						 <div class="panel-body">
						 <table class="table table-striped table-bordered">
						 		<thead>
							 		<th> Academic Year</th>
							 		<th> Amount</th>
							 		<th> Mode</th>
							 		<th> Date</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(isset($getACADetails))
						 				{
											foreach($getACADetails as $aca)
											{
												echo '<tr>';
												echo '<td>'.$aca['aca_year'].'</td>';
												echo '<td>'.$aca['aca_amount'].'</td>';
												echo '<td>'.getMode($aca['aca_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$aca['created']).'</td>';
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="3">No Record Found</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Academic Year</label>
							     <div class="col-sm-4">
							   		<select id="aca_year" name="aca_year" class="form-control">
									  <option value="">Academic Year</option>
									  <?php 
									  $expenditure_year;
									   foreach($expenditure_year as $years)
									   {
									   	echo '<option value="'.$years.'">'.$years.'</option>';
									   }
									  ?>
								  </select>
							    </div>
							</div><br/><br/>
							 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Release Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="aca_release_date" name="aca_release_date" placeholder="From">
							    </div>
							</div><br/><br/>
						
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							   <input type="text" class="form-control" id="aca" name="aca" placeholder="Amount">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							   <select class="form-control " id="aca_mode" name="aca_mode" onchange="showStipendMode(this.id);">
								 <option value="">Mode</option>
								  <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
						 		
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade aca_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							  <input type="text" class="form-control" id="aca_cno" name="aca_cno" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>
						 </div>
					</div>
					<div class="hos_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Hostel Charges Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only.----></span></div>
						 <div class="panel-body">
						 
						 	<table class="table table-striped table-bordered">
						 		<thead>
							 		<th> From Date</th>
							 		<th> To Date</th>
							 		<th> Amount</th>
							 		<th> Mode</th>
							 		<th> Date</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getHostelDetails))
						 				{
											foreach($getHostelDetails as $hos)
											{
												echo '<tr>';						
												echo '<td>'.$hos['hos_from'].'</td>';		
												echo '<td>'.$hos['hos_to'].'</td>';						
												echo '<td>'.$hos['hos_amount'].'</td>';
												echo '<td>'.getMode($hos['hos_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$hos['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="4">No Record Found</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">From Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="hos_from" name="hos_from" placeholder="From">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">To Date</label>
							     <div class="col-sm-4">
							   <input type="text" class="form-control fyDatepicker" id="hos_to" name="hos_to" placeholder="To">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="hos_amount" name="hos_amount" placeholder="Amount">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							   <select class="form-control " id="hos_mode" name="hos_mode" onchange="showStipendMode(this.id);">
								 <option value="">Mode</option>
								   <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
						 		
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade hos_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							  <input type="text" class="form-control" id="hos_cheq_no" name="hos_cheq_no" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>							
						 </div>
					</div>	 
					<div class="hra_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of HRA Released in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.---></span></div>
						 <div class="panel-body">
						 
						 	<table class="table table-striped table-bordered">
						 		<thead>
						 			<th> City</th>
							 		<th> From</th>
							 		<th> To</th>
							 		<th> Amount</th>
							 		<th> Mode</th>	
							 		<th> Created</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getHRADetails))
						 				{
						 					$cities = $this->config->item('grade_cities');
											foreach($getHRADetails as $hra)
											{
												echo '<tr>';
												echo '<td>'.$cities[$hra['hra_city']].'</td>';
												echo '<td>'.$hra['hra_from_date'].'</td>';
												echo '<td>'.$hra['hra_to_date'].'</td>';
												echo '<td>'.$hra['hra_amount'].'</td>';
												echo '<td>'.getMode($hra['hra_mode']).'</td>';
												
												echo '<td>'.date('d M Y h:i:s A',$hra['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">No Record Found</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 	<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">City</label>
							     <div class="col-sm-4">
							   <select class="form-control " id="hra_city" name="hra_city">
								   <option value="">City</option>
								   <option value="1">Delhi</option>
								   <option value="2">Banglore</option>
								   <option value="3">Calcutta</option>
								   <option value="4">Chennai</option>
								   <option value="5">Mumbai</option>
								   <option value="6">Hydrabad</option>
								   <option value="8">Pune</option>
								   <option value="7">Other</option>						 		
								</select>
							    </div>
							</div><br/><br/>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">From Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="hra_from_date" name="hra_from_date" placeholder="From">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">To Date</label>
							     <div class="col-sm-4">
							   <input type="text" class="form-control fyDatepicker" id="hra_to_date" name="hra_to_date" placeholder="To">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="hra_rate" name="hra_rate" placeholder="Amount">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							   <select class="form-control " id="hra_mode" name="hra_mode" onchange="showStipendMode(this.id);">
								   <option value="">Mode</option>
								   <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade hra_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							  <input type="text" class="form-control" id="hra_cno" name="hra_cno" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>							
						 </div>
					</div>
					<div class="tf_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Tuition Fees/Other Compulsory Fees (TF/OCF) Released in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.---></span></div>
						 <div class="panel-body">
						 	<table class="table table-striped table-bordered">
						 		<thead>
							 		<th> Academic Year</th>
							 		<th> Amount</th>							 									 					<th> Mode</th>
							 		<th> Date</th>
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getTutionFeeDetails))
						 				{
											foreach($getTutionFeeDetails as $tfee)
											{
												echo '<tr>';						
												echo '<td>'.$tfee['tf_year'].'</td>';		
												echo '<td>'.$tfee['tf_amount'].'</td>';						
												echo '<td>'.getMode($tfee['tf_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$tfee['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="4">No Record Found</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Academic Year</label>
							     <div class="col-sm-4">
							   		<select id="tf_year" name="tf_year" class="form-control">
									  <option value="">Select</option>
									  <?php 
									  $expenditure_year;
									   foreach($expenditure_year as $years)
									   {
									   	echo '<option value="'.$years.'">'.$years.'</option>';
									   }
									  ?>
									  </select>
							    </div>
							</div><br/><br/>
								 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Release Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="tf_release_date" name="tf_release_date" placeholder="From">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							  		<input type="text" class="form-control" id="tf_amount" name="tf_amount" placeholder="Amount">
							    </div>
							</div><br/><br/>	
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							  	 <select class="form-control " id="tf_mode" name="tf_mode" onchange="showStipendMode(this.id);">
								 	<option value="">Mode</option>
								   <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade tf_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							  		<input type="text" class="form-control" id="tf_cheq_no" name="tf_cheq_no" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>												
						 </div>
					</div>	
				<!--	<div class="ocf_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Other Compulsory Fees(OCF) Released in Financial Year <label class="fy"></label> <span class='spn_note'>Date Can be Selected Quarter Wise Only.</span></div>
						 <div class="panel-body">
						 <table class="table table-striped table-bordered">
						 		<thead>
							 		<th> Academic Year</th>
							 		<th> Amount</th>							 									 								<th> Mode</th>
							 		<th> Date</th>
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getOCFDetails))
						 				{
											foreach($getOCFDetails as $ocf)
											{
												echo '<tr>';						
												echo '<td>'.$ocf['ocf_year'].'</td>';		
												echo '<td>'.$ocf['ocf_amount'].'</td>';						
												echo '<td>'.getMode($ocf['ocf_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$ocf['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="4">No Record Found</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Academic Year</label>
							     <div class="col-sm-4">
							   		<select id="ocf_year" name="ocf_year" class="form-control">
									  <option value="">Select</option>
									  <?php
									  
									   foreach($expenditure_year as $years)
									   {
									   	echo '<option value="'.$years.'">'.$years.'</option>';
									   }
									  ?>
									  </select>
							    </div>
							</div><br/><br/>
							 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Release Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="ocf_release_date" name="ocf_release_date" placeholder="From">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							  		<input type="text" class="form-control" id="ocf_amount" name="ocf_amount" placeholder="Amount">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							  	 <select class="form-control " id="ocf_mode" name="ocf_mode" onchange="showStipendMode(this.id);">
								 	<option value="">Mode</option>
								   <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade ocf_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							  		<input type="text" class="form-control" id="ocf_cheq_no" name="ocf_cheq_no" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>													
						 </div>
					</div>-->	
					<div class="st_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Study Tour in India Released in Financial Year <label class="fy"></label> <span class='spn_note'><!---Date Can be Selected Quarter Wise Only.----></span></div>
						 <div class="panel-body">
						 	<table class="table table-striped table-bordered">
						 		<thead>
						 			<th> City From</th>
						 			<th> City To</th>
						 			<th> City From Days</th>
						 			<th> Date To Days</th>
							 		<th> Date From</th>
							 		<th> Date To</th>
							 		<th> Amount</th>
							 		<th> Mode</th>
							 		<th> Created</th>
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getStudyTourDetails))
						 				{
											foreach($getStudyTourDetails as $studytr)
											{												
												echo '<tr>';
												echo '<td>'.$cities[$studytr['st_from_city']].'</td>';
												echo '<td>'.$cities[$studytr['st_to_city']].'</td>';
												echo '<td>'.$studytr['st_from_city_days'].'</td>';
												echo '<td>'.$studytr['st_to_city_days'].'</td>';
												echo '<td>'.$studytr['st_from_date'].'</td>';
												echo '<td>'.$studytr['st_to_date'].'</td>';
												echo '<td>'.$studytr['st_amount'].'</td>';
												echo '<td>'.getMode($studytr['st_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$studytr['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="3">No Record Found</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						  
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">City From</label>
						     <div class="col-sm-4">
						   		<select class="form-control " id="st_from_city" name="st_from_city">
									   <option value="">City</option>
									   <option value="1">Delhi</option>
									   <option value="2">Banglore</option>
									   <option value="3">Calcutta</option>
									   <option value="4">Chennai</option>
									   <option value="5">Mumbai</option>
									   <option value="6">Hydrabad</option>	
									   <option value="7">Other</option>						 		
									</select>
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">City To</label>
						     <div class="col-sm-4">
						   		<select class="form-control " id="st_to_city" name="st_to_city">
									    <option value="">City</option>
									   <option value="1">Delhi</option>
									   <option value="2">Banglore</option>
									   <option value="3">Calcutta</option>
									   <option value="4">Chennai</option>
									   <option value="5">Mumbai</option>
									   <option value="6">Hydrabad</option>	
									   <option value="7">Other</option>						 		
									</select>
						    </div>
						</div><br/><br/>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">No of Days in from City</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="st_from_city_days" name="st_from_city_days" placeholder="No of Days">
							    </div>
							</div><br/><br/>
							 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">No of Days in to City</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="st_to_city_days" name="st_to_city_days" placeholder="No of Days">
							    </div>
							</div><br/><br/>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Date From</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="st_from_date" name="st_from_date" placeholder="From">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">To Date</label>
							     <div class="col-sm-4">
							  		<input type="text" class="form-control fyDatepicker" id="st_to_date" name="st_to_date" placeholder="To">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							  		<input type="text" class="form-control " id="st_amount" name="st_amount" placeholder="Amount">
							    </div>
							</div><br/><br/>
							<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							   <select class="form-control " id="st_mode" name="st_mode" onchange="showStipendMode(this.id);">
								   <option value="">Mode</option>
								   <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade st_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							  		<input type="text" class="form-control" id="st_cno" name="st_cno" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>												
						 </div>
					</div>	
					<div class="mr_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Medical Reimbursment Released in Financial Year <label class="fy"></label> <span class='spn_note'><!-----Date Can be Selected Quarter Wise Only.----></span></div>
						 <div class="panel-body">
						 <table class="table table-striped table-bordered">
						 		<thead>							 		
							 		<th> Amount</th>	
							 		<th> Mode</th>	
							 		<th> Date</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getMedicalReimbursDetails))
						 				{
											foreach($getMedicalReimbursDetails as $mr)
											{
												echo '<tr>';												
												echo '<td>'.$mr['mr_amount'].'</td>';
												echo '<td>'.getMode($mr['mr_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$mr['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="2">Stipend Not Released Yet!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>	
						  <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Release Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="mr_release_date" name="mr_release_date" placeholder="From">
							    </div>
							</div><br/><br/>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="mr_amount" name="mr_amount" placeholder="Amount">
							    </div>
						</div><br/><br/>
						<div class="col-xs-12">
					    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
					     <div class="col-sm-4">
					   		<select class="form-control " id="mr_mode" name="mr_mode" onchange="showStipendMode(this.id);">
							   <option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>							 		
							</select>
					    </div>
						</div><br/><br/>
						 <div class="col-xs-12 fade mr_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="mr_cno" name="mr_cno" placeholder="Amount">
							    </div>
						</div><br/><br/>									
						 </div>
					</div>	
					<div class="travel_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Travel Payment Released in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.-----></span></div>
						 <div class="panel-body">
						 <table class="table table-striped table-bordered">
						 		<thead>
							 		
							 		<th> Travel Type</th>	
							 		<th> Amount</th>
							 		<th> Mode</th>
							 		<th> Date</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getTravalDetails))
						 				{
											foreach($getTravalDetails as $travel)
											{
												echo '<tr>';	
												if($travel['travel_type'] == 1)
												{
													echo '<td>Air</td>';	
												}
												if($travel['travel_type'] == 2)
												{
													echo '<td>Surface</td>';	
												}	
												echo '<td>'.$travel['travel_amount'].'</td>';	
												echo '<td>'.getMode($travel['travel_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$travel['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="4">Not Record Found!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Travel Type</label>
							     <div class="col-sm-4">
							   		<select id="travel_type" name="travel_type" class="form-control">
									  <option value="">Select</option>
									  <option value="1">Air</option>
									  <option value="2">Surface</option>
									  </select>
							    </div>
							</div><br/><br/>
							 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Release Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="travel_release_date" name="travel_release_date" placeholder="From">
							    </div>
							</div><br/><br/>						
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						   		<input type="text" class="form-control" id="travel_amount" name="travel_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>	
						<div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
							     <div class="col-sm-4">
							  	 <select class="form-control " id="travel_mode" name="travel_mode" onchange="showStipendMode(this.id);">
								 	<option value="">Mode</option>
								   <option value="1">Cash</option>
								   <option value="2">Bank Transfer</option>
								   <option value="3">NEFT</option>
								   <option value="4">RTGS</option>
								   <option value="5">Other</option>
								</select>
							    </div>
							</div><br/><br/>
							<div class="col-xs-12 fade travel_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							  		<input type="text" class="form-control" id="travel_cno" name="travel_cno" placeholder="Transaction No/Other">
							    </div>
							</div><br/><br/>									
						 </div>
					</div>
				    <div class="this_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Thesis Charges Released in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.-----></span></div>
						 <div class="panel-body">	
						 	<table class="table table-striped table-bordered">
						 		<thead>
							 		<th> Amount</th>
							 		<th> Mode</th>	
							 		<th> Date</th>				 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getThesisChargesDetails))
						 				{
											foreach($getThesisChargesDetails as $thiss)
											{
												echo '<tr>';												
												echo '<td>'.$thiss['tc_amount'].'</td>';
												echo '<td>'.getMode($thiss['tc_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$thiss['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="3">Not Record Found!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>	
						 	 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Release Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="tc_release_date" name="tc_release_date" placeholder="From">
							    </div>
							</div><br/><br/>									
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						   		<input type="text" class="form-control" id="tc_amount" name="tc_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>	
						<div class="col-xs-12">
					    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
					     <div class="col-sm-4">
					   		<select class="form-control " id="tc_mode" name="tc_mode" onchange="showStipendMode(this.id);">
							   <option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>							 		
							</select>
					    </div>
						</div><br/><br/>
						 <div class="col-xs-12 fade tc_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="tc_cno" name="tc_cno" placeholder="Transaction No/Other">
							    </div>
						</div><br/><br/>								
						 </div>
					</div>
				    <div class="misc_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Miscellaneous Released in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.----></span></div>
						 <div class="panel-body">	
						 <table class="table table-striped table-bordered">
						 		<thead>
							 		
							 		<th>Misc. Item</th>	
							 		<th> Amount</th>
							 		<th> Mode</th>
							 		<th> Cheque No.</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getMiscDetails))
						 				{
											foreach($getMiscDetails as $misc)
											{
												echo '<tr>';						
												echo '<td>'.$misc['msc_item'].'</td>';						
												echo '<td>'.$misc['msc_amount'].'</td>';
												echo '<td>'.getMode($misc['msc_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$misc['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="4">Not Record Found!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>											
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Miscellaneous Item</label>
						     <div class="col-sm-4">
						   		 <input type="text" class="form-control" id="msc_item" name="msc_item" placeholder="Miscellaneous">
						    </div>
						</div><br/><br/>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Release Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="msc_release_date" name="msc_release_date" placeholder="From">
							    </div>
							</div><br/><br/>
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						   		  <input type="text" class="form-control" id="msc_amount" name="msc_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>	
						<div class="col-xs-12">
					    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
					     <div class="col-sm-4">
					   		<select class="form-control " id="msc_mode" name="msc_mode" onchange="showStipendMode(this.id);">
							   <option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>							 		
							</select>
					    </div>
						</div><br/><br/>
						 <div class="col-xs-12 fade msc_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="msc_cno" name="msc_cno" placeholder="Transaction No/Other">
							    </div>
						</div><br/><br/>								
						 </div>
					</div>	
					<div class="uni_misc_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Miscellaneous for University Released in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.---></span></div>
						 <div class="panel-body">	
						 <table class="table table-striped table-bordered">
						 		<thead>
							 		
							 		<th>Misc. Item</th>	
							 		<th> Amount</th>
							 		<th> Mode</th>
							 		<th> Date</th>							 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getMiscellaneousUniversityDetails))
						 				{
											foreach($getMiscellaneousUniversityDetails as $miscu)
											{
												echo '<tr>';						
												echo '<td>'.$miscu['uni_msc_item'].'</td>';		
												echo '<td>'.$miscu['uni_msc_amount'].'</td>';	
												echo '<td>'.getMode($miscu['uni_msc_mode']).'</td>';
												echo '<td>'.date('d M Y h:i:s A',$miscu['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="4">Not Record Found!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>
						 												
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Miscellaneous Item</label>
						     <div class="col-sm-4">
						   		 <input type="text" class="form-control" id="uni_msc_item" name="uni_msc_item" placeholder="Miscellaneous">
						    </div>
						</div><br/><br/>
						 <div class="col-xs-12">
							    <label for="inputEmail3" class="col-sm-3 control-label">Release Date</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control fyDatepicker" id="uni_msc_release_date" name="uni_msc_release_date" placeholder="From">
							    </div>
							</div><br/><br/>
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						   		  <input type="text" class="form-control" id="uni_msc_amount" name="uni_msc_amount" placeholder="Amount">
						    </div>
						</div><br/><br/>	
						<div class="col-xs-12">
					    <label for="inputEmail3" class="col-sm-3 control-label">Mode</label>
					     <div class="col-sm-4">
					   		<select class="form-control " id="uni_msc_mode" name="uni_msc_mode" onchange="showStipendMode(this.id);">
							   <option value="">Mode</option>
							   <option value="1">Cash</option>
							   <option value="2">Bank Transfer</option>
							   <option value="3">NEFT</option>
							   <option value="4">RTGS</option>
							   <option value="5">Other</option>							 		
							</select>
					    </div>
						</div><br/><br/>
						 <div class="col-xs-12 fade uni_msc_mode">
							    <label for="inputEmail3" class="col-sm-3 control-label">Transaction No./Other</label>
							     <div class="col-sm-4">
							   		<input type="text" class="form-control" id="uni_msc_cno" name="uni_msc_cno" placeholder="Transaction No/Other">
							    </div>
						</div><br/><br/>								
						 </div>
					</div>	
					<div class="exindia_details panel panel-default" style="float:left;width:100%;min-height:150px;">
						 <div class="panel-heading">Summary of Ex India Deduction in Financial Year <label class="fy"></label> <span class='spn_note'><!----Date Can be Selected Quarter Wise Only.---></span></div>
						 <div class="panel-body">	
						  <table class="table table-striped table-bordered">
						 		<thead>
							 		
							 		<th>From</th>	
							 		<th> To</th>
							 		<th> Amount</th>
							 		<th>Date</th>						 		
							 								 		
						 		</thead>
						 		<tbody>
						 			<?php 
						 				if(!empty($getDeductionDetails))
						 				{
											foreach($getDeductionDetails as $ded)
											{
												echo '<tr>';	
													
												echo '<td>'.$ded['ded_from'].'</td>';
												echo '<td>'.$ded['ded_to'].'</td>';
												echo '<td>'.$ded['ded_amount'].'</td>';	
												echo '<td>'.date('d M Y h:i:s A',$ded['created']).'</td>';							
												echo '</tr>';
											}
										}
										else
										{
											echo '<tr><td colspan="5">Not Record Found!</td></tr>';
										}
						 			?>
						 		</tbody>
						 	</table>											
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">From</label>
						     <div class="col-sm-4">
						   		 <input type="text" class="form-control fyDatepicker" id="ded_from" name="ded_from" placeholder="From">
						    </div>
						</div><br/><br/>
						 <div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">To</label>
						     <div class="col-sm-4">
						   		  <input type="text" class="form-control fyDatepicker" id="ded_to" name="ded_to" placeholder="To">
						    </div>
						</div><br/><br/>
						<div class="col-xs-12">
						    <label for="inputEmail3" class="col-sm-3 control-label">Amount</label>
						     <div class="col-sm-4">
						   		  <input type="text" class="form-control" id="ded_amount" name="ded_amount" placeholder="Amount">
						    </div>
						</div>						
															
						 </div>
					</div>	
								
					
					<hr/>
					<div class="form-group col-xs-9 exp_doc">						
						    <label for="" class="col-sm-2">Expenditure Document</label>
						    <div class="col-sm-8">
						      <input class="" id="doc" name="doc" placeholder="From" type="file">
						    </div>					    
									    
					</div>
					<hr/>
					<div class="form-group col-xs-9 signt">
					    <label for="inputEmail3" class="col-sm-2">Name of the Officer</label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" id="officer_name" name="officer_name" placeholder="Name">
					    </div>
					
				<div class="form-group col-xs-5 pull-right" style="width: 416px;">
					    <label for="" class="col-sm-3">Signature</label>
					    <div class="col-sm-8">
					      <input class="" id="expenditure_sign" name="expenditure_sign" placeholder="From" type="file">
					    </div>					    
					</div>
					
					    					    
					</div>
					
					
					<div class="form-group col-xs-9 signt">
					    <label for="inputEmail3" class="col-sm-2">Date</label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" readonly="true" id="expenditure_date" name="expenditure_date" placeholder="Date" value="<?php 
						  date_default_timezone_set("Asia/Kolkata");
						  echo date('d M Y h:i:s A');
						  ?>">
					    </div>				    
					</div>
				
					
					<div class="form-group col-xs-9 pull-right pdlef signt">					    
					    <div class="col-sm-3 pull-left pdleft">
					      <input type="submit" class="form-control sbmt" id="submit" value="Submit"/>
					    </div>					    
					</div> 			
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
                          <h4 class="modal-title">EXPENDITURE STATEMENT OF STUDENT</h4>
                        </div>
                        <div class="modal-body">
     
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                  
                </div>
            </div>
</section>
	
<div id="expDiv" class="modal fade" role="dialog">
  	<div id="expDivId" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop PDF file Here</span></div>
  		</div>
  </div>
	<script src="<?php echo base_url();?>assets/site/main/js/bootbox/bootbox.min.js"></script>
<script type='text/javascript'>
	//Edit Expend
function editExp(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editExpenditure')?>',
                        type: 'post',
						data:{'appno':appid},
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
//AdvanceStipned
function editAdvanceStipendExp(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editAdvancStipenedExpenditure')?>',
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
//STIPNED
function editStipendExp(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                       url: '<?php echo site_url('regional/editStipenedExpenditure')?>',
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
//HRA

//Hostel

function editHostelExp(appid){
	
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editHostelExpenditure')?>',
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


function editHRAExp(appid){
	
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editHRAExpenditure')?>',
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
//ACA
function editACAExp(appid){
	
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editACAExpenditure')?>',
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

//Tution Fee
function editTutionFeeExp(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editTutionFeeExpenditure')?>',
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

//Tour
function editTourExp(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editTourExpenditure')?>',
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



//Medical
function editMedicalExp(appid){
	
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editMedicalExpenditure')?>',
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
//Thesis
function editThesisExp(appid){
	
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editThesisExpenditure')?>',
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

//Miscellaneous
function editMiscellaneousExp(appid){
	
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editMiscellaneousExpenditure')?>',
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
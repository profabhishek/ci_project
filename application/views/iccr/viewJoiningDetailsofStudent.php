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
		<h3 class="text-center caps">Joining Details of Applicant</h3>	
		<h4 class="text-center caps">Academic  Year : <?php echo $this->uri->segment(4); ?></h4>	
		<h4 class="text-center caps"><?php echo strtoupper($regionName[0]["name"]); ?> </h4>	
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="blue-heading col-md-12 " style="margin-bottom:0;">
			 <h3>Joining Statement of Applicant: <?php echo $this->uri->segment(3); ?> for Academic Year - <?php echo $this->uri->segment(4); ?></h3>
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadAllExpenditureReport/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		<input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
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
	  			 				<td ><?php echo $this->uri->segment(3); ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px">Name</td>
	  			 				<td><?php echo $academicDetails[0]['fullname']; ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px">Country</td>
	  			 				<td> <?php
								  $countries = $this->common_model->getCountries();
								  foreach($countries as $country)
								  {
									  if($country['id'] == $academicDetails[0]['country'])
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
											if($prog['id'] == $academicDetails[0]['programme'])
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
									  if($course['id'] == $academicDetails[0]['course'])
									  {
										echo $course['title'];
									  }
								  }
								  ?></td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px">Course Duration</td>
	  			 				<td>  <?php
									echo $academicDetails[0]['course_duration_from'].' - '.$academicDetails[0]['course_duration_to'];
								  ?></td>
	  			 			</tr>
	  			 			<tr class="trr">
	  			 				<td>University/Institute</td>
	  			 				<td> <?php
								
				 				//$data = $this->common_model->getconfirmationData($this->uri->segment(3));
						        //$uni = $this->common_model->getUniversityById($data[0]['regional_university']);echo $uni[0]['name'];
								 $univ = $this->common_model->getAllUniversities();
								  foreach($univ as $un)
								  {
									  if($un['id'] == $academicDetails[0]['university'])
									  {
										echo $un['name'];
									  }
								  }
								 
						    ?>	</td>
	  			 			</tr>
	  			 			<tr>
	  			 				<td width="200px" style="background:#fff;">Scheme</td>
	  			 				<td> <?php
								  $code = "";
								  $schemes = $this->common_model->getAllSchemes();
								  foreach($schemes as $scheme)
								  {								  		
								  		if(!empty($academicDetails))
					      		  		{
											if($academicDetails[0]['scheme'] == $scheme['id'])
											{
												echo $scheme['scheme_name'];
											}
											
										}
								  }
								  ?></td>
	  			 			</tr>
	  			 		</tbody>
	  			 	</table> 
	  			 	
	     			<table id="tbl_report" class="table table-striped table-bordered" style="width:100%;">
						 		
						 		<tbody>
						 			
						 			
<tr>
						 				<td><b>Joining Details</b></td>
						 				
						 			</tr>
						 			<tr>
						 				<td>
						 					<table class=" table table-striped table-bordered travelTable" style="width:100%;">
						 				<thead>
						 					<th> Categories</th>
							 		<th> Joining Date</th>
							 		<th> Completetion Date</th>
							 		<th> Travel Arrive Date</th>
                                    <th> Flight No</th>									
							 		
						 				</thead>
						 				<tbody>
						 					<tr>
						 				<?php $full_welfare = 0; ?>
						 				<td>Joining Details</td>
						 				<?php
						 				
						 					if(count($joiningDetails)>0)
						 					{
						 						
												foreach($joiningDetails as $trvl)
							 					{
							 						echo (($trvl['joining_date'] !=NULL) && ($trvl['joining_date'] !="")) ? "<td>".$trvl['joining_date']."</td>" : "<td>0</td>";
													echo (($trvl['completion_date'] !=NULL) && ($trvl['completion_date'] !="")) ? "<td>".$trvl['completion_date']."</td>" : "<td>0</td>";
													echo (($trvl['travel_arival_date'] !=NULL && $trvl['travel_arival_date'] !="")) ? "<td>".$trvl['travel_arival_date']."</td>" : "<td>0</td>";
													echo (($trvl['flight_no'] !=NULL && $trvl['flight_no'] !="")) ? "<td>".$trvl['flight_no']."</td>" : "<td>0</td>";													
												}	
											}
											
						 				?>
						 			</tr>
							 																															
						 			
						 				</tbody>
						 			</table>
						 				</td>
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
	trr += "<td><b>Grand Totals</b></td>";
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
	
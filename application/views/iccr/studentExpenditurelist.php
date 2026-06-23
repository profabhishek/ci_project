<style type="text/css">
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
.form-group {
    margin-bottom: 15px;
    margin-top: 17px;
}
</style>
<script type="text/javascript">
	function showExpenditure(id)
	{
		var fy = $('#fy_old').val();
		if(fy != "")
		{
			location.href = baseURL + "headquarter/expenditureReportofStudent/" + id + "/" + fy;
		}
		else
		{
			 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Select Financial Year First."  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
		}
	}
	function showExpenditureList(id)
	{
		var fy = $('#fyrept').val();
		if(fy != "")
		{
			location.href = baseURL + "headquarter/expenditureReportofStudent/" + id + "/" + fy;
		}
		else
		{
			 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Select Financial Year First."  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
		}
	}
</script>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:15px;">
			<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal 
	</marquee>
			<div class="blue-heading col-md-12 ">
			 <h3>Expenditure Details of New Students</h3>
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadList/" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>headquarter/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
			<form id="form-filter">
			<div class="col-md-12 form-group">
			<div class="col-md-1 pdleft pdright">
			<label class="pull-right">Financial Year</label>
			</div>
			<div class="col-md-2">
				<select class="form-control" id="fyrept" name="fyrept">
					<option value="">Financial Year</option>
					<?php 
					foreach($ofy as $fyy)
					{
						echo '<option value="'.$fyy.'">'.$fyy.'</option>';
					}
					?>
				</select>
			</div>
			<div class="col-md-1 pdleft pdright">
			<label class="pull-right">Admission Year</label>
			</div>
			<div class="col-md-2">
				<select class="form-control" id="fy_old_one" name="fy_old_one">
					<option value="">Admission Year</option>
					<?php 
					foreach($ofy as $fyy)
					{
						echo '<option value="'.$fyy.'">'.$fyy.'</option>';
					}
					?>
				</select>
			</div>
			
			<div class="col-md-1">
			<label class="pull-right">Expenditure</label>
			</div>
			<div class="col-md-2">
				<select class="form-control" id="expenditurefilter" name="expenditurefilter">
					<option value="1">All</option>
					<option value="2">Released</option>
				</select>
			</div>
			<div class="col-md-1">
			<label class="pull-right">RO's</label>
			</div>
			<div class="col-md-2">
				<select class="form-control" id="ros" name="ros">
					<option value="-1">All</option>
					<?php
						$regionalOffices = $this->common_model->getAllRegions();
						if(count($regionalOffices)>0)
						{
							foreach($regionalOffices as $ro)
							{
								?>
								<option value="<?php echo $ro['id'];?>"><?php echo $ro['name'];?></option>
								<?php			
							}
						}
					?>
				</select>
			</div>
			<div class="filters col-md-12 form-group" >
				<div class="col-sm-6">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button>
                 </div>
			</div>
		</div>
		</form>
		<table id="tbl_schrls" class="table table-striped table-bordered detailpagepdf expreportTable">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>
				
				<th>Applicant Name</th>			
				<th>Email</th>
				<th>Gender</th>
				<th>Programme</th>
				<th>Country</th>
				<th>Scheme</th>
				<th>Admission Year</th>
				<th>Regional Office</th>
				<th>Status </th>
				<th>Expenditure</th>				
			</thead>
			<tbody>
				
			</tbody>
		</table>
		<hr/>
		
		<div class="blue-heading col-md-12 ">
			 <h3>Expenditure Details of Old Students</h3>
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadList/" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>headquarter/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		<div class="col-md-7 form-group">
			<div class="col-md-8">
			<label class="pull-right">Financial Year</label>
			</div>
			<div class="col-md-4 pull-right">
				<select class="form-control" id="fy_old" name="fy_old">
					<option value="">Financial Year</option>
					<?php 
					foreach($ofy as $fyy)
					{
						echo '<option value="'.$fyy.'">'.$fyy.'</option>';
					}
					
					?>
				</select>
			</div>
			<div class="filters col-md-12 form-group">
				<div class="col-sm-6">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button>
                 </div>
			</div>
						
		</div>
		<table id="tbl_schrls" class="table table-striped table-bordered detailpagepdf ">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>
				<th>Applicant Name</th>				
				<th>Email</th>
				<th>Gender</th>
				<th>Programme</th>				
				<th>Country</th>
				<th>Scheme</th>	
				<th>Regional Office</th>
				<th>Status </th>				
			</thead>
			<tbody>
			
			</tbody>
		</table>
	</div>
</section>

	<script type="text/javascript">		

$(document).ready(function() {
	
	 reprottable = $('.expreportTable').DataTable( {	
        "order": [[1, "desc" ]],
        "processing": true,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":"<?php echo site_url('headquarter/getExpStudentDetails')?>",
        	"type": "POST",
            "data": function ( data ) {
                data.FinancialYear = $('#fy_old_one').val();
				data.ExpenditureFilter = $('#expenditurefilter').val();
				data.RO = $('#ros').val();
				
            }
        },
         
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/images/loader.gif'></div>"}
    } );
	
	
	
	

 
    $('#btn-filter').click(function(){ //button filter event click
        reprottable.ajax.reload(null,true);  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reprottable.ajax.reload(null,true);  //just reload table
    });   
});
	</script>
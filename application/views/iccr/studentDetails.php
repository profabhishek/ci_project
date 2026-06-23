
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
</style>
<section class="meacontent">
	<div class="container" style="min-height:410px;padding-top:10px;">		
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal 
	</marquee>	
	
		<div class="blue-heading col-md-12">
			 <h3>Applicant Details for Current Academic Year</h3>
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>headquarter/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		<form id="form-filter" class="form-horizontal">
			<div class="filters col-md-12 form-group">
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Applicant Name</label>
					<div class="col-md-6 pdright pdleft">
						<input type="text" id="applicant_name" name="applicant_name" class="form-control"/>
					</div>
				</div>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Gender</label>
					<div class="col-md-6 pdright pdleft">
						<select id="gender" name="gender" class="form-control">
							<option value="">Select</option>
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Email Id</label>
					<div class="col-md-6 pdright pdleft">
						<input type="text" id="mail" name="mail" class="form-control" placeholder="Email Id"/>
					</div>
				</div>
			
				
				
			
			</div>
			<div class="filters col-md-12 form-group">
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5 pdleft">Academic Programme</label>
					<div class="col-md-6 pdright pdleft">
						<select id="programmes" name="programmes" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						  <?php
						  $programme = $this->common_model->getAllProgramme();
						  foreach($programme as $na)
						  {
						  	echo '<option value="'.$na['id'].'">'.$na['name'].'</option>';
						  }
						  ?>
						</select>
					</div>
				</div>
					
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Country</label>
					<div class="col-md-6 pdright pdleft">
						<select id="country" name="country" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						  <?php
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $na)
						  {
						  	echo '<option value="'.$na['id'].'">'.$na['country_name'].'</option>';
						  }
						  ?>
						</select>
					</div>
				</div>
				
			
				
				
			</div>				
			
			<div class="filters col-md-12 form-group">
				<div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button>
                 </div>
			</div>
			</form>
		<table class="table table-striped table-bordered detailpagepdf reportTable">
			<thead>
				<th>S.No.</th>				
				<th>Applicant Name</th>				
				<th>Email Id</th>
				<th>Gender</th>
				<th>Programme</th>
				<th>Scheme</th>
				<th>Country</th>								
				<th>Application Form </th>	
				<th>Contact Form </th>								
			</thead>
					
		</table>
		<hr/>
	</div>
</section>
	<script type="text/javascript">
		

$(document).ready(function() {
	
	 reprottable = $('.reportTable').DataTable( {	
        "order": [[1, "desc" ]],
        "processing": true,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":"<?php echo site_url('headquarter/getStudentDetails')?>",
        	"type": "POST",
            "data": function ( data ) {
                data.ApplicantName = $('#applicant_name').val();
                data.Gender = $('#gender').val();
                data.Mail = $('#mail').val();
                data.Country = $('#country').val();
                data.Programme = $('#programmes').val();
                data.Counrse = $('#courses').val();
                data.Scheme = $('#schemes').val();
            }
        },
         
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/images/loader.gif'></div>"}
    } );
	
	
	
	

 
    $('#btn-filter').click(function(){ //button filter event click
        //reprottable.ajax.reload();  //just reload table
        reprottable.ajax.reload(null, true);
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reprottable.ajax.reload(null, true);
      //  reprottable.ajax.reload();  //just reload table
    });   
});
</script>
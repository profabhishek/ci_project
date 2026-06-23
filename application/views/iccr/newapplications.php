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
    .alert
    {
        margin: 0 auto 1%;    
        width: 85.5%;
    }
</style>
<?php 

function sortByName($a, $b)
{
	$a = $a['uni'];
	$b = $b['uni'];

	if ($a == $b)
	{
		return 0;
	}

	return ($a < $b) ? -1 : 1;
}
$stateuniversities = $this->common_model->getStateUniversities();

//
$icaruniversity = $this->common_model->getICARUniversity();

$centraluniversities = $this->common_model->getCentralUniversities();

$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states =  $this->common_model->getAllStates();

$statewiseUniversites = array();
foreach($states as $st)
{
	if(!array_key_exists($st['id'],$statewiseUniversites))
	{
		$statewiseUniversites[$st['id']] = array();
	}
}
$icaruniversity_one = str_replace("'","\'",json_encode($icaruniversity));
$stateuniversities_one = str_replace("'","\'",json_encode($stateuniversities));
$centraluniversities_one = str_replace("'","\'",json_encode($centraluniversities));
$nits_one = str_replace("'","\'",json_encode($nits));
$yogas_one = str_replace("'","\'",json_encode($yogas));
$states_array = json_encode($statewiseUniversites);
?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
var centralUniversities = JSON.parse('<?php echo $centraluniversities_one;?>');
var icaruniversity = JSON.parse('<?php echo $icaruniversity_one;?>');
var nits = JSON.parse('<?php echo $nits_one;?>');
var yogas = JSON.parse('<?php echo $yogas_one;?>');
var statesarray = JSON.parse('<?php echo $states_array;?>');
</script>
<section class="meacontent" >
    <?php
    if ($this->session->flashdata('message_type') == "success") {
        ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php
    }
    if ($this->session->flashdata('message_type') == "error") {
        ?>
        <div class="alert alert-error" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php
    }
    ?>
    <div class="container" style="min-height:410px;padding-top:10px;">		
        <marquee style="margin-bottom:5px;padding-top:0;">
            Welcome <?php
            $user_data = $this->session->userdata('user_data');
            echo $user_data['fname'];
            ?> to ICCR Scholarship Portal 
        </marquee>	
        <div class="blue-heading col-md-12">
            <h3>Application Received From Students</h3>
           <?php $title = "Application Received From Students"; ?>
        
            <a href="<?php echo site_url(); ?>headquarter/dashboard" class="backbtn">
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
					<label for="inputEmail3" class="col-sm-5">Email Id</label>
					<div class="col-md-6 pdright pdleft">
						<input type="text" id="mail" name="mail" class="form-control" placeholder="Email Id"/>
					</div>
				</div>
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
				
				
			
			</div>
			<div class="filters col-md-12 form-group">
					
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Course</label>
					<div class="col-md-6 pdright pdleft">
						<select id="courses" name="courses" class="selectpicker form-control" required="true">
							<option value="">Select</option>						  
						</select>
					</div>
				</div>
					<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5 pdleft">University/Institute</label>
					<div class="col-md-6 pdright pdleft">
						<select id="university" name="university" class="selectpicker form-control" required="true">							
						 <option value="">Select</option>
						 	<?php
						 	echo '<optgroup label="State Universities">';
							 				foreach($stateuniversities as $univercity)
											{											
												if(array_key_exists($univercity['state_id'],$statewiseUniversites))
												{													
													array_push($statewiseUniversites[$univercity['state_id']],$univercity);
												}
											}	 
											foreach($statewiseUniversites as $key=>$univercity1)
											{
												if(count($univercity1)>0)
												{
													$statenames = $this->common_model->getStateById($key);
													echo '<optgroup label="&nbsp;&nbsp;&nbsp;'.$statenames[0]['name'].'" class="stt">';
													foreach($univercity1 as $uni_choice)
													{
														echo '<option value="'.$uni_choice['id'].'">'.$uni_choice['uni'].'</option>';															
													}
													echo '</optgroup>';			
												}	
											}
										    
										    echo '</optgroup>';	
										    echo '<optgroup label="Central Universities">';
											foreach($centraluniversities as $univercity_cnet)
											{								
												echo '<option value="'.$univercity_cnet['id'].'">'.$univercity_cnet['uni'].'</option>';												
										    }
											echo '</optgroup>';
											echo '<optgroup label="ICAR Universities">';
											foreach($icaruniversity as $univercity_icar)
											{								
												echo '<option value="'.$univercity_icar['id'].'">'.$univercity_icar['uni'].'</option>';												
										    }
											echo '</optgroup>';
										    echo '<optgroup label="National Institute of Technology (NIT)">';
										    foreach($nits as $univercity_nit)
											{								
												echo '<option value="'.$univercity_nit['id'].'">'.$univercity_nit['uni'].'</option>';	
										    }
											 echo '</optgroup>';
											 echo '<optgroup label="Gurus">';
						 			foreach($yogas as $univercity_yogs)
									{								
										echo '<option value="'.$univercity_yogs['id'].'">'.$univercity_yogs['uni'].'</option>';										
								    }
									echo '</optgroup>';
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
			</br></br>
				<div class="col-md-4">
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
					</div>
					
				</div>
				
				<!-----<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Regional Offices</label>
					<div class="col-md-6 pdright pdleft">
						<select id="region" name="region" class="selectpicker form-control">
							<option value="">Select</option>
						  <?php
						  $regions = $this->common_model->getAllRegions();
						  foreach($regions as $na)
						  {
						  	echo '<option value="'.$na['id'].'">'.$na['name'].'</option>';
						  }
						  ?>
						</select>
					</div>
				</div>--->
				
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Status</label>
					<div class="col-md-6 pdright pdleft">
						<select id="confirmed" name="confirmed" class="form-control" required="true">
							<option value="">Select</option>	
							<option value="10">Ayush</option>
							<option value="11">SFS to ICCR</option>
							<option value="2">ICAR</option>
							<option value="4">Fee Structure</option>
							<option value="12">Confirmed</option>
							<option value="13">Not Confirmed</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Application No</label>
					<div class="col-md-6 pdright pdleft">
						<input type="text" id="application" name="application" class="form-control"/>
					</div>
				</div>
			<div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button>
                 </div>	
			</div>
			</form>
		<div>
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>
        <table class="customTable1 table table-striped table-bordered detailpagepdf newApplication">
            <thead>
            <th>S.No.</th>				
            <th>Applicant Name</th>				
            <th>Email Id</th>
            <th>Application No.</th>
            <<th>Nomenclature</th>	
				<th>University</th>	
            <th>Scheme</th>
            <th>Country</th>
            <!-----<th>Date of Registration</th>----->
			<th>Date of Submission</th>		
			<th>View</th>
			<!-----<th>Action</th>--->
			<th>Status</th>
			<!-- <th>Download</th> -->
			 
            </thead>
            <tbody>                
            </tbody>
        </table>
        <hr/>
    </div>
	
			<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Status</h4>
                        </div>
                        <div class="modal-body">
						</div>
						
						<div class="modal-footer">
						<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
						<!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
						</div>
                    </div>
                  
                </div>
            </div>
	
</section>
<script>
var year = "<?php echo $year;?>";
    $(document).ready(function () {
    	 
    	reprottable = $('.newApplication').DataTable( {	
        "order": [[1, "desc" ]],
        "processing": true,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":"<?php echo site_url('headquarter/getNewAllApplicaitons/"+year+"')?>",
        	"type": "POST",
            "data": function ( data ) {
               data.MinDate = $('#min-date').val();
               data.MaxDate = $('#max-date').val();
			   data.ApplicantName = $('#applicant_name').val();   
               data.Mail = $('#mail').val();               
               data.Programme = $('#programmes').val();                
               data.Counrse = $('#courses').val();
               data.Universtiy = $('#university').val();
			   data.Scheme = $('#schemes').val();
			   data.Country = $('#country').val();
			   data.Region = $('#region').val();
			   data.Confirmed = $('#confirmed').val();
			   data.Application = $('#application').val();
			  
            }
        },
		        "lengthMenu": [[10, 25, 50, 100, 1000, 2000], [10, 25, 50, 100, 1000, 2000]],
        "pageLength": 10,

        dom: '<"top"Blftrip>',
        buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            className: 'btn btn-success btn-sm',
            exportOptions: {
                columns: ':visible:not(.noExport)',
                modifier: { page: 'all', search: 'applied', order: 'current' },
                format: {
                    body: function(data, row, column, node){
                        if(column === 0) return row + 1; // SN reset
                        return typeof data === 'string' ? data.replace(/(<([^>]+)>)/gi, "") : data;
                    }
                }
            }
        },
        {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            className: 'btn btn-info btn-sm',
            exportOptions: {
                columns: ':visible:not(.noExport)',
                modifier: { page: 'all', search: 'applied', order: 'current' },
                format: {
                    body: function(data, row, column, node){
                        if(column === 0) return row + 1;
                        return typeof data === 'string' ? data.replace(/(<([^>]+)>)/gi, "") : data;
                    }
                }
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf-o"></i> PDF',
            className: 'btn btn-danger btn-sm',
            orientation: 'landscape',
            pageSize: 'A3',
            exportOptions: {
                columns: ':visible:not(.noExport)',
                modifier: { page: 'all', search: 'applied', order: 'current' },
                format: {
                    body: function(data, row, column, node){
                        if(column === 0) return row + 1;
                        return typeof data === 'string' ? data.replace(/(<([^>]+)>)/gi, "") : data;
                    }
                }
            }
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> Print',
            className: 'btn btn-secondary btn-sm',
            exportOptions: {
                columns: ':visible:not(.noExport)',
                modifier: { page: 'all', search: 'applied', order: 'current' },
                format: {
                    body: function(data, row, column, node){
                        if(column === 0) return row + 1;
                        return typeof data === 'string' ? data.replace(/(<([^>]+)>)/gi, "") : data;
                    }
                }
            }
        }
    ],

         
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/images/loader.gif'></div>"}
    } );    	
    
    });
</script>
<script>
 $(document).ready(function(){
	
$('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});




// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[9] || 0; // Our date column in the table
	
	//console.log(min+'--'+max);
	
    if (
      (min == "" || max == "") ||
      (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
    ) {
      return true;
    }
    return false;
  }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change(function() {
  reprottable.draw();
});

$('#my-table_filter').hide();

 $('#btn-filter').click(function(){ //button filter event click
    reprottable.ajax.reload(null,false);  //just reload table
});
$('#btn-reset').click(function(){ //button reset event click
    $('#form-filter')[0].reset();
    reprottable.ajax.reload(null,false);  //just reload table
}); 

}); 

function openStatus(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('headquarter/openUniversityStatus')?>',
                        type: 'post',
						data:{'id':appid},
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


function printDiv(divName) {
	
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;

	window.print();
	document.body.innerHTML = originalContents;
}

</script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/buttons.dataTables.min.css">
<script src="<?php echo base_url();?>assets/site/main/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/buttons.print.min.js"></script>

<!-- PDFMake for PDF export -->
<script src="<?php echo base_url();?>assets/site/main/js/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/vfs_fonts.js"></script>

<!-- JSZip for Excel export -->
<script src="<?php echo base_url();?>assets/site/main/js/jszip.min.js"></script>
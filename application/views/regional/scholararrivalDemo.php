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
.backbtn
{
	top:-32px;
}
marquee{
	
    border: 1px solid #cecece;
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto 5px;
    padding: 7px 5px 0 !important;
    text-align: left;
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

$stateuniversities_one = str_replace("'","\'",json_encode($stateuniversities));
$centraluniversities_one = str_replace("'","\'",json_encode($centraluniversities));
$nits_one = str_replace("'","\'",json_encode($nits));
$yogas_one = str_replace("'","\'",json_encode($yogas));
$states_array = json_encode($statewiseUniversites);
?>
<script type="text/javascript">
var stateuniversities = JSON.parse('<?php echo $stateuniversities_one;?>');
var centralUniversities = JSON.parse('<?php echo $centraluniversities_one;?>');
var nits = JSON.parse('<?php echo $nits_one;?>');
var yogas = JSON.parse('<?php echo $yogas_one;?>');
var statesarray = JSON.parse('<?php echo $states_array;?>');
</script>
<section class="meacontent">
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
	<div  class="container" style="min-height:410px;padding-top:16px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>
			<div class="blue-heading col-md-12 ">
			 <h3> Travel Plan Details of Applicant</h3>
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a class="form-control lnk" style="width:129px;"   href="#" onclick = "addTravelDetails();">Add Travel Details</a>
	<a href="<?php echo site_url();?>regional/dashboard" class="backbtn">
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
						<select id="programmeroarrival" name="programmes" class="selectpicker form-control" required="true">
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
					<!-----<div class="col-md-4">
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
				</div>---->
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
			<div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button>
                 </div>	
			</div>
			
			<hr style="float: left;width:98%;"/>
		<div class="row">
		<div class="container">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>
</div>
</form>
		
		
		<table class="customTable1 table table-striped table-bordered detailpagepdf newApplication">
			<thead>
				<th>S.No.</th>
				<th>Applicant Name</th>
				<th>Email Id</th>
				<th>Course</th>
				<th>Scheme</th>
				<th>University</th>
				<th>Country</th>	
				<th>Arrival Date By Mission</th>
				<th>Travel Plan By Mission/Ro</th>				
				<th>Status</th>	
				<th>Year</th>
				<th>View History</th>								
			</thead>
			<tbody>
			
			</tbody>
		</table>
		<hr/>
			  <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">STUDENT TRAVEL DETAILS</h4>
                        </div>
                        <div class="modal-body">
     
							</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-primary submitBtn" onclick="submitTravelForm()">SUBMIT</button>
	<a href="#" class="btn" data-dismiss="modal">Close</a>
	</div>
                    </div>
                  
                </div>
            </div>
	</div>
</section>
	<script type='text/javascript'>
	//Edit Expend
function addTravelDetails(appid){
	// AJAX request
                    $.ajax({
                        url: '<?php echo site_url('regional/getTravelStudents')?>',
                        type: 'post',
                        success: function(response){ 
                            $('.modal-body').html(response); 
                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}

function submitTravelForm1(){
	var app_no = $('#app_no').val();
	alert(app_no);
	
var urls = ["<?php echo site_url('regional/isCheckDetails')?>", "<?php echo site_url('regional/isUnderTaking')?>","<?php echo site_url('regional/isAlreadytTravelPlan')?>"];
$.each(urls, function(index, value) {
    $.ajax({
        global: false,
        type: 'POST',
        url: value,
        dataType: 'json',
        data:'contactFrmSubmit=1&app_no='+app_no,
        success: function(response) {
            switch(value) {
                case "<?php echo site_url('regional/isCheckDetails')?>":
				alert(JSON.stringify(response));
				if(response.status == true){
				location.href = "<?php echo site_url('regional/createTravelplan/')?>"+app_no;
				} 
				else
				{
				 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Sorry Details Not Found..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				 //location.href = "<?php echo site_url('regional/scholararrival')?>";
				}
                    break;
                case "<?php echo site_url('regional/isUnderTaking')?>":
				if(response.status == true){
				location.href = "<?php echo site_url('regional/createTravelplan/')?>"+app_no;
				} 
				else
				{
				 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Sorry Undertaking Not Found..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				 //location.href = "<?php echo site_url('regional/scholararrival')?>";
				}
                    break;
					case "<?php echo site_url('regional/isAlreadytTravelPlan')?>":
				if(response.status == true){
				location.href = "<?php echo site_url('regional/createTravelplan/')?>"+app_no;
				} 
				else
				{
				 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Sorry travel plan already uploaded..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				 //location.href = "<?php echo site_url('regional/scholararrival')?>";
				}
				 break;
            }
        },
        error: function (e, request, status, error) {
            if (e.status == 500) {
                alert("500 error");
            }
        }
    });
});
}
function submitTravelForm(){
	var app_no = $('#app_no').val();
	     $.ajax({
            type:'POST',
			//url: '<?php echo site_url('regional/isCheckDetails')?>',
            url: '<?php echo site_url('regional/isAlreadytTravelPlan')?>',
            data:'contactFrmSubmit=1&app_no='+app_no,
			dataType: "json",
            success:function(response){
				//alert(JSON.stringify(response.status));
				if(response.status == false){
				location.href = "<?php echo site_url('regional/createTravelplan/')?>"+app_no;
				} 
				else
				{
				 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Sorry Travel Plan Already uploaded..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				 //location.href = "<?php echo site_url('regional/scholararrival')?>";
				}
			}
			
        });
}


 $(document).ready(function(){
	//alert('ok');
	 reprottable = $('.newApplication').DataTable( {	
        "order": [[1, "desc" ]],
        "processing": true,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":"<?php echo site_url('regional/getScolarArrival')?>",
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
            }
        },
         
         oLanguage: {sProcessing: "<div id='loaderlogs'><img src='"+baseURL+"/assets/site/main/images/loader.gif'></div>"}
    } );
	
	
$('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});

// Set up your table


// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
	  alert('ok');
    var min = $('#min-date').val();
	alert(min);
    var max = $('#max-date').val();
	alert(max);
    var createdAt = data[10] || 0; // Our date column in the table
	
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







</script>
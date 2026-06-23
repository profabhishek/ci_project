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
  <div class="content-wrapper">
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:15px;">	
		
			<div class="blue-heading col-md-12 ">
				 <h3>Filter Applications by:</h3>
				 <form method="post" action="<?php echo base_url();?>admin/downloadpdf/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
			">
					  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
					   <input id="pdftitle" name="pdftitle" value="<?php echo $title; ?>" type="hidden"/>
					  <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value="PDF"/>	
					  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
				</form>
				
        </a>
			</div>
			<form id="form-filter" class="form-horizontal">
			

			<div class="filters col-md-12 form-group">
			
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Admission Year</label>
					<div class="col-md-6 pdright pdleft">
						<select class="form-control" id="fy_old_one" name="fy_old_one">
				
					<option value="">----Select----</option>
					<option value="2018-2019">2018-2019</option>
					<option value="2019-2020">2019-2020</option>
					<option value="2020-2021">2020-2021</option>
					<option value="2021-2022">2021-2022</option>
					<option value="2018-2019">2022-2023</option>
					<option value="2019-2020">2023-2024</option>
					<option value="2020-2021">2024-2025</option>
				</select>
					</div>
				</div>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Financial Year</label>
					<div class="col-md-6 pdright pdleft">
						<select class="form-control" id="fyrept" name="fyrept">
					<option value="">Financial Year</option>
					<?php 
				$current = date('Y-m-d');
                $current1 = date('Y-m-d', strtotime('-4 years'));
				$CI =& get_instance();
                $ofy = $CI->getFinancialYears($current1, 5);
					
					foreach($ofy as $fyy)
					{
						echo '<option value="'.$fyy.'">'.$fyy.'</option>';
					}
					?>
				</select>
					</div>
				</div>
			<div
			<div class="col-md-4">
			<label for="inputEmail3" class="col-sm-5">Expenditure</label>
			<div class="col-md-6 pdright pdleft">
				<select class="form-control" id="expenditurefilter" name="expenditurefilter">
					<option value="1">All</option>
					<option value="2">Released</option>
				</select>
				</div>
			</div>
			</br>
			</br>
			</br>
			</br>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Applicant Name</label>
					<div class="col-md-6 pdright pdleft">
						<input type="text" id="applicant_name" name="applicant_name" class="form-control"/>
					</div>
				</div>
				
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Application No</label>
					<div class="col-md-6 pdright pdleft">
						<input type="text" id="application" name="application" class="form-control"/>
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
					<label for="inputEmail3" class="col-sm-5">Course</label>
					<div class="col-md-6 pdright pdleft">
						<select id="courses" name="courses" class="selectpicker form-control" required="true">
							<option value="">Select</option>						  
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
					<label for="inputEmail3" class="col-sm-5">Schemes</label>
					<div class="col-md-6 pdright pdleft">
						<select id="schemes" name="schemes" class="selectpicker form-control" required="true">
							<option value="">Select</option>
						  <?php
						 
						  $schems = $this->common_model->getAllSchemes();
						  //echo "<pre>";print_r($schems);die;
						  foreach($schems as $na)
						  {
						  						
						  		
									
							echo '<option value="'.$na['id'].'">'.$na['scheme_name'].'</option>';
										
								
								
							
						  }
						  ?>
						</select>
					</div>
				</div>
							
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Regional Offices</label>
					<div class="col-md-6 pdright pdleft">
						<select id="region" name="region" class="selectpicker form-control" required="true">
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
				</div>
				</br></br></br></br>
				<div class="col-md-4">
					<label for="inputEmail3" class="col-sm-5">Status</label>
					<div class="col-md-6 pdright pdleft">
						<select id="confirmed" name="confirmed" class="form-control" required="true">
							<option value="">Select</option>	
							<option value="1">Acceptance</option>
							<option value="2">Decline</option>
						</select>
					</div>
				</div>
				
			</div>	
			

		<hr style="float: left;width:98%;"/>
		<div class="row">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" name="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" name="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
  
  <div class="filters col-md-12 form-group">
				<div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button></br>
					
					 <button type="button" id="btn-download-filter" class="btn btn-default col-sm-3 sbmt">Downlaod</button>
					
					 <!-----<button type="button" id="btn-download-filter-pdf" class="btn btn-default col-sm-3 sbmt">Pdf</button>--->
                 </div>
			</div>
</div>
</form>
		<table id="myreporttable" class="table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>	
				<th>Application No</th>	
				<th>Applicant Name</th>						
				<th>Gender</th>							
				<th>Country</th>
				<th>Programme</th>
				<th>Regional Office</th>
				<th>Course</th>
				<th>University/Institute</th>
				<th>Scheme</th>
				<th>Year</th>	
				<th>Expenditure</th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($arrived)>0)
				{
					foreach($arrived as $app)
					{
						?>
						<tr>
						
						</tr>
						<?php	
						$counter++;	
					}
				}
				
				?>
			</tbody>
		</table>
	</div>
</section>
</div>
<script type="text/javascript">
		

$(document).ready(function() {
 	 table = $('#myreporttable').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "searching": false,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/getReports')?>",
            "type": "POST",
            "data": function ( data ) {
				data.MinDate = $('#min-date').val();
                data.MaxDate = $('#max-date').val();
                data.ApplicantName = $('#applicant_name').val();
				data.Application = $('#application').val();
                data.Gender = $('#gender').val();
                data.Country = $('#country').val();
                data.Programme = $('#programmes').val();
                data.Region = $('#region').val();
                data.Counrse = $('#courses').val();
                data.Universtiy = $('#university').val();
                data.Scheme = $('#schemes').val();
				data.Confirmed = $('#confirmed').val();
				data.ExpenditureFilter = $('#expenditurefilter').val();
				data.FinancialYear = $('#fy_old_one').val();
            }
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 $('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});
    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload(null,false);  //just reload table
    });
	$('#btn-download-filter').click(function(){ 
	//button filter event click
	//alert('ok');
	  $.ajax({
         url: "<?php echo site_url('admin/downloadTotalConfirmation')?>",
         type:"POST",
         async:false,
         dataType:"json",
         data:$("#form-filter").serialize(),
         timeout:3000,
         success:function(data){
			//alert(JSON.stringify(data));
           var $a = $("<a>");
           $a.attr("href",data.file);
           $("body").append($a);
           $a.attr("download", "file.xls");
           $a[0].click();
           $a.remove();
         },
         error:function(){
          //console.log(data);
        }
    }); 
	/* var form1 = $('#form-filter');
	form1.attr('action',"<?php echo site_url('admin/downloadTotalConfirmation');?>");
        form1.attr('method','POST');
        form1.submit(); */
	
       
    });
	$('#btn-download-filter-pdf').click(function(){ 
	//button filter event click
	//alert('ok');
	  $.ajax({
         url: "<?php echo site_url('admin/downloadTotalConfirmationpdfs')?>",
         type:"POST",
         async:false,
         dataType:"json",
         data:$("#form-filter").serialize(),
         timeout:3000,
         success:function(data){
			 alert('ok');
			console.log(JSON.stringify(data));
           var $a = $("<a>");
           $a.attr("href",data.file);
           $("body").append($a);
           $a.attr("download", "file.pdf");
           $a[0].click();
           $a.remove();
         },
         error:function(){
          console.log(data);
        }
    }); 
	/* var form1 = $('#form-filter');
	form1.attr('action',"<?php echo site_url('admin/downloadTotalConfirmation');?>");
        form1.attr('method','POST');
        form1.submit(); */
	
       
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload(null,false);  //just reload table
    });   
});
</script>
<script type="text/javascript">
	function showExpenditure(id)
	{
		var fy = $('#fy_old').val();
		if(fy != "")
		{
			location.href = baseURL + "admin/expenditureReportofStudent/" + id + "/" + fy;
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
			location.href = baseURL + "admin/expenditureReportofStudent/" + id + "/" + fy;
		}
		else
		{
			 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Select Financial Year First."  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
		}
	}
</script>
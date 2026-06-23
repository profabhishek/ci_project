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
.lnk
{
	 background: #747474 none repeat scroll 0 0;
    border: 1px solid;
    border-radius: 38px;
    box-shadow: 0 0 5px #fff inset;
    color: #fff;
    cursor: pointer;
    float: right;
    font-size: 11px;
    font-weight: bold;
    height: 30px;
    position: relative;
    right: 132px;
    top: -34px;
    width: 205px;
}
.lnk:hover
{
	background: #747474 none repeat scroll 0 0;
    color: #fff;
   
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
			<h4 style="text-align:center;color:red;font-weight:bold;font-size:15px;font-family:arial;">For Enabling Payment Detail Link of Applicant, Please Update Course Duration & City in Academic Detail of Applicant. </h4>
			
			<h3 style="text-align:center;color:red;font-weight:bold;font-size:15px;font-family:arial;">Fund Balance for Current Quarter (<?php echo getStartOfQuarter() .' to '.getEndOfQuarter(); ?>): <?php if(count($quarterbalance)>0) echo $quarterbalance[0]['amount_released']; else echo "0 Balance"; ?></h3>
		<div class="blue-heading col-md-12 ">
			 <h3>New Applicant Expenditure Statement</h3>			 
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;width:120px;">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
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
				
				
			</br></br>
		
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
		<table id="tbl_schrls" class="table table-striped table-bordered detailpagepdf newApplication">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>
				<th>Email Id</th>
				<th>Reference No</th>
				<th>Applicant Name</th>
				<th>University</th>
				<th>Country</th>
				<th>Arrival Date</th>								
				<th>Payment Details</th>				
			</thead>
			<tbody>
				
			</tbody>
		</table>
		<hr/>
		
		<div class="blue-heading col-md-12 ">
			 <h3>Expenditure Statement For Live Applicant </h3>
			 <!--<a class="form-control lnk"  href="<?php echo site_url();?>regional/regionalExpenditureForOldUser">Payment Details For Old Student</a>-->
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;width:120px;">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
		</div>
		
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				<th>Application No</th>
				
				<th>Applicant Name</th>
				
				<th>University</th>
				
				<th>Country</th>
												
				<th>Payment Details</th>
				
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($oldarrived)>0)
				{
					foreach($oldarrived as $app)
					{
						
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['application_id'];?></td>						
						<td><?php echo $app['name'];?></td>						
						<td><?php $counry = $this->common_model->getUniversityById($app['universty_choice']); echo $counry[0]['name'];?></td>	
						<td><?php $counry = $this->common_model->getCountryById($app['country']); echo $counry[0]['country_name'];?>
						</td>
						<!--<td><?php echo $app['email'];?></td>-->
						
						<td>
						<?php
						$status = $this->common_model->getScholarshipStatusofApplicant($app['application_id']);
						
						if(count($status) <= 0)
						{
							?>
							<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureForOldUser/<?php echo $app['application_id'];?>">Payment Details</a>
							<?php
						}
						elseif(count($status)>0)
						{
							if($status[0]['scholarship_status'] != -1)
							{
								if($status[0]['scholarship_status'] == 2)
								{
									?>
								<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Detained"/>
								<?php
								}
								elseif($status[0]['scholarship_status'] == 4)
								{
									?>
								<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Finally Passed"/>
								<?php
								}
								else
								{
								?>
								<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/regionalExpenditureForOldUser/<?php echo $app['application_id'];?>">Payment Details</a>
								<?php	
								}	
							}
						}
						?>
							
						</td>
						
						</tr>
						<?php	
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
		<hr/>
	</div>
</section>
	<?php
function getStartOfQuarter()
{
     return date(sprintf('01-%s-Y', floor((date('n') - 1) / 3) * 3 + 1));
}

function getEndOfQuarter()
{
    return date(sprintf('t-%s-Y', floor((date('n') + 2) / 3) * 3));
}
	?>
	
<script>
 $(document).ready(function(){
	
	 reprottable = $('.newApplication').DataTable( {	
        "order": [[1, "desc" ]],
        "processing": true,
        "searching":false,
        "serverSide": true,
        "ajax": {
        	"url":"<?php echo site_url('regional/getExpenditure')?>",
        	"type": "POST",
            "data": function ( data ) {
               data.MinDate = $('#min-date').val();
               data.MaxDate = $('#max-date').val();
			   data.ApplicantName = $('#applicant_name').val();   
               data.Mail = $('#mail').val(); 			   
               data.Universtiy = $('#university').val();
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
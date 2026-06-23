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
<script type="text/javascript">
	function showExpenditureList(id)
	{
		var fy = $('#fyrept').val();
		if(fy != "")
		{
			location.href = baseURL + "regional/expenditureReportofStudent/" + id + "/" + fy;
		}
		else
		{
			 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Select Financial Year First."  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
		}
	}
</script>
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
	<div class="container" style="min-height:410px;padding-top:10px;">		
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome <?php
			$user_data = $this->session->userdata('user_data');
			 echo $user_data['fname'];?> to ICCR Scholarship Portal 
	</marquee>	
		<div class="blue-heading col-md-12">
			 <h3>Admitt Student</h3>
			 <form method="post" action="<?php echo base_url();?>headquarter/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
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
					<label for="inputEmail3" class="col-sm-5">Financial Year</label>
					<div class="col-md-6 pdright pdleft">
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
				</div>
			<div class="filters col-md-12 form-group">
				<div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary col-sm-3 sbmt" style="margin-right:10px;">Filter</button>
                    &nbsp;&nbsp;&nbsp;
                    <!-----<button type="button" id="btn-reset" class="btn btn-default col-sm-3 sbmt">Reset</button>---->
                 </div>
			</div>
			
			</div>
			</form>
		<div class="container">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>
		<table id="tbl_schrls" class="customTable1 table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>				
				<th>Applicant Name</th>				
				<th>Email Id</th>
				<th>Course</th>
				<th>Scheme</th>
				<th>University</th>								
				<th>Country </th>	
				<th>Year</th>
				<th>Status </th>
				<th>Expenditure</th>
                <th>Action</th>					
			</thead>
			   <tbody>
                <?php
                $counter = 1;

                if (count($totalAdmitt) > 0) {
                    foreach ($totalAdmitt as $app) {
                        $response = $this->common_model->getUniversityResponses($app['application_no']);
                        $resp = explode(',', $response[0]['response']);
                        if ($response[0]['response'] != "2,2,2") {
                            ?>
                            <tr>
                                <td><?php echo $counter; ?></td>					
                                <td><?php echo $app['fullname']; ?></td>
                                <td><?php echo $app['email']; ?></td>	
                                <!---<td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
                echo $sch[0]['scheme_name'];
                            ?></td>--->		
                                <td><?php
                                    $unii = 0;
                                    $resp = explode(',', $response[0]['response']);
                                    $cnt = 0;
                                    $uniar = array();
                                    $universties = explode(',', $response[0]['University']);
                                    foreach ($resp as $res) {
                                        if ($res == 1) {
                                            $unii = $universties[$cnt];
                                            $uniar[$universties[$cnt]] = $res;
                                        } else {
                                            $uniar[$universties[$cnt]] = $res;
                                        }
                                        $cnt++;
                                    }
									$coursearr = array();
                                    $course = "";
									//$courseid = "";
                                    foreach ($uniar as $key => $u) {
                                        $c = $this->common_model->getCourseDetails($app['application_no'], $key);
                                        //print_r( $this->common_model->getCourseDetails($app['application_no'],$key));
                                        $course .= $c['course_name'];
										//$courseid.= $c['course_id'];
                                        if ($c['subject'] != "")
                                            $course .= $c['subject'];
                                        $course .= "<br/>";
										$coursearr[]=$c['course_id'];
										
										
                                    }
									//echo "<pre>";print_r($coursearr);
									//echo "<pre>";print_r($coursearr[0]);
                                    echo $course;
                                    ?></td>
                              
								<td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
                            echo $sch[0]['scheme_name'];
                            ?></td>
                                <td>
								<?php $data = $this->common_model->getConfirmationofApplicationIds($app['application_id']);
							     $uni = $this->common_model->getUniversityById($data[0]->regional_university);
				                   echo $uni[0]['name'];
				 
				                    ?>
				                 </td>						

                           
                                     <td><?php echo $app['country_name']; ?></td>	
                          					
                                  <td><?php 
                                    $date1 = strtotime($app['created']);	
								echo date('Y-m-d',$date1);?>
                                </td>
                                <td>
								
								<?php 
								
								$sts = $this->common_model->getApplicationUnderStatus($app['status']);
                                 echo $sts[0]['status']?>
                                    			
                               </td>
					<!---<td>
								<?php 
								$expenditureDatail = $this->common_model->isExpenditureReady($app['application_no']);
								
							if(count($expenditureDatail)>0)
												{		
?>											
						<a class='form-control sbmt1' style='height:35px;width:140px;' href='javascript:void(0);' onclick=showExpenditureList(<?php echo $app['application_no']?>);>View Details</a>
						<?php
									}
							else
							{
								echo "Not Released";
							}
					?>
				</td>--->
				
				
				<td>
				
				<?php
				
					$expenditureDatail = $this->common_model->isExpenditureReady($app['application_no']);
				$sts = "";
				if(count($expenditureDatail)>0)
				{								
				
					$sts ="<a class='form-control sbmt1' style='height:35px;width:140px;' href='javascript:void(0);' onclick=showExpenditureList('".$app['application_no']."');>View Details</a>";
	
				}
				else
				{
					$sts = "Not Released";
				}
				echo $sts;
				?>
				</td>
			
								<td>
							
								 <a class="form-control sbmt" style="height:42px;width:140px;" href="<?php echo site_url(); ?>regional/scholarStatusView/<?php echo $app['application_no']; ?>" target = "__blank">View</a>
								
                                </td>						
                            </tr>
            <?php
            $counter++;
        }
    }
}
?>
            </tbody>
		</table>
		<hr/>
	</div>
</section>
	<script>
$(document).ready(function(){
	
$('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});

// Set up your table
table = $('.customTable1').DataTable({
  paging: true,
  info: true
});

// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[7] || 0; // Our date column in the table

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
  table.draw();
});

$('#my-table_filter').hide();
});
</script>
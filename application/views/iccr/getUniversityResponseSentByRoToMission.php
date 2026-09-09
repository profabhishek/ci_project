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
<script>
    $(document).ready(function () {
        $('#example').dataTable({
            destroy: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });

</script>
<section class="meacontent">

    <div  class="container" style="min-height:410px;padding-top:15px;">	
        <marquee style="margin-bottom:5px;padding-top:0;">
            Welcome <?php
            $user_data = $this->session->userdata('user_data');
            echo $user_data['fname'];
            ?> to ICCR Scholarship Portal 
        </marquee>
        <div class="blue-heading col-md-12 ">
            <h3>University Response Send by HQ to Mission</h3>
            <?php $title = "University Response Send by HQ to Mission"; ?>
            <form method="post" action="<?php echo base_url(); ?>headquarter/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;">
                <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
                <input id="pdftitle" name="pdftitle" value="<?php echo $title; ?>" type="hidden"/>
                <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
            </form>
            <a href="<?php echo site_url(); ?>headquarter/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
		
			<div class="container">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>
        <table  id="example" class="customTable1 table table-striped table-bordered detailpagepdf">
            <thead>
            <th>S.No.</th>				
            <th>Applicant Name</th>
			<th>Male</th>
			<!--<th>Female</th>--->
            <!--<th>Email Id</th>-->
            <th>Country</th>
            <th>Scheme</th>
            <th>Course</th>				
            <th>University</th>
            <th>Region</th>
            <th>Remarks by HQ</th>	
            <th>University Status</th>
            <th>Year</th>			
            <th>Forward to Mission </th>
            <th>ICCR Letter</th>
            <th>University Approval Letter</th>
			<th>Date</th>
            </thead>
            <tbody>
                <?php
                $counter = 1;

                if (count($responseSetByHqToMission) > 0) {
                    foreach ($responseSetByHqToMission as $app) {
                        $response = $this->common_model->getUniversityResponses($app['application_no']);
                        $resp = explode(',', $response[0]['response']);
                        if ($response[0]['response'] != "2,2,2") {
                            ?>
                            <tr>
                                <td><?php echo $counter; ?></td>					
                                <td><?php echo $app['fullname']; ?></td>
								<td>
								<?php if($app['gender'] == 1) 
									echo "Male";
								?>
								</td>
								<!--<td>
								<?php if($app['gender'] == 2) 
									echo "Female";
								?>
								</td>-->
                                <!--<td><?php echo $app['email']; ?></td>-->
                                <td><?php echo $app['country_name']; ?></td>		
                                <td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
                echo $sch[0]['scheme_name'];
                            ?></td>		
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

                                <td><?php
                                    $universties = explode(',', $response[0]['University']);
                                    foreach ($universties as $uni) {
                                        $u = $this->common_model->getUniversityById($uni);
                                        echo $u[0]['name'];
                                        echo "<br/>";
                                    }
                                    ?></td>						

                                <td>
                                    <?php
                                    $regions = explode(',', $response[0]['regional_office']);
                                    foreach ($regions as $reg) {
                                        $rg = $this->common_model->getRegionById($reg);
                                        echo $rg[0]['name'];
                                        echo "<br/>";
                                    }
                                    ?>	
                                </td>					
                                  <td>
                                    <?php
                                    if($app['course'] !=""){
                                    echo $app['course'];
                                    }else{
                                        echo 'NA';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $resp = explode(',', $response[0]['response']);
                                    foreach ($resp as $res) {
                                        if ($res == 1)
                                            echo "Accepted";
                                        elseif ($res == 2)
                                            echo "Declined";

                                        echo "<br/>";
                                    }
                                    ?>							
                                </td>
								<td><?php $date = date_create($app['created']);
							$array =  (array) $date;
							//print_r($array);
						?>
						<?php echo date("Y-m-d", strtotime($array['date']));?></td>	
						<!-----<td><?php echo date("Y-m-d", $app['region_one_status_date']); ?></td>--->
                                <td>						
                                    <?php
                                    if ($app['status'] == 4) {
                                        $userdata = $this->session->userdata('user_data');
                                        $division = $userdata['state'];
                                        if ($division == 1 || $division == 11 || $division == 12) {
                                            foreach ($uniar as $keyid => $respppp) {
                                                if ($respppp == 1) {
                                                    ?>
                                                    <a class="form-control sbmt" style="height:42px;width:140px;" href="<?php echo site_url(); ?>headquarter/beforeconfirmtoMission/<?php echo $app['application_no']; ?>/<?php echo $keyid; ?>">(A) Forward To Mission</a>

                                                    <?php
                                                } elseif ($respppp == 2) {
                                                    ?>
                                                    <a class="form-control sbmt" style="height:42px;width:140px;" href="<?php echo site_url(); ?>headquarter/beforerejectiontoMission/<?php echo $app['application_no']; ?>/<?php echo $keyid; ?>">(R) Forward To Mission</a>

                                                    <?php
                                                }
                                            }
                                        } else {
                                            echo "Not Authorised";
                                        }
                                    } elseif ($app['status'] >= 10) {
                                        echo "Forwarded to Mission";
                                    }
                                    ?>
                                </td>


                                <td>

                                    <?php
                                    $sts = 0;
                                    //echo '<pre>';print_r($response);print_r($app);
                                    foreach ($response as $resp) {
                                       if ($resp['University'] == $app['universty_choice_three'] || $resp['University'] == $app['universty_choice_two'] || $resp['University'] == $app['universty_choice']) {
                                            $sts++;
                                            if ($resp['response'] == 1) {
                                                ?>
                                                <a target="_blank" href="<?php echo site_url(); ?>headquarter/confirmationReceivedWithNewFormat/<?php echo $app['application_no']; ?>/<?php echo $resp['University']; ?>" target="_blank">Download</a>

                        <?php
                    } elseif ($resp['response'] == 2) {
                        ?>
                                                <a target="_blank" href="<?php echo site_url(); ?>headquarter/confirmationNotReceivedWithFormat/<?php echo $app['application_no']; ?>/<?php echo $resp['University']; ?>" target="_blank">Download</a>
                                                <?php
                                            }
                                        }
                                    }
                                    if ($sts == 0) {
                                        echo "NA";
                                    }
                                    ?>

                                </td>

                               <td>
                               <?php 
                               if(!empty($app['region_one_doc'])){
                               ?>
                                 <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $app['region_one_doc']; ?>" target="_blank">Download</a>
                               
                                <?php
                               } else {
                                echo "NA";
                                }
                               ?>   
                                </td>
								<td><?php 
								

								   if(!empty($app['iccr_status_date'])){
								 echo gmdate("Y-m-d", $app['iccr_status_date']);
								   }else
								   {
									   echo "NA";
								   }
								
								?></td>
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
  info: true,
  dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
});

// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[10] || 0; // Our date column in the table

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
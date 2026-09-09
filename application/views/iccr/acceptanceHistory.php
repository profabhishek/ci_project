<style type="text/css">
    .tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
    .form_head{float:none;height:132px;margin:0 auto;text-align:center;}
    .form_head img{width:32px;}
    .form_head h3{height:33px;margin:0;width:100%;}
    .form_head h5{margin:0 auto;}
    .caps{text-transform:uppercase;}
    .prfl{border:4px double #cecece;height:178px;width:159px;text-align: center;padding:0;}
    .prfl img{;margin-bottom:8px;}
    .note{font-size: 10px;font-weight:normal;margin-left:15px;}
    .note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
    .note1{font-size: 13px;font-weight:normal;margin-left:0;}
    .undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
    #fbl_main tbody tr td:first-child{
        width: 279px !important;
    }
    optgroup[label]{ color: #4e7a9f;
                     font-size: 20px;
                     padding-left: 10px;
                     padding-top: 10px;
                     text-decoration: underline;}
    optgroup option{color:#747474; font-size: 14px;}
</style>
<section class="meacontent">
    <div class="col-xs-10 form_head">
        <img src="<?php echo site_url(); ?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
        <h3 class="text-center caps">Application Details For Scholarship through ICCR</h3>
        <h5 class="text-center">FILLED BY APPLICANT</h5>
    </div>

    <div  class="container" style="min-height:410px;padding:0px;">
        <div class="tab-content detailpagepdf">
            <div id="home" class="tab-pane fade in active">

                <div class="box-body">
                    <div class="col-xs-3 prfl pull-right" >
					<?php

$userd = $this->common_model->getUserInfo(!empty($applicaitonStepOne) ? $applicaitonStepOne[0]['uid'] : null);
//echo "<pre>";print_r($userd);die;

          				if(empty($userd) || $userd->dir == "")
						{
							?>
							<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
							<?php
						}
						else
						{
							if(file_exists($userd->dir.'/'. $userImage))
							{
								?>
							<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?><?php echo $userd->dir.'/'. $userImage; ?>"/>
							<?php
							}
							else{
								?>
							<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
							<?php
							}

						}
              		?>
                    </div>
                    <div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">
                        <table id="fbl_main" style="width: 100%;">

                            <tbody>
                                <tr>
                                    <td style="font-weight:bold;"><label id="lbl" style="">Application Made Through</label>				</td>
                                    <td colspan="2"><label>:&nbsp;&nbsp;<?php
                        foreach ($missions as $mission) {
                            if (!empty($applicaitonStepThree)) {
                                if ($applicaitonStepThree[0]['application_through'] == $mission['id']) {
                                    echo '</b> ' . $mission['mission_type'] . ' ' . $mission['mission_name'] . ', ' . $mission['country_name'];
                                }
                            }
                        }
                        ?>	</label></td>
                                </tr>
                                <tr >
                                    <td style="height:35px;font-weight:bold;"><label>1. Full name (IN BLOCK LETTERS)</label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                            $title = '';
                                            if (count($applicaitonStepOne) > 0) {
                                                $title = $applicaitonStepOne[0]['student_title'];
                                            }
                                            if ($title == 1) {
                                                echo 'Mr.';
                                            } elseif ($title == 2) {
                                                echo 'Mrs';
                                            }
                                            ?>
                                        <?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['fullname']; ?>	</td>
                                </tr>
                                <tr >
                                    <td style="font-weight:bold;height: 35px;"><label>2. Gender</label></td>
                                    <td>:&nbsp;&nbsp;<?php
                                        $title = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $title = $applicaitonStepOne[0]['gender'];
                                        }
                                        if ($title == 1) {
                                            echo 'Male';
                                        } elseif ($title == 2) {
                                            echo 'Female';
                                        }
                                        ?></td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>3. Date of Birth</label></td>
                                    <td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['dob']; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>4. Email</label></td>
                                    <td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['email']; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>5. Mobile/Phone</label></td>
                                    <td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['phone_number']; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>6. Country</label></td>
                                    <td>:&nbsp;&nbsp;<?php
                                        $nationalities = $this->common_model->getCountries();
                                        foreach ($nationalities as $na) {
                                            if (!empty($applicaitonStepOne)) {
                                                if ($applicaitonStepOne[0]['nationality'] == $na['id']) {
                                                    echo $na['country_name'];
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:35px;max-width:120px">
                                        <table style="width:100%;" id="tbl_course">
                                            <thead>
                                            <th>7. Level of Programme</th>
                                        <?php
                                        if (count($applicaitonStepOne) > 0 && ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 9)) {
                                            ?>
                                                <th>Course Type </th>
                                            <?php
                                        }
                                        ?>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php
                                        $programme = $this->common_model->getAllProgramme();
                                        foreach ($programme as $program) {
                                            if (!empty($applicaitonStepOne)) {
                                                if ($applicaitonStepOne[0]['programme'] == $program['id']) {
                                                    echo $program['name'];
                                                }
                                            }
                                        }
                                        ?></td>
                                                    <td>
                                            <?php
                                            $courseType = $this->common_model->getAllCourseType();
                                            foreach ($courseType as $ctype) {
                                                if (!empty($applicaitonStepOne)) {
                                                    if ($applicaitonStepOne[0]['course_type'] == $ctype['id']) {
                                                        echo $ctype['course_type'];
                                                    }
                                                }
                                            }
                                            ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>



                            </tbody>
                        </table>

                    </div>
                    <div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">

                    </div>

                    <!-- /.box-body -->

                </div>
            </div>	<br><hr>
            <div id="step3" class="tab-pane fade in active">
            <label>8. Confirmation Status</label>

<?php
$response = $this->common_model->getconfirmationDataByMission($this->uri->segment(3));
//echo "<pre>";print_r($response);die;
?>

                <table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th >University Name</th>
                    <th >University Status</th>
                    <th >University Letter</th>
                    <th >ICCR Letter</th>
					<th >Acceptance</th>
					<th >Medical Fitness Certificate</th>
                    </thead>
                    <tbody>
					<?php if (!empty($response)) { ?>
                        <tr>
                            <td>
                <?php $university_first = !empty($response[0]['regional_university']) ? $this->common_model->getFinalUniversityById($response[0]['regional_university']) : [];
                echo !empty($university_first) ? $university_first[0]['name'] : 'NA'; ?></td>
                            <td>
                <?php
                $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $response[0]['regional_university']) {
                        $sts++;
                        if ($resp['university_is_accept'] == 1) {
                            echo "Confirmed";
                        } elseif ($resp['university_is_accept'] == 2) {
                            echo "Not Confirmed";
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
$sts = 0;
foreach ($response as $resp) {
    if ($resp['regional_university'] == $response[0]['regional_university']) {
        $sts++;
        if ($resp['university_is_accept'] == 1) {

			$file_path_un = null;
			foreach (array(date('Y'), date('Y')-1, date('Y')-2) as $ua_year) {
				$ua_candidate = './'.$ua_year.'/university_approval/'.$resp['region_one_doc'];
				if (file_exists($ua_candidate)) {
					$file_path_un = $ua_candidate;
					break;
				}
			}

			if($file_path_un){
				if(strpos($resp['region_one_doc'],'.pdf')){
							 $output = '<a href="'.site_url().'headquarter/downloadDocs/'.base64url_encode($file_path_un).'" target = "_blank">Download</a>';
						   }
                            else {
						     $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
				            $output = '<a download="'.rand().time().'" href="data:'.$mime_type.';base64,'.$data.'" target = "_blank">Download</a>';

							}
							echo $output;
							}

            else { ?>
				 <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>

			<?php }
			?>
                <?php
                    } elseif ($resp['university_is_accept'] == 2) {
                        $file_path_un2 = null;
                        foreach (array(date('Y'), date('Y')-1, date('Y')-2) as $ua_year) {
                            $ua_candidate = './'.$ua_year.'/university_approval/'.$resp['region_one_doc'];
                            if (file_exists($ua_candidate)) {
                                $file_path_un2 = $ua_candidate;
                                break;
                            }
                        }
                        if ($file_path_un2) {
                ?>
                <a href="<?php echo site_url().'headquarter/downloadDocs/'.base64url_encode($file_path_un2); ?>" target="_blank">Download</a>
                <?php
                        } else {
                ?>
                <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
                <?php
                        }
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
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $response[0]['regional_university']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>headquarter/confirmationReceivedWithNewFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            echo "Not Confirmed";
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
								$mappingData= $this->common_model->getMappingData($this->uri->segment(3));
                              //echo "<pre>";print_r($mappingData);
                                   if(!empty($mappingData) && $mappingData[0]['mission_status'] == 1 && $mappingData[0]['scholar_acceptance'] == 1) {
                                        if ($response[0]['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>headquarter/undertakingFromStudent/<?php echo $response[0]['application_id']; ?>/<?php echo $response[0]['regional_university']; ?>" target="_blank"><span class = "label label-success">Download</span></a>

                                            <?php
                                        } else {
                                            echo "NA";
                                        }
                                    }
									else
									{
										echo "NA";
									}

                                ?>

                            </td>
							<td>
                                <?php
									$currentyear = date('Y');
                                   if(!empty($mappingData) && $mappingData[0]['mission_status'] == 1 && $mappingData[0]['scholar_acceptance'] == 1) {
                                        if ($response[0]['university_is_accept'] == 1) {
								  $file_path_un = FCPATH.$currentyear.'/medical_fitness/'.$mappingData[0]['medical_fitness'];
                                            ?>
                                            <a target="_blank" href="<?php echo site_url() . 'headquarter/downloadDocs/' . base64url_encode($file_path_un); ?>" target="_blank"><span class = "label label-success">Download / Print</span></a>

                                            <?php
                                        } else {
											echo "NA";
										}
                                    }
									else
									{
										echo "NA";
									}

                                ?>

                            </td>
                        </tr>
					<?php } else { ?>
						<tr>
							<td>NA</td>
							<td>NA</td>
							<td>NA</td>
							<td>NA</td>
							<td>NA</td>
							<td>NA</td>
						</tr>
					<?php } ?>
                    </tbody>
                </table>


                <hr/>
                <div class="box-body">

                    <table class="table" id="tbl_relation" style="width:100%;">
                        <thead>
                        <th >University Name</th>
                        <th >Scheme</th>
                        <th >ICCR Regional Office</th>
                        <th >Date of Forwarding</th>
                        </thead>
                                <?php
                                if (!empty($applicaitonStepOne) && (($applicaitonStepOne[0]['programme'] == 1 && $applicaitonStepOne[0]['course'] == 58) || ($applicaitonStepOne[0]['programme'] == 2 && $applicaitonStepOne[0]['course'] == 59))) {
                                    ?>
                            <tbody>
                                <tr>
    <?php
    $data = $this->common_model->getconfirmationDataforfourthoptionHqrs($this->uri->segment(3));
    ?>
                                    <td>
                                    <?php
                                    $univ = !empty($data) ? $this->common_model->getUniversityById($data[0]['regional_university']) : [];
                                    echo !empty($univ) ? $univ[0]['name'] : 'NA';
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    $sch = !empty($mappingData) ? $this->common_model->getSchemeById($mappingData[0]['scholarship_id']) : [];
                                    echo !empty($sch) ? $sch[0]['scheme_name'] : 'NA';
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    $reg = !empty($data) ? $this->common_model->getRegionById($data[0]['region_one_status']) : [];
                                    echo !empty($reg) ? $reg[0]['name'] : 'NA';
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    echo !empty($data) ? date('d M Y h:i:s A', $data[0]['region_one_status_date']) : 'NA';
                                    ?>
                                    </td>
                                </tr>
                            </tbody>
    <?php
} else {
    ?>
                            <tbody>
                                <tr>
    <?php

    /* ---------------------------------------------------------------------
     * This block used to call getconfirmationData() (filter: university_is_accept
     * = 1, no ORDER BY) and print row [0], while the "Confirmation Status" table
     * higher up on the same page was built from a different filter over the same
     * iccr_university_response table. An applicant can nominate several
     * universities, so the two blocks could land on different rows and the page
     * showed TWO different university names for one student.
     * It now resolves the single final allotment the same way everywhere.
     * ------------------------------------------------------------------ */
    $appNoForForwarding = $this->uri->segment(3);
    $allResponses  = $this->common_model->getUniversityResponsesForApplication($appNoForForwarding);
    $mappingForFwd = !empty($mappingData) ? $mappingData[0] : array();
    $finalRow      = $this->common_model->pickFinalUniversityResponse(
        $allResponses,
        isset($mappingForFwd['regional_university']) ? $mappingForFwd['regional_university'] : null
    );

    $fwdUniversityName = 'NA';
    if (!empty($finalRow)) {
        if (!empty($finalRow['university_name'])) {
            $fwdUniversityName = $finalRow['university_name'];
        } else {
            $univ = $this->common_model->getUniversityByIdOld($finalRow['regional_university']);
            $fwdUniversityName = !empty($univ) ? $univ[0]['name'] : 'NA';
        }
    }

    $fwdSchemeName = 'NA';
    if (!empty($mappingForFwd['scholarship_id'])) {
        $sch = $this->common_model->getSchemeById($mappingForFwd['scholarship_id']);
        $fwdSchemeName = !empty($sch) ? $sch[0]['scheme_name'] : 'NA';
    }

    /* "ICCR Regional Office" always printed NA: it was read from
     * $response[0]['region_one_status'], but the query behind $response does not
     * SELECT region_one_status at all, so the isset() test never passed. */
    $fwdRegionId = 0;
    if (!empty($finalRow['region_one_status'])) {
        $fwdRegionId = (int) $finalRow['region_one_status'];
    } elseif (!empty($mappingForFwd['region_one_status'])) {
        $fwdRegionId = (int) $mappingForFwd['region_one_status'];
    }
    $fwdRegionName = 'NA';
    if ($fwdRegionId > 0) {
        $reg = $this->common_model->getRegionById($fwdRegionId);
        $fwdRegionName = !empty($reg) ? $reg[0]['name'] : 'NA';
    }

    /* Guard the timestamp so an empty/zero value cannot render as 01 Jan 1970. */
    $fwdDate = 'NA';
    $fwdRawDate = null;
    if (!empty($finalRow['region_one_status_date'])) {
        $fwdRawDate = $finalRow['region_one_status_date'];
    } elseif (!empty($mappingForFwd['region_one_status_date'])) {
        $fwdRawDate = $mappingForFwd['region_one_status_date'];
    }
    if (!empty($fwdRawDate) && is_numeric($fwdRawDate) && (int) $fwdRawDate > 0) {
        $fwdDate = date('d M Y h:i:s A', (int) $fwdRawDate);
    }
    ?>
                                    <td><?php echo htmlspecialchars($fwdUniversityName, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($fwdSchemeName, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($fwdRegionName, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo $fwdDate; ?></td>
                                </tr>
                            </tbody>
                            <?php
                        }
                        ?>

                    </table>

                    <br/>

				<!------Visa Details------>
				<?php
				 $mappingData = $this->common_model->getMappingData($this->uri->segment(3));
				 //echo "<pre>";print_r($mappingData);die;
				if(!empty($mappingData))
				{
					?>
			    <table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>9. Visa</th>
					<th>VISA Type</th>
                    <th>VISA Number</th>
                    <th>VISA Issue Date</th>
                    <th>VISA Duration From</th>
					<th>VISA Duration To</th>
					<th>VISA Issued Place</th>
					<th>VISA Approved Status</th>
                    </thead>
                    <tbody>

						<tr>
					<td></td>
					<td><?php
						if(!empty($mappingData[0]['visa_no'])){
							$course = !empty($applicaitonStepOne) ? $applicaitonStepOne[0]['programme'] : '';
							if($counter == 3 || $counter == 4){ echo 'Research'; } else { echo 'Student'; }
						} else { echo 'N/A'; }
					?></td>
					<td><?php echo !empty($mappingData[0]['visa_no']) ? $mappingData[0]['visa_no'] : 'N/A'; ?></td>
					<td><?php echo !empty($mappingData[0]['visa_isuue_date']) ? $mappingData[0]['visa_isuue_date'] : 'N/A'; ?></td>
					<td><?php echo !empty($mappingData[0]['visa_from_date']) ? $mappingData[0]['visa_from_date'] : 'N/A'; ?></td>
					<td><?php echo !empty($mappingData[0]['visa_to_date']) ? $mappingData[0]['visa_to_date'] : 'N/A'; ?></td>
					<td><?php echo !empty($mappingData[0]['visa_issueplace']) ? $mappingData[0]['visa_issueplace'] : 'N/A'; ?></td>
					<td><?php echo !empty($mappingData[0]['visa_approved']) ? $mappingData[0]['visa_approved'] : 'N/A'; ?></td>
					</tr>
                    </tbody>
                </table>
				<?php
				}
				else
				{
				?>
				<table id="tbl_visa_na" class="table" style="width: 100%;">
					<thead>
					<th>9. Visa</th>
					<th>VISA Type</th>
					<th>VISA Number</th>
					<th>VISA Issue Date</th>
					<th>VISA Duration From</th>
					<th>VISA Duration To</th>
					<th>VISA Issued Place</th>
					<th>VISA Approved Status</th>
					</thead>
					<tbody>
					<tr>
					<td></td>
					<td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td>
					</tr>
					</tbody>
				</table>
				<?php
				} // end if(!empty($mappingData))
				?>
                    <br/>

				<!------Flight/Travel Details------>
				<?php
				$travel = $this->common_model->getTravelData($this->uri->segment(3));
				?>
				<table id="tbl_travel" class="table" style="width: 100%;">
					<thead>
					<th>10. Flight/Train Details</th>
					<th>Flight/Train No</th>
					<th>Date of Departure</th>
					<th>Time of Departure</th>
					<th>Departure City</th>
					<th>Date of Arrival in India</th>
					<th>Time of Arrival</th>
					<th>Arrival City</th>
					<th>Airport Reception</th>
					</thead>
					<tbody>
					<tr>
					<td></td>
					<td><?php echo !empty($travel[0]['flight_no']) ? $travel[0]['flight_no'] : 'N/A'; ?></td>
					<td><?php echo !empty($travel[0]['departure_date']) ? $travel[0]['departure_date'] : 'N/A'; ?></td>
					<td><?php echo !empty($travel[0]['time_of_departure']) ? $travel[0]['time_of_departure'] : 'N/A'; ?></td>
					<td><?php echo !empty($travel[0]['departure_city']) ? $travel[0]['departure_city'] : 'N/A'; ?></td>
					<td><?php echo !empty($travel[0]['travel_arrival_date']) ? $travel[0]['travel_arrival_date'] : 'N/A'; ?></td>
					<td><?php echo !empty($travel[0]['time_of_arrival']) ? $travel[0]['time_of_arrival'] : 'N/A'; ?></td>
					<td><?php echo !empty($travel[0]['final_city_arrival']) ? $travel[0]['final_city_arrival'] : 'N/A'; ?></td>
					<td><?php echo !empty($travel[0]['airport_reseption']) ? $travel[0]['airport_reseption'] : 'N/A'; ?></td>
					</tr>
					</tbody>
				</table>
                    <br/>

                </div>

                <!-- /.box-body -->

            </div>
            <hr>
        </div>

    </div>
</section>

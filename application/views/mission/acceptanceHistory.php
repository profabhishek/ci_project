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
<?php
// The controller (Mission::historyview()) decodes the application number
// from the URL before using it for any lookups (the "View History" link
// base64-encodes it), but this view was reading the raw URL segment
// directly in many places below, which re-introduced the same "everything
// shows NA" bug for the University/ICCR Letter/Acceptance/Medical/Visa/
// Travel sections even after the controller-level fix. Use the decoded
// value the controller already computed and passed in, falling back to the
// raw segment only if this view is ever reached without it.
$appNoForView = isset($applicationId) ? $applicationId : $this->uri->segment(3);
$controllerBase = isset($controllerBase) ? $controllerBase : 'mission';
$stateuniversities = $this->common_model->getStateUniversities();
$centraluniversities = $this->common_model->getCentralUniversities();
$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states = $this->common_model->getAllStates();
$statewiseUniversites = array();
foreach ($states as $st) {
    if (!array_key_exists($st['id'], $statewiseUniversites)) {
        $statewiseUniversites[$st['id']] = array();
    }
}
//print_r($states);
$stateuniversities_one = str_replace("'", "\'", json_encode($stateuniversities));
$centraluniversities_one = str_replace("'", "\'", json_encode($centraluniversities));
$nits_one = str_replace("'", "\'", json_encode($nits));
$yogas_one = str_replace("'", "\'", json_encode($yogas));
$states_array = json_encode($statewiseUniversites);
?>
<script type="text/javascript">
    var stateuniversities = JSON.parse('<?php echo $stateuniversities_one; ?>');
    var centralUniversities = JSON.parse('<?php echo $centraluniversities_one; ?>');
    var nits = JSON.parse('<?php echo $nits_one; ?>');
    var yogas = JSON.parse('<?php echo $yogas_one; ?>');
    var statesarray = JSON.parse('<?php echo $states_array; ?>');
</script>
<section class="meacontent">	
    <div class="col-xs-10 form_head">		
        <img src="<?php echo site_url(); ?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
        <h3 class="text-center caps">Application Details For Scholarship through ICCR</h3>
        <h5 class="text-center">FILLED BY APPLICANT</h5>
    </div>

    <div  class="container" style="min-height:410px;padding:0px;">	
        <form method="post" action="<?php echo base_url(); ?>university/downloadApplication/<?php echo $appNoForView; ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
              ">
            <input id="approvedappId" name="approvedappId" value="<?php echo $appNoForView; ?>" type="hidden"/>
            <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
        </form>
        <div class="tab-content detailpagepdf">		
            <div id="home" class="tab-pane fade in active">	

                <div class="box-body">
                    <div class="col-xs-3 prfl pull-right" >
					<?php

$userd = $this->common_model->getUserInfo(!empty($applicaitonStepOne) ? $applicaitonStepOne[0]['uid'] : null);
//echo "<pre>";print_r($userd);die;

          				// The image tag below used to be rendered unconditionally, so if the
						// referenced file doesn't actually exist on disk (e.g. it was
						// deleted/moved on the server, or never uploaded in this
						// environment) the browser just shows a broken-image icon with no
						// indication of why. Now we check the real path on disk first and
						// only show a photo if the file is actually there; otherwise we
						// show a plain "No Photo Available" placeholder instead of a
						// broken image link - this is a missing FILE issue (data), not a
						// code bug, so this only improves how a missing file is displayed.
						if (!empty($userImage) && !empty($userd) && $userd->dir != "" && file_exists($userd->dir.'/'. $userImage)) {
							$profileImgSrc = site_url().$userd->dir.'/'. $userImage;
						} else if (!empty($userImage) && file_exists(FCPATH.'assets/site/main/profile_pics/'.$userImage)) {
							$profileImgSrc = site_url().'assets/site/main/profile_pics/'.$userImage;
						} else {
							$profileImgSrc = false;
						}
						if ($profileImgSrc) {
							?>
							<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo $profileImgSrc; ?>"/>
							<?php
						} else {
							?>
							<div style="width:151px;height:171px;display:flex;align-items:center;justify-content:center;text-align:center;font-size:12px;color:#777;border:1px dashed #ccc;">No Photo Available</div>
							<?php
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
/* -------------------------------------------------------------------------
 * Confirmation-status data
 *
 * WHY THIS WAS REWRITTEN
 * This page used to show two different university names for the same student.
 * Section 8 was built from getconfirmationDataByMission() (filter:
 * confirmed_to_mission = 1) while the "Date of Forwarding" table below was
 * built from getconfirmationData() (filter: university_is_accept = 1). Both
 * read the SAME iccr_university_response table, neither had an ORDER BY, and
 * both hard-coded row [0]. An applicant may nominate up to five universities,
 * so both result sets can contain several rows - whichever row MySQL happened
 * to return first won, and the two blocks disagreed.
 *
 * Section 8 additionally hard-coded exactly two <tbody> blocks, reading
 * $response[0] and $response[1]. That produced a permanent empty "NA NA NA NA"
 * row whenever there was only one response, and silently DROPPED the 3rd, 4th
 * and 5th responses when there were more.
 *
 * Now: one ordered query (getUniversityResponsesForApplication) feeds every
 * block, all responses are listed, and one row is designated the final
 * allotment (pickFinalUniversityResponse) and reused everywhere.
 * ---------------------------------------------------------------------- */
$docsArray = array();
if (!empty($applicaitonDocuments)) {
    foreach ($applicaitonDocuments as $docs) {
        if (!array_key_exists($docs['doc_type'], $docsArray)) {
            $docsArray[$docs['doc_type']] = array();
        }
        $docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
        $docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
    }
}

// Fall back to querying here if the view is ever rendered by a controller that
// has not been updated to pass these in.
$universityResponses = isset($universityResponses)
    ? $universityResponses
    : $this->common_model->getUniversityResponsesForApplication($appNoForView);

$mappingData = (isset($mappingData) && !empty($mappingData))
    ? $mappingData
    : $this->common_model->getMappingData($appNoForView);
$mappingRow  = !empty($mappingData) ? $mappingData[0] : array();

if (!isset($finalConfirmation)) {
    $finalConfirmation = $this->common_model->pickFinalUniversityResponse(
        $universityResponses,
        isset($mappingRow['regional_university']) ? $mappingRow['regional_university'] : null
    );
}
$finalUniversityId = !empty($finalConfirmation) ? (int) $finalConfirmation['regional_university'] : 0;
// Match on the response row id, not just the university id: a historic HQ bulk
// update (ConfirmationofCourseToMissionByHqrs) could stamp the same
// regional_university onto several rows, and only one of them is the real
// allotment - keying off the id keeps exactly one row flagged "Final".
$finalResponseId = (!empty($finalConfirmation) && isset($finalConfirmation['id'])) ? (int) $finalConfirmation['id'] : 0;

/*
 * Uploaded documents are filed under a per-year folder (2024/, 2025/, 2026/...)
 * and the year is NOT stored with the record, so the folder has to be probed.
 * The old code probed only three hard-coded years for university letters and
 * only the CURRENT year for the medical certificate - a certificate uploaded in
 * a previous year produced a dead download link. These helpers probe a widening
 * range plus the applicant's own upload directory, and return NULL when the file
 * genuinely is not on disk so the page can print "Not uploaded" instead of a
 * link that 404s.
 */
if (!function_exists('iccr_locate_year_file')) {
    function iccr_locate_year_file($subFolder, $fileName, $userDir = '') {
        if (empty($fileName)) {
            return null;
        }
        $candidates = array();
        if (!empty($userDir)) {
            $candidates[] = rtrim($userDir, '/') . '/' . $fileName;
        }
        $thisYear = (int) date('Y');
        for ($y = $thisYear + 1; $y >= $thisYear - 6; $y--) {
            $candidates[] = $y . '/' . $subFolder . '/' . $fileName;
        }
        $candidates[] = 'assets/site/main/' . $subFolder . '/' . $fileName;
        foreach ($candidates as $relative) {
            if (file_exists(FCPATH . $relative)) {
                return FCPATH . $relative;
            }
        }
        return null;
    }
}
if (!function_exists('iccr_doc_download_link')) {
    function iccr_doc_download_link($absolutePath, $controllerBase, $label = 'Download') {
        if (empty($absolutePath)) {
            return '<span title="File not found on the server">Not uploaded</span>';
        }
        return '<a target="_blank" href="' . site_url() . $controllerBase . '/downloadDocs/'
             . base64url_encode($absolutePath) . '">' . $label . '</a>';
    }
}

$applicantDir = (!empty($registerData) && !empty($registerData[0]['dir'])) ? $registerData[0]['dir'] : '';
?>

                <table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>University Name</th>
                    <th>University Status</th>
                    <th>University Letter</th>
                    <th>ICCR Letter</th>
                    <th>Acceptance</th>
                    <th>Medical Fitness Certificate</th>
                    </thead>
                    <tbody>
<?php if (empty($universityResponses)) { ?>
                        <tr>
                            <td colspan="6" style="text-align:center;color:#777;">
                                No university response has been recorded for this application yet.
                            </td>
                        </tr>
<?php
} else {
    foreach ($universityResponses as $resp) {
        $thisUniversityId = (int) $resp['regional_university'];
        $isFinal   = ($finalResponseId > 0 && isset($resp['id']))
            ? ((int) $resp['id'] === $finalResponseId)
            : ($finalUniversityId > 0 && $thisUniversityId === $finalUniversityId);
        $isAccept  = ((int) $resp['university_is_accept'] === 1);
        $isReject  = ((int) $resp['university_is_accept'] === 2);
        $uniName   = !empty($resp['university_name']) ? $resp['university_name'] : null;
        if ($uniName === null) {
            // University row missing/renamed - fall back to a direct lookup so the
            // cell shows a name rather than a blank, and only then give up.
            $lookup  = $this->common_model->getUniversityByIdOld($thisUniversityId);
            $uniName = !empty($lookup) ? $lookup[0]['name'] : 'NA';
        }
?>
                        <tr<?php echo $isFinal ? ' style="background-color:#f4fbf4;"' : ''; ?>>
                            <td>
                                <?php echo htmlspecialchars($uniName, ENT_QUOTES, 'UTF-8'); ?>
                                <?php if ($isFinal) { ?>
                                    <span class="label label-success" style="margin-left:6px;">Final</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                if ($isAccept) {
                                    echo 'Confirmed';
                                } elseif ($isReject) {
                                    echo 'Not Confirmed';
                                } else {
                                    echo 'Awaiting response';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                // University's own offer/rejection letter.
                                if ($isAccept || $isReject) {
                                    $letterPath = iccr_locate_year_file('university_approval', $resp['region_one_doc']);
                                    echo iccr_doc_download_link($letterPath, $controllerBase);
                                } else {
                                    echo 'NA';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                // ICCR letter is generated on the fly, so it only depends on
                                // the university having accepted - no file to probe.
                                if ($isAccept) {
                                    ?>
                                    <a target="_blank" href="<?php echo site_url() . $controllerBase . '/confirmationReceivedWithFormat/' . $appNoForView . '/' . $thisUniversityId; ?>">Download</a>
                                    <?php
                                } else {
                                    echo 'NA';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                /*
                                 * Acceptance (student undertaking) and the medical certificate
                                 * only ever exist for the FINAL allotment, so they are shown on
                                 * that row only. Previously these two cells were rendered from a
                                 * mix of $response[0] and the separate $university array, which
                                 * could point at a different university than the row being drawn.
                                 * scholar_acceptance lives on iccr_status_mapping:
                                 *   1 = accepted by student, 2 = declined, -1/0 = not answered.
                                 */
                                $missionStatus     = isset($mappingRow['mission_status']) ? (int) $mappingRow['mission_status'] : 0;
                                $scholarAcceptance = isset($mappingRow['scholar_acceptance']) ? (int) $mappingRow['scholar_acceptance'] : 0;

                                if (!$isFinal || !$isAccept || $missionStatus !== 1) {
                                    echo 'NA';
                                } elseif ($scholarAcceptance === 1) {
                                    ?>
                                    <a target="_blank" href="<?php echo site_url() . $controllerBase . '/undertakingFromStudent/' . $appNoForView . '/' . $thisUniversityId; ?>"><span class="label label-success">Download</span></a>
                                    <?php
                                } elseif ($scholarAcceptance === 2) {
                                    echo 'Declined';
                                } else {
                                    echo 'Awaiting student response';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!$isFinal || !$isAccept || $missionStatus !== 1) {
                                    echo 'NA';
                                } elseif ($scholarAcceptance === 2) {
                                    echo 'Declined';
                                } elseif ($scholarAcceptance !== 1) {
                                    echo 'Awaiting student response';
                                } elseif (empty($mappingRow['medical_fitness'])) {
                                    echo 'Not uploaded';
                                } else {
                                    $medicalPath = iccr_locate_year_file('medical_fitness', $mappingRow['medical_fitness'], $applicantDir);
                                    echo iccr_doc_download_link($medicalPath, $controllerBase, 'Download / Print');
                                }
                                ?>
                            </td>
                        </tr>
<?php
    }
}
?>
                    </tbody>
                </table>


                <!--<h3 class="text-center" id="h5_cnetr">Applicant's Acceptance Forwarded to Hqrs/RO</h3>-->
                <hr/>
                <div class="box-body">

                    <table class="table" id="tbl_relation" style="width:100%;">
                        <thead>
                        <th>University Name</th>
                        <th>Scheme</th>
                        <th>ICCR Regional Office</th>
                        <th>Date of Forwarding</th>
                        </thead>
                        <tbody>
                            <tr>
<?php
/* -------------------------------------------------------------------------
 * Forwarding block
 *
 * This is the block that used to disagree with section 8. It now renders the
 * SAME row that section 8 marks "Final", so one application can only ever show
 * one final university name.
 *
 * Two special cases are preserved:
 *  - The Ayush/ICAR "fourth option" flow stores its allotment in a different
 *    table (iccr_university_response_by_hqrs), so that table is consulted first
 *    for those programme/course combinations.
 *  - "ICCR Regional Office" used to always print NA. The column was read from
 *    $response[0]['region_one_status'], but the query behind $response
 *    (getconfirmationDataByMission) does not even SELECT region_one_status, so
 *    the isset() check could never pass. It is now read from the same row that
 *    supplies the university name.
 * ---------------------------------------------------------------------- */
$forwardRow          = $finalConfirmation;
$forwardUniversityId = $finalUniversityId;
$forwardUniversityNm = (!empty($finalConfirmation) && !empty($finalConfirmation['university_name']))
    ? $finalConfirmation['university_name']
    : null;

$isFourthOptionFlow = (!empty($applicaitonStepOne) && (
        ((int) $applicaitonStepOne[0]['programme'] === 1 && (int) $applicaitonStepOne[0]['course'] === 58) ||
        ((int) $applicaitonStepOne[0]['programme'] === 2 && (int) $applicaitonStepOne[0]['course'] === 59)
    ));

if ($isFourthOptionFlow) {
    $hqrsRows = $this->common_model->getconfirmationDataforfourthoptionHqrs($appNoForView);
    if (!empty($hqrsRows)) {
        $forwardRow          = $hqrsRows[0];
        $forwardUniversityId = (int) $hqrsRows[0]['regional_university'];
        $forwardUniversityNm = null; // resolved below
    }
}

if ($forwardUniversityNm === null && $forwardUniversityId > 0) {
    $univ = $this->common_model->getUniversityByIdOld($forwardUniversityId);
    $forwardUniversityNm = !empty($univ) ? $univ[0]['name'] : null;
}

// Scheme lives on iccr_status_mapping, not on the response row.
$schemeName = 'NA';
if (!empty($mappingRow['scholarship_id'])) {
    $sch = $this->common_model->getSchemeById($mappingRow['scholarship_id']);
    if (!empty($sch)) {
        // scheme_name already carries the scheme code in brackets in this data
        // set (e.g. "... [A1209]"), so the code column is deliberately not
        // appended again here.
        $schemeName = $sch[0]['scheme_name'];
    }
}

// Regional office: prefer the forwarding row, fall back to iccr_status_mapping.
$regionId = 0;
if (!empty($forwardRow) && !empty($forwardRow['region_one_status'])) {
    $regionId = (int) $forwardRow['region_one_status'];
} elseif (!empty($mappingRow['region_one_status'])) {
    $regionId = (int) $mappingRow['region_one_status'];
}
$regionName = 'NA';
if ($regionId > 0) {
    $reg = $this->common_model->getRegionById($regionId);
    if (!empty($reg)) {
        $regionName = $reg[0]['name'];
    }
}

// Date of forwarding is a unix timestamp; guard against 0/empty/non-numeric so
// the page never prints "01 Jan 1970".
$forwardDate = 'NA';
$rawDate = null;
if (!empty($forwardRow) && !empty($forwardRow['region_one_status_date'])) {
    $rawDate = $forwardRow['region_one_status_date'];
} elseif (!empty($mappingRow['region_one_status_date'])) {
    $rawDate = $mappingRow['region_one_status_date'];
}
if (!empty($rawDate) && is_numeric($rawDate) && (int) $rawDate > 0) {
    $forwardDate = date('d M Y h:i:s A', (int) $rawDate);
}
?>
                                <td><?php echo $forwardUniversityNm !== null ? htmlspecialchars($forwardUniversityNm, ENT_QUOTES, 'UTF-8') : 'NA'; ?></td>
                                <td><?php echo htmlspecialchars($schemeName, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($regionName, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo $forwardDate; ?></td>
                            </tr>
                        </tbody>
                    </table>
					</hr>
					</br>
								<!------Visa Details------>
				<?php
				 $mappingData = $this->common_model->getMappingData($appNoForView);
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
						// VISA type is derived from the level of programme:
						// 3 = M.Phil, 4 = Ph.D -> Research visa, everything else -> Student
						// visa. The old code tested an undefined $counter variable (it was
						// never assigned anywhere in this view), so this cell could only
						// ever print "Student" and emitted an undefined-variable notice.
						if(!empty($mappingData[0]['visa_no'])){
							$programmeId = !empty($applicaitonStepOne) ? (int) $applicaitonStepOne[0]['programme'] : 0;
							if($programmeId === 3 || $programmeId === 4){ echo 'Research'; } else { echo 'Student'; }
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
				$travel = $this->common_model->getTravelData($appNoForView);
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





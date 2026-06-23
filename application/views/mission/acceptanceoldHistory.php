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
        <form method="post" action="<?php echo base_url(); ?>mission/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
              ">
            <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
            <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
        </form>
        <div class="tab-content detailpagepdf">		
            <div id="home" class="tab-pane fade in active">	

                <div class="box-body">
                    <div class="col-xs-3 prfl pull-right" >
<?php
if ($userImage == "") {
    ?>
                            <img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url(); ?>assets/site/main/images/default_avatar.png"/>
                            <?php
                        } else {
                            ?>
                            <img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url(); ?>assets/site/main/profile_pics/<?php echo $userImage; ?>"/>
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
                                        <label>4. Country</label></td>
                                    <td>:&nbsp;&nbsp;<?php
                                        $nationalities = $this->common_model->getCountries();
                                        foreach ($nationalities as $na) {
                                            if (!empty($applicaitonStepOne)) {
                                                if ($applicaitonStepOne[0]['country'] == $na['id']) {
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
                                            <th>9. Level of Programme</th>
                                        <?php
                                        if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 9) {
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
            </div>		
            <div id="step3" class="tab-pane fade in active">	 
                                                        <?php
                                                        $docsArray = array();
                                                        if (count($applicaitonDocuments) > 0) {
                                                            foreach ($applicaitonDocuments as $docs) {
                                                                if (!array_key_exists($docs['doc_type'], $docsArray)) {
                                                                    $docsArray[$docs['doc_type']] = array();
                                                                }
                                                                $docsArray[$docs['doc_type']]['path'] = $docs['doc_path'];
                                                                $docsArray[$docs['doc_type']]['time'] = $docs['added_on'];
                                                            }
                                                        }
                                                        ?>
<?php
$response = $this->common_model->getconfirmationDataforHqrs($this->uri->segment(3));
?>
                <table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>6. University/Institute</th>
                    <th >University Name</th>
                    <th >University Status</th>	
                    <th >University Letter</th>											
                    <th >ICCR Letter</th>											
                    </thead>
                    <tbody>
                        <tr>											
                            <td>Option One</td>
                            <td>													
                <?php $university_first = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);
                echo $university_first[0]['name']; ?></td>
                            <td>
                <?php
                $sts = 0;
                foreach ($response as $resp) {
                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
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
    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
        $sts++;
        if ($resp['university_is_accept'] == 1) {
            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
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
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationoldReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationoldNotReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>

                            </td>
                        </tr>
                        <tr>
                            <td>Option Two</td>
                            <td ><?php $university_second = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);
                                echo $university_second[0]['name']; ?></td>
                            <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
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
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
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
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_two']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationoldReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationoldNotReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>

                            </td>
                        </tr>
                        <tr>
                            <td>Option Third</td>
                            <td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']);
                                echo $university_three[0]['name']; ?></td>
                            <td>
                                <?php
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
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
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $resp['region_one_doc']; ?>" target="_blank">Download</a>
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
                                $sts = 0;
                                foreach ($response as $resp) {
                                    if ($resp['regional_university'] == $applicaitonStepOne[0]['universty_choice_three']) {
                                        $sts++;
                                        if ($resp['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationoldReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?>mission/confirmationoldNotReceivedWithFormat/<?php echo $this->uri->segment(3); ?>/<?php echo $resp['regional_university']; ?>" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                }
                                if ($sts == 0) {
                                    echo "NA";
                                }
                                ?>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table" id="tbl_relation" style="width:100%;">
                    <thead>
                    <th >7. Status</th>

                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Applicant's Acceptance has been forwarded to Regional Office of ICCR.
                            </td>

                        </tr>
                    </tbody>
                </table>

                <!--<h3 class="text-center" id="h5_cnetr">Applicant's Acceptance Forwarded to Hqrs/RO</h3>-->	 
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
                                if (($applicaitonStepOne[0]['programme'] == 1 && $applicaitonStepOne[0]['course'] == 58) || ($applicaitonStepOne[0]['programme'] == 2 && $applicaitonStepOne[0]['course'] == 59)) {
                                    ?>
                            <tbody>
                                <tr>
    <?php
    $data = $this->common_model->getconfirmationDataforfourthoptionHqrs($this->uri->segment(3));
    ?>
                                    <td>
                                    <?php
                                    $univ = $this->common_model->getUniversityById($data[0]['regional_university']);
                                    echo $univ[0]['name'];
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    $sch = $this->common_model->getSchemeById($mappingData[0]['scholarship_id']);
                                    echo $sch[0]['scheme_name'];
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    $reg = $this->common_model->getRegionById($data[0]['region_one_status']);
                                    echo $reg[0]['name'];
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    echo date('d M Y h:i:s A', $data[0]['region_one_status_date']);
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
    $data = $this->common_model->getconfirmationData($this->uri->segment(3));
    ?>
                                    <td>
    <?php
    $univ = $this->common_model->getUniversityById($data[0]['regional_university']);
    echo $univ[0]['name'];
    ?>
                                    </td>
                                    <td>
    <?php
    $sch = $this->common_model->getSchemeById($mappingData[0]['scholarship_id']);
    echo $sch[0]['scheme_name'];
    ?>
                                    </td>
                                    <td>
    <?php
    $reg = $this->common_model->getRegionById($data[0]['region_one_status']);
    echo $reg[0]['name'];
    ?>
                                    </td>
                                    <td>
    <?php
    echo date('d M Y h:i:s A', $data[0]['region_one_status_date']);
    ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                        }
                        ?>

                    </table>

                    <br/>					

                </div>

                <!-- /.box-body -->

            </div>	
            <hr>
        </div>

    </div>
</section>





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
        <h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
        <h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
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
					
						$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']); 
              			if($userd->dir == "")
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
                                        <?php if(!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['fullname'].' '.$applicaitonStepOne[0]['middlename'].' '.$applicaitonStepOne[0]['familyname'];?>	</td>
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
                                    <td style="height:35px;font-weight: bold;">
                                        <label>5.Email</label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $email = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $email = $applicaitonStepOne[0]['email'];
                                        }
                                        ?>	
                                        <?php if (!empty($applicaitonStepOne)) echo $email; ?>	
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>6.Phone No : </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $phone = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $phone = $applicaitonStepOne[0]['phone'];
                                        }
                                        ?>	
                                        <?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['tel_country_code'] . $phone; ?>	
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>7. Permanent Unique ID of your country (Excluding Passpor No.) </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $unique_id = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $unique_id = $applicaitonStepOne[0]['unique_id'];
                                        }
                                        ?>	
                                        <?php if (!empty($applicaitonStepOne)) echo $unique_id; ?>	
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>8.Postal Address : </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $postal_address = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $postal_address = $applicaitonStepOne[0]['postal_address'];
                                        }
                                        ?>	
<?php if (!empty($applicaitonStepOne)) echo $postal_address; ?>	
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>9.Details of Father/Mother/Guardian </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $guardian_name = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $guardian_name = $applicaitonStepOne[0]['guardian_name'];
                                        }
                                        ?>	
<?php if (!empty($applicaitonStepOne)) echo $guardian_name; ?>	
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>10.Guardian Relation : </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $guardian_relation = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $guardian_relation = $applicaitonStepOne[0]['guardian_relation'];
                                        }
                                        ?>	
<?php if (!empty($applicaitonStepOne)) echo $guardian_relation; ?>	
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>11.Guardian Address : </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $guardian_address = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $guardian_address = $applicaitonStepOne[0]['guardian_address'];
                                        }
                                        ?>	
<?php if (!empty($applicaitonStepOne)) echo $guardian_address; ?>	
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="height:35px;max-width:120px">
                                        <table style="width:100%;" id="tbl_course">
                                            <thead>
                                            <th>9. Course applied for</th>
                                        <?php
                                        if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 9) {
                                            ?>
                                                <th>Course Type </th>
    <?php
} elseif (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8) {
    ?>
                                                <th>Course Type/Subject </th>
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
                                            if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 9) {

                                                $courseType = $this->common_model->getAllCourseType();
                                                foreach ($courseType as $ctype) {
                                                    if (!empty($applicaitonStepOne)) {
                                                        if ($applicaitonStepOne[0]['course_type'] == $ctype['id']) {
                                                            echo $ctype['course_type'];
                                                        }
                                                    }
                                                }
                                                if ($applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4) {
                                                    echo $applicaitonStepOne[0]['course_subject'];
                                                }
                                            } elseif (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 8) {
                                                echo $applicaitonStepOne[0]['course_subject'];
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
                <table id="tbl_relation" class="table" style="width: 100%;">

                    <tbody>
                        <tr>
                            <td colspan="3">
<?php
if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8) {
    ?>
                                    <table id="tbl_uni" style="width: 100%;">
                                        <thead>
                                        <th>Course you wish to study</th>
                                        <th>University</th>
                                        <th>Course Stream</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
    <?php
    if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2) {

        $courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

        foreach ($courses as $course) {
            if (!empty($applicaitonStepOne)) {
                if ($applicaitonStepOne[0]['course'] == $course['id']) {
                    echo $course['title'];
                }
            }
        }
    } elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
        $courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
        foreach ($courses as $course) {
            if (!empty($applicaitonStepOne)) {
                if ($applicaitonStepOne[0]['course'] == $course['id']) {
                    echo $course['title'];
                }
            }
        }
    } elseif ($applicaitonStepOne[0]['programme'] == 9) {

        $courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

        foreach ($courses as $course) {
            if (!empty($applicaitonStepOne)) {
                if ($applicaitonStepOne[0]['course'] == $course['id']) {
                    echo $course['title'];
                }
            }
        }
    }
    ?>	



                                                </td>
                                                <td><?php $university_second = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);
                                echo $university_second[0]['name']; ?></td>
                                                <td><?php
                                if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 4) {
                                    $crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
                                    if ($applicaitonStepOne[0]['course'] > 0 && $crs[0]['has_stream'] > 0) {
                                        if (!empty($applicaitonStepOne))
                                            echo $applicaitonStepOne[0]['course_option_name'];
                                    }
                                }
                                else {
                                    echo "NA";
                                }
    ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php
                                                    if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2) {

                                                        $courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

                                                        foreach ($courses as $course) {
                                                            if (!empty($applicaitonStepOne)) {
                                                                if ($applicaitonStepOne[0]['course_two'] == $course['id']) {
                                                                    echo $course['title'];
                                                                }
                                                            }
                                                        }
                                                    } elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
                                                        $courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
                                                        foreach ($courses as $course) {
                                                            if (!empty($applicaitonStepOne)) {
                                                                if ($applicaitonStepOne[0]['course_two'] == $course['id']) {
                                                                    echo $course['title'];
                                                                }
                                                            }
                                                        }
                                                    } elseif ($applicaitonStepOne[0]['programme'] == 9) {

                                                        $courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

                                                        foreach ($courses as $course) {
                                                            if (!empty($applicaitonStepOne)) {
                                                                if ($applicaitonStepOne[0]['course_two'] == $course['id']) {
                                                                    echo $course['title'];
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?></td>
                                                <td><?php $university_second = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);
                                                echo $university_second[0]['name']; ?></td>
                                                <td><?php
                                                    if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 4) {
                                                        $crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
                                                        if ($applicaitonStepOne[0]['course_two'] > 0 && $crs[0]['has_stream'] > 0) {
                                                            if (!empty($applicaitonStepOne))
                                                                echo $applicaitonStepOne[0]['course_option_name_two'];
                                                        }
                                                    }
                                                    else {
                                                        echo "NA";
                                                    }
                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php
                                                    if ($applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2) {

                                                        $courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

                                                        foreach ($courses as $course) {
                                                            if (!empty($applicaitonStepOne)) {
                                                                if ($applicaitonStepOne[0]['course_three'] == $course['id']) {
                                                                    echo $course['title'];
                                                                }
                                                            }
                                                        }
                                                    } elseif ($applicaitonStepOne[0]['programme'] == 5 || $applicaitonStepOne[0]['programme'] == 6) {
                                                        $courses = $this->common_model->getCourseByPrgramme($applicaitonStepOne[0]['programme']);
                                                        foreach ($courses as $course) {
                                                            if (!empty($applicaitonStepOne)) {
                                                                if ($applicaitonStepOne[0]['course_three'] == $course['id']) {
                                                                    echo $course['title'];
                                                                }
                                                            }
                                                        }
                                                    } elseif ($applicaitonStepOne[0]['programme'] == 9) {

                                                        $courses = $this->common_model->getCourseByPrgrammeAndType($applicaitonStepOne[0]['programme'], $applicaitonStepOne[0]['course_type']);

                                                        foreach ($courses as $course) {
                                                            if (!empty($applicaitonStepOne)) {
                                                                if ($applicaitonStepOne[0]['course_three'] == $course['id']) {
                                                                    echo $course['title'];
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?></td>
                                                <td><?php $university_second = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']);
                                                echo $university_second[0]['name']; ?></td>
                                                <td><?php
                                                    if ($applicaitonStepOne[0]['programme'] > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 4) {
                                                        $crs = $this->common_model->getCoursesById($applicaitonStepOne[0]['course']);
                                                        if ($applicaitonStepOne[0]['course_three'] > 0 && $crs[0]['has_stream'] > 0) {
                                                            if (!empty($applicaitonStepOne))
                                                                echo $applicaitonStepOne[0]['course_option_name_three'];
                                                        }
                                                    }
                                                    else {
                                                        echo "NA";
                                                    }
                                                    ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                                    <?php
                                                } else {
                                                    ?>
                                    <table id="tbl_uni" style="width: 100%;">
                                        <thead>
                                        <th>University 1</th>
                                        <th>University 2</th>
                                        <th>University 3</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php $university_first = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice']);
                                                echo $university_first[0]['name']; ?></td>
                                                <td><?php $university_second = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_two']);
                                                echo $university_second[0]['name']; ?></td>
                                                <td><?php $university_three = $this->common_model->getUniversityById($applicaitonStepOne[0]['universty_choice_three']);
                                                echo $university_three[0]['name']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                                    <?php
                                                }
                                                ?>


                            </td>

                        </tr>
                    </tbody>
                </table>
                <table class="table" id="tbl_relation">
                    <th>7. Status</th>
                    <tbody>
                        <tr>										
                            <td style="height:35px;">
                                                <?php
                                                if ($this->uri->segment(4) == "approved") {
                                                    echo strtoupper('Recommended by Mission/Post & Forwarded to concerned Regional Offices of ICCR.');
                                                }
                                                if ($this->uri->segment(4) == "rejected") {
                                                    echo strtoupper('Not-Recommended by Mission/Post & Forwarded to concerned Regional Offices of ICCR.');
                                                }
                                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="text-center" id="h5_cnetr">All Documents</h5>	 
                <div class="box-body">
                    <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                        <table class="table" id="tbl_relation" >
                            <thead>
                            <th>S.No.</th>
                            <th>Document Name</th>
                            <th>Upload Document</th>							
                            <th>Uploaded Time</th>							
                            </thead>
                            <tbody>
                                                <?php
                                                $counter = 1;
                                                $upload = 0;
                                                $doctypes = $this->config->item('doc_types');
                                                ?>	
                                <tr>
                                    <td><?php echo $counter;
                                                $counter++; ?></td>
                                    <td>Permanent Unique ID <span class="text-red">*</span></td>
                                    <td>
                                                <?php
                                                if (array_key_exists($doctypes['id']['type'], $docsArray)) {
                                                    $upload++;
                                                    ?>
                                            <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['id']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                                    <?php
                                                } else {
                                                    ?>
                                            <a href="#" data-toggle="modal" data-target="#idProofDiv">Upload</a>
                                                    <?php
                                                }
                                                ?>	

                                    </td>
                                    <td>
                                                <?php
                                                if (array_key_exists($doctypes['id']['type'], $docsArray)) {
                                                    echo date('d-m-y h:i:s a', $docsArray[$doctypes['id']['type']]['time']);
                                                } else {
                                                    ?>
                                            N/A
                                    <?php
                                }
                                ?>
                                    </td>								
                                </tr>
<?php
if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['passport_no'] != "") {
    ?>
                                    <tr>
                                        <td><?php echo $counter;
    $counter++; ?></td>
                                        <td><?php echo $doctypes['passport']['title']; ?><span class="text-red">*</span></td>
                                        <td>
    <?php
    if (array_key_exists($doctypes['passport']['type'], $docsArray)) {
        $upload++;
        ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['passport']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                        <?php
                                    } else {
                                        ?>
                                                <a href="#"  data-toggle="modal" data-target="#passportDiv">Upload</a>
        <?php
    }
    ?>

                                        </td>
                                        <td>
    <?php
    if (array_key_exists($doctypes['id']['type'], $docsArray)) {
        echo date('d-m-y h:i:s a', $docsArray[$doctypes['id']['type']]['time']);
    } else {
        ?>
                                                N/A
                                        <?php
                                    }
                                    ?>
                                        </td>

                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                //if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['school_leaving_country'] != "" && $applicaitonStepTwo[0]['school_leaving_country'] > 0)
                                if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $counter;
                                    $counter++; ?></td>
                                        <td><?php echo $doctypes['school_leaving']['title']; ?><span class="text-red">*</span></td>
                                        <td>
    <?php
    if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
        $upload++;
        ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['school_leaving']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
        <?php
    } else {
        ?>
                                                <a href="#"  data-toggle="modal" data-target="#schoolLivingDiv">Upload</a>
                                        <?php
                                    }
                                    ?>

                                        </td>
                                        <td>
    <?php
    if (array_key_exists($doctypes['school_leaving']['type'], $docsArray)) {
        echo date('d-m-y h:i:s a', $docsArray[$doctypes['school_leaving']['type']]['time']);
    } else {
        ?>
                                                N/A
                                                <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        //if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['ug_leaving_country'] != "" && $applicaitonStepTwo[0]['ug_leaving_country'] > 0)
                                        if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
                                            ?>
                                    <tr>
                                        <td><?php echo $counter;
                                            $counter++; ?></td>
                                        <td><?php echo $doctypes['ug']['title']; ?><span class="text-red">*</span></td>
                                        <td>
                                            <?php
                                            if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
                                                $upload++;
                                                ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['ug']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#"  data-toggle="modal" data-target="#underGraduateDiv">Upload</a>
                                        <?php
                                    }
                                    ?>

                                        </td>
                                        <td>
    <?php
    if (array_key_exists($doctypes['ug']['type'], $docsArray)) {
        echo date('d-m-y h:i:s a', $docsArray[$doctypes['ug']['type']]['time']);
    } else {
        ?>
                                                N/A
                                                <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        //if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['pg_leaving_country'] != "" && $applicaitonStepTwo[0]['pg_leaving_country'] > 0)
                                        if (array_key_exists($doctypes['pg']['type'], $docsArray)) {
                                            ?>
                                    <tr>
                                        <td><?php echo $counter;
                                            $counter++; ?></td>
                                        <td><?php echo $doctypes['pg']['title']; ?><span class="text-red">*</span></td>
                                        <td>
                                            <?php
                                            if (array_key_exists($doctypes['pg']['type'], $docsArray)) {
                                                $upload++;
                                                ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['pg']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#"  data-toggle="modal" data-target="#postGraduateDiv">Upload</a>
        <?php
    }
    ?>

                                        </td>
                                        <td>
                                    <?php
                                    if (array_key_exists($doctypes['pg']['type'], $docsArray)) {
                                        echo date('d-m-y h:i:s a', $docsArray[$doctypes['pg']['type']]['time']);
                                    } else {
                                        ?>
                                                N/A
        <?php
    }
    ?>
                                        </td>

                                    </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        //if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['mphil_leaving_country'] != "" && $applicaitonStepTwo[0]['mphil_leaving_country'] > 0)
                                        if (array_key_exists($doctypes['mhil']['type'], $docsArray)) {
                                            ?>
                                    <tr>
                                        <td><?php echo $counter;
                                        $counter++; ?></td>
                                        <td><?php echo $doctypes['mhil']['title']; ?><span class="text-red">*</span></td>
                                        <td>
    <?php
    if (array_key_exists($doctypes['mhil']['type'], $docsArray)) {
        $upload++;
        ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['mhil']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#"  data-toggle="modal" data-target="#mphilDiv">Upload</a>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
    <?php
    if (array_key_exists($doctypes['mhil']['type'], $docsArray)) {
        echo date('d-m-y h:i:s a', $docsArray[$doctypes['mhil']['type']]['time']);
    } else {
        ?>
                                                N/A
                                        <?php
                                    }
                                    ?>
                                        </td>

                                    </tr>
    <?php
}
?>
                                        <?php
                                        //if(count($applicaitonStepTwo) > 0 && $applicaitonStepTwo[0]['phd_leaving_country'] != "" && $applicaitonStepTwo[0]['phd_leaving_country'] > 0)
                                        if (array_key_exists($doctypes['phd']['type'], $docsArray)) {
                                            ?>
                                    <tr>
                                        <td><?php echo $counter;
                                        $counter++; ?></td>
                                        <td><?php echo $doctypes['phd']['title']; ?><span class="text-red">*</span></td>
                                        <td>
                                            <?php
                                            if (array_key_exists($doctypes['phd']['type'], $docsArray)) {
                                                $upload++;
                                                ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['phd']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#"  data-toggle="modal" data-target="#phdDiv">Upload</a>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <?php
                                            if (array_key_exists($doctypes['phd']['type'], $docsArray)) {
                                                echo date('d-m-y h:i:s a', $docsArray[$doctypes['phd']['type']]['time']);
                                            } else {
                                                ?>
                                                N/A
                                                <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if (count($applicaitonStepThree) > 0 && $applicaitonStepThree[0]['currently_non_nri'] != "" && $applicaitonStepThree[0]['currently_non_nri'] > 0 && $applicaitonStepThree[0]['currently_non_nri'] == 1) {
                                    ?>
                                    <tr>
                                        <td><?php echo $counter;
                                $counter++; ?></td>
                                        <td><?php echo $doctypes['indian_address']['title']; ?><span class="text-red">*</span></td>
                                        <td>
                                            <?php
                                            if (array_key_exists($doctypes['indian_address']['type'], $docsArray)) {
                                                $upload++;
                                                ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['indian_address']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#"  data-toggle="modal" data-target="#addressProofDiv">Upload</a>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
    <?php
    if (array_key_exists($doctypes['indian_address']['type'], $docsArray)) {
        echo date('d-m-y h:i:s a', $docsArray[$doctypes['indian_address']['type']]['time']);
    } else {
        ?>
                                                N/A
                                                <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                            <?php
                                        }
                                        ?>		
<?php
if (count($applicaitonStepThree) > 0 && $applicaitonStepThree[0]['is_international_lic'] != "" && $applicaitonStepThree[0]['is_international_lic'] > 0 && $applicaitonStepThree[0]['is_international_lic'] == 1) {
    ?>
                                    <tr>
                                        <td><?php echo $counter;
    $counter++; ?></td>
                                        <td><?php echo $doctypes['dl']['title']; ?><span class="text-red">*</span></td>
                                        <td>
                                    <?php
                                    if (array_key_exists($doctypes['dl']['type'], $docsArray)) {
                                        $upload++;
                                        ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['dl']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
        <?php
    } else {
        ?>
                                                <a href="#"  data-toggle="modal" data-target="#licenceDiv">Upload</a>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <?php
                                            if (array_key_exists($doctypes['dl']['type'], $docsArray)) {
                                                echo date('d-m-y h:i:s a', $docsArray[$doctypes['dl']['type']]['time']);
                                            } else {
                                                ?>
                                                N/A
                                                <?php
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                            <?php
                                        }
                                        ?>						
                                <tr>
                                    <td><?php echo $counter;
                                        $counter++; ?></td>
                                    <td><?php echo $doctypes['physical']['title']; ?><span class="text-red">*</span></td>
                                    <td>
                                        <?php
                                        if (array_key_exists($doctypes['physical']['type'], $docsArray)) {
                                            $upload++;
                                            ?>
                                            <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['physical']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                    <?php
                                } else {
                                    ?>
                                            <a href="#"  data-toggle="modal" data-target="#physicalFitnessDiv">Upload</a>
                                    <?php
                                }
                                ?>

                                    </td>
                                    <td>
<?php
if (array_key_exists($doctypes['physical']['type'], $docsArray)) {
    echo date('d-m-y h:i:s a', $docsArray[$doctypes['physical']['type']]['time']);
} else {
    ?>
                                            N/A
                                            <?php
                                        }
                                        ?>
                                    </td>

                                </tr>	
                                        <?php
                                        if (count($docsArray) > 0 && array_key_exists($doctypes['tl']['type'], $docsArray)) {
                                            ?>
                                    <tr>
                                        <td><?php echo $counter;
                                        $counter++; ?></td>
                                        <td><?php echo $doctypes['tl']['title']; ?></td>
                                        <td>
                                            <?php
                                            if (array_key_exists($doctypes['tl']['type'], $docsArray)) {
                                                $upload++;
                                                ?>
                                                <a target="_blank" href="<?php echo site_url(); ?><?php echo $docsArray[$doctypes['tl']['type']]['path']; ?>"><i class="fa fa-file-pdf-o fa-1x text-red"></i> Click to view Document</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#"  data-toggle="modal" data-target="#translationDiv">Upload</a>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
                                    <?php
                                    if (array_key_exists($doctypes['tl']['type'], $docsArray)) {
                                        echo date('d-m-y h:i:s a', $docsArray[$doctypes['tl']['type']]['time']);
                                    } else {
                                        ?>
                                                N/A
                                        <?php
                                    }
                                    ?>
                                        </td>

                                    </tr>
                                            <?php
                                        }
                                        ?>							
                            </tbody>
                        </table>
                    </div>
                    <br/>
                    <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                        <div class="name-sec col-xs-12 col-sm-6 col-md-12">					
                            <div class="form-group">
                                <span class="note1">I hereby declare that the particulars given above are true to the best of my knowledge and belief and I have understood the Terms and Conditions of the Schholarship Scheme and hereby undertake to abide by them. I also undertake to return to my country after completion of my studies in India.</span>
                            </div>

                        </div>
                    </div>	

                </div>

                <!-- /.box-body -->

            </div>	
            <hr>
        </div>

    </div>
</section>





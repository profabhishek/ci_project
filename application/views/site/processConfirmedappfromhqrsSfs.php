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
    <!----<div class="col-xs-10 form_head">		
        <img src="<?php echo site_url(); ?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
        <h3 class="text-center caps">Application Details For Scholarship through ICCR</h3>
        <h5 class="text-center">FILLED BY APPLICANT</h5>
    </div>--->

    <div  class="container" style="min-height:410px;padding:0px;">	
        <!-----<form method="post" action="<?php echo base_url(); ?>mission/downloadApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
              ">
            <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
            <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
        </form>--->
        <div class="tab-content detailpagepdf">		
            <div id="home" class="tab-pane fade in active">	

                <div class="box-body">
				  	<div class="col-xs-3 prfl pull-right" >
              	<?php              			 
              			
              			$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']); 
						            			 
              			
						$dirdata = $userd->dir;
						$imgs = file_get_contents($userd->dir .'/'.$userImage);
							$data = base64_encode($imgs);
							$f = finfo_open();
							$imgdata = base64_decode($data);
                            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
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
							<img style="width:151px;height:171px;" id="profil_image_div" src="data:<?php if(!empty($mime_type)){echo $mime_type;}?>;base64,<?php if(!empty($data)){echo $data;}?>"/>
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
                    <!----<div class="col-xs-3 prfl pull-right" >
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
                    </div>--->
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
                                                echo 'Ms.';
                                            } elseif ($title == 3) {
                                                echo 'Mrs.';
                                            }
                                            ?>
                                        <?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['fullname'].' '.$applicaitonStepOne[0]['middlename'].' '.$applicaitonStepOne[0]['familyname'];?></td>
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
                                    <td>:&nbsp;&nbsp;<?php if (!empty($applicaitonStepOne)) echo $applicaitonStepOne[0]['dob'];; ?>

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
                                        <label>7. Unique Id : </label></td>
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
                                        <label>9.Guardian Name : </label></td>
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
                                        <table style="width:100%;" id="tbl_course" class="table">
                                            <thead>
                                            <th style="padding-left:0;">12. Level of Programme</th>
                                        <?php
                                        if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 1 || $applicaitonStepOne[0]['programme'] == 2 || $applicaitonStepOne[0]['programme'] == 9) {
                                            ?>
                                                <th>Course Type </th>
    <?php
} elseif (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8) {
    ?>
                                                <th>Subject </th>
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
                                            } elseif (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] == 3 || $applicaitonStepOne[0]['programme'] == 4 || $applicaitonStepOne[0]['programme'] == 8) {
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
                                                        <?php
        $response = $this->common_model->getconfirmationDataforHqrs($this->uri->segment(3));
		$responseMission = $this->common_model->getconfirmationDataByMissionSfs($mappingData[0]['application_no']);
		$applicaitonsResubmitStatus = $this->common_model->getCommonApplicationStatus($responseMission[0]['application_id'],$universityId,$flag);
		//echo "<pre>";print_r($applicaitonsResubmitStatus);
                                                       ?>
			<?php if(count($responseMission) >1)
			{
				?>
				<table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>13. University/Institute</th>
<?php
if (count($applicaitonStepOne) > 0) {
    ?>
                     <th >Course Name</th>
    <?php
}
?>
					<th>Scheme</th>
                

                    <th>University Status</th>	
                    <th>University Letter</th>	.
					 <th>Offer Letter</th>	
                    <th >Acceptance Letter</th>											
                    </thead>
    <tbody>
						<tr>
                     
                                

                            <td><?php $university = $this->common_model->getconfirmationDataByMissionSfs($applicaitonStepOne[0]['application_no']);
						    //echo "<pre>";print_r($mappingData);die;
							 $universityData = $this->common_model->getUniversityById($university[1]['regional_university']);
							 echo $universityData[0]['name'];
                                ?></td>
							<td>
              					<?php
              					echo $this->common_model->getCourseName($applicaitonStepOne[0]['application_no'],$university[1]['regional_university']);
              					
              					?>
              				</td>
							<td>
              					<?php
									
                               //echo "<pre>";print_r($mappingData);die;
								//echo "<pre>";print_r($mappingData);
              					$sch = $this->common_model->getSchemeById($mappingData[0]['scholarship_id']);
								//echo "<pre>";print_r($sch[0]);
								if($sch){
									echo $sch[0]['scheme_name'];
								}
								else
								{
									echo "NA";
								}
              					
              					?>
              				</td>
                           
							<td>
              				<?php if($university[1]['university_is_accept'] == 1)
              					  {
									echo "Confirmed";
								  }
								  
              				?>
              				</td>
                            
							
							
							 <td>
                                <?php
                              //echo "<pre>";print_r($mappingData);
							  $response = $this->common_model->getconfirmationDataByMissionSfs($mappingData[0]['application_no']);
							   //echo "<pre>";print_r($response);
                                  
									   ?>
                                        <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $response[1]['region_one_doc']; ?>" target="_blank"><span class = "label label-success">Downloads</span></a>
										<?php
                                    
									
                                
                               
                                ?>

                            </td>
							 
							
                           
							
							
							
							
                        </tr>

                    </tbody>
                </table>
				
				<?php
				
			}
			
			elseif(count($applicaitonStepOne) > 0 )
				{
					
					?>
						<table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>13. University/Institutes</th>
<?php
if (count($applicaitonStepOne) > 0 ) {
    ?>
                     <th >Course Name</th>
    <?php
}
?>
					<th>Scheme </th>
                

                    <th>University Status</th>	
                    <th>University Letter</th>	.
					 										
                    </thead>
    <tbody>
						<tr>
                     
                                

                            <td><?php $university = $this->common_model->getconfirmationDataByMissionSfs($applicaitonStepOne[0]['application_no']);
						    //echo "<pre>";print_r($mappingData);die;
							 $universityData = $this->common_model->getUniversityById($university[0]['regional_university']);
							 echo $universityData[0]['name'];
                                ?></td>
							<td>
              					<?php
              					echo $university[0]['confirmed_course'];
              					
              					?>
              				</td>
							<td>
              					<?php
									
                               //echo "<pre>";print_r($mappingData);die;
								//echo "<pre>";print_r($mappingData);
              					$sch = $this->common_model->getSchemeById($mappingData[0]['scholarship_id']);
								//echo "<pre>";print_r($sch);
								if($sch){
									echo $sch[0]['scheme_name'];
								}
								else
								{
									echo "NA";
								}
              					
              					?>
              				</td>
                           
							<td>
              				<?php if($university[0]['university_is_accept'] == 1)
              					  {
									echo "Confirmed";
								  }
								  
              				?>
              				</td>
                            
							
							
							<td>
                                <?php
                              //echo "<pre>";print_r($mappingData);
							  $response = $this->common_model->getconfirmationDataByMissionSfs($mappingData[0]['application_no']);
							   //echo "<pre>";print_r($response);
                                       if($response[0]['region_one_doc']){
									   ?>
                                        <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $response[0]['region_one_doc']; ?>" target="_blank"><span class = "label label-success">Downloads</span></a>
										<?php
                                    
									
                                
									   }
                                ?>

                            </td>
							 
							
                          
							
							
							
							
                        </tr>

                    </tbody>
					
					
                </table>
					
					<?php
				}
			else
			{
				?>
				<table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>13. University/Institute</th>
<?php
if (count($applicaitonStepOne) > 0) {
    ?>
                     <th >Course Name</th>
    <?php
}
?>
					<th>Scheme</th>
                

                    <th>University Status</th>	
                    <th>University Letter</th>	.
					 										
                    </thead>
    <tbody>
						<tr>
                     
                                

                            <td><?php $university = $this->common_model->getconfirmationDataByMission($applicaitonStepOne[0]['application_no']);
						    //echo "<pre>";print_r($mappingData);die;
							 $universityData = $this->common_model->getUniversityById($university[0]['regional_university']);
							 echo $universityData[0]['name'];
                                ?></td>
							<td>
              					<?php
              					echo $this->common_model->getCourseName($applicaitonStepOne[0]['application_no'],$university[0]['regional_university']);
              					
              					?>
              				</td>
							<td>
              					<?php
									
                               //echo "<pre>";print_r($mappingData);die;
								//echo "<pre>";print_r($mappingData);
              					$sch = $this->common_model->getSchemeById($mappingData[0]['scholarship_id']);
								//echo "<pre>";print_r($sch[0]);
								if($sch){
									echo $sch[0]['scheme_name'];
								}
								else
								{
									echo "NA";
								}
              					
              					?>
              				</td>
                           
							<td>
              				<?php if($university[0]['university_is_accept'] == 1)
              					  {
									echo "Confirmed";
								  }
								  
              				?>
              				</td>
                            
							
							
							 <td>
                                <?php
                              //echo "<pre>";print_r($mappingData);
							  $response = $this->common_model->getconfirmationDataByMission($mappingData[0]['application_no']);
							   //echo "<pre>";print_r($response);

									   ?>
                                        <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $response[0]['region_one_doc']; ?>" target="_blank"><span class = "label label-success">Downloads</span></a>
										<?php
                                   
									
                                
                               
                                ?>

                            </td>
							 
							
                           
					
							
							
                        </tr>

                    </tbody>
					
					
                </table>
				
				<?php
				
			}
				
			
			?>
                								
		
		




                <!-- /.box-body -->

            </div>	
            <hr>
        </div>

    </div>
</section>





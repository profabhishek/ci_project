<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:133px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
.form-horizontal .control-label {
    padding-top: 7px;
    margin-bottom: 0;
    text-align: left;
    font-size: 12px;
}
input,select,label{font-size:14px !important;}
.tab-content input[type="text"], select {
    color: #747474 !important;
    font-size: 14px !important;
    font-weight: bold;
}
.rpt{
	 border: 1px solid #cecece;
    border-radius: 24px;
    color: #747474;
    float: right;
    font-weight: bold;
    padding: 6px;
    text-align: center;
    width: 129px;
}
</style>
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
                                        <label>9. Guardian Name : </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $guardian_name = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $guardian_name = $applicaitonStepOne[0]['father_fname'].' '.$applicaitonStepOne[0]['father_mname'].' '.$applicaitonStepOne[0]['father_lname'];
                                        }
                                        ?>	
<?php if (!empty($applicaitonStepOne)) echo $guardian_name; ?>	
                                    </td>
                                </tr>
                               <tr>
                                    <td style="height:35px;font-weight: bold;">
                                        <label>10. Guardian Contact Number : </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $guardian_relation = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $guardian_relation = $applicaitonStepOne[0]['father_number'];
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
                                                        ?>
                <table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>13. University/Institute</th>
<?php
if (count($applicaitonStepOne) > 0 && $applicaitonStepOne[0]['programme'] != 3 && $applicaitonStepOne[0]['programme'] != 4 && $applicaitonStepOne[0]['programme'] != 7 && $applicaitonStepOne[0]['programme'] != 8) {
    ?>
                     <th >Course Name</th>
    <?php
}
?>
					<th>Scheme</th>
                

                    <th >University Status</th>	
                    <th >University Letter</th>	
                    <!-----<th >ICCR Letter</th>--->											
                    </thead>
                    <tbody>
						<tr>
                     
                                

                            <td><?php $university = $this->common_model->getconfirmationDataByMission($applicaitonStepOne[0]['application_no']);
						    //echo "<pre>";print_r($university);die;
							 if (!empty($university)) {
								 $universityData = $this->common_model->getUniversityById($university[0]['regional_university']);
								 echo !empty($universityData) ? $universityData[0]['name'] : 'NA';
							 } else {
								 echo 'NA';
							 }
                                ?></td>
							<td>
              					<?php
              					if (!empty($university)) {
              					echo $this->common_model->getCourseName($applicaitonStepOne[0]['application_no'],$university[0]['regional_university']);
              					} else {
              					echo 'NA';
              					}
              					?>
              				</td>
							<td>
              					<?php
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
              				<?php if(!empty($university) && $university[0]['university_is_accept'] == 1)
              					  {
									echo "Confirmed";
								  }
								  elseif(!empty($university) && $university[0]['university_is_accept'] == 2)
              					  {
									echo "Not-Confirmed";
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
    $response = $this->common_model->getconfirmationDataByMission($mappingData[0]['application_no']);

    if (!empty($response) && !empty($response[0]['region_one_doc'])) {

        $file_path_un = './'.$currentyear.'/university_approval/'.$response[0]['region_one_doc'];
        // For your case: ./2026/university_approval/nalanda.pdf

        if (strpos($response[0]['region_one_doc'], '.pdf') !== false) {
            echo '<a href="'.site_url().'applicant/downloadDocs/'.base64url_encode($file_path_un).'" target="_blank">Download</a>';
        } else {
            $imgs = file_get_contents($file_path_un);
            if ($imgs !== false) {
                $data = base64_encode($imgs);
                $f = finfo_open();
                $imgdata = base64_decode($data);
                $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
                echo '<a download="'.rand().time().'" href="data:'.$mime_type.';base64,'.$data.'" target="_blank">Download</a>';
            } else {
                echo "File not found: ".$file_path_un; // temporary debug
            }
        }
    } else {
        echo "NA";
    }
    ?>
</td>
                            <!----<td>
                                <?php
                               
                               
                                   if(!empty($university)) {
                                        if ($university[0]['university_is_accept'] == 1) {
                                            ?>
                                            <a target="_blank" href="#" target="_blank">Download</a>

                                            <?php
                                        } elseif ($resp['university_is_accept'] == 2) {
                                            ?>
                                            <a target="_blank" href="#" target="_blank">Download</a>
                                            <?php
                                        }
                                    }
                                
                               
                                ?>

                            </td>--->
                        </tr>

                    </tbody>
                </table>								
                <hr/>
				
				<?php
				
				if(!empty($mappingData[0]['visa_no']))
				{
					?>
					 <table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>14. Visa</th>
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
						<td>
					 <?php 
						if(!empty($mappingData[0]['visa_no'])){
							
							$course = $applicaitonStepOne[0]['programme'];
					      	if($course == 3 || $course == 4)
					      	{
								echo 'Research';
							}
							else
							{
								echo 'Student';
							}
						}
						
					 ?>
					 </td>
						<td>
						<?php
							if(!empty($mappingData[0]['visa_no']))
							{
								echo $mappingData[0]['visa_no'];
								
							}
							

							?>
						</td>
						
						<td>
						<?php
							if(!empty($mappingData[0]['visa_isuue_date']))
							{
								echo $mappingData[0]['visa_isuue_date'];
								
							}
							

							?>
						</td>
						<td>
						<?php
							if(!empty($mappingData[0]['visa_from_date']))
							{
								echo $mappingData[0]['visa_from_date'];
								
							}
							

							?>
						</td>
						<td>
						<?php
							if(!empty($mappingData[0]['visa_to_date']))
							{
								echo $mappingData[0]['visa_to_date'];
								
							}
							

							?>
						</td>
						<td>
						<?php
							if(!empty($mappingData[0]['visa_issueplace']))
							{
								echo $mappingData[0]['visa_issueplace'];
								
							}
							

							?>
						</td>
						<td>
						<?php
							if(!empty($mappingData[0]['visa_approved']))
							{
								echo $mappingData[0]['visa_approved'];
								
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
					
					            <div class="box-body">
                <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                        <form id="form-visa" action="<?php echo site_url(); ?>applicant/visaapply/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <div class="box-body">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	   	 
 <input type = "hidden" name = "app_id" value = "<?php echo $appno;?>">

                       <div class="col-sm-12">
										
						
						<div class="row">
							<div class="col-sm-3">
								<label>VISA Type</label>
								<select class="form-control">
					      	
					      	<?php 
					      	$course =$applicaitonStepOne[0]['programme'];
					      	if($course == 3 || $course == 4)
					      	{
							?>
								<option value="2">Research</option>
							<?php	
							}
							else
							{
							?>
								<option value="1">Student</option>
								<option value="2">Research</option>
							<?php	
							}
					      	?>				      	
					      </select>
							</div>	
							<div class="col-sm-2">
								<label>VISA Number</label>
								 <input type="text" class="form-control" id="visa_no" name="visa_no" required="true" placeholder="VISA Number"/>
							</div>	
							<div class="col-sm-2">
								<label>VISA Issue Date</label>
								<input type="text" class="form-control datepicker_visa_issuedate" id="visa_issue_date" name="visa_issue_date" required="true" placeholder="VISA Issue Date"/>	
							</div>	

							<div class="col-sm-2">
								<label>VISA Duration From</label>
								<input type="text" class="form-control datepicker_visa_issuedate" id="visa_from_date" name="visa_from_date" required="true" placeholder="From"/ autocomplete = "off">	
							</div>
						<div class="col-sm-2">
						<label>VISA Duration To</label>
							 <input type="text" class="form-control datepicker_visa_issuedate" id="duration_to_date" name="duration_to_date" required="true" placeholder="To" autocomplete = "off"/>	 
							</div>
							<div class="col-sm-2">
						<label>VISA Issued Place</label>
							 <input type="text" class="form-control datepicker_visa_issueplace" id="visa_issueplace" name="visa_issueplace" required="true" placeholder="VISA Issued Place" autocomplete = "off"/>	 
							</div>
							<div class="col-sm-2">
						<label>VISA Approved Status</label>
							 <input type="text" class="form-control datepicker_visa_approved" id="visa_approved" name="visa_approved" required="true" placeholder="VISA Approved Status" autocomplete = "off"/>	 
							</div>
						</div>
						
</br>
                                <div class="col-sm-2 pull-right">
                                    <input type="submit" class="form-control sbmt" value="Submit"/>
                                </div>


                            </div>
                            <!-- /.box-body -->
                        </form>
                    </div>
                    <br/>					

                </div>

                <!-- /.box-body -->

            </div>
					<?php
				}
				
				?>
				
	
            <hr>
        </div>
    </div>
</section>
<script>
 $('.datepicker_visa_issuedate').datepicker({
		changeMonth: true,
		//minDate:"+0M + 0D",
		//maxDate:"+0M +0D",
		changeYear: true,
		yearRange: "-0:+5",
		dateFormat: 'dd-mm-yy'
	});
</script>
	
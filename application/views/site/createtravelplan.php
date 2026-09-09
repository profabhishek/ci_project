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
.link_div{
	 border: 1px solid red;
    border-radius: 7px;
    display: block;
    float: left;
    margin-top: 1px;
    padding: 5px;
    width: 107px;
    text-align: center;
}
input,select,label{font-size:14px !important;}
.tab-content input[type="text"], select {
    background: #fffdca none repeat scroll 0 0 !important;
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
<script type="text/javascript">
	function showcityother(id)
	{
		var v = $('#'+ id).val();
		if(v==7)
		{
			$('.city_other').addClass("in");
		}
		else
		{
			$('.city_other').removeClass("in");
		}
	}
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
						
						
				//echo "<pre>";print_r($userd);die;
				$currentyear = date('Y');
				if (!empty($userd->dir)) {
					$ar = explode('/',$userd->dir);
					$oldYear = isset($ar[2]) ? $ar[2] : 'main';
				} else {
					$oldYear = 'main';
				}
				//echo $oldYear;
				if($oldYear == 'main')
				{
					?>
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
					<?php
				}
				else{
					?>
					   	<div class="col-xs-3 prfl pull-right" >
              		<?php              			 
              			
              			$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']); 
						$dirdata = $userd->dir;
						//$oldYear = explode('/',$dirdata);
						//echo "<pre>";print_r($oldYear);die;
						if (file_exists($userd->dir .'/'.$userImage) && is_file($userd->dir .'/'.$userImage)) {
							$imgs = file_get_contents($userd->dir .'/'.$userImage);
							//echo $imgs;
							$data = base64_encode($imgs);
							$f = finfo_open();
							$imgdata = base64_decode($data);
                            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
						}
						//echo "<pre>";print_r($userd->dir);die;
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
					
					<?php
				}
				
				
          				/*if($userd->dir == "")
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
              		
					*/?>
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
                                                if ($applicaitonStepOne[0]['nationality'] == $na['id']) {
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
                                        <label>6. Phone No : </label></td>
                                    <td align="left" style="height:35px;">:&nbsp;&nbsp;<?php
                                        $phone = '';
                                        if (count($applicaitonStepOne) > 0) {
                                            $phone = $applicaitonStepOne[0]['phone_number'];
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
                     <th >Nomenclature</th>
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
							$userd = $this->common_model->getUserInfo($applicaitonStepOne[0]['uid']);
                                //echo "<pre>";print_r($userd);die;
                                $currentyear = date('Y');
                                if (!empty($userd->dir)) {
                                    $ar = explode('/',$userd->dir);
                                    $oldYear = isset($ar[1]) ? $ar[1] : 'main';
                                } else {
                                    $oldYear = 'main';
                                }
								
									     //echo "<pre>";print_r($mappingData);
										 
							  $response = $this->common_model->getconfirmationDataByMission($mappingData[0]['application_no']);
							  $file_path_un = './'.$currentyear.'/university_approval/'.(!empty($response) ? $response[0]['region_one_doc'] : '');
							  // echo "<pre>";print_r($ar);
							  if($oldYear == 'main')
								{

							   //echo "<pre>";print_r($response);
                                   if($mappingData[0]['mission_status'] == 1) {
									   ?>
                                        <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo !empty($response[1]) ? $response[1]['region_one_doc'] : ''; ?>" target="_blank"><span class = "label label-success">Downloads</span></a>
										<?php
                                    }
									
                                
                            
								}
								elseif($oldYear == 2022||$oldYear == 2023||$oldYear == 2024||$oldYear == 2025||$oldYear == 2026)
								{
                                  //  echo "else20";
							 if(strpos($file_path_un,'.pdf')){ ?>
					<a target="_blank" href="<?php echo site_url().'applicant/downloadDocs/'.base64url_encode($file_path_un);?>" target="_blank"><span class = "label label-success">Download</span></a>
						   <?php }
                            else if (!empty($response[0]['region_one_doc']) && is_file($file_path_un)) {
								// $response[0]['region_one_doc'] can be blank when the university
								// hasn't uploaded an approval document yet, which made
								// $file_path_un resolve to just the folder path (e.g.
								// "./2026/university_approval/") instead of a real file -
								// file_get_contents() on a directory logged a "failed to
								// open stream" notice every time. Only attempt to read it
								// once we know a real file is actually there.
						     $imgs = file_get_contents($file_path_un);
							 $data = base64_encode($imgs);
							 $f = finfo_open();
							 $imgdata = base64_decode($data);
                             $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
				  echo $output = '<a download="'.rand().time().'" href="data:'.$mime_type.';base64,'.$data.'" target = "_blank"><span class = "label label-success">Download</span></a>';

							}
							else {
								echo '<span class="label label-default">Not Available</span>';
							}
								
									?>
												

<?php
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
				<!------Visa Details------>
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
					      	if($course == 4)
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
					
				
					
			<!------Travel Details------>
			
			
				
				<?php
				
				if(!empty($travel))
				{
					?>
					 <table id="tbl_relation" class="table" style="width: 100%;">
                    <thead>
                    <th>15. Flight/Train Details</th>
					<th>Flight/Train No</th>
					<th>Date of Depature</th>
					<th>Time of Departure</th>
                    <th>Departure City</th>
					<th>Date of Arival in India</th>
					<th>Time of Arrival</th>
                    <th>Arrival City</th>
					<th>Airport Reseption</th>
					<!--<th>Cost of Ticket (INR)</th>-->
                    </thead>
                    <tbody>

						<tr>

					<td></td>
					<td>
						<?php
							if(!empty($travel)){

							echo $travel[0]['flight_no'];
						}


							?>
						</td>
						<td>
					 <?php
						if(!empty($travel)){

							echo $travel[0]['departure_date'];
						}

					 ?>
					 </td>
						<td>
						<?php
							if(!empty($travel)){

							echo $travel[0]['time_of_departure'];
						}


							?>
						</td>

						<td>
						<?php
							if(!empty($travel)){

							echo $travel[0]['departure_city'];
						}


							?>
						</td>
						<td>
						<?php
							if(!empty($travel)){

							echo $travel[0]['travel_arrival_date'];
						}


							?>
						</td>
						<td>
						<?php
							if(!empty($travel)){

							echo $travel[0]['time_of_arrival'];
						}

							?>
						</td>
						<td>
						<?php
							if(!empty($travel)){

							$cities = $this->config->item('grade_cities');
							$cityId = $travel[0]['final_city_arrival'];
							if($cityId == 7){
								echo !empty($travel[0]['city_other']) ? $travel[0]['city_other'] : (isset($cities[$cityId]) ? $cities[$cityId] : '');
							} else {
								echo isset($cities[$cityId]) ? $cities[$cityId] : $cityId;
							}
						}


							?>
						</td>
						<td>
						<?php
							if(!empty($travel)){

							echo $travel[0]['airport_reseption'];
						}


							?>
						</td>
						</tr>
                    </tbody>
                </table>
					<?php } ?>





            <hr>
			
			
			
			
			
			
			
        </div>
    </div>
</section>

<?php  
//echo "<pre>";print_r($mappingData);
if(empty($travel) && $mappingData[0]['status'] >= 11 && $mappingData[0]['scholar_acceptance'] == 1)

{
	?>
	
<section class="meacontent">	
	<div  class="container" style="min-height:410px;padding:0px;">		
	<div class="tab-content footr">		
	  <div id="home" class="tab-pane fade in active ">	   
	    <form id="form-visa" action="<?php echo site_url();?>applicant/travelpaln/<?php echo $appno; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
	      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	     <div class="box-body">
		 <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Flight/Train No</label>
		    <div class="col-sm-6">
		     	<input type="text" name="flight_no" id="flight_no" required="true" class="form-control datepicker_arrival" placeholder="Flight No"/>
		    </div>	
		  </div>
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Date of Departure</label>
		    <div class="col-sm-6">
		     	<input type="text" name="departure_date" id="departure_date" required="true" class="form-control datepicker_arrival" placeholder="Date of Departure"/>
		    </div>	
		  </div> 
		  <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Time of Departure</label>
		    <div class="col-sm-6">
		     	<input type="text" name="time_of_departure" id="time_of_departure" required="true" class="form-control datepicker_arrival" placeholder="Time of Departure"/>
		    </div>	
		  </div> 
		  		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Departure City</label>
		    <div class="col-sm-6">
		     	<input type="text" name="departure_city" id="departure_city" placeholder="Departure City" class="form-control" required="true"/>
		    </div>	
		  </div> 
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Date of Arival in India</label>
		    <div class="col-sm-6">
		     	<input type="text" name="travel_arrival_date" placeholder="Date of Arrival in India" id="travel_arrival_date" required="true" class="form-control datepicker_arrival" placeholder="Arival Date"/>
		    </div>	
		  </div> 

		  <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Time of Arrival</label>
		    <div class="col-sm-6">
		     	<input type="text" name="time_of_arrival" id="time_of_arrival" required="true" class="form-control datepicker_arrival" placeholder="Time of Arrival"/>
		    </div>	
		  </div> 
		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Final City of arrival</label>
		    <div class="col-sm-3">
		    	<select id="final_city_arrival" name="final_city_arrival" class="form-control" required="true" onchange="showcityother(this.id);">
		    		<option value="">Select</option>
		    		<?php
		    			$cities = $this->config->item('grade_cities');
		    			
		    			foreach($cities as $cityid=>$ctyName)
		    			{
							echo '<option value="'.$cityid.'">'.$ctyName.'</option>';
						}
		    		?>
		    	
		    	</select>
		    </div>
		    <div class="col-sm-3 fade city_other">
		    	<input type="text" name="city_other" id="city_other" placeholder="Other City" class="form-control"/>
		    </div>	
		  </div> 
		  		    <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft" class="form-control">Airport Reseption</label>
		    <div class="col-sm-6">
		     	<input type="text" name="airport_reseption" placeholder="Airport Reseption" id="airport_reseption" required="true" class="form-control datepicker_arrival"/>
		    </div>	
		  </div>
		 <!-- <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Regional Office to be contacted</label>
		    <div class="col-sm-6">
		    	<?php
					$data = $this->common_model->getConfirmationofApplicationIds($appno);
					$reg = !empty($data) ? $this->common_model->getRegionById($data[0]->region_one_status) : [];
				?>
		     	<input type="text" class="form-control" value="<?php echo !empty($reg) ? $reg[0]['name'] : '';?>" readonly="true"/>
		     	<input type="hidden" name="regional_office_contacted" id="regional_office_contacted" class="form-control" value="<?php echo !empty($reg) ? $reg[0]['id'] : '';?>"/>
		    </div>	
		  </div>-->
		 <!-- <div class="form-group col-xs-10">
		    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Cost of Ticket (INR)</label>
		    <div class="col-sm-6"> 
		     	<input type="text" name="cost_of_ticket" id="cost_of_ticket"  placeholder="Cost of Ticket" class="form-control" required="true"/>
		    </div>	
		  </div> -->
	     
	     
	    <!--<div class="form-group col-xs-10">
					    <label for="inputEmail3" class="col-sm-3 control-label  pdright pdleft">Upload Travel Schedule</label>
					    <div class="col-sm-3">
					      <input type="file"  name="travel_plan_doc" id="travel_plan_doc" required="true"  />
					    </div>
					
					   	
					</div> -->
					
					<br/><br/>
					 <div class="col-md-12 pull-right pdleft">
					      <input type="submit" class="form-control sbmt" value="Submit"/>
					    </div>
						</div>	
	   
              <!-- /.box-body -->
            </form>
	  </div>	   
	</div>
	</div>
</section>
	<?php
}

?>

	
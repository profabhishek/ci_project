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
<section class="meacontent">
    <div  class="container" style="min-height:410px;padding-top:16px;">
        <marquee style="margin-bottom:5px;padding-top:0;">
            Welcome <?php
            $user_data = $this->session->userdata('user_data');
            echo $user_data['fname'];
            ?> to ICCR Scholarship Portal 
        </marquee>	
        <div class="blue-heading col-md-12 ">
            <h3>Acceptance/Declined by Applicant</h3>
            <?php $title = base64_encode("Acceptance/Declined by Applicant."); ?>
            <form method="post" action="<?php echo base_url(); ?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;">
                <input id="pdftitle" name="pdftitle" value="<?php echo $title; ?>" type="hidden"/> 
                <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
                <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
            </form>
            <a href="<?php echo site_url(); ?>regional/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
        <table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
            <thead>
            <th>S.No.</th>
         <th>Application No</th>				
            <th>Applicant Name</th>	
            <th>Email Id</th>	
            <th>Course</th>	
            <th>Scheme</th>	
            <th>University</th>				
            <th>Country</th>
            <th>Status </th>	
			<th>Undertaking</th>			
            <th>View </th>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                if (count($listofacceptance) > 0) {
                    foreach ($listofacceptance as $app) {
                        ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
							<?php 	$date1 = '2019-12-01';
						//$date1 = '2019-12-01';
						$date = date_create($app['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($app['created']);
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}?>
							<td><?php echo $app['application_no'];?></td>
                            <td><?php echo $app['fullname'];?></td>
                            <td><?php echo $app['email']; ?></td>
                            <td><?php $course = $this->common_model->getCoursesById($app['course']);
                echo $course[0]['title']; ?></td>
                            <td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);
                echo $uni[0]['scheme_name']; ?></td>
                            <td><?php
                                $data = $this->common_model->getConfirmationofApplicationIds($app['application_no']);
                                //$data = $this->common_model->getconfirmationData($app['application_no']);
                                $uni = $this->common_model->getUniversityById($data[0]->regional_university);
                                echo $uni[0]['name'];
                                ?></td>	
                            <td><?php echo $app['country_name']; ?></td>
                            <td>
                                <?php
                                if ($app['scholar_acceptance'] == 1) {
                                    echo "Accepted";
                                } elseif ($app['scholar_acceptance'] == 2) {
                                    echo "Declined";
                                }
                                ?>
                            </td>	
							<td><a download href="<?php echo site_url();?>assets/site/main/undertakings/<?php echo $app['undertaking_doc'];?>">Download</td>							
                            <td>
                                <a style="height:34px;width:140px;" class="form-control sbmt1" href="<?php echo site_url(); ?>regional/applicantAcceptanceStatus/<?php echo $app['application_no']; ?>" target = "__blank">View</a>

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
	
	
	
	
	 <div class="blue-heading col-md-12 ">
            <h3>Acceptance/Declined by Applicant(Ayush)</h3>
            <?php $title = base64_encode("Acceptance/Declined by Applicant."); ?>
            <form method="post" action="<?php echo base_url(); ?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;">
                <input id="pdftitle" name="pdftitle" value="<?php echo $title; ?>" type="hidden"/> 
                <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
                <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
            </form>
            <a href="<?php echo site_url(); ?>regional/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
        <table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
            <thead>
            <th>S.No.</th>
         <th>Application No</th>				
            <th>Applicant Name</th>	
            <th>Email Id</th>	
            <th>Course</th>	
            <th>Scheme</th>	
            <th>University</th>				
            <th>Country</th>
            <th>Status </th>	
			<th>Undertaking</th>			
            <th>View </th>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                if (count($listofacceptanceAyush) > 0) {
					//echo "<pre>";print_r($listofacceptanceAyush);
                    foreach ($listofacceptanceAyush as $app) {
						//echo "<pre>";print_r($app['regional_university']);
                        ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
							<?php 	$date1 = '2019-12-01';
						//$date1 = '2019-12-01';
						$date = date_create($app['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						//echo $date1;
						//echo $date2;die;
						//print_r($date2);die;
						$studentyreg = strtotime($app['created']);
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}?>
							<td><?php echo $app['application_no'];?></td>
                            <td><?php echo $app['fullname'];?></td>
                            <td><?php echo $app['email']; ?></td>
                            <td><?php $course = $this->common_model->getCoursesById($app['course']);
                echo $course[0]['title']; ?></td>
                            <td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);
                echo $uni[0]['scheme_name']; ?></td>
                            <td><?php
                                $data = $this->common_model->getConfirmationofApplicationAyushIds($app['application_id']);
								//echo "<pre>";
					//print_r($data);die;
                                //$data = $this->common_model->getconfirmationData($app['application_no']);
                                $uni = $this->common_model->getAlumniUniversityById($data[0]->regional_university);
                                echo $uni[0]['name'];
                                ?></td>	
                            <td><?php echo $app['country_name']; ?></td>
                            <td>
                                <?php
                                if ($app['scholar_acceptance'] == 1) {
                                    echo "Accepted";
                                } elseif ($app['scholar_acceptance'] == 2) {
                                    echo "Declined";
                                }
                                ?>
                            </td>	
							<td><a download href="<?php echo site_url();?>assets/site/main/undertakings/<?php echo $app['undertaking_doc'];?>">Download</td>							
                            <td>
                                <a style="height:34px;width:140px;" class="form-control sbmt1" href="<?php echo site_url(); ?>regional/applicantAcceptanceStatus/<?php echo $app['application_no']; ?>" target = "__blank">View</a>

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

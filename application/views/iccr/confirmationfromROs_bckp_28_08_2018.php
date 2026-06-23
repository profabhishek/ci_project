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
<section class="meacontent">
    <?php
    if ($this->session->flashdata('message_type') == "success") {
        ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php
    }
    if ($this->session->flashdata('message_type') == "error") {
        ?>
        <div class="alert alert-error" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php
    }
    ?>
    <div  class="container" style="min-height:410px;padding-top:15px;">	
        <marquee style="margin-bottom:5px;padding-top:0;">
            Welcome <?php
            $user_data = $this->session->userdata('user_data');
            echo $user_data['fname'];
            ?> to ICCR Scholarship Portal 
        </marquee>
        <div class="blue-heading col-md-12 ">
            <h3>University Response Received from RO</h3>
            <?php $title = "University Response Received from RO"; ?>
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
        <table  id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
            <thead>
            <th>S.No.</th>				
            <th>Applicant Name</th>
            <!--<th>Email Id</th>-->
            <th>Country</th>
            <th>Scheme</th>
            <th>Course</th>				
            <th>University</th>
            <th>Region</th>				
            <th>University Letter</th>	
            <th>University Status</th>			
            <th>Forward to Mission </th>
            <th>View </th>				
            </thead>
            <tbody>
                <?php
                $counter = 1;
                if (count($confirmationfromROs) > 0) {
                    foreach ($confirmationfromROs as $app) {
                        $response = $this->common_model->getUniversityResponses($app['application_no']);
                        $resp = explode(',', $response[0]['response']);
                        $confirmed_to_mission = explode(',', $response[0]['confirmed_to_mission']);
                        if ($response[0]['response'] != "2,2,2") {
                            ?>
                            <tr>
                                <td><?php echo $counter; ?></td>					
                                <td><?php echo $app['fullname']; ?></td>
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
                                    $course = "";
                                    foreach ($uniar as $key => $u) {
                                        $c = $this->common_model->getCourseDetails($app['application_no'], $key);
                                        //print_r( $this->common_model->getCourseDetails($app['application_no'],$key));
                                        $course .= $c['course_name'];
                                        if ($c['subject'] != "")
                                            $course .= $c['subject'];
                                        $course .= "<br/>";
                                    }
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
                                    $docs = explode(';', $response[0]['docs']);
                                    $cont = 1;
                                    foreach ($docs as $doc) {
                                        ?>
                                        <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/university_approval/<?php echo $doc; ?>" target="_blank">Download Letter <?php echo $cont; ?></a>
                                        <br>
                                        <?php
                                        $cont++;
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?php
                                    $resp = explode(',', $response[0]['response']);
                                    foreach ($resp as $res) {
                                        if ($res == 1)
                                            echo "Confirmed";
                                        elseif ($res == 2)
                                            echo "Not Confirmed";

                                        echo "<br/>";
                                    }
                                    ?>							
                                </td>
                                <td>						
                                    <?php
                                    if ($app['status'] >= 4) {
                                        $userdata = $this->session->userdata('user_data');
                                        $division = $userdata['state'];

                                        if ($division == 1 || $division == 11 || $division == 12) {

                                            $resp = explode(',', $response[0]['response']);


                                            $counter = 0;
                                            foreach ($resp as $res) {
                                                if ($res == 1) {
                                                    if ($confirmed_to_mission[$counter] == -1) {
                                                        ?>
                                                        <a class="form-control sbmt" style="height:42px;width:140px;" href="<?php echo site_url(); ?>headquarter/beforeconfirmtoMission/<?php echo $app['application_no']; ?>/<?php echo $keyid; ?>">(A) Forward To Mission</a>
                                                        <?php
                                                    } else {
                                                        echo "Sent to Mission";
                                                    }
                                                } elseif ($res == 2) {
                                                    if ($confirmed_to_mission[$counter] == -1) {
                                                        ?>
                                                        <a class="form-control sbmt" style="height:42px;width:140px;" href="<?php echo site_url(); ?>headquarter/beforerejectiontoMission/<?php echo $app['application_no']; ?>/<?php echo $keyid; ?>">(R) Forward To Mission</a>
                                                        <?php
                                                    } else {
                                                        echo "Sent to Mission";
                                                    }
                                                }
                                                echo "<br/>";
                                                $counter++;
                                            }
                                        } else {
                                            echo "Not Authorised";
                                        }
                                    } elseif ($app['status'] >= 10) {

                                        echo "Sent to Mission";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a style="height:34px;width:140px;" class="form-control sbmt1" href="<?php echo site_url(); ?>headquarter/universityResponse/<?php echo $app['application_no']; ?>">View</a>
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

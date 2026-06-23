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
            <th>Course</th>
            <th>Country</th>
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
                        if ($response[0]['response'] == "2,2,2") {
                            ?>
                            <tr>
                                <td><?php echo $counter; ?></td>					
                                <td><?php echo $app['fullname']; ?></td>						
                                <td><?php $course = $this->common_model->getCoursesById($app['course']);
                echo $course[0]['title']; ?></td>
                                <td><?php echo $app['country_name']; ?></td>							
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
                                    $docs = explode(',', $response[0]['docs']);
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
                                            echo "Accepted";
                                        elseif ($res == 2)
                                            echo "Declined";

                                        echo "<br/>";
                                    }
                                    ?>							
                                </td>
                                <td>

                                    <?php
                                    if ($app['status'] == 4) {
                                        $userdata = $this->session->userdata('user_data');
                                        $division = $userdata['state'];
                                        if ($division == 1) {
                                            ?>
                                            <a class="form-control sbmt" style="height:30px;width:140px;" href="<?php echo site_url(); ?>headquarter/processfourthchoice/<?php echo $app['application_no']; ?>">Process</a>
                                            <?php
                                        } else {
                                            echo "Not Authorised";
                                        }
                                    } elseif ($app['status'] >= 10) {
                                        echo "Forwarded to Mission";
                                    }
                                    ?>

                                </td>
                                <td>


                                    <a style="height:34px;width:140px;" class="form-control sbmt1" href="<?php echo site_url(); ?>headquarter/universityResponse/<?php echo $app['application_no']; ?>">View</a>

                                </td>
                            </tr>
                                    <?php
                                }
                                $counter++;
                            }
                        }
                        ?>
            </tbody>
        </table>
        <hr/>
    </div>
</section>

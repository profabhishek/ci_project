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
<script>
    var editor; 
    $(document).ready(function () {
        
        $('#example').dataTable({
            "destroy": true,
            "lengthMenu": [[10, 25, 50, 200, 500,  -1], [10, 25, 50, 200, 500, "All"]],
//            "processing": true,
//            "serverSide": true,
//            "ajax": {
//                "url": "<?php //echo base_url();?>headquarter/getSchemewiseApplicantReportAjax",
//                "dataType": "json",
//                "type": "GET"
//            },
//        "columns": [
//            { "data": "fullname" },
//            { "data": "application_no" },
//            { "data": "email" },
//            { "data": "scheme_name" },
//            { "data": "university_is_accept" }
//        ]
        });
    });

</script>
<section class="meacontent">

    <div  class="container" style="min-height:410px;padding-top:15px;">	
        <marquee style="margin-bottom:5px;padding-top:0;">
            Welcome <?php
            $user_data = $this->session->userdata('user_data');
            echo $user_data['fname'];
            ?> to ICCR Scholarship Portal 
        </marquee>
        <div class="blue-heading col-md-12 ">
            <h3>Total Accepted/Rejected List of Applicant</h3>
            <?php $title = "Total Accepted/Rejected List of Applicant"; ?>
            <form method="post" action="<?php echo base_url(); ?>headquarter/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
                  ">
                <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
                <input id="pdftitle" name="pdftitle" value="<?php echo $title; ?>" type="hidden"/>
                <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
            </form>
            <a href="<?php echo site_url(); ?>headquarter/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
        <table  id="example" class="customTable table table-striped table-bordered detailpagepdf">
            <thead>
           <th>Serial Number</th>			
            <th>Applicant Name</th>
            <th>Application No.</th>
            <th>Email Id</th>          
            <th>Scheme</th>           				
            <th>University Status</th>
            </thead>
            <tbody>
                <?php
                $counter = 1;

                if (count($totalrecords) > 0) {
                    foreach ($totalrecords as $app) {
                        ?>
                        <tr>
                            <td><?php echo $counter;?></td>				
                            <td><?php echo $app['fullname']; ?></td>
                            <td><?php echo $app['application_no']; ?></td>
                            <td><?php echo $app['email']; ?></td>
                            <td><?php echo $app['scheme_name']; ?></td>		
                            <td><?php if ($app['university_is_accept'] == 1) echo "Accepted"; 
                            if($app['university_is_accept'] == 2) echo "Rejected"; 
                            ?>
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

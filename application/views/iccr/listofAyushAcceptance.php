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
            <h3>Ayush Acceptance/Declined by Applicant</h3>
            <?php $title = base64_encode("Acceptance/Declined by Applicant."); ?>
            <form method="post" action="<?php echo base_url(); ?>headquarter/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;">
                <input id="pdftitle" name="pdftitle" value="<?php echo $title; ?>" type="hidden"/> 
                <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
                <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
            </form>
            <a href="<?php echo site_url(); ?>headquarter/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
		<div class="container">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>
        <table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
            <thead>
            <th>S.No.</th>				
            <th>Applicant Name</th>	
            <th>Email Id</th>	
            <th>Course</th>	
            <th>Scheme</th>	
            <th>University</th>				
            <th>Country</th>
            <th>Status </th>
			<th>Year</th>
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

                            <td><?php echo $app['fullname']; ?></td>
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
							<td><?php echo date("Y-m-d", $app['created']); ?></td>
                            <td>
                                <a style="height:34px;width:140px;" class="form-control sbmt1" href="<?php echo site_url(); ?>headquarter/applicantAcceptanceStatus/<?php echo $app['application_no']; ?>">View</a>

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
<script>
$(document).ready(function(){
	
$('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});

// Set up your table
table = $('.customTable1').DataTable({
  paging: true,
  info: true
});

// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[8] || 0; // Our date column in the table

    if (
      (min == "" || max == "") ||
      (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
    ) {
      return true;
    }
    return false;
  }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change(function() {
  table.draw();
});

$('#my-table_filter').hide();
});
</script>
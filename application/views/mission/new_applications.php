<style type="text/css">
    #frm_details_ngo {
        float: right;
        position: absolute !important;
        right: 0;
        top: 11px !important;
    }

    .blue-heading h3 {
        margin-top: 13px !important;
        font-weight: bold;

    }

    marquee {

        border: 1px solid #cecece;
        color: #f18f2e;
        float: none;
        font-weight: bold;
        height: 35px;
        margin: 0 auto 5px;
        padding: 7px 5px 0;
        text-align: left;
    }

    /* ---------------------------------------------------------------
       Filter panel. All rules are prefixed .mna- and scoped to
       #form-filter on this page, so no other screen is affected.
       The grid gives every field the same width and spacing and
       collapses to one column on small screens.
       --------------------------------------------------------------- */
    #form-filter.mna-filter {
        clear: both;
        margin: 0 0 18px;
    }

    #form-filter .mna-card {
        background: #fff;
        border: 1px solid #e2e6ea;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(16, 24, 40, .06);
        padding: 16px 18px 18px;
    }

    #form-filter .mna-card-head {
        border-bottom: 1px solid #eef1f4;
        margin: -2px 0 16px;
        padding-bottom: 10px;
    }

    #form-filter .mna-card-title {
        color: #1f3c68;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: .2px;
    }

    #form-filter .mna-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 14px 18px;
    }

    /* Three columns on a desktop: the six filters form two even rows of
       three, instead of four in one row and two in the next. */
    @media (min-width: 992px) {
        #form-filter .mna-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    #form-filter .mna-field {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    #form-filter .mna-field > label {
        color: #43526b;
        font-size: 12.5px;
        font-weight: 600;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    #form-filter .mna-field .form-control {
        height: 38px;
        width: 100%;
        border: 1px solid #d5dbe2;
        border-radius: 4px;
        box-shadow: none;
        font-size: 13.5px;
        color: #24303f;
    }

    #form-filter .mna-field .form-control:focus {
        border-color: #4a90d9;
        box-shadow: 0 0 0 3px rgba(74, 144, 217, .15);
    }

    #form-filter .mna-field select.form-control[disabled] {
        background: #f3f5f7;
        color: #8a94a3;
        cursor: not-allowed;
    }

    #form-filter .mna-hint {
        color: #8a94a3;
        font-size: 11.5px;
        margin-top: 4px;
        min-height: 14px;
    }

    /* The six text/select filters fill the grid evenly; the date range sits
       on its own full-width row underneath so no row is left half empty. */
    #form-filter .mna-field-wide {
        grid-column: 1 / -1;
    }

    /* Date range: the two inputs share the row evenly. */
    #form-filter .mna-daterange {
        display: flex;
        max-width: 420px;
        width: 100%;
    }

    #form-filter .mna-daterange .form-control {
        flex: 1 1 0;
        border-radius: 4px;
    }

    #form-filter .mna-daterange .input-group-addon {
        background: #f3f5f7;
        border: 1px solid #d5dbe2;
        border-left: 0;
        border-right: 0;
        color: #6b7686;
        display: flex;
        align-items: center;
        font-size: 12px;
        padding: 0 10px;
    }

    #form-filter .mna-actions {
        border-top: 1px solid #eef1f4;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 16px;
        padding-top: 14px;
    }

    #form-filter .mna-actions .btn {
        border-radius: 4px;
        font-size: 13.5px;
        font-weight: 600;
        min-width: 120px;
        padding: 8px 18px;
    }

    @media (max-width: 767px) {
        #form-filter .mna-card {
            padding: 14px;
        }

        #form-filter .mna-grid {
            grid-template-columns: 1fr;
        }

        #form-filter .mna-actions .btn {
            flex: 1 1 0;
            min-width: 0;
        }
    }

    /* ---------------------------------------------------------------
       Dropdowns. Native selects are replaced with a chevron of our own
       (an inline SVG, so nothing extra is loaded) and the browser's
       default arrow is removed. The rule covers both the filter selects
       and the DataTables "Show N entries" select.
       --------------------------------------------------------------- */
    #form-filter select.form-control,
    #tbl_schrls_wrapper .dataTables_length select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='none' stroke='%236b7686' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round' d='M1 1.5l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 11px center;
        background-size: 11px 7px;
        padding-right: 30px;
    }

    #form-filter select.form-control::-ms-expand {
        display: none;
    }

    #form-filter select.form-control[disabled] {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='none' stroke='%23b3bbc6' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round' d='M1 1.5l5 5 5-5'/%3E%3C/svg%3E");
    }

    #form-filter select.form-control optgroup {
        color: #1f3c68;
        font-style: normal;
        font-weight: 700;
    }

    #form-filter select.form-control option {
        color: #24303f;
        font-weight: 400;
        padding: 4px 0;
    }

    /* ---------------------------------------------------------------
       Results table. Scoped to this page's table and its DataTables
       wrapper, so the column order, export buttons and server-side
       paging all keep working - only the appearance changes.
       --------------------------------------------------------------- */
    .mna-table-wrap {
        background: #fff;
        border: 1px solid #e2e6ea;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(16, 24, 40, .06);
        padding: 14px 14px 4px;
    }

    #tbl_schrls_wrapper .top {
        align-items: center;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    #tbl_schrls_wrapper .dt-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        float: none;
    }

    #tbl_schrls_wrapper .dt-buttons .btn {
        border-radius: 4px;
        font-size: 12.5px;
        font-weight: 600;
        margin: 0;
        padding: 6px 14px;
    }

    #tbl_schrls_wrapper .dataTables_length {
        color: #43526b;
        float: none;
        font-size: 13px;
    }

    #tbl_schrls_wrapper .dataTables_length select {
        border: 1px solid #d5dbe2;
        border-radius: 4px;
        height: 32px;
        margin: 0 6px;
        min-width: 74px;
    }

    #tbl_schrls.customTable1 {
        border: 0;
        border-collapse: collapse;
        margin: 0;
        /* 17 columns never fit on one screen, so the table scrolls sideways
           inside .mna-table-wrap either way. Giving it room stops the long
           University and Nomenclature cells from wrapping into very tall
           rows. */
        min-width: 1500px;
        width: 100%;
    }

    /* Nomenclature (10) and University (11) hold up to five entries each, so
       give them room rather than letting them wrap into very tall rows.
       Email (4) gets a little too. */
    #tbl_schrls.customTable1 > thead th:nth-child(4),
    #tbl_schrls.customTable1 > tbody > tr > td:nth-child(4) {
        min-width: 190px;
    }

    #tbl_schrls.customTable1 > thead th:nth-child(10),
    #tbl_schrls.customTable1 > tbody > tr > td:nth-child(10),
    #tbl_schrls.customTable1 > thead th:nth-child(11),
    #tbl_schrls.customTable1 > tbody > tr > td:nth-child(11) {
        min-width: 230px;
    }

    /* "Print" is rendered with btn-secondary, which Bootstrap 3 does not
       define, so it would otherwise have no styling at all. */
    #tbl_schrls_wrapper .dt-buttons .btn-secondary {
        background: #fff;
        border: 1px solid #c9d3de;
        color: #1f3c68;
    }

    #tbl_schrls_wrapper .dt-buttons .btn-secondary:hover {
        background: #f0f6fd;
        border-color: #1f6fc4;
        color: #17579b;
    }

    #tbl_schrls.customTable1 > thead th {
        background: #f4f7fa;
        border: 0;
        border-bottom: 2px solid #dfe5ec;
        color: #1f3c68;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .4px;
        padding: 11px 12px;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
    }

    #tbl_schrls.customTable1 > tbody > tr > td {
        background: transparent;
        border: 0;
        border-bottom: 1px solid #eef1f4;
        color: #24303f;
        font-size: 13px;
        line-height: 1.5;
        padding: 10px 12px;
        vertical-align: middle;
    }

    #tbl_schrls.customTable1 > tbody > tr:nth-child(even) > td {
        background: #fafbfc;
    }

    #tbl_schrls.customTable1 > tbody > tr:hover > td {
        background: #f0f6fd;
    }

    /* The action links carry inline width/float from the controller, so
       these need !important to line them up as buttons. */
    #tbl_schrls.customTable1 .sbmt,
    #tbl_schrls.customTable1 .sbmt1 {
        border-radius: 4px;
        display: inline-block;
        float: none !important;
        font-size: 12.5px;
        font-weight: 600;
        height: auto !important;
        margin: 0 !important;
        padding: 6px 12px !important;
        text-align: center;
        white-space: nowrap;
        width: 100% !important;
        min-width: 84px;
    }

    #tbl_schrls.customTable1 a.sbmt {
        background: #1f6fc4;
        border: 1px solid #1f6fc4;
        color: #fff;
    }

    #tbl_schrls.customTable1 a.sbmt:hover {
        background: #17579b;
        border-color: #17579b;
        color: #fff;
        text-decoration: none;
    }

    #tbl_schrls.customTable1 a.sbmt1 {
        background: #fff;
        border: 1px solid #c9d3de;
        color: #1f3c68;
    }

    #tbl_schrls.customTable1 a.sbmt1:hover {
        background: #f0f6fd;
        border-color: #1f6fc4;
        color: #17579b;
        text-decoration: none;
    }

    #tbl_schrls.customTable1 a.disabled,
    #tbl_schrls.customTable1 a[disabled] {
        background: #f1f3f5 !important;
        border: 1px solid #e0e4e9 !important;
        color: #98a1ae !important;
        cursor: not-allowed;
        pointer-events: none;
    }

    #tbl_schrls_wrapper .dataTables_info {
        color: #6b7686;
        font-size: 12.5px;
        padding-top: 14px;
    }

    #tbl_schrls_wrapper .dataTables_paginate {
        padding-top: 10px;
    }

    #tbl_schrls_wrapper .dataTables_paginate .paginate_button {
        border-radius: 4px !important;
        font-size: 12.5px;
        padding: 5px 11px;
    }

    #tbl_schrls_wrapper .dataTables_paginate .paginate_button.current {
        background: #1f6fc4 !important;
        border-color: #1f6fc4 !important;
        color: #fff !important;
    }

    @media (max-width: 767px) {
        .mna-table-wrap {
            padding: 12px 10px 4px;
        }

        #tbl_schrls_wrapper .top {
            justify-content: flex-start;
        }

        #tbl_schrls.customTable1 > tbody > tr > td,
        #tbl_schrls.customTable1 > thead th {
            font-size: 12px;
            padding: 8px 9px;
        }
    }
</style>
<?php

function sortByName($a, $b)
{
    $a = $a['uni'];
    $b = $b['uni'];

    if ($a == $b) {
        return 0;
    }

    return ($a < $b) ? -1 : 1;
}
$stateuniversities = $this->common_model->getStateUniversities();

//

$centraluniversities = $this->common_model->getCentralUniversities();

$nits = $this->common_model->getNITUniversities();
$yogas = $this->common_model->getYogaGurus();
$states =  $this->common_model->getAllStates();

$statewiseUniversites = array();
foreach ($states as $st) {
    if (!array_key_exists($st['id'], $statewiseUniversites)) {
        $statewiseUniversites[$st['id']] = array();
    }
}

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
    <div class="container" style="min-height:410px;padding-top:16px;border: 1px solid #cecece;">
        <marquee>Welcome <?php echo $misionData[0]['mission_type'] . ' : ' . $misionData[0]['mission_name']; ?> to ICCR Scholarship Portal.</marquee>
        <div class="blue-heading col-md-12 ">
            <h3>Applications Received</h3>
            <form method="post" action="<?php echo base_url(); ?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
                <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden" />
                <!-- <input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value="" /> -->
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            </form>
            <a href="<?php echo site_url(); ?>mission/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
        <form id="form-filter" class="mna-filter">
            <div class="mna-card">
                <div class="mna-card-head">
                    <span class="mna-card-title">Filter Applications</span>
                </div>
                <div class="mna-grid">
                    <div class="mna-field">
                        <label for="applicant_name">Applicant Name</label>
                        <input type="text" id="applicant_name" name="applicant_name" class="form-control" placeholder="Applicant name" />
                    </div>
                    <div class="mna-field">
                        <label for="mail">Email Id</label>
                        <input type="text" id="mail" name="mail" class="form-control" placeholder="Email Id" />
                    </div>
                    <div class="mna-field">
                        <label for="programmes_mission">Academic Programme</label>
                        <select id="programmes_mission" name="programmes_mission" class="selectpicker form-control">
                            <option value="">Select</option>
                            <?php
                            $programme = $this->common_model->getAllProgramme();
                            foreach ($programme as $na) {
                                echo '<option value="' . $na['id'] . '">' . $na['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    // Course stays disabled until an Academic Programme is chosen:
                    // its options are loaded by programme (assets/site/main/js/custom.js
                    // -> mission/getCourseByPrgrammeold), so on its own it is always
                    // empty. The page script at the bottom keeps the two in step.
                    ?>
                    <div class="mna-field">
                        <label for="courses_mission">Course</label>
                        <select id="courses_mission" name="courses_mission" class="selectpicker form-control" disabled="disabled">
                            <option value="">Select</option>
                        </select>
                        <span class="mna-hint" id="course_hint">Select an Academic Programme first</span>
                    </div>
                    <div class="mna-field">
                        <label for="university">University/Institute</label>
                        <select id="university" name="university" class="selectpicker form-control">
                            <option value="">Select</option>
                            <?php
                            echo '<optgroup label="State Universities">';
                            foreach ($stateuniversities as $univercity) {
                                if (array_key_exists($univercity['state_id'], $statewiseUniversites)) {
                                    array_push($statewiseUniversites[$univercity['state_id']], $univercity);
                                }
                            }
                            foreach ($statewiseUniversites as $key => $univercity1) {
                                if (count($univercity1) > 0) {
                                    $statenames = $this->common_model->getStateById($key);
                                    echo '<optgroup label="&nbsp;&nbsp;&nbsp;' . $statenames[0]['name'] . '" class="stt">';
                                    foreach ($univercity1 as $uni_choice) {
                                        echo '<option value="' . $uni_choice['id'] . '">' . $uni_choice['uni'] . '</option>';
                                    }
                                    echo '</optgroup>';
                                }
                            }

                            echo '</optgroup>';
                            echo '<optgroup label="Central Universities">';
                            foreach ($centraluniversities as $univercity_cnet) {
                                echo '<option value="' . $univercity_cnet['id'] . '">' . $univercity_cnet['uni'] . '</option>';
                            }
                            echo '</optgroup>';
                            echo '<optgroup label="National Institute of Technology (NIT)">';
                            foreach ($nits as $univercity_nit) {
                                echo '<option value="' . $univercity_nit['id'] . '">' . $univercity_nit['uni'] . '</option>';
                            }
                            echo '</optgroup>';
                            echo '<optgroup label="Gurus">';
                            foreach ($yogas as $univercity_yogs) {
                                echo '<option value="' . $univercity_yogs['id'] . '">' . $univercity_yogs['uni'] . '</option>';
                            }
                            echo '</optgroup>';
                            ?>
                        </select>
                    </div>
                    <div class="mna-field">
                        <label for="confirmed">Confirmed</label>
                        <select id="confirmed" name="confirmed" class="form-control">
                            <option value="">Select</option>
                            <option value="-1">All</option>
                            <option value="10">Ayush</option>
                        </select>
                    </div>
                    <div class="mna-field mna-field-wide">
                        <label for="min-date">Date of Registration</label>
                        <div class="input-group input-daterange mna-daterange">
                            <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From">
                            <div class="input-group-addon">to</div>
                            <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To">
                        </div>
                    </div>
                </div>
                <div class="mna-actions">
                    <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                    <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
		<div class="table-responsive mna-table-wrap">
			<table id="tbl_schrls" class="customTable1 table table-striped table-bordered detailpagepdf newApplication">
				<thead>
					<th>S.No.</th>
					<th>Application No</th>
					<th>Applicant Name</th>
					<th>Email Id</th>
					<th>Passport No</th>
					<th>Date of Birth</th>
					<th>Mobile Number</th>
					<th>Gender</th>
					<th>Country</th>
					<th>Nomenclature</th>
					<th>University</th>
					<!--<th>Year</th>--->
					<th>Date of Registration</th>
					<th>Date of Submission</th>
					<th>Confirmation Date</th>
					<th>Action </th>
					<th>View </th>
					<th>Status </th>
				</thead>
				<tbody>


				</tbody>
			</table>
			<hr />
		</div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Status</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
                    <!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->


                </div>
            </div>

        </div>
    </div>
</section>
<script>
    var year = "<?php echo $year; ?>";
    $(document).ready(function() {

        reprottable = $('.newApplication').DataTable({
            "processing": true,
            "searching": false,

            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('mission/getNewApplicaitons/"+year+"') ?>",
                "type": "POST",
                "data": function(data) {
                    data.MinDate = $('#min-date').val();
                    data.MaxDate = $('#max-date').val();
                    data.ApplicantName = $('#applicant_name').val();
                    data.Mail = $('#mail').val();
                    data.Programme = $('#programmes_mission').val();
                    data.Counrse = $('#courses_mission').val();
                    data.Universtiy = $('#university').val();
                    data.Confirmed = $('#confirmed').val();

                }
            },
			       

		"columnDefs": [
            {
                "targets": 0,
                "render": function (data, type, row, meta) {
                    // serial number across pages
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }
        ],

        "lengthMenu": [[10, 25, 50, 100, 1000, 2000], [10, 25, 50, 100, 1000, 2000]],
        "pageLength": 10,

        dom: '<"top"Blftrip>',
        buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            className: 'btn btn-success btn-sm',
            exportOptions: {
                columns: ':visible:not(.noExport)',
                modifier: { page: 'all', search: 'applied', order: 'current' },
                format: {
                    body: function(data, row, column, node){
                        if(column === 0) return row + 1; // SN reset
                        return typeof data === 'string' ? data.replace(/(<([^>]+)>)/gi, "") : data;
                    }
                }
            }
        },
        {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            className: 'btn btn-info btn-sm',
            exportOptions: {
                columns: ':visible:not(.noExport)',
                modifier: { page: 'all', search: 'applied', order: 'current' },
                format: {
                    body: function(data, row, column, node){
                        if(column === 0) return row + 1;
                        return typeof data === 'string' ? data.replace(/(<([^>]+)>)/gi, "") : data;
                    }
                }
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf-o"></i> PDF',
            className: 'btn btn-danger btn-sm',
            orientation: 'landscape',
            pageSize: 'A3',
            exportOptions: {
                columns: ':visible:not(.noExport)',
                modifier: { page: 'all', search: 'applied', order: 'current' },
                format: {
                    body: function(data, row, column, node){
                        if(column === 0) return row + 1;
                        return typeof data === 'string' ? data.replace(/(<([^>]+)>)/gi, "") : data;
                    }
                }
            }
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> Print',
            className: 'btn btn-secondary btn-sm',
            exportOptions: {
                columns: ':visible:not(.noExport)',
                modifier: { page: 'all', search: 'applied', order: 'current' },
                format: {
                    body: function(data, row, column, node){
                        if(column === 0) return row + 1;
                        return typeof data === 'string' ? data.replace(/(<([^>]+)>)/gi, "") : data;
                    }
                }
            }
        }
    ],


            oLanguage: {
                sProcessing: "<div id='loaderlogs'><img src='" + baseURL + "/assets/site/main/images/loader.gif'></div>"
            }
        });


        $('.input-daterange input').each(function() {
            $(this).datepicker('clearDates');
        });

        // Set up your table


        // Extend dataTables search
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = $('#min-date').val();
                var max = $('#max-date').val();
                var createdAt = data[6] || 0; // Our date column in the table

                //console.log(min+'--'+max);

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
            reprottable.draw();
        });

        $('#my-table_filter').hide();

        $('#btn-filter').click(function() { //button filter event click
            reprottable.ajax.reload(null, false); //just reload table
        });
        $('#btn-reset').click(function() { //button reset event click
            $('#form-filter')[0].reset();
            syncCourseState();
            reprottable.ajax.reload(null, false); //just reload table
        });

        // -------------------------------------------------------------
        // Course depends on Academic Programme.
        //
        // The Course list is fetched per programme by the shared script
        // (assets/site/main/js/custom.js -> mission/getCourseByPrgrammeold),
        // so before a programme is picked the dropdown holds nothing but
        // "Select". It therefore stays disabled until a programme is
        // chosen, and is emptied and disabled again when the programme is
        // cleared - otherwise a stale course from the previous programme
        // would still be posted with the filter.
        // -------------------------------------------------------------
        function syncCourseState() {
            var hasProgramme = $.trim($('#programmes_mission').val() || '') !== '';
            if (hasProgramme) {
                $('#courses_mission').prop('disabled', false);
                $('#course_hint').text('');
            } else {
                $('#courses_mission').prop('disabled', true).html('<option value="">Select</option>').val('');
                $('#course_hint').text('Select an Academic Programme first');
            }
        }

        $('#programmes_mission').on('change', syncCourseState);
        syncCourseState();

    });

    function openStatus(appid) {
        // AJAX request
        //var appid = $('#expe').val();
        //alert(appid);
        $.ajax({
            url: '<?php echo site_url('mission/openUniversityStatus') ?>',
            type: 'post',
            data: {
                'id': appid
            },
            //dataType:'json',
            success: function(response) {
                //alert(JSON.stringify(response));
                // Add response in Modal body
                $('.modal-body').html(response);

                // Display Modals
                $('#modalForm').modal('show');
            }

        });
    }
</script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/site/main/css/buttons.dataTables.min.css">
<script src="<?php echo base_url();?>assets/site/main/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/buttons.print.min.js"></script>

<!-- PDFMake for PDF export -->
<script src="<?php echo base_url();?>assets/site/main/js/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>assets/site/main/js/vfs_fonts.js"></script>

<!-- JSZip for Excel export -->
<script src="<?php echo base_url();?>assets/site/main/js/jszip.min.js"></script>
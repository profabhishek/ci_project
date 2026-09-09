<style type="text/css">
.tab-content {
    border: 1px solid #cecece;
    padding: 10px 20px 20px;
}

.form_head {
    float: none;
    height: 132px;
    margin: 0 auto;
    text-align: center;
}

.form_head img {
    width: 32px;
}

.form_head h3 {
    height: 33px;
    margin: 0;
    width: 100%;
}

.form_head h5 {
    margin: 0 auto;
}

.caps {
    text-transform: uppercase;
}

.prfl {
    border: 4px double #cecece;
    height: 150px;
    width: 150px;
    text-align: center;
    padding: 0;
}

.prfl img {
    height: 143px;
    margin-bottom: 8px;
    width: 139px;
}

.note {
    font-size: 10px;
    font-weight: normal;
    margin-left: 15px;
}

.note strong {
    color: red;
    font-size: 11px;
    font-weight: normal;
    margin-left: 15px;
}

.note1 {
    font-size: 14px;
    font-weight: normal;
    margin-left: 0;
}

.undertake {
    margin-right: 5px !important;
    margin-top: 6px !important;
    float: left;
}

.alert {
    margin: 12px auto 8px;
    width: 85.5%;
}

.capitalLetter:valid {
    text-transform: uppercase;
}

.capitalLetter::placeholder {
    text-transform: capitalize;
}
</style>

<section class="meacontent">
    <div class="col-xs-10 form_head">
        <img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png"
            alt="Indian Embelam">
        <h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
        <h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
    </div>
    <?php
	    	if($this->session->flashdata('message_type') == "success")
	    	{
			?>
    <div class="alert alert-success"
        role="alert">
        <button type="button"
            class="close"
            data-dismiss="alert"
            aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
    </div>
    <?php	
			}
			if($this->session->flashdata('message_type') == "error")
	    	{
			?>
    <div class="alert alert-error"
        role="alert">
        <button type="button"
            class="close"
            data-dismiss="alert"
            aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>
    </div>
    <?php	
			}
	    	
	    	?>
    <div class="container"
        style="min-height:410px;padding-top:0px;padding:0;">
        <div class="tab-content">
            <div id="step1"
                class="tab-pane fade in active">
                <?php //echo form_open('applicant/applicant_other_info?appno='.$_GET['appno']); ?>
                <form id="form-process-education-info" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                    <input type="hidden" name="appno" value="<?php echo $applicaitonStepOne[0]['application_no']?>" />
                    <div class="box-body">
                        <div class="name-sec col-xs-12 col-sm-5 col-md-12">
                            <h4>25. Educational Qualifications <span class="note1"><strong></strong>(Fill in
                                    all columns which are applicable to you)</span></h4>
                        </div>

	<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
<table class="table">
<thead>
    <th>Certificate/Degree</th>
    <th>Country</th>
    <th>Exam Board</th>
    <th>Name of Institute/School</th>
    <th>Subjects Covered</th>
    <th>Year</th>
    <th>Percentage(%)/Grade</th>
</thead>

<?php 
$programs = $this->config->item('programme');						
$program = $programs[$applicaitonStepOne[0]['programme']];
$programmeId = (int)$applicaitonStepOne[0]['programme'];

$rowsToShow = [];

if (in_array($programmeId, [12, 13])) {
    $rowsToShow = ['Secondary/High School', 'High School/College'];
}
elseif ($programmeId == 1) {
    $rowsToShow = ['Secondary/High School', 'High School/College', 'Undergraduate'];
}
elseif ($programmeId == 2) {
    $rowsToShow = ['Secondary/High School', 'High School/College', 'Undergraduate', 'Postgraduate'];
}
elseif ($programmeId == 4) {
    $rowsToShow = ['Secondary/High School', 'High School/College', 'Undergraduate', 'Postgraduate', 'PhD'];
}
elseif ($programmeId == 8) {
    $rowsToShow = ['Secondary/High School', 'High School/College', 'Undergraduate', 'Postgraduate', 'PhD'];
}

$countries = $this->common_model->getCountries();
?>

<tbody>

<?php

//print_r($applicaitonStepTwo);die; 
foreach ($rowsToShow as $course) {

    $req = '';
    $star = '';

    if($programmeId==2 && ($course=='Secondary/High School' || $course=='High School/College' || $course=='Undergraduate')){
        $req='required="true"';
        $star='<span class="text-red">*</span>';
    }
    elseif($programmeId==4 && ($course=='Secondary/High School' || $course=='High School/College' || $course=='Undergraduate' || $course=='Postgraduate')){
        $req='required="true"';
        $star='<span class="text-red">*</span>';
    }
	 elseif($programmeId==8 && ($course=='Secondary/High School' || $course=='High School/College' || $course=='Undergraduate' || $course=='Postgraduate')){
        $req='required="true"';
        $star='<span class="text-red">*</span>';
    }
    elseif($programmeId==1 && ($course=='Secondary/High School' || $course=='High School/College')){
        $req='required="true"';
        $star='<span class="text-red">*</span>';
    }

    $courseKey = strtolower(str_replace(' ','_',$course));
	//country_strtolower(str_replace(' ','_',$course)); 

    $countryField = 'country_'.$courseKey;
    $boardField = 'board_'.$courseKey;
    $instituteField = 'institute_'.$courseKey;
    $subjectsField = 'subjects_'.$courseKey;
    $yearField = 'year_'.$courseKey;
    $percentageField = 'percentage_'.$courseKey;
	
if($course=='Secondary/High School'){
	$countryFieldtb = 'school_leaving_country_x';
    $boardFieldtb = 'school_leaving_board_name_x';
    $instituteFieldtb = 'school_leaving_university_x';
    $subjectsFieldtb = 'school_leaving_subjects_x';
    $yearFieldtb = 'school_leaving_year_x';
    $percentageFieldtb = 'school_leaving_percentage_x';	
}
if($course=='High School/College'){
	$countryFieldtb = 'school_leaving_country';
    $boardFieldtb = 'school_leaving_board_name';
    $instituteFieldtb = 'school_leaving_university';
    $subjectsFieldtb = 'school_leaving_subjects';
    $yearFieldtb = 'school_leaving_year';
    $percentageFieldtb = 'school_leaving_percentage';	
}

if($course=='Undergraduate'){
	$countryFieldtb = 'ug_leaving_country';
    $boardFieldtb = 'ug_leaving_board_name';
    $instituteFieldtb = 'ug_leaving_university';
    $subjectsFieldtb = 'ug_leaving_subjects';
    $yearFieldtb = 'ug_leaving_year';
    $percentageFieldtb = 'ug_leaving_percentage';	
}

if($course=='Postgraduate'){
	$countryFieldtb = 'pg_leaving_country';
    $boardFieldtb = 'pg_leaving_board_name';
    $instituteFieldtb = 'pg_leaving_university';
    $subjectsFieldtb = 'pg_leaving_subjects';
    $yearFieldtb = 'pg_leaving_year';
    $percentageFieldtb = 'pg_leaving_percentage';	
}

if($course=='PhD'){
	$countryFieldtb = 'phd_leaving_country';
    $boardFieldtb = 'phd_leavingphd_board_name';
    $instituteFieldtb = 'phd_leaving_university';
    $subjectsFieldtb = 'phd_leaving_subjects';
    $yearFieldtb = 'phd_leaving_year';
    $percentageFieldtb = 'phd_leaving_percentage';	
}
    $countryVal = (!empty($applicaitonStepTwo) && isset($applicaitonStepTwo[0][$countryFieldtb])) ? $applicaitonStepTwo[0][$countryFieldtb] : '';
    $boardVal = (!empty($applicaitonStepTwo) && isset($applicaitonStepTwo[0][$boardFieldtb])) ? $applicaitonStepTwo[0][$boardFieldtb] : '';
    $instituteVal = (!empty($applicaitonStepTwo) && isset($applicaitonStepTwo[0][$instituteFieldtb])) ? $applicaitonStepTwo[0][$instituteFieldtb] : '';
    $subjectsVal = (!empty($applicaitonStepTwo) && isset($applicaitonStepTwo[0][$subjectsFieldtb])) ? $applicaitonStepTwo[0][$subjectsFieldtb] : '';
    $yearVal = (!empty($applicaitonStepTwo) && isset($applicaitonStepTwo[0][$yearFieldtb])) ? $applicaitonStepTwo[0][$yearFieldtb] : '';
    $percentageVal = (!empty($applicaitonStepTwo) && isset($applicaitonStepTwo[0][$percentageFieldtb])) ? $applicaitonStepTwo[0][$percentageFieldtb] : '';
?>

<tr>

<td><?php echo $course; ?> <?php echo $star;?></td>

<td>
<select name="<?php echo $countryField;?>" class="selectpicker form-control" <?php echo $req;?>>
<option value="">Country</option>

<?php
foreach ($countries as $country)
{
    $selected = ($countryVal == $country['id']) ? 'selected="selected"' : '';
    echo '<option '.$selected.' value="'.$country['id'].'">'.$country['country_name'].'</option>';
}
?>
</select>
</td>

<td>
<input type="text" <?php echo $req;?> 
name="<?php echo $boardField;?>" 
value="<?php echo $boardVal;?>" 
class="form-control">
</td>

<td>
<input type="text" <?php echo $req;?> 
name="<?php echo $instituteField;?>" 
value="<?php echo $instituteVal;?>" 
class="form-control">
</td>

<td>
<input type="text" <?php echo $req;?> 
name="<?php echo $subjectsField;?>" 
value="<?php echo $subjectsVal;?>" 
class="form-control">
</td>

<td>
<input type="text" <?php echo $req;?> 
name="<?php echo $yearField;?>" 
value="<?php echo $yearVal;?>" 
class="form-control">
</td>

<td>
<input type="text" <?php echo $req;?> 
name="<?php echo $percentageField;?>" 
value="<?php echo $percentageVal;?>" 
class="form-control">
</td>

</tr>

<?php } ?>

</tbody>
</table>
</div>
					<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                            <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <span class="note1"><strong>Note : </strong>( For admission in any UG level course 
                                      minimum 12 years of education school/college is required.<b>(Optional)</b></span>
                                </div>
                            </div>
                        </div>
					<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                            <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <span class="note1"><strong>Note : </strong>( For admission in any PG level course 
                                      minimum 15 years of education school/college is required.<b>(Optional)</b></span>
                                </div>
                            </div>
                        </div>

      					<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                            <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <span class="note1"><strong>Note : </strong>( For admission in any PhD level course 
                                      minimum 17 years of education school/college is required.<b>(Optional)</b></span>
                                </div>
                            </div>
                        </div>
      			
                        <div class="name-sec col-xs-4 col-sm-2 col-md-7 pull-right">
                            <div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
                                <button type="submit" class="form-control capitalLetter sbmt">Next &nbsp;&nbsp;<span class="glyphicon glyphicon-forward"></span></button>
                                <!-- <input type="submit" class="form-control sbmt" value="Next "/>-->
                                <!--<a href="<?php echo site_url();?>applicant/applicant_other_info?appno=<?php echo html_escape($_GET['appno']); ?>" class="form-control sbmt">Save & Continue to Page 3</a>-->
                            </div>

                            <?php  
					
					if(!empty($applicaitonStepTwo))
							{
								?>
                            <div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
                                <a href="<?php echo site_url();?>applicant/applicant_education_info_prev?appno=<?php echo $applicaitonStepTwo[0]['application_no']; ?>"
                                    target="_blank"
                                    class="form-control  sbmt"><span></span>&nbsp;&nbsp;Preview</a>
                            </div>

                            <?php
							}
							else
							{
								?>

                            <div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
                                <a href="javascript:void(0);"
                                    class="form-control sbmt"><span></span>&nbsp;&nbsp;Preview</a>
                            </div>
                            <?php
							}
					?>



                            <!----<div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
				  <a href="<?php echo site_url();?>applicant/applicant_personal_infoayush?appno=<?php echo html_escape($_GET['appno']); ?>" class="form-control sbmt"><span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;Previous</a>
				</div>--->

                        </div>
                    </div>
                    <!-- /.box-body -->


                    <?php echo form_close(); ?>
            </div>


        </div>
    </div>
</section>

<script>
    var row = $(".attr");

    function addRow() {
        row.clone(true, true).appendTo("#TextBoxContainer").find("input").val("").end();
    }

    function removeRow(button) {
        button.closest("tr.attr").remove();
    }

    $('#TextBoxContainer .attr:first-child').find('.remove').hide();

    /* Doc ready */
    $("#btnAdd").on('click', function () {
        addRow();  
        if($("#TextBoxContainer .attr").length > 1) {
            // alert('hi');
            //alert("Can't remove row.");
            $(".remove").show();
        }
    });
    $(".remove").on('click', function () {
        if($("#TextBoxContainer .attr").size() == 1) {
            //alert("Can't remove row.");
            $(".remove").hide();
        } else {
            removeRow($(this));
            
            if($("#TextBoxContainer .attr").size() == 1) {
                $(".remove").hide();
            }
            
        }
    });

</script>
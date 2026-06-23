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
                            <h4>25. Previous Educational Qualifications <span class="note1"><strong></strong>(Fill in
                                    all columns which are applicable to you)</span></h4>
                        </div>
                        <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                            <table class="table">
                                <thead>
                                    <th>Certificate/Degree</th>
                                    <th>Country</th>
                                    <th>Board&nbsp;Name</th>
                                    <th>Name&nbsp;of&nbsp;Institute/School</th>
                                    <th>Subjects&nbsp;Covered</th>
                                    <th>Year</th>
                                    <th>Percentage(%)/Grade</th>
                                </thead>
                                <tbody>
                                    <?php 
								$programs = $this->config->item('programme');
								$program = $programs[$applicaitonStepOne[0]['programme']];
								switch($program)
								{
									case "UG":
									?>

                                    <tr>
                                        <td>Grade X<br />(equivalent to Grade X in India) <span
                                                class="text-red">*</span></td>
                                        <td>
                                            <select id="school_leaving_country_x"
                                                name="school_leaving_country_x"
                                                class="selectpicker form-control capitalLetter"
                                                required="true">
                                                <option value="">Country</option>
                                                <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_board_name_x"
                                                name="school_leaving_board_name_x"
                                                class="form-control capitalLetter"
                                                placeholder="Board Name"
                                                required="true"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name_x'];?>" />
                                        </td>

                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_university_x"
                                                name="school_leaving_university_x"
                                                class="form-control capitalLetter"
                                                placeholder="Institute/School"
                                                required="true"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>" />
                                        </td>
                                        

										<td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_subjects_x"
                                                name="school_leaving_subjects_x"
                                                class="form-control capitalLetter"
                                                placeholder="Subjects"
                                                required="true"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x'];?>" />
                                        </td>
                                        <td>
                                            <input type="number"
                                                required="true"
                                                id="school_leaving_year_x"
                                                name="school_leaving_year_x"
                                                class="form-control capitalLetter"
                                                placeholder="Year"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>" />
                                        </td>
                                        <td>
                                            <input type="number" step="0.01"
                                                required="true"
                                                id="school_leaving_percentage_x"
                                                name="school_leaving_percentage_x"
                                                class="form-control capitalLetter"
                                                placeholder="Percentage"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Grade XII<br />(equivalent to Grade XII in India) <span
                                                class="text-red">*</span></td>
                                        <td>
                                            <select id="school_leaving_country"
                                                name="school_leaving_country"
                                                class="selectpicker form-control capitalLetter"
                                                required="true">
                                                <option value="">Country</option>
                                                <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_board_name"
                                                name="school_leaving_board_name"
                                                class="form-control capitalLetter"
												placeholder="Board Name"
                                                required="true"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name'];?>" />
                                        </td>

                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_university"
                                                name="school_leaving_university"
                                                class="form-control capitalLetter"
                                                placeholder="Institute/School"
                                                required="true"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>" />
                                        </td>
										
                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_subjects"
                                                name="school_leaving_subjects"
                                                class="form-control capitalLetter"
                                                placeholder="Subjects"
                                                required="true"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects'];?>" />
                                        </td>
                                        <td>
                                            <input type="number"
                                                required="true"
                                                id="school_leaving_year"
                                                name="school_leaving_year"
                                                class="form-control capitalLetter"
                                                placeholder="Year"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>" />
                                        </td>
                                        <td>
                                            <input type="number" step="0.01"
                                                required="true"
                                                id="school_leaving_percentage"
                                                name="school_leaving_percentage"
                                                class="form-control capitalLetter"
                                                placeholder="Percentage"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>" />
                                        </td>
                                    </tr>
                                    <?php
								break;
								case "Dance":
								case "Music":
								case "Yoga":
								case "CetificateCourse":
								?>

                                    <tr>
                                        <td>Grade X<br />(equivalent to Grade X in India) <span
                                                class="text-red">*</span></td>
                                        <td>
                                            <select id="school_leaving_country_x"
                                                name="school_leaving_country_x"
                                                class="selectpicker form-control capitalLetter"
                                                required="true">
                                                <option value="">Country</option>
                                                <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_university_x"
                                                name="school_leaving_university_x"
                                                class="form-control capitalLetter"
                                                placeholder="University/Institute"
                                                required="true"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>" />
                                        </td>
                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_subjects_x"
                                                name="school_leaving_subjects_x"
                                                class="form-control capitalLetter"
                                                placeholder="Subjects"
                                                required="true"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x'];?>" />
                                        </td>
                                        <td>
                                            <input type="number"
                                                required="true"
                                                id="school_leaving_year_x"
                                                name="school_leaving_year_x"
                                                class="form-control capitalLetter"
                                                placeholder="Year"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>" />
                                        </td>
                                        <td>
                                            <input type="number" step="0.01"
                                                required="true"
                                                id="school_leaving_percentage_x"
                                                name="school_leaving_percentage_x"
                                                class="form-control capitalLetter"
                                                placeholder="Percentage"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Grade XII<br />(equivalent to Grade XII in India)<span
                                                class="text-red">*</span></td>
                                        <td>
                                            <select id="school_leaving_country"
                                                name="school_leaving_country"
                                                class="selectpicker form-control capitalLetter"
                                                required="true">
                                                <option value="">Country</option>
                                                <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_university"
                                                name="school_leaving_university"
                                                class="form-control capitalLetter"
                                                placeholder="University/Institute"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>" />
                                        </td>
                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="school_leaving_subjects"
                                                name="school_leaving_subjects"
                                                class="form-control capitalLetter"
                                                placeholder="Subjects"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects'];?>" />
                                        </td>
                                        <td>
                                            <input type="number"
                                                required="true"
                                                id="school_leaving_year"
                                                name="school_leaving_year"
                                                class="form-control capitalLetter"
                                                placeholder="Year"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>" />
                                        </td>
                                        <td>
                                            <input type="number" step="0.01"
                                                required="true"
                                                id="school_leaving_percentage"
                                                name="school_leaving_percentage"
                                                class="form-control capitalLetter"
                                                placeholder="Percentage"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Undergraduate<br />(equivalent to three years course after grade XII in
                                            India)<span class="text-red">*</span></td>
                                        <td>
                                            <select id="ug_leaving_country"
                                                name="ug_leaving_country"
                                                class="selectpicker form-control capitalLetter">
                                                <option value="">Country</option>
                                                <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text"
                                                id="ug_leaving_university"
                                                name="ug_leaving_university"
                                                class="form-control capitalLetter"
                                                placeholder="University/Board"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>" />
                                        </td>
                                        <td>
                                            <input type="text"
                                                id="ug_leaving_subjects"
                                                name="ug_leaving_subjects"
                                                class="form-control capitalLetter"
                                                placeholder="Subjects"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_subjects'];?>" />
                                        </td>
                                        <td>
                                            <input type="number"
                                                id="ug_leaving_year"
                                                name="ug_leaving_year"
                                                class="form-control capitalLetter"
                                                placeholder="Year"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>" />
                                        </td>
                                        <td>
                                            <input type="number" step="0.01"
                                                id="ug_leaving_percentage"
                                                name="ug_leaving_percentage"
                                                class="form-control capitalLetter"
                                                placeholder="Percentage"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>" />
                                        </td>
                                    </tr>
                            </table>


                            <table class="table">
                                <?php
								break;
								case "PG":
								?>
                                <tr>
                                    <td>Grade X<br />(equivalent to Grade X in India) <span class="text-red">*</span>
                                    </td>
                                    <td>
                                        <select id="school_leaving_country_x"
                                            name="school_leaving_country_x"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_board_name_x"
                                            name="school_leaving_board_name_x"
                                            class="form-control capitalLetter"
                                            placeholder="Board Name"
                                            required="true"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name_x'];?>" />
                                    </td>

                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_university_x"
                                            name="school_leaving_university_x"
                                            class="form-control capitalLetter"
                                            placeholder="Name of Institute"
                                            required="true"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>" />
                                    </td>
                                   

									<td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_subjects_x"
                                            name="school_leaving_subjects_x"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            required="true"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x'];?>" />
                                    </td>

                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="school_leaving_year_x"
                                            name="school_leaving_year_x"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="school_leaving_percentage_x"
                                            name="school_leaving_percentage_x"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Grade XII<br />(equivalent to Grade XII in India)<span class="text-red">*</span>
                                    </td>
                                    <td>
                                        <select id="school_leaving_country"
                                            name="school_leaving_country"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_board_name"
                                            name="school_leaving_board_name"
                                            class="form-control capitalLetter"
                                            placeholder="Board Name"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_university"
                                            name="school_leaving_university"
                                            class="form-control capitalLetter"
                                            placeholder="Name of Institute"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>" />
                                    </td>
                                    
									<td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_subjects"
                                            name="school_leaving_subjects"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="school_leaving_year"
                                            name="school_leaving_year"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="school_leaving_percentage"
                                            name="school_leaving_percentage"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    </tbody>
                                    <thead>
                                        <th>Certificate/Degree</th>
                                        <th>Country</th>
                                        <th>Name&nbsp;of&nbsp;University</th>
										<th>College/Department</th>
                                        <th>Subjects&nbsp;Covered</th>
                                        <th>Year</th>
                                        <th>Percentage(%)/Grade</th>
                                    </thead>
                                    <tbody>

                                        <td>Undergraduate<br />(equivalent to three years course after grade XII in
                                            India)<span class="text-red">*</span></td>
                                        <td>
                                            <select id="ug_leaving_country"
                                                name="ug_leaving_country"
                                                class="selectpicker form-control capitalLetter"
                                                required="true">
                                                <option value="">Country</option>
                                                <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="ug_leaving_university"
                                                name="ug_leaving_university"
                                                class="form-control capitalLetter"
                                                placeholder="Name of University"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>" />
                                        </td>
                                        <td>
                                            <input type="text"
                                                required="true"
                                                id="ug_leaving_department_name"
                                                name="ug_leaving_department_name"
                                                class="form-control capitalLetter"
                                                placeholder="College/Department"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_department_name'];?>" />
                                        </td>
										<td>
                                            <input type="text"
                                                required="true"
                                                id="ug_leaving_subjects"
                                                name="ug_leaving_subjects"
                                                class="form-control capitalLetter"
                                                placeholder="Subjects"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_subjects'];?>" />
                                        </td>
                                        <td>
                                            <input type="number"
                                                required="true"
                                                id="ug_leaving_year"
                                                name="ug_leaving_year"
                                                class="form-control capitalLetter"
                                                placeholder="Year"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>" />
                                        </td>
                                        <td>
                                            <input type="number" step="0.01"
                                                required="true"
                                                id="ug_leaving_percentage"
                                                name="ug_leaving_percentage"
                                                class="form-control capitalLetter"
                                                placeholder="Percentage"
                                                value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>" />
                                        </td>
                                </tr>
                                </tbody>
                                <?php
								break;
								case "M.Phil":
								?>
                                <tr>
                                    <td>Grade X<br />(equivalent to Grade X in India) <span class="text-red">*</span>
                                    </td>
                                    <td>
                                        <select id="school_leaving_country_x"
                                            name="school_leaving_country_x"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_university_x"
                                            name="school_leaving_university_x"
                                            class="form-control capitalLetter"
                                            placeholder="University/Institute"
                                            required="true"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_subjects_x"
                                            name="school_leaving_subjects_x"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            required="true"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="school_leaving_year_x"
                                            name="school_leaving_year_x"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="school_leaving_percentage_x"
                                            name="school_leaving_percentage_x"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Grade XII<br />(equivalent to Grade XII in India)<span class="text-red">*</span>
                                    </td>
                                    <td>
                                        <select id="school_leaving_country"
                                            name="school_leaving_country"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_university"
                                            name="school_leaving_university"
                                            class="form-control capitalLetter"
                                            placeholder="University/Institute"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_subjects"
                                            name="school_leaving_subjects"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="school_leaving_year"
                                            name="school_leaving_year"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="school_leaving_percentage"
                                            name="school_leaving_percentage"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Undergraduate<br />(equivalent to three years course after grade XII in
                                        India)<span class="text-red">*</span></td>
                                    <td>
                                        <select id="ug_leaving_country"
                                            name="ug_leaving_country"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="ug_leaving_university"
                                            name="ug_leaving_university"
                                            class="form-control capitalLetter"
                                            placeholder="University/Board"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="ug_leaving_subjects"
                                            name="ug_leaving_subjects"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_subjects'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="ug_leaving_year"
                                            name="ug_leaving_year"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="ug_leaving_percentage"
                                            name="ug_leaving_percentage"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Post graduate<br />(Two years University education after graduation or five
                                        years after class XII.)<span class="text-red">*</span></td>
                                    <td>
                                        <select id="pg_leaving_country"
                                            name="pg_leaving_country"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['pg_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="pg_leaving_university"
                                            name="pg_leaving_university"
                                            class="form-control capitalLetter"
                                            placeholder="University/Institute"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_university'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="pg_leaving_subjects"
                                            name="pg_leaving_subjects"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_subjects'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="pg_leaving_year"
                                            name="pg_leaving_year"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_year'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="pg_leaving_percentage"
                                            name="pg_leaving_percentage"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_percentage'];?>" />
                                    </td>
                                </tr>
                                <?php
								break;
								case "Ph.D":
								case "Ph.D Ayurveda":
								?>
                                <tr>
                                    <td>Grade X<br />(equivalent to Grade X in India) <span class="text-red">*</span>
                                    </td>
                                    <td>
                                        <select id="school_leaving_country_x"
                                            name="school_leaving_country_x"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country_x'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_university_x"
                                            name="school_leaving_university_x"
                                            class="form-control capitalLetter"
                                            placeholder="Name of Institute"
                                            required="true"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university_x'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_board_name_x"
                                            name="school_leaving_board_name_x"
                                            class="form-control capitalLetter"
                                            placeholder="Board Name"
                                            required="true"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name_x'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_subjects_x"
                                            name="school_leaving_subjects_x"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            required="true"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects_x'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="school_leaving_year_x"
                                            name="school_leaving_year_x"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year_x'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="school_leaving_percentage_x"
                                            name="school_leaving_percentage_x"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage_x'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Grade XII<br />(equivalent to Grade XII in India)<span class="text-red">*</span>
                                    </td>
                                    <td>
                                        <select id="school_leaving_country"
                                            name="school_leaving_country"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['school_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_university"
                                            name="school_leaving_university"
                                            class="form-control capitalLetter"
                                            placeholder="Name of Institute"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_university'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_board_name"
                                            name="school_leaving_board_name"
                                            class="form-control capitalLetter"
                                            placeholder="Board Name"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_board_name'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="school_leaving_subjects"
                                            name="school_leaving_subjects"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_subjects'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="school_leaving_year"
                                            name="school_leaving_year"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_year'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="school_leaving_percentage"
                                            name="school_leaving_percentage"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['school_leaving_percentage'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Undergraduate<br />(equivalent to three years course after grade XII in
                                        India)<span class="text-red">*</span></td>
                                    <td>
                                        <select id="ug_leaving_country"
                                            name="ug_leaving_country"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['ug_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="ug_leaving_university"
                                            name="ug_leaving_university"
                                            class="form-control capitalLetter"
                                            placeholder="Name of Institute"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_university'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="ug_leaving_board_name"
                                            name="ug_leaving_board_name"
                                            class="form-control capitalLetter"
                                            placeholder="Board Name"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_board_name'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="ug_leaving_subjects"
                                            name="ug_leaving_subjects"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_subjects'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="ug_leaving_year"
                                            name="ug_leaving_year"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_year'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="ug_leaving_percentage"
                                            name="ug_leaving_percentage"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['ug_leaving_percentage'];?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Post graduate<br />(Two years University education after graduation or five
                                        years after class XII.)<span class="text-red">*</span></td>
                                    <td>
                                        <select id="pg_leaving_country"
                                            name="pg_leaving_country"
                                            class="selectpicker form-control capitalLetter"
                                            required="true">
                                            <option value="">Country</option>
                                            <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonStepTwo))
										  	{
												if($applicaitonStepTwo[0]['pg_leaving_country'] == $country['id'])
												{
													echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
												else
												{
													echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
												}
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
											}
										  	
										  }
									  ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="pg_leaving_university"
                                            name="pg_leaving_university"
                                            class="form-control capitalLetter"
                                            placeholder="Name of Institute"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_university'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="pg_leaving_board_name"
                                            name="pg_leaving_board_name"
                                            class="form-control capitalLetter"
                                            placeholder="Board Name"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_board_name'];?>" />
                                    </td>
                                    <td>
                                        <input type="text"
                                            required="true"
                                            id="pg_leaving_subjects"
                                            name="pg_leaving_subjects"
                                            class="form-control capitalLetter"
                                            placeholder="Subjects"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_subjects'];?>" />
                                    </td>
                                    <td>
                                        <input type="number"
                                            required="true"
                                            id="pg_leaving_year"
                                            name="pg_leaving_year"
                                            class="form-control capitalLetter"
                                            placeholder="Year"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_year'];?>" />
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            required="true"
                                            id="pg_leaving_percentage"
                                            name="pg_leaving_percentage"
                                            class="form-control capitalLetter"
                                            placeholder="Percentage"
                                            value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['pg_leaving_percentage'];?>" />
                                    </td>
                                </tr>
                                <?php
								break;								
							}
							?>
                                </tbody>
                            </table>
                        </div>
                        <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                            <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <span class="note1"><strong>Note : </strong>(Details of any course in Indian
                                        Universities/Institutes which the scholar is currently attending or has attended
                                        in past.<b>(Optional)</b></span>
                                </div>
                            </div>
                        </div>
                        <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                            <table class="table">
                                <thead>
                                    <th>Country</th>
                                    <th>Name of School/University/Board</th>
                                    <th>Course</th>
                                    <th>Year</th>
                                    <th>Percentage(%)/Grade</th>
                                    <th>
                                        <?php if(count($this->common_model->getOtherEducationDetail($applicaitonStepTwo[0]['id'])) == 0) { ?>
                                            <a href="javascript:;" class="btn btn-primary btnAdd" id="btnAdd"><i class="fa fa-plus"></i></a>
                                        <?php } ?>
                                    </th>
                                </thead>
                                <tbody id="TextBoxContainer">
                                    <?php
										//echo '<pre>'; print_r($this->common_model->getOtherEducationDetail($applicaitonStepTwo[0]['id']));die;
                                        if(count($this->common_model->getOtherEducationDetail($applicaitonStepTwo[0]['id'])) > 0){

                                            foreach($this->common_model->getOtherEducationDetail($applicaitonStepTwo[0]['id']) as $value){
                                    ?>
                                        <tr>
                                            <td>
                                                <select id="other_course_country" name="other_course_country[]" class="selectpicker form-control capitalLetter">
                                                    <option value="">Country</option>
                                                    <?php
                                                        $countries = $this->common_model->getCountries();
                                                        foreach($countries as $country)
                                                        {
                                                            if($value['other_course_country'] == $country['id'])
                                                            {
                                                                echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                                echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
                                                            }
                                                        
                                                        }
                                                    ?>
                                                </select>
                                            </td>

                                            <td>
                                                <input class="form-control capitalLetter" id="other_course_university" name="other_course_university[]" placeholder="University/Institute" type="text" value="<?php echo $value['other_course_university'];?>" />
                                            </td>

                                            <td>
                                                <input class="form-control capitalLetter" id="other_course" name="other_course[]" placeholder="Course" type="text" value="<?php echo $value['other_course'];?>" />
                                            </td>

                                            <td>
                                                <input class="form-control capitalLetter" id="other_course_year" name="other_course_year[]" max="4" placeholder="Year" type="number" value="<?php echo $value['other_course_year'];?>" />
                                            </td>

                                            <td>
                                                <input class="form-control capitalLetter" id="other_course_percentage" name="other_course_percentage[]" placeholder="Percentage(%)" type="number" step="0.01" value="<?php echo $value['other_course_percentage'];?>" />
                                            </td>
                                            <td>
                                                <!-- <a href="javascript:;" class="btn btn-danger remove"><i class="fa fa-trash"></i></a> -->
                                            </td>
                                        </tr>
                                    <?php } } else { ?>
                                    
                                    <tr class="attr">
                                        <td>
                                            <select id="other_course_country" name="other_course_country[]" class="selectpicker form-control capitalLetter">
                                                <option value="">Country</option>
                                                <?php
                                                    $countries = $this->common_model->getCountries();
                                                    foreach($countries as $country)
                                                    {
                                                    if(!empty($applicaitonStepTwo))
                                                    {
                                                        if($applicaitonStepTwo[0]['other_course_country'] == $country['id'])
                                                        {
                                                            echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';
                                                    }
                                                    
                                                    }
                                                ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input class="form-control capitalLetter" id="other_course_university" name="other_course_university[]" placeholder="University/Institute" type="text" value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course_university'];?>" />
                                        </td>

                                        <td>
                                            <input class="form-control capitalLetter" id="other_course" name="other_course[]" placeholder="Course" type="text" value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course'];?>" />
                                        </td>

                                        <td>
                                            <input class="form-control capitalLetter" id="other_course_year" name="other_course_year[]" placeholder="Year" type="number" value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course_year'];?>" />
                                        </td>

                                        <td>
                                            <input class="form-control capitalLetter" id="other_course_percentage" name="other_course_percentage[]" placeholder="Percentage(%)" type="number" step="0.01" value="<?php if(!empty($applicaitonStepTwo)) echo $applicaitonStepTwo[0]['other_course_percentage'];?>" />
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-danger remove"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="name-sec col-xs-4 col-sm-2 col-md-7 pull-right">
                            <div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
                                <button type="submit" class="form-control capitalLetter sbmt">Next &nbsp;&nbsp;<span class="glyphicon glyphicon-forward"></span></button>
                                <!-- <input type="submit" class="form-control sbmt" value="Next "/>-->
                                <!--<a href="<?php echo site_url();?>applicant/applicant_other_info?appno=<?php echo $_GET['appno']; ?>" class="form-control sbmt">Save & Continue to Page 3</a>-->
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
				  <a href="<?php echo site_url();?>applicant/applicant_personal_infoayush?appno=<?php echo $_GET['appno']; ?>" class="form-control sbmt"><span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;Previous</a>
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
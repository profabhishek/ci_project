<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:150px;width:150px;text-align: center;padding:0;}
.prfl img{height:143px;margin-bottom:8px;width:139px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 14px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
.alert
{	
	margin: 12px auto 8px;    
    width: 85.5%;
}
</style>

<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Form For Scholarship through ICCR SFS</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
	</div>	
	<?php
	    	if($this->session->flashdata('message_type') == "success")
	    	{
			?>
			<div class="alert alert-success" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
			</div>
			<?php	
			}
			if($this->session->flashdata('message_type') == "error")
	    	{
			?>
			<div class="alert alert-error" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> <?php echo $this->session->flashdata('error');?>
			</div>
			<?php	
			}
	    	
	    	?>
	<div  class="container" style="min-height:410px;padding-top:0px;padding:0;">	
	<div class="tab-content">	
	  <div id="step1" class="tab-pane fade in active ">
	  <?php echo form_open('Sfs/applicant_sfs_other_info?appno='.html_escape($_GET['appno'])); ?>	   
	  
              <div class="box-body panel panel-blue margin-bottom-40">  
				 <div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>16. Previous Educational Qualifications   <span class="note1"><strong></strong>(Fill in all columns which are applicable to you)</span></h4>
				</div> 
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table class="table">
						<thead>
							<th>Certificate/Degree</th>
							<th colspan="1">Country</th>
							<th colspan="3">Name of School/University/Board</th>
							<th colspan="1">Admission Year</th>
							<th colspan="1">Passing Year</th>
							<th colspan="1">Percentage(%)/Grade</th>
						</thead>
						<tbody>
							<?php 
							$programs = $this->config->item('programme');
							$program = $programs[$applicaitonSfsStepOne[0]['programme']];
							switch($program)
							{
								case "UG":
								?>
								
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India) <span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="school_leaving_country" name="school_leaving_country" class="selectpicker form-control" required="true">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['school_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_university" name="school_leaving_university" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_admission_year" name="school_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_admission_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_year" name="school_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_percentage" name="school_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_percentage'];?>"/>
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
								<td>School Leaving<br/>(equivalent to Grade XII in India)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="school_leaving_country" name="school_leaving_country" class="selectpicker form-control" required="true">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['school_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_university" name="school_leaving_university" class="form-control" placeholder="University/Institute" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_admission_year" name="school_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_admission_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_year" name="school_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_percentage" name="school_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_percentage'];?>"/>
								</td>
							</tr>
							<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="ug_leaving_country" name="ug_leaving_country" class="selectpicker form-control">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['ug_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text"  id="ug_leaving_university" name="ug_leaving_university" class="form-control" placeholder="University/Board" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="ug_leaving_admission_year" name="ug_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_admission_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" id="ug_leaving_year" name="ug_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text"  id="ug_leaving_percentage" name="ug_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_percentage'];?>"/>
								</td>
							</tr>
								<?php
								break;
								case "PG":
								
								?>
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="school_leaving_country" name="school_leaving_country" class="selectpicker form-control" required="true">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['school_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_university" name="school_leaving_university" class="form-control" placeholder="University/Institute" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_admission_year" name="school_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_admission_year'];?>"/>
								</td>
								
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_year" name="school_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_percentage" name="school_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_percentage'];?>"/>
								</td>
							</tr>
							<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="ug_leaving_country" name="ug_leaving_country" class="selectpicker form-control" required="true">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['ug_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text" required="true"  id="ug_leaving_university" name="ug_leaving_university" class="form-control" placeholder="University/Board" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="ug_leaving_admission_year" name="ug_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_admission_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="ug_leaving_year" name="ug_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="ug_leaving_percentage" name="ug_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_percentage'];?>"/>
								</td>
							</tr>
								<?php
								break;
								case "M.Phil":
								?>
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="school_leaving_country" name="school_leaving_country" class="selectpicker form-control" required="true">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['school_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_university" name="school_leaving_university" class="form-control" placeholder="University/Institute" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_admission_year" name="school_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_admission_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_year" name="school_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_percentage" name="school_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_percentage'];?>"/>
								</td>
							</tr>
								<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="ug_leaving_country" name="ug_leaving_country" class="selectpicker form-control" required="true">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['ug_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text" required="true"  id="ug_leaving_university" name="ug_leaving_university" class="form-control" placeholder="University/Board" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="ug_leaving_admission_year" name="ug_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_admission_year'];?>"/>
								</td
								<td colspan="1">
									<input type="text" required="true"  id="ug_leaving_year" name="ug_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="ug_leaving_percentage" name="ug_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_percentage'];?>"/>
								</td>
							</tr>
								<tr>
							<td>Post graduate<br/>(Two years University education after graduation or five years after class XII.)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="pg_leaving_country" name="pg_leaving_country" class="selectpicker form-control" required="true">
			                        <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['pg_leaving_country'] == $country['id'])
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
								<td colspan="2">
								 <input type="text" required="true"  id="pg_leaving_university" name="pg_leaving_university" class="form-control" placeholder="University/Institute"  value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['pg_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="pg_leaving_admission_year" name="pg_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['pg_leaving_admission_year'];?>"/>
								</td>
								
								
								
								<td colspan="1">
									<input type="text" required="true"  id="pg_leaving_year" name="pg_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['pg_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="pg_leaving_percentage" name="pg_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['pg_leaving_percentage'];?>"/>
								</td>
							</tr>
								<?php
								break;
								case "Ph.D":
								case "Ph.D Ayurveda":
								?>
								<tr>
								<td>School Leaving<br/>(equivalent to Grade XII in India)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="school_leaving_country" name="school_leaving_country" class="selectpicker form-control" required="true">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['school_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_university" name="school_leaving_university" class="form-control" placeholder="University/Institute" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="school_leaving_admission_year" name="school_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_admission_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_year" name="school_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="school_leaving_percentage" name="school_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['school_leaving_percentage'];?>"/>
								</td>
							</tr>
								<tr>
								<td>Undergraduate<br/>(equivalent to three years course after grade XII in India)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="ug_leaving_country" name="ug_leaving_country" class="selectpicker form-control" required="true">
			                         <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['ug_leaving_country'] == $country['id'])
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
								<td colspan="2">
								  <input type="text" required="true"  id="ug_leaving_university" name="ug_leaving_university" class="form-control" placeholder="University/Board" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="ug_leaving_admission_year" name="ug_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_admission_year'];?>"/>
								</td>
								
								<td colspan="1">
									<input type="text" required="true"  id="ug_leaving_year" name="ug_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="ug_leaving_percentage" name="ug_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['ug_leaving_percentage'];?>"/>
								</td>
							</tr>
								<tr>
							<td>Post graduate<br/>(Two years University education after graduation or five years after class XII.)<span class="text-red">*</span></td>
								<td colspan="1">
								   <select id="pg_leaving_country" name="pg_leaving_country" class="selectpicker form-control" required="true">
			                        <option value="">Country</option>
			                         <?php
										  $countries = $this->common_model->getCountries();
										  foreach($countries as $country)
										  {
										  	if(!empty($applicaitonSfsStepTwo))
										  	{
												if($applicaitonSfsStepTwo[0]['pg_leaving_country'] == $country['id'])
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
								<td colspan="2">
								 <input type="text" required="true"  id="pg_leaving_university" name="pg_leaving_university" class="form-control" placeholder="University/Institute"  value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['pg_leaving_university'];?>"/>
								</td>
								<td colspan="2">
								  <input type="text" required="true"  id="pg_leaving_admission_year" name="pg_leaving_admission_year" class="form-control" placeholder="University/Institute" required="true" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['pg_leaving_admission_year'];?>"/>
								</td>
								
								
								
								<td colspan="1">
									<input type="text" required="true"  id="pg_leaving_year" name="pg_leaving_year" class="form-control" placeholder="Year" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['pg_leaving_year'];?>"/>
								</td>
								<td colspan="1">
									<input type="text" required="true"  id="pg_leaving_percentage" name="pg_leaving_percentage" class="form-control" placeholder="Percentage" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['pg_leaving_percentage'];?>"/>
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
							<span class="note1"><strong>Note: </strong>(Details of any course in Indian Universities/Institutes which the scholar is currently attending or has attended in past may be given below <b>(Optional)</b>.)</span>
						</div>											
				 	</div>
				 </div>  	
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					<table class="table">
						<thead>
							<th>Year</th>							
							<th>Name of School/University/Board</th>
							<th>Course</th>
						</thead>
						<tbody>
							<tr>
								<td><input class="form-control" id="other_course_year" name="other_course_year" placeholder="Year" type="text"   value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['other_course_year'];?>"/></td>
								<td><input class="form-control" id="other_course_university" name="other_course_university" placeholder="University/Institute" type="text"   value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['other_course_university'];?>"/></td>
								<td><input class="form-control" id="other_course_university_admission_year" name="other_course_university_admission_year" placeholder="University/Institute" type="text"   value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['other_course_university_admission_year'];?>"/></td>
								<td><input class="form-control" id="other_course" name="other_course" placeholder="Course" type="text" value="<?php if(!empty($applicaitonSfsStepTwo)) echo $applicaitonSfsStepTwo[0]['other_course'];?>"/></td>							
							</tr>							
						</tbody>
					</table>
				</div>	
				<div class="name-sec col-xs-4 col-sm-2 col-md-7 pull-right">				  	
					<div class="name-sec col-xs-4 col-sm-2 col-md-3 pull-right">
					<button type="submit" class="form-control btn btn-info">Next &nbsp;&nbsp;<span class="glyphicon glyphicon-forward"></span></button>
	                </div>
                <div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
				  <a href="<?php echo site_url();?>Sfs/applicant_sfs_personal_info?appno=<?php echo html_escape($_GET['appno']); ?>" class="form-control btn btn-info"><span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;Previous</a>
				  </div>
				
              	</div>
              </div>
              <!-- /.box-body -->

             
            <?php echo form_close(); ?>
	  </div>
	  	
	   
	</div>
	</div>
</section>
	
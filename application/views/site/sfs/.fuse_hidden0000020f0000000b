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
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
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
		<span style="color:red;font-weight: bold;box-shadow:4px 1px 13px yellow inset;">Note: (Signature should be less than equal to 1 MB and in JPG/JPEG/PNG format) </span>
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
	<div  class="container" style="min-height:410px;padding:0px;">
	<div class="tab-content">	
	  <div id="step2" class="tab-pane fade in active">
	   <?php echo form_open('Sfs/applicant_sfs_documents?appno='.$_GET['appno'],array('enctype' => 'multipart/form-data','onsubmit'=>'return validateFieldsOtherInfo()')); ?>	  
              <div class="box-body">
              	 <div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>17. Give below the names of two persons who have agreed to testify from their personal knowledge to your character (they must not be related to you and should have direct knowledge of your academic pursuits).</h4>
				</div> 
				<div class="passport-sec col-xs-12 col-sm-12 col-md-6 pdleft pdright" style="background: rgb(244, 244, 244) none repeat scroll 0% 0%; border: 1px solid rgb(206, 206, 206); margin-right: 0px;padding-top: 20px;">
				<div class="name-sec col-xs-12 col-sm-3 col-md-6">
				<label for="comment"><u>Reference 1 </u></label>
				</div>
					<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Name <span class="text-red">*</span></label>
                   <div class="form-group date">
                      <input type="text"  class="form-control"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Name" id="enq_ref_one_name" name="enq_ref_one_name" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_one_name'];?>" required="true"/>
                   </div>
                </div> 
                 <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Occupation<span class="text-red">*</span></label>
                   <div class="form-group">
                      <input type="text" class="form-control"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Occupation" id="enq_ref_one_designation" name="enq_ref_one_designation" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_one_designation'];?>" required="true"/>
                   </div>
                </div>        	
               </div> 
               <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
               	<div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Email<span class="text-red">*</span></label>
                   <div class="form-group">
                      <input type="email" class="form-control" placeholder="Email" id="enq_ref_one_email" name="enq_ref_one_email" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_one_email'];?>" required="true"/> 
                   </div>
                </div>              
                <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Telephone <span class="text-red">*</span></label>
                   <div class="form-group">
                      <input type="text" pattern="^[0-9]+$" title="0-9" maxlength="15" class="form-control" placeholder="Telephone" id="enq_ref_one_phone" name="enq_ref_one_phone"  value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_one_phone'];?>" required="true"/>
                   </div>
                </div> 
               </div>
               <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
               	<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment"> Postal Address <span class="text-red">*</span></label>	
							<div class="form-group col-md-12 pdleft">							
						  <textarea class="form-control" rows="3" id="enq_ref_one_address" name="enq_ref_one_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_one_address'];?></textarea>
					</div>
					
										
				 </div>
				</div>				
               </div>
               
				
				</div> 
				<div class="passport-sec col-xs-12 col-sm-12 col-md-6 pdleft pdright" style="background: rgb(244, 244, 244) none repeat scroll 0% 0%; border: 1px solid rgb(206, 206, 206); margin-right: 0px;padding-top: 20px;">
				<div class="name-sec col-xs-12 col-sm-3 col-md-6">
				<label for="comment"><u>Reference 2</u></label>
				</div>
					<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-6 col-md-6">
                   <label for="comment">Name <span class="text-red">*</span></label>
                   <div class="form-group date">
                      <input type="text" class="form-control" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Name" id="enq_ref_two_name" name="enq_ref_two_name"  value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_two_name'];?>" required="true"/>
                   </div>
                </div>
                	 <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Occupation <span class="text-red">*</span></label>
                   <div class="form-group">
                      <input type="text" class="form-control" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Occupation" id="enq_ref_two_designation" name="enq_ref_two_designation" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_two_designation'];?>" required="true"/>
                   </div>
                </div> 
                <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Email <span class="text-red">*</span></label>
                   <div class="form-group">
                      <input type="email" class="form-control" placeholder="Email" id="enq_ref_two_email" name="enq_ref_two_email" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_two_email'];?>" required="true"/>
                   </div>
                </div> 
                <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                   <label for="comment">Telephone <span class="text-red">*</span></label>
                   <div class="form-group">
                      <input type="text" pattern="^[0-9]+$" title="0-9" maxlength="15" class="form-control" placeholder="Telephone" id="enq_ref_two_phone" name="enq_ref_two_phone" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_two_phone'];?>" required="true"/>
                   </div>
                </div> 
                <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
               	<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">	
					<div class="name-sec col-xs-12 col-sm-6 col-md-12">
						<label for="comment"> Postal Address <span class="text-red">*</span></label>	
							<div class="form-group col-md-12 pdleft">							
						  <textarea class="form-control" rows="3" id="enq_ref_two_address" name="enq_ref_two_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['enq_ref_two_address'];?></textarea>
					</div>				
				 </div>
				</div>
               </div>        	
               </div> 
				</div> 
				
 				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>18. Details of close relative(s) or friends, if any, in India.</h4>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Name </label>
                   <div class="form-group date">
                      <input type="text" class="form-control" placeholder="Name" id="relative_ref_name" name="relative_ref_name" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['relative_ref_name'];?>"/>
                   </div>
                </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Relationship</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Relationship" id="relative_ref_relation" name="relative_ref_relation" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['relative_ref_relation'];?>"/>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Occupation</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Designation" id="relative_ref_designation" name="relative_ref_designation"  value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['relative_ref_designation'];?>"/>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Postal Address</label>
                   <div class="form-group date">
                      <textarea class="form-control" placeholder="Address" id="relative_ref_address" name="relative_ref_address"><?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['relative_ref_address'];?></textarea>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Tel No.</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Tel No." id="relative_ref_contact" name="relative_ref_contact" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['relative_ref_contact'];?>"/>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                   <label for="comment">Email</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Email" id="relative_ref_email" name="relative_ref_email"  value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['relative_ref_email'];?>"/>
                   </div>
                </div>               	
               </div> 
				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">19. Have you travelled or lived in India in the past?</label>
						<div class="form-group">
						<?php
						//echo '<pre>';
						//print_r($applicaitonSfsStepThree);
						if(!empty($applicaitonSfsStepThree) && $applicaitonSfsStepThree[0]['is_travel_or_live_in_india_before'] > 0)
						{
							if($applicaitonSfsStepThree[0]['is_travel_or_live_in_india_before'] == 1){
								?>
						  <input value="1" checked="true" type="radio" id="is_travel_or_live_in_india_before" name="is_travel_or_live_in_india_before"> Yes
						  <input value="2" type="radio" id="is_travel_or_live_in_india_before" name="is_travel_or_live_in_india_before"> No
						<?php
							}
							elseif($applicaitonSfsStepThree[0]['is_travel_or_live_in_india_before'] == 2){
								?>
						  <input value="1"  type="radio" id="is_travel_or_live_in_india_before" name="is_travel_or_live_in_india_before"> Yes
						  <input value="2" checked="true" type="radio" id="is_travel_or_live_in_india_before" name="is_travel_or_live_in_india_before"> No
						<?php
							}
						}
						else
						{
						?>
						  <input value="1" type="radio" id="is_travel_or_live_in_india_before" name="is_travel_or_live_in_india_before"> Yes
						  <input value="2" type="radio" id="is_travel_or_live_in_india_before" name="is_travel_or_live_in_india_before"> No
						<?php  	
						}
						?>
						  
						</div>
				 </div>
				
								
				</div>
				<?php
				if(!empty($applicaitonSfsStepThree) && $applicaitonSfsStepThree[0]['is_iccr_scholarship_avail_before'] > 0)
						{
							if($applicaitonSfsStepThree[0]['is_iccr_scholarship_avail_before'] == 1){
							?>
							<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright iccr_scholar">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-2">
					 <label for="comment">Year of Scholarship</label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Year" id="iccr_scholar_year" name="iccr_scholar_year" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['iccr_scholar_year'];?>"/>
						</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">Name of Course</label>
						<div class="form-group">
						<?php
						if(!empty($applicaitonSfsStepThree))
						{
							if($applicaitonSfsStepThree[0]['iccr_scholar_course'] == 1){
								?>
						  <input type="radio" checked="true" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
						  <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
						  <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> Ph.D.
						  <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
						<?php
							}
							elseif($applicaitonSfsStepThree[0]['iccr_scholar_course'] == 2){
								?>
						   <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
						  <input type="radio" checked="true" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
						  <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> Ph.D.
						  <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
						<?php
							}
							elseif($applicaitonSfsStepThree[0]['iccr_scholar_course'] == 3){
								?>
						   <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
						  <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
						  <input checked="true" type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> Ph.D.
						  <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
						<?php
							}
							elseif($applicaitonSfsStepThree[0]['iccr_scholar_course'] == 4){
								?>
						   <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
						  <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
						  <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> Ph.D.
						  <input type="radio" checked="true" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
						<?php
							}
						}
						else
						{
						?>
						 <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
						  <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
						  <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> Ph.D.
						  <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
						<?php  	
						}
						?>
						  
						</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-3">
					 <label for="comment">Name of Institue/University</label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Institute/Uni." id="iccr_scholar_institute" name="iccr_scholar_institute" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['iccr_scholar_institute'];?>"/>
						</div>
				</div>	
				 <div class="name-sec col-xs-12 col-sm-3 col-md-4">
					 <label for="comment">Duration of stay in India on Scholarship</label>
						<div class="pdleft col-md-6">
						<input type="text" class="form-control" placeholder="From " id="iccr_scholar_duration_from" name="iccr_scholar_duration_from" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['iccr_scholar_duration_from'];?>"/>
						</div>
						<div class="pdleft col-md-6">
						<input type="text" class="form-control" placeholder="To" id="iccr_scholar_duration_to" name="iccr_scholar_duration_to" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['iccr_scholar_duration_to'];?>"/>
						</div>
				</div>				
				</div>
							<?php	
							}
						}
						else
						{
						?>
						<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright iccr_scholar fade">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-2">
					 <label for="comment">Year of Scholarship</label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Year" id="iccr_scholar_year" name="iccr_scholar_year" />
						</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">Name of Course</label>
						<div class="form-group">						
					
						 <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
						  <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
						  <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> Ph.D.
						  <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
						</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-3">
					 <label for="comment">Name of Institue/University</label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Institute/Uni." id="iccr_scholar_institute" name="iccr_scholar_institute"/>
						</div>
				</div>	
				 <div class="name-sec col-xs-12 col-sm-3 col-md-4">
					 <label for="comment">Duration of stay in India on Scholarship</label>
						<div class="pdleft col-md-6">
						<input type="text" class="form-control" placeholder="From " id="iccr_scholar_duration_from" name="iccr_scholar_duration_from" />
						</div>
						<div class="pdleft col-md-6">
						<input type="text" class="form-control" placeholder="To" id="iccr_scholar_duration_to" name="iccr_scholar_duration_to" />
						</div>
				</div>				
				</div>
						<?php	
						}
						?>	
				
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
				<?php
				//print_r($registerData);
				?>
					<label>20.Application Submitted Through Indian Mission|Consulate in (<?php $countr = $this->common_model->getCountryById($registerSfsData[0]['country_of_domicile']); echo $countr[0]['country_name'];?>)<span class="text-red">*</span></label>
					<div class="col-xs-2 col-md-4 col-sm-2 pdleft" style="display:none;">
						<div class="form-group">
							<select class="selectpicker form-control mission_made_through" id="mission_made_through" name="mission_made_through" required="true">
								<option value="">------ Select Mission/Consulate ------</option>							
							 	<?php
								  $countries = $this->common_model->getCountries();
								  //echo "<pre>";
								  //print_r($countries);die;
								  foreach($countries as $country)
								  {
								  	if(!empty($registerSfsData))
								  	{
										if($registerSfsData[0]['country_of_domicile'] == $country['id'])
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
						</div>
					</div>
					<?php
					//print_r($applicaitonStepThree);
					 		
								?>
								<div class="col-xs-2 col-md-6 col-sm-2 pdleft pdright mission_list">
								<div class="form-group">
										<select id="application_through" name="application_through" class="selectpicker form-control" required="true" >
											<option value="">------ Select Mission/Consulate ------</option>
										 	<?php
											
										 	if(!empty($applicaitonSfsStepThree) && $applicaitonSfsStepThree[0]['mission_made_through'] >0)
									  		{
												
												if($applicaitonSfsStepThree[0]['mission_made_through'] > 0)
												{
													$missions = $this->common_model->getMissionsByCountry($applicaitonSfsStepThree[0]['mission_made_through']);
													foreach($missions as $mission)
						       						{			       							
														if($applicaitonSfsStepThree[0]['application_through'] == $mission['id'])
														{
															echo '<option selected="selected" value="'.$mission['id'].'">'.$mission['mission_type'].' '.$mission['mission_name'].'</option>';
														}
														else
														{
															echo '<option value="'.$mission['id'].'">'.$mission['mission_type'].' '.$mission['mission_name'].'</option>';
														}											
						       						}
												}
											}
											else
											{
												$missions = $this->common_model->getMissionsByCountry($registerSfsData[0]['country_of_domicile']);
													foreach($missions as $mission)
						       						{			       							
														echo '<option value="'.$mission['id'].'">'.$mission['mission_type'].' '.$mission['mission_name'].'</option>';
																									
						       						}
											}		
										 		
										 	?>				  
										</select>	
									</div>
								</div>
								<?php
					
					?>			
					
					</div>	
						
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-3 col-md-5">
					 <label for="comment">21. Do you have an International driving licence?</label>
						<div class="form-group">
						<?php
						if(!empty($applicaitonSfsStepThree) && $applicaitonSfsStepThree[0]['is_international_lic'] > 0)
						{
							if($applicaitonSfsStepThree[0]['is_international_lic'] == 1){
								?>
						  <input type="radio" class="is_international_lic" checked="true" value="1" name="is_international_lic" id="is_international_lic"> Yes
						  <input type="radio" class="is_international_lic" value="2" name="is_international_lic" id="is_international_lic"> No
						<?php
							}
							elseif($applicaitonSfsStepThree[0]['is_international_lic'] == 2){
								?>
						 <input type="radio" class="is_international_lic" value="1" name="is_international_lic" id="is_international_lic"> Yes
						  <input type="radio"  class="is_international_lic" checked="true" value="2" name="is_international_lic" id="is_international_lic"> No
						<?php
							}
						}
						else
						{
						?>
						  <input type="radio" class="is_international_lic" value="1" name="is_international_lic" id="is_international_lic"> Yes
						  <input type="radio"  checked="true" class="is_international_lic" value="2" name="is_international_lic" id="is_international_lic"> No
						<?php  	
						}
						?>
						  
						</div>
				</div>
				<?php
				if(!empty($applicaitonSfsStepThree) && $applicaitonSfsStepThree[0]['is_international_lic'] > 0)
				{
					if($applicaitonSfsStepThree[0]['is_international_lic'] == 1){
						?>
				<div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade in">
					<label for="comment">Licence Number</label>
					<div class="form-group">
					   <input type="text" name="is_international_lic_no" id="is_international_lic_no" class="form-control"  value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['is_international_lic_no'];?>"/> 					   
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade in">
					<label for="comment">Issuing Authority</label>
					<div class="form-group">
					    <input type="text" name="is_international_lic_auth" id="is_international_lic_auth" class="form-control"  value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['is_international_lic_auth'];?>"/> 
					   
					</div>
				 </div>	
						<?php
					}
					elseif($applicaitonSfsStepThree[0]['is_international_lic'] == 2){
						?>
				<div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
					<label for="comment">Licence Number</label>
					<div class="form-group">
					   <input type="text" name="is_international_lic_no" id="is_international_lic_no" class="form-control"  value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['is_international_lic_no'];?>"/> 					   
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
					<label for="comment">Issuing Authority</label>
					<div class="form-group">
					    <input type="text" name="is_international_lic_auth" id="is_international_lic_auth" class="form-control" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['is_international_lic_auth'];?>"/> 
					   
					</div>
				 </div>	
						<?php
					}
				}
				else
				{
					?>
					<div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
					<label for="comment">Licence Number</label>
					<div class="form-group">
					   <input type="text" name="is_international_lic_no" id="is_international_lic_no" class="form-control" /> 					   
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
					<label for="comment">Issuing Authority</label>
					<div class="form-group">
					    <input type="text" name="is_international_lic_auth" id="is_international_lic_auth" class="form-control" /> 
					   
					</div>
				 </div>	
					<?php
				}
				?>		
				</div>
				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">22. Any Other Information.</label>
						<div class="form-group">
						  <textarea class="form-control" placeholder="Other Information Which You Want to Share With Us." id="any_other_info" name="any_other_info"><?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['any_other_info'];?></textarea>
						</div>
				 </div>			
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">Date: <?php echo date('d-m-Y');?></label>
						
				 </div>			
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright" style="margin-bottom: 20px">				 			 
				 <div class="name-sec col-xs-12 col-sm-6 col-md-4">
					 
						<div class="form-group">
						 <label for="comment" style="float: left;width:20%;">Place: </label> <input style="float: left;width:79%;" type="text" class="form-control" placeholder="Place" id="place" name="place" value="<?php if(!empty($applicaitonSfsStepThree)) echo $applicaitonSfsStepThree[0]['place'];?>"/>
						</div>
				 </div>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-3 pull-right">
					 
						<div class="form-group">
						  <?php 						  
						  if(!empty($applicaitonSfsStepThree) && $applicaitonSfsStepThree[0]['signature_doc'] != "")
						  {
						  ?>
						  <a href="#" class="signaturediv_sfs_img"  data-toggle="modal" data-target="#sfs_signature">Re-Upload Signature</a>
						  <a target="_blank" href="<?php echo site_url(); ?>assets/site/main/profile_sfs_signature/<?php echo $applicaitonSfsStepThree[0]['signature_doc']; ?>" target="_blank" title="Click to View Signature"><img id="signatureImageImg" name="signatureImageImg" style="border:1px solid #cecece;padding:2px;width:50px;max-height:40px;" class="pull-right" src="<?php echo site_url(); ?>assets/site/main/profile_signature/<?php echo $applicaitonSfsStepThree[0]['signature_doc']; ?>"/></a>
						
						  <?php	
						  }
						  else
						  {
						  ?>
						  <a href="#" class="signaturediv_sfs_img"  data-toggle="modal" data-target="#sfs_signature">Upload Signature</a>
						 
						  <?php	
						  }
						  ?>						 
						  
						</div>
				 </div>			
				</div>
				  <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1"><input type="checkbox" checked="true" disabled="true" class="undertake"/>I hereby declare that the particulars given above are true to the best of my knowledge and belief and that I have understood the financial terms and conditions of the Scholarship Scheme. I hereby undertake to abide by them, and I also undertake to return to my country after completion of my studies in India.</span>
					</div>
										
				 </div>
				 </div>
				<div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
                <div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
              <!-- <input type="submit" class="form-control sbmt" value="Next >>"/>-->
               <button type="submit" class="form-control btn btn-info">Next &nbsp;&nbsp;<span class="glyphicon glyphicon-forward"></span></button>
                </div>
                <div class="name-sec col-xs-4 col-sm-2 col-md-6 pull-right">
				  <a href="<?php echo site_url();?>Sfs/applicant_sfs_education_info?appno=<?php echo $_GET['appno']; ?>" class="form-control btn btn-info">
				  <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;Previous</a>
				  </div>
              	</div>
              </div>
              <!-- /.box-body -->

            <?php echo form_close(); ?>
	  </div>
	  
	  	
	   
	</div>
	</div>
</section>
  <div id="sfs_signature" class="modal fade" role="dialog">
  	<div id="signatureSfsUpload" class="modal-dialog popup dropzone">
  		<div class="dz-message" data-dz-message><span>Click/Drop Image file Here</span></div>
  	</div>
  </div>
	
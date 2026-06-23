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
.note1{font-size: 10px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
</style>
	<form id="frm_download" name="frm_download" action="<?php echo site_url(); ?>applicant/exportPDF" method="post">
	<div class="name-sec col-xs-4 col-sm-2 col-md-2 pull-right" style="font-size:12px;position:absolute;right:7%;">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
		<input type="submit" class=" form-control sbmt" style="" value="Download"/>
		</div>
	</form>
<section class="meacontent detailpagepdf">		
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
		<h5 class="text-center">TO BE FILLED BY APPLICANT</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding-top:0px;">
	<!--<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#home">Personal Information</a></li>
	  <li><a data-toggle="tab" href="#menu1">Language & Course Details</a></li>
	  <li><a data-toggle="tab" href="#menu2">Education Details</a></li>
	  <li><a data-toggle="tab" href="#menu3">Course Details</a></li>
	  <li class="pull-right"><a href="<?php echo site_url();?>home/dashboard/student">Back</a></li>
	</ul>-->
	
	
	<div class="tab-content">
		<div id="step4" class="tab-pane fade in active ">
	    <form action="<?php echo site_url();?>user/register" enctype="multipart/form-data" method="post">
              <div class="box-body">
              	 <div class="name-sec col-xs-12 col-sm-5 col-md-12 text-center">
					<h4 class="text-uppercase">Certificate of Physical Fitness</h4>
					<h5>(To be filled by a Registered Medical practitioner in the applicant's country of domicile)</h5>
				</div>  
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Name</label>
                   <div class="form-group date">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Sex</label>
                   <div class="form-group">
                      <select class="selectpicker form-control">
                      	<option>Sex</option>
                      	<option>Male</option>
                      	<option>Female</option>
                      	<option>Other</option>
                      </select>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Marital Status</label>
                   <div class="form-group">
                      <select class="selectpicker form-control">
                      	<option>Select</option>
                      	<option>Married</option>
                      	<option>Un-Married</option>
                      	<option>Widow</option>
                      </select>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Age</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>  
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Blood Group</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>              	
               </div> 
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				  <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Nationality</label>
                   <div class="form-group date">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
				 <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Country</label>
                   <div class="form-group">
                      <select class="selectpicker form-control">
                      	<option>Select</option>
                      	<option>Male</option>
                      	<option>Female</option>
                      	<option>Other</option>
                      </select>
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">City</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Telephone</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>  
                <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                   <label for="comment">Email Address</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>              	
               </div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">Address</label>
					<div class="form-group">
					  <textarea class="form-control" rows="2" id="postal" placeholder="Postal Address"></textarea>
					</div>
				 </div>	
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>Medical History  <span class="note1"><strong>Note: </strong>(Please give details of any past medical condition which may adversely impact the patient's health at the current time or in the near future')</span></h4>
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>History of Any Known Illness/Surgery</h4>
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">(1) Raised BP</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>	
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					<label for="comment">If, Yes-No Regular treatment</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">(2) DM</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>	
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					<label for="comment">If, Yes-No Regular treatment</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				</div>				
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">(3) IHD</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>	
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					<label for="comment">If, Yes-No Regular treatment</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">(4) Stroke</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>	
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					<label for="comment">If, Yes-No Regular treatment</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				</div>				
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>Kidney Disease</h4>
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">Chronic Rental Failure</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>	
				 <div class="name-sec col-xs-12 col-sm-6 col-md-6">
					<label for="comment">If, Yes-No Regular treatment</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>Any history of Surgery/Prolonged hospitalization (more than 2 weeks)</h4>
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<span class="note1"><strong>Note: </strong>(Yes/No; if Yes, details of illness/injury/surgery with duration of illness/treatment)</span>
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">history of loss of apetite</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>	
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					<label for="comment">history of loss of Weight</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					<label for="comment">history of digestive diseases</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					<label for="comment">Family History of</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> DM
						  <input type="checkbox" name="lang"/> HT
						  <input type="checkbox" name="lang"/> Obesity
					</div>
				 </div>
				</div>
				<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				 <div class="name-sec col-xs-12 col-sm-6 col-md-8">
					 <label for="comment">Any known Allergy:- If so, is the patient on any medication/precautions?</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>				 
				</div>	
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>Physical Examination</h4>
					<h5>Mdedical condition of:</h5>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Height</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Weight</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>  
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Chest</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Head</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Nose</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Lungs</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
				</div>
				<div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				<div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Eyes</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Pharynx</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>  
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Heart</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Ears</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Neck</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
                <div class="name-sec col-xs-12 col-sm-3 col-md-2">
                   <label for="comment">Reflexes</label>
                   <div class="form-group">
                      <input type="text" class="form-control" placeholder="Occupation" id="">
                   </div>
                </div>
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>Remarks if any:</h4>
					<h5><strong>Mdedical Examination:</strong> &nbsp;&nbsp;Routine Blood, (Including fasting & P.P), Urine Test and Chest X-Ray and any other test as deemed fit by the Medical Practitioner (to rute out any chronic disease).</h5>
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>Summary</h4>
					<h5>I believe this applicant IS/IS NOT physical able to carry on a full course of study, involving long hours of work, in a college or university in India.</h5>
					
				</div>
				<div class="name-sec col-xs-12 col-sm-6 col-md-9">
					 <label for="comment">In my opinion the applicant's health and physical condition in general are:</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Excelent
						  <input type="checkbox" name="lang"/> Good
						  <input type="checkbox" name="lang"/> Poor
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>I certify that the applicant is up-to-date on routine vaccinations including, among others, MMR, DPT, Varicella, Hepatitis A& B etc.</h4>										
				</div>
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">He/She has no physical condition/aliment which would hinder him from pursuing a full course of study in India.</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				<div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">He/She present no evidence of any communicable disease or of any chronic fatigue.</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">He/She does not have any chronic medical condition which requires regular and sustained medical treatment.</label>
					<div class="form-group">
						  <input type="checkbox" name="lang"/> Yes
						  <input type="checkbox" name="lang"/> No
					</div>
				 </div>
				 <div class="name-sec col-xs-12 col-sm-6 col-md-12">
					 <label for="comment">Note: If answers to 4,5 and 6 above are postive, please give details in Remarks column below.</label>
					<div class="form-group">
						  <textarea class="form-control" rows="2" id="postal" placeholder="Remarks"></textarea>
					</div>
				 </div>
				 <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
				 <div class="name-sec col-xs-12 col-sm-6 col-md-2">
					<label for="comment">Date</label>
					<div class="form-group">
						  <input type="text" class="form-control" name="lang"/> 						  
					</div>
				 </div>	
				 <div class="name-sec col-xs-12 col-sm-6 col-md-7">
					<label for="comment">Address</label>
					<div class="form-group">
						 <input type="text" class="form-control" name="lang"/>
					</div>
				 </div>
				  <div class="name-sec col-xs-12 col-sm-6 col-md-3">
					 <label for="comment">Signature</label>
					<div class="form-group">
						  <input type="text" class="form-control" name="lang"/>
					</div>
				 </div>					 
				</div>
				<div class="name-sec col-xs-12 col-sm-5 col-md-12">
					<h4>IMPORTANT:</h4>					
				</div>
				 <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
				 	<div class="name-sec col-xs-12 col-sm-6 col-md-12">					
					<div class="form-group">
						<span class="note1"><input type="checkbox" class="undertake"/>As a protective measure, those planning to study in India are strongly advise to get vaccinated against typhoid/cholera before coming to India.</span>
					</div>
										
				 </div>
				 </div>
				<div class="name-sec col-xs-4 col-sm-2 col-md-4 pull-right">
                <div class="name-sec col-xs-4 col-sm-2 col-md-7 pull-right">
                <input type="submit" id="step-one-application" name="step-two-application" class="form-control sbmt" value="Submit"/>
                </div>               
              	</div>
              </div>
              <!-- /.box-body -->

            </form>
	  </div>	   
	</div>
	</div>
</section>
	
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
   .capitalLetter:valid { text-transform: uppercase; } 
   .capitalLetter::placeholder { text-transform: capitalize; }
</style>
<section class="meacontent">
   <div class="col-xs-10 form_head">
      <img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
      <h3 class="text-center caps">Application Form For Scholarship through ICCR</h3>
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
         <form id="form-process-doc" enctype="multipart/form-data" method="post">
            <input type="hidden" name="application_no" value="<?php echo $applicaitonStepOne[0]['application_no'];?>"/>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
            <div class="box-body">
               <div class="name-sec col-xs-12 col-sm-5 col-md-12">
                  <h4>26. Give below the names of two persons who have agreed to testify from their personal knowledge to your character (they must not be related to you and should have direct knowledge of your academic pursuits).</h4>
               </div>
               <!-- <span>Reference&nbsp;of&nbsp;the&nbsp;Student&nbsp;already&nbsp;studying&nbsp;in&nbsp;India&nbsp;under&nbsp;ICCR&nbsp;Scholarship.</span> -->
               <br>
               <div class="passport-sec col-xs-12 col-sm-12 col-md-6 pdleft pdright" style="background: rgb(244, 244, 244) none repeat scroll 0% 0%; border: 1px solid rgb(206, 206, 206); margin-right: 0px;padding-top: 20px;">
                  <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                     <label for="comment"><u>Reference 1 </u></label><br>
                  </div>
                  <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Name <span class="text-red">*</span></label>
                        <div class="form-group date">
                           <input type="text"  class="form-control capitalLetter"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Name" id="enq_ref_one_name" name="enq_ref_one_name" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_name'];?>" required="true"/>
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Occupation<span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="text" class="form-control capitalLetter"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Occupation" id="enq_ref_one_designation" name="enq_ref_one_designation" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_designation'];?>" required="true"/>
                        </div>
                     </div>
                  </div>
                  <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Email<span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="email" class="form-control" placeholder="Email" id="enq_ref_one_email" name="enq_ref_one_email" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_email'];?>" required="true"/> 
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Telephone <span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="text" pattern="^[0-9]+$" title="0-9" maxlength="15" class="form-control" placeholder="Telephone" id="enq_ref_one_phone" name="enq_ref_one_phone"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_phone'];?>" required="true"/>
                        </div>
                     </div>
                  </div>
                  <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                     <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                        <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                           <label for="comment"> Postal Address <span class="text-red">*</span></label>	
                           <div class="form-group col-md-12 pdleft">							
                              <textarea class="form-control capitalLetter" rows="3" id="enq_ref_one_address" name="enq_ref_one_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address'];?></textarea>
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
                           <input type="text" class="form-control capitalLetter" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Name" id="enq_ref_two_name" name="enq_ref_two_name"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_name'];?>" required="true"/>
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Occupation <span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="text" class="form-control capitalLetter" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Occupation" id="enq_ref_two_designation" name="enq_ref_two_designation" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation'];?>" required="true"/>
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Email <span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="email" class="form-control" placeholder="Email" id="enq_ref_two_email" name="enq_ref_two_email" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_email'];?>" required="true"/>
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Telephone <span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="text" pattern="^[0-9]+$" title="0-9" maxlength="15" class="form-control" placeholder="Telephone" id="enq_ref_two_phone" name="enq_ref_two_phone" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_phone'];?>" required="true"/>
                        </div>
                     </div>
                     <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                        <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                           <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                              <label for="comment"> Postal Address <span class="text-red">*</span></label>	
                              <div class="form-group col-md-12 pdleft">							
                                 <textarea class="form-control capitalLetter" rows="3" id="enq_ref_two_address" name="enq_ref_two_address" placeholder="Postal Address" required="true" ><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_address'];?></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="name-sec col-xs-12 col-sm-5 col-md-12">
                  <h4>27. Details of close relative(s) or friends, if any, in India.</h4>
               </div>
               <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                  <div class="form-group">
                     <?php
                        if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['is_iccr_relative_friends'] > 0)
                        {
                        	if($applicaitonStepThree[0]['is_iccr_relative_friends'] == 1){
                        		?>
                     <input type="radio" class="is_iccr_relative_friends" checked="true" value="1" id="is_iccr_relative_friends" name="is_iccr_relative_friends"> Yes
                     <input type="radio" class="is_iccr_relative_friends" value="2" id="is_iccr_relative_friends" name="is_iccr_relative_friends"> No
                     <?php
                        }
                        elseif($applicaitonStepThree[0]['is_iccr_relative_friends'] == 2){
                        	?>
                     <input type="radio" class="is_iccr_relative_friends" value="1" id="is_iccr_relative_friends" name="is_iccr_relative_friends"> Yes
                     <input type="radio" class="is_iccr_relative_friends" checked="true" value="2" id="is_iccr_relative_friends" name="is_iccr_relative_friends"> No
                     <?php
                        }
                        }
                        else
                        {
                        ?>
                     <input type="radio" class="is_iccr_relative_friends" value="1" checked="true" id="is_iccr_relative_friends" name="is_iccr_relative_friends"> Yes
                     <input type="radio"  class="is_iccr_relative_friends" value="2" id="is_iccr_relative_friends" name="is_iccr_relative_friends"> No
                     <?php  	
                        }
                        ?>
                  </div>
               </div>
               <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright friends_relative">
                  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                     <label for="comment">Name </label>
                     <div class="form-group date">
                        <input type="text" class="form-control capitalLetter" placeholder="Name" id="relative_ref_name" name="relative_ref_name" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_name'];?>"/>
                     </div>
                  </div>
                  
                  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                     <label for="comment">Relationship</label>
                     <div class="form-group">
                        <input type="text" class="form-control capitalLetter" placeholder="Relationship" id="relative_ref_relation" name="relative_ref_relation" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_relation'];?>"/>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                     <label for="comment">Occupation</label>
                     <div class="form-group">
                        <input type="text" class="form-control capitalLetter" placeholder="Designation" id="relative_ref_designation" name="relative_ref_designation"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_designation'];?>"/>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                     <label for="comment">Postal Address</label>
                     <div class="form-group date">
                        <textarea class="form-control capitalLetter" placeholder="Address" id="relative_ref_address" name="relative_ref_address"><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_address'];?></textarea>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                     <label for="comment">Mobile Number</label>
                     <div class="form-group">
                        <input type="text" class="form-control" placeholder="Mobile Number" id="relative_ref_contact" name="relative_ref_contact" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_contact'];?>"/>
                     </div>
                     <span id="spnError" style="color: Red; display: none">*Valid characters: Numbers and special characters.</span>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                     <label for="comment">Email</label>
                     <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" id="relative_ref_email" name="relative_ref_email"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['relative_ref_email'];?>"/>
                     </div>
                  </div>
               </div>
               <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                  <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                     <label for="comment">28. Have you travelled or lived in India in the past?</label>
                     <div class="form-group">
                        <?php
                           //echo '<pre>';
                           //print_r($applicaitonStepThree);
                           if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['is_travel_or_live_in_india_before'] > 0)
                           {
                           	if($applicaitonStepThree[0]['is_travel_or_live_in_india_before'] == 1){
                           		?>
                        <input value="1" checked="true" type="radio" id="is_travel_or_live_in_india_before" name="is_travel_or_live_in_india_before"> Yes
                        <input value="2" type="radio" id="is_travel_or_live_in_india_before" name="is_travel_or_live_in_india_before"> No
                        <?php
                           }
                           elseif($applicaitonStepThree[0]['is_travel_or_live_in_india_before'] == 2){
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
                  <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                     <label for="comment">29. Have you ever availed of ICCR Scholarship earlier?</label>
                     <div class="form-group">
                        <?php
                           if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] > 0)
                           {
                           	if($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 1){
                           		?>
                        <input type="radio" class="is_iccr_scholarship_avail_before" checked="true" value="1" id="is_iccr_scholarship_avail_before" name="is_iccr_scholarship_avail_before"> Yes
                        <input type="radio" class="is_iccr_scholarship_avail_before" value="2" id="is_iccr_scholarship_avail_before" name="is_iccr_scholarship_avail_before"> No
                        <?php
                           }
                           elseif($applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 2){
                           	?>
                        <input type="radio" class="is_iccr_scholarship_avail_before" value="1" id="is_iccr_scholarship_avail_before" name="is_iccr_scholarship_avail_before"> Yes
                        <input type="radio" class="is_iccr_scholarship_avail_before" checked="true" value="2" id="is_iccr_scholarship_avail_before" name="is_iccr_scholarship_avail_before"> No
                        <?php
                           }
                           }
                           else
                           {
                           ?>
                        <input type="radio" class="is_iccr_scholarship_avail_before" value="1" id="is_iccr_scholarship_avail_before" name="is_iccr_scholarship_avail_before"> Yes
                        <input type="radio"  checked="true" class="is_iccr_scholarship_avail_before" value="2" id="is_iccr_scholarship_avail_before" name="is_iccr_scholarship_avail_before"> No
                        <?php  	
                           }
                           ?>
                     </div>
                  </div>
               </div>
               <?php
				if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['is_iccr_scholarship_avail_before'] == 1){
				?>
               <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright iccr_scholar" id="iccr_scholar">
                  <div class="name-sec col-xs-12 col-sm-6 col-md-2">
                     <label for="comment">Year of Scholarship</label>
                     <div class="form-group">
                        <input type="text" class="form-control capitalLetter" placeholder="Year" id="iccr_scholar_year" name="iccr_scholar_year" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_year'];?>"/>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3">
                     <label for="comment">Name of Course</label>
                     <div class="form-group">
                        <?php
                           if(!empty($applicaitonStepThree))
                           {
                           	if($applicaitonStepThree[0]['iccr_scholar_course'] == 1){
                           		?>
                        <input type="radio" checked="true" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
                        <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
                        <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> PhD
                        <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
                        <?php
                           }
                           elseif($applicaitonStepThree[0]['iccr_scholar_course'] == 2){
                           	?>
                        <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
                        <input type="radio" checked="true" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
                        <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> PhD
                        <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
                        <?php
                           }
                           elseif($applicaitonStepThree[0]['iccr_scholar_course'] == 3){
                           	?>
                        <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
                        <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
                        <input checked="true" type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> PhD
                        <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
                        <?php
                           }
                           elseif($applicaitonStepThree[0]['iccr_scholar_course'] == 4){
                           	?>
                        <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
                        <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
                        <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> PhD
                        <input type="radio" checked="true" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
                        <?php
                           }
                           }
                           else
                           {
                           ?>
                        <input type="radio" value="1" name="iccr_scholar_course" id="iccr_scholar_course"> UG
                        <input type="radio" value="2" name="iccr_scholar_course" id="iccr_scholar_course"> PG
                        <input type="radio" value="3" name="iccr_scholar_course" id="iccr_scholar_course"> PhD
                        <input type="radio" value="4" name="iccr_scholar_course" id="iccr_scholar_course"> Other
                        <?php  	
                           }
                           ?>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                     <label for="comment">Earlier Application Number</label>
                     <div class="form-group">
                        <input type="text" class="form-control capitalLetter" placeholder="Application Number" id="old_application_number" name="old_application_number" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['old_application_number'];?>"/>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                     <label for="comment">Name of Institue/University</label>
                     <div class="form-group">
                        <input type="text" class="form-control capitalLetter" placeholder="Name of Institue/University" id="iccr_scholar_institute" name="iccr_scholar_institute" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_institute'];?>"/>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-4">
                     <label for="comment">Duration of stay in India on Scholarship</label>
                     <div class="pdleft col-md-6">
                        <input type="text" class="form-control capitalLetter" placeholder="From " id="iccr_scholar_duration_from" name="iccr_scholar_duration_from" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_from'];?>"/>
                     </div>
                     <div class="pdleft col-md-6">
                        <input type="text" class="form-control capitalLetter" placeholder="To" id="iccr_scholar_duration_to" name="iccr_scholar_duration_to" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['iccr_scholar_duration_to'];?>"/>
                     </div>
                  </div>
               </div>
               <?php	
                  }
                  else
                  {
                  ?>
               <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright iccr_scholar fade" id="iccr_scholar">
                  <div class="name-sec col-xs-12 col-sm-6 col-md-2">
                     <label for="comment">Year of Scholarship</label>
                     <div class="form-group">
                        <input type="text" class="form-control capitalLetter" placeholder="Year" id="iccr_scholar_year" name="iccr_scholar_year" />
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
                     <label for="comment">Earlier Application Number</label>
                     <div class="form-group">
                        <input type="text" class="form-control capitalLetter" placeholder="Application Number" id="old_application_number" name="old_application_number" value=""/>
                        <?php //if(isset($applicaitonStepThree)) echo $applicaitonStepThree[0]['old_application_number'];?>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-3">
                     <label for="comment">Name of Institue/University</label>
                     <div class="form-group">
                        <input type="text" class="form-control capitalLetter" placeholder="Institute/Uni." id="iccr_scholar_institute" name="iccr_scholar_institute"/>
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
               <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                  <div class="name-sec col-xs-12 col-sm-6 col-md-5">
                     <label for="comment">30. Are you currently a resident in India?</label>
                     <div class="form-group">
                        <?php
                           if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['currently_non_nri']>0)
                           {
                           	if($applicaitonStepThree[0]['currently_non_nri'] == 1){
                           		?>
                        <input type="radio" checked="true" class="currently_non_nri_val" value="1" name="currently_non_nri" id="currently_non_nri"> Yes
                        <input type="radio" value="2" class="currently_non_nri_val" name="currently_non_nri" id="currently_non_nri"> No
                        <?php
                           }
                           elseif($applicaitonStepThree[0]['currently_non_nri'] == 2){
                           	?>
                        <input type="radio" value="1" class="currently_non_nri_val" name="currently_non_nri" id="currently_non_nri"> Yes
                        <input type="radio" checked="true" class="currently_non_nri_val" value="2" name="currently_non_nri" id="currently_non_nri"> No
                        <?php
                           }
                           }
                           else
                           {
                           ?>
                        <input type="radio" value="1" class="currently_non_nri_val" name="currently_non_nri" id="currently_non_nri"> Yes
                        <input type="radio" value="2" class="currently_non_nri_val" name="currently_non_nri" checked="true" id="currently_non_nri"> No
                        <?php  	
                           }
                           ?>
                     </div>
                  </div>
                  <?php				 	
                     if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['currently_non_nri'] >0)
                     {
                     	if($applicaitonStepThree[0]['currently_non_nri'] == 1){
                     		?>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-7 fade in is_indian_address">
                     <label for="comment">Postal Address</label>
                     <div class="pdleft col-md-12">
                        <textarea class="form-control capitalLetter" placeholder="Address" id="currently_non_nri_address" name="currently_non_nri_address" required="true"><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['currently_non_nri_address'];?></textarea>
                     </div>
                  </div>
                  <?php
                     }
                     elseif($applicaitonStepThree[0]['currently_non_nri'] == 2){
                     	?>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-7 fade is_indian_address">
                     <label for="comment">Postal Address</label>
                     <div class="pdleft col-md-12">
                        <textarea class="form-control capitalLetter" placeholder="Address" id="currently_non_nri_address" name="currently_non_nri_address"><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['currently_non_nri_address'];?></textarea>
                     </div>
                  </div>
                  <?php
                     }
                     else{
                     	?>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-7 fade is_indian_address">
                     <label for="comment">Postal Address</label>
                     <div class="pdleft col-md-12">
                        <textarea class="form-control capitalLetter" placeholder="Address" id="currently_non_nri_address" name="currently_non_nri_address"><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['currently_non_nri_address'];?></textarea>
                     </div>
                  </div>
                  <?php
                     }
                     }
                     else
                     {
                     ?>
                  <div class="name-sec col-xs-12 col-sm-3 col-md-7 fade is_indian_address">
                     <label for="comment">Postal Address</label>
                     <div class="pdleft col-md-12">
                        <textarea class="form-control capitalLetter" placeholder="Address" id="currently_non_nri_address" name="currently_non_nri_address"><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['currently_non_nri_address'];?></textarea>
                     </div>
                  </div>
                  <?php
                     }
                     ?>							
               </div>
               <div class="formrow">
                  <div class="col-xs-12 col-sm-3 col-md-6">
                     <div class="forminner">
                        <label for="comment" title = "">31. Are you married to an Indian national?<span class="text-red">*</span></label>
                        <?php
                           $merried = '';
                           if ( count( $applicaitonStepThree ) > 0 ) {
                           $merried = $applicaitonStepThree[ 0 ][ 'is_married' ];
                           }
                           
                           if ( $merried == 1 ) {
                           ?>
                        <input checked="true" class="is_married" type="radio" value="1" name="is_married" id="is_married"/>
                        Yes
                        <input type="radio" class="is_married" value="2" name="is_married" id="is_married"/>
                        No
                        <?php
                           } elseif ( $merried == 2 ) {
                            ?>
                        <input type="radio" class="is_married" value="1" name="is_married" id="is_married"/>
                        Yes
                        <input checked="true" class="is_married" type="radio" value="2" name="is_married" id="is_married"/>
                        No
                        <?php
                           } else {
                           ?>
                        <input type="radio" class="is_married" value="1" name="is_married" id="is_married"/>
                        Yes
                        <input type="radio" class="is_married" value="2" name="is_married" id="is_married" checked="true"/>
                        No
                        <?php
                           }
                           ?>
                     </div>
                     <?php
                        $merrieds = '';
                        	  if ( count( $applicaitonStepThree ) > 0 ) {
                        		$merrieds = $applicaitonStepThree[ 0 ][ 'married' ];
                        	  }
                        	if ( $merrieds == 1 ) {
                        ?>
                     <div class="col-xs-12 col-sm-4 col-md-4 is_indian_married pdleft">
                        <?php
                           if ( $applicaitonStepThree[ 0 ][ 'married' ] == 1 ) {
                           ?>
                        <input type="radio" checked="true" value="1" name="married" id="married "/>
                        Married
                        <input type="radio" value="2" name="married" id="married"/>
                        Unmarried
                        <?php
                           } elseif ( $applicaitonStepThree[ 0 ][ 'married' ] == 2 ) {
                            ?>
                        <input type="radio" value="1" name="married" id="married "/>
                        Married
                        <input type="radio" checked="true" value="2" name="married" id="married"/>
                        Unmarried
                        <?php
                           }  else {
                           ?>
                        <input type="radio" value="1" name="married" id="married "/>
                        Married
                        <input type="radio" value="2" name="married" id="married"/>
                        Unmarried
                        <?php
                           }
                           ?>
                     </div>
                     <?php
                        } else {
                        ?>
                     <div class="col-xs-12 col-sm-6 col-md-6 pdleft is_indian_married fade">
                        <input type="radio" value="1" name="married" id="married "/>
                        Married
                        <input type="radio" value="2" name="married" id="married"/>
                        Unmarried
                     </div>
                     <?php
                        }
                        ?>
                  </div>
               </div>
               <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                  <div class="name-sec col-xs-12 col-sm-3 col-md-5">
                     <label for="comment">32. Do you have an International driving licence?</label>
                     <div class="form-group">
                        <?php
                           if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['is_international_lic'] > 0)
                           {
                           	if($applicaitonStepThree[0]['is_international_lic'] == 1){
                           		?>
                        <input type="radio" class="is_international_lic" checked="true" value="1" name="is_international_lic" id="is_international_lic"> Yes
                        <input type="radio" class="is_international_lic" value="2" name="is_international_lic" id="is_international_lic"> No
                        <?php
                           }
                           elseif($applicaitonStepThree[0]['is_international_lic'] == 2){
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
                     if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['is_international_lic'] > 0)
                     {
                     	if($applicaitonStepThree[0]['is_international_lic'] == 1){
                     		?>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade in">
                     <label for="comment">Licence Number</label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_no" id="is_international_lic_no" class="form-control capitalLetter"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_no'];?>"/> 					   
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade in">
                     <label for="comment">Issuing Authority</label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_auth" id="is_international_lic_auth" class="form-control capitalLetter"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_auth'];?>"/> 
                     </div>
                  </div>
                  <?php
                     }
                     elseif($applicaitonStepThree[0]['is_international_lic'] == 2){
                     	?>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
                     <label for="comment">Licence Number</label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_no" id="is_international_lic_no" class="form-control capitalLetter"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_no'];?>"/> 					   
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
                     <label for="comment">Issuing Authority</label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_auth" id="is_international_lic_auth" class="form-control capitalLetter" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_auth'];?>"/> 
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
                        <input type="text" name="is_international_lic_no" id="is_international_lic_no" class="form-control " /> 					   
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
                     <label for="comment">Issuing Authority</label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_auth" id="is_international_lic_auth" class="form-control capitalLetter" /> 
                     </div>
                  </div>
                  <?php
                     }
                     ?>		
               </div>
               <div class="name-sec col-xs-12 col-sm-5 col-md-12">
                  <?php
                     //print_r($registerData);
                     ?>
                  <label>33. Application Submitted Through Indian Mission|Consulate in (<?php $countr = $this->common_model->getCountryById($registerData[0]['country_of_domicile']); echo $countr[0]['country_name'];?>)<span class="text-red">*</span></label>
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
                              	if(!empty($registerData))
                              	{
                              if($registerData[0]['country_of_domicile'] == $country['id'])
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
                              if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['mission_made_through'] >0)
                              	{
                              
                              if($applicaitonStepThree[0]['mission_made_through'] > 0)
                              {
                              	$missions = $this->common_model->getMissionsByCountry($applicaitonStepThree[0]['mission_made_through']);
                              	foreach($missions as $mission)
                               						{			       							
                              		if($applicaitonStepThree[0]['application_through'] == $mission['id'])
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
                              $missions = $this->common_model->getMissionsByCountry($registerData[0]['country_of_domicile']);
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
                  <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                     <label for="comment">34. Any Other Information.</label>
                     <div class="form-group">
                        <textarea class="form-control capitalLetter" placeholder="Other Information Which You Want to Share With Us." id="any_other_info" name="any_other_info"><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['any_other_info'];?></textarea>
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
                        <label for="comment" style="float: left;width:20%;">Place: </label> <input style="float: left;width:79%;" type="text" class="form-control" placeholder="Place" id="place" name="place" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['place'];?>"/>
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 pull-right">
                     <div class="form-group">
                        <?php 
                           if(isset($applicaitonStepThree[0]['uid'])){
                            $userd = $this->common_model->getUserInfo($applicaitonStepThree[0]['uid']); 
                            $imgs = file_get_contents($userd->dir .'/'.$applicaitonStepThree[0]['signature_doc']);
                            $data = base64_encode($imgs);
                            $f = finfo_open();
                            $imgdata = base64_decode($data);
                            $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
                            // if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['signature_doc'] != "")
                            //{
                           //if(file_exists($userd->dir.'/'.$applicaitonStepThree[0]['signature_doc']))
                           
                            ?>
                        <a href="#" class="signaturediv_img" id="reuploadsignature" data-toggle="modal" data-target="#signature">Re-Upload Signature</a>
                        <hr>
                        <span style="color:black;font-weight: bold;box-shadow:4px 1px 13px yellow inset;">Note: (Signature should be less than equal to 200 KB and in JPG/JPEG/PNG format) </span>
                        <a target="_blank"  title="Click to View Signature"><img id="signatureImageImg" name="signatureImageImg" style="border:1px solid #cecece;padding:2px;width:50px;max-height:40px;" class="pull-right" src="data:<?php echo $mime_type;?>;base64,<?php echo $data;?>"/></a>
                        <?php	
                          // }
                           }
                           else
                           {
                           ?>
                        <a href="#" class="signaturediv_img"  data-toggle="modal" data-target="#signature">Upload Signature</a>
                        <hr>
                        <span style="color:black;font-weight: bold;box-shadow:4px 1px 13px yellow inset;">Note: (Signature should be less than equal to 200 KB and in JPG/JPEG/PNG format) </span>
                        <?php	
                           }
                           ?>						 
                     </div>
                  </div>
               </div>
               <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                  <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                     <div class="form-group">
                        <span class="note1"><input type="checkbox" checked="true" disabled="true" class="undertake"/>I hereby declare that the particulars given above are true to the best of my knowledge and belief and that I have understood the financial terms and conditions of the Scholarship Scheme. I hereby undertake to abide by them, and I also undertake to return to my country after completion of my studies in India.Any false information given in the application will be liable to cancellation of admission.</span>
                        <span>Please give your preference with highest preference on the top and lowest on the bottom.</span>
                     </div>
                  </div>
               </div>
               <div class="form-group text-right">
                  <?php
                     //echo "<pre>";print_r($applicaitonStepThree);
                     if(!empty($applicaitonStepThree))
                     		{
                     			?>
                  <a href="<?php echo site_url();?>applicant/applicant_other_info_prev?appno=<?php echo $applicaitonStepThree[0]['application_no']; ?>" class="form-control sbmt" target = "_blank"><span></span>&nbsp;&nbsp;Preview</a>
                  <?php
                     }else{
                     	?>
                  <a href="javascript:void(0);" class="form-control sbmt" disabled><span></span>&nbsp;&nbsp;Preview</a>
                  <?php
                     }
                     
                     ?>
                  <!------<a href="<?php echo site_url();?>applicant/applicant_education_info?appno=<?php //echo html_escape($_GET['appno']); ?>" class="form-control sbmt">
                     <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;Previous</a>------>
                  <button type="submit" class="form-control sbmt">Next &nbsp;&nbsp;<span class="glyphicon glyphicon-forward"></span></button>
               </div>
               <!-- /.box-body -->
         </form>
         <?php //echo form_close(); ?>
         </div>
      </div>
   </div>
</section>
<div id="signature" class="modal fade" role="dialog">
   <div id="signatureUpload" class="modal-dialog popup dropzone ">
      <div class="dz-message" data-dz-message><span>Click/Drop Image file Here</span></div>
   </div>
</div>

<!-- add old application number -->

<script>
   $(document).on("click",".is_iccr_scholarship_avail_before",function(){
   	var is_Indian = $(this).val();   
   	if(is_Indian == 1){
   		$('#iccr_scholar').removeClass("fade");
   		$('#iccr_scholar').addClass("fade in");
   	}else{
   		$('#iccr_scholar').removeClass("fade in");
   		$('#iccr_scholar').addClass("fade");
   	}
   });
</script>
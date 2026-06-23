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
      <h3 class="text-center caps">Application Form (2026-2027)</h3>
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
                           <input type="text"  class="form-control capitalLetter"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Name" id="enq_ref_one_name" name="enq_ref_one_name" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_name'];?>" required/>
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Occupation<span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="text" class="form-control capitalLetter"  pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Occupation" id="enq_ref_one_designation" name="enq_ref_one_designation" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_designation'];?>" required/>
                        </div>
                     </div>
                  </div>
                  <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Email<span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="email" class="form-control" placeholder="Email" id="enq_ref_one_email" name="enq_ref_one_email" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_email'];?>" required/> 
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Telephone <span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="text" pattern="^[0-9]+$" title="0-9" maxlength="15" class="form-control" placeholder="Telephone" id="enq_ref_one_phone" name="enq_ref_one_phone"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_phone'];?>" required/>
                        </div>
                     </div>
                  </div>
                  <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                     <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                        <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                           <label for="comment"> Postal Address <span class="text-red">*</span></label>	
                           <div class="form-group col-md-12 pdleft">							
                              <textarea class="form-control capitalLetter" rows="3" id="enq_ref_one_address" name="enq_ref_one_address" placeholder="Postal Address" required ><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_one_address'];?></textarea>
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
                           <input type="text" class="form-control capitalLetter" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Name" id="enq_ref_two_name" name="enq_ref_two_name"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_name'];?>" required/>
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Occupation <span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="text" class="form-control capitalLetter" pattern="^[a-zA-Z ]+$" title="A-Z a-z ' '" placeholder="Occupation" id="enq_ref_two_designation" name="enq_ref_two_designation" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_designation'];?>" required/>
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Email <span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="email" class="form-control" placeholder="Email" id="enq_ref_two_email" name="enq_ref_two_email" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_email'];?>" required/>
                        </div>
                     </div>
                     <div class="name-sec col-xs-12 col-sm-3 col-md-6">
                        <label for="comment">Telephone <span class="text-red">*</span></label>
                        <div class="form-group">
                           <input type="text" pattern="^[0-9]+$" title="0-9" maxlength="15" class="form-control" placeholder="Telephone" id="enq_ref_two_phone" name="enq_ref_two_phone" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_phone'];?>" required/>
                        </div>
                     </div>
                     <div class="passport-sec col-xs-12 col-sm-12 col-md-12 pdleft pdright">
                        <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                           <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                              <label for="comment"> Postal Address <span class="text-red">*</span></label>	
                              <div class="form-group col-md-12 pdleft">							
                                 <textarea class="form-control capitalLetter" rows="3" id="enq_ref_two_address" name="enq_ref_two_address" placeholder="Postal Address" required ><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['enq_ref_two_address'];?></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php
$step3      = !empty($applicaitonStepThree) ? $applicaitonStepThree[0] : [];
$relative   = $step3['is_iccr_relative_friends'] ?? 1; // default Yes
?>
<div class="col-md-12">
    <h4>27. Details of close relative(s) or friends, if any, in India.</h4>

    <div class="form-group">
        <label>
            <input type="radio" name="is_iccr_relative_friends" value="1"
                <?= ($relative == 1) ? 'checked' : ''; ?>>
            Yes
        </label>

        <label>
            <input type="radio" name="is_iccr_relative_friends" value="2"
                <?= ($relative == 2) ? 'checked' : ''; ?>>
            No
        </label>
    </div>

    <!-- Relative Details -->
    <div id="relative_section" style="display:none;">

        <div class="row">

            <div class="col-md-4">
                <label>Name<span class="text-red">*</span></label>
                <input type="text" class="form-control"
                    name="relative_ref_name" 
                    value="<?= $step3['relative_ref_name'] ?? ''; ?>">
            </div>

            <div class="col-md-4">
                <label>Relationship<span class="text-red">*</span></label>
                <input type="text" class="form-control"
                    name="relative_ref_relation" 
                    value="<?= $step3['relative_ref_relation'] ?? ''; ?>">
            </div>

            <div class="col-md-4">
                <label>Occupation<span class="text-red">*</span></label>
                <input type="text" class="form-control"
                    name="relative_ref_designation" 
                    value="<?= $step3['relative_ref_designation'] ?? ''; ?>">
            </div>

            <div class="col-md-4 mt-2">
                <label>Postal Address<span class="text-red">*</span></label>
                <textarea class="form-control" 
                    name="relative_ref_address"><?= $step3['relative_ref_address'] ?? ''; ?></textarea>
            </div>

            <div class="col-md-4 mt-2">
                <label>Mobile Number<span class="text-red">*</span></label>
                <input type="text" class="form-control"
                    name="relative_ref_contact" 
                    value="<?= $step3['relative_ref_contact'] ?? ''; ?>">
            </div>

            <div class="col-md-4 mt-2">
                <label>Email<span class="text-red">*</span></label>
                <input type="email" class="form-control"
                    name="relative_ref_email" 
                    value="<?= $step3['relative_ref_email'] ?? ''; ?>">
            </div>

        </div>

    </div>
</div>
<script>
$(function () {

    function toggleRelative() {
        let val = $('input[name="is_iccr_relative_friends"]:checked').val();
        $('#relative_section').toggle(val == '1');
    }

    // On change
    $('input[name="is_iccr_relative_friends"]').on('change', toggleRelative);

    // On page load (edit case)
    toggleRelative();

});
</script>

               <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
    <div class="name-sec col-xs-12 col-sm-6 col-md-12">

        <label>28. Have you travelled or lived in India in the past?</label>

        <?php
        $travel = !empty($applicaitonStepThree)
            ? $applicaitonStepThree[0]['is_travel_or_live_in_india_before']
            : '';
        ?>

        <div class="form-group">
            <label>
                <input type="radio" name="is_travel_or_live_in_india_before" value="1"
                    <?= ($travel == 1) ? 'checked' : ''; ?>> Yes
            </label>

            <label>
                <input type="radio" name="is_travel_or_live_in_india_before" value="2"
                    <?= ($travel == 2) ? 'checked' : ''; ?>> No
            </label>
        </div>

        <!-- Visit Details -->
        <div class="col-12" id="visit-details" style="display:none;">
            <div class="row">
                <div class="col-md-4">
                    <label>Period of Visit<span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="visit_period" 
                        value="<?= !empty($applicaitonStepThree) ? $applicaitonStepThree[0]['visit_period'] ?? '' : ''; ?>">
                </div>

                <div class="col-md-4">
                    <label>Place of Visit<span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="visit_place" 
                        value="<?= !empty($applicaitonStepThree) ? $applicaitonStepThree[0]['visit_place'] ?? '' : ''; ?>">
                </div>

                <div class="col-md-4">
                    <label>Purpose of Visit<span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="visit_purpose" 
                        value="<?= !empty($applicaitonStepThree) ? $applicaitonStepThree[0]['visit_purpose'] ?? '' : ''; ?>">
                </div>
            </div>
        </div>

    </div>
</div>
<script>
$(function () {

    function toggleVisitDetails() {
        let selected = $('input[name="is_travel_or_live_in_india_before"]:checked').val();
        $('#visit-details').toggle(selected == '1');
    }

    // On change
    $('input[name="is_travel_or_live_in_india_before"]').on('change', toggleVisitDetails);

    // On page load
    toggleVisitDetails();

});
</script>
<?php
$step3 = !empty($applicaitonStepThree) ? $applicaitonStepThree[0] : [];

$iccr        = $step3['is_iccr_scholarship_avail_before'] ?? '';
$course      = $step3['iccr_scholar_course'] ?? '';
$current     = $step3['currently_non_nri'] ?? '';
?>	
<div class="addres-sec col-md-12">

    <label>29. Have you ever availed ICCR Scholarship in the past?</label>

    <div class="form-group">
        <label>
            <input type="radio" name="is_iccr_scholarship_avail_before" value="1"
                <?= ($iccr == 1) ? 'checked' : ''; ?>> Yes
        </label>

        <label>
            <input type="radio" name="is_iccr_scholarship_avail_before" value="2"
                <?= ($iccr == 2 || $iccr == '') ? 'checked' : ''; ?>> No
        </label>
    </div>

    <!-- Scholarship Details -->
    <div id="iccr_scholar" style="display:none;">

        <div class="row">

            <div class="col-md-2">
                <label>Year<span class="text-red">*</span></label>
                <input type="text" class="form-control"
                    name="iccr_scholar_year" 
                    value="<?= $step3['iccr_scholar_year'] ?? ''; ?>">
            </div>

            <div class="col-md-3">
                <label>Course<span class="text-red">*</span></label><br>

                <?php
                $courses = [
                    1 => 'UG',
                    2 => 'PG',
                    3 => 'PhD',
                    4 => 'Other'
                ];
                foreach ($courses as $key => $value) {
                ?>
                    <label>
                        <input type="radio" name="iccr_scholar_course" value="<?= $key; ?>" 
                            <?= ($course == $key) ? 'checked' : ''; ?>>
                        <?= $value; ?>
                    </label>
                <?php } ?>
            </div>

            <div class="col-md-3">
                <label>Application Number<span class="text-red">*</span></label>
                <input type="text" class="form-control" 
                    name="old_application_number"
                    value="<?= $step3['old_application_number'] ?? ''; ?>">
            </div>

            <div class="col-md-4">
                <label>Institute / University<span class="text-red">*</span></label>
                <input type="text" class="form-control"
                    name="iccr_scholar_institute" 
                    value="<?= $step3['iccr_scholar_institute'] ?? ''; ?>">
            </div>

            <div class="col-md-6 mt-2">
                <label>Duration<span class="text-red">*</span></label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control"
                            placeholder="From"
                            name="iccr_scholar_duration_from" 
                            value="<?= $step3['iccr_scholar_duration_from'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" 
                            placeholder="To"
                            name="iccr_scholar_duration_to"
                            value="<?= $step3['iccr_scholar_duration_to'] ?? ''; ?>">
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
<div class="addres-sec col-md-12 mt-3">

    <label>30. Are you currently a resident in India?</label>

    <div class="form-group">
        <label>
            <input type="radio" name="currently_non_nri" value="1"
                <?= ($current == 1) ? 'checked' : ''; ?>> Yes
        </label>

        <label>
            <input type="radio" name="currently_non_nri" value="2"
                <?= ($current == 2 || $current == '') ? 'checked' : ''; ?>> No
        </label>
    </div>

    <!-- Address -->
    <div id="indian_address" style="display:none;">
        <label>Postal Address in India<span class="text-red">*</span></label>
        <textarea class="form-control"  name="currently_non_nri_address"><?= $step3['currently_non_nri_address'] ?? ''; ?></textarea>
    </div>

</div>
<script>
$(function () {

    function toggleICCR() {
        let val = $('input[name="is_iccr_scholarship_avail_before"]:checked').val();
        $('#iccr_scholar').toggle(val == '1');
    }

    function toggleAddress() {
        let val = $('input[name="currently_non_nri"]:checked').val();
        $('#indian_address').toggle(val == '1');
    }

    // On change
    $('input[name="is_iccr_scholarship_avail_before"]').on('change', toggleICCR);
    $('input[name="currently_non_nri"]').on('change', toggleAddress);

    // On page load
    toggleICCR();
    toggleAddress();

});
</script>
			   
		<?php
$step3      = !empty($applicaitonStepThree) ? $applicaitonStepThree[0] : [];
$is_married = $step3['is_married'] ?? 2; // Default No
?>
<div class="formrow">
    <div class="col-md-6">

        <label>31. Are you married to an Indian national? <span class="text-red">*</span></label>

        <div class="form-group">
            <label>
                <input type="radio" name="is_married" value="1"
                    <?= ($is_married == 1) ? 'checked' : ''; ?>>
                Yes
            </label>

            <label>
                <input type="radio" name="is_married" value="2"
                    <?= ($is_married == 2) ? 'checked' : ''; ?>>
                No
            </label>
        </div>

        <!-- Spouse Details -->
        <div id="spouse_details" style="display:none;">

            <div class="form-group">
                <label>Spouse Name <span class="text-red">*</span></label>
                <input type="text" class="form-control"
                    name="spouse_name"  value="<?= $step3['spouse_name'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Spouse Passport Number <span class="text-red">*</span></label>
                <input type="text" class="form-control"
                    name="spouse_passport" 
                    value="<?= $step3['spouse_passport'] ?? ''; ?>">
            </div>

        </div>

    </div>
</div>
<script>
$(function () {

    function toggleSpouse() {
        let val = $('input[name="is_married"]:checked').val();
        $('#spouse_details').toggle(val == '1');
    }

    // On change
    $('input[name="is_married"]').on('change', toggleSpouse);

    // On page load (edit case)
    toggleSpouse();

});
</script>	   
			   
               
               <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                  <div class="name-sec col-xs-12 col-sm-3 col-md-5">
                     <label for="comment">32. Do you have an International driving licence?</label>
                     <div class="form-group">
                        <?php
                           if(!empty($applicaitonStepThree) && $applicaitonStepThree[0]['is_international_lic'] > 0)
                           {
                           	if($applicaitonStepThree[0]['is_international_lic'] == 1){
                           		?>
                        <input type="radio" class="is_international_lic" checked="true" value="1" name="is_international_lic" > Yes
                        <input type="radio" class="is_international_lic" value="2" name="is_international_lic" > No
                        <?php
                           }
                           elseif($applicaitonStepThree[0]['is_international_lic'] == 2){
                           	?>
                        <input type="radio" class="is_international_lic" value="1" name="is_international_lic" > Yes
                        <input type="radio"  class="is_international_lic" checked="true" value="2" name="is_international_lic" > No
                        <?php
                           }
                           }
                           else
                           {
                           ?>
                        <input type="radio" class="is_international_lic" value="1" name="is_international_lic" > Yes
                        <input type="radio"  checked="true" class="is_international_lic" value="2" name="is_international_lic" > No
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
                     <label for="comment">Licence Number<span class="text-red">*</span></label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_no" class="form-control capitalLetter"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_no'];?>"/> 					   
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade in">
                     <label for="comment">Issuing Authority<span class="text-red">*</span></label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_auth" class="form-control capitalLetter"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_auth'];?>"/> 
                     </div>
                  </div>
                  <?php
                     }
                     elseif($applicaitonStepThree[0]['is_international_lic'] == 2){
                     	?>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
                     <label for="comment">Licence Number<span class="text-red">*</span></label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_no" class="form-control capitalLetter"  value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_no'];?>"/> 					   
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
                     <label for="comment">Issuing Authority<span class="text-red">*</span></label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_auth"  class="form-control capitalLetter" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['is_international_lic_auth'];?>"/> 
                     </div>
                  </div>
                  <?php
                     }
                     }
                     else
                     {
                     ?>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
                     <label for="comment">Licence Number<span class="text-red">*</span></label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_no" class="form-control " /> 					   
                     </div>
                  </div>
                  <div class="name-sec col-xs-12 col-sm-6 col-md-3 licence_div fade">
                     <label for="comment">Issuing Authority<span class="text-red">*</span></label>
                     <div class="form-group">
                        <input type="text" name="is_international_lic_auth" class="form-control capitalLetter" /> 
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
                  <label>33. Nearest Indian Mission|Consulate in (<?php $countr = $this->common_model->getCountryById($registerData[0]['country_of_domicile']); echo $countr[0]['country_name'];?>)<span class="text-red">*</span></label>
                  <div class="col-xs-2 col-md-4 col-sm-2 pdleft" style="display:none;">
                     <div class="form-group">
                        <select class="selectpicker form-control mission_made_through" id="mission_made_through" name="mission_made_through" required>
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
                     //print_r($applicaitonStepThree);die;                      		
                     			?>
                  <div class="col-xs-2 col-md-6 col-sm-2 pdleft pdright mission_list">
                     <div class="form-group">
                        <select id="application_through" name="application_through" class="selectpicker form-control" required >
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
                 		
               </div>
               <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdleft pdright">
                  <div class="name-sec col-xs-12 col-sm-6 col-md-12">
                     <label for="comment">34. Any Other Information.</label>
                     <div class="form-group">
                        <textarea class="form-control capitalLetter" placeholder="Any Other Information Which You would like to Share With Us." id="any_other_info" name="any_other_info"><?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['any_other_info'];?></textarea>
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
                        <label for="comment" style="float: left;width:20%;">Place: </label> <input style="float: left;width:79%;" type="text" class="form-control" placeholder="Your Current Location" id="place" name="place" value="<?php if(!empty($applicaitonStepThree)) echo $applicaitonStepThree[0]['place'];?>"/>
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
  
  	$(document).on("change", "input[name=is_married], input[name=married]", function () {
        let isMarriedIndian = $("input[name=is_married]:checked").val();
        let marriedStatus = $("input[name=married]:checked").val();

        if (isMarriedIndian == 1) {
            $(".is_indian_married").removeClass("fade");
        } else {
            $(".is_indian_married").addClass("fade");
            $(".spouse_details").addClass("fade");
            return;
        }

        if (marriedStatus == 1) {
            $(".spouse_details").removeClass("fade");
        } else {
            $(".spouse_details").addClass("fade");
        }
    });

  
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
   
  
$(document).ready(function(){

function toggleSection(radioName, sectionId){

    let val = $('input[name="'+radioName+'"]:checked').val();

    if(val == '1'){
        $(sectionId).show();
        $(sectionId).find('input, textarea, select').attr('required', true);
    }else{
        $(sectionId).hide();
        $(sectionId).find('input, textarea, select').removeAttr('required');
    }

}

/* Relatives */
$('input[name="is_iccr_relative_friends"]').change(function(){
    toggleSection('is_iccr_relative_friends','#relative_section');
});

/* Travel */
$('input[name="is_travel_or_live_in_india_before"]').change(function(){
    toggleSection('is_travel_or_live_in_india_before','#visit-details');
});

/* ICCR scholarship */
$('input[name="is_iccr_scholarship_avail_before"]').change(function(){
    toggleSection('is_iccr_scholarship_avail_before','#iccr_scholar');
});

/* Indian resident */
$('input[name="currently_non_nri"]').change(function(){
    toggleSection('currently_non_nri','#indian_address');
});

/* Married */
$('input[name="is_married"]').change(function(){
    toggleSection('is_married','#spouse_details');
});

/* International Licence */
$('input[name="is_international_lic"]').change(function(){

    let val = $('input[name="is_international_lic"]:checked').val();

    if(val == '1'){
        $('.licence_div').fadeIn();
        $('#is_international_lic_no,#is_international_lic_auth').attr('required',true);
    }else{
        $('.licence_div').fadeOut();
        $('#is_international_lic_no,#is_international_lic_auth').removeAttr('required');
    }

});


/* Load state on page load */

toggleSection('is_iccr_relative_friends','#relative_section');
toggleSection('is_travel_or_live_in_india_before','#visit-details');
toggleSection('is_iccr_scholarship_avail_before','#iccr_scholar');
toggleSection('currently_non_nri','#indian_address');
toggleSection('is_married','#spouse_details');

let lic = $('input[name="is_international_lic"]:checked').val();
if(lic == '1'){
    $('.licence_div').show();
}else{
    $('.licence_div').hide();
}

});

</script>
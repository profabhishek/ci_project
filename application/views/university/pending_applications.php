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
marquee{
	
    border: 1px solid #cecece;
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto 5px;
    padding: 7px 5px 0;
    text-align: left;
}
</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">	
	<marquee>Welcome <?php echo $universityData[0]['name']; ?> to ICCR Scholarship Portal</marquee>	
		<div class="blue-heading col-md-12 ">
			 <h3>Pending Application</h3>
			 <form method="post" action="<?php echo base_url();?>mission/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>mission/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		<div class="row">
		<!-----<div class="col-12 col-sm-12 col-md-3 left-menu-sec">
			<div id="sidebar-wrapper">       
	        <ul class="sidebar-nav" id="sidebar">
	          <li><a href="<?php echo site_url(); ?>university/new_applications">Applications Received<span class="pull-right fltright"><?php echo $newCountApplication;?></span></a></li>	           
	          <li><a href="<?php echo site_url(); ?>university/pending_application">Pending Application<span class="pull-right fltright"><?php echo $countpending_application; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/resubmitapplication">Cases of Re-Subuniversity by Applicant<span class="pull-right fltright"><?php echo $countresubmitapplication; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/hold_applications">Applications on Hold<span class="pull-right fltright"><?php echo $countholdapplications; ?></span></a></li>
	          <li><a href="<?php echo site_url(); ?>university/approved_applications">Processed Applications<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
	          <!-----<li><a href="<?php echo site_url(); ?>university/confirmaitonreceivesformhqrs">Confirmation from University/Institute<span class="pull-right fltright"><?php echo $countapprovedApplication; ?></span></a></li>
	           <li><a href="<?php echo site_url(); ?>university/listofacceptance">Acceptance/Decline by Applicant<span class="pull-right fltright"><?php echo $countlistofacceptance; ?></span></a></li>
			    <li><a href="<?php echo site_url(); ?>university/visaendrosment">Student/Research VISA Endorsement<span class="pull-right fltright"><?php echo $countvisaendrosment; ?></span></a></li>
	             <li><a href="<?php echo site_url(); ?>university/travel_applications">Travel Plan of Applicant<span class="pull-right fltright"><?php echo $counttravel; ?></span></a></li>
				 <li><a href="<?php echo site_url();?>university/addStream"><i class="fa fa-book"></i>Create Stream</a></li>
				  <li><a href="<?php echo site_url();?>university/addStreamMapping"><i class="fa fa-book"></i>Create Stream mapping</a></li>
				 <li><a href="<?php echo site_url();?>university/addPages"><i class="fa fa-book"></i> Create Page</a></li>
	        </ul>
      </div>
		</div>---->
		
		<div class="col-12 col-sm-12 col-md-12">
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>				
				<th>Applicant Name</th>
				<th>Email Id</th>
				<th>Country</th>	
				
				<th>Course</th>	
				<th>Universities Opts.</th>	
										
				<th style="width:226px;">Action </th>				
			</thead>
			<tbody>
				<?php 
				$counter=1;
				$user_data = $this->session->userdata('user_data');
				$universityId = $user_data['university'];
				if(count($pending_applications)>0)
				{
					foreach($pending_applications as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>						
						<td><?php echo $app['fullname'];?></td>
						
						<td><?php echo  $app['email'];?></td>
						<td><?php echo $app['country_name'];?></td>							
						<td><?php
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							echo $course[0]['name'].' ('.$app['course_subject'].')';
						}
						else
						{
					$course = $this->common_model->getCoursesById($app['course']);
					$course1 = $this->common_model->getCoursesById($app['course_two']);
					$course2 = $this->common_model->getCoursesById($app['course_three']);
					$course3 = $this->common_model->getCoursesById($app['course_fourth']);
					$course4 = $this->common_model->getCoursesById($app['course_fifth']);
					
					$strm1 = $this->common_model->getStreamById($app['course_option_name']);
					$strm2 = $this->common_model->getStreamById($app['course_option_name_two']);
					$strm3 = $this->common_model->getStreamById($app['course_option_name_three']);
					$strm4 = $this->common_model->getStreamById($app['course_option_name_fourth']);
					$strm5 = $this->common_model->getStreamById($app['course_option_name_fifth']);		
							
								if($universityId == $app['universty_choice']){
					$fullCourse .= $course[0]['title'].' '.$strm1[0]['name'].'<br/>';
					}
					elseif($universityId == $app['universty_choice_two']){
					$fullCourse .= $course1[0]['title'].' '.$strm2[0]['name'].'<br/>';
					}
					elseif($universityId == $app['universty_choice_three']){
					$fullCourse .= $course2[0]['title'].' '.$strm3[0]['name'].'<br/>';
					}
					elseif($universityId == $app['universty_choice_fourth']){
					$fullCourse .= $course3[0]['title'].' '.$strm4[0]['name'].'<br/>';
					}
					elseif($universityId == $app['universty_choice_fifth']){
					$fullCourse .= $course4[0]['title'].' '.$strm5[0]['name'].'<br/>';
					}
							echo $fullCourse;
							
							
							
							
							
						}?></td>
						<td>
							<?php
							if($universityId == $app['universty_choice']){
					$uni1 = $this->common_model->getUniversityById($app['universty_choice']);
				}
				elseif($universityId == $app['universty_choice_two']){
				$uni2 = $this->common_model->getUniversityById($app['universty_choice_two']);
				}
				elseif($universityId == $app['universty_choice_three']){
				$uni3 = $this->common_model->getUniversityById($app['universty_choice_three']);
				}
				elseif($universityId == $app['universty_choice_fourth']){
				$uni4 = $this->common_model->getUniversityById($app['universty_choice_fourth']);
				}
				elseif($universityId == $app['universty_choice_fifth']){
				$uni5 = $this->common_model->getUniversityById($app['universty_choice_fifth']);
				}
				if($universityId == $app['universty_choice']){
				$universityDetails .= ' '.$uni1[0]['name'].'<br/>';		
				}
				if($universityId == $app['universty_choice_two']){
					$universityDetails .= ' '.$uni2[0]['name'].'<br/>';
				}
				if($universityId == $app['universty_choice_three']){
					$universityDetails .= ' '.$uni3[0]['name'].'<br/>';
				}
				if($universityId == $app['universty_choice_fourth']){
					$universityDetails .= ' '.$uni4[0]['name'].'<br/>';	
				}
				if($universityId == $app['universty_choice_fifth']){
					$universityDetails .= ' '.$uni5[0]['name'].'<br/>';
				}
							echo $universityDetails;
							?>
						</td>
								
						<td colspan="2"><a style="float:left;width:104px;margin-right:10px;" href="<?php echo site_url();?>university/viewApplication/<?php echo $app['application_no'];?>/pending" class="form-control sbmt">Process</a>
						<a style="float:left;width:104px;" href="<?php echo site_url(); ?>university/viewfullApplication/<?php echo $app['application_no'];?>" class="form-control sbmt1">View</a></td>						
						</tr>
						<?php	
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
		</div>
		</div>
		<hr/>
	</div>
</section>
	
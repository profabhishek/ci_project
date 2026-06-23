<style type="text/css">
.tab-content{ border: 1px solid #cecece;padding: 10px 20px 20px;}
.form_head{float:none;height:132px;margin:0 auto;text-align:center;}
.form_head img{width:32px;}
.form_head h3{height:33px;margin:0;width:100%;}
.form_head h5{margin:0 auto;}
.caps{text-transform:uppercase;}
.prfl{border:4px double #cecece;height:178px;width:159px;text-align: center;padding:0;}
.prfl img{;margin-bottom:8px;}
.note{font-size: 10px;font-weight:normal;margin-left:15px;}
.note strong{color:red;font-size:11px;font-weight:normal;margin-left:15px;}
.note1{font-size: 13px;font-weight:normal;margin-left:0;}
.undertake{margin-right:5px !important;margin-top:6px !important;float: left;}
#fbl_main tbody tr td:first-child{
	width: 279px !important;
}
optgroup[label]{ color: #4e7a9f;
    font-size: 20px;
    padding-left: 10px;
    padding-top: 10px;
    text-decoration: underline;}
optgroup option{color:#747474; font-size: 14px;}
</style>
<section class="meacontent">	
	<div class="col-xs-10 form_head">		
		<img src="<?php echo site_url();?>assets/site/main/images/indian-embelam.png" alt="Indian Embelam">
		<h3 class="text-center caps">Alumni Details For Scholarship through ICCR</h3>
		<h5 class="text-center">To Be Filled By Regional Office</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;width:68%;">	
	<form method="post" action="<?php echo base_url();?>regional/downloadAluminiApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<div class="tab-content detailpagepdf">		
	  <div id="home" class="tab-pane fade in active">	
	    	 
              <div class="box-body">
              	<div class="col-xs-3 prfl pull-right" >
              		<?php 
              			if($alunamiapplication == "")
              			{
						?>
						<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/images/default_avatar.png"/>
						<?php	
						}
						else
						{
							$userImage = $alunamiapplication[0]['photo'];
						?>
						<img style="width:151px;height:171px;" id="profil_image_div" src="<?php echo site_url();?>assets/site/main/alumni_pic/<?php echo $userImage; ?>"/>
						<?php		
						}
              		?>
              	</div>
              	<div class="name-sec col-xs-12 col-sm-9 col-md-9 pdleft pdright">
					<table id="fbl_main" style="width: 100%;">
						
						<tbody>
						<tr >
								<td style="height:35px;font-weight:bold;"><label>1. Full name (IN BLOCK LETTERS)</label></td>
								<td align="left" style="height:35px;">:&nbsp;&nbsp;
					   <?php if(!empty($alunamiapplication)) echo $alunamiapplication[0]['fullname'];?>	</td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>2. Date of Birth</label></td>
											<td>:&nbsp;&nbsp;<?php if(!empty($alunamiapplication)) echo date("d/m/Y", strtotime($alunamiapplication[0]['date_of_birth']));?>
										
								</td>
								</tr>
							<tr >
								<td style="font-weight:bold;height: 35px;"><label>3. Gender</label></td>
								<td>:&nbsp;&nbsp;<?php $title = '';
						  if(count($alunamiapplication) > 0)
						  {
						  	$title = $alunamiapplication[0]['gender'];
						  }
						  if($title == 1)
						  {
						  	echo 'Male';					  	
						  }
						  elseif($title == 2)
						  {
						  	echo 'Female';							  						  
						  }
					  ?></td>
							</tr>
							
								<tr>
								<td style="height:35px;font-weight: bold;">
								<label>4. Country</label></td>
											<td>:&nbsp;&nbsp;<?php
						  $nationalities = $this->common_model->getCountries();
						  foreach($nationalities as $na)
						  {
						  	if(!empty($alunamiapplication))
						  	{
								if($alunamiapplication[0]['nationality'] == $na['id'])
								{
									echo $na['country_name'];
								}
							}
						  }
						  ?>
								 	</td>
							</tr>
							<tr>
							<td style="height:35px;font-weight: bold;">
							<label>5.Application Made Through</label></td>
							<td>:&nbsp;&nbsp;
							<?php 
							$missions = $this->common_model->getAllMissions();
							?>
							<?php foreach($missions as $mission)
	       						{
	       							if(!empty($alunamiapplication))
							  		{
										if($alunamiapplication[0]['mission_id'] == $mission['id'])
										{
											echo $mission['country_name'].'</b> '.$mission['mission_type'].' '.$mission['mission_name'];
										}										
									}	
	       						} ?>
							</td>
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><label for="comment">6. Passport No</label></td>
								<td style="height:35px;">:&nbsp;&nbsp;<?php if(!empty($alunamiapplication)) echo $alunamiapplication[0]['passport_no'];?></td>
							</tr>
							<tr>
								<td style="height:35px;" colspan="2">
								<table id="tblpassport" class="table" style="width: 100%;">
									<thead>
										<th style="width:150px; ">a) Date of Issue</th>
										<th style="width:150px; ">b) Date of Expiry</th>
										<th style="width:150px; ">c) Place of Issue</th>
									</thead>
									<tbody>
										<tr>
											<td><?php if(!empty($alunamiapplication)) echo $alunamiapplication[0]['passport_issue_date'].'-'.$alunamiapplication[0]['passport_issue_month'].'-'.$alunamiapplication[0]['passport_issue_year']; ?></td>
											<td><?php if(!empty($alunamiapplication)) echo $alunamiapplication[0]['passport_expiry_date'].'-'.$alunamiapplication[0]['passport_expiry_month'].'-'.$alunamiapplication[0]['passport_expiry_year']; ?></td>
											<td><?php if(!empty($alunamiapplication)) echo $alunamiapplication[0]['passport_issue_place'];?></td>
										</tr>
									</tbody>
								</table>
							
								</td>
								
															
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>7. Programme</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								
								$programme = $this->common_model->getAllProgramme();						  		
						  		foreach($programme as $program)
						  		{
									if(!empty($alunamiapplication))
								  	{
								  		if($alunamiapplication[0]['programme'] == $program['id'])
								  		{
											echo $program['name'];
										}										
									}
								}
								 
								?></td>	
								
							</tr>
								
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>8. Course</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								
								if(!empty($alunamiapplication))
								{
									if($alunamiapplication[0]['course'] == -1)
									{
										echo $alunamiapplication[0]['other_course'];
									}
									else
									{
										$crs = $this->common_model->getCoursesById($alunamiapplication[0]['course']);
										
										echo $crs[0]['title'];
									}
								}
								 
								?></td>	
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>9. University</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication))
								{
									if($alunamiapplication[0]['unverisity'] == -1)
									{
										echo $alunamiapplication[0]['other_unverisity'];
									}
									else
									{
										$crs = $this->common_model->getUniversityById($alunamiapplication[0]['unverisity']);
										echo $crs[0]['name'];
									}
								}
								 
								?></td>	
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>10. City</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication))
								{
									if($alunamiapplication[0]['city'] == 7)
									{
										echo $alunamiapplication[0]['other_city'];
									}
									else
									{
										$crs = $this->config->item('grade_cities');
										echo $crs[$alunamiapplication[0]['city']];
									} 
								}
								
								?></td>	
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>11. Year of Admission(Duration of Course)</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication))
								{
									echo $alunamiapplication[0]['duration_of_course_from'].'-'.$alunamiapplication[0]['duration_of_course_to'];
								}
								 
								?></td>
								
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>12. Year of Passing</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication))
								{
									echo $alunamiapplication[0]['year_of_passing'];
								}
								 
								?></td>	
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;"><label for="comment">13. Date of Arrival in India & Departure</label></td>
								
							</tr>
							<tr>
								<td colspan="2">
								<table class="table">
									
									<tbody>
										<td colspan="2">
							
									<thead>
										<th>a) Date of Arrival</th>
										<th>b) Date of Departure</th>
										
									</thead>
									<tbody>
										<tr>
											<td><?php if(!empty($alunamiapplication)) echo $alunamiapplication[0]['date_of_arrival'];?></td>
											<td><?php if(!empty($alunamiapplication)) echo $alunamiapplication[0]['date_of_departure'];?></td>
										</tr>
									</tbody>
								
							
								</td>
									</tbody>
								</table>
							
								</td>
								
															
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>14. Present Details</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication[0]['present_details']))
								{
									echo $alunamiapplication[0]['present_details'];
								}else{
									echo 'NA';
								}
								 
								?></td>	
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>15. Email Id</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication))
								{
									echo $alunamiapplication[0]['email'];
								}
								 
								?></td>	
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>16. Phone</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication))
								{
									echo $alunamiapplication[0]['phone'];
								}
								 
								?></td>	
								
							</tr>
								<tr>
								<td style="height:35px;font-weight: bold;">
								<label>17. Award Recognition</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication[0]['award_recognition']))
								{
									echo $alunamiapplication[0]['award_recognition'];
								}
								else{
									echo "NA";
								}
								 
								?></td>	
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>18. About us</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication[0]['about_us']))
								{
									echo $alunamiapplication[0]['about_us'];
								}
								else{
									echo "NA";
								}
								 
								?></td>	
								
							</tr>
												
						</tbody>
					</table>
              </div>
              <!-- /.box-body -->
	  </div>
	</div>
	</div>
	</div>
</section>
	
	


	
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
		<h5 class="text-center">TO BE FILLED BY Alumni</h5>
	</div>
	
	<div  class="container" style="min-height:410px;padding:0px;width:68%;">	
	<form method="post" action="<?php echo base_url();?>headquarter/downloadAlumniApplication/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
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
								<label>5. Course</label>
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
								<label>6. University</label>
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
								<label>7. City</label>
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
								<label>8. Duration of Course</label>
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
								<label>9. Year of Passing</label>
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
								<td style="height:35px;font-weight: bold;">
								<label>10. Present Details</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication))
								{
									echo $alunamiapplication[0]['present_details'];
								}
								 
								?></td>	
								
							</tr>
							<tr>
								<td style="height:35px;font-weight: bold;">
								<label>11. Email Id</label>
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
								<label>12. Phone</label>
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
								<label>13. Award Recognition</label>
								</td>
								<td>:&nbsp;&nbsp;
								<?php 
								if(!empty($alunamiapplication))
								{
									echo $alunamiapplication[0]['award_recognition'];
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
	
	


	
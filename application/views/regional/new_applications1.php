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
.backbtn
{
	top:9px;
}
.divider{
	margin:0;
}
marquee{
	
    border: 1px solid #cecece;
    color: #f18f2e;
    float: none;
    font-weight: bold;
    height: 35px;
    margin: 0 auto 5px;
    padding: 7px 5px 0 !important;
    text-align: left;
}
.pops
{
	background: white none repeat scroll 0 0;
    border: 2px solid rgba(0, 0, 0, 0.3);
    min-height: 150px;
    padding: 20px;
    text-align: center;
}
</style>
<script type="text/javascript">
	function forwardtouniverstiychoice(id,appno)
	{
		var valu = $('#' + id).val();		
		if(valu != "")
		{
			var cls = $('#' + id + ' option:selected').attr("class");
			location.href = baseURL + "regional/forwardtouniversity/" + appno + "/" + cls;	
		}
		else
		{
			BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error" ,message: "Select Preference.!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]}); 
		}
	}
</script>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:15px;">
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>	
		<div class="blue-heading col-md-12 ">
			 <h3 style="float:left;">Application Received from Mission</h3>
			
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a href="<?php echo site_url();?>regional/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>				
				
				<th>Applicant Name</th>				
				
				<th>Country</th>
				<th>Scheme</th>
				<th>Course</th>
				<th>Universities Opts.</th>				
				
				
				<th>Application Form</th>
				<th>Contact Form </th>
				<th>University Letter Format</th>	
				<th>University <br/>Forwarded <br/>Letter</th>	
				<th>Process</th>
			</thead>
			<tbody>
				<?php 
				$counter=1;				
				if(count($newApplication)>0)
				{
					foreach($newApplication as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>					
						<td><?php echo $app['fullname'];?></td>	
						<td><?php echo $app['country_name'];?></td>	
						<td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
						
						echo $sch[0]['scheme_name'];?></td>					
							<td align="left"><?php
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
							echo $course[0]['title'].' '.$app['course_option_name'].'<br/>';
							echo $course1[0]['title'].' '.$app['course_option_name_two'].'<br/>';
							echo $course2[0]['title'].' '.$app['course_option_name_three'].'<br/>';
							
						}?></td>
					
						<td align="left"><?php 
						$uname ="";$array_uni_id = array();
						echo "1) ";
						if($region == $app['university_choice_one_state']){
							$university = $this->common_model->getUniversityById($app['universty_choice']);		
							$uname = $university[0]['name'];
							array_push($array_uni_id,1);
							echo $uname;
						}
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice']);		
							$uname = $university[0]['name'];
							echo $uname;
						}
						
						
						?>
						<br/>
							<?php 
								echo "2) ";
						$uname ="";					
						if($region == $app['university_choice_two_state']){						
							$university = $this->common_model->getUniversityById($app['universty_choice_two']);
							$uname = $university[0]['name'];
							
							echo $uname;
							array_push($array_uni_id,2);
						}						
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice_two']);	
							$uname = $university[0]['name'];
							echo $uname;
						}
						?><br/>
							<?php 
							echo "3) ";
						$uname ="";
						
						if($region == $app['university_choice_three_state']){							
							$university = $this->common_model->getUniversityById($app['universty_choice_three']);
							$uname = $university[0]['name'];
							array_push($array_uni_id,3);
							echo $uname;
						}
						else
						{
							$university = $this->common_model->getUniversityById($app['universty_choice_three']);
							$uname = $university[0]['name'];
							echo $uname;
						}
					
						?>
						</td>
						
						<td><a target="_blank"  href="<?php echo site_url();?>regional/applicationForm/<?php echo $app['application_no'];?>">Download</a></td>
						<td><a target="_blank" href="<?php echo site_url();?>regional/contactForm/<?php echo $app['application_no'];?>">Download</a></td>
						<td><a  href="<?php echo site_url();?>regional/universityLetter/<?php echo $app['application_no'];?>">Download</a></td>
						<td>						
							<?php
							if(count($array_uni_id)>0)
							{
								foreach($array_uni_id as $optionNo)
								{
									if($optionNo == 1)
									{
										if($app['uni_forwarded_letter'] == "")
										{
											?>
											<a href="#"  onclick="updateId('<?php echo $app['application_no'];?>','<?php echo $app['universty_choice']; ?>');" data-toggle="modal" class="form-control sbmt" data-target="#universtiyLetterdiv">Upload</a>
											
											<?php
										}
										else
										{
											?>
											<a download href="<?php echo site_url();?>assets/site/main/university_Forwarded_letter/<?php echo $app['uni_forwarded_letter'];?>">Download</a><br/>
											<?php
										}
									}
									if($optionNo == 2)
									{
										if($app['uni_forwarded_letter_two'] == "")
										{
											?>
											<a href="#"  onclick="updateId('<?php echo $app['application_no'];?>','<?php echo $app['universty_choice_two']; ?>');" data-toggle="modal" class="form-control sbmt" data-target="#universtiyLetterdiv">Upload</a>
											
											<?php
										}
										else
										{
											?>
											<a download href="<?php echo site_url();?>assets/site/main/university_Forwarded_letter/<?php echo $app['uni_forwarded_letter_two'];?>">Download</a><br/>
											<?php
										}
									}
									if($optionNo == 3)
									{
										if($app['uni_forwarded_letter_three'] == "")
										{
											?>
											<a href="#"  onclick="updateId('<?php echo $app['application_no'];?>','<?php echo $app['universty_choice_three']; ?>');" data-toggle="modal" class="form-control sbmt" data-target="#universtiyLetterdiv">Upload</a>
											
										  
											<?php
										}
										else
										{
											?>
											<a download href="<?php echo site_url();?>assets/site/main/university_Forwarded_letter/<?php echo $app['uni_forwarded_letter_three'];?>">Download</a><br/>
											<?php
										}
									}
									
								}
							}
							
					
							
							 ?>
						</td>
						<td>
						<?php 
												
						if($app['status'] == 4)
						{
							$forwartToUniversity = array();
							
							if(count($array_uni_id)>0 && count($array_uni_id) >= 1)
							{
								//echo "<pre>";print_r($array_uni_id);
								$stscounter = 0; $pend ="";$array_pend = array();
								foreach($array_uni_id as $ststid)
								{
									$colname = "university_status_".$ststid;
									if($app[$colname] == "-1")
									{
										$stscounter++;
										$pend .= $ststid;		
										array_push($forwartToUniversity,$ststid);
									}
								}
								if(count($forwartToUniversity) > 0)
								{
									foreach($forwartToUniversity as $optNo)
									{
										if($optNo == 1)
										{
											if($region == $app['university_choice_one_state']){
												if($app['uni_forwarded_letter'] == "")
												{
												?>
											<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>
										<?php
												}
												else
												{
													?>
											<a class="form-control sbmt" style="height:32px;width:140px;" href="<?php echo site_url();?>regional/forwardtouniversity/<?php echo $app['application_no'].'/'.$optNo;?>">Forward To University</a>
										<?php
												}
											}
										}
										if($optNo == 2)
										{
											if($region == $app['university_choice_two_state']){
												if($app['uni_forwarded_letter_two'] == "")
												{
													?>
											<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>
										<?php
												}
												else
												{
													?>
											<a class="form-control sbmt" style="height:32px;width:140px;" href="<?php echo site_url();?>regional/forwardtouniversity/<?php echo $app['application_no'].'/'.$optNo;?>">Forward To University</a>
										<?php
												}
											}
										}
										if($optNo == 3)
										{
											if($region == $app['university_choice_three_state']){
												if($app['uni_forwarded_letter_three'] == "")
												{
													?>
											<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Upload Letter First"/>
										<?php
												}
												else
												{
													?>
											<a class="form-control sbmt" style="height:32px;width:140px;" href="<?php echo site_url();?>regional/forwardtouniversity/<?php echo $app['application_no'].'/'.$optNo;?>">Forward To University</a>
										<?php
												}
											}
										}
									}
								}
								else
								{
									echo "Forwarded to University";
								}								
							}
							
						}
						
						?>
						</td>
						</tr>
						<?php	
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
		<hr/>
	</div>
	
	 <div id="universtiyLetterdiv" class="modal fade" role="dialog">
	  	<div id="universtiyLetter" class="modal-dialog popup dropzone">
	  			<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
	  		</div>
	  </div>
</section>
	
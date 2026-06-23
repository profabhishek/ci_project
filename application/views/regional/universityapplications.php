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
.alert
{
	margin: 0 auto 1%;    
    width: 85.5%;
}
</style>
<section class="meacontent">
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
	<div  class="container" style="min-height:410px;padding-top:15px;">	
	<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>	
		<div class="blue-heading col-md-12 ">
			 <h3>University Response Sent to Hqrs.</h3>
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
		
		<div class="container">
	<div class="col-md-4 pull-right">
    <div class="input-group input-daterange">

      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

      <div class="input-group-addon">To</div>

      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

    </div>
  </div>
</div>
		
		
		
		<table id="tbl_schrls" class="customTable1 table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>		
				
				<th>Application Id</th>
				<th>Applicant Name</th>
				<th>Email Id</th>
				<th>Country</th>
				<th>Scheme</th>
				<th>Course</th>				
				<th>University <br/>Opts.</th>	
				<th>Process</th>
				<th>Year </th>
				<th>View </th>	
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($newApplication)>0)
				{
					
					foreach($newApplication as $app)
					{						
					
					
						if($app['status'] >= 4)
						{
							$sts = $this->common_model->isAnyUniversityResponseConfirm($app['application_no'],$region);						
							if(count($sts) <= 0)
							{		
																	
								?>
									<tr>
						<td><?php echo $counter;?></td>
						<?php $date1 = '2019-12-01'; 
						$date = date_create($app['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						$studentyreg = strtotime($app['created']);
					
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
						?>
						<td><?php echo $app['application_no'].$new; ?></td>
					    <td><?php echo $app['fullname'];?></td>
						<!--<td><?php echo $app['ref_no'];?></td>-->
						<td><?php echo $app['email'];?></td>
						<td><?php echo $app['country_name'];?></td>	
						<td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
						
						echo $sch[0]['scheme_name'];?></td>	
						<td align="left"><?php
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							echo $course[0]['name'].' '.$app['course_subject'];
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
						<td>
						<?php	
							$sts1 = $this->common_model->isAnyUniversityResponseConfirmToHqrs($app['application_no']);
							if(count($sts1)<=0)
						{
						if(count($array_uni_id)>0)
						{
								foreach($array_uni_id as $optionNo)
								{
									if($optionNo == 1)
									{
										?>							
						<a style="height:34px;width:140px;" class="form-control sbmt" href="<?php echo site_url();?>regional/application/<?php echo $app['application_no'];?>">Confirm to Hqrs</a>
										<?php
									}
									if($optionNo == 2)
									{
										?>							
						<a style="height:34px;width:140px;" class="form-control sbmt" href="<?php echo site_url();?>regional/application/<?php echo $app['application_no'];?>">Confirm to Hqrs</a>
										<?php
									}
									if($optionNo == 3)
									{
										?>							
						<a style="height:34px;width:140px;" class="form-control sbmt" href="<?php echo site_url();?>regional/application/<?php echo $app['application_no'];?>">Confirm to Hqrs</a>
										<?php
									}
								}
							}	
						}
						else
						{
							?>
							<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Confirm to Hqrs"/>
							<?php
							
							
						}
						?>	
						
						</td>	
							<?php $date = date_create($app['created']);
							$array =  (array) $date;
							//print_r($array);
						?>
						<td><?php echo date("Y-m-d", strtotime($array['date']));?></td>	
						<td><?php echo "NA";	?></td>
						</tr>
								
						<?php
							}
							elseif(count($sts) > 0)
							{
								?>
									<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['application_no']; ?></td>
					    <td><?php echo $app['fullname'];?></td>
						<!--<td><?php echo $app['ref_no'];?></td>-->
						<td><?php echo $app['email'];?></td>
						<td><?php echo $app['country_name'];?></td>	
						<td><?php $sch = $this->common_model->getSchemeById($app['scholarship_id']);
						
						echo $sch[0]['scheme_name'];?></td>	
						<td align="left"><?php
						if($app['programme'] == 3 || $app['programme'] == 4 || $app['programme'] == 8)
						{
							$course = $this->common_model->getProgrammeById($app['programme']);
							echo $course[0]['name'].' '.$app['course_subject'];
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
                       				
						<td>
							<?php	
							$isAccept = FALSE;$uiver = array();
							foreach($sts as $st)
							{
								if($st['university_is_accept']==1)
								{
									$isAccept = TRUE;
								}
								$uiver[$st['regional_university']] = $st;
							}	
							
							$sts1 = $this->common_model->isAnyUniversityResponseConfirmToHqrs($app['application_no']);
				
						
							if(count($array_uni_id)>0)
							{
								if(count($sts1)<=0)
						           {
								foreach($array_uni_id as $optionNo)
								{
									
									if($optionNo == 1)
									{
										if(count($sts) > 0)
										{	
											if(array_key_exists($app['universty_choice'],$uiver))	
											{
												if($uiver[$app['universty_choice']]['university_is_accept']==1 || $uiver[$app['universty_choice']]['university_is_accept']==2)
												{
													if($uiver[$app['universty_choice']]['university_is_accept'] == 1)
													{
														echo "(A) for (".$optionNo.") Sent to Hqrs </br>";
													}
													elseif($uiver[$app['universty_choice']]['university_is_accept'] == 2)
													{
														echo "(R) for (".$optionNo.") Sent to Hqrs </br>";	
													}
													
												}
											}		
											else
											{											
												?>
												<a style="height:34px;width:140px;" class="form-control sbmt" href="<?php echo site_url();?>regional/application/<?php echo $app['application_no'];?>">Confirm to Hqrs</a>
												<?php
													
											}											
										}
									}
						}
								}else{
							
							?>
							<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Confirm to Hqrs"/>
							<?php
						}
						
						if(count($array_uni_id)>0)
							{
						if(count($sts1)<=0)
						           {
									   foreach($array_uni_id as $optionNo)
								{
									if($optionNo == 2)
									{
										if($sts > 0)
										{
											if(array_key_exists($app['universty_choice_two'],$uiver))	
											{
												if($uiver[$app['universty_choice_two']]['university_is_accept']==1 || $uiver[$app['universty_choice_two']]['university_is_accept']==2)
												{
													if($uiver[$app['universty_choice_two']]['university_is_accept'] == 1)
													{
														echo "(A) for (".$optionNo.") Sent to Hqrs </br>";
													}
													elseif($uiver[$app['universty_choice_two']]['university_is_accept'] == 2)
													{
														echo "(R) for (".$optionNo.") Sent to Hqrs </br>";	
													}
												}
											}		
											else
											{	
												?>
												<a style="height:34px;width:140px;" class="form-control sbmt" href="<?php echo site_url();?>regional/application/<?php echo $app['application_no'];?>">Confirm to Hqrs</a>
												<?php
												
											}											
										}
										
									}
								}
								   }
							}
								   else
								   {
									
									?>
							<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Confirm to Hqrs"/>
							<?php
									
								   }
								   if(count($array_uni_id)>0)
							{
								   if(count($sts1)<=0)
						           {
									   foreach($array_uni_id as $optionNo)
								{
									if($optionNo == 3)
									{
										if(count($sts)>0)
										{
											if(array_key_exists($app['universty_choice_three'],$uiver))	
											{
												if($uiver[$app['universty_choice_three']]['university_is_accept']==1 || $uiver[$app['universty_choice_three']]['university_is_accept']==2)
												{
													if($uiver[$app['universty_choice_three']]['university_is_accept'] == 1)
													{
														echo "(A) for (".$optionNo.") Sent to Hqrs </br>";
													}
													elseif($uiver[$app['universty_choice_three']]['university_is_accept'] == 2)
													{
														echo "(R) for (".$optionNo.") Sent to Hqrs </br>";	
													}
												}
											}		
											else
											{
												
												?>
												<a style="height:34px;width:140px;" class="form-control sbmt" href="<?php echo site_url();?>regional/application/<?php echo $app['application_no'];?>">Confirm to Hqrs</a>
												<?php
												
											}											
										}
										
									}
								}
								}
							}
								else
								{
									?>
							<input type="submit" style="border-radius:37px;font-size:11px;" class="btn btn-block btn-default sbmt disabled" value="Confirm to Hqrs"/>
							<?php
									
								}
						
							}	
							?>
						</td>	
						<?php $date = date_create($app['created']);
							$array =  (array) $date;
							//print_r($array);
						?>
						<td><?php echo date("Y-m-d", strtotime($array['date']));?></td>	
							
						<td>
							<?php
							if($sts[0]['region_one_status'] == $region)
							{
								?>
								<a style="height:34px;width:140px;" class="form-control sbmt1" href="<?php echo site_url();?>regional/universityResponse/<?php echo $app['application_no'];?>">View</a>
								<?php
							}
							elseif($sts[0]['region_one_status'] != $region)
							{
								echo "NA";	
							}
							?>
						</td>	
						</tr>	
						<?php
							}
						}
							
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
		<hr/>
	</div>
</section>
<script>
$(document).ready(function() {
    $('#customTable1').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value="">--------</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
$(document).ready(function(){
	
$('.input-daterange input').each(function() {
	$(this).datepicker('clearDates');
});

// Set up your table
table = $('.customTable1').DataTable({
  paging: true,
  info: true
});

// Extend dataTables search
$.fn.dataTable.ext.search.push(
  function(settings, data, dataIndex) {
    var min = $('#min-date').val();
    var max = $('#max-date').val();
    var createdAt = data[9] || 0; // Our date column in the table

    if (
      (min == "" || max == "") ||
      (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
    ) {
      return true;
    }
    return false;
  }
);

// Re-draw the table when the a date range filter changes
$('.date-range-filter').change(function() {
  table.draw();
});

$('#my-table_filter').hide();
});
</script>	
	

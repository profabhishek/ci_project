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
	<div  class="container" style="min-height:410px;padding-top:16px;">
			<marquee>Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3>Acceptance/Declined by Applicant</h3>
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
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>	
				<th>Application No</th>
				<th>Applicant Name</th>	
				<th>Email Id</th>	
				<th>Course</th>	
				<th>Scheme</th>							
				<!-------<th>Status </th>------>		
				
				<th>Undertaking</th>
				<th>View </th>
				<th>Status</th>
				<th>Visa Grant Permission</th>
				<th>Offer Letter</th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($listofacceptance)>0)
				{
					foreach($listofacceptancewithconfirmation as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php echo $app['application_no'];?></td>
						<td><?php echo $app['fullname'];?></td>
						<td><?php echo $app['email'];?></td>
						<td><?php $course = $this->common_model->getCoursesById($app['course']);echo $course[0]['title'];?></td>
						<td>
						<?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);
						if(!empty($uni))
						{
							echo $uni[0]['scheme_name'];
						}
						else
						{
							echo 'NA';
						}
						?>
						</td>
										
						<!-------<td>
						<?php							
							if($app['scholar_acceptance'] == 1)
							{
								echo "Accepted";
							}
							elseif($app['scholar_acceptance'] == 2)
							{
								echo "Declined";
							}
							elseif($app['scholar_acceptance'] == -1)
							{
								echo "Pending";
							}
							?>
							
						</td>---->	
					<td>
					<?php 
					if(!empty($app['undertaking_doc']))
					{
						?>
						
						<a download href="<?php echo site_url();?>assets/site/main/undertakings/<?php echo $app['undertaking_doc'];?>">Download
						
						<?php
					}
					else
					{
						echo "Not Uploaded";
					}
					?>
					
					</td>
					<td><a class="form-control sbmt1" style="width:100px;" href="<?php echo site_url();?>mission/viewFullApplications/<?php echo $app['application_no'];?>">View</a></td>
					
					
					<td><a href='javascript:void(0);' style="float:left;width:104px;" onclick ="openStatus('<?php echo $app['application_no'];?>')" class="form-control sbmt1">Status</a></td>
					
					<td><?php						
							if(!empty($app['undertaking_doc']))
					{
								?>
								<a href="javascript:void(0);" style="float:left;width:104px;" onclick ="processApp('<?php echo $app['application_no'];?>')" class="form-control sbmt1">Process</a>
								<?php								
							}	
							
							else
							{
								
								echo "NA";
																
							}
						?>	</td>
					    <td>
                        <?php
						//echo '<pre>';print_r($app);
                        //$response = $this->common_model->getUniversityResponsesForOfferLetter($app['application_no']);
					    //echo '<pre>';print_r($response);die;
                        if ($app['visa_grant_permission'] == 1){
                         ?>
                        <a target="_blank" href="<?php echo site_url(); ?>mission/offerReceivedWithFormat/<?php echo $app['application_no']; ?>/<?php echo $app['regional_university']; ?>" target="_blank">Download</a>
					<?php
						}
						else
						{
							echo "NA";
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
</section>

<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
     
						</div>
	<div class="modal-footer">
	<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
	<!-----<button type="button" class="btn btn-primary submitBtn">SUBMIT</button>--->
           
	
	</div>
                    </div>
                  
                </div>
            </div>
<script type='text/javascript'>
	function processApp(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('mission/processApplication')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}

function openStatus(appid){
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('mission/openUniversityStatus')?>',
                        type: 'post',
						data:{'id':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}
</script>
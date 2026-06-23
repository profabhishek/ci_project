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
	top:-32px;
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
		<marquee style="margin-bottom:5px;padding-top:0;">
			Welcome to <?php echo $regionName[0]['name'];?> (Regional Office) to ICCR Scholarship Portal 
		</marquee>
			<div class="blue-heading col-md-12 ">
			 <h3> Travel Plan Details of Applicant</h3>
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a class="form-control lnk" style="width:129px;"   href="#" onclick = "addTravelDetails();">Add Travel Details</a>
	<a href="<?php echo site_url();?>regional/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				
				<th>Applicant Name</th>
				
				<th>Email Id</th>
				<th>Course</th>
				<th>Scheme</th>
				<th>University</th>
				<th>Country</th>	
				<th>Arrival Date By Mission</th>
				<th>Travel Plan By Mission/Ro</th>				
				<th>Status</th>	
				<th>View History</th>								
			</thead>
			<tbody>
				<?php 
				$counter=1;
				$arrat = array();
				if(count($travel)>0)
				{
					foreach($travel as $app)
					{
						if(!in_array($app['application_id'],$arrat))
						{
							array_push($arrat,$app['application_id']);
							?>
							<tr>
						<td><?php echo $counter;?></td>
						
						<td><?php 
						
						$date1 = '2021-03-15';
						$date = date_create($app['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						$studentyreg = strtotime($app['created']);
						$arrat = array();
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
						
						echo $app['fullname'].' '.$app['middlename'].'  '.$app['familyname'].$new;?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php 
						$data = $this->common_model->getConfirmationofApplicationIds($app['application_id']);
						echo $data[0]->confirmed_course;
						//$course = $this->common_model->getCoursesById($app['course']);echo $course[0]['title'];?></td>
						<td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);echo $uni[0]['scheme_name'];?></td>
						<td><?php
						
						$data = $this->common_model->getConfirmationofApplicationIds($app['application_id']);
						
						
						 $uni = $this->common_model->getUniversityById($data[0]->regional_university);echo $uni[0]['name'];?></td>		
						<td><?php echo $app['country_name'];?></td>	
						<!---<td><?php
						
						$travelpl = $this->common_model->getTravelPlan($app['application_id']);
						echo $travelpl[0]['travel_arrival_date'];
						?></td>---->	
						<td><?php
						
						$travelpl = $this->common_model->getTravelPlan($app['application_id']);
						
						
						if($app['undertaking_status_by_region'] != ''){
							echo $travelpl[0]['travel_arrival_date'].'(RO)';
						}
						else
						{
							echo $travelpl[0]['travel_arrival_date'];
						}
						
						?></td>	
						<td><?php
						
						$travelpl = $this->common_model->getTravelPlan($app['application_id']);
						
						?>
						<a download href='<?php echo site_url();?>assets/site/main/travelplan/<?php echo $travelpl[0]['travel_plan_doc'];?>'>Download</a>	
						</td>							
						<td>	
							<?php
							
							if($app['status'] == 13)
							{
							?>
							<a class="form-control sbmt" style="height:30px;width:90px;margin-bottom: 8px;" href='<?php echo site_url();?>regional/scholarArrivedstatus/<?php echo $app['application_id'];?>/<?php echo $travelpl[0]['id'];?>'>Process</a>
							
							<?php	
							}
							elseif($app['status'] >= 14)
							{
								echo "Arrived";
							}
							elseif($app['status'] == -14)
							{
								echo "Not Arrived";
							}
							?>					 
							
						</td>
						<td>
							<?php
							
							if($app['status'] == 13)
							{
								echo "NA";
							}
							elseif($app['status'] >= 14)
							{
								?>
							<a class="form-control sbmt1" style="height:30px;width:90px;margin-bottom: 8px;" href='<?php echo site_url();?>regional/scholarArrivedstatusView/<?php echo $app['application_id'];?>'>View </a>
							
							<?php
							}
							elseif($app['status'] == -14)
							{
								?>
							<a class="form-control sbmt1" style="height:30px;width:90px;margin-bottom: 8px;" href='<?php echo site_url();?>regional/scholarArrivedstatusView/<?php echo $app['application_id'];?>'>View</a>
							
							<?php
							}
							?>
						</td>
						</tr>
							<?php
						}
						?>
						
						<?php	
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
		<hr/>
			  <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">STUDENT TRAVEL DETAILS</h4>
                        </div>
                        <div class="modal-body">
     
							</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-primary submitBtn" onclick="submitTravelForm()">SUBMIT</button>
	<a href="#" class="btn" data-dismiss="modal">Close</a>
	</div>
                    </div>
                  
                </div>
            </div>
	</div>
	
	
	
	
	<div  class="container" style="min-height:410px;padding-top:16px;">
		
			<div class="blue-heading col-md-12 ">
			 <h3> Travel Plan Details of Applicant(2021-2022)</h3>
			 <form method="post" action="<?php echo base_url();?>regional/downloadList/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
">
		  <input id="approvedappId" name="approvedappId" value="<?php echo $this->uri->segment(3); ?>" type="hidden"/>
		<input class="pull-right export-btn" style="margin-right:11px;margin-top:-6px;" type="submit" value=""/>	
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">			
	</form>
	<a class="form-control lnk" style="width:129px;"   href="#" onclick = "addTravelDetails();">Add Travel Details</a>
	<a href="<?php echo site_url();?>regional/dashboard" class="backbtn">
          <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
        </a>
		</div>
		<table id="tbl_schrls" class="customTable table table-striped table-bordered detailpagepdf">
			<thead>
				<th>S.No.</th>
				
				<th>Applicant Name</th>
				
				<th>Email Id</th>
				<th>Course</th>
				<th>Scheme</th>
				<th>University</th>
				<th>Country</th>	
				<th>Arrival Date By Mission</th>
				<th>Travel Plan By Mission/Ro</th>				
				<th>Status</th>	
				<th>View History</th>								
			</thead>
			<tbody>
				<?php 
				$counter=1;
				$arrat = array();
				if(count($travelPlan)>0)
				{
					foreach($travelPlan as $app)
					{
						if(!in_array($app['application_id'],$arrat))
						{
							array_push($arrat,$app['application_id']);
							?>
							<tr>
						<td><?php echo $counter;?></td>
						
						<td><?php 
						
						$date1 = '2021-03-15';
						$date = date_create($app['created']);
						$array =  (array) $date;
						$date2 = date("Y-m-d", strtotime($array['date']));
						$studentyreg = strtotime($app['created']);
						$arrat = array();
						//if($r['status'] = 4) {
							if ($date2 >= $date1) {
							$new='<img src="'.site_url().'assets/site/main/images/newnotification.gif.png" alt="new gif Image">';
							}
							else{
								$new = '';
							}
						
						echo $app['fullname'].' '.$app['middlename'].'  '.$app['familyname'].$new;?></td>						
						<td><?php echo $app['email'];?></td>
						<td><?php 
						$data = $this->common_model->getConfirmationofApplicationIds($app['application_id']);
						echo $data[0]->confirmed_course;
						//$course = $this->common_model->getCoursesById($app['course']);echo $course[0]['title'];?></td>
						<td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);echo $uni[0]['scheme_name'];?></td>
						<td><?php
						
						$data = $this->common_model->getConfirmationofApplicationIds($app['application_id']);
						
						
						 $uni = $this->common_model->getUniversityById($data[0]->regional_university);echo $uni[0]['name'];?></td>		
						<td><?php echo $app['country_name'];?></td>	
						<!---<td><?php
						
						$travelpl = $this->common_model->getTravelPlan($app['application_id']);
						echo $travelpl[0]['travel_arrival_date'];
						?></td>---->	
						<td><?php
						
						$travelpl = $this->common_model->getTravelPlan($app['application_id']);
						
						
						if($app['undertaking_status_by_region'] != ''){
							echo $travelpl[0]['travel_arrival_date'].'(RO)';
						}
						else
						{
							echo $travelpl[0]['travel_arrival_date'];
						}
						
						?></td>	
						<td><?php
						
						$travelpl = $this->common_model->getTravelPlan($app['application_id']);
						
						?>
						<a download href='<?php echo site_url();?>assets/site/main/travelplan/<?php echo $travelpl[0]['travel_plan_doc'];?>'>Download</a>	
						</td>							
						<td>	
							<?php
							
							if($app['status'] == 13)
							{
							?>
							<a class="form-control sbmt" style="height:30px;width:90px;margin-bottom: 8px;" href='<?php echo site_url();?>regional/scholarArrivedstatus/<?php echo $app['application_id'];?>/<?php echo $travelpl[0]['id'];?>'>Process</a>
							
							<?php	
							}
							elseif($app['status'] >= 14)
							{
								echo "Arrived";
							}
							elseif($app['status'] == -14)
							{
								echo "Not Arrived";
							}
							?>					 
							
						</td>
						<td>
							<?php
							
							if($app['status'] == 13)
							{
								echo "NA";
							}
							elseif($app['status'] >= 14)
							{
								?>
							<a class="form-control sbmt1" style="height:30px;width:90px;margin-bottom: 8px;" href='<?php echo site_url();?>regional/scholarArrivedstatusView/<?php echo $app['application_id'];?>'>View </a>
							
							<?php
							}
							elseif($app['status'] == -14)
							{
								?>
							<a class="form-control sbmt1" style="height:30px;width:90px;margin-bottom: 8px;" href='<?php echo site_url();?>regional/scholarArrivedstatusView/<?php echo $app['application_id'];?>'>View</a>
							
							<?php
							}
							?>
						</td>
						</tr>
							<?php
						}
						?>
						
						<?php	
						$counter++;	
					}
				}
				?>
			</tbody>
		</table>
		<hr/>
			  <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">STUDENT TRAVEL DETAILS</h4>
                        </div>
                        <div class="modal-body">
     
							</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-primary submitBtn" onclick="submitTravelForm()">SUBMIT</button>
	<a href="#" class="btn" data-dismiss="modal">Close</a>
	</div>
                    </div>
                  
                </div>
            </div>
	</div>
</section>
	<script type='text/javascript'>
	//Edit Expend
function addTravelDetails(appid){
	// AJAX request
                    $.ajax({
                        url: '<?php echo site_url('regional/getTravelStudents')?>',
                        type: 'post',
                        success: function(response){ 
                            $('.modal-body').html(response); 
                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}

function submitTravelForm1(){
	var app_no = $('#app_no').val();
	alert(app_no);
	
var urls = ["<?php echo site_url('regional/isCheckDetails')?>", "<?php echo site_url('regional/isUnderTaking')?>","<?php echo site_url('regional/isAlreadytTravelPlan')?>"];
$.each(urls, function(index, value) {
    $.ajax({
        global: false,
        type: 'POST',
        url: value,
        dataType: 'json',
        data:'contactFrmSubmit=1&app_no='+app_no,
        success: function(response) {
            switch(value) {
                case "<?php echo site_url('regional/isCheckDetails')?>":
				alert(JSON.stringify(response));
				if(response.status == true){
				location.href = "<?php echo site_url('regional/createTravelplan/')?>"+app_no;
				} 
				else
				{
				 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Sorry Details Not Found..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				 //location.href = "<?php echo site_url('regional/scholararrival')?>";
				}
                    break;
                case "<?php echo site_url('regional/isUnderTaking')?>":
				if(response.status == true){
				location.href = "<?php echo site_url('regional/createTravelplan/')?>"+app_no;
				} 
				else
				{
				 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Sorry Undertaking Not Found..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				 //location.href = "<?php echo site_url('regional/scholararrival')?>";
				}
                    break;
					case "<?php echo site_url('regional/isAlreadytTravelPlan')?>":
				if(response.status == true){
				location.href = "<?php echo site_url('regional/createTravelplan/')?>"+app_no;
				} 
				else
				{
				 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Sorry travel plan already uploaded..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				 //location.href = "<?php echo site_url('regional/scholararrival')?>";
				}
				 break;
            }
        },
        error: function (e, request, status, error) {
            if (e.status == 500) {
                alert("500 error");
            }
        }
    });
});
}
function submitTravelForm(){
	var app_no = $('#app_no').val();
	     $.ajax({
            type:'POST',
			//url: '<?php echo site_url('regional/isCheckDetails')?>',
            url: '<?php echo site_url('regional/isAlreadytTravelPlan')?>',
            data:'contactFrmSubmit=1&app_no='+app_no,
			dataType: "json",
            success:function(response){
				//alert(JSON.stringify(response.status));
				if(response.status == false){
				location.href = "<?php echo site_url('regional/createTravelplan/')?>"+app_no;
				} 
				else
				{
				 BootstrapDialog.show({type: BootstrapDialog.TYPE_DANGER ,title: "Error Message" ,message: "Sorry Travel Plan Already uploaded..!" ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close();}}]});
				 //location.href = "<?php echo site_url('regional/scholararrival')?>";
				}
			}
			
        });
}
</script>
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
			 <h3>Issue Documents</h3>
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
				<th>Email Id</th>
				<th>Course</th>
				<th>Scheme</th>
				<th>University</th>				
				<th>Country</th>						
				<th>Bonafide Certificate</th>
				<th>Residential Permit</th>
				<th>Joining Report</th>			
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($travel)>0)
				{
					foreach($travel as $app)
					{
						?>
						<tr>
						<td><?php echo $counter;?></td>
						
						
						
						<td><?php echo $app['fullname'];?></td>
						<td><?php echo $app['email'];?></td>
						<td><?php $course = $this->common_model->getCoursesById($app['course']);echo $course[0]['title'];?></td>
						<td><?php $uni = $this->common_model->getSchemeById($app['scholarship_id']);echo $uni[0]['scheme_name'];?></td>
						<td><?php $data = $this->common_model->getConfirmationofApplicationIds($app['application_no']);
						 $uni = $this->common_model->getUniversityById($data[0]->regional_university);echo $uni[0]['name'];?></td>	
						 				<td><?php echo $app['country_name'];?></td>
						
						<!---<td>
						<?php 
						if($app['bonafide_doc'] != "")
						{
							?>
							<a  href="<?php echo site_url();?>assets/site/main/bonafide_doc/<?php echo $app['bonafide_doc'];?>">Download</a>
							<?php
						}
						else
						{
							?>
						<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/uploadbonafide/<?php echo $app['application_no'];?>">Upload</a>
						<?php
						}
						?>
						
						 
						</td>--->
						<td>
						<?php 
						//$bonafideCount = count($app['bonafide_doc']);
						//foreach($app['bonafide_doc'] as $bn) {
							//echo "<pre>";
							//print_r($app['bonafide_doc']);
						$bonafide = $this->common_model->getRegionalBonafideDoc($app['application_no']);
						//echo "<pre>";
						//print_r($bonafide);
						foreach($bonafide as $bn) {
						if($bn['bonafide_doc'] != "")
						{
							?>
							<!-----<a  href="<?php echo site_url();?>assets/site/main/bonafide_doc/<?php echo $bn['bonafide_doc'];?>"target = "__blank">Download</a></br></br>--->
							
							<a  href="<?php echo site_url();?>assets/site/main/bonafide_doc/<?php echo $bn['bonafide_doc'];?>"target = "__blank">Download   <a  href="JavaScript:void(0);" onclick ="editOpenbonafideDetails(<?php echo $bn['id'];?>)" class="btn btn-primary submitBtn">&nbsp;Edit</a></a></br></br>
							
							<?php
						}
						}
						
						if($app['bonafide_doc'] != ""){
							?>
							<a  href="<?php echo site_url();?>assets/site/main/bonafide_doc/<?php echo $app['bonafide_doc'];?>"target = "__blank">Download</a></br></br>
							<?php
						}
						
							?>
						<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/uploadbonafide/<?php echo base64_encode($app['application_no']);?>">Upload</a>
						<?php
						
						
						?>
						
						 
						</td>
						<td>
						
						<?php
							$rp = $this->common_model->getRegionalRpDoc($app['application_no']);
							//echo "<pre>";
							//print_r($rp);
						foreach($rp as $r) {
						if($r['police_doc'] != "")
						{
							?>
							<!-----<a  href="<?php echo site_url();?>assets/site/main/bonafide_doc/<?php echo $bn['bonafide_doc'];?>"target = "__blank">Download</a></br></br>--->
							
							<!-----<a  href="<?php echo site_url();?>assets/site/main/bonafide_doc/<?php echo $r['police_doc'];?>"target = "__blank">Download   <a  href="JavaScript:void(0);" onclick ="editOpenbonafideDetails(<?php echo $r['id'];?>)" class="btn btn-primary submitBtn">&nbsp;</a></a></br></br>-->
							
							<a  href="<?php echo site_url();?>assets/site/main/police_doc/<?php echo $r['police_doc'];?>"target = "__blank">Download</a></br></br>
							
							<?php
						}
						}
						
						
					
						if($app['police_doc'] != "")
						{
							?>
							<a  href="<?php echo site_url();?>assets/site/main/police_doc/<?php echo $app['police_doc'];?>" target = "__blank">Download</a>
							<?php
						}
						else
						{
							?>
						<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/uploadresidentialpermit/<?php echo base64_encode($app['application_no']);?>">Upload</a>
						<?php
						}
						?></td>
						
						
						
						
						
						
						
						
							<td><?php 
						if($app['joining_doc'] != "")
						{
							?>
							<a  href="<?php echo site_url();?>assets/site/main/joining_doc/<?php echo $app['joining_doc'];?>" target = "__blank">Download</a>
							<?php
						}
						else
						{
							?>
						<a class="form-control sbmt" style="height:35px;width:140px;" href="<?php echo site_url();?>regional/uploadjoiningreport/<?php echo base64_encode($app['application_no']);?>">Upload</a>
						<?php
						}
						?></td>
						
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
	<!-- Modal -->
            <div class="modal fade" id="modalForm" role="dialog">
                <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">BONAFIDE DETAILS OF STUDENT</h4>
                        </div>
                        <div class="modal-body">
     
						</div>
	<div class="modal-footer">
	<!----<button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>--->
	<!---<input type="submit" class="btn btn-primary submitBtn" value = "submit">---->
           
	<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
	</div>
                    </div>
                  
                </div>
            </div>
</section>
	<script type='text/javascript'>
	function editOpenbonafideDetails(appid){
		//alert('ok');
	// AJAX request
				//var appid = $('#expe').val();
					//alert(appid);
                    $.ajax({
                        url: '<?php echo site_url('regional/editBonafideDetails')?>',
                        type: 'post',
						data:{'appno':appid},
	                    //dataType:'json',
                        success: function(response){ 
						//alert(JSON.stringify(response));
                            // Add response in Modal body
							//alert(JSON.stringify(response));
                            $('.modal-body').html(response); 

                            // Display Modals
                            $('#modalForm').modal('show'); 
                        }
    
	});
}


function submitContactForm(){
	//alert('ok');
	var acdemicyear = $('#acdemic_year').val();
	//alert(acdemicyear);
    var files = $('#files')[0].files;
    //alert(files);
    var appno = $('#app_id').val();
	//alert(appno);
	
	var error = '';
  var form_data = new FormData();
  
  for(var count = 0; count<files.length; count++)
  {
   var name = files[count].name;
   var extension = name.split('.').pop().toLowerCase();
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    error += "Invalid " + count + " Image File"
   }
   else
   {
    form_data.append("files[]", files[count]);
	//alert(JSON.stringify(form_data));
   }
  }
  form_data.append("appid", appno);
  form_data.append("acdemic_year", acdemicyear);
  //alert(JSON.stringify(form_data));
  if(error == '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>regional/upload",
    method:"POST",
    data:form_data,
    contentType:false,
    cache:false,
    processData:false,
    beforeSend:function()
    {
     $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
    },
    success:function(data)
    {
		//alert(data);
		// if(data){
			//window.location.href = "<?php echo base_url(); ?>regional/issueDocuments";
		//} 
     //$('#uploaded_images').html(data);
     //$('#files').val('');
    }
   })
  }
  else
  {
   alert(error);
  }
	
}
</script>
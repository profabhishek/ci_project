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
.undertake{margin-right:5px !important;margin-top:4px !important;float: left;}
.upload_link{border-right: 1px solid #cecece;margin-right: 8px;padding-right: 12px;}
.alert
{	
	margin: 12px auto 8px;    
    width: 85.5%;
}
</style>
<section class="meacontent">
	<div  class="container" style="min-height:410px;padding-top:16px;">
		<marquee>Welcome <?php echo $misionData[0]['mission_type'].' : '.$misionData[0]['mission_name']; ?> to ICCR Scholarship Portal</marquee>
		<div class="blue-heading col-md-12 ">
			 <h3>Alumini Details</h3>
			 <form method="post" action="<?php echo base_url();?>mission/downloadFile/<?php echo $this->uri->segment(3); ?>" enctype="multipart/form-data" id="frm_details_ngo" name="frm_details_ngo" style="width: 100%;position: relative;top: -43px;
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
				<th>Country</th>
				
				<th>Downlaod</th>
				<th>Uplod</th>
			</thead>
			<tbody>
				<?php 
				$counter=1;
				if(count($alumindetails)>0)
				{
					foreach($alumindetails as $app)
					{
						//echo "<pre>";print_r($app);
						?>
						<tr>
						<td><?php echo $counter;?></td>
						<td><?php 
						$country = $this->common_model->getCountryById($app['country']);
						echo $country[0]['country_name'];
						
						?>
						
						</td>
											
						
						<td>
				
						<a style="float:left;width:104px;" href="<?php echo site_url(); ?>mission/downloadFile"  class="form-control sbmt1">Downlaod</a>
						
						</td>
						<td>
						<form>
    <p><input type="file" name="file" class="file" required></p>
    <input type="submit" name="submit" class="submit" value="Submit">
</form>
						<!----<a href="javascript:void(0);"  data-toggle="modal" class="upload_link" data-target="#aluminiDiv">Upload</a></td>--->
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

</div>

</section>
<div id="aluminiDiv" class="modal fade" role="dialog">
  	<div id="alumini" class="modal-dialog popup dropzone">
  		<div class="dz-message" data-dz-message><span>Click/Drop Image/PDF file Here</span></div>
  	</div>
</div>
	<script src="<?php echo base_url();?>assets/site/main/js/bootbox/bootbox.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.submit').on('click', function() {
            var file_data = $('.file').prop('files')[0];
            if(file_data != undefined) {
                var form_data = new FormData();                  
                form_data.append('file', file_data);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('mission/uploadAluminiDocs');?>',
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success:function(response) {
                        if(response == 'success') {
                            alert('File uploaded successfully.');
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
  
                        $('.file').val('');
                    }
                });
            }
            return false;
        });
    });
</script>
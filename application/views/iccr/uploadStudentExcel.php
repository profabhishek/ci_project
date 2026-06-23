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

    <?php if (!empty($this->session->flashdata('mess'))) { ?>
    <script>
        var message = "<?php echo $this->session->flashdata('mess'); ?>";
        swal({
            title: '',
            text: message,
            type: "warning",
        }).then(
                function () {},
                // handling the promise rejection
                        function (dismiss) {
                            if (dismiss === 'timer') {
                                console.log('Thank You.!')
                            }
                        }
                )
    </script> 
<?php } ?>       
<script type="text/javascript">
 	function deleteFeedback(id)
 	{
		$.ajax({
			url:baseURL + "headquarter/deleteFeedback",
			data:{'feedBackId':id},
			
			type:"GET",
			success:function(jsonData){
				if(jsonData.status == true)	
				{
					BootstrapDialog.show({type: BootstrapDialog.TYPE_SUCCESS ,title: "Success" ,message: "Delete Successfully!"  ,buttons: [{label: 'OK',action: function(dialogItself) {dialogItself.close(); location.href = baseURL + "admin/allschemes";}}]});
				}
			},
			error:function()
			{
				
			}
		});
	}
 </script>
<section class="meacontent">

    <div  class="container" style="min-height:410px;padding-top:15px;">	
        <marquee style="margin-bottom:5px;padding-top:0;">
            Welcome <?php
            $user_data = $this->session->userdata('user_data');
            echo $user_data['fname'];
            ?> to ICCR Scholarship Portal 
        </marquee>
        <div class="blue-heading col-md-12 ">
            <h3>Upload Excel</h3>
            <?php $title = "Feed Back List"; ?>
            <a href="<?php echo site_url(); ?>headquarter/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
        <div class="box-body">
                        <div id="msg"></div>
                        <form name="text" method="POST" enctype="multipart/form-data" action="<?php echo site_url(); ?>headquarter/upload_excel_file">
						 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
                        
                            <label class="form-label span3" for="file">File</label>
                            <input type="file" name="ngoexcel" id="ngoexcel" required/>
                            <br><br>
                            <input type="submit" name="btn_submit" class="btn btn-success" value="Submit"/>
                        </form>
       </div>
		<hr/>
    </div>
</section>

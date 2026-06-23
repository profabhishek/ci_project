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
<script>
    $(document).ready(function () {
        $('#example').dataTable({
            destroy: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });

</script>
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
            <h3>Feed Back List</h3>
            <?php $title = "Feed Back List"; ?>
            <a href="<?php echo site_url(); ?>headquarter/dashboard" class="backbtn">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
        <table  id="example" class="customTable table table-striped table-bordered detailpagepdf">
            <thead>
            <th>S.No.</th>
			<th>Name</th>
			<th>Email Id</th>
			<th>Phone No</th>
			<th>Comment</th>
			<!--<th>Action</th>-->  
            </thead>
            <tbody>
               <?php	       		 
	       		$counter = 1;
	       		foreach($feedback as $feedbacks)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $feedbacks['name'];?></td>
					<td><?php echo $feedbacks['emailid'];?></td>
					<td><?php echo $feedbacks['mobile_no'];?></td>
					<td><?php echo $feedbacks['comment'];?></td>									
					 <!--<td>
				<a href="javascript:void(0);"onclick="deleteFeedback('<?php echo $feedbacks["id"];?>');" class="icon_link delete" style="padding-left:15px"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
								</td>-->
				</tr>
				<?php	
				$counter++;
				}
	       		?>
            </tbody>
        </table>
        <hr/>
    </div>
</section>

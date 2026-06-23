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
			
            "destroy": true,
            "searching": false,
            
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });

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
            <h3>Search Result List</h3>
            <?php $title = "Search Result List"; ?>
            
        </div>
        <table  id="example" class="customTable table table-striped table-bordered">
            <thead>
            <th>S.No.</th>
			<th>Page Title</th>
			<th>Page Description</th>
			<th>Action</th>
			
			
            </thead>
            <tbody>
               <?php	       		 
	       		$counter = 1;
	       		foreach($pages as $page)
	       		{
				?>
				<tr>
					<td><?php echo $counter;?></td>
					<td><?php echo $page['page_title'];?></td>
					<td><?php echo word_limiter(strip_tags($page['page_description'],50));?></td>
					<td><a href="<?php echo site_url(); ?>home/page/<?php echo $page['page_slug']?>" class="icon_link delete" >view more</a></td>
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

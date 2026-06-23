<div class="clearfix"> </div>
		<footer>
			<section class="footerarea">
				<div class="container">
				
					<ul class="flink text-center">
						<?php $data['footerpage'] = $this->common_model->getFrontPage(0);
						if(!empty($data['footerpage'])){
						foreach($data['footerpage'] as $page){?>
							<li><a href="<?php echo site_url();?>home/page/<?php echo $page['page_slug']?>"><?php echo $page['page_title'] ?></a></li>
							<?php } ?>
						<?php } ?>
						<!--<li><a href="<?php echo site_url();?>home/termsandconditions">Terms &amp; Conditions</a></li>
						<li><a href="<?php echo site_url();?>home/privacy">Privacy Policy</a></li>
						<li><a href="<?php echo site_url();?>home/copyright">Copyright Policy</a></li>
						<li><a href="<?php echo site_url();?>home/hyperlink">Hyperlinking Policy</a></li>
						<li><a href="<?php echo site_url();?>home/disclaimer">Disclaimer</a></li>
						<li><a href="<?php echo site_url();?>home/help">Help</a></li>-->
						<li><a href="<?php echo site_url();?>home/feedback">Feedback</a></li>
					</ul>
					<!-- <?php //$last_modified_date = $this->session->userdata('last_modified_on');?>
					<?php //if(!empty($last_modified_date)){?> -->
					<div class="copyright text-center">
					Last Updated On: 25-02-2025
					<!-- <?php //echo date('d-m-Y',strtotime($last_modified_date));?> -->
					<!-- <div class="visitor-counts">Visitors : 423526</div> -->
					</div>
					
					<!--<?php //} ?>-->
					<div class="copyright text-center">&copy; Content Owned by Indian Council for Cultural Relations, Government of India. All Rights Reserved.</div>
					<br/>
					<?php
$Count = $this->db->query('select * from ci_sessions')->num_rows();


					?>
					<!-- <div class="visitor text-center">
						<div>Total Number of Visitors: </div>&nbsp;&nbsp;
						
						<?php //echo $Count; ?>
					</div> -->
				</div>
			</section>
		</footer>
	</div>
</div>
<!-- Upload Divs -->
 <div id="profileUploadsPic" class="modal fade" role="dialog">
  	<div id="profilePic" class="modal-dialog popup dropzone">
  			<div class="dz-message" data-dz-message><span>Click/Drop Image file Here</span></div>
  		</div>
  </div>
 <script type="text/javascript">
     $(document).ready(function() {
      $('#incfont').click(function(){
   		curSize = parseInt($('body').css('font-size')) + 1;
          if(curSize<=20)
   			$('body').css('font-size', curSize);
    	}); 
		$('#decfont').click(function(){
       	 curSize= parseInt($('body').css('font-size')) - 1;
            if(curSize>=10)
       	 $('body').css('font-size', curSize);
        });
       $('#norfont').click(function(){
        curSize1= parseInt($('body').css('font-size', ''))  ;
        $('body').css('font-size', curSize1);
        });
    });
</script>


</body>
</html>
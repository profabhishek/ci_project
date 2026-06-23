<div class="clearfix"> </div>
		<footer>
			<section class="footerarea">
				<div class="container">
				
					<ul class="flink text-center">
						<li><a href="<?php echo site_url();?>home/termsandconditions">Terms &amp; Conditions</a></li>
						<li><a href="<?php echo site_url();?>home/privacy">Privacy Policy</a></li>
						<li><a href="<?php echo site_url();?>home/copyright">Copyright Policy</a></li>
						<li><a href="<?php echo site_url();?>home/hyperlink">Hyperlinking Policy</a></li>
						<li><a href="<?php echo site_url();?>home/disclaimer">Disclaimer</a></li>
						<li><a href="<?php echo site_url();?>home/help">Help</a></li>							
					</ul>
					<div class="copyright text-center">&copy; Content Owned by Indian Council for Cultural Relations, Government of India. All Rights Reserved.</div>
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
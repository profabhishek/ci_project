<div class="box">
   <div class="something1"></div>
   <div class="something2">
      <a class="mylink">My link</a>
   </div>
</div>

<script type='text/javascript'>
      $(".mylink").click(function() {
   $(this).parents(".box").fadeOut("fast");
}); 
	
</script>
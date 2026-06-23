<style type="text/css">
   h2{
   background: #ccde8f none repeat scroll 0 0;
   font-size: 16px;
   font-weight: bold;
   padding: 5px;
   text-align: center;
   border: 1px solid #000;
   }
   h1{
   background: #f18f2e none repeat scroll 0 0;
   color: #fff;
   font-size: 21px;
   font-weight: bold;
   padding: 5px;
   text-align: center;
   border: 1px solid #000;
   }
   ul li span{
   font-size: 11px;
   margin-right: 9px;
   }
</style>
<section class="meacontent" id="meacontent">
   <div  class="container">
      <div class="field-item even" property="content:encoded">
       
       
       
     <ul class="list-group" label="Gurus">
            <h1>Gurus</h1>
          <?php $centraluniversities = $this->common_model->getYogaGurus();	?>
        
         	<?php  
				foreach($centraluniversities as $univercity_cnet)
				{			
								
					echo ' <li class="list-group-item"><span class="glyphicon glyphicon-screenshot"></span><a title="External site that open in new window" href="'.$univercity_cnet['link'].'" target=_"blank">'.$univercity_cnet['uni'].' for ['.$univercity_cnet['subject'].']</a>';
													
						
				}					   
         	?> 
         </ul>
      
          
  
      </div>
   </div>
</section>
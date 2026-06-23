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
         <h1>State Universities</h1>
         <?php $stateuniversities = $this->common_model->getStateUniversities();
         $states =  $this->common_model->getAllStates();
			$statewiseUniversites = array();
			foreach($states as $st)
			{
				if(!array_key_exists($st['id'],$statewiseUniversites))
				{
					$statewiseUniversites[$st['id']] = array();
				}
			} ?>
         <ul class="list-group" label="&nbsp;&nbsp;&nbsp;ANDHRA PRADESH" class="stt">
         	<?php
         		
 				foreach($stateuniversities as $univercity)
				{											
					if(array_key_exists($univercity['state_id'],$statewiseUniversites))
					{													
						array_push($statewiseUniversites[$univercity['state_id']],$univercity);
					}
				}	 
				foreach($statewiseUniversites as $key=>$univercity1)
				{
					if(count($univercity1)>0)
					{
						$statenames = $this->common_model->getStateById($key);
						echo '<h2>'.$statenames[0]['name'].'</h2>';
						foreach($univercity1 as $uni_choice)
						{
							
								echo ' <li class="list-group-item"><span class="glyphicon glyphicon-screenshot"></span>
								<a title="External site that open in new window" href="'.$uni_choice['link'].'" target=_"blank">'.$uni_choice['uni'].'</a>';
								
						}							
					}	
				}
										   
         	?>
         
         
           
         </ul>
       
      </div>
   </div>
</section>
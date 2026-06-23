<style type="text/css">
.meacontent .container {
    margin-left: auto;
    margin-right: auto;
    padding-bottom: 40px;
    padding-left: 40px;
    padding-right: 40px;
}
.pics
{
	position: relative;
}
.piclable
{
	 background: #000 none repeat scroll 0 0;
    bottom: -300px;
    color: #fff;
    font-size: 20px;
    height: 44px;
    opacity: 0.4;
    padding-left: 20px;
    padding-top: 8px;
    position: absolute;
    vertical-align: bottom;
    width: 60%;
}
</style>


<section class="meacontent">
	<div  class="container">
		<div class="field-item even maincnt" property="content:encoded">
			<h2 class="pageTitle">PUNE</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/pune.jpg">
						<div class="piclable">SAVITRIBAI PHULE PUNE UNIVERSITY</div>
				</div>
					<div class="lft">  
					
					<?php
      	$address = strtoupper("PUNE, India");
	//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d945.6018793845902!2d73.82315922915849!3d18.555657570599404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2bf2fb6d316ed%3A0xbbac24f7e8910166!2sICCR%20Office%20Pune!5e0!3m2!1sen!2sin!4v1627890371727!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->


      	<br/>      
      </div>
      </div>
			
			
			<h3><strong> A Brief on the city:</strong></h3>
			
			<p>Pune is the second largest district in the state of Maharashtra. It is also known as oxford of the East on account of its educational institutions and their fame.
</p>

								
			<h4><strong>Education:</strong></h4>
			<p>One of the major Central/ State Universities in Pune comprises of Savitribai Phule Pune University, one of the major universities located in Pune.</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Being the cultural capital of Maharashtra, Pune exemplifies an indigenous Marathi culture and ethos, in which education, arts and crafts, and theaters are given due prominence. 

The city, on account of its established educational institution is also called “oxford of the East” , The Lokmanya Tilak Museum at Tilak Wada, Shaniwar Wada, a fort that used to be seat of the Peshwa rulers of the Maratha Empire and Lal Mahal built by Shivaji’s father Shahaji Bhonsle for his wife Jijabai are some remarkable heritage points in the city.

The other places of interest includes Mahatma Jyotirao Phule’s cottage, the Kelkar Museum, Aga Khan Palace which houses the Samadhi of Kasturba Gandhi, the revered wife of Mahatma Gandhi, is located here. <a href="https://incredibleindia.org/" target="_blank">Read More</a>
</p>


<h4><strong>Important Contact Address ICCR:</strong></h4>
<table class="table">
	<thead>
		<th>Name & Designation</th>
		<th>Address</th> 	
				<th>Contacts</th>
		
				
	</thead>
	<tbody>	
	<tr>
	
		<td><strong>Shri Sudarshan Shetty</strong></br>
Regional Officer</td>
		<td>Savitribai Phule University, Ganeshkhind Pune - 411 007 Maharashtra</td>
		
		<td>Tel: 020- 25884194, 25885464 (O)
Fax:020-25884140<br/>
(M):09665646049
Email: ropune[dot]iccr[at]gov[dot]in/<br/>iccrpune[at]gmail[dot]com</td>
		
		
	</tr>
	</tbody>
</table>

<strong>FRRO:</strong>		
	<table class="table">
	<thead>
	<th></th>
		<th></th>
		<th></th>		
		</thead>
	<tbody>	
	<tr>
<td>FRRO, Pune</td>
		<td>FRRO Pune, 
Police Commissioner Office, <br/>Next to GPO,<br/>Sadhu Waswani Road,<br/>Camp, Pune-411001</td>
		
		<td>+(91)-(20)-26208273<br/>
www.punepolice.gov.in </td>
		
		
	</tr>
	</tbody>
</table>
		</div>
	</div>
</section>
	
		<?php
function getLatLong($address){
    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        $data['latitude']  = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
            return $data;
        }else{
            return false;
        }
    }else{
        return false;   
    }
}
?>
	
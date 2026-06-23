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
			<h2 class="pageTitle">SHILLONG</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/shillong.jpg">
			<div class="piclable">Shillong UNIVERSITY</div>
			</div>  
			<div class="lft"> 
			
			
				 
			
			 	
      	<?php
      	$address = strtoupper("Shillong, India");
		//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2096.3538884745676!2d78.07674808367588!3d27.91323536521715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3974a4e5bcbc4b51%3A0xdada713733d0e998!2sAligarh%20Muslim%20University!5e0!3m2!1sen!2sin!4v1627974838477!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->
      	<br/>      
      	
      </div>
      </div>
			<h3><strong> A Brief on the city:</strong></h3>
			
			<p>Shillong is the capital of the Indian state of Meghalaya, often referred to as the "Scotland of the East" due to its picturesque landscapes, rolling hills, and cool climate. Nestled in the Khasi Hills, Shillong is known for its natural beauty, colonial-era charm, and vibrant local culture. The city is also a gateway to several scenic destinations in the Northeast and is home to important institutions and government bodies of the state.
</p>
								
			<h4><strong>Education:</strong></h4>
			<p>Shillong hosts some of the prominent educational institutions in Northeast India. These include North-Eastern Hill University (NEHU), Indian Institute of Management (IIM) Shillong, St. Anthonys College, St. Edmunds College, and Shillong College. The city is known for its academic atmosphere and has been a center for quality education in the region, attracting students from across the Northeast.</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Shillong is a cultural hub of Meghalaya, deeply rooted in tribal traditions, especially those of the Khasi community. The city is famous for its music scene, with rock and folk music festivals held frequently. Traditional festivals like Shad Suk Mynsiem and Nongkrem Dance Festival offer a glimpse into local customs and heritage. Shillongs tourist attractions include Wards Lake, Shillong Peak, Elephant Falls, and the Don Bosco Museum. The cool weather, misty hills, and friendly locals make it a favorite destination for nature lovers and cultural enthusiasts alike. Handwoven textiles, bamboo crafts, and local delicacies like Jadoh and Dohneiiong add to the city's unique charm.  <a href="https://incredibleindia.org/"target="_blank">Read More</a>
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
 <td><strong>Shri N. Munish Singh</strong> </br>Sub- Zonal Officer</td>

		<td>Indian Council for Cultural Relations Brookside Cottage,</br>New Assembly Compound,</br> Shillong-793 004 Meghalaya

</td>

	<td>Tel: +91-364-2228573,+91-8119923578 <br/>Fax: +91-364-2220183<br/>
Email: roshillong[dot]iccr[at]nic[dot]in, iccrshillong[at]gmail[dot]com</td>
		
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
<td>FRRO Kolkata,</td>
		<td>237, A.J.C. Bose Road, <br/>Kolkata</td>
		
		<td>033-22900549(T) <br/>
frrokol[at]nic[dot]in</td>
		
		
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
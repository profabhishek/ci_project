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
			<h2 class="pageTitle">HISAR</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/flash-img.jpg">
			
				<div class="piclable">PPIMT HISAR UNIVERSITY</div>
				</div>
					<div class="lft">  
					
					
					<?php
      	$address = strtoupper("HISAR, India");
		//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d289543.5112681662!2d75.3146384664657!3d29.029676473678446!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3913ccba708d17df%3A0x921c6cda6821805!2sPrannath%20Parnami%20Institute%20of%20Management%20%26%20Technology!5e0!3m2!1sen!2sin!4v1627982104133!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->


      	<br/>      
      </div>
      </div>
			
			<h3><strong> A Brief on the city:</strong></h3>
			
			<p>Encompassing the remains and traces of Pre-Harappan Civilization and Harappan Civilizations, Hisar is India’s largest site showcasing the life of earliest settlements of the humans.</p>

								
			<h4><strong>Education:</strong></h4>
			<p>Major Central/ State University in Hisar Chaudhary Charan Singh Haryana Agriculture University, Hisar.</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Culture of a place is a reflection of its society. The culture of Hisar is fascinating and captivating. It tells us about the people of the place, their lifestyle and their beliefs. Observing the culture of Hisar gives you a fair idea about the traditions and practices that are still followed by the locals. The festivals, the events, the attractions, all reflect the culture of Hisar in one way or the other.

The construction work of the Hisar city started in the year 1354 A.D. under the personal supervision of Firozshah himself who stayed here for a sufficient time. The boundary wall of Hisar Firoza was built of stones brought from the hills of Narsai. The fort city was also surrounded by a big ditch dug round the wall. The palace, popularly known as 'Gujari Mahal', was made for his beloved. The Gujari Mahal still stands in its austere majesty. This palace is a complex of different buildings, including the royal residence of the sultan Firozshah, Shahi Darwaza, Diwan-e-Aam, Baradari with three tehkhana, a Hamam, a mosque and a pillar. <a href="https://incredibleindia.org/" target="_blank">Read More</a>
</p>

<h4><strong>Important Contact Address ICCR:</strong></h4>
<table class="table">
	<thead>
		<th>Name</th>
		<th>Address</th> 	
				<th>Contacts</th>
		
				
	</thead>
	<tbody>	
	<tr>
	
		<td><strong>Shri K Ayyannar</strong> </br>Zonal Director</td>
		<td>USICR Press Building(Near Zoology Department)</br>
North Campus,Chatra Marg University of Delhi</td>
		
		<td>Tel: 91-11-27667373/74/75<br/> 
Fax: 0522-2209587<br/> Mobile: 8590373832<br/> Email:rochandigarh[dot]iccr[at]gov[dot]in,ro[dot]delhincr[at]gov[dot]in</td>
		
		
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
<td>FRRO Delhi,</td>
		<td>East Block-VIII</br>
Level-2 Sector-1 R.K. Puram</br>
New Delhi-110066.</td>
		
		<td>011-26711443/011-26713851<br/>  frrodli[dot]support[at]gov[dot]in</td>
		
		
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
	
	
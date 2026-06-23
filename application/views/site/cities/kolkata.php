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
			<h2 class="pageTitle">KOLKATA</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/kolkata.jpg">
			<div class="piclable"> UNIVERSITY OF KOLKATA</div>
				</div>
					<div class="lft">  
					
					
					<?php
      	$address = strtoupper("KOLKATA, India");
	//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2191.020737882973!2d88.35049664668615!3d22.54755443290127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a027710ea683541%3A0x4c4cff62b311f3bb!2sIndian%20Council%20For%20Cultural%20Relations!5e0!3m2!1sen!2sin!4v1627890341153!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->


      	<br/>      
      </div>
      </div>
			<h3><strong> A Brief on the city:</strong></h3>
			
			<p>Kolkata is the capital of India's West Bengal state. Today, it’s known for its grand colonial architecture, art galleries and cultural festivals. It’s also home to Mother House, headquarters of the Missionaries of Charity, founded by Mother Teresa, whose tomb is on site.
</p>
								
			<h4><strong>Education:</strong></h4>
			<p>Major Central/ State Universities in Kolkata comprise of Visva-Bharati  University founded by the first Indian Nobel Laureate Rabindranath Tagore in 1921, Aliah University, Calcutta University, Presidency University, Rabindra Bharati University, The Sanskrit College and University, West Bengal State University, West Bengal University of Animal and Fishery Sciences, West Bengal University of Technology are located in Kolkata.</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Kolkata is an important cultural centre of India. The city is the birthplace of modern Indian literary and artistic thought and of Indian nationalism, and its citizens have made great efforts to preserve Indian culture and civilization. The blending of Eastern and Western cultural influences over the centuries has stimulated the creation of numerous and diverse organizations that contribute to Kolkata’s cultural life.
			 Kolkata has a wealth of history ingrained in its many monuments and landmarks, such as the Victoria Memorial. Kolkata boasts of some of the best seafood, street food and sweet options. You would love the different preparations of fish, rolls and sandesh. The centre of the Bengal Renaissance, Kolkata has always been a hotbed of literature, theater, art and poetry. Home to traditional craftsmen and weavers, one can buy beautiful Calcutta sarees at very reasonable prices. <a href="https://incredibleindia.org/" target="_blank">Read More</a></p>

<h4><strong>Important Contact Address ICCR:</strong></h4>
<table class="table">
	<thead>
		<th>Name & Designation</th>
		<th>Address</th>
		<th>Contacts</th>		
						
	</thead>
	<tbody>	
	<tr>
		<td><strong>Shri R N Goswami</strong> </br>Zonal Director</td>
</td>


	<td>Rabindranath Tagore
Center<br/>
9A, Ho Chi Minh Sarani
Kolkata 700071, WEST
BENGAL</td>

	<td>Tel: 033-22822895/-0402/-0314/-
3431,22872680, <br/>Fax: 033-22874890/-0028<br/>
Email: rokolkata[dot]iccr[at]gov[dot]in / iccrcal[at]gmail[dot]com</td>
			
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
<td>FRRO, Kolkata.</td>
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
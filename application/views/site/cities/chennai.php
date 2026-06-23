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
			<h2 class="pageTitle">CHENNAI</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/chennai.jpg">
			
			<div class="piclable">MADRAS UNIVERSITY</div>
			</div>
			<div class="lft"> 
				
				
				<?php
      	$address = strtoupper("CHENNAI, India");
		//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d817.2360659810711!2d80.26161103260598!3d13.006877306710173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5267eedadfe533%3A0xd96d6b0041b73398!2sIndian%20Council%20for%20Cultural%20Relations!5e0!3m2!1sen!2sin!4v1627890275112!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->


      	<br/>      
      </div>
      </div>
				
			<h3><strong> A Brief on the city:</strong></h3>
			
			<p>Chennai is the capital city of the State of Tamil Nadu. In spite of being the capital of a Tamil speaking State, it has emerged as cosmopolitan city playing an important role in the historical, cultural and intellectual development of India,  In addition, it holds out an interesting fare of South Indian architecture, music, dance, drama, sculpture and other arts and crafts. </p>
								
			<h4><strong>Education:</strong></h4>
			<p>Major Central/State Universities in Chennai comprises of</p>
			 1. Anna University</br>
			 2. Madras University</br>
			 3. Tamil Nadu Music and Fine Arts University</br>
			 4. Tamil Nadu Open University</br>
		 	 5. Tamil Nadu Teacher Education University</br>
			 6. Tamilnadu Dr. M.G.R.Medical University</br>
			 7. Tamilnadu Physical Education and Sports University</br>
			 8. Tamilnadu Veterinary & Animal Sciences University</br>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>When it comes to hospitality and traditional food, Chennai beats many of the cities easily. As serving food is seen as an utmost pious deed in the entire South India, get ready to experience unforgettable moments while dining in the land of Chennai. They serve number of traditional foodstuffs including sambar, dosa, idli, rasam, coconut chutney, dry curry and kootu etc with steamed rice on banana leaf, which is the traditional way of dining in Chennai. The city has multiple variants of cuisines for vegan as well as for non-vegetarians. Do not forget to taste the rich Tamilian filtered coffee. <a href="https://incredibleindia.org/" target="_blank">Read More</a>
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
		<td><strong>Shri Pardeep Kumar</strong> </br>Zonal Director</td>
		<td>Ground Floor,
Regional Passport Office,<br/> 
8th Block, 80 Feet Road,Koramangala,<br/>
Bangalore – 560 020<br/>
Karnataka</td>
		
		<td>Ph: 080-23466175 (D)
080-23566914/23462714/ <br/>23462715 (O) 080-23566917 (Fax)
9036457331 (M)<br/>
E-mail: robengaluru[dot]iccr[at]gov[dot]in;<br/>
iccrbengaluru[at]gmail[dot]com</td>

	
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

		<td>FRRO Bangalore</td>
		<td>5th Floor, 'A' Block, TTMC, <br/>
		BMTC Bus Stand Building, <br/>
		K.H. Road, Shantinagar, <br/>
		Bangalore - 560027</td>
		
		<td>080-22218195,080-22218183,<br/>
		080-22218110 , 
080-22218196 [Fax]<br/>
Email: frroblr-ka[at]nic[dot]in</td>
		
		
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
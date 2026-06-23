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
			<h2 class="pageTitle">MUMBAI</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/mumbai.jpg">
			
				<div class="piclable">IIT BOMBAY UNIVERSITY</div>
				</div>
					<div class="lft">  
					
					<?php
      	$address = strtoupper("MUMBAI, India");
	//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.4119848635696!2d72.9110792142136!3d19.133435255138224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c7f189efc039%3A0x68fdcea4c5c5894e!2sIndian%20Institute%20of%20Technology%20Bombay!5e0!3m2!1sen!2sin!4v1627982350582!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->


      	<br/>      
      </div>
      </div>
					
			<h3><strong> A Brief on the city: </strong></h3>
			
			<p>Mumbai (formerly called Bombay) is a densely populated city on India’s west coast called financial capital of India. Offshore, Elephanta Islands having cave temples dedicated to the Hindu god Shiva. The city is also home to Bollywood film industry.</p>
								
			<h4><strong>Education:</strong></h4>
			<p>Major Central/ State Universities, Institutions in Mumbai comprise of Mumbai University, Mahatma Gandhi Antarrashtriya Hindi Vishwavidyalaya, IIT Bombay.</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Mumbai is a magical city with a wonderful vibe. Housing India’s most prolific film industry; some of Asia’s biggest slums as well as world’s most expensive homes along with the largest tropical forest in an urban area, the city truly mirrors the diversity that India is known for. 
Situated at a 10 km radius from Gateway of India is one of the major tourist places in Mumbai, the Elephanta Caves. The caves are said to be one of the oldest rock cut structures in the country and is a perfect example of archaic Indian art associated to the cult of Lord Shiva.<a href="https://incredibleindia.org/" target="_blank">Read More</a></p>

<h4><strong>Important Contact Address ICCR:</strong></h4>
<table class="table">
	<thead>
		<th>Name & Designation</th>
		<th>Address</th>
		<th>Contacts</th>		
						
	</thead>
	<tbody>	
	<tr>
		<td><strong>Ms. Renu Prithiani</strong> </br>Zonal Director</td>


	<td>Videsh Bhavan 3rd floor,G Block,plot No.C-45,</br> Bandra-Kurla Complex,</br> Bandra (East) Mumbai 400 051</td>

	<td>Tel: 022-26520027,42,43 (O)
E-mail: iccr[dot]may2012[at]gmail[dot]com</td>
		
		
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
<td>FRRO, Mumbai.</td>
		<td>Annex-II Bldg., <br/> 3rd Floor Badruddin Tayyabji Marg,<br/>  Behind St.Xavier’s College,<br/>  C.S.T., Mumbai- 400001</td>
		
		<td>022-22621169(T) 022-22620721(F) <br/> For Enquiries on Registration and Visa Services Phone <br/> 022-22620446, Enquiry For PIO/OCI <br/> Phone 022-2262116
frromum[at]nic[dot]in</td>
		
		
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
	
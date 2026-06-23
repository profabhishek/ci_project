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
			<h2 class="pageTitle">ALIGARH</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/ALU.jpg">
			<div class="piclable">ALIGARH MUSLIM UNIVERSITY</div>
			</div>  
			<div class="lft"> 
			
			
				 
			
			 	
      	<?php
      	$address = strtoupper("Aligarh, India");
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
			
			<p>Aligarh is a District of Uttar Pradesh, India. The city is located about 90 miles (140 km) southeast of New Delhi. The administrative headquarters of Aligarh District is Aligarh (Koil). It is here that Aligarh Muslim University is located.
</p>
								
			<h4><strong>Education:</strong></h4>
			<p>Major Central/ State University in Aligarh: Aligarh Muslim University (1875).</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>The locks manufactured in Aligarh are a commodity well known across India and in other places.  <a href="https://incredibleindia.org/"target="_blank">Read More</a>
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
<td><strong>Shri Arvind Kumar</strong> <br>Sub-Zonal Director</br>
		<td>3rd Floor, Passport Bhawan
Vipin Khand, Gomti Nagar
Lucknow-226010
Uttar Pradesh</td>

	<td>Tel: 0522-2209592, 2209594<br/> 
Fax: 0522-2209587<br/> Mobile: 07080921503<br/> Email: iccrluck[at]gmail[dot]com, rolucknow[dot]iccr[at]gov[dot]in</td>
		
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
<td>FRRO Lucknow,</td>
		<td>557, Hind Nagar, Kanpur Road,<br/>  Near Old Chungi, Lucknow- 226012.</td>
		
		<td>0522-2432431(T) 0522-2432430(F)<br/>  frrolko[at]nic[dot]in</td>
		
		
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
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
			<h2 class="pageTitle">BENGALURU</h2>
				<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/banglore.jpg">
			<div class="piclable">BENGALURU UNIVERSITY</div>
			</div>  
			<div class="lft"> 
				
				
				 	<?php
      	$address = strtoupper("BENGALURU, India");
		//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1634.5368490531976!2d77.58544668694286!3d12.997052512656754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae164712d40fdb%3A0xabfcd5dda6305b23!2sIndian%20Council%20For%20Cultural%20Relations%20ICCR!5e0!3m2!1sen!2sin!4v1627890171648!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->
      	<br/>      
      </div>
      </div>
			
			<h3><strong> A Brief on the city:</strong></h3>
			
								<p><strong>Bangalore</strong> known as <strong> Bengaluru</strong>is the capital of the Indian state of Karnataka. Located in southern India on the Deccan Plateau, at a height of over 900 m (3,000 ft) above sea level. Its elevation is the highest among the major cities of India.

Bangalore is sometimes referred to as the "Silicon Valley of India" (or "IT capital of India") because of its pioneering role as the nation's leading information technology (IT). Indian technological organizations ISRO, Infosys, Wipro and HAL have headquarters in the city.  The population of youngsters mostly students, out on the streets of the city in evenings, is a sight worth watching.
</p>
								
			<h4><strong>Education:</strong></h4>
			<p>Bangalore University, established in 1886, provides affiliation to over 500 colleges, with a total student enrollment exceeding 300,000. </p>
				
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Bangalore is known as the "Garden City of India" because of its gentle climate, broad streets, greenery and the presence of many public parks, such as Lal Bagh and Cubbons Park.  Bangalore is sometimes called as the "Rock/Metal Capital of India" because it is one of the premier places to hold international rock concerts.  In May 2012, Lonely Planet ranked Bangalore 3rd among the world's top 10 cities to visit.

Bangalore is also home to many vegan-friendly restaurants and vegan activism groups due it which it has been named as India's most vegan-friendly city by PETA India. <a href="https://incredibleindia.org/"target="_blank">Read More</a></p>

<h4><strong>Important Contact Address ICCR:</strong></h4>
<table class="table">
	<thead>
		<th>Name & Designation</th>
		<th>Address</th>
		<th>Designation</th>		
		
				
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
	
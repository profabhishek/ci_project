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
			<h2 class="pageTitle">BHOPAL</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/bhopal.jpg">
			
			<div class="piclable">MANIT UNIVERSITY</div>
			</div>
			<div class="lft"> 
				
				<?php
      	$address = strtoupper("BHOPAL, India");
		//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d916.512458057925!2d77.39936552916366!3d23.24127363132878!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397c42a2b7d49d01%3A0x2c605319307c212b!2sICCR%20Office!5e0!3m2!1sen!2sin!4v1627890230466!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->
      	<br/>      
      </div>
      </div>
				
				
				
			<h3><strong> A Brief on the city:</strong></h3>
			
							<p><strong>Bhopal</strong> the capital of the Indian state of Madhya Pradesh and the administrative headquarters of Bhopal district and Bhopal division.  Bhopal is known as the City of Lakes for its various natural as well as artificial lakes and is also one of the greenest cities in India.

Bhopal houses various institutions and installations of national importance, including ISRO's Master Control Facility and BHEL. Bhopal is home to the largest number of Institutes of National Importance in India, namely Indian Institute of Science Education and Research Bhopal(IISER), Maulana Azad National Institute of Technology Bhopal(MANIT), School of Planning and Architecture Bhopal (SPA), and All India Institute of Medical Sciences, Bhopal(AIIMS).</p>
								
			<h4><strong>Education:</strong></h4>
			<p>The Bhopal is the home of many universities and national Institutes. The institutes
and universities headquartered in the city include: </p>
1. Atal Bihari Vajpayee Hindi Vishwavidyalaya <br/>
2. Barkatullaah University  <br/>
3. M.P.Bhoj (open) University <br/>
 4. Makhanlal <br/>
Chaturvedi National University of Journalism & Communication <br/>
5. National Law Institute 
University<br/>
6. Rajiv Gandhi Prodoyogiki Vishwavidyalaya<br/>
7. Sanchi University of
Buddhist-Indic Studies.<br/>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Bharat Bhavan is the main cultural centre of the city. It has an art gallery, an open-air amphitheater facing the Upper Lake, two other theaters and a tribal museum.

Bhopali culture is such that people of all religions visit each other on their respective festivals to greet and exchange sweets. <a href="https://incredibleindia.org/" target="_blank">Read More</a></p>

<h4><strong>Important Contact Address ICCR:</strong></h4>
<table class="table">
	<thead>
		<th>Name & Designation</th>
		<th>Address</th>
		<th>Contact</th>		
		
				
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
<td>FRRO Delhi,
		<td>East Block-VIII</br>
Level-2 Sector-1 R.K. Puram</br>
New Delhi-110066</td>
		
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
	
	
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
			<h2 class="pageTitle">DELHI</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/delhi.jpg">
			<div class="piclable">IIT DELHI UNIVERSITY</div>
			</div>  
			<div class="lft"> 
			
			
				 
			
			 	
      	<?php
      	$address = strtoupper("Delhi, India");
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
			
			<p>Delhi is the capital of India and one of the country most vibrant metropolitan cities. Known for its rich history, architectural grandeur, and dynamic lifestyle, Delhi blends ancient heritage with modern developments. It is home to the Indian Parliament, Rashtrapati Bhavan, and several historical landmarks like the Red Fort and Qutub Minar. Delhi also houses Raj Ghat, the memorial of Mahatma Gandhi.
</p>
								
			<h4><strong>Education:</strong></h4>
			<p>Delhi is home to some of India most prestigious educational institutions. Major Central/State Universities in Delhi include the University of Delhi, Jawaharlal Nehru University (JNU), Jamia Millia Islamia, Guru Gobind Singh Indraprastha University, Ambedkar University Delhi, Indira Gandhi National Open University (IGNOU), and the Indian Institute of Technology (IIT) Delhi..</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Delhi is a cultural mosaic that represents a blend of India's diverse traditions. It is a hub of historical monuments, vibrant street markets, performing arts, and cuisine. The city celebrates various festivals with great enthusiasm, including Diwali, Eid, Holi, and Christmas. Tourists can explore Mughal architecture in Old Delhi, experience contemporary art and culture in New Delhi, and enjoy delicious food ranging from kebabs to chaat. As the heart of political and cultural India, Delhi offers everything from heritage walks to modern shopping malls, attracting millions of visitors each year.  <a href="https://incredibleindia.org/"target="_blank">Read More</a>
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
<td>FRRO Delhi</td>
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
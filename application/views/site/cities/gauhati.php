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
			<h2 class="pageTitle">GUWAHATI</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/small_subansiri.jpg">
			
			<div class="piclable">IIT GUWAHATI CAMPUS</div>
				</div>
					<div class="lft">      
			
			<?php
      	$address = strtoupper("GUWAHATI, India");
	//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3582.02178406366!2d91.81853971434789!3d26.130832699601953!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375a58b18c878c47%3A0xe5722676ec12679!2sIndian%20Council%20For%20Cultural%20Relations%20Guwahati!5e0!3m2!1sen!2sin!4v1627890295226!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->


      	<br/>      
      </div>
      </div>
      
      <h3><strong> A Brief on the city:</strong></h3>
			<p><strong>Guwahati</strong> is a major city in Eastern India.  Dispur is the capital of Assam state.</p>
			
			<p> Guwahati is a mixture of beautiful landmark and fast growing developing city in India.  It is a major commercial and educational center, world class institutions such as the Indian Institute of Technology Guwahati.  This city is a major center for sports and other activities of north east peoples and for the administrative and political activities in Assam.</p>
								
			<h4><strong>Education:</strong></h4>
			<p>Major Central/State Universities in Guwahati comprises of.</p>
			 1. Assam Rajiv Gandhi University of Co-operative Management<br/>
			  2. Assam Science & Technology University <br/>
			  3. Cotton College State University <br/>
			  			  4. Guwahati University<br/>
			   5. Krishna Kanta Handique State Open University<br/>
			   6. National Law University and Judicial Academy<br/>
			   			    7. Srimanta Sankaradeva University of Health Sciences<br/>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Many South, Eastern and Southeast Asian communities have settled in Assam over the centuries. But civilization in the region did not necessarily begin with the fertile Brahmaputra Valley. Discoveries of stone implements and pottery reveal the existence of prehistoric communities on the highlands encircling the valley. 
Anthropological accounts say Assam’s demography is marked by several waves of migration. Australoids, the first inhabitants, were absorbed or dispersed by the Mongoloids that ancient Sanskrit literature term as Kirats. The Caucasoids followed, and their four categories – Mediterranean, Alpine, Indo-Aryan and Irano-Scythian – settled in the valleys. <a href="https://incredibleindia.org/" target="_blank">Read More</a></p>

<h4><strong>Important Contact Address ICCR:</strong></h4>
<table class="table">
	<thead>
		<th>Name & Designation</th>
		<th>Address</th> 	
				<th>Contacts</th>
		
				
	</thead>
	<tbody>	
	<tr>
		<td><strong>Shri N. Munish Singh</strong><br/>
Zonal Director</td>
		<td>Annexure Pavilion
Shilpgram, <br/>Panjabari Road<br/>
Guwahati - 781 037
Assam</td>
		
		<td>Ph. 0361-2335358 (O)
0361-2335359 <br/>(Fax)
9864839444 (M)<br/>
E-mail: roguwahati[dot]iccr[at]gov[dot]in;<br/>
iccrro[dot]guwahati[at]gmail[dot]com</td>
	
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
<td>FRRO Guwahati,</td>
		<td>Deputy Commissioner of Police 
		<br/>(Intelligence) Panbazar,
Guwahati, Assam-781001</td>
		
		<td>Tel: 0361-2543458<br/>
Email: dcp-intl[at]assampolice[dot]gov[dot]in</td>
		
		
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
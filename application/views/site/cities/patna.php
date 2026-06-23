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
			<h2 class="pageTitle">PATNA</h2>
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/patna.jpg">
				<div class="piclable">PATNA UNIVERSITY</div>
				</div>
					<div class="lft">  
					
					<?php
      	$address = strtoupper("PATNA, India");
	//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d945.6018793845902!2d73.82315922915849!3d18.555657570599404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2bf2fb6d316ed%3A0xbbac24f7e8910166!2sICCR%20Office%20Pune!5e0!3m2!1sen!2sin!4v1627890371727!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->


      	<br/>      
      </div>
      </div>
			
			
			<h3><strong> A Brief on the city:</strong></h3>
			
			<p>Patna is the capital and largest city of the state of Bihar in India.  Buddhist, Hindu, and Jain pilgrimage centres of Vaishali, Rajgir, Nalanda, Bodh Gaya, and Pawapuri are situated nearby Patna City is also a sacred city for Sikhs as the tenth Sikh Guru, Guru Gobind Singh, was born here.</p>

								
			<h4><strong>Education:</strong></h4>
			<p>Major Central/ State Universities in Patna comprise of Central University of South Bihar, Patna University.</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>Patna is blessed with a culture which has continuously evolved during the last 2500 years of recorded history. The population comprises of dThe food of the city reflects the tradition brought along the history and its quite distinct. The Mughlai and Central Asia food, brought along with the foreign invaders during Medieval India can also be found in the city. Rice forms the staple food, eaten in combination with lentils, vegetables, chapati and pickles. <a href="https://incredibleindia.org/" target="_blank">Read More</a>
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
	
		<td>Regional Director/ Officer</br>
		Smt. Swadha Rizvi, I.F.S.
</td>
		<td>67-68/40. Officers
flats
Opposite Suchna<br/>
Bhavan
Patna-800001<br/>Bihar</td>
		
		<td>Tel: 0612-2204734, 2545232<br/> Fax:
0612-2227972<br/>s
E-mail ropatna[dot]iccr[at]gov[dot]in;
iccrropatna[at]gmail[dot]com,</td>
		
		
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
<td>FRRO Patna,</td>
		<td>FRRO Patna, <br/>
Superintendent of Police,<br/> 
Muradpur, 
Patna, Bihar 800001</td>
		
		<td>Off:061-22219745, 22214318<br/>
Mob: 09470001389<br/>
Email: ssp-patna-bih[at]nic[dot]in</td>
		
		
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
	
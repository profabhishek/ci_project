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
			<h2 class="pageTitle">GOA</h2>
			
			<div class="mancnttt"> 
				<div class="pics">
			<img class="cityimage" src="<?php echo site_url();?>assets/site/main/images/cities/Goa_University.jpg">
			<div class="piclable">GOA UNIVERSITY</div>
				</div>
					<div class="lft">      
				
			
				
			<?php
      	$address = strtoupper("GOA, India");
	//$latLong = getLatLong($address);
					////$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
					//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
			      	?> 
			<!--<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>--><div style='overflow:hidden;height:298px;width:37%;border:2px solid #f18f2e;padding: 5px;'><div id='gmap_canvas' style='height:298px;width:100%;'>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7690.998655520968!2d73.83240262175961!3d15.457550897830874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfc753797558d1%3A0x482155287a8ee944!2sGoa%20University!5e0!3m2!1sen!2sin!4v1627982455541!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div><div><small><a href=""></a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><!--<script type='text/javascript'>function init_map(){var myOptions = {zoom:7,center:new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>'),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng('<?php echo $latitude;?>','<?php echo $longitude;?>')});infowindow = new google.maps.InfoWindow({content:'Ahemdabad, India <br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>-->


      	<br/>      
      </div>
      </div>
			
			
			<h3><strong> A Brief on the city:</strong></h3>
			
			<p>Goa, a tiny emerald land on the west coast of India, </p>
								
			<h4><strong>Education:</strong></h4>
			<p>Goa University, established in June 1985, is located on a picturesque campus spread over 427.49 acres area of Taleigao Plateau overlooking the Zuari Estuary, within close vicinity of the capital city of Panaji, in North Goa. Besides being the most important location for post-graduate studies, it also serves as the academic nerve-centre of the higher education system in Goa. Today Goa University, is a university of affiliated colleges, 55 of which are distributed across Goa, 

Goa enjoys a place of pride in the country as one of the most literate states of India.</p>
			
			<h4><strong>Culture and Tourism:</strong></h4>
			<p>The state of Goa, in India, is famous for its beaches and places of worship.Tourism is its primary industry.  Foreign tourists, mostly from Europe, arrive in Goa in winter whilst the summer and monsoon seasons see a large number of Indian tourists. 

Major tourist attractions include: Bom Jesus Basilica, Fort Aguada, a wax museum on Indian culture and a heritage museum. The Churches and Convents of Goa have been declared a World Heritage Site by UNESCO. <a href="https://incredibleindia.org/" target="_blank">Read More</a>
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
<td>FRRO Mumbai,</td>
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
	
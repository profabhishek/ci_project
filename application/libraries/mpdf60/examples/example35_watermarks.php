<?php

$html = '
<h1>mPDF</h1>
<h2>Watermarks</h2>
<p>P: Nulla felis erat, imperdiet eu, ullamcorper non, nonummy quis, elit. Suspendisse potenti. Ut a eros at ligula vehicula pretium. Maecenas feugiat pede vel risus. Nulla et lectus. Fusce eleifend neque sit amet erat. Integer consectetuer nulla non orci. Morbi feugiat pulvinar dolor. Cras odio. Donec mattis, nisi id euismod auctor, neque metus pellentesque risus, at eleifend lacus sapien et risus. Phasellus metus. Phasellus feugiat, lectus ac aliquam molestie, leo lacus tincidunt turpis, vel aliquam quam odio et sapien. Mauris ante pede, auctor ac, suscipit quis, malesuada sed, nulla. Integer sit amet odio sit amet lectus luctus euismod. Donec et nulla. Sed quis orci. </p>

<hr />

<div>DIV: Proin aliquet lorem id felis. Curabitur vel libero at mauris nonummy tincidunt. Donec imperdiet. Vestibulum sem sem, lacinia vel, molestie et, laoreet eget, urna. Curabitur viverra faucibus pede. Morbi lobortis. Donec dapibus. Donec tempus. Ut arcu enim, rhoncus ac, venenatis eu, porttitor mollis, dui. Sed vitae risus. In elementum sem placerat dui. Nam tristique eros in nisl. Nulla cursus sapien non quam porta porttitor. Quisque dictum ipsum ornare tortor. Fusce ornare tempus enim. </div>
<div>DIV: Proin aliquet lorem id felis. Curabitur vel libero at mauris nonummy tincidunt. Donec imperdiet. Vestibulum sem sem, lacinia vel, molestie et, laoreet eget, urna. Curabitur viverra faucibus pede. Morbi lobortis. Donec dapibus. Donec tempus. Ut arcu enim, rhoncus ac, venenatis eu, porttitor mollis, dui. Sed vitae risus. In elementum sem placerat dui. Nam tristique eros in nisl. Nulla cursus sapien non quam porta porttitor. Quisque dictum ipsum ornare tortor. Fusce ornare tempus enim. </div>

<blockquote>Blockquote: Maecenas arcu justo, malesuada eu, dapibus ac, adipiscing vitae, turpis. Fusce mollis. Aliquam egestas. In purus dolor, facilisis at, fermentum nec, molestie et, metus. Maecenas arcu justo, malesuada eu, dapibus ac, adipiscing vitae, turpis. Fusce mollis. Aliquam egestas. In purus dolor, facilisis at, fermentum nec, molestie et, metus.</blockquote>

<address>Address: Vestibulum feugiat, orci at imperdiet tincidunt, mauris erat facilisis urna, sagittis ultricies dui nisl et lectus. Sed lacinia, lectus vitae dictum sodales, elit ipsum ultrices orci, non euismod arcu diam non metus.</address>
<table border="1">
			<thead>
					 <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="application_submitted_table" rowspan="1" colspan="1" style="width: 37px;" aria-sort="ascending" aria-label=" S.NO : activate to sort column descending"> S.NO </th><th class="sorting" tabindex="0" aria-controls="application_submitted_table" rowspan="1" colspan="1" style="width: 138px;" aria-label=" Application Number : activate to sort column ascending"> Application Number </th><th class="sorting" tabindex="0" aria-controls="application_submitted_table" rowspan="1" colspan="1" style="width: 150px;" aria-label=" NGO Name &amp;amp;ID : activate to sort column ascending"> NGO Name &amp;ID </th><th class="sorting" tabindex="0" aria-controls="application_submitted_table" rowspan="1" colspan="1" style="width: 91px;" aria-label=" NITI Aayog Id: activate to sort column ascending"> NITI Aayog Id</th><th class="sorting" tabindex="0" aria-controls="application_submitted_table" rowspan="1" colspan="1" style="width: 53px;" aria-label=" District : activate to sort column ascending"> District </th><th class="sorting" tabindex="0" aria-controls="application_submitted_table" rowspan="1" colspan="1" style="width: 97px;" aria-label=" Project Name : activate to sort column ascending"> Project Name </th><th class="sorting" tabindex="0" aria-controls="application_submitted_table" rowspan="1" colspan="1" style="width: 158px;" aria-label=" NGO Total Project Cost : activate to sort column ascending"> NGO Total Project Cost </th><th class="sorting" tabindex="0" aria-controls="application_submitted_table" rowspan="1" colspan="1" style="width: 227px;" aria-label=" Date of Forwarding from Ministry : activate to sort column ascending"> Date of Forwarding from Ministry </th></tr>
           </thead>
           <tbody>
					  					  
					   					  
					<tr role="row" class="odd">
                <td class="sorting_1"> 1 </td>
                <td><a href="http://localhost:8000/wcdngo/state/approvedApplicationDetails/STEP1482822207" title="View">STEP1482822207</a></td>
                <td> Rakesh Kumar (NGO)   </td>
                <td> nicmwcd </td>
                <td> Delhi </td>
                <td> Chemicals </td>
                <td> 900000 </td>
                <td>  27-12-2016 </td>
            </tr></tbody>
				</table>
';


//==============================================================
//==============================================================
//==============================================================

include("../mpdf.php");

$mpdf=new mPDF('c'); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->SetWatermarkText('DRAFT');
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->showWatermarkText = true;

$mpdf->WriteHTML($html);
$mpdf->AddPage();

$mpdf->SetWatermarkImage('tiger.wmf', 1, '', array(160,10));
$mpdf->showWatermarkImage = true;

$mpdf->WriteHTML('<h2>Using a Watermark as a Header</h2>');
$mpdf->WriteHTML($html);
$mpdf->AddPage();

$mpdf->SetWatermarkImage('tiger.wmf', 0.15, 'F');
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML('<h2>Using a Watermark Image as Background</h2>');
$mpdf->WriteHTML($html,2);


$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================


?>
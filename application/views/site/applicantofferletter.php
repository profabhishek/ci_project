
 
 <html>
    <style>
        .sign_align {
            text-align: right;
        }
		
    </style>

    <body>
        <?php 
        foreach( $schemeId as $stepOne)



        {


echo $stepOne['application_no'];






        
        ?>
        <p style="text-align:;"><small>Ref. No. <?php echo $data->applicationId; ?> <br/>Date: <?php echo $missionDate; ?> </small></p>

		<?php 
        $image = site_url() . 'assets/site/main/images/mea-logo.jpg';
        $new = '<img src="' . $image . '" class="" style="margin: auto;">';
        ?>
	<!--/var/www/html/assets/site/main/images/mea-logo.jpg; -->

        <div style="text-align: center;"><?php echo $new; ?></div>
		<h3 style="text-align: center;">Dummy Letter</h3>
        <h3 style="text-align: center;">Indian Council For Cultural Relations (ICCR)</h3>
        <p style="text-align: right;"><?php echo  $mission[0]['mission_type'] . ': ' . $mission[0]['mission_name'].',<br>'.$mission[0]['country_name']; ?></p>

        <p>Subject:- Offer of Provisional admission with award of ICCR Scholarship for A.Y 2023-24</p>

        <p>Dear: Mr./Ms./Mrs. <?php echo  $stepOne[0]['fullname'] . ' ' . $stepOne[0]['middlename'] . ' ' . $stepOne[0]['familyname']; ?></p>
        <p>1)  We are pleased to inform you that you have been provisionally selected to pursue Course <?php echo $course . ' at under ' . $uninmae[0]['name'] . ' ' . $schemename[0]['scheme_name'] . ' for the Academic Year 2023-2024. You are requested to report ' . $regionInfo[0]['name'] . ' University physically along with all original certificate and testimonials latest by '   . $response[0]['timeline'] . ' and also to Regional Office through Email.'; ?></p>
        <p>2)  Hostel accommodation will be provided to you subject to its availability by University authorities. You are required to report at the nearest �Foreign Regional Registration Office� within fourteen days of arrival in India.</p>
        <p>3)  You are advised to contact the Education Wing of this Mission immediately along with your passport for grant of visa and finalization of your date of departure. You are also hereby directed to obtain your final departure letter from the Mission before joining the concerned Institution in India failing which this offer letter stands cancelled. Furthermore no request of change of course and University will be entertained.</p>
        <p>4)  You are advised to carry with you joining report form and a Minimum of INR 50,000/- equivalent to $700 to meet incidental expenses on arrival in India.</p>
        <p>5)  Please complete all pre-departure formalities such as preparation of passport  and getting the student/research visa.</p>
        <p>6)  Please carry original documents for confirming the provisional admission at the time of reporting at University. Please note that admission is granted provisionally and needs to be confirmed on the basis of submission of original documents at the time of first reporting at the University. In case of discrepancies in documentation, University reserves the right to cancel provisional admission offered to student. ICCR/Mission will not be responsible for cancellation of provisional admission on the above grounds and will not be liable to pay scholarship or expenses  incurred on return air-tickets by the student.</p>
        <!--<p><b>NOTE:-</b> Due to ongoing Covid-19 Pandemic, students will take up online classes and once the situation is better students will be invited to India as and when University allows to report and join physical classes. For any update, please be in touch with University and Mission.</p>-->
	</br></br>
		<p style="text-align: right;">Yours Sincerely <br><?php echo $missionPersonName; ?></p>

        <?php } ?>
    </body>
</html>   
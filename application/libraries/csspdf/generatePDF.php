<?php
    require_once('./autoload.inc.php');

    use Dompdf\Dompdf;
    $userName=$_POST['name'];
    $dompdf = new Dompdf();

    $html= '<h1 style="color: blue;"> Hello World</h1>'.$userName;

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'landscape');

    $dompdf->render();

    $dompdf->stream();

?>
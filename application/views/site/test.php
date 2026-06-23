<?php
$a = '1';
$b = &$a;
echo $b;
$b = "2$b";
echo $a.", ".$b;
?>
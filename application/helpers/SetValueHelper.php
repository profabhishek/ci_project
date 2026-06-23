<?php

//echo "helper";die;
function get_field_value($field,$row)
    {
        if(isset($_POST[$field]))
        {
            $val=$_POST[$field];
        }else if(isset($row[$field])){
            $val=$row[$field];
        }else{
            $val='';
        }
        return $val;
    }
	
	
	
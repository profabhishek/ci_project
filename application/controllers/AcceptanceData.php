<?php

defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
class AcceptanceData extends CI_Controller {

    function allStudent(){
		$data = array("data"=>"hrllo");
		$this->response($data);
   
	   }
	   

}
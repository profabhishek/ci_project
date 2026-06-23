<?php

class App_auth
{

private $CI;

function App_auth()
{
$this->CI = &get_instance();
}

function index()
{
		//echo "-----------";die;
		//echo "<pre>";print_r($this->CI);die;
if ($this->CI->session->userdata('user_data') == "" )  // If no session found redirect to login page.
{
redirect('home');
}
}
}


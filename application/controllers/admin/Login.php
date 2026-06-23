<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Login extends CI_Controller {	
	function __construct()	{
			parent::__construct();	$this->load->helper('url');	$this->load->helper('form');	
			$this->load->library('session');	
			$this->load->library('encrypt');	    
			 $this->load->model('admin/UserModel');	
			 $this->load->library('form_validation');	
			 $this->load->helper('security');	
			 $this->load->library('pagination');
	}		
	public function index()	{
		
		}	
		public function logout()
		{
			$array_items = array('name' => '', 'email' => '');	$this->session->unset_userdata($array_items);	
			redirect('admin/login');	
			}	
		}
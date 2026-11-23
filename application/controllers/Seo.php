<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seo extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');	
        $this->load->library('encryption');
        $this->load->helper('date');   
        $this->load->model('user_model'); 
        $this->load->model('common_model');     
        $this->load->model('user_model');     
        $this->load->library('excel'); 
          
    }
	// XML sitemap for search engines: /sitemap.xml (see config/routes.php)
	function xml()
	{
		$this->load->helper('a2a_sitemap');
		$seen = array();
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
		foreach (a2a_sitemap_groups() as $links) {
			foreach ($links as $l) {
				if (strpos($l[1], '#') === 0 || preg_match('/\.(pdf|xlsx?)$/i', $l[1])) { continue; }
				$u = site_url($l[1]);
				if (isset($seen[$u])) { continue; } $seen[$u] = 1;
				$xml .= '  <url><loc>' . htmlspecialchars($u, ENT_XML1, 'UTF-8') . '</loc></url>' . "\n";
			}
		}
		$xml .= '</urlset>' . "\n";
		$this->output->set_content_type('application/xml', 'utf-8')->set_output($xml);
	}
	function sitemap()
    {
    	$this->load->view('site/header');
		$this->load->view("sitemap");
		$this->load->view('site/footer');        
    }
}

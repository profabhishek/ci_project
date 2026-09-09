<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends CI_Controller {
    function __construct() {
        parent::__construct();
		$this->load->helper('url');
			$this->load->helper('form');
			$this->load->helper('security');
			$this->load->helper('text');
			$this->load->library('form_validation');
			$this->load->library('session');	
			$this->load->library('encryption');
			$this->load->helper('date');   
			$this->load->model('user_model'); 
			$this->load->model('common_model');  
			$this->load->model('M_db');
           
    }

    function blog($start = 0)//index page
    {
		$this->load->model('M_db');
        $data['posts'] = $this->M_db->get_posts(5, $start);
		//print_r($data);die;
        //pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/blog/index/';//url to set pagination
        $config['total_rows'] = $this->M_db->get_post_count();
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links(); //Links of pages

        $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
        //$this->load->view('header', $class_name);
        //$this->load->view('v_home', $data);
		$this->load->view('site/header');
		$this->load->view('site/v_blog_home',$data);
		$this->load->view('site/footer');
    }

    function search($query = '')//index page
    {

        $query = $query != '' ? $query : $this->input->get('query', TRUE);

        $data['posts'] = $this->m_db->search_posts($query);

        //pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'blog/search/?query=' . urlencode($query);//url to set pagination
        $config['total_rows'] = $this->m_db->get_post_count();
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links(); //Links of pages
        $data['query'] = $query; //Links of pages

        $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
        $this->load->view('header', $class_name);
        $this->load->view('v_search', $data);
        $this->load->view('footer');
    }

    function post($post_id)//single post page
    {
        $this->load->model('M_comment');
        $data['comments'] = $this->M_comment->get_comment($post_id);
		//print_r($data['comments']);die;
        $data['post'] = $this->M_db->get_post($post_id);
		//print_r($data['post']);die;
        $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
        $this->load->view('site/header');
        $this->load->view('site/v_single_post', $data);
        $this->load->view('site/footer');
    }

    function new_post()//Creating new post page
    {
        //when the user is not an admin and author
        if (!$this->check_permissions('author'))
        {
            redirect(base_url() . 'index.php/users/login');
        }
        if ($this->input->post()) {
            $data = array('post_title' => $this->input->post('post_title'), 'post' => $this->input->post('post'), 'active' => 1,);
            $this->m_db->insert_post($data);
            redirect(base_url() . 'index.php/blog/');
        } else {

            $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
            $this->load->view('header', $class_name);
            $this->load->view('v_new_post');
            $this->load->view('footer');
        }
    }

    function check_permissions($required)//checking current user's permission
    {
        $user_type = $this->session->userdata('user_type');//current user
        if ($required == 'user') {
            return isset($user);

        } elseif ($required == 'author') {
            return $user_type == 'author' || $user_type == 'admin';

        } elseif ($required == 'admin') {
            return $user_type == 'admin';
        }
    }

    function editpost($post_id)//Edit post page
    {
        if (!$this->check_permissions('author'))//when the user is not an admin and author
        {
            redirect(base_url() . 'index.php/users/login');
        }
        $data['success'] = 0;

        if ($this->input->post()) {
            $data = array('post_title' => $this->input->post('post_title'), 'post' => $this->input->post('post'), 'active' => 1);
            $this->m_db->update_post($post_id, $data);
            $data['success'] = 1;
        }
        $data['post'] = $this->m_db->get_post($post_id);

        $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
        $this->load->view('header', $class_name);
        $this->load->view('v_edit_post', $data);
        $this->load->view('footer');
    }

    function deletepost($post_id)//delete post page
    {
        if (!$this->check_permissions('author'))//when the user is not an andmin and author
        {
            redirect(base_url() . 'index.php/users/login');
        }
        $this->m_db->delete_post($post_id);
        redirect(base_url() . 'index.php/blog/');
    }
}
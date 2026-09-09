<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller
{
    /*
     * Page status value
     *
     * Published = 1
     * Unpublished = 0
     *
     * Page is_deleted values
     *
     * Not Deleted = 0
     * Deleted = 1
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('common_model');
        $this->load->model('general_model', 'general');
        $this->load->library('encryption');
        $this->load->helper('date');
        $this->load->library('pagination');

    }

    public function page_security()
    {
        $userdata = $this->session->userdata('user_data');
        if(!empty($userdata))
        {
			
            $roles = $this->config->item('roles_id');
            $role = $roles[$userdata['user_type']];
			
           switch($role)
        	{
				case "ICCR":
				redirect(site_url() . 'headquarter/dashboard');
				break;
				
			}
        }
        else
        {
            redirect(site_url() . 'home');
        }
        return $userdata;
    }

    public function viewPage()
    {
		
        $this->page_security();

        $data = array();
        $data['pages'] = $this->common_model->getAllPages();
        $this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/view_page',$data);
		$this->load->view('admin/footer_main');	
    }

    public function addPage()
    {
        $this->page_security();
		$this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/add_page');
		$this->load->view('admin/footer_main');	     
    }
	
	public function editPage($slug)
    {
        $this->page_security();
		$data = array();
		
		$data['page'] = $this->common_model->getAllPages($slug);
       
		if(empty($data))
        {
            $message = array('type'=>'error', 'message'=>'OOPS Something went wrong, please try again later !');
            $this->session->set_flashdata('message', $message);

            redirect(base_url('page/addPage'));
        }
        
		
        $this->load->view('admin/header_main');
		$this->load->view('admin/leftsidebar');
		$this->load->view('admin/edit_page',$data);
		$this->load->view('admin/footer_main');	
    }

    public function create()
    {
        $this->page_security();
		//$this->form_validation->set_rules('master_page_id', 'Page Category', 'required');
        $this->form_validation->set_rules('page_title', 'Title', 'required');
        $this->form_validation->set_rules('page_slug', 'Slug', 'required');
        $this->form_validation->set_rules('page_description', 'Description', 'required');

        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE)
        {
            $validation_errors = $this->form_validation->error_array();
			
            $message = array('type'=>'error', 'errors'=>$validation_errors);
            $this->session->set_flashdata('message', $message);

            redirect(base_url('admin/page/add'));
        }
        else
        {
            //$post = $this->security->xss_clean($this->input->post(NULL, TRUE)) ;
            $post = $this->input->post() ;
			$master_page_id = isset($post['master_page_id']) && !empty($post['master_page_id'])?$post['master_page_id']:0;
            $data = array(
				'master_page_id' => $master_page_id,
                'page_title' => $post['page_title'],
                'page_slug' => $post['page_slug'],
                'page_description' => $post['page_description'],
                'meta_title' => $post['meta_title'],
                'meta_keyword' =>trim($post['meta_keyword']),
                'meta_description' => trim($post['meta_description']),
                'status' => 1,
                'created_on' => date('Y-m-d H:i:s')
            );

            $lastId = $this->general->save('iccr_page', $data);

            if($lastId)
            {
				if($_FILES["page_main_image"]['name'] != "")
				{				
					$ext = pathinfo($_FILES["page_main_image"]['name'],PATHINFO_EXTENSION);
					$imgname = time().'.'.$ext;		  
					$target_file = 'assets/site/main/page_main_image/'.$imgname; 
					if(move_uploaded_file($_FILES["page_main_image"]["tmp_name"], $target_file)) 
					{
						$data = array(
							'page_main_image' => $imgname
						);
						$update_page_image = $this->general->update('iccr_page', $data,$post['page_slug']);
						if($update_page_image)
						{
							
						}else{
						$message = array('type'=>'error', 'message'=>'Unable to upload image..!');
						$this->session->set_flashdata('message', $message);

						redirect(base_url('admin/page/add'));	
						}
					}else{
						$message = array('type'=>'error', 'message'=>'Unable to upload image..!');
						$this->session->set_flashdata('message', $message);

						redirect(base_url('admin/page/add'));	
					}
				}
                $message = array('type'=>'success', 'message'=>'New page added successfully !');
                $this->session->set_flashdata('message', $message);

                redirect(base_url('admin/page/add'));
            }
            else{
                $message = array('type'=>'error', 'message'=>'Unable to add page, please try again !');
                $this->session->set_flashdata('message', $message);

                redirect(base_url('admin/page/add'));
            }
        }

    }

    public function update($page_slug)
    {
        $this->page_security();        
        $this->form_validation->set_rules('page_title', 'Title', 'required');		
        $this->form_validation->set_rules('page_description', 'Description', 'required');
       
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == FALSE)
        {
            $validation_errors = $this->form_validation->error_array();

            $message = array('type'=>'error', 'errors'=>$validation_errors);
            $this->session->set_flashdata('message', $message);

            redirect(base_url('admin/page/edit/').$page_slug);
        }
        else
        {
            //$post = $this->security->xss_clean($this->input->post(NULL, FALSE)) ;
			$post = $this->input->post();
			//$master_page_id = isset($post['master_page_id']) && !empty($post['master_page_id'])?$post['master_page_id']:0;
            $data = array(
				//'master_page_id' => $master_page_id,
                'page_title' => $post['page_title'],
                'page_description' => $post['page_description'],
                'meta_title' => $post['meta_title'],
                'meta_keyword' =>trim($post['meta_keyword']),
                'meta_description' => trim($post['meta_description']),
				'modified_on' => date('Y-m-d H:i:s')
				
            );

            $lastId = $this->general->update('iccr_page', $data, $page_slug);
			
				
				if($_FILES["page_main_image"]["name"] != "")
				{	
					$ext = pathinfo($_FILES["page_main_image"]['name'],PATHINFO_EXTENSION);
					$imgname = time().'.'.$ext;	
					
					$target_file = 'assets/site/main/page_main_image/'.$imgname; 
					
					if(move_uploaded_file($_FILES["page_main_image"]['tmp_name'], $target_file)) 
					{
						$data = array(
							'page_main_image' => $imgname
						);
						$update_page_image = $this->general->update('iccr_page', $data,$page_slug);
						if($update_page_image)
						{
							
						}else{
						$message = array('type'=>'errorupdate', 'message'=>'Unable to upload image..!');
						$this->session->set_flashdata('message', $message);
						redirect(base_url('admin/page/edit/').$page_slug);
						}
					}else{
						$message = array('type'=>'errorupdate', 'message'=>'Unable to upload image..!');
						$this->session->set_flashdata('message', $message);
						redirect(base_url('admin/page/edit/').$page_slug);
					}
				}
                $message = array('type'=>'success', 'message'=>'Page updated successfully !');
                $this->session->set_flashdata('message', $message);

                redirect(base_url('admin/page/edit/').$page_slug);
            
        }
    }

    public function changeStatus($id,$status)
	{
		
		try{
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        $data['status'] = $status;
			$data['id'] = $id;
					
			$status_dtl = $this->common_model->changeStatus($id,$data);
		  
			if($status_dtl){
			$this->session->set_flashdata('message', 'success');
			//$this->session->set_flashdata('message', 'Status Change Sucessfully!');
			redirect($actual_link);	
			}else{
			$this->session->set_flashdata('message', 'error');
			//$this->session->set_flashdata('message', 'Something wrong. Please try again later!');
			redirect($actual_link);		
			}						
	            		
	            
        	
		}
		catch(Exception $e)
		{
	 		$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time');
			redirect($actual_link);				 
		}
	}

    public function destroy()
    {     
		//$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $_REQUEST['pageid'];
		
		$sts = $this->general->delete($id);
		if($sts)
		{
			$response = TRUE;
		}
		else
		{
			 $response = FALSE;
		}
		echo $response;
	
    }


    public function page($slug)
    {
        $this->load->model('general_model', 'general');
        $banners = $this->general->getByCriteria(array('is_deleted'=>0, 'status'=>1, 'banner_name'=>'Main Banner'), 'ref_banner');
        $bannerId = $banners[0]['id'];

        $data['bannerImages'] = $this->general->getByCriteria(array('is_deleted'=>0, 'status'=>1, 'ref_banner_id'=> $bannerId), 'ref_banner_slide');
        $page = $this->general->getByCriteria(array('slug'=>$slug, 'status'=>1), 'ref_page', array('id, title, slug, description, meta_title, meta_keyword, meta_description, status'));
        if(!empty($page)){
            $data['page'] = $page[0];
        }

        $this->load->view('main/header', $data);
		$this->load->view('main/page',$data);
		$this->load->view('main/footer');
    }
	
	public function pageslugunique_check($data)
        {
		$check_slug = $this->common_model->getAllPages($data);
			if (!empty($check_slug))
			{
					
					return FALSE;
			}
			else
			{
					return TRUE;
			}
        }
	public function getPageUpdateStatus()
        {
		$check_slug = $this->common_model->getAllPages($data);
			if (!empty($check_slug))
			{
					
					return FALSE;
			}
			else
			{
					return TRUE;
			}
        }	
	

}
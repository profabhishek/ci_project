<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('admin/usermodel');
		$this->load->model('admin/common_model');
		$this->load->model('admin/admin_model');
		$this->load->helper(array('url', 'form', 'date', 'security'));
		$this->load->library(array('encrypt', 'pagination', 'upload'));
		$this->load->library('form_validation');
	}

	public function index($limit = null)
	{		
		if (!empty($this->session->userdata('email')))
		{
			redirect('admin/dashboard');
		}
		$sewhere['user_type']='admin';
		$data['title'] = "Admin";		
	    $this->load->view('admin/header');	
		$this->load->view('admin/admin', $data);
	}
	public function addadmin()
	{
		$this->load->view('admin/header');	
			$this->load->view('admin/addadmin');
		
	}
	public function action($template="", $id=""){
		
		
		
        $data['title'] = "Admin";
        $this->load->view('admin/header', $data);
      //  $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        $setData = $this->input->post();
	switch ($template) {
	case "add":
	
	 //$clean = $this->input->post();
		 
		  // echo'<pre>';print_r($clean);die;
		  $admindata['name']= $setData['name'];
			$admindata['email']= $setData['email'];//
			$admindata['contactno']= $setData['contact'];//
			$admindata['user_type']= 'admin';
			$admindata['username']= $setData['username'];//
			$admindata['password']= md5($setData['password']);//
			$admindata['address']= $setData['address'];
			$admindata['gender']= $setData['gender'];
			$admindata['status']= $setData['status'];
			$id= $this->common_model->insert_data('adminuser',$admindata);
			
			
			if (empty($setData)) {
				
				
				 				  
				    $mesg = '<div class="alert alert-success" role="alert"><span>Due to some problem Admin not added.</span></div>';
                  
                    $this->session->set_flashdata('message', $mesg);
                    redirect('admin/addadmin');
				  
				  
                        

		   }else{
			   
			      				  
				    $mesg = '<div class="alert alert-success" role="alert"><span>Admin added successfully.</span></div>';
                  
                    $this->session->set_flashdata('message', $mesg);
                    redirect('admin/admin');
						
				   
		   }
        //$data['roles'] = $this->common_model->get_all_data('frm_role');
      //  if($setData){
          //  $this->form_validation->set_rules('username', 'User name', 'required|callback_chkUsername');
          //  $this->form_validation->set_rules('email', 'Email-ID', 'required|valid_email');
           // $this->form_validation->set_rules('password', 'Password', 'required|matches[confpass]');
           // $this->form_validation->set_message('matches', 'The %s field does not match.');
            //if( $this->form_validation->run() == FALSE ){
              //  $this->load->view('admin/addadmin', $data);
               // return;
           // }
           // else{

              //  $insData = array();
              //  if( count($setData['userrole']) ){
               //     foreach($setData['userrole'] as $usrole){
                 //       $dt['userid'] = $setData['userid'];
                 //       $dt['roleid'] = $usrole;
                //        $dt['status'] = '1';
               //         $insData[] = $dt;
               //     }
              //  }
            //    unset($setData['userrole']);
           //     unset($setData['confpass']);
           //     $setData['password'] = md5($setData['password']);
           //     $uid = $this->common_model->insert_data('users',$setData );
              //  if(count($insData))
              //      $res = $this->common_model->batch_insert_data('frm_userrole',$insData );

              //      $mesg = '<div class="alert alert-success alert-dismissable" role="alert"><span>User successfully added.</span>';
                 //   $mesg .= '<button class="close" data-dismiss="alert">&times;</button></div>';
                //    $this->session->set_flashdata('message', $mesg);
                //    redirect('admin/users/action/edit/'.$setData['userid']);

           // }
       // }
       // $this->load->view('admin/user_add', $data);
	break;
	case "edit":
	
	
        $where['id'] = $id;
        $dataSet['adminuser'] = $this->common_model->getRecords( $where,'adminuser');
       
      
        
        if($setData){
		//	
//$this->form_validation->set_rules('email', 'Email-ID');
			
          //  if( $this->form_validation->run() == FALSE ){
			//	 die('sgtop');
           //     $this->load->view('admin/addadmin', $dataSet);
           //     return;
           // }
           $admindata['name']= $setData['name'];
			$admindata['email']= $setData['email'];//
			$admindata['contactno']= $setData['contact'];//
			$admindata['user_type']= 'admin';
			$admindata['username']= $setData['username'];//
			$admindata['password']= md5($setData['password']);//
			$admindata['address']= $setData['address'];
			$admindata['gender']= $setData['gender'];
			$admindata['status']= $setData['status'];

            $res = $this->common_model->update_data('adminuser',$admindata, $where );
            //$userid = $this->common_model->get_data('adminuser', $where, ' id ')->id;

            //if($userid)
              //  $res = $this->common_model->update_data('adminuser',$admindata, $where );

            if($res){
                $mesg = '<div class="alert alert-success alert-dismissable" role="alert"><span>Admin credential edited successfully.</span>';
                $mesg .= '<button class="close" data-dismiss="alert">&times;</button></div>';
                $this->session->set_flashdata('message', $mesg);
                redirect('admin/admin');
            }

        }
        $this->load->view('admin/edit_admin', $dataSet);
        break;
	case "delete":
        $where = array('id' => $id);
		//$where1 = array('userid' => $id);
        $del = $this->common_model->delete_data('adminuser', $where);
       // $res = $this->common_model->delete_data('userrole', $where1);
		
        if($del)
		{
			    $mesg = '<div class="alert alert-success alert-dismissable" role="alert"><span>Admin successfully deleted.</span></div>';
                   
                    $this->session->set_flashdata('message', $mesg);
					
            redirect(base_url().'admin/admin/');
		}
	break;
    case "active":
        $status = array('status'=>'1');
        $where = array( 'id' => $id );
        $res = $this->common_model->update_data('adminuser', $status, $where );
        if($res)
            redirect(base_url().'admin/admin/');
	break;
    case "inactive":
        $status = array('status'=>'0');
        $where = array( 'id' => $id );
        $res = $this->common_model->update_data('adminuser', $status, $where );
        if($res)
            redirect(base_url().'admin/admin/');
    break;
	default:
		$total_rows = $this->common_model->getnumRows('frm_merchanttype');
		$pageno=$_REQUEST['per_page'];
		if($pageno=="")$pageno=0;
		else $pageno=$pageno;
		$offset = ($pageno) ? $pageno : 0;
		$perpage = 20;
		$cpurl = base_url().'admin/merchant/type/'.$this->uri->segment(3);
		$dataset['pagination']= $this->Pagin($cpurl,$total_rows,$perpage);
		$dataset['merchant'] =  $this->common_model->getDataRows('frm_merchanttype',$perpage,$pageno);
		$this->load->view('admin/merchant_type', $dataset);
	}
	//$this->load->view('footer');
	}
		
			

	
}

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    public $status; 
    public $roles;    
    function __construct(){
        // Call the Model constructor
        parent::__construct();        
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }
	
	
	
	public function insertUser($d)
    {  
            $string = array(
                'first_name'=>$d['firstname'],
                'email'=>$d['email'],
			    'phone'=>$d['phone'],
                'role'=>$this->roles[0], 
				'password'=>md5($d['password']), 
                'status'=>$this->status[0]
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }
    
    public function isDuplicate($email)
    {     
        $this->db->get_where('users', array('email' => $email), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }
    
    public function insertToken($user_id)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');
        
        $string = array(
                'token'=> $token,
                'user_id'=>$user_id,
                'created'=>$date
            );
        $query = $this->db->insert_string('tokens',$string);
        $this->db->query($query);
        return $token . $user_id;
        
    }
	
	
	public function isTokenValid($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn, 
            'tokens.user_id' => $uid), 1);      
        
        if($this->db->affected_rows() > 0){
            $row = $q->row();             
            
            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d'); 
            $todayTS = strtotime($today);
            
            if($createdTS != $todayTS){
                return false;
            }
            
            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
            
        }else{
            return false;
        }
        
    }
	
	public function updateUserInfo($post)
    {
        $data = array(
               'password' => $post['password'],
               'last_login' => date('Y-m-d h:i:s A'), 
               'status' => $this->status[1]
            );
        $this->db->where('id', $post['user_id']);
        $this->db->update('users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updateUserInfo('.$post['user_id'].')');
            return false;
        }
        
        $user_info = $this->getUserInfo($post['user_id']); 
        return $user_info; 
    }
	
	
	public function checkLogin($data)
    {
            
        	
		
		
		  $email =$data['email'];		
        		 
		   $encrypt_password = md5(trim($data['password']));
				$this->db->select('*');
				$this->db->from('users');
				$this->db->where('email',$email);
				$this->db->where('status','1');
			    $this->db->where('password',$encrypt_password);
				$rs=$this->db->get();
	
				if($rs->num_rows()>0)
				 { 
				 
					   $row = $rs->row();
					   $datas = array(
									 'userid'=> $row->id,
									 'fname'=> $row->name,
									 'email'=> $row->email																		
									);
					  $this->session->set_userdata('user_data',$datas);
					  
					
					  
					  return true;
					 }else{
						 
						   $this->session->set_flashdata('loginerror', '<div class="error" style="color:red;">Please enter valid login/password</div>');
					 return false;
					}
		
		
		
    }
    
    public function updateLoginTime($id)
    {
        $this->db->where('id', $id);
        $this->db->update('users', array('last_login' => date('Y-m-d h:i:s A')));
        return;
    }
	
	
	public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('users', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$email.')');
            return false;
        }
    }
	
	public function getUserInfo($id)
    {
        $q = $this->db->get_where('users', array('id' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }
	
	
	
	
	
} 


?>
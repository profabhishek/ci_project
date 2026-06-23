<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    public $status; 
    public $roles;    
    function __construct(){
        // Call the Model constructor
        parent::__construct();   
        $this->load->database();     
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }
    function updateLogin($uid)
    {
		$data = array(
			'last_login'=>date('Y-m-d H:i:s A')			
        );
        $this->db->where('id', $uid);
        $this->db->update('iccr_users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE;
	}
    function updateProfile($post)
    {
		$data = array(
			'first_name'=>$post['fullname'],
			'phone'=>$post['mobile_number'],
			'email'=>$post['useremail']
        );
        $this->db->where('id', $post['userid']);
        $this->db->update('users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE;
	}
	function updateProfileAgent($post)
	{
		$data = array(
			'first_name'=>$post['fullname'],
			'phone'=>$post['mobile_number'],
			'company'=>$post['company'],
			'ceano'=>$post['cea_number']
        );
        $this->db->where('id', $post['userid']);
        $this->db->update('users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE;
	}
    function insertFbUser($post)
    {
		try
		{
			$string = array(
            	'username'=>$post['email'],
                'first_name'=>$post['name'],
                'email'=>$post['email'],
			    'phone'=>$post['mobile'],
                'role'=>$this->roles[0], 
				'password'=>"", 
				'user_type'=>$post['user_type'],
                'status'=>$this->status[1],
                'facebookid'=>$post['fbid']
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return 0;
		}
	}
	
	function getUserImage($uid)
    {              
      $this->db->select('*');
      $this->db->from('user_profile_image');
	  $this->db->where('userid',$uid);
      $rs = $this->db->get();
	  if($rs->num_rows()>0) 
		{
		   $row = $rs->row();
		   $imgrow = array(
			 'userid'=> $row->userid,
			 'image'=> $row->image					
			);
		  return $imgrow;
		 }
		 else
		 return array();
    }
	function updateUserImage($post)
	{
		$data = array(
               'image'=>$post['image']
        );
        $this->db->where('userid', $post['userid']);
        $this->db->update('user_profile_image', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE; 
	}
	function insertUserImage($image)
	{
		$string = array(
        	'userid'=>$image['userid'],
            'image'=>$image['image'],
            'status'=>$this->status[1]
        );
        $q = $this->db->insert_string('user_profile_image',$string);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
    public function insertUserFromMobile($d)
    {  
            $string = array(
            	'username'=>$d['username'],
                'first_name'=>$d['firstname'],
                'email'=>$d['email'],
			    'phone'=>$d['phone'],
                'role'=>$this->roles[0], 
				'password'=>md5($d['password']), 
				'user_type'=>$d['user_type'],
                'status'=>$this->status[1]
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }
    function insertStudentDetails($d)
    {
		 $string = array(
            	'country_of_domicile'=>$d['country'],
                'gender'=>$d['gender'],	
				'date_of_birth'=>$d['applicant_date']."/".$d['applicant_month']."/".$d['applicant_year'],
				'mobile_number'=>$d['mobile_no'],
                'currently_in_india'=>$d['isindian'],
                'created'=>date('Y-m-d h:i:s'),
                'uid' => $d['uid']
            );
            $q = $this->db->insert_string('iccr_student_details',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
	}
	public function insertUser($d)
    {  
            $string = array(
            	'username'=>$d['username'],
                'email_id'=>$d['emailId'],	
				'password'=>$d['password'],
				'user_type'=>1,
                'status'=>0,
                'created'=>date('Y-m-d h:i:s'),
                'state'=>0,
                'user_country'=>$d['country'],
                'dir'=>$d['dir']
            );
            $q = $this->db->insert_string('iccr_users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }    
    public function isDuplicate($email)
    {     
        $this->db->get_where('iccr_users', array('email_id' => $email), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }
	public function isDuplicateEmail($email)
    {    
	
	   //$email =$data['username'];
	   //echo $email;die;
	  //$previousYear = '2019';
       $sql = "select email_id,created from iccr_users where email_id = '".$email."'" ;
	   //$sql = "select * from iccr_users where email_id = '".$email."' and date(created) >= date '2019-12-01' and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.") and status = '1'";
	   $rs = $this->db->query($sql)->row();
	   if($rs > 0){
            return true;
		}else{
			
			return false;
		}       
    }
	
	/* public function checkLoginYear($data,$year)
    {     
	
	   $email =$data['username'];
       $sql = "select * from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year." and status = '1'" ;
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    } */
	
	
		 public function checkLoginYear($data,$year)
    {     
	   $previousYear = '2019';
	   $email =$data['username'];
       $sql = "select * from iccr_users where email_id = '".$email."' and date(created) >= date '2019-12-01' and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.") and status = '1'";
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    } 
	public function checkForgetYear($email,$year)
    {     
	
	   
       $sql = "select * from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year." and status = '1'" ;
	   $rs = $this->db->query($sql)->num_rows();
	   if($rs > 0){
            return COUNT($rs);
		}else{
			
			return false;
		}       
    }
	public function checkForgetPassForOthers($email,$year,$data){		
		$token = $data['token'];
		$pass_count = $data['pass_updated_count'];
		$sql = "UPDATE iccr_users SET token = '".$token."', `pass_updated_count` = '".$pass_count."' WHERE  email_id = '".$email."'" ;
		$rs = $this->db->query($sql);
		if($rs){
			return true;			
		}else{			
			return false;
		}
	}
	
	
		public function checkType($data)
    {     
	   $status = 1;
	   $email =$data['username'];
       $sql = "select * from iccr_users where email_id = '".$email."' and status = ".$status."" ;
	   $rs = $this->db->query($sql)->row();
	   if($rs > 0){
            return $rs;
		}else{
			
			return false;
		}       
    }
	
    public function isDuplicateFb($fbid)
    {     
        $this->db->get_where('users', array('facebookid' => $fbid), 1);
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
        $query = $this->db->insert_string('iccr_tokens',$string);
        $this->db->query($query);
        return $token . $user_id;
        
    }	
	public function isTokenValid($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
        $q = $this->db->get_where('iccr_tokens', array(
            'iccr_tokens.token' => $tkn, 
            'iccr_tokens.user_id' => $uid), 1);      
        
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
	public function updatePassword($post)
	{
		$data = array(
               'password' => $post['password']
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
	public function updateUserInfo($post)
    {
        $data = array(
               'password' => $post['password'],
               'last_login' => date('Y-m-d h:i:s A'), 
               'status' => $this->status[1]
            );
        $this->db->where('id', $post['user_id']);
        $this->db->update('iccr_users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updateUserInfo('.$post['user_id'].')');
            return false;
        }
        
        $user_info = $this->getUserInfo($post['user_id']); 
        return $user_info; 
    }
    function updateUserProfile($post){
		try
		{
			$string = array(
                'first_name'=>$post['name'],
                'email'=>$post['email'],
			    'phone'=>$post['mobile'],
			    'user_profile_image'=>$post['user_image']
            );
            $this->db->where('id', $post['user_id']); 
            $q = $this->db->update('users',$string); 
                       
            $success = $this->db->affected_rows($q);
                        
	        if(!$success){
	            //error_log('Unable to update User Profile');
	            return FALSE;
	        }
	        return TRUE;
		}
		catch(Exception $e)
		{
			return FALSE;
		}
	}
	function updateUserRegistration($post)
	{
		try
		{
			$string = array(
            	'username'=>$post['phone'],
                'first_name'=>$post['firstname'],
                'email'=>$post['email'],
			    'phone'=>$post['phone'],
                'role'=>$this->roles[0], 
				'password'=>"", 
				'user_type'=>$post['user_type'],
                'status'=>$this->status[1]
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            $id = $this->db->insert_id();            
	        if($id <= 0){
	            error_log('Unable to updateUserRegistration()');
	            return FALSE;
	        }
	        return TRUE;
		}
		catch(Exception $e)
		{
			return FALSE;
		}
	}
	function checkFbLogin($post)
	{
		$fbid =$post['fbid'];		        	
    	$condition = array("facebookid"=>$fbid,"status"=>"1");
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$rs=$this->db->get();
		if($rs->num_rows()>0) 
		{
		   $row = $rs->row();
		   $datas = array(
			 'userid'=> $row->id,
			 'fname'=> $row->first_name,
			 'email'=> $row->email,
			 'user_type'=> $row->user_type,
			 'user_image'=> $row->user_profile_image,	
			 'phone'=> $row->phone,
			 'facebookid'=>$row->facebookid								
			);
		   $this->session->set_userdata('user_data',$datas);
		   return true;
		 }
		 else
		 {
			$this->session->set_flashdata('loginerror', '<div class="error" style="color:red;">Please enter valid login/password</div>');
			return false;
		 }
	}
	public function checkUsersLogin($data)
	{
		$email = $data['username'];		        		 
		$encrypt_password = md5(trim($data['pass']));
    	$condition = array("email_id"=>$email,"status"=>"1","password"=>$encrypt_password);
    	
		$this->db->select('*');
		$this->db->from('iccr_allusers');
		$this->db->where($condition);
		$rs=$this->db->get();
		if($rs->num_rows()>0) 
		{
		   $row = $rs->row();
		   return $row;
		 }
		 else
		 {			
			return false;
		 }
	}
	public function checkLogin($data)
    {
    	$email =$data['username'];		        		 
		//$encrypt_password = md5(trim($data['pass']));
    	$condition = array("email_id"=>$email,"status"=>"1");
		$this->db->select('*');
		$this->db->from('iccr_users');
		$this->db->where($condition);
		$rs=$this->db->get();
		if($rs->num_rows()>0) 
		{
		   $row = $rs->row();
		   return $row;
		 }
		 else
		 {			
			return false;
		 }
    }
    public function checkLoginmobile($data)
    {    	
    	$phone = $data['mobile'];		
    	$condition = array("username"=>$phone);
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$rs=$this->db->get();
		if($rs->num_rows()>0)
		{ 		 
		   $row = $rs->row();
		   $datas = array(
			 'userid'=> $row->id,
			 'fname'=> $row->first_name,
			 'email'=> $row->email,
			 'user_type'=> $row->user_type																		
			);
		  $this->session->set_userdata('user_data',$datas);
			return TRUE;
		}else{
			/*$string = array(
            	'username'=>$phone,
                'first_name'=>"",
                'email'=>"",
			    'phone'=>$phone,
                'role'=>$this->roles[0], 
				'password'=>"", 
                'status'=>$this->status[0]
            );
            $q = $this->db->insert_string('users',$string); 
                        
            $this->db->query($q);
            $this->db->insert_id();*/
			return FALSE;
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
	function getUserInfoByFbId($id)
    {
        $q = $this->db->get_where('users', array('facebookid' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }
	public function getUserInfo($id)
    {
        $q = $this->db->get_where('iccr_users', array('id' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }
    public function getUserInfoById($id)
    {
    	try{
			$q = $this->db->get_where('iccr_users', array('id' => $id), 1);  
	        if($this->db->affected_rows() > 0){
	            $row = $q->row();
	            return $row;
	        }else{	          
	            return array();
	        }
		}
		catch(Exception $e)
		{
			
		}
    }
	
	//==============================Added by Rahul dey 24-01-2019===========================
	public function insertFeedbackDetails($post)
    {
    	try
		{
			$string = array(
                'name'=>$post['name'],
			    'mobile_no'=>$post['mobile_no'],
				'emailid'=>$post['emailid'],
                'comment'=>$post['comment'],
                'user_ip_address'=>$_SERVER['REMOTE_ADDR']
            );
            $q = $this->db->insert_string('iccr_feedback',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return 0;
		}
    }
	
		public function checkForgotLoginYear($email,$year = null)
    {     
	
       $sql = "select * from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year." and status = '1'";
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    }
    
    	public function checkForgotType($email)
    {     
	   $status = 1;
       $sql = "select * from iccr_users where email_id = '".$email."' and status = ".$status."" ;
	  
	   $rs = $this->db->query($sql)->row();
	   
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    }
    
    	public function checkForgot($email)
    {     
	
       $sql = "select * from iccr_users where email_id = '".$email."' and status = '1'";
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    }
	
	public function checkForgetType($email)
    {     
	   
      $sql = "select * from iccr_users where email_id = '".$email."' and status = '1'" ;
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    }
	
	
	public function checkForgetWithType($email,$year)
    {     
	   
      //$sql = "select * from iccr_users where email_id = '".$email."' and date(created) >= date '2019-12-01' and YEAR(created) = '".$year."' and status = '1'" ;
	  
	   $previousYear = '2019';
       $sql = "select * from iccr_users where email_id = '".$email."' and date(created) >= date '2019-12-01' and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.") and status = '1'";
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return count($rs);
		}else{
			
			return false;
		}       
    }
	
	
	public function checkForgetWithoutYear($email)
    {     
	
	   
       $sql = "select * from iccr_users where email_id = '".$email."' and status = '1'" ;
	   $rs = $this->db->query($sql)->num_rows();
	   if($rs > 0){
            return COUNT($rs);
		}else{
			
			return false;
		}       
    }
	
	
	public function checkForgetPass($email,$year=null,$data){
		$token = $data['token'];
		$pass_count = $data['pass_updated_count'];
		$sql = "UPDATE iccr_users SET token = '".$token."', `pass_updated_count` = '".$pass_count."' WHERE  email_id = '".$email."'";
		
		if(!empty($year))
		{
			//$sql .=" and YEAR(created) ='".$year."'";
			$previousYear = '2019';
			//$sql .=" and YEAR(created) ='".$year."'";
			$sql .= " and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.") and status = '1'";
		}
		
		$rs = $this->db->query($sql);
		if($rs){
			return true;
			
		}else{
			
			return false;
		}
	}
	public function checkPassportYeartest($pass_no,$year)
    {     
		//echo "<pre>";
		//print_r($pass_no);
		//print_r($email);die;
       $sql = "select * from iccr_student_application_details where passport_no = '".$pass_no."' and YEAR(created) = ".$year."" ;
	   //echo $sql;die;
	   //echo $this->db->_compile_select();
	   $rs = $this->db->query($sql)->row();
	   
	   if($rs > 0){
            return true;
		}else{
			
			return false;
		}       
    }
	
		public function checkPassportYear($pass_no,$course,$year)
    {     
       $sql = "select * from iccr_student_application_details  
	   where passport_no = '".$pass_no."' and course_type = '".$course."'and YEAR(created) = ".$year."" ;
	    //$sql = "select * from iccr_student_application_details where email = '".$email."' and passport_no = '".$pass_no."' and YEAR(created) = ".$year."" ;
	   //echo $sql;die;
	   //echo $this->db->_compile_select();die;
	   $rs = $this->db->query($sql)->row();
	   //print_r($rs);die;
	   if($rs > 0){
            return true;
		}else{
			
			return false;
		}      
    }
	
		public function isValidAluminiEmail($data)
    {
    		        		 
		
    	$condition = array("email"=>$data);
		$this->db->select('*');
		$this->db->from('iccr_alumni_data');
		$this->db->where($condition);
		$rs=$this->db->get();
		if($rs->num_rows()>0) 
		{
		   $row = $rs->row();
		   return $row;
		 }
		 else
		 {			
			return false;
		 }
    }
		public function checkSubmitDetails($id)
    {     
	
	   $sql = "select * from iccr_student_application_details where programme != 4 AND uid = ".$id."";
       //$sql = "select * from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year." and status = '1'" ;
	   //echo $sql;die;
	   $rs = $this->db->query($sql)->row();
	   /* if($rs > 0){
		    $cyear = $rs->created;
			$chyear = explode('-',$cyear);
			$yr =$chyear[0]; 
			
			if($yr == '2019'){
				
			}
	   } */
	  
	   if($rs > 0){
            return $rs;
		}else{
			
			return false;
		}       
    }
	public function __destruct(){
		
		$this->db->close();
	}
	
} 


?>
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
	
	function updateUserPassport($post)
	{
		$data = array(
               'passport_file'=>$post['passport_file']
        );
        $this->db->where('id', $post['userid']);
        $this->db->update('iccr_users', $data); 
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
				'passport_no'=>$d['passport_no'],
				'date_of_birth'=>$d['applicant_date']."/".$d['applicant_month']."/".$d['applicant_year'],
				'mobile_number'=>$d['mobile_no'],
                'currently_in_india'=>$d['isindian'],
                'created'=>date('Y-m-d h:i:s'),
				'student_type'=>1,
				'apply_course_type'=>$d['apply_course_type'],
                'uid' => $d['uid'],
				'father_fname'=>$d['father_fname'],	
				'father_mname'=>$d['father_mname'],	
				'father_lname'=>$d['father_lname'],	
				'mother_fname'=>$d['mother_fname'],	
				'mother_mname'=>$d['mother_mname'],	
				'mother_lname'=>$d['mother_lname'],
           		'gurdian_fname'=>$d['gurdian_fname'],	
				'gurdian_mname'=>$d['gurdian_mname'],	
				'gurdian_lname'=>$d['gurdian_lname'],
            );	
	
		
            $q = $this->db->insert_string('iccr_student_details',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
	}
	public function insertUser($d)
    {  

			$string = array(
                'parent_type'=>$d['parent_type'],
            	'username'=>$d['username'],
				'student_mname'=>$d['student_mname'],
				'student_lname'=>$d['student_lname'],
                'email_id'=>$d['emailId'],	
				'password'=>$d['password'],
				'student_title'=>$d['student_title'],
				'unique_id'=>$d['unique_id'],
				'mobile_no'=>$d['mobile_no'],
				'user_type'=>1,
                'status'=>1,
				'apply_course_type'=>$d['apply_course_type'],
                'created'=>date('Y-m-d h:i:s'),
                'state'=>0,
				'student_type'=>1,
                'user_country'=>$d['country'],
              	'passport_file' => $d['passport_file'],
                'dir'=>$d['dir']
            );  
            $q = $this->db->insert_string('iccr_users',$string);   
            $this->db->query($q);
            return $this->db->insert_id();
    }	
	///////////////new otp 3-4-2024////////////3
	
	
	public function insertOTP($d)
    {  
 
			$string = array(
            	'email'=>$d['email'],
				'otp'=>$d['otp'],
				'otp_count'=>$d['otp_count'],
                'created_at'=>$d['created_at'],	
				'updated_at'=>$d['updated_at']
            );
            $q = $this->db->insert_string('iccr_users_otp',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }
	
	function updateOTP($post)
	{
		/* print_r($post);
		die; */
		$data = array(
				'otp'=>$post['otp'],
				'otp_count'=>$post['otp_count'],
				'updated_at'=>$post['updated_at'],
				
        );
        $this->db->where('email', $post['email']);
        $this->db->update('iccr_users_otp', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE; 
	}

	function updateValidOTP($post)
	{
		/* print_r($post);
		die; */
		$data = array(
				'verify_status'=>!empty($post['verify_status']) ? $post['verify_status'] : 0,
				'valid_otp_count'=>!empty($post['valid_otp_count']) ? $post['valid_otp_count'] : Null,
        );
        $this->db->where('email', $post['email']);
        $this->db->update('iccr_users_otp', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE; 
	}
	
	function getUserOTPData($user_email) {
        $this->db->select('*');
		$this->db->from('iccr_users_otp');
        $this->db->where('email', $user_email);
        $code = $this->db->error();
        if ($code['code'] > 0) {
        }
        return $this->db->get()->row();
    }

	
    public function isDuplicate($email)
    {     
        $this->db->get_where('iccr_users', array('email_id' => $email), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }
	public function isDuplicatePassport($passport, $year)
    {     
       //$sql = "select email_id,created from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year."" ;
	   $sql = "select usrs.email_id,usrs.id,usrs.created from iccr_users usrs join iccr_student_details stds on usrs.id = stds.uid where stds.passport_no = '".$passport."' and YEAR(usrs.created) = ".$year."";
	   //echo $sql;die;
	   $rs = $this->db->query($sql)->row();
	  if(is_object($rs)){
            return true;
		}else{
			
			return false;
		}       
    }
	
	public function isDuplicateEmail($email,$year)
    {     
       $sql = "select email_id,created from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year."" ;
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return true;
		}else{
			
			return false;
		}       
    }
	// public function isDuplicateData($fname,$fmname,$flname,$mname,$mmname,$mlname,$year)
    // {     
       // $sql = "select father_fname,mother_fname,date_of_birth,created from iccr_student_details where father_fname = '".$fname."' and father_mname = '".$fmname."' and father_lname = '".$flname."' and mother_fname = '".$mname."' and mother_mname = '".$mmname."' and mother_lname = '".$mlname."' and YEAR(created) = ".$year."" ;
	   // $rs = $this->db->query($sql)->row();
	   // if(is_object($rs)){
            // return true;
		// }else{   
			 
			// return false;
		// }       
    // }
	
	public function isAluminiDuplicateEmail($email)
    {     
       $sql = "select email,created from iccr_alumni_data where email = '".$email."" ;
	   $rs = $this->db->query($sql)->row();
	   if($rs > 0){
            return true;
		}else{
			
			return false;
		}       
    }
	
	public function checkLoginYear($data,$year)
    {     

	   //$reg_chyear = explode('-',$year);
	   //$reg_previous_yr =$reg_chyear[0]; 
	   //$reg_curent_yr =$reg_chyear[1];
	   $previousYear = '2021';
	   $email =$data['username'];
	   if($year=='2022'){
		   $dateY = '2022-02-09';
	   }
	   else if($year=='2023'){
		    $dateY = '2023-02-09';
	   }
	   else if($year=='2024'){
		$dateY = '2024-02-09';
	   }
	   else if($year=='2025'){
		$dateY = '2025-02-09';
	   }
 	else if($year=='2026'){
		$dateY = '2026-02-09';
	   }

	   else{
		   $dateY = '2021-02-09';
	   }
	   // and user_country != 1
	   // Rewritten to avoid wrapping "created" in date(...)/YEAR(...): those
	   // functions prevent MySQL from using any index on created, forcing a
	   // full table scan on every login. The range comparisons below match
	   // exactly the same rows (created is a datetime column) but let the
	   // query planner use an index if one exists.
	   $yearInt = (int)$year;
	   $prevYearInt = (int)$previousYear;
	   $sql = "select * from iccr_users where email_id = '".$email."' and created > '".$dateY." 00:00:00' and (
	                (created >= '".$yearInt."-01-01 00:00:00' and created < '".($yearInt+1)."-01-01 00:00:00')
	             or (created >= '".$prevYearInt."-01-01 00:00:00' and created < '".($prevYearInt+1)."-01-01 00:00:00')
	           ) and status = '1'";

	   /* $sql = "select * from iccr_users where email_id = '".$email."' and user_country != 1 and apply_course_type != 10 and date(created) > date '2022-02-09' and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.") and status = '1'"; */
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
	  
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}        
    }
	
	public function checkLoginYearSfs($data,$year)
    {     
	
	   //$reg_chyear = explode('-',$year);
	   //$reg_previous_yr =$reg_chyear[0]; 
	   //$reg_curent_yr =$reg_chyear[1];
	   $previousYear = '2021';
	   $email =$data['username'];
	   $sql = "select * from iccr_users where email_id = '".$email."' and date(created) > date '2021-10-01' and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.") and status = '1'";
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
	  
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}        
    }
	public function checkLoginSubmitYear($data,$year)
    {     
	
	   //$reg_chyear = explode('-',$year);
	   //$reg_previous_yr =$reg_chyear[0]; 
	   //$reg_curent_yr =$reg_chyear[1];
	   $previousYear = '2021';
	   $email =$data['username'];
	   $sql = "select * from iccr_users where email_id = '".$email."' and date(created) >= date '2021-03-15' and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.")";
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
	  
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}        
    }
	
	
	
	
	public function checkSubmitDetails($id)
    {      
		//$sql = "select status from iccr_student_application_details where uid = ".$id."";
		//$sql = "select * from iccr_users where id = ".$id."";
	   //$sql = "select isap.status,iu.student_type from iccr_student_application_details isap join iccr_users iu on iu.id = isap.uid where uid = ".$id."";
       //$sql = "select * from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year." and status = '1'" ;
	   //echo $sql;die;
	 //  $rs = $this->db->query($sql)->row();
	   $rs = $this->db->get_where('iccr_student_application_details',array('uid'=>$id))->row();
	   /* if($rs > 0){
		    $cyear = $rs->created;
			$chyear = explode('-',$cyear);
			$yr =$chyear[0]; 
			
			if($yr == '2019'){
				
			}
	   } */
	  
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}      
    }
	
	public function checkPhdSubmitDetails($id)
    {     
		$sql = "select status from iccr_users where apply_course_type = 4 and id = ".$id."";
		//$sql = "select * from iccr_users where id = ".$id."";
	   //$sql = "select isap.status,iu.student_type from iccr_student_application_details isap join iccr_users iu on iu.id = isap.uid where uid = ".$id."";
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
	  
	   if(is_object($rs)){
            return true;
		}else{
			
			return false;
		}       
    }
	public function checkayushsSubmitDetails($id)
    {     
		$sql = "select status from iccr_users where apply_course_type = 10 and id = ".$id."";
		//$sql = "select * from iccr_users where id = ".$id."";
	   //$sql = "select isap.status,iu.student_type from iccr_student_application_details isap join iccr_users iu on iu.id = isap.uid where uid = ".$id."";
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
	  
	   if(is_object($rs)){
            return true;
		}else{
			
			return false;
		}       
    }
	
	public function checkCountryDetails($id)
    {     

		$sql = "select user_country from iccr_users where id = ".$id."";
	   
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}        
    }
		public function checkAyushSubmitDetails($id)
    {     
	
		
	   $sql = "select * from iccr_student_application_details where course_type = 1 and uid = ".$id."";
       //$sql = "select * from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year." and status = '1'" ;
	   //$sql = "select ip.id,sd.student_type from iccr_student_application_details ip join iccr_student_details sd on sd.uid = ip.uid where course_type = 1 and sd.student_type != 2 and ip.uid = ".$id."";
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
	
	public function checkUserStatus($id)
    {     
	
	   $sql = "select * from iccr_status_mapping where uid = ".$id."";
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
	
	public function checkForgetYear($email,$year)
    {     
	
	   
       $sql = "select * from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year." and status = '1'" ;
	   $rs = $this->db->query($sql)->num_rows();
	   if($rs > 0){
            return $rs;
		}else{

			return false;
		}
    }
	
	
	
	public function checkForgetPass($email=null,$year=null,$data=null){
		
		//echo $email;
		//echo $year;
		//print_r($data);die;
		$token = $data['token'];
		$pass_count = $data['pass_updated_count'];
		$sql = "UPDATE iccr_users SET token = '".$token."', `pass_updated_count` = '".$pass_count."' WHERE  email_id = '".$email."'";
		
		if(!empty($year))
		{
			
			//$sql .=" and YEAR(created) ='".$year."'";
			$sql .= " and YEAR(created) = ".$year."  and status = '1'";
		}
		
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
       // Rewritten to compare "created" directly against a literal instead of
       // wrapping it in date(...): DATE(created) >= ... can't use an index on
       // created, forcing a full table scan on every login. This is logically
       // identical (created is a datetime, so >= midnight covers the same range).
       $sql = "select id,email_id,user_type,apply_course_type from iccr_users where email_id = '".$email."' and created >= '2021-03-15 00:00:00' and status = ".$status."" ;
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
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
	
	public function isValidAluminiEmail($data)
    {
			        		 
		//$encrypt_password = md5(trim($data['pass']));
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
	
	
	
		public function checkForgetType($email,$year)
    {     
		$sql = "select * from iccr_users where email_id = '".$email."' and date(created) > date '2021-03-15' and YEAR(created) = ".$year." and status = '1'";
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    }
	
	
	public function checkForget($email)
    {     
	
	   
       $sql = "select * from iccr_users where email_id = '".$email."' and status = '1'" ;
	   $rs = $this->db->query($sql)->num_rows();
	   //echo $rs;die;
	   if($rs > 0){
            return $rs;
		}else{

			return false;
		}
    }
	
	
	public function checkForgetWithoutYear($email)
    {     
	
	   
       $sql = "select * from iccr_users where email_id = '".$email."' and status = '1'" ;
	   $rs = $this->db->query($sql)->num_rows();
	   if($rs > 0){
            // $rs is already a row count (int) from num_rows(); COUNT($rs)
            // is invalid in PHP 8 (count() requires an array/Countable and
            // throws a fatal TypeError on a plain int).
            return $rs;
		}else{

			return false;
		}
    }
	
	
	public function checkForgetWithType($email,$year)
    {     
	  
	  
	   $sql = "select * from iccr_users where email_id = '".$email."' and YEAR(created) = ".$year." and status = '1'";
	   $rs = $this->db->query($sql)->row();
		 
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    }
	
	
	public function checkYear($pass_no,$year)
    {     
	    //echo "<pre>";
		//print_r($pass_no);
		//print_r($email);
		//print_r($year);die;
       $sql = "select iu.created,sd.university_is_accept,sd.application_id from iccr_student_application_details 
	   JOIN iccr_university_response sd ON sd.application_id = iccr_student_application_details.application_no
	   JOIN iccr_users iu ON iu.id = iccr_student_application_details.uid
	   where passport_no = '".$pass_no."' and YEAR(iccr_student_application_details.created) = ".$year."" ;
	    //$sql = "select * from iccr_student_application_details where email = '".$email."' and passport_no = '".$pass_no."' and YEAR(created) = ".$year."" ;
	   //echo $sql;die;
	   //echo $this->db->_compile_select();die;
	   $rs = $this->db->query($sql)->row();
	   //print_r($rs);die;
	   if($rs > 0){
            return $rs;
		}else{
			
			return false;
		}       
    }
	
	public function checkPassportYear($pass_no,$year)
    {     
	    //echo "<pre>";
		//print_r($pass_no);
		//print_r($email);
		//print_r($year);die;
       $sql = "select * from iccr_student_application_details where passport_no = '".$pass_no."' and YEAR(created) = ".$year."" ;
	    //$sql = "select * from iccr_student_application_details where email = '".$email."' and passport_no = '".$pass_no."' and YEAR(created) = ".$year."" ;
	   //echo $sql;die;
	   //echo $this->db->_compile_select();die;
	   $rs = $this->db->query($sql)->row();
	   //print_r($rs);die;
	   if($rs > 0){
            return $rs; 
		}else{
			
			return false;
		}       
    }
	
	public function checkUniqueIdYear($pass_no,$year)
    {     
	    //echo "<pre>";
		//print_r($pass_no);
		//print_r($email);
		//print_r($year);die;
       $sql = "select unique_id from iccr_student_application_details where unique_id = '".$pass_no."' and YEAR(created) = ".$year."" ;
	    //$sql = "select * from iccr_student_application_details where email = '".$email."' and passport_no = '".$pass_no."' and YEAR(created) = ".$year."" ;
	   //echo $sql;die;
	   //echo $this->db->_compile_select();die;
	   $rs = $this->db->query($sql)->row();
	   //print_r($rs);die;
	   if($rs > 0){
            return $rs; 
		}else{
			
			return false;
		}       
    }
	
	
		public function insertSfsUser($d)
    {  
            $string = array(
            	'username'=>$d['username'],
                'email_id'=>$d['emailId'],	
				'password'=>$d['password'],
				'user_type'=>1,
                'status'=>1,
                'created'=>date('Y-m-d h:i:s'),
                'state'=>0,
                'user_country'=>$d['country']
            );
            $q = $this->db->insert_string('iccr_sfs_users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    } 
	
	
	    function insertSfsStudentDetails($d)
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
            $q = $this->db->insert_string('iccr_sfs_student_details',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
	}
	
	public function isSfsTokenValid($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
        $q = $this->db->get_where('iccr_sfs_tokens', array(
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
            
            $user_info = $this->getSfsUserInfo($row->user_id);
            return $user_info;
            
        }else{
            return false;
        }
        
    }
	
	
	public function getSfsUserInfo($id)
    {
        $q = $this->db->get_where('iccr_sfs_users', array('id' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }
	
	
	 public function insertSfsToken($user_id)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');        
        $string = array(
                'token'=> $token,
                'user_id'=>$user_id,
                'created'=>$date
            );
        $query = $this->db->insert_string('iccr_sfs_tokens',$string);
        $this->db->query($query);
        return $token . $user_id;
        
    }
	
	public function updateSfsUserInfo($post)
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
        
        $user_info = $this->getSfsUserInfo($post['user_id']); 
        return $user_info; 
    }
	
	public function isDuplicateSfsEmail($email,$year)
    {     
       $sql = "select email_id,created from iccr_sfs_users where email_id = '".$email."' and YEAR(created) = ".$year."" ;
	   $rs = $this->db->query($sql)->row();
	   if($rs > 0){
            return true;
		}else{
			
			return false;
		}       
    }
	
	public function checkSfsType($data)
    {     
	   $status = 1;
	   $email =$data['username'];
       $sql = "select * from iccr_sfs_users where email_id = '".$email."' and status = ".$status."" ;
	   $rs = $this->db->query($sql)->row();
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}       
    }
	
		public function checkSfsLoginYear($data,$year)
    {     
	
	   //$reg_chyear = explode('-',$year);
	   //$reg_previous_yr =$reg_chyear[0]; 
	   //$reg_curent_yr =$reg_chyear[1];
	   $previousYear = '2019';
	   $email =$data['username'];
	   $sql = "select * from iccr_sfs_users where email_id = '".$email."' and date(created) > date '2019-12-26' and (YEAR(created) = ".$year." OR YEAR(created) = ".$previousYear.") and status = '1'";
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
	  
	   if(is_object($rs)){
            return $rs;
		}else{
			
			return false;
		}        
    }
	
	
	  function updateSfsLogin($uid)
    {
		$data = array(
			'last_login'=>date('Y-m-d H:i:s A')			
        );
        $this->db->where('id', $uid);
        $this->db->update('iccr_sfs_users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE;
	}
	
	public function __destruct() {
    $this->db->close();
}

public function updateLoginHistry($datas)
		{
			
			$uri= $_SERVER['HTTP_USER_AGENT']; 
			//print_r($datas);die;
			$ip_address=$this->input->ip_address();
			//print_r($datas);die;
			$created = date('Y/m/d h:i:s');
			$data = array('user_id' => $datas['userid'],'first_name' => $datas['fname'],'when'=>$created,'ip_address'=>$ip_address,'action'=>'Login Successful','uri'=>$uri,'user_type'=>$datas['user_type']);
			$q = $this->db->insert_string('iccr_login_history',$data);
			$this->db->query($q);
			return true;
		}
		
		
		///loginHistory Managment
	public function updateLogoutHistry($user_data)
		{
			$uri= $_SERVER['HTTP_USER_AGENT']; 
			//print_r($user_data);die;
			$ip_address=$this->input->ip_address();
			$created = date('Y/m/d h:i:s');
			$data = array('user_id' => $user_data['userid'],'first_name' => $user_data['fname'],'when'=>$created,'ip_address'=>$ip_address,'action'=>'Logout','uri'=>$uri,'user_type'=>$user_data['user_type']);
			$q = $this->db->insert_string('iccr_login_history',$data);
			$this->db->query($q);
			return true;
		}
		
		
		public function updateLoginFailHistry($datas)
		{
			
			$uri= $_SERVER['HTTP_USER_AGENT']; 
			//print_r($datas);die;
			$ip_address=$this->input->ip_address();
			//print_r($datas);die;
			$created = date('Y/m/d h:i:s');
			$data = array('user_id' => $datas['userid'],'first_name' => $datas['fname'],'when'=>$created,'ip_address'=>$ip_address,'action'=>'Login Fail','uri'=>$uri,'user_type'=>$datas['user_type']);
			$q = $this->db->insert_string('iccr_login_history',$data);
			$this->db->query($q);
			return true;
		}
	
} 


?>
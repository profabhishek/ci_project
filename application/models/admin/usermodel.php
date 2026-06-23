<?php
class Usermodel extends CI_Model
{
     function validatelogin($data)
     {   
		
		
	        $email =$data['email'];		   
		   $encrypt_password = md5(trim($data['password']));
				$this->db->select('*');
				$this->db->from('adminuser');
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
					  $this->session->set_userdata('adminlogged_in',$datas);
					  
					
					  
					  return 1;
					 }else{
						 
						   $this->session->set_flashdata('loginerror', '<div class="error" style="color:red;">Please enter valid login/password</div>');
					 return 0;
					}
         }
		 
		 
		 function do_subscription($data)
		 {
			 $this->db->insert('subscriber',$data);
		 }
		 
		 
		  function checkAvailability($data)
		  {
			 
			 
			    $this->db->select('*');
				$this->db->from('user');
				$this->db->where($data['type'],$data['value']);
							   
				$rs=$this->db->get();
				          
				
				if($rs->num_rows()>0)
				 { 
				   return 1;
				 }else
					 {
					   return 0;					
					 }
					 
					 
			 
		  }
		 
		
		
		
		
		 function update_pass_forgot($email,$data)
		 {
			 
			 $this->db->where('email',$email);
			 $this->db->update('user',$data);
			
			 if($this->db->affected_rows() > 0)
			 {
				 return 1;
			 }
		 }
		  function update_password($data,$id)
		 { 
		 
		  
			 $this->db->where('Id',$id);
			 $this->db->update('userlogin',$data);
			
			 if($this->db->affected_rows() > 0)
			 {
				 return TRUE;
			 }
			 
		 }
		 	 
		
		
		
		 
    function saveuser($data){ 
					 $data=$this->db->insert('user',$data);
					  if($data)
							{ 
							  return TRUE;
							  }else{
							  return FALSE;
						   }
                  }
       
			 
			 
  
	      }
?>
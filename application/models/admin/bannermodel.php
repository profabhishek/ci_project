<?php
class Bannermodel extends CI_Model
{
	 
	 function insertbannerimage($data)
	 {
		 $this->db->insert('bannerlist',$data);
		  return  $this->db->insert_id();
	 }
	 
	 function updateProperty($data,$id)
	 {
		 
		  $this->db->where('prop_id', $id);
          $this->db->update('property',$data);
          return;
	 }
	 
	
    function getbaseimage($pro_id)
	 {
		 
		     $this->db->select('img_name');
			$this->db->from('propertyimg');
			$this->db->where('pro_id',$pro_id);
			$this->db->where('baseimage',1);
						   
			$rs=$this->db->get();
			 $row = $rs->row();
			
			  return $row->img_name ;
	 }
	 
	 
	 function deleteprop($proid){
		 
		 
		    $this->db->delete('property', array('prop_id' => $proid)); 
		  
		    $this->db->select('img_name');
			$this->db->from('propertyimg');
			$this->db->where('pro_id',$proid);
						   
			$rs=$this->db->get();
			$imgdata=$rs->result();
		
			foreach($imgdata as $img)
			{
				$img_name=$img->img_name;
				unlink($img_name);
				
				
			}
					
		 
		  $this->db->delete('propertyimg', array('pro_id' => $proid)); 
		  
		 
		
			return true;
   }
       
}
?>
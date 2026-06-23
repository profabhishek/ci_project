<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	function get_parent_list($id){
		$this->db->select('fc.*');
		$this->db->from('frm_category fc');
		$this->db->join('frm_category fc2', "fc2.id!=fc.parent_id", 'left');
		$this->db->where('fc.id !=', $id);
		$this->db->where('fc.status', 1);
		$this->db->where('fc2.id', $id);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	
	 function insertcmspage($data)
	 {
		 $this->db->insert('cms_page',$data);
		  return $this->db->insert_id();
	 }
	 
	  function cmslist()
	 {
	    $this->db->select('*');
		$this->db->from('cms_page');
		$this->db->where('page_status',1);
					   
		$rs=$this->db->get();
		
		  return $rs ;
	 }
	 
	 
}
?>
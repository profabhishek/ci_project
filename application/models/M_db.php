<?php
class M_db extends CI_Model
{
	
	 function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        
    }
	
    function get_posts($number = 10, $start = 0)
    {
		
        $this->db->select('*');
        $this->db->from('iccr_posts');
        $this->db->where('active',1);
        $this->db->order_by('date_added','desc');
        $this->db->limit($number, $start);
		//echo $this->db->_compile_select();
        $query = $this->db->get();
		//echo $this->db->_compile_select();
        return $query->result_array();
		
		

    }
	function search_posts($query)
	{
		$this->db->select();
		$this->db->from('posts');
		$this->db->like("post_title", $query, 'both');
		$this->db->or_like("post", $query, 'both');
		$this->db->order_by('date_added', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}
    function get_post_count()
    {
        $this->db->select()->from('iccr_posts')->where('active',1);
        $query = $this->db->get();
        return $query->num_rows;
    }
    function get_post($post_id)
    {
        $this->db->select();
        $this->db->from('iccr_posts');
        $this->db->where(array('active'=>1,'post_id'=>$post_id));
        $this->db->order_by('date_added','desc');
        $query = $this->db->get();
        return $query->first_row('array');
    }
    function insert_post($data)
    {
        $this->db->insert('posts',$data);
        return $this->db->insert_id();
    }
    
    function update_post($post_id, $data)
    {
        $this->db->where('post_id',$post_id);
        $this->db->update('posts',$data);
    }
    
    function delete_post($post_id)
    {
        $this->db->where('post_id',$post_id);
        $this->db->delete('posts');
    }
}

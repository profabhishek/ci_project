<?php

class M_comment extends CI_Model
{
    function add_comment($data)
    {
        $this->db->insert('comments',$data);
        return $this->db->insert_id();
    }
    
    function get_comment($post_id)
    {
		//echo $post_id;die;
        $this->db->select('comments.*,iccr_blog_users.username');
        $this->db->from('iccr_comments');
        $this->db->join('iccr_blog_users','iccr_blog_users.user_id = iccr_comments.user_id', 'left');
        $this->db->where('post_id',$post_id);
        $this->db->order_by('date_added','asc');
        $query = $this->db->get();
        return $query->result_array();
    }
}


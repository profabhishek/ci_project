<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model
{
    public function save($table, $data)
    {
        $this->db->insert($table, $data);
		//print_r($this->db->last_query());exit;
        return $this->db->insert_id();
    }

    public function update($table, $data, $id)
    {
		
        $this->db->where('page_slug', $id);
        $this->db->update($table, $data);
		//print_r($this->db->last_query());
        return $this->db->affected_rows();
    }

    public function getAll($table, array $fields = null)
    {
        if($fields) $this->db->select(implode(',', $fields));
        $this->db->from($table);
        return $this->db->get()->result_array();
    }

    public function getByCriteria($criteria, $table, array $fields = null)
    {
        if($fields) $this->db->select(implode(',', $fields));
        $this->db->where($criteria);
        $this->db->from($table);
        return $this->db->get()->result_array();
    }

    public function getSQL($sql)
    {
        return $this->db->query($sql)->result_array();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('iccr_page');
        return $this->db->affected_rows();
    }

    public function deleteByCriteria($criteria, $table, $data)
    {
        $this->db->where($criteria);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function update_status($id, $table, $data)
    {
        $this->db->where('md5(id)', $id);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Read-only data for the public home page (no login needed):
 * scheme list and the countries that have an Indian Mission on the portal.
 * Results are cached for 1 hour in application/cache so the home page stays fast.
 */
class A2a_public_model extends CI_Model
{
    const TTL = 3600;

    private function cache()
    {
        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));
        return $this->cache;
    }

    public function schemes()
    {
        $c = $this->cache();
        $rows = $c->get('a2a_pub_schemes');
        if ($rows !== FALSE) { return $rows; }
        $rows = array();
        if ($this->db->table_exists('iccr_scheme')) {
            // Same exclusions as common_model->getAllSchemes()
            $rows = $this->db->select('id, scheme_name, desc')
                ->from('iccr_scheme')
                ->where_not_in('id', array(2, 13, 19, 24, 25, 27))
                ->order_by('scheme_name', 'ASC')
                ->get()->result_array();
        }
        $c->save('a2a_pub_schemes', $rows, self::TTL);
        return $rows;
    }

    // [ ['country_id'=>.., 'country'=>.., 'mission'=>..], ... ]  (no e-mail addresses)
    public function mission_countries()
    {
        $c = $this->cache();
        $rows = $c->get('a2a_pub_missions');
        if ($rows !== FALSE) { return $rows; }
        $rows = $this->db->select('c.id AS country_id, c.country_name AS country, m.mission_name AS mission')
            ->from('iccr_missions m')
            ->join('iccr_countries c', 'c.id = m.country')
            ->where('m.status', 1)
            ->order_by('c.country_name', 'ASC')
            ->get()->result_array();
        $c->save('a2a_pub_missions', $rows, self::TTL);
        return $rows;
    }
}

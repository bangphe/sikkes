<?php
class Departemen_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_departemen()
	{
		$this->db->select('*');
		$this->db->from('ref_dept');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_dept');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_departemen()
    {
        $this->db->select('*');
		$this->db->from('ref_dept');	
		$query = $this->db->get();
		return $query;
    }

	function get_departemen($kode_dept)
	{
		$this->db->select('*');
		$this->db->from('ref_dept');
		$this->db->where('KDDEPT',$kode_dept);
		$query = $this->db->get();
		return $query;
	}
	
	function add($departemen)
	{
		$this->db->insert('ref_dept', $departemen);
	}
		
	function update($kode_dept, $departemen)
	{
		$this->db->where('KDDEPT',$kode_dept)->update('ref_dept', $departemen);
	}

	function hapus_departemen($kode_dept)
	{
		$this->db->where('KDDEPT',$kode_dept)->delete('ref_dept');
	}
	
	function cek_departemen_baru($departemen)
	{
		$query = $this->db->get_where('ref_dept', array('NMDEPT' => $departemen));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_departemen($departemen, $kode_dept)
	{				
		$query = $this->db->query('select * from ref_dept where NMDEPT =  "'.$departemen.'" and KDDEPT '.$kode_dept);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function valid($kode)
	{
		$query = $this->db->get_where('ref_dept', array('KDDEPT' => $kode));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
// END masterdepartemen_model Class
/* End of file masterdepartemen_model.php */
/* Location: ./application/models/masterdepartemen_model.php */
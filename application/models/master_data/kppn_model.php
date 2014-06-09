<?php
class Kppn_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid()
	{
		$this->db->select('*');
		$this->db->from('ref_kppn');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_kppn');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_kppn()
    {
        $this->db->select('*');
		$this->db->from('ref_kppn');	
		$query = $this->db->get();
		return $query;
    }

	function get_kppn($kode)
	{
		$this->db->select('*');
		$this->db->from('ref_kppn');
		$this->db->where('KDKPPN',$kode);
		$query = $this->db->get();
		return $query;
	}
	
	function add($kppn)
	{
		$this->db->insert('ref_kppn', $kppn);
	}
		
	function update($kode, $kppn)
	{
		$this->db->where('KDKPPN',$kode)->update('ref_kppn', $kppn);
	}

	function hapus_kppn($kode)
	{
		$this->db->where('KDKPPN',$kode)->delete('ref_kppn');
	}
	
	function cek_kppn_baru($kppn)
	{
		$query = $this->db->get_where('ref_kppn', array('NMKPPN' => $kppn));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_kppn($kppn, $kode)
	{				
		$query = $this->db->query('select * from ref_kppn where NMKPPN =  "'.$kppn.'" and KDKPPN <> '.$kode);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function valid_kode($kode){
		$query = $this->db->get_where('ref_kppn', array('KDKPPN' => $kode));
		if ($query->num_rows() > 0){
			return TRUE;	
		}
		else
			return FALSE;
	}

}
// END masterkppn_model Class
/* End of file masterkppn_model.php */
/* Location: ./application/models/masterkppn_model.php */
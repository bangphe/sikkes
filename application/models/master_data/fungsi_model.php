<?php
class Fungsi_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_fungsi()
	{
		$this->db->select('*');
		$this->db->from('ref_fungsi');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_fungsi');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_fungsi()
    {
        $this->db->select('*');
		$this->db->from('ref_fungsi');	
		$query = $this->db->get();
		return $query;
    }

	function get_fungsi($kode_fungsi)
	{
		$this->db->select('*');
		$this->db->from('ref_fungsi');
		$this->db->where('KodeFungsi',$kode_fungsi);
		$query = $this->db->get();
		return $query;
	}
	
	function add($fungsi)
	{
		$this->db->insert('ref_fungsi', $fungsi);
	}
		
	function update($kode_fungsi, $fungsi)
	{
		$this->db->where('KodeFungsi',$kode_fungsi)->update('ref_fungsi', $fungsi);
	}

	function hapus_fungsi($kode_fungsi)
	{
		$this->db->where('KodeFungsi',$kode_fungsi)->delete('ref_fungsi');
	}
	
	function cek_fungsi_baru($fungsi)
	{
		$query = $this->db->get_where('ref_fungsi', array('NamaFungsi' => $fungsi));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_fungsi($fungsi, $kode_fungsi)
	{				
		$query = $this->db->query('select * from ref_fungsi where NamaFungsi =  "'.$fungsi.'" and KodeFungsi <> '.$kode_fungsi);
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
		$query = $this->db->get_where('ref_fungsi', array('KodeFungsi' => $kode));
		if ($query->num_rows() > 0){
			return TRUE;	
		}
		else
			return FALSE;
	}

}
// END masterfungsi_model Class
/* End of file masterfungsi_model.php */
/* Location: ./application/models/masterfungsi_model.php */
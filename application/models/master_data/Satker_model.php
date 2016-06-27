<?php
class Satker_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_satker()
	{
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_satker()
    {
        $this->db->select('*');
		$this->db->from('ref_satker');	
		$query = $this->db->get();
		return $query;
    }

	function get_satker($kode_satker)
	{
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->where('kdsatker',$kode_satker);
		$query = $this->db->get();
		return $query;
	}
	
	function add($satker)
	{
		$this->db->insert('ref_satker', $satker);
	}
		
	function update($kode_satker, $satker)
	{
		$this->db->where('kdsatker',$kode_satker)->update('ref_satker', $satker);
	}

	function hapus_satker($kode_satker)
	{
		$this->db->where('kdsatker',$kode_satker)->delete('ref_satker');
	}
	
	function cek_satker_baru($satker)
	{
		$query = $this->db->get_where('ref_satker', array('nmsatker' => $satker));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_satker($satker, $kode_satker)
	{				
		$query = $this->db->query('select * from ref_satker where nmsatker =  "'.$satker.'" and kdsatker <> '.$kode_satker);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_satker_by_lokasi($idlokasi)
	{
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->where('kdlokasi',$idlokasi);
		$query = $this->db->get();
		return $query;
	}
	
	function valid_kode($kode){
		$query = $this->db->get_where('ref_satker', array('nomorsp' => $kode));
		if ($query->num_rows() > 0){
			return TRUE;	
		}
		else
			return FALSE;
	}

}
// END mastersatker_model Class
/* End of file mastersatker_model.php */
/* Location: ./application/models/mastersatker_model.php */

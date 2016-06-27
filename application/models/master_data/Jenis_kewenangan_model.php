<?php
class Jenis_kewenangan_model extends CI_Model {
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
		$this->db->from('ref_jenis_satker');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_jenis_satker');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_jenis_satker()
    {
        $this->db->select('*');
		$this->db->from('ref_jenis_satker');	
		$query = $this->db->get();
		return $query;
    }

	function get_jenis_satker($kode_jenis_satker)
	{
		$this->db->select('*');
		$this->db->from('ref_jenis_satker');
		$this->db->where('KodeJenisSatker',$kode_jenis_satker);
		$query = $this->db->get();
		return $query;
	}
	
	function add($jenis)
	{
		$this->db->insert('ref_jenis_satker', $jenis);
	}
		
	function update($kode, $jenis)
	{
		$this->db->where('KodeJenisSatker',$kode)->update('ref_jenis_satker', $jenis);
	}

	function hapus_jenis_satker($kode_jenis_satker)
	{
		$this->db->where('KodeJenisSatker',$kode_jenis_satker)->delete('ref_jenis_satker');
	}
	
	function cek_jenis_satker_baru($jenis)
	{
		$query = $this->db->get_where('ref_jenis_satker', array('JenisSatker' => $jenis));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_jenis_satker($jenis, $kode_jenis_satker)
	{				
		$query = $this->db->query('select * from ref_jenis_satker where JenisSatker =  "'.$jenis.'" and KodeJenisSatker '.$kode_jenis_satker);
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
// END jenis_satker_model Class
/* End of file jenis_satker_model.php */
/* Location: ./application/models/jenis_satker_model.php */
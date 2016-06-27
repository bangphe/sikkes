<?php
class Jenis_pembiayaan_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_jenis_pembiayaan()
	{
		$this->db->select('*');
		$this->db->from('ref_jenis_pembiayaan');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_jenis_pembiayaan');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_jenis_pembiayaan()
    {
        $this->db->select('*');
		$this->db->from('ref_jenis_pembiayaan');	
		$query = $this->db->get();
		return $query;
    }

	function get_jenis_pembiayaan($kode_jenis_pembiayaan)
	{
		$this->db->select('*');
		$this->db->from('ref_jenis_pembiayaan');
		$this->db->where('KodeJenisPembiayaan',$kode_jenis_pembiayaan);
		$query = $this->db->get();
		return $query;
	}
	
	function add($jenis_pembiayaan)
	{
		$this->db->insert('ref_jenis_pembiayaan', $jenis_pembiayaan);
	}
		
	function update($kode_jenis_pembiayaan, $jenis_pembiayaan)
	{
		$this->db->where('KodeJenisPembiayaan',$kode_jenis_pembiayaan)->update('ref_jenis_pembiayaan', $jenis_pembiayaan);
	}

	function hapus_jenis_pembiayaan($kode_jenis_pembiayaan)
	{
		$this->db->where('KodeJenisPembiayaan',$kode_jenis_pembiayaan)->delete('ref_jenis_pembiayaan');
	}
	
	function cek_jenis_pembiayaan_baru($jenis_pembiayaan)
	{
		$query = $this->db->get_where('ref_jenis_pembiayaan', array('JenisPembiayaan' => $jenis_pembiayaan));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_jenis_pembiayaan($jenis_pembiayaan, $kode_jenis_pembiayaan)
	{				
		$query = $this->db->query('select * from ref_jenis_pembiayaan where JenisPembiayaan =  "'.$jenis_pembiayaan.'" and KodeJenisPembiayaan <> '.$kode_jenis_pembiayaan);
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
// END masterjenis_pembiayaan_model Class
/* End of file masterjenis_pembiayaan_model.php */
/* Location: ./application/models/masterjenis_pembiayaan_model.php */
<?php
class Anggaran_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_anggaran()
	{
		$this->db->select('*');
		$this->db->from('ref_tahun_anggaran');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_tahun_anggaran');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_anggaran()
    {
        $this->db->select('*');
		$this->db->from('ref_tahun_anggaran');	
		$query = $this->db->get();
		return $query;
    }

	function get_anggaran($kode_anggaran)
	{
		$this->db->select('*');
		$this->db->from('ref_tahun_anggaran');
		$this->db->where('idThnAnggaran',$kode_anggaran);
		$query = $this->db->get();
		return $query;
	}
	
	function add($anggaran)
	{
		$this->db->insert('ref_tahun_anggaran', $anggaran);
	}
		
	function update($kode_anggaran, $anggaran)
	{
		$this->db->where('idThnAnggaran',$kode_anggaran)->update('ref_tahun_anggaran', $anggaran);
	}

	function hapus_anggaran($kode_anggaran)
	{
		$this->db->where('idThnAnggaran',$kode_anggaran)->delete('ref_tahun_anggaran');
	}
	
	function cek_anggaran_baru($anggaran)
	{
		$query = $this->db->get_where('ref_tahun_anggaran', array('NamaProvinsi' => $anggaran));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_anggaran($anggaran, $kode_anggaran)
	{				
		$query = $this->db->query('select * from ref_tahun_anggaran where NamaProvinsi =  "'.$anggaran.'" and idThnAnggaran <> '.$kode_anggaran);
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
// END masteranggaran_model Class
/* End of file masteranggaran_model.php */
/* Location: ./application/models/masteranggaran_model.php */
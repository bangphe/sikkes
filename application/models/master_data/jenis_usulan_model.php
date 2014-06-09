<?php
class Jenis_usulan_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_jenis_usulan()
	{
		$this->db->select('*');
		$this->db->from('ref_jenis_usulan');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_jenis_usulan');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_jenis_usulan()
    {
        $this->db->select('*');
		$this->db->from('ref_jenis_usulan');	
		$query = $this->db->get();
		return $query;
    }

	function get_jenis_usulan($kode_jenis_usulan)
	{
		$this->db->select('*');
		$this->db->from('ref_jenis_usulan');
		$this->db->where('KodeJenisUsulan',$kode_jenis_usulan);
		$query = $this->db->get();
		return $query;
	}
	
	function add($jenis)
	{
		$this->db->insert('ref_jenis_usulan', $jenis);
	}
		
	function update($kode, $jenis)
	{
		$this->db->where('KodeJenisUsulan',$kode)->update('ref_jenis_usulan', $jenis);
	}

	function hapus_jenis_usulan($kode_jenis_usulan)
	{
		$this->db->where('kdsatker',$kode_jenis_usulan)->delete('ref_jenis_usulan');
	}
	
	function cek_jenis_usulan_baru($jenis)
	{
		$query = $this->db->get_where('ref_jenis_usulan', array('JenisUsulan' => $jenis));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_jenis_usulan($jenis, $kode_jenis_usulan)
	{				
		$query = $this->db->query('select * from ref_jenis_usulan where JenisUsulan =  "'.$jenis.'" and KodeJenisUsulan '.$kode_jenis_usulan);
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
// END mastersatker_model Class
/* End of file mastersatker_model.php */
/* Location: ./application/models/mastersatker_model.php */
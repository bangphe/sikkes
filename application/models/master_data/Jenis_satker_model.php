<?php
class Jenis_satker_model extends CI_Model {
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
		$this->db->from('t_jnssat');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('t_jnssat');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_jenis_satker()
    {
        $this->db->select('*');
		$this->db->from('t_jnssat');	
		$query = $this->db->get();
		return $query;
    }

	function get_jenis_satker($kode_jenis_satker)
	{
		$this->db->select('*');
		$this->db->from('t_jnssat');
		$this->db->where('kdjnssat',$kode_jenis_satker);
		$query = $this->db->get();
		return $query;
	}
	
	function add($jenis)
	{
		$this->db->insert('t_jnssat', $jenis);
	}
		
	function update($kode, $jenis)
	{
		$this->db->where('kdjnssat',$kode)->update('t_jnssat', $jenis);
	}

	function hapus_jenis_satker($kode_jenis_satker)
	{
		$this->db->where('kdjnssat',$kode_jenis_satker)->delete('t_jnssat');
	}
	
	function cek_jenis_satker_baru($jenis)
	{
		$query = $this->db->get_where('t_jnssat', array('nmjnssat' => $jenis));
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
		$query = $this->db->query('select * from t_jnssat where nmjnssat =  "'.$jenis.'" and kdjnssat '.$kode_jenis_satker);
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
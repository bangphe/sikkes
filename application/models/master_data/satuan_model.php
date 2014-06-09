<?php
class Satuan_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_satuan()
	{
		$this->db->select('*');
		$this->db->from('ref_satuan');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_satuan');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_satuan()
    {
        $this->db->select('*');
		$this->db->from('ref_satuan');	
		$query = $this->db->get();
		return $query;
    }

	function get_satuan($kode_satuan)
	{
		$this->db->select('*');
		$this->db->from('ref_satuan');
		$this->db->where('KodeSatuan',$kode_satuan);
		$query = $this->db->get();
		return $query;
	}
	
	function add($satuan)
	{
		$this->db->insert('ref_satuan', $satuan);
	}
		
	function update($kode_satuan, $satuan)
	{
		$this->db->where('KodeSatuan',$kode_satuan)->update('ref_satuan', $satuan);
	}

	function hapus_satuan($kode_satuan)
	{
		$this->db->where('KodeSatuan',$kode_satuan)->delete('ref_satuan');
	}
	
	function cek_satuan_baru($satuan)
	{
		$query = $this->db->get_where('ref_satuan', array('Satuan' => $satuan));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_satuan($satuan, $kode_satuan)
	{				
		$query = $this->db->query('select * from ref_satuan where Satuan =  "'.$satuan.'" and KodeSatuan <> '.$kode_satuan);
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
// END mastersatuan_model Class
/* End of file mastersatuan_model.php */
/* Location: ./application/models/mastersatuan_model.php */
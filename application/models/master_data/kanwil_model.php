<?php
class Kanwil_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_kanwil()
	{
		$this->db->select('*');
		$this->db->from('ref_kanwil');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_kanwil');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_kanwil()
    {
        $this->db->select('*');
		$this->db->from('ref_kanwil');	
		$query = $this->db->get();
		return $query;
    }

	function get_kanwil($kode_kanwil)
	{
		$this->db->select('*');
		$this->db->from('ref_kanwil');
		$this->db->where('KDKANWIL',$kode_kanwil);
		$query = $this->db->get();
		return $query;
	}
	
	function add($kanwil)
	{
		$this->db->insert('ref_kanwil', $kanwil);
	}
		
	function update($kode_kanwil, $kanwil)
	{
		$this->db->where('KDKANWIL',$kode_kanwil)->update('ref_kanwil', $kanwil);
	}

	function hapus_kanwil($kode_kanwil)
	{
		$this->db->where('KDKANWIL',$kode_kanwil)->delete('ref_kanwil');
	}
	
	function cek_kanwil_baru($kanwil)
	{
		$query = $this->db->get_where('ref_kanwil', array('NMKANWIL' => $kanwil));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_kanwil($kanwil, $kode_kanwil)
	{				
		$query = $this->db->query('select * from ref_kanwil where NMKANWIL =  "'.$kanwil.'" and KDKANWIL <> '.$kode_kanwil);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function valid($kode){
		$query = $this->db->get_where('ref_kanwil', array('KDKANWIL' => $kode));
		if($query->num_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
// END masterkanwil_model Class
/* End of file masterkanwil_model.php */
/* Location: ./application/models/masterkanwil_model.php */
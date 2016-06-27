<?php
class Unit_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_unit()
	{
		$this->db->select('*');
		$this->db->from('ref_unit');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_unit');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_unit()
    {
        $this->db->select('*');
		$this->db->from('ref_unit');	
		$query = $this->db->get();
		return $query;
    }

	function get_unit($kode_unit)
	{
		$this->db->select('*');
		$this->db->from('ref_unit');
		$this->db->where('KDUNIT',$kode_unit);
		$query = $this->db->get();
		return $query;
	}
	
	function add($unit)
	{
		$this->db->insert('ref_unit', $unit);
	}
		
	function update($kode_unit, $unit)
	{
		$this->db->where('KDUNIT',$kode_unit)->update('ref_unit', $unit);
	}

	function hapus_unit($kode_unit)
	{
		$this->db->where('KDUNIT',$kode_unit)->delete('ref_unit');
	}
	
	function cek_unit_baru($unit)
	{
		$query = $this->db->get_where('ref_unit', array('NMUNIT' => $unit));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_unit($unit, $kode_unit)
	{				
		$query = $this->db->query('select * from ref_unit where NMUNIT =  "'.$unit.'" and KDUNIT <> '.$kode_unit);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function valid($kode)
	{
		$query = $this->db->get_where('ref_unit', array('KDUNIT' => $kode));
		if($query->num_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

}
// END masterunit_model Class
/* End of file masterunit_model.php */
/* Location: ./application/models/masterunit_model.php */
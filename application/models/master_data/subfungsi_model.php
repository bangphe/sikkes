<?php
class Subfungsi_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_subfungsi()
	{
		$this->db->select('*');
		$this->db->from('ref_sub_fungsi');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_sub_fungsi');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_subfungsi()
    {
        $this->db->select('*');
		$this->db->from('ref_sub_fungsi');	
		$query = $this->db->get();
		return $query;
    }

	function get_subfungsi($kode_subfungsi)
	{
		$this->db->select('*');
		$this->db->from('ref_sub_fungsi');
		$this->db->where('KodeSubFungsi',$kode_subfungsi);
		$query = $this->db->get();
		return $query;
	}
	
	function add($subfungsi)
	{
		$this->db->insert('ref_sub_fungsi', $subfungsi);
	}
		
	function update($kode_subfungsi, $subfungsi)
	{
		$this->db->where('KodeSubFungsi',$kode_subfungsi)->update('ref_sub_fungsi', $subfungsi);
	}

	function hapus_subfungsi($kode_subfungsi)
	{
		$this->db->where('KodeSubFungsi',$kode_subfungsi)->delete('ref_sub_fungsi');
	}
	
	function update_double_where($tabel,$data,$kolom,$param,$kolom2,$param2){
		$this->db->where($kolom,$param);
		$this->db->where($kolom2,$param2);
		$this->db->update($tabel, $data);
	}
	
	function cek_subfungsi_baru($subfungsi)
	{
		$query = $this->db->get_where('ref_sub_fungsi', array('NamaSubFungsi' => $subfungsi));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_subfungsi($subfungsi, $kode_subfungsi)
	{				
		$query = $this->db->query('select * from ref_sub_fungsi where NamaSubFungsi =  "'.$subfungsi.'" and KodeSubFungsi = '.$kode_subfungsi);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function valid_kode($kdfungsi,$kode){
		$query = $this->db->get_where('ref_sub_fungsi', array('KodeFungsi' => $kdfungsi, 'KodeSubFungsi' => $kode));
		if ($query->num_rows() > 0){
			return TRUE;	
		}
		else
			return FALSE;
	}
}
// END mastersubfungsi_model Class
/* End of file mastersubfungsi_model.php */
/* Location: ./application/models/mastersubfungsi_model.php */
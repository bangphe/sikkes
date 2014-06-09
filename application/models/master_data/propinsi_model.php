<?php
class Propinsi_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_propinsi()
	{
		$this->db->select('*');
		$this->db->from('ref_provinsi');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_provinsi');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_propinsi(){
        $this->db->select('*');
		$this->db->from('ref_provinsi');	
		$query = $this->db->get();
		return $query;
    }
	
	function get_max($tabel,$kolom){
		$this->db->select_max($kolom);
		$this->db->from($tabel);
		$return = $this->db->get()->result();
		$result = 0;
		foreach($return as $row){
			$result = $row->$kolom;
		}
		return $result;
	}

	function get_prov($KodeProvinsi)
	{
		$this->db->select('*');
		$this->db->from('ref_provinsi');
		$this->db->where('KodeProvinsi',$KodeProvinsi);
		$query = $this->db->get();
		return $query;
	}
	
	function add($tabel, $data){
		$this->db->insert($tabel, $data);
	}
		
	function update($KodeProv, $data){
		$this->db->where('KodeProvinsi',$KodeProv)->update('ref_provinsi', $data);
	}

	function hapus_prov($KodeProvinsi){
		$this->db->where('KodeProvinsi',$KodeProvinsi)->delete('ref_provinsi');
	}
	
	function cek_propinsi_baru($propinsi){
		$query = $this->db->get_where('ref_propinsi', array('nmpropinsi' => $propinsi));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_propinsi($propinsi, $kode_propinsi)
	{				
		$query = $this->db->query('select * from ref_propinsi where nmpropinsi =  "'.$propinsi.'" and kdpropinsi <> '.$kode_propinsi);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function valid_kode($kode){
		$query = $this->db->get_where('ref_provinsi', array('KodeProvinsi' => $kode));
		if ($query->num_rows() > 0){
			return TRUE;	
		}
		else
			return FALSE;
	}
}
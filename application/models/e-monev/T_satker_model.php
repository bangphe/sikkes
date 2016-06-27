<?php
class T_satker_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_satker_by_lokasi($idlokasi)
	{
		$this->db->select('*');
		$this->db->from('t_satker');
		$this->db->where('kdlokasi',$idlokasi);
		$query = $this->db->get();
		return $query;
	}
	
	function get_satker_by_lokasi_kodeunit($idlokasi, $kdunit)
	{
		$this->db->select('*');
		$this->db->from('t_satker');
		$this->db->where('kdlokasi',$idlokasi);
		$this->db->where('kdunit',$kdunit);
		$query = $this->db->get();
		return $query;
	}
	
	function get_satker_by_id($idsatker)
	{
		$this->db->select('*');
		$this->db->from('t_satker');
		$this->db->where('kdsatker',$idsatker);
		$query = $this->db->get();
		return $query;
	}

}
// END t_lokasi Class
/* End of file t_lokasi_model.php */
/* Location: ./application/models/e-monev/t_lokasi_model.php */

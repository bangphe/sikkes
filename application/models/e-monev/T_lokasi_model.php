<?php
class T_lokasi_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_all_propinsi()
	{
        $this->db->select('*');
		$this->db->from('depkesgabungan.t_lokasi');	
		$query = $this->db->get();
		return $query;
    }
    
    function get_propinsi_by_id($id)
	{
        $this->db->select('*');
		$this->db->from('depkesgabungan.t_lokasi');	
		$this->db->where('kdlokasi', $id);	
		$query = $this->db->get();
		return $query;
    }

}
// END t_lokasi Class
/* End of file t_lokasi_model.php */
/* Location: ./application/models/e-monev/t_lokasi_model.php */

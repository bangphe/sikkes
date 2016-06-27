<?php
class D_skmpnen_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
		$this->load->database();
    }
	
	function get_skmpnen_by_satker($kdsatker)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.d_skmpnen');
		$monev->where('kdsatker',$kdsatker);
		$query = $monev->get();
		return $query;
	}
    
	
	function get_skmpnen_by_satker_kodeunit($kdsatker, $kdunit)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.d_skmpnen');
		$monev->where('kdsatker',$kdsatker);
		$monev->where('kdunit',$kdunit);
		$query = $monev->get();
		return $query;
	}
	
	function get_all_progres()
	{
	    $monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.progres');
		$query = $monev->get();
		return $query;
    }
    
    function get_paket($d_skmpnen_id)
	{
	    $monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.paket');
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$query = $monev->get();
		return $query;
    }
    
    function get_kontrak($d_skmpnen_id)
	{
	    $monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.kontrak');
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$query = $monev->get();
		return $query;
    }
    
    function sum_sewakelola($idsatker)
	{
		$this->db->select_sum('jumlah');
		$this->db->from('depkesgabungan.d_item');
		$this->db->where('kdsatker', $idsatker);
		$query = $this->db->get();
		return $query;
    }
}
// END t_lokasi Class
/* End of file d_skmpnen_model.php */
/* Location: ./application/models/e-monev/d_skmpnen_model.php */

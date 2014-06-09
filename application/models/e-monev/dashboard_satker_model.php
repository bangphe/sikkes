<?php
class Dashboard_satker_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
		$this->load->database();
    }
	
	function get_keg($kdgiat)
	{
		$this->db->select('nmgiat');
		$this->db->from('t_giat');
		$this->db->where('kdgiat',$kdgiat);
		return $this->db->get();
	}
	
	function get_output($kdgiat,$kdoutput)
	{
		$this->db->select('nmoutput');
		$this->db->from('t_output');
		$this->db->where('kdgiat',$kdgiat);
		$this->db->where('kdoutput',$kdoutput);
		return $this->db->get();
	}
	
	function get_suboutput($kdprogram,$kdgiat,$kdoutput,$kdsoutput)
	{
		$this->db->select('ursoutput');
		$this->db->from('d_soutput');
		$this->db->where('kdprogram',$kdprogram);
		$this->db->where('kdgiat',$kdgiat);
		$this->db->where('kdoutput',$kdoutput);
		$this->db->where('kdsoutput',$kdsoutput);
		return $this->db->get();
	}
	
	function get_kmpnen_by_satker($kdsatker, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_kmpnen');
		$this->db->where('kdsatker', $kdsatker);
		$this->db->where('thang', $thang);
		$this->db->order_by('urkmpnen','asc');
		return $this->db->get();
	}
	function get_skmpnen_by_kmpnen($kdsatker, $thang, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdsoutput, $kdkmpnen, $kdjendok, $kddekon)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->where('kdsatker',$kdsatker);
		$this->db->where('thang',$thang);
		$this->db->where('kddept',$kddept);
		$this->db->where('kdunit',$kdunit);
		$this->db->where('kdprogram',$kdprogram);
		$this->db->where('kdgiat',$kdgiat);
		$this->db->where('kdoutput',$kdoutput);
		$this->db->where('kdsoutput',$kdsoutput);
		$this->db->where('kdkmpnen',$kdkmpnen);
		$this->db->where('kdjendok',$kdjendok);
		$this->db->where('kddekon',$kddekon);
		return $this->db->get();
	}
	
	function get_skmpnen_by_satker($kdsatker, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->where('kdsatker',$kdsatker);
		$this->db->where('thang',$thang);
		return $this->db->get();
	}
	
	function get_skmpnen_by_satkers($kdsatker, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->where('kdsatker',$kdsatker);
		$this->db->where('thang',$thang);
		$this->db->limit(50);

		return $this->db->get();
	}

	function get_paket($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdsoutput, $kdkmpnen, $kdskmpnen){
		$this->db->select('*');
		$this->db->from('paket');
		$this->db->where('thang', $thang);
		$this->db->where('kdjendok', $kdjendok);
		$this->db->where('kdsatker', $kdsatker);
		$this->db->where('kddept', $kddept);
		$this->db->where('kdunit', $kdunit);
		$this->db->where('kdprogram', $kdprogram);
		$this->db->where('kdgiat', $kdgiat);
		$this->db->where('kdoutput', $kdoutput);
		$this->db->where('kdsoutput', $kdsoutput);
		$this->db->where('kdkmpnen', $kdkmpnen);
		$this->db->where('kdskmpnen', $kdskmpnen);
		return $this->db->get();
	}
	
    function get_swakelola($idpaket){
		$this->db->select('*');
		$this->db->select_sum('i.jumlah');
		$this->db->from('paket p');
		$this->db->join('d_item i', 'i.thang = p.thang AND i.kdjendok = p.kdjendok AND i.kdsatker = p.kdsatker AND i.kddept = p.kddept AND i.kdunit = p.kdunit AND i.kdprogram = p.kdprogram AND i.kdgiat = p.kdgiat AND i.kdoutput = p.kdoutput AND i.kdlokasi = p.kdlokasi AND i.kdkabkota = p.kdkabkota AND i.kddekon = p.kddekon AND i.kdsoutput = p.kdsoutput AND i.kdkmpnen = p.kdkmpnen AND i.kdskmpnen = p.kdskmpnen');
		$this->db->join('dm_jns_item j', 'p.idpaket = j.idpaket AND j.kdakun = i.kdakun AND j.noitem = i.noitem');
		$this->db->where('p.idpaket', $idpaket);
		$this->db->where('j.kdjnsitem', '1');
		return $this->db->get();
	}
	
    function get_kontraktual($idpaket){
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item');
		$this->db->where('idpaket', $idpaket);
		$this->db->where('kdjnsitem', '2');
		return $this->db->get();
    }
	
    function get_pagu_total_swakelola($thang, $kdsatker){
		$this->db->select('*');
		$this->db->select_sum('i.jumlah');
		$this->db->from('paket p');
		$this->db->join('d_item i', 'i.thang = p.thang AND i.kdjendok = p.kdjendok AND i.kdsatker = p.kdsatker AND i.kddept = p.kddept AND i.kdunit = p.kdunit AND i.kdprogram = p.kdprogram AND i.kdgiat = p.kdgiat AND i.kdoutput = p.kdoutput AND i.kdlokasi = p.kdlokasi AND i.kdkabkota = p.kdkabkota AND i.kddekon = p.kddekon AND i.kdsoutput = p.kdsoutput AND i.kdkmpnen = p.kdkmpnen AND i.kdskmpnen = p.kdskmpnen');
		$this->db->join('dm_jns_item j', 'p.idpaket = j.idpaket AND j.kdakun = i.kdakun AND j.noitem = i.noitem');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdsatker', $kdsatker);
		$this->db->where('j.kdjnsitem', '1');
		return $this->db->get();
	}
	
    function get_pagu_total_kontraktual($thang, $kdsatker){
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item j');
		$this->db->join('paket p', 'j.idpaket = p.idpaket');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdsatker', $kdsatker);
		$this->db->where('j.kdjnsitem', '2');
		return $this->db->get();
    }
	
	function get_progres_fisik_swakelola_per_bulan($idpaket, $bulan){
		$this->db->select('*');
		$this->db->from('dm_progress_swakelola');
		$this->db->where('idpaket', $idpaket);
		$this->db->where('bulan', $bulan);
		return $this->db->get();
	}
	
	function get_progres_fisik_kontraktual_per_bulan($idpaket, $bulan){
		$this->db->select('*');
		$this->db->from('dm_progress_kontraktual');
		$this->db->where('idpaket', $idpaket);
		$this->db->where('bulan', $bulan);
		return $this->db->get();
	}
	
}
// END dashboard_model Class
/* End of file dashboard_satker_model.php */
/* Location: ./application/models/e-monev/dashboard_satker_model.php */

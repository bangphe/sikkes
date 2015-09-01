<?php
class Dashboard_unit_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
		$this->load->database();
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
	
	function get_provinsi()
	{
		$this->db->select('*');
		$this->db->from('ref_provinsi');
		//$this->db->order_by('NamaProvinsi');
		$this->db->order_by('KodeProvinsi');
		return $this->db->get();
	}

	function get_skmpnen_by_provinsi($thang, $kdunit, $kdlokasi)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->where('kdprogram', $kdunit);
		$this->db->where('kdlokasi', $kdlokasi);
		$this->db->where('thang', $thang);
		return $this->db->get();
	}
	
    function get_pagu_total_swakelola($thang, $kdunit){
		$this->db->select('*');
		$this->db->select_sum('i.jumlah');
		$this->db->from('paket p');
		$this->db->join('d_item i', 'i.thang = p.thang AND i.kdjendok = p.kdjendok AND i.kdsatker = p.kdsatker AND i.kddept = p.kddept AND i.kdunit = p.kdunit AND i.kdprogram = p.kdprogram AND i.kdgiat = p.kdgiat AND i.kdoutput = p.kdoutput AND i.kdlokasi = p.kdlokasi AND i.kdkabkota = p.kdkabkota AND i.kddekon = p.kddekon AND i.kdsoutput = p.kdsoutput AND i.kdkmpnen = p.kdkmpnen AND i.kdskmpnen = p.kdskmpnen');
		$this->db->join('dm_jns_item j', 'p.idpaket = j.idpaket AND j.kdakun = i.kdakun AND j.noitem = i.noitem');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('j.kdjnsitem', '1');
		return $this->db->get();
	}
	
    function get_pagu_total_kontraktual($thang, $kdunit){
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item j');
		$this->db->join('paket p', 'j.idpaket = p.idpaket');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('j.kdjnsitem', '2');
		return $this->db->get();
    }
	
    function get_pagu_prov_swakelola($thang, $kdunit, $kdlokasi){
		$this->db->select('*');
		$this->db->select_sum('i.jumlah');
		$this->db->from('paket p');
		$this->db->join('d_item i', 'i.thang = p.thang AND i.kdjendok = p.kdjendok AND i.kdsatker = p.kdsatker AND i.kddept = p.kddept AND i.kdunit = p.kdunit AND i.kdprogram = p.kdprogram AND i.kdgiat = p.kdgiat AND i.kdoutput = p.kdoutput AND i.kdlokasi = p.kdlokasi AND i.kdkabkota = p.kdkabkota AND i.kddekon = p.kddekon AND i.kdsoutput = p.kdsoutput AND i.kdkmpnen = p.kdkmpnen AND i.kdskmpnen = p.kdskmpnen');
		$this->db->join('dm_jns_item j', 'p.idpaket = j.idpaket AND j.kdakun = i.kdakun AND j.noitem = i.noitem');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('p.kdlokasi', $kdlokasi);
		$this->db->where('j.kdjnsitem', '1');
		return $this->db->get();
	}
	
    function get_pagu_prov_kontraktual($thang, $kdunit, $kdlokasi){
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item j');
		$this->db->join('paket p', 'j.idpaket = p.idpaket');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('p.kdlokasi', $kdlokasi);
		$this->db->where('j.kdjnsitem', '2');
		return $this->db->get();
    }
	
	function get_jnssat_by_prov($kdunit, $kdlokasi)
	{
		$this->db->select('*');
		$this->db->from('t_jnssat j');
		$this->db->join('ref_satker s', 's.kdjnssat = j.kdjnssat');
		$this->db->where('s.kdunit', $kdunit);
		$this->db->where('s.kdlokasi', $kdlokasi);
		$this->db->group_by('j.kdjnssat');
		return $this->db->get();
	}
	
    function get_pagu_jnssat_swakelola($thang, $kdunit, $kdlokasi, $kdjnssat){
		$this->db->select('*');
		$this->db->select_sum('i.jumlah');
		$this->db->from('paket p');
		$this->db->join('d_item i', 'i.thang = p.thang AND i.kdjendok = p.kdjendok AND i.kdsatker = p.kdsatker AND i.kddept = p.kddept AND i.kdunit = p.kdunit AND i.kdprogram = p.kdprogram AND i.kdgiat = p.kdgiat AND i.kdoutput = p.kdoutput AND i.kdlokasi = p.kdlokasi AND i.kdkabkota = p.kdkabkota AND i.kddekon = p.kddekon AND i.kdsoutput = p.kdsoutput AND i.kdkmpnen = p.kdkmpnen AND i.kdskmpnen = p.kdskmpnen');
		$this->db->join('dm_jns_item j', 'p.idpaket = j.idpaket AND j.kdakun = i.kdakun AND j.noitem = i.noitem');
		$this->db->join('ref_satker k', 'k.kdsatker = p.kdsatker');
		$this->db->where('k.kdjnssat', $kdjnssat);
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('p.kdlokasi', $kdlokasi);
		$this->db->where('j.kdjnsitem', '1');
		return $this->db->get();
	}
	
    function get_pagu_jnssat_kontraktual($thang, $kdunit, $kdlokasi, $kdjnssat){
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item j');
		$this->db->join('paket p', 'j.idpaket = p.idpaket');
		$this->db->join('ref_satker k', 'k.kdsatker = p.kdsatker');
		$this->db->where('k.kdjnssat', $kdjnssat);
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('p.kdlokasi', $kdlokasi);
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
	
	function get_skmpnen_by_jnssat($thang, $kdunit, $kdlokasi, $kdjnssat)
	{
		$this->db->select('d.*');
		$this->db->from('ref_satker r');
		$this->db->join('d_skmpnen d', 'd.kdsatker = r.kdsatker');
		$this->db->where('d.kdunit', $kdunit);	
		$this->db->where('d.kdlokasi', $kdlokasi);	
		$this->db->where('d.thang', $thang);
		$this->db->where('r.kdjnssat', $kdjnssat);
		return $this->db->get();
	}
	
	function get_satker_by_jnssat($kdunit, $kdlokasi, $kdjnssat)
	{
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->where('kdunit', $kdunit);
		$this->db->where('kdlokasi', $kdlokasi);
		$this->db->where('kdjnssat', $kdjnssat);
		$this->db->group_by('kdsatker');
		return $this->db->get();
	}
	
    function get_pagu_satker_swakelola($thang, $kdunit, $kdlokasi, $kdsatker){
		$this->db->select('*');
		$this->db->select_sum('i.jumlah');
		$this->db->from('paket p');
		$this->db->join('d_item i', 'i.thang = p.thang AND i.kdjendok = p.kdjendok AND i.kdsatker = p.kdsatker AND i.kddept = p.kddept AND i.kdunit = p.kdunit AND i.kdprogram = p.kdprogram AND i.kdgiat = p.kdgiat AND i.kdoutput = p.kdoutput AND i.kdlokasi = p.kdlokasi AND i.kdkabkota = p.kdkabkota AND i.kddekon = p.kddekon AND i.kdsoutput = p.kdsoutput AND i.kdkmpnen = p.kdkmpnen AND i.kdskmpnen = p.kdskmpnen');
		$this->db->join('dm_jns_item j', 'p.idpaket = j.idpaket AND j.kdakun = i.kdakun AND j.noitem = i.noitem');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('p.kdlokasi', $kdlokasi);
		$this->db->where('p.kdsatker', $kdsatker);
		$this->db->where('j.kdjnsitem', '1');
		return $this->db->get();
	}
	
    function get_pagu_satker_kontraktual($thang, $kdunit, $kdlokasi, $kdsatker){
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item j');
		$this->db->join('paket p', 'j.idpaket = p.idpaket');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('p.kdlokasi', $kdlokasi);
		$this->db->where('p.kdsatker', $kdsatker);
		$this->db->where('j.kdjnsitem', '2');
		return $this->db->get();
    }
	
	function get_skmpnen_by_satker($thang, $kdunit, $kdlokasi, $kdsatker)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->where('kdunit', $kdunit);	
		$this->db->where('kdlokasi', $kdlokasi);	
		$this->db->where('thang', $thang);
		$this->db->where('kdsatker', $kdsatker);
		return $this->db->get();
	}
	
	function get_subkomponen_by_satker($kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->where('thang', $thang);
		$this->db->where('kdunit', $kdunit);
		$this->db->where('kdlokasi', $kdlokasi);
		$this->db->where('kdsatker', $kdsatker);
		return $this->db->get();
	}

	function get_kegiatan_by_satker($kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_soutput d');
		$this->db->join('t_giat g', 'g.kddept=d.kddept AND g.kdunit=d.kdunit AND g.kdprogram=d.kdprogram AND d.kdgiat=g.kdgiat');
		$this->db->where('d.thang', $thang);
		$this->db->where('d.kdunit', $kdunit);
		$this->db->where('d.kdlokasi', $kdlokasi);
		$this->db->where('d.kdsatker', $kdsatker);
		//$this->db->order_by('g.kdgiat DESC');
		$this->db->group_by('g.kdgiat');
		return $this->db->get();
	}

	function get_output_by_satker($kdgiat, $kdoutput)
	{
		$this->db->select('*');
		$this->db->from('t_output t');
		$this->db->where('t.kdgiat', $kdgiat);
		$this->db->where('t.kdoutput', $kdoutput);
		return $this->db->get();
	}

	function get_suboutput_by_satker($kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_soutput d');
		$this->db->where('d.thang', $thang);
		$this->db->where('d.kdunit', $kdunit);
		$this->db->where('d.kdlokasi', $kdlokasi);
		$this->db->where('d.kdsatker', $kdsatker);
		$this->db->where('d.kdgiat', $kdgiat);
		return $this->db->get();
	}
	
    function get_pagu_skmp_swakelola($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdsoutput, $kdkmpnen, $kdskmpnen){
		$this->db->select('*');
		$this->db->select_sum('i.jumlah');
		$this->db->from('paket p');
		$this->db->join('d_item i', 'i.thang = p.thang AND i.kdjendok = p.kdjendok AND i.kdsatker = p.kdsatker AND i.kddept = p.kddept AND i.kdunit = p.kdunit AND i.kdprogram = p.kdprogram AND i.kdgiat = p.kdgiat AND i.kdoutput = p.kdoutput AND i.kdlokasi = p.kdlokasi AND i.kdkabkota = p.kdkabkota AND i.kddekon = p.kddekon AND i.kdsoutput = p.kdsoutput AND i.kdkmpnen = p.kdkmpnen AND i.kdskmpnen = p.kdskmpnen');
		$this->db->join('dm_jns_item j', 'p.idpaket = j.idpaket AND j.kdakun = i.kdakun AND j.noitem = i.noitem');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdjendok', $kdjendok);
		$this->db->where('p.kdsatker', $kdsatker);
		$this->db->where('p.kddept', $kddept);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('p.kdprogram', $kdprogram);
		$this->db->where('p.kdgiat', $kdgiat);
		$this->db->where('p.kdoutput', $kdoutput);
		$this->db->where('p.kdsoutput', $kdsoutput);
		$this->db->where('p.kdkmpnen', $kdkmpnen);
		$this->db->where('p.kdskmpnen', $kdskmpnen);
		$this->db->where('j.kdjnsitem', '1');
		return $this->db->get();
	}
	
    function get_pagu_skmp_kontraktual($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdsoutput, $kdkmpnen, $kdskmpnen){
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item j');
		$this->db->join('paket p', 'j.idpaket = p.idpaket');
		$this->db->where('p.thang', $thang);
		$this->db->where('p.kdjendok', $kdjendok);
		$this->db->where('p.kdsatker', $kdsatker);
		$this->db->where('p.kddept', $kddept);
		$this->db->where('p.kdunit', $kdunit);
		$this->db->where('p.kdprogram', $kdprogram);
		$this->db->where('p.kdgiat', $kdgiat);
		$this->db->where('p.kdoutput', $kdoutput);
		$this->db->where('p.kdsoutput', $kdsoutput);
		$this->db->where('p.kdkmpnen', $kdkmpnen);
		$this->db->where('p.kdskmpnen', $kdskmpnen);
		$this->db->where('j.kdjnsitem', '2');
		return $this->db->get();
    }
	
	function count_paket_by_prov($kdunit, $kdlokasi, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->where('thang',$thang);
		$this->db->where('kdunit',$kdunit);
		$this->db->where('kdlokasi',$kdlokasi);
		return $this->db->count_all_results();
	}
	
	function count_paket_by_jnssat($kdunit, $kdlokasi, $kdjnssat, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen d');
		$this->db->join('ref_satker k', 'k.kdsatker = d.kdsatker');
		$this->db->where('d.thang',$thang);
		$this->db->where('d.kdunit',$kdunit);
		$this->db->where('d.kdlokasi',$kdlokasi);
		$this->db->where('k.kdjnssat',$kdjnssat);
		return $this->db->count_all_results();
	}
	
	function count_paket_by_satker($kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->where('thang',$thang);
		$this->db->where('kdunit',$kdunit);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('kdsatker',$kdsatker);
		return $this->db->count_all_results();
	}

	function count_output_by_prov($kdunit, $kdlokasi, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_soutput');
		$this->db->where('thang',$thang);
		$this->db->where('kdunit',$kdunit);
		$this->db->where('kdlokasi',$kdlokasi);
		return $this->db->count_all_results();
	}
	
	function count_output_by_jnssat($kdunit, $kdlokasi, $kdjnssat, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_soutput d');
		$this->db->join('ref_satker k', 'k.kdsatker = d.kdsatker');
		$this->db->where('d.thang',$thang);
		$this->db->where('d.kdunit',$kdunit);
		$this->db->where('d.kdlokasi',$kdlokasi);
		$this->db->where('k.kdjnssat',$kdjnssat);
		return $this->db->count_all_results();
	}
	
	function count_output_by_satker($kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$this->db->select('*');
		$this->db->from('d_soutput');
		$this->db->where('thang',$thang);
		$this->db->where('kdunit',$kdunit);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('kdsatker',$kdsatker);
		return $this->db->count_all_results();
	}
	
}
// END dashboard_model Class
/* End of file dashboard_unit_model.php */
/* Location: ./application/models/e-monev/dashboard_unit_model.php */

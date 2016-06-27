<?php
class Laporan_evaluasi_model extends CI_Model {
   
    public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
		$this->load->model('role_model');
    }
	
	function get_program()
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join($this->db->database.'.t_program','d_skmpnen.kdprogram=t_program.kdprogram');
		$this->db->join($this->db->database.'.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		//$this->db->join($this->db->database.'.t_output','d_skmpnen.kdoutput=t_output.kdoutput');
		//$this->db->join($this->db->database.'.d_kmpnen','d_skmpnen.kdmpnen=d_kmpnen.kdkmpnen');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join($this->db->database.'.t_program','d_skmpnen.kdprogram=t_program.kdprogram');
		$this->db->join($this->db->database.'.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		//$this->db->join($this->db->database.'.t_output','d_skmpnen.kdoutput=t_output.kdoutput');
		//$this->db->join($this->db->database.'.d_kmpnen','d_skmpnen.kdmpnen=d_kmpnen.kdkmpnen');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_program2(){
		/*$monev = $this->load->database('monev',TRUE);
		$monev->select('*');*/
		$this->db->select('*');
		$this->db->from($this->db->database.'.t_program');
		$this->db->group_by('t_program.kdprogram');
		//$this->db->join('epkesgabungan.t_program','d_skmpnen.kdprogram=t_program.kdprogram');
		//$this->db->join($this->db->database.'.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		$this->db->join('monev.d_skmpnen','d_skmpnen.kdprogram=t_program.kdprogram');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->db->limit('10');
		return $this->db->get();
	}
	
	function program()
	{
		$thang = $this->session->userdata('thn_anggaran');
		
		$this->db->select('*');
		$this->db->select_sum('jumlah', 'totaljumlah');
		$this->db->from('d_item');
		$this->db->join('t_program', 'd_item.kdprogram = t_program.kdprogram');
		$this->db->where('d_item.thang', $thang);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d_item.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d_item.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->join('ref_satker', 'ref_satker.kdsatker = d_item.kdsatker');
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d_item.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('t_program.kdprogram');
		return $this->db->get();
		
	}
	
	function keg($kddept,$kdprogram)
	{
		$thang = $this->session->userdata('thn_anggaran');
		
		$this->db->select('*');
		$this->db->select_sum('jumlah', 'totaljumlah');
		$this->db->from('d_item');
		$this->db->join('t_giat', 'd_item.kdgiat = t_giat.kdgiat');
		$this->db->where('d_item.thang', $thang);
		$this->db->where('d_item.kdprogram', $kdprogram);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d_item.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d_item.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->join('ref_satker', 'ref_satker.kdsatker = d_item.kdsatker');
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d_item.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('t_giat.kdgiat');
		return $this->db->get();
		
	}
	
	function output($kdprogram,$kdgiat)
	{
		$thang = $this->session->userdata('thn_anggaran');
		
		$this->db->select('*');
		$this->db->select_sum('jumlah', 'totaljumlah');
		$this->db->from('d_item');
		$this->db->join('t_output', 'd_item.kdgiat = t_output.kdgiat AND d_item.kdoutput = t_output.kdoutput');
		$this->db->where('d_item.thang', $thang);
		$this->db->where('d_item.kdprogram', $kdprogram);
		$this->db->where('d_item.kdgiat', $kdgiat);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d_item.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d_item.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->join('ref_satker', 'ref_satker.kdsatker = d_item.kdsatker');
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d_item.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('t_output.kdoutput');
		return $this->db->get();
		
	}
	
	function suboutput($kdprogram,$kdgiat,$kdoutput)
	{
		$thang = $this->session->userdata('thn_anggaran');
		
		$this->db->select('*');
		$this->db->select_sum('jumlah', 'totaljumlah');
		$this->db->from('d_item');
		$this->db->join('d_soutput', 'd_item.kdgiat = d_soutput.kdgiat AND d_item.kdoutput = d_soutput.kdoutput AND d_item.kdsoutput = d_soutput.kdsoutput');
		$this->db->where('d_item.thang', $thang);
		$this->db->where('d_soutput.thang', $thang);
		$this->db->where('d_item.kdprogram', $kdprogram);
		$this->db->where('d_item.kdgiat', $kdgiat);
		$this->db->where('d_item.kdoutput', $kdoutput);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d_item.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d_item.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->join('ref_satker', 'ref_satker.kdsatker = d_item.kdsatker');
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d_item.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('d_soutput.kdsoutput');
		return $this->db->get();
		
	}
	
	function komponen($kdprogram,$kdgiat,$kdoutput,$kdsoutput)
	{
		$thang = $this->session->userdata('thn_anggaran');
		
		$this->db->select('*');
		$this->db->select_sum('jumlah', 'totaljumlah');
		$this->db->from('d_item');
		$this->db->join('d_kmpnen', 'd_item.kdgiat = d_kmpnen.kdgiat AND d_item.kdoutput = d_kmpnen.kdoutput AND d_item.kdsoutput = d_kmpnen.kdsoutput AND d_item.kdkmpnen = d_kmpnen.kdkmpnen');
		$this->db->where('d_item.thang', $thang);
		$this->db->where('d_kmpnen.thang', $thang);
		$this->db->where('d_item.kdprogram', $kdprogram);
		$this->db->where('d_item.kdgiat', $kdgiat);
		$this->db->where('d_item.kdoutput', $kdoutput);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d_item.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d_item.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->join('ref_satker', 'ref_satker.kdsatker = d_item.kdsatker');
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d_item.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('d_kmpnen.kdkmpnen');
		return $this->db->get();
		
	}
	
	function subkomponen($kdprogram,$kdgiat,$kdoutput,$kdsoutput,$kdkmpnen)
	{
		$thang = $this->session->userdata('thn_anggaran');
		
		$this->db->select('*');
		$this->db->select_sum('jumlah', 'totaljumlah');
		$this->db->from('d_item');
		$this->db->join('d_skmpnen', 'd_item.kdgiat = d_skmpnen.kdgiat AND d_item.kdoutput = d_skmpnen.kdoutput AND d_item.kdsoutput = d_skmpnen.kdsoutput AND d_item.kdkmpnen = d_skmpnen.kdkmpnen AND d_item.kdskmpnen = d_skmpnen.kdskmpnen');
		$this->db->where('d_item.thang', $thang);
		$this->db->where('d_skmpnen.thang', $thang);
		$this->db->where('d_item.kdprogram', $kdprogram);
		$this->db->where('d_item.kdgiat', $kdgiat);
		$this->db->where('d_item.kdoutput', $kdoutput);
		$this->db->where('d_item.kdkmpnen', $kdkmpnen);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d_item.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d_item.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->join('ref_satker', 'ref_satker.kdsatker = d_item.kdsatker');
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d_item.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('d_skmpnen.kdskmpnen');
		return $this->db->get();
		
	}
	function get_paket_p($thang, $kdjendok, $kddept, $kdunit, $kdprogram){
		$this->db->select('*');
		$this->db->from('paket');
		$this->db->where('thang', $thang);
		$this->db->where('kdjendok', $kdjendok);
		$this->db->where('kddept', $kddept);
		$this->db->where('kdunit', $kdunit);
		$this->db->where('kdprogram', $kdprogram);
		return $this->db->get();
	}
	
	function get_paket_g($thang, $kdjendok, $kddept, $kdunit, $kdprogram, $kdgiat){
		$this->db->select('*');
		$this->db->from('paket');
		$this->db->where('thang', $thang);
		$this->db->where('kdjendok', $kdjendok);
		$this->db->where('kddept', $kddept);
		$this->db->where('kdunit', $kdunit);
		$this->db->where('kdprogram', $kdprogram);
		$this->db->where('kdgiat', $kdgiat);
		return $this->db->get();
	}
	
	function get_paket_o($thang, $kdjendok, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput){
		$this->db->select('*');
		$this->db->from('paket');
		$this->db->where('thang', $thang);
		$this->db->where('kdjendok', $kdjendok);
		$this->db->where('kddept', $kddept);
		$this->db->where('kdunit', $kdunit);
		$this->db->where('kdprogram', $kdprogram);
		$this->db->where('kdgiat', $kdgiat);
		$this->db->where('kdoutput', $kdoutput);
		return $this->db->get();
	}
	
	function get_paket_so($thang, $kdjendok, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdsoutput){
		$this->db->select('*');
		$this->db->from('paket');
		$this->db->where('thang', $thang);
		$this->db->where('kdjendok', $kdjendok);
		$this->db->where('kddept', $kddept);
		$this->db->where('kdunit', $kdunit);
		$this->db->where('kdprogram', $kdprogram);
		$this->db->where('kdgiat', $kdgiat);
		$this->db->where('kdoutput', $kdoutput);
		$this->db->where('kdsoutput', $kdsoutput);
		return $this->db->get();
	}
	
	function get_paket_k($thang, $kdjendok, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdsoutput, $kdkmpnen){
		$this->db->select('*');
		$this->db->from('paket');
		$this->db->where('thang', $thang);
		$this->db->where('kdjendok', $kdjendok);
		$this->db->where('kddept', $kddept);
		$this->db->where('kdunit', $kdunit);
		$this->db->where('kdprogram', $kdprogram);
		$this->db->where('kdgiat', $kdgiat);
		$this->db->where('kdoutput', $kdoutput);
		$this->db->where('kdsoutput', $kdsoutput);
		$this->db->where('kdkmpnen', $kdkmpnen);
		return $this->db->get();
	}
	
	function get_paket_sk($thang, $kdjendok, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdsoutput, $kdkmpnen, $kdskmpnen){
		$this->db->select('*');
		$this->db->from('paket');
		$this->db->where('thang', $thang);
		$this->db->where('kdjendok', $kdjendok);
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
	
	function get_kdjnsitem($idpaket){
		$this->db->select('kdjnsitem');
		$this->db->from('dm_jns_item');
		$this->db->where('idpaket', $idpaket);
		return $this->db->get();
	}
		
	function get_kegiatan()
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join($this->db->database.'.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join($this->db->database.'.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_sub_komponen_()
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('d_skmpnen');
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
		//$monev->where('d_skmpnen_id','1');
		return $monev->get();
	}
	
	function get_sub()
	{
		$sql = "select distinct kdgiat, kdprogram from monev.d_skmpnen";
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function get_out()
	{
		$sql = "select distinct kdoutput from monev.d_skmpnen";
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function get_pro($kd)
	{
		$sql = "select distinct kdprogram,nmprogram from monev.d_skmpnen where kdprogram=$kd";
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_kmpnen()
	{
		$sql = "select distinct kdkmpnen from monev.d_skmpnen";
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function get_skmpnen()
	{
		$sql = "select distinct kdskmpnen from monev.d_skmpnen";
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function unggah($data,$mode)
	{
		$kode = explode('_',$data['id']);
		if($mode == 1){
			if($kode[0]=='prog'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdprogram',$kode[1]);
				$this->db->where('kddept',$kode[2]);
			}else if($kode[0]=='keg'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdgiat',$kode[1]);
				$this->db->where('kdprogram',$kode[2]);
			}else if($kode[0]=='output'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdprogram',$kode[1]);
				$this->db->where('kdgiat',$kode[2]);
				$this->db->where('kdoutput',$kode[3]);
			}else if($kode[0]=='suboutput'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdprogram',$kode[1]);
				$this->db->where('kdgiat',$kode[2]);
				$this->db->where('kdoutput',$kode[3]);
				$this->db->where('kdsoutput',$kode[4]);
			}else if($kode[0]=='komponen'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdprogram',$kode[1]);
				$this->db->where('kdgiat',$kode[2]);
				$this->db->where('kdoutput',$kode[3]);
				$this->db->where('kdsoutput',$kode[4]);
				$this->db->where('kdkmpnen',$kode[5]);
			}else if($kode[0]=='subkomponen'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdsoutput',$kode[1]);
				$this->db->where('kdkmpnen',$kode[2]);
				$this->db->where('kdprogram',$kode[3]);
				$this->db->where('kdgiat',$kode[4]);
			}
			$data_update['nama_dokumen'] = $data['nama_dokumen'];
			$this->db->update('monev.data_evaluasi', $data_update);
		}else{
			if($kode[0]=='prog'){
				$data_insert['kode_evaluasi'] = $kode[0];
				$data_insert['kdprogram'] = $kode[1];
				$data_insert['kddept'] = $kode[2];
			}else if($kode[0]=='keg'){
				$data_insert['kode_evaluasi'] = $kode[0];
				$data_insert['kdgiat'] = $kode[1];
				$data_insert['kdprogram'] = $kode[2];
			}else if($kode[0]=='output'){
				$data_insert['kode_evaluasi'] = $kode[0];
				$data_insert['kdprogram'] = $kode[1];
				$data_insert['kdgiat'] = $kode[2];
				$data_insert['kdoutput'] = $kode[3];
			}else if($kode[0]=='suboutput'){
				$data_insert['kode_evaluasi'] = $kode[0];
				$data_insert['kdprogram'] = $kode[1];
				$data_insert['kdgiat'] = $kode[2];
				$data_insert['kdoutput'] = $kode[3];
				$data_insert['kdsoutput'] = $kode[4];
			}else if($kode[0]=='komponen'){
				$data_insert['kode_evaluasi'] = $kode[0];
				$data_insert['kdprogram'] = $kode[1];
				$data_insert['kdgiat'] = $kode[2];
				$data_insert['kdoutput'] = $kode[3];
				$data_insert['kdsoutput'] = $kode[4];
				$data_insert['kdkmpnen'] = $kode[5];
			}else if($kode[0]=='subkomponen'){
				$data_insert['kode_evaluasi'] = $kode[0];
				$data_insert['kdsoutput'] = $kode[1];
				$data_insert['kdkmpnen'] = $kode[2];
				$data_insert['kdprogram'] = $kode[3];
				$data_insert['kdgiat'] = $kode[4];
			}
			$data_insert['nama_dokumen'] = $data['nama_dokumen'];
			$this->db->insert('monev.data_evaluasi',$data_insert);
		}
	}
	
	function get_dokumen($id)
	{
		$this->db->select('*');
		$this->db->from('monev.data_evaluasi');
		$kode = explode('_',$id);
		if($kode[0]=='prog'){
			$this->db->where('kode_evaluasi',$kode[0]);
			$this->db->where('kdprogram',$kode[1]);
			$this->db->where('kddept',$kode[2]);
		}else if($kode[0]=='keg'){
			$this->db->where('kode_evaluasi',$kode[0]);
			$this->db->where('kdgiat',$kode[1]);
			$this->db->where('kdprogram',$kode[2]);
		}else if($kode[0]=='output'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdprogram',$kode[1]);
				$this->db->where('kdgiat',$kode[2]);
				$this->db->where('kdoutput',$kode[3]);
		}else if($kode[0]=='suboutput'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdprogram',$kode[1]);
				$this->db->where('kdgiat',$kode[2]);
				$this->db->where('kdoutput',$kode[3]);
				$this->db->where('kdsoutput',$kode[4]);
		}else if($kode[0]=='komponen'){
				$this->db->where('kode_evaluasi',$kode[0]);
				$this->db->where('kdkmpnen',$kode[1]);
				$this->db->where('kdprogram',$kode[2]);
				$this->db->where('kdgiat',$kode[3]);
		}else if($kode[0]=='subkomponen'){
				$this->db->where('kdsoutput',$kode[1]);
				$this->db->where('kdkmpnen',$kode[2]);
				$this->db->where('kdprogram',$kode[3]);
				$this->db->where('kdgiat',$kode[4]);
		}
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
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('i.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('i.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->join('ref_satker', 'ref_satker.kdsatker = i.kdsatker');
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('i.kdunit',$this->session->userdata('kdunit'));
		}
		return $this->db->get();
	}
	
    function get_kontraktual($idpaket){
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item');
		$this->db->where('idpaket', $idpaket);
		$this->db->where('kdjnsitem', '2');
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->join('ref_satker', 'ref_satker.kdsatker = kdsatker');
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('kdunit',$this->session->userdata('kdunit'));
		}
		return $this->db->get();
    }
	
}
?>

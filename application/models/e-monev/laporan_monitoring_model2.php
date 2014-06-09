<?php
class Laporan_monitoring_model2 extends CI_Model {
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	function update($permasalahan_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('permasalahan_id', $permasalahan_id);
		$monev->update('permasalahan', $data);
	}
	
	function update_ref($referensi_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('referensi_id', $referensi_id);
		$monev->update('monev.referensi', $data);
	}
	
	function update_rencana($rencana_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('rencana_id', $rencana_id);
		$monev->update('monev.rencana', $data);
	}
	
	function update_progres($progres_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('progres_id', $progres_id);
		$monev->update('monev.progres', $data);
	}
	
	function update_progres2($spm_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('spm_id', $spm_id);
		$monev->update('monev.spm', $data);
	}
	
	function update_paket($d_skmpnen_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$monev->update('monev.paket', $data);
	}
	
	function update_data_detail_prakontrak($d_skmpnen_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$monev->update('monev.detail_prakontrak', $data);
	}
	
	function update_data_kontrak($d_skmpnen_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$monev->update('monev.kontrak', $data);
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
	
	function delete($table, $kolom, $parameter){
		$this->db->where($kolom, $parameter);
		$this->db->delete($table); 
	}
	
	function delete2($table, $kolom, $parameter, $kolom2, $parameter2){
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->delete($table); 
	}
	
	function delete3($table, $kolom, $parameter, $kolom2, $parameter2, $kolom3, $parameter3){
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->delete($table); 
	}
	
	function delete4($table, $kolom, $parameter, $kolom2, $parameter2, $kolom3, $parameter3, $kolom4, $parameter4){
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->where($kolom4, $parameter4);
		$this->db->delete($table); 
	}
	
	function delete5($table, $kolom, $parameter, $kolom2, $parameter2, $kolom3, $parameter3, $kolom4, $parameter4, $kolom5, $parameter5){
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->where($kolom4, $parameter4);
		$this->db->where($kolom5, $parameter5);
		$this->db->delete($table); 
	}
	
	function delete6($table, $kolom, $parameter, $kolom2, $parameter2, $kolom3, $parameter3, $kolom4, $parameter4, $kolom5, $parameter5, $kolom6, $parameter6){
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->where($kolom4, $parameter4);
		$this->db->where($kolom5, $parameter5);
		$this->db->where($kolom6, $parameter6);
		$this->db->delete($table); 
	}
	
	function get($table){
		$this->db->select('*');
		$this->db->from($table);
		return $this->db->get();
	}
	
	function get_where($tabel,$kolom,$parameter){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		return $this->db->get();
	}
	
	function get_where2($tabel,$kolom,$parameter,$kolom2,$parameter2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		return $this->db->get();
	}
	
	function get_where3($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		return $this->db->get();
	}
	
	function get_where4($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3,$kolom4,$parameter4){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->where($kolom4, $parameter4);
		return $this->db->get();
	}
	
	function get_where_join($tabel,$kolom,$parameter,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $parameter_join);
		$this->db->where($kolom, $parameter);
		return $this->db->get();
	}
	
	function cek($tabel, $kolom1, $param1, $kolom2, $param2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $param1);
		$this->db->where($kolom2, $param2);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function get_sub_komponen(){
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen d');
		$this->db->join('depkesgabungan.d_kmpnen', 'depkesgabungan.d_kmpnen.thang = d.thang AND depkesgabungan.d_kmpnen.kdsatker = d.kdsatker AND depkesgabungan.d_kmpnen.kddept = d.kddept AND depkesgabungan.d_kmpnen.kdunit = d.kdunit AND depkesgabungan.d_kmpnen.kdprogram = d.kdprogram AND depkesgabungan.d_kmpnen.kdgiat = d.kdgiat AND depkesgabungan.d_kmpnen.kdoutput = d.kdoutput AND depkesgabungan.d_kmpnen.kdlokasi = d.kdlokasi AND depkesgabungan.d_kmpnen.kdkabkota = d.kdkabkota AND depkesgabungan.d_kmpnen.kdsoutput = d.kdsoutput AND depkesgabungan.d_kmpnen.kdkmpnen = d.kdkmpnen AND depkesgabungan.d_kmpnen.kdjendok = d.kdjendok  AND depkesgabungan.d_kmpnen.kddekon = d.kddekon', 'left');
		$this->db->join('t_satker', 't_satker.kdsatker = d.kdsatker');
		$this->db->where('d.thang',$this->session->userdata('thn_anggaran'));
		if($this->session->userdata('kd_role') != 8)
		{
			//$this->db->where('thang',date("Y"));
			$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		}
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$monev->select('*');
		$this->db->from('d_skmpnen d');
		$this->db->join('depkesgabungan.d_kmpnen', 'depkesgabungan.d_kmpnen.thang = d.thang AND depkesgabungan.d_kmpnen.kdsatker = d.kdsatker AND depkesgabungan.d_kmpnen.kddept = d.kddept AND depkesgabungan.d_kmpnen.kdunit = d.kdunit AND depkesgabungan.d_kmpnen.kdprogram = d.kdprogram AND depkesgabungan.d_kmpnen.kdgiat = d.kdgiat AND depkesgabungan.d_kmpnen.kdoutput = d.kdoutput AND depkesgabungan.d_kmpnen.kdlokasi = d.kdlokasi AND depkesgabungan.d_kmpnen.kdkabkota = d.kdkabkota AND depkesgabungan.d_kmpnen.kdsoutput = d.kdsoutput AND depkesgabungan.d_kmpnen.kdkmpnen = d.kdkmpnen AND depkesgabungan.d_kmpnen.kdjendok = d.kdjendok  AND depkesgabungan.d_kmpnen.kddekon = d.kddekon', 'left');
		$this->db->join('t_satker', 't_satker.kdsatker = d.kdsatker');
		$this->db->where('d.thang',$this->session->userdata('thn_anggaran'));
		if($this->session->userdata('kd_role') != 8)
		{
			//$this->db->where('thang',date("Y"));
			$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		}
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_program()
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('depkesgabungan.t_program','d_skmpnen.kdprogram=t_program.kdprogram');
		$this->db->join('depkesgabungan.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		//$this->db->join('depkesgabungan.t_output','d_skmpnen.kdoutput=t_output.kdoutput');
		//$this->db->join('depkesgabungan.d_kmpnen','d_skmpnen.kdmpnen=d_kmpnen.kdkmpnen');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('depkesgabungan.t_program','d_skmpnen.kdprogram=t_program.kdprogram');
		$this->db->join('depkesgabungan.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		//$this->db->join('depkesgabungan.t_output','d_skmpnen.kdoutput=t_output.kdoutput');
		//$this->db->join('depkesgabungan.d_kmpnen','d_skmpnen.kdmpnen=d_kmpnen.kdkmpnen');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_program2(){
		/*$monev = $this->load->database('monev',TRUE);
		$monev->select('*');*/
		$this->db->select('*');
		$this->db->from('depkesgabungan22.t_program');
		$this->db->group_by('t_program.kdprogram');
		//$this->db->join('epkesgabungan.t_program','d_skmpnen.kdprogram=t_program.kdprogram');
		//$this->db->join('depkesgabungan.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		$this->db->join('monev.d_skmpnen','d_skmpnen.kdprogram=t_program.kdprogram');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->db->limit('10');
		return $this->db->get();
	}
	
	function get_program3()
	{
		$this->db->select('*');
		$this->db->select_sum('jumlah');
		$this->db->from('depkesgabungan22.d_item');
		$this->db->join('depkesgabungan22.t_program','d_item.kdprogram=t_program.kdprogram');
		//$this->db->join('depkesgabungan22.t_output','d_item.kdoutput=t_output.kdoutput');
		//$this->db->join('depkesgabungan22.t_giat','d_item.kdgiat=t_giat.kdgiat');
		$this->db->group_by('d_item.kdprogram');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->db->limit('10');
		return $this->db->get();
	}
	
	function get_kegiatan()
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('depkesgabungan.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('depkesgabungan.t_giat','d_skmpnen.kdgiat=t_giat.kdgiat');
		$this->db->where('thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function cek_permasalahan_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('permasalahan');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function cek_rencana_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function cek_progres_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function cek_progres2_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function cek_paket($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('permasalahan');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function add($data)
	{
		$this->db->insert('permasalahan',$data);
	}
	
	function add_sp2d($data)
	{
		$this->db->insert('monev.sp2d',$data);
	}
	
	function add_rencana($data)
	{
		$this->db->insert('monev.rencana',$data);
	}
	
	function add_progres($data)
	{
		$this->db->insert('monev.progres',$data);
	}
	
	function add_progres2($data)
	{
		$this->db->insert('monev.spm',$data);
	}
	
	function add_paket($data)
	{
		$this->db->insert('monev.paket',$data);
	}
	
	function add_detailprakontrak($data)
	{
		$this->db->insert('monev.detail_prakontrak',$data);
	}
	
	function add_data_kontrak($data)
	{
		$this->db->insert('monev.kontrak',$data);
	}
	
	function add_jadual_pelaksanaan($data)
	{
		$this->db->insert('monev.jadual_pelaksanaan',$data);
	}
	
	function get_permasalahan($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('permasalahan');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		return $monev->get()->result();
	}
	
	function get_rencana($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get()->result();
	}
	
	function cek_presentase_rencana($d_skmpnen_id,$rencana_id)
	{
		/*
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('rencana_id <>', $rencana_id);*/
		$sql = 'select * from monev.rencana where d_skmpnen_id = '.$d_skmpnen_id.' and tahun = '.$this->session->userdata('thn_anggaran').' and rencana_id <> '.$rencana_id.'';
		return $this->db->query($sql)->result();
	}
	
	function cek_presentase_progres($d_skmpnen_id,$progres_id)
	{
		/*
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('rencana_id <>', $rencana_id);*/
		$sql = 'select * from monev.progres where d_skmpnen_id = '.$d_skmpnen_id.' and tahun = '.$this->session->userdata('thn_anggaran').' and progres_id <> '.$progres_id.'';
		return $this->db->query($sql)->result();
	}
	
	function get_rencana2($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_referensi()
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.referensi');
		return $monev->get();
	}
	
	function is_exist_fisik_more_than_100_bef($d_skmpnen_id,$progres_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('progres_id <',$progres_id);
		$monev->where('fisik',100);
		if($monev->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function is_exist_fisik_more_than_100_af($d_skmpnen_id,$progres_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('progres_id >',$progres_id);
		$monev->where('fisik',100);
		if($monev->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_progres($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get()->result();
	}
	
	function get_progress($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_progres2($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get()->result();
	}
	
	function get_progress2($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_provinsi()
	{
		$this->db->select();
		$this->db->from('depkesgabungan.ref_provinsi');
		return $this->db->get()->result();
	}
	
	function get_kppn()
	{
		$this->db->select();
		$this->db->from('depkesgabungan.ref_kppn');
		return $this->db->get()->result();
	}
	
	function get_kabupaten_by_kode_provinsi($kode_provinsi)
	{
		$this->db->select();
		$this->db->from('ref_kabupaten');
		$this->db->where('KodeProvinsi',$kode_provinsi);
		return $this->db->get()->result();
	}
	
	function get_permasalahan_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('permasalahan');
		$monev->where('permasalahan_id',$id);
		return $monev->get();
	}
	
	function get_referensi_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.referensi');
		$monev->where('referensi_id',$id);
		return $monev->get();
	}
	
	function get_rencana_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('rencana_id',$id);
		return $monev->get();
	}
	
	function get_progres_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('progres_id',$id);
		return $monev->get();
	}
	
	function get_progres2_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('spm_id',$id);
		return $monev->get();
	}
	
	function get_sp2d_by_spm_id($spm_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.sp2d');
		$monev->where('spm_id',$spm_id);
		return $monev->get();
	}
	
	function get_paket_by_d_skmpnen_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('paket');
		$monev->where('d_skmpnen_id',$id);
		return $monev->get();
	}
	
	function get_prakontrak_by_d_skmpnen_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('detail_prakontrak');
		$monev->where('d_skmpnen_id',$id);
		return $monev->get();
	}
	
	function get_kontrak_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.kontrak');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_jadual_pelaksanaan_by_d_skmpnen_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.jadual_pelaksanaan');
		$monev->where('d_skmpnen_id',$id);
		return $monev->get();
	}
	
	function get_nama_provinsi_by_kode_provinsi($kode_provinsi)
	{
		$this->db->select();
		$this->db->from('depkesgabungan.ref_provinsi');
		$this->db->where('KodeProvinsi',$kode_provinsi);
		return $this->db->get();
	}
	
	function cek_paket_pengerjaan($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.paket');
		$monev->where('paket_pengerjaan',0);
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function cek_paket2($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.paket');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_nama_kabupaten_by_kode_kabupaten($kode_kabupaten,$kode_provinsi)
	{
		$this->db->select();
		$this->db->from('depkesgabungan.ref_kabupaten');
		$this->db->where('KodeKabupaten',$kode_kabupaten);
		$this->db->where('KodeProvinsi',$kode_provinsi);
		return $this->db->get();
	}
	
	function get_nama_kppn_by_kode_kppn($kode_kppn)
	{
		$this->db->select();
		$this->db->from('depkesgabungan.ref_kppn');
		$this->db->where('KDKPPN',$kode_kppn);

		return $this->db->get();
	}
	
	function get_sub_komponen_by_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('d_skmpnen');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
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
	
	function getAlokasi($kdprogram)
	{
		$sql = "SELECT SUM(jumlah) as total FROM `d_item` WHERE `kdprogram`= $kdprogram";	
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function getAlokasiKeg($kdprogram,$kdgiat)
	{
		$sql = "SELECT SUM(jumlah) as total FROM d_item WHERE kdprogram=$kdprogram and kdgiat=$kdgiat";	
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function getAlokasiOut($kdgiat,$kdoutput,$kdsoutput)
	{
		$sql = "SELECT SUM(jumlah) as total FROM d_item WHERE kdoutput=$kdoutput and kdgiat=$kdgiat and kdsoutput=$kdsoutput";	
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function getAlokasiSubOut($kdsoutput,$kdgiat,$kdprogram)
	{
		$sql = "SELECT SUM(jumlah) as total FROM d_item WHERE kdsoutput=$kdsoutput and kdgiat=$kdgiat and kdprogram=$kdprogram";	
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function getSubOutput($kdgiat,$kdsoutput)
	{
		$sql = "SELECT * FROM depkesgabungan22.d_soutput WHERE kdgiat=$kdgiat and kdsoutput=$kdsoutput LIMIT 10";	
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function getKomponen($kdprogram,$kdgiat,$kdoutput,$kdsoutput)
	{
		$sql = "select * from depkesgabungan22.d_kmpnen where kdprogram=$kdprogram and kdgiat=$kdgiat and kdoutput=$kdoutput and kdsoutput=$kdsoutput LIMIT 1";	
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function getSubKomponen($kdgiat,$kdoutput,$kdkmpnen)
	{
		$sql = "select * from depkesgabungan22.d_skmpnen where kdgiat=$kdgiat and kdoutput=$kdoutput and kdkmpnen=$kdkmpnen LIMIT 1";	
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_alokasi($kdprogram,$kdgiat,$kdoutput,$kdkmpnen)
	{
		$sql = "select SUM(jumlah) as total from depkesgabungan.d_item where kdprogram='$kdprogram' and kdgiat='$kdgiat' and kdoutput='$kdoutput' and kdkmpnen='$kdkmpnen'";
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function get_keuangan($d_skmpnen_id)
	{
		$sql = "select SUM(nominal) as total_nominal from monev.spm where d_skmpnen_id=$d_skmpnen_id";	
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function get_jumlah_prog($kdprogram)
	{
		$sql = "select SUM(jumlah) as total from depkesgabungan.d_item where kdprogram=$kdprogram and kdsatker=465930";
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_jumlah_keg($kdgiat,$kdprogram)
	{
		$sql = "select SUM(jumlah) as total from depkesgabungan.d_item where kdgiat=$kdgiat and kdprogram=$kdprogram and kdsatker=465930";
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_jumlah_output($kdgiat,$kdoutput)
	{
		$sql = "select SUM(jumlah) as total from depkesgabungan.d_item where kdgiat=$kdgiat and kdoutput=$kdoutput and kdsatker=465930;";	
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_jumlah_kmpnen($kdgiat,$kdoutput,$kdkmpnen)
	{
		$sql = "select SUM(jumlah) as total from depkesgabungan.d_item where kdgiat=$kdgiat and kdoutput=$kdoutput and kdkmpnen=$kdkmpnen and kdsatker=465930;";	
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_jumlah_skmpnen($kdgiat,$kdoutput,$kdkmpnen)
	{
		$sql = "select SUM(jumlah) as total from depkesgabungan.d_item where kdgiat=$kdgiat and kdoutput=$kdoutput and kdkmpnen=$kdkmpnen and kdsatker=465930;";	
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_d_item($thang,$kdjendok,$kdsatker,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdlokasi,$kdkabkota,$kddekon,$kdsoutput,$kdkmpnen)
	{
		$this->db->select('*');
		$this->db->from('depkesgabungan.d_item');
		$this->db->join('depkesgabungan.t_akun','depkesgabungan.d_item.kdakun = depkesgabungan.t_akun.kdakun');
		$this->db->where('thang',$thang);
		$this->db->where('kdjendok',$kdjendok);
		$this->db->where('kdsatker',$kdsatker);
		$this->db->where('kddept',$kddept);
		$this->db->where('kdunit',$kdunit);
		$this->db->where('kdprogram',$kdprogram);
		$this->db->where('kdgiat',$kdgiat);
		$this->db->where('kdoutput',$kdoutput);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('kdkabkota',$kdkabkota);
		$this->db->where('kddekon',$kddekon);
		$this->db->where('kdsoutput',$kdsoutput);
		$this->db->where('kdkmpnen',$kdkmpnen);
		return $this->db->get();
	}
	
	function unggah($data,$mode)
	{
		if($mode == 1){
			$this->db->where('d_skmpnen_id', $data['d_skmpnen_id']);
			$this->db->update('monev.data_dokumen', $data);
		}else{
			$this->db->insert('monev.data_dokumen',$data);
		}
	}
	
	function get_dokumen($d_skmpnen_id)
	{
		$this->db->select('*');
		$this->db->from('monev.data_dokumen');
		$this->db->where('d_skmpnen_id',$d_skmpnen_id);
		return $this->db->get();
	}

	function get_progres_by_bulan($d_skmpnen_id, $bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',$bulan);
		return $monev->get();
	}

	function get_progres_evaluasi($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_spm_by_bulan($d_skmpnen_id, $bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
	
	function is_exist_renc_fisik_more_than_100_bef($d_skmpnen_id,$rencana_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('rencana_id <',$rencana_id);
		$monev->where('fisik',100);
		if($monev->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function is_exist_renc_keuangan_more_than_100_bef($d_skmpnen_id,$rencana_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('rencana_id <',$rencana_id);
		$monev->where('keuangan',100);
		if($monev->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function keg($kddept,$kdprogram)
	{
		$sql = "SELECT distinct d_item.kdgiat,t_giat.nmgiat FROM depkesgabungan22.d_item join depkesgabungan22.t_giat on d_item.kdgiat=t_giat.kdgiat WHERE d_item.kddept=$kddept and d_item.kdprogram=$kdprogram and d_item.thang=2013 order by d_item.kdgiat asc";
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function output($kdprogram,$kdgiat)
	{
		$sql = "select * from t_output join t_giat on t_output.kdgiat=t_giat.kdgiat join d_item on d_item.kdoutput=t_output.kdoutput and t_giat.kdprogram=d_item.kdprogram and t_giat.kdgiat=d_item.kdgiat where t_giat.kdprogram=$kdprogram and t_giat.kdgiat=$kdgiat group by d_item.kdoutput";
		
		$query = $this->db->query($sql);
		
		return $query;	
	}
	
	function suboutput($kdprogram,$kdgiat)
	{
		$sql = "select * from d_soutput join t_giat on d_soutput.kdgiat=t_giat.kdgiat join d_item on d_item.kdoutput=d_soutput.kdsoutput and t_giat.kdprogram=d_item.kdprogram and t_giat.kdgiat=d_item.kdgiat where t_giat.kdprogram=$kdprogram and t_giat.kdgiat=$kdgiat group by d_item.kdsoutput limit 1";
		
		$query = $this->db->query($sql);
		
		return $query;	
	}

	function get_grid_dokumen($d_skmpnen_id)
	{
		$this->db->select('*');
		$this->db->from('monev.data_dokumen');
		$this->db->where('d_skmpnen_id',$d_skmpnen_id);
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('monev.data_dokumen');
		$this->db->where('d_skmpnen_id',$d_skmpnen_id);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_dokumen_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('monev.data_dokumen');
		$this->db->where('data_dokumen_id',$id);
		return $this->db->get();
	}
	
	function hapus_dokumen($id)
	{
		$this->db->delete('monev.data_dokumen', array('data_dokumen_id' => $id));
	}
}	
	

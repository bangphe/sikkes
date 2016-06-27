<?php
class Manajemen_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
	}
	
	function save($table, $data){
		$this->db->insert($table, $data);
	}
	
	function update($table, $data, $kolom, $parameter){
		$this->db->where($kolom, $parameter);
		$this->db->update($table, $data);
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
	
	function get_where2_join($tabel,$kolom,$parameter,$kolom2,$parameter2,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $parameter_join);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
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
	
	function get_where3_join($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		return $this->db->get();
	}
	
	function get_where4_join($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3,$kolom4,$parameter4,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->where($kolom4, $parameter4);
		$this->db->join($tabel_join,$parameter_join);
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
	
	function get_where5_join($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3,$kolom4,$parameter4,$kolom5,$parameter5,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->where($kolom4, $parameter4);
		$this->db->where($kolom5, $parameter5);
		$this->db->join($tabel_join,$parameter_join);
		return $this->db->get();
	}
	
	function get_where5($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3,$kolom4,$parameter4,$kolom5,$parameter5){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->where($kolom4, $parameter4);
		$this->db->where($kolom5, $parameter5);
		return $this->db->get();
	}
	function get_where9($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3,$kolom4,$parameter4,$kolom5,$parameter5,$kolom6,$parameter6,$kolom7,$parameter7,$kolom8,$parameter8,$kolom9,$parameter9){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$this->db->where($kolom4, $parameter4);
		$this->db->where($kolom5, $parameter5);
		$this->db->where($kolom6, $parameter6);
		$this->db->where($kolom7, $parameter7);
		$this->db->where($kolom8, $parameter8);
		$this->db->where($kolom9, $parameter9);
		return $this->db->get();
	}
	function get_join($tabel,$tabel_join,$param_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $param_join);
		return $this->db->get();
	}
	
	function get_where_join($tabel,$tabel_join,$param_join,$kolom,$param){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $param_join);
		$this->db->where($kolom, $param);
		return $this->db->get();
	}
	
	function get_where_double_join($tabel,$tabel_join,$param_join,$tabel_join2,$param_join2,$kolom,$param){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $param_join);
		$this->db->join($tabel_join2, $param_join2);
		$this->db->where($kolom, $param);
		return $this->db->get();
	}
	
	function sum($tabel,$kolom, $kolom1,$param1){
		$this->db->select_sum($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom1, $param1);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->$kolom;
		}
		return $Biaya;
	}
	function sum2($tabel,$kolom, $kolom1,$param1, $kolom2,$param2){
		$this->db->select_sum($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom1, $param1);
		$this->db->where($kolom2, $param2);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->$kolom;
		}
		return $Biaya;
	}
	function get_count_by_user()
	{
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		return $this->db->get();
	}
	
	function get_count_by_acc()
	{
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->where('no_reg_satker', $this->session->userdata('kdsatker'));
		$this->db->where('status =', 4);
		return $this->db->get();
	}
	
	function get_count_by_ref()
	{
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 5);
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		return $this->db->get();
	}
	
	function get_count_by_con()
	{
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 6);
		return $this->db->get();
	}
	
	function get_count_iku()
	{
		$this->db->select('*');
		$this->db->from('target_iku');
		$this->db->join('data_iku','target_iku.KodeIku=data_iku.KodeIku');
		$this->db->where('idThnAnggaran',$this->session->userdata('thn_anggaran'));
		return $this->db->count_all_results();
	}
	
	function get_count_ikk()
	{
		$this->db->select('*');
		$this->db->from('target_ikk');
		$this->db->join('data_ikk','target_ikk.KodeIkk=data_ikk.KodeIkk');
		$this->db->where('idThnAnggaran',$this->session->userdata('thn_anggaran'));
		return $this->db->count_all_results();
	}
	
	function get_count_by_app()
	{
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 2);
		return $this->db->get();
	}
	
	function get_count_by_dekon()
	{
		$kdlokasi='';
		$kdunit='';
		foreach($this->get_prov_unit()->result() as $row){
			$kdlokasi = $row->kdlokasi;
			$kdunit = $row->kdunit;
		}
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->where('KodeJenisSatker !=', 3);
		$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
		$this->db->or_where('STATUS', 1);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('kdunit',$kdunit);
		return $this->db->get();	
	}
	
	function get_prov_unit(){
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		return $this->db->get();
	}

	function get_satker_kegiatan(){
		$this->db->select('*');
		$this->db->from('ref_satker_kegiatan');
		$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		return $this->db->get();
	}
	
	function get_data_pengajuan(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function cek_satker_kementerian(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('ref_satker','users.kdsatker=ref_satker.kdsatker');
		$this->db->where('users.kdsatker', $this->session->userdata('kdsatker'));
		$this->db->like('nmsatker', 'direktorat');
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function get_data_pengajuan_dekon(){
		$kdlokasi='';
		// $kdunit='';
		foreach($this->get_prov_unit()->result() as $row){
			$kdlokasi = $row->kdlokasi;
			// $kdunit = $row->kdunit;
		}
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('KodeJenisSatker !=', 3);
		$this->db->where('KodeJenisSatker !=', 4);
		$this->db->where('KodeJenisSatker !=', 5);
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('KodeJenisSatker !=', 3);
		$this->db->where('KodeJenisSatker !=', 4);
		$this->db->where('KodeJenisSatker !=', 5);
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}

	function get_data_pengajuan_direktorat(){
		$kdlokasi='';
		foreach($this->get_prov_unit()->result() as $row){
			$kdlokasi = $row->kdlokasi;
		}
		foreach($this->get_satker_kegiatan()->result() as $row){
			$kdsatker_kegiatan = $row->KodeKegiatan;
		}

		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->join('data_kegiatan','pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		$this->db->where('data_kegiatan.KodeKegiatan =', $kdsatker_kegiatan);
		// if($this->session->userdata('eselon') == '1') {
		// 	$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		// 	$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		// }
		// elseif($this->session->userdata('eselon') == '2') {
		// 	$this->db->join('data_kegiatan','pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		// 	$this->db->like('data_kegiatan.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		// }
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		//$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS !=', 0);
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->join('data_kegiatan','pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		$this->db->where('data_kegiatan.KodeKegiatan =', $kdsatker_kegiatan);
		// if($this->session->userdata('eselon') == '1') {
		// 	$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		// 	$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		// }
		// elseif($this->session->userdata('eselon') == '2') {
		// 	$this->db->join('data_kegiatan','pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		// 	$this->db->like('data_kegiatan.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		// }
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		//$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS !=', 0);
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_pengajuan_unit_utama(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();

		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}

	function get_data_pengajuan_roren(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_kegiatan', 'pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		//$this->db->where('STATUS', 0);
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 6);
		$this->db->where('STATUS !=', 7);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();

		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_kegiatan', 'pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		//$this->db->where('STATUS', 0);
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 6);
		$this->db->where('STATUS !=', 7);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
		
	}

	function get_data_pertimbangan(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 6);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 6);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_persetujuan(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 3);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 3);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_disetujui(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 4);
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL)
			$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		if ($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2){
			$this->db->where('ref_satker.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		if ($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3){
			$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
			$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		}
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();

		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 4);
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL)
			$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		if ($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2){
			$this->db->where('ref_satker.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		if ($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3){
			$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
			$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		}
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_cetak(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 4);
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		return $this->db->get();
	}
	
	function get_data_ditolak(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL)
			$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		if ($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2){
			$this->db->where('ref_satker.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		if ($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3){
			$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
			$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		}
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('(`STATUS` =  5 OR `STATUS` =  7)');
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();

		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL)
			$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		if ($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2){
			$this->db->where('ref_satker.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->where('ref_satker.kdjnssat', 4);
		}
		if ($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3){
			$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
			$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		}
		$this->db->where('STATUS', 5);
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->or_where('STATUS', 7);
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_fungsi($KodePengajuan){
		$this->db->select('*');
		$this->db->from('data_fungsi');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('data_fungsi');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_telaah_staff($KodePengajuan){
		$this->db->select('*');
		$this->db->from('data_telaah_staff');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('data_telaah_staff');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_subFungsi($kodePengajuan,$KodeFungsi){
		$this->db->select('*');
		$this->db->from('data_sub_fungsi');
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KD_Pengajuan',$kodePengajuan);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('data_sub_fungsi');
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KD_Pengajuan',$kodePengajuan);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_Program($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi){
		$this->db->select('*');
		$this->db->from('data_program');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('data_program');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_kegiatan($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram){
		$this->db->select('*');
		$this->db->from('data_kegiatan');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeFungsi.".".$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('data_kegiatan');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeFungsi.".".$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_iku($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram){
		$this->db->select('*');
		$this->db->from('data_iku');
		$this->db->join('ref_iku','data_iku.KodeIku=ref_iku.KodeIku');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('data_iku.KodeProgram',$KodeProgram);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('data_iku');
		$this->db->join('ref_iku','data_iku.KodeIku=ref_iku.KodeIku');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('data_iku.KodeProgram',$KodeProgram);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_ikk($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$this->db->select('*');
		$this->db->from('data_ikk');
		$this->db->join('ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('data_ikk.KodeKegiatan',$KodeKegiatan);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('data_ikk');
		$this->db->join('ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('data_ikk.KodeKegiatan',$KodeKegiatan);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_menu_kegiatan($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk){
		$this->db->select('*');
		$this->db->from('data_menu_kegiatan');
		$this->db->join('ref_menu_kegiatan','data_menu_kegiatan.KodeMenuKegiatan=ref_menu_kegiatan.KodeMenuKegiatan');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('data_menu_kegiatan.KodeProgram',$KodeProgram);
		$this->db->where('data_menu_kegiatan.KodeKegiatan',$KodeKegiatan);
		$this->db->where('data_menu_kegiatan.KodeIkk',$KodeIkk);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('data_menu_kegiatan');
		$this->db->join('ref_menu_kegiatan','data_menu_kegiatan.KodeMenuKegiatan=ref_menu_kegiatan.KodeMenuKegiatan');
		$this->db->where('KD_Pengajuan',$KD_Pengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('data_menu_kegiatan.KodeProgram',$KodeProgram);
		$this->db->where('data_menu_kegiatan.KodeKegiatan',$KodeKegiatan);
		$this->db->where('data_menu_kegiatan.KodeIkk',$KodeIkk);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function cek_kegiatan($kd_pengajuan){
		$this->db->select('*');
		$this->db->from('data_kegiatan');
		$this->db->where('KD_PENGAJUAN', $kd_pengajuan);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function cek($tabel,$kolom,$parameter){
		$this->db->select('*');
		$this->db->where($kolom,$parameter);
		return $this->db->count_all_results($tabel);
	}
	
	function cek2($tabel,$kolom,$parameter,$kolom2,$parameter2){
		$this->db->select('*');
		$this->db->where($kolom,$parameter);
		$this->db->where($kolom2,$parameter2);
		return $this->db->count_all_results($tabel);
	}
	
	function cek3($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3){
		$this->db->select('*');
		$this->db->where($kolom,$parameter);
		$this->db->where($kolom2,$parameter2);
		$this->db->where($kolom3,$parameter3);
		return $this->db->count_all_results($tabel);
	}
	
	function cek4($tabel,$kolom,$parameter,$kolom2,$parameter2,$kolom3,$parameter3,$kolom4,$parameter4){
		$this->db->select('*');
		$this->db->where($kolom,$parameter);
		$this->db->where($kolom2,$parameter2);
		$this->db->where($kolom3,$parameter3);
		$this->db->where($kolom4,$parameter4);
		return $this->db->count_all_results($tabel);
	}
	
	function get_kab(){
		$query = "select ref_satker.*, ref_kabupaten.NamaKabupaten as kab from ref_satker left join ref_kabupaten on ref_kabupaten.KodeProvinsi=ref_satker.kdlokasi where ref_satker.kdkabkota=ref_kabupaten.KodeKabupaten and ref_satker.kdlokasi=ref_kabupaten.KodeProvinsi and ref_satker.kdsatker=010024";
		
		$query = $this->db->query($query);
		return $query;	
	}
	
	function get_data_telah_ditelaah(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		$this->db->where('STATUS', 4);
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		$this->db->where('STATUS', 5);
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		$this->db->where('STATUS', 7);
		$this->db->order_by('TANGGAL_PENGAJUAN', 'desc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();

		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		$this->db->where('STATUS', 4);
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		$this->db->where('STATUS', 5);
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('NO_REG_SATKER',$this->session->userdata('kdsatker'));
		$this->db->where('STATUS', 7);
		$this->db->order_by('TANGGAL_PENGAJUAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	function get_data_telah_ditelaah_dekon(){
		$kdlokasi='';
		// $kdunit='';
		foreach($this->get_prov_unit()->result() as $row){
			$kdlokasi = $row->kdlokasi;
			// $kdunit = $row->kdunit;
		}
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS', 4);
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS', 5);
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS', 7);
		$this->db->order_by('TANGGAL_PENGAJUAN', 'desc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();

		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS', 4);
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS', 5);
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS', 7);
		$this->db->order_by('TANGGAL_PENGAJUAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	function get_data_telah_ditelaah_unit_utama(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 4);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 5);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 7);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->order_by('TANGGAL_PENGAJUAN', 'desc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 4);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 5);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->or_where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS', 7);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->order_by('TANGGAL_PENGAJUAN', 'desc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}

	function get_proposal_belum_disetujui($thn_anggaran){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER');
		$this->db->where('STATUS !=', '0');
		$this->db->where('STATUS !=', '4');
		$this->db->where('STATUS !=', '5');
		$this->db->where('STATUS !=', '6');
		$this->db->where('STATUS !=', '7');
		$this->db->where('TAHUN_ANGGARAN', $thn_anggaran);
		return $this->db->get();
		
	}
	
	function rekap_data_pengajuan_satker(){
		$this->db->select('*');
		$this->db->from('pengajuasn');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_kegiatan','pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		$this->db->join('ref_kegiatan','data_kegiatan.KodeKegiatan=ref_kegiatan.KodeKegiatan');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->where('STATUS !=', 8);
		$this->db->where('ref_kegiatan.KodeKegiatan =', 2093);
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		
		return $this->db->get();
	}

	function rekap_data_pengajuan_unit_utama(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
		$this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
		$this->db->where('STATUS !=', 4);
		$this->db->where('STATUS !=', 5);
		$this->db->where('STATUS !=', 7);
		$this->db->like('data_program.KodeProgram','024.'.$this->session->userdata('kdunit'), 'after');
		$this->db->order_by('TANGGAL_PEMBUATAN', 'desc');
		
		return $this->db->get();
	}
}

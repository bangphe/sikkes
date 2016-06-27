<?php
class Filtering_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
    
	/*
	function get_program($kode_kementrian){
		$this->db->select('*');
		$this->db->from('ref_program');
		$this->db->where('KodeKementerian',$kode_kementrian);
		return $this->db->get();
	}
	*/
	
	function getProv($kode)
	{
		$sql = "select * from ref_provinsi where KodeProvinsi='$kode'";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function get_search($kode_kementrian, $keyword, $kategori){
		$this->db->select('*');
		$this->db->from('ref_program');
		$this->db->where('KodeKementerian',$kode_kementrian);
		$this->db->like($kategori,$keyword);
		return $this->db->get();
	}
	
	function get($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function k_program(){
		$this->db->select('KodeProgram');
		$this->db->from('ref_satker_program');
		$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
		return $this->db->get();
	}
	
	function get_program($tabel){
		$program="";
		foreach($this->k_program()->result() as $row){
			$program[$row->KodeProgram] = $row->KodeProgram;
		}
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where_in('KodeProgram', $program);
		return $this->db->get();
	}
	
	function get_program_prioritas($tabel){
		$program="";
		foreach($this->k_program()->result() as $row){
			$program[$row->KodeProgram] = $row->KodeProgram;
		}
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where('KodeStatus','1');
		$this->db->where_in('KodeProgram', $program);
		return $this->db->get();
	}
	
	function cek($tabel, $parameter1, $kolom1){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $parameter1);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function cek_where_in_double_param($tabel,$kolom1,$parameter1,$kolom2,$parameter2,$table2,$array){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $parameter1);
		$this->db->where($kolom2, $parameter2);
		$this->db->where_in($table2, $array);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function get_data_pengajuan($provinsi, $data_program, $data_iku, $data_kegiatan, $data_ikk, $fokus_prioritas, $reformasi_kesehatan){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		if($fokus_prioritas != NULL) $this->db->join('data_fokus_prioritas','pengajuan.KD_PENGAJUAN=data_fokus_prioritas.KD_PENGAJUAN');
		if($reformasi_kesehatan != NULL) $this->db->join('data_reformasi_kesehatan','pengajuan.KD_PENGAJUAN=data_reformasi_kesehatan.KD_PENGAJUAN');
		if($data_program != NULL) $this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		if($data_iku != NULL) $this->db->join('data_iku','pengajuan.KD_PENGAJUAN=data_iku.KD_PENGAJUAN');
		if($data_kegiatan != NULL) $this->db->join('data_kegiatan','pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		if($data_ikk != NULL) $this->db->join('data_ikk','pengajuan.KD_PENGAJUAN=data_ikk.KD_PENGAJUAN');
		if($provinsi != NULL) $this->db->where_in('kdlokasi',$provinsi);
		if($fokus_prioritas != NULL) $this->db->where_in('idFokusPrioritas',$fokus_prioritas);
		if($reformasi_kesehatan != NULL) $this->db->where_in('idReformasiKesehatan',$reformasi_kesehatan);
		if($data_program != NULL) $this->db->where_in('data_program.KodeProgram',$data_program);
		if($data_kegiatan != NULL) $this->db->where_in('data_kegiatan.KodeKegiatan',$data_kegiatan);
		if($data_iku != NULL) $this->db->where_in('data_iku.KodeIku',$data_iku);
		if($data_ikk != NULL) $this->db->where_in('data_ikk.KodeIkk',$data_ikk);
		$this->db->where('STATUS',3);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		if($fokus_prioritas != NULL) $this->db->join('data_fokus_prioritas','pengajuan.KD_PENGAJUAN=data_fokus_prioritas.KD_PENGAJUAN');
		if($reformasi_kesehatan != NULL) $this->db->join('data_reformasi_kesehatan','pengajuan.KD_PENGAJUAN=data_reformasi_kesehatan.KD_PENGAJUAN');
		if($data_program != NULL) $this->db->join('data_program','pengajuan.KD_PENGAJUAN=data_program.KD_PENGAJUAN');
		if($data_iku != NULL) $this->db->join('data_iku','pengajuan.KD_PENGAJUAN=data_iku.KD_PENGAJUAN');
		if($data_kegiatan != NULL) $this->db->join('data_kegiatan','pengajuan.KD_PENGAJUAN=data_kegiatan.KD_PENGAJUAN');
		if($data_ikk != NULL) $this->db->join('data_ikk','pengajuan.KD_PENGAJUAN=data_ikk.KD_PENGAJUAN');
		if($provinsi != NULL) $this->db->where_in('kdlokasi',$provinsi);
		if($fokus_prioritas != NULL) $this->db->where_in('idFokusPrioritas',$fokus_prioritas);
		if($reformasi_kesehatan != NULL) $this->db->where_in('idReformasiKesehatan',$reformasi_kesehatan);
		if($data_program != NULL) $this->db->where_in('data_program.KodeProgram',$data_program);
		if($data_kegiatan != NULL) $this->db->where_in('data_kegiatan.KodeKegiatan',$data_kegiatan);
		if($data_iku != NULL) $this->db->where_in('data_iku.KodeIku',$data_iku);
		if($data_ikk != NULL) $this->db->where_in('data_ikk.KodeIkk',$data_ikk);
		$this->db->where('STATUS',3);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function cek_triple($tabel, $parameter1, $kolom1, $parameter2, $kolom2, $parameter3, $kolom3){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $parameter1);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom3, $parameter3);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function cek_double($tabel, $parameter1, $kolom1, $parameter2, $kolom2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $parameter1);
		$this->db->where($kolom2, $parameter2);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function get_ikk($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->limit(20);
		return $this->db->get();
	}
	
	function get_where($tabel,$kolom,$parameter){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		return $this->db->get();
	}
	
	function k_iku(){
		$this->db->select('KodeIku');
		$this->db->from('ref_satker_iku');
		$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
		return $this->db->get();
	}
	
	function k_kegiatan(){
		$this->db->select('KodeKegiatan');
		$this->db->from('ref_satker_kegiatan');
		$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
		return $this->db->get();
	}
	
	function k_ikk(){
		$this->db->select('KodeIkk');
		$this->db->from('ref_satker_ikk');
		$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
		return $this->db->get();
	}
	
	function get_where_iku($tabel,$kolom,$parameter){
		$iku="";
		foreach($this->k_iku()->result() as $row){
			$iku[$row->KodeIku] = $row->KodeIku;
		}
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->where_in('KodeIku',$iku);
		return $this->db->get();
	}
	
	function get_where_kegiatan($tabel,$kolom,$parameter){
		$kegiatan="";
		foreach($this->k_kegiatan()->result() as $row){
			$kegiatan[$row->KodeKegiatan] = $row->KodeKegiatan;
		}
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->where_in('KodeKegiatan',$kegiatan);
		return $this->db->get();
	}
	
	function get_where_ikk($tabel,$kolom,$parameter){
		$ikk="";
		foreach($this->k_ikk()->result() as $row){
			$ikk[$row->KodeIkk] = $row->KodeIkk;
		}
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->where_in('KodeIkk',$ikk);
		return $this->db->get();
	}
	
	function get_where_double($tabel,$kolom,$parameter,$kolom2,$parameter2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->where($kolom2,$parameter2);
		return $this->db->get();
	}
}
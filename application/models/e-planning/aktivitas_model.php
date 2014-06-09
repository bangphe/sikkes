<?php
class Aktivitas_model extends CI_Model {
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
	
	function deleteAktivitas($KodeAktivitas){
		$this->db->where('KodeAktivitas', $KodeAktivitas);
		$this->db->delete('aktivitas'); 
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
	
	function get_where_join($tabel,$kolom,$parameter,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $parameter_join);
		$this->db->where($kolom, $parameter);
		return $this->db->get();
	}
	
	function get_where_join_satuan($tabel,$kolom,$parameter,$tabel_join,$parameter_join){
		$this->db->select('satuan');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $parameter_join);
		$this->db->where($kolom, $parameter);
		return $this->db->get();
	}
	
	function get_where_join_pembiayaan($tabel,$kolom,$parameter,$tabel_join,$parameter_join){
		$this->db->select('JenisPembiayaan');
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
	
	function get_aktivitas($KD_PENGAJUAN){
		$this->db->select('*');
		$this->db->from('aktivitas');
		$this->db->join('ref_jenis_pembiayaan','aktivitas.KodeJenisPembiayaan=ref_jenis_pembiayaan.KodeJenisPembiayaan');
		$this->db->join('ref_jenis_usulan','aktivitas.KodeJenisUsulan=ref_jenis_usulan.KodeJenisUsulan');
		$this->db->join('ref_satuan','aktivitas.KodeSatuan=ref_satuan.KodeSatuan');
		$this->db->where('KD_PENGAJUAN',$KD_PENGAJUAN);
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('aktivitas');
		$this->db->join('ref_jenis_pembiayaan','aktivitas.KodeJenisPembiayaan=ref_jenis_pembiayaan.KodeJenisPembiayaan');
		$this->db->join('ref_jenis_usulan','aktivitas.KodeJenisUsulan=ref_jenis_usulan.KodeJenisUsulan');
		$this->db->join('ref_satuan','aktivitas.KodeSatuan=ref_satuan.KodeSatuan');
		$this->db->where('KD_PENGAJUAN',$KD_PENGAJUAN);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}

	function cek_aktivitas_update($KD_PENGAJUAN,$KodeAktivitas) {
		$this->db->select('*');
		$this->db->from('aktivitas_update');
		$this->db->where('KD_PENGAJUAN',$KD_PENGAJUAN);
		$this->db->where('KodeAktivitas',$KodeAktivitas);

		return $this->db->get();
	}

	function cek_usulan_update($KD_PENGAJUAN,$KodeAktivitas) {
		$this->db->select('*');
		$this->db->from('aktivitas_update');
		$this->db->where('KD_PENGAJUAN',$KD_PENGAJUAN);
		$this->db->where('KodeAktivitas',$KodeAktivitas);
		
		if($this->db->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function get_usulan_update($KD_PENGAJUAN,$KodeAktivitas) {
		$this->db->select('*');
		$this->db->from('aktivitas_update');
		$this->db->join('ref_jenis_usulan','aktivitas_update.KodeJenisUsulan=ref_jenis_usulan.KodeJenisUsulan');
		$this->db->join('ref_satuan','aktivitas_update.KodeSatuan=ref_satuan.KodeSatuan');
		$this->db->join('ref_jenis_pembiayaan','aktivitas_update.KodeJenisPembiayaan=ref_jenis_pembiayaan.KodeJenisPembiayaan');
		$this->db->where('KD_PENGAJUAN',$KD_PENGAJUAN);
		$this->db->where('KodeAktivitas',$KodeAktivitas);
		
		return $this->db->get();
	}

	function get_rincian_kegiatan() {
          // $this->db->distinct('ref_rincian_kegiatan.idrincian, ref_rincian_kegiatan.nmrincian');
		  // $this->db->from('ref_rincian_kegiatan');
          return $this->db->query( "SELECT DISTINCT idrincian , nmrincian FROM ref_rincian_kegiatan");
    }
	function get_rincian_by_id($idrincian) {
          // $this->db->distinct('ref_rincian_kegiatan.idrincian, ref_rincian_kegiatan.nmrincian');
		  // $this->db->from('ref_rincian_kegiatan');
          return $this->db->query( "SELECT DISTINCT idrincian , nmrincian , idkeg FROM ref_rincian_kegiatan WHERE idrincian =".'"'.$idrincian.'"');
    }
}

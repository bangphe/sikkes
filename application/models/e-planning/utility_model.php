<?php
class Utility_model extends CI_Model {
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	function get_cetak(){
		if($this->session->userdata('kd_role') == 1){
			$kdlokasi='';
			$kdunit='';
			$kdkabkota='';
			foreach($this->get_prov_unit()->result() as $row){
				$kdlokasi = $row->kdlokasi;
				$kdunit = $row->kdunit;
				$kdkabkota = $row->kdkabkota;
			}
			$this->db->select('*');
			$this->db->from('pengajuan');
			$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
			$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
			$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
			$this->db->where('STATUS', 3);
			$this->db->where('ref_satker.kdunit',$kdunit);
			$this->db->where('kdlokasi',$kdlokasi);
			$this->db->where('kdkabkota',$kdkabkota);
			return $this->db->get();
		}else if($this->session->userdata('kd_role') == 2){
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
			$this->db->where('STATUS', 3);
			$this->db->where('ref_satker.kdunit',$kdunit);
			$this->db->where('kdlokasi',$kdlokasi);
			return $this->db->get();
		}else if($this->session->userdata('kd_role') == 3){
			$this->db->select('*');
			$this->db->from('pengajuan');
			$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
			$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
			$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
			$this->db->where('STATUS', 3);
			return $this->db->get();
		}else{
			$this->db->select('*');
			$this->db->from('pengajuan');
			$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
			$this->db->join('ref_rencana_anggaran','pengajuan.id_rencana_anggaran=ref_rencana_anggaran.id_rencana_anggaran');
			$this->db->where('tahun_anggaran',$this->session->userdata('thn_anggaran'));
			$this->db->where('STATUS', 3);
			$this->db->where('ref_satker.kdunit',$this->session->userdata('kdunit'));
			return $this->db->get();
		}
	}
	
	function save($table, $data){
		$this->db->insert($table, $data);
	}
	
	function delete($tabel,$kolom,$parameter){
		$this->db->where($kolom,$parameter);
		$this->db->delete($tabel);
	}
	
	function get_max($tabel, $kolom){
		$this->db->select_max($kolom);
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function cek_file($tabel,$kolom,$param){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$return = $this->db->get();
		
		if($return->num_rows() > 0 ) return FALSE;
		else return TRUE;
	}
	
	function get_flexigrid($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function get_where($tabel,$kolom,$param){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		return $this->db->get();
	}
	
	function get_where2($tabel,$kolom,$param,$kolom2,$param2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->where($kolom2,$param2);
		return $this->db->get();
	}
	
	function get_where_join($tabel,$kolom,$param,$tabel_join,$param_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->join($tabel_join,$param_join);
		return $this->db->get();
	}
	
	function get_where2_join($tabel,$kolom,$param,$kolom2,$param2,$tabel_join,$param_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->where($kolom2,$param2);
		$this->db->join($tabel_join,$param_join);
		return $this->db->get();
	}
	
	function get_where2_join2($tabel,$kolom,$param,$kolom2,$param2,$tabel_join,$param_join,$tabel_join2,$param_join2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->where($kolom2,$param2);
		$this->db->join($tabel_join,$param_join);
		$this->db->join($tabel_join2,$param_join2);
		return $this->db->get();
	}
	
	function get_where2_join3($tabel,$kolom,$param,$kolom2,$param2,$tabel_join,$param_join,$tabel_join2,$param_join2,$tabel_join3,$param_join3){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->where($kolom2,$param2);
		$this->db->join($tabel_join,$param_join);
		$this->db->join($tabel_join2,$param_join2);
		$this->db->join($tabel_join3,$param_join3);
		return $this->db->get();
	}
	
	function sum($tabel,$kolom,$kolom1,$param){
		$this->db->select_sum($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom1, $param);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->$kolom;
		}
		return $Biaya;
	}
	
	function sum2($tabel,$kolom,$kolom1,$param,$kolom2,$param2){
		$this->db->select_sum($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom1, $param);
		$this->db->where($kolom2, $param2);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->$kolom;
		}
		return $Biaya;
	}
}
<?php
class Dashboard_model extends CI_Model {
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	//Count proposal provinsi
	function get_proposal_prov_satker($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_prov_diajukan($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS !=', 0);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_prov_reprov($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS !=', 0);
		$this->db->where('PROV_PEREKOMENDASI  !=', '');
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_prov_reunit($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS !=', 0);
		$this->db->where('UU_PEREKOMENDASI  !=', '');
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_prov_setuju($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 4);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_prov_tolak($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('(STATUS =  5 OR STATUS =  7)');
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_prov_timbang($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 6);
		return $this->db->get()->num_rows();
	}
	
	//Sum nilai proposal provinsi
	function sum_proposal_prov_satker($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_prov_diajukan($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS !=', 0);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_prov_reprov($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS !=', 0);
		$this->db->where('PROV_PEREKOMENDASI  !=', '');
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_prov_reunit($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('STATUS !=', 0);
		$this->db->where('UU_PEREKOMENDASI  !=', '');
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_prov_setuju($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 4);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_prov_tolak($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('(STATUS =  5 OR STATUS =  7)');
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_prov_timbang($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		// $this->db->where('kdkabkota','00');
		// $this->db->where('nomorsp !=','');
		// $this->db->where('kdkppn !=','');
		// $this->db->where('kdunit_awa !=','');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 6);
		return $this->db->get()->row()->Jumlah;
	}
	
	//Count proposal skpd
	function get_proposal_skpd_satker($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_skpd_diajukan($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS  !=', 0);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_skpd_reprov($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS  !=', 0);
		$this->db->where('PROV_PEREKOMENDASI  !=', '');
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_skpd_reunit($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS  !=', 0);
		$this->db->where('UU_PEREKOMENDASI  !=', '');
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_skpd_setuju($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 4);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_skpd_tolak($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('(STATUS =  5 OR STATUS =  7)');
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_skpd_timbang($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 6);
		return $this->db->get()->num_rows();
	}
	
	//Sum nilai proposal skpd
	function sum_proposal_skpd_satker($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_skpd_diajukan($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS  !=', 0);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_skpd_reprov($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS  !=', 0);
		$this->db->where('PROV_PEREKOMENDASI  !=', '');
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_skpd_reunit($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS  !=', 0);
		$this->db->where('UU_PEREKOMENDASI  !=', '');
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_skpd_setuju($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 4);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_skpd_tolak($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('(STATUS =  5 OR STATUS =  7)');
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_skpd_timbang($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 6);
		return $this->db->get()->row()->Jumlah;
	}
	
	//Count proposal kpkd
	function get_proposal_kpkd_satker($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_kpkd_diajukan($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS !=', 0);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_kpkd_reunit($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS  !=', 0);
		$this->db->where('UU_PEREKOMENDASI  !=', '');
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_kpkd_setuju($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 4);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_kpkd_tolak($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('(STATUS =  5 OR STATUS =  7)');
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_kpkd_timbang($thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 6);
		return $this->db->get()->num_rows();
	}

	//Sum nilai proposal kpkd
	function sum_proposal_kpkd_satker($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_kpkd_diajukan($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS !=', 0);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_kpkd_reunit($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS  !=', 0);
		$this->db->where('UU_PEREKOMENDASI  !=', '');
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_kpkd_setuju($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 4);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_kpkd_tolak($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('(STATUS =  5 OR STATUS =  7)');
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_kpkd_timbang($thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('STATUS', 6);
		return $this->db->get()->row()->Jumlah;
	}
	
	//List provinsi
	function get_provinsi(){
		$this->db->select('*');
		$this->db->from('ref_provinsi');
		$this->CI->flexigrid->build_query();
		$result['result'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_provinsi');
		$result['count'] = $this->db->get()->num_rows();
		return $result;
	}
	
	//Count proposal per provinsi
	function get_proposal_per_prov_satker($kdlokasi, $thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->num_rows();
	}
	
	function get_proposal_per_prov_diajukan($kdlokasi, $thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS !=',0);
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->num_rows();
	}
	
	//Sum nilai proposal per provinsi
	function sum_proposal_per_prov_satker($kdlokasi, $thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_proposal_per_prov_diajukan($kdlokasi, $thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('STATUS !=',0);
		$this->db->where('TAHUN_ANGGARAN', $thang);
		return $this->db->get()->row()->Jumlah;
	}
	
	//List satker
	function get_satker($arg){
		$this->db->select('nmsatker, ref_satker.kdsatker')->distinct();
		$this->db->from('ref_satker');
		if($arg == 'skpd'){
			$this->db->where('kdjnssat', '4');
			$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		}
		elseif($arg == 'kpkd'){
			$this->db->where('kdjnssat !=', '3');
			$this->db->where('kdjnssat !=', '4');
			$this->db->where('kdjnssat !=', '5');
			$this->db->where('kdjnssat !=', '6');
			$this->db->where('kdjnssat !=', '7');
			$this->db->where('kdjnssat !=', '8');
		}
		else{
			if($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3){
				$this->db->join('pengajuan', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
				$this->db->join('data_program', 'data_program.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
				$this->db->like('KodeProgram','024.'. $arg, 'after');
			}
			else 	$this->db->where('kdlokasi', $arg);
		}
		$this->db->where('kdsatker = kdinduk');
		$this->db->order_by('nmsatker', 'asc');
		$this->CI->flexigrid->build_query();
		$result['result'] = $this->db->get();
		
		$this->db->select('nmsatker, ref_satker.kdsatker')->distinct();
		$this->db->from('ref_satker');
		if($arg == 'skpd'){
			$this->db->where('kdjnssat', '4');
			$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		}
		elseif($arg == 'kpkd'){
			$this->db->where('kdjnssat !=', '3');
			$this->db->where('kdjnssat !=', '4');
			$this->db->where('kdjnssat !=', '5');
			$this->db->where('kdjnssat !=', '6');
			$this->db->where('kdjnssat !=', '7');
			$this->db->where('kdjnssat !=', '8');
		}
		else{
			if($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3){
				$this->db->join('pengajuan', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
				$this->db->join('data_program', 'data_program.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
				$this->db->like('KodeProgram','024.'. $arg, 'after');
			}
			else 	$this->db->where('kdlokasi', $arg);
		}
		$this->db->where('kdsatker = kdinduk');
		$this->db->order_by('nmsatker', 'asc');
		$result['count'] = $this->db->get()->num_rows();
		return $result;
	}
	
	//Count proposal per satker
	function get_prop_satker($arg, $kdsatker, $thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('kdsatker', $kdsatker);
		if($arg == 'skpd'){
			$this->db->where('kdjnssat', '4');
			$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		}
		elseif($arg == 'kpkd'){
			$this->db->where('kdjnssat !=', '3');
			$this->db->where('kdjnssat !=', '4');
			$this->db->where('kdjnssat !=', '5');
			$this->db->where('kdjnssat !=', '6');
			$this->db->where('kdjnssat !=', '7');
			$this->db->where('kdjnssat !=', '8');
		}
		else{
			if($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3){
				$this->db->join('data_program', 'data_program.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
				$this->db->like('KodeProgram','024.'. $arg, 'after');
			}
			else 	$this->db->where('kdlokasi', $arg);
		}
		return $this->db->get()->num_rows();
	}
	
	function get_prop_satker_diajukan($arg, $kdsatker, $thang){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('kdsatker', $kdsatker);
		$this->db->where('STATUS !=', 0);
		if($arg == 'skpd'){
			$this->db->where('kdjnssat', '4');
			$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		}
		elseif($arg == 'kpkd'){
			$this->db->where('kdjnssat !=', '3');
			$this->db->where('kdjnssat !=', '4');
			$this->db->where('kdjnssat !=', '5');
			$this->db->where('kdjnssat !=', '6');
			$this->db->where('kdjnssat !=', '7');
			$this->db->where('kdjnssat !=', '8');
		}
		else{
			if($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3){
				$this->db->join('data_program', 'data_program.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
				$this->db->like('KodeProgram','024.'. $arg, 'after');
			}
			else 	$this->db->where('kdlokasi', $arg);
		}
		return $this->db->get()->num_rows();
	}
	
	//Sum nilali proposal per satker
	function sum_prop_satker($arg, $kdsatker, $thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('kdsatker', $kdsatker);
		if($arg == 'skpd'){
			$this->db->where('kdjnssat', '4');
			$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		}
		elseif($arg == 'kpkd'){
			$this->db->where('kdjnssat !=', '3');
			$this->db->where('kdjnssat !=', '4');
			$this->db->where('kdjnssat !=', '5');
			$this->db->where('kdjnssat !=', '6');
			$this->db->where('kdjnssat !=', '7');
			$this->db->where('kdjnssat !=', '8');
		}
		else{
			if($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3){
				$this->db->join('data_program', 'data_program.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
				$this->db->like('KodeProgram','024.'. $arg, 'after');
			}
			else 	$this->db->where('kdlokasi', $arg);
		}
		return $this->db->get()->row()->Jumlah;
	}
	
	function sum_prop_satker_diajukan($arg, $kdsatker, $thang){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('pengajuan', 'aktivitas.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
		$this->db->join('ref_satker', 'pengajuan.NO_REG_SATKER = ref_satker.kdsatker');
		$this->db->where('TAHUN_ANGGARAN', $thang);
		$this->db->where('kdsatker', $kdsatker);
		$this->db->where('STATUS !=', 0);
		if($arg == 'skpd'){
			$this->db->where('kdjnssat', '4');
			$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		}
		elseif($arg == 'kpkd'){
			$this->db->where('kdjnssat !=', '3');
			$this->db->where('kdjnssat !=', '4');
			$this->db->where('kdjnssat !=', '5');
			$this->db->where('kdjnssat !=', '6');
			$this->db->where('kdjnssat !=', '7');
			$this->db->where('kdjnssat !=', '8');
		}
		else{
			if($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3){
				$this->db->join('data_program', 'data_program.KD_PENGAJUAN = pengajuan.KD_PENGAJUAN');
				$this->db->like('KodeProgram','024.'. $arg, 'after');
			}
			else 	$this->db->where('kdlokasi', $arg);
		}
		return $this->db->get()->row()->Jumlah;
	}
	
}
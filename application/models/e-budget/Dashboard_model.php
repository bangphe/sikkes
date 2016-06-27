<?php
class Dashboard_model extends CI_Model {
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	//Count kmpnen provinsi
	function get_kmpnen_prov($thang){
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('ref_satker', 'd_skmpnen.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('thang', $thang);
		return $this->db->get()->num_rows();
	}
	
	function get_kmpnen_prov_mapped($thang){
		$this->db->select('*');
		$this->db->from('d_ikk_fokus');
		$this->db->join('ref_satker', 'd_ikk_fokus.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('thang', $thang);
		return $this->db->get()->num_rows();
	}
	
	//Sum anggaran prov
	function sum_ang_prov($thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		return $this->db->get()->row()->jumlah;
	}
	
	function sum_ang_prov_mapped($thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('d_ikk_fokus', 'd_item.thang = d_ikk_fokus.thang AND d_item.kdjendok = d_ikk_fokus.kdjendok AND d_item.kdsatker = d_ikk_fokus.kdsatker AND d_item.kdunit = d_ikk_fokus.kdunit AND d_item.kdprogram = d_ikk_fokus.kdprogram AND d_item.kdgiat = d_ikk_fokus.kdgiat AND d_item.kdoutput = d_ikk_fokus.kdoutput AND d_item.kddekon = d_ikk_fokus.kddekon AND d_item.kdsoutput = d_ikk_fokus.kdsoutput AND d_item.kdkmpnen = d_ikk_fokus.kdkmpnen AND d_item.kdskmpnen = d_ikk_fokus.kdskmpnen');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('d_item.thang', $thang);
		return $this->db->get()->row()->jumlah;
	}
	
	//Count kmpnen skpd
	function get_kmpnen_skpd($thang){
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('ref_satker', 'd_skmpnen.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('thang', $thang);
		return $this->db->get()->num_rows();
	}
	
	function get_kmpnen_skpd_mapped($thang){
		$this->db->select('*');
		$this->db->from('d_ikk_fokus');
		$this->db->join('ref_satker', 'd_ikk_fokus.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('thang', $thang);
		return $this->db->get()->num_rows();
	}
	
	//Sum anggaran skpd
	function sum_ang_skpd($thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('thang', $thang);
		return $this->db->get()->row()->jumlah;
	}
	
	function sum_ang_skpd_mapped($thang){
		$this->db->select('*');
		$this->db->from('d_item');
		$this->db->join('d_ikk_fokus', 'd_item.thang = d_ikk_fokus.thang AND d_item.kdjendok = d_ikk_fokus.kdjendok AND d_item.kdsatker = d_ikk_fokus.kdsatker AND d_item.kdunit = d_ikk_fokus.kdunit AND d_item.kdprogram = d_ikk_fokus.kdprogram AND d_item.kdgiat = d_ikk_fokus.kdgiat AND d_item.kdoutput = d_ikk_fokus.kdoutput AND d_item.kddekon = d_ikk_fokus.kddekon AND d_item.kdsoutput = d_ikk_fokus.kdsoutput AND d_item.kdkmpnen = d_ikk_fokus.kdkmpnen AND d_item.kdskmpnen = d_ikk_fokus.kdskmpnen');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('d_item.thang', $thang);
		//return $this->db->get()->row()->jumlah;
		return $this->db->get();
	}

	function sum_ang_skpd_mappedd($thang){
		$this->db->select('*');
		$this->db->from('d_itesm');
		$this->db->join('d_ikk_fokus', 'd_item.thang = d_ikk_fokus.thang AND d_item.kdjendok = d_ikk_fokus.kdjendok AND d_item.kdsatker = d_ikk_fokus.kdsatker AND d_item.kdunit = d_ikk_fokus.kdunit AND d_item.kdprogram = d_ikk_fokus.kdprogram AND d_item.kdgiat = d_ikk_fokus.kdgiat AND d_item.kdoutput = d_ikk_fokus.kdoutput AND d_item.kddekon = d_ikk_fokus.kddekon AND d_item.kdsoutput = d_ikk_fokus.kdsoutput AND d_item.kdkmpnen = d_ikk_fokus.kdkmpnen AND d_item.kdskmpnen = d_ikk_fokus.kdskmpnen');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat', '4');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->where('d_item.thang', $thang);
		return $this->db->get()->row()->jumlah;
	}
	
	//Count kmpnen kpkd
	function get_kmpnen_kpkd($thang){
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('ref_satker', 'd_skmpnen.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('thang', $thang);
		return $this->db->get()->num_rows();
	}
	
	function get_kmpnen_kpkd_mapped($thang){
		$this->db->select('*');
		$this->db->from('d_ikk_fokus');
		$this->db->join('ref_satker', 'd_ikk_fokus.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('thang', $thang);
		return $this->db->get()->num_rows();
	}
	
	//Sum anggaran kpkd
	function sum_ang_kpkd($thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('thang', $thang);
		return $this->db->get()->row()->jumlah;
	}
	
	function sum_ang_kpkd_mapped($thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('d_ikk_fokus', 'd_item.thang = d_ikk_fokus.thang AND d_item.kdjendok = d_ikk_fokus.kdjendok AND d_item.kdsatker = d_ikk_fokus.kdsatker AND d_item.kdunit = d_ikk_fokus.kdunit AND d_item.kdprogram = d_ikk_fokus.kdprogram AND d_item.kdgiat = d_ikk_fokus.kdgiat AND d_item.kdoutput = d_ikk_fokus.kdoutput AND d_item.kddekon = d_ikk_fokus.kddekon AND d_item.kdsoutput = d_ikk_fokus.kdsoutput AND d_item.kdkmpnen = d_ikk_fokus.kdkmpnen AND d_item.kdskmpnen = d_ikk_fokus.kdskmpnen');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat !=', '3');
		$this->db->where('kdjnssat !=', '4');
		$this->db->where('kdjnssat !=', '5');
		$this->db->where('kdjnssat !=', '6');
		$this->db->where('kdjnssat !=', '7');
		$this->db->where('kdjnssat !=', '8');
		$this->db->where('d_item.thang', $thang);
		return $this->db->get()->row()->jumlah;
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
	
	//Count kmpnen per provinsi
	function get_kmpnen_per_prov($kdlokasi, $thang){
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('ref_satker', 'd_skmpnen.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('ref_satker.kdlokasi',$kdlokasi);
		$this->db->where('thang', $thang);
		return $this->db->get()->num_rows();
	}
	
	function get_kmpnen_per_prov_mapped($kdlokasi, $thang){
		$this->db->select('*');
		$this->db->from('d_ikk_fokus');
		$this->db->join('ref_satker', 'd_ikk_fokus.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('ref_satker.kdlokasi',$kdlokasi);
		$this->db->where('thang', $thang);
		return $this->db->get()->num_rows();
	}
	
	//Sum nilai kmpnen per provinsi
	function sum_ang_per_prov($kdlokasi, $thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('ref_satker.kdlokasi',$kdlokasi);
		$this->db->where('thang', $thang);
		return $this->db->get()->row()->jumlah;
	}
	
	function sum_ang_per_prov_mapped($kdlokasi, $thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('d_ikk_fokus', 'd_item.thang = d_ikk_fokus.thang AND d_item.kdjendok = d_ikk_fokus.kdjendok AND d_item.kdsatker = d_ikk_fokus.kdsatker AND d_item.kdunit = d_ikk_fokus.kdunit AND d_item.kdprogram = d_ikk_fokus.kdprogram AND d_item.kdgiat = d_ikk_fokus.kdgiat AND d_item.kdoutput = d_ikk_fokus.kdoutput AND d_item.kddekon = d_ikk_fokus.kddekon AND d_item.kdsoutput = d_ikk_fokus.kdsoutput AND d_item.kdkmpnen = d_ikk_fokus.kdkmpnen AND d_item.kdskmpnen = d_ikk_fokus.kdskmpnen');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('kdjnssat',4);
		$this->db->where('ref_satker.kdlokasi',$kdlokasi);
		$this->db->where('d_item.thang', $thang);
		return $this->db->get()->row()->jumlah;
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
				$this->db->join('d_skmpnen', 'd_skmpnen.kdsatker = ref_satker.kdsatker');
				$this->db->where('d_skmpnen.kddept', '024');
				$this->db->where('d_skmpnen.kdunit', $arg);
			}
			else 	$this->db->where('kdlokasi', $arg);
		}
		$this->db->where('ref_satker.kdsatker = kdinduk');
		$this->db->order_by('nmsatker', 'asc');
		$this->CI->flexigrid->build_query();
		$result['result'] = $this->db->get();
		
		$this->db->select('*');
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
				$this->db->join('d_skmpnen', 'd_skmpnen.kdsatker = ref_satker.kdsatker');
				$this->db->where('d_skmpnen.kddept', '024');
				$this->db->where('d_skmpnen.kdunit', $arg);
			}
			else 	$this->db->where('kdlokasi', $arg);
		}
		$this->db->where('ref_satker.kdsatker = kdinduk');
		$this->db->order_by('nmsatker', 'asc');
		$result['count'] = $this->db->get()->num_rows();
		return $result;
	}
	
	//Count kmpnen per satker
	function get_kmpnen_satker($arg, $kdsatker, $thang){
		$this->db->select('*');
		$this->db->from('d_skmpnen');
		$this->db->join('ref_satker', 'd_skmpnen.kdsatker = ref_satker.kdsatker');
		$this->db->where('thang', $thang);
		$this->db->where('d_skmpnen.kdsatker', $kdsatker);
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
				$this->db->where('d_skmpnen.kddept', '024');
				$this->db->where('d_skmpnen.kdunit', $arg);
			}
			else 	$this->db->where('ref_satker.kdlokasi', $arg);
		}
		return $this->db->get()->num_rows();
	}
	
	function get_kmpnen_satker_mapped($arg, $kdsatker, $thang){
		$this->db->select('*');
		$this->db->from('d_ikk_fokus');
		$this->db->join('ref_satker', 'd_ikk_fokus.kdsatker = ref_satker.kdsatker');
		$this->db->where('thang', $thang);
		$this->db->where('d_ikk_fokus.kdsatker', $kdsatker);
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
				$this->db->where('d_ikk_fokus.kdunit', $arg);
			}
			else 	$this->db->where('ref_satker.kdlokasi', $arg);
		}
		return $this->db->get()->num_rows();
	}
	
	//Sum nilali kmpnen per satker
	function sum_ang_satker($arg, $kdsatker, $thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('thang', $thang);
		$this->db->where('d_item.kdsatker', $kdsatker);
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
				$this->db->where('d_item.kddept', '024');
				$this->db->where('d_item.kdunit', $arg);
			}
			else 	$this->db->where('ref_satker.kdlokasi', $arg);
		}
		return $this->db->get()->row()->jumlah;
	}
	
	function sum_ang_satker_mapped($arg, $kdsatker, $thang){
		$this->db->select_sum('jumlah');
		$this->db->from('d_item');
		$this->db->join('d_ikk_fokus', 'd_item.thang = d_ikk_fokus.thang AND d_item.kdjendok = d_ikk_fokus.kdjendok AND d_item.kdsatker = d_ikk_fokus.kdsatker AND d_item.kdunit = d_ikk_fokus.kdunit AND d_item.kdprogram = d_ikk_fokus.kdprogram AND d_item.kdgiat = d_ikk_fokus.kdgiat AND d_item.kdoutput = d_ikk_fokus.kdoutput AND d_item.kddekon = d_ikk_fokus.kddekon AND d_item.kdsoutput = d_ikk_fokus.kdsoutput AND d_item.kdkmpnen = d_ikk_fokus.kdkmpnen AND d_item.kdskmpnen = d_ikk_fokus.kdskmpnen');
		$this->db->join('ref_satker', 'd_item.kdsatker = ref_satker.kdsatker');
		$this->db->where('d_item.thang', $thang);
		$this->db->where('d_item.kdsatker', $kdsatker);
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
				$this->db->where('d_item.kddept', '024');
				$this->db->where('d_item.kdunit', $arg);
			}
			else 	$this->db->where('ref_satker.kdlokasi', $arg);
		}
		return $this->db->get()->row()->jumlah;
	}
	
}
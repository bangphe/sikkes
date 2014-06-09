<?php
class General_model extends CI_Model{
	/**
	 * Constructor
	 */
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function update($tabel,$data,$kolom,$param){
		$this->db->where($kolom,$param);
		$this->db->update($tabel, $data);
	}
	
	function update_double_where($tabel,$data,$kolom,$param,$kolom2,$param2){
		$this->db->where($kolom,$param);
		$this->db->where($kolom2,$param2);
		$this->db->update($tabel, $data);
	}
	
	function get_data_flexigrid_join($tabel,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_data_user(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('ref_satker','users.kdsatker=ref_satker.kdsatker');
		$this->db->join('role_login','users.KD_ROLE=role_login.KD_ROLE');
		$this->db->where('users.KD_ROLE !=','8');
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('ref_satker','users.kdsatker=ref_satker.kdsatker');
		$this->db->join('role_login','users.KD_ROLE=role_login.KD_ROLE');
		$this->db->where('users.KD_ROLE !=','8');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_data_flexigrid_double_join_where($tabel,$tabel_join,$parameter_join,$tabel_join2,$parameter_join2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->db->join($tabel_join2,$parameter_join2);
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->db->join($tabel_join2,$parameter_join2);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	function get_data_flexigrid_triple_join($tabel,$tabel_join,$parameter_join,$tabel_join2,$parameter_join2,$tabel_join3,$parameter_join3){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->db->join($tabel_join2,$parameter_join2);
		$this->db->join($tabel_join3,$parameter_join3);
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->db->join($tabel_join2,$parameter_join2);
		$this->db->join($tabel_join3,$parameter_join3);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_data($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function get_data_join($tabel,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);	
		return $this->db->get();
	}
	
	function get_where_join($tabel,$kolom,$parameter,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $parameter_join);
		$this->db->where($kolom, $parameter);
		return $this->db->get();
	}
	
	function add($tabel, $data){
		$this->db->insert($tabel, $data);
	}
	
	function delete($tabel,$kolom,$parameter){
		$this->db->where($kolom, $parameter);
		$this->db->delete($tabel);
	}
	
	function delete_in($tabel,$kolom,$parameter){
		$this->db->where_in($kolom, $parameter);
		$this->db->delete($tabel);
	}
	
	function delete_double_param($tabel,$kolom1,$param1,$kolom2,$param2){
		$this->db->where($kolom1, $param1);
		$this->db->where($kolom2, $param2);
		$this->db->delete($tabel);
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
	
	function get_temp($tabel,$kolom,$param){
		$this->db->select($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$return = $this->db->get()->result();
		$result = 0;
		foreach($return as $row){
			$result = $row->$kolom;
		}
		return $result;	
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
	
	function get_max_where($tabel,$kolom,$kolom_param,$param){
		$this->db->select_max($kolom);
		$this->db->where($kolom_param,$param);
		$this->db->from($tabel);
		$return = $this->db->get()->result();
		$result = 0;
		foreach($return as $row){
			$result = $row->$kolom;
		}
		return $result;
	}
	
	function get_where($tabel,$kolom,$param){
		$this->db->select('*');
		$this->db->where($kolom,$param);
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function get_where_in($tabel,$kolom,$param){
		$this->db->select('*');
		$this->db->where_in($kolom,$param);
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function get_double_where($tabel,$kolom,$param,$kolom2,$param2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->where($kolom2,$param2);
		return $this->db->get();
	}

	function get_triple_where($tabel,$kolom,$param,$kolom2,$param2,$kolom3,$param3){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->where($kolom2,$param2);
		$this->db->where($kolom3,$param3);
		return $this->db->get();
	}
	
	function get_double_where_in($tabel,$kolom,$param,$kolom2,$param2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where_in($kolom,$param);
		$this->db->where_in($kolom2,$param2);
		return $this->db->get();
	}
	function get_target_nasional_iku($kodeiku){
		$this->db->select('*');
		$this->db->from('target_iku');
		$this->db->join('ref_iku', 'ref_iku.KodeIku = target_iku.KodeIku');
		$this->db->join('ref_tahun_anggaran', 'ref_tahun_anggaran.idThnAnggaran = target_iku.idThnAnggaran');
		$this->db->where('target_iku.KodeIku', $kodeiku);
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		
		$this->db->select('*');
		$this->db->from('target_iku');
		$this->db->join('ref_iku', 'ref_iku.KodeIku = target_iku.KodeIku');
		$this->db->where('target_iku.KodeIku', $kodeiku);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_target_nasional_ikk($kodeikk){
		$this->db->select('*');
		$this->db->from('target_ikk');
		$this->db->join('ref_ikk', 'ref_ikk.KodeIkk = target_ikk.KodeIkk');
		$this->db->join('ref_tahun_anggaran', 'ref_tahun_anggaran.idThnAnggaran = target_ikk.idThnAnggaran');
		$this->db->where('target_ikk.KodeIkk', $kodeikk);
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		
		$this->db->select('*');
		$this->db->from('target_ikk');
		$this->db->join('ref_ikk', 'ref_ikk.KodeIkk = target_ikk.KodeIkk');
		$this->db->where('target_ikk.KodeIkk', $kodeikk);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function valid_kode($table,$kolom,$param){
		$query = $this->db->get_where($table, array($kolom => $param));
		if ($query->num_rows() > 0){
			return TRUE;	
		}
		else
			return FALSE;
	}
}
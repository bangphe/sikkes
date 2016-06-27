<?php
class Referensi_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	function get_general($table){
		$this->db->select('*');
		$this->db->from($table);
		return $this->db->get();
	}
	
	function save($data, $table){
		$this->db->insert($table, $data);
	}
	
	function delete($tabel,$kolom,$parameter){
		$this->db->where($kolom,$parameter);
		$this->db->delete($tabel);
	}
	
	function update($table, $data, $kolom, $parameter){
		$this->db->where($kolom, $parameter);
		$this->db->update($table, $data);
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
	
	function where_flexigrid($tabel,$kolom,$parameter){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function join_double_flexigrid($tabel,$tabel1,$parameter,$tabel2,$parameter2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel1,$parameter);
		$this->db->join($tabel2,$parameter2);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel1,$parameter);
		$this->db->join($tabel2,$parameter2);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function where_join_double_flexigrid($tabel,$param,$kolom,$tabel1,$parameter,$tabel2,$parameter2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->join($tabel1,$parameter);
		$this->db->join($tabel2,$parameter2);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->join($tabel1,$parameter);
		$this->db->join($tabel2,$parameter2);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}

	function where_join_triple_flexigrid($tabel,$param,$kolom,$tabel1,$parameter,$tabel2,$parameter2,$tabel3,$parameter3){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->join($tabel1,$parameter);
		$this->db->join($tabel2,$parameter2);
		$this->db->join($tabel3,$parameter3);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$param);
		$this->db->join($tabel1,$parameter);
		$this->db->join($tabel2,$parameter2);
		$this->db->join($tabel3,$parameter3);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function join_where_flexigrid($tabel,$kolom,$parameter,$tabel2,$parameter2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->join($tabel2,$parameter2);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->join($tabel2,$parameter2);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_where_flexigrid($tabel,$kolom,$parameter,$tabelJoin,$parameterJoin){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->join($tabelJoin,$parameterJoin);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->join($tabelJoin,$parameterJoin);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}

	function get_where($tabel,$kolom,$parameter){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		return $this->db->get();
	}

	function get_periode_awal($idperiode)
	{
		$this->db->select($this->db->database.'.ref_periode.periode_awal');
		$this->db->from($this->db->database.'.ref_periode');
		$this->db->where($this->db->database.'.ref_periode.idperiode',$idperiode);

		return $this->db->get()->row()->periode_awal;
	}

	function get_periode_akhir($idperiode)
	{
		$this->db->select($this->db->database.'.ref_periode.periode_akhir');
		$this->db->from($this->db->database.'.ref_periode');
		$this->db->where($this->db->database.'.ref_periode.idperiode',$idperiode);

		return $this->db->get()->row()->periode_akhir;
	}
}
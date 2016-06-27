<?php
class Reformasi_kesehatan_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	function get($table){
		$this->db->select('*');
		$this->db->from($table);
		return $this->db->get();
	}
	
	function get_where($table,$kolom,$parameter){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($kolom,$parameter);
		return $this->db->get();
	}
	
	function save($table,$data){
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
	
	function get_reformasi_kesehatan(){
		$this->db->select('*');
		$this->db->from('reformasi_kesehatan');
		$this->db->join('ref_periode','reformasi_kesehatan.idPeriode=ref_periode.idPeriode');
		$this->db->order_by('ReformasiKesehatan', 'asc');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('reformasi_kesehatan');
		$this->db->join('ref_periode','reformasi_kesehatan.idPeriode=ref_periode.idPeriode');
		$this->db->order_by('ReformasiKesehatan', 'asc');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	function join_flexigrid($tabel,$tabel1,$parameter){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel1,$parameter);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel1,$parameter);
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
}
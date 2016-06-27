<?php
class Master_model extends CI_Model {
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	function save($table, $data){
		$this->db->insert($table, $data);
	}
	
	function truncate($tabel){
		$this->db->from($tabel); 
		$this->db->truncate(); 
	}
	
	function cek($tabel, $parameter1, $kolom1, $parameter2, $kolom2){
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
	
	function cek3($tabel, $parameter1, $kolom1, $parameter2, $kolom2, $parameter3, $kolom3){
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
	
	function cek_beda($tabel, $parameter1, $kolom1, $parameter_beda, $kolom_beda, $parameter2, $kolom2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $parameter1);
		$this->db->where($kolom2, $parameter2);
		$this->db->where($kolom_beda.' !=', $parameter_beda);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function update($table, $data, $kolom, $parameter){
		$this->db->where($kolom, $parameter);
		$this->db->update($table, $data);
	}
	
	function update_double_parameter($table, $data, $kolom, $parameter, $kolom2, $parameter2){
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->update($table, $data);
	}
	
	function delete($table, $kolom, $parameter){
		$this->db->where($kolom, $parameter);
		$this->db->delete($table); 
	}
	
	function delete_double_parameter($table, $kolom, $parameter, $kolom2, $parameter2){
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->delete($table); 
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
	
	function get_join($tabel,$tabel2,$parameterJoin){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel2,$parameterJoin);
		return $this->db->get();
	}
	
	function get_double_join($tabel,$tabelJoin1,$parameterJoin1,$tabelJoin2,$parameterJoin2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabelJoin1,$parameterJoin1);
		$this->db->join($tabelJoin2,$parameterJoin2);
		return $this->db->get();
	}
	
	function get_triple_join_where($tabel,$tabel_join,$param_join,$tabel_join2,$param_join2,$tabel_join3,$param_join3,$kolom,$parameter){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $param_join);
		$this->db->join($tabel_join2, $param_join2);
		$this->db->join($tabel_join3, $param_join3);
		$this->db->where($kolom, $parameter);
		return $this->db->get();
	}
	
	function get_join_where($tabel,$tabel2,$kolom,$parameter,$parameterJoin){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel2,$parameterJoin);
		$this->db->where($kolom,$parameter);
		return $this->db->get();
	}
	
	function get($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function get_satker(){
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->join('ref_provinsi','ref_satker.kdlokasi=ref_provinsi.KodeProvinsi');
		$this->db->join('ref_kabupaten','ref_satker.kdlokasi=ref_kabupaten.KodeProvinsi AND ref_satker.kdkabkota=ref_kabupaten.KodeKabupaten');
		// $this->db->where('kdsatker = kdinduk');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->join('ref_provinsi','ref_satker.kdlokasi=ref_provinsi.KodeProvinsi');
		$this->db->join('ref_kabupaten','ref_satker.kdlokasi=ref_kabupaten.KodeProvinsi AND ref_satker.kdkabkota=ref_kabupaten.KodeKabupaten');
		// $this->db->where('kdsatker = kdinduk');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function cek_satker_program_per_satker($kdsatker) {
		$this->db->select('*');
		$this->db->from('ref_satker_program');
		$this->db->where('kdsatker', $kdsatker);

		return $this->db->get();
	}

	function cek_satker_kegiatan_per_satker($kdsatker) {
		$this->db->select('*');
		$this->db->from('ref_satker_kegiatan');
		$this->db->where('kdsatker', $kdsatker);

		return $this->db->get();
	}

	function get_allsatker(){
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->join('ref_provinsi','ref_satker.kdlokasi=ref_provinsi.KodeProvinsi');
		$this->db->join('ref_kabupaten','ref_satker.kdlokasi=ref_kabupaten.KodeProvinsi AND ref_satker.kdkabkota=ref_kabupaten.KodeKabupaten');
		$this->db->like('nmsatker','biro perencanaan dan anggaran');
		$this->db->or_like('nmsatker','inspektorat','both');
		$this->db->or_like('nmsatker','sekretariat ditjen');
		$this->db->or_like('nmsatker','sekretariat badan');
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->join('ref_provinsi','ref_satker.kdlokasi=ref_provinsi.KodeProvinsi');
		$this->db->join('ref_kabupaten','ref_satker.kdlokasi=ref_kabupaten.KodeProvinsi AND ref_satker.kdkabkota=ref_kabupaten.KodeKabupaten');
		$this->db->like('nmsatker','biro perencanaan dan anggaran');
		$this->db->or_like('nmsatker','inspektorat','both');
		$this->db->or_like('nmsatker','sekretariat ditjen');
		$this->db->or_like('nmsatker','sekretariat badan');
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_tupoksi($kdsatker){
		$this->db->select('*');
		$this->db->from('ref_tupoksi');
		$this->db->join('ref_tahun_anggaran','ref_tupoksi.idThnAnggaran=ref_tahun_anggaran.idThnAnggaran');
		$this->db->join('ref_periode','ref_tupoksi.idPeriode=ref_periode.idPeriode');
		$this->db->where('kdsatker',$kdsatker);
		$this->CI->flexigrid->build_query();		
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('ref_tupoksi');
		$this->db->join('ref_tahun_anggaran','ref_tupoksi.idThnAnggaran=ref_tahun_anggaran.idThnAnggaran');
		$this->db->join('ref_periode','ref_tupoksi.idPeriode=ref_periode.idPeriode');
		$this->db->where('kdsatker',$kdsatker);
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}
	
	function get_max($kolom,$tabel,$kolom_param,$parameter){
		$this->db->select_max($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom_param,$parameter);
		return $this->db->get();
	}
	
	function valid($kode)
	{
		$prog = $this->db->get_where('prioritas_program', array('idThnAnggaran' => $kode));
		$iku = $this->db->get_where('prioritas_iku', array('idThnAnggaran' => $kode));
		$keg = $this->db->get_where('prioritas_kegiatan', array('idThnAnggaran' => $kode));
		$ikk = $this->db->get_where('prioritas_ikk', array('idThnAnggaran' => $kode));
		//$query = $this->db->get_where('prioritas_program', array('idThnAnggaran' => $kode));
		if ($prog->num_rows() > 0 && $iku->num_rows() > 0 && $keg->num_rows() > 0 && $ikk->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function getTahun($kd){
		$sql = "select * from ref_tahun_anggaran where idPeriode=$kd order by thn_anggaran asc";
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function getJenisPrioritas()
	{
		$sql = "select * from ref_jenis_prioritas order by KodeJenisPrioritas asc";
		$query = $this->db->query($sql);
			
		return $query;
	}
	
}
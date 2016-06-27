<?php
class Login_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	function get_user($username, $password){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('USERNAME',$username);
		$this->db->where('PASS_USER', $password);
		return $this->db->get();
	}
	
	function cek_user($username){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('USERNAME',$username);
		$return = $this->db->get();
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	function get_user_by_email($email){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('EMAIL_USER',$email);
		return $this->db->get();
	}
	
	function reset_password_by_email($email){
		$data = array('PASS_USER' => md5('users'));
		$this->db->where('EMAIL_USER', $email);
		$this->db->update('users', $data);
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
	
	function select($select,$tabel,$tabel_group){
		$this->db->select($select);
		$this->db->from($tabel);
		$this->db->group_by($tabel_group);
		return $this->db->get();
	}
	
	function get_kdsatker($id_prov){
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->where('kdlokasi',$id_prov);
		$result = $this->db->get();
		$kdsatker;
		foreach($result->result() as $row)
			$kdsatker[$row->kdsatker] = $row->kdsatker;
		return $kdsatker;
	}
	
	function get_pengajuan_prov($id_prov){
		$this->db->where_in('NO_REG_SATKER',$this->get_kdsatker($id_prov));
		return $this->db->count_all_results('pengajuan');
	}
	
	function get_pengajuan_satker($NO_REG_SATKER){
		$this->db->where('NO_REG_SATKER',$NO_REG_SATKER);
		return $this->db->count_all_results('pengajuan');
	}
}
<?php

class Feedback_model extends CI_Model {
    const TABLE = 'feedback_eplanning';

    public function __construct() {
        parent::__construct();
        $this->CI = get_instance();
        $this->load->database();
    }

    function save($data) {
        $this->db->insert(self::TABLE, $data);
    }

    function update($table, $data, $kolom, $parameter) {
        $this->db->where($kolom, $parameter);
        $this->db->update($table, $data);
    }

    function get_history($kdpengajuan) {
        $this->db->select('feedback_eplanning.*, users.USERNAME');
        $this->db->from(self::TABLE);
        $this->db->join('users','users.USER_ID=ID_USER');
        $this->db->where('ID_PENGAJUAN', $kdpengajuan);
        $this->db->where('PARENT', 0);
		$this->db->order_by('ID_FEEDBACK', 'desc');
		$this->db->limit(5);
        
        return $this->db->get();
    }

    function get_more($kdpengajuan,$id_feedback) {
        $this->db->select('feedback_eplanning.*, users.USERNAME');
        $this->db->from(self::TABLE);
        $this->db->join('users','users.USER_ID=ID_USER');
        $this->db->where('ID_PENGAJUAN', $kdpengajuan);
        $this->db->where('ID_FEEDBACK <', $id_feedback);
        $this->db->where('PARENT', 0);
		$this->db->order_by('ID_FEEDBACK', 'desc');
		$this->db->limit(5);
        
        return $this->db->get();
    }

    function get_parent($kdpengajuan, $id_parent) {
        $this->db->select('feedback_eplanning.*, users.USERNAME');
        $this->db->from(self::TABLE);
        $this->db->join('users','users.USER_ID=ID_USER');
        $this->db->where('ID_PENGAJUAN', $kdpengajuan);
        $this->db->where('PARENT', $id_parent);
        
        return $this->db->get();
    }
    
    function get_lower_users($satkerAtas, $satkerBawah){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('KodeJenisSatker < ', $satkerAtas);
        $this->db->where('KodeJenisSatker >= ', $satkerBawah);
        
        return $this->db->get();
    }
	
	function get_propinsi($id_user){
		$this->db->select('*');
        $this->db->from('users');
        $this->db->where('USER_ID', $id_user);
        
        return $this->db->get();
	}
    
    function get_users($satker, $id_propinsi, $role, $idPengusul, $kodejenissatker, $kd_pengajuan){
        $this->db->select('u.*');
        $this->db->from('users u');
		$this->db->where_in('u.KodeJenisSatker', $satker);
		$this->db->where('u.KodeProvinsi', $id_propinsi);
		$this->db->where("(u.KD_ROLE = $role or u.USER_ID = $idPengusul)");        
        // if($kodejenissatker != '3' && $kodejenissatker != '4' && $kodejenissatker != '5'){
			// $this->db->join('ref_satker', 'u.kdsatker = ref_satker.kdsatker');
			// $this->db->or_where("(ref_satker.nmsatker like 'BIRO PERENCANAAN%' or ref_satker.nmsatker like 'KANTOR INSPEKTORAT%' or ref_satker.nmsatker like 'SEKRETARIAT DITJEN%' or ref_satker.nmsatker like 'SEKRETARIAT BADAN%')");
			// $this->db->where('u.kdunit', $this->get_kdunit($kd_pengajuan));
		// }
        return $this->db->get();
    }
	
	function get_kdunit($kd_pengajuan){
        $this->db->select('*');
        $this->db->from('data_program');
		$this->db->where('KD_PENGAJUAN', $kd_pengajuan);
        $result = $this->db->get();
		foreach($result->result() as $row)
			$program = explode('.', $row->KodeProgram);
		return $program[1];
    }
	
	function resolv($data, $id_feedback){
		$this->db->trans_begin();
		$this->db->where('ID_FEEDBACK', $id_feedback);
		$this->db->update('feedback_eplanning', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
	
	function resolvParent($data, $id_feedback){
		$this->db->trans_begin();
		$this->db->where('PARENT', $id_feedback);
		$this->db->update('feedback_eplanning', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

}

<?php

class Feedback_emonev_model extends CI_Model {
    const TABLE = 'feedback_emonev';

    public function __construct() {
        parent::__construct();
        $this->CI = get_instance();
        $this->load->database();
    }

    function save($data) {
		$monev = $this->load->database('monev',TRUE);
        $this->db->insert('monev.feedback_emonev', $data);
    }

    function update($table, $data, $kolom, $parameter) {
        $this->db->where($kolom, $parameter);
        $this->db->update($table, $data);
    }

    function get_history($idpermasalahan) {
		$monev = $this->load->database('monev',TRUE);
        $monev = $this->db->select('feedback_emonev.*, users.USERNAME');
        $this->db->from(self::TABLE);
        $this->db->join($this->db->database.'.users','users.USER_ID=ID_USER');
        $this->db->where('ID_PERMASALAHAN', $idpermasalahan);
        $this->db->where('PARENT', 0);
		$this->db->order_by('ID_FEEDBACK', 'desc');
		$this->db->limit(5);
        
        return $this->db->get();
    }

    function get_more($idpermasalahan,$id_feedback) {
		$monev = $this->load->database('monev',TRUE);
        $monev = $this->db->select('feedback_emonev.*, users.USERNAME');
        $this->db->from(self::TABLE);
        $this->db->join($this->db->database.'.users','users.USER_ID=ID_USER');
        $this->db->where('ID_PERMASALAHAN', $idpermasalahan);
        $this->db->where('ID_FEEDBACK <', $id_feedback);
        $this->db->where('PARENT', 0);
		$this->db->order_by('ID_FEEDBACK', 'desc');
		$this->db->limit(5);
        
        return $this->db->get();
    }

    function get_parent($idpermasalahan, $id_parent) {
		$monev = $this->load->database('monev',TRUE);
        $monev = $this->db->select('feedback_emonev.*, users.USERNAME');
        $this->db->from(self::TABLE);
        $this->db->join($this->db->database.'.users','users.USER_ID=ID_USER');
        $this->db->where('ID_PERMASALAHAN', $idpermasalahan);
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
}

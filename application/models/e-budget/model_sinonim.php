<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_sinonim
 *
 * @author bren
 */
class model_sinonim extends CI_Model {
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->CI = get_instance();
        $this->load->database();
        $this->load->library('session');
    }

    function get($table) {
        $this->db->select('*');
        $this->db->from($table);
        return $this->db->get();
    }

    function get_where($tabel, $kolom, $parameter) {
        $this->db->select('*');
        $this->db->from($tabel);
        $this->db->where($kolom, $parameter);
        return $this->db->get->result();
    }
    
    public function add_sinonim($sinonim) {
        $kdsatker = $this->session->userdata('kdsatker');
        
        $ret = "0";
        $sql = "SELECT * FROM sinonim WHERE nmsinonim='$sinonim' AND kdsatker='$kdsatker'";
        $result = mysql_query($sql) or die (mysql_error());
        if (mysql_num_rows($result) == 0) {
            $sql = "INSERT INTO sinonim (nmsinonim, kdsatker) VALUES ('$sinonim', '$kdsatker')";
            mysql_query($sql);
        }
        else {
            $ret = "1";
        }
        return $ret;
    }

    public function add_sinonim_akun($idsinonim, $akun) {
        if (!is_array($akun)) {
            return;
        }
        foreach ($akun as $key => $value) {
            $sql = "SELECT * FROM sinonimakun WHERE id_sinonim='$idsinonim' AND kdakun='$value'";
            $result = mysql_query($sql) or die (mysql_error());
            if (mysql_num_rows($result) == 0) {
                $sql = "INSERT INTO sinonimakun VALUES ('$idsinonim', '$value')";
                mysql_query($sql);
            }
        }
    }

    public function add_sinonim_katakunci($idsinonim, $katakunci) {
        $katakunci = $this->db->escape($katakunci);
        $sql = "SELECT * FROM sinonimkatakunci WHERE id_sinonim='$idsinonim' AND katakunci=$katakunci";
        //$sql = $this->db->escape($sql);
//        $this->db->query($sql);
        //die ($sql);
        $result = mysql_query($sql) or die (mysql_error());
        if (mysql_num_rows($result) == 0) {
            $sql = "INSERT INTO sinonimkatakunci (id_sinonim, katakunci) VALUES ('$idsinonim', $katakunci)";
            mysql_query($sql);
        }
    }

    public function delete_sinonim($idsinonim) {
        $sql = "DELETE FROM sinonim WHERE id='$idsinonim'";
        mysql_query($sql);
        $sql = "DELETE FROM sinonimakun WHERE id_sinonim='$idsinonim'";
        mysql_query($sql);
        $sql = "DELETE FROM sinonimkatakunci WHERE id_sinonim='$idsinonim'";
        mysql_query($sql);
    }

    public function delete_sinonim_akun($idsinonim, $akun) {
        $sql = "DELETE FROM sinonimakun WHERE id_sinonim='$idsinonim' and kdakun='$akun'";
        mysql_query($sql);
    }

    public function delete_sinonim_katakunci($idkatakunci) {
        $sql = "DELETE FROM sinonimkatakunci WHERE id='$idkatakunci'";
        mysql_query($sql);
    }
    
    public function get_sinonim_akun($idsinonim) {
        $this->db->select('*');
        $this->db->from('sinonimakun');
        $this->db->where('id_sinonim',$idsinonim);
        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('*');
        $this->db->from('sinonimakun');
        $this->db->where('id_sinonim',$idsinonim);
        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }
    
    public function get_sinonim_akun2($idsinonim) {
        $akun = array();
        $sql = "SELECT * FROM sinonimakun WHERE id_sinonim='$idsinonim' ORDER BY kdakun";
        $result = mysql_query($sql) or die (mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $akun[] = $row['kdakun'];
        }
        return $akun;
    }

    function get_nama_akun($kdakun) {
        $sql = "SELECT nmakun FROM t_akun t WHERE kdakun='$kdakun'";
        $result = mysql_query($sql) or die (mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            return $kdakun." - ".$row['nmakun'];
        }
    }
    
    public function get_sinonim_katakunci($idsinonim) {
        $this->db->select('*');
        $this->db->from('sinonimkatakunci');
        $this->db->where('id_sinonim',$idsinonim);
        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('*');
        $this->db->from('sinonimkatakunci');
        $this->db->where('id_sinonim',$idsinonim);
        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }
    
    public function get_sinonim_katakunci2($idsinonim) {
        $katakunci = array();
        $sql = "SELECT * FROM sinonimkatakunci WHERE id_sinonim='$idsinonim'";
        $result = mysql_query($sql) or die (mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $katakunci[] = $row['katakunci'];
        }
        return $katakunci;
    }

    public function list_sinonim() {
        $kdsatker = $this->session->userdata('kdsatker');
        
        $this->db->select('*');
        $this->db->from('sinonim');
        $this->db->where('kdsatker',$kdsatker);
        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('*');
        $this->db->from('sinonim');
        $this->db->where('kdsatker',$kdsatker);
        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }
    
    public function list_sinonim_pencarian() {
        $kdsatker = $this->session->userdata('kdsatker');
        $sinonim = array();
        $sql = "SELECT * FROM sinonim WHERE kdsatker='$kdsatker' ORDER BY id";
        $result = mysql_query($sql) or die (mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $sinonim[] = array($row['id'],$row['nmsinonim']);
        }
        return $sinonim;
    }
    
    public function get_sinonim($id) {
        $ret = "";
        $sql = "SELECT * FROM sinonim WHERE id='$id' ORDER BY id";
        $result = mysql_query($sql) or die (mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $ret = $row['nmsinonim'];
        }
        return $ret;
    }
}

?>

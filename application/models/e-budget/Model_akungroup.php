<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_akungroup
 *
 * @author bren
 */
class model_akungroup extends CI_Model {

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

    public function add_akungroup($akungroup) {
        $kdsatker = $this->session->userdata('kdsatker');
        
        $ret = "0";
        $sql = "SELECT * FROM akungroup WHERE nmakungroup='$akungroup' AND kdsatker='$kdsatker'";
        $result = mysql_query($sql) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
            $sql = "INSERT INTO akungroup (nmakungroup, kdsatker) VALUES ('$akungroup', '$kdsatker')";
            mysql_query($sql);
        } else {
            $ret = "1";
        }
        return $ret;
    }

    public function add_akungroup_akun($idakungroup, $akun) {
        if (!is_array($akun)) {
            return;
        }
        foreach ($akun as $key => $value) {
            $sql = "SELECT * FROM akungroupakun WHERE id_akungroup='$idakungroup' AND kdakun='$value'";
            $result = mysql_query($sql) or die(mysql_error());
            if (mysql_num_rows($result) == 0) {
                $sql = "INSERT INTO akungroupakun VALUES ('$idakungroup', '$value')";
                mysql_query($sql);
            }
        }
    }

    public function delete_akungroup($idakungroup) {
        $sql = "DELETE FROM akungroup WHERE id='$idakungroup'";
        mysql_query($sql);
        $sql = "DELETE FROM akungroupakun WHERE id_akungroup='$idakungroup'";
        mysql_query($sql);
    }

    public function delete_akungroup_akun($idakungroup, $akun) {
        $sql = "DELETE FROM akungroupakun WHERE id_akungroup='$idakungroup' and kdakun='$akun'";
        mysql_query($sql);
    }
    
    public function list_akungroup() {
        $kdsatker = $this->session->userdata('kdsatker');
        
        $this->db->select('*');
        $this->db->from('akungroup');
        $this->db->where('kdsatker',$kdsatker);
        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('*');
        $this->db->from('akungroup');
        $this->db->where('kdsatker',$kdsatker);
        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }
    
    public function list_akungroup_pencarian() {
        $kdsatker = $this->session->userdata('kdsatker');
        
        $akungroup = array();
        $sql = "SELECT * FROM akungroup WHERE kdsatker='$kdsatker' ORDER BY id";
        $result = mysql_query($sql) or die (mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $akungroup[] = array($row['id'],$row['nmakungroup']);
        }
        return $akungroup;
    }
    
    public function get_akungroup_akun2($idakungroup) {
        $akun = array();
        $sql = "SELECT * FROM akungroupakun WHERE id_akungroup='$idakungroup' ORDER BY kdakun";
        $result = mysql_query($sql) or die (mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $akun[] = $row['kdakun'];
        }
        return $akun;
    }

    public function get_akungroup_akun($idakungroup) {
        $this->db->select('*');
        $this->db->from('akungroupakun');
        $this->db->where('id_akungroup',$idakungroup);
        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('*');
        $this->db->from('akungroupakun');
        $this->db->where('id_akungroup',$idakungroup);
        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }

    function get_nama_akun($kdakun) {
        $sql = "SELECT nmakun FROM t_akun t WHERE kdakun='$kdakun'";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            return $kdakun . " - " . $row['nmakun'];
        }
    }

    public function get_akungroup($id) {
        $ret = "";
        $sql = "SELECT * FROM akungroup WHERE id='$id' ORDER BY id";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $ret = $row['nmakungroup'];
        }
        return $ret;
    }

}

?>

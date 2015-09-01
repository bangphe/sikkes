<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_mapping
 *
 * @author bren
 */
class model_ebudget extends CI_Model {

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
        return $this->db->get();
    }
    
    public function get_feedback_status($key) {
        $sts = "0";
        $sql = "SELECT sts FROM feedback WHERE fkey='$key'";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {   
            $sts = $row['sts'];
        }    
        return $sts;
    }     

    public function get_data($tahun, $unit, $key) {
        $sts_komponen = $this->get_feedback_status($key);
        
        $keys = explode("-", $key);
        $thang = $keys[0];
        $kdsatker = $keys[1];
        $kdunit = $keys[2];
        $kdprogram = $keys[3];
        $kdgiat = $keys[4];
        $kdoutput = $keys[5];
        $kdsoutput = $keys[6];
        $kdkmpnen = $keys[7];
        $kdskmpnen = $keys[8];
//        if (strlen($kdskmpnen) == 1) {
//            $kdskmpnen = " " . $kdskmpnen;
//        }
        //die ($key);

        $sql = "SELECT satker.nmsatker, d.kdunit, d.kdprogram, d.kdgiat, d.kdoutput, d.kdsoutput, d.kdkmpnen, d.kdskmpnen, unit.nmunit, program.nmprogram, giat.nmgiat, output.nmoutput, soutput.ursoutput, komponen.urkmpnen, skomponen.urskmpnen, akun.nmakun, d.kdakun, d.kdheader, d.noitem, d.nmitem, d.jumlah FROM d_item d
            LEFT JOIN t_satker satker ON satker.kdsatker=d.kdsatker
            LEFT JOIN t_unit unit ON unit.kdunit=d.kdunit AND unit.kddept=d.kddept
            LEFT JOIN t_program program ON program.kdprogram = d.kdprogram AND program.kdunit=d.kdunit AND program.kddept=d.kddept
            LEFT JOIN t_giat giat ON giat.kdgiat = d.kdgiat AND giat.kddept = d.kddept AND giat.kdunit = d.kdunit AND giat.kdprogram = d.kdprogram
            LEFT JOIN t_output output ON output.kdgiat = d.kdgiat AND output.kdoutput = d.kdoutput
            LEFT JOIN d_soutput soutput ON soutput.thang = d.thang AND soutput.kdsatker = d.kdsatker AND soutput.kddept = d.kddept AND soutput.kdunit = d.kdunit AND soutput.kdprogram = d.kdprogram AND soutput.kdgiat = d.kdgiat AND soutput.kdoutput = d.kdoutput AND soutput.kdlokasi = d.kdlokasi AND soutput.kdkabkota = d.kdkabkota AND soutput.kdsoutput = d.kdsoutput AND soutput.kddekon = d.kddekon
            LEFT JOIN d_kmpnen komponen ON komponen.thang = d.thang AND komponen.kdsatker = d.kdsatker AND komponen.kddept = d.kddept AND komponen.kdunit = d.kdunit AND komponen.kdprogram = d.kdprogram AND komponen.kdgiat = d.kdgiat AND komponen.kdoutput = d.kdoutput AND komponen.kdlokasi = d.kdlokasi AND komponen.kdkabkota = d.kdkabkota AND komponen.kdsoutput = d.kdsoutput AND komponen.kdkmpnen = d.kdkmpnen AND komponen.kddekon = d.kddekon";


        if ($unit == "0") {
            $sql = $sql .
                    " LEFT JOIN d_skmpnen skomponen ON skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kddept = d.kddept AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdlokasi = d.kdlokasi AND skomponen.kdkabkota = d.kdkabkota AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdskmpnen = d.kdskmpnen AND skomponen.kddekon = d.kddekon
                            LEFT JOIN t_akun akun ON akun.kdakun = d.kdakun
                            WHERE d.thang='$tahun' AND d.kdsatker='$kdsatker' AND d.kdprogram ='$kdprogram' AND d.kdgiat = '$kdgiat' AND d.kdoutput = '$kdoutput' AND d.kdsoutput ='$kdsoutput' AND d.kdkmpnen = '$kdkmpnen' AND d.kdskmpnen LIKE '%$kdskmpnen'";

            if ($kdskmpnen == "") {
                $sql = $sql .
                        " LEFT JOIN t_akun akun ON akun.kdakun = d.kdakun
                        WHERE d.thang='$tahun' AND d.kdsatker='$kdsatker' AND d.kdprogram ='$kdprogram' AND d.kdgiat = '$kdgiat' AND d.kdoutput = '$kdoutput' AND d.kdsoutput ='$kdsoutput' AND d.kdkmpnen = '$kdkmpnen'";
            }
        } else {
            $sql = $sql .
                    " LEFT JOIN d_skmpnen skomponen ON skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kddept = d.kddept AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdlokasi = d.kdlokasi AND skomponen.kdkabkota = d.kdkabkota AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdskmpnen = d.kdskmpnen AND skomponen.kddekon = d.kddekon
                        LEFT JOIN t_akun akun ON akun.kdakun = d.kdakun
                        WHERE d.thang='$tahun' AND d.kdsatker='$kdsatker' AND d.kdunit='$kdunit' AND d.kdprogram ='$kdprogram' AND d.kdgiat = '$kdgiat' AND d.kdoutput = '$kdoutput' AND d.kdsoutput ='$kdsoutput' AND d.kdkmpnen = '$kdkmpnen' AND d.kdskmpnen LIKE '%$kdskmpnen'";

            if ($kdskmpnen == "") {
                $sql = $sql .
                        " LEFT JOIN t_akun akun ON akun.kdakun = d.kdakun
                        WHERE d.thang='$tahun' AND d.kdsatker='$kdsatker' AND d.kdunit='$kdunit' AND d.kdprogram ='$kdprogram' AND d.kdgiat = '$kdgiat' AND d.kdoutput = '$kdoutput' AND d.kdsoutput ='$kdsoutput' AND d.kdkmpnen = '$kdkmpnen'";
            }
        }

//       die ($sql);
        $result = mysql_query($sql) or die(mysql_error());

        $dataComplete = array();
        $dataAkun = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            //$key = $row[1]."-".$row[2]."-".$row[3]."-".$row[4]."-".$row[5]."-".$row[6]."-".$row[7];
            $value = $row[8] . "-;-" . $row[9] . "-;-" . $row[10] . "-;-" . $row[11] . "-;-" . $row[12] . "-;-" . $row[13] . "-;-" . $row[14]. "-;-" . $sts_komponen;
            $dataComplete[$key] = $value;
            
            $keyakun = $key."-".$row[16]."-".$row[18];
            $sts_akun = $this->get_feedback_status($keyakun);
            if (!isset($dataAkun[$key])) {
                $dataAkun[$key] = array();
                $dataAkun[$key][] = $row[15] . "-;-" . $row[16] . "-;-" . $row[17] . "-;-" . $row[18] . "-;-" . $row[19] . "-;-" . $row[20]. "-;-" . $sts_akun;
            } else {
                $dataAkun[$key][] = $row[15] . "-;-" . $row[16] . "-;-" . $row[17] . "-;-" . $row[18] . "-;-" . $row[19] . "-;-" . $row[20]. "-;-" . $sts_akun;
            }
        }

        $ret = array();
        $ret[] = $dataComplete;
        $ret[] = $dataAkun;

        return $ret;
    }

    public function get_belanja_data($tahun, $unit, $satker, $belanja, $lokasi, $program, $kegiatan, $akun, $beban, $jenissat, $ikk, $reformasi_kesehatan, $fokus_prioritas) {
        ini_set("memory_limit", "200M");
        $sql = "SELECT d.kdakun, unit.nmunit, satker.nmsatker, d.nmitem, d.volkeg, d.satkeg, d.hargasat, d.jumlah FROM d_item d
                LEFT JOIN t_satker satker ON satker.kdsatker=d.kdsatker
                LEFT JOIN t_unit unit ON unit.kdunit=d.kdunit AND unit.kddept=d.kddept
                LEFT JOIN t_jnsban jnsban ON (jnsban.kdbeban = d.kdbeban AND jnsban.kdjnsban=d.kdjnsban)
                LEFT JOIN d_ikk_fokus ikk ON (ikk.thang = d.thang AND ikk.kdsatker = d.kdsatker AND ikk.kdunit = d.kdunit AND ikk.kdprogram = d.kdprogram AND ikk.kdgiat = d.kdgiat AND ikk.kdoutput = d.kdoutput AND ikk.kdsoutput = d.kdsoutput AND ikk.kdkmpnen = d.kdkmpnen AND ikk.kdskmpnen = d.kdskmpnen AND ikk.kdjendok = d.kdjendok  AND ikk.kddekon = d.kddekon)
                WHERE d.thang='$tahun'";

        $ret = $this->check_authorized_satker_unit();

        if ($unit != "0") {
            $sql = $sql . " AND d.kdunit='$unit' ";
        } else {
            if ($ret['type'] != "roren") {
                $unit_ = $ret['unit'];
                $sql = $sql . " AND (";
                foreach ($unit_ as $key => $value) {
                    $sql = $sql . " d.kdunit='$value' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($satker != "0") {
            $sql = $sql . " AND  d.kdsatker='$satker' ";
        } else {
            if ($ret['type'] == "roren") {
                
            }
            if ($ret['type'] == "unit") {
                if ($unit == "0") {
                    $unit_ = $ret['unit'];
                    $sql = $sql . " AND (";
                    foreach ($unit_ as $key => $value) {
                        $sql2 = "SELECT * FROM t_satker WHERE kdunit='$value'";
                        $result2 = mysql_query($sql2) or die(mysql_error());
                        //die($sql2);
                        while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                            $kdsatker_ = $row2['kdsatker'];
                            $sql = $sql . " d.kdsatker='$kdsatker_' OR";
                        }
                        $sql = substr_replace($sql, "", -3);
                        $sql = $sql . ")";
                    }
                } else {
                    $sql = $sql . " AND (";
                    $sql2 = "SELECT * FROM t_satker WHERE kdunit='$unit'";
                    $result2 = mysql_query($sql2) or die(mysql_error());
                    //die($sql2);
                    while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                        $kdsatker_ = $row2['kdsatker'];
                        $sql = $sql . " d.kdsatker='$kdsatker_' OR";
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                }
            }
            if ($ret['type'] == "propinsi" || $ret['type'] == "biasa") {
                $satker = $ret['satker'];
                if ($unit == "0") {
                    $sql = $sql . " AND (";
                    foreach ($satker as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $sql = $sql . " d.kdsatker='$value2' OR";
                        }
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                } else {
                    $sql = $sql . " AND (";
                    foreach ($satker[$unit] as $key => $value) {
                        $sql = $sql . " d.kdsatker='$value' OR";
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                }
            }
        }

        if ($program != "0") {
            $sql = $sql . " AND  d.kdprogram='$program' ";
        }

        if ($kegiatan != "0") {
            $sql = $sql . " AND  d.kdgiat='$kegiatan' ";
        }

        if ($ikk != "0") {
            $sql = $sql . " AND  ikk.ikk='$ikk' AND ikk.kdgiat='$kegiatan' ";
        }

        if ($fokus_prioritas != "0") {
            $sql = $sql . " AND (ikk.fokus_prioritas_utama='$fokus_prioritas' OR ikk.fokus_prioritas LIKE '%$fokus_prioritas%') ";
        }

        if ($reformasi_kesehatan != "0") {
            $sql = $sql . " AND (ikk.reformasi_kesehatan_utama='$reformasi_kesehatan' OR ikk.reformasi_kesehatan LIKE '%$reformasi_kesehatan%') ";
        }

        if ($akun != "") {
            $sql = $sql . " AND (";
            foreach ($akun as $key => $value) {
                $sql = $sql . " d.kdakun='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($lokasi != "") {
            $sql = $sql . " AND (";
            foreach ($lokasi as $key => $value) {
                $sql = $sql . " d.kdlokasi='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($beban != "") {
            $sql = $sql . " AND (";
            foreach ($beban as $key => $value) {
                $sql = $sql . " d.kdbeban='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($jenissat != "") {
            $sql = $sql . " AND (";
            foreach ($jenissat as $key => $value) {
                $sql = $sql . " d.kddekon='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        $sql = $sql . " AND d.kddept='024' AND d.kdakun LIKE '$belanja%' ORDER BY d.kdunit, d.kdsatker, d.kdprogram, d.kdgiat, d.kdoutput, d.kdsoutput, d.kdkmpnen, d.kdskmpnen, d.kdakun, d.noitem";
        //die ($sql);

        $result = mysql_query($sql) or die(mysql_error());
        $data = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            if (substr($row[0], 0, 2) == $belanja) {
                $data[] = $row[0] . "-;-" . $row[1] . "-;-" . $row[2] . "-;-" . $row[3] . "-;-" . $row[4] . "-;-" . $row[5] . "-;-" . $row[6] . "-;-" . $row[7];
            }
        }

        return $data;
    }

    public function get_belanja_data_pencarian_canggih($tahun, $unit, $satker, $lokasi, $program, $kegiatan, $beban, $jenissat, $sinonim, $akun, $katakunci, $akungroup, $akungroupakun, $tsinonim, $ikk, $reformasi_kesehatan, $fokus_prioritas, $sinonim_negatif, $data_sinonim_negatif) {
        $separator = "-|;|-";
        
        ini_set("memory_limit", "200M");

        $sql = "SELECT d.kdakun, unit.nmunit, satker.nmsatker, d.nmitem, d.volkeg, d.satkeg, d.hargasat, d.jumlah, akun.nmakun, komponen.urkmpnen, skomponen.urskmpnen,
                d.thang, d.kdjendok, d.kdsatker, d.kddept, d.kdunit, d.kdprogram, d.kdgiat, d.kdoutput, d.kdlokasi, d.kdkabkota, d.kddekon, d.kdsoutput, d.kdkmpnen, d.kdskmpnen
                FROM d_item d
                LEFT JOIN ref_satker satker ON satker.kdsatker=d.kdsatker
                LEFT JOIN t_unit unit ON unit.kdunit=d.kdunit AND unit.kddept=d.kddept
                LEFT JOIN t_akun akun ON akun.kdakun = d.kdakun
                LEFT JOIN t_jnsban jnsban ON (jnsban.kdbeban = d.kdbeban AND jnsban.kdjnsban=d.kdjnsban)
                LEFT JOIN d_skmpnen skomponen ON (skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kddept = d.kddept AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdlokasi = d.kdlokasi AND skomponen.kdkabkota = d.kdkabkota AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdjendok = d.kdjendok  AND skomponen.kddekon = d.kddekon AND skomponen.kdskmpnen = d.kdskmpnen )
                LEFT JOIN d_kmpnen komponen ON (komponen.thang = d.thang AND komponen.kdsatker = d.kdsatker AND komponen.kddept = d.kddept AND komponen.kdunit = d.kdunit AND komponen.kdprogram = d.kdprogram AND komponen.kdgiat = d.kdgiat AND komponen.kdoutput = d.kdoutput AND komponen.kdlokasi = d.kdlokasi AND komponen.kdkabkota = d.kdkabkota AND komponen.kdsoutput = d.kdsoutput AND komponen.kdkmpnen = d.kdkmpnen AND komponen.kdjendok = d.kdjendok  AND komponen.kddekon = d.kddekon)
                LEFT JOIN d_ikk_fokus ikk ON (ikk.thang = d.thang AND ikk.kdsatker = d.kdsatker AND ikk.kdunit = d.kdunit AND ikk.kdprogram = d.kdprogram AND ikk.kdgiat = d.kdgiat AND ikk.kdoutput = d.kdoutput AND ikk.kdsoutput = d.kdsoutput AND ikk.kdkmpnen = d.kdkmpnen AND ikk.kdskmpnen = d.kdskmpnen AND ikk.kdjendok = d.kdjendok  AND ikk.kddekon = d.kddekon)
                WHERE d.thang='$tahun'";

        $ret = $this->check_authorized_satker_unit();

        if ($unit != "0") {
            $sql = $sql . " AND d.kdunit='$unit' ";
        } else {
            if ($ret['type'] != "roren") {
                $unit_ = $ret['unit'];
                $sql = $sql . " AND (";
                foreach ($unit_ as $key => $value) {
                    $sql = $sql . " d.kdunit='$value' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($satker != "0") {
            $sql = $sql . " AND  d.kdsatker='$satker' ";
        } else {
            if ($ret['type'] == "roren") {
                
            }
            if ($ret['type'] == "unit") {
                if ($unit == "0") {
                    $unit_ = $ret['unit'];
                    $sql = $sql . " AND (";
                    foreach ($unit_ as $key => $value) {
                        $sql2 = "SELECT * FROM t_satker WHERE kdunit='$value'";
                        $result2 = mysql_query($sql2) or die(mysql_error());
                        //die($sql2);
                        while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                            $kdsatker_ = $row2['kdsatker'];
                            $sql = $sql . " d.kdsatker='$kdsatker_' OR";
                        }
                        $sql = substr_replace($sql, "", -3);
                        $sql = $sql . ")";
                    }
                } else {
                    $sql = $sql . " AND (";
                    $sql2 = "SELECT * FROM t_satker WHERE kdunit='$unit'";
                    $result2 = mysql_query($sql2) or die(mysql_error());
                    //die($sql2);
                    while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                        $kdsatker_ = $row2['kdsatker'];
                        $sql = $sql . " d.kdsatker='$kdsatker_' OR";
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                }
            }
            if ($ret['type'] == "propinsi" || $ret['type'] == "biasa") {
                $satker = $ret['satker'];
                if ($unit == "0") {
                    $sql = $sql . " AND (";
                    foreach ($satker as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $sql = $sql . " d.kdsatker='$value2' OR";
                        }
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                } else {
                    $sql = $sql . " AND (";
                    foreach ($satker[$unit] as $key => $value) {
                        $sql = $sql . " d.kdsatker='$value' OR";
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                }
            }
        }

        if ($program != "0") {
            $sql = $sql . " AND  d.kdprogram='$program' ";
        }

        if ($kegiatan != "0") {
            $sql = $sql . " AND  d.kdgiat='$kegiatan' ";
        }
        if ($ikk != "0") {
            $sql = $sql . " AND  ikk.ikk='$ikk' AND ikk.kdgiat='$kegiatan' ";
        }

        if ($fokus_prioritas != "0") {
            $sql = $sql . " AND (ikk.fokus_prioritas_utama='$fokus_prioritas' OR ikk.fokus_prioritas LIKE '%$fokus_prioritas%') ";
        }

        if ($reformasi_kesehatan != "0") {
            $sql = $sql . " AND (ikk.reformasi_kesehatan_utama='$reformasi_kesehatan' OR ikk.reformasi_kesehatan LIKE '%$reformasi_kesehatan%') ";
        }

        if ($lokasi != "") {
            $sql = $sql . " AND (";
            foreach ($lokasi as $key => $value) {
                $sql = $sql . " d.kdlokasi='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($beban != "") {
            $sql = $sql . " AND (";
            foreach ($beban as $key => $value) {
                $kdb_ = substr($value, 0, 1);
                $kdjns = substr($value, 1, 1);
                $sql = $sql . " (d.kdbeban='$kdb_' AND d.kdjnsban='$kdjns') OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($jenissat != "") {
            $sql = $sql . " AND (";
            foreach ($jenissat as $key => $value) {
                $sql = $sql . " d.kddekon='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($tsinonim[0] == "0") {
            if (count($katakunci) > 0) {
                $sql = $sql . " AND (";
                foreach ($katakunci as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " d.nmitem LIKE '%$value%' OR";
                    $sql = $sql . " skomponen.urskmpnen LIKE '%$value%' OR";
                    $sql = $sql . " komponen.urkmpnen LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($tsinonim[0] == "0") {
            if (count($data_sinonim_negatif) > 0) {
                $sql = $sql . " AND (";
                foreach ($data_sinonim_negatif as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " d.nmitem NOT LIKE '%$value%' OR";
                    $sql = $sql . " skomponen.urskmpnen NOT LIKE '%$value%' OR";
                    $sql = $sql . " komponen.urkmpnen NOT LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($tsinonim[0] == "1") {
            if (count($katakunci) > 0) {
                $sql = $sql . " AND (";
                foreach ($katakunci as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " d.nmitem LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($tsinonim[0] == "1") {
            if (count($data_sinonim_negatif) > 0) {
                $sql = $sql . " AND (";
                foreach ($data_sinonim_negatif as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " d.nmitem NOT LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($tsinonim[0] == "2") {
            if (count($katakunci) > 0) {
                $sql = $sql . " AND (";
                foreach ($katakunci as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " skomponen.urskmpnen LIKE '%$value%' OR";
                    $sql = $sql . " komponen.urkmpnen LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($tsinonim[0] == "2") {
            if (count($data_sinonim_negatif) > 0) {
                $sql = $sql . " AND (";
                foreach ($data_sinonim_negatif as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " skomponen.urskmpnen NOT LIKE '%$value%' OR";
                    $sql = $sql . " komponen.urkmpnen NOT LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if (count($akungroupakun) > 0) {
            $sql = $sql . " AND (";
            foreach ($akungroupakun as $key => $value) {
                $sql = $sql . " d.kdakun='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        $sql = $sql . " AND d.kddept='024' ORDER BY d.kdunit, d.kdsatker, d.kdprogram, d.kdgiat, d.kdoutput, d.kdsoutput, d.kdkmpnen, d.kdskmpnen, d.kdakun, d.noitem";
        //die($sql);
        //var_dump($sql);
        $result = mysql_query($sql) or die(mysql_error());
        $data = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            if ($sinonim) {
                $correct_akun = "0";
                foreach ($akun as $key => $value) {
                    if ($value == $row[0]) {
                        $correct_akun = "1";
                        break;
                    }
                }
            } else {
                $correct_akun = "1";
            }

//            $data[] = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[0]."-".$row[8],$correct_akun,$row[9],$row[10],
//                    $row[11]."-".$row[12]."-".$row[13]."-".$row[14]."-".$row[15]."-".$row[16]."-".$row[17]."-".$row[18]."-".$row[19]."-".$row[20]."-".$row[21]."-".$row[22]."-".$row[23]."-".$row[24]);
  
            $data[] = $row[0] . "$separator" . $row[1] . "$separator" . $row[2] . "$separator" . $row[3] . "$separator" . $row[4] . "$separator" . $row[5] . "$separator" . $row[6] . "$separator" . $row[7] . "$separator" . $row[0] . " - " . $row[8] . "$separator" . $correct_akun . "$separator" . $row[9] . "$separator" . $row[10] . "$separator" .
                    $row[11] . "-" . $row[12] . "-" . $row[13] . "-" . $row[14] . "-" . $row[15] . "-" . $row[16] . "-" . $row[17] . "-" . $row[18] . "-" . $row[19] . "-" . $row[20] . "-" . $row[21] . "-" . $row[22] . "-" . $row[23] . "-" . $row[24];
        }

        return $data;
    }
    
    public function get_belanja_data_pencarian_canggih_volume($tahun, $unit, $satker, $lokasi, $program, $kegiatan, $beban, $jenissat, $sinonim, $akun, $katakunci, $akungroup, $akungroupakun, $tsinonim, $ikk, $reformasi_kesehatan, $fokus_prioritas, $volume) {
        $separator = "-|;|-";
        
        ini_set("memory_limit", "200M");

        $sql = "SELECT d.kdakun, unit.nmunit, satker.nmsatker, d.nmitem, d.volkeg, d.satkeg, d.hargasat, d.jumlah, akun.nmakun, komponen.urkmpnen, skomponen.urskmpnen,
                d.thang, d.kdjendok, d.kdsatker, d.kddept, d.kdunit, d.kdprogram, d.kdgiat, d.kdoutput, d.kdlokasi, d.kdkabkota, d.kddekon, d.kdsoutput, d.kdkmpnen, d.kdskmpnen, d.vol1, d.sat1, d.vol2, d.sat2, d.vol3, d.sat3, d.vol4, d.sat4
                FROM d_item d
                LEFT JOIN ref_satker satker ON satker.kdsatker=d.kdsatker
                LEFT JOIN t_unit unit ON unit.kdunit=d.kdunit AND unit.kddept=d.kddept
                LEFT JOIN t_akun akun ON akun.kdakun = d.kdakun
                LEFT JOIN t_jnsban jnsban ON (jnsban.kdbeban = d.kdbeban AND jnsban.kdjnsban=d.kdjnsban)
                LEFT JOIN d_skmpnen skomponen ON (skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kddept = d.kddept AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdlokasi = d.kdlokasi AND skomponen.kdkabkota = d.kdkabkota AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdjendok = d.kdjendok  AND skomponen.kddekon = d.kddekon AND skomponen.kdskmpnen = d.kdskmpnen )
                LEFT JOIN d_kmpnen komponen ON (komponen.thang = d.thang AND komponen.kdsatker = d.kdsatker AND komponen.kddept = d.kddept AND komponen.kdunit = d.kdunit AND komponen.kdprogram = d.kdprogram AND komponen.kdgiat = d.kdgiat AND komponen.kdoutput = d.kdoutput AND komponen.kdlokasi = d.kdlokasi AND komponen.kdkabkota = d.kdkabkota AND komponen.kdsoutput = d.kdsoutput AND komponen.kdkmpnen = d.kdkmpnen AND komponen.kdjendok = d.kdjendok  AND komponen.kddekon = d.kddekon)
                LEFT JOIN d_ikk_fokus ikk ON (ikk.thang = d.thang AND ikk.kdsatker = d.kdsatker AND ikk.kdunit = d.kdunit AND ikk.kdprogram = d.kdprogram AND ikk.kdgiat = d.kdgiat AND ikk.kdoutput = d.kdoutput AND ikk.kdsoutput = d.kdsoutput AND ikk.kdkmpnen = d.kdkmpnen AND ikk.kdskmpnen = d.kdskmpnen AND ikk.kdjendok = d.kdjendok  AND ikk.kddekon = d.kddekon)
                WHERE d.thang='$tahun'";

        $ret = $this->check_authorized_satker_unit();

        if ($unit != "0") {
            $sql = $sql . " AND d.kdunit='$unit' ";
        } else {
            if ($ret['type'] != "roren") {
                $unit_ = $ret['unit'];
                $sql = $sql . " AND (";
                foreach ($unit_ as $key => $value) {
                    $sql = $sql . " d.kdunit='$value' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($satker != "0") {
            $sql = $sql . " AND  d.kdsatker='$satker' ";
        } else {
            if ($ret['type'] == "roren") {
                
            }
            if ($ret['type'] == "unit") {
                if ($unit == "0") {
                    $unit_ = $ret['unit'];
                    $sql = $sql . " AND (";
                    foreach ($unit_ as $key => $value) {
                        $sql2 = "SELECT * FROM t_satker WHERE kdunit='$value'";
                        $result2 = mysql_query($sql2) or die(mysql_error());
                        //die($sql2);
                        while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                            $kdsatker_ = $row2['kdsatker'];
                            $sql = $sql . " d.kdsatker='$kdsatker_' OR";
                        }
                        $sql = substr_replace($sql, "", -3);
                        $sql = $sql . ")";
                    }
                } else {
                    $sql = $sql . " AND (";
                    $sql2 = "SELECT * FROM t_satker WHERE kdunit='$unit'";
                    $result2 = mysql_query($sql2) or die(mysql_error());
                    //die($sql2);
                    while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                        $kdsatker_ = $row2['kdsatker'];
                        $sql = $sql . " d.kdsatker='$kdsatker_' OR";
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                }
            }
            if ($ret['type'] == "propinsi" || $ret['type'] == "biasa") {
                $satker = $ret['satker'];
                if ($unit == "0") {
                    $sql = $sql . " AND (";
                    foreach ($satker as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $sql = $sql . " d.kdsatker='$value2' OR";
                        }
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                } else {
                    $sql = $sql . " AND (";
                    foreach ($satker[$unit] as $key => $value) {
                        $sql = $sql . " d.kdsatker='$value' OR";
                    }
                    $sql = substr_replace($sql, "", -3);
                    $sql = $sql . ")";
                }
            }
        }

        if ($program != "0") {
            $sql = $sql . " AND  d.kdprogram='$program' ";
        }

        if ($kegiatan != "0") {
            $sql = $sql . " AND  d.kdgiat='$kegiatan' ";
        }
        if ($ikk != "0") {
            $sql = $sql . " AND  ikk.ikk='$ikk' AND ikk.kdgiat='$kegiatan' ";
        }

        if ($fokus_prioritas != "0") {
            $sql = $sql . " AND (ikk.fokus_prioritas_utama='$fokus_prioritas' OR ikk.fokus_prioritas LIKE '%$fokus_prioritas%') ";
        }

        if ($reformasi_kesehatan != "0") {
            $sql = $sql . " AND (ikk.reformasi_kesehatan_utama='$reformasi_kesehatan' OR ikk.reformasi_kesehatan LIKE '%$reformasi_kesehatan%') ";
        }

        if ($lokasi != "") {
            $sql = $sql . " AND (";
            foreach ($lokasi as $key => $value) {
                $sql = $sql . " d.kdlokasi='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($beban != "") {
            $sql = $sql . " AND (";
            foreach ($beban as $key => $value) {
                $kdb_ = substr($value, 0, 1);
                $kdjns = substr($value, 1, 1);
                $sql = $sql . " (d.kdbeban='$kdb_' AND d.kdjnsban='$kdjns') OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($jenissat != "") {
            $sql = $sql . " AND (";
            foreach ($jenissat as $key => $value) {
                $sql = $sql . " d.kddekon='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }

        if ($tsinonim[0] == "0") {
            if (count($katakunci) > 0) {
                $sql = $sql . " AND (";
                foreach ($katakunci as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " d.nmitem LIKE '%$value%' OR";
                    $sql = $sql . " skomponen.urskmpnen LIKE '%$value%' OR";
                    $sql = $sql . " komponen.urkmpnen LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if ($tsinonim[0] == "1") {
            if (count($katakunci) > 0) {
                $sql = $sql . " AND (";
                foreach ($katakunci as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " d.nmitem LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }
        if ($tsinonim[0] == "2") {
            if (count($katakunci) > 0) {
                $sql = $sql . " AND (";
                foreach ($katakunci as $key => $value) {
                    $value = $this->db->escape_like_str($value);
                    $sql = $sql . " skomponen.urskmpnen LIKE '%$value%' OR";
                    $sql = $sql . " komponen.urkmpnen LIKE '%$value%' OR";
                }
                $sql = substr_replace($sql, "", -3);
                $sql = $sql . ")";
            }
        }

        if (count($akungroupakun) > 0) {
            $sql = $sql . " AND (";
            foreach ($akungroupakun as $key => $value) {
                $sql = $sql . " d.kdakun='$value' OR";
            }
            $sql = substr_replace($sql, "", -3);
            $sql = $sql . ")";
        }
        
        if (trim($volume) != "") {
            $sql = $sql . " AND  (d.sat1 LIKE '$volume' OR d.sat2 LIKE '$volume' OR d.sat3 LIKE '$volume' OR d.sat4 LIKE '$volume') ";
        }

        $sql = $sql . " AND d.kddept='024' ORDER BY d.kdunit, d.kdsatker, d.kdprogram, d.kdgiat, d.kdoutput, d.kdsoutput, d.kdkmpnen, d.kdskmpnen, d.noitem";
        //die($sql);

        $result = mysql_query($sql) or die(mysql_error());
        $data = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            if ($sinonim) {
                $correct_akun = "0";
                foreach ($akun as $key => $value) {
                    if ($value == $row[0]) {
                        $correct_akun = "1";
                        break;
                    }
                }
            } else {
                $correct_akun = "1";
            }

            $totalvolume = 0;
            
            $sat1 = $row[26];
            $sat2 = $row[28];
            $sat3 = $row[30];
            $sat4 = $row[32];
            
            $vol1 = $row[25];
            $vol2 = $row[27];
            $vol3 = $row[29];
            $vol4 = $row[31];
            
            if ($sat1 == trim($volume)) {
                $totalvolume = $vol1;
            }
            if ($sat2 == trim($volume)) {
                $totalvolume = $vol2;
            }
            if ($sat3 == trim($volume)) {
                $totalvolume = $vol3;
            }            
            if ($sat4 == trim($volume)) {
                $totalvolume = $vol4;
            }    
            
            $data[] = $row[0] . "$separator" . $row[1] . "$separator" . $row[2] . "$separator" . $row[3] . "$separator" . $row[4] . "$separator" . $row[5] . "$separator" . $row[6] . "$separator" . $totalvolume . "$separator" . $row[0] . " - " . $row[8] . "$separator" . $correct_akun . "$separator" . $row[9] . "$separator" . $row[10] . "$separator" .
                    $row[11] . "-" . $row[12] . "-" . $row[13] . "-" . $row[14] . "-" . $row[15] . "-" . $row[16] . "-" . $row[17] . "-" . $row[18] . "-" . $row[19] . "-" . $row[20] . "-" . $row[21] . "-" . $row[22] . "-" . $row[23] . "-" . $row[24];
        }

        return $data;
    }    

    function check_authorized_satker_unit() {
        // badan layanan umum
        //$kdsatker = "632200";
        // satker propinsi DKI Jakarta (kode induk tidak sama)
        //$kdsatker = "019008";
        // satker propinsi DKI Jakarta (kode induk sama)
        //$kdsatker = "010024";  
        // satker kabupaten bekasi (kode induk tidak sama) kdunit = 1,3,5
        //$kdsatker = "029374"; 
        // satker kabupaten bekasi (kode induk sama) kdunit = 1,3,5
        //$kdsatker = "020809";
        // satker unit BUK
        //$kdsatker = "466080";
        // vertikal-upt
        //$kdsatker = "416114";
        // permanen pusat
        //$kdsatker = "466034";
        // roren
        //$kdsatker = "465915";

        $kdsatker = $this->session->userdata('kdsatker');
//        die ($kdsatker);

        $unit = array();
        $satker = array();
        $ret = array();
        // satker roren, satker super
        if ($kdsatker == "465915") {
            $ret['type'] = "roren";
            return $ret;
        }

        $sql = "SELECT * FROM t_satker_unit WHERE kdsatker='$kdsatker' ORDER BY kdunit";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $unit[] = $row['kdunit'];
        }

        if (count($unit) == 0) {
            $kdlokasi = "";
            $sql = "SELECT * FROM t_satker WHERE kdsatker='$kdsatker' AND kdkabkota='00' AND kdjnssat='4'";
            $result = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
                $kdlokasi = $row['kdlokasi'];
            }
            if ($kdlokasi) {
                // satker propinsi, ambil semua satker dan unit yang berada dalam lokasi yang sama dengan jenis satker 4
                $sql = "SELECT * FROM t_satker WHERE kdlokasi='$kdlokasi' AND kdjnssat='4'";
                $result = mysql_query($sql) or die(mysql_error());
                while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
                    $kd_unit = $row['kdunit'];
                    $kd_satker = $row['kdsatker'];
                    if (!in_array($kd_satker, $satker)) {
                        if (isset($satker[$kd_unit])) {
                            $satker[$kd_unit][] = $kd_satker;
                        } else {
                            $satker[$kd_unit] = array();
                            $satker[$kd_unit][] = $kd_satker;
                        }
                    }
                    if (!in_array($kd_unit, $unit)) {
                        $unit[] = $kd_unit;
                    }
                }
                $ret['type'] = "propinsi";
                $ret['unit'] = $unit;
                $ret['satker'] = $satker;
                return $ret;
            } else {
                // satker biasa, ambil semua satker dan unit yang punya kode induk stker yang sama
                $sql = "SELECT t2.* FROM t_satker t1, t_satker t2 WHERE t1.kdsatker='$kdsatker' AND t1.kdinduk=t2.kdinduk";
                $result = mysql_query($sql) or die(mysql_error());
                while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
                    $kd_unit = $row['kdunit'];
                    $kd_satker = $row['kdsatker'];
                    if (!in_array($kd_satker, $satker)) {
                        if (isset($satker[$kd_unit])) {
                            $satker[$kd_unit][] = $kd_satker;
                        } else {
                            $satker[$kd_unit] = array();
                            $satker[$kd_unit][] = $kd_satker;
                        }
                    }
                    if (!in_array($kd_unit, $unit)) {
                        $unit[] = $kd_unit;
                    }
                }
                $ret['type'] = "biasa";
                $ret['unit'] = $unit;
                $ret['satker'] = $satker;
                return $ret;
            }
        } else {
            // satker unit, ambil unit dan tampilkan unit itu saja dalam pilihan unit
            $ret['type'] = "unit";
            $ret['unit'] = $unit;
            $ret['satker'] = $satker;
            return $ret;
        }
    }

    function get_all_unit() {
        $ret = $this->check_authorized_satker_unit();
        if ($ret['type'] == 'roren') {
            // satker roren
            $sql = "SELECT * from t_unit WHERE kddept='024' order by kdunit";
            $result = $this->db->query($sql);
            //die(var_dump($result->result()));
            $dataView = array();
            foreach ($result->result() as $row) {
                $dataView[$row->kdunit] = $row->nmunit;
            }
            return $dataView;
        } else {
            $unit = $ret['unit'];
            $sql = "SELECT * from t_unit WHERE kddept='024' order by kdunit";
            $result = $this->db->query($sql);
            //die(var_dump($result->result()));
            $dataView = array();
            if ($ret['type'] != 'unit') {
                $dataView["0"] = "SEMUA UNIT";
            }
            foreach ($result->result() as $row) {
                if (in_array($row->kdunit, $unit)) {
                    $dataView[$row->kdunit] = $row->nmunit;
                }
            }
            return $dataView;
        }
    }

    function get_all_unit_complete() {
        $ret = $this->check_authorized_satker_unit();
        if ($ret['type'] == 'roren') {
            // satker roren
            $sql = "SELECT * from t_unit WHERE kddept='024' order by kdunit";
            $result = $this->db->query($sql);
            //die(var_dump($result->result()));
            $dataView = array();
            $dataView["0"] = "SEMUA UNIT";
            foreach ($result->result() as $row) {
                $dataView[$row->kdunit] = $row->nmunit;
            }
            return $dataView;
        } else {
            $unit = $ret['unit'];
            $sql = "SELECT * from t_unit WHERE kddept='024' order by kdunit";
            $result = $this->db->query($sql);
            //die(var_dump($result->result()));
            $dataView = array();
            $dataView["0"] = "SEMUA UNIT";
            foreach ($result->result() as $row) {
                if (in_array($row->kdunit, $unit)) {
                    $dataView[$row->kdunit] = $row->nmunit;
                }
            }
            return $dataView;
        }
    }

    function get_all_satker_script() {
        $ret = $this->check_authorized_satker_unit();
//        die (var_dump($ret));
        if($this->session->userdata('kd_role') == '4'){
                // satker biasa
                $unit = $ret['unit'];
                $satker_check = $ret['satker'];

                $script = "var kdunit = new Array();";
                foreach ($unit as $key => $value) {
                    $script = $script . "kdunit[\"" . $value . "\"] = new Array();\n";
                    $sql = "SELECT * FROM t_satker t WHERE kddept='024' AND kdunit='" . $value . "' ORDER BY kdsatker";
                    $result2 = mysql_query($sql) or die(mysql_error());
                    while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                        if (in_array($row2['kdsatker'], $satker_check[$value])) {
                            $nmsatker = $row2['nmsatker'];
                            $nmsatker = str_replace("\"", "", $nmsatker);
                            $kdsatker = $row2['kdsatker'];
                            $script = $script . "kdunit[\"" . $value . "\"][\"" . $kdsatker . "\"] = \"" . $nmsatker . "\";\n";
                        }
                    }
                }
            }
        elseif ($ret['type'] == 'roren') {
            // satker roren
            $sql = "SELECT * from t_unit WHERE kddept='024' ORDER BY kdunit";
            $result = mysql_query($sql) or die(mysql_error());
            $script = "var kdunit = new Array();";
            while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
                $script = $script . "kdunit[\"" . $row['kdunit'] . "\"] = new Array();\n";

                $sql = "SELECT * FROM t_satker t WHERE kddept='024' AND kdunit='" . $row['kdunit'] . "' ORDER BY nmsatker";
                $result2 = mysql_query($sql) or die(mysql_error());
                while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                    $nmsatker = $row2['nmsatker'];
                    $nmsatker = str_replace("\"", "", $nmsatker);
                    $kdsatker = $row2['kdsatker'];
                    $script = $script . "kdunit[\"" . $row['kdunit'] . "\"][\"" . $kdsatker . "\"] = \"" . $nmsatker . "\";\n";
                }
            }

            return $script;
        } elseif ($ret['type'] == 'unit') {
                // all saker, satker unit
                $unit = $ret['unit'];
                $script = "var kdunit = new Array();";
                $script = $script . "kdunit[\"" . $unit[0] . "\"] = new Array();\n";

                $sql = "SELECT * FROM t_satker t WHERE kddept='024' AND kdunit='" . $unit[0] . "' ORDER BY kdsatker";
                $result2 = mysql_query($sql) or die(mysql_error());
                while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                    $nmsatker = $row2['nmsatker'];
                    $nmsatker = str_replace("\"", "", $nmsatker);
                    $kdsatker = $row2['kdsatker'];
                    $script = $script . "kdunit[\"" . $unit[0] . "\"][\"" . $kdsatker . "\"] = \"" . $nmsatker . "\";\n";
                }
                return $script;
            } 

            return $script;
        
    }

    function get_all_program_script() {
        $sql = "SELECT * from t_unit WHERE kddept='024' ORDER BY kdunit";
        $result = mysql_query($sql) or die(mysql_error());
        $script = "var kdunit_p = new Array();";
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $script = $script . "kdunit_p[\"" . $row['kdunit'] . "\"] = new Array();\n";

            $sql = "SELECT * FROM t_program t WHERE kddept='024' AND kdunit='" . $row['kdunit'] . "' ORDER BY kdprogram";
            $result2 = mysql_query($sql) or die(mysql_error());
            while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                $nmprogram = $row2['nmprogram'];
                $nmprogram = str_replace("\"", "", $nmprogram);
                $kdprogram = $row2['kdprogram'];
                $script = $script . "kdunit_p[\"" . $row['kdunit'] . "\"][\"" . $kdprogram . "\"] = \"" . $nmprogram . "\";\n";
            }
        }

        return $script;
    }

    function get_all_kegiatan_script() {
        $sql = "SELECT * from t_program WHERE kddept='024' ORDER BY kdprogram";
        $result = mysql_query($sql) or die(mysql_error());
        $script = "var kdprogram = new Array();";
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $script = $script . "kdprogram[\"" . $row['kdprogram'] . "\"] = new Array();\n";

            $sql = "SELECT * FROM t_giat t WHERE kddept='024' AND kdprogram='" . $row['kdprogram'] . "' ORDER BY kdprogram";
            $result2 = mysql_query($sql) or die(mysql_error());
            while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                $nmgiat = $row2['nmgiat'];
                $nmgiat = str_replace("\"", "", $nmgiat);
                $kdgiat = $row2['kdgiat'];
                $script = $script . "kdprogram[\"" . $row['kdprogram'] . "\"][$kdgiat] = \"" . $nmgiat . "\";\n";
            }
        }

        return $script;
    }

    function get_all_program() {
        $sql = "SELECT kdprogram, nmprogram FROM t_program t WHERE kddept='024' ORDER BY kdprogram";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        $dataView['0'] = "SEMUA PROGRAM";
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['kdprogram']] = $row['nmprogram'];
        }
        return $dataView;
    }

    function get_all_kegiatan() {
        $sql = "SELECT kdgiat, nmgiat FROM t_giat t WHERE kddept='024' ORDER BY kdgiat";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        $dataView['0'] = "SEMUA KEGIATAN";
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['kdgiat']] = $row['nmgiat'];
        }
        return $dataView;
    }

    function get_all_akun() {
        $sql = "SELECT kdakun, nmakun FROM t_akun t WHERE kdakun LIKE '5%' ORDER BY kdakun";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['kdakun']] = $row['kdakun'] . " - " . $row['nmakun'];
        }
        return $dataView;
    }

    function get_all_akun_script() {
        $script = "var kdakun = new Array();";
        $sql = "SELECT kdakun, nmakun FROM t_akun t WHERE kdakun LIKE '5%' ORDER BY kdakun";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $script = $script . "kdakun[\"" . $row['kdakun'] . "\"] = \"" . $row['kdakun'] . " - " . $row['nmakun'] . "\";\n";
        }
        return $script;
    }

    function get_all_location() {
        $sql = "SELECT kdlokasi, nmlokasi FROM t_lokasi t ORDER BY kdlokasi";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['kdlokasi']] = $row['nmlokasi'];
        }
        return $dataView;
    }

    function get_all_beban() {
        $sql = "SELECT kdbeban, kdjnsban, nmjnsban FROM t_jnsban t ORDER BY kdbeban";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['kdbeban'] . $row['kdjnsban']] = $row['nmjnsban'];
        }
        return $dataView;
    }

    function get_all_dekon() {
        $sql = "SELECT kddekon, nmdekon FROM t_dekon ORDER BY kddekon";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['kddekon']] = $row['nmdekon'];
        }
        return $dataView;
    }

    function get_all_sinonim_negatif() {
        $sql = "SELECT id, nmsinonim FROM sinonim_negatif ORDER BY id";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['id']] = $row['nmsinonim'];
        }
        return $dataView;
    }

    function get_fokus_prioritas_ikk($key) {
        //d.thang, d.kdsatker, d.kdunit, d.kdprogram, d.kdgiat, d.kdoutput, d.kdsoutput, d.kdkmpnen, skomponen.kdskmpnen, d.kdjendok, d.kddekon,
        $keys = explode("-", $key);
        $thang = $keys[0];
        $kdsatker = $keys[1];
        $kdunit = $keys[2];
        $kdprogram = $keys[3];
        $kdgiat = $keys[4];
        $kdoutput = $keys[5];
        $kdsoutput = $keys[6];
        $kdkmpnen = $keys[7];
        $kdskmpnen = $keys[8];
        $kdjendok = $keys[9];
        $kddekon = $keys[10];
        //if (strlen($kdskmpnen) == 1) {
        //    $kdskmpnen = " " . $kdskmpnen;
        //}

        $sql = "SELECT fokus_prioritas, ikk, fokus_prioritas_utama, reformasi_kesehatan_utama, reformasi_kesehatan FROM d_ikk_fokus WHERE thang='$thang' AND kdsatker='$kdsatker'
                AND kdunit='$kdunit' AND kdprogram='$kdprogram' AND kdgiat='$kdgiat' AND kdoutput='$kdoutput'
                AND kdsoutput='$kdsoutput' AND kdkmpnen='$kdkmpnen' AND kdskmpnen='$kdskmpnen'
                AND kdjendok='$kdjendok' AND kddekon='$kddekon'";

        //die ($sql);

        $result = mysql_query($sql) or die(mysql_error());
        $ret = array();
        $ret[0] = array();
        $ret[1] = "";
        $ret[2] = array();
        $ret[3] = "";
        $ret[4] = "";
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $fokus_prioritas = $row['fokus_prioritas'];
            $reformasi_kesehatan = $row['reformasi_kesehatan'];
            $ikk = $row['ikk'];
            $ret[0] = explode(",", $fokus_prioritas);
            $ret[1] = $row['fokus_prioritas_utama'];
            $ret[2] = explode(",", $reformasi_kesehatan);
            $ret[3] = $row['reformasi_kesehatan_utama'];
            $ret[4] = $ikk;
        }
        return $ret;
    }

    function save_fokus_prioritas($key, $fokus_prioritas, $ikk, $fokus_prioritas_utama, $reformasi_kesehatan, $reformasi_kesehatan_utama) {
        $ret = 0;

        $keys = explode("-", $key);
        $thang = $keys[0];
        $kdsatker = $keys[1];
        $kdunit = $keys[2];
        $kdprogram = $keys[3];
        $kdgiat = $keys[4];
        $kdoutput = $keys[5];
        $kdsoutput = $keys[6];
        $kdkmpnen = $keys[7];
        $kdskmpnen = $keys[8];
//        if (strlen($kdskmpnen) == 1) {
//            $kdskmpnen = " " . $kdskmpnen;
//        }
        $kdjendok = $keys[9];
        $kddekon = $keys[10];

        $s_fokus_prioritas = "";
        if ($fokus_prioritas) {
            foreach ($fokus_prioritas as $key => $value) {
                $s_fokus_prioritas = $s_fokus_prioritas . $value . ",";
                if ($value == $fokus_prioritas_utama) {
                    $ret = 1;
                    return $ret;
                }
            }
        }
        if ($s_fokus_prioritas != "") {
            $s_fokus_prioritas = substr($s_fokus_prioritas, 0, -1);
        }

        $s_reformasi_kesehatan = "";
        if ($reformasi_kesehatan) {
            foreach ($reformasi_kesehatan as $key => $value) {
                $s_reformasi_kesehatan = $s_reformasi_kesehatan . $value . ",";
                if ($value == $reformasi_kesehatan_utama) {
                    $ret = 1;
                    return $ret;
                }
            }
        }
        if ($s_reformasi_kesehatan != "") {
            $s_reformasi_kesehatan = substr($s_reformasi_kesehatan, 0, -1);
        }

        $sql = "DELETE FROM d_ikk_fokus
                WHERE thang='$thang' AND kdsatker='$kdsatker'
                AND kdunit='$kdunit' AND kdprogram='$kdprogram' AND kdgiat='$kdgiat' AND kdoutput='$kdoutput'
                AND kdsoutput='$kdsoutput' AND kdkmpnen='$kdkmpnen' AND kdskmpnen='$kdskmpnen'
                AND kdjendok='$kdjendok' AND kddekon='$kddekon'";

        $result = mysql_query($sql) or die(mysql_error());

        $sql = "INSERT INTO d_ikk_fokus VALUES ('$thang', '$kdjendok', '$kdsatker', '$kdunit', '$kdprogram',
                '$kdgiat', '$kdoutput', '$kddekon', '$kdsoutput', '$kdkmpnen', '$kdskmpnen', '$s_fokus_prioritas',
                '$ikk', '$fokus_prioritas_utama', '$reformasi_kesehatan_utama', '$s_reformasi_kesehatan')";
        //die ($sql);
        $result = mysql_query($sql) or die(mysql_error());
    }

    function get_all_fokus_prioritas() {
        $sql = "SELECT idFokusPrioritas, FokusPrioritas FROM fokus_prioritas ORDER BY idFokusPrioritas";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['idFokusPrioritas']] = $row['FokusPrioritas'];
        }
        //die (var_dump($dataView));
        return $dataView;
    }

    function get_all_reformasi_kesehatan() {
        $sql = "SELECT idReformasiKesehatan, ReformasiKesehatan FROM reformasi_kesehatan ORDER BY idReformasiKesehatan";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['idReformasiKesehatan']] = $row['ReformasiKesehatan'];
        }
        //die (var_dump($dataView));
        return $dataView;
    }

    function get_all_ikk($kdgiat) {
        $sql = "SELECT kdikk, nmikk FROM t_ikk WHERE kdgiat='$kdgiat' ORDER BY kdikk";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView[$row['kdikk']] = $row['nmikk'];
        }
        //die (var_dump($dataView));
        return $dataView;
    }

    function get_all_ikk_script() {
        $sql = "SELECT * from t_giat WHERE kddept='024' ORDER BY kdgiat";
        $result = mysql_query($sql) or die(mysql_error());
        $script = "var kdgiat = new Array();";
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $script = $script . "kdgiat[\"" . $row['kdgiat'] . "\"] = new Array();\n";

            $sql = "SELECT * FROM t_ikk t WHERE kdgiat='" . $row['kdgiat'] . "' ORDER BY kdikk";
            $result2 = mysql_query($sql) or die(mysql_error());
            while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                $nmikk = $row2['nmikk'];
                $nmikk = str_replace("\"", "", $nmikk);
                $kdikk = $row2['kdikk'];
                $script = $script . "kdgiat[\"" . $row['kdgiat'] . "\"][\"$kdikk\"] = \"" . $nmikk . "\";\n";
            }
        }

        return $script;
    }
   
    function add_feedback($satker, $key, $feedback, $status) {
        $kdsatker_src = $this->session->userdata('kdsatker');
        $username = $this->session->userdata('username');
        $feedback = $value = $this->db->escape($feedback);
        $sql = "INSERT INTO feedback (fkey, kdsatker_src, kdsatker_dest, feedback, sts, thang, creator) VALUES ('$key', '$kdsatker_src', '$satker', $feedback, $status, now(), '$username')";
        mysql_query($sql) or die(mysql_error());
    }
    
    function get_feedback($key) {
        $this->db->select('id, s1.nmsatker as satkersrc, s2.nmsatker as satkerdest, feedback, sts, thang, creator');
        $this->db->from('feedback f ');
        $this->db->join('t_satker s1', 's1.kdsatker=f.kdsatker_src', 'left');
        $this->db->join('t_satker s2', 's2.kdsatker=f.kdsatker_dest', 'left');
        $this->db->where('f.fkey', $key);
        $this->db->order_by('thang', 'desc'); 

        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('s1.nmsatker as satkersrc, s2.nmsatker as satkerdest, feedback, sts, thang, creator');
        $this->db->from('feedback f ');
        $this->db->join('t_satker s1', 's1.kdsatker=f.kdsatker_src', 'left');
        $this->db->join('t_satker s2', 's2.kdsatker=f.kdsatker_dest', 'left');
        $this->db->where('f.fkey', $key);
        $this->db->order_by('thang', 'desc'); 

        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        //die (var_dump($query['record_count']));
        return $query;
    }

    function get_view_db_output($tahun, $unit, $satker) {
        $this->db->select('*');
        $this->db->from('t_giat d');
        $this->db->join('t_output output', 'output.kdgiat = d.kdgiat AND output.kdoutput = d.kdoutput', 'left');
        $this->db->join('t_satker satker', 'satker.kdsatker=d.kdsatker', 'inner');
        if($this->session->userdata('kd_role') == '4')
        {
            $this->db->join($this->db->database.'.ref_satker', $this->db->database.'.ref_satker.kdsatker = d.kdsatker');
            $this->db->where($this->db->database.'.ref_satker.kdinduk', $this->session->userdata('kdinduk'));
        }
        $this->db->where('d.thang', $tahun);

        if ($satker != "0") {
            $this->db->where('d.kdsatker', $satker);
        }

        $ret = $this->check_authorized_satker_unit();

        if ($unit != "0") {
            $this->db->where('d.kdunit', $unit);
        } else {
            if ($ret['type'] != "roren") {
                $unit_ = $ret['unit'];
                $this->db->where_in('d.kdunit', $unit_);
            }
        }

        if ($satker != "0") {
            $this->db->where('d.kdsatker', $satker);
        } else {
            if ($ret['type'] == "roren") {
                
            }
            if ($ret['type'] == "unit") {
                if ($unit == "0") {
                    $unit_ = $ret['unit'];
                    $kdsatker_ = array();
                    foreach ($unit_ as $key => $value) {
                        $sql2 = "SELECT * FROM t_satker WHERE kdunit='$value'";
                        $result2 = mysql_query($sql2) or die(mysql_error());
                        //die($sql2);
                        while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                            $kdsatker_[] = $row2['kdsatker'];
                        }
                    }
                    $this->db->where_in('d.kdsatker', $kdsatker_);
                } else {
                    $sql2 = "SELECT * FROM t_satker WHERE kdunit='$unit'";
                    $result2 = mysql_query($sql2) or die(mysql_error());
                    $kdsatker_ = array();
                    while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                        $kdsatker_[] = $row2['kdsatker'];
                    }
                    $this->db->where_in('d.kdsatker', $kdsatker_);
                }
            }
            if ($ret['type'] == "propinsi" || $ret['type'] == "biasa") {
                $satker_ = $ret['satker'];
                $kdsatker_ = array();
                if ($unit == "0") {
                    foreach ($satker_ as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $kdsatker_[] = $value2;
                        }
                    }
                } else {
                    foreach ($satker_[$unit] as $key => $value) {
                        $kdsatker_[] = $value;
                    }
                }
                $this->db->where_in('d.kdsatker', $kdsatker_);
            }
        }

        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('*');
        $this->db->from('t_giat d');
        $this->db->join('t_output output', 'output.kdgiat = d.kdgiat AND output.kdoutput = d.kdoutput', 'left');
        $this->db->join('t_satker satker', 'satker.kdsatker=d.kdsatker', 'inner');
        if($this->session->userdata('kd_role') == '4')
        {
            $this->db->join($this->db->database.'.ref_satker', $this->db->database.'.ref_satker.kdsatker = d.kdsatker');
            $this->db->where($this->db->database.'.ref_satker.kdinduk', $this->session->userdata('kdinduk'));
        }
        $this->db->where('d.thang', $tahun);

        if ($unit != "0") {
            $this->db->where('d.kdunit', $unit);
        } else {
            if ($ret['type'] != "roren") {
                $unit_ = $ret['unit'];
                $this->db->where_in('d.kdunit', $unit_);
            }
        }

        if ($satker != "0") {
            $this->db->where('d.kdsatker', $satker);
        } else {
            if ($ret['type'] == "roren") {
                
            }
            if ($ret['type'] == "unit") {
                if ($unit == "0") {
                    $unit_ = $ret['unit'];
                    $kdsatker_ = array();
                    foreach ($unit_ as $key => $value) {
                        $sql2 = "SELECT * FROM t_satker WHERE kdunit='$value'";
                        $result2 = mysql_query($sql2) or die(mysql_error());
                        //die($sql2);
                        while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                            $kdsatker_[] = $row2['kdsatker'];
                        }
                    }
                    $this->db->where_in('d.kdsatker', $kdsatker_);
                } else {
                    $sql2 = "SELECT * FROM t_satker WHERE kdunit='$unit'";
                    $result2 = mysql_query($sql2) or die(mysql_error());
                    $kdsatker_ = array();
                    while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                        $kdsatker_[] = $row2['kdsatker'];
                    }
                    $this->db->where_in('d.kdsatker', $kdsatker_);
                }
            }
            if ($ret['type'] == "propinsi" || $ret['type'] == "biasa") {
                $satker_ = $ret['satker'];
                $kdsatker_ = array();
                if ($unit == "0") {
                    foreach ($satker_ as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $kdsatker_[] = $value2;
                        }
                    }
                } else {
                    foreach ($satker_[$unit] as $key => $value) {
                        $kdsatker_[] = $value;
                    }
                }
                $this->db->where_in('d.kdsatker', $kdsatker_);
            }
        }
        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }

    function get_view_data_output($tahun, $unit, $satker) {
        $records = $this->get_view_db_output($tahun, $unit, $satker);
        $dataView = array();
        foreach ($records['records']->result() as $row) {
            $kdskmpnen_ = $row->kdskmpnen;
            $kdskmpnen = str_replace(' ', '', $kdskmpnen_);

            $key = $row->thang . "-" . $row->kdsatker . "-" . $row->kdunit . "-" . $row->kdprogram . "-" . $row->kdgiat . "-" . $row->kdoutput . "-" . $row->kdsoutput . "-" . $row->kdkmpnen . "-" . $kdskmpnen . "-" . $row->kdjendok . "-" . $row->kddekon;
            $dataView[$key][] = $row->urkmpnen;
            $dataView[$key][] = $row->urskmpnen;
            $dataView[$key][] = $row->nmsatker;

            $sql = "SELECT fokus_prioritas, ikk, fokus_prioritas_utama, reformasi_kesehatan_utama, reformasi_kesehatan FROM d_ikk_fokus WHERE thang='$tahun' AND kdsatker='$row->kdsatker'
                    AND kdunit='$row->kdunit' AND kdprogram='$row->kdprogram' AND kdgiat='$row->kdgiat' AND kdoutput='$row->kdoutput'
                    AND kdsoutput='$row->kdsoutput' AND kdkmpnen='$row->kdkmpnen' AND kdskmpnen LIKE '$kdskmpnen'
                    AND kdjendok='$row->kdjendok' AND kddekon='$row->kddekon'";
            //$dataView[$key][] = $sql;
            $result2 = mysql_query($sql) or die(mysql_error());
            if (mysql_num_rows($result2) > 0) {
                $dataView[$key][] = 1;
            } else {
                $dataView[$key][] = 0;
            }
            $sts_komponen = $this->get_feedback_status($key);
            $dataView[$key][] = $sts_komponen;
        }
        $query['records'] = $dataView;
        $query['record_count'] = $records['record_count'];
        //die (var_dump($dataView));
        return $query;
    }

    function get_view_data_db($tahun, $unit, $satker) {
        $this->db->select('d.thang, d.kdsatker, d.kdunit, d.kdprogram, d.kdgiat, d.kdoutput, d.kdsoutput, d.kdkmpnen, skomponen.kdskmpnen, d.kdjendok, d.kddekon, d.urkmpnen, skomponen.urskmpnen, satker.nmsatker');
        $this->db->from('d_kmpnen d');
        $this->db->join('d_skmpnen skomponen', 'skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kddept = d.kddept AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdlokasi = d.kdlokasi AND skomponen.kdkabkota = d.kdkabkota AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdjendok = d.kdjendok  AND skomponen.kddekon = d.kddekon', 'left');
        $this->db->join('t_satker satker', 'satker.kdsatker=d.kdsatker', 'inner');
        if($this->session->userdata('kd_role') == '4')
        {
            $this->db->join($this->db->database.'.ref_satker', $this->db->database.'.ref_satker.kdsatker = d.kdsatker');
            $this->db->where($this->db->database.'.ref_satker.kdinduk', $this->session->userdata('kdinduk'));
        }
        $this->db->where('d.thang', $tahun);

        if ($satker != "0") {
            $this->db->where('d.kdsatker', $satker);
        }

        $ret = $this->check_authorized_satker_unit();

        if ($unit != "0") {
            $this->db->where('d.kdunit', $unit);
        } else {
            if ($ret['type'] != "roren") {
                $unit_ = $ret['unit'];
                $this->db->where_in('d.kdunit', $unit_);
            }
        }

        if ($satker != "0") {
            $this->db->where('d.kdsatker', $satker);
        } else {
            if ($ret['type'] == "roren") {
                
            }
            if ($ret['type'] == "unit") {
                if ($unit == "0") {
                    $unit_ = $ret['unit'];
                    $kdsatker_ = array();
                    foreach ($unit_ as $key => $value) {
                        $sql2 = "SELECT * FROM t_satker WHERE kdunit='$value'";
                        $result2 = mysql_query($sql2) or die(mysql_error());
                        //die($sql2);
                        while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                            $kdsatker_[] = $row2['kdsatker'];
                        }
                    }
                    $this->db->where_in('d.kdsatker', $kdsatker_);
                } else {
                    $sql2 = "SELECT * FROM t_satker WHERE kdunit='$unit'";
                    $result2 = mysql_query($sql2) or die(mysql_error());
                    $kdsatker_ = array();
                    while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                        $kdsatker_[] = $row2['kdsatker'];
                    }
                    $this->db->where_in('d.kdsatker', $kdsatker_);
                }
            }
            if ($ret['type'] == "propinsi" || $ret['type'] == "biasa") {
                $satker_ = $ret['satker'];
                $kdsatker_ = array();
                if ($unit == "0") {
                    foreach ($satker_ as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $kdsatker_[] = $value2;
                        }
                    }
                } else {
                    foreach ($satker_[$unit] as $key => $value) {
                        $kdsatker_[] = $value;
                    }
                }
                $this->db->where_in('d.kdsatker', $kdsatker_);
            }
        }

        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('d.thang, d.kdsatker, d.kdunit, d.kdprogram, d.kdgiat, d.kdoutput, d.kdsoutput, d.kdkmpnen, skomponen.kdskmpnen, d.kdjendok, d.kddekon, d.urkmpnen, skomponen.urskmpnen, satker.nmsatker');
        $this->db->from('d_kmpnen d');
        $this->db->join('d_skmpnen skomponen', 'skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kddept = d.kddept AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdlokasi = d.kdlokasi AND skomponen.kdkabkota = d.kdkabkota AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdjendok = d.kdjendok  AND skomponen.kddekon = d.kddekon', 'left');
        $this->db->join('t_satker satker', 'satker.kdsatker=d.kdsatker', 'inner');
        if($this->session->userdata('kd_role') == '4')
        {
            $this->db->join($this->db->database.'.ref_satker', $this->db->database.'.ref_satker.kdsatker = d.kdsatker');
            $this->db->where($this->db->database.'.ref_satker.kdinduk', $this->session->userdata('kdinduk'));
        }
        $this->db->where('d.thang', $tahun);

        if ($unit != "0") {
            $this->db->where('d.kdunit', $unit);
        } else {
            if ($ret['type'] != "roren") {
                $unit_ = $ret['unit'];
                $this->db->where_in('d.kdunit', $unit_);
            }
        }

        if ($satker != "0") {
            $this->db->where('d.kdsatker', $satker);
        } else {
            if ($ret['type'] == "roren") {
                
            }
            if ($ret['type'] == "unit") {
                if ($unit == "0") {
                    $unit_ = $ret['unit'];
                    $kdsatker_ = array();
                    foreach ($unit_ as $key => $value) {
                        $sql2 = "SELECT * FROM t_satker WHERE kdunit='$value'";
                        $result2 = mysql_query($sql2) or die(mysql_error());
                        //die($sql2);
                        while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                            $kdsatker_[] = $row2['kdsatker'];
                        }
                    }
                    $this->db->where_in('d.kdsatker', $kdsatker_);
                } else {
                    $sql2 = "SELECT * FROM t_satker WHERE kdunit='$unit'";
                    $result2 = mysql_query($sql2) or die(mysql_error());
                    $kdsatker_ = array();
                    while ($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
                        $kdsatker_[] = $row2['kdsatker'];
                    }
                    $this->db->where_in('d.kdsatker', $kdsatker_);
                }
            }
            if ($ret['type'] == "propinsi" || $ret['type'] == "biasa") {
                $satker_ = $ret['satker'];
                $kdsatker_ = array();
                if ($unit == "0") {
                    foreach ($satker_ as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $kdsatker_[] = $value2;
                        }
                    }
                } else {
                    foreach ($satker_[$unit] as $key => $value) {
                        $kdsatker_[] = $value;
                    }
                }
                $this->db->where_in('d.kdsatker', $kdsatker_);
            }
        }
        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }

    function get_view_data($tahun, $unit, $satker) {
        $records = $this->get_view_data_db($tahun, $unit, $satker);
        $dataView = array();
        foreach ($records['records']->result() as $row) {
            $kdskmpnen_ = $row->kdskmpnen;
            $kdskmpnen = str_replace(' ', '', $kdskmpnen_);

            $key = $row->thang . "-" . $row->kdsatker . "-" . $row->kdunit . "-" . $row->kdprogram . "-" . $row->kdgiat . "-" . $row->kdoutput . "-" . $row->kdsoutput . "-" . $row->kdkmpnen . "-" . $kdskmpnen . "-" . $row->kdjendok . "-" . $row->kddekon;
            $dataView[$key][] = $row->urkmpnen;
            $dataView[$key][] = $row->urskmpnen;
            $dataView[$key][] = $row->nmsatker;

            $sql = "SELECT fokus_prioritas, ikk, fokus_prioritas_utama, reformasi_kesehatan_utama, reformasi_kesehatan FROM d_ikk_fokus WHERE thang='$tahun' AND kdsatker='$row->kdsatker'
                    AND kdunit='$row->kdunit' AND kdprogram='$row->kdprogram' AND kdgiat='$row->kdgiat' AND kdoutput='$row->kdoutput'
                    AND kdsoutput='$row->kdsoutput' AND kdkmpnen='$row->kdkmpnen' AND kdskmpnen LIKE '$kdskmpnen'
                    AND kdjendok='$row->kdjendok' AND kddekon='$row->kddekon'";
            //$dataView[$key][] = $sql;
            $result2 = mysql_query($sql) or die(mysql_error());
            if (mysql_num_rows($result2) > 0) {
                $dataView[$key][] = 1;
            } else {
                $dataView[$key][] = 0;
            }
            $sts_komponen = $this->get_feedback_status($key);
            $dataView[$key][] = $sts_komponen;
        }
        $query['records'] = $dataView;
        $query['record_count'] = $records['record_count'];
        //die (var_dump($dataView));
        return $query;
    }

    function check_encoding($string) {
        if (preg_match('%^(?:
            [\x09\x0A\x0D\x20-\x7E]            
            | [\xC2-\xDF][\x80-\xBF]             
            | \xE0[\xA0-\xBF][\x80-\xBF]         
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  
            | \xED[\x80-\x9F][\x80-\xBF]         
            | \xF0[\x90-\xBF][\x80-\xBF]{2}      
            | [\xF1-\xF3][\x80-\xBF]{3}         
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      
        )*$%xs', $string)) {
            
        } else {
            $string = iconv('CP1252', 'utf-8//IGNORE', $string);
        }
        return $string;
    }

    function import_d_item($target_path, $id) {
        rename($target_path . "d_item.keu", $target_path . "D_ITEM.KEU");
        $dbfname = $target_path . "D_ITEM.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        $satker_already_deleted = array();
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO d_item VALUES (";
            $count = 1;
            $break = 0;
            $tahun_deleted = "";
            $satker_deleted = "";
            foreach ($record as $key => $value) {
                $value = trim($value);
                // cari kode satker dan tahun
                if ($count == 1) {
                    $tahun_deleted = $value;
                }
                if ($count == 3) {
                    $satker_deleted = $value;
                    if (!in_array($tahun_deleted . "-" . $satker_deleted, $satker_already_deleted)) {
                        $sql_deleted = "DELETE FROM d_item WHERE thang='$tahun_deleted' AND kdsatker='$satker_deleted'";
                        mysql_query($sql_deleted);
                        $this->insert_import_detail($id, $satker_deleted, $tahun_deleted);
                        $satker_already_deleted[] = $tahun_deleted . "-" . $satker_deleted;
                    }
                }
                if ($count == 39) {
                    break;
                }
                if ($count == 4) {
                    if ($value != "024") {
                        $break = 1;
                        break;
                    }
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = $this->check_encoding($sql);
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $result = mysql_query($sql);
            if (!$result) {
                if (mysql_errno() != 1062) {
                    die(mysql_error() . "=>" . $sql);
                }
            }
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_d_kmpnen($target_path) {
        rename($target_path . "d_kmpnen.keu", $target_path . "D_KMPNEN.KEU");
        $dbfname = $target_path . "D_KMPNEN.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        $satker_already_deleted = array();
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO d_kmpnen VALUES (";
            $count = 1;
            $break = 0;
            $tahun_deleted = "";
            $satker_deleted = "";
            foreach ($record as $key => $value) {
                $value = trim($value);
                // cari kode satker dan tahun
                if ($count == 1) {
                    $tahun_deleted = $value;
                }
                if ($count == 3) {
                    $satker_deleted = $value;
                    if (!in_array($tahun_deleted . "-" . $satker_deleted, $satker_already_deleted)) {
                        $sql_deleted = "DELETE FROM d_kmpnen WHERE thang='$tahun_deleted' AND kdsatker='$satker_deleted'";
                        mysql_query($sql_deleted);

                        $satker_already_deleted[] = $tahun_deleted . "-" . $satker_deleted;
                    }
                }
                if ($count == 17) {
                    break;
                }
                if ($count == 4) {
                    if ($value != "024") {
                        $break = 1;
                        break;
                    }
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql = $this->check_encoding($sql);
            $result = mysql_query($sql);
            if (!$result) {
                if (mysql_errno() != 1062) {
                    die(mysql_error() . "=>" . $sql);
                }
            }
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_d_skmpnen($target_path) {
        rename($target_path . "d_skmpnen.keu", $target_path . "D_SKMPNEN.KEU");
        $dbfname = $target_path . "D_SKMPNEN.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        $satker_already_deleted = array();
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO d_skmpnen VALUES (";
            $count = 1;
            $break = 0;
            $tahun_deleted = "";
            $satker_deleted = "";
            foreach ($record as $key => $value) {
                $value = trim($value);
                // cari kode satker dan tahun
                if ($count == 1) {
                    $tahun_deleted = $value;
                }
                if ($count == 3) {
                    $satker_deleted = $value;
                    if (!in_array($tahun_deleted . "-" . $satker_deleted, $satker_already_deleted)) {
                        $sql_deleted = "DELETE FROM d_skmpnen WHERE thang='$tahun_deleted' AND kdsatker='$satker_deleted'";
                        mysql_query($sql_deleted);

                        $satker_already_deleted[] = $tahun_deleted . "-" . $satker_deleted;
                    }
                }
                if ($count == 16) {
                    break;
                }
                if ($count == 4) {
                    if ($value != "024") {
                        $break = 1;
                        break;
                    }
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql = $this->check_encoding($sql);
            $result = mysql_query($sql);
            if (!$result) {
                if (mysql_errno() != 1062) {
                    die(mysql_error() . "=>" . $sql);
                }
            }
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_d_soutput($target_path) {
        rename($target_path . "d_soutput.keu", $target_path . "D_SOUTPUT.KEU");
        $dbfname = $target_path . "D_SOUTPUT.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        $satker_already_deleted = array();
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO d_soutput VALUES (";
            $count = 1;
            $break = 0;
            $tahun_deleted = "";
            $satker_deleted = "";
            foreach ($record as $key => $value) {
                $value = trim($value);
                // cari kode satker dan tahun
                if ($count == 1) {
                    $tahun_deleted = $value;
                }
                if ($count == 3) {
                    $satker_deleted = $value;
                    if (!in_array($tahun_deleted . "-" . $satker_deleted, $satker_already_deleted)) {
                        $sql_deleted = "DELETE FROM d_soutput WHERE thang='$tahun_deleted' AND kdsatker='$satker_deleted'";
                        mysql_query($sql_deleted);

                        $satker_already_deleted[] = $tahun_deleted . "-" . $satker_deleted;
                    }
                }
                if ($count == 14) {
                    break;
                }
                if ($count == 4) {
                    if ($value != "024") {
                        $break = 1;
                        break;
                    }
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql = $this->check_encoding($sql);
            $result = mysql_query($sql);
            if (!$result) {
                if (mysql_errno() != 1062) {
                    die(mysql_error() . "=>" . $sql);
                }
            }
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_t_akun($target_path) {
        rename($target_path . "t_akun.keu", $target_path . "T_AKUN.KEU");
        $dbfname = $target_path . "T_AKUN.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO t_akun VALUES (";
            $count = 1;
            $key1 = "";
            foreach ($record as $key => $value) {
                if ($count == 1) {
                    $key1 = $value;
                }
                if ($count == 3) {
                    break;
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            //$this->db->query($sql);
            $sql = $this->check_encoding($sql);
            $sql_del = "DELETE FROM t_akun WHERE kdakun='$key1'";
            mysql_query($sql_del) or die(mysql_error() . "=>" . $sql_del);
            mysql_query($sql) or die(mysql_error() . "=>" . $sql);
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_t_giat($target_path) {
        rename($target_path . "t_giat.keu", $target_path . "T_GIAT.KEU");
        $dbfname = $target_path . "T_GIAT.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO t_giat VALUES (";
            $count = 1;
            $break = 0;
            $key1 = "";
            $key3 = "";
            $key4 = "";
            $key5 = "";
            foreach ($record as $key => $value) {
                if ($count == 1) {
                    $key1 = $value;
                }
                if ($count == 4) {
                    $key4 = $value;
                }
                if ($count == 5) {
                    $key5 = $value;
                }
                if ($count == 6) {
                    break;
                }
                if ($count == 3) {
                    $key3 = $value;
                    if ($value != "024") {
                        $break = 1;
                        break;
                    }
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql_del = "DELETE FROM t_giat WHERE kdgiat='$key1' AND kddept='$key3' AND kdunit='$key4' AND kdprogram='$key5'";
            mysql_query($sql_del) or die(mysql_error() . "=>" . $sql_del);
            mysql_query($sql) or die(mysql_error() . "=>" . $sql);
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_t_output($target_path) {
        rename($target_path . "t_output.keu", $target_path . "T_OUTPUT.KEU");
        $dbfname = $target_path . "T_OUTPUT.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO t_output VALUES (";
            $count = 1;
            $break = 0;
            $key1 = "";
            $key2 = "";
            foreach ($record as $key => $value) {
                if ($count == 4) {
                    break;
                }
                if ($count == 1) {
                    $key1 = $value;
                    $kdgiat = $value;
                    $sql2 = "SELECT * FROM t_giat WHERE kdgiat='$kdgiat'";
                    $result = mysql_query($sql2) or die($sql2);
                    if (mysql_num_rows($result) == 0) {
                        $break = 1;
                        break;
                    }
                }
                if ($count == 2) {
                    $key2 = $value;
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql_del = "DELETE FROM t_output WHERE kdgiat='$key1' AND kdoutput='$key2'";
            mysql_query($sql_del) or die(mysql_error() . "=>" . $sql_del);
            mysql_query($sql) or die(mysql_error() . "=>" . $sql);
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_t_program($target_path) {
        rename($target_path . "t_program.keu", $target_path . "T_PROGRAM.KEU");
        $dbfname = $target_path . "T_PROGRAM.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO t_program VALUES (";
            $count = 1;
            $break = 0;
            $key1 = "";
            $key2 = "";
            $key3 = "";
            foreach ($record as $key => $value) {
                if ($count == 5) {
                    break;
                }
                if ($count == 1) {
                    if ($value != "024") {
                        $break = 1;
                        break;
                    }
                    $key1 = $value;
                }
                if ($count == 2) {
                    $key2 = $value;
                }
                if ($count == 3) {
                    $key3 = $value;
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql_del = "DELETE FROM t_program WHERE kddept='$key1' AND kdunit='$key2' AND kdprogram='$key3'";
            mysql_query($sql_del) or die(mysql_error() . "=>" . $sql_del);
            mysql_query($sql) or die(mysql_error() . "=>" . $sql);
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_t_satker($target_path) {
        rename($target_path . "t_satker.keu", $target_path . "T_SATKER.KEU");
        $dbfname = $target_path . "T_SATKER.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO t_satker VALUES (";
            $count = 1;
            $break = 0;
            $key1 = "";
            foreach ($record as $key => $value) {
                if ($count == 11) {
                    break;
                }
                if ($count == 4) {
                    if ($value != "024") {
                        $break = 1;
                        break;
                    }
                }
                if ($count == 1) {
                    $key1 = $value;
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql_del = "DELETE FROM t_satker WHERE kdsatker='$key1'";
            mysql_query($sql_del) or die(mysql_error() . "=>" . $sql_del);
            mysql_query($sql) or die(mysql_error() . "=>" . $sql);
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_t_unit($target_path) {
        rename($target_path . "t_unit.keu", $target_path . "T_UNIT.KEU");
        $dbfname = $target_path . "T_UNIT.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO t_unit VALUES (";
            $count = 1;
            $key1 = "";
            $key2 = "";
            $break = 0;
            foreach ($record as $key => $value) {
                if ($count == 4) {
                    break;
                }
                if ($count == 1) {
                    if ($value != "024") {
                        $break = 1;
                        break;
                    }
                    $key1 = $value;
                }
                if ($count == 2) {
                    $key2 = $value;
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            if ($break == 1) {
                continue;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql_del = "DELETE FROM t_unit WHERE kddept='$key1' AND kdunit='$key2'";
            mysql_query($sql_del) or die(mysql_error() . "=>" . $sql_del);
            mysql_query($sql) or die(mysql_error() . "=>" . $sql);
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function import_t_lokasi($target_path) {
        rename($target_path . "t_lokasi.keu", $target_path . "T_LOKASI.KEU");
        $dbfname = $target_path . "T_LOKASI.KEU";
        $fdbf = fopen($dbfname, 'r');
        $fields = array();
        $buf = fread($fdbf, 32);
        $header = unpack("VRecordCount/vFirstRecord/vRecordLength", substr($buf, 4, 8));
        //echo 'Header: '.json_encode($header).'<br/>';
        $goon = true;
        $unpackString = '';
        while ($goon && !feof($fdbf)) { // read fields:
            $buf = fread($fdbf, 32);
            if (substr($buf, 0, 1) == chr(13)) {
                $goon = false;
            } // end of field list
            else {
                $field = unpack("a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf, 0, 18));
                //echo 'Field: '.json_encode($field).'<br/>';
                $unpackString.="A$field[fieldlen]$field[fieldname]/";
                array_push($fields, $field);
            }
        }
        fseek($fdbf, $header['FirstRecord'] + 1); // move back to the start of the first record (after the field definitions)
        $record = "";
        for ($i = 1; $i <= $header['RecordCount']; $i++) {
            $buf = fread($fdbf, $header['RecordLength']);
            $record = unpack($unpackString, $buf);
            $sql = "INSERT INTO t_lokasi VALUES (";
            $count = 1;
            $key1 = "";
            foreach ($record as $key => $value) {
                if ($count == 3) {
                    break;
                }
                if ($count == 1) {
                    $key1 = $value;
                }
                $value = $this->db->escape($value);
                $sql = $sql . "$value,";
                $count++;
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql . ")";
            //echo $sql;
            $sql_del = "DELETE FROM t_lokasi WHERE kdlokasi='$key1'";
            mysql_query($sql_del) or die(mysql_error() . "=>" . $sql_del);
            mysql_query($sql) or die(mysql_error() . "=>" . $sql);
            //echo 'record: '.json_encode($record).'<br/>';
            //echo $i.$buf.'<br/>';
        } //raw record
        fclose($fdbf);
        return $record;
    }

    function get_history($tahun) {
        $this->db->select('h.id as id, h.pk_date as sdate, u.username as user_operate, u.kdsatker as kdsatker_operate, s2.nmsatker as nmsatker_operate, h.version as version, h.description as description');
        $this->db->from('d_history_import h');
        $this->db->join('users u', 'u.user_id=h.userid', 'left');
        $this->db->join('t_satker s2', 'u.kdsatker=s2.kdsatker', 'left');
        $this->db->where('h.thang', $tahun);

        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('h.id as id, h.pk_date as sdate, u.username as user_operate, u.kdsatker as kdsatker_operate, s2.nmsatker as nmsatker_operate, h.version as version, h.description as description');
        $this->db->from('d_history_import h');
        $this->db->join('users u', 'u.user_id=h.userid', 'left');
        $this->db->join('t_satker s2', 'u.kdsatker=s2.kdsatker', 'left');
        $this->db->where('h.thang', $tahun);

        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }
    
    function get_history_version_desc($id) {
        $sql = "select h.pk_date as sdate, u.username as user_operate, u.kdsatker as kdsatker_operate, s2.nmsatker as nmsatker_operate, h.version as version, h.description as description from d_history_import h left join users u on (u.user_id=h.userid) left join t_satker s2 on (u.kdsatker=s2.kdsatker) where h.id=$id";
        $result = mysql_query($sql) or die(mysql_error());
        $dataView = array();
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $dataView['sdate'] = $row['sdate'];
            $dataView['user_operate'] = $row['user_operate'];
            $dataView['kdsatker_operate'] = $row['kdsatker_operate'];
            $dataView['nmsatker_operate'] = $row['nmsatker_operate'];
            $dataView['version'] = $row['version'];
            $dataView['description'] = $row['description'];
        }
        return $dataView;
    }
    
    function get_histroy_detail($id) {
        $this->db->select('d.id_import as id, d.kd_satker as kdsatker, s.nmsatker as nmsatker');
        $this->db->from('d_history_import_detail d');
        $this->db->join('t_satker s', 's.kdsatker=d.kd_satker', 'left');
        $this->db->where('d.id_import', $id);

        $this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();

        $this->db->select('d.id_import as id, d.kd_satker as kdsatker, s.nmsatker as nmsatker');
        $this->db->from('d_history_import_detail d');
        $this->db->join('t_satker s', 's.kdsatker=d.kd_satker', 'left');
        $this->db->where('d.id_import', $id);

        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
    }
    
    function select_max_history_id() {
        $sql = "select max(id) as maxid from d_history_import";
        $result = mysql_query($sql) or die(mysql_error());
        $maxid = 0;
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $maxid = $row['maxid'];
        }
        return $maxid;
    }
    
    function insert_import($id, $date, $userid, $version, $description, $thang) {
        $sql = "INSERT INTO d_history_import VALUES ('$date', $userid, '$version', '$description', $id, '$thang')";
        mysql_query($sql) or die(mysql_error() . "=>" . $sql);
    }
    
    function insert_import_detail($id, $kdsatker, $thang) {
        $sql = "INSERT INTO d_history_import_detail VALUES ($id, '$kdsatker', '$thang')";
        mysql_query($sql) or die(mysql_error() . "=>" . $sql);
    }
    
    function delete_table($thang) {
        $sql = "DELETE FROM d_item WHERE thang='$thang'";
        $result = mysql_query($sql) or die ($sql);
        $sql = "DELETE FROM d_kmpnen WHERE thang='$thang'";
        $result = mysql_query($sql) or die ($sql);
        $sql = "DELETE FROM d_skmpnen WHERE thang='$thang'";
        $result = mysql_query($sql) or die ($sql);
        $sql = "DELETE FROM d_soutput WHERE thang='$thang'";
        $result = mysql_query($sql) or die ($sql);
    }
}

?>

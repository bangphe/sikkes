<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_graphics
 *
 * @author bren
 */
class model_graphics extends CI_Model {

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

    function wrap_sql($sql, $unit, $satker, $ret) {
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
        return $sql;
    }

    function get_graphics_data_normal($unit, $satker, $tahun, $type) {
        $nmsatker = "";
        if ($satker != "0") {
            $nmsatker = $this->get_nama_satker($satker);
        }
        $ret = $this->check_authorized_satker_unit();
        $total_unit = array();
        $total_unit_fix = array();
        $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit where unit.kdunit=d.kdunit and d.thang='$tahun' ";
        $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        $sql = $sql . " group by d.kdunit";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $total_unit[$row['nmunit']] = $row['jumlah'];
            $total_unit_fix[$row['nmunit']] = $row['jumlah'];
        }

        $grafik_belanja = array();

        $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit where unit.kdunit=d.kdunit and d.thang='$tahun' ";
        $sql = $this->wrap_sql($sql, $unit, $satker, $ret);

        $condition = array();
        $condition_color = array();
        if ($type == "0") {
            $condition['pegawai'] = " and d.kdakun LIKE '51%' ";
            $condition['barang'] = " and d.kdakun LIKE '52%' ";
            $condition['modal'] = " and d.kdakun LIKE '53%' ";
            $condition['bansos'] = " and d.kdakun LIKE '57%' ";

            $condition_color['pegawai'] = "FF0000";
            $condition_color['barang'] = "00FF00";
            $condition_color['modal'] = "0000FF";
            $condition_color['bansos'] = "FFFF00";
        }

        if ($type == "2") {
            $condition['RM'] = " and d.kdbeban = 'A' and d.kdjnsban = '0' ";
            $condition['L.COST-RMP'] = " and d.kdbeban = 'C' and d.kdjnsban = '0' ";
            $condition['PNBP'] = " and d.kdbeban = 'D' and d.kdjnsban = '0' ";
            $condition['PDN'] = " and d.kdbeban = 'E' and d.kdjnsban = '0' ";
            $condition['BLU'] = " and d.kdbeban = 'F' and d.kdjnsban = '0' ";
            $condition['STM'] = " and d.kdbeban = 'G' and d.kdjnsban = '0' ";
            $condition['HDN'] = " and d.kdbeban = 'H' and d.kdjnsban = '0' ";
            $condition['PINJ. VALAS'] = " and d.kdbeban = 'B' and d.kdjnsban = '1' ";
            $condition['RPLN'] = " and d.kdbeban = 'B' and d.kdjnsban = '2' ";
            $condition['HIBAH VALAS'] = " and d.kdbeban = 'I' and d.kdjnsban = '3' ";
            $condition['HIBAH RHLN'] = " and d.kdbeban = 'I' and d.kdjnsban = '4' ";
            $condition['HDN LANGSUNG'] = " and d.kdbeban = 'H' and d.kdjnsban = '6' ";

            $condition_color['RM'] = "C0C0C0";
            $condition_color['L.COST-RMP'] = "808080";
            $condition_color['PNBP'] = "000000";
            $condition_color['PDN'] = "FF0000";
            $condition_color['BLU'] = "800000";
            $condition_color['STM'] = "FFFF00";
            $condition_color['HDN'] = "808000";
            $condition_color['PINJ. VALAS'] = "00FF00";
            $condition_color['RPLN'] = "008000";
            $condition_color['HIBAH VALAS'] = "00FFFF";
            $condition_color['HIBAH RHLN'] = "008080";
            $condition_color['HDN LANGSUNG'] = "0000FF";
        }

        if ($type == "3") {
            $condition['Kantor Pusat'] = " and d.kddekon = '1' ";
            $condition['Kantor Daerah'] = " and d.kddekon = '2' ";
            $condition['Dekonsentrasi'] = " and d.kddekon = '3' ";
            $condition['Tugas Pembantuan'] = " and d.kddekon = '4' ";
            $condition['Urusan Bersama'] = " and d.kddekon = '5' ";
            $condition['Kewenangan Desentralisasi'] = " and d.kddekon = '6' ";

            $condition_color['Kantor Pusat'] = "C0C0C0";
            $condition_color['Kantor Daerah'] = "00FFFF";
            $condition_color['Dekonsentrasi'] = "0000FF";
            $condition_color['Tugas Pembantuan'] = "FF0000";
            $condition_color['Urusan Bersama'] = "800000";
            $condition_color['Kewenangan Desentralisasi'] = "FFFF00";
        }

        foreach ($condition as $key => $value) {
            $sql = $sql . $value;
            $sql = $sql . "  group by d.kdunit order by d.kdunit";

            $result = mysql_query($sql) or die(mysql_error() . " " . $sql);
            //die($sql);
            while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
                $jumlah = $row['jumlah'];
                $nmunit = $row['nmunit'];

                if (!isset($grafik_belanja[$nmunit])) {
                    $tot = number_format($total_unit_fix[$nmunit], 0, ',', ',');
                    $grafik_belanja[$nmunit] = "<graph caption='$nmunit (Total : Rp $tot)' showNames='1'>";
                }
                $persen = ($jumlah * 100 / $total_unit[$nmunit]);
                $persen = number_format($persen, 2, ',', ',');
                //$jumlah = number_format($jumlah, 0, ',', ',');
                $grafik_belanja[$nmunit] = $grafik_belanja[$nmunit] . "<set name='" . $key . " (Rp " . number_format($jumlah, 0, ',', ',') . ")' value='" . $jumlah . "' color='" . $condition_color[$key] . "'/>";
            }
            $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit where unit.kdunit=d.kdunit and d.thang='$tahun' ";
            $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        }
        foreach ($grafik_belanja as $key => $value) {
            $grafik_belanja[$key] = $grafik_belanja[$key] . "</graph>";
        }

        return $grafik_belanja;
    }

    function get_graphics_data_subtract($unit, $satker, $tahun, $type) {
        $nmsatker = "";
        if ($satker != "0") {
            $nmsatker = $this->get_nama_satker($satker);
        }
        $ret = $this->check_authorized_satker_unit();
        $total_unit = array();
        $total_unit_fix = array();
        $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit where unit.kdunit=d.kdunit and d.thang='$tahun' ";
        $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        $sql = $sql . " group by d.kdunit";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $total_unit[$row['nmunit']] = $row['jumlah'];
            $total_unit_fix[$row['nmunit']] = $row['jumlah'];
        }

        $grafik_perjadin = array();

        $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit where unit.kdunit=d.kdunit and d.thang='$tahun' ";
        $sql = $this->wrap_sql($sql, $unit, $satker, $ret);

        $condition = array();
        $condition_color = array();
        if ($type == "1") {
            $condition['perjadin luar negeri'] = " and d.kdakun IN ('524211','524212','524219') ";
            $condition['perjadin dalam negeri'] = " and d.kdakun IN ('524111','524112','524119') ";

            $condition_color['perjadin luar negeri'] = "FF0000";
            $condition_color['perjadin dalam negeri'] = "00FF00";
        }
        foreach ($condition as $key => $value) {
            $sql = $sql . $value;
            $sql = $sql . "  group by d.kdunit order by d.kdunit";
            $result = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
                $jumlah = $row['jumlah'];
                $nmunit = $row['nmunit'];
                $total_unit[$nmunit] = $total_unit[$nmunit] - $jumlah;

                if (!isset($grafik_perjadin[$nmunit])) {
                    $tot = number_format($total_unit_fix[$nmunit], 0, ',', ',');
                    $grafik_perjadin[$nmunit] = "<graph caption='$nmunit (Total : Rp $tot)' showNames='1'>";
                }
                $persen = ($jumlah * 100 / $total_unit_fix[$nmunit]);
                $persen = number_format($persen, 2, ',', ',');
                //$jumlah = number_format($jumlah, 0, ',', ',');
                $grafik_perjadin[$nmunit] = $grafik_perjadin[$nmunit] . "<set name='" . $key . " (Rp " . number_format($jumlah, 0, ',', ',') . ")' value='$jumlah' color='$condition_color[$key]'/>";
            }
            $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit where unit.kdunit=d.kdunit and d.thang='$tahun' ";
            $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        }
        foreach ($grafik_perjadin as $key => $value) {
            $persen = ($total_unit[$key] * 100 / $total_unit_fix[$key]);
            $persen = number_format($persen, 2, ',', ',');
            //$total_unit[$key]= number_format($total_unit[$key], 0, ',', ',');
            $grafik_perjadin[$key] = $grafik_perjadin[$key] . "<set name='" . "lain-lain" . " (Rp " . number_format($jumlah, 0, ',', ',') . ")' value='$total_unit[$key]' color='FFFF00'/>";
            $grafik_perjadin[$key] = $grafik_perjadin[$key] . "</graph>";
        }

        return $grafik_perjadin;
    }

    function get_graphics_data_subtract_fokus_reformasi($unit, $satker, $tahun, $type) {
        $nmsatker = "";
        if ($satker != "0") {
            $nmsatker = $this->get_nama_satker($satker);
        }
        $ret = $this->check_authorized_satker_unit();
        $total_unit = array();
        $total_unit_fix = array();
        $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit where unit.kdunit=d.kdunit and d.thang='$tahun' ";
        $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        $sql = $sql . " group by d.kdunit";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $total_unit[$row['nmunit']] = $row['jumlah'];
            $total_unit_fix[$row['nmunit']] = $row['jumlah'];
        }

        $grafik_perjadin = array();

        $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit, d_ikk_fokus skomponen  where skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdskmpnen = d.kdskmpnen AND skomponen.kddekon = d.kddekon AND unit.kdunit=d.kdunit and d.thang='$tahun' ";
        $sql = $this->wrap_sql($sql, $unit, $satker, $ret);

        $condition = array();
        $condition_color = array();
        if ($type == "5") {
            $condition['Peningkatan kesehatan ibu, bayi, Balita dan Keluarga Berencana (KB)'] = " and (skomponen.fokus_prioritas LIKE '%1%' or skomponen.fokus_prioritas_utama = '1') ";
            $condition['Perbaikan status gizi masyarakat'] = " and (skomponen.fokus_prioritas LIKE '%2%' or skomponen.fokus_prioritas_utama = '2') ";
            $condition['Pengendalian penyakit menular serta penyakit tidakmenular diikuti penyehatan lingkungan'] = " and (skomponen.fokus_prioritas LIKE '%3%' or skomponen.fokus_prioritas_utama = '3') ";
            $condition['Pemenuhan, pengembangan, dan pemberdayaan SDM kesehatan'] = " and (skomponen.fokus_prioritas LIKE '%4%' or skomponen.fokus_prioritas_utama = '4') ";
            $condition['Peningkatan ketersediaan, keterjangkauan, pemerataan, keamanan, mutu dan penggunaan obat serta pengawasan obat dan makanan'] = " and (skomponen.fokus_prioritas LIKE '%5%' or skomponen.fokus_prioritas_utama = '5') ";
            $condition['Pengembangan Sistem Jaminan Kesehatan Masyarakat (Jamkesmas)'] = " and (skomponen.fokus_prioritas LIKE '%6%' or skomponen.fokus_prioritas_utama = '6') ";
            $condition['Pemberdayaan masyarakat dan penanggulangan bencana dan krisis kesehatan'] = " and (skomponen.fokus_prioritas LIKE '%7%' or skomponen.fokus_prioritas_utama = '7') ";
            $condition['Peningkatan pelayanan kesehatan primer, sekunder dan tersier'] = " and (skomponen.fokus_prioritas LIKE '%8%' or skomponen.fokus_prioritas_utama = '8') ";

            $condition_color['Peningkatan kesehatan ibu, bayi, Balita dan Keluarga Berencana (KB)'] = "C0C0C0";
            $condition_color['Perbaikan status gizi masyarakat'] = "000000";
            $condition_color['Pengendalian penyakit menular serta penyakit tidakmenular diikuti penyehatan lingkungan'] = "FF0000";
            $condition_color['Pemenuhan, pengembangan, dan pemberdayaan SDM kesehatan'] = "800000";
            $condition_color['Peningkatan ketersediaan, keterjangkauan, pemerataan, keamanan, mutu dan penggunaan obat serta pengawasan obat dan makanan'] = "FFFF00";
            $condition_color['Pengembangan Sistem Jaminan Kesehatan Masyarakat (Jamkesmas)'] = "00FFFF";
            $condition_color['Pemberdayaan masyarakat dan penanggulangan bencana dan krisis kesehatan'] = "008080";
            $condition_color['Peningkatan pelayanan kesehatan primer, sekunder dan tersier'] = "0000FF";
        }

        if ($type == "6") {
            $condition['Pengembangan Jaminan Kesehatan Masyarakat'] = " and (skomponen.reformasi_kesehatan LIKE '%1%' or skomponen.reformasi_kesehatan_utama = '1') ";
            $condition['Peningkatan pelayanan kesehatan di DTPK'] = " and (skomponen.reformasi_kesehatan LIKE '%2%' or skomponen.reformasi_kesehatan_utama = '2') ";
            $condition['Ketersediaan, keterjangkauan obat diseluruh fasilitas kesehatan'] = " and (skomponen.reformasi_kesehatan LIKE '%3%' or skomponen.reformasi_kesehatan_utama = '3') ";
            $condition['Pelaksanaan reformasi birokrasi'] = " and (skomponen.reformasi_kesehatan LIKE '%4%' or skomponen.reformasi_kesehatan_utama = '4') ";
            $condition['Pemenuhan biaya operasional kesehatan (BOK)'] = " and (skomponen.reformasi_kesehatan LIKE '%5%' or skomponen.reformasi_kesehatan_utama = '5') ";
            $condition['Penanganan daerah bermasalah kesehatan  (PDBK)'] = " and (skomponen.reformasi_kesehatan LIKE '%6%' or skomponen.reformasi_kesehatan_utama = '6') ";
            $condition['Pengembangan pelayanan kesehatan Kelas Internasional (World Class Health Care)'] = " and (skomponen.reformasi_kesehatan LIKE '%7%' or skomponen.reformasi_kesehatan_utama = '7') ";

            $condition_color['Pengembangan Jaminan Kesehatan Masyarakat'] = "C0C0C0";
            $condition_color['Peningkatan pelayanan kesehatan di DTPK'] = "000000";
            $condition_color['Ketersediaan, keterjangkauan obat diseluruh fasilitas kesehatan'] = "FF0000";
            $condition_color['Pelaksanaan reformasi birokrasi'] = "800000";
            $condition_color['Pemenuhan biaya operasional kesehatan (BOK)'] = "FFFF00";
            $condition_color['Penanganan daerah bermasalah kesehatan  (PDBK)'] = "00FFFF";
            $condition_color['Pengembangan pelayanan kesehatan Kelas Internasional (World Class Health Care)'] = "008080";
        }

        foreach ($condition as $key => $value) {
            $sql = $sql . $value;
            $sql = $sql . "  group by d.kdunit order by d.kdunit";
            $result = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
                $jumlah = $row['jumlah'];
                $nmunit = $row['nmunit'];
                $total_unit[$nmunit] = $total_unit[$nmunit] - $jumlah;

                if (!isset($grafik_perjadin[$nmunit])) {
                    $tot = number_format($total_unit_fix[$nmunit], 0, ',', ',');
                    $grafik_perjadin[$nmunit] = "<graph caption='$nmunit (Total : Rp $tot)' showNames='1'>";
                }
                $persen = ($jumlah * 100 / $total_unit_fix[$nmunit]);
                $persen = number_format($persen, 2, ',', ',');
                //$jumlah = number_format($jumlah, 0, ',', ',');
                $grafik_perjadin[$nmunit] = $grafik_perjadin[$nmunit] . "<set name='" . $key . " (Rp " . number_format($jumlah, 0, ',', ',') . ")' value='$jumlah' color='$condition_color[$key]'/>";
            }
            $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit, d_ikk_fokus skomponen  where skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdskmpnen = d.kdskmpnen AND skomponen.kddekon = d.kddekon AND unit.kdunit=d.kdunit and d.thang='$tahun' ";
            $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        }
        foreach ($grafik_perjadin as $key => $value) {
            $persen = ($total_unit[$key] * 100 / $total_unit_fix[$key]);
            $persen = number_format($persen, 2, ',', ',');
            //$total_unit[$key]= number_format($total_unit[$key], 0, ',', ',');
            $grafik_perjadin[$key] = $grafik_perjadin[$key] . "<set name='" . "lain-lain" . " (Rp " . number_format($jumlah, 0, ',', ',') . ")' value='$total_unit[$key]' color='FFFF00'/>";
            $grafik_perjadin[$key] = $grafik_perjadin[$key] . "</graph>";
        }

        return $grafik_perjadin;
    }
    
    function get_graphics_data_subtract_ikk($unit, $satker, $tahun, $type) {
        $sql = "SELECT t.kdgiat, t.kdikk, t.nmikk FROM t_ikk t left join t_giat g on (t.kdgiat=g.kdgiat) where kdunit='01'";
        
        $nmsatker = "";
        if ($satker != "0") {
            $nmsatker = $this->get_nama_satker($satker);
        }
        $ret = $this->check_authorized_satker_unit();
        $total_unit = array();
        $total_unit_fix = array();
        $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit where unit.kdunit=d.kdunit and d.thang='$tahun' ";
        $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        $sql = $sql . " group by d.kdunit";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            $total_unit[$row['nmunit']] = $row['jumlah'];
            $total_unit_fix[$row['nmunit']] = $row['jumlah'];
        }

        $grafik_perjadin = array();

        $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit, d_ikk_fokus skomponen  where skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdskmpnen = d.kdskmpnen AND skomponen.kddekon = d.kddekon AND unit.kdunit=d.kdunit and d.thang='$tahun' ";
        $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        
        $condition = array();
        $condition_color = array();
        $sql_ikk_lst = "";
        if ($type == "7") {
            // get ikk list per unit
            if ($unit == "0") {
                $sql_ikk_lst = "SELECT t.kdgiat, t.kdikk, t.nmikk FROM t_ikk t left join t_giat g on (t.kdgiat=g.kdgiat)";
            }
            else {
                $sql_ikk_lst = "SELECT t.kdgiat, t.kdikk, t.nmikk FROM t_ikk t left join t_giat g on (t.kdgiat=g.kdgiat) where kdunit='$unit'";
            }
            $result_ikk_list = mysql_query($sql_ikk_lst) or die(mysql_error());
            while ($row_ikk_list = mysql_fetch_array($result_ikk_list, MYSQL_BOTH)) {
                $nmikk = $row_ikk_list['nmikk'];
                $kdgiat = $row_ikk_list['kdgiat'];
                $kdikk = $row_ikk_list['kdikk'];
                $condition[$nmikk] = " and (skomponen.ikk = '$kdikk' and skomponen.kdgiat = '$kdgiat') ";
                $condition_color[$nmikk] = "C0C0C0";
            }
        }
        
        //die (var_dump($condition));

        foreach ($condition as $key => $value) {
            $sql = $sql . $value;
            $sql = $sql . "  group by d.kdunit order by d.kdunit";
            //die(var_dump($sql));
            $result = mysql_query($sql) or die(mysql_error());
            while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
//                die(var_dump($row));
                $jumlah = $row['jumlah'];
                $nmunit = $row['nmunit'];
                $total_unit[$nmunit] = $total_unit[$nmunit] - $jumlah;

                if (!isset($grafik_perjadin[$nmunit])) {
                    $tot = number_format($total_unit_fix[$nmunit], 0, ',', ',');
                    $grafik_perjadin[$nmunit] = "<graph caption='$nmunit (Total : Rp $tot)' showNames='1'>";
                }
                $persen = ($jumlah * 100 / $total_unit_fix[$nmunit]);
                $persen = number_format($persen, 2, ',', ',');
                //$jumlah = number_format($jumlah, 0, ',', ',');
                $grafik_perjadin[$nmunit] = $grafik_perjadin[$nmunit] . "<set name='" . $key . " (Rp " . number_format($jumlah, 0, ',', ',') . ")' value='$jumlah' color='$condition_color[$key]'/>";
            }
            $sql = "select sum(d.jumlah) as jumlah, unit.nmunit as nmunit from d_item d, t_unit unit, d_ikk_fokus skomponen  where skomponen.thang = d.thang AND skomponen.kdsatker = d.kdsatker AND skomponen.kdunit = d.kdunit AND skomponen.kdprogram = d.kdprogram AND skomponen.kdgiat = d.kdgiat AND skomponen.kdoutput = d.kdoutput AND skomponen.kdsoutput = d.kdsoutput AND skomponen.kdkmpnen = d.kdkmpnen AND skomponen.kdskmpnen = d.kdskmpnen AND skomponen.kddekon = d.kddekon AND unit.kdunit=d.kdunit and d.thang='$tahun' ";
            $sql = $this->wrap_sql($sql, $unit, $satker, $ret);
        }
        foreach ($grafik_perjadin as $key => $value) {
            $persen = ($total_unit[$key] * 100 / $total_unit_fix[$key]);
            $persen = number_format($persen, 2, ',', ',');
            //$total_unit[$key]= number_format($total_unit[$key], 0, ',', ',');
            $grafik_perjadin[$key] = $grafik_perjadin[$key] . "<set name='" . "lain-lain" . " (Rp " . number_format($jumlah, 0, ',', ',') . ")' value='$total_unit[$key]' color='FFFF00'/>";
            $grafik_perjadin[$key] = $grafik_perjadin[$key] . "</graph>";
        }
        
//        die (var_dump($grafik_perjadin));
        return $grafik_perjadin;
    }

    function get_graphics_data($unit, $satker, $tahun, $type) {
        if ($type == "0" || $type == "2" || $type == "3") {
            return $this->get_graphics_data_normal($unit, $satker, $tahun, $type);
        }
        if ($type == "1") {
            return $this->get_graphics_data_subtract($unit, $satker, $tahun, $type);
        }
        if ($type == "5" || $type == "6") {
            return $this->get_graphics_data_subtract_fokus_reformasi($unit, $satker, $tahun, $type);
        }
        if ($type == "7") {
            return $this->get_graphics_data_subtract_ikk($unit, $satker, $tahun, $type);
        }
    }

    function get_nama_satker($kdsatker) {
        $sql = "SELECT nmsatker FROM t_satker t WHERE kdsatker='$kdsatker'";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
            return $row['nmsatker'];
        }
    }
}

?>

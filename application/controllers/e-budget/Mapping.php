<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mapping
 *
 * @author bren
 */
class mapping extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('flexigrid');
        $this->load->helper('flexigrid');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('e-budget/model_ebudget', 'mm');
    }

    function grid_komponen($kdunit_back, $kdsatker_back, $page) {
        $kdunit = $this->input->post('unit');
        $kdsatker = $this->input->post('satker');
        
        if ((!$kdunit || !$kdsatker) && $kdsatker_back!=-1 && $kdunit_back!=-1) {
            $kdunit = $kdunit_back;
            $kdsatker = $kdsatker_back;
        }

        $colModel['NO'] = array('NO', 20, TRUE, 'center', 0);
        $colModel['d.urkmpnen'] = array('KOMPONEN', 300, FALSE, 'left', 1);
        $colModel['skomponen.urskmpnen'] = array('SUBKOMPONEN', 300, FALSE, 'left', 1);
        $colModel['satker.nmsatker'] = array('SATKER', 300, FALSE, 'left', 1);
        $colModel['MAPPINGOK'] = array('SUDAH DIMAPPING', 100, FALSE, 'left', 0);
        $colModel['MAPPING'] = array('MAPPING', 50, FALSE, 'left', 0);

        //setting konfigurasi pada bottom tool bar flexigrid
        $gridParams = array(
                            'width' => 'auto',
                            'height' => 330,
                            'rp' => 15,
                            'rpOptions' => '[15,30,50,100]',
                            'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
                            'blockOpacity' => 0,
                            'title' => '',
                            'showTableToggleBtn' => false,
                                                        'newp' => $page
                            );

        $url = base_url() . "index.php/e-budget/mapping/grid_list_komponen/$kdunit/$kdsatker";

        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams);
        $data['js_grid'] = $grid_js;
        $data['notification'] = "";
        $data['judul'] = 'Daftar Komponen';
        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }

    function grid_list_komponen($kdunit, $kdsatker) {
        $valid_fields = array('d.urkmpnen','skomponen.urskmpnen','satker.nmsatker');
        $this->flexigrid->validate_post('', 'asc', $valid_fields);
        $this->output->set_header($this->config->item('json_header'));
        $thang =  $this->session->userdata('thn_anggaran');
        $return = $this->mm->get_view_data($thang, $kdunit, $kdsatker);

        $page = $this->flexigrid->post_info['page'];
        $rp = $this->flexigrid->post_info['rp'];
        $count = 0 + ($rp*($page-1));
        $record_items = array();
        foreach ($return['records'] as $key => $row) {
            $count = $count + 1;
            $komponen = $row[0];
            $skomponen = $row[1];
            $satker = $row[2];
            $mappingok = $row[3];
            $mappingmark = "";
            if ($mappingok == 1) {
                $mappingmark = '<a href=\'#\'><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/setujui.png\'></a>';
            }
            
            $url = site_url()."/e-budget/mapping/edit_mapping/$kdunit/$key/$kdsatker/$page";
            $url = str_replace(' ', '', $url);
            
            $record_items[] = array(
                $key,
                $count,
                $komponen,
                $skomponen,
                $satker,
                $mappingmark,
                //$key."T".$url
                '<a href='.$url.'><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/edit.png\'></a>',
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($return['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }

    function form_mapping() {
        $data2 = array();
        $data2['search'] = $this->mm->get_all_unit();
        $data2['judul'] = "Mapping Komponen";
        $script = $this->mm->get_all_satker_script();
        $data['added_js'] = "<script type='text/javascript'>$script</script>";
        $data['content'] = $this->load->view('e-budget/view_mapping', $data2, true);
        $this->load->view('main', $data);
    }

    function edit_mapping($kdunit, $key, $satker, $page) {
        $fokus_prioritas_utama = $this->input->post('fokus_prioritas_utama');
        $fokus_prioritas = $this->input->post('fokus_prioritas');
        $reformasi_kesehatan_utama = $this->input->post('reformasi_kesehatan_utama');
        $reformasi_kesehatan = $this->input->post('reformasi_kesehatan');
        $ikk = $this->input->post('ikk');
        $ret = 0;
        if ($ikk && $reformasi_kesehatan_utama && $fokus_prioritas_utama) {
            $ret = $this->mm->save_fokus_prioritas($key, $fokus_prioritas, $ikk, $fokus_prioritas_utama, $reformasi_kesehatan, $reformasi_kesehatan_utama);
        }
        
        $data2 = array();
        
        $fokus_ikk = $this->mm->get_fokus_prioritas_ikk($key);

        //die (var_dump($fokus_ikk));
        
        $selected_fokus_prioritas = $fokus_ikk[0];
        $selected_fokus_prioritas_utama = $fokus_ikk[1];
        $selected_reformasi_kesehatan = $fokus_ikk[2];
        $selected_reformasi_kesehatan_utama = $fokus_ikk[3];
        $selected_ikk = $fokus_ikk[4];

        $allfokus = $this->mm->get_all_fokus_prioritas();
        $allreformasi = $this->mm->get_all_reformasi_kesehatan();
        $giats = explode("-", $key);
        $allikk = $this->mm->get_all_ikk($giats[4]);
        $thang =  $this->session->userdata('thn_anggaran');
        $view = $this->mm->get_data($thang, $kdunit, $key);
        
        $dataComplete = $view[0];
        $temp = count($dataComplete);
        if ($temp > 0) {
            $data = $dataComplete[$key];
            $datas = explode("-;-", $data);
            $unit = $datas[0];
            $program = $datas[1];
            $kegiatan = $datas[2];
            $output = $datas[3];
            $suboutput = $datas[4];
            $komponen = $datas[5];
            $subkomponen = $datas[6];

            $dataAkun = $view[1][$key];
            $data2['dataAkun'] = $dataAkun;
            
            $data2['fokus_ikk'] = $fokus_ikk;
            
            $data2['selected_fokus_prioritas'] = $selected_fokus_prioritas;
            $data2['selected_fokus_prioritas_utama'] = $selected_fokus_prioritas_utama;
            $data2['selected_reformasi_kesehatan'] = $selected_reformasi_kesehatan;
            $data2['selected_reformasi_kesehatan_utama'] = $selected_reformasi_kesehatan_utama;
            $data2['selected_ikk'] = $selected_ikk;
    //        
            $data2['allfokus'] = $allfokus;
            $data2['allreformasi'] = $allreformasi;
            $data2['allikk'] = $allikk;
            
            $data2['unit'] = $unit;
            $data2['program'] = $program;
            $data2['kegiatan'] = $kegiatan;
            $data2['output'] = $output;
            $data2['suboutput'] = $suboutput;
            $data2['komponen'] = $komponen;
            $data2['subkomponen'] = $subkomponen;
            
            $data2['kdunit'] = $kdunit;
            $data2['kdsatker'] = $satker;
            $data2['key'] = $key;
            $data2['page'] = $page;
            if ($ret == 0) {
                $data2['notification'] = "";
            }
            else {
                $data2['notification'] = "Terjadi Kesalahan <br>Fokus Prioritas Pendukung tidak boleh sama dengan Fokus Prioritas Utama <br>Reformasi Kesehatan Pendukung tidak boleh sama dengan Reformasi Kesehatan Utama";
            }
        }

        else {
            // $dataAkun = $view[1][$key];
            $data2['dataAkun'] = "";
            
            $data2['fokus_ikk'] = $fokus_ikk;
            
            $data2['selected_fokus_prioritas'] = $selected_fokus_prioritas;
            $data2['selected_fokus_prioritas_utama'] = $selected_fokus_prioritas_utama;
            $data2['selected_reformasi_kesehatan'] = $selected_reformasi_kesehatan;
            $data2['selected_reformasi_kesehatan_utama'] = $selected_reformasi_kesehatan_utama;
            $data2['selected_ikk'] = $selected_ikk;
    //        
            $data2['allfokus'] = $allfokus;
            $data2['allreformasi'] = $allreformasi;
            $data2['allikk'] = $allikk;
            
            $data2['unit'] = '-';
            $data2['program'] = '-';
            $data2['kegiatan'] = '-';
            $data2['output'] = '-';
            $data2['suboutput'] = '-';
            $data2['komponen'] = '-';
            $data2['subkomponen'] = '-';
            
            $data2['kdunit'] = $kdunit;
            $data2['kdsatker'] = $satker;
            $data2['key'] = $key;
            $data2['page'] = $page;
            if ($ret == 0) {
                $data2['notification'] = "";
            }
            else {
                $data2['notification'] = "Terjadi Kesalahan <br>Fokus Prioritas Pendukung tidak boleh sama dengan Fokus Prioritas Utama <br>Reformasi Kesehatan Pendukung tidak boleh sama dengan Reformasi Kesehatan Utama";
            }
        }
        
        $data = array();
        $data['content'] = $this->load->view('e-budget/view_mapping_edit', $data2, true);
        //die (var_dump( $data['content']));
        $this->load->view('main', $data);
    }
}

?>

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
class feedback extends CI_Controller {

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

        //$this->grid_list_komponen($kdunit, $kdsatker);
        
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 0);
        $colModel['KOMPONEN'] = array('KOMPONEN', 300, FALSE, 'left', 1);
        $colModel['SUBKOMPONEN'] = array('SUBKOMPONEN', 300, FALSE, 'left', 1);
        $colModel['SATKER'] = array('SATKER', 300, FALSE, 'left', 1);
        $colModel['STATUS'] = array('STATUS', 130, FALSE, 'left', 1);
        $colModel['FEEDBACK'] = array('FEEDBACK', 50, FALSE, 'left', 1);

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
	
        $url = base_url() . "index.php/e-budget/feedback/grid_list_komponen/$kdunit/$kdsatker";

        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams);
        $data['js_grid'] = $grid_js;
        $data['notification'] = "";
        $data['judul'] = 'Feedback - Daftar Komponen';
        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }

    function grid_list_komponen($kdunit, $kdsatker) {
        $valid_fields = array('');
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
            
            $sts_komponen = $row[4];
            $sts = "";
            if ($sts_komponen == "2") {
                $sts = "ADA JAWABAN";
            }
            if ($sts_komponen == "1") {
                $sts = "FEEDBACK BARU";
            }
            if ($sts_komponen == "0") {
                $sts = "TIDAK ADA FEEDBACK";
            }
            
            $url = site_url()."/e-budget/feedback/edit_mapping/$kdunit/$key/$kdsatker/$page";
            $url = str_replace(' ', '', $url);
            
            $record_items[] = array(
                $key,
                $count,
                $komponen,
                $skomponen,
                $satker,
                $sts,
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
        $script = $this->mm->get_all_satker_script();
        $data['added_js'] = "<script type='text/javascript'>$script</script>";
        $data2['judul'] = "Feedback";
        $data['content'] = $this->load->view('e-budget/view_feedback', $data2, true);
        $this->load->view('main', $data);
    }

    function edit_mapping($kdunit, $key, $satker, $page) {
        $thang =  $this->session->userdata('thn_anggaran');
        $view = $this->mm->get_data($thang, $kdunit, $key);
        
        $dataComplete = $view[0];
        $data = $dataComplete[$key];
        $datas = explode("-;-", $data);
        $unit = $datas[0];
        $program = $datas[1];
        $kegiatan = $datas[2];
        $output = $datas[3];
        $suboutput = $datas[4];
        $komponen = $datas[5];
        $subkomponen = $datas[6];
        $sts = $datas[7];

        $dataAkun = $view[1][$key];
        $data2['dataAkun'] = $dataAkun;

        
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
        $data2['notification'] = '';
        $data2['sts'] = $sts;
        $data = array();
        $data['content'] = $this->load->view('e-budget/view_feedback_edit', $data2, true);
        //die (var_dump( $data['content']));
        $this->load->view('main', $data);
    }
    
    function feedback_edit($kdunit, $satker, $page, $key_back, $key) {
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['SATKER_SRC'] = array('SATKER ASAL', 150, FALSE, 'left', 1);
        $colModel['SATKER_DEST'] = array('SATKER TUJUAN', 150, FALSE, 'left', 1);
        $colModel['FEEDBACK'] = array('FEEDBACK', 600, FALSE, 'left', 1);
        $colModel['STATUS'] = array('STATUS', 130, FALSE, 'left', 1);
        $colModel['TANGGAL'] = array('TANGGAL', 70, FALSE, 'left', 1);
        $colModel['CREATOR'] = array('PEMBUAT', 150, FALSE, 'left', 1);

        //setting konfigurasi pada bottom tool bar flexigrid
        $gridParams = array(
            'width' => 'auto',
            'height' => 330,
            'rp' => 15,
            'rpOptions' => '[15,30,50,100]',
            'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
            'blockOpacity' => 0,
            'title' => '',
            'showTableToggleBtn' => false
        );

        $sts = $this->mm->get_feedback_status($key);
        $tombol = "";
        if ($sts == "2") {
            $tombol = "BERIKAN FEEDBACK BARU";
        }
        if ($sts == "1") {
            $tombol = "BERIKAN JAWABAN";
        }
        if ($sts == "0") {
            $tombol = "BERIKAN FEEDBACK";
        }
       
        // mengambil data dari file controler ajax pada method grid_user		
        $url = base_url() . "index.php/e-budget/feedback/grid_list_feedback/$key";
        $data['added_js'] = 
        "<script type='text/javascript'>
        function spt_js(com,grid){	
                if (com=='$tombol'){
                        location.href= '".base_url()."index.php/e-budget/feedback/add_feedback/$kdunit/$satker/$page/$key_back/$key';    
                }			
        } </script>";

        ////menambah tombol pada flexigrid top toolbar
        $buttons[] = array($tombol,'add','spt_js');
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        $data['notification'] = "";
        $data['judul'] = 'Daftar Feedback';
        $data['div'] = "<a href='".site_url()."/e-budget/feedback/edit_mapping/$kdunit/$key_back/$satker/$page'> <div class=\"buttons\">
                            <button type=\"button\" class=\"regular\" name=\"submit\">
                                <img src=\"".base_url()."images/main/back.png\" alt=\"\"/>
                                Kembali
                            </button>
                        </div></a>";          
        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }
    
    function grid_list_feedback($key) {
        $valid_fields = array('id');
        $this->flexigrid->validate_post('id', 'asc', $valid_fields);
        $records = $this->mm->get_feedback($key);

        $count = 0;
        $record_items = array();
        foreach ($records['records']->result() as $row) {
            $count++;
            $sts = "";
            if ($row->sts == "2") {
                $sts = "ADA JAWABAN";
            }
            if ($row->sts == "1") {
                $sts = "FEEDBACK BARU";
            }
            if ($row->sts == "0") {
                $sts = "TIDAK ADA FEEDBACK";
            }
            $record_items[] = array(
                $row->id,
                $count,
                $row->satkersrc,
                $row->satkerdest,
                $row->feedback,
                $sts,
                $row->thang,
                $row->creator
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }
    
    function add_feedback($kdunit, $satker, $page, $key_back, $key) {
        $sts = $this->mm->get_feedback_status($key);
        $tombol = "";
        if ($sts == "2") {
            $judul = "Feedback Baru";
            $label = "Feedback";
        }
        if ($sts == "1") {
            $judul = "Jawaban Feedback";
            $label = "Jawaban";
        }
        if ($sts == "0") {
            $judul = "Feedback";
            $label = "Feedback";
        }       
        
        $data2['kdunit'] = $kdunit;
        $data2['satker'] = $satker;
        $data2['key'] = $key;
        $data2['key_back'] = $key_back;
        $data2['page'] = $page;
        $data2['judul'] = $judul;
        $data2['label'] = $label;
        $data2['error'] = '';
        $data = array();
        $data['content'] = $this->load->view('e-budget/view_add_feedback', $data2, true);
        //die (var_dump( $data['content']));
        $this->load->view('main', $data);
    }
    
    function add_feedback_action($kdunit, $satker, $page, $key_back, $key) {
        $sts = $this->mm->get_feedback_status($key);
        $newsts = "";
        if ($sts == "2") {
            $newsts = 1;
        }
        if ($sts == "1") {
            $newsts = 2;
        }
        if ($sts == "0") {
            $newsts = 1;
        } 
        
        $feedback_text = $this->input->post('feedback_text');
        $keys = explode("-", $key);
        $kdsatker = $keys[1];
        $this->mm->add_feedback($kdsatker, $key, $feedback_text, $newsts);
        redirect('/e-budget/feedback/feedback_edit/'.$kdunit.'/'.$satker.'/'.$page.'/'.$key_back.'/'.$key);
    }
}

?>

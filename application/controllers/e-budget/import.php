<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of import
 *
 * @author bren
 */
class import extends CI_Controller {

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

    function delete_dir($dirPath) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException('$dirPath must be a directory');
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    function index(){
        $valid_fields = array('h.id');
        $this->flexigrid->validate_post('h.id', 'asc', $valid_fields);
        $this->form_import($this->flexigrid->post_info['page']);
    }
    function form_import($page) {
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['TANGGAL'] = array('TANGGAL', 120, FALSE, 'left', 1);
        $colModel['NMOPERATOR'] = array('NAMA OPERATOR', 120, FALSE, 'left', 1);
        $colModel['KDSATKEROPERATOR'] = array('KODE SATKER OPERATOR', 120, FALSE, 'left', 1);
        $colModel['NMSATKEROPERATOR'] = array('NAMA SATKER OPERATOR', 160, FALSE, 'left', 1);
        $colModel['VERSION'] = array('VERSION', 120, FALSE, 'left', 1);
        //$colModel['DESCRIPTION'] = array('KETERANGAN', 120, FALSE, 'left', 1);
        $colModel['DETAIL'] = array('DETAIL', 50, FALSE, 'left', 1);
        
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
        // mengambil data dari file controler ajax pada method grid_user        
        $url = base_url() . "index.php/e-budget/import/grid_form_import";
        
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, "");
        $data2 = array();
        $data2['js_grid'] = $grid_js;
        $data2['notification'] = "";
        $data2['judul'] = 'History Import';
        $kdsatker =  $this->session->userdata('kdsatker');
        $data2['super'] = "0";
        if ($kdsatker == "465915") {
            $data2['super'] = "1";
        }
        $data['content'] = $this->load->view('e-budget/view_import', $data2, true);
        $this->load->view('main', $data);
    }
    
    function grid_form_import() {
        $valid_fields = array('h.id');
        $this->flexigrid->validate_post('h.id', 'asc', $valid_fields);
        $thang =  $this->session->userdata('thn_anggaran');
        $records = $this->mm->get_history($thang);

        $page = $this->flexigrid->post_info['page'];
        $rp = $this->flexigrid->post_info['rp'];
        $count = 0 + ($rp*($page-1));
        $record_items = array();
        foreach ($records['records']->result() as $row) {
            $count++;
            $id = $row->id;
            $url = site_url()."/e-budget/import/detailimport/$id/$page";
            $record_items[] = array(
                $row->id,
                $count,
                $row->sdate,
                $row->user_operate,
                $row->kdsatker_operate,
                $row->nmsatker_operate,
                $row->version,
                //$row->description,
                '<a href='.$url.'><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/edit.png\'></a>'
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }
    
    function detailimport($id, $page) {
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['KODESATKER'] = array('KODE SATKER', 120, FALSE, 'left', 1);
        $colModel['NAMASATKER'] = array('NAMA SATKER', 120, FALSE, 'left', 1);
        
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
        // mengambil data dari file controler ajax pada method grid_user        
        $url = base_url() . "index.php/e-budget/import/grid_detailimport/$id";
        
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, "");
        $data2 = $this->mm->get_history_version_desc($id);
        $data2['js_grid'] = $grid_js;
        $data2['notification'] = "";
        $data2['judul'] = 'Daftar satker yang diimport';
        $data2['div'] = "<a href='".site_url()."/e-budget/import/form_import/$page'> <div class=\"buttons\">
                    <button type=\"button\" class=\"regular\" name=\"submit\">
                        <img src=\"".base_url()."images/main/back.png\" alt=\"\"/>
                        Kembali
                    </button>
                </div></a>";
        $data['content'] = $this->load->view('e-budget/view_import_detail', $data2, true);
        $this->load->view('main', $data);
    }
    
    function grid_detailimport($id) {
        $valid_fields = array('d.id_import');
        $this->flexigrid->validate_post('d.id_import', 'asc', $valid_fields);
        
        $records = $this->mm->get_histroy_detail($id);

        $page = $this->flexigrid->post_info['page'];
        $rp = $this->flexigrid->post_info['rp'];
        $count = 0 + ($rp*($page-1));
        $record_items = array();
        foreach ($records['records']->result() as $row) {
            $count++;
            $id = $row->id;
            $kdsatker = $row->kdsatker;
            $nmsatker = $row->nmsatker;
            $record_items[] = array(
                $id.$kdsatker,
                $count,
                $kdsatker,
                $nmsatker
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }

    function import_action() {
        ini_set("max_execution_time","1200");
        ini_set("max_input_time","1200");
        ini_set("post_max_size","1500M");
        ini_set("memory_limit","1500M");
        
        $date = new DateTime();
        $rand = "";
        $move_path = "";
        for ($i = 0; $i < 10; $i++) {
            $rand = $rand . rand(0, 9);
        }
        $dir = $rand . $date->format('U');
        $file_name="";
        //$target_path = "D:/Project/htdocs/sikkes/uploads/" . $dir . "/";
        $target_path = "./uploads/".$dir."/";
        //mkdir($target_path);
        // create directory if doesn't exist
        //if(!is_dir($target_path))
        //mkdir($target_path);

        $config['upload_path'] = $target_path;
        $config['allowed_types'] = 'zip';
        $config['max_size'] = '500000000';

        // create directory if doesn't exist
        if(!is_dir($config['upload_path']))
        mkdir($config['upload_path'], 0777);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('zip')) {
            $data_file = $this->upload->data();
            $data2['result'] = '<font color="red"><b>'.$this->upload->display_errors("<p>Error Upload : ", "</p>").$data_file['file_type'].'</b></font>';
            $data['content'] = $this->load->view('e-budget/view_import_result', $data2, true);
            $this->load->view('main', $data);
        } else {
            $uploaddata = $this->upload->data();
            $file_name = $uploaddata['file_name'];
            $move_path = $target_path . $file_name;
            
            $zip = zip_open($move_path);
            if ($zip) {
                while ($zip_entry = zip_read($zip)) {
                    $fp = fopen($target_path . zip_entry_name($zip_entry), "w");
                    if (zip_entry_open($zip, $zip_entry, "r")) {
                        $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                        fwrite($fp, $buf);
                        zip_entry_close($zip_entry);
                        fclose($fp);
                    }
                }
                zip_close($zip);
                
                $maxid = $this->mm->select_max_history_id();
                $maxid = $maxid + 1;
                
                $version = $this->input->post('versi');
                $description = $this->input->post('description');
                $thang =  $this->session->userdata('thn_anggaran');
                $userid =  $this->session->userdata('id_user');
                $this->mm->insert_import($maxid, date("Y-m-d H:i:s"), $userid, $version, $description, $thang);

                $clear = $this->input->post('clear');
                if ($clear == "clear") {
                    $this->mm->delete_table($thang);
                }
                
                // $this->mm->import_d_soutput($target_path);
                // $this->mm->import_d_kmpnen($target_path);
                // $this->mm->import_d_skmpnen($target_path);
                // $this->mm->import_d_item($target_path, $maxid);

                // $this->mm->import_t_unit($target_path);
                // $this->mm->import_t_program($target_path);
                $this->mm->import_t_giat($target_path);
                // $this->mm->import_t_output($target_path);
                // $this->mm->import_t_akun($target_path);
                // $this->mm->import_t_satker($target_path);
                // $this->mm->import_t_lokasi($target_path);
            }  
            $this->delete_dir($target_path);
            $data2['result'] = "Import berhasil";
            $data['content'] = $this->load->view('e-budget/view_import_result', $data2, true);
            $this->load->view('main', $data);
        }
    }
    
    function php_info() {
        die (phpinfo());
    }
}

?>

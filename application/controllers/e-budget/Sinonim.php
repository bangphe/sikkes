<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sinonim
 *
 * @author bren
 */
class sinonim extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('flexigrid');
        $this->load->helper('flexigrid');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('master_data/general_model', 'gm');
        $this->load->model('e-budget/model_sinonim', 'ms');
        $this->load->model('e-budget/model_ebudget', 'mm');
    }

    function index($type) {
        if ($type == "1") {
            $this->grid_sinonim('1');
        }
        else {
            $this->grid_sinonim_negatif('1');
        }
    }
    
    function grid_sinonim($page) {
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['SINONIM'] = array('SINONIM', 400, FALSE, 'left', 1);
        $colModel['AKUN'] = array('AKUN', 70, FALSE, 'left', 1);
        $colModel['KATAKUNCI'] = array('KATA KUNCI', 70, FALSE, 'left', 1);
        $colModel['HAPUS'] = array('HAPUS', 50, FALSE, 'left', 1);

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
        $url = base_url() . "index.php/e-budget/sinonim/grid_list_sinonim/";
        $data['added_js'] = 
        "<script type='text/javascript'>
        function spt_js(com,grid){	
                if (com=='Tambah'){
                        location.href= '".base_url()."index.php/e-budget/sinonim/add_sinonim';    
                }			
        } </script>";
        ////menambah tombol pada flexigrid top toolbar
        $buttons[] = array('Tambah','add','spt_js');
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        $data['notification'] = "";
        $data['judul'] = 'Daftar Sinonim Positif';
        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }
    
    function grid_list_sinonim() {
        $valid_fields = array('id');
        $this->flexigrid->validate_post('id', 'asc', $valid_fields);
        $this->output->set_header($this->config->item('json_header'));

        $records = $this->ms->list_sinonim();

        $page = $this->flexigrid->post_info['page'];
        $rp = $this->flexigrid->post_info['rp'];
        $count = 0 + ($rp*($page-1));
        $record_items = array();
        foreach ($records['records']->result() as $row) {
            $count++;
            $id = $row->id;
            $sinonim = $row->nmsinonim;
            
            $url_akun = site_url()."/e-budget/sinonim/grid_akun/$id/$page";
            $url_katakunci = site_url()."/e-budget/sinonim/grid_katakunci/$id/$page";
            $url_hapus = site_url()."/e-budget/sinonim/delete/$id/$page";
            
            $record_items[] = array(
                $id,
                $count,
                $sinonim,
                '<a href='.$url_akun.'><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/edit.png\'></a>',
                '<a href='.$url_katakunci.'><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/edit.png\'></a>',
                '<a href='.$url_hapus.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }

    function grid_sinonim_negatif($page) {
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['SINONIM'] = array('SINONIM', 400, FALSE, 'left', 1);
        //$colModel['KATAKUNCI'] = array('KATA KUNCI', 70, FALSE, 'left', 1);
        $colModel['HAPUS'] = array('HAPUS', 50, FALSE, 'left', 1);

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
        $url = base_url() . "index.php/e-budget/sinonim/grid_list_sinonim_negatif/";
        $data['added_js'] = 
        "<script type='text/javascript'>
        function spt_js(com,grid){  
                if (com=='Tambah'){
                        location.href= '".base_url()."index.php/e-budget/sinonim/add_sinonim_negatif';    
                }           
        } </script>";
        ////menambah tombol pada flexigrid top toolbar
        $buttons[] = array('Tambah','add','spt_js');
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        $data['notification'] = "";
        $data['judul'] = 'Daftar Sinonim Negatif';
        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }
    
    function grid_list_sinonim_negatif() {
        $valid_fields = array('id');
        $this->flexigrid->validate_post('id', 'asc', $valid_fields);
        $this->output->set_header($this->config->item('json_header'));

        $records = $this->ms->list_sinonim_negatif();

        $page = $this->flexigrid->post_info['page'];
        $rp = $this->flexigrid->post_info['rp'];
        $count = 0 + ($rp*($page-1));
        $record_items = array();
        foreach ($records['records']->result() as $row) {
            $count++;
            $id = $row->id;
            $sinonim = $row->nmsinonim;
            
            //$url_katakunci = site_url()."/e-budget/sinonim/grid_katakunci/$id/$page";
            $url_hapus = site_url()."/e-budget/sinonim/delete_sinonim_negatif/$id/$page";
            
            $record_items[] = array(
                $id,
                $count,
                $sinonim,
                //'<a href='.$url_katakunci.'><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/edit.png\'></a>',
                '<a href='.$url_hapus.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }
    
    function grid_akun($id, $pagesinonim) {
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['AKUN'] = array('AKUN', 400, FALSE, 'left', 1);
        $colModel['HAPUS'] = array('HAPUS', 50, FALSE, 'left', 1);

        $nmsinonim = $this->ms->get_sinonim($id);
        
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
        $url = base_url() . "index.php/e-budget/sinonim/grid_list_akun/$id/$pagesinonim";
        $data['added_js'] = 
        "<script type='text/javascript'>
        function spt_js(com,grid){	
                if (com=='Tambah'){
                        location.href= '".base_url()."index.php/e-budget/sinonim/edit_akun/$id/$pagesinonim';    
                }			
        } </script>";
        ////menambah tombol pada flexigrid top toolbar
        $buttons[] = array('Tambah','add','spt_js');
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        $data['notification'] = "";
        $data['judul'] = 'Daftar Akun Sinonim : '.$nmsinonim;
        $data['div'] = "<a href='".site_url()."/e-budget/sinonim/grid_sinonim/$pagesinonim'> <div class=\"buttons\">
                            <button type=\"button\" class=\"regular\" name=\"submit\">
                                <img src=\"".base_url()."images/main/back.png\" alt=\"\"/>
                                Kembali
                            </button>
                        </div></a>";        
        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }
    
    function grid_list_akun($id, $pagesinonim) {
        $valid_fields = array('id_sinonim','kdakun');
        $this->flexigrid->validate_post('kdakun', 'asc', $valid_fields);
        $records = $this->ms->get_sinonim_akun($id);

        $count = 0;
        $record_items = array();
        foreach ($records['records']->result() as $row) {
            $count++;
            $id = $row->id_sinonim;
            $akun = $row->kdakun;
            $url_hapus = site_url()."/e-budget/sinonim/delete_akun/$id/$akun/$pagesinonim";
            
            $record_items[] = array(
                $id.$akun,
                $count,
                $this->ms->get_nama_akun($akun),
                '<a href='.$url_hapus.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }
    
    function grid_katakunci($id, $pagesinonim) {
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['KATAKUNCI'] = array('KATA KUNCI', 400, FALSE, 'left', 1);
        $colModel['HAPUS'] = array('HAPUS', 50, FALSE, 'left', 1);

        $nmsinonim = $this->ms->get_sinonim($id);
        
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
        $url = base_url() . "index.php/e-budget/sinonim/grid_list_katakunci/$id/$pagesinonim";
        $data['added_js'] = 
        "<script type='text/javascript'>
        function spt_js(com,grid){	
                if (com=='Tambah'){
                        location.href= '".base_url()."index.php/e-budget/sinonim/edit_katakunci/$id/$pagesinonim';    
                }			
        } </script>";
        ////menambah tombol pada flexigrid top toolbar
        $buttons[] = array('Tambah','add','spt_js');
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        $data['notification'] = "";
        $data['judul'] = 'Daftar Kata Kunci Sinonim : '.$nmsinonim;
        $data['div'] = "<a href='".site_url()."/e-budget/sinonim/grid_sinonim/$pagesinonim'> <div class=\"buttons\">
                            <button type=\"button\" class=\"regular\" name=\"submit\">
                                <img src=\"".base_url()."images/main/back.png\" alt=\"\"/>
                                Kembali
                            </button>
                        </div></a>";
        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }
    
    function grid_list_katakunci($id, $pagesinonim) {
        $valid_fields = array('id_sinonim','katakunci');
        $this->flexigrid->validate_post('katakunci', 'asc', $valid_fields);
        $records = $this->ms->get_sinonim_katakunci($id);

        $count = 0;
        $record_items = array();
        foreach ($records['records']->result() as $row) {
            $count++;
            $pk = $row->id;
            $id = $row->id_sinonim;
            $katakunci = $row->katakunci;
            $url_hapus = site_url()."/e-budget/sinonim/delete_katakunci/$id/$pk/$pagesinonim";
            
            $record_items[] = array(
                $katakunci.$id,
                $count,
                $katakunci,
                '<a href='.$url_hapus.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }
    
    function add_sinonim() {
        $data['error'] = "";
        $data['judul'] = 'Tambah Sinonim';
        $data['content'] = $this->load->view('e-budget/view_add_sinonim', $data, true);
        $this->load->view('main', $data);
    }
        
    function add_sinonim_action() {
        $sinonim = $this->input->post('sinonim');
        $sinonim = trim($sinonim);
        
        $ret = $this->ms->add_sinonim($sinonim);
        if ($ret == "0") {
            redirect('/e-budget/sinonim/grid_sinonim/1');
        }
        else {
            $data['error'] = "Nama sinonim sudah terpakai";
            $data['judul'] = 'TAMBAH SINONIM';
            $data['content'] = $this->load->view('e-budget/view_add_sinonim', $data, true);
            $this->load->view('main', $data);
        }
    }

    function add_sinonim_negatif() {
        $data['error'] = "";
        $data['judul'] = 'Tambah Sinonim';
        $data['content'] = $this->load->view('e-budget/view_add_sinonim_negatif', $data, true);
        $this->load->view('main', $data);
    }
        
    function add_sinonim_negatif_action() {
        $sinonim = $this->input->post('sinonim');
        $sinonim = trim($sinonim);
        
        $ret = $this->ms->add_sinonim_negatif($sinonim);
        if ($ret == "0") {
            redirect('/e-budget/sinonim/grid_sinonim_negatif/1');
        }
        else {
            $data['error'] = "Nama sinonim sudah terpakai";
            $data['judul'] = 'TAMBAH SINONIM NEGATIF';
            $data['content'] = $this->load->view('e-budget/view_add_sinonim_negatif', $data, true);
            $this->load->view('main', $data);
        }
    }
    
    function delete($id, $page) {
        $ret = $this->ms->delete_sinonim($id);
        redirect('/e-budget/sinonim/grid_sinonim/1');
    }

    function delete_sinonim_negatif($id, $page) {
        $ret = $this->ms->delete_sinonim_negatif($id);
        redirect('/e-budget/sinonim/grid_sinonim_negatif/1');
    }
    
    public function edit_akun($id, $pagesinonim) {
        $nmsinonim = $this->ms->get_sinonim($id);
        $script = $this->mm->get_all_akun_script();
        $data['added_js'] = 
        "<script type='text/javascript'>$script</script>";
        $data['judul'] = 'Tambah Akun Sinonim';
        $data['nmsinonim'] = $nmsinonim;
        $data['error'] = "";
        $data['id'] = $id;
        $data['pagesinonim'] = $pagesinonim;
        $data['content'] = $this->load->view('e-budget/view_edit_akun_sinonim', $data, true);
        $this->load->view('main', $data);
    }
    
    public function edit_akun_action($id, $pagesinonim) {
        $akun = $this->input->post('akun');
        //die (var_dump($akun));
        $this->ms->add_sinonim_akun($id, $akun);
        redirect('/e-budget/sinonim/grid_akun/'.$id.'/'.$pagesinonim);
    }
    
    public function edit_katakunci($id, $pagesinonim) {
        $nmsinonim = $this->ms->get_sinonim($id);
        $data['judul'] = 'Tambah Kata Kunci Sinonim';
        $data['nmsinonim'] = $nmsinonim;
        $data['error'] = '';
        $data['id'] = $id;
        $data['pagesinonim'] = $pagesinonim;
        $data['content'] = $this->load->view('e-budget/view_edit_katakunci_sinonim', $data, true);
        $this->load->view('main', $data);
    }
    
    public function edit_katakunci_action($id, $pagesinonim) {
        $katakunci = $this->input->post('katakunci');
        $this->ms->add_sinonim_katakunci($id, $katakunci);
        redirect('/e-budget/sinonim/grid_katakunci/'.$id.'/'.$pagesinonim);
    }
    
    public function delete_akun($id, $akun, $pagesinonim) {
        $this->ms->delete_sinonim_akun($id, $akun);
        redirect('/e-budget/sinonim/grid_akun/'.$id.'/'.$pagesinonim);
    }
    
    public function delete_katakunci($id, $idkatakunci, $pagesinonim) {
        $this->ms->delete_sinonim_katakunci($idkatakunci);
        redirect('/e-budget/sinonim/grid_katakunci/'.$id.'/'.$pagesinonim);
    }
}

?>

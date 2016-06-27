<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of akungroup
 *
 * @author bren
 */
class akungroup extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('flexigrid');
        $this->load->helper('flexigrid');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('master_data/general_model', 'gm');
        $this->load->model('e-budget/model_akungroup', 'ms');
        $this->load->model('e-budget/model_ebudget', 'mm');
    }

    function grid_akungroup($page) {        
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['AKUNGROUP'] = array('AKUN GROUP', 400, FALSE, 'left', 1);
        $colModel['AKUN'] = array('AKUN', 70, FALSE, 'left', 1);
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
        $url = base_url() . "index.php/e-budget/akungroup/grid_list_akungroup";
        $data['notification'] = "";
        $data['added_js'] =
                "<script type='text/javascript'>
        function spt_js(com,grid){	
                if (com=='Tambah'){
                        location.href= '" . base_url() . "index.php/e-budget/akungroup/add_akungroup';    
                }			
        } </script>";
        ////menambah tombol pada flexigrid top toolbar
        $buttons[] = array('Tambah', 'add', 'spt_js');
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        $data['judul'] = 'Daftar Akun Group';

        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }

    function grid_list_akungroup() {
        $kdsatker = $this->session->userdata('kdsatker');
        $valid_fields = array('id');
        $this->flexigrid->validate_post('id', 'asc', $valid_fields);
        $records = $this->ms->list_akungroup();

        $this->output->set_header($this->config->item('json_header'));

        $page = $this->flexigrid->post_info['page'];
        $rp = $this->flexigrid->post_info['rp'];
        $count = 0 + ($rp*($page-1));
        foreach ($records['records']->result() as $row) {
            $count++;
            $id = $row->id;
            $akungroup = $row->nmakungroup;
            $url_akun = site_url() . "/e-budget/akungroup/grid_akun/$id/$page";
            $url_hapus = site_url() . "/e-budget/akungroup/delete/$id/$page";

            $record_items[] = array(
                $row->id,
                $count,
                $akungroup,
                '<a href=' . $url_akun . '><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/edit.png\'></a>',
                '<a href=' . $url_hapus . ' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/hapus.png\'></a>'
            );
        }
        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }

    function add_akungroup() {
        $data['error'] = "";
        $data['judul'] = 'TAMBAH AKUN GROUP';
        $data['content'] = $this->load->view('e-budget/view_add_akungroup', $data, true);
        $this->load->view('main', $data);
    }

    function add_akungroup_action() {
        $akungroup = $this->input->post('akungroup');
        $akungroup = trim($akungroup);

        $ret = $this->ms->add_akungroup($akungroup);
        if ($ret == "0") {
            redirect('/e-budget/akungroup/grid_akungroup/1');
        } else {
            $data['error'] = "Nama akun group sudah terpakai";
            $data['judul'] = 'Tambah Akun Group';
            $data['content'] = $this->load->view('e-budget/view_add_akungroup', $data, true);
            $this->load->view('main', $data);
        }
    }

    function delete($id, $page) {
        $ret = $this->ms->delete_akungroup($id);
        redirect('/e-budget/akungroup/grid_akungroup/1');
    }

    function grid_akun($id, $page) {
        $colModel['NO'] = array('NO', 20, TRUE, 'center', 1);
        $colModel['AKUN'] = array('AKUN', 400, FALSE, 'left', 1);
        $colModel['HAPUS'] = array('HAPUS', 50, FALSE, 'left', 1);

        $nmakungroup = $this->ms->get_akungroup($id);

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
        $url = base_url() . "index.php/e-budget/akungroup/grid_list_akun/$id/$page";
        $data['added_js'] =
                "<script type='text/javascript'>
        function spt_js(com,grid){	
                if (com=='Tambah'){
                        location.href= '" . base_url() . "index.php/e-budget/akungroup/edit_akun/$id/$page';    
                }			
        } </script>";
        ////menambah tombol pada flexigrid top toolbar
        $buttons[] = array('Tambah', 'add', 'spt_js');
        $grid_js = build_grid_js('user', $url, $colModel, 'NO', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        $data['notification'] = "";
        $data['div'] = "<a href='".site_url()."/e-budget/akungroup/grid_akungroup/$page'> <div class=\"buttons\">
                            <button type=\"button\" class=\"regular\" name=\"submit\">
                                <img src=\"".base_url()."images/main/back.png\" alt=\"\"/>
                                Kembali
                            </button>
                        </div></a>";  
        $data['judul'] = 'Akun : ' . $nmakungroup;
        $data['content'] = $this->load->view('grid', $data, true);
        $this->load->view('main', $data);
    }

    function grid_list_akun($id, $page) {
        $valid_fields = array('id_akungroup','kdakun');
        $this->flexigrid->validate_post('kdakun', 'asc', $valid_fields);
        $records = $this->ms->get_akungroup_akun($id);

        $count = 0;
        $record_items = array();
        foreach ($records['records']->result() as $row) {
            $count++;
            $id = $row->id_akungroup;
            $akun = $row->kdakun;

            $url_hapus = site_url() . "/e-budget/akungroup/delete_akun/$id/$akun/$page";

            $record_items[] = array(
                $id.$akun,
                $count,
                $this->ms->get_nama_akun($akun),
                '<a href=' . $url_hapus . ' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/hapus.png\'></a>'
            );
        }

        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }

    public function edit_akun($id, $page) {
        $nmakungroup = $this->ms->get_akungroup($id);
        $script = $this->mm->get_all_akun_script();
        $data['added_js'] =
                "<script type='text/javascript'>$script</script>";
        $data['judul'] = 'Tambah Akun';
        $data['nmakungroup'] = $nmakungroup;
        $data['error'] = "";
        $data['id'] = $id;
        $data['page'] = $page;
        $data['content'] = $this->load->view('e-budget/view_edit_akun_akungroup', $data, true);
        $this->load->view('main', $data);
    }

    public function edit_akun_action($id, $page) {
        $akun = $this->input->post('akun');
        //die (var_dump($akun));
        $this->ms->add_akungroup_akun($id, $akun);
        redirect('/e-budget/akungroup/grid_akun/' . $id.'/'.$page);
    }

    public function delete_akun($id, $akun, $page) {
        $this->ms->delete_akungroup_akun($id, $akun);
        redirect('/e-budget/akungroup/grid_akun/' . $id.'/'.$page);
    }

}

?>

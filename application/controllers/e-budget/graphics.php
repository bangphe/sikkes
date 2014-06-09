<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of graphics
 *
 * @author bren
 */
class graphics extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('flexigrid');
        $this->load->helper('flexigrid');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('e-budget/model_ebudget', 'mm');
        $this->load->model('e-budget/model_graphics', 'mg');
        $this->load->model('master_data/general_model', 'gm');
    }
    
    function form_graphics() {
        $data2 = array();
        $data2['search'] = $this->mm->get_all_unit_complete();
        $script = $this->mm->get_all_satker_script();
        $data['added_js'] = "<script type='text/javascript'>$script</script>";
        $data['content'] = $this->load->view('e-budget/view_graphics', $data2, true);
        $this->load->view('main', $data);
    }
    
    function show() {
        $kdunit = $this->input->post('unit');
        $records = $this->gm->get_where('t_unit', 'kdunit', $kdunit);
        $nmunit = "";
        foreach ($records->result() as $row) {
            $nmunit = $row->nmunit;
        }
        if ($kdunit == "0") {
            $nmunit = "SEMUA UNIT";
        }
        $kdsatker = $this->input->post('satker');
        $records = $this->gm->get_where('t_satker', 'kdsatker', $kdsatker);
        $nmsatker = "";
        foreach ($records->result() as $row) {
            $nmsatker = $row->nmsatker;
        }
        if ($kdsatker == "0") {
            $nmsatker = "SEMUA SATKER";
        }
        $type = $this->input->post('type');
        
        $types = array();
        $types[] = "Grafik Per Jenis Belanja";
        $types[] = "Grafik Per Jenis Perjalanan Dinas";
        $types[] = "Grafik Per Sumber Pembiayaan";
        $types[] = "Grafik Per Jenis Kewenangan";
        $types[] = "Grafik Per Program";
        $types[] = "Grafik Per Fokus Prioritas";
        $types[] = "Grafik Per Reformasi Kesehatan";
        $types[] = "Grafik Per Ikk";
        $nmtype = $types[$type];

        $ret = $this->mg->get_graphics_data($kdunit, $kdsatker, '2013', $type);
        $data2['chart'] = $ret;
        $data2['nmunit'] = $nmunit;
        $data2['nmsatker'] = $nmsatker;
        $data2['nmtype'] = $nmtype;
        $data['content'] = $this->load->view('e-budget/view_show_graphics', $data2, true);
        $this->load->view('main', $data);
    }
}

?>

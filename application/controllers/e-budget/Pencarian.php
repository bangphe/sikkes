<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pencarian
 *
 * @author bren
 */
class pencarian extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('flexigrid');
        $this->load->helper('flexigrid');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('e-budget/model_ebudget', 'mm');
        $this->load->model('e-budget/model_sinonim', 'ms');
        $this->load->model('e-budget/model_akungroup', 'ma');
    }

    function form_pencarian($type) {
        $units = $this->mm->get_all_unit_complete();
        $lokasis = $this->mm->get_all_location();
        $programs = $this->mm->get_all_program();
        $bebans = $this->mm->get_all_beban();
        $jenissats = $this->mm->get_all_dekon();
        $reformasi_kesehatans = $this->mm->get_all_reformasi_kesehatan();
        $fokus_prioritass = $this->mm->get_all_fokus_prioritas();

        $data['units'] = $units;
        $data['lokasis'] = $lokasis;
        $data['programs'] = $programs;
        $data['bebans'] = $bebans;
        $data['jenissats'] = $jenissats;
        $data['reformasi_kesehatans'] = $reformasi_kesehatans;
        $data['fokus_prioritass'] = $fokus_prioritass;

        $script = $this->mm->get_all_satker_script();
        $script = $script . $this->mm->get_all_akun_script();
        $script = $script . $this->mm->get_all_program_script();
        $script = $script . $this->mm->get_all_kegiatan_script();
        $script = $script . $this->mm->get_all_ikk_script();

        $data['added_js'] = "<script type='text/javascript'>$script</script>";
        $data['judul'] = 'PENCARIAN';
        $data['type'] = $type;
        $data['content'] = $this->load->view('e-budget/view_pencarian', $data, true);
        $this->load->view('main', $data);
    }

    function result_pencarian($type) {
        ini_set("max_execution_time","1200");
        ini_set("max_input_time","1200");
        ini_set("post_max_size","1500M");
        ini_set("memory_limit","1500M");
        
        $unit = $this->input->post('unit');
        $satker = $this->input->post('satker');
        $belanja = $this->input->post('belanja');
        $lokasi = $this->input->post('lokasi');
        $program = $this->input->post('program');
        $kegiatan = $this->input->post('kegiatan');
        $akun = $this->input->post('akun');
        $beban = $this->input->post('beban');
        $jenissat = $this->input->post('jenissat');
        $ikk = $this->input->post('ikk');
        $reformasi_kesehatan = $this->input->post('reformasi_kesehatan');
        $fokus_prioritas = $this->input->post('fokus_prioritas');
        $thang =  $this->session->userdata('thn_anggaran');
        $view = $this->mm->get_belanja_data($thang, $unit, $satker, $belanja, $lokasi, $program, $kegiatan, $akun, $beban, $jenissat, $ikk, $reformasi_kesehatan, $fokus_prioritas);
        $data['judul'] = 'HASIL PENCARIAN';
        $data['view'] = $view;
        if ($type == "0") {
            $data['content'] = $this->load->view('e-budget/view_hasil_pencarian', $data, true);
            $this->load->view('main', $data);
        }
        else {
            $this->load->view('e-budget/view_hasil_pencarian_excel', $data);
        }
    }
    
    function form_pencarian_canggih($type) {        
        $units = array();
        if ($type == "1" || $type == "3") {
            $units = $this->mm->get_all_unit_complete();
        }
        else {
            $units = $this->mm->get_all_unit();
        }
        $lokasis = $this->mm->get_all_location();
        $programs = $this->mm->get_all_program();
        $bebans = $this->mm->get_all_beban();
        $jenissats = $this->mm->get_all_dekon();
        $reformasi_kesehatans = $this->mm->get_all_reformasi_kesehatan();
        $fokus_prioritass = $this->mm->get_all_fokus_prioritas();        
        $sinonim_negatifs = $this->mm->get_all_sinonim_negatif();

        $sinonims = $this->ms->list_sinonim_pencarian();
        $sinonim_negatif = $this->ms->list_sinonim_negatif_pencarian();
        $akungroups = $this->ma->list_akungroup_pencarian();

        $data['units'] = $units;
        $data['lokasis'] = $lokasis;
        $data['programs'] = $programs;
        $data['bebans'] = $bebans;
        $data['jenissats'] = $jenissats;
        $data['sinonims'] = $sinonims;
        $data['sinonim_negatifs'] = $sinonim_negatifs;
        $data['sinonim_negatif'] = $sinonim_negatif;
        $data['akungroups'] = $akungroups;

        $data['reformasi_kesehatans'] = $reformasi_kesehatans;
        $data['fokus_prioritass'] = $fokus_prioritass;

        $script = $this->mm->get_all_satker_script();
        $script = $script . $this->mm->get_all_kegiatan_script();
        $script = $script . $this->mm->get_all_program_script();
        $script = $script . $this->mm->get_all_ikk_script();

        $data['added_js'] = "<script type='text/javascript'>$script</script>";
        $data['judul'] = 'PENCARIAN CANGGIH';
        $data['type'] = $type;
        $data['content'] = $this->load->view('e-budget/view_pencarian_canggih', $data, true);
        $this->load->view('main', $data);
    }
    
    function result_pencarian_canggih($type) {
        ini_set("max_execution_time","1200");
        ini_set("max_input_time","1200");
        ini_set("post_max_size","4000M");
        ini_set("memory_limit","4000M"); 
        
        $unit = $this->input->post('unit');
        $satker = $this->input->post('satker');
        $lokasi = $this->input->post('lokasi');
        $program = $this->input->post('program');
        $kegiatan = $this->input->post('kegiatan');
        $beban = $this->input->post('beban');
        $jenissat = $this->input->post('jenissat');
        $sinonim = $this->input->post('sinonim');
        $sinonim_negatif = $this->input->post('sinonim_negatif');
        $tsinonim = $this->input->post('tsinonim');
        $akungroup = $this->input->post('akungroup');
        $ikk = $this->input->post('ikk');
        $reformasi_kesehatan = $this->input->post('reformasi_kesehatan');
        $fokus_prioritas = $this->input->post('fokus_prioritas');

        $data_sinonim_negatif = $this->ms->get_sinonim_negatif($sinonim_negatif);
        $akun = $this->ms->get_sinonim_akun2($sinonim);
        $katakunci = $this->ms->get_sinonim_katakunci2($sinonim);
        $akungroupakun = $this->ma->get_akungroup_akun2($akungroup);
        $thang =  $this->session->userdata('thn_anggaran');
        if ($type == "3") {
            $volume = $this->input->post('volume');
            $view = $this->mm->get_belanja_data_pencarian_canggih_volume($thang, $unit, $satker, $lokasi, $program, $kegiatan, $beban, $jenissat, $sinonim, $akun, $katakunci, $akungroup, $akungroupakun, $tsinonim, $ikk, $reformasi_kesehatan, $fokus_prioritas, $volume); 
        }
        else {
            $view = $this->mm->get_belanja_data_pencarian_canggih($thang, $unit, $satker, $lokasi, $program, $kegiatan, $beban, $jenissat, $sinonim, $akun, $katakunci, $akungroup, $akungroupakun, $tsinonim, $ikk, $reformasi_kesehatan, $fokus_prioritas, $sinonim_negatif, $data_sinonim_negatif);        
        }
        
        $data['judul'] = 'HASIL PENCARIAN CANGGIH';
        $data['view'] = $view;
        if ($type == "0") {
            $data['content'] = $this->load->view('e-budget/view_hasil_pencarian_canggih', $data, true);
            $this->load->view('main', $data);
        }
        if ($type == "1" || $type == "3") {
            $rekap = $this->input->post('rekap');
            if ($unit == "0" && $rekap == "2") {
                $rekap = "1";
            }
            $data['rekap'] = $rekap;
            $this->load->view('e-budget/view_hasil_pencarian_rekap_excel', $data);
        }     
        if ($type == "2") {  
            foreach($this->mm->get_where('ref_unit', 'KDUNIT', $unit)->result() as $rw) {
                $nmunit = $rw->NMUNIT;
            }

            $data['judul'] = 'REKAP PENCARIAN';
            $data['unit'] = $nmunit;
            $data['content'] = $this->load->view('e-budget/view_hasil_pencarian_canggih_excel', $data);
//            $this->load->view('main', $data);
        }
    }
    
    function rekap_pencarian_canggih() {
        ini_set("max_execution_time","1200");
        ini_set("max_input_time","1200");
        ini_set("post_max_size","4000M");
        ini_set("memory_limit","4000M"); 
        
        $view = $this->input->post('rekap');
        //die (var_dump($view));
        $data['judul'] = 'REKAP PENCARIAN';
        $data['view'] = $view;
        $data2['content'] = $this->load->view('e-budget/view_hasil_pencarian_canggih_excel', $data);
//        $this->load->view('main', $data2);
    }
}

?>

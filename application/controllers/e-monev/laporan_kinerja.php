<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan_kinerja extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->cek_session();
        $this->load->helper('fusioncharts');
        $this->load->model('e-monev/laporan_kinerja_model', 'lkm');
        $this->load->model('e-monev/bank_model', 'bm');
		$this->load->model('role_model');
    }

    function cek_session() {
        $kode_role = $this->session->userdata('kd_role');
        if ($kode_role == '') {
            redirect('login/login_ulang');
        }
    }

    function index($prioritas = NULL) {
        $this->grid($prioritas);
    }

    function grid($pilihan_prioritas) {
        $kode_role = $this->session->userdata('kd_role');
		if($kode_role != Role_model::PEMBUAT_LAPORAN) {
			$colModel['no'] = array('No', 25, TRUE, 'center', 0);
	//		if($kode_role == 8) $colModel['nmsatker'] = array('Nama Satker',200,TRUE,'center',1);
			$colModel['Ikk'] = array('[Kode] Nama IKK', 550, TRUE, 'left', 1);
			$colModel['ExistingNasional'] = array('Capaian Nasional Tahun Lalu', 140, TRUE, 'left', 0);
			$colModel['TargetNasional'] = array('Target Nasional Tahun Berjalan', 150, TRUE, 'left', 0);
			$colModel['ExistingSatker'] = array('Capaian Satker Tahun Lalu', 130, TRUE, 'left', 0);
			$colModel['TargetSatker'] = array('Target Satker Tahun Berjalan', 140, TRUE, 'left', 0);
			$colModel['jumlah'] = array('Alokasi DIPA', 130, TRUE, 'left', 0);
			//$colModel['keuangan'] = array('Alokasi Swakelola dan Nilai Kontrak', 170, TRUE, 'left', 0);
			$colModel['nominal'] = array('Realisasi Keuangan', 120, TRUE, 'left', 0);
			$colModel['PersenRealisasiSPM'] = array('%Realisasi Keuangan SPM', 130, TRUE, 'left', 0);
			$colModel['PersenRealisasiSP2D'] = array('%Realisasi Keuangan SP2D', 133, TRUE, 'left', 0);
			$colModel['PersenCapaian'] = array('%Capaian Kinerja', 90, TRUE, 'left', 0);
			$colModel['InputRencanaRealisasi'] = array('Target & Realisasi Indikator', 120, FALSE, 'left', 0);
			/*$colModel['InputRencana'] = array('Target Indikator', 80, FALSE, 'left', 0);
			$colModel['InputRealisasi'] = array('Realisasi Indikator', 85, FALSE, 'left', 0);*/
			$colModel['RealisasiKinerja'] = array('Realisasi Kinerja', 80, FALSE, 'left', 0);
			$colModel['LihatPaket'] = array('Lihat Paket', 70, FALSE, 'left', 0);
		}
		else {
			$colModel['no'] = array('No', 25, TRUE, 'center', 0);
	//		if($kode_role == 8) $colModel['nmsatker'] = array('Nama Satker',200,TRUE,'center',1);
			$colModel['Ikk'] = array('[Kode] Nama IKK', 550, TRUE, 'left', 1);
			$colModel['ExistingNasional'] = array('Capaian Nasional Tahun Lalu', 140, TRUE, 'left', 0);
			$colModel['TargetNasional'] = array('Target Nasional Tahun Berjalan', 150, TRUE, 'left', 0);
			$colModel['ExistingSatker'] = array('Capaian Satker Tahun Lalu', 130, TRUE, 'left', 0);
			$colModel['TargetSatker'] = array('Target Satker Tahun Berjalan', 140, TRUE, 'left', 0);
			$colModel['jumlah'] = array('Alokasi DIPA', 130, TRUE, 'left', 0);
			//$colModel['keuangan'] = array('Alokasi Swakelola dan Nilai Kontrak', 170, TRUE, 'left', 0);
			$colModel['nominal'] = array('Realisasi Keuangan', 120, TRUE, 'left', 0);
			$colModel['PersenRealisasiSPM'] = array('%Realisasi Keuangan SPM', 130, TRUE, 'left', 0);
			$colModel['PersenRealisasiSP2D'] = array('%Realisasi Keuangan SP2D', 133, TRUE, 'left', 0);
			$colModel['PersenCapaian'] = array('%Capaian Kinerja', 90, TRUE, 'left', 0);
			$colModel['InputRencana'] = array('Target Indikator', 80, FALSE, 'left', 0);
			$colModel['InputRealisasi'] = array('Realisasi Indikator', 85, FALSE, 'left', 0);
			$colModel['RealisasiKinerja'] = array('Realisasi Kinerja', 80, FALSE, 'left', 0);
			$colModel['LihatPaket'] = array('Lihat Paket', 70, FALSE, 'left', 0);
		}

        //setting konfigurasi pada bottom tool bar flexigrid
        $gridParams = array(
            'width' => 'auto',
            'height' => 320,
            'rp' => 15,
            'rpOptions' => '[15,30,50,100]',
            'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
            'blockOpacity' => 0,
            'title' => '',
            'showTableToggleBtn' => false,
			'nowrap' => false
        );

		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Cetak','print','cetak_js');
		
        // mengambil data dari file controler ajax pada method grid_user	
        $url = site_url() . "/e-monev/laporan_kinerja/grid_data_kinerja/$pilihan_prioritas";
        $grid_js = build_grid_js('user', $url, $colModel, 'ID', 'asc', $gridParams, $buttons, true);
        $data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function cetak_js(com,grid){	
			if (com=='Cetak'){
				location.href= '".site_url()."/e-monev/laporan_kinerja/cetak/$pilihan_prioritas';    
			} 		
		} </script>";
		
        $data['notification'] = "";
        if ($this->session->userdata('notification') != '') {
            $data['notification'] = "
				<script>
					$(document).ready(function() {
						$.growlUI('Pesan :', '" . $this->session->userdata('notification') . "');
					});
				</script>
			";
        }//end if

        $prioritas = $this->lkm->get_prioritas();
        $data_prioritas[-2] = 'Semua';
        $data_prioritas[-1] = 'Semua Prioritas';
        foreach ($prioritas as $row) {
            $data_prioritas[$row->KodeJenisPrioritas] = $row->JenisPrioritas;
        }

        $data['judul'] = 'Laporan Kinerja';
        $data['prioritas'] = $data_prioritas;
        $data['curr_date'] = date('d M Y');
        $data['pilihan_prioritas'] = $pilihan_prioritas;
        $data['content'] = $this->load->view('e-monev/grid_kinerja', $data, true);
        $this->load->view('main', $data);
    }

    function grid_data_kinerja($pilihan_prioritas = NULL) {
        $kd_role = $this->session->userdata('kd_role');
        $valid_fields = array('ref_ikk.KodeIkk');
        $this->flexigrid->validate_post('ref_ikk.KodeIkk', 'asc', $valid_fields);
        $records = $this->lkm->get_dataIkk_grid($pilihan_prioritas);
        $this->output->set_header($this->config->item('json_header'));
        $no = 0;
        foreach ($records['records']->result() as $row) {
            $no = $no + 1;

            //capaian nasional tahun lalu
            $extNas = $this->lkm->get_previous_existing_nasional($row->KodeIkk);
            //capaian satker tahun lalu
            // $extSatker = $this->lkm->get_previous_existing_satker($row->KodeIkk);
            $extSatker = 0;
            //target nasional tahun berjalan
            $targetNas = $this->lkm->get_target_nasional($row->KodeIkk);
            //target satker tahun berjalan
            $targetSatker = $this->lkm->get_target_satker($row->KodeIkk);
            //ambil alokasi dipa dari table d_item_spm
			$alokasiDipa = $this->lkm->get_alokasi_dipa($row->KodeIkk);
			//alokasi swakelola dan nilai kontrak
			//$alokasiSwaKontrak = $this->lkm->get_alokasi_swakelola_dan_kontrak($row->KodeIkk);
			
			$nilai_keu = 0;
			$realisasiSpm = 0;
			$realisasiSp2d = 0;
			$realisasiKinerja = 0;

			//Proses %Capaian Kinerja
			$realisasiIkk = $this->lkm->get_realisasi_satkerIkk($row->KodeIkk);
			$rencanaIkk = $this->lkm->get_rencana_satkerIkk($row->KodeIkk);
			$capaianKinerja;
			if($realisasiIkk->num_rows() > 0){
				if($rencanaIkk->num_rows() > 0){
					$nilai_realisasi = $realisasiIkk->row()->bulan_12;
					$nilai_rencana = $rencanaIkk->row()->bulan_12;
					$capaianKinerja = ($nilai_realisasi/$nilai_rencana)*(100);	
				}
				else {
					$capaianKinerja = 0;
				}
			}
			else
			{
				$capaianKinerja = 0;
			}

			//warning icon capaian kinerja
			if($capaianKinerja < 50)
			{
				$warna_icon_capaian_kinerja = '<img border=\'0\' src=\''.base_url().'images/flexigrid/bulb_red.png\'>';
			}
			else if($capaianKinerja >= 50 && $capaianKinerja < 75)
			{
				$warna_icon_capaian_kinerja = '<img border=\'0\' src=\''.base_url().'images/flexigrid/bulb_yellow.png\'>';
			}
			else if($capaianKinerja >= 75 && $capaianKinerja <= 100)
			{
				$warna_icon_capaian_kinerja = '<img border=\'0\' src=\''.base_url().'images/flexigrid/bulb_green.png\'>';
			}
			else if($capaianKinerja > 100)
			{
				$warna_icon_capaian_kinerja = '<img border=\'0\' src=\''.base_url().'images/flexigrid/bulb_blue.png\'>';
			}
							
			if($kd_role != Role_model::PEMBUAT_LAPORAN) {
				$record_items[] = array(
					$no, $no,
					"[$row->KodeIkk] $row->Ikk",
					$extNas,
					$targetNas,
					$extSatker,
					$targetSatker,
					'Rp '.number_format($alokasiDipa, 2), // alokasi dipa
					//'Rp '.number_format($alokasiSwaKontrak, 2), //alokasi swakelola
					'Rp '.number_format(0, 2), // realisasi keu
					number_format($realisasiSpm, 2).' %',
					number_format($realisasiSp2d, 2).' %',
					number_format($capaianKinerja, 2).' %'.$warna_icon_capaian_kinerja,
					'<a href='.base_url().'index.php/e-monev/laporan_kinerja/indikator_grid/'.$row->KodeIkk.'/'.$row->idThnAnggaran.'><img border=\'0\' src=\''.base_url().'images/icon/lihat.png\'></a>',
					number_format($realisasiKinerja, 2).' %',
					'<a href='.base_url().'index.php/e-monev/laporan_kinerja/komponenGrid/'.$row->KodeIkk.'/'.$pilihan_prioritas.'><img border=\'0\' src=\''.base_url().'images/icon/lihat.png\'></a>'
				);
			}
			else {
				$record_items[] = array(
					$no, $no,
					"[$row->KodeIkk] $row->Ikk",
					$extNas,
					$targetNas,
					$extSatker,
					$targetSatker,
					'Rp '.number_format($alokasiDipa, 2), // alokasi dipa
					//'Rp '.number_format($alokasiSwaKontrak, 2), //alokasi swakelola
					'Rp '.number_format(0, 2), // realisasi keu
					number_format($realisasiSpm, 2).' %',
					number_format($realisasiSp2d, 2).' %',
					number_format($capaianKinerja, 2).' %'.$warna_icon_capaian_kinerja,
					'<a href='.base_url().'index.php/e-monev/laporan_kinerja/input_rencana/'.$row->KodeIkk.'/'.$row->idThnAnggaran.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>',
					'<a href='.base_url().'index.php/e-monev/laporan_kinerja/input_realisasi/'.$row->KodeIkk.'/'.$row->idThnAnggaran.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>',
					number_format($realisasiKinerja, 2).' %',
					'<a href='.base_url().'index.php/e-monev/laporan_kinerja/komponenGrid/'.$row->KodeIkk.'/'.$pilihan_prioritas.'><img border=\'0\' src=\''.base_url().'images/icon/lihat.png\'></a>'
				);
			}
        }
        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }

    function pilih_data() {
        $prioritas = $this->input->post('prioritas');
        $this->index($prioritas);
    }
	
	//Target & Realisasi Indikator
	function input_indikator($kodeikk, $id_thn)
	{
		$data['kodeikk'] = $kodeikk;
		$data['thn'] = $id_thn;
		$data['content'] = $this->load->view('e-monev/main_indikator',$data,true);
		$this->load->view('main',$data);
	}
    
	function daftar_indikator($kodeikk, $id_thn)
	{
		$ikk = $this->lkm->get_ikk($kodeikk);
        $rencana = $this->lkm->get_rencana_ikk($kodeikk, $id_thn);
        $realisasi = $this->lkm->get_realisasi_ikk($kodeikk, $id_thn);
		
		$data['ikk'] = $ikk;
		$data['thn'] = $id_thn;
		$data['kodeikk'] = $kodeikk;
		$data['bulan'] = $this->bulan();
		$data['rencana'] = $rencana;
		$data['satker'] = $this->lkm->get_satker()->row()->nmsatker;
		$data['realisasi'] = $realisasi;
		
		$this->load->view('e-monev/grid_indikator',$data);
	}
	
	function input_rencana_indikator($kodeikk,$id_bln,$id_thn)
	{
		$result = $this->lkm->get_rencana_ikk($kodeikk, $id_thn);
		$array_bulan = $this->bulan();
			
		$data['kodeikk'] = $kodeikk;
		$data['id_bln'] = $id_bln;
		$data['thn'] = $id_thn;
		$data['bulan'] = $array_bulan[$id_bln];
		$data['bulans'] = $this->bulan();
		$data['rencana'] = $result;
		$data['post_action'] = "e-monev/laporan_kinerja/save_rencana_indikator/$kodeikk/$id_thn";
		$this->load->view('e-monev/form_input_rencana_indikator',$data);
	}
	
	function save_rencana_indikator($kodeikk, $id_thn){
		/* hapus data rencana ikk */
		$this->lkm->delete_rencana_ikk($kodeikk, $id_thn);
		
		/* insert data rencana ikk */
		$data = array(
			'idThnAnggaran' => $id_thn,
			'kdSatker' => $this->session->userdata('kdsatker'),
			'kodeIkk' => $kodeikk,
		);
		//$i=$id_bln;
		for($i=1; $i<=12; $i++)
			$data = array_merge ($data, array("bulan_$i"=> $this->input->post("bulan_$i")));
		
		$this->lkm->save_rencana_ikk($data);
		redirect("e-monev/laporan_kinerja/input_indikator/$kodeikk/$id_thn");
    }
	
	function input_realisasi_indikator($kodeikk, $id_thn) {
        $rencana = $this->lkm->get_rencana_ikk($kodeikk, $id_thn);
        
        if (count($rencana) > 0){
        $realisasi = $this->lkm->get_realisasi_ikk($kodeikk, $id_thn);        
        
        $data['kodeikk'] = $kodeikk;
        $data['thn'] = $id_thn;
        $data['bulan'] = $this->bulan();
        $data['rencana'] = $rencana;
        $data['realisasi'] = $realisasi;
        $data['post_action'] = "e-monev/laporan_kinerja/save_realisasi_indikator/$kodeikk/$id_thn";
        }else{
            $data['noRencana'] = 'Silahkan isi data rencana terlebih dahulu!!';
			$data['kodeikk'] = $kodeikk;
        	$data['thn'] = $id_thn;
		}
        $this->load->view('e-monev/form_input_realisasi_indikator',$data);
    }
	
	function save_realisasi_indikator($kodeikk, $id_thn){
		/* hapus data rencana ikk */
		$this->lkm->delete_realisasi_ikk($kodeikk, $id_thn);
		
		/* insert data rencana ikk */
		$data = array(
			'idThnAnggaran' => $id_thn,
			'kdSatker' => $this->session->userdata('kdsatker'),
			'kodeIkk' => $kodeikk,
		);
		//$i=$id_bln;
		for($i=1; $i<=12; $i++)
			$data = array_merge ($data, array("bulan_$i"=> $this->input->post("bulan_$i")));
		
		$this->lkm->save_realisasi_ikk($data);
		redirect("e-monev/laporan_kinerja/input_indikator/$kodeikk/$id_thn");
    }
	
	function indikator_grid($kodeikk, $id_thn)
	{
        $colModel['no'] = array('No', 25, TRUE, 'center', 0);
		$colModel['satker'] = array('Nama Satker', 150, TRUE, 'left', 1);
		$colModel['jan'] = array('Januari', 70, TRUE, 'left', 0);
		$colModel['feb'] = array('Februari', 70, TRUE, 'left', 0);
		$colModel['mar'] = array('Maret', 70, TRUE, 'left', 0);
		$colModel['apr'] = array('April', 70, TRUE, 'left', 0);
		$colModel['mei'] = array('Mei', 70, TRUE, 'left', 0);
		$colModel['jun'] = array('Juni', 70, TRUE, 'left', 0);
		$colModel['jul'] = array('Juli', 70, TRUE, 'left', 0);
		$colModel['ags'] = array('Agustus', 70, TRUE, 'left', 0);
		$colModel['sep'] = array('September', 70, TRUE, 'left', 0);
		$colModel['okt'] = array('Oktober', 70, TRUE, 'left', 0);
		$colModel['nov'] = array('November', 70, TRUE, 'left', 0);
		$colModel['des'] = array('Desember', 70, TRUE, 'left', 0);
		
        //setting konfigurasi pada bottom tool bar flexigrid
        $gridParams = array(
            'width' => 'auto',
            'height' => 320,
            'rp' => 15,
            'rpOptions' => '[15,30,50,100]',
            'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
            'blockOpacity' => 0,
            'title' => '',
            'showTableToggleBtn' => false,
			'nowrap' => false
        );
        
        $buttons[] = array('Kembali','add','spt_js');
        $buttons[] = array('separator');

        // mengambil data dari file controler ajax pada method grid_user	
        $url = site_url() . "/e-monev/laporan_kinerja/grid_indikator/$kodeikk/$id_thn";
        $grid_js = build_grid_js('user', $url, $colModel, 'ID', 'asc', $gridParams, $buttons, true);
        $data['js_grid'] = $grid_js;
        $data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Kembali'){
				location.href= '".base_url()."index.php/e-monev/laporan_kinerja';    
			}   
		} </script>";
        
        $data['notification'] = "";
        if ($this->session->userdata('notification') != '') {
            $data['notification'] = "
				<script>
					$(document).ready(function() {
						$.growlUI('Pesan :', '" . $this->session->userdata('notification') . "');
					});
				</script>
			";
        }//end if

        $ikk = $this->lkm->get_ikk($kodeikk);

        $data['judul'] = 'Laporan Kinerja';
        $data['curr_date'] = date('d M Y');
        $data['dataikk'] = $ikk[0];
        $data['content'] = $this->load->view('e-monev/grid_indikator2', $data, true);
        $this->load->view('main', $data);
	}
	
	function grid_indikator($kodeikk, $id_thn)
	{
		$valid_fields = array('i.KodeIkk');
        $this->flexigrid->validate_post('i.KodeIkk', 'asc', $valid_fields);
        $records = $this->lkm->get_indikator_grid($kodeikk, $id_thn);
        $this->output->set_header($this->config->item('json_header'));
        $no = 0;
        foreach ($records['records']->result() as $row) {
            $no = $no + 1;
			$nmsatker = $this->lkm->get_satker($row->kdSatker)->row()->nmsatker;
            $record_items[] = array(
                $no, $no,
				$nmsatker,
				$row->b1.'/'.$row->bulan_1,
				$row->b2.'/'.$row->bulan_2,
				$row->b3.'/'.$row->bulan_3,
				$row->b4.'/'.$row->bulan_4,
				$row->b5.'/'.$row->bulan_5,
				$row->b6.'/'.$row->bulan_6,
				$row->b7.'/'.$row->bulan_7,
				$row->b8.'/'.$row->bulan_8,
				$row->b9.'/'.$row->bulan_9,
				$row->b10.'/'.$row->bulan_10,
				$row->b11.'/'.$row->bulan_11,
				$row->b12.'/'.$row->bulan_12
            );
        }
        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
    function komponenGrid($kodeikk, $pilihan_prioritas=NULL) {
        $kode_role = $this->session->userdata('kd_role');
        $colModel['no'] = array('No', 25, TRUE, 'center', 0);
        $colModel['komponen'] = array('[Komponen] [Subkomponen] Nama Subkomponen', 425, TRUE, 'left', 1);
		$colModel['satker'] = array('Nama Satker', 150, TRUE, 'left', 0);
		$colModel['ProgFisik'] = array('Progress Fisik', 150, TRUE, 'left', 0);
		$colModel['alokasi'] = array('Alokasi Swakelola atau Nilai Kontrak', 185, TRUE, 'left', 0);
		$colModel['RealisasiFisik'] = array('Realisasi Fisik Kinerja', 150, TRUE, 'left', 0);
//        $colModel['ExistingNasional'] = array('Existing Nas', 60, TRUE, 'center', 0);
//        $colModel['ExistingSatker'] = array('Existing Satker', 70, TRUE, 'center', 0);
//        $colModel['TargetSatker'] = array('Target Satker', 70, TRUE, 'center', 0);
//        $colModel['TargetNasional'] = array('Target Nas', 60, TRUE, 'center', 0);
//        $colModel['jumlah'] = array('Alokasi', 120, TRUE, 'right', 0);
//        $colModel['keuangan'] = array('Keuangan', 120, TRUE, 'right', 0);
//        $colModel['nominal'] = array('Realisasi', 120, TRUE, 'right', 0);

        //setting konfigurasi pada bottom tool bar flexigrid
        $gridParams = array(
            'width' => 'auto',
            'height' => 320,
            'rp' => 15,
            'rpOptions' => '[15,30,50,100]',
            'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
            'blockOpacity' => 0,
            'title' => '',
            'showTableToggleBtn' => false,
			'nowrap' => false
        );
        
        $buttons[] = array('Kembali','add','spt_js');
        $buttons[] = array('separator');

        // mengambil data dari file controler ajax pada method grid_user	
        $url = site_url() . "/e-monev/laporan_kinerja/grid_data_komponen/$kodeikk";
        $grid_js = build_grid_js('user', $url, $colModel, 'ID', 'asc', $gridParams, $buttons, true);
        $data['js_grid'] = $grid_js;
        $data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Kembali'){
				location.href= '".base_url()."index.php/e-monev/laporan_kinerja';    
			}   
		} </script>";
        
        $data['notification'] = "";
        if ($this->session->userdata('notification') != '') {
            $data['notification'] = "
				<script>
					$(document).ready(function() {
						$.growlUI('Pesan :', '" . $this->session->userdata('notification') . "');
					});
				</script>
			";
        }//end if

        $prioritas = $this->lkm->get_prioritas();
        $data_prioritas[-2] = 'Semua';
        $data_prioritas[-1] = 'Semua Prioritas';
        foreach ($prioritas as $row) {
            $data_prioritas[$row->KodeJenisPrioritas] = $row->JenisPrioritas;
        }
        
        $ikk = $this->lkm->get_ikk($kodeikk);

        $data['judul'] = 'Laporan Kinerja';
        $data['prioritas'] = $data_prioritas;
        $data['curr_date'] = date('d M Y');
        $data['pilihan_prioritas'] = $pilihan_prioritas;
        $data['dataikk'] = $ikk[0];
        $data['content'] = $this->load->view('e-monev/grid_komponen', $data, true);
        $this->load->view('main', $data);
    }
    
    function grid_data_komponen($kodeikk) {
        $valid_fields = array('d.d_skmpnen_id');
        $this->flexigrid->validate_post('d.d_skmpnen_id', 'asc', $valid_fields);
        $records = $this->lkm->get_komponen_grid2($kodeikk);
        $this->output->set_header($this->config->item('json_header'));
		$progres_fisik = 0;
        $no = 0;
        foreach ($records['records']->result() as $row) {
            $no = $no + 1;
            //$nmsatker = $this->lkm->get_satker($row->kdsatker)->row()->nmsatker;
			$keu = $this->lkm->get_paket_keu($row->d_skmpnen_id);
			$kontrak = $this->lkm->get_kontrak_keu($kodeikk);
			$tot = $this->lkm->get_totaljumlah($kodeikk);
			$swakelola = $this->lkm->get_pakett($kodeikk);
			
			if($keu->num_rows() > 0)
			{
				if($keu->row()->paket_pengerjaan==0){
					//$nilai_keu = $kontrak->num_rows() > 0? $kontrak->row()->nilai_kontrak:0;
					$nilai_keu = $keu->row()->nilai_kontrak;	
				}
				else{
					$nilai_keu = $keu->row()->totaljumlah;	
				}
			}
			else{
				$nilai_keu = 0;
			}
			
			if($swakelola->num_rows() > 0)
			{
				if($swakelola->row()->paket_pengerjaan==0){
					$nilai_swa = $swakelola->row()->nilai_kontrak;
					//$nilai_keu = $keu->row()->nilai_kontrak;	
				}
				else{
					$n_kontrak = $kontrak->num_rows() > 0? $kontrak->row()->nilai_kontrak:0;
					$nilai_swa = $swakelola->row()->totaljumlah + $n_kontrak;	
				}
			}
			else{
				$nilai_swa = 0;
			}
			
			if($this->lkm->get_progress($row->d_skmpnen_id)->num_rows() > 0)
				{
					if(date("Y") > $this->session->userdata('thn_anggaran')){ //jika tahun anggaran sudah lewat
						$progres_fisik = $this->lkm->get_progress3($row->d_skmpnen_id,11);
						$nilai_prog = $progres_fisik->num_rows() > 0? $progres_fisik->row()->realisasi_fisik:0;
					}else{
						if(date("m") == 1)
						{ 
							$progres_fisik = $this->lkm->get_progress_tahun($row->d_skmpnen_id,12,$this->session->userdata('thn_anggaran')-1);
							$nilai_prog = $progres_fisik->num_rows() > 0? $progres_fisik->row()->realisasi_fisik:0;
						}
						else{
							$nilai_prog = $this->lkm->get_progress3($row->d_skmpnen_id,date("m")-1)->row()->realisasi_fisik;
						}
					}
				}
				else
				{
					$nilai_prog = 0;
				}
			
			/*progres fisik
			$prog_fisik = $this->lkm->get_progres_fisik($row->d_skmpnen_id);
			$nilai_prog_fisik = $prog_fisik->num_rows() > 0? $prog_fisik->row()->fisik:0;*/
		
			//realisasi fisik kinerja
			//
			$alokasi_dipa = $row->totaljumlah;
			$total_alokasi = $nilai_keu;
			$totaljum = $tot->row()->totaljumlah;
			//$realisasi_fisik = (($nilai_prog)*($alokasi_dipa)/$total_alokasi)*(100);
			$realisasi_fisik = $total_alokasi == 0 ? 0 : (($nilai_prog)*($alokasi_dipa)/$nilai_swa);
			
            $record_items[] = array(
                $no, $no,
                "[$row->kdkmpnen] [$row->kdskmpnen] $row->urskmpnen",
				$row->nmsatker,
				number_format($nilai_prog, 2).' %',
				'Rp '.number_format($nilai_keu),
				number_format($realisasi_fisik, 2).' %'
            );
        }
        if (isset($record_items))
            $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
        else
            $this->output->set_output('{"page":"1","total":"0","rows":[]}');
    }

    function bulan() {
        $bulan = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
        return $bulan;
    }

    function input_rencana($kodeikk, $id_thn) {
        $ikk = $this->lkm->get_ikk($kodeikk);
        $rencana = $this->lkm->get_rencana_ikk($kodeikk, $id_thn);
        
        $data['ikk'] = $ikk;
        $data['id_thn'] = $id_thn;
        $data['bulan'] = $this->bulan();
        $data['rencana'] = $rencana;
        $data['post_action'] = "e-monev/laporan_kinerja/insert_rencana/$kodeikk/$id_thn";
        $data['content'] = $this->load->view('e-monev/form_input_rencana_ikk', $data, true);
        $this->load->view('main', $data);
    }
    
    function insert_rencana($kodeikk, $id_thn){
        if ($this->cek_validasi(1) == FALSE){
            $this->input_rencana($kodeikk, $id_thn);
        }else{
            /* hapus data rencana ikk */
            $this->lkm->delete_rencana_ikk($kodeikk, $id_thn);
            
            /* insert data rencana ikk */
            $data = array(
                'idThnAnggaran' => $id_thn,
                'kdSatker' => $this->session->userdata('kdsatker'),
                'kodeIkk' => $kodeikk,
            );
            
            for($i=1; $i<=12; $i++)
                $data = array_merge ($data, array("bulan_$i"=> $this->input->post("bulan_$i")));
            
            $this->lkm->save_rencana_ikk($data);

            redirect("e-monev/laporan_kinerja");
        }
    }
    
    function input_realisasi($kodeikk, $id_thn) {
        $ikk = $this->lkm->get_ikk($kodeikk);
        $rencana = $this->lkm->get_rencana_ikk($kodeikk, $id_thn);
        
        if (count($rencana) > 0){
        $realisasi = $this->lkm->get_realisasi_ikk($kodeikk, $id_thn);        
        
        $data['ikk'] = $ikk;
        $data['id_thn'] = $id_thn;
        $data['bulan'] = $this->bulan();
        $data['rencana'] = $rencana;
        $data['realisasi'] = $realisasi;
        $data['post_action'] = "e-monev/laporan_kinerja/insert_realisasi/$kodeikk/$id_thn";
        }else
            $data['noRencana'] = 'Silahkan isi data rencana terlebih dahulu!!';
        $data['content'] = $this->load->view('e-monev/form_input_realisasi_ikk', $data, true);
        $this->load->view('main', $data);
    }
    
    function insert_realisasi($kodeikk, $id_thn){
        if ($this->cek_validasi(2) == FALSE){
            $this->input_realisasi($kodeikk, $id_thn);
        }else{
            /* hapus data rencana ikk */
            $this->lkm->delete_realisasi_ikk($kodeikk, $id_thn);
            
            /* insert data rencana ikk */
            $data = array(
                'idThnAnggaran' => $id_thn,
                'kdSatker' => $this->session->userdata('kdsatker'),
                'kodeIkk' => $kodeikk,
            );
            
            for($i=1; $i<=12; $i++)
                $data = array_merge ($data, array("bulan_$i"=> $this->input->post("bulan_$i")));
            
            $this->lkm->save_realisasi_ikk($data);

            redirect("e-monev/laporan_kinerja");
        }
    }
    
    // cek_validasi setiap input user
    function cek_validasi($jenis) {
        $this->load->library('form_validation');
        if ($jenis == 1)
            $field = 'Rencana';
        else if ($jenis == 2)
            $field = 'Realisasi';
        
        //setting rules
        for($i=1; $i<=12; $i++)
            $this->form_validation->set_rules("bulan_$i", "Nilai $field", 'required|integer');

        // Setting Error Message
        $this->form_validation->set_message('required', '%s harus diisi!!');
        $this->form_validation->set_message('integer', '%s harus berisi angka bulat!!');

//        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        return $this->form_validation->run();
    }

    function get_kabupaten() {
        if ($_POST['data_post'] != '') {
            $data = '';
            $parent = $_POST['data_post'];
            $result = $this->lkm->get_kabupaten_by_kode_provinsi($parent);
            foreach ($result as $row) {
                $data.= '<option value="' . $row->KodeKabupaten . '" class="dynamic_data_kabupaten">' . $row->NamaKabupaten . '</option>';
            }
            echo $data;
        }
        else
            echo '<option value="0" class="dynamic_data_kabupaten">-- Pilih Kabupaten --</option>';
    }

    function cek_dropdown($value) {
        if ($value == 0) {
            //$this->form_validation->set_message('cek_dropdown', 'Kolom %s harus dipilih!!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

	function cetak($pilihan_prioritas=NULL)
	{
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thn = $this->session->userdata('thn_anggaran');
		
		// call library
		$kd_role = $this->session->userdata('kd_role');
		$records = $this->lkm->get_dataIkk($pilihan_prioritas);
		
		$nmsatker = $this->lkm->get_satker($this->session->userdata('kdsatker'))->row()->nmsatker;
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/rekap_kinerja.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Rekap Laporan Kinerja Tahun Anggaran '.$thn); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no = 0;
		$awal_baris = 7; //awal baris
		$baris = $awal_baris;
		
		if($records->num_rows()>0){
			foreach($records->result() as $row){
				$no = $no + 1;
				$kode_ikk = '['.$row->KodeIkk.'] '.$row->Ikk;
				$target_ind = $this->lkm->get_rencana_ikk($row->KodeIkk, $row->idThnAnggaran);
				$real_ind = $this->lkm->get_realisasi_ikk($row->KodeIkk, $row->idThnAnggaran);
				$paket = $this->lkm->get_paket_cetak($row->KodeIkk);
				
				$extNas = $this->lkm->get_previous_existingNas($row->KodeIkk);
				$extSatker = $this->lkm->get_previous_existingSatker($row->KodeIkk);
				$targetSatker = $this->lkm->get_target_satker($row->KodeIkk);
				$targetNas = $this->lkm->get_target_Nasional($row->KodeIkk);
				$realisasi = $this->lkm->get_realisasi_keu($row->KodeIkk);
				$alokasi = $this->lkm->get_alokasi_keu($row->KodeIkk);
				$nilai_alokasi = $alokasi->num_rows() > 0?$alokasi->row()->totaljumlah:0;
				$kontrak = $this->lkm->get_kontrak($row->KodeIkk);
				$keuangan = $this->lkm->get_keu($row->KodeIkk);
				$keu = $this->lkm->get_keu($row->KodeIkk);
				$nilai_keuangan = 0;
				$realisasiSpm = 0;
				$realisasiSp2d = 0;
				$sp2d = $this->lkm->get_sp2d($row->KodeIkk);
            
				//mengambil nilai alokasi swakelola & nilai kontrak
				if($keu->num_rows() > 0)
				{
					if($keu->row()->paket_pengerjaan==0){
						$nilai_keu = $keu->row()->nilai_kontrak;
						//$nilai_keu = $keu->row()->nilai_kontrak;	
					}
					else{
						$n_kontrak = $kontrak->num_rows() > 0? $kontrak->row()->nilai_kontrak:0;
						$nilai_keu = $keu->row()->totaljumlah + $n_kontrak;	
					}
				}
				else{
					$nilai_keu = 0;
				}
				
				//mengambil nilai sp2d
				$n_sp2d = $sp2d->num_rows() > 0? $sp2d->row()->nominal:0;
				$realisasiSp2d = $nilai_keu == 0 ? 0 : (($n_sp2d/$nilai_keu)*(100));
				
				//mengambil nilai spm
				$n_rea = $realisasi->num_rows() > 0? $realisasi->row()->nominal:0;
				$realisasiSpm = $nilai_keu == 0 ? 0 : (($n_rea/$nilai_keu)*(100));
				
				//Target Satker
				if($targetSatker->num_rows() > 0){
					if($targetSatker->row()->bulan_12 == null)
						$total_target = 0;
					else
						$total_target = $targetSatker->row()->bulan_12;
				}else{
					$total_target = 0;
				}
				//End Target Satker
				
				if($extSatker->num_rows() > 0){
					if($extSatker->row()->bulan_12 == null)
						$exist_satker = 0;
					else
						$exist_satker = $extSatker->row()->bulan_12;
				}else{
					$exist_satker = 0;
				}
				
				//Proses %Capaian Kinerja
				$realisasiIkk = $this->lkm->get_realisasi_satkerIkk($row->KodeIkk);
				$rencanaIkk = $this->lkm->get_rencana_satkerIkk($row->KodeIkk);
				$capaianKinerja;
				if($realisasiIkk->num_rows() > 0){
					if($rencanaIkk->num_rows() > 0){
						$nilai_realisasi = $realisasiIkk->row()->bulan_12;
						$nilai_rencana = $rencanaIkk->row()->bulan_12;
						$capaianKinerja = ($nilai_realisasi/$nilai_rencana)*(100);	
					}
					else
						$capaianKinerja = 0;
				}
				else
					$capaianKinerja = 0;
				//End Capaian Kinerja
				
				//Mengambil Nilai Progress
				if($this->lkm->get_progresss($row->KodeIkk)->num_rows() > 0)
				{
					if(date("Y") > $this->session->userdata('thn_anggaran')){ //jika tahun anggaran sudah lewat
						$progres_fisik = $this->lkm->get_progress4($row->KodeIkk,11);
						$nilai_prog = $progres_fisik->num_rows() > 0? $progres_fisik->row()->realisasi_fisik:0;
					}else{
						if(date("m") == 1)
						{ 
							$progres_fisik = $this->lkm->get_progress_tahun1($row->KodeIkk,12,$this->session->userdata('thn_anggaran')-1);
							$nilai_prog = $progres_fisik->num_rows() > 0? $progres_fisik->row()->realisasi_fisik:0;
						}
						else{
							$nilai_prog = $this->lkm->get_progress4($row->KodeIkk,date("m")-1)->row()->realisasi_fisik;
						}
					}
				}
				else
				{
					$nilai_prog = 0;
				}
				//End Nilai Progress
				
				//$realisasiKinerja = $nilai_prog;
				$tot = $this->lkm->get_totaljumlah($row->KodeIkk);
				$tott = $this->lkm->get_totaljumlah2($row->KodeIkk);
				$alokasi_dipa = $tott->num_rows() > 0? $tott->row()->totaljumlah:0;
				$total_alokasi = $nilai_keu;
				$totaljum = $tot->row()->totaljumlah;
				//$realisasi_fisik = (($nilai_prog)*($alokasi_dipa)/$total_alokasi)*(100);
				$realisasiKinerja = $total_alokasi == 0 ? 0 : (($nilai_prog)*($totaljum)/$nilai_keu);
				
				//Proses mengambil paket
				$list_paket = '';
				if($paket->num_rows() > 0){
					foreach($paket->result() as $row){
						if($list_paket == ''){
							$list_paket .= $row->urskmpnen;
						}else{
							$list_paket .= ', '.$row->urskmpnen;
						}
					}
				}
				else {
					$list_paket = '-';	
				}
				//End paket
				
				//Mengambil nilai Target Indikator
				$target_ind_1 = 0;
				$target_ind_2 = 0;
				$target_ind_3 = 0;
				$target_ind_4 = 0;
				$target_ind_5 = 0;
				$target_ind_6 = 0;
				$target_ind_7 = 0;
				$target_ind_8 = 0;
				$target_ind_9 = 0;
				$target_ind_10 = 0;
				$target_ind_11 = 0;
				$target_ind_12 = 0;
				
				foreach ($target_ind as $row) {
					$target_ind_1 = $row->bulan_1;
					$target_ind_2 = $row->bulan_2;
					$target_ind_3 = $row->bulan_3;
					$target_ind_4 = $row->bulan_4;
					$target_ind_5 = $row->bulan_5;
					$target_ind_6 = $row->bulan_6;
					$target_ind_7 = $row->bulan_7;
					$target_ind_8 = $row->bulan_8;
					$target_ind_9 = $row->bulan_9;
					$target_ind_10 = $row->bulan_10;
					$target_ind_11 = $row->bulan_11;
					$target_ind_12 = $row->bulan_12;
				}
				//End target indikator
				
				//Mengambil nilai realisasi indikator
				$real_ind_1 = 0;
				$real_ind_2 = 0;
				$real_ind_3 = 0;
				$real_ind_4 = 0;
				$real_ind_5 = 0;
				$real_ind_6 = 0;
				$real_ind_7 = 0;
				$real_ind_8 = 0;
				$real_ind_9 = 0;
				$real_ind_10 = 0;
				$real_ind_11 = 0;
				$real_ind_12 = 0;
				
				foreach ($real_ind as $row) {
					$real_ind_1 = $row->bulan_1;
					$real_ind_2 = $row->bulan_2;
					$real_ind_3 = $row->bulan_3;
					$real_ind_4 = $row->bulan_4;
					$real_ind_5 = $row->bulan_5;
					$real_ind_6 = $row->bulan_6;
					$real_ind_7 = $row->bulan_7;
					$real_ind_8 = $row->bulan_8;
					$real_ind_9 = $row->bulan_9;
					$real_ind_10 = $row->bulan_10;
					$real_ind_11 = $row->bulan_11;
					$real_ind_12 = $row->bulan_12;
				}
				//End realisasi indikator
				
				//SetCellValue
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $kode_ikk);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $extNas->num_rows() > 0 ?$extNas->row()->ExistingNasional:0);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $targetNas->num_rows() > 0?$targetNas->row()->TargetNasional:0);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $extSatker->num_rows() > 0 ?$extSatker->row()->total_realisasi:0);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, $total_target);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, 'Rp '.number_format($nilai_alokasi, 2));
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, 'Rp '.number_format($nilai_keu, 2));
				$this->excel->getActiveSheet()->setCellValue('I'.$baris, 'Rp '.number_format($realisasi->num_rows() > 0?$realisasi->row()->nominal:0, 2));
				$this->excel->getActiveSheet()->setCellValue('J'.$baris, number_format($realisasiSpm, 2).' %');
				$this->excel->getActiveSheet()->setCellValue('K'.$baris, number_format($realisasiSp2d, 2).' %');
				$this->excel->getActiveSheet()->setCellValue('L'.$baris, number_format($capaianKinerja, 2).' %');
				$this->excel->getActiveSheet()->setCellValue('M'.$baris, number_format($realisasiKinerja, 2).' %');
				
				$this->excel->getActiveSheet()->setCellValue('N'.$baris, $target_ind_1);
				$this->excel->getActiveSheet()->setCellValue('O'.$baris, $real_ind_1);
				$this->excel->getActiveSheet()->setCellValue('P'.$baris, $target_ind_2);
				$this->excel->getActiveSheet()->setCellValue('Q'.$baris, $real_ind_2);
				$this->excel->getActiveSheet()->setCellValue('R'.$baris, $target_ind_3);
				$this->excel->getActiveSheet()->setCellValue('S'.$baris, $real_ind_3);
				$this->excel->getActiveSheet()->setCellValue('T'.$baris, $target_ind_4);
				$this->excel->getActiveSheet()->setCellValue('U'.$baris, $real_ind_4);
				$this->excel->getActiveSheet()->setCellValue('V'.$baris, $target_ind_5);
				$this->excel->getActiveSheet()->setCellValue('W'.$baris, $real_ind_5);
				$this->excel->getActiveSheet()->setCellValue('X'.$baris, $target_ind_6);
				$this->excel->getActiveSheet()->setCellValue('Y'.$baris, $real_ind_6);
				$this->excel->getActiveSheet()->setCellValue('Z'.$baris, $target_ind_7);
				$this->excel->getActiveSheet()->setCellValue('AA'.$baris, $real_ind_7);
				$this->excel->getActiveSheet()->setCellValue('AB'.$baris, $target_ind_8);
				$this->excel->getActiveSheet()->setCellValue('AC'.$baris, $real_ind_8);
				$this->excel->getActiveSheet()->setCellValue('AD'.$baris, $target_ind_9);
				$this->excel->getActiveSheet()->setCellValue('AE'.$baris, $real_ind_9);
				$this->excel->getActiveSheet()->setCellValue('AF'.$baris, $target_ind_10);
				$this->excel->getActiveSheet()->setCellValue('AG'.$baris, $real_ind_10);
				$this->excel->getActiveSheet()->setCellValue('AH'.$baris, $target_ind_11);
				$this->excel->getActiveSheet()->setCellValue('AI'.$baris, $real_ind_11);
				$this->excel->getActiveSheet()->setCellValue('AJ'.$baris, $target_ind_12);
				$this->excel->getActiveSheet()->setCellValue('AK'.$baris, $real_ind_12);
				$this->excel->getActiveSheet()->setCellValue('AL'.$baris, $list_paket);
				
				$baris++;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':AL'.($baris-1))->getBorders()->getInside()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':AL'.($baris-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':AL'.($baris-1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':AL'.($baris-1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap_Laporan_Kinerja_'.$nmsatker.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
		
	}
	
}

//end class
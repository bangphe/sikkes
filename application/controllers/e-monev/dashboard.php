<?php
class Dashboard extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->model('e-planning/Manajemen_model','mm');
		$this->load->model('e-monev/dashboard_model','dm');
		$this->load->model('e-monev/dashboard_unit_model', 'dum');
		$this->load->model('e-monev/laporan_monitoring_model','lmm');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	
	function index()
	{
		$this->grid();
	}
	
	function grid()
	{
		$data['thang'] = $this->session->userdata('thn_anggaran');
		$data['content'] = $this->load->view('e-monev/dashboard_kementerian',$data,true);
		$this->load->view('main',$data);
	}
	
	function grid_kementerian()
	{
		//$id = '01';
		$thang = $this->session->userdata('thn_anggaran');
		if(isset($_POST['id'])) {
		 $kode = explode('#',$_POST['id']);
		 if($kode[0] == 'unit'){
		 	$this->getProv($kode[1], $kode[2], $kode[3]);
		 }
		 if($kode[0] == 'prop'){
		 	$this->getJnssat($kode[1], $kode[2], $kode[3], $kode[4]);
		 }
		 if($kode[0] == 'jnssat'){
		 	$this->getNewSatker($kode[1], $kode[2], $kode[3], $kode[4], $kode[5]);
		 }
		 // if($kode[0] == 'satker'){
		 // 	//$this->getPaket($kode[1], $kode[2], $kode[3], $kode[4], $kode[5]);
		 // 	$this->getKegiatan($kode[1], $kode[2], $kode[3], $kode[4], $kode[5]);
		 // }
		 // if($kode[0] == 'kegiatan'){
			//  $this->getOutput($kode[1], $kode[2], $kode[3], $kode[4], $kode[5]);
		 // }
		}
		else
		{
			$thang = $this->session->userdata('thn_anggaran');
			$bulan = date("n")-1;
			
			// pagu total se-kementerian
			$pagu_total = 0;
			$pagu_total += $this->dm->get_pagu_total_swakelola($thang)->row()->jumlah;
			$pagu_total += $this->dm->get_pagu_total_kontraktual($thang)->row()->nilaikontrak;
						
			$result = array();
			$records = $this->dm->get_unit_utama();
			foreach($records->result_array() as $row){
				$row['id'] = 'unit#'.$row['KDUNIT'].'#'.$thang.'#'.$pagu_total;
				
				$un = $this->dum->get_provinsi();
				foreach($un->result_array() as $row3){
					
					$jns = $this->dum->get_jnssat_by_prov($row['KDUNIT'], $row3['KodeProvinsi']);
					foreach($jns->result_array() as $row2){
						
						$pagu_jnssat = 0;
						$merah = 0;
						$kuning = 0;
						$hijau = 0;
						$biru = 0;
						$fisik_jnssat = 0;
						$fisik = 0;
						$pagu_progress = 0;
						
						$kegiatan = $this->dum->get_kegiatan_by_satker($row2['kdunit'], $row2['kdlokasi'], $row2['kdsatker'], $thang);
						$progress_satker=0;
						$count_kegiatan=0;
						foreach($kegiatan->result() as $data_kegiatan){//8
							$kdjendok = $data_kegiatan->kdjendok;
							$kddept = $data_kegiatan->kddept;
							$kdprogram = $data_kegiatan->kdprogram;
							$kdoutput = $data_kegiatan->kdoutput;
							$kdlokasi = $data_kegiatan->kdlokasi;
							$kdkabkota = $data_kegiatan->kdkabkota;
							$kddekon = $data_kegiatan->kddekon;
							$kdsoutput = $data_kegiatan->kdsoutput;
							$kdgiat = $data_kegiatan->kdgiat;
							$kdsatker = $data_kegiatan->kdsatker;
							$kdunit = $data_kegiatan->kdunit;

							$progress_fisik = 0;
							//$progress_fisik_output = 0;
							$progress_fisik_total = 0;
							$count_progress_fisik = 0;
							$paket = $this->dum->get_suboutput_by_satker($data_kegiatan->kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang);
							foreach($paket->result() as $pk){//ini menampilkan outputnya
								$kdjendok_paket = $pk->kdjendok;
								$kddept_paket = $pk->kddept;
								$kdprogram_paket = $pk->kdprogram;
								$kdoutput_paket = $pk->kdoutput;
								$kdlokasi_paket = $pk->kdlokasi;
								$kdkabkota_paket = $pk->kdkabkota;
								$kddekon_paket = $pk->kddekon;
								$kdsoutput_paket = $pk->kdsoutput;
								$kdgiat_paket = $pk->kdgiat;
								//ngecek apakah input laporan sudah diisi atau belom
								$cek_paket = $this->lmm->cek_paket_by_kdoutput($thang, $kdjendok_paket, $kdsatker, $kddept_paket, $kdunit, $kdprogram_paket, $kdgiat_paket, $kdoutput_paket, $kdlokasi_paket, $kdkabkota_paket, $kddekon_paket, $kdsoutput_paket);
								if ($cek_paket->num_rows > 0) {
									foreach ($cek_paket->result() as $row2) {//ini hasilnya cuman 1
										$idpaket = $row2->idpaket;
									}
									//PROGRESS FISIK
									if($this->lmm->get_progress_by_idpaket($idpaket)->num_rows() > 0) {
										//ambil progress fisik tiap bulan per output
										$progress_fisik_output = $this->lmm->get_progress_by_idpaket_and_month($idpaket,date("m"))->row()->progress;
										$progress_fisik = $progress_fisik_output / $paket->num_rows();

										// filter flag warna prog fisik (merah kuning hijau biru)
										if($progress_fisik_output <= 50 ){
											$merah += 1;
										}elseif($progress_fisik_output >= 51 && $progress_fisik_output <= 75){
											$kuning += 1;
										}elseif($progress_fisik_output >= 76 && $progress_fisik_output <= 100){
											$hijau += 1;
										}elseif($progress_fisik_output > 100){
											$biru += 1;
										}
									}
									else {
										$progress_fisik = 0;
									}
									$progress_satker += $progress_fisik;
								}
							}
						}

						$count_kegiatan = $this->lmm->cek_kegiatan_terisi($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram);
						if ($count_kegiatan > 0) {
							$progress_satker = $progress_satker / $count_kegiatan;
						}
						else {
							$progress_satker = 0;
						}
						
					}
				}
				//filter warna prog fisik
				$row['merah'] = $merah;
				$row['kuning'] = $kuning;
				$row['hijau'] = $hijau;
				$row['biru'] = $biru;
				$row['prog'] = round($progress_satker,1).'%';
				$progress_satker = 0;
				
				$row['name'] = $row['NMUNIT'];
				$jumlah_paket = $this->dm->get_skmpnen_by_unit($thang, $row['KDUNIT'])->num_rows;
				$row['paket'] = $jumlah_paket.' OUTPUT';
				$row['state'] = $this->has_provinsi($row['KDUNIT']) ? 'closed' : 'open';
				array_push($result, $row);
			}
			echo json_encode($result);
		}
	}
	
	function has_provinsi ($kdunit){
		$cek = $this->dm->get_prov_by_unit($kdunit);
		return $cek->num_rows() > 0 ? true : false;
	}
	
	function getProv($kdunit, $thang, $pagu_total){
		$thang = $this->session->userdata('thn_anggaran');
		$kdunit = $this->session->userdata('kdunit');
		$bulan = date("n")-1;
		
		// pagu total unit utama
		$pagu_total = 0;
		$pagu_total += $this->dum->get_pagu_total_swakelola($thang, $kdunit)->row()->jumlah;
		$pagu_total += $this->dum->get_pagu_total_kontraktual($thang, $kdunit)->row()->nilaikontrak;
		
		
		$result = array();
		$records = $this->dum->get_provinsi();
		foreach($records->result_array() as $row){
			$row['id'] = 'prop#'.$kdunit.'#'.$row['KodeProvinsi'].'#'.$thang.'#'.$pagu_total;
			
			$jns = $this->dum->get_jnssat_by_prov($kdunit, $row['KodeProvinsi']);
			foreach($jns->result_array() as $row2){
				
				$pagu_jnssat = 0;
				$merah = 0;
				$kuning = 0;
				$hijau = 0;
				$biru = 0;
				$fisik_jnssat = 0;
				$fisik = 0;
				$pagu_progress = 0;
				
				$kegiatan = $this->dum->get_kegiatan_by_satker($row2['kdunit'], $row2['kdlokasi'], $row2['kdsatker'], $thang);
				$progress_satker=0;
				$count_kegiatan=0;
				foreach($kegiatan->result() as $data_kegiatan){//8
					$kdjendok = $data_kegiatan->kdjendok;
					$kddept = $data_kegiatan->kddept;
					$kdprogram = $data_kegiatan->kdprogram;
					$kdoutput = $data_kegiatan->kdoutput;
					$kdlokasi = $data_kegiatan->kdlokasi;
					$kdkabkota = $data_kegiatan->kdkabkota;
					$kddekon = $data_kegiatan->kddekon;
					$kdsoutput = $data_kegiatan->kdsoutput;
					$kdgiat = $data_kegiatan->kdgiat;
					$kdsatker = $data_kegiatan->kdsatker;

					$progress_fisik = 0;
					//$progress_fisik_output = 0;
					$progress_fisik_total = 0;
					$count_progress_fisik = 0;
					$paket = $this->dum->get_suboutput_by_satker($data_kegiatan->kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang);
					foreach($paket->result() as $pk){//ini menampilkan outputnya
						$kdjendok_paket = $pk->kdjendok;
						$kddept_paket = $pk->kddept;
						$kdprogram_paket = $pk->kdprogram;
						$kdoutput_paket = $pk->kdoutput;
						$kdlokasi_paket = $pk->kdlokasi;
						$kdkabkota_paket = $pk->kdkabkota;
						$kddekon_paket = $pk->kddekon;
						$kdsoutput_paket = $pk->kdsoutput;
						$kdgiat_paket = $pk->kdgiat;
						//ngecek apakah input laporan sudah diisi atau belom
						$cek_paket = $this->lmm->cek_paket_by_kdoutput($thang, $kdjendok_paket, $kdsatker, $kddept_paket, $kdunit, $kdprogram_paket, $kdgiat_paket, $kdoutput_paket, $kdlokasi_paket, $kdkabkota_paket, $kddekon_paket, $kdsoutput_paket);
						if ($cek_paket->num_rows > 0) {
							foreach ($cek_paket->result() as $row2) {//ini hasilnya cuman 1
								$idpaket = $row2->idpaket;
							}
							//PROGRESS FISIK
							if($this->lmm->get_progress_by_idpaket($idpaket)->num_rows() > 0) {
								//ambil progress fisik tiap bulan per output
								$progress_fisik_output = $this->lmm->get_progress_by_idpaket_and_month($idpaket,date("m"))->row()->progress;
								$progress_fisik = $progress_fisik_output / $paket->num_rows();

								// filter flag warna prog fisik (merah kuning hijau biru)
								if($progress_fisik_output <= 50 ){
									$merah += 1;
								}elseif($progress_fisik_output >= 51 && $progress_fisik_output <= 75){
									$kuning += 1;
								}elseif($progress_fisik_output >= 76 && $progress_fisik_output <= 100){
									$hijau += 1;
								}elseif($progress_fisik_output > 100){
									$biru += 1;
								}
							}
							else {
								$progress_fisik = 0;
							}
							$progress_satker += $progress_fisik;
						}
					}
				}

				$count_kegiatan = $this->lmm->cek_kegiatan_terisi($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram);
				if ($count_kegiatan > 0) {
					$progress_satker = $progress_satker / $count_kegiatan;
				}
				else {
					$progress_satker = 0;
				}
				
			}
				
			//filter warna prog fisik
			$row['merah'] = $merah;
			$row['kuning'] = $kuning;
			$row['hijau'] = $hijau;
			$row['biru'] = $biru;
			$row['prog'] = round($progress_satker,1).'%';
			$progress_satker = 0;
			
			$row['name'] = $row['NamaProvinsi'];
			$jumlah_paket = $this->dum->count_output_by_prov($kdunit, $row['KodeProvinsi'], $thang);
			$row['paket'] = $jumlah_paket.' OUTPUT';
			$row['state'] = $this->has_jnssat($kdunit, $row['KodeProvinsi'],$thang) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	function has_jnssat($kdunit, $kdlokasi, $thang)
	{
		$cek = $this->dum->get_jnssat_by_prov($kdunit, $kdlokasi);
		return $cek->num_rows() > 0 ? true : false;
	}
	
	function getJnssat($kdunit, $kdlokasi, $thang, $pagu_total)
	{
		$bulan = date("n")-1;
		$result = array();
		$records = $this->dum->get_jnssat_by_prov($kdunit, $kdlokasi);
		foreach($records->result_array() as $row){
			$row['id'] = 'jnssat#'.$kdunit.'#'.$kdlokasi.'#'.$row['kdjnssat'].'#'.$thang.'#'.$pagu_total;
			
			$pagu_jnssat = 0;
			$merah = 0;
			$kuning = 0;
			$hijau = 0;
			$biru = 0;
			$fisik_jnssat = 0;
			$fisik = 0;
			$pagu_progress = 0;
			
			$kegiatan = $this->dum->get_kegiatan_by_satker($row['kdunit'], $row['kdlokasi'], $row['kdsatker'], $thang);
			$progress_satker=0;
			$count_kegiatan=0;
			foreach($kegiatan->result() as $data_kegiatan){//8
				$kdjendok = $data_kegiatan->kdjendok;
				$kddept = $data_kegiatan->kddept;
				$kdprogram = $data_kegiatan->kdprogram;
				$kdoutput = $data_kegiatan->kdoutput;
				$kdlokasi = $data_kegiatan->kdlokasi;
				$kdkabkota = $data_kegiatan->kdkabkota;
				$kddekon = $data_kegiatan->kddekon;
				$kdsoutput = $data_kegiatan->kdsoutput;
				$kdgiat = $data_kegiatan->kdgiat;
				$kdsatker = $data_kegiatan->kdsatker;

				$progress_fisik = 0;
				//$progress_fisik_output = 0;
				$progress_fisik_total = 0;
				$count_progress_fisik = 0;
				$paket = $this->dum->get_suboutput_by_satker($data_kegiatan->kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang);
				foreach($paket->result() as $pk){//ini menampilkan outputnya
					$kdjendok_paket = $pk->kdjendok;
					$kddept_paket = $pk->kddept;
					$kdprogram_paket = $pk->kdprogram;
					$kdoutput_paket = $pk->kdoutput;
					$kdlokasi_paket = $pk->kdlokasi;
					$kdkabkota_paket = $pk->kdkabkota;
					$kddekon_paket = $pk->kddekon;
					$kdsoutput_paket = $pk->kdsoutput;
					$kdgiat_paket = $pk->kdgiat;
					//ngecek apakah input laporan sudah diisi atau belom
					$cek_paket = $this->lmm->cek_paket_by_kdoutput($thang, $kdjendok_paket, $kdsatker, $kddept_paket, $kdunit, $kdprogram_paket, $kdgiat_paket, $kdoutput_paket, $kdlokasi_paket, $kdkabkota_paket, $kddekon_paket, $kdsoutput_paket);
					if ($cek_paket->num_rows > 0) {
						foreach ($cek_paket->result() as $row2) {//ini hasilnya cuman 1
							$idpaket = $row2->idpaket;
						}
						//PROGRESS FISIK
						if($this->lmm->get_progress_by_idpaket($idpaket)->num_rows() > 0) {
							//ambil progress fisik tiap bulan per output
							$progress_fisik_output = $this->lmm->get_progress_by_idpaket_and_month($idpaket,date("m"))->row()->progress;

							$progress_fisik = $progress_fisik_output / $paket->num_rows();

							// filter flag warna prog fisik (merah kuning hijau biru)
							if($progress_fisik_output <= 50 ){
								$merah += 1;
							}elseif($progress_fisik_output >= 51 && $progress_fisik_output <= 75){
								$kuning += 1;
							}elseif($progress_fisik_output >= 76 && $progress_fisik_output <= 100){
								$hijau += 1;
							}elseif($progress_fisik_output > 100){
								$biru += 1;
							}
						}
						else {
							$progress_fisik = 0;
						}
						$progress_satker += $progress_fisik;
					}
				}
			}

			$count_kegiatan = $this->lmm->cek_kegiatan_terisi($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram);
			if ($count_kegiatan > 0) {
				$progress_satker = $progress_satker / $count_kegiatan;
			}
			else {
				$progress_satker = 0;
			}
			
			//filter warna prog fisik
			$row['merah'] = $merah;
			$row['kuning'] = $kuning;
			$row['hijau'] = $hijau;
			$row['biru'] = $biru;
			$row['prog'] = round($progress_satker,1).'%';
			$progress_satker = 0;
			
			$row['name'] = $row['nmjnssat'];
			$jumlah_paket = $this->dum->count_output_by_jnssat($kdunit, $kdlokasi, $row['kdjnssat'], $thang);
			$row['paket'] = $jumlah_paket.' OUTPUT';
			$row['state'] = $this->has_satker($kdunit, $kdlokasi, $row['kdjnssat'], $thang) ? 'closed' : 'open';
			array_push($result, $row);
			
		}
		echo json_encode($result);
	}
	
	function has_satker($kdunit, $kdlokasi, $kdjnssat, $thang)
	{
		$cek = $this->dum->get_satker_by_jnssat($kdunit, $kdlokasi, $kdjnssat);
		return $cek->num_rows() > 0 ? true : false;
	}

	function getNewSatker($kdunit, $kdlokasi, $kdjnssat, $thang, $pagu_total)
	{
		$bulan = date("n")-1;
		$result = array();
		$records = $this->dum->get_satker_by_jnssat($kdunit, $kdlokasi, $kdjnssat);
		
		foreach($records->result_array() as $row){
			$row['id'] = 'satker#'.$kdunit.'#'.$kdlokasi.'#'.$row['kdsatker'].'#'.$thang.'#'.$pagu_total;
			$kdsatker = $row['kdsatker'];
			$pagu_satker = 0;
			$merah = 0;
			$kuning = 0;
			$hijau = 0;
			$biru = 0;
			
			$fisik_satker=0;
			
			$kegiatan = $this->dum->get_kegiatan_by_satker($row['kdunit'], $row['kdlokasi'], $row['kdsatker'], $thang);
			$progress_satker=0;
			$count_kegiatan=0;
			foreach($kegiatan->result() as $data_kegiatan){//8
				$kdjendok = $data_kegiatan->kdjendok;
				$kddept = $data_kegiatan->kddept;
				$kdprogram = $data_kegiatan->kdprogram;
				$kdoutput = $data_kegiatan->kdoutput;
				$kdlokasi = $data_kegiatan->kdlokasi;
				$kdkabkota = $data_kegiatan->kdkabkota;
				$kddekon = $data_kegiatan->kddekon;
				$kdsoutput = $data_kegiatan->kdsoutput;
				$kdgiat = $data_kegiatan->kdgiat;

				$progress_fisik = 0;
				//$progress_fisik_output = 0;
				$progress_fisik_total = 0;
				$count_progress_fisik = 0;
				$paket = $this->dum->get_suboutput_by_satker($data_kegiatan->kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang);
				foreach($paket->result() as $pk){//ini menampilkan outputnya
					$kdjendok_paket = $pk->kdjendok;
					$kddept_paket = $pk->kddept;
					$kdprogram_paket = $pk->kdprogram;
					$kdoutput_paket = $pk->kdoutput;
					$kdlokasi_paket = $pk->kdlokasi;
					$kdkabkota_paket = $pk->kdkabkota;
					$kddekon_paket = $pk->kddekon;
					$kdsoutput_paket = $pk->kdsoutput;
					$kdgiat_paket = $pk->kdgiat;
					//ngecek apakah input laporan sudah diisi atau belom
					$cek_paket = $this->lmm->cek_paket_by_kdoutput($thang, $kdjendok_paket, $kdsatker, $kddept_paket, $kdunit, $kdprogram_paket, $kdgiat_paket, $kdoutput_paket, $kdlokasi_paket, $kdkabkota_paket, $kddekon_paket, $kdsoutput_paket);
					if ($cek_paket->num_rows > 0) {
						foreach ($cek_paket->result() as $row2) {//ini hasilnya cuman 1
							$idpaket = $row2->idpaket;
						}
						//PROGRESS FISIK
						if($this->lmm->get_progress_by_idpaket($idpaket)->num_rows() > 0) {
							//ambil progress fisik tiap bulan per output
							$progress_fisik_output = $this->lmm->get_progress_by_idpaket_and_month($idpaket,date("m"))->row()->progress;
							/*//hitung jumlah total output per kegiatan
							$count_progress_fisik = $paket->num_rows();
							//menjumlahkan semua progress fisik
							$progress_fisik_total += $progress_fisik_output;
							//hasil akhirnya
							$progress_fisik = $progress_fisik_total / $count_progress_fisik;*/

							$progress_fisik = $progress_fisik_output / $paket->num_rows();

							// filter flag warna prog fisik (merah kuning hijau biru)
							if($progress_fisik_output <= 50 ){
								$merah += 1;
							}elseif($progress_fisik_output >= 51 && $progress_fisik_output <= 75){
								$kuning += 1;
							}elseif($progress_fisik_output >= 76 && $progress_fisik_output <= 100){
								$hijau += 1;
							}elseif($progress_fisik_output > 100){
								$biru += 1;
							}
						}
						else {
							$progress_fisik = 0;
						}
						$progress_satker += $progress_fisik;
					}
				}
			}

			$count_kegiatan = $this->lmm->cek_kegiatan_terisi($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram);
			if ($count_kegiatan > 0) {
				$progress_satker = $progress_satker / $count_kegiatan;
			}
			else {
				$progress_satker = 0;
			}
			
			//filter warna prog fisik
			$row['merah'] = $merah;
			$row['kuning'] = $kuning;
			$row['hijau'] = $hijau;
			$row['biru'] = $biru;
			$row['prog'] = round($progress_satker,1).'%';
			$progress_satker=0;
			
			$row['name'] = $row['nmsatker'];
			$jumlah_paket = $this->dum->count_output_by_satker($kdunit, $kdlokasi, $row['kdsatker'], $thang);
			$row['paket'] = $jumlah_paket.' OUTPUT';
			$row['state'] = $this->has_kegiatan($kdunit, $kdlokasi, $row['kdsatker'], $thang) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	function has_kegiatan($kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$rs =  $this->dum->get_kegiatan_by_satker($kdunit, $kdlokasi, $kdsatker, $thang);
		return $rs->num_rows() > 0 ? true : false;
	}
	
	function getKegiatan($kdunit, $kdlokasi, $kdsatker, $thang, $pagu_total)
	{
		$bulan = date("n")-1;
		$result = array();
		$records = $this->dum->get_kegiatan_by_satker($kdunit, $kdlokasi, $kdsatker, $thang);
		foreach($records->result_array() as $row){
			$row['id'] = 'kegiatan#'.$row['kdgiat'].'#'.$row['kdunit'].'#'.$row['kdlokasi'].'#'.$row['kdsatker'].'#'.$thang.'#'.$pagu_total;
			
			$pagu_skmp = 0;
			$merah = 0;
			$kuning = 0;
			$hijau = 0;
			$biru = 0;
			$fisik_skmp = 0;
			$fisik = 0;
			$pagu_progress = 0;
			
			$progress_fisik = 0;
			$progress_fisik_output = 0;
			$progress_fisik_total = 0;
			$count_progress_fisik = 0;
			$paket = $this->dum->get_suboutput_by_satker($row['kdgiat'], $kdunit, $kdlokasi, $kdsatker, $thang);
			foreach($paket->result() as $pk){
				$kdjendok = $pk->kdjendok;
				$kddept = $pk->kddept;
				$kdprogram = $pk->kdprogram;
				$kdoutput = $pk->kdoutput;
				$kdlokasi = $pk->kdlokasi;
				$kdkabkota = $pk->kdkabkota;
				$kddekon = $pk->kddekon;
				$kdsoutput = $pk->kdsoutput;
				$kdgiat = $pk->kdgiat;
				//ngecek apakah input laporan sudah diisi atau belom
				$cek_paket = $this->lmm->cek_paket_by_kdoutput($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kddekon, $kdsoutput);
				if ($cek_paket->num_rows > 0) {
					foreach ($cek_paket->result() as $row2) {
						$idpaket = $row2->idpaket;
					}
					//PROGRESS FISIK
					if($this->lmm->get_progress_by_idpaket($idpaket)->num_rows() > 0) {
						//ambil progress fisik tiap bulan per output
						$progress_fisik_output = $this->lmm->get_progress_by_idpaket_and_month($idpaket,date("m"))->row()->progress;
						//hitung jumlah total output per kegiatan
						$count_progress_fisik = $paket->num_rows();
						//menjumlahkan semua progress fisik
						$progress_fisik_total += $progress_fisik_output;
						//hasil akhirnya
						$progress_fisik = $progress_fisik_total / $count_progress_fisik;
						if($progress_fisik <= 50 ){
							$merah += 1;
						}elseif($progress_fisik >= 51 && $progress_fisik <= 75){
							$kuning += 1;
						}elseif($progress_fisik >= 76 && $progress_fisik <= 100){
							$hijau += 1;
						}elseif($progress_fisik > 100){
							$biru += 1;
						}
					}
					else {
						$progress_fisik = 0;
					}
				}
			}
			
			if($pagu_progress > 0 && $pagu_total > 0) {
				// realisasi fisik unit utama per jenis satker
				$fisik = $pagu_progress / $pagu_total;
			}
			
			//filter warna prog fisik
			$row['merah'] = $merah;
			$row['kuning'] = $kuning;
			$row['hijau'] = $hijau;
			$row['biru'] = $biru;
			//$row['prog'] = round($fisik, 2).'%';
			$row['prog'] = $progress_fisik.'%';
			
			$row['name'] = strtoupper($row['nmgiat']);
			$row['paket'] = 'Program : '.$row['kdprogram'];
			$row['state'] = $this->has_output($row['kdgiat'], $kdunit, $kdlokasi, $row['kdsatker'], $thang) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}

	function has_output($kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$rs =  $this->dm->get_suboutput_by_satker($kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang);
		return $rs->num_rows() > 0 ? true : false;
	}

	function getOutput($kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$bulan = date("n")-1;
		$result = array();
		$records = $this->dum->get_suboutput_by_satker($kdgiat, $kdunit, $kdlokasi, $kdsatker, $thang);
		foreach($records->result_array() as $row){
			$progress_fisik = 0;
			$merah = 0;
			$kuning = 0;
			$hijau = 0;
			$biru = 0;

			$row['id'] = 'output#'.$kdunit.'#'.$kdlokasi.'#'.$kdsatker.'#'.$row['kdsoutput'].'#'.$thang;
			$kdjendok = $row['kdjendok'];
			$kddept = $row['kddept'];
			$kdprogram = $row['kdprogram'];
			$kdoutput = $row['kdoutput'];
			$kdlokasi = $row['kdlokasi'];
			$kdkabkota = $row['kdkabkota'];
			$kddekon = $row['kddekon'];
			$kdsoutput = $row['kdsoutput'];

			//ngecek apakah input laporan sudah diisi atau belom
			$cek_paket = $this->lmm->cek_paket_by_kdoutput($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kddekon, $kdsoutput);
			if ($cek_paket->num_rows > 0) {
				foreach ($cek_paket->result() as $row2) {
					$idpaket = $row2->idpaket;
				}
				//PROGRESS FISIK
				if($this->lmm->get_progress_by_idpaket($idpaket)->num_rows() > 0) {
					$progress_fisik = $this->lmm->get_progress_by_idpaket_and_month($idpaket,date("m"))->row()->progress;
					if($progress_fisik <= 50 ){
						$merah += 1;
					}elseif($progress_fisik >= 51 && $progress_fisik <= 75){
						$kuning += 1;
					}elseif($progress_fisik >= 76 && $progress_fisik <= 100){
						$hijau += 1;
					}elseif($progress_fisik > 100){
						$biru += 1;
					}
				}
				else {
					$progress_fisik = 0;
				}
			}
			
			
			//filter warna prog fisik
			$row['merah'] = $merah;
			$row['kuning'] = $kuning;
			$row['hijau'] = $hijau;
			$row['biru'] = $biru;
			//$row['prog'] = round($fisik, 2).'%';
			$row['prog'] = $progress_fisik.'%';
			
			$row['name'] = '['.$row['kdprogram'].'-'.$row['kdgiat'].'-'.$row['kdoutput'].'-'.$row['kdsoutput'].'] '.$row['ursoutput'];
			$row['paket'] = 'Kegiatan : '.$row['kdgiat'];
			$row['state'] = 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	// function has_paket($kdunit, $kdlokasi, $kdsatker, $thang)
	// {
	// 	$rs =  $this->dm->get_subkomponen_by_satker($kdunit, $kdlokasi, $kdsatker, $thang);
	// 	return $rs->num_rows() > 0 ? true : false;
	// }
	
	// function getPaket($kdunit, $kdlokasi, $kdsatker, $thang, $pagu_total)
	// {
	// 	$bulan = date("n")-1;
	// 	$result = array();
	// 	$records = $this->dm->get_subkomponen_by_satker($kdunit, $kdlokasi, $kdsatker, $thang);
	// 	foreach($records->result_array() as $row){
	// 		$row['id'] = 'paket#'.$kdunit.'#'.$kdlokasi.'#'.$kdsatker.'#'.$row['kdskmpnen'].'#'.$thang.'#'.$pagu_total;
			
	// 		$pagu_skmp = 0;
	// 		$merah = 0;
	// 		$kuning = 0;
	// 		$hijau = 0;
	// 		$biru = 0;
	// 		$fisik_skmp = 0;
	// 		$fisik = 0;
	// 		$pagu_progress = 0;
			
	// 		// pagu total unit utama per jenis satker provinsi
	// 		$pagu_skmp += $this->dm->get_pagu_skmp_swakelola($thang, $row['kdjendok'], $kdsatker, $row['kddept'], $kdunit, $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen'])->row()->jumlah;
	// 		$pagu_skmp += $this->dm->get_pagu_skmp_kontraktual($thang, $row['kdjendok'], $kdsatker, $row['kddept'], $kdunit, $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen'])->row()->nilaikontrak;
			
	// 		$pagu_swakelola = 0;
	// 		$pagu_kontraktual = 0;
	// 		$prog_fis_swakelola = 0;
	// 		$prog_fis_kontraktual = 0;
	// 		 if($pagu_skmp > 0){
	// 			$paket = $this->dm->get_paket($thang, $row['kdjendok'], $row['kdsatker'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen']);
	// 			if($paket->num_rows() > 0) {
	// 				foreach($paket->result() as $pk){
	// 					$pagu_swakelola = $this->dm->get_swakelola($pk->idpaket)->row()->jumlah;
	// 					$pagu_kontraktual = $this->dm->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
						
	// 					//mengambil nilai progress fisik paket per bulan
	// 					if(isset($this->dm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
	// 						$prog_fis_swakelola = $this->dm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
	// 					if(isset($this->dm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
	// 						$prog_fis_kontraktual = $this->dm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
	// 				}
	// 			}
	// 			if($prog_fis_swakelola > 0 && $prog_fis_kontraktual > 0) {
	// 				$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
	// 				// realisasi fisik komponen unit utama per jenis satker per provinsi
	// 				$fisik_skmp = ($prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual) / $pagu_skmp;
	// 			}
	// 		  }	
	// 		// filter flag warna prog fisik (merah kuning hijau biru)
	// 		if($fisik_skmp <= 50 ){
	// 			$merah += 1;
	// 		}elseif($fisik_skmp >= 51 && $fisik_skmp <= 75){
	// 			$kuning += 1;
	// 		}elseif($fisik_skmp >= 76 && $fisik_skmp <= 100){
	// 			$hijau += 1;
	// 		}elseif($fisik_skmp > 100){
	// 			$biru += 1;
	// 		}
			
	// 		if($pagu_progress > 0 && $pagu_total > 0) {
	// 			// realisasi fisik unit utama per jenis satker
	// 			$fisik = $pagu_progress / $pagu_total;
	// 		}
			
	// 		//filter warna prog fisik
	// 		$row['merah'] = $merah;
	// 		$row['kuning'] = $kuning;
	// 		$row['hijau'] = $hijau;
	// 		$row['biru'] = $biru;
	// 		$row['prog'] = round($fisik, 2).'%';
			
	// 		$row['name'] = '['.$row['kdgiat'].'.'.$row['kdoutput'].'.'.$row['kdsoutput'].'.'.$row['kdkmpnen'].'.'.$row['kdskmpnen'].'] '.$row['urskmpnen'];
	// 		$row['paket'] = 'Program : '.$row['kdprogram'];
	// 		$row['state'] = 'open';
	// 		array_push($result, $row);
	// 	}
	// 	echo json_encode($result);
	// }
	
	function main_grafik()
	{
		$data['thang'] = $this->session->userdata('thn_anggaran');
		$data['bulan'] = date("n")-1;
		$data['content'] = $this->load->view('e-monev/main_graph_dashboard',$data,true);
		$this->load->view('main',$data);
	}
	
	//grafik rencana fisik
	function grafik()
	{
		$records = $this->dm->get_unit_utama();
		$thang = $this->session->userdata('thn_anggaran');
		$bulan = date("n")-1;
		
		// pagu total se-kementerian
		$pagu_total = 0;
		$pagu_total += $this->dm->get_pagu_total_swakelola($thang)->row()->jumlah;
		$pagu_total += $this->dm->get_pagu_total_kontraktual($thang)->row()->nilaikontrak;

		//grafik kurva y
		$strXML = '';
		$strXML .= '<graph yAxisName=\'Presentase\' caption=\'Grafik Progress Fisik Pelaksanaan Paket\' subcaption=\'Tahun '.$this->session->userdata('thn_anggaran').'\' hovercapbg=\'FFECAA\' hovercapborder=\'F47E00\' formatNumberScale=\'0\' decimalPrecision=\'0\' showvalues=\'0\' numdivlines=\'5\' numVdivlines=\'0\' yaxisminvalue=\'1000\' yaxismaxvalue=\'100\'  rotateNames=\'1\' NumberSuffix=\'%25\'>';
		$strXML .= '<categories >';
		foreach ($records->result_array() as $data) {
			$strXML .= '<category name="'.$data['NMUNIT'].'" />';
		}
		$strXML .= '</categories>';

		//grafik kurva x
		$strXML .= '<dataset seriesName=\'Unit Utama\' color=\'F1683C\' anchorBorderColor=\'F1683C\' anchorBgColor=\'F1683C\'>';
		foreach($records->result_array() as $row)
		{
			$pagu_unit = 0;
			$fisik_unit = 0;
			$fisik = 0;
			$pagu_progress = 0;
			
			// pagu total unit utama per provinsi
			$pagu_unit += $this->dm->get_pagu_unit_swakelola($thang, $row['KDUNIT'])->row()->jumlah;
			$pagu_unit += $this->dm->get_pagu_unit_kontraktual($thang, $row['KDUNIT'])->row()->nilaikontrak;
			
			foreach($this->dm->get_skmpnen_by_unit($thang, $row['KDUNIT'])->result_array() as $row1){
				$kdskmpnen_ = $row1['kdskmpnen'];
				$kdskmpnen = str_replace(' ', '', $kdskmpnen_);

				$pagu_swakelola = 0;
				$pagu_kontraktual = 0;
				$prog_fis_swakelola = 0;
				$prog_fis_kontraktual = 0;
			  if($pagu_unit > 0){
				$paket = $this->dm->get_paket($thang, $row1['kdjendok'], $row1['kdsatker'], $row1['kddept'], $row1['kdunit'], $row1['kdprogram'], $row1['kdgiat'], $row1['kdoutput'], $row1['kdsoutput'], $row1['kdkmpnen'], $kdskmpnen);
				if($paket->num_rows() > 0) {
					foreach($paket->result() as $pk){
						$pagu_swakelola = $this->dm->get_swakelola($pk->idpaket)->row()->jumlah;
						$pagu_kontraktual = $this->dm->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
						
						//mengambil nilai progress fisik paket per bulan
						if(isset($this->dm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_swakelola = $this->dm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
						if(isset($this->dm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_kontraktual = $this->dm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
					}
				}
				if ($prog_fis_swakelola > 0 && $prog_fis_kontraktual > 0) {
					$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
					// realisasi fisik unit utama per provinsi
					$fisik = $pagu_progress / $pagu_total;
				}
			  }
			}
			$strXML .= '<set value="'.$fisik.'" />';
		}
		$strXML .= '</dataset>';
		$strXML .= '</graph>';
		$myFile = dirname(dirname(dirname(dirname(__FILE__)))).'/charts/testFile.xml';
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $strXML);
		fclose($fh);
		$graph = '<script type="text/javascript">
					   var chart = new FusionCharts("'.base_url().'charts/FCF_MSLine.swf", "ChartId", "900", "650");
					   chart.setDataURL("'.base_url().'charts/testFile.xml");		   
					   chart.render("chartdiv");
				  </script>';
		echo $graph;
	}
}
?>
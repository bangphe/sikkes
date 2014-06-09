<?php
class Dashboard_unit extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->model('e-planning/Manajemen_model','mm');
		$this->load->model('e-monev/dashboard_unit_model', 'dum');
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
		$kdunit = $this->session->userdata('kdunit');
		$data['nmunit'] = $this->mm->get_where('t_unit', 'kdunit', $kdunit)->row()->nmunit;
		$data['thang'] = $this->session->userdata('thn_anggaran');
		$data['content'] = $this->load->view('e-monev/dashboard_unit',$data,true);
		$this->load->view('main',$data);
	}
	
	function gridUnit()
	{
		//$id = '01';
		$thang = $this->session->userdata('thn_anggaran');
		if(isset($_POST['id'])) {
		 $kode = explode('#',$_POST['id']);
		 if($kode[0] == 'prop'){
			 $this->getJnssat($kode[1], $kode[2], $kode[3], $kode[4]);
		 }
		 if($kode[0] == 'jnssat'){
			 $this->getSatker($kode[1], $kode[2], $kode[3], $kode[4], $kode[5]);
		 }
		 if($kode[0] == 'satker'){
			 $this->getPaket($kode[1], $kode[2], $kode[3], $kode[4], $kode[5]);
		 }
		}
		else
		{
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
				
				$pagu_prov = 0;
				$merah = 0;
				$kuning = 0;
				$hijau = 0;
				$biru = 0;
				$fisik_prov = 0;
				$fisik = 0;
				$pagu_progress = 0;
				
				// pagu total unit utama per provinsi
				$pagu_prov += $this->dum->get_pagu_prov_swakelola($thang, $kdunit, $row['KodeProvinsi'])->row()->jumlah;
				$pagu_prov += $this->dum->get_pagu_prov_kontraktual($thang, $kdunit, $row['KodeProvinsi'])->row()->nilaikontrak;
				
				foreach($this->dum->get_skmpnen_by_provinsi($thang, $kdunit, $row['KodeProvinsi'])->result_array() as $row1){
					$pagu_swakelola = 0;
					$pagu_kontraktual = 0;
					$prog_fis_swakelola = 0;
					$prog_fis_kontraktual = 0;
				  if($pagu_prov > 0){
					$paket = $this->dum->get_paket($thang, $row1['kdjendok'], $row1['kdsatker'], $row1['kddept'], $row1['kdunit'], $row1['kdprogram'], $row1['kdgiat'], $row1['kdoutput'], $row1['kdsoutput'], $row1['kdkmpnen'], $row1['kdskmpnen']);
					if($paket->num_rows() > 0) {
						foreach($paket->result() as $pk){
							$pagu_swakelola = $this->dum->get_swakelola($pk->idpaket)->row()->jumlah;
							$pagu_kontraktual = $this->dum->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
							
							//mengambil nilai progress fisik paket per bulan
							if(isset($this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
								$prog_fis_swakelola = $this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
							if(isset($this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
								$prog_fis_kontraktual = $this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
						}
					}
					if($prog_fis_swakelola > 0 && $prog_fis_kontraktual > 0) {
						$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
						// realisasi fisik komponen unit utama per provinsi
						$fisik_prov = ($prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual) / $pagu_prov;
					}
				  }	
					// filter flag warna prog fisik (merah kuning hijau biru)
					if($fisik_prov <= 50 ){
						$merah += 1;
					}elseif($fisik_prov >= 51 && $fisik_prov <= 75){
						$kuning += 1;
					}elseif($fisik_prov >= 76 && $fisik_prov <= 100){
						$hijau += 1;
					}elseif($fisik_prov > 100){
						$biru += 1;
					}
				}
				
				if($pagu_progress > 0 && $pagu_total > 0) {
					// realisasi fisik unit utama per provinsi
					$fisik = $pagu_progress / $pagu_total;
				}
					
				//filter warna prog fisik
				$row['merah'] = $merah;
				$row['kuning'] = $kuning;
				$row['hijau'] = $hijau;
				$row['biru'] = $biru;
				$row['prog'] = round($fisik, 2).'%';
				
				$row['name'] = $row['NamaProvinsi'];
				$jumlah_paket = $this->dum->count_paket_by_prov($kdunit, $row['KodeProvinsi'], $thang);
				$row['paket'] = $jumlah_paket.' PKT';
				$row['state'] = $this->has_jnssat($kdunit, $row['KodeProvinsi'],$thang) ? 'closed' : 'open';
				array_push($result, $row);
			}
			echo json_encode($result);
		}
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
			
			// pagu total unit utama per jenis satker provinsi
			$pagu_jnssat += $this->dum->get_pagu_jnssat_swakelola($thang, $kdunit, $kdlokasi, $row['kdjnssat'])->row()->jumlah;
			$pagu_jnssat += $this->dum->get_pagu_jnssat_kontraktual($thang, $kdunit, $kdlokasi, $row['kdjnssat'])->row()->nilaikontrak;
			
			foreach($this->dum->get_skmpnen_by_jnssat($thang, $kdunit, $kdlokasi, $row['kdjnssat'])->result_array() as $row1){
				$pagu_swakelola = 0;
				$pagu_kontraktual = 0;
				$prog_fis_swakelola = 0;
				$prog_fis_kontraktual = 0;
			  if($pagu_jnssat > 0){
				$paket = $this->dum->get_paket($thang, $row1['kdjendok'], $row1['kdsatker'], $row1['kddept'], $row1['kdunit'], $row1['kdprogram'], $row1['kdgiat'], $row1['kdoutput'], $row1['kdsoutput'], $row1['kdkmpnen'], $row1['kdskmpnen']);
				if($paket->num_rows() > 0) {
					foreach($paket->result() as $pk){
						$pagu_swakelola = $this->dum->get_swakelola($pk->idpaket)->row()->jumlah;
						$pagu_kontraktual = $this->dum->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
						
						//mengambil nilai progress fisik paket per bulan
						if(isset($this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_swakelola = $this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
						if(isset($this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_kontraktual = $this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
					}
				}

				if($prog_fis_swakelola > 0 && $prog_fis_kontraktual > 0) {
					$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
					// realisasi fisik komponen unit utama per jenis satker per provinsi
					$fisik_jnssat = ($prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual) / $pagu_jnssat;
				}				
			  }	
				// filter flag warna prog fisik (merah kuning hijau biru)
				if($fisik_jnssat <= 50 ){
					$merah += 1;
				}elseif($fisik_jnssat >= 51 && $fisik_jnssat <= 75){
					$kuning += 1;
				}elseif($fisik_jnssat >= 76 && $fisik_jnssat <= 100){
					$hijau += 1;
				}elseif($fisik_jnssat > 100){
					$biru += 1;
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
			$row['prog'] = round($fisik, 2).'%';
			
			$row['name'] = $row['nmjnssat'];
			$jumlah_paket = $this->dum->count_paket_by_jnssat($kdunit, $kdlokasi, $row['kdjnssat'], $thang);
			$row['paket'] = $jumlah_paket.' PKT';
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
	
	function getSatker($kdunit, $kdlokasi, $kdjnssat, $thang, $pagu_total)
	{
		$bulan = date("n")-1;
		$result = array();
		$records = $this->dum->get_satker_by_jnssat($kdunit, $kdlokasi, $kdjnssat);
		
		foreach($records->result_array() as $row){
			$row['id'] = 'satker#'.$kdunit.'#'.$kdlokasi.'#'.$row['kdsatker'].'#'.$thang.'#'.$pagu_total;
			
			$pagu_satker = 0;
			$merah = 0;
			$kuning = 0;
			$hijau = 0;
			$biru = 0;
			$fisik_satker = 0;
			$fisik = 0;
			$pagu_progress = 0;
			
			// pagu total unit utama per jenis satker provinsi
			$pagu_satker += $this->dum->get_pagu_satker_swakelola($thang, $kdunit, $kdlokasi, $row['kdsatker'])->row()->jumlah;
			$pagu_satker += $this->dum->get_pagu_satker_kontraktual($thang, $kdunit, $kdlokasi, $row['kdsatker'])->row()->nilaikontrak;
			
			foreach($this->dum->get_skmpnen_by_satker($thang, $kdunit, $kdlokasi, $row['kdsatker'])->result_array() as $row1){
				$pagu_swakelola = 0;
				$pagu_kontraktual = 0;
				$prog_fis_swakelola = 0;
				$prog_fis_kontraktual = 0;
			  if($pagu_satker > 0){
				$paket = $this->dum->get_paket($thang, $row1['kdjendok'], $row1['kdsatker'], $row1['kddept'], $row1['kdunit'], $row1['kdprogram'], $row1['kdgiat'], $row1['kdoutput'], $row1['kdsoutput'], $row1['kdkmpnen'], $row1['kdskmpnen']);
				if($paket->num_rows() > 0) {
					foreach($paket->result() as $pk){
						$pagu_swakelola = $this->dum->get_swakelola($pk->idpaket)->row()->jumlah;
						$pagu_kontraktual = $this->dum->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
						
						//mengambil nilai progress fisik paket per bulan
						if(isset($this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_swakelola = $this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
						if(isset($this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_kontraktual = $this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
					}
				}

				if($prog_fis_swakelola > 0 && $prog_fis_kontraktual > 0) {
					$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
					// realisasi fisik komponen unit utama per jenis satker per provinsi
					$fisik_satker = ($prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual) / $pagu_satker;
				}
			  }	
				// filter flag warna prog fisik (merah kuning hijau biru)
				if($fisik_satker <= 50 ){
					$merah += 1;
				}elseif($fisik_satker >= 51 && $fisik_satker <= 75){
					$kuning += 1;
				}elseif($fisik_satker >= 76 && $fisik_satker <= 100){
					$hijau += 1;
				}elseif($fisik_satker > 100){
					$biru += 1;
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
			$row['prog'] = round($fisik, 2).'%';
			
			$row['name'] = $row['nmsatker'];
			$jumlah_paket = $this->dum->count_paket_by_satker($kdunit, $kdlokasi, $row['kdsatker'], $thang);
			$row['paket'] = $jumlah_paket.' PKT';
			$row['state'] = $this->has_paket($kdunit, $kdlokasi, $row['kdsatker'], $thang) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	function has_paket($kdunit, $kdlokasi, $kdsatker, $thang)
	{
		$rs =  $this->dum->get_subkomponen_by_satker($kdunit, $kdlokasi, $kdsatker, $thang);
		return $rs->num_rows() > 0 ? true : false;
	}
	
	function getPaket($kdunit, $kdlokasi, $kdsatker, $thang, $pagu_total)
	{
		$bulan = date("n")-1;
		$result = array();
		$records = $this->dum->get_subkomponen_by_satker($kdunit, $kdlokasi, $kdsatker, $thang);
		foreach($records->result_array() as $row){
			$row['id'] = 'paket#'.$kdunit.'#'.$kdlokasi.'#'.$kdsatker.'#'.$row['kdskmpnen'].'#'.$thang.'#'.$pagu_total;
			
			$pagu_skmp = 0;
			$merah = 0;
			$kuning = 0;
			$hijau = 0;
			$biru = 0;
			$fisik_skmp = 0;
			$fisik = 0;
			$pagu_progress = 0;
			
			// pagu total unit utama per jenis satker provinsi
			$pagu_skmp += $this->dum->get_pagu_skmp_swakelola($thang, $row['kdjendok'], $kdsatker, $row['kddept'], $kdunit, $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen'])->row()->jumlah;
			$pagu_skmp += $this->dum->get_pagu_skmp_kontraktual($thang, $row['kdjendok'], $kdsatker, $row['kddept'], $kdunit, $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen'])->row()->nilaikontrak;
			
			$pagu_swakelola = 0;
			$pagu_kontraktual = 0;
			$prog_fis_swakelola = 0;
			$prog_fis_kontraktual = 0;
			 if($pagu_skmp > 0){
				$paket = $this->dum->get_paket($thang, $row['kdjendok'], $row['kdsatker'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen']);
				if($paket->num_rows() > 0) {
					foreach($paket->result() as $pk){
						$pagu_swakelola = $this->dum->get_swakelola($pk->idpaket)->row()->jumlah;
						$pagu_kontraktual = $this->dum->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
						
						//mengambil nilai progress fisik paket per bulan
						if(isset($this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_swakelola = $this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
						if(isset($this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_kontraktual = $this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
					}
				}

				if($prog_fis_swakelola > 0 && $prog_fis_kontraktual > 0) {
					$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
					// realisasi fisik komponen unit utama per jenis satker per provinsi
					$fisik_skmp = ($prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual) / $pagu_skmp;
				}
			  }	
			// filter flag warna prog fisik (merah kuning hijau biru)
			if($fisik_skmp <= 50 ){
				$merah += 1;
			}elseif($fisik_skmp >= 51 && $fisik_skmp <= 75){
				$kuning += 1;
			}elseif($fisik_skmp >= 76 && $fisik_skmp <= 100){
				$hijau += 1;
			}elseif($fisik_skmp > 100){
				$biru += 1;
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
			$row['prog'] = round($fisik, 2).'%';
			
			$row['name'] = '['.$row['kdgiat'].'.'.$row['kdoutput'].'.'.$row['kdsoutput'].'.'.$row['kdkmpnen'].'.'.$row['kdskmpnen'].'] '.$row['urskmpnen'];
			$row['paket'] = 'Program : '.$row['kdprogram'];
			$row['state'] = 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}

	function main_grafik()
	{
		$data['thang'] = $this->session->userdata('thn_anggaran');
		$data['bulan'] = date("n")-1;
		$data['content'] = $this->load->view('e-monev/main_graph_dashboard_unit',$data,true);
		$this->load->view('main',$data);
	}
	
	//grafik rencana fisik
	function grafik()
	{
		$records = $this->dum->get_provinsi();
		$thang = $this->session->userdata('thn_anggaran');
		$kdunit = $this->session->userdata('kdunit');
		$bulan = date("n")-1;
		// pagu total unit utama
		$pagu_total = 0;
		$pagu_total += $this->dum->get_pagu_total_swakelola($thang, $kdunit)->row()->jumlah;
		$pagu_total += $this->dum->get_pagu_total_kontraktual($thang, $kdunit)->row()->nilaikontrak;

		//grafik kurva y
		$strXML = '';
		$strXML .= '<graph yAxisName=\'Presentase\' caption=\'Grafik Progress Fisik Pelaksanaan Paket\' subcaption=\'Tahun '.$this->session->userdata('thn_anggaran').'\' hovercapbg=\'FFECAA\' hovercapborder=\'F47E00\' formatNumberScale=\'0\' decimalPrecision=\'0\' showvalues=\'0\' numdivlines=\'5\' numVdivlines=\'0\' yaxisminvalue=\'1000\' yaxismaxvalue=\'100\'  rotateNames=\'1\' NumberSuffix=\'%25\'>';
		$strXML .= '<categories >';
		foreach ($records->result_array() as $data) {
			$strXML .= '<category name="'.$data['NamaProvinsi'].'" />';
		}
		$strXML .= '</categories>';

		//grafik kurva x
		$strXML .= '<dataset seriesName=\'Propinsi\' color=\'F1683C\' anchorBorderColor=\'F1683C\' anchorBgColor=\'F1683C\'>';
		foreach($records->result_array() as $row)
		{
			$pagu_prov = 0;
			$fisik_prov = 0;
			$fisik = 0;
			$pagu_progress = 0;
			
			// pagu total unit utama per provinsi
			$pagu_prov += $this->dum->get_pagu_prov_swakelola($thang, $kdunit, $row['KodeProvinsi'])->row()->jumlah;
			$pagu_prov += $this->dum->get_pagu_prov_kontraktual($thang, $kdunit, $row['KodeProvinsi'])->row()->nilaikontrak;
			
			foreach($this->dum->get_skmpnen_by_provinsi($thang, $kdunit, $row['KodeProvinsi'])->result_array() as $row1){
				$pagu_swakelola = 0;
				$pagu_kontraktual = 0;
				$prog_fis_swakelola = 0;
				$prog_fis_kontraktual = 0;
			  if($pagu_prov > 0){
				$paket = $this->dum->get_paket($thang, $row1['kdjendok'], $row1['kdsatker'], $row1['kddept'], $row1['kdunit'], $row1['kdprogram'], $row1['kdgiat'], $row1['kdoutput'], $row1['kdsoutput'], $row1['kdkmpnen'], $row1['kdskmpnen']);
				if($paket->num_rows() > 0) {
					foreach($paket->result() as $pk){
						$pagu_swakelola = $this->dum->get_swakelola($pk->idpaket)->row()->jumlah;
						$pagu_kontraktual = $this->dum->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
						
						//mengambil nilai progress fisik paket per bulan
						if(isset($this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_swakelola = $this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
						if(isset($this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_kontraktual = $this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
					}
				}
				if($prog_fis_swakelola > 0 && $prog_fis_kontraktual > 0) {
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
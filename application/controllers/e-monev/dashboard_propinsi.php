<?php
class Dashboard_propinsi extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->model('e-planning/manajemen_model', 'mm');
		$this->load->model('e-monev/dashboard_propinsi_model','dpm');
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
		$prov = $this->mm->get_where('ref_provinsi','KodeProvinsi',$this->session->userdata('kodeprovinsi'));
		$data['thang'] = $this->session->userdata('thn_anggaran');
		$data['namaProv'] = $prov->row()->NamaProvinsi;
		$data['content'] = $this->load->view('e-monev/dashboard_prov',$data,true);
		$this->load->view('main',$data);
	}
	
	function gridSatker()
	{
		//$id = '01';
		$thang = $this->session->userdata('thn_anggaran');
		if(isset($_POST['id'])) {
		 $kode = explode('#',$_POST['id']);
		 if($kode[0] == 'satker'){
		 	$this->getPaket($kode[1], $kode[2], $kode[3], $kode[4]);
		 }
		}
		else
		{
			$kdlokasi = $this->session->userdata('kodeprovinsi');
			$bulan = date("n")-1;
			
			// pagu total provinsi
			$pagu_total = 0;
			$pagu_total += $this->dpm->get_pagu_prov_swakelola($thang, $kdlokasi)->row()->jumlah;
			$pagu_total += $this->dpm->get_pagu_prov_kontraktual($thang, $kdlokasi)->row()->nilaikontrak;
			
			$result = array();
			$records = $this->dpm->get_satker_by_propinsi();
			foreach($records->result_array() as $row){
				$row['id'] = 'satker#'.$row['kdlokasi'].'#'.$row['kdsatker'].'#'.$thang.'#'.$pagu_total;
			
				$pagu_satker = 0;
				$merah = 0;
				$kuning = 0;
				$hijau = 0;
				$biru = 0;
				$fisik_satker = 0;
				$fisik = 0;
				$pagu_progress = 0;
				
				// pagu total per satker
				$pagu_satker += $this->dpm->get_pagu_satker_swakelola($thang, $kdlokasi, $row['kdsatker'])->row()->jumlah;
				$pagu_satker += $this->dpm->get_pagu_satker_kontraktual($thang, $kdlokasi, $row['kdsatker'])->row()->nilaikontrak;
				
				foreach($this->dpm->get_skmpnen_by_satker($thang, $kdlokasi, $row['kdsatker'])->result_array() as $row1){
					$pagu_swakelola = 0;
					$pagu_kontraktual = 0;
					$prog_fis_swakelola = 0;
					$prog_fis_kontraktual = 0;
				  if($pagu_satker > 0){
					$paket = $this->dpm->get_paket($thang, $row1['kdjendok'], $row1['kdsatker'], $row1['kddept'], $row1['kdunit'], $row1['kdprogram'], $row1['kdgiat'], $row1['kdoutput'], $row1['kdsoutput'], $row1['kdkmpnen'], $row1['kdskmpnen']);
					if($paket->num_rows() > 0) {
						foreach($paket->result() as $pk){
							$pagu_swakelola = $this->dpm->get_swakelola($pk->idpaket)->row()->jumlah;
							$pagu_kontraktual = $this->dpm->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
							
							//mengambil nilai progress fisik paket per bulan
							if(isset($this->dpm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
								$prog_fis_swakelola = $this->dpm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
							if(isset($this->dpm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
								$prog_fis_kontraktual = $this->dpm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
						}
					}
					$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
					
					// realisasi fisik komponen unit utama per jenis satker per provinsi
					$fisik_satker = ($prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual) / $pagu_satker;
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
				
				// realisasi fisik unit utama per jenis satker
				$fisik = $pagu_progress / $pagu_total;
				
				//filter warna prog fisik
				$row['merah'] = $merah;
				$row['kuning'] = $kuning;
				$row['hijau'] = $hijau;
				$row['biru'] = $biru;
				$row['prog'] = round($fisik, 2).'%';
				
				$row['name'] = $row['nmsatker'].' (Unit: '.$row['kdunit'].')';
				$jumlah_paket = $this->dpm->get_skmpnen_by_satker($thang, $row['kdlokasi'], $row['kdsatker'],$thang);
				$row['paket'] = $jumlah_paket->num_rows().' PKT';
				
				$row['state'] = $this->has_paket($thang, $row['kdsatker']) ? 'closed' : 'open';
				array_push($result, $row);
			}
			echo json_encode($result);
		}
	}
	
	function has_paket($thang, $kdsatker)
	{
		$rs =  $this->dpm->get_skmpnen($thang, $kdsatker);
		return $rs->num_rows() > 0 ? true : false;
	}
	
	function getPaket($kdlokasi, $kdsatker, $thang, $pagu_total)
	{
		$bulan = date("n")-1;
		$result = array();
		$records = $this->dpm->get_skmpnen($thang, $kdsatker);
		foreach($records->result_array() as $row){
			$row['id'] = 'paket#'.$kdlokasi.'#'.$kdsatker.'#'.$row['kdskmpnen'].'#'.$thang;
			
			$pagu_skmp = 0;
			$merah = 0;
			$kuning = 0;
			$hijau = 0;
			$biru = 0;
			$fisik_skmp = 0;
			$fisik = 0;
			$pagu_progress = 0;
			
			// pagu total unit utama per jenis satker provinsi
			$pagu_skmp += $this->dpm->get_pagu_skmp_swakelola($thang, $row['kdjendok'], $kdsatker, $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen'])->row()->jumlah;
			$pagu_skmp += $this->dpm->get_pagu_skmp_kontraktual($thang, $row['kdjendok'], $kdsatker, $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen'])->row()->nilaikontrak;
			
			$pagu_swakelola = 0;
			$pagu_kontraktual = 0;
			$prog_fis_swakelola = 0;
			$prog_fis_kontraktual = 0;
			 if($pagu_skmp > 0){
				$paket = $this->dpm->get_paket($thang, $row['kdjendok'], $row['kdsatker'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen']);
				if($paket->num_rows() > 0) {
					foreach($paket->result() as $pk){
						$pagu_swakelola = $this->dpm->get_swakelola($pk->idpaket)->row()->jumlah;
						$pagu_kontraktual = $this->dpm->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
						
						//mengambil nilai progress fisik paket per bulan
						if(isset($this->dpm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_swakelola = $this->dum->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
						if(isset($this->dpm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
							$prog_fis_kontraktual = $this->dum->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
					}
				}
				$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
				
				// realisasi fisik komponen unit utama per jenis satker per provinsi
				$fisik_skmp = ($prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual) / $pagu_skmp;
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
			
			// realisasi fisik unit utama per jenis satker
			$fisik = $pagu_progress / $pagu_total;
			
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
	
}
?>
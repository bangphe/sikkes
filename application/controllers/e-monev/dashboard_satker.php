<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_satker extends CI_Controller 
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->model('e-planning/Manajemen_model','mm');
		$this->load->model('e-monev/dashboard_satker_model','dsm');
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
		$this->satker();
	}
	
	function satker(){
		$data['kdsatker'] = $this->session->userdata('kdsatker');
		$data['thang'] = $this->session->userdata('thn_anggaran');
		$data['nmsatker'] = $this->mm->get_where('ref_satker', 'kdsatker', $data['kdsatker'])->row()->nmsatker;
		
	    $data2['content'] = $this->load->view('e-monev/dashboard_satker', $data, true);
		$this->load->view('main',$data2);
	}
	
	function gridSatker()
	{
		$result = array();
		//$records = $this->dsm->get_skmpnen_by_satker($this->session->userdata('kdsatker'), $this->session->userdata('thn_anggaran'));
		$records = $this->dsm->get_soutput_by_satker($this->session->userdata('kdsatker'), $this->session->userdata('thn_anggaran'));
		$bulan = date("n")-1;
		
		//total anggaran semua paket satker
		$pagu_total = 0;
		$pagu_total += $this->dsm->get_pagu_total_swakelola($this->session->userdata('thn_anggaran'), $this->session->userdata('kdsatker'))->row()->jumlah;
		$pagu_total += $this->dsm->get_pagu_total_kontraktual($this->session->userdata('thn_anggaran'), $this->session->userdata('kdsatker'))->row()->nilaikontrak;
			
		foreach($records->result_array() as $row){
			$giat = $this->dsm->get_keg($row['kdgiat']);
			$output = $this->dsm->get_output($row['kdgiat'],$row['kdoutput']);
			$soutput = $this->dsm->get_suboutput($row['kdprogram'],$row['kdgiat'],$row['kdoutput'],$row['kdsoutput']);
			$fisik = 0;
			
			$thang = $row['thang'];
			$kdjendok = $row['kdjendok'];
			$kdsatker = $row['kdsatker'];
			$kddept = $row['kddept'];
			$kdunit = $row['kdunit'];
			$kdprogram = $row['kdprogram'];
			$kdgiat = $row['kdgiat'];
			$kdoutput = $row['kdoutput'];
			$kdlokasi = $row['kdlokasi'];
			$kdkabkota = $row['kdkabkota'];
			$kddekon = $row['kddekon'];
			$kdsoutput = $row['kdsoutput'];

			$progress_fisik = 0;
			//ngecek apakah input laporan sudah diisi atau belom
			$cek_paket = $this->lmm->cek_paket_by_kdoutput($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kddekon, $kdsoutput);
			if ($cek_paket->num_rows > 0) {
				foreach ($cek_paket->result() as $row2) {
					$idpaket = $row2->idpaket;
					//PROGRESS FISIK
					if($this->lmm->get_progress_by_idpaket($idpaket)->num_rows() > 0) {
						$progress_fisik = $this->lmm->get_progress_by_idpaket_and_month($idpaket,date("m"))->row()->progress;
					}
					else {
						$progress_fisik = 0;
					}
				}
				
			}

			// $row['komponen'] = $row['urkmpnen'];
			// $row['subkomponen'] = $row['urskmpnen'];
			$row['paket'] = '['.$row['kdgiat'].'.'.$row['kdoutput'].'.'.$row['kdsoutput'].'] '.$row['ursoutput'];
			//$row['program'] = $row['kdprogram'];
			$row['keg'] = '['.$row['kdgiat'].'] '.$giat->row()->nmgiat;
			$row['output'] = '['.$row['kdoutput'].'] '.$output->row()->nmoutput;
			$row['suboutput'] = '['.$row['kdsoutput'].'] '.$soutput->row()->ursoutput;
			// $progress = $this->get_progress_skmpnen_by_kmpnen($row['d_skmpnen_id'],$row['thang']);
			$row['fisik']= $progress_fisik.'%';
			$row['state'] = 'open';
			array_push($result, $row);
		}
		
		echo json_encode($result);
	}

	function main_grafik()
	{
		$data['bulan'] = date("n")-1;
		$data['thang'] = $this->session->userdata('thn_anggaran');
		$data['kdsatker'] = $this->session->userdata('kdsatker');
		$data['nmsatker'] = $this->mm->get_where('ref_satker', 'kdsatker', $data['kdsatker'])->row()->nmsatker;
		$data['content'] = $this->load->view('e-monev/main_graph_dashboard_satker',$data,true);
		$this->load->view('main',$data);
	}
	
	//grafik rencana fisik
	function grafik()
	{
		$records = $this->dsm->get_skmpnen_by_satkers($this->session->userdata('kdsatker'), $this->session->userdata('thn_anggaran'));
		$bulan = date("n")-1;

		//total anggaran semua paket satker
		$pagu_total = 0;
		$pagu_total += $this->dsm->get_pagu_total_swakelola($this->session->userdata('thn_anggaran'), $this->session->userdata('kdsatker'))->row()->jumlah;
		$pagu_total += $this->dsm->get_pagu_total_kontraktual($this->session->userdata('thn_anggaran'), $this->session->userdata('kdsatker'))->row()->nilaikontrak;

		//grafik kurva y
		$strXML = '';
		$strXML .= '<graph yAxisName=\'Presentase\' caption=\'Grafik Rencana Fisik Pelaksanaan Paket\' subcaption=\'Tahun '.$this->session->userdata('thn_anggaran').'\' hovercapbg=\'FFECAA\' hovercapborder=\'F47E00\' formatNumberScale=\'0\' decimalPrecision=\'0\' showvalues=\'0\' numdivlines=\'5\' numVdivlines=\'0\' yaxisminvalue=\'1000\' yaxismaxvalue=\'100\'  rotateNames=\'1\' NumberSuffix=\'%25\'>';
		$strXML .= '<categories >';
		foreach ($records->result_array() as $data) {
			$strXML .= '<category name="'.$data['urskmpnen'].'" />';
		}
		$strXML .= '</categories>';

		//grafik kurva x
		$strXML .= '<dataset seriesName=\'Paket\' color=\'F1683C\' anchorBorderColor=\'F1683C\' anchorBgColor=\'F1683C\'>';		
		foreach($records->result_array() as $row)
		{
			$fisik = 0;
			//db server
			$kdskmpnen_ = $row['kdskmpnen'];
			$kdskmpnen = str_replace(' ', '', $kdskmpnen_);
			$pagu_swakelola = 0;
			$pagu_kontraktual = 0;
			$prog_fis_swakelola = 0;
			$prog_fis_kontraktual = 0;
			$pagu_progress = 0;
			// mengambil nilai anggaran per paket
			$paket = $this->dsm->get_paket($row['thang'], $row['kdjendok'], $row['kdsatker'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $kdskmpnen);
			if($paket->num_rows > 0)
			{
				foreach($paket->result() as $pk)
				{
					$pagu_swakelola = $this->dsm->get_swakelola($pk->idpaket)->row()->jumlah;
					$pagu_kontraktual = $this->dsm->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
					
					//mengambil nilai progress fisik paket per bulan
					if(isset($this->dsm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress))
						$prog_fis_swakelola = $this->dsm->get_progres_fisik_swakelola_per_bulan($pk->idpaket, $bulan)->row()->progress;
					if(isset($this->dsm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress))
						$prog_fis_kontraktual = $this->dsm->get_progres_fisik_kontraktual_per_bulan($pk->idpaket, $bulan)->row()->progress;
				}
				$fisik = $prog_fis_kontraktual;
			}
			if($prog_fis_swakelola > 0 && $prog_fis_kontraktual > 0) {
				$pagu_progress += $prog_fis_swakelola*$pagu_swakelola + $prog_fis_kontraktual*$pagu_kontraktual;
				// realisasi fisik unit utama per provinsi
				if($pagu_progress > 0 && $pagu_total > 0) {
					//$fisik = $pagu_progress / $pagu_total;
					$fisik = $prog_fis_kontraktual;
				}
			}
			$fisik = $prog_fis_kontraktual;
			
			$strXML .= '<set value="'.$fisik.'" />';
		}
			
		$strXML .= '</dataset>';
		$strXML .= '</graph>';
		$myFile = dirname(dirname(dirname(dirname(__FILE__)))).'/charts/testFile.xml';
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $strXML);
		fclose($fh);
		$graph = '<script type="text/javascript">
					   var chart = new FusionCharts("'.base_url().'charts/FCF_MSLine.swf", "ChartId", "1000", "750");
					   chart.setDataURL("'.base_url().'charts/testFile.xml");		   
					   chart.render("chartdiv");
				  </script>';
		echo $graph;
	}
}//end class

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */

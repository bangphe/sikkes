<?php
class Dashboard extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->model('e-planning/dashboard_model','dm');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
		if($kode_role == '1' ||$kode_role == '4' ||$kode_role == '5')
		{
			redirect('beranda/homepage');
		}
	}
	
	function index()
	{
		if($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 2)
			$this->view($this->session->userdata('kodeprovinsi'));
		elseif($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3)
			$this->view($this->session->userdata('kdunit'));
		else
			$this->grid();
	}
	
	function grid()
	{
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['name'] = array('Satker',350,TRUE,'left',1);
		$colModel['satker_jml'] = array('Jumlah Proposal</br>Dibuat',80,TRUE,'right',1);
		$colModel['satker_nil'] = array('Nilai Proposal</br>Dibuat',120,TRUE,'right',1);
		$colModel['diajukan_jml'] = array('Jumlah Proposal</br>Diajukan',80,TRUE,'right',1);
		$colModel['diajukan_nil'] = array('Nilai Proposal</br>Diajukan',120,TRUE,'right',1);
		$colModel['prov_jml'] = array('Jumlah Proposal</br>Direkomendasikan</br>Provinsi',80,TRUE,'right',1);
		$colModel['prov_nil'] = array('Nilai Proposal</br>Direkomendasikan</br>Provinsi',120,TRUE,'right',1);
		$colModel['dir_jml'] = array('Jumlah Proposal</br>Direkomendasikan</br>Direktorat',80,TRUE,'right',1);
		$colModel['dir_nil'] = array('Nilai Proposal</br>Direkomendasikan</br>Direktorat',120,TRUE,'right',1);
		$colModel['unit_jml'] = array('Jumlah Proposal</br>Direkomendasikan</br>Unit Utama',80,TRUE,'right',1);
		$colModel['unit_nil'] = array('Nilai Proposal</br>Direkomendasikan</br>Unit Utama',120,TRUE,'right',1);
		$colModel['setuju_jml'] = array('Jumlah Proposal</br>Disetujui',80,TRUE,'right',1);
		$colModel['setuju_nil'] = array('Nilai Proposal</br>Disetujui',120,TRUE,'right',1);
		$colModel['tolak_jml'] = array('Jumlah Proposal</br>Ditolak',80,TRUE,'right',1);
		$colModel['tolak_nil'] = array('Nilai Proposal</br>Ditolak',120,TRUE,'right',1);
		$colModel['timbang_jml'] = array('Jumlah Proposal</br>Dipertimbangkan',80,TRUE,'right',1);
		$colModel['timbang_nil'] = array('Nilai Proposal</br>Dipertimbangkan',120,TRUE,'right',1);
		
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '200',
			'rp' => 3,
			'rpOptions' => '[3]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'Dashboard Proposal',
			'nowrap' => false,
			'showTableToggleBtn' => false
		);
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/dashboard/list_grid/";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/dashboard/rekap_dashboard_proposal\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/print.png\" alt=\"\"/>
						Cetak
					</button>
					</form>
				</div>";
		$data['added_js'] = "";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['notification'] = "";
		if($this->session->userdata('notification')!=''){
			$data['notification'] = "
				<script>
					$(document).ready(function() {
						$.growlUI('Pesan :', '".$this->session->userdata('notification')."');
					});
				</script>
			";
		}//end if
		$data['judul'] = 'Dashboard Proposal';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_grid()
	{
		$thang = $this->session->userdata('thn_anggaran');	
		$valid_fields = array('name');
		$this->flexigrid->validate_post('','',$valid_fields);

		$this->output->set_header($this->config->item('json_header'));
		$record_items[]=array(
			1,
			1,
			'<a href="'.site_url().'/e-planning/dashboard/view/skpd">SKPD / Tugas Pembantuan</a>',
			$this->dm->get_proposal_skpd_satker($thang),
			'Rp '.number_format($this->dm->sum_proposal_skpd_satker($thang)),
			$this->dm->get_proposal_skpd_diajukan($thang),
			'Rp '.number_format($this->dm->sum_proposal_skpd_diajukan($thang)),
			$this->dm->get_proposal_skpd_reprov($thang),
			'Rp '.number_format($this->dm->sum_proposal_skpd_reprov($thang)),
			//DIREKTORAT
			$this->dm->get_proposal_skpd_dir($thang),
			'Rp '.number_format($this->dm->sum_proposal_skpd_dir($thang)),
			//END DIREKTORAT
			$this->dm->get_proposal_skpd_reunit($thang),
			'Rp '.number_format($this->dm->sum_proposal_skpd_reunit($thang)),
			$this->dm->get_proposal_skpd_setuju($thang),
			'Rp '.number_format($this->dm->sum_proposal_skpd_setuju($thang)),
			$this->dm->get_proposal_skpd_tolak($thang),
			'Rp '.number_format($this->dm->sum_proposal_skpd_tolak($thang)),
			$this->dm->get_proposal_skpd_timbang($thang),
			'Rp '.number_format($this->dm->sum_proposal_skpd_timbang($thang)),
		);
		$record_items[]=array(
			2,
			2,
			'<a href="'.site_url().'/e-planning/dashboard/view/kpkd">Permanen Pusat & Vertikal UPT</a>',
			$this->dm->get_proposal_kpkd_satker($thang),
			'Rp '.number_format($this->dm->sum_proposal_kpkd_satker($thang)),
			$this->dm->get_proposal_kpkd_diajukan($thang),
			'Rp '.number_format($this->dm->sum_proposal_kpkd_diajukan($thang)),
			'-',
			'-',
			'-',
			'-',
			$this->dm->get_proposal_kpkd_reunit($thang),
			'Rp '.number_format($this->dm->sum_proposal_kpkd_reunit($thang)),
			$this->dm->get_proposal_kpkd_setuju($thang),
			'Rp '.number_format($this->dm->sum_proposal_kpkd_setuju($thang)),
			$this->dm->get_proposal_kpkd_tolak($thang),
			'Rp '.number_format($this->dm->sum_proposal_kpkd_tolak($thang)),
			$this->dm->get_proposal_kpkd_timbang($thang),
			'Rp '.number_format($this->dm->sum_proposal_kpkd_timbang($thang)),
		);
		$record_items[]=array(
			3,
			3,
			'<a href="'.site_url().'/e-planning/dashboard/view/prov">Provinsi / Dekonsentrasi</a>',
			$this->dm->get_proposal_prov_satker($thang),
			'Rp '.number_format($this->dm->sum_proposal_prov_satker($thang)),
			$this->dm->get_proposal_prov_diajukan($thang),
			'Rp '.number_format($this->dm->sum_proposal_prov_diajukan($thang)),
			$this->dm->get_proposal_prov_reprov($thang),
			'Rp '.number_format($this->dm->sum_proposal_prov_reprov($thang)),
			//DIREKTORAT
			$this->dm->get_proposal_dir_redir($thang),
			'Rp '.number_format($this->dm->sum_proposal_dir_redir($thang)),
			//END DIREKTORAT
			$this->dm->get_proposal_prov_reunit($thang),
			'Rp '.number_format($this->dm->sum_proposal_prov_reunit($thang)),
			$this->dm->get_proposal_prov_setuju($thang),
			'Rp '.number_format($this->dm->sum_proposal_prov_setuju($thang)),
			$this->dm->get_proposal_prov_tolak($thang),
			'Rp '.number_format($this->dm->sum_proposal_prov_tolak($thang)),
			$this->dm->get_proposal_prov_timbang($thang),
			'Rp '.number_format($this->dm->sum_proposal_prov_timbang($thang)),
		);
			
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build(count($record_items),$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}

	function rekap_dashboard_proposal() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thang = $this->session->userdata('thn_anggaran');
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/rekap/dashboard_proposal2.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Dashboard Pengajuan Proposal Tahun Anggaran '.$thang); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no = 0;
		$baris_1 = 7;
		$baris_2 = 8;
		$baris_3 = 9;

		$this->excel->getActiveSheet()->setCellValue('C'.$baris_1, $this->dm->get_proposal_skpd_satker($thang));
		$this->excel->getActiveSheet()->setCellValue('D'.$baris_1, 'Rp '.number_format($this->dm->sum_proposal_skpd_satker($thang)));
		$this->excel->getActiveSheet()->setCellValue('E'.$baris_1, $this->dm->get_proposal_skpd_diajukan($thang));
		$this->excel->getActiveSheet()->setCellValue('F'.$baris_1, 'Rp '.number_format($this->dm->sum_proposal_skpd_diajukan($thang)));
		$this->excel->getActiveSheet()->setCellValue('G'.$baris_1, $this->dm->get_proposal_skpd_reprov($thang));
		$this->excel->getActiveSheet()->setCellValue('H'.$baris_1, 'Rp '.number_format($this->dm->sum_proposal_skpd_reprov($thang)));
		$this->excel->getActiveSheet()->setCellValue('I'.$baris_1, $this->dm->get_proposal_skpd_dir($thang));
		$this->excel->getActiveSheet()->setCellValue('J'.$baris_1, 'Rp '.number_format($this->dm->sum_proposal_skpd_dir($thang)));
		$this->excel->getActiveSheet()->setCellValue('K'.$baris_1, $this->dm->get_proposal_skpd_reunit($thang));
		$this->excel->getActiveSheet()->setCellValue('L'.$baris_1, 'Rp '.number_format($this->dm->sum_proposal_skpd_reunit($thang)));
		$this->excel->getActiveSheet()->setCellValue('M'.$baris_1, $this->dm->get_proposal_skpd_setuju($thang));
		$this->excel->getActiveSheet()->setCellValue('N'.$baris_1, 'Rp '.number_format($this->dm->sum_proposal_skpd_setuju($thang)));
		$this->excel->getActiveSheet()->setCellValue('O'.$baris_1, $this->dm->get_proposal_skpd_tolak($thang));
		$this->excel->getActiveSheet()->setCellValue('P'.$baris_1, 'Rp '.number_format($this->dm->sum_proposal_skpd_tolak($thang)));
		$this->excel->getActiveSheet()->setCellValue('Q'.$baris_1, $this->dm->get_proposal_skpd_timbang($thang));
		$this->excel->getActiveSheet()->setCellValue('R'.$baris_1, 'Rp '.number_format($this->dm->sum_proposal_skpd_timbang($thang)));

		$this->excel->getActiveSheet()->setCellValue('C'.$baris_2, $this->dm->get_proposal_kpkd_satker($thang));
		$this->excel->getActiveSheet()->setCellValue('D'.$baris_2, 'Rp '.number_format($this->dm->sum_proposal_kpkd_satker($thang)));
		$this->excel->getActiveSheet()->setCellValue('E'.$baris_2, $this->dm->get_proposal_kpkd_diajukan($thang));
		$this->excel->getActiveSheet()->setCellValue('F'.$baris_2, 'Rp '.number_format($this->dm->sum_proposal_kpkd_diajukan($thang)));
		$this->excel->getActiveSheet()->setCellValue('G'.$baris_2, '-');
		$this->excel->getActiveSheet()->setCellValue('H'.$baris_2, '-');
		$this->excel->getActiveSheet()->setCellValue('I'.$baris_2, '-');
		$this->excel->getActiveSheet()->setCellValue('J'.$baris_2, '-');
		$this->excel->getActiveSheet()->setCellValue('K'.$baris_2, $this->dm->get_proposal_kpkd_reunit($thang));
		$this->excel->getActiveSheet()->setCellValue('L'.$baris_2, 'Rp '.number_format($this->dm->sum_proposal_kpkd_reunit($thang)));
		$this->excel->getActiveSheet()->setCellValue('M'.$baris_2, $this->dm->get_proposal_kpkd_setuju($thang));
		$this->excel->getActiveSheet()->setCellValue('N'.$baris_2, 'Rp '.number_format($this->dm->sum_proposal_kpkd_setuju($thang)));
		$this->excel->getActiveSheet()->setCellValue('O'.$baris_2, $this->dm->get_proposal_kpkd_tolak($thang));
		$this->excel->getActiveSheet()->setCellValue('P'.$baris_2, 'Rp '.number_format($this->dm->sum_proposal_kpkd_tolak($thang)));
		$this->excel->getActiveSheet()->setCellValue('Q'.$baris_2, $this->dm->get_proposal_kpkd_timbang($thang));
		$this->excel->getActiveSheet()->setCellValue('R'.$baris_2, 'Rp '.number_format($this->dm->sum_proposal_kpkd_timbang($thang)));

		$this->excel->getActiveSheet()->setCellValue('C'.$baris_3, $this->dm->get_proposal_prov_satker($thang));
		$this->excel->getActiveSheet()->setCellValue('D'.$baris_3, 'Rp '.number_format($this->dm->sum_proposal_prov_satker($thang)));
		$this->excel->getActiveSheet()->setCellValue('E'.$baris_3, $this->dm->get_proposal_prov_diajukan($thang));
		$this->excel->getActiveSheet()->setCellValue('F'.$baris_3, 'Rp '.number_format($this->dm->sum_proposal_prov_diajukan($thang)));
		$this->excel->getActiveSheet()->setCellValue('G'.$baris_3, $this->dm->get_proposal_prov_reprov($thang));
		$this->excel->getActiveSheet()->setCellValue('H'.$baris_3, 'Rp '.number_format($this->dm->sum_proposal_prov_reprov($thang)));
		$this->excel->getActiveSheet()->setCellValue('I'.$baris_3, $this->dm->get_proposal_dir_redir($thang));
		$this->excel->getActiveSheet()->setCellValue('J'.$baris_3, 'Rp '.number_format($this->dm->sum_proposal_dir_redir($thang)));
		$this->excel->getActiveSheet()->setCellValue('K'.$baris_3, $this->dm->get_proposal_prov_reunit($thang));
		$this->excel->getActiveSheet()->setCellValue('L'.$baris_3, 'Rp '.number_format($this->dm->sum_proposal_prov_reunit($thang)));
		$this->excel->getActiveSheet()->setCellValue('M'.$baris_3, $this->dm->get_proposal_prov_setuju($thang));
		$this->excel->getActiveSheet()->setCellValue('N'.$baris_3, 'Rp '.number_format($this->dm->sum_proposal_prov_setuju($thang)));
		$this->excel->getActiveSheet()->setCellValue('O'.$baris_3, $this->dm->get_proposal_prov_tolak($thang));
		$this->excel->getActiveSheet()->setCellValue('P'.$baris_3, 'Rp '.number_format($this->dm->sum_proposal_prov_tolak($thang)));
		$this->excel->getActiveSheet()->setCellValue('Q'.$baris_3, $this->dm->get_proposal_prov_timbang($thang));
		$this->excel->getActiveSheet()->setCellValue('R'.$baris_3, 'Rp '.number_format($this->dm->sum_proposal_prov_timbang($thang)));

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Dashboard Pengajuan Proposal '.$thang.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function rekap_dashboard_proposal2() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thang = $this->session->userdata('thn_anggaran');
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/dashboard_proposal2.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Dashboard Pengajuan Proposal Tahun Anggaran '.$thang); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no=1;
		$index=7;
		$index2=8;

		foreach ($this->dm->get_jenis_satker() as $key=>$value) {
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $value);
			if($key=='1') {
				foreach($this->dm->get_skpd_satker()->result() as $row2){
					$this->excel->getActiveSheet()->setCellValue('B'.$index, '- '.$row2->nmsatker);
					$index++;
				}
			} elseif ($key=='2') {
				foreach($this->dm->get_kpkd_satker()->result() as $row3){
					$this->excel->getActiveSheet()->setCellValue('B'.$index, '- '.$row3->nmsatker);
					$index++;
				}
			}
			
			$index++;
			$no++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Dashboard Pengajuan Proposal '.$thang.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	// function rekap_dashboard_proposal_prov() {
	// 	$tanggal_print = date('d/m/Y');
	// 	$tanggal_judul = date('dmY');
	// 	$thang = $this->session->userdata('thn_anggaran');
	// 	ini_set("memory_limit", "256M");
	// 	// set to excel
	// 	$this->load->library('excel');                 
	// 	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	// 	$this->excel = $objReader->load('file/rekap/dashboard_prov_proposal.xlsx');
	// 	$this->excel->setActiveSheetIndex(0);
		
	// 	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Dashboard Pengajuan Proposal Provinsi Tahun Anggaran '.$thang); //print judul
	// 	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
	// 	// $no = 0;
	// 	$no=1;
	// 	$index=7;
	// 	$index2=8;
	// 	// $baris_1 = 7;
	// 	// $baris_2 = 8;
	// 	// $baris_3 = 9;

	// 	foreach ($this->dm->get_all_provinsi()->result() as $row) {
	// 		$this->excel->getActiveSheet()->getStyle('A'.$index.':G'.$index)->getFont()->setBold(true);
	// 		$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
	// 		$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->NamaProvinsi);
	// 		$this->excel->getActiveSheet()->setCellValue('D'.$index, $this->dm->get_proposal_per_prov_satker($row->KodeProvinsi, $thang));
	// 		$this->excel->getActiveSheet()->setCellValue('E'.$index, 'Rp '.number_format($this->dm->sum_proposal_per_prov_satker($row->KodeProvinsi, $thang)));
	// 		$this->excel->getActiveSheet()->setCellValue('F'.$index, $this->dm->get_proposal_per_prov_diajukan($row->KodeProvinsi, $thang));
	// 		$this->excel->getActiveSheet()->setCellValue('G'.$index, 'Rp '.number_format($this->dm->sum_proposal_per_prov_diajukan($row->KodeProvinsi, $thang)));
	// 		$index++;
	// 		foreach ($this->dm->get_satker_by_prop($row->KodeProvinsi)->result() as $row2) {
	// 			$this->excel->getActiveSheet()->setCellValue('C'.$index, '- '.$row2->nmsatker);
	// 			$this->excel->getActiveSheet()->setCellValue('D'.$index, $this->dm->get_pengajuan_prop_satker($row2->kdlokasi, $row2->kdsatker, $thang));
	// 			//$this->excel->getActiveSheet()->setCellValue('E'.$index, 'Rp '.number_format($this->dm->sum_prov_satker($row2->kdlokasi, $row2->kdsatker, $thang)));
	// 			// $this->excel->getActiveSheet()->setCellValue('F'.$index, $this->dm->get_prov_satker_diajukan($row2->kdlokasi, $row2->kdsatker, $thang));
	// 			// $this->excel->getActiveSheet()->setCellValue('G'.$index, 'Rp '.number_format($this->dm->sum_prov_satker_diajukan($row2->kdlokasi, $row2->kdsatker, $thang)));
	// 			$index++;
	// 			$no++;
	// 		}
			
			
			
	// 	}

	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //        header('Content-Disposition: attachment;filename="Dashboard Pengajuan Proposal '.$thang.'.xlsx"');
 //        header('Cache-Control: max-age=0');

 //        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
 //        $objWriter->save('php://output');
	// }

	function rekap_dashboard_proposal_prov() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thang = $this->session->userdata('thn_anggaran');
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/rekap/dashboard_prov.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Dashboard Pengajuan Proposal Provinsi Tahun Anggaran '.$thang); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	

		$no=1;
		$index=7;
		$index2=8;

		foreach ($this->dm->get_all_provinsi()->result() as $row) {
			$this->excel->getActiveSheet()->getStyle('A'.$index.':G'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->NamaProvinsi);
			$this->excel->getActiveSheet()->setCellValue('C'.$index, $this->dm->get_proposal_per_prov_satker($row->KodeProvinsi, $thang));
			$this->excel->getActiveSheet()->setCellValue('D'.$index, 'Rp '.number_format($this->dm->sum_proposal_per_prov_satker($row->KodeProvinsi, $thang)));
			$this->excel->getActiveSheet()->setCellValue('E'.$index, $this->dm->get_proposal_per_prov_diajukan($row->KodeProvinsi, $thang));
			$this->excel->getActiveSheet()->setCellValue('F'.$index, 'Rp '.number_format($this->dm->sum_proposal_per_prov_diajukan($row->KodeProvinsi, $thang)));
			$index++;
			$no++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Dashboard Pengajuan Proposal '.$thang.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function rekap_dashboard_proposal_skpd() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thang = $this->session->userdata('thn_anggaran');
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/rekap/dashboard_prov.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Dashboard Pengajuan Proposal SKPD/Tugas Pembantuan Tahun Anggaran '.$thang); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no=1;
		$index=7;
		$index2=8;

		foreach ($this->dm->get_satker_by_skpd()->result() as $row) {
			$this->excel->getActiveSheet()->getStyle('A'.$index.':G'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);
			$this->excel->getActiveSheet()->setCellValue('C'.$index, $this->dm->get_pengajuan_skpd_satker($row->kdsatker, $thang));
			$this->excel->getActiveSheet()->setCellValue('D'.$index, 'Rp '.number_format($this->dm->sum_skpd_satker($row->kdsatker, $thang)));
			$this->excel->getActiveSheet()->setCellValue('E'.$index, $this->dm->get_skpd_satker_diajukan($row->kdsatker, $thang));
			$this->excel->getActiveSheet()->setCellValue('F'.$index, 'Rp '.number_format($this->dm->sum_skpd_satker_diajukan($row->kdsatker, $thang)));
			$index++;
			$no++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Dashboard Pengajuan Proposal '.$thang.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function rekap_dashboard_proposal_kpkd() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thang = $this->session->userdata('thn_anggaran');
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/rekap/dashboard_prov.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Dashboard Pengajuan Proposal Kantor Pusat/Kantor Daerah Tahun Anggaran '.$thang); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no=1;
		$index=7;
		$index2=8;

		foreach ($this->dm->get_satker_by_kpkd()->result() as $row) {
			$this->excel->getActiveSheet()->getStyle('A'.$index.':G'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);
			$this->excel->getActiveSheet()->setCellValue('C'.$index, $this->dm->get_pengajuan_kpkd_satker($row->kdsatker, $thang));
			$this->excel->getActiveSheet()->setCellValue('D'.$index, 'Rp '.number_format($this->dm->sum_kpkd_satker($row->kdsatker, $thang)));
			$this->excel->getActiveSheet()->setCellValue('E'.$index, $this->dm->get_kpkd_satker_diajukan($row->kdsatker, $thang));
			$this->excel->getActiveSheet()->setCellValue('F'.$index, 'Rp '.number_format($this->dm->sum_kpkd_satker_diajukan($row->kdsatker, $thang)));
			$index++;
			$no++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Dashboard Pengajuan Proposal '.$thang.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function rekap_dashboard_proposal_per_prov($kdlokasi) {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thang = $this->session->userdata('thn_anggaran');
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/rekap/dashboard_prov_proposal.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Dashboard Pengajuan Proposal Provinsi Tahun Anggaran '.$thang); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		// $no = 0;
		$no=1;
		$index=7;
		$index2=8;
		// $baris_1 = 7;
		// $baris_2 = 8;
		// $baris_3 = 9;
		$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
		foreach ($this->dm->get_satker_by_provinsi($kdlokasi)->result() as $row) {
			$this->excel->getActiveSheet()->getStyle('A'.$index.':G'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->NamaProvinsi);
			$this->excel->getActiveSheet()->setCellValue('C'.$index, $row->nmsatker);
			$this->excel->getActiveSheet()->setCellValue('D'.$index, $this->dm->get_pengajuan_prop_satker($row->KodeProvinsi, $row->kdsatker, $thang));
			$this->excel->getActiveSheet()->setCellValue('E'.$index, 'Rp '.number_format($this->dm->sum_prov_satker($row->KodeProvinsi, $row->kdsatker, $thang)));
			$this->excel->getActiveSheet()->setCellValue('F'.$index, $this->dm->get_prov_satker_diajukan($row->KodeProvinsi, $row->kdsatker, $thang));
			$this->excel->getActiveSheet()->setCellValue('G'.$index, 'Rp '.number_format($this->dm->sum_prov_satker_diajukan($row->KodeProvinsi, $row->kdsatker, $thang)));
			$index++;
			// foreach ($this->dm->get_satker_by_prop($row->KodeProvinsi)->result() as $row2) {
			// 	$this->excel->getActiveSheet()->setCellValue('C'.$index, '- '.$row2->nmsatker);
			// 	$this->excel->getActiveSheet()->setCellValue('D'.$index, $this->dm->get_pengajuan_prop_satker($row2->kdlokasi, $row2->kdsatker, $thang));
			// 	//$this->excel->getActiveSheet()->setCellValue('E'.$index, 'Rp '.number_format($this->dm->sum_prov_satker($row2->kdlokasi, $row2->kdsatker, $thang)));
			// 	// $this->excel->getActiveSheet()->setCellValue('F'.$index, $this->dm->get_prov_satker_diajukan($row2->kdlokasi, $row2->kdsatker, $thang));
			// 	// $this->excel->getActiveSheet()->setCellValue('G'.$index, 'Rp '.number_format($this->dm->sum_prov_satker_diajukan($row2->kdlokasi, $row2->kdsatker, $thang)));
			// 	$index++;
			// 	$no++;
			// }
			
			
			
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Dashboard Pengajuan Proposal '.$thang.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	function view($arg)
	{
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['name'] = array('Satker',350,TRUE,'left',1);
		$colModel['satker_jml'] = array('Jumlah Proposal</br>Dibuat',80,TRUE,'right',1);
		$colModel['satker_nil'] = array('Nilai Proposal</br>Dibuat',120,TRUE,'right',1);
		$colModel['diajukan_jml'] = array('Jumlah Proposal</br>Diajukan',80,TRUE,'right',1);
		$colModel['diajukan_nil'] = array('Nilai Proposal</br>Diajukan',120,TRUE,'right',1);
		
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '200',
			'rp' => 50,
			'rpOptions' => '[50,100,300,750]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'Dashboard Proposal',
			'nowrap' => false,
			'showTableToggleBtn' => false
		);
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/dashboard/list_view/".$arg;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		if($arg == 'prov'){
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/dashboard\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/dashboard/rekap_dashboard_proposal_prov/$arg\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/print.png\" alt=\"\"/>
						Cetak
					</button>
					</form>
				</div>";
		}
		elseif ($arg == 'skpd') {
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/dashboard\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/dashboard/rekap_dashboard_proposal_skpd/\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/print.png\" alt=\"\"/>
						Cetak
					</button>
					</form>
				</div>";
		}
		elseif ($arg == 'kpkd') {
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/dashboard\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/dashboard/rekap_dashboard_proposal_kpkd/\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/print.png\" alt=\"\"/>
						Cetak
					</button>
					</form>
				</div>";
		}
		else{
			if($this->session->userdata('kd_role') != 3){
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/dashboard/view/prov\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/dashboard/rekap_dashboard_proposal_per_prov/$arg\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/print.png\" alt=\"\"/>
						Cetak
					</button>
					</form>
				</div>";
			}
		}
		$data['added_js'] = "";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['notification'] = "";
		if($this->session->userdata('notification')!=''){
			$data['notification'] = "
				<script>
					$(document).ready(function() {
						$.growlUI('Pesan :', '".$this->session->userdata('notification')."');
					});
				</script>
			";
		}//end if
		$data['judul'] = 'Dashboard Proposal';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_view($arg)
	{
		$thang = $this->session->userdata('thn_anggaran');	
		$valid_fields = array('name');
		$this->flexigrid->validate_post('','',$valid_fields);
		if($arg == 'prov')	$records = $this->dm->get_provinsi();
		else $records = $this->dm->get_satker($arg);

		$this->output->set_header($this->config->item('json_header'));
		$no = 0;
		foreach ($records['result']->result() as $row){
			$no = $no+1;
			if($arg == 'prov'){
				$record_items[] = array(
					$no,
					$no,
					'<a href="'.site_url().'/e-planning/dashboard/view/'.$row->KodeProvinsi.'">'.$row->NamaProvinsi.'</a>',
					$this->dm->get_proposal_per_prov_satker($row->KodeProvinsi, $thang),
					'Rp '.number_format($this->dm->sum_proposal_per_prov_satker($row->KodeProvinsi, $thang)),
					$this->dm->get_proposal_per_prov_diajukan($row->KodeProvinsi, $thang),
					'Rp '.number_format($this->dm->sum_proposal_per_prov_diajukan($row->KodeProvinsi, $thang)),
				);
			}
			else{
				$record_items[] = array(
					$no,
					$no,
					$row->nmsatker,
					$this->dm->get_prop_satker($arg, $row->kdsatker, $thang),
					'Rp '.number_format($this->dm->sum_prop_satker($arg, $row->kdsatker, $thang)),
					$this->dm->get_prop_satker_diajukan($arg, $row->kdsatker, $thang),
					'Rp '.number_format($this->dm->sum_prop_satker_diajukan($arg, $row->kdsatker, $thang)),
				);
			}
		}
			
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
}
?>
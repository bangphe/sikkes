<?php
class Dashboard extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->model('e-budget/dashboard_model','dm');
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
		$colModel['jml_kmpnen'] = array('Jumlah Komponen',100,TRUE,'right',1);
		$colModel['mapped'] = array('Sudah Di-Mapping',100,TRUE,'right',1);
		$colModel['nmapped'] = array('Belum Di-Mapping',100,TRUE,'right',1);
		$colModel['total_ang'] = array('Total Anggaran',130,TRUE,'right',1);
		$colModel['ang_mapped'] = array('Total Anggaran</br>Sudah Di-Mapping',130,TRUE,'right',1);
		$colModel['ang_nmapped'] = array('Total Anggaran</br>Belum Di-Mapping',130,TRUE,'right',1);
		
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '200',
			'rp' => 3,
			'rpOptions' => '[3]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'Dashboard Anggaran',
			'nowrap' => false,
			'showTableToggleBtn' => false
		);
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-budget/dashboard/list_grid/";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
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
		$data['judul'] = 'Dashboard Anggaran';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_grid()
	{
		$thang = $this->session->userdata('thn_anggaran');	
		$valid_fields = array('name');
		$this->flexigrid->validate_post('','',$valid_fields);

		$this->output->set_header($this->config->item('json_header'));
		$kmpnen1= $this->dm->get_kmpnen_skpd($thang);
		$m_kmpnen1= $this->dm->get_kmpnen_skpd_mapped($thang);
		$nm_kmpnen1= $kmpnen1 - $m_kmpnen1;
		$ang1= $this->dm->sum_ang_skpd($thang);
		$m_ang1=0; 
		if($this->dm->sum_ang_skpd_mapped($thang)->num_rows() > 0) {
			$m_ang1 = $this->dm->sum_ang_skpd_mappedd($thang);
		}
		else {
			$m_ang1 = 0;
		}
		$nm_ang1= $ang1 - $m_ang1;
		
		$kmpnen2= $this->dm->get_kmpnen_kpkd($thang);
		$m_kmpnen2= $this->dm->get_kmpnen_kpkd_mapped($thang);
		$nm_kmpnen2= $kmpnen2 - $m_kmpnen2;
		$ang2= $this->dm->sum_ang_kpkd($thang);
		$m_ang2= $this->dm->sum_ang_kpkd_mapped($thang);
		$nm_ang2= $ang2 - $m_ang2;
		
		$kmpnen3= $this->dm->get_kmpnen_prov($thang);
		$m_kmpnen3= $this->dm->get_kmpnen_prov_mapped($thang);
		$nm_kmpnen3= $kmpnen3 - $m_kmpnen3;
		$ang3= $this->dm->sum_ang_prov($thang);
		$m_ang3= $this->dm->sum_ang_prov_mapped($thang);
		$nm_ang3= $ang3 - $m_ang3;
		$record_items[]=array(
			1,
			1,
			'<a href="'.site_url().'/e-budget/dashboard/view/skpd">SKPD / Tugas Pembantuan</a>',
			$kmpnen1,
			$m_kmpnen1,
			$nm_kmpnen1,
			'Rp '.number_format($ang1),
			'Rp '.number_format($m_ang1),
			'Rp '.number_format($nm_ang1),
		);
		$record_items[]=array(
			2,
			2,
			'<a href="'.site_url().'/e-budget/dashboard/view/kpkd">Permanen Pusat & Vertikal UPT</a>',
			$kmpnen2,
			$m_kmpnen2,
			$nm_kmpnen2,
			'Rp '.number_format($ang2),
			'Rp '.number_format($m_ang2),
			'Rp '.number_format($nm_ang2),
		);
		$record_items[]=array(
			3,
			3,
			'<a href="'.site_url().'/e-budget/dashboard/view/prov">Provinsi / Dekonsentrasi</a>',
			$kmpnen3,
			$m_kmpnen3,
			$nm_kmpnen3,
			'Rp '.number_format($ang3),
			'Rp '.number_format($m_ang3),
			'Rp '.number_format($nm_ang3),
		);
			
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build(count($record_items),$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function view($arg)
	{
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['name'] = array('Satker',350,TRUE,'left',1);
		$colModel['jml_kmpnen'] = array('Jumlah Komponen',100,TRUE,'right',1);
		$colModel['mapped'] = array('Sudah Di-Mapping',100,TRUE,'right',1);
		$colModel['nmapped'] = array('Belum Di-Mapping',100,TRUE,'right',1);
		$colModel['total_ang'] = array('Total Anggaran',130,TRUE,'right',1);
		$colModel['ang_mapped'] = array('Total Anggaran</br>Sudah Di-Mapping',130,TRUE,'right',1);
		$colModel['ang_nmapped'] = array('Total Anggaran</br>Belum Di-Mapping',130,TRUE,'right',1);
		
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '200',
			'rp' => 50,
			'rpOptions' => '[50,100,300,750]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'Dashboard Anggaran',
			'nowrap' => false,
			'showTableToggleBtn' => false
		);
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-budget/dashboard/list_view/".$arg;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		if($arg == 'prov' || $arg == 'skpd' || $arg == 'kpkd'){
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-budget/dashboard\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali
					</button>
					</form>
				</div>";
		}
		else{
			if($this->session->userdata('kd_role') != 3){
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-budget/dashboard/view/prov\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali
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
		$data['judul'] = 'Dashboard Anggaran';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_view($arg)
	{
		$thang = $this->session->userdata('thn_anggaran');	
		if($arg == 'prov'){	
			$valid_fields = array('NamaProvinsi');
			$this->flexigrid->validate_post('KodeProvinsi','asc',$valid_fields);
			$records = $this->dm->get_provinsi();
		}
		else{
			$valid_fields = array('nmsatker');
			$this->flexigrid->validate_post('nmsatker','asc',$valid_fields);
			$records = $this->dm->get_satker($arg);
		}

		$this->output->set_header($this->config->item('json_header'));
		$no = 0;
		foreach ($records['result']->result() as $row){
			$no = $no+1;
			if($arg == 'prov'){
				$kmpnen = $this->dm->get_kmpnen_per_prov($row->KodeProvinsi, $thang);
				$m_kmpnen = $this->dm->get_kmpnen_per_prov_mapped($row->KodeProvinsi, $thang);
				$nm_kmpnen = $kmpnen - $m_kmpnen;
				$ang = $this->dm->sum_ang_per_prov($row->KodeProvinsi, $thang);
				$m_ang = $this->dm->sum_ang_per_prov_mapped($row->KodeProvinsi, $thang);
				$nm_ang = $ang - $m_ang;
				$record_items[] = array(
					$no,
					$no,
					'<a href="'.site_url().'/e-budget/dashboard/view/'.$row->KodeProvinsi.'">'.$row->NamaProvinsi.'</a>',
					$kmpnen,
					$m_kmpnen,
					$nm_kmpnen,
					'Rp '.number_format($ang),
					'Rp '.number_format($m_ang),
					'Rp '.number_format($nm_ang),
				);
			}
			else{
				$kmpnen = $this->dm->get_kmpnen_satker($arg, $row->kdsatker, $thang);
				$m_kmpnen = $this->dm->get_kmpnen_satker_mapped($arg, $row->kdsatker, $thang);
				$nm_kmpnen = $kmpnen - $m_kmpnen;
				$ang = $this->dm->sum_ang_satker($arg, $row->kdsatker, $thang);
				$m_ang = $this->dm->sum_ang_satker_mapped($arg, $row->kdsatker, $thang);
				$nm_ang = $ang - $m_ang;
				$record_items[] = array(
					$no,
					$no,
					$row->nmsatker,
					$kmpnen,
					$m_kmpnen,
					$nm_kmpnen,
					'Rp '.number_format($ang),
					'Rp '.number_format($m_ang),
					'Rp '.number_format($nm_ang),
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
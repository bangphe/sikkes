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
		// $data['added_php'] = 
				// "<div class=\"buttons\">
					// <form action=\"".base_url()."index.php/e-planning/dashboard\">
					// <button type=\"submit\" class=\"regular\" name=\"cetak\">
						// <img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						// Kembali ke Daftar Proposal
					// </button>
					// </form>
				// </div>";
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
		if($arg == 'prov' || $arg == 'skpd' || $arg == 'kpkd'){
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/dashboard\" method=\"POST\">
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
					<form action=\"".base_url()."index.php/e-planning/dashboard/view/prov\" method=\"POST\">
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
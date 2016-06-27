<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filtering extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/Filtering_model','fm');
		$this->load->model('e-planning/Pendaftaran_model','pm');
		$this->load->model('e-planning/Manajemen_model','mm');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	function index(){
		$data['added_js'] = 
			"<script type=\"text/javascript\">
				$(document).ready(function() {
					$('#content_tengah div').tree({
						components: ['checkbox', 'collapse'],
						onCheck: {
							ancestors: 'check',
							descendants: 'check'
						},
						onUncheck: {
							descendants: 'uncheck'
						}
					});
					$('.button').button();
				});
				//-->
			</script>";
		$option_prioritas;
		
		$prog='';
		$iku='';
		$keg='';
		$ikk='';
		foreach($this->pm->get('ref_program')->result() as $row){
			$prog=$prog.'{id: "'.$row->KodeProgram.'", label: "'.$row->NamaProgram.'"},';
		}
		foreach($this->fm->get_ikk('ref_iku')->result() as $row){
			$iku=$iku.'{id: "'.$row->KodeIku.'", label: "'.$row->Iku.'"},';
		}
		foreach($this->pm->get('ref_kegiatan')->result() as $row){
			$keg=$keg.'{id: "'.$row->KodeKegiatan.'", label: "'.$row->NamaKegiatan.'"},';
		}
		foreach($this->fm->get_ikk('ref_ikk')->result() as $row){
			$ikk=$ikk.'{id: "'.$row->KodeIkk.'", label: "'.$row->Ikk.'"},';
		}
		$data2['prog'] = $prog;
		$data2['iku'] = $iku;
		$data2['keg'] = $keg;
		$data2['ikk'] = $ikk;
		
		foreach($this->pm->get('ref_prioritas')->result() as $row){
			$option_prioritas[$row->KodePrioritas] = $row->Prioritas;
		}
		$data2['reformasi_kesehatan'] = $this->pm->get('reformasi_kesehatan')->result();
		$data2['fokus_prioritas'] = $this->pm->get('fokus_prioritas')->result();
		$data2['prov'] = $this->pm->get_provinsi()->result();
		$data2['program'] = $this->fm->get('ref_program');
		$data2['opt_prioritas'] = $option_prioritas;
		$data['e_planning'] = "";
		$data['content'] = $this->load->view('e-planning/filtering/filtering',$data2, true);
		$this->load->view('main',$data);
	}

	function program(){
		foreach($this->pm->get_kode_kementrian()->result() as $row){
			$Kode_kementrian = $row->KodeKementrian;
		}
		$data['program'] = $this->fm->get_program($Kode_kementrian);
		$this->load->view('e-planning/filtering/program_kegiatan',$data);
	}

	function search(){
		if($this->validasi($this->input->post('nilai_prop'))==FALSE) $this->index();
		else{
			$keyword = $this->input->post('keyword');
			$kategori = $this->input->post('kategori');
			foreach($this->pm->get_kode_kementrian()->result() as $row){
				$Kode_kementrian = $row->KodeKementrian;
			}
			$data['program'] = $this->fm->get_search($Kode_kementrian,$keyword,$kategori);
			$this->load->view('e-planning/filtering/program_kegiatan',$data);
		}
	}
	
	function validasi($tipe){
		if($tipe != 3){
			$config = array(
				array('field'=>'indikator','label'=>'Indikator', 'rules'=>'required'),
				array('field'=>'prioritas','label'=>'Prioritas', 'rules'=>'required')
			);
		}else{
			$config = array(
				array('field'=>'indikator','label'=>'Indikator', 'rules'=>'required'),
				array('field'=>'prioritas','label'=>'Prioritas', 'rules'=>'required'),
				array('field'=>'batas_bawah','label'=>'Batas Bawah', 'rules'=>'required|numeric'),
				array('field'=>'batas_atas','label'=>'Batas Atas', 'rules'=>'required|numeric')
			);
		}
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		$this->form_validation->set_message('numeric', '%s harus angka !!');

		return $this->form_validation->run();
	}
	
	function tes()
	{
		$prop = $this->input->post('prop');
		//$prov = $this->input->post('prov');	
		$tes = $this->fm->getProv($prop);
		echo $prop;	
	}
	
	function cek()
	{
		$data['added_js'] = 
			"<script type=\"text/javascript\">
				$(document).ready(function() {
					$('#content_tengah div').tree({
						components: ['checkbox', 'collapse'],
						onCheck: {
							ancestors: 'check',
							descendants: 'check'
						},
						onUncheck: {
							descendants: 'uncheck'
						}
					});
					$('.button').button();
				});
				//-->
		</script>";
		$kdprio = $this->input->post('prioritas');
		//$tes = $this->fm->get('ref_provinsi');
		
		$prior = $this->mm->get_where('ref_jenis_prioritas','KodeJenisPrioritas',$kdprio);
		//echo $prop;
		
		$dataprop = array();
		if(isset($_POST['provinsi'])){
			$prov = $this->input->post('provinsi');
			for($i=0; $i<count($prov); $i++){
				//$dataprov[$i] = $prov[$i];
				$propinsiquery = $this->mm->get_where('ref_provinsi','KodeProvinsi',$prov[$i]);
				foreach($propinsiquery->result() as $propterpilih);
				$dataprop[$i]['kodeprop'] = $propterpilih->KodeProvinsi;
				$dataprop[$i]['namaprop'] = $propterpilih->NamaProvinsi;
			}
		}
		$data['propinsi'] = $dataprop;
		
		$dataprog = array();
		if(isset($_POST['program'])){
			$prog = $this->input->post('program');
			for($i=0; $i<count($prog); $i++){
				//$dataprov[$i] = $prov[$i];
				$progquery = $this->mm->get_where('ref_program','KodeProgram',$prog[$i]);
				foreach($progquery->result() as $progterpilih);
				$dataprog[$i]['kodeprog'] = $progterpilih->KodeProgram;
				$dataprog[$i]['namaprog'] = $progterpilih->NamaProgram;
			}
		}
		$data['program'] = $dataprog;
		
		$dataiku = array();
		if(isset($_POST['iku'])){
			$dtiku = $this->input->post('iku');
			for($i=0; $i<count($dtiku); $i++){
				//$dataprov[$i] = $prov[$i];
				$ikuquery = $this->mm->get_where('ref_iku','KodeIku',$dtiku[$i]);
				foreach($ikuquery->result() as $ikuterpilih);
				$dataiku[$i]['kodeiku'] = $ikuterpilih->KodeIku;
				$dataiku[$i]['namaiku'] = $ikuterpilih->Iku;
			}
		}
		$data['iku'] = $dataiku;
		
		$datakeg = array();
		if(isset($_POST['kegiatan'])){
			$dtkeg = $this->input->post('kegiatan');
			for($i=0; $i<count($dtkeg); $i++){
				//$dataprov[$i] = $prov[$i];
				$kegquery = $this->mm->get_where('ref_kegiatan','KodeKegiatan',$dtkeg[$i]);
				foreach($kegquery->result() as $kegterpilih);
				$datakeg[$i]['kodekeg'] = $kegterpilih->KodeKegiatan;
				$datakeg[$i]['namakeg'] = $kegterpilih->NamaKegiatan;
			}
		}
		$data['kegiatan'] = $datakeg;
		
		$dataikk = array();
		if(isset($_POST['ikk'])){
			$dtikk = $this->input->post('ikk');
			for($i=0; $i<count($dtikk); $i++){
				//$dataprov[$i] = $prov[$i];
				$ikkquery = $this->mm->get_where('ref_ikk','KodeIkk',$dtikk[$i]);
				foreach($ikkquery->result() as $ikkterpilih);
				$dataikk[$i]['kodeikk'] = $ikkterpilih->KodeIkk;
				$dataikk[$i]['namaikk'] = $ikkterpilih->Ikk;
			}
		}
		$data['ikk'] = $dataikk;
		
		$datajenisprio = array();
		if(isset($_POST['jenis_prioritas'])){
			$jenis = $this->input->post('jenis_prioritas');
			for($i=0; $i<count($jenis); $i++){
				//$dataprov[$i] = $prov[$i];
				$jenisquery = $this->mm->get_where('ref_jenis_prioritas','KodeJenisPrioritas',$jenis[$i]);
				foreach($jenisquery->result() as $propterpilih);
				$datajenisprio[$i]['kodejenis'] = $propterpilih->KodeJenisPrioritas;
				$datajenisprio[$i]['namajenis'] = $propterpilih->JenisPrioritas;
			}
		}
		$data['jenis_prioritas'] = $datajenisprio;
		
		$datafokprio = array();
		if(isset($_POST['fokus_prioritas'])){
			$fok = $this->input->post('fokus_prioritas');
			for($i=0; $i<count($fok); $i++){
				//$dataprov[$i] = $prov[$i];
				$fokprio_query = $this->mm->get_where('fokus_prioritas','idFokusPrioritas',$fok[$i]);
				foreach($fokprio_query->result() as $fokprioterpilih);
				$datafokprio[$i]['idfok'] = $fokprioterpilih->idFokusPrioritas;
				$datafokprio[$i]['namafok'] = $fokprioterpilih->FokusPrioritas;
			}
		}
		$data['fokus_prioritas'] = $datafokprio;
		
		$dataref = array();
		if(isset($_POST['reformasi_kesehatan'])){
			$refkes = $this->input->post('reformasi_kesehatan');
			for($i=0; $i<count($refkes); $i++){
				//$dataprov[$i] = $prov[$i];
				$refkes_query = $this->mm->get_where('reformasi_kesehatan','idReformasiKesehatan',$refkes[$i]);
				foreach($refkes_query->result() as $refkesterpilih);
				$dataref[$i]['idrefkes'] = $refkesterpilih->idReformasiKesehatan;
				$dataref[$i]['namarefkes'] = $refkesterpilih->ReformasiKesehatan;
			}
		}
		$data['reformasi_kesehatan'] = $dataref;
		
		if(isset($_POST['fokus_prioritas'])){
		$idFokusPrioritas = $this->input->post('fokus_prioritas');
			for($i=0; $i<count($idFokusPrioritas); $i++){
				$data['idFokus'] = $idFokusPrioritas[$i];
			}
		}
		
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['nmsatker'] = array('Nama Satker',150,TRUE,'center',1);
		$colModel['JUDUL_PROPOSAL'] = array('Judul Proposal',150,TRUE,'left',1);
		$colModel['TANGGAl_PEMBUATAN'] = array('Tanggal Pembuatan',100,TRUE,'center',1);
		$colModel['TANGGAL_PENGAJUAN'] = array('Tangal Surat',100,TRUE,'center',0);
		$colModel['Kota'] = array('Kota',150,TRUE,'left',0);
		$colModel['PRIORITAS_NASIONAL'] = array('Prioritas Nasional',100,TRUE,'left',0);
		$colModel['PRIORITAS_KEMENTRIAN'] = array('Prioritas Kementrian',100,TRUE,'left',0);
		$colModel['PRIORITAS_BIDANG'] = array('Prioritas Bidang',100,TRUE,'left',0);
		$colModel['NON_PRIORITAS'] = array('Non Prioritas',100,TRUE,'left',0);
		$colModel['FOKUS_PRIORITAS'] = array('Fokus Prioritas',100,TRUE,'left',0);
		$colModel['REFORMASI_KESEHATAN'] = array('Reformasi Kesehatan',105,TRUE,'left',0);
		$colModel['program'] = array('Program',150,TRUE,'left',0);
		$colModel['iku'] = array('IKU',100,TRUE,'left',0);
		$colModel['kegiatan'] = array('Kegiatan',150,TRUE,'left',0);
		$colModel['ikk'] = array('IKK',100,TRUE,'left',0);
		$colModel['NILAI_PROPOSAL'] = array('Nilai Proposal',100,TRUE,'right',1);
		$colModel['detail'] = array('Detail',70,TRUE,'center',0);
		$colModel['ubah'] = array('Ubah',70,TRUE,'center',0);
		$colModel['TELAAH_STAFF'] = array('Telaah Staff',70,TRUE,'center',0);
		$colModel['STATUS'] = array('Minta Persetujuan',100,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'nowrap' => false,
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
				
		// mengambil data dari file controler ajax pada method grid_user
		if($this->input->post('provinsi') != NULL) $this->session->set_userdata('provinsi_f', $this->input->post('provinsi')); else $this->session->set_userdata('provinsi_f', NULL);
		if($this->input->post('jenis_prioritas') != NULL) $this->session->set_userdata('jenis_prioritas_f', $this->input->post('jenis_prioritas')); else $this->session->set_userdata('jenis_prioritas_f', NULL);
		if($this->input->post('prioritas') != NULL) $this->session->set_userdata('prioritas_f', $this->input->post('prioritas')); else $this->session->set_userdata('prioritas_f', NULL);
		if($this->input->post('fokus_prioritas') != NULL) $this->session->set_userdata('fokus_prioritas_f', $this->input->post('fokus_prioritas')); else $this->session->set_userdata('fokus_prioritas_f', NULL);
		if($this->input->post('reformasi_kesehatan') != NULL) $this->session->set_userdata('reformasi_kesehatan_f', $this->input->post('reformasi_kesehatan')); else $this->session->set_userdata('reformasi_kesehatan_f', NULL);
		if($this->input->post('program') != NULL) $this->session->set_userdata('program_f', $this->input->post('program')); else $this->session->set_userdata('program_f', NULL);
		if($this->input->post('iku') != NULL) $this->session->set_userdata('iku_f', $this->input->post('iku')); else $this->session->set_userdata('iku_f', NULL);
		if($this->input->post('kegiatan') != NULL) $this->session->set_userdata('kegiatan_f', $this->input->post('kegiatan')); else $this->session->set_userdata('kegiatan_f', NULL);
		if($this->input->post('ikk') != NULL) $this->session->set_userdata('ikk_f', $this->input->post('ikk')); else $this->session->set_userdata('ikk_f', NULL);
		if($this->input->post('tupoksi') != NULL) $this->session->set_userdata('tupoksi_f', $this->input->post('tupoksi')); else $this->session->set_userdata('tupoksi_f', NULL);
		$url = base_url()."index.php/e-planning/filtering/list_filtering";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['e_planning'] = "";
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
		
		$data['cb'] = $kdprio;
		$data['prioritas'] = $prior;
		//$data['propinsi'] = $this->mm->get_where('ref_provinsis','KodeProvinsi',$prop);
		//$data['fokus_prioritas'] = $this->mm->get_where('fokus_prioritas','idFokusPrioritas',$fokprio);
		//$data['reformasi_kesehatan'] = $this->mm->get_where('reformasi_kesehatan','idReformasiKesehatan',$refkes);
		//$data['reformasi_kesehatan'] = $this->mm->get('reformasi_kesehatan');
		$data['content'] = $this->load->view('e-planning/filtering/hasil_filtering',$data,true);
		$this->load->view('main',$data);
	}
	
	
	
	function proses_filtering(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['nmsatker'] = array('Nama Satker',100,TRUE,'center',1);
		$colModel['JUDUL_PROPOSAL'] = array('Judul Proposal',100,TRUE,'left',1);
		$colModel['TANGGAL_PENGAJUAN'] = array('Tanggal Pembuatan',100,TRUE,'center',1);
		$colModel['PRIORITAS_NASIONAL'] = array('Prioritas Nasional',100,TRUE,'left',0);
		$colModel['PRIORITAS_KEMENTRIAN'] = array('Prioritas Kementrian',100,TRUE,'left',0);
		$colModel['PRIORITAS_BIDANG'] = array('Prioritas Bidang',100,TRUE,'left',0);
		$colModel['FOKUS_PRIORITAS'] = array('Fokus Prioritas',100,TRUE,'left',0);
		$colModel['REFORMASI_KESEHATAN'] = array('Reformasi Kesehatan',100,TRUE,'left',0);
		$colModel['NILAI_PROPOSAL'] = array('Nilai Proposal',100,TRUE,'right',1);
		$colModel['TELAAH_STAFF'] = array('Telaah Staff',100,TRUE,'center',0);
		$colModel['STATUS'] = array('Minta Persetujuan',100,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
				
		// mengambil data dari file controler ajax pada method grid_user
		if($this->input->post('provinsi') != NULL) $this->session->set_userdata('provinsi_f', $this->input->post('provinsi')); else $this->session->set_userdata('provinsi_f', NULL);
		if($this->input->post('jenis_prioritas') != NULL) $this->session->set_userdata('jenis_prioritas_f', $this->input->post('jenis_prioritas')); else $this->session->set_userdata('jenis_prioritas_f', NULL);
		if($this->input->post('prioritas') != NULL) $this->session->set_userdata('prioritas_f', $this->input->post('prioritas')); else $this->session->set_userdata('prioritas_f', NULL);
		if($this->input->post('fokus_prioritas') != NULL) $this->session->set_userdata('fokus_prioritas_f', $this->input->post('fokus_prioritas')); else $this->session->set_userdata('fokus_prioritas_f', NULL);
		if($this->input->post('reformasi_kesehatan') != NULL) $this->session->set_userdata('reformasi_kesehatan_f', $this->input->post('reformasi_kesehatan')); else $this->session->set_userdata('reformasi_kesehatan_f', NULL);
		if($this->input->post('program') != NULL) $this->session->set_userdata('program_f', $this->input->post('program')); else $this->session->set_userdata('program_f', NULL);
		if($this->input->post('iku') != NULL) $this->session->set_userdata('iku_f', $this->input->post('iku')); else $this->session->set_userdata('iku_f', NULL);
		if($this->input->post('kegiatan') != NULL) $this->session->set_userdata('kegiatan_f', $this->input->post('kegiatan')); else $this->session->set_userdata('kegiatan_f', NULL);
		if($this->input->post('ikk') != NULL) $this->session->set_userdata('ikk_f', $this->input->post('ikk')); else $this->session->set_userdata('ikk_f', NULL);
		if($this->input->post('tupoksi') != NULL) $this->session->set_userdata('tupoksi_f', $this->input->post('tupoksi')); else $this->session->set_userdata('tupoksi_f', NULL);
		$url = base_url()."index.php/e-planning/filtering/list_filtering";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['e_planning'] = "";
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
		$data['judul'] = 'Hasil Filtering';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function list_filtering(){
		$data_ikk="";
		$data_iku="";
		$data_program="";
		$data_kegiatan="";
		$provinsi = $this->session->userdata('provinsi_f');
		$jenis_prioritas = $this->session->userdata('jenis_prioritas_f');
		$prioritas = $this->session->userdata('prioritas_f');
		$fokus_prioritas = $this->session->userdata('fokus_prioritas_f');
		$reformasi_kesehatan = $this->session->userdata('reformasi_kesehatan_f');
		$program = $this->session->userdata('program_f');
		$iku = $this->session->userdata('iku_f');
		$kegiatan = $this->session->userdata('kegiatan_f');
		$ikk = $this->session->userdata('ikk_f');
		$tupoksi = $this->session->userdata('tupoksi_f');
		if($prioritas == '1'){
			if($jenis_prioritas[0] !=Null){
				for($i=0; $i<count($jenis_prioritas); $i++){
					foreach($this->fm->get_where_double('prioritas_ikk','kdsatker',$this->session->userdata('kdsatker'),'KodeJenisPrioritas',$jenis_prioritas[$i])->result() as $row){
						$data_ikk[$row->KodeIkk] = $row->KodeIkk;
					}
					foreach($this->fm->get_where_double('prioritas_iku','kdsatker',$this->session->userdata('kdsatker'),'KodeJenisPrioritas',$jenis_prioritas[$i])->result() as $row){
						$data_iku[$row->KodeIku] = $row->KodeIku;
					}
					foreach($this->fm->get_where_double('prioritas_kegiatan','kdsatker',$this->session->userdata('kdsatker'),'KodeJenisPrioritas',$jenis_prioritas[$i])->result() as $row){
						$data_kegiatan[$row->KodeKegiatan] = $row->KodeKegiatan;
					}
					foreach($this->fm->get_where_double('prioritas_program','kdsatker',$this->session->userdata('kdsatker'),'KodeJenisPrioritas',$jenis_prioritas[$i])->result() as $row){
						$data_program[$row->KodeProgram] = $row->KodeProgram;
					}
				}
			}
		}else{
			if($ikk !=Null){
				for($i=0; $i<count($ikk); $i++){
					$data_ikk[$ikk[$i]] = $ikk[$i];
				}
			}
			if($iku !=Null){
				for($i=0; $i<count($iku); $i++){
					$data_iku[$iku[$i]] = $iku[$i];
				}
			}
			if($kegiatan !=Null){
				for($i=0; $i<count($kegiatan); $i++){
					$data_kegiatan[$kegiatan[$i]] = $kegiatan[$i];
				}
			}
			if($program !=Null){
				for($i=0; $i<count($program); $i++){
					$data_program[$program[$i]] = $program[$i];
				}
			}
		}
		
		//if($fokus_prioritas !=Null) $fokusPrioritas = 'V'; else $fokusPrioritas = 'X';
		//if($reformasi_kesehatan !=Null) $reformasiKesehatan = 'V'; else $reformasiKesehatan = 'X';
		
		$valid_fields = array('nmsatker','TANGGAL_PENGAJUAN','NILAI_PROPOSAL');
		$this->flexigrid->validate_post('kdsatker','asc',$valid_fields);
		$records = $this->fm->get_data_pengajuan($provinsi, $data_program, $data_iku, $data_kegiatan, $data_ikk, $fokus_prioritas, $reformasi_kesehatan);
		
		$array_items = array(
			'provinsi_f' => '',
			'jenis_prioritas_f' => '',
			'prioritas_f' => '',
			'fokus_prioritas_f' => '',
			'reformasi_kesehatan_f' => '',
			'program_f' => '',
			'iku_f' => '',
			'kegiatan_f' => '',
			'ikk_f' => '',
			'tupoksi_f' => ''
		);
		$this->session->unset_userdata($array_items);

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		$dataFokus =  0;
		$dataRefKes = '';
		foreach ($records['records']->result() as $row){
			$dataIkk;
			$dataIku;
			$dataProgram;
			$dataKegiatan;
			$kota;
			foreach($this->fm->get_where('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
				$dataIkk[$row2->KodeIkk] = $row2->KodeIkk;
			}
			foreach($this->fm->get_where('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row3){
				$dataIku[$row3->KodeIku] = $row3->KodeIku;
			}
			foreach($this->fm->get_where('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row4){
				$dataProgram[$row4->KodeProgram] = $row4->KodeProgram;
			}
			foreach($this->fm->get_where('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row5){
				$dataKegiatan[$row5->KodeKegiatan] = $row5->KodeKegiatan;
			}
			foreach($this->fm->get_where_double('ref_kabupaten','KodeKabupaten',$row->kdkabkota,'KodeProvinsi',$row->kdlokasi)->result() as $kab)			{
				$kota[$kab->KodeKabupaten] = $kab->NamaKabupaten;	
			}
			foreach($this->fm->get_where('data_fokus_prioritas','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row6){
				$dataFokus .= $row6->idFokusPrioritas.", ";	
			}
			foreach($this->fm->get_where('data_reformasi_kesehatan','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row7){
				$dataRefKes .= $row7->idReformasiKesehatan.", ";	
			}
			
			// hilangkan koma di belakang variabel
			$dataFokus = substr($dataFokus, 0, -2);
			$dataRefKes = substr($dataRefKes, 0, -2);
			
			/*
			if($prioritas == '1'){
				if(is_array($jenis_prioritas)){
					if(in_array('1',$jenis_prioritas)) $prioritas_nasional = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_nasional = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
					if(in_array('3',$jenis_prioritas)) $prioritas_kementrian = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_kementrian = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
					if(in_array('2',$jenis_prioritas)) $prioritas_bidang = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_bidang = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
				}else{
					if($jenis_prioritas == '1') $prioritas_nasional = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_nasional = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
					if($jenis_prioritas == '3') $prioritas_kementrian = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_kementrian = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
					if($jenis_prioritas == '2') $prioritas_bidang = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_bidang = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
				}
			}else{
			*/
				if($this->fm->cek_where_in_double_param('prioritas_ikk','KodeJenisPrioritas','1','kdsatker',$row->kdsatker,'KodeIkk',$dataIkk) == TRUE || $this->fm->cek_where_in_double_param('prioritas_kegiatan','KodeJenisPrioritas','1','kdsatker',$row->kdsatker,'KodeKegiatan',$dataKegiatan) == TRUE || $this->fm->cek_where_in_double_param('prioritas_iku','KodeJenisPrioritas','1','kdsatker',$row->kdsatker,'KodeIku',$dataIku) == TRUE || $this->fm->cek_where_in_double_param('prioritas_program','KodeJenisPrioritas','1','kdsatker',$row->kdsatker,'KodeProgram',$dataProgram) == TRUE) $prioritas_nasional = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_nasional = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
				
				if($this->fm->cek_where_in_double_param('prioritas_ikk','KodeJenisPrioritas','3','kdsatker',$row->kdsatker,'KodeIkk',$dataIkk) == TRUE || $this->fm->cek_where_in_double_param('prioritas_kegiatan','KodeJenisPrioritas','3','kdsatker',$row->kdsatker,'KodeKegiatan',$dataKegiatan) == TRUE || $this->fm->cek_where_in_double_param('prioritas_iku','KodeJenisPrioritas','3','kdsatker',$row->kdsatker,'KodeIku',$dataIku) == TRUE || $this->fm->cek_where_in_double_param('prioritas_program','KodeJenisPrioritas','3','kdsatker',$row->kdsatker,'KodeProgram',$dataProgram) == TRUE) $prioritas_kementrian = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_kementrian = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
				
				if($this->fm->cek_where_in_double_param('prioritas_ikk','KodeJenisPrioritas','2','kdsatker',$row->kdsatker,'KodeIkk',$dataIkk) == TRUE || $this->fm->cek_where_in_double_param('prioritas_kegiatan','KodeJenisPrioritas','2','kdsatker',$row->kdsatker,'KodeKegiatan',$dataKegiatan) == TRUE || $this->fm->cek_where_in_double_param('prioritas_iku','KodeJenisPrioritas','2','kdsatker',$row->kdsatker,'KodeIku',$dataIku) == TRUE || $this->fm->cek_where_in_double_param('prioritas_program','KodeJenisPrioritas','2','kdsatker',$row->kdsatker,'KodeProgram',$dataProgram) == TRUE) $prioritas_bidang = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $prioritas_bidang = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
				
				if($this->fm->cek_where_in_double_param('prioritas_ikk','KodeJenisPrioritas','0','kdsatker',$row->kdsatker,'KodeIkk',$dataIkk) == TRUE || $this->fm->cek_where_in_double_param('prioritas_kegiatan','KodeJenisPrioritas','0','kdsatker',$row->kdsatker,'KodeKegiatan',$dataKegiatan) == TRUE || $this->fm->cek_where_in_double_param('prioritas_iku','KodeJenisPrioritas','0','kdsatker',$row->kdsatker,'KodeIku',$dataIku) == TRUE || $this->fm->cek_where_in_double_param('prioritas_program','KodeJenisPrioritas','0','kdsatker',$row->kdsatker,'KodeProgram',$dataProgram) == TRUE) $non_prioritas = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $non_prioritas = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
			//}
			//if($prioritas == '2'){
				if($this->fm->cek('data_fokus_prioritas', $row->KD_PENGAJUAN, 'KD_PENGAJUAN')) $fokusPrioritas = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $fokusPrioritas = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
				if($this->fm->cek('data_reformasi_kesehatan', $row->KD_PENGAJUAN, 'KD_PENGAJUAN')) $reformasiKesehatan = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>'; else $reformasiKesehatan = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
			//}
			if($this->fm->cek('data_iku',$row->KD_PENGAJUAN,'KD_PENGAJUAN')) $datasIku = $row3->KodeIku; else $datasIku = '<p>-</p>';
			if($this->fm->cek('data_program',$row->KD_PENGAJUAN,'KD_PENGAJUAN')) $datasProg = $row4->NamaProgram; else $datasProg = '<p>-</p>';
			if($this->fm->cek('data_kegiatan',$row->KD_PENGAJUAN,'KD_PENGAJUAN')) $datasKeg = $row5->NamaKegiatan; else $datasKeg = '<p>-</p>';
			if($this->fm->cek('data_ikk',$row->KD_PENGAJUAN,'KD_PENGAJUAN')) $datasIkk = $row2->KodeIkk; else $datasIkk = '<p>-</p>';
			
			if($this->fm->cek('data_fokus_prioritas',$row->KD_PENGAJUAN,'KD_PENGAJUAN')) $fokus = $dataFokus; else $fokus = '<p>-</p>';
			if($this->fm->cek('data_reformasi_kesehatan',$row->KD_PENGAJUAN,'KD_PENGAJUAN')) $refKes = $dataRefKes; else $refKes = '<p>-</p>';
			
			$tanggal_surat = explode("-", $row->TANGGAL_PENGAJUAN);
			$tanggal_pembuatan = explode("-", $row->TANGGAL_PEMBUATAN);
			$fungsi='<a href="#" onclick="TES('.$row->KD_PENGAJUAN.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>';	
			$no = $no+1;
			$record_items[] = array(
				$row->kdsatker,
				$no,
				$row->nmsatker,
				$row->JUDUL_PROPOSAL,
				$tanggal_pembuatan[2].'-'.$tanggal_pembuatan[1].'-'.$tanggal_pembuatan[0],
				$tanggal_surat[2].'-'.$tanggal_surat[1].'-'.$tanggal_surat[0],
				$kota[$kab->KodeKabupaten] = $kab->NamaKabupaten,
				$prioritas_nasional,
				$prioritas_kementrian,
				$prioritas_bidang,
				$non_prioritas,
				$fokus,
				$refKes,
				$datasProg,
				$datasIku,
				$datasKeg,
				$datasIkk,
				number_format($this->mm->sum('data_program','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/e-planning/manajemen/edit/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/e-planning/manajemen/telaah_staff/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/manajemen/setujui_pengajuan/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin menyetujui ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/Manajemen/tolak_pengajuan/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/Manajemen/pertimbangkan_pengajuan/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/pertimbangan.jpg\'></a>',
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
}

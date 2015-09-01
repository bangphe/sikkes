<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pendaftaran extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/pendaftaran_model','pm');
		$this->load->model('e-planning/aktivitas_model','am');
		$this->load->model('e-planning/manajemen_model','mm');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	function get_alamatSatker(){
		if ($_POST['kdsatker']!='') {
			$parent = $_POST['kdsatker'];
			$data = '';
			
			$result = $this->pm->get_data_satker($parent);
			foreach ($result->result() as $row){
				$data.= $row->NamaProvinsi;
			}
			echo $data;
		}
		else
			echo '';
	}
	
	function kegiatan(){
		foreach($this->pm->get_kode_kementrian()->result() as $row){
			$Kode_kementrian = $row->KodeKementrian;
		}
		$data['kegiatan'] = $this->pm->get_kegiatan($Kode_kementrian);
		$this->load->view('e-planning/tambah_pengusulan/kegiatan',$data);
	}
	
	function volume($kode_kegiatan, $nama_kegiatan){
		$data['kode_kegiatan'] = $kode_kegiatan;
		$data['nama_kegiatan'] = $nama_kegiatan;
		$this->load->view('e-planning/tambah_pengusulan/volume',$data);
	}
	
	function sub_fungsi($kode_fungsi){
		$data['sub_fungsi'] = $this->pm->get_sub_fungsi($kode_fungsi);
		$this->load->view('e-planning/tambah_pengusulan/sub_fungsi',$data);
	}

	function json(){
	 $data='[{
		"id":1,
		"text":"Foods",
		"children":[{
			"id":2,
			"text":"Fruits",
			"state":"closed",
			"children":[{
				"text":"apple",
				"checked":true
			},{
				"text":"orange"
			}]
		},{
			"id":3,
			"text":"Vegetables",
			"state":"open",
			"children":[{
				"text":"tomato",
				"checked":true
			},{
				"text":"carrot",
				"checked":true
			},{
				"text":"cabbage"
			},{
				"text":"potato",
				"checked":true
			},{
				"text":"lettuce"
			}]
		}]
	}]';
	return encode_json($data);
	}
	
	function cek_dropdown($value){
		if($value === '0'){
			$this->form_validation->set_message('cek_dropdown', 'Kolom %s harus dipilih!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function validasi_pengajuan(){
		$config = array(
			array('field'=>'satker_', 'label'=>'Nama Satker*', 'rules'=>'callback_cek_dropdown'),
			array('field'=>'fungsi', 'label'=>'Fungsi*', 'rules'=>'callback_cek_dropdown'),
			array('field'=>'subfungsi_', 'label'=>'Sub Fungsi*', 'rules'=>'callback_cek_dropdown'),
			array('field'=>'program', 'label'=>'Program*', 'rules'=>'callback_cek_dropdown'),
			array('field'=>'kegiatan_', 'label'=>'Kegiatan*', 'rules'=>'callback_cek_dropdown'),
			array('field'=>'judul_proposal','label'=>'Judul Proposal*', 'rules'=>'required'),
			array('field'=>'nomor_proposal','label'=>'Nomor*', 'rules'=>'required'),
			array('field'=>'tanggal_pembuatan','label'=>'Tanggal Pembuatan*', 'rules'=>'required'),
			array('field'=>'tanggal_mulai','label'=>'Tanggal Mulai*', 'rules'=>'required'),
			array('field'=>'tanggal_selesai','label'=>'Tanggal Selesai*', 'rules'=>'required'),
			array('field'=>'ikk_[]','label'=>'IKK*', 'rules'=>'required'),
			array('field'=>'iku_[]','label'=>'IKU*', 'rules'=>'required'),
			array('field'=>'fokus_prioritas[]','label'=>'Fokus Prioritas*', 'rules'=>'required'),
			array('field'=>'reformasi_kesehatan[]','label'=>'Reformasi Kesehatan*', 'rules'=>'required'),
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		$this->form_validation->set_message('callback_cek_dropdown', '%s harus dipilih !!');

		return $this->form_validation->run();
	}

	function pengajuan(){
	// if($this->validasi_pengajuan() == FALSE){
			// $this->tambah_usulan();
		// }else{
		// $kd_pengajuan=$this->input->post('kd_pengajuan');
		
		$rencana_anggaran=$this->input->post('rencana_anggaran');
		$kdsatker=$this->input->post('kdsatker');
		$judul_proposal=$this->input->post('judul_proposal');
		$nomor_proposal=$this->input->post('nomor_proposal');
		$perihal=$this->input->post('perihal');
		
		$tgl_pembuatan=explode('-',$this->input->post('tanggal_pembuatan'));
		$tanggal_pembuatan= $tgl_pembuatan[2].'-'.$tgl_pembuatan[1].'-'.$tgl_pembuatan[0];
		
		$thn_anggaran=$this->input->post('thn_anggaran');
		// $triwulan=$this->input->post('triwulan');
		
		$tgl_mulai=explode('-',$this->input->post('tanggal_mulai'));
		$tanggal_mulai = $tgl_mulai[2].'-'.$tgl_mulai[1].'-'.$tgl_mulai[0];
		$tgl_selesai=explode('-',$this->input->post('tanggal_selesai'));
		$tanggal_selesai = $tgl_selesai[2].'-'.$tgl_selesai[1].'-'.$tgl_selesai[0];
		
		$latar_belakang=$this->input->post('latar_belakang');
		$analisis_situasi=$this->input->post('analisis_situasi');
		$permasalahan=$this->input->post('permasalahan');
		$alternatif_solusi=$this->input->post('alternatif_solusi');
		
		$file[1]=null;
		$file[2]=null;
		$file[3]=null;
		for($i = 1; $i <= 3; $i++) {	
			$config['upload_path'] = "./file";
			$config['allowed_types'] ='doc|docx|pdf|xls|xlsx|txt';
			$config['max_size']	= '100000';
							
			// create directory if doesn't exist
			if(!is_dir($config['upload_path']))
			mkdir($config['upload_path'], 0777);
			
			$this->load->library('upload', $config);
			//$nama_file=$this->input->post('file');
			if(!empty($_FILES['file'.$i]['name'])){			
				//$upload = $this->upload->do_upload('file'.$i);
				//$data[$i] = $this->upload->data();
				//if($data[$i]['file_size'] > 0) $file[$i] = $data[$i]['file_name'];
				if(!$this->upload->do_upload('file'.$i)){
					$notif_upload = '<font color="red"><b>'.$this->upload->display_errors("<p>Error Upload : ", "</p>").'</b></font>';
					$this->session->set_userdata('upload_file', $notif_upload);
					redirect('e-planning/pendaftaran/tambah_usulan');
				}else{
					$data[$i] = $this->upload->data();
					if($data[$i]['file_size'] > 0) $file[$i] = $data[$i]['file_name'];
				}
			}
		}
		// $waktu= $this->session->userdata('kdsatker').' '.date('Y-m-d H:i:s');
		$n = rand(0,100000);
		$kode = $this->session->userdata('kdsatker').'-'.$this->session->userdata('id_user').'-'.$n;
		$data_pengajuan = array(
			'KodeJenisSatker' => $this->session->userdata('kodejenissatker'),
			'TANGGAL_PEMBUATAN' => $tanggal_pembuatan,
			'ID_USER' => $this->session->userdata('id_user'),
			'NO_REG_SATKER' => $kdsatker,
			'JUDUL_PROPOSAL' => $judul_proposal,
			'NOMOR_SURAT' => $nomor_proposal,
			'PERIHAL' => $perihal,
			'LATAR_BELAKANG' => $latar_belakang,
			'TAHUN_ANGGARAN' => $thn_anggaran,
			'ANALISIS_SITUASI' => $analisis_situasi,
			'PERMASALAHAN' => $permasalahan,
			'ALTERNATIF_SOLUSI' => $alternatif_solusi,
			'PROPOSAL' => $file[1],
			'TOR' => $file[2],
			'DATA_PENDUKUNG_LAINNYA' => $file[3],
			// 'TRIWULAN' => $this->session->userdata('triwulan'),
			'ID_RENCANA_ANGGARAN' => $rencana_anggaran,
			'TANGGAL_MULAI' => $tanggal_mulai,
			'TANGGAL_SELESAI' => $tanggal_selesai,
			'KODE_PEMBUATAN' => $kode
		);
		// if($this->session->userdata('kodejenissatker') == 2){
			// $data_pengajuan = $data_pengajuan + array('STATUS' => '1');
		// }
		// elseif($this->session->userdata('kodejenissatker') == 3){
			// $data_pengajuan = $data_pengajuan + array('STATUS' => '2');
		// }
		$this->pm->pengajuan($data_pengajuan);
		
		$kd_pengajuan;
		// foreach($this->pm->get_KodePengajuan()->result() as $row){
			// $kd_pengajuan = $row->KodePengajuan;
		// }
		foreach($this->mm->get_where5('pengajuan','KODE_PEMBUATAN',$kode,'ID_USER',$this->session->userdata('id_user'),'JUDUL_PROPOSAL',$judul_proposal,'NOMOR_SURAT',$nomor_proposal,'PERIHAL',$perihal)->result() as $ro)
			$kd_pengajuan= $ro->KD_PENGAJUAN;
		if(isset($_POST['tupoksi'])){
		$KodeTupoksi = $this->input->post('tupoksi');
			for($i=0; $i<count($KodeTupoksi); $i++){
				$data_tupoksi = array(
					'KodeTupoksi' => $KodeTupoksi[$i],
					'KD_PENGAJUAN' => $kd_pengajuan
				);
				$this->pm->save($data_tupoksi, 'data_tupoksi');
			}
		}
		
		if(isset($_POST['reformasi_kesehatan'])){
		$idReformasiKesehatan = $this->input->post('reformasi_kesehatan');
			for($i=0; $i<count($idReformasiKesehatan); $i++){
				$data_reformasi_kesehatan = array(
					'idReformasiKesehatan' => $idReformasiKesehatan[$i],
					'KD_PENGAJUAN' => $kd_pengajuan,
					// 'Biaya' => $this->input->post('biaya_rk_'.$idReformasiKesehatan[$i])
				);
				$this->pm->save($data_reformasi_kesehatan, 'data_reformasi_kesehatan');
			}
		}
		
		if(isset($_POST['fokus_prioritas'])){
		$idFokusPrioritas = $this->input->post('fokus_prioritas');
			for($i=0; $i<count($idFokusPrioritas); $i++){
				$data_fokus_prioritas = array(
					'idFokusPrioritas' => $idFokusPrioritas[$i],
					'KD_PENGAJUAN' => $kd_pengajuan,
					// 'Biaya' => $this->input->post('biaya_fp_'.$idFokusPrioritas[$i])
				);
				$this->pm->save($data_fokus_prioritas, 'data_fokus_prioritas');
			}
		}
		
		$fungsi=$this->input->post('fungsi');
		$datafungsi;
		foreach($this->pm->get_where('ref_fungsi', $fungsi, 'KodeFungsi')->result() as $row){
		$datafungsi = array(
			'KodeFungsi' => $fungsi,
			'NamaFungsi' => $row->NamaFungsi,
			'KD_PENGAJUAN' => $kd_pengajuan
		);
		}
		$this->pm->save($datafungsi, 'data_fungsi');
		
		$subfungsi=$this->input->post('subfungsi_');
		$datasubfungsi;
		foreach($this->pm->get_where_double('ref_sub_fungsi', $subfungsi, 'KodeSubFungsi', $fungsi, 'KodeFungsi')->result() as $row){
		$datasubfungsi = array(
			'KodeSubFungsi' => $subfungsi,
			'NamaSubFungsi' => $row->NamaSubFungsi,
			'KodeFungsi' => $fungsi,
			'KD_PENGAJUAN' => $kd_pengajuan
		);
		}
		$this->pm->save($datasubfungsi, 'data_sub_fungsi');
		
		$program=$this->input->post('program');
		$dataprogram;
		foreach($this->pm->get_where('ref_program', $program, 'KodeProgram')->result() as $row){
		$dataprogram = array(
			'KodeProgram' => $program,
			'NamaProgram' => $row->NamaProgram,
			'KodeSubFungsi' => $subfungsi,
			'KodeFungsi' => $fungsi,
			'KD_PENGAJUAN' => $kd_pengajuan
		);
		}
		$this->pm->save($dataprogram, 'data_program');
		
		if(isset($_POST['iku_'])){
		$iku=$this->input->post('iku_');
		$dataiku;
			for($i=0; $i<count($iku); $i++){
				$kodeiku = $this->pm->get_where('ref_iku',$iku[$i],'KodeIku')->row()->KodeIku;
				$idtarget = str_replace(".", "_", $kodeiku);
				$dataiku = array(
					'Kodeiku' => $iku[$i],
					'KodeProgram' => $program,
					'KodeFungsi' => $fungsi,
					'KodeSubFungsi' => $subfungsi,
					'Jumlah' => $this->input->post('target_iku_'.$idtarget),
					'KD_PENGAJUAN' => $kd_pengajuan
				);
			$this->pm->save($dataiku, 'data_iku');
			}
		}
		
		$kegiatan=$this->input->post('kegiatan_');
		$datakegiatan;
		foreach($this->pm->get_where('ref_kegiatan', $kegiatan, 'KodeKegiatan')->result() as $row){
		$datakegiatan = array(
			'ID_PENANGGUNG_JAWAB' => $this->session->userdata('id_user'),
			'KodeKegiatan' => $kegiatan,
			'NamaKegiatan' => $row->NamaKegiatan,
			'KodeProgram' => $program,
			'KodeSubFungsi' => $subfungsi,
			'KodeFungsi' => $fungsi,
			'KD_PENGAJUAN' => $kd_pengajuan
		);
		}
		$this->pm->save($datakegiatan, 'data_kegiatan');
		
		if(isset($_POST['ikk_'])){
		$ikk=$this->input->post('ikk_');
			for($i=0; $i<count($ikk); $i++){
				$kodeikk = $this->pm->get_where('ref_ikk',$ikk[$i],'KodeIkk')->row()->KodeIkk;
				$idtarget = str_replace(".", "_", $kodeikk);
				$dataikk = array(
					'KodeIkk' => $ikk[$i],
					'KodeProgram' => $program,
					'KodeKegiatan' => $kegiatan,
					'KodeFungsi' => $fungsi,
					'KodeSubFungsi' => $subfungsi,
					'Jumlah' => $this->input->post('target_ikk_'.$idtarget),
					'KD_PENGAJUAN' => $kd_pengajuan
				);
			$this->pm->save($dataikk, 'data_ikk');
			}
		}
		
		//redirect('e-planning/manajemen/grid_pengajuan/');
		redirect('e-planning/manajemen/grid_aktivitas/'.$kd_pengajuan.'/'.$fungsi.'/'.$subfungsi.'/'.$program.'/'.$kegiatan);
		// }
	}
	
	function validasi_biaya(){
		$config = array(
			array('field'=>'biaya','label'=>'Biaya', 'rules'=>'required|numeric')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		$this->form_validation->set_message('numeric', '%s harus angka !!');

		return $this->form_validation->run();
	}
	
	function validasi_jumlah(){
		$config = array(
			array('field'=>'jumlah','label'=>'Jumlah', 'rules'=>'required|numeric')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		$this->form_validation->set_message('numeric', '%s harus angka !!');

		return $this->form_validation->run();
	}
	
	function tambah_menu_kegiatan($KodePengajuan,$KodeFungsi,$KodeSubFungsi,$KodeProgram,$KodeKegiatan,$KodeIkk){
		$data2['menu_kegiatan'] = $this->pm->get_menu_kegiatan($KodeProgram,$KodeKegiatan,$KodeIkk);
		$data2['KodeFungsi'] = $KodeFungsi;
		$data2['KodeSubFungsi'] = $KodeSubFungsi;
		$data2['KodePengajuan'] = $KodePengajuan;
		$data2['KodeProgram'] = $KodeProgram;
		$data2['KodeKegiatan'] = $KodeKegiatan;
		$data2['KodeIkk'] = $KodeIkk;
		$data['content'] = $this->load->view('e-planning/tambah_pengusulan/tambah_menu_kegiatan',$data2,true);
		$this->load->view('main', $data);
	}

	function cari_menu_kegiatan(){
		$keyword = $this->input->post('keyword');
		$kolom = $this->input->post('kategori');
		$data2['menu_kegiatan'] = $this->pm->search_menu_kegiatan($this->input->post('KodeIkk'),$keyword,$kolom);
		$data2['KodeFungsi'] = $this->input->post('KodeFungsi');
		$data2['KodePengajuan'] = $this->input->post('KodePengajuan');
		$data2['KodeSubFungsi'] = $this->input->post('KodeSubFungsi');
		$data2['KodeProgram'] = $this->input->post('KodeProgram');
		$data2['KodeKegiatan'] = $this->input->post('KodeKegiatan');
		$data2['KodeIkk'] = $this->input->post('KodeIkk');
		$data['content'] = $this->load->view('e-planning/tambah_pengusulan/tambah_menu_kegiatan',$data2,true);
		$this->load->view('main', $data);
	}

	function save_menu_kegiatan(){
		foreach($this->pm->cek_menu_kegiatan($this->input->post('KodePengajuan'),$this->input->post('KodeFungsi'),$this->input->post('KodeSubFungsi'), $this->input->post('KodeProgram'), $this->input->post('KodeKegiatan'), $this->input->post('KodeIkk'), $this->input->post('kode'))->result() as $row){
			$jumlah = $row->jumlah;
		}
		if($jumlah == 0){
			$data = array(
				'Kodeikk' => $this->input->post('KodeIkk'),
				'KodeProgram' => $this->input->post('KodeProgram'),
				'KodeKegiatan' => $this->input->post('KodeKegiatan'),
				'KodeFungsi' => $this->input->post('KodeFungsi'),
				'KodeSubFungsi' => $this->input->post('KodeSubFungsi'),
				'KodeMenuKegiatan' => $this->input->post('KodeMenuKegiatan'),
				'KD_PENGAJUAN' => $this->input->post('KodePengajuan'),
				'KodeMenuKegiatan' => $this->input->post('kode')
			);
			
			$this->pm->save($data, 'data_menu_kegiatan');
			redirect('e-planning/manajemen/grid_menu_kegiatan/'.$this->input->post('KodePengajuan').'/'.$this->input->post('KodeFungsi').'/'.$this->input->post('KodeSubFungsi').'/'.$this->input->post('KodeProgram').'/'.$this->input->post('KodeKegiatan').'/'.$this->input->post('KodeIkk'));
		}else{
			$data['added_js'] = 
				"<script type='text/javascript'>
					alert('Maaf, Anda sudah memilih menu kegiatan tersebut sebelumnya');
				</script>";
			$data2['menu_kegiatan'] = $this->pm->get_menu_kegiatan($this->input->post('KodeIkk'));
			$data2['KodeFungsi'] = $this->input->post('KodeFungsi');
			$data2['KodeSubFungsi'] = $this->input->post('KodeSubFungsi');
			$data2['KodePengajuan'] = $this->input->post('KodePengajuan');
			$data2['KodeProgram'] = $this->input->post('KodeProgram');
			$data2['KodeKegiatan'] = $this->input->post('KodeKegiatan');
			$data2['KodeIkk'] = $this->input->post('KodeIkk');
			$data['content'] = $this->load->view('e-planning/tambah_pengusulan/tambah_menu_kegiatan',$data2,true);
			$this->load->view('main', $data);
		}
	}
	
	// function grid_user(){
		// $colModel['no'] = array('No',20,TRUE,'center',0);
		// $colModel['nmsatker'] = array('Nama Satker',100,TRUE,'center',1);
		// $colModel['JenisSatker'] = array('Peranan',100,TRUE,'center',1);
		// $colModel['USERNAME'] = array('Username',100,TRUE,'center',1);
		// $colModel['NAMA_USER'] = array('Nama',100,TRUE,'center',1);
		// $colModel['NamaJabatan'] = array('Jabatan',100,TRUE,'center',1);
			
		// //setting konfigurasi pada bottom tool bar flexigrid
		// $gridParams = array(
			// 'width' => 'auto',
			// 'height' => '298',
			// 'rp' => 15,
			// 'rpOptions' => '[15,30,50,100]',
			// 'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			// 'blockOpacity' => 0,
			// 'title' => 'PROPOSAL DISETUJUI',
			// 'showTableToggleBtn' => false,
			// 'nowrap' => false
		// );
		
		// // mengambil data dari file controler ajax pada method grid_user		
		// $url = base_url()."index.php/e-planning/manajemen/grid_list_pengajuan_disetujui";
		// $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		// $data['js_grid'] = $grid_js;
		// $data['e_planning'] = "";
		// $data['judul'] = 'Proposal Disetujui';
		// $data['content'] = $this->load->view('grid',$data,true);
		// $this->load->view('main',$data);
	// }
	 
	 //mengambil data user di tabel login
	function grid_list_pengajuan_disetujui(){
		$valid_fields = array('NO_REG_SATKER','JUDUL_PROPOSAL','TANGGAL_PENGAJUAN','TANGGAL_PERSETUJUAN');
		$this->flexigrid->validate_post('JUDUL_PROPOSAL','asc',$valid_fields);
		$records = $this->mm->get_data_pengajuan2();

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$tanggal_pengajuan = explode('-', $row->TANGGAL_PENGAJUAN);
			$tanggal_persetujuan = explode('-', $row->TANGGAL_PERSETUJUAN);
			
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$tanggal_persetujuan[2].'-'.$tanggal_persetujuan[1].'-'.$tanggal_persetujuan[0],
				$row->NO_REG_SATKER,
				$row->rencana_anggaran,
				'<a href='.base_url().'index.php/e-planning/manajemen/grid_fungsi/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				$row->JUDUL_PROPOSAL,
				number_format($this->mm->sum('data_program','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				$row->ID_USER
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function tambah_user(){
		
		$option_jenis_satker;
		$option_role;
		$option_unit_utama;
		$option_provinsi = $this->pm->get('ref_provinsi');
		$option_kabupaten;
		$option_jenis_satker['0'] = '--- Pilih Jenis Kewenangan ---';
		foreach($this->pm->get('ref_jenis_satker')->result() as $row){
			$option_jenis_satker[$row->KodeJenisSatker] = $row->JenisSatker;
		}
		foreach($this->pm->get_where('role_login','8','KD_ROLE !=')->result() as $row){
			$option_role[$row->KD_ROLE] = $row->ROLE;
		}
		// foreach($this->pm->get('ref_unit')->result() as $row){
			// $option_unit_utama[$row->KDUNIT] = $row->NMUNIT;
		// }
		/*foreach($this->pm->get('ref_provinsi')->result() as $row){
			$option_provinsi[$row->KodeProvinsi] = $row->NamaProvinsi;
		}*/
		// foreach($this->pm->get('ref_kabupaten')->result() as $row){
			// $option_kabupaten[$row->KodeKabupaten] = $row->NamaKabupaten;
		// }
		$data['master_data'] = '';
		$data['jenis_satker'] = $option_jenis_satker;
		$data['role'] = $option_role;
		// $data['unit_utama'] = $option_unit_utama;
		$data['provinsi'] = $option_provinsi;
		// $data['kabupaten'] = $option_kabupaten;
		$data['eselon1'] = $this->pm->get('ref_eselon1');
		$data['content'] = $this->load->view('e-planning/master/tambah_user',$data,true);
		$this->load->view('main',$data);
	}

	function save_user(){
		if($this->validasi_user() == FALSE){
			$this->tambah_user();
		}else{
			$nama = $this->input->post('nama');
			//$peran = $this->input->post('peran');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$alamat = $this->input->post('alamat');
			$telp = $this->input->post('telp');
			$email = $this->input->post('email');
			$role = $this->input->post('role');
			if($role != '1' && $role != '5' && $role != '3' && $role != '4'){
				$jenis_satker = '3';
				$kdunit = '01';
				$kdprovinsi = '01';
				$kdkabupaten = '54';
				$kdsatker = '465915';
				if($this->input->post('jns_jabatan') == 'eselon'){
					$jabatan = explode('-',$this->input->post('jabatan'));
					$NamaJabatan = $jabatan[2];
					$eselon = $jabatan[0];
					$kode_eselon = $jabatan[1];
				}
				else{
					$NamaJabatan = 'Staf';
					$eselon = '0';
					$kode_eselon = '-';
				}
				}
			else{
				$jenis_satker = $this->input->post('peran');
				if($this->input->post('peran') == '1'){
					$kdprovinsi = $this->input->post('provinsi');
					$kdkabupaten = $this->input->post('kabupaten');
					$kdsatker = $this->input->post('satker_');
					$kdunit = $this->pm->get_where('ref_satker',$kdsatker,'kdsatker')->row()->kdunit;
					$NamaJabatan = '-';
					$eselon = '0';
					$kode_eselon = '-';
				}
				else{
					$kdsatker = $this->input->post('satker_');
					foreach($this->pm->get_where('ref_satker',$kdsatker,'kdsatker')->result() as $row){
						$kdprovinsi = $row->kdlokasi;
						$kdkabupaten = $row->kdkabkota;
						$kdunit = $row->kdunit;
					}
				}
				if($this->input->post('jns_jabatan') == 'eselon'){
					$jabatan = explode('-',$this->input->post('jabatan'));
					$NamaJabatan = $jabatan[2];
					$eselon = $jabatan[0];
					$kode_eselon = $jabatan[1];
				}
				else{
					$NamaJabatan = 'Staf';
					$eselon = '0';
					$kode_eselon = '-';
				}
			}
			
			$data_user = array(
				'USERNAME' => $username,
				'KD_ROLE' => $role,
				'PASS_USER' => md5($password),
				'kdsatker' => $kdsatker,
				'NAMA_USER' => $nama,
				'KodeJenisSatker' => $jenis_satker,
				'KDUNIT' => $kdunit,
				'KodeKabupaten' => $kdkabupaten,
				'KodeProvinsi' => $kdprovinsi,
				'ALAMAT_USER' => $alamat,
				'TELP_USER' => $telp,
				'EMAIL_USER' => $email,
				'NAMA_JABATAN' => $NamaJabatan,
				'KODE_JABATAN' => $kode_eselon,
				'ESELON' =>$eselon
			);
			$this->pm->save($data_user, 'users');
			// if($this->input->post('peran') == '3')
				// $this->pm->update('users', array('KDUNIT' => $kdunit), 'USERNAME', $username);
			// foreach($this->pm->get_max('users','USER_ID','userID')->result() as $row){
				// $userID = $row->userID;
			// }
			// foreach($this->pm->get_where('role_login',$role,'KD_ROLE')->result() as $row){
				// $jabatan = $row->ROLE;
			// }
			
				// $data_jabatan = array(
					// 'NamaJabatan' => $NamaJabatan,
					// 'KodeEselon' => $kode_eselon,
					// 'Eselon' =>$eselon,
					// 'USER_ID' => $userID
				// );
			// $this->pm->save($data_jabatan, 'data_jabatan');
			
			redirect('master_data/master_user');
		}
	}
	
	function validasi_user(){
		$config = array(
			array('field'=>'satker_','label'=>'Nama Satker*', 'rules'=>'required'),
			array('field'=>'nama','label'=>'Nama*', 'rules'=>'required'),
			array('field'=>'email','label'=>'Email*', 'rules'=>'required'),
			array('field'=>'telp','label'=>'Telepon*', 'rules'=>'required'),
			array('field'=>'alamat','label'=>'Alamat*', 'rules'=>'required'),
			array('field'=>'jabatan','label'=>'Jabatan*', 'rules'=>'required'),
			array('field'=>'username','label'=>'Username*', 'rules'=>'required'),
			array('field'=>'password','label'=>'Password*', 'rules'=>'required'),
			array('field'=>'confpass','label'=>'Confirm Password*', 'rules'=>'required')
		);
	
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		return $this->form_validation->run();
	}
	function get_jenis_kewenangan_penyetuju()
	{
		$query = $this->mm->get_where3('ref_jenis_satker', 'KodeJenisSatker !=', '1', 'KodeJenisSatker !=', '4', 'KodeJenisSatker !=', '5');
		$i=0;
		foreach($query->result() as $jns)
		{
			$datajson[$i]['KodeJenisKewenangan'] = $jns->KodeJenisSatker;
			$datajson[$i]['JenisKewenangan'] = $jns->JenisSatker;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_jenis_kewenangan()
	{
		$query = $this->pm->get('ref_jenis_satker');
		$i=0;
		foreach($query->result() as $kab)
		{
			$datajson[$i]['KodeJenisKewenangan'] = $kab->KodeJenisSatker;
			$datajson[$i]['JenisKewenangan'] = $kab->JenisSatker;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	//get data kabupaten
	function get_kab($kode)
	{
		$query = $this->pm->get_where_double('ref_kabupaten', $kode, 'KodeProvinsi', '00', 'KodeKabupaten !=');
		$i=0;
		foreach($query->result() as $kab)
		{
			$datajson[$i]['KodeKabupaten'] = $kab->KodeKabupaten;
			$datajson[$i]['NamaKabupaten'] = $kab->NamaKabupaten;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	
	function get_kab_all($kode)
	{
		$query = $this->pm->get_where('ref_kabupaten', $kode, 'KodeProvinsi');
		$i=0;
		foreach($query->result() as $kab)
		{
			$datajson[$i]['KodeKabupaten'] = $kab->KodeKabupaten;
			$datajson[$i]['NamaKabupaten'] = $kab->NamaKabupaten;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_satker($kode1,$kode2)
	{
		$query = $this->pm->get_satker_tp($kode1, $kode2);
		$i=0;
		foreach($query->result() as $stk)
		{
			$datajson[$i]['kdsatker'] = $stk->kdsatker;
			$datajson[$i]['nmsatker'] = $stk->nmsatker.' ('.$stk->kdunit.')';
			$i++;
		}
		echo json_encode($datajson);
	}
	function get_satker_unit_utama()
	{
		$query = $this->pm->get_satker_unit_utama();
		$i=0;
		foreach($query->result() as $stk)
		{
			$datajson[$i]['kdsatker'] = $stk->kdsatker;
			$datajson[$i]['nmsatker'] = $stk->nmsatker;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_satker_kp()
	{
		$query = $this->pm->get_satker_kp();
		$i=0;
		foreach($query->result() as $stk)
		{
			$datajson[$i]['kdsatker'] = $stk->kdsatker;
			$datajson[$i]['nmsatker'] = $stk->nmsatker;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_satker_kd()
	{
		$query = $this->pm->get_satker_kd();
		$i=0;
		foreach($query->result() as $stk)
		{
			$datajson[$i]['kdsatker'] = $stk->kdsatker;
			$datajson[$i]['nmsatker'] = $stk->nmsatker;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_satker_dekon()
	{
		$i=0;
		$query2 = $this->pm->get_satker_provinsi();
		foreach($query2->result() as $stk)
		{
			$datajson[$i]['kdsatker'] = $stk->kdsatker;
			$datajson[$i]['nmsatker'] = $stk->nmsatker.' ('.$stk->kdunit.')';
			$i++;
		}
		echo json_encode($datajson);
	}
	function get_jabatan($kode)
	{
	
		$i=0; $j=0; $k=0; $l=0;
		foreach($this->pm->get_where('ref_eselon1', $kode, 'kdunit')->result() as $row1)
		{
			$datajson[$i]['kodeJabatan'] = '1-'.$row1->kdunit.'-'.$row1->eselon1;
			$datajson[$i]['namaJabatan'] = $row1->eselon1;
			$i++;
			foreach ($this->pm->get_where('ref_eselon2', $kode, 'kdunit')->result() as $row2){
				$datajson[$i]['kodeJabatan'] = '2-'.$kode.'.'.$row2->id_eselon2.'-'.$row2->eselon2;
				$datajson[$i]['namaJabatan'] = '- '.$row2->eselon2;
				$es2=$row2->id_eselon2;
				$i++;
				foreach ($this->pm->get_where_double('ref_eselon3', $kode, 'kdunit', $es2, 'id_eselon2')->result() as $row3){
					$datajson[$i]['kodeJabatan'] = '3-'.$kode.'.'.$row2->id_eselon2.'.'.$row3->id_eselon3.'-'.$row3->eselon3;
					$datajson[$i]['namaJabatan'] = '- - '.$row3->eselon3;
					$es3=$row3->id_eselon3;
					$i++;
					foreach ($this->pm->get_where_triple('ref_eselon4', $kode, 'kdunit', $es2, 'id_eselon2',$es3, 'id_eselon3')->result() as $row4){
						$datajson[$i]['kodeJabatan'] = '4-'.$kode.'.'.$row2->id_eselon2.'.'.$row3->id_eselon3.'.'.$row4->id_eselon4.'-'.$row4->eselon4;
						$datajson[$i]['namaJabatan'] = '- - - '.$row4->eselon4;
						$i++;
					}
				}
			}
		}
		
		echo json_encode($datajson);
	}
	
	function tambah_usulan(){
		$kdsatker = $this->session->userdata('kdsatker');
		$thn_anggaran = $this->session->userdata('thn_anggaran');
		$option_rencana_anggaran;
		$option_jenis_satker;
		$option_rencana_anggaran['0'] = '--- Pilih Sumber Dana ---';
		foreach ($this->pm->get('ref_rencana_anggaran')->result() as $row){
			$option_rencana_anggaran[$row->id_rencana_anggaran] = $row->rencana_anggaran;
		}
		$kdsatker= $this->session->userdata('kdsatker');
		$selected_state = '-';
		$selected_worker = 0;
		if($kdsatker!=NULL){
			foreach($this->pm->get_data_satker($kdsatker)->result() as $row){
				$selected_state = $row->NamaProvinsi;
				$selected_worker = $row->kdsatker;
			}
		}
		$option_provinsi['0'] = '-- Pilih Provinsi --';
		foreach ($this->pm->get_provinsi()->result() as $row){
			$option_provinsi[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$option_satker['0'] = '-- Pilih SatKer --';
		foreach($this->pm->get_satker()->result() as $row){
			$option_satker[$row->kdsatker] = $row->nmsatker;
		}
		foreach($this->pm->get('ref_jenis_satker')->result() as $row){
			$option_jenis_satker[$row->KodeJenisSatker] = $row->JenisSatker;
		}
		$KodePengajuan;
		foreach($this->pm->get_KodePengajuan()->result() as $row){
			$KodePengajuan = $row->KodePengajuan+1;
		}
		
		$data2['fungsi']=$this->pm->get_where('ref_fungsi','1','KodeStatus');
		
		// if($this->pm->cek1('ref_satker_program','kdsatker',$kdsatker))
		$data2['program']=$this->pm->get_program_satker();
		// else $data2['program']=$this->pm->get_where_double('ref_program','1','KodeStatus','024','KodeKementerian');
		// }
		$data2['tgl']=date('d-m-Y');
		$data2['kd_pengajuan'] = $KodePengajuan;
		$data2['kdsatker'] = $kdsatker;
		$data2['thn_anggaran'] = $thn_anggaran;
		$data2['reformasi_kesehatan'] = $this->pm->get('reformasi_kesehatan')->result();
		$data2['fokus_prioritas'] = $this->pm->get('fokus_prioritas')->result();
		$data['e_planning'] = "";
		$data2['tupoksi'] = $this->pm->get_where('ref_tupoksi',$this->session->userdata('kdsatker'),'kdsatker')->result();
		$data2['jenis_satker'] = $option_jenis_satker;
		$data2['rencana_anggaran'] = $option_rencana_anggaran;
		$data2['rencana_anggaran'] = $option_rencana_anggaran;
		$data2['selected_state'] = $selected_state;
		$data2['selected_worker'] = $selected_worker;
		$data2['provinsi'] = $option_provinsi;
		$data2['satker'] = $option_satker;
		$data['judul'] = 'pengajuan proposal -1-';
		
		$option_jenis_pembiayaan=NULL;
		$option_satuan=NULL;
		$option_jenis_usulan=NULL;
		foreach($this->am->get('ref_jenis_usulan')->result() as $row){
			$option_jenis_usulan[$row->KodeJenisUsulan] = $row->JenisUsulan;
		}
		foreach($this->am->get('ref_satuan')->result() as $row){
			$option_satuan[$row->KodeSatuan] = $row->Satuan;
		}
		foreach($this->am->get('ref_jenis_pembiayaan')->result() as $row){
			$option_jenis_pembiayaan[$row->KodeJenisPembiayaan] = $row->JenisPembiayaan;
		}
		$data2['jenis_pembiayaan'] = $option_jenis_pembiayaan;
		$data2['satuan'] = $option_satuan;
		$data2['jenis_usulan'] = $option_jenis_usulan;
		$data2['error_file'] = '';
		if($this->session->userdata('upload_file') != ''){
			$data2['error_file'] = $this->session->userdata('upload_file');
			$this->session->unset_userdata('upload_file');
		} 
		//tampil form pengajuan proposal
		// if ($this->session->userdata('kdsatker') == '465915' || $this->session->userdata('kodeprovinsi') == '13') {
			$data['content'] = $this->load->view('e-planning/tambah_pengusulan/pengajuan1',$data2,true);
		// }
		// else {
		// 	$data['content'] = $this->load->view('e-planning/tambah_pengusulan/tutup',$data2,true);
		// }
		//$data['content'] = $this->load->view('e-planning/tambah_pengusulan/pengajuan1',$data2,true);
		
		//menutup form pengajuan proposal
		//$data['content'] = $this->load->view('e-planning/tambah_pengusulan/tutup',$data2,true);
		$this->load->view('main',$data);
	}
	function get_outcome($kode1)
	{
		$query = $this->pm->get_where('ref_program', $kode1, 'KodeProgram');
		$i=0;
		foreach($query->result() as $row)
		{
			$datajson[$i]['OutComeProgram'] = $row->OutComeProgram;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	
	// function get_output($kode1)
	// {
	// 	$query = $this->pm->get_where('ref_output', $kode1, 'KodeKegiatan');
	// 	$i=0;
	// 	foreach($query->result() as $row)
	// 	{
	// 		$datajson[$i]['KodeOutput'] = $row->KodeOutput;
	// 		$datajson[$i]['Output'] = $row->Output;
	// 		$i++;
	// 	}
		
	// 	echo json_encode($datajson);
	// }
	function get_output($kode1)
	{
		$query = $this->pm->get_where('t_output', $kode1, 'kdgiat');
		$i=0;
		foreach($query->result() as $row)
		{
			$datajson[$i]['KodeOutput'] = $row->kdoutput;
			$datajson[$i]['Output'] = $row->nmoutput;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_sub($kode1)
	{
		$query = $this->pm->get_where_double('ref_sub_fungsi', $kode1, 'KodeFungsi', '1', 'KodeStatus');
		$i=0;
		foreach($query->result() as $row)
		{
			$datajson[$i]['KodeSub'] = $row->KodeSubFungsi;
			$datajson[$i]['NamaSub'] = $row->NamaSubFungsi;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_iku($kode1)
	{
		// if($this->pm->cek1('ref_satker_iku','kdsatker',$this->session->userdata('kdsatker')))
		$tahun = $this->mm->get_where('ref_tahun_anggaran','thn_anggaran',$this->session->userdata('thn_anggaran'))->row()->idThnAnggaran;
		$query = $this->pm->get_iku_satker($kode1);
		// else
		// $query = $this->pm->get_where_double('ref_iku', $kode1, 'KodeProgram', '1', 'KodeStatus');
		$i=0;
		foreach($query->result() as $row)
		{
			$datajson[$i]['KodeIku'] = $row->KodeIku;
			$datajson[$i]['Iku'] = $row->Iku;
			// foreach($this->pm->get_where('target_iku', $row->KodeIku, 'KodeIku')->result() as $r){
			// 	$datajson[$i]['TargetNasional'] = $r->TargetNasional;
			// }
			foreach($this->pm->get_target_iku($row->KodeIku,$tahun)->result() as $r){
				$datajson[$i]['TargetNasional'] = $r->TargetNasional;
			}
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_ikk($kode1)
	{
		// if($this->pm->cek1('ref_satker_ikk','kdsatker',$this->session->userdata('kdsatker')))
		$query = $this->pm->get_ikk_satker($kode1);
		// else
		// $query = $this->pm->get_where_double('ref_ikk', $kode1, 'KodeKegiatan', '1', 'KodeStatus');
		$i=0;
		foreach($query->result() as $row)
		{
			$datajson[$i]['KodeIkk'] = $row->KodeIkk;
			$datajson[$i]['Ikk'] = $row->Ikk;
			foreach($this->pm->get_where('target_ikk', $row->KodeIkk, 'KodeIkk')->result() as $r){
				$datajson[$i]['TargetNasional'] = $r->TargetNasional;
			}
			$i++;
		}
		
		echo json_encode($datajson);
	}
	
	function get_keg($kode1)
	{
		// if($this->pm->cek1('ref_satker_kegiatan','kdsatker',$this->session->userdata('kdsatker')))
		$query = $this->pm->get_kegiatan_satker($kode1);
		//$query = $this->pm->get_kegiatan_satker($kode1,$kode2,$kode3);
		// else
		// $query = $this->pm->get_where_triple('ref_kegiatan', $kode1, 'KodeFungsi', $kode1.'.'.$kode2, 'KodeSubFungsi', $kode3, 'KodeProgram');
		$i=0;
		
		if($query->num_rows >0){
		foreach($query->result() as $row)
		{	
			$datajson[$i]['KodeKeg'] = $row->KodeKegiatan;
			$datajson[$i]['NamaKeg'] = $row->NamaKegiatan;
			$i++;
		}
		}
		else
		{	$datajson[0]['KodeKeg'] = '0';
			$datajson[0]['NamaKeg'] = 'Tidak ada kegiatan';
		}
		
		 
		echo json_encode($datajson);
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aktivitas extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/Aktivitas_model','am');
		$this->load->model('e-planning/Pendaftaran_model','pm');
		$this->load->model('role_model');
	}
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	
	function grid_aktivitas($KD_PENGAJUAN, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['DetailUsulan'] = array('Detail Usulan',350,TRUE,'center',1);
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['DetailUsulanUpd'] = array('Detail Usulan (Perubahan)',350,TRUE,'center',1);
		}
		$colModel['JenisUsulan'] = array('Jenis Usulan',100,TRUE,'center',1);
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['JenisUsulanUpd'] = array('Jenis Usulan (Perubahan)',135,TRUE,'center',1);
		}
		$colModel['Perincian'] = array('Perincian',250,TRUE,'center',1);
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['PerincianUpd'] = array('Perincian (Perubahan)',250,TRUE,'center',1);
		}
		$colModel['Volume'] = array('Volume',100,TRUE,'right',1);
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['VolumeUpd'] = array('Volume (Perubahan)',100,TRUE,'center',1);
		}
		$colModel['Satuan'] = array('Satuan',100,TRUE,'center',1);
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['SatuanUpd'] = array('Satuan (Perubahan)',100,TRUE,'center',1);
		}
		$colModel['HargaSatuan'] = array('Harga Satuan',100,TRUE,'right',1);
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['HargaSatuanUpd'] = array('Harga Satuan (Perubahan)',100,TRUE,'center',1);
		}
		$colModel['Jumlah'] = array('Jumlah',100,TRUE,'right',1);
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['JumlahUpd'] = array('Jumlah (Perubahan)',100,TRUE,'center',1);
		}
		$colModel['JenisPembiayaan'] = array('Jenis Pembiayaan',100,TRUE,'center',1);
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['JenisPembiayaanUpd'] = array('Jenis Pembiayaan (Perubahan)',100,TRUE,'center',1);
		}
		$colModel['UBAH'] = array('Ubah',50,TRUE,'center',0);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		$colModel['HAPUS'] = array('Hapus',50,TRUE,'center',0);
		
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'RAB',
			'nowrap' => false,
			'showTableToggleBtn' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/aktivitas/list_aktivitas/".$KD_PENGAJUAN."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."/".$KodeKegiatan;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali ke Daftar Proposal
					</button>
					</form>
				</div>";
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/aktivitas/tambah_aktivitas/".$KD_PENGAJUAN."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."/".$KodeKegiatan."'
			}			
		} </script>";
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
		$data['judul'] = 'RAB';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function list_aktivitas($KD_PENGAJUAN,$KodeFungsi,$KodeSubFungsi,$KodeProgram,$KodeKegiatan){
		$valid_fields = array('JudulUsulan','JenisUsulan','Perincian','Volume','Satuan','HargaSatuan','Jumlah','JenisPembiayaan');
		$this->flexigrid->validate_post('aktivitas.KodeAktivitas','desc',$valid_fields);
		$records = $this->am->get_aktivitas($KD_PENGAJUAN);
		//$records2 = $this->am->get_aktivitas_update($KD_PENGAJUAN);

		$this->output->set_header($this->config->item('json_header'));
		$no = 0;
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT) {
			foreach ($records['records']->result() as $row){
				$no = $no+1;
				$cek_usulan = $this->am->cek_usulan_update($row->KD_PENGAJUAN, $row->KodeAktivitas);
				if($cek_usulan==TRUE) {
					$data_usulan = $this->am->get_usulan_update($row->KD_PENGAJUAN, $row->KodeAktivitas);
					foreach($data_usulan->result() as $row2) {
						$judul_update = $row2->JudulUsulan;
						$jenis_update = $row2->JenisUsulan;
						$perincian_update = $row2->Perincian;
						$volume_update = $row2->Volume;
						$satuan_update = $row2->Satuan;
						$hargasatuan_update = 'Rp '.number_format($row2->HargaSatuan);
						$jumlah_update = 'Rp '.number_format($row2->Jumlah);
						$jenis_pembiayaan_update = $row2->JenisPembiayaan;
					}
				}
				else {
					$judul_update = '-';
					$jenis_update = '-';
					$perincian_update = '-';
					$volume_update = '-';
					$satuan_update = '-';
					$hargasatuan_update = '-';
					$jumlah_update = '-';
					$jenis_pembiayaan_update ='-';
				}
				$record_items[] = array(
					$row->KodeAktivitas,
					$no,
					$row->JudulUsulan,
					$judul_update,
					$row->JenisUsulan,
					$jenis_update,
					$row->Perincian,
					$perincian_update,
					$row->Volume,
					$volume_update,
					$row->Satuan,
					$satuan_update,
					'Rp '.number_format($row->HargaSatuan),
					$hargasatuan_update,
					'Rp '.number_format($row->JumlahUpdate),
					$jumlah_update,
					$row->JenisPembiayaan,
					$jenis_pembiayaan_update,
					'<a href='.site_url().'/e-planning/aktivitas/update_aktivitas_/'.$row->KD_PENGAJUAN.'/'.$row->KodeAktivitas.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
					'<a href='.site_url().'/e-planning/aktivitas/detail_aktivitas/'.$row->KD_PENGAJUAN.'/'.$row->KodeAktivitas.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					'<a href='.site_url().'/e-planning/aktivitas/delete/'.$row->KD_PENGAJUAN.'/'.$row->KodeAktivitas.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
				);
			}
			if(isset($record_items))
				$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
			else
				$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		} else {
			foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
					$row->KodeAktivitas,
					$no,
					$row->JudulUsulan,
					$row->JenisUsulan,
					$row->Perincian,
					$row->Volume,
					$row->Satuan,
					'Rp '.number_format($row->HargaSatuan),
					'Rp '.number_format($row->Jumlah),
					$row->JenisPembiayaan,
					'<a href='.site_url().'/e-planning/aktivitas/update_aktivitas/'.$row->KD_PENGAJUAN.'/'.$row->KodeAktivitas.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
					'<a href='.site_url().'/e-planning/aktivitas/detail_aktivitas/'.$row->KD_PENGAJUAN.'/'.$row->KodeAktivitas.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					'<a href='.site_url().'/e-planning/aktivitas/delete/'.$row->KD_PENGAJUAN.'/'.$row->KodeAktivitas.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
				);
			}
			if(isset($record_items))
				$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
			else
				$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		}
	}
	
	function tambah_aktivitas($KD_PENGAJUAN, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$option_jenis_pembiayaan=NULL;
		$option_jenis_pembiayaan['0']= '--- Pilih Jenis Pembiayaan ---';
		$option_satuan=NULL;
		$option_satuan['0'] = '--- Pilih Satuan ---';
		$option_jenis_usulan=NULL;
		$option_jenis_usulan['0']='--- Pilih Jenis Usulan ---';
		$option_rincian_kegiatan=NULL;
		$option_rincian_kegiatan['0']='--- Pilih Rincian Kegiatan ---';
		foreach($this->am->get('ref_rincian_kegiatan')->result() as $row){
			$option_rincian_kegiatan[$row->idrincian] = $row->nmrincian;
		}
		
		foreach($this->am->get('ref_jenis_usulan')->result() as $row){
			$option_jenis_usulan[$row->KodeJenisUsulan] = $row->JenisUsulan;
		}
		
		foreach($this->am->get('ref_satuan')->result() as $row){
			$option_satuan[$row->KodeSatuan] = $row->Satuan;
		}
		
		foreach($this->am->get('ref_jenis_pembiayaan')->result() as $row){
			$option_jenis_pembiayaan[$row->KodeJenisPembiayaan] = $row->JenisPembiayaan;
		}
		
		if($this->am->get_where('pengajuan','KD_PENGAJUAN',$KD_PENGAJUAN)->row()->ID_RENCANA_ANGGARAN == 2 && $option_jenis_usulan == NULL) $data['notif'] = 'Anda belum mengisi menu kegiatan';
		else $data['notif'] = '';
		$data['idRencanaAnggaran'] = $this->am->get_where('pengajuan','KD_PENGAJUAN',$KD_PENGAJUAN)->row()->ID_RENCANA_ANGGARAN;
		$data['jenis_pembiayaan'] = $option_jenis_pembiayaan;
		// $data['rincian_kegiatan'] = $this->am->get_rincian_kegiatan();
		$data['rincian_kegiatan'] = $option_rincian_kegiatan;
		$data['satuan'] = $option_satuan;
		$data['KD_PENGAJUAN'] = $KD_PENGAJUAN;
		$data['jenis_usulan'] = $option_jenis_usulan;
		$data['KodeFungsi'] = $KodeFungsi;
		$data['KodeSubFungsi'] = $KodeSubFungsi;
		$data['KodeProgram'] = $KodeProgram;
		$data['KodeKegiatan'] = $KodeKegiatan;
		$data['fokus_prioritas'] = $this->am->get_where_join('data_fokus_prioritas','KD_PENGAJUAN',$KD_PENGAJUAN,'fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas')->result();
		$data['reformasi_kesehatan'] = $this->am->get_where_join('data_reformasi_kesehatan','KD_PENGAJUAN',$KD_PENGAJUAN,'reformasi_kesehatan','data_reformasi_kesehatan.idReformasiKesehatan=reformasi_kesehatan.idReformasiKesehatan')->result();
		$data['content'] = $this->load->view('e-planning/tambah_pengusulan/aktivitas_pengusulan',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_aktivitas($idRencanaAnggaran,$KD_PENGAJUAN){
		$KodeFungsi = $this->input->post('KodeFungsi');
		$KodeSubFungsi = $this->input->post('KodeSubFungsi');
		$KodeProgram = $this->input->post('KodeProgram');
		$KodeKegiatan = $this->input->post('KodeKegiatan');
		$satuan='';
		foreach($this->am->get_where('ref_satuan','KodeSatuan',$this->input->post('satuan'))->result() as $row){
			$satuan = $row->Satuan;
		}
		if($this->input->post('rinci_1') != null) $rinci1= $this->input->post('rinci_1').' '.$this->input->post('rinci_2');
		else $rinci1='';
		if($this->input->post('rinci_3') != null) 
			if($this->input->post('rinci_1') != null) $rinci2= ' x '.$this->input->post('rinci_3').' '.$this->input->post('rinci_4');
			else $rinci2= $this->input->post('rinci_3').' '.$this->input->post('rinci_4');
		else $rinci2='';
		if($this->input->post('rinci_5') != null) 
			if($this->input->post('rinci_1') != null || $this->input->post('rinci_3') != null) $rinci3= ' x '.$this->input->post('rinci_5').' '.$this->input->post('rinci_6');
			else $rinci3= $this->input->post('rinci_5').' '.$this->input->post('rinci_6');
		else $rinci3='';
		if($this->input->post('rinci_7') != null) 
			if($this->input->post('rinci_1') != null || $this->input->post('rinci_3') != null || $this->input->post('rinci_5') != null) $rinci4= ' x '.$this->input->post('rinci_7').' '.$this->input->post('rinci_8');
			else $rinci4= $this->input->post('rinci_7').' '.$this->input->post('rinci_8');
		else $rinci4='';
		
		$perincian = $rinci1.$rinci2.$rinci3.$rinci4;
		// if($this->validasi() == FALSE){
			// $this->tambah_aktivitas($KD_PENGAJUAN, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan);
		// }
		// else{
		$usulan='';
		if($this->input->post('rincian') == '1'){
			$idrincian=$this->input->post('rincian_kegiatan');
			$usulan = $this->am->get_rincian_by_id($idrincian)->row()->nmrincian;
			$idkeg = $this->am->get_rincian_by_id($idrincian)->row()->idkeg;
			$data_rincian = array('idrincian' => $idrincian, 'idkeg' => $idkeg);
			
		}
		else {
			$usulan = $this->input->post('judul_usulan');
		}
		
		$data = array(
			'KD_PENGAJUAN' => $KD_PENGAJUAN,
			'idRencanaAnggaran' => $idRencanaAnggaran,
			'KodeJenisUsulan' => $this->input->post('jenis_usulan'),
			'JudulUsulan' => $usulan,
			'Perincian' => $perincian,
			'KodeSatuan' => $this->input->post('satuan'),
			'HargaSatuan' => $this->input->post('harga_satuan'),
			'Jumlah' => $this->input->post('jumlah'),
			'JumlahUpdate' => $this->input->post('jumlah'),
			'KodeJenisPembiayaan' => $this->input->post('jenis_pembiayaan'),
			'Perincian_1' => $this->input->post('rinci_1'),
			'Perincian_2' => $this->input->post('rinci_3'),
			'Perincian_3' => $this->input->post('rinci_5'),
			'Perincian_4' => $this->input->post('rinci_7'),
			'SatuanPerincian_1' => $this->input->post('rinci_2'),
			'SatuanPerincian_2' => $this->input->post('rinci_4'),
			'SatuanPerincian_3' => $this->input->post('rinci_6'),
			'SatuanPerincian_4' => $this->input->post('rinci_8'),
			'Volume' => $this->input->post('volume'),
		);

		if($this->input->post('rincian') == '1'){
			$data = $data + $data_rincian;
			
		}
		$this->am->save('aktivitas', $data);
		$KodeAktivitas = $this->am->get_max('aktivitas','KodeAktivitas');
		// if($this->session->userdata('kd_role') == Role_model::DIREKTORAT) {
		// 	$data_update = array(
		// 		'KD_PENGAJUAN' => $KD_PENGAJUAN,
		// 		'KodeAktivitas'=>$KodeAktivitas,
		// 		'idRencanaAnggaran' => $idRencanaAnggaran,
		// 		'KodeJenisUsulan' => $this->input->post('jenis_usulan'),
		// 		'JudulUsulan' => $usulan,
		// 		'Perincian' => $perincian,
		// 		'KodeSatuan' => $this->input->post('satuan'),
		// 		'HargaSatuan' => $this->input->post('harga_satuan'),
		// 		'Jumlah' => $this->input->post('jumlah'),
		// 		'KodeJenisPembiayaan' => $this->input->post('jenis_pembiayaan'),
		// 		'Perincian_1' => $this->input->post('rinci_1'),
		// 		'Perincian_2' => $this->input->post('rinci_3'),
		// 		'Perincian_3' => $this->input->post('rinci_5'),
		// 		'Perincian_4' => $this->input->post('rinci_7'),
		// 		'SatuanPerincian_1' => $this->input->post('rinci_2'),
		// 		'SatuanPerincian_2' => $this->input->post('rinci_4'),
		// 		'SatuanPerincian_3' => $this->input->post('rinci_6'),
		// 		'SatuanPerincian_4' => $this->input->post('rinci_8'),
		// 		'Volume' => $this->input->post('volume'),
		// 	);
		// 	$this->am->save('aktivitas_update', $data_update);
		// }
		$fokus_prioritas = $this->input->post('fokus_prioritas');
		if($fokus_prioritas[0]!=NULL){
			for($i=0;$i<count($fokus_prioritas);$i++){
				$this->am->save('fp_aktivitas', array('KodeAktivitas'=>$KodeAktivitas,'idFokusPrioritas'=>$fokus_prioritas[$i]));
				$datafp= array('Biaya' => $this->pm->get_biaya_fp($KD_PENGAJUAN,$fokus_prioritas[$i]));
				$this->pm->update2('data_fokus_prioritas', array('Biaya' => '0'), 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idFokusPrioritas', $fokus_prioritas[$i]);
				$this->pm->update2('data_fokus_prioritas', $datafp, 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idFokusPrioritas', $fokus_prioritas[$i]);
			}
		}
		$reformasi_kesehatan = $this->input->post('reformasi_kesehatan');
		if($reformasi_kesehatan[0]!=NULL){
			for($i=0;$i<count($reformasi_kesehatan);$i++){
				$this->am->save('rk_aktivitas', array('KodeAktivitas'=>$KodeAktivitas,'idReformasiKesehatan'=>$reformasi_kesehatan[$i]));
				$datark= array('Biaya' => $this->pm->get_biaya_rk($KD_PENGAJUAN,$reformasi_kesehatan[$i]));
				$this->pm->update2('data_reformasi_kesehatan', array('Biaya' => '0'), 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idReformasiKesehatan', $reformasi_kesehatan[$i]);
				$this->pm->update2('data_reformasi_kesehatan', $datark, 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idReformasiKesehatan', $reformasi_kesehatan[$i]);
			}
		}
		redirect('e-planning/aktivitas/grid_aktivitas/'.$KD_PENGAJUAN.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan);
	// }
	}
	
	function validasi(){
		$config = array(
			array('field'=>'jenis_usulan','label'=>'Jenis Usulan*', 'rules'=>'required'),
			array('field'=>'judul_usulan','label'=>'Detail Usulan*', 'rules'=>'required'),
			array('field'=>'volume','label'=>'Volume*', 'rules'=>'required'),
			array('field'=>'satuan','label'=>'Satuan*', 'rules'=>'required'),
			array('field'=>'harga_satuan','label'=>'Harga satuan*', 'rules'=>'required'),
			array('field'=>'jumlah','label'=>'Jumlah', 'rules'=>'required'),
			array('field'=>'jenis_pembiayaan','label'=>'Jenis Pembiayaan*', 'rules'=>'required'),
			// array('field'=>'fokus_prioritas','label'=>'Fokus Prioritas*', 'rules'=>'required'),
			// array('field'=>'reformasi_kesehatan','label'=>'Reformasi Kesehatan*', 'rules'=>'required')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		return $this->form_validation->run();
	}
	
	function detail_aktivitas($KD_PENGAJUAN, $KodeAktivitas, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
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
		
		if($this->am->get_where('pengajuan','KD_PENGAJUAN',$KD_PENGAJUAN)->row()->ID_RENCANA_ANGGARAN == 2 && $option_jenis_usulan == NULL) $data['notif'] = 'Anda belum mengisi menu kegiatan';
		else $data['notif'] = '';
		$data_aktivitas = $this->am->get_where('aktivitas','KodeAktivitas',$KodeAktivitas);
		$data_aktivitas1 = $this->am->get_where_join_satuan('aktivitas','KD_PENGAJUAN',$KD_PENGAJUAN,'ref_satuan','aktivitas.KodeSatuan=ref_satuan.KodeSatuan');
		$data_aktivitas2 = $this->am->get_where_join_pembiayaan('aktivitas','KD_PENGAJUAN',$KD_PENGAJUAN,'ref_jenis_pembiayaan','aktivitas.KodeJenisPembiayaan=ref_jenis_pembiayaan.KodeJenisPembiayaan');
		$data['idRencanaAnggaran'] = $data_aktivitas->row()->idRencanaAnggaran;
		$data['jenis_pembiayaan'] = $option_jenis_pembiayaan;
		$data['satuan'] = $option_satuan;
		$data['KD_PENGAJUAN'] = $KD_PENGAJUAN;
		$data['KodeAktivitas'] = $KodeAktivitas;
		$data['jenis_usulan'] = $option_jenis_usulan;
		$data['s_jenis_pembiayaan'] = $data_aktivitas2->row()->JenisPembiayaan;
		$data['s_jenis_usulan'] = $data_aktivitas->row()->KodeJenisUsulan;
		$data['s_satuan'] = $data_aktivitas1->row()->satuan;
		$data['JudulUsulan'] = $data_aktivitas->row()->JudulUsulan;
		$data['Perincian'] = $data_aktivitas->row()->Perincian;
		$data['Volume'] = $data_aktivitas->row()->Volume;
		$data['HargaSatuan'] = $data_aktivitas->row()->HargaSatuan;
		$data['Jumlah'] = $data_aktivitas->row()->Jumlah;
		$data['KodeFungsi'] = $KodeFungsi;
		$data['KodeSubFungsi'] = $KodeSubFungsi;
		$data['KodeProgram'] = $KodeProgram;
		$data['KodeKegiatan'] = $KodeKegiatan;
		$data['fokus_prioritas'] = $this->am->get_where_join('data_fokus_prioritas','KD_PENGAJUAN',$KD_PENGAJUAN,'fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas')->result();
		$data['reformasi_kesehatan'] = $this->am->get_where_join('data_reformasi_kesehatan','KD_PENGAJUAN',$KD_PENGAJUAN,'reformasi_kesehatan','data_reformasi_kesehatan.idReformasiKesehatan=reformasi_kesehatan.idReformasiKesehatan')->result();
		$data['content'] = $this->load->view('e-planning/tambah_pengusulan/detail_aktivitas_pengusulan',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_aktivitas_($KD_PENGAJUAN, $KodeAktivitas, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$option_jenis_pembiayaan=NULL;
		$option_satuan=NULL;
		$option_jenis_usulan=NULL;
		$option_rincian_kegiatan=NULL;
		$option_rincian_kegiatan['0']='--- Pilih Rincian Kegiatan ---';
		foreach($this->am->get('ref_rincian_kegiatan')->result() as $row){
			$option_rincian_kegiatan[$row->idrincian] = $row->nmrincian;
		}
		foreach($this->am->get('ref_jenis_usulan')->result() as $row){
			$option_jenis_usulan[$row->KodeJenisUsulan] = $row->JenisUsulan;
		}
		
		foreach($this->am->get('ref_satuan')->result() as $row){
			$option_satuan[$row->KodeSatuan] = $row->Satuan;
		}
		
		foreach($this->am->get('ref_jenis_pembiayaan')->result() as $row){
			$option_jenis_pembiayaan[$row->KodeJenisPembiayaan] = $row->JenisPembiayaan;
		}
		
		if($this->am->get_where('pengajuan','KD_PENGAJUAN',$KD_PENGAJUAN)->row()->ID_RENCANA_ANGGARAN == 2 && $option_jenis_usulan == NULL) $data['notif'] = 'Anda belum mengisi menu kegiatan';
		else $data['notif'] = '';

		if($this->am->cek_aktivitas_update($KD_PENGAJUAN, $KodeAktivitas)->num_rows == 0)
		{
			$data_aktivitas = $this->am->get_where2('aktivitas','KD_PENGAJUAN',$KD_PENGAJUAN,'KodeAktivitas',$KodeAktivitas);
			//$idRencanaAnggaran = $data_aktivitas->row()->idRencanaAnggaran;
			$data_update = array(
				'KD_PENGAJUAN' => $KD_PENGAJUAN,
				'KodeAktivitas'=>$KodeAktivitas,
				'idRencanaAnggaran' => $data_aktivitas->row()->idRencanaAnggaran,
				'KodeJenisUsulan' => $data_aktivitas->row()->KodeJenisUsulan,
				'JudulUsulan' => $data_aktivitas->row()->JudulUsulan,
				'Perincian' => $data_aktivitas->row()->idrincian,
				'KodeSatuan' => $data_aktivitas->row()->KodeSatuan,
				'HargaSatuan' => $data_aktivitas->row()->HargaSatuan,
				'Jumlah' => $data_aktivitas->row()->Jumlah,
				'KodeJenisPembiayaan' => $data_aktivitas->row()->KodeJenisPembiayaan,
				'Perincian_1' => $data_aktivitas->row()->Perincian_1,
				'Perincian_2' => $data_aktivitas->row()->Perincian_2,
				'Perincian_3' => $data_aktivitas->row()->Perincian_3,
				'Perincian_4' => $data_aktivitas->row()->Perincian_4,
				'SatuanPerincian_1' => $data_aktivitas->row()->SatuanPerincian_1,
				'SatuanPerincian_2' => $data_aktivitas->row()->SatuanPerincian_2,
				'SatuanPerincian_3' => $data_aktivitas->row()->SatuanPerincian_3,
				'SatuanPerincian_4' => $data_aktivitas->row()->SatuanPerincian_4,
				'Volume' => $data_aktivitas->row()->Volume,
			);
			$this->am->save('aktivitas_update', $data_update);
			$data['idRencanaAnggaran'] = $data_aktivitas->row()->idRencanaAnggaran;
			$data['jenis_pembiayaan'] = $option_jenis_pembiayaan;
			$data['rincian_kegiatan'] = $option_rincian_kegiatan;
			$data['satuan'] = $option_satuan;
			$data['KD_PENGAJUAN'] = $KD_PENGAJUAN;
			$data['KodeAktivitas'] = $KodeAktivitas;
			$data['jenis_usulan'] = $option_jenis_usulan;
			$data['s_jenis_pembiayaan'] = $data_aktivitas->row()->KodeJenisPembiayaan;
			$data['s_jenis_usulan'] = $data_aktivitas->row()->KodeJenisUsulan;
			$data['s_satuan'] = $data_aktivitas->row()->KodeSatuan;
			$data['JudulUsulan'] = $data_aktivitas->row()->JudulUsulan;
			$data['Volume'] = $data_aktivitas->row()->Volume;
			$data['HargaSatuan'] = $data_aktivitas->row()->HargaSatuan;
			$data['Jumlah'] = $data_aktivitas->row()->Jumlah;
			$data['rinci1'] = $data_aktivitas->row()->Perincian_1;
			$data['rinci2'] = $data_aktivitas->row()->Perincian_2;
			$data['rinci3'] = $data_aktivitas->row()->Perincian_3;
			$data['rinci4'] = $data_aktivitas->row()->Perincian_4;
			$data['sat_rinci1'] = $data_aktivitas->row()->SatuanPerincian_1;
			$data['sat_rinci2'] = $data_aktivitas->row()->SatuanPerincian_2;
			$data['sat_rinci3'] = $data_aktivitas->row()->SatuanPerincian_3;
			$data['sat_rinci4'] = $data_aktivitas->row()->SatuanPerincian_4;
			$data['idrincian'] = $data_aktivitas->row()->idrincian;
			
			$data['KodeFungsi'] = $KodeFungsi;
			$data['KodeSubFungsi'] = $KodeSubFungsi;
			$data['KodeProgram'] = $KodeProgram;
			$data['KodeKegiatan'] = $KodeKegiatan;
			$data['fokus_prioritas'] = $this->am->get_where_join('data_fokus_prioritas','KD_PENGAJUAN',$KD_PENGAJUAN,'fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas')->result();
			$data['reformasi_kesehatan'] = $this->am->get_where_join('data_reformasi_kesehatan','KD_PENGAJUAN',$KD_PENGAJUAN,'reformasi_kesehatan','data_reformasi_kesehatan.idReformasiKesehatan=reformasi_kesehatan.idReformasiKesehatan')->result();
			$data['content'] = $this->load->view('e-planning/tambah_pengusulan/update_aktivitas_pengusulan',$data,true);
			$this->load->view('main',$data);
		}
		else {
			$data_aktivitas = $this->am->get_where('aktivitas_update','KodeAktivitas',$KodeAktivitas);
			$data['idRencanaAnggaran'] = $data_aktivitas->row()->idRencanaAnggaran;
			$data['jenis_pembiayaan'] = $option_jenis_pembiayaan;
			$data['rincian_kegiatan'] = $option_rincian_kegiatan;
			$data['satuan'] = $option_satuan;
			$data['KD_PENGAJUAN'] = $KD_PENGAJUAN;
			$data['KodeAktivitas'] = $KodeAktivitas;
			$data['jenis_usulan'] = $option_jenis_usulan;
			$data['s_jenis_pembiayaan'] = $data_aktivitas->row()->KodeJenisPembiayaan;
			$data['s_jenis_usulan'] = $data_aktivitas->row()->KodeJenisUsulan;
			$data['s_satuan'] = $data_aktivitas->row()->KodeSatuan;
			$data['JudulUsulan'] = $data_aktivitas->row()->JudulUsulan;
			$data['Volume'] = $data_aktivitas->row()->Volume;
			$data['HargaSatuan'] = $data_aktivitas->row()->HargaSatuan;
			$data['Jumlah'] = $data_aktivitas->row()->Jumlah;
			$data['rinci1'] = $data_aktivitas->row()->Perincian_1;
			$data['rinci2'] = $data_aktivitas->row()->Perincian_2;
			$data['rinci3'] = $data_aktivitas->row()->Perincian_3;
			$data['rinci4'] = $data_aktivitas->row()->Perincian_4;
			$data['sat_rinci1'] = $data_aktivitas->row()->SatuanPerincian_1;
			$data['sat_rinci2'] = $data_aktivitas->row()->SatuanPerincian_2;
			$data['sat_rinci3'] = $data_aktivitas->row()->SatuanPerincian_3;
			$data['sat_rinci4'] = $data_aktivitas->row()->SatuanPerincian_4;
			$data['idrincian'] = $data_aktivitas->row()->idrincian;
			
			$data['KodeFungsi'] = $KodeFungsi;
			$data['KodeSubFungsi'] = $KodeSubFungsi;
			$data['KodeProgram'] = $KodeProgram;
			$data['KodeKegiatan'] = $KodeKegiatan;
			$data['fokus_prioritas'] = $this->am->get_where_join('data_fokus_prioritas','KD_PENGAJUAN',$KD_PENGAJUAN,'fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas')->result();
			$data['reformasi_kesehatan'] = $this->am->get_where_join('data_reformasi_kesehatan','KD_PENGAJUAN',$KD_PENGAJUAN,'reformasi_kesehatan','data_reformasi_kesehatan.idReformasiKesehatan=reformasi_kesehatan.idReformasiKesehatan')->result();
			$data['content'] = $this->load->view('e-planning/tambah_pengusulan/update_aktivitas_pengusulan',$data,true);
			$this->load->view('main',$data);
		}
		
	}

	function update_aktivitas($KD_PENGAJUAN, $KodeAktivitas, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$option_jenis_pembiayaan=NULL;
		$option_satuan=NULL;
		$option_jenis_usulan=NULL;
		$option_rincian_kegiatan=NULL;
		$option_rincian_kegiatan['0']='--- Pilih Rincian Kegiatan ---';
		foreach($this->am->get('ref_rincian_kegiatan')->result() as $row){
			$option_rincian_kegiatan[$row->idrincian] = $row->nmrincian;
		}
		foreach($this->am->get('ref_jenis_usulan')->result() as $row){
			$option_jenis_usulan[$row->KodeJenisUsulan] = $row->JenisUsulan;
		}
		
		foreach($this->am->get('ref_satuan')->result() as $row){
			$option_satuan[$row->KodeSatuan] = $row->Satuan;
		}
		
		foreach($this->am->get('ref_jenis_pembiayaan')->result() as $row){
			$option_jenis_pembiayaan[$row->KodeJenisPembiayaan] = $row->JenisPembiayaan;
		}
		
		if($this->am->get_where('pengajuan','KD_PENGAJUAN',$KD_PENGAJUAN)->row()->ID_RENCANA_ANGGARAN == 2 && $option_jenis_usulan == NULL) $data['notif'] = 'Anda belum mengisi menu kegiatan';
		else $data['notif'] = '';
		$data_aktivitas = $this->am->get_where('aktivitas','KodeAktivitas',$KodeAktivitas);
		$data['idRencanaAnggaran'] = $data_aktivitas->row()->idRencanaAnggaran;
		$data['jenis_pembiayaan'] = $option_jenis_pembiayaan;
		$data['rincian_kegiatan'] = $option_rincian_kegiatan;
		$data['satuan'] = $option_satuan;
		$data['KD_PENGAJUAN'] = $KD_PENGAJUAN;
		$data['KodeAktivitas'] = $KodeAktivitas;
		$data['jenis_usulan'] = $option_jenis_usulan;
		$data['s_jenis_pembiayaan'] = $data_aktivitas->row()->KodeJenisPembiayaan;
		$data['s_jenis_usulan'] = $data_aktivitas->row()->KodeJenisUsulan;
		$data['s_satuan'] = $data_aktivitas->row()->KodeSatuan;
		$data['JudulUsulan'] = $data_aktivitas->row()->JudulUsulan;
		$data['Volume'] = $data_aktivitas->row()->Volume;
		$data['HargaSatuan'] = $data_aktivitas->row()->HargaSatuan;
		$data['Jumlah'] = $data_aktivitas->row()->Jumlah;
		$data['rinci1'] = $data_aktivitas->row()->Perincian_1;
		$data['rinci2'] = $data_aktivitas->row()->Perincian_2;
		$data['rinci3'] = $data_aktivitas->row()->Perincian_3;
		$data['rinci4'] = $data_aktivitas->row()->Perincian_4;
		$data['sat_rinci1'] = $data_aktivitas->row()->SatuanPerincian_1;
		$data['sat_rinci2'] = $data_aktivitas->row()->SatuanPerincian_2;
		$data['sat_rinci3'] = $data_aktivitas->row()->SatuanPerincian_3;
		$data['sat_rinci4'] = $data_aktivitas->row()->SatuanPerincian_4;
		$data['idrincian'] = $data_aktivitas->row()->idrincian;
		
		$data['KodeFungsi'] = $KodeFungsi;
		$data['KodeSubFungsi'] = $KodeSubFungsi;
		$data['KodeProgram'] = $KodeProgram;
		$data['KodeKegiatan'] = $KodeKegiatan;
		$data['fokus_prioritas'] = $this->am->get_where_join('data_fokus_prioritas','KD_PENGAJUAN',$KD_PENGAJUAN,'fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas')->result();
		$data['reformasi_kesehatan'] = $this->am->get_where_join('data_reformasi_kesehatan','KD_PENGAJUAN',$KD_PENGAJUAN,'reformasi_kesehatan','data_reformasi_kesehatan.idReformasiKesehatan=reformasi_kesehatan.idReformasiKesehatan')->result();
		$data['content'] = $this->load->view('e-planning/tambah_pengusulan/update_aktivitas_pengusulan',$data,true);
		$this->load->view('main',$data);
	}
	
	function proses_update_aktivitas($KD_PENGAJUAN,$KodeAktivitas){
		$KodeFungsi = $this->input->post('KodeFungsi');
		$KodeSubFungsi = $this->input->post('KodeSubFungsi');
		$KodePengajuan = $this->input->post('KodePengajuan');
		$KodeProgram = $this->input->post('KodeProgram');
		$KodeKegiatan = $this->input->post('KodeKegiatan');
		foreach($this->am->get_where('ref_satuan','KodeSatuan',$this->input->post('satuan'))->result() as $row){
			$satuan = $row->Satuan;
		}
		if($this->input->post('rinci_1') != null) $rinci1= $this->input->post('rinci_1').' '.$this->input->post('rinci_2');
		else $rinci1='';
		if($this->input->post('rinci_3') != null) 
			if($this->input->post('rinci_1') != null) $rinci2= ' x '.$this->input->post('rinci_3').' '.$this->input->post('rinci_4');
			else $rinci2= $this->input->post('rinci_3').' '.$this->input->post('rinci_4');
		else $rinci2='';
		if($this->input->post('rinci_5') != null) 
			if($this->input->post('rinci_1') != null || $this->input->post('rinci_3') != null) $rinci3= ' x '.$this->input->post('rinci_5').' '.$this->input->post('rinci_6');
			else $rinci3= $this->input->post('rinci_5').' '.$this->input->post('rinci_6');
		else $rinci3='';
		if($this->input->post('rinci_7') != null) 
			if($this->input->post('rinci_1') != null || $this->input->post('rinci_3') != null || $this->input->post('rinci_5') != null) $rinci4= ' x '.$this->input->post('rinci_7').' '.$this->input->post('rinci_8');
			else $rinci4= $this->input->post('rinci_7').' '.$this->input->post('rinci_8');
		else $rinci4='';
		
		$perincian = $rinci1.$rinci2.$rinci3.$rinci4;
		
		
		$usulan='';
		if($this->input->post('rincian') == '1'){
			$idrincian=$this->input->post('rincian_kegiatan');
			$usulan = $this->am->get_rincian_by_id($idrincian)->row()->nmrincian;
			$idkeg = $this->am->get_rincian_by_id($idrincian)->row()->idkeg;
			$data_rincian = array('idrincian' => $idrincian, 'idkeg' => $idkeg);
			
		}
		else {
			$usulan = $this->input->post('judul_usulan');
		}
		$data = array(
			'KodeJenisUsulan' => $this->input->post('jenis_usulan'),
			'JudulUsulan' => $usulan,
			'Perincian' => $perincian,
			'KodeSatuan' => $this->input->post('satuan'),
			'HargaSatuan' => $this->input->post('harga_satuan'),
			'Jumlah' => $this->input->post('jumlah'),
			'KodeJenisPembiayaan' => $this->input->post('jenis_pembiayaan'),
			'Perincian_1' => $this->input->post('rinci_1'),
			'Perincian_2' => $this->input->post('rinci_3'),
			'Perincian_3' => $this->input->post('rinci_5'),
			'Perincian_4' => $this->input->post('rinci_7'),
			'SatuanPerincian_1' => $this->input->post('rinci_2'),
			'SatuanPerincian_2' => $this->input->post('rinci_4'),
			'SatuanPerincian_3' => $this->input->post('rinci_6'),
			'SatuanPerincian_4' => $this->input->post('rinci_8'),
			'Volume' => $this->input->post('volume'),
		);

		$data_up = array(
			'Jumlah' => 0,
			//'JumlahUpdate' => 0,
		);
			
		if($this->input->post('rincian') == '1'){
			$data = $data + $data_rincian;
			
		}
			if($this->session->userdata('kd_role') == Role_model::DIREKTORAT) {
				$this->am->update('aktivitas', $data_up, 'KodeAktivitas', $KodeAktivitas);
				$this->am->update('aktivitas_update', $data, 'KodeAktivitas', $KodeAktivitas);
				$this->am->delete('fp_aktivitas', 'KodeAktivitas', $KodeAktivitas);
				$fokus_prioritas = $this->input->post('fokus_prioritas');
				if($fokus_prioritas[0]!=NULL){
					for($i=0;$i<count($fokus_prioritas);$i++){
						$this->am->save('fp_aktivitas', array('KodeAktivitas'=>$KodeAktivitas,'idFokusPrioritas'=>$fokus_prioritas[$i]));
				$datafp= array('Biaya' => $this->pm->get_biaya_fp($KD_PENGAJUAN,$fokus_prioritas[$i]));
				$this->pm->update2('data_fokus_prioritas', $datafp, 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idFokusPrioritas', $fokus_prioritas[$i]);
					}
				}
				$this->am->delete('rk_aktivitas', 'KodeAktivitas', $KodeAktivitas);
				$reformasi_kesehatan = $this->input->post('reformasi_kesehatan');
				if($reformasi_kesehatan[0]!=NULL){
					for($i=0;$i<count($reformasi_kesehatan);$i++){
						$this->am->save('rk_aktivitas', array('KodeAktivitas'=>$KodeAktivitas,'idReformasiKesehatan'=>$reformasi_kesehatan[$i]));
				$datark= array('Biaya' => $this->pm->get_biaya_rk($KD_PENGAJUAN,$reformasi_kesehatan[$i]));
				$this->pm->update2('data_reformasi_kesehatan', $datark, 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idReformasiKesehatan', $reformasi_kesehatan[$i]);
					}
				}
				redirect('e-planning/aktivitas/grid_aktivitas/'.$KD_PENGAJUAN.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan);
			} else 
			{
				$this->am->update('aktivitas', $data, 'KodeAktivitas', $KodeAktivitas);
				$this->am->delete('fp_aktivitas', 'KodeAktivitas', $KodeAktivitas);
				$fokus_prioritas = $this->input->post('fokus_prioritas');
				if($fokus_prioritas[0]!=NULL){
					for($i=0;$i<count($fokus_prioritas);$i++){
						$this->am->save('fp_aktivitas', array('KodeAktivitas'=>$KodeAktivitas,'idFokusPrioritas'=>$fokus_prioritas[$i]));
				$datafp= array('Biaya' => $this->pm->get_biaya_fp($KD_PENGAJUAN,$fokus_prioritas[$i]));
				$this->pm->update2('data_fokus_prioritas', $datafp, 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idFokusPrioritas', $fokus_prioritas[$i]);
					}
				}
				$this->am->delete('rk_aktivitas', 'KodeAktivitas', $KodeAktivitas);
				$reformasi_kesehatan = $this->input->post('reformasi_kesehatan');
				if($reformasi_kesehatan[0]!=NULL){
					for($i=0;$i<count($reformasi_kesehatan);$i++){
						$this->am->save('rk_aktivitas', array('KodeAktivitas'=>$KodeAktivitas,'idReformasiKesehatan'=>$reformasi_kesehatan[$i]));
				$datark= array('Biaya' => $this->pm->get_biaya_rk($KD_PENGAJUAN,$reformasi_kesehatan[$i]));
				$this->pm->update2('data_reformasi_kesehatan', $datark, 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idReformasiKesehatan', $reformasi_kesehatan[$i]);
					}
				}
				redirect('e-planning/aktivitas/grid_aktivitas/'.$KD_PENGAJUAN.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan);
			}
	}
	
	function delete($KD_PENGAJUAN,$KodeAktivitas, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$this->am->delete('aktivitas', 'KodeAktivitas', $KodeAktivitas);
		$fp= $this->am->get_where('fp_aktivitas', 'KodeAktivitas',$KodeAktivitas)->row()->idFokusPrioritas;
		$rk= $this->am->get_where('rk_aktivitas', 'KodeAktivitas',$KodeAktivitas)->row()->idReformasiKesehatan;
		$this->am->delete('fp_aktivitas', 'KodeAktivitas', $KodeAktivitas);
		$this->am->delete('rk_aktivitas', 'KodeAktivitas', $KodeAktivitas);
		
		$datafp= array('Biaya' => $this->pm->get_biaya_fp($KD_PENGAJUAN,$fp));
		$this->pm->update2('data_fokus_prioritas', $datafp, 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idFokusPrioritas', $fp);
		$datark= array('Biaya' => $this->pm->get_biaya_rk($KD_PENGAJUAN,$rk));
		$this->pm->update2('data_reformasi_kesehatan', $datark, 'KD_PENGAJUAN', $KD_PENGAJUAN, 'idReformasiKesehatan', $rk);
		redirect('e-planning/aktivitas/grid_aktivitas/'.$KD_PENGAJUAN.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan);
	}
	
	function get_fp($kd_pengajuan, $jns_usulan)
	{
		$query = $this->am->get_where('data_fokus_prioritas', 'KD_PENGAJUAN', $kd_pengajuan);
		$i=0;
		foreach($query->result() as $row)
		{	
			$datajson[$i]['idFokusPrioritas'] = $row->idFokusPrioritas;
			$datajson[$i]['FokusPrioritas'] = $this->am->get_where('fokus_prioritas','idFokusPrioritas',$row->idFokusPrioritas)->row()->FokusPrioritas;
			if($jns_usulan == '1' || $jns_usulan == '2')
				$datajson[$i]['Attributes'] = 'type="checkbox" checked="checked" disabled="disabled"';
			else
				$datajson[$i]['Attributes'] = 'type="radio"';
			$i++;
		}
		
		echo json_encode($datajson);
	}
	function get_rk($kd_pengajuan, $jns_usulan)
	{
		$query = $this->am->get_where('data_reformasi_kesehatan', 'KD_PENGAJUAN', $kd_pengajuan);
		$i=0;
		foreach($query->result() as $row)
		{	
			$datajson[$i]['idReformasiKesehatan'] = $row->idReformasiKesehatan;
			$datajson[$i]['ReformasiKesehatan'] = $this->am->get_where('reformasi_kesehatan','idReformasiKesehatan',$row->idReformasiKesehatan)->row()->ReformasiKesehatan;
			if($jns_usulan == '1' || $jns_usulan == '2')
				$datajson[$i]['Attributes'] = 'type="checkbox" checked="checked" disabled="disabled"';
			else
				$datajson[$i]['Attributes'] = 'type="radio"';
			$i++;
		}
		
		echo json_encode($datajson);
	}
	
	function get_jns_usulan($idrincian)
	{
		$query = $this->am->get_where('ref_rincian_kegiatan', 'idrincian', $idrincian);
		if($query->num_rows <1){
			$datajson['KodeJenisUsulan'] = '0';
		}
		else{
			foreach($query->result() as $row){	
				$datajson['KodeJenisUsulan'] = $row->KodeJenisUsulan;
				$datajson['JenisUsulan'] = $this->am->get_where('ref_jenis_usulan','KodeJenisUsulan',$row->KodeJenisUsulan)->row()->JenisUsulan;
			}
		}
		echo json_encode($datajson);
	}
}

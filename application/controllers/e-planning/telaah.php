<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Telaah extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('e-planning/Manajemen_model','mm');
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
	function status_telaah($kd_pengajuan){
		foreach($this->mm->get_where('pengajuan','KD_PENGAJUAN', $kd_pengajuan)->result() as $row)
			$judul_proposal = $row->JUDUL_PROPOSAL;
		foreach($this->mm->get_where('data_telaah_staff','KD_PENGAJUAN', $kd_pengajuan)->result() as $row){
			$kode_telaah_staff = $row->KODE_TELAAH_STAFF;
			$status_telaah = $row->STATUS;
		}
		$data['judul'] = $judul_proposal;
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data['kd_telaah'] = $kode_telaah_staff;
		$data['status'] = $status_telaah;
		$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/detail_status_telaah',$data, true);
		$this->load->view('main',$data2);
		
	}
	function grid_telaah_staff($kd_pengajuan){
		//$this->cek_session();
		// $colModel['NO'] = array('No',20,TRUE,'center',0);
		$colModel['NAMA'] = array('Nama',300,TRUE,'left',1);
		$colModel['JABATAN'] = array('Jabatan',150,TRUE,'left',0);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		$colModel['KOREKSI'] = array('Koreksi',50,TRUE,'center',0);
		$colModel['STATUS_TELAAH'] = array('Status Telaah',200,TRUE,'center',1);
		$colModel['POSISI'] = array('Posisi Telaah Proposal',150,TRUE,'center',1);
		$colModel['AKTIVITAS'] = array('Aktivitas',70,TRUE,'center',0);
			
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
		
		//menambah tombol pada flexigrid top toolbar
		// $buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/telaah/grid_list_telaah_staff/".$kd_pengajuan;
		// $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		if($this->session->userdata('kd_role') == Role_model::DIREKTORAT || $this->session->userdata('kd_role') == Role_model::VERIFIKATOR) {
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali ke Daftar Proposal
					</button>
					</form>
				</div>";
		}
		else {
			$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_persetujuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kembali ke Daftar Persetujuan
					</button>
					</form>
				</div>";
		}
		
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
		$data['judul'] = 'TELAAH STAFF';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function grid_list_telaah_staff($kd_pengajuan){
		$valid_fields = array('TANGGAL','DARI','KEPADA','PERSOALAN','SIMPULAN');
		$this->flexigrid->validate_post('TANGGAL','asc',$valid_fields);
		$records = $this->mm->get_telaah_staff($kd_pengajuan);
		

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$nama='';
			$jabatan='';
			foreach($this->mm->get_where('users','USER_ID', $this->session->userdata('id_user'))->result() as $peg){
				$nama = $peg->NAMA_USER;
				$jabatan = $peg->NAMA_JABATAN;
			}
			if($row->STATUS == '1') {$status = 'Telah ditelaah staf';  $posisi = 'Kasubag';}
			elseif($row->STATUS == '2') {$status = 'Perlu koreksi staf'; $posisi = 'Staf';}
			elseif($row->STATUS == '3') {$status = 'Telah ditelaah Kasubag'; $posisi = 'Kabag';}
			elseif($row->STATUS == '4') {$status = 'Perlu koreksi Kasubag'; $posisi = 'Kasubag';}
			elseif($row->STATUS == '5') {$status = 'Telah ditelaah Kabag'; $posisi = 'Kabiro';}
			elseif($row->STATUS == '6') {$status = 'Perlu koreksi Kabag'; $posisi = 'Kabag';}
			elseif($row->STATUS == '7') {$status = 'Telah ditelaah Kabiro'; $posisi = 'Proses Penelaahan Selesai';}
			elseif($row->STATUS == '8') {$status = 'Telah ditelaah Administrator'; $posisi = 'Proses Penelaahan Selesai';}
			elseif($row->STATUS == '9') {$status = 'Telah ditelaah Direktorat'; $posisi = 'Proses Penelaahan Selesai';}
			elseif($row->STATUS == '10') {$status = 'Telah ditelaah Verifikator'; $posisi = 'Proses Penelaahan Selesai';}
			else {$status = 'Draft'; $posisi = 'Staf';}
			
			$kirimsetuju = '';
			$mintakoreksi = '';
			$koreksi = '<a href="#"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit_mono.png\'></a>';
			if($this->session->userdata('kd_role') == Role_model::ADMIN){
					$kirimsetuju = '<a href="'.site_url().'/e-planning/telaah/setuju_admin/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin menyetujui ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>';
					$mintakoreksi = '';
					$koreksi = '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
				if($row->STATUS == '7' || $row->STATUS == '8') {
					$kirimsetuju = '-';
					$koreksi = '<a href="#"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit_mono.png\'></a>';;
				}
			}
			elseif($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
					$kirimsetuju = '<a href="'.site_url().'/e-planning/telaah/setuju_direktorat/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin menyetujui ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>';
					$mintakoreksi = '';
					$koreksi = '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
				if($row->STATUS == '9') {
					$kirimsetuju = '-';
					$koreksi = '<a href="#"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit_mono.png\'></a>';;
				}
			}
			elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR){
					$kirimsetuju = '<a href="'.site_url().'/e-planning/telaah/setuju_verifikator/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin menyetujui ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>';
					$mintakoreksi = '';
					$koreksi = '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
				if($row->STATUS == '10') {
					$kirimsetuju = '-';
					$koreksi = '<a href="#"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit_mono.png\'></a>';;
				}
			}
			elseif($this->session->userdata('eselon') == '0'){
				if($row->STATUS == '0' || $row->STATUS == '2'){
					$kirimsetuju = '<a href="'.site_url().'/e-planning/telaah/kirim/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yasdkin ingin mengirim telaah ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					$koreksi = '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
				}
			}
			elseif($this->session->userdata('eselon') == '4'){
				if($row->STATUS == '1' || $row->STATUS == '4'){
					$kirimsetuju = '<a href="'.site_url().'/e-planning/telaah/kirim/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin mengirim telaah ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					$mintakoreksi = '<a href="'.site_url().'/e-planning/telaah/minta_koreksi/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin meminta koreksi ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/load.png\'></a>';
					if($row->STATUS == '4') $koreksi = '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
				}
			}
			elseif($this->session->userdata('eselon') == '3'){
				if($row->STATUS == '3' || $row->STATUS == '6'){
					$kirimsetuju = '<a href="'.site_url().'/e-planning/telaah/kirim/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin mengirim telaah ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					$mintakoreksi = '<a href="'.site_url().'/e-planning/telaah/minta_koreksi/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin meminta koreksi ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/load.png\'></a>';
					if($row->STATUS == '6') $koreksi = '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
				}
			}
			elseif($this->session->userdata('eselon') == '2'){
				if($row->STATUS == '5'){
					$kirimsetuju = '<a href="'.site_url().'/e-planning/telaah/setuju/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin menyetujui ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>';
					$mintakoreksi = '<a href="'.site_url().'/e-planning/telaah/minta_koreksi/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'" onclick="return confirm(\'Anda yakin ingin meminta koreksi ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/load.png\'></a>';
					$koreksi = '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
				}
			}
			
			//$cetak = '<a href="'.site_url().'/e-planning/telaah/cetak_telaah_staff/'.$row->KODE_TELAAH_STAFF.'/'.$kd_pengajuan.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/print.png\'></a>';
			$no = $no+1;
			$record_items[] = array(
				$no,
				// $no,
				$nama,
				$jabatan,
				'<a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$kd_pengajuan.'/'.$row->KODE_TELAAH_STAFF.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				$koreksi,
				$status,
				$posisi,
				$mintakoreksi.' '.$kirimsetuju,
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
		
	function telaah_staff($kd_pengajuan){
		if($this->validasi_telaah() == FALSE){
			$data['warning'] = 'Tanggal, persoalan, pra-anggapan, fakta yang memperngaruhi, penggunaan sumber daya yang efektif, feasibilitas, equity, gap daerah, analisis, dan simpulan harus diisi.';
			$data['TANGGAL'] = $this->input->post('tanggal');
			$data['PERSOALAN'] = $this->input->post('persoalan');
			$data['PRAANGGAPAN'] = $this->input->post('praanggapan');
			$data['FAKTA_YANG_MEMPENGARUHI'] = $this->input->post('fakta_yang_mempengaruhi');
			$data['COST_EFEKTIF'] = $this->input->post('cost_efektif');
			$data['EFISIEN'] = $this->input->post('efisien');
			$data['FEASIBILITAS'] = $this->input->post('feasibilitas');
			$data['EQUITY'] = $this->input->post('equity');
			$data['GAP_DAERAH'] = $this->input->post('gap_daerah');
			$data['ANALISIS'] = $this->input->post('analisis');
			$data['SIMPULAN'] = $this->input->post('simpulan');
		}
		else{
			// redirect('e-planning/proses_telaah_staff/'.$kd_pengajuan);
			$this->proses_telaah_staff($kd_pengajuan);
		}
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/telaah_staff',$data, true);
		$this->load->view('main',$data2);
	}
	
	function proses_telaah_staff($kd_pengajuan){
		// if($this->validasi_telaah() == False){
			// $this->telaah_staff($kd_pengajuan);
		// }else{
			$tanggal = explode('-',$this->input->post('tanggal'));
			$data=array(
				'KD_PENGAJUAN' => $kd_pengajuan,
				'TANGGAL' => $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0],
				'PERSOALAN' =>$this->input->post('persoalan'),
				'PRAANGGAPAN' => $this->input->post('praanggapan'),
				'FAKTA_YANG_MEMPENGARUHI' => $this->input->post('fakta_yang_mempengaruhi'),
				'COST_EFEKTIF' => $this->input->post('cost_efektif'),
				'EFISIEN' => $this->input->post('efisien'),
				'FEASIBILITAS' => $this->input->post('feasibilitas'),
				'EQUITY' => $this->input->post('equity'),
				'GAP_DAERAH' => $this->input->post('gap_daerah'),
				'ANALISIS' => $this->input->post('analisis'),
				'SIMPULAN' => $this->input->post('simpulan')
			);
			$this->mm->save('data_telaah_staff', $data);
			
			foreach($this->mm->get_where('data_telaah_staff', 'KD_PENGAJUAN', $kd_pengajuan)->result() as $row)
				$kd_telaah = $row->KODE_TELAAH_STAFF;
			foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
			$data_akses= array(
				'KODE_TELAAH_STAFF' => $kd_telaah,
				'KD_PENGAJUAN' => $kd_pengajuan,
				'ID_USER' => $this->session->userdata('id_user'),
				'JABATAN' => $kode_jabatan,
				'AKTIVITAS' => 'Membuat telaah'
			);
			$this->mm->save('pengakses_telaah', $data_akses);
			//redirect('e-planning/manajemen/grid_telaah_staff/'.$kd_pengajuan);
			// redirect('e-planning/manajemen/cetak_telaah_staff/'.$KODE_TELAAH_STAFF);
			redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
		// }
	}
	
	function validasi_telaah(){
		$config = array(
			array('field'=>'tanggal','label'=>'Tanggal', 'rules'=>'required'),
			array('field'=>'persoalan','label'=>'Persoalan', 'rules'=>'required'),
			array('field'=>'praanggapan','label'=>'Praanggapan', 'rules'=>'required'),
			array('field'=>'fakta_yang_mempengaruhi','label'=>'Fakta yang mempengaruhi', 'rules'=>'required'),
			array('field'=>'cost_efektif','label'=>'Penggunaan sumber daya yang cost efektif', 'rules'=>'required'),
			array('field'=>'efisien','label'=>'Efisien', 'rules'=>'required'),
			array('field'=>'feasibilitas','label'=>'Feasibilitas (secara teknis, politis dan kendala sosial)', 'rules'=>'required'),
			array('field'=>'equity','label'=>'Equity (keadilan)', 'rules'=>'required'),
			array('field'=>'gap_daerah','label'=>'Menutup gap yang ada di daerah', 'rules'=>'required'),
			array('field'=>'analisis','label'=>'Analisis', 'rules'=>'required'),
			array('field'=>'simpulan','label'=>'Simpulan', 'rules'=>'required'),
		);
			//setting rules
		$this->form_validation->set_rules($config);
		
		// $this->form_validation->set_message('required', '%s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function kirim($KODE_TELAAH_STAFF){
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row){
			$kode_jabatan = $row->KODE_JABATAN;
			$eselon = $row->ESELON;
			}
		$kd_unit= $this->session->userdata('kdunit');
		$kd_jab = explode('.',$kode_jabatan);
		if($eselon=='0'){
			$data['pengirim'] = $this->mm->get_where2('data_pegawai','ESELON', '0', 'KDUNIT', $kd_unit);
			$data['penerima'] = $this->mm->get_where2('data_pegawai','ESELON', '4', 'KDUNIT', $kd_unit);
			$data['kirimke'] = 'kirim_ke_kasubag';
		}
		elseif($eselon=='4'){
			$data['pengirim'] = $this->mm->get_where2('data_pegawai','ESELON', '4', 'KDUNIT', $kd_unit);
			$data['penerima'] = $this->mm->get_where2('data_pegawai','ESELON', '3', 'KDUNIT', $kd_unit);
			$data['kirimke'] = 'kirim_ke_kabag';
		}
		elseif($eselon=='3'){
			$data['pengirim'] = $this->mm->get_where2('data_pegawai','ESELON', '3', 'KDUNIT', $kd_unit);
			$data['penerima'] = $this->mm->get_where2('data_pegawai','ESELON', '2', 'KDUNIT', $kd_unit);
			$data['kirimke'] = 'kirim_ke_kabiro';
		}
		$status='';
		foreach($this->mm->get_where('data_telaah_staff','KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF)->result() as $row)
			$status = $row->STATUS;
		$data['kd_telaah'] = $KODE_TELAAH_STAFF;
		$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/kirim_telaah_staff',$data, true);
		$this->load->view('main',$data2);
		
	}
	function kirim_ke_kasubag($KODE_TELAAH_STAFF){
		$kode_dari = $this->input->post('dari');
		for($i=0; $i<count($kode_dari); $i++){
			$dari = $kode_dari[$i];
		}
		foreach($this->mm->get_where('data_pegawai', 'id_peg', $dari)->result() as $row)
			$jabatan_dari = $row->KODE_JABATAN;
			
		$kode_kepada = $this->input->post('kepada');
		for($i=0; $i<count($kode_kepada); $i++){
			$kepada = $kode_kepada[$i];
		}
		foreach($this->mm->get_where('data_pegawai', 'id_peg', $kepada)->result() as $row)
			$jabatan_kepada = $row->KODE_JABATAN;
			
		foreach($this->mm->get_where('data_telaah_staff', 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF)->result() as $row){
			$kd_pengajuan = $row->KD_PENGAJUAN;
			$status_awal = $row->STATUS;
		}
		
		$data = array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'STATUS_AWAL' => $status_awal,
			'DARI' => $dari,
			'JABATAN_DARI' => $jabatan_dari,
			'KEPADA' => $kepada,
			'JABATAN_KEPADA' => $jabatan_kepada,
		);
		$this->mm->delete2('detail_telaah', 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF, 'STATUS_AWAL', '0');
		$this->mm->save('detail_telaah', $data);
		
		$data_telaah=array('STATUS' => '1');
		$this->mm->update('data_telaah_staff',$data_telaah,'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Mengirim telaah ke Kasubag'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}
	function kirim_ke_kabag($KODE_TELAAH_STAFF){
		$kode_dari = $this->input->post('dari');
		for($i=0; $i<count($kode_dari); $i++){
			$dari = $kode_dari[$i];
		}
		foreach($this->mm->get_where('data_pegawai', 'id_peg', $dari)->result() as $row)
			$jabatan_dari = $row->KODE_JABATAN;
			
		$kode_kepada = $this->input->post('kepada');
		for($i=0; $i<count($kode_kepada); $i++){
			$kepada = $kode_kepada[$i];
		}
		foreach($this->mm->get_where('data_pegawai', 'id_peg', $kepada)->result() as $row)
			$jabatan_kepada = $row->KODE_JABATAN;
			
		foreach($this->mm->get_where('data_telaah_staff', 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF)->result() as $row){
			$kd_pengajuan = $row->KD_PENGAJUAN;
			$status_awal = $row->STATUS;
		}
		
		$data = array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'STATUS_AWAL' => $status_awal,
			'DARI' => $dari,
			'JABATAN_DARI' => $jabatan_dari,
			'KEPADA' => $kepada,
			'JABATAN_KEPADA' => $jabatan_kepada,
		);
		$this->mm->delete2('detail_telaah', 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF, 'STATUS_AWAL', '1');
		$this->mm->save('detail_telaah', $data);
		
		$data_telaah=array('STATUS' => '3');
		$this->mm->update('data_telaah_staff',$data_telaah,'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Mengirim telaah ke Kabag'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}
	
	function kirim_ke_kabiro($KODE_TELAAH_STAFF){
		$kode_dari = $this->input->post('dari');
		for($i=0; $i<count($kode_dari); $i++){
			$dari = $kode_dari[$i];
		}
		foreach($this->mm->get_where('data_pegawai', 'id_peg', $dari)->result() as $row)
			$jabatan_dari = $row->KODE_JABATAN;
			
		$kode_kepada = $this->input->post('kepada');
		for($i=0; $i<count($kode_kepada); $i++){
			$kepada = $kode_kepada[$i];
		}
		foreach($this->mm->get_where('data_pegawai', 'id_peg', $kepada)->result() as $row)
			$jabatan_kepada = $row->KODE_JABATAN;
			
		foreach($this->mm->get_where('data_telaah_staff', 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF)->result() as $row){
			$kd_pengajuan = $row->KD_PENGAJUAN;
			$status_awal = $row->STATUS;
		}
		
		$data = array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'STATUS_AWAL' => $status_awal,
			'DARI' => $dari,
			'JABATAN_DARI' => $jabatan_dari,
			'KEPADA' => $kepada,
			'JABATAN_KEPADA' => $jabatan_kepada,
		);
		$this->mm->delete2('detail_telaah', 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF, 'STATUS_AWAL', '3');
		$this->mm->save('detail_telaah', $data);
		
		$data_telaah=array('STATUS' => '5');
		$this->mm->update('data_telaah_staff',$data_telaah,'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Mengirim telaah ke Kabiro'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}
	function setuju($kd_pengajuan,$KODE_TELAAH_STAFF){
		$data_status = array('STATUS'=> '7');
		$this->mm->update('data_telaah_staff', $data_status, 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Menyetujui telaah'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}
	function setuju_admin($kd_pengajuan,$KODE_TELAAH_STAFF){
		$data_status = array('STATUS'=> '8');
		$this->mm->update('data_telaah_staff', $data_status, 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Menyetujui telaah'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}

	function setuju_direktorat($kd_pengajuan,$KODE_TELAAH_STAFF){
		$data_status = array('STATUS'=> '9');
		$this->mm->update('data_telaah_staff', $data_status, 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Menyetujui telaah'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}

	function setuju_verifikator($kd_pengajuan,$KODE_TELAAH_STAFF){
		$data_status = array('STATUS'=> '10');
		$this->mm->update('data_telaah_staff', $data_status, 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Menyetujui telaah'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}

	function minta_koreksi($kd_pengajuan, $KODE_TELAAH_STAFF){
		
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data['kd_telaah'] = $KODE_TELAAH_STAFF;
		$data['TANGGAL'] = '';
		$data['PERSOALAN'] = '';
		$data['PRAANGGAPAN'] = '';
		$data['FAKTA_YANG_MEMPENGARUHI'] = '';
		$data['COST_EFEKTIF'] = '';
		$data['EFISIEN'] = '';
		$data['FEASIBILITAS'] = '';
		$data['EQUITY'] = '';
		$data['GAP_DAERAH'] = '';
		$data['ANALISIS'] = '';
		$data['SIMPULAN'] = '';
		foreach($this->mm->get_where('data_telaah_staff','KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF)->result() as $row){
			$tanggal= explode('-',$row->TANGGAL);
			$data['TANGGAL'] = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			$data['PERSOALAN'] = $row->PERSOALAN;
			$data['PRAANGGAPAN'] = $row->PRAANGGAPAN;
			$data['FAKTA_YANG_MEMPENGARUHI'] = $row->FAKTA_YANG_MEMPENGARUHI;
			$data['COST_EFEKTIF'] = $row->COST_EFEKTIF;
			$data['EFISIEN'] = $row->EFISIEN;
			$data['FEASIBILITAS'] = $row->FEASIBILITAS;
			$data['EQUITY'] = $row->EQUITY;
			$data['GAP_DAERAH'] = $row->GAP_DAERAH;;
			$data['ANALISIS'] = $row->ANALISIS;
			$data['SIMPULAN'] = $row->SIMPULAN;
		}
		$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/tanggapan_telaah',$data, true);
		$this->load->view('main',$data2);
	}
	function proses_minta_koreksi($kd_pengajuan, $KODE_TELAAH_STAFF){
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row){
			$kode_jabatan = $row->KODE_JABATAN;
			$nama = $row->NAMA_USER;
		}
		$eselon = $this->session->userdata('eselon');
		$eselon_tujuan = '';
		if($eselon == '4') $eselon_tujuan = '0';
		else $eselon_tujuan = $eselon + 1;
		$data_koreksi= array(
			'TANGGAPAN' => $this->input->post('tanggapan'),
			'KD_PENGAJUAN' => $kd_pengajuan,
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'TERTANDA' => $nama,
			'ESELON' => $eselon,
			'ESELON_TUJUAN' => $eselon_tujuan,
		);
		$this->mm->save('tanggapan_telaah', $data_koreksi);
		foreach($this->mm->get_where('data_telaah_staff','KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF)->result() as $row)
			$status = $row->STATUS;
		$data_status = array('STATUS' => $status + 1);
		$this->mm->update('data_telaah_staff', $data_status, 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Minta koreksi telaah'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}
	function update_telaah_staff($kd_pengajuan,$KODE_TELAAH_STAFF){
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data['kode_telaah_staff'] = $KODE_TELAAH_STAFF;
		$data['kd_pengajuan'] = $kd_pengajuan;
		foreach($this->mm->get_where('data_telaah_staff','KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF)->result() as $row){
			$tanggal = explode('-',$row->TANGGAL);
			$data['PERSOALAN'] = $row->PERSOALAN;
			$data['PRAANGGAPAN'] = $row->PRAANGGAPAN;
			$data['FAKTA_YANG_MEMPENGARUHI'] = $row->FAKTA_YANG_MEMPENGARUHI;
			$data['COST_EFEKTIF'] = $row->COST_EFEKTIF;
			$data['EFISIEN'] = $row->EFISIEN;
			$data['FEASIBILITAS'] = $row->FEASIBILITAS;
			$data['EQUITY'] = $row->EQUITY;
			$data['GAP_DAERAH'] = $row->GAP_DAERAH;
			$data['ANALISIS'] = $row->ANALISIS;
			$data['SIMPULAN'] = $row->SIMPULAN;
		}
		if($this->session->userdata('eselon') == 0) $eselon_dari= 4;
		else $eselon_dari= $this->session->userdata('eselon') - 1;
		$rec_tanggapan = $this->mm->get_where4('tanggapan_telaah','KD_PENGAJUAN',$kd_pengajuan,'KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF,'ESELON_TUJUAN',$this->session->userdata('eselon'), 'ESELON',$eselon_dari);
		if($rec_tanggapan->num_rows() > 0){
			foreach($rec_tanggapan->result() as $tang){
				$data['tanggapan'] = $tang->TANGGAPAN;
				$data['tertanda'] = $tang->TERTANDA;
			}
		}
		$data['TANGGAL'] = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
		$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/edit_telaah_staff',$data, true);
		$this->load->view('main',$data2);
	}
	
	function proses_update_telaah_staff($kd_pengajuan,$KODE_TELAAH_STAFF){
		if($this->validasi_telaah() == FALSE){
			$data['kd_pengajuan'] = $kd_pengajuan;
			$data['kode_telaah_staff'] = $KODE_TELAAH_STAFF;
			$data['kd_pengajuan'] = $kd_pengajuan;
			$data['warning'] = 'Tanggal, persoalan, pra-anggapan, fakta yang memperngaruhi, penggunaan sumber daya yang efektif, feasibilitas, equity, gap daerah, analisis, dan simpulan harus diisi.';
			$data['TANGGAL'] = $this->input->post('tanggal');
			$data['PERSOALAN'] = $this->input->post('persoalan');
			$data['PRAANGGAPAN'] = $this->input->post('praanggapan');
			$data['FAKTA_YANG_MEMPENGARUHI'] = $this->input->post('fakta_yang_mempengaruhi');
			$data['COST_EFEKTIF'] = $this->input->post('cost_efektif');
			$data['EFISIEN'] = $this->input->post('efisien');
			$data['FEASIBILITAS'] = $this->input->post('feasibilitas');
			$data['EQUITY'] = $this->input->post('equity');
			$data['GAP_DAERAH'] = $this->input->post('gap_daerah');
			$data['ANALISIS'] = $this->input->post('analisis');
			$data['SIMPULAN'] = $this->input->post('simpulan');
			if($this->session->userdata('eselon') == 0) $eselon_dari= 4;
			else $eselon_dari= $this->session->userdata('eselon') - 1;
			$rec_tanggapan = $this->mm->get_where4('tanggapan_telaah','KD_PENGAJUAN',$kd_pengajuan,'KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF,'ESELON_TUJUAN',$this->session->userdata('eselon'), 'ESELON',$eselon_dari);
			if($rec_tanggapan->num_rows() > 0){
				foreach($rec_tanggapan->result() as $tang){
					$data['tanggapan'] = $tang->TANGGAPAN;
					$data['tertanda'] = $tang->TERTANDA;
				}
			}
			$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/edit_telaah_staff',$data, true);
			$this->load->view('main',$data2);
		}
		else
		{
		$tanggal = explode('-',$this->input->post('tanggal'));
		$data=array(
			'KD_PENGAJUAN' => $kd_pengajuan,
			'TANGGAL' => $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0],
			'PERSOALAN' =>$this->input->post('persoalan'),
			'PRAANGGAPAN' => $this->input->post('praanggapan'),
			'FAKTA_YANG_MEMPENGARUHI' => $this->input->post('fakta_yang_mempengaruhi'),
			'COST_EFEKTIF' => $this->input->post('cost_efektif'),
			'EFISIEN' => $this->input->post('efisien'),
			'FEASIBILITAS' => $this->input->post('feasibilitas'),
			'EQUITY' => $this->input->post('equity'),
			'GAP_DAERAH' => $this->input->post('gap_daerah'),
			'ANALISIS' => $this->input->post('analisis'),
			'SIMPULAN' => $this->input->post('simpulan')
		);
		$this->mm->update('data_telaah_staff', $data, 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		
		foreach($this->mm->get_where('users', 'USER_ID', $this->session->userdata('id_user'))->result() as $row)
				$kode_jabatan = $row->KODE_JABATAN;
		$data_akses= array(
			'KODE_TELAAH_STAFF' => $KODE_TELAAH_STAFF,
			'KD_PENGAJUAN' => $kd_pengajuan,
			'ID_USER' => $this->session->userdata('id_user'),
			'JABATAN' => $kode_jabatan,
			'AKTIVITAS' => 'Mengoreksi telaah'
		);
		$this->mm->save('pengakses_telaah', $data_akses);
		
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
		}
	}
	
	function delete_telaah_staff($kd_pengajuan, $KODE_TELAAH_STAFF){
		$this->mm->delete('data_telaah_staff', 'KODE_TELAAH_STAFF', $KODE_TELAAH_STAFF);
		redirect('e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan);
	}
	
	function detail_telaah_staff($kd_pengajuan, $KODE_TELAAH_STAFF){
		$data['kd_pengajuan'] = $kd_pengajuan;
		foreach($this->mm->get_where('data_telaah_staff','KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF)->result() as $row){
			$tanggal= explode('-',$row->TANGGAL);
			$data['TANGGAL'] = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			$data['PERSOALAN'] = $row->PERSOALAN;
			$data['PRAANGGAPAN'] = $row->PRAANGGAPAN;
			$data['FAKTA_YANG_MEMPENGARUHI'] = $row->FAKTA_YANG_MEMPENGARUHI;
			$data['COST_EFEKTIF'] = $row->COST_EFEKTIF;;
			$data['EFISIEN'] = $row->EFISIEN;;
			$data['FEASIBILITAS'] = $row->FEASIBILITAS;;
			$data['EQUITY'] = $row->EQUITY;;
			$data['GAP_DAERAH'] = $row->GAP_DAERAH;;
			$data['ANALISIS'] = $row->ANALISIS;
			$data['SIMPULAN'] = $row->SIMPULAN;
		}
		if($this->session->userdata('kd_role') == 2){
		if($this->session->userdata('eselon') == 0) $eselon_dari= 4;
		else $eselon_dari= $this->session->userdata('eselon') - 1;
		$rec_tanggapan = $this->mm->get_where4('tanggapan_telaah','KD_PENGAJUAN',$kd_pengajuan,'KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF,'ESELON_TUJUAN',$this->session->userdata('eselon'), 'ESELON',$eselon_dari);
		if($rec_tanggapan->num_rows() > 0){
			foreach($rec_tanggapan->result() as $tang){
				$data['tanggapan'] = $tang->TANGGAPAN;
				$data['tertanda'] = $tang->TERTANDA;
			}
		}
		}
		$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/detail_telaah_staff',$data, true);
		$this->load->view('main',$data2);
	}
	
	function cetak_telaah_staff($KODE_TELAAH_STAFF){
		$kepada= '';
		$dari= '';
		$jabatan_ttd='';
		$nama_ttd='';
		$nip_ttd='';
		$jabatan_user = $this->mm->get_where('users', 'USER_ID',$this->session->userdata('id_user'))->row()->KODE_JABATAN;
		if($this->session->userdata('eselon') != '1'){
			foreach($this->mm->get_where2('detail_telaah','KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF,'JABATAN_DARI',$jabatan_user)->result() as $row){
				$dari = $row->DARI;
				$kepada= $row->KEPADA;
			}
			foreach($this->mm->get_where('data_pegawai', 'id_peg', $dari)->result() as $r){
				$jabatan_ttd = $r->NAMA_JABATAN;
				$nama_ttd = $r->nama_peg;
				$nip_ttd = $r->nip_peg;
			}
		}
		else{
			foreach($this->mm->get_where2('detail_telaah','KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF,'JABATAN_KEPADA',$jabatan_user)->result() as $row){
				$dari = $row->DARI;
				$kepada= $row->KEPADA;
			}
			foreach($this->mm->get_where('data_pegawai', 'id_peg', $kepada)->result() as $r){
				$jabatan_ttd = $r->NAMA_JABATAN;
				$nama_ttd = $r->nama_peg;
				$nip_ttd = $r->nip_peg;
			}
		}
		$data['DARI']= '';
		foreach($this->mm->get_where('data_pegawai', 'id_peg', $dari)->result() as $d)
			$data['DARI']=$d->nama_peg;
		$data['KEPADA']= '';
		foreach($this->mm->get_where('data_pegawai', 'id_peg', $kepada)->result() as $k)
			$data['KEPADA']=$k->nama_peg;
		$data['jabatan_ttd'] = $jabatan_ttd;
		$data['nama_ttd'] = $nama_ttd;
		$data['nip_ttd'] = $nip_ttd;
		$hasil = $this->mm->get_where('data_telaah_staff','KODE_TELAAH_STAFF',$KODE_TELAAH_STAFF);
		$tanggal = explode('-',$hasil->row()->TANGGAL);
		$data['persoalan'] =  $hasil->row()->PERSOALAN;
		$data['tanggal'] = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
		$data['praanggapan'] =  $hasil->row()->PRAANGGAPAN;
		$data['fakta_yang_mempengaruhi'] =  $hasil->row()->FAKTA_YANG_MEMPENGARUHI;
		$data['cost_efektif'] =  $hasil->row()->COST_EFEKTIF;
		$data['efisien'] =  $hasil->row()->EFISIEN;
		$data['feasibilitas'] =  $hasil->row()->FEASIBILITAS;
		$data['equity'] =  $hasil->row()->EQUITY;
		$data['gap_daerah'] =  $hasil->row()->GAP_DAERAH;
		$data['analisis'] =  $hasil->row()->ANALISIS;
		$data['simpulan'] =  $hasil->row()->SIMPULAN;
		$kd_pengajuan = $hasil->row()->KD_PENGAJUAN;
		$data['perihal'] = $this->mm->get_where('pengajuan', 'KD_PENGAJUAN',$kd_pengajuan)->row()->PERIHAL;
		
		$this->load->view('e-planning/tambah_pengusulan/cetak_telaah_staff',$data);
	}
	
}
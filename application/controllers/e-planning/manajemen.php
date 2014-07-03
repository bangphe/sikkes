<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manajemen extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/Manajemen_model','mm');
		$this->load->model('e-planning/Pendaftaran_model','pm');
		$this->load->model('e-planning/Master_model','masmo');
		$this->load->model('e-planning/Aktivitas_model','am');
		$this->load->model('e-planning/feedback_model','fb');
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
	function grid_pengajuan(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['KD_PENGAJUAN'] = array('ID Proposal',60,TRUE,'center',0);
		$colModel['TANGGAL_PEMBUATAN'] = array('Tanggal Proposal',100,TRUE,'center',0);
		$colModel['nmsatker'] = array('Satker',200,TRUE,'left',1);
		$colModel['JUDUL_PROPOSAL'] = array('Judul Proposal',300,TRUE,'left',1);
		$colModel['NILAI_PROPOSAL'] = array('Nilai Proposal',150,TRUE,'right',1);
		$colModel['rencana_anggaran'] = array('Sumber Dana',70,TRUE,'center',1);
		if($this->session->userdata('kd_role') == Role_model::ADMIN) $colModel['IKK'] = array('Target IKK',75,TRUE,'center',0);
		$colModel['DETAIL'] = array('Detail',30,TRUE,'center',0);
		
		if($this->session->userdata('kd_role') != Role_model::PENYETUJU && $this->session->userdata('kd_role') != Role_model::PENELAAH && $this->session->userdata('kd_role') != Role_model::VERIFIKATOR && $this->session->userdata('kd_role') != Role_model::DIREKTORAT){
		$colModel['KOREKSI'] = array('Koreksi',40,TRUE,'center',0);
		$colModel['HAPUS'] = array('Hapus',25,TRUE,'center',0);
		$colModel['AKTIVITAS'] = array('RAB',25,TRUE,'center',0);
		$colModel['FPRK'] = array('Fokus Prioritas & Reformasi Kesehatan',125,TRUE,'center',0);
		}
		//$colModel['TELAAH_STAFF'] = array('Telaah Staff',50,TRUE,'center',0);
		if($this->session->userdata('kd_role') == Role_model::PENGUSUL){
			$colModel['STATUS'] = array('Status',200,TRUE,'center',0);
		}else if($this->session->userdata('kd_role') == Role_model::VERIFIKATOR){
			$colModel['TELAAH_STAFF'] = array('Telaah Staf',200,TRUE,'center',0);
			$colModel['REKOMENDASI'] = array('Rekomendasi',100,TRUE,'center',0);
			$colModel['STATUS'] = array('Status',200,TRUE,'center',1);
		}else if($this->session->userdata('kodejenissatker') == 3 && $this->session->userdata('kd_role') == Role_model::PENGUSUL){
			$colModel['REKOMENDASI'] = array('Rekomendasi',50,TRUE,'center',0);
			$colModel['STATUS'] = array('Status',200,TRUE,'center',1);
		}else if($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			$colModel['KOREKSI'] = array('Koreksi',40,TRUE,'center',0);
			$colModel['AKTIVITAS'] = array('RAB',25,TRUE,'center',0);
			$colModel['TELAAH_STAFF'] = array('Telaah Staf',200,TRUE,'center',0);
			$colModel['REKOMENDASI'] = array('Rekomendasi',100,TRUE,'center',0);
			$colModel['STATUS'] = array('Status',200,TRUE,'center',1);
		}else if($this->session->userdata('kd_role') == Role_model::ADMIN || $this->session->userdata('kd_role') == Role_model::PENYETUJU || $this->session->userdata('kd_role') == Role_model::PENELAAH || $this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING){
			$colModel['STATUS'] = array('Status',200,TRUE,'center',1);
		}else {
			$colModel['STATUS'] = array('Status',200,TRUE,'center',1);
		}
		if($this->session->userdata('kd_role') != Role_model::ADMIN && $this->session->userdata('kd_role') != Role_model::PENYETUJU && $this->session->userdata('kd_role') != Role_model::PENELAAH && $this->session->userdata('kd_role') != Role_model::ADMIN_PLANNING && $this->session->userdata('kd_role') != Role_model::DIREKTORAT)
			$colModel['FEEDBACK'] = array('Feedback',250,TRUE,'center',0);
        $colModel['CETAK'] = array('Cetak RAB',70,TRUE,'center',0);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '450',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		if($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_pengajuan";
		if($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN) $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$return = $this->mm->get_where('ref_tupoksi','kdsatker', $this->session->userdata('kdsatker'));
		
		if($return->num_rows() < 1)	{
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '#';
				alert('Tupoksi belum ada. Silakan mengisi tupoksi terlebih dahulu di menu Rencana Kerja Satker.');
			}			
		} 
		
		function goStatusKoreksi(kdpengajuan){
			var konfirmasi = confirm('apakah Anda yakin langsung direkomendasi?')
			if(konfirmasi == true){
				window.location='".base_url()."index.php/e-planning/manajemen/koreksi/'+kdpengajuan+'';
			}
		}
		</script>";
		} else {
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/tambah_usulan';    
			}			
		} 
		
		function goStatusKoreksi(kdpengajuan){
			var konfirmasi = confirm('apakah Anda yakin langsung direkomendasi?')
			if(konfirmasi == true){
				window.location='".base_url()."index.php/e-planning/manajemen/koreksi/'+kdpengajuan+'';
			}
		}
		</script>";
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
		$data['judul'] = 'Daftar Proposal';
		$data['e_planning'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function grid_list_pengajuan(){
		$valid_fields = array('nmsatker','JUDUL_PROPOSAL','NILAI_PROPOSAL','rencana_anggaran');
		$this->flexigrid->validate_post('TANGGAL_PENGAJUAN','asc',$valid_fields);
		$records = $this->mm->get_data_pengajuan();
		$records2 = $this->mm->get_data_pengajuan_dekon();
		$records3 = $this->mm->get_data_pengajuan_unit_utama();
		$records4 = $this->mm->get_data_pengajuan_roren();
		$records5 = $this->mm->get_data_pengajuan_direktorat();

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		if($this->session->userdata('kd_role') == Role_model::PENGUSUL){
			foreach ($records['records']->result() as $row){
				if($row->STATUS==1) $persetujuan='Proses di Tingkat Provinsi';
				elseif($row->STATUS==8) $persetujuan='Proses di Tingkat Direktorat';
				elseif($row->STATUS==2) $persetujuan='Proses di Tingkat Unit Utama';
				elseif($row->STATUS==3) $persetujuan='Proses di Roren';
				elseif($row->STATUS==6) $persetujuan='Sedang Dipertimbangkan';
				elseif($row->STATUS == 0 && $row->KodeJenisSatker == 1) {
					if($this->mm->cek('aktivitas','KD_PENGAJUAN',$row->KD_PENGAJUAN)) $persetujuan='<a href='.site_url().'/e-planning/manajemen/kirim_pengajuan_dekon/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin mengirim ?\nPERHATIAN!!!\nProposal yang telah terkirim tidak bisa diubah lagi jika tidak dimintai koreksi.\nPastikan proposal Anda telah terisi dengan benar.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					else $persetujuan='<a href="#" onclick="alert(\'Anda harus mengisi RAB terlebih dahulu\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
						
				}
				elseif($row->STATUS == 0 && $row->KodeJenisSatker == 2) {
					if($this->mm->cek('aktivitas','KD_PENGAJUAN',$row->KD_PENGAJUAN)) $persetujuan='<a href='.site_url().'/e-planning/manajemen/kirim_pengajuan_dekon/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin mengirim ?\nPERHATIAN!!!\nProposal yang telah terkirim tidak bisa diubah lagi jika tidak dimintai koreksi.\nPastikan proposal Anda telah terisi dengan benar.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					else $persetujuan='<a href="#" onclick="alert(\'Anda harus mengisi RAB terlebih dahulu\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
						
				}
				elseif($row->STATUS == 0 && $row->KodeJenisSatker == 5) {
					if($this->mm->cek('aktivitas','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 
				$persetujuan='<a href='.site_url().'/e-planning/manajemen/kirim_pengajuan_unit_utama/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin mengirim ?\nPERHATIAN!!!\nProposal yang telah terkirim tidak bisa diubah lagi jika tidak dimintai koreksi.\nPastikan proposal Anda telah terisi dengan benar.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					else $persetujuan='<a href="#" onclick="alert(\'Anda harus mengisi RAB terlebih dahulu\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
				}
				elseif($row->STATUS == 0 && $row->KodeJenisSatker == 3) {
					if($this->mm->cek('aktivitas','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 
				$persetujuan='<a href='.site_url().'/e-planning/manajemen/kirim_pengajuan_unit_utama/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin mengirim ?\nPERHATIAN!!!\nProposal yang telah terkirim tidak bisa diubah lagi jika tidak dimintai koreksi.\nPastikan proposal Anda telah terisi dengan benar.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					else $persetujuan='<a href="#" onclick="alert(\'Anda harus mengisi RAB terlebih dahulu\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
				}
				elseif($row->STATUS == 0 && $row->KodeJenisSatker == 4) {
					if($this->mm->cek('aktivitas','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 
				$persetujuan = '<a href='.site_url().'/e-planning/manajemen/kirim_pengajuan_unit_utama/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin mengirim ?\nPERHATIAN!!!\nProposal yang telah terkirim tidak bisa diubah lagi jika tidak dimintai koreksi.\nPastikan proposal Anda telah terisi dengan benar.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					else $persetujuan='<a href="#" onclick="alert(\'Anda harus mengisi RAB terlebih dahulu\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
				}
				
				$fungsi;
				foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$fungsi= $rw->KodeFungsi;}
				
				$subfungsi;
				foreach($this->mm->get_where('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$subfungsi= $rw->KodeSubFungsi;}
				
				$program;
				foreach($this->mm->get_where('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$program= $rw->KodeProgram;}
				
				$kegiatan;
				foreach($this->mm->get_where('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$kegiatan= $rw->KodeKegiatan;}
					
				$feedback = $this->fb->get_history($row->KD_PENGAJUAN);
				if($row->kdlokasi == $this->session->userdata('kodeprovinsi') && $feedback->num_rows() > 0){
					$link_feedback = '<a href="'.base_url().'index.php/e-planning/feedback/index/'.$row->KD_PENGAJUAN.'">Tanggapi Feedback</a>';
					// $koreksi = $this->mm->get_where('feedback_eplanning', 'ID_PENGAJUAN', $row->KD_PENGAJUAN)->row()->STATUS_KOREKSI;
					// $count_koreksi = count($koreksi);
					// $status_koreksi = $koreksi[$count_koreksi - 1];
				}else{
					$link_feedback = 'Tidak Ada Feedback';
				}
				$nilai_proposal = 0;
				foreach($this->mm->get_where('aktivitas','KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $nilai){
					$nilai_proposal += $nilai->Jumlah;
				}
				$aktivitas = '<a href='.site_url().'/e-planning/aktivitas/grid_aktivitas/'.$row->KD_PENGAJUAN.'/'.$fungsi.'/'.$subfungsi.'/'.$program.'/'.$kegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>';
				if($this->mm->cek('data_fokus_prioritas','KD_PENGAJUAN', $row->KD_PENGAJUAN) == FALSE || $this->mm->cek('data_reformasi_kesehatan','KD_PENGAJUAN', $row->KD_PENGAJUAN) == FALSE)
					$aktivitas = '<a href="#"  onclick="alert(\'Anda harus memilih paling sedikit 1 (satu) fokus prioritas dan 1 (satu) reformasi kesehatan. Silakan mengoreksi proposal Anda.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>';
				
				$tanggal_pembuatan = $row->TANGGAL_PEMBUATAN;
				$no = $no+1;
				if($row->STATUS < 1){
				$record_items[] = array(
					$no,
					$no,
					$row->KD_PENGAJUAN,
					$tanggal_pembuatan,
					$row->nmsatker,
					$row->JUDUL_PROPOSAL,
					'Rp '.number_format($nilai_proposal),
					$row->rencana_anggaran,
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/2><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
					'<a href='.site_url().'/e-planning/manajemen/delete_pengajuan/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
					$aktivitas,
					'<a href='.site_url().'/e-planning/manajemen/biaya_fprk/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					$persetujuan,
                    $link_feedback,
					'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
				);
				}
				elseif($row->STATUS_KOREKSI == 1){
				$record_items[] = array(
					$no,
					$no,
					$row->KD_PENGAJUAN,
					$tanggal_pembuatan,
					$row->nmsatker,
					$row->JUDUL_PROPOSAL,
					'Rp '.number_format($nilai_proposal),
					$row->rencana_anggaran,
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/2><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
					'<img border=\'0\' src=\''.base_url().'images/flexigrid/hapus_mono.png\'>',
					$aktivitas,
					'<a href='.site_url().'/e-planning/manajemen/biaya_fprk/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					$persetujuan,
                    $link_feedback,
					'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
				);
				}
				else {
				$record_items[] = array(
					$no,
					$no,
					$row->KD_PENGAJUAN,
					$tanggal_pembuatan,
					$row->nmsatker,
					$row->JUDUL_PROPOSAL,
					'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
					$row->rencana_anggaran,
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					'<img border=\'0\' src=\''.base_url().'images/flexigrid/edit_mono.png\'>',
					'<img border=\'0\' src=\''.base_url().'images/flexigrid/hapus_mono.png\'>',
					'<img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier_mono.png\'>',
					'<img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'>',
					$persetujuan,
                    $link_feedback,
					'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
				);
				}
			}
			if(isset($record_items))
				$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
			else
				$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		}

		//rekomendasi Verifikator jenis satker Dekonsentrasi
		elseif($this->session->userdata('kodejenissatker') == 2 && $this->session->userdata('kd_role') == Role_model::VERIFIKATOR){
			foreach ($records2['records']->result() as $row){
				
				if($row->STATUS == 1) {
					if ($this->mm->cek('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN) && $this->mm->get_where('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)->row()->STATUS >= 7) {
						$rekomendasi='<a href='.base_url().'index.php/e-planning/manajemen/setujui_direktorat/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\' onClick="return confirm(\'Apakah Anda yakin akan merekomendasi sekarang?\nProposal yang sudah direkomendasikan tidak bisa dikoreksi lagi oleh satker pengusul jika proposal diberi feedback.\')"></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_rekomendasi_step1/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
					}
					else {
						$rekomendasi='<a href="#" onclick="alert(\'Telaah staff belum dilakukan.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_rekomendasi_step1/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
					}

					$telaah=''; $stat_telaah='';
					if($this->pm->cek1('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 	{
						foreach($this->mm->get_where('data_telaah_staff', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $rw){
							if($rw->STATUS == '1') {$stat_telaah = 'Sudah ditelaah Staf';}
							elseif($rw->STATUS == '2') {$stat_telaah = 'Belum ditelaah';}
							elseif($rw->STATUS == '3') {$stat_telaah = 'Sudah ditelaah Kasubag';}
							elseif($rw->STATUS == '4') {$stat_telaah = 'Sudah ditelaah Staf';}
							elseif($rw->STATUS == '5') {$stat_telaah = 'Sudah ditelaah Kabag';}
							elseif($rw->STATUS == '6') {$stat_telaah = 'Sudah ditelaah Kasubag';}
							elseif($rw->STATUS == '7') {$stat_telaah = 'Sudah ditelaah Karoren';}
							elseif($rw->STATUS == '8') {$stat_telaah = 'Sudah ditelaah Admin';}
							elseif($rw->STATUS == '9') {$stat_telaah = 'Sudah ditelaah Direktorat';}
							elseif($rw->STATUS == '10') {$stat_telaah = 'Sudah ditelaah Verifikator';}
							else $stat_telaah = 'Belum ditelaah';
						}
						$telaah = $stat_telaah.'</br><a href="'.site_url().'/e-planning/telaah/grid_telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';
					}
					else{
						$telaah = 'Belum ditelaah</br><a href="'.site_url().'/e-planning/telaah/telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Buat Telaah Proposal"></a>';
					}
				}
				else {
					$rekomendasi = '-';
					$telaah = '-';
				}

				$fungsi;
				foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$fungsi= $rw->KodeFungsi;}
				
				$subfungsi;
				foreach($this->mm->get_where('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$subfungsi= $rw->KodeSubFungsi;}
				
				$program;
				foreach($this->mm->get_where('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$program= $rw->KodeProgram;}
				
				$kegiatan;
				foreach($this->mm->get_where('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$kegiatan= $rw->KodeKegiatan;}
				


				$feedback = $this->fb->get_history($row->KD_PENGAJUAN);
				if($row->STATUS == '1'){
					$link_feedback = base_url().'index.php/e-planning/feedback/index/'.$row->KD_PENGAJUAN;
				}else{
					$link_feedback = '#';
				}	
				
				$tanggal_pembuatan = $row->TANGGAL_PEMBUATAN;
				$no = $no+1;				
				if($row->STATUS==2) $persetujuan='Proses di Tingkat Unit Utama';
				elseif($row->STATUS==3) $persetujuan='Proses di Roren';
				elseif($row->STATUS==0) $persetujuan='Proses di Satker';
				elseif($row->STATUS==6) $persetujuan='Sedang Dipertimbangkan';
				elseif($row->STATUS==1) $persetujuan = 'Proses Verifikasi di Provinsi';
				elseif($row->STATUS==8) $persetujuan='Proses di Tingkat Direktorat';
				
				$record_items2[] = array(
					$no,
					$no,
					$row->KD_PENGAJUAN,
					$tanggal_pembuatan,
					$row->nmsatker,
					$row->JUDUL_PROPOSAL,
					'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)), 
					$row->rencana_anggaran,
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					$telaah,
					$rekomendasi,
					$persetujuan,
                    // '<a onclick="javascript:goStatusKoreksi('.$row->KD_PENGAJUAN.');">Langsung Rekomendasi</a> &nbsp;&nbsp; | &nbsp&nbsp;
					'<a href='.$link_feedback.'>Beri Feedback</a>',
					'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
				);
				
			}
			if(isset($record_items2))
				$this->output->set_output($this->flexigrid->json_build($records2['record_count'],$record_items2));
			else
				$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		} //END

		//rekomendasi Verifikator jenis satker Unit Utama
		elseif($this->session->userdata('kodejenissatker') == 3 && $this->session->userdata('kd_role') == Role_model::VERIFIKATOR) {
			
			foreach ($records3['records']->result() as $row){
				$Biaya=0;
				
				// if($row->STATUS == 2) $rekomendasi='<a href='.base_url().'index.php/e-planning/manajemen/uu_setujui/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\' onClick="return confirm(\'Apakah Anda yakin akan merekomendasi sekarang?\nProposal yang sudah direkomendasikan tidak bisa dikoreksi lagi oleh satker pengusul jika proposal diberi feedback.\')"></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_rekomendasi_step1/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
				// else $rekomendasi='';

				if($row->STATUS == 2) {
					if ($this->mm->cek('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN) && $this->mm->get_where('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)->row()->STATUS >= 7) {
						$rekomendasi='<a href='.base_url().'index.php/e-planning/manajemen/uu_setujui/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\' onClick="return confirm(\'Apakah Anda yakin akan merekomendasi sekarang?\nProposal yang sudah direkomendasikan tidak bisa dikoreksi lagi oleh satker pengusul jika proposal diberi feedback.\')"></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_rekomendasi_step1/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
					}
					else {
						$rekomendasi='<a href="#" onclick="alert(\'Telaah staff belum dilakukan.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_rekomendasi_step1/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
					}

					$telaah=''; $stat_telaah='';
					if($this->pm->cek1('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 	{
						foreach($this->mm->get_where('data_telaah_staff', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $rw){
							if($rw->STATUS == '1') {$stat_telaah = 'Sudah ditelaah Staf';}
							elseif($rw->STATUS == '2') {$stat_telaah = 'Belum ditelaah';}
							elseif($rw->STATUS == '3') {$stat_telaah = 'Sudah ditelaah Kasubag';}
							elseif($rw->STATUS == '4') {$stat_telaah = 'Sudah ditelaah Staf';}
							elseif($rw->STATUS == '5') {$stat_telaah = 'Sudah ditelaah Kabag';}
							elseif($rw->STATUS == '6') {$stat_telaah = 'Sudah ditelaah Kasubag';}
							elseif($rw->STATUS == '7') {$stat_telaah = 'Sudah ditelaah Karoren';}
							elseif($rw->STATUS == '8') {$stat_telaah = 'Sudah ditelaah Admin';}
							elseif($rw->STATUS == '9') {$stat_telaah = 'Sudah ditelaah Direktorat';}
							elseif($rw->STATUS == '10') {$stat_telaah = 'Sudah ditelaah Verifikator';}
							else $stat_telaah = 'Belum ditelaah';
						}
						$telaah = $stat_telaah.'</br><a href="'.site_url().'/e-planning/telaah/grid_telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';
					}
					else{
						$telaah = 'Belum ditelaah</br><a href="'.site_url().'/e-planning/telaah/telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Buat Telaah Proposal"></a>';
					}
				}
				else {
					$rekomendasi = '-';
					$telaah = '-';
				}

				if($row->STATUS==2) $persetujuan='Proses Verifikasi di Unit Utama';
				elseif($row->STATUS==3) $persetujuan='Proses di Roren';
				elseif($row->STATUS==0) $persetujuan='Proses di Satker';
				elseif($row->STATUS==6) $persetujuan='Sedang Dipertimbangkan';
				elseif($row->STATUS==1) $persetujuan = 'Proses di Tingkat Provinsi';
				elseif($row->STATUS==8) $persetujuan='Proses di Tingkat Direktorat';
				
				$fungsi;
				foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$fungsi= $rw->KodeFungsi;}
				
				$subfungsi;
				foreach($this->mm->get_where('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$subfungsi= $rw->KodeSubFungsi;}
				
				$program;
				foreach($this->mm->get_where('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$program= $rw->KodeProgram;}
				
				$kegiatan;
				foreach($this->mm->get_where('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$kegiatan= $rw->KodeKegiatan;}
					
				$feedback = $this->fb->get_history($row->KD_PENGAJUAN);
				if($row->STATUS == '2'){
					$link_feedback = base_url().'index.php/e-planning/feedback/index/'.$row->KD_PENGAJUAN;
				}else{
					$link_feedback = '#';
				}
				
				$tanggal_pembuatan = $row->TANGGAL_PEMBUATAN;
				$no = $no+1;
				$record_items3[] = array(
					$no,
					$no,
					$row->KD_PENGAJUAN,
					$tanggal_pembuatan,
					$row->nmsatker,
					$row->JUDUL_PROPOSAL,
					'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
					$row->rencana_anggaran,
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					$telaah,
					$rekomendasi,
					$persetujuan,
                    // '<a onclick="javascript:goStatusKoreksi('.$row->KD_PENGAJUAN.');">Langsung Rekomendasi</a> &nbsp;&nbsp; | &nbsp&nbsp;
					'<a href='.$link_feedback.'>Beri Feedback</a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
				);
			}
			if(isset($record_items3))
				$this->output->set_output($this->flexigrid->json_build($records3['record_count'],$record_items3));
			else
				$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		} //END

		//rekomendasi role Direktorat
		elseif($this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			foreach ($records5['records']->result() as $row){
				$rekomendasi;
				if($row->STATUS == 8) {
					if ($this->mm->cek('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN) && $this->mm->get_where('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)->row()->STATUS >= 7) {
						$rekomendasi='<a href='.base_url().'index.php/e-planning/manajemen/setujui_unit_utama/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\' onClick="return confirm(\'Apakah Anda yakin akan merekomendasi sekarang?\nProposal yang sudah direkomendasikan tidak bisa dikoreksi lagi oleh satker pengusul jika proposal diberi feedback.\')"></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_rekomendasi_step1/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
					}
					else {
						$rekomendasi='<a href="#" onclick="alert(\'Telaah staff belum dilakukan.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_rekomendasi_step1/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
					}

					$telaah=''; $stat_telaah='';
					if($this->pm->cek1('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 	{
						foreach($this->mm->get_where('data_telaah_staff', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $rw){
							if($rw->STATUS == '1') {$stat_telaah = 'Sudah ditelaah Staf';}
							elseif($rw->STATUS == '2') {$stat_telaah = 'Belum ditelaah';}
							elseif($rw->STATUS == '3') {$stat_telaah = 'Sudah ditelaah Kasubag';}
							elseif($rw->STATUS == '4') {$stat_telaah = 'Sudah ditelaah Staf';}
							elseif($rw->STATUS == '5') {$stat_telaah = 'Sudah ditelaah Kabag';}
							elseif($rw->STATUS == '6') {$stat_telaah = 'Sudah ditelaah Kasubag';}
							elseif($rw->STATUS == '7') {$stat_telaah = 'Sudah ditelaah Karoren';}
							elseif($rw->STATUS == '8') {$stat_telaah = 'Sudah ditelaah Admin';}
							elseif($rw->STATUS == '9') {$stat_telaah = 'Sudah ditelaah Direktorat';}
							else $stat_telaah = 'Belum ditelaah';
						}
						$telaah = $stat_telaah.'</br><a href="'.site_url().'/e-planning/telaah/grid_telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';
						// if($this->session->userdata('kd_role') == Role_model::DIREKTORAT)
						// 	$telaah = $stat_telaah.'</br><a href="'.site_url().'/e-planning/telaah/grid_telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';
						// else $telaah= $stat_telaah.'</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';
					}
					else{
						// if($this->session->userdata('eselon') == '0') $telaah = 'Belum ditelaah</br><a href="'.site_url().'/e-planning/telaah/telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Buat Telaah Proposal"></a>';
						// else $telaah = 'Belum ditelaah';
						$telaah = 'Belum ditelaah</br><a href="'.site_url().'/e-planning/telaah/telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Buat Telaah Proposal"></a>';
					}
				}
				else {
					$rekomendasi = '-';
					$telaah='-';
				}
				if($row->STATUS == 8) $persetujuan='Sedang di Direktorat / Pusat / Biro';
				elseif($row->STATUS==3) $persetujuan='Proses di Roren';
				elseif($row->STATUS==0) $persetujuan='Proses di Satker';
				elseif($row->STATUS==6) $persetujuan='Sedang Dipertimbangkan';
				elseif($row->STATUS==2) $persetujuan = 'Proses di Unit Utama';
				elseif($row->STATUS==1) $persetujuan = 'Proses di Tingkat Provinsi';

				$fungsi;
				foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$fungsi= $rw->KodeFungsi;}
				
				$subfungsi;
				foreach($this->mm->get_where('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$subfungsi= $rw->KodeSubFungsi;}
				
				$program;
				foreach($this->mm->get_where('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$program= $rw->KodeProgram;}
				
				$kegiatan;
				foreach($this->mm->get_where('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$kegiatan= $rw->KodeKegiatan;}
				
				$aktivitas = '<a href='.site_url().'/e-planning/aktivitas/grid_aktivitas/'.$row->KD_PENGAJUAN.'/'.$fungsi.'/'.$subfungsi.'/'.$program.'/'.$kegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>';
				
				$kodetelaah;
				foreach ($this->mm->get_where('data_telaah_staff', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $rw){
					$kodetelaah = $rw->KODE_TELAAH_STAFF;
				}

				$tanggal_pembuatan = $row->TANGGAL_PEMBUATAN;
				$nilai_p = $this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN);
				$nilai_up = $this->mm->sum('aktivitas_update','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN);
				$nilai_pr = $nilai_p + $nilai_up;
				$no = $no+1;
				if ($row->STATUS==0 || $row->STATUS==1 || $row->STATUS==2 || $row->STATUS==3) {
					$record_items5[] = array(
						$no,
						$no,
						$row->KD_PENGAJUAN,
						$tanggal_pembuatan,
						$row->nmsatker,
						$row->JUDUL_PROPOSAL,
						'Rp '.number_format($nilai_pr), 
						$row->rencana_anggaran,
						'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
						'<img border=\'0\' src=\''.base_url().'images/flexigrid/edit_mono.png\'>',
						'<img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier_mono.png\'>',
						$telaah,
						$rekomendasi,
						$persetujuan,
						'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
					);
				}
				else {
					$record_items5[] = array(
						$no,
						$no,
						$row->KD_PENGAJUAN,
						$tanggal_pembuatan,
						$row->nmsatker,
						$row->JUDUL_PROPOSAL,
						'Rp '.number_format($nilai_pr), 
						$row->rencana_anggaran,
						'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
						'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/2><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
						$aktivitas,
						$telaah,
						$rekomendasi,
						$persetujuan,
						'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
					);
				}
			}
			if(isset($record_items5))
				$this->output->set_output($this->flexigrid->json_build($records5['record_count'],$record_items5));
			else
				$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		} //END

		elseif($this->session->userdata('kd_role') == Role_model::ADMIN || $this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING){
			foreach ($records4['records']->result() as $row){
				$Biaya=0;
				if($row->STATUS==0 && $row->NO_REG_SATKER == $this->session->userdata{'kdsatker'})	{
					if($this->mm->cek('aktivitas','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 
					$persetujuan = '<a href='.site_url().'/e-planning/manajemen/kirim_pengajuan_roren/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin mengirim ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
					else $persetujuan='<a href="#" onclick="alert(\'Anda harus mengisi RAB terlebih dahulu\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/send.png\'></a>';
				}
				elseif($row->STATUS==6) $persetujuan='Sedang Dipertimbangkan';
				elseif($row->STATUS==1) $persetujuan='Proses di Tingkat Provinsi';
				elseif($row->STATUS==2) $persetujuan='Proses di Tingkat Unit Utama';
				elseif($row->STATUS==3) $persetujuan='Proses di Roren';
				elseif($row->STATUS==0) $persetujuan='Proses di Satker';
				elseif($row->STATUS==8) $persetujuan='Proses di Tingkat Direktorat / Pusat / Biro';
				else $persetujuan='';
				
				$fungsi;
				foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$fungsi= $rw->KodeFungsi;}
				
				$subfungsi;
				foreach($this->mm->get_where('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$subfungsi= $rw->KodeSubFungsi;}
				
				$program;
				foreach($this->mm->get_where('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$program= $rw->KodeProgram;}
				
				$kegiatan = '';
				foreach($this->mm->get_where('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $rw){
					$kegiatan= $rw->KodeKegiatan;}
					
				// $feedback = $this->fb->get_history($row->KD_PENGAJUAN);
				// if($row->ID_USER == $this->session->userdata('id_user') && $feedback->num_rows() > 0){
					$link_feedback = base_url().'index.php/e-planning/feedback/index/'.$row->KD_PENGAJUAN;
				// }else{
					// $link_feedback = '#';
				// }	
				$aktivitas = '<a href='.site_url().'/e-planning/aktivitas/grid_aktivitas/'.$row->KD_PENGAJUAN.'/'.$fungsi.'/'.$subfungsi.'/'.$program.'/'.$kegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>';
				if($this->mm->cek('data_fokus_prioritas','KD_PENGAJUAN', $row->KD_PENGAJUAN) == FALSE || $this->mm->cek('data_reformasi_kesehatan','KD_PENGAJUAN', $row->KD_PENGAJUAN) == FALSE)
					$aktivitas = '<a href="#"  onclick="alert(\'Anda harus memilih paling sedikit 1 (satu) fokus prioritas dan 1 (satu) reformasi kesehatan. Silakan mengoreksi proposal Anda.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>';
				$tanggal_pembuatan = $row->TANGGAL_PEMBUATAN;

				//ambil ikk yang dipilih
				$d_ikk = $this->pm->get_ikk_by_kdpengajuan($row->KD_PENGAJUAN);
				//ambil dari jumlah ikk dari kegiatan yang dipilih
				$d_keg = $this->pm->get_jumlah_ikk($row->KD_PENGAJUAN); 

				if($d_ikk->num_rows() > 0 || $d_keg->num_rows() > 0) {
					$ikk = $d_ikk->num_rows();
					$keg = $d_keg->num_rows();

					$target_ikk='';
					$target_nasional='';
					foreach($this->pm->get_ikk_by_kdpengajuan($row->KD_PENGAJUAN)->result() as $data_ikk) {
						$target = $this->pm->get_ikk_by_kodeikk($row->KD_PENGAJUAN, $data_ikk->KodeIkk);
						$target_nasional = $target->TargetNasional;
						$target_ikk = $target->Jumlah;
						if($target_ikk < $target_nasional) {
							$ikk--;
						}
						elseif($target_ikk >= $target_nasional) {
							$ikk=$ikk;
						}
					}
					$tot = round($ikk / $keg * 100,0);
					//warning icon IKK
					if($tot < 50)
					{

						$warning_icon_ikk = '<a href="#" onclick="opendialog('.$row->KD_PENGAJUAN.')"><img border=\'0\' src=\''.base_url().'images/flexigrid/bulb_red.png\'></a>';
					}
					else if($tot >= 50 && $tot < 75)
					{
						$warning_icon_ikk = '<a href="#" onclick="opendialog('.$row->KD_PENGAJUAN.')"><img border=\'0\' src=\''.base_url().'images/flexigrid/bulb_yellow.png\'></a>';
					}
					else if($tot >= 75 && $tot <= 100)
					{
						$warning_icon_ikk = '<a href="#" onclick="opendialog('.$row->KD_PENGAJUAN.')"><img border=\'0\' src=\''.base_url().'images/flexigrid/bulb_green.png\'></a>';
					}
				}

				else {
					$tot = 0;
				}
				
				
				
				

				$tar='';
				$t=0;
				foreach ($this->pm->getTargetIkk($row->KD_PENGAJUAN)->result() as $value) {
					$tar[$t] = $value->Jumlah;
					$t++;
				}

				$no = $no+1;
				if($row->STATUS == 0){
				$record_items4[] = array(
					$no,
					$no,
					$row->KD_PENGAJUAN,
					$tanggal_pembuatan,
					$row->nmsatker,
					// $nmprogram,
					$row->JUDUL_PROPOSAL,
					'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
					$row->rencana_anggaran,
					//$ikk.'/'.$keg,
					$tot.' % '.$warning_icon_ikk,
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/2><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
					'<a href='.site_url().'/e-planning/manajemen/delete_pengajuan/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
					$aktivitas,
					'<a href='.site_url().'/e-planning/manajemen/biaya_fprk/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					$persetujuan,
                    // '<a href='.$link_feedback.'>Beri Feedback</a>',
					'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
				);
				}
				else{
				$record_items4[] = array(
					$no,
					$no,
					$row->KD_PENGAJUAN,
					$tanggal_pembuatan,
					$row->nmsatker,
					// $nmprogram,
					$row->JUDUL_PROPOSAL,
					'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
					$row->rencana_anggaran,
					//$ikk.'/'.$keg,
					$tot.' % '.$warning_icon_ikk,
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/2><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
					'<a href='.site_url().'/e-planning/manajemen/delete_pengajuan/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
					$aktivitas,
					'<a href='.site_url().'/e-planning/manajemen/biaya_fprk/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					$persetujuan,
                    // '<a href='.$link_feedback.'>Beri Feedback</a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
				);
				}
			}
			if(isset($record_items4))
				$this->output->set_output($this->flexigrid->json_build($records4['record_count'],$record_items4));
			else
				$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		}
		elseif($this->session->userdata('kd_role') == Role_model::PENYETUJU || $this->session->userdata('kd_role') == Role_model::PENELAAH || $this->session->userdata('kd_role') == Role_model::DIREKTORAT){
			foreach ($records4['records']->result() as $row){
				$Biaya=0;
				if($row->STATUS==6) $persetujuan='Sedang Dipertimbangkan';
				elseif($row->STATUS==1) $persetujuan='Proses di Tingkat Provinsi';
				elseif($row->STATUS==2) $persetujuan='Proses di Tingkat Unit Utama';
				elseif($row->STATUS==3) $persetujuan='Proses di Roren';
				elseif($row->STATUS==0) $persetujuan='Proses di Satker';
				elseif($row->STATUS==8) $persetujuan='Proses di Tingkat Direktorat / Pusat / Biro';
				else $persetujuan='';
				
				$feedback = $this->fb->get_history($row->KD_PENGAJUAN);
				if($row->ID_USER == $this->session->userdata('id_user') && $feedback->num_rows() > 0){
					$link_feedback = base_url().'index.php/e-planning/feedback/index/'.$row->KD_PENGAJUAN;
				}else{
					$link_feedback = '#';
				}	
				
				$tanggal_pembuatan = $row->TANGGAL_PEMBUATAN;
				$no = $no+1;
				$record_items4[] = array(
					$no,
					$no,
					$row->KD_PENGAJUAN,
					$tanggal_pembuatan,
					$row->nmsatker,
					// $nmprogram,
					$row->JUDUL_PROPOSAL,
					'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
					$row->rencana_anggaran,
					'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
					$persetujuan,
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
				);
			}
			if(isset($record_items4))
				$this->output->set_output($this->flexigrid->json_build($records4['record_count'],$record_items4));
			else
				$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		}
	}
	
	function tampil_ikk($kode_pengajuan){
		$kodeprogram=$this->pm->get_where('data_program',$kode_pengajuan,'KD_PENGAJUAN')->row()->KodeProgram;
		$data['selected_program']=$kodeprogram;
		$data['kegiatan']=$this->pm->get_kegiatan_satker($data['selected_program']);
		$kodekegiatan=$this->pm->get_where('data_kegiatan',$kode_pengajuan,'KD_PENGAJUAN')->row()->KodeKegiatan;
		$data['selected_kegiatan']=$kodekegiatan;
		$data['ikk']=$this->pm->get_ikk_satker($data['selected_kegiatan'])->result();
		$data['judul'] = 'Tampil IKK';
		$data['kdpengajuan'] = $kode_pengajuan;
		$data['idTahun'] = $this->mm->get_where('ref_tahun_anggaran','thn_anggaran',$this->session->userdata('thn_anggaran'))->row()->idThnAnggaran;
		$this->load->view('e-planning/tambah_pengusulan/tampil_ikk',$data);
	}

	function grid_persetujuan(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['TANGGAL_PENGAJUAN'] = array('Tanggal Proposal',75,TRUE,'center',1);
		$colModel['nmsatker'] = array('Satker',250,TRUE,'left',1);
		$colModel['JUDUL_PROPOSAL'] = array('Judul Proposal',500,TRUE,'left',1);
		$colModel['NOMOR_SURAT'] = array('Nomor Proposal',100,TRUE,'left',1);
		$colModel['rencana_anggaran'] = array('Sumber Dana',100,TRUE,'center',1);
		$colModel['NILAI_PROPOSAL'] = array('Nilai Proposal',100,TRUE,'right',1);
		$colModel['PERIHAL'] = array('Perihal',250,TRUE,'left',1);
		$colModel['tupoksi'] = array('Tupoksi',250,TRUE,'left',1);
		$colModel['FokusPrioritas'] = array('Fokus Prioritas',400,TRUE,'left',1);
		$colModel['REFORMASI_KESEHATAN'] = array('Reformasi Kesehatan',400,TRUE,'left',1);
		$colModel['FUNGSI'] = array('Fungsi',200,TRUE,'left',1);
		$colModel['SUB_FUNGSI'] = array('Sub Fungsi',200,TRUE,'left',1);
		$colModel['PROGRAM'] = array('Program',400,TRUE,'left',1);
		$colModel['OUTCOME'] = array('Outcome',400,TRUE,'left',1);
		$colModel['IKU'] = array('IKU',400,TRUE,'left',1);
		$colModel['KEGIATAN'] = array('Kegiatan',400,TRUE,'left',1);
		$colModel['IKK'] = array('IKK',400,TRUE,'left',1);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		if ($this->session->userdata('kd_role') == Role_model::PENELAAH ||$this->session->userdata('kd_role') == Role_model::ADMIN ||$this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING) 
		$colModel['TELAAH_STAFF'] = array('Telaah Staf',200,TRUE,'center',0);
		if ($this->session->userdata('kd_role') == Role_model::PENYETUJU) // ||$this->session->userdata('kd_role') == Role_model::ADMIN) {
			$colModel['STATUS_TELAAH'] = array('Status Telaah',200,TRUE,'center',1);
		if ($this->session->userdata('kd_role') == Role_model::ADMIN ||$this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING ||$this->session->userdata('kd_role') == Role_model::PENYETUJU) 
			$colModel['STATUS'] = array('Keputusan',100,TRUE,'center',1);
		$colModel['FEEDBACK'] = array('Feedback',100,TRUE,'center',0);
		$colModel['CETAK'] = array('Cetak',50,TRUE,'center',0);
			
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
		$url = base_url()."index.php/e-planning/manajemen/grid_list_persetujuan";
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
		$data['judul'] = 'Persetujuan';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
function grid_list_persetujuan(){
		$valid_fields = array('TANGGAL_PENGAJUAN','nmsatker','JUDUL_PROPOSAL','NOMOR_SURAT','rencana_anggaran','NILAI_PROPOSAL','PERIHAL','tupoksi','FokusPrioritas','REFORMASI_KESEHATAN','FUNGSI','SUB_FUNGSI','PROGRAM','OUTCOME','IKU','KEGIATAN','IKK');
		$this->flexigrid->validate_post('TANGGAL_PENGAJUAN','asc',$valid_fields);
		$records = $this->mm->get_data_persetujuan();

		$this->output->set_header($this->config->item('json_header'));
		
		$telaah;
		$no = 0;
		foreach ($records['records']->result() as $row){
			$tanggal_pengajuan = explode("-", $row->TANGGAL_PENGAJUAN);
			//$fungsi='<input name="klik" id="klik" type="button" value="click me" onclick="TES('.$row->KD_PENGAJUAN.');"/>';
			// $fungsi='<a href="#" onclick="TES('.$row->KD_PENGAJUAN.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>';	
			$kodetelaah;
			foreach ($this->mm->get_where('data_telaah_staff', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $rw){
				$kodetelaah=$rw->KODE_TELAAH_STAFF;
			}
			$telaah=''; $telaah1=''; $stat_telaah='';
			if($this->pm->cek1('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 	{
				foreach($this->mm->get_where('data_telaah_staff', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $rw){
					if($rw->STATUS == '1') {$stat_telaah = 'Sudah ditelaah Staf';}
					elseif($rw->STATUS == '2') {$stat_telaah = 'Belum ditelaah';}
					elseif($rw->STATUS == '3') {$stat_telaah = 'Sudah ditelaah Kasubag';}
					elseif($rw->STATUS == '4') {$stat_telaah = 'Sudah ditelaah Staf';}
					elseif($rw->STATUS == '5') {$stat_telaah = 'Sudah ditelaah Kabag';}
					elseif($rw->STATUS == '6') {$stat_telaah = 'Sudah ditelaah Kasubag';}
					elseif($rw->STATUS == '7') {$stat_telaah = 'Sudah ditelaah Karoren';}
					elseif($rw->STATUS == '8') {$stat_telaah = 'Sudah ditelaah Admin';}
					else $stat_telaah = 'Belum ditelaah';
				}
				if($this->session->userdata('kd_role') == Role_model::ADMIN ||$this->session->userdata('kd_role') == Role_model::PENELAAH)
					$telaah = $stat_telaah.'</br><a href="'.site_url().'/e-planning/telaah/grid_telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';
				else $telaah= $stat_telaah.'</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';
			}
			else{
				if($this->session->userdata('eselon') == '0') $telaah = 'Belum ditelaah</br><a href="'.site_url().'/e-planning/telaah/telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Buat Telaah Proposal"></a>';
				elseif($this->session->userdata('kd_role') == Role_model::ADMIN) $telaah = 'Belum ditelaah</br><a href="'.site_url().'/e-planning/telaah/telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Buat Telaah Proposal"></a>';
				else $telaah = 'Belum ditelaah';
				$telaah1='Belum ditelaah';
			}
			
			foreach($this->mm->get_where('data_telaah_staff', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $rw){
				if($rw->STATUS == '1') {$telaah1 = 'Sudah ditelaah Staf</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"> <img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';}
				elseif($rw->STATUS == '2') {$telaah1 = 'Belum ditelaah';}
				elseif($rw->STATUS == '3') {$telaah1 = 'Sudah ditelaah Kasubag</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"> <img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';}
				elseif($rw->STATUS == '4') {$telaah1 = 'Sudah ditelaah Staf</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"> <img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';}
				elseif($rw->STATUS == '5') {$telaah1 = 'Sudah ditelaah Kabag</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"> <img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';}
				elseif($rw->STATUS == '6') {$telaah1 = 'Sudah ditelaah Kasubag</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"> <img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';}
				elseif($rw->STATUS == '7') {$telaah1 = 'Sudah ditelaah Karoren</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"> <img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';}
				elseif($rw->STATUS == '8') {$telaah1 = 'Sudah ditelaah Admin</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"> <img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';}
				elseif($rw->STATUS == '9') {$telaah1 = 'Sudah ditelaah Direktorat</br><a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"> <img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\' title="Lihat Telaah Proposal"></a>';}
				else $telaah1 = 'Belum ditelaah';
			}
			
			if($this->mm->cek('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN) && $this->mm->get_where('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)->row()->STATUS >= 7) 
			$persetujuan = '<a href="'.base_url().'index.php/e-planning/manajemen/setujui_pengajuan/'.$row->KD_PENGAJUAN.'" onClick="return confirm(\'Apakah Anda yakin akan menyetujui sekarang?\nProposal yang sudah disetujui tidak bisa dikoreksi lagi oleh satker pengusul jika proposal diberi feedback.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href="'.base_url().'index.php/e-planning/manajemen/tolak_pengajuan/'.$row->KD_PENGAJUAN.'" ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\' onClick="return confirm(\'Apakah Anda yakin akan menolak sekarang?\nProposal yang sudah ditolak tidak bisa dikoreksi lagi oleh satker pengusul jika proposal diberi feedback.\')"></a>&nbsp&nbsp&nbsp<a href="'.base_url().'index.php/e-planning/manajemen/pertimbangkan_pengajuan/'.$row->KD_PENGAJUAN.'" onClick="return confirm(\'Apakah Anda yakin akan mempertimbangkan sekarang?\nProposal yang sudah dipertimbangkan tidak bisa dikoreksi lagi oleh satker pengusul jika proposal diberi feedback.\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/pertimbangan.jpg\'></a>';
			else $persetujuan='<a href="#" onclick="alert(\'Telaah staff belum dilakukan\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href="#" onclick="alert(\'Telaah staff belum dilakukan\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>&nbsp&nbsp&nbsp<a href="#" onclick="alert(\'Telaah staff belum dilakukan\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/pertimbangan.jpg\'></a>';
			$no = $no+1;
			
			$tupoksi='';
			$t=0;
			foreach($this->mm->get_where_join('data_tupoksi','ref_tupoksi','data_tupoksi.KodeTupoksi = ref_tupoksi.KodeTupoksi','KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $r){
				$tupoksi[0] = $r->Tupoksi.'</br>';
				$t++;
			}
			$fp='';
			$f=0;
			foreach($this->mm->get_where_join('data_fokus_prioritas','fokus_prioritas','data_fokus_prioritas.idFokusPrioritas = fokus_prioritas.idFokusPrioritas','KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $r){
				$fp[$f] = $r->FokusPrioritas.'</br>';
				$f++;
			}
			
			$rk='';
			$k=0;
			foreach($this->mm->get_where_join('data_reformasi_kesehatan','reformasi_kesehatan','data_reformasi_kesehatan.idReformasiKesehatan = reformasi_kesehatan.idReformasiKesehatan','KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $r){
				$rk[$k]= $r->ReformasiKesehatan.'</br>';
				$k++;
			}
			$fungsi = $this->mm->get_where_join('data_fungsi','ref_fungsi','data_fungsi.KodeFungsi = ref_fungsi.KodeFungsi', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->row()->NamaFungsi;
			$subfungsi = $this->mm->get_where_join('data_sub_fungsi','ref_sub_fungsi','data_sub_fungsi.KodeSubFungsi = ref_sub_fungsi.KodeSubFungsi', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->row()->NamaSubFungsi;
			$program = $this->mm->get_where_join('data_program','ref_program','data_program.KodeProgram = ref_program.KodeProgram', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->row()->NamaProgram;
			$outcome = $this->mm->get_where_join('data_program','ref_program','data_program.KodeProgram = ref_program.KodeProgram', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->row()->OutComeProgram;
			$iku='';
			$u=0;
			foreach($this->mm->get_where_join('data_iku','ref_iku','data_iku.KodeIku = ref_iku.KodeIku','KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $r){
				$iku[$u]= $r->Iku.'</br>';
				$u++;
			}
			$kegiatan= $this->mm->get_where_join('data_kegiatan','ref_kegiatan','data_kegiatan.KodeKegiatan = ref_kegiatan.KodeKegiatan', 'KD_PENGAJUAN', $row->KD_PENGAJUAN)->row()->NamaKegiatan;
			$ikk='';
			$i=0;
			foreach($this->mm->get_where_join('data_ikk','ref_ikk','data_ikk.KodeIkk = ref_ikk.KodeIkk','KD_PENGAJUAN', $row->KD_PENGAJUAN)->result() as $r){
				$ikk[$i]= $r->Ikk.'</br>';
				$i++;
			}
			
			// $feedback = $this->fb->get_history($row->KD_PENGAJUAN);
			// if($row->ID_USER == $this->session->userdata('id_user') && $feedback->num_rows() > 0){
				$link_feedback = base_url().'index.php/e-planning/feedback/index/'.$row->KD_PENGAJUAN;
			// }else{
				// $link_feedback = '#';
			// }
			
			if ($this->session->userdata('kd_role') == Role_model::PENYETUJU){
			$record_items[] = array(
				$no,
				$no,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$row->nmsatker,
				$row->JUDUL_PROPOSAL,
				$row->NOMOR_SURAT,
				$row->rencana_anggaran,
				'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				$row->PERIHAL,
				$tupoksi,
				$fp,
				$rk,
				$fungsi,
				$subfungsi,
				$program,
				$outcome,
				$iku,
				$kegiatan,
				$ikk,
				'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				// '<a href='.site_url().'/e-planning/manajemen/grid_fungsi/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				$telaah1,
				$persetujuan,
				'<a href='.$link_feedback.'><img border=\'0\' src=\''.base_url().'images/icon/input.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
			);
			}
			elseif($this->session->userdata('kd_role') == Role_model::ADMIN ||$this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING){
			$record_items[] = array(
				$no,
				$no,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$row->nmsatker,
				$row->JUDUL_PROPOSAL,
				$row->NOMOR_SURAT,
				$row->rencana_anggaran,
				'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				$row->PERIHAL,
				$tupoksi,
				$fp,
				$rk,
				$fungsi,
				$subfungsi,
				$program,
				$outcome,
				$iku,
				$kegiatan,
				$ikk,
				'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				// '<a href='.site_url().'/e-planning/manajemen/grid_fungsi/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				// '',
				$telaah,
				$persetujuan,
				'<a href='.$link_feedback.'> Beri Feedback </a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
			);
			} elseif($this->session->userdata('kd_role') == Role_model::PENELAAH) {
			$record_items[] = array(
				$no,
				$no,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$row->nmsatker,
				$row->JUDUL_PROPOSAL,
				$row->NOMOR_SURAT,
				$row->rencana_anggaran,
				'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				$row->PERIHAL,
				$tupoksi,
				$fp,
				$rk,
				$fungsi,
				$subfungsi,
				$program,
				$outcome,
				$iku,
				$kegiatan,
				$ikk,
				'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				// '<a href='.site_url().'/e-planning/manajemen/grid_fungsi/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				$telaah,
				'<a href='.$link_feedback.'> Beri Feedback </a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
			);
			}
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function delete_pengajuan($kd_pengajuan){
		$this->pm->delete('data_fokus_prioritas', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_tupoksi', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_reformasi_kesehatan', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_menu_kegiatan', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_ikk', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_kegiatan', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_iku', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_program', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_sub_fungsi', 'KD_PENGAJUAN', $kd_pengajuan);
		$this->pm->delete('data_fungsi', 'KD_PENGAJUAN', $kd_pengajuan);
		foreach($this->mm->get_where('aktivitas','KD_PENGAJUAN',$kd_pengajuan)->result() as $row){
			$this->am->delete('aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('fp_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('rk_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
		}
		$this->pm->delete('pengajuan', 'KD_PENGAJUAN', $kd_pengajuan);
		redirect('e-planning/manajemen/grid_pengajuan');
	}

	//mengganti file proposal menjadi NULL
	function delete_file_proposal($kd_pengajuan) {
		$data = array('PROPOSAL' => NULL);
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
		//redirect('e-planning/manajemen/grid_pengajuan');
		redirect('/e-planning/manajemen/detail_pengajuan/'.$kd_pengajuan.'/2');
	}

	//mengganti file TOR menjadi NULL
	function delete_file_tor($kd_pengajuan) {
		$data = array('TOR' => NULL);
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
		redirect('/e-planning/manajemen/detail_pengajuan/'.$kd_pengajuan.'/2');
	}

	//mengganti file data pendukung menjadi NULL
	function delete_file_pendukung($kd_pengajuan) {
		$data = array('DATA_PENDUKUNG_LAINNYA' => NULL);
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
		redirect('/e-planning/manajemen/detail_pengajuan/'.$kd_pengajuan.'/2');
	}

	//mengirimkan pengajuan proposal ke tingkat provinsi / dekon
	function kirim_pengajuan_dekon($kd_pengajuan){
		$data = array('STATUS' => 1, 'TANGGAL_PENGAJUAN' => date('Y-m-d'));
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
		redirect('e-planning/manajemen/grid_pengajuan');
	}

	//mengirimkan pengajuan proposal ke tingkat direktorat
	function kirim_pengajuan_direktorat($kd_pengajuan){
		$data = array('STATUS' => 8, 'TANGGAL_PENGAJUAN' => date('Y-m-d'));
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
		redirect('e-planning/manajemen/grid_pengajuan');
	}
	
	//mengirimkan pengajuan proposal ke tingkat unit utama
	function kirim_pengajuan_unit_utama($kd_pengajuan){
		$data = array('STATUS' => 2, 'TANGGAL_PENGAJUAN' => date('Y-m-d'));
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
		redirect('e-planning/manajemen/grid_pengajuan');
	}
	
	//mengirimkan pengajuan proposal ke tingkat roren / kementerian
	function kirim_pengajuan_roren($kd_pengajuan){
		$data = array('STATUS' => 3, 'TANGGAL_PENGAJUAN' => date('Y-m-d'));
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
		redirect('e-planning/manajemen/grid_pengajuan');
	}
	
	function update_pengajuan($kd_pengajuan){
		if($this->validasi_pengajuan() == FALSE){
			$this->detail_pengajuan($kd_pengajuan,2);
		}else{
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
						redirect('e-planning/manajemen/detail_pengajuan/'.$kd_pengajuan.'/2');
					}else{
						$data[$i] = $this->upload->data();
						if($data[$i]['file_size'] > 0) $file[$i] = $data[$i]['file_name'];
					}
				}
			}
			
		$rencana_anggaran=$this->input->post('rencana_anggaran');
		$kdsatker=$this->input->post('kdsatker');
		$judul_proposal=$this->input->post('judul_proposal');
		$nomor_proposal=$this->input->post('nomor_proposal');
		$perihal=$this->input->post('perihal');
		
		if($this->input->post('tanggal_pembuatan') != ''){
		$tgl_pembuatan=explode('-',$this->input->post('tanggal_pembuatan'));
		$tanggal_pembuatan= $tgl_pembuatan[2].'-'.$tgl_pembuatan[1].'-'.$tgl_pembuatan[0];
		}else $tanggal_pembuatan= date('Y-m-d');
		
		$thn_anggaran=$this->input->post('thn_anggaran');
		$triwulan=$this->input->post('triwulan');
		
		if($this->input->post('tanggal_mulai') != ''){
		$tgl_mulai=explode('-',$this->input->post('tanggal_mulai'));
		$tanggal_mulai = $tgl_mulai[2].'-'.$tgl_mulai[1].'-'.$tgl_mulai[0];
		}else $tanggal_mulai= date('Y-m-d');
		
		if($this->input->post('tanggal_selesai') != ''){
		$tgl_selesai=explode('-',$this->input->post('tanggal_selesai'));
		$tanggal_selesai = $tgl_selesai[2].'-'.$tgl_selesai[1].'-'.$tgl_selesai[0];
		}else $tanggal_selesai= date('Y-m-d');
		
		$latar_belakang=$this->input->post('latar_belakang');
		$analisis_situasi=$this->input->post('analisis_situasi');
		$permasalahan=$this->input->post('permasalahan');
		$alternatif_solusi=$this->input->post('alternatif_solusi');
			$data = array(
			'TANGGAL_PEMBUATAN' => $tanggal_pembuatan,
			'NO_REG_SATKER' => $kdsatker,
			'JUDUL_PROPOSAL' => $judul_proposal,
			'NOMOR_SURAT' => $nomor_proposal,
			'PERIHAL' => $perihal,
			'LATAR_BELAKANG' => $latar_belakang,
			'TAHUN_ANGGARAN' => $thn_anggaran,
			'ANALISIS_SITUASI' => $analisis_situasi,
			'PERMASALAHAN' => $permasalahan,
			'ALTERNATIF_SOLUSI' => $alternatif_solusi,
			// 'PROPOSAL' => $file[1],
			// 'TOR' => $file[2],
			// 'DATA_PENDUKUNG_LAINNYA' => $file[3],
			'TRIWULAN' => $this->session->userdata('triwulan'),
			'ID_RENCANA_ANGGARAN' => $rencana_anggaran,
			'TANGGAL_MULAI' => $tanggal_mulai,
			'TANGGAL_SELESAI' => $tanggal_selesai
			);
			if($file[1] != "") { $data = $data + array('PROPOSAL' => $file[1]);}
			if($file[2] != "") { $data = $data + array('TOR' => $file[2]);}
			if($file[3] != "") { $data = $data + array('DATA_PENDUKUNG_LAINNYA' => $file[3]);}
			$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
						
			$this->pm->hapus_tupoksi($kd_pengajuan);
			$KodeTupoksi = $this->input->post('tupoksi');
			if($KodeTupoksi[0] !=Null){
				for($i=0; $i<count($KodeTupoksi); $i++){
					$data_tupoksi = array(
						'KodeTupoksi' => $KodeTupoksi[$i],
						'KD_PENGAJUAN' => $kd_pengajuan
					);
					$this->pm->save($data_tupoksi, 'data_tupoksi');
				}
			}
			
			$this->pm->hapus('data_reformasi_kesehatan', 'KD_PENGAJUAN', $kd_pengajuan);
			$idReformasiKesehatan = $this->input->post('reformasi_kesehatan');
			if($idReformasiKesehatan[0] !=Null){
				for($i=0; $i<count($idReformasiKesehatan); $i++){
					$data_reformasi_kesehatan = array(
						'idReformasiKesehatan' => $idReformasiKesehatan[$i],
						'KD_PENGAJUAN' => $kd_pengajuan,
						// 'Biaya' => $this->input->post('biaya_rk_'.$idReformasiKesehatan[$i])
					);
					$this->pm->save($data_reformasi_kesehatan, 'data_reformasi_kesehatan');
				}
			}
			
			$this->pm->hapus('data_fokus_prioritas', 'KD_PENGAJUAN', $kd_pengajuan);
			$idFokusPrioritas = $this->input->post('fokus_prioritas');
			if($idFokusPrioritas[0] !=Null){
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
		$this->pm->update('data_fungsi', $datafungsi, 'KD_PENGAJUAN', $kd_pengajuan);
		
		$subfungsi=$this->input->post('subfungsi');
		$datasubfungsi;
		foreach($this->mm->get_where2('ref_sub_fungsi', 'KodeSubFungsi', $subfungsi, 'KodeFungsi', $fungsi)->result() as $row){
		$datasubfungsi = array(
			'KodeSubFungsi' => $subfungsi,
			'NamaSubFungsi' => $row->NamaSubFungsi,
			'KodeFungsi' => $fungsi,
			'KD_PENGAJUAN' => $kd_pengajuan
		);
		}
		$this->pm->update('data_sub_fungsi', $datasubfungsi, 'KD_PENGAJUAN', $kd_pengajuan);
		
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
		$this->pm->update('data_program', $dataprogram, 'KD_PENGAJUAN', $kd_pengajuan);
		
		$this->pm->hapus('data_iku', 'KD_PENGAJUAN', $kd_pengajuan);
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
		$this->pm->update('data_kegiatan', $datakegiatan, 'KD_PENGAJUAN', $kd_pengajuan);
		
		$this->pm->hapus('data_ikk', 'KD_PENGAJUAN', $kd_pengajuan);
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
			redirect('e-planning/manajemen/grid_pengajuan');
		}
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
			array('field'=>'satker', 'label'=>'Nama Satker', 'rules'=>'callback_cek_dropdown'),
			array('field'=>'judul_proposal','label'=>'Judul Proposal', 'rules'=>'required')
		);
			//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		$this->form_validation->set_message('callback_cek_dropdown', '%s harus dipilih !!');

		return $this->form_validation->run();
	}
	
	function grid_fungsi($KD_PENGAJUAN){
		//$this->cek_session();
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['KodeFungsi'] = array('Kode Fungsi',300,TRUE,'center',1);
		$colModel['NamaFungsi'] = array('Nama Fungsi',300,TRUE,'center',1);
		$colModel['KodeSubFungsi'] = array('Sub Fungsi',100,TRUE,'center',1);
		$colModel['Hapus'] = array('Hapus',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => 330,
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		if($this->mm->cek('data_fungsi','KD_PENGAJUAN',$KD_PENGAJUAN) == 0) $buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_fungsi/".$KD_PENGAJUAN;
		if($this->mm->cek('data_fungsi','KD_PENGAJUAN',$KD_PENGAJUAN) == 0) $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Pengajuan
					</button>
					</form>
				</div>";
		if($this->mm->cek('data_fungsi','KD_PENGAJUAN',$KD_PENGAJUAN) == 0) $data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/tambah_fungsi/".$KD_PENGAJUAN."';    
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
		$data['judul'] = 'Daftar Fungsi';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	 //mengambil data user di tabel login
	function grid_list_fungsi($KodePengajuan){
		$valid_fields = array('KodeFungsi','NamaFungsi','KodeSubFungsi');
		$this->flexigrid->validate_post('KodeFungsi','asc',$valid_fields);
		$records = $this->mm->get_data_fungsi($KodePengajuan);

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){	
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->KodeFungsi,
				$row->NamaFungsi,
				'<a href='.site_url().'/e-planning/manajemen/grid_sub_fungsi/'.$KodePengajuan.'/'.$row->KodeFungsi.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.site_url().'/e-planning/manajemen/delete_fungsi/'.$KodePengajuan.'/'.$row->KodeFungsi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	function delete_fungsi($KD_Pengajuan, $KodeFungsi){
		$this->mm->delete2('data_sub_fungsi', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan);
		$this->mm->delete2('data_program', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan);
		$this->mm->delete2('data_iku', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan);
		$this->mm->delete2('data_kegiatan', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan);
		$this->mm->delete2('data_ikk', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan);
		$this->mm->delete2('data_menu_kegiatan', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan);
		foreach($this->mm->get_where('aktivitas','KD_PENGAJUAN',$KD_Pengajuan)->result() as $row){
			$this->am->delete('aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('fp_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('rk_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
		}
		$this->pm->hapus_fungsi($KD_Pengajuan, $KodeFungsi);
		redirect('e-planning/manajemen/grid_fungsi/'.$KD_Pengajuan);
	}
	function grid_sub_fungsi($KodePengajuan, $KodeFungsi){
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['KodeSubFungsi'] = array('Kode Sub Fungsi',100,TRUE,'center',1);
		$colModel['NamaSubFungsi'] = array('Nama Sub Fungsi',800,TRUE,'center',1);
		$colModel['PROGRAM'] = array('Program',100,TRUE,'center',1);
		$colModel['Hapus'] = array('Hapus',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => 330,
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		if($this->mm->cek2('data_sub_fungsi','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi) == 0) 
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_sub_fungsi/".$KodePengajuan."/".$KodeFungsi;
		if($this->mm->cek2('data_sub_fungsi','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi) == 0) $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Pengajuan
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_fungsi/".$KodePengajuan."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Fungsi
					</button>
					</form>
				</div>";
		if($this->mm->cek2('data_sub_fungsi','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi) == 0) $data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/tambah_sub_fungsi/".$KodePengajuan."/".$KodeFungsi."';    
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
		$data['judul'] = 'Daftar Sub Fungsi';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data user di tabel login
	function grid_list_sub_fungsi($KodePengajuan,$KodeFungsi){
		$valid_fields = array('KodeSubFungsi','NamaSubFungsi');
		$this->flexigrid->validate_post('KodeSubFungsi','asc',$valid_fields);
		$records = $this->mm->get_data_subFungsi($KodePengajuan,$KodeFungsi);

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){	
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->KodeSubFungsi,
				$row->NamaSubFungsi,
				'<a href='.base_url().'index.php/e-planning/manajemen/grid_program/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$row->KodeSubFungsi.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.site_url().'/e-planning/manajemen/delete_sub_fungsi/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$row->KodeSubFungsi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function delete_sub_fungsi($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi){
		$this->pm->hapus_sub_fungsi($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi);
		$this->mm->delete3('data_program', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi);
		$this->mm->delete3('data_iku', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi);
		$this->mm->delete3('data_kegiatan', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeFungsi.'.'.$KodeSubFungsi);
		$this->mm->delete3('data_ikk', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi);
		$this->mm->delete3('data_menu_kegiatan', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi);
		foreach($this->mm->get_where('aktivitas','KD_PENGAJUAN',$KD_Pengajuan)->result() as $row){
			$this->am->delete('aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('fp_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('rk_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
		}
		redirect('e-planning/manajemen/grid_sub_fungsi/'.$KD_Pengajuan.'/'.$KodeFungsi);
	}
	
	function grid_program($KodePengajuan, $KodeFungsi, $KodeSubFungsi){
		//$this->cek_session();
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['KodeProgram'] = array('Kode Program',100,TRUE,'center',1);
		$colModel['NamaProgram'] = array('Program',700,TRUE,'center',1);
		//$colModel['BIAYA'] = array('Biaya',100,TRUE,'right',1);
		$colModel['IKU'] = array('Iku',50,TRUE,'center',1);
		$colModel['KEGIATAN'] = array('Kegiatan',50,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => 330,
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		if($this->mm->cek3('data_program','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi) == 0) $buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_program/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi;
		if($this->mm->cek3('data_program','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi) == 0) $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Pengajuan
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_fungsi/".$KodePengajuan."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_sub_fungsi/".$KodePengajuan."/".$KodeFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Sub Fungsi
					</button>
					</form>
				</div>";
		if($this->mm->cek3('data_program','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi) == 0) $data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/tambah_program/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."';    
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
		$data['judul'] = 'Daftar Program';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function grid_list_program($KodePengajuan,$KodeFungsi,$KodeSubFungsi){
		$valid_fields = array('KodeProgram','NamaProgram','KEGIATAN');
		$this->flexigrid->validate_post('KodeProgram','asc',$valid_fields);
		$records = $this->mm->get_data_program($KodePengajuan, $KodeFungsi,$KodeSubFungsi);

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){	
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->KodeProgram,
				$row->NamaProgram,
				//number_format($row->Biaya),
				'<a href='.base_url().'index.php/e-planning/manajemen/grid_iku/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$row->KodeProgram.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/manajemen/grid_kegiatan/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$row->KodeProgram.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.site_url().'/e-planning/manajemen/delete_program/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$row->KodeProgram.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
	 		);
	 	}
	 	
	 	if(isset($record_items))
	 		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
	 	else
	 		$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	function delete_program($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram){
		$this->pm->hapus_program($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram);
		$this->mm->delete4('data_iku', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi, 'KodeProgram', $KodeProgram);
		$this->mm->delete4('data_kegiatan', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeFungsi.'.'.$KodeSubFungsi, 'KodeProgram', $KodeProgram);
		$this->mm->delete4('data_ikk', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi, 'KodeProgram', $KodeProgram);
		$this->mm->delete4('data_menu_kegiatan', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi, 'KodeProgram', $KodeProgram);
		foreach($this->mm->get_where('aktivitas','KD_PENGAJUAN',$KD_Pengajuan)->result() as $row){
			$this->am->delete('aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('fp_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('rk_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
		}
		redirect('e-planning/manajemen/grid_program/'.$KD_Pengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi);
	}
	function grid_iku($KodePengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram){
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['KodeIku'] = array('Kode IKU',100,TRUE,'center',1);
		$colModel['Iku'] = array('IKU',700,TRUE,'center',1);
		$colModel['Jumlah'] = array('Jumlah',100,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => 330,
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_iku/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Pengajuan
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_fungsi/".$KodePengajuan."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_sub_fungsi/".$KodePengajuan."/".$KodeFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Sub Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_program/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Program
					</button>
					</form>
				</div>";
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/tambah_iku/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."';
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
		$data['judul'] = 'Daftar Program';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function grid_list_iku($KodePengajuan,$KodeFungsi,$KodeSubFungsi, $KodeProgram){
		$valid_fields = array('KodeIku','Iku','Jumlah');
		$this->flexigrid->validate_post('Jumlah','desc',$valid_fields);
		$records = $this->mm->get_data_iku($KodePengajuan, $KodeFungsi,$KodeSubFungsi, $KodeProgram);

		$this->output->set_header($this->config->item('json_header'));
			
		$no = 0;
		foreach ($records['records']->result() as $row){	
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->KodeIku,
				$row->Iku,
				number_format($row->Jumlah),
				'<a href='.site_url().'/e-planning/manajemen/delete_iku/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$row->KodeIku.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
	 		);
	 	}
	 	
	 	if(isset($record_items))
	 		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
	 	else
	 		$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	function delete_iku($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeIku){
		$this->pm->hapus_iku($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeIku);
		redirect('e-planning/manajemen/grid_iku/'.$KD_Pengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram);
	}
	function grid_kegiatan($KodePengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram){
		//$this->cek_session();
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['KodeKegiatan'] = array('Kode Kegiatan',100,TRUE,'center',1);
		$colModel['NamaKegiatan'] = array('Kegiatan',700,TRUE,'center',1);
		//$colModel['Biaya'] = array('Biaya',100,TRUE,'right',1);
		$colModel['aktivitas'] = array('Aktivitas',50,FALSE,'center',0);
		$colModel['IKK'] = array('IKK',50,FALSE,'center',0);
		$colModel['DELETE'] = array('Delete',50,FALSE,'center',0);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => 330,
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		if($this->mm->cek4('data_kegiatan','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeFungsi.'.'.$KodeSubFungsi,'KodeProgram',$KodeProgram) == 0) $buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_kegiatan/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram;
		if($this->mm->cek4('data_kegiatan','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeFungsi.'.'.$KodeSubFungsi,'KodeProgram',$KodeProgram) == 0) $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Pengajuan
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_fungsi/".$KodePengajuan."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_sub_fungsi/".$KodePengajuan."/".$KodeFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Sub Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_program/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Program
					</button>
					</form>
				</div>";
		if($this->mm->cek4('data_kegiatan','KD_PENGAJUAN',$KodePengajuan,'KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeFungsi.'.'.$KodeSubFungsi,'KodeProgram',$KodeProgram) == 0) $data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/tambah_kegiatan/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."';    
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
		$data['judul'] = 'Daftar Kegiatan';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
		//mengambil data user di tabel login
	function grid_list_kegiatan($KodePengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram){
		$valid_fields = array('KodeKegiatan','NamaKegiatan');
		$this->flexigrid->validate_post('KodeKegiatan','asc',$valid_fields);
		
		$records = $this->mm->get_data_kegiatan($KodePengajuan,$KodeFungsi,$KodeSubFungsi,$KodeProgram);

		$this->output->set_header($this->config->item('json_header'));
			
		$no = 0;
		foreach ($records['records']->result() as $row){	
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->KodeKegiatan,
				$row->NamaKegiatan,
				//number_format($row->Biaya),
				'<a href='.base_url().'index.php/e-planning/aktivitas/grid_aktivitas/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$row->KodeProgram.'/'.$row->KodeKegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/manajemen/grid_ikk/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$row->KodeProgram.'/'.$row->KodeKegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.site_url().'/e-planning/manajemen/delete_kegiatan/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$row->KodeKegiatan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	function delete_kegiatan($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$this->pm->hapus_kegiatan($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan);
		$this->mm->delete5('data_ikk', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi, 'KodeProgram', $KodeProgram, 'KodeKegiatan', $KodeKegiatan);
		$this->mm->delete5('data_menu_kegiatan', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi, 'KodeProgram', $KodeProgram, 'KodeKegiatan', $KodeKegiatan);
		foreach($this->mm->get_where('aktivitas','KD_PENGAJUAN',$KD_Pengajuan)->result() as $row){
			$this->am->delete('aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('fp_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
			$this->am->delete('rk_aktivitas', 'KodeAktivitas', $row->KodeAktivitas);
		}
		redirect('e-planning/manajemen/grid_kegiatan/'.$KD_Pengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram);
	}
	function grid_ikk($KodePengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$id_rencana_anggaran='';
		foreach($this->mm->get_where('pengajuan','KD_PENGAJUAN',$KodePengajuan)->result() as $row){
			$id_rencana_anggaran=$row->ID_RENCANA_ANGGARAN;
		}
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['KodeIkk'] = array('Kode IKK',100,TRUE,'center',1);
		$colModel['Ikk'] = array('IKK',700,TRUE,'center',1);
		if($id_rencana_anggaran == 2){
			$colModel['KodeMenuKegiatan'] = array('Menu Kegiatan',50,TRUE,'center',1);
		}
		$colModel['Jumlah'] = array('Jumlah',100,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => 330,
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_ikk/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."/".$KodeKegiatan."/".$id_rencana_anggaran;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Pengajuan
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_fungsi/".$KodePengajuan."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_sub_fungsi/".$KodePengajuan."/".$KodeFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Sub Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_program/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Program
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_kegiatan/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kegiatan
					</button>
					</form>
				</div>";
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/tambah_ikk/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."/".$KodeKegiatan."';
			}			
		}
		</script>";
			
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
		$data['judul'] = 'IKK';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function grid_list_ikk($KodePengajuan,$KodeFungsi,$KodeSubFungsi,$KodeProgram,$KodeKegiatan,$id_rencana_anggaran){
		$valid_fields = array('KodeIkk','Ikk','Jumlah');
		$this->flexigrid->validate_post('Jumlah','desc',$valid_fields);
		$records = $this->mm->get_data_ikk($KodePengajuan, $KodeFungsi,$KodeSubFungsi,$KodeProgram,$KodeKegiatan);
		
		$this->output->set_header($this->config->item('json_header'));
			
		$no = 0;
		foreach ($records['records']->result() as $row){	
			$no = $no+1;
			if($id_rencana_anggaran==2){
				$record_items[] = array(
					$no,
					$no,
					$row->KodeIkk,
					$row->Ikk,
					'<a href='.base_url().'index.php/e-planning/manajemen/grid_menu_kegiatan/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'/'.$row->KodeIkk.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
					number_format($row->Jumlah),
					'<a href='.site_url().'/e-planning/manajemen/delete_ikk/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'/'.$row->KodeIkk.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
				);
			}else{
				$record_items[] = array(
					$no,
					$no,
					$row->KodeIkk,
					$row->Ikk,
					$row->Jumlah,
					'<a href='.site_url().'/e-planning/manajemen/delete_ikk/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'/'.$row->KodeIkk.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
				);
			}
	 	}
	 	
	 	if(isset($record_items))
	 		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
	 	else
	 		$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	function delete_ikk($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk){
		$this->pm->hapus_ikk($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk);
		$this->mm->delete6('data_menu_kegiatan', 'KodeFungsi', $KodeFungsi, 'KD_PENGAJUAN', $KD_Pengajuan, 'KodeSubFungsi', $KodeSubFungsi, 'KodeProgram', $KodeProgram, 'KodeKegiatan', $KodeKegiatan, 'KodeIkk', $KodeIkk);
		redirect('e-planning/manajemen/grid_ikk/'.$KD_Pengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan);
	}
	function biaya_fprk($kd_pengajuan){
		$data['kd_pengajuan']=$kd_pengajuan;
		$data['fp_selected'] = $this->pm->get_where('data_fokus_prioritas',$kd_pengajuan, 'KD_PENGAJUAN')->result();
		$data['rk_selected'] = $this->pm->get_where('data_reformasi_kesehatan',$kd_pengajuan, 'KD_PENGAJUAN')->result();
		$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/biaya_fprk', $data, true);
		$this->load->view('main', $data2);
	}
	function update_biaya_fprk($kd_pengajuan){
		foreach($this->pm->get_where('data_fokus_prioritas',$kd_pengajuan, 'KD_PENGAJUAN')->result() as $row){
			$data_fokus_prioritas = array(
				'Biaya' => $this->input->post('biaya_fp_'.$row->idFokusPrioritas)
			);
			$this->pm->update2('data_fokus_prioritas', $data_fokus_prioritas, 'KD_PENGAJUAN', $kd_pengajuan, 'idFokusPrioritas', $row->idFokusPrioritas);
		}
		foreach($this->pm->get_where('data_reformasi_kesehatan',$kd_pengajuan, 'KD_PENGAJUAN')->result() as $row){
			$data_reformasi_kesehatan = array(
				'Biaya' => $this->input->post('biaya_rk_'.$row->idReformasiKesehatan)
			);
			$this->pm->update2('data_reformasi_kesehatan', $data_reformasi_kesehatan, 'KD_PENGAJUAN', $kd_pengajuan, 'idReformasiKesehatan', $row->idReformasiKesehatan);
		}
		redirect('e-planning/manajemen/grid_pengajuan');
	}
	function detail_pengajuan($kd_pengajuan,$perintah,$popup=null){
		$data['kdsatker']='-';
		$data['selected_worker']='-';
		$data['provinsi']='-';
		$data['judul']='-';
		$tgl_buat='-';
		$tgl_mulai='-';
		$tgl_selesai='-';
		$data['nomor']='-';
		$data['perihal']='-';
		$data['thn_anggaran']='-';
		$data['triwulan']='-';
		$data['latar_belakang']='-';
		$data['analisis_situasi']='-';
		$data['permasalahan']='';
		$data['alternatif_solusi']='-';
		$data['proposal']='-';
		$data['KodeJenisSatker']='-';
		$data['tor']='-';
		$data['data_pendukung_lainnya']='-';
		$data['surat_rekomendasi_prov']='-';
		$data['surat_rekomendasi_uu']='-';
		$data['selected_rencana_anggaran']='';
		$data['kd_pengajuan']=$kd_pengajuan;
		$result = $this->pm->get_data_pengajuan($kd_pengajuan);
		foreach($result->result() as $row){
			$data['kdsatker']=$row->NO_REG_SATKER;
			$data['KodeJenisSatker']=$row->KodeJenisSatker;
			$data['selected_worker']=$row->NO_REG_SATKER;
			$data['provinsi']=$row->NamaProvinsi;
			$data['judul']=$row->JUDUL_PROPOSAL;
			$data['thn_anggaran']=$row->TAHUN_ANGGARAN;
			$tgl_buat=explode('-',$row->TANGGAL_PEMBUATAN);
			$tgl_mulai=explode('-',$row->TANGGAL_MULAI);
			$tgl_selesai=explode('-',$row->TANGGAL_SELESAI);
			$data['nomor']=$row->NOMOR_SURAT;
			$data['perihal']=$row->PERIHAL;
			$data['triwulan']=$row->TRIWULAN;
			$data['latar_belakang']=$row->LATAR_BELAKANG;
			$data['analisis_situasi']=$row->ANALISIS_SITUASI;
			$data['permasalahan']=$row->PERMASALAHAN;
			$data['selected_rencana_anggaran']=$row->ID_RENCANA_ANGGARAN;
			$data['alternatif_solusi']=$row->ALTERNATIF_SOLUSI;
			if($row->PROPOSAL!=NULL) $data['proposal']=$row->PROPOSAL;
			if($row->TOR!=NULL) $data['tor']=$row->TOR;
			if($row->DATA_PENDUKUNG_LAINNYA!=NULL) $data['data_pendukung_lainnya']=$row->DATA_PENDUKUNG_LAINNYA;
			if($row->SURAT_REKOMENDASI_PROV!=NULL) $data['surat_rekomendasi_prov']=$row->SURAT_REKOMENDASI_PROV;
			if($row->SURAT_REKOMENDASI_UU!=NULL) $data['surat_rekomendasi_uu']=$row->SURAT_REKOMENDASI_UU;
		}
		
		$data['tanggal_pembuatan']=$tgl_buat[2].'-'.$tgl_buat[1].'-'.$tgl_buat[0];
		$data['tanggal_mulai']=$tgl_mulai[2].'-'.$tgl_mulai[1].'-'.$tgl_mulai[0];
		$data['tanggal_selesai']=$tgl_selesai[2].'-'.$tgl_selesai[1].'-'.$tgl_selesai[0];
		
		$option_rencana_anggaran;
		$option_rencana_anggaran['0']= '--- Pilih Sumber Dana ---';
		foreach ($this->pm->get('ref_rencana_anggaran')->result() as $row){
			$option_rencana_anggaran[$row->id_rencana_anggaran] = $row->rencana_anggaran;
		}
		$data['rencana_anggaran'] = $option_rencana_anggaran;
		$option_satker['0'] = '-- Pilih SatKer --';
		foreach($this->pm->get_satker()->result() as $row){
			$option_satker[$row->kdsatker] = $row->nmsatker;
		}
		$option_jenis_satker;
		foreach($this->pm->get('ref_jenis_satker')->result() as $row){
			$option_jenis_satker[$row->KodeJenisSatker] = $row->JenisSatker;
		}
		$tupoksi=$this->pm->get_where('data_tupoksi',$kd_pengajuan, 'KD_PENGAJUAN');
		$selected_tupoksi = '';
		foreach($tupoksi->result() as $row){
			 foreach($this->mm->get_where('ref_tupoksi', 'KodeTupoksi',$row->KodeTupoksi)->result() as $rw)
				$selected_tupoksi .= $rw->Tupoksi.'</br>';
		}
		if ($tupoksi->num_rows < 1) $data['selected_tupoksi'] = '-</br>';
		else $data['selected_tupoksi'] = $selected_tupoksi;
		$data['tupoksi'] = $this->pm->get_where('ref_tupoksi',$this->session->userdata('kdsatker'),'kdsatker')->result();
		$data['jenis_satker'] = $option_jenis_satker;
		$data['satker'] = $option_satker;
		$data['reformasi_kesehatan'] = $this->pm->get('reformasi_kesehatan')->result();
		$data['fokus_prioritas'] = $this->pm->get('fokus_prioritas')->result();
		$data['fp_selected'] = $this->pm->get_where('data_fokus_prioritas',$kd_pengajuan, 'KD_PENGAJUAN')->result();
		$data['rk_selected'] = $this->pm->get_where('data_reformasi_kesehatan',$kd_pengajuan, 'KD_PENGAJUAN')->result();
		$option_fungsi['0'] = '--- Pilih Fungsi ---';
		foreach ($this->pm->get_where('ref_fungsi','1','KodeStatus')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = '['.$row->KodeFungsi.'] '.$row->NamaFungsi;
		}
		$option_program['0'] = '--- Pilih Program ---';
		foreach ($this->pm->get_program_satker()->result() as $row){
			$option_program[$row->KodeProgram] = '['.$row->KodeProgram.'] '.$row->NamaProgram;
		}
		$data['fungsi']=$option_fungsi;
		$kdfungsi = $this->pm->get_where('data_fungsi',$kd_pengajuan,'KD_PENGAJUAN')->row()->KodeFungsi;
		$data['selected_fungsi']=$kdfungsi;
		$data['program']=$option_program;
		$kodeprogram=$this->pm->get_where('data_program',$kd_pengajuan,'KD_PENGAJUAN')->row()->KodeProgram;
		$data['selected_program']=$kodeprogram;
		$outcome='';
		foreach($this->pm->get_where('ref_program',$kodeprogram,'KodeProgram')->result() as $outc)
			$outcome=$outc->OutComeProgram;
		$data['outcome']=$outcome;
		//$data['sub_fungsi']=$this->pm->get_where('ref_sub_fungsi','1','KodeStatus');
		$data['sub_fungsi']=$this->pm->get_where_double('ref_sub_fungsi', $kdfungsi, 'KodeFungsi', '1', 'KodeStatus');
		$data['selected_subfungsi']=$this->pm->get_where('data_sub_fungsi',$kd_pengajuan,'KD_PENGAJUAN')->row()->KodeSubFungsi;
		
		$data['kegiatan']=$this->pm->get_kegiatan_satker($data['selected_program']);
		$kodekegiatan=$this->pm->get_where('data_kegiatan',$kd_pengajuan,'KD_PENGAJUAN')->row()->KodeKegiatan;
		$data['selected_kegiatan']=$kodekegiatan;
		$output='';
		foreach($this->pm->get_where('ref_output',$kodekegiatan,'KodeKegiatan')->result() as $outp)
			$output= $outp->Output;
		$data['output']=$output;
		
		// if($this->pm->cek1('ref_satker_iku','kdsatker',$this->session->userdata('kdsatker')))
		// $data['iku'] = $this->pm->get_iku_satker($kode1)->result();
		// else
		$data['idTahun'] = $this->mm->get_where('ref_tahun_anggaran','thn_anggaran',$this->session->userdata('thn_anggaran'))->row()->idThnAnggaran;
		$data['iku'] =$this->pm->get_iku_satker($data['selected_program'])->result();
		
		// if($this->pm->cek1('ref_satker_ikk','kdsatker',$this->session->userdata('kdsatker')))
		// $data['ikk'] = $this->pm->get_ikk_satker($kode1)->result();
		// else
		$data['ikk']=$this->pm->get_ikk_satker($data['selected_kegiatan'])->result();
		$data['error_file'] = '';
		if($this->session->userdata('upload_file') != ''){
			$data['error_file'] = $this->session->userdata('upload_file');
			$this->session->unset_userdata('upload_file');
		} 		
		
		if($perintah==1){
			if($popup == 1){
				$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/detail_pengusulan', $data);
			}else{
				$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/detail_pengusulan', $data, true);
			}
		}else{ 
			$data2['content'] = $this->load->view('e-planning/tambah_pengusulan/edit_pengusulan', $data, true);
		}
		
		if($popup != 1){
			$this->load->view('main', $data2);
		}
	}
	function grid_pengajuan_disetujui(){		
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['JUDUL_PROPOSAL'] = array('Judul Proposal',350,TRUE,'left',1);
		$colModel['TANGGAL_PENGAJUAN'] = array('Tanggal Proposal',100,TRUE,'center',1);
		$colModel['TANGGAL_PERSETUJUAN'] = array('Tanggal Disetujui',100,TRUE,'center',1);
		$colModel['NILAI PROPOSAL'] = array('Nilai Proposal',100,TRUE,'center',1);
		$colModel['rencana_anggaran'] = array('Sumber Dana',100,TRUE,'center',1);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		// $colModel['DISETUJUI_OLEH'] = array('Disetujui Oleh',100,TRUE,'center',1);
		$colModel['CETAK'] = array('Cetak RAB',100,TRUE,'center',0);
			
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
		$url = base_url()."index.php/e-planning/manajemen/grid_list_pengajuan_disetujui";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		// $data['added_php'] = 
				// "<div class=\"buttons\">
					// <form action=\"".base_url()."index.php/e-planning/utility/cetak_pengusulan\" method=\"POST\">
					// <button type=\"submit\" class=\"positive\" name=\"cetak\">
						// <img src=\"".base_url()."images/main/excel.png\" alt=\"\"/>
						// Cetak Semua
					// </button>
					// </form>
				// </div>";
              // //$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
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
		$data['js_grid'] = $grid_js;
		$data['e_planning'] = "";
		$data['judul'] = 'Proposal Disetujui';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	 //mengambil data user di tabel login
	function grid_list_pengajuan_disetujui(){
		$valid_fields = array('NO_REG_SATKER','JUDUL_PROPOSAL','TANGGAL_PENGAJUAN','TANGGAL_PERSETUJUAN', 'rencana_anggaran');
		$this->flexigrid->validate_post('JUDUL_PROPOSAL','asc',$valid_fields);
		$records = $this->mm->get_data_disetujui();

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$tanggal_pengajuan = explode('-', $row->TANGGAL_PENGAJUAN);
			$tanggal_persetujuan = explode('-', $row->TANGGAL_PERSETUJUAN);
			
			if($this->pm->cek1('data_feedback','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 	{
			$feedback = '<a href='.site_url().'/e-planning/manajemen/cetak_feedback/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/print.png\'></a> <a href='.site_url().'/e-planning/manajemen/edit_feedback/1/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
			}
			else $feedback = '<a href='.site_url().'/e-planning/manajemen/feedback/1/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>';
			$no = $no+1;
			$record_items[] = array(
				$row->TANGGAL_PENGAJUAN,
				$no,
				$row->JUDUL_PROPOSAL,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$tanggal_persetujuan[2].'-'.$tanggal_persetujuan[1].'-'.$tanggal_persetujuan[0],
				'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				$row->rencana_anggaran,
				'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cetak_pengusulan(){
		$data['pengusulan'] = $this->mm->get_cetak();
		$this->load->view('e-planning/tambah_pengusulan/cetak_pengusulan',$data);
	}
	
	function cetak_pengusulan2($KD_PENGAJUAN){
		$data['pengusulan'] = $this->mm->get_where('pengajuan','KD_PENGAJUAN',$KD_PENGAJUAN);
		$this->load->view('e-planning/tambah_pengusulan/cetak_pengusulan',$data);
	}
	
	function rekap($thn_anggaran){
		$data['pengusulan'] = $this->mm->get('pengajuan');
		$this->load->view('e-planning/tambah_pengusulan/cetak_pengusulan',$data);
	}
	
	function grid_pengajuan_ditolak(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['JUDUL_PROPOSAL'] = array('Judul Proposal',350,TRUE,'left',1);
		$colModel['TANGGAL_PENGAJUAN'] = array('Tanggal Proposal',100,TRUE,'center',1);
		$colModel['TANGGAL_PERSETUJUAN'] = array('Tanggal Ditolak',100,TRUE,'center',1);
		$colModel['NILAI PROPOSAL'] = array('Nilai Proposal',200,TRUE,'right',1);
		$colModel['ID_RENCANA_ANGGARAN'] = array('Sumber Dana',100,TRUE,'center',1);
		$colModel['KETERANGAN'] = array('Keterangan',400,TRUE,'left',1);
		$colModel['DITOLAK'] = array('Penolak',200,TRUE,'left',1);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		$colModel['CETAK'] = array('Cetak',100,TRUE,'center',0);
			
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
		$url = base_url()."index.php/e-planning/manajemen/grid_list_pengajuan_ditolak";
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
		$data['judul'] = 'Daftar Proposal Ditolak';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	 //mengambil data user di tabel login
	function grid_list_pengajuan_ditolak(){
		$valid_fields = array('NO_REG_SATKER','JUDUL_PROPOSAL','TANGGAL_PENGAJUAN','TANGGAL_PERSETUJUAN','KETERANGAN');
		$this->flexigrid->validate_post('TANGGAL_PENGAJUAN','asc',$valid_fields);
		$records = $this->mm->get_data_ditolak();

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$tanggal_pengajuan = explode('-', $row->TANGGAL_PENGAJUAN);
			$tanggal_persetujuan = explode('-', $row->TANGGAL_PERSETUJUAN);
			
			if($this->pm->cek1('data_feedback','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 	{
			$feedback = '<a href='.site_url().'/e-planning/manajemen/cetak_feedback/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/print.png\'></a> <a href='.site_url().'/e-planning/manajemen/edit_feedback/1/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>';
			}
			else $feedback = '<a href='.site_url().'/e-planning/manajemen/feedback/2/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>';
			
			$ket=explode('^^^',$row->KETERANGAN);
			$keterangan = $ket[1];
			if($ket[0] == 'Roren')
				$kewenangan = $ket[0];
			else{
				$satker = $this->mm->get_where('ref_satker', 'kdsatker', $ket[0]);
				if($satker->num_rows > 0) $kewenangan = $satker->row()->nmsatker;
				else $kewenangan = $this->mm->get_where('ref_jenis_satker','KodeJenisSatker',$ket[0])->row()->JenisSatker;
			}
			
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->JUDUL_PROPOSAL,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$tanggal_persetujuan[2].'-'.$tanggal_persetujuan[1].'-'.$tanggal_persetujuan[0],
				'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				$row->rencana_anggaran,
				$keterangan,
				$kewenangan,
				'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function tolak_pengajuan($kd_pengajuan){
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data2['content'] = $this->load->view('e-planning/manajemen/tolak',$data, true);
		$this->load->view('main',$data2);
	}
	
	function tolak_proposal($kd_pengajuan){
		if($this->validasi_keterangan() == FALSE){
			$this->tolak_pengajuan($kd_pengajuan);
		}else{
			$data = array('STATUS' => 5,
				'STATUS_KOREKSI' => 0,
				'TANGGAL_PERSETUJUAN' => date('Y-m-d'),
				// 'ID_USER' => $this->session->userdata('id_user'),
				'KETERANGAN' => $this->session->userdata('kdsatker').'^^^'.$this->input->post('keterangan')
			);
			$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
			
			//menutup komentar feedback
			foreach($this->mm->get_where3('feedback_eplanning', 'ID_PENGAJUAN', $kd_pengajuan, 'ID_USER', $this->session->userdata('id_user'), 'PARENT', 0)->result() as $row)
				$this->pm->update('feedback_eplanning', array('STATUS' => 0), 'ID_FEEDBACK', $row->ID_FEEDBACK);
			
			redirect('e-planning/manajemen/grid_pengajuan_ditolak');
		}
	}
	
	function tolak_rekomendasi_step1($kd_pengajuan){
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data2['content'] = $this->load->view('e-planning/manajemen/tolak_rekomendasi',$data, true);
		$this->load->view('main',$data2);
	}
	
	function tolak_rekomendasi_step2($kd_pengajuan){
		if($this->validasi_keterangan() == FALSE){
			$this->tolak_pengajuan($kd_pengajuan);
		}else{
			$data = array('STATUS' => 7,
				'STATUS_KOREKSI' => 0,
				'TANGGAL_PERSETUJUAN' => date('Y-m-d'),
				// 'ID_USER' => $this->session->userdata('id_user'),
				'KETERANGAN' => $this->session->userdata('kdsatker').'^^^'.$this->input->post('keterangan')
			);
			$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
			
			//menutup komentar feedback
			foreach($this->mm->get_where3('feedback_eplanning', 'ID_PENGAJUAN', $kd_pengajuan, 'ID_USER', $this->session->userdata('id_user'), 'PARENT', 0)->result() as $row)
				$this->pm->update('feedback_eplanning', array('STATUS' => 0), 'ID_FEEDBACK', $row->ID_FEEDBACK);
			
			redirect('e-planning/manajemen/grid_pengajuan');
		}
	}
	
	//form menyetujui rekomendasi ke tingkat Unit Utama
	function setujui_unit_utama($kd_pengajuan){
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data2['content'] = $this->load->view('e-planning/manajemen/setujui_unit_utama',$data, true);
		$this->load->view('main',$data2);
	}

	//proses form rekomendasi
	function setujui_rekomendasi_unit_utama($kd_pengajuan){
		if($this->validasi_dokumen() == FALSE){
			$this->setujui_unit_utama($kd_pengajuan);
		}else{
			$surat_rekomendasi=null;
			$config['upload_path'] = "./file";
			$config['allowed_types'] ='doc|docx|pdf';
			$config['max_size']	= '500000';
							
			// create directory if doesn't exist
			if(!is_dir($config['upload_path']))
			mkdir($config['upload_path'], 0777);
			
			$this->load->library('upload', $config);
			//$nama_file=$this->input->post('file');
			if(!empty($_FILES['surat_rekomendasi']['name'])){			
				$upload = $this->upload->do_upload('surat_rekomendasi');
				$data = $this->upload->data();
				if($data['file_size'] > 0) $surat_rekomendasi = $data['file_name'];
			}
			$data = array('STATUS' => 2,
				'STATUS_KOREKSI' => 0,
				'SURAT_REKOMENDASI_DIR' => $surat_rekomendasi,
				'PROV_PEREKOMENDASI' => $this->session->userdata('id_user').'_'.$this->session->userdata('kdsatker').'_'.date('Y-m-d')
			);
			$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
			
			//menutup komentar feedback
			foreach($this->mm->get_where3('feedback_eplanning', 'ID_PENGAJUAN', $kd_pengajuan, 'ID_USER', $this->session->userdata('id_user'), 'PARENT', 0)->result() as $row)
				$this->pm->update('feedback_eplanning', array('STATUS' => 0), 'ID_FEEDBACK', $row->ID_FEEDBACK);
			
			redirect('e-planning/manajemen/grid_pengajuan');
		}
	}

	//menyetujui rekomendasi ke tingkat direktorat
	function setujui_direktorat($kd_pengajuan){
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data2['content'] = $this->load->view('e-planning/manajemen/setujui_direktorat',$data, true);
		$this->load->view('main',$data2);
	}
	
	//proses form rekomendasi
	function setujui_rekomendasi_direktorat($kd_pengajuan){
		if($this->validasi_dokumen() == FALSE){
			$this->setujui_direktorat($kd_pengajuan);
		}else{
			$surat_rekomendasi=null;
			$config['upload_path'] = "./file";
			$config['allowed_types'] ='doc|docx|pdf';
			$config['max_size']	= '500000';
							
			// create directory if doesn't exist
			if(!is_dir($config['upload_path']))
			mkdir($config['upload_path'], 0777);
			
			$this->load->library('upload', $config);
			//$nama_file=$this->input->post('file');
			if(!empty($_FILES['surat_rekomendasi']['name'])){			
				$upload = $this->upload->do_upload('surat_rekomendasi');
				$data = $this->upload->data();
				if($data['file_size'] > 0) $surat_rekomendasi = $data['file_name'];
			}
			$data = array('STATUS' => 8,
				'STATUS_KOREKSI' => 0,
				'SURAT_REKOMENDASI_PROV' => $surat_rekomendasi,
				'DIR_PEREKOMENDASI' => $this->session->userdata('id_user').'_'.$this->session->userdata('kdsatker').'_'.date('Y-m-d')
			);
			$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
			
			//menutup komentar feedback
			foreach($this->mm->get_where3('feedback_eplanning', 'ID_PENGAJUAN', $kd_pengajuan, 'ID_USER', $this->session->userdata('id_user'), 'PARENT', 0)->result() as $row)
				$this->pm->update('feedback_eplanning', array('STATUS' => 0), 'ID_FEEDBACK', $row->ID_FEEDBACK);
			
			redirect('e-planning/manajemen/grid_pengajuan');
		}
	}

	//form menyetujui untuk merekomendasikan proposal ke Roren
	function uu_setujui($kd_pengajuan){
		$data['kd_pengajuan'] = $kd_pengajuan;
		$data2['content'] = $this->load->view('e-planning/manajemen/uu_setujui',$data, true);
		$this->load->view('main',$data2);
	}

	//form action uu_setujui
	function uu_setujui_rekomendasi($kd_pengajuan){
		if($this->validasi_dokumen() == FALSE){
			$this->uu_setujui($kd_pengajuan);
		}else{
			$surat_rekomendasi=null;
			$config['upload_path'] = "./file";
			$config['allowed_types'] ='doc|docx|pdf';
			$config['max_size']	= '500000';
							
			// create directory if doesn't exist
			if(!is_dir($config['upload_path']))
			mkdir($config['upload_path'], 0777);
			
			$this->load->library('upload', $config);
			//$nama_file=$this->input->post('file');
			if(!empty($_FILES['surat_rekomendasi']['name'])){			
				$upload = $this->upload->do_upload('surat_rekomendasi');
				$data = $this->upload->data();
				if($data['file_size'] > 0) $surat_rekomendasi = $data['file_name'];
			}
			$data = array('STATUS' => 3,
				'STATUS_KOREKSI' => 0,
				'SURAT_REKOMENDASI_UU' => $surat_rekomendasi,
				'UU_PEREKOMENDASI' => $this->session->userdata('id_user').'_'.$this->session->userdata('kdsatker').'_'.date('Y-m-d')
			);
			$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
			
			//menutup komentar feedback
			foreach($this->mm->get_where3('feedback_eplanning', 'ID_PENGAJUAN', $kd_pengajuan, 'ID_USER', $this->session->userdata('id_user'), 'PARENT', 0)->result() as $row)
				$this->pm->update('feedback_eplanning', array('STATUS' => 0), 'ID_FEEDBACK', $row->ID_FEEDBACK);
			
			redirect('e-planning/manajemen/grid_pengajuan');
		}
	}
	
	function setujui_pengajuan($kd_pengajuan){
		$data = array('STATUS' => 4,
				'STATUS_KOREKSI' => 0,
			// 'ID_USER' => $this->session->userdata('kdsatker'),
			'TANGGAL_PERSETUJUAN' => date('Y-m-d')
		);
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
			
			//menutup komentar feedback
			foreach($this->mm->get_where3('feedback_eplanning', 'ID_PENGAJUAN', $kd_pengajuan, 'ID_USER', $this->session->userdata('id_user'), 'PARENT', 0)->result() as $row)
				$this->pm->update('feedback_eplanning', array('STATUS' => 0), 'ID_FEEDBACK', $row->ID_FEEDBACK);
			
		redirect('e-planning/manajemen/grid_pengajuan_disetujui');
	}
	
	function pertimbangkan_pengajuan($kd_pengajuan){
		$data = array('STATUS' => 6,
				'STATUS_KOREKSI' => 0);
		$this->pm->update('pengajuan', $data, 'KD_PENGAJUAN', $kd_pengajuan);
			
			//menutup komentar feedback
			foreach($this->mm->get_where3('feedback_eplanning', 'ID_PENGAJUAN', $kd_pengajuan, 'ID_USER', $this->session->userdata('id_user'), 'PARENT', 0)->result() as $row)
				$this->pm->update('feedback_eplanning', array('STATUS' => 0), 'ID_FEEDBACK', $row->ID_FEEDBACK);
			
		redirect('e-planning/manajemen/grid_pertimbangan');
	}
	
	function validasi_dokumen(){
		$config = array( array('field'=>'surat_rekomendasi','label'=>'Dokumen Rekomendasi', 'rules'=>'callback_cek_file'));
		//setting rules
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('callback_cek_file', '%s harus diisi !!');
		return $this->form_validation->run();
	}

	function validasi_keterangan(){
		$config = array( array('field'=>'keterangan','label'=>'Keterangan', 'rules'=>'required'));
		//setting rules
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s harus diisi !!');
		return $this->form_validation->run();
	}
		function cek_file($value){
		if(!empty($_FILES['surat_rekomendasi']['name'])){
			return TRUE;
		}
		else{
			$this->form_validation->set_message('cek_file', '%s harus diisi !!');
			return FALSE;
		}
	}
	
	function grid_menu_kegiatan($KodePengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk){
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['KodeMenuKegiatan'] = array('Kode Menu Kegiatan',100,TRUE,'center',1);
		$colModel['MenuKegiatan'] = array('Menu Kegiatan',700,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => 330,
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => '',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_menu_kegiatan/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."/".$KodeKegiatan."/".$KodeIkk;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_pengajuan\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Pengajuan
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_fungsi/".$KodePengajuan."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_sub_fungsi/".$KodePengajuan."/".$KodeFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Sub Fungsi
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_program/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Program
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_kegiatan/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Kegiatan
					</button>
					</form>
					<form action=\"".base_url()."index.php/e-planning/manajemen/grid_ikk/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."/".$KodeKegiatan."\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Ikk
					</button>
					</form>
				</div>";
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/tambah_menu_kegiatan/".$KodePengajuan."/".$KodeFungsi."/".$KodeSubFungsi."/".$KodeProgram."/".$KodeKegiatan."/".$KodeIkk."';
			}
		}
		</script>";
			
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
		$data['judul'] = 'IKK';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function grid_list_menu_kegiatan($KodePengajuan,$KodeFungsi,$KodeSubFungsi,$KodeProgram,$KodeKegiatan,$KodeIkk){
		$valid_fields = array('KodeMenuKegiatan','MenuKegiatan');
		$this->flexigrid->validate_post('MenuKegiatan','desc',$valid_fields);
		$records = $this->mm->get_data_menu_kegiatan($KodePengajuan, $KodeFungsi,$KodeSubFungsi,$KodeProgram,$KodeKegiatan,$KodeIkk);

		$this->output->set_header($this->config->item('json_header'));
			
		$no = 0;
		foreach ($records['records']->result() as $row){	
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->KodeMenuKegiatan,
				$row->MenuKegiatan,
				'<a href='.site_url().'/e-planning/manajemen/delete_menu_kegiatan/'.$KodePengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'/'.$KodeIkk.'/'.$row->KodeMenuKegiatan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
	 		);
	 	}
	 	
	 	if(isset($record_items))
	 		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
	 	else
	 		$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function delete_menu_kegiatan($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk, $KodeMenuKegiatan){
		$this->pm->hapus_menu_kegiatan($KD_Pengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk, $KodeMenuKegiatan);
		redirect('e-planning/manajemen/grid_menu_kegiatan/'.$KD_Pengajuan.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan.'/'.$KodeIkk);
	}
	
	function grid_pertimbangan(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['TANGGAL_PENGAJUAN'] = array('Tanggal Proposal',75,TRUE,'center',0);
		$colModel['nmsatker'] = array('Satker',250,TRUE,'left',1);
		$colModel['JUDUL_PROPOSAL'] = array('Judul Proposal',400,TRUE,'left',1);
		$colModel['NILAI_PROPOSAL'] = array('Nilai Proposal',100,TRUE,'right',1);
		$colModel['rencana_anggaran'] = array('Sumber Dana',100,TRUE,'center',1);
		$colModel['TELAAH_STAFF'] = array('Telaah Staf',50,TRUE,'center',0);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		// $colModel['KD_FUNGSI'] = array('Fungsi',50,TRUE,'center',0);
		if ($this->session->userdata('kd_role') == Role_model::PENYETUJU ||$this->session->userdata('kd_role') == Role_model::ADMIN ||$this->session->userdata('kd_role') == Role_model::ADMIN_PLANN) 
			$colModel['STATUS'] = array('Keputusan',100,TRUE,'center',1);
		$colModel['CETAK'] = array('Cetak',100,TRUE,'center',0);
			
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
		//$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/list_pertimbangan";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		/*
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/pendaftaran/pengajuan_step1';    
			}			
		} </script>";
		*/
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
		$data['judul'] = 'Daftar Proposal Dipertimbangkan';
		$data['e_planning'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function list_pertimbangan(){
		$valid_fields = array('nmsatker','JUDUL_PROPOSAL','NILAI_PROPOSAL','rencana_anggaran');
		$this->flexigrid->validate_post('TANGGAL_PENGAJUAN','asc',$valid_fields);
		$records = $this->mm->get_data_pertimbangan();

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$tanggal_pengajuan = explode("-", $row->TANGGAL_PENGAJUAN);
			$fungsi='<a href="#" onclick="TES('.$row->KD_PENGAJUAN.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>';
			$kodetelaah = $this->mm->get_where('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)->row()->KODE_TELAAH_STAFF;
			if($this->pm->cek1('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 	{
			if($this->session->userdata('kd_role') == Role_model::PENELAAH)
			$telaah='<a href="'.site_url().'/e-planning/telaah/grid_telaah_staff/'.$row->KD_PENGAJUAN.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>';
			$telaah='<a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$row->KD_PENGAJUAN.'/'.$kodetelaah.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>';
			}
			else{
			$telaah='Belum ditelaah';
			}
			// if($this->mm->cek('data_telaah_staff','KD_PENGAJUAN',$row->KD_PENGAJUAN)) $persetujuan = '<a href='.base_url().'index.php/e-planning/manajemen/setujui_pengajuan/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin menyetujui ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_pengajuan/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
			// else $persetujuan='<a href="#" onclick="alert(\'Telaah staff belum dilakukan\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href="#" onclick="alert(\'Telaah staff belum dilakukan\')" ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>';
			
			$no = $no+1;
		if ($this->session->userdata('kd_role') == Role_model::PENYETUJU ||$this->session->userdata('kd_role') == Role_model::ADMIN ||$this->session->userdata('kd_role') == Role_model::ADMIN_PLANN) {
			$record_items[] = array(
				$no,
				$no,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$row->nmsatker,
				$row->JUDUL_PROPOSAL,
				'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				$row->rencana_anggaran,
				'<a href='.site_url().'/e-planning/telaah/detail_telaah_staff/'.$kodetelaah.'/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/e-planning/telaah/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				// '<a href='.site_url().'/e-planning/manajemen/grid_fungsi/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/manajemen/setujui_pengajuan/'.$row->KD_PENGAJUAN.' onclick="return confirm(\'Anda yakin ingin menyetujui ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'></a>&nbsp&nbsp&nbsp<a href='.base_url().'index.php/e-planning/manajemen/tolak_pengajuan/'.$row->KD_PENGAJUAN.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
			);
		} else{
			$record_items[] = array(
				$no,
				$no,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$row->nmsatker,
				$row->JUDUL_PROPOSAL,
				'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				$row->rencana_anggaran,
				$telaah,
				'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				// '<a href='.site_url().'/e-planning/manajemen/grid_fungsi/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
			);
		}
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function feedback($perintah,$kd_pengajuan){
		$data['perintah']=$perintah;
		$data['kdsatker']='-';
		$data['provinsi']='-';
		$data['judul']='-';
		$data['tanggal_pengajuan']='-';
		$data['perihal']='-';
		$data['nomor_pengajuan']='-';
		$data['jabatan']='-';
		$data['alamat']='-';
		$data['kode_jenis_satker']='-';
		$data['kode_unit']='-';
		$data['kd_pengajuan']=$kd_pengajuan;
		$result = $this->pm->get_data_pengajuan($kd_pengajuan);
		foreach($result->result() as $row){
			$data['kdsatker']=$row->NO_REG_SATKER;
			$data['nmsatker']=$row->nmsatker;
			$data['provinsi']=$row->NamaProvinsi;
			$data['judul']=$row->JUDUL_PROPOSAL;
			$data['tanggal_pengajuan']=$row->TANGGAL_PENGAJUAN;
			$data['perihal']=$row->PERIHAL;
			$data['nomor_pengajuan']=$row->NOMOR_SURAT;
		}
		$result2 = $this->mm->get_where_double_join('pengajuan','users','ID_USER = USER_ID','ref_provinsi','users.KodeProvinsi = ref_provinsi.KodeProvinsi','KD_PENGAJUAN',$kd_pengajuan);
		foreach($result2->result() as $row) {
			$data['jabatan']=$row->NAMA_JABATAN;
			$data['alamat']=$row->ALAMAT_USER;
			$data['kode_unit']=$row->KDUNIT;
			$data['kode_jenis_satker']=$row->KodeJenisSatker;
		}
		$option_kode_surat;
		foreach ($this->pm->get('kode_surat')->result() as $row){
			$option_kode_surat[$row->id_kode_surat] = $row->nama_kode_surat;
		}
		$data['kode_surat']=$option_kode_surat;
		$data2['content'] = $this->load->view('e-planning/manajemen/feedback', $data, true);
		$this->load->view('main', $data2);
	}
	
	function save_feedback($perintah,$kd_pengajuan){
		$tanggal=explode('-',$this->input->post('tanggal'));
		$id_user_pengajuan= $this->mm->get_where('pengajuan','KD_PENGAJUAN',$kd_pengajuan)->row()->ID_USER;
		$data=array( 
			'ID_USER'=>$this->session->userdata('id_user'),
			'KODE_SURAT'=>$this->input->post('kode_surat'),
			'NOMOR_FEEDBACK'=>$this->input->post('nomor_surat'),
			'TAHUN_FEEDBACK'=>$this->input->post('tahun_surat'),
			'TANGGAL_FEEDBACK'=> $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0],
			'UMPAN_BALIK'=>$this->input->post('umpan_balik'),
			'KD_PENGAJUAN'=>$kd_pengajuan,
			'ID_USER_PENGAJUAN'=>$id_user_pengajuan
		);
		$this->mm->save('data_feedback',$data);
		if($perintah == 1) redirect('e-planning/manajemen/grid_pengajuan_disetujui');
		else redirect('e-planning/manajemen/grid_pengajuan_ditolak');
	}
	function edit_feedback($perintah,$kd_pengajuan){
		$data['perintah']=$perintah;
		foreach ($this->mm->get_where('data_feedback','KD_PENGAJUAN',$kd_pengajuan)->result() as $row){
			$tanggal = explode('-',$row->TANGGAL_FEEDBACK);
			$data['umpan_balik'] = $row->UMPAN_BALIK;
			$data['nomor_surat'] = $row->NOMOR_FEEDBACK;
			$data['tahun_surat'] = $row->TAHUN_FEEDBACK;
			$data['kode_surat'] = $row->KODE_SURAT;
		}
		$data['tanggal'] = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
		$data['kdsatker']='-';
		$data['provinsi']='-';
		$data['judul']='-';
		$data['tanggal_pengajuan']='-';
		$data['perihal']='-';
		$data['nomor_pengajuan']='-';
		$data['jabatan']='-';
		$data['alamat']='-';
		$data['kode_jenis_satker']='-';
		$data['option_kode_surat']='-';
		$data['kd_pengajuan']=$kd_pengajuan;
		$result = $this->pm->get_data_pengajuan($kd_pengajuan);
		foreach($result->result() as $row){
			$data['kdsatker']=$row->NO_REG_SATKER;
			$data['nmsatker']=$row->nmsatker;
			$data['provinsi']=$row->NamaProvinsi;
			$data['judul']=$row->JUDUL_PROPOSAL;
			$data['tanggal_pengajuan']=$row->TANGGAL_PENGAJUAN;
			$data['perihal']=$row->PERIHAL;
			$data['nomor_pengajuan']=$row->NOMOR_SURAT;
		}
		$result2 = $this->mm->get_where_double_join('pengajuan','users','ID_USER = USER_ID','ref_provinsi','users.KodeProvinsi = ref_provinsi.KodeProvinsi','KD_PENGAJUAN',$kd_pengajuan);
		foreach($result2->result() as $row) {
			$data['jabatan']=$row->NAMA_JABATAN;
			$data['alamat']=$row->ALAMAT_USER;
			$data['kode_jenis_satker']=$row->KodeJenisSatker;
			$data['id_user_pengajuan']=$row->ID_USER;
		}
		$option_kode_surat;
		foreach ($this->pm->get('kode_surat')->result() as $row){
			$option_kode_surat[$row->id_kode_surat] = $row->nama_kode_surat;
		}
		
		foreach($this->mm->get_where_join('data_program','ref_program','data_program.KodeProgram = ref_program.KodeProgram', 'KD_PENGAJUAN',$kd_pengajuan)->result() as $row)
			$data['kode_unit']=$row->KodeUnitOrganisasi;
		
		$data['option_kode_surat']= $option_kode_surat;
		$data2['content'] = $this->load->view('e-planning/manajemen/edit_feedback', $data, true);
		$this->load->view('main', $data2);
	}
	
	function update_feedback($perintah,$kd_pengajuan){
		$tanggal=explode('-',$this->input->post('tanggal'));
		$data3=array( 
			'ID_USER'=>$this->session->userdata('id_user'),
			'NOMOR_FEEDBACK'=>$this->input->post('nomor_surat'),
			'TANGGAL_FEEDBACK'=>$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0],
			'UMPAN_BALIK'=>$this->input->post('umpan_balik'),
			'TAHUN_FEEDBACK'=>$this->input->post('tahun_surat'),
			'KODE_SURAT'=>$this->input->post('kode_surat'),
		);
		$this->mm->update('data_feedback',$data3, 'KD_PENGAJUAN',$kd_pengajuan);
		if($perintah == 1) redirect('e-planning/manajemen/grid_pengajuan_disetujui');
		else redirect('e-planning/manajemen/grid_pengajuan_ditolak');
	}
	function cetak_feedback($kd_pengajuan){
		foreach ($this->mm->get_where('data_feedback','KD_PENGAJUAN',$kd_pengajuan)->result() as $row){
			$tanggal = explode('-',$row->TANGGAL_FEEDBACK);
			$data['umpan_balik'] = $row->UMPAN_BALIK;
			$data['nomor_surat'] = $row->NOMOR_FEEDBACK;
			$data['tahun_surat'] = $row->TAHUN_FEEDBACK;
			$data['kode_surat'] = $row->KODE_SURAT;
		}
		$data['tanggal'] = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
		$data['kdsatker']='-';
		$data['provinsi']='-';
		$data['judul']='-';
		$data['tanggal_pengajuan']='-';
		$data['perihal']='-';
		$data['nomor_pengajuan']='-';
		$data['jabatan']='-';
		$data['alamat']='-';
		$data['kode_jenis_satker']='-';
		$data['option_kode_surat']='-';
		$data['kd_pengajuan']=$kd_pengajuan;
		$result = $this->pm->get_data_pengajuan($kd_pengajuan);
		foreach($result->result() as $row){
			$data['kdsatker']=$row->NO_REG_SATKER;
			$data['nmsatker']=$row->nmsatker;
			$data['provinsi']=$row->NamaProvinsi;
			$data['judul']=$row->JUDUL_PROPOSAL;
			$data['tanggal_pengajuan']=$row->TANGGAL_PENGAJUAN;
			$data['perihal']=$row->PERIHAL;
			$data['nomor_pengajuan']=$row->NOMOR_SURAT;
		}
		$result2 = $this->mm->get_where_double_join('pengajuan','users','ID_USER = USER_ID','ref_provinsi','users.KodeProvinsi = ref_provinsi.KodeProvinsi','KD_PENGAJUAN',$kd_pengajuan);
		foreach($result2->result() as $row) {
			$data['jabatan']=$row->NAMA_JABATAN;
			$data['alamat']=$row->ALAMAT_USER;
			$data['kode_jenis_satker']=$row->KodeJenisSatker;
			$data['id_user_pengajuan']=$row->ID_USER;
		}
		$option_kode_surat;
		foreach ($this->pm->get('kode_surat')->result() as $row){
			$option_kode_surat[$row->id_kode_surat] = $row->nama_kode_surat;
		}
		
		foreach($this->mm->get_where_join('data_program','ref_program','data_program.KodeProgram = ref_program.KodeProgram', 'KD_PENGAJUAN',$kd_pengajuan)->result() as $row)
			$data['kode_unit']=$row->KodeUnitOrganisasi;
		
		$data['option_kode_surat']= $option_kode_surat;
		$this->load->view('e-planning/manajemen/preview_feedback', $data);
	}
	function grid_pengajuan_telah_ditelaah(){		
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['TANGGAL_PENGAJUAN'] = array('Tanggal Proposal',100,TRUE,'center',1);
		$colModel['TANGGAL_TELAAH'] = array('Tanggal Ditelaah',100,TRUE,'center',1);
		$colModel['ID_RENCANA_ANGGARAN'] = array('Sumber Dana',100,TRUE,'center',1);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		$colModel['JUDUL_PROPOSAL'] = array('Judul Proposal',350,TRUE,'left',1);
		$colModel['NILAI PROPOSAL'] = array('Nilai Proposal',100,TRUE,'center',1);
		$colModel['CETAK'] = array('Cetak',100,TRUE,'center',0);
			
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
			'noWrap' => false
		);
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/manajemen/grid_list_pengajuan_telah_ditelaah";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/e-planning/utility/cetak_pengusulan\" method=\"POST\">
					<button type=\"submit\" class=\"positive\" name=\"cetak\">
						<img src=\"".base_url()."images/main/excel.png\" alt=\"\"/>
						Cetak Semua
					</button>
					</form>
				</div>";
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
		$data['js_grid'] = $grid_js;
		$data['e_planning'] = "";
		$data['judul'] = 'Proposal Telah Ditelaah';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	 //mengambil data user di tabel login
	function grid_list_pengajuan_telah_ditelaah(){
		$valid_fields = array('NO_REG_SATKER','JUDUL_PROPOSAL','TANGGAL_PENGAJUAN','TANGGAL_PERSETUJUAN');
		$this->flexigrid->validate_post('JUDUL_PROPOSAL','asc',$valid_fields);
		if($this->session->userdata('kd_role') == Role_model::PENGUSUL)
			$records = $this->mm->get_data_telah_ditelaah();
		elseif($this->session->userdata('kodejenissatker') == 2 && $this->session->userdata('kd_role') == Role_model::VERIFIKATOR)
			$records = $this->mm->get_data_telah_ditelaah_dekon();
		elseif($this->session->userdata('kodejenissatker') == 3 && $this->session->userdata('kd_role') == Role_model::VERIFIKATOR)
			$records = $this->mm->get_data_telah_ditelaah_unit_utama();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$tanggal_pengajuan = explode('-', $row->TANGGAL_PENGAJUAN);
			$tanggal_telaah = explode('-', $row->TANGGAL_PERSETUJUAN);
			
			$no = $no+1;
			$record_items[] = array(
				$row->TANGGAL_PENGAJUAN,
				$no,
				$tanggal_pengajuan[2].'-'.$tanggal_pengajuan[1].'-'.$tanggal_pengajuan[0],
				$tanggal_telaah[2].'-'.$tanggal_telaah[1].'-'.$tanggal_telaah[0],
				$row->rencana_anggaran,
				'<a href='.site_url().'/e-planning/manajemen/detail_pengajuan/'.$row->KD_PENGAJUAN.'/1><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				$row->JUDUL_PROPOSAL,
				'Rp '.number_format($this->mm->sum('aktivitas','Jumlah', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)),
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/utility/cetak_rab/'.$row->KD_PENGAJUAN.'><img border=\'0\' src=\''.base_url().'images/main/excel.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function koreksi($kdpengajuan){
		$data = array("STATUS_KOREKSI" => 0);
		$this->mm->update('pengajuan', $data, 'KD_PENGAJUAN', $kdpengajuan);
		redirect("e-planning/manajemen/grid_pengajuan");
	}
}

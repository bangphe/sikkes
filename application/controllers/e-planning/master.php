<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->helper('url');
		$this->load->library('Spreadsheet_Excel_Reader');
		$this->load->helper('form');
		$this->load->model('e-planning/master_model','masmo');
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
	function addVisi($idPeriode){
		$data['idPeriode']=$idPeriode;
		$data['periode']='-';
		foreach($this->masmo->get_where('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$optionVisi['0']='-- Pilih Visi --';
		foreach($this->masmo->get('ref_visi')->result() as $row){
			$optionVisi[$row->idVisi]=$row->Visi;
		}
		$data['judul'] = 'Tambah Visi';
		$data['visi']=$optionVisi;
		$this->load->view('e-planning/master/tambah_visi',$data);
	}
	
	function saveVisi(){
		$data=array(
			'idVisi'=>$_POST['idVisi'],
			'idPeriode'=>$_POST['idPeriode']
		);
		$this->masmo->save('data_visi',$data);
	}
	
	function loadUpdateVisi($idVisi,$idPeriode){
		$data['visi_terpilih']=$idVisi;
		$data['periode']='';
		$data['idPeriode']=$idPeriode;
		foreach($this->masmo->get_where('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$option_visi['0'] = '-- Pilih Visi --';
		foreach ($this->masmo->get('ref_visi')->result() as $row){
			$option_visi[$row->idVisi] = $row->Visi;
		}
		$data['judul']='Update Visi';
		$data['visi'] = $option_visi;
		$data2['content'] = $this->load->view('e-planning/master/update_visi',$data);
	}
	
	function updateVisi($idVisiAwal){
		$data=array(
			'idVisi'=>$_POST['idVisi'],
			'idPeriode'=>$_POST['idPeriode']
		);
		$this->masmo->update('data_visi', $data, 'idVisi', $idVisiAwal, 'idPeriode', $_POST['idPeriode']);
	}
	
	function deleteVisi($idPeriode, $idVisi){
		$this->masmo->delete('data_visi', 'idVisi', $idVisi, 'idPeriode', $idPeriode);
		redirect('e-planning/referensi/grid_visi/'.$idPeriode);
	}
	
	function addMisi($idPeriode){
		$data['idPeriode']=$idPeriode;
		$data['periode']='-';
		foreach($this->masmo->get('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$optionMisi['0']='-- Pilih Misi --';
		foreach($this->masmo->get('ref_misi')->result() as $row){
			$optionMisi[$row->idMisi]=$row->Misi;
		}
		$data['judul'] = 'Tambah Misi';
		$data['misi']=$optionMisi;
		$this->load->view('e-planning/master/tambah_misi',$data);
	}
	
	function saveMisi(){
		$data=array(
			'idMisi'=>$_POST['idMisi'],
			'idPeriode'=>$_POST['idPeriode']
		);
		$this->masmo->save('data_misi',$data);
	}
	
	function loadUpdateMisi($idMisi,$idPeriode){
		$data['misi_terpilih']=$idMisi;
		$data['periode']='';
		$data['idPeriode']=$idPeriode;
		foreach($this->masmo->get_where('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$option_misi['0'] = '-- Pilih Misi --';
		foreach ($this->masmo->get('ref_misi')->result() as $row){
			$option_misi[$row->idMisi] = $row->Misi;
		}
		$data['judul']='Update Misi';
		$data['misi'] = $option_misi;
		$data2['content'] = $this->load->view('e-planning/master/update_misi',$data);
	}
	
	function updateMisi($idMisiAwal){
		$data=array(
			'idMisi'=>$_POST['idMisi'],
			'idPeriode'=>$_POST['idPeriode']
		);
		$this->masmo->update('data_misi', $data, 'idMisi', $idMisiAwal, 'idPeriode', $_POST['idPeriode']);
	}
	
	function deleteMisi($idPeriode, $idMisi){
		$this->masmo->delete('data_misi', 'idMisi', $idMisi, 'idPeriode', $idPeriode);
		redirect('e-planning/referensi/grid_misi/'.$idPeriode);
	}
	
	function addTujuan($idPeriode){
		$data['idPeriode']=$idPeriode;
		$data['periode']='-';
		foreach($this->masmo->get('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$optionTujuan['0']='-- Pilih Tujuan --';
		foreach($this->masmo->get('ref_tujuan')->result() as $row){
			$optionTujuan[$row->idTujuan]=$row->Tujuan;
		}
		$data['judul'] = 'Tambah Tujuan';
		$data['tujuan']=$optionTujuan;
		$this->load->view('e-planning/master/tambah_tujuan',$data);
	}
	
	function saveTujuan(){
		$data=array(
			'idTujuan'=>$_POST['idTujuan'],
			'idPeriode'=>$_POST['idPeriode']
		);
		$this->masmo->save('data_tujuan',$data);
	}
	
	function loadUpdateTujuan($idTujuan,$idPeriode){
		$data['tujuan_terpilih']=$idTujuan;
		$data['periode']='';
		$data['idPeriode']=$idPeriode;
		foreach($this->masmo->get_where('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$option_tujuan['0'] = '-- Pilih Tujuan --';
		foreach($this->masmo->get('ref_tujuan')->result() as $row){
			$option_tujuan[$row->idTujuan] = $row->Tujuan;
		}
		$data['judul']='Update Tujuan';
		$data['tujuan'] = $option_tujuan;
		$data2['content'] = $this->load->view('e-planning/master/update_tujuan',$data);
	}
	
	function updateTujuan($idTujuanAwal){
		$data=array(
			'idTujuan'=>$_POST['idTujuan'],
			'idPeriode'=>$_POST['idPeriode']
		);
		$this->masmo->update('data_tujuan', $data, 'idTujuan', $idTujuanAwal, 'idPeriode', $_POST['idPeriode']);
	}
	
	function deleteTujuan($idPeriode, $idTujuan){
		$this->masmo->delete('data_tujuan', 'idTujuan', $idTujuan, 'idPeriode', $idPeriode);
		redirect('e-planning/referensi/grid_tujuan/'.$idPeriode);
	}
	
	function addSasaranStrategis_referensi(){
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['judul'] = 'Tambah Sasaran';
		$this->load->view('e-planning/master/tambah_sasaran_strategis',$data);
	}
	
	function addSasaranStrategis($idPeriode){
		$data['idPeriode']=$idPeriode;
		$data['periode']='-';
		foreach($this->masmo->get('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$optionSasaran['0']='-- Pilih Sasaran Strategis --';
		foreach($this->masmo->get('ref_sasaran_strategis')->result() as $row){
			$optionSasaran[$row->idSasaran]=$row->sasaran_strategis;
		}
		$data['judul'] = 'Tambah Sasaran Strategis';
		$data['sasaran']=$optionSasaran;
		$this->load->view('e-planning/master/tambah_sasaran_strategis',$data);
	}
	
	//validasi
	function validasi_sasaran(){
		$config = array(
			array('field'=>'sasaran','label'=>'Sasaran Strategis', 'rules'=>'required')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');

		return $this->form_validation->run();
	}
	
	function saveSasaranStrategis_referensi(){
		if($this->validasi_sasaran() == TRUE){
			$data=array(
				'idPeriode'=>$_POST['idPeriode'],
				'sasaran_strategis'=>$_POST['sasaran'],
				'kdsatker'=>$this->session->userdata('kdsatker')
			);
			$this->masmo->save('ref_sasaran_strategis',$data);
		}
		else
			redirect('');
	}
	
	function saveSasaranStrategis(){
		$data=array(
			'idPeriode'=>$_POST['idPeriode'],
			'idSasaran'=>$_POST['idSasaran']
		);
		$this->masmo->save('data_sasaran_strategis',$data);
	}
	
	function detailSasaranStrategis($idSasaran){
		$data['idSasaran']='-';
		$data['Sasaran']='-';
		foreach($this->masmo->get_where('ref_sasaran_strategis','idSasaran',$idSasaran)->result() as $row){
			$data['idVisi']=$row->idVisi;
			$data['Visi']=$row->Visi;
		}
		$data['content']=$this->load->view('e-planning/master/detail_sasaran_strategis',$data,true);
		$data2=$this->load->view('main',$data2);
	}
	
	function loadUpdateSasaranStrategis($idSasaran,$idPeriode){
		$data['sasaran_terpilih']=$idSasaran;
		$data['periode']='';
		$data['idPeriode']=$idPeriode;
		foreach($this->masmo->get_where('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$option_sasaran['0'] = '-- Pilih Sasaran Strategis --';
		foreach ($this->masmo->get('ref_sasaran_strategis')->result() as $row){
			$option_sasaran[$row->idSasaran] = $row->sasaran_strategis;
		}
		$data['judul']='Update Sasaran Strategis';
		$data['sasaran'] = $option_sasaran;
		$data2['content'] = $this->load->view('e-planning/master/update_sasaran_strategis',$data);
	}
	
	function loadUpdateSasaranStrategis_referensi($idSasaran){
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['sasaran']='';
		$data['idSasaran']=$idSasaran;
		$data['selected_periode']='';
		foreach($this->masmo->get_where('ref_sasaran_strategis','idsasaran',$idSasaran)->result() as $row){
			$data['sasaran']=$row->sasaran_strategis;
			$data['selected_periode']=$row->idPeriode;
		}
		$data['judul']='Update Sasaran';
		$data2['content'] = $this->load->view('e-planning/master/update_sasaran_strategis',$data);
	}
	
	function updateSasaranStrategis_referensi($idSasaran){
		$data=array(
			'idPeriode'=>$_POST['periode'],
			'sasaran_strategis'=>$_POST['sasaran']
		);
		$this->masmo->update('ref_sasaran_strategis', $data, 'idSasaran', $idSasaran);
	}
	
	function updateSasaranStrategis($idSasaranAwal){
		$data=array(
			'idSasaran'=>$_POST['idSasaran'],
			'idPeriode'=>$_POST['idPeriode']
		);
		$this->masmo->update('data_sasaran_strategis', $data, 'idSasaran', $idSasaranAwal, 'idPeriode', $_POST['idPeriode']);
	}
	
	function deleteSasaranStrategis($idPeriode, $idSasaran){
		$this->masmo->delete('data_sasaran_strategis', 'idSasaran', $idSasaran, 'idPeriode', $idPeriode);
		redirect('e-planning/referensi2/grid_sasaran/'.$idPeriode);
	}
	
	function addTahunAnggaran(){
		$data['content'] = $this->load->view('e-planning/master/tambah_thn_anggaran','',true);
		$this->load->view('main,$data');
	}
	
	function saveTahunAnggaran(){
		$data=array(
			'thn_anggaran'=>$this->input->post($this->input->post('thn_anggaran'))
		);
		$this->masmo->save('tahun_anggaran',$data);
	}
	
	function detailTahungAnggaran($idThnAggaran){
		$data['idTahunAnggaran']='-';
		$data['thn_anggaran']='-';
		foreach($this->masmo->get_where('ref_tahun_anggaran','idTahunAnggaran',$idTahunAnggaran)->result() as $row){
			$data['idTahunAnggaran']=$row->idTahunAnggaran;
			$data['thn_anggaran']=$row->thn_anggaran;
		}
		$data['content']=$this->load->view('e-planning/master/detail_thn_anggaran',$data,true);
		$data2=$this->load->view('main',$data2);
	}
	
	function loadUpdateTahunAnggaran($tahun_anggaran){
		$result->$this->masmo->get('tahun_anggaran','thn_anggaran',$thn_anggaran);
		$data['thn_anggaran']='';
		foreach($result->result() as $row){
			$data['thn_anggaran']=$row->thn_anggaran;
		}
		$data2['content'] = $this->load->view('e-planning/master/update_sasaran_strategis',$data,true);
		$this->load->view('main',$data2);
	}
	
	function updateTahunAnggaran($thn_anggaranAwal){
		$data=array(
			'thn_anggaran'=>$this->input->post('thn_anggaran')
		);
		$this->masmo->update('tahun_anggaran', $data, 'thn_anggaran', $thn_anggaranAwal);
	}
	
	function deleteTahunAnggaran($thn_anggaran){
		$this->masmo->delete('tahun_anggaran', 'thn_anggaran', $thn_anggaran);
	}
	
	function addPeriode(){
		$this->load->view('e-planning/master/tambah_periode');
	}
	
	function savePeriode(){
		$data=array(
			'periode_awal'=>$_POST['periode_awal'],
			'periode_akhir'=>$_POST['periode_akhir']
		);
		$this->masmo->save('ref_periode',$data);
	}
	
	function detailPeriode($idPeriode){
		$data['idPeriode']='-';
		$data['periode']='-';
		foreach($this->masmo->get_where('ref_tahun_anggaran','idTahunAnggaran',$idTahunAnggaran)->result() as $row){
			$data['idPeriode']=$row->idPeriode;
			$data['periode']=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['content']=$this->load->view('e-planning/master/detail_periode',$data,true);
		$data2=$this->load->view('main',$data2);
	}

	function loadUpdatePeriode($idPeriode){
		$data['judul']='Update Periode';
		$data['idPeriode']=$idPeriode;
		$result=$this->masmo->get_where('ref_periode','idPeriode',$idPeriode);
		$data['selected_periode_awal']='';
		$data['selected_periode_akhir']='';
		foreach($result->result() as $row){
			$data['selected_periode_awal']=$row->periode_awal;
			$data['selected_periode_akhir']=$row->periode_akhir;
		}
		$this->load->view('e-planning/master/update_periode',$data);
	}
	
	function updatePeriode($idPeriode){
		$data=array(
			'periode_awal'=>$_POST['periode_awal'],
			'periode_akhir'=>$_POST['periode_akhir']
		);
		$this->masmo->update('ref_periode', $data, 'idPeriode', $idPeriode);
	}
	
	function deletePeriode($idPeriode){
		$this->masmo->delete('data_sasaran_strategis', 'idPeriode', $idPeriode);
		$this->masmo->delete('data_visi', 'idPeriode', $idPeriode);
		$this->masmo->delete('data_misi', 'idPeriode', $idPeriode);
		$this->masmo->delete('data_tujuan', 'idPeriode', $idPeriode);
		$this->masmo->delete('ref_periode', 'idPeriode', $idPeriode);
		redirect('e-planning/referensi/grid_periode');
	}
	
	//tabel referensi
	function addPeriode_referensi(){
		$data['judul'] = 'Tambah Periode';
		$this->load->view('e-planning/referensi/tambah_periode',$data);
	}
	
	function savePeriode_referensi(){
		$data=array(
			'periode_awal'=>$_POST['periode_awal'],
			'periode_akhir'=>$_POST['periode_akhir']
		);
		$this->masmo->save('ref_periode',$data);
	}
	
	function loadUpdatePeriode_referensi($idPeriode){
		$data['periode_awal']='';
		$data['periode_akhir']='';
		$data['idPeriode']=$idPeriode;
		foreach($this->masmo->get_where('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$data['periode_awal']=$row->periode_awal;
			$data['periode_akhir']=$row->periode_akhir;
		}
		$data['judul']='Update Periode';
		$data2['content'] = $this->load->view('e-planning/referensi/update_periode',$data);
	}
	
	function updatePeriode_referensi($idPeriode){
		$data=array(
			'periode_awal'=>$_POST['periode_awal'],
			'periode_akhir'=>$_POST['periode_akhir']
		);
		$this->masmo->update('ref_periode', $data, 'idPeriode', $idPeriode);
	}
	
	function deletePeriode_referensi($idPeriode){
		$this->masmo->delete('ref_periode', 'idPeriode', $idPeriode);
		redirect('e-planning/referensi2/grid_periode');
	}
	
	function addVisi_referensi(){
		$option_periode;
		$option_periode['0'] = '--- Pilih Periode ---';
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['tahun'] = $this->masmo->get('ref_tahun_anggaran');
		$data['judul'] = 'Tambah Visi';
		//$this->load->view('e-planning/referensi/tambah_visi',$data);
		$this->load->view('e-planning/referensi/tambah_visi',$data);
	}
	
	//validasi
	function validasi_visi(){
		$config = array(
			array('field'=>'Visi','label'=>'Visi', 'rules'=>'required')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');

		return $this->form_validation->run();
	}
	
	function saveVisi_referensi(){
		// $cek = $this->masmo->get_where2('ref_visi', 'kdsatker', $this->session->userdata('kdsatker'), 'idPeriode', $_POST['periode']);
		// if($this->validasi_visi() == FALSE){
		// 	redirect('');
		// }
		// elseif($cek->num_rows() > 0)
		// 	redirect('');
		// else{
		// 	$data=array(
		// 		'kdsatker'=>$this->session->userdata('kdsatker'),
		// 		'idPeriode'=>$_POST['periode'],
		// 		'idThnAnggaran'=>$_POST['tahun'],
		// 		'Visi'=>$_POST['Visi']
		// 	);
		// 	$this->masmo->save('ref_visi',$data);
		// }
		$data=array(
			'kdsatker'=>$this->session->userdata('kdsatker'),
			'idPeriode'=>$_POST['periode'],
			'idThnAnggaran'=>$_POST['tahun'],
			'Visi'=>$_POST['Visi']
		);
		$this->masmo->save('ref_visi',$data);
	}
	
	function loadUpdateVisi_referensi($idVisi){
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$option_tahun;
		foreach($this->masmo->get('ref_tahun_anggaran')->result() as $row){
			$option_tahun[$row->idThnAnggaran] = $row->thn_anggaran;
		}
		$data['periode'] = $option_periode;
		$data['tahun'] = $option_tahun;
		$data['visi']='';
		$data['idVisi']=$idVisi;
		$data['selected_periode']='';
		foreach($this->masmo->get_where('ref_visi','idVisi',$idVisi)->result() as $row){
			$data['visi']=$row->Visi;
			$data['selected_periode']=$row->idPeriode;
			$data['selected_tahun']=$row->idThnAnggaran;
		}
		$data['judul']='Update Visi';
		$data2['content'] = $this->load->view('e-planning/referensi/update_visi',$data);
	}
	
	function updateVisi_referensi($idVisi){
		$data=array(
			'Visi'=>$_POST['Visi'],
			'idThnAnggaran'=>$_POST['tahun'],
			'idPeriode'=>$_POST['periode'],
		);
		$this->masmo->update('ref_visi', $data, 'idVisi', $idVisi);
	}
	
	function deleteVisi_referensi($idVisi){
		$this->masmo->delete('ref_visi', 'idVisi', $idVisi);
		redirect('e-planning/referensi2/grid_visi');
	}
	
	function addMisi_referensi(){
		$option_periode;
		$option_periode['0'] = '--- Pilih Periode ---';
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['tahun'] = $this->masmo->get('ref_tahun_anggaran');
		$data['judul'] = 'Tambah Misi';
		$this->load->view('e-planning/referensi/tambah_misi',$data);
	}
	
	//validasi
	function validasi_misi(){
		$config = array(
			array('field'=>'Misi','label'=>'Misi', 'rules'=>'required')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');

		return $this->form_validation->run();
	}
	
	function saveMisi_referensi(){
		// if($this->validasi_misi() == FALSE){
		// 	redirect('');
		// }
		//else{
			$data=array(
				'kdsatker'=>$this->session->userdata('kdsatker'),
				'idPeriode'=>$_POST['periode'],
				'idThnAnggaran'=>$_POST['tahun'],
				'Misi'=>$_POST['Misi'],
			);
			$this->masmo->save('ref_misi',$data);
		//}
	}
	
	function loadUpdateMisi_referensi($idMisi){
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$option_tahun;
		foreach($this->masmo->get('ref_tahun_anggaran')->result() as $row){
			$option_tahun[$row->idThnAnggaran] = $row->thn_anggaran;
		}
		$data['periode'] = $option_periode;
		$data['tahun'] = $option_tahun;
		$data['misi']='';
		$data['idMisi']=$idMisi;
		$data['selected_periode'] = '';
		foreach($this->masmo->get_where('ref_misi','idMisi',$idMisi)->result() as $row){
			$data['misi']=$row->Misi;
			$data['selected_periode'] = $row->idPeriode;
			$data['selected_tahun']=$row->idThnAnggaran;
		}
		$data['judul']='Update Misi';
		$data2['content'] = $this->load->view('e-planning/referensi/update_misi',$data);
	}
	
	function updateMisi_referensi(){
		$data=array(
			'Misi'=>$_POST['Misi'],
			'idPeriode'=>$_POST['periode'],
			'idThnAnggaran'=>$_POST['tahun']
		);
		$this->masmo->update('ref_misi', $data, 'idMisi', $_POST['idMisi']);
	}
	
	function deleteMisi_referensi($idMisi){
		$this->masmo->delete('ref_misi', 'idMisi', $idMisi);
		redirect('e-planning/referensi2/grid_misi');
	}
	
	function addTujuan_referensi(){
		$data['judul'] = 'Tambah Tujuan';
		$this->load->view('e-planning/referensi/tambah_tujuan',$data);
	}
	
	function saveTujuan_referensi(){
		$data=array(
			'Tujuan'=>$_POST['Tujuan']
		);
		$this->masmo->save('ref_tujuan',$data);
	}
	
	function loadUpdateTujuan_referensi($idTujuan){
		$data['tujuan']='';
		$data['idTujuan']=$idTujuan;
		foreach($this->masmo->get_where('ref_tujuan','idTujuan',$idTujuan)->result() as $row){
			$data['tujuan']=$row->Tujuan;
		}
		$data['judul']='Update Tujuan';
		$data2['content'] = $this->load->view('e-planning/referensi/update_tujuan',$data);
	}
	
	function updateTujuan_referensi($idTujuan){
		$data=array(
			'Tujuan'=>$_POST['Tujuan']
		);
		$this->masmo->update('ref_tujuan', $data, 'idTujuan', $_POST['idTujuan']);
	}
	
	function deleteTujuan_referensi($idTujuan){
		$this->masmo->delete('ref_tujuan', 'idTujuan', $idTujuan);
		redirect('e-planning/referensi2/grid_tujuan');
	}
	
	function addSasaran_referensi(){
		$data['judul'] = 'Tambah Sasaran Strategis';
		$this->load->view('e-planning/referensi/tambah_sasaran_strategis',$data);
	}
	
	function saveSasaran_referensi(){
		$data=array(
			'sasaran_strategis'=>$_POST['sasaran_strategis']
		);
		$this->masmo->save('ref_sasaran_strategis',$data);
	}
	
	function loadUpdateSasaran_referensi($idSasaran){
		$data['sasaran_strategis']='';
		$data['idSasaran']=$idSasaran;
		foreach($this->masmo->get_where('ref_sasaran_strategis','idSasaran',$idSasaran)->result() as $row){
			$data['sasaran_strategis']=$row->sasaran_strategis;
		}
		$data['judul']='Update Sasaran Strategis';
		$data2['content'] = $this->load->view('e-planning/referensi/update_sasaran_strategis',$data);
	}
	
	function updateSasaran_referensi($idSasaran){
		$data=array(
			'sasaran_strategis'=>$_POST['sasaran_strategis']
		);
		$this->masmo->update('ref_sasaran_strategis', $data, 'idSasaran', $_POST['idSasaran']);
	}
	
	function deleteSasaran_referensi($idSasaran){
		$this->masmo->delete('ref_sasaran_strategis', 'idSasaran', $idSasaran);
		redirect('e-planning/referensi2/grid_sasaran');
	}
	
	function grid_satker(){
		//$this->cek_session();
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['kdsatker'] = array('Kode Satker',100,TRUE,'center',1);
		$colModel['nmsatker'] = array('Satker',400,TRUE,'left',1);
		$colModel['NamaProvinsi'] = array('Provinsi',150,TRUE,'left',1);
		$colModel['NamaKabupaten'] = array('Kabupaten',150,TRUE,'left',1);
		$colModel['status'] = array('Status',100,TRUE,'center',1);
		$colModel['edit'] = array('Edit',100,TRUE,'center',1);
			
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
				
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/master/list_satker";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
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
		$data['judul'] = 'Kemampuan Satker';
		$data['manajemen_pengguna'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function list_satker(){
		$valid_fields = array('kdsatker','nmsatker','NamaProvinsi','NamaKabupaten','STATUS');
		$this->flexigrid->validate_post('kdsatker','asc',$valid_fields);
		$records = $this->masmo->get_satker();
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			
			//cek program per satker
			$cek_program = $this->masmo->cek_satker_program_per_satker($row->kdsatker);
			$cek_kegiatan = $this->masmo->cek_satker_kegiatan_per_satker($row->kdsatker);
			if ($cek_program->num_rows() > 0) {
				$status = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>';
			}
			else {
				$status = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
			}

			$record_items[] = array(			
				$row->kdsatker,
				$no,
				$row->kdsatker,
				$row->nmsatker,
				$row->NamaProvinsi,
				$row->NamaKabupaten,
				$status,
				'<a href='.site_url().'/e-planning/master/kemampuan_satker/'.$row->kdsatker.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>'
			);
		}
		// foreach ($records2['records']->result() as $row){
			// $no = $no+1;
			// $record_items[] = array(
				// $row->kdsatker,
				// $no,
				// // $row->kdsatker,
				// $row->nmsatker,
				// $row->NamaProvinsi,
				// $row->NamaKabupaten,
				// '<a href='.site_url().'/e-planning/master/kemampuan_satker/'.$row->kdsatker.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>'
			// );
		// }
		// foreach ($records3['records']->result() as $row){
			// $no = $no+1;
			// $record_items[] = array(
				// $row->kdsatker,
				// $no,
				// // $row->kdsatker,
				// $row->nmsatker,
				// $row->NamaProvinsi,
				// $row->NamaKabupaten,
				// '<a href='.site_url().'/e-planning/master/kemampuan_satker/'.$row->kdsatker.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>'
			// );
		// }
		// foreach ($records4['records']->result() as $row){
			// $no = $no+1;
			// $record_items[] = array(
				// $row->kdsatker,
				// $no,
				// // $row->kdsatker,
				// $row->nmsatker,
				// $row->NamaProvinsi,
				// $row->NamaKabupaten,
				// '<a href='.site_url().'/e-planning/master/kemampuan_satker/'.$row->kdsatker.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>'
			// );
		// }
		// foreach ($records5['records']->result() as $row){
			// $no = $no+1;
			// $record_items[] = array(
				// $row->kdsatker,
				// $no,
				// // $row->kdsatker,
				// $row->nmsatker,
				// $row->NamaProvinsi,
				// $row->NamaKabupaten,
				// '<a href='.site_url().'/e-planning/master/kemampuan_satker/'.$row->kdsatker.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>'
			// );
		// }
		$rec_count = $records['record_count'];//+$records2['record_count']+$records3['record_count']+$records4['record_count']+$records5['record_count'];
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($rec_count,$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function kemampuan_satker($kdsatker){
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
		$data['title'] = 'Edit Satker - '.$this->masmo->get_where('ref_satker','kdsatker',$kdsatker)->row()->nmsatker.' (Kode Unit: '.$this->masmo->get_where('ref_satker','kdsatker',$kdsatker)->row()->kdunit.')';
		$data['kdsatker'] = $kdsatker;
		$data['manajemen_pengguna'] = "";
		$data['program'] = $this->masmo->get('ref_program');
		$data2['content'] = $this->load->view('e-planning/master/kemampuan_satker',$data,true);
		$this->load->view('main',$data2);	
	}
	
	function save_satker($kdsatker){
		$KodeProgram = $this->input->post('program');
		$KodeKegiatan = $this->input->post('kegiatan');
		$KodeIku = $this->input->post('iku');
		$KodeIkk = $this->input->post('ikk');
		$this->masmo->delete('ref_satker_program', 'kdsatker', $kdsatker);
		if($KodeProgram[0] != Null){
			for($i=0; $i<count($KodeProgram); $i++){			
				$data_prog = array(
					'kdsatker' => $kdsatker,
					'KodeProgram' => $KodeProgram[$i]
				);
				$this->masmo->save('ref_satker_program', $data_prog);
			}
		}
		$this->masmo->delete('ref_satker_kegiatan', 'kdsatker', $kdsatker);
		if($KodeKegiatan[0] != Null){
			for($i=0; $i<count($KodeKegiatan); $i++){
				$data_keg = array(
					'kdsatker' => $kdsatker,
					'KodeKegiatan' => $KodeKegiatan[$i]
				);
				$this->masmo->save('ref_satker_kegiatan', $data_keg);
			}
		}
		$this->masmo->delete('ref_satker_iku', 'kdsatker', $kdsatker);
		if($KodeIku[0] != Null){
			for($i=0; $i<count($KodeIku); $i++){
				$data_iku = array(
					'kdsatker' => $kdsatker,
					'KodeIku' => $KodeIku[$i]
				);
				$this->masmo->save('ref_satker_iku', $data_iku);
			}
		}
		$this->masmo->delete('ref_satker_ikk', 'kdsatker', $kdsatker);
		if($KodeIkk[0] != Null){
			for($i=0; $i<count($KodeIkk); $i++){
				$data_ikk = array(
					'kdsatker' => $kdsatker,
					'KodeIkk' => $KodeIkk[$i]
				);
				$this->masmo->save('ref_satker_ikk', $data_ikk);
			}
		}
		redirect('e-planning/master/grid_satker');
	}
	
	function grid_satker_tupoksi(){
		//$this->cek_session();
		$colModel['no'] = array('No',50,TRUE,'center',1);
		$colModel['nmsatker'] = array('Satker',700,TRUE,'left',1);
		$colModel['NamaProvinsi'] = array('Provinsi',150,TRUE,'left',1);
		$colModel['NamaKabupaten'] = array('Kabupaten',150,TRUE,'left',1);
		$colModel['edit'] = array('Edit',100,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'SATKER',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
				
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/master/list_satker_tupoksi";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['master_data'] = "";
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
		$data['judul'] = 'Daftar Satker';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function list_satker_tupoksi(){
		$valid_fields = array('nmsatker','NamaProvinsi','NamaKabupaten');
		$this->flexigrid->validate_post('nmsatker','asc',$valid_fields);
		$records = $this->masmo->get_satker();
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->nmsatker,
				$row->NamaProvinsi,
				$row->NamaKabupaten,
				'<a href='.site_url().'/e-planning/master/grid_tupoksi/'.$row->kdsatker.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function grid_tupoksi($kdsatker){
		//$this->cek_session();
		$colModel['no'] = array('No',50,TRUE,'center',0);
		$colModel['periode'] = array('Periode',80,TRUE,'center',1);
		$colModel['tahun'] = array('Tahun',80,TRUE,'center',1);
		$colModel['Tupoksi'] = array('Tupoksi',680,TRUE,'left',1);
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$colModel['edit'] = array('Edit',80,TRUE,'center',0);
		$colModel['delete'] = array('Delete',80,TRUE,'center',0);
		}
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
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/master/list_tupoksi/".$kdsatker;
		
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		}
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/e-planning/master/tambah_tupoksi/".$kdsatker."';
			}			
		} </script>";
		$data['master_data'] = "";
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
		$data['judul'] = 'Daftar Tupoksi';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	//mengambil data user di tabel login
	function list_tupoksi($kdsatker){
		$valid_fields = array('Tupoksi');
		$this->flexigrid->validate_post('Tupoksi','asc',$valid_fields);
		$records = $this->masmo->get_tupoksi($kdsatker);
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->periode_awal.'-'.$row->periode_akhir,
				$row->thn_anggaran,
				$row->Tupoksi,
				'<a href='.site_url().'/e-planning/master/editTupoksi/'.$row->kdsatker.'/'.$row->KodeTupoksi.' ><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.site_url().'/e-planning/master/deleteTupoksi/'.$row->kdsatker.'/'.$row->KodeTupoksi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function deleteTupoksi($kdsatker,$kdTupoksi){
		$this->masmo->delete_double_parameter('ref_tupoksi', 'kdsatker', $kdsatker, 'KodeTupoksi', $kdTupoksi);
		redirect('e-planning/master/grid_tupoksi/'.$kdsatker);
	}
	
	function tambah_tupoksi($kdsatker){
		$option_periode;
		$option_periode['0'] = '--- Pilih Periode ---';
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['tahun'] = $this->masmo->get('ref_tahun_anggaran');
		$data['master_data'] = "";
		$data['judul'] = 'Tupoksi';
		$data['kdsatker'] = $kdsatker;
		$data2['content'] = $this->load->view('e-planning/master/tambah_tupoksi',$data,true);
		$this->load->view('main',$data2);
	}
	
	function proses_tupoksi($kdsatker){
		if($this->validasi_tupoksi()==FALSE){
			$this->tambah_tupoksi($kdsatker);
		}else{
			$data = array(
				'kdsatker' => $kdsatker,
				'idPeriode' => $_POST['periode'],
				'idThnAnggaran' => $_POST['tahun'],
				'Tupoksi' => $this->input->post('no_tupoksi').'. '.$this->input->post('tupoksi')
			);
			$this->masmo->save('ref_tupoksi', $data);
			redirect('e-planning/master/grid_tupoksi/'.$kdsatker);
		}
	}
	function editTupoksi($kdsatker, $KodeTupoksi){
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$option_tahun;
		foreach($this->masmo->get('ref_tahun_anggaran')->result() as $row){
			$option_tahun[$row->idThnAnggaran] = $row->thn_anggaran;
		}
		$data['periode'] = $option_periode;
		$data['tahun'] = $option_tahun;
		$data['selected_periode'] = '';
		foreach($this->masmo->get_where2('ref_tupoksi', 'KodeTupoksi', $KodeTupoksi, 'kdsatker', $kdsatker)->result() as $row){
			$data['tupoksi'] = $row->Tupoksi;
			$data['selected_periode'] = $row->idPeriode;
			$data['selected_tahun']=$row->idThnAnggaran;
		}

		//$tupoksi = $this->masmo->get_where2('ref_tupoksi', 'KodeTupoksi', $KodeTupoksi, 'kdsatker', $kdsatker)->row()->Tupoksi;
		$data['master_data'] = "";
		$data['judul'] = 'Tupoksi';
		$data['kdsatker'] = $kdsatker;
		$data['KodeTupoksi'] = $KodeTupoksi;
		$data2['content'] = $this->load->view('e-planning/master/edit_tupoksi',$data,true);
		$this->load->view('main',$data2);
	}
	
	function update_tupoksi($kdsatker, $KodeTupoksi){
		if($this->validasi_tupoksi()==FALSE){
			$this->tambah_tupoksi($kdsatker);
		}else{
			$data = array(
				'idPeriode' =>$this->input->post('periode'),
				'idThnAnggaran' =>$this->input->post('tahun'),
				'Tupoksi' =>$this->input->post('tupoksi')
			);
			$this->masmo->update_double_parameter('ref_tupoksi', $data, 'KodeTupoksi', $KodeTupoksi, 'kdsatker', $kdsatker);
			redirect('e-planning/master/grid_tupoksi/'.$kdsatker);
		}
	}
	
	function validasi_tupoksi(){
		$config = array(
			array('field'=>'tupoksi','label'=>'Tupoksi', 'rules'=>'required')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');

		return $this->form_validation->run();
	}
}

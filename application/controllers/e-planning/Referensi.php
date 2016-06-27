<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referensi extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/referensi_model','refmo');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	function loadReferensi($pilihan){
		if($pilihan=='visi') $data['content']=$this->load->view('e-planning/referensi/visi',$data,true);
		else if($pilihan=='misi') $data['content']=$this->load->view('e-planning/referensi/misi',$data,true);
		else if($pilihan=='tujuan') $data['content']=$this->load->view('e-planning/referensi/tujuan',$data,true);
		else if($pilihan=="sasaran") $data['content']=$this->load->view('e-planning/referensi/sasaran',$data,true);
		$this->load->view('main',$data);
	}

	function saveVisibyPeriode(){
		$data = array(
			'idPeriode'=>$this->input->post('idPeriode'),
			'idVisi'=>$this->input->post('idVisi')
		);
		$this->refmo->save($data, 'data_visi');
	}
	
	function saveMisibyPeriode(){
		$data = array(
			'idPeriode'=>$this->input->post('idPeriode'),
			'idMisi'=>$this->input->post('idMisi')
		);
		$this->refmo->save($data, 'data_misi');
	}
	
	function saveTujuanbyPeriode(){
		$data = array(
			'idPeriode'=>$this->input->post('idPeriode'),
			'idTujuan'=>$this->input->post('idTujuan')
		);
		$this->refmo->save($data, 'data_tujuan');
	}
	
	function saveSasaranbyPeriode(){
		$data = array(
			'idPeriode'=>$this->input->post('idPeriode'),
			'idSasaran'=>$this->input->post('idSasaran')
		);
		$this->refmo->save($data, 'data_sasaran_strategis');
	}

	//flexigrid
	function grid_periode(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',1);
		$colModel['PERIODE'] = array('Periode',100,TRUE,'center',1);
		$colModel['SASARAN_STRATEGIS'] = array('Sasaran Strategis',50,TRUE,'left',1);
		$colModel['VISI'] = array('Visi',50,TRUE,'left',1);
		$colModel['MISI'] = array('Misi',50,TRUE,'left',1);
		$colModel['TUJUAN'] = array('Tujuan',50,TRUE,'left',1);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',1);
		$colModel['EDIT'] = array('Edit',50,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'PENGAJUAN PROPOSAL',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi/grid_list_periode";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addPeriode','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/savePeriode/',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'periode_awal='+ document.form_tambah_periode.periode_awal.value +' && periode_akhir='+ document.form_tambah_periode.periode_akhir.value, //the name of the $_POST variable and its value
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_periode'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function update_data(idPeriode){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updatePeriode/'+idPeriode,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'periode_awal='+ document.form_update_periode.periode_awal.value +' && periode_akhir='+ document.form_update_periode.periode_akhir.value,
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_periode'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function detailPeriode(idPeriode){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdatePeriode/'+idPeriode,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Daftar Periode';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_periode(){
		$valid_fields = array('PERIODE','SASARAN_STRATEGIS','VISI','MISI','TUJUAN','DETAIL','DELETE');
		$this->flexigrid->validate_post('periode_awal','asc',$valid_fields);
		$records = $this->refmo->get_flexigrid('ref_periode');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->periode_awal.'-'.$row->periode_akhir,
				'<a href='.base_url().'index.php/e-planning/referensi/grid_sasaran/'.$row->idPeriode.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/referensi/grid_visi/'.$row->idPeriode.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/referensi/grid_misi/'.$row->idPeriode.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/referensi/grid_tujuan/'.$row->idPeriode.'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/referensi/detail_periode/'.$row->idPeriode.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href="#" onClick="detailPeriode('.$row->idPeriode.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deletePeriode/'.$row->idPeriode.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}

	function grid_visi($idPeriode){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',1);
		$colModel['Visi'] = array('Visi',400,TRUE,'left',1);
		$colModel['EDIT'] = array('Edit',50,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'VISI',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi/grid_list_visi/".$idPeriode;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addVisi/".$idPeriode."','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(idPeriode){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/saveVisi',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'idVisi='+ document.form_tambah_visi.visi.value +' && idPeriode='+ idPeriode,
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_visi/'+idPeriode}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(idVisi){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updateVisi/'+idVisi,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'idVisi='+ document.form_update_visi.visi.value +
						' && idPeriode='+ document.form_update_visi.idPeriode.value,
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_visi/'+document.form_update_visi.idPeriode.value}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateVisi(idVisi,idPeriode){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdateVisi/'+idVisi+'/'+idPeriode,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Visi';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_visi($idPeriode){
		$valid_fields = array('Visi','DETAIL','DELETE');
		$this->flexigrid->validate_post('Visi','asc',$valid_fields);
		$records = $this->refmo->get_where_flexigrid('data_visi','idPeriode',$idPeriode,'ref_visi','data_visi.idVisi=ref_visi.idVisi');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->Visi,
				'<a href=\'#\' onClick="updateVisi('.$row->idVisi.','.$idPeriode.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deleteVisi/'.$row->idPeriode.'/'.$row->idVisi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function grid_misi($idPeriode){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',1);
		$colModel['Misi'] = array('Misi',400,TRUE,'left',1);
		$colModel['EDIT'] = array('Edit',50,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'MISI',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi/grid_list_misi/".$idPeriode;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addMisi/".$idPeriode."','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(idPeriode){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/saveMisi',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'idMisi='+ document.form_tambah_misi.misi.value +' && idPeriode='+ idPeriode,
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_misi/'+idPeriode}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(idMisi){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updateMisi/'+idMisi,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'idMisi='+ document.form_update_misi.misi.value +
						' && idPeriode='+ document.form_update_misi.idPeriode.value,
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_misi/'+document.form_update_misi.idPeriode.value}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateMisi(idMisi,idPeriode){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdateMisi/'+idMisi+'/'+idPeriode,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Misi';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_misi($idPeriode){
		$valid_fields = array('Misi','DETAIL','DELETE');
		$this->flexigrid->validate_post('Misi','asc',$valid_fields);
		$records = $this->refmo->get_where_flexigrid('data_misi','idPeriode',$idPeriode,'ref_misi','data_misi.idMisi=ref_misi.idMisi');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->Misi,
				'<a href=\'#\' onClick="updateMisi('.$row->idMisi.','.$idPeriode.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deleteMisi/'.$row->idPeriode.'/'.$row->idMisi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function grid_tujuan($idPeriode){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',1);
		$colModel['Tujuan'] = array('Tujuan',400,TRUE,'left',1);
		$colModel['EDIT'] = array('Edit',50,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'Tujuan',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi/grid_list_tujuan/".$idPeriode;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addTujuan/".$idPeriode."','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(idPeriode){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/saveTujuan',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'idTujuan='+ document.form_tambah_tujuan.tujuan.value +' && idPeriode='+ idPeriode,
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_tujuan/'+idPeriode}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(idTujuan){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updateTujuan/'+idTujuan,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'idTujuan='+ document.form_update_tujuan.tujuan.value +
						' && idPeriode='+ document.form_update_tujuan.idPeriode.value,
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_tujuan/'+document.form_update_tujuan.idPeriode.value}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateTujuan(idTujuan,idPeriode){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdateTujuan/'+idTujuan+'/'+idPeriode,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Tujuan';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_tujuan($idPeriode){
		$valid_fields = array('Tujuan','DETAIL','DELETE');
		$this->flexigrid->validate_post('Tujuan','asc',$valid_fields);
		$records = $this->refmo->get_where_flexigrid('data_tujuan','idPeriode',$idPeriode,'ref_tujuan','data_tujuan.idTujuan=ref_tujuan.idTujuan');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->Tujuan,
				'<a href=\'#\' onClick="updateTujuan('.$row->idTujuan.','.$idPeriode.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deleteTujuan/'.$row->idPeriode.'/'.$row->idTujuan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function grid_sasaran($idPeriode){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',1);
		$colModel['sasaran_strategis'] = array('Sasaran Strategis',400,TRUE,'left',1);
		$colModel['EDIT'] = array('Edit',50,TRUE,'center',1);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',1);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'Sasaran Strategis',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
		
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi/grid_list_sasaran/".$idPeriode;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addSasaranStrategis/".$idPeriode."','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(idPeriode){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/saveSasaranStrategis',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'idSasaran='+ document.form_tambah_sasaran.sasaran.value +' && idPeriode='+ idPeriode,
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_sasaran/'+idPeriode}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(idSasaran){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updateSasaranStrategis/'+idSasaran,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'idSasaran='+ document.form_update_sasaran.sasaran.value +
						' && idPeriode='+ document.form_update_sasaran.idPeriode.value,
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi/grid_sasaran/'+document.form_update_sasaran.idPeriode.value}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateSasaran(idSasaran,idPeriode){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdateSasaranStrategis/'+idSasaran+'/'+idPeriode,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Sasaran Stragegis';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_sasaran($idPeriode){
		$valid_fields = array('sasaran_strategis','DETAIL','DELETE');
		$this->flexigrid->validate_post('sasaran_strategis','asc',$valid_fields);
		$records = $this->refmo->get_where_flexigrid('data_sasaran_strategis','idPeriode',$idPeriode,'ref_sasaran_strategis','data_sasaran_strategis.idSasaran=ref_sasaran_strategis.idSasaran');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->sasaran_strategis,
				'<a href=\'#\' onClick="updateSasaran('.$row->idSasaran.','.$idPeriode.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deleteSasaranStrategis/'.$row->idPeriode.'/'.$row->idSasaran.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
}
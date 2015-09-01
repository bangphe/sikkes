<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referensi2 extends CI_Controller {
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
	function grid_periode(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',1);
		$colModel['PERIODE'] = array('Periode',100,TRUE,'center',1);
		if($this->session->userdata('kd_role') != 8){
			$colModel['EDIT'] = array('Edit',25,TRUE,'center',1);
			$colModel['DELETE'] = array('Delete',25,TRUE,'center',1);
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
		// if($this->session->userdata('kd_role') != 8)
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi2/grid_list_periode";
		
		// if($this->session->userdata('kd_role') != 8)
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		
		// else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addPeriode_referensi','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/savePeriode_referensi/',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						periode_awal:document.form_tambah_periode.periode_awal.value,
						periode_akhir:document.form_tambah_periode.periode_akhir.value
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_periode'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function update_data(idPeriode){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updatePeriode_referensi/'+idPeriode,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						periode_awal:document.form_update_periode.periode_awal.value,
						periode_akhir:document.form_update_periode.periode_akhir.value
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_periode'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updatePeriode(idPeriode){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdatePeriode_referensi/'+idPeriode,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['rencana_kerja_satker'] = "";
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
				'<a href=\'#\' onClick="updatePeriode('.$row->idPeriode.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deletePeriode_referensi/'.$row->idPeriode.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}

	function grid_visi(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['periode'] = array('Periode',80,TRUE,'center',1);
		$colModel['tahun'] = array('Tahun',80,TRUE,'center',1);
		$colModel['nmsatker'] = array('Satker',200,TRUE,'left',1);
		$colModel['Visi'] = array('Visi',585,TRUE,'left',1);
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN || $this->session->userdata('kd_role') == Role_model::DIREKTORAT){
		$colModel['EDIT'] = array('Edit',50,TRUE,'center',0);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',0);
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
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN || $this->session->userdata('kd_role') == Role_model::DIREKTORAT){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi2/grid_list_visi";
		
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN || $this->session->userdata('kd_role') == Role_model::DIREKTORAT){
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		}
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addVisi_referensi/','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/saveVisi_referensi',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						Visi:document.form_tambah_visi.visi.value,
						periode:document.form_tambah_visi.periode.value,
						tahun:document.form_tambah_visi.tahun.value
					},
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_visi'}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(IdVisi){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updateVisi_referensi/'+IdVisi,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						idVisi:IdVisi,
						Visi:document.form_update_visi.visi.value,
						periode:document.form_update_visi.periode.value,
						tahun:document.form_update_visi.tahun.value
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_visi'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			<!--
			function update_grid(idPeriode){
				$('#kanan').show('slow');
				$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_visi/'+idPeriode}).flexReload();
			}
			-->
			
			function updateVisi(idVisi){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdateVisi_referensi/'+idVisi,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		/*
		$option_periode;
		foreach($this->masmo->get('ref_periode','idPeriode',$idPeriode)->result() as $row){
			$option_periode[$row->idPeriode]=$row->periode_awal.'-'.$row->periode_akhir;
		}
		
		$data['panel'] =
		"<div class=\"panel\">
			<form name=\"form_periode\" id=\"form_periode\" method=\"POST\" action=\"#\" onsubmit=\" update_grid(document.form_periode.periode.value); \">
				<strong>Periode</strong> ".form_dropdown('periode', $option_periode)."
				<input type=\"submit\" class=\"regular\" name=\"save\" value=\"OK\" />
			</form>
		</div>";
		*/
		$data['div']="<div id='kanan'></div>";
		$data['rencana_kerja_satker'] = "";
		$data['judul'] = 'Visi';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_visi(){
		$valid_fields = array('Visi','nmsatker', 'periode_awal');
		$this->flexigrid->validate_post('Visi','asc',$valid_fields);
		//$records = $this->refmo->where_join_double_flexigrid('ref_visi',$this->session->userdata('kdsatker'),'ref_visi.kdsatker','ref_periode','ref_visi.idPeriode=ref_periode.idPeriode','ref_satker','ref_visi.kdsatker=ref_satker.kdsatker');
		$records = $this->refmo->where_join_triple_flexigrid('ref_visi',$this->session->userdata('kdsatker'),'ref_visi.kdsatker','ref_tahun_anggaran','ref_visi.idThnAnggaran=ref_tahun_anggaran.idThnAnggaran','ref_satker','ref_visi.kdsatker=ref_satker.kdsatker','ref_periode','ref_visi.idPeriode=ref_periode.idPeriode');
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->periode_awal.'-'.$row->periode_akhir,
				$row->thn_anggaran,
				$row->nmsatker,
				$row->Visi,
				//$row->periode_awal.'-'.$row->periode_akhir,
				'<a href=\'#\' onClick="updateVisi('.$row->idVisi.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deleteVisi_referensi/'.$row->idVisi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function grid_misi(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['periode'] = array('Periode',80,TRUE,'center',1);
		$colModel['tahun'] = array('Tahun',80,TRUE,'center',1);
		$colModel['nmsatker'] = array('Satker',200,TRUE,'left',1);
		$colModel['Misi'] = array('Misi',585,TRUE,'left',1);
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL  || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$colModel['EDIT'] = array('Edit',50,TRUE,'center',0);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',0);
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
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL  || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi2/grid_list_misi";
		
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		}
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addMisi_referensi/','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/saveMisi_referensi',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						Misi:document.form_tambah_misi.misi.value,
						periode:document.form_tambah_misi.periode.value,
						tahun:document.form_tambah_misi.tahun.value
					},
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_misi'}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(IdMisi){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updateMisi_referensi',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						idMisi:IdMisi,
						Misi:document.form_update_misi.misi.value,
						periode:document.form_update_misi.periode.value,
						tahun:document.form_update_misi.tahun.value
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_misi'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateMisi(idMisi){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdateMisi_referensi/'+idMisi,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['rencana_kerja_satker'] = "";
		$data['judul'] = 'Misi';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_misi(){
		$valid_fields = array('Misi','nmsatker');
		$this->flexigrid->validate_post('Misi','asc',$valid_fields);
		//$records = $this->refmo->where_join_double_flexigrid('ref_misi',$this->session->userdata('kdsatker'),'ref_misi.kdsatker','ref_periode','ref_misi.idPeriode=ref_periode.idPeriode','ref_satker','ref_misi.kdsatker=ref_satker.kdsatker');
		$records = $this->refmo->where_join_triple_flexigrid('ref_misi',$this->session->userdata('kdsatker'),'ref_misi.kdsatker','ref_tahun_anggaran','ref_misi.idThnAnggaran=ref_tahun_anggaran.idThnAnggaran','ref_satker','ref_misi.kdsatker=ref_satker.kdsatker','ref_periode','ref_misi.idPeriode=ref_periode.idPeriode');
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->periode_awal.'-'.$row->periode_akhir,
				$row->thn_anggaran,
				$row->nmsatker,
				$row->Misi,
				'<a href=\'#\' onClick="updateMisi('.$row->idMisi.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deleteMisi_referensi/'.$row->idMisi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function grid_kegiatan(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',1);
		$colModel['KodeKegiatan'] = array('Kode Kegiatan',100,TRUE,'center',1);
		$colModel['Kegiatan'] = array('Kegiatan',400,TRUE,'left',1);
		if($this->session->userdata('kd_role') != 8){
			$colModel['EDIT'] = array('Edit',25,TRUE,'center',1);
			$colModel['DELETE'] = array('Delete',25,TRUE,'center',1);
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
		// if($this->session->userdata('kd_role') != 8)
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi2/list_kegiatan";
		
		// if($this->session->userdata('kd_role') != 8)
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		
		// else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/referensi2/loadUpdateKegiatan/','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(){
				$.ajax({
					url: '".base_url()."index.php/e-planning/referensi2/addKegiatan',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'NamaKegiatan='+ document.form_tambah_kegiatan.NamaKegiatan.value,
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_kegiatan'}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(KodeKegiatan){
				$.ajax({
					url: '".base_url()."index.php/e-planning/referensi2/updateKegiatan/'+KodeKegiatan,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data: 'KodeKegiatan='+ KodeKegiatan +
						' && NamaKegiatan='+ document.form_update_kegiatan.NamaKegiatan.value,
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_kegiatan'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateKegiatan(KodeKegiatan){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdateKegiatan/'+KodeKegiatan,'kanan');
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Kegiatan';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function list_kegiatan(){
		$valid_fields = array('KodeKegiatan','NamaKegiatan','DETAIL','DELETE');
		$this->flexigrid->validate_post('KodeKegiatan','asc',$valid_fields);
		$records = $this->refmo->get_flexigrid('ref_kegiatan');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->KodeKegiatan,
				$no,
				$row->KodeKegiatan,
				$row->NamaKegiatan,
				'<a href=\'#\' onClick="updateMisi('.$row->idMisi.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deleteMisi_referensi/'.$row->idMisi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function addKegiatan(){
		$data['judul'] = 'Tambah Kegiatan';
		$this->load->view('e-planning/referensi/tambah_kegiatan',$data);
	}
	
	function loadUpdateKegiatan($KodeKegiatan){
		$data['NamaKegiatan']='';
		$data['KodeKegiatan']=$KodeKegiatan;
		foreach($this->masmo->get_where('ref_kegiatan','KodeKegiatan',$KodeKegiatan)->result() as $row){
			$data['NamaKegiatan']=$row->NamaKegiatan;
		}
		$data['judul']='Update Kegiatan';
		$data2['content'] = $this->load->view('e-planning/referensi/update_kegiatan',$data);
	}
	
	function updateKegiatan($KodeKegiatan){
		$data=array(
			'NamaKegiatan'=>$_POST['NamaKegiatan']
		);
		$this->masmo->update('ref_kegiatan', $data, 'KogeKegiatan', $_POST['KodeKegiatan']);
	}
	
	function deleteKegiatan($KodeKegiatan){
		$this->masmo->delete('ref_kegiatan', 'KodeKegiatan', $KodeKegiatan);
		redirect('e-planning/referensi2/grid_kegiatan');
	}
	
	function saveKegiatan(){
		$data=array(
			'NamaKegiatan'=>$_POST['NamaKegiatan'],
		);
		$this->masmo->save('ref_kegiatan',$data);
	}
	
	function grid_program(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',1);
		$colModel['KodeProgram'] = array('Kode Program',100,TRUE,'left',1);
		$colModel['NamaProgram'] = array('Program',400,TRUE,'left',1);
		if($this->session->userdata('kd_role') != 8){
			$colModel['EDIT'] = array('Edit',25,TRUE,'center',1);
			$colModel['DELETE'] = array('Delete',25,TRUE,'center',1);
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
		// if($this->session->userdata('kd_role') != 8)
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/referensi2/list_program";
		
		// if($this->session->userdata('kd_role') != 8)
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		
		// else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type=\"text/javascript\">
			$(document).ready(function(){
				$(\"#kanan\").hide();
			});
			function spt_js(com,grid){
				if (com==\"Tambah\"){
					$(\"#kanan\").show(\"slow\");
					getdata(\"".base_url()."index.php/e-planning/referensi2/addProgram/\",\"kanan\");
				}			
			}
			function save_data(){
				$.ajax({
					url: \"".base_url()."index.php/e-planning/referensi2/saveProgram\",
					global: false,
					type: \"POST\",
					async: false,
					dataType: \"html\",
					data:{
						NamaProgram: document.form_tambah_program.NamaProgram.value,
						OutComeProgram: document.form_tambah_program.OutComeProgram.value,
						KodeUnitOrganisasi: document.form_tambah_program.KodeUnitOrganisasi.value
					},
					success: function (response) {
						$(\"#kanan\").hide(\"slow\");
						$(\"#user\").flexOptions({ url: \"".base_url()."index.php/e-planning/referensi2/grid_program\"}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(KodeProgram){
				$.ajax({
					url: \"".base_url()."index.php/e-planning/referensi2/updateProgram/\"+KodeProgram,
					global: false,
					type: \"POST\",
					async: false,
					dataType: \"html\",
					data:{
						KodeProgram: KodeProgram,
						NamaProgram: document.form_update_program.NamaProgram.value
					},
					success: function (response) {
						$(\"#user\").flexOptions({ url: \"".base_url()."index.php/e-planning/referensi2/grid_program\"}).flexReload();
						$(\"#kanan\").hide(\"slow\");
					}
				});
				return false;
			}
			
			function loadUpdateProgram(KodeProgram){
				$(\"#kanan\").show(\"slow\");
				getdata(\"".base_url()."index.php/e-planning/referensi2/loadUpdateProgram/\"+KodeProgram,\"kanan\");
			}
		</script>";
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Program';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function list_program(){
		$valid_fields = array('KodeProgram','NamaProgram','DETAIL','DELETE');
		$this->flexigrid->validate_post('KodeProgram','asc',$valid_fields);
		$records = $this->refmo->get_flexigrid('ref_program');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->KodeProgram,
				$no,
				$row->KodeProgram,
				$row->NamaProgram,
				"<a href=\"#\" onClick=\"loadUpdateProgram(".$row->KodeProgram.");\"><img border=\"0\" src=\"".base_url()."images/flexigrid/edit.png\"></a>",
				'<a href='.base_url().'index.php/e-planning/referensi2/deleteProgram/'.$row->KodeProgram.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function addProgram(){
		$data['judul'] = 'Tambah Program';
		$option_unit;
		$data['kdunit']='';
		foreach($this->masmo->get_max('KodeProgram','ref_program','KodeUnitOrganisasi','024.01')->result() as $row){
			$data['kdunit'] = $row->KodeProgram;
		}
		foreach($this->masmo->get('ref_unit_organisasi')->result() as $row){
			$option_unit[$row->KodeUnitOrganisasi] = $row->NamaUnitOrganisasi;
		}
		$data['unit'] = $option_unit;
		$this->load->view('e-planning/referensi/tambah_program',$data);
	}
	
	function loadUpdateProgram($KodeProgram){
		$data['NamaProgram']='';
		$data['selected_unit']='';
		$data['KodeProgram']=$KodeProgram;
		foreach($this->masmo->get_where('ref_program','KodeProgram',$KodeProgram)->result() as $row){
			$data['NamaProgram']=$row->NamaProgram;
			$data['selected_unit']=$row->KodeUnitOrganisasi;
		}
		$option_unit;
		foreach($this->masmo->get('ref_unit_organisasi')->result() as $row){
			$option_unit[$row->KodeUnitOrganisasi] = $row->NamaUnitOrganisasi;
		}
		$data['unit'] = $option_unit;
		$data['judul']='Update Program';
		$data2['content'] = $this->load->view('e-planning/referensi/update_program',$data);
	}
	
	function updateProgram($KodeProgram){
		$data=array(
			'NamaProgram'=>$_POST['NamaProgram'],
			'KodeUnitOrganisasi'=>$_POST['KodeUnitOrganisasi'],
		);
		$this->masmo->update('ref_program', $data, 'KogeProgram', $_POST['KodeProgram']);
	}
	
	function deleteProgram($KodeProgram){
		$this->masmo->delete('ref_program', 'KodeProgram', $KodeProgram);
		redirect('e-planning/referensi2/grid_program');
	}
	
	function saveProgram(){
		foreach($this->masmo->get_max('KodeProgram','ref_program','KodeUnitOrganisasi',$_POST['KodeUnitOrganisasi'])->result() as $row){
			$temp = explode('.',$row->KodeProgram);
			$kode_program = $_POST['KodeUnitOrganisasi'].'.'.($temp[2]+1);
		}
		
		$data=array(
			'KodeProgram'=>$kode_program,
			'KodeKementerian'=>'024',
			'OutComeProgram'=>$_POST['OutComeProgram'],
			'NamaProgram'=>$_POST['NamaProgram'],
			'KodeUnitOrganisasi'=>$_POST['KodeUnitOrganisasi']
		);
		$this->masmo->save('ref_program',$data);
	}
	
	function grid_sasaran(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['nmsatker'] = array('Satker',200,TRUE,'left',1);
		$colModel['sasaran_strategis'] = array('Sasaran Satker',500,TRUE,'left',1);
		$colModel['periode_awal-periode_akhir'] = array('Periode',100,FALSE,'center',0);
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$colModel['EDIT'] = array('Edit',50,TRUE,'center',0);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',0);
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
		$url = base_url()."index.php/e-planning/referensi2/grid_list_sasaran";
		
		if ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		}
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/addSasaranStrategis_referensi','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/saveSasaranStrategis_referensi',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						sasaran:document.form_tambah_sasaran.sasaran.value,
						idPeriode:document.form_tambah_sasaran.periode.value
					},
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_sasaran'}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(idSasaran){
				$.ajax({
					url: '".base_url()."index.php/e-planning/master/updateSasaranStrategis_referensi/'+idSasaran,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						sasaran:document.form_update_sasaran.sasaran.value,
						periode:document.form_update_sasaran.periode.value
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/referensi2/grid_sasaran'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateSasaran(idSasaran){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/master/loadUpdateSasaranStrategis_referensi/'+idSasaran,'kanan');
			}
		</script>";
		$data['rencana_kerja_satker'] = "";
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Sasaran Satker';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_sasaran(){
		$valid_fields = array('sasaran_strategis','nmsatker');
		$this->flexigrid->validate_post('sasaran_strategis','asc',$valid_fields);
		$records = $this->refmo->where_join_double_flexigrid('ref_sasaran_strategis',$this->session->userdata('kdsatker'),'ref_sasaran_strategis.kdsatker','ref_periode','ref_sasaran_strategis.idPeriode=ref_periode.idPeriode','ref_satker','ref_sasaran_strategis.kdsatker=ref_satker.kdsatker');
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->nmsatker,
				$row->sasaran_strategis,
				$row->periode_awal.'-'.$row->periode_akhir,
				'<a href=\'#\' onClick="updateSasaran('.$row->idSasaran.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/master/deleteSasaran_referensi/'.$row->idSasaran.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
}
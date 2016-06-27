<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Rencana_kinerja_kementrian extends CI_Controller{
	function __construct(){
		parent::__construct();
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
	
	function grid_visi(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['Visi'] = array('Visi',600,TRUE,'left',1);
		$colModel['periode_awal'] = array('Periode',100,TRUE,'center',1);
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
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
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_list_visi";
		
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
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
					url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/saveVisi',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						Visi:document.form_tambah_visi.visi.value,
						periode:document.form_tambah_visi.periode.value
					},
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_visi'}).flexReload();
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
						periode:document.form_update_visi.periode.value
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_visi'}).flexReload();
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
		$data['rencana_kerja_kementrian'] = "";
		$data['judul'] = 'Visi';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	
	function grid_list_visi(){
		$valid_fields = array('Visi','nmsatker','periode_awal');
		$this->flexigrid->validate_post('Visi','asc',$valid_fields);
		$records = $this->refmo->join_where_flexigrid('ref_visi','kdsatker',1,'ref_periode','ref_visi.idPeriode=ref_periode.idPeriode');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->Visi,
				$row->periode_awal.'-'.$row->periode_akhir,
				'<a href=\'#\' onClick="updateVisi('.$row->idVisi.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/rencana_kinerja_kementrian/deleteVisi/'.$row->idVisi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
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
	 
	
	function saveVisi(){
		$cek = $this->masmo->get_where2('ref_visi', 'kdsatker', 1, 'idPeriode', $_POST['periode']);
		if($this->validasi_visi() == FALSE){
			$this->grid_visi($this->input->post('Visi'));
		}
		elseif($cek->num_rows() > 0)
			redirect('');
		else{
			$data=array(
				'kdsatker'=>1,
				'idPeriode'=>$_POST['periode'],
				'Visi'=>$_POST['Visi']
			);
		}
		$this->masmo->save('ref_visi',$data);
	}
	
	function deleteVisi($idVisi){
		$this->masmo->delete('ref_visi', 'idVisi', $idVisi);
		redirect('e-planning/rencana_kinerja_kementrian/grid_visi');
	}
	
	function grid_misi(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['periode_awal-periode_akhir'] = array('Periode',200,FALSE,'center',0);
		$colModel['Misi'] = array('Misi',200,TRUE,'center',1);
		$colModel['periode_awal-periode_akhir'] = array('Periode',100,FALSE,'center',0);
		$colModel['Misi'] = array('Misi',600,TRUE,'left',1);
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
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
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_list_misi";
		
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
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
					url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/saveMisi',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						Misi:document.form_tambah_misi.misi.value,
						periode:document.form_tambah_misi.periode.value
					},
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_misi'}).flexReload();
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
						periode:document.form_update_misi.periode.value
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_misi'}).flexReload();
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
		$data['rencana_kerja_kementrian'] = "";
		$data['judul'] = 'Misi';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_misi(){
		$valid_fields = array('Misi','nmsatker');
		$this->flexigrid->validate_post('Misi','asc',$valid_fields);
		$records = $this->refmo->join_where_flexigrid('ref_misi','kdsatker',1,'ref_periode','ref_misi.idPeriode=ref_periode.idPeriode');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->periode_awal.'-'.$row->periode_akhir,
				$row->Misi,
				'<a href=\'#\' onClick="updateMisi('.$row->idMisi.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/rencana_kinerja_kementrian/deleteMisi/'.$row->idMisi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
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
	
	function saveMisi(){
		if($this->validasi_misi() == FALSE){
			$this->grid_misi($this->input->post('Misi'));
		}
		else{
			$data=array(
				'kdsatker'=>1,
				'idPeriode'=>$_POST['periode'],
				'Misi'=>$_POST['Misi'],
			);
			$this->masmo->save('ref_misi',$data);
		}
	}
	
	function deleteMisi($idMisi){
		$this->masmo->delete('ref_misi', 'idMisi', $idMisi);
		redirect('e-planning/rencana_kinerja_kementrian/grid_misi');
	}
	
	function grid_sasaran(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['sasaran_strategis'] = array('Sasaran Strategis',600,TRUE,'left',1);
		$colModel['periode_awal-periode_akhir'] = array('Periode',100,FALSE,'center',0);		
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
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
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_list_sasaran";
				
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
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
					url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/saveSasaranStrategis',
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
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_sasaran'}).flexReload();
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
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/rencana_kinerja_kementrian/grid_sasaran'}).flexReload();
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
		$data['rencana_kerja_kementrian'] = "";
		$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Sasaran Strategis';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function grid_list_sasaran(){
		$valid_fields = array('sasaran_strategis','nmsatker');
		$this->flexigrid->validate_post('sasaran_strategis','asc',$valid_fields);
		$records = $this->refmo->join_where_flexigrid('ref_sasaran_strategis','kdsatker',1,'ref_periode','ref_sasaran_strategis.idPeriode=ref_periode.idPeriode');
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->sasaran_strategis,
				$row->periode_awal.'-'.$row->periode_akhir,
				'<a href=\'#\' onClick="updateSasaran('.$row->idSasaran.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/rencana_kinerja_kementrian/deleteSasaran/'.$row->idSasaran.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	//validasi
	function validasi_sasaran(){
		$config = array(
			array('field'=>'sasaran','label'=>'Sasaran', 'rules'=>'required')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');

		return $this->form_validation->run();
	}
	
	function saveSasaranStrategis(){
		if($this->validasi_sasaran() == FALSE){
			$this->grid_sasaran();
		}
		else{
			$data=array(
				'idPeriode'=>$_POST['idPeriode'],
				'sasaran_strategis'=>$_POST['sasaran'],
				'kdsatker'=>1
			);
			$this->masmo->save('ref_sasaran_strategis',$data);
		}
	}
	
	function deleteSasaran($idSasaran){
		$this->masmo->delete('ref_sasaran_strategis', 'idSasaran', $idSasaran);
		redirect('e-planning/rencana_kinerja_kementrian/grid_sasaran');
	}
}
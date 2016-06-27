<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fokus_prioritas extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('flexigrid');
		$this->load->helper('flexigrid');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/fokus_prioritas_model','fopri');
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
	
	function grid_fokus_prioritas(){
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['periode_awal'] = array('Periode',100,TRUE,'center',1);
		$colModel['FokusPrioritas'] = array('Fokus Prioritas',800,TRUE,'left',1);		
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$colModel['EDIT'] = array('Edit',25,TRUE,'center',0);
		$colModel['DELETE'] = array('Delete',25,TRUE,'center',0);
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
		$url = base_url()."index.php/e-planning/fokus_prioritas/list_fokus_prioritas";
				
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
				getdata('".base_url()."index.php/e-planning/fokus_prioritas/tambah_fokus_prioritas/','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(){
				$.ajax({
					url: '".base_url()."index.php/e-planning/fokus_prioritas/save_fokus_prioritas',
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						periode:document.form_tambah_fokus_prioritas.periode.value,
						fokus_prioritas:document.form_tambah_fokus_prioritas.fokus_prioritas.value,
					},
					success: function (response) {
						$('#kanan').hide('slow');
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/fokus_prioritas/grid_fokus_prioritas'}).flexReload();
					}          
				});
				return false;
			}
			
			function update_data(idFokusPrioritas){
				$.ajax({
					url: '".base_url()."index.php/e-planning/fokus_prioritas/updateFokusPrioritas/'+idFokusPrioritas,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						periode:document.form_update_fokus_prioritas.periode.value,
						fokus_prioritas:document.form_update_fokus_prioritas.fokus_prioritas.value,
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/fokus_prioritas/grid_fokus_prioritas'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateFokusPrioritas(idFokusPrioritas){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/fokus_prioritas/loadUpdateFokusPrioritas/'+idFokusPrioritas,'kanan');
			}
		</script>";
		$data['div']="<div id='kanan'></div>";
		$data['rencana_kerja_satker'] = "";
		$data['judul'] = 'Fokus Prioritas';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function list_fokus_prioritas(){
		$valid_fields = array('periode_awal','FokusPrioritas');
		$this->flexigrid->validate_post('periode_awal','asc',$valid_fields);
		$records = $this->fopri->get_fokus_prioritas();

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->periode_awal.'-'.$row->periode_akhir,
				$row->FokusPrioritas,
				'<a href=\'#\' onClick="updateFokusPrioritas('.$row->idFokusPrioritas.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/fokus_prioritas/deleteFokusPrioritas/'.$row->idFokusPrioritas.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function tambah_fokus_prioritas(){
		$option_periode;
		foreach($this->fopri->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['judul'] = 'Tambah Fokus Prioritas';
		$this->load->view('e-planning/referensi/tambah_fokus_prioritas',$data);
	}
	
	//validasi
	function validasi_fokus_prioritas(){
		$config = array(
			array('field'=>'fokus_prioritas','label'=>'Fokus Prioritas', 'rules'=>'required')
		);
	
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');

		return $this->form_validation->run();
	}
		
	function save_fokus_prioritas(){
		if($this->validasi_fokus_prioritas() == FALSE){
			$this->grid_fokus_prioritas();
		}
		else{
			$data=array(
				'idPeriode' => $_POST['periode'],
				'FokusPrioritas' => $_POST['fokus_prioritas']
			);
			$this->fopri->save('fokus_prioritas',$data);
		}
	}
	
	function loadUpdateFokusPrioritas($idFokusPrioritas){
		$option_periode;
		foreach($this->fopri->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['fokus_prioritas']='';
		$data['idFokusPrioritas']=$idFokusPrioritas;
		$data['selected_periode']='';
		foreach($this->fopri->get_where('fokus_prioritas','idFokusPrioritas',$idFokusPrioritas)->result() as $row){
			$data['fokus_prioritas']=$row->FokusPrioritas;
			$data['selected_periode']=$row->idPeriode;
		}
		$data['judul']='Update Fokus Prioritas';
		$data2['content'] = $this->load->view('e-planning/referensi/update_fokus_prioritas',$data);
	}
	
	function updateFokusPrioritas($idFokusPrioritas){
		$data=array(
			'idPeriode' => $_POST['periode'],
			'FokusPrioritas' => $_POST['fokus_prioritas']
		);
		$this->fopri->update('fokus_prioritas', $data, 'idFokusPrioritas', $idFokusPrioritas);
	}
	
	function deleteFokusPrioritas($idFokusPrioritas){
		$this->fopri->delete('data_fokus_prioritas', 'idFokusPrioritas', $idFokusPrioritas);
		$this->fopri->delete('fokus_prioritas', 'idFokusPrioritas', $idFokusPrioritas);
		redirect('e-planning/fokus_prioritas/grid_fokus_prioritas');
	}
}
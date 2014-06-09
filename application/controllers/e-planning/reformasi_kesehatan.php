<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reformasi_kesehatan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('flexigrid');
		$this->load->helper('flexigrid');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/reformasi_kesehatan_model','reke');
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
	function grid_reformasi_kesehatan(){
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['periode_awal-periode_akhir'] = array('Periode',200,TRUE,'center',1);
		$colModel['ReformasiKesehatan'] = array('Prioritas Kesehatan',200,TRUE,'left',1);	
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
			'title' => 'Prioritas Kesehatan',
			'showTableToggleBtn' => false,
			'nowrap' => false
		);
			
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		// mengambil data dari file controler ajax pada method grid_user		
		$url = base_url()."index.php/e-planning/reformasi_kesehatan/list_reformasi_kesehatan";	
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		}
		else{
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		}
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/reformasi_kesehatan/tambah_reformasi_kesehatan/','kanan');
			}			
		} </script>";
		$data['added_js2']=
		"<script type='text/javascript'>
			$(document).ready(function(){
				$('#kanan').hide();
			});
			function save_data(){
				$.ajax({
					url: \"".base_url()."index.php/e-planning/reformasi_kesehatan/save_reformasi_kesehatan\",
					global: false,
					type: \"POST\",
					async: false,
					dataType: \"html\",
					data:{
						periode:document.form_tambah_reformasi_kesehatan.periode.value,
						reformasi_kesehatan:document.form_tambah_reformasi_kesehatan.reformasi_kesehatan.value,
					},
					success: function (response) {
						$(\"#kanan\").hide(\"slow\");
						$(\"#user\").flexOptions({ url: \"".base_url()."index.php/e-planning/reformasi_kesehatan/grid_reformasi_kesehatan\"}).flexReload();
					}
				});
				return false;
			}
			
			function update_data(idReformasiKesehatan){
				$.ajax({
					url: '".base_url()."index.php/e-planning/reformasi_kesehatan/updateReformasiKesehatan/'+idReformasiKesehatan,
					global: false,
					type: 'POST',
					async: false,
					dataType: 'html',
					data:{
						periode:document.form_update_reformasi_kesehatan.periode.value,
						reformasi_kesehatan:document.form_update_reformasi_kesehatan.reformasi_kesehatan.value
					},
					success: function (response) {
						$('#user').flexOptions({ url: '".base_url()."index.php/e-planning/reformasi_kesehatan/grid_reformasi_kesehatan'}).flexReload();
						$('#kanan').hide('slow');
					}          
				});
				return false;
			}
			
			function updateFokusPrioritas(idReformasiKesehatan){
				$('#kanan').show('slow');
				getdata('".base_url()."index.php/e-planning/reformasi_kesehatan/loadUpdateReformasiKesehatan/'+idReformasiKesehatan,'kanan');
			}
		</script>";
		$data['div']="<div id='kanan'></div>";
		$data['rencana_kerja_kementrian'] = "";
		$data['judul'] = 'Prioritas Kesehatan';
		$data['content'] = $this->load->view('grid_kiri',$data,true);
		$this->load->view('main',$data);
	}
	 
	function list_reformasi_kesehatan(){
		$valid_fields = array('periode_awal-periode_akhir','ReformasiKesehatan');
		$this->flexigrid->validate_post('periode_awal','asc',$valid_fields);
		$records = $this->reke->get_reformasi_kesehatan();

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->periode_awal.'-'.$row->periode_akhir,
				$row->ReformasiKesehatan,
				'<a href=\'#\' onClick="updateReformasiKesehatan('.$row->idReformasiKesehatan.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/reformasi_kesehatan/deleteReformasiKesehatan/'.$row->idReformasiKesehatan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function tambah_reformasi_kesehatan(){
		$option_periode;
		foreach($this->reke->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['judul'] = 'Tambah Prioritas Kesehatan';
		$this->load->view('e-planning/referensi/tambah_reformasi_kesehatan',$data);
	}
		
	function save_reformasi_kesehatan(){
		$data=array(
			'FokusPrioritas' => $_POST['reformasi_kesehatan'],
			'idPeriode' => $_POST['periode']
		);
		$this->reke->save('reformasi_kesehatan',$data);
	}
	
	function loadUpdateReformasiKesehatan($idReformasiKesehatan){
		$option_periode;
		foreach($this->reke->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['reformasi_kesehatan']='';
		$data['idReformasiKesehatan']=$idReformasiKesehatan;
		$data['selected_periode']='';
		foreach($this->reke->get_where('reformasi_kesehatan','idReformasiKesehatan',$idReformasiKesehatan)->result() as $row){
			$data['reformasi_kesehatan']=$row->ReformasiKesehatan;
			$data['selected_periode']=$row->idPeriode;
		}
		$data['judul']='Update Prioritas Kesehatan';
		$data2['content'] = $this->load->view('e-planning/referensi/update_reformasi_kesehatan',$data);
	}
	
	function updateReformasiKesehatan($idReformasiKesehatan){
		$data=array(
			'idPeriode' => $_POST['periode'],
			'ReformasiKesehatan' => $_POST['reformasi_kesehatan']
		);
		$this->reke->update('ref_visi', $data, 'idFokusPrioritas', $idFokusPrioritas);
	}
	
	function deleteFokusPrioritas($idReformasiKesehatan){
		$this->reke->delete('reformasi_kesehatan', 'idReformasiKesehatan', $idReformasiKesehatan);
		redirect('e-planning/reformasi_kesehatan/grid_reformasi_kesehatan');
	}
}
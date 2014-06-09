<?php
class Master_reformasi_kesehatan extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');	
		$this->load->library('form_validation');
		$this->load->library('session');
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
	/**
	 * Menampilkan tabel daftar propinsi
	 */
	function index(){
		redirect ('master_data/master_reformasi_kesehatan/grid_reformasi_kesehatan');
	}
	
	function grid_reformasi_kesehatan(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['periode_awal-periode_akhir'] = array('Periode',100,TRUE,'center',0);
		$colModel['ReformasiKesehatan'] = array('Reformasi Kesehatan',700,TRUE,'LEFT',1);
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$colModel['UBAH'] = array('Ubah',25,TRUE,'center',0);
		$colModel['HAPUS'] = array('Hapus',25,TRUE,'center',0);
		}
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
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_reformasi_kesehatan/list_reformasi_kesehatan";
		
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		}
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_reformasi_kesehatan/add_process';    
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

		$data['judul'] = 'Reformasi Kesehatan';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_reformasi_kesehatan(){
		$valid_fields = array('idPeriode','ReformasiKesehatan');
		$this->flexigrid->validate_post('reformasi_kesehatan.idPeriode','asc',$valid_fields);
		$records = $this->gm->get_data_flexigrid_join('reformasi_kesehatan','ref_periode','reformasi_kesehatan.idPeriode=ref_periode.idPeriode');
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->idPeriode,
				$no,
				$row->periode_awal.'-'.$row->periode_akhir,
				$row->ReformasiKesehatan,
				'<a href='.site_url().'/master_data/master_reformasi_kesehatan/edit_proses/'.$row->idReformasiKesehatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_reformasi_kesehatan/hapus/'.$row->idReformasiKesehatan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('reformasi_kesehatan', 'Reformasi Kesehatan', 'required');
		$this->form_validation->set_message('required', '%s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function add_process(){
		$option_periode;
		foreach($this->gm->get_data('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['content'] = $this->load->view('form_master_data/form_tambah_reformasi_kesehatan',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_reformasi_kesehatan(){
		if($this->cek_validasi() == true){
			$reformasi_kesehatan = array(
				'idPeriode' => $this->input->post('periode'),
				'ReformasiKesehatan' => $this->input->post('reformasi_kesehatan')
			);
			$this->gm->add('reformasi_kesehatan',$reformasi_kesehatan);
			redirect('master_data/master_reformasi_kesehatan');
		}else{
			$option_periode;
			foreach($this->gm->get_data('ref_periode')->result() as $row){
				$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
			}
			$data['periode'] = $option_periode;
			$data['content'] = $this->load->view('form_master_data/form_tambah_reformasi_kesehatan',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function edit_proses($idReformasiKesehatan){
		$reformasi_kesehatan = $this->gm->get_where('reformasi_kesehatan','idReformasiKesehatan',$idReformasiKesehatan);
		$option_periode;
		foreach($this->gm->get_data('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['idReformasiKesehatan'] = $idReformasiKesehatan;
		$data['idPeriode'] = $reformasi_kesehatan->row()->idPeriode;
		$data['reformasi_kesehatan'] = $reformasi_kesehatan->row()->ReformasiKesehatan;
		$data['content'] = $this->load->view('form_master_data/form_edit_reformasi_kesehatan',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_reformasi_kesehatan($idReformasiKesehatan){
		if ($this->cek_validasi() == true){
			$data_reformasi_kesehatan = array(
				'ReformasiKesehatan' => $this->input->post('reformasi_kesehatan'),
				'idPeriode' => $this->input->post('periode'),
			);
			$this->gm->update('reformasi_kesehatan',$data_reformasi_kesehatan,'idReformasiKesehatan',$idReformasiKesehatan);
			redirect('master_data/master_reformasi_kesehatan');
		}else{
			$reformasi_kesehatan = $this->gm->get_where('reformasi_kesehatan','idReformasiKesehatan',$idReformasiKesehatan);
			$option_periode;
			foreach($this->gm->get_data('ref_periode')->result() as $row){
				$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
			}
			$data['periode'] = $option_periode;
			$data['idReformasiKesehatan'] = $idReformasiKesehatan;
			$data['idPeriode'] = $reformasi_kesehatan->row()->idPeriode;
			$data['reformasi_kesehatan'] = $reformasi_kesehatan->row()->ReformasiKesehatan;
			$data['content'] = $this->load->view('form_master_data/form_edit_reformasi_kesehatan',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function hapus($idReformasiKesehatan){
		$this->gm->delete('data_reformasi_kesehatan','idReformasiKesehatan',$idReformasiKesehatan);
		$this->gm->delete('reformasi_kesehatan','idReformasiKesehatan',$idReformasiKesehatan);
		redirect('master_data/master_reformasi_kesehatan');
	}
}
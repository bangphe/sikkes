<?php
class Master_tahun_anggaran extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/thn_anggaran_model', 'tm');	
		$this->load->library('form_validation');
		$this->load->library('session');
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
		redirect ('master_data/master_tahun_anggaran/grid_tahun_anggaran');
	}
	
	function grid_tahun_anggaran(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['thn_anggaran'] = array('Tahun Anggaran',300,TRUE,'center',1);
		$colModel['UBAH'] = array('Ubah',50,TRUE,'center',0);
		$colModel['HAPUS'] = array('Hapus',50,TRUE,'center',0);
		
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
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_tahun_anggaran/list_tahun_anggaran";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_tahun_anggaran/add_process';
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

		$data['judul'] = 'Master Tahun Anggaran';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_tahun_anggaran(){
		$valid_fields = array('thn_anggaran');
		$this->flexigrid->validate_post('thn_anggaran','asc',$valid_fields);
		$records = $this->gm->get_data_flexigrid('ref_tahun_anggaran');
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->thn_anggaran,
				$no,
				$row->thn_anggaran,
				'<a href='.site_url().'/master_data/master_tahun_anggaran/edit_proses/'.$row->idThnAnggaran.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_tahun_anggaran/hapus/'.$row->idThnAnggaran.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}

	function validasi($tahun){

		$valid = $this->tm->validasi($tahun);
		if($valid == TRUE){
			echo 'FALSE';
		}
		else{
		echo 'TRUE';
		}
	}
	
	function add_process(){
		$option_periode;
		foreach($this->gm->get_data('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;	
		}
		$data['master_data'] = "";
		$data['opt_periode'] = $option_periode;
		$data['content'] = $this->load->view('form_master_data/form_tambah_tahun_anggaran',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_tahun_anggaran(){
		$tahun = $this->input->post('thn_anggaran');
		$periode = $this->input->post('periode');
		foreach ($this->gm->get_where('ref_periode','idPeriode',$periode)->result() as $row){
		$periode_akhir = $row->periode_akhir;
		$periode_awal = $row->periode_awal;
		if($tahun<$periode_awal OR $tahun>$periode_akhir){
		redirect('master_data/master_tahun_anggaran/add_process');}
		else{
		$thn_anggaran = array(
			'thn_anggaran' 	=> $this->input->post('thn_anggaran'),
			'idPeriode'		=> $this->input->post('periode')
		);
		$this->gm->add('ref_tahun_anggaran',$thn_anggaran);
		redirect('master_data/master_tahun_anggaran');
		}
		}
	}
	
	function edit_proses($idThnAnggaran){
		$option_periode;
		foreach($this->gm->get_data('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;	
		}
		$thn_anggaran = $this->gm->get_where('ref_tahun_anggaran','idThnAnggaran',$idThnAnggaran);
		
		$data['master_data'] = "";
		$data['selected_year'] = $thn_anggaran->row()->thn_anggaran;
		$data['idThnAnggaran'] = $idThnAnggaran;
		$data['opt_periode'] = $option_periode;
		$data['periode'] = $thn_anggaran->row()->idperiode;
		$data['content'] = $this->load->view('form_master_data/form_edit_tahun_anggaran',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_tahun_anggaran($idThnAnggaran){
		$thn_anggaran = array('thn_anggaran' => $this->input->post('thn_anggaran'));
		$this->gm->update('ref_tahun_anggaran',$thn_anggaran,'idThnAnggaran',$idThnAnggaran);
		redirect('master_data/master_tahun_anggaran');
	}
	
	function hapus($idThnAnggaran){
		$this->gm->delete('ref_tahun_anggaran','idThnAnggaran',$idThnAnggaran);
		redirect('master_data/master_tahun_anggaran');
	}
}
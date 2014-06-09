<?php
/**
 * Kelas Master_propinsi
 */
class Master_kabupaten extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/kabupaten_model');	
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
		redirect ('master_data/master_kabupaten/grid_kabupaten');
	}
	
	function grid_kabupaten(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['NamaProvinsi'] = array('Nama Provinsi',250,TRUE,'LEFT',0);
		$colModel['NamaKabupaten'] = array('Nama Kabupaten',250,TRUE,'LEFT',1);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
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
		$url = site_url()."/master_data/master_kabupaten/list_kabupaten";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_kabupaten/add_process';    
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
		$data['judul'] = 'Kabupaten';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_kabupaten(){
		$valid_fields = array('KodeProvinsi','KodeKabupaten','NamaKabupaten');
		$this->flexigrid->validate_post('ref_kabupaten.KodeProvinsi','asc',$valid_fields);
		$records = $this->gm->get_data_flexigrid_join('ref_kabupaten','ref_provinsi','ref_kabupaten.KodeProvinsi=ref_provinsi.KodeProvinsi');
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->KodeProvinsi,
				$no,
				$row->NamaProvinsi,
				$row->NamaKabupaten,
				'<a href='.site_url().'/master_data/master_kabupaten/detail_kabupaten/'.$row->KodeProvinsi.'/'.$row->KodeKabupaten.'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/master_data/master_kabupaten/edit_proses/'.$row->KodeProvinsi.'/'.$row->KodeKabupaten.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_kabupaten/hapus/'.$row->KodeProvinsi.'/'.$row->KodeKabupaten.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('kabupaten', 'Nama Kabupaten', 'required');
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	//validasi kode
	function validKode($kode){
		$kdprov = $this->input->get('x');
		//$kode = $this->input->get('y');
		if($this->kabupaten_model->valid_kode($kode, $kdprov) == TRUE){
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	
	//validasi nama
	function valid(){
		$nama = $this->input->get('nama');
		if($this->kabupaten_model->valid($nama) == TRUE)
			echo 'FALSE';
		else
			echo 'TRUE';
	}
	
	function add_process(){
		$option_prov;
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$data['master_data'] = "";
		$data['provinsi'] = $option_prov;
		$data['content'] = $this->load->view('form_master_data/form_tambah_kabupaten',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_kabupaten(){
		if($this->cek_validasi() == true){
			$kab = array(
				'NamaKabupaten' => $this->input->post('kabupaten'),
				//'KodeKabupaten' => $this->gm->get_max_where('ref_kabupaten','KodeKabupaten','KodeProvinsi',$this->input->post('provinsi'))+1,
				'KodeKabupaten' => $this->input->post('kdkab'),
				'KodeProvinsi' => $this->input->post('provinsi'),
			);
			$this->gm->add('ref_kabupaten',$kab);
			redirect('master_data/master_kabupaten');
		}else{
			$option_prov;
			foreach($this->gm->get_data('ref_provinsi')->result() as $row){
				$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
			}
			$data['master_data'] = "";
			$data['provinsi'] = $option_prov;
			$data['content'] = $this->load->view('form_master_data/form_tambah_kabupaten',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function edit_proses($KodeProvinsi,$KodeKabupaten){
		$kab = $this->gm->get_double_where('ref_kabupaten','KodeProvinsi',$KodeProvinsi,'KodeKabupaten',$KodeKabupaten);
		$option_prov;
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$data['master_data'] = "";
		$data['provinsi'] = $option_prov;
		$data['KodeProvinsi'] = $KodeProvinsi;
		$data['KodeKabupaten'] = $KodeKabupaten;
		$data['NamaKabupaten'] = $kab->row()->NamaKabupaten;
		$data['content'] = $this->load->view('form_master_data/form_edit_kabupaten',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_kabupaten($KodeKabupaten){
		if ($this->cek_validasi() == true){
			$data_kab = array(
				'NamaKabupaten' => $this->input->post('kabupaten')
			);
			$this->gm->update_double_where('ref_kabupaten',$data_kab,'KodeProvinsi',$this->input->post('provinsi'),'KodeKabupaten',$KodeKabupaten);
			redirect('master_data/master_kabupaten');
		}else{
			$prov = $this->propinsi_model->get_prov($KodeProvinsi);
			$data['master_data'] = "";
			$data['KodeProvinsi'] = $KodeProvinsi;
			$data['NamaProvinsi'] = $prov->row()->NamaProvinsi;
			$data['content'] = $this->load->view('form_master_data/form_edit_provinsi',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function hapus($kodeProvinsi, $KodeKabupaten){	
		$this->gm->delete_double_param('ref_kabupaten','KodeProvinsi',$kodeProvinsi,'KodeKabupaten',$KodeKabupaten);
		redirect('master_data/master_kabupaten');
	}
	
	//detail kabupaten
	function detail_kabupaten($KodeProvinsi, $KodeKabupaten){
		$kab = $this->gm->get_double_where('ref_kabupaten','KodeProvinsi',$KodeProvinsi,'KodeKabupaten',$KodeKabupaten);
		$option_prov;
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$data['master_data'] = "";
		$data['provinsi'] = $option_prov;
		$data['KodeProvinsi'] = $KodeProvinsi;
		$data['KodeKabupaten'] = $KodeKabupaten;
		$data['NamaKabupaten'] = $kab->row()->NamaKabupaten;
		$data['content'] = $this->load->view('form_master_data/form_detail_kabupaten',$data,true);
		$this->load->view('main',$data);	
	}
}
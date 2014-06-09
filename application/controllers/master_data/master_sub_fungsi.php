<?php
class Master_sub_fungsi extends CI_Controller {
	
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
		redirect ('master_data/master_sub_fungsi/grid_subfungsi');
	}
	
	function grid_subfungsi(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['NamaFungsi'] = array('Nama Fungsi',250,TRUE,'LEFT',1);
		$colModel['NamaSubFungsi'] = array('Nama Sub Fungsi',250,TRUE,'LEFT',1);
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
		$buttons[] = array('separator');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_sub_fungsi/list_subfungsi";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_sub_fungsi/add_process';    
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

		$data['judul'] = 'Master Kabupaten';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_subfungsi(){
	
		$valid_fields = array('KodeFungsi','KodeSubFungsi','NamaFungsi');
		$this->flexigrid->validate_post('ref_sub_fungsi.KodeFungsi','asc',$valid_fields);
		$records = $this->gm->get_data_flexigrid_join('ref_fungsi','ref_sub_fungsi','ref_fungsi.KodeFungsi=ref_sub_fungsi.KodeFungsi');
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->KodeFungsi,
				$no,
				$row->NamaFungsi,
				$row->NamaSubFungsi,
				'<a href='.site_url().'/master_data/master_sub_fungsi/edit_proses/'.$row->KodeFungsi.'/'.$row->KodeSubFungsi.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_sub_fungsi/hapus/'.$row->KodeFungsi.'/'.$row->KodeSubFungsi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('subfungsi', 'Sub Fungsi', 'required');
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function add_process(){
		$option_fungsi;
		foreach($this->gm->get_data('ref_fungsi')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = $row->NamaFungsi;
		}
		$data['master_data'] = "";
		$data['fungsi'] = $option_fungsi;
		$data['content'] = $this->load->view('form_master_data/form_tambah_subfungsi',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_subfungsi(){
		if($this->cek_validasi() == true){
			$subfungsi = array(
				'NamaSubFungsi' => $this->input->post('subfungsi'),
				'KodeSubFungsi' => $this->gm->get_max_where('ref_sub_fungsi','KodeFungsi','KodeFungsi',$this->input->post('fungsi'))+1,
				'KodeFungsi' => $this->input->post('fungsi'),
			);
			$this->gm->add('ref_sub_fungsi',$subfungsi);
			redirect('master_data/master_sub_fungsi');
		}else{
			$data['master_data'] = "";
			$option_fungsi;
			foreach($this->gm->get_data('ref_fungsi')->result() as $row){
				$option_fungsi[$row->KodeFungsi] = $row->NamaFungsi;
			}
			$data['fungsi'] = $option_fungsi;
			$data['content'] = $this->load->view('form_master_data/form_tambah_subfungsi',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function edit_proses($KodeFungsi, $KodeSubFungsi){
		$subfungsi = $this->gm->get_double_where('ref_sub_fungsi','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$option_fungsi;
		foreach($this->gm->get_data('ref_fungsi')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = $row->NamaFungsi;
		}
		$data['master_data'] = "";
		$data['fungsi'] = $option_fungsi;
		$data['KodeFungsi'] = $KodeFungsi;
		$data['KodeSubFungsi'] = $KodeSubFungsi;
		$data['subfungsi'] = $subfungsi->row()->NamaSubFungsi;
		$data['content'] = $this->load->view('form_master_data/form_edit_subfungsi',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_subfungsi($KodeSubFungsi){
		if ($this->cek_validasi() == true){
			$data_subfungsi = array('NamaSubFungsi' => $this->input->post('subfungsi'));
			$this->gm->update_double_where('ref_sub_fungsi',$data_subfungsi,'KodeFungsi',$this->input->post('fungsi'),'KodeSubFungsi',$KodeSubFungsi);
			redirect('master_data/master_sub_fungsi');
		}else{
			$subfungsi = $this->gm->get_double_where('ref_sub_fungsi','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
			$option_fungsi;
			foreach($this->gm->get_data('ref_fungsi')->result() as $row){
				$option_fungsi[$row->KodeFungsi] = $row->NamaFungsi;
			}
			$data['master_data'] = "";
			$data['fungsi'] = $option_fungsi;
			$data['KodeFungsi'] = $KodeFungsi;
			$data['KodeSubFungsi'] = $KodeSubFungsi;
			$data['subfungsi'] = $subfungsi->row()->subfungsi;
			$data['content'] = $this->load->view('form_master_data/form_edit_subfungsi',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function hapus($KodeFungsi, $KodeSubFungsi){
		$this->gm->delete2('data_menu_kegiatan','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$this->gm->delete2('data_ikk','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$this->gm->delete2('data_iku','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$this->gm->delete2('data_kegiatan','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$this->gm->delete2('data_program','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$this->gm->delete2('data_sub_fungsi','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$kegiatan = '';
		$ikk = '';
		foreach($this->gm->get_double_where('ref_kegiatan','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi)->result() as $row){
			$kegiatan[$row->KodeKegiatan]=$row->KodeKegiatan;
		}
		foreach($this->gm->get_where_in('ref_ikk','KodeKegiatan',$kegiatan)->result() as $row){
			$ikk[$row->KodeIkk]=$row->KodeIkk;
		}
		$this->gm->delete_in('ref_satker_kegiatan', 'KodeKegiatan', $kegiatan);
		$this->gm->delete_in('ref_satker_ikk', 'KodeIkk', $ikk);
		$this->gm->delete_in('ref_ikk', 'KodeKegiatan', $kegiatan);
		$this->gm->delete_in('ref_menu_kegiatan', 'KodeKegiatan', $kegiatan);
		$this->gm->delete_double_param('ref_kegiatan','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$this->gm->delete_double_param('ref_sub_fungsi','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		redirect('master_data/master_sub_fungsi');
	}
}
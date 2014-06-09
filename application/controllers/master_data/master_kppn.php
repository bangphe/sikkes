<?php
/**
 * Kelas Master_kppn
 */
class Master_kppn extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/kppn_model');	
		$this->load->library('form_validation');
		$this->cek_session();
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
	 * Menampilkan tabel flexigrid
	 */
	function index()
	{		
		$this->grid();
	}
	
	function check_reference($kode){
		$referensi = $this->kppn_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}

	//melhat daftar flexigrid yang telah dibuat
	function grid()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['NMKPPN'] = array('Nama KPPN',250,TRUE,'left',1);
		$colModel['KPPN'] = array('Tipe KPPN',50,TRUE,'left',1);
		$colModel['ALMKPPN'] = array('Alamat KPPN',100,TRUE,'left',1);
		$colModel['KOTAKPPN'] = array('Kota/Kabupaten',100,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_kppn/list_grid";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_kppn/add';    
			}
			if (com=='Hapus'){
				if($('.trSelected',grid).length>0){
					if(confirm('Anda yakin ingin menghapus ' + $('.trSelected',grid).length + ' buah data?')){
						var items = $('.trSelected',grid);
						var itemlist ='';
						for(i=0;i<items.length;i++){
							itemlist+= items[i].id.substr(3)+',';
						}
						$.ajax({
						   type: 'POST',
						   url: '".site_url('/master_data/master_kppn/hapus')."', 
						   data: 'items='+itemlist,
						   success: function(data){
							$('#flex1').flexReload();
							alert(data);
						   }
						});
					}
				} else {
					return false;
				} 
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

		$data['judul'] = 'KPPN';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data kppn
	function list_grid() 
	{
	
		$valid_fields = array('KDKPPN','NMKPPN');
		$this->flexigrid->validate_post('KDKPPN','asc',$valid_fields);
		$records = $this->kppn_model->get_data_flexigrid();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KDKPPN,
										$no,
										$row->NMKPPN,
										$row->TIPEKPPN,
										$row->ALMKPPN,
										$row->KOTAKPPN,
										//$this->gm->get_double_where('ref_kabupaten','KOTAKPPN',$row->KOTAKPPN,'KDPROVINSI',$row->KDPROVINSI)->row()->NamaKabupaten,
								'<a href=\''.site_url().'/master_data/master_kppn/detail/'.$row->KDKPPN.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_kppn/edit/'.$row->KDKPPN.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_kppn/hapus/'.$row->KDKPPN.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_kppn_baru($value){
		if($this->kppn_model->cek_kppn_baru($value)){
			$this->form_validation->set_message('cek_kppn_baru',  'Nama KPPN '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_kppn($value, $kode_kppn){
		if($this->kppn_model->cek_kppn($value, $kode_kppn)){
			$this->form_validation->set_message('cek_kppn', 'Nama KPPN '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi(){
		$this->form_validation->set_rules('kode_kppn', 'Kode KPPN', 'required|max_length[3]');
		$this->form_validation->set_rules('tipe_kppn', 'Tipe KPPN', 'required');
		/*$this->form_validation->set_rules('KDKTUA', 'KDKTUA', 'required');
		$this->form_validation->set_rules('KDKANWIL', 'Kanwil', 'required');
		$this->form_validation->set_rules('KDDATIDUA', 'KDDATIDUA', 'required');
		$this->form_validation->set_rules('kode_prov', 'Provinsi', 'required');
		$this->form_validation->set_rules('kabupaten', 'Kota/Kabupaten', 'required');*/
		$this->form_validation->set_rules('nama_kppn', 'Nama KPPN', 'required');
		/*$this->form_validation->set_rules('alamat', 'Alamat KPPN', 'required');
		$this->form_validation->set_rules('telpon', 'Telpon KPPN', 'required');
		$this->form_validation->set_rules('email', 'Email KPPN', 'required');
		$this->form_validation->set_rules('KDKCBI', 'KDKCBI', 'required');
		$this->form_validation->set_rules('kodepos', 'Kode Pos', 'required');
		$this->form_validation->set_rules('fax', 'Fax', 'required');
		$this->form_validation->set_rules('KDDEFA', 'KDDEFA', 'required');*/
		
		return $this->form_validation->run();
	}
	
	//proses validasi kode
	function valid($kode){
		if($this->kppn_model->valid_kode($kode) == TRUE){
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	//proses penambahan satker
	function add()
	{		
		$opt_kanwil[0] = "--- Pilih Kanwil ---";
		$opt_prov[0] = "--- Pilih Provinsi ---";
		
		foreach($this->gm->get_data('ref_kanwil')->result() as $row){
			$opt_kanwil[$row->KDKANWIL] = $row->NMKANWIL;
		}
		
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$opt_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		
		$data['master_data'] = "";
		$data['option_kanwil'] = $opt_kanwil;
		$data['option_prov'] = $opt_prov;
		$data['content'] = $this->load->view('form_master_data/form_tambah_kppn',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_kppn()
	{
		if($this->cek_validasi() == true)
		{
			$data = array(
				'KDKPPN'		=> $this->input->post('kode_kppn'),
				'TIPEKPPN'		=> $this->input->post('tipe_kppn'),
				'KDKTUA'		=> $this->input->post('KDKTUA'),
				'KDKANWIL'		=> $this->input->post('KDKANWIL'),
				'KDDATIDUA'		=> $this->input->post('KDDATIDUA'),
				'KDPROVINSI'	=> $this->input->post('kode_prov'),
				'KOTAKPPN'		=> $this->input->post('kabupaten'),
				'NMKPPN'		=> $this->input->post('nama_kppn'),
				'ALMKPPN'		=> $this->input->post('alamat'),
				'TELKPPN'		=> $this->input->post('telpon'),
				'EMAIL'			=> $this->input->post('email'),
				'KDKCBI'		=> $this->input->post('KDKCBI'),
				'KODEPOS'		=> $this->input->post('kodepos'),
				'FAXKPPN' 		=> $this->input->post('fax'),
				'KDDEFA'		=> $this->input->post('KDDEFA')		 
			);
			$this->gm->add('ref_kppn',$data);
			redirect('master_data/master_kppn');
		} 
		else{
			$opt_kanwil[0] = "--- Pilih Kanwil ---";
			$opt_prov[0] = "--- Pilih Provinsi ---";
			
			foreach($this->gm->get_data('ref_kanwil')->result() as $row){
				$opt_kanwil[$row->KDKANWIL] = $row->NMKANWIL;
			}
			
			foreach($this->gm->get_data('ref_provinsi')->result() as $row){
				$opt_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
			}
			
			$data['master_data'] = "";
			$data['option_kanwil'] = $opt_kanwil;
			$data['option_prov'] = $opt_prov;
			$data['content'] = $this->load->view('form_master_data/form_tambah_kppn',$data,true);
			$this->load->view('main',$data);
		}	
	}
	
	//mengubah satker
	function edit($kode_kppn)
	{								
		$kppn = $this->gm->get_where('ref_kppn','KDKPPN',$kode_kppn)->row();
		$opt_kanwil;
		$opt_prov;
		$opt_kab;
		
		foreach($this->gm->get_data('ref_kanwil')->result() as $row){
			$opt_kanwil[$row->KDKANWIL] = $row->NMKANWIL;
		}
		
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$opt_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		
		foreach($this->gm->get_data('ref_kabupaten')->result() as $row){
			$opt_kab[$row->KodeKabupaten] = $row->NamaKabupaten;
		}
		
		$data['master_data'] = "";
		$data['option_kanwil'] = $opt_kanwil;
		$data['kanwil'] = $kppn->KDKANWIL;
		$data['option_prov'] = $opt_prov;
		$data['prov'] = $kppn->KDPROVINSI;
		$data['option_kab'] = $opt_kab;
		$data['kab'] = $this->gm->get_double_where('ref_kabupaten','KodeKabupaten',$kppn->KOTAKPPN,'KodeProvinsi',$kppn->KDPROVINSI)->row()->NamaKabupaten;
		$data['kode_kppn'] = $kode_kppn;
		$data['tipe'] = $kppn->TIPEKPPN;
		$data['kdktua'] = $kppn->KDKTUA;
		$data['kddatidua'] = $kppn->KDDATIDUA;
		$data['nama'] = $kppn->NMKPPN;
		$data['telp'] = $kppn->TELKPPN;
		$data['alamat'] = $kppn->ALMKPPN;
		$data['kddefa'] = $kppn->KDDEFA;
		$data['email'] = $kppn->EMAIL;
		$data['fax'] = $kppn->FAXKPPN;
		$data['kodepos'] = $kppn->KODEPOS;
		$data['content'] = $this->load->view('form_master_data/form_edit_kppn',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_kppn($kode_kppn){
		if($this->cek_validasi() == true)
		{
			$data = array(
				'KDKPPN'		=> $this->input->post('kode_kppn'),
				'TIPEKPPN'		=> $this->input->post('tipe_kppn'),
				'KDKTUA'		=> $this->input->post('KDKTUA'),
				'KDKANWIL'		=> $this->input->post('KDKANWIL'),
				'KDDATIDUA'		=> $this->input->post('KDDATIDUA'),
				'KDPROVINSI'	=> $this->input->post('kode_prov'),
				'KOTAKPPN'		=> $this->input->post('kabupaten'),
				'NMKPPN'		=> $this->input->post('nama_kppn'),
				'ALMKPPN'		=> $this->input->post('alamat'),
				'TELKPPN'		=> $this->input->post('telpon'),
				'EMAIL'			=> $this->input->post('email'),
				'KDKCBI'		=> $this->input->post('KDKCBI'),
				'KODEPOS'		=> $this->input->post('kodepos'),
				'FAXKPPN' 		=> $this->input->post('fax'),
				'KDDEFA'		=> $this->input->post('KDDEFA')		 
			);
			$this->gm->update('ref_kppn',$data,'KDKPPN',$kode_kppn);
			redirect('master_data/master_kppn');
		} 
		else{
			$this->edit($kode_kppn);	
		}
	}
	
	function hapus($kode_kppn)
	{	
		$this->gm->delete('ref_kppn', 'KDKPPN', $kode_kppn);
		redirect('master_data/master_kppn');
	}
	
	function get_prov($kode)
	{
		$query = $this->gm->get_where('ref_provinsi', 'KodeProvinsi', $kode);
		$i=0;
		foreach($query->result() as $kab)
		{
			$datajson[$i]['KodeProvinsi'] = $kab->KodeProvinsi;
			$datajson[$i]['NamaProvinsi'] = $kab->NamaProvinsi;
			$i++;
		}
		
		echo json_encode($datajson);
	}
	
	function detail($kode_kppn)
	{
		$kppn = $this->gm->get_where('ref_kppn','KDKPPN',$kode_kppn)->row();
		$opt_kanwil;
		$opt_prov;
		$opt_kab;
		
		foreach($this->gm->get_data('ref_kanwil')->result() as $row){
			$opt_kanwil[$row->KDKANWIL] = $row->NMKANWIL;
		}
		
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$opt_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		
		foreach($this->gm->get_data('ref_kabupaten')->result() as $row){
			$opt_kab[$row->KodeKabupaten] = $row->NamaKabupaten;
		}
		
		$data['master_data'] = "";
		$data['option_kanwil'] = $opt_kanwil;
		$data['kanwil'] = $kppn->KDKANWIL;
		$data['option_prov'] = $opt_prov;
		$data['prov'] = $kppn->KDPROVINSI;
		$data['option_kab'] = $opt_kab;
		$data['kab'] = $this->gm->get_double_where('ref_kabupaten','KodeKabupaten',$kppn->KOTAKPPN,'KodeProvinsi',$kppn->KDPROVINSI)->row()->NamaKabupaten;
		$data['kode_kppn'] = $kode_kppn;
		$data['tipe'] = $kppn->TIPEKPPN;
		$data['kdktua'] = $kppn->KDKTUA;
		$data['kddatidua'] = $kppn->KDDATIDUA;
		$data['nama'] = $kppn->NMKPPN;
		$data['telp'] = $kppn->TELKPPN;
		$data['alamat'] = $kppn->ALMKPPN;
		$data['kddefa'] = $kppn->KDDEFA;
		$data['email'] = $kppn->EMAIL;
		$data['fax'] = $kppn->FAXKPPN;
		$data['kodepos'] = $kppn->KODEPOS;
		$data['content'] = $this->load->view('form_master_data/form_detail_kppn',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_kppn class

/* End of file master_kppn.php */
/* Location: ./application/controllers/master_kppn.php */

<?php
/**
 * Kelas Master_kanwil
 */
class Master_kanwil extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/kanwil_model');	
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
	 * Menampilkan tabel kanwil kanwil
	 */
	function index()
	{		
		redirect ('master_data/master_kanwil/grid_kanwil');
	}
	
	// function cek_session()
	 // {	
		// $kode_role = $this->session->userdata('kode_role');
		// if($kode_role == '' || ($kode_role != 1 && $kode_role != 2))
		// {
			// redirect('login/login_ulang');
		// }
	 // }

	//melhat kanwil user yang telah dibuat
	function grid_kanwil()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['NMKANWIL'] = array('Nama Kanwil',400,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_kanwil/list_kanwil";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_kanwil/add_process';    
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
						   url: '".site_url('/master_data/master_kanwil/hapus_kanwil')."', 
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

		$data['judul'] = 'Kanwil';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data kanwil
	function list_kanwil() 
	{
		$valid_fields = array('KDKANWIL','NMKANWIL');
		$this->flexigrid->validate_post('KDKANWIL','asc',$valid_fields);
		$records = $this->kanwil_model->get_data_flexigrid_kanwil();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KDKANWIL,
										$no,
										$row->NMKANWIL,
								'<a href=\''.site_url().'/master_data/master_kanwil/detail_kanwil/'.$row->KDKANWIL.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_kanwil/edit_proses/'.$row->KDKANWIL.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_kanwil/hapus_kanwil/'.$row->KDKANWIL.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_kanwil_baru($value){
		if($this->kanwil_model->cek_kanwil_baru($value)){
			$this->form_validation->set_message('cek_kanwil_baru',  'Nama Kanwil '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_kanwil($value, $kode_kanwil){
		if($this->kanwil_model->cek_kanwil($value, $kode_kanwil)){
			$this->form_validation->set_message('cek_kanwil', 'Nama Kanwil '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_kanwil)
	{
		if($edit == true)
		{
			$NMKANWIL = '|callback_cek_kanwil['.$kode_kanwil.']';
		}
		else
		{
			$NMKANWIL = '|callback_cek_kanwil_baru';
		}
		$this->form_validation->set_rules('NMKANWIL', 'Nama Kanwil', 'required'.$NMKANWIL);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function valid($kode){
		if($this->kanwil_model->valid($kode) == TRUE){
			echo 'FALSE';
		}
		else{
			echo 'TRUE';
		}
	}
	
	//proses penambahan kanwil
	function add_process()
	{	
		$option_prov;
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$data['master_data'] = "";
		$data['provinsi'] = $option_prov;
		$data['content'] = $this->load->view('form_master_data/form_tambah_kanwil',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_kanwil()
	{
		if($this->cek_validasi(false,'') == true)
		{
			$data = array(
				'KDKANWIL' 		=> $this->input->post('KDKANWIL'),
				'NMKANWIL'		=> $this->input->post('NMKANWIL'),
				'KDROMAWI'		=> $this->input->post('KDROMAWI'),
				'KDPROVINSI'	=> $this->input->post('KDPROVINSI')			 
			);
			$this->kanwil_model->add($data);
			redirect('master_data/master_kanwil');
		} 
		else{
			$option_prov;
			foreach($this->gm->get_data('ref_provinsi')->result() as $row){
				$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
			}
			$data['master_data'] = "";
			$data['provinsi'] = $option_prov;
			$data['content'] = $this->load->view('form_master_data/form_tambah_kanwil',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	//mengubah kanwil
	function edit_proses($kode_kanwil)
	{								
		/*if ($this->cek_validasi(true,$kode_kanwil) == true) 
		{
			$this->load->helper('security');
			
			$region = array('Satuan'	=> $this->input->post('Satuan')
						 
						);
						
			//$this->kanwil_model->update($kode_kanwil $kanwil);
			redirect('master_data/master_kanwil');
		}
		else{
			$kanwil = $this->kanwil_model->get_kanwil($kode_kanwil);
			$data['master_data'] = "";
			$data['Satuan'] = $kanwil->row()->Satuan;
			$data['content'] = $this->load->view('form_master_data/form_edit_kanwil',$data,true);
			$this->load->view('main',$data);
		}*/
		$kanwil = $this->gm->get_where('ref_kanwil','KDKANWIL',$kode_kanwil);
		$option_prov;
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$data['master_data'] = "";
		$data['provinsi'] = $option_prov;
		$data['NMKANWIL'] = $kanwil->row()->NMKANWIL;
		$data['KDKANWIL'] = $kode_kanwil;
		$data['KDROMAWI'] = $kanwil->row()->KDROMAWI;
		$data['KDPROV'] = $kanwil->row()->KDPROVINSI;
		$data['content'] = $this->load->view('form_master_data/form_edit_kanwil',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_kanwil($kode_kanwil){
		if ($this->cek_validasi(true, $kode_kanwil) == true){
			$data = array(
				'KDKANWIL' 		=> $this->input->post('KDKANWIL'),
				'NMKANWIL'		=> $this->input->post('NMKANWIL'),
				'KDROMAWI'		=> $this->input->post('KDROMAWI'),
				'KDPROVINSI'	=> $this->input->post('KDPROVINSI')	
			);
			$this->gm->update('ref_kanwil',$data,'KDKANWIL',$kode_kanwil);
			redirect('master_data/master_kanwil');
		}else{
			$kanwil = $this->gm->get_where('ref_kanwil','KDKANWIL',$kode_kanwil);
			$option_prov;
			foreach($this->gm->get_data('ref_provinsi')->result() as $row){
				$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
			}
			$data['master_data'] = "";
			$data['provinsi'] = $option_prov;
			$data['NMKANWIL'] = $kanwil->row()->NMKANWIL;
			$data['KDKANWIL'] = $kode_kanwil;
			$data['KDROMAWI'] = $kanwil->row()->KDROMAWI;
			$data['KDPROV'] = $kanwil->row()->KDPROVINSI;
			$data['content'] = $this->load->view('form_master_data/form_edit_kanwil',$data,true);
			$this->load->view('main',$data);
		}
	}

	
	function hapus_kanwil($kode)
	{	
		/*$KDKANWIL = split(",",$this->input->post('items'));
		$msg = '';
		
		foreach($KDKANWIL as $kode){
			if($kode != ''){
				if($this->check_reference($kode) == FALSE)
					$msg ='Proses hapus gagal. Data yang anda pilih direferensi oleh tabel lain';
				else if (isset($kode) && !empty($kode))
				{
					$this->kanwil_model->hapus_kanwil($kode);
					$msg .= "Data kanwil dengan ID (".$kode.") telah berhasil dihapus.\n";
				}
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);*/
		$this->gm->delete('ref_kanwil', 'KDKANWIL', $kode);
		redirect('master_data/master_kanwil');
	}
	
	function check_reference($kode){
		$referensi = $this->kanwil_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//menambahkan detail kanwil
	function detail_kanwil($kode_kanwil)
	{
		$kanwil = $this->gm->get_where('ref_kanwil','KDKANWIL',$kode_kanwil);
		$option_prov;
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$data['master_data'] = "";
		$data['provinsi'] = $option_prov;
		$data['NMKANWIL'] = $kanwil->row()->NMKANWIL;
		$data['KDKANWIL'] = $kode_kanwil;
		$data['KDROMAWI'] = $kanwil->row()->KDROMAWI;
		$data['KDPROV'] = $kanwil->row()->KDPROVINSI;
		$data['content'] = $this->load->view('form_master_data/form_detail_kanwil',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_kanwil class

/* End of file master_kanwil.php */
/* Location: ./application/controllers/master_kanwil.php */

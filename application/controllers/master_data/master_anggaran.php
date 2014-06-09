<?php
/**
 * Kelas Master_anggaran
 */
class Master_anggaran extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/anggaran_model');	
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
	 * Menampilkan tabel daftar anggaran
	 */
	function index()
	{		
		redirect ('master_data/master_anggaran/grid_daftar');
	}
	
	// function cek_session()
	 // {	
		// $kode_role = $this->session->userdata('kode_role');
		// if($kode_role == '' || ($kode_role != 1 && $kode_role != 2))
		// {
			// redirect('login/login_ulang');
		// }
	 // }

	//melhat daftar user yang telah dibuat
	function grid_daftar()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['TAHUN_ANGGARAN'] = array('Tahun Anggaran',250,TRUE,'center',1);
		
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
		$buttons[] = array('Hapus','delete','spt_js');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_anggaran/grid_anggaran";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_anggaran/add_process';    
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
						   url: '".site_url('/master_data/master_anggaran/hapus_anggaran')."', 
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
		$data['judul'] = 'Master Anggaran';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data anggaran
	function grid_anggaran() 
	{
	
		$valid_fields = array('idThnAnggaran','thn_anggaran');
		$this->flexigrid->validate_post('idThnAnggaran','asc',$valid_fields);
		$records = $this->anggaran_model->get_data_flexigrid_anggaran();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->idThnAnggaran,
										$no,
										$row->thn_anggaran,
								'<a href=\''.site_url().'/master_data/master_anggaran/edit_proses/'.$row->idThnAnggaran.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_anggaran_baru($value){
		if($this->anggaran_model->cek_anggaran_baru($value)){
			$this->form_validation->set_message('cek_anggaran_baru',  'Tahun anggaran '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_anggaran($value, $kode_anggaran){
		if($this->anggaran_model->cek_anggaran($value, $kode_anggaran)){
			$this->form_validation->set_message('cek_anggaran', 'TAhun Anggaran '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_anggaran)
	{
		if($edit == true)
		{
			$TahunAnggaran = '|callback_cek_anggaran['.$kode_anggaran.']';
		}
		else
		{
			$TahunAnggaran = '|callback_cek_anggaran_baru';
		}
		$this->form_validation->set_rules('TahunAnggaran', 'Tahun Anggaran', 'required'.$TahunAnggaran);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
//proses penambahan anggaran
	function add_process()
	{		
		if($this->cek_validasi(false,'') == true)
		{
			$region = array('NamaProvinsi'	=> $this->input->post('NamaProvinsi')
						 
						);
			$this->anggaran_model->add($anggaran);
			redirect('master_data/master_anggaran');
		} 
		else{
			$data['content'] = $this->load->view('form_master_data/form_master_anggaran',null,true);
			$this->load->view('main',$data);
		}
	}
	
	//mengubah anggaran
	function edit_proses($kode_anggaran)
	{								
		if ($this->cek_validasi(true,$kode_anggaran) == true) 
		{
			$this->load->helper('security');
			
			$region = array('NamaProvinsi'	=> $this->input->post('NamaProvinsi')
						 
						);
						
			//$this->anggaran_model->update($kode_anggaran $anggaran);
			redirect('master_data/master_anggaran');
		}
		else{
			$anggaran = $this->anggaran_model->get_anggaran($kode_anggaran);
		
			$data['TahunAnggaran'] = $anggaran->row()->thn_anggaran;
			$data['content'] = $this->load->view('form_master_data/form_edit_anggaran',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function hapus_anggaran()
	{	
		$KKDEPT = split(",",$this->input->post('items'));
		$msg = '';
		
		foreach($Kodeanggaran as $kode){
			if($kode != ''){
				if($this->check_reference($kode) == FALSE)
					$msg ='Proses hapus gagal. Data yang anda pilih direferensi oleh tabel lain';
				else if (isset($kode) && !empty($kode))
				{
					$this->anggaran_model->hapus_anggaran($kode);
					$msg .= "Data anggaran dengan ID (".$kode.") telah berhasil dihapus.\n";
				}
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);
	}
	
	function check_reference($kode){
		$referensi = $this->anggaran_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
} 
// END master_anggaran class

/* End of file master_anggaran.php */
/* Location: ./application/controllers/master_anggaran.php */

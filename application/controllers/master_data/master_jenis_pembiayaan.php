<?php
/**
 * Kelas Master_jenis_pembiayaan
 */
class Master_jenis_pembiayaan extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/jenis_pembiayaan_model');	
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
	 * Menampilkan tabel jenis_pembiayaan jenis_pembiayaan
	 */
	function index()
	{		
		redirect ('master_data/master_jenis_pembiayaan/grid_jenis_pembiayaan');
	}
	
	// function cek_session()
	 // {	
		// $kode_role = $this->session->userdata('kode_role');
		// if($kode_role == '' || ($kode_role != 1 && $kode_role != 2))
		// {
			// redirect('login/login_ulang');
		// }
	 // }

	//melhat jenis_pembiayaan user yang telah dibuat
	function grid_jenis_pembiayaan()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['JenisPembiayaan'] = array('Jenis Pembiayaan',400,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_jenis_pembiayaan/list_jenis_pembiayaan";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_jenis_pembiayaan/add_process';    
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
						   url: '".site_url('/master_data/master_jenis_pembiayaan/hapus_jenis_pembiayaan')."', 
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

		$data['judul'] = 'Jenis Pembiayaan';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data jenis_pembiayaan
	function list_jenis_pembiayaan() 
	{
		$valid_fields = array('KodeJenisPembiayaan','JenisPembiayaan');
		$this->flexigrid->validate_post('KodeJenisPembiayaan','asc',$valid_fields);
		$records = $this->jenis_pembiayaan_model->get_data_flexigrid_jenis_pembiayaan();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KodeJenisPembiayaan,
										$no,
										$row->JenisPembiayaan,
								'<a href=\''.site_url().'/master_data/master_jenis_pembiayaan/detail_jenis_pembiayaan/'.$row->KodeJenisPembiayaan.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_jenis_pembiayaan/edit_proses/'.$row->KodeJenisPembiayaan.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_jenis_pembiayaan/hapus_jenis_pembiayaan/'.$row->KodeJenisPembiayaan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_jenis_pembiayaan_baru($value){
		if($this->jenis_pembiayaan_model->cek_jenis_pembiayaan_baru($value)){
			$this->form_validation->set_message('cek_jenis_pembiayaan_baru',  'Jenis Pembiayaan '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_jenis_pembiayaan($value, $kode_jenis_pembiayaan){
		if($this->jenis_pembiayaan_model->cek_jenis_pembiayaan($value, $kode_jenis_pembiayaan)){
			$this->form_validation->set_message('cek_jenis_pembiayaan', 'Jenis Pembiayaan '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_jenis_pembiayaan)
	{
		if($edit == true)
		{
			$JenisPembiayaan = '|callback_cek_jenis_pembiayaan['.$kode_jenis_pembiayaan.']';
		}
		else
		{
			$JenisPembiayaan = '|callback_cek_jenis_pembiayaan_baru';
		}
		$this->form_validation->set_rules('JenisPembiayaan', 'Jenis Pembiayaan', 'required'.$JenisPembiayaan);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}

//proses penambahan jenis_pembiayaan
	function add_process()
	{		
		$this->form_validation->set_rules('JenisPembiayaan', 'JenisPembiayaan', 'required');
		$pembiayaan = $this->input->post('JenisPembiayaan');
		$compare = $this->jenis_pembiayaan_model->cek_jenis_pembiayaan_baru($pembiayaan);
		if($this->form_validation->run() == TRUE and $compare == FALSE)
		{
			$data = array(
				'JenisPembiayaan'	=> $this->input->post('JenisPembiayaan') 
			);
			$this->gm->add('ref_jenis_pembiayaan', $data);
			redirect('master_data/master_jenis_pembiayaan');
		} 
		else{
			$data['master_data'] = "";
			$data['content'] = $this->load->view('form_master_data/form_tambah_jenis_pembiayaan',null,true);
			$this->load->view('main',$data);
		}
	}
	
	//mengubah jenis_pembiayaan
	function edit_proses($kode_jenis_pembiayaan)
	{								
		/*if ($this->cek_validasi(true,$kode_jenis_pembiayaan) == true) 
		{
			$this->load->helper('security');
			
			$region = array('Satuan'	=> $this->input->post('Satuan')
						 
						);
						
			//$this->jenis_pembiayaan_model->update($kode_jenis_pembiayaan $jenis_pembiayaan);
			redirect('master_data/master_jenis_pembiayaan');
		}
		else{
			$jenis_pembiayaan = $this->jenis_pembiayaan_model->get_jenis_pembiayaan($kode_jenis_pembiayaan);
			$data['master_data'] = "";
			$data['Satuan'] = $jenis_pembiayaan->row()->Satuan;
			$data['content'] = $this->load->view('form_master_data/form_edit_jenis_pembiayaan',$data,true);
			$this->load->view('main',$data);
		}*/
		$jenis_pembiayaan = $this->gm->get_where('ref_jenis_pembiayaan','KodeJenisPembiayaan',$kode_jenis_pembiayaan);
		$data['master_data'] = "";
		$data['JenisPembiayaan'] = $jenis_pembiayaan->row()->JenisPembiayaan;
		$data['KodeJenisPembiayaan'] = $kode_jenis_pembiayaan;
		$data['content'] = $this->load->view('form_master_data/form_edit_jenis_pembiayaan',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_jenis_pembiayaan($kode_jenis_pembiayaan){
		$pembiayaan = $this->input->post('JenisPembiayaan');
		$compare = $this->jenis_pembiayaan_model->cek_jenis_pembiayaan_baru($pembiayaan);
		if($compare == FALSE){

			$data = array(
				'KodeJenisPembiayaan'	=> $this->input->post('KodeJenisPembiayaan'),
				'JenisPembiayaan' 		=> $this->input->post('JenisPembiayaan')
			);
			$this->gm->update('ref_jenis_pembiayaan',$data,'KodeJenisPembiayaan',$kode_jenis_pembiayaan);
			redirect('master_data/master_jenis_pembiayaan');
		}else{
			$data['master_data'] = "";
			//$data_jenis_pembiayaan = $this->gm->get_where('ref_jenis_pembiayaan','KodeJenisPembiayaan',$KodeJenisPembiayaan);
			$data['JenisPembiayaan'] = "";
			$data['KodeJenisPembiayaan'] = $kode_jenis_pembiayaan;
			$data['content'] = $this->load->view('form_master_data/form_edit_jenis_pembiayaan',$data,true);
			$this->load->view('main',$data);
		}
	}

	
	function hapus_jenis_pembiayaan($kode)
	{	
		/*$KodeJenisPembiayaan = split(",",$this->input->post('items'));
		$msg = '';
		
		foreach($KodeJenisPembiayaan as $kode){
			if($kode != ''){
				if($this->check_reference($kode) == FALSE)
					$msg ='Proses hapus gagal. Data yang anda pilih direferensi oleh tabel lain';
				else if (isset($kode) && !empty($kode))
				{
					$this->jenis_pembiayaan_model->hapus_jenis_pembiayaan($kode);
					$msg .= "Data jenis_pembiayaan dengan ID (".$kode.") telah berhasil dihapus.\n";
				}
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);*/
		$this->gm->delete('ref_jenis_pembiayaan', 'KodeJenisPembiayaan', $kode);
		redirect('master_data/master_jenis_pembiayaan');
	}
	
	function check_reference($kode){
		$referensi = $this->jenis_pembiayaan_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//menambahkan detail jenis_pembiayaan
	function detail_jenis_pembiayaan($kode_jenis_pembiayaan)
	{
		$jenis_pembiayaan = $this->gm->get_where('ref_jenis_pembiayaan','KodeJenisPembiayaan',$kode_jenis_pembiayaan);
		$data['master_data'] = "";
		$data['JenisPembiayaan'] = $jenis_pembiayaan->row()->JenisPembiayaan;
		$data['KodeJenisPembiayaan'] = $kode_jenis_pembiayaan;
		$data['content'] = $this->load->view('form_master_data/form_detail_jenis_pembiayaan',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_jenis_pembiayaan class

/* End of file master_jenis_pembiayaan.php */
/* Location: ./application/controllers/master_jenis_pembiayaan.php */

<?php
/**
 * Kelas Master_jenis_kewenangan
 */
class Master_jenis_kewenangan extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/jenis_kewenangan_model');	
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
	 * Menampilkan tabel daftar satker
	 */
	function index()
	{		
		redirect ('master_data/master_jenis_kewenangan/grid_jenis_kewenangan');
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
	function grid_jenis_kewenangan()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['JenisSatker'] = array('Nama Jenis Kewenangan',250,TRUE,'left',1);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		$colModel['UBAH'] = array('Ubah',50,TRUE,'center',0);
		// $colModel['HAPUS'] = array('Hapus',50,TRUE,'center',0);
		
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
		// $buttons[] = array('Tambah','add','spt_js');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_jenis_kewenangan/list_jenis_satker";
		// $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_jenis_kewenangan/add';    
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
						   url: '".site_url('/master_data/master_jenis_kewenangan/hapus')."', 
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

		$data['judul'] = 'Jenis Kewenangan';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data satker
	function list_jenis_satker() 
	{
		$valid_fields = array('KodeJenisSatker','JenisSatker');
		$this->flexigrid->validate_post('KodeJenisSatker','asc',$valid_fields);
		$records = $this->jenis_kewenangan_model->get_data_flexigrid();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->KodeJenisSatker,
				$no,
				$row->JenisSatker,
				'<a href=\''.site_url().'/master_data/master_jenis_kewenangan/detail/'.$row->KodeJenisSatker.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href=\''.site_url().'/master_data/master_jenis_kewenangan/edit_proses/'.$row->KodeJenisSatker.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				// '<a href='.site_url().'/master_data/master_jenis_kewenangan/hapus/'.$row->KodeJenisSatker.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
		);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_jenis_satker_baru($value){
		if($this->jenis_kewenangan_model->cek_jenis_satker_baru($value)){
			$this->form_validation->set_message('cek_jenis_satker_baru',  'Nama satker '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_jenis_satker($value, $kode_jenis_satker){
		if($this->jenis_kewenangan_model->cek_jenis_satker($value, $kode_jenis_satker)){
			$this->form_validation->set_message('cek_jenis_satker', 'Nama satker '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_jenis_satker)
	{
		if($edit == true)
		{
			$JenisSatker = '|callback_cek_jenis_satker['.$kode_jenis_satker.']';
		}
		else
		{
			$JenisSatker = '|callback_cek_jenis_satker_baru';
		}
		$this->form_validation->set_rules('JenisSatker', 'Jenis Satker', 'required'.$JenisSatker);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function valid($kode)
	{
		if ($this->jenis_kewenangan_model->valid($kode) == TRUE)
		{
			$this->form_validation->set_message('valid', "Kode Jenis Satker dengan kode $kode sudah terdaftar");
			return FALSE;
		}
		else
		{			
			return TRUE;
		}
	}
	
	function add()
	{
		$data['content'] = $this->load->view('form_master_data/form_tambah_jenis_satker', null, true);
		$this->load->view('main', $data);	
	}
	
	//proses penambahan satker
	function add_process()
	{
		if($this->cek_validasi(true, '') == TRUE)
		{
			$data = array(
				'JenisSatker' => $this->input->post('JenisSatker')
			);
			$this->jenis_kewenangan_model->add($data);
			redirect('master_data/master_jenis_kewenangan');	
		}
		else
		{
			$this->add();	
		}
	}
	
	//mengubah satker
	function edit_proses($kode_jenis_satker)
	{								
		/*if ($this->cek_validasi(true,$kode_jenis_satker) == true) 
		{
			$this->load->helper('security');
			
			$region = array('JenisSatker'	=> $this->input->post('JenisSatker')
						 
						);
						
			//$this->jenis_kewenangan_model->update($kode_jenis_satker $satker);
			redirect('master_data/master_jenis_kewenangan');
		}
		else{
			$data['master_data'] = "";
			$satker = $this->jenis_kewenangan_model->get_jenis_satker($kode_jenis_satker);
			$data['master_data'] = "";
			$data['JenisSatker'] = $satker->row()->JenisSatker;
			$data['content'] = $this->load->view('form_master_data/form_edit_jenis_kewenangan',$data,true);
			$this->load->view('main',$data);
		}*/
		$satker = $this->gm->get_where('ref_jenis_satker', 'KodeJenisSatker', $kode_jenis_satker);
		
		$data['master_data'] = "";
		$data['KodeJenisSatker'] = $kode_jenis_satker;
		$data['JenisSatker'] = $satker->row()->JenisSatker;
		$data['content'] = $this->load->view('form_master_data/form_edit_jenis_kewenangan', $data, true);
		$this->load->view('main', $data);
	}
	
	function update($kode){
		if ($this->cek_validasi(true, '') == true){
			$data = array(
				'JenisSatker'		=> $this->input->post('JenisSatker')
			);
			//$this->jenis_kewenangan_model->update('KodeJenisSatker',$kode,'JenisSatker',$data);
			$this->gm->update('ref_jenis_satker',$data,'KodeJenisSatker',$kode);
			redirect('master_data/master_jenis_kewenangan');
		}else{
			$this->edit_proses($kode);
		}	
	}
	
	function hapus($kode_jenis_satker)
	{	
		/*$KKDEPT = split(",",$this->input->post('items'));
		$msg = '';
		
		foreach($kode_jenis_satker as $kode){
			if($kode != ''){
				if($this->check_reference($kode) == FALSE)
					$msg ='Proses hapus gagal. Data yang anda pilih direferensi oleh tabel lain';
				else if (isset($kode) && !empty($kode))
				{
					$this->jenis_kewenangan_model->hapus_jenis_satker($kode);
					$msg .= "Data satker dengan ID (".$kode.") telah berhasil dihapus.\n";
				}
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);*/
		$this->gm->delete('ref_jenis_satker', 'KodeJenisSatker', $kode_jenis_satker);
		redirect('master_data/master_jenis_kewenangan');
	}
	
	function check_reference($kode){
		$referensi = $this->jenis_kewenangan_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//detail satker
	function detail($kode_jenis_satker)
	{
		$satker = $this->gm->get_where('ref_jenis_satker', 'KodeJenisSatker', $kode_jenis_satker);
		
		$data['master_data'] = "";
		$data['KodeJenisSatker'] = $kode_jenis_satker;
		$data['JenisSatker'] = $satker->row()->JenisSatker;
		$data['content'] = $this->load->view('form_master_data/form_detail_jenis_kewenangan', $data, true);
		$this->load->view('main', $data);
	}
} 
// END Master_jenis_kewenangan class

/* End of file Master_jenis_kewenangan.php */
/* Location: ./application/controllers/Master_jenis_kewenangan.php */

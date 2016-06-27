<?php
/**
 * Kelas Master_satuan
 */
class Master_satuan extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/satuan_model');	
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
	 * Menampilkan tabel satuan satuan
	 */
	function index()
	{		
		redirect ('master_data/master_satuan/grid_satuan');
	}
	
	// function cek_session()
	 // {	
		// $kode_role = $this->session->userdata('kode_role');
		// if($kode_role == '' || ($kode_role != 1 && $kode_role != 2))
		// {
			// redirect('login/login_ulang');
		// }
	 // }

	//melhat satuan user yang telah dibuat
	function grid_satuan()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['SATUAN'] = array('Nama Satuan',400,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_satuan/list_satuan";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_satuan/add_process';    
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
						   url: '".site_url('/master_data/master_satuan/hapus_satuan')."', 
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

		$data['judul'] = 'Master Satuan';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data satuan
	function list_satuan() 
	{
		$valid_fields = array('KodeSatuan','Satuan');
		$this->flexigrid->validate_post('KodeSatuan','asc',$valid_fields);
		$records = $this->satuan_model->get_data_flexigrid_satuan();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KodeSatuan,
										$no,
										$row->Satuan,
								'<a href=\''.site_url().'/master_data/master_satuan/detail_satuan/'.$row->KodeSatuan.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_satuan/edit_proses/'.$row->KodeSatuan.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_satuan/hapus_satuan/'.$row->KodeSatuan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_satuan_baru($value){
		if($this->satuan_model->cek_satuan_baru($value)){
			$this->form_validation->set_message('cek_satuan_baru',  'Nama Satuan '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_satuan($value, $kode_satuan){
		if($this->satuan_model->cek_satuan($value, $kode_satuan)){
			$this->form_validation->set_message('cek_satuan', 'Nama Satuan '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_satuan)
	{
		if($edit == true)
		{
			$Satuan = '|callback_cek_satuan['.$kode_satuan.']';
		}
		else
		{
			$Satuan = '|callback_cek_satuan_baru';
		}
		$this->form_validation->set_rules('Satuan', 'Nama Satuan', 'required'.$Satuan);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
//proses penambahan satuan
	function add_process()
	{	
		$this->form_validation->set_rules('nmsatuan', 'nmsatuan', 'required');
		$satuan = $this->input->post('nmsatuan');
		$compare = $this->satuan_model->cek_satuan_baru($satuan);
		if($this->form_validation->run() == TRUE and $compare == FALSE)
		{
			$data = array(
				'Satuan'		=> $this->input->post('nmsatuan')		 
			);
			$this->gm->add('ref_satuan', $data);
			redirect('master_data/master_satuan');
		} 
		else{
			$data['master_data'] = "";
			$data['content'] = $this->load->view('form_master_data/form_tambah_satuan',null,true);
			$this->load->view('main',$data);
		}
	}
	
	//mengubah satuan
	function edit_proses($kode_satuan)
	{								
		/*if ($this->cek_validasi(true,$kode_satuan) == true) 
		{
			$this->load->helper('security');
			
			$region = array('Satuan'	=> $this->input->post('Satuan')
						 
						);
						
			//$this->satuan_model->update($kode_satuan $satuan);
			redirect('master_data/master_satuan');
		}
		else{
			$satuan = $this->satuan_model->get_satuan($kode_satuan);
			$data['master_data'] = "";
			$data['Satuan'] = $satuan->row()->Satuan;
			$data['content'] = $this->load->view('form_master_data/form_edit_satuan',$data,true);
			$this->load->view('main',$data);
		}*/
		$satuan = $this->gm->get_where('ref_satuan','KodeSatuan',$kode_satuan);
		$data['master_data'] = "";
		$data['Satuan'] = $satuan->row()->Satuan;
		$data['KodeSatuan'] = $kode_satuan;
		$data['content'] = $this->load->view('form_master_data/form_edit_satuan',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_satuan($kode_satuan){
		$satuan = $this->input->post('Satuan');
		$compare = $this->satuan_model->cek_satuan_baru($satuan);
		if($compare == FALSE){
			$data_satuan = array('Satuan' => $this->input->post('Satuan'));
			$this->gm->update('ref_satuan',$data_satuan,'KodeSatuan',$kode_satuan);
			redirect('master_data/master_satuan');
		}else{
			$data['master_data'] = "";
			//$data_satuan = $this->gm->get_where('ref_satuan','KodeSatuan',$KodeSatuan);
			$data['Satuan'] = "";
			$data['KodeSatuan'] = $kode_satuan;
			$data['content'] = $this->load->view('form_master_data/form_edit_satuan',$data,true);
			$this->load->view('main',$data);
		}
	}

	
	function hapus_satuan($kode)
	{	
		/*$KodeSatuan = split(",",$this->input->post('items'));
		$msg = '';
		
		foreach($KodeSatuan as $kode){
			if($kode != ''){
				if($this->check_reference($kode) == FALSE)
					$msg ='Proses hapus gagal. Data yang anda pilih direferensi oleh tabel lain';
				else if (isset($kode) && !empty($kode))
				{
					$this->satuan_model->hapus_satuan($kode);
					$msg .= "Data satuan dengan ID (".$kode.") telah berhasil dihapus.\n";
				}
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);*/
		$this->gm->delete('ref_satuan', 'KodeSatuan', $kode);
		redirect('master_data/master_satuan');
	}
	
	function check_reference($kode){
		$referensi = $this->satuan_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//menambahkan detail satuan
	function detail_satuan($kode_satuan)
	{
		$satuan = $this->gm->get_where('ref_satuan','KodeSatuan',$kode_satuan);
		$data['master_data'] = "";
		$data['Satuan'] = $satuan->row()->Satuan;
		$data['KodeSatuan'] = $kode_satuan;
		$data['content'] = $this->load->view('form_master_data/form_detail_satuan',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_satuan class

/* End of file master_satuan.php */
/* Location: ./application/controllers/master_satuan.php */

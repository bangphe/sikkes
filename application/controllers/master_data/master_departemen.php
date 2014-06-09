<?php
/**
 * Kelas Master_departemen
 */
class Master_departemen extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/departemen_model');	
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
	 * Menampilkan tabel daftar departemen
	 */
	function index()
	{		
		redirect ('master_data/master_departemen/grid_daftar');
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
		$colModel['NMDEPT'] = array('Nama Departemen',400,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_departemen/grid_departemen";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_departemen/add_process';    
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
						   url: '".site_url('/master_data/master_departemen/hapus')."', 
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

		$data['judul'] = 'Master Departemen';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data departemen
	function grid_departemen() 
	{
		$valid_fields = array('KDDEPT','NMDEPT');
		$this->flexigrid->validate_post('KDDEPT','asc',$valid_fields);
		$records = $this->departemen_model->get_data_flexigrid_departemen();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KDDEPT,
										$no,
										$row->NMDEPT,
								'<a href=\''.site_url().'/master_data/master_departemen/detail_dept/'.$row->KDDEPT.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_departemen/edit_proses/'.$row->KDDEPT.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_departemen/hapus/'.$row->KDDEPT.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_departemen_baru($value){
		if($this->departemen_model->cek_departemen_baru($value)){
			$this->form_validation->set_message('cek_departemen_baru',  'Nama Departemen '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_departemen($value, $kode_dept){
		if($this->departemen_model->cek_departemen($value, $kode_dept)){
			$this->form_validation->set_message('cek_departemen', 'Nama Departemen '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_dept)
	{
		if($edit == true)
		{
			$NMDEPT = '|callback_cek_departemen['.$kode_dept.']';
		}
		else
		{
			$NMDEPT = '|callback_cek_departemen_baru';
		}
		$this->form_validation->set_rules('NMDEPT', 'dept', 'required'.$NMDEPT);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function valid($kode)
	{
		if ($this->departemen_model->valid($kode) == TRUE)
		{
			echo 'FALSE';
			//$this->form_validation->set_message('valid', "Kode Departemen dengan kode $kode sudah terdaftar");
			//return FALSE;
		}
		else
		{
			echo 'TRUE';
			//return TRUE;
		}
	}
	
//proses penambahan departemen	
	function add_process()
	{	
		// $this->form_validation->set_rules('KDDEPT', 'KDDEPT', 'required|exact_length[3]|numeric|callback_valid');
		$this->form_validation->set_rules('NMDEPT', 'NMDEPT', 'required');
		$nmdept = $this->input->post('NMDEPT');
		$compare = $this->departemen_model->cek_departemen_baru($nmdept);
		// $nmdept = $this->input->post('NMDEPT');
		// $compare = $this->gm->get_where('ref_dept','NMDEPT',$nmdept)->result();
		if($this->form_validation->run() == TRUE and $compare == FALSE)
		{
			$data = array(
				'KDDEPT'	=> $this->gm->get_max('ref_dept','KDDEPT')+1,
				'NMDEPT'	=> $this->input->post('NMDEPT')
			);
			$this->departemen_model->add($data);
			redirect('master_data/master_departemen');
		}
		else{
			$data['master_data'] = "";
			$data['content'] = $this->load->view('form_master_data/form_master_departemen',null,true);
			$this->load->view('main',$data);
		}
	}
	
	//mengubah departemen
	function edit_proses($kode_dept)
	{
		// $this->form_validation->set_rules('KDDEPT', 'KDDEPT', 'required|exact_length[3]|numeric|callback_valid');	
		// $this->form_validation->set_rules('NMDEPT', 'NMDEPT', 'required');	
		/*if ($this->cek_validasi(true,$kode_dept) == true) 
		{
			$this->load->helper('security');
			
			$region = array('NMDEPT'	=> $this->input->post('NMDEPT')
						 
						);
						
			//$this->departemen_model->update($kode_dept $departemen);
			redirect('master_data/master_departemen');
		}
		else{
			$departemen = $this->departemen_model->get_departemen($kode_dept);
			$data['master_data'] = "";
			$data['NMDEPT'] = $departemen->row()->NMDEPT;
			$data['content'] = $this->load->view('form_master_data/form_edit_departemen',$data,true);
			$this->load->view('main',$data);
		}*/
		// if($this->form_validation->run() == TRUE)
		// {
			$departemen = $this->gm->get_where('ref_dept','KDDEPT',$kode_dept);
			$data['master_data'] = "";
			$data['NMDEPT'] = $departemen->row()->NMDEPT;
			$data['KDDEPT'] = $kode_dept;
			$data['content'] = $this->load->view('form_master_data/form_edit_departemen',$data,true);
			$this->load->view('main',$data);
		// }
		// else{
			// redirect('form_master_data/form_edit_departemen');
		// }
	}
	
	function update_departemen($kode_dept){
		//if($this->form_validation->run() == TRUE)
		$nmdept = $this->input->post('NMDEPT');
		$compare = $this->departemen_model->cek_departemen_baru($nmdept);
		if($compare == FALSE){
		//if ($this->cek_validasi() == true){
			$data_departemen = array(
				'KDDEPT'	=> $this->input->post('KDDEPT'),
				'NMDEPT'	=> $this->input->post('NMDEPT')			
			);
			$this->gm->update('ref_dept',$data_departemen,'KDDEPT',$kode_dept);
			redirect('master_data/master_departemen');
		}else{
			$this->form_validation->set_message('valid', "Nama Departemen telah terdaftar");
			$data['master_data'] = "";
			// foreach ($this->gm->get_where('ref_dept','KDDEPT',$KDDEPT)->result() as $row){
			// $data_departemen = $row->NMDEPT;}
			//$data['NMDEPT'] = $data_departemen->row()->NMDEPT;
			$data['NMDEPT'] = "";
			$data['KDDEPT'] = $kode_dept;
			$data['content'] = $this->load->view('form_master_data/form_edit_departemen',$data,true);
			$this->load->view('main',$data);
		}
	}

	
	/*function hapus_departemen()
	{	
		$KDDEPT = split(",",$this->input->post('items'));
		$msg = '';
		
		foreach($KDDEPT as $kode){
			if($kode != ''){
				if($this->check_reference($kode) == FALSE)
					$msg ='Proses hapus gagal. Data yang anda pilih direferensi oleh tabel lain';
				else if (isset($kode) && !empty($kode))
				{
					$this->departemen_model->hapus_departemen($kode);
					$msg .= "Data departemen dengan ID (".$kode.") telah berhasil dihapus.\n";
				}
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);
	}*/
	
	function hapus($kode){	
		$this->gm->delete('ref_dept','KDDEPT',$kode);
		redirect('master_data/master_departemen');
	}
	
	function check_reference($kode){
		$referensi = $this->departemen_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//menambahkan detail departemen
	function detail_dept($kode_dept)
	{
		$departemen = $this->gm->get_where('ref_dept','KDDEPT',$kode_dept);
		$data['master_data'] = "";
		$data['NMDEPT'] = $departemen->row()->NMDEPT;
		$data['KDDEPT'] = $kode_dept;
		$data['content'] = $this->load->view('form_master_data/form_detail_departemen',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_departemen class

/* End of file master_departemen.php */
/* Location: ./application/controllers/master_departemen.php */

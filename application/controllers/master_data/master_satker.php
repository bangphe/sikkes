<?php
/**
 * Kelas Master_satker
 */
class Master_satker extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/satker_model');	
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
		redirect ('master_data/master_satker/grid_daftar');
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
		$colModel['nmsatker'] = array('Nama Satker',250,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_satker/grid_satker";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_satker/add_process';    
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
						   url: '".site_url('/master_data/master_satker/hapus_satker')."', 
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

		$data['judul'] = 'Satker';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data satker
	function grid_satker() 
	{
	
		$valid_fields = array('kdsatker','nmsatker');
		$this->flexigrid->validate_post('kdsatker','asc',$valid_fields);
		$records = $this->satker_model->get_data_flexigrid_satker();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->kdsatker,
										$no,
										$row->nmsatker,
								'<a href=\''.site_url().'/master_data/master_satker/detail_satker/'.$row->kdsatker.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_satker/edit_proses/'.$row->kdsatker.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_satker/hapus/'.$row->kdsatker.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_satker_baru($value){
		if($this->satker_model->cek_satker_baru($value)){
			$this->form_validation->set_message('cek_satker_baru',  'Nama satker '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_satker($value, $kode_satker){
		if($this->satker_model->cek_satker($value, $kode_satker)){
			$this->form_validation->set_message('cek_satker', 'Nama satker '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_satker)
	{
		if($edit == true)
		{
			$nmsatker = '|callback_cek_satker['.$kode_satker.']';
		}
		else
		{
			$nmsatker = '|callback_cek_satker_baru';
		}
		$this->form_validation->set_rules('kdsatker', 'Kode Satker', 'required');
		$this->form_validation->set_rules('nmsatker', 'Nama Satker', 'required'.$nmsatker);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	//proses validasi kode
	function valid($kode){
		if($this->satker_model->valid_kode($kode) == TRUE){
		//	$this->form_validation->set_message('validasi_kode', 'Kode $kode telah dipakai!!');
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	//proses penambahan satker
	function add_process()
	{		
		$option_dept;
		$option_dept['0']='--- Pilih Departemen ---';
		foreach($this->gm->get_data('ref_dept')->result() as $row){
			$option_dept[$row->KDDEPT] = "[".$row->KDDEPT."] - ".$row->NMDEPT;	
		}
		$option_unit;
		$option_unit['0']='--- Pilih Unit ---';
		foreach($this->gm->get_data('ref_unit')->result() as $row){
			$option_unit[$row->KDUNIT] = "[".$row->KDUNIT."] - ".$row->NMUNIT;	
		}
		$option_prov;
		$option_prov['0']='--- Pilih Provinsi ---';
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = "[".$row->KodeProvinsi."] - ".$row->NamaProvinsi;	
		}
		$option_kppn;
		$option_kppn['0']='--- Pilih KPPN ---';
		foreach($this->gm->get_data('ref_kppn')->result() as $row){
			$option_kppn[$row->KDKPPN] = $row->NMKPPN;	
		}
		$option_jnssat;
		$option_jnssat['0']='--- Pilih Jenis Satker ---';
		foreach($this->gm->get_data('t_jnssat')->result() as $row){
			$option_jnssat[$row->kdjnssat] = $row->nmjnssat;	
		}
		/*$option_kab;
		foreach($this->gm->get_data('ref_kabupaten')->result() as $row){
			$option_kab[$row->KodeKabupaten] = "[".$row->KodeKabupaten."] - ".$row->NamaKabupaten;	
		}*/
		$data['master_data'] = "";
		$data['option_dept'] = $option_dept;
		$data['option_unit'] = $option_unit;
		$data['option_prov'] = $option_prov;
		$data['option_kppn'] = $option_kppn;
		$data['option_jnssat'] = $option_jnssat;
		//$data['option_kab']  = $option_kab;
		$data['content'] = $this->load->view('form_master_data/form_master_satker',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_satker()
	{
		if($this->cek_validasi(false,'') == true)
		{
			//input ref_satker
			$ref_satker = array(
				'kdsatker'	=> $this->input->post('kdsatker'),
				'kdinduk'	=> $this->input->post('kdinduk'),
				'nmsatker'	=> $this->input->post('nmsatker'),
				'kddept'	=> $this->input->post('dept'),
				'kdunit'	=> $this->input->post('unit'),
				'kdlokasi'	=> $this->input->post('prov'),
				'kdkabkota'	=> $this->input->post('kabupaten'),
				'nomorsp'	=> $this->input->post('nomorsp'),
				'kdkppn'	=> $this->input->post('kdkppn'),
				'kdjnssat'	=> $this->input->post('kdjnssat')			 
			);
			$this->gm->add('ref_satker',$ref_satker);
			
			//input t_satker
			$t_satker = array(
				'kdsatker'	=> $this->input->post('kdsatker'),
				'kdinduk'	=> $this->input->post('kdinduk'),
				'nmsatker'	=> $this->input->post('nmsatker'),
				'kddept'	=> $this->input->post('dept'),
				'kdunit'	=> $this->input->post('unit'),
				'kdlokasi'	=> $this->input->post('prov'),
				'kdkabkota'	=> $this->input->post('kabupaten'),
				'nomorsp'	=> $this->input->post('nomorsp'),
				'kdkppn'	=> $this->input->post('kdkppn'),
				'kdjnssat'	=> $this->input->post('kdjnssat')			 
			);
			$this->gm->add('t_satker',$t_satker);
			redirect('e-planning/master/kemampuan_satker/'.$this->input->post('kdsatker'));
		} 
		else{
			$data['master_data'] = "";
			$data['content'] = $this->load->view('form_master_data/form_master_satker',null,true);
			$this->load->view('main',$data);
		}	
	}
	
	//mengubah satker
	function edit_proses($kode_satker)
	{								
		/*if ($this->cek_validasi(true,$kode_satker) == true) 
		{
			$this->load->helper('security');
			
			$region = array('nmsatker'	=> $this->input->post('nmsatker')
						 
						);
						
			//$this->satker_model->update($kode_satker $satker);
			redirect('master_data/master_satker');
		}
		else{
			$data['master_data'] = "";
			$satker = $this->satker_model->get_satker($kode_satker);
			$data['master_data'] = "";
			$data['nmsatker'] = $satker->row()->nmsatker;
			$data['content'] = $this->load->view('form_master_data/form_edit_satker',$data,true);
			$this->load->view('main',$data);
		}*/
		$satker = $this->gm->get_where('ref_satker', 'kdsatker', $kode_satker);
		$option_dept;
		foreach($this->gm->get_data('ref_dept')->result() as $row){
			$option_dept[$row->KDDEPT] = "[".$row->KDDEPT."] - ".$row->NMDEPT;	
		}
		$option_unit;
		foreach($this->gm->get_data('ref_unit')->result() as $row){
			$option_unit[$row->KDUNIT] = "[".$row->KDUNIT."] - ".$row->NMUNIT;	
		}
		$option_prov;
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = "[".$row->KodeProvinsi."] - ".$row->NamaProvinsi;	
		}
		$option_kppn;
		foreach($this->gm->get_data('ref_kppn')->result() as $row){
			$option_kppn[$row->KDKPPN] = $row->NMKPPN;	
		}
		$option_jnssat;
		foreach($this->gm->get_data('t_jnssat')->result() as $row){
			$option_jnssat[$row->kdjnssat] = $row->nmjnssat;	
		}
		$data['master_data'] = "";
		$data['option_dept'] = $option_dept;
		$data['option_unit'] = $option_unit;
		$data['option_prov'] = $option_prov;
		$data['option_kppn'] = $option_kppn;
		$data['option_jnssat'] = $option_jnssat;
		$data['kdsatker'] = $kode_satker;
		$data['kdinduk'] = $satker->row()->kdinduk;
		$data['nmsatker'] = $satker->row()->nmsatker;
		$data['selected_dept'] = $satker->row()->kddept;
		$data['selected_unit'] = $satker->row()->kdunit;
		$data['selected_loc'] = $satker->row()->kdlokasi;
		
		foreach($this->gm->get_where('ref_kabupaten','KodeProvinsi',$data['selected_loc'])->result() as $row)
			$option_kab[$row->KodeKabupaten] = $row->NamaKabupaten;
		$data['opt_kab'] = $option_kab;
		
		$data['selected_kab'] = $satker->row()->kdkabkota;
		// $data['kab'] = $this->gm->get_double_where('ref_kabupaten','KodeKabupaten',$satker->row()->kdkabkota,'KodeProvinsi',$satker->row()->kdlokasi)->row()->NamaKabupaten;
		$data['nomorsp'] = $satker->row()->nomorsp;
		$data['kppn'] = $satker->row()->kdkppn;
		$data['kdjnssat'] = $satker->row()->kdjnssat;
		$data['content'] = $this->load->view('form_master_data/form_edit_satker', $data, true);
		$this->load->view('main', $data);
	}
	
	function update_satker($kode_satker){
		// if ($this->cek_validasi(true, $kode_satker) == true){
			$ref_satker = array(
				'kdsatker'	=> $this->input->post('kdsatker'),
				'kdinduk'	=> $this->input->post('kdinduk'),
				'nmsatker'	=> $this->input->post('nmsatker'),
				'kddept'	=> $this->input->post('dept'),
				'kdunit'	=> $this->input->post('unit'),
				'kdlokasi'	=> $this->input->post('prov'),
				'kdkabkota'	=> $this->input->post('kabupaten'),
				'nomorsp'	=> $this->input->post('nomorsp'),
				'kdkppn'	=> $this->input->post('kdkppn'),
				'kdjnssat'	=> $this->input->post('kdjnssat')			 
			);
			$this->gm->update('ref_satker',$ref_satker,'kdsatker',$kode_satker);
			
			//input t_satker
			$t_satker = array(
				'kdsatker'	=> $this->input->post('kdsatker'),
				'kdinduk'	=> $this->input->post('kdinduk'),
				'nmsatker'	=> $this->input->post('nmsatker'),
				'kddept'	=> $this->input->post('dept'),
				'kdunit'	=> $this->input->post('unit'),
				'kdlokasi'	=> $this->input->post('prov'),
				'kdkabkota'	=> $this->input->post('kabupaten'),
				'nomorsp'	=> $this->input->post('nomorsp'),
				'kdkppn'	=> $this->input->post('kdkppn'),
				'kdjnssat'	=> $this->input->post('kdjnssat')			 
			);
			$this->gm->update('t_satker',$t_satker,'kdsatker',$kode_satker);
			redirect('master_data/master_satker');
		// }else{
			// $this->edit_proses($kode_satker);
		// }	
	}
	
	function hapus($kode_satker)
	{	
		/*$KKDEPT = split(",",$this->input->post('items'));
		$msg = '';
		
		foreach($kode_satker as $kode){
			if($kode != ''){
				if($this->check_reference($kode) == FALSE)
					$msg ='Proses hapus gagal. Data yang anda pilih direferensi oleh tabel lain';
				else if (isset($kode) && !empty($kode))
				{
					$this->satker_model->hapus_satker($kode);
					$msg .= "Data satker dengan ID (".$kode.") telah berhasil dihapus.\n";
				}
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);*/
		$this->gm->delete('ref_satker', 'kdsatker', $kode_satker);
		$this->gm->delete('t_satker', 'kdsatker', $kode_satker);
		redirect('master_data/master_satker');
	}
	
	function check_reference($kode){
		$referensi = $this->satker_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//detail satker
	function detail_satker($kode_satker)
	{
		$satker = $this->gm->get_where('ref_satker', 'kdsatker', $kode_satker);
		$option_dept;
		foreach($this->gm->get_data('ref_dept')->result() as $row){
			$option_dept[$row->KDDEPT] = "[".$row->KDDEPT."] - ".$row->NMDEPT;	
		}
		$option_unit;
		foreach($this->gm->get_data('ref_unit')->result() as $row){
			$option_unit[$row->KDUNIT] = "[".$row->KDUNIT."] - ".$row->NMUNIT;	
		}
		$option_prov;
		foreach($this->gm->get_data('ref_provinsi')->result() as $row){
			$option_prov[$row->KodeProvinsi] = "[".$row->KodeProvinsi."] - ".$row->NamaProvinsi;	
		}
		$option_kppn;
		foreach($this->gm->get_data('ref_kppn')->result() as $row){
			$option_kppn[$row->KDKPPN] = $row->NMKPPN;	
		}
		$option_jnssat;
		foreach($this->gm->get_data('t_jnssat')->result() as $row){
			$option_jnssat[$row->kdjnssat] = $row->nmjnssat;	
		}
		$data['master_data'] = "";
		$data['option_dept'] = $option_dept;
		$data['option_unit'] = $option_unit;
		$data['option_prov'] = $option_prov;
		$data['option_kppn'] = $option_kppn;
		$data['option_jnssat'] = $option_jnssat;
		$data['kdsatker'] = $kode_satker;
		$data['kdinduk'] = $satker->row()->kdinduk;
		$data['nmsatker'] = $satker->row()->nmsatker;
		$data['selected_dept'] = $satker->row()->kddept;
		$data['selected_unit'] = $satker->row()->kdunit;
		$data['selected_loc'] = $satker->row()->kdlokasi;
		foreach($this->gm->get_where('ref_kabupaten','KodeProvinsi',$data['selected_loc'])->result() as $row)
			$option_kab[$row->KodeKabupaten] = $row->NamaKabupaten;
		$data['opt_kab'] = $option_kab;
		
		$data['selected_kab'] = $satker->row()->kdkabkota;
		$data['nomorsp'] = $satker->row()->nomorsp;
		$data['kppn'] = $satker->row()->kdkppn;
		$data['kdjnssat'] = $satker->row()->kdjnssat;
		$data['content'] = $this->load->view('form_master_data/form_detail_satker', $data, true);
		$this->load->view('main', $data);
	}
} 
// END master_satker class

/* End of file master_satker.php */
/* Location: ./application/controllers/master_satker.php */

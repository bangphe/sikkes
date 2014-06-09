<?php
/**
 * Kelas Master_unit
 */
class Master_unit extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/unit_model');	
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
	 * Menampilkan tabel unit unit
	 */
	function index()
	{		
		redirect ('master_data/master_unit/grid_unit');
	}
	
	// function cek_session()
	 // {	
		// $kode_role = $this->session->userdata('kode_role');
		// if($kode_role == '' || ($kode_role != 1 && $kode_role != 2))
		// {
			// redirect('login/login_ulang');
		// }
	 // }

	//melhat unit user yang telah dibuat
	function grid_unit()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['NMUNIT'] = array('Nama Unit',400,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_unit/list_unit";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_unit/add_process';    
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
						   url: '".site_url('/master_data/master_unit/hapus_unit')."', 
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

		$data['judul'] = 'Unit';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data unit
	function list_unit() 
	{
		$valid_fields = array('KDUNIT','NMUNIT');
		$this->flexigrid->validate_post('KDUNIT','asc',$valid_fields);
		$records = $this->unit_model->get_data_flexigrid_unit();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KDUNIT,
										$no,
										$row->NMUNIT,
								'<a href=\''.site_url().'/master_data/master_unit/detail_unit/'.$row->KDUNIT.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_unit/edit_proses/'.$row->KDUNIT.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_unit/hapus_unit/'.$row->KDUNIT.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_unit_baru($value){
		if($this->unit_model->cek_unit_baru($value)){
			$this->form_validation->set_message('cek_unit_baru',  'Nama Kanwil '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_unit($value, $kode_unit){
		if($this->unit_model->cek_unit($value, $kode_unit)){
			$this->form_validation->set_message('cek_unit', 'Nama Kanwil '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_unit)
	{
		if($edit == true)
		{
			$NMUNIT = '|callback_cek_unit['.$kode_unit.']';
		}
		else
		{
			$NMUNIT = '|callback_cek_unit_baru';
		}
		$this->form_validation->set_rules('NMUNIT', 'Nama Unit', 'required'.$NMUNIT);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function valid($kode){
		if($this->unit_model->valid($kode) == TRUE)
		{
			echo 'FALSE';
		}
		else{
			echo 'TRUE';
		}
	}
	
	//proses penambahan unit
	function add_process()
	{	
		$option_dept;
		foreach($this->gm->get_data('ref_dept')->result() as $row){
			$option_dept[$row->KDDEPT] = $row->KDDEPT;	
		}
		$data['master_data'] = "";
		$data['option_dept'] = $option_dept;
		$data['kode_dept'] = '024';
		$data['content'] = $this->load->view('form_master_data/form_tambah_unit',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_unit()
	{
		$this->form_validation->set_rules('KDUNIT','Kode Unit','required');
		
		if($this->form_validation->run() == true)
		{
			//input ref_unit
			$unit = array(
				'KDDEPT' 		=> '024',
				'KDUNIT'		=> $this->input->post('KDUNIT'),
				'NMUNIT'		=> $this->input->post('NMUNIT')
			);
			$this->gm->add('ref_unit', $unit);
			
			//input t_unit
			$t_unit = array(
				'kddept' 		=> '024',
				'kdunit'		=> $this->input->post('KDUNIT'),
				'nmunit'		=> $this->input->post('NMUNIT')
			);
			$this->gm->add('t_unit', $t_unit);
			redirect('master_data/master_unit');
		} 
		else{
			$data['master_data'] = "";
			$data['content'] = $this->load->view('form_master_data/form_tambah_unit',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	//mengubah unit
	function edit_proses($kode_unit)
	{								
		/*if ($this->cek_validasi(true,$kode_unit) == true) 
		{
			$this->load->helper('security');
			
			$region = array('Satuan'	=> $this->input->post('Satuan')
						 
						);
						
			//$this->unit_model->update($kode_unit $unit);
			redirect('master_data/master_unit');
		}
		else{
			$unit = $this->unit_model->get_unit($kode_unit);
			$data['master_data'] = "";
			$data['Satuan'] = $unit->row()->Satuan;
			$data['content'] = $this->load->view('form_master_data/form_edit_unit',$data,true);
			$this->load->view('main',$data);
		}*/
		$unit = $this->gm->get_where('ref_unit','KDUNIT',$kode_unit);
		$option_dept;
		foreach($this->gm->get_data('ref_dept')->result() as $row){
			$option_dept[$row->KDDEPT] = $row->KDDEPT;	
		}
		$data['master_data'] = "";
		$data['dept'] = $option_dept;
		$data['NMUNIT'] = $unit->row()->NMUNIT;
		$data['kode_dept'] = '024';
		$data['KDUNIT'] = $kode_unit;
		$data['content'] = $this->load->view('form_master_data/form_edit_unit',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_unit($kode_unit){
		if ($this->cek_validasi() == true){
			//update ref_unit
			$data = array(
				'KDDEPT' 		=> '024',
				'KDUNIT'		=> $this->input->post('KDUNIT'),
				'NMUNIT'		=> $this->input->post('NMUNIT')
			);
			$this->gm->update('ref_unit',$data,'KDUNIT',$kode_unit);
			
			//update t_unit
			$t_unit = array(
				'kddept' 		=> '024',
				'kdunit'		=> $this->input->post('KDUNIT'),
				'nmunit'		=> $this->input->post('NMUNIT')
			);
			$this->gm->update('t_unit',$data,'kdunit',$kode_unit);
			redirect('master_data/master_unit');
			redirect('master_data/master_unit');
		}else{
			$unit = $this->gm->get_where('ref_unit','KDUNIT',$kode_unit);
			$option_dept;
			foreach($this->gm->get_data('ref_dept')->result() as $row){
				$option_dept[$row->KDDEPT] = $row->KDDEPT;	
			}
			$data['master_data'] = "";
			$data['dept'] = $option_dept;
			$data['NMUNIT'] = $unit->row()->NMUNIT;
			$data['kode_dept'] = '024';
			$data['KDUNIT'] = $kode_unit;
			$data['content'] = $this->load->view('form_master_data/form_edit_unit',$data,true);
			$this->load->view('main',$data);
		}
	}

	
	function hapus_unit($kode)
	{	
		/*$KDUNIT = split(",",$this->input->post('items'));
		$msg = '';
		
		foreach($KDUNIT as $kode){
			if($kode != ''){
				if($this->check_reference($kode) == FALSE)
					$msg ='Proses hapus gagal. Data yang anda pilih direferensi oleh tabel lain';
				else if (isset($kode) && !empty($kode))
				{
					$this->unit_model->hapus_unit($kode);
					$msg .= "Data unit dengan ID (".$kode.") telah berhasil dihapus.\n";
				}
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);*/
		$this->gm->delete('ref_unit', 'KDUNIT', $kode);
		$this->gm->delete('t_unit', 'kdunit', $kode);
		redirect('master_data/master_unit');
	}
	
	function check_reference($kode){
		$referensi = $this->unit_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//menambahkan detail unit
	function detail_unit($kode_unit)
	{
		$unit = $this->gm->get_where('ref_unit','KDUNIT',$kode_unit);
		$option_dept;
		foreach($this->gm->get_data('ref_dept')->result() as $row){
			$option_dept[$row->KDDEPT] = $row->KDDEPT;	
		}
		$data['master_data'] = "";
		$data['dept'] = $option_dept;
		$data['kode_dept'] = '024';
		$data['NMUNIT'] = $unit->row()->NMUNIT;
		$data['KDUNIT'] = $kode_unit;
		$data['content'] = $this->load->view('form_master_data/form_detail_unit',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_unit class

/* End of file master_unit.php */
/* Location: ./application/controllers/master_unit.php */

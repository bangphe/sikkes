<?php
/**
 * Kelas Master_subfungsi
 */
class Master_subfungsi extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/subfungsi_model');	
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
	 * Menampilkan tabel daftar subfungsi
	 */
	function index()
	{		
		redirect ('master_data/master_subfungsi/grid_daftar');
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
		$colModel['KodeFungsi'] = array('Kode Fungsi',150,TRUE,'center',1);
		$colModel['KodeSubFungsi'] = array('Kode Sub Fungsi',150,TRUE,'center',1);
		$colModel['NamaSubFungsi'] = array('Nama Sub Fungsi',600,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_subfungsi/grid_subfungsi";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_subfungsi/add_process';    
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
						   url: '".site_url('/master_data/master_subfungsi/hapus_subfungsi')."', 
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
		$data['judul'] = 'Sub Fungsi';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data subfungsi
	function grid_subfungsi() 
	{
	
		$valid_fields = array('KodeFungsi','KodeSubFungsi','NamaSubFungsi');
		$this->flexigrid->validate_post('KodeFungsi','asc',$valid_fields);
		$records = $this->subfungsi_model->get_data_flexigrid_subfungsi();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KodeSubFungsi,
										$no,
										$row->KodeFungsi,
										$row->KodeSubFungsi,
										$row->NamaSubFungsi,
								'<a href=\''.site_url().'/master_data/master_subfungsi/detail_subfungsi/'.$row->KodeSubFungsi.'/'.$row->KodeFungsi.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_subfungsi/edit_proses/'.$row->KodeFungsi.'/'.$row->KodeSubFungsi.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_subfungsi/hapus_subfungsi/'.$row->KodeSubFungsi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_subfungsi_baru($value){
		if($this->subfungsi_model->cek_subfungsi_baru($value)){
			$this->form_validation->set_message('cek_subfungsi_baru',  'Nama subfungsi '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_subfungsi($value, $kode_subfungsi){
		if($this->subfungsi_model->cek_subfungsi($value, $kode_subfungsi)){
			$this->form_validation->set_message('cek_subfungsi', 'Nama subfungsi '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_subfungsi)
	{
		if($edit == true)
		{
			$NamaSubFungsi = '|callback_cek_subfungsi['.$kode_subfungsi.']';
		}
		else
		{
			$NamaSubFungsi = '|callback_cek_subfungsi_baru';
		}
		$this->form_validation->set_rules('NamaSubFungsi', 'Nama SubFungsi', 'required'.$NamaSubFungsi);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
//proses penambahan subfungsi
	/*function add_process()
	{		
		if($this->cek_validasi(false,'') == true)
		{
			$subfungsi = array('KodeSubFungsi'	=> $this->input->post('KodeSubFungsi'),
								'KodeFungsi'	=> $this->input->post('KodeFungsi'),
								'NamaSubFungsi'	=> $this->input->post('NamaSubFungsi')
						 
						);
			$this->subfungsi_model->add($subfungsi);
			redirect('master_data/master_subfungsi');
		} 
		else{
			$data['content'] = $this->load->view('form_master_data/form_tambah_subfungsi',null,true);
			$this->load->view('main',$data);
		}
	}*/
	
	//proses validasi kode
	function valid($kode){
		$kdfungsi = $this->input->get('x');
		if($this->subfungsi_model->valid_kode($kdfungsi,$kode) == TRUE){
		//	$this->form_validation->set_message('validasi_kode', 'Kode $kode telah dipakai!!');
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	function add_process()
	{		
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$option_fungsi;
		foreach($this->gm->get_data('ref_fungsi')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = $row->KodeFungsi;
		}
		$data['fungsi'] = $option_fungsi;
		$data['status'] = $option_status;
		$data['content'] = $this->load->view('form_master_data/form_tambah_subfungsi',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_subfungsi()
	{
		if($this->cek_validasi(false,'') == true)
		{
			$data = array(
				'KodeSubFungsi'	=> $this->input->post('KodeSubFungsi'),
				'KodeFungsi'	=> $this->input->post('KodeFungsi'),
				'NamaSubFungsi'	=> $this->input->post('NamaSubFungsi'),
				'KodeStatus' 	=> $this->input->post('KodeStatus')			 			 
			);
			$this->subfungsi_model->add($data);
			redirect('master_data/master_subfungsi');
		} 
		else{
			$option_status;
			foreach($this->gm->get_data('status_program')->result() as $row){
				$option_status[$row->KodeStatus] = $row->Status;
			}
			$option_fungsi;
			foreach($this->gm->get_data('ref_fungsi')->result() as $row){
				$option_fungsi[$row->KodeFungsi] = $row->KodeFungsi;
			}
			$data['fungsi'] = $option_fungsi;
			$data['status'] = $option_status;
			$data['content'] = $this->load->view('form_master_data/form_tambah_subfungsi',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	
	//mengubah sub fungsi
	function edit_proses($KodeFungsi, $KodeSubFungsi){
		$option_fungsi;
		foreach($this->gm->get_data('ref_fungsi')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = $row->KodeFungsi;
		}
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$subfungsi = $this->gm->get_double_where('ref_sub_fungsi','KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
		$data['opt_fungsi'] = $option_fungsi;
		$data['opt_status'] = $option_status;
		$data['stats'] = $subfungsi->row()->KodeStatus;
		$data['KodeFungsi'] = $KodeFungsi;
		$data['master_data'] = "";
		$data['NamaSubFungsi'] = $subfungsi->row()->NamaSubFungsi;
		$data['KodeSubFungsi'] = $KodeSubFungsi;
		$data['content'] = $this->load->view('form_master_data/form_edit_subfungsi',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_subfungsi($KodeFungsi, $KodeSubFungsi){
		$this->form_validation->set_rules('KodeFungsi', 'KDDEPT', 'required|exact_length[2]|numeric');	
		$this->form_validation->set_rules('KodeSubFungsi', 'NMDEPT', 'required');
		
		if ($this->form_validation->run() == true){
			$data_subfungsi = array(
				'KodeFungsi'	=> $this->input->post('KodeFungsi'),
				'KodeSubFungsi'	=> $this->input->post('KodeSubFungsi'),
				'NamaSubFungsi'	=> $this->input->post('NamaSubFungsi'),
				'KodeStatus' 	=> $this->input->post('KodeStatus')	
			);
			$this->subfungsi_model->update_double_where('ref_sub_fungsi',$data_subfungsi,'KodeFungsi',$KodeFungsi,'KodeSubFungsi',$KodeSubFungsi);
			//$this->gm->update('ref_sub_fungsi',$data_subfungsi,);
			redirect('master_data/master_subfungsi');
		}else{
			$this->edit_proses($KodeFungsi, $KodeSubFungsi);
		}
	}

	function hapus_subfungsi($KodeSubFungsi){
		$this->gm->delete('ref_sub_fungsi','KodeSubFungsi',$KodeSubFungsi);
		redirect('master_data/master_subfungsi');
	}
	
	function check_reference($kode){
		$referensi = $this->subfungsi_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//menambahkan detail subfungsi
	function detail_subfungsi($KodeSubFungsi, $KodeFungsi)
	{
		$option_fungsi;
		foreach($this->gm->get_data('ref_fungsi')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = $row->KodeFungsi;
		}
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$subfungsi = $this->gm->get_double_where('ref_sub_fungsi','KodeSubFungsi',$KodeSubFungsi,'KodeFungsi',$KodeFungsi);
		$data['KodeFungsi'] = $option_fungsi;
		$data['KodeStatus'] = $option_status;
		$data['status'] = $subfungsi->row()->KodeStatus;
		$data['fungsi'] = $KodeFungsi;
		$data['master_data'] = "";
		$data['NamaSubFungsi'] = $subfungsi->row()->NamaSubFungsi;
		$data['KodeSubFungsi'] = $KodeSubFungsi;
		$data['content'] = $this->load->view('form_master_data/form_detail_subfungsi',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_subfungsi class

/* End of file master_subfungsi.php */
/* Location: ./application/controllers/master_subfungsi.php */

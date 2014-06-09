<?php
/**
 * Kelas Master_jenis_usulan
 */
class Master_jenis_usulan extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/jenis_usulan_model');	
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
	 * Menampilkan tabel daftar Usulan
	 */
	function index()
	{		
		redirect ('master_data/master_jenis_usulan/grid_jenis_usulan');
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
	function grid_jenis_usulan()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['JenisUsulan'] = array('Nama Jenis Usulan',250,TRUE,'left',1);
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
							'nowrap' =>false
							);
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_jenis_usulan/list_jenis_usulan";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_jenis_usulan/add';    
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
						   url: '".site_url('/master_data/master_jenis_usulan/hapus')."', 
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

		$data['judul'] = 'Jenis Usulan';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data Usulan
	function list_jenis_usulan() 
	{
		$valid_fields = array('KodeJenisUsulan','JenisUsulan');
		$this->flexigrid->validate_post('KodeJenisUsulan','asc',$valid_fields);
		$records = $this->jenis_usulan_model->get_data_flexigrid_jenis_usulan();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KodeJenisUsulan,
										$no,
										$row->JenisUsulan,
								'<a href=\''.site_url().'/master_data/master_jenis_usulan/detail/'.$row->KodeJenisUsulan.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_jenis_usulan/edit_proses/'.$row->KodeJenisUsulan.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_jenis_usulan/hapus/'.$row->KodeJenisUsulan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_jenis_usulan_baru($value){
		if($this->jenis_usulan_model->cek_jenis_usulan_baru($value)){
			$this->form_validation->set_message('cek_jenis_usulan_baru',  'Nama Usulan '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_jenis_usulan($value, $kode_jenis_usulan){
		if($this->jenis_usulan_model->cek_jenis_usulan($value, $kode_jenis_usulan)){
			$this->form_validation->set_message('cek_jenis_usulan', 'Nama Usulan '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_jenis_usulan)
	{
		if($edit == true)
		{
			$JenisUsulan = '|callback_cek_jenis_usulan['.$kode_jenis_usulan.']';
		}
		else
		{
			$JenisUsulan = '|callback_cek_jenis_usulan_baru';
		}
		$this->form_validation->set_rules('JenisUsulan', 'Jenis Usulan', 'required'.$JenisUsulan);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function valid($kode)
	{
		if ($this->jenis_usulan_model->valid($kode) == TRUE)
		{
			$this->form_validation->set_message('valid', "Kode Jenis Usulan dengan kode $kode sudah terdaftar");
			return FALSE;
		}
		else
		{			
			return TRUE;
		}
	}
	
	function add()
	{
		$data['content'] = $this->load->view('form_master_data/form_tambah_jenis_usulan', null, true);
		$this->load->view('main', $data);	
	}
	
	//proses penambahan Usulan
	function add_process()
	{
		$this->form_validation->set_rules('JenisUsulan', 'JenisUsulan', 'required');
		$jenisusulan = $this->input->post('JenisUsulan');
		$compare = $this->jenis_usulan_model->cek_jenis_usulan_baru($jenisusulan);
		if($this->form_validation->run() == TRUE and $compare == FALSE)
		{
			$data = array(
				'JenisUsulan' => $this->input->post('JenisUsulan')
			);
			$this->jenis_usulan_model->add($data);
			redirect('master_data/master_jenis_usulan');	
		}
		else
		{
			$this->add();	
		}
	}
	
	//mengubah Usulan
	function edit_proses($kode_jenis_usulan)
	{								
		$usulan = $this->gm->get_where('ref_jenis_usulan', 'KodeJenisUsulan', $kode_jenis_usulan);
		
		$data['master_data'] = "";
		$data['KodeJenisUsulan'] = $kode_jenis_usulan;
		$data['JenisUsulan'] = $usulan->row()->JenisUsulan;
		$data['content'] = $this->load->view('form_master_data/form_edit_jenis_usulan', $data, true);
		$this->load->view('main', $data);
	}
	
	function update($kode){
		$jenisusulan = $this->input->post('JenisUsulan');
		$compare = $this->jenis_usulan_model->cek_jenis_usulan_baru($jenisusulan);
		if($compare == FALSE){
			$data = array(
				'JenisUsulan'		=> $this->input->post('JenisUsulan')
			);
			//$this->jenis_usulan_model->update('KodeJenisUsulan',$kode,'JenisUsulan',$data);
			$this->gm->update('ref_jenis_usulan',$data,'KodeJenisUsulan',$kode);
			redirect('master_data/master_jenis_usulan');
		}else{
			$this->edit_proses($kode);
		}	
	}
	
	function hapus($kode_jenis_usulan)
	{	
		$this->gm->delete('ref_jenis_usulan', 'KodeJenisUsulan', $kode_jenis_usulan);
		redirect('master_data/master_jenis_usulan');
	}
	
	function check_reference($kode){
		$referensi = $this->jenis_usulan_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//detail Usulan
	function detail($kode_jenis_usulan)
	{
		$usulan = $this->gm->get_where('ref_jenis_usulan', 'KodeJenisUsulan', $kode_jenis_usulan);
		
		$data['master_data'] = "";
		$data['KodeJenisUsulan'] = $kode_jenis_usulan;
		$data['JenisUsulan'] = $usulan->row()->JenisUsulan;
		$data['content'] = $this->load->view('form_master_data/form_detail_jenis_usulan', $data, true);
		$this->load->view('main', $data);
	}
} 
// END master_jenis_usulan class

/* End of file master_jenis_usulan.php */
/* Location: ./application/controllers/master_jenis_usulan.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_bank extends CI_Controller 
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');
		$this->load->model('e-monev/bank_model','bm');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	
	function index()
	{
		redirect ('e-monev/master_bank/grid_bank');
	}
	
	function grid_bank(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['nama_bank'] = array('Nama Bank',300,TRUE,'center',1);
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
							'showTableToggleBtn' => false
							);
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/e-monev/master_bank/list_bank";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/e-monev/master_bank/add';
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

		$data['judul'] = 'Bank';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_bank()
	{
		$valid_fields = array('bank_id','nama_bank');
		$this->flexigrid->validate_post('bank_id','asc',$valid_fields);
		$records = $this->bm->get_data_flexigrid_bank();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->bank_id,
				$no,
				$row->nama_bank,
				'<a href='.site_url().'/e-monev/master_bank/edit/'.$row->bank_id.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/e-monev/master_bank/hapus/'.$row->bank_id.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function validasi($bank){
		if($this->bm->cek_bank_baru($bank) == TRUE){
			return false;
		}
		else {
			return true;
		}
	}
	
	function validasi2($bank, $bank_id){
		if($this->bm->cek_bank($bank, $bank_id) == TRUE){
			return false;
		}
		else {
			return true;
		}
	}
	
	function add()
	{
		$data['content'] = $this->load->view('e-monev/form_tambah_bank',null,true);
		$this->load->view('main',$data);
	}
	
	function save_bank(){
		$this->form_validation->set_rules('nama_bank', 'nama_bank', 'required|callback_validasi');
		$this->form_validation->set_error_delimiters('<p style="color:#F40509">', '</p>');
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		$this->form_validation->set_message('callback_validasi', 'Nama bank %s sudah ada di database');
		if($this->form_validation->run())
		{
			$bank = array(
				'nama_bank' 	=> $this->input->post('nama_bank')
			);
			$this->bm->add($bank);
			redirect('e-monev/master_bank');
		}
		else
		{
			$this->add();
		}
	}
	
	function jajal()
	{
		$data['content'] = $this->load->view('form_input_progres',null,true);
		$this->load->view('main',$data);
	}
	
	function save_progres($id)
	{
		$config['upload_path'] = './tes/';
		$config['allowed_types'] = 'doc|docx|pdf|txt|jpg|jpeg';
		$config['max_size']  = '10240';

		$this->load->library('upload', $config);
		
		// create directory if doesn't exist
		if(!is_dir($config['upload_path']))	mkdir($config['upload_path'], 0777);
		
		$file='';
		if(!empty($_FILES['file']['name'])){			
			$upload = $this->upload->do_upload('file');
			$data = $this->upload->data('file');
			if($data['file_size'] > 0) $file = $data['file_name'];
		}
		echo 'sukses bro';
	}
	
	function edit($bank_id)
	{
		$bank = $this->bm->get_bank($bank_id);
		
		$data['nama_bank'] = $bank->row()->nama_bank;
		$data['bank_id'] = $bank_id;
		$data['content'] = $this->load->view('e-monev/form_edit_bank',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_bank($bank_id)
	{
		$this->form_validation->set_rules('nama_bank', 'nama_bank', 'required|callback_validasi2['.$bank_id.']');
		$this->form_validation->set_error_delimiters('<p style="color:#F40509">', '</p>');
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		$this->form_validation->set_message('callback_validasi', 'Nama bank %s sudah ada di database');
		if($this->form_validation->run())
		{
			$bank = array(
				'nama_bank' 	=> $this->input->post('nama_bank')
			);
			$this->bm->update($bank_id,$bank);
			redirect('e-monev/master_bank');
		}
		else
		{
			$this->edit();
		}
	}
	
	function hapus($bank_id)
	{
		$this->bm->hapus($bank_id);
		redirect('e-monev/master_bank');
	}
	
}//end class

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */

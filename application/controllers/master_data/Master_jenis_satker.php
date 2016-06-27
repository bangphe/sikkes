<?php
/**
 * Kelas Master_jenis_satker
 */
class Master_jenis_satker extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/jenis_satker_model');	
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
	 * Menampilkan tabel flexogrid
	 */
	function index()
	{		
		redirect ('master_data/master_jenis_satker/grid');
	}
	
	// function cek_session()
	 // {	
		// $kode_role = $this->session->userdata('kode_role');
		// if($kode_role == '' || ($kode_role != 1 && $kode_role != 2))
		// {
			// redirect('login/login_ulang');
		// }
	 // }

	//melhat jenis_satker user yang telah dibuat
	function grid()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['nmjnssat'] = array('Nama Jenis Satker',400,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_jenis_satker/list_jenis";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_jenis_satker/add';    
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
						   url: '".site_url('/master_data/master_jenis_satker/hapus')."', 
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

		$data['judul'] = 'Jenis Satker';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data jenis_satker
	function list_jenis() 
	{
		$valid_fields = array('kdjnssat','nmjnssat');
		$this->flexigrid->validate_post('kdjnssat','asc',$valid_fields);
		$records = $this->jenis_satker_model->get_data_flexigrid();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->kdjnssat,
										$no,
										$row->nmjnssat,
								'<a href=\''.site_url().'/master_data/master_jenis_satker/detail/'.$row->kdjnssat.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_jenis_satker/edit/'.$row->kdjnssat.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_jenis_satker/hapus/'.$row->kdjnssat.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_jenis_satker_baru($value){
		if($this->jenis_satker_model->cek_jenis_satker_baru($value)){
			$this->form_validation->set_message('cek_jenis_satker_baru',  'Nama nmjnssat '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_jenis_satker($value, $kode){
		if($this->jenis_satker_model->cek_jenis_satker($value, $kode)){
			$this->form_validation->set_message('cek_jenis_satker', 'Nama nmjnssat '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode)
	{
		if($edit == true)
		{
			$nmjnssat = '|callback_cek_jenis_satker['.$kode.']';
		}
		else
		{
			$nmjnssat = '|callback_cek_jenis_satker_baru';
		}
		$this->form_validation->set_rules('nmjnssat', 'Nama nmjnssat', 'required'.$nmjnssat);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	//proses penambahan jenis_satker
	function add()
	{	
		$this->form_validation->set_rules('JenisSatker', 'JenisSatker', 'required');
		$jenis_satker = $this->input->post('JenisSatker');
		$compare = $this->jenis_satker_model->cek_jenis_satker_baru($jenis_satker);
		
		//ambil nilai max
		$temp = $this->gm->get_max('t_jnssat','kdjnssat');
		if($this->form_validation->run() == TRUE and $compare == FALSE)
		{
			$data = array(
				'kdjnssat'	=> $temp+1,
				'nmjnssat'	=> $this->input->post('JenisSatker')		 
			);
			$this->gm->add('t_jnssat', $data);
			redirect('master_data/master_jenis_satker');
		} 
		else{
			$data['master_data'] = "";
			$data['content'] = $this->load->view('form_master_data/form_tambah_jenis_satker',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	//mengubah jenis_satker
	function edit($kode)
	{
		$jenis_satker = $this->gm->get_where('t_jnssat','kdjnssat',$kode);
		$data['master_data'] = "";
		$data['nmjnssat'] = $jenis_satker->row()->nmjnssat;
		$data['kdjnssat'] = $kode;
		$data['content'] = $this->load->view('form_master_data/form_edit_jenis_satker',$data,true);
		$this->load->view('main',$data);
	}
	
	function update($kode){
		$jenis_satker = $this->input->post('nmjnssat');
		$compare = $this->jenis_satker_model->cek_jenis_satker_baru($jenis_satker);
		if($compare == FALSE){
			$data_jenis_satker = array('nmjnssat' => $this->input->post('nmjnssat'));
			$this->gm->update('t_jnssat',$data_jenis_satker,'kdjnssat',$kode);
			redirect('master_data/master_jenis_satker');
		}else{
			$jenis_satker = $this->gm->get_where('t_jnssat','kdjnssat',$kode);
			$data['master_data'] = "";
			$data['nmjnssat'] = $jenis_satker->row()->nmjnssat;
			$data['kdjnssat'] = $kode;
			$data['content'] = $this->load->view('form_master_data/form_edit_jenis_satker',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function hapus($kode)
	{	
		$this->gm->delete('t_jnssat', 'kdjnssat', $kode);
		redirect('master_data/master_jenis_satker');
	}
	
	function check_reference($kode){
		$referensi = $this->jenis_satker_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//menambahkan detail jenis_satker
	function detail($kode)
	{
		$jenis_satker = $this->gm->get_where('t_jnssat','kdjnssat',$kode);
		$data['master_data'] = "";
		$data['nmjnssat'] = $jenis_satker->row()->nmjnssat;
		$data['kdjnssat'] = $kode;
		$data['content'] = $this->load->view('form_master_data/form_detail_jenis_satker',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_jenis_satker class

/* End of file master_jenis_satker.php */
/* Location: ./application/controllers/master_jenis_satker.php */

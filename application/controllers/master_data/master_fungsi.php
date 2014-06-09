<?php
/**
 * Kelas Master_fungsi
 */
class Master_fungsi extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/fungsi_model');	
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
	 * Menampilkan tabel daftar fungsi
	 */
	function index()
	{		
		redirect ('master_data/master_fungsi/grid_daftar');
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
		$colModel['NamaFungsi'] = array('Nama Fungsi',250,TRUE,'left',1);
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
		$url = site_url()."/master_data/master_fungsi/grid_fungsi";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_fungsi/add_process';    
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
						   url: '".site_url('/master_data/master_fungsi/hapus_fungsi')."', 
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
		$data['judul'] = 'Fungsi';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data fungsi
	function grid_fungsi() 
	{
	
		$valid_fields = array('KodeFungsi','NamaFungsi');
		$this->flexigrid->validate_post('KodeFungsi','asc',$valid_fields);
		$records = $this->fungsi_model->get_data_flexigrid_fungsi();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KodeFungsi,
										$no,
										$row->NamaFungsi,
								'<a href=\''.site_url().'/master_data/master_fungsi/detail_fungsi/'.$row->KodeFungsi.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_fungsi/edit_proses/'.$row->KodeFungsi.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_fungsi/hapus_fungsi/'.$row->KodeFungsi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_fungsi_baru($value){
		if($this->fungsi_model->cek_fungsi_baru($value)){
			$this->form_validation->set_message('cek_fungsi_baru',  'Nama fungsi '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_fungsi($value, $kode_fungsi){
		if($this->fungsi_model->cek_fungsi($value, $kode_fungsi)){
			$this->form_validation->set_message('cek_fungsi', 'Nama fungsi '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	function cek_validasi($edit,$kode_fungsi)
	{
		if($edit == true)
		{
			$NamaFungsi = '|callback_cek_fungsi['.$kode_fungsi.']';
		}
		else
		{
			$NamaFungsi = '|callback_cek_fungsi_baru';
		}
		$this->form_validation->set_rules('NamaFungsi', 'Nama fungsi', 'required'.$NamaFungsi);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	//proses validasi kode
	function valid($kode){
		if($this->fungsi_model->valid_kode($kode) == TRUE){
		//	$this->form_validation->set_message('validasi_kode', 'Kode $kode telah dipakai!!');
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
//proses penambahan fungsi
	function add_process()
	{	
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$data['status'] = $option_status;
		$data['content'] = $this->load->view('form_master_data/form_master_fungsi',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_fungsi()
	{
		$this->form_validation->set_rules('KodeFungsi', 'Kode Fungsi', 'required|min_length[2]');
		$this->form_validation->set_rules('NamaFungsi', 'Nama Fungsi', 'required');
		$fungsi = $this->input->post('NamaFungsi');
		$compare = $this->fungsi_model->cek_fungsi_baru($fungsi);
		if($this->form_validation->run() == TRUE and $compare == FALSE)
		{
			$data = array(
				'KodeFungsi' => $this->input->post('KodeFungsi'),
				'NamaFungsi' => $this->input->post('NamaFungsi'),
				'KodeStatus' => $this->input->post('KodeStatus')			 
			);
			$this->fungsi_model->add($data);
			redirect('master_data/master_fungsi');
		} 
		else{
			$option_status;
			foreach($this->gm->get_data('status_program')->result() as $row){
				$option_status[$row->KodeStatus] = $row->Status;
			}
			$data['status'] = $option_status;
			$data['content'] = $this->load->view('form_master_data/form_master_fungsi',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	
	
	//mengubah fungsi
	function edit_proses($KodeFungsi){
		$fungsi = $this->gm->get_where('ref_fungsi','KodeFungsi',$KodeFungsi);
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$data['status'] = $option_status;
		$data['master_data'] = "";
		$data['NamaFungsi'] = $fungsi->row()->NamaFungsi;
		$data['KodeFungsi'] = $KodeFungsi;
		$data['KodeStatus'] = $fungsi->row()->KodeStatus;
		$data['content'] = $this->load->view('form_master_data/form_edit_fungsi',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_fungsi($KodeFungsi){
		$fungsi = $this->input->post('NamaFungsi');
		$compare = $this->fungsi_model->cek_fungsi_baru($fungsi);
		if($compare == FALSE){
			$data_fungsi = array(
				'KodeFungsi' => $this->input->post('KodeFungsi'),
				'NamaFungsi' => $this->input->post('NamaFungsi'),
				'KodeStatus' => $this->input->post('KodeStatus')
			);
			$this->gm->update('ref_fungsi',$data_fungsi,'KodeFungsi',$KodeFungsi);
			redirect('master_data/master_fungsi');
		}else{
			$this->edit_proses($KodeFungsi);
		}
	}

	function hapus_fungsi($KodeFungsi){
		$this->gm->delete('data_menu_kegiatan', 'KodeFungsi', $KodeFungsi);
		$this->gm->delete('data_program', 'KodeFungsi', $KodeFungsi);
		$this->gm->delete('data_ikk', 'KodeFungsi', $KodeFungsi);
		$this->gm->delete('data_iku', 'KodeFungsi', $KodeFungsi);
		$this->gm->delete('data_kegiatan', 'KodeFungsi', $KodeFungsi);
		$this->gm->delete('data_sub_fungsi', 'KodeFungsi', $KodeFungsi);
		$this->gm->delete('data_fungsi', 'KodeFungsi', $KodeFungsi);
		$kegiatan = '';
		$ikk = '';
		foreach($this->gm->get_where('ref_kegiatan','KodeFungsi',$KodeFungsi)->result() as $row){
			$kegiatan[$row->KodeKegiatan]=$row->KodeKegiatan;
		}
		foreach($this->gm->get_where_in('ref_ikk','KodeKegiatan',$kegiatan)->result() as $row){
			$ikk[$row->KodeIkk]=$row->KodeIkk;
		}
		$this->gm->delete_in('ref_satker_kegiatan', 'KodeKegiatan', $kegiatan);
		$this->gm->delete_in('ref_satker_ikk', 'KodeIkk', $ikk);
		$this->gm->delete_in('ref_ikk', 'KodeKegiatan', $kegiatan);
		$this->gm->delete_in('ref_menu_kegiatan', 'KodeKegiatan', $kegiatan);
		$this->gm->delete('ref_kegiatan', 'KodeFungsi', $KodeFungsi);
		$this->gm->delete('ref_sub_fungsi', 'KodeFungsi', $KodeFungsi);
		$this->gm->delete('ref_fungsi', 'KodeFungsi', $KodeFungsi);
		redirect('master_data/master_fungsi');
	}
	
	function check_reference($kode){
		$referensi = $this->fungsi_model->check($kode)->num_rows();
		if ($referensi > 0)
			return FALSE;
		else
			return TRUE;
	}
	
	//menambahkan detail fungsi
	function detail_fungsi($KodeFungsi)
	{
		$fungsi = $this->gm->get_where('ref_fungsi','KodeFungsi',$KodeFungsi);
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$data['master_data'] = "";
		$data['status'] = $option_status;
		$data['NamaFungsi'] = $fungsi->row()->NamaFungsi;
		$data['KodeFungsi'] = $KodeFungsi;
		$data['KodeStatus'] = $fungsi->row()->KodeStatus;
		$data['content'] = $this->load->view('form_master_data/form_detail_fungsi',$data,true);
		$this->load->view('main',$data);
	}
} 
// END master_fungsi class

/* End of file master_fungsi.php */
/* Location: ./application/controllers/master_fungsi.php */

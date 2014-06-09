<?php
/**
 * Kelas Master_propinsi
 */
class Master_propinsi extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');
		$this->load->model('master_data/propinsi_model');	
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
	 * Menampilkan tabel daftar propinsi
	 */
	function index()
	{		
		redirect ('master_data/master_propinsi/grid_propinsi');
	}
	
	 
	function grid_propinsi()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['NamaProvinsi'] = array('Nama Provinsi',250,TRUE,'LEFT',1);
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
		$url = site_url()."/master_data/master_propinsi/list_propinsi";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_propinsi/add_process';    
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
						   url: '".site_url('/master_data/master_propinsi/hapus_provinsi')."', 
						   data: 'items='+itemlist,
						   success: function(data){
							$('#user').flexReload();
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

		$data['judul'] = 'Provinsi';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_propinsi(){
	
		$valid_fields = array('KodeProvinsi','NamaProvinsi');
		$this->flexigrid->validate_post('KodeProvinsi','asc',$valid_fields);
		$records = $this->propinsi_model->get_data_flexigrid_propinsi();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KodeProvinsi,
										$no,
										$row->NamaProvinsi,
								'<a href=\''.site_url().'/master_data/master_propinsi/detail_provinsi/'.$row->KodeProvinsi.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/master_data/master_propinsi/edit_proses/'.$row->KodeProvinsi.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/master_data/master_propinsi/hapus_provinsi/'.$row->KodeProvinsi.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_propinsi_baru($value){
		if($this->propinsi_model->cek_propinsi_baru($value)){
			$this->form_validation->set_message('cek_propinsi_baru',  'Nama propinsi '.$value.' telah terpakai!!');
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('NamaProvinsi', 'Nama Provinsi', 'required');
		$this->form_validation->set_rules('KodeProvinsi', 'Kode Provinsi', 'required');
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	/*function add_process(){
		$data['master_data'] = "";
		$data['content'] = $this->load->view('form_master_data/form_master_propinsi',null,true);
		$this->load->view('main',$data);
	}
	
	function save_provinsi(){
		if($this->cek_validasi() == true){
			$prov = array(
				'NamaProvinsi' => $this->input->post('NamaProvinsi'),
				'KodeProvinsi' => $this->propinsi_model->get_max('ref_provinsi','KodeProvinsi')+1
			);
			$this->propinsi_model->add('ref_provinsi',$prov);
			redirect('master_data/master_propinsi');
		}else{
			$data['master_data'] = "";
			$data['content'] = $this->load->view('form_master_data/form_master_propinsi',null,true);
			$this->load->view('main',$data);
		}
	}*/
	
	//proses validasi kode
	function valid($kode){
		if($this->propinsi_model->valid_kode($kode) == TRUE){
		//	$this->form_validation->set_message('validasi_kode', 'Kode $kode telah dipakai!!');
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	function add_process()
	{		
		if($this->cek_validasi(false,'') == true)
		{
			$data = array(
				'KodeProvinsi' => $this->input->post('KodeProvinsi'),
				'NamaProvinsi' => $this->input->post('NamaProvinsi')
				//'KodeProvinsi' => $this->propinsi_model->get_max('ref_provinsi','KodeProvinsi')+1
			);
			$this->propinsi_model->add('ref_provinsi',$data);
			redirect('master_data/master_propinsi');
		} 
		else{
			$data['master_data'] = "";
			$data['content'] = $this->load->view('form_master_data/form_master_propinsi',null,true);
			$this->load->view('main',$data);
		}
	}
	
	function edit_proses($KodeProvinsi){
		$prov = $this->propinsi_model->get_prov($KodeProvinsi);
		$data['master_data'] = "";
		$data['KodeProvinsi'] = $KodeProvinsi;
		$data['NamaProvinsi'] = $prov->row()->NamaProvinsi;
		$data['content'] = $this->load->view('form_master_data/form_edit_provinsi',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_propinsi($KodeProvinsi){
		if ($this->cek_validasi() == true){
			$data_prov = array('NamaProvinsi'	=> $this->input->post('NamaProvinsi'));
			$this->propinsi_model->update($KodeProvinsi, $data_prov);
			redirect('master_data/master_propinsi');
		}else{
			$prov = $this->propinsi_model->get_prov($KodeProvinsi);
			$data['master_data'] = "";
			$data['KodeProvinsi'] = $KodeProvinsi;
			$data['NamaProvinsi'] = $prov->row()->NamaProvinsi;
			$data['content'] = $this->load->view('form_master_data/form_edit_provinsi',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function hapus_provinsi($KodeProvinsi){	
		/*$KodeProvinsi = explode(",",$this->input->post('items'));
		$msg = '';
		
		foreach($KodeProvinsi as $kode){
			if($kode != ''){
				$this->propinsi_model->hapus_prov($kode);
				$msg .= "Data provinsi dengan ID (".$kode.") telah berhasil dihapus.\n";
			}
		}//end foreach
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($msg);*/
		$this->gm->delete('ref_provinsi', 'KodeProvinsi', $KodeProvinsi);
		$this->gm->delete('ref_kanwil', 'KDPROVINSI', $KodeProvinsi);
		$this->gm->delete('ref_kabupaten', 'KodeProvinsi', $KodeProvinsi);
		redirect('master_data/master_propinsi');
	}
	
	//menambahkan detail fungsi
	function detail_provinsi($KodeProv)
	{
		$provinsi = $this->gm->get_where('ref_provinsi','KodeProvinsi',$KodeProv);
		$data['master_data'] = "";
		$data['NamaProvinsi'] = $provinsi->row()->NamaProvinsi;
		$data['KodeProvinsi'] = $KodeProv;
		$data['content'] = $this->load->view('form_master_data/form_detail_provinsi',$data,true);
		$this->load->view('main',$data);
	}
}

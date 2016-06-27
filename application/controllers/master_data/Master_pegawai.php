<?php
class Master_pegawai extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');	
		$this->load->model('e-planning/Pendaftaran_model','pm');
		$this->load->library('form_validation');
		$this->load->library('session');
	}
	
	/**
	 * Menampilkan tabel daftar pegawai
	 */
	function index(){
		redirect ('master_data/master_pegawai/grid_pegawai');
	}
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	
	function json(){
	 $data='[{
		"id":1,
		"text":"Foods",
		"children":[{
			"id":2,
			"text":"Fruits",
			"state":"closed",
			"children":[{
				"text":"apple",
				"checked":true
			},{
				"text":"orange"
			}]
		},{
			"id":3,
			"text":"Vegetables",
			"state":"open",
			"children":[{
				"text":"tomato",
				"checked":true
			},{
				"text":"carrot",
				"checked":true
			},{
				"text":"cabbage"
			},{
				"text":"potato",
				"checked":true
			},{
				"text":"lettuce"
			}]
		}]
	}]';
	return encode_json($data);
	}
	function grid_pegawai(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['nip_peg'] = array('NIP',100,TRUE,'LEFT',0);
		$colModel['nama_peg'] = array('Nama Pegawai',300,TRUE,'LEFT',1);
		$colModel['namajabatan'] = array('Jabatan',300,TRUE,'LEFT',1);
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
		$url = site_url()."/master_data/master_pegawai/list_pegawai";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_pegawai/tambah_pegawai';    
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

		$data['judul'] = 'Pegawai';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_pegawai(){
		
		$valid_fields = array('nip_pegawai','nama_peg','namajabatan');
		$this->flexigrid->validate_post('data_pegawai.id_peg','asc',$valid_fields);
		$records = $this->gm->get_data_flexigrid('data_pegawai');
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->id_peg,
				$no,
				$row->nip_peg,
				$row->nama_peg,
				$row->NAMA_JABATAN,
				'<a href=\''.site_url().'/master_data/master_pegawai/detail/'.$row->id_peg.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/master_data/master_pegawai/edit/'.$row->id_peg.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_pegawai/hapus/'.$row->id_peg.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function tambah_pegawai(){
		$option_satker;
		$option_unit_utama;
		
		foreach($this->pm->get('ref_satker')->result() as $row){
			$option_satker[$row->kdsatker] = $row->nmsatker;
		}
		$option_unit_utama['0'] = '--- Pilih Unit Utama ---';
		foreach($this->pm->get('ref_unit')->result() as $row){
			$option_unit_utama[$row->KDUNIT] = $row->NMUNIT;
		}
		$data['master_data'] = '';
		$data['satker'] = $option_satker;
		$data['unit_utama'] = $option_unit_utama;
		$data['eselon1'] = $this->pm->get('ref_eselon1');
		$data['content'] = $this->load->view('e-planning/master/tambah_pegawai',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_pegawai(){
		if($this->validasi_pegawai() == FALSE){
			$this->tambah_pegawai();
		}else{
			$nama_peg = $this->input->post('nama_peg');
			$nip_peg = $this->input->post('nip_peg');					
			$jabatan = explode('-',$this->input->post('jabatan'));
			$satker = $this->input->post('satker');
			if($this->input->post('jns_jabatan') == 'eselon'){
				$jabatan = explode('-',$this->input->post('jabatan'));
				$NamaJabatan = $jabatan[2];
				$eselon = $jabatan[0];
				$kode_eselon = $jabatan[1];
				$unit = $this->input->post('unit_utama');
			}
			else{
				$NamaJabatan = 'Staf';
				$eselon = '0';
				$kode_eselon = '-';
				$unit = $this->input->post('unit_utama');
			}
			$data_pegawai = array(
				'nip_peg' => $nip_peg,
				'nama_peg' => $nama_peg,
				'NAMA_JABATAN' => $NamaJabatan,
				'KODE_JABATAN' => $kode_eselon,
				'kdsatker' => $satker,
				'ESELON' => $eselon,
				'KDUNIT' => $unit
			);
			$this->pm->save($data_pegawai, 'data_pegawai');
					
			redirect('master_data/master_pegawai');
		}
	}
	
	function validasi_pegawai(){
		$config = array(
			array('field'=>'nama_peg','label'=>'Nama Pegawai', 'rules'=>'required'),
			array('field'=>'nip_peg','label'=>'NIP Pegawai', 'rules'=>'required')
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		return $this->form_validation->run();
	}
	
	//mendapatkan
	function getJabatan($kode)
	{
		$i=0; $j=0; $k=0; $l=0;
		foreach($this->pm->get_where('ref_eselon1', $kode, 'kdunit')->result() as $row1)
		{
			$datajson[$i]['kodeJabatan'] = '1-'.$row1->kdunit.'-'.$row1->eselon1;
			$datajson[$i]['namaJabatan'] = $row1->eselon1;
			$i++;
			foreach ($this->pm->get_where('ref_eselon2', $kode, 'kdunit')->result() as $row2){
				$datajson[$i]['kodeJabatan'] = '2-'.$kode.'.'.$row2->id_eselon2.'-'.$row2->eselon2;
				$datajson[$i]['namaJabatan'] = '- '.$row2->eselon2;
				$es2=$row2->id_eselon2;
				$i++;
				foreach ($this->pm->get_where_double('ref_eselon3', $kode, 'kdunit', $es2, 'id_eselon2')->result() as $row3){
					$datajson[$i]['kodeJabatan'] = '3-'.$kode.'.'.$row2->id_eselon2.'.'.$row3->id_eselon3.'-'.$row3->eselon3;
					$datajson[$i]['namaJabatan'] = '- - '.$row3->eselon3;
					$es3=$row3->id_eselon3;
					$i++;
					foreach ($this->pm->get_where_triple('ref_eselon4', $kode, 'kdunit', $es2, 'id_eselon2',$es3, 'id_eselon3')->result() as $row4){
						$datajson[$i]['kodeJabatan'] = '4-'.$kode.'.'.$row2->id_eselon2.'.'.$row3->id_eselon3.'.'.$row4->id_eselon4.'-'.$row4->eselon4;
						$datajson[$i]['namaJabatan'] = '- - - '.$row4->eselon4;
						$i++;
					}
				}
			}
		}
		
		echo json_encode($datajson);
	}
	
	function hapus($id_peg){	
		$this->gm->delete('data_pegawai','id_peg',$id_peg);
		redirect('master_data/master_pegawai');
	}
	
	function detail($id)
	{
		$option_satker;
		$option_unit_utama;
		
		foreach($this->pm->get('ref_satker')->result() as $row){
			$option_satker[$row->kdsatker] = $row->nmsatker;
		}

		foreach($this->pm->get('ref_unit')->result() as $row){
			$option_unit_utama[$row->KDUNIT] = $row->NMUNIT;
		}
				
		$pegawai = $this->gm->get_where('data_pegawai','id_peg',$id);
		
		$data['master_data'] = "";
		$data['id'] = $id;
		$data['opt_satker'] = $option_satker;
		$data['opt_unit_utama'] = $option_unit_utama;
		$data['eselon1'] = $this->pm->get('ref_eselon1');
		$data['nip'] = $pegawai->row()->nip_peg;
		$data['nama_peg'] = $pegawai->row()->nama_peg;
		$data['jabatan'] = $pegawai->row()->NAMA_JABATAN;
		$data['satker'] = $pegawai->row()->kdsatker;
		$data['unit'] = $pegawai->row()->KDUNIT;
		$data['content'] = $this->load->view('e-planning/master/detail_pegawai',$data,true);
		$this->load->view('main',$data);
	}
	
	function edit($id)
	{
		$option_satker;
		$option_unit_utama;
		
		foreach($this->pm->get('ref_satker')->result() as $row){
			$option_satker[$row->kdsatker] = $row->nmsatker;
		}

		foreach($this->pm->get('ref_unit')->result() as $row){
			$option_unit_utama[$row->KDUNIT] = $row->NMUNIT;
		}
		
		$pegawai = $this->gm->get_where('data_pegawai','id_peg',$id);
		
		$data['master_data'] = "";
		$data['id'] = $id;
		$data['opt_satker'] = $option_satker;
		$data['opt_unit_utama'] = $option_unit_utama;
		$data['eselon1'] = $this->pm->get('ref_eselon1');
		$data['nip'] = $pegawai->row()->nip_peg;
		$data['nama_peg'] = $pegawai->row()->nama_peg;
		$data['jabatan'] = $pegawai->row()->NAMA_JABATAN;
		$data['satker'] = $pegawai->row()->kdsatker;
		$data['unit'] = $pegawai->row()->KDUNIT;
		$data['content'] = $this->load->view('e-planning/master/edit_pegawai',$data,true);
		$this->load->view('main',$data);
	}
	
	function edit_proses($id)
	{
		if($this->validasi_pegawai() == FALSE){
			$this->edit($id);
		}else{
			$nama_peg = $this->input->post('nama_peg');
			$nip_peg = $this->input->post('nip_peg');					
			$jabatan = explode('-',$this->input->post('jabatan'));
			$NamaJabatan = $jabatan[2];
			$eselon = $jabatan[0];
			$kode_eselon = $jabatan[1];
			
			$data_pegawai = array(
				'nip_peg' => $nip_peg,
				'nama_peg' => $nama_peg,
				'NAMA_JABATAN' => $NamaJabatan,
				'KODE_JABATAN' => $kode_eselon
			);
			$this->pm->update('data_pegawai',$data_pegawai, 'id_peg', $id);
					
			redirect('master_data/master_pegawai');
		}
	}
}

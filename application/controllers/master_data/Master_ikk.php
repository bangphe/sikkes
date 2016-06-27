<?php
class Master_ikk extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');	
		$this->load->model('e-planning/manajemen_model', 'mm');	
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
	function index(){
		redirect ('master_data/master_ikk/grid_ikk');
	}
	
	function grid_ikk(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['NamaKegiatan'] = array('Nama Kegiatan',400,TRUE,'LEFT',0);
		$colModel['Ikk'] = array('Ikk',400,TRUE,'LEFT',1);
		$colModel['TargetNasional'] = array('Target Nasional',75,TRUE,'center',0);
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
							'nowrap' => false,
							'showTableToggleBtn' => false,
			'nowrap' => false
							);
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_ikk/list_ikk";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_ikk/add_process';    
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

		$data['judul'] = 'IKK';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_ikk(){
		
		$valid_fields = array('KodeKegiatan','KodeIkk','Ikk');
		$this->flexigrid->validate_post('ref_ikk.KodeIkk','asc',$valid_fields);
		
		$records = $this->gm->get_data_flexigrid_join('ref_ikk','ref_kegiatan','ref_ikk.KodeKegiatan=ref_kegiatan.KodeKegiatan');
		/*$records = $this->gm->get_data_flexigrid_double_join('ref_ikk','ref_kegiatan','ref_ikk.KodeKegiatan=ref_kegiatan.KodeKegiatan','target_ikk','ref_ikk.KodeIkk=target_ikk.KodeIkk');*/
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			// if($this->mm->cek('target_ikk','KodeIkk',$row->KodeIkk)) $tambahikk = $this->mm->get_where('target_ikk','KodeIkk',$row->KodeIkk)->row()->TargetNasional;
			// else $tambahikk = '<a href=\''.site_url().'/master_data/master_ikk/add_target/'.$row->KodeIkk.'\'>Tambah</a>';
			$no = $no+1;
			$record_items[] = array(
				$row->KodeKegiatan,
				$no,
				$row->NamaKegiatan,
				$row->Ikk,
				'<a href=\''.site_url().'/master_data/master_ikk/grid_target_nasional/'.$row->KodeIkk.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href=\''.site_url().'/master_data/master_ikk/detail_ikk/'.$row->KodeIkk.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/master_data/master_ikk/edit_proses/'.$row->KodeIkk.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_ikk/hapus/'.$row->KodeIkk.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function add_target($kode){
		$ikk = $this->gm->get_where('ref_ikk','KodeIkk',$kode);
		$option_thn;
		foreach($this->gm->get_data('ref_tahun_anggaran')->result() as $row){
			$option_thn[$row->idThnAnggaran] = $row->thn_anggaran;
		}
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$data['tahun'] = $option_thn;
		$data['status'] = $option_status;
		$data['kode_ikk'] = $ikk->row()->KodeIkk;
		$data['content'] = $this->load->view('form_master_data/form_tambah_target_ikk',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_target($kode){
		$ikk = $this->gm->get_where('ref_ikk','KodeIkk',$kode);
		$data = array(
			'KodeIkk'			=> $ikk->row()->KodeIkk,
			'idThnAnggaran'		=> $this->input->post('thn_anggaran'),
			'TargetNasional'	=> $this->input->post('target_ikk')
		);
		$this->gm->add('target_ikk',$data);
		redirect('master_data/master_ikk/grid_target_nasional/'.$kode);
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('kdikk', 'Kode Ikk', 'required|numeric|exact_length[3]');
		$this->form_validation->set_rules('ikk', 'Ikk', 'required');
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	//proses validasi kode
	function valid($kode){
		$kdkeg = $this->input->get('kdkeg').'.'.$kode;
		if($this->gm->valid_kode('ref_ikk','KodeIkk',$kdkeg) == TRUE){
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	function add_process(){
		$option_kegiatan;
		foreach($this->gm->get_data('ref_kegiatan')->result() as $row){
			$option_kegiatan[$row->KodeKegiatan] = "[".$row->KodeKegiatan."] - ".$row->NamaKegiatan;
		}
		/*$option_ikk;
		foreach($this->gm->get_data('ref_ikk')->result() as $row){
			$option_ikk[$row->KodeIkk] = "[".$row->KodeIkk."] - ".$row->Ikk;
		}*/
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$option_thn;
		foreach($this->gm->get_data('ref_tahun_anggaran')->result() as $row){
			$option_thn[$row->idThnAnggaran] = $row->thn_anggaran;
		}
		$data['master_data'] = "";
		$data['kegiatan'] = $option_kegiatan;
		//$data['opt_ikk'] = $option_ikk;
		$data['status'] = $option_status;
		$data['tahun'] = $option_thn;
		$data['content'] = $this->load->view('form_master_data/form_tambah_ikk',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_ikk(){
		if($this->cek_validasi() == true){
			//input ref_ikk
			//$KodeIkk = explode('.',$this->gm->get_max_where('ref_ikk','KodeIkk','KodeKegiatan',$this->input->post('kegiatan')));
			$ref_ikk = array(
				//'KodeIkk' 		=> $this->input->post('kegiatan').'.'.($KodeIkk[1]+1),
				'KodeIkk'		=> $this->input->post('kegiatan').'.'.$this->input->post('kdikk'),
				'KodeKegiatan'	=> $this->input->post('kegiatan'), 
				'Ikk' 			=> $this->input->post('ikk'),
				'KodeStatus' 	=> $this->input->post('status')
			);
			$this->gm->add('ref_ikk',$ref_ikk);
			
			//input t_ikk
			$t_ikk = array(
				'kdgiat'	=> $this->input->post('kegiatan'), 
				'kdikk'		=> $this->input->post('kdikk'),		
				'nmikk' 	=> $this->input->post('ikk')
			);
			$this->gm->add('t_ikk',$t_ikk);
			
			//input target_ikk
			/*$target_ikk = array(
				'KodeIkk' 			=> $this->input->post('kegiatan').'.'.($KodeIkk[1]+1),
				'idThnAnggaran' 	=> $this->input->post('thn_anggaran'),
				'TargetNasional' 	=> $this->input->post('target_ikk')
			);
			$this->gm->add('target_ikk',$target_ikk);*/
			redirect('master_data/master_ikk');
		}else{
			$this->add_process();
		}
	}
	
	function edit_proses($KodeIkk){
		$ikk = $this->gm->get_where('ref_ikk','KodeIkk',$KodeIkk);
		$option_kegiatan;
		foreach($this->gm->get_data('ref_kegiatan')->result() as $row){
			$option_kegiatan[$row->KodeKegiatan] = "[".$row->KodeKegiatan."] - ".$row->NamaKegiatan;
		}
		$option_ikk;
		foreach($this->gm->get_data('ref_ikk')->result() as $row){
			$option_ikk[$row->KodeIkk] = "[".$row->KodeIkk."] - ".$row->Ikk;
		}
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		// $targetIkk;
		// foreach($this->gm->get_where('target_ikk','KodeIkk',$KodeIkk)->result() as $row){
			// $targetIkk = $row->TargetNasional;
		// }
		$data['kegiatan'] = $option_kegiatan;
		$data['status'] = $option_status;
		$data['ikk'] = $option_ikk;
		$data['selected_kegiatan'] = $ikk->row()->KodeKegiatan;
		$data['selected_ikk'] = $ikk->row()->Ikk;
		$data['selected_status'] = $ikk->row()->KodeStatus;		
		$data['KodeIkk'] = $KodeIkk;
		// $data['TargetIkk'] = $targetIkk;
		$data['master_data'] = "";
		$data['content'] = $this->load->view('form_master_data/form_edit_ikk',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_ikk($KodeIkk){
		if ($this->cek_validasi() == true){
			$ikk = array(
				'Ikk' 			=> $this->input->post('ikk'),
				'KodeStatus' 	=> $this->input->post('status')
			);
			$this->gm->update('ref_ikk',$ikk, 'KodeIkk', $KodeIkk);
			
			$ikk = array(
				'nmikk' 		=> $this->input->post('ikk'),
			);
			$this->gm->update('t_ikk',$ikk, 'kdikk', $KodeIkk);
			// $target_ikk = array(
				// 'KodeIkk' 			=> $this->input->post('kegiatan').'.'.($KodeIkk[1]+1),
				// 'idThnAnggaran' 	=> $this->input->post('thn_anggaran'),
				// 'TargetNasional' 	=> $this->input->post('target_ikk')
			// );
			// $this->gm->update('target_ikk',$target_ikk);
			/*$data_ikk = array('Ikk' => $this->input->post('ikk'));
			$this->gm->update('ref_ikk',$data_ikk,'KodeIkk',$KodeIkk);*/
			redirect('master_data/master_ikk');
		}else{
			redirect('master_data/master_ikk/edit_proses/'.$KodeIkk);
		}
	}
	
	function hapus($KodeIkk){
		$this->gm->delete('data_menu_kegiatan','KodeIkk',$KodeIkk);
		$this->gm->delete('data_ikk','KodeIkk',$KodeIkk);
		$this->gm->delete('ref_satker_ikk', 'KodeIkk', $KodeIkk);
		$this->gm->delete('ref_ikk', 'KodeIkk', $KodeIkk);
		$this->gm->delete('t_ikk','kdikk',$KodeIkk);
		redirect('master_data/master_ikk');
	}
	
	//detail ikk
	function detail_ikk($KodeIkk){
		$ikk = $this->gm->get_where('ref_ikk','KodeIkk',$KodeIkk);
		$targetIkk = $this->gm->get_where('target_ikk', 'KodeIkk', $KodeIkk);
		$option_kegiatan;
		foreach($this->gm->get_data('ref_kegiatan')->result() as $row){
			$option_kegiatan[$row->KodeKegiatan] = "[".$row->KodeKegiatan."] - ".$row->NamaKegiatan;
		}
		$option_ikk;
		foreach($this->gm->get_data('ref_ikk')->result() as $row){
			$option_ikk[$row->KodeIkk] = "[".$row->KodeIkk."] - ".$row->Ikk;
		}
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		foreach($this->gm->get_where_join('ref_ikk','ref_ikk.KodeIkk',$KodeIkk,'target_ikk','target_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row2)	
		$data['TargetIkk'] = $row2->TargetNasional;
		$data['kegiatan'] = $option_kegiatan;
		$data['status'] = $option_status;
		$data['ikk'] = $option_ikk;
		$data['selected_kegiatan'] = $ikk->row()->KodeKegiatan;
		$data['kodeIkk'] = $ikk->row()->KodeIkk;
		$data['Ikk'] = $ikk->row()->Ikk;
		$data['selected_status'] = $ikk->row()->KodeStatus;	
		$data['KodeIkk'] = $KodeIkk;
		$data['master_data'] = "";
		$data['content'] = $this->load->view('form_master_data/form_detail_ikk',$data,true);
		$this->load->view('main',$data);
	}
	
	
	function grid_target_nasional($kodeikk){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['Ikk'] = array('Ikk',400,TRUE,'LEFT',1);
		$colModel['Tahun'] = array('Tahun',50,TRUE,'center',1);
		$colModel['TargetNasional'] = array('Target Nasional',100,TRUE,'center',0);
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
							'nowrap' => false,
							'showTableToggleBtn' => false,
			'nowrap' => false
							);
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_ikk/list_target_nasional/".$kodeikk;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_ikk/add_target/".$kodeikk."';    
			}
		} </script>";
		
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/master_data/master_ikk\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Master IKK
					</button>
					</form>
				</div>";
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

		$data['judul'] = 'Target Nasional Ikk';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_target_nasional($kodeikk){
		$valid_fields = array('TargetNasional','KodeIkk','Ikk');
		$this->flexigrid->validate_post('ref_Ikk.KodeIkk','asc',$valid_fields);
		$records = $this->gm->get_target_nasional_ikk($kodeikk);
		$this->output->set_header($this->config->item('json_header'));
		$kodeikk;
		$no =0;
		foreach ($records['records']->result() as $row){
			
			$no = $no+1;
			$record_items[] = array(
				$row->KodeIkk,
				$no,
				$row->Ikk,
				$row->thn_anggaran,
				//$row->TargetNasional,
				$row->TargetNasional,
				'<a href='.site_url().'/master_data/master_ikk/edit_target/'.$row->KodeIkk.'/'.$row->idThnAnggaran.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_ikk/hapus_target/'.$row->KodeIkk.'/'.$row->idThnAnggaran.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function hapus_target($KodeIkk,$idTahun){
		$this->gm->delete_double_param('target_ikk','KodeIkk',$KodeIkk,'idThnAnggaran',$idTahun);
		redirect('master_data/master_ikk/grid_target_nasional/'.$KodeIkk);
	}
	
	function edit_target($KodeIkk,$idTahun){
		$option_thn;
		foreach($this->gm->get_data('ref_tahun_anggaran')->result() as $row){
			$option_thn[$row->idThnAnggaran] = $row->thn_anggaran;
		}
		$targetnasional;
		foreach($this->gm->get_double_where('target_ikk','KodeIkk',$KodeIkk,'idThnAnggaran', $idTahun)->result() as $row){
			$targetnasional = $row->TargetNasional;
		}
		$data['tahun'] = $option_thn;
		$data['target'] = $targetnasional;
		$data['selected_tahun']= $idTahun;
		$data['kode_ikk'] = $KodeIkk;
		$data2['content'] = $this->load->view('form_master_data/form_edit_target_ikk',$data,true);
		$this->load->view('main',$data2);
	}
	
	function update_target($KodeIkk,$idTahun){
		$data = array(
			'TargetNasional' => $this->input->post('target_ikk')
			);
		$this->gm->update_double_where('target_ikk',$data,'KodeIkk',$KodeIkk,'idThnAnggaran',$idTahun);
		redirect('master_data/master_ikk/grid_target_nasional/'.$KodeIkk);
	}
}
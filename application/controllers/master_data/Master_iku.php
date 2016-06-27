<?php
class Master_iku extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');	
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
		redirect ('master_data/master_iku/grid_iku');
	}
	
	function grid_Iku(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['NamaProgram'] = array('Nama Program',400,TRUE,'LEFT',0);
		$colModel['Iku'] = array('Iku',400,TRUE,'LEFT',1);
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
		$url = site_url()."/master_data/master_iku/list_iku";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_iku/add_process';    
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

		$data['judul'] = 'IKU';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_iku(){
		$valid_fields = array('KodeProgram','KodeIku','Iku');
		$this->flexigrid->validate_post('ref_iku.KodeProgram','asc',$valid_fields);
		$records = $this->gm->get_data_flexigrid_join('ref_iku','ref_program','ref_iku.KodeProgram=ref_program.KodeProgram');
		/*$records = $this->gm->get_data_flexigrid_double_join('ref_iku','ref_program','ref_iku.KodeProgram=ref_program.KodeProgram','target_iku','ref_iku.KodeIku=target_iku.KodeIku');*/
		
		$this->output->set_header($this->config->item('json_header'));
		$kodeiku;
		$no =0;
		foreach ($records['records']->result() as $row){
			
			$no = $no+1;
			$record_items[] = array(
				$row->KodeProgram,
				$no,
				$row->NamaProgram,
				$row->Iku,
				//$row->TargetNasional,
				'<a href=\''.site_url().'/master_data/master_iku/grid_target_nasional/'.$row->KodeIku.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href=\''.site_url().'/master_data/master_iku/detail_iku/'.$row->KodeIku.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/master_data/master_iku/edit_proses/'.$row->KodeIku.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_iku/hapus/'.$row->KodeIku.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
			
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function add_target($kode){
		$iku = $this->gm->get_where('ref_iku','KodeIku',$kode);
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
		$data['kode_iku'] = $iku->row()->KodeIku;
		$data['content'] = $this->load->view('form_master_data/form_tambah_target_iku',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_target($kode){
		$iku = $this->gm->get_where('ref_iku','KodeIku',$kode);
		$data = array(
			'KodeIku'			=> $iku->row()->KodeIku,
			'idThnAnggaran'		=> $this->input->post('thn_anggaran'),
			'TargetNasional'	=> $this->input->post('target_iku')
		);
		$this->gm->add('target_iku',$data);
		redirect('master_data/master_iku/grid_target_nasional/'.$kode);
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('kdiku', 'Kode Iku', 'required|numeric|exact_length[2]');
		$this->form_validation->set_rules('Iku', 'Iku', 'required');
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	//proses validasi kode
	function valid($kd){
		$kode = $this->input->get('kdprog').'.'.$kd;
		if($this->gm->valid_kode('ref_iku','KodeIku',$kode) == TRUE){
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	function add_process(){
		$option_program;
		foreach($this->gm->get_data('ref_program')->result() as $row){
			$option_program[$row->KodeProgram] = "[".$row->KodeProgram."] - ".$row->NamaProgram;
		}
		/*$option_iku;
		foreach($this->gm->get_data('ref_iku')->result() as $row){
			$option_iku[$row->KodeIku] = "[".$row->KodeIku."] - ".$row->Iku;
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
		$data['program'] = $option_program;
		//$data['opt_iku'] = $option_iku;
		$data['opt_status'] = $option_status;
		$data['tahun'] = $option_thn;
		$data['content'] = $this->load->view('form_master_data/form_tambah_iku',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_iku(){
		if($this->cek_validasi() == true){
			/*proses penambahan kode 0
			$KodeIku = explode('.',$this->gm->get_max_where('ref_iku','KodeIku','KodeProgram',$this->input->post('program')));
			$kd = $KodeIku[3]+1;
			$num_padded = str_pad($kd, 2, '0', STR_PAD_LEFT);
			*/
			//input ref_iku
			$Iku = array(
				'KodeProgram' => $this->input->post('program'),
				//'KodeIku' => $this->input->post('program').'.'.($num_padded),
				'KodeIku'	=> $this->input->post('program').'.'.$this->input->post('kdiku'),
				'Iku' => $this->input->post('Iku'),
				'KodeStatus' => $this->input->post('status'),
			);
			$this->gm->add('ref_iku',$Iku);
			
			//input target_iku
			/*$targetIku = array(
				'KodeIku' 			=> $this->input->post('program').'.'.($num_padded),
				'idThnAnggaran' 	=> $this->input->post('thn_anggaran'),
				'TargetNasional'	=> $this->input->post('targetiku')
			);
			$this->gm->add('target_iku', $targetIku);*/
			redirect('master_data/master_iku');
		}else{
			$this->add_process();
		}
	}
	
	function edit_proses($KodeIku){
		$Iku = $this->gm->get_where('ref_iku','KodeIku',$KodeIku);
		//$target = $this->gm->get_where_join('ref_iku','ref_iku.KodeIku',$KodeIku,'target_iku','target_iku.KodeIku=ref_iku.KodeIku');		
		$option_program;
		foreach($this->gm->get_data('ref_program')->result() as $row){
			$option_program[$row->KodeProgram] = "[".$row->KodeProgram."] - ".$row->NamaProgram;
		}
		$option_iku;
		foreach($this->gm->get_data('ref_iku')->result() as $row){
			$option_iku[$row->KodeIku] = "[".$row->KodeIku."] - ".$row->Iku;
		}
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		// $selected_thn;
		// foreach($this->gm->get_where_join('target_iku','target_iku.KodeIku',$KodeIku,'ref_tahun_anggaran','target_iku.idThnAnggaran=ref_tahun_anggaran.idThnAnggaran')->result() as $row){
			// $selected_thn[$row->idThnAnggaran] = $row->thn_anggaran;	
		// }
		// $option_thn;
		// foreach($this->gm->get_data('ref_tahun_anggaran')->result() as $row){
			// $option_thn[$row->idThnAnggaran] = $row->thn_anggaran;
		// }
		// $targetIku;
		// foreach($this->gm->get_where('target_iku','KodeIku',$KodeIku)->result() as $row){
			// $targetIku = $row->TargetNasional;
		// }
		$data['master_data'] = "";
		$data['program'] = $option_program;
		//$data['iku'] = $option_iku;
		$data['status'] = $option_status;
		// $data['tahun'] = $option_thn;
		$data['selected_program'] = $Iku->row()->KodeProgram;
		//$data['selected_iku'] = $Iku->row()->KodeIku;
		$data['selected_status'] = $Iku->row()->KodeStatus;
		// $data['selected_thn'] = $selected_thn;
		$data['Iku'] = $Iku->row()->Iku;
		$data['KodeIku'] = $KodeIku;
		// $data['TargetIku'] = $targetIku;
		$data['content'] = $this->load->view('form_master_data/form_edit_iku',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_Iku($KodeIku){
		if ($this->cek_validasi() == true){
			$data_Iku = array('Iku' => $this->input->post('Iku'));
			$this->gm->update('ref_iku',$data_Iku,'KodeIku',$KodeIku);
			redirect('master_data/master_iku');
		}else{
			$data['master_data'] = "";
			$Iku = $this->gm->get_where('ref_iku','KodeIku',$KodeIku);
			$option_program;
			foreach($this->gm->get_data('ref_program')->result() as $row){
				$option_program[$row->KodeProgram] = $row->NamaProgram;
			}
			$data['program'] = $option_program;
			$data['KodeProgram'] = $Iku->row()->KodeProgram;
			$data['Iku'] = $Iku->row()->Iku;
			$data['KodeIku'] = $KodeIku;
			$data['content'] = $this->load->view('form_master_data/form_edit_Iku',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function hapus($KodeIku){
		$this->gm->delete('data_iku','KodeIku',$KodeIku);
		$this->gm->delete('ref_satker_iku','KodeIku',$KodeIku);
		$this->gm->delete('ref_iku','KodeIku',$KodeIku);
		redirect('master_data/master_iku');
	}
	
	//detail iku
	function detail_iku($KodeIku)
	{
		$Iku = $this->gm->get_where('ref_iku','KodeIku',$KodeIku);
		$target = $this->gm->get_where_join('ref_iku','ref_iku.KodeIku',$KodeIku,'target_iku','target_iku.KodeIku=ref_iku.KodeIku');
		$option_program;
		foreach($this->gm->get_data('ref_program')->result() as $row){
			$option_program[$row->KodeProgram] = "[".$row->KodeProgram."] - ".$row->NamaProgram;
		}
		$option_iku;
		foreach($this->gm->get_data('ref_iku')->result() as $row){
			$option_iku[$row->KodeIku] = "[".$row->KodeIku."] - ".$row->Iku;
		}
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		$data['master_data'] = "";
		$data['program'] = $option_program;
		$data['iku'] = $option_iku;
		$data['status'] = $option_status;
		$data['selected_program'] = $Iku->row()->KodeProgram;
		$data['kodeIku'] = $Iku->row()->KodeIku;
		$data['Iku'] = $Iku->row()->Iku;
		$data['selected_status'] = $Iku->row()->KodeStatus;
		$data['KodeIku'] = $KodeIku;
		// $data['TargetIku'] = $target->row()->TargetNasional;
		$data['content'] = $this->load->view('form_master_data/form_detail_iku',$data,true);
		$this->load->view('main',$data);	
	}
	
	
	function grid_target_nasional($kodeiku){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['Iku'] = array('Iku',400,TRUE,'LEFT',1);
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
							'showTableToggleBtn' => false
							);
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_iku/list_target_nasional/".$kodeiku;
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_iku/add_target/".$kodeiku."';    
			}
		} </script>";
		
		$data['added_php'] = 
				"<div class=\"buttons\">
					<form action=\"".base_url()."index.php/master_data/master_iku\" method=\"POST\">
					<button type=\"submit\" class=\"regular\" name=\"cetak\">
						<img src=\"".base_url()."images/flexigrid/edit2.png\" alt=\"\"/>
						Master IKU
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

		$data['judul'] = 'Target Nasional Iku';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_target_nasional($kodeiku){
		$valid_fields = array('Iku', 'Tahun');
		$this->flexigrid->validate_post('ref_iku.KodeIku','asc',$valid_fields);
		$records = $this->gm->get_target_nasional_iku($kodeiku);
		/*$records = $this->gm->get_data_flexigrid_double_join('ref_iku','ref_program','ref_iku.KodeProgram=ref_program.KodeProgram','target_iku','ref_iku.KodeIku=target_iku.KodeIku');*/
		
		$this->output->set_header($this->config->item('json_header'));
		$kodeiku;
		$no =0;
		foreach ($records['records']->result() as $row){
			
			$no = $no+1;
			$record_items[] = array(
				$row->KodeIku,
				$no,
				$row->Iku,
				$row->thn_anggaran,
				//$row->TargetNasional,
				$row->TargetNasional,
				'<a href='.site_url().'/master_data/master_iku/edit_target/'.$row->KodeIku.'/'.$row->idThnAnggaran.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_iku/hapus_target/'.$row->KodeIku.'/'.$row->idThnAnggaran.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function hapus_target($KodeIku,$idTahun){
		$this->gm->delete_double_param('target_iku','KodeIku',$KodeIku,'idThnAnggaran',$idTahun);
		redirect('master_data/master_iku/grid_target_nasional/'.$KodeIku);
	}
	
	function edit_target($KodeIku,$idTahun){
		$option_thn;
		foreach($this->gm->get_data('ref_tahun_anggaran')->result() as $row){
			$option_thn[$row->idThnAnggaran] = $row->thn_anggaran;
		}
		$targetnasional;
		foreach($this->gm->get_double_where('target_iku','KodeIku',$KodeIku,'idThnAnggaran', $idTahun)->result() as $row){
			$targetnasional = $row->TargetNasional;
		}
		$data['tahun'] = $option_thn;
		$data['target'] = $targetnasional;
		$data['selected_tahun']= $idTahun;
		$data['kode_iku'] = $KodeIku;
		$data2['content'] = $this->load->view('form_master_data/form_edit_target_iku',$data,true);
		$this->load->view('main',$data2);
	}
	
	function update_target($KodeIku,$idTahun){
		$data = array(
			'TargetNasional' => $this->input->post('target_iku')
			);
		$this->gm->update_double_where('target_iku',$data,'KodeIku',$KodeIku,'idThnAnggaran',$idTahun);
		redirect('master_data/master_iku/grid_target_nasional/'.$KodeIku);
	}
}
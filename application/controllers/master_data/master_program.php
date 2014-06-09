<?php
class Master_program extends CI_Controller {
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
	
	function index(){
		redirect ('master_data/master_program/grid_program');
	}
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	
	function grid_program(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['KodeProgram'] = array('Kode Program',100,TRUE,'center',1);
		$colModel['NamaProgram'] = array('Nama Program',400,TRUE,'LEFT',1);
		$colModel['OutComeProgram'] = array('Output',400,TRUE,'LEFT',0);
		$colModel['Status'] = array('Status',100,TRUE,'center',0);
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
		$url = site_url()."/master_data/master_program/list_program";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_program/add_process';    
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
		$data['judul'] = 'Program';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_program(){	
		$valid_fields = array('KodeProgram','NamaProgram','OutComeProgram');
		$this->flexigrid->validate_post('KodeProgram','asc',$valid_fields);
		$records = $this->gm->get_data_flexigrid_join('ref_program','status_program','ref_program.KodeStatus=status_program.KodeStatus');
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->KodeProgram,
				$no,
				$row->KodeProgram,
				$row->NamaProgram,
				$row->OutComeProgram,
				$row->Status,
				'<a href=\''.site_url().'/master_data/master_program/detail_program/'.$row->KodeProgram.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/master_data/master_program/edit_proses/'.$row->KodeProgram.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_program/hapus/'.$row->KodeProgram.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('kode_program', 'Kode Program', 'required|exact_length[2]|numeric');
		$this->form_validation->set_rules('program', 'Program', 'required');
		$this->form_validation->set_rules('output', 'Output', 'required');
		
		$this->form_validation->set_message('required', '%s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	function cek_validasi_update(){
		// $this->form_validation->set_rules('kode_program', 'Kode Program', 'required|exact_length[2]|numeric');
		$this->form_validation->set_rules('program', 'Program', 'required');
		$this->form_validation->set_rules('output', 'Output', 'required');
		
		$this->form_validation->set_message('required', '%s harus diisi !!');
		
		return $this->form_validation->run();
	}
	//proses validasi kode
	function valid($kode){
		/*$kode = $this->input->get('kode');
		$kdunit = '024.01'.'.'.$kode;*/
		/*$kdunit = $this->input->get('kdunit');
		$kode = $this->input->get('kode');
		$kd = $kdunit.'.'.$kode;*/
		$kdunit = $this->input->get('kdunit').'.'.$kode;
		if($this->gm->valid_kode('ref_program','KodeProgram',$kdunit) == TRUE){
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	function add_process(){
		/*foreach($this->gm->get_data('ref_program')->result() as $tes){
			foreach($this->gm->get_where('ref_program','KodeProgram',$tes->KodeProgram)->result() as $tes2);	
		}*/
		$option_unit_org;
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
			$option_unit_org[$row->KodeUnitOrganisasi] = "[".$row->KodeUnitOrganisasi."] - ".$row->NamaUnitOrganisasi;
		}
		$data['unit_organisasi'] = $option_unit_org;
		$data['status'] = $option_status;
		//$data['kode_program'] = $tes2->KodeProgram;
		$data['content'] = $this->load->view('form_master_data/form_tambah_program',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_program(){
		if($this->cek_validasi() == true){
			/*proses penambahan kode 0
			$kode = explode('.',$this->gm->get_max_where('ref_program','KodeProgram','KodeUnitOrganisasi',$this->input->post('unit_organisasi')));
			$kd = $kode[2]+1;
			$num_padded = str_pad($kd, 2, '0', STR_PAD_LEFT);*/
			
			//input ref_program
			$program = array(
				'KodeUnitOrganisasi' => $this->input->post('unit_organisasi'),
				'KodeProgram' => $this->input->post('unit_organisasi').'.'.$this->input->post('kode_program'),
				'KodeKementerian' => '024',
				'NamaProgram' => $this->input->post('program'),
				'OutComeProgram' => $this->input->post('output'),
				'KodeStatus' => $this->input->post('status')
			);
			$this->gm->add('ref_program',$program);
			
			
			//input t_program
			$temp = explode('.', $this->input->post('unit_organisasi').'.'.$this->input->post('kode_program'));
			$t_program = array(
				'kddept' => $temp[0],
				'kdunit' => $temp[1],
				'kdprogram' => $temp[2],
				'nmprogram' => $this->input->post('program')
			);
			$this->gm->add('t_program',$t_program);
			redirect('master_data/master_program');
		}else{
			$option_unit_org;
			$option_status;
			foreach($this->gm->get_data('status_program')->result() as $row){
				$option_status[$row->KodeStatus] = $row->Status;
			}
			foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
				$option_unit_org[$row->KodeUnitOrganisasi] = "[".$row->KodeUnitOrganisasi."] - ".$row->NamaUnitOrganisasi;
			}
			$data['unit_organisasi'] = $option_unit_org;
			$data['status'] = $option_status;
			$data['content'] = $this->load->view('form_master_data/form_tambah_program',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function edit_proses($KodeProgram){
		$program = $this->gm->get_where('ref_program','KodeProgram',$KodeProgram);
		$option_unit_org;
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
			$option_unit_org[$row->KodeUnitOrganisasi] = "[".$row->KodeUnitOrganisasi."] - ".$row->NamaUnitOrganisasi;
		}
		$data['unit_organisasi'] = $option_unit_org;
		$data['status'] = $option_status;
		$data['selected_unit_organisasi'] = $program->row()->KodeUnitOrganisasi;
		$data['selected_status'] = $program->row()->KodeStatus;
		$data['output'] = $program->row()->OutComeProgram;
		$data['program'] = $program->row()->NamaProgram;
		$data['KodeProgram'] = $KodeProgram;
		$data['content'] = $this->load->view('form_master_data/form_edit_program',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_program($KodeProgram){
		if ($this->cek_validasi_update() == true){
		//	$unit_org = foreach($this->gm->get_data('ref_program')->result() as $row);
			
			/*$kode = $this->gm->get_max_where('ref_program','KodeProgram','KodeUnitOrganisasi',$this->input->post('unit_organisasi'));
			$temp = explode('.',$kode);
			$kode_program = $this->input->post('unit_organisasi').'.'.($temp[2]+1);*/
			$kode = $this->gm->get_temp('ref_program','KodeProgram',$KodeProgram);
			$temp = explode('.',$kode);
			$kdunit = $temp[1];
			$kdprog = $temp[2];
			
			//update ref_program
			$program = array(
				'NamaProgram' => $this->input->post('program'),
				'OutComeProgram' => $this->input->post('output'),
				'KodeStatus' => $this->input->post('status')
			);
			$this->gm->update('ref_program',$program,'KodeProgram',$KodeProgram);
			
			//update t_program
			$t_program = array(
				'nmprogram' => $this->input->post('program')
			);
			$this->gm->update_double_where('t_program',$t_program,'kdunit',$kdunit,'kdprogram',$kdprog);
			redirect('master_data/master_program');
		}else{
			$program = $this->gm->get_where('ref_program','KodeProgram',$KodeProgram);
			$option_unit_org;
			$option_status;
			foreach($this->gm->get_data('status_program')->result() as $row){
				$option_status[$row->KodeStatus] = $row->Status;
			}
			foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
				$option_unit_org[$row->KodeUnitOrganisasi] = $row->NamaUnitOrganisasi;
			}
			$data['unit_organisasi'] = $option_unit_org;
			$data['status'] = $option_status;
			$data['selected_unit_organisasi'] = $program->row()->KodeUnitOrganisasi;
			$data['selected_status'] = $program->row()->KodeStatus;
			$data['output'] = $program->row()->OutComeProgram;
			$data['program'] = $program->row()->NamaProgram;
			$data['KodeProgram'] = $KodeProgram;
			$data['content'] = $this->load->view('form_master_data/form_edit_program',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function hapus($KodeProgram){
		//hapus t_program
		$prog = $this->gm->get_temp('ref_program','KodeProgram',$KodeProgram);
		$temp = explode('.',$prog);
		$this->gm->delete_double_param('t_program','kdunit',$temp[1],'kdprogram',$temp[2]);
		
		$this->gm->delete('data_menu_kegiatan','KodeProgram',$KodeProgram);
		$this->gm->delete('data_ikk','KodeProgram',$KodeProgram);
		$this->gm->delete('data_iku','KodeProgram',$KodeProgram);
		$this->gm->delete('data_kegiatan','KodeProgram',$KodeProgram);
		$this->gm->delete('data_program','KodeProgram',$KodeProgram);
		$iku = '';
		foreach($this->gm->get_where('ref_iku','KodeProgram',$KodeProgram)->result() as $row){
			$iku[$row->KodeIku]=$row->KodeIku;
		}
		$this->gm->delete('ref_satker_program', 'KodeProgram', $KodeProgram);
		$this->gm->delete_in('ref_satker_iku', 'KodeIku', $iku);
		$this->gm->delete('ref_menu_kegiatan', 'KodeProgram', $KodeProgram);
		$this->gm->delete('ref_iku', 'KodeProgram', $KodeProgram);
		$this->gm->delete('ref_program','KodeProgram',$KodeProgram);
		
		redirect('master_data/master_program');
	}
	
	//detail program
	function detail_program($KodeProgram)
	{
		$program = $this->gm->get_where('ref_program','KodeProgram',$KodeProgram);
		$option_unit_org;
		$option_status;
		foreach($this->gm->get_data('status_program')->result() as $row){
			$option_status[$row->KodeStatus] = $row->Status;
		}
		foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
			$option_unit_org[$row->KodeUnitOrganisasi] = "[".$row->KodeUnitOrganisasi."] - ".$row->NamaUnitOrganisasi;
		}
		$data['unit_organisasi'] = $option_unit_org;
		$data['status'] = $option_status;
		$data['selected_unit_organisasi'] = $program->row()->KodeUnitOrganisasi;
		$data['selected_status'] = $program->row()->KodeStatus;
		$data['output'] = $program->row()->OutComeProgram;
		$data['program'] = $program->row()->NamaProgram;
		$data['KodeProgram'] = $KodeProgram;
		$data['content'] = $this->load->view('form_master_data/form_detail_program',$data,true);
		$this->load->view('main',$data);
	}
}
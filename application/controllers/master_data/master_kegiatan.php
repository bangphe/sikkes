<?php
class Master_kegiatan extends CI_Controller {
	
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
		redirect ('master_data/master_kegiatan/grid_kegiatan');
	}
	
	function grid_kegiatan(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['KodeKegiatan'] = array('Kode Kegiatan',100,TRUE,'center',1);
		$colModel['NamaProgram'] = array('Nama Program',400,TRUE,'LEFT',1);
		$colModel['NamaKegiatan'] = array('Nama Kegiatan',400,TRUE,'LEFT',1);
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
		$url = site_url()."/master_data/master_kegiatan/list_kegiatan";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_kegiatan/add_process';    
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

		$data['judul'] = 'Kegiatan';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_kegiatan(){	
		$valid_fields = array('KodeKegiatan','KodeProgram','KodeKegiatan','NamaKegiatan');
		$this->flexigrid->validate_post('KodeKegiatan','asc',$valid_fields);
	$records = $this->gm->get_data_flexigrid_join('ref_kegiatan','ref_program','ref_kegiatan.KodeProgram=ref_program.KodeProgram');
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->KodeKegiatan,
				$no,
				$row->KodeKegiatan,
				$row->NamaProgram,
				$row->NamaKegiatan,
				'<a href=\''.site_url().'/master_data/master_kegiatan/detail_kegiatan/'.$row->KodeKegiatan.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/master_data/master_kegiatan/edit_proses/'.$row->KodeKegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_kegiatan/hapus/'.$row->KodeKegiatan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('kdkeg', 'Kode Kegiatan', 'required');
		$this->form_validation->set_rules('subfungsi', 'Sub Fungsi', 'required');
		$this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');
		
		$this->form_validation->set_message('required', '%s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	//proses validasi kode
	function valid($kode){
		if($this->gm->valid_kode('ref_kegiatan', 'KodeKegiatan', $kode) == TRUE){
		//	$this->form_validation->set_message('validasi_kode', 'Kode $kode telah dipakai!!');
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	function add_process(){
		$option_unit_org;
		//$option_program;
		$option_fungsi;
		$option_unit_org['0'] = '--- Pilih Unit ---';
		foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
			$option_unit_org[$row->KodeUnitOrganisasi] = "[".$row->KodeUnitOrganisasi."] - ".$row->NamaUnitOrganisasi;
		}
		// foreach($this->gm->get_data('ref_program')->result() as $row){
			// $option_program[$row->KodeProgram] = "[".$row->KodeProgram."] - ".$row->NamaProgram;
		// }
		foreach($this->gm->get_data('ref_fungsi')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = "[".$row->KodeFungsi."] - ".$row->NamaFungsi;
		}
		$data['added_js'] =
		"<script>
			function get_subfungsi(kd){
				var prp = kd.value;
					$.ajax({
						url: \"".base_url()."index.php/master_data/master_kegiatan/get_subfungsi\",
						global: false,
						type: \"POST\",
						async: false,
						dataType: \"html\",
						data: \"kdfungsi=\"+ prp, //the name of the $_POST variable and its value
						success: function (response) {
							var dynamic_options2 = $(\"*\").index( $('.dynamic2')[0] );
							if ( dynamic_options2 != (-1)) 
							    $(\".dynamic2\").remove();
								$(\"#subfungsi\").append(response);
								$(\".third\").attr({selected: ' selected'});
						}          
					});
				  return false;
			}
			function get_program(kdu){
				var pr = kdu.value;
					$.ajax({
						url: \"".base_url()."index.php/master_data/master_kegiatan/get_program\",
						global: false,
						type: \"POST\",
						async: false,
						dataType: \"html\",
						data: \"kdunit=\"+ pr, //the name of the $_POST variable and its value
						success: function (response) {
							var dynamic_options2 = $(\"*\").index( $('.dynamic3')[0] );
							if ( dynamic_options2 != (-1)) 
								$(\".dynamic3\").remove();
								$(\"#program\").append(response);
								$(\".third\").attr({selected: ' selected'});
						}          
					});
				  return false;
			}
		</script>";
		$data['master_data'] = "";
		$data['fungsi'] = $option_fungsi;
		$data['unit_organisasi'] = $option_unit_org;
		//$data['program'] = $option_program;
		$data['kode_kegiatan'] = $this->gm->get_max('ref_kegiatan','KodeKegiatan')+1;
		$data['content'] = $this->load->view('form_master_data/form_tambah_kegiatan',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_kegiatan(){
		if($this->cek_validasi() == true){
			//input ref_kegiatan
			$kdkeg = $this->gm->get_max('ref_kegiatan','KodeKegiatan')+1;
			$kegiatan = array(
				//'KodeKegiatan' => $kdkeg,
				'KodeKegiatan' => $this->input->post('kdkeg'),
				'KodeKementerian' => '024',
				'KodeUnitOrganisasi' => $this->input->post('unit_organisasi'),
				'KodeProgram' => $this->input->post('program'),
				'KodeFungsi' => $this->input->post('fungsi'),
				'KodeSubFungsi' => $this->input->post('fungsi').'.'.$this->input->post('subfungsi'),
				'NamaKegiatan' => $this->input->post('kegiatan')
			);
			$this->gm->add('ref_kegiatan',$kegiatan);
			
			//input t_giat
			$kode = $this->gm->get_max_where('ref_kegiatan','KodeProgram','KodeProgram',$this->input->post('program'));
			$temp = explode('.',$kode);
			$t_giat = array(
				//'kdgiat' => $kdkeg,
				'kdgiat' => $this->input->post('kdkeg'),
				'nmgiat' => $this->input->post('kegiatan'),
				'kddept' => $temp[0],
				'kdunit' => $temp[1],
				'kdprogram' => $temp[2]
			);
			$this->gm->add('t_giat',$t_giat);
			redirect('master_data/master_kegiatan');
		}else{
			$option_unit_org;
			//$option_program;
			$option_fungsi;
			foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
				$option_unit_org[$row->KodeUnitOrganisasi] = $row->NamaUnitOrganisasi;
			}
			// foreach($this->gm->get_data('ref_program')->result() as $row){
				// $option_program[$row->KodeProgram] = $row->NamaProgram;
			// }
			foreach($this->gm->get_data('ref_fungsi')->result() as $row){
				$option_fungsi[$row->KodeFungsi] = $row->NamaFungsi;
			}
			$data['added_js'] =
			"<script>
				function get_subfungsi(kd){
					var prp = kd.value;
						$.ajax({
							url: \"".base_url()."index.php/master_data/master_kegiatan/get_subfungsi/\",
							global: false,
							type: \"POST\",
							async: false,
							dataType: \"html\",
							data: \"kdfungsi=\"+ prp, //the name of the $_POST variable and its value
							success: function (response) {
								var dynamic_options2 = $(\"*\").index( $('.dynamic2')[0] );
								if ( dynamic_options2 != (-1)) 
									$(\"#subfungsi\").append(response);
									$(\".third\").attr({selected: ' selected'});
							}          
						});
					  return false;
				}
			</script>";
			$data['added_js'] =
			"<script>
			function get_program(kdu){
					var pr = kdu.value;
						$.ajax({
							url: \"".base_url()."index.php/master_data/master_kegiatan/get_program/\",
							global: false,
							type: \"POST\",
							async: false,
							dataType: \"html\",
							data: \"kdunit=\"+ pr, //the name of the $_POST variable and its value
							success: function (response) {
								var dynamic_options2 = $(\"*\").index( $('.dynamic3')[0] );
								if ( dynamic_options2 != (-1)) 
									$(\".dynamic3\").remove();
									$(\"#program\").append(response);
									$(\".third\").attr({selected: ' selected'});
							}          
						});
					  return false;
				}
			</script>";
			
			$data['master_data'] = "";
			$data['fungsi'] = $option_fungsi;
			$data['unit_organisasi'] = $option_unit_org;
			//$data['program'] = $option_program;
			$data['content'] = $this->load->view('form_master_data/form_tambah_kegiatan',$data,true);
			$this->load->view('main',$data);
		}
	}
	
	function get_subfungsi(){
		if ($_POST['kdfungsi']!='') {
			$options_sub_fungsi =''; 		
			$parent = $_POST['kdfungsi'];
			
			$result	= $this->gm->get_where('ref_sub_fungsi','KodeFungsi',$parent);
			foreach ($result->result() as $row){
				$options_sub_fungsi.= '<option value="'.$row->KodeSubFungsi.'" class="dynamic2">'."[".$row->KodeSubFungsi."] - ".$row->NamaSubFungsi.'</option>';
			}
			echo $options_sub_fungsi;
		}
	}
	
	function get_program(){
		if ($_POST['kdunit']!='') {
			$options_program =''; 		
			$parents = $_POST['kdunit'];
			
			$result	= $this->gm->get_where('ref_program','KodeUnitOrganisasi',$parents);
			foreach ($result->result() as $row){
				$options_program.= '<option value="'.$row->KodeProgram.'" class="dynamic3">'."[".$row->KodeProgram."] - ".$row->NamaProgram.'</option>';
			}
			echo $options_program;
		}
	}
	
	function edit_proses($KodeKegiatan){
		$kegiatan = $this->gm->get_where('ref_kegiatan','KodeKegiatan',$KodeKegiatan);
		$option_unit_org;
		$option_program;
		$option_fungsi;
		$option_subfungsi;
		foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
			$option_unit_org[$row->KodeUnitOrganisasi] = "[".$row->KodeUnitOrganisasi."] - ".$row->NamaUnitOrganisasi;
		}
		foreach($this->gm->get_where('ref_program','KodeUnitOrganisasi',$kegiatan->row()->KodeUnitOrganisasi)->result() as $row){
			$option_program[$row->KodeProgram] = "[".$row->KodeProgram."] - ".$row->NamaProgram;
		}
		foreach($this->gm->get_data('ref_fungsi')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = "[".$row->KodeFungsi."] - ".$row->NamaFungsi;
		}
		foreach($this->gm->get_where('ref_sub_fungsi','KodeFungsi',$kegiatan->row()->KodeFungsi)->result() as $row){
			$option_subfungsi[$row->KodeSubFungsi] = "[".$row->KodeSubFungsi."] - ".$row->NamaSubFungsi;
		}
		$data['added_js'] =
		"<script>
			function get_subfungsi(kd){
				var prp = kd.value;
					$.ajax({
						url: \"".base_url()."index.php/master_data/master_kegiatan/get_subfungsi\",
						global: false,
						type: \"POST\",
						async: false,
						dataType: \"html\",
						data: \"kdfungsi=\"+ prp, //the name of the $_POST variable and its value
						success: function (response) {
							var dynamic_options2 = $(\"*\").index( $('.dynamic2')[0] );
							if ( dynamic_options2 != (-1)) 
							    $(\".dynamic2\").remove();
								$(\"#subfungsi\").append(response);
								$(\".third\").attr({selected: ' selected'});
						}          
					});
				  return false;
			}
			function get_program(kdu){
				var pr = kdu.value;
					$.ajax({
						url: \"".base_url()."index.php/master_data/master_kegiatan/get_program\",
						global: false,
						type: \"POST\",
						async: false,
						dataType: \"html\",
						data: \"kdunit=\"+ pr, //the name of the $_POST variable and its value
						success: function (response) {
							var dynamic_options2 = $(\"*\").index( $('.dynamic3')[0] );
							if ( dynamic_options2 != (-1)) 
								$(\"#program\").append(response);
								$(\".third\").attr({selected: ' selected'});
						}          
					});
				  return false;
			}
		</script>";
		$data['master_data'] = "";
		$selected_subfungsi = explode('.',$kegiatan->row()->KodeSubFungsi);
		$selected_program = explode('.',$kegiatan->row()->KodeUnitOrganisasi);
		$data['fungsi'] = $option_fungsi;
		$data['unit_organisasi'] = $option_unit_org;
		$data['program'] = $option_program;
		$data['subfungsi'] = $option_subfungsi;
		$data['selected_fungsi'] = $kegiatan->row()->KodeFungsi;
		$data['selected_unit_organisasi'] = $kegiatan->row()->KodeUnitOrganisasi;
		$data['selected_program'] = $selected_program[1];
		$data['selected_subfungsi'] = $selected_subfungsi[1];
		$data['kegiatan'] = $kegiatan->row()->NamaKegiatan;
		$data['KodeKegiatan'] = $KodeKegiatan;
		$data['content'] = $this->load->view('form_master_data/form_edit_kegiatan',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_kegiatan($KodeKegiatan){
		if ($this->cek_validasi() == true){
			//update ref_kegiatan
			$kegiatan = array(
				'KodeUnitOrganisasi' => $this->input->post('unit_organisasi'),
				'KodeProgram' => $this->input->post('program'),
				'KodeFungsi' => $this->input->post('fungsi'),
				'KodeSubFungsi' => $this->input->post('fungsi').'.'.$this->input->post('subfungsi'),
				'NamaKegiatan' => $this->input->post('kegiatan')
			);
			$this->gm->update('ref_kegiatan',$kegiatan,'KodeKegiatan',$KodeKegiatan);
			
			/*//update t_giat
			$kode = $this->gm->get_max_where('ref_kegiatan','KodeProgram','KodeProgram',$this->input->post('program'));
			$temp = explode('.',$kode);
			$t_giat = array(
				'kdgiat' => $kdkeg,
				'nmgiat' => $this->input->post('kegiatan'),
				'kddept' => $temp[0],
				'kdunit' => $temp[1],
				'kdprogram' => $temp[2]
			);
			$this->gm->update('t_giat',$t_giat,'kdgiat',$KodeKegiatan);*/
			redirect('master_data/master_kegiatan');
		}else{
			$kegiatan = $this->gm->get_where('ref_kegiatan','KodeKegiatan',$KodeKegiatan);
			$option_unit_org;
			$option_program;
			$option_fungsi;
			$option_subfungsi;
			foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
				$option_unit_org[$row->KodeUnitOrganisasi] = $row->NamaUnitOrganisasi;
			}
			foreach($this->gm->get_where('ref_program','KodeUnitOrganisasi',$kegiatan->row()->KodeUnitOrganisasi)->result() as $row){
				$option_program[$row->KodeProgram] = $row->NamaProgram;
			}
			foreach($this->gm->get_data('ref_fungsi')->result() as $row){
				$option_fungsi[$row->KodeFungsi] = $row->NamaFungsi;
			}
			foreach($this->gm->get_where('ref_sub_fungsi','KodeFungsi',$kegiatan->row()->KodeFungsi)->result() as $row){
				$option_subfungsi[$row->KodeSubFungsi] = $row->NamaSubFungsi;
			}
			$data['master_data'] = "";
			$selected_subfungsi = explode('.',$kegiatan->row()->KodeSubFungsi);
			// $selected_program = explode('.',$kegiatan->row()->KodeProgram);
			$data['fungsi'] = $option_fungsi;
			$data['unit_organisasi'] = $option_unit_org;
			$data['program'] = $option_program;
			$data['subfungsi'] = $option_subfungsi;
			$data['selected_fungsi'] = $kegiatan->row()->KodeFungsi;
			$data['selected_unit_organisasi'] = $kegiatan->row()->KodeUnitOrganisasi;
			$data['selected_program'] = $kegiatan->row()->KodeProgram;
			$data['selected_subfungsi'] = $selected_subfungsi[1];
			$data['kegiatan'] = $kegiatan->row()->NamaKegiatan;
			$data['KodeKegiatan'] = $KodeKegiatan;
			$data['content'] = $this->load->view('form_master_data/form_edit_kegiatan',$data,true);
			$this->load->view('main',$data);
		}
	}
	function getprogram($kode)
	{
		$query = $this->gm->get_where('ref_program','KodeUnitOrganisasi',$kode);
		$i=0;
		foreach($query->result() as $row)
		{	
			$datajson[$i]['KodeProg'] = $row->KodeProgram;
			$datajson[$i]['NamaProg'] = $row->NamaProgram;
			$i++;
		}
		echo json_encode($datajson);
	}
	
	function hapus($KodeKegiatan){
		$this->gm->delete('data_menu_kegiatan','KodeKegiatan',$KodeKegiatan);
		$this->gm->delete('data_ikk','KodeKegiatan',$KodeKegiatan);
		$this->gm->delete('data_kegiatan','KodeKegiatan',$KodeKegiatan);
		$ikk = '';
		foreach($this->gm->get_where('ref_ikk','KodeKegiatan',$KodeKegiatan)->result() as $row){
			$ikk[$row->KodeIkk]=$row->KodeIkk;
		}
		$this->gm->delete('ref_satker_kegiatan', 'KodeKegiatan', $KodeKegiatan);
		$this->gm->delete_in('ref_satker_ikk', 'KodeIkk', $ikk);
		$this->gm->delete('ref_menu_kegiatan', 'KodeKegiatan', $KodeKegiatan);
		$this->gm->delete('ref_ikk', 'KodeKegiatan', $KodeKegiatan);
		$this->gm->delete('ref_kegiatan','KodeKegiatan',$KodeKegiatan);
		$this->gm->delete('t_giat','kdgiat',$KodeKegiatan);
		redirect('master_data/master_kegiatan');
	}
	
	//detail kegiatan
	function detail_kegiatan($KodeKegiatan){
		$kegiatan = $this->gm->get_where('ref_kegiatan','KodeKegiatan',$KodeKegiatan);
		$option_unit_org;
		$option_program;
		$option_fungsi;
		$option_subfungsi;
		foreach($this->gm->get_data('ref_unit_organisasi')->result() as $row){
			$option_unit_org[$row->KodeUnitOrganisasi] = "[".$row->KodeUnitOrganisasi."] - ".$row->NamaUnitOrganisasi;
		}
		foreach($this->gm->get_where('ref_program','KodeUnitOrganisasi',$kegiatan->row()->KodeUnitOrganisasi)->result() as $row){
			$option_program[$row->KodeProgram] = "[".$row->KodeProgram."] - ".$row->NamaProgram;
		}
		foreach($this->gm->get_data('ref_fungsi')->result() as $row){
			$option_fungsi[$row->KodeFungsi] = "[".$row->KodeFungsi."] - ".$row->NamaFungsi;
		}
		foreach($this->gm->get_where('ref_sub_fungsi','KodeFungsi',$kegiatan->row()->KodeFungsi)->result() as $row){
			$option_subfungsi[$row->KodeSubFungsi] = "[".$row->KodeSubFungsi."] - ".$row->NamaSubFungsi;
		}
		$data['master_data'] = "";
		$selected_subfungsi = explode('.',$kegiatan->row()->KodeSubFungsi);
		$selected_program = explode('.',$kegiatan->row()->KodeUnitOrganisasi);
		$data['fungsi'] = $option_fungsi;
		$data['unit_organisasi'] = $option_unit_org;
		$data['program'] = $option_program;
		$data['subfungsi'] = $option_subfungsi;
		$data['selected_fungsi'] = $kegiatan->row()->KodeFungsi;
		$data['selected_unit_organisasi'] = $kegiatan->row()->KodeUnitOrganisasi;
		$data['selected_program'] = $selected_program[1];
		$data['selected_subfungsi'] = $selected_subfungsi[1];
		$data['kegiatan'] = $kegiatan->row()->NamaKegiatan;
		$data['KodeKegiatan'] = $KodeKegiatan;
		$data['content'] = $this->load->view('form_master_data/form_detail_kegiatan',$data,true);
		$this->load->view('main',$data);
	}
}

<?php
class Master_menu_kegiatan extends CI_Controller {
	
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
		redirect ('master_data/master_menu_kegiatan/grid_menu_kegiatan');
	}
	
	function grid_menu_kegiatan(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['Ikk'] = array('Ikk',430,TRUE,'LEFT',0);
		$colModel['MenuKegiatan'] = array('Menu Kegiatan',450,TRUE,'LEFT',1);
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
		$url = site_url()."/master_data/master_menu_kegiatan/list_menu_kegiatan";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/master_data/master_menu_kegiatan/add_process';    
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

		$data['judul'] = 'Menu Kegiatan';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_menu_kegiatan(){
		$valid_fields = array('KodeIkk','KodeMenuKegiatan','MenuKegiatan');
		$this->flexigrid->validate_post('ref_menu_kegiatan.KodeMenuKegiatan','asc',$valid_fields);
		$records = $this->gm->get_data_flexigrid_join('ref_menu_kegiatan','ref_ikk','ref_menu_kegiatan.KodeIkk=ref_ikk.KodeIkk');
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->KodeIkk,
				$no,
				$row->Ikk,
				$row->MenuKegiatan,
				'<a href=\''.site_url().'/master_data/master_menu_kegiatan/detail/'.$row->KodeMenuKegiatan.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
				'<a href='.site_url().'/master_data/master_menu_kegiatan/edit_proses/'.$row->KodeMenuKegiatan.'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
				'<a href='.site_url().'/master_data/master_menu_kegiatan/hapus/'.$row->KodeMenuKegiatan.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>',
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function cek_validasi(){
		$this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');
		$this->form_validation->set_rules('ikk', 'Ikk', 'required');
		$this->form_validation->set_rules('menu_kegiatan', 'Menu Kegiatan', 'required');
		$this->form_validation->set_message('required', '%s harus diisi !!');
		
		return $this->form_validation->run();
	}
	
	//proses validasi kode
	function valid($kode){
		if($this->gm->valid_kode('ref_menu_kegiatan','KodeMenuKegiatan',$kode) == TRUE){
		//	$this->form_validation->set_message('validasi_kode', 'Kode $kode telah dipakai!!');
			echo 'FALSE';
		}
		else
			echo 'TRUE';
	}
	
	function add_process(){
		$option_program[0] = '--- Pilih Program ---';
		foreach($this->gm->get_data('ref_program')->result() as $row){
			$option_program[$row->KodeProgram] = '['.$row->KodeProgram.'] - '.$row->NamaProgram;
		}
		$option_kegiatan[0] = '--- Pilih Kegiatan ---';
		$option_ikk[0] = '--- Pilih IKK ---';
		$data['added_js'] =
		"<script>
			function get_kegiatan(kd){
				var prp = kd.value;
					$.ajax({
						url: \"".base_url()."index.php/master_data/master_menu_kegiatan/get_kegiatan\",
						global: false,
						type: \"POST\",
						async: false,
						dataType: \"html\",
						data: \"kdprogram=\"+ prp, //the name of the $_POST variable and its value
						success: function (response) {
							var dynamic_options2 = $(\"*\").index( $('.dynamic2')[0] );
							if ( dynamic_options2 != (-1)) 
								$(\".dynamic2\").remove();
								$(\"#kegiatan\").append(response);
								$(\".third\").attr({selected: ' selected'});
						}          
					});
				  return false;
			}
			
			function get_ikk(kd){
				var pr = kd.value;
					$.ajax({
						url: \"".base_url()."index.php/master_data/master_menu_kegiatan/get_ikk\",
						global: false,
						type: \"POST\",
						async: false,
						dataType: \"html\",
						data: \"kdkegiatan=\"+ pr, //the name of the $_POST variable and its value
						success: function (response) {
							var dynamic_options2 = $(\"*\").index( $('.dynamic3')[0] );
							if ( dynamic_options2 != (-1)) 
								$(\".dynamic3\").remove();
								$(\"#ikk\").append(response);
								$(\".third\").attr({selected: ' selected'});
						}         
					});
				  return false;
			}
		</script>";
		$data['master_data'] = "";
		$data['program'] = $option_program;
		$data['kegiatan'] = $option_kegiatan;
		$data['ikk'] = $option_ikk;
		$data['content'] = $this->load->view('form_master_data/form_tambah_menu_kegiatan',$data,true);
		$this->load->view('main',$data);
	}
	
	function get_kegiatan(){
		if ($_POST['kdprogram']!='') {
			$options_kegiatan =''; 		
			$parent = $_POST['kdprogram'];
			
			$result	= $this->gm->get_where('ref_kegiatan','KodeProgram',$parent);
			foreach ($result->result() as $row){
				$options_kegiatan.= '<option value="'.$row->KodeKegiatan.'" class="dynamic2">'."[".$row->KodeKegiatan."] - ".$row->NamaKegiatan.'</option>';
			}
			echo $options_kegiatan;
		}
	}
	
	function get_ikk(){
		if ($_POST['kdkegiatan']!='') {
			$options_ikk =''; 		
			$parent = $_POST['kdkegiatan'];
			
			$result	= $this->gm->get_where('ref_ikk','KodeKegiatan',$parent);
			foreach ($result->result() as $row){
				$options_ikk.= '<option value="'.$row->KodeIkk.'" class="dynamic3">'."[".$row->KodeIkk."] - ".$row->Ikk.'</option>';
			}
			echo $options_ikk;
		}
	}
	
	function get_keg($kode)
	{
		$query = $this->gm->get_where('ref_kegiatan','KodeProgram',$kode);
		$i=0;
		foreach($query->result() as $row)
		{	
			$datajson[$i]['KodeKeg'] = $row->KodeKegiatan;
			$datajson[$i]['NamaKeg'] = $row->NamaKegiatan;
			$i++;
		}
		echo json_encode($datajson);
	}
	
	function get_ikk_($kode)
	{
		$query = $this->gm->get_where('ref_ikk','KodeKegiatan',$kode);
		$i=0;
		foreach($query->result() as $row)
		{	
			$datajson[$i]['KodeIkk'] = $row->KodeIkk;
			$datajson[$i]['Ikk'] = $row->Ikk;
			$i++;
		}
		echo json_encode($datajson);
	}
	
	function save_menu_kegiatan(){
		if($this->cek_validasi() == true){
			$menu_kegiatan = array(
				//'KodeMenuKegiatan' => $this->gm->get_max('ref_menu_kegiatan','KodeMenuKegiatan')+1,
				'KodeIkk' => $this->input->post('ikk'),
				'KodeKegiatan' => $this->input->post('kegiatan'),
				'KodeProgram' => $this->input->post('program'),
				'KodeMenuKegiatan' => $this->input->post('kode_menu_kegiatan'),
				'MenuKegiatan' => $this->input->post('menu_kegiatan')
			);
			$this->gm->add('ref_menu_kegiatan',$menu_kegiatan);
			redirect('master_data/master_menu_kegiatan');
		}else{
			$this->add_process();
		}
	}
	
	function edit_proses($KodeMenuKegiatan){
		$menu_kegiatan = $this->gm->get_where('ref_menu_kegiatan','KodeMenuKegiatan',$KodeMenuKegiatan);
		$option_program[0] = '--- Pilih Program ---';
		foreach($this->gm->get_data('ref_program')->result() as $row){
			$option_program[$row->KodeProgram] = '['.$row->KodeProgram.'] - '.$row->NamaProgram;
		}
		$option_kegiatan[0] = '--- Pilih Kegiatan ---';
		foreach($this->gm->get_where('ref_kegiatan','KodeProgram',$menu_kegiatan->row()->KodeProgram)->result() as $row){
			$option_kegiatan[$row->KodeKegiatan] = '['.$row->KodeKegiatan.'] - '.$row->NamaKegiatan;
		}
		$option_ikk[0] = '--- Pilih IKK ---';
		foreach($this->gm->get_where('ref_ikk','KodeKegiatan',$menu_kegiatan->row()->KodeKegiatan)->result() as $row){
			$option_ikk[$row->KodeIkk] = '['.$row->KodeIkk.'] - '.$row->Ikk;
		}
		$data['program'] = $option_program;
		$data['kegiatan'] = $option_kegiatan;
		$data['ikk'] = $option_ikk;
		$data['selected_ikk'] = $menu_kegiatan->row()->KodeIkk;
		$data['selected_kegiatan'] = $menu_kegiatan->row()->KodeKegiatan;
		$data['selected_program'] = $menu_kegiatan->row()->KodeProgram;
		$data['menu_kegiatan'] = $menu_kegiatan->row()->MenuKegiatan;
		$data['KodeMenuKegiatan'] = $KodeMenuKegiatan;
		$data['content'] = $this->load->view('form_master_data/form_edit_menu_kegiatan',$data,true);
		$this->load->view('main',$data);
	}
	
	function update_menu_kegiatan($KodeMenuKegiatan){
		if ($this->cek_validasi() == true){
			$menu_kegiatan = array(
				'KodeIkk' => $this->input->post('ikk'),
				'KodeKegiatan' => $this->input->post('kegiatan'),
				'KodeProgram' => $this->input->post('program'),
				'MenuKegiatan' => $this->input->post('menu_kegiatan')
			);
			$this->gm->update('ref_menu_kegiatan',$menu_kegiatan,'KodeMenuKegiatan',$KodeMenuKegiatan);
			redirect('master_data/master_menu_kegiatan');
		}else{
			$this->edit_proses($KodeMenuKegiatan);
		}
	}
	
	function hapus($KodeMenuKegiatan){
		$this->gm->delete('data_menu_kegiatan','KodeMenuKegiatan',$KodeMenuKegiatan);
		$this->gm->delete('ref_menu_kegiatan','KodeMenuKegiatan',$KodeMenuKegiatan);
		redirect('master_data/master_menu_kegiatan');
	}
	
	function detail($KodeMenuKegiatan){
		$menu_kegiatan = $this->gm->get_where('ref_menu_kegiatan','KodeMenuKegiatan',$KodeMenuKegiatan);
		$option_program;
		foreach($this->gm->get_data('ref_program')->result() as $row){
			$option_program[$row->KodeProgram] = $row->NamaProgram;
		}
		$option_kegiatan;
		foreach($this->gm->get_where('ref_kegiatan','KodeProgram',$menu_kegiatan->row()->KodeProgram)->result() as $row){
			$option_kegiatan[$row->KodeKegiatan] = $row->NamaKegiatan;
		}
		$option_ikk;
		foreach($this->gm->get_where('ref_ikk','KodeKegiatan',$menu_kegiatan->row()->KodeKegiatan)->result() as $row){
			$option_ikk[$row->KodeIkk] = $row->Ikk;
		}
		
		$data['program'] = $option_program;
		$data['kegiatan'] = $option_kegiatan;
		$data['ikk'] = $option_ikk;
		$data['selected_ikk'] = $menu_kegiatan->row()->KodeIkk;
		$data['selected_kegiatan'] = $menu_kegiatan->row()->KodeKegiatan;
		$data['selected_program'] = $menu_kegiatan->row()->KodeProgram;
		$data['menu_kegiatan'] = $menu_kegiatan->row()->MenuKegiatan;
		$data['KodeMenuKegiatan'] = $KodeMenuKegiatan;
		$data['content'] = $this->load->view('form_master_data/form_detail_menu_kegiatan',$data,true);
		$this->load->view('main',$data);	
	}
}
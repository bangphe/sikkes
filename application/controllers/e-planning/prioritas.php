<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prioritas extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/Filtering_model','fm');
		$this->load->model('e-planning/Pendaftaran_model','pm');
		$this->load->model('e-planning/Master_model','masmo');
		$this->load->model('role_model');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	function grid()
	{
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		//$colModel['prioritas'] = array('Prioritas',400,TRUE,'center',1);
		$colModel['thn_anggaran'] = array('Tahun',100,TRUE,'center',1);
		$colModel['idPeriode'] = array('Periode',100,TRUE,'center',0);
		$colModel['DETAIL'] = array('Detail',50,TRUE,'center',0);
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		$colModel['UBAH'] = array('Ubah',50,TRUE,'center',0);
		$colModel['HAPUS'] = array('Hapus',50,TRUE,'center',0);
		}
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
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN){
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		}
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/e-planning/prioritas/list_prioritas";
		if ($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN_REF || $this->session->userdata('kd_role') == Role_model::ADMIN) 		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		else $grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/e-planning/prioritas/add_process';    
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
		
		//$data['div']="<div id='kanan'></div>";
		$data['judul'] = 'Prioritas';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	//mengambil data
	function list_prioritas() 
	{
		/*$valid_fields = array('KodeProgram','NMDEPT');
		$this->flexigrid->validate_post('KDDEPT','asc',$valid_fields);*/
		/*$records = $this->pm->get_data_flexigrid_double_join('prioritas_program','ref_jenis_prioritas','ref_jenis_prioritas.KodeJenisPrioritas=prioritas_program.KodeJenisPrioritas','ref_program','ref_program.KodeProgram=prioritas_program.KodeProgran');*/
		//$records = $this->pm->get_data_flexigrid_join('prioritas_program','ref_program','ref_program.KodeProgram=prioritas_program.KodeProgram');
		$valid_fields = array('KodeProgram', 'KodeJenisPrioritas', 'thn_anggaran');
		$this->flexigrid->validate_post('KodeProgram','asc',$valid_fields);
		//$records = $this->pm->get_data_flexigrid_join('prioritas_program','ref_program','ref_program.KodeProgram=prioritas_program.KodeProgram');
		
		$records = $this->pm->get_data_flexigrid_joins();
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				$record_items[] = array(
										$row->KodeProgram,
										$no,
										$row->thn_anggaran,
										$row->periode_awal.'-'.$row->periode_akhir,
								'<a href=\''.site_url().'/e-planning/prioritas/detail/'.$row->idThnAnggaran.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'></a>',
								'<a href=\''.site_url().'/e-planning/prioritas/edit/'.$row->idThnAnggaran.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/iconedit.png\'></a>',
								'<a href='.site_url().'/e-planning/prioritas/hapus/'.$row->idThnAnggaran.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
								);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function pilihan_prioritas($kdJenisPrioritas){
		$data['added_js'] = 
			"<script type=\"text/javascript\">
				$(document).ready(function() {
					$('#content_tengah div').tree({
						components: ['checkbox', 'collapse'],
						onCheck: {
							ancestors: 'check',
							descendants: 'check'
						},
						onUncheck: {
							descendants: 'uncheck'
						}
					});
					$('.button').button();
				});
				//-->
			</script>";
	
		if($kdJenisPrioritas == 1) $data['title'] = 'Prioritas Nasional';
		else if($kdJenisPrioritas == 2) $data['title'] = 'Prioritas Bidang';
		else $data['title'] = 'Prioritas Kelembagaan';
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode]=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['prioritas'] = "";
		$data['kdJenisPrioritas'] = $kdJenisPrioritas;
		$data['program'] = $this->fm->get_where('ref_program','KodeStatus','1');
		$data['content'] = $this->load->view('e-planning/prioritas/prioritas',$data, true);
		$this->load->view('main',$data);
	}

	function program(){
		foreach($this->pm->get_kode_kementrian()->result() as $row){
			$Kode_kementrian = $row->KodeKementrian;
		}
		$data['program'] = $this->fm->get_program($Kode_kementrian);
		$this->load->view('e-planning/filtering/program_kegiatan',$data);
	}
	
	// save satker
	function save_prioritas($kdJenisPrioritas){
		$idPeriode = $this->input->post('periode');
		$KodeProgram = $this->input->post('program');
		$KodeKegiatan = $this->input->post('kegiatan');
		$KodeIku = $this->input->post('iku');
		$KodeIkk = $this->input->post('ikk');
		$this->masmo->delete('prioritas_program', 'KodeJenisPrioritas', $kdJenisPrioritas);
		if($KodeProgram[0] != Null){
			for($i=0; $i<count($KodeProgram); $i++){			
				$data_prog = array(
					'idPeriode' => $idPeriode,
					'KodeJenisPrioritas' => $kdJenisPrioritas,
					'KodeProgram' => $KodeProgram[$i],
					'kdsatker' => $this->session->userdata('kdsatker')
				);
				$this->masmo->save('prioritas_program', $data_prog);
			}
		}
		$this->masmo->delete('prioritas_kegiatan', 'KodeJenisPrioritas', $kdJenisPrioritas);
		if($KodeKegiatan[0] != Null){
			for($i=0; $i<count($KodeKegiatan); $i++){
				$data_keg = array(
					'idPeriode' => $idPeriode,
					'KodeJenisPrioritas' => $kdJenisPrioritas,
					'KodeKegiatan' => $KodeKegiatan[$i]
				);
				$this->masmo->save('prioritas_kegiatan', $data_keg);
			}
		}
		$this->masmo->delete('prioritas_iku', 'KodeJenisPrioritas', $kdJenisPrioritas);
		if($KodeIku[0] != Null){
			for($i=0; $i<count($KodeIku); $i++){
				$data_iku = array(
					'idPeriode' => $idPeriode,
					'KodeJenisPrioritas' => $kdJenisPrioritas,
					'KodeIku' => $KodeIku[$i]
				);
				$this->masmo->save('prioritas_iku', $data_iku);
			}
		}
		$this->masmo->delete('prioritas_ikk', 'KodeJenisPrioritas', $kdJenisPrioritas);
		if($KodeIkk[0] != Null){
			for($i=0; $i<count($KodeIkk); $i++){
				$data_ikk = array(
					'idPeriode' => $idPeriode,
					'KodeJenisPrioritas' => $kdJenisPrioritas,
					'KodeIkk' => $KodeIkk[$i]
				);
				$this->masmo->save('prioritas_ikk', $data_ikk);
			}
		}
		redirect('e-planning/prioritas/grid');
	}
	
	function prioritas_satker(){
		$data['added_js'] = 
			"<script type=\"text/javascript\">
				$(document).ready(function() {
					$('#content_tengah div').tree({
						components: ['checkbox', 'collapse'],
						onCheck: {
							ancestors: 'check',
							descendants: 'check'
						},
						onUncheck: {
							descendants: 'uncheck'
						}
					});
					$('.button').button();
				});
				//-->
			</script>";
			
		$data['title'] = 'Prioritas Satker';
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode]=$row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data['prioritas'] = "";
		$data['program'] = $this->fm->get_program_prioritas('ref_program');
		$data['content'] = $this->load->view('e-planning/prioritas/prioritas_satker',$data, true);
		$this->load->view('main',$data);
	}
	
	function save_prioritas_satker($kdJenisPrioritas){
		$idPeriode = $this->input->post('periode');
		$KodeProgram = $this->input->post('program');
		$KodeKegiatan = $this->input->post('kegiatan');
		$KodeIku = $this->input->post('iku');
		$KodeIkk = $this->input->post('ikk');
		$this->masmo->delete_double_parameter('prioritas_program', 'KodeJenisPrioritas', $kdJenisPrioritas, 'kdsatker', $this->session->userdata('kdsatker'));
		if($KodeProgram[0] != Null){
			for($i=0; $i<count($KodeProgram); $i++){			
				$data_prog = array(
					'idPeriode' => $idPeriode,
					'KodeJenisPrioritas' => 4,
					'kdsatker' => $this->session->userdata('kdsatker'),
					'KodeProgram' => $KodeProgram[$i]
				);
				$this->masmo->save('prioritas_program', $data_prog);
			}
		}
		$this->masmo->delete('prioritas_kegiatan', 'KodeJenisPrioritas', $kdJenisPrioritas, 'kdsatker', $this->session->userdata('kdsatker'));
		if($KodeKegiatan[0] != Null){
			for($i=0; $i<count($KodeKegiatan); $i++){
				$data_keg = array(
					'idPeriode' => $idPeriode,
					'KodeJenisPrioritas' => 4,
					'kdsatker' => $this->session->userdata('kdsatker'),
					'KodeKegiatan' => $KodeKegiatan[$i]
				);
				$this->masmo->save('prioritas_kegiatan', $data_keg);
			}
		}
		$this->masmo->delete('prioritas_iku', 'KodeJenisPrioritas', $kdJenisPrioritas, 'kdsatker', $this->session->userdata('kdsatker'));
		if($KodeIku[0] != Null){
			for($i=0; $i<count($KodeIku); $i++){
				$data_iku = array(
					'idPeriode' => $idPeriode,
					'KodeJenisPrioritas' => 4,
					'kdsatker' => $this->session->userdata('kdsatker'),
					'KodeIku' => $KodeIku[$i]
				);
				$this->masmo->save('prioritas_iku', $data_iku);
			}
		}
		$this->masmo->delete('prioritas_ikk', 'KodeJenisPrioritas', $kdJenisPrioritas, 'kdsatker', $this->session->userdata('kdsatker'));
		if($KodeIkk[0] != Null){
			for($i=0; $i<count($KodeIkk); $i++){
				$data_ikk = array(
					'idPeriode' => $idPeriode,
					'KodeJenisPrioritas' => 4,
					'kdsatker' => $this->session->userdata('kdsatker'),
					'KodeIkk' => $KodeIkk[$i]
				);
				$this->masmo->save('prioritas_ikk', $data_ikk);
			}
		}
		redirect('e-planning/prioritas/prioritas_satker');
	}
	
	function add_process()
	{
		$prioritas = $this->input->post('prio');
		$prior = array();
		$i=0;

		/*$prog = $this->masmo->get_join('prioritas_program', 'ref_program', 'ref_program.KodeProgram=prioritas_program.KodeProgram');
		$ikk = $this->masmo->get_triple_join_where('ref_ikk','prioritas_ikk','prioritas_ikk.KodeIkk=ref_ikk.KodeIkk','prioritas_kegiatan','prioritas_kegiatan.KodeKegiatan=ref_ikk.KodeKegiatan','ref_kegiatan','ref_kegiatan.KodeKegiatan=prioritas_kegiatan.KodeKegiatan','KodeStatus','1');*/
		$prog = $this->masmo->get_join('ref_program','prioritas_program','prioritas_program.KodeProgram=ref_program.KodeProgram'); 
		$keg = $this->masmo->get_double_join('ref_kegiatan','ref_ikk','ref_kegiatan.KodeKegiatan=ref_ikk.KodeKegiatan','prioritas_kegiatan','prioritas_kegiatan.KodeKegiatan=ref_kegiatan.KodeKegiatan');
		
		foreach($this->masmo->get_join('ref_program','ref_iku','ref_program.KodeProgram=ref_iku.KodeProgram')->result() as $row){
			$prior[$i] = $row->NamaProgram;
			$i++;	
		}
						
		/*foreach($this->masmo->get_join('prioritas_program','ref_program','ref_program.KodeProgram=prioritas_program.KodeProgram')->result() as $row)
		{
			$prior[$i] = $row->KodeJenisPrioritas;
			$i++;
		}*/
		$otpion_jenis;
		$option_jenis[0] = 'None';
		foreach($this->masmo->get('ref_jenis_prioritas')->result() as $row){
			$option_jenis[$row->KodeJenisPrioritas] = $row->JenisPrioritas;	
		}
		foreach($this->pm->get('prioritas_iku')->result() as $ikus);
		
		$data['master_data'] = "";
		$data['judul'] = "Tambah Prioritas";
		$data['periode'] = $this->masmo->get('ref_periode');
		$data['prioritas'] = $this->masmo->getJenisPrioritas();
		$data['program'] = $prog;
		$data['kegiatan'] = $keg;
		$data['ref_prog'] = $this->fm->get_where('ref_program','KodeStatus',1);
		$data['ref_keg'] = $this->masmo->get('ref_kegiatan');
		//$data['iku'] = $prior;
		$data['opt_jenis'] = $option_jenis;
		//$data['jenis'] = $prog->row()->KodeJenisPrioritas;
		$data['prior_prog'] = $prior;
		//$data['prior_iku'] = $this->pm->getSingleUser($ikus->KodeIku);
		$data['content'] = $this->load->view('e-planning/prioritas/tambah_prioritas',$data,true);
		$this->load->view('main',$data);	
	}
	
	
	function cobasave()
	{
		$tahun = $this->input->post('tahun');
		$periode= $this->input->post('periode');
		$kdsatker = $this->session->userdata('kdsatker');
		$program = $_POST['jenis_prioritas_program'];
		$kodeprogram = $this->input->post('kdprog');
		for($i=0;$i<count($program);$i++)
		{
			//masukkan ke tabel program
			$data = array(
					'KodeProgram' 			=> $kodeprogram[$i],
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $program[$i],
					'kdsatker'				=> $kdsatker,
					'idThnAnggaran'			=> $tahun
			);
			$this->masmo->save('prioritas_program',$data);
			//echo 'Kode Program : '.$kodeprogram[$i].' Adalah '.$program[$i].', Pada tahun : '.$tahun.'<br>';
		}
		$kegiatan = $_POST['jenis_prioritas_kegiatan'];
		$kodekegiatan = $this->input->post('kdkeg');
		for($i=0;$i<count($kegiatan);$i++)
		{
			//masukkan ke tabel kegiatan
			$data = array(
					'KodeKegiatan' 			=> $kodekegiatan[$i],
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $kegiatan[$i],
					'kdsatker'				=> $kdsatker,
					'idThnAnggaran'			=> $tahun
			);
			$this->masmo->save('prioritas_kegiatan',$data);
			//echo 'Kode Kegiatan : '.$kodekegiatan[$i].' Adalah '.$kegiatan[$i].'<br>';
		}
		$iku = $_POST['jenis_prioritas_iku'];
		$kodeiku = $this->input->post('kdiku');
		for($i=0;$i<count($iku);$i++)
		{
			//masukkan ke tabel iku
			$data = array(
					'KodeIku' 				=> $kodeiku[$i],
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $iku[$i],
					'kdsatker'				=> $kdsatker,
					'idThnAnggaran'			=> $tahun
			);
			$this->masmo->save('prioritas_iku',$data);
			//echo 'Kode IKU : '.$kodeiku[$i].' Adalah '.$iku[$i].'<br>';
		}
		$ikk = $_POST['jenis_prioritas_ikk'];
		$kodeikk = $this->input->post('kdikk');
		for($i=0;$i<count($ikk);$i++)
		{
			//masukkan ke tabel ikk
			$data = array(
					'KodeIkk' 				=> $kodeikk[$i],
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $ikk[$i],
					'kdsatker'				=> $kdsatker,
					'idThnAnggaran'			=> $tahun
			);
			$this->masmo->save('prioritas_ikk',$data);
			//echo 'Kode IKK : '.$kodeikk[$i].' Adalah '.$ikk[$i].'<br>';
		}
		redirect('e-planning/prioritas/grid');
	}
	//save Iku
	
	function save()
	{
		$kode = $this->input->post('kode');
		$prioritas = $this->input->post('prio');
		$tahun = $this->input->post('tahun');
		$periode = $this->input->post('periode');
		
		echo $kode.'-'.$prioritas.'-'.$tahun.'-'.$periode;
		/*$data = array(
					'KodeIku' 				=> $kode,
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $prioritas,
					'kdsatker'				=> $this->session->userdata('kdsatker'),
					'idThnAnggaran'			=> $tahun
		);
		$this->masmo->save('prioritas_iku',$data);
		redirect('e-planning/prioritas/grid');*/
		
		/*$cek = $this->masmo->get_where('prioritas_iku','KodeIku',$kode);
		if($cek->num_rows() > 0)
		{
			$this->masmo->save('prioritas_iku',$data);
		}
		else
		{
			$this->masmo->update('prioritas_iku',$data,'KodeIku',$kode);	
		}*/
	}
	
	function save_ikk()
	{
		$kode = $this->input->post('kode');
		$prioritas = $this->input->post('prio');
		$tahun = $this->input->post('tahun');
		$periode = $this->input->post('periode');
		
		//echo $kode.'-'.$prioritas.'-'.$tahun.'-'.$periode;
		$data = array(
					'KodeIkk' 				=> $kode,
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $prioritas,
					'kdsatker'				=> $this->session->userdata('kdsatker'),
					'idThnAnggaran'			=> $tahun
		);
		$this->masmo->save('prioritas_ikk',$data);
        redirect('e-planning/prioritas/grid');		
	}
	
	function save_program()
	{
		$kode = $this->input->post('kode');
		$prioritas = $this->input->post('prio');
		$tahun = $this->input->post('tahun');
		$periode = $this->input->post('periode');
		
		//echo $kode.'-'.$prioritas.'-'.$tahun.'-'.$periode;
		$data = array(
					'KodeProgram' 				=> $kode,
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $prioritas,
					'kdsatker'				=> $this->session->userdata('kdsatker'),
					'idThnAnggaran'			=> $tahun
		);
		$this->masmo->save('prioritas_program',$data);
        redirect('e-planning/prioritas/grid');		
	}
	
	function save_kegiatan()
	{
		$kode = $this->input->post('kode');
		$prioritas = $this->input->post('prio');
		$tahun = $this->input->post('tahun');
		$periode = $this->input->post('periode');
		
		//echo $kode.'-'.$prioritas.'-'.$tahun.'-'.$periode;
		$data = array(
					'KodeKegiatan' 				=> $kode,
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $prioritas,
					'kdsatker'				=> $this->session->userdata('kdsatker'),
					'idThnAnggaran'			=> $tahun
		);
		$this->masmo->save('prioritas_kegiatan',$data);	
		redirect('e-planning/prioritas/grid');
	}
	
	function update_iku()
	{
		$kode = $this->input->post('kode');
		$prioritas = $this->input->post('prio');
		$tahun = $this->input->post('tahun');
		$periode = $this->input->post('periode');
		
		//echo $kode.'-'.$prioritas.'-'.$tahun.'-'.$periode;
		$data = array(
					'KodeIku' 				=> $kode,
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $prioritas,
					'kdsatker'				=> $this->session->userdata('kdsatker'),
					'idThnAnggaran'			=> $tahun
		);
		$this->masmo->update('prioritas_iku',$data,'KodeIku',$kode);
	}
	
	function update_ikk()
	{
		$kode = $this->input->post('kode');
		$prioritas = $this->input->post('prio');
		$tahun = $this->input->post('tahun');
		$periode = $this->input->post('periode');
		
		//echo $kode.'-'.$prioritas.'-'.$tahun.'-'.$periode;
		$data = array(
					'KodeIkk' 				=> $kode,
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $prioritas,
					'kdsatker'				=> $this->session->userdata('kdsatker'),
					'idThnAnggaran'			=> $tahun
		);
		$this->masmo->update('prioritas_ikk',$data,'KodeIkk',$kode);
	}
	
	function update_program()
	{
		$kode = $this->input->post('kode');
		$prioritas = $this->input->post('prio');
		$tahun = $this->input->post('tahun');
		$periode = $this->input->post('periode');
		
		//echo $kode.'-'.$prioritas.'-'.$tahun.'-'.$periode;
		$data = array(
					'KodeProgram' 				=> $kode,
					'idPeriode'					=> $periode,
					'KodeJenisPrioritas'		=> $prioritas,
					'kdsatker'					=> $this->session->userdata('kdsatker'),
					'idThnAnggaran'				=> $tahun
		);
		$this->masmo->update('prioritas_program',$data,'KodeProgram',$kode);
	}
	
	function update_kegiatan()
	{
		$kode = $this->input->post('kode');
		$prioritas = $this->input->post('prio');
		$tahun = $this->input->post('tahun');
		$periode = $this->input->post('periode');
		
		//echo $kode.'-'.$prioritas.'-'.$tahun.'-'.$periode;
		$data = array(
					'KodeKegiatan' 			=> $kode,
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $prioritas,
					'kdsatker'				=> $this->session->userdata('kdsatker'),
					'idThnAnggaran'			=> $tahun
		);
		$this->masmo->update('prioritas_kegiatan',$data,'KodeKegiatan',$kode);
	}
	
	function getTahun($kode)
	{
		$tahun = $this->masmo->getTahun($kode);
		$i=0;
		
		foreach($tahun->result() as $row)
		{
			$datajson[$i]['id'] = $row->idThnAnggaran;
			$datajson[$i]['thn'] = $row->thn_anggaran;
			$i++;
		}
		echo json_encode($datajson);
	}
	
	function valid($kode)
	{
		if ($this->masmo->valid($kode) == TRUE)
		{
			echo 'FALSE';
			//$this->form_validation->set_message('valid', "Kode Departemen dengan kode $kode sudah terdaftar");
			//return FALSE;
		}
		else
		{
			echo 'TRUE';
			//return TRUE;
		}
	}
	
	function edit($kode)
	{
		$thn = $this->pm->get_where('ref_tahun_anggaran', $kode, 'idThnAnggaran');
		$prog = $this->masmo->get_join('ref_program','prioritas_program','prioritas_program.KodeProgram=ref_program.KodeProgram'); 
		$keg = $this->masmo->get_double_join('ref_kegiatan','ref_ikk','ref_kegiatan.KodeKegiatan=ref_ikk.KodeKegiatan','prioritas_kegiatan','prioritas_kegiatan.KodeKegiatan=ref_kegiatan.KodeKegiatan');
		
		$option_jenis;
		foreach($this->masmo->get('ref_jenis_prioritas')->result() as $row){
			$option_jenis[$row->KodeJenisPrioritas] = $row->JenisPrioritas;	
		}
		
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;	
		}
		
		$option_tahun;
		foreach($this->masmo->get('ref_tahun_anggaran')->result() as $row){
			$option_tahun[$row->idThnAnggaran] = $row->thn_anggaran;	
		}
		
		$data['master_data'] = "";
		$data['th'] = $kode;
		$data['judul'] = "Detail Prioritas";
		$data['opt_periode'] = $option_periode;
		$data['periode'] = $thn->row()->idperiode;
		$data['opt_tahun'] = $option_tahun;
		$data['tahun'] = $thn->row()->idThnAnggaran;
		$data['prioritas'] = $this->masmo->getJenisPrioritas();
		$data['program'] = $prog;
		$data['kegiatan'] = $keg;
		$data['ref_prog'] = $this->fm->get_where('ref_program','KodeStatus',1);
		$data['ref_keg'] = $this->masmo->get('ref_kegiatan');
		$data['opt_jenis'] = $option_jenis;
		$data['content'] = $this->load->view('e-planning/prioritas/edit_prioritas',$data,true);
		$this->load->view('main',$data);	
	}
	
	function edit_proses()
	{
		$tahun = $this->input->post('tahun');
		$periode= $this->input->post('periode');
		$kdsatker = $this->session->userdata('kdsatker');
		$program = $_POST['jenis_prioritas_program'];
		$kodeprogram = $this->input->post('kdprog');
		for($i=0;$i<count($program);$i++)
		{
			//masukkan ke tabel program
			$data = array(
					'KodeProgram' 			=> $kodeprogram[$i],
					'idPeriode'				=> $periode,
					'KodeJenisPrioritas'	=> $program[$i],
					'kdsatker'				=> $kdsatker,
					'idThnAnggaran'			=> $tahun
			);
			$this->db->update('prioritas_program',$data);
			redirect('e-planning/prioritas/grid');
			//echo 'Kode Program : '.$kodeprogram[$i].' Adalah '.$program[$i].', Pada tahun : '.$tahun.'<br>';
		}
	}
	
	function detail($kode)
	{
		$thn = $this->pm->get_where('ref_tahun_anggaran', $kode, 'idThnAnggaran');
		$prog = $this->masmo->get_join('ref_program','prioritas_program','prioritas_program.KodeProgram=ref_program.KodeProgram'); 
		$keg = $this->masmo->get_double_join('ref_kegiatan','ref_ikk','ref_kegiatan.KodeKegiatan=ref_ikk.KodeKegiatan','prioritas_kegiatan','prioritas_kegiatan.KodeKegiatan=ref_kegiatan.KodeKegiatan');
		
		$option_jenis;
		foreach($this->masmo->get('ref_jenis_prioritas')->result() as $row){
			$option_jenis[$row->KodeJenisPrioritas] = $row->JenisPrioritas;	
		}
		
		$option_periode;
		foreach($this->masmo->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;	
		}
		
		$option_tahun;
		foreach($this->masmo->get('ref_tahun_anggaran')->result() as $row){
			$option_tahun[$row->idThnAnggaran] = $row->thn_anggaran;	
		}
		
		$data['master_data'] = "";
		$data['th'] = $kode;
		$data['judul'] = "Detail Prioritas";
		$data['opt_periode'] = $option_periode;
		$data['periode'] = $thn->row()->idperiode;
		$data['opt_tahun'] = $option_tahun;
		$data['tahun'] = $thn->row()->idThnAnggaran;
		$data['prioritas'] = $this->masmo->getJenisPrioritas();
		$data['program'] = $prog;
		$data['kegiatan'] = $keg;
		$data['ref_prog'] = $this->fm->get_where('ref_program','KodeStatus',1);
		$data['ref_keg'] = $this->masmo->get('ref_kegiatan');
		$data['opt_jenis'] = $option_jenis;
		$data['content'] = $this->load->view('e-planning/prioritas/detail_prioritas',$data,true);
		$this->load->view('main',$data);	
	}
	
	function hapus($tahun)
	{
		$this->masmo->delete('prioritas_iku', 'idThnAnggaran', $tahun);
		$this->masmo->delete('prioritas_program', 'idThnAnggaran', $tahun);
		$this->masmo->delete('prioritas_ikk', 'idThnAnggaran', $tahun);
		$this->masmo->delete('prioritas_kegiatan', 'idThnAnggaran', $tahun);
		redirect('e-planning/prioritas/grid');
	}
}

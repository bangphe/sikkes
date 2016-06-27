<?php
/**
 * Kelas Master_propinsi
 */
class Master_user extends CI_Controller {
	
	//Konstruktor
	function __construct()
	{
		parent::__construct();
		$this->cek_session();
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->model('master_data/general_model', 'gm');	
		$this->load->model('e-planning/pendaftaran_model', 'pm');	
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
		redirect ('master_data/master_user/grid_user');
	}
	
	function grid_user(){
		$colModel['NO'] = array('No.',30,TRUE,'center',0);
		$colModel['USERNAME'] = array('User',200,TRUE,'LEFT',1);
		$colModel['NAMA_USER'] = array('Nama Lengkap',300,TRUE,'LEFT',1);
		$colModel['ROLE'] = array('Role',100,TRUE,'LEFT',1);
		$colModel['NAMA_JABATAN'] = array('Jabatan',200,TRUE,'LEFT',1);
		$colModel['nmsatker'] = array('Satker',300,TRUE,'LEFT',1);
		$colModel['UBAH'] = array('Ubah',25,TRUE,'center',0);
		$colModel['HAPUS'] = array('Hapus',25,TRUE,'center',0);
		
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
		$buttons[] = array('separator');
		
		//mengambil data dari file controler ajax pada method grid_region		
		$url = site_url()."/master_data/master_user/list_user";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Tambah'){
				location.href= '".site_url()."/e-planning/pendaftaran/tambah_user';
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

		$data['judul'] = 'Master User';
		$data['master_data'] = "";
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function list_user(){
		$valid_fields = array('USERNAME','NAMA_USER','ROLE','NAMA_JABATAN','nmsatker');
		$this->flexigrid->validate_post('ROLE','asc',$valid_fields);
		$records = $this->gm->get_data_user();
		
		$this->output->set_header($this->config->item('json_header'));
		
		$no =0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$row->ROLE,
				$no,
				$row->USERNAME,
				$row->NAMA_USER,
				$row->ROLE,
				$row->NAMA_JABATAN,
				$row->nmsatker,
				'<a href='.site_url().'/master_data/master_user/edit/'.$row->USER_ID.'><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'></a>',
				'<a href='.site_url().'/master_data/master_user/hapus/'.$row->USER_ID.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	function edit($user){
		foreach($this->gm->get_where('users','USER_ID',$user)->result() as $row){
			$username= $row->USERNAME;
			$password = $row->PASS_USER;
			$role= $row->KD_ROLE;
			$jenis_kewenangan = $row->KodeJenisSatker;
			$provinsi= $row->KodeProvinsi;
			$kabkota = $row->KodeKabupaten;
			$satker = $row->kdsatker;
			$alamat = $row->ALAMAT_USER;
			$email = $row->EMAIL_USER;
			$telp = $row->TELP_USER;
			$nama = $row->NAMA_USER;
			$kdjabatan= $row->KODE_JABATAN;
			$eselon= $row->ESELON;
			$nmjabatan= $row->NAMA_JABATAN;
			$kdunit= $row->KDUNIT;
		}
		$option_prov;
		$option_kab;
		$option_satker;
		
		foreach($this->db->get('role_login')->result() as $row)
			$option_role[$row->KD_ROLE] = $row->ROLE;
		$option_kewenangan;
		foreach($this->db->get('ref_jenis_satker')->result() as $row)
			$option_kewenangan[$row->KodeJenisSatker] = $row->JenisSatker;
		$data['opt_kewenangan'] = $option_kewenangan;
		foreach($this->db->get('ref_provinsi')->result() as $row)
			$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		$data['opt_prov'] = $option_prov;
		foreach($this->gm->get_double_where('ref_kabupaten','KodeProvinsi',$provinsi,'KodeKabupaten !=', '00')->result() as $row)
			$option_kab[$row->KodeKabupaten] = $row->NamaKabupaten;
		$data['opt_kab'] = $option_kab;
		if($jenis_kewenangan == '1'){
			foreach($this->pm->get_satker_tp($kabkota,$provinsi)->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		elseif($jenis_kewenangan == '2'){
			foreach($this->pm->get_satker_provinsi()->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		elseif($jenis_kewenangan == '3'){
			foreach($this->pm->get_satker_unit_utama()->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		elseif($jenis_kewenangan == '4'){
			foreach($this->pm->get_satker_kp()->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		elseif($jenis_kewenangan == '5'){
			foreach($this->pm->get_satker_kd()->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		// if($eselon == 1)
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = $nmjabatan;
		// elseif($eselon == 2)
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = '&nbsp&nbsp&nbsp&nbsp '.$nmjabatan;
		// elseif($eselon == 3)
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$nmjabatan;
		// elseif($eselon == 4)
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$nmjabatan;
		// else
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = '-';
		$jabatan = $eselon.'-'.$kdjabatan.'-'.$nmjabatan;
		$data['jabatan'] = $jabatan;
		$data['nmjabatan'] = $nmjabatan;
		$data['kdjabatan'] = $kdjabatan;
		
		$opt_jabatan[0] = '--- Pilih Jabatan ---';
		foreach($this->pm->get_where('ref_eselon1', $kdunit, 'kdunit')->result() as $row){
			$opt_jabatan['1-'.$row->kdunit.'-'.$row->eselon1] = $row->eselon1;
			foreach($this->pm->get_where('ref_eselon2',$row->kdunit,'kdunit')->result() as $row){
				$opt_jabatan['2-'.$row->kdunit.'.'.$row->id_eselon2.'-'.$row->eselon2] = '&nbsp&nbsp&nbsp&nbsp '.$row->eselon2;
				foreach($this->pm->get_where_double('ref_eselon3',$row->kdunit,'kdunit',$row->id_eselon2,'id_eselon2')->result() as $row){
					$opt_jabatan['3-'.$row->kdunit.'.'.$row->id_eselon2.'.'.$row->id_eselon3.'-'.$row->eselon3] = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$row->eselon3;
					foreach($this->pm->get_where_triple('ref_eselon4',$row->kdunit,'kdunit',$row->id_eselon2,'id_eselon2',$row->id_eselon3,'id_eselon3')->result() as $row){
						$opt_jabatan['4-'.$row->kdunit.'.'.$row->id_eselon2.'.'.$row->id_eselon3.'.'.$row->id_eselon4.'-'.$row->eselon4] = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$row->eselon4;
					}
				}
			}
		}
		$data['opt_jabatan'] = $opt_jabatan;
		
		$data['user']= $user;
		$data['username'] = $username;
		$data['role'] = $role;
		$data['jenis_kewenangan'] = $jenis_kewenangan;
		$data['provinsi'] = $provinsi;
		$data['kabupaten'] = $kabkota;
		$data['satker'] = $satker;
		$data['alamat_user'] = $alamat;
		$data['telp'] = $telp;
		$data['email'] = $email;
		$data['nama'] = $nama;
		$data['opt_role'] = $option_role;
		$data['eselon'] = $eselon;
		$data['kdunit'] = $kdunit;
		
		$data['content'] = $this->load->view('e-planning/master/edit_user',$data,true);
		$this->load->view('main',$data);
	}
	function update($user){
		$nama = $this->input->post('nama');
		//$peran = $this->input->post('peran');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$alamat = $this->input->post('alamat');
		$telp = $this->input->post('telp');
		$email = $this->input->post('email');
		$role = $this->input->post('role');
		if($role != '1' && $role != '5' && $role != '3' && $role != '4'){
			$jenis_satker = '3';
			$kdunit = '01';
			$kdprovinsi = '01';
			$kdkabupaten = '54';
			$kdsatker = '465915';
		}
		else{
			$jenis_satker = $this->input->post('peran');
			if($this->input->post('peran') == '1'){
				$kdprovinsi = $this->input->post('provinsi');
				$kdkabupaten = $this->input->post('kabupaten');
				$kdsatker = $this->input->post('satker_');
				$kdunit = $this->pm->get_where('ref_satker',$kdsatker,'kdsatker')->row()->kdunit;
			}
			else{
				$kdsatker = $this->input->post('satker_');
				foreach($this->pm->get_where('ref_satker',$kdsatker,'kdsatker')->result() as $row){
					$kdprovinsi = $row->kdlokasi;
					$kdkabupaten = $row->kdkabkota;
					$kdunit = $row->kdunit;
				}
			}
		}
		if($this->input->post('jns_jabatan') == 'eselon'){
			$jabatan = explode('-',$this->input->post('jabatan'));
			$NamaJabatan = $jabatan[2];
			$eselon = $jabatan[0];
			$kode_eselon = $jabatan[1];
		}
		else{
			$NamaJabatan = 'Staf';
			$eselon = '0';
			$kode_eselon = '-';
		}
		// $jabatan = explode('-',$this->input->post('jabatan'));
		// $NamaJabatan = $jabatan[2];
		// $eselon = $jabatan[0];
		// $kode_eselon = $jabatan[1];
		
		$data_user = array(
			'USERNAME' => $username,
			'KD_ROLE' => $role,
			'PASS_USER' => md5($password),
			'kdsatker' => $kdsatker,
			'NAMA_USER' => $nama,
			'KodeJenisSatker' => $jenis_satker,
			'KDUNIT' => $kdunit,
			'KodeKabupaten' => $kdkabupaten,
			'KodeProvinsi' => $kdprovinsi,
			'ALAMAT_USER' => $alamat,
			'TELP_USER' => $telp,
			'EMAIL_USER' => $email,
			'NAMA_JABATAN' => $NamaJabatan,
			'KODE_JABATAN' => $kode_eselon,
			'ESELON' =>$eselon
		);
		$this->pm->update('users',$data_user, 'USER_ID', $user);
		redirect('master_data/master_user');
	}	
	function hapus($USER_ID){	
		$this->gm->delete('data_jabatan','USER_ID',$USER_ID);
		$this->gm->delete('users','USER_ID',$USER_ID);
		redirect('master_data/master_user');
	}
	function detail_user(){
		$user = $this->session->userdata('id_user');
		foreach($this->gm->get_where('users','USER_ID',$user)->result() as $row){
			$username= $row->USERNAME;
			$password = $row->PASS_USER;
			$role= $row->KD_ROLE;
			$jenis_kewenangan = $row->KodeJenisSatker;
			$provinsi= $row->KodeProvinsi;
			$kabkota = $row->KodeKabupaten;
			$satker = $row->kdsatker;
			$alamat = $row->ALAMAT_USER;
			$email = $row->EMAIL_USER;
			$telp = $row->TELP_USER;
			$nama = $row->NAMA_USER;
			$kdjabatan= $row->KODE_JABATAN;
			$eselon= $row->ESELON;
			$nmjabatan= $row->NAMA_JABATAN;
			if($jenis_kewenangan == '3') $kdunit= $row->KDUNIT;
		}
		$data['user']= $user;
		$data['username'] = $username;
		$data['role'] = $role;
		$data['jenis_kewenangan'] = $jenis_kewenangan;
		$data['provinsi'] = $provinsi;
		$data['kabupaten'] = $kabkota;
		$data['satker'] = $satker;
		$data['alamat'] = $alamat;
		$data['telp'] = $telp;
		$data['email'] = $email;
		$data['nama'] = $nama;
		$data['eselon'] = $eselon;
		$data['nmjabatan'] = $nmjabatan;
		if($jenis_kewenangan == '3') $data['kdunit'] = $kdunit;
		
		$data['content'] = $this->load->view('form_master_data/form_detail_profil',$data,true);
		$this->load->view('main',$data);
	}
	
	function change_password(){
		$data['content'] = $this->load->view('form_master_data/form_edit_password',null,true);
		$this->load->view('main',$data);
	}
	function update_password(){
		$user = $this->session->userdata('id_user');
		$password = $this->input->post('password');
		$data_user = array('PASS_USER' => md5($password));
		$this->pm->update('users',$data_user, 'USER_ID', $user);
		redirect('master_data/master_user/detail_user');
	}
	
	function edit_profil(){
		$user = $this->session->userdata('id_user');
		$jenis_kewenangan = $this->session->userdata('kodejenissatker');
		// foreach($this->gm->get_where('users','USER_ID',$user)->result() as $row){
			// $username = $row->USERNAME;
			// $alamat = $row->ALAMAT_USER;
			// $email = $row->EMAIL_USER;
			// $telp = $row->TELP_USER;
			// $nama = $row->NAMA_USER;
			// $eselon= $row->ESELON;
			// $kdunit= $row->KDUNIT;
			// $kdjabatan= $row->KODE_JABATAN;
			// $nmjabatan= $row->NAMA_JABATAN;
		// }$optjabatan['0'] = '';
		// if($eselon == '4'){
			// foreach($this->pm->get_where('ref_eselon4', $kdunit, 'kdunit')->result() as $jab)
				// $optjabatan[$jab->kdunit.'.'.$jab->id_eselon2.'.'.$jab->id_eselon3.'.'.$jab->id_eselon4.'-'.$jab->eselon4] = $jab->eselon4;
		// }
		// elseif($eselon == '3'){
			// foreach($this->pm->get_where('ref_eselon3', $kdunit, 'kdunit')->result() as $jab)
				// $optjabatan[$jab->kdunit.'.'.$jab->id_eselon2.'.'.$jab->id_eselon3.'-'.$jab->eselon3] = $jab->eselon3;
		// }
		// elseif($eselon == '2'){
			// foreach($this->pm->get_where('ref_eselon2', $kdunit, 'kdunit')->result() as $jab)
				// $optjabatan[$jab->kdunit.'.'.$jab->id_eselon2.'-'.$jab->eselon2] = $jab->eselon2;
		// }
		// elseif($eselon == '1'){
			// foreach($this->pm->get_where('ref_eselon1', $kdunit, 'kdunit')->result() as $jab)
				// $optjabatan[$jab->kdunit.'-'.$jab->eselon1] = $jab->eselon1;
		// }
		// $data['jabatan'] = $optjabatan;
		// $data['alamat_user'] = $alamat;
		// $data['username'] = $username;
		// $data['telp'] = $telp;
		// $data['email'] = $email;
		// $data['nama'] = $nama;
		// $data['jnskewenangan'] = $jenis_kewenangan;
		// $data['s_jabatan'] = $kdjabatan.'-'.$nmjabatan;
		
		foreach($this->gm->get_where('users','USER_ID',$user)->result() as $row){
			$username= $row->USERNAME;
			$password = $row->PASS_USER;
			$role= $row->KD_ROLE;
			$jenis_kewenangan = $row->KodeJenisSatker;
			$provinsi= $row->KodeProvinsi;
			$kabkota = $row->KodeKabupaten;
			$satker = $row->kdsatker;
			$alamat = $row->ALAMAT_USER;
			$email = $row->EMAIL_USER;
			$telp = $row->TELP_USER;
			$nama = $row->NAMA_USER;
			$kdjabatan= $row->KODE_JABATAN;
			$eselon= $row->ESELON;
			$nmjabatan= $row->NAMA_JABATAN;
			$kdunit= $row->KDUNIT;
		}
		$option_prov;
		$option_kab;
		$option_satker;
		
		foreach($this->db->get('role_login')->result() as $row)
			$option_role[$row->KD_ROLE] = $row->ROLE;
		$option_kewenangan;
		foreach($this->db->get('ref_jenis_satker')->result() as $row)
			$option_kewenangan[$row->KodeJenisSatker] = $row->JenisSatker;
		$data['opt_kewenangan'] = $option_kewenangan;
		foreach($this->db->get('ref_provinsi')->result() as $row)
			$option_prov[$row->KodeProvinsi] = $row->NamaProvinsi;
		$data['opt_prov'] = $option_prov;
		foreach($this->gm->get_double_where('ref_kabupaten','KodeProvinsi',$provinsi,'KodeKabupaten !=', '00')->result() as $row)
			$option_kab[$row->KodeKabupaten] = $row->NamaKabupaten;
		$data['opt_kab'] = $option_kab;
		if($jenis_kewenangan == '1'){
			foreach($this->pm->get_satker_tp($kabkota,$provinsi)->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		elseif($jenis_kewenangan == '2'){
			foreach($this->pm->get_satker_provinsi()->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		elseif($jenis_kewenangan == '3'){
			foreach($this->pm->get_satker_unit_utama()->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		elseif($jenis_kewenangan == '4'){
			foreach($this->pm->get_satker_kp()->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		elseif($jenis_kewenangan == '5'){
			foreach($this->pm->get_satker_kd()->result() as $row)
				$option_satker[$row->kdsatker] = $row->nmsatker;
			$data['opt_satker'] = $option_satker;
		}
		// if($eselon == 1)
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = $nmjabatan;
		// elseif($eselon == 2)
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = '&nbsp&nbsp&nbsp&nbsp '.$nmjabatan;
		// elseif($eselon == 3)
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$nmjabatan;
		// elseif($eselon == 4)
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$nmjabatan;
		// else
			// $jabatan[$eselon.'-'.$kdjabatan.'-'.$nmjabatan] = '-';
		$jabatan = $eselon.'-'.$kdjabatan.'-'.$nmjabatan;
		$data['jabatan'] = $jabatan;
		$data['nmjabatan'] = $nmjabatan;
		$data['kdjabatan'] = $kdjabatan;
		
		$opt_jabatan= '';
		foreach($this->pm->get_where('ref_eselon1', $kdunit, 'kdunit')->result() as $row){
			$opt_jabatan['1-'.$row->kdunit.'-'.$row->eselon1] = $row->eselon1;
			foreach($this->pm->get_where('ref_eselon2',$row->kdunit,'kdunit')->result() as $row){
				$opt_jabatan['2-'.$row->kdunit.'.'.$row->id_eselon2.'-'.$row->eselon2] = '&nbsp&nbsp&nbsp&nbsp '.$row->eselon2;
				foreach($this->pm->get_where_double('ref_eselon3',$row->kdunit,'kdunit',$row->id_eselon2,'id_eselon2')->result() as $row){
					$opt_jabatan['3-'.$row->kdunit.'.'.$row->id_eselon2.'.'.$row->id_eselon3.'-'.$row->eselon3] = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$row->eselon3;
					foreach($this->pm->get_where_triple('ref_eselon4',$row->kdunit,'kdunit',$row->id_eselon2,'id_eselon2',$row->id_eselon3,'id_eselon3')->result() as $row){
						$opt_jabatan['4-'.$row->kdunit.'.'.$row->id_eselon2.'.'.$row->id_eselon3.'.'.$row->id_eselon4.'-'.$row->eselon4] = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp '.$row->eselon4;
					}
				}
			}
		}
		$data['opt_jabatan'] = $opt_jabatan;
		
		$data['user']= $user;
		$data['username'] = $username;
		$data['role'] = $role;
		$data['jenis_kewenangan'] = $jenis_kewenangan;
		$data['provinsi'] = $provinsi;
		$data['kabupaten'] = $kabkota;
		$data['satker'] = $satker;
		$data['alamat_user'] = $alamat;
		$data['telp'] = $telp;
		$data['email'] = $email;
		$data['nama'] = $nama;
		$data['opt_role'] = $option_role;
		$data['eselon'] = $eselon;
		$data['kdunit'] = $kdunit;
		$data['jnskewenangan'] = $jenis_kewenangan;
		
		$data2['content'] = $this->load->view('form_master_data/form_edit_profil',$data,true);
		$this->load->view('main',$data2);
	}
	function update_profil(){
		$user = $this->session->userdata('id_user');
		$nama = $this->input->post('nama');
		$username = $this->input->post('username');
		$alamat = $this->input->post('alamat');
		$telp = $this->input->post('telp');
		$email = $this->input->post('email');
		if($this->input->post('jns_jabatan') == 'eselon'){
			$jabatan = explode('-',$this->input->post('jabatan'));
			$NamaJabatan = $jabatan[2];
			$eselon = $jabatan[0];
			$kode_eselon = $jabatan[1];
		}
		else{
			$NamaJabatan = 'Staf';
			$eselon = '0';
			$kode_eselon = '-';
		}
		
		$username_lama = $this->pm->get_where('users', $user, 'USER_ID')->row()->USERNAME;
		if($this->pm->cek1('users', 'USERNAME', $username) && $username != $username_lama){
			$data['warning'] = 'Username telah terdaftar. Gunakan username lain.';
			$this->edit_profil();
		}
		else{
		
		$data_user = array(
			'USERNAME' => $username,
			'NAMA_USER' => $nama,
			'ALAMAT_USER' => $alamat,
			'TELP_USER' => $telp,
			'EMAIL_USER' => $email,
			'NAMA_JABATAN' => $NamaJabatan,
			'KODE_JABATAN' => $kode_eselon,
			'ESELON' =>$eselon
		);
		$this->pm->update('users',$data_user, 'USER_ID', $user);
		redirect('master_data/master_user/detail_user');
		}
	}
	function cek_username($username){
		$username_lama = $this->pm->get_where('users', $this->session->userdata('id_user'), 'USER_ID')->row()->USERNAME;
		if($this->pm->cek1('users', 'USERNAME', $username) && $username != $username_lama){
			$datajson['warning'] = 'Username telah terdaftar. Gunakan username lain.';
			$datajson['cek'] = false;
		}
		else {
			$datajson['warning'] = '';
			$datajson['cek'] = true;
		}
		echo json_encode($datajson);
	}
}
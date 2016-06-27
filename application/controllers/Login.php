<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	 
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('e-planning/pendaftaran_model','pm');
		$this->load->model('login_model', 'lm');
	}
	
	public function index(){
		if($this->session->userdata('kd_role') != '')
			redirect('beranda/homepage');
		if(isset($_POST['username']) && isset($_POST['password'])){
			$data['username'] = $_POST['username'];
			if($_POST['username'] != null && $this->lm->cek_user($_POST['username']) == FALSE){
				$data['notification1'] = '*Username tidak terdaftar.';
			}
			elseif($_POST['password'] != null && $this->lm->get_user($_POST['username'], md5($_POST['password']))->num_rows < 1){
				$data['notification1'] = '*Password tidak sesuai.';
			}
		}
		$option_thn_anggaran;
		foreach($this->lm->get('ref_tahun_anggaran')->result() as $row){
			$option_thn_anggaran[$row->thn_anggaran] = $row->thn_anggaran;
		}
		$data['thn_anggaran'] = $option_thn_anggaran;
		$this->load->view('login',$data);
	}

	//maintenance system
	// public function index()
	// {
	// 	$this->load->view('maintenance',$data);
	// }
	
	public function login_ulang(){
		$this->index();
	}
	
	function login_proses(){
		if($this->cek_validasi() == FALSE){
			$this->index();
		}
		else{
			$user = $this->lm->get_user($_POST['username'], md5($_POST['password']))->result();
			if($user != null){
				foreach($user as $row){
					$this->session->set_userdata('username', $row->USERNAME);
					$this->session->set_userdata('nama_user', $row->NAMA_USER);
					$this->session->set_userdata('alamat_user', $row->ALAMAT_USER);
					$this->session->set_userdata('telp_user', $row->TELP_USER);
					$this->session->set_userdata('email', $row->EMAIL_USER);
					$this->session->set_userdata('id_user', $row->USER_ID);
					$this->session->set_userdata('kdsatker', $row->kdsatker);
					$kdinduk = $this->lm->get_where('ref_satker', 'kdsatker', $row->kdsatker)->row()->kdinduk;
					$this->session->set_userdata('kdinduk', $kdinduk);
					$this->session->set_userdata('kd_role', $row->KD_ROLE);
					$this->session->set_userdata('kdunit', $row->KDUNIT);
					$this->session->set_userdata('eselon', $row->ESELON);
					$this->session->set_userdata('kodejenissatker', $row->KodeJenisSatker);
					$this->session->set_userdata('kodeprovinsi', $row->KodeProvinsi);
					$this->session->set_userdata('kodekabupaten', $row->KodeKabupaten);
					$this->session->set_userdata('thn_anggaran', $_POST['thn_anggaran']);
					// $this->session->set_userdata('triwulan', $this->input->post('triwulan'));	
				}
				//$this->pendaftaran_step1();
				redirect('beranda/homepage');
			}
			else $this->index();
		}
	}
	
	function cek_validasi(){
		$config = array(
			array('field'=>'username','label'=>'Username', 'rules'=>'required'),
			array('field'=>'password','label'=>'Password', 'rules'=>'required')
		);
		//setting rules
		$this->form_validation->set_rules($config);
		
		$this->form_validation->set_message('required', 'Kolom %s harus diisi !!');

		return $this->form_validation->run();
	}
	
	function logout(){
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama_user');
		$this->session->unset_userdata('alamat_user');
		$this->session->unset_userdata('telp_user');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('kdsatker');
		$this->session->unset_userdata('kdinduk', $kdinduk);
		$this->session->unset_userdata('kd_role');
		$this->session->unset_userdata('kdunit');
		$this->session->unset_userdata('eselon');
		$this->session->unset_userdata('kodejenissatker');
		$this->session->unset_userdata('kodeprovinsi');
		$this->session->unset_userdata('kodekabupaten');
		$this->session->unset_userdata('thn_anggaran');
		$this->session->unset_userdata();
		$this->session->sess_destroy();
		redirect($this->index());
	}
	
	function lupa_password(){
		$data['title'] = 'Lupa Password?';
		if(isset($_POST['email'])){
			$data['email'] = $_POST['email'];
			if (valid_email($_POST['email']) == FALSE){
				$data['notification1'] = '*Format alamat e-mail yang Anda masukkan salah.';
			}
			elseif($_POST['email'] != null && $this->lm->get_user_by_email($_POST['email'])->num_rows < 1){
				$data['notification1'] = '*Alamat e-mail yang Anda masukkan tidak terdaftar sebagai user di database kami.';
			}
		}
		$this->load->view('lupa_password', $data);
	}
	
	// tanpa konfirmasi email ke user
	function recovery_password(){
		$user = $this->lm->get_user_by_email($_POST['email']);
		$this->load->helper('email');
		if (valid_email($_POST['email']) == FALSE){
			$this->lupa_password();
		}
		elseif($_POST['email'] != null &&  $user->num_rows < 1 ){
			$this->lupa_password();
		}
		else{
			$this->lm->reset_password_by_email($_POST['email']);
			$data['notification3'] = 'Reset password telah diproses. Password telah di-reset menjadi : users';
			$option_thn_anggaran;
			foreach($this->lm->get('ref_tahun_anggaran')->result() as $row){
				$option_thn_anggaran[$row->thn_anggaran] = $row->thn_anggaran;
			}
			$data['thn_anggaran'] = $option_thn_anggaran;
			$this->load->view('login',$data);
		}
	}

	// Recovery password dengan mengirimkan konfirmasi email ke user
	// function recovery_password(){
	// 	$user = $this->lm->get_user_by_email($_POST['email']);
	// 	$this->load->helper('email');
	// 	if (valid_email($_POST['email']) == FALSE){
	// 		$this->lupa_password();
	// 	}
	// 	elseif($_POST['email'] != null &&  $user->num_rows < 1 ){
	// 		$this->lupa_password();
	// 	}
	// 	else{
	// 		$this->lm->reset_password_by_email($_POST['email']);
	// 		$config = Array(
	// 			'protocol' => 'smtp',
	// 			'smtp_host' => 'ssl://smtp.googlemail.com',
	// 			'smtp_port' => 465,
	// 			'smtp_user' => 'erenggar.helpdesk@gmail.com',
	// 			'smtp_pass' => '1qaz2wsxa',
	// 			'mailtype'  => 'html', 
	// 			'charset' => 'utf-8',
	// 			'wordwrap' => TRUE

	// 		);
	// 		$this->load->library('email', $config);
	// 		$this->email->set_newline("\r\n");
	// 		$email_body ="Anda terdaftar di E-RENGGAR menggunakan ".$_POST['email'].", sebagai user berikut.<div>&nbsp;</div>";
	// 		foreach($user->result() as $row){
	// 			$email_body .= "<div>- Username: ".$row->USERNAME." , dengan Password di-reset menjadi: users</div>";
	// 		}
	// 		$email_body .= "<div>&nbsp;</div><div>&nbsp;</div><div>Segera ganti password Anda setelah Anda melakukan login.</div>";
	// 		$this->email->from('erenggar.helpdesk@gmail.com', 'Helpdesk E-RENGGAR');

	// 		$to = $_POST['email'];
	// 		$list = array($to);
	// 		$this->email->to($list);
	// 		$this->email->subject("Reset Password E-RENGGAR");
	// 		$this->email->message($email_body);

	// 		$this->email->send();
	// 		// echo $this->email->print_debugger();
	// 		$data['notification3'] = 'Reset password telah diproses. Silakan mengecek e-mail yang Anda daftarkan.';
	// 		$option_thn_anggaran;
	// 		foreach($this->lm->get('ref_tahun_anggaran')->result() as $row){
	// 			$option_thn_anggaran[$row->thn_anggaran] = $row->thn_anggaran;
	// 		}
	// 		$data['thn_anggaran'] = $option_thn_anggaran;
	// 		$this->load->view('login',$data);
	// 	}
	// }
	
	function chart(){			
		$this->load->library('FusionCharts');
		
		if($this->uri->segment(3) == '')
			$chartType = 'Column2D';
		else
			$chartType =$this->uri->segment(3);
		
		$width = '600';
		$height = '300';
		
		$chart = new FusionCharts($chartType, $width, $height);
		
		$caption = 'Grafik Satker';
		$xAxisName = 'Kode Satker';
		$yAxisName = 'Jumlah';
		$decimalPrecision = '0';
		$formatNumberScale = '0';
		$showNames = '1';
		$content = "<graph caption='".$caption."' xAxisName='".$xAxisName."' yAxisName='".$yAxisName."' decimalPrecision='".$decimalPrecision."' formatNumberScale='".$formatNumberScale."'>";
		foreach($this->lm->select(' COUNT( NO_REG_SATKER ) AS jumlah, NO_REG_SATKER','pengajuan','NO_REG_SATKER')->result() as $row){
			$content = $content."<set name='".$row->NO_REG_SATKER."' value='".$row->jumlah."' color='' />";
		}
		$strXML = $content."</graph>";
		
		$data['chart'] = $chart->renderChartHTML(base_url().'charts/'.$chartType.'.swf', '', $strXML, 'chartId', $width, $height);
		
		$this->load->view('e-planning/chart/mahasiswa_chart_v', $data);
	}
	
	function chart2(){			
		$this->load->library('FusionCharts');
		
		if($this->uri->segment(3) == '')
			$chartType = 'Column3D';
		else
			$chartType =$this->uri->segment(3);
		
		$width = '80%';
		$height = '80%';
		
		$chart = new FusionCharts($chartType, $width, $height);
		
		$content = "<chart caption='Provinsi' subcaption='Click on a column to drill-down' xAxisName='Provinsi' yAxisName='Jumlah' numberPrefix='' showValues='0' useRoundEdges='1'>";
		foreach($this->lm->get('ref_provinsi')->result() as $row){
			$content = $content."<set label='".$row->NamaProvinsi."' value='".$this->lm->get_pengajuan_prov($row->KodeProvinsi)."' link='newchart-xml-".$row->KodeProvinsi."' />";
		}
		foreach($this->lm->get('ref_provinsi')->result() as $row){
			$content = $content."<linkeddata id='".$row->KodeProvinsi."'>";
				$content = $content."<chart caption='Satker' subcaption='Satuan Kerja Provinsi ".$row->NamaProvinsi."' xAxisName='Satker' yAxisName='Jumlah' numberPrefix='' showValues='0' useRoundEdges='1' >";
					foreach($this->lm->get_where('ref_satker','kdlokasi',$row->KodeProvinsi)->result() as $row){
						$nmsatker = $row->nmsatker;
						if(mb_strlen($row->nmsatker) > 30){
							$nmsatker = substr($row->nmsatker, 0, 19).'..'.substr($row->nmsatker, -8);
						}
						$content = $content."<set label='".$nmsatker."' value='".$this->lm->get_pengajuan_satker($row->kdsatker)."'/>";
					}
				$content = $content."</chart>";
			$content = $content."</linkeddata>";
		}
		$content = $content."</chart>";
		$strXML = $content;
		$data['chart'] = $chart->renderChart(base_url().'charts/'.$chartType.'.swf', '', $strXML, 'chartId', $width, $height);
		$data['content'] = $this->load->view('e-planning/chart/chart', $data, true);
		$this->load->view('main', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */


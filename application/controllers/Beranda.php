<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beranda extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('e-planning/manajemen_model');
		$this->load->model('role_model');
		//$this->load->library('session');
		//$this->cek_session();
	}

	function Beranda()
	{
		parent::Controller();	
	}//end constructor
	
	function index()
	{
		$this->homepage();
	}//end index
	
	function cek_session()
	 {	
		$kode_user = $this->session->userdata('id_user');
		if(empty($kode_user))
		{
			redirect('login/login_ulang');
		}
	 }

	function homepage()
	{
		$this->cek_session();
		$file = 'UserManualERenggar.zip';
		if($this->session->userdata('kd_role') == Role_model::PENGUSUL)
			$file = 'UserManual Level 1 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::PEMBUAT_ANGGARAN)
			$file = 'UserManual Level 1 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
			$file = 'UserManual Level 1 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR)
			$file = 'UserManual Level 2 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::PENELAAH)
			$file = 'UserManual Level 3 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::PENYETUJU)
			$file = 'UserManual Level 3 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING)
			$file = 'UserManual Level 3 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::ADMIN_BUDGETING)
			$file = 'UserManual Level 3 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::ADMIN_MONEV)
			$file = 'UserManual Level 3 ERenggar.docx';
		elseif($this->session->userdata('kd_role') == Role_model::ADMIN_REF)
			$file = 'UserManual Level 4 ERenggar.docx';
		$data2['file'] = $file;
		$data['content'] = $this->load->view('home',$data2,true);
		$this->load->view('main',$data);
	}//end homepage

}//end class

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */

<?php

class Form extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/departemen_model', 'dm');	

	}

	function index()
	{
		$this->add();
	}
	
	function valid($id)
	{
		if ($this->dm->valid($id) == TRUE)
		{
			$this->form_validation->set_message('valid', "Kode Departemen dengan nomor $id sudah terdaftar!!");
			return FALSE;
		}
		else
		{			
			return TRUE;
		}
	}
	
	function add(){		
		$this->form_validation->set_rules('kode', 'Kode', 'required|exact_length[2]|numeric|callback_valid');
		$this->form_validation->set_rules('nama', 'Nama', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
				'KDDEPT' => $this->input->post('kode'),
				'NMDEPT' => $this->input->post('nama')
			);
			$this->dm->add($data);
			redirect('form/index');
		}
		else
		{
			$this->load->view('test');
		}	
	}
}
?>
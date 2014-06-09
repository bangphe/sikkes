<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Strategy_map extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('Strategy_map_model','sm');
	}
	
	function index(){
		$option_periode;
		foreach($this->sm->get('ref_periode')->result() as $row){
			$option_periode[$row->idPeriode] = $row->periode_awal.'-'.$row->periode_akhir;
		}
		$data['periode'] = $option_periode;
		$data2['content'] = $this->load->view('strategy_map',$data,true);
		$this->load->view('main',$data2);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapping_output extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->helper('fusioncharts');
		$this->load->model('e-monev/laporan_monitoring_model','lmm');
		$this->load->model('e-budget/mapping_output_model','mom');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	
	function index()
	{
		$this->mappingOutputTree();
	}
	
	function mappingOutputTree()
	{
		$data['title'] = 'Mapping Output';
		$data['content'] = $this->load->view('e-budget/view_mapping_output',$data,true);
		$this->load->view('main',$data);
	}
	
	function loadData(){
		$records = $this->mom->program();
		$arr = array("total"=>$records->num_rows(), "rows"=>array());
		$parent = array();
		$unduh = '<a href=#><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';
		foreach($records->result() as $row)
		{
			if($this->lmm->get_where2($this->db->database.'.d_item','kdprogram',$row->kdprogram,'kdgiat',$row->kdgiat)->num_rows() > 0)
			{
				foreach($this->mom->getAlokasiKeg($row->kdprogram,$row->kdgiat)->result() as $aloKeg){
				$alokasiKeg = 'Rp. '.number_format($aloKeg->total);	
				}
			}
			else{
				$alokasiKeg ="";
			}
			array_push($parent, array("id"=>$row->kdprogram,"code"=>'['.$row->kdprogram.'] - '.$row->nmprogram,"name"=>number_format($row->totaljumlah),"uang"=>"","rk"=>"","rf"=>"","evaluasi"=>$unduh,"state"=>"closed"));
			foreach($this->mom->keg($row->kddept,$row->kdprogram)->result() as $row2)
			{
				array_push($parent, array("id"=>$row2->kdgiat,"code"=>'['.$row2->kdgiat.'] - '.$row2->nmgiat,"name"=>$alokasiKeg,"uang"=>"","rk"=>"","rf"=>"","evaluasi"=>$unduh,"_parentId"=>$row->kdprogram,"state"=>"closed"));
				foreach($this->mom->output($row->kdprogram,$row2->kdgiat)->result() as $row3)
				{
					array_push($parent, array("id"=>$row3->kdoutput,"code"=>'['.$row3->kdoutput.'] - '.$row3->nmoutput,"name"=>"","keu"=>"","fisik"=>"","evaluasi"=>$unduh,"_parentId"=>$row2->kdgiat));
				}
			}
		}
		$arr["rows"] = $parent;
		echo json_encode($arr);
		//echo json_encode($arr);
	}
	
	function outputGrid()
	{
		//$id = '01';
		if(isset($_POST['id'])) {
		 $kode = explode('#',$_POST['id']);
		 if($kode[0] == 'prog'){
		 	$this->getKegiatan($kode[2],$kode[1]);
		 }
		 if($kode[0] == 'keg')
		 {
			 $this->getOutput($kode[2],$kode[1]);
		 }
		 if($kode[0] == 'output')
		 {
			 $this->getSubOutput($kode[1],$kode[2],$kode[3]);
		 }
		 if($kode[0] == 'suboutput')
		 {
			 $this->getKomponen($kode[1],$kode[2],$kode[3],$kode[4]);
		 }
		 if($kode[0] == 'komponen')
		 {
			 $this->getSubKomponen($kode[1],$kode[2],$kode[3],$kode[4],$kode[5]);
		 }
		}
		else
		{
			$result = array();
			$records = $this->mom->program();
			$count = 0;
			$count_keg = 0;
			$hasil_persentase = 0;
			//$records2 = $this->mom->keg();
			foreach($records->result_array() as $row){
				$row['id'] = 'prog#'.$row['kdprogram'].'#'.$row['kddept'];
				
				$id = $row['thang'].'-'.$row['kdunit'].'-'.$row['kdprogram'];
				//alokasi dipa
				$nilai_alokasi = $row['totaljumlah'];

				//menghitung total kegiatan per programnya
				$total_keg = $this->mom->count_keg($row['kddept'],$row['kdprogram']);

				//menghitung kegiatan yang sudah ada isinya
				$cek_program = $this->mom->cek_mapping_by_program($row['thang'],$row['kdunit'],$row['kdprogram']);
				if ($cek_program->num_rows() > 0) {
					foreach ($cek_program->result() as $data) {
						$count_keg = $count++;
						$hasil_persentase = $count/$total_keg*100;
					}
					
					//$hasil_persentase = ($cek_program / $count_keg) * 100;
				} else {
					$hasil_persentase = 0;
				}
				
				$row['name'] = '['.$row['kdprogram'].'] - '.$row['nmprogram'];
				$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
				$row['uang'] = round($hasil_persentase,1).'%';
				$row['evaluasi'] = '';
				$row['state'] = $this->has_kegiatan($row['kdprogram']) ? 'closed' : 'open';
				array_push($result, $row);
				
			}
			echo json_encode($result);
		}
	}
	
	function getKegiatan($kddept,$kdprogram)
	{
		$result = array();
		$records = $this->mom->keg($kddept,$kdprogram);

		foreach($records->result_array() as $row){
			$row['id'] = 'keg#'.$row['kdgiat'].'#'.$row['kdprogram'];
			
			$id = $row['thang'].'-'.$row['kdunit'].'-'.$row['kdprogram'].'-'.$row['kdgiat'];

			//alokasi dipa
			$nilai_alokasi = $row['totaljumlah'];
			
			//alokasi swakelola dan kontrak
			$nilai_keuangan = 0;
			$paket = $this->mom->get_paket_g($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat']);
			if($paket->num_rows > 0){
				foreach($paket->result() as $pk){
					$nilai_keuangan += $this->mom->get_swakelola($pk->idpaket)->row()->jumlah;
					$nilai_keuangan += $this->mom->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
				}
			}

			//menghitung total output yang sudah di mapping by kegiatan nya
			$cek_kegiatan = $this->mom->cek_mapping_by_kegiatan($id);

			if ($cek_kegiatan > 0) {
				//menghitung total output nya per kegiatan
				$total_output = $this->mom->count_output($row['kdprogram'],$row['kdgiat']);

				$hasil_persentase = ($cek_kegiatan / $total_output)*100;
			}

			else {
				$hasil_persentase = 0;
			}
			

			$row['name'] = '['.$row['kdgiat'].'] Kegiatan - '.$row['nmgiat'];
			$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
			$row['uang'] = round($hasil_persentase,1).'%';
			$row['evaluasi'] = '';
			$row['state'] = $this->has_output($row['kdgiat']) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	function getOutput($kdprogram,$kdgiat)
	{
		$result = array();
		$records = $this->mom->output($kdprogram,$kdgiat);
		foreach($records->result_array() as $row){
			$row['id'] = 'output#'.$row['kdprogram'].'#'.$row['kdgiat'].'#'.$row['kdoutput'];
			
			//link mapping
			$id = $row['thang'].'-'.$row['kdunit'].'-'.$row['kddept'].'-'.$row['kdprogram'].'-'.$row['kdgiat'].'-'.$row['kdoutput'].'-'.$row['kdjendok'].'-'.$row['kdsatker'].'-'.$row['kdlokasi'].'-'.$row['kdkabkota'].'-'.$row['kddekon'].'-'.$row['kdsoutput'];
			$mapping = '<a href='.base_url().'index.php/e-budget/mapping_output/mapping/'.$id.'><img border=\'0\' src=\''.base_url().'images/icon/input.png\'></a>';
			
			//alokasi dipa
			$nilai_alokasi = $row['totaljumlah'];
			
			//alokasi swakelola dan kontrak
			$nilai_keuangan = 0;
			$paket = $this->mom->get_paket_o($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput']);
			if($paket->num_rows > 0){
				foreach($paket->result() as $pk){
					$nilai_keuangan += $this->mom->get_swakelola($pk->idpaket)->row()->jumlah;
					$nilai_keuangan += $this->mom->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
				}
			}
			
			$row['name'] = '['.$row['kdoutput'].'] Output - '.$row['nmoutput'];
			$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
			$row['uang'] = $this->mom->cek_mapping_output($id) > 0 ? '<a href=\'#\'><img border=\'0\' src=\'' . base_url() . 'images/flexigrid/setujui.png\'></a>' : "";
			$row['evaluasi'] = $mapping;
			$row['state'] = 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}

	function mapping($id)
	{
		$kode = explode('-',$id);

		$thang = $kode[0];
		$kdunit = $kode[1];
		$kddept = $kode[2];
		$kdprogram = $kode[3];
		$kdgiat = $kode[4];
		$kdoutput = $kode[5];
		$kdjendok = $kode[6];
		$kdsatker = $kode[7];
		$kdlokasi = $kode[8];
		$kdkabkota = $kode[9];
		$kddekon = $kode[10];
		$kdsoutput = $kode[11];

		$ikk = $this->input->post('ikk');
        if ($ikk) {
            $this->mom->save_fokus_prioritas($id, $ikk);
        }
        $d_item = $this->lmm->get_d_item_by_output($thang,$kdjendok,$kdsatker,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdlokasi,$kdkabkota,$kddekon,$kdsoutput);

        $data2['id'] = $id;
		$data2['unit'] = $this->lmm->get_unit_by_idskmpnen($kddept, $kdunit);
		$data2['program'] = $this->lmm->get_program_by_idskmpnen($kdprogram, $kddept, $kdunit);
		$data2['giat'] = $this->lmm->get_kegiatan_by_idskmpnen($kdprogram, $kddept, $kdunit, $kdgiat);
		$data2['output'] = $this->lmm->get_output_by_idskmpnen($kdoutput, $kdgiat);
		$data2['d_item'] = $d_item;
		$data2['allikk'] = $this->mom->get_all_ikk($kdgiat);
		$data['content'] = $this->load->view('e-budget/view_add_mapping_output',$data2,true);
		$this->load->view('main',$data);
	}
	
	function has_kegiatan($id)
	{
		$rs = $this->lmm->get_where('t_program','kdprogram',$id);
		return $rs->num_rows() > 0 ? true : false;
	}
	
	function has_output($id)
	{
		$rs = $this->lmm->get_where('t_giat','kdgiat',$id);
		return $rs->num_rows() > 0 ? true : false;
	}

	function edit_mapping($kdunit, $key, $satker, $page) {
        $ikk = $this->input->post('ikk');
        $ret = 0;
        if ($ikk ) {
            $ret = $this->mm->save_fokus_prioritas($key, $fokus_prioritas, $ikk, $fokus_prioritas_utama, $reformasi_kesehatan, $reformasi_kesehatan_utama);
        }
        
        $data2 = array();
        
        $fokus_ikk = $this->mm->get_fokus_prioritas_ikk($key);

        //die (var_dump($fokus_ikk));
  
        $giats = explode("-", $key);
        $allikk = $this->mm->get_all_ikk($giats[4]);
        $thang =  $this->session->userdata('thn_anggaran');
        $view = $this->mm->get_data($thang, $kdunit, $key);
        
        $data = array();
        $data['content'] = $this->load->view('e-budget/view_mapping_edit', $data2, true);
        //die (var_dump( $data['content']));
        $this->load->view('main', $data);
    }
}
?>

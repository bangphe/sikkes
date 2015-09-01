<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapping_output extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->helper('fusioncharts');
		$this->load->model('e-monev/laporan_monitoring_model2','lmm');
		$this->load->model('e-monev/laporan_evaluasi_model','lem');
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
		$this->evaluasiTree();
	}
	
	function unggah($id)
	{
		$data2['id'] = $id;
		$data2['error_file'] = '';
		if($this->session->userdata('upload_file') != ''){
			$data2['error_file'] = $this->session->userdata('upload_file');
			$this->session->unset_userdata('upload_file');
		}
		$data['content'] = $this->load->view('e-monev/form_unggah_evaluasi',$data2,true);
		$this->load->view('main',$data);
	}
	
	function do_unggah($id)
	{
		$file = null;
		$config['upload_path'] = "./file";
		$config['allowed_types'] ='doc|docx|pdf|xls|xlsx|txt';
		$config['max_size']	= '10000';
							
		// create directory if doesn't exist
		if(!is_dir($config['upload_path']))
		mkdir($config['upload_path'], 0777);
			
		$this->load->library('upload', $config);
		
		if($_FILES['file_unggah']['name'] != ""){			
			if(!$this->upload->do_upload('file_unggah')){
				$data_file = $this->upload->data();
				$notif_upload = '<font color="red"><b>'.$this->upload->display_errors("<p>Error Upload : ", "</p>").$data_file['file_type'].'</b></font>';
				$this->session->set_userdata('upload_file', $notif_upload);
				redirect('e-monev/laporan_evaluasi/unggah/'.$id);
			}else{
				$data_file = $this->upload->data();
				if($data_file['file_size'] > 0) $file = $data_file['file_name'];
			}
		}else{
			$notif_upload = '<font color="red"><b>Upload File terlebih dahulu.</b></font>';
			$this->session->set_userdata('upload_file', $notif_upload);
			redirect('e-monev/laporan_evaluasi/unggah/'.$id);
		}
		$data = array(
			'id' => $id,
			'nama_dokumen' => $file
		);
		if($this->lem->get_dokumen($id)->num_rows()>0){
			$file_gambar = $data_file['file_path'].$this->lem->get_dokumen($id)->row()->nama_dokumen;
			if(is_file($file_gambar)){
				unlink($file_gambar);
			}
			$this->lem->unggah($data,1);
		}else{
			$this->lem->unggah($data,2);
		}
		
		redirect('e-monev/laporan_evaluasi/');
	}
	
	function evaluasiTree()
	{
		$data['title'] = 'Laporan Evaluasi';
		$data['content'] = $this->load->view('e-monev/evaluasi2',$data,true);
		$this->load->view('main',$data);
	}
	
	function loadData(){
		$records = $this->lem->program();
		$arr = array("total"=>$records->num_rows(), "rows"=>array());
		$parent = array();
		$unduh = '<a href=#><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';
		foreach($records->result() as $row)
		{
			if($this->lmm->get_where2($this->db->database.'.d_item','kdprogram',$row->kdprogram,'kdgiat',$row->kdgiat)->num_rows() > 0)
			{
				foreach($this->lem->getAlokasiKeg($row->kdprogram,$row->kdgiat)->result() as $aloKeg){
				$alokasiKeg = 'Rp. '.number_format($aloKeg->total);	
				}
			}
			else{
				$alokasiKeg ="";
			}
			array_push($parent, array("id"=>$row->kdprogram,"code"=>'['.$row->kdprogram.'] - '.$row->nmprogram,"name"=>number_format($row->totaljumlah),"uang"=>"","rk"=>"","rf"=>"","evaluasi"=>$unduh,"state"=>"closed"));
			foreach($this->lem->keg($row->kddept,$row->kdprogram)->result() as $row2)
			{
				array_push($parent, array("id"=>$row2->kdgiat,"code"=>'['.$row2->kdgiat.'] - '.$row2->nmgiat,"name"=>$alokasiKeg,"uang"=>"","rk"=>"","rf"=>"","evaluasi"=>$unduh,"_parentId"=>$row->kdprogram,"state"=>"closed"));
				foreach($this->lem->output($row->kdprogram,$row2->kdgiat)->result() as $row3)
				{
					array_push($parent, array("id"=>$row3->kdoutput,"code"=>'['.$row3->kdoutput.'] - '.$row3->nmoutput,"name"=>"","keu"=>"","fisik"=>"","evaluasi"=>$unduh,"_parentId"=>$row2->kdgiat));
				}
			}
		}
		$arr["rows"] = $parent;
		echo json_encode($arr);
		//echo json_encode($arr);
	}
	
	function treeGrid()
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
			$records = $this->lem->program();
			//$records2 = $this->lem->keg();
			foreach($records->result_array() as $row){
				$row['id'] = 'prog#'.$row['kdprogram'].'#'.$row['kddept'];
				
				//unggah dan unduh evaluasi
				$id_file = 'prog_'.$row['kdprogram'].'_'.$row['kddept'];
				if($this->lem->get_dokumen($id_file)->num_rows() > 0){
					$nama_file = $this->lem->get_dokumen($id_file)->row()->nama_dokumen;
					$unduh = '<a href='.base_url().'file/'.$nama_file.'><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';
					$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
				}else{
					$unduh = '<a href=#><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';;
					$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
				}
				
				//alokasi dipa
				$nilai_alokasi = $row['totaljumlah'];
				
				//alokasi swakelola dan kontrak
				$nilai_keuangan = 0;
				// $paket = $this->lem->get_paket_p($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen']);
				$paket = $this->lem->get_paket_p($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram']);
				if($paket->num_rows > 0){
					foreach($paket->result() as $pk){
						$nilai_keuangan += $this->lem->get_swakelola($pk->idpaket)->row()->jumlah;
						$nilai_keuangan += $this->lem->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
					}
				}
				
				$row['name'] = '['.$row['kdprogram'].'] - '.$row['nmprogram'];
				$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
				$row['uang'] = 'Rp. '.number_format($nilai_keuangan);
				$row['evaluasi'] = $unduh.' '.$unggah;
				$row['state'] = $this->has_kegiatan($row['kdprogram']) ? 'closed' : 'open';
				array_push($result, $row);
				
			}
			echo json_encode($result);
		}
	}
	
	function getKegiatan($kddept,$kdprogram)
	{
		$result = array();
		$records = $this->lem->keg($kddept,$kdprogram);
		foreach($records->result_array() as $row){
			$row['id'] = 'keg#'.$row['kdgiat'].'#'.$row['kdprogram'];
			
			//unggah dan unduh evaluasi
			$id_file = 'keg_'.$row['kdgiat'].'_'.$row['kdprogram'];
			if($this->lem->get_dokumen($id_file)->num_rows() > 0){
				$nama_file = $this->lem->get_dokumen($id_file)->row()->nama_dokumen;
				$unduh = '<a href='.base_url().'file/'.$nama_file.'><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}else{
				$unduh = '<a href=#><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';;
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}
			
			//alokasi dipa
			$nilai_alokasi = $row['totaljumlah'];
			
			//alokasi swakelola dan kontrak
			$nilai_keuangan = 0;
			$paket = $this->lem->get_paket_g($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat']);
			if($paket->num_rows > 0){
				foreach($paket->result() as $pk){
					$nilai_keuangan += $this->lem->get_swakelola($pk->idpaket)->row()->jumlah;
					$nilai_keuangan += $this->lem->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
				}
			}
			
			$row['name'] = '['.$row['kdgiat'].'] Kegiatan - '.$row['nmgiat'];
			$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
			$row['uang'] = 'Rp. '.number_format($nilai_keuangan);
			$row['evaluasi'] = $unduh.' '.$unggah;
			$row['state'] = $this->has_output($row['kdgiat']) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	function getOutput($kdprogram,$kdgiat)
	{
		$result = array();
		$records = $this->lem->output($kdprogram,$kdgiat);
		foreach($records->result_array() as $row){
			$row['id'] = 'output#'.$row['kdprogram'].'#'.$row['kdgiat'].'#'.$row['kdoutput'];
			
			//unggah dan unduh evaluasi
			$id_file = 'output_'.$row['kdprogram'].'_'.$row['kdgiat'].'_'.$row['kdoutput'];
			if($this->lem->get_dokumen($id_file)->num_rows() > 0){
				$nama_file = $this->lem->get_dokumen($id_file)->row()->nama_dokumen;
				$unduh = '<a href='.base_url().'file/'.$nama_file.'><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}else{
				$unduh = '<a href=#><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';;
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}
			
			//alokasi dipa
			$nilai_alokasi = $row['totaljumlah'];
			
			//alokasi swakelola dan kontrak
			$nilai_keuangan = 0;
			$paket = $this->lem->get_paket_o($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput']);
			if($paket->num_rows > 0){
				foreach($paket->result() as $pk){
					$nilai_keuangan += $this->lem->get_swakelola($pk->idpaket)->row()->jumlah;
					$nilai_keuangan += $this->lem->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
				}
			}
			
			$row['name'] = '['.$row['kdoutput'].'] Output - '.$row['nmoutput'];
			$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
			$row['uang'] = 'Rp. '.number_format($nilai_keuangan);
			$row['evaluasi'] = $unduh.' '.$unggah;
			$row['state'] = $this->has_suboutput($row['kdoutput']) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	function getSubOutput($kdprogram,$kdgiat,$kdoutput)
	{
		$result = array();
		$records = $this->lem->suboutput($kdprogram,$kdgiat,$kdoutput);
		foreach($records->result_array() as $row){
			$row['id'] = 'suboutput#'.$row['kdprogram'].'#'.$row['kdgiat'].'#'.$row['kdoutput'].'#'.$row['kdsoutput'];
			
			//unggah dan unduh evaluasi
			$id_file = 'suboutput_'.$row['kdprogram'].'_'.$row['kdgiat'].'_'.$row['kdoutput'].'_'.$row['kdsoutput'];
			if($this->lem->get_dokumen($id_file)->num_rows() > 0){
				$nama_file = $this->lem->get_dokumen($id_file)->row()->nama_dokumen;
				$unduh = '<a href='.base_url().'file/'.$nama_file.'><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}else{
				$unduh = '<a href=#><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';;
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}
			
			//alokasi dipa
			$nilai_alokasi = $row['totaljumlah'];
			
			//alokasi swakelola dan kontrak
			$nilai_keuangan = 0;
			$paket = $this->lem->get_paket_so($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput']);
			if($paket->num_rows > 0){
				foreach($paket->result() as $pk){
					$nilai_keuangan += $this->lem->get_swakelola($pk->idpaket)->row()->jumlah;
					$nilai_keuangan += $this->lem->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
				}
			}
			
			$row['name'] = '['.$row['kdsoutput'].'] Sub Output - '.$row['ursoutput'];
			$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
			$row['uang'] = 'Rp. '.number_format($nilai_keuangan);
			$row['evaluasi'] = $unduh.' '.$unggah;
			$row['state'] = $this->has_komponen($row['kdsoutput']) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	function getKomponen($kdprogram,$kdgiat,$kdoutput,$kdsoutput)
	{
		$result = array();
		$records = $this->lem->komponen($kdprogram,$kdgiat,$kdoutput,$kdsoutput);
		foreach($records->result_array() as $row){
			$row['id'] = 'komponen#'.$row['kdprogram'].'#'.$row['kdgiat'].'#'.$row['kdoutput'].'#'.$row['kdsoutput'].'#'.$row['kdkmpnen'];
			
			//unggah dan unduh evaluasi
			$id_file = 'komponen_'.$row['kdprogram'].'_'.$row['kdgiat'].'_'.$row['kdoutput'].'_'.$row['kdsoutput'].'_'.$row['kdkmpnen'];
			if($this->lem->get_dokumen($id_file)->num_rows() > 0){
				$nama_file = $this->lem->get_dokumen($id_file)->row()->nama_dokumen;
				$unduh = '<a href='.base_url().'file/'.$nama_file.'><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}else{
				$unduh = '<a href=#><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';;
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}
			
			//alokasi dipa
			$nilai_alokasi = $row['totaljumlah'];
			
			//alokasi swakelola dan kontrak
			$nilai_keuangan = 0;
			$paket = $this->lem->get_paket_k($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen']);
			if($paket->num_rows > 0){
				foreach($paket->result() as $pk){
					$nilai_keuangan += $this->lem->get_swakelola($pk->idpaket)->row()->jumlah;
					$nilai_keuangan += $this->lem->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
				}
			}
			
			$row['name'] = '['.$row['kdkmpnen'].'] Komponen - '.$row['urkmpnen'];
			$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
			$row['uang'] = 'Rp. '.number_format($nilai_keuangan);
			$row['evaluasi'] = $unduh.' '.$unggah;
			$row['state'] = $this->has_subkomponen($row['kdkmpnen']) ? 'closed' : 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	
	function getSubKomponen($kdprogram,$kdgiat,$kdoutput,$kdsoutput,$kdkmpnen)
	{
		$result = array();
		$records = $this->lem->subkomponen($kdprogram,$kdgiat,$kdoutput,$kdsoutput,$kdkmpnen);
		foreach($records->result_array() as $row){
			$row['id'] = 'subkomponen#'.$row['kdsoutput'].'#'.$row['kdkmpnen'].'#'.$row['kdprogram'].'#'.$row['kdgiat'];
			
			//unggah dan unduh evaluasi
			$id_file = 'subkomponen_'.$row['kdsoutput'].'_'.$row['kdkmpnen'].'_'.$row['kdprogram'].'_'.$row['kdgiat'];
			if($this->lem->get_dokumen($id_file)->num_rows() > 0){
				$nama_file = $this->lem->get_dokumen($id_file)->row()->nama_dokumen;
				$unduh = '<a href='.base_url().'file/'.$nama_file.'><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}else{
				$unduh = '<a href=#><img border=\'0\' src=\''.base_url().'images/icon/download2.png\'></a>';;
				$unggah = '<a href='.base_url().'index.php/e-monev/laporan_evaluasi/unggah/'.$id_file.'><img border=\'0\' src=\''.base_url().'images/icon/upload2.png\'></a>';
			}
			
			//alokasi dipa
			$nilai_alokasi = $row['totaljumlah'];
			
			//alokasi swakelola dan kontrak
			$nilai_keuangan = 0;
			$paket = $this->lem->get_paket_sk($row['thang'], $row['kdjendok'], $row['kddept'], $row['kdunit'], $row['kdprogram'], $row['kdgiat'], $row['kdoutput'], $row['kdsoutput'], $row['kdkmpnen'], $row['kdskmpnen']);
			if($paket->num_rows > 0){
				foreach($paket->result() as $pk){
					$nilai_keuangan += $this->lem->get_swakelola($pk->idpaket)->row()->jumlah;
					$nilai_keuangan += $this->lem->get_kontraktual($pk->idpaket)->row()->nilaikontrak;
				}
			}
				
			$row['name'] = '['.$row['kdskmpnen'].'] Sub Komponen - '.$row['urskmpnen'];
			$row['alo'] = 'Rp. '.number_format($nilai_alokasi);
			$row['uang'] = 'Rp. '.number_format($nilai_keuangan);
			$row['evaluasi'] = $unduh.' '.$unggah;
			$row['state'] = 'open';
			array_push($result, $row);
		}
		echo json_encode($result);
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
	
	function has_suboutput($kdoutput)
	{
		$rs = $this->lmm->get_where('t_output','kdoutput',$kdoutput);
		return $rs->num_rows() > 0 ? true : false;
	}
	
	function has_komponen($id)
	{
		$rs = $this->lmm->get_where('d_soutput','kdsoutput',$id);
		return $rs->num_rows() > 0 ? true : false;
	}
	
	function has_subkomponen($kdkmpnen)
	{
		$rs = $this->lmm->get_where('d_kmpnen','kdkmpnen',$kdkmpnen);
		return $rs->num_rows() > 0 ? true : false;
	}
}
?>

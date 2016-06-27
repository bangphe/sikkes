<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback extends CI_Controller {
    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 0;

    function __construct() {
        parent::__construct();
		$this->cek_session();
        $this->load->library('form_validation');
        $this->load->library('general');
        $this->load->library('session');
        $this->load->library('flexigrid');
        $this->load->helper('flexigrid');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('e-planning/manajemen_model','mm');
        $this->load->model('e-planning/pendaftaran_model', 'pm');
        $this->load->model('e-planning/feedback_model', 'fm');
    }
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
    
    function index($kdpengajuan){
        $pengajuan = $this->pm->get_data_pengajuan($kdpengajuan);
        $feedback = $this->fm->get_history($kdpengajuan);        
        $data = array();
		$tembusan = '';
        
        foreach($pengajuan->result() as $row) {            
            $data['kdsatker'] = $row->NO_REG_SATKER;
            $data['KodeJenisSatker'] = $row->KodeJenisSatker;
            $data['provinsi'] = $row->NamaProvinsi;
            $data['judul'] = $row->JUDUL_PROPOSAL;
            $data['thn_anggaran'] = $row->TAHUN_ANGGARAN;            
            $data['nomor'] = $row->NOMOR_SURAT;
            $data['perihal'] = $row->PERIHAL;
            $data['selected_rencana_anggaran'] = $row->ID_RENCANA_ANGGARAN;
            if ($row->TANGGAL_PEMBUATAN != NULL)
                $tgl_buat = explode('-', $row->TANGGAL_PEMBUATAN);
            
            $satkerUsulan = $row->KodeJenisSatker;		
            $kdpengajuan = $row->KD_PENGAJUAN;		
			$id_user = $row->ID_USER;			
        }
        
		$user = $this->fm->get_propinsi($id_user);
		
		$tembusan = '';
        /*// get tembusan
        switch ($satkerUsulan) {
            case 1: //jika proposal buatan TP
				if ($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3)	//unit utama		
					$tembusan = $this->fm->get_users(array(1,2), $user->row()->KodeProvinsi, $this->session->userdata('kd_role'),
								$user->row()->USER_ID, $satkerUsulan, $kdpengajuan);
				elseif ($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 2)	//dekon
					$tembusan = '';
				elseif ($this->session->userdata('kd_role') != 3 && $this->session->userdata('kodejenissatker') == 3)	//unit utama		
					$tembusan = $this->fm->get_users(array(1,2), $user->row()->KodeProvinsi, $this->session->userdata('kd_role'),
								$user->row()->USER_ID, $satkerUsulan, $kdpengajuan);
                break;
            case 2: //jika proposal buatan dekon
				if ($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3)	//unit utama
					$tembusan = '';
				elseif ($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 2)	//dekon
					$tembusan = '';
                break;
            case 3: //jika proposal buatan unit utama
				if ($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3)	//unit utama
					$tembusan = '';
                break;
            case 4: //jika proposal buatan kantor pusat
				if ($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3)	//unit utama
					$tembusan = '';
                break;
            case 5: //jika proposal buatan kantor daerah
				if ($this->session->userdata('kd_role') == 3 && $this->session->userdata('kodejenissatker') == 3)	//unit utama
					$tembusan = '';
                break;
        }*/
        
        if (isset($tgl_buat) && is_array($tgl_buat))
            $data['tanggal_pembuatan'] = $tgl_buat[2].'-'.$tgl_buat[1].'-'.$tgl_buat[0];
        else
            $data['tanggal_pembuatan'] = '-';
        
        $data['id_user'] = $this->session->userdata('id_user');
        $data['history'] = $feedback;
        $data['tembusan'] = $tembusan;
        $data['kdpengajuan'] = $kdpengajuan;
        $data['post_action'] = "e-planning/feedback/insert_feedback/$kdpengajuan";
        $data['content'] = $this->load->view('e-planning/feedback/tambah_feedback', $data, true);
        
        $this->load->view('main', $data);
    }
    
    function insert_feedback($kdpengajuan){
        if ($this->cek_validasi() == FALSE){
            $this->index($kdpengajuan);
        }else{
            $tembusan = $this->input->post('tembusan');
            $tembusan_str = '';
            
            for($i=0; $i<count($tembusan); $i++)
                $tembusan_str .= $tembusan[$i].';';
            /* insert data feedback */
            $data = array(
                'ID_PENGAJUAN' => $kdpengajuan,
                'ID_USER' => $this->input->post('id_user'),
                'PESAN' => $this->input->post('feedback_text'),
                'TUJUAN' => $tembusan_str,
				'PARENT' => $this->input->post('reply_from'),
                'STATUS' => '1',
            );
            $this->fm->save($data);
			
			/* update status_koreksi menjadi 1 */
			$data2 = array("STATUS_KOREKSI" => 1);
			$this->mm->update('pengajuan', $data2, 'KD_PENGAJUAN', $kdpengajuan);

        //    $this->index($kdpengajuan);
			redirect('e-planning/feedback/insert_feedback/'.$kdpengajuan);
        }
    }

    function cek_validasi() {
        $config = array(
            array('field' => 'feedback_text', 'label' => 'Isi Feedback', 'rules' => 'required'),
        );

        //setting rules
        $this->form_validation->set_rules($config);

        $this->form_validation->set_message('required', 'Kolom %s harus diisi !!');

        return $this->form_validation->run();
    }
	
	function load_more($kdpengajuan) {
		$tmp = '';
		if(isSet($_POST['id_feedback'])){
			$id_feedback = $_POST['id_feedback'];
			$feedback = $this->fm->get_more($kdpengajuan,$id_feedback);
			$idf = '';
			$tmp = '';
			foreach($feedback->result() as $row){
				
				if($row->STATUS == 0){ 
					$komentar_aktif = "komentar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
				} else {
					$komentar_aktif = '<a href="#repnow" onclick="javascript:replyFrom('.$row->ID_FEEDBACK.')" class="reply-stream" id="reply-stream-'.$row->ID_FEEDBACK.'">komentar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
				
				if($this->session->userdata('id_user') == $row->ID_USER){ 
					if($row->STATUS == 0){ 
						$resolv = "selesai &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
					}else{
						$resolv = '<a href="'.base_url().'index.php/e-planning/feedback/resolv/'.$row->ID_FEEDBACK.'/'.$kdpengajuan.'" class="resolv-stream">selesai</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}
				}
				
				$tmp .= '<li>
					<a href="#"><img class="ava-stream" src="'.base_url().'images/icons/depkes.png" width="40" height="48" alt="'.$row->USERNAME.'" /></a>
					<div class="pesan-stream">
						<div class="nama-stream">'.strtolower($row->USERNAME).'</div>
						<div id="msg-stream-'.$row->ID_FEEDBACK.'">'.$row->PESAN.'</div>
						<div class="date-stream">
							'.$komentar_aktif.' '.$resolv.'
							<a title="'.date("d F Y   H:i ", strtotime($row->TANGGAL)).'WIB">'.$this->general->KonversiWaktu(strtotime($row->TANGGAL)).'</a>
						</div>
					</div>
					<div class="clear"></div>
				</li>';
				
				if($row->PARENT == 0){
					$parent = $this->fm->get_parent($kdpengajuan, $row->ID_FEEDBACK); 
					foreach ($parent->result() as $brs):						
						$tmp .= '<li class="msg-stream-reply">
							<a href="#"><img class="ava-stream-reply" src="'.base_url().'images/icons/depkes.png" width="30" height="38" alt="'.$brs->USERNAME.'" /></a>
							<div class="pesan-stream-reply">
								<div class="nama-stream-reply">'.(strtolower($brs->USERNAME)).'</div>
								<div>'.$brs->PESAN.'</div>
								<div class="date-stream-reply">
									<a title="'.date("d F Y   H:i ", strtotime($brs->TANGGAL)).'WIB">'.$this->general->KonversiWaktu(strtotime($brs->TANGGAL)).'</a>
								</div>
							</div>
							<div class="clear"></div>
						</li>';	
					endforeach; 
				}
				 
				
				$idf = $row->ID_FEEDBACK;
			}
			
			if($feedback->num_rows() < 5){
				$tmp .= '<a href="#judul">
							<div class="morebox">kembali ke atas</div>
						</a>';
			}else{
				$tmp .= '<a href="#" class="more" id="'.$idf.'">
							<div id="more'.$idf.'" class="morebox">selanjutnya</div>
						 </a>';
			}
		}
		
		echo $tmp;
	}
	
	function resolv($id_feedback, $kdpengajuan){
		$data = array('STATUS' => 0);
		$this->fm->resolv($data, $id_feedback);
		
		$parent = $this->fm->get_parent($kdpengajuan, $id_feedback);
		if($parent->result() != NULL){
			$this->fm->resolvParent($data, $id_feedback);
		}
		
		/* update status_koreksi menjadi 0 */
		$data2 = array("STATUS_KOREKSI" => 0);
		$this->mm->update('pengajuan', $data2, 'KD_PENGAJUAN', $kdpengajuan);
		
		redirect("e-planning/feedback/insert_feedback/".$kdpengajuan);
	}
}
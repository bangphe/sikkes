<?php
class Laporan_monitoring_model extends CI_Model {
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
		$this->load->model('role_model');
    }
	
	function update($permasalahan_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('permasalahan_id', $permasalahan_id);
		$monev->update('permasalahan', $data);
	}
        
        function update_penyelesaian($id_upaya_penyelesaian, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('id_upaya_penyelesaian', $id_upaya_penyelesaian);
		$monev->update('upaya_penyelesaian', $data);
	}
        
        function hapus_penyelesaian($id_upaya_penyelesaian)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('id_upaya_penyelesaian', $id_upaya_penyelesaian);
		$monev->delete('upaya_penyelesaian');
	}
	
	function update_ref($referensi_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('referensi_id', $referensi_id);
		$monev->update('monev.referensi', $data);
	}
	
	function update_bobot($id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->update('monev.bobot', $data);
	}
	
	function update_progres($progres_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('progres_id', $progres_id);
		$monev->update('monev.progres', $data);
	}
	
	function update_progres2($spm_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('spm_id', $spm_id);
		$monev->update('monev.spm', $data);
	}
	
	function update_paket($d_skmpnen_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$monev->update('monev.paket', $data);
	}
	
	function update_data_detail_prakontrak($d_skmpnen_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$monev->update('monev.detail_prakontrak', $data);
	}
	
	function update_data_kontrak($d_skmpnen_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$monev->update('monev.kontrak', $data);
	}
	
	function get_where($tabel,$kolom,$parameter){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom, $parameter);
		return $this->db->get();
	}
	// function get_sub_komponen(){
	// 	$kdinduk = $this->get_where($this->db->database.'.ref_satker', 'kdsatker', $this->session->userdata('kdsatker'))->row()->kdinduk;
	// 	$this->db->select('*');
	// 	$this->db->from($this->db->database.'.d_skmpnen d');
	// 	$this->db->join($this->db->database.'.d_kmpnen', $this->db->database.'.d_kmpnen.thang = d.thang AND '.$this->db->database.'.d_kmpnen.kdsatker = d.kdsatker AND '.$this->db->database.'.d_kmpnen.kddept = d.kddept AND '.$this->db->database.'.d_kmpnen.kdunit = d.kdunit AND '.$this->db->database.'.d_kmpnen.kdprogram = d.kdprogram AND '.$this->db->database.'.d_kmpnen.kdgiat = d.kdgiat AND '.$this->db->database.'.d_kmpnen.kdoutput = d.kdoutput AND '.$this->db->database.'.d_kmpnen.kdlokasi = d.kdlokasi AND '.$this->db->database.'.d_kmpnen.kdkabkota = d.kdkabkota AND '.$this->db->database.'.d_kmpnen.kdsoutput = d.kdsoutput AND '.$this->db->database.'.d_kmpnen.kdkmpnen = d.kdkmpnen AND '.$this->db->database.'.d_kmpnen.kdjendok = d.kdjendok  AND '.$this->db->database.'.d_kmpnen.kddekon = d.kddekon', 'left');
	// 	$this->db->join($this->db->database.'.t_output', $this->db->database.'.t_output.kdgiat = d.kdgiat AND '.$this->db->database.'.t_output.kdoutput = d.kdoutput');
	// 	$this->db->join($this->db->database.'.t_giat', $this->db->database.'.t_giat.kdgiat = d.kdgiat');
	// 	$this->db->join($this->db->database.'.t_satker', $this->db->database.'.t_satker.kdsatker = d.kdsatker');
	// 	if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
	// 	{
	// 		$this->db->join($this->db->database.'.ref_satker', $this->db->database.'.ref_satker.kdsatker = d.kdsatker');
	// 		$this->db->where($this->db->database.'.ref_satker.kdinduk', $this->session->userdata('kdinduk'));
	// 	}
	// 	elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
	// 	{
	// 		$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
	// 		$this->db->where($this->db->database.'.t_satker.kdjnssat','4');
	// 	}
	// 	elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
	// 	{
	// 		$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
	// 	}
	// 	$this->db->where('d.thang',$this->session->userdata('thn_anggaran'));
	// 	$this->CI->flexigrid->build_query();
	// 	$return['records'] = $this->db->get();
		
	// 	$this->db->select('*');
	// 	$this->db->from($this->db->database.'.d_skmpnen d');
	// 	$this->db->join($this->db->database.'.d_kmpnen', $this->db->database.'.d_kmpnen.thang = d.thang AND '.$this->db->database.'.d_kmpnen.kdsatker = d.kdsatker AND '.$this->db->database.'.d_kmpnen.kddept = d.kddept AND '.$this->db->database.'.d_kmpnen.kdunit = d.kdunit AND '.$this->db->database.'.d_kmpnen.kdprogram = d.kdprogram AND '.$this->db->database.'.d_kmpnen.kdgiat = d.kdgiat AND '.$this->db->database.'.d_kmpnen.kdoutput = d.kdoutput AND '.$this->db->database.'.d_kmpnen.kdlokasi = d.kdlokasi AND '.$this->db->database.'.d_kmpnen.kdkabkota = d.kdkabkota AND '.$this->db->database.'.d_kmpnen.kdsoutput = d.kdsoutput AND '.$this->db->database.'.d_kmpnen.kdkmpnen = d.kdkmpnen AND '.$this->db->database.'.d_kmpnen.kdjendok = d.kdjendok  AND '.$this->db->database.'.d_kmpnen.kddekon = d.kddekon', 'left');
	// 	$this->db->join($this->db->database.'.t_output', $this->db->database.'.t_output.kdgiat = d.kdgiat AND '.$this->db->database.'.t_output.kdoutput = d.kdoutput');
	// 	$this->db->join($this->db->database.'.t_giat', $this->db->database.'.t_giat.kdgiat = d.kdgiat');
	// 	$this->db->join($this->db->database.'.t_satker', $this->db->database.'.t_satker.kdsatker = d.kdsatker');
	// 	if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
	// 	{
	// 		if($this->session->userdata('kdinduk')== ''){
	// 		$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
	// 		}
	// 		else {
	// 			$this->db->join($this->db->database.'.ref_satker', $this->db->database.'.ref_satker.kdsatker = d.kdsatker');
	// 			$this->db->where($this->db->database.'.ref_satker.kdinduk', $this->session->userdata('kdinduk'));
	// 		}
	// 	}
	// 	elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
	// 	{
	// 		$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
	// 		$this->db->where($this->db->database.'.t_satker.kdjnssat','4');
	// 	}
	// 	elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
	// 	{
	// 		$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
	// 	}
	// 	$this->db->where('d.thang',$this->session->userdata('thn_anggaran'));
	// 	$this->CI->flexigrid->build_query(FALSE);
	// 	$return['record_count'] = $this->db->count_all_results();
	// 	return $return;
	// }

	function get_dja($kdoutput) {
		$this->db->select('*');
		$this->db->from('dja');
		$this->db->where('output', $kdoutput);
		return $this->db->get();
	}

	function get_output(){
		$this->db->select('*');
		$this->db->from($this->db->database.'.d_soutput d');
		$this->db->join($this->db->database.'.t_output', $this->db->database.'.t_output.kdgiat = d.kdgiat AND '.$this->db->database.'.t_output.kdoutput = d.kdoutput');
		$this->db->join($this->db->database.'.t_giat', $this->db->database.'.t_giat.kdgiat = d.kdgiat');
		$this->db->join($this->db->database.'.t_satker', $this->db->database.'.t_satker.kdsatker = d.kdsatker');
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->join($this->db->database.'.ref_satker', $this->db->database.'.ref_satker.kdsatker = d.kdsatker');
			//$this->db->where($this->db->database.'.ref_satker.kdinduk', $this->session->userdata('kdinduk'));
			$this->db->where($this->db->database.'.ref_satker.kdsatker', $this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->where($this->db->database.'.t_satker.kdjnssat','4');
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->where('d.thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($this->db->database.'.d_soutput d');
		$this->db->join($this->db->database.'.t_output', $this->db->database.'.t_output.kdgiat = d.kdgiat AND '.$this->db->database.'.t_output.kdoutput = d.kdoutput');
		$this->db->join($this->db->database.'.t_giat', $this->db->database.'.t_giat.kdgiat = d.kdgiat');
		$this->db->join($this->db->database.'.t_satker', $this->db->database.'.t_satker.kdsatker = d.kdsatker');
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->join($this->db->database.'.ref_satker', $this->db->database.'.ref_satker.kdsatker = d.kdsatker');
			// $this->db->where($this->db->database.'.ref_satker.kdinduk', $this->session->userdata('kdinduk'));
			$this->db->where($this->db->database.'.ref_satker.kdsatker', $this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
			$this->db->where($this->db->database.'.t_satker.kdjnssat','4');
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->where('d.thang',$this->session->userdata('thn_anggaran'));
		$this->CI->flexigrid->build_query(FALSE);
		$return['record_count'] = $this->db->count_all_results();
		return $return;
	}

	function get_output_tree($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kddekon, $kdsoutput)
	{
		$this->db->select('*');
		$this->db->from($this->db->database.'.d_soutput d');
		$this->db->join($this->db->database.'.t_output', $this->db->database.'.t_output.kdgiat = d.kdgiat AND '.$this->db->database.'.t_output.kdoutput = d.kdoutput');
		$this->db->join($this->db->database.'.t_giat', $this->db->database.'.t_giat.kdgiat = d.kdgiat');
		$this->db->join($this->db->database.'.t_satker', $this->db->database.'.t_satker.kdsatker = d.kdsatker');
		$this->db->where($this->db->database.'.d.thang',$thang);
		$this->db->where($this->db->database.'.d.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.d.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.d.kddept',$kddept);
		$this->db->where($this->db->database.'.d.kdunit',$kdunit);
		$this->db->where($this->db->database.'.d.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.d.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.d.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.d.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.d.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.d.kddekon',$kddekon);
		$this->db->where($this->db->database.'.d.kdsoutput',$kdsoutput);

		return $this->db->get();
	}

	function get_kegiatan_tree($kdgiat, $kddept, $kdunit, $kdprogram)
	{
		$this->db->select('*');
		$this->db->from($this->db->database.'.t_giat d');
		$this->db->where($this->db->database.'.d.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.d.kddept',$kddept);
		$this->db->where($this->db->database.'.d.kdunit',$kdunit);
		$this->db->where($this->db->database.'.d.kdprogram',$kdprogram);

		return $this->db->get();
	}
	
	function cek_permasalahan_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('permasalahan');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function cek_rencana_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function cek_progres_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function cek_progres2_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function cek_paket($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('permasalahan');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		//$this->db->where('thang',date("Y"));
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
		$result = $monev->get();
		if($result->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function add($data)
	{
            $monev = $this->load->database('monev',TRUE);
		$monev->insert('permasalahan',$data);
	}
        
        function add_penyelesaian($data)
	{
            $monev = $this->load->database('monev',TRUE);
		$monev->insert('upaya_penyelesaian',$data);
	}
	
	function add_sp2d($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.data_sp2d',$data);
	}
	
	function add_spm($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.sp2d',$data);
	}
	
	function add_rencana($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.rencana',$data);
	}
	
	function add_bobot($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.bobot',$data);
	}
	
	function add_progres($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.progres',$data);
	}
	
	function add_progres2($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.spm',$data);
	}
	
	function add_paket($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.paket',$data);
	}
	
	function add_detailprakontrak($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.detail_prakontrak',$data);
	}
	
	function add_data_kontrak($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.kontrak',$data);
	}
	
	function add_jadual_pelaksanaan($data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->insert('monev.jadual_pelaksanaan',$data);
	}
	
	function get_permasalahan($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*, count(*) as jml_permasalahan');
		$monev->from('permasalahan');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
                $monev->group_by("bulan"); 
		return $monev->get()->result();
	}
        
        function count_permasalahan($d_skmpnen_id, $bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('count(*) as jml_permasalahan');
		$monev->from('permasalahan');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
                $monev->where("bulan", $bulan); 
		return $monev->get();
	}
        
        function get_permasalahan_byBulan($d_skmpnen_id, $bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('p.*, count(u.id_permasalahan) as jml_penyelesaian');
		$monev->from('permasalahan p');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
                $monev->where("bulan", $bulan); 
                $monev->join('upaya_penyelesaian u','u.id_permasalahan=p.permasalahan_id','left');
                $monev->group_by('p.permasalahan_id');
		return $monev->get()->result();
	}
	
	function get_rencana3($d_skmpnen_id,$bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
	
	function cek_presentase_rencana($d_skmpnen_id,$rencana_id)
	{
		
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('rencana_id !=', $rencana_id);
		return $monev->get()->result();
		// $sql = 'select * from monev.rencana where d_skmpnen_id = '.$d_skmpnen_id.' and tahun = '.$this->session->userdata('thn_anggaran').' and rencana_id <> '.$rencana_id.'';
		// return $this->db->query($sql)->result();
	}
	
	function cek_presentase_progres($d_skmpnen_id,$progres_id)
	{
		
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('rencana_id <>', $rencana_id);
		return $monev->get()->result();
		// $sql = 'select * from monev.progres where d_skmpnen_id = '.$d_skmpnen_id.' and tahun = '.$this->session->userdata('thn_anggaran').' and progres_id <> '.$progres_id.'';
		// return $this->db->query($sql)->result();
	}
	
	function get_rencana2($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_rencana4($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('fisik',0);
		return $monev->get();
	}
	
	function get_rencana5($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('keuangan',0);
		return $monev->get();
	}
	
	function get_referensi()
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.referensi');
		return $monev->get();
	}
	
	function is_exist_fisik_more_than_100_bef($d_skmpnen_id,$progres_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('progres_id <',$progres_id);
		$monev->where('fisik',100);
		if($monev->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_progres($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get()->result();
	}
	
	function get_progress($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_progress3($d_skmpnen_id,$bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
	
	function get_progres2($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get()->result();
	}
	
	function get_progress2($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_progress4($d_skmpnen_id,$bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
	
	function get_provinsi()
	{
		$this->db->select();
		$this->db->from($this->db->database.'.ref_provinsi');
		return $this->db->get()->result();
	}
	
	function get_kppn()
	{
		$this->db->select();
		$this->db->from($this->db->database.'.ref_kppn');
		return $this->db->get()->result();
	}
	
	function get_kabupaten_by_kode_provinsi($kode_provinsi)
	{
		$this->db->select();
		$this->db->from('ref_kabupaten');
		$this->db->where('KodeProvinsi',$kode_provinsi);
		return $this->db->get()->result();
	}
	
	function get_permasalahan_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('permasalahan');
		$monev->where('permasalahan_id',$id);
		return $monev->get();
	}
        
        function get_upaya_penyelesaian_by_masalah($id_permasalahan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('upaya_penyelesaian');
		$monev->where('id_permasalahan',$id_permasalahan);
		return $monev->get();
	}
        
        function get_upaya_penyelesaian_by_id($id_upaya)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('upaya_penyelesaian');
		$monev->where('id_upaya_penyelesaian',$id_upaya);
		return $monev->get();
	}
	
	function get_progres_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('progres_id',$id);
		return $monev->get();
	}
	
	function get_progres2_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('spm_id',$id);
		return $monev->get();
	}
	
	function get_sp2d_by_spm_id($spm_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.sp2d');
		$monev->where('spm_id',$spm_id);
		return $monev->get();
	}
	
	function get_tot_sp2d_by_akun($spm_id,$kdakun)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select_sum('nominal');
		$monev->from('monev.sp2d');
		$monev->where('spm_id',$spm_id);
		$monev->where('kdakun',$kdakun);
		return $monev->get();
	}

	function get_jenis_item()
	{
		$this->db->select();
		$this->db->from('ref_jenis_item');
		return $this->db->get();
	}

	function get_referensi_by_id($id)
	{
		$this->db->select();
		$this->db->from($this->db->database.'.referensi');
		$this->db->where($this->db->database.'.referensi.referensi_id',$id);
		return $this->db->get();
	}

	function cek_paket_by_kegiatan($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat)
	{
		$this->db->select();
		$this->db->from($this->db->database.'.paket_output paket');
		$this->db->where($this->db->database.'.paket.thang',$thang);
		$this->db->where($this->db->database.'.paket.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.paket.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.paket.kddept',$kddept);
		$this->db->where($this->db->database.'.paket.kdunit',$kdunit);
		$this->db->where($this->db->database.'.paket.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.paket.kdgiat',$kdgiat);

		return $this->db->get();
	}

	function cek_kegiatan_terisi($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram)
	{
		$this->db->select('COUNT(DISTINCT kdgiat) AS JUMLAH');
		$this->db->from($this->db->database.'.paket_output paket');
		$this->db->where($this->db->database.'.paket.thang',$thang);
		$this->db->where($this->db->database.'.paket.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.paket.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.paket.kddept',$kddept);
		$this->db->where($this->db->database.'.paket.kdunit',$kdunit);
		$this->db->where($this->db->database.'.paket.kdprogram',$kdprogram);
		$this->db->group_by($this->db->database.'.paket.kdprogram',$kdprogram);
		$query = $this->db->get();
		foreach ($query->result() as $data) {
			return $data->JUMLAH;
		}
	}

	function cek_paket_by_kdoutput($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kddekon, $kdsoutput)
	{
		$this->db->select();
		$this->db->from($this->db->database.'.paket_output paket');
		$this->db->where($this->db->database.'.paket.thang',$thang);
		$this->db->where($this->db->database.'.paket.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.paket.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.paket.kddept',$kddept);
		$this->db->where($this->db->database.'.paket.kdunit',$kdunit);
		$this->db->where($this->db->database.'.paket.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.paket.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.paket.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.paket.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.paket.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.paket.kddekon',$kddekon);
		$this->db->where($this->db->database.'.paket.kdsoutput',$kdsoutput);

		return $this->db->get();
	}

	function cek_paket_by_idskmpnen($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kddekon, $kdsoutput, $kdkmpnen, $kdskmpnen)
	{
		$this->db->select();
		$this->db->from($this->db->database.'.paket');
		$this->db->where($this->db->database.'.paket.thang',$thang);
		$this->db->where($this->db->database.'.paket.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.paket.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.paket.kddept',$kddept);
		$this->db->where($this->db->database.'.paket.kdunit',$kdunit);
		$this->db->where($this->db->database.'.paket.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.paket.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.paket.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.paket.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.paket.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.paket.kddekon',$kddekon);
		$this->db->where($this->db->database.'.paket.kdsoutput',$kdsoutput);
		$this->db->where($this->db->database.'.paket.kdkmpnen',$kdkmpnen);
		$this->db->like($this->db->database.'.paket.kdskmpnen',$kdskmpnen, 'before');

		return $this->db->get();
	}

	function get_paket_by_output($thang, $kdjendok, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kddekon, $kdsoutput)
	{
		$this->db->select();
		$this->db->from($this->db->database.'.paket_output paket');
		$this->db->where($this->db->database.'.paket.thang',$thang);
		$this->db->where($this->db->database.'.paket.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.paket.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.paket.kddept',$kddept);
		$this->db->where($this->db->database.'.paket.kdunit',$kdunit);
		$this->db->where($this->db->database.'.paket.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.paket.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.paket.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.paket.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.paket.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.paket.kddekon',$kddekon);
		$this->db->where($this->db->database.'.paket.kdsoutput',$kdsoutput);

		return $this->db->get();
	}

	function get_satker_by_idskmpnen($kdsatker)
	{
		$this->db->select($this->db->database.'.t_satker.nmsatker');
		$this->db->from($this->db->database.'.t_satker');
		$this->db->where($this->db->database.'.t_satker.kdsatker',$kdsatker);

		return $this->db->get()->row()->nmsatker;
	}

	function get_unit_by_idskmpnen($kddept, $kdunit)
	{
		$this->db->select($this->db->database.'.t_unit.nmunit');
		$this->db->from($this->db->database.'.t_unit');
		$this->db->where($this->db->database.'.t_unit.kddept',$kddept);
		$this->db->where($this->db->database.'.t_unit.kdunit',$kdunit);

		return $this->db->get()->row()->nmunit;
	}

	function get_program_by_idskmpnen($kdprogram, $kddept, $kdunit)
	{
		$this->db->select($this->db->database.'.t_program.nmprogram');
		$this->db->from($this->db->database.'.t_program');
		$this->db->where($this->db->database.'.t_program.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.t_program.kddept',$kddept);
		$this->db->where($this->db->database.'.t_program.kdunit',$kdunit);

		return $this->db->get()->row()->nmprogram;
	}

	function get_kegiatan_by_idskmpnen($kdprogram, $kddept, $kdunit, $kdgiat)
	{
		$this->db->select($this->db->database.'.t_giat.nmgiat');
		$this->db->from($this->db->database.'.t_giat');
		$this->db->where($this->db->database.'.t_giat.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.t_giat.kddept',$kddept);
		$this->db->where($this->db->database.'.t_giat.kdunit',$kdunit);
		$this->db->where($this->db->database.'.t_giat.kdgiat',$kdgiat);

		return $this->db->get()->row()->nmgiat;
	}

	function get_output_by_idskmpnen($kdoutput, $kdgiat)
	{
		$this->db->select($this->db->database.'.t_output.nmoutput');
		$this->db->from($this->db->database.'.t_output');
		$this->db->where($this->db->database.'.t_output.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.t_output.kdgiat',$kdgiat);

		return $this->db->get()->row()->nmoutput;
	}

	function get_soutput_by_idskmpnen($thang, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kdjendok, $kddekon)
	{
		$this->db->select($this->db->database.'.d_soutput.ursoutput');
		$this->db->from($this->db->database.'.d_soutput');
		$this->db->where($this->db->database.'.d_soutput.thang',$thang);
		$this->db->where($this->db->database.'.d_soutput.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.d_soutput.kddept',$kddept);
		$this->db->where($this->db->database.'.d_soutput.kdunit',$kdunit);
		$this->db->where($this->db->database.'.d_soutput.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.d_soutput.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.d_soutput.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.d_soutput.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.d_soutput.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.d_soutput.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.d_soutput.kddekon',$kddekon);

		return $this->db->get()->row()->ursoutput;
		// if($this->db->get()->num_rows() > 0 ) {
		// 	return $this->db->get()->row()->ursoutput;
		// }
		// else {
		// 	return '-';
		// }
	}

	function cek_soutput_by_idskmpnen($thang, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kdjendok, $kddekon)
	{
		$this->db->select($this->db->database.'.d_soutput.ursoutput');
		$this->db->from($this->db->database.'.d_soutput');
		$this->db->where($this->db->database.'.d_soutput.thang',$thang);
		$this->db->where($this->db->database.'.d_soutput.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.d_soutput.kddept',$kddept);
		$this->db->where($this->db->database.'.d_soutput.kdunit',$kdunit);
		$this->db->where($this->db->database.'.d_soutput.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.d_soutput.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.d_soutput.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.d_soutput.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.d_soutput.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.d_soutput.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.d_soutput.kddekon',$kddekon);

		if($this->db->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function get_komponen_by_idskmpnen($thang, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kdsoutput, $kdkmpnen, $kdjendok, $kddekon)
	{
		$this->db->select($this->db->database.'.d_kmpnen.urkmpnen');
		$this->db->from($this->db->database.'.d_kmpnen');
		$this->db->where($this->db->database.'.d_kmpnen.thang',$thang);
		$this->db->where($this->db->database.'.d_kmpnen.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.d_kmpnen.kddept',$kddept);
		$this->db->where($this->db->database.'.d_kmpnen.kdunit',$kdunit);
		$this->db->where($this->db->database.'.d_kmpnen.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.d_kmpnen.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.d_kmpnen.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.d_kmpnen.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.d_kmpnen.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.d_kmpnen.kdsoutput',$kdsoutput);
		$this->db->where($this->db->database.'.d_kmpnen.kdkmpnen',$kdkmpnen);
		$this->db->where($this->db->database.'.d_kmpnen.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.d_kmpnen.kddekon',$kddekon);

		return $this->db->get()->row()->urkmpnen;
	}

	function cek_skomponen_by_idskmpnen($thang, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kdsoutput, $kdkmpnen, $kdskmpnen, $kdjendok, $kddekon)
	{
		$this->db->select($this->db->database.'.d_skmpnen.urskmpnen');
		$this->db->from($this->db->database.'.d_skmpnen');
		$this->db->where($this->db->database.'.d_skmpnen.thang',$thang);
		$this->db->where($this->db->database.'.d_skmpnen.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.d_skmpnen.kddept',$kddept);
		$this->db->where($this->db->database.'.d_skmpnen.kdunit',$kdunit);
		$this->db->where($this->db->database.'.d_skmpnen.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.d_skmpnen.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.d_skmpnen.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.d_skmpnen.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.d_skmpnen.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.d_skmpnen.kdsoutput',$kdsoutput);
		$this->db->where($this->db->database.'.d_skmpnen.kdkmpnen',$kdkmpnen);
		//ndek lokal
		//$this->db->where($this->db->database.'.d_skmpnen.kdskmpnen',$kdskmpnen);
		//ndek serper
		$this->db->like($this->db->database.'.d_skmpnen.kdskmpnen',$kdskmpnen, 'before');
		$this->db->where($this->db->database.'.d_skmpnen.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.d_skmpnen.kddekon',$kddekon);

		if($this->db->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function get_skomponen_by_idskmpnen($thang, $kdsatker, $kddept, $kdunit, $kdprogram, $kdgiat, $kdoutput, $kdlokasi, $kdkabkota, $kdsoutput, $kdkmpnen, $kdskmpnen, $kdjendok, $kddekon)
	{
		$this->db->select($this->db->database.'.d_skmpnen.urskmpnen');
		$this->db->from($this->db->database.'.d_skmpnen');
		$this->db->where($this->db->database.'.d_skmpnen.thang',$thang);
		$this->db->where($this->db->database.'.d_skmpnen.kdsatker',$kdsatker);
		$this->db->where($this->db->database.'.d_skmpnen.kddept',$kddept);
		$this->db->where($this->db->database.'.d_skmpnen.kdunit',$kdunit);
		$this->db->where($this->db->database.'.d_skmpnen.kdprogram',$kdprogram);
		$this->db->where($this->db->database.'.d_skmpnen.kdgiat',$kdgiat);
		$this->db->where($this->db->database.'.d_skmpnen.kdoutput',$kdoutput);
		$this->db->where($this->db->database.'.d_skmpnen.kdlokasi',$kdlokasi);
		$this->db->where($this->db->database.'.d_skmpnen.kdkabkota',$kdkabkota);
		$this->db->where($this->db->database.'.d_skmpnen.kdsoutput',$kdsoutput);
		$this->db->where($this->db->database.'.d_skmpnen.kdkmpnen',$kdkmpnen);
		//ndek lokal
		//$this->db->where($this->db->database.'.d_skmpnen.kdskmpnen',$kdskmpnen);
		//ndek serper
		$this->db->like($this->db->database.'.d_skmpnen.kdskmpnen',$kdskmpnen, 'before');
		$this->db->where($this->db->database.'.d_skmpnen.kdjendok',$kdjendok);
		$this->db->where($this->db->database.'.d_skmpnen.kddekon',$kddekon);

		return $this->db->get()->row()->urskmpnen;
	}

	function get_rencana_fisik_by_idpaket($idpaket)
	{
		$this->db->select('k.bulan, k.rencana_id, k.idpaket, k.rencana AS rencana_kontraktual');
		$this->db->from('dm_rencana_fisik k');
		$this->db->where('k.idpaket',$idpaket);
		$this->db->where('k.tahun',$this->session->userdata('thn_anggaran'));
		$this->db->order_by('k.rencana_id','asc');

		return $this->db->get()->result();
	}

	function get_progress_fisik_by_idpaket($idpaket)
	{
		$this->db->select('k.bulan, k.idpaket, k.progress_id, k.progress AS progress_kontraktual');
		$this->db->from('dm_progress_fisik k');
		$this->db->where('k.idpaket',$idpaket);
		$this->db->where('k.tahun',$this->session->userdata('thn_anggaran'));
		$this->db->order_by('k.progress_id','asc');

		return $this->db->get();
	}

	function get_rencana_by_idpaket($idpaket)
	{
		$this->db->select('k.*');
		$this->db->from('dm_rencana_fisik k');
		$this->db->where('k.idpaket',$idpaket);
		$this->db->where('k.tahun',$this->session->userdata('thn_anggaran'));
		$this->db->order_by('k.rencana_id','asc');

		return $this->db->get();
	}

	function get_rencana_by_idpaket_and_month($idpaket,$bulan)
	{
		$this->db->select('k.*');
		$this->db->from('dm_rencana_fisik k');
		$this->db->where('k.idpaket',$idpaket);
		$this->db->where('k.bulan',$bulan);
		$this->db->where('k.tahun',$this->session->userdata('thn_anggaran'));

		return $this->db->get();
	}

	function get_progress_by_idpaket($idpaket)
	{
		$this->db->select('k.*');
		$this->db->from('dm_progress_fisik k');
		$this->db->where('k.idpaket',$idpaket);
		$this->db->where('k.tahun',$this->session->userdata('thn_anggaran'));
		$this->db->order_by('k.progress_id','asc');

		return $this->db->get();
	}

	function get_progress_by_idpaket_and_month($idpaket,$bulan)
	{
		$this->db->select('k.*');
		$this->db->from('dm_progress_fisik k');
		$this->db->where('k.idpaket',$idpaket);
		$this->db->where('k.bulan',$bulan);
		$this->db->where('k.tahun',$this->session->userdata('thn_anggaran'));
		$this->db->order_by('k.progress_id','asc');

		return $this->db->get();
	}

	function get_progress_by_year($idpaket,$bulan,$tahun)
	{
		$this->db->select('k.*');
		$this->db->from('dm_progress_fisik k');
		$this->db->where('k.idpaket',$idpaket);
		$this->db->where('k.bulan',$bulan);
		$this->db->where('k.tahun',$tahun);
		$this->db->order_by('k.progress_id','asc');

		return $this->db->get()->result();
	}

	function get_progress_kontrak_by_idpaket($idpaket)
	{
		$this->db->select();
		$this->db->from('dm_progress_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));
		$this->db->order_by('progress_id','asc');

		return $this->db->get()->result();
	}

	function get_progress_kontrak_by_id($progress_id)
	{
		$this->db->select('');
		$this->db->from('dm_progress_fisik');
		$this->db->where('progress_id',$progress_id);

		return $this->db->get();
	}

	function get_progress_swakelola_by_id($progress_id)
	{
		$this->db->select('');
		$this->db->from('dm_progress_swakelola');
		$this->db->where('progress_id',$progress_id);

		return $this->db->get();
	}

	function get_prog_renc_kontrak_by_idpaket($idpaket)
	{
		$this->db->select();
		$this->db->from('dm_progress_fisik d');
		$this->db->join('dm_rencana_fisik k', 'k.idpaket=d.idpaket AND k.bulan=d.bulan AND k.tahun=d.tahun');
		$this->db->where('d.idpaket',$idpaket);
		$this->db->where('d.tahun',$this->session->userdata('thn_anggaran'));

		return $this->db->get()->result();
	}

	function get_prog_renc_swakelola_by_idpaket($idpaket)
	{
		$this->db->select();
		$this->db->from('dm_progress_swakelola d');
		$this->db->join('dm_rencana_swakelola k', 'k.idpaket=d.idpaket AND k.bulan=d.bulan AND k.tahun=d.tahun');
		$this->db->where('d.idpaket',$idpaket);
		$this->db->where('d.tahun',$this->session->userdata('thn_anggaran'));

		return $this->db->get()->result();
	}

	function get_jnsitem_by_idpaket($idpaket, $noitem, $kdakun)
	{
		$this->db->select('');
		$this->db->from('dm_jns_item');
		$this->db->join('paket','paket.idpaket=dm_jns_item.idpaket');
		$this->db->where('dm_jns_item.idpaket',$idpaket);
		$this->db->where('dm_jns_item.noitem',$noitem);
		$this->db->where('dm_jns_item.kdakun',$kdakun);

		return $this->db->get();
	}

	function get_kontrak_by_idpaket($idpaket)
	{
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('kdjnsitem',2);

		return $this->db->get();
	}

	function get_swakelola_by_idpaket($idpaket)
	{
		$this->db->select_sum('nilaikontrak');
		$this->db->from('dm_jns_item');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('kdjnsitem',1);

		return $this->db->get();
	}

	function get_rencana_swakelola_by_id($id)
	{
		$this->db->select('');
		$this->db->from('dm_rencana_swakelola');
		$this->db->where('rencana_id',$id);

		return $this->db->get();
	}

	function get_rencana_kontrak_fisik_by_id($id)
	{
		$this->db->select('');
		$this->db->from('dm_rencana_fisik');
		$this->db->where('rencana_id',$id);

		return $this->db->get();
	}

	function get_rencana_kontrak_per_bulan($idpaket, $bulan)
	{
		$this->db->select('rencana');
		$this->db->from('dm_rencana_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $this->session->userdata('thn_anggaran'));

		return $this->db->get()->row()->rencana;
	}

	function get_rencana_swakelola_per_bulan($idpaket, $bulan)
	{
		$this->db->select('rencana');
		$this->db->from('dm_rencana_swakelola');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $this->session->userdata('thn_anggaran'));

		return $this->db->get()->row()->rencana;
	}

	function get_progress_kontrak_per_bulan($idpaket, $bulan)
	{
		$this->db->select('*');
		$this->db->from('dm_progress_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $this->session->userdata('thn_anggaran'));

		return $this->db->get()->row();
	}

	function get_progress_swakelola_per_bulan($idpaket, $bulan)
	{
		$this->db->select('*');
		$this->db->from('dm_progress_swakelola');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $this->session->userdata('thn_anggaran'));

		return $this->db->get()->row();
	}	

	function get_rencana_kontrak_after_rencana_id($rencana_id,$idpaket)
	{
		$this->db->select();
		$this->db->from('dm_rencana_fisik');
		$this->db->where('rencana_id >=',$rencana_id);
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun', $this->session->userdata('thn_anggaran'));

		return $this->db->get()->result();
	}

	function get_rencana_swakelola_after_rencana_id($rencana_id,$idpaket)
	{
		$this->db->select();
		$this->db->from('dm_rencana_swakelola');
		$this->db->where('rencana_id >=',$rencana_id);
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun', $this->session->userdata('thn_anggaran'));

		return $this->db->get()->result();
	}

	function get_progress_kontrak_after_progress_id($progress_id,$idpaket)
	{
		$this->db->select();
		$this->db->from('dm_progress_fisik');
		$this->db->where('progress_id >=',$progress_id);
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun', $this->session->userdata('thn_anggaran'));

		return $this->db->get()->result();
	}

	function get_progress_swakelola_after_progress_id($progress_id,$idpaket)
	{
		$this->db->select();
		$this->db->from('dm_progress_swakelola');
		$this->db->where('progress_id >=',$progress_id);
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun', $this->session->userdata('thn_anggaran'));

		return $this->db->get()->result();
	}

	function update_rencana_kontrak($rencana_id, $data)
	{
		$this->db->where('rencana_id', $rencana_id);
		$this->db->update('dm_rencana_fisik', $data);
	}

	function update_rencana_swakelola($rencana_id, $data)
	{
		$this->db->where('rencana_id', $rencana_id);
		$this->db->update('dm_rencana_swakelola', $data);
	}

	function update_progress_kontrak($progress_id, $data)
	{
		$this->db->where('progress_id', $progress_id);
		$this->db->update('dm_progress_fisik', $data);
	}

	function update_progress_swakelola($progress_id, $data)
	{
		$this->db->where('progress_id', $progress_id);
		$this->db->update('dm_progress_swakelola', $data);
	}

	function update_jnsitem($data, $idpaket, $noitem, $kdakun)
	{
		$this->db->where('idpaket',$idpaket);
		$this->db->where('noitem',$noitem);
		$this->db->where('kdakun',$kdakun);
		$this->db->update('dm_jns_item', $data);
	}

	function add_paket_by_output($data)
	{
		$this->db->insert('paket_output', $data);
	}

	function add_kontrak_by_jenis_item($data)
	{
		$this->db->insert('dm_jns_item', $data);
	}

	function add_rencana_fisik_by_idpaket($data)
	{
		$this->db->insert('dm_rencana_fisik', $data);
	}

	function add_rencana_kontrak_by_idpaket($data)
	{
		$this->db->insert('dm_rencana_fisik', $data);
	}

	function add_rencana_swakelola_by_idpaket($data)
	{
		$this->db->insert('dm_rencana_swakelola', $data);
	}

	function add_progress_kontrak_by_idpaket($data)
	{
		$this->db->insert('dm_progress_fisik', $data);
	}

	function add_progress_swakelola_by_idpaket($data)
	{
		$this->db->insert('dm_progress_swakelola', $data);
	}

	function is_exist_progres_swa_more_than_100_bef($progress_id,$idpaket)
	{
		$this->db->select();
		$this->db->from('dm_progress_swakelola');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));
		$this->db->where('progress_id <',$progress_id);
		$this->db->where('progress',100);
		if($this->db->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function is_exist_progres_kont_more_than_100_bef($progress_id,$idpaket)
	{
		$this->db->select();
		$this->db->from('dm_progress_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));
		$this->db->where('progress_id <',$progress_id);
		$this->db->where('progress',100);
		if($this->db->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function cek_jnsitem_by_idpaket($idpaket)
	{
		$this->db->select('');
		$this->db->from('dm_jns_item');
		$this->db->where('idpaket',$idpaket);

		if ($this->db->get()->num_rows > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function cek_rencana_fisik_by_idpaket($idpaket)
	{
		$this->db->select('');
		$this->db->from('dm_rencana_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));

		if ($this->db->get()->num_rows > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function cek_rencana_kontrak_by_idpaket($idpaket)
	{
		$this->db->select('');
		$this->db->from('dm_rencana_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));

		if ($this->db->get()->num_rows > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function cek_rencana_kontrak_terisi_by_idpaket($idpaket)
	{
		$this->db->select('');
		$this->db->from('dm_rencana_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('rencana >=', 0);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));

		if ($this->db->get()->num_rows > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function cek_rencana_swakelola_terisi_by_idpaket($idpaket)
	{
		$this->db->select('');
		$this->db->from('dm_rencana_swakelola');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('rencana >=', 0);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));

		if ($this->db->get()->num_rows > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function cek_rencana_swakelola_by_idpaket($idpaket)
	{
		$this->db->select('');
		$this->db->from('dm_rencana_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));

		if ($this->db->get()->num_rows > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function cek_progress_kontraktual_by_idpaket($idpaket)
	{
		$this->db->select('');
		$this->db->from('dm_progress_fisik');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));

		if ($this->db->get()->num_rows > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function cek_progress_swakelola_by_idpaket($idpaket)
	{
		$this->db->select('');
		$this->db->from('dm_progress_swakelola');
		$this->db->where('idpaket',$idpaket);
		$this->db->where('tahun',$this->session->userdata('thn_anggaran'));

		if ($this->db->get()->num_rows > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function get_paket_by_d_skmpnen_id($id)
	{
		/*$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('paket');
		$monev->where('d_skmpnen_id',$id);
		return $monev->get();*/
		
		$this->db->select();
		$this->db->from('monev.paket');
		$this->db->where('d_skmpnen_id',$id);
		return $this->db->get();
	}
	
	function get_prakontrak_by_d_skmpnen_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('detail_prakontrak');
		$monev->where('d_skmpnen_id',$id);
		return $monev->get();
	}
	
	function get_kontrak_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.kontrak');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_jadual_pelaksanaan_by_d_skmpnen_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.jadual_pelaksanaan');
		$monev->where('d_skmpnen_id',$id);
		return $monev->get();
	}
	
	function get_nama_provinsi_by_kode_provinsi($kode_provinsi)
	{
		$this->db->select();
		$this->db->from($this->db->database.'.ref_provinsi');
		$this->db->where('KodeProvinsi',$kode_provinsi);
		return $this->db->get();
	}
	
	function cek_paket_pengerjaan($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.paket');
		$monev->where('paket_pengerjaan',0);
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function cek_paket2($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('monev.paket');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_nama_kabupaten_by_kode_kabupaten($kode_kabupaten,$kode_provinsi)
	{
		$this->db->select();
		$this->db->from($this->db->database.'.ref_kabupaten');
		$this->db->where('KodeKabupaten',$kode_kabupaten);
		$this->db->where('KodeProvinsi',$kode_provinsi);
		return $this->db->get();
	}
	
	function get_nama_kppn_by_kode_kppn($kode_kppn)
	{
		$this->db->select();
		$this->db->from($this->db->database.'.ref_kppn');
		$this->db->where('KDKPPN',$kode_kppn);

		return $this->db->get();
	}
	
	function get_sub_komponen_by_id($d_skmpnen_id)
	{
		$this->db->select('*');
		$this->db->from('monev.d_skmpnen');
		$this->db->where('d_skmpnen_id',$d_skmpnen_id);
		return $this->db->get();
	}
	
	function get_sub_komponen_()
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('d_skmpnen');
		$monev->where('thang',$this->session->userdata('thn_anggaran'));
		//$monev->where('d_skmpnen_id','1');
		return $monev->get();
	}
	
	function get_d_item_by_output($thang,$kdjendok,$kdsatker,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdlokasi,$kdkabkota,$kddekon,$kdsoutput)
	{
		$this->db->select('*');
		$this->db->from($this->db->database.'.d_soutput d');
		$this->db->join($this->db->database.'.d_item i','i.thang=d.thang AND i.kdjendok=d.kdjendok AND i.kdsatker=d.kdsatker AND i.kddept=d.kddept AND i.kdunit=d.kdunit AND i.kdprogram=d.kdprogram AND i.kdgiat=d.kdgiat AND i.kdoutput=d.kdoutput AND i.kdlokasi=d.kdlokasi AND i.kdkabkota=d.kdkabkota AND i.kdsoutput=d.kdsoutput');
		$this->db->join($this->db->database.'.t_akun t','i.kdakun = t.kdakun');
		$this->db->where('d.thang',$thang);
		$this->db->where('d.kdjendok',$kdjendok);
		$this->db->where('d.kdsatker',$kdsatker);
		$this->db->where('d.kddept',$kddept);
		$this->db->where('d.kdunit',$kdunit);
		$this->db->where('d.kdprogram',$kdprogram);
		$this->db->where('d.kdgiat',$kdgiat);
		$this->db->where('d.kdoutput',$kdoutput);
		$this->db->where('d.kdlokasi',$kdlokasi);
		$this->db->where('d.kdkabkota',$kdkabkota);
		$this->db->where('d.kddekon',$kddekon);
		$this->db->where('d.kdsoutput',$kdsoutput);
		return $this->db->get();
	}
	
	//jumlah rincian biaya
	function get_sum_d_item($thang,$kdjendok,$kdsatker,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdlokasi,$kdkabkota,$kddekon,$kdsoutput)
	{
		$this->db->select_sum('jumlah');
		$this->db->from($this->db->database.'.d_soutput d');
		$this->db->join($this->db->database.'.d_item i','i.thang=d.thang AND i.kdjendok=d.kdjendok AND i.kdsatker=d.kdsatker AND i.kddept=d.kddept AND i.kdunit=d.kdunit AND i.kdprogram=d.kdprogram AND i.kdgiat=d.kdgiat AND i.kdoutput=d.kdoutput AND i.kdlokasi=d.kdlokasi AND i.kdkabkota=d.kdkabkota AND i.kdsoutput=d.kdsoutput');
		$this->db->join($this->db->database.'.t_akun t','i.kdakun = t.kdakun');
		$this->db->where('d.thang',$thang);
		$this->db->where('d.kdjendok',$kdjendok);
		$this->db->where('d.kdsatker',$kdsatker);
		$this->db->where('d.kddept',$kddept);
		$this->db->where('d.kdunit',$kdunit);
		$this->db->where('d.kdprogram',$kdprogram);
		$this->db->where('d.kdgiat',$kdgiat);
		$this->db->where('d.kdoutput',$kdoutput);
		$this->db->where('d.kdlokasi',$kdlokasi);
		$this->db->where('d.kdkabkota',$kdkabkota);
		$this->db->where('d.kddekon',$kddekon);
		$this->db->where('d.kdsoutput',$kdsoutput);
		return $this->db->get();
	}

	//jumlah rincian biaya per item
	function get_sum_per_item($thang,$kdjendok,$kdsatker,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdlokasi,$kdkabkota,$kddekon,$kdsoutput,$kdkmpnen,$kdskmpnen,$noitem)
	{
		$this->db->select('jumlah');
		$this->db->from($this->db->database.'.d_item');
		$this->db->join($this->db->database.'.t_akun',$this->db->database.'.d_item.kdakun = '.$this->db->database.'.t_akun.kdakun');
		$this->db->where('thang',$thang);
		$this->db->where('kdjendok',$kdjendok);
		$this->db->where('kdsatker',$kdsatker);
		$this->db->where('kddept',$kddept);
		$this->db->where('kdunit',$kdunit);
		$this->db->where('kdprogram',$kdprogram);
		$this->db->where('kdgiat',$kdgiat);
		$this->db->where('kdoutput',$kdoutput);
		$this->db->where('kdlokasi',$kdlokasi);
		$this->db->where('kdkabkota',$kdkabkota);
		$this->db->where('kddekon',$kddekon);
		$this->db->where('kdsoutput',$kdsoutput);
		$this->db->where('kdkmpnen',$kdkmpnen);
		$this->db->like('kdskmpnen',$kdskmpnen, 'before');
		$this->db->where('noitem',$noitem);
		return $this->db->get()->row()->jumlah;
	}

	function get_jumlah_swakelola($thang,$kdjendok,$kdsatker,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdlokasi,$kdkabkota,$kddekon,$kdsoutput,$kdkmpnen,$kdskmpnen,$idpaket)
	{
		$this->db->select_sum('jumlahs');
		$this->db->from($this->db->database.'.d_item d');
		//serper
		//$this->db->join($this->db->database.'.paket p','p.thang=d.thang AND p.kdjendok=d.kdjendok AND p.kdsatker=d.kdsatker AND p.kddept=d.kddept AND p.kdunit=d.kdunit AND p.kdprogram=d.kdprogram AND p.kdgiat=d.kdgiat AND p.kdoutput=d.kdoutput AND p.kdlokasi=d.kdlokasi AND p.kdkabkota=d.kdkabkota AND p.kddekon=d.kddekon AND p.kdsoutput=d.kdsoutput');
		//local
		$this->db->join($this->db->database.'.paket p','p.thang=d.thang AND p.kdjendok=d.kdjendok AND p.kdsatker=d.kdsatker AND p.kddept=d.kddept AND p.kdunit=d.kdunit AND p.kdprogram=d.kdprogram AND p.kdgiat=d.kdgiat AND p.kdoutput=d.kdoutput AND p.kdlokasi=d.kdlokasi AND p.kdkabkota=d.kdkabkota AND p.kddekon=d.kddekon AND p.kdsoutput=d.kdsoutput AND p.kdskmpnen=d.kdskmpnen');
		$this->db->join($this->db->database.'.dm_jns_item dm', 'dm.idpaket = p.idpaket AND dm.kdakun=d.kdakun AND dm.noitem=d.noitem');
		$this->db->where('d.thang',$thang);
		$this->db->where('d.kdjendok',$kdjendok);
		$this->db->where('d.kdsatker',$kdsatker);
		$this->db->where('d.kddept',$kddept);
		$this->db->where('d.kdunit',$kdunit);
		$this->db->where('d.kdprogram',$kdprogram);
		$this->db->where('d.kdgiat',$kdgiat);
		$this->db->where('d.kdoutput',$kdoutput);
		$this->db->where('d.kdlokasi',$kdlokasi);
		$this->db->where('d.kdkabkota',$kdkabkota);
		$this->db->where('d.kddekon',$kddekon);
		$this->db->where('d.kdsoutput',$kdsoutput);
		$this->db->where('d.kdkmpnen',$kdkmpnen);
		$this->db->like('d.kdskmpnen',$kdskmpnen, 'before');
		$this->db->where('p.idpaket',$idpaket);
		$this->db->where('dm.kdjnsitem',1);

		return $this->db->get()->row()->jumlah;
	}
	
	function get_progres_by_bulan($d_skmpnen_id, $bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',$bulan);
		return $monev->get();
	}

	function get_progres_evaluasi($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_spm_by_bulan($d_skmpnen_id, $bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
	
	function is_exist_renc_fisik_more_than_100_bef($d_skmpnen_id,$rencana_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('rencana_id <',$rencana_id);
		$monev->where('fisik',100);
		if($monev->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function is_exist_renc_keuangan_more_than_100_bef($d_skmpnen_id,$rencana_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('rencana_id <',$rencana_id);
		$monev->where('keuangan',100);
		if($monev->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function is_exist_progres_keuangan_more_than_100_bef($d_skmpnen_id,$spm_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('spm_id <',$spm_id);
		$monev->where('keuangan',100);
		if($monev->get()->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_progres_after_this_progres_id($d_skmpnen_id,$progres_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('progres_id >=',$progres_id);
		return $monev->get()->result();
	}
	
	function get_spm_after_this_spm_id($d_skmpnen_id,$spm_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('spm_id >=',$spm_id);
		return $monev->get()->result();
	}
	
	function get_progress_tahun($d_skmpnen_id,$bulan,$tahun)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$tahun);
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
	
	function get_progress_keu_tahun($d_skmpnen_id,$bulan,$tahun)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.spm');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$tahun);
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
	
	function get_rencana_tahun($d_skmpnen_id,$bulan,$tahun)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$tahun);
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
	
	function get_satker_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.d_skmpnen');
		$monev->join($this->db->database.'.t_satker t', 't.kdsatker = d_skmpnen.kdsatker');
		$monev->where('d_skmpnen.d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_program_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.d_skmpnen d');
		$monev->join($this->db->database.'.t_program program', 'program.kddept = d.kddept AND program.kdunit = d.kdunit AND program.kdprogram = d.kdprogram');
		$monev->where('d.d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_kegiatan_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.d_skmpnen d');
		$monev->join($this->db->database.'.t_giat giat', 'giat.kddept = d.kddept AND giat.kdunit = d.kdunit AND giat.kdprogram = d.kdprogram AND giat.kdgiat = d.kdgiat');
		$monev->where('d.d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_output_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.d_skmpnen d');
		$monev->join($this->db->database.'.t_output output', 'output.kdgiat = d.kdgiat AND output.kdoutput = d.kdoutput');
		$monev->where('d.d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_sub_output_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.d_skmpnen d');
		$monev->join($this->db->database.'.d_soutput', $this->db->database.'.d_soutput.thang = d.thang AND '.$this->db->database.'.d_soutput.kdsatker = d.kdsatker AND '.$this->db->database.'.d_soutput.kddept = d.kddept AND '.$this->db->database.'.d_soutput.kdunit = d.kdunit AND '.$this->db->database.'.d_soutput.kdprogram = d.kdprogram AND '.$this->db->database.'.d_soutput.kdgiat = d.kdgiat AND '.$this->db->database.'.d_soutput.kdoutput = d.kdoutput AND '.$this->db->database.'.d_soutput.kdlokasi = d.kdlokasi AND '.$this->db->database.'.d_soutput.kdkabkota = d.kdkabkota AND '.$this->db->database.'.d_soutput.kdjendok = d.kdjendok  AND '.$this->db->database.'.d_soutput.kddekon = d.kddekon');
		$monev->where('d.d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function get_komponen_by_d_skmpnen_id($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.d_skmpnen d');
		$monev->join($this->db->database.'.d_kmpnen', $this->db->database.'.d_kmpnen.thang = d.thang AND '.$this->db->database.'.d_kmpnen.kdsatker = d.kdsatker AND '.$this->db->database.'.d_kmpnen.kddept = d.kddept AND '.$this->db->database.'.d_kmpnen.kdunit = d.kdunit AND '.$this->db->database.'.d_kmpnen.kdprogram = d.kdprogram AND '.$this->db->database.'.d_kmpnen.kdgiat = d.kdgiat AND '.$this->db->database.'.d_kmpnen.kdoutput = d.kdoutput AND '.$this->db->database.'.d_kmpnen.kdlokasi = d.kdlokasi AND '.$this->db->database.'.d_kmpnen.kdkabkota = d.kdkabkota AND '.$this->db->database.'.d_kmpnen.kdsoutput = d.kdsoutput AND '.$this->db->database.'.d_kmpnen.kdkmpnen = d.kdkmpnen AND '.$this->db->database.'.d_kmpnen.kdjendok = d.kdjendok  AND '.$this->db->database.'.d_kmpnen.kddekon = d.kddekon');
		$monev->where('d.d_skmpnen_id',$d_skmpnen_id);
		return $monev->get();
	}
	
	function hapus_prakontrak($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->delete('monev.detail_prakontrak', array('d_skmpnen_id' => $id));
	}
	
	function hapus_kontrak($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->delete('monev.kontrak', array('d_skmpnen_id' => $id));
	}
	
	function hapus_bobot($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->delete('monev.bobot', array('d_skmpnen_id' => $id));
	}
	
	function hapus($tabel,$kolom,$id)
	{
		$this->db->delete($tabel, array($kolom => $id));
	}
	
	function update_rencana_by_d_skmpnen($d_skmpnen_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$monev->update('monev.rencana', $data);
	}
	
	function update_progres_by_d_skmpnen($d_skmpnen_id, $data)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->where('d_skmpnen_id', $d_skmpnen_id);
		$monev->update('monev.progres', $data);
	}
	
	function get_bobot_by_d_skmpnen($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.bobot');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
	}
	
	function get_rencana_terisi($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('fisik >', 0);
		return $monev->get();
	}
	
	function get_rencana_keu_terisi($d_skmpnen_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.rencana');
		$monev->where('d_skmpnen_id',$d_skmpnen_id);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('keuangan >', 0);
		return $monev->get();
	}
	
	function get_sp2d_per_bulan($d_skmpnen_id,$bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select_sum('data_sp2d.nominal');
		$monev->from('data_sp2d');
		$monev->join('sp2d', 'sp2d.sp2d_id = data_sp2d.sp2d_id');
		$monev->join('spm', 'spm.spm_id = sp2d.spm_id');
		$monev->where('spm.d_skmpnen_id',$d_skmpnen_id);
		$monev->where('spm.tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('spm.bulan',$bulan);
		return $monev->get();
	}
	
	function get_spm_by_id($id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.sp2d s');
		$monev->join($this->db->database.'.t_akun t', 't.kdakun = s.kdakun');
		$monev->where('s.spm_id',$id);
		return $monev->get();
	}
	
	function get_spm($sp2d_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('d.*,m.d_skmpnen_id,m.bulan');
		$monev->from('monev.sp2d d');
		$monev->join('monev.spm m', 'm.spm_id = d.spm_id');
		$monev->where('d.sp2d_id',$sp2d_id);
		return $monev->get();
	}
	
	function get_spm_before($sp2d_id,$spm_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.sp2d d');
		$monev->where('d.sp2d_id',$sp2d_id-1);
		$monev->where('d.spm_id',$spm_id);
		return $monev->get();
	}
	
	function get_sp2d_by_id($sp2d_id)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.data_sp2d s');
		$monev->where('s.sp2d_id',$sp2d_id);
		return $monev->get();
	}
	
	function get_alokasi_akun($thang,$kdjendok,$kdsatker,$kddept,$kdunit,$kdprogram,$kdgiat,$kdoutput,$kdlokasi,$kdkabkota,$kddekon,$kdsoutput,$kdkmpnen,$kdskmpnen,$kdakun)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select_sum('jumlah');
		$monev->from($this->db->database.'.d_item');
		$monev->join($this->db->database.'.t_akun',$this->db->database.'.d_item.kdakun = '.$this->db->database.'.t_akun.kdakun');
		$monev->where('thang',$thang);
		$monev->where('kdjendok',$kdjendok);
		$monev->where('kdsatker',$kdsatker);
		$monev->where('kddept',$kddept);
		$monev->where('kdunit',$kdunit);
		$monev->where('kdprogram',$kdprogram);
		$monev->where('kdgiat',$kdgiat);
		$monev->where('kdoutput',$kdoutput);
		$monev->where('kdlokasi',$kdlokasi);
		$monev->where('kdkabkota',$kdkabkota);
		$monev->where('kddekon',$kddekon);
		$monev->where('kdsoutput',$kdsoutput);
		$monev->where('kdkmpnen',$kdkmpnen);
		$monev->where('kdskmpnen',$kdskmpnen);
		$monev->where($this->db->database.'.d_item.kdakun',$kdakun);
		return $monev->get();
	}
	
	function get_sub_komponen_cetak($kd_satker){
		$monev = $this->load->database('monev',TRUE);
		$monev->select('*');
		$monev->from('d_skmpnen d');
		$monev->join($this->db->database.'.d_kmpnen', $this->db->database.'.d_kmpnen.thang = d.thang AND '.$this->db->database.'.d_kmpnen.kdsatker = d.kdsatker AND '.$this->db->database.'.d_kmpnen.kddept = d.kddept AND '.$this->db->database.'.d_kmpnen.kdunit = d.kdunit AND '.$this->db->database.'.d_kmpnen.kdprogram = d.kdprogram AND '.$this->db->database.'.d_kmpnen.kdgiat = d.kdgiat AND '.$this->db->database.'.d_kmpnen.kdoutput = d.kdoutput AND '.$this->db->database.'.d_kmpnen.kdlokasi = d.kdlokasi AND '.$this->db->database.'.d_kmpnen.kdkabkota = d.kdkabkota AND '.$this->db->database.'.d_kmpnen.kdsoutput = d.kdsoutput AND '.$this->db->database.'.d_kmpnen.kdkmpnen = d.kdkmpnen AND '.$this->db->database.'.d_kmpnen.kdjendok = d.kdjendok  AND '.$this->db->database.'.d_kmpnen.kddekon = d.kddekon', 'left');
		$monev->join($this->db->database.'.t_satker', $this->db->database.'.t_satker.kdsatker = d.kdsatker');
		$monev->where('d.thang',$this->session->userdata('thn_anggaran'));
		$monev->where('d.kdsatker',$kd_satker);
		$monev->order_by('d.d_skmpnen_id');
		return $monev->get();
	}
	
	function get_pilih_satker(){
		$this->db->distinct('d.kdsatker,'.$this->db->database.'.t_satker.*');
		$this->db->from('d_skmpnen d');
		$this->db->join($this->db->database.'.t_satker', $this->db->database.'.t_satker.kdsatker = d.kdsatker');
		$this->db->where('d.thang',$this->session->userdata('thn_anggaran'));
		return $this->db->get();
	}
	
	function get_nmsatker($kdsatker){
		$this->db->select('nmsatker');
		$this->db->from('t_satker');
		$this->db->where('kdsatker',$kdsatker);
		return $this->db->get()->row();
	}
}	
	

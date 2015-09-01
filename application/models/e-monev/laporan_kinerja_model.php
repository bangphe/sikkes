<?php

class Laporan_kinerja_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->CI = get_instance();
        $this->load->database();
		$this->load->model('role_model');
		$this->load->library('Subquery');
    }

	function get_satker()
	{
		$kdsatker = $this->session->userdata('kdsatker');
		$this->db->select('nmsatker');
		$this->db->from('ref_satker');
		$this->db->where('kdsatker', $kdsatker);	
		
		return $this->db->get();
	}

    function get_dataIkk_grid($prioritas) {
		$this->db->distinct();
		$this->db->select('prioritas_ikk.*, ref_ikk.Ikk');
		$this->db->from($this->db->database.'.d_ikk_fokus d');
		$this->db->join($this->db->database.'.prioritas_ikk', $this->db->database.'.prioritas_ikk.KodeIkk = d.ikk');
        $this->db->join($this->db->database.'.ref_ikk', $this->db->database.'.ref_ikk.KodeIkk = d.ikk');
        $this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.prioritas_ikk.idThnAnggaran');
        $this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', $this->session->userdata('thn_anggaran'));
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
        if ($prioritas != NULL && $prioritas != -2){
            if ($prioritas == -1)
            $this->db->where($this->db->database.'.prioritas_ikk.KodeJenisPrioritas !=', 0);
            else
            $this->db->where($this->db->database.'.prioritas_ikk.KodeJenisPrioritas', $prioritas);
        }
        $this->CI->flexigrid->build_query();
        $return['records'] = $this->db->get();

		$this->db->distinct();
		$this->db->select('prioritas_ikk.*, ref_ikk.Ikk');
		$this->db->from($this->db->database.'.d_ikk_fokus d');
		$this->db->join($this->db->database.'.prioritas_ikk', $this->db->database.'.prioritas_ikk.KodeIkk = d.ikk');
        $this->db->join($this->db->database.'.ref_ikk', $this->db->database.'.ref_ikk.KodeIkk = d.ikk');
        $this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.prioritas_ikk.idThnAnggaran');
        $this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', $this->session->userdata('thn_anggaran'));
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
        if ($prioritas != NULL && $prioritas != -2){
            if ($prioritas == -1)
            $this->db->where($this->db->database.'.prioritas_ikk.KodeJenisPrioritas !=', 0);
            else
            $this->db->where($this->db->database.'.prioritas_ikk.KodeJenisPrioritas', $prioritas);
        }
		$result = $this->db->get();
        $return['record_count'] = $result->num_rows();
        return $return;
    }

    //capaian nasional tahun lalu
    function get_previous_existing_nasional($kode){
        $thn = $this->session->userdata('thn_anggaran');
        
        $this->db->select('ExistingNasional');
        $this->db->from($this->db->database.'.target_ikk');
        $this->db->where('KodeIkk', $kode);
        $this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.target_ikk.idThnAnggaran');
        $this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', ($thn-1));

        $result = $this->db->get();
        return $result->num_rows > 0 ? $result->row()->ExistingNasional : 0;
    }
    
    //capaian satker tahun lalu
    function get_previous_existing_satker($kode){
        $thn = $this->session->userdata('thn_anggaran');

		$this->db->select_max('bulan_12');
		$this->db->from($this->db->database.'.realisasi_satker_ikk r');
		$this->db->join('monev.d_skmpnen d', 'd.ikk=r.KodeIkk');
        $this->db->where('r.KodeIkk', $kode);
		$this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.r.idThnAnggaran');
        $this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', ($thn-1));

		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('r.KodeIkk');

		$result = $this->db->get();

		if($result->num_rows() > 0)
		{
			if($result->row()->bulan_12 == null) {
				$exist_satker = 0;
			}
			else {
				$exist_satker = $result->row()->bulan_12;
			}
		}
		else
		{
			$exist_satker = 0;
		}

        return $exist_satker;
    }
    
    //target satker tahun berjalan
    function get_target_satker($kode){
        $thn = $this->session->userdata('thn_anggaran');
      
       $this->db->select_max('bulan_12');
		$this->db->from($this->db->database.'.rencana_satker_ikk i');
		$this->db->join($this->db->database.'.d_ikk_fokus d', 'd.ikk=i.KodeIkk');
		$this->db->where($this->db->database.'.i.KodeIkk', $kode);
		$this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.i.idThnAnggaran');
		$this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', $thn);
       	if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}

		$result = $this->db->get();

		if($result->num_rows() > 0)
		{
			if($result->row()->bulan_12 == null) {
				$total_target = 0;
			}
			else {
				$total_target = $result->row()->bulan_12;
			}		
		}
		else
		{
			$total_target = 0;
		}

		return $total_target;
			
    }
    
    //target nasional tahun berjalan
    function get_target_nasional($kode){
        $thn = $this->session->userdata('thn_anggaran');
        
        $this->db->select('TargetNasional');
        $this->db->from($this->db->database.'.target_ikk');
        $this->db->where('KodeIkk', $kode);
        $this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.target_ikk.idThnAnggaran');
        $this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', $thn);

        $result = $this->db->get();
        return $result->num_rows() > 0 ? $result->row()->TargetNasional : 0;
    }

    //ambil data alokasi dipa dari d_item_spm
    function get_alokasi_dipa($ikk)
    {        
        $this->db->select_sum('jumlah');
        $this->db->from($this->db->database.'.d_ikk_fokus f');
        $this->db->join($this->db->database.'.d_item_spm d', 'f.thang=d.thang AND f.kdjendok=d.kdjendok AND f.kdsatker=d.kdsatker AND f.kdunit=d.kdunit AND f.kdprogram=d.kdprogram AND f.kdgiat=d.kdgiat AND f.kdoutput=d.kdoutput AND f.kddekon=d.kddekon AND f.kdsoutput=d.kdsoutput AND f.kdkmpnen=d.kdkmpnen AND f.kdskmpnen=d.kdskmpnen');
        $this->db->where('f.ikk', $ikk);

        $result = $this->db->get();
        return $result->num_rows() > 0 ? $result->row()->jumlah : 0;
    }
    
    //ambil alokasi swakelola & nilai kontrak
    function get_alokasi_swakelola_dan_kontrak($ikk)
    {
		$this->db->select_sum('dm.nilaikontrak', 'nilai_kontrak');
        $this->db->from($this->db->database.'.d_ikk_fokus f');
        $this->db->join($this->db->database.'.d_item_spm d', 'f.thang=d.thang AND f.kdjendok=d.kdjendok AND f.kdsatker=d.kdsatker AND f.kdunit=d.kdunit AND f.kdprogram=d.kdprogram AND f.kdgiat=d.kdgiat AND f.kdoutput=d.kdoutput AND f.kddekon=d.kddekon AND f.kdsoutput=d.kdsoutput AND f.kdkmpnen=d.kdkmpnen AND f.kdskmpnen=d.kdskmpnen');
        $this->db->join($this->db->database.'.paket p', 'p.thang=d.thang AND p.kdjendok=d.kdjendok AND p.kdsatker=d.kdsatker AND p.kdunit=d.kdunit AND p.kdprogram=d.kdprogram AND p.kdgiat=d.kdgiat AND p.kdoutput=d.kdoutput AND p.kddekon=d.kddekon AND p.kdsoutput=d.kdsoutput AND p.kdkmpnen=d.kdkmpnen AND p.kdskmpnen=d.kdskmpnen');
        $this->db->join($this->db->database.'.dm_jns_item dm', 'dm.idpaket=p.idpaket');
        $this->db->where('f.ikk', $ikk);

        $result = $this->db->get();
        return $result->num_rows() > 0 ? $result->row()->nilai_kontrak : 0;
    }

    function get_dataIkk($prioritas) {
        //$this->db->select('prioritas_ikk.*, ref_ikk.Ikk');
		$this->db->distinct();
		$this->db->select('prioritas_ikk.*, ref_ikk.Ikk');
		$this->db->from('monev.d_skmpnen d');
		$this->db->join($this->db->database.'.prioritas_ikk', $this->db->database.'.prioritas_ikk.KodeIkk = d.ikk');
        $this->db->join($this->db->database.'.ref_ikk', $this->db->database.'.ref_ikk.KodeIkk = d.ikk');
        $this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.prioritas_ikk.idThnAnggaran');
        $this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', $this->session->userdata('thn_anggaran'));
        if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
        if ($prioritas != NULL && $prioritas != -2){
            if ($prioritas == -1)
            $this->db->where($this->db->database.'.prioritas_ikk.KodeJenisPrioritas !=', 0);
            else
            $this->db->where($this->db->database.'.prioritas_ikk.KodeJenisPrioritas', $prioritas);
        }
        
        return $this->db->get();
    }
	
	//indikator grid
	function get_indikator_grid($kode, $id_thn)
	{
		$this->db->select('i.bulan_1 b1, i.bulan_2 b2, i.bulan_3 b3, i.bulan_4 b4, i.bulan_5 b5, i.bulan_6 b6, i.bulan_7 b7, i.bulan_8 b8, i.bulan_9 b9, i.bulan_10 b10, i.bulan_11 b11, i.bulan_12 b12, i.kdSatker, k.*');
        $this->db->from($this->db->database.'.rencana_satker_ikk i');
		$this->db->join($this->db->database.'.realisasi_satker_ikk k', 'k.KodeIkk=i.KodeIkk AND k.idThnAnggaran=i.idThnAnggaran AND k.kdSatker=i.kdSatker');
        $this->db->where('i.KodeIkk', $kode);
        $this->db->where('i.idThnAnggaran', $id_thn);
		$this->db->group_by('i.KodeIkk');
		$this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();
		
		$this->db->select('i.bulan_1 b1, i.bulan_2 b2, i.bulan_3 b3, i.bulan_4 b4, i.bulan_5 b5, i.bulan_6 b6, i.bulan_7 b7, i.bulan_8 b8, i.bulan_9 b9, i.bulan_10 b10, i.bulan_11 b11, i.bulan_12 b12, k.*');
        $this->db->from($this->db->database.'.rencana_satker_ikk i');
		$this->db->join($this->db->database.'.realisasi_satker_ikk k', 'k.KodeIkk=i.KodeIkk AND k.idThnAnggaran=i.idThnAnggaran AND k.kdSatker=i.kdSatker');
        $this->db->where('i.KodeIkk', $kode);
        $this->db->where('i.idThnAnggaran', $id_thn);
		$this->db->group_by('i.kodeIkk');
		$this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
	}
    
	function get_komponen_grid2($kode){
		$thn = $this->session->userdata('thn_anggaran');
      
	  	//$this->db->distinct();
        $this->db->select('d.*, r.nmsatker');
		//$this->db->select_sum('totaljumlah');
        $this->db->from('monev.d_skmpnen d');        
        $this->db->join('monev.paket p', 'p.d_skmpnen_id=d.d_skmpnen_id');  
		$this->db->join($this->db->database.'.ref_satker r', 'r.kdsatker=d.kdsatker');
        $this->db->where('d.thang', $thn);
        $this->db->where('d.ikk', $kode);
        if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		//$this->db->group_by('d.d_skmpnen_id');
        //$this->db->group_by(array("f.kdkmpnen", "f.kdskmpnen")); 
        //$this->db->group_by('f.kdskmpnen, f.kdkmpnen, f.kdgiat, f.thang, f.kdprogram, f.kdsatker, f.kdoutput, f.kdsoutput');
		$this->CI->flexigrid->build_query();
        $query['records'] = $this->db->get();
        
		//$this->db->distinct();
       $this->db->select('d.*, r.nmsatker');
		//$this->db->select_sum('totaljumlah');
        $this->db->from('monev.d_skmpnen d');        
        $this->db->join('monev.paket p', 'p.d_skmpnen_id=d.d_skmpnen_id');  
		$this->db->join($this->db->database.'.ref_satker r', 'r.kdsatker=d.kdsatker');
        $this->db->where('d.thang', $thn);
        $this->db->where('d.ikk', $kode);
        if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		//$this->db->group_by('d.d_skmpnen_id');
       	
        $this->CI->flexigrid->build_query(FALSE);
        $query['record_count'] = $this->db->count_all_results();
        return $query;
	}
	
	function get_totaljumlah($kode)
	{
		$thn = $this->session->userdata('thn_anggaran');
      	$monev = $this->load->database('monev',TRUE);
		
	  	//$this->db->distinct();
        $monev->select_sum('totaljumlah');
		//$this->db->select_sum('totaljumlah');
        $monev->from('d_skmpnen d');        
        $monev->join('paket p', 'p.d_skmpnen_id=d.d_skmpnen_id');  
		$monev->join($this->db->database.'.ref_satker r', 'r.kdsatker=d.kdsatker');
        $monev->where('d.thang', $thn);
        $monev->where('d.ikk', $kode);
        if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$monev->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$monev->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$monev->where('d.kdunit',$this->session->userdata('kdunit'));
		}	
		return $monev->get();
	}
	
	function get_totaljumlah2($kode)
	{
		$thn = $this->session->userdata('thn_anggaran');
       	$monev = $this->load->database('monev',TRUE);
		
        $monev->select('totaljumlah');
        $monev->from('d_skmpnen d');        
        $monev->join('paket p', 'p.d_skmpnen_id=d.d_skmpnen_id');  
        $monev->where('d.thang', $thn);
        $monev->where('d.ikk', $kode);
        if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$monev->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$monev->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$monev->where('d.kdunit',$this->session->userdata('kdunit'));
		}	
		return $monev->get();
	}
	
	//alokasi swakelola / nilai kontrak (komponen grid)
	function get_paket_keu($kode){
        $thn = $this->session->userdata('thn_anggaran');
        $kdsatker = $this->session->userdata('kdsatker');
		$monev = $this->load->database('monev',TRUE);
		
		$monev->select('p.paket_pengerjaan, d.totaljumlah, k.nilai_kontrak');
		$monev->from('d_skmpnen d');
		$monev->join('paket p', 'p.d_skmpnen_id=d.d_skmpnen_id');
		$monev->join('monev.kontrak k', 'k.d_skmpnen_id=d.d_skmpnen_id', 'left');
		$monev->where('d.thang', $thn);
        $monev->where('d.d_skmpnen_id', $kode);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$monev->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$monev->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$monev->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$monev->group_by('d.d_skmpnen_id');
        return $monev->get();
    }
	
	function get_pakett($kode){
        $thn = $this->session->userdata('thn_anggaran');
        $kdsatker = $this->session->userdata('kdsatker');
		$monev = $this->load->database('monev',TRUE);
		
		$monev->select('p.paket_pengerjaan, d.totaljumlah, k.nilai_kontrak');
		$monev->from('d_skmpnen d');
		$monev->join('paket p', 'p.d_skmpnen_id=d.d_skmpnen_id');
		$monev->join('monev.kontrak k', 'k.d_skmpnen_id=d.d_skmpnen_id', 'left');
		$monev->where('d.thang', $thn);
        $monev->where('d.ikk', $kode);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$monev->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$monev->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$monev->where('d.kdunit',$this->session->userdata('kdunit'));
		}
        return $monev->get();
    }
	
	function get_kontrak_keu($kode)
	{
		$thn = $this->session->userdata('thn_anggaran');
        $kdsatker = $this->session->userdata('kdsatker');
		
		$this->db->select('k.nilai_kontrak');
		$this->db->from('monev.d_skmpnen d');
		$this->db->join('monev.kontrak k', 'k.d_skmpnen_id=d.d_skmpnen_id');
		$this->db->where('d.thang', $thn);
        $this->db->where('d.ikk', $kode);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('d.ikk');
        return $this->db->get();
	}
	
    function get_komponen_grid($kode){
        $thn = $this->session->userdata('thn_anggaran');
        
        $this->db->select('s.*');
		$this->db->select_sum('jumlsah');
        $this->db->from('d_item i');        
        $this->db->join('d_ikk_fokus f', 'f.thang=i.thang and f.kdjendok=i.kdjendok and f.kdsatker=i.kdsatker and f.kdprogram=i.kdprogram and f.kdgiat=i.kdgiat and f.kdoutput=i.kdoutput and f.kdsoutput=i.kdsoutput and f.kdkmpnen=i.kdkmpnen');
        $this->db->join('monev.d_skmpnen s', 's.thang=i.thang and s.kdjendok=i.kdjendok and s.kdsatker=i.kdsatker and s.kdprogram=i.kdprogram and s.kdgiat=i.kdgiat and s.kdoutput=i.kdoutput and s.kdsoutput=i.kdsoutput and s.kdkmpnen=i.kdkmpnen');        
        $this->db->where('f.thang', $thn);
        $this->db->where('f.ikk', $kode);
        if ($this->session->userdata('kd_role') != 8) {
            $this->db->where('f.kdsatker', $this->session->userdata('kdsatker'));
        }
        //$this->db->group_by(array("f.kdkmpnen", "f.kdskmpnen")); 
        $this->db->group_by('f.kdkmpnen');
		$this->CI->flexigrid->build_query();
        $return['records'] = $this->db->get();
        
       $this->db->select('s.*');
		$this->db->select_sum('jumlah');
        $this->db->from('d_item i');        
        $this->db->join('d_ikk_fokus f', 'f.thang=i.thang and f.kdjendok=i.kdjendok and f.kdsatker=i.kdsatker and f.kdprogram=i.kdprogram and f.kdgiat=i.kdgiat and f.kdoutput=i.kdoutput and f.kdsoutput=i.kdsoutput and f.kdkmpnen=i.kdkmpnen');
        $this->db->join('monev.d_skmpnen s', 's.thang=i.thang and s.kdjendok=i.kdjendok and s.kdsatker=i.kdsatker and s.kdprogram=i.kdprogram and s.kdgiat=i.kdgiat and s.kdoutput=i.kdoutput and s.kdsoutput=i.kdsoutput and s.kdkmpnen=i.kdkmpnen');        
        $this->db->where('f.thang', $thn);
        $this->db->where('f.ikk', $kode);
        if ($this->session->userdata('kd_role') != 8) {
            $this->db->where('f.kdsatker', $this->session->userdata('kdsatker'));
        }
        //$this->db->group_by(array("f.kdkmpnen", "f.kdskmpnen")); 
        $this->db->group_by('f.kdkmpnen'); 
        $this->CI->flexigrid->build_query(FALSE);
        $return['record_count'] = $this->db->count_all_results();
        return $return;
    }

    function save_rencana_ikk($data) {
        $this->db->insert($this->db->database.'.rencana_satker_ikk', $data);
    }
    
    function save_realisasi_ikk($data) {
        $this->db->insert($this->db->database.'.realisasi_satker_ikk', $data);
    }

    function get_prioritas() {
        $this->db->select();
        $this->db->from($this->db->database.'.ref_jenis_prioritas');
        return $this->db->get()->result();
    }
    
    function get_ikk($kode) {
        $this->db->select();
        $this->db->from($this->db->database.'.ref_ikk');
        $this->db->where('KodeIkk', $kode);
        return $this->db->get()->result();
    }
    
    function get_rencana_ikk($kode, $id_thn){
        $this->db->select();
        $this->db->from($this->db->database.'.rencana_satker_ikk');
        $this->db->where('KodeIkk', $kode);
        $this->db->where('idThnAnggaran', $id_thn);
        /*
		if ($this->session->userdata('kd_role') != 8) {
            $this->db->join('d_ikk_fokus', 'd_ikk_fokus.Ikk = rencana_satker_ikk.KodeIkk');
            $this->db->where('d_ikk_fokus.kdsatker', $this->session->userdata('kdsatker'));
        }
		*/
		$this->db->where($this->db->database.'.rencana_satker_ikk.kdSatker', $this->session->userdata('kdsatker'));
        return $this->db->get()->result();
    }
    
    function get_realisasi_ikk($kode, $id_thn){
        $this->db->select();
        $this->db->from($this->db->database.'.realisasi_satker_ikk');
        $this->db->where('KodeIkk', $kode);
        $this->db->where('idThnAnggaran', $id_thn);
        /*
		if ($this->session->userdata('kd_role') != 8) {
            $this->db->join('d_ikk_fokus', 'd_ikk_fokus.Ikk = realisasi_satker_ikk.KodeIkk');
            $this->db->where('d_ikk_fokus.kdsatker', $this->session->userdata('kdsatker'));
        }
		*/
		$this->db->where($this->db->database.'.realisasi_satker_ikk.kdSatker', $this->session->userdata('kdsatker'));
        return $this->db->get()->result();
    }
    
	function update_rencana_ikk($kode, $id_thn, $data){
        $this->db->where('KodeIkk', $kode);
        $this->db->where('idThnAnggaran', $id_thn);
        /*
		if ($this->session->userdata('kd_role') != 8) {
            $this->db->join('d_ikk_fokus', 'd_ikk_fokus.Ikk = rencana_satker_ikk.KodeIkk');
            $this->db->where('d_ikk_fokus.kdsatker', $this->session->userdata('kdsatker'));
        }
		*/
		$this->db->where($this->db->database.'.rencana_satker_ikk.kdSatker', $this->session->userdata('kdsatker'));
        $this->db->update($this->db->database.'.rencana_satker_ikk', $data); 
    }
	
    function delete_rencana_ikk($kode, $id_thn){
        $this->db->where('KodeIkk', $kode);
        $this->db->where('idThnAnggaran', $id_thn);
        /*
		if ($this->session->userdata('kd_role') != 8) {
            $this->db->join('d_ikk_fokus', 'd_ikk_fokus.Ikk = rencana_satker_ikk.KodeIkk');
            $this->db->where('d_ikk_fokus.kdsatker', $this->session->userdata('kdsatker'));
        }
		*/
		$this->db->where($this->db->database.'.rencana_satker_ikk.kdSatker', $this->session->userdata('kdsatker'));
        $this->db->delete($this->db->database.'.rencana_satker_ikk'); 
    }
    
    function delete_realisasi_ikk($kode, $id_thn){
        $this->db->where('KodeIkk', $kode);
        $this->db->where('idThnAnggaran', $id_thn);
        /*
		if ($this->session->userdata('kd_role') != 8) {
            $this->db->join('d_ikk_fokus', 'd_ikk_fokus.Ikk = realisasi_satker_ikk.KodeIkk');
            $this->db->where('d_ikk_fokus.kdsatker', $this->session->userdata('kdsatker'));
        }
		*/
		$this->db->where($this->db->database.'.realisasi_satker_ikk.kdSatker', $this->session->userdata('kdsatker'));
        $this->db->delete($this->db->database.'.realisasi_satker_ikk'); 
    }
    
	//alokasi
	function get_alokasi_keu($kode){
		$thn = $this->session->userdata('thn_anggaran');
        
        $this->db->select_sum('totaljumlah');
        $this->db->from('monev.d_skmpnen d');        
        $this->db->where('d.thang', $thn);
        $this->db->where('d.ikk', $kode);
        /*if ($this->session->userdata('kd_role') != 8 && $this->session->userdata('kd_role') != 12) {
            $this->db->where('i.kdsatker', $this->session->userdata('kdsatker'));
			$this->db->where('i.kdlokasi', $this->session->userdata('kodeprovinsi'));
        }*/
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
        $this->db->group_by('d.ikk');
        return $this->db->get();
	}
	
    function get_alokasi_keuangan($kode){
        $thn = $this->session->userdata('thn_anggaran');
        
        $this->db->select_sum('jumlah');
        $this->db->from('d_item i');        
        $this->db->join('d_ikk_fokus f', 'f.thang=i.thang and f.kdjendok=i.kdjendok and f.kdsatker=i.kdsatker and f.kdprogram=i.kdprogram and f.kdgiat=i.kdgiat and f.kdoutput=i.kdoutput and f.kdsoutput=i.kdsoutput and f.kdkmpnen=i.kdkmpnen and f.kdskmpnen=i.kdskmpnen');
        $this->db->where('f.thang', $thn);
        $this->db->where('f.ikk', $kode);
        if ($this->session->userdata('kd_role') != 8) {
            $this->db->where('f.kdsatker', $this->session->userdata('kdsatker'));
        }
        $this->db->group_by('f.ikk');
        return $this->db->get();
    }
	
    function get_realisasi_keuangan($kode){
        $thn = $this->session->userdata('thn_anggaran');
        
        $this->db->select_sum('spm.nominal');
        $this->db->from('d_item i');        
        $this->db->join('d_ikk_fokus f', 'f.thang=i.thang and f.kdjendok=i.kdjendok and f.kdsatker=i.kdsatker and f.kdprogram=i.kdprogram and f.kdgiat=i.kdgiat and f.kdoutput=i.kdoutput and f.kdsoutput=i.kdsoutput and f.kdkmpnen=i.kdkmpnen and f.kdskmpnen=i.kdskmpnen');
        $this->db->join('monev.d_skmpnen s', 's.thang=i.thang and s.kdjendok=i.kdjendok and s.kdsatker=i.kdsatker and s.kdprogram=i.kdprogram and s.kdgiat=i.kdgiat and s.kdoutput=i.kdoutput and s.kdsoutput=i.kdsoutput and s.kdkmpnen=i.kdkmpnen and s.kdskmpnen=i.kdskmpnen');
        $this->db->join('monev.spm spm', 'spm.d_skmpnen_id=s.d_skmpnen_id', 'left');
        $this->db->where('f.thang', $thn);
        $this->db->where('f.ikk', $kode);
        if ($this->session->userdata('kd_role') != 8) {
            $this->db->where('f.kdsatker', $this->session->userdata('kdsatker'));
        }
        $this->db->group_by('f.ikk');
        return $this->db->get();
    }
	
	//realisasi_keuangan
	function get_realisasi_keu($kode){
		$thn = $this->session->userdata('thn_anggaran');
       	$kdsatker = $this->session->userdata('kdsatker');
		
		$this->db->select_sum('a.nominal');
		$sub = $this->subquery->start_subquery('from');
		$sub->select_max('s.nominal', false);
		$sub->from('monev.d_skmpnen d');
		$sub->join('monev.spm s', 's.d_skmpnen_id=d.d_skmpnen_id');
		$sub->where('d.thang', $thn);
		$sub->where('d.ikk', $kode);
		//$sub->where('d.kdsatker', $kdsatker);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$sub->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$sub->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$sub->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$sub->group_by('s.d_skmpnen_id');
		$this->subquery->end_subquery('a');
		
		/*$this->db->select_max('nominal');
		//$this->db->select_sum('nominal');
		$this->db->from('monev.d_skmpnen d');
		$this->db->join('monev.spm s', 'd.d_skmpnen_id=s.d_skmpnen_id');
		$this->db->where('d.ikk', $kode);
		$this->db->where('d.thang', $thn);
		//$this->db->where('d.kdsatker', $kdsatker);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('d.d_skmpnen_id');*/
        return $this->db->get();
	}
	
	//keu
	function get_keu($kode){
        $thn = $this->session->userdata('thn_anggaran');
        $kdsatker = $this->session->userdata('kdsatker');
		$monev = $this->load->database('monev',TRUE);
		
		$monev->select('p.*, k.nilai_kontrak, d.totaljumlah');
		$monev->from('d_skmpnen d');
		$monev->join('paket p', 'p.d_skmpnen_id=d.d_skmpnen_id');
		$monev->join('kontrak k', 'k.d_skmpnen_id=d.d_skmpnen_id', 'left');
		$monev->where('d.thang', $thn);
        $monev->where('d.ikk', $kode);
		//$this->db->where('d.kdsatker', $kdsatker);
        /*$this->db->select('paket.paket_pengerjsaan');
        $this->db->select_sum('kontrak.nilai_kontrak');
        $this->db->from('monev.d_skmpnen d');        
        $this->db->join('monev.paket', 'paket.d_skmpnen_id=d.d_skmpnen_id');
        
        $this->db->where('d.thang', $thn);
        $this->db->where('d.ikk', $kode);
        if ($this->session->userdata('kd_role') != 8 && $this->session->userdata('kd_role') != 12) {
            $this->db->where('i.kdsatker', $this->session->userdata('kdsatker'));
			$this->db->where('i.kdlokasi', $this->session->userdata('kodeprovinsi'));
        }*/
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$monev->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$monev->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$monev->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$monev->group_by('d.ikk');
        return $monev->get();
    }
    
	function get_kontrak($kode)
	{
		$thn = $this->session->userdata('thn_anggaran');
        $kdsatker = $this->session->userdata('kdsatker');
		$monev = $this->load->database('monev',TRUE);
		
		$monev->select('k.nilai_kontrak');
		$monev->from('d_skmpnen d');
		$monev->join('kontrak k', 'k.d_skmpnen_id=d.d_skmpnen_id');
		$monev->where('d.thang', $thn);
        $monev->where('d.ikk', $kode);
		$monev->where('d.kdsatker', $kdsatker);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$monev->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$monev->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$monev->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$monev->group_by('d.ikk');
        return $monev->get();
	}
	
    function get_keuangan($kode){
        $thn = $this->session->userdata('thn_anggaran');
        
        $this->db->select('f.*, paket.jenis_paket');
        $this->db->select_sum('kontrak.nilai_kontrak');
        $this->db->from('d_item i');        
        $this->db->join('d_ikk_fokus f', 'f.thang=i.thang and f.kdjendok=i.kdjendok and f.kdsatker=i.kdsatker and f.kdprogram=i.kdprogram and f.kdgiat=i.kdgiat and f.kdoutput=i.kdoutput and f.kdsoutput=i.kdsoutput and f.kdkmpnen=i.kdkmpnen and f.kdskmpnen=i.kdskmpnen');
        $this->db->join('monev.d_skmpnen s', 's.thang=i.thang and s.kdjendok=i.kdjendok and s.kdsatker=i.kdsatker and s.kdprogram=i.kdprogram and s.kdgiat=i.kdgiat and s.kdoutput=i.kdoutput and s.kdsoutput=i.kdsoutput and s.kdkmpnen=i.kdkmpnen and s.kdskmpnen=i.kdskmpnen');
        $this->db->join('monev.paket', 'paket.d_skmpnen_id=s.d_skmpnen_id');
        $this->db->join('monev.kontrak', 'kontrak.d_skmpnen_id=s.d_skmpnen_id', 'left');
        $this->db->where('f.thang', $thn);
        $this->db->where('f.ikk', $kode);
        if ($this->session->userdata('kd_role') != 8) {
            $this->db->where('f.kdsatker', $this->session->userdata('kdsatker'));
        }
        $this->db->group_by('f.ikk');
        return $this->db->get();
    }
	
	function get_paket_cetak($kode){
        $thn = $this->session->userdata('thn_anggaran');
        
        /*$this->db->select('s.*');
        $this->db->from('d_item i');        
        $this->db->join('d_ikk_fokus f', 'f.thang=i.thang and f.kdjendok=i.kdjendok and f.kdsatker=i.kdsatker and f.kdprogram=i.kdprogram and f.kdgiat=i.kdgiat and f.kdoutput=i.kdoutput and f.kdsoutput=i.kdsoutput and f.kdkmpnen=i.kdkmpnen and f.kdskmpnen=i.kdskmpnen');
        $this->db->join('monev.d_skmpnen s', 's.thang=i.thang and s.kdjendok=i.kdjendok and s.kdsatker=i.kdsatker and s.kdprogram=i.kdprogram and s.kdgiat=i.kdgiat and s.kdoutput=i.kdoutput and s.kdsoutput=i.kdsoutput and s.kdkmpnen=i.kdkmpnen and s.kdskmpnen=i.kdskmpnen');        
        $this->db->where('f.thang', $thn);
        $this->db->where('f.ikk', $kode);
        if ($this->session->userdata('kd_role') != 8) {
            $this->db->where('f.kdsatker', $this->session->userdata('kdsatker'));
        }
        $this->db->group_by(array("f.kdkmpnen", "f.kdskmpnen")); */
		//$this->db->distinct();
		$this->db->select('d.urskmpnen');
		$this->db->select_sum('totaljumlah');
        $this->db->from('monev.d_skmpnen d');        
        $this->db->join('monev.paket p', 'p.d_skmpnen_id=d.d_skmpnen_id');  
        $this->db->where('d.thang', $thn);
        $this->db->where('d.ikk', $kode);
        if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('d.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('d.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('d.kdunit',$this->session->userdata('kdunit'));
		}
		$this->db->group_by('d.d_skmpnen_id');
        return $this->db->get();
    }

	function get_realisasi_satkerIkk($kode)
	{
		$thn = $this->session->userdata('thn_anggaran');
        
		$this->db->select('bulan_12');
		$this->db->from($this->db->database.'.realisasi_satker_ikk');
        $this->db->where('KodeIkk', $kode);
		$this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.realisasi_satker_ikk.idThnAnggaran');
        $this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', $thn);
        //if ($this->session->userdata('kd_role') != 8 && $this->session->userdata('kd_role') != 12) {
			//$this->db->join('monev.d_skmpnen d', 'd.Ikk = realisasi_satker_ikk.KodeIkk and d.kdsatker=realisasi_satker_ikk.kdSatker');
			if($this->session->userdata('kd_role') == 5){
            	$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
				$this->db->group_by('KodeIkk');
			}
        //}
        return $this->db->get();
	}
	
	function get_rencana_satkerIkk($kode)
	{
		$thn = $this->session->userdata('thn_anggaran');
        
		$this->db->select('bulan_12');
		$this->db->from($this->db->database.'.rencana_satker_ikk');
        $this->db->where('KodeIkk', $kode);
		$this->db->join($this->db->database.'.ref_tahun_anggaran', $this->db->database.'.ref_tahun_anggaran.idThnAnggaran = '.$this->db->database.'.rencana_satker_ikk.idThnAnggaran');
        $this->db->where($this->db->database.'.ref_tahun_anggaran.thn_anggaran', $thn);
        //if ($this->session->userdata('kd_role') != 8 && $this->session->userdata('kd_role') != 12) {
			//$this->db->join('monev.d_skmpnen d', 'd.Ikk = rencana_satker_ikk.KodeIkk and d.kdsatker=rencana_satker_ikk.kdSatker');
			if($this->session->userdata('kd_role') == 5){
            	$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
				$this->db->group_by('KodeIkk');
			}
        //}
        return $this->db->get();
	}
	
	//sp2d
	function get_sp2d($kode)
	{
        $thn = $this->session->userdata('thn_anggaran');
        
        /*$this->db->select_sum('sp2d.nominal');
        $this->db->from('monev.d_skmpnen i');        
        $this->db->join('d_ikk_fokus f', 'f.thang=i.thang and f.kdjendok=i.kdjendok and f.kdsatker=i.kdsatker and f.kdprogram=i.kdprogram and f.kdgiat=i.kdgiat and f.kdoutput=i.kdoutput and f.kdsoutput=i.kdsoutput and f.kdkmpnen=i.kdkmpnen and f.kdskmpnen=i.kdskmpnen');
        $this->db->join('monev.spm spm', 'spm.d_skmpnen_id=i.d_skmpnen_id', 'left');
		$this->db->join('monev.sp2d sp2d', 'sp2d.spm_id=spm.spm_id', 'left');
		$this->db->select_max('d.nominal');
		$this->db->from('monev.d_skmpnen k');
		$this->db->join('monev.spm s', 's.d_skmpnen_id = k.d_skmpnen_id');
		$this->db->join('monev.sp2d p', 'p.spm_id = s.spm_id');
		$this->db->join('monev.data_sp2d d', 'd.sp2d_id = p.sp2d_id');
        $this->db->where('s.tahun', $thn);
        $this->db->where('k.ikk', $kode);
        if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$this->db->where('k.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$this->db->where('k.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$this->db->where('k.kdunit',$this->session->userdata('kdunit'));
		}*/
		
		$this->db->select_sum('f.nominal');
		$sub = $this->subquery->start_subquery('from');
		$sub->select('e.d_skmpnen_id');
		$sub->select_max('e.nominal');
		$sub->group_by('e.d_skmpnen_id');
		$sub = $this->subquery->start_subquery('from');
		$sub->select('a.d_skmpnen_id');
		$sub->select_sum('d.nominal');
		$sub->from('monev.d_skmpnen a');
		$sub->join('monev.spm b', 'b.d_skmpnen_id=a.d_skmpnen_id');
		$sub->join('monev.sp2d c', 'c.spm_id=b.spm_id');
		$sub->join('monev.data_sp2d d', 'd.sp2d_id = c.sp2d_id');
		$sub->where('a.thang', $thn);
		$sub->where('a.ikk', $kode);
		if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN)
		{
			$sub->where('a.kdsatker',$this->session->userdata('kdsatker'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 2)
		{
			$sub->where('a.kdlokasi',$this->session->userdata('kodeprovinsi'));
		}
		elseif($this->session->userdata('kd_role') == Role_model::VERIFIKATOR && $this->session->userdata('kodejenissatker') == 3)
		{
			$sub->where('a.kdunit',$this->session->userdata('kdunit'));
		}
		$sub->group_by('c.sp2d_id');
		$this->subquery->end_subquery('e');
		$this->subquery->end_subquery('f');
		
        return $this->db->get();
	}
	
	/*function get_sp2d($kode)
	{
        $thn = $this->session->userdata('thn_anggaran');
        
        $this->db->select_sum('sp2d.nominal');
        $this->db->from('d_item i');        
        $this->db->join('d_ikk_fokus f', 'f.thang=i.thang and f.kdjendok=i.kdjendok and f.kdsatker=i.kdsatker and f.kdprogram=i.kdprogram and f.kdgiat=i.kdgiat and f.kdoutput=i.kdoutput and f.kdsoutput=i.kdsoutput and f.kdkmpnen=i.kdkmpnen and f.kdskmpnen=i.kdskmpnen');
        $this->db->join('monev.d_skmpnen s', 's.thang=i.thang and s.kdjendok=i.kdjendok and s.kdsatker=i.kdsatker and s.kdprogram=i.kdprogram and s.kdgiat=i.kdgiat and s.kdoutput=i.kdoutput and s.kdsoutput=i.kdsoutput and s.kdkmpnen=i.kdkmpnen and s.kdskmpnen=i.kdskmpnen');
        $this->db->join('monev.spm spm', 'spm.d_skmpnen_id=s.d_skmpnen_id', 'left');
		$this->db->join('monev.sp2d sp2d', 'sp2d.spm_id=spm.spm_id', 'left');
        $this->db->where('f.thang', $thn);
        $this->db->where('f.ikk', $kode);
        if ($this->session->userdata('kd_role') != 8) {
            $this->db->where('f.kdsatker', $this->session->userdata('kdsatker'));
        }
        $this->db->group_by('f.ikk');
        return $this->db->get();
	}*/
	
	function get_progres_fisik($kode)
	{
		$thn = $this->session->userdata('thn_anggaran');
		
		$monev = $this->load->database('monev',TRUE);
		$monev->select('p.fisik');
		$monev->from('progres p');
		$monev->where('p.d_skmpnen_id',$kode);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',12);
		
		return $monev->get();
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
	
	function get_progresss($kode)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres p');
		$monev->join('monev.d_skmpnen d', 'd.d_skmpnen_id = p.d_skmpnen_id');
		$monev->where('d.ikk',$kode);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		return $monev->get();
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
	
	function get_progress4($kode,$bulan)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select('realisasi_fisik');
		$monev->from('monev.progres p');
		$monev->join('monev.d_skmpnen d', 'd.d_skmpnen_id = p.d_skmpnen_id');
		$monev->where('d.ikk',$kode);
		$monev->where('tahun',$this->session->userdata('thn_anggaran'));
		$monev->where('bulan',$bulan);
		$monev->group_by('d.ikk');
		return $monev->get();
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
	
	function get_progress_tahun1($kode,$bulan,$tahun)
	{
		$monev = $this->load->database('monev',TRUE);
		$monev->select();
		$monev->from('monev.progres p');
		$monev->join('monev.d_skmpnen d', 'd.d_skmpnen_id = p.d_skmpnen_id');
		$monev->where('d.ikk',$kode);
		$monev->where('tahun',$tahun);
		$monev->where('bulan',$bulan);
		return $monev->get();
	}
}

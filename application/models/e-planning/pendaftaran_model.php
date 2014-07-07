<?php
class Pendaftaran_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct(){
        parent::__construct();
		$this->CI = get_instance();
		$this->load->database();		
    }
	
	function getSingleUser($kd)
	{
		$this->db->select('*');
		$this->db->from('prioritas_iku');
		$this->db->where('KodeIku', $kd);
		$getAllUser = $this->db->get()->result_object();
		if (count($getAllUser) > 0 )
		{
			return $getAllUser[0];
		}
		return NULL;
	}
	
	function get_KodePengajuan(){
		$this->db->select_max('KD_PENGAJUAN','KodePengajuan');
		$this->db->from('pengajuan');
		return $this->db->get();
	}
	
	function get_max($tabel,$kolom,$alias){
		$this->db->select_max($kolom,$alias);
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function cek_Tupoksi($KD_PENGAJUAN, $KodeTupoksi){
		$this->db->select('*');
		$this->db->from('data_tupoksi');
		$this->db->where('KD_PENGAJUAN', $KD_PENGAJUAN);
		$this->db->where('KodeTupoksi', $KodeTupoksi);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function cekProp($kd){
		$this->db->select('*');
		$this->db->from('ref_provinsi');
		$this->db->where('KodeProvinsi', $kd);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function cekFokus($kd){
		$this->db->select('*');
		$this->db->from('fokus_prioritas');
		$this->db->where('idFokusPrioritas', $kd);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function cekReform($kd){
		$this->db->select('*');
		$this->db->from('reformasi_kesehatan');
		$this->db->where('idReformasiKesehatan', $kd);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function cek1($tabel, $kolom1, $param1){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $param1);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	function cek($tabel, $kolom1, $param1, $kolom2, $param2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $param1);
		$this->db->where($kolom2, $param2);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	
	function cek3($tabel, $kolom1, $param1, $kolom2, $param2, $kolom3, $param3){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom1, $param1);
		$this->db->where($kolom2, $param2);
		$this->db->where($kolom3, $param3);
		$return = $this->db->get();
		
		if($return->num_rows() > 0)	
			return true;
		else
			return false;
	}
	function hapus_tupoksi($KD_PENGAJUAN){
		$this->db->where('KD_PENGAJUAN',$KD_PENGAJUAN);
		$this->db->delete('data_tupoksi');
	}
	
	function hapus($tabel, $kolom, $parameter){
		$this->db->where($kolom,$parameter);
		$this->db->delete($tabel);
	}
	
	function get_pengajuan(){
		$start = isset($paramArr['start'])?$paramArr['start']:NULL;
		$limit = isset($paramArr['limit'])?$paramArr['start']:NULL;
		$sortField = isset($paramArr['sortField'])?$paramArr['sortField']:'JUDUL_PROPOSAL';
		$sortOrder = isset($paramArr['sortOrder'])?$paramArr['sortOrder']:'asc';
		$whereParam = isset($paramArr['whereParam'])?$paramArr['whereParam']:NULL;
		if(!empty($start) && !empty($limit)) $optLimit = "limit $start,$limit";
		else $optLimit = NULL;
		
		if(!empty($whereParam)) $whereParam = "and (".$whereParam.")";
		$whereClause = "where true ".$whereParam;
		
		$SQL = "SELECT * FROM pengajuan $whereClause order by $sortField $sortOrder $optLimit ";
		$result = $this->db->query($SQL);
		
		if($result->num_rows() > 0) {
		$custlist = $result->result();
		return $custlist;
		} else {
		return null;
		}
	}
	
	function get($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		return $this->db->get();
	}
	
	function get_where($tabel,$parameter,$kolom){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		return $this->db->get();
	}
	
	function get_where_double($tabel,$parameter,$kolom,$parameter2,$kolom2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->where($kolom2,$parameter2);
		return $this->db->get();
	}
	
	function get_where_triple($tabel,$parameter,$kolom,$parameter2,$kolom2,$parameter3,$kolom3){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($kolom,$parameter);
		$this->db->where($kolom2,$parameter2);
		$this->db->where($kolom3,$parameter3);
		return $this->db->get();
	}
	
	function get_data_pengajuan($kd_pengajuan){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$this->db->join('ref_satker','pengajuan.NO_REG_SATKER=ref_satker.kdsatker');
		$this->db->join('ref_provinsi','ref_satker.kdlokasi=ref_provinsi.KodeProvinsi');
		$this->db->where('KD_PENGAJUAN',$kd_pengajuan);
		$this->db->order_by('TANGGAL_PENGAJUAN', 'desc');
		return $this->db->get();
	}
    
	function get_data_satker($kd_satker){
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->join('ref_provinsi','ref_satker.kdlokasi=ref_provinsi.KodeProvinsi');
		$this->db->where('kdsatker',$kd_satker);
		return $this->db->get();
	}
	
    function get_provinsi(){
    	$this->db->select('*');
    	$this->db->from('ref_provinsi');
		$this->db->order_by('NamaProvinsi','asc');
    	return $this->db->get();
    }
	
	function get_satker(){
		foreach($this->get_kode_kementrian()->result() as $row){
			$KodeKementrian = $row->KodeKementrian;
		}
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->where('kddept',$KodeKementrian);
		$this->db->order_by('nmsatker','asc');
		return $this->db->get();
	}
	
	function get_kegiatan_satker($kodeprogram){
		$this->db->select('*');
		$this->db->from('ref_satker_kegiatan');
		$this->db->join('ref_kegiatan', 'ref_kegiatan.KodeKegiatan = ref_satker_kegiatan.KodeKegiatan');
		$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		//$this->db->where('KodeSubFungsi',$kodefungsi.'.'.$kodesubfungsi);
		$this->db->where('KodeProgram',$kodeprogram);
		return $this->db->get();
	}
	
	function get_kegiatan($KodeFungsi, $KodeSubFungsi, $KodeProgram){
		if($this->get_kegiatan_satker()->result() != NULL){
			foreach($this->get_kegiatan_satker()->result() as $row){
				$kodekegiatan[] = $row->KodeKegiatan;
			}
			$this->db->select('*');
			$this->db->from('ref_kegiatan');
			$this->db->where_in('KodeKegiatan',$kodekegiatan);
			$this->db->where('KodeFungsi',$KodeFungsi);
			$this->db->where('KodeSubFungsi',$KodeFungsi.".".$KodeSubFungsi);
			$this->db->where('KodeProgram',$KodeProgram);
			return $this->db->get();
		}else return NULL;
	}
	
	function get_kode_kementrian(){
		$this->db->select('*');
		$this->db->from('ref_kode_kementrian');
		return $this->db->get();
	}
	
	function get_fungsi(){
		$this->db->select('*');
		$this->db->from('ref_fungsi');
		return $this->db->get();
	}
	
	function search($keyword, $kolom, $tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->like($kolom, $keyword);		
		return $this->db->get();
	}
	
	function search_sub_fungsi($kodeFungsi, $keyword, $kolom){
		$this->db->select('*');
		$this->db->from('ref_sub_fungsi');
		$this->db->where('KodeFungsi',$kodeFungsi);
		$this->db->like($kolom, $keyword);
		return $this->db->get();
	}
	
	function search_kegiatan($KodeFungsi, $KodeSubFungsi, $KodeProgram,$keyword,$kolom){
		if($this->get_kegiatan_satker()->result() != NULL){
			foreach($this->get_kegiatan_satker()->result() as $row){
				$kodekegiatan[] = $row->KodeKegiatan;
			}
			$this->db->select('*');
			$this->db->from('ref_kegiatan');
			$this->db->where_in('KodeKegiatan',$kodekegiatan);
			$this->db->where('KodeFungsi',$KodeFungsi);
			$this->db->where('KodeSubFungsi',$KodeFungsi.".".$KodeSubFungsi);
			$this->db->where('KodeProgram',$KodeProgram);
			$this->db->like($kolom, $keyword);
			return $this->db->get();
		}else return NULL;
	}
	
	
	function get_sub_fungsi($kode_fungsi){
		$this->db->select('*');
		$this->db->from('ref_sub_fungsi');
		$this->db->where('KodeFungsi',$kode_fungsi);		
		return $this->db->get();
	}
	
	function get_program_kegiatan($kode_fungsi,$KodeSubFungsi){
		foreach($this->get_kode_kementrian()->result() as $row){
			$KodeKementrian = $row->KodeKementrian;
		}
		$this->db->select('KodeProgram');
		$this->db->from('ref_kegiatan');
		$this->db->where('KodeFungsi',$kode_fungsi);
		$this->db->where('KodeSubFungsi',$kode_fungsi.'.'.$KodeSubFungsi);
		$this->db->where('KodeKementerian',$KodeKementrian);
		return $this->db->get();
	}
	
	function get_program_satker(){
		$this->db->select('*');
		$this->db->from('ref_satker_program');
		$this->db->join('ref_program', 'ref_program.KodeProgram = ref_satker_program.KodeProgram');
		$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		return $this->db->get();
	}
		
	function get_program_manage($kode_fungsi,$KodeSubFungsi){
		if($this->get_program_satker()->result() != NULL){
			foreach($this->get_program_satker()->result() as $row){
				$kodeprogram[] = $row->KodeProgram;
			}
			$this->db->select('*');
			$this->db->from('ref_program');
			$this->db->where('KodeStatus','1');
			$this->db->where_in('KodeProgram',$kodeprogram);
			return $this->db->get();
		}else return NULL;
	}
	
	function search_program($kodeFungsi, $KodeSubFungsi, $keyword, $kolom){
		if($this->get_program_satker()->result() != NULL){
			foreach($this->get_program_satker()->result() as $row){
				$kodeprogram[] = $row->KodeProgram;
			}
			$this->db->select('*');
			$this->db->from('ref_program');
			$this->db->where_in('KodeProgram',$kodeprogram);
			$this->db->like($kolom, $keyword);
			return $this->db->get();
		}else return NULL;
	}
	
	function get_iku_satker($kodeprogram){
		$this->db->select('*');
		$this->db->from('ref_satker_iku');
		$this->db->join('ref_iku','ref_satker_iku.KodeIku = ref_iku.KodeIku');
		$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		$this->db->where('KodeProgram',$kodeprogram);
		return $this->db->get();
	}
	
	function get_iku($KodeProgram){
		if($this->get_iku_satker()->result() != NULL){
			foreach($this->get_iku_satker()->result() as $row){
				$kodeiku[] = $row->KodeIku;
			}
			$this->db->select('*');
			$this->db->from('ref_iku');
			$this->db->where_in('KodeIku',$kodeiku);
			return $this->db->get();
		}else return NULL;
	}
	
	function search_iku($KodeProgram, $keyword, $kolom){
		if($this->get_iku_satker()->result() != NULL){
			foreach($this->get_iku_satker()->result() as $row){
				$kodeiku[] = $row->KodeIku;
			}
			$this->db->select('*');
			$this->db->from('ref_iku');
			$this->db->where('KodeProgram', $KodeProgram);
			$this->db->where_in('KodeIku',$kodeiku);
			$this->db->like($kolom, $keyword);
			return $this->db->get();
		}else return NULL;
	}

	function get_target_iku($kodeiku,$tahun) {
		if($kodeiku != NULL){
			$this->db->select('*');
			$this->db->from('target_iku');
			$this->db->where('KodeIku',$kodeiku);
			$this->db->where('idThnAnggaran',$tahun);
			return $this->db->get();
		}else return NULL;
	}
	
	function get_ikk_satker($kodekegiatan){
		$this->db->select('*');
		$this->db->from('ref_satker_ikk');
		$this->db->join('ref_ikk','ref_satker_ikk.KodeIkk = ref_ikk.KodeIkk');
		$this->db->where('kdsatker',$this->session->userdata('kdsatker'));
		$this->db->where('KodeKegiatan',$kodekegiatan);
		return $this->db->get();
	}
	
	function get_ikk($KodeKegiatan){
		if($this->get_ikk_satker()->result() != NULL){
			foreach($this->get_ikk_satker()->result() as $row){
				$kodeikk[] = $row->KodeIkk;
			}
			$this->db->select('*');
			$this->db->from('ref_ikk');
			$this->db->where_in('KodeIkk',$kodeikk);
			$this->db->where_in('KodeKegiatan',$KodeKegiatan);
			return $this->db->get();
		}else return NULL;
	}
	
	function search_ikk($KodeKegiatan, $keyword, $kolom){
		if($this->get_ikk_satker()->result() != NULL){
			foreach($this->get_ikk_satker()->result() as $row){
				$kodeikk[] = $row->KodeIkk;
			}
			$this->db->select('*');
			$this->db->from('ref_ikk');
			$this->db->where('KodeKegiatan', $KodeKegiatan);
			$this->db->like($kolom, $keyword);
			return $this->db->get();
		}else return NULL;
	}
	
	function get_menu_kegiatan($KodeProgram,$KodeKegiatan,$KodeIkk){
		$this->db->select('*');
		$this->db->from('ref_menu_kegiatan');
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeKegiatan',$KodeKegiatan);
		$this->db->where('KodeIkk',$KodeIkk);
		return $this->db->get();
	}
	
	function search_menu_kegiatan($KodeIkk, $keyword, $kolom){
		$this->db->select('*');
		$this->db->from('ref_menu_kegiatan');
		$this->db->where('KodeIkk', $KodeIkk);
		$this->db->like($kolom, $keyword);
		return $this->db->get();
	}
	
	function save($data, $table){
		$this->db->insert($table, $data);
	}
	
	function update($table, $data, $kolom, $parameter){
		$this->db->where($kolom, $parameter);
		$this->db->update($table, $data);
	}
	
	function update2($table, $data, $kolom, $parameter, $kolom2, $parameter2){
		$this->db->where($kolom, $parameter);
		$this->db->where($kolom2, $parameter2);
		$this->db->update($table, $data);
	} 
	function delete($table, $kolom, $parameter){
		$this->db->where($kolom, $parameter);
		$this->db->delete($table); 
	}
	
	function pengajuan($data){
		$this->db->insert('pengajuan',$data);
	}
	
	//filtering
	function get_program($kode_kementrian){
		$this->db->select('*');
		$this->db->from('ref_program');
		$this->db->where('KodeKementrian',$kode_kementrian);
		return $this->db->get();
	}
// Unit Utama
	function get_satker_unit_utama(){
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->like('nmsatker','biro perencanaan dan anggaran');
		$this->db->or_like('nmsatker','inspektorat','both');
		$this->db->or_like('nmsatker','sekretariat ditjen');
		$this->db->or_like('nmsatker','sekretariat badan');
		/*$this->db->where('kdsatker', '416151');
		$this->db->or_where('kdsatker', '465827');
		$this->db->or_where('kdsatker', '465895');
		$this->db->or_where('kdsatker', '465909');
		$this->db->or_where('kdsatker', '466080');
		$this->db->or_where('kdsatker', '630870');
		$this->db->or_where('kdsatker', '465915');
		$this->db->or_where('kdsatker', '415366');*/
		$this->db->order_by('nmsatker', 'asc');
		return $this->db->get();
	}
// Kantor Pusat
	function get_satker_kp(){
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->where('kdjnssat', '1');
		$this->db->not_like('nmsatker', 'biro perencanaan dan anggaran');
		$this->db->not_like('nmsatker', 'inspektorat', 'both');
		$this->db->not_like('nmsatker', 'sekretariat ditjen');
		$this->db->not_like('nmsatker', 'sekretariat badan');
		$this->db->order_by('nmsatker', 'asc');
		return $this->db->get();
	}
// Kantor Daerah
	function get_satker_kd(){
		$this->db->select('*');
		$this->db->from('ref_satker');
		$this->db->where('kdjnssat', '2');
		$this->db->order_by('nmsatker', 'asc');
		return $this->db->get();
	}
	
	// function get_satker_rs(){
		// $this->db->select('*');
		// $this->db->from('ref_satker');
		// $this->db->like('nmsatker', 'rs');
		// $this->db->not_like('nmsatker', 'rsud');
		// $this->db->or_like('nmsatker', 'rumah sakit');
		// $this->db->not_like('nmsatker', 'rumah sakit umum daerah');
		// return $this->db->get();
	// }
	// function get_satker_kementerian(){
		// $this->db->select('*');
		// $this->db->from('ref_satker');
		// $this->db->like('nmsatker', 'direktorat');
		// return $this->db->get();
	// }
	// function get_satker_pusat(){
		// $this->db->select('*');
		// $this->db->from('ref_satker');
		// $this->db->like('nmsatker', 'pusat', 'after');
		// return $this->db->get();
	// }
	
// Dekon
	function get_satker_provinsi(){
		$this->db->select('*');
		$this->db->from('ref_satker');
		//$this->db->like('nmsatker', 'dinas kesehatan pro');
		// $this->db->where('kdunit', '01');
		// $this->db->where('kdunit','00');
		$this->db->where('kdkabkota','00');
		$this->db->where('nomorsp !=','');
		$this->db->where('kdkppn !=','');
		$this->db->where('kdunit_awa !=','');
		$this->db->order_by('kdlokasi', 'asc');
		return $this->db->get();
	}
// Tugas Pembantuan
	function get_satker_tp($kab,$prov){
		$this->db->select('*');
		$this->db->from('ref_satker');
		// $this->db->where('kdunit', '01');
		$this->db->where('kdkabkota', $kab);
		$this->db->where('kdlokasi', $prov);
		$this->db->where('kdjnssat', '4');
		//$this->db->where('kdunit', '01');
		$this->db->not_like('nmsatker', 'dinas kesehatan pro');
		$this->db->order_by('nmsatker', 'asc');
		return $this->db->get();
	}
	
	// function get_satker_tp2($kab,$prov){
		// $this->db->select('*');
		// $this->db->from('ref_satker');
		// $this->db->where('kdkabkota', $kab);
		// $this->db->where('kdlokasi', $prov);
		// //$this->db->where('kdunit', '01');
		// $this->db->like('nmsatker','rsud');
		// return $this->db->get();
	// }
	// function get_satker_tp3($kab,$prov){
		// $this->db->select('*');
		// $this->db->from('ref_satker');
		// $this->db->where('kdkabkota', $kab);
		// $this->db->where('kdlokasi', $prov);
		// //$this->db->where('kdunit', '01');
		// $this->db->like('nmsatker','rumah sakit umum daerah');
		// return $this->db->get();
	// }
	// function get_satker_tp4($kab,$prov){
		// $this->db->select('*');
		// $this->db->from('ref_satker');
		// $this->db->where('kdkabkota', $kab);
		// $this->db->where('kdlokasi', $prov);
		// //$this->db->where('kdunit', '01');
		// $this->db->like('nmsatker','dinas kesehatan k');
		// return $this->db->get();
	// }
	//cek database
	function cek_fungsi($KodePengajuan,$KodeFungsi){
		$this->db->select('count(*) as jumlah');
		$this->db->from('data_fungsi');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		return $this->db->get();
	}
	
	function hapus_fungsi($KodePengajuan,$KodeFungsi){
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->delete('data_fungsi');
	}
	
	function cek_sub_fungsi($KodePengajuan,$KodeFungsi, $KodeSubFungsi){
		$this->db->select('count(*) as jumlah');
		$this->db->from('data_sub_fungsi');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		return $this->db->get();
	}
	
	function hapus_sub_fungsi($KodePengajuan,$KodeFungsi, $KodeSubFungsi){
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->delete('data_sub_fungsi');
	}
	
	function cek_program($KodePengajuan,$KodeFungsi, $KodeSubFungsi, $KodeProgram){
		$this->db->select('count(*) as jumlah');
		$this->db->from('data_program');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		return $this->db->get();
	}
	
	function hapus_program($KodePengajuan,$KodeFungsi, $KodeSubFungsi, $KodeProgram){
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->delete('data_program');
	}
	
	function cek_iku($KodePengajuan,$KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeIku){
		$this->db->select('count(*) as jumlah');
		$this->db->from('data_iku');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeIku',$KodeIku);
		return $this->db->get();
	}
	
	function hapus_iku($KodePengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeIku){
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeIku',$KodeIku);
		$this->db->delete('data_iku');
	}
	
	function cek_kegiatan($KodePengajuan,$KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$this->db->select('count(*) as jumlah');
		$this->db->from('data_kegiatan');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeFungsi.".".$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeKegiatan',$KodeKegiatan);
		return $this->db->get();
	}
	
	function biaya_program($KodePengajuan,$KodeFungsi, $KodeSubFungsi, $KodeProgram){
		$this->db->select('*');
		$this->db->from('data_program');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		return $this->db->get();
	}
	
	function sum($tabel,$kolom, $kolom1,$param){
		$this->db->select_sum($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom1, $param);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->$kolom;
		}
		return $Biaya;
	}
	
	function sum2($tabel,$kolom, $kolom1,$param,$kolom2,$param2){
		$this->db->select_sum($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom1, $param);
		$this->db->where($kolom2, $param2);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->$kolom;
		}
		return $Biaya;
	}
	
	function get_biaya($tabel,$kolom, $kolom1,$param,$kolom2,$param2){
		$this->db->select_sum($kolom);
		$this->db->from($tabel);
		$this->db->where($kolom1, $param);
		$this->db->where($kolom2, $param2);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->$kolom;
		}
		return $Biaya;
	}
	
	function get_biaya_fp($kd_pengajuan, $kd_fp){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('fp_aktivitas', 'aktivitas.KodeAktivitas = fp_aktivitas.KodeAktivitas');
		$this->db->where('KD_PENGAJUAN', $kd_pengajuan);
		$this->db->where('idFokusPrioritas', $kd_fp);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->Jumlah;
		}
		return $Biaya;
	}
	
	function get_biaya_rk($kd_pengajuan, $kd_rk){
		$this->db->select_sum('Jumlah');
		$this->db->from('aktivitas');
		$this->db->join('rk_aktivitas', 'aktivitas.KodeAktivitas = rk_aktivitas.KodeAktivitas');
		$this->db->where('KD_PENGAJUAN', $kd_pengajuan);
		$this->db->where('idReformasiKesehatan', $kd_rk);
		$return = $this->db->get()->result();
		$Biaya = 0;
		foreach($return as $row){
			$Biaya = $row->Jumlah;
		}
		return $Biaya;
	}
	
	function hapus_kegiatan($KodePengajuan,$KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan){
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeFungsi.".".$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeKegiatan',$KodeKegiatan);
		$this->db->delete('data_kegiatan');
	}
	
	function cek_ikk($KodePengajuan,$KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk){
		$this->db->select('count(*) as jumlah');
		$this->db->from('data_ikk');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeKegiatan',$KodeKegiatan);
		$this->db->where('KodeIkk',$KodeIkk);
		return $this->db->get();
	}
	
	function hapus_ikk($KodePengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk){
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeKegiatan',$KodeKegiatan);
		$this->db->where('KodeIkk',$KodeIkk);
		$this->db->delete('data_ikk');
	}
	
	function cek_menu_kegiatan($KodePengajuan,$KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk, $KodeMenuKegiatan){
		$this->db->select('count(*) as jumlah');
		$this->db->from('data_menu_kegiatan');
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeKegiatan',$KodeKegiatan);
		$this->db->where('KodeIkk',$KodeIkk);
		$this->db->where('KodeMenuKegiatan',$KodeMenuKegiatan);
		return $this->db->get();
	}
	
	function hapus_menu_kegiatan($KodePengajuan, $KodeFungsi, $KodeSubFungsi, $KodeProgram, $KodeKegiatan, $KodeIkk, $KodeMenuKegiatan){
		$this->db->where('KD_PENGAJUAN',$KodePengajuan);
		$this->db->where('KodeFungsi',$KodeFungsi);
		$this->db->where('KodeSubFungsi',$KodeSubFungsi);
		$this->db->where('KodeProgram',$KodeProgram);
		$this->db->where('KodeKegiatan',$KodeKegiatan);
		$this->db->where('KodeIkk',$KodeIkk);
		$this->db->where('KodeMenuKegiatan',$KodeMenuKegiatan);
		$this->db->delete('data_menu_kegiatan');
	}
	
	function get_data_flexigrid($tabel)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_data_flexigrid_join($tabel,$tabel_join,$parameter_join){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_data_flexigrid_joins(){
		$this->db->select('*');
		$this->db->from('prioritas_program');
		//$this->db->join('ref_jenis_prioritas','ref_jenis_prioritas.KodeJenisPrioritas=prioritas_program.KodeJenisPrioritas');
		$this->db->join('ref_periode','ref_periode.idPeriode=prioritas_program.idPeriode');
		$this->db->join('ref_tahun_anggaran','ref_tahun_anggaran.idThnAnggaran=prioritas_program.idThnAnggaran');
		$this->db->group_by('prioritas_program.idThnAnggaran');
		//$this->db->join('ref_program','ref_program.KodeProgram=prioritas_program.KodeProgram');
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('prioritas_program');
		//$this->db->join('ref_jenis_prioritas','ref_jenis_prioritas.KodeJenisPrioritas=prioritas_program.KodeJenisPrioritas');
		$this->db->join('ref_periode','ref_periode.idPeriode=prioritas_program.idPeriode');
		$this->db->join('ref_tahun_anggaran','ref_tahun_anggaran.idThnAnggaran=prioritas_program.idThnAnggaran');
		$this->db->group_by('prioritas_program.idThnAnggaran');
		//$this->db->join('ref_program','ref_program.KodeProgram=prioritas_program.KodeProgram');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $query['records']->num_rows();
		return $query;
	}
	
	function get_join_where($tabel,$tabel_join,$param_join,$kolom,$param){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join, $param_join);
		$this->db->where($kolom, $param);
		return $this->db->get();
	}
	
	function get_data_flexigrid_double_join($tabel,$tabel_join,$parameter_join,$tabel_join2,$parameter_join2){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->db->join($tabel_join2,$parameter_join2);
		$this->CI->flexigrid->build_query();
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join($tabel_join,$parameter_join);
		$this->db->join($tabel_join2,$parameter_join2);
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}

	function get_jumlah_ikk($kd_pengajuan) {
		$this->db->select('i.*');
		$this->db->from('data_kegiatan d');
		$this->db->join('ref_ikk i', 'i.KodeKegiatan=d.KodeKegiatan');
		$this->db->where('d.KD_PENGAJUAN',$kd_pengajuan);

		return $this->db->get();
	}

	function get_jumlah_iku($kd_pengajuan) {
		$this->db->select('i.*');
		$this->db->from('data_program d');
		$this->db->join('ref_iku i', 'i.KodeProgram=d.KodeProgram');
		$this->db->where('d.KD_PENGAJUAN',$kd_pengajuan);

		return $this->db->get();
	}

	function get_ikk_by_kdpengajuan($kd_pengajuan) {
		$this->db->select('*');
		$this->db->from('data_ikk');
		$this->db->where('KD_PENGAJUAN',$kd_pengajuan);

		return $this->db->get();
	}

	function get_iku_by_kdpengajuan($kd_pengajuan) {
		$this->db->select('*');
		$this->db->from('data_iku');
		$this->db->where('KD_PENGAJUAN',$kd_pengajuan);

		return $this->db->get();
	}

	function get_ikk_by_kodeikk($kd_pengajuan, $kd_ikk) {
		$this->db->select('*');
		$this->db->from('data_ikk d');
		$this->db->join('target_ikk t','d.KodeIkk=t.KodeIkk');
		$this->db->join('ref_tahun_anggaran a','a.idThnAnggaran=t.idThnAnggaran');
		$this->db->where('d.KD_PENGAJUAN',$kd_pengajuan);
		$this->db->where('d.KodeIkk',$kd_ikk);
		$this->db->where('a.thn_anggaran',$this->session->userdata('thn_anggaran'));

		return $this->db->get()->row();
	}

	function get_iku_by_kodeiku($kd_pengajuan, $kd_iku) {
		$this->db->select('*');
		$this->db->from('data_iku d');
		$this->db->join('target_iku t','d.KodeIku=t.KodeIku');
		$this->db->join('ref_tahun_anggaran a','a.idThnAnggaran=t.idThnAnggaran');
		$this->db->where('d.KD_PENGAJUAN',$kd_pengajuan);
		$this->db->where('d.KodeIku',$kd_iku);
		$this->db->where('a.thn_anggaran',$this->session->userdata('thn_anggaran'));

		return $this->db->get()->row();
	}

	function getTargetIkk($kd_pengajuan) {
		$this->db->select('*');
		$this->db->from('data_ikk');
		$this->db->where('KD_PENGAJUAN',$kd_pengajuan);

		return $this->db->get();
	}

	function get_ikk_by_satker($kd_pengajuan) {
		$this->db->select('*');
		$this->db->from('data_ikk d');
		$this->db->join('ref_ikk t','d.KodeIkk=t.KodeIkk');
		$this->db->where('d.KD_PENGAJUAN',$kd_pengajuan);

		return $this->db->get();
	}

	function get_iku_by_satker($kd_pengajuan) {
		$this->db->select('*');
		$this->db->from('data_iku d');
		$this->db->join('ref_iku t','d.KodeIku=t.KodeIku');
		$this->db->where('d.KD_PENGAJUAN',$kd_pengajuan);

		return $this->db->get();
	}

	function get_ikk_by_kdpengajuan_ikk($kd_pengajuan, $kd_ikk) {
		$this->db->select('*');
		$this->db->from('data_ikk d');
		$this->db->where('d.KD_PENGAJUAN',$kd_pengajuan);
		$this->db->where('d.KodeIkk',$kd_ikk);

		return $this->db->get();
	}

	function get_targetikk_by_kdpengajuan_ikk($kd_pengajuan, $kd_ikk, $thn) {
		$this->db->select('*');
		$this->db->from('data_ikk d');
		$this->db->join('target_ikk i', 'i.KodeIkk=d.KodeIkk');
		$this->db->where('d.KD_PENGAJUAN',$kd_pengajuan);
		$this->db->where('d.KodeIkk',$kd_ikk);
		$this->db->where('i.idThnAnggaran',$thn);

		return $this->db->get();
	}
}

<?php
class Kabupaten_model extends CI_Model
{
	function valid($nama){
		$query = $this->db->query("select NamaKabupaten from ref_kabupaten where NamaKabupaten like '$nama'");
		if($query->num_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function valid_kode($kode,$kdprov){
		$query = $this->db->get_where('ref_kabupaten', array('KodeProvinsi' => $kdprov, 'KodeKabupaten' => $kode));
		if ($query->num_rows() > 0){
			return TRUE;	
		}
		else
			return FALSE;
	}
}
?>
<?php
class Thn_anggaran_model extends CI_Model
{
	function valid($tahun)
	{
		$sql = $this->db->query("select thn_anggaran from ref_tahun_anggaran where thn_anggaran like '$tahun'");
		if($sql->num_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;	
		}
	}
	
	function validasi($tahun){
		$sql = $this->db->get_where('ref_tahun_anggaran', array('thn_anggaran' => $tahun));
		if($sql->num_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;	
		}
	}
}
?>
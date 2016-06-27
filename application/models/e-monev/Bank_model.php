<?php
class Bank_model extends CI_Model {
	/**
	 * Constructor
	 */
	public function __construct()
    {
        parent::__construct();
		$this->CI = get_instance();		
    }
	
	function get_data_flexigrid_bank()
	{
		$this->db->select('*');
		$this->db->from('monev.bank');
		$this->CI->flexigrid->build_query();		
		$query['records'] = $this->db->get();
		
		$this->db->select('*');
		$this->db->from('monev.bank');
		$this->CI->flexigrid->build_query(FALSE);
		$query['record_count'] = $this->db->count_all_results();
		return $query;
	}
	
	function get_all_bank()
    {
        $this->db->select('*');
		$this->db->from('monev.bank');	
		$query = $this->db->get();
		return $query;
    }

	function get_bank($bank_id)
	{
		$this->db->select('*');
		$this->db->from('monev.bank');
		$this->db->where('bank_id',$bank_id);
		$query = $this->db->get();
		return $query;
	}
	
	function add($bank)
	{
		$this->db->insert('monev.bank', $bank);
	}
		
	function update($bank_id, $bank)
	{
		$this->db->where('bank_id',$bank_id)->update('monev.bank', $bank);
	}

	function hapus($bank_id)
	{
		$this->db->where('bank_id',$bank_id)->delete('monev.bank');
	}
	
	function cek_bank_baru($bank)
	{
		$query = $this->db->get_where('monev.bank', array('nama_bank' => $bank));
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	function cek_bank($bank, $bank_id)
	{				
		$query = $this->db->query('select * from monev.bank where nama_bank =  "'.$bank.'" and bank_id <> '.$bank_id);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
// END masteranggaran_model Class
/* End of file bank_model.php */
/* Location: ./application/models/e-monev/bank_model.php */

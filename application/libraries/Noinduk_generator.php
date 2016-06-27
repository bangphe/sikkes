<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Noinduk_generator
{	
	/**
	* Constructor
	* 
	* @access	public
	*/	
	public function Noinduk_generator()
        {
                
	}

        /**
	 * Create no induk
	 *
	 * @access	public
	 * @param	varietas
	 * @param	kecamatan
	 * @param	kelas benih
         * @param	no unik
	 * @return	string
	 */
        public function create($varietas,$kecamatan,$kelas_benih,$nomer_unik){
                $CI =& get_instance();
                
                $CI->load->model('varietas_model');
                $CI->load->model('kecamatan_model');
                $CI->load->model('kelas_benih_model');
                
		$result_tanaman 	= $CI->varietas_model->get_varietas_dan_tanaman($varietas);
		foreach($result_tanaman->result() as $row){
			$tanaman 	=	$row->KODE_TANAMAN;
			$varietas	=	$row->KODE_VARIETAS;
			$kode_per 	=	$row->KODE_PERBANYAKAN;
		}

		$result_kelas_benih = $CI->kelas_benih_model->get_kode_grup_kelas_benih($kelas_benih);
		foreach($result_kelas_benih->result() as $row){
			$kode_benih =	$row->KODE_KELAS_BENIH;
		}

		$result_kabupaten = $CI->kecamatan_model->get_kode_kabupaten($kecamatan);
		foreach($result_kabupaten->result() as $row){
			$kode_kabupaten =	$row->KODE_KABUPATEN;
			$kode_satgas 	=	$row->KODE_SATGAS;
		}
                
		$nomor_permohonan = $varietas.' '.$kode_per.' '.$kode_benih.'/3'.' '.$kode_satgas.$kode_kabupaten.'.'.$nomer_unik;
		return $nomor_permohonan;
	}

        /**
	 * get current no induk. It depends on each phase
	 *
	 * @access	public
	 * @param	kelas_benih: new kelas_benih on current phase
	 * @param	no_induk: refer on pengajuan
	 */
        public function get_current($kelas_benih, $no_induk){
            $CI =& get_instance();
            $CI->load->model('kelas_benih_model');

                $string			= explode(" ",$no_induk); //split no induk lapangan

                //get new kode kelas benih of its current
                $result_kelas_benih = $CI->kelas_benih_model->get_kode_grup_kelas_benih($kelas_benih);
                foreach($result_kelas_benih->result() as $row){
                        $kode_benih =	$row->KODE_KELAS_BENIH;
                }

                $no_induk = $string[0].' '.$string[1].' '.$kode_benih.'/3'.' '.$string[3];

                return $no_induk;
        }
}
?>
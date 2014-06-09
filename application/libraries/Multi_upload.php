<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
* This library assumes that you have already loaded the default CI Upload Library seperately
* 
* Functions is based upon CI_Upload, Feel free to modify this 
*   library to function as an extension to CI_Upload
* 
* Library modified by: Alvin Mites
* http://www.mitesdesign.com
* 
*/

class Multi_upload  {
	function Multi_upload () {
//		$CI =& get_instance();
	}
	
	/**
	 * Perform multiple file uploads
     * Based upon JQuery Multiple Upload Class
     * see http://www.fyneworks.com/jquery/multiple-file-upload/
	 */	
	function go_upload($field = 'userfile') {
        $CI =& get_instance(); 
		// Is $_FILES[$field] set? If not, no reason to continue.
		if ( ! isset($_FILES[$field]['name'][0])){
			$CI->upload->set_error('upload_no_file_selected');
			return FALSE;
		} 
		else{
			$num_files = count($_FILES[$field]['name']) -1;
            $file_list = array();
            $error_hold = array();
            $error_upload = FALSE;
		}
		
        // Is the upload path valid?
        if ( ! $CI->upload->validate_upload_path()){
            // errors will already be set by validate_upload_path() so just return FALSE
            return FALSE;
        }
        
        for ($i=0; $i < $num_files; $i++) {
			$error_hold[$i] = FALSE;                       
			// Was the file able to be uploaded? If not, determine the reason why.
			if ( ! is_uploaded_file($_FILES[$field]['tmp_name'][$i])){
                $error = ( ! isset($_FILES[$field]['error'][$i])) ? 4 : $_FILES[$field]['error'][$i];
                switch($error){
                    case 1:  // UPLOAD_ERR_INI_SIZE
                        $error_hold[$i] = 'upload_file_exceeds_limit';
                        break;
                    case 2: // UPLOAD_ERR_FORM_SIZE
                        $error_hold[$i] = 'upload_file_exceeds_form_limit';
                        break;
                    case 3: // UPLOAD_ERR_PARTIAL
                       $error_hold[$i] = 'upload_file_partial';
                        break;
                    case 4: // UPLOAD_ERR_NO_FILE
                       $error_hold[$i] = 'upload_no_file_selected';
                        break;
                    case 6: // UPLOAD_ERR_NO_TMP_DIR
                        $error_hold[$i] = 'upload_no_temp_directory';
                        break;
                    case 7: // UPLOAD_ERR_CANT_WRITE
                        $error_hold[$i] = 'upload_unable_to_write_file';
                        break;
                    case 8: // UPLOAD_ERR_EXTENSION
                        $error_hold[$i] = 'upload_stopped_by_extension';
                        break;
                    default :
                        $error_hold[$i] = 'upload_no_file_selected';
                        break;
                }
                return FALSE;
            }
		
		
            // Set the uploaded data as class variables
            $CI->upload->file_temp = $_FILES[$field]['tmp_name'][$i];        
            $CI->upload->file_name = $CI->upload->_prep_filename($_FILES[$field]['name'][$i]);
            $CI->upload->file_size = $_FILES[$field]['size'][$i];        
//            $CI->upload->file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type'][$i]);
//            $CI->upload->file_type = strtolower($CI->upload->file_type);
            $CI->upload->file_ext  = $CI->upload->get_extension($_FILES[$field]['name'][$i]);
            
            // Convert the file size to kilobytes
            if ($CI->upload->file_size > 0){
                $CI->upload->file_size = round($CI->upload->file_size/1024, 2);
            }

            // Is the file type allowed to be uploaded?
            if ( ! $CI->upload->is_allowed_filetype()){
                $error_hold[$i] = 'upload_invalid_filetype';
            }

            // Is the file size within the allowed maximum?
            if ( ! $CI->upload->is_allowed_filesize()) {
                $error_hold[$i] = 'upload_invalid_filesize';
            }

            // Are the image dimensions within the allowed size?
            // Note: This can fail if the server has an open_basdir restriction.
            if ( ! $CI->upload->is_allowed_dimensions()){
                $error_hold[$i] = 'upload_invalid_dimensions';
            }

            // Sanitize the file name for security
            $CI->upload->file_name = $CI->upload->clean_file_name($CI->upload->file_name);

            // Remove white spaces in the name
            if ($CI->upload->remove_spaces == TRUE){
                $CI->upload->file_name = preg_replace("/\s+/", "_", $CI->upload->file_name);
            }
			
			/*
			* Validate the file name
			* This function appends an number onto the end of
			* the file if one with the same name already exists.
			* If it returns false there was a problem.
			*/
            $CI->upload->orig_name = $CI->upload->file_name;

            if ($CI->upload->overwrite == FALSE){
                $CI->upload->file_name = $CI->upload->set_filename($CI->upload->upload_path, $CI->upload->file_name);
                if ($CI->upload->file_name === FALSE){
                    $error_hold[$i] = TRUE;
                }
            }
			
			/*
			* Move the file to the final destination
			* To deal with different server configurations
			* we'll attempt to use copy() first.  If that fails
			* we'll use move_uploaded_file().  One of the two should
			* reliably work in most environments
			*/
            if ( ! @copy($CI->upload->file_temp, $CI->upload->upload_path.$CI->upload->file_name)){
                if ( ! @move_uploaded_file($CI->upload->file_temp, $CI->upload->upload_path.$CI->upload->file_name)){
                     $error_hold[$i] = 'upload_destination_error';
                }
            }
            
            /*
			 * Run the file through the XSS hacking filter
			 * This helps prevent malicious code from being
			 * embedded within a file.  Scripts can easily
			 * be disguised as images or other file types.
			 */
            if ($CI->upload->xss_clean == TRUE){
                $CI->upload->do_xss_clean();
            }
            
            if ($error_hold[$i]) {
                $error_upload = TRUE;
            } 
			else {
                if ($imageVar = $this->multiple_image_properties($CI->upload->upload_path.$CI->upload->file_name)) {
                    $file_list[] = array(
                            'name' 	=> $CI->upload->file_name,
                            'file' 	=> $CI->upload->upload_path.$CI->upload->file_name,
                            'size' 	=> $CI->upload->file_size,
                            'ext' 	=> $CI->upload->file_ext,
                            'image_type' => $imageVar->image_type,
                            'height' => $imageVar->height,
                            'width' => $imageVar->width
                            );
                } else {
                    $file_list[] = array(
                            'name' 	=> $CI->upload->file_name,
                            'file' 	=> $CI->upload->upload_path.$CI->upload->file_name,
                            'size' 	=> $CI->upload->file_size,
                            'type' 	=> $CI->upload->file_type,
                            'ext' 	=> $CI->upload->file_ext,
                            );
                }
                
            }
        }
        if ($error_upload) {
            $this->set_error($error_hold);
            return FALSE;
        } else {
			
            return $file_list;
        }    
    }//end of functions
   
	function do_synchronize($nama_file){
		$CI =& get_instance(); 
		$CI->load->model('pengajuan_sertifikasi_model');
		$CI->load->model('pengawasan_panen_model');
		$CI->load->model('pengolahan_model');
		$CI->load->model('fase_pendahuluan_model');
		$CI->load->model('permohonan_uji_lab_model');
		$CI->load->model('siap_siar_model');
		$CI->load->model('fase_tumbuh_model');
		$CI->load->model('sample_model');
		$CI->load->model('kaji_ulang_model');
		$CI->load->model('rekomendasi_benih_model');
		$CI->load->model('konsep_label_model');
		$CI->load->model('pengujian_kadar_air_model');
		$CI->load->model('pengujian_daya_tumbuh_model');
		$CI->load->model('pengujian_kemurnian_fisik_model');
		$CI->load->model('pengujian_kemurnian_genetik_model');
		$CI->load->model('pengolahan_gabungan_model');
		
		//-------------------------------------------debugging untuk sinkronisasi mulai disini --------------------------------------------------------------------------------------------------------------------------------------------//
		$file = fopen('./upload_file/'.$nama_file, "r");
		$contents = fread($file,filesize('./upload_file/'.$nama_file));
		$explode_contents 	= explode('--BATAS--',$contents);

                // cek format file sql
                if (count($explode_contents) != 17) {
                    $this->set_error('The file you are attempting to synchronize has unknown format.');
                    return FALSE;
                }else{
		$query_pengajuan 	= $explode_contents[1]; //query pengajuan sertifikasi
		// olah data pengajuan sertifikasi
		$array_pengajuan	= explode('INSERT INTO pengajuan_sertifikasi VALUES',$query_pengajuan);	
		$total_isi_array	= count($array_pengajuan);
		$count_data			= 0;	

		//------------------------------------------------------olah pendahuluan ------------------------------------------------------------------------------------------------------//
		$query_pendahuluan	= $explode_contents[2]; //query pendahuluan
		$array_pendahuluan	= explode('INSERT INTO pendahuluan VALUES',$query_pendahuluan);
		$total_array_pendahuluan	= count($array_pendahuluan);
		//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------olah panen ------------------------------------------------------------------------------------------------------//
		$query_pengawasan_panen	= $explode_contents[3]; //query pengawasan panen
		$array_pengawasan_panen	= explode('INSERT INTO pengawasan_panen VALUES',$query_pengawasan_panen);
		$total_isi_array_panen	= count($array_pengawasan_panen);
		//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		//------------------------------------------------------olah pengolahan ------------------------------------------------------------------------------------------------------//
		$query_pengolahan		= $explode_contents[4]; //query pengolahan
		$array_pengolahan		= explode('INSERT INTO pengolahan VALUES',$query_pengolahan);
		$total_isi_array_olah	= count($array_pengolahan);
		//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------	
					$total_array_kadar_air;
//		echo 'pertama';
                for($i=1;$i<=$total_isi_array-1;$i++){
			if($array_pengajuan[$i] != ''){
				$urutan_kolom 	= explode(',',$array_pengajuan[$i]);
				$no_induk 		= trim($urutan_kolom[11], '"'); //menghilangkan string "" pada hasil nomor induk lapangan
							
				//kondisi ngecek apakah nomor induk sudah ada dalam database atau belum
				$result_cek		= $CI->pengajuan_sertifikasi_model->get_hasil_dari_no_induk($no_induk);	
				if($result_cek->num_rows() == 0){
				
					$induk_permohonan = trim(trim($urutan_kolom[0], '('),'"'); //get id-permohonan			
				
					$result_max = $CI->pengajuan_sertifikasi_model->get_last_id_permohonan();
					$new_id 	= $result_max->row()->ID_PERMOHONAN+1;
					$new_id		= '("'.$new_id.'"';			// id_permohonan_baru
					
					//replace dengan id permohonan baru
					$replace_id = array(0=>$new_id);
					array_splice($urutan_kolom,0,1,$replace_id); 
									
					//gabungkan ulang lagi array terpecah-pecah
					$pengajuan_baru = implode(",", $urutan_kolom); 
					$query_pengajuan = 'INSERT INTO pengajuan_sertifikasi VALUES'.$pengajuan_baru;

					$CI->pengajuan_sertifikasi_model->insert_hasil_pengajuan_sinkronisasi($query_pengajuan);
					$count_data	= $count_data+1;

					//------------------------------------------------------olah pendahuluan ------------------------------------------------------------------------------------------------------//
					for($j=1;$j<=$total_array_pendahuluan-1;$j++){
						$urutan_kolom_pendahuluan = explode(',',$array_pendahuluan[$j]);
						$induk_permohonan_pendahuluan = trim($urutan_kolom_pendahuluan[4], '"'); //menghilangkan string "" 
						if($induk_permohonan_pendahuluan == $induk_permohonan){
							$result_max_pendahuluan = $CI->fase_pendahuluan_model->get_last_id_pendahuluan();
							$new_id_pendahuluan 	= $result_max_pendahuluan->row()->ID_PENDAHULUAN+1;
							$new_id_pendahuluan		= '("'.$new_id_pendahuluan.'"';			// id_pengawasan_panen_baru
							
							$urutan_kolom_pendahuluan[0] = $new_id_pendahuluan; //replace dengan id pengawasan
							$urutan_kolom_pendahuluan[4] = $result_max->row()->ID_PERMOHONAN+1; //replace dengan id permohonan
											
							//gabungkan ulang lagi array terpecah-pecah
							$pendahuluan_baru 	= implode(",", $urutan_kolom_pendahuluan); 
							$query_pendahuluan	= 'INSERT INTO pendahuluan VALUES'.$pendahuluan_baru;
							$CI->fase_pendahuluan_model->insert_hasil_pendahuluan_sinkronisasi($query_pendahuluan);
						}
					}//end for					
					//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					
					//------------------------------------------------------olah panen ------------------------------------------------------------------------------------------------------//
					for($j=1;$j<=$total_isi_array_panen-1;$j++){
						$urutan_kolom_panen = explode(',',$array_pengawasan_panen[$j]);
						$induk_permohonan_panen = trim($urutan_kolom_panen[3], '"'); //menghilangkan string "" 
						if($induk_permohonan_panen == $induk_permohonan){
							$result_max_panen = $CI->pengawasan_panen_model->get_last_id_pengawasan();
							$new_id_panen 	= $result_max_panen->row()->ID_PENGAWASAN+1;
							$new_id_panen	= '("'.$new_id_panen.'"';			// id_pengawasan_panen_baru
							
							$urutan_kolom_panen[0] = $new_id_panen; //replace dengan id pengawasan
							$urutan_kolom_panen[3] = $result_max->row()->ID_PERMOHONAN+1; //replace dengan id permohonan
											
							//gabungkan ulang lagi array terpecah-pecah
							$pengawasan_panen_baru 	= implode(",", $urutan_kolom_panen); 
							$query_pengawasan		= 'INSERT INTO pengawasan_panen VALUES'.$pengawasan_panen_baru;
							$CI->pengawasan_panen_model->insert_hasil_panen_sinkronisasi($query_pengawasan);
						}
					}//end for					
					//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					
					//------------------------------------------------------olah pengolahan ------------------------------------------------------------------------------------------------------//
					for($j=1;$j<=$total_isi_array_olah-1;$j++){
						$urutan_kolom_pengolahan = explode(',',$array_pengolahan[$j]);
						$induk_permohonan_pengolahan = trim($urutan_kolom_pengolahan[1], '"'); //menghilangkan string "" 
						if($induk_permohonan_pengolahan == $induk_permohonan){
							$result_max_olah 	= $CI->pengolahan_model->get_last_id_pengolahan();
							$new_id_olah 		= $result_max_olah->row()->ID_PENGOLAHAN+1;
							$new_id_olah		= '("'.$new_id_olah.'"';			// id_pengawasan_panen_baru
							
							//replace dengan id permohonan baru
							$urutan_kolom_pengolahan[0] = $new_id_olah; //replace dengan id pengolahan
							$urutan_kolom_pengolahan[1] = $result_max->row()->ID_PERMOHONAN+1; //replace dengan id permohonan
											
							//gabungkan ulang lagi array terpecah-pecah
							$pengolahan_baru 	= implode(",", $urutan_kolom_pengolahan); 
							$query_pengolahan	= 'INSERT INTO pengolahan VALUES'.$pengolahan_baru;
							$CI->pengolahan_model->insert_hasil_olah_sinkronisasi($query_pengolahan);
						}
					}//end for					
					//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

					//------------------------------------------------------olah permohonan uji lab--------------------------------------------------------------------------------------------//
					$query_uji_lab			= $explode_contents[7]; //query permohonan uji lab
					$array_uji_lab			= explode('INSERT INTO permohonan_uji_lab VALUES',$query_uji_lab);
					$total_array_uji_lab	= count($array_uji_lab);
					for($j=1;$j<=$total_array_uji_lab-1;$j++){
						$urutan_kolom_uji_lab 		= explode(',',$array_uji_lab[$j]);
						$induk_permohonan_uji_lab 	= trim($urutan_kolom_uji_lab[1], '"'); //menghilangkan string "" 
						if($induk_permohonan_uji_lab == $induk_permohonan){
						
							//get id fase lapangan
							$id_permohonan_uji_awal = trim(trim($urutan_kolom_uji_lab[0], '('),'"'); //get id-permohonan
							
							$result_max_uji_lab	= $CI->permohonan_uji_lab_model->get_last_id_uji();
							$new_id_uji_lab		= $result_max_uji_lab->row()->ID_PERMOHONAN_UJI+1;
							$new_id_uji_lab		= '("'.$new_id_uji_lab.'"';

							//replace dengan id permohonan baru
							$urutan_kolom_uji_lab[0] = $new_id_uji_lab; //replace dengan id permohonan_uji_lab
							$urutan_kolom_uji_lab[1] = $result_max->row()->ID_PERMOHONAN+1; //replace dengan id permohonan

							//gabungkan ulang lagi array terpecah-pecah
							$uji_lab_baru 	= implode(",", $urutan_kolom_uji_lab); 
							$query_uji_lab	= 'INSERT INTO permohonan_uji_lab VALUES'.$uji_lab_baru;
							$CI->permohonan_uji_lab_model->insert_hasil_uji_lab_sinkronisasi($query_uji_lab);
							
							//------------------------------------------------------olah kaji ulang---------------------------------------------------------------------------------------------------------//
							$query_kaji_ulang	= $explode_contents[9]; //query kaji ulang
							$array_kaji_ulang	= explode('INSERT INTO kaji_ulang_permintaan VALUES',$query_kaji_ulang);
							$total_array_kaji_ulang	= count($array_kaji_ulang);
							for($k=1;$k<=$total_array_kaji_ulang-1;$k++){
								$urutan_kolom_kaji_ulang 	= explode(',',$array_kaji_ulang[$k]);
								$induk_permohonan_uji 		= trim($urutan_kolom_kaji_ulang[1], '"'); //menghilangkan string "" 
								if($induk_permohonan_uji == $id_permohonan_uji_awal){
								
									//get id fase lapangan
									$id_kaji_ulang_awal 	= trim(trim($urutan_kolom_kaji_ulang[0], '('),'"'); //get id-permohonan
								
									$result_max_kaji_ulang	= $CI->kaji_ulang_model->get_last_id_kaji_ulang();
									$new_id_kaji_ulang		= $result_max_kaji_ulang->row()->ID_KAJI_ULANG+1;
									$new_id_kaji_ulang		= '("'.$new_id_kaji_ulang.'"';

									//replace dengan id permohonan baru
									$urutan_kolom_kaji_ulang[0] = $new_id_kaji_ulang; //replace dengan id kaji ulang
									$urutan_kolom_kaji_ulang[1] = $result_max_uji_lab->row()->ID_PERMOHONAN_UJI+1; //replace dengan id permohonan uji

									//gabungkan ulang lagi array terpecah-pecah
									$kaji_ulang_baru 	= implode(",", $urutan_kolom_kaji_ulang); 
									$query_kaji_ulang	= 'INSERT INTO kaji_ulang_permintaan VALUES'.$kaji_ulang_baru;
									$CI->kaji_ulang_model->insert_hasil_kaji_ulang_sinkronisasi($query_kaji_ulang);
								}
								
								//------------------------------------------------------olah pengujian_daya_tumbuh---------------------------------------------------------------------------------------------------------//
								$query_daya_tumbuh	= $explode_contents[12]; //query rekom benih
								$array_daya_tumbuh	= explode('INSERT INTO pengujian_daya_tumbuh VALUES',$query_daya_tumbuh);
								$total_array_daya_tumbuh = count($array_daya_tumbuh);
								for($x=1;$x<=$total_array_daya_tumbuh-1;$x++){
									$urutan_kolom_daya_tumbuh 	= explode(',',$array_daya_tumbuh[$x]);
									$induk_kaji_ulang_dy_tmbuh 	= trim($urutan_kolom_daya_tumbuh[3], '"'); //menghilangkan string "" 
									if($induk_kaji_ulang_dy_tmbuh == $id_kaji_ulang_awal){
										$result_max_daya_tumbuh	= $CI->pengujian_daya_tumbuh_model->get_last_id_daya_tumbuh();
										$new_id_daya_tumbuh		= $result_max_daya_tumbuh->row()->ID_UJI_DAYA_TUMBUH+1;
										$new_id_daya_tumbuh		= '("'.$new_id_daya_tumbuh.'"';

										//replace dengan id permohonan baru
										$urutan_kolom_daya_tumbuh[0] = $new_id_daya_tumbuh; //replace dengan id_rekomendasi
										$urutan_kolom_daya_tumbuh[3] = $result_max_kaji_ulang->row()->ID_KAJI_ULANG+1; //replace dengan id permohonan uji

										//gabungkan ulang lagi array terpecah-pecah
										$rekomendasi_baru 	= implode(",", $urutan_kolom_daya_tumbuh); 
										$query_daya_tumbuh	= 'INSERT INTO pengujian_daya_tumbuh VALUES'.$rekomendasi_baru;
										$CI->pengujian_daya_tumbuh_model->insert_hasil_daya_tumbuh_sinkronisasi($query_daya_tumbuh);
									}
								}
								//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
								
								//------------------------------------------------------olah pengujian_kadar_air---------------------------------------------------------------------------------------------------------//
								$query_kadar_air	= $explode_contents[13]; //query pengujian kadar air
								$array_kadar_air	= explode('INSERT INTO pengujian_kadar_air VALUES',$query_kadar_air);
								$total_array_kadar_air = count($array_kadar_air);
								for($x=1;$x<=$total_array_kadar_air-1;$x++){
									$urutan_kolom_kadar_air		= explode(',',$array_kadar_air[$x]);
									$induk_kaji_ulang_kadar_air	= trim($urutan_kolom_kadar_air[3], '"'); //menghilangkan string "" 
									if($induk_kaji_ulang_kadar_air == $id_kaji_ulang_awal){
										$result_max_kadar_air	= $CI->pengujian_kadar_air_model->get_last_id_kadar_air();
										$new_id_kadar_air		= $result_max_kadar_air->row()->ID_UJI_KADAR_AIR+1;
										$new_id_kadar_air		= '("'.$new_id_kadar_air.'"';

										//replace dengan id permohonan baru
										$urutan_kolom_kadar_air[0] = $new_id_kadar_air; //replace dengan id_rekomendasi
										$urutan_kolom_kadar_air[3] = $result_max_kaji_ulang->row()->ID_KAJI_ULANG+1; //replace dengan id permohonan uji

										//gabungkan ulang lagi array terpecah-pecah
										$kadar_air_baru 	= implode(",", $urutan_kolom_kadar_air); 
										$query_kadar_air	= 'INSERT INTO pengujian_kadar_air VALUES'.$kadar_air_baru;
										$CI->pengujian_kadar_air_model->insert_hasil_kadar_air_sinkronisasi($query_kadar_air);
									}
                                                                        echo $query_kadar_air.' '.$x;
								}
								//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

								//------------------------------------------------------olah pengujian_kemurnian_fisik---------------------------------------------------------------------------------------------------------//
								$query_murni_fisik	= $explode_contents[14]; //query kemurnian fisik
								$array_murni_fisik	= explode('INSERT INTO pengujian_kemurnian_fisik VALUES',$query_murni_fisik);
								$total_array_murni_fisik = count($array_murni_fisik);
								for($x=1;$x<=$total_array_murni_fisik-1;$x++){
									$urutan_kolom_uji_fisik 	= explode(',',$array_murni_fisik[$x]);
									$induk_kaji_ulang_fisik  	= trim($urutan_kolom_uji_fisik[2], '"'); //menghilangkan string "" 
									if($induk_kaji_ulang_fisik == $id_kaji_ulang_awal){
										$result_max_murni_fisik	= $CI->pengujian_kemurnian_fisik_model->get_last_id_uji_fisik();
										$new_id_uji_fisik		= $result_max_murni_fisik->row()->ID_UJI_FISIK+1;
										$new_id_uji_fisik		= '("'.$new_id_uji_fisik.'"';

										//replace dengan id permohonan baru
										$urutan_kolom_uji_fisik[0] = $new_id_uji_fisik; //replace dengan id_kemurnian_fisik
										$urutan_kolom_uji_fisik[2] = $result_max_kaji_ulang->row()->ID_KAJI_ULANG+1; //replace dengan id permohonan uji

										//gabungkan ulang lagi array terpecah-pecah
										$uji_fisik_baru 	= implode(",", $urutan_kolom_uji_fisik); 
										$query_murni_fisik	= 'INSERT INTO pengujian_kemurnian_fisik VALUES'.$uji_fisik_baru;
										$CI->pengujian_kemurnian_fisik_model->insert_hasil_uji_fisik_sinkronisasi($query_murni_fisik);
									}
								}
								//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

								//------------------------------------------------------olah pengujian_kemurnian_genetik---------------------------------------------------------------------------------------------------------//
								$query_uji_genetik	= $explode_contents[15]; //query rekom benih
								$array_uji_genetik	= explode('INSERT INTO pengujian_kemurnian_genetik VALUES',$query_uji_genetik);
								$total_array_uji_genetik = count($array_uji_genetik);
								for($x=1;$x<=$total_array_uji_genetik-1;$x++){
									$urutan_kolom_uji_genetik 	= explode(',',$array_uji_genetik[$x]);
									$induk_kaji_ulang_uji_genetik 	= trim($urutan_kolom_uji_genetik[3], '"'); //menghilangkan string "" 
									if($induk_kaji_ulang_uji_genetik == $id_kaji_ulang_awal){
										$result_max_uji_genetik	= $CI->pengujian_kemurnian_genetik_model->get_last_id_uji_genetik();
										$new_id_uji_genetik		= $result_max_uji_genetik->row()->ID_UJI_GENETIK+1;
										$new_id_uji_genetik		= '("'.$new_id_uji_genetik.'"';

										//replace dengan id permohonan baru
										$urutan_kolom_uji_genetik[0] = $new_id_uji_genetik; //replace dengan id_rekomendasi
										$urutan_kolom_uji_genetik[3] = $result_max_kaji_ulang->row()->ID_KAJI_ULANG+1; //replace dengan id permohonan uji

										//gabungkan ulang lagi array terpecah-pecah
										$uji_genetik_baru 	= implode(",", $urutan_kolom_uji_genetik); 
										$query_uji_genetik	= 'INSERT INTO pengujian_kemurnian_genetik VALUES'.$uji_genetik_baru;
										$CI->pengujian_kemurnian_genetik_model->insert_hasil_uji_genetik_sinkronisasi($query_uji_genetik);
									}
                                                                        echo $query_uji_genetik;
								}
								//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------								
							
							}//end looping kaji ulang

							//------------------------------------------------------olah rekomendasi benih---------------------------------------------------------------------------------------------------------//
							$query_rekomendasi	= $explode_contents[10]; //query rekom benih
							$array_rekomendasi	= explode('INSERT INTO rekomendasi_benih VALUES',$query_rekomendasi);
							$total_array_rekomendasi = count($array_rekomendasi);
							for($k=1;$k<=$total_array_rekomendasi-1;$k++){
								$urutan_kolom_rekomendasi 	= explode(',',$array_rekomendasi[$k]);
								$induk_permohonan_uji_rekom = trim($urutan_kolom_rekomendasi[1], '"'); //menghilangkan string "" 
								if($induk_permohonan_uji_rekom == $id_permohonan_uji_awal){
									$result_max_rekomendasi	= $CI->rekomendasi_benih_model->get_last_id_rekomendasi();
									$new_id_rekomendasi		= $result_max_rekomendasi->row()->ID_REKOMENDASI+1;
									$new_id_rekomendasi		= '("'.$new_id_rekomendasi.'"';

									//replace dengan id permohonan baru
									$urutan_kolom_rekomendasi[0] = $new_id_rekomendasi; //replace dengan id_rekomendasi
									$urutan_kolom_rekomendasi[1] = $result_max_uji_lab->row()->ID_PERMOHONAN_UJI+1; //replace dengan id permohonan uji

									//gabungkan ulang lagi array terpecah-pecah
									$rekomendasi_baru 	= implode(",", $urutan_kolom_rekomendasi); 
									$query_rekomendasi	= 'INSERT INTO rekomendasi_benih VALUES'.$rekomendasi_baru;
									$CI->rekomendasi_benih_model->insert_hasil_rekomendasi_sinkronisasi($query_rekomendasi);
								}
							}
							//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	

							//------------------------------------------------------olah konsep label---------------------------------------------------------------------------------------------------------//
							$query_label	= $explode_contents[11]; //query konsep label
							$array_label	= explode('INSERT INTO konsep_label VALUES',$query_label);
							$total_array_label = count($array_label);
							for($k=1;$k<=$total_array_label-1;$k++){
								$urutan_kolom_label			= explode(',',$array_label[$k]);
								$induk_permohonan_uji_label = trim($urutan_kolom_label[1], '"'); //menghilangkan string "" 
								if($induk_permohonan_uji_label == $id_permohonan_uji_awal){
									$result_max_label	= $CI->konsep_label_model->get_last_id_label();
									$new_id_label		= $result_max_label->row()->ID_KONSEP_LABEL+1;
									$new_id_label		= '("'.$new_id_label.'"';

									//replace dengan id permohonan baru
									$urutan_kolom_label[0] 	= $new_id_label; //replace dengan id_rekomendasi
									$urutan_kolom_label[1] 	= $result_max_uji_lab->row()->ID_PERMOHONAN_UJI+1; //replace dengan id permohonan uji

									//gabungkan ulang lagi array terpecah-pecah
									$label_baru 	= implode(",", $urutan_kolom_label); 
									$query_label	= 'INSERT INTO konsep_label VALUES'.$label_baru;
									$CI->konsep_label_model->insert_hasil_label_sinkronisasi($query_label);
								}
							}
							//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------								
						}//end looping permohonan uji lab
					}//end for
					//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------	

					//------------------------------------------------------olah fase tumbuh---------------------------------------------------------------------------------------------------//
					$query_fase_tumbuh		= $explode_contents[5]; //query fase tumbuh
					$array_fase_tumbuh		= explode('INSERT INTO fase_tumbuh VALUES',$query_fase_tumbuh);
					$total_array_fase_tumbh	= count($array_fase_tumbuh);			
					for($j=1;$j<=$total_array_fase_tumbh-1;$j++){
						$urutan_kolom_fase_tumbuh 	= explode(',',$array_fase_tumbuh[$j]);
						$induk_permohonan_fase_tmbh = trim($urutan_kolom_fase_tumbuh[3], '"'); //menghilangkan string "" 
						if($induk_permohonan_fase_tmbh == $induk_permohonan){
						
							//get id fase lapangan
							$id_fase_lapangan_awal = trim(trim($urutan_kolom_fase_tumbuh[0], '('),'"'); //get id-permohonan
						
							//create id fase lapangan baru
							$result_max_fase	= $CI->fase_tumbuh_model->get_last_id_fase_tumbuh();
							$new_id_fase_tmbh 	= $result_max_fase->row()->ID_FASE_LAPANGAN+1;
							$new_id_fase_tmbh	= '("'.$new_id_fase_tmbh.'"';
							
							//replace dengan id permohonan baru
							$urutan_kolom_fase_tumbuh[0] = $new_id_fase_tmbh; //replace dengan id fase_lapangan
							$urutan_kolom_fase_tumbuh[3] = $result_max->row()->ID_PERMOHONAN+1; //replace dengan id permohonan
											
							//gabungkan ulang lagi array terpecah-pecah
							$fase_tumbuh_baru 	= implode(",", $urutan_kolom_fase_tumbuh); 
							$query_fase_tumbuh	= 'INSERT INTO fase_tumbuh VALUES'.$fase_tumbuh_baru;
							$CI->fase_tumbuh_model->insert_fase_tumbuh_sinkronisasi($query_fase_tumbuh);	
							
							//------------------------------------------------------olah sample fase tumbuh---------------------------------------------------------------------------------------------------//
							$query_sample	= $explode_contents[6]; //query sample fase tumbuh
							$array_sample	= explode('INSERT INTO sample VALUES',$query_sample);
							$total_array_sample	= count($array_sample);
							for($k=1;$k<=$total_array_sample-1;$k++){
								$urutan_kolom_sample 	= explode(',',$array_sample[$k]);
								$induk_fase_lapangan 	= trim($urutan_kolom_sample[1], '"'); //menghilangkan string "" 
								if($induk_fase_lapangan == $id_fase_lapangan_awal){
									$result_max_sample	= $CI->sample_model->get_last_id_sample();
									$new_id_sample		= $result_max_sample->row()->ID_SAMPLE+1;
									$new_id_sample		= '("'.$new_id_sample.'"';

									//replace dengan id permohonan baru
									$urutan_kolom_sample[0] = $new_id_sample; //replace dengan id permohonan_uji_lab
									$urutan_kolom_sample[1] = $result_max_fase->row()->ID_FASE_LAPANGAN+1; //replace dengan id permohonan

									//gabungkan ulang lagi array terpecah-pecah
									$sample_baru 	= implode(",", $urutan_kolom_sample); 
									$query_sample	= 'INSERT INTO sample VALUES'.$sample_baru;
									$CI->sample_model->insert_hasil_sample_sinkronisasi($query_sample);
								}
							}
							//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
						}
					}//end for					
					//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					
					//------------------------------------------------------olah siap siar------------------------------------------------------------------------------------------------------//
					$query_siap_siar		= $explode_contents[8]; //query siap siar
					$array_siap_siar		= explode('INSERT INTO siap_siar VALUES',$query_siap_siar);
					$total_array_siap_siar	= count($array_siap_siar);			
					for($j=1;$j<=$total_array_siap_siar-1;$j++){
						$urutan_kolom_siap_siar = explode(',',$array_siap_siar[$j]);
						$induk_permohonan_siap_siar = trim($urutan_kolom_siap_siar[1], '"'); //menghilangkan string "" 
						if($induk_permohonan_siap_siar == $induk_permohonan){
							$result_max_siar	= $CI->siap_siar_model->get_last_id_siap_siar();
							$new_id_siap_siar 	= $result_max_siar->row()->ID_SIAP_SIAR+1;
							$new_id_siap_siar	= '("'.$new_id_siap_siar.'"';			// id_siap siar baru
							
							//replace dengan id permohonan baru
							$urutan_kolom_siap_siar[0] = $new_id_siap_siar; //replace dengan id pengolahan
							$urutan_kolom_siap_siar[1] = $result_max->row()->ID_PERMOHONAN+1; //replace dengan id permohonan
											
							//gabungkan ulang lagi array terpecah-pecah
							$siap_siar_baru 	= implode(",", $urutan_kolom_siap_siar); 
							$query_siap_siar	= 'INSERT INTO siap_siar VALUES'.$siap_siar_baru;
							$CI->siap_siar_model->insert_siap_siar_sinkronisasi($query_siap_siar);
						}
					}//end for					
					//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------						
				
				}//end if
			}//end if
		}//end for

		//------------------------------------------------------olah pengolahan gabungan---------------------------------------------------------------------------------------------------------//
		$query_olah_gabungan	= $explode_contents[16]; 
		$array_olah_gabungan	= explode('INSERT INTO pengolahan_gabungan VALUES',$query_olah_gabungan);
		$total_olah_gabungan	= count($array_olah_gabungan);
		for($j=1;$j<=$total_olah_gabungan-1;$j++){
		
			$urutan_kolom_gabungan	= explode(',',$array_olah_gabungan[$j]);
			$no_lapangan_parent 	= trim($urutan_kolom_gabungan[1], '"'); //get nomor lapangan parent
			$result_ada_no_induk_p	= $CI->pengajuan_sertifikasi_model->get_hasil_dari_no_induk($no_lapangan_parent);
			
			$no_lapangan_child 		= str_replace('");', '', $urutan_kolom_gabungan[2]);
			$no_lapangan_child 		= trim(trim($no_lapangan_child, '"')); //get nomor lapangan child

			$result_ada_no_induk_c	= $CI->pengajuan_sertifikasi_model->get_hasil_dari_no_induk($no_lapangan_child);
			$result_parent			= $CI->pengolahan_gabungan_model->get_all_sesuai_no_induk_child($no_lapangan_child);
			
			if($result_ada_no_induk_p->num_rows() > 0){
				if($result_ada_no_induk_c->num_rows() > 0){
					if ($result_parent->num_rows() == 0){
						$result_max_gabungan	= $CI->pengolahan_gabungan_model->get_last_id_pengolahan();
						$new_id_olah_gabungan	= $result_max_gabungan->row()->id_pengolahan_gabungan+1;
						$new_id_olah_gabungan	= '("'.$new_id_olah_gabungan.'"';

						//replace dengan id permohonan baru
						$urutan_kolom_gabungan[0] 	= $new_id_olah_gabungan; //replace dengan id_rekomendasi
						
						//gabungkan ulang lagi array terpecah-pecah
						$olah_gabungan_baru 	= implode(",", $urutan_kolom_gabungan); 
						$query_olah_gabungan	= 'INSERT INTO pengolahan_gabungan VALUES'.$olah_gabungan_baru;
						$CI->pengolahan_gabungan_model->insert_hasil_pengolahan_sinkronisasi($query_olah_gabungan);
					}
				}
			}
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------		
		
		fclose($file); // close read file
                unlink(realpath('./upload_file/'.$nama_file)); // hapus file setelah sinkronisasi selesai
		
		$explode_nama_file = explode("_",$nama_file);
		$CI->load->model('sinkronisasi_model');
		$data = array(
			'ASAL_SATGAS'	 			=> $explode_nama_file[2], 
			'TANGGAL_SINKRONISASI'	 	=> mdate("%Y-%m-%d %h:%i:%s",time()),
			'JUMLAH_DATA' 				=> $count_data,	
			'NAMA_FILE'	 				=> $nama_file, 
		);			

		//insert log sinkronisasi into database
		$CI->sinkronisasi_model->insert_log_data($data);

                return $total_array_kadar_air;
                } // end else
		//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//	
	}

    /**
	 * Set Image Properties
	 *
	 * Uses GD to determine the width/height/type of image
	 *
	 * @access    public
	 * @param    string
	 * @return    void
	 */    
    function multiple_image_properties($path = ''){
        $CI =& get_instance(); 
        if ( ! $CI->upload->is_image()){
            return false;
        }

        if (function_exists('getimagesize')){
            if (FALSE !== ($D = @getimagesize($path))) {    
                $types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
                $image->width       = $D['0'];
                $image->height      = $D['1'];
                $image->image_type        = ( ! isset($types[$D['2']])) ? 'unknown' : $types[$D['2']];
                
                return $image;
            }
        }
    }
    


	/**
	 * Set an error message
	 *
	 * @access    public
	 * @param    string
	 * @return    void
	 */    
    function set_error($msg){
        $CI =& get_instance();    
        $CI->lang->load('upload');
        
        if (is_array($msg)) {
            foreach ($msg as $val){
                $msg = ($CI->lang->line($val) == FALSE) ? $val : $CI->lang->line($val);                
                $this->error_msg[] = $msg;
                log_message('error', $msg);
            }        
        }
        else{
            $msg = ($CI->lang->line($msg) == FALSE) ? $msg : $CI->lang->line($msg);
            $this->error_msg[] = $msg;
            log_message('error', $msg);
        }
    }
    
  
}
?>

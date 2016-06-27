<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beranda extends CI_Controller 
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->model('e-monev/t_lokasi_model','tlm');
		$this->load->model('e-monev/t_satker_model','tsm');
		$this->load->model('e-monev/d_skmpnen_model','dsm');
		$this->load->model('e-monev/laporan_monitoring_model2','lmm');
		$this->load->model('master_data/unit_model','ru');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	
	function index() {
	    echo "<meta http-equiv=\"refresh\" content=\"0;url=".base_url()."index.php/e-monev/beranda/unit_kerja/".date("n")."\">";
	}
	
	function unit_kerja($bulan) {
		$get_unit = $this->ru->get_all_unit();
		
		
		if($bulan == NULL){
			$bulan = date("n");
		}else{
			$bulan = $this->uri->segment(4);
		}
		
		$no = 1;
		$list_unit = '';
		$total_progres_unit_fisik = 0;
		$total_progres_unit_keuangan = 0;
		$total_satker_unit = 0;
		
		if($get_unit->result() != NULL){
			foreach($get_unit->result() as $baris){
				$propinsi = $this->tlm->get_all_propinsi();

				$total_satker = 0;
				$total_hasil_progres_fisik = 0;
				$total_hasil_progres_keuangan = 0;
				$total_merah_fisik = 0;
				$total_kuning_fisik = 0;
				$total_hijau_fisik = 0;
				$total_biru_fisik = 0;
				$total_merah_keuangan = 0;
				$total_kuning_keuangan = 0;
				$total_hijau_keuangan = 0;
				$total_biru_keuangan = 0;
				if($propinsi->result() != NULL){
					foreach($propinsi->result() as $row){
						if($row->kdlokasi >= 0 && $row->kdlokasi <= 34){

							// hitung merah kuning hijau biru, progres fisik & keuangan
							$satker = $this->tsm->get_satker_by_lokasi_kodeunit($row->kdlokasi, $baris->KDUNIT);
		;
							$total_progres_keuangan = 0;
							$total_progres_fisik = 0;
							$merah_keuangan = 0;
							$kuning_keuangan = 0;
							$hijau_keuangan = 0;
							$biru_keuangan = 0;
							$merah_fisik = 0;
							$kuning_fisik = 0;
							$hijau_fisik = 0;
							$biru_fisik = 0;

							if($satker->result() != NULL){
								foreach($satker->result() as $brs){			

									$skmpnen = $this->dsm->get_skmpnen_by_satker_kodeunit($brs->kdsatker, $baris->KDUNIT);

									$jumlahno = 0;
									$total_bobot_kontrak = 0;
									$total_bobot_keuangan = 0;
									$total_bobot_anggaran = 0;
									$total_keseluruhan_progres_keuangan = 0;
									$total_keseluruhan_progres_fisik = 0;


									if($skmpnen->result() != NULL){
										foreach($skmpnen->result() as $rows){

											$cek_paket = $this->dsm->get_paket($rows->d_skmpnen_id);
											if($cek_paket->result() != NULL){

												// hitung bobot anggaran
												if($cek_paket->row()->paket_pengerjaan == 0){
													// kotraktual
													$kotrak_table = $this->dsm->get_kontrak($rows->d_skmpnen_id);
													if($kotrak_table->result() != NULL){
														foreach($kotrak_table->result() as $row_kontrak){
															$nilai_kontrak = $row_kontrak->nilai_kontrak;
														}
														$total_bobot_kontrak += $nilai_kontrak;
													}else{
														$nilai_kontrak = 0;
													}

													$paket_pengerjaan = $nilai_kontrak;
												}else{
													// sewakelola
													$sewakelola = $this->dsm->sum_sewakelola($brs->kdsatker);
													if($sewakelola->result() != NULL){
														$jumlah = $sewakelola->row()->jumlah;
														$total_bobot_keuangan += $jumlah;
													}else{
														$jumlah = 0;
													}

													$paket_pengerjaan = $jumlah;
												}

												// hitung total bobot anggaran
												$total_bobot_anggaran = $total_bobot_keuangan + $total_bobot_kontrak;
											}
										}
										foreach($skmpnen->result() as $rows){

											$cek_paket = $this->dsm->get_paket($rows->d_skmpnen_id);
											if($cek_paket->result() != NULL){

												// hitung bobot anggaran
												if($cek_paket->row()->paket_pengerjaan == 0){
													// kotraktual
													$data_kotrak_table = $this->dsm->get_kontrak($rows->d_skmpnen_id);
													if($data_kotrak_table->result() != NULL){
														foreach($data_kotrak_table->result() as $row_kontrak){
															$nilai_kontrak = $row_kontrak->nilai_kontrak;
														}
													}else{
														$nilai_kontrak = 0;
													}

													$paket_pengerjaan = $nilai_kontrak;
												}else{
													// sewakelola
													$sewakelola = $this->dsm->sum_sewakelola($brs->kdsatker);
													if($sewakelola->result() != NULL){
														$jumlah = $sewakelola->row()->jumlah;
													}else{
														$jumlah = 0;
													}

													$paket_pengerjaan = $jumlah;
												}

												// hitung progres fisik dan keuangan	
												$progres_fisik = $this->progres_fisik($rows->d_skmpnen_id, $bulan);
												$progres_keuangan = $this->progres_keuangan($rows->d_skmpnen_id, $bulan);

												// hitung progres keseluruhan
												$hasil_progres_keuangan = $paket_pengerjaan / $total_bobot_anggaran * $progres_keuangan;
												$hasil_progres_fisik = $paket_pengerjaan / $total_bobot_anggaran * $progres_fisik;

												// hitung total keseluruhan 
												$total_keseluruhan_progres_keuangan += $hasil_progres_keuangan;
												$total_keseluruhan_progres_fisik += $hasil_progres_fisik;

												$jumlahno++;
											}
										}
									}

									// hitung total progres
									$total_progres_fisik += $total_keseluruhan_progres_fisik;
									$total_progres_keuangan += $total_keseluruhan_progres_keuangan;	
									// filter flag warna (merah kuning hijau biru)
									if($total_keseluruhan_progres_fisik >= 0 && $total_keseluruhan_progres_fisik <= 50 ){
										$merah_fisik += 1;
									}elseif($total_keseluruhan_progres_fisik >= 51 && $total_keseluruhan_progres_fisik <= 75){
										$kuning_fisik += 1;
									}elseif($total_keseluruhan_progres_fisik >= 76 && $total_keseluruhan_progres_fisik <= 100){
										$hijau_fisik += 1;
									}elseif($total_keseluruhan_progres_fisik > 100){
										$biru_fisik += 1;
									}	

									if($total_keseluruhan_progres_keuangan >= 0 && $total_keseluruhan_progres_keuangan <= 50 ){
										$merah_keuangan += 1;
									}elseif($total_keseluruhan_progres_keuangan >= 51 && $total_keseluruhan_progres_keuangan <= 75){
										$kuning_keuangan += 1;
									}elseif($total_keseluruhan_progres_keuangan >= 76 && $total_keseluruhan_progres_keuangan <= 100){
										$hijau_keuangan += 1;
									}elseif($total_keseluruhan_progres_keuangan > 100){
										$biru_keuangan += 1;
									}			
									
								}
							}

							$total_satker += $satker->num_rows();
							$total_hasil_progres_keuangan += $total_progres_keuangan;
							$total_hasil_progres_fisik += $total_progres_fisik;
							$total_merah_fisik += $merah_fisik;
							$total_kuning_fisik += $kuning_fisik;
							$total_hijau_fisik += $hijau_fisik;
							$total_biru_fisik += $biru_fisik;
							$total_merah_keuangan += $merah_keuangan;
							$total_kuning_keuangan += $kuning_keuangan;
							$total_hijau_keuangan += $hijau_keuangan;
							$total_biru_keuangan += $biru_keuangan;
						}
					}
				}

				$list_unit .= '<tr>
						<td width="25">'.$no.'</td>
						<td width="350" align="left"><a href="'.base_url().'index.php/e-monev/beranda/detail_propinsi/'.$bulan.'/'.$baris->KDUNIT.'">'.$baris->NMUNIT.'</a></td>
						<td width="30">'.$total_satker.'</td>
						<td width="90">'.round($total_merah_keuangan).'</td>
						<td width="90">'.round($total_kuning_keuangan).'</td>
						<td width="90">'.round($total_hijau_keuangan).'</td>
						<td width="30">'.round($total_biru_keuangan).'</td>
						<td width="30">'.round($total_hasil_progres_keuangan).'%</td>
						<td width="90">'.round($total_merah_fisik).'</td>
						<td width="90">'.round($total_kuning_fisik).'</td>
						<td width="90">'.round($total_hijau_fisik).'</td>
						<td width="90">'.round($total_biru_fisik).'</td>
						<td width="90">'.round($total_hasil_progres_fisik).'%</td>
						</tr>';
				
				$total_progres_unit_fisik += $total_hasil_progres_fisik;
				$total_progres_unit_keuangan += $total_hasil_progres_keuangan;
				$total_satker_unit += $total_satker;
				
				$no++;
			}
		}else{
			$list_unit .= '<tr>
				<td width="25">&nbsp;</td>
				<td width="350">&nbsp;</td>
				<td width="30">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				</tr>';
		}
		
		$data['list_unit'] = $list_unit;
		$data['total_progres_unit_keuangan'] = $total_progres_unit_keuangan;
		$data['total_progres_unit_fisik'] = $total_progres_unit_fisik;
		$data['total_satker_unit'] = $total_satker_unit;
		$data['get_unit'] = $get_unit;
	    $data['content'] = $this->load->view('e-monev/beranda_unit', $data, true);
		$this->load->view('main',$data);
	}
	
	
	function detail_propinsi($bulan, $kdunit) {
	    $propinsi = $this->tlm->get_all_propinsi();
		
		if($bulan == NULL){
			$bulan = date("n");
		}else{
			$bulan = $this->uri->segment(4);
		}
		
		
		
		$no = 1;
		$total_satker = 0;
		$total_merah_coba_fisik = 0;
		$total_hasil_progres_fisik = 0;
		$total_hasil_progres_keuangan = 0;
		$list_propinsi = '';
		if($propinsi->result() != NULL){
			foreach($propinsi->result() as $row){
				if($row->kdlokasi >= 0 && $row->kdlokasi <= 34){
					
					// hitung merah kuning hijau biru, progres fisik & keuangan
					$satker = $this->tsm->get_satker_by_lokasi_kodeunit($row->kdlokasi, $kdunit);
;
					$total_progres_keuangan = 0;
					$total_progres_fisik = 0;
					$merah_keuangan = 0;
					$kuning_keuangan = 0;
					$hijau_keuangan = 0;
					$biru_keuangan = 0;
					$merah_fisik = 0;
					$kuning_fisik = 0;
					$hijau_fisik = 0;
					$biru_fisik = 0;

					if($satker->result() != NULL){
						foreach($satker->result() as $brs){			

							$skmpnen = $this->dsm->get_skmpnen_by_satker_kodeunit($brs->kdsatker, $kdunit);

							$jumlahno = 0;
							$total_bobot_kontrak = 0;
							$total_bobot_keuangan = 0;
							$total_bobot_anggaran = 0;
							$total_keseluruhan_progres_keuangan = 0;
							$total_keseluruhan_progres_fisik = 0;


							if($skmpnen->result() != NULL){
								foreach($skmpnen->result() as $rows){

									$cek_paket = $this->dsm->get_paket($rows->d_skmpnen_id);
									if($cek_paket->result() != NULL){

										// hitung bobot anggaran
										if($cek_paket->row()->paket_pengerjaan == 0){
											// kotraktual
											$kotrak_table = $this->dsm->get_kontrak($rows->d_skmpnen_id);
											if($kotrak_table->result() != NULL){
												foreach($kotrak_table->result() as $row_kontrak){
													$nilai_kontrak = $row_kontrak->nilai_kontrak;
												}
												$total_bobot_kontrak += $nilai_kontrak;
											}else{
												$nilai_kontrak = 0;
											}

											$paket_pengerjaan = $nilai_kontrak;
										}else{
											// sewakelola
											$sewakelola = $this->dsm->sum_sewakelola($brs->kdsatker);
											if($sewakelola->result() != NULL){
												$jumlah = $sewakelola->row()->jumlah;
												$total_bobot_keuangan += $jumlah;
											}else{
												$jumlah = 0;
											}

											$paket_pengerjaan = $jumlah;
										}

										// hitung total bobot anggaran
										$total_bobot_anggaran = $total_bobot_keuangan + $total_bobot_kontrak;
									}
								}
								foreach($skmpnen->result() as $rows){

									$cek_paket = $this->dsm->get_paket($rows->d_skmpnen_id);
									if($cek_paket->result() != NULL){

										// hitung bobot anggaran
										if($cek_paket->row()->paket_pengerjaan == 0){
											// kotraktual
											$data_kotrak_table = $this->dsm->get_kontrak($rows->d_skmpnen_id);
											if($data_kotrak_table->result() != NULL){
												foreach($data_kotrak_table->result() as $row_kontrak){
													$nilai_kontrak = $row_kontrak->nilai_kontrak;
												}
											}else{
												$nilai_kontrak = 0;
											}

											$paket_pengerjaan = $nilai_kontrak;
										}else{
											// sewakelola
											$sewakelola = $this->dsm->sum_sewakelola($brs->kdsatker);
											if($sewakelola->result() != NULL){
												$jumlah = $sewakelola->row()->jumlah;
											}else{
												$jumlah = 0;
											}

											$paket_pengerjaan = $jumlah;
										}

										// hitung progres fisik dan keuangan	
										$progres_fisik = $this->progres_fisik($rows->d_skmpnen_id, $bulan);
										$progres_keuangan = $this->progres_keuangan($rows->d_skmpnen_id, $bulan);

										// hitung progres keseluruhan
										$hasil_progres_keuangan = $paket_pengerjaan / $total_bobot_anggaran * $progres_keuangan;
										$hasil_progres_fisik = $paket_pengerjaan / $total_bobot_anggaran * $progres_fisik;
										
										// hitung total keseluruhan 
										$total_keseluruhan_progres_keuangan += $hasil_progres_keuangan;
										$total_keseluruhan_progres_fisik += $hasil_progres_fisik;

										

										$jumlahno++;
									}
										//$no++;
								}

								
							}

							// hitung total progres
							$total_progres_fisik += $total_keseluruhan_progres_fisik;
							$total_progres_keuangan += $total_keseluruhan_progres_keuangan;
							
							
							// filter flag warna (merah kuning hijau biru)
							if($total_keseluruhan_progres_fisik >= 0 && $total_keseluruhan_progres_fisik <= 50 ){
								$merah_fisik += 1;
							}elseif($total_keseluruhan_progres_fisik >= 51 && $total_keseluruhan_progres_fisik <= 75){
								$kuning_fisik += 1;
							}elseif($total_keseluruhan_progres_fisik >= 76 && $total_keseluruhan_progres_fisik <= 100){
								$hijau_fisik += 1;
							}elseif($total_keseluruhan_progres_fisik > 100){
								$biru_fisik += 1;
							}	
								
							if($total_keseluruhan_progres_keuangan >= 0 && $total_keseluruhan_progres_keuangan <= 50 ){
								$merah_keuangan += 1;
							}elseif($total_keseluruhan_progres_keuangan >= 51 && $total_keseluruhan_progres_keuangan <= 75){
								$kuning_keuangan += 1;
							}elseif($total_keseluruhan_progres_keuangan >= 76 && $total_keseluruhan_progres_keuangan <= 100){
								$hijau_keuangan += 1;
							}elseif($total_keseluruhan_progres_keuangan > 100){
								$biru_keuangan += 1;
							}			
						}
					}
					
					$list_propinsi .= '<tr>
						<td width="25">'.$no.'</td>
						<td width="350" align="left"><a href="'.base_url().'index.php/e-monev/beranda/detail_satker/'.$row->kdlokasi.'/'.$bulan.'/'.$kdunit.'">'.$row->nmlokasi.'</a></td>
						<td width="30">'.$satker->num_rows().'</td>
						<td width="90">'.round($merah_keuangan).'</td>
						<td width="90">'.round($kuning_keuangan).'</td>
						<td width="90">'.round($hijau_keuangan).'</td>
						<td width="30">'.round($biru_keuangan).'</td>
						<td width="30">'.round($total_progres_keuangan).'%</td>
						<td width="90">'.round($merah_fisik).'</td>
						<td width="90">'.round($kuning_fisik).'</td>
						<td width="90">'.round($hijau_fisik).'</td>
						<td width="90">'.round($biru_fisik).'</td>
						<td width="90">'.round($total_progres_fisik).'%</td>
						</tr>';
					
					$total_merah_coba_fisik += $hijau_fisik;
					$total_satker += $satker->num_rows();
					$total_hasil_progres_keuangan += $total_progres_keuangan;
					$total_hasil_progres_fisik += $total_progres_fisik;
				}
				$no++;
			}
		}else{
			$list_propinsi .= '<tr>
				<td width="25">&nbsp;</td>
				<td width="350">&nbsp;</td>
				<td width="30">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				<td width="90">&nbsp;</td>
				</tr>';
		}
		
		$data['list_propinsi'] = $list_propinsi;
		$data['propinsi_rows'] = $propinsi;
		$data['total_satker'] = $total_satker;
		$data['total_merah_coba_fisik'] = $total_merah_coba_fisik;
		$data['total_hasil_progres_fisik'] = $total_hasil_progres_fisik;
		$data['total_hasil_progres_keuangan'] = $total_hasil_progres_keuangan;
	    $data['content'] = $this->load->view('e-monev/beranda_propinsi', $data, true);
		$this->load->view('main',$data);
	}
	
	function detail_satker($idlokasi, $bulan = null, $kdunit) {
	    $satker = $this->tsm->get_satker_by_lokasi_kodeunit($idlokasi, $kdunit);
	    $data['propinsi'] = $this->tlm->get_propinsi_by_id($idlokasi)->row()->nmlokasi;
		
		if($bulan == NULL){
			$bulan = date("n");
		}else{
			$bulan = $this->uri->segment(5);
		}
		
		$no = 1;
		$list_satker = '';
		$total_progres_keuangan = 0;
		$total_progres_fisik = 0;
		$total_item_semua = 0;
		
		if($satker->result() != NULL){
			foreach($satker->result() as $row){			
				
				$skmpnen = $this->dsm->get_skmpnen_by_satker_kodeunit($row->kdsatker, $kdunit);
				
				$jumlahno = 0;
				$total_bobot_kontrak = 0;
				$total_bobot_keuangan = 0;
				$total_bobot_anggaran = 0;
				$total_keseluruhan_progres_keuangan = 0;
				$total_keseluruhan_progres_fisik = 0;
				$merah_keuangan = 0;
				$kuning_keuangan = 0;
				$hijau_keuangan = 0;
				$biru_keuangan = 0;
				$merah_fisik = 0;
				$kuning_fisik = 0;
				$hijau_fisik = 0;
				$biru_fisik = 0;


				if($skmpnen->result() != NULL){
					foreach($skmpnen->result() as $rows){

						$cek_paket = $this->dsm->get_paket($rows->d_skmpnen_id);
						if($cek_paket->result() != NULL){

							// hitung bobot anggaran
							if($cek_paket->row()->paket_pengerjaan == 0){
								// kotraktual
								$kotrak_table = $this->dsm->get_kontrak($rows->d_skmpnen_id);
								if($kotrak_table->result() != NULL){
									foreach($kotrak_table->result() as $row_kontrak){
										$nilai_kontrak = $row_kontrak->nilai_kontrak;
									}
									$total_bobot_kontrak += $nilai_kontrak;
								}else{
									$nilai_kontrak = 0;
								}

								$paket_pengerjaan = $nilai_kontrak;
							}else{
								// sewakelola
								$sewakelola = $this->dsm->sum_sewakelola($row->kdsatker);
								if($sewakelola->result() != NULL){
									$jumlah = $sewakelola->row()->jumlah;
									$total_bobot_keuangan += $jumlah;
								}else{
									$jumlah = 0;
								}

								$paket_pengerjaan = $jumlah;
							}

							// hitung total bobot anggaran
							$total_bobot_anggaran = $total_bobot_keuangan + $total_bobot_kontrak;
						}
					}
					foreach($skmpnen->result() as $rows){

						$cek_paket = $this->dsm->get_paket($rows->d_skmpnen_id);
						if($cek_paket->result() != NULL){

							// hitung bobot anggaran
							if($cek_paket->row()->paket_pengerjaan == 0){
								// kotraktual
								$data_kotrak_table = $this->dsm->get_kontrak($rows->d_skmpnen_id);
								if($data_kotrak_table->result() != NULL){
									foreach($data_kotrak_table->result() as $row_kontrak){
										$nilai_kontrak = $row_kontrak->nilai_kontrak;
									}
								}else{
									$nilai_kontrak = 0;
								}

								$paket_pengerjaan = $nilai_kontrak;
							}else{
								// sewakelola
								$sewakelola = $this->dsm->sum_sewakelola($row->kdsatker);
								if($sewakelola->result() != NULL){
									$jumlah = $sewakelola->row()->jumlah;
								}else{
									$jumlah = 0;
								}

								$paket_pengerjaan = $jumlah;
							}

							// hitung progres fisik dan keuangan	
							$progres_fisik = $this->progres_fisik($rows->d_skmpnen_id, $bulan);
							$progres_keuangan = $this->progres_keuangan($rows->d_skmpnen_id, $bulan);

							// hitung progres keseluruhan
							$hasil_progres_keuangan = $paket_pengerjaan / $total_bobot_anggaran * $progres_keuangan;
							$hasil_progres_fisik = $paket_pengerjaan / $total_bobot_anggaran * $progres_fisik;

							// hitung total keseluruhan 
							$total_keseluruhan_progres_keuangan += $hasil_progres_keuangan;
							$total_keseluruhan_progres_fisik += $hasil_progres_fisik;

							// filter flag warna (merah kuning hijau biru)
							if($hasil_progres_keuangan >= 0 && $hasil_progres_keuangan <= 50 ){
								$merah_keuangan += 1;
							}elseif($hasil_progres_keuangan >= 51 && $hasil_progres_keuangan <= 75){
								$kuning_keuangan += 1;
							}elseif($hasil_progres_keuangan >= 76 && $hasil_progres_keuangan <= 100){
								$hijau_keuangan += 1;
							}elseif($hasil_progres_keuangan > 100){
								$biru_keuangan += 1;
							}

							if($hasil_progres_fisik >= 0 && $hasil_progres_fisik <= 50 ){
								$merah_fisik += 1;
							}elseif($hasil_progres_fisik >= 51 && $hasil_progres_fisik <= 75){
								$kuning_fisik += 1;
							}elseif($hasil_progres_fisik >= 76 && $hasil_progres_fisik <= 100){
								$hijau_fisik += 1;
							}elseif($hasil_progres_fisik > 100){
								$biru_fisik += 1;
							}

							$jumlahno++;
						}
							//$no++;
					}
				}

				$list_satker .= '<tr>
				<td width="25">'.$no.'</td>
				<td width="350" align="left"><a href="'.base_url().'index.php/e-monev/beranda/detail_paket/'.$row->kdsatker.'/'.$bulan.'/'.$kdunit.'">'.$row->nmsatker.'</td>
				<td width="30">'.$jumlahno.'</td>
				<td width="90">'.round($merah_keuangan).'</td>
				<td width="90">'.round($kuning_keuangan).'</td>
				<td width="90">'.round($hijau_keuangan).'</td>
				<td width="90">'.round($biru_keuangan).'</td>
				<td width="30">'.round($total_keseluruhan_progres_keuangan).'%</td>
				<td width="90">'.round($merah_fisik).'</td>
				<td width="90">'.round($kuning_fisik).'</td>
				<td width="90">'.round($hijau_fisik).'</td>
				<td width="90">'.round($biru_fisik).'</td>
				<td width="90">'.round($total_keseluruhan_progres_fisik).'%</td>
				</tr>';
				
				// hitung total progres
				$total_item_semua += $jumlahno;
				$total_progres_fisik += $total_keseluruhan_progres_fisik;
				$total_progres_keuangan += $total_keseluruhan_progres_keuangan;
				$no++;				
			}
		}else{
				$list_satker .= '<tr>
			<td width="25">&nbsp;</td>
			<td width="350">&nbsp;</td>
			<td width="30">&nbsp;</td>
			<td width="90">&nbsp;</td>
			<td width="90">&nbsp;</td>
			<td width="90">&nbsp;</td>
			<td width="90">&nbsp;</td>
			<td width="90">&nbsp;</td>
			<td width="90">&nbsp;</td>
			<td width="90">&nbsp;</td>
			</tr>';
		}
		
		$data['list_satker'] = $list_satker;
		$data['total_progres_keuangan'] = $total_progres_keuangan;
		$data['total_progres_fisik'] = $total_progres_fisik;
		$data['total_item_semua'] = $total_item_semua;
		$data['satker'] = $satker;
		$data['idlokasi'] = $idlokasi;
	    $data['content'] = $this->load->view('e-monev/beranda_satker', $data, true);
		$this->load->view('main',$data);
	}
	
	
	function detail_paket($idsatker, $bulan, $kdunit) {
	    $data['satkers'] = $this->tsm->get_satker_by_id($idsatker)->row();
	    $skmpnen = $this->dsm->get_skmpnen_by_satker_kodeunit($idsatker, $kdunit);
		
		if($bulan == NULL){
			$bulan = date("n");
		}
	    
	    $no = 1;
	    $jumlahno = 1;
	    $list_paket = '';
	    $total_bobot_kontrak = 0;
	    $total_bobot_keuangan = 0;
	    $total_bobot_anggaran = 0;
	    $total_keseluruhan_progres_keuangan = 0;
	    $total_keseluruhan_ketidaksesuaian_keuangan = 0;
	    $total_keseluruhan_progres_fisik = 0;
	    $total_keseluruhan_ketidaksesuaian_fisik = 0;
		$total_keseluruhan_ketidaksesuaian_fisik_minus = 0;
		$total_keseluruhan_ketidaksesuaian_fisik_plus = 0;
		$total_keseluruhan_ketidaksesuaian_keuangan_plus = 0;
		$total_keseluruhan_ketidaksesuaian_keuangan_minus = 0;
		
        if($skmpnen->result() != NULL){
            foreach($skmpnen->result() as $row){
            
                $cek_paket = $this->dsm->get_paket($row->d_skmpnen_id);
                if($cek_paket->result() != NULL){
                    
                    // hitung bobot anggaran
                    if($cek_paket->row()->paket_pengerjaan == 0){
                        // kotraktual
                        $kotrak_table = $this->dsm->get_kontrak($row->d_skmpnen_id);
                        if($kotrak_table->result() != NULL){
                            foreach($kotrak_table->result() as $row_kontrak){
                                $nilai_kontrak = $row_kontrak->nilai_kontrak;
                            }
                            $total_bobot_kontrak += $nilai_kontrak;
                        }else{
                            $nilai_kontrak = 0;
                        }
                        
                        $paket_pengerjaan = $nilai_kontrak;
                    }else{
                        // sewakelola
                        $sewakelola = $this->dsm->sum_sewakelola($idsatker);
                        if($sewakelola->result() != NULL){
                            $jumlah = $sewakelola->row()->jumlah;
                            $total_bobot_keuangan += $jumlah;
                        }else{
                            $jumlah = 0;
                        }
                        
                        $paket_pengerjaan = $jumlah;
                    }
                    
                    // hitung total bobot anggaran
                    $total_bobot_anggaran = $total_bobot_keuangan + $total_bobot_kontrak;
                }
            }
            foreach($skmpnen->result() as $row){
            
                $cek_paket = $this->dsm->get_paket($row->d_skmpnen_id);
                if($cek_paket->result() != NULL){
                    
                    // hitung bobot anggaran
                    if($cek_paket->row()->paket_pengerjaan == 0){
                        // kotraktual
                        $data_kotrak_table = $this->dsm->get_kontrak($row->d_skmpnen_id);
                        if($data_kotrak_table->result() != NULL){
                            foreach($data_kotrak_table->result() as $row_kontrak){
                                $nilai_kontrak = $row_kontrak->nilai_kontrak;
                            }
                        }else{
                            $nilai_kontrak = 0;
                        }
                        
                        $paket_pengerjaan = $nilai_kontrak;
                    }else{
                        // sewakelola
                        $sewakelola = $this->dsm->sum_sewakelola($idsatker);
                        if($sewakelola->result() != NULL){
                            $jumlah = $sewakelola->row()->jumlah;
                        }else{
                            $jumlah = 0;
                        }
                        
                        $paket_pengerjaan = $jumlah;
                    }
                    
                    // hitung progres fisik dan keuangan	
                    $progres_fisik = $this->progres_fisik($row->d_skmpnen_id, $bulan);
                    $progres_keuangan = $this->progres_keuangan($row->d_skmpnen_id, $bulan);
                    $rencana_fisik = $this->rencana_fisik($row->d_skmpnen_id, $bulan);
                    $rencana_keuangan = $this->rencana_keuangan($row->d_skmpnen_id, $bulan);
                    
                    // hitung progres keseluruhan
                    $hasil_progres_keuangan = $paket_pengerjaan / $total_bobot_anggaran * $progres_keuangan;
                    $hasil_progres_fisik = $paket_pengerjaan / $total_bobot_anggaran * $progres_fisik;
                    
                    // hitung ketidaksesuaian
                    $ketidaksesuaian_fisik = $hasil_progres_fisik - $rencana_fisik;
                    $ketidaksesuaian_keuangan = $hasil_progres_keuangan - $rencana_keuangan;
					
                    $list_paket .= '<tr>
                        <td width="25">'.$no.'</td>
                        <td width="350" align="left">'.$row->urskmpnen.'</td>
                        <td width="90">'.round($hasil_progres_keuangan).'%</td>
                        <td colspan="2" width="90">'.round($ketidaksesuaian_keuangan).'%</td>
                        <td width="90">'.round($hasil_progres_fisik).'%</td>
                        <td colspan="2" width="90">'.round($ketidaksesuaian_fisik).'%</td>
                      </tr>';
                     
                    // hitung total keseluruhan 
                    $total_keseluruhan_progres_keuangan += $hasil_progres_keuangan;
                    $total_keseluruhan_ketidaksesuaian_keuangan += $ketidaksesuaian_keuangan;
                    $total_keseluruhan_progres_fisik += $hasil_progres_fisik;
                    $total_keseluruhan_ketidaksesuaian_fisik += $ketidaksesuaian_fisik;
					
					if($ketidaksesuaian_fisik < 0){
						$total_keseluruhan_ketidaksesuaian_fisik_minus += $ketidaksesuaian_fisik;
					}else{
						$total_keseluruhan_ketidaksesuaian_fisik_plus += $ketidaksesuaian_fisik;
					}
					
					if($ketidaksesuaian_keuangan < 0){
						$total_keseluruhan_ketidaksesuaian_keuangan_minus += $ketidaksesuaian_keuangan;
					}else{
						$total_keseluruhan_ketidaksesuaian_keuangan_plus += $ketidaksesuaian_keuangan;
					}
                    
                    $jumlahno++;
                 }
                 
                 $no++;
            }
        }else{
            $list_paket .= '<tr>
                <td width="25">&nbsp;</td>
                <td width="350">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td colspan="2" width="90">&nbsp;</td>
                <td width="90">&nbsp;</td>
                <td colspan="2" width="90">&nbsp;</td>
              </tr>';
        }
        
        $data['total_keseluruhan_progres_keuangan'] = $total_keseluruhan_progres_keuangan;
        $data['total_keseluruhan_ketidaksesuaian_keuangan'] = $total_keseluruhan_ketidaksesuaian_keuangan;
        $data['total_keseluruhan_ketidaksesuaian_keuangan_plus'] = $total_keseluruhan_ketidaksesuaian_keuangan_plus;
        $data['total_keseluruhan_ketidaksesuaian_keuangan_minus'] = $total_keseluruhan_ketidaksesuaian_keuangan_minus;
        $data['total_keseluruhan_progres_fisik'] = $total_keseluruhan_progres_fisik;
        $data['total_keseluruhan_ketidaksesuaian_fisik'] = $total_keseluruhan_ketidaksesuaian_fisik;
        $data['total_keseluruhan_ketidaksesuaian_fisik_plus'] = $total_keseluruhan_ketidaksesuaian_fisik_plus;
        $data['total_keseluruhan_ketidaksesuaian_fisik_minus'] = $total_keseluruhan_ketidaksesuaian_fisik_minus;
        $data['list_paket'] = $list_paket;
        $data['skmpnen'] = $skmpnen;
        $data['jumlahno'] = $jumlahno;
        $data['idsatker'] = $idsatker;
	    $data['content'] = $this->load->view('e-monev/beranda_paket', $data, true);
		$this->load->view('main',$data);
	}
	
	function progres_fisik($skmpnen_id, $bulan) {
	    $progres_fisik = 0;
	    if($skmpnen_id != NULL){
	        if($this->lmm->get_progres_by_bulan($skmpnen_id, $bulan)->num_rows() > 0){
					foreach($this->lmm->get_progres_by_bulan($skmpnen_id, $bulan)->result() as $row_progres_fisik){
						$progres_fisik = $row_progres_fisik->fisik + $progres_fisik;
					}
			}else{
				$progres_fisik = '0';
			}
		}else{
		    $progres_fisik = '0';
		}
		
		return $progres_fisik;
	}    
				
	function progres_keuangan($skmpnen_id, $bulan) {	
		$progres_keuangan = 0;
	    if($skmpnen_id != NULL){
	    	if($this->lmm->get_spm_by_bulan($skmpnen_id, $bulan)->num_rows() > 0){
				foreach($this->lmm->get_spm_by_bulan($skmpnen_id, $bulan)->result() as $row_progres_keuangan){
					$progres_keuangan = $row_progres_keuangan->keuangan + $progres_keuangan;
				}
					
			}else{
				$progres_keuangan = '0';
			}
		}else{
		    $progres_keuangan = '0';
		}
		
		return $progres_keuangan;
	} 
	
	function rencana_fisik($skmpnen_id, $bulan) {
	    $rencana_fisik = 0;
	    if($skmpnen_id != NULL){
	        if($this->lmm->get_rencana2($skmpnen_id, $bulan)->num_rows() > 0){
					foreach($this->lmm->get_rencana2($skmpnen_id, $bulan)->result() as $row_rencana_fisik){
						$rencana_fisik = $row_rencana_fisik->fisik + $rencana_fisik;
					}
			}else{
				$rencana_fisik = '0';
			}
		}else{
		    $rencana_fisik = '0';
		}
		
		return $rencana_fisik;
	}  
	
	function rencana_keuangan($skmpnen_id, $bulan) {
	    $rencana_keuangan = 0;
	    if($skmpnen_id != NULL){
	        if($this->lmm->get_rencana2($skmpnen_id, $bulan)->num_rows() > 0){
					foreach($this->lmm->get_rencana2($skmpnen_id, $bulan)->result() as $row_rencana_keuangan){
						$rencana_keuangan = $row_rencana_keuangan->keuangan + $rencana_keuangan;
					}
			}else{
				$rencana_keuangan = '0';
			}
		}else{
		    $rencana_keuangan = '0';
		}
		
		return $rencana_keuangan;
	} 
	

}//end class

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */

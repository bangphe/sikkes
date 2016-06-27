<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class utility extends CI_Controller 
{

	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->library('session');;
		$this->load->library('flexigrid');
		$this->load->library('excel');   
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->helper('flexigrid');
		$this->load->library('Spreadsheet_Excel_Reader');
		$this->load->helper('url');
		$this->load->model('e-planning/Utility_model', 'umo');
		$this->load->model('e-planning/manajemen_model', 'mm');
		$this->load->model('e-planning/master_model', 'masmo');
		$this->load->model('e-planning/Pendaftaran_model','pm');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	function cetak_pengusulan(){
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/daftar_pengusulan.xlsx');
		$this->excel->setActiveSheetIndex(0);
		$no=1;
		$index=7;
		foreach($this->mm->get_cetak()->result() as $row){
			$this->excel->getActiveSheet()->getStyle('A'.$index.':D'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->mergeCells('B'.$index.':D'.$index);
			$this->excel->getActiveSheet()->getStyle('B'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->JUDUL_PROPOSAL);
			$this->excel->getActiveSheet()->setCellValue('F'.$index, $this->mm->sum('data_program','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN));
			$index++;
			foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
				$this->excel->getActiveSheet()->mergeCells('B'.$index.':D'.$index);
				$this->excel->getActiveSheet()->setCellValue('B'.$index,$row2->NamaFungsi);
				$index++;
				foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
					$this->excel->getActiveSheet()->mergeCells('B'.$index.':D'.$index);
					$this->excel->getActiveSheet()->setCellValue('B'.$index,$row3->NamaSubFungsi);
					$index++;
					foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
						$this->excel->getActiveSheet()->mergeCells('B'.$index.':D'.$index);
						$this->excel->getActiveSheet()->setCellValue('B'.$index,$row4->NamaProgram);
						$this->excel->getActiveSheet()->setCellValue('F'.$index, $row4->Biaya);
						$index++;
						foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
							$this->excel->getActiveSheet()->mergeCells('C'.$index.':D'.$index);
							$this->excel->getActiveSheet()->setCellValue('C'.$index,$row5->Iku);
							$this->excel->getActiveSheet()->setCellValue('E'.$index, $row5->Jumlah);
							$index++;
							foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
								$this->excel->getActiveSheet()->mergeCells('C'.$index.':D'.$index);
								$this->excel->getActiveSheet()->setCellValue('C'.$index,$row6->NamaKegiatan);
								$this->excel->getActiveSheet()->setCellValue('F'.$index, $row6->Biaya);
								$index++;
								foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
									$this->excel->getActiveSheet()->setCellValue('D'.$index,$row7->Ikk);
									$this->excel->getActiveSheet()->setCellValue('E'.$index, $row7->Jumlah);
									$index++;
								}
							}
						}
					}
				}
			}
			$no++;
		}
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="daftar pengusulan.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	function cetak_pengusulan2($KD_PENGAJUAN){
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/daftar_pengusulan.xlsx');
		$this->excel->setActiveSheetIndex(0);
		$no=1;
		$index=7;
		$judul = "";
		foreach($this->mm->get_where('pengajuan','KD_PENGAJUAN',$KD_PENGAJUAN)->result() as $row){
			$this->excel->getActiveSheet()->getStyle('A'.$index.':D'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->mergeCells('B'.$index.':D'.$index);
			$this->excel->getActiveSheet()->getStyle('B'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->JUDUL_PROPOSAL);
			$judul = $row->JUDUL_PROPOSAL;
			$this->excel->getActiveSheet()->setCellValue('F'.$index, $this->mm->sum('data_program','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN));
			$index++;
			foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
				$this->excel->getActiveSheet()->mergeCells('B'.$index.':D'.$index);
				$this->excel->getActiveSheet()->setCellValue('B'.$index,$row2->NamaFungsi);
				$index++;
				foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
					$this->excel->getActiveSheet()->mergeCells('B'.$index.':D'.$index);
					$this->excel->getActiveSheet()->setCellValue('B'.$index,$row3->NamaSubFungsi);
					$index++;
					foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
						$this->excel->getActiveSheet()->mergeCells('B'.$index.':D'.$index);
						$this->excel->getActiveSheet()->setCellValue('B'.$index,$row4->NamaProgram);
						$this->excel->getActiveSheet()->setCellValue('F'.$index, $row4->Biaya);
						$index++;
						foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
							$this->excel->getActiveSheet()->mergeCells('C'.$index.':D'.$index);
							$this->excel->getActiveSheet()->setCellValue('C'.$index,$row5->Iku);
							$this->excel->getActiveSheet()->setCellValue('E'.$index, $row5->Jumlah);
							$index++;
							foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
								$this->excel->getActiveSheet()->mergeCells('C'.$index.':D'.$index);
								$this->excel->getActiveSheet()->setCellValue('C'.$index,$row6->NamaKegiatan);
								$this->excel->getActiveSheet()->setCellValue('F'.$index, $row6->Biaya);
								$index++;
								foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
									$this->excel->getActiveSheet()->setCellValue('D'.$index,$row7->Ikk);
									$this->excel->getActiveSheet()->setCellValue('E'.$index, $row7->Jumlah);
									$index++;
								}
							}
						}
					}
				}
			}
			$no++;
		}
        
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$judul.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	function cetak_rab($KD_PENGAJUAN){
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/cetak/RAB.xlsx');
		$this->excel->setActiveSheetIndex(0);
		$no=1;
		$index=6;
		$total = 0;
		$judul = $this->umo->get_where('pengajuan','KD_PENGAJUAN',$KD_PENGAJUAN)->row()->JUDUL_PROPOSAL;
		$this->excel->getActiveSheet()->setCellValue('A2', $judul);
		foreach($this->umo->get('ref_jenis_usulan')->result() as $row){
			$this->excel->getActiveSheet()->getStyle('A'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('B'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('C'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('D'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('F'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('G'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('H'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('I'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('J'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('J'.$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->JenisUsulan);
			$this->excel->getActiveSheet()->getStyle('G'.$index)->getNumberFormat()->setFormatCode('#,##0');
			$this->excel->getActiveSheet()->setCellValue('G'.$index, $this->umo->sum2('aktivitas','Jumlah','KodeJenisUsulan',$row->KodeJenisUsulan,'KD_PENGAJUAN',$KD_PENGAJUAN));
			$total = $total + $this->umo->sum2('aktivitas','Jumlah','KodeJenisUsulan',$row->KodeJenisUsulan,'KD_PENGAJUAN',$KD_PENGAJUAN);
			$index++;
			foreach($this->umo->get_where2_join2('aktivitas','KD_PENGAJUAN',$KD_PENGAJUAN,'KodeJenisUsulan',$row->KodeJenisUsulan,'ref_satuan','aktivitas.KodeSatuan=ref_satuan.KodeSatuan','ref_jenis_pembiayaan','aktivitas.KodeJenisPembiayaan=ref_jenis_pembiayaan.KodeJenisPembiayaan')->result() as $row2){
				$this->excel->getActiveSheet()->getStyle('D'.$index)->getNumberFormat()->setFormatCode('#,##0');
				$this->excel->getActiveSheet()->getStyle('F'.$index)->getNumberFormat()->setFormatCode('#,##0');
				$this->excel->getActiveSheet()->getStyle('G'.$index)->getNumberFormat()->setFormatCode('#,##0');
				$this->excel->getActiveSheet()->setCellValue('B'.$index, '- '.$row2->JudulUsulan);
				$this->excel->getActiveSheet()->setCellValue('C'.$index, $row2->Perincian);
				$this->excel->getActiveSheet()->setCellValue('D'.$index, $row2->Volume);
				$this->excel->getActiveSheet()->setCellValue('E'.$index, $row2->Satuan);
				$this->excel->getActiveSheet()->setCellValue('F'.$index, $row2->HargaSatuan);
				$this->excel->getActiveSheet()->setCellValue('G'.$index, $row2->Jumlah);
				$this->excel->getActiveSheet()->setCellValue('H'.$index, $row2->JenisPembiayaan);
				$index2=$index;
				$index3=$index;
				if($this->mm->cek('fp_aktivitas', 'KodeAktivitas',$row2->KodeAktivitas) == false){
					$this->excel->getActiveSheet()->getStyle('A'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('B'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('C'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('D'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('F'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('G'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('H'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('I'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('J'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('J'.$index2)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->setCellValue('I'.$index2,'');
					
					$index2++;
				}
				else{
				foreach($this->umo->get_where_join('fp_aktivitas','KodeAktivitas',$row2->KodeAktivitas,'fokus_prioritas','fp_aktivitas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas')->result() as $row3){
					$this->excel->getActiveSheet()->getStyle('A'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('B'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('C'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('D'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('F'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('G'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('H'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('I'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('J'.$index2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('J'.$index2)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->setCellValue('I'.$index2,$row3->FokusPrioritas);
					
					$index2++;
				}
				}
				if($this->mm->cek('rk_aktivitas', 'KodeAktivitas',$row2->KodeAktivitas) == false){
					$this->excel->getActiveSheet()->getStyle('A'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('B'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('C'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('D'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('F'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('G'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('H'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('I'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('J'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('J'.$index3)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->setCellValue('J'.$index3,'');
					
					$index3++;
				}
				else{
				foreach($this->umo->get_where_join('rk_aktivitas','KodeAktivitas',$row2->KodeAktivitas,'reformasi_kesehatan','rk_aktivitas.idReformasiKesehatan=reformasi_kesehatan.idReformasiKesehatan')->result() as $row4){
					$this->excel->getActiveSheet()->getStyle('A'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('B'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('C'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('D'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('F'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('G'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('H'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('I'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('J'.$index3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('J'.$index3)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->setCellValue('J'.$index3,$row4->ReformasiKesehatan);
					
					$index3++;
				}
				}
				if($index3>$index2) $index=$index3; else $index=$index2;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('B'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('C'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('D'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('F'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('G'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('H'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('I'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('J'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('J'.$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$index++;
			$no++;
		}
		$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('B'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('B'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('C'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('D'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('F'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('G'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('H'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('I'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('J'.$index)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('J'.$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$this->excel->getActiveSheet()->getStyle('G'.$index)->getNumberFormat()->setFormatCode('#,##0');
		$this->excel->getActiveSheet()->setCellValue('B'.$index, 'Jumlah');
		$this->excel->getActiveSheet()->setCellValue('G'.$index, $total);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="RAB Proposal - '.$KD_PENGAJUAN.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	function load_rekap(){
		$data['judul'] = 'Rekap';
		$option_tahun_anggaran;
		foreach($this->mm->get('ref_tahun_anggaran')->result() as $row){
			$option_tahun_anggaran[$row->thn_anggaran] = $row->thn_anggaran;
		}
		$data['thn_anggaran'] = $option_tahun_anggaran;
		$data['content'] = $this->load->view('e-planning/rekap',$data,true);
		$this->load->view('main',$data);
	}
	
	function rekap(){
		$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
		$this->load->library('excel');    
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/rekap.xlsx');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setCellValue('A1', 'REKAPITULASI USULAN PROPOSAL TAHUN '.$TAHUN_ANGGARAN);
		$this->excel->getActiveSheet()->setCellValue('A3', 'NO')
									  ->setCellValue('B3', 'SATKER PENGUSUL')
									  ->setCellValue('C3', 'NO/TGL SURAT PENGANTAR')
									  ->setCellValue('D3', 'PROGRAM')
									  ->setCellValue('E3', 'INDIKATOR KINERJA UTAMA (IKU)')
									  ->setCellValue('F3', 'KEGIATAN')
									  ->setCellValue('G3', 'INDIKATOR KINERJA KEGIATAN (IKK)')
									  ->setCellValue('H3', 'TARGET KINERJA')
									  ->setCellValue('I3', 'USULAN')
									  ->setCellValue('I4', 'APBN')
									  ->setCellValue('J4', 'DAK');
		$no=1;
		$index=5;
		foreach($this->mm->get_where2_join('pengajuan','TAHUN_ANGGARAN',$TAHUN_ANGGARAN,'STATUS','1','ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER')->result() as $row){
			$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C'.$index.':J'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);
			$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
			$this->excel->getActiveSheet()->setCellValue('C'.$index, $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
			$this->excel->getActiveSheet()->setCellValue('H'.$index, $row->nmsatker);
			if($row->ID_RENCANA_ANGGARAN == '1'){
				$this->excel->getActiveSheet()->setCellValue('I'.$index, 'V');
			}else{
				$this->excel->getActiveSheet()->setCellValue('J'.$index, 'V');
			}
			$index++;
			$index2 = $index;
			$index3 = $index;
			foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
				foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
					foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
						$this->excel->getActiveSheet()->setCellValue('D'.$index, $row4->NamaProgram);
						foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
							$this->excel->getActiveSheet()->setCellValue('E'.$index2, $row5->Iku);
							$index2++;
						}
						foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
							$this->excel->getActiveSheet()->setCellValue('F'.$index3, $row6->NamaKegiatan);
							foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
								$this->excel->getActiveSheet()->setCellValue('G'.$index3, $row7->Ikk);
								$index3++;
							}
						}
						if($index3>=$index2){
							$index=$index3;
						}else{
							$index=$index2;
						}
					}
				}
			}
			$no++;
		}
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DAFTAR PENGAJUAN '.$TAHUN_ANGGARAN.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	// function rekap_fokus_prioritas()
	// {
	// 	$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
	// 	$pilihan_rekap = $this->input->post('rekap');
		
	// 	$this->load->library('excel');    
	// 	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	// 	$this->excel = $objReader->load('file/rekap_fokus_prioritas.xlsx');
	// 	$this->excel->setActiveSheetIndex(0);
	// 	$this->excel->getActiveSheet()->setCellValue('A1', 'REKAPITULASI USULAN PROPOSAL BERDASARKAN FOKUS PRIORITAS TAHUN '.$TAHUN_ANGGARAN);
	// 	$this->excel->getActiveSheet()->setCellValue('A3', 'NO')
	// 								  ->setCellValue('B3', 'SATKER PENGUSUL')
	// 								  ->setCellValue('C3', 'KAB/KOTA')
	// 								  ->setCellValue('D3', 'JUDUL PROPOSAL AKTIVITAS')
	// 								  ->setCellValue('E3', 'NO/TGL SURAT PENGANTAR')
	// 								  ->setCellValue('F3', 'PROGRAM')
	// 								  ->setCellValue('G3', 'INDIKATOR KINERJA UTAMA (IKU)')
	// 								  ->setCellValue('H3', 'KEGIATAN')
	// 								  ->setCellValue('I3', 'INDIKATOR KINERJA KEGIATAN (IKK)')
	// 								  ->setCellValue('J3', 'TARGET KINERJA NASIONAL')
	// 								  ->setCellValue('K3', 'TARGET KINERJA DAERAH')
	// 								  ->setCellValue('L3', 'USULAN')
	// 								  ->setCellValue('L4', 'Fokus 1. Peningkatan')
	// 								  ->setCellValue('M4', 'Fokus 2. Perbaikan')
	// 								  ->setCellValue('N4', 'Fokus 3. Pengendalian')
	// 								  ->setCellValue('O4', 'Fokus 4. Pemenuhan')
	// 								  ->setCellValue('P4', 'Fokus 5. Peningkatan')
	// 								  ->setCellValue('Q4', 'Fokus 6. Pengembangan')
	// 								  ->setCellValue('R4', 'Fokus 7. Pemberdayaan')
	// 								  ->setCellValue('S4', 'Fokus 8. Peningkatan');

	// 	$no=1;
	// 	$index=5;
		
	// 	foreach($this->mm->get_where2_join('pengajuan','TAHUN_ANGGARAN',$TAHUN_ANGGARAN,'STATUS','1','ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER')->result() as $row){
	// 		$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		$this->excel->getActiveSheet()->getStyle('C'.$index.':J'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		//$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
	// 		$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
	// 		$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);

	// 		foreach($this->mm->get_where2_join('ref_satker','kdlokasi',$row->kdlokasi,'kdsatker',$row->kdsatker,'ref_kabupaten','ref_kabupaten.KodeKabupaten=ref_satker.kdkabkota')->result() as $tes){
	// 			foreach($this->mm->get_where2('ref_kabupaten','KodeProvinsi',$tes->kdlokasi,'KodeKabupaten',$tes->kdkabkota)->result() as $tes2)			
	// 			$this->excel->getActiveSheet()->setCellValue('C'.$index, $tes2->NamaKabupaten);			
	// 		}
	// 		$this->excel->getActiveSheet()->setCellValue('D'.$index, $row->JUDUL_PROPOSAL);			
	// 		$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
	// 		$this->excel->getActiveSheet()->setCellValue('E'.$index, $row->NOMOR_SURAT.'/'.$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
	// 		/*if($row->ID_RENCANA_ANGGARAN == '1'){
	// 			$this->excel->getActiveSheet()->setCellValue('I'.$index, 'V');
	// 		}else{
	// 			$this->excel->getActiveSheet()->setCellValue('J'.$index, 'V');
	// 		}*/
	// 		//$index++;
	// 		$index2 = $index;
	// 		$index3 = $index;
	// 		foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
	// 			foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
	// 				foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
	// 					$this->excel->getActiveSheet()->setCellValue('F'.$index2, $row4->NamaProgram);
	// 					foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
	// 						$this->excel->getActiveSheet()->setCellValue('G'.$index2, $row5->Iku);
	// 						$index2++;
	// 					}
	// 					foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
	// 						$this->excel->getActiveSheet()->setCellValue('H'.$index3, $row6->NamaKegiatan);
	// 						$n=0;
	// 							$biaya;
	// 							foreach($this->pm->get('fokus_prioritas')->result() as $fok)
	// 							{
	// 								if($this->mm->cek2('data_fokus_prioritas', 'idFokusPrioritas', $fok->idFokusPrioritas, 'KD_PENGAJUAN', $row->KD_PENGAJUAN)) {
	// 								$biaya[$n] = $this->pm->get_biaya('data_fokus_prioritas','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN,'idFokusPrioritas',$fok->idFokusPrioritas);
	// 								}
	// 								else $biaya[$n]='0';
	// 								$n++;
	// 							}
								
	// 							$this->excel->getActiveSheet()->setCellValue('L'.$index3, "Rp.".$biaya[0]); 
	// 							$this->excel->getActiveSheet()->setCellValue('M'.$index3, "Rp.".$biaya[1]);
	// 							$this->excel->getActiveSheet()->setCellValue('N'.$index3, "Rp.".$biaya[2]);
	// 							$this->excel->getActiveSheet()->setCellValue('O'.$index3, "Rp.".$biaya[3]);
	// 							$this->excel->getActiveSheet()->setCellValue('P'.$index3, "Rp.".$biaya[4]); 
	// 							$this->excel->getActiveSheet()->setCellValue('Q'.$index3, "Rp.".$biaya[5]); 
	// 							$this->excel->getActiveSheet()->setCellValue('R'.$index3, "Rp.".$biaya[6]);  
	// 							$this->excel->getActiveSheet()->setCellValue('S'.$index3, "Rp.".$biaya[7]);
								
	// 							if($this->mm->cek('data_fokus_prioritas','KD_PENGAJUAN',$row->KD_PENGAJUAN)) 
	// 							$total = $this->mm->sum('data_fokus_prioritas','Biaya','KD_PENGAJUAN',$row->KD_PENGAJUAN);
	// 							else $total = 0;
	// 							$this->excel->getActiveSheet()->setCellValue('T'.$index3, "Rp.".$total);
	// 						foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
	// 							$this->excel->getActiveSheet()->setCellValue('I'.$index3, $row7->Ikk);
	// 							if($this->mm->cek('target_ikk','KodeIkk',$row7->KodeIkk))
	// 							$target_nasional = $this->mm->get_where('target_ikk','KodeIkk',$row7->KodeIkk)->row()->TargetNasional;
	// 							else $target_nasional = '0';
	// 								$this->excel->getActiveSheet()->setCellValue('J'.$index3, $target_nasional.'%');
	// 							$jumlah_ikk = $this->mm->get_where('data_ikk','KodeIkk',$row7->KodeIkk)->row()->Jumlah;
	// 								$this->excel->getActiveSheet()->setCellValue('K'.$index3, $jumlah_ikk.'%');
								
	// 							$index3++;
	// 						}
							
	// 					}
						
	// 					if($index3>=$index2){
	// 						$index=$index3;
	// 					}else{
	// 						$index=$index2;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$no++;
	// 	}
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //        header('Content-Disposition: attachment;filename="DAFTAR PENGAJUAN '.$TAHUN_ANGGARAN.'.xlsx"');
 //        header('Cache-Control: max-age=0');

 //        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
 //        $objWriter->save('php://output');
	// }

	function rekap_fokus_prioritas() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thn = $this->input->post('thn_anggaran');
		$records = $this->mm->cetak_fokus_prioritas_reformasi_kesehatan($thn);
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/cetak_fokus_prioritas.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Rekap Proposal Tahun Anggaran '.$thn); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no = 0;
		$awal_baris = 7; //awal baris
		$baris = $awal_baris;

		if($records->num_rows()>0){
			foreach($records->result() as $row){
				$no = $no + 1;

				$tgl_asli = $row->TANGGAL_PEMBUATAN;
				$tgl = date("d-m-Y", strtotime($tgl_asli));

				//SetCellValue
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $row->NamaProvinsi);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $row->nmsatker);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $row->JUDUL_PROPOSAL);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $row->NOMOR_SURAT);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, '['.$row->KodeProgram.'] '.$row->NamaProgram);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, '['.$row->KodeKegiatan.'] '.$row->NamaKegiatan);
				$n=0;
				$biaya;
				foreach($this->pm->get('fokus_prioritas')->result() as $fok)
				{
					if($this->mm->cek2('data_fokus_prioritas', 'idFokusPrioritas', $fok->idFokusPrioritas, 'KD_PENGAJUAN', $row->KD_PENGAJUAN)) {
					$biaya[$n] = $this->pm->get_biaya('data_fokus_prioritas','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN,'idFokusPrioritas',$fok->idFokusPrioritas);
					}
					else $biaya[$n]='0';
					$n++;
				}
				
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, "Rp.".number_format($biaya[0],2)); 
				$this->excel->getActiveSheet()->setCellValue('I'.$baris, "Rp.".number_format($biaya[1],2));
				$this->excel->getActiveSheet()->setCellValue('J'.$baris, "Rp.".number_format($biaya[2],2));
				$this->excel->getActiveSheet()->setCellValue('K'.$baris, "Rp.".number_format($biaya[3],2));
				$this->excel->getActiveSheet()->setCellValue('L'.$baris, "Rp.".number_format($biaya[4],2)); 
				$this->excel->getActiveSheet()->setCellValue('M'.$baris, "Rp.".number_format($biaya[5],2)); 
				$this->excel->getActiveSheet()->setCellValue('N'.$baris, "Rp.".number_format($biaya[6],2));  
				$this->excel->getActiveSheet()->setCellValue('O'.$baris, "Rp.".number_format($biaya[7],2));
				$this->excel->getActiveSheet()->setCellValue('P'.$baris, "Rp.".number_format($biaya[8],2));
				
				if($this->mm->cek('data_fokus_prioritas','KD_PENGAJUAN',$row->KD_PENGAJUAN))
					$biaya_total = $this->mm->sum('data_fokus_prioritas','Biaya','KD_PENGAJUAN',$row->KD_PENGAJUAN);
				else 
					$biaya_total=0;
				$this->excel->getActiveSheet()->setCellValue('Q'.$baris, "Rp. ".number_format($biaya_total,2));
				$baris++;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':Q'.($baris-1))->getBorders()->getInside()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':Q'.($baris-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':Q'.($baris-1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':Q'.($baris-1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Pengajuan Proposal Fokus Prioritas.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	// function rekap_reformasi_kesehatan()
	// {
	// 	$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
	// 	$pilihan_rekap = $this->input->post('rekap');
		
	// 	$this->load->library('excel');    
	// 	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	// 	$this->excel = $objReader->load('file/rekap_reformasi_kesehatan.xlsx');
	// 	$this->excel->setActiveSheetIndex(0);
	// 	$this->excel->getActiveSheet()->setCellValue('A1', 'REKAPITULASI USULAN PROPOSAL BERDASARKAN REFORMASI KESEHATAN TAHUN '.$TAHUN_ANGGARAN);
	// 	$this->excel->getActiveSheet()->setCellValue('A3', 'NO')
	// 								  ->setCellValue('B3', 'SATKER PENGUSUL')
	// 								  ->setCellValue('C3', 'KAB/KOTA')
	// 								  ->setCellValue('D3', 'JUDUL PROPOSAL AKTIVITAS')
	// 								  ->setCellValue('E3', 'NO/TGL SURAT PENGANTAR')
	// 								  ->setCellValue('F3', 'PROGRAM')
	// 								  ->setCellValue('G3', 'INDIKATOR KINERJA UTAMA (IKU)')
	// 								  ->setCellValue('H3', 'KEGIATAN')
	// 								  ->setCellValue('I3', 'INDIKATOR KINERJA KEGIATAN (IKK)')
	// 								  ->setCellValue('J3', 'TARGET KINERJA NASIONAL')
	// 								  ->setCellValue('K3', 'TARGET KINERJA DAERAH')
	// 								  ->setCellValue('L3', 'USULAN')
	// 								  ->setCellValue('L4', 'Reform 1. Pengembangan')
	// 								  ->setCellValue('M4', 'Reform 2. Peningkatan')
	// 								  ->setCellValue('N4', 'Reform 3. Ketersediaan')
	// 								  ->setCellValue('O4', 'Reform 4. Reformasi')
	// 								  ->setCellValue('P4', 'Reform 5. Pemenuhan')
	// 								  ->setCellValue('Q4', 'Reform 6. Penanganan')
	// 								  ->setCellValue('R4', 'Reform 7. Pengembangan');

	// 	$no=1;
	// 	$index=5;
		
	// 	foreach($this->mm->get_where2_join('pengajuan','TAHUN_ANGGARAN',$TAHUN_ANGGARAN,'STATUS','1','ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER')->result() as $row){
	// 		$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		$this->excel->getActiveSheet()->getStyle('C'.$index.':J'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		//$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
	// 		$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
	// 		$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);

	// 		foreach($this->mm->get_where2_join('ref_satker','kdlokasi',$row->kdlokasi,'kdsatker',$row->kdsatker,'ref_kabupaten','ref_kabupaten.KodeKabupaten=ref_satker.kdkabkota')->result() as $tes){
	// 			foreach($this->mm->get_where2('ref_kabupaten','KodeProvinsi',$tes->kdlokasi,'KodeKabupaten',$tes->kdkabkota)->result() as $tes2)			
	// 			$this->excel->getActiveSheet()->setCellValue('C'.$index, $tes2->NamaKabupaten);			
	// 		}
	// 		$this->excel->getActiveSheet()->setCellValue('D'.$index, $row->JUDUL_PROPOSAL);			
	// 		$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
	// 		$this->excel->getActiveSheet()->setCellValue('E'.$index, $row->NOMOR_SURAT.'/'.$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
	// 		/*if($row->ID_RENCANA_ANGGARAN == '1'){
	// 			$this->excel->getActiveSheet()->setCellValue('I'.$index, 'V');
	// 		}else{
	// 			$this->excel->getActiveSheet()->setCellValue('J'.$index, 'V');
	// 		}*/
	// 		//$index++;
	// 		$index2 = $index;
	// 		$index3 = $index;
	// 		foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
	// 			foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
	// 				foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
	// 					$this->excel->getActiveSheet()->setCellValue('F'.$index2, $row4->NamaProgram);
	// 					foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
	// 						$this->excel->getActiveSheet()->setCellValue('G'.$index2, $row5->Iku);
	// 						$index2++;
	// 					}
	// 					foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
	// 						$this->excel->getActiveSheet()->setCellValue('H'.$index3, $row6->NamaKegiatan);
							
	// 							$n=0;
	// 							$biaya;
	// 							foreach($this->pm->get('reformasi_kesehatan')->result() as $ref)
	// 							{
	// 								if($this->mm->cek2('data_reformasi_kesehatan', 'idReformasiKesehatan', $ref->idReformasiKesehatan, 'KD_PENGAJUAN', $row->KD_PENGAJUAN)) {
	// 								$biaya[$n] = $this->pm->get_biaya('data_reformasi_kesehatan','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN,'idReformasiKesehatan',$ref->idReformasiKesehatan);
	// 								}
	// 								else $biaya[$n]='0';
	// 								$n++;
	// 							}
								
	// 							$this->excel->getActiveSheet()->setCellValue('L'.$index3, "Rp.".$biaya[0]); 
	// 							$this->excel->getActiveSheet()->setCellValue('M'.$index3, "Rp.".$biaya[1]);
	// 							$this->excel->getActiveSheet()->setCellValue('N'.$index3, "Rp.".$biaya[2]);
	// 							$this->excel->getActiveSheet()->setCellValue('O'.$index3, "Rp.".$biaya[3]);
	// 							$this->excel->getActiveSheet()->setCellValue('P'.$index3, "Rp.".$biaya[4]); 
	// 							$this->excel->getActiveSheet()->setCellValue('Q'.$index3, "Rp.".$biaya[5]); 
	// 							$this->excel->getActiveSheet()->setCellValue('R'.$index3, "Rp.".$biaya[6]);  
								
	// 							if($this->mm->cek('data_reformasi_kesehatan','KD_PENGAJUAN',$row->KD_PENGAJUAN)) $total = $this->mm->sum('data_reformasi_kesehatan','Biaya','KD_PENGAJUAN',$row->KD_PENGAJUAN);
	// 							else $total = 0;
	// 							$this->excel->getActiveSheet()->setCellValue('S'.$index3, "Rp.".$total);
	// 						foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
	// 							$this->excel->getActiveSheet()->setCellValue('I'.$index3, $row7->Ikk);
	// 							if($this->mm->cek('target_ikk','KodeIkk',$row7->KodeIkk))
	// 							$target_nasional = $this->mm->get_where('target_ikk','KodeIkk',$row7->KodeIkk)->row()->TargetNasional;
	// 							else $target_nasional = '0';
	// 								$this->excel->getActiveSheet()->setCellValue('J'.$index3, $target_nasional.'%');
	// 							$jumlah_ikk = $this->mm->get_where('data_ikk','KodeIkk',$row7->KodeIkk)->row()->Jumlah;
	// 								$this->excel->getActiveSheet()->setCellValue('K'.$index3, $jumlah_ikk.'%');
								
	// 							$index3++;
	// 						}
							
	// 					}
						
	// 					if($index3>=$index2){
	// 						$index=$index3;
	// 					}else{
	// 						$index=$index2;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$no++;
	// 	}
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //        header('Content-Disposition: attachment;filename="DAFTAR PENGAJUAN '.$TAHUN_ANGGARAN.'.xlsx"');
 //        header('Cache-Control: max-age=0');

 //        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
 //        $objWriter->save('php://output');
	// }

	function rekap_reformasi_kesehatan() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thn = $this->input->post('thn_anggaran');
		$records = $this->mm->cetak_fokus_prioritas_reformasi_kesehatan($thn);
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/cetak_reformasi_kesehatan.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Rekap Proposal Tahun Anggaran '.$thn); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no = 0;
		$awal_baris = 7; //awal baris
		$baris = $awal_baris;

		if($records->num_rows()>0){
			foreach($records->result() as $row){
				$no = $no + 1;

				$tgl_asli = $row->TANGGAL_PEMBUATAN;
				$tgl = date("d-m-Y", strtotime($tgl_asli));

				//SetCellValue
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $row->NamaProvinsi);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $row->nmsatker);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $row->JUDUL_PROPOSAL);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $row->NOMOR_SURAT);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, '['.$row->KodeProgram.'] '.$row->NamaProgram);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, '['.$row->KodeKegiatan.'] '.$row->NamaKegiatan);
				$n=0;
				$biaya;

				foreach($this->pm->get('reformasi_kesehatan')->result() as $ref)
				{
					if($this->mm->cek2('data_reformasi_kesehatan', 'idReformasiKesehatan', $ref->idReformasiKesehatan, 'KD_PENGAJUAN', $row->KD_PENGAJUAN)) {
					$biaya[$n] = $this->pm->get_biaya('data_reformasi_kesehatan','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN,'idReformasiKesehatan',$ref->idReformasiKesehatan);
					}
					else $biaya[$n]='0';
					$n++;
				}
				
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, "Rp.".number_format($biaya[0],2)); 
				$this->excel->getActiveSheet()->setCellValue('I'.$baris, "Rp.".number_format($biaya[1],2));
				$this->excel->getActiveSheet()->setCellValue('J'.$baris, "Rp.".number_format($biaya[2],2));
				$this->excel->getActiveSheet()->setCellValue('K'.$baris, "Rp.".number_format($biaya[3],2));
				$this->excel->getActiveSheet()->setCellValue('L'.$baris, "Rp.".number_format($biaya[4],2)); 
				$this->excel->getActiveSheet()->setCellValue('M'.$baris, "Rp.".number_format($biaya[5],2)); 
				$this->excel->getActiveSheet()->setCellValue('N'.$baris, "Rp.".number_format($biaya[6],2));  
				$this->excel->getActiveSheet()->setCellValue('O'.$baris, "Rp.".number_format($biaya[7],2));
				
				if($this->mm->cek('data_reformasi_kesehatan','KD_PENGAJUAN',$row->KD_PENGAJUAN))
					$biaya_total = $this->mm->sum('data_reformasi_kesehatan','Biaya','KD_PENGAJUAN',$row->KD_PENGAJUAN);
				else 
					$biaya_total=0;
				$this->excel->getActiveSheet()->setCellValue('P'.$baris, "Rp. ".number_format($biaya_total,2));
				$baris++;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':P'.($baris-1))->getBorders()->getInside()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':P'.($baris-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':P'.($baris-1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':P'.($baris-1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Pengajuan Proposal Reformasi Kesehatan.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	// function rekap_jenis_pembiayaan()
	// {
	// 	$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
	// 	$pilihan_rekap = $this->input->post('rekap');
		
	// 	$this->load->library('excel');    
	// 	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	// 	$this->excel = $objReader->load('file/rekap_jenis_pembiayaan.xlsx');
	// 	$this->excel->setActiveSheetIndex(0);
	// 	$this->excel->getActiveSheet()->setCellValue('A1', 'REKAPITULASI USULAN PROPOSAL PER PROGRAM, PER KEGIATAN DAN PER SUMBER DAYA TAHUN '.$TAHUN_ANGGARAN);
	// 	$this->excel->getActiveSheet()->setCellValue('A3', 'NO')
	// 								  ->setCellValue('B3', 'SATKER PENGUSUL')
	// 								  ->setCellValue('C3', 'KAB/KOTA')
	// 								  ->setCellValue('D3', 'JUDUL PROPOSAL AKTIVITAS')
	// 								  ->setCellValue('E3', 'NO/TGL SURAT PENGANTAR')
	// 								  ->setCellValue('F3', 'PROGRAM')
	// 								  ->setCellValue('G3', 'INDIKATOR KINERJA UTAMA (IKU)')
	// 								  ->setCellValue('H3', 'KEGIATAN')
	// 								  ->setCellValue('I3', 'INDIKATOR KINERJA KEGIATAN (IKK)')
	// 								  ->setCellValue('J3', 'TARGET KINERJA NASIONAL')
	// 								  ->setCellValue('K3', 'TARGET KINERJA DAERAH')
	// 								  ->setCellValue('L3', 'USULAN')
	// 								  ->setCellValue('L4', 'RUPIAH MURNI (RM)')
	// 								  ->setCellValue('M4', 'P/HLN')
	// 								  ->setCellValue('M5', 'P/HLN')
	// 								  ->setCellValue('N5', 'RUPIAH MURNI PENDAMPING (RMP)')
	// 								  ->setCellValue('O4', 'PNBP')
	// 								  ->setCellValue('P4', 'BLU')
	// 								  ->setCellValue('Q4', 'TOTAL');

	// 	$no=1;
	// 	$index=6;
		
	// 	foreach($this->mm->get_where2_join('pengajuan','TAHUN_ANGGARAN',$TAHUN_ANGGARAN,'STATUS','1','ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER')->result() as $row){
	// 		$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		$this->excel->getActiveSheet()->getStyle('C'.$index.':J'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		//$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
	// 		$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
	// 		$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);

	// 		foreach($this->mm->get_where2_join('ref_satker','kdlokasi',$row->kdlokasi,'kdsatker',$row->kdsatker,'ref_kabupaten','ref_kabupaten.KodeKabupaten=ref_satker.kdkabkota')->result() as $tes){
	// 			foreach($this->mm->get_where2('ref_kabupaten','KodeProvinsi',$tes->kdlokasi,'KodeKabupaten',$tes->kdkabkota)->result() as $tes2)			
	// 			$this->excel->getActiveSheet()->setCellValue('C'.$index, $tes2->NamaKabupaten);			
	// 		}
	// 		$this->excel->getActiveSheet()->setCellValue('D'.$index, $row->JUDUL_PROPOSAL);			
	// 		$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
	// 		$this->excel->getActiveSheet()->setCellValue('E'.$index, $row->NOMOR_SURAT.'/'.$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
	// 		/*if($row->ID_RENCANA_ANGGARAN == '1'){
	// 			$this->excel->getActiveSheet()->setCellValue('I'.$index, 'V');
	// 		}else{
	// 			$this->excel->getActiveSheet()->setCellValue('J'.$index, 'V');
	// 		}*/
	// 		//$index++;
	// 		$index2 = $index;
	// 		$index3 = $index;
	// 		foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
	// 			foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
	// 				foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
	// 					$this->excel->getActiveSheet()->setCellValue('F'.$index2, $row4->NamaProgram);
	// 					foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
	// 						$this->excel->getActiveSheet()->setCellValue('G'.$index2, $row5->Iku);
	// 						$index2++;
	// 					}
	// 					foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
	// 						$this->excel->getActiveSheet()->setCellValue('H'.$index3, $row6->NamaKegiatan);
	// 						foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
	// 							$this->excel->getActiveSheet()->setCellValue('I'.$index3, $row7->Ikk);
	// 							if($this->mm->cek('target_ikk','KodeIkk',$row7->KodeIkk))
	// 							$target_nasional = $this->mm->get_where('target_ikk','KodeIkk',$row7->KodeIkk)->row()->TargetNasional;
	// 							else $target_nasional = '0';
	// 								$this->excel->getActiveSheet()->setCellValue('J'.$index3, $target_nasional.'%');
	// 							$jumlah_ikk = $this->mm->get_where('data_ikk','KodeIkk',$row7->KodeIkk)->row()->Jumlah;
	// 								$this->excel->getActiveSheet()->setCellValue('K'.$index3, $jumlah_ikk.'%');
								
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisPembiayaan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_rm = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisPembiayaan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_rm = 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisPembiayaan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_phln = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisPembiayaan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_phln = 0;
	// 							$biaya_rmp = 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisPembiayaan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_pnbp = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisPembiayaan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_pnbp = 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisPembiayaan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_blu = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisPembiayaan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_blu = 0;
	// 							$this->excel->getActiveSheet()->setCellValue('L'.$index3, "Rp.".$biaya_rm);
	// 							$this->excel->getActiveSheet()->setCellValue('M'.$index3, "Rp.".$biaya_phln);
	// 							$this->excel->getActiveSheet()->setCellValue('N'.$index3, "Rp.".$biaya_rmp);
	// 							$this->excel->getActiveSheet()->setCellValue('O'.$index3, "Rp.".$biaya_pnbp);
	// 							$this->excel->getActiveSheet()->setCellValue('P'.$index3, "Rp.".$biaya_blu); 
								
	// 							if($this->mm->cek('aktivitas','KD_PENGAJUAN', $row->KD_PENGAJUAN)) $biaya_total = $this->mm->sum('aktivitas','Jumlah','KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_total=0;
	// 							$this->excel->getActiveSheet()->setCellValue('Q'.$index3, "Rp.".$biaya_total); 
	// 							$index3++;
	// 						}
							
	// 					}
						
	// 					if($index3>=$index2){
	// 						$index=$index3;
	// 					}else{
	// 						$index=$index2;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$no++;
	// 	}
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //        header('Content-Disposition: attachment;filename="DAFTAR PENGAJUAN '.$TAHUN_ANGGARAN.'.xlsx"');
 //        header('Cache-Control: max-age=0');

 //        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
 //        $objWriter->save('php://output');
	// }

	function rekap_jenis_pembiayaan() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thn = $this->input->post('thn_anggaran');
		$records = $this->mm->cetak_fokus_prioritas_reformasi_kesehatan($thn);
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/cetak_jenis_pembiayaan.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Rekap Proposal Tahun Anggaran '.$thn); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no = 0;
		$awal_baris = 7; //awal baris
		$baris = $awal_baris;

		if($records->num_rows()>0){
			foreach($records->result() as $row){
				$no = $no + 1;

				$tgl_asli = $row->TANGGAL_PEMBUATAN;
				$tgl = date("d-m-Y", strtotime($tgl_asli));

				//SetCellValue
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $row->NamaProvinsi);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $row->nmsatker);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $row->JUDUL_PROPOSAL);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $row->NOMOR_SURAT);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, '['.$row->KodeProgram.'] '.$row->NamaProgram);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, '['.$row->KodeKegiatan.'] '.$row->NamaKegiatan);
				$n=0;
				$biaya;

				if($this->mm->cek2('aktivitas', 'KodeJenisPembiayaan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
					$biaya_phln = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisPembiayaan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else 
					$biaya_phln = 0;

				if($this->mm->cek2('aktivitas', 'KodeJenisPembiayaan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
					$biaya_rm = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisPembiayaan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else
					$biaya_rm = 0;
				
				if($this->mm->cek2('aktivitas', 'KodeJenisPembiayaan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
					$biaya_pnbp = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisPembiayaan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else 
					$biaya_pnbp = 0;

				if($this->mm->cek2('aktivitas', 'KodeJenisPembiayaan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
					$biaya_blu = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisPembiayaan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else 
					$biaya_blu = 0;
				
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, "Rp.".number_format($biaya_phln,2)); 
				$this->excel->getActiveSheet()->setCellValue('I'.$baris, "Rp.".number_format($biaya_rm,2));
				$this->excel->getActiveSheet()->setCellValue('J'.$baris, "Rp.".number_format($biaya_pnbp,2));
				$this->excel->getActiveSheet()->setCellValue('K'.$baris, "Rp.".number_format($biaya_blu,2));
				
				if($this->mm->cek('data_reformasi_kesehatan','KD_PENGAJUAN',$row->KD_PENGAJUAN))
					$biaya_total = $this->mm->sum('data_reformasi_kesehatan','Biaya','KD_PENGAJUAN',$row->KD_PENGAJUAN);
				else 
					$biaya_total=0;
				$this->excel->getActiveSheet()->setCellValue('L'.$baris, "Rp. ".number_format($biaya_total,2));
				$baris++;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':L'.($baris-1))->getBorders()->getInside()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':L'.($baris-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':L'.($baris-1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':L'.($baris-1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Pengajuan Proposal Jenis Pembiayaan.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	// function rekap_sumber_dana()
	// {
	// 	$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
	// 	$pilihan_rekap = $this->input->post('rekap');
		
	// 	$this->load->library('excel');    
	// 	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	// 	$this->excel = $objReader->load('file/rekap_sumber_dana.xlsx');
	// 	$this->excel->setActiveSheetIndex(0);
	// 	$this->excel->getActiveSheet()->setCellValue('A1', 'REKAPITULASI USULAN PROPOSAL BERDASARKAN SUMBER DANA TAHUN '.$TAHUN_ANGGARAN);
	// 	$this->excel->getActiveSheet()->setCellValue('A3', 'NO')
	// 								  ->setCellValue('B3', 'SATKER PENGUSUL')
	// 								  ->setCellValue('C3', 'KAB/KOTA')
	// 								  ->setCellValue('D3', 'JUDUL PROPOSAL AKTIVITAS')
	// 								  ->setCellValue('E3', 'NO/TGL SURAT PENGANTAR')
	// 								  ->setCellValue('F3', 'PROGRAM')
	// 								  ->setCellValue('G3', 'INDIKATOR KINERJA UTAMA (IKU)')
	// 								  ->setCellValue('H3', 'KEGIATAN')
	// 								  ->setCellValue('I3', 'INDIKATOR KINERJA KEGIATAN (IKK)')
	// 								  ->setCellValue('J3', 'TARGET KINERJA NASIONAL')
	// 								  ->setCellValue('K3', 'TARGET KINERJA DAERAH')
	// 								  ->setCellValue('L3', 'USULAN')
	// 								  ->setCellValue('L4', 'APBN')
	// 								  ->setCellValue('M4', 'DAK');

	// 	$no=1;
	// 	$index=5;
		
	// 	foreach($this->mm->get_where2_join('pengajuan','TAHUN_ANGGARAN',$TAHUN_ANGGARAN,'STATUS','1','ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER')->result() as $row){
	// 		$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		$this->excel->getActiveSheet()->getStyle('C'.$index.':J'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		//$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
	// 		$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
	// 		$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);

	// 		foreach($this->mm->get_where2_join('ref_satker','kdlokasi',$row->kdlokasi,'kdsatker',$row->kdsatker,'ref_kabupaten','ref_kabupaten.KodeKabupaten=ref_satker.kdkabkota')->result() as $tes){
	// 			foreach($this->mm->get_where2('ref_kabupaten','KodeProvinsi',$tes->kdlokasi,'KodeKabupaten',$tes->kdkabkota)->result() as $tes2)			
	// 			$this->excel->getActiveSheet()->setCellValue('C'.$index, $tes2->NamaKabupaten);			
	// 		}
	// 		$this->excel->getActiveSheet()->setCellValue('D'.$index, $row->JUDUL_PROPOSAL);			
	// 		$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
	// 		$this->excel->getActiveSheet()->setCellValue('E'.$index, $row->NOMOR_SURAT.'/'.$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
	// 		/*if($row->ID_RENCANA_ANGGARAN == '1'){
	// 			$this->excel->getActiveSheet()->setCellValue('I'.$index, 'V');
	// 		}else{
	// 			$this->excel->getActiveSheet()->setCellValue('J'.$index, 'V');
	// 		}*/
	// 		//$index++;
	// 		$index2 = $index;
	// 		$index3 = $index;
	// 		foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
	// 			foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
	// 				foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
	// 					$this->excel->getActiveSheet()->setCellValue('F'.$index2, $row4->NamaProgram);
	// 					foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
	// 						$this->excel->getActiveSheet()->setCellValue('G'.$index2, $row5->Iku);
	// 						$index2++;
	// 					}
	// 					foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
	// 						$this->excel->getActiveSheet()->setCellValue('H'.$index3, $row6->NamaKegiatan);
	// 							if($this->mm->cek2('aktivitas', 'idRencanaAnggaran', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_apbn = $this->mm->sum2('aktivitas', 'Jumlah', 'idRencanaAnggaran', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_apbn= 0;
	// 							if($this->mm->cek2('aktivitas', 'idRencanaAnggaran', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_dak = $this->mm->sum2('aktivitas', 'Jumlah', 'idRencanaAnggaran', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_dak= 0;
	// 							$this->excel->getActiveSheet()->setCellValue('L'.$index3, "Rp.".$biaya_apbn);
	// 							$this->excel->getActiveSheet()->setCellValue('M'.$index3, "Rp.".$biaya_dak);
	// 						foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
	// 							$this->excel->getActiveSheet()->setCellValue('I'.$index3, $row7->Ikk);
	// 							if($this->mm->cek('target_ikk','KodeIkk',$row7->KodeIkk))
	// 							$target_nasional = $this->mm->get_where('target_ikk','KodeIkk',$row7->KodeIkk)->row()->TargetNasional;
	// 							else $target_nasional = '0';
	// 								$this->excel->getActiveSheet()->setCellValue('J'.$index3, $target_nasional.'%');
	// 							$jumlah_ikk = $this->mm->get_where('data_ikk','KodeIkk',$row7->KodeIkk)->row()->Jumlah;
	// 								$this->excel->getActiveSheet()->setCellValue('K'.$index3, $jumlah_ikk.'%');
								
								
								
	// 							$index3++;
	// 						}
							
	// 					}
						
	// 					if($index3>=$index2){
	// 						$index=$index3;
	// 					}else{
	// 						$index=$index2;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$no++;
	// 	}
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //        header('Content-Disposition: attachment;filename="DAFTAR PENGAJUAN '.$TAHUN_ANGGARAN.'.xlsx"');
 //        header('Cache-Control: max-age=0');

 //        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
 //        $objWriter->save('php://output');
	// }

	function rekap_sumber_dana() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thn = $this->input->post('thn_anggaran');
		$records = $this->mm->cetak_fokus_prioritas_reformasi_kesehatan($thn);
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/cetak_sumber_dana.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Rekap Proposal Tahun Anggaran '.$thn); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no = 0;
		$awal_baris = 7; //awal baris
		$baris = $awal_baris;

		if($records->num_rows()>0){
			foreach($records->result() as $row){
				$no = $no + 1;

				$tgl_asli = $row->TANGGAL_PEMBUATAN;
				$tgl = date("d-m-Y", strtotime($tgl_asli));

				//SetCellValue
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $row->NamaProvinsi);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $row->nmsatker);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $row->JUDUL_PROPOSAL);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $row->NOMOR_SURAT);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, '['.$row->KodeProgram.'] '.$row->NamaProgram);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, '['.$row->KodeKegiatan.'] '.$row->NamaKegiatan);
				
				if($this->mm->cek2('aktivitas', 'idRencanaAnggaran', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
					$biaya_apbn = $this->mm->sum2('aktivitas', 'Jumlah', 'idRencanaAnggaran', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else
					$biaya_apbn= 0;
				if($this->mm->cek2('aktivitas', 'idRencanaAnggaran', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
					$biaya_dak = $this->mm->sum2('aktivitas', 'Jumlah', 'idRencanaAnggaran', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else 
					$biaya_dak= 0;
				
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, "Rp.".number_format($biaya_apbn,2)); 
				$this->excel->getActiveSheet()->setCellValue('I'.$baris, "Rp.".number_format($biaya_dak,2));
				$baris++;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':I'.($baris-1))->getBorders()->getInside()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':I'.($baris-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':I'.($baris-1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':I'.($baris-1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Pengajuan Proposal Sumber Dana.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	// function rekap_apbn()
	// {
	// 	$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
	// 	$pilihan_rekap = $this->input->post('rekap');
		
	// 	$this->load->library('excel');    
	// 	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	// 	$this->excel = $objReader->load('file/rekap_apbn.xlsx');
	// 	$this->excel->setActiveSheetIndex(0);
	// 	$this->excel->getActiveSheet()->setCellValue('A1', 'REKAPITULASI USULAN BERSUMBER APBN TAHUN '.$TAHUN_ANGGARAN);
	// 	$this->excel->getActiveSheet()->setCellValue('A3', 'NO')
	// 								  ->setCellValue('B3', 'SATKER PENGUSUL')
	// 								  ->setCellValue('C3', 'KAB/KOTA')
	// 								  ->setCellValue('D3', 'JUDUL PROPOSAL AKTIVITAS')
	// 								  ->setCellValue('E3', 'NO/TGL SURAT PENGANTAR')
	// 								  ->setCellValue('F3', 'PROGRAM')
	// 								  ->setCellValue('G3', 'INDIKATOR KINERJA UTAMA (IKU)')
	// 								  ->setCellValue('H3', 'KEGIATAN')
	// 								  ->setCellValue('I3', 'INDIKATOR KINERJA KEGIATAN (IKK)')
	// 								  ->setCellValue('J3', 'TARGET KINERJA NASIONAL')
	// 								  ->setCellValue('K3', 'TARGET KINERJA DAERAH')
	// 								  ->setCellValue('L3', 'USULAN')
	// 								  ->setCellValue('L4', 'BELANJA PEGAWAI')
	// 								  ->setCellValue('M4', 'BIAYA OPERASIONAL')
	// 								  ->setCellValue('N4', 'BIAYA PELAKSANAAN KEGIATAN/PROGRAM')
	// 								  ->setCellValue('O4', 'BIAYA OBAT')
	// 								  ->setCellValue('P4', 'BIAYA FISIK BANGUNAN')
	// 								  ->setCellValue('Q4', 'PENGADAAN ALKES')
	// 								  ->setCellValue('R4', 'PENGADAAN KENDARAAN');

	// 	$no=1;
	// 	$index=5;
		
	// 	foreach($this->mm->get_where2_join('pengajuan','TAHUN_ANGGARAN',$TAHUN_ANGGARAN,'STATUS','1','ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER')->result() as $row){
	// 		$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		$this->excel->getActiveSheet()->getStyle('C'.$index.':J'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		//$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
	// 		$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
	// 		$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);

	// 		foreach($this->mm->get_where2_join('ref_satker','kdlokasi',$row->kdlokasi,'kdsatker',$row->kdsatker,'ref_kabupaten','ref_kabupaten.KodeKabupaten=ref_satker.kdkabkota')->result() as $tes){
	// 			foreach($this->mm->get_where2('ref_kabupaten','KodeProvinsi',$tes->kdlokasi,'KodeKabupaten',$tes->kdkabkota)->result() as $tes2)			
	// 			$this->excel->getActiveSheet()->setCellValue('C'.$index, $tes2->NamaKabupaten);			
	// 		}
	// 		$this->excel->getActiveSheet()->setCellValue('D'.$index, $row->JUDUL_PROPOSAL);			
	// 		$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
	// 		$this->excel->getActiveSheet()->setCellValue('E'.$index, $row->NOMOR_SURAT.'/'.$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
	// 		/*if($row->ID_RENCANA_ANGGARAN == '1'){
	// 			$this->excel->getActiveSheet()->setCellValue('I'.$index, 'V');
	// 		}else{
	// 			$this->excel->getActiveSheet()->setCellValue('J'.$index, 'V');
	// 		}*/
	// 		//$index++;
	// 		$index2 = $index;
	// 		$index3 = $index;
	// 		foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
	// 			foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
	// 				foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
	// 					$this->excel->getActiveSheet()->setCellValue('F'.$index2, $row4->NamaProgram);
	// 					foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
	// 						$this->excel->getActiveSheet()->setCellValue('G'.$index2, $row5->Iku);
	// 						$index2++;
	// 					}
	// 					foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
	// 						$this->excel->getActiveSheet()->setCellValue('H'.$index3, $row6->NamaKegiatan);
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_bp = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_bp = 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_op = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_op = 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_pel = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_pel = 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_ob = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_ob= 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '5', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_fis = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '5', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_fis= 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '6', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_alk = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '6', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_alk= 0;
	// 							if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '7', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
	// 							$biaya_kend = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '7', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_kend= 0;
	// 							$this->excel->getActiveSheet()->setCellValue('L'.$index3, "Rp.".$biaya_bp);
	// 							$this->excel->getActiveSheet()->setCellValue('M'.$index3, "Rp.".$biaya_op);
	// 							$this->excel->getActiveSheet()->setCellValue('N'.$index3, "Rp.".$biaya_pel);
	// 							$this->excel->getActiveSheet()->setCellValue('O'.$index3, "Rp.".$biaya_ob);
	// 							$this->excel->getActiveSheet()->setCellValue('P'.$index3, "Rp.".$biaya_fis); 
	// 							$this->excel->getActiveSheet()->setCellValue('Q'.$index3, "Rp.".$biaya_alk); 
	// 							$this->excel->getActiveSheet()->setCellValue('R'.$index3, "Rp.".$biaya_kend); 
								
	// 							if($this->mm->cek('aktivitas','KD_PENGAJUAN', $row->KD_PENGAJUAN)) $biaya_total = $this->mm->sum('aktivitas','Jumlah','KD_PENGAJUAN', $row->KD_PENGAJUAN);
	// 							else $biaya_total=0;
	// 							$this->excel->getActiveSheet()->setCellValue('S'.$index3, "Rp.".$biaya_total); 
	// 						foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
	// 							$this->excel->getActiveSheet()->setCellValue('I'.$index3, $row7->Ikk);
	// 							if($this->mm->cek('target_ikk','KodeIkk',$row7->KodeIkk))
	// 							$target_nasional = $this->mm->get_where('target_ikk','KodeIkk',$row7->KodeIkk)->row()->TargetNasional;
	// 							else $target_nasional = '0';
	// 								$this->excel->getActiveSheet()->setCellValue('J'.$index3, $target_nasional.'%');
	// 							$jumlah_ikk = $this->mm->get_where('data_ikk','KodeIkk',$row7->KodeIkk)->row()->Jumlah;
	// 								$this->excel->getActiveSheet()->setCellValue('K'.$index3, $jumlah_ikk.'%');
								
								
	// 							$index3++;
	// 						}
							
	// 					}
						
	// 					if($index3>=$index2){
	// 						$index=$index3;
	// 					}else{
	// 						$index=$index2;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$no++;
	// 	}
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //        header('Content-Disposition: attachment;filename="DAFTAR PENGAJUAN '.$TAHUN_ANGGARAN.'.xlsx"');
 //        header('Cache-Control: max-age=0');

 //        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
 //        $objWriter->save('php://output');
	// }

	function rekap_apbn() {
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thn = $this->session->userdata('thn_anggaran');
		$records = $this->mm->cetak_apbn();
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/cetak_apbn.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Rekap Proposal Tahun Anggaran '.$thn); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no = 0;
		$awal_baris = 7; //awal baris
		$baris = $awal_baris;

		if($records->num_rows()>0){
			foreach($records->result() as $row){
				$no = $no + 1;

				$tgl_asli = $row->TANGGAL_PEMBUATAN;
				$tgl = date("d-m-Y", strtotime($tgl_asli));

				//SetCellValue
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $row->NamaProvinsi);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $row->nmsatker);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $row->JUDUL_PROPOSAL);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $row->NOMOR_SURAT);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, $row->TANGGAL_PENGAJUAN);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, $row->NamaProgram);
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, $row->NamaKegiatan);

				if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
				$biaya_bp = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else $biaya_bp = 0;
				if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
				$biaya_op = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else $biaya_op = 0;
				if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
				$biaya_pel = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else $biaya_pel = 0;
				if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
				$biaya_ob = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else $biaya_ob= 0;
				if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '5', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
				$biaya_fis = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '5', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else $biaya_fis= 0;
				if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '6', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
				$biaya_alk = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '6', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else $biaya_alk= 0;
				if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '7', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
				$biaya_kend = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '7', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else $biaya_kend= 0;
				$this->excel->getActiveSheet()->setCellValue('I'.$baris, "Rp. ".number_format($biaya_bp,2));
				$this->excel->getActiveSheet()->setCellValue('J'.$baris, "Rp. ".number_format($biaya_op,2));
				$this->excel->getActiveSheet()->setCellValue('K'.$baris, "Rp. ".number_format($biaya_pel,2));
				$this->excel->getActiveSheet()->setCellValue('L'.$baris, "Rp. ".number_format($biaya_ob,2));
				$this->excel->getActiveSheet()->setCellValue('M'.$baris, "Rp. ".number_format($biaya_fis,2)); 
				$this->excel->getActiveSheet()->setCellValue('N'.$baris, "Rp. ".number_format($biaya_alk,2)); 
				$this->excel->getActiveSheet()->setCellValue('O'.$baris, "Rp. ".number_format($biaya_kend,2)); 
				
				if($this->mm->cek('aktivitas','KD_PENGAJUAN', $row->KD_PENGAJUAN)) $biaya_total = $this->mm->sum('aktivitas','Jumlah','KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else $biaya_total=0;
				$this->excel->getActiveSheet()->setCellValue('P'.$baris, "Rp. ".number_format($biaya_total,2));
				$baris++;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':P'.($baris-1))->getBorders()->getInside()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':P'.($baris-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':P'.($baris-1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':P'.($baris-1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Pengajuan Proposal.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	// function rekap_dak()
	// {
	// 	$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
	// 	$pilihan_rekap = $this->input->post('rekap');
		
	// 	$this->load->library('excel');    
	// 	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	// 	$this->excel = $objReader->load('file/rekap_dak.xlsx');
	// 	$this->excel->setActiveSheetIndex(0);
		
	// 	$no=1;
	// 	$index=5;
		
	// 	foreach($this->mm->get_where2_join('pengajuan','TAHUN_ANGGARAN',$TAHUN_ANGGARAN,'STATUS','1','ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER')->result() as $row){
	// 		$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		$this->excel->getActiveSheet()->getStyle('C'.$index.':J'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 		//$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
	// 		$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
	// 		$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);

	// 		foreach($this->mm->get_where2_join('ref_satker','kdlokasi',$row->kdlokasi,'kdsatker',$row->kdsatker,'ref_kabupaten','ref_kabupaten.KodeKabupaten=ref_satker.kdkabkota')->result() as $tes){
	// 			foreach($this->mm->get_where2('ref_kabupaten','KodeProvinsi',$tes->kdlokasi,'KodeKabupaten',$tes->kdkabkota)->result() as $tes2)			
	// 			$this->excel->getActiveSheet()->setCellValue('C'.$index, $tes2->NamaKabupaten);			
	// 		}
	// 		$this->excel->getActiveSheet()->setCellValue('D'.$index, $row->JUDUL_PROPOSAL);			
	// 		$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
	// 		$this->excel->getActiveSheet()->setCellValue('E'.$index, $row->NOMOR_SURAT.'/'.$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
	// 		/*if($row->ID_RENCANA_ANGGARAN == '1'){
	// 			$this->excel->getActiveSheet()->setCellValue('I'.$index, 'V');
	// 		}else{
	// 			$this->excel->getActiveSheet()->setCellValue('J'.$index, 'V');
	// 		}*/
	// 		//$index++;
	// 		$index2 = $index;
	// 		$index3 = $index;
	// 		foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
	// 			foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
	// 				foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
	// 					$this->excel->getActiveSheet()->setCellValue('F'.$index2, $row4->NamaProgram);
	// 					foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
	// 						$this->excel->getActiveSheet()->setCellValue('G'.$index2, $row5->Iku);
	// 						$index2++;
	// 					}
	// 					foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
	// 						$this->excel->getActiveSheet()->setCellValue('H'.$index3, $row6->NamaKegiatan);
	// 						foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
	// 							$this->excel->getActiveSheet()->setCellValue('I'.$index3, $row7->Ikk);
	// 							if($this->mm->cek('target_ikk','KodeIkk',$row7->KodeIkk))
	// 							$target_nasional = $this->mm->get_where('target_ikk','KodeIkk',$row7->KodeIkk)->row()->TargetNasional;
	// 							else $target_nasional = '0';
	// 								$this->excel->getActiveSheet()->setCellValue('J'.$index3, $target_nasional.'%');
	// 							$jumlah_ikk = $this->mm->get_where('data_ikk','KodeIkk',$row7->KodeIkk)->row()->Jumlah;
	// 								$this->excel->getActiveSheet()->setCellValue('K'.$index3, $jumlah_ikk.'%');
								
	// 							foreach($this->pm->get('reformasi_kesehatan')->result() as $ref)
	// 							{
	// 								if($this->pm->cek('data_reformasi_kesehatan', 'idReformasiKesehatan', $ref->idReformasiKesehatan, 'KD_PENGAJUAN', $row->KD_PENGAJUAN)) {
	// 								$biaya = $this->pm->get_biaya('data_reformasi_kesehatan','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN,'idReformasiKesehatan',$ref->idReformasiKesehatan);
	// 								$this->excel->getActiveSheet()->setCellValue('L'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('M'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('N'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('O'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('P'.$index3, "Rp.".$biaya); 
	// 								$this->excel->getActiveSheet()->setCellValue('Q'.$index3, "Rp.".$biaya); 
	// 								$this->excel->getActiveSheet()->setCellValue('R'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('S'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('T'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('U'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('V'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('W'.$index3, "Rp.".$biaya); 
	// 								$this->excel->getActiveSheet()->setCellValue('X'.$index3, "Rp.".$biaya); 
	// 								$this->excel->getActiveSheet()->setCellValue('Y'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('Z'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('AA'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('AB'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('AC'.$index3, "Rp.".$biaya);
	// 								$this->excel->getActiveSheet()->setCellValue('AD'.$index3, "Rp.".$biaya); 
	// 								$this->excel->getActiveSheet()->setCellValue('AE'.$index3, "Rp.".$biaya); 
	// 								$this->excel->getActiveSheet()->setCellValue('AF'.$index3, "Rp.".$biaya);
	// 								}
	// 							}
	// 							$index3++;
	// 						}
							
	// 					}
						
	// 					if($index3>=$index2){
	// 						$index=$index3;
	// 					}else{
	// 						$index=$index2;
	// 					}
	// 				}
	// 			}
	// 		}
	// 		$no++;
	// 	}
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //        header('Content-Disposition: attachment;filename="DAFTAR PENGAJUAN '.$TAHUN_ANGGARAN.'.xlsx"');
 //        header('Cache-Control: max-age=0');

 //        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
 //        $objWriter->save('php://output');
	// }

	function rekap_dak()
	{
		$tanggal_print = date('d/m/Y');
		$tanggal_judul = date('dmY');
		$thn = $this->input->post('thn_anggaran');
		$records = $this->mm->cetak_dak($thn);
		ini_set("memory_limit", "256M");
		// set to excel
		$this->load->library('excel');                 
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/cetak_dak.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Rekap Proposal Tahun Anggaran '.$thn); //print judul
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, $tanggal_print); //print tanggal	
		
		$no = 0;
		$awal_baris = 7; //awal baris
		$baris = $awal_baris;

		if($records->num_rows()>0){
			foreach($records->result() as $row){
				$no = $no + 1;

				$tgl_asli = $row->TANGGAL_PEMBUATAN;
				$tgl = date("d-m-Y", strtotime($tgl_asli));

				//SetCellValue
				$this->excel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$this->excel->getActiveSheet()->setCellValue('B'.$baris, $row->NamaProvinsi);
				$this->excel->getActiveSheet()->setCellValue('C'.$baris, $row->nmsatker);
				$this->excel->getActiveSheet()->setCellValue('D'.$baris, $row->JUDUL_PROPOSAL);
				$this->excel->getActiveSheet()->setCellValue('E'.$baris, $row->NOMOR_SURAT);
				$this->excel->getActiveSheet()->setCellValue('F'.$baris, '['.$row->KodeProgram.'] '.$row->NamaProgram);
				$this->excel->getActiveSheet()->setCellValue('G'.$baris, '['.$row->KodeKegiatan.'] '.$row->NamaKegiatan);
				
				if($this->mm->cek2('aktivitas', 'idRencanaAnggaran', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
					$biaya_dak = $this->mm->sum2('aktivitas', 'Jumlah', 'idRencanaAnggaran', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
				else 
					$biaya_dak= 0;
				
				$this->excel->getActiveSheet()->setCellValue('H'.$baris, "Rp.".number_format($biaya_dak,2));
				$baris++;
			}
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':H'.($baris-1))->getBorders()->getInside()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':H'.($baris-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':H'.($baris-1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$awal_baris.':H'.($baris-1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Pengajuan Proposal DAK.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	function rekap_lengkap()
	{
		$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
		$pilihan_rekap = $this->input->post('rekap');
		
		$this->load->library('excel');    
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$this->excel = $objReader->load('file/rekap_lengkap.xlsx');
		$this->excel->setActiveSheetIndex(0);
		
		$no=1;
		$index=5;
		
		foreach($this->mm->get_where2_join('pengajuan','TAHUN_ANGGARAN',$TAHUN_ANGGARAN,'STATUS','1','ref_satker','ref_satker.kdsatker=pengajuan.NO_REG_SATKER')->result() as $row){
			$this->excel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C'.$index.':J'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$this->excel->getActiveSheet()->getStyle('A'.$index.':J'.$index)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A'.$index, $no);
			$this->excel->getActiveSheet()->setCellValue('B'.$index, $row->nmsatker);

			foreach($this->mm->get_where2_join('ref_satker','kdlokasi',$row->kdlokasi,'kdsatker',$row->kdsatker,'ref_kabupaten','ref_kabupaten.KodeKabupaten=ref_satker.kdkabkota')->result() as $tes){
				foreach($this->mm->get_where2('ref_kabupaten','KodeProvinsi',$tes->kdlokasi,'KodeKabupaten',$tes->kdkabkota)->result() as $tes2)			
				$this->excel->getActiveSheet()->setCellValue('C'.$index, $tes2->NamaKabupaten);			
			}
			$this->excel->getActiveSheet()->setCellValue('D'.$index, $row->JUDUL_PROPOSAL);			
			$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
			$this->excel->getActiveSheet()->setCellValue('E'.$index, $row->NOMOR_SURAT.'/'.$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
			/*if($row->ID_RENCANA_ANGGARAN == '1'){
				$this->excel->getActiveSheet()->setCellValue('I'.$index, 'V');
			}else{
				$this->excel->getActiveSheet()->setCellValue('J'.$index, 'V');
			}*/
			//$index++;
			$index2 = $index;
			$index3 = $index;
			foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){
				foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){
					foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){
						$this->excel->getActiveSheet()->setCellValue('F'.$index2, $row4->NamaProgram);
						foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){
							$this->excel->getActiveSheet()->setCellValue('G'.$index2, $row5->Iku);
							$index2++;
						}
						foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){
							$this->excel->getActiveSheet()->setCellValue('H'.$index3, $row6->NamaKegiatan);
							
								
								if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
								$biaya_bp = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
								else $biaya_bp = 0;
								if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
								$biaya_op = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
								else $biaya_op = 0;
								if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
								$biaya_pel = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
								else $biaya_pel = 0;
								if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
								$biaya_ob = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
								else $biaya_ob= 0;
								if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '5', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
								$biaya_fis = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '5', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
								else $biaya_fis= 0;
								if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '6', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
								$biaya_alk = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '6', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
								else $biaya_alk= 0;
								if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '7', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
								$biaya_kend = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '7', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
								else $biaya_kend= 0;
								$this->excel->getActiveSheet()->setCellValue('L'.$index3, "Rp.".$biaya_bp);
								$this->excel->getActiveSheet()->setCellValue('M'.$index3, "Rp.".$biaya_op);
								$this->excel->getActiveSheet()->setCellValue('N'.$index3, "Rp.".$biaya_pel);
								$this->excel->getActiveSheet()->setCellValue('O'.$index3, "Rp.".$biaya_ob);
								$this->excel->getActiveSheet()->setCellValue('P'.$index3, "Rp.".$biaya_fis); 
								$this->excel->getActiveSheet()->setCellValue('Q'.$index3, "Rp.".$biaya_alk); 
								$this->excel->getActiveSheet()->setCellValue('R'.$index3, "Rp.".$biaya_kend); 
								
								if($this->pm->sum('aktivitas','Jumlah','KD_PENGAJUAN', $row->KD_PENGAJUAN)) $biaya_total = $this->mm->sum('aktivitas','Jumlah','KD_PENGAJUAN', $row->KD_PENGAJUAN);
								else $biaya_total=0;
								$this->excel->getActiveSheet()->setCellValue('S'.$index3, "Rp.".$biaya_total); 
								
								foreach($this->pm->get('reformasi_kesehatan')->result() as $ref)
								{
									if($this->pm->cek('data_reformasi_kesehatan', 'idReformasiKesehatan', $ref->idReformasiKesehatan, 'KD_PENGAJUAN', $row->KD_PENGAJUAN)) {
									$biaya = $this->pm->get_biaya('data_reformasi_kesehatan','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN,'idReformasiKesehatan',$ref->idReformasiKesehatan);
									$this->excel->getActiveSheet()->setCellValue('T'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('U'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('V'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('W'.$index3, "Rp.".$biaya); 
									$this->excel->getActiveSheet()->setCellValue('X'.$index3, "Rp.".$biaya); 
									$this->excel->getActiveSheet()->setCellValue('Y'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('Z'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AA'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AB'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AC'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AD'.$index3, "Rp.".$biaya); 
									$this->excel->getActiveSheet()->setCellValue('AE'.$index3, "Rp.".$biaya); 
									$this->excel->getActiveSheet()->setCellValue('AF'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AG'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AH'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AI'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AJ'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AK'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AL'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AM'.$index3, "Rp.".$biaya);
									$this->excel->getActiveSheet()->setCellValue('AN'.$index3, "Rp.".$biaya);
									}
								}
							foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
								$this->excel->getActiveSheet()->setCellValue('I'.$index3, $row7->Ikk);
								if($this->mm->cek('target_ikk','KodeIkk',$row7->KodeIkk))
								$target_nasional = $this->mm->get_where('target_ikk','KodeIkk',$row7->KodeIkk)->row()->TargetNasional;
								else $target_nasional = '0';
									$this->excel->getActiveSheet()->setCellValue('J'.$index3, $target_nasional.'%');
								$jumlah_ikk = $this->mm->get_where('data_ikk','KodeIkk',$row7->KodeIkk)->row()->Jumlah;
									$this->excel->getActiveSheet()->setCellValue('K'.$index3, $jumlah_ikk.'%');
								
								$index3++;
							}
							
						}
						
						if($index3>=$index2){
							$index=$index3;
						}else{
							$index=$index2;
						}
					}
				}
			}
			$no++;
		}
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DAFTAR PENGAJUAN '.$TAHUN_ANGGARAN.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}
	
	function rekap_daerah(){
		$TAHUN_ANGGARAN = $this->input->post('thn_anggaran');
		// $TAHUN_ANGGARAN = $this->session->userdata('thn_anggaran');
		$phpExcel = new PHPExcel();
		$phpExcel->setActiveSheetIndex(0);
		$sheet[0] = $phpExcel->getActiveSheet();
		// $sheet[0]->setCellValue("A1", "Text")
				// ->setCellValue("A2", "Text")
				// ->setCellValue("A3", "Text")
				// ->setCellValue("A4", "Text")
				// ->setCellValue("A5", "Text");
		$sheet[0]->getColumnDimension("A")->setWidth(5);
		$sheet[0]->getColumnDimension("B")->setWidth(40);
		$sheet[0]->getColumnDimension("C")->setWidth(30);
		$sheet[0]->getColumnDimension("D")->setWidth(50);
		$sheet[0]->getColumnDimension("E")->setWidth(20);
		$sheet[0]->getColumnDimension("F")->setWidth(50);
		$sheet[0]->getColumnDimension("G")->setWidth(50);
		$sheet[0]->getColumnDimension("H")->setWidth(50);
		$sheet[0]->getColumnDimension("I")->setWidth(50);
		$sheet[0]->getColumnDimension("j")->setWidth(10);
		$sheet[0]->getColumnDimension("K")->setWidth(10);
		$sheet[0]->getColumnDimension("L")->setWidth(20);
		$sheet[0]->getColumnDimension("M")->setWidth(20);
		$sheet[0]->getColumnDimension("N")->setWidth(20);
		$sheet[0]->getColumnDimension("O")->setWidth(20);
		$sheet[0]->getColumnDimension("P")->setWidth(20);
		$sheet[0]->getColumnDimension("Q")->setWidth(20);
		$sheet[0]->getColumnDimension("R")->setWidth(20);
		$sheet[0]->getColumnDimension("S")->setWidth(20);
		
		$sheet[0]->getStyle('A1:S4')->getAlignment()->setWrapText(true);
		$sheet[0]->getStyle('A1:S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet[0]->getStyle('A1:S4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$formatter = array(
						"font" => array( 
							"bold" => true
						),
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID, 
							'color' => array('rgb' => 'CCCCCC')
						)
					);
		$sheet[0]->getStyle("A3:S4")->applyFromArray($formatter);
		$sheet[0]->getStyle("A1:S1")->applyFromArray(array("font" => array( "bold" => true, "size" => "14")));
		$sheet[0]->mergeCells("A1:S1");
		$sheet[0]->setCellValue('A1', "REKAPITULASI USULAN PROPOSAL YANG BELUM DISETUJUI TAHUN ".$TAHUN_ANGGARAN);
		$sheet[0]->mergeCells("A3:A4");
		$sheet[0]->mergeCells("B3:B4");
		$sheet[0]->mergeCells("C3:C4");
		$sheet[0]->mergeCells("D3:D4");
		$sheet[0]->mergeCells("E3:E4");
		$sheet[0]->mergeCells("F3:F4");
		$sheet[0]->mergeCells("G3:G4");
		$sheet[0]->mergeCells("H3:H4");
		$sheet[0]->mergeCells("I3:I4");
		$sheet[0]->mergeCells("J3:J4");
		$sheet[0]->mergeCells("K3:K4");
		$sheet[0]->setCellValue('A3', "NO.");
		$sheet[0]->setCellValue('B3', "SATKER PENGUSUL");
		$sheet[0]->setCellValue('C3', "KAB/KOTA");
		$sheet[0]->setCellValue('D3', "JUDUL PROPOSAL AKTIVITAS");
		$sheet[0]->setCellValue('E3', "NO/TGL SURAT PENGANTAR");
		$sheet[0]->setCellValue('F3', "PROGRAM");
		$sheet[0]->setCellValue('G3', "INDIKATOR KINERJA UTAMA (IKU)");
		$sheet[0]->setCellValue('H3', "KEGIATAN");
		$sheet[0]->setCellValue('I3', "INDIKATOR KINERJA KEGIATAN (IKK)");
		$sheet[0]->setCellValue('J3', "TARGER KINERJA NASIONAL");
		$sheet[0]->setCellValue('K3', "TARGER KINERJA DAERAH");
		$sheet[0]->mergeCells("L3:S3");
		$sheet[0]->setCellValue('L3', "USULAN APBN");
		$sheet[0]->setCellValue('L4', "BELANJA PEGAWAI");
		$sheet[0]->setCellValue('M4', "BIAYA OPERASIONAL");
		$sheet[0]->setCellValue('N4', "BIAYA PELAKSANAAN KEGIATAN/PROGRAM");
		$sheet[0]->setCellValue('O4', "BIAYA OBAT");
		$sheet[0]->setCellValue('P4', "BIAYA FISIK BANGUNAN");
		$sheet[0]->setCellValue('Q4', "BIAYA ALKES");
		$sheet[0]->setCellValue('R4', "BIAYA KENDARAAN");
		$sheet[0]->setCellValue('S4', "TOTAL");
		
		
		$no=1;
		$idx=5;
		$total_bp=0;
		$total_op=0;
		$total_pel=0;
		$total_ob=0;
		$total_fis=0;
		$total_alk=0;
		$total_kend=0;
		$total_all=0;
		foreach($this->mm->get_proposal_belum_disetujui($TAHUN_ANGGARAN)->result() as $row){
			$sheet[0]->getStyle('A'.$idx.':E'.$idx)->getAlignment()->setWrapText(true); 
			$sheet[0]->getStyle('A'.$idx.':B'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$sheet[0]->getStyle('C'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet[0]->getStyle('D'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$sheet[0]->getStyle('E'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet[0]->getStyle('A'.$idx.':E'.$idx)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$sheet[0]->setCellValue('A'.$idx, $no);
			$sheet[0]->setCellValue('B'.$idx, $row->nmsatker);
			foreach($this->mm->get_where2('ref_kabupaten','KodeProvinsi',$row->kdlokasi,'KodeKabupaten',$row->kdkabkota)->result() as $tes2)			
				$sheet[0]->setCellValue('C'.$idx, $tes2->NamaKabupaten);
			$sheet[0]->setCellValue('D'.$idx, $row->JUDUL_PROPOSAL);
			$tanggal = explode('-', $row->TANGGAL_PENGAJUAN);
			$sheet[0]->setCellValue('E'.$idx, $row->NOMOR_SURAT.'/'.$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]);
			
			foreach($this->mm->get_where('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row4){
				$sheet[0]->getStyle('F'.$idx)->getAlignment()->setWrapText(true); 
				$sheet[0]->getStyle('F'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$sheet[0]->getStyle('F'.$idx)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$sheet[0]->setCellValue('F'.$idx, $row4->NamaProgram);
				$idx2 = $idx;
				foreach($this->mm->get_where_join('data_iku','ref_iku','data_iku.KodeIku=ref_iku.KodeIku','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row5){
					$sheet[0]->getStyle('G'.$idx2)->getAlignment()->setWrapText(true); 
					$sheet[0]->getStyle('G'.$idx2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$sheet[0]->getStyle('G'.$idx2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$sheet[0]->setCellValue('G'.$idx2, $row5->Iku);
					$idx2++;
				}
				if($this->mm->get_where_join('data_iku','ref_iku','data_iku.KodeIku=ref_iku.KodeIku','KD_PENGAJUAN',$row->KD_PENGAJUAN)->num_rows > 0)
					$idx2 =$idx2-1;
				foreach($this->mm->get_where2('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN, 'KodeProgram',$row4->KodeProgram)->result() as $row6){
					$sheet[0]->getStyle('H'.$idx)->getAlignment()->setWrapText(true); 
					$sheet[0]->getStyle('H'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$sheet[0]->getStyle('H'.$idx)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$sheet[0]->setCellValue('H'.$idx, $row6->NamaKegiatan);
					
					if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
						$biaya_bp = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '1', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
					else $biaya_bp = 0;
					if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
						$biaya_op = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '2', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
					else $biaya_op = 0;
					if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
						$biaya_pel = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '3', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
					else $biaya_pel = 0;
					if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
						$biaya_ob = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '4', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
					else $biaya_ob= 0;
					if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '5', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
						$biaya_fis = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '5', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
					else $biaya_fis= 0;
					if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '6', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
						$biaya_alk = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '6', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
					else $biaya_alk= 0;
					if($this->mm->cek2('aktivitas', 'KodeJenisUsulan', '7', 'KD_PENGAJUAN', $row->KD_PENGAJUAN))
						$biaya_kend = $this->mm->sum2('aktivitas', 'Jumlah', 'KodeJenisUsulan', '7', 'KD_PENGAJUAN', $row->KD_PENGAJUAN);
					else $biaya_kend= 0;
					$sheet[0]->getStyle('L'.$idx.':S'.$idx)->getAlignment()->setWrapText(true); 
					$sheet[0]->getStyle('L'.$idx.':S'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$sheet[0]->getStyle('L'.$idx.':S'.$idx)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					$sheet[0]->setCellValue('L'.$idx, "Rp.".number_format($biaya_bp));
					$sheet[0]->setCellValue('M'.$idx, "Rp.".number_format($biaya_op));
					$sheet[0]->setCellValue('N'.$idx, "Rp.".number_format($biaya_pel));
					$sheet[0]->setCellValue('O'.$idx, "Rp.".number_format($biaya_ob));
					$sheet[0]->setCellValue('P'.$idx, "Rp.".number_format($biaya_fis)); 
					$sheet[0]->setCellValue('Q'.$idx, "Rp.".number_format($biaya_alk)); 
					$sheet[0]->setCellValue('R'.$idx, "Rp.".number_format($biaya_kend)); 
					if($this->pm->sum('aktivitas','Jumlah','KD_PENGAJUAN', $row->KD_PENGAJUAN)) 
						$biaya_total = $this->mm->sum('aktivitas','Jumlah','KD_PENGAJUAN', $row->KD_PENGAJUAN);
					else $biaya_total=0;
						$sheet[0]->setCellValue('S'.$idx, "Rp.".number_format($biaya_total)); 
					
					$total_bp += $biaya_bp;
					$total_op += $biaya_op;
					$total_pel += $biaya_pel;
					$total_ob += $biaya_ob;
					$total_fis += $biaya_fis;
					$total_alk += $biaya_alk;
					$total_kend += $biaya_kend;
					$total_all += $biaya_total;
					
					$idx3 = $idx;
					foreach($this->mm->get_where3_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN, 'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){
						$sheet[0]->getStyle('I'.$idx3.':K'.$idx3)->getAlignment()->setWrapText(true); 
						$sheet[0]->getStyle('I'.$idx3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						$sheet[0]->getStyle('J'.$idx3.':K'.$idx3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$sheet[0]->getStyle('I'.$idx3.':K'.$idx3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$sheet[0]->setCellValue('I'.$idx3, $row7->Ikk);
						if($this->mm->cek('target_ikk','KodeIkk',$row7->KodeIkk))
							$target_nasional = $this->mm->get_where('target_ikk','KodeIkk',$row7->KodeIkk)->row()->TargetNasional;
						else $target_nasional = '0';
							$sheet[0]->setCellValue('J'.$idx3, $target_nasional.'%');
							$jumlah_ikk = $this->mm->get_where('data_ikk','KodeIkk',$row7->KodeIkk)->row()->Jumlah;
							$sheet[0]->setCellValue('K'.$idx3, $jumlah_ikk.'%');
						
						$idx3++;
					}
					if($this->mm->get_where3_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN, 'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->num_rows > 0)
						$idx3= $idx3-1;
				}
				if($idx3>=$idx2){
					$sheet[0]->mergeCells("A".$idx.":A".$idx3);
					$sheet[0]->mergeCells("B".$idx.":B".$idx3);
					$sheet[0]->mergeCells("C".$idx.":C".$idx3);
					$sheet[0]->mergeCells("D".$idx.":D".$idx3);
					$sheet[0]->mergeCells("E".$idx.":E".$idx3);
					$sheet[0]->mergeCells("F".$idx.":F".$idx3);
					$sheet[0]->mergeCells("H".$idx.":H".$idx3);
					$sheet[0]->mergeCells("J".$idx.":J".$idx3);
					$sheet[0]->mergeCells("K".$idx.":K".$idx3);
					$sheet[0]->mergeCells("L".$idx.":L".$idx3);
					$sheet[0]->mergeCells("M".$idx.":M".$idx3);
					$sheet[0]->mergeCells("N".$idx.":N".$idx3);
					$sheet[0]->mergeCells("O".$idx.":O".$idx3);
					$sheet[0]->mergeCells("P".$idx.":P".$idx3);
					$sheet[0]->mergeCells("Q".$idx.":Q".$idx3);
					$sheet[0]->mergeCells("R".$idx.":R".$idx3);
					$sheet[0]->mergeCells("S".$idx.":S".$idx3);
					$idx=$idx3;
					}
				elseif($idx2 > $idx){
					$sheet[0]->mergeCells("A".$idx.":A".$idx2);
					$sheet[0]->mergeCells("B".$idx.":B".$idx2);
					$sheet[0]->mergeCells("C".$idx.":C".$idx2);
					$sheet[0]->mergeCells("D".$idx.":D".$idx2);
					$sheet[0]->mergeCells("E".$idx.":E".$idx2);
					$sheet[0]->mergeCells("F".$idx.":F".$idx2);
					$sheet[0]->mergeCells("H".$idx.":H".$idx2);
					$sheet[0]->mergeCells("J".$idx.":J".$idx2);
					$sheet[0]->mergeCells("K".$idx.":K".$idx2);
					$sheet[0]->mergeCells("L".$idx.":L".$idx2);
					$sheet[0]->mergeCells("M".$idx.":M".$idx2);
					$sheet[0]->mergeCells("N".$idx.":N".$idx2);
					$sheet[0]->mergeCells("O".$idx.":O".$idx2);
					$sheet[0]->mergeCells("P".$idx.":P".$idx2);
					$sheet[0]->mergeCells("Q".$idx.":Q".$idx2);
					$sheet[0]->mergeCells("R".$idx.":R".$idx2);
					$sheet[0]->mergeCells("S".$idx.":S".$idx2);
					$idx=$idx2;
					}
				else
					$idx=$idx;
			}
			$no++;
			$idx++;
		}
		// Total Biaya
		$sheet[0]->getStyle("A".$idx.":K".$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet[0]->getStyle("A".$idx.":K".$idx)->applyFromArray(array("font" => array( "bold" => true)));
		$sheet[0]->mergeCells("A".$idx.":K".$idx);
		$sheet[0]->setCellValue("A".$idx, "TOTAL");
		$sheet[0]->getStyle('L'.$idx.':S'.$idx)->getAlignment()->setWrapText(true); 
		$sheet[0]->getStyle('L'.$idx.':S'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$sheet[0]->getStyle('L'.$idx.':S'.$idx)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$sheet[0]->setCellValue('L'.$idx, "Rp.".number_format($total_bp));
		$sheet[0]->setCellValue('M'.$idx, "Rp.".number_format($total_op));
		$sheet[0]->setCellValue('N'.$idx, "Rp.".number_format($total_pel));
		$sheet[0]->setCellValue('O'.$idx, "Rp.".number_format($total_ob));
		$sheet[0]->setCellValue('P'.$idx, "Rp.".number_format($total_fis)); 
		$sheet[0]->setCellValue('Q'.$idx, "Rp.".number_format($total_alk)); 
		$sheet[0]->setCellValue('R'.$idx, "Rp.".number_format($total_kend)); 
		$sheet[0]->setCellValue('S'.$idx, "Rp.".number_format($total_all)); 
		
		
		$colorTotal = array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID, 
							'color' => array('rgb' => '7CCF29')
						)
					);
		$sheet[0]->getStyle("S3:S".$sheet[0]->getHighestRow())->applyFromArray($colorTotal);
		$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
		$sheet[0]->getStyle('A3:S'.$sheet[0]->getHighestRow())->applyFromArray($styleArray);
		
		$sheet[0]->setTitle("SHEET 1");
		// $sheet[1] = $phpExcel->createSheet();
		// $sheet[1]->setCellValue("A5", "A Lima");
		// $sheet[1]->setTitle("Simple");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="REKAP PROPOSAL DAERAH.xlsx"');
        header('Cache-Control: max-age=0');
		 
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function grid_file(){
		//$this->cek_session();
		$colModel['no'] = array('No',20,TRUE,'center',0);
		$colModel['namaFile'] = array('File',300,TRUE,'center',1);
		$colModel['DOWNLOAD'] = array('Download',50,TRUE,'center',0);
		$colModel['restore'] = array('Restore',50,FALSE,'center',0);
		$colModel['DELETE'] = array('Delete',50,TRUE,'center',0);
			
		$gridParams = array(
			'width' => 'auto',
			'height' => '298',
			'rp' => 15,
			'rpOptions' => '[15,30,50,100]',
			'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
			'blockOpacity' => 0,
			'title' => 'DAFTAR FILE',
			'showTableToggleBtn' => false
		);
				
		$buttons[] = array('Salin Data','add','spt_js');
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){	
			if (com=='Salin Data'){
				location.href= '".site_url()."/e-planning/utility/unduh_database';    
			}			
		} </script>";
		$data['notification'] = "";
		if($this->session->userdata('notification')!=''){
			$data['notification'] = "
				<script>
					$(document).ready(function() {
						$.growlUI('Pesan :', '".$this->session->userdata('notification')."');
					});
				</script>
			";
		}
		$url = base_url()."index.php/e-planning/utility/list_file";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons);
		$data['database'] = "";
		$data['js_grid'] = $grid_js;
		$data['judul'] = 'Daftar File';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	 
	function list_file(){
		$valid_fields = array('namaFile');
		$this->flexigrid->validate_post('namaFile','asc',$valid_fields);
		$records = $this->umo->get_flexigrid('data_file');

		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
		foreach ($records['records']->result() as $row){
			$no = $no+1;
			$record_items[] = array(
				$no,
				$no,
				$row->namaFile,
				'<a href=\''.base_url().'file/backup/'.$row->namaFile.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href=\''.base_url().'index.php/e-planning/utility/restore_db/'.$row->namaFile.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/magnifier.png\'></a>',
				'<a href='.base_url().'index.php/e-planning/utility/deleteFile/'.$row->idFile.'/'.$row->namaFile.' onclick="return confirm(\'Anda yakin ingin menghapus ?\')"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>'
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function deleteFile($idFile,$namaFile){
		$this->umo->delete('data_file','idFile',$idFile);
		unlink($_SERVER['DOCUMENT_ROOT'].'/depkes/depkes/file/backup/'.$namaFile);
		redirect('e-planning/utility/grid_file');
	}
	
	function insert_results(){
		//Upload file
		$config['upload_path'] = './file/';
		$config['allowed_types'] = 'csv|xls|sql';
		$config['max_size']  = '1024';

		$this->load->library('upload', $config);
		 
		// create directory if doesn't exist
		if(!is_dir($config['upload_path']))
		mkdir($config['upload_path'], 0777);
		  
		if(!$this->upload->do_upload())
		{
			$data['error'] = 'Error';
			$data['content'] = $this->load->view('database_view',$data,true);
			$this->load->view('main',$data);
		}
		else
		{
			//Insert CSV Data into database
			$data = array('upload_data' => $this->upload->data());
			$filePath1 = './file/';
			$filePath2 = $data['upload_data']['file_name'];
			$filePath = $filePath1 . $filePath2;
			$data['success'] = 'Database sukses terupdate';
			$data['content'] = $this->load->view('database_view',$data,true);
			if($data['upload_data']['file_ext'] == '.csv'){
				$this->load->library('csvreader');
				$data['csvData'] = $this->csvreader->parse_file($filePath);
				foreach($data['csvData'] as $cd){
					$temp = explode(' ', $cd['NAMA_PT']);
					$sekolah_tinggi = $temp[0].' '.$temp[1];
					if($temp[0] == 'Universitas'){
						$kode_jenis_pt = '1';
					}else if($temp[0] == 'Institut'){
						$kode_jenis_pt = '3';
					}else if($sekolah_tinggi == 'Sekolah Tinggi'){
						$kode_jenis_pt = '2';
					}else if($temp[0] == 'Akademi'){
						$kode_jenis_pt = '4';
					}else if($temp[0] == 'Politeknik'){
						$kode_jenis_pt = '5';
					}
				   $results_array = array(
										   'PTI' => $cd['PTI'],
										   'KODE_JENIS_PT' => $kode_jenis_pt,
										   'KODE_REGION' => 1,
										   'ID_NEGARA' => 1,
										   'KDPTI' => $cd['KDPTI'],
										   'NAMA_PT' => str_replace('\n', ',', $cd['NAMA_PT']),
										   'ALAMAT_PT' => str_replace('\n', ',', $cd['ALAMAT_PT']),
										   'WEBSITE_PT' => str_replace('\n', ',', $cd['WEBSITE_PT']),
										   'TELP_PT' => str_replace('\n', ',', $cd['TELP_PT']),
										   'EMAIL_PT' => str_replace('\n', ',', $cd['EMAIL_PT'])
								   );
					$cek_pt = $this->user_model->get_nama_perguruan_tinggi($cd['PTI']);
					if($cek_pt->num_rows()>0){
						$this->laporan_m->update_db($results_array,$cd['PTI']);
					}else{
						$this->laporan_m->insert_db($results_array);
					}
				 }
				 $data['success'] = 'Database sukses terupdate';
				 $data['content'] = $this->load->view('database_view',$data,true);
				 $this->load->view('main', $data);
			}else if($data['upload_data']['file_ext'] == '.xls'){
				$this->load->library('spreadsheet_excel_reader');
				$this->spreadsheet_excel_reader->setOutputEncoding('CP1251'); // Set output Encoding.
				$this->spreadsheet_excel_reader->read($filePath); // relative path to .xls that was uploaded earlier
				//$j = -1;
				$row_count = count($this->spreadsheet_excel_reader->sheets[0]['cells']);
				
				for ($i=2; $i <= $row_count; $i++){ 
				  //$j++;
				  $temp = explode(' ', $this->spreadsheet_excel_reader->sheets[0]['cells'][$i][3]);
				  $sekolah_tinggi = $temp[0].' '.$temp[1];
				  if($temp[0] == 'Universitas'){
				 	$kode_jenis_pt = '1';
					}else if($temp[0] == 'Institut'){
						$kode_jenis_pt = '3';
					}else if($sekolah_tinggi == 'Sekolah Tinggi'){
						$kode_jenis_pt = '2';
					}else if($temp[0] == 'Akademi'){
						$kode_jenis_pt = '4';
					}else if($temp[0] == 'Politeknik'){
						$kode_jenis_pt = '5';
					}
				   $results_array = array(
										   'PTI' => $this->spreadsheet_excel_reader->sheets[0]['cells'][$i][1],
										   'KODE_JENIS_PT' => $kode_jenis_pt,
										   'KODE_REGION' => 1,
										   'ID_NEGARA' => 1,
										   'KDPTI' => $this->spreadsheet_excel_reader->sheets[0]['cells'][$i][2],
										   'NAMA_PT' => $this->spreadsheet_excel_reader->sheets[0]['cells'][$i][3],
										   'ALAMAT_PT' => $this->spreadsheet_excel_reader->sheets[0]['cells'][$i][4],
										   'WEBSITE_PT' => $this->spreadsheet_excel_reader->sheets[0]['cells'][$i][5],
										   'TELP_PT' => $this->spreadsheet_excel_reader->sheets[0]['cells'][$i][6],
										   'EMAIL_PT' => $this->spreadsheet_excel_reader->sheets[0]['cells'][$i][7]
								   );
					$cek_pt = $this->user_model->get_nama_perguruan_tinggi($this->spreadsheet_excel_reader->sheets[0]['cells'][$i][1]);
					if($cek_pt->num_rows()>0){
						$this->laporan_m->update_db($results_array,$this->spreadsheet_excel_reader->sheets[0]['cells'][$i][1]);
					}else{
						$this->laporan_m->insert_db($results_array);
					}
				}
				$data['success'] = 'Database sukses terupdate';
				$data['content'] = $this->load->view('database_view',$data,true);
				$this->load->view('main', $data);
			}else if($data['upload_data']['file_ext'] == '.sql'){
				$input = $this->load->file($filePath, true);
				$file_array = explode(';',$input);
				foreach($file_array as $query){
					$this->laporan_m->insert_db2($query);
				}
				$data['success'] = 'Database sukses terupdate';
				$data['content'] = $this->load->view('database_view',$data,true);
				$this->load->view('main', $data);
			}
		}
	}
	
	function unduh_database(){
		ini_set("memory_limit","2000M");
		$prefs = array(
                'tables'      => array(),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
				'format'      => 'txt',             // gzip, zip, txt
                'filename'    => 'backup_'.date("d-m-Y").'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "::"               // Newline character used in backup file
              );
			  
		// Load the DB utility class
		$this->load->dbutil($prefs);

		// Backup your entire database and assign it to a variable
		// $backup =& $this->dbutil->backup($prefs);
		
		if(!is_dir('./file/backup')) mkdir('./file/backup', 0777);
				
		// Load the file helper and write the file to your server
		// write_file($_SERVER['DOCUMENT_ROOT'].'/depkes/depkes/file/backup/backup_'.date("d-m-Y").'.sql', $backup);
		// if($this->umo->cek_file('data_file','namaFile','backup_'.date("d-m-Y").'.sql')) $this->umo->save('data_file', array('namaFile'=>'backup_'.date("d-m-Y").'.sql'));
		
		echo exec('mysqldump -u root -h localhost depkes2 > '.$_SERVER['DOCUMENT_ROOT'].'sikkes/file/backup/backup_'.date("d-m-Y").'.sql');
		if($this->umo->cek_file('data_file','namaFile','backup_'.date("d-m-Y").'.sql')) $this->umo->save('data_file', array('namaFile'=>'backup_'.date("d-m-Y").'.sql'));
		 echo 'DB Backup-ed  '.$_SERVER['DOCUMENT_ROOT'].'  '.base_url();
		// redirect('e-planning/utility/grid_file');
		// Load the download helper and send the file to your desktop
		//force_download('backup_'.date("d-m-Y").'.sql.zip', $backup);
	}
	
	function loadView_yankes(){
		$data['upload_dak'] = "";
		$data['content'] = $this->load->view('e-planning/master/upload_yankes','',true);
		$this->load->view('main',$data);
	}
	
	function loadView_yandas(){
		$data['upload_dak'] = "";
		$data['content'] = $this->load->view('e-planning/master/upload_yandas','',true);
		$this->load->view('main',$data);
	}
	
	function loadView_dak_binfar(){
		$data['upload_dak'] = "";
		$data['content'] = $this->load->view('e-planning/master/upload_dak_binfar','',true);
		$this->load->view('main',$data);
	}
	
	function upload_yandas(){
		$config['upload_path'] = './file/dak/';
		$config['allowed_types'] = 'xls';
		$config['max_size']  = '10240';

		$this->load->library('upload', $config);
		
		// create directory if doesn't exist
		if(!is_dir($config['upload_path']))	mkdir($config['upload_path'], 0777);
		
		$file='';
		if(!empty($_FILES['file']['name'])){			
			$upload = $this->upload->do_upload('file');
			$data = $this->upload->data();
			if($data['file_size'] > 0) $file = $data['file_name'];
		}
		
		//redirect('e-planning/penfaftaran/pengajuan_step1');
		
		$filePath = './file/dak/'.$file;
		
		//$this->spreadsheet_excel_reader->setOutputEncoding('CP1251'); // Set output Encoding.
		$this->spreadsheet_excel_reader->read($filePath); // relative path to .xls that was uploaded earlier
		
		$row_count = count($this->spreadsheet_excel_reader->sheets[2]['cells']);
		
		for ($i=6; $i <= $row_count; $i++){
			$data_yandas = array(
				'Kode_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][1],
				'Nama_Satker_KabKota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][2],
				'Propinsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][3],
				'KabKota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][4],
				'Kriteria' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][5],
				'CP_Nama_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][6],
				'CP_HP_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][7],
				'CP_Email_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][8],
				'CP_Nama_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][9],
				'CP_HP_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][10],
				'CP_Email_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][11],
				'PUSTU_Jumlah' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][12],
				'PUSTU_Kondisi_Jumlah_Baik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][13],
				'PUSTU_Kondisi_Jumlah_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][14],
				'PUSTU_Kondisi_Jumlah_Rusak_Sedang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][15],
				'PUSTU_Kondisi_Jumlah_Rusak_Ringan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][16],
				'PUSTU_Jumlah_Peralatan_Ketersediaan_Ada' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][17],
				'PUSTU_Jumlah_Peralatan_Ketersediaan_Tidak_Ada' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][18],
				'PUSTU_Keterangan_Peralatan_Tidak_Tersedia' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][19],
				'PUSTU_Jumlah_Kelengkapan_Peralatan_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][20],
				'PUSTU_Jumlah_Kelengkapan_Peralatan_Tidak_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][21],
				'PUSTU_Keterangan_Peralatan_Tidak_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][22],
				'PUSTU_Jumlah_Kondisi_Peralatan_Bagus' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][23],
				'PUSTU_Jumlah_Kondisi_Peralatan_Rusak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][24],
				'PUSTU_Keterangan_Peralatan_Kondisi_Rusak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][25],
				'PUSTU_Usulan_Jumlah_Pembangunan_Baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][26],
				'PUSTU_Usulan_Biaya_Pembangunan_Baru_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][27],
				'PUSTU_Usulan_Rehab_PUSTU_hanya_pada_rusak_berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][28],
				'PUSTU_Usulan_Biaya_Rehab_PUSTU_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][29],
				'PUSTU_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][30],
				'Poskesdes_Jumlah_Desa' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][31],
				'Poskesdes' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][32],
				'Poskesdes_Usulan_Jumlah_Pemb_Baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][33],
				'Poskesdes_Usulan_Biaya_Pemb_Baru_per_unit_cost_Poskesdes' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][34],
				'Poskesdes_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][35],
				'Puskesmas_dan_Puskesmas_Perawatan_Jumlah_Kecamatan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][36],
				'Jenis_Puskesmas_non_perawatan'=>'Puskesmas non Perawatan',
				'PNP_Jumlah_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][37],
				'PNP_Kondisi_Jumlah_Baik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][38],
				'PNP_Kondisi_Jumlah_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][39],
				'PNP_Kondisi_Jumlah_Rusak_Sedang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][40],
				'PNP_Kondisi_Jumlah_Rusak_Ringan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][41],
				'PNP_Jumlah_Peralatan_Ketersediaan_Ada' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][42],
				'PNP_Jumlah_Peralatan_Ketersediaan_Tidak_Ada' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][43],
				'PNP_Keterangan_Peralatan_Tidak_Tersedia' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][44],
				'PNP_Jumlah_Kelengkapan_Peralatan_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][45],
				'PNP_Jumlah_Kelengkapan_Peralatan_Tidak_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][46],
				'PNP_Keterangan_Peralatan_Tidak_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][47],
				'PNP_Jumlah_Kondisi_Peralatan_Bagus' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][48],
				'PNP_Jumlah_Kondisi_Peralatan_Rusak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][49],
				'PNP_Keterangan_Peralatan_Kondisi_Rusak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][50],
				'PNP_Jumlah_Ada_IPL_Sederhana' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][51],
				'PNP_Jumlah_Tidak_Ada_IPL_Sederhana' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][52],
				'PNP_Usulan_Jumlah_Pemb_Baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][53],
				'PNP_Usulan_Biaya_Pemb_baru_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][54],
				'PNP_Jumlah_Rehab_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][55],
				'PNP_Usulan_Biaya_Rehab_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][56],
				'PNP_Usulan_Jumlah_Pemb_IPL_baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][57],
				'PNP_Usulan_Biaya_Pemb_IPL_Baru_per_cost_unit' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][58],
				'PNP_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][59],
				'Jenis_Puskesmas_perawatan'=>'Puskesmas Perawatan',
				'PP_Jumlah_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][60],
				'PP_Kondisi_Jumlah_Baik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][61],
				'PP_Kondisi_Jumlah_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][62],
				'PP_Kondisi_Jumlah_Rusak_Sedang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][63],
				'PP_Kondisi_Jumlah_Rusak_Ringan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][64],
				'PP_Jumlah_Peralatan_Ketersediaan_Ada' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][65],
				'PP_Jumlah_Peralatan_Ketersediaan_Tidak_Ada' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][66],
				'PP_Keterangan_Peralatan_Tidak_Tersedia' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][67],
				'PP_Jumlah_Kelengkapan_Peralatan_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][68],
				'PP_Jumlah_Kelengkapan_Peralatan_Tidak_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][69],
				'PP_Keterangan_Peralatan_Tidak_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][70],
				'PP_Jumlah_Kondisi_Peralatan_Bagus' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][71],
				'PP_Jumlah_Kondisi_Peralatan_Rusak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][72],
				'PP_Keterangan_Peralatan_Kondisi_Rusak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][73],
				'PP_Jumlah_Ada_IPL_Sederhana' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][74],
				'PP_Jumlah_Tidak_Ada_IPL_Sederhana' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][75],
				'PP_Usulan_Jumlah_Pemb_Baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][76],
				'PP_Usulan_Biaya_Pemb_baru_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][77],
				'PP_Jumlah_Rehab_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][78],
				'PP_Usulan_Biaya_Rehab_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][79],
				'PP_Usulan_Jumlah_Pemb_IPL_baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][80],
				'PP_Usulan_Biaya_Pemb_IPL_Baru_per_cost_unit' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][81],
				'PP_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][82],
				'Jenis_Puskesmas_Perawatan_Mampu_Poned'=>'Puskesmas Perawatan Mampu Poned',
				'PPMP_Jumlah_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][83],
				'PPMP_Kondisi_Jumlah_Baik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][84],
				'PPMP_Kondisi_Jumlah_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][85],
				'PPMP_Kondisi_Jumlah_Rusak_Sedang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][86],
				'PPMP_Kondisi_Jumlah_Rusak_Ringan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][87],
				'PPMP_Jumlah_Peralatan_Ketersediaan_Ada' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][88],
				'PPMP_Jumlah_Peralatan_Ketersediaan_Tidak_Ada' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][89],
				'PPMP_Keterangan_Peralatan_Tidak_Tersedia' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][90],
				'PPMP_Jumlah_Kelengkapan_Peralatan_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][91],
				'PPMP_Jumlah_Kelengkapan_Peralatan_Tidak_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][92],
				'PPMP_Keterangan_Peralatan_Tidak_Lengkap' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][93],
				'PPMP_Jumlah_Kondisi_Peralatan_Bagus' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][94],
				'PPMP_Jumlah_Kondisi_Peralatan_Rusak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][95],
				'PPMP_Keterangan_Peralatan_Kondisi_Rusak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][96],
				'PPMP_Jumlah_Ada_IPL_Sederhana' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][97],
				'PPMP_Jumlah_Tidak_Ada_IPL_Sederhana' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][98],
				'PPMP_Usulan_Jumlah_Pemb_Baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][99],
				'PPMP_Usulan_Biaya_Pemb_baru_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][100],
				'PPMP_Jumlah_Rehab_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][101],
				'PPMP_Usulan_Biaya_Rehab_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][102],
				'PPMP_Usulan_Jumlah_Pemb_IPL_baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][103],
				'PPMP_Usulan_Biaya_Pemb_IPL_Baru_per_cost_unit' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][104],
				'PPMP_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][105],
				'Jenis_Rumah_Dinas_DrDrg'=>'Rumah Dinas dr/drg',
				'RD_Jumlah_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][106],
				'RD_Kondisi_Jumlah_Baik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][107],
				'RD_Kondisi_Jumlah_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][108],
				'RD_Kondisi_Jumlah_Rusak_Sedang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][109],
				'RD_Kondisi_Jumlah_Rusak_Ringan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][110],
				'RD_Usulan_Jumlah_Pemb_Baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][111],
				'RD_Usulan_Biaya_Pemb_baru_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][112],
				'RD_Jumlah_Rehab_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][113],
				'RD_Usulan_Biaya_Rehab_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][114],
				'RD_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][115],
				'Jenis_Rumah_Dinas_Paramedis'=>'Rumah Dinas Paramedis',
				'RDP_Jumlah_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][116],
				'RDP_Kondisi_Jumlah_Baik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][117],
				'RDP_Kondisi_Jumlah_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][118],
				'RDP_Kondisi_Jumlah_Rusak_Sedang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][119],
				'RDP_Kondisi_Jumlah_Rusak_Ringan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][120],
				'RDP_Usulan_Jumlah_Pemb_Baru' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][121],
				'RDP_Usulan_Biaya_Pemb_baru_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][122],
				'RDP_Jumlah_Rehab_Rusak_Berat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][123],
				'RDP_Usulan_Biaya_Rehab_per_unit_cost' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][124],
				'RDP_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][125],
				'Jenis_Sarana_Prasarana'=>'Sanitarian Kit',
				'Jumlah_Puskesmas_yang_memiliki_Sanitarian_Kit' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][126],
				'Jumlah_Puskesmas_yang_Tidak_Memiliki_Sanitarian_Kit' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][127],
				'Sanitarian_Kit_Total_Puskesmas' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][128],
				'Sanitarian_Kit_Usulan_Penyediaan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][129],
				'Sanitarian_Kit_Usulan_Harga_Satuan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][130],
				'Sanitarian_Kit_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][131]
			);
			$this->masmo->save('yandas', $data_yandas);
			$Kode_Yandas;
			foreach($this->umo->get_max('Yandas', 'Kode_Yandas')->result() as $row){
				$Kode_Yandas=$row->Kode_Yandas;
			}
			
			$data_evaluasi_yandas_2009 = array(
				'Kode_Yandas'=>$Kode_Yandas,
				'Tahun_Evaluasi'=>'2009',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][132],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][133],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][134],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][135],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][136],
				'Jumlah_Pustu_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][137],
				'Jumlah_Poskesdes_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][138],
				'Jumlah_Puskesmas_Non_Perawatan_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][139],
				'Jumlah_Puskesmas_Perawatan_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][140],
				'Jumlah_Puskesmas_Perawatan_Mampu_PONED_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][141],
				'JumlahRumah_Dinas_DrDrg' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][142],
				'JumlahRumah_Dinas_Paramedis' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][143],
				'Lainnya' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][144]
			);
			
			$data_evaluasi_yandas_2010 = array(
				'Kode_Yandas'=>$Kode_Yandas,
				'Tahun_Evaluasi'=>'2010',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][145],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][146],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][147],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][148],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][149],
				'Jumlah_Pustu_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][150],
				'Jumlah_Poskesdes_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][151],
				'Jumlah_Puskesmas_Non_Perawatan_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][152],
				'Jumlah_Puskesmas_Perawatan_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][153],
				'Jumlah_Puskesmas_Perawatan_Mampu_PONED_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][154],
				'JumlahRumah_Dinas_DrDrg' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][155],
				'JumlahRumah_Dinas_Paramedis' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][156],
				'Lainnya' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][157]
			);
			
			$data_evaluasi_yandas_2011 = array(
				'Kode_Yandas'=>$Kode_Yandas,
				'Tahun_Evaluasi'=>'2011',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][158],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][159],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][160],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][161],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][162],
				'Jumlah_Pustu_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][163],
				'Jumlah_Poskesdes_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][164],
				'Jumlah_Puskesmas_Non_Perawatan_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][165],
				'Jumlah_Puskesmas_Perawatan_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][166],
				'Jumlah_Puskesmas_Perawatan_Mampu_PONED_yang_Dibangun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][167],
				'JumlahRumah_Dinas_DrDrg' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][168],
				'JumlahRumah_Dinas_Paramedis' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][169],
				'Lainnya' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][170],

			);
			
			$this->masmo->save('evaluasi_yandas', $data_evaluasi_yandas_2009);
			$this->masmo->save('evaluasi_yandas', $data_evaluasi_yandas_2010);
			$this->masmo->save('evaluasi_yandas', $data_evaluasi_yandas_2011);
		}
		redirect('e-planning/utility/sukses_yandas');
	}
	
	function sukses_yandas(){
		$data['upload_dak'] = "";
		$data['added_js'] = "<script> alert('Data telah berhasil diunggah'); </script>";
		$data['content'] = $this->load->view('e-planning/master/upload_yandas','',true);
		$this->load->view('main',$data);
	}
	
	function upload_yankes(){
		$config['upload_path'] = './file/dak/';
		$config['allowed_types'] = 'xls';
		$config['max_size']  = '10240';

		$this->load->library('upload', $config);
		
		// create directory if doesn't exist
		if(!is_dir($config['upload_path']))	mkdir($config['upload_path'], 0777);
		
		$file='';
		if(!empty($_FILES['file']['name'])){			
			$upload = $this->upload->do_upload('file');
			$data = $this->upload->data();
			if($data['file_size'] > 0) $file = $data['file_name'];
		}
		
		//redirect('e-planning/penfaftaran/pengajuan_step1');
		
		$filePath = './file/dak/'.$file;
		
		//$this->spreadsheet_excel_reader->setOutputEncoding('CP1251'); // Set output Encoding.
		$this->spreadsheet_excel_reader->read($filePath); // relative path to .xls that was uploaded earlier
		
		$row_count = count($this->spreadsheet_excel_reader->sheets[2]['cells']);
		
		for ($i=6; $i <= $row_count; $i++){
			$data_yankes = array(
				'Tahun_Sekarang'=>'2012',
				'Tahun_Usulan'=>'2013',
				'Kode_Satker_RS' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][1],
				'Nama_Satker_RS' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][2],
				'Propinsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][3],
				'KabupatenKota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][4],
				'Kriteria' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][5],
				'Kepemilikan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][6],
				'Jenis_RS' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][7],
				'Tipe_RS' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][8],
				'Akreditasi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][9],
				'CP_Nama_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][10],
				'CP_HP_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][11],
				'CP_Email_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][12],
				'CP_Nama_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][13],
				'CP_HP_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][14],
				'CP_Email_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][15],
				'PONEK_Jumlah_dokter_spesialis_anak' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][16],
				'PONEK_Jumlah_dokter_spesialis_Kebidan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][17],
				'PONEK_Tim_PONEK_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][18],
				'PONEK_Pelayanan_Darah_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][19],
				'PONEK_Usulan_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][20],
				'PONEK_Usulan_Biaya_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][21],
				'PONEK_Usulan_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][22],
				'PONEK_Usulan_Biaya_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][23],
				'PONEK_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][24],
				'TT_Jumlah_TT_Se_RS' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][25],
				'TT_Jumlah_TT_Kelas_III' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][26],
				'TT_Jumlah_BOR_RS' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][27],
				'TT_Jumlah_BOR_Kelas_III' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][28],
				'TT_Usulan_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][29],
				'TT_Usulan_Biaya_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][30],
				'TT_Usulan_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][31],
				'TT_Usulan_Biaya_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][32],
				'TT_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][33],
				'IPL_RS_Ketersediaan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][34],
				'IPL_RS_Standar' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][35],
				'IPL_RS_Dibangun_Tahun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][36],
				'IPL_RS_Kondisi_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][37],
				'IPL_RS_Usulan_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][38],
				'IPL_RS_Usulan_Biaya_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][39],
				'IPL_RS_Usulan_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][40],
				'IPL_RS_Usulan_Biaya_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][41],
				'IPL_RS_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][42],
				'UTD_di_RS_di_RS_Ketersediaan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][43],
				'UTD_di_RS_di_RS_Standar' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][44],
				'UTD_di_RS_di_RS_Dibangun_Tahun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][45],
				'UTD_di_RS_di_RS_Kondisi_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][46],
				'UTD_di_RS_di_RS_Usulan_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][47],
				'UTD_di_RS_di_RS_Usulan_Biaya_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][48],
				'UTD_di_RS_di_RS_Usulan_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][49],
				'UTD_di_RS_di_RS_Usulan_Biaya_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][50],
				'UTD_di_RS_di_RS_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][51],
				'BD_di_RS_di_RS_Ketersediaan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][52],
				'BD_di_RS_di_RS_Standar' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][53],
				'BD_di_RS_di_RS_Dibangun_Tahun' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][54],
				'BD_di_RS_di_RS_Kondisi_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][55],
				'BD_di_RS_di_RS_Usulan_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][56],
				'BD_di_RS_di_RS_Usulan_Biaya_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][57],
				'BD_di_RS_di_RS_Usulan_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][58],
				'BD_di_RS_di_RS_Usulan_Biaya_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][59],
				'BD_di_RS_di_RS_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][60],
				'IGD_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][61],
				'IGD_Kondisi_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][62],
				'IGD_Kondisi_Bangunan_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][63],
				'IGD_Usulan_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][64],
				'IGD_Usulan_Biaya_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][65],
				'IGD_Usulan_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][66],
				'IGD_Usulan_Biaya_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][67],
				'IGD_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][68],
				'ICU_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][69],
				'ICU_Kondisi_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][70],
				'ICU_Kondisi_Bangunan_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][71],
				'ICU_Usulan_Alat_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][72],
				'ICU_Usulan_Biaya_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][73],
				'ICU_Usulan_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][74],
				'ICU_Usulan_Biaya_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][75],
				'ICU_Usulan_Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][76]
			);
			$this->masmo->save('yankes', $data_yankes);
			$Kode_Desk_Yankes_Rujukan;
			foreach($this->umo->get_max('yankes', 'Kode_Desk_Yankes_Rujukan')->result() as $row){
				$Kode_Desk_Yankes_Rujukan=$row->Kode_Desk_Yankes_Rujukan;
			}
			
			$data_evaluasi_yankes_2008 = array(
				'Kode_Desk_Yankes_Rujukan'=>$Kode_Desk_Yankes_Rujukan,
				'Tahun_Evaluasi'=>'2008',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][77],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][78],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][79],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][80],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][81],
				'Hasil_TT_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][82],
				'Hasil_TT_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][83],
				'Hasil_RS_PONEK_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][84],
				'Hasil_RS_PONEK_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][85],
				'Hasil_IGD_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][86],
				'Hasil_IGD_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][87],
				'Hasil_Pelayanan_Darah_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][88],
				'Hasil_Pelayanan_Darah_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][89],
				'Hasil_IPL_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][90],
				'Hasil_IPL_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][91]
			);
			
			$data_evaluasi_yankes_2009 = array(
				'Kode_Desk_Yankes_Rujukan'=>$Kode_Desk_Yankes_Rujukan,
				'Tahun_Evaluasi'=>'2009',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][92],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][93],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][94],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][95],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][96],
				'Hasil_TT_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][97],
				'Hasil_TT_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][98],
				'Hasil_RS_PONEK_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][99],
				'Hasil_RS_PONEK_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][100],
				'Hasil_IGD_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][101],
				'Hasil_IGD_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][102],
				'Hasil_Pelayanan_Darah_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][103],
				'Hasil_Pelayanan_Darah_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][104],
				'Hasil_IPL_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][105],
				'Hasil_IPL_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][106]
			);
			
			$data_evaluasi_yankes_2010 = array(
				'Kode_Desk_Yankes_Rujukan'=>$Kode_Desk_Yankes_Rujukan,
				'Tahun_Evaluasi'=>'2010',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][107],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][108],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][109],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][110],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][111],
				'Hasil_TT_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][112],
				'Hasil_TT_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][113],
				'Hasil_RS_PONEK_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][114],
				'Hasil_RS_PONEK_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][115],
				'Hasil_IGD_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][116],
				'Hasil_IGD_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][117],
				'Hasil_Pelayanan_Darah_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][118],
				'Hasil_Pelayanan_Darah_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][119],
				'Hasil_IPL_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][120],
				'Hasil_IPL_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][121]
			);
			
			$data_evaluasi_yankes_2011 = array(
				'Kode_Desk_Yankes_Rujukan'=>$Kode_Desk_Yankes_Rujukan,
				'Tahun_Evaluasi'=>'2011',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][122],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][123],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][124],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][125],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][126],
				'Hasil_TT_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][127],
				'Hasil_TT_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][128],
				'Hasil_RS_PONEK_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][129],
				'Hasil_RS_PONEK_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][130],
				'Hasil_IGD_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][131],
				'Hasil_IGD_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][132],
				'Hasil_Pelayanan_Darah_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][133],
				'Hasil_Pelayanan_Darah_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][134],
				'Hasil_IPL_Alat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][135],
				'Hasil_IPL_Bangunan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][136]
			);
			
			$this->masmo->save('evaluasi_yankes', $data_evaluasi_yankes_2008);
			$this->masmo->save('evaluasi_yankes', $data_evaluasi_yankes_2009);
			$this->masmo->save('evaluasi_yankes', $data_evaluasi_yankes_2010);
			$this->masmo->save('evaluasi_yankes', $data_evaluasi_yankes_2011);
		}
		redirect('e-planning/utility/sukses_yankes');
	}
	
	function sukses_yankes(){
		$data['upload_dak'] = "";
		$data['added_js'] = "<script> alert('Data telah berhasil diunggah'); </script>";
		$data['content'] = $this->load->view('e-planning/master/upload_yankes','',true);
		$this->load->view('main',$data);
	}
	
	function upload_dak_binfar(){
		$config['upload_path'] = './file/dak/';
		$config['allowed_types'] = 'xls';
		$config['max_size']  = '10240';

		$this->load->library('upload', $config);
		
		// create directory if doesn't exist
		if(!is_dir($config['upload_path']))	mkdir($config['upload_path'], 0777);
		
		$file='';
		if(!empty($_FILES['file']['name'])){			
			$upload = $this->upload->do_upload('file');
			$data = $this->upload->data();
			if($data['file_size'] > 0) $file = $data['file_name'];
		}
		
		//redirect('e-planning/penfaftaran/pengajuan_step1');
		
		$filePath = './file/dak/'.$file;
		
		//$this->spreadsheet_excel_reader->setOutputEncoding('CP1251'); // Set output Encoding.
		$this->spreadsheet_excel_reader->read($filePath); // relative path to .xls that was uploaded earlier
		
		$row_count = count($this->spreadsheet_excel_reader->sheets[2]['cells']);
		
		for ($i=5; $i <= $row_count; $i++){
			$data_dak_binfar = array(
				'Tahun_Sekarang'=>'2012',
				'Tahun_Usulan'=>'2013',
				'Kode_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][1],
				'Nama_Satker_KabKota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][2],
				'Propinsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][3],
				'Kabkota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][4],
				'Kriteria' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][5],
				'CP_Nama_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][6],
				'CP_HP_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][7],
				'CP_Email_Kepala_Satker' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][8],
				'CP_Nama_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][9],
				'CP_HP_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][10],
				'CP_Email_Pelaksana_Desk' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][11],
				'Jumlah_Penduduk_tahun_sekarang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][12],
				'Jumlah_Penduduk_sesuai_SK_BupatiWalikota_tahun_sekarang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][13],
				'Anggaran_Obat_dan_Perbekalan_kesehatan_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][14],
				'Anggaran_Obat_dan_Perbekalan_kesehatan_JamkesmasGakin' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][15],
				'Anggaran_Obat_dan_Perbekalan_kesehatan_Pendapatan_asli_Puskesmas'=> $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][16],
				'Anggaran_Obat_dan_Perbekalan_kesehatan_sisa_stock_Obat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][17],
				'Usulan_Anggaran_Obat_dan_Perbekalan_Kesehatan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][18],
				'Jumlah_Bangunan_Instalasi_Farmasi_KabKota_tahun_sekarang' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][19],
				'Jumlah_Bangunan_Instalasi_Farmasi_KabKota_berdasarkan_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][20],
				'Tahun_Anggaran_APBD_untuk_Bangunan_Instalasi_Farmasi_KabKota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][21],
				'Jumlah_Bangunan_Instalasi_Farmasi_KabKota_berdasarkan_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][22],
				'Tahun_Anggaran_TP_untuk_Bangunan_Instalasi_Farmasi_KabKota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][23],
				'Jumlah_Bangunan_Instalasi_Farmasi_KabKota_berdasarkan_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][24],
				'Tahun_Anggaran_DAK_untuk_Bangunan_Instalasi_Farmasi_KabKota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][25],
				'Jumlah_Bangunan_Instalasi_Farmasi_KabKota__yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][26],
				'Jumlah_Bangunan_Instalasi_Farmasi_KabKota_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][27],
				'Prosentase_Kerusakan_Bangunan_Instalasi_Farmasi_KabKota' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][28],
				'Luas_Bangunan_Instalasi_Farmasi_KabKota_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][29],
				'Volume_Bangunan_Instalasi_Farmasi_KabKota_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][30],
				'Status_Kepemilikan_Bangunan_Instalasi_Farmasi_KabKota_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][31],
				'Lahan_siap_bangun_Instalasi_Farmasi_KabKota_' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][32],
				'Jumlah_Komputer'=> $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][33],
				'Jumlah_Komputer_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][34],
				'Tahun_Anggaran_APBD_untuk_komputer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][35],
				'Jumlah_Komputer_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][36],
				'Tahun_Anggaran_TP_untuk_komputer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][37],
				'Jumlah_Komputer_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][38],
				'Tahun_Anggaran_DAK_untuk_komputer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][39],
				'Jumlah_Komputer_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][40],
				'Jumlah_Komputer_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][41],
				'Prosentase_Kerusakan_Komputer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][42],
				'Jumlah_Printer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][43],
				'Jumlah_Printer_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][44],
				'Tahun_Anggaran_APBD_untuk_Printer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][45],
				'Jumlah_Printer_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][46],
				'Tahun_Anggaran_TP_untuk_Printer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][47],
				'Jumlah_Printer_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][48],
				'Tahun_Anggaran_DAK_untuk_Printer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][49],
				'Jumlah_Printer_yang_berfungsi'=> $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][50],
				'Jumlah_Printer_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][51],
				'Prosentase_Kerusakan_Printer' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][52],
				'Jumlah_Palet' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][53],
				'Jumlah_Palet_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][54],
				'Tahun_Anggaran_APBD_untuk_Palet' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][55],
				'Jumlah_Palet_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][56],
				'Tahun_Anggaran_TP_untuk_Palet' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][57],
				'Jumlah_Palet_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][58],
				'Tahun_Anggaran_DAK_untuk_Palet' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][59],
				'Jumlah_Palet_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][60],
				'Jumlah_Palet_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][61],
				'Prosentase_Kerusakan_Palet' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][62],
				'Jumlah_Handforklift' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][63],
				'Jumlah_Handforklift_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][64],
				'Tahun_Anggaran_APBD_untuk_Handforklift' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][65],
				'Jumlah_Handforklift_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][66],
				'Tahun_Anggaran_TP_untuk_Handforklift' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][67],
				'Jumlah_Handforklift_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][68],
				'Tahun_Anggaran_DAK_untuk_Handforklift' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][69],
				'Jumlah_Handforklift_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][70],
				'Jumlah_Handforklift_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][71],
				'Prosentase_Kerusakan_Handforklift' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][72],
				'Jumlah_Cold_chainPenyimpan_vaksin' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][73],
				'Jumlah_Cold_chainPenyimpan_vaksin_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][74],
				'Tahun_Anggaran_APBD_untuk_Cold_chainPenyimpan_vaksin' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][75],
				'Jumlah_Cold_chainPenyimpan_vaksin_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][76],
				'Tahun_Anggaran_TP_untuk_Cold_chainPenyimpan_vaksin' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][77],
				'Jumlah_Cold_chainPenyimpan_vaksin_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][78],
				'Tahun_Anggaran_DAK_untuk_Cold_chainPenyimpan_vaksin' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][79],
				'Jumlah_Cold_chainPenyimpan_vaksin_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][80],
				'Jumlah_Cold_chainPenyimpan_vaksin_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][81],
				'Prosentase_Kerusakan_Cold_chainPenyimpan_vaksin' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][82],
				'Jumlah__AC_split' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][83],
				'Jumlah__AC_split_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][84],
				'Tahun_Anggaran_APBD_untuk__AC_split' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][85],
				'Jumlah__AC_split_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][86],
				'Tahun_Anggaran_TP_untuk__AC_split' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][87],
				'Jumlah__AC_split_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][88],
				'Tahun_Anggaran_DAK_untuk__AC_split' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][89],
				'Jumlah__AC_split_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][90],
				'Jumlah__AC_split_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][91],
				'Prosentase_Kerusakan__AC_split' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][92],
				'Jumlah__Alarm' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][93],
				'Jumlah_Alarm_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][94],
				'Tahun_Anggaran_APBD_untuk__Alarm' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][95],
				'Jumlah__Alarm_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][96],
				'Tahun_Anggaran_TP_untuk__Alarm' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][97],
				'Jumlah__Alarm_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][98],
				'Tahun_Anggaran_DAK_untuk__Alarm' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][99],
				'Jumlah__Alarm_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][100],
				'Jumlah__Alarm_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][101],
				'Prosentase_Kerusakan__Alarm' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][102],
				'Jumlah__Faximile' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][103],
				'Jumlah__Faximile_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][104],
				'Tahun_Anggaran_APBD_untuk__Faximile' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][105],
				'Jumlah__Faximile_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][106],
				'Tahun_Anggaran_TP_untuk__Faximile' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][107],
				'Jumlah__Faximile_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][108],
				'Tahun_Anggaran_DAK_untuk__Faximile' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][109],
				'Jumlah__Faximile_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][110],
				'Jumlah__Faximile_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][111],
				'Prosentase_Kerusakan__Faximile' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][112],
				'Jumlah__Genset' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][113],
				'Jumlah__Genset_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][114],
				'Tahun_Anggaran_APBD_untuk__Genset' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][115],
				'Jumlah__Genset_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][116],
				'Tahun_Anggaran_TP_untuk__Genset' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][117],
				'Jumlah__Genset_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][118],
				'Tahun_Anggaran_DAK_untuk__Genset' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][119],
				'Jumlah__Genset_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][120],
				'Jumlah__Genset_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][121],
				'Prosentase_Kerusakan__Genset' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][122],
				'Jumlah__Sarana_Distribusi_Roda_4' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][123],
				'Jumlah__Sarana_Distribusi_Roda_4_yang_berasal_dari_anggaran_APBD' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][124],
				'Tahun_Anggaran_APBD_untuk__Sarana_Distribusi_Roda_4' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][125],
				'Jumlah__Sarana_Distribusi_Roda_4_yang_berasal_dari_anggaran_TP' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][126],
				'Tahun_Anggaran_TP_untuk__Sarana_Distribusi_Roda_4' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][127],
				'Jumlah__Sarana_Distribusi_Roda_4_yang_berasal_dari_anggaran_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][128],
				'Tahun_Anggaran_DAK_untuk__Sarana_Distribusi_Roda_4' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][129],
				'Jumlah__Sarana_Distribusi_Roda_4_yang_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][130],
				'Jumlah__Sarana_Distribusi_Roda_4_yang_tidak_berfungsi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][131],
				'Prosentase_Kerusakan__Sarana_Distribusi_Roda_4' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][132],
				'Kondisi_Geografis_wilayah' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][133],
				'Usulan_Pembangunan_Baru_IF_Gugus_PulauSatelit' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][134]
			);
			$this->masmo->save('dak_binfar', $data_dak_binfar);
			$Kode_DAK_Binfar;
			foreach($this->umo->get_max('dak_binfar', 'Kode_DAK_Binfar')->result() as $row){
				$Kode_DAK_Binfar=$row->Kode_DAK_Binfar;
			}
			
			$data_evaluasi_dak_binfar_2010 = array(
				'Kode_DAK_Binfar'=>$row->Kode_DAK_Binfar,
				'Tahun_Evaluasi'=>'2010',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][135],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][136],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][137],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][138],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][139],
				'Penyediaan_Obat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][140],
				'Pembangunan_IFK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][141],
				'Perluasan_IFK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][142],
				'Sarana_Distribusi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][143],
				'Sarana_Penyimpanan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][144],
				'Sarana_Pengaman' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][145],
				'Sarana_Pengolah_Data' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][146]
			);
			
			$data_evaluasi_dak_binfar_2011 = array(
				'Kode_DAK_Binfar'=>$row->Kode_DAK_Binfar,
				'Tahun_Evaluasi'=>'2011',
				'Pagu_DAK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][147],
				'Dana_Pendamping' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][148],
				'Total' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][149],
				'Realisasi_Keuangan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][150],
				'Realisasi_Fisik' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][151],
				'Penyediaan_Obat' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][152],
				'Pembangunan_IFK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][153],
				'Perluasan_IFK' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][154],
				'Sarana_Distribusi' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][155],
				'Sarana_Penyimpanan' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][156],
				'Sarana_Pengaman' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][157],
				'Sarana_Pengolah_Data' => $this->spreadsheet_excel_reader->sheets[2]['cells'][$i][158]
			);
			
			$this->masmo->save('evaluasi_dak_binfar', $data_evaluasi_dak_binfar_2010);
			$this->masmo->save('evaluasi_dak_binfar', $data_evaluasi_dak_binfar_2011);
		}
		redirect('e-planning/utility/sukses_dak_binfar');
	}
	
	function sukses_dak_binfar(){
		$data['upload_dak'] = "";
		$data['added_js'] = "<script> alert('Data telah berhasil diunggah'); </script>";
		$data['content'] = $this->load->view('e-planning/master/upload_dak_binfar','',true);
		$this->load->view('main',$data);
	}
	
	function restore_db($namaFile){
		$file = $this->load->file($_SERVER['DOCUMENT_ROOT'].'/depkes/depkes/file/backup/'.$namaFile, true);
		$query = explode('::', $file);
		for($i=0; $i<count($query)-1;$i++){
			if(!empty($query[$i])){
				$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
				$this->db->query($query[$i]);
				$this->db->query("SET FOREIGN_KEY_CHECKS = 1");
			}
		}
		redirect('e-planning/utility/grid_file');
	}
}
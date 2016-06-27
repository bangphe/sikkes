<?php
    ini_set("max_execution_time","1200");
    ini_set("max_input_time","1200");
    ini_set("post_max_size","4000M");
    ini_set("memory_limit","4000M"); 
    
    function newsheet($objPHPExcel, $sheetnumber) {
        $objPHPExcel->createSheet(NULL, $sheetnumber);
        $objPHPExcel->setActiveSheetIndex($sheetnumber);      
        

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(70);
        $sheet->getColumnDimension('C')->setWidth(70);
        $sheet->getColumnDimension('D')->setWidth(150);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(30);
        
        $objPHPExcel->getActiveSheet()->setTitle('Rekap');
    }    
    
    $sheetnumber = 0;
    $separator = "-|;|-";
    
/** Error reporting */
    error_reporting(E_ALL);

    date_default_timezone_set('Europe/London');

    /** Include PHPExcel */
    require_once APPPATH.'/libraries/PHPExcel.php';

    $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
    $cacheSettings = array( 'memoryCacheSize' => '32MB');
    PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
    
    // Add some data
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Rekap Rincian');
    
        // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Rekap');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(18);
    
    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->getColumnDimension('A')->setWidth(16);
    $sheet->getColumnDimension('B')->setWidth(70);
    $sheet->getColumnDimension('C')->setWidth(70);
    $sheet->getColumnDimension('D')->setWidth(150);
    $sheet->getColumnDimension('E')->setWidth(20);
    $sheet->getColumnDimension('F')->setWidth(20);
    $sheet->getColumnDimension('G')->setWidth(30);
    $sheet->getColumnDimension('H')->setWidth(30);
    $sheet->getColumnDimension('I')->setWidth(30);
    $sheet->getColumnDimension('J')->setWidth(30);
    
    $objPHPExcel->getActiveSheet()->mergeCells('G3:J3');
    $objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objPHPExcel->getActiveSheet()
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Unit/Satker/Komponen/Sub Komponen')
                ->setCellValue('C3', 'Akun')
                ->setCellValue('D3', 'Uraian Belanja')
                ->setCellValue('E3', 'Volume')
                ->setCellValue('F3', 'Harga Satuan')
                ->setCellValue('G3', 'Jumlah');
    
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true)->setSize(18);
    $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true)->setSize(18);
    $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true)->setSize(18);
    $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true)->setSize(18);
    $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true)->setSize(18);
    $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true)->setSize(18);
    $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true)->setSize(18);

    $total_unit = array();
    $total_satker = array();
    $total_kegiatan = array();
    $total = 0;
    if ($view) {
        $old_unit = "";
        $old_satker = "";
        $old_key = "";
        $countunit = 0;
        $countsatker = 0;

        foreach ($view as $key => $value) {
            $datas = explode($separator, $value);
            $nmunit = $datas[1];
            $nmsatker = $datas[2];
            $jumlah = $datas[7];
            $key = $datas[12];

            if ($old_unit != $nmunit) {
                $old_satker = "";
                $old_unit = $nmunit;
                $countunit++;
                $countsatker = 0;
                $total_unit[$countunit] = $jumlah;
                $total = $total + $jumlah;

            }
            else {
                $total_unit[$countunit] = $total_unit[$countunit] + $jumlah;
                $total = $total + $jumlah;
            }

            if ($old_satker != $nmsatker) {
                $old_satker = $nmsatker;
                $countsatker++;
                if (!isset($total_satker[$countunit])) {
                    $total_satker[$countunit] = array();
                }
                $total_satker[$countunit][$countsatker] = $jumlah;
            }
            else {
                $total_satker[$countunit][$countsatker] = $total_satker[$countunit][$countsatker] + $jumlah;
            }

            if ($old_key != $key) {
                $old_key = $key;
                if (!isset($total_kegiatan[$countunit])) {
                    $total_kegiatan[$countunit] = array();
                }
                if (!isset($total_kegiatan[$countunit][$countsatker])) {
                    $total_kegiatan[$countunit][$countsatker] = array();
                }
                $total_kegiatan[$countunit][$countsatker][$key] = $jumlah;
            } else {
                $total_kegiatan[$countunit][$countsatker][$key] = $total_kegiatan[$countunit][$countsatker][$key] + $jumlah;
            }
        }
    }
    $count = 3;

    if ($view) {
        $old_unit = "";
        $old_satker = "";
        $old_komponen = "";
        $countunit = 0;
        $countsatker = 0;
        $countkomponen = 0;
        foreach ($view as $key => $value) {
            $datas = explode($separator, $value);
            $nmunit = $datas[1];
            $nmsatker = $datas[2];
            $nmitem = $datas[3];
            $volkeg = $datas[4];
            $satkeg = $datas[5];
            $hargasat = $datas[6];
            $jumlah = $datas[7];
            $akun = $datas[8];
            $komponen = $datas[10];
            $skomponen = $datas[11];
            $key = $datas[12];
            if ($old_unit != $nmunit) {
                if ($count == 65530) {
                    $sheetnumber++;
                    $count = 0;
                    newsheet($objPHPExcel, $sheetnumber);
                }
                $count++;
                $old_satker = "";
                $old_unit = $nmunit;
                $countunit++;
                $countsatker = 0;
                $countkomponen = 0;
                
                $keys = explode("-", $key);
                $kdsatker = $keys[2];
                $kdunit = $keys[4];
                $kdkmpnen = $keys[12];                

                $objPHPExcel->getActiveSheet()->getCell('A'.$count)->setValueExplicit($kdunit, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()
                ->setCellValue('B'.$count, $nmunit)
                ->setCellValue('C'.$count, '')
                ->setCellValue('D'.$count, '')
                ->setCellValue('E'.$count, '')
                ->setCellValue('F'.$count, '')
                ->setCellValue('G'.$count, '')
                ->setCellValue('H'.$count, '')
                ->setCellValue('I'.$count, '')
                ->setCellValue('J'.$count, number_format($total_unit[$countunit], 0, ',', ','));
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$count)->getFont()->setBold(true)->setSize(16);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$count)->getFont()->setBold(true)->setSize(16);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$count)->getFont()->setBold(true)->setSize(16);
            }     

            if ($old_satker != $nmsatker) {
                if ($count == 65530) {
                    $sheetnumber++;
                    $count = 0;
                    newsheet($objPHPExcel, $sheetnumber);
                }                
                $count++;
                $old_satker = $nmsatker;
                $countsatker++;
                $countkomponen = 0;
                
                $keys = explode("-", $key);
                $kdsatker = $keys[2];
                $kdunit = $keys[4];
                $kdkmpnen = $keys[12];                

                $objPHPExcel->getActiveSheet()->getCell('A'.$count)->setValueExplicit($kdunit.".".$kdsatker, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()
//                ->setCellValue('A'.$count, $kdunit.".".$kdsatker)
                ->setCellValue('B'.$count, $nmsatker)
                ->setCellValue('C'.$count, '')
                ->setCellValue('D'.$count, '')
                ->setCellValue('E'.$count, '')
                ->setCellValue('F'.$count, '')
                ->setCellValue('G'.$count, '')
                ->setCellValue('H'.$count, '')
                ->setCellValue('I'.$count, number_format($total_satker[$countunit][$countsatker], 0, ',', ','))
                ->setCellValue('J'.$count, '');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$count)->getFont()->setBold(true)->setSize(14);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$count)->getFont()->setBold(true)->setSize(14);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$count)->getFont()->setBold(true)->setSize(14);
            }    

            if ($old_komponen != $komponen) {
                if ($count == 65530) {
                    $sheetnumber++;
                    $count = 0;
                    newsheet($objPHPExcel, $sheetnumber);
                }
                $count++;
                $old_komponen = $komponen;
                $countkomponen++;
                
                $keys = explode("-", $key);
                $kdsatker = $keys[2];
                $kdunit = $keys[4];
                $kdkmpnen = $keys[12];                

                $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.$count, '')
                ->setCellValue('B'.$count, $komponen)
                ->setCellValue('C'.$count, '')
                ->setCellValue('D'.$count, '')
                ->setCellValue('E'.$count, '')
                ->setCellValue('F'.$count, '')
                ->setCellValue('G'.$count, '')
                ->setCellValue('H'.$count, '')
                ->setCellValue('I'.$count, '')
                ->setCellValue('J'.$count, '');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$count)->getFont()->setBold(true)->setSize(12);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$count)->getFont()->setBold(true)->setSize(12);
            }

            if ($old_key != $key) {
                if ($count == 65530) {
                    $sheetnumber++;
                    $count = 0;
                    newsheet($objPHPExcel, $sheetnumber);
                }                
                $count++;
                $old_key = $key;

                $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.$count, '')
                ->setCellValue('B'.$count, $skomponen)
                ->setCellValue('C'.$count, '')
                ->setCellValue('D'.$count, '')
                ->setCellValue('E'.$count, '')
                ->setCellValue('F'.$count, '')
                ->setCellValue('G'.$count, '')
                ->setCellValue('H'.$count, number_format($total_kegiatan[$countunit][$countsatker][$key], 0, ',', ','))
                ->setCellValue('I'.$count, '')
                ->setCellValue('J'.$count, '');
                
                $objPHPExcel->getActiveSheet()->getStyle('B'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            }
            
            if ($count == 65530) {
                $sheetnumber++;
                $count = 0;
                newsheet($objPHPExcel, $sheetnumber);
            }
            $count++;          
            $objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$count, '')
            ->setCellValue('B'.$count, '')
            ->setCellValue('C'.$count, $akun)
            ->setCellValue('D'.$count, $nmitem)
            ->setCellValue('E'.$count, number_format($volkeg, 0, ',', ',') . " " . $satkeg)
            ->setCellValue('F'.$count, number_format($hargasat, 0, ',', ','))
            ->setCellValue('G'.$count, number_format($jumlah, 0, ',', ','))
            ->setCellValue('H'.$count, '')
            ->setCellValue('I'.$count, '')
            ->setCellValue('J'.$count, '');
            
            $objPHPExcel->getActiveSheet()->getStyle('E'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }
    }
    if ($count == 65530) {
        $sheetnumber++;
        $count = 0;
        newsheet($objPHPExcel, $sheetnumber);
    }    
    $count++;
  
    $objPHPExcel->getActiveSheet()
    ->setCellValue('A'.$count, 'Jumlah')
    ->setCellValue('J'.$count, number_format($total, 0, ',', ','));
    $objPHPExcel->getActiveSheet()->getStyle('A'.$count)->getFont()->setBold(true)->setSize(18);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$count)->getFont()->setBold(true)->setSize(18);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    
    header('Content-type: application/ms-excel');
    header('Content-Disposition: attachment; filename="Rekap Rincian - '.$nmunit.'.xls"');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    //ob_end_clean();
    $objWriter->save('php://output');
    
//    $date = new DateTime();
//    $sdate = $date->format('U');
//    $filenameexcel = "download/RekapRincian".$sdate.".xls";
//    $objWriter->save($filenameexcel);  
//    
//    $filenamezip_nopath = "RekapRincian".$sdate.".zip";
//    $filenameexcel_nopath = "RekapRincian".$sdate.".xlsx";
//    $path = "H:/svndepkes/trunk/src/sikkes/download/";
//    
//    exec("zip -j $path".$filenamezip_nopath." $path".$filenameexcel_nopath);
//    $filenameexcel = "download/RekapRincian".$sdate.".xlsx";
//    $filenamezip = "download/RekapRincian".$sdate.".zip";
//    //unlink($filenameexcel);
//    
//    // http headers for zip downloads
//    header("Pragma: public");
//    header("Expires: 0");
//    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//    header("Cache-Control: public");
//    header("Content-Description: File Transfer");
//    header("Content-type: application/octet-stream");
//    header("Content-Disposition: attachment; filename=\"".$filenamezip_nopath."\"");
//    header("Content-Transfer-Encoding: binary");
//    header("Content-Length: ".filesize($filenamezip));
//    ob_end_flush();
//    @readfile($filenamezip);
?>
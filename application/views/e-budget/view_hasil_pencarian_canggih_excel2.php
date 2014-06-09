<?php
ini_set("max_execution_time","1200");
ini_set("max_input_time","1200");
ini_set("post_max_size","1500M");
ini_set("memory_limit","1500M");

/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** Include PHPExcel */
require_once APPPATH.'/libraries/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Kementerian Kesehatan")
							 ->setLastModifiedBy("Kementerian Kesehatan")
							 ->setTitle("Dokumen Pencairan Canggih")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
?>
                                    <?php
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue('A1', 'Rekap Rincian');
                                    
                                    $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue('A2', 'No')
                                                ->setCellValue('B2', 'Unit/Satker/Komponen/Sub Komponen')
                                                ->setCellValue('C2', 'Akun')
                                                ->setCellValue('D2', 'Uraian Belanja')
                                                ->setCellValue('E2', 'Volume')
                                                ->setCellValue('F2', 'Harga Satuan')
                                                ->setCellValue('G2', 'Jumlah');
                                    ?>
                                    <?php
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
                                            $datas = explode("-;-", $value);
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
                                    ?>

                                    <?php
                                    $count = 0;
                                    
                                    if ($view) {
                                        $old_unit = "";
                                        $old_satker = "";
                                        $old_komponen = "";
                                        $countunit = 0;
                                        $countsatker = 0;
                                        $countkomponen = 0;
                                        foreach ($view as $key => $value) {
                                            $count++;
                                            $mod = $count % 2;
                                            $datas = explode("-;-", $value);
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
                                            ?>
                                            <?php
                                            if ($old_unit != $nmunit) {
                                                $old_satker = "";
                                                $old_unit = $nmunit;
                                                $countunit++;
                                                $countsatker = 0;
                                                $countkomponen = 0;
                                                ?>
                                                <?php
                                                $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue('A'.$count, $countunit)
                                                ->setCellValue('B'.$count, $nmunit)
                                                ->setCellValue('C'.$count, '')
                                                ->setCellValue('D'.$count, '')
                                                ->setCellValue('E'.$count, '')
                                                ->setCellValue('F'.$count, '')
                                                ->setCellValue('G'.$count, '')
                                                ->setCellValue('H'.$count, '')
                                                ->setCellValue('I'.$count, '')
                                                ->setCellValue('J'.$count, $total_unit[$countunit]);
                                                ?>
            <?php
        }
        ?>

                                            <?php
                                            if ($old_satker != $nmsatker) {
                                                $old_satker = $nmsatker;
                                                $countsatker++;
                                                $countkomponen = 0;
                                                ?>

                                                <?php
                                                $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue('A'.$count, $countunit.".".$countsatker)
                                                ->setCellValue('B'.$count, $nmsatker)
                                                ->setCellValue('C'.$count, '')
                                                ->setCellValue('D'.$count, '')
                                                ->setCellValue('E'.$count, '')
                                                ->setCellValue('F'.$count, '')
                                                ->setCellValue('G'.$count, '')
                                                ->setCellValue('H'.$count, '')
                                                ->setCellValue('I'.$count, $total_satker[$countunit][$countsatker])
                                                ->setCellValue('J'.$count, '');
                                                ?>
            <?php
        }
        ?>
                                                
                                                
                                            <?php
                                                if ($old_komponen != $komponen) {
                                                    $old_komponen = $komponen;
                                                    $countkomponen++;
                                                ?>

                                                <?php
                                                $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue('A'.$count, $countunit.".".$countsatker.".".$countkomponen)
                                                ->setCellValue('B'.$count, $komponen)
                                                ->setCellValue('C'.$count, '')
                                                ->setCellValue('D'.$count, '')
                                                ->setCellValue('E'.$count, '')
                                                ->setCellValue('F'.$count, '')
                                                ->setCellValue('G'.$count, '')
                                                ->setCellValue('H'.$count, '')
                                                ->setCellValue('I'.$count, '')
                                                ->setCellValue('J'.$count, '');
                                                ?>
            <?php
        }
        ?>    
                                                                                
                                            <?php
                                            if ($old_key != $key) {
                                                $old_key = $key;
                                                ?>

                                                <?php
                                                $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue('A'.$count, '')
                                                ->setCellValue('B'.$count, $skomponen)
                                                ->setCellValue('C'.$count, '')
                                                ->setCellValue('D'.$count, '')
                                                ->setCellValue('E'.$count, '')
                                                ->setCellValue('F'.$count, '')
                                                ->setCellValue('G'.$count, '')
                                                ->setCellValue('H'.$count, $total_kegiatan[$countunit][$countsatker][$key])
                                                ->setCellValue('I'.$count, '')
                                                ->setCellValue('J'.$count, '');
                                                ?>
                                                <?php
                                            }
                                            ?>

                                                <?php
                                                $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue('A'.$count, '')
                                                ->setCellValue('B'.$count, '')
                                                ->setCellValue('C'.$count, $akun)
                                                ->setCellValue('D'.$count, $nmitem)
                                                ->setCellValue('E'.$count, number_format($volkeg, 0, ',', ','). " " . $satkeg)
                                                ->setCellValue('F'.$count, number_format($hargasat, 0, ',', ','))
                                                ->setCellValue('G'.$count, $jumlah)
                                                ->setCellValue('H'.$count, '')
                                                ->setCellValue('I'.$count, '')
                                                ->setCellValue('J'.$count, '');
                                                ?>
        <?php
    }
}
$objPHPExcel->getActiveSheet()->setTitle('Simple');
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientâ€™s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>

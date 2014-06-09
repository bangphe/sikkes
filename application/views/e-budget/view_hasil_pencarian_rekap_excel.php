<?php
ini_set("max_execution_time","1200");
ini_set("max_input_time","1200");
ini_set("post_max_size","1500M");
ini_set("memory_limit","1500M");
header("Expires: Mon, " . gmdate("D,d M YH:i:s") . " GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"Rekap.xls\"");
header("Content-Description: PHP/INTERBASE Generated Data");
readfile($export_file);

$separator = "-|;|-";
?>
<html> 
    <body>
        <!-- content start -->
        <div>
            <div >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top">
                            <div >
                                <h1>Rekap</h1>
                                <form method="post" action="daftarbelanja.php" name="daftarbelanja">
                                    <div>
                                        <table id="table_spacing" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="text-align:center"><h2><b>No</b></h2></td>
                                                <td style="text-align:center"><h2><b>Unit/Satker</b></h2></td>
                                                <td colspan="1" style="text-align:right"><h2><b>Jumlah</b></h2></td>
                                            </tr>
                                            <?php
                                            $total_unit = array();
                                            $total_satker = array();
                                            $total = 0;
                                            if ($view) {
                                                $old_unit = "";
                                                $old_satker = "";
                                                $countunit = 0;
                                                $countsatker = 0;

                                                foreach ($view as $key => $value) {
                                                    $datas = explode($separator, $value);
                                                    $nmunit = $datas[1];
                                                    $nmsatker = $datas[2];
                                                    $jumlah = $datas[7];

                                                    if ($old_unit != $nmunit) {
                                                        $old_satker = "";
                                                        $old_unit = $nmunit;
                                                        $countunit++;
                                                        $countsatker = 0;
                                                        $total_unit[$countunit] = $jumlah;
                                                        $total = $total + $jumlah;
                                                    } else {
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
                                                    } else {
                                                        $total_satker[$countunit][$countsatker] = $total_satker[$countunit][$countsatker] + $jumlah;
                                                    }
                                                }
                                            }
                                            $count = 0;

                                            if ($view) {
                                                $old_unit = "";
                                                $old_satker = "";
                                                $countunit = 0;
                                                $countsatker = 0;
                                                foreach ($view as $key => $value) {
                                                    $count++;
                                                    $mod = $count % 2;
                                                    $datas = explode($separator, $value);
                                                    $nmunit = $datas[1];
                                                    $nmsatker = $datas[2];
                                                    $nmitem = $datas[3];
                                                    $volkeg = $datas[4];
                                                    $satkeg = $datas[5];
                                                    $hargasat = $datas[6];
                                                    $jumlah = $datas[7];
                                                    if ($old_unit != $nmunit) {
                                                        $old_satker = "";
                                                        $old_unit = $nmunit;
                                                        $countunit++;
                                                        $countsatker = 0;
                                                        $key = $datas[12];
                                                        $keys = explode("-", $key);
                                                        $kdsatker = $keys[2];
                                                        $kdunit = $keys[4];                                                        
                                                        ?>
                                                        <tr>
                                                            <td><b><h3>024-<?php echo $kdunit; ?></h3></b></td>
                                                            <td><b><h3><?php echo $nmunit; ?></h3></b></td>
                                                            <td style="text-align:right"><b><h3><?php echo number_format($total_unit[$countunit], 0, ',', ','); ?></h3></b></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    if ($old_satker != $nmsatker) {
                                                        $old_satker = $nmsatker;
                                                        $countsatker++;
                                                        $key = $datas[12];
                                                        $keys = explode("-", $key);
                                                        $kdsatker = $keys[2];
                                                        $kdunit = $keys[4];                                                        
                                                        if (($rekap == "1")) {
                                                            ?>
                                                            <tr>
                                                                <td><b>024-<?php echo $kdunit; ?>-<?php echo $kdsatker; ?></b></td>
                                                                <td><b><?php echo $nmsatker; ?></b></td>
                                                                <td style="text-align:right"><b><?php echo number_format($total_satker[$countunit][$countsatker], 0, ',', ','); ?></b></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="2"><h2><b>Jumlah Total</b></h2></td>
                                                <td style="text-align:right"><h2><b><?php echo number_format($total, 0, ',', ','); ?></b></h2></td>
                                            </tr>
                                        </table>
                                    </div>  
                                </form>        
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>    
    </body>
</html>
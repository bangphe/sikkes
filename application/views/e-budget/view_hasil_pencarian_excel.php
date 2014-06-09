<?php
ini_set("max_execution_time","1200");
ini_set("max_input_time","1200");
ini_set("post_max_size","1500M");
ini_set("memory_limit","1500M");
header ("Expires: Mon, " . gmdate("D,d M YH:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"RekapRincian.xls\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );
readfile($export_file);
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
                        <h2>Rekap Rincian</h2>
                        <form method="post" action="daftarbelanja.php" name="daftarbelanja">
                            <div>
                                <table id="table_spacing" width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="text-align:center;background-color:#C6DEFF;font-weight: bold;font-size: 16px">No</td>
                                        <td style="text-align:center;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Unit/Satker</td>
                                        <td style="text-align:center;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Uraian Belanja</td>
                                        <td style="text-align:center;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Volume</td>
                                        <td style="text-align:center;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Harga Satuan</td>
                                        <td colspan="2" style="text-align:center;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Jumlah</td>
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
                                            $datas = explode("-;-", $value);
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
                                        }
                                    }
                                    ?>

                                    <?php
                                    $count = 0;
                                    
                                    if ($view) {
                                        $old_unit = "";
                                        $old_satker = "";
                                        $countunit = 0;
                                        $countsatker = 0;
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
                                            ?>
                                            <?php
                                            if ($old_unit != $nmunit) {
                                                $old_satker = "";
                                                $old_unit = $nmunit;
                                                $countunit++;
                                                $countsatker = 0;
                                                ?>
                                                <tr>
                                                    <td style="font-weight: bold;font-size: 16px"><?php echo $countunit; ?></td>
                                                    <td style="font-weight: bold;font-size: 16px"><?php echo $nmunit; ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align:right;font-weight: bold;font-size: 16px"><?php echo number_format($total_unit[$countunit], 0, ',', ','); ?></td>
                                                </tr>
            <?php
        }
        ?>

                                            <?php
                                            if ($old_satker != $nmsatker) {
                                                $old_satker = $nmsatker;
                                                $countsatker++;
                                                ?>
                                                <tr>
                                                    <td style="font-weight: bold;font-size: 14px"><?php echo $countunit; ?>.<?php echo $countsatker; ?></td>
                                                    <td style="font-weight: bold;font-size: 14px"><?php echo $nmsatker; ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align:right;font-weight: bold;font-size: 14px"><?php echo number_format($total_satker[$countunit][$countsatker], 0, ',', ','); ?></td>
                                                </tr>
            <?php
        }
        ?>

                                            <tr <?php if ($mod == 0) echo "class=\"alternate-row\""; ?>>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td><?php echo $nmitem; ?></td>
                                                <td><?php echo number_format($volkeg, 0, ',', ','). " " . $satkeg; ?></td>
                                                <td style="text-align:right"><?php echo number_format($hargasat, 0, ',', ','); ?></td>
                                                <td style="text-align:right"><?php echo number_format($jumlah, 0, ',', ','); ?></td>
                                                <td></td>
                                            </tr>
        <?php
    }
}
?>
                                            <tr>
                                                <td colspan="6" style="font-weight: bold;font-size: 16px">Jumlah Total</td>
                                                <td style="text-align:right;font-weight: bold;font-size: 16px"><?php echo number_format($total, 0, ',', ','); ?></td>
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
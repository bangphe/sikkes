<?php
ini_set("max_execution_time","1200");
ini_set("max_input_time","1200");
ini_set("post_max_size","1500M");
ini_set("memory_limit","1500M");
?>
<div id="tengah">
    <div id="judul" class="title">
        Hasil Pencarian
        <!--
        <label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <div>
            <div>
                <table width="140%" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed; width: 100%;">
                    <tr>
                        <th width="3%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">No</th>
                        <th width="29%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Unit/Satker</th>
                        <th width="34%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Uraian Belanja</th>
                        <th width="6%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Volume</th>
                        <th width="8%" style="text-align:right;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Harga Satuan</th>
                        <th colspan="2" width="20%" style="text-align:right;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Jumlah</th>
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
                                $old_unit = $nmunit;
                                $old_satker = "";
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
                                    <td style="background-color:#ADDFFF;font-weight: bold;font-size: 16px"><?php echo  $countunit; ?></td>
                                    <td style="background-color:#ADDFFF;font-weight: bold;font-size: 16px"><?php echo  $nmunit; ?></td>
                                    <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                    <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                    <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                    <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                    <td style="text-align:right;background-color:#ADDFFF;font-weight: bold;font-size: 16px"><?php echo  number_format($total_unit[$countunit], 0, ',', ','); ?></td>
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
                                    <td style="background-color:#BDEDFF;font-weight: bold;font-size: 14px"><?php echo  $countunit; ?>.<?php echo  $countsatker; ?></td>
                                    <td style="background-color:#BDEDFF;font-weight: bold;font-size: 14px"><?php echo  $nmsatker; ?></td>
                                    <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                    <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                    <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                    <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                    <td style="text-align:right;background-color:#BDEDFF;font-weight: bold;font-size: 14px"><?php echo  number_format($total_satker[$countunit][$countsatker], 0, ',', ','); ?></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <tr <?php if ($mod == 0) echo "style=\"background-color:#E0FFFF\""; else echo "style=\"background-color:#FFFFFF\"";?>>
                                <td></td>
                                <td>
                                </td>
                                <td><?php echo  $nmitem; ?></td>
                                <td><?php echo  number_format($volkeg, 0, ',', ',') . " " . $satkeg; ?></td>
                                <td style="text-align:right"><?php echo  number_format($hargasat, 0, ',', ','); ?></td>
                                <td style="text-align:right"><?php echo  number_format($jumlah, 0, ',', ','); ?></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="6" style="background-color:#ADDFFF;font-weight: bold;font-size: 16px">Jumlah Total</td>
                        <td style="text-align:right;background-color:#ADDFFF;font-weight: bold;font-size: 16px"><?php echo  number_format($total, 0, ',', ','); ?></td>
                    </tr>
                </table>
            </div>  
        </div>     
    </div>
</div>
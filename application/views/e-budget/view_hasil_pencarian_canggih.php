<?php
ini_set("max_execution_time","1200");
ini_set("max_input_time","1200");
ini_set("post_max_size","1500M");
ini_set("memory_limit","1500M");

$separator = "-|;|-";
?>
<div id="tengah">
    <div id="judul" class="title">
        Hasil Pencarian Canggih
        <!--
        <label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <div>
            <div>
                <form class="appnitro" name="pencarian" enctype="multipart/form-data" method="post" action="<?php echo  base_url() . 'index.php/e-budget/pencarian/rekap_pencarian_canggih/'; ?>">
                    <table width="180%" border="0" cellspacing="0" cellpadding="0" style="table-layout: fixed; width: 188%">
                        <tr>
                            <th width="6%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">No</th>
                            <th width="28%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Unit/Satker/Komponen/Sub Komponen</th>
                            <th width="28%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Akun</th>
                            <th width="40%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Uraian Belanja</th>
                            <th width="6%" style="text-align:left;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Volume</th>
                            <th width="8%" style="text-align:right;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Harga Satuan</th>
                            <th colspan="4" width="30%" style="text-align:center;background-color:#C6DEFF;font-weight: bold;font-size: 16px">Jumlah</th>
                            <th width="3%" style="background-color:#C6DEFF;font-weight: bold;font-size: 16px">Rekap</th>
                        </tr>
                        <tr>
                            <td colspan="12">
                                <div class="buttons">
                                    <button type="submit" class="regular" name="submit">
                                        <img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
                                        Rekap
                                    </button>
                                </div>
                            </td>
                        </tr>
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
                                $datas = explode($separator, $value);
                                $nmunit = $datas[1];
                                $nmsatker = $datas[2];
                                $nmitem = $datas[3];
                                $volkeg = $datas[4];
                                $satkeg = $datas[5];
                                $hargasat = $datas[6];
                                $jumlah = $datas[7];
                                $akun = $datas[8];
                                $correct_akun = $datas[9];
                                $komponen = $datas[10];
                                $skomponen = $datas[11];
                                $key = $datas[12];
                                ?>
                                <?php
                                if ($old_unit != $nmunit) {
                                    $keys = explode("-", $key);
                                    $kdsatker = $keys[2];
                                    $kdunit = $keys[4];
                                    $kdkmpnen = $keys[12];
                                    $old_unit = $nmunit;
                                    $old_satker = "";
                                    $countunit++;
                                    $countsatker = 0;
                                    $countkomponen = 0;
                                    ?>
                                    <tr>
                                        <td style="background-color:#ADDFFF;font-weight: bold;font-size: 16px"><?php echo  $kdunit; ?></td>
                                        <td style="background-color:#ADDFFF;font-weight: bold;font-size: 16px"><?php echo  $nmunit; ?></td>
                                        <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                        <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                        <td style="text-align:left;background-color:#ADDFFF;font-weight: bold"></td>
                                        <td style="background-color:#ADDFFF;font-weight: bold"></td>

                                        <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                        <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                        <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                        <td style="text-align:right;background-color:#ADDFFF;font-weight: bold;font-size: 16px"><?php echo  number_format($total_unit[$countunit], 0, ',', ','); ?></td>

                                        <td style="background-color:#ADDFFF;font-weight: bold"></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($old_satker != $nmsatker) {
                                    $keys = explode("-", $key);
                                    $kdsatker = $keys[2];
                                    $kdunit = $keys[4];
                                    $kdkmpnen = $keys[12];
                                    $old_satker = $nmsatker;
                                    $countsatker++;
                                    $countkomponen = 0;
                                    ?>
                                    <tr>
                                        <td style="background-color:#BDEDFF;font-weight: bold;font-size: 14px"><?php echo  $kdunit; ?>.<?php echo  $kdsatker; ?></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold;font-size: 14px"><?php echo  $nmsatker; ?></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="text-align:left;background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>

                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="text-align:right;background-color:#BDEDFF;font-weight: bold;font-size: 14px"><?php echo  number_format($total_satker[$countunit][$countsatker], 0, ',', ','); ?></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>

                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                    
                                <?php
                                if ($old_komponen != $komponen) {
                                    $keys = explode("-", $key);
                                    $kdsatker = $keys[2];
                                    $kdunit = $keys[4];
                                    $kdkmpnen = $keys[12];
                                    $old_komponen = $komponen;
                                    $countkomponen++;
                                    ?>
                                    <tr>
                                        <td style="background-color:#BDEDFF;font-weight: bold;font-size: 12px"><!--<?php echo  $kdunit; ?>.<?php echo  $kdsatker; ?>.<?php echo  $kdkmpnen; ?>--></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold;font-size: 12px"><?php echo  $komponen; ?></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="text-align:left;background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>

                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="text-align:right;background-color:#BDEDFF;font-size: 12px"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>

                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                    </tr>
                                    <?php
                                }
                                ?>    
                                    
                                <?php
                                if ($old_key != $key) {
                                    $old_key = $key;
                                    ?>
                                    <tr>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-size: 12px"><?php echo  $skomponen; ?></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="text-align:left;background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>

                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="text-align:right;background-color:#BDEDFF;font-weight: bold;"><?php echo  number_format($total_kegiatan[$countunit][$countsatker][$key], 0, ',', ','); ?></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>

                                        <td style="background-color:#BDEDFF;font-weight: bold"></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                <tr <?php
                        if ($mod == 0) {
                            if ($correct_akun == "0") {
                                echo "style=\"background-color:yellow\"";
                            } else {
                                echo "style=\"background-color:#E0FFFF\"";
                            }
                        } else {
                            if ($correct_akun == "0") {
                                echo "style=\"background-color:yellow\"";
                            } else {
                                echo "style=\"background-color:#FFFFFF\"";
                            }
                        }
                                ?>>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF\""; else echo "style=\"background-color:#FFFFFF\"";} else {echo "style=\"background-color:yellow\"";}?>></td>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF\""; else echo "style=\"background-color:#FFFFFF\"";} else {echo "style=\"background-color:yellow\"";}?>></td>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF\""; else echo "style=\"background-color:#FFFFFF\"";} else {echo "style=\"background-color:yellow\"";}?>><?php echo  $akun; ?></td>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF\""; else echo "style=\"background-color:#FFFFFF\"";} else {echo "style=\"background-color:yellow\"";}?>><?php echo  $nmitem; ?></td>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF\""; else echo "style=\"background-color:#FFFFFF\"";} else {echo "style=\"background-color:yellow\"";}?>><?php echo  number_format($volkeg, 0, ',', ',') . " " . $satkeg; ?></td>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF;text-align:right\""; else echo "style=\"background-color:#FFFFFF;text-align:right\"";} else {echo "style=\"background-color:yellow;text-align:right\"";}?>><?php echo  number_format($hargasat, 0, ',', ','); ?></td>

                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF;text-align:right\""; else echo "style=\"background-color:#FFFFFF;text-align:right\"";} else {echo "style=\"background-color:yellow;text-align:right\"";}?>><?php echo  number_format($jumlah, 0, ',', ','); ?></td>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF;text-align:right\""; else echo "style=\"background-color:#FFFFFF;text-align:right\"";} else {echo "style=\"background-color:yellow;text-align:right\"";}?>></td>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF;text-align:right\""; else echo "style=\"background-color:#FFFFFF;text-align:right\"";} else {echo "style=\"background-color:yellow;text-align:right\"";}?>></td>
                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF;text-align:right\""; else echo "style=\"background-color:#FFFFFF;text-align:right\"";} else {echo "style=\"background-color:yellow;text-align:right\"";}?>></td>

                                    <td <?php if ($correct_akun == "1") {if ($mod == 0) echo "style=\"background-color:#E0FFFF;text-align:right\""; else echo "style=\"background-color:#FFFFFF;text-align:right\"";} else {echo "style=\"background-color:yellow;text-align:right\"";}?>><input type="checkbox" name="rekap[]" value="
                                        <?php
                                        $value_e = str_replace("\"", "", $value);
                                        $value_e = str_replace("\'", "", $value_e);
                                        echo $value_e;
                                        ?>" 
                                               checked style="width: 1%;alignment-adjust: central"/></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="6" style="background-color:#ADDFFF;font-weight: bold;font-size: 16px">Jumlah Total</td>
                            <td style="text-align:right;background-color:#ADDFFF;font-weight: bold;font-size: 16px" colspan="4"><?php echo  number_format($total, 0, ',', ','); ?></td>
                            <td style="background-color:#ADDFFF"></td>
                        </tr>
                    </table>
                </form>
            </div>  
        </div>     
    </div>
</div>
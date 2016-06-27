<div id="tengah">
    <div id="judul" class="title">
        Feedback
        <!--
        <label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <?php
        $url = site_url() . "/e-budget/feedback/edit_mapping/$kdunit/$key/$kdsatker/$page";
        $url = str_replace(' ', '', $url);
        ?>

        <form method="post" action="<?php echo  $url ?>" name="mapping2">
            <table width="110%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="25%"><h2>Rincian Komponen</h2></td>
                    <td width="85%"></td>
                </tr>
                <tr>
                    <td width="25%">Unit</td>
                    <td width="85%"><?php echo  $unit; ?></td>
                </tr>
                <tr>
                    <td width="25%">Program</td>
                    <td width="85%"><?php echo  $program; ?></td>
                </tr>
                <tr>
                    <td width="25%">Kegiatan</td>
                    <td width="85%"><?php echo  $kegiatan; ?></td>
                </tr>
                <tr>
                    <td width="25%">Output</td>
                    <td width="85%"><?php echo  $output; ?></td>
                </tr>
                <tr>
                    <td width="25%">Sub Output</td>
                    <td width="85%"><?php echo  $suboutput; ?></td>
                </tr>
                <tr>
                    <td width="25%">Komponen</td>
                    <td width="85%"><?php echo  $komponen; ?></td>
                </tr>
                <tr>
                    <td width="25%">Sub Komponen</td>
                    <td width="85%"><?php echo  $subkomponen; ?></td>
                </tr>
                <tr>
                    <td width="25%"></td>
                    <td width="85%" style="font-weight: bold;color: red">
                        <?php echo  $notification; ?>
                    </td>
                </tr>
                <tr>
                    <td>                            
                        <a href='<?php echo  site_url()."/e-budget/feedback/feedback_edit/$kdunit/$kdsatker/$page/$key/$key" ;?>'>
                        <div class="buttons">
                            <button type="button" class="regular" name="submit">
<?php
            if ($sts == "2") {
                echo  "ADA JAWABAN BARU - BERIKAN FEEDBACK BARU";
            }
            if ($sts == "1") {
                echo  "ADA FEEDBACK BARU - BERIKAN JAWABAN     ";
            }
            if ($sts == "0") {
                echo  "TIDAK ADA FEEDBACK - BERIKAN FEEDBACK   ";
            }
?>
                            </button>
                        </div>
                            </a>
                        <a href='<?php echo  site_url()."/e-budget/feedback/grid_komponen/$kdunit/$kdsatker/$page" ;?>'>
                        <div class="buttons">
                            <button type="button" class="regular" name="submit">
                                <img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>
                                Kembali
                            </button>
                        </div>
                            </a>
                    </td>
                </tr> 
                <tr>
                    <td width="25%"><h2>Rincian Data Belanja</h2></td>
                    <td width="85%"></td>
                </tr>
            </table>
            <table width="150%" border="1" cellspacing="0" cellpadding="2px" style="table-layout: fixed; width: 80%;">
                <tr>
                    <th width="5%" style="background-color:#C6DEFF">No</th>
                    <th width="25%" style="background-color:#C6DEFF">Nama Akun</th>
                    <th width="50%" style="background-color:#C6DEFF">Nama Item</th>
                    <th width="10%" style="text-align:right;background-color:#C6DEFF">Jumlah</th>
                    <th width="10%" style="background-color:#C6DEFF">Status Feedback</th>
                    <th width="15%" style="background-color:#C6DEFF">Feedback Akun</th>
                </tr>

                <?php
                if ($dataAkun) {
                    $no = 0;
                    $total = 0;
                    foreach ($dataAkun as $key2 => $value) {
                        $no++;
                        $datas = explode("-;-", $value);
                        $total = $total + $datas[5];
                        $sts = $datas[6];
                        ?>
                        <tr>
                            <td style="background-color:#ADDFFF"><?php echo  $no; ?></td>
                            <td style="background-color:#ADDFFF"><?php echo  $datas[1] . " - " . $datas[0]; ?></td>
                            <td style="background-color:#ADDFFF"><?php echo  $datas[4]; ?></td>
                            <td style="text-align:right;background-color:#ADDFFF"><?php echo  number_format($datas[5], 0, ',', ','); ?></td>
                            <td style="background-color:#ADDFFF">
                                <?php 
                                    if ($sts == "2") {
                                        echo  "ADA JAWABAN BARU";
                                    }
                                    if ($sts == "1") {
                                        echo  "ADA FEEDBACK BARU";
                                    }
                                    if ($sts == "0") {
                                        echo  "TIDAK ADA FEEDBACK";
                                    }
                                ?></td>
                            <td style="background-color:#ADDFFF"><a href='<?php echo  site_url()."/e-budget/feedback/feedback_edit/$kdunit/$kdsatker/$page/$key/$key-$datas[1]-$datas[3]" ;?>'>
                                <?php 
                                    if ($sts == "2") {
                                        echo  "BERIKAN FEEDBACK BARU";
                                    }
                                    if ($sts == "1") {
                                        echo  "BERIKAN JAWABAN     ";
                                    }
                                    if ($sts == "0") {
                                        echo  "BERIKAN FEEDBACK   ";
                                    }
                                ?></td>
                                </a></td>
                        </tr>   
                        <?php
                    }
                    ?>
                    <tr>
                        <td style="background-color:#ADDFFF"><b>Jumlah</b></td>
                        <td style="text-align:right;background-color:#ADDFFF" colspan="3"><b><?php echo  number_format($total, 0, ',', ','); ?></b></td>
                        <td style="background-color:#ADDFFF"></td>
                        <td style="background-color:#ADDFFF"></td>
                    </tr>   
                    <?php
                }
                ?>
            </table>     
            <br><br><br><br>
        </form>
    </div>
</div>

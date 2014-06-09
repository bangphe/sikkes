<div id="tengah">
    <div id="judul" class="title">
        Mapping Komponen
        <!--
        <label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <?php
        $url = site_url() . "/e-budget/mapping/edit_mapping/$kdunit/$key/$kdsatker/$page";
        $url = str_replace(' ', '', $url);
        ?>

        <form method="post" action="<?php echo $url ?>" name="mapping2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="15%"><h2>Rincian Komponen</h2></td>
                    <td width="85%"></td>
                </tr>
                <tr>
                    <td width="15%">Unit</td>
                    <td width="85%"><?php echo $unit; ?></td>
                </tr>
                <tr>
                    <td width="15%">Program</td>
                    <td width="85%"><?php echo $program; ?></td>
                </tr>
                <tr>
                    <td width="15%">Kegiatan</td>
                    <td width="85%"><?php echo $kegiatan; ?></td>
                </tr>
                <tr>
                    <td width="15%">Output</td>
                    <td width="85%"><?php echo $output; ?></td>
                </tr>
                <tr>
                    <td width="15%">Sub Output</td>
                    <td width="85%"><?php echo $suboutput; ?></td>
                </tr>
                <tr>
                    <td width="15%">Komponen</td>
                    <td width="85%"><?php echo $komponen; ?></td>
                </tr>
                <tr>
                    <td width="15%">Sub Komponen</td>
                    <td width="85%"><?php echo $subkomponen; ?></td>
                </tr>
                <tr>
                    <td width="15%">Reformasi Kesehatan Utama</td>
                    <td width="85%">
                        <select id="reformasi_kesehatan_utama" name="reformasi_kesehatan_utama">
                            <?php
                            foreach ($allreformasi as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>" <?php if ($selected_reformasi_kesehatan_utama == $key) echo "selected" ?>><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Reformasi Kesehatan Pendukung</td>
                    <td width="85%">
                        <div class="container">
                            <?php
                            foreach ($allreformasi as $key => $value) {
                                ?>
                                <input type="checkbox" name="reformasi_kesehatan[]" value="<?php echo $key; ?>" <?php if (in_array($key, $selected_reformasi_kesehatan)) echo "checked" ?>/><?php echo $value; ?><br />
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Fokus Prioritas Utama</td>
                    <td width="85%">
                        <select id="fokus_prioritas_utama" name="fokus_prioritas_utama">
                            <?php
                            foreach ($allfokus as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>" <?php if ($selected_fokus_prioritas_utama == $key) echo "selected" ?>><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Fokus Prioritas Pendukung</td>
                    <td width="85%">
                        <div class="container">
                            <?php
                            foreach ($allfokus as $key => $value) {
                                ?>
                                <input type="checkbox" name="fokus_prioritas[]" value="<?php echo $key; ?>" <?php if (in_array($key, $selected_fokus_prioritas)) echo "checked" ?>/><?php echo $value; ?><br />
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Ikk</td>
                    <td width="85%">
                        <select id="ikk" name="ikk">
                            <?php
                            foreach ($allikk as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>" <?php if ($selected_ikk == $key) echo "selected" ?>><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="15%"></td>
                    <td width="85%" style="font-weight: bold;color: red">
                        <?php echo $notification; ?>
                    </td>
                </tr>
                <tr>
                    <td>                            
                        <div class="buttons">
                            <button type="submit" class="regular" name="submit">
                                <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                                Simpan
                            </button>
                        </div>
                        <a href='<?php echo site_url()."/e-budget/mapping/grid_komponen/$kdunit/$kdsatker/$page" ;?>'>
                        <div class="buttons">
                            <button type="button" class="regular" name="submit">
                                <img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
                                Kembali
                            </button>
                        </div>
                            </a>
                    </td>
                </tr> 
                <tr>
                    <td width="15%"><h2>Rincian Data Belanja</h2></td>
                    <td width="85%"></td>
                </tr>
            </table>
            <table width="140%" border="1" cellspacing="0" cellpadding="2px" style="table-layout: fixed; width: 80%;">
                <tr>
                    <th width="5%" style="background-color:#C6DEFF">No</th>
                    <th width="25%" style="background-color:#C6DEFF">Nama Akun</th>
                    <th width="50%" style="background-color:#C6DEFF">Nama Item</th>
                    <th width="20%" style="text-align:right;background-color:#C6DEFF">Jumlah</th>
                </tr>

                <?php
                if ($dataAkun) {
                    $no = 0;
                    $total = 0;
                    foreach ($dataAkun as $key => $value) {
                        $no++;
                        $datas = explode("-;-", $value);
                        $total = $total + $datas[5];
                        ?>
                        <tr>
                            <td style="background-color:#ADDFFF"><?php echo $no; ?></td>
                            <td style="background-color:#ADDFFF"><?php echo $datas[1] . " - " . $datas[0]; ?></td>
                            <td style="background-color:#ADDFFF"><?php echo $datas[4]; ?></td>
                            <td style="text-align:right;background-color:#ADDFFF"><?php echo number_format($datas[5], 0, ',', ','); ?></td>
                        </tr>   
                        <?php
                    }
                    ?>
                    <tr>
                        <td style="background-color:#ADDFFF"><b>Jumlah</b></td>
                        <td style="text-align:right;background-color:#ADDFFF" colspan="3"><b><?php echo number_format($total, 0, ',', ','); ?></b></td>
                    </tr>   
                    <?php
                } else {
                ?>
                <tr>
                    <td style="background-color:#ADDFFF">-</td>
                    <td style="background-color:#ADDFFF">-</td>
                    <td style="background-color:#ADDFFF">-</td>
                    <td style="text-align:right;background-color:#ADDFFF">-</td>
                </tr>
                <tr>
                    <td style="background-color:#ADDFFF"><b>Jumlah</b></td>
                    <td style="text-align:right;background-color:#ADDFFF" colspan="3"><b>-</b></td>
                </tr> 
                <?php } ?>
            </table>     
            <br><br><br><br>
        </form>
    </div>
</div>

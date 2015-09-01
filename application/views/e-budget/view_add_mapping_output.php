<style type="text/css">
table.myTable { width:100%; border-collapse:collapse;  }
table.myTable .tes { 
    background-color: #dfe4ea; color:#000; text-align:center;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px; font-weight:bold;}
table.myTable td { padding:8px; border:#999 1px solid; }

table.myTable tr:nth-child(even) { /*(even) or (2n+0)*/
    background: #fff;
}
table.myTable tr:nth-child(odd) { /*(odd) or (2n+1)*/
    background-color: #f2f5f9;
}
</style>

<div id="tengah">
    <div id="judul" class="title">
        Mapping Output
        <!--
        <label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <?php
        $url = site_url() . "/e-budget/mapping_output/mapping/$id/";
        $url = str_replace(' ', '', $url);
        ?>

        <form method="post" action="<?php echo $url;?>" name="mapping2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="15%"><h2>Rincian Output</h2></td>
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
                    <td width="85%"><?php echo $giat; ?></td>
                </tr>
                <tr>
                    <td width="15%">Output</td>
                    <td width="85%"><?php echo $output; ?></td>
                </tr>
                <tr>
                    <td width="15%">Ikk</td>
                    <td width="85%">
                        <select id="ikk" name="ikk">
                            <?php
                            foreach ($allikk as $key => $value) {
                                ?>
                                <option value="<?php echo $key?>"><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
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
                    </td>
                </tr> 
                <tr>
                    <td width="15%"><h2>Rincian Data Belanja</h2></td>
                    <td width="85%"></td>
                </tr>
            </table>
            <table width="140%" border="1" cellspacing="0" cellpadding="2px" class="myTable" style="table-layout: fixed; width: 80%;">
                <tr>
                    <th width="5%" class="tes">No</th>
                    <th width="25%" class="tes">Nama Akun</th>
                    <th width="50%" class="tes">Nama Item</th>
                    <th width="20%" class="tes">Jumlah</th>
                </tr>
                <?php
                    $no = 1;
                    foreach($d_item->result() as $row){
                ?>
                <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $row->kdakun.'-'.$row->nmakun;?></td>
                    <td><?php echo $row->nmitem;
                    if($row->vol1 !=0){
                        echo ' ['.$row->vol1.' '.$row->sat1;
                        if($row->vol2 ==0){
                            echo ']';
                        }else{
                            echo ' x '.$row->vol2.' '.$row->sat2;
                            if($row->vol3 ==0){
                                echo ']';
                            }else{
                                echo ' x '.$row->vol3.' '.$row->sat3;
                                if($row->vol4 ==0){
                                    echo ']';
                                }else{
                                    echo ' x '.$row->vol4.' '.$row->sat4.']';
                                }
                            }
                        }
                    }
                    ?></td>
                    <td align="center">Rp. <?=number_format($row->jumlah,2,',','.');?></td>
                    
                </tr>
                    <?php $no++; ?>
                <?php } ?>                                                                                          
            </table>    
            <br><br><br><br>
        </form>
    </div>
</div>

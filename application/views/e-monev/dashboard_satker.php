<!--div id="judul" class="title"><p align="center">DASHBOARD LAPORAN MONITORING <?php // echo $nmsatker.' '.$thang; ?></p></div-->
<?php  
	$bulan_angka = date("n")-1;
	$bulan_huruf = $this->general->konversi_bulan($bulan_angka);
?> 
<div id="judul" class="title"><p align="center">DASHBOARD LAPORAN MONITORING <?php echo $nmsatker.' '.$bulan_huruf.' '.$thang; ?></p></div> 
<a href="<?php echo base_url();?>index.php/e-monev/dashboard_satker/main_grafik/">
    <div class="buttons">
        <button type="submit" class="regular" name="submit">
            <img src="<?php echo base_url(); ?>images/icon/grafik.png" alt=""/>
            Grafik
        </button>
    </div>
</a>
<br /><br /><br />

<div id="content">
    <table title="" class="easyui-treegrid" style="width:1150px;"  
            url="<?= base_url() ?>index.php/e-monev/dashboard_satker/gridSatker"  
            rownumbers="true" showFooter="true" 
            idField="id" treeField="" nowrap="false">  
        <thead> 
            <tr>
                <th field="keg" width="350" align="left">Kegiatan</th>
                <th field="output" width="320" align="left">Output</th>
                <th field="paket" width="300">Sub Output</th>  
                <!--<th field="program" width="100" align="center">Program</th>  -->
                <!-- <th field="suboutput" width="240" align="left">Sub Output</th> -->
                <th field="fisik" width="85" align="center">Progress Fisik</th>  
            </tr>  
        </thead>  
    </table>  
</div>
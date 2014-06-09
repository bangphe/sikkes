<?php 
	$bulan_angka = date("n")-1;
	$bulan_huruf = $this->general->konversi_bulan($bulan_angka);
?>  
<div id="judul" class="title"><p align="center">DASHBOARD PROPINSI <?php echo $namaProv.' '.$thang.' '.$bulan_huruf; ?></p></div>
<div id="content">
	<table title="" class="easyui-treegrid" style="width:1157px;"  
            url="<?= base_url() ?>index.php/e-monev/dashboard_propinsi/gridSatker"  
            rownumbers="true" showFooter="true" 
            idField="id" treeField="name" animate:"true">  
        <thead frozen="true">  
            <tr>  
                <th field="name" width="600">Nama Satker</th>  
                <th field="paket" align="center">Jumlah Paket</th>  
            </tr>  
        </thead>  
        <thead>  
            <tr>  
                <th colspan="5">Fisik</th>
            </tr>  
            <tr>  
                <th field="merah" width="75" align="center">Merah</th>  
                <th field="kuning" width="75" align="center">Kuning</th>
                <th field="hijau" width="75" align="center">Hijau</th>  
                <th field="biru" width="75" align="center">Biru</th> 
                <th field="prog" width="75" align="center">Progress</th>   
            </tr>  
        </thead>  
    </table> 
</div>
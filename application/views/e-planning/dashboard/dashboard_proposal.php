<!--div id="judul" class="title"><p align="center">DASHBOARD PROPINSI <?php //echo $namaProv.' '.$thang; ?></p></div-->
<?php  
	$bulan_angka = date("n")-1;
	$bulan_huruf = $this->general->konversi_bulan($bulan_angka);
?>  
<div id="content">
	<!--table title="<?php echo  'JUMLAH TAHAPAN PROPOSAL PER UNIT UTAMA '.$bulan_huruf.' '.$thang; ?>" class="easyui-treegrid" style="width:1110px;height:auto"  
            url="<?php echo  site_url(); ?>/e-planning/dashboard/get_unit"  
            rownumbers="true" showFooter="true" 
            idField="id" treeField="name" animate="true" >  
        <thead frozen="true">  
            <tr>  
                <th field="name" width="400">Nama Satker</th>  
                <th field="total_prop" width="100" align="center">Jumlah</br>Total Proposal</th>  
            </tr>  
        </thead>  
        <thead>  
            <tr>  
                <th colspan="7">Posisi Proposal</th>
            </tr>  
            <tr>  
                <th field="satker" width="75" align="center">Satker</br>(Draft)</th>  
                <th field="prov" width="75" align="center">Provinsi</th>
                <th field="unit" width="75" align="center">Unit Utama</th>  
                <th field="roren" width="75" align="center">Roren</th> 
                <th field="setuju" width="75" align="center">Disetujui</th>
                <th field="tolak" width="75" align="center">Ditolak</th>   
                <th field="timbang" align="center">Dipertimbangkan</th>   
            </tr>  
        </thead>  
    </table--> 
	
	<table title="<?php echo  'JUMLAH TAHAPAN PROPOSAL '.$bulan_huruf.' '.$thang; ?>" class="easyui-treegrid" style="width:1110px;height:600px"  
            url="<?php echo  site_url(); ?>/e-planning/dashboard/get_jnssat"  
            rownumbers="true" showFooter="true" 
            idField="id" treeField="name" animate="true" >  
        <thead frozen="true">  
            <tr>  
                <th field="name" width="400">Nama Satker</th>  
                <th field="total_prop" width="100" align="center">Jumlah</br>Total Proposal</th>  
            </tr>  
        </thead>  
        <thead>  
            <tr>  
                <th colspan="7">Posisi Proposal</th>
            </tr>  
            <tr>  
                <th field="satker" width="75" align="center">Satker</br>(Draft)</th>  
                <th field="prov" width="75" align="center">Provinsi</th>
                <th field="unit" width="75" align="center">Unit Utama</th>  
                <th field="roren" width="75" align="center">Roren</th> 
                <th field="setuju" width="75" align="center">Disetujui</th>
                <th field="tolak" width="75" align="center">Ditolak</th>   
                <th field="timbang" align="center">Dipertimbangkan</th>   
            </tr>  
        </thead>  
    </table> 
</div>
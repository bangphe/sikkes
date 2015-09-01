<div id="content">
	<table title="" class="easyui-treegrid" style="width:1157px;"  
            url="<?= base_url() ?>index.php/e-monev/laporan_monitoring/treeList"  
            rownumbers="true" showFooter="true" 
            idField="id" treeField="name" animate:"true">  
        <thead frozen="true">  
            <tr>
                <th field="name" width="600">Nama</th>
                <th field="alokasi" width="600">Alokasi</th>
            </tr>
        </thead>  
    </table> 
</div>

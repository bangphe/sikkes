<div id="content">
		<table id="tt" title="Laporan Evaluasi" class="easyui-treegrid" style="width:1170px;height:540px"
			data-options="url:'<?php echo  base_url() ?>index.php/e-monev/laporan_evaluasi/treeGrid',idField:'id',treeField:'name',
					rownumbers:true,fitColumns:true,autoRowHeight:false,animate:true,nowrap:true">
		<thead>
			<tr>
				<th data-options="field:'name',editor:'text'" width="700">Program</th>
				<th data-options="field:'alo',editor:'text'" width="200" align="right">Alokasi Dipa</th>
                <th data-options="field:'uang',editor:'text'" width="200" align="right">Alokasi Swakelola & Nilai Kontrak</th>
                <th data-options="field:'evaluasi',editor:'text'" width="70">Evaluasi</th>
			</tr>
		</thead>
	</table>
</div>
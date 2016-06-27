<div id="content">
		<table id="tt" title="Mapping Output" class="easyui-treegrid" style="width:1170px;height:540px"
			data-options="url:'<?php echo  base_url() ?>index.php/e-budget/mapping_output/outputGrid',idField:'id',treeField:'name',
					rownumbers:true,fitColumns:true,autoRowHeight:false,animate:true,nowrap:true">
		<thead>
			<tr>
				<th data-options="field:'name',editor:'text'" width="650">Program</th>
				<th data-options="field:'alo',editor:'text'" width="200" align="center">Alokasi</th>
                <th data-options="field:'uang',editor:'text'" width="150" align="center">Sudah Di-Mapping</th>
                <th data-options="field:'evaluasi',editor:'text'" width="70" align="center">Mapping</th>
			</tr>
		</thead>
	</table>
</div>
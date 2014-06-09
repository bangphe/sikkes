<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>Bulan</th>
		<th>Rencana Keuangan (%)</th>
		<th>Rencana Keuangan (Rp)</th>
		<th>Input</th>
	</tr>
	<?php
		$no = 1;
		foreach($daftar_rencana as $row){
	?>
	<tr>
		<td><?php echo $bulan[$row->bulan];?></td>
		<td><?php echo $row->keuangan;?></td>
		<td>Rp. <?=number_format($row->keuangan_rp,2,',','.');?></td>
		<td><?php echo '<a href=\'#\'><img border=\'0\' onclick="update2('.$d_skmpnen_id.','.$row->rencana_id.','.$row->bulan.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
	</tr>
	<?php } ?>																									
</table>

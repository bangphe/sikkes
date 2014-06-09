<h2 class="tablecloth">Ketentuan Pengisian Progres</h2>
<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>No</th>
		<th>Ketentuan</th>
		<th>Tanggal</th>
		<th>Update</th>
	</tr>
	<?php
		$no = 1;
		foreach($daftar_ref->result() as $row){
	?>
	<tr>
		<td width="5%"><?php echo $no++;?></td>
		<td width="70%"><?php echo $row->ketentuan;?></td>
		<td width="10%"><?php echo $row->tanggal;?></td>
		<td width="5%"><?php echo '<a href=\'#\'><img border=\'0\' onclick="update('.$row->referensi_id.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
	</tr>
	<?php } ?>																									
</table>

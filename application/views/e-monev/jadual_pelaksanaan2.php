<link href="<?= base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>js/tablecloth.js"></script>
<br />
<table width="100%" class="tablecloth" cellspacing="0" cellpadding="0">
	<tr>
		<th>No</th>
		<th>Uraian Kegiatan</th>
		<th>Tanggal</th>
		<th>Hapus</th>
	</tr>
	<?php 
	$i = 0;
	if($data_jadual_pelaksanaan->num_rows > 0)
	{
		foreach($data_jadual_pelaksanaan->result() as $row)
		{?>
		<tr>
			<?php $tanggal = explode('-',$row->tanggal);?>
			<td><?php echo ++$i;?></td>
			<td><?php echo $row->uraian_kegiatan;?></td>
			<?php if(date("D", strtotime($row->tanggal)) == 'Sun' || date("D", strtotime($row->tanggal)) == 'Sat'){?>
				<td style="color:red"><?php echo $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];?></td>
			<?php } else { ?>
				<td><?php echo $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];?></td>
			<?php } ?>
			<td><?php echo '<a href="#" onClick="delete_jadual_pelaksanaan('.$row->jadual_pelaksanaan_id.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>';?></td>
		</tr>
	<?php }
	}
	else
	{
	?>
		<tr>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
		</tr>
	<?php } ?>
</table>

<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo  base_url() ?>js/tablecloth.js"></script>
<br />
<table width="100%" class="tablecloth" cellspacing="0" cellpadding="0">
	<tr>
		<th>No</th>
		<th>Tanggal</th>
		<th>Nomor SP2D</th>
		<th>Nominal</th>
		<th>Hapus</th>
	</tr>
	<?php 
	$i = 0;
	if($daftar_sp2d->num_rows > 0)
	{
		foreach($daftar_sp2d->result() as $row)
		{?>
		<tr>
			<?php $tanggal = explode('-',$row->tanggal);?>
			<td><?php echo  ++$i;?></td>
			<?php if(date("D", strtotime($row->tanggal)) == 'Sun' || date("D", strtotime($row->tanggal)) == 'Sat'){?>
				<td style="color:red"><?php echo  $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];?></td>
			<?php } else { ?>
				<td><?php echo  $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];?></td>
			<?php } ?>
			<td><?php echo  $row->nomor_sp2d;?></td>
			<td>Rp. <?php echo number_format($row->nominal,2,',','.');?></td>
			<td><?php echo  '<a href="#" onClick="delete_data_sp2d('.$sp2d_id.','.$row->data_sp2d_id.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>';?></td>
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
			<td>-</td>
		</tr>
	<?php } ?>
</table>

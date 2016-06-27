<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo  base_url() ?>js/tablecloth.js"></script>
<br />
<table width="100%" class="tablecloth" cellspacing="0" cellpadding="0">
	<tr>
		<th>No</th>
		<th>Tanggal</th>
		<th>Nomor SPM</th>
		<th>Nama Akun</th>
		<th>Nominal</th>
		<th>Hapus</th>
		<th>SP2D</th>
	</tr>
	<?php 
	$i = 0;
	if($daftar_spm->num_rows > 0)
	{
		foreach($daftar_spm->result() as $row)
		{?>
		<tr>
			<td><?php echo  ++$i;?></td>
			<?php $tanggal = explode('-',$row->tanggal);?>
			<?php if(date("D", strtotime($row->tanggal)) == 'Sun' || date("D", strtotime($row->tanggal)) == 'Sat'){?>
				<td style="color:red"><?php echo  $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];?></td>
			<?php } else { ?>
				<td><?php echo  $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];?></td>
			<?php } ?>
			<td><?php echo  $row->nomor_sp2d;?></td>
			<td><?php echo  $row->nmakun;?></td>
			<td>Rp. <?php echo number_format($row->nominal,2,',','.');?></td>
			<td><?php echo  '<a href="#" onClick="delete_data_spm('.$spm_id.','.$row->sp2d_id.');"><img border=\'0\' src=\''.base_url().'images/flexigrid/hapus.png\'></a>';?></td>
			<td width="5%"><?php echo  '<a href=\'#\'><img border=\'0\' onclick="sp2d('.$row->sp2d_id.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
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
			<td>-</td>
			<td>-</td>
		</tr>
	<?php } ?>
</table>

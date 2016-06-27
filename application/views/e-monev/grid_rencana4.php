<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>Bulan</th>
		<th colspan="2">Persiapan (%)</th>
		<th colspan="2">Pelaksanaan (%)</th>
		<th colspan="2">Pembuatan Laporan (%)</th>
		<th colspan="2">Dokumen (%)</th>
		<th>Input</th>
	</tr>
	<tr>
		<td>Bobot</td>
		<td colspan="2"><?php echo  $b_persiapan;?></td>
		<td colspan="2"><?php echo  $b_pelaksanaan;?></td>
		<td colspan="2"><?php echo  $b_pembuatan;?></td>
		<td colspan="2"><?php echo  $b_dokumen;?></td>
		<td><?php echo  '<a href=\'#\'><img border=\'0\' onclick="update_bobot('.$d_skmpnen_id.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
	</tr>
	<?php
		$no = 1;
		foreach($daftar_rencana as $row){
	?>
	<tr>
		<td><?php echo  $bulan[$row->bulan];?></td>
		<td><?php echo  $row->persiapan;?></td>
		<?php 
		if($total_bobot!=0){
			$persiapanx = round($b_persiapan/$total_bobot*$row->persiapan,2);
		}else{
			$persiapanx = 0;
		}
		?>
		<td><?php echo  $persiapanx;?></td>
		<td><?php echo  $row->pelaksanaan;?></td>
		<?php 
		if($total_bobot!=0){
			$pelaksanaanx = round($b_pelaksanaan/$total_bobot*$row->pelaksanaan,2);
		}else{
			$pelaksanaanx = 0;
		}
		?>
		<td><?php echo  $pelaksanaanx;?></td>
		<td><?php echo  $row->pembuatan_laporan;?></td>
		<?php 
		if($total_bobot!=0){
			$pembuatanx = round($b_pembuatan/$total_bobot*$row->pembuatan_laporan,2);
		}else{
			$pembuatanx = 0;
		}	
		?>
		<td><?php echo  $pembuatanx;?></td>
		<td><?php echo  $row->dokumen_laporan;?></td>
		<?php 
		if($total_bobot!=0){
			$dokumenx = round($b_dokumen/$total_bobot*$row->dokumen_laporan,2);
		}else{
			$dokumenx = 0;
		}
		?>
		<td><?php echo  $dokumenx;?></td>
		<td><?php echo  '<a href=\'#\'><img border=\'0\' onclick="update3('.$d_skmpnen_id.','.$row->rencana_id.','.$row->bulan.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
	</tr>
	<?php } ?>	
	<!--
	<tr>
		<td><b>Presentase Total : </b></td>
		<td><b><?php echo  $nilai_persiapan;?></b></td>
		<td><b><?php echo  $nilai_pelaksanaan;?></b></td>
		<td><b><?php echo  $nilai_pembuatan_laporan;?></b></td>
		<td><b><?php echo  $nilai_dokumen_laporan;?></b></td>
		<td></td>
	</tr>
-->	
</table>

<div class="buttons">
	<button type="submit" class="regular" name="grafik_progress" onclick="grafik_progress(<?php echo  $idpaket;?>)">
		<img src="<?php echo  base_url(); ?>images/icon/grafik.png" alt=""/>
		Grafik
	</button>
</div>
<div class="buttons">
<p align="center"><b>Tahun Anggaran : </b><?php echo  $this->session->userdata('thn_anggaran');?></p>
<br />
<p align="center"><b>Output : </b><?php echo  $nmoutput;?></p>
<br />
<p align="center"><b>Sub Output : </b><?php echo  $ursoutput;?></p>

<br />
</div>
<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>Bulan</th>
		<th>Tanggal</th>
		<th>Rencana Fisik (%)</th>
		<th>Progress Fisik (%)</th>
		<th>File Bukti Fisik</th>
		<th>Input</th>

	</tr>
	<?php
		$no = 1;
		foreach($daftar_progress as $row){
	?>
	<tr>
		<td><?php echo  $bulan[$row->bulan];?></td>
		<td><?php echo  $row->tanggal;?></td>
		<td><?php echo  $row->rencana;?></td>
		<td><?php echo  $row->progress;?></td>
		<td><?php echo  '<a href=\''.base_url().'index.php/e-monev/laporan_monitoring/download_file_kontrak/'.$row->progress_id.'\'>'.$row->dokumen.'</a></td>'; ?></td>
		<td><?php echo  '<a href=\'#\'><img border=\'0\' onclick="update_progress_fisik('.$row->progress_id.','.$row->idpaket.','.$row->bulan.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
	</tr>
	<?php } ?>																									
</table>
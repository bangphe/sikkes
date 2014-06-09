<div class="buttons">
	<button type="submit" class="regular" name="grafik" onClick="grafik(<?php echo $d_skmpnen_id;?>);">
		<img src="<?php echo base_url(); ?>images/icon/grafik.png" alt=""/>
		Grafik
	</button>
</div>

<p align="center"><b>Tahun Anggaran : </b><?php echo $this->session->userdata('thn_anggaran');?></p>
<br />
<p align="center"><b>Nama Komponen/Sub Komponen : </b><?php echo $sub_komponen;?></p>

<br />
<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>Bulan</th>
		<th>Tanggal</th>
		<th>Fisik (%)</th>
		<th>File Bukti Fisik</th>
		<th>Input</th>
	</tr>
	<?php
		$no = 1;
		foreach($daftar_progres as $row){
	?>
	<tr>
		<td><?php echo $bulan[$row->bulan];?></td>
		<td><?php echo $row->tanggal;?></td>
		<td><?php echo $row->fisik;?></td>
		<td><?php echo '<a href=\''.base_url().'index.php/e-monev/laporan_monitoring/download/'.$row->progres_id.'\'>'.$row->dok_bukti_fisik.'</a></td>'; ?></td>
		<td><?php echo '<a href=\'#\'><img border=\'0\' onclick="update('.$d_skmpnen_id.','.$row->progres_id.','.$row->bulan.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
	</tr>
	<?php } ?>																									
</table>

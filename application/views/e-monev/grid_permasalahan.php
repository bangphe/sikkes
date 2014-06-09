<h2 class="tablecloth">Tahun Anggaran : <?php echo $this->session->userdata('thn_anggaran'); ?></h2>
<h2 class="tablecloth">Nama Komponen/Sub Komponen : <?php echo $sub_komponen;?></h2>
<div>
    <?= anchor(site_url('e-monev/laporan_monitoring/'), img(array('src' => 'images/flexigrid/prev.gif', 'border' => '0', 'alt' => '')) . 'Kembali Ke Laporan Monitoring'); ?>
    
</div>
<br/>
<table class="tablecloth" cellspacing="0" cellpadding="0" width="500">
	<tr>
		<th>Bulan</th>
		<th>Jumlah Permasalahan</th>
		<th>Lihat</th>
	</tr>
	<?php
		$no = 1;
		foreach($daftar_permasalahan as $row){
	?>
	<tr>
		<td><?php echo $row['nama_bulan'];?></td>
		<td><?php echo $row['jml_permasalahan'];?></td>
		<td><?php echo '<a href=\'#\'><img border=\'0\' onclick="update('.$d_skmpnen_id.','.$row['bulan'].', true);" src=\''.base_url().'images/icon/lihat.png\'></a></td>'; ?></td>
	</tr>
	<?php } ?>																									
</table>
<?php ?>

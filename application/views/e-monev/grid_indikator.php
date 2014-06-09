<div>
    <?= anchor(site_url('e-monev/laporan_kinerja/'), img(array('src' => 'images/flexigrid/prev.gif', 'border' => '0', 'alt' => '')) . 'Kembali Ke Laporan Kinerja'); ?>
</div>

<h2 class="tablecloth" align="center">Tahun Anggaran : <?php echo $this->session->userdata('thn_anggaran'); ?></h2>
<h2 class="tablecloth" align="center">Kode IKK : <?php echo $ikk[0]->KodeIkk;?></h2>
<h2 class="tablecloth" align="center">Nama IKK : <?php echo $ikk[0]->Ikk;?></h2>
<h2 class="tablecloth" align="center">Nama Satker : <?php echo $satker;?></h2>
<br/>

<div align="center">
<table class="tablecloth" cellspacing="0" cellpadding="0" width="500" style="">
	<tr>
		<th>Bulan</th>
		<th>Rencana</th>
		<!--<th>Input</th>-->
        <th>Realisasi</th>
		<!--<th>Input</th>-->
	</tr>
	<?php foreach ($bulan as $id => $val) { ?>
	<tr>
		<td><?php echo $val;?></td>
		<td><?php $str = "bulan_$id"; if (isset($rencana[0]) && $rencana[0]->$str != NULL): echo $rencana[0]->$str; else : echo '-'; endif; echo form_error("bulan_$id");?></td>
		<?php /*?><td><?php echo '<a href=\'#\'><img border=\'0\' onclick="update_rencana('.$kodeikk.','.$id.','.$thn.', true);" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td><?php */?>
        <td><?php $str = "bulan_$id"; if (isset($realisasi[0]) && $realisasi[0]->$str != NULL): echo $realisasi[0]->$str; else : echo '-'; endif; echo form_error("bulan_$id");?></td>
		<?php /*?><td><?php echo '<a href=\'#\'><img border=\'0\' onclick="update_realisasi('.$kodeikk.','.$thn.', true);" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td><?php */?>
	</tr>
	<?php } ?>																									
</table>
</div>
<?php ?>

<div id="master">
<div id="judul" class="title">
	Rekap Laporan Monitoring
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_rekap_monitoring" method="post" action="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/cetak/'; ?>">

	<table width="80%" height="25%">
	<br />
	<div>
		<?php echo  anchor(site_url('e-monev/laporan_monitoring/'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Laporan Monitoring'); ?>
		</div>
		<br />
		<tr>
				<td width="10%">Pilih satker</td>
				<td width="70%"><?php echo  form_dropdown('pil_satker', $opsi_satker);?></td>
		</tr>
	</table>
	<table width="80%"><tr>
	<td width="10%">&nbsp;</td>
	<td  width="70%">
	<div class="buttons">
      <button type="submit" class="positive" name="cetak"> <img src="<?php echo  base_url(); ?>images/main/excel.png" alt=""/> Cetak </button>
	  </div>
	 </td></tr></table>
	</form>
</div>
</div>

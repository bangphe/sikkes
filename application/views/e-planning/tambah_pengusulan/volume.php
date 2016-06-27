<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.ui.all.js"></script>
<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.layout.js"></script>
<div id="container">
	<h1>Rincian Pengusul</h1>
	<div id="body">
		<form id="tes" onsubmit="window.opener.document.getElementById('detail1').value=document.getElementById('volume').value; window.close();" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>Kode Kegiatan</p></td>
				<td><p><?php echo  $kode_kegiatan; ?></p></td>
			</tr>
			<tr>
				<td><p>Nama Kegiatan</p></td>
				<td><p><?php echo  $nama_kegiatan; ?></p></td>
			</tr>
			<tr>
				<td><p>Volume</p></td>
				<td><p><input id="volume" name="volume" /></p></td>
			</tr>
			<tr>
				<td><p>Satuan</p></td>
				<td><p><input id="satuan" name="satuan" /></p></td>
			</tr>
			<tr>
				<td><p>Harga Satuan</p></td>
				<td><p><input id="harga_satuan" name="harga_satuan" /></p></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" id="submit" value="submit" /></td>
			</tr>
		</table>
		</form>
	</div>
</div>
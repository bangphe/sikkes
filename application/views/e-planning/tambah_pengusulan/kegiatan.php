<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.ui.all.js"></script>
<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.layout.js"></script>
<div id="container">
	<h1>Rincian Pengusul</h1>
	<div id="body">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode Kegiatan</p></td>
				<td><p>Nama Kegiatan</p></td>
			</tr>
			<?php
			$no=1;
			foreach($kegiatan->result() as $row){
				$kode = $row->KodeKegiatan;
				$nama = $row->NamaKegiatan; 
			?>
			<tr style="cursor: hand" onmouseover="this.style.backgroundColor='#ffff00';" onmouseout="this.style.backgroundColor='#ffffff';" onclick="window.opener.document.getElementById('detail1').value=<?php echo  $kode; ?>; window.opener.document.getElementById('detail2').value='<?php echo  $nama; ?>'; window.close();">
				<td><?php echo  $no; ?></td>
				<td><?php echo  $kode; ?></td>
				<td><?php echo  $nama; ?></td>
			</tr>
			<?php 
				$no++;	
			} 
			?>
		</table>
	</div>
</div>
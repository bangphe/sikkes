<div id="container">
	<h1>Rincian Pengusul</h1>
	<div id="body">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode Indikator</p></td>
				<td><p>Nama Indikator</p></td>
				<td><p>Rincian</p></td>
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
				<td><?php echo  $nama; ?></td>
			</tr>
			<?php 
				$no++;	
			} 
			?>
		</table>
	</div>
</div>
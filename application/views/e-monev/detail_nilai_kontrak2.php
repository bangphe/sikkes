<!--
<tr>
	<td width="40%"><b>Realisasi Keuangan (Rupiah):</b></td>
	<td width="60%">
		<?php
			echo $realisasi_keuangan;
		?>
	</td>
</tr>
<tr>
	<td width="40%"><b>Realisasi Fisik (%) :</b></td>
	<td width="60%">
		<?php
			echo $realisasi_fisik;
		?>
	</td>
</tr>
-->
<tr>
	<td width="40%"><b>Nilai Kontrak (Rupiah) :</b></td>
	<td width="60%">
		Rp. <?=number_format($nilai_kontrak,2,',','.');?>
	</td>
</tr>
<tr>
	<td width="40%"><b>PHLN :</b></td>
	<td width="60%">
		Rp. <?=number_format($phln,2,',','.');?>
	</td>
</tr>

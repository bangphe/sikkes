<h1><center>Pra Kontrak</center></h1>
<br />
<fieldset>
	<legend>Detail <?php echo '<a href="#" onClick="edit_prakontrak();"><img border=\'0\' src=\''.base_url().'images/icon/iconedit.png\'></a>';?></legend>
<br />
	<table width=auto>
		<tr>
			<td width="40%">Kategori Pengadaan :</td>
			<td width="60%">
				<?php
					echo $kategori_pengadaan;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Cara Pengadaan :</td>
			<td width="60%">
				<?php
					echo $cara_pengadaan;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Nilai HPS / OE :</td>
			<td width="60%">
				Rp. <?=number_format($nilai_hps_oe,2,',','.');?>
			</td>
		</tr>
	</table>
	<br />
</fieldset>

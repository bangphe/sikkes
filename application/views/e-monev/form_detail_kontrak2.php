<link href="<?= base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<h1><center>Kontrak <?php echo '<a href="#" onClick="edit_kontrak();"><img border=\'0\' src=\''.base_url().'images/icon/iconedit.png\'></a>';?></center></h1>
<br />
	<table width="100%">
		<?php echo $input_nilai_kontrak;?>
		<tr>
			<td width="40%"><b>Nomor Kontrak :</b></td>
			<td width="60%">
				<?php
					echo $nomor_kontrak;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%"><b>Tanggal TTD :</b></td>
			<td width="60%">
				<?php
				   echo $tanggal_ttd;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%"><b>Waktu Pelaksanaan :</b></td>
			<td width="60%">
				<?php
				   echo $waktu_pelaksanaan;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%"><b>Tanggal SPMK :</b></td>
			<td width="60%">
				<?php
				   echo $tanggal_spmk; 
				?>
			</td>
		</tr>
		<tr>
			<td width="40%"><b>Tanggal Selesai :</b></td>
			<td width="60%">
				<?php
				   echo $tanggal_selesai;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%"><b>Rekanan Utama :</b></td>
			<td width="60%">
				<?php
				    echo $rekanan_utama;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%"><b>Alamat :</b></td>
			<td width="60%">
				<?php 
					echo $alamat;
				?>
			</td>
		</tr>
		<tr>
			<td width="60%"><b>Nama Bank :</b></td>
			<td width="40%">
				<?php
					echo $nama_bank;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%"><b>NPWP :</b></td>
			<td width="60%">
				<?php
				   echo $npwp;
				?>
			</td>
		</tr>
	</table>

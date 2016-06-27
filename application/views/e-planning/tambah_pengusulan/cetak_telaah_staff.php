<html>
<head>
</head>
<!--<body onLoad="window.print(); window.location = '<?php echo  site_url(); ?>/e-planning/manajemen/grid_persetujuan';">
-->
<body>
<div width="800px" align="center">
<div align="center" width="800px" align="center">
	TELAAH STAF</br>
	TENTANG</br>
	<?php echo  $perihal.'</br>';	?>
	-------------------------------------------------------
</div>
<div width="800px" align="center">
		<table border="0" cellspacing="0" cellpadding="5" width="800px">
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="vertical-align:top;"><p>Dari</p></td>
				<td style="vertical-align:top;">:</td>
				<td ><p><?php echo  $DARI; ?></p></td>
			</tr>
			<tr>
				<td width="30%" style="vertical-align:top;"><p>Kepada</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $KEPADA; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Tanggal</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $tanggal; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Persoalan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $persoalan; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Praanggapan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $praanggapan; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Fakta yang mempengaruhi</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $fakta_yang_mempengaruhi; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Penggunaan sumber daya yang cost efektif</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $cost_efektif; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Efisien</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $efisien; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Feasibilitas (secara teknis, politis dan kendala sosial)</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $feasibilitas; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Equity (keadilan)</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $equity; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Menutup gap yang ada di daerah</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $gap_daerah; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Analisis</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $analisis; ?></p></td>
			</tr>
			<tr>
				<td style="vertical-align:top;"><p>Simpulan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $simpulan; ?></p></td>
			</tr>
			<div align="center">
			<tr>
				<td colspan="3"><div >
				Demikian telaah staff ini kami sampaikan, mohon arahan lebih lanjut. Atas perhatiannya, kami
				sampaikan terima kasih.
				</div>
				</br>
				</br></td></tr>
				<tr><td colspan="3">
				<table align="center" width="auto" border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td align="center">
							<p><?php echo  $jabatan_ttd; ?></p>
							</br>
							</br>
							</br>
							</br>
							<p><?php echo  $nama_ttd."</br>NIP. ".$nip_ttd; ?></p>
						</td>
					</tr>
				</table>
			</td></tr>
		</div>
		</table>
		
</div>
</div>
</body>
</html>
<div id="kiri">
<div id="judul" class="title">
	Telaah Staff
</div>
<div id="content">
	<form id="form_detail_telaah_staff" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/telaah/grid_telaah_staff/'.$kd_pengajuan ?>">
	<?php if(isset($tanggapan)){?>
	<table>
		<tr><td>
		<fieldset style="border-color:#000000; width:835px">
		<legend class="legend" >| Tanggapan |</legend>
		<table>
		<tr><td>
		<p>Dari: <?php echo  $tertanda; ?></p>
		<p><?php echo  $tanggapan; ?></p>
		</td></tr>
		</table>
		</fieldset>
		</td></tr>
		</table>
	<?php } ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td width="20%" style="padding-left:10px;vertical-align:top;"><p>Tanggal</p></td>
				<td width="1%"  style="vertical-align:top;">:</td>
				<td><p><?php echo  $TANGGAL; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Persoalan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $PERSOALAN; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Praanggapan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $PRAANGGAPAN; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Fakta yang mempengaruhi</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $FAKTA_YANG_MEMPENGARUHI; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Penggunaan sumber daya yang cost efektif</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $COST_EFEKTIF; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Efisien</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $EFISIEN; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Feasibilitas (secara teknis, politis dan kendala sosial)</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $FEASIBILITAS; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Equity (keadilan)</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $EQUITY; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Menutup gap yang ada di daerah</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $GAP_DAERAH; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Analisis</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $ANALISIS; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Simpulan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo  $SIMPULAN; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td></td><td></td>
			<td>
					<div class="buttons">
						<button type="button" class="positive" name="ok"  onClick="history.go(-1);">
							<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
							OK
						</button>
					</div>
				</td>
			</tr>
		</table>
	</form>
</div>
</div>
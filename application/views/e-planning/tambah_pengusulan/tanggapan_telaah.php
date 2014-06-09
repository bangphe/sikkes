<div id="kiri">
<div id="judul" class="title">
	Telaah Staff
</div>
<div id="content">
	<form id="form_koreksi_telaah" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/telaah/proses_minta_koreksi/'.$kd_pengajuan.'/'.$kd_telaah; ?>" onsubmit="return validate_form()">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td width="20%" style="padding-left:10px;vertical-align:top;"><p>Tanggal</p></td>
				<td width="1%"  style="vertical-align:top;">:</td>
				<td><p><?php echo $TANGGAL; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Persoalan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $PERSOALAN; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Praanggapan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $PRAANGGAPAN; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Fakta yang mempengaruhi</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $FAKTA_YANG_MEMPENGARUHI; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Penggunaan sumber daya yang cost efektif</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $COST_EFEKTIF; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Efisien</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $EFISIEN; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Feasibilitas (secara teknis, politis dan kendala sosial)</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $FEASIBILITAS; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Equity (keadilan)</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $EQUITY; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Menutup gap yang ada di daerah</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $GAP_DAERAH; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Analisis</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $ANALISIS; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Simpulan</p></td>
				<td style="vertical-align:top;">:</td>
				<td><p><?php echo $SIMPULAN; ?></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>
		<table>
		<tr><td>
		<fieldset style="border-color:#000000; width:835px">
		<legend class="legend" >| Tanggapan |</legend>
		<table>
		<tr><td>
		<textarea id="tanggapan" name="tanggapan" rows="10" cols="100"></textarea>
		</td></tr>
		</table>
		</fieldset>
		</td></tr>
		<tr><td align="center">
					<div class="buttons">
						<button type="submit" class="positive" name="save">
							<img src="<?php echo base_url(); ?>images/main/update.png" alt=""/>
							Simpan
						</button>
						  <a href="<?php echo site_url(); ?>/e-planning/telaah/grid_telaah_staff/<?php echo $kd_pengajuan; ?>" class="negative">
						<img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
						Batal
					 </a>
					</div>
		</td></tr>
		</table>
	</form>
</div>
</div>
<script type="text/javascript">
	function validate_form()
	{
	var a=document.forms["form_koreksi_telaah"]["tanggapan"].value;
	if (a==null || a=="")
	  {
	  alert("Anda harus mengisi tanggapan terlebih dahulu.");
	  return false;
	  }
	}
</script>
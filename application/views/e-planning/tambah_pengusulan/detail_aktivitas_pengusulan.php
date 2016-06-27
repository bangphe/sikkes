<div id="judul" class="title">Detail RAB</div>
<div id="content">
	<form id="form_detail_aktivitas" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/aktivitas/grid_aktivitas/'.$KD_PENGAJUAN.'/'.$KodeFungsi.'/'.$KodeSubFungsi.'/'.$KodeProgram.'/'.$KodeKegiatan; ?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td  style="vertical-align:top;" width="15%">Jenis Usulan</td>
				<td>
					<?php foreach($this->am->get_where('ref_jenis_usulan', 'KodeJenisUsulan', $s_jenis_usulan)->result() as $row)
						echo $row->JenisUsulan;
					?>
				</td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;">Judul Usulan</td>
				<td><?php echo  $JudulUsulan; ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;">Perincian</td>
				<td><?php echo  $Perincian; ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;">Volume</td>
				<td><?php echo  $Volume; ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;">Satuan</td>
				<td><?php echo  $s_satuan; ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;">Harga Satuan</td>
				<td><?php echo  $HargaSatuan; ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;">Jumlah</td>
				<td><?php echo  $Jumlah; ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;">Jenis Pembiayaan</td>
				<td><?php echo  $s_jenis_pembiayaan; ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
			<td style="vertical-align:top;">Fokus Prioritas</td>
			<td>
				<?php if(isset($fokus_prioritas)){ foreach ($fokus_prioritas as $row) { ?>
					<?php if($this->am->cek('fp_aktivitas', 'idFokusPrioritas', $row->idFokusPrioritas, 'KodeAktivitas', $KodeAktivitas)) echo $row->FokusPrioritas.'</br>';  ?>
				<?php
					}}
				?>
			</td>
		</tr>
		<tr><td><p>&nbsp;</p></td><tr>
		<tr>
			<td style="vertical-align:top;">Reformasi Kesehatan</td>
			<td>
				<?php if(isset($reformasi_kesehatan)){ foreach($reformasi_kesehatan as $row) { ?>
					<?php if($this->am->cek('rk_aktivitas', 'idReformasiKesehatan', $row->idReformasiKesehatan, 'KodeAktivitas', $KodeAktivitas))  echo $row->ReformasiKesehatan.'</br>'; ?></br>
				<?php
					}}
				?>
			</td>
		</tr>
			<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="button" onClick="history.go(-1);"  class="positive" name="save" id="save">
						<img src="<?php echo  base_url(); ?>images/main/ok.png" alt=""/>
						OK
					</button>
				</div>
			</td>
		</tr>
		</table>
	</form>
</div>

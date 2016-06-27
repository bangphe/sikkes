<div id="kiri_mini">
<div id="judul">
	Persetujuan Proposal
</div>
<div id="content">
	<form class="appnitro" name="form_filtering" id="form_filtering" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/manajemen/setujui_rekomendasi_direktorat/'.$kd_pengajuan; ?>">
	<table width="100%" height="auto">
		<tr>
			<td width="35%">Dokumen Rekomendasi</td>
			<td width="65%"><input type="file" id="surat_rekomendasi" name="surat_rekomendasi" /><label id="error"><?php echo  form_error('surat_rekomendasi'); ?></label></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset">
						<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
						Reset
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
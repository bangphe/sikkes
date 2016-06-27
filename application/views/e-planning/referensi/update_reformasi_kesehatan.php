<div id="judul" class="title">
	<?php echo  $judul; ?>
</div>
	<div id="content">
		<form name="form_update_reformasi_kesehatan" method="POST" id="form_update_reformasi_kesehatan" action="#">
		<table width="100%" height="100%">
			<tr>
				<td>Periode</td>
				<td>
					<?php echo  form_dropdown('periode', $periode, $selected_periode); ?>
				</td>
			</tr>
			<tr>
				<td>Reformasi Kesehatan</td>
				<td>
					<textarea id="reformasi_kesehatan" name="reformasi_kesehatan"><?php echo  $reformasi_kesehatan; ?></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="update" onClick="update_data(<?php echo  $idReformasiKesehatan;?>);">
							<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
							Update
						</button>
					</div>
				</td>
			</tr>
		</table>
		</form>
	</div>
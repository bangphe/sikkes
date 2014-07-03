<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content">
	<form name="form_update_misi" method="POST" id="form_update_misi" action="#">
	<table width="100%" height="100%">
		<tr>
				<td>Tahun</td>
				<td>
					<?php echo form_dropdown('tahun', $tahun, $selected_tahun); ?>
				</td>
			</tr>
		<tr>
			<td>Misi</td>
			<td>
				<textarea name="misi" id="misi" cols=100><?php echo $misi; ?></textarea>
			</td>
		</tr>
		<tr>
		<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="update" onClick="update_data(<?php echo $idMisi; ?>);">
						<img src="<?php echo base_url(); ?>images/main/update.png" alt=""/>
						Update
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>

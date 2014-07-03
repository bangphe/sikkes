<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
	<div id="content">
		<form name="form_update_visi" method="POST" id="form_update_visi" action="#">
		<table width="100%" height="100%">
			<tr>
				<td>Periode</td>
				<td>
					<?php echo form_dropdown('tahun', $tahun, $selected_tahun); ?>
				</td>
			</tr>
			<tr>
				<td>Visi</td>
				<td>
					<textarea id="visi" name="visi" cols=100><?php echo $visi; ?></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="update" onClick="update_data(<?php echo $idVisi;?>);">
							<img src="<?php echo base_url(); ?>images/main/update.png" alt=""/>
							Update
						</button>
					</div>
				</td>
			</tr>
		</table>
		</form>
	</div>

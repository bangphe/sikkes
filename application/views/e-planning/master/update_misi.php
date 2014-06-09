<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content">
	<form name="form_update_misi" method="POST" id="form_update_misi" action="#">
	<table width="100%" height="100%">
		<tr>
			<td>Periode</td>
			<td>
				<input type="hidden" name="idPeriode" id="idPeriode" value="<?php echo $idPeriode; ?>" />
				<input name="periode" id="periode" value=<?php echo $periode; ?> readonly="TRUE" />
			</td>
		</tr>
		<tr>
			<td>Misi</td>
			<td>
				<?php echo form_dropdown('misi',$misi,$misi_terpilih); ?>
			</td>
		</tr>
		<tr>
		<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="update" onClick="update_data(<?php echo $misi_terpilih;?>);">
						<img src="<?php echo base_url(); ?>images/main/update.png" alt=""/>
						Update
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
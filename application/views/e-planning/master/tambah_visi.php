<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
	<div id="content">
		<form name="form_tambah_visi" method="POST" id="form_tambah_visi" action="#">
		<table width="100%" height="100%">
			<tr>
				<td>Periode</td>
				<td>
					<input type="hidden" name="idPeriode" id="idPeriode" value="<?php echo $idPeriode; ?>" />
					<input name="periode" id="periode" value=<?php echo $periode; ?> readonly="TRUE" />
				</td>
			</tr>
			<tr>
				<td>Visi</td>
				<td>
					<?php echo form_dropdown('visi',$visi); ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save" onClick="save_data(<?php echo $idPeriode; ?>);">
							<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
							Save
						</button>
						<button type="reset" class="negative" name="reset">
							<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
							Reset
						</button>
					</div>
				</td>
			</tr>
		</table>
		</form>
	</div>
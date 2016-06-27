<div id="judul" class="title">
	<?php echo  $judul; ?>
</div>
<div id="content">
	<form name="form_update_tujuan" method="POST" id="form_update_tujuan" action="#">
	<table width="100%" height="100%">
		<tr>
			<td>Periode</td>
			<td>
				<input type="hidden" name="idPeriode" id="idPeriode" value="<?php echo  $idPeriode; ?>" />
				<input name="periode" id="periode" value=<?php echo  $periode; ?> readonly="TRUE" />
			</td>
		</tr>
		<tr>
			<td>Tujuan</td>
			<td>
				<?php echo  form_dropdown('tujuan',$tujuan,$tujuan_terpilih); ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="update" onClick="update_data(<?php echo  $tujuan_terpilih;?>);">
						<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
						Update
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
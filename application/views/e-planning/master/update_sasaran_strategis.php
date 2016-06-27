<div id="judul" class="title">
	<?php echo  $judul; ?>
</div>
	<div id="content">
		<form name="form_update_sasaran" method="POST" id="form_update_sasaran" action="#">
		<table width="100%" height="100%">
			<tr>
				<td>Periode</td>
				<td>
					<?php echo  form_dropdown('periode',$periode, $selected_periode); ?>
				</td>
			</tr>
			<tr>
				<td>Sasaran</td>
				<td>
					<textarea id="sasaran" name="sasaran" cols=100><?php echo  $sasaran; ?></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="update" onClick="update_data(<?php echo  $idSasaran; ?>);">
							<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
							Update
						</button>
					</div>
				</td>
			</tr>
		</table>
		</form>
	</div>

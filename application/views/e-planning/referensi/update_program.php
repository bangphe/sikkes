<div id="judul" class="title">
	<?php echo  $judul; ?>
</div>
<div id="content">
	<form name="form_update_program" method="POST" id="form_update_program" action="#" onsubmit="update_data(<?php echo  $KodeProgram; ?>);" >
	<table width="100%" height="100%">
		<tr>
			<td>Unit Organisasi</td>
			<td>
				<?php echo  form_dropdown('KodeUnitOrganisasi',$unit); ?>
			</td>
		</tr>
		<tr>
			<td>Program</td>
			<td>
				<textarea id="NamaProgram" name="NamaProgram"><?php echo  $NamaProgram; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>Output</td>
			<td>
				<textarea id="OutComeProgram" name="OutComeProgram"><?php echo  $OutComeProgram; ?></textarea>
			</td>
		</tr>
		<tr>
		<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="update">
						<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
						Update
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
<div id="judul" class="title">
	<?php echo  $judul; ?>
</div>
<div id="content">
	<form name="form_tambah_program" method="POST" id="form_tambah_program" action="#" onsubmit="save_data();">
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
				<textarea id="NamaProgram" name="NamaProgram"></textarea>
			</td>
		</tr>
		<tr>
			<td>Output</td>
			<td>
				<textarea id="OutComeProgram" name="OutComeProgram"></textarea>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" >
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
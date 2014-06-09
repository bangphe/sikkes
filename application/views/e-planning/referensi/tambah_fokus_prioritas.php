<div id="judul" class="title">
	Tambah Fokus Prioritas
</div>
<div id="content">
	<form name="form_tambah_fokus_prioritas" method="POST" id="form_tambah_fokus_prioritas" onSubmit="save_data();" action="#">
		<table>
			<tr>
				<td>Periode </td>
				<td><?php echo form_dropdown('periode',$periode); ?></td>
			</tr>
			<tr>
				<td>Fokus Prioritas </td>
				<td><textarea id="fokus_prioritas" name="fokus_prioritas" cols=100></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save">
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

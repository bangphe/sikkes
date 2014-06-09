<div id="judul" class="title">
	Tambah Reformasi Kesehatan
</div>
<div id="content">
	<form name="form_tambah_reformasi_kesehatan" method="POST" id="form_tambah_reformasi_kesehatan" onSubmit="save_data();" action="#">
		<table>
			<tr>
				<td>Periode </td>
				<td><?php $js="id=periode"; echo form_dropdown('periode',$periode,Null,$js); ?></td>
			</tr>
			<tr>
				<td>Reformasi Kesehatan </td>
				<td><textarea id="reformasi_kesehatan" name="reformasi_kesehatan"></textarea></td>
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
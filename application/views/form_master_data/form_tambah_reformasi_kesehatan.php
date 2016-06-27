<div id="judul" class="title">
	Master Reformasi Kesehatan
</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_reformasi_kesehatan/save_reformasi_kesehatan'; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Periode</td>
				<td width="70%"><?php $js = 'id="periode" style="width:80%"'; echo form_dropdown('periode', $periode); ?></td>
			</tr>
			<tr>
				<td width="10%">Reformasi Kesehatan</td>
				<td width="70%"><textarea name="reformasi_kesehatan" id="reformasi_kesehatan" style="width:80%"></textarea><?php echo  form_error('reformasi_kesehatan'); ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save">
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
</div>
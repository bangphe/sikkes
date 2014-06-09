<div id="kiri">
<div id="judul">
	Unggah Data
</div>
<div id="content">
		<form id="form_cari_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/E-Planning/master/upload_excel'; ?>">
			<p>Unggah data (xls,xlsx) </p>
			<input id="file" name="file" class="element file" type="file"/>
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
		</form>
	</div>
</div>
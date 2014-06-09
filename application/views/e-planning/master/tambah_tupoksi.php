<div id="kiri_mini">
<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content">
	<form name="form_tambah_tupoksi" method="POST" id="form_tambah_tupoksi" action="<?php echo base_url(); ?>index.php/e-planning/master/proses_tupoksi/<?php echo $kdsatker; ?>">
	<table width="100%" height="100%">
		<tr>
			<td>No. Tupoksi</td>
			<td>
				<input type="text" name="no_tupoksi" id="no_tupoksi"/>
			</td>
		</tr>
		<tr>
			<td>Tupoksi</td>
			<td>
				<textarea type="text" name="tupoksi" id="tupoksi"  cols=100></textarea>
				<?php echo form_error('tupoksi'); ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
				<button type="submit" class="regular" name="Save">
					<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
					Simpan
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
</div>

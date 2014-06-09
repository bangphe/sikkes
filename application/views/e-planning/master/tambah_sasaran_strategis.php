<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content">
	<form name="form_tambah_sasaran" method="POST" id="form_tambah_sasaran" action="#">
	<table width="100%" height="100%">
		<tr>
			<td>Periode</td>
			<td>
				<?php echo form_dropdown('periode',$periode); ?>
			</td>
		</tr>
		<tr>
			<td>Sasaran</td>
			<td>
				<textarea id="sasaran" name="sasaran" cols=100></textarea>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" onClick="save_data();">
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

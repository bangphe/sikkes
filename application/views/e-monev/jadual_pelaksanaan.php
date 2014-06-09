<script type="text/javascript">
$(document).ready(function(){
  $(function() {
			$( "#tanggal" ).datepicker({ dateFormat: "dd-mm-yy" });
			get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_prakontrak3/"+d_skmpnen_id,'','profile_detail_loading', 'daftar_jadual');
	});
});
</script>
<br />
<fieldset>
<legend>Jadual Pelaksanaan</legend>
<br />
	<table width=auto>
		<tr>
			<td width="40%">Uraian Kegiatan :</td>
			<td width="60%">
				<?php
				$data = array(
						  'name'        => 'uraian_kegiatan',
						  'id'          => 'uraian_kegiatan',
						  'size'        => '30'
						);
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Isi Tanggal :</td>
			<td width="60%">
				<?php
				$data = array(
						  'name'        => 'tanggal',
						  'id'          => 'tanggal',
						  'value'       => '',
						  'size'        => '30',
						);
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="submit" onClick="save_data_jadual_pelaksanaan();">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="reset();">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Reset
					</button>
				</div>
			</td>
		</tr>
	</table>
	<div align="center" id="daftar_jadual">
	</div>
	<br />
</fieldset>

<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content">
	<form name="form_tambah_misi" method="POST" id="form_tambah_misi" action="#">
	<table width="100%" height="100%">
		<!-- <tr>
			<td>Periode</td>
			<td>
				<?php //echo form_dropdown('periode', $periode); ?>
			</td>
		</tr> -->
		<tr>
			<td>Tahun</td>
			<td>
				<select id="tahun" name="tahun">
        			<option value="0">--- Pilih Tahun ---</option>
        			<?php
						  foreach($tahun->result() as $row)
						  {
							  echo '<option value="'.$row->idThnAnggaran.'">'.$row->thn_anggaran.'</option>';
						  }
					?>
        		</select>
			</td>
		</tr>
		<tr>
			<td>Misi</td>
			<td>
				<textarea name="misi" id="misi" cols=100></textarea><?php echo form_error('misi')?>
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

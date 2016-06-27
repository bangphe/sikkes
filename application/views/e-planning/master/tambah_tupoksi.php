<div id="kiri_mini">
<div id="judul" class="title">
	<?php echo  $judul; ?>
</div>
<div id="content">
	<form name="form_tambah_tupoksi" method="POST" id="form_tambah_tupoksi" action="<?php echo  base_url(); ?>index.php/e-planning/master/proses_tupoksi/<?php echo  $kdsatker; ?>">
	<table width="100%" height="100%">
		<tr>
			<td>Periode</td>
			<td>
				<?php $js = 'id="periode" style="width:15%; padding:3px;"'; 
				echo form_dropdown('periode',$periode,null,$js); ?>
			</td>
		</tr>
		<tr>
			<td>Tahun</td>
			<td>
				<select id="tahun" name="tahun" style="width:15%; padding:3px;">
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
			<td>No. Tupoksi</td>
			<td>
				<input type="text" name="no_tupoksi" id="no_tupoksi" style="width:14%; padding:3px;"/>
			</td>
		</tr>
		<tr>
			<td>Tupoksi</td>
			<td>
				<textarea type="text" name="tupoksi" id="tupoksi" rows="4" cols="60"></textarea>
				<?php echo  form_error('tupoksi'); ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
				<button type="submit" class="regular" name="Save">
					<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
					Simpan
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

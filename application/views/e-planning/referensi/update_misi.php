<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content">
	<form name="form_update_misi" method="POST" id="form_update_misi" action="#">
	<table width="100%" height="100%">
		<tr>
			<td>Periode</td>
			<td>
				<?php $js = 'id="periode" style="width:15%; padding:3px;"'; 
				echo form_dropdown('periode',$periode,$selected_periode,$js); ?>
			</td>
		</tr>
		<tr>
			<td>Tahun</td>
			<td>
				<?php $js = 'id="tahun" style="width:15%; padding:3px;"'; 
				echo form_dropdown('tahun',$tahun,$selected_tahun,$js); ?>
			</td>
		</tr>
		<tr>
			<td>Misi</td>
			<td>
				<textarea name="misi" id="misi" rows="4" cols="60"><?php echo $misi; ?></textarea>
			</td>
		</tr>
		<tr>
		<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="update" onClick="update_data(<?php echo $idMisi; ?>);">
						<img src="<?php echo base_url(); ?>images/main/update.png" alt=""/>
						Update
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>

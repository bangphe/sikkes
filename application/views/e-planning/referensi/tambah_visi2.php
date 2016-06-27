<div id="judul" class="title">
	<?php echo  $judul; ?>
</div>
	<div id="content">
		<form name="form_tambah_visi" method="POST" id="form_tambah_visi" action="#">
		<table width="100%" height="100%">
			<tr>
				<td>Periode</td>
				<td>
					<?php $js = 'id="periode" style="width:15%; padding:3px;"'; 
					echo form_dropdown('periode',$periode,null,$js); ?>
					<a href="#" class="tambah">Masukkan periode?</a>
				</td>
			</tr>
			<div class="tambah-periode" style="display:none">
				<tr>
					<td>Periode Awal </td>
					<td>
						<select name="periode_awal">
							<?php
								$temp = date("Y")-5;
								$periode = $temp+11;
								while($temp < $periode){
							?>
							<option value="<?php echo  $temp; ?>"><?php echo  $temp; ?></option>
							<?php
								$temp++;
								} 
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Periode Akhir </td>
					<td>
						<select name="periode_akhir">
							<?php
								$temp = date("Y")+5;
								$periode = $temp-11;
								while($temp > $periode){
							?>
							<option value="<?php echo  $temp; ?>"><?php echo  $temp; ?></option>
							<?php
								$temp--;
								} 
							?>
						</select>
					</td>
				</tr>
			</div>
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
				<td>Visi</td>
				<td>
					<textarea name="visi" id="visi" rows="4" cols="60"><?php echo  form_error('visi')?></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save" onClick="save_data();">
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

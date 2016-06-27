<div id="judul" class="title">
	Tambah Periode
</div>
<div id="content">
	<form name="form_tambah_periode" id="form_tambah_periode" method="post" action="#">
		<table>
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
<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content">
	<form name="form_update_periode" id="form_update_periode" method="post" action="#">
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
						<option <?php if($temp==$periode_awal) echo "selected"; ?> value="<?php echo $temp; ?>"><?php echo $temp; ?></option>
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
						<option <?php if($temp==$periode_akhir) echo "selected"; ?> value="<?php echo $temp; ?>"><?php echo $temp; ?></option>
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
						<button type="submit" class="regular" name="update" onClick="update_data(<?php echo $idPeriode; ?>);">
							<img src="<?php echo base_url(); ?>images/main/update.png" alt=""/>
							Update
						</button>
					</div>
				</td>
			</tr>
		</table>
	</form>
</div>
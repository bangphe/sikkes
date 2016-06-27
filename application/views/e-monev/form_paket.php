<fieldset>
<legend>Form Paket</legend>
<br />
	<table width=auto>
		<tr>
			<td width="60%">Nama Satker :</td>
			<td width="40%">
				<?php echo  $nmsatker;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Program :</td>
			<td width="40%">
				<?php echo  $nmprogram;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Kegiatan :</td>
			<td width="40%">
				<?php echo  $nmgiat;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Output :</td>
			<td width="40%">
				<?php echo  $nmoutput;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Suboutput :</td>
			<td width="40%">
				<?php echo  $ursoutput;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Nama Komponen :</td>
			<td width="40%">
				<?php echo  $urkmpnen;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Nama Sub Komponen :</td>
			<td width="40%">
				<?php echo  $sub_komponen;?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="submit" onClick="save_data_paket();">
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
</fieldset>

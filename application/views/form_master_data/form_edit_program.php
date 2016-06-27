<div id="tengah">
<div id="judul" class="title">
	Program
</div>
<div id="content_tengah">
	<form name="form_program" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_program/update_program/'.$KodeProgram; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Program</td>
				<td width="70%"><input type="text" id="kode_program" name="kode_program" style="width:6%; padding:3px" value="<?php echo  $KodeProgram; ?>" readonly="readonly" /></td>
            <tr>
            <tr>
				<td width="10%">Unit Organisasi</td>
				<td width="70%"><?php $js = 'id="unit_organisasi" style="width:55%; padding:2px;" disabled="disabled"'; echo form_dropdown('unit_organisasi', $unit_organisasi, $selected_unit_organisasi, $js); ?></td>
			</tr>
			<tr>
				<td width="10%">Program</td>
				<td width="70%"><textarea id="program" name="program" style="width:50%" rows="3"><?php echo  $program; ?></textarea></td>
			</tr>
			<tr>
				<td width="10%">Output</td>
				<td width="70%"><textarea id="output" name="output" style="width:50%" rows="3"><?php echo  $output; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="status" style="width:10%; padding:2px;"'; echo form_dropdown('status',$status,$selected_status, $js); ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save">
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
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_program/grid_program"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>
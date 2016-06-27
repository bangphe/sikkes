<div id="tengah">
<div id="judul" class="title">IKU</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_Iku/update_Iku/'.$KodeIku; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Program</td>
				<td width="70%"><?php $js = 'id="program" style="width:60%; padding:3px;" disabled="disabled"'; echo form_dropdown('program', $program, $selected_program, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode IKU</td>
				<td width="70%"><input type="text" id="kdiku" name="kdiku" style="width:10%; padding:3px" value="<?php echo  $KodeIku?>" readonly="readonly" /></td>
			</tr>
			<tr>
				<td width="10%">IKU</td>
				<td width="70%"><textarea name="Iku" id="Iku" style="width:50%; padding:3px;" rows="3"/><?php echo  $Iku; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="status" style="width:10%; padding:3px;"'; echo form_dropdown('status',$status,null,$js); ?></td>
			</tr>
            <tr>
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_iku/grid_iku"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
			</tr>
		</table>
	</form>
</div>
</div>
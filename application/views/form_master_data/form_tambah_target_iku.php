<div id="tengah">
<div id="judul" class="title">
	Master Ikk
</div>
<div id="content_tengah">
	<form name="form_iku" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_iku/save_target/'.$kode_iku; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Iku</td>
				<td width="70%"><input type="text" name="iku" id="iku"   value="<?php echo  $kode_iku;?>" readonly="TRUE"></td>
			</tr>
            <tr>
				<td width="10%">Tahun Anggaran</td>
				<td width="70%">
					<?php
						$js = 'id="thn_anggaran" ';
						echo form_dropdown('thn_anggaran', $tahun, null, $js);
					?>
				</td>
			</tr>
            <tr>
				<td width="10%">Target Iku</td>
				<td width="70%"><textarea name="target_iku" id="target_iku" style="width:50%; padding:3px;" rows="1"/></textarea><?php echo  form_error('target_iku'); ?></td>
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_iku/grid_target_nasional/<?php echo  $kode_iku; ?>"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
			</tr>
		</table>
	</form>
</div>
</div>
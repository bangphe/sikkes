<div id="tengah">
<div id="judul" class="title">
	Kabupaten
</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_kabupaten/update_kabupaten/'.$KodeKabupaten; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Provinsi</td>
				<td width="70%"><?php $js = 'id="provinsi" style="padding:3px; width:25%"'; echo form_dropdown('provinsi', $provinsi, $KodeProvinsi, $js); ?></td>
			</tr>
			<tr>
				<td width="10%">Kabupaten</td>
				<td width="70%"><input type="text" name="kabupaten" style="width:24%; padding:3px" id="kabupaten" value="<?php echo  $NamaKabupaten; ?>" /></td>
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_kabupaten/grid_kabupaten"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>
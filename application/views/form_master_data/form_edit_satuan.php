<div id="master">
<div id="judul" class="title">
	Satuan
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_edit_satuan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_satuan/update_satuan/'.$KodeSatuan ?>">

	<table width="80%" height="25%">
        <tr>
				<td width="10%">Nama Satuan</td>
				<td width="70%"><input type="text" name="nmsatuan" id="nmsatuan" style="width:15%; padding:4px" value="<?php echo  $Satuan;?>" /><?php echo  form_error('Satuan'); ?></td>
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_satuan/grid_satuan"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
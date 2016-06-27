<div id="master">
<div id="judul" class="title">
	Unit
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_edit_unit" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_unit/update_unit/'.$KDUNIT ?>">

	<table width="80%" height="25%">
		<tr>
				<td width="10%">Kode Departemen</td>
				<td width="70%"><input type="text" name="kode" id="kode" style="padding:3px; width:5%" value="<?php echo  $kode_dept; ?>" readonly="readonly" /></td>
			</tr>
        <tr>
				<td width="12%">Kode Unit</td>
				<td width="70%"><input type="text" name="KDUNIT" id="KDUNIT" style="padding:3px; width:5%" value="<?php echo  $KDUNIT;?>" /></td>
			</tr>
        <tr>
				<td width="10%">Nama Unit</td>
				<td width="70%"><textarea name="NMUNIT" id="NMUNIT" style="width:30%; padding:5px" /><?php echo  $NMUNIT;?></textarea></td>
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_unit/grid_unit"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
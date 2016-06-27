<div id="master">
<div id="judul" class="title">
	Unit
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_detail_unit" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_unit/detail_unit/'.$KDUNIT ?>">

	<table width="80%" height="25%">
		<tr>
				<td width="10%">Kode Departemen</td>
				<td width="70%"><input type="text" name="kode" id="kode" style="padding:3px; width:5%" value="<?php echo  $kode_dept; ?>" readonly="readonly" /></td>
			</tr>
        <tr>
				<td width="12%">Kode Unit</td>
				<td width="70%"><input type="text" name="KDUNIT" id="KDUNIT" style="padding:3px; width:5%" value="<?php echo  $KDUNIT;?>" readonly="TRUE" /></td>
			</tr>
        <tr>
				<td width="10%">Nama Unit</td>
				<td width="70%"><textarea name="NMUNIT" id="NMUNIT" style="width:30%; padding:5px" readonly="TRUE" /><?php echo  $NMUNIT;?></textarea></td>
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
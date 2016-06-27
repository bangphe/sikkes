<div id="master">
<div id="judul" class="title">
	Provinsi
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form name="form_provinsi" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_propinsi/detail_provinsi/'.$KodeProvinsi; ?>">


	<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Provinsi</td>
				<td width="70%"><input type="text" name="KodeProvinsi" id="KodeProvinsi" style="width:25%; padding:4px" readonly="TRUE" value="<?php echo  $KodeProvinsi; ?>" /></td>
			</tr>
            <tr>
				<td width="10%">Nama Provinsi</td>
				<td width="70%"><input type="text" name="NamaProvinsi" id="NamaProvinsi" style="width:25%; padding:4px" readonly="TRUE" value="<?php echo  $NamaProvinsi; ?>" /></td>
			</tr>
			<tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_propinsi/grid_propinsi"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
<div id="master">
<div id="judul" class="title">
	Kanwil
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_detail_kanwil" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_kanwil/detail_kanwil/'.$KDKANWIL ?>">

	<table width="80%" height="25%">
		<tr>
				<td width="12%">Kode Kanwil</td>
				<td width="70%"><input type="text" name="KDKANWIL" id="KDKANWIL" style="padding:3px; width:7%" value="<?php echo  $KDKANWIL;?>" readonly="TRUE" /></td>
			</tr>
        <tr>
				<td width="10%">Nama Kanwil</td>
				<td width="70%"><input type="text" name="NMKANWIL" id="NMKANWIL" style="width:25%; padding:3px" value="<?php echo  $NMKANWIL;?>" readonly="TRUE" /></td>
			</tr>
             <tr>
				<td width="10%">Kode Romawi</td>
				<td width="70%"><input type="text" name="KDROMAWI" id="KDROMAWI" style="width:25%; padding:3px" value="<?php echo  $KDROMAWI;?>" readonly="TRUE" /></td>
			</tr>
            <tr>
				<td width="10%">Provinsi</td>
				<td width="70%"><?php $js = 'id="KDPROVINSI" style="width:26%; padding:3px" disabled="disabled"'; echo form_dropdown('KDPROVINSI', $provinsi, $KDPROV, $js); ?></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_kanwil/grid_kanwil"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
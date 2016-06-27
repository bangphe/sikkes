<div id="master">
<div id="judul" class="title">
	Fungsi
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form name="form_fungsi" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_fungsi/detail_fungsi/'.$KodeFungsi; ?>">


	<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Fungsi</td>
				<td width="70%"><textarea name="KodeFungsi" id="KodeFungsi" style="width:35%" readonly="TRUE"/><?php echo  $KodeFungsi; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Nama Fungsi</td>
				<td width="70%"><textarea name="NamaFungsi" id="NamaFungsi" style="width:35%" readonly="TRUE" /><?php echo  $NamaFungsi; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="KodeStatus" style="width:10%; padding:3px" disabled="disabled"'; echo form_dropdown('KodeStatus',$status, $KodeStatus, $js); ?></td>
			</tr>
			<tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_fungsi/grid_daftar"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
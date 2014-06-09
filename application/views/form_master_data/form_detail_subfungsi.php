<div id="master">
<div id="judul" class="title">
	Sub Fungsi
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form name="form_sub_fungsi" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_subfungsi/detail_subfungsi/'.$KodeSubFungsi.'/'.$KodeFungsi; ?>">


	<table width="80%" height="25%">
             <tr>
				<td width="10%">Kode Fungsi</td>
				<td width="70%"><?php $js = 'id="KodeFungsi" style="width:7%" disabled="disabled"'; echo form_dropdown('KodeFungsi', $KodeFungsi, $fungsi, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode Sub Fungsi</td>
				<td width="70%"><textarea name="KodeSubFungsi" id="KodeSubFungsi" style="width:20%" readonly="TRUE"/><?php echo $KodeSubFungsi; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Nama Sub Fungsi</td>
				<td width="70%"><textarea name="NamaSubFungsi" id="NamaSubFungsi" style="width:35%" readonly="TRUE" rows="4" /><?php echo $NamaSubFungsi; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="KodeStatus" style="width:12%; padding:3px;" disabled="disabled"'; echo form_dropdown('KodeStatus', $KodeStatus, $status, $js); ?></td>
			</tr>
			<tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/master_data/master_subfungsi/grid_daftar"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
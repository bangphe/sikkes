<div id="master">
<div id="judul" class="title">
	Jenis Satker
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_edit_jenis_satker" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_jenis_satker/update/'.$kdjnssat; ?>">

	<table width="80%" height="25%">
    		<tr>
				<td width="10%">Kode Jenis Satker</td>
				<td width="70%"><input type="text" name="kdjnssat" id="kdjnssat" style="width:3%; padding:4px" readonly="TRUE" value="<?php echo $kdjnssat; ?>" /></td>
			</tr>
        	<tr>
				<td width="10%">Jenis Satker</td>
				<td width="70%"><input type="text" name="nmjnssat" id="nmjnssat" style="width:20%; padding:4px" readonly="TRUE" value="<?php echo $nmjnssat; ?>" /></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/master_data/master_jenis_satker"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
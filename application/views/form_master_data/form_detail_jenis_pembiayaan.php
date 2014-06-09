<div id="master">
<div id="judul" class="title">
	Jenis Pembiayaan
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_detail_jenis_pembiayaan" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_jenis_pembiayaan/detail_jenis_pembiayaan/'.$KodeJenisPembiayaan ?>">

	<table width="80%" height="25%">
		<tr>
				<td width="12%">Kode Jenis Pembiayaan</td>
				<td width="70%"><input type="text" name="KodeJenisPembiayaan" id="KodeJenisPembiayaan" style="padding:3px; width:14%" readonly="TRUE" value="<?php echo $KodeJenisPembiayaan;?>" /></td>
			</tr>
        <tr>
				<td width="10%">Nama Jenis Pembiayaan</td>
				<td width="70%"><input type="text" name="JenisPembiayaan" id="JenisPembiayaan" style="width:14%; padding:3px" readonly="TRUE" value="<?php echo $JenisPembiayaan;?>" /></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/master_data/master_jenis_pembiayaan/grid_jenis_pembiayaan"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
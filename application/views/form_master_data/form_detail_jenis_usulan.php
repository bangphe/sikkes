<div id="master">
<div id="judul" class="title">
	Jenis Usulan
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_detail_jenis_usulan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_jenis_usulan/detail/'.$KodeJenisUsulan; ?>">

	<table width="80%" height="25%">
    		<tr>
				<td width="10%">Kode Jenis Usulan</td>
				<td width="70%"><input type="text" name="KodeJenisUsulan" id="KodeJenisUsulan" style="width:10%; padding:4px" readonly="TRUE" value="<?php echo  $KodeJenisUsulan; ?>" /></td>
			</tr>
        	<tr>
				<td width="10%">Jenis Usulan</td>
				<td width="70%"><input type="text" name="JenisUsulan" id="JenisUsulan" style="width:60%; padding:4px" readonly="TRUE" value="<?php echo  $JenisUsulan; ?>" /></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_jenis_usulan/grid_jenis_usulan"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>

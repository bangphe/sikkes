<div id="master">
<div id="judul" class="title">
	Jenis Kewenangan
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_detail_jenis_satker" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_jenis_satker/detail/'.$KodeJenisSatker; ?>">

	<table width="80%" height="25%">
    		<tr>
				<td width="10%">Kode Jenis Satker</td>
				<td width="70%"><input type="text" name="KodeJenisSatker" id="KodeJenisSatker" style="width:10%; padding:4px" readonly="TRUE" value="<?php echo  $KodeJenisSatker; ?>" /></td>
			</tr>
        	<tr>
				<td width="10%">Jenis Satker</td>
				<td width="70%"><input type="text" name="JenisSatker" id="JenisSatker" style="width:50%; padding:4px" readonly="TRUE" value="<?php echo  $JenisSatker; ?>" /></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a  onClick="history.go(-1);"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Kembali</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
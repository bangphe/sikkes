<div id="master">
<div id="judul" class="title">
	Unggah Evaluasi
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_unggah_evaluasi" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-monev/laporan_evaluasi/do_unggah/'.$id; ?>">

	<table width="80%" height="25%">
		<tr>
				<td width="10%">File Dokumen</td>
				<td width="70%"><input id="file_unggah" name="file_unggah" class="element file" type="file"/></td>
		</tr>
		<?php if($error_file != ''){ ?>
		<tr>
				<td width="10%">&nbsp;</td>
				<td width="70%"><?php echo  $error_file; ?></td>
		</tr>
		<?php } ?>
	</table>
	<table width="100%"><tr><td  width="100%" style="text-align:center">
	<div class="buttons">
	  <button type="button" class="negative" name="batal" onClick="history.go(-1);"> <img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/> Batal </button>
      <button type="submit" class="regular" name="save" id="save"> <img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/> Simpan </button>
	  </div>
	 </td></tr></table>
	</form>
</div>
</div>
<div id="master">
<div id="judul" class="title">
	Unggah Dokumen
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_unggah_dokumen" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-monev/laporan_monitoring/do_unggah/'.$d_skmpnen_id; ?>">

	<table width="80%" height="25%">
	<div>
		<?= anchor(site_url('e-monev/laporan_monitoring/daftar_dokumen/'.$d_skmpnen_id),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Dokumen'); ?>
		</div>
		<br />
		<?php if($error_file != ''){ ?>
		<tr>
				<td width="10%">&nbsp;</td>
				<td width="70%"><?php echo $error_file; ?></td>
		</tr>
		<? } ?>
		<tr>
				<td width="10%">File Dokumen</td>
				<td width="70%"><div id="error_file"></div><input id="file_unggah" name="file_unggah" class="element file" type="file"/></td>
		</tr>
		<tr>
				<td width="10%">Keterangan</td>
				<td width="70%"><div id="error_ket"></div><?php 
							$data = array(
										'name'        => 'ket_file',
										'id'		  => 'ket_file',
										'cols'        => '40',
										'rows'        => '5'
									);
							echo form_textarea($data);
						?></td>
		</tr>
		<tr>
		<td width="10%">&nbsp;</td>
		<td width="70%">
			Characters :  <p id="counter"></p>
		</td>
		</tr>
	</table>
	<table width="100%"><tr><td  width="100%" style="text-align:center">
	<div class="buttons">
	  <button type="button" class="negative" name="batal" onClick="history.go(-1);"> <img src="<?php echo base_url(); ?>images/main/back.png" alt=""/> Batal </button>
      <button type="submit" class="regular" name="save" id="save" onClick="return cek_ket_file()"> <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/> Simpan </button>
	  </div>
	 </td></tr></table>
	</form>
</div>
</div>

<script type="text/javascript">	
$(document).ready(function()
{
    var max_length = 100;
    //run listen key press
    whenkeydown(max_length);
});
 
function whenkeydown(max_length)
{
    $("#ket_file").unbind().keyup(function()
    {
        //check if the appropriate text area is being typed into
        if(document.activeElement.id === "ket_file")
        {
            //get the data in the field
            var text = $(this).val();
 
            //set number of characters
            var numofchars = text.length;
 
            if(numofchars <= max_length)
            {
                //set the length of the text into the counter span
                $("#counter").html(text.length);
            }
            else
            {
                //make sure string gets trimmed to max character length
                $(this).val(text.substring(0, max_length));
            }
        }
    });
}

function cek_ket_file(){
	var file_unggah = $("#file_unggah").val();
	var ket_file = $("#ket_file").val();
	if(file_unggah == '' && ket_file == ''){
		document.getElementById("error_file").innerHTML = 'File dokumen wajib diisi';
		document.getElementById("error_ket").innerHTML = 'Keterangan wajib diisi';
		return false;
	}else if(file_unggah == ''){
		document.getElementById("error_file").innerHTML = 'File dokumen wajib diisi';
		document.getElementById("error_ket").innerHTML = '';
		return false;
	}else if(ket_file == ''){
		document.getElementById("error_file").innerHTML = '';
		document.getElementById("error_ket").innerHTML = 'Keterangan wajib diisi';
		return false;
	}else{
		return true;
	}
}
</script>
<script type="text/javascript">
// function validasiKode(kode){
	// $.ajax({
		// url: '<?php echo  base_url()?>index.php/master_data/master_fungsi/valid/'+kode,
		// data: '',
		// type: 'GET',
		// beforeSend: function()
		// {},
		// success: function(data)
		// {
			// if(data=='FALSE')
			// {
				// document.getElementById('submit').disabled = true;
				// alert('Maaf, kode telah terdaftar dalam database.');
			// }
			// else
			// {
				// document.getElementById('submit').disabled = false;
			// }
		// }
	// })
// }
</script>

<div id="master">
<div id="judul" class="title">
	Fungsi
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form name="form_edit_fungsi" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_fungsi/update_fungsi/'.$KodeFungsi; ?>">


	<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Fungsi</td>
				<td width="70%"><input type="text" name="KodeFungsi" id="KodeFungsi" style="padding:3px; width:5%" value="<?php echo  $KodeFungsi; ?>" readonly="readonly" /></td>
			</tr>
			<tr>
            <tr>
				<td width="10%">Nama Fungsi</td>
				<td width="70%"><textarea name="NamaFungsi" id="NamaFungsi" style="width:35%"/><?php echo  $NamaFungsi; ?></textarea><?php echo  form_error('NamaFungsi'); ?></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="KodeStatus" style="width:10%; padding:3px"'; echo form_dropdown('KodeStatus',$status, $KodeStatus, $js); ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save" id="submit">
							<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
							Save
						</button>
						<button type="reset" class="negative" name="reset">
							<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
							Reset
						</button>
					</div>
				</td>
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
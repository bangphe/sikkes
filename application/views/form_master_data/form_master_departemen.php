<script type="text/javascript">
// function validasiKode(kode)
// {
	// $.ajax({
		// url: '<?php echo base_url()?>index.php/master_data/master_departemen/valid/'+kode,
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
				////alert(submit.innerHTML);
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
	Master Departemen
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_master_departemen" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_departemen/add_process'; ?>">

	<table width="80%" height="25%">
		<tr>
				<td width="10%">Kode Departemen</td>
				<td width="70%"><input type="text" name="KDDEPT" id="KDDEPT" style="padding:3px; width:5%" value="<?php echo $kode_dept=$this->gm->get_max('ref_dept','KDDEPT')+1; ?>" readonly="readonly" /></td>
				<!--td width="70%"><textarea name="KDDEPT" id="KDDEPT" style="width:35%" onchange="validasiKode(this.value)"/></textarea><?php //echo form_error('KDDEPT', '<p class="field_error">', '</p>');?></td-->
			</tr>
        <tr>
				<td width="10%">Nama Departemen</td>
				<td width="70%"><textarea name="NMDEPT" id="NMDEPT" style="width:35%"/></textarea><?php echo form_error('NMDEPT','<p class="field_error">','</p>'); ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save" id="submit">
							<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
							Save
						</button>
						<button type="reset" class="negative" name="reset">
							<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
							Reset
						</button>
					</div>
				</td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/master_data/master_departemen/grid_daftar"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
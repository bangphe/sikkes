<script type="text/javascript">
 function validasiKode(kode){
	 $.ajax({
		 url: '<?php echo base_url()?>index.php/master_data/master_propinsi/valid/'+kode,
		 data: '',
		 type: 'GET',
		 beforeSend: function()
		 {},
		 success: function(data)
		 {
			 if(data=='FALSE')
			 {
				 document.getElementById('submit').disabled = true;
				 alert('Maaf, kode '+kode+' telah terdaftar dalam database.');
			 }
			 else
			 {
				 document.getElementById('submit').disabled = false;
			 }
		 }
	 })
 }
</script>

<div id="master">
<div id="judul" class="title">
	Provinsi
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master" style="overflow:auto;">
	<form class="appnitro" name="form_master_propinsi" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_propinsi/add_process'; ?>">

	<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Provinsi</td>
				<td width="70%"><input type="text" name="KodeProvinsi" id="KodeProvinsi" style="width:25%; padding:4px" onchange="validasiKode(this.value)"/><?php echo form_error('KodeProvinsi'); ?></td>
			</tr>
            <tr>
				<td width="10%">Nama Provinsi</td>
				<td width="70%"><input type="text" name="NamaProvinsi" id="NamaProvinsi" style="width:25%; padding:4px"/><?php echo form_error('NamaProvinsi'); ?></td>
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
                        <a href="<?php echo base_url();?>index.php/master_data/master_propinsi/grid_propinsi"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
			</tr>
	</table>
	</form>
</div>
</div>
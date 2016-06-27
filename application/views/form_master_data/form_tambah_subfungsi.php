<script type="text/javascript">
 function validasiKode(kode){
	 var x = document.getElementById("KodeFungsi");
	 getVal = x.value; 
	 $.ajax({
		 url: '<?php echo  base_url()?>index.php/master_data/master_subfungsi/valid/'+kode,
		 data: 'x='+getVal,
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

<div id="tengah">
<div id="judul" class="title">
	Sub Fungsi
</div>
<div id="content_tengah">
	<form class="appnitro" name="form_master_subfungsi" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_subfungsi/save_subfungsi'; ?>">

	<table width="80%" height="25%">
		<tr>
				<td width="10%">Kode Fungsi</td>
				<td width="70%"><?php $js = 'id="KodeFungsi" style="width:5%; padding:3px"'; echo form_dropdown('KodeFungsi',$fungsi, null, $js); ?><?php echo  form_error('KodeFungsi'); ?></td>
			</tr>
        <tr>
				<td width="10%">Kode Sub Fungsi</td>
				<td width="70%"><input type="text" name="KodeSubFungsi" id="KodeSubFungsi" style="padding:3px" onchange="validasiKode(this.value)"/><?php echo  form_error('KodeSubFungsi'); ?></td>
			</tr>
        <tr>
				<td width="10%">Nama Sub Fungsi</td>
				<td width="70%"><textarea name="NamaSubFungsi" id="NamaSubFungsi" style="width:30%"/></textarea><?php echo  form_error('NamaSubFungsi'); ?></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="KodeStatus" style="width:10%; padding:3px"'; echo form_dropdown('KodeStatus',$status, null, $js); ?></td>
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_subfungsi/grid_daftar"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
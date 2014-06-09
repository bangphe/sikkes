<script type="text/javascript">
function validasiNama(nama)
{
	$.ajax({
		url: '<?php echo base_url()?>index.php/master_data/master_kabupaten/valid/',
		data: 'nama='+nama,
		type: 'GET',
		beforeSend: function()
		{},
		success: function(data)
		{
			if(data=='FALSE')
			{
				document.getElementById('submit').disabled = true;
				alert('Maaf, nama Kabupaten telah terdaftar dalam database.');
			}
			else
			{
				document.getElementById('submit').disabled = false;
			}
		}
	})
}
function getKode() {
	  var x = document.getElementById("provinsi");
	  var y = document.getElementById("kdkab");
	  getCmb = x.value;
	 // y.value = getCmb;
}
function validasiKode(kode){
	 var x = document.getElementById("provinsi");
	 getVal = x.value;
	 $.ajax({
		 url: '<?php echo base_url()?>index.php/master_data/master_kabupaten/validKode/'+kode,
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
 
function validate_form()
	{
	var a=document.forms["form_kabupaten"]["kdkab"].value;
	var b=document.forms["form_kabupaten"]["kabupaten"].value;
	if (a==null || a=="" || b==null || b=="")
	  {
	  alert("Kode dan nama kabupaten/kota harus diisi.");
	  return false;
	  }
	 
}
</script>
<div id="tengah">
<div id="judul" class="title">
	Kabupaten
</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_kabupaten/save_kabupaten'; ?>" onsubmit="return validate_form()">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Provinsi</td>
				<td width="70%"><?php $js = 'name="provinsi" id="provinsi" style="width:25%; padding:3px"'; echo form_dropdown('provinsi', $provinsi, null, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode Kabupaten</td>
				<td width="70%"><input type="text" name="kdkab" id="kdkab" style="width:24%; padding:3px" onchange="validasiKode(this.value)" /><?php echo form_error('kdkab'); ?></td>
			</tr>
			<tr>
				<td width="10%">Kabupaten</td>
				<td width="70%"><input type="text" name="kabupaten" id="kabupaten" style="width:24%; padding:3px" onchange="validasiNama(this.value)" /><?php echo form_error('kabupaten'); ?></td>
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
                        <a href="<?php echo base_url();?>index.php/master_data/master_kabupaten/grid_kabupaten"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>
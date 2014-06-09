<script>
function getJabatan(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/master_data/master_pegawai/getJabatan/'+v;
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option;
			var nama;
			var j=0, k=0, l=0;
			
			//$('#testing').html('');
			
			$('#jabatan').html('<option>--- Pilih Disini ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['kodeJabatan'];
				nama = data[i]['namaJabatan'];
				option += '<option value="'+id+'">'+nama+'</option>';
				
			}
  				$('#jabatan').append(option);
		}
	});	
}
</script>

<div id="tengah">
<div id="judul" class="title">Pegawai</div>
<div id="content_tengah">
	<form class="appnitro" name="form_tambah_pegawai" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_pegawai/edit_proses/'.$id; ?>">
	<ul id="tt" class="easyui-tree"
			url="<?php echo base_url(); ?>index.php/master_data/master_pegawai/json"
			checkbox="true">
	</ul>
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%">NIP Pegawai</td>
			<td width="85%"><input name="nip_peg" id="nip_peg" type="text" style="padding:3px; width:20%" value="<?php echo $nip; ?>" /><?php echo form_error('nip_peg'); ?></td>
		</tr>
        <tr>
			<td width="15%">Nama Pegawai</td>
			<td width="85%"><input name="nama_peg" id="nama_peg" type="text" style="padding:3px; width:20%" value="<?php echo $nama_peg; ?>" /><?php echo form_error('nama_peg'); ?></td>
		</tr>
        <tr id="menu_satker">
			<td width="15%">Nama Satker</td>
			<td width="85%"><?php $css = 'id="satker" style="padding:3px; width:48%"'; echo form_dropdown('satker', $opt_satker, $satker, $css); ?></td>
		</tr>
		<tr id="menu_unit_utama">
			<td width="15%">Unit Utama</td>
			<td width="85%"><?php $css = 'id="unit_utama" style="padding:3px; width:48%" onchange="getJabatan(this.value)"'; echo form_dropdown('unit_utama', $opt_unit_utama, $unit, $css); ?></td>
		</tr>
        <tr id="menu_jabatan">
			<td width="15%">Jabatan</td>
			<td width="85%">
				<select id="jabatan" name="jabatan" style="width:48%; padding:3px">
                <option><?php echo $jabatan; ?></option></select>
                </td>
		</tr>
        <tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save">
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
	</table>
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		
        <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/master_data/master_pegawai/grid_pegawai"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>

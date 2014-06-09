<script type="text/javascript">
function getKab(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/pendaftaran/get_kab/'+v;
	//alert(v)
	
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
			
			//$('#testing').html('');
			
			$('#kabupaten').html('<option>--- Pilih Kabupaten ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeKabupaten'];
				nama = data[i]['NamaKabupaten'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#kabupaten').append(option);
		}
	});	
}
</script>
<div id="master">
<div id="judul" class="title">
	KPPN
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_edit_kppn" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_kppn/update_kppn/'.$kode_kppn; ?>">

	<table width="80%" height="25%">
            <tr>
				<td width="10%">Kode KPPN</td>
				<td width="70%"><input type="text" name="kode_kppn" id="kode_kppn" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo $kode_kppn?>" /><?php echo form_error('kode_kppn'); ?></td>
			</tr>
            <tr>
				<td width="10%">Tipe KPPN</td>
				<td width="70%"><input type="text" name="tipe_kppn" id="tipe_kppn" style="padding:3px; width:10%" value="<?php echo $tipe?>" /><?php echo form_error('tipe_kppn'); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode KTUA</td>
				<td width="70%"><input type="text" name="kode_ktua" id="kode_ktua" style="padding:3px; width:10%" value="<?php echo $kdktua?>" /><?php echo form_error('kode_ktua'); ?></td>
			</tr>
            <tr>
				<td width="10%">Kanwil</td>
				<td width="70%"><?php $js = 'id="KDKANWIL" style="width:20%; padding:3px"'; echo form_dropdown('KDKANWIL', $option_kanwil, $kanwil, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">KDDATIDUA</td>
				<td width="70%"><input type="text" name="KDDATIDUA" id="KDDATIDUA" style="padding:3px; width:10%" value="<?php echo $kddatidua?>"/><?php echo form_error('KDDATIDUA'); ?></td>
			</tr>
            <tr>
				<td width="10%">Provinsi</td>
				<td width="70%"><?php $js = 'id="kode_prov" style="width:25%; padding:3px" onchange="getKab(this.value)"'; echo form_dropdown('kode_prov', $option_prov, $prov, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kota/Kabupaten</td>
				<td width="70%"><select id="kabupaten" name="kabupaten" style="padding:3px; width:25%" >
            		<option><?php echo $kab?></option></select></td>
			</tr>
            <tr>
				<td width="10%">Nama KPPN</td>
				<td width="70%"><input type="text" name="nama_kppn" id="nama_kppn" style="padding:3px; width:25%" value="<?php echo $nama?>" /><?php echo form_error('nama_kppn'); ?></td>
			</tr>
            <tr>
				<td width="10%">Alamat KPPN</td>
				<td width="70%"><textarea name="alamat" id="alamat" style="padding:3px; width:25%" readonly="TRUE"><?php echo $alamat;?></textarea><?php echo form_error('alamat'); ?></td>
			</tr>
            <tr>
				<td width="10%">Telpon KPPN</td>
				<td width="70%"><input type="text" name="telpon" id="telpon" style="padding:3px; width:15%" value="<?php echo $telp?>" /><?php echo form_error('telpon'); ?></td>
			</tr>
            <tr>
				<td width="10%">Email KPPN</td>
				<td width="70%"><input type="text" name="email" id="email" style="padding:3px; width:15%" value="<?php echo $email?>" /><?php echo form_error('email'); ?></td>
			</tr>
            <tr>
				<td width="10%">KDKCBI</td>
				<td width="70%"><input type="text" name="KDKCBI" id="KDKCBI" style="padding:3px; width:10%" value="<?php echo $kode_kppn?>" /><?php echo form_error('KDKCBI'); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode Pos</td>
				<td width="70%"><input type="text" name="kodepos" id="kodepos" style="padding:3px; width:10%" value="<?php echo $kodepos?>"/><?php echo form_error('kodepos'); ?></td>
			</tr>
            <tr>
				<td width="10%">Fax</td>
				<td width="70%"><input type="text" name="fax" id="fax" style="padding:3px; width:10%" value="<?php echo $fax?>"/><?php echo form_error('fax'); ?></td>
			</tr>
            <tr>
				<td width="10%">KDDEFA</td>
				<td width="70%"><input type="text" name="KDDEFA" id="KDDEFA" style="padding:3px; width:10%" value="<?php echo $kddefa?>"/><?php echo form_error('KDDEFA'); ?></td>
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
                        <a href="<?php echo base_url();?>index.php/master_data/master_kppn"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
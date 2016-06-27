<script type="text/javascript">
function validasiTahun(tahun)
{
	$.ajax({
		url: '<?php echo  base_url()?>index.php/master_data/master_tahun_anggaran/validasi/'+tahun,
		data: '',
		type: 'GET',
		beforeSend: function()
		{},
		success: function(data)
		{
			if(data=='FALSE')
			{
				document.getElementById('submit').disabled = true;
				alert('Maaf, data yang diinputkan telah terdaftar dalam database.');
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
	Master Tahun Anggaran
</div>
<div id="content_tengah">
	<form name="form_tahun_anggaran" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_tahun_anggaran/save_tahun_anggaran'; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Tahun Anggaran</td>
				<td width="70%"><input type="text" name="thn_anggaran" id="thn_anggaran" style="width:24%; padding:3px" onchange="validasiTahun(this.value)" /><?php echo  form_error('thn_anggaran'); ?></td>
			</tr>
            <tr>
				<td width="10%">Periode</td>
				<td width="70%"><?php $js = 'id="periode" style="width:10%; padding:3px"'; echo form_dropdown('periode', $opt_periode, null, $js); ?> <?php echo  form_error('periode'); ?></td>
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_tahun_anggaran/grid_tahun_anggaran"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
			</tr>
		</table>
	</form>
</div>
</div>
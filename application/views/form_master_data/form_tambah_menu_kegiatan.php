<script type="text/javascript">
 function validasiKode(kode){
	 $.ajax({
		 url: '<?php echo base_url()?>index.php/master_data/master_menu_kegiatan/valid/'+kode,
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

<div id="tengah">
<div id="judul" class="title">
	Menu Kegiatan
</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_menu_kegiatan/save_menu_kegiatan'; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Program</td>
				<td width="70%">
					<?php
						$js = 'id="program" onChange="get_kegiatan(this)" style="width:60%; padding:4px"';
						echo form_dropdown('program', $program,Null,$js); 
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Kegiatan</td>
				<td width="70%">
                	<?php
						$js = 'id="kegiatan" onChange="get_ikk(this)" style="width:60%; padding:4px"';
						echo form_dropdown('kegiatan', $kegiatan,Null,$js); 
					?>
                </td>
			</tr>
			<tr>
				<td width="10%">Ikk</td>
				<td width="70%">
                	<?php
						$js = 'id="ikk" style="width:60%; padding:4px"';
						echo form_dropdown('ikk', $ikk,Null,$js); 
					?>
                </td>
			</tr>
            <tr>
				<td width="10%">Kode Menu Kegiatan</td>
				<td width="70%"><input type="text" name="kode_menu_kegiatan" id="kode_menu_kegiatan" style="width:8%; padding:4px" onchange="validasiKode(this.value)"/><?php echo form_error('kode_menu_kegiatan'); ?></td>
			</tr>
			<tr>
				<td width="10%">Menu Kegiatan</td>
				<td width="70%"><input type="text" name="menu_kegiatan" id="menu_kegiatan" style="width:40%; height:30px; padding:4px"/></textarea><?php echo form_error('menu_kegiatan'); ?></td>
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
                        <a href="<?php echo base_url();?>index.php/master_data/master_menu_kegiatan/grid_menu_kegiatan"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>
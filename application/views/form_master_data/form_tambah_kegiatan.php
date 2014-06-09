<script type="text/javascript">
 function validasiKode(kode){
	 $.ajax({
		 url: '<?php echo base_url()?>index.php/master_data/master_kegiatan/valid/'+kode,
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
	Kegiatan
</div>
<div id="content_tengah">
	<form name="form_kegiatan" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_kegiatan/save_kegiatan'; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Kegiatan</td>
				<!--<td width="70%"><input type="text" name="kode" id="kode" style="padding:3px; width:5%" value="<?php echo $kode_kegiatan; ?>" readonly="readonly" /></td>-->
                <td width="70%"><input type="text" name="kdkeg" id="kdkeg" style="padding:3px; width:5%" onchange="validasiKode(this.value)" /></td>
			</tr>
            <tr>
				<td width="10%">Unit Organisasi</td>
				<td width="70%">
				<?php 
				//$js = 'id="unit_organisasi" style="width:67%; padding:3px"'; echo form_dropdown('unit_organisasi', $unit_organisasi, null, $js); 
				$js = 'id="unit_organisasi" onChange="get_program(this)" style="width:49%; padding:3px;"';
				echo form_dropdown('unit_organisasi',$unit_organisasi,null,$js);
				?>
            </td>
			</tr>
			<tr>
				<td width="10%">Program</td>
				<td><select id="program" name="program" class="dyamic3" style="width:49%; padding:3px;"></select><?php echo form_error('program'); ?></td>
			</tr>
			<tr>
				<td width="10%">Fungsi</td>
				<td width="70%">
					<?php
						$js = 'id="fungsi" onChange="get_subfungsi(this)" style="width:49%; padding:3px;"'; 
						echo form_dropdown('fungsi',$fungsi,null,$js); 
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Sub Fungsi</td>
				<td><select id="subfungsi" name="subfungsi" class="dyamic2" style="width:49%; padding:3px;"></select><?php echo form_error('subfungsi'); ?></td>
			</tr>
			<tr>
				<td width="10%">Kegiatan</td>
				<td width="70%"><textarea name="kegiatan" id="kegiatan" cols="60" style="padding:3px;" rows="4"/><?php echo form_error('kegiatan'); ?></textarea></td>
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
                        <a href="<?php echo base_url();?>index.php/master_data/master_kegiatan/grid_kegiatan"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>

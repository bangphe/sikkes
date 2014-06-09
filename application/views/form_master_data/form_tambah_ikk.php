<script type="text/javascript">	 
 function validasiKode(kode){
	 var x = document.getElementById('kegiatan');
	 getVal = x.value;
	 $.ajax({
		 url: '<?php echo base_url()?>index.php/master_data/master_ikk/valid/'+kode,
		 data: 'kdkeg='+getVal,
		 type: 'GET',
		 beforeSend: function()
		 {},
		 success: function(data)
		 {
			 if(data=='FALSE')
			 {
				 document.getElementById('submit').disabled = true;
				 alert('Maaf, kode '+getVal+'.'+kode+' telah terdaftar dalam database.');
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
	IKK
</div>
<div id="content_tengah">
	<form name="form_ikk" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_ikk/save_ikk'; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Kegiatan</td>
				<td width="70%"><?php $js = 'id="kegiatan" style="width:80%; padding:3px;"'; echo form_dropdown('kegiatan', $kegiatan, null, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode IKK</td>
				<td width="70%"><input type="text" id="kdikk" name="kdikk" style="padding:3px" onchange="validasiKode(this.value)" /></td>
			</tr>
			<tr>
				<td width="10%">IKK</td>
				<td width="70%"><textarea name="ikk" id="ikk" style="width:50%; padding:3px;" rows="3"/></textarea><?php echo form_error('ikk'); ?></td>
			</tr>
            <tr>
				<td width="10%">Tahun Anggaran</td>
				<td width="70%">
					<?php
						$js = 'id="thn_anggaran" style="width:10%; padding:3px;"';
						echo form_dropdown('thn_anggaran', $tahun, null, $js);
					?>
				</td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="status" style="width:10%; padding:3px;"'; echo form_dropdown('status',$status,null,$js); ?></td>
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
                        <a href="<?php echo base_url();?>index.php/master_data/master_ikk/grid_ikk"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
			</tr>
		</table>
	</form>
</div>
</div>

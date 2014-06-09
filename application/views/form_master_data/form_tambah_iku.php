<script type="text/javascript">	 
 function validasiKode(kode){
	 var x = document.getElementById('program');
	 getVal = x.value;
	 $.ajax({
		 url: '<?php echo base_url()?>index.php/master_data/master_iku/valid/'+kode,
		 data: 'kdprog='+getVal,
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
	IKU
</div>
<div id="content_tengah">
	<form name="form_iku" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_Iku/save_Iku'; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Program</td>
				<td width="70%"><?php $js = 'id="program" style="width:80%; padding:3px;"'; echo form_dropdown('program', $program, null, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode IKU</td>
				<td width="70%"><input type="text" id="kdiku" name="kdiku" style="padding:3px" onchange="validasiKode(this.value)" /></td>
			</tr>
			<tr>
				<td width="10%">IKU</td>
				<td width="70%"><textarea name="Iku" id="Iku" style="width:59%; padding:3px;" rows="3"/></textarea><?php echo form_error('Iku'); ?>
                </td>
			</tr>
            <tr>
				<td width="10%">Tahun Anggaran</td>
				<td width="70%">
					<?php
						$js = 'id="thn_anggaran" style="width:10%; padding:3px"';
						echo form_dropdown('thn_anggaran', $tahun, null, $js);
					?>
				</td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="status" style="width:10%; padding:3px;"'; echo form_dropdown('status',$opt_status,null,$js); ?></td>
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
                        <a href="<?php echo base_url();?>index.php/master_data/master_iku/grid_iku"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
			</tr>
		</table>
	</form>
</div>
</div>

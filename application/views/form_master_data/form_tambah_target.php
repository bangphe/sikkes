<div id="tengah">
<div id="judul" class="title">
	Master Ikk
</div>
<div id="content_tengah">
	<form name="form_ikk" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_ikk/save_target/'.$kode_ikk; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Ikk</td>
				<td width="70%"><input type="text" name="kode" id="kode"  style="padding:3px; width:5%" value="<?php echo $kode_ikk;?>" readonly="TRUE"></td>
			</tr>
            <tr>
				<td width="10%">Tahun Anggaran</td>
				<td width="70%">
					<?php
						$js = 'id="thn_anggaran" style="width:7%; padding:3px;"';
						echo form_dropdown('thn_anggaran', $tahun, null, $js);
					?>
				</td>
			</tr>
            <tr>
				<td width="10%">Target Ikk</td>
				<td width="70%"><textarea name="target_ikk" id="target_ikk" style="width:50%; padding:3px;" rows="3"/></textarea><?php echo form_error('target_ikk'); ?></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="status" style="width:10%; padding:3px;"'; echo form_dropdown('status',$status,null,$js); ?></td>
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
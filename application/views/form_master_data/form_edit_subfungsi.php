<div id="tengah">
<div id="judul" class="title">
	Sub Fungsi
</div>
<div id="content_tengah">
	<form name="form_sub_fungsi" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_subfungsi/update_subfungsi/'.$KodeFungsi.'/'.$KodeSubFungsi; ?>">


	<table width="80%" height="25%">
            <tr>
				<td width="10%">Kode Fungsi</td>
				<td width="70%"><?php $js = 'id="KodeFungsi" style="width:7%"'; echo form_dropdown('KodeFungsi', $opt_fungsi, $KodeFungsi, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode Sub Fungsi</td>
				<td width="70%"><textarea name="KodeSubFungsi" id="KodeSubFungsi" style="width:30%"/><?php echo $KodeSubFungsi?></textarea><?php echo form_error('kode_sub'); ?></td>
			</tr>
            <tr>
				<td width="10%">Nama Sub Fungsi</td>
				<td width="70%"><textarea name="NamaSubFungsi" id="NamaSubFungsi" style="width:35%" rows="4" /><?php echo $NamaSubFungsi; ?></textarea><?php echo form_error('NamaSubFungsi'); ?></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="KodeStatus" style="width:12%; padding:3px;"'; echo form_dropdown('KodeStatus',$opt_status, $stats, $js); ?></td>
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
                        <a href="<?php echo base_url();?>index.php/master_data/master_subfungsi/grid_daftar"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
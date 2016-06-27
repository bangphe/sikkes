<div id="tengah">
<div id="judul" class="title">Master Tahun Anggaran</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_tahun_anggaran/update_tahun_anggaran/'.$idThnAnggaran; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Tahun Anggaran</td>
				<td width="70%">
					<?php
						$opt;
						for ($i = date('Y')-5; $i <= date('Y')+20; $i++) {
							$opt[$i] = $i;
						}
						$js = 'id="thn_anggaran" style="width:7%; padding:3px;"';
						echo form_dropdown('thn_anggaran', $opt, $selected_year, $js);
					?>
				</td>
			</tr>
            <tr>
				<td width="10%">Periode</td>
				<td width="70%"><?php $js = 'id="periode" style="width:10%; padding:3px"'; echo form_dropdown('periode', $opt_periode, $periode, $js); ?> <?php echo  form_error('periode'); ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save">
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
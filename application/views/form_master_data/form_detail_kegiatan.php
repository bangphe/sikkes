<div id="tengah">
<div id="judul" class="title">
	Kegiatan
</div>
<div id="content_tengah">
	<form name="form_kegiatan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_kegiatan/detail_kegiatan/'.$KodeKegiatan; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Unit Organisasi</td>
				<td width="70%">
				    <?php 
				        $js = 'id="unit_organisasi" onChange="get_program(this)" style="width:35%; padding:3px;" disabled="disabled"';
						echo form_dropdown('unit_organisasi', $unit_organisasi, $selected_unit_organisasi, $js); 
					?>
					</td>
			</tr>
			<tr>
				<td width="10%">Program</td>
				<td>
				   <?php 
				       $js = 'id="program" class="dyamic3" style="width:75%; padding:3px;" disabled="disabled"'; 
						echo form_dropdown('program',$program,$selected_program,$js); 
				   ?>
				</td>
			</tr>
			<?php /*<tr>
				<td width="10%">Fungsi</td>
				<td width="70%">
					<?php
						$js = 'id="fungsi" onChange="get_subfungsi(this)" style="width:35%; padding:3px;" disabled="disabled"'; 
						echo form_dropdown('fungsi',$fungsi,$selected_fungsi,$js); 
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Sub Fungsi <?php echo  $selected_subfungsi; ?></td>
				<td>
					<?php
						$js = 'id="subfungsi" class="dyamic2" style="width:75%; padding:3px;" disabled="disabled"'; 
						echo form_dropdown('subfungsi',$subfungsi,$selected_subfungsi,$js); 
					?>
				</td>
			</tr> */ ?>
			<tr>
				<td width="10%">Kegiatan</td>
				<td width="70%"><textarea name="kegiatan" id="kegiatan" style="padding:3px;" cols="60" rows="4" readonly="TRUE"><?php echo  $kegiatan; ?></textarea></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_kegiatan/grid_kegiatan"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>

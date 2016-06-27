<div id="tengah">
<div id="judul" class="title">Menu Kegiatan</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_menu_kegiatan/detail/'.$KodeMenuKegiatan; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Program</td>
				<td width="70%">
					<?php
						$js = 'id="program" style="padding:3px; width:50%" onChange="get_kegiatan(this)" disabled="disabled"';
						echo form_dropdown('program', $program,$selected_program,$js); 
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Kegiatan</td>
				<td width="70%">
					<?php
						$js = 'id="kegiatan" style="padding:3px; width:50%" onChange="get_ikk(this)" disabled="disabled"'; 
						echo form_dropdown('kegiatan',$kegiatan,$selected_kegiatan,$js); 
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Ikk</td>
				<td width="70%">
					<?php
						$js = 'id="ikk" disabled="disabled" style="padding:3px; width:70%;"'; 
						echo form_dropdown('ikk',$ikk,$selected_ikk,$js); 
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Menu Kegiatan</td>
				<td width="70%"><textarea name="menu_kegiatan" id="menu_kegiatan" style="width:70%; padding:3px" readonly="TRUE" /><?php echo  $menu_kegiatan; ?></textarea></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_menu_kegiatan/grid_menu_kegiatan"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>
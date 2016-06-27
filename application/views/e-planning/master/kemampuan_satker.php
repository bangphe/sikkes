<script language="JavaScript">
function toggle(source) {
  checkboxes1 = document.getElementsByName('program[]');
  for each(var checkbox in checkboxes1)
    checkbox.checked = source.checked;
  checkboxes2 = document.getElementsByName('kegiatan[]');
  for each(var checkbox in checkboxes2)
    checkbox.checked = source.checked;
  checkboxes3 = document.getElementsByName('iku[]');
  for each(var checkbox in checkboxes3)
    checkbox.checked = source.checked;
  checkboxes4 = document.getElementsByName('ikk[]');
  for each(var checkbox in checkboxes4)
    checkbox.checked = source.checked;
}
</script>
<div id="tengah">
<div id="judul" class="title">
	<?php echo  $title; ?>
	<?php /*<label class="edit"><a href="<?php echo  base_url(); ?>index.php/e-planning/master/saveSatker/<?php echo  $kdsatker ?>/1"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label> */?>
</div>
<div id="content_tengah">
	<form class="appnitro" name="form_edit_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/master/save_satker/'.$kdsatker; ?>">
	<p><input type="checkbox" name="toggleall" onclick="toggle(this)"/>Pilih semua</p>
		<div>
			<ul>
				<?php foreach($program->result() as $row){?>
                <li><input style="width:50px" type="checkbox" name="program[]" value="<?php echo  $row->KodeProgram; ?>" <?php if($this->masmo->cek('ref_satker_program', $kdsatker, 'kdsatker', $row->KodeProgram, 'KodeProgram')) echo "checked=\"true\""; ?>><span><?php echo  '['.$row->KodeProgram.'] '.$row->NamaProgram; ?></span>
                    <ul>
						<li><strong>IKU</strong></li>
						<?php foreach($this->masmo->get_where('ref_iku','KodeProgram',$row->KodeProgram)->result() as $row){?>
							<li><input style="width:50px" type="checkbox" name="iku[]" value="<?php echo  $row->KodeIku; ?>" <?php if($this->masmo->cek('ref_satker_iku', $kdsatker, 'kdsatker', $row->KodeIku, 'KodeIku')) echo "checked=\"true\""; ?>><span><?php echo  '['.$row->KodeIku.'] '.$row->Iku; ?></span>
                        <?php } ?>
						<li><strong>Kegiatan</strong></li>
						<?php foreach($this->masmo->get_where('ref_kegiatan','KodeProgram',$row->KodeProgram)->result() as $row){?>
                        <li><input style="width:50px" type="checkbox" name="kegiatan[]" value="<?php echo  $row->KodeKegiatan; ?>" <?php if($this->masmo->cek('ref_satker_kegiatan', $kdsatker, 'kdsatker', $row->KodeKegiatan, 'KodeKegiatan')) echo "checked=\"true\""; ?>><span><?php echo  '['.$row->KodeKegiatan.'] '.$row->NamaKegiatan; ?></span>
                            <ul>
								<?php foreach($this->masmo->get_where('ref_ikk','KodeKegiatan',$row->KodeKegiatan)->result() as $row){?>
									<li><input style="width:50px" type="checkbox" name="ikk[]" value="<?php echo  $row->KodeIkk; ?>" <?php if($this->masmo->cek('ref_satker_ikk', $kdsatker, 'kdsatker', $row->KodeIkk, 'KodeIkk')) echo "checked=\"true\""; ?>><span><?php echo  '['.$row->KodeIkk.'] '.$row->Ikk; ?></span>
								<?php } ?>
                            </ul>
                        <?php } ?>
                    </ul>
				<?php } ?>
            </ul>
		</div>
		</p>
		<table width="100%" height="auto" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<div class="buttons">
					<button type="submit" class="positive" name="save">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
				</div>
			</td>
		</tr>
        </table>
	</form>
</div>
</div>
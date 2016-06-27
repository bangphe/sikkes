<div id="kiri">
<div id="judul" class="title">
	Tambah Program
</div>
<div id="content">
		<form id="form_cari_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/pendaftaran/cari_program/'.$KodePengajuan; ?>">
			<b>search </b>
			<input type="hidden" id="kodeFungsi" name="KodeFungsi" value="<?php echo  $KodeFungsi; ?>" />
			<input type="hidden" id="kodeSubFungsi" name="KodeSubFungsi" value="<?php echo  $KodeSubFungsi; ?>" />
			<input id="keyword" name="keyword" /> 
			<select name="kategori" id="kategori">
				<option value="KodeProgram">Kode Program</option>
				<option value="NamaProgram">Nama Program</option>
			</select>
			<input type="submit" value="search" />
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode program</p></td>
				<td><p>Nama Program</p></td>
				<!--<td><p>Biaya</p></td>-->
				<td><p>Action</p></td>
			</tr>
			<?php
			if($program!=NULL){
				$no=1;
				foreach($program->result() as $row){
					$kode = $row->KodeProgram;
					$nama = $row->NamaProgram; 
				?>
				<tr onmouseover="this.style.backgroundColor='#ffff00';" onmouseout="this.style.backgroundColor='#ffffff';" onclick="window.opener.document.getElementById('detail1').value=<?php echo  $kode; ?>; window.opener.document.getElementById('detail2').value='<?php echo  $nama; ?>'; window.close();">
					<form id="form_tambah_Program" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/pendaftaran/save_program/'.$KodePengajuan; ?>">
					<input type="hidden" id="kodeFungsi" name="KodeFungsi" value="<?php echo  $KodeFungsi; ?>" />
					<input type="hidden" id="kodeSubFungsi" name="KodeSubFungsi" value="<?php echo  $KodeSubFungsi; ?>" />
					<td><?php echo  $no; ?></td>
					<td><?php echo  $kode; ?><input type="hidden" id="kode" name="kode" value="<?php echo  $kode; ?>" /></td>
					<td><?php echo  $nama; ?><input type="hidden" id="nama" name="nama" value="<?php echo  $nama; ?>" /></td>
					<!--<td><input id="biaya" name="biaya" value="" /></td>-->
					<td><input type="submit" value="Tambah" /></td>
					</form>
				</tr>
				<?php 
					$no++;	
				}
			} 
			?>
		</table>
	</div>
</div>
<?php if(form_error('biaya')!=''){ ?>
	<script type="text/javascript">
		alert("<?php echo  form_error('biaya'); ?>");
	</script>
<?php } ?>
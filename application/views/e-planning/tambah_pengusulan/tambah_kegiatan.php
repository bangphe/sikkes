<div id="kiri">
<div id="judul" class="title">
	Tambah Kegiatan
</div>
<div id="content">
		<form id="form_cari_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/cari_kegiatan/'.$KodePengajuan; ?>">
			<b>search </b>
			<input type="hidden" id="KodeFungsi" name="KodeFungsi" value="<?php echo $KodeFungsi; ?>" />
			<input type="hidden" id="KodeSubFungsi" name="KodeSubFungsi" value="<?php echo $KodeSubFungsi; ?>" />
			<input type="hidden" id="KodeProgram" name="KodeProgram" value="<?php echo $KodeProgram; ?>" />
			<input id="keyword" name="keyword" /> 
			<select name="kategori" id="kategori">
				<option value="KodeKegiatan">Kode Kegiatan</option>
				<option value="NamaKegiatan">Nama Kegiatan</option>
			</select>
			<input type="submit" value="search" />
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode Kegiatan</p></td>
				<td><p>Nama Kegiatan</p></td>
				<!--<td><p>Biaya</p></td>-->
				<td><p>Action</p></td>
			</tr>
			<?php
			if($kegiatan!=NULL){
				$no=1;
				foreach($kegiatan->result() as $row){
					$kode = $row->KodeKegiatan;
					$nama = $row->NamaKegiatan; 
				?>
				<tr onmouseover="this.style.backgroundColor='#ffff00';" onmouseout="this.style.backgroundColor='#ffffff';" onclick="window.opener.document.getElementById('detail1').value=<?php echo $kode; ?>; window.opener.document.getElementById('detail2').value='<?php echo $nama; ?>'; window.close();">
					<form id="form_tambah_Program" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/save_kegiatan/'.$KodePengajuan; ?>">
					<input type="hidden" id="KodeFungsi" name="KodeFungsi" value="<?php echo $KodeFungsi; ?>" />
					<input type="hidden" id="KodeSubFungsi" name="KodeSubFungsi" value="<?php echo $KodeSubFungsi; ?>" />
					<input type="hidden" id="KodeProgram" name="KodeProgram" value="<?php echo $KodeProgram; ?>" />
					<td><?php echo $no; ?></td>
					<td><?php echo $kode; ?><input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>" /></td>
					<td><?php echo $nama; ?><input type="hidden" id="nama" name="nama" value="<?php echo $nama; ?>" /></td>
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
		alert("<?php echo form_error('biaya'); ?>");
	</script>
<?php } ?>
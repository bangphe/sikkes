<div id="kiri">
<div id="judul" class="title">
	Tambah Menu Kegiatan
</div>
<div id="content">
		<form id="form_cari_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/cari_menu_kegiatan'; ?>">
			<p>search </p>
			<input type="hidden" id="KodeFungsi" name="KodeFungsi" value="<?php echo $KodeFungsi; ?>" />
			<input type="hidden" id="KodeSubFungsi" name="KodeSubFungsi" value="<?php echo $KodeSubFungsi; ?>" />
			<input type="hidden" id="KodePengajuan" name="KodePengajuan" value="<?php echo $KodePengajuan; ?>" />
			<input type="hidden" id="KodeProgram" name="KodeProgram" value="<?php echo $KodeProgram; ?>" />
			<input type="hidden" id="KodeKegiatan" name="KodeKegiatan" value="<?php echo $KodeKegiatan; ?>" />
			<input type="hidden" id="KodeIkk" name="KodeIkk" value="<?php echo $KodeIkk; ?>" />
			<input id="keyword" name="keyword" /> 
			<select name="kategori" id="kategori">
				<option value="KodeMenuKegiatan">Kode Menu Kegiatan</option>
				<option value="MenuKegiatan">Nama Menu Kegiatan</option>
			</select>
			<input type="submit" value="search" />
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode Menu Kegiatan</p></td>
				<td><p>Nama Menu Kegiatan</p></td>
				<td><p>Action</p></td>
			</tr>
			<?php
			$no=1;
			foreach($menu_kegiatan->result() as $row){
				$kode = $row->KodeMenuKegiatan;
				$nama = $row->MenuKegiatan; 
			?>
			<tr onmouseover="this.style.backgroundColor='#ffff00';" onmouseout="this.style.backgroundColor='#ffffff';" onclick="window.opener.document.getElementById('detail1').value=<?php echo $kode; ?>; window.opener.document.getElementById('detail2').value='<?php echo $nama; ?>'; window.close();">
				<form id="form_tambah_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/save_menu_kegiatan'; ?>">
				<input type="hidden" id="KodeFungsi" name="KodeFungsi" value="<?php echo $KodeFungsi; ?>" />
				<input type="hidden" id="KodeSubFungsi" name="KodeSubFungsi" value="<?php echo $KodeSubFungsi; ?>" />
				<input type="hidden" id="KodePengajuan" name="KodePengajuan" value="<?php echo $KodePengajuan; ?>" />
				<input type="hidden" id="KodeProgram" name="KodeProgram" value="<?php echo $KodeProgram; ?>" />
				<input type="hidden" id="KodeKegiatan" name="KodeKegiatan" value="<?php echo $KodeKegiatan; ?>" />
				<input type="hidden" id="KodeIkk" name="KodeIkk" value="<?php echo $KodeIkk; ?>" />
				<td><?php echo $no; ?></td>
				<td><?php echo $kode; ?><input type="hidden" id="kode" name="kode" value="<?php echo $kode; ?>" /></td>
				<td><?php echo $nama; ?><input type="hidden" id="nama" name="nama" value="<?php echo $nama; ?>" /></td>
				<td><input type="submit" value="Tambah" /></td>
				</form>
			</tr>
			<?php 
				$no++;	
			} 
			?>
		</table>
	</div>
</div>
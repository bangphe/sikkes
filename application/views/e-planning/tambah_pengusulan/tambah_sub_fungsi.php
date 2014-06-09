<div id="kiri">
<div id="judul" class="title">
	Tambah Sub Fungsi
</div>
<div id="content">
		<form id="form_cari_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/cari_sub_fungsi/'.$KodePengajuan; ?>">
			<b>Search </b>
			<input type="hidden" id="kodeFungsi" name="kodeFungsi" value="<?php echo $KodeFungsi; ?>" />
			<input id="keyword" name="keyword" /> 
			<select name="kategori" id="kategori">
				<option value="KodeSubFungsi">Kode Sub Fungsi</option>
				<option value="NamaSubFungsi">Nama Sub Fungsi</option>
			</select>
			<input type="submit" value="search" />
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode Sub Fungsi</p></td>
				<td><p>Nama Sub Fungsi</p></td>
				<td><p>Action</p></td>
			</tr>
			<?php
			$no=1;
			foreach($sub_fungsi->result() as $row){
				$kode = $row->KodeSubFungsi;
				$nama = $row->NamaSubFungsi; 
			?>
			<tr onmouseover="this.style.backgroundColor='#ffff00';" onmouseout="this.style.backgroundColor='#ffffff';" onclick="window.opener.document.getElementById('detail1').value=<?php echo $kode; ?>; window.opener.document.getElementById('detail2').value='<?php echo $nama; ?>'; window.close();">
				<form id="form_tambah_sub_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/save_sub_fungsi/'.$KodePengajuan; ?>">
				<input type="hidden" id="kodeFungsi" name="kodeFungsi" value="<?php echo $KodeFungsi; ?>" />
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
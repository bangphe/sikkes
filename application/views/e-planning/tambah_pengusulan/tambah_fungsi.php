<div id="kiri">
<div id="judul" class="title">
	Tambah Fungsi
</div>
<div id="content">
		<form id="form_cari_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/cari_fungsi/'.$KodePengajuan; ?>">
			<p>search </p>
			<input id="keyword" name="keyword" /> 
			<select name="kategori" id="kategori">
				<option value="KodeFungsi">Kode Fungsi</option>
				<option value="NamaFungsi">Nama Fungsi</option>
			</select>
			<input type="submit" value="search" />
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode Fungsi</p></td>
				<td><p>Nama Fungsi</p></td>
				<td><p>Action</p></td>
			</tr>
			<?php
			$no=1;
			foreach($fungsi->result() as $row){
				$kode = $row->KodeFungsi;
				$nama = $row->NamaFungsi; 
			?>
			<tr onmouseover="this.style.backgroundColor='#ffff00';" onmouseout="this.style.backgroundColor='#ffffff';" onclick="window.opener.document.getElementById('detail1').value=<?php echo $kode; ?>; window.opener.document.getElementById('detail2').value='<?php echo $nama; ?>'; window.close();">
				<form id="form_tambah_fungsi" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/save_fungsi/'.$KodePengajuan; ?>">
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
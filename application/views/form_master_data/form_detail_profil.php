<div id="tengah">
<div id="judul" class="title">Profil User</div>
<div id="content_tengah">
	<form class="appnitro" name="form_detail_user" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_user/update/'.$user; ?>" onsubmit="return validate_form()">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr><td>
		<fieldset style="border-color:#000000; width:835px">
		<legend class="legend" >| Informasi User |</legend>
		<table><tr>
		<td width="15%">Peran</td><td>:</td>
		<td width="85%"><?php echo $this->gm->get_where('role_login', 'KD_ROLE', $role)->row()->ROLE; ?></td>
		</tr>
		<tr>
		<td>Jenis Kewenangan</td><td>:</td>
		<td><?php echo $this->gm->get_where('ref_jenis_satker', 'KodeJenisSatker', $jenis_kewenangan)->row()->JenisSatker; ?></td>
		</tr>
		<tr>
		<td>Satuan Kerja</td><td>:</td>
		<td><?php echo $this->gm->get_where('ref_satker', 'kdsatker', $satker)->row()->nmsatker; ?></td>
		</tr>
		<tr>
		<td>Provinsi</td><td>:</td>
		<td><?php echo $this->gm->get_where('ref_provinsi', 'KodeProvinsi', $provinsi)->row()->NamaProvinsi; ?></td>
		</tr>
		<tr>
		<td>Kabupaten / Kota</td><td>:</td>
		<td><?php echo $this->gm->get_double_where('ref_kabupaten', 'KodeProvinsi', $provinsi, 'KodeKabupaten', $kabupaten)->row()->NamaKabupaten; ?></td>
		</tr>
		<tr><td colspan="3"><a href="<?php echo site_url(); ?>/master_data/master_user/change_password" class="positive" title="Ubah Kata Sandi">Ubah Kata Sandi</a></td>
		</tr>
		</table>
		</fieldset>
		</td></tr>
	</table>
	<table>
		<tr><td>
		<fieldset style="border-color:#000000; width:835px">
		<legend class="legend" >| Profil User | <a href="<?php echo site_url(); ?>/master_data/master_user/edit_profil" class="positive"><img src="<?php echo base_url(); ?>images/icons/Edit_icon(16x16).png" alt="" title="Edit Profil"/></a></legend>
		<table><tr>
		<td width="15%">Username</td><td>:</td>
		<td width="85%"><?php echo $username; ?></td>
		</tr><tr>
		<td width="15%">Nama</td><td>:</td>
		<td width="85%"><?php echo $nama; ?></td>
		</tr>
		<tr>
		<td>Email</td><td>:</td>
		<td><?php echo $email; ?></td>
		</tr>
		<tr>
		<td>Telepon</td><td>:</td>
		<td><?php echo $telp; ?></td>
		</tr>
		<tr>
		<td>Alamat</td><td>:</td>
		<td><?php echo $alamat; ?></td>
		</tr>
		<?php if($this->session->userdata('kodejenissatker') == '3'){?>
		<tr>
		<td>Jabatan</td><td>:</td>
		<td><?php echo $nmjabatan; ?></td>
		</tr>
		<?php } ?>
		</table>
		</fieldset>
		</td></tr>
	</table>
	</form>
</div>
</div>
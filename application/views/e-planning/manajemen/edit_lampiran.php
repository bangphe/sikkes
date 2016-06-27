<link rel="stylesheet" type="text/css" href="<?php echo  base_url();?>css/feedback.css">
<style type="text/css">
table.myTable { width:100%; border-collapse:collapse;  }
table.myTable .tes { 
	background-color: #dfe4ea; color:#000; text-align:center;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 12px; font-weight:bold;}
table.myTable td { padding:8px; border:#999 1px solid; }

table.myTable tr:nth-child(even) { /*(even) or (2n+0)*/
	background: #fff;
}
table.myTable tr:nth-child(odd) { /*(odd) or (2n+1)*/
	background-color: #f2f5f9;
}
.alert-danger {
    background-color: #f2dede;
    border-color: #ebccd1;
    color: #a94442}
.alert {
    padding: 15px;
    margin-bottom: 10px;
    border: 1px solid transparent;
    border-radius: 4px}
.alert h4 {
    margin-top: 0;
    color: inherit;
	font-size: 16px;}
.text-center {
    text-align: center}
</style>

<div id="tengah">
    <div id="judul" class="title">
        Data Lampiran File
    </div>
    <div id="content_tengah">
		<table class="tableBase">
			<tr>
				<td>
					<table class="tableInfo">
						<tr>
							<td class="tdInfo">Sumber Dana</td>
							<td>
								<?php
								foreach ($this->mm->get_where('ref_rencana_anggaran', 'id_rencana_anggaran', $selected_rencana_anggaran)->result() as $row)
									echo $row->rencana_anggaran;
								?>
							</td>
						</tr>
						<tr>
							<td class="tdInfo">Nama Satker</td> 
							<td>
								<?php
								foreach ($this->mm->get_where('ref_satker', 'kdsatker', $kdsatker)->result() as $row)
									echo $row->nmsatker;
								?>
							</td>
						</tr>
						<tr>
							<td class="tdInfo">Propinsi</td>
							<td><?php echo  $provinsi; ?></td>
						</tr>
						<tr>
							<td class="tdInfo">Jenis Satker</td>
							<td>
								<?php
								foreach ($this->mm->get_where('ref_jenis_satker', 'KodeJenisSatker', $KodeJenisSatker)->result() as $row)
									echo $row->JenisSatker;
								?>
							</td>
						</tr>
						<tr>
							<td class="tdInfo">Judul Proposal</td>
							<td>
								<?php echo  $judul; ?>
							</td>
						</tr>
					</table>
					<table class="tableInfo">
						<tr>
							<td class="tdInfo">No. Surat Pengantar</td>
							<td>
								<?php echo  $nomor; ?>
							</td>
						</tr>
						<tr>
							<td class="tdInfo">Tanggal Surat</td>
							<td><p><?php echo  $tanggal_pembuatan; ?></p></td>
						</tr>
						<tr>
							<td class="tdInfo">Perihal Surat</td>
							<td><?php echo  $perihal; ?></td>
						</tr>
						<tr>
							<td class="tdInfo">Th. Anggaran</td>
							<td><?php echo  $thn_anggaran; ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
    </div>
    <div>
		<?php echo  anchor(site_url('e-planning/manajemen/grid_pengajuan'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Pengajuan'); ?>
	</div>
	<div class="clear"></div>
	<div class="garis"></div>
</div>

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Periode Pagu Indikatif</a></li>
    <li><a href="#tabs-2">Periode Anggaran</a></li>
    <li><a href="#tabs-3">Periode Pagu Definitif</a></li>
  </ul>
  <div id="tabs-1">
  <?php if ($cek_periode_satu) {?>
  <form class="appnitro" name="form_edit_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/manajemen/update_lampiran_periode_satu/'.$kd_pengajuan; ?>">
  	<table width="100%" height="100%">
		<?php if ($this->session->userdata('kd_role') == Role_model::DIREKTORAT) { ?>
		<tr>
			<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
			<td><input id="file1" disabled="disabled" name="file1" class="element file" type="file"/> <?php if($proposal != '-'){ echo'<a href="'.base_url().'file/'.$proposal.'">'.$proposal.'</a>'; } ?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">TOR</td>
			<td><input id="file2" disabled="disabled" name="file2" class="element file" type="file"/> <?php if($tor != '-'){ echo'<a href="'.base_url().'file/'.$tor.'">'.$tor.'</a>'; } ?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Data Pendukung Lainnya</td>
			<td><input id="file3" disabled="disabled" name="file3" class="element file" type="file"/> <?php if($data_pendukung_lainnya != '-'){ echo'<a href="'.base_url().'file/'.$data_pendukung_lainnya.'">'.$data_pendukung_lainnya.'</a>'; } ?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<?php } elseif ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN) { ?>
		<tr>
			<td><table class="myTable">
				<tr>
					<td class="tes"></td>
					<td class="tes">Lampiran</td>
					<td class="tes">Download</td>
					<td class="tes">Hapus</td>
				</tr>	
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
					<td style="vertical-align:top;">
						<input id="file1" name="file1" class="element file" type="file"/>
						<p style="color:red">File maksimum 10MB</p>
					</td>
					<td style="vertical-align:top;">
						<?php if($proposal != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$proposal; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($proposal != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_proposal/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
								<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
								Hapus
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">TOR</td>
					<td style="vertical-align:top;">
						<input id="file2" name="file2" class="element file" type="file"/>
						<p style="color:red">File maksimum 10MB</p>
					</td>
					<td style="vertical-align:top;">
						<?php if($tor != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$tor; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($tor != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_tor/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
								<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
								Hapus
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Data Pendukung</td>
					<td style="vertical-align:top;">
						<input id="file3" name="file3" class="element file" type="file"/>
						<p style="color:red">File maksimum 10MB</p>
					</td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$data_pendukung_lainnya; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_pendukung/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
								<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
								Hapus
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				</table>
				<table>
				<tr>
					<td></td>
					<td>
						<div class="buttons">
							<button type="submit" class="regular" name="save" id="save">
								<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
								Koreksi
							</button>
						</div>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php } else {?>
			<tr>
			<td><table class="myTable">
				<tr>
					<td class="tes"></td>
					<td class="tes">Lampiran</td>
					<td class="tes">Download</td>
				</tr>	
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
					<td style="vertical-align:top;"><input id="file1" name="file1" class="element file" type="file"/></td>
					<td style="vertical-align:top;">
						<?php if($proposal != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$proposal; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">TOR</td>
					<td style="vertical-align:top;"><input id="file2" name="file2" class="element file" type="file"/></td>
					<td style="vertical-align:top;">
						<?php if($tor != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$tor; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Data Pendukung</td>
					<td style="vertical-align:top;"><input id="file3" name="file3" class="element file" type="file"/></td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$data_pendukung_lainnya; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php } ?>
	</table>
   </form>
  <?php } else { ?>
  	<div class="alert alert-danger text-center">
		<h4>MAAF</h4>
		<p style="font-size:13px;">Pagu Indikatif (01 Januari 2015 - 31 Maret 2015) sudah ditutup.</p>
	</div>
	<table width="100%" height="100%">
		<?php if ($this->session->userdata('kd_role') == Role_model::DIREKTORAT) { ?>
		<tr>
			<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
			<td><input id="file1" disabled="disabled" name="file1" class="element file" type="file"/> <?php if($proposal != '-'){ echo'<a href="'.base_url().'file/'.$proposal.'">'.$proposal.'</a>'; } ?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">TOR</td>
			<td><input id="file2" disabled="disabled" name="file2" class="element file" type="file"/> <?php if($tor != '-'){ echo'<a href="'.base_url().'file/'.$tor.'">'.$tor.'</a>'; } ?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Data Pendukung Lainnya</td>
			<td><input id="file3" disabled="disabled" name="file3" class="element file" type="file"/> <?php if($data_pendukung_lainnya != '-'){ echo'<a href="'.base_url().'file/'.$data_pendukung_lainnya.'">'.$data_pendukung_lainnya.'</a>'; } ?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<?php } elseif ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN) { ?>
		<tr>
			<td><table class="myTable">
				<tr>
					<td class="tes"></td>
					<td class="tes">Download</td>
					<td class="tes">Nama File</td>
				</tr>	
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
					<td style="vertical-align:top;">
						<?php if($proposal != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$proposal; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($proposal != '-') { ?>
						<?php echo  $proposal; ?>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">TOR</td>
					<td style="vertical-align:top;">
						<?php if($tor != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$tor; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($tor != '-') { ?>
						<?php echo  $tor; ?>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Data Pendukung</td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$data_pendukung_lainnya; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya != '-') { ?>
						<?php echo  $data_pendukung_lainnya;?>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php } else {?>
			<tr>
			<td><table class="myTable">
				<tr>
					<td class="tes"></td>
					<td class="tes">Download</td>
					<td class="tes">Nama File</td>
				</tr>	
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
					<td style="vertical-align:top;">
						<?php if($proposal != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$proposal; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($proposal != '-') { ?>
						<?php echo  $proposal; ?>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">TOR</td>
					<td style="vertical-align:top;">
						<?php if($tor != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$tor; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($tor != '-') { ?>
						<?php echo  $tor; ?>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Data Pendukung</td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$data_pendukung_lainnya; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya != '-') { ?>
						<?php echo  $data_pendukung_lainnya; ?>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php } ?>
	</table>
  <?php } ?>
  </div>
  <div id="tabs-2">
  	<?php if ($cek_periode_dua) { ?>
  	<div class="alert alert-danger text-center">
		<h4>PENGUMUMAN</h4>
		<p style="font-size:13px;">Periode Anggaran (01 Mei 2015 - 30 Juni 2015).</p>
	</div>
	  <form class="appnitro" name="form_edit_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/manajemen/update_lampiran_periode_dua/'.$kd_pengajuan; ?>">
	  	<table width="100%" height="100%">
			<?php if ($this->session->userdata('kd_role') == Role_model::DIREKTORAT) { ?>
			<tr>
				<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
				<td><input id="file1" disabled="disabled" name="file1" class="element file" type="file"/> <?php if($proposal_2 != '-'){ echo'<a href="'.base_url().'file/'.$proposal_2.'">'.$proposal_2.'</a>'; } ?></td>
			</tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;">TOR</td>
				<td><input id="file2" disabled="disabled" name="file2" class="element file" type="file"/> <?php if($tor_2 != '-'){ echo'<a href="'.base_url().'file/'.$tor_2.'">'.$tor_2.'</a>'; } ?></td>
			</tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;">Data Pendukung Lainnya</td>
				<td><input id="file3" disabled="disabled" name="file3" class="element file" type="file"/> <?php if($data_pendukung_lainnya_2 != '-'){ echo'<a href="'.base_url().'file/'.$data_pendukung_lainnya_2.'">'.$data_pendukung_lainnya_2.'</a>'; } ?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<?php } elseif ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN) { ?>
			<tr>
				<td><table class="myTable">
					<tr>
						<td class="tes"></td>
						<td class="tes">Lampiran</td>
						<td class="tes">Download</td>
						<td class="tes">Hapus</td>
					</tr>	
					<tr>
						<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
						<td style="vertical-align:top;">
							<input id="file1" name="file1" class="element file" type="file"/>
							<p style="color:red">File maksimum 10MB</p>
						</td>
						<td style="vertical-align:top;">
							<?php if($proposal_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  base_url().'file/'.$proposal_2; ?>" class="negative">
									<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
									Download
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
						<td style="vertical-align:top;">
							<?php if($proposal_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_proposal/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
									<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
									Hapus
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td width="15%" style="padding-left:10px;vertical-align:top;">TOR</td>
						<td style="vertical-align:top;">
							<input id="file2" name="file2" class="element file" type="file"/>
							<p style="color:red">File maksimum 10MB</p>
						</td>
						<td style="vertical-align:top;">
							<?php if($tor_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  base_url().'file/'.$tor_2; ?>" class="negative">
									<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
									Download
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
						<td style="vertical-align:top;">
							<?php if($tor_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_tor/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
									<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
									Hapus
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td width="15%" style="padding-left:10px;vertical-align:top;">Data Pendukung</td>
						<td style="vertical-align:top;">
							<input id="file3" name="file3" class="element file" type="file"/>
							<p style="color:red">File maksimum 10MB</p>
						</td>
						<td style="vertical-align:top;">
							<?php if($data_pendukung_lainnya_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  base_url().'file/'.$data_pendukung_lainnya_2; ?>" class="negative">
									<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
									Download
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
						<td style="vertical-align:top;">
							<?php if($data_pendukung_lainnya_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_pendukung/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
									<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
									Hapus
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
					</tr>
					</table>
					<table>
					<tr>
						<td></td>
						<td>
							<div class="buttons">
								<button type="submit" class="regular" name="save" id="save">
									<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
									Koreksi
								</button>
							</div>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<?php } else {?>
				<tr>
				<td><table class="myTable">
					<tr>
						<td class="tes"></td>
						<td class="tes">Lampiran</td>
						<td class="tes">Download</td>
					</tr>	
					<tr>
						<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
						<td style="vertical-align:top;"><input id="file1" name="file1" class="element file" type="file"/></td>
						<td style="vertical-align:top;">
							<?php if($proposal_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  base_url().'file/'.$proposal_2; ?>" class="negative">
									<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
									Download
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td width="15%" style="padding-left:10px;vertical-align:top;">TOR</td>
						<td style="vertical-align:top;"><input id="file2" name="file2" class="element file" type="file"/></td>
						<td style="vertical-align:top;">
							<?php if($tor_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  base_url().'file/'.$tor_2; ?>" class="negative">
									<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
									Download
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td width="15%" style="padding-left:10px;vertical-align:top;">Data Pendukung</td>
						<td style="vertical-align:top;"><input id="file3" name="file3" class="element file" type="file"/></td>
						<td style="vertical-align:top;">
							<?php if($data_pendukung_lainnya_2 != '-') { ?>
							<div class="buttons">
							    <a href="<?php echo  base_url().'file/'.$data_pendukung_lainnya_2; ?>" class="negative">
									<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
									Download
								</a>
							</div>
							<?php } else { ?>
							Tidak ada lampiran file
							<?php } ?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<?php } ?>
		</table>
	  </form>
  	<?php } else { ?>
  	<div class="alert alert-danger text-center">
		<h4>MAAF</h4>
		<p style="font-size:13px;">Periode Anggaran (01 Mei 2015 - 30 Juni 2015) belum dibuka.</p>
	</div>
  	<?php } ?>
  </div>
  <div id="tabs-3">
    <?php if ($cek_periode_tiga) { ?>
    <form class="appnitro" name="form_edit_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/manajemen/update_lampiran_periode_tiga/'.$kd_pengajuan; ?>">
  	<table width="100%" height="100%">
		<?php if ($this->session->userdata('kd_role') == Role_model::DIREKTORAT) { ?>
		<tr>
			<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
			<td><input id="file1" disabled="disabled" name="file1" class="element file" type="file"/> <?php if($proposal_3 != '-'){ echo'<a href="'.base_url().'file/'.$proposal_3.'">'.$proposal_3.'</a>'; } ?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">TOR</td>
			<td><input id="file2" disabled="disabled" name="file2" class="element file" type="file"/> <?php if($tor_3 != '-'){ echo'<a href="'.base_url().'file/'.$tor_3.'">'.$tor_3.'</a>'; } ?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Data Pendukung Lainnya</td>
			<td><input id="file3" disabled="disabled" name="file3" class="element file" type="file"/> <?php if($data_pendukung_lainnya_3 != '-'){ echo'<a href="'.base_url().'file/'.$data_pendukung_lainnya_3.'">'.$data_pendukung_lainnya_3.'</a>'; } ?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<?php } elseif ($this->session->userdata('kd_role') == Role_model::PENGUSUL || $this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING || $this->session->userdata('kd_role') == Role_model::ADMIN) { ?>
		<tr>
			<td><table class="myTable">
				<tr>
					<td class="tes"></td>
					<td class="tes">Lampiran</td>
					<td class="tes">Download</td>
					<td class="tes">Hapus</td>
				</tr>	
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
					<td style="vertical-align:top;">
						<input id="file1" name="file1" class="element file" type="file"/>
						<p style="color:red">File maksimum 10MB</p>
					</td>
					<td style="vertical-align:top;">
						<?php if($proposal_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$proposal_3; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($proposal_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_proposal/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
								<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
								Hapus
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">TOR</td>
					<td style="vertical-align:top;">
						<input id="file2" name="file2" class="element file" type="file"/>
						<p style="color:red">File maksimum 10MB</p>
					</td>
					<td style="vertical-align:top;">
						<?php if($tor_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$tor_3; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($tor_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_tor/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
								<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
								Hapus
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Data Pendukung</td>
					<td style="vertical-align:top;">
						<input id="file3" name="file3" class="element file" type="file"/>
						<p style="color:red">File maksimum 10MB</p>
					</td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$data_pendukung_lainnya_3; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  site_url().'/e-planning/manajemen/delete_file_pendukung/'.$kd_pengajuan; ?>" class="negative" onclick="return confirm('Apakah anda yakin ingin menghapus file?')">
								<img src="<?php echo  base_url(); ?>images/flexigrid/tolak.png" alt=""/>
								Hapus
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				</table>
				<table>
				<tr>
					<td></td>
					<td>
						<div class="buttons">
							<button type="submit" class="regular" name="save" id="save">
								<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
								Koreksi
							</button>
						</div>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php } else {?>
			<tr>
			<td><table class="myTable">
				<tr>
					<td class="tes"></td>
					<td class="tes">Lampiran</td>
					<td class="tes">Download</td>
				</tr>	
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
					<td style="vertical-align:top;"><input id="file1" name="file1" class="element file" type="file"/></td>
					<td style="vertical-align:top;">
						<?php if($proposal_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$proposal_3; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">TOR</td>
					<td style="vertical-align:top;"><input id="file2" name="file2" class="element file" type="file"/></td>
					<td style="vertical-align:top;">
						<?php if($tor_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$tor_3; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="15%" style="padding-left:10px;vertical-align:top;">Data Pendukung</td>
					<td style="vertical-align:top;"><input id="file3" name="file3" class="element file" type="file"/></td>
					<td style="vertical-align:top;">
						<?php if($data_pendukung_lainnya_3 != '-') { ?>
						<div class="buttons">
						    <a href="<?php echo  base_url().'file/'.$data_pendukung_lainnya_3; ?>" class="negative">
								<img src="<?php echo  base_url(); ?>images/icon/download2.png" alt=""/>
								Download
							</a>
						</div>
						<?php } else { ?>
						Tidak ada lampiran file
						<?php } ?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php } ?>
	</table>
  </form>
  	<?php } else { ?>
  	<div class="alert alert-danger text-center">
		<h4>MAAF</h4>
		<p style="font-size:13px;">Periode Pagu Definitif (01 Juli 2015 - 31 Desember 2015) belum dibuka.</p>
	</div>
  	<?php } ?>
  </div>
</div>

<script type="text/javascript">
$(function() {
    $( "#tabs" ).tabs();
  });
</script>
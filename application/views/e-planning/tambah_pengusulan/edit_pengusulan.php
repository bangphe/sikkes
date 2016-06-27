<style type="text/css">
	table.myTable { width:65%; border-collapse:collapse;  }
	table.myTable .tes { 
		background-color: #dfe4ea; color:#000;
		font-family: Arial,Helvetica,sans-serif;
		font-size: 12px; font-weight:bold;}
	table.myTable td { padding:10px 15px 10px 15px;}

	table.myTable tr:nth-child(even) { /*(even) or (2n+0)*/
		background: #fff;
	}
	table.myTable tr:nth-child(odd) { /*(odd) or (2n+1)*/
		background-color: #f2f5f9;
	}
</style>

<div id="tengah">
<div id="judul" class="title">
	Update Proposal
	<!--label class="edit"><a href="<?php //echo base_url(); ?>index.php/e-planning/manajemen/detail_pengajuan/<?php //echo $kd_pengajuan ?>/1"><img src="<?php //echo base_url(); ?>images/icons/detail.png" /></a></label-->
</div>
<div id="content_tengah">
	<form class="appnitro" name="form_edit_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/manajemen/update_pengajuan/'.$kd_pengajuan; ?>" onsubmit="return validateForm()" >
	<?php if($error_file != ''){ 
		echo $error_file;
	} ?>
	<h3>Sumber Dana</h3>
	<table width="100%" height="auto" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%" style="padding-left:10px;vertical-align:top;">Sumber Dana</td>
			<td width="85%">
				<?php
					$js = 'id="rencana_anggaran" style="width:30%; padding:3px;"'; 
					echo form_dropdown('rencana_anggaran',$rencana_anggaran,$selected_rencana_anggaran,$js);
				?>
			</td>
		</tr>
	</table>
	<h3>Rincian Pengusul</h3>
	<table width="100%" height="100%">
			<td width="15%" height="21" style="padding-left:10px;vertical-align:top;">Nama Satker</td> 
			<td width="85%">
				<?php
					$js = 'id="satker" onChange="get_data(this)" disabled="disabled" style="width:50%; padding:3px;"'; 
					echo form_dropdown('satker', $satker, $selected_worker, $js) 
				?>
				<?php echo  form_error('satker'); ?>
				
			<input type="hidden" name="kdsatker" id="kdsatker" readonly="TRUE" value="<?php echo  $kdsatker; ?>" />
			</td>
		</tr>
		<tr>
			<td height="24" style="padding-left:10px;vertical-align:top;">Propinsi</td>
			<td><input name="provinsi" id="provinsi"  disabled="disabled" style="padding:3px;" value="<?php echo  $provinsi; ?>" /></td>
		</tr>
		<tr>
			<td height="33" style="padding-left:10px;vertical-align:top;">Jenis Kewenangan</td>
			<td>
				<?php 
					$disabled = 'id="jenis_satker" disabled="disabled" style="width:16%; padding:3px;"';
					echo form_dropdown('jenis_satker', $jenis_satker,$KodeJenisSatker,$disabled);
				?>
			</td>
		</tr>
	</table>
	<h3>Identitas Proposal</h3>
	<table width="100%" height="100%">
		<tr>
			<td width="15%"  style="padding-left:10px;vertical-align:top;">Judul Proposal</td>
			<td width="85%">
				<textarea name="judul_proposal" cols="60" rows="4" id="judul_proposal"><?php echo  $judul; ?></textarea>
				<?php echo  form_error('judul_proposal'); ?>
			</td>
		</tr>
		<tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Nomor Surat Pengantar</td>
			<td width="85%">
				<input type="text" id="nomor_proposal" name="nomor_proposal" value="<?php echo  $nomor;?>" style="padding:3px;"/></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Tanggal Surat</td>
			<td><p>
			  <input name="tanggal_pembuatan" id="tanggal_pembuatan" type="text"  value="<?php echo  $tanggal_pembuatan;?>" style="padding:3px;"/> (hh-bb-tttt)
			</p></td>
        </tr>
		  <tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Perihal Surat</td>
			<td width="85%"><textarea id="perihal" name="perihal" cols="60" rows="4"><?php echo  $perihal;?></textarea></td>
		  </tr>
    
		<tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Th. Anggaran</td>
			<td><input name="thn_anggaran" id="thn_anggaran" value="<?php echo  $thn_anggaran; ?>" readonly="TRUE" style="padding:3px;"/></td>
		</tr>
		<?php /*<tr>
			<td style="padding-left:10px;vertical-align:top;">Triwulan</td>
			<td><input name="triwulan" id="triwulan" value="<?php echo  $triwulan; ?>" readonly="TRUE" /></td>
		</tr> */ ?>
		<tr>
		  <td style="padding-left:10px;vertical-align:top;">Tupoksi</td>
		  <td><?php foreach ($tupoksi as $row) { ?>
              <input style="width:20px;" id="tupoksi" name="tupoksi[]" type="checkbox" value="<?php echo  $row->KodeTupoksi; ?>" <?php if($this->pm->cek_tupoksi($kd_pengajuan, $row->KodeTupoksi)) echo "checked=\"true\""; ?> />
              <?php echo  $row->Tupoksi; ?></br>
              <?php } ?>          </td>
	    </tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Fokus Prioritas</td>
			<td><table width="100%" height="100%">
				<?php if(isset($fokus_prioritas)){ foreach ($fokus_prioritas as $row) { ?>
				<tr>
				<td>	<input style="width:20px;" id="<?php echo  "fokus_prioritas".$row->idFokusPrioritas; ?>" name="fokus_prioritas[]" type="checkbox" value="<?php echo  $row->idFokusPrioritas; ?>" <?php if($this->pm->cek('data_fokus_prioritas', 'idFokusPrioritas', $row->idFokusPrioritas, 'KD_PENGAJUAN', $kd_pengajuan)) echo "checked=\"true\""; ?>/> </td>
					<td width="97%"><?php echo  $row->FokusPrioritas; ?></td>
					<?php /* <td width="14%"><input type="text" style="text-align:right;vertical-align:top;" id="<?php echo  "biaya_fp_".$row->idFokusPrioritas; ?>" onChange="totalFp();" onfocusout="totalFp();" onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';"  name="<?php echo  "biaya_fp_".$row->idFokusPrioritas; ?>" <?php if($this->pm->cek('data_fokus_prioritas', 'idFokusPrioritas', $row->idFokusPrioritas, 'KD_PENGAJUAN', $kd_pengajuan)){ foreach($this->mm->get_where2('data_fokus_prioritas', 'idFokusPrioritas', $row->idFokusPrioritas, 'KD_PENGAJUAN', $kd_pengajuan)->result() as $r) echo "value=\"".$r->Biaya."\"";} else echo "value=\"0\"";?>/></td> */ ?>
				</tr>
				<?php }} ?>
				<?php /*<tr><td></td><td align="right">Total Biaya</td><td><input type="text" id="total_fp" style="text-align:right;vertical-align:top;"  readonly="true" value="<?php echo  $this->pm->sum('data_fokus_prioritas','Biaya','KD_PENGAJUAN',$kd_pengajuan); ?>"/></td></tr> */ ?>
			</table></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Reformasi Kesehatan</td>
			<td><table width="100%" height="100%">
				<?php if(isset($reformasi_kesehatan)){ foreach($reformasi_kesehatan as $row) { ?>
				<tr>
				<td>	<input style="width:20px;" id="<?php echo  "reformasi_kesehatan".$row->idReformasiKesehatan; ?>" name="reformasi_kesehatan[]" type="checkbox" value="<?php echo  $row->idReformasiKesehatan; ?>"  <?php if($this->pm->cek('data_reformasi_kesehatan', 'idReformasiKesehatan', $row->idReformasiKesehatan, 'KD_PENGAJUAN', $kd_pengajuan)) echo "checked=\"true\""; ?>/> </td>
				<td width="97%"><?php echo  $row->ReformasiKesehatan; ?></td>
				<?php /*<td width="14%"><input type="text" style="text-align:right;vertical-align:top;" id="<?php echo  "biaya_rk_".$row->idReformasiKesehatan; ?>" onChange="totalRk();" onfocusout="totalRk();" onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';"  name="<?php echo  "biaya_rk_".$row->idReformasiKesehatan; ?>" <?php if($this->pm->cek('data_reformasi_kesehatan', 'idReformasiKesehatan', $row->idReformasiKesehatan, 'KD_PENGAJUAN', $kd_pengajuan)){ foreach($this->mm->get_where2('data_reformasi_kesehatan', 'idReformasiKesehatan', $row->idReformasiKesehatan, 'KD_PENGAJUAN', $kd_pengajuan)->result() as $r) echo "value=\"".$r->Biaya."\"";} else echo "value=\"0\"";?>/></td> */ ?>
				</tr>
				<?php }} ?>
				<?php/*<tr><td></td><td align="right">Total Biaya</td><td><input type="text" id="total_rk" style="text-align:right;vertical-align:top;" readonly="true" value="<?php echo  $this->pm->sum('data_reformasi_kesehatan','Biaya','KD_PENGAJUAN',$kd_pengajuan); ?>"/></td></tr>
				<tr><td colspan="3"><div id="label" style="color:red;"><strong></strong></div></td></tr>*/?>
			</table></td>
		</tr>
        
	</table>
	<h3>Waktu Pelaksanaan</h3>
	<table width="100%" height="10%">
      <tr>
        <td width="15%" height="24"style="padding-left:10px;vertical-align:top;">Tanggal Mulai </td>
        <td><p>
          <input name="tanggal_mulai" id="tanggal_mulai" type="text" style="padding:3px;" value="<?php echo  $tanggal_mulai;?>"/> (hh-bb-tttt)
        </p></td>
        </tr>
      <tr>
        <td style="padding-left:10px;vertical-align:top;">Tanggal Selesai </td>
        <td><p>
          <input name="tanggal_selesai" id="tanggal_selesai" type="text" style="padding:3px;" value="<?php echo  $tanggal_selesai;?>"/> (hh-bb-tttt)
        </p></td>
        </tr>
	</table>
	<h3>Ringkasan Proposal</h3>
	<table width="100%" height="3%">
      <tr>
        <td width="15%"  style="padding-left:10px;vertical-align:top;">Latar Belakang</td>
        <td width="85%"><textarea id="latar_belakang" name="latar_belakang"><?php echo  $latar_belakang; ?></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="15%"  style="padding-left:10px;vertical-align:top;">Analisis Situasi</td>
        <td width="85%"><textarea id="analisis_situasi" name="analisis_situasi"><?php echo  $analisis_situasi; ?></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="15%"  style="padding-left:10px;vertical-align:top;">Permasalahan</td>
        <td width="85%"><textarea id="permasalahan" name="permasalahan"><?php echo  $permasalahan; ?></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="15%"  style="padding-left:10px;vertical-align:top;">Alternatif Pemecahan Masalah</td>
        <td width="85%"><textarea id="alternatif_solusi" name="alternatif_solusi"><?php echo  $alternatif_solusi; ?></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<h3>Lampiran</h3>
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
			<td width="15%" style="vertical-align:top;">File Lampiran</td>
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
			</td>
		</tr>
		<!-- <tr>
			<td width="15%" style="padding-left:10px;vertical-align:top;">Proposal</td>
			<td><input id="file1" name="file1" class="element file" type="file"/> <?php //if($proposal != '-'){ echo'<a href="'.base_url().'file/'.$proposal.'">'.$proposal.'</a>'; } ?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">TOR</td>
			<td><input id="file2" name="file2" class="element file" type="file"/> <?php //if($tor != '-'){ echo'<a href="'.base_url().'file/'.$tor.'">'.$tor.'</a>'; } ?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Data Pendukung Lainnya</td>
			<td><input id="file3" name="file3" class="element file" type="file"/> <?php //if($data_pendukung_lainnya != '-'){ echo'<a href="'.base_url().'file/'.$data_pendukung_lainnya.'">'.$data_pendukung_lainnya.'</a>'; } ?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr> -->
		<?php } else {?>
			<tr>
			<td width="15%" style="vertical-align:top;">File Lampiran</td>
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
		<p>&nbsp;</p>
	<h3>Ringkasan Fungsi</h3>
	<table width="100%" height="3%">
      <div>
        <tr>
          <td width="15%" height="23"  style="padding-left:10px;vertical-align:top;">Fungsi</td>
          <td width="85%">
				<?php
					$js = 'id="fungsi" onchange="get_sub(this.value);" style="width:75%; padding:3px;"'; 
					echo form_dropdown('fungsi', $fungsi, $selected_fungsi, $js) ;
				?>
				<?php echo  form_error('fungsi'); ?>
		  
			</td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
      
		<tr >
			<td width="15%" style="padding-left:10px;vertical-align:top;">Sub Fungsi</td>
			<td width="85%">
				<select id="subfungsi" name="subfungsi" style="width:75%; padding:3px;">
					<option value="0">--- Pilih Sub Fungsi ---</option>
			        <?php
					  foreach($sub_fungsi->result() as $row)
					  {
						if($selected_subfungsi == $row->KodeSubFungsi)
						  echo '<option selected value="'.$row->KodeSubFungsi.'">['.$row->KodeSubFungsi.'] '.$row->NamaSubFungsi.'</option>';
						else
						  echo '<option value="'.$row->KodeSubFungsi.'">['.$row->KodeSubFungsi.'] '.$row->NamaSubFungsi.'</option>';
					  }
					?>
	            </select>
			</td>
		</tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
        <tr>
          <td width="15%" style="padding-left:10px;vertical-align:top;">Program</td>
          <td><label>
				<?php
					$pr = 'id="program" name="program" onchange="get_keg(this.value);  get_outcome(this.value), get_iku(this.value)" style="width:75%; padding:3px;"'; 
					echo form_dropdown('program', $program, $selected_program, $pr) ;
				?>
				<?php echo  form_error('program'); ?>
		  
          </label></td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
        <tr>
          <td width="15%" height="32" style="padding-left:10px;vertical-align:top;">Outcome</td>
          <td name="outcome" id="outcome" >
		  <?php echo  $outcome; ?>
          </td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="23%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">IKU</td>
          <td style="padding-left:10px;"  id="iku" name="iku">
				<table width="100%" height="100%">
			<tr><td></td><td></td><td  align="center"><b>Target Nasional</b></td><td  align="center"><b>Jumlah</b></td></tr>
				<?php if(isset($iku)){ foreach($iku as $row) { ?>
				<tr>
				<td>	<input style="width:20px;" id="<?php echo  "iku".$row->KodeIku; ?>" name="iku_[]" type="checkbox" value="<?php echo  $row->KodeIku; ?>"  <?php if($this->pm->cek('data_iku', 'KodeIku', $row->KodeIku, 'KD_PENGAJUAN', $kd_pengajuan)) echo "checked=\"true\""; ?>/> </td>
				<td width="85%"><?php echo  '['.$row->KodeIku.'] '.$row->Iku; ?></td>
				<td width="14%"><input type="text" style="text-align:center;vertical-align:top;" id="<?php echo  "nasional_iku".$row->KodeIku; ?>" name="<?php echo  "nasional_iku".$row->KodeIku; ?>" <?php  foreach($this->pm->get_where_double('target_iku',  $row->KodeIku, 'KodeIku', $idTahun, 'idThnAnggaran')->result() as $r) echo 'value="'.$r->TargetNasional.'"'; ?>  disabled="disabled"/></td>
				<td width="14%"><input type="text" style="text-align:center;vertical-align:top;" id="<?php echo  "target_iku_".$row->KodeIku; ?>" onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';"  name="<?php echo  "target_iku_".$row->KodeIku; ?>" <?php if($this->pm->cek('data_iku', 'KodeIku', $row->KodeIku, 'KD_PENGAJUAN', $kd_pengajuan)){ foreach($this->mm->get_where2('data_iku','KodeIku',$row->KodeIku,'KD_PENGAJUAN',$kd_pengajuan)->result() as $r) echo  "value=\"".$r->Jumlah."\"";} else echo "value=\"0\""; ?>  /></td>
				</tr>
				<?php }} ?>
			</table>
			</td>
			</tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="8%">
	  <div>
       
		<tr>
          <td width="15%" height="21"  style="padding-left:10px;vertical-align:top;">Kegiatan</td>
          <td><label><select id="kegiatan_" name="kegiatan_" onchange="get_output(this.value); get_ikk(this.value)" style="width:75%; padding:3px;">
            				<option value="0">--- Pilih Kegiatan ---</option>
                            <?php
							  foreach($kegiatan->result() as $row)
							  {
								if($selected_kegiatan == $row->KodeKegiatan)
								  echo '<option selected value="'.$row->KodeKegiatan.'">['.$row->KodeKegiatan.'] '.$row->NamaKegiatan.'</option>';
								else
								  echo '<option value="'.$row->KodeKegiatan.'">['.$row->KodeKegiatan.'] '.$row->NamaKegiatan.'</option>';
							  }
							  ?>
              </select>
          </label></td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="4%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">Output</td>
          <td name="output" id="output" >
		  <?php echo  $output; ?>
		  </td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="23%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">IKK</td>
          <td style="padding-left:10px;" id="ikk" name="ikk">
				<table width="100%" height="100%">
			<tr><td></td><td></td><td  align="center"><b>Target Nasional</b></td><td  align="center"><b>Jumlah</b></td></tr>
				<?php if(isset($ikk)){ foreach($ikk as $row) { ?>
				<tr>
				<td><input style="width:20px;" id="<?php echo  "ikk".$row->KodeIkk; ?>" name="ikk_[]" type="checkbox" value="<?php echo  $row->KodeIkk; ?>"  <?php if($this->pm->cek('data_ikk', 'KodeIkk', $row->KodeIkk, 'KD_PENGAJUAN', $kd_pengajuan)) echo "checked=\"true\""; ?>/> </td>
				<td width="85%"><?php echo  '['.$row->KodeIkk.'] '.$row->Ikk; ?></td>
				<td width="14%"><input type="text" style="text-align:center;vertical-align:top;" id="<?php echo  "nasional_ikk".$row->KodeIkk; ?>" name="<?php echo  "nasional_ikk".$row->KodeIkk; ?>" <?php  foreach($this->pm->get_where_double('target_ikk',  $row->KodeIkk, 'KodeIkk', $idTahun, 'idThnAnggaran')->result() as $r) echo 'value="'.$r->TargetNasional.'"'; ?>  disabled="disabled"/></td>
				<td width="14%"><input type="text" style="text-align:center;vertical-align:top;" id="<?php echo  "target_ikk_".$row->KodeIkk; ?>" onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';"  name="<?php echo  "target_ikk_".$row->KodeIkk; ?>" <?php if($this->pm->cek('data_ikk', 'KodeIkk', $row->KodeIkk, 'KD_PENGAJUAN', $kd_pengajuan)){ foreach($this->mm->get_where2('data_ikk','KodeIkk',$row->KodeIkk,'KD_PENGAJUAN',$kd_pengajuan)->result() as $r) echo  "value=\"".$r->Jumlah."\"";} else echo "value=\"0\""; ?>  /></td>
				</tr>
				<?php }} ?>
			
			</table>
		  	</td>
          </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
		<table>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
	    <a href="<?php echo  site_url(); ?>/e-planning/manajemen/grid_pengajuan" class="negative">
						<img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>
						Batal
					 </a>
					<button type="submit" class="regular" name="save" id="save">
						<img src="<?php echo  base_url(); ?>images/main/update.png" alt=""/>
						Koreksi
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
		$(function() {
			$( "#tanggal_pembuatan" ).datepicker({ dateFormat: "dd-mm-yy" });
			$( "#tanggal_mulai" ).datepicker({ dateFormat: "dd-mm-yy" });
			$( "#tanggal_selesai" ).datepicker({ dateFormat: "dd-mm-yy" });
		});
	});
	
function activateprop(source) {
	$('#menu_provinsi').hide();
}
<?php /*
<?php if(isset($reformasi_kesehatan)){foreach($reformasi_kesehatan as $row) { ?>
		<?php if(!$this->pm->cek('data_reformasi_kesehatan', 'idReformasiKesehatan', $row->idReformasiKesehatan, 'KD_PENGAJUAN', $kd_pengajuan)){ ?> $('<?php echo  "#biaya_rk_".$row->idReformasiKesehatan; ?>').hide(); <?php } ?>
	<?php }} ?>
	<?php if(isset($fokus_prioritas)){ foreach ($fokus_prioritas as $row) { ?>
		<?php if(!$this->pm->cek('data_fokus_prioritas', 'idFokusPrioritas', $row->idFokusPrioritas, 'KD_PENGAJUAN', $kd_pengajuan)){ ?> $('<?php echo  "#biaya_fp_".$row->idFokusPrioritas; ?>').hide(); <?php } ?>
	<?php }} ?>
	
	function get_data(kdsatker){
		document.form_edit_pengusulan.kdsatker.value = '';
		document.form_edit_pengusulan.provinsi.value = '';
		$.ajax({
			url: "<?php echo  base_url(); ?>index.php/e-planning/pendaftaran/get_alamatSatker",
			global: false,
			type: "POST",
			async: false,
			dataType: "html",
			data: "kdsatker="+ satker.value, //the name of the $_POST variable and its value
			success: function (response) {
				str = response.split(";");
				document.form_edit_pengusulan.kdsatker.value = satker.value;
				document.form_edit_pengusulan.provinsi.value = str[0];
									
			}          
		});
	  	return false;
	}
	
	function totalRk(){
		var biaya=0;
		<?php if(isset($reformasi_kesehatan)){ ?>
				<?php
					$no=0;
					echo "biaya=";
					foreach($reformasi_kesehatan as $row) {
						if($no>0) echo "+";
						echo "eval(document.form_edit_pengusulan.biaya_rk_".$row->idReformasiKesehatan.".value)";
						$no++;
					}
					echo ";";
				?>
		<?php } ?>
		document.form_edit_pengusulan.total_rk.value = biaya;
		if(document.form_edit_pengusulan.total_rk.value != document.form_edit_pengusulan.total_fp.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Total biaya Fokus Priortas dan Total biaya Reformasi Kesehatan harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
	}
	
	function totalFp(){
		var biaya=0;
		<?php if(isset($fokus_prioritas)){ ?>
				<?php
					$no=0;
					echo "biaya=";
					foreach($fokus_prioritas as $row) {
						if($no>0) echo "+";
						echo "eval(document.form_edit_pengusulan.biaya_fp_".$row->idFokusPrioritas.".value)";
						$no++;
					}
					echo ";";
				?>
		<?php } ?>
		document.form_edit_pengusulan.total_fp.value = biaya;
		if(document.form_edit_pengusulan.total_rk.value != document.form_edit_pengusulan.total_fp.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Total biaya Fokus Priortas dan Total biaya Reformasi Kesehatan harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
	}
	
	<?php if(isset($reformasi_kesehatan)){foreach($reformasi_kesehatan as $row) { ?>
		$('<?php echo  "#reformasi_kesehatan".$row->idReformasiKesehatan; ?>').click(function() {
		  if(this.checked){
			$('<?php echo  "#biaya_rk_".$row->idReformasiKesehatan; ?>').show();
		  }else{
			$('<?php echo  "#biaya_rk_".$row->idReformasiKesehatan; ?>').hide();
			<?php echo  "document.form_edit_pengusulan.biaya_rk_".$row->idReformasiKesehatan.".value='0';"; ?>
			totalRk();
		  }
		});
	<?php }} ?>
	<?php if(isset($fokus_prioritas)){foreach($fokus_prioritas as $row) { ?>
		$('<?php echo  "#fokus_prioritas".$row->idFokusPrioritas; ?>').click(function() {
		  if(this.checked){
			$('<?php echo  "#biaya_fp_".$row->idFokusPrioritas; ?>').show();
		  }else{
			$('<?php echo  "#biaya_fp_".$row->idFokusPrioritas; ?>').hide();
			<?php echo  "document.form_edit_pengusulan.biaya_fp_".$row->idFokusPrioritas.".value='0';"; ?>
			totalFp();
		  }
		});
	<?php }} ?>
*/ ?>
function get_sub(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_sub/'+v;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option;
			var nama;
			
			//$('#testing').html('');
			
			$('#subfungsi').html('<option value="0">--- Pilih Sub Fungsi ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeSub'];
				nama = data[i]['NamaSub'];
				option += '<option value="'+id+'">['+id+'] '+nama+'</option>';
			}
  				$('#subfungsi').append(option);
		}
	});	
}
function get_keg(x)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_keg/'+x;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option;
			var nama;
			
			//$('#testing').html('');
			
			$('#kegiatan_').html('<option value="0">--- Pilih Kegiatan ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeKeg'];
				nama = data[i]['NamaKeg'];
				option += '<option value="'+id+'">['+id+'] '+nama+'</option>';
				
			}
  				$('#kegiatan_').append(option);
		}
	});	
}
function get_outcome(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_outcome/'+v;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var option='';
			var nama;
			
			//$('#testing').html('');
			
			$('#outcome').html('');
			
			for(var i=0; i< data.length;i++)
			{
				nama = data[i]['OutComeProgram'];
				option += nama+'</br>';
			}
  				$('#outcome').append(option);
		}
	});	
}
function get_iku(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_iku/'+v;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option='';
			var nama;
			var target;
			var idtarget;
			//$('#testing').html('');
			
			$('#iku').html('<tr><td></td><td></td><td  align="center"><b>Target Nasional</b></td><td  align="center"><b>Jumlah</b></td></tr>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeIku'];
				idtarget = id.replace(/\./g, '_');
				nama = data[i]['Iku'];
				target = data[i]['TargetNasional'];
				option += '<tr><td><input type="checkbox" name="iku_[]" value="'+id+'"/></></td><td>['+id+'] '+nama+'</td><td width="17%"><iwidth="17%"><input readonly="true" type="text" name="nasional_iku'+i+'" value="'+target+'" style="text-align:center"/></td><td width="17%"><input type="text" style="text-align:center" name="target_iku_'+idtarget+'" id="target_iku_'+id+'"/></td></tr>';
			}
  				$('#iku').append(option);
		}
	});	
} 
function get_output(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_output/'+v;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option='';
			var nama;
			
			//$('#testing').html('');
			
			$('#output').html('');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeOutput'];
				nama = data[i]['Output'];
				option += nama+'</br>';
			}
  				$('#output').html(option);
		}
	});	
}
function get_ikk(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_ikk/'+v;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option='';
			var nama;
			var target;
			var idtarget;
			//$('#testing').html('');
			
			$('#ikk').html('<tr><td></td><td></td><td  align="center"><b>Target Nasional</b></td><td  align="center"><b>Jumlah</b></td></tr>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeIkk'];
				idtarget = id.replace(/\./g, '_');
				nama = data[i]['Ikk'];
				target = data[i]['TargetNasional'];
				option +=  '<tr><td><input type="checkbox" name="ikk_[]" value="'+id+'"/></></td><td>['+id+'] '+nama+'</td><td width="17%"><iwidth="17%"><input readonly="true" type="text" name="nasional_ikk'+i+'" value="'+target+'" style="text-align:center"/></td><td width="17%"><input type="text" style="text-align:center" name="target_ikk_'+idtarget+'" id="target_ikk_'+id+'"/></td></tr>';
			}
  				$('#ikk').append(option);
		}
	});	
}
function validateForm()
	{
	var a=document.forms["form_edit_pengusulan"]["judul_proposal"].value;
	var b=document.forms["form_edit_pengusulan"]["nomor_proposal"].value;
	var c=document.forms["form_edit_pengusulan"]["tanggal_pembuatan"].value;
	var d=document.forms["form_edit_pengusulan"]["tanggal_mulai"].value;
	var e=document.forms["form_edit_pengusulan"]["tanggal_selesai"].value;
	var f=document.forms["form_edit_pengusulan"]["fungsi"].value;
	var g=document.forms["form_edit_pengusulan"]["subfungsi"].value;
	var h=document.forms["form_edit_pengusulan"]["program"].value;
	var i=document.forms["form_edit_pengusulan"]["kegiatan_"].value;
	var j=document.forms["form_edit_pengusulan"]["latar_belakang"].value;
	var k=document.forms["form_edit_pengusulan"]["analisis_situasi"].value;
	var l=document.forms["form_edit_pengusulan"]["permasalahan"].value;
	var m=document.forms["form_edit_pengusulan"]["alternatif_solusi"].value;
	if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="" || e==null || e=="" || f==0 || g==0 || h==0 || i==0  || j==""  || j=="<p></p>" || k=="" || k=="<p></p>" || l=="" || l=="<p></p>" || m=="" || m=="<p></p>" )
	  {
	  alert("Judul, nomor, tanggal pembuatan, tanggal mulai, tanggal selesai, latar belakang, analisis situasi, permasalahan, dan alternatif solusi harus diisi.\nFungsi, subfungsi, program, dan kegiatan harus diisi.");
	  return false;
	  }
	}

	function get_data(kdsatker){
		document.form_edit_pengusulan.kdsatker.value = '';
		document.form_edit_pengusulan.provinsi.value = '';
		$.ajax({
			url: "<?php echo  base_url(); ?>index.php/e-planning/pendaftaran/get_alamatSatker",
			global: false,
			type: "POST",
			async: false,
			dataType: "html",
			data: "kdsatker="+ satker.value, //the name of the $_POST variable and its value
			success: function (response) {
				str = response.split(";");
				document.form_edit_pengusulan.kdsatker.value = satker.value;
				document.form_edit_pengusulan.provinsi.value = str[0];
			}          
		});
	  	return false;
	}
	
	function hitungJumlah(){
		biaya = eval(document.form_edit_pengusulan.volume.value)*eval(document.form_edit_pengusulan.harga_satuan.value);
		document.form_edit_pengusulan.jumlah.value = biaya;
	}
	tinyMCE.init({
        // General options
        mode : "exact",
		elements : "latar_belakang,analisis_situasi,permasalahan,alternatif_solusi",
		theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
 
        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,undo,redo",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "hr,removeformat,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        content_css : "css/content.css",
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",        
    });

</script>

<div id="tengah">
<div id="judul" class="title">
	<?php echo $title; ?>
</div>
<div id="content_tengah">
	<form class="appnitro" name="form_filtering" id="form_filtering" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/prioritas/save_prioritas_satker/4'; ?>">
	<table width="100%" height="100%" cellspacing="0" cellpadding="0" >
		<tr>
			<td width="70%">Periode <?php echo form_dropdown('periode',$periode); ?></td>
		</tr>
		<tr>
			<td width="70%">
				<table width="100%" border="0" cellspacing="5" cellpadding="5" height="100%">
					<tr>
						<td>
							<div style="height:360px; overflow:auto;">
								<ul><?php if($this->pm->cek1('ref_satker_program','kdsatker',$this->session->userdata('kdsatker'))){ ?>
									<?php foreach($program->result() as $row){?>
									<li><input id= "program[]" style="width:50px" type="checkbox" name="program[]" value="<?php echo $row->KodeProgram; ?>" <?php if($this->masmo->cek('prioritas_program', $this->session->userdata('kdsatker'), 'kdsatker', $row->KodeProgram, 'KodeProgram')) echo "checked=\"true\""; ?>><span><?php echo $row->KodeProgram." - ".$row->NamaProgram; ?></span>
										<ul>
											<li><?php if($this->pm->cek1('ref_satker_iku','kdsatker',$this->session->userdata('kdsatker'))){ ?>
											<strong>IKU</strong></li>
											<?php foreach($this->fm->get_where_iku('ref_iku','KodeProgram',$row->KodeProgram)->result() as $row){?>
												<li><input style="width:50px" type="checkbox" name="iku[]" value="<?php echo $row->KodeIku; ?>" <?php if($this->masmo->cek('prioritas_iku', $this->session->userdata('kdsatker'), 'kdsatker', $row->KodeIku, 'KodeIku')); ?>><span><?php echo $row->KodeIku." - ".$row->Iku; ?></span>
											<?php } ?>
											<?php } else echo 'Tidak ada kewenangan IKU pada program ini.';?>
											<li><?php if($this->pm->cek1('ref_satker_kegiatan','kdsatker',$this->session->userdata('kdsatker'))){ ?>
											<strong>Kegiatan</strong></li>
											<?php foreach($this->fm->get_where_kegiatan('ref_kegiatan','KodeProgram',$row->KodeProgram)->result() as $row){?>
											<li><input id="kegiatan[]" style="width:50px" type="checkbox" name="kegiatan[]" value="<?php echo $row->KodeKegiatan; ?>" <?php if($this->masmo->cek('prioritas_kegiatan', $this->session->userdata('kdsatker'), 'kdsatker', $row->KodeKegiatan, 'KodeKegiatan')) echo "checked=\"true\""; ?>><span><?php echo $row->KodeKegiatan." - ".$row->NamaKegiatan; ?></span>
												<ul><?php if($this->pm->cek1('ref_satker_ikk','kdsatker',$this->session->userdata('kdsatker'))){ ?>
													<?php foreach($this->fm->get_where_ikk('ref_ikk','KodeKegiatan',$row->KodeKegiatan)->result() as $row){?>
														<li><input style="width:50px" type="checkbox" name="ikk[]" value="<?php echo $row->KodeIkk; ?>" <?php if($this->masmo->cek('prioritas_ikk', $this->session->userdata('kdsatker'), 'kdsatker', $row->KodeIkk, 'KodeIkk')) echo "checked=\"true\""; ?>><span><?php echo $row->KodeIkk." - ".$row->Ikk; ?></span>
													<?php } ?>
													<?php } else echo 'Tidak ada kewenangan IKK pada kegiatan ini.';?>
												</ul>
											<?php } ?>
											<?php } else echo 'Tidak ada kewenangan kegiatan pada program ini.';?>
										</ul>
									<?php } ?>
								</ul>
							</div>
							<?php } else echo 'Tidak ada kewenangan program untuk satuan kerja ini.';?>
						</td>
					</tr>
					<tr>
						<td>
							<div class="buttons">
								<button type="submit" class="normal" name="Cari">
									<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
									Simpan
								</button>
								<button type="reset" class="negative" name="reset">
									<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
									Reset
								</button>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
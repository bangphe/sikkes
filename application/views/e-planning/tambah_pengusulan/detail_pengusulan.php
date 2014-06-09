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
</style>
<div id="tengah">
<div id="judul" class="title">
	Detail Proposal
	<!--label class="edit"><a href="<?php //echo base_url(); ?>index.php/e-planning/manajemen/detail_pengajuan/<?php //echo $kd_pengajuan ?>/2"><img src="<?php //echo base_url(); ?>images/icons/Edit_icon.png" /></a></label-->
</div>
<div id="content_tengah">
<form id="detail_pengajuan" name="detail_pengajuan" method="POST"  >
	<h3>Sumber Dana</h3>
	<table width="100%" height="auto" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%">Sumber Dana</td>
			<td width="85%">
				<?php foreach($this->mm->get_where('ref_rencana_anggaran','id_rencana_anggaran',$selected_rencana_anggaran)->result() as $row)
					echo $row->rencana_anggaran;
				?>
			</td>
		</tr>
	</table>
	<h3>Rincian Pengusul</h3>
	<table width="100%" height="auto" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%" style="vertical-align:top;">Nama Satker</td> 
			<td>
				<?php
					foreach($this->mm->get_where('ref_satker','kdsatker',$kdsatker)->result() as $row)
					echo $row->nmsatker;
				?>
			</td>
		</tr>
		<tr>
			<td>Propinsi</td>
			<td><?php echo $provinsi; ?></td>
		</tr>
		<tr>
			<td>Jenis Satker</td>
			<td>
				<?php
					foreach($this->mm->get_where('ref_jenis_satker','KodeJenisSatker',$KodeJenisSatker)->result() as $row)
					echo $row->JenisSatker; 
				?>
			</td>
		</tr>
	</table>
	<h3>Identitas Proposal</h3>
	<table width="100%" height="auto">
		<tr>
			<td width="15%" style="vertical-align:top;">Judul Proposal</td>
			<td width="85%">
				<?php echo $judul; ?>
			</td>
		</tr>
		<tr>
			<td width="15%" style="vertical-align:top;">Nomor Surat Pengantar</td>
			<td width="85%">
				<?php echo $nomor;?></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Tanggal Surat</td>
			<td><p>
			  <?php echo $tanggal_pembuatan;?>
			</p></td>
        </tr>
		  <tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Perihal Surat</td>
			<td width="85%"><?php echo $perihal;?></td>
		  </tr>
		<tr>
			<td style="vertical-align:top;">Th. Anggaran</td>
			<td><?php echo $thn_anggaran; ?></td>
		</tr>
	</table>
	<h3>Ringkasan Proposal</h3>
	<table width="100%" height="auto">
		<tr>
			<td width="15%" style="vertical-align:top;">Latar Belakang</td>
			<td width="85%">
				<?php echo $latar_belakang; ?>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td style="vertical-align:top;">Analisis Situasi</td>
			<td>
				<?php echo $analisis_situasi; ?>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td style="vertical-align:top;">Permasalahan</td>
			<td>
				<?php echo $permasalahan; ?>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td style="vertical-align:top;">Alternatif Pemecahan Masalah</td>
			<td>
				<?php echo $alternatif_solusi; ?>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td style="vertical-align:top;">Tupoksi</td>
			<td>
				<?php echo $selected_tupoksi;  ?>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td style="vertical-align:top;">Fokus Prioritas</td>
			<td><table class="myTable">
				<tr>
					<td class="tes">Fokus Prioritas</td>
					<td class="tes">Biaya</td>
				</tr>
				<?php foreach ($fp_selected as $row) { ?>
				<tr>
					<td width="85%"><?php echo $this->mm->get_where('fokus_prioritas','idFokusPrioritas',$row->idFokusPrioritas)->row()->FokusPrioritas; ?> </td>
					<td align="right"><?php echo 'Rp '.number_format($this->pm->get_biaya_fp($kd_pengajuan,$row->idFokusPrioritas));?> </td>
				</tr>
				<?php } ?>
				<tr>
					<td align="center"><b>Total Biaya</b></td>
					<td align="right"><b><?php echo 'Rp '.number_format($this->pm->sum('data_fokus_prioritas','Biaya','KD_PENGAJUAN',$kd_pengajuan)); ?></b></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td style="vertical-align:top;">Reformasi Kesehatan</td>
			<td>
				<table class="myTable">
				<tr>
					<td class="tes">Reformasi Kesehatan</td>
					<td class="tes">Biaya</td>
				</tr>
				<?php foreach ($rk_selected as $row) { ?>
				<tr>
					<td width="85%"><?php echo $this->mm->get_where('reformasi_kesehatan','idReformasiKesehatan',$row->idReformasiKesehatan)->row()->ReformasiKesehatan;?> </td>
					<td align="right"><?php echo 'Rp '.number_format($this->pm->get_biaya_rk($kd_pengajuan,$row->idReformasiKesehatan));?> </td>
				</tr>
				<?php } ?>
				<tr>
					<td align="center"><b>Total Biaya</b></td>
					<td align="right"><b><?php echo 'Rp '.number_format($this->pm->sum('data_reformasi_kesehatan','Biaya','KD_PENGAJUAN',$kd_pengajuan)); ?></b></td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
	<h3>Ringkasan Fungsi</h3>
	<table>
		<tr>
		<td width="15%" style="vertical-align:top;">Fungsi</td>
		<?php
			$kode_fungsi='';
			foreach($this->mm->get_where('ref_fungsi','KodeFungsi',$selected_fungsi)->result() as $row){  $kode_fungsi=$row->KodeFungsi;?>
		<td>(<?php echo $kode_fungsi; ?>) <?php echo $row->NamaFungsi; }?></td>
		</tr>
		<tr>
		<td width="15%" style="vertical-align:top;">Sub Fungsi</td>
		<?php
			$kode_subfungsi='';
			foreach($this->mm->get_where2('ref_sub_fungsi','KodeFungsi',$selected_fungsi, 'KodeSubFungsi',$selected_subfungsi)->result() as $row){ 
			$kode_subfungsi=$row->KodeSubFungsi; ?>
		<td>(<?php	echo $kode_fungsi.'.'.$kode_subfungsi; ?>) <?php echo $row->NamaSubFungsi; } ?></td>
		</tr>
		<tr>
		<td width="15%" style="vertical-align:top;">Program</td>
		<?php
			$kode_program='';
			foreach($this->mm->get_where('ref_program','KodeProgram',$selected_program)->result() as $row){ ?>
		<td>(<?php	$kode_program=$row->KodeProgram; echo $kode_program; ?>) <?php echo $row->NamaProgram; }?></td>
		</tr>
        <tr>
          <td width="15%" height="32" style="vertical-align:top;">Outcome</td>
          <td name="outcome" id="outcome" >
		  <?php echo $outcome; ?>
          </td>
        </tr>
        <tr>
			<td width="15%" style="vertical-align:top;">Kegiatan</td>
			<?php
				$kode_kegiatan='';
				foreach($this->mm->get_where('data_kegiatan','KD_PENGAJUAN',$kd_pengajuan)->result() as $row){ ?>
			<td>(<?php	$kode_kegiatan=$row->KodeKegiatan;echo $kode_kegiatan;	?>) <?php echo $row->NamaKegiatan; }?></td>
		</tr>
		<tr>
			<td width="15%"  style="vertical-align:top;">IKU</td>
			<td>
				<table class="myTable">
					<tr>
						<td class="tes"><b>IKU</b></td>
						<td class="tes" align="center"><b>Target Nasional - Renja KL</b></td>
						<td class="tes" align="center"><b>Jumlah</b></td>
						<td class="tes" align="center"><b>Status</b></td>
					</tr>
					<?php
						$dataiku = $this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$kd_pengajuan,'KodeFungsi',$kode_fungsi,'KodeSubFungsi',$kode_subfungsi,'data_iku.KodeProgram',$kode_program,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result();
						$count = count($dataiku);
						if ($count == 0) {
					?>
						<td align="center">-</td>
						<td align="center">-</td>
						<td align="center">-</td>
						<td align="center">-</td>
					<?php } else { ?>
					<?php
						foreach($dataiku as $row) {  
					?>
					<tr>
						<td>(<?php echo $row->KodeIku;?>) <?php echo $row->Iku; ?></td>
						<td align="center" width="14%"><?php foreach($this->pm->get_where_double('target_iku',  $row->KodeIku, 'KodeIku', $idTahun, 'idThnAnggaran')->result() as $r) echo $r->TargetNasional; ?></td>
						<td align="center" width="14%"><?php echo $row->Jumlah; ?></td>
						<?php
							$targetIku = $this->pm->get_where_double('target_iku', $row->KodeIku, 'KodeIku', $idTahun, 'idThnAnggaran');
							//$cek = count($targetIku);
							foreach($targetIku->result() as $r)
							{
								$target_nasional = $r->TargetNasional;
								if ($row->Jumlah < $target_nasional) {
							 		$warning_icon_target_iku = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
								}
								elseif ($row->Jumlah >= $target_nasional) {
									$warning_icon_target_iku = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>';
								}
							}
						?>
						<td align="center" width="14%"><?php echo $warning_icon_target_iku; ?></td>
					</tr>
					<?php } } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td width="15%" style="vertical-align:top;">IKK</td>
			<td>
				<table class="myTable">
					<tr>
						<td class="tes"><b>IKK</b></td>
						<td class="tes" align="center"><b>Target Nasional - Renja KL</b></td>
						<td class="tes" align="center"><b>Jumlah</b></td>
						<td class="tes" align="center"><b>Status</b></td>
					</tr>
				<?php
					$dataikk = $this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$kd_pengajuan,'KodeFungsi',$kode_fungsi,'KodeSubFungsi',$kode_subfungsi,'data_ikk.KodeProgram',$kode_program,'data_ikk.KodeKegiatan',$kode_kegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result();
					$count = count($dataikk);
					if($count == 0) {
				?>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">-</td>
					<td align="center">-</td>
				<?php } else { ?>
				<?php
					foreach($dataikk as $row) { 
				?>
					<tr>
						<td>(<?php	echo $row->KodeIkk; ?>) <?php echo $row->Ikk; ?></td>
						<td align="center" width="14%"><?php foreach($this->pm->get_where_double('target_ikk',  $row->KodeIkk, 'KodeIkk',$idTahun, 'idThnAnggaran')->result() as $r) echo $r->TargetNasional; ?></td>
						<td align="center" width="14%"><?php echo $row->Jumlah; ?></td>
						<?php
							foreach($this->pm->get_where_double('target_ikk',  $row->KodeIkk, 'KodeIkk',$idTahun, 'idThnAnggaran')->result() as $r)
							{
								$target_nasional = $r->TargetNasional;
								if ($row->Jumlah < $target_nasional) {
							 		$warning_icon_target_ikk = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
								}
								elseif ($row->Jumlah >= $target_nasional) {
									$warning_icon_target_ikk = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>';
								}
							}
						?>
						<td align="center" width="14%"><?php echo $warning_icon_target_ikk; ?></td>
					</tr>
				<?php } } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td width="15%"  style="vertical-align:top;">Aktivitas</td>
			<td>
				<table class="myTable">
					<tr>
						<td class="tes"><b>Judul Aktivitas</b></td>
						<td class="tes"><b>Jenis Usulan</b></td>
						<td class="tes"><b>Perincian</b></td>
						<td class="tes"><b>Volume<b/></td>
						<td class="tes"><b>Satuan</b></td>
						<td class="tes"><b>Harga Satuan</b></td>
						<td class="tes"><b>Jumlah</b></td>
						<!--td class="tes">Fokus Prioritas</td><th>Reformasi Kesehatan</th-->
					</tr>
					<?php
						$jumlahakt = 0;
						$kode_aktivitas='';
						$data_aktivitas = $this->mm->get_where_double_join('aktivitas','ref_jenis_usulan','aktivitas.KodeJenisUsulan=ref_jenis_usulan.KodeJenisUsulan','ref_satuan','aktivitas.KodeSatuan=ref_satuan.KodeSatuan','KD_PENGAJUAN',$kd_pengajuan)->result();
						foreach($data_aktivitas as $row)
						{ 
							$kode_aktivitas = $row->KodeAktivitas;
					?>
					<tr>
						<td><?php echo $row->JudulUsulan; ?></td>
						<td><?php echo $row->JenisUsulan; ?></td>
						<td><?php echo $row->Perincian; ?></td>
						<td align="right"><?php echo number_format($row->Volume); ?></td>
						<td><?php echo $row->Satuan; ?></td>
						<td align="right"><?php echo 'Rp '.number_format($row->HargaSatuan); ?></td>
						<td align="right"><?php echo 'Rp '.number_format($row->Jumlah); ?></td>
						<!--td><?php //foreach($this->mm->get_where_join('data_fokus_prioritas','fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas','KD_PENGAJUAN',$kd_pengajuan)->result() as $row) echo $row->FokusPrioritas;	?>
						</td-->
					</tr>
						<?php $jumlahakt = $jumlahakt + $row->Jumlah; } ?>
					<tr>
						<td align="center" colspan="6"><b>Total</b></td>
						<td align="right"><b><?php echo 'Rp '.number_format($jumlahakt); ?></b></td>
					</tr>
				</table>
			</td>
			</td>
		</tr>
	</table>

	<h3>Lampiran</h3>
	<table width="100%" height="auto">
		<tr>
			<td width="15%">Proposal</td>
			<td width="85%">
				<?php if($proposal != '-'){ ?><a href="<?php echo base_url(); ?>file/<?php echo $proposal; ?>"><?php echo $proposal; ?></a>
				<?php }else echo '-'; ?>
			</td>
		</tr>
		<tr>
			<td>TOR</td>
			<td>
				<?php if($tor != '-'){ ?><a href="<?php echo base_url(); ?>file/<?php echo $tor; ?>"><?php echo $tor; ?></a>
				<?php }else echo '-'; ?>
			</td>
		</tr>
		<tr>
			<td>Data Pendukung Lainnya</td>
			<td>
				<?php if($data_pendukung_lainnya != '-'){ ?><a href="<?php echo base_url(); ?>file/<?php echo $data_pendukung_lainnya; ?>"><?php echo $data_pendukung_lainnya; ?></a>
				<?php }else echo '-'; ?>
			</td>
		</tr>
		<?php if($this->session->userdata('kodejenissatker') == '1' || $this->session->userdata('kodejenissatker') == '4'){ ?>
		<tr>
			<td>Surat Rekomendasi dari Tingkat Provinsi</td>
			<td>
				<?php if($surat_rekomendasi_prov != '-'){ ?><a href="<?php echo base_url(); ?>file/<?php echo $surat_rekomendasi_prov; ?>"><?php echo $surat_rekomendasi_prov; ?></a>
				<?php }else echo '-'; ?>
			</td>
		</tr>
		<? } ?>
		<?php if($this->session->userdata('kodejenissatker') == '3'){ ?>
		<tr>
			<td>Surat Rekomendasi dari Tingkat Unit</td>
			<td>
				<?php if($surat_rekomendasi_uu != '-'){ ?><a href="<?php echo base_url(); ?>file/<?php echo $surat_rekomendasi_uu; ?>"><?php echo $surat_rekomendasi_uu; ?></a>
				<?php }else echo '-'; ?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="button" class="positive" name="ok" onClick="history.go(-1);"> <img src="<?php echo base_url(); ?>images/main/ok.png" alt=""/> OK </button>
				</div>
			</td>
		</tr>
	</table>
</form>
</div>
</div>
<script>
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

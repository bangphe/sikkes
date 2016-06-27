<link rel="stylesheet" type="text/css" href="<?php echo  base_url();?>css/feedback.css">
<style type="text/css">
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
<!-- <div class="alert alert-danger text-center">
	<h4>INFORMASI</h4>
	<p style="font-size:13px;">Periode <?php //echo $periode;?></p>
</div> -->

<div id="tengah">
    <div id="judul" class="title">
        Data Proposal
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

<div id="tengah">
	<!-- <div id="judul" class="title">Data RAB</div> -->
	<!-- <div id="content_tengah">
	<?php
		if(isset($added_php)) echo $added_php."</br></br></br>";
		echo $js_grid;
	?>
		<table id="user" style="display:none"></table>
	</div>
	<div id="petunjuk">            
		<?php echo $this->config->item('petunjuk');?>
		<?php if (isset($failed_form)) { echo $failed_form; $this->session->unset_userdata('failed_form'); }?>
		<?php if(isset($no_asal)) echo $no_asal;?>
	</div>
	<?php if (isset($div)){echo $div;}?>
	<?php if (isset($div2)){echo $div2;}?>
	<?php if (isset($div3)){echo $div3;}?> -->

	<div id="tabs">
		<ul>
		    <li><a href="#tabs-1">Periode Pagu Indikatif</a></li>
		    <li><a href="#tabs-2">Periode Anggaran</a></li>
		    <li><a href="#tabs-3">Periode Pagu Definitif</a></li>
		</ul>
		<div id="tabs-1">
			<?php if ($cek_periode_satu) {?>
			<div id="content_tengah">
			<?php
				if(isset($added_php)) echo $added_php."</br></br></br>";
				echo $js_grid;
			?>
			<table id="user" style="display:none"></table>
			</div>
			<div id="petunjuk">            
				<?php echo $this->config->item('petunjuk');?>
				<?php if (isset($failed_form)) { echo $failed_form; $this->session->unset_userdata('failed_form'); }?>
				<?php if(isset($no_asal)) echo $no_asal;?>
			</div>
			<?php if (isset($div)){echo $div;}?>
			<?php if (isset($div2)){echo $div2;}?>
			<?php if (isset($div3)){echo $div3;}?>
			<?php } else { ?>	
			<div class="alert alert-danger text-center">
				<h4>MAAF</h4>
				<p style="font-size:13px;">Pagu Indikatif (01 Januari 2015 - 31 Maret 2015) sudah ditutup.</p>
			</div>
			<div id="content_tengah">
				<table class="myTable">
					<tr>
						<td width="2%" class="tes"><b>No.</b></td>
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
						$data_aktivitas = $this->am->get_aktivitas_1($kdpengajuan)->result();
						foreach($data_aktivitas as $value => $row)
						{ 
							$kode_aktivitas = $row->KodeAktivitas;
					?>
					<tr>
						<td><?php echo  $value+1;?></td>
						<td><?php echo  $row->JudulUsulan; ?></td>
						<td><?php echo  $row->JenisUsulan; ?></td>
						<td><?php echo  $row->Perincian; ?></td>
						<td align="right"><?php echo  number_format($row->Volume); ?></td>
						<td><?php echo  $row->Satuan; ?></td>
						<td align="right"><?php echo  'Rp '.number_format($row->HargaSatuan); ?></td>
						<td align="right"><?php echo  'Rp '.number_format($row->Jumlah); ?></td>
						<!--td><?php //foreach($this->mm->get_where_join('data_fokus_prioritas','fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas','KD_PENGAJUAN',$kd_pengajuan)->result() as $row) echo $row->FokusPrioritas;	?>
						</td-->
					</tr>
						<?php $jumlahakt = $jumlahakt + $row->Jumlah; $value++;} ?>
					<tr>
						<td align="center" colspan="7"><b>Total</b></td>
						<td align="right"><b><?php echo  'Rp '.number_format($jumlahakt); ?></b></td>
					</tr>
				</table>
			</div>
			<?php } ?>
		</div>
		
		<div id="tabs-2">
			<?php if ($cek_periode_dua) {?>
			<div id="content_tengah">
			<?php
				if(isset($added_php)) echo $added_php."</br></br></br>";
				echo $js_grid;
			?>
			<table id="user" style="display:none"></table>
			</div>
			<div id="petunjuk">            
				<?php echo $this->config->item('petunjuk');?>
				<?php if (isset($failed_form)) { echo $failed_form; $this->session->unset_userdata('failed_form'); }?>
				<?php if(isset($no_asal)) echo $no_asal;?>
			</div>
			<?php if (isset($div)){echo $div;}?>
			<?php if (isset($div2)){echo $div2;}?>
			<?php if (isset($div3)){echo $div3;}?>
			<?php } else { ?>
			<div class="alert alert-danger text-center">
				<h4>MAAF</h4>
				<p style="font-size:13px;">Periode Pagu Anggaran (01 Januari 2015 - 31 Maret 2015) sudah ditutup.</p>
			</div>
			<div id="content_tengah">
				<table class="myTable">
					<tr>
						<td width="2%" class="tes"><b>No.</b></td>
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
						$data_aktivitas = $this->am->get_aktivitas_2($kdpengajuan)->result();
						foreach($data_aktivitas as $value => $row)
						{ 
							$kode_aktivitas = $row->KodeAktivitas;
					?>
					<tr>
						<td><?php echo  $value+1;?></td>
						<td><?php echo  $row->JudulUsulan; ?></td>
						<td><?php echo  $row->JenisUsulan; ?></td>
						<td><?php echo  $row->Perincian; ?></td>
						<td align="right"><?php echo  number_format($row->Volume); ?></td>
						<td><?php echo  $row->Satuan; ?></td>
						<td align="right"><?php echo  'Rp '.number_format($row->HargaSatuan); ?></td>
						<td align="right"><?php echo  'Rp '.number_format($row->Jumlah); ?></td>
						<!--td><?php //foreach($this->mm->get_where_join('data_fokus_prioritas','fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas','KD_PENGAJUAN',$kd_pengajuan)->result() as $row) echo $row->FokusPrioritas;	?>
						</td-->
					</tr>
						<?php $jumlahakt = $jumlahakt + $row->Jumlah; $value++;} ?>
					<tr>
						<td align="center" colspan="7"><b>Total</b></td>
						<td align="right"><b><?php echo  'Rp '.number_format($jumlahakt); ?></b></td>
					</tr>
				</table>
			</div>
			<?php } ?>
		</div>
		<div id="tabs-3">
		<?php if ($cek_periode_tiga) {?>
		<div id="content_tengah">
			<div class="alert alert-danger text-center">
				<h4>PENGUMUMAN</h4>
				<p style="font-size:13px;">Periode Anggaran (01 September 2015 - 31 Desember 2015)</p>
			</div>
			<?php
				if(isset($added_php)) echo $added_php."</br></br></br>";
				echo $js_grid;
			?>
			<table id="user" style="display:none"></table>
			</div>
			<div id="petunjuk">            
				<?php echo $this->config->item('petunjuk');?>
				<?php if (isset($failed_form)) { echo $failed_form; $this->session->unset_userdata('failed_form'); }?>
				<?php if(isset($no_asal)) echo $no_asal;?>
			</div>
			<?php if (isset($div)){echo $div;}?>
			<?php if (isset($div2)){echo $div2;}?>
			<?php if (isset($div3)){echo $div3;}?>
		<?php } else { ?>
		<div class="alert alert-danger text-center">
			<h4>MAAF</h4>
			<p style="font-size:13px;">Pagu Definitif (01 September 2015 - 30 September 2015) belum dibuka.</p>
		</div>
		<div id="content_tengah">
			<table class="myTable">
				<tr>
					<td width="2%" class="tes"><b>No.</b></td>
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
					$data_aktivitas = $this->am->get_aktivitas_2($kdpengajuan)->result();
					foreach($data_aktivitas as $value => $row)
					{ 
						$kode_aktivitas = $row->KodeAktivitas;
				?>
				<tr>
					<td><?php echo  $value+1;?></td>
					<td><?php echo  $row->JudulUsulan; ?></td>
					<td><?php echo  $row->JenisUsulan; ?></td>
					<td><?php echo  $row->Perincian; ?></td>
					<td align="right"><?php echo  number_format($row->Volume); ?></td>
					<td><?php echo  $row->Satuan; ?></td>
					<td align="right"><?php echo  'Rp '.number_format($row->HargaSatuan); ?></td>
					<td align="right"><?php echo  'Rp '.number_format($row->Jumlah); ?></td>
					<!--td><?php //foreach($this->mm->get_where_join('data_fokus_prioritas','fokus_prioritas','data_fokus_prioritas.idFokusPrioritas=fokus_prioritas.idFokusPrioritas','KD_PENGAJUAN',$kd_pengajuan)->result() as $row) echo $row->FokusPrioritas;	?>
					</td-->
				</tr>
					<?php $jumlahakt = $jumlahakt + $row->Jumlah; $value++;} ?>
				<tr>
					<td align="center" colspan="7"><b>Total</b></td>
					<td align="right"><b><?php echo  'Rp '.number_format($jumlahakt); ?></b></td>
				</tr>
			</table>
		</div>
		<?php } ?>
		</div>
	</div>
</div>

<script type="text/javascript">
var periode_pengajuan_satu = "<?php echo  $cek_periode_satu_status;?>";
var periode_pengajuan_dua = "<?php echo  $cek_periode_dua_status;?>";
var periode_pengajuan_tiga = "<?php echo  $cek_periode_tiga_status;?>";
//alert(periode_pengajuan_satu);
$(function() {
	if (periode_pengajuan_satu==1) {
		$( "#tabs" ).tabs({active: 0});
	}
	else if(periode_pengajuan_dua==1) {
		$( "#tabs" ).tabs({active: 1});
	}
	else if(periode_pengajuan_tiga==1) {
		$( "#tabs" ).tabs({active: 2});
	}
	else {
		$( "#tabs" ).tabs({active: 0});
	}
});
</script>
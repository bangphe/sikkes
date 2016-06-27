<link rel="stylesheet" type="text/css" href="<?php echo  base_url();?>css/feedback.css">

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
	<div id="judul" class="title">Data RAB</div>
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
	</div>
	<?php if (isset($div)){echo $div;}?>
	<?php if (isset($div2)){echo $div2;}?>
	<?php if (isset($div3)){echo $div3;}?>
</div>

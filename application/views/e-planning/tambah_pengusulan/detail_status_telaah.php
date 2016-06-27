<div id="kiri">
<div id="judul" class="title">
	Telaah Staff
</div>
<div id="content">
		<table width="700px" border="0" cellspacing="0" cellpadding="0">
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>JUDUL PROPOSAL</p></td>
				<td>:</td>
				<td><?php echo  $judul;?></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td width="200px" style="padding-left:10px;vertical-align:top;"><p>TELAAH</p></td>
				<td>:</td>
				<td><?php echo  '<a href="'.site_url().'/e-planning/telaah/detail_telaah_staff/'.$kd_telaah.'/'.$kd_pengajuan.'">'; ?>Lihat Detail Telaah</a></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>STATUS PROSES TELAAH</p></td>
				<td>:</td>
				<td><?php 
				if($status == '0'){ echo '-DRAFT-';
					if($this->session->userdata('eselon') == '0') echo '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$row->KODE_TELAAH_STAFF.'/'.$KodePengajuan.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/edit.png\'> - DRAFT -</a>';}
				if($status == '1') echo 'Telah ditelaah staf';
				if($status == '2'){ echo 'Perlu koreksi staf';
					if($this->session->userdata('eselon') == '4') echo '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$row->KODE_TELAAH_STAFF.'/'.$KodePengajuan.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'> Perlu koreksi staf</a>';}
				if($status == '3') echo 'Telah ditelaah Kasubag';
				if($status == '4'){ echo 'Perlu koreksi Kasubag';
					if($this->session->userdata('eselon') == '3') echo '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$row->KODE_TELAAH_STAFF.'/'.$KodePengajuan.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'> Perlu koreksi Kasubag</a>';}
				if($status == '5') echo 'Telah ditelaah Kabag';
				if($status == '6'){ echo 'Perlu koreksi Kabag';
					if($this->session->userdata('eselon') == '2') echo '<a href="'.site_url().'/e-planning/telaah/update_telaah_staff/'.$row->KODE_TELAAH_STAFF.'/'.$KodePengajuan.'"><img border=\'0\' src=\''.base_url().'images/flexigrid/detail.png\'> Perlu koreksi Kabag</a?';}
				if($status == '7') echo 'Telah ditelaah Kabiro';
				?></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<?php 	$status_staf = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>';
					$status_kasubag = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>';
					$status_kabag = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>';
					$status_kabiro = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>';
					if($status < 7){
						$status_kabiro = '(belum menelaah)';
						if($status == 6) $status_kasubag = '(perlu mengoreksi)';
					}
					if($status < 5){
						$status_kabag = '(belum menelaah)';
						if($status == 4) $status_kasubag = '(perlu mengoreksi)';
					}
					if($status < 3){
						$status_kasubag = '(belum menelaah)';
						if($status == 2) $status_staf = '(perlu mengoreksi)';
					}
					if($status < 1){
						$status_staf = '(belum menelaah)';
					}
			?>
			<tr>
				<td style="padding-left:10px;vertical-align:top;" colspan=2>Staf&nbsp;</td>
				<td align="left"><?php echo  $status_staf; ?></td>
			</tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;" colspan=2>Kasubag&nbsp;</td>
				<td align="left"><?php echo  $status_kasubag; ?></td>
			</tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;" colspan=2>Kabag&nbsp;</td>
				<td align="left"><?php echo  $status_kabag; ?></td>
			</tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;" colspan=2>Kabiro&nbsp;</td>
				<td align="left"><?php echo  $status_kabiro; ?> <?php echo  $this->session->userdata('eselon'); ?></td>
			</tr>
			<tr>
			<td></td><td></td>
			<td><div class="buttons">
					<button type="button" class="negative" name="kembali" onClick="history.go(-1);"> <img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/> Kembali </button>
			<?php if($this->session->userdata('eselon') != '0'){ ?>
			<a href="#" class="positive" >
					<img src="<?php echo  base_url(); ?>images/main/ok.png" alt=""/> Minta Koreksi </a>
			<?php } ?>
			<?php if($this->session->userdata('eselon') == '4' || $this->session->userdata('eselon') == '3'){ ?>
			<a href="<?php echo  base_url()?>index.php/e-planning/telaah/kirim/<?php echo  $kd_telaah;?>" class="positive" >
					<img src="<?php echo  base_url(); ?>images/main/ok.png" alt=""/> Kirim </a>
			<?php }
			elseif($this->session->userdata('eselon') == '2'){ ?>
			<a href="#" class="positive" >
					<img src="<?php echo  base_url(); ?>images/main/ok.png" alt=""/> Setujui Telaah </a>
			<?php } ?>
				</div>
			</td>
			</tr>
		</table>
		</div>
</div>
</div>
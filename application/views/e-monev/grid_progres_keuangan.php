<div class="buttons">
	<button type="submit" class="regular" name="grafik" onClick="grafik(<?php echo $d_skmpnen_id;?>);">
		<img src="<?php echo base_url(); ?>images/icon/grafik.png" alt=""/>
		Grafik
	</button>
</div>

<p align="center"><b>Tahun Anggaran : </b><?php echo $this->session->userdata('thn_anggaran');?></p>
<br />
<p align="center"><b>Nama Komponen/Sub Komponen : </b><?php echo $sub_komponen;?></p>

<br />
<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>No</th>
		<th>Bulan</th>
		<!--<th>Tanggal</th>
		<th>No SPM</th>
		<th>Nominal</th>
		<th>Presentase (%)</th>
		<th>Update</th>
		<th>SP2D</th>-->
		<th>Jumlah Progres Keuangan</th>
		<th>%SPM</th>
		<th>%SP2D</th>
		<th>SPM</th>
	</tr>
	<?php
		$no = 1;
		foreach($daftar_progres2 as $row){
	?>
	<tr>
		<td width="3%"><?php echo $no++;?></td>
		<td width="15%"><?php echo $bulan[$row->bulan];?></td>
		<!--<td width="15%"><?php echo $row->tanggal;?></td>
		<td><?php echo $row->nomor_spm;?></td>
		<td><?php echo $row->nominal;?></td>
		<td><?php echo round($row->keuangan,3).' %';?></td>
		<td width="5%"><?php echo '<a href=\'#\'><img border=\'0\' onclick="update('.$d_skmpnen_id.','.$row->spm_id.','.$row->bulan.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
		<td width="5%"><?php echo '<a href=\'#\'><img border=\'0\' onclick="sp2d('.$d_skmpnen_id.','.$row->spm_id.','.$row->bulan.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>-->
		<td>Rp. <?=number_format($row->nominal,2,',','.');?></td>
		<td><?php if($alokasi != 0){
			$persen_spm = round($row->nominal/$alokasi*100, 2);
		}else{
			$persen_spm = 0;
		}
		echo $persen_spm.' %';?></td>
		<td><?php if($alokasi != 0 && $sp2d[$row->bulan] != null){
			$persen_sp2d = round($sp2d[$row->bulan]/$alokasi*100, 2);
		}else{
			$persen_sp2d = 0;
		}
		echo $persen_sp2d.' %';?></td>
		<td width="5%"><?php echo '<a href=\'#\'><img border=\'0\' onclick="spm('.$d_skmpnen_id.','.$row->spm_id.','.$row->bulan.');" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
	</tr>
	<?php } ?>																									
</table>

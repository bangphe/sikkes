<div class="buttons">
	<button type="submit" class="regular" name="grafik_rencana" onclick="grafik_rencana(<?php echo  $idpaket;?>)">
		<img src="<?php echo  base_url(); ?>images/icon/grafik.png" alt=""/>
		Grafik
	</button>
</div>
<div class="buttons">
<p align="center"><b>Tahun Anggaran : </b><?php echo  $this->session->userdata('thn_anggaran');?></p>
<br />
<p align="center"><b>Output : </b><?php echo  $nmoutput;?></p>
<br />
<p align="center"><b>Sub Output : </b><?php echo  $ursoutput;?></p>
<br />
<br />
</div>
<div align="center">
<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>Bulan</th>
		<th>Rencana Fisik (%)</th>
		<th>Input</th>
	</tr>
	<?php
		$no = 1;
		foreach($daftar_rencana as $row){
	?>
	<tr>
		<td><?php echo  $bulan[$row->bulan];?></td>
		<td><?php echo  $row->rencana_kontraktual;?></td>
		<td><?php echo  '<a href=\'#\'><img border=\'0\' onclick="update_rencana_kontrak('.$row->rencana_id.','.$row->idpaket.','.$row->bulan.')" src=\''.base_url().'images/icons/edit_icon(16x16).png\'></a></td>'; ?></td>
		
	</tr>
	<?php } ?>																									
</table>
</div>
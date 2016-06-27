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
<table>
	<tr>
		<td>
			<table class="myTable">
				<tr>
					<td class="tes"><b>IKU</b></td>
					<td class="tes" align="center"><b>Target Nasional - Renja KL</b></td>
					<td class="tes" align="center"><b>Jumlah</b></td>
					<td class="tes" align="center"><b>Status</b></td>
				</tr>
			<?php
				foreach($iku as $row) { 
			?>
				<tr>
					<td>(<?php echo  $row->KodeIku; ?>) <?php echo  $row->Iku; ?></td>
					<td align="center" width="14%"><?php foreach($this->pm->get_where_double('target_iku',  $row->KodeIku, 'KodeIku',$idTahun, 'idThnAnggaran')->result() as $r) echo $r->TargetNasional; ?></td>
					<td align="center" width="14%">
					<?php
					if($this->pm->cek('data_iku', 'KodeIku', $row->KodeIku, 'KD_PENGAJUAN', $kdpengajuan)) {
						foreach($this->pm->get_iku_by_kdpengajuan_iku($kdpengajuan,$row->KodeIku)->result() as $v) echo $v->Jumlah=='' ? '0' : $v->Jumlah;
					}
					else {
						echo '-';
					}	
					?>
					</td>
					<?php
						$target_i = $this->pm->get_targetiku_by_kdpengajuan_iku($kdpengajuan, $row->KodeIku, $idTahun);
						if($target_i->num_rows() > 0) {
							foreach($this->pm->get_targetiku_by_kdpengajuan_iku($kdpengajuan, $row->KodeIku, $idTahun)->result() as $r)
							{
								$jumlah_iku = $r->Jumlah;
								$target_nasional = $r->TargetNasional;
								if ($jumlah_iku < $target_nasional) {
							 		$warning_icon_target_iku = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
								}
								elseif ($jumlah_iku >= $target_nasional) {
									$warning_icon_target_iku = '<img border=\'0\' src=\''.base_url().'images/flexigrid/setujui.png\'>';
								}
							}
						}
						else {
							$warning_icon_target_iku = '<img border=\'0\' src=\''.base_url().'images/flexigrid/tolak.png\'>';
						}
					?>
					<td align="center" width="14%"><?php echo  $warning_icon_target_iku; ?></td>
				</tr>
			<?php } ?>
			</table>
		</td>
	</tr>
</table>
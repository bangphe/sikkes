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
					<td class="tes"><b>IKK</b></td>
					<td class="tes" align="center"><b>Target Nasional - Renja KL</b></td>
					<td class="tes" align="center"><b>Jumlah</b></td>
					<td class="tes" align="center"><b>Status</b></td>
				</tr>
			<?php
				$dataikk = $this->pm->get_ikk_by_satker($kdpengajuan)->result();
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
					<td align="center" width="14%"><?php echo $row->Jumlah=="" ? "0" : $row->Jumlah; ?></td>
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
</table>
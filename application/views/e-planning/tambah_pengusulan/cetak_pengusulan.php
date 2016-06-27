<html>
<head>
</head>
<body>
<body onLoad="window.print(); window.location='<?php echo  site_url(); ?>/e-planning/manajemen/grid_pengajuan_disetujui';">
<div width="560px" align="center">
<div align="right" width="660px">CM. 005/Teknis-Roren</div>
<div align="center" width="660px">
	RENCANA ANGGARAN BIAYA</br>
	(NAMA KEGIATAN)</br>
</div>
</br></br></br>
<div width="660px" align="center">
	<table border="1" cellspacing="0" cellpadding="1" width="560" style='table-layout:fixed;'>
		<col width=40>
		<col width=350>
		<col width=70>
		<col width=100>
		<tr align="center">
			<td><strong>No</strong></td>
			<td><strong>Uraian</strong></td>
			<td><strong>Volume</strong></td>
			<td><strong>Total</strong></td>
		</tr>
		<?php
			$no=1;
			foreach($pengusulan->result() as $row){
		?>
			<tr style='font-size:12px;'>
				<td align="center"><strong><?php echo  $no; ?></strong></td>
				<td><strong><?php echo  $row->JUDUL_PROPOSAL ?></strong></td>
				<td></td>
				<td><strong><?php echo  number_format($this->mm->sum('data_program','Biaya', 'KD_PENGAJUAN',$row->KD_PENGAJUAN)); ?></strong></td>
			</tr>
			<?php foreach($this->mm->get_where('data_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN)->result() as $row2){?>
				<tr>
					<td></td>
					<td>
						<table border="0" height="auto" width="350">
						<col width=10>
						<col width=340>
						<tr style='font-size:12px;'>
							<td></td>
							<td><?php echo  $row2->NamaFungsi; ?></td>
						</tr>
						</table>
					</td>
					<td></td>
					<td></td>
				</tr>
				<?php foreach($this->mm->get_where2('data_sub_fungsi','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi)->result() as $row3){?>
					<tr>
						<td></td>
						<td>
							<table border="0" height="auto" width="350">
							<col width=10>
							<col width=340>
							<tr style='font-size:12px;'>
								<td></td>
								<td><?php echo  $row3->NamaSubFungsi; ?></td>
							</tr>
							</table>
						<td></td>
						<td></td>
					</tr>
					<?php foreach($this->mm->get_where3('data_program','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi)->result() as $row4){?>
						<tr>
							<td></td>
							<td>
								<table border="0" height="auto" width="350">
								<col width=10>
								<col width=340>
								<tr style='font-size:12px;'>
									<td></td>
									<td><?php echo  $row4->NamaProgram; ?></td>
								</tr>
								</table>
							</td>
							<td></td>
							<td style='font-size:12px;'><?php echo  number_format($row4->Biaya); ?></td>
						</tr>
						<?php foreach($this->mm->get_where4_join('data_iku','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'data_iku.KodeProgram',$row4->KodeProgram,'ref_iku','data_iku.KodeIku=ref_iku.KodeIku')->result() as $row5){?>
							<tr>
								<td></td>
								<td>
									<table border="0" height="auto" width="350">
									<col width=20>
									<col width=330>
									<tr style='font-size:12px;'>
										<td></td>
										<td><?php echo  $row5->Iku; ?></td>
									</tr>
									</table>
								</td>
								<td style='font-size:12px;'><?php echo  number_format($row5->Jumlah); ?></td>
								<td></td>
							</tr>
							<?php foreach($this->mm->get_where4('data_kegiatan','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeFungsi.'.'.$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram)->result() as $row6){?>
								<tr>
									<td></td>
									<td>
										<table border="0" height="auto" width="350">
										<col width=20>
										<col width=330>
										<tr style='font-size:12px;'>
											<td></td>
											<td><?php echo  $row6->NamaKegiatan; ?></td>
										</tr>
										</table>
									</td>
									<td></td>
									<td style='font-size:12px;'><?php echo  number_format($row6->Biaya); ?></td>
								</tr>
								<?php foreach($this->mm->get_where5_join('data_ikk','KD_PENGAJUAN',$row->KD_PENGAJUAN,'KodeFungsi',$row2->KodeFungsi,'KodeSubFungsi',$row3->KodeSubFungsi,'KodeProgram',$row4->KodeProgram,'data_ikk.KodeKegiatan',$row6->KodeKegiatan,'ref_ikk','data_ikk.KodeIkk=ref_ikk.KodeIkk')->result() as $row7){?>
									<tr>
										<td></td>
										<td>
											<table border="0" height="auto" width="350">
											<col width=30>
											<col width=320>
											<tr style='font-size:12px;'>
												<td></td>
												<td><?php echo  $row7->Ikk; ?></td>
											</tr>
											</table>
										</td>
										<td style='font-size:12px;'><?php echo  number_format($row7->Jumlah); ?></td>
										<td></td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		<?php
			$no++;
			}
			
		?>
	</table>
</div>
</div>
</body>
</html>
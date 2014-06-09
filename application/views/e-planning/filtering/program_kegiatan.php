<div id="container">
	<h1>Rincian Pengusul</h1>
	<div id="body">
		<form id="form_program" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/E-Planning/Filtering/search'; ?>">
			<p>search </p>
			<input id="keyword" name="keyword" /> 
			<select id="kategori" name="kategori">
				<option value="KodeProgram">Kode Program</option>
				<option value="NamaProgram">Nama Program</option>
				<option value="OutComeProgram">Output</option>
			</select>
			<input type="submit" value="search" />
		<?php if($program!=''){ ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode Kegiatan</p></td>
				<td><p>Nama Kegiatan</p></td>
				<td><p>Output</p></td>
			</tr>
			<?php
			$no=1;
			foreach($program->result() as $row){
				$kode = $row->KodeProgram;
				$nama = $row->NamaProgram;
				$output = $row->OutComeProgram; 
			?>
			<tr style="cursor: hand" onmouseover="this.style.backgroundColor='#ffff00';" 
			onmouseout="this.style.backgroundColor='#ffffff';" 
			onclick="window.opener.document.getElementById('prioritas').value='<?php echo $nama; ?>';
			window.opener.document.getElementById('kode_prioritas').value='<?php echo $kode; ?>'; 
			window.close();">
				<td><?php echo $no; ?></td>
				<td><?php echo $kode; ?></td>
				<td><?php echo $nama; ?></td>
				<td><?php echo $output; ?></td>
			</tr>
			<?php 
				$no++;	
			} 
			?>
		</table>
		<?php }else{ ?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td><p align="center">No Data</p></td>
			</tr>
			?>
		</table>
		<?php } ?>
		
		</form>
	</div>
</div>
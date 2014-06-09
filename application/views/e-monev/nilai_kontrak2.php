<!--
<tr>
	<td width="40%">Realisasi Keuangan (Rupiah):</td>
	<td width="60%">
		<?php
			$data = array(
						  'name'        => 'realisasi_keuangan',
						  'id'          => 'realisasi_keuangan',
						  'size'        => '30'
						);
			echo form_input($data);
		?>
	</td>
</tr>
<tr>
	<td width="40%">Realisasi Fisik (%) :</td>
	<td width="60%">
		<?php
			$data = array(
						  'name'        => 'realisasi_fisik',
						  'id'          => 'realisasi_fisik',
						  'size'        => '30'
						);
			echo form_input($data);
		?>
	</td>
</tr>
-->
<tr>
	<td width="40%">Nilai Kontrak (Rupiah) :</td>
	<td width="60%">
		<?php
			$data = array(
						  'name'        => 'nilai_kontrak_f',
						  'id'          => 'nilai_kontrak_f',
						  'size'        => '30',
						  'onChange'    => 'format_kontrak()',
						  'onFocus'     => 'unformat_kontrak()'
						);
			echo form_input($data);
		?>
		<input type="hidden" name="nilai_kontrak" id="nilai_kontrak" />
	</td>
</tr>
<tr>
	<td width="40%">PHLN :</td>
	<td width="60%">
		<?php
			$data = array(
						  'name'        => 'phln_f',
						  'id'          => 'phln_f',
						  'size'        => '30',
						  'onChange'    => 'format_phln()',
						  'onFocus'     => 'unformat_phln()'
						);
			echo form_input($data);
		?>
		<input type="hidden" name="phln" id="phln" />
	</td>
</tr>

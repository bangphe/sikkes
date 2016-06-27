<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
  $(function() {
			$( "#tanggal_ttd" ).datepicker({ dateFormat: "dd-mm-yy" });
			$( "#tanggal_pelaksanaan" ).datepicker({ dateFormat: "dd-mm-yy" });
			$( "#tanggal_spmk" ).datepicker({ dateFormat: "dd-mm-yy" });
			$( "#tanggal_selesai" ).datepicker({ dateFormat: "dd-mm-yy" });
	});
});

function format_kontrak(){
	var kontrak = $("#nilai_kontrak_f").val();
	
	if($.isNumeric(kontrak) == false){
		if(kontrak != ''){
			$("#nilai_kontrak_f").val(accounting.formatMoney(0,'Rp ',2,'.',','));
			$("#nilai_kontrak").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Nilai kontrak (Rupiah) harus diisi.');
		}
	}else{
		$("#nilai_kontrak_f").val(accounting.formatMoney(kontrak,'Rp ',2,'.',','));
		$("#nilai_kontrak").val(kontrak);
	}	
}
function unformat_kontrak(){
	var kontrak = $("#nilai_kontrak_f").val();
	$("#nilai_kontrak_f").val(accounting.unformat(kontrak,','));
}
function format_phln(){
	var phln = $("#phln_f").val();
	
	if($.isNumeric(phln) == false){
		if(phln != ''){
			$("#phln_f").val(accounting.formatMoney(0,'Rp ',2,'.',','));
			$("#phln").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Nilai PHLN harus diisi.');
		}
	}else{
		$("#phln_f").val(accounting.formatMoney(phln,'Rp ',2,'.',','));
		$("#phln").val(phln);
	}	
}
function unformat_phln(){
	var phln = $("#phln_f").val();
	$("#phln_f").val(accounting.unformat(phln,','));
}
</script>
<h1><center>Kontrak</center></h1>
<br />
	<table width=auto>
		<?php echo  $input_nilai_kontrak;?>
		<tr>
			<td width="40%">Nomor Kontrak :</td>
			<td width="60%">
				<?php
					$data1 = array(
								  'name'        => 'nomor_kontrak',
								  'id'          => 'nomor_kontrak',
								  'size'        => '30',
								  'value'        => $nomor_kontrak
								);
					echo form_input($data1);
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Tanggal TTD :</td>
			<td width="60%">
				<?php
				$data2 = array(
						  'name'        => 'tanggal_ttd',
						  'id'          => 'tanggal_ttd',
						  'value'       => $tanggal_ttd,
						  'size'        => '30',
						);
					echo form_input($data2);
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Waktu Pelaksanaan :</td>
			<td width="60%">
				<?php
				$data3 = array(
						  'name'        => 'tanggal_pelaksanaan',
						  'id'          => 'tanggal_pelaksanaan',
						  'value'       => $tanggal_pelaksanaan,
						  'size'        => '30',
						);
					echo form_input($data3);
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Tanggal SPMK :</td>
			<td width="60%">
				<?php
				$data4 = array(
						  'name'        => 'tanggal_spmk',
						  'id'          => 'tanggal_spmk',
						  'value'       => $tanggal_spmk,
						  'size'        => '30',
						);
					echo form_input($data4);
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Tanggal Selesai :</td>
			<td width="60%">
				<?php
				$data5 = array(
						  'name'        => 'tanggal_selesai',
						  'id'          => 'tanggal_selesai',
						  'value'       => $tanggal_selesai,
						  'size'        => '30',
						);
					echo form_input($data5);
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Rekanan Utama :</td>
			<td width="60%">
				<?php
				$data6 = array(
						  'name'        => 'rekanan_utama',
						  'id'          => 'rekanan_utama',
						  'value'       => $rekanan_utama,
						  'size'        => '30',
						);
					echo form_input($data6);
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Alamat :</td>
			<td width="60%">
				<?php 
					$data7 = array(
								'name'        => 'alamat',
								'id'          => 'alamat',
								'value'       => $alamat,
								'cols'        => '40',
								'rows'        => '5'
							);
					echo form_textarea($data7);
				?>
			</td>
		</tr>
		<tr>
			<td width="60%">Nama Bank :</td>
			<td width="40%">
				<?php
					echo form_dropdown('nama_bank',$nama_bank, $bank_dipilih,'id="nama_bank"');
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">NPWP :</td>
			<td width="60%">
				<?php
				$data8 = array(
						  'name'        => 'npwp',
						  'id'          => 'npwp',
						  'value'       => $npwp,
						  'size'        => '30',
						);
					echo form_input($data8);
				?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="submit" onClick="update_data_detail_kontrak();">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="form_kontrak();">
						<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
						Reset
					</button>
				</div>
			</td>
		</tr>
	</table>

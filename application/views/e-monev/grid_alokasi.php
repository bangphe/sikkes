<script type="text/javascript">
function getNilaiKontrak(val, no)
{
	var nilai = $("#alokasi_"+no).val();

	if (val == '1') {
		$('#nilai_kontrak_'+no).val(nilai);
		$('#nilai_kontrak_'+no).removeAttr('disabled');
		//$('#nilai_kontrak_'+no).attr('disabled', true);
	}
	else {
		$('#nilai_kontrak_'+no).val('0');
		$('#nilai_kontrak_'+no).removeAttr('disabled');
	}
}

function format_kontrak(no){
	var nilai = $("#nilai_kontrak_"+no).val();
	
	if($.isNumeric(nilai) == false){
		if(nilai != ''){
			$("#nilai_kontrak_"+no).val(accounting.formatMoney(0,'Rp ',2,'.',','));
			$("#nilaikontrak").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Nominal harus diisi.');
		}
	}else{
		$("#nilai_kontrak_"+no).val(accounting.formatMoney(nilai,'Rp ',2,'.',','));
		$("#nilaikontrak").val(nilai);
	}	
}

function unformat_kontrak(no){
	var nilai = $("#nilai_kontrak_"+no).val();
	$("#nilai_kontrak_"+no).val(accounting.unformat(nilai,','));
}

</script>

<br />
<fieldset>
<legend>Daftar Alokasi</legend>
<h2>Alokasi : Rp. <?=number_format($alokasi,2,',','.');?></h2>
<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>No</th>
		<th>Nama Akun</th>
		<th>Nama Item</th>
		<th>Jumlah</th>
	</tr>
	<?php
		$no = 1;
		foreach($d_item->result() as $row){
	?>
	<tr>
		<td><?php echo $no;?></td>
		<td><?php echo $row->kdakun.'-'.$row->nmakun;?></td>
		<td><?php echo $row->nmitem;
		if($row->vol1 !=0){
			echo ' ['.$row->vol1.' '.$row->sat1;
			if($row->vol2 ==0){
				echo ']';
			}else{
				echo ' x '.$row->vol2.' '.$row->sat2;
				if($row->vol3 ==0){
					echo ']';
				}else{
					echo ' x '.$row->vol3.' '.$row->sat3;
					if($row->vol4 ==0){
						echo ']';
					}else{
						echo ' x '.$row->vol4.' '.$row->sat4.']';
					}
				}
			}
		}
		?></td>
		<td>Rp. <?=number_format($row->jumlah,2,',','.');?></td>
		
	</tr>
		<?php $no++; ?>
	<?php } ?>																							
</table>
</fieldset>
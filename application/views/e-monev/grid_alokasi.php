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
		<th>Paket Pengerjaan</th>
		<th>Nilai Kontrak</th>
	</tr>
	<?php
		$no = 1;
		foreach($d_item->result() as $row){
	?>
	<tr>
		<td><?php echo $no;?></td>
		<td><?php echo $row->nmakun.'-'.$row->kdakun;?></td>
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
		<td>
		<select id="idjnsitem_<?php echo $no?>" name="idjnsitem_<?php echo $no?>" style="width:95%; padding:3px" onchange="getNilaiKontrak(this.value, <?php echo $no; ?>), simpanJenisItem(<?php echo $no; ?>)" >
			<option value="0">- Pilih Paket -</option>
			<?php
				foreach ($option_jenis_item->result() as $opt) {
					//ngecek data di dm_jns_item
					$get_jnsitem = $this->lmm->get_jnsitem_by_idpaket($idpaket,$row->noitem,$row->kdakun);
					if ($get_jnsitem->num_rows()) 
					{
						foreach ($get_jnsitem->result() as $get) 
						{
							if($get->kdjnsitem == $opt->idjnsitem) 
							{
								echo '<option value="'.$opt->idjnsitem.'" selected="selected">'.$opt->nmjnsitem.'</option>';
							}
							else {
								echo '<option value="'.$opt->idjnsitem.'">'.$opt->nmjnsitem.'</option>';
							}
						}
					}
					else {
						echo '<option value="'.$opt->idjnsitem.'">'.$opt->nmjnsitem.'</option>';
					}
				}
			?>
		</select>
		</td>
		<td>
			<?php 
				$cek_jnsitem = $this->lmm->get_jnsitem_by_idpaket($idpaket, $row->noitem, $row->kdakun);
				if ($cek_jnsitem->num_rows > 0) {
					$_nilaikontrak = $this->lmm->get_jnsitem_by_idpaket($idpaket, $row->noitem, $row->kdakun)->row()->nilaikontrak;
				}
				else {
					$_nilaikontrak = 0;
				}
				
				$nilai_kontrak = number_format($_nilaikontrak,2,',','.')
			?>
			<input type="text" disabled=<?php echo $_nilaikontrak==0 ? "true" : "false"; ?> name="nilai_kontrak_<?php echo $no;?>" id="nilai_kontrak_<?php echo $no;?>" style="padding:3px; width:75%" onchange="simpanJenisItem(<?php echo $no;?>)" onfocus="unformat_kontrak(<?php echo $no;?>)" value="<?php echo $cek_jnsitem->num_rows() ? $_nilaikontrak : 0; ?>" />
			<input type="hidden" name="alokasi_<?php echo $no;?>" id="alokasi_<?php echo $no;?>" value="<?php echo $row->jumlah ;?>" />
			<input type="hidden" name="noitem_<?php echo $no;?>" id="noitem_<?php echo $no;?>" value="<?php echo $row->noitem?>" />
			<input type="hidden" name="kdakun_<?php echo $no;?>" id="kdakun_<?php echo $no;?>" value="<?php echo $row->kdakun?>" />
		</td>
	</tr>
		<?php $no++; ?>
	<?php } ?>																							
</table>
</fieldset>

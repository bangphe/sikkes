<h1><center>Pra Kontrak</center></h1>
<br />
<fieldset>
	<legend>Detail</legend>
	<table width=auto>
		<tr>
			<td width="40%">Kategori Pengadaan :</td>
			<td width="60%">
				<?php
					echo form_dropdown('kategori_pengadaan',$kategori_pengadaan, $kategori_pengadaan_dipilih,'id="kategori_pengadaan"');
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Cara Pengadaan :</td>
			<td width="60%">
				<?php
					echo form_dropdown('cara_pengadaan',$cara_pengadaan, $cara_pengadaan_dipilih,'id="cara_pengadaan"');
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Nilai HPS / OE :</td>
			<td width="60%">
				<?php
				$data = array(
						  'name'        => 'hps',
						  'id'          => 'hps',
						  'value'       => 'Rp '.number_format($nilai_hps_oe,2,',','.'),
						  'onChange'    => 'format_hps()',
						  'onFocus'     => 'unformat_hps()'
						);
					echo form_input($data);
				?>
				<input type="hidden" name="nilai_hps_oe" id="nilai_hps_oe" value="<?php echo $nilai_hps_oe;?>" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="submit" onClick="update_detail_prakontrak();">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="form_prakontrak();">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>
	<br />
</fieldset>

<script type="text/javascript">
function format_hps(){
	var hps = $("#hps").val();
	
	if($.isNumeric(hps) == false){
		if(hps != ''){
			$("#hps").val(accounting.formatMoney(0,'Rp ',2,'.',','));
			$("#nilai_hps_oe").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Nilai HPS / OE harus diisi.');
		}
	}else{
		$("#hps").val(accounting.formatMoney(hps,'Rp ',2,'.',','));
		$("#nilai_hps_oe").val(hps);
	}	
}
function unformat_hps(){
	var hps = $("#hps").val();
	$("#hps").val(accounting.unformat(hps,','));
}
</script>
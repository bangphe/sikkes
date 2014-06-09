<script type="text/javascript">
$(document).ready(function(){
  $(function() {
			get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_sp2d/"+<?php echo $sp2d_id;?>,'','profile_detail_loading', 'daftar_sp2d');
	});
});

function format_nominal(){
	var nominal = $("#nominal_f").val();
	
	if($.isNumeric(nominal) == false){
		if(nominal != ''){
			$("#nominal_f").val(accounting.formatMoney(0,'Rp ',2,'.',','));
			$("#nominal").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Nominal harus diisi.');
		}
	}else{
		$("#nominal_f").val(accounting.formatMoney(nominal,'Rp ',2,'.',','));
		$("#nominal").val(nominal);
	}	
}
function unformat_nominal(){
	var nominal = $("#nominal_f").val();
	$("#nominal_f").val(accounting.unformat(nominal,','));
}
</script>
<div class="buttons">
	<button type="submit" class="regular" name="grafik" onClick="spm(<?php echo $d_skmpnen_id;?>,<?php echo $spm_id;?>,<?php echo $bulan;?>);">
		<img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
		Kembali
	</button>
	<button type="submit" class="regular" name="grafik" onClick="grafik(<?php echo $d_skmpnen_id;?>);">
		<img src="<?php echo base_url(); ?>images/icon/grafik.png" alt=""/>
		Grafik
	</button>
	
</div>
<br />
<br />
<br />
<fieldset>
<legend>Input SP2D</legend>
<br />
	<table width=auto>
		<tr>
			<td width="40%">Nomor SPM :</td>
			<td width="60%">
				<?php
					echo $no_spm;
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Nominal SPM :</td>
			<td width="60%">
				Rp. <?=number_format($total_spm,2,',','.');?>
			</td>
		</tr>
		<tr>
			<td width="40%">Nomor SP2D :</td>
			<td width="60%">
				<?php
				$data = array(
						  'name'        => 'nomor_sp2d',
						  'id'          => 'nomor_sp2d',
						  'size'        => '30'
						);
					echo form_input($data);
				?>
			</td>
		</tr>
		<tr>
			<td width="40%">Nominal :</td>
			<td width="60%">
				<?php
				$data = array(
						  'name'        => 'nominal_f',
						  'id'          => 'nominal_f',
						  'size'        => '30',
						  'onChange'    => 'format_nominal()',
						  'onFocus'     => 'unformat_nominal()'
						);
					echo form_input($data);
				?>
				<input type="hidden" name="nominal" id="nominal" />
				<input type="hidden" name="spm_hidden" id="spm_hidden" value="<?php echo $total_spm;?>"/>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="submit" onClick="save_data_sp2d(<?php echo $sp2d_id;?>);">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="reset();">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Reset
					</button>
				</div>
			</td>
		</tr>
	</table>
</fieldset>
<br />
<fieldset>
<legend>Daftar SP2D</legend>
<div align="center" id="daftar_sp2d">
</div>
</fieldset>

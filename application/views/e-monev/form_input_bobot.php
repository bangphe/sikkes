<table width=auto>
		<div>
		<?php echo  anchor(site_url('e-monev/laporan_monitoring/input_rencana/'.$d_skmpnen_id.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Rencana Fisik',array('onclick' => 'rencana_fisik('.$d_skmpnen_id.');;return false;')); ?>
		</div>
		<br />
		<tr>
			<td colspan="2"><center><b>Bobot</b></center></td>
		</tr>	
		<tr>
			<td><b>Persiapan (%)</b></td>
			<td>
				<div>
					<?php 
							$data1 = array(
										'name'        => 'persiapan',
										'id'          => 'persiapan',
										'value'       => $b_persiapan,
										'onChange'    => "validasi_persiapan()"
									);
							echo form_input($data1);
						?>		
				</div>
				<!--
				<div>
					Characters :  <p id="counter1"></p>
				</div>
				-->
			</td>
		</tr>
		<tr>
			<td><b>Pelaksanaan(%)</b></td>
			<td>
				<div>
					<?php 
							$data2 = array(
										'name'        => 'pelaksanaan',
										'id'          => 'pelaksanaan',
										'value'       => $b_pelaksanaan,
										'onChange'    => "validasi_pelaksanaan()"
									);
							echo form_input($data2);
						?>		
				</div>
				<!--
				<div>
					Characters :  <p id="counter2"></p>
				</div>
				-->
			</td>
		</tr>
		<tr>
			<td><b>Pembuatan Laporan (%)</b></td>
			<td>
				<div>
					<?php 
							$data3 = array(
										'name'        => 'pembuatan_laporan',
										'id'          => 'pembuatan_laporan',
										'value'       => $b_pembuatan_laporan,
										'onChange'    => "validasi_pembuatan()"
									);
							echo form_input($data3);
						?>		
				</div>
				<!--
				<div>
					Characters :  <p id="counter3"></p>
				</div>
				-->
			</td>
		</tr>
		<tr>
			<td><b>Dokumen(%)</b></td>
			<td>
				<div>
					<?php 
							$data4 = array(
										'name'        => 'dokumen_laporan',
										'id'          => 'dokumen_laporan',
										'value'       => $b_dokumen_laporan,
										'onChange'    => "validasi_dokumen()"
									);
							echo form_input($data4);
						?>		
				</div>
				<!--
				<div>
					Characters :  <p id="counter4"></p>
				</div>
				-->
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" onClick="save_data_bobot(<?php echo  $d_skmpnen_id;?>);">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="rencana_fisik(<?php echo  $d_skmpnen_id;?>);">
						<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>

<script type="text/javascript">	
function validasi_persiapan(){
	var text = $("#persiapan").val();
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$("#persiapan").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Bobot persiapan harus diisi.');
		}
	}else{
		if (text.indexOf(".") >= 0){
			var digit = text.split(".");
			if(digit[1].length > 2){
				var num = parseFloat(text);
				$("#persiapan").val(num.toFixed(2));
			}else{
				$("#persiapan").val(text);
			}
		}
	}	
}

function validasi_pelaksanaan(){
	var text = $("#pelaksanaan").val();
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$("#pelaksanaan").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Bobot pelaksanaan harus diisi.');
		}
	}else{
		if (text.indexOf(".") >= 0){
			var digit = text.split(".");
			if(digit[1].length > 2){
				var num = parseFloat(text);
				$("#pelaksanaan").val(num.toFixed(2));
			}else{
				$("#pelaksanaan").val(text);
			}
		}			
	}	
}

function validasi_pembuatan(){
	var text = $("#pembuatan_laporan").val();
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$("#pembuatan_laporan").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Bobot pembuatan laporan harus diisi.');
		}
	}else{
		if (text.indexOf(".") >= 0){
			var digit = text.split(".");
			if(digit[1].length > 2){
				var num = parseFloat(text);
				$("#pembuatan_laporan").val(num.toFixed(2));
			}else{
				$("#pembuatan_laporan").val(text);
			}
		}
	}	
}

function validasi_dokumen(){
	var text = $("#dokumen_laporan").val();
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$("#dokumen_laporan").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Bobot dokumen laporan harus diisi.');
		}
	}else{
		if (text.indexOf(".") >= 0){
			var digit = text.split(".");
			if(digit[1].length > 2){
				var num = parseFloat(text);
				$("#dokumen_laporan").val(num.toFixed(2));
			}else{
				$("#dokumen_laporan").val(text);
			}
		}
	}	
}
</script>
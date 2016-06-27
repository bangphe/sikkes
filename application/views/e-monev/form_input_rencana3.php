<script type="text/javascript">	
function validasi_rencana(n){
	var field_id = '#'+n;
	var text = $(field_id).val();
	var fisik = $(field_id+"_hidden").val();
	var bulan = $("#bulan_hidden").val();
	var numofchars = text.length;
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$(field_id).val(fisik);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Semua field harus diisi.');
		}
	}else{
		if(parseFloat(text) > 100){
			$(field_id).val(100);
			alert('Isian tidak boleh lebih dari 100.');
		}else if(parseFloat(text) < parseFloat(fisik)){
			if(bulan != 'Januari'){
				$(field_id).val(fisik);
				alert('Isian tidak boleh kurang dari bulan sebelumnya.');
			}
		}else{
			if (text.indexOf(".") >= 0){
				var digit = text.split(".");
				if(digit[1].length > 2){
					var num = parseFloat(text);
					$(field_id).val(num.toFixed(2));
				}else{
					$(field_id).val(text.substring(0, numofchars));
				}
			}
		}
	}
	
}
</script>
<table width=auto>
		<div>
		<?php echo  anchor(site_url('e-monev/laporan_monitoring/input_rencana/'.$d_skmpnen_id.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Rencana Fisik',array('onclick' => 'rencana_fisik('.$d_skmpnen_id.');;return false;')); ?>
		</div>
		<br />
		<tr>
			<td><b>Bulan</b></td>
			<td>
				<?php echo  $bulan;?>
			</td>
		</tr>
		<input type="hidden" name="bulan_hidden" id="bulan_hidden" value=<?php echo  $bulan; ?> />
		<input type="hidden" name="persiapan_hidden" id="persiapan_hidden" value=<?php echo  $persiapan_sebelum; ?> />
		<input type="hidden" name="pelaksanaan_hidden" id="pelaksanaan_hidden" value=<?php echo  $pelaksanaan_sebelum; ?> />
		<input type="hidden" name="pembuatan_laporan_hidden" id="pembuatan_laporan_hidden" value=<?php echo  $pembuatan_sebelum; ?> />
		<input type="hidden" name="dokumen_laporan_hidden" id="dokumen_laporan_hidden" value=<?php echo  $dokumen_sebelum; ?> />
		<tr>
			<td><b>Persiapan (%)</b></td>
			<td>
				<div>
					<?php 
							$data1 = array(
										'name'        => 'persiapan',
										'id'          => 'persiapan',
										'value'       => $persiapan,
										'onChange'    => "validasi_rencana('persiapan')"
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
										'value'       => $pelaksanaan,
										'onChange'    => "validasi_rencana('pelaksanaan')"
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
										'value'       => $pembuatan_laporan,
										'onChange'    => "validasi_rencana('pembuatan_laporan')"
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
										'value'       => $dokumen_laporan,
										'onChange'    => "validasi_rencana('dokumen_laporan')"
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
					<button type="submit" class="regular" name="save" onClick="save_data3(<?php echo  $d_skmpnen_id.','.$rencana_id;?>);">
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

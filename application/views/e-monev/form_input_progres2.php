<script type="text/javascript">	
function validasi_progres(n){
	var field_id = '#'+n;
	var text = $(field_id).val();
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$(field_id).val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}
	}else{
		if (text.indexOf(".") >= 0){
			var digit = text.split(".");
			if(digit[1].length > 2){
				var num = parseFloat(text);
				$(field_id).val(num.toFixed(2));
			}else{
				$(field_id).val(text);
			}
		}
		
	}
}
</script>
<table width=auto>
		<div>
		<?= anchor(site_url('e-monev/laporan_monitoring/input_progres_fisik/'.$d_skmpnen_id.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Progres Fisik',array('onclick' => 'daftar_progres('.$d_skmpnen_id.');;return false;')); ?>
		</div>
		<br />
		<tr>
			<td><b>Bulan</b></td>
			<td>
				<?php echo $bulan;?>
			</td>
		</tr>
		<tr>
			<td><b>Persiapan (%)</b></td>
			<td>
				<div>
					<?php 
							$data1 = array(
										'name'        => 'persiapan',
										'id'          => 'persiapan',
										'value'       => $persiapan,
										'onChange'    => "validasi_progres('persiapan')"
									);
							echo form_input($data1);
						?>		
				</div>
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
										'onChange'    => "validasi_progres('pelaksanaan')"
									);
							echo form_input($data2);
						?>		
				</div>
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
										'onChange'    => "validasi_progres('pembuatan_laporan')"
									);
							echo form_input($data3);
						?>		
				</div>
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
										'onChange'    => "validasi_progres('dokumen_laporan')"
									);
							echo form_input($data4);
						?>		
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" onClick="save_data(<?php echo $d_skmpnen_id.','.$progres_id;?>);">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="daftar_progres(<?php echo $d_skmpnen_id;?>);">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>

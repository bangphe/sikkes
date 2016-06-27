<?php echo  form_open_multipart('e-monev/laporan_monitoring/save_progres/'.$d_skmpnen_id.'/'.$progres_id); ?>
<table class="tablecloth" width=auto>
		<div>
		<?php echo  anchor(site_url('e-monev/laporan_monitoring/input_progres_fisik/'.$d_skmpnen_id.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Progres',array('onclick' => 'daftar_progres('.$d_skmpnen_id.');;return false;')); ?>
		</div>
		<br />
		<tr>
			<td><b>Bulan</b></td>
			<td>
				<?php echo  $bulan;?>
			</td>
		</tr>
		<tr>
			<td><b>Fisik (%)</b></td>
			<td>
				<div>
					<?php 
						$data = array(
										'name'        => 'fisik',
										'id'          => 'fisik',
										'value'       => $fisik,
										'onChange'    => 'validasi_angka()'
									);
							echo form_input($data);
					echo form_hidden('d_skmpnen_id',$d_skmpnen_id);
						?>
				</div>
				<div>
					Characters :  <p id="counter2"></p>
				</div>
			</td>
		</tr>
		<tr>
			<td><b>File Bukti Fisik</b></td>
			<td>
				<div>
					<input id="file" name="file" type="file" size="20"/>	
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div>
					<input id="submit-button" type="submit" name="daftar_warna" value="Save" />
					<input id="submit-button" type="button" name="batal" value="Cancel" onClick="daftar_progres(<?php echo  $d_skmpnen_id;?>);;return false;"/>
				</div>
			</td>
		</tr>
	</table>
<?php echo  form_close();?>
<script type="text/javascript">	
/*
$(document).ready(function()
{
    var max_length = 3;
    //run listen key press
    whenkeydown(max_length);
});
*/

function validasi_angka(){
	var text = $("#fisik").val();
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$("#fisik").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Progres Fisik harus diisi.');
		}
	}else{
		if (text.indexOf(".") >= 0){
			var digit = text.split(".");
			if(digit[1].length > 2){
				var num = parseFloat(text);
				$("#fisik").val(num.toFixed(2));
			}else{
				$("#fisik").val(text);
			}
		}
		
	}
	
}
</script>
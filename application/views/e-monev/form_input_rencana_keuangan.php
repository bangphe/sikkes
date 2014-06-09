<script type="text/javascript">	
$(document).ready(function()
{
    //var max_length = 3;
    //run listen key press
    //whenkeydown2(max_length);
});

function whenkeydown2(max_length)
{
    $("#keuangan").unbind().keyup(function()
    {
        //check if the appropriate text area is being typed into
        if(document.activeElement.id === "keuangan")
        {
            //get the data in the field
            var text = $(this).val();
 
            //set number of characters
            var numofchars = text.length;
 
            if(numofchars <= max_length)
            {
                //set the length of the text into the counter span
                $("#counter2").html(text.length);
            }
            else
            {
                //make sure string gets trimmed to max character length
                $(this).val(text.substring(0, max_length));
            }
        }
    });
}

function validasi_rencana(){
	var keuangan = $("#keuangan_f").val();
	var keuangan_sebelum = $("#keuangan_hidden").val();
	var alokasi = $("#alokasi_hidden").val();
	var bulan = $("#bulan_hidden").val();
	
	if($.isNumeric(keuangan) == false){
		if(keuangan != ''){
			$("#keuangan_f").val(accounting.formatMoney(keuangan_sebelum,'Rp ',2,'.',','));
			$("#keuangan_rp").val(keuangan_sebelum);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Rencana Keuangan (Rp) harus diisi.');
		}
	}else{
		if(parseFloat(keuangan) > parseFloat(alokasi)){
			$("#keuangan_f").val(accounting.formatMoney(alokasi,'Rp ',2,'.',','));
			$("#keuangan_rp").val(alokasi);
			alert('Isian tidak boleh lebih dari 100%.');
		}else if(parseFloat(keuangan) < parseFloat(keuangan_sebelum)){
			if(bulan != 'Januari'){
				$("#keuangan_f").val(accounting.formatMoney(keuangan_sebelum,'Rp ',2,'.',','));
				$("#keuangan_rp").val(keuangan_sebelum);
				alert('Isian tidak boleh kurang dari bulan sebelumnya.');
			}
		}else{
			/*
			if (keuangan.indexOf(".") >= 0){
				var digit = keuangan.split(".");
				if(digit[1].length > 2){
					var num = parseFloat(keuangan);
					$("#keuangan_f").val(num.toFixed(2));
				}else{
					$("#keuangan_f").val(keuangan);
				}
			}*/
			$("#keuangan_f").val(accounting.formatMoney(keuangan,'Rp ',2,'.',','));
			$("#keuangan_rp").val(keuangan);
		}
	}
	
}
function unformat_angka(){
	var keuangan = $("#keuangan_f").val();
	$("#keuangan_f").val(accounting.unformat(keuangan,','));
}
</script>
<table width=auto>
		<div>
		<?= anchor(site_url('e-monev/laporan_monitoring/input_rencana/'.$d_skmpnen_id.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Rencana',array('onclick' => 'daftar_rencana('.$d_skmpnen_id.');;return false;')); ?>
		</div>
		<br />
		<tr>
			<td><b>Bulan</b></td>
			<td>
				<?php echo $bulan;?>
			</td>
		</tr>
		<tr>
			<td><b>Rencana Keuangan (Rp)</b></td>
			<td>
				<div>
					<?php 
							$data = array(
										'name'        => 'keuangan_f',
										'id'          => 'keuangan_f',
										'value'       => 'Rp '.number_format($keuangan_rp,2,',','.'),
										'onChange'    => 'validasi_rencana()',
										'onFocus'     => 'unformat_angka()'
									);
							echo form_input($data);
						?>	
					<input type="hidden" name="keuangan_rp" id="keuangan_rp" value=<?php echo $keuangan_rp; ?> />	
					<input type="hidden" name="bulan_hidden" id="bulan_hidden" value=<?php echo $bulan; ?> />
					<input type="hidden" name="keuangan_hidden" id="keuangan_hidden" value=<?php echo $keuangan_sebelum; ?> />
					<input type="hidden" name="alokasi_hidden" id="alokasi_hidden" value=<?php echo $alokasi; ?> />
				</div>
				<!--
				<div>
					Characters :  <p id="counter2"></p>
				</div>
				-->
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" onClick="save_rencana_keuangan(<?php echo $d_skmpnen_id.','.$rencana_id;?>);">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="daftar_rencana(<?php echo $d_skmpnen_id;?>);">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>

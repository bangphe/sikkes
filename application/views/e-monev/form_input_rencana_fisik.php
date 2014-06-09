<script type="text/javascript">	
/*
$(document).ready(function()
{
    var max_length = 3;
    //run listen key press
    whenkeydown(max_length);
});
*/

function validasi_rencana(){
	var text = $("#fisik").val();
	var fisik = $("#fisik_hidden").val();
	var bulan = $("#bulan_hidden").val();
	var numofchars = text.length;
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$("#fisik").val(fisik);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Target Fisik harus diisi.');
		}
	}else{
		if(parseFloat(text) > 100){
			$("#fisik").val(100);
			alert('Isian tidak boleh lebih dari 100.');
		}else if(parseFloat(text) < parseFloat(fisik)){
			if(bulan != 'Januari'){
				$("#fisik").val(fisik);
				alert('Isian tidak boleh kurang dari bulan sebelumnya.');
			}
		}else{
			if (text.indexOf(".") >= 0){
				var digit = text.split(".");
				if(digit[1].length > 2){
					var num = parseFloat(text);
					$("#fisik").val(num.toFixed(2));
				}else{
					$("#fisik").val(text.substring(0, numofchars));
				}
			}
		}
	}
	
}
 
function whenkeydown(max_length)
{
    $("#fisik").unbind().keyup(function()
    {
        //check if the appropriate text area is being typed into
        if(document.activeElement.id === "fisik")
        {
            //get the data in the field
            var text = $(this).val();
 
            //set number of characters
            var numofchars = text.length;
 
            if(numofchars <= max_length)
            {
                //set the length of the text into the counter span
                $("#counter").html(text.length);
            }
            else
            {
                //make sure string gets trimmed to max character length
                $(this).val(text.substring(0, max_length));
            }
        }
    });
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
			<td><b>Target Fisik (%)</b></td>
			<td>
				<div>
					<?php 
							$data = array(
										'name'        => 'fisik',
										'id'          => 'fisik',
										'value'       => $fisik,
										'onChange'    => 'validasi_rencana()'
									);
							echo form_input($data);
						?>
					<input type="hidden" name="bulan_hidden" id="bulan_hidden" value=<?php echo $bulan; ?> />
					<input type="hidden" name="fisik_hidden" id="fisik_hidden" value=<?php echo $fisik_sebelum; ?> />						
				</div>
				<!--
				<div>
					Characters :  <p id="counter"></p>
				</div>
				-->
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" onClick="save_rencana_fisik(<?php echo $d_skmpnen_id.','.$rencana_id;?>);">
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

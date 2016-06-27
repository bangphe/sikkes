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
	var text = $("#rencana_swakelola").val();
	var rencana_swakelola = $("#rencana_swakelola_hidden").val();
	var bulan = $("#bulan_hidden").val();
	var numofchars = text.length;
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$("#rencana_swakelola").val(rencana_swakelola);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Target Swakelola harus diisi.');
		}
	}else{
		if(parseFloat(text) > 100){
			$("#rencana_swakelola").val(100);
			alert('Isian tidak boleh lebih dari 100.');
		}else if(parseFloat(text) < parseFloat(rencana_swakelola)){
			if(bulan != 'Januari'){
				$("#rencana_swakelola").val(rencana_swakelola);
				alert('Isian tidak boleh kurang dari bulan sebelumnya.');
			}
		}else{
			if (text.indexOf(".") >= 0){
				var digit = text.split(".");
				if(digit[1].length > 2){
					var num = parseFloat(text);
					$("#rencana_swakelola").val(num.toFixed(2));
				}else{
					$("#rencana_swakelola").val(text.substring(0, numofchars));
				}
			}
		}
	}
	
}
 
function whenkeydown(max_length)
{
    $("#rencana_swakelola").unbind().keyup(function()
    {
        //check if the appropriate text area is being typed into
        if(document.activeElement.id === "rencana_swakelola")
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
		<tr>
			<td><b>Bulan</b></td>
			<td>
				<?php echo  $bulan;?>
			</td>
		</tr>
		<tr>
			<td><b>Target Swakelola (%)</b></td>
			<td>
				<div>
					<?php 
							$data = array(
										'name'        => 'rencana_swakelola',
										'id'          => 'rencana_swakelola',
										'value'       => $rencana_swakelola,
										'onChange'    => 'validasi_rencana()'
									);
							echo form_input($data);
						?>
					<input type="hidden" name="bulan_hidden" id="bulan_hidden" value=<?php echo  $bulan; ?> />
					<input type="hidden" name="rencana_swakelola_hidden" id="rencana_swakelola_hidden" value=<?php echo  $rencana_swakelola_sebelum; ?> />						
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
					<button type="submit" class="regular" name="save" onClick="save_rencana_swakelola(<?php echo  $rencana_id.','.$idpaket;?>);">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="daftar_rencana(); return false;">
						<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>

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
	var text = $("#progress").val();
	
	if($.isNumeric(text) == false){
		if(text != ''){
			$("#progress").val(0);
			alert('Isian harus berupa angka.\nDesimal menggunakan titik(.).');
		}else{
			alert('Progres Fisik harus diisi.');
		}
	}else{
		if (text.indexOf(".") >= 0){
			var digit = text.split(".");
			if(digit[1].length > 2){
				var num = parseFloat(text);
				$("#progress").val(num.toFixed(2));
			}else{
				$("#progress").val(text);
			}
		}
		
	}	
}

function whenkeydown(max_length)
{
    $("#progress").unbind().keyup(function()
    {
        //check if the appropriate text area is being typed into
        if(document.activeElement.id === "progress")
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

<?php echo  form_open_multipart('e-monev/laporan_monitoring/save_progress_swakelola/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput.'/'.$kdkmpnen.'/'.$kdskmpnen.'/'.$progress_id.'/'.$idpaket); ?>
<table class="tablecloth" width="50%">
		<tr>
			<td><b>Bulan</b></td>
			<td>
				<?php echo  $bulan;?>
			</td>
		</tr>
		<tr>
			<td><b>Progress Fisik (%)</b></td>
			<td>
				<div>
					<?php 
						$data = array(
										'name'        => 'progress',
										'id'          => 'progress',
										'value'       => $progress,
										'onChange'    => 'validasi_angka()'
									);
							echo form_input($data);
					?>
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
					<input id="submit-button" type="submit" name="submit" value="Save" />
					<input id="submit-button" type="button" name="batal" value="Cancel" onClick="daftar_progress_swakelola(); return false;"/>
				</div>
			</td>
		</tr>
	</table>
<?php echo  form_close();?>
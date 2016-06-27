<script type="text/javascript">	
$(document).ready(function()
{
    var max_length = 3;
    //run listen key press
    whenkeydown2(max_length);
});

function whenkeydown2(max_length)
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
</script>
<?php echo  form_open_multipart('e-monev/master_bank/save_progres/1'); ?>
<table class="tablecloth" width=auto>
		
		<br />
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
					<input id="submit-button" type="button" name="batal" value="Cancel" />
				</div>
			</td>
		</tr>
	</table>
<?php echo  form_close();?>

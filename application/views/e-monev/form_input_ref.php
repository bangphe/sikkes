<script type="text/javascript">	
$(document).ready(function()
{
    var max_length = 2;
    //run listen key press
    whenkeydown(max_length);
});
 
function whenkeydown(max_length)
{
    $("#tanggal").unbind().keyup(function()
    {
        //check if the appropriate text area is being typed into
        if(document.activeElement.id === "tanggal")
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
		<br />
		<div>
		<?= anchor(site_url('e-monev/laporan_monitoring/input_masalah/'.$referensi_id.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Referensi',array('onclick' => 'daftar_referensi();;return false;')); ?>
		</div>
		<br />
		<tr>
			<td><b>Tanggal</b></td>
			<td>
				<div>
					<?php 
							$data = array(
										'name'        => 'tanggal',
										'id'          => 'tanggal',
										'value'       => $tanggal
									);
							echo form_input($data);
						?>		
				</div>
				<div>
					Characters :  <p id="counter"></p>
				</div>
				
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" onClick="save_data(<?php echo $referensi_id;?>);">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="daftar_referensi();">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>

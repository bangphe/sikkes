<script type="text/javascript">	
    $(document).ready(function()
    {
        var max_length = 100;
        //run listen key press
        whenkeydown(max_length);
        whenkeydown3(max_length);
    });
 
    function whenkeydown(max_length)
    {
        $("#permasalahan").unbind().keyup(function()
        {
            //check if the appropriate text area is being typed into
            if(document.activeElement.id === "permasalahan")
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

    function whenkeydown3(max_length)
    {
        $("#ket_pihak_terkait").unbind().keyup(function()
        {
            //check if the appropriate text area is being typed into
            if(document.activeElement.id === "ket_pihak_terkait")
            {
                //get the data in the field
                var text = $(this).val();
 
                //set number of characters
                var numofchars = text.length;
 
                if(numofchars <= max_length)
                {
                    //set the length of the text into the counter span
                    $("#counter3").html(text.length);
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
        <td><b>Status</b></td>
        <td>
            <?php
            echo form_dropdown('status', $status, 0, 'id="status"');
            ?>
        </td>
        
        <td><b>Pihak Terkait</b></td>
        <td>
            <?php
            echo form_dropdown('pihak_terkait', $pihak_terkait, 0, 'id="pihak_terkait"');
            ?>
        </td>
    </tr>
    <tr>
        <td><b>Permasalahan</b></td>
        <td>
            <div>
                <?php
                $data = array(
                    'name' => 'permasalahan',
                    'id' => 'permasalahan',
                    'cols' => '40',
                    'rows' => '5'
                );
                echo form_textarea($data);
                ?>		
            </div>
            <div>
                Characters :  <span id="counter"></span>
            </div>

        </td>
        <td><b>Keterangan Pihak Terkait</b></td>
        <td>
            <div>
                <?php
                $data = array(
                    'name' => 'ket_pihak_terkait',
                    'id' => 'ket_pihak_terkait',
                    'cols' => '40',
                    'rows' => '5'
                );
                echo form_textarea($data);
                ?>		
            </div>
            <div>
                Characters :  <span id="counter3"></span>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <div class="buttons">
                <button type="submit" class="regular" name="save" onClick="save_data(<?php echo  $d_skmpnen_id.','.$idbulan;?>);">
                    <img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
                    Save
                </button>
                <button type="reset" class="negative" name="reset" onClick="reset(0);">
                    <img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
                    Reset
                </button>
            </div>
        </td>
    </tr>
</table>

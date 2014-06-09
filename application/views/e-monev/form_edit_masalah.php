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
        $("#edit_permasalahan").unbind().keyup(function()
        {
            //check if the appropriate text area is being typed into
            if(document.activeElement.id === "edit_permasalahan")
            {
                //get the data in the field
                var text = $(this).val();
 
                //set number of characters
                var numofchars = text.length;
 
                if(numofchars <= max_length)
                {
                    //set the length of the text into the counter span
                    $("#counter_edit").html(text.length);
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
        $("#edit_ket_pihak_terkait").unbind().keyup(function()
        {
            //check if the appropriate text area is being typed into
            if(document.activeElement.id === "edit_ket_pihak_terkait")
            {
                //get the data in the field
                var text = $(this).val();
 
                //set number of characters
                var numofchars = text.length;
 
                if(numofchars <= max_length)
                {
                    //set the length of the text into the counter span
                    $("#counter_edit3").html(text.length);
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
            echo form_dropdown('edit_status', $status, 0, 'id="edit_status"');
            ?>
        </td>
        
        <td><b>Pihak Terkait</b></td>
        <td>
            <?php
            echo form_dropdown('edit_pihak_terkait', $pihak_terkait, 0, 'id="edit_pihak_terkait"');
            ?>
        </td>
    </tr>
    <tr>
        <td><b>Permasalahan</b></td>
        <td>
            <div>
                <?php
                $data = array(
                    'name' => 'edit_permasalahan',
                    'id' => 'edit_permasalahan',
                    'cols' => '40',
                    'rows' => '5'
                );
                echo form_textarea($data);
                ?>		
            </div>
            <div>
                Characters :  <span id="counter_edit"></span>
            </div>

        </td>
        <td><b>Keterangan Pihak Terkait</b></td>
        <td>
            <div>
                <?php
                $data = array(
                    'name' => 'edit_ket_pihak_terkait',
                    'id' => 'edit_ket_pihak_terkait',
                    'cols' => '40',
                    'rows' => '5'
                );
                echo form_textarea($data);
                ?>		
            </div>
            <div>
                Characters :  <span id="counter_edit3"></span>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <div class="buttons">
                <input type="hidden" name="id_skmpnen" id="id_skmpnen" value=""/>
                <input type="hidden" name="bulan" id="bulan" value=""/>
                <input type="hidden" name="id_permasalahan" id="id_permasalahan" value=""/>
                <button type="submit" class="regular" name="save" onClick="edit_data();">
                    <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                    Save
                </button>
                <button type="reset" class="negative" name="reset" onClick="reset(1);">
                    <img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
                    Reset
                </button>
            </div>
        </td>
    </tr>
</table>

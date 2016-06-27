
<table width=auto>
    <tr>
        <td><b>Permasalahan</b></td>
        <td>
            <div>
                <?php
                $data = array(
                    'name' => 'edit_detail_penyelesaian',
                    'id' => 'edit_detail_penyelesaian',
                    'cols' => '60',
                    'rows' => '5'
                );
                echo form_textarea($data);
                ?>		
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <div class="buttons">
                <input type="hidden" name="id_upaya_penyelesaian" id="id_upaya_penyelesaian" value=""/>
                <input type="hidden" name="id_permasalahan" id="id_permasalahan" value=""/>
                <button type="submit" class="regular" name="save" onClick="update_upaya();">
                    <img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
                    Save
                </button>
                <button type="reset" class="negative" name="reset" onClick="reset_upaya(1);">
                    <img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
                    Reset
                </button>
            </div>
        </td>
    </tr>
</table>

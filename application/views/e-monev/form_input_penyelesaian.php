
<table width=auto>
    <tr>
        <td><b>Permasalahan</b></td>
        <td>
            <div>
                <?php
                $data = array(
                    'name' => 'detail_penyelesaian',
                    'id' => 'detail_penyelesaian',
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
                <button type="submit" class="regular" name="save" onClick="save_upaya(<?php echo $data_masalah->permasalahan_id;?>);">
                    <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                    Save
                </button>
                <button type="reset" class="negative" name="reset" onClick="reset_upaya(0);">
                    <img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
                    Reset
                </button>
            </div>
        </td>
    </tr>
</table>

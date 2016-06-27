
<table width=auto>
    <tr>
        <td><b>Feedback</b></td>
        <td>
            <div>
                <?php
                $data = array(
                    'name' => 'detail_feedback',
                    'id' => 'detail_feedback',
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
                <button type="submit" class="regular" name="save" onClick="save(<?php echo  $data_masalah->permasalahan_id;?>);">
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

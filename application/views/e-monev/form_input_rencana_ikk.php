<div>
    <?= anchor(site_url('e-monev/laporan_kinerja/'), img(array('src' => 'images/flexigrid/prev.gif', 'border' => '0', 'alt' => '')) . 'Kembali Ke Laporan Kinerja'); ?>
</div>
<br />
<?php
echo form_open($post_action);
?>
<table width=auto>
    <tr>
        <td width="15%"><b>Kode</b></td>
        <td>
            <?php echo $ikk[0]->KodeIkk; ?>
        </td>
    </tr>    
    <tr>
        <td><b>Nama IKK </b></td>
        <td>
            <?php echo $ikk[0]->Ikk; ?>
        </td>
    </tr>
    <tr>
        <td width="15%" height="10px" colspan="2"></td>
    </tr>
    <tr>
        <td width="15%" colspan="2"><b>Rencana per bulan</b></td>
    </tr>
    <?php foreach ($bulan as $id => $val): ?>
        <tr>
            <td align="right"><b><?php echo $val; ?></b>&nbsp;&nbsp;</td>
            <td>
                <?php $str = "bulan_$id"; if (isset($rencana[0]) && $rencana[0]->$str != NULL): ?>
                <input type="text" id="<?php echo "bulan_$id"; ?>" name="<?php echo "bulan_$id"; ?>" value="<?php echo $rencana[0]->$str;?>" onChange="set_rencana(<?php echo $id; ?>)"/>
                <?php else :?>
                <input type="text" id="<?php echo "bulan_$id"; ?>"name="<?php echo "bulan_$id"; ?>" value="<?php echo set_value("bulan_$id"); ?>" onChange="set_rencana(<?php echo $id; ?>)" />
                <?php endif; echo form_error("bulan_$id"); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td>
            <div class="buttons">
                <button type="submit" class="regular" name="save" id="submit">
                    <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                    Save
                </button>
                <button type="reset" class="negative" name="reset">
                    <img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
                    Cancel
                </button>
            </div>
        </td>
    </tr>
</table>
<?php
echo form_close();
?>
<script>
	function set_rencana(bulan){
		//var rencana = document.getElementsByName("bulan_"+bulan);
		var rencana = parseInt($('#bulan_'+bulan).val());
		var nol = 0;
		
		/*if(rencana == 0){
			var bulan_sebelum = parseInt($('#bulan_'+(bulan-1)).val());
			alert("Inputan harus lebih dari 0");
				$('#bulan_'+i).val(null);
		}
		else{
			if(bulan != 1){
				var bulan_sebelum = parseInt($('#bulan_'+(bulan-1)).val());
				if(rencana<bulan_sebelum){
					alert("Rencana bulan ini tidak boleh lebih kecil dari bulan sebelumnya");
					for(var i=bulan; i<= 12;i++){
						$('#bulan_'+i).val(bulan_sebelum);
					}
				}else{
					for(var i=bulan; i<= 12;i++){
						$('#bulan_'+(i+1)).val(rencana);
					}
				}
			}else{
				for(var i=bulan; i<= 12;i++){
					$('#bulan_'+(i+1)).val(rencana);
				}
			}
		}*/
		
		var bulan_sebelum = parseInt($('#bulan_'+(bulan-1)).val());
		
		if(rencana<bulan_sebelum){
			alert("Rencana bulan ini tidak boleh lebih kecil dari bulan sebelumnya");
			for(var i=bulan; i<= 12;i++){
				$('#bulan_'+i).val(bulan_sebelum);
			}
		}else{
			for(var i=bulan; i<= 12;i++){
				$('#bulan_'+(i+1)).val(rencana);
			}
		}
	}
</script>